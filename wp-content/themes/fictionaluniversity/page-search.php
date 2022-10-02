<!-- This page is power pages and its content -->
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
        <div class="generic-content">
            <?php get_search_form() ?>
        </div>
    </div>

<?php
}
get_footer();
?>