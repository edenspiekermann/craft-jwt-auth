# Craft JWT Auth plugin

Enable authentication to Craft through the use of [JSON Web Tokens](https://jwt.io/) (JWT).

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.3 or later.

## Installation

To install the plugin, follow these instructions.

1.  Open your terminal and go to your Craft project:

    cd /path/to/project

2.  Then tell Composer to load the plugin:

    composer require edenspiekermann/craft-jwt-auth

3.  In the Control Panel, go to Settings → Plugins and click the “Install” button for Craft JWT Auth.

## Craft JWT Auth Overview

From the [official website](https://jwt.io/):

    JSON Web Tokens are an open, industry standard RFC 7519 method for representing claims securely between two parties.

This plugin enables requests to Craft to be securely authenticated in the presence of a JWT that can be successfully verified as matching a secret key generated signature.

## Configuring Craft JWT Auth

Once installed, navigate to the settings page of the plugin and enter required settings to activate the plugin:

| Setting            | Description                                                                                 |
| ------------------ | ------------------------------------------------------------------------------------------- |
| `Secret key`       | Mandatory. Secret key used to sign outgoing and verify incoming JWTs.                       |
| `Auto create user` | Optional. Activate to enable auto-creation of a public user when provided a verifiable JWT. |

## Using Craft JWT Auth

The plugin will attempt to verify any incoming requests with a JWT present in the `Authentication` header with a `Bearer` prefix, or with the simpler `X-Access-Token` header value. An example:

```shell
# With Authorization: Bearer
curl --header "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.XbPfbIHMI6arZ3Y922BhjWgQzWXcXNrz0ogtVhfEd2o" MYCRAFTSITE.com

# With X-Access-Token
curl --header "X-Access-Token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.XbPfbIHMI6arZ3Y922BhjWgQzWXcXNrz0ogtVhfEd2o" MYCRAFTSITE.com
```

The plugin will attempt to verify the token using the [lcobucci/jwt](https://github.com/lcobucci/jwt) package for PHP. The package adheres to the [IANA specifications](https://www.iana.org/assignments/jwt/jwt.xhtml) for JWTs.

If a provided token can be verified AND can be match to a user account with a username matching the provided `sub` key, the user will be authenticated and the request allowed to continue.

If the token is verifiable but a matching user account does NOT exist, but the `Auto create user` setting is enabled AND public registration is enabled in the Craft settings, a new user account will be created on-the-fly and the new user then logged in.

## Craft JWT Auth Roadmap

### Features

The plugin does or will offer the following features:

- [x] Validate incoming requests with a JWT present in the Authentication headers.
- [x] Match a validated JWT to a user account in Craft CMS and login as that user.
- [x] Optionally create a new account if no existing account can be found.
- [ ] Generate a JWT from a user’s account data to enable sharing with other services that implement the same secret key.

### Milestones

While the plugin is already useable, it is by no means finished. Use at your own risk. Some things to do before I'm comfortable taking it to version 1.0.0:

- [ ] `0.2.0` Refactor into more logical set of services and classes.
- [ ] `0.3.0` Better testing for the presence of an actual JWT, rather than some other type of token.
- [ ] `0.3.1` Checking for the presence of valid claims and handling if they aren't there.
- [ ] `0.3.2` Handle edge case of successful user creation but failed image creation.
- [ ] `0.3.3` Better exception handling in general.
- [ ] `0.4.0` Add test cases for all of that.
- [ ] Have really smart people review the code for vulnerabilities.
- [ ] Other stuff I haven't though of because I haven't done 👆 yet.

Written and maintained by [Mike Pierce](https://michaelpierce.trade). Made possible by [Edenspiekermann](https://edenspiekermann.com).
