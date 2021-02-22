<?php
/*
 * Template Name: Home
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

$post_params = array('post_type'=>'post',
										 'post_status'=>'publish',
										 'posts_per_page'=>4);

$wpb_all_query = new WP_Query($post_params);

$i = 0;
?>
<?php get_header(); ?>

<?php if ( $wpb_all_query->have_posts() ) : ?>

  <div class="pattern card-group">

		<!-- the loop -->
		<?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
				<a href="<?php the_permalink(); ?>" class="card <?php if($i%2 ) echo "card--large" ?>">
					<div class="card--featured"><?= the_post_thumbnail( 'medium' ); ?></div>
					<div class="card--content">
						<p class="label"><?= the_date(); ?></p>
						<p class="hed"><?php the_title(); ?></p>
					</div>
				</a>
		<?php
		 		$i = $i + 1;
				endwhile;
	  ?>
		<!-- end of the loop -->

		<a href="/environment" class="card card--medium">
			<div class="card--featured">
				<img src="/environment/img/clean-horz@3x.png" />
			</div>
			<div class="card--content">
				<p class="label">Environment</p>
				<p class="hed">Everyone deserves energy that is not only clean, but also safe, reliable and affordable. </p>
			</div>
		</a>

	</div>

  <div class="pattern content">
    <p>At Southern Company Gas, we are a dedicated team of innovators, engineers, thinkers and creators. Driven by ingenuity, we fuel the possibilities necessary for building the future of energy.</p>

    <p>We hold ourselves accountable to our customers first and foremost. To that end, we’re committed to delivering clean, safe, reliable and affordable energy for our customers, our neighbors and our communities.</p>
  </div>



	<div href="/community" class="image-break pattern dark" style="background-image:url('https://southerncompanygas.com/wp-content/uploads/2019/10/scgco-what-is-natural-gas.jpg');">
    <div class="dimmer"></div>
    <div class="copy">
      <p class="label">Renewable Natural Gas</p>
      <p class="hed hed--large">What is natrual gas</p>
      <p>Natural gas is the earth’s cleanest fossil fuel and is colorless and odorless in its natural state. It is composed of four hydrocarbon atoms and one carbon atom (CH4 or methane). Learn more:</p>
			<?php get_template_part( 'templates/mailchimp-form' ); ?>
    </div>
  </div>

  <div class="pattern content">
    <p>Our service starts with listening to – and learning from – our customers so we fully understand how to best meet their energy needs, and we take pride in our ability to provide them with clear, open and honest communication.</p>
  </div>

  <div class="pattern card-group">
    <a href="" class="card card--image card--mega" style="background-image:url(https://southerncompanygas.com/wp-content/uploads/2019/09/socogas-history.jpg);">
      <div class="card--content">
        <p class="hed">150 years of service</p>
        <p>Uncover our legacy </p>
      </div>
    </a>
    <a href="/about-us/leadership" class="card card--large">
			<div class="card--featured">
				<img src="https://southerncompanygas.com/wp-content/uploads/2019/12/kimberly-s-green-leadership.jpg" />
			</div>
      <div class="card--content">
        <p class="hed">Leading us into tomorrow</p>
        <p>Learn about our leaders </p>
      </div>
    </a>
  </div>

	<div class="pattern companies">
		<div class="copy">
			<h2 class="hed hed--large">A family of companies</h2>
		</div>

		<img src="https://www.fueluponthis.com/design-system/img/companies-screenshot.png" />
	</div>

  <div href="/community" class="image-break pattern dark" style="background-image:url('https://southerncompanygas.com/wp-content/uploads/2019/12/soco-community.jpg');">
    <div class="dimmer"></div>
    <div class="copy">
      <p class="label">Community</p>
      <p class="hed hed--large">Giving back to those we serve</p>
      <p>We have been proud members of the communities we serve for more than 160 years. Join our community:</p>
			<?php get_template_part( 'templates/mailchimp-form' ); ?>
    </div>
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

	.companies {
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;

		img {
			width: 100%;
		}
	}
</style>
