<?php 
/**
 * BPP: Widget Admin Form Template
 */
?>
<p>
    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('<b>Title:</b>', 'blogworthy-popular-posts'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('max_post'); ?>"><?php _e('<b>Max Results:</b>', 'blogworthy-popular-posts'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('max_post'); ?>" name="<?php echo $this->get_field_name('max_post'); ?>" type="text" value="<?php echo esc_attr($max_post); ?>" />
    <br/>
    <span><strong>Example: 5, 10, 15, 20, etc.</strong></span>
</p>
<p>
    <label for="<?php echo $this->get_field_id('display_thumbnail'); ?>"><?php _e('<b>Show Thumbnail?:</b>', 'blogworthy-popular-posts'); ?></label>
    <input  id="<?php echo $this->get_field_id('display_thumbnail'); ?>" name="<?php echo $this->get_field_name('display_thumbnail'); ?>" type="radio" value="yes" checked="checked"/>Yes<input id="<?php echo $this->get_field_id('display_thumbnail'); ?>" name="<?php echo $this->get_field_name('display_thumbnail'); ?>" type="radio" value="no" />No
</p>
<p>
    <label for="<?php echo $this->get_field_id('display_excerpt'); ?>"><?php _e('<b>Show excerpt?:</b>', 'blogworthy-popular-posts'); ?></label>
    <input  id="<?php echo $this->get_field_id('display_excerpt'); ?>" name="<?php echo $this->get_field_name('display_excerpt'); ?>" type="radio" value="yes" checked="checked"/>Yes<input id="<?php echo $this->get_field_id('display_excerpt'); ?>" name="<?php echo $this->get_field_name('display_excerpt'); ?>" type="radio" value="no" />No
</p>
<p>
    <label for="<?php echo $this->get_field_id('display_views'); ?>"><?php _e('<b>Show Views?:</b>', 'blogworthy-popular-posts'); ?></label>
    <input  id="<?php echo $this->get_field_id('display_views'); ?>" name="<?php echo $this->get_field_name('display_views'); ?>" type="radio" value="yes" checked="checked"/>Yes<input id="<?php echo $this->get_field_id('display_views'); ?>" name="<?php echo $this->get_field_name('display_views'); ?>" type="radio" value="no" />No
</p>
<p>
    <label for="<?php echo $this->get_field_id('home_page'); ?>"><?php _e('<b>Remove home page from list?:</b>', 'blogworthy-popular-posts'); ?></label>
    <input  id="<?php echo $this->get_field_id('home_page'); ?>" name="<?php echo $this->get_field_name('home_page'); ?>" type="radio" value="yes" checked="checked"/>Yes<input id="<?php echo $this->get_field_id('home_page'); ?>" name="<?php echo $this->get_field_name('home_page'); ?>" type="radio" value="no" />No
</p>
<p>
    <label for="<?php echo $this->get_field_id('filtercatid'); ?>"><?php _e('<b>Filter Out Category:</b>', 'blogworthy-popular-posts'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('filtercatid'); ?>" name="<?php echo $this->get_field_name('filtercatid'); ?>" type="text" value="<?php echo esc_attr($filtercatid); ?>" />
    <br/>
    <span>To remove specific categories, use comma separated category ID's.</span>
</p>
<p>
    <label for="<?php echo $this->get_field_id('filterpostid'); ?>"><?php _e('<b>Filter Out Post:</b>', 'blogworthy-popular-posts'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('filterpostid'); ?>" name="<?php echo $this->get_field_name('filterpostid'); ?>" type="text" value="<?php echo esc_attr($filterpostid); ?>" />
    <br/>
    <span>To remove specific Posts, use comma separated post ID's.</span>
</p>
<?php 

?>