<?php
/**
 * The main template file for display archive page.
 *
 * @package WordPress
*/

//Check if portfolio post type then go to another template
$post_type = get_post_type();
if($post_type == 'galleries')
{
	get_template_part("galleries");
	exit;
}
else
{
	//Get archive page layout setting
	$pp_blog_archive_layout = get_option('pp_blog_archive_layout');
	if(empty($pp_blog_archive_layout))
	{
		$pp_blog_archive_layout = 'blog_r';
	}
	
	$located = locate_template($pp_blog_archive_layout.'.php');
	if (!empty($located))
	{
		get_template_part($pp_blog_archive_layout);
	}
	else
	{
		echo 'Error can\'t find page template you selected';
	}
}
?>