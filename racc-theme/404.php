<?php
/**
 * Not found.
 *
 * @package racc
 */

get_header();
get_template_part( 'template-parts/page-hero', null, array( 'title' => racc_t( 'Page not found', 'الصفحة غير موجودة' ), 'kicker' => '404' ) );
?>
<div class="section">
	<div class="container prose">
		<p><?php racc_e( 'The page you are looking for may have moved.', 'ربما تم نقل الصفحة التي تبحث عنها.' ); ?></p>
		<p><a class="btn btn-copper" href="<?php echo esc_url( racc_home_url() ); ?>"><?php racc_e( 'Back to home', 'العودة للرئيسية' ); ?></a></p>
	</div>
</div>
<?php
get_footer();
