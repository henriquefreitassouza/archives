<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CS_Academy
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="cs-footer">
		<div class="cs-footer__about">
			<div class="grid-container">
				<div class="grid-x">
					<div class="cell medium-3">
						<div class="cs-footer__about-text">
							<?= get_theme_mod( 'footer_about_setting' ); ?>
						</div>
					</div>
					<nav class="cell medium-offset-3 medium-6 cs-footer__navigation">
						<?php
						wp_nav_menu( array(
							'theme_location' => 'footer-menu',
							'menu_id'        => 'cs-footer-menu',
							'menu_class'		 => 'vertical menu',
							'container'			 => '',
							'items_wrap'     => '<ul class="%2$s">%3$s</ul>'
						) );
						?>
					</nav>
				</div>
			</div>
		</div>
		<div class="cs-footer__copyright">
			<div class="grid-container">
				<div class="grid-x">
					<div class="cell">
						<span><?= get_theme_mod( 'footer_note_setting' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<script>$(document).foundation();</script>
</body>
</html>
