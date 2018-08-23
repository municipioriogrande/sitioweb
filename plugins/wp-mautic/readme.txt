=== WP Mautic ===
Author: mautic
Contributors: mautic,hideokamoto,shulard,escopecz,dbhurley
Donate link: http://mautic.org/
Tags: marketing, automation
Tested up to: 4.9
Requires at least: 4.6
Stable tag: 2.2.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

[Mautic](http://mautic.org) WordPress Plugin inserts Mautic tracking image and forms to the WP website. Your Mautic instance will be able to track information about your visitors that way.

## Key features
- You don't have to edit source code of your template to insert tracking code.
- Plugin adds additional information to tracking image URL so you get better results than using just plain HTML code of tracking image.
- You can use Mautic form embed with shortcode described below.
- You can choose where the script is injected (header / footer).
- Tracking image can be used as fallback when JavaScript is disabled.

## Configuration

Once installed, the plugin must appared in your plugin list :

1. Enable it.
2. Go to the settings page and set your Mautic instance URL.

And that's it !

## Usage

### Mautic Tracking Script

Tracking script works right after you finish the configuration steps. That means it will insert the `mtc.js` script from your Mautic instance. You can check HTML source code (CTRL + U) of your WP website to make sure the plugin works. You should be able to find something like this:

    <script>
      (function(w,d,t,u,n,a,m){w['MauticTrackingObject']=n;
        w[n]=w[n]||function(){(w[n].q=w[n].q||[]).push(arguments)},a=d.createElement(t),
        m=d.getElementsByTagName(t)[0];a.async=1;a.src=u;m.parentNode.insertBefore(a,m)
      })(window,document,'script','http://yourmauticsite.com/mtc.js','mt');

      mt('send', 'pageview');
    </script>

#### Custom attributes handling

If you need to send custom attributes within Mautic events, you can use the `wpmautic_tracking_attributes` filter.

    add_filter('wpmautic_tracking_attributes', function($attrs) {
      $attrs['preferred_locale'] = $customVar;
      return $attrs;
    });

The returned attributes will be added to Mautic payload.

### Mautic Forms

To load a Mautic Form to your WP post, insert this shortcode to the place you want the form to appear:

    [mautic type="form" id="1"]

Replace "1" with the form ID you want to load. To get the ID of the form, go to your Mautic, open the form detail and look at the URL. The ID is right there. For example in this URL: http://yourmautic.com/s/forms/view/3 the ID is 3.

### Mautic Focus

To load a Mautic Focus to your post, insert this shortcode to the place you want the form to appear:

    [mautic type="focus" id="1"]

Replace "1" with the focus ID you want to load. To get the ID of the focus, go to your Mautic, open the focus detail and look at the URL. The ID is right there. For example in this URL: http://yourmautic.com/s/focus/3.js the ID is 3.

### Mautic Dynamic Content

To load dynamic content into your WP content, insert this shortcode where you'd like it to appear:

    [mautic type="content" slot="slot_name"]Default content to display in case of error or unknown contact.[/mautic]

Replace the "slot_name" with the slot name you'd like to load. This corresponds to the slot name you defined when building your campaign and adding the "Request Dynamic Content" contact decision.

### Mautic Gated Videos

Mautic supports gated videos with Youtube, Vimeo, and MP4 as sources.

To load gated videos into your WP content, insert this shortcode where you'd like it to appear:

    [mautic type="video" gate-time="#" form-id="#" src="URL"]
    [mautic type="video" src="URL"]

Replace the # signs with the appropriate number. For gate-time, enter the time (in seconds) where you want to pause the video and show the mautic form. For form-id, enter the id of the mautic form that you'd like to display as the gate. Replace URL with the browser URL to view the video. In the case of Youtube or Vimeo, you can simply use the URL as it appears in your address bar when viewing the video normally on the providing website. For MP4 videos, enter the full http URL to the MP4 file on the server.

Since the Mautic v2.9.1 release, the form-id is not mandatory anymore, mautic video can be tracked.

### Mautic Tags

You can add or remove multiple lead tags on specific pages using commas. To remove an tag you have to use minus "-" signal before tag name:

    [mautic type="tags" values="mytag,anothertag,-removetag"]

== Installation ==

### Via WP administration

Mautic - WordPress plugin [is listed](https://wordpress.org/plugins/wp-mautic/) in the in the official WordPress plugin repository. That makes it very easy to install it directly form WP administration.

1. Go to *Plugins* / *Add New*.
2. Search for **WP Mautic** in the search box.
3. The "WP Mautic" plugin should appear. Click on Install.

### Via ZIP package

If the installation via official WP plugin repository doesn't work for you, follow these steps:

1. [Download ZIP package](https://github.com/mautic/mautic-wordpress/archive/master.zip).
2. At your WP administration go to *Plugins* / *Add New* / *Upload plugin*.
3. Select the ZIP package you've downloaded in step 1.

== Upgrade Notice ==

= v2.2.1 =
Fix an escaping error introduced in the 2.0.0 version. If you tried to use HTML inside Dynamic Content shortcode, the HTML code is escaped so it became unusable.

= v2.0.4 =
Fix a bug introduced in the 2.0.2 version, you must upgrade asap because the async attribute on form generator script blocks `document.write`.

= v2.0.3 =
Fix a bug introduced in the 2.0.2 version, you must upgrade asap because there was a typo in the option page name which forbid option to be saved.

== Changelog ==

= v2.2.2 =

Release date : 2017-11-13

* Changed
  * We are now compatible with PHP7.2 and WordPress 4.9.

= v2.2.1 =

Release date : 2017-08-24

* Changed
  * Fix an escaping error when using HTML in Mautic Dynamic Content shortcode. Previously, the HTML code was escaped...
  * Remove obsolete shortcode syntax from documentation and code comments. They are still handled and not marked deprecated at the moment.

= v2.2.0 =

Release date : 2017-08-07

* Changed
  * Add compatibility with the new Mautic 2.9.1 video features. It allow to track video even when not linked to a form ID (https://github.com/mautic/mautic/pull/4438).

= v2.1.1 =

Release date : 2017-07-19

* Changed
  * Update some labels which are not clear enough.

= v2.1.0 =

Release date : 2017-07-19

* Added
  * Call translation on all labels, plugin is translation ready !
  * Add a new function `wpmautic_get_tracking_attributes` which defines attributes to be sent through JS and Image trackers.
  * Add a filter `wpmautic_tracking_attributes` to allow developers injecting custom attributes in trackers.
  * Add the ability to track logged user (within an option)

* Changed
  * Add valid text domain and start official translation process.

= v2.0.4 =

Release date : 2017-06-03

* Changed
  * Hotfix release, the async attribute on form generator script blocks `document.write`.

= v2.0.3 =

Release date : 2017-06-02

* Changed
  * Hotfix release, the option group wasn't valid.

= v2.0.2 =

Release date : 2017-06-02

* Added
  * Make a solid test suite to check every plugin parts (settings, loading, injection)
  * Add a new setting to activate tracking image as a fallback when javascript is disabled

* Changed
  * Refactor shortcode handling and put everything in shortcodes.php.
  * Clean old code from the repository (wpmautic_wp_title).

= v2.0.1 =

Release date : 2017-05-25

* Added
  * Add a new option in settings screen to choose where the script is injected.
  * Add new tests around script injection.

= v2.0.0 =

Release date : 2017-05-25

* Added
  * Composer development requirement (squizlabs/php_codesniffer).
  * Code sniffer configuration : phpcs.xml.
  * Update code using the sniff.
  * Add basic unit tests using PHPUnit.
  * Activate continuous integration using Travis-CI (check .travis.yml file).

* Changed
  * Use escape functions when printing data: esc_url.
