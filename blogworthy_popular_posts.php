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
/*
Copyright 2012  Francis Yaconiello  (email : francis@yaconiello.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(!class_exists('Blogworthy_Popular_Posts'))
{
	class Blogworthy_Popular_Posts
	{
		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
        	// Initialize Settings
            require_once(sprintf("%s/lib/settings.php", dirname(__FILE__)));
            $Blogworthy_Popular_Posts_Settings = new Blogworthy_Popular_Posts_Settings();

            // Initialize GAPI Class
            // require_once(sprintf("%s/lib/gapi.class.php", dirname(__FILE__)));
            // $GAPI = new GAPI();
        	
        	// Register custom post types
            // require_once(sprintf("%s/posts/posts_template.php", dirname(__FILE__)));
            // $Popular_Post_Type_Template = new Popular_Post_Type_Template();
		} // END public function __construct
	    
		/**
		 * Activate the plugin
		 */
		public static function activate()
		{
			// Do nothing
		} // END public static function activate
	
		/**
		 * Deactivate the plugin
		 */		
		public static function deactivate()
		{
			// Do nothing
		} // END public static function deactivate
	} // END class Blogworthy_Popular_Posts
} // END if(!class_exists('Blogworthy_Popular_Posts'))

if(class_exists('Blogworthy_Popular_Posts'))
{
	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('Blogworthy_Popular_Posts', 'activate'));
	register_deactivation_hook(__FILE__, array('Blogworthy_Popular_Posts', 'deactivate'));

	// instantiate the plugin class
	$blogworthy_popular_posts = new Blogworthy_Popular_Posts();
	
    // Add a link to the settings page onto the plugin page
    if(isset($blogworthy_popular_posts))
    {
        // Add the settings link to the plugins page
        function blogworthy_settings_link($links)
        { 
            $settings_link = '<a href="options-general.php?page=blogworthy_popular_posts">Settings</a>'; 
            array_unshift($links, $settings_link); 
            return $links; 
        }

        $plugin = plugin_basename(__FILE__); 
        add_filter("plugin_action_links_$plugin", 'blogworthy_settings_link');

        //Add Blogworthy Popular Posts to settings panel
        // function BlogworthyPopularPosts_menu() {
        //     add_options_page('Blogworthy Popular Posts', 'Blogworthy Popular Posts', 8, __FILE__, 'BlogWorthyMostViewedPosts_options');
        // }
        // add_action('admin_menu', 'BlogworthyPopularPosts_menu');
    }
}