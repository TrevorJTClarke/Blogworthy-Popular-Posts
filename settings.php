<?php
if(!class_exists('Blogworthy_Popular_Posts_Settings'))
{
    class Blogworthy_Popular_Posts_Settings {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_blogworthy_popular_posts_page' ) );
        add_action( 'admin_init', array( $this, 'bpp_init' ) );
    }

    /**
     * Add options page
     */
    public function add_blogworthy_popular_posts_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Blogworthy Popular Posts', 
            'Blogworthy Popular Posts Settings', 
            'manage_options', 
            'blogworthy-popular-posts', 
            array( $this, 'create_blogworthy_popular_posts_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_blogworthy_popular_posts_page()
    {
        // Set class property
        $this->options = get_option( 'bpp_setting_options' );
        require_once(sprintf("%s/templates/settings_page.php", dirname(__FILE__)));
    }

    /**
     * Register and add settings
     */
    public function bpp_init()
    {        
        register_setting(
            'bpp_ga_settings',
            'bpp_setting_options',
            array( $this, 'sanitize' )
        );

        add_settings_section(
            'bpp_setting_ga_creds',
            'Google Analytics Credentials',
            array( $this, 'print_section_info' ),
            'blogworthy-popular-posts'
        );

        add_settings_field(
            'ga_id_number',
            'GA Profile ID',
            array( $this, 'id_number_callback' ),
            'blogworthy-popular-posts',
            'bpp_setting_ga_creds'         
        );

        add_settings_field(
            'ga_email', 
            'GA Login Email', 
            array( $this, 'ga_email_callback' ), 
            'blogworthy-popular-posts', 
            'bpp_setting_ga_creds'
        );

        add_settings_field(
            'ga_password', 
            'GA Login Password', 
            array( $this, 'ga_password_callback' ), 
            'blogworthy-popular-posts', 
            'bpp_setting_ga_creds'
        );     
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = absint( $input['id_number'] );

        if( isset( $input['ga_email'] ) )
            $new_input['ga_email'] = sanitize_text_field( $input['ga_email'] );

        if( isset( $input['ga_password'] ) )
            $new_input['ga_password'] = sanitize_text_field( $input['ga_password'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     * TODO: add small section for ABout here
     */
    public function print_section_info()
    {
        print '<strong>Requirements for Setup:</strong><br>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. Log into Google Analytics.<br> 
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Go your site\'s profile (go to the admin dashboard).<br> 
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Your URL should look like: https://www.google.com/analytics/web/#report/visitors-overview/a1234b23478970<b>p</b><strong><font color="#2EA2CC">987654</font></strong>/<br>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4. The last part after the <b>"p"</b> is your Google Analytics Profile ID, in this case it is <strong>"<font color="#2EA2CC">987654</font>"</strong><br><br>
               <em><strong>NOTE:</strong> Your GA Profile ID is <strong>NOT</strong> your "UA-xxxxxx-xx" number. It is a 9 digit number unique to your site profile.</em>';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        printf(
            '<input type="text" id="id_number" name="bpp_setting_options[id_number]" value="%s" />',
            isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function ga_email_callback()
    {
        printf(
            '<input type="email" id="ga_email" name="bpp_setting_options[ga_email]" value="%s" />',
            isset( $this->options['ga_email'] ) ? esc_attr( $this->options['ga_email']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function ga_password_callback()
    {
        printf(
            '<input type="password" id="ga_password" name="bpp_setting_options[ga_password]" value="%s" />',
            isset( $this->options['ga_password'] ) ? esc_attr( $this->options['ga_password']) : ''
        );
    }

    }
}
