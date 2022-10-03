<?php
/*
    Plugin Name: First Plugin
    Description: Truly amazing plugin
    Version: 1.0
    Author: Shad
    Author URI: https://fiverr.com/aynadigital
*/

add_filter('the_content', 'addToEndOfPost');

function addToEndOfPost($content) {
    if(is_single() && is_main_query()) {
        return $content . '<h4>My name is shad.</h4>';
    }

    return $content;
}