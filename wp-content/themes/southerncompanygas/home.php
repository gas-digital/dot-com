<?php
/*
 * Template Name: Home
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

$post_params = array('post_type'=>'post',
										 'post_status'=>'publish',
										 'posts_per_page'=>3);

$wpb_all_query = new WP_Query($post_params);

$i = 0;
?>
<?php get_header(); ?>

<div class="pattern intro">
	<div class="split split--right-weighted">
		<div class="left">
			<img src="/wp-content/uploads/2021/02/hyblend-image-scaled.jpg" />
		</div>
		<div class="right">
			<div class="copy copy--left">
				<p class="label">Environment / Featured / Industry News</p>
				<p class="hed hed--large">Breaking barriers: How we’re working to overcome obstacles</p>
				<p>American innovation moves at lightning speed. Access to alternative forms of energy is increasing, but incorporating new fuels into our energy system is not without challenges.</p>
				<a href="/2021/02/11/hyblend/">Learn more &#8594;</a>
			</div>
		</div>
	</div>
	<div class="news pattern card-group">
		<?php if ( $wpb_all_query->have_posts() ) : ?>
		<?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
				$thumb = get_the_post_thumbnail_url( get_the_ID() ,  "small");
		?>
				<a href="<?php the_permalink(); ?>" class="card dark card--flat card--micro">
					<div class="card--featured" style="background-image:url('<?= $thumb ?>')">

					</div>
					<div class="card--content">
							<p class="hed hed--large"><?php the_title(); ?></p>
					</div>
				</a>
		<?php
				endwhile;
		?>
	</div>
</div>

<div class="container">

	<div class="pattern split">
		<div class="left">
			<div class="copy copy--left">
				<p class="label">Kim Greene, CEO</p>
				<p class="hed hed--large">Who we are</p>
				<p>Southern Company Gas’s roots date back to 1856 when Atlanta Gas Light was incorporated to provide gas lighting to the city of Atlanta.</p>
				<a href="/who-we-are">Learn more &#8594;</a>
			</div>
		</div>
		<div class="right">
			<img src="/who-we-are/leadership/img/kim-greene-01.jpg" />
		</div>
	</div>

  <div class="pattern split">
		<div class="left">
			<img src="/environment/img/clean-horz@3x.png" />
		</div>

		<div class="right">
			<div class="copy copy--left">
				<p class="label">Environment</p>
				<p class="hed hed--large">Everyone deserves energy that is not only clean, but also safe, reliable and affordable. </p>
				<a href="/environment">Learn more &#8594;</a>
			</div>
		</div>
	</div>

  <div class="pattern content">
    <p>At Southern Company Gas, we are a dedicated team of innovators, engineers, thinkers and creators. Driven by ingenuity, we fuel the possibilities necessary for building the future of energy.</p>

    <p>We hold ourselves accountable to our customers first and foremost. To that end, we’re committed to delivering clean, safe, reliable and affordable energy for our customers, our neighbors and our communities.</p>
  </div>

	<div href="/community" class="image-break pattern dark" style="background-image:url('https://southerncompanygas.com/wp-content/uploads/2019/10/scgco-what-is-natural-gas.jpg');">
    <div class="dimmer"></div>
    <div class="copy">
      <p class="label">Join the waitlist to learn more about RNG</p>
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
				<p>Atlanta Gas Light</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Chattanooga Gas</p>
			</div>
			<div class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Nicor Gas</p>
			</div>
		</div>
	</div>

</div>

<?php wp_reset_postdata(); ?>

<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>

<style>

	#main {
		padding:0 !important;
	}

	#main .fusion-row{
		max-width: unset;
	}

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

	.image-break {
		max-width: 120rem;
	}

	.pattern.intro {
		margin: 0;
		width: 100%;
		display: flex;
		flex-direction: column;
		max-width: unset;
		background-color: white;
		background-image: url('/environment/img/environment-sustainable-lines.svg');
		background-size: cover;
		background-position: 0% 26%;
		overflow: hidden;
	}

	.pattern.intro .split {
		margin: 3rem auto;
	}

	.pattern.news {
		background-color: rgba(0,0,0,0.8);
		padding: 3rem;
		margin: 0;
		justify-content: center;
	}

	.intro .copy a {
		color: white;
	}

	.container {
		padding-top: 0;
	}

	.card.card--micro.card--flat .card--featured {
		border-radius: 3rem;
	}

	.card.card--micro.card--flat .card--content {
		background: none;
	}

	@media (max-width: 900px) {
		.pattern.intro {
			padding: 3rem;
		}

		.pattern.news {
			background: none;
		}
	}
</style>
