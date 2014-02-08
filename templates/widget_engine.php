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
    $template = '<div class="bpp_widget_block" id="BPP_Popular_Posts">
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
    require(sprintf("%s/today_post_template.php", dirname(__FILE__)));
    $todayArray = FormatTodayData( $gaTodayData );
    $todayHtmlArray = implode("", $todayArray);

    //format week data
    require(sprintf("%s/week_post_template.php", dirname(__FILE__)));
    $weekArray = FormatWeekData( $gaWeekData );
    $weekHtmlArray = implode("", $weekArray);

    // format all data
    require(sprintf("%s/month_post_template.php", dirname(__FILE__)));
    $monthArray = FormatMonthData( $gaMonthData );
    $monthHtmlArray = implode("", $monthArray);
    
    // Construct Widget Html with data
    return CreateWrapper( $title, $todayHtmlArray, $weekHtmlArray, $monthHtmlArray );
}

?>