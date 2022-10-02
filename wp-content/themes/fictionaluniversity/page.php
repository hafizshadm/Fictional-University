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

        <?php
        $theParentId = wp_get_post_parent_id(get_the_ID());
        if ($theParentId !== 0) { ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParentId) ?>">
                        <i class="fa fa-home" aria-hidden="true">
                        </i> Back to <?php echo get_the_title($theParentId) ?>
                    </a>
                    <span class="metabox__main"><?php the_title(); ?></span>
                </p>
            </div>


        <?php }
        $testArray = get_pages( array(
            'child_of' => get_the_ID(  )
        ) );
        
        if($theParentId or $testArray) {
            ?>


        <div class="page-links">
            <h2 class="page-links__title"><a href="<?php echo get_permalink( $theParentId ) ?>"><?php echo get_the_title( $theParentId ) ?></a></h2>
            
            
            <ul class="min-list">
                <?php 
                    if($theParentId) {
                        $findTheChildrenOf = $theParentId;
                    } else {
                        $findTheChildrenOf = get_the_ID();
                    }

                    wp_list_pages( array(
                        'title_li' => NULL,
                        'child_of' => $findTheChildrenOf,
                        'sort_column' => 'menu_order'
                    ) );
                
                ?>
            </ul>
        </div>
        <?php
        }
        ?>

        <div class="generic-content">
            <p><?php the_content(); ?></p>
        </div>
    </div>

<?php
}
get_footer();
?>