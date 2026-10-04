<?php
/**
 * Projects portfolio with sector filter.
 *
 * @package racc
 */

$racc_projects = racc_get_projects( 9 );
$racc_names    = racc_sector_names();
$racc_used     = array_unique( array_filter( wp_list_pluck( $racc_projects, 'sector' ) ) );
$racc_archive  = get_post_type_archive_link( 'racc_project' );
$racc_has_real = $racc_projects && ! $racc_projects[0]['sample'];
?>
<section class="section projects" id="projects">
	<div class="container">
		<header class="section-head section-head-row reveal">
			<div>
				<p class="section-kicker"><?php racc_e( 'Our projects', 'مشاريعنا' ); ?></p>
				<h2 class="section-title"><?php racc_e( 'Work that shapes skylines and communities', 'أعمال ترسم ملامح المدن والمجتمعات' ); ?></h2>
			</div>
			<?php if ( $racc_has_real && $racc_archive ) : ?>
				<a class="link-arrow" href="<?php echo esc_url( $racc_archive ); ?>"><?php racc_e( 'All projects', 'جميع المشاريع' ); ?><?php echo racc_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
			<?php endif; ?>
		</header>

		<?php if ( count( $racc_used ) > 1 ) : ?>
			<div class="filters" role="group" aria-label="<?php echo esc_attr( racc_t( 'Filter by sector', 'تصفية حسب القطاع' ) ); ?>" data-filters>
				<button type="button" class="filter is-active" data-filter="*" aria-pressed="true"><?php racc_e( 'All', 'الكل' ); ?></button>
				<?php foreach ( $racc_used as $racc_key ) : ?>
					<button type="button" class="filter" data-filter="<?php echo esc_attr( $racc_key ); ?>" aria-pressed="false"><?php echo esc_html( isset( $racc_names[ $racc_key ] ) ? $racc_names[ $racc_key ] : $racc_key ); ?></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="project-grid" data-projects>
			<?php foreach ( $racc_projects as $racc_p ) : ?>
				<?php $racc_tag = $racc_p['url'] ? 'a' : 'div'; ?>
				<article class="project-card reveal" data-sector="<?php echo esc_attr( $racc_p['sector'] ); ?>">
					<<?php echo $racc_tag; // phpcs:ignore WordPress.Security.EscapeOutput ?> class="project-link"<?php echo $racc_p['url'] ? ' href="' . esc_url( $racc_p['url'] ) . '"' : ''; ?>>
						<div class="project-media">
							<?php racc_img( $racc_p['image'], $racc_p['title'] ); ?>
						</div>
						<div class="project-body">
							<?php if ( $racc_p['sector'] && isset( $racc_names[ $racc_p['sector'] ] ) ) : ?>
								<span class="project-sector"><?php echo esc_html( $racc_names[ $racc_p['sector'] ] ); ?></span>
							<?php endif; ?>
							<h3 class="project-title"><?php echo esc_html( $racc_p['title'] ); ?></h3>
							<?php if ( $racc_p['location'] ) : ?>
								<span class="project-loc"><?php echo racc_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $racc_p['location'] ); ?></span>
							<?php endif; ?>
						</div>
					</<?php echo $racc_tag; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
				</article>
			<?php endforeach; ?>
		</div>

		<?php if ( ! $racc_has_real && current_user_can( 'edit_posts' ) ) : ?>
			<p class="admin-note"><?php echo wp_kses_post( 'Admin note: these are sample projects. Add your real projects under <a href="' . esc_url( admin_url( 'post-new.php?post_type=racc_project' ) ) . '">Projects → Add project</a> and they will replace the samples automatically. (Only logged-in editors see this note.)' ); ?></p>
		<?php endif; ?>
	</div>
</section>
