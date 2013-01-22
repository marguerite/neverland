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
	return 500;
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
			<em class="comment-awaiting-moderation"><?php __( 'Your comment is awaiting moderation.', 'neverland' ); ?></em>
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
		<p><?php __( 'Pingback:', 'neverland' ); ?> <?php comment_author_link(); ?></p>
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
$output .= "<li class=\"widget-container\"><h3 class=\"widget-title\">".__("What's up buddy?",'neverland')."</h3>";
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
	$avatar_defaults[$newavatar] = __('KDE default','neverland');
	return $avatar_defaults;
	}

// Dropdown Categories

if(function_exists('register_sidebar_widget'))
	register_sidebar_widget(__('Dropdown Categories'),'neverland_dropdown_categories');

function neverland_dropdown_categories() {
$select = wp_dropdown_categories('show_option_none=Select Category&show_count=1&orderby=name&echo=0&selected=6');
$select = preg_replace("#<select([^>]*)>#", "<select$1 onchange='return this.form.submit()'>", $select);
$output .= "<li class=\"widget-container\"><h3 class=\"widget-title\">".__('Categories','neverland')."</h3>";
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
	$output .= "<li class=\"widget-container\"><h3 class=\"widget-title\">".__('Categories','neverland')."</h3>";
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
	$output .= "<li class=\"widget-container\"><h3 class=\"widget-title\">".__('Archives','neverland')."</h3>";
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

	$output .= "<li class=\"widget-container\"><h3 class=\"widget-title\">".__('Authors','neverland')."</h3>";
	$output .= "<ul>";
	foreach ($neverland_users as $neverland_user) {
		if (count_user_posts($neverland_user->ID) != "0" ){
		$output .= "<li>";
		$output .= get_avatar($neverland_user->user_email,32);
		if ($neverland_user->user_url != "") {
		$output .= "<a title=\"".$neverland_user->display_name.__("'s blog",'neverland')."\" href=\"".$neverland_user->user_url."\">";
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

/* More Options for Authors */
add_filter('user_contactmethods','neverland_add_contact_fields');

function neverland_add_contact_fields($contactmethods) {
	$contactmethods['twitter'] = 'Twitter';
	$contactmethods['kdelook'] = 'kde-look(apps).org';
	$contactmethods['identica'] = 'Identi.ca';
	$contactmethods['plurk'] = 'Plurk';
	$contactmethods['googleplus_displayname'] = 'Google+ DisplayName';
	$contactmethods['googleplus_url'] = 'Google+ URL';
	$contactmethods['facebook_displayname'] = 'Facebook DisplayName';
	$contactmethods['facebook_url'] = 'Facebook URL';
	$contactmethods['weibo_name'] = 'Sina Weibo Name';
	$contactmethods['weibo_url'] = 'Sina Weibo URL';
	$contactmethods['douban_name'] = 'Douban Name';
	$contactmethods['douban_url'] = 'Douban URL';
	$contactmethods['v2ex'] = 'V2EX';
	$contactmethods['github'] = 'Github';
	$contactmethods['obs'] = 'OBS';
	$contactmethods['dribbble'] = 'Dribbble';
	$contactmethods['fiveoopx'] = '500px';
	$contactmethods['tumblr'] = 'Tumblr';
	$contactmethods['deviantart'] = 'DeviantArt';
	$contactmethods['skype'] = 'Skype';
	$contactmethods['imessage'] = 'iMessage';
	$contactmethods['weixin'] = 'WeiXin';
	$contactmethods['renren_name'] = 'RenRen Name';
	$contactmethods['renren_url'] = 'RenRen URL';
	$contactmethods['custom_servicename'] = 'Custom Service Name';
	$contactmethods['custom_name'] = 'Custom Name';
	$contactmethods['custom_url'] = 'Custom URL';
	$contactmethods['other'] = 'Other';
	
	unset($contactmethods['yim']);
	unset($contactmethods['aim']);
	
	return $contactmethods;
}

/* Output Improved Author Information */

function neverland_author_information() {
	
	$output .= '<div id="entry-author-info">';
	
		$output .= '<div id="author-avatar">';
							
			$output .= get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'neverland_author_bio_avatar_size', 72 ) );
	
			if  (get_the_author_meta('first_name') && get_the_author_meta('last_name')) {
		
				$output .= '<span><a href="mailto://'.get_the_author_meta('user_email').'" title="Email'.get_the_author_meta('nickname').'">'.get_the_author_meta('first_name').'·'.get_the_author_meta('last_name').'</a></span>';

			} else {
				$output .= '<span><a href="mailto://'.get_the_author_meta('user_email').'" title="Email'.get_the_author_meta('nickname').'">'.get_the_author_meta('nickname').'</a></span>';
			} 

		$output .= '</div><!-- #author-avatar -->';
	
		$output .= '<div id="author-description">';
	
			$output .= '<ul id="author-contacts">';
			
			
				if (get_the_author_meta('user_url')) {
	
					$output .= '<li class="author-contacts-item"><a href="'.get_the_author_meta('user_url').'" title="'.get_the_author_meta('nickname').'\'s Blog" style="background:url('.get_the_author_meta('user_url').'/favicon.ico) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('user_url').'</a></li>';
		
				}
	
				if (get_the_author_meta('twitter')) {
	
					$output .= '<li class="author-contacts-item"><a href="https://twitter.com/#!/'.get_the_author_meta('twitter').'" title="Follow '.get_the_author_meta('twitter').' on Twitter" style="background:url(https://twitter.com/favicon.ico) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('twitter').'</a></li>';
		
				}
				
				if (get_the_author_meta('kdelook')) {
					
					$output .= '<li class="author-contacts-item"><a href="http://kde-look.org/usermanager/search.php?username='.get_the_author_meta('kdelook').'" title="Follow '.get_the_author_meta('kdelook').' on kde-look(apps).org" style="background:url(http://ikde.org/wp-content/themes/neverland/favicon.ico) no-repeat center left; padding: 18px;">'.get_the_author_meta('kdelook').'</a></li>';
				
				}
				
				if (get_the_author_meta('identica')) {
	
					$output .= '<li class="author-contacts-item"><a href="https://identi.ca/'.get_the_author_meta('identica').'" title="Follow '.get_the_author_meta('identica').' on Identi.ca" style="background:url(https://identi.ca/favicon.ico) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('identica').'</a></li>';
		
				}
				
				if (get_the_author_meta('plurk')) {
	
					$output .= '<li class="author-contacts-item"><a href="https://plurk.com/'.get_the_author_meta('plurk').'" title="Follow '.get_the_author_meta('plurk').' on Plurk" style="background:url(https://plurk.com/favicon.ico) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('plurk').'</a></li>';
		
				}	
				
				if (get_the_author_meta('googleplus_url') && get_the_author_meta('googleplus_displayname')) {
	
					$output .= '<li class="author-contacts-item"><a href="'.get_the_author_meta('googleplus_url').'" title="Follow '.get_the_author_meta('googleplus_displayname').' on Google+" style="background:url(https://ssl.gstatic.com/s2/oz/images/favicon.ico) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('googleplus_displayname').'</a></li>';
		
				}			

				if (get_the_author_meta('facebook_url') && get_the_author_meta('facebook_displayname')) {
	
					$output .= '<li class="author-contacts-item"><a href="'.get_the_author_meta('facebook_url').'" title="Follow '.get_the_author_meta('facebook_displayname').' on Facebook" style="background:url(https://facebook.com/favicon.ico) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('facebook_displayname').'</a></li>';
		
				}
				
				if (get_the_author_meta('weibo_url') && get_the_author_meta('weibo_name')) {
	
					$output .= '<li class="author-contacts-item"><a href="'.get_the_author_meta('weibo_url').'" title="Follow '.get_the_author_meta('weibo_name').' on Sina Weibo" style="background:url(http://www.4001010100.com/ENG/images/weibo_favicon.png) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('weibo_name').'</a></li>';
		
				}
				
				if (get_the_author_meta('douban_url') && get_the_author_meta('douban_name')) {
	
					$output .= '<li class="author-contacts-item"><a href="'.get_the_author_meta('douban_url').'" title="Follow '.get_the_author_meta('douban_name').' on Douban" style="background:url(http://douban.com/favicon.ico) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('douban_name').'</a></li>';
		
				}

				if (get_the_author_meta('v2ex')) {
	
					$output .= '<li class="author-contacts-item"><a href="http://v2ex.com/member/'.get_the_author_meta('v2ex').'" title="Follow '.get_the_author_meta('v2ex').' on V2EX.com" style="background:url(http://v2ex.com/favicon.ico) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('v2ex').'</a></li>';
		
				}
				
				if (get_the_author_meta('github')) {
	
					$output .= '<li class="author-contacts-item"><a href="https://github.com/'.get_the_author_meta('github').'" title="Fork '.get_the_author_meta('github').' on Github" style="background:url(http://blog.madpython.com/wp-content/uploads/2010/11/github_icon_32-e1288879601776.png) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('github').'</a></li>';
		
				}
				
				if (get_the_author_meta('obs')) {
	
					$output .= '<li class="author-contacts-item"><a href="https://build.opensuse.org/project/show?project=home%3A'.get_the_author_meta('obs').'" title="'.get_the_author_meta('obs').'\'s Home Repository on OBS" style="background:url(https://build.opensuse.org/favicon.ico) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('obs').'</a></li>';
		
				}
				
				if (get_the_author_meta('dribbble')) {
	
					$output .= '<li class="author-contacts-item"><a href="http://dribbble.com/'.get_the_author_meta('dribbble').'" title="Follow '.get_the_author_meta('dribbble').' on Dribbble" style="background:url(http://icons.iconarchive.com/icons/areskub/seize/16/Dribbble-icon.png) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('dribbble').'</a></li>';
		
				}
				
				if (get_the_author_meta('fiveoopx')) {
	
					$output .= '<li class="author-contacts-item"><a href="http://500px.com/'.get_the_author_meta('fiveoopx').'" title="Follow '.get_the_author_meta('fiveoopx').' on 500px.com" style="background:url(http://500px.com/favicon.ico) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('fiveoopx').'</a></li>';
		
				}
				
				if (get_the_author_meta('tumblr')) {
	
					$output .= '<li class="author-contacts-item"><a href="http://www.tumblr.com/blog/'.get_the_author_meta('tumblr').'" title="Follow '.get_the_author_meta('tumblr').' on Tumblr" style="background:url(http://icons.iconarchive.com/icons/dakirby309/windows-8-metro/16/Web-Tumblr-alt-Metro-icon.png) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('tumblr').'</a></li>';
		
				}
				
				if (get_the_author_meta('deviantart')) {
	
					$output .= '<li class="author-contacts-item"><a href="http://'.get_the_author_meta('deviantart').'.deviantart.com" title="Follow '.get_the_author_meta('deviantart').' on DeviantArt" style="background:url(http://deviantart.com/favicon.ico) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('deviantart').'</a></li>';
		
				}
				
				if (get_the_author_meta('skype')) {
	
					$output .= '<li class="author-contacts-item"><a href="callto://'.get_the_author_meta('skype').'" title="Call '.get_the_author_meta('skype').' by Skype" style="background:url(http://www.kibaoij.ru/app/aiken/themes/v7/i/skype_16x16.gif) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('skype').'</a></li>';
		
				}
				
				if (get_the_author_meta('imessage')) {
	
					$output .= '<li class="author-contacts-item" style="background:url(http://t3.gstatic.com/images?q=tbn:ANd9GcSZlQhn0pRrS5Jt1MbDm94NhSN5Wk0ujIbajJnmQtCynjknALpZlfKu_NI) no-repeat center left; padding-left: 18px">'.get_the_author_meta('imessage').'</li>';
		
				}
				
				if (get_the_author_meta('weixin')) {
	
					$output .= '<li class="author-contacts-item" style="background:url(http://www.maimaibao.com/newresource/images/icon/icon_weixin17x17.gif) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('weixin').'</li>';
		
				}
	
				if (get_the_author_meta('renren_url') && get_the_author_meta('renren_name')) {
	
					$output .= '<li class="author-contacts-item"><a href="'.get_the_author_meta('renren_url').'" title="Follow '.get_the_author_meta('renren_name').' on RenRen" style="background:url(http://www.chinadaily.com.cn/image/ico_renren.gif) no-repeat center left; padding-left: 18px;">'.get_the_author_meta('renren_name').'</a></li>';
		
				}
				
				if (get_the_author_meta('custom_url') && get_the_author_meta('custom_name') && get_the_author_meta('custom_servicename')) {
	
					$output .= '<li class="author-contacts-item"><a href="'.get_the_author_meta('custom_url').'" title="Follow '.get_the_author_meta('custom_name').' on '.get_the_author_meta('custom_servicename').'">'.get_the_author_meta('custom_name').'</a></li>';
		
				}

				if (get_the_author_meta('other')) {
	
					$output .= '<li class="author-contacts-item"><a href="'.get_the_author_meta('other').'">'.get_the_author_meta('other').'</a></li>';
		
				}
	
			$output .= '</ul>';
	
			if (get_the_author_meta('description')) {
							
				$output .= '<div>'.get_the_author_meta( 'description' ).'</div>';
						
			}

		$output .= '</div><!-- #author-description	-->';

	$output .= '</div><!-- #entry-author-info -->';

	echo $output;
}
