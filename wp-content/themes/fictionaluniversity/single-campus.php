<!-- This page is power single post page -->
<?php
get_header();

while (have_posts()) {
    the_post();
    pageBanner(array(
        'title' => '',
        'sub-title' => '',
        'photo' => ''
    ));
?>
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>">
                    <i class="fa fa-home" aria-hidden="true">
                    </i> All Campuses
                </a>
                <span class="metabox__main"><?php the_title(); ?></span>
            </p>
        </div>

        <div class="generic-content">
            <p><?php the_content(); ?></p>

        </div>
        <div class="acf-map">
            <?php $map_location = get_field('map_location'); ?>
            <div class="marker" data-lat="<?php echo $map_location['lat']; ?>" data-lng="<?php echo $map_location['lng'] ?>">
                <h3><?php the_title(); ?></h3>
                <p><?php echo $map_location['address']; ?></p>
            </div>
        </div>
        <?php
        $relatedPrograms = new WP_Query(array(
            'post_type' => 'program',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'related_campus',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"'
                )
            )
        ));

        if ($relatedPrograms->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--small">Available Programs at this campus:</h2>';
            echo '<ul class ="min-list link-list">';

            while ($relatedPrograms->have_posts()) {
                $relatedPrograms->the_post();
        ?>
                <li>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </li>
        <?php
            }
            echo '</ul>';
        }
        ?>
    </div>
<?php
}
get_footer();
?>