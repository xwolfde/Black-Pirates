<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package blackpirates
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
     <div class="row">
	<header class="entry-header span3">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php blackpirates_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
        <div class="span9">
            <div class="entry-content">
                    <?php the_content(); ?>
                    <?php
                            wp_link_pages( array(
                                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blackpirates' ),
                                    'after'  => '</div>',
                            ) );
                    ?>
            </div><!-- .entry-content -->

            <footer class="entry-footer">
                    <?php blackpirates_entry_footer(); ?>
            </footer><!-- .entry-footer -->
         </div>
        </div> 
</article><!-- #post-## -->

