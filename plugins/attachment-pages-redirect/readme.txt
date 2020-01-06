=== Attachment Pages Redirect ===
Contributors: samuelaguilera
Tags: attachment, redirect, images, 301, 302
Requires at least: 4.8
Requires PHP: 5.6
Tested up to: 5.3
Stable tag: 1.1.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Redirect attachment pages or return a 404 error for them based on the parent post status.

== Description ==

There are three possible scenarios where this plugin does something:

A) A visitor lands on an attachment page and the parent post is available (not in trash or deleted). A 301 redirect will be issued to redirect the visitor to the parent post.

B) A visitor lands on an attachment page and the parent post was already deleted from trash. A 302 redirect is issued to home page (this can be changed to 301 if you want, see FAQ for more details). 

C) A visitor lands on an attachment page and the parent post is in trash, therefore not available for the visitor. It returns a 404 error code to prevent endless redirection loop in old WP releases and redirecting to trashed/not available posts.

**There is no options page**, simply activate it and will do the job.

If you're happy with the plugin [please don't forget to give it a good rating](https://wordpress.org/support/plugin/attachment-pages-redirect/reviews/?filter=5), it will motivate me to keep sharing and improving this plugin (and others).

= Requirements =

* WordPress 4.8 or higher.
    	
== Installation ==

* Extract the zip file and just drop the contents in the <code>wp-content/plugins/</code> directory of your WordPress installation (or install it directly from your dashboard) and then activate the Plugin from Plugins page.
  
== Frequently Asked Questions ==

= Will this plugin works in WordPress older than 4.8? =

It should work with WP 3.3 or newer, but I'm not supporting versions older than the one required in this readme.

= Can I change the HTTP codes used for the redirections? =

Since version 1.1 you can do this by adding constants to your wp-config.php file. The example below will switch the redirection codes used by default.

`define( 'ATTACHMENT_REDIRECT_CODE', '302' );
define( 'ORPHAN_ATTACHMENT_REDIRECT_CODE', '301' );
`

**Use this at your own risk, only if you know what you're doing!! No support will be offered for this.**

== Changelog ==

= 1.1.1 =

* Minor changes to make code 100% compliant with WordPress Coding Standards. This doesn't means any change in the plugin functionality, it's just code cosmetic.

= 1.1 =

* Minor coding standards improvements.
* Added ATTACHMENT_REDIRECT_CODE and ORPHAN_ATTACHMENT_REDIRECT_CODE constants to allow change the HTTP redirection codes (e.g. change 302 to 301 for orphan attachments)
* Prevent endless redirection loop in old WP releases and redirecting to trashed/not available posts if an attachment page is visited when parent post is in trash. Returning a 404 error in this case.

= 1.0 =

* Initial release.

== Upgrade Notice ==

= 1.1 =

* Recommended upgrade. Read changelog in WordPress.org for more details.

