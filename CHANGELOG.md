# Craft JWT Auth Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## 0.1.0 - 2019-10-04

### Added

- Initial release
- Validate incoming requests with a JWT present in the Authentication headers.
- Match a validated JWT to a user account in Craft CMS and login as that user.
- Optionally create a new account if no existing account can be found.
