<?php
/*
    Plugin Name: First Plugin
    Description: Truly amazing plugin
    Version: 1.0
    Author: Shad
    Author URI: https://fiverr.com/aynadigital
*/

add_action('admin_menu', 'ourPluginSettingLink');

function ourPluginSettingLink() {
    add_options_page(
        'Word Count Setting', //Title of the page
        'Word Count', //Menu Title
        'manage_options', //User Role
        'word-count-setting', //Slug
        'ourSettingsPageHTML' //Call back function
    );
}

function ourSettingsPageHTML() {
    ?>
    <p>Hello World From Word Count Plugin</p>
    <?php
}