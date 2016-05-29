<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package blackpirates
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
     <div class="row">
	<header class="entry-header col-md-4">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
        <div class="col-md-8">
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
                    <?php
                            edit_post_link(
                                    sprintf(
                                            /* translators: %s: Name of current post */
                                            esc_html__( 'Edit %s', 'blackpirates' ),
                                            the_title( '<span class="screen-reader-text">"', '"</span>', false )
                                    ),
                                    '<span class="edit-link">',
                                    '</span>'
                            );
                    ?>
            </footer><!-- .entry-footer -->
        </div>
</article><!-- #post-## -->

