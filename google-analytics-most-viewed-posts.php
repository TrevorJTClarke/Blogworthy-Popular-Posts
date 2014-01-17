<?php
/*
Plugin Name: Blogworthy Popular Posts
Description: This plugin uses Google Analytics API to fetch data from your analytics account and displays most viewed posts in the widget.
Author: Trevor Clarke
Author URI: http://blogworthy.com
*/




// BlogWorthyMostViewedPosts Class
class BlogWorthyMostViewedPosts extends WP_Widget {

//**************************************************************************************
// Constructor
//**************************************************************************************
	function BlogWorthyMostViewedPosts() {
		$GAPP_url = get_bloginfo('siteurl');
		$lang = dirname( plugin_basename(__FILE__)) . "/languages";
		load_plugin_textdomain('google-analytics-most-viewed-posts', false, $lang);
		$widget_ops = array('description' => __('This plugin uses Google Analytics API to fetch data from your analytics account and displays most viewed posts in the widget.', 'google-analytics-most-viewed-posts'));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::WP_Widget(false, $name = __('Google Analytics Most Viewed Posts', 'google-analytics-most-viewed-posts'), $widget_ops, $control_ops);
	}

//**************************************************************************************
// WP_Widget::form
//**************************************************************************************
	function form($instance) {
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
?>
<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('<b>Title:</b>', 'google-analytics-most-viewed-posts'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
         </p>
        
<p>
		<input class="widefat" id="<?php echo $this->get_field_id('gauser'); ?>" name="<?php echo $this->get_field_name('gauser'); ?>" type="hidden" value="<?php echo get_option('BlogWorthyMostViewedPosts_username'); ?>" /></p>


<p>
		<input class="widefat" id="<?php echo $this->get_field_id('gapwd'); ?>" name="<?php echo $this->get_field_name('gapwd'); ?>" type="hidden" value="<?php echo get_option('BlogWorthyMostViewedPosts_password'); ?>" /></p>
        
<p>
		<input class="widefat" id="<?php echo $this->get_field_id('gaid'); ?>" name="<?php echo $this->get_field_name('gaid'); ?>" type="hidden" value="<?php echo get_option('BlogWorthyMostViewedPosts_profileID'); ?>" /></p>
                
<p><label for="<?php echo $this->get_field_id('max_post'); ?>"><?php _e('<b>Most Viewed Posts Max Results:</b>', 'google-analytics-most-viewed-posts'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('max_post'); ?>" name="<?php echo $this->get_field_name('max_post'); ?>" type="text" value="<?php echo esc_attr($max_post); ?>" />
        <br/>
        <span><strong>Example:5 or 10 or 15 or 20 etc.</strong></span>
        </p>

<p><label for="<?php echo $this->get_field_id('display_excerpt'); ?>"><?php _e('<b>Enable the display of excerpt?:</b>', 'google-analytics-most-viewed-posts'); ?></label>
		<input  id="<?php echo $this->get_field_id('display_excerpt'); ?>" name="<?php echo $this->get_field_name('display_excerpt'); ?>" type="radio" value="yes" checked="checked"/>Yes<input id="<?php echo $this->get_field_id('display_excerpt'); ?>" name="<?php echo $this->get_field_name('display_excerpt'); ?>" type="radio" value="no" />No
        <br/>
        <span>Can enable / disable the display of excerpt.</span>
        
        </p>
        
<p><label for="<?php echo $this->get_field_id('thumbnail'); ?>"><?php _e('<b>Show Thumbnail:</b>', 'google-analytics-most-viewed-posts'); ?></label>
		<input  id="<?php echo $this->get_field_id('thumbnail'); ?>" name="<?php echo $this->get_field_name('thumbnail'); ?>" type="checkbox" value="yes" <?php if($thumbnail == 'yes'){ echo 'checked="checked"'; } else{}; ?>  />
       </p>
       

<p><label for="<?php echo $this->get_field_id('home_page'); ?>"><?php _e('<b>Remove home page from list:</b>', 'google-analytics-most-viewed-posts'); ?></label>
		<input  id="<?php echo $this->get_field_id('home_page'); ?>" name="<?php echo $this->get_field_name('home_page'); ?>" type="checkbox" value="yes" checked="checked" />
       
        </p>
       

<p><label for="<?php echo $this->get_field_id('filtercatid'); ?>"><?php _e('<b>Filter Out Category:</b>', 'google-analytics-most-viewed-posts'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('filtercatid'); ?>" name="<?php echo $this->get_field_name('filtercatid'); ?>" type="text" value="<?php echo esc_attr($filtercatid); ?>" />
        <br/>
        <span>To remove specific categories, place comma separated category ID's.</span>
        </p>

<p><label for="<?php echo $this->get_field_id('filterpostid'); ?>"><?php _e('<b>Filter Out Post:</b>', 'google-analytics-most-viewed-posts'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('filterpostid'); ?>" name="<?php echo $this->get_field_name('filterpostid'); ?>" type="text" value="<?php echo esc_attr($filterpostid); ?>" />
        <br/>
        <span>To remove specific Posts, place comma separated post ID's.</span>
        </p>

    
<?php
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
		
			$filter_catid= $filtercatid;
			$all_catid = explode(",",$filter_catid);
			
			$filter_postid= $filterpostid;
			$all_postid = explode(",",$filter_postid);
			//echo $before_title . $title ."<br/>".$max_post."<br/>".$display_excerpt."<br/>".$home_page."<br/>".$after_title;
			echo $before_title . $title .$after_title;
		$GAPP_filter_fixed = 'ga:pagePath=~^/';		
	require 'gapi.class.php';



$BlogWorthy_today = 1;
$BlogWorthy_week = 7;
$BlogWorthy_month = 30;
		
$BlogWorthytodays_year = date("Y");
	$BlogWorthytodays_month = date("m");
	$BlogWorthytodays_day = date("d");
	$BlogWorthycurrent_date = "$BlogWorthytodays_year-$BlogWorthytodays_month-$BlogWorthytodays_day";
	$BlogWorthydaydate = strtotime ( "-$BlogWorthy_today day" , strtotime ( $BlogWorthycurrent_date ) ) ;
	$BlogWorthydaydate = date ( 'Y-m-d' , $BlogWorthydaydate );
	$BlogWorthyFrom = $BlogWorthydaydate;
		
	
	//Get weekly date
	$BlogWorthyweekdates = strtotime ( "-$BlogWorthy_week day" , strtotime ( $BlogWorthycurrent_date ) ) ;
	$BlogWorthyweekdates = date ( 'Y-m-d' , $BlogWorthyweekdates );
	$BlogWorthyweek_From = $BlogWorthyweekdates;
		
	
	//Get Monthly date
	$BlogWorthyalldates = strtotime ( "-$BlogWorthy_month day" , strtotime ( $BlogWorthycurrent_date ) ) ;
	$BlogWorthyalldates = date ( 'Y-m-d' , $BlogWorthyalldates );
	$BlogWorthyall_From = $BlogWorthyalldates;	

 $ga = new gapi($gauser,$gapwd);
$ga->requestReportData($gaid, array('hostname', 'pagePath'), array('pageviews','visits'), array('-pageviews','-visits'), $filter=$GAPP_filter_fixed.$GAPP_filter, $start_date=$BlogWorthyFrom, $end_date=$BlogWorthycurrent_date, $start_index=1, $max_results=$max_post);
//print_r($ga);
//echo "<br/><br/>";

 $gaweek = new gapi($gauser,$gapwd);
$gaweek->requestReportData($gaid, array('hostname', 'pagePath'), array('pageviews','visits'), array('-pageviews','-visits'), $filter=$GAPP_filter_fixed.$GAPP_filter, $start_date=$BlogWorthyweek_From, $end_date=$BlogWorthycurrent_date, $start_index=1, $max_results=$max_post);
//print_r($ga);
//echo "<br/><br/>";



$gaall = new gapi($gauser,$gapwd);
$gaall->requestReportData($gaid, array('hostname', 'pagePath'), array('pageviews','visits'), array('-pageviews','-visits'), $filter=$GAPP_filter_fixed.$GAPP_filter, $start_date=$BlogWorthyall_From, $end_date=$BlogWorthycurrent_date, $start_index=1, $max_results=$max_post);
//print_r($gaall);

foreach($ga->getResults() as $result)
{
  
  		$getPageviews  = $result->getPageviews();
  		$getHostname = $result->getHostname();
		$getPagepath = $result->getPagepath();
		$postPagepath = 'http://'.$getHostname.$getPagepath;
		$getPostID = url_to_postid($postPagepath);
		$search_id[]=$getPostID;
		$todaypageviews[$getPostID] = $getPageviews;
		$todaypagepath[$getPostID] = $postPagepath;
		
}

			$BlogWorthy_todaypageviews = $todaypageviews;
			$BlogWorthy_id = array_unique($search_id);
			$count = count($BlogWorthy_id);
			$BlogWorthy_todaypagepath = $todaypagepath;
	

foreach($gaweek->getResults() as $weekresult)
{
  
  		$getPageviews = $weekresult->getPageviews();
  		$getHostname = $weekresult->getHostname();
		$getPagepath = $weekresult->getPagepath();
		$postPagepath = 'http://'.$getHostname.$getPagepath;
		$getPostID = url_to_postid($postPagepath);
		$search_weekid[]=$getPostID;
		$weeklypageviews[$getPostID] = $getPageviews;
		$weeklypagepath[$getPostID] = $postPagepath;
		
}
			$BlogWorthy_weeklypageviews = $weeklypageviews;
			$BlogWorthy_weekids = array_unique($search_weekid);
			$countweekid = count($BlogWorthy_weekids);
			$BlogWorthy_weeklypagepath = $weeklypagepath;

foreach($gaall->getResults() as $allresult)
{
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
			?>
					
			
	<div class="TabbedPanels" id="BlogWorthy_TabbedPanelspost">
		<ul class="TabbedPanelsTabGroup">
			<li class="TabbedPanelsTab">Today</li> 
            <li class="TabbedPanelsTab">Week</li> 
			<li class="TabbedPanelsTab">All Time</li> 
            
			
		</ul>
		<div class="TabbedPanelsContentGroup">
			<div class="TabbedPanelsContent">
            
            
          <?php
		   for ($x=1; $x<$count; $x++)
  {
  		$BlogWorthy_todaysingleid = $BlogWorthy_id[$x];
  		
			$titleStr = get_the_title($BlogWorthy_todaysingleid);
			$post = get_post($BlogWorthy_todaysingleid);
			$dateStr = mysql2date('Y-m-d', $post->post_date);
			$contentStr = strip_tags(mb_substr($post->post_content, 0, 60));
			$image = wp_get_attachment_image_src( get_post_thumbnail_id($BlogWorthy_todaysingleid), 'single-post-thumbnail' );
			$category_detail=get_the_category($BlogWorthy_todaysingleid);//$post->ID
		foreach($category_detail as $cd){
		//echo $cd->cat_name;
		//echo $cd->cat_ID;
		}
		
			if($display_excerpt == "yes" && $home_page == "yes" && $thumbnail == "yes"){
				if($BlogWorthy_todaysingleid == 0)
				{}
				else
				{
				
			if (in_array($cd->cat_ID, $all_catid))
  			{
			}
				else{
					if (in_array($BlogWorthy_todaysingleid, $all_postid))
  			{
				}
					  else
					  {
						  echo $today_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_todaypagepath[$BlogWorthy_todaysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px"  /></div><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_todaypageviews[$BlogWorthy_todaysingleid].' )</span></div></div></li></ul>';
					  }
				}
				}
			}
			
			elseif($display_excerpt == "yes" && $home_page == "yes" && $thumbnail == ""){
				if($BlogWorthy_todaysingleid == 0)
				{}
				else
				{
				
			if (in_array($cd->cat_ID, $all_catid))
  			{
			}
				else{
					if (in_array($BlogWorthy_todaysingleid, $all_postid))
  			{
				}
					  else
					  {
						  echo $today_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_todaypagepath[$BlogWorthy_todaysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_todaypageviews[$BlogWorthy_todaysingleid].' )</span></div></div></li></ul>';
					  }
				}
				}
			}
			
			elseif($display_excerpt == "yes" && $home_page == "" && $thumbnail == ""){
			if (in_array($cd->cat_ID, $all_catid))
  			{
			}
			else
			{	
			if (in_array($BlogWorthy_todaysingleid, $all_postid))
  			{
				}
					  else
					  {
			
			echo $today_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_todaypagepath[$BlogWorthy_todaysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_todaypageviews[$BlogWorthy_todaysingleid].' )</span></div></div></li></ul>';
					  }
			}
			}
			
			
			elseif($display_excerpt == "yes" && $home_page == "" && $thumbnail == "yes"){
			if (in_array($cd->cat_ID, $all_catid))
  			{
			}
			else
			{	
			if (in_array($BlogWorthy_todaysingleid, $all_postid))
  			{
				}
					  else
					  {
			
			echo $today_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_todaypagepath[$BlogWorthy_todaysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px"  /></div><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_todaypageviews[$BlogWorthy_todaysingleid].' )</span></div></div></li></ul>';
					  }
			}
			}
			
			
			
			
			elseif($display_excerpt == "no" && $home_page == "" && $thumbnail == ""){
				
			if (in_array($cd->cat_ID, $all_catid))
  			{
			}
			else
			{		
			if (in_array($BlogWorthy_todaysingleid, $all_postid))
  			{
				}
					  else
					  {	
				
			echo $today_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_todaypagepath[$BlogWorthy_todaysingleid].'>'.$titleStr.'</a></div></li></ul>';
			}
			}
			}
			
			elseif($display_excerpt == "no" && $home_page == "" && $thumbnail == "yes"){
				
			if (in_array($cd->cat_ID, $all_catid))
  			{
			}
			else
			{		
			if (in_array($BlogWorthy_todaysingleid, $all_postid))
  			{
				}
					  else
					  {	
				
			echo $today_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_todaypagepath[$BlogWorthy_todaysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px"  /></div></div></li></ul>';
			}
			}
			}
			
			
			elseif($display_excerpt == "no" && $home_page == "yes" && $thumbnail == "yes"){
				if($BlogWorthy_todaysingleid == 0){
				}
				else
				{
					if (in_array($cd->cat_ID, $all_catid))
  					{
						}
			else
			{
				if (in_array($BlogWorthy_todaysingleid, $all_postid))
  					{}
					  else
					  {	
					
					
					echo $today_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_todaypagepath[$BlogWorthy_todaysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px"  /></div></div></li></ul>';
				}
			}
				}
				
			}
			
			elseif($display_excerpt == "no" && $home_page == "yes" && $thumbnail == ""){
				if($BlogWorthy_todaysingleid == 0){
				}
				else
				{
					if (in_array($cd->cat_ID, $all_catid))
  					{
						}
			else
			{
				if (in_array($BlogWorthy_todaysingleid, $all_postid))
  					{}
					  else
					  {	
					
					
					echo $today_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_todaypagepath[$BlogWorthy_todaysingleid].'>'.$titleStr.'</a></div></li></ul>';
				}
			}
				}
				
			}
			
			
			
			else
			{
				echo $today_post_output= 'Something wrong!! Please try again...';
				
			}
			
			
			
  }
   
		  ?>
         
         
         
         </div>
			<div class="TabbedPanelsContent">
       <?php
             for ($y=1; $y<$countweekid; $y++)
  {
  	$BlogWorthy_weeklysingleid = $BlogWorthy_weekids[$y];
  	
		
			$titleStr = get_the_title($BlogWorthy_weeklysingleid);
			$post = get_post($BlogWorthy_weeklysingleid);
			$dateStr = mysql2date('Y-m-d', $post->post_date);
			$contentStr = strip_tags(mb_substr($post->post_content, 0, 60));
			$image = wp_get_attachment_image_src( get_post_thumbnail_id($BlogWorthy_weeklysingleid), 'single-post-thumbnail' );
			$category_detail=get_the_category($BlogWorthy_weeklysingleid);//$post->ID
		foreach($category_detail as $cd){
	
		//echo $cd->cat_ID;
		}
			if($display_excerpt == "yes" && $home_page == "yes" && $thumbnail == "yes"){
				if($BlogWorthy_weeklysingleid == 0)
				{}
				else
				{
					
					if (in_array($cd->cat_ID, $all_catid)){
				}
				else{	
				if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
						}
					  else
					  {
			echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px" /></div><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_weeklypageviews[$BlogWorthy_weeklysingleid].' )</span></div>
			</div></li></ul>';
					  }
				}
				}
			}
			
			
			
			elseif($display_excerpt == "yes" && $home_page == "yes" && $thumbnail ==""){
				if($BlogWorthy_weeklysingleid == 0)
				{}
				else
				{
					
					if (in_array($cd->cat_ID, $all_catid)){
				}
				else{	
				if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
						}
					  else
					  {
			echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_weeklypageviews[$BlogWorthy_weeklysingleid].' )</span></div>
			</div></li></ul>';
					  }
				}
				}
			}
			
			
			elseif($display_excerpt == "yes" && $home_page == "" && $thumbnail ==""){
				
				if (in_array($cd->cat_ID, $all_catid)){
				}
				else{	
				
				if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
						}
					  else
					  {
				
				echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_weeklypageviews[$BlogWorthy_weeklysingleid].' )</span></div>
			</div></li></ul>';	
					  }
			}
			}
			
			
			
			
				elseif($display_excerpt == "yes" && $home_page == "" && $thumbnail =="yes"){
				
				if (in_array($cd->cat_ID, $all_catid)){
				}
				else{	
				
				if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
						}
					  else
					  {
				
				echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px" /></div><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_weeklypageviews[$BlogWorthy_weeklysingleid].' )</span></div>
			</div></li></ul>';	
					  }
			}
			}
			
			elseif($display_excerpt == "no" && $home_page == "" && $thumbnail ==""){
				if (in_array($cd->cat_ID, $all_catid)){
				}
				else{	
					if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
						}
					  else
					  {
			echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a></div></li></ul>';	
			}
				}
			}
			
			elseif($display_excerpt == "no" && $home_page == "" && $thumbnail =="yes"){
				if (in_array($cd->cat_ID, $all_catid)){
				}
				else{	
					if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
						}
					  else
					  {
			echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px" /></div></div></li></ul>';	
			}
				}
			}
			
			
			elseif($display_excerpt == "no" && $home_page == "yes" && $thumbnail =="yes"){
				if($BlogWorthy_weeklysingleid == 0){
				}
				else
				{
						if (in_array($cd->cat_ID, $all_catid)){
				}
				else{
					if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
						}
					  else
					  {
					
					
					echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a>
					<br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px" /></div></div></li></ul>';
				}
				}
				}
				
			}
			
			elseif($display_excerpt == "no" && $home_page == "yes" && $thumbnail ==""){
				if($BlogWorthy_weeklysingleid == 0){
				}
				else
				{
						if (in_array($cd->cat_ID, $all_catid)){
				}
				else{
					if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
						}
					  else
					  {
					
					
					echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a></div>
					</li></ul>';
				}
				}
				}
				
			}
			
			else
			{
				echo $week_post_output= 'Something wrong!! Please try again...';
				
			}
			
  }
  
            
            ?>
            </div>
			<div class="TabbedPanelsContent">
            
             <?php
             for ($z=1; $z<$countallid; $z++)
  {
  $BlogWorthy_allsingleid = $BlogWorthy_allids[$z];
 
		
			$titleStr = get_the_title($BlogWorthy_allsingleid);
			$post = get_post($BlogWorthy_allsingleid);
			$dateStr = mysql2date('Y-m-d', $post->post_date);
			$contentStr = strip_tags(mb_substr($post->post_content, 0, 60));
		
		$category_detail=get_the_category($BlogWorthy_allsingleid);//$post->ID
		foreach($category_detail as $cd){
		
		//echo $cd->cat_ID;
		}
			
			
			$image = wp_get_attachment_image_src( get_post_thumbnail_id($BlogWorthy_allsingleid), 'single-post-thumbnail' );
			if($display_excerpt == "yes" && $home_page == "yes" && $thumbnail == "yes"){
				if($BlogWorthy_allsingleid == 0)
				{}
				else
				{
					
				if (in_array($cd->cat_ID, $all_catid))	{
				}
				else{
					if (in_array($BlogWorthy_allsingleid, $all_postid)){
						}
					  else
					  {
					
			echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px"  /></div><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_allpageviews[$BlogWorthy_allsingleid].' )</span></div>
			</div></li></ul>';
					  }
				}
				}
			}
			
			elseif($display_excerpt == "yes" && $home_page == "yes" && $thumbnail == ""){
				if($BlogWorthy_allsingleid == 0)
				{}
				else
				{
					
				if (in_array($cd->cat_ID, $all_catid))	{
				}
				else{
					if (in_array($BlogWorthy_allsingleid, $all_postid)){
						}
					  else
					  {
					
			echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_allpageviews[$BlogWorthy_allsingleid].' )</span></div>
			</div></li></ul>';
					  }
				}
				}
			}
			
			elseif($display_excerpt == "yes" && $home_page == "" && $thumbnail == ""){
				
				if (in_array($cd->cat_ID, $all_catid))	{
				}
				else{
				if (in_array($BlogWorthy_allsingleid, $all_postid)){
						}
					  else
					  {
			echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_allpageviews[$BlogWorthy_allsingleid].' )</span></div>
			</div></li></ul>';
					  }
				}
			}
			
			
			elseif($display_excerpt == "yes" && $home_page == "" && $thumbnail == "yes"){
				
				if (in_array($cd->cat_ID, $all_catid))	{
				}
				else{
				if (in_array($BlogWorthy_allsingleid, $all_postid)){
						}
					  else
					  {
			echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px"  /></div><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_allpageviews[$BlogWorthy_allsingleid].' )</span></div>
			</div></li></ul>';
					  }
				}
			}
			
			elseif($display_excerpt == "no" && $home_page == "" && $thumbnail == ""){
				if (in_array($cd->cat_ID, $all_catid))	{
				}
				else{
					if (in_array($BlogWorthy_allsingleid, $all_postid)){
						}
					  else
					  {
			echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a></div></li></ul>';	
			}
				}
			}
			
			elseif($display_excerpt == "no" && $home_page == "" && $thumbnail == "yes"){
				if (in_array($cd->cat_ID, $all_catid))	{
				}
				else{
					if (in_array($BlogWorthy_allsingleid, $all_postid)){
						}
					  else
					  {
			echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px"  /></div></div></li></ul>';	
			}
				}
			}
			
			
			elseif($display_excerpt == "no" && $home_page == "yes" && $thumbnail == "yes"){
				if($BlogWorthy_allsingleid == 0){
				}
				else
				{
					if (in_array($cd->cat_ID, $all_catid))	{
				}
				else{
					if (in_array($BlogWorthy_allsingleid, $all_postid)){
						}
					  else
					  {
					
					echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px"  /></div></div></li></ul>';
				}
				}
				}
				
			}
			
			
			elseif($display_excerpt == "no" && $home_page == "yes" && $thumbnail == ""){
				if($BlogWorthy_allsingleid == 0){
				}
				else
				{
					if (in_array($cd->cat_ID, $all_catid))	{
				}
				else{
					if (in_array($BlogWorthy_allsingleid, $all_postid)){
						}
					  else
					  {
					
					echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a></div></li></ul>';
				}
				}
				}
				
			} 
			
			else
			{
				echo $all_post_output= 'Something wrong!! Please try again...';
				
			}
			
			
  }		
            
            ?>
            </div> 
			</div> 
	</div><script type="text/javascript">
	var BlogWorthy_TabbedPanelspost = new Spry.Widget.TabbedPanels("BlogWorthy_TabbedPanelspost");
</script>
			
			
	<?php		
	
		BlogWorthyMostViewedPosts_view();
		echo $after_widget;
	}
} // BlogWorthyMostViewedPosts Class - END

//**************************************************************************************
//  Register widget
//**************************************************************************************
function BlogWorthyMostViewedPostsInit() {
    register_widget('BlogWorthyMostViewedPosts');
}
add_action('widgets_init', 'BlogWorthyMostViewedPostsInit');

//**************************************************************************************
// Activate and Deactivate
//**************************************************************************************
function BlogWorthyMostViewedPosts_activate() {
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
}
function BlogWorthyMostViewedPosts_deactivate() {
}
register_activation_hook(__FILE__, 'BlogWorthyMostViewedPosts_activate');
register_deactivation_hook(__FILE__, 'BlogWorthyMostViewedPosts_deactivate' );

//**************************************************************************************
//  Options
//**************************************************************************************
function BlogWorthyMostViewedPosts_options() {
	if($_POST['Submit'] == "Save") {
		$expire = mktime(date("H"), date("i"), date("s"), date("m")  , date("d"), date("Y")) + (60 * $_POST['BlogWorthyMostViewedPosts_cacheExpiresMinutes']);
		$now = mktime(date("H"), date("i"), date("s"), date("m")  , date("d"), date("Y"));
		update_option('BlogWorthyMostViewedPosts_username', $_POST['BlogWorthyMostViewedPosts_username']);
		if($_POST['BlogWorthyMostViewedPosts_password'])
			update_option('BlogWorthyMostViewedPosts_password', $_POST['BlogWorthyMostViewedPosts_password']);
		update_option('BlogWorthyMostViewedPosts_profileID' , $_POST['BlogWorthyMostViewedPosts_profileID']);
		update_option('BlogWorthyMostViewedPosts_maxResults', $_POST['BlogWorthyMostViewedPosts_maxResults']?$_POST['BlogWorthyMostViewedPosts_maxResults']:5);
		
		
// magic_quotes_gpc = On
		if (get_magic_quotes_gpc()) {
			$_POST['BlogWorthyMostViewedPosts_filter'] = stripslashes($_POST['BlogWorthyMostViewedPosts_filter']);
		}
		update_option('BlogWorthyMostViewedPosts_filter' , $_POST['BlogWorthyMostViewedPosts_filter']);
		update_option('BlogWorthyMostViewedPosts_dateDispEnable', $_POST['BlogWorthyMostViewedPosts_dateDispEnable']);
		update_option('BlogWorthyMostViewedPosts_postDateEnable', $_POST['BlogWorthyMostViewedPosts_postDateEnable']);
		update_option('BlogWorthyMostViewedPosts_contentsViewEnable', $_POST['BlogWorthyMostViewedPosts_contentsViewEnable']);
		update_option('BlogWorthyMostViewedPosts_cssEnable', $_POST['BlogWorthyMostViewedPosts_cssEnable']);
		update_option('BlogWorthyMostViewedPosts_cacheEnable', $_POST['BlogWorthyMostViewedPosts_cacheEnable']);
		update_option('BlogWorthyMostViewedPosts_cacheExpiresMinutes', $_POST['BlogWorthyMostViewedPosts_cacheExpiresMinutes']);
		update_option('BlogWorthyMostViewedPosts_cacheExpires', $expire);
	}
?>
		<div class="wrap">
			<div class="icon32" id="icon-options-general"><br/></div>
			<h2 style="margin-top:0px">Google Analytics Most Viewed Posts </h2>
			<p><?php _e('by', 'google-analytics-most-viewed-posts'); ?> <strong><a href="http://wensil.com/" target="_blank">Wensil iTechnologies</a></strong></p>
           <form method="post">
				<table class="form-table">
					<tbody>
					<tr valign="top">
						<th scope="row"><label for="GoogleAnalyticsMostViewedPosts_username"><?php _e('Google Account Email ID:', 'google-analytics-most-viewed-posts'); ?></label></th>
						<td>
							<input type="text" class="regular-text" value="<?php echo get_option('BlogWorthyMostViewedPosts_username'); ?>" name="BlogWorthyMostViewedPosts_username"/><br />
							<span class="setting-description"><?php _e('Please fill the email address you use to login to your Google Analytics.', 'google-analytics-most-viewed-posts'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="GoogleAnalyticsMostViewedPosts_password"><?php _e('Google Account Password:', 'google-analytics-most-viewed-posts'); ?></label></th>
						<td>
							<input type="password" class="regular-text" value="<?php echo get_option('BlogWorthyMostViewedPosts_password'); ?>" name="BlogWorthyMostViewedPosts_password"/><br />
							<span class="setting-description"><?php _e('Please fill password correct too again.', 'google-analytics-most-viewed-posts'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="GoogleAnalyticsMostViewedPosts_profileID"><?php _e('Google Analytics Profile ID:', 'google-analytics-most-viewed-posts'); ?></label></th>
						<td>
							<input type="text" class="regular-text" value="<?php echo get_option('BlogWorthyMostViewedPosts_profileID'); ?>" name="BlogWorthyMostViewedPosts_profileID"/><br />
							<span class="setting-description"><?php _e('Your GA Profile ID is NOT your "UA-xxxxxx-xx" number. Actually it is a 9 digit number unique to your site profile.<br/>
							To get it you need to: <br/> 1). Log into Google Analytics.<br/> 2). Access your site\'s profile (get to the dashboard).<br/> 3). Your URL should look like: https://www.google.com/analytics/web/#report/visitors-overview/a1234b23478970<b>p</b>987654/ <br/>4). That last part, after the <b>"p"</b> is your Google Analytics Profile ID, in this case (this is a fake account) it is <b>"<font color="#21759B">987654</font>"</b>
.)', 'google-analytics-most-viewed-posts'); ?></span>
						</td>
					</tr>
                    </tbody>
                    </table>
                    </form> 
			
<?php
	$GAPP_css = get_option('BlogWorthyMostViewedPosts_cssEnable');
	if ($GAPP_css == "yes") {
		echo '<div style="width:300px; float:left; list-style-type: none;"> <style type="text/css"> .BlogWorthy_most_viewed_post { background: #ffffff; border: 1px solid #cccccc; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px; -moz-box-shadow: inset 0 0 5px 5px #f5f5f5; -webkit-box-shadow: inset 0 0 5px 5px #f5f5f5; box-shadow: inset 0 0 5px 5px #f5f5f5; padding: 10px; margin: 1em 0; padding-bottom: 10px; margin-bottom: 10px; } </style>';
		echo '<h3>';
		//echo __('Preview', 'google-analytics-most-viewed-posts');
		echo '</h3>';
		//BlogWorthyMostViewedPosts_view(true);
		echo '</div>';
	}
	else {
		echo '<div style="float:left; list-style-type: none;">';
		echo '<h3>';
		echo __('Preview', 'google-analytics-most-viewed-posts');
		echo '</h3>';
		//BlogWorthyMostViewedPosts_view(true);
		echo '</div>';
	}
?>
		</div>
<?php
}

//**************************************************************************************
//  Add admin menu
//**************************************************************************************
function BlogWorthyMostViewedPosts_menu() {
    add_options_page('Google Analytics Most Viewed Posts', 'Google Analytics Most Viewed Posts', 8, __FILE__, 'BlogWorthyMostViewedPosts_options');
}
add_action('admin_menu', 'BlogWorthyMostViewedPosts_menu');

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

//**************************************************************************************
// Load  or unload custom style sheet and javascript
//**************************************************************************************

function loadCSSandJS() {
	$style = get_template_directory().'/google-analytics-most-viewed-posts.css';
	$tabing_style = get_template_directory().'/SpryTabbedPanels.css';
	$tabing_script = get_template_directory().'/SpryTabbedPanels.js';
	
	 if (is_file($style)) {
		$style = get_bloginfo('stylesheet_directory').'/google-analytics-most-viewed-posts.css';
		$tabing_style = get_bloginfo('stylesheet_directory').'/SpryTabbedPanels.css';
		$tabing_script = get_bloginfo().'/SpryTabbedPanels.js';
	} else {
		$url = WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__));
		$style = $url.'/google-analytics-most-viewed-posts.css';
		$tabing_style = $url.'/SpryTabbedPanels.css';
		$tabing_script = $url.'/SpryTabbedPanels.js';
	}
	echo "<!--Google Analytics Most Viewed Posts plugin CSS & JS-->\n";
	echo '<link rel="stylesheet" type="text/css" media="all" href="'.$style.'"><br/>';
	echo '<link rel="stylesheet" type="text/css" media="all" href="'.$tabing_style.'"><br/>';
	echo '<script type="text/javascript" src="'.$tabing_script.'"></script>';
}
//$GAPP_css = get_option('BlogWorthyMostViewedPosts_cssEnable');
add_action('wp_head', 'loadCSSandJS');
/*if ($GAPP_css == "yes") {
	add_action('wp_head', 'loadCSSandJS');
} else {
	remove_action('wp_head', 'loadCSSandJS');
}*/

//**************************************************************************************
// Implementation of the short code
//**************************************************************************************
function GAPP_shortcode() {
	$output = BlogWorthyMostViewedPosts_view(true);
	return $output;
}
add_shortcode('GAPP_VIEW', 'GAPP_shortcode');
 
?>