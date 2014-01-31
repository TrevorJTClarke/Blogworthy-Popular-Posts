<?php
/**
 * WP_Widget::BlogWorthyMostViewedPosts
 * 
 * -------------- OLD -------------------
 * Constructor
 *     - extend base widget, setup defaults
 * WP_Widget::form
 *     - widget options in a form inside widgets menu
 * WP_Widget::update
 *     - save settings to the widget
 * WP_Widget::widget
 *     - builds the renderable piece of html, also holds GA logic
 * Register widget
 *     - adds to WP widget registry
 * Activate and Deactivate
 *     - loads plugin
 * Options
 *     - stores settings
 * Add admin menu
 *     - adds ot admin panel
 * Output with debug mode
 *     - this doesnt work
 * Widget output
 *     - grabs the stored widget data
 * Load  or unload custom style sheet and javascript
 *     - fix to pull from the correct area
 * Implementation of the short code
 *     - not sure if this works...
*/

// BlogWorthyMostViewedPosts Class
class BlogWorthyMostViewedPosts extends WP_Widget {

//**************************************************************************************
// Constructor
//**************************************************************************************
    function BlogWorthyMostViewedPosts() {
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
        $display_thumbnail = strip_tags($instance['display_thumbnail']);
        $display_excerpt = strip_tags($instance['display_excerpt']);
        $display_views = strip_tags($instance['display_views']);
        $home_page = strip_tags($instance['home_page']);
        $filtercatid = strip_tags($instance['filtercatid']);
        $filterpostid = strip_tags($instance['filterpostid']);

        require(sprintf("%s/templates/bpp_widget_admin_form.php", dirname(__FILE__)));
    }

//**************************************************************************************
// WP_Widget::update
//**************************************************************************************
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['max_post'] = strip_tags($new_instance['max_post']);
        $instance['display_thumbnail'] = strip_tags($new_instance['display_thumbnail']);
        $instance['display_excerpt'] = strip_tags($new_instance['display_excerpt']);
        $instance['display_views'] = strip_tags($new_instance['display_views']);
        $instance['home_page'] = strip_tags($new_instance['home_page']);
        $instance['filtercatid'] = strip_tags($new_instance['filtercatid']);
        $instance['filterpostid'] = strip_tags($new_instance['filterpostid']);
        
        return $instance;
    }

//**************************************************************************************
//  WP_Widget::widget
//**************************************************************************************
    function widget($args, $instance) {
        extract($args);

        // Option Vars
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
        $max_post = apply_filters('widget_max_post', empty($instance['max_post']) ? '' : $instance['max_post']);
        $display_thumbnail = apply_filters('display_thumbnail', empty($instance['display_thumbnail']) ? '' : $instance['display_thumbnail']);
        $display_excerpt = apply_filters('display_excerpt', empty($instance['display_excerpt']) ? '' : $instance['display_excerpt']);
        $display_views = apply_filters('display_views', empty($instance['display_views']) ? '' : $instance['display_views']);
        $home_page = apply_filters('home_page', empty($instance['home_page']) ? '' : $instance['home_page']);
        $filtercatid = apply_filters('filtercatid', empty($instance['filtercatid']) ? '' : $instance['filtercatid']);
        $filterpostid = apply_filters('filterpostid', empty($instance['filterpostid']) ? '' : $instance['filterpostid']);
        
        // GA Vars
        $BPP_GA = get_option('bpp_setting_options');
        $gaUsername = $BPP_GA['ga_email'];
        $gaPassword = $BPP_GA['ga_password'];
        $profileId = $BPP_GA['id_number'];

        // GA Option Vars
        $dimensions = array('pagePath');
        $metrics = array('uniquePageviews');
        $sort = '-uniquePageviews';
        $filter = 'pagePath=~\/[a-zA-Z0-9\-]+\/\d+$';
        $fromDate = date('Y-m-d', strtotime('-2 days'));
        $toDate = date('Y-m-d');

        $ga = new gapi($gaUsername, $gaPassword);
        $mostPopular = $ga->requestReportData($profileId, $dimensions, $metrics, $sort, $filter, $fromDate, $toDate, 1, 10);
        var_dump($mostPopular);
        // TODO:
        // $ga = new gapi($gauser,$gapwd);
        // $ga->requestReportData($gaid, array('hostname', 'pagePath'), array('pageviews','visits'), array('-pageviews','-visits'), $filter=$GAPP_filter_fixed.$GAPP_filter, $start_date=$BlogWorthyFrom, $end_date=$BlogWorthycurrent_date, $start_index=1, $max_results=$max_post);
        // // print_r($ga);
        // // echo "<br/><br/>";
        // $gaweek = new gapi($gauser,$gapwd);
        // $gaweek->requestReportData($gaid, array('hostname', 'pagePath'), array('pageviews','visits'), array('-pageviews','-visits'), $filter=$GAPP_filter_fixed.$GAPP_filter, $start_date=$BlogWorthyweek_From, $end_date=$BlogWorthycurrent_date, $start_index=1, $max_results=$max_post);
        // // print_r($ga);
        // // echo "<br/><br/>";
        // $gaall = new gapi($gauser,$gapwd);
        // $gaall->requestReportData($gaid, array('hostname', 'pagePath'), array('pageviews','visits'), array('-pageviews','-visits'), $filter=$GAPP_filter_fixed.$GAPP_filter, $start_date=$BlogWorthyall_From, $end_date=$BlogWorthycurrent_date, $start_index=1, $max_results=$max_post);
        


        
            $filter_catid= $filtercatid;
            $all_catid = explode(",",$filter_catid);
            
            $filter_postid= $filterpostid;
            $all_postid = explode(",",$filter_postid);
            // echo $before_title . $title ."<br/>".$max_post."<br/>".$display_excerpt."<br/>".$home_page."<br/>".$after_title;
            echo $before_title . "<h2>" . $title . "</h2>" . $after_title;
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

        // TODO:
        // require widget_engine.php
        // construct widget
        

        echo $before_widget;

        // TODO:
        // echo $contructed_widget;

        // TODO:
        // ???? what does this do?
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