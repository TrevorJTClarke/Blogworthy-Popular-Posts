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
            'bpp_ga_settings', // Option group
            'bpp_setting_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'bpp_setting_ga_creds', // ID
            'Google Analytics Credentials',
            array( $this, 'print_section_info' ), // Callback
            'blogworthy-popular-posts' // Page
        );  

        add_settings_field(
            'ga_id_number', // ID
            'GA ID Number', // Title 
            array( $this, 'id_number_callback' ), // Callback
            'blogworthy-popular-posts', // Page
            'bpp_setting_ga_creds' // Section           
        );      

        add_settings_field(
            'ga_email', 
            'GA Login Email', 
            array( $this, 'ga_email_callback' ), 
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

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Requirements for GA Setup:';
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
            '<input type="text" id="ga_email" name="bpp_setting_options[ga_email]" value="%s" />',
            isset( $this->options['ga_email'] ) ? esc_attr( $this->options['ga_email']) : ''
        );
    }

    }
}
