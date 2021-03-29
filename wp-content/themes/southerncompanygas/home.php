<?php
/*
 * Template Name: Home
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

$post_params = array('post_type'=>'post',
										 'post_status'=>'publish',
										 'posts_per_page'=>1);

$wpb_all_query = new WP_Query($post_params);

$i = 0;
?>
<?php get_header(); ?>

<div class="pattern split" style="background-color: black; margin: 0 auto;">
  <div class="left">
    <div class="card card--large">
      <div class="card--featured">
        <iframe width="100%" height="400" src="https://www.youtube.com/embed/XoB8NlCldTQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
      <div class="card--content">
        <p class="label">On January 30, 2019</p>
        <p class="hed">Polar vortex sends temperatures to -51F </p>
        <p>Nicor Gas delivered on its promise of providing safe, reliable gas to its customers.</p>
      </div>
    </div>
  </div>
  <div class="right">
    <div class="copy copy--left dark">
      <p class="hed hed--large">Employees prepare to brave the chill to keep customers safe, warm</p>
      <p> As a potent blast of cold air continues to descend from the Arctic into much of the country, our teams at Nicor Gas, Virginia Natural Gas, Atlanta Gas Light and Chattanooga Gas continue to work around-the-clock to keep customers safe and warm.</p>
    </div>
  </div>
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

<?php if ( $wpb_all_query->have_posts() ) : ?>

  <div class="pattern card-group">


		<!-- the loop -->
		<?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
				<a href="<?php the_permalink(); ?>" class="card <?php if($i == 0) echo "card--mega" ?>">
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
      <p class="hed hed--large">What is natural gas?</p>
      <p>Natural gas is the earth’s cleanest fossil fuel and is colorless and odorless in its natural state. It is composed of four hydrocarbon atoms and one carbon atom (CH4 or methane). Learn more:</p>
			<?php get_template_part( 'templates/mailchimp-form' ); ?>
    </div>
  </div>

  <div class="pattern content">
    <p>Our service starts with listening to – and learning from – our customers so we fully understand how to best meet their energy needs, and we take pride in our ability to provide them with clear, open and honest communication.</p>
  </div>

	<div class="pattern companies">
		<div class="copy">
			<h2 class="hed hed--large">A family of companies</h2>
		</div>

		<div class="grid">
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Alabama Power</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Southern Linc</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Southern Company Gas</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Virginia Natural Gas</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Georgia Power</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Southern Nuclear</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Atlanta Gas Light</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Gulf Power</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Southern Power</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Chattanooga Gas</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>PowerSecure</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Mississippi Power</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Southern  Telecom</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Nicor Gas</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Sequent Energy Management</p>
			</div>
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

	.companies .grid {
		margin-top: 6rem;
		max-width: 120rem;
		justify-content: space-evenly;
	}

	.companies .grid--item {
		flex-direction: row;
		align-items: flex-end;
		width: 32rem;
		margin: 2rem;
	}

	.companies .grid--item img {
		width: 6rem;
		height: 5rem;
	}

	.companies .grid--item p {
		font-size: 2rem;
		align-self: flex-end;
		line-height: 2.2rem;
		margin: 0.2rem 0.6rem;
	}


</style>
