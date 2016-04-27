<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package blackpirates
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
	<header class="entry-header span4">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php blackpirates_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
         <div class="span8">
            <div class="entry-content">
                    <?php
                            the_content( sprintf(
                                    /* translators: %s: Name of current post. */
                                    wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'blackpirates' ), array( 'span' => array( 'class' => array() ) ) ),
                                    the_title( '<span class="screen-reader-text">"', '"</span>', false )
                            ) );
                    ?>

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
