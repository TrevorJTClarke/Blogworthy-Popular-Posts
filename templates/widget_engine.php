<?php
/**
 * Widget Engine
 * Creates Combined Html based on all the data from GA
 */
// TODO:
// require template_engine.php
// require today_post_template.php
// require week_post_template.php
// require month_post_template.php

function CreateWrapper ( $widget_title, $today_content, $week_content, $month_content ) {
    if(!$widget_title){return;}
    $template = '<div class="BPP_tabs" id="BPP_Popular_Posts">
                    <div class="bpp_widget_title">' . $widget_title . '</div>
                    <ul class="bpp_tab_container">
                        <li id="bpp_tab1" class="bpp_tab_item">Today</li>
                        <li id="bpp_tab2" class="bpp_tab_item">Week</li>
                        <li id="bpp_tab3" class="bpp_tab_item">All Time</li>
                    </ul>
                    <ul id="bpp_content1" class="TabbedPanelsContent">' . $today_content . '</ul>
                    <ul id="bpp_content2" class="TabbedPanelsContent">' . $week_content . '</ul>
                    <ul id="bpp_content3" class="TabbedPanelsContent">' . $month_content . '</ul>
                </div>';
    return $template;
}

// TODO:
// - loop through all 3
// - assemble into html block
// - return
function CreateWidget () {
    
    //format today data
    foreach($ga->getResults() as $result) {
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

    //format week data
    foreach($gaweek->getResults() as $weekresult) {
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

    // format all data
    foreach($gaall->getResults() as $allresult) {
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

    // TODO:
    // fire off logic for all data

    // TODO:
    // Construct Widget Html with data
    // CreateWrapper( $widget_title, $today_content, $week_content, $month_content );

}
?>