<?php
/**
 * WP_Widget::BlogWorthyMostViewedPosts
*/

// BlogWorthyMostViewedPosts Class
class BlogWorthyMostViewedPosts extends WP_Widget {

//**************************************************************************************
// Constructor
//**************************************************************************************
    function BlogWorthyMostViewedPosts() {
        // $GAPP_url = bloginfo('url');
        $lang = dirname( plugin_basename(__FILE__)) . "/languages";
        load_plugin_textdomain('blogworthy-popular-posts', false, $lang);
        $widget_ops = array('description' => __('Display your popular posts.', 'blogworthy-popular-posts'));
        $control_ops = array('width' => 250, 'height' => 350);
        parent::WP_Widget(false, $name = __('Blogworthy Popular Posts', 'blogworthy-popular-posts'), $widget_ops, $control_ops);
    }

//**************************************************************************************
// WP_Widget::form
//**************************************************************************************
    function form ($instance) {
        $instance = wp_parse_args( (array) $instance, array('title' => ''));
        $gauser = strip_tags($instance['gauser']);
        $gapwd = strip_tags($instance['gapwd']);
        $gaid = strip_tags($instance['gaid']);
        $title = strip_tags($instance['title']);
        $max_post = strip_tags($instance['max_post']);
        $display_excerpt = strip_tags($instance['display_excerpt']);
        $home_page = strip_tags($instance['home_page']);
        $filtercatid = strip_tags($instance['filtercatid']);
        $filterpostid = strip_tags($instance['filterpostid']);
        $thumbnail = strip_tags($instance['thumbnail']);

        require(sprintf("%s/templates/bpp_widget_admin_form.php", dirname(__FILE__)));
    }

//**************************************************************************************
// WP_Widget::update
//**************************************************************************************
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['gauser'] = strip_tags($new_instance['gauser']);
        $instance['gapwd'] = strip_tags($new_instance['gapwd']);
        $instance['gaid'] = strip_tags($new_instance['gaid']);
        $instance['max_post'] = strip_tags($new_instance['max_post']);
        $instance['display_excerpt'] = strip_tags($new_instance['display_excerpt']);
        $instance['home_page'] = strip_tags($new_instance['home_page']);
        $instance['filtercatid'] = strip_tags($new_instance['filtercatid']);
        $instance['filterpostid'] = strip_tags($new_instance['filterpostid']);
        $instance['thumbnail'] = strip_tags($new_instance['thumbnail']);
        
        return $instance;
    }

//**************************************************************************************
//  WP_Widget::widget
//**************************************************************************************
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
        $gauser = apply_filters('widget_title', empty($instance['gauser']) ? '' : $instance['gauser']);
        $gapwd = apply_filters('widget_title', empty($instance['gapwd']) ? '' : $instance['gapwd']);
        $gaid = apply_filters('widget_title', empty($instance['gaid']) ? '' : $instance['gaid']);
        $max_post = apply_filters('widget_max_post', empty($instance['max_post']) ? '' : $instance['max_post']);
        $display_excerpt = apply_filters('display_excerpt', empty($instance['display_excerpt']) ? '' : $instance['display_excerpt']);
        $home_page = apply_filters('home_page', empty($instance['home_page']) ? '' : $instance['home_page']);
        $filtercatid = apply_filters('filtercatid', empty($instance['filtercatid']) ? '' : $instance['filtercatid']);
        $filterpostid = apply_filters('filterpostid', empty($instance['filterpostid']) ? '' : $instance['filterpostid']);
        $thumbnail = apply_filters('thumbnail', empty($instance['thumbnail']) ? '' : $instance['thumbnail']);
        
        echo $before_widget;
        
        //     $filter_catid= $filtercatid;
        //     $all_catid = explode(",",$filter_catid);
            
        //     $filter_postid= $filterpostid;
        //     $all_postid = explode(",",$filter_postid);
        //     //echo $before_title . $title ."<br/>".$max_post."<br/>".$display_excerpt."<br/>".$home_page."<br/>".$after_title;
        //     echo $before_title . $title .$after_title;
        // $GAPP_filter_fixed = 'ga:pagePath=~^/';     
        // require 'gapi.class.php';
        
        // BlogWorthyMostViewedPosts_view();
        
        echo $after_widget;
    }

} // BlogWorthyMostViewedPosts Class - END

?>