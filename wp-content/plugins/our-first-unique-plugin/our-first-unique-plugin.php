<?php
/*
    Plugin Name: First Plugin
    Description: Truly amazing plugin
    Version: 1.0
    Author: Shad
    Author URI: https://fiverr.com/aynadigital
*/

class WordCountAndTimePlugin
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'adminPage'));
        add_action('admin_init', array($this, 'settings'));
        add_filter('the_content', array($this, 'ifWrap'));
    }

    function ifWrap($content)
    {
        if (
            is_main_query() and is_single()
            and
            (
                get_option('wcp_word_count', '1') or
                get_option('wcp_char_count', '1') or
                get_option('wcp_read_time', '1')
            )
        ) {
            return $this->createHTML($content);
        }
        return $content;
    }

    function createHTML($content)
    {

        $html = '<div class="post-stats-wrap"><h3>' . esc_html(get_option('wcp_headline', 'Post Statistics')) . '</h3><p>';

        if (get_option('wcp_word_count', '1') or get_option('wcp_read_time', '1')) {
            $wordCount = str_word_count(strip_tags($content));
        }

        if (get_option('wcp_word_count', '1')) {
            $html .= "This post has " . $wordCount . " words.<br>";
        }

        if (get_option('wcp_char_count', '1')) {
            $html .= "This post has " . strlen(strip_tags($content)) . " chars.<br>";
        }

        if (get_option('wcp_read_time', '1')) {
            $html .= "This post has take about " . round($wordCount / 225) . " minute(s) to read.<br>";
        }

        $html .= '</p></div>';

        $html .= '<style>
            .post-stats-wrap {
                background-color: #fff;
                padding: 20px;
                border: 0;
                border-radius: 4px;
                box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
                margin: 20px 0;
            }
        </style>';

        if (get_option('wcp_location', '0') == '0') {
            return $html . $content;
        }
        return $content . $html;
    }


    function settings()
    {
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
            array('sanitize_callback' => array($this, 'sanitize_display_location'), 'default' => '0') //options or values going to db
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
            array($this, 'checkboxHTML'), //callback
            'word-count-setting', //using slug of the page
            'wcp_first_section', //section name have to use in add_settings_section
            array('theName' => 'wcp_word_count')
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
            array($this, 'checkboxHTML'), //callback
            'word-count-setting', //using slug of the page
            'wcp_first_section', //section name have to use in add_settings_section
            array('theName' => 'wcp_char_count')
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
            array($this, 'checkboxHTML'), //callback
            'word-count-setting', //using slug of the page
            'wcp_first_section', //section name have to use in add_settings_section
            array('theName' => 'wcp_read_time')
        );

        //Storing settings in database
        register_setting(
            'wordcountplugin', //group name 
            'wcp_read_time',  //settings/input name going to database
            array('sanitize_callback' => 'sanitize_text_field', 'default' => '1') //options or values going to db
        );
    }

    /** 
     * function readTimeHTML() {
     *  ?> 
     *    <input type="checkbox" name="wcp_read_time" value="1" <?php checked(get_option('wcp_word_count'), '1'); ?> />
     *    <?php
     * }

     * function charCountHTML() {
     *    ?> 
     *    <input type="checkbox" name="wcp_char_count" value="1" <?php checked(get_option('wcp_word_count'), '1'); ?> />
     *    <?php
     *}

     *function wordCountHTML() {
     *    ?> 
     *    <input type="checkbox" name="wcp_word_count" value="1" <?php checked(get_option('wcp_word_count'), '1'); ?> />
     *    <?php
     *}
     */

    function sanitize_display_location($input)
    {
        if ($input != '0' and $input != '1') {
            add_settings_error('wcp_location', 'wcp_location_error', 'Display location must be either beginning or end');
            return get_option('wcp_location', 1);
        }

        return $input;
    }

    // Reuseable checkbox
    function checkboxHTML($args)
    {
?>
        <input type="checkbox" name="<?php echo $args['theName'] ?>" value="1" <?php checked(get_option($args['theName']), '1'); ?> />
    <?php
    }


    function headlineHTML()
    {
    ?>
        <input type="text" name="wcp_headline" value="<?php echo esc_attr(get_option('wcp_headline')); ?>">
    <?php
    }

    function locationHTML()
    {
    ?>

        <select name="wcp_location">
            <option value="0" <?php selected(get_option('wcp_location'), '0'); ?>>Beginning of the post</option>
            <option value="1" <?php selected(get_option('wcp_location'), '1'); ?>>End of the post</option>
        </select>

    <?php
    }

    function adminPage()
    {
        add_options_page(
            'Word Count Setting', //Title of the page
            'Word Count', //Menu Title
            'manage_options', //User Role
            'word-count-setting', //Slug
            array($this, 'ourHTML') //Call back function
        );
    }

    function ourHTML()
    {
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
