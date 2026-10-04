<?php
/**
 * Projects archive (/projects/).
 *
 * @package racc
 */

get_header();
get_template_part( 'template-parts/page-hero', null, array( 'title' => racc_t( 'Our projects', 'مشاريعنا' ), 'kicker' => racc_t( 'Portfolio', 'أعمالنا' ) ) );
$racc_names = racc_sector_names();
?>
<div class="section">
	<div class="container">
		<div class="project-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				$racc_id     = get_the_ID();
				$racc_sector = racc_meta( $racc_id, 'sector' );
				?>
				<article class="project-card">
					<a class="project-link" href="<?php the_permalink(); ?>">
						<div class="project-media"><?php racc_img( get_the_post_thumbnail_url( $racc_id, 'racc-card' ), get_the_title() ); ?></div>
						<div class="project-body">
							<?php if ( isset( $racc_names[ $racc_sector ] ) ) : ?>
								<span class="project-sector"><?php echo esc_html( $racc_names[ $racc_sector ] ); ?></span>
							<?php endif; ?>
							<h2 class="project-title"><?php echo esc_html( racc_t( get_the_title(), racc_meta( $racc_id, 'title_ar' ) ) ); ?></h2>
							<?php $racc_loc = racc_t( racc_meta( $racc_id, 'location_en' ), racc_meta( $racc_id, 'location_ar' ) ); ?>
							<?php if ( $racc_loc ) : ?>
								<span class="project-loc"><?php echo racc_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $racc_loc ); ?></span>
							<?php endif; ?>
						</div>
					</a>
				</article>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination(); ?>
	</div>
</div>
<?php
get_footer();
