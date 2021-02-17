<?php
//for use in the loop, list 5 post titles related to first tag on current post
$tags = wp_get_post_tags($post->ID);

if ($tags) {
  $first_tag = $tags[0]->term_id;

  $args=array(
    'tag__in' => array($first_tag),
    'post__not_in' => array($post->ID),
    'posts_per_page'=>5,
    'caller_get_posts'=>1
  );

  $my_query = new WP_Query($args);

  if( $my_query->have_posts() ) {
?>

<div class="pattern">
  <div class="copy">
    <p class="hed hed--medium">Related Posts</p>
  </div>
</div>
<div class="pattern card-group">

<?php
      while ($my_query->have_posts()) : $my_query->the_post();
?>

      <a class="card card--medium" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to<?php the_title_attribute(); ?>">

        <div class="card--featured">
          <?= the_post_thumbnail( 'medium' ); ?>
        </div>

        <div class="card--content">
          <p class="hed"><?php the_title(); ?></p>
        </div>

      </a>

<?php
    endwhile;
?>
</div>
<?php
  }

  wp_reset_query();
}
?>

<style>
.pattern.card-group {
  justify-content: space-evenly;
}
</style>
