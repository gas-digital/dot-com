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

<section id="content" <?php Avada()->layout->add_style( 'content_style' ); ?>>
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
			<?php if ( 'above' === Avada()->settings->get( 'blog_post_title' ) ) : ?>
				<?php if ( 'below_title' === Avada()->settings->get( 'blog_post_meta_position' ) ) : ?>
					<div class="fusion-post-title-meta-wrap">
				<?php endif; ?>
				<?php $title_size = ( false === avada_is_page_title_bar_enabled( $post->ID ) ? '1' : '2' ); ?>
				<?php echo avada_render_post_title( $post->ID, false, '', $title_size ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				<?php if ( 'below_title' === Avada()->settings->get( 'blog_post_meta_position' ) ) : ?>
					<?php echo avada_render_post_metadata( 'single' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</div>
				<?php endif; ?>
			<?php elseif ( 'disabled' === Avada()->settings->get( 'blog_post_title' ) && Avada()->settings->get( 'disable_date_rich_snippet_pages' ) && Avada()->settings->get( 'disable_rich_snippet_title' ) ) : ?>
				<span class="entry-title" style="display: none;"><?php the_title(); ?></span>
			<?php endif; ?>

			<?php avada_singular_featured_image(); ?>

			<?php if ( 'below' === Avada()->settings->get( 'blog_post_title' ) ) : ?>
				<?php if ( 'below_title' === Avada()->settings->get( 'blog_post_meta_position' ) ) : ?>
					<div class="fusion-post-title-meta-wrap">
				<?php endif; ?>
				<?php $title_size = ( false === avada_is_page_title_bar_enabled( $post->ID ) ? '1' : '2' ); ?>
				<?php echo avada_render_post_title( $post->ID, false, '', $title_size ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				<?php if ( 'below_title' === Avada()->settings->get( 'blog_post_meta_position' ) ) : ?>
					<?php echo avada_render_post_metadata( 'single' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<div class="post-content">

				<?php
					$title_image_style = '';
					$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
					$image = $image[0];
					if($image){
						$title_image_style = 'style="background-color: rgba(0, 0, 0, 0.4); padding: 20% 0px; background-image: url('.$image.'); -webkit-background-size: cover; background-size: cover; height: auto; background-position: center center; background-repeat: no-repeat no-repeat;" data-bg-url="'.$image.'"';
					}
				?>

				<div class="fusion-fullwidth fullwidth-box nonhundred-percent-fullwidth non-hundred-percent-height-scrolling" style="background-color: #ffffff;background-position: center center;background-repeat: no-repeat;padding-top:0px;padding-right:30px;padding-bottom:50px;padding-left:30px;margin-top: 0px;">
					<div class="fusion-builder-row fusion-row ">
						<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_1 fusion-builder-column-1 fusion-one-full fusion-column-first fusion-column-last fusion-blend-mode 1_1" style="margin-top:0px;margin-bottom:0px;">
							<div class="fusion-column-wrapper" <?= ($title_image_style)?$title_image_style:'style="padding: 100px 0 0;"' ?>>
								<div class="fusion-builder-row fusion-builder-row-inner fusion-row ">
									<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_5  fusion-one-fifth fusion-column-first 1_5" style="margin-top: 0px;margin-bottom: 0px;width:20%;width:calc(20% - ( ( 4% + 4% ) * 0.2 ) );margin-right:4%;">
										<div class="fusion-column-wrapper" style="padding: 0px 0px 0px 0px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
										</div>
									</div>
									<div class="fusion-layout-column fusion_builder_column fusion_builder_column_3_5  fusion-three-fifth 3_5" style="margin-top: 0px;margin-bottom: 0px;width:60%;width:calc(60% - ( ( 4% + 4% ) * 0.6 ) );margin-right:4%;">
											<div class="fusion-column-wrapper" style="padding: 0px; -webkit-background-size: cover; background-size: cover; height: auto; background-position: left top; background-repeat: no-repeat no-repeat;" data-bg-url="">
											<style type="text/css">@media only screen and (max-width:840px) {.fusion-title.fusion-title-1{margin-top:0px!important;margin-bottom:15px!important;}}</style>
											<div class="fusion-title title fusion-title-1 fusion-sep-none fusion-title-center fusion-title-size-one fusion-border-below-title" style="margin-top:0px;margin-bottom:30px;">
												<h1 class="title-heading-center" style="margin:0;<?= ($title_image_style)?'color:#ffffff;':'' ?>" data-fontsize="54" data-lineheight="64"><?= $post->post_title ?></h1>
											</div>
										</div>
									</div>
									<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_5  fusion-one-fifth fusion-column-last 1_5" style="margin-top: 0px;margin-bottom: 0px;width:20%;width:calc(20% - ( ( 4% + 4% ) * 0.2 ) );">
										<div class="fusion-column-wrapper" style="padding: 0px 0px 0px 0px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
										</div>
									</div>
								</div>
								<div class="fusion-clearfix"></div>
							</div>
						</div>
					</div>
				</div>
				<?php the_content(); ?>
				<?php fusion_link_pages(); ?>
			</div>

			<?php if ( ! post_password_required( $post->ID ) ) : ?>
				<?php if ( '' === Avada()->settings->get( 'blog_post_meta_position' ) || 'below_article' === Avada()->settings->get( 'blog_post_meta_position' ) || 'disabled' === Avada()->settings->get( 'blog_post_title' ) ) : ?>
					<div class="fusion-fullwidth fullwidth-box nonhundred-percent-fullwidth non-hundred-percent-height-scrolling" style="background-color: #ffffff;background-position: center center;background-repeat: no-repeat;padding-top:0px;padding-right:0px;padding-bottom:50px;padding-left:0px;">
						<div class="fusion-builder-row fusion-row ">
							<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_5 fusion-builder-column-1 fusion-one-fifth fusion-column-first 1_5" style="margin-top:0px;margin-bottom:0px;width:16.8%; margin-right: 4%;">
								<div class="fusion-column-wrapper" style="padding: 0px 0px 0px 0px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
									<div class="fusion-clearfix"></div>
								</div>
							</div>
							<div class="fusion-layout-column fusion_builder_column fusion_builder_column_3_5 fusion-builder-column-2 fusion-three-fifth 3_5" style="margin-top:0px;margin-bottom:0px;width:58.4%; margin-right: 4%;">
								<div class="fusion-column-wrapper" style="padding: 0px; -webkit-background-size: cover; background-size: cover; height: auto; background-position: left top; background-repeat: no-repeat no-repeat;" data-bg-url>
									<?php echo avada_render_post_metadata( 'single' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
								</div>
							</div>
							<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_5 fusion-builder-column-3 fusion-one-fifth fusion-column-last 1_5" style="margin-top:0px;margin-bottom:0px;width:16.8%">
								<div class="fusion-column-wrapper" style="padding: 0px 0px 0px 0px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
									<div class="fusion-clearfix"></div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php do_action( 'avada_before_additional_post_content' ); ?>
				<?php avada_render_social_sharing(); ?>
				<?php $author_info = get_post_meta( $post->ID, 'pyre_author_info', true ); ?>
				<?php if ( ( Avada()->settings->get( 'author_info' ) && 'no' !== $author_info ) || ( ! Avada()->settings->get( 'author_info' ) && 'yes' === $author_info ) ) : ?>
					<section class="about-author">
						<?php ob_start(); ?>
						<?php the_author_posts_link(); ?>
						<?php /* translators: The link. */ ?>
						<?php $title = sprintf( __( 'About the Author: %s', 'Avada' ), ob_get_clean() ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride ?>
						<?php $title_size = ( false === avada_is_page_title_bar_enabled( $post->ID ) ? '2' : '3' ); ?>
						<?php Avada()->template->title_template( $title, $title_size ); ?>
						<div class="about-author-container">
							<div class="avatar">
								<?php echo get_avatar( get_the_author_meta( 'email' ), '72' ); ?>
							</div>
							<div class="description">
								<?php the_author_meta( 'description' ); ?>
							</div>
						</div>
					</section>
				<?php endif; ?>
				<?php avada_render_related_posts( get_post_type() ); // Render Related Posts. ?>

				<?php $post_comments = get_post_meta( $post->ID, 'pyre_post_comments', true ); ?>
				<?php if ( ( Avada()->settings->get( 'blog_comments' ) && 'no' !== $post_comments ) || ( ! Avada()->settings->get( 'blog_comments' ) && 'yes' === $post_comments ) ) : ?>
					<?php comments_template(); ?>
				<?php endif; ?>
				<?php do_action( 'avada_after_additional_post_content' ); ?>
			<?php endif; ?>
		</article>
	<?php endwhile; ?>
</section>
<?php do_action( 'avada_after_content' ); ?>
<?php get_footer(); ?>
