<?php
/**
 * The Header for Neverland.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Neverland
 * @since Neverland 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
<link rel="shortcut icon" href="<?php echo get_bloginfo('template_url'); ?>/favicon.ico" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_url'); ?>/js/jquery.snippet.css"/>
<link rel="apple-touch-icon" href="<?php echo get_bloginfo('template_url'); ?>/apple/iphone.png"/>
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_bloginfo('template_url'); ?>/apple/ipad.png"/>
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_bloginfo('template_url'); ?>/apple/retina.png"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/js/jquery.snippet.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/js/sh_changelog.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/js/sh_desktop.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/js/sh_log.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/js/sh_makefile.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/js/sh_spec.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/js/neverland.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/js/zoom.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/js/lightbox.js"></script>

<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
	<div id="header">
		<div id="site-title">
			<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</div>
		
		<div id="subscribe">
			<a class="rss" href="http://ikde.org/feed/"></a>
			<a class="twitter" href="https://twitter.com/#!/ikde_org/"></a>
			<a class="gplus" href="https://plus.google.com/103630450909014790042/posts"></a>
		</div>

		<div id="access">
			<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
			<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
		</div> <!-- #access -->
	</div><!-- #header -->
