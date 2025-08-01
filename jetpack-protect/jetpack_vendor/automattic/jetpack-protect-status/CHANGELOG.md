# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.7.0] - 2025-07-30
### Added
- Add UI confirmation via text box when deleting an extension via delete-fixer so that the user is fully aware that it may break their site. [#44521]

## [0.6.1] - 2025-07-21
### Changed
- Update dependencies.

## [0.6.0] - 2025-06-05
### Added
- Add functionality to correctly display database threats in the Protect UI. [#43663]

## [0.5.11] - 2025-05-05
### Changed
- Update dependencies.

## [0.5.10] - 2025-04-28
### Changed
- Internal updates.

## [0.5.9] - 2025-03-31
### Changed
- Update dependencies.

## [0.5.8] - 2025-03-21
### Changed
- Internal updates.

## [0.5.7] - 2025-03-18
### Changed
- Update dependencies.

## [0.5.6] - 2025-03-17
### Changed
- Internal updates.

## [0.5.5] - 2025-03-12
### Changed
- Internal updates.

## [0.5.4] - 2025-03-05
### Changed
- Internal updates.

## [0.5.3] - 2025-03-03
### Changed
- Internal updates.

## [0.5.2] - 2025-02-24
### Changed
- Update dependencies.

## [0.5.1] - 2025-02-11
### Fixed
- Protect Status: Ensure vulnerabilities property is always an array. [#41694]

## [0.5.0] - 2025-02-10
### Changed
- Combine multiple vulnerability results for the same extension into a single vulnerable extension threat result. [#40863]

## [0.4.3] - 2025-02-03
### Fixed
- Code: Remove extra params on function calls. [#41263]
- Fix a bug when core version data is not interpreted correctly from the report data response. [#41503]

## [0.4.2] - 2025-01-20
### Fixed
- Fix Current_Plan::supports() call from breaking cache on every call. [#41010]

## [0.4.1] - 2024-12-23
### Fixed
- Fix PHP warnings caused by uninstalled extensions. [#40622]

## [0.4.0] - 2024-12-04
### Added
- Add extension data to threats. [#40400]

## [0.3.1] - 2024-11-25
### Changed
- Updated dependencies. [#40286]

## [0.3.0] - 2024-11-14
### Added
- Added threats property to protect status. [#40097]

### Removed
- General: Update minimum PHP version to 7.2. [#40147]

## [0.2.2] - 2024-11-04
### Added
- Enable test coverage. [#39961]

## [0.2.1] - 2024-10-29
### Changed
- Internal updates.

## [0.2.0] - 2024-09-23
### Changed
- Adds a fixable_threats status property [#39125]

## [0.1.5] - 2024-09-05
### Changed
- Update dependencies.

## [0.1.4] - 2024-09-05
### Changed
- Update dependencies.

## [0.1.3] - 2024-08-26
### Changed
- Updated package dependencies. [#39004]

## [0.1.2] - 2024-08-19
### Changed
- Internal updates.

## [0.1.1] - 2024-08-09
### Changed
- Update dependencies.

## 0.1.0 - 2024-07-15
### Added
- Initial version. [#37894]

### Changed
- Updated package dependencies. [#37894]

[0.7.0]: https://github.com/Automattic/jetpack-protect-status/compare/v0.6.1...v0.7.0
[0.6.1]: https://github.com/Automattic/jetpack-protect-status/compare/v0.6.0...v0.6.1
[0.6.0]: https://github.com/Automattic/jetpack-protect-status/compare/v0.5.11...v0.6.0
[0.5.11]: https://github.com/Automattic/jetpack-protect-status/compare/v0.5.10...v0.5.11
[0.5.10]: https://github.com/Automattic/jetpack-protect-status/compare/v0.5.9...v0.5.10
[0.5.9]: https://github.com/Automattic/jetpack-protect-status/compare/v0.5.8...v0.5.9
[0.5.8]: https://github.com/Automattic/jetpack-protect-status/compare/v0.5.7...v0.5.8
[0.5.7]: https://github.com/Automattic/jetpack-protect-status/compare/v0.5.6...v0.5.7
[0.5.6]: https://github.com/Automattic/jetpack-protect-status/compare/v0.5.5...v0.5.6
[0.5.5]: https://github.com/Automattic/jetpack-protect-status/compare/v0.5.4...v0.5.5
[0.5.4]: https://github.com/Automattic/jetpack-protect-status/compare/v0.5.3...v0.5.4
[0.5.3]: https://github.com/Automattic/jetpack-protect-status/compare/v0.5.2...v0.5.3
[0.5.2]: https://github.com/Automattic/jetpack-protect-status/compare/v0.5.1...v0.5.2
[0.5.1]: https://github.com/Automattic/jetpack-protect-status/compare/v0.5.0...v0.5.1
[0.5.0]: https://github.com/Automattic/jetpack-protect-status/compare/v0.4.3...v0.5.0
[0.4.3]: https://github.com/Automattic/jetpack-protect-status/compare/v0.4.2...v0.4.3
[0.4.2]: https://github.com/Automattic/jetpack-protect-status/compare/v0.4.1...v0.4.2
[0.4.1]: https://github.com/Automattic/jetpack-protect-status/compare/v0.4.0...v0.4.1
[0.4.0]: https://github.com/Automattic/jetpack-protect-status/compare/v0.3.1...v0.4.0
[0.3.1]: https://github.com/Automattic/jetpack-protect-status/compare/v0.3.0...v0.3.1
[0.3.0]: https://github.com/Automattic/jetpack-protect-status/compare/v0.2.2...v0.3.0
[0.2.2]: https://github.com/Automattic/jetpack-protect-status/compare/v0.2.1...v0.2.2
[0.2.1]: https://github.com/Automattic/jetpack-protect-status/compare/v0.2.0...v0.2.1
[0.2.0]: https://github.com/Automattic/jetpack-protect-status/compare/v0.1.5...v0.2.0
[0.1.5]: https://github.com/Automattic/jetpack-protect-status/compare/v0.1.4...v0.1.5
[0.1.4]: https://github.com/Automattic/jetpack-protect-status/compare/v0.1.3...v0.1.4
[0.1.3]: https://github.com/Automattic/jetpack-protect-status/compare/v0.1.2...v0.1.3
[0.1.2]: https://github.com/Automattic/jetpack-protect-status/compare/v0.1.1...v0.1.2
[0.1.1]: https://github.com/Automattic/jetpack-protect-status/compare/v0.1.0...v0.1.1
