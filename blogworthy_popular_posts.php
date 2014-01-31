<?php
/*
Plugin Name: Blogworthy Popular Posts
Plugin URI: http://blogworthy.com/
Description: This plugin uses Google Analytics API to fetch data from your analytics account and displays most viewed posts in the widget.
Version: 0.1.0
Author: Trevor Clarke
Author URI: https://github.com/TrevorJTClarke
License: GPL2
*/

if(!class_exists('Blogworthy_Popular_Posts')) {
	class Blogworthy_Popular_Posts {
		/**
		 * Construct the plugin object
		 */
		public function __construct() {
        	// Initialize Settings
            require_once(sprintf("%s/settings.php", dirname(__FILE__)));

            // Initialize GAPI Class
            require_once(sprintf("%s/lib/gapi.class.php", dirname(__FILE__)));
            // $GAPI = new gapi();

            // Initialize Widget
            require_once(sprintf("%s/bpp_widget_class.php", dirname(__FILE__)));
            
		} // END public function __construct
	    
		/**
		 * Activate the plugin
		 */
		public static function activate() {
			if(!get_option('BlogWorthyMostViewedPosts_maxResults'))
                add_option('BlogWorthyMostViewedPosts_maxResults', '5');
            if(!get_option('BlogWorthyMostViewedPosts_dateDispEnable'))
                add_option('BlogWorthyMostViewedPosts_dateDispEnable', 'yes');
            if(!get_option('BlogWorthyMostViewedPosts_postDateEnable'))
                add_option('BlogWorthyMostViewedPosts_postDateEnable', 'no');
            
            if(!get_option('BlogWorthyMostViewedPosts_contentsViewEnable'))
                add_option('BlogWorthyMostViewedPosts_contentsViewEnable', 'no');
            if(!get_option('BlogWorthyMostViewedPosts_cssEnable'))
                add_option('BlogWorthyMostViewedPosts_cssEnable', 'yes');
            if(!get_option('BlogWorthyMostViewedPosts_cacheEnable'))
                add_option('BlogWorthyMostViewedPosts_cacheEnable', 'no');
            if(!get_option('BlogWorthyMostViewedPosts_cacheExpiresMinutes'))
                add_option('BlogWorthyMostViewedPosts_cacheExpiresMinutes', '60');
		} // END public static function activate
	
		/**
		 * Deactivate the plugin
		 */		
		public static function deactivate() {
			// Do nothing
		} // END public static function deactivate
	} // END class Blogworthy_Popular_Posts
} // END if(!class_exists('Blogworthy_Popular_Posts'))

if(class_exists('Blogworthy_Popular_Posts')) {
	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('Blogworthy_Popular_Posts', 'activate'));
	register_deactivation_hook(__FILE__, array('Blogworthy_Popular_Posts', 'deactivate'));

	// instantiate the plugin class
	$blogworthy_popular_posts = new Blogworthy_Popular_Posts();
	
    // check if we start BPP correctly
    if(isset($blogworthy_popular_posts)) {
        // Add the settings link to the admin settings
        if( is_admin() ) {
            $Blogworthy_Popular_Posts_Settings = new Blogworthy_Popular_Posts_Settings();
        }
        
        // Add the settings link to the plugins page
        function blogworthy_settings_link($links) { 
            $settings_link = '<a href="options-general.php?page=blogworthy-popular-posts">Settings</a>'; 
            array_unshift($links, $settings_link); 
            return $links; 
        }
        $plugin = plugin_basename(__FILE__); 
        add_filter("plugin_action_links_$plugin", 'blogworthy_settings_link');


        //Start widget
        // $BlogWorthyMostViewedPosts = new BlogWorthyMostViewedPosts();
        function BPPWidgetInit() {
            register_widget('BlogWorthyMostViewedPosts');
        }
        add_action('widgets_init', 'BPPWidgetInit');
    }
}