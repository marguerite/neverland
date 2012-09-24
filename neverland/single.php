<?php get_header(); ?>

			<div class="content">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<h1 class="entry-title"><?php the_title(); ?></h1>

					<div class="entry-utility">
						<?php __('By','neverland');?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="View all posts by <?php the_author();?>"><abbr><?php the_author(); ?></abbr></a> |
						<?php __('Published','neverland');?> <abbr><?php the_date() ?></abbr>
						<?php edit_post_link( __( '| Edit', 'neverland' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-utility -->

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'neverland' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->

				</div><!-- #post-## -->

				<div class="entry-utility">
						<?php if (the_tags()); ?>
				</div>
<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
					<div id="entry-author-info">
						<div id="author-avatar">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'neverland_author_bio_avatar_size', 60 ) ); ?>
						</div><!-- #author-avatar -->
						<div id="author-description">
							<h2><?php printf( esc_attr__( 'About %s', 'neverland' ), get_the_author() ); ?></h2>
							<?php the_author_meta( 'description' ); ?>
							<div id="author-link">
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
									<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'neverland' ), get_the_author() ); ?>
								</a>
							</div><!-- #author-link	-->
						</div><!-- #author-description -->
					</div><!-- #entry-author-info -->
<?php endif; ?>

				<div class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'neverland' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'neverland' ) . '</span>' ); ?></div>
				</div><!-- #nav-below -->

				<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
