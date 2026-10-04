<?php
/**
 * Fallback template (blog / archives).
 *
 * @package racc
 */

get_header();
get_template_part( 'template-parts/page-hero', null, array( 'title' => is_home() ? racc_t( 'News', 'الأخبار' ) : wp_strip_all_tags( get_the_archive_title() ) ) );
?>
<div class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="post-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'post-card' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a class="post-card-media" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'racc-card' ); ?></a>
						<?php endif; ?>
						<div class="post-card-body">
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<?php the_excerpt(); ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php racc_e( 'Nothing here yet.', 'لا يوجد محتوى بعد.' ); ?></p>
		<?php endif; ?>
	</div>
</div>
<?php
get_footer();
