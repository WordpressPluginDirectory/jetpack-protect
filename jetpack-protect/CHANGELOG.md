# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 4.3.0 - 2025-07-30
### Added
- Add UI confirmation via text box when deleting an extension via delete-fixer so that the user is fully aware that it may break their site. [#44521]
- My Jetpack: Add analytics for empty product search results. [#44344]

### Changed
- E2E tests: remove redundant logic in test fixture and converted the fixture to Typscript [#44327]
- Improve performance of wpcom comments liking by caching and minimizing API requests. [#44205]
- My Jetpack: Enabled access to My Jetpack on WP Multisite. [#44260]
- Sync: Ignore the ActivityPub Outbox CPT. [#44222]
- Update package dependencies. [#44206]

### Fixed
- My Jetpack: Fix footer alignment for diconnected accounts. [#44468]
- My Jetpack: Restore plan purchase link. [#44535]
- Update JITMs to remove jQuery dependency. [#43783]

## 4.2.0 - 2025-07-03
### Added
- WAF: Add account recovery flow for blocklisted IP addresses. [#43051]

### Changed
- My Jetpack: Update Stats card to include a chart for better analytics. [#43870]
- Update package dependencies. [#44151]

### Removed
- Remove the need to add FTP/SSH credentials to run auto threat fixers. [#43935]

### Fixed
- JITM: Fix ineffective caching due to expired plugin sync transient. [#44117]
- My Jetpack: Use compact number notation in the Protect card. [#43977]
- WAF: Fix PHP warnings for Brute_Force_Protection->get_local_host(). [#44170]

## 4.1.0 - 2025-06-05
### Added
- Scanner: Add functionality to correctly display database threats in the Protect UI. [#43663]
- Account Protection: Add the Account Protection module toggle. [#40925]
- My Jetpack: Add user tour. [#42880]
- My Jetpack: Improve the onboarding experience of Jetpack guiding the users through a new onboarding process. [#42757]

### Changed
- Connection: Allow pre-selected login providers. [#42662]
- General: Indicate compatibility with WordPress 6.8. [#42701]
- My Jetpack: Optimize the images for onboarding slider for faster page load. [#43473]
- My Jetpack: Update the onboarding UI, changing it to a single button. [#43203]
- General: Update package dependencies. [#43766]

### Removed
- General: Update minimum WordPress version to 6.7. [#43192]

### Fixed
- JS Packages: Decrease CSS priority of global styles to prevent them from applying within the editor. [#43035]
- My Jetpack: Fix Onboarding UI responsiveness at 600px. [#43533]
- My Jetpack: Fix readability of license activation button on hover. [#43550]
- My Jetpack: Prevent social login from getting stuck when email input is not empty. [#43158]
- Readme: Clarify language in the plugin readme regarding malware and vulnerability scanning. [#43775]

## 4.0.0 - 2025-03-24
### Changed
- Scanner: Add threat count to tab. [#40056]
- Scanner: Animate the "scan in progress" placeholder image. [#39825]
- General: Indicate compatibility with WordPress 6.7. [#39786]
- General: Update package dependencies. [#42511]

### Removed
- Firewall: Remove "new" badge from tab. [#41902]
- General: Update minimum PHP version to 7.2. [#40147]
- General: Update minimum WordPress version to 6.6. [#40146]

## 3.1.1 - 2024-10-17
### Changed
- Firewall: Fix backwards compatibility for sites running standalone mode with outdated packages autoloaded.

## 3.1.0 - 2024-10-15
### Added
- Firewall: Adds stat cards showing recent block counts [#35739]
- Auto-Fixers: Adds handling for long-running fixers [#39301]

### Changed
- Firewall: added help text for IP list formatting rules [#39448]
- Updated package dependencies. [#39707]

### Removed
- Security Scanning: disabled database threat category [#39467]

### Fixed
- Minor fixes and improvements.

## 3.0.2 - 2024-09-06
### Changed
- Internal updates.

## 3.0.1 - 2024-09-06
### Added
- Threats List: Add pagination. [#39058]

### Changed
- Admin menu: change order of Jetpack sub-menu items. [#39095]
- Updated package dependencies. [#39176]

### Fixed
- Security Scanning: Adds a background to the scan progress bar. [#38847]
- General: Delete relevant Protect options on deactivation. [#38815]
- Auto Fixers: Disable the unignore threats button when a fixer is in progress. [#38898]
- Security Scanning: Fix the threat fixed on date in the history view. [#39164]
- General: Improves the manual scan link button loading state. [#38897]

## 3.0.0-beta - 2024-08-09
### Added
- Firewall: add dedicated WAF allow and block list toggles [#38265]
- General: add "contact support" links [#38416]
- Security Scanning: add threats history view [#38117]

### Changed
- General: indicate compatibility with the upcoming version of WordPress - 6.6. [#37962]

### Removed
- General: update WordPress version requirements to WordPress 6.5. [#38382]

### Fixed
- Fix an issue where the connection error hook was always resetting the notice [#38120]
- Fix image optimization [#38573]
- Fix in-progress threat fixer loading indicator [#38051]
- Fix threat fix modal title [#38312]

## 2.2.0 - 2024-05-24
### Added
- Add data to WAF logs and a toggle for users to opt-in to share more data with us if needed. [#36377]
- Trigger a red bubble notification when a bad install is detected. [#36449]

### Changed
- Update WordPress minimum version requirement to WordPress 6.4. [#37047]
- Only show installation errors on the plugins page. [#36390]

### Fixed
- Jetpack Protect Footer: ensure that "Go to cloud" links are not shown when on a platform with no firewall support. [#36794]

## 2.1.0 - 2024-03-14
### Added
- Added onboarding flows. [#34649]
- Added firewall standalone mode indicator. [#34840]

### Changed
- General: indicate compatibility with the upcoming version of WordPress, 6.5. [#35820]
- Use blog ID instead of site slug in checkout links. [#35004]
- Updated package dependencies. [#36325]
- Updated package lockfile. [#35672]

### Fixed
- Prevent text orphans in the site scanning header. [#35935]

## 2.0.0 - 2024-01-18
### Changed
- Firewall: use datetime versioning for rules file updates. [#34698]
- General: unify display of notifications across Scan and Firewall screens [#34702]
- General: indicate full compatibility with the latest version of WordPress, 6.4. [#33776]
- General: update PHP requirement to PHP 7.0+ [#34126]
- General: update WordPress version requirements to WordPress 6.3. [#34127]
- General: update package dependencies. [#34882]
- General: update lockfile. [#33607]

### Fixed
- Fix Modal component overflow scrolling. [#34475]
- Fix Popover component styling. [#34424]
- Improved helper script installer logging. [#34297]

## 1.4.2 - 2023-10-19
### Changed
- General: update WordPress version requirements to WordPress 6.2. [#32762] [#32772]
- Updated Jetpack submenu sort order so individual features are alpha-sorted. [#32958]
- Updated method used to render Connection initial state. [#32499]
- Updated package dependencies. [#33692]

## 1.4.1 - 2023-07-18
### Changed
- Brute Force Protection: add access to feature in environments that otherwise do not support the WAF. [#31952]
- General: indicate full compatibility with the latest version of WordPress, 6.3. [#31910]
- Update WordPress version requirements. Now requires version 6.1. [#30120]
- Update package dependencies. [#31952]

### Fixed
- Scan: Fixed sorting of threats by severity. [#31124]
- License Activation: add filtering for unattached and unrevoked licenses within upgrade flow check. [#31086]

## 1.4.0 - 2023-05-05
### Added
- Add brute force protection. [#28401]

### Changed
- General: indicate full compatibility with the latest version of WordPress, 6.2. [#29341]
- Improve the firewall status heading to provide more information based on the current configuration. [#28401]
- Updated package dependencies. [#29480]

## 1.3.0 - 2023-03-13
### Added
- Add ability to toggle automatic and manual firewall rules independently. [#27726]
- Add improved messaging for currently enabled firewall features. [#27845]
- Disable Jetpack Firewall on unsupported environments. [#27939]
- Add link to pricing page for getting started with an existing plan or license key. [#27745]

### Changed
- Updated package dependencies. [#29297]
- Update to React 18. [#28710]
- Use `flex-start`/`flex-end` instead of `start`/`end` for better browser compatibility. [#28530]

### Fixed
- Fix connection button loading indicators. [#28514]
- Fix Protect status report caching. [#28766]
- Remove unnecessary full path from example in UI. [#29037]
- Other assorted fixes for minor bugs and grammar. [#27846] [#28091] [#28397] [#28273]

## 1.2.0 - 2023-01-16
### Added
- Add web application firewall (WAF) features [#27528]
- Add progress bar to site scannnig screen [#27171]

### Fixed
- Poll for scan status while scanner is provisioning [#28275]
- Bug fixes

## 1.1.2 - 2022-11-30
### Changed
- changed description and author [#27618]
- Updated package dependencies. [#27043]

## 1.1.1 - 2022-11-18
### Fixed
- Fix issue with plugin activation.

## 1.1.0 - 2022-11-17
### Added
- Add features for paid Jetpack Scan users, including file and database threats, on-demand scanning, and threat auto-fixers.

### Changed
- Compatibility: WordPress 6.1 compatibility

### Fixed
- Adjust alignment of spinner icon and loading text on the in-progress scan screen.

## 1.0.4 - 2022-08-29
### Fixed
- Fixed NaN error that prevented the pricing interstitial from rendering.

## 1.0.3 - 2022-08-26
### Added
- Added a default 'See all results' label to the mobile navigation button.
- Added a spinner to the in progress scan page in admin
- Added JITM functionality
- Added threat descriptions.
- My Jetpack includes JITMs

### Changed
- Add condition to check plugin activation context before redirecting

### Fixed
- Fixed alignment of long navigation item labels on mobile screen sizes.

## 1.0.2 - 2022-07-27
### Changed
- Updated package dependencies.

### Fixed
- Fix protect admin toolbar icon display when Jetpack enabled and connected
- Minor bug fix - added isset() checks for report data properties

## 1.0.1 - 2022-07-07
### Added
- Added two new FAQ entries
- Protect: record even just after the site is registered

### Changed
- Moved normalization of the Protect status report data to the server side.
- Renamed `master` references to `trunk`
- Reorder JS imports for `import/order` eslint rule.

### Fixed
- Fixed bug that would not display Core vulnerabilities.
- Removed legacy code and documentation and adds new docs for the debug helper plugin.
- Fixed recommendation for plugins that don't have a fix yet
- Protect: Fix visual issue of the Interstitial page

## 1.0.0 - 2022-05-31
### Added
- Add additional tracking events
- Add Alert icon to the error admin page
- Add checks to the Site Health page
- Add custom hook to handle viewport sizes via CSS
- Add error message when adding plugin fails
- Add first approach of Interstitial page
- Add Jetpack Scan to promotion section when site doesn't have Security bundle
- Add missing prop-types module dependency
- Add Navigation dropdown mode and use it for small/medium screens
- Add ProductOffer component
- Add product offer component
- Add title and redirect for vul at wpscan
- Add 'get themes' to synced callables in Protect
- Add installedThemes to the initial state
- Add notifications to the menu item and the admin bar
- Add status polling to the Protect admin page.
- Added details to the FAQ question on how Jetpack Protect is different from other Jetpack products.
- Added Jetpack Protect readme file for the plugin listing.
- Added option to display terms of service below product activation button.
- Added Social card to My Jetpack.
- Added the list of installed plugins to the initial state
- Change ConnectScreen by the Interstitial component
- Creates Status Class
- Empty state screen
- Expose and use IconsCard component
- Flush cache on plugin deactivation
- Footer component
- Handle error in the UI
- Hooks on plugin activation and deactivation
- Hook to read data from the initial state
- Implement Footer
- Implement Add Security bundle workflow
- Introduce Accordion component
- Introduce Navigation component
- Introduce Summary component
- Introduce VulnerabilitiesList component
- JS Components: Introduce Alert component. Add error to ProductOffer components
- More options to the testing api responses
- Record admin page-view and get security from footer events
- Render Security component with data provided by wpcom
- Request and expose to the client the Security bundle data
- Update logo

### Changed
- Add empty state for no vuls
- Add popover at Badge
- Cache empty statuses for a short period of time
- Changed connection screen to the one that does not require a product
- Changed the method used to disconnect
- Changed the wording for the initial screen.
- Change expiration time of plugin cache
- Clean connection data. Update to latest connection API
- Configure Sync to only what we need to sync
- Janitorial: require a more recent version of WordPress now that WP 6.0 is coming out.
- JS Components: Add subTitle prop to ProductOffer component
- JS Components: iterate over Dialog component
- Improve Dialog layout in medium viewport size
- Move VulnerabilitiesList to section hero
- New VulsList
- Redesign Summary component
- Re-implement "Your results will be ready soon" layout
- Re-implement Admin page by using Dialog component
- Remove use of `pnpx` in preparation for pnpm 7.0.
- Replace deprecated external-link variation by using isExternalLink prop
- Require only site level connection
- Truncate items at NavigationGroup
- Tweak footer
- Update Footer and VulsList for small/medium viewport
- Update Navigation to be external controlled
- Update Protect icon
- Update VulnerabilitiesList to remove severity and add fixed in
- Updated package dependencies.
- Update package.json metadata.
- Updates CTA wording to reduce confusion when user already has Jetpack Security Bundle which includes Jetpack Scan
- Update the Status when connection is established
- Use data provided by My Jetpack to render Product offer
- Use weight Button prop to style the "learn more" footer link
- Use a different copy when there are no found vulnerabilities but there are still some unchecked items

### Removed
- Removed Full Sync from loaded modules as Full Sync Immediately is present by default now

### Fixed
- Adjust spacing and overflow properties of the navigation labels to improve display of long names.
- Fix Connectino initialization
- Fix fatal when checking whether site site has vuls
- Fix right margin in primary layout
