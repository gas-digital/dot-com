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

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>

			<div class="post-content">
				<?php
					$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
					$image = $image[0];
				?>

				<div class="pattern split single-post">
					<div class="left">
						<img src="<?= $image ?>" />
					</div>
					<div class="right">
						<div class="copy copy--left">
							<p class="post-categories">
								<?= get_the_category_list(" / "); ?>
							</p>
							<p class="hed hed--large"><?php the_title(); ?></p>
							<p><?php the_excerpt(); ?></p>
						</div>
					</div>
				</div>

				<?php the_content(); ?>
				<?php get_template_part( 'templates/related' ); ?>

				<?php fusion_link_pages(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</section>
<?php do_action( 'avada_after_content' ); ?>
<?php get_footer(); ?>

<style>
p.post-categories {
	display: flex;
	font-size: 1.4rem;
	padding: 0;
}

.post-categories a {
  font-size: 1.4rem;
	margin:0 1rem;
}

.post-categories a:first-child {
	margin-left: 0;
}

.split.single-post {
	margin-bottom: 0;
}

.post-content {
	margin-bottom: 0rem;
}

.fusion-layout-column {
	max-width: 80rem;
}
</style>
