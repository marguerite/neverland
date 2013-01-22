<?php get_header(); ?>

<div class="content">

<?php
	/* Queue the first post, that way we know who
	 * the author is when we try to get their name,
	 * URL, description, avatar, etc.
	 *
	 * We reset this later so we can run the loop
	 * properly with a call to rewind_posts().
	 */
	if ( have_posts() )
		the_post();
?>

	<h1 class="page-title author">
		
		<?php printf( __( '%s\'s column', 'neverland' ), "<span class='vcard'><a class='url' href='" . get_author_posts_url( get_the_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_the_author() ) . "' rel='me'>" . get_the_author() . "</a></span>" ); ?>

	</h1>

<?php /* Improved Author Information */ ?>
				
<?php neverland_author_information(); ?>

<ul id="author-pinterest">
<?php
	/* Since we called the_post() above, we need to
	 * rewind the loop back to the beginning that way
	 * we can run the loop properly, in full.
	 */
	rewind_posts();

	/* Run the loop for the author archive page to output the authors posts
	 * If you want to overload this in a child theme then include a file
	 * called loop-author.php and that will be used instead.
	 */
	 get_template_part( 'loop', 'author' );
?>
<!-- the other </ul> is at the end of loop.php to avoid including navigation
	bar -->
			
</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
