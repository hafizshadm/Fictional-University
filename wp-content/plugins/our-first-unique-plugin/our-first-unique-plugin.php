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
        add_action('admin_init', array($this, 'settings'));
    }

    function settings() {
        // Creating section with the help of add_settings_field
        add_settings_section(
            'wcp_first_section', //creating section
            NULL, //seperate title from add_settings_field
            NULL, //seperate callback from add_settings_field
            'word-count-setting' //using slug of the page
        );

        /**
         * Display Location HTML field
         */
        // Linking with register_settings
        add_settings_field(
            'wcp_location', //using settings name
            'Display Location', //title for the field
            array($this, 'locationHTML'), //callback
            'word-count-setting', //using slug of the page
            'wcp_first_section' //section name have to use in add_settings_section
        );

        //Storing settings in database
        register_setting(
            'wordcountplugin', //group name 
            'wcp_location',  //settings name going to database
            array('sanitize_callback' => 'sanitize_text_field', 'default' => '0') //options or values going to db
        );


        /**
         * Headline or heading HTML field
         */
        // Linking with register_settings
        add_settings_field(
            'wcp_headline', //using settings name
            'Headline Text', //title for the field
            array($this, 'headlineHTML'), //callback
            'word-count-setting', //using slug of the page
            'wcp_first_section' //section name have to use in add_settings_section
        );

        //Storing settings in database
        register_setting(
            'wordcountplugin', //group name 
            'wcp_headline',  //settings name going to database
            array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics') //options or values going to db
        );


        /**
         * Word Count HTML field
         */
        // Linking with register_settings
        add_settings_field(
            'wcp_word_count', //using settings name
            'Word Count', //title for the field
            array($this, 'wordCountHTML'), //callback
            'word-count-setting', //using slug of the page
            'wcp_first_section' //section name have to use in add_settings_section
        );

        //Storing settings in database
        register_setting(
            'wordcountplugin', //group name 
            'wcp_word_count',  //settings/input name going to database
            array('sanitize_callback' => 'sanitize_text_field', 'default' => '1') //options or values going to db
        );


        /**
         * Character Count HTML field
         */
        // Linking with register_settings
        add_settings_field(
            'wcp_char_count', //using settings name
            'Character Count', //title for the field
            array($this, 'charCountHTML'), //callback
            'word-count-setting', //using slug of the page
            'wcp_first_section' //section name have to use in add_settings_section
        );

        //Storing settings in database
        register_setting(
            'wordcountplugin', //group name 
            'wcp_char_count',  //settings/input name going to database
            array('sanitize_callback' => 'sanitize_text_field', 'default' => '1') //options or values going to db
        );


        /**
         * Read Time HTML field
         */
        // Linking with register_settings
        add_settings_field(
            'wcp_read_time', //using settings name
            'Read Time', //title for the field
            array($this, 'readTimeHTML'), //callback
            'word-count-setting', //using slug of the page
            'wcp_first_section' //section name have to use in add_settings_section
        );

        //Storing settings in database
        register_setting(
            'wordcountplugin', //group name 
            'wcp_read_time',  //settings/input name going to database
            array('sanitize_callback' => 'sanitize_text_field', 'default' => '1') //options or values going to db
        );
    }

    function readTimeHTML() {
        ?> 
        <input type="checkbox" name="wcp_read_time" value="1" <?php checked(get_option('wcp_word_count'), '1'); ?> />
        <?php
    }

    function charCountHTML() {
        ?> 
        <input type="checkbox" name="wcp_char_count" value="1" <?php checked(get_option('wcp_word_count'), '1'); ?> />
        <?php
    }

    function wordCountHTML() {
        ?> 
        <input type="checkbox" name="wcp_word_count" value="1" <?php checked(get_option('wcp_word_count'), '1'); ?> />
        <?php
    }

    function headlineHTML() {
        ?> 
            <input type="text" name="wcp_headline" value="<?php echo esc_attr(get_option('wcp_headline')); ?>">
        <?php
    }

    function locationHTML() {
        ?>
        
        <select name="wcp_location">
            <option value="0" <?php selected(get_option('wcp_location'), '0'); ?>>Beginning of the post</option>
            <option value="1" <?php selected(get_option('wcp_location'), '1'); ?>>End of the post</option>
        </select>
        
        <?php
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
            <form action="options.php" method="POST">
                <?php
                /* 
                must use group name in settings_fields, it will add all the hidden html values from wordpress like NONCE, ACTIONS, 
                its sort of security for us
                */    
                settings_fields('wordcountplugin'); 
                do_settings_sections('word-count-setting');
                submit_button();
                ?>
            </form>
        </div>

        <?php
    }
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();


