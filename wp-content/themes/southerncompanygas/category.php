<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

$currentCategory = get_queried_object();

$post_params = array('post_type'=>'post',
										 'post_status'=>'publish',
										 'posts_per_page'=>-1,
						  		 	 'cat'=>$currentCategory->term_id);

$wpb_all_query = new WP_Query($post_params);

?>
<?php get_header(); ?>

<div class="pattern intro ">
  <div class="copy">
    <p class="hed hed--large">News: <?= $currentCategory->name ?></p>
  </div>
</div>

<?php if ( $wpb_all_query->have_posts() ) : ?>

	<div class="pattern card-group">

		<?php get_template_part( 'templates/news-navigation' ); ?>

		<!-- the loop -->
		<?php
			while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
			$img = get_the_post_thumbnail_url();
			$is_default = strpos($img, 'BG_Darkblue');
			$cat = get_the_category();
			$cat_name = $cat[0]->name;
		?>
				<a href="<?php the_permalink(); ?>" class="card <?php if(!$i) echo "card--mega"; $i++ ?>">
					<div class="card--featured">
						<?php
							if($is_default){
								echo '<img src="/assets/img/news/' .  $cat_name. '.png" />';
							}else {
								echo the_post_thumbnail( 'medium' );
							}
						?>
					</div>
					<div class="card--content">
						<p class="label"><?= the_date(); ?></p>
						<p class="hed"><?php the_title(); ?></p>
					</div>
				</a>
		<?php endwhile; ?>
		<!-- end of the loop -->

	</div>

<?php wp_reset_postdata(); ?>

<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>

<style>
	.pattern.card-group {
		margin-top: 10rem;
	}
</style>
