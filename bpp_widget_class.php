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
        parent::WP_Widget(false, $name = __('Blogworthy Popular Posts', 'blogworthy-popular-posts'), $widget_ops);
    }

//**************************************************************************************
// WP_Widget::form
//**************************************************************************************
    function form ($instance) {
        $instance = wp_parse_args( (array) $instance, array('title' => ''));
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
        $max_post = apply_filters('widget_max_post', empty($instance['max_post']) ? '' : $instance['max_post']);
        $display_excerpt = apply_filters('display_excerpt', empty($instance['display_excerpt']) ? '' : $instance['display_excerpt']);
        $home_page = apply_filters('home_page', empty($instance['home_page']) ? '' : $instance['home_page']);
        $filtercatid = apply_filters('filtercatid', empty($instance['filtercatid']) ? '' : $instance['filtercatid']);
        $filterpostid = apply_filters('filterpostid', empty($instance['filterpostid']) ? '' : $instance['filterpostid']);
        $thumbnail = apply_filters('thumbnail', empty($instance['thumbnail']) ? '' : $instance['thumbnail']);
        
        $BPP_GA = get_option('bpp_setting_options');
        $gaUsername = $BPP_GA['ga_email'];
        $gaPassword = $BPP_GA['ga_password'];
        $profileId = $BPP_GA['id_number'];

        $dimensions = array('pagePath');
        $metrics = array('uniquePageviews');
        $sort = '-uniquePageviews';
        $filter = 'pagePath=~\/[a-zA-Z0-9\-]+\/\d+$';
        $fromDate = date('Y-m-d', strtotime('-2 days'));
        $toDate = date('Y-m-d');

        $ga = new gapi($gaUsername, $gaPassword);
        $mostPopular = $ga->requestReportData($profileId, $dimensions, $metrics, $sort, $filter, $fromDate, $toDate, 1, 10);

        var_dump($mostPopular);

        echo $before_widget;
        
            $filter_catid= $filtercatid;
            $all_catid = explode(",",$filter_catid);
            
            $filter_postid= $filterpostid;
            $all_postid = explode(",",$filter_postid);
            //echo $before_title . $title ."<br/>".$max_post."<br/>".$display_excerpt."<br/>".$home_page."<br/>".$after_title;
            echo $before_title . $title . $after_title;
            $GAPP_filter_fixed = 'ga:pagePath=~^/';
        // require 'gapi.class.php';
        // require(sprintf("%s/lib/gapi.class.php", dirname(__FILE__)));

        // $BlogWorthy_today = 1;
        // $BlogWorthy_week = 7;
        // $BlogWorthy_month = 30;
                
        // $BlogWorthytodays_year = date("Y");
        //     $BlogWorthytodays_month = date("m");
        //     $BlogWorthytodays_day = date("d");
        //     $BlogWorthycurrent_date = "$BlogWorthytodays_year-$BlogWorthytodays_month-$BlogWorthytodays_day";
        //     $BlogWorthydaydate = strtotime ( "-$BlogWorthy_today day" , strtotime ( $BlogWorthycurrent_date ) ) ;
        //     $BlogWorthydaydate = date ( 'Y-m-d' , $BlogWorthydaydate );
        //     $BlogWorthyFrom = $BlogWorthydaydate;
                
            
        //     //Get weekly date
        //     $BlogWorthyweekdates = strtotime ( "-$BlogWorthy_week day" , strtotime ( $BlogWorthycurrent_date ) ) ;
        //     $BlogWorthyweekdates = date ( 'Y-m-d' , $BlogWorthyweekdates );
        //     $BlogWorthyweek_From = $BlogWorthyweekdates;
                
            
        //     //Get Monthly date
        //     $BlogWorthyalldates = strtotime ( "-$BlogWorthy_month day" , strtotime ( $BlogWorthycurrent_date ) ) ;
        //     $BlogWorthyalldates = date ( 'Y-m-d' , $BlogWorthyalldates );
        //     $BlogWorthyall_From = $BlogWorthyalldates;  

        
        // BlogWorthyMostViewedPosts_view();
        
        echo $after_widget;
    }

} // BlogWorthyMostViewedPosts Class - END



//**************************************************************************************
//  Output with debug mode
//**************************************************************************************
function BlogWorthyMostViewedPosts_view($debug = false) {
    $GAPP_cEn = get_option('BlogWorthyMostViewedPosts_cacheEnable');
    $GAPP_cEM = get_option('BlogWorthyMostViewedPosts_cacheExpiresMinutes');
    $GAPP_cEx = get_option('BlogWorthyMostViewedPosts_cacheExpires');
    $GAPP_che = get_option('BlogWorthyMostViewedPosts_cache');
    try {
        if($GAPP_cEn == 'yes') {
            $now = mktime(date("H"), date("i"), date("s"), date("m")  , date("d"), date("Y"));
            if($now > $GAPP_cEx or strlen($GAPP_che) == '') {
                $expire = $now + (60 * $GAPP_cEM);
                update_option('BlogWorthyMostViewedPosts_cacheExpires', $expire);
                update_option('BlogWorthyMostViewedPosts_cache', BlogWorthyMostViewedPosts_widget_output());
                $output = get_option('BlogWorthyMostViewedPosts_cache');
            }
            else
                $output = get_option('BlogWorthyMostViewedPosts_cache');
            }
        else {
            update_option('BlogWorthyMostViewedPosts_cache', '');
            $output = BlogWorthyMostViewedPosts_widget_output();
        }
    }
    catch(Exception $e) {
        if($debug == true) {
            $output = __('<br /><strong>Debug Report :<br /></strong><small>( In-case you see this you have some problem kindly used this data to report me or fix things yourself remember in always here to help. )</small><br />', 'google-analytics-most-viewed-posts');
            $output .= "<pre>$e</pre>";
        }
        else {
            if(stristr($e, "Invalid value for ids parameter"))
                $output = __('<b>Google Analytics Most Viewed Posts Alert :</b><br />Please check/recheck/enter your Google Analytics Profile ID.', 'google-analytics-most-viewed-posts');
            elseif(stristr($e, "Failed to request report data"))
                $output = __('<b>Google Analytics Most Viewed Posts Alert :</b><br />Please check/recheck/enter your Google Analytics Profile ID.', 'google-analytics-most-viewed-posts');
            elseif(stristr($e, "Failed to authenticate user"))
                $output = __('<b>Google Analytics Most Viewed Posts Alert :</b><br />Please check/recheck/enter your Google Analytics account details (username and password).', 'google-analytics-most-viewed-posts');
            else
                $output = __('<b>Google Analytics Most Viewed Posts Alert :</b><br />Unknown error please contact me at <a href=\"http://wensil.com\">Google Analytics Most Viewed Posts plugin page</a> if you find this error/message.', 'google-analytics-most-viewed-posts');
        }
    }
    echo $output;
}

//**************************************************************************************
//  Widget output
//**************************************************************************************
function BlogWorthyMostViewedPosts_widget_output() {
    $GAPP_usr = get_option('BlogWorthyMostViewedPosts_username');
    $GAPP_pwd = get_option('BlogWorthyMostViewedPosts_password');
    $GAPP_pID = get_option('BlogWorthyMostViewedPosts_profileID');
    $GAPP_mRs = get_option('BlogWorthyMostViewedPosts_maxResults');
    $GAPP_filter = get_option('BlogWorthyMostViewedPosts_filter');
    $GAPP_dDisp = get_option('BlogWorthyMostViewedPosts_dateDispEnable');
    $GAPP_pDisp = get_option('BlogWorthyMostViewedPosts_postDateEnable');
    $GAPP_cView = get_option('BlogWorthyMostViewedPosts_contentsViewEnable');
}


?>