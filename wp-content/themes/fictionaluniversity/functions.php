<?php
//Including Search Route File
require get_theme_file_path('/inc/search-route.php');
require get_theme_file_path('/inc/like-route.php');

// Customizing Rest API starts
function university_custom_rest()
{
    register_rest_field(
        'post',
        'authorName',
        array(
            'get_callback' => function () {
                return get_the_author();
            }
        )
    );


    register_rest_field(
        'note',
        'userNoteCount',
        array(
            'get_callback' => function () {
                return count_user_posts(get_current_user_id(), 'note');
            }
        )
    );
}


add_action('rest_api_init', 'university_custom_rest');
// Customizing Rest API ends


//Page Banner Function Section Starts
function pageBanner($args = NULL)
{

    //PHP Logic is here
    if (!$args['title']) {
        $args['title'] = get_the_title();
    }
    if (!$args['sub-title']) {
        $args['sub-title'] = get_field('page_subtitle');
    }
    if (!$args['photo']) {
        if (get_field('page_banner_image') and !is_archive() and !is_home()) {
            $args['photo'] = get_field('page_banner_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }


?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url('<?php echo $args['photo']; ?>')"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['sub-title']; ?></p>
            </div>
        </div>
    </div>

<?php

}
//Page Banner Function Section Ends






//Adding Scripts and CSS files starts
function university_files()
{
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyCqWCjiaTt-a2nRARTfKfCYkHnFO1A2wMU', NULL, 1.0, true);
    wp_enqueue_script('main_university_js', get_theme_file_uri('/build/index.js'), array('jquery'), 1.0, true);
    wp_enqueue_style('font_awesome', "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
    wp_enqueue_style('custom_google_fonts', "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
    wp_enqueue_style('university_main_styles', get_theme_file_uri("/build/style-index.css"));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri("/build/index.css"));

    //Make JS available in js file
    wp_localize_script('main_university_js', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ));
}
add_action('wp_enqueue_scripts', 'university_files');
//Adding Scripts and CSS files ends





//Adding University Features starts
function university_features()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 480, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 300, true);
}
add_action('after_setup_theme', 'university_features');
//Adding University Features ends

//Customizing Default Queries starts
function universities_adjust_features($query)
{
    if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
            )
        ));
    }

    if (!is_admin() and is_post_type_archive('program') and $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }

    if (!is_admin() and is_post_type_archive('campus') and $query->is_main_query()) {
        $query->set('posts_per_page', -1);
    }
}

add_action('pre_get_posts', 'universities_adjust_features');

//Customizing Default Queries ends




function universityMapKey($api)
{
    $api['key'] = 'AIzaSyCqWCjiaTt-a2nRARTfKfCYkHnFO1A2wMU';
    return $api;
}


add_filter('acf/fields/google_map/api', 'universityMapKey');


// Redirect Subscribers to Front page

add_action('admin_init', 'redirectSubscribers');

function redirectSubscribers () {
    $currentUser = wp_get_current_user();
    if (count($currentUser->roles) == 1 AND $currentUser->roles[0] == "subscriber" ) {
        wp_redirect(site_url('/'));
        exit;
    }
}


// Hide admin bar for subscribers
add_action('wp_loaded', 'noAdminBar');

function noAdminBar() {
    $currentUser = wp_get_current_user();
    if (count($currentUser->roles) == 1 AND $currentUser->roles[0] == "subscriber" ) {
        show_admin_bar(false);
    }
}


// Customize Login Screen
//******Note Filters are use to customize objects or methods in some way*/
add_filter('login_headerurl', 'ourHeaderUrl');
function ourHeaderUrl() {
    return esc_url(site_url('/'));
}

// Loading css for wordpress admin
add_action('login_enqueue_scripts', 'ourLoginCss');

function ourLoginCss () {
    wp_enqueue_style('font_awesome', "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
    wp_enqueue_style('custom_google_fonts', "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
    wp_enqueue_style('university_main_styles', get_theme_file_uri("/build/style-index.css"));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri("/build/index.css"));
}

add_filter('login_headertitle', 'ourLoginTitle');

function ourLoginTitle() {
    return 'Developed By Shad';
}

// Note post making private
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function makeNotePrivate($data, $postsarr) {
    if(count_user_posts(get_current_user_id(),'note') > 5 AND !$postsarr['ID']) {
        die('Your posts limit increase');
    }

    if($data['post_type'] == 'note') {
        $data['post_title'] = sanitize_text_field($data['post_title']);
        $data['post_content'] = sanitize_textarea_field($data['post_title']);
    }

    if($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
        $data['post_status'] = 'private';
    }
    return $data;
}