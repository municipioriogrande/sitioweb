<?php
/**
 * Plugin Name: Attachment Pages Redirect
 * Description: Makes attachment pages redirects (301) to post parent if any. If not, redirects (302) to home page.
 * Author: Samuel Aguilera
 * Version: 1.1.1
 * Author URI: http://www.samuelaguilera.com
 * License: GPLv3
 *
 * @package Attachment Pages Redirect
 */

/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License version 3 as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'ATTACHMENT_REDIRECT_CODE' ) ) {
	define( 'ATTACHMENT_REDIRECT_CODE', '301' ); // Default redirect code for attachments with existing parent post.
}

if ( ! defined( 'ORPHAN_ATTACHMENT_REDIRECT_CODE' ) ) {
	define( 'ORPHAN_ATTACHMENT_REDIRECT_CODE', '302' ); // Default redirect code for attachments with no parent post.
}


/**
 * Handles redirection.
 */
function sar_attachment_redirect() {

	global $post;

	if ( is_attachment() && isset( $post->post_parent ) && is_numeric( $post->post_parent ) && ( 0 !== $post->post_parent ) ) {

		$parent_post_in_trash = get_post_status( $post->post_parent ) === 'trash' ? true : false;

		if ( $parent_post_in_trash ) {
			wp_die( 'Page not found.', '404 - Page not found', 404 ); // Prevent endless redirection loop in old WP releases and redirecting to trashed posts if an attachment page is visited when parent post is in trash.
		}

		wp_safe_redirect( get_permalink( $post->post_parent ), ATTACHMENT_REDIRECT_CODE ); // Redirect to post/page from where attachment was uploaded.
		exit;

	} elseif ( is_attachment() && isset( $post->post_parent ) && is_numeric( $post->post_parent ) && ( $post->post_parent < 1 ) ) {

		wp_safe_redirect( get_bloginfo( 'wpurl' ), ORPHAN_ATTACHMENT_REDIRECT_CODE ); // Redirect to home for attachments not associated to any post/page.
		exit;

	}
}

add_action( 'template_redirect', 'sar_attachment_redirect', 1 );
