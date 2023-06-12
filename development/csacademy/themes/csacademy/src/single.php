<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package CS_Academy
 */

get_header();
?>
<div class="grid-container">
	<div class="grid-x grid-margin-x">
		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div class="cell medium-9 cs-content-wrapper">
		<?php else : ?>
		<div class="cell cs-content-wrapper">
		<?php endif; ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
<div class="cell medium-3 cs-content-wrapper">
	<?php get_sidebar(); ?>
</div>
<?php endif; ?>
</div>
</div>
<?php
get_footer();
