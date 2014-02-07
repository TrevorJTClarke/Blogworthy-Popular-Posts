<?php
/**
 * Widget Engine
 * Creates Combined Html based on all the data from GA
 */
//pull in required files
require(sprintf("%s/template_engine.php", dirname(__FILE__)));

// wraps all content after its been formatted
function CreateWrapper ( $widget_title, $today_content, $week_content, $month_content ) {
    if(!$widget_title){return;}
    $template = '<div class="bpp_tabs" id="BPP_Popular_Posts">
                    <div class="bpp_widget_title">' . $widget_title . '</div>
                    <ul class="bpp_tab_container">
                        <li id="bpp_tab1" class="bpp_tab_item">Today</li>
                        <li id="bpp_tab2" class="bpp_tab_item">Week</li>
                        <li id="bpp_tab3" class="bpp_tab_item">All Time</li>
                    </ul>
                    <ul id="bpp_content1" class="bpp_tab_content">' . $today_content . '</ul>
                    <ul id="bpp_content2" class="bpp_tab_content">' . $week_content . '</ul>
                    <ul id="bpp_content3" class="bpp_tab_content">' . $month_content . '</ul>
                </div>';
    return $template;
}

// formats all data into compilable data
function CreateWidget ( $title, $gaTodayData, $gaWeekData, $gaMonthData ) {
    
    //format today data
    foreach ($gaTodayData as $result) {
        $getPageviews  = $result->getPageviews();
        $getHostname = $result->getHostname();
        $getPagepath = $result->getPagepath();
        $postPagepath = 'http://'.$getHostname.$getPagepath;
        $getPostID = url_to_postid($postPagepath);
        $search_id[] = $getPostID;
        $todaypageviews[$getPostID] = $getPageviews;
        $todaypagepath[$getPostID] = $postPagepath;
    }
    $BlogWorthy_todaypageviews = $todaypageviews;
    $BlogWorthy_id = array_unique($search_id);
    $count = count($BlogWorthy_id);
    $BlogWorthy_todaypagepath = $todaypagepath;

    require(sprintf("%s/today_post_template.php", dirname(__FILE__)));
    $todayHtmlArray = implode("", $todayArray);

    //format week data
    foreach ($gaWeekData as $weekresult) {
        $getPageviews = $weekresult->getPageviews();
        $getHostname = $weekresult->getHostname();
        $getPagepath = $weekresult->getPagepath();
        $postPagepath = 'http://'.$getHostname.$getPagepath;
        $getPostID = url_to_postid($postPagepath);
        $search_weekid[] = $getPostID;
        $weeklypageviews[$getPostID] = $getPageviews;
        $weeklypagepath[$getPostID] = $postPagepath;
    }
    $BlogWorthy_weeklypageviews = $weeklypageviews;
    $BlogWorthy_weekids = array_unique($search_weekid);
    $countweekid = count($BlogWorthy_weekids);
    $BlogWorthy_weeklypagepath = $weeklypagepath;

    require(sprintf("%s/week_post_template.php", dirname(__FILE__)));
    $weekHtmlArray = implode("", $weekArray);

    // format all data
    foreach ($gaMonthData as $allresult) {
        $getPageviews  = $allresult->getPageviews();
        $getHostname = $allresult->getHostname();
        $getPagepath = $allresult->getPagepath();
        $postPagepath = 'http://'.$getHostname.$getPagepath;
        $getPostID = url_to_postid($postPagepath);
        $search_allid[] = $getPostID;
        $allpageviews[$getPostID] = $getPageviews;
        $allpagepath[$getPostID] = $postPagepath;
        $BlogWorthy_allpagepath = $allpagepath;
    }
    $BlogWorthy_allpageviews = $allpageviews;
    $BlogWorthy_allids = array_unique($search_allid);
    $countallid = count($BlogWorthy_allids);
    $BlogWorthy_allpagepath = $allpagepath;

    require(sprintf("%s/month_post_template.php", dirname(__FILE__)));
    $monthHtmlArray = implode("", $monthArray);
    
    // Construct Widget Html with data
    return CreateWrapper( $title, $todayHtmlArray, $weekHtmlArray, $monthHtmlArray );
}

?>