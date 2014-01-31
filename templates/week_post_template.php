<?php
for ($y=1; $y<$countweekid; $y++) {
    $BlogWorthy_weeklysingleid = $BlogWorthy_weekids[$y];

    $titleStr =         get_the_title($BlogWorthy_weeklysingleid);
    $post =             get_post($BlogWorthy_weeklysingleid);
    $dateStr =          mysql2date('Y-m-d', $post->post_date);
    $contentStr =       strip_tags(mb_substr($post->post_content, 0, 60));
    $category_detail =  get_the_category($BlogWorthy_weeklysingleid);//$post->ID
    $image =            wp_get_attachment_image_src( get_post_thumbnail_id($BlogWorthy_weeklysingleid), 'single-post-thumbnail' );

    foreach($category_detail as $cd){
        echo $cd->cat_ID;
    }

    if($display_excerpt == "yes" && $home_page == "yes" && $thumbnail == "yes"){
        if($BlogWorthy_weeklysingleid == 0){
        } else {
            if (in_array($cd->cat_ID, $all_catid)){
            } else {   
                if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
                } else {
                    echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px" /></div><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_weeklypageviews[$BlogWorthy_weeklysingleid].' )</span></div></div></li></ul>';
                }
            }
        }
    }

    elseif($display_excerpt == "yes" && $home_page == "yes" && $thumbnail ==""){
        if($BlogWorthy_weeklysingleid == 0) {
        } else {
            if (in_array($cd->cat_ID, $all_catid)){
            } else {   
                if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
                } else {
                    echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_weeklypageviews[$BlogWorthy_weeklysingleid].' )</span></div></div></li></ul>';
                }
            }
        }
    }

    elseif($display_excerpt == "yes" && $home_page == "" && $thumbnail ==""){
        if (in_array($cd->cat_ID, $all_catid)){
        } else {   
            if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
            } else {
                echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_weeklypageviews[$BlogWorthy_weeklysingleid].' )</span></div></div></li></ul>';  
            }
        }
    }

    elseif($display_excerpt == "yes" && $home_page == "" && $thumbnail =="yes"){
        if (in_array($cd->cat_ID, $all_catid)){
        } else {
            if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
            } else {
                echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px" /></div><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_weeklypageviews[$BlogWorthy_weeklysingleid].' )</span></div></div></li></ul>';  
            }
        }
    }

    elseif($display_excerpt == "no" && $home_page == "" && $thumbnail ==""){
        if (in_array($cd->cat_ID, $all_catid)){
        } else {   
            if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
            } else {
                echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a></div></li></ul>';    
            }
        }
    }

    elseif($display_excerpt == "no" && $home_page == "" && $thumbnail =="yes"){
        if (in_array($cd->cat_ID, $all_catid)){
        } else {   
            if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
            } else {
                echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px" /></div></div></li></ul>';   
            }
        }
    }

    elseif($display_excerpt == "no" && $home_page == "yes" && $thumbnail =="yes"){
        if($BlogWorthy_weeklysingleid == 0){
        } else {
            if (in_array($cd->cat_ID, $all_catid)){
            } else {
                if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
                } else {
                    echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px" /></div></div></li></ul>';
                }
            }
        }
    }

    elseif($display_excerpt == "no" && $home_page == "yes" && $thumbnail ==""){
        if($BlogWorthy_weeklysingleid == 0){
        } else {
            if (in_array($cd->cat_ID, $all_catid)){
            } else {
                if (in_array($BlogWorthy_weeklysingleid, $all_postid)){
                } else {
                    echo $week_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_weeklypagepath[$BlogWorthy_weeklysingleid].'>'.$titleStr.'</a></div></li></ul>';
                }
            }
        }
    } else {
        echo $week_post_output= 'Something wrong!! Please try again...';
    }

}
?>