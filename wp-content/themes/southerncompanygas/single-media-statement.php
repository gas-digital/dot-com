<?php
/**
 * Template used for single posts and other post-types
 * that don't have a specific template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); ?>

<header id="post-header" style="padding-top: 8%; margin-bottom: 50px;" class="media-statement-update">
	<?php $title_size = ( false === avada_is_page_title_bar_enabled( $post->ID ) ? '1' : '2' ); ?>
	<?php echo avada_render_post_title( $post->ID, false, '', $title_size ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	<div class="media-update-meta">
		<?php
			
			$settings = array(
				'post_meta' => 'yes',
				'post_meta_type' => false,
				'post_meta_date' => true,
				'post_meta_cats' => false
			);
			
			echo avada_render_post_metadata( 'single', $settings ); // phpcs:ignore WordPress.Security.EscapeOutput
		?>
	</div>
</header>
<section id="content" style="float: left;" class="media-statement">
	<?php if ( fusion_get_option( 'blog_pn_nav' ) ) : ?>
		<div class="single-navigation clearfix">
			<?php previous_post_link( '%link', esc_attr__( 'Previous', 'Avada' ) ); ?>
			<?php next_post_link( '%link', esc_attr__( 'Next', 'Avada' ) ); ?>
		</div>
	<?php endif; ?>

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
			<?php $full_image = ''; ?>
			<?php avada_singular_featured_image(); ?>

			<div class="post-content">
				<?php the_content(); ?>
				<?php fusion_link_pages(); ?>
			</div>

			<?php if ( ! post_password_required( $post->ID ) ) : ?>
				<?php do_action( 'avada_before_additional_post_content' ); ?>
				<?php do_action( 'avada_after_additional_post_content' ); ?>
			<?php endif; ?>
		</article>
	<?php endwhile; ?>
</section>
<?php do_action( 'avada_after_content' ); ?>
<?php get_footer(); ?>
