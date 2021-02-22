<?php

$currentCategory = get_queried_object();
$categories = get_categories();

?>

<div class="card card--flat news-navigation">
  <div class="card--content">

    <a href="/news" class="button button--pill <?php if(!has_category()) { echo "active"; }  ?>">All</a>

    <?php foreach($categories as $category) { ?>

      <a class="button button--pill <?php if($category->term_id == $currentCategory->term_id) { echo "active"; }  ?>" href="<?= get_category_link($category->term_id) ?>"><?= $category->name ?></a>

    <?php } ?>
  </div>
</div>

<style>
  .news-navigation {
    align-self: flex-start;
  }
</style>
