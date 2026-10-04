<?php
/**
 * Single project.
 *
 * @package racc
 */

get_header();
while ( have_posts() ) :
	the_post();
	$racc_id      = get_the_ID();
	$racc_names   = racc_sector_names();
	$racc_sector  = racc_meta( $racc_id, 'sector' );
	$racc_content = racc_is_ar() ? racc_meta( $racc_id, 'content_ar' ) : '';
	get_template_part(
		'template-parts/page-hero',
		null,
		array(
			'title'  => racc_t( get_the_title(), racc_meta( $racc_id, 'title_ar' ) ),
			'kicker' => isset( $racc_names[ $racc_sector ] ) ? $racc_names[ $racc_sector ] : racc_t( 'Project', 'مشروع' ),
		)
	);
	$racc_facts = array_filter(
		array(
			racc_t( 'Location', 'الموقع' ) => racc_t( racc_meta( $racc_id, 'location_en' ), racc_meta( $racc_id, 'location_ar' ) ),
			racc_t( 'Client', 'العميل' )   => racc_t( racc_meta( $racc_id, 'client_en' ), racc_meta( $racc_id, 'client_ar' ) ),
			racc_t( 'Year', 'السنة' )      => racc_meta( $racc_id, 'year' ),
		)
	);
	?>
	<div class="section">
		<div class="container project-single">
			<div class="prose">
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'racc-wide', array( 'class' => 'prose-hero' ) );
				}
				if ( $racc_content ) {
					echo wp_kses_post( wpautop( $racc_content ) );
				} else {
					the_content();
				}
				?>
			</div>
			<?php if ( $racc_facts ) : ?>
				<aside class="project-facts">
					<dl>
						<?php foreach ( $racc_facts as $racc_k => $racc_v ) : ?>
							<dt><?php echo esc_html( $racc_k ); ?></dt>
							<dd><?php echo esc_html( $racc_v ); ?></dd>
						<?php endforeach; ?>
					</dl>
					<a class="btn btn-copper btn-block" href="<?php echo esc_url( racc_home_url() ); ?>#contact"><?php racc_e( 'Discuss a similar project', 'ناقش مشروعاً مماثلاً' ); ?></a>
				</aside>
			<?php endif; ?>
		</div>
	</div>
	<?php
endwhile;
get_footer();
