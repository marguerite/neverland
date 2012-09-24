<?php get_header(); ?>

			<div class="content">

<?php if ( have_posts() ) : ?>
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'neverland' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				<?php
				/* Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called loop-search.php and that will be used instead.
				 */
				 get_template_part( 'loop', 'search' );
				?>
<?php else : ?>
				<div id="post-0" class="post no-results not-found">
					<h2 class="entry-title"><?php __( 'Command Not Found', 'neverland' ); ?></h2>
					<div class="entry-content error404">
						<p><?php __( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'neverland' ); ?></p>
					</div><!-- .entry-content -->
				</div><!-- #post-0 -->
<?php endif; ?>
			</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
