<?php
/*
    Plugin Name: First Plugin
    Description: Truly amazing plugin
    Version: 1.0
    Author: Shad
    Author URI: https://fiverr.com/aynadigital
*/

class WordCountAndTimePlugin {
    function __construct()
    {
        add_action('admin_menu', array($this, 'adminPage'));
    }

    function adminPage() {
        add_options_page(
            'Word Count Setting', //Title of the page
            'Word Count', //Menu Title
            'manage_options', //User Role
            'word-count-setting', //Slug
            array($this, 'ourHTML') //Call back function
        );
    }
    
    function ourHTML() {
        ?>

        <div class="wrap">
            <h1>Word Count Settings</h1>
        </div>

        <?php
    }
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();


