<?php

get_header();
pageBanner(array(
  'title' => 'All Campuses',
  'sub-title' => 'We have several beautiful campuses in the town.',
  'photo' => ''
));
?>

<div class="container container--narrow page-section">

  <div class="acf-map">

    <?php
    while (have_posts()) {
      the_post();
      $map_location = get_field('map_location');
    ?>
      <div class="marker" data-lat="<?php echo $map_location['lat']; ?>" data-lng="<?php echo $map_location['lng'] ?>">
        <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
        <p><?php echo $map_location['address']; ?></p>
      </div>
    <?php }
    echo paginate_links();
    ?>
  </div>



</div>

<?php get_footer();

?>