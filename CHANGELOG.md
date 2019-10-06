# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 0.2.0 - 2019-10-06

### Added

- `JWT::getJWTFromRequest()`: Attempts to find a JWT in request headers and return it.

- `JWT::parseAndVerifyJWT()`: Attempts to parse a JWT and verify that it is signed using the shared secret.

- `JWT::parseJWT()`: Attempts to parse a JWT string.

- `JWT::verifyJWT()`: Attempts to verify a JWT token with the shared secret key.

- `JWT::getUserByJWT()`: Looks for a Craft user that matches the claimed email in the verified token.

- `JWT::createUserByJWT()`: Creates a Craft user based on the claims found in the verified token.

- Roadmap to 1.0 in README

### Changed

- Refactored authentication logic into service calls

## 0.1.2 - 2019-10-05

### Added

- Additional instructions to the PR template

### Removed

- Deleted some unneeded asset files

- Cleaned up various files of unneeded cruft

## 0.1.1 - 2019-10-04

### Changed

- Changed the name of the package to edenspiekermann/craft-jwt-auth

## 0.1.0 - 2019-10-04

### Added

- Initial release

- Validate incoming requests with a JWT present in the Authentication headers.

- Match a validated JWT to a user account in Craft CMS and login as that user.

- Optionally create a new account if no existing account can be found.
