<?php
/**
 * Plugin connection management class.
 *
 * @package automattic/jetpack-connection
 */

namespace Automattic\Jetpack\Connection;

/**
 * Plugin connection management class.
 * The class represents a single plugin that uses Jetpack connection.
 * Its functionality has been pretty simplistic so far: add to the storage (`Plugin_Storage`), remove it from there,
 * and determine whether it's the last active connection. As the component grows, there'll be more functionality added.
 */
class Plugin {

	/**
	 * List of the keys allowed as arguments
	 *
	 * @var array
	 */
	private $arguments_whitelist = array(
		'url_info',
	);

	/**
	 * Plugin slug.
	 *
	 * @var string
	 */
	private $slug;

	/**
	 * Users Connection Admin instance.
	 *
	 * @var Users_Connection_Admin
	 */
	private $users_connection_admin;

	/**
	 * Initialize the plugin manager.
	 *
	 * @param string $slug Plugin slug.
	 */
	public function __construct( $slug ) {
		$this->slug = $slug;

		// Initialize Users_Connection_Admin
		$this->users_connection_admin = new Users_Connection_Admin();
	}

	/**
	 * Get the plugin slug.
	 *
	 * @return string
	 */
	public function get_slug() {
		return $this->slug;
	}

	/**
	 * Add the plugin connection info into Jetpack.
	 *
	 * @param string $name Plugin name, required.
	 * @param array  $args Plugin arguments, optional.
	 *
	 * @return $this
	 * @see $this->arguments_whitelist
	 */
	public function add( $name, array $args = array() ) {
		$args = compact( 'name' ) + array_intersect_key( $args, array_flip( $this->arguments_whitelist ) );

		Plugin_Storage::upsert( $this->slug, $args );

		return $this;
	}

	/**
	 * Remove the plugin connection info from Jetpack.
	 *
	 * @return $this
	 */
	public function remove() {
		Plugin_Storage::delete( $this->slug );

		return $this;
	}

	/**
	 * Determine if this plugin connection is the only one active at the moment, if any.
	 *
	 * @return bool
	 */
	public function is_only() {
		$plugins = Plugin_Storage::get_all();

		if ( is_wp_error( $plugins ) ) {
			if ( 'too_early' === $plugins->get_error_code() ) {
				_doing_it_wrong( __METHOD__, esc_html( $plugins->get_error_code() . ': ' . $plugins->get_error_message() ), '6.16.1' );
			} else {
				wp_trigger_error( __METHOD__, $plugins->get_error_code() . ': ' . $plugins->get_error_message() );
			}
			return false;
		}

		return ! $plugins || ( array_key_exists( $this->slug, $plugins ) && 1 === count( $plugins ) );
	}
}
