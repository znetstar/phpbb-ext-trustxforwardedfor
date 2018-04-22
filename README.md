# PhpBB Extension - marttiphpbb Trust X-Forwarded-For

## Requirements

phpBB 3.2+ PHP 7+

## Description

The "X-Forwarded-For" header value is a comma+space separated list of IP addresses, the left-most being the original client, and each successive proxy that passed the request adding the IP address where it received the request from.

This extension will set the user ip in your phpBB to the most trusted (most right) ip
in the X-Forwarded-For header instead of SERVER_ADDR (the direct client)
Use this only with a reverse proxy which is under your control.
This extension will block all ips which are not localhost (127.0.0.1 or ::1) unless
defined in the comma separated list environment variable
MARTTIPHPBB_TRUSTXFORWARDEDFOR_IPS.

If your reverse proxy has i.e the address 172.0.0.13, then set the environment variable
MARTTIPHPBB_TRUSTXFORWARDEDFOR_IPS=172.17.0.3

## Quick Install

You can install this on the latest release of phpBB 3.2 by following the steps below:

* Create `marttiphpbb/trustxforwardedfor` in the `ext` directory.
* Download and unpack the repository into `ext/marttiphpbb/trustxforwardedfor`
* Enable `Trust X-Forwarded-For` in the ACP at `Customise -> Manage extensions`.
* You can start editing the Archive Forum in the Forum ACP for each Forum.

## Uninstall

* Disable `Trust X-Forwarded-For` in the ACP at `Customise -> Extension Management -> Extensions`.
* To permanently uninstall, click `Delete Data`. Optionally delete the `/ext/marttiphpbb/trustxforwardedfor` directory.

## Support

* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/phpbb-ext-trustxforwardedfor/issues).

### License

[GPL-2.0](license.txt)
