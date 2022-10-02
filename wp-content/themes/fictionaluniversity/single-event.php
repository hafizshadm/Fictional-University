<!-- This page is power single event page -->
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
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>">
                    <i class="fa fa-home" aria-hidden="true">
                    </i> Event Home
                </a>
                <span class="metabox__main"><?php the_title() ?></span>
            </p>
        </div>


        <div class="generic-content">
            <p><?php the_content(); ?></p>
        </div>

        <?php
        $relatedPrograms = get_field('related_programs');

        if ($relatedPrograms) {
            echo '<hr class="section-break">';
            echo '<h3 class="headline headline--medium">Related Program(s)</h3>';
            echo '<ul class="link-list min-list">';

            foreach ($relatedPrograms as $program) {
        ?>
                <li><a href="<?php echo get_the_permalink($program); ?>">
                        <?php echo get_the_title($program); ?>
                    </a></li>

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