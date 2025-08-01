<?php
/**
 * Primary class file for the Jetpack Protect plugin.
 *
 * @package automattic/jetpack-protect-plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

use Automattic\Jetpack\Account_Protection\Settings as Account_Protection_Settings;
use Automattic\Jetpack\Admin_UI\Admin_Menu;
use Automattic\Jetpack\Assets;
use Automattic\Jetpack\Connection\Initial_State as Connection_Initial_State;
use Automattic\Jetpack\Connection\Manager as Connection_Manager;
use Automattic\Jetpack\IP\Utils as IP_Utils;
use Automattic\Jetpack\JITMS\JITM;
use Automattic\Jetpack\Modules;
use Automattic\Jetpack\My_Jetpack\Initializer as My_Jetpack_Initializer;
use Automattic\Jetpack\My_Jetpack\Products as My_Jetpack_Products;
use Automattic\Jetpack\Plugins_Installer;
use Automattic\Jetpack\Protect\Credentials;
use Automattic\Jetpack\Protect\Onboarding;
use Automattic\Jetpack\Protect\REST_Controller;
use Automattic\Jetpack\Protect\Scan_History;
use Automattic\Jetpack\Protect\Site_Health;
use Automattic\Jetpack\Protect\Threats;
use Automattic\Jetpack\Protect_Status\Plan;
use Automattic\Jetpack\Protect_Status\Protect_Status;
use Automattic\Jetpack\Protect_Status\Scan_Status;
use Automattic\Jetpack\Protect_Status\Status;
use Automattic\Jetpack\Status as Jetpack_Status;
use Automattic\Jetpack\Sync\Functions as Sync_Functions;
use Automattic\Jetpack\Sync\Sender;
use Automattic\Jetpack\Waf\Waf_Runner;
use Automattic\Jetpack\Waf\Waf_Stats;

/**
 * Class Jetpack_Protect
 *
 * @phan-constructor-used-for-side-effects
 */
class Jetpack_Protect {

	const JETPACK_SCAN_PRODUCT_IDS                   = array(
		2010, // JETPACK_SECURITY_DAILY.
		2011, // JETPACK_SECURITY_DAILY_MOTNHLY.
		2012, // JETPACK_SECURITY_REALTIME.
		2013, // JETPACK_SECURITY_REALTIME_MONTHLY.
		2014, // JETPACK_COMPLETE.
		2015, // JETPACK_COMPLETE_MONTHLY.
		2016, // JETPACK_SECURITY_TIER_1_YEARLY.
		2017, // JETPACK_SECURITY_TIER_1_MONTHLY.
		2019, // JETPACK_SECURITY_TIER_2_YEARLY.
		2020, // JETPACK_SECURITY_TIER_2_MONTHLY.
		2106, // JETPACK_SCAN.
		2107, // JETPACK_SCAN_MONTHLY.
		2108, // JETPACK_SCAN_REALTIME.
		2109, // JETPACK_SCAN_REALTIME_MONTHLY.
	);
	const JETPACK_WAF_MODULE_SLUG                    = 'waf';
	const JETPACK_BRUTE_FORCE_PROTECTION_MODULE_SLUG = 'protect';
	const JETPACK_ACCOUNT_PROTECTION_MODULE_SLUG     = 'account-protection';
	const JETPACK_PROTECT_ACTIVATION_OPTION          = JETPACK_PROTECT_SLUG . '_activated';

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( '_admin_menu', array( $this, 'admin_page_init' ) );

		// Activate the module as the plugin is activated
		add_action( 'admin_init', array( $this, 'do_plugin_activation_activities' ) );

		// Init Jetpack packages
		add_action(
			'plugins_loaded',
			function () {
				$config = new Automattic\Jetpack\Config();
				// Connection package.
				$config->ensure(
					'connection',
					array(
						'slug'     => JETPACK_PROTECT_SLUG,
						'name'     => JETPACK_PROTECT_NAME,
						'url_info' => JETPACK_PROTECT_URI,
					)
				);
				// Sync package.
				$config->ensure(
					'sync',
					array(
						'jetpack_sync_modules'             => array(
							'Automattic\\Jetpack\\Sync\\Modules\\Options',
							'Automattic\\Jetpack\\Sync\\Modules\\Callables',
							'Automattic\\Jetpack\\Sync\\Modules\\Users',
						),
						'jetpack_sync_callable_whitelist'  => array(
							'main_network_site' => array( 'Automattic\\Jetpack\\Connection\\Urls', 'main_network_site_url' ),
							'get_plugins'       => array( 'Automattic\\Jetpack\\Sync\\Functions', 'get_plugins' ),
							'get_themes'        => array( 'Automattic\\Jetpack\\Sync\\Functions', 'get_themes' ),
							'wp_version'        => array( 'Automattic\\Jetpack\\Sync\\Functions', 'wp_version' ),
						),
						'jetpack_sync_options_contentless' => array(),
						'jetpack_sync_options_whitelist'   => array(
							'active_plugins',
							'stylesheet',
						),
					)
				);

				// Identity crisis package.
				$config->ensure( 'identity_crisis' );

				// Web application firewall package.
				$config->ensure( 'waf' );

				// Account protection package.
				$config->ensure( 'account_protection' );
			},
			1
		);

		add_filter( 'jetpack_connection_user_has_license', array( $this, 'jetpack_check_user_licenses' ), 10, 3 );

		add_filter( 'jetpack_get_available_standalone_modules', array( $this, 'protect_filter_available_modules' ), 10, 1 );
	}

	/**
	 * Initialize the plugin
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'admin_bar_menu', array( $this, 'admin_bar' ), 65 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );

		REST_Controller::init();
		My_Jetpack_Initializer::init();
		Site_Health::init();

		// Sets up JITMS.
		JITM::configure();
	}

	/**
	 * Initialize the admin page resources.
	 */
	public function admin_page_init() {
		$total_threats = Status::get_total_threats();
		$menu_label    = _x( 'Protect', 'The Jetpack Protect product name, without the Jetpack prefix', 'jetpack-protect' );
		if ( $total_threats ) {
			$menu_label .= sprintf( ' <span class="update-plugins">%d</span>', $total_threats );
		}

		$page_suffix = Admin_Menu::add_menu(
			__( 'Jetpack Protect', 'jetpack-protect' ),
			$menu_label,
			'manage_options',
			'jetpack-protect',
			array( $this, 'plugin_settings_page' ),
			5
		);

		add_action( 'load-' . $page_suffix, array( $this, 'enqueue_admin_scripts' ) );
	}

	/**
	 * Enqueues the wp-admin styles (used outside the React app)
	 */
	public function enqueue_admin_styles() {
		wp_enqueue_style( 'jetpack-protect-wpadmin', JETPACK_PROTECT_BASE_PLUGIN_URL . '/assets/jetpack-protect.css', array(), JETPACK_PROTECT_VERSION );
	}

	/**
	 * Enqueue plugin admin scripts and styles.
	 */
	public function enqueue_admin_scripts() {

		Assets::register_script(
			'jetpack-protect',
			'build/index.js',
			JETPACK_PROTECT_ROOT_FILE,
			array(
				'in_footer'  => true,
				'textdomain' => 'jetpack-protect',
			)
		);
		Assets::enqueue_script( 'jetpack-protect' );
		// Required for Analytics.
		wp_enqueue_script( 'jp-tracks', '//stats.wp.com/w.js', array(), gmdate( 'YW' ), true );
		// Initial JS state including JP Connection data.
		Connection_Initial_State::render_script( 'jetpack-protect' );
		wp_add_inline_script( 'jetpack-protect', $this->render_initial_state(), 'before' );
	}

	/**
	 * Render the initial state into a JavaScript variable.
	 *
	 * @return string
	 */
	public function render_initial_state() {
		return 'var jetpackProtectInitialState=JSON.parse(decodeURIComponent("' . rawurlencode( wp_json_encode( $this->initial_state() ) ) . '"));';
	}

	/**
	 * Get the initial state data for hydrating the React UI.
	 *
	 * @return array
	 */
	public function initial_state() {
		global $wp_version;

		// Always fetch the latest plan status from WPCOM.
		$has_plan = Plan::has_required_plan( true );

		$status = Status::get_status();

		$initial_state = array(
			'apiRoot'            => esc_url_raw( rest_url() ),
			'apiNonce'           => wp_create_nonce( 'wp_rest' ),
			'registrationNonce'  => wp_create_nonce( 'jetpack-registration-nonce' ),
			'credentials'        => Credentials::get_credential_array(),
			'status'             => $status,
			'fixerStatus'        => Threats::fix_threats_status( $status->fixable_threat_ids ),
			'scanHistory'        => Scan_History::get_scan_history(),
			'installedPlugins'   => Plugins_Installer::get_plugins(),
			'installedThemes'    => Sync_Functions::get_themes(),
			'wpVersion'          => $wp_version,
			'adminUrl'           => 'admin.php?page=jetpack-protect',
			'siteSuffix'         => ( new Jetpack_Status() )->get_site_suffix(),
			'blogID'             => Connection_Manager::get_site_id( true ),
			'jetpackScan'        => My_Jetpack_Products::get_product( 'scan' ),
			'hasPlan'            => $has_plan,
			'onboardingProgress' => Onboarding::get_current_user_progress(),
			'accountProtection'  => ( new Account_Protection_Settings() )->get(),
			'waf'                => array(
				'wafSupported'        => Waf_Runner::is_supported_environment(),
				'currentIp'           => IP_Utils::get_ip(),
				'upgradeIsSeen'       => self::get_waf_upgrade_seen_status(),
				'displayUpgradeBadge' => self::get_waf_upgrade_badge_display_status(),
				'isEnabled'           => Waf_Runner::is_enabled(),
				'config'              => Waf_Runner::get_config(),
				'stats'               => self::get_waf_stats(),
				'globalStats'         => Waf_Stats::get_global_stats(),
			),
		);

		$initial_state['jetpackScan']['pricingForUi'] = Plan::get_product( 'jetpack_scan' );

		return $initial_state;
	}
	/**
	 * Main plugin settings page.
	 */
	public function plugin_settings_page() {
		?>
			<div id="jetpack-protect-root"></div>
		<?php
	}

	/**
	 * Activate the WAF module on plugin activation.
	 *
	 * @static
	 */
	public static function plugin_activation() {
		add_option( self::JETPACK_PROTECT_ACTIVATION_OPTION, true );
	}

	/**
	 * Runs on admin_init, and does actions required on plugin activation, based on
	 * the activation option.
	 *
	 * This needs to be run after the activation hook, as that results in a redirect,
	 * and we need the sync module's actions and filters to be registered.
	 */
	public static function do_plugin_activation_activities() {
		if ( get_option( self::JETPACK_PROTECT_ACTIVATION_OPTION ) && ( new Connection_Manager() )->is_connected() ) {
			self::activate_modules();
		}
	}

	/**
	 * Activates the waf and brute force protection modules and disables the activation option
	 */
	public static function activate_modules() {
		delete_option( self::JETPACK_PROTECT_ACTIVATION_OPTION );
		( new Modules() )->activate( self::JETPACK_ACCOUNT_PROTECTION_MODULE_SLUG, false, false );
		( new Modules() )->activate( self::JETPACK_WAF_MODULE_SLUG, false, false );
		( new Modules() )->activate( self::JETPACK_BRUTE_FORCE_PROTECTION_MODULE_SLUG, false, false );
	}

	/**
	 * Removes plugin from the connection manager
	 * If it's the last plugin using the connection, the site will be disconnected.
	 *
	 * @access public
	 * @static
	 */
	public static function plugin_deactivation() {

		// Clear Sync data.
		Sender::get_instance()->uninstall();

		$manager = new Connection_Manager( 'jetpack-protect' );
		$manager->remove_connection();

		Protect_Status::delete_option();
		Scan_Status::delete_option();
		Scan_History::delete_option();
	}

	/**
	 * Create a shortcut on Admin Bar to show the total of threats found.
	 *
	 * @param object $wp_admin_bar The Admin Bar object.
	 * @return void
	 */
	public function admin_bar( $wp_admin_bar ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$total = Status::get_total_threats();

		if ( $total > 0 ) {
			$args = array(
				'id'    => 'jetpack-protect',
				'title' => '<span class="ab-icon jp-protect-icon"></span><span class="ab-label">' . $total . '</span>',
				'href'  => admin_url( 'admin.php?page=jetpack-protect' ),
				'meta'  => array(
					// translators: %d is the number of threats found.
					'title' => sprintf( _n( '%d threat found by Jetpack Protect', '%d threats found by Jetpack Protect', $total, 'jetpack-protect' ), $total ),
				),
			);

			$wp_admin_bar->add_node( $args );
		}
	}

	/**
	 * Adds modules to the list of available modules
	 *
	 * @param array $modules The available modules.
	 * @return array
	 */
	public function protect_filter_available_modules( $modules ) {
		return array_merge( array( self::JETPACK_ACCOUNT_PROTECTION_MODULE_SLUG, self::JETPACK_WAF_MODULE_SLUG, self::JETPACK_BRUTE_FORCE_PROTECTION_MODULE_SLUG ), $modules );
	}

	/**
	 * Check if the user has an available license that includes Jetpack Scan.
	 *
	 * @param boolean  $has_license  Whether a license was already found.
	 * @param object[] $licenses     Unattached licenses belonging to the user.
	 * @param string   $plugin_slug  Slug of the plugin that initiated the flow.
	 *
	 * @return boolean
	 */
	public static function jetpack_check_user_licenses( $has_license, $licenses, $plugin_slug ) {
		if ( $plugin_slug !== JETPACK_PROTECT_SLUG || $has_license ) {
			return $has_license;
		}

		$license_found = false;

		foreach ( $licenses as $license ) {
			if ( $license->attached_at || $license->revoked_at ) {
				continue;
			}

			if ( in_array( $license->product_id, self::JETPACK_SCAN_PRODUCT_IDS, true ) ) {
				$license_found = true;
				break;
			}
		}

		return $license_found;
	}

	/**
	 * Get WAF Upgrade "Seen" Status
	 *
	 * @return bool Whether the current user has dismissed the upgrade popover or enabled the automatic rules feature.
	 */
	public static function get_waf_upgrade_seen_status() {
		return (bool) get_user_meta( get_current_user_id(), 'jetpack_protect_waf_upgrade_seen', true );
	}

	/**
	 * Set WAF Upgrade "Seen" Status
	 *
	 * @return bool True if upgrade seen status updated to true, false on failure.
	 */
	public static function set_waf_upgrade_seen_status() {
		self::set_waf_upgrade_badge_timestamp();
		return (bool) update_user_meta( get_current_user_id(), 'jetpack_protect_waf_upgrade_seen', true );
	}

	/**
	 * Get WAF Upgrade Badge Timestamp
	 *
	 * @return integer The timestamp for the when the upgrade seen status was first set to true.
	 */
	public static function get_waf_upgrade_badge_timestamp() {
		return (int) get_user_meta( get_current_user_id(), 'jetpack_protect_waf_upgrade_badge_timestamp', true );
	}

	/**
	 * Set WAF Upgrade Badge Timestamp
	 *
	 * @return bool True if upgrade badge timestamp to set to the current time, false on failure.
	 */
	public static function set_waf_upgrade_badge_timestamp() {
		return (bool) update_user_meta( get_current_user_id(), 'jetpack_protect_waf_upgrade_badge_timestamp', time() );
	}

	/**
	 * Get WAF Upgrade Badge Display Status
	 *
	 * @return bool True if upgrade badge timestamp is set and less than 7 days ago, otherwise false.
	 */
	public static function get_waf_upgrade_badge_display_status() {
		$badge_timestamp_exists = metadata_exists( 'user', get_current_user_id(), 'jetpack_protect_waf_upgrade_badge_timestamp' );
		if ( ! $badge_timestamp_exists ) {
			return true;
		}

		$badge_timestamp = self::get_waf_upgrade_badge_timestamp();
		$seven_days      = strtotime( '-7 days' );
		if ( $badge_timestamp > $seven_days ) {
			return true;
		}

		return false;
	}

	/**
	 * Get WAF stats
	 *
	 * @return bool|array False if WAF is not enabled, otherwise an array of stats.
	 */
	public static function get_waf_stats() {
		if ( ! Waf_Runner::is_enabled() ) {
			return false;
		}

		return array(
			'blockedRequests'           => Plan::has_required_plan() ? Waf_Stats::get_blocked_requests() : false,
			'automaticRulesLastUpdated' => Waf_Stats::get_automatic_rules_last_updated(),
		);
	}
}
