<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package black-pirates
 */

?>

	</div><!-- #content -->


    


</div><!-- /pusher -->
</div><!-- #page  -->
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
                        
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'blackpirates' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'blackpirates' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'blackpirates' ), 'blackpirates', '<a href="http://xwolf.de/" rel="designer">xwolf</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
<?php wp_footer(); ?>

</body>
</html>
