<?php
/**
 * neverland functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, neverland_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'neverland_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

/** Tell WordPress to run neverland_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'neverland_setup' );

if ( ! function_exists( 'neverland_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override neverland_setup() in a child theme, add your own neverland_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function neverland_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'gallery' ) );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'neverland', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'neverland' ),
	) );
}
endif;

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function neverland_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'neverland_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function neverland_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'neverland' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and neverland_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function neverland_auto_excerpt_more( $more ) {
	return ' &hellip;' . neverland_continue_reading_link();
}
add_filter( 'excerpt_more', 'neverland_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function neverland_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= neverland_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'neverland_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since Twenty Ten 1.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Deprecated way to remove inline styles printed when the gallery shortcode is used.
 *
 * This function is no longer needed or used. Use the use_default_gallery_style
 * filter instead, as seen above.
 *
 * @since Twenty Ten 1.0
 * @deprecated Deprecated in Twenty Ten 1.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function neverland_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'neverland_remove_gallery_css' );

// Comment style

if ( ! function_exists( 'neverland_comment' ) ) :

function neverland_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div class="comment-author">
			<span><?php echo get_avatar( $comment, 40 ); ?></span>
			<span><?php printf( __( '%s', 'neverland' ), sprintf( '%s', get_comment_author_link() ) ); ?></span>
		</div><!-- .comment-author -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'neverland' ); ?></em>
			<br />
		<?php endif; ?>
      <div class="comment-body">
		<div class="comment-meta">
			<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			  <?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'neverland' ), get_comment_date(),  get_comment_time() ); ?>
			</a>
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			<?php edit_comment_link( __( '(Edit)', 'neverland' ), ' ' );?>
			</div><!-- .comment-meta -->
			
        <?php comment_text(); ?>

		</div>

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'neverland' ); ?> <?php comment_author_link(); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override neverland_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function neverland_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'neverland' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'neverland' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'neverland' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'neverland' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
/** Register sidebars by running neverland_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'neverland_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * This function uses a filter (show_recent_comments_widget_style) new in WordPress 3.1
 * to remove the default style. Using Twenty Ten 1.2 in WordPress 3.0 will show the styles,
 * but they won't have any effect on the widget in default Twenty Ten styling.
 *
 * @since Twenty Ten 1.0
 */
function neverland_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'neverland_remove_recent_comments_style' );

// Add a new Recent Comments widget with avatars

if(function_exists('register_sidebar_widget'))
	register_sidebar_widget(__('Recent Comments with Avatars'),'neverland_recent_avatar_comments');

function neverland_recent_avatar_comments() {
global $wpdb;
$sql = "SELECT * from $wpdb->comments WHERE comment_approved= '1' AND comment_type != 'pingback'
    ORDER BY comment_date DESC LIMIT 0 ,8";
$comments = $wpdb->get_results($sql);
$output .= "<li class=\"widget-container\"><h3 class=\"widget-title\">What's up buddy?</h3>";
$output .= "<ul>";
foreach ($comments as $comment) {
$output .= "<li class=\"recent-comment\">";
$url = '<a href="'. get_permalink($comment->comment_post_ID).'#comment-'.$comment->comment_ID .'" title="'.$comment->comment_author .' | '.get_the_title($comment->comment_post_ID).'">';
$output .= "<div class=\"recent_comment_meta\">";
$output .= get_avatar($comment->comment_author_email,32);
$output .= "<div class=\"recent_comment_text\"><span class=\"recent_comment_name\">". $comment->comment_author ."</span>";
$output .= "<span class=\"recent_comment_date\">". mysql2date('F j',$comment->comment_date)."</span>";
$output .= "</div></div>";
$output .= "<p>".$url. wp_html_excerpt($comment->comment_content, 40) ."...</a></p>";
$output .= "</li>";
}
$output .= "</ul></li>";
echo $output;
}

// Replace default avatar with kde one 

add_filter('avatar_defaults','neverland_avatar');

function neverland_avatar($avatar_defaults) {
	$newavatar = get_bloginfo('template_directory')."/images/avatar.png";
	$avatar_defaults[$newavatar] = " KDE default";
	return $avatar_defaults;
	}
	
// Dropdown Categories 

if(function_exists('register_sidebar_widget'))
	register_sidebar_widget(__('Dropdown Categories'),'neverland_dropdown_categories');
	
function neverland_dropdown_categories() {
$select = wp_dropdown_categories('show_option_none=Select Category&show_count=1&orderby=name&echo=0&selected=6');
$select = preg_replace("#<select([^>]*)>#", "<select$1 onchange='return this.form.submit()'>", $select);
$output .= "<li class=\"widget-container\"><h3 class=\"widget-title\">Categories</h3>";
$output .= "<form class=\"dropdown_categories\" action=\"". get_bloginfo('url')."\" method=\"get\">";
$output .= $select;
$output .= "<noscript><input type=\"submit\" value=\"View\" /></noscript></form></li>";
echo $output;
	}

// Categories bar chart 

if(function_exists('register_sidebar_widget'))
	register_sidebar_widget(__('Bar Categories'),'neverland_bar_cat');
	
function neverland_bar_cat() {
	global $wpdb;
	$cat_id = "SELECT term_id,taxonomy,count FROM $wpdb->term_taxonomy WHERE taxonomy = 'category' ";
	$cat_id_results = $wpdb->get_results($cat_id);
	$output .= "<li class=\"widget-container\"><h3 class=\"widget-title\">Categories</h3>";
	$output .= "<table class=\"bar-chart\">";
	foreach ($cat_id_results as $cat_id_result) {
		$bar_width = ($cat_id_result->count)*5;
		$output .= "<tr>";
		$output .= "<td class=\"cat_name category-name".$cat_id_result->term_id."\">";
		$output .= "<a href=\"".get_category_link($cat_id_result->term_id)."\">".get_the_category_by_ID($cat_id_result->term_id)."</a></td>";
		$output .= "<td class=\"cat_bar category-". $cat_id_result->term_id . "\" style=\"width:".$bar_width."px\">";
		$output .= $cat_id_result->count ."</td>";
		$output .= "</tr>";
	}
	$output .= "</table></li>";
	echo $output;
	}

// Monthly Archives 

if(function_exists('register_sidebar_widget'))
	register_sidebar_widget(__('Monthly Bar Archives'),'neverland_monthly_archives');

function neverland_monthly_archives() {
	global $wpdb,$wp_locale;
	$monthly_archives = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish'GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC";
	$monthly_archives_results = $wpdb->get_results($monthly_archives);
	$output .= "<li class=\"widget-container\"><h3 class=\"widget-title\">Archives</h3>";
	$output .= "<table class=\"bar-chart\">";
	foreach ($monthly_archives_results as $monthly_archives_result) {
		$bar_width = ($monthly_archives_result->posts)*5;
		$output .= "<tr>";
		$output .= "<td class=\"cat_name archive-name-". $monthly_archives_result->year ."-". $monthly_archives_result->month ."\">";
		$output .= "<a href=\"".get_month_link($monthly_archives_result->year,$monthly_archies_result->month)."\">".$wp_locale->get_month($monthly_archives_result->month).",".$monthly_archives_result->year."</a></td>";
		$output .= "<td class=\"cat_bar archive-".$monthly_archives_result->year."-".$monthly_archives_result->month."\" style=\"width:".$bar_width."px;\">";
		$output .= $monthly_archives_result->posts."</td>";
		$output .= "</tr>";
	}
	$output .= "</table></li>";
	echo $output;
}

// Author Statistics Applet

if(function_exists('register_sidebar_widget'))
	register_sidebar_widget(__('Author Statistics'),'neverland_author_statistics');
	
function neverland_author_statistics() {
    global $wpdb;
	$neverland_user_query = "SELECT ID, user_email, user_url, display_name FROM $wpdb->users";
	$neverland_users = $wpdb->get_results($neverland_user_query);
	
	$output .= "<li class=\"widget-container\"><h3 class=\"widget-title\">Authors</h3>";
	$output .= "<ul>";
	foreach ($neverland_users as $neverland_user) {
		if (count_user_posts($neverland_user->ID) != "0" ){
		$output .= "<li>";
		$output .= get_avatar($neverland_user->user_email,32);
		if ($neverland_user->user_url != "") {
		$output .= "<a title=\"".$neverland_user->display_name."'s blog\" href=\"".$neverland_user->user_url."\">";
		$output .= $neverland_user->display_name;
		$output .= "</a>";
		} else {	
		$output .= $neverland_user->display_name;
		} 
		$output .= "&nbsp;&nbsp;(<a title=\"Posts by".$neverland_uesr->display_name."\" href=\"".get_author_posts_url($neverland_user->ID)."\">".count_user_posts($neverland_user->ID)."</a>)";
		$output .= "</li>";
		}
	}
	$output .= "</ul></li>";
	echo $output;
}