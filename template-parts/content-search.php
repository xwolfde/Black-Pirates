<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package blackpirates
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="row">
        <header class="entry-header col-md-4">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php blackpirates_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
         <div class="col-md-8">
            <div class="entry-summary">
                    <?php the_excerpt(); ?>
            </div><!-- .entry-summary -->

            <footer class="entry-footer">
                    <?php blackpirates_entry_footer(); ?>
            </footer><!-- .entry-footer -->
          </div>
           </div>
</article><!-- #post-## -->

