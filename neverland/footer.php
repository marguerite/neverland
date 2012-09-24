<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Neverland
 * @since Neverland 1.0
 */
?>

	<div id="footer">
                <div id="colophon">
			<div id="site-info">
				<a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
				<span>designed by marguerite. Better experience in firefox and webkit.</span>
			</div><!-- #site-info -->

			<div id="site-generator">
				<?php do_action( 'neverland_credits' ); ?>
				<a class="wordpress" href="<?php echo esc_url( __('http://wordpress.org/', 'neverland') ); ?>"
						title="<?php esc_attr_e('Semantic Personal Publishing Platform', 'neverland'); ?>" rel="generator">
					<?php printf('WordPress', 'neverland'); ?>
				</a>
				<a class="cc" href="">
					& <?php __('Creative Commons','neverland');?>
				</a>
				<a class="gimp" href="http://gimp.org">
					& <?php __("GIMP (I'm not using Photoshop).",'neverland');?>
				</a>
			</div><!-- #site-generator -->

		</div><!-- #colophon -->
	</div><!-- #footer -->

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
