=== Robin image optimizer — save money on image compression  ===
Tags: image, optimizer, image optimization, resmush.it, smush, jpg, png, gif, optimization, compression, Compress, Images, Pictures, Reduce Image Size, Smush, Smush.it
Contributors: webcraftic
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VDX7JNTQPNPFW
Requires at least: 4.2
Tested up to: 5.0
Requires PHP: 5.3
Stable tag: trunk
License: GPLv2

Automatic image optimization without any quality loss. No limitations, no paid plans. The best Wordpress image optimization plugin allows optimizing any amount of images for free!

== Description ==

Make your website faster by reducing the weight of images. Our Wordpress image optimizer plugin can cease image weights on 80% without any loss of quality.

Robin image optimizer is a smart and advanced image optimizer that really stands out among other Wordpress plugins. Robin image optimizer is a Wordpress free image optimizer plugin with zero limitations in terms of number of images and optimization quality. The only thing that you may stumble across is the image weight, which shouldn’t exceed 5 MB.

### What’s the purpose of image optimization? ###

The lighter the weight of the image – the faster your page loads. With the constant growth of mobile users, increases the necessity in mobile websites optimization. If you don’t want to get many rejections and lose money due to the poor ad performances, we’d recommend you to start with image optimization.

###  Why should we use Robin image optimizer for image optimization? ###

*  The first and the most significant difference from the counterparts: our plugin is absolutely free and has the same features as paid products.

*  This Wordpress image optimizer doesn't have any limits or restrictions in image optimization.

*  Automatic optimization using Cron. You don't need to wait til optimization is completed; the plugin will be optimizing couple of images every several minutes in the background.

*  Manual mass-optimization. Press the button and wait til your images are optimized

*  Image backup. Before optimization starts, all images are being stored in original quality. Then, when optimization is over, you can restore lost images or re-optimize them in another quality.

*  You can choose compression mode (normal, regular, high). Compression mode influences image weight and quality. The higher the compression, the worse is the quality and the smaller is the weight.

*  Image optimization on boot.

*  Reducing pre-optimization image weight by changing image size.

*  Detailed statistics on optimized images

#### RECOMMENDED SEPARATE MODULES ####
We invite you to check out a few other related free plugins that our team has also produced that you may find especially useful:

* [Clearfy – WordPress optimization plugin](https://wordpress.org/plugins/clearfy/)
* [Disable updates, Disable automatic updates, Updates manager](https://wordpress.org/plugins/webcraftic-updates-manager/)
* [Cyrlitera – transliteration of links and file names](https://wordpress.org/plugins/cyrlitera/)
* [Cyr-to-lat reloaded – transliteration of links and file names](https://wordpress.org/plugins/cyr-and-lat/ "Cyr-to-lat reloaded")
* [Disable admin notices individually](https://wordpress.org/plugins/disable-admin-notices/ "Disable admin notices individually")
* [WordPress Assets manager, dequeue scripts, dequeue styles](https://wordpress.org/plugins/gonzales/  "WordPress Assets manager, dequeue scripts, dequeue styles")
* [Hide login page](https://wordpress.org/plugins/hide-login-page/ "Hide login page")

#### Thanks the authors of plugins ####
We used some useful functions from plugins **Imagify Image Optimizer**, **Smush Image Compression and Optimization**, **EWWW Image Optimizer**, **reSmush.it Image Optimizer**, **ShortPixel Image Optimizer**.

== Translations ==

* English - default, always included
* Russian

If you want to help with the translation, please contact me through this site or through the contacts inside the plugin.

== Installation ==

1. Upload `robin-image-optimizer` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. All your new pictures will be automatically optimized !

== Frequently Asked Questions ==

= Why is this plugin free and how long it will be this way? =

Our Wordpress plugin to optimize images uses API of this free service: https://resmush.it, So as long as these guys allow free image optimization, our plugin will remain free. Still, we have several ideas of how to make optimization free and planning to implement them in our plugin.

= Are there any limits for image optimization? =
There are no limits for image optimization in our plugin. The only thing we have is a kind of a restriction of image weight – it should be greater than 5 MB. But our plugin can reduce pre-optimization image weight, so you’ll be able to optimize almost all images you have.

= What image formats do you support? =
Robin image optimizer can optimize jpg, png and gif (both animated or not).

= Do you remove EXIF images data? =
EXIF-data is removed by default. However, you can keep it by disabling the feature.

= Do you remove source images? =
No. Robin image optimizer replaces images with their optimized analogues. The backup option stores source images and allows restoring them in one click.

= Can I re-optimize images in another mode? =
Yes. By enabling the backup feature in the plugin, you can re-optimize any image using another compression mode.

== Screenshots ==

1. The simple interface
2. The simple interface

== Changelog ==
= 1.0.5 =
* Fixed: Added compatibility with ithemes sync

= 1.1.3 =
* Fixed: Compatibility with W3 total cache
* Fixed: Compatibility with External Media without Import

= 1.1.2 =
* Fixed: Some bugs
* Fixed: Removed limit on image resizing
* Fixed: Update core framework
* Added: New free server
* Added: Servers status, you can select available servers to optimize images
* Added: Added compatibility with the plugin Clearfy
* Preparing plugin for multisite support

= 1.0.8 =
* Added: Ability to re-optimize images with errors.
* Fixed: Some bugs
* Added: An alternative server for image optimization. Now you can select an alternative optimization server if the current server is unavailable.
* Fixed: Problems with translations

= 1.0.7
* Fixed: Images are saved in a size 0 bytes
* Fixed: Trying to backup file with empty filename
* Fixed: Curl replacement for file_get_contents
* Fixed: Statistics

= 1.0.6 =
* Fixed: fixed bar progress styles
* Fixed: changed the link to the reviews page

= 1.0.5 =
* Fixed: corrected image size calculations for individual optimization

= 1.0.4 =
* Fixed: update core framework

= 1.0.3 =
* Fixed: small bugs

= 1.0.0 =
* Release
