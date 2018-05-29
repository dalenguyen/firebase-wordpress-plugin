# Integrate Firebase WordPress Plugin

Contributors:      dalenguyen

Donate link:       https://www.paypal.me/DaleNguyen

Tags:              firebase, wordpress

Requires at least: 4.0.0

Tested up to:      4.9.6

Stable tag:        0.2.1

Requires PHP:      5.2.4

License:           GPLv2 or later

License URI:       http://www.gnu.org/licenses/gpl-2.0.html

Integrate Firebase is a plugin that helps to integrate Firebase features to WordPress

## Description

The Integrate Firebase Plugin will help a Firebase user to login to your WordPress interface - not to WordPress dashboard - from Firebase authentication. You can show user info display data that is only available to your Firebase users.

### Links

* [Github project page](https://github.com/dalenguyen/firebase-wordpress-plugin)
* [View CHANGELOG](https://github.com/dalenguyen/firebase-wordpress-plugin/blob/master/CHANGELOG.md)

## Installation

If installing the plugin from wordpress.org:

1. Upload the entire `/integrate-firebase` directory to the `/wp-content/plugins/` directory.
2. Activate Integrate Firebase Plugin through the 'Plugins' menu in WordPress.
3. Profit.

## Frequently Asked Questions

### What can I do with this Integrate Firebase plugin?

At version 0.2.2, a user can integrate Firebase authentication to WordPress. That means you can log in, log out and show data only to logged in users.

### How can I add a login form to WordPress?

After adding Firebase credentials from Settings > Firebase. You can add login form through shortcodes:

```
echo do_shortcode("[firebase_login]");
```

If you want to create your own form. Please start with *<form id='login-form'>*. For submit button, you have to add 'firebase-form-submit' as an ID.

### How can I show user info after login?

You can add a shortcode to show user's info

```
echo do_shortcode("[firebase_greetings]");
```

### How can I hide or show data for a logged in user?

You can put your data as an HTML code inside a shortcode

```
echo do_shortcode("[firebase_show class='your-class-name']YOUR HTML CODE[/firebase_show]");
```

### How can I log out?

This is a shortcode for log out button.

```
echo do_shortcode("[firebase_logout]");
```

## Screenshots

1. After activating the plugin, you need enter Firebase credentials under Setting > Firebase.

![Firebase Settings](/assets/screenshot-1.png)

## Changelog

### 0.2.2
* Fixed readme typos

### 0.2.1
* Change plugin name
* Update logout shortcode

### 0.2.0
* Add scripts & styles
* Allow to show and hide data after login

### 0.1.0
* Started the project and add an authentication method

## Upgrade Notice

Please use [github issues](https://github.com/dalenguyen/firebase-wordpress-plugin/issues) when submitting your logs.  Please do not post to the forums.
