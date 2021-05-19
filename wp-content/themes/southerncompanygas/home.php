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

<div class="pattern intro">
	<div class="copy dark">
		<h1 class="hed hed--large">We are building with clean energy</h1>
		<p>As companies and people become more environmentally conscious, Southern Company Gas and organizations like us are tasked with building a future fueled by clean energy.</p>
	</div>
</div>

<div class="split news">
	<div class="left">
		<?php
				if ( $wpb_all_query->have_posts() ) :
		?>
		<?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
				$thumb = get_the_post_thumbnail_url( get_the_ID() ,  "medium");
				if($i == 0) {
		?>
				<a href="<?php the_permalink(); ?>" class="card">
					<div class="card--featured">
						<img src="<?= $thumb ?>" />
					</div>
					<div class="card--content">
						<p class="label">News</p>
						<p class="hed"><?php the_title(); ?></p>
					</div>
				</a>
		<?php
				}
				$i = 1;
				endwhile;
		?>
	</div>
	<div class="right">
			<?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
					$thumb = get_the_post_thumbnail_url( get_the_ID() ,  "small");
					if($i > 0) {
			?>
					<a href="<?php the_permalink(); ?>" class="card card--flat card--micro">
						<div class="card--featured" style="background-image:url('<?= $thumb ?>')">

						</div>
						<div class="card--content">
							<p class="label">News</p>
							<p class="hed"><?php the_title(); ?></p>
						</div>
					</a>
			<?php
					}
					$i++;
					endwhile;
			?>
	</div>
</div>

<div class="container">
	<div class="pattern split">
		<div class="left">
			<div class="copy copy--left">
				<p class="label">Kim Greene, CEO</p>
				<p class="hed hed--medium">Who we are</p>
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
			<img src="/assets/img/illos/bus-wide.svg" />
		</div>

		<div class="right">
			<div class="copy copy--left">
				<p class="label">Environment</p>
				<p class="hed hed--medium">Everyone deserves energy that is not only clean, but also safe, reliable and affordable. </p>
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
      <p class="hed hed--medium">Join our waitlist to know what's coming in Renewable Natural Gas</p>
			<?php get_template_part( 'templates/mailchimp-form' ); ?>
    </div>
  </div>

  <div class="pattern content">
    <p>Our service starts with listening to – and learning from – our customers so we fully understand how to best meet their energy needs, and we take pride in our ability to provide them with clear, open and honest communication.</p>
  </div>

	<div class="pattern companies">
		<div class="copy">
			<h2 class="hed hed--medium">A family of companies</h2>
		</div>

		<div class="grid">
			<a href="https://www.southernlinc.com/" class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Southern Linc</p>
			</a>
			<a href="/" class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Southern Company Gas</p>
			</a>
			<a href="https://virginianaturalgas.com/" class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Virginia Natural Gas</p>
			</a>
			<a href="https://www.atlantagaslight.com/" class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Atlanta Gas Light</p>
			</a>
			<a href="http://chattanoogagas.com/" class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Chattanooga Gas</p>
			</a>
			<a href="https://www.nicorgas.com/" class="grid--item">
				<img src="/assets/img/triangle.png" />
				<p>Nicor Gas</p>
			</a>
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

	#main .fusion-row {
		max-width: unset;
	}

	#header {
		background: none;
		position: relative;
		z-index: 1;
	}

	#header-container {
		background: none;
	}

	.navbar ol li a {
		color: white;
	}

	#boxed-wrapper {
		overflow: visible;
		z-index: 0;
	}

	.container {
		padding-top: 0;
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
		top: -16rem;
		width: 100%;
		display: flex;
		position: relative;
		min-height: 40rem;
		padding-top: 16rem;
		padding-bottom: 14rem;
		flex-direction: column;
		max-width: unset;
		background-color: #00B6EC;
		background-image: url('/assets/img/illos/home-bg.svg');
		background-size: cover;
		background-position: center;
		overflow: hidden;
	}

	.pattern.intro .copy {
		max-width: 50rem;
	}

	.pattern.intro .split {
		margin: 3rem auto;
	}

	.news.split {
		margin-top: -16rem;
		max-width: unset;
	}

	.news.split .left {
		background: #CDCDCD;
	}

	.news.split .right{
		justify-content: center;
	}

	@media (max-width: 900px) {
		.pattern.intro {
			padding: 16rem 3rem 10rem;
		}

		.news.split {
			width: 100%;
			margin-left: 0;
			margin-right: 0;
		}
	}
</style>
