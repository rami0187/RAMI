<?php
/**
 * Inspirational band.
 *
 * @package racc
 */

$racc_c = racc_copy_defaults();
?>
<section class="vision" aria-label="<?php echo esc_attr( racc_t( 'Our commitment', 'التزامنا' ) ); ?>">
	<div class="vision-media" aria-hidden="true">
		<?php racc_img( racc_image( 'vision', 'island_mosque', 2000 ), '' ); ?>
	</div>
	<div class="container vision-inner reveal">
		<span class="vision-mark" aria-hidden="true">“</span>
		<p class="vision-quote"><?php echo esc_html( racc_mod( 'racc_vision_quote', $racc_c['vision_quote'] ) ); ?></p>
		<ul class="vision-points">
			<li><?php echo racc_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php racc_e( 'Saudi Building Code (SBC) compliance', 'الامتثال لكود البناء السعودي' ); ?></li>
			<li><?php echo racc_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php racc_e( 'International engineering standards', 'المعايير الهندسية العالمية' ); ?></li>
			<li><?php echo racc_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php racc_e( 'Decades of strategic-project experience', 'عقود من الخبرة في المشاريع الإستراتيجية' ); ?></li>
		</ul>
	</div>
</section>
