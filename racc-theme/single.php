<?php
/**
 * Single post.
 *
 * @package racc
 */

get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page-hero', null, array( 'kicker' => get_the_date() ) );
	?>
	<div class="section">
		<article class="container prose">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'racc-wide', array( 'class' => 'prose-hero' ) );
			}
			the_content();
			?>
		</article>
	</div>
	<?php
endwhile;
get_footer();
