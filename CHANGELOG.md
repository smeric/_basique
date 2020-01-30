# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]


## [1.0.1] - 2019-01-30
### Changed
- WordPress 5.2 added to jQuery version number in wp-includes/script-loader.php a ['-wp' suffix](https://github.com/WordPress/WordPress/blob/7d171684bc7eb76496627b64a791ac722a5e9f04/wp-includes/script-loader.php#L1017) that should be removed when real jQuery version compare in _basique_enqueue_jquery_scripts function.
- Removed jQuery version compare from _basique_jquery_local_fallback function in functions.php as the $wp_scripts global seems to be undefined at script_loader_src hook time.
- Removed closing php tag in functions.php for convenience :)

## [1.0.0] - 2019-01-13

- Initial public release
