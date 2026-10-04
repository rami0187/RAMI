<?php
/**
 * Default page.
 *
 * @package racc
 */

get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page-hero' );
	?>
	<div class="section">
		<div class="container prose">
			<?php the_content(); ?>
		</div>
	</div>
	<?php
endwhile;
get_footer();
