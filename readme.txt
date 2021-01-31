=== Integrate Firebase ===
Contributors:      hanthuy
Donate link:       https://www.paypal.me/DaleNguyen
Tags:              firebase
Requires at least: 4.0.0
Tested up to:      5.6
Stable tag:        0.8.0
Requires PHP:      5.2.4
License:           GPLv2 or later
License URI:       http://www.gnu.org/licenses/gpl-2.0.html

Integrate Firebase is a plugin that helps to integrate Firebase features to WordPress

== Description ==

The Firebase for WordPress Plugin will help a Firebase user to login to your WordPress interface - not to WordPress dashboard - from Firebase authentication. You can show user info and display data that is only available to your Firebase users.

If you want a secured implementation, with much more features, check the [Interate Firebase PRO](https://firebase.dalenguyen.me/) version.

= Links =

* [Github project page](https://github.com/dalenguyen/firebase-wordpress-plugin)
* [View CHANGELOG](https://github.com/dalenguyen/firebase-wordpress-plugin/blob/master/CHANGELOG.md)

== Installation ==

If installing the plugin from wordpress.org:

1. Upload the entire `/integrate-firebase` directory to the `/wp-content/plugins/` directory.
2. Activate Integrate Firebase Plugin through the 'Plugins' menu in WordPress.
3. Profit.

== Frequently Asked Questions ==

= What can I do with this Integrate Firebase plugin? =

At version 0.6.1, the user can integrate Firebase authentication to WordPress. That means you can:

* Log in, log out and show custom data only to logged in users.
* Get Real Time and Firestore database in Dashboard
* Show realtime database on frontend after users log in

= How can I put a shortcode in a widget or WordPress editor? =

The example in this guide only shows you how to put in a PHP file. If you want to put the shortcode inside a widget or editor. You can simply do this:

> [firebase_login][/firebase_login]

= How can I add a login form to WordPress? =

After adding Firebase credentials from Settings > Firebase. You can add login form through shortcodes:

>  echo do_shortcode("[firebase_login]");

If you want to create your own form. Please start with *<form id='login-form'>*. For submit button, you have to add 'firebase-form-submit' as an ID.

= How can I show user info after login? =

You can add a shortcode to show user's info

> echo do_shortcode("[firebase_greetings]");

= How can I show error when a user cannot login? =

You can show error message when a user cannot login by using a shortcode

> echo do_shortcode("[firebase_login_error class="your-class-name"][/firebase_login_error]");

= How can I show data for a not logged in user? =

You can put your data as an HTML code inside a shortcode

> echo do_shortcode("[firebase_show_not_login class="your-class-name"]YOUR HTML CODE[/firebase_show_not_login]");

= How can I hide or show data for a logged in user? =

You can put your data as an HTML code inside a shortcode

> echo do_shortcode("[firebase_show class="your-class-name"]YOUR HTML CODE[/firebase_show]");

= How can I show realtime database for a logged in user? =

You can put your data as an HTML code inside a shortcode. Realtime data will be shown as a table with an id #if-realtime.

> echo do_shortcode("[realtime class="your-class-name" collection_name="string" document_name="string"]");

= How can I log out?

This is a shortcode for log out button.

> echo do_shortcode("[firebase_logout]");

== Screenshots ==

1. After activating the plugin, you need enter Firebase credentials under Setting > Firebase.
2. Please enter collection names in order to show the data from Real Time Database

== Changelog ==

= 0.8.0 =
* Updated firebase packages to 8.2.5
* Moved scripts to the end of body tag

= 0.7.0 =
* Fixed add_options_page error
* Preformated data before showing in dashboard
* Delegated button style to WordPress
* Updated firebase package to 7.18.0

= 0.6.1 =
* Removed hide realtime table script

= 0.6.0 =
* Show realtime data publicly

= 0.5.3 =
* Update firebase scripts

= 0.5.2 =
* Show realtime database after login

= 0.5.1 =
* Hide login form after logging in

= 0.5.0 =
* Add shortcode to display when not login
* Add error handling shortcode

= 0.4.0 =
* Added Firestore database support in Dashboard

= 0.3.2 =
* Fixed firebase show shortcode

= 0.3.1 =
* Fixed get firebase credentials

= 0.3.0 =
* Added about information
* Added Real Time database support in Dashboard

= 0.2.2 =
* Fixed readme typos

= 0.2.1 =
* Change plugin name
* Update logout shortcode

= 0.2.0 =
* Add scripts & styles
* Allow to show and hide data after login

= 0.1.0 =
* Started the project and add authentication method

== Upgrade Notice ==

Please use [github issues](https://github.com/dalenguyen/firebase-wordpress-plugin/issues) when submitting your logs.  Please do not post to the forums.
