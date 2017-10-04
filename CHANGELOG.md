# Change Log for Points Logs Regenerator

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [Unreleased]

Nothing documented yet.

## [1.1.1] - 2017-10-04

### Requires

- WordPoints: 2.4+

### Added

- Namespace extension header.
- This change log.

### Fixed

- Deprecated notices from `Channel`, `Module Name`, and `Module URI` extension headers.
- The regeneration process being interrupted in the middle. Now `wordpoints_prevent_interruptions()` is called before we start.

## [1.1.0] - 2015-04-03

### Requires

- WordPoints: 1.10+

### Added

- Support for updates through the WordPoints.org module. #6
- Added POT file and full translation support. #1

### Changed

- The button is now less of a show-hogger. It is the secondary color and moved into the corner on larger screens. #8

## [1.0.0] - 2014-08-04

### Added

- Button on the Points Logs screen to regenerate points logs.

[unreleased]: https://github.com/WordPoints/points-logs-regenerator/compare/master...HEAD
[1.1.1]: https://github.com/WordPoints/points-logs-regenerator/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/WordPoints/points-logs-regenerator/compare/1.0.0...1.1.0
[1.0.0]: https://github.com/WordPoints/points-logs-regenerator/compare/...1.0.0
