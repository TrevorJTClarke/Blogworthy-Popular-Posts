<?php
// TODO:
// create a funtion that returns the created list item content
$monthArray = array();
for ($z=1; $z<$countallid; $z++) {
    $BlogWorthy_allsingleid = $BlogWorthy_allids[$z];

    $titleStr =         get_the_title($BlogWorthy_allsingleid);
    $post =             get_post($BlogWorthy_allsingleid);
    $dateStr =          mysql2date('Y-m-d', $post->post_date);
    $contentStr =       strip_tags(mb_substr($post->post_content, 0, 60));
    $category_detail =  get_the_category($BlogWorthy_allsingleid);//$post->ID
    $image =            wp_get_attachment_image_src( get_post_thumbnail_id($BlogWorthy_allsingleid), 'single-post-thumbnail' );


// LOGIC:
// if exclude homepage, skip
// if in filtered cat id, skip
// if in filtered post id, skip
    if($home_page != "yes"){
        if($BlogWorthy_allsingleid == 0) {
        } else {
            if (in_array($cd->cat_ID, $all_catid)){
            } else {
                if (in_array($BlogWorthy_allsingleid, $all_postid)) {
                } else {
                    $tempMonthItem = CreateListItem( $BlogWorthy_allsingleid[$BlogWorthy_allsingleid], $titleStr, $image[0], $contentStr, $BlogWorthy_allpageviews[$BlogWorthy_allsingleid] );
                    array_push($monthArray, $tempMonthItem);
                    // echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px"  /></div><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_allpageviews[$BlogWorthy_allsingleid].' )</span></div></div></li></ul>';
                }
            }
        }
    }
}







// DEPRECATE PLEASE!!!!!!!!!!!!!!!!!!!!!
// -----------------------------
//     foreach($category_detail as $cd){
//         echo $cd->cat_ID;
//     }

//     if($display_excerpt == "yes" && $home_page == "yes" && $thumbnail == "yes"){
//         if($BlogWorthy_allsingleid == 0){
//         } else {
//             if (in_array($cd->cat_ID, $all_catid))  {
//             } else {
//                 if (in_array($BlogWorthy_allsingleid, $all_postid)){
//                 } else {
//                     echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px"  /></div><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_allpageviews[$BlogWorthy_allsingleid].' )</span></div></div></li></ul>';
//                 }
//             }
//         }
//     }

//     elseif($display_excerpt == "yes" && $home_page == "yes" && $thumbnail == ""){
//         if($BlogWorthy_allsingleid == 0){ 
//         } else {
//             if (in_array($cd->cat_ID, $all_catid))  {
//             } else {
//                 if (in_array($BlogWorthy_allsingleid, $all_postid)){
//                 } else {
//                     echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_allpageviews[$BlogWorthy_allsingleid].' )</span></div></div></li></ul>';
//                 }
//             }
//         }
//     }

//     elseif($display_excerpt == "yes" && $home_page == "" && $thumbnail == ""){
//         if (in_array($cd->cat_ID, $all_catid)) {
//         } else {
//             if (in_array($BlogWorthy_allsingleid, $all_postid)){
//             } else {
//                 echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_allpageviews[$BlogWorthy_allsingleid].' )</span></div></div></li></ul>';
//             }
//         }
//     }

//     elseif($display_excerpt == "yes" && $home_page == "" && $thumbnail == "yes"){
//         if (in_array($cd->cat_ID, $all_catid))  {
//         } else {
//             if (in_array($BlogWorthy_allsingleid, $all_postid)){
//             } else {
//                 echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px"  /></div><div class="BlogWorthy_most_viewed_post_contents">'.$contentStr.' ...<br/><span style="color:#ccc; font-family: arial; font-size: 10px;">( Views : '.$BlogWorthy_allpageviews[$BlogWorthy_allsingleid].' )</span></div></div></li></ul>';
//             }
//         }
//     }

//     elseif($display_excerpt == "no" && $home_page == "" && $thumbnail == ""){
//         if (in_array($cd->cat_ID, $all_catid))  {
//         } else {
//             if (in_array($BlogWorthy_allsingleid, $all_postid)){
//             } else {
//                 echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a></div></li></ul>';   
//             }
//         }
//     }

//     elseif($display_excerpt == "no" && $home_page == "" && $thumbnail == "yes"){
//         if (in_array($cd->cat_ID, $all_catid))  {
//         } else {
//             if (in_array($BlogWorthy_allsingleid, $all_postid)){
//             } else {
//                 echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a><br /><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px"  /></div></div></li></ul>'; 
//             }
//         }
//     }

//     elseif($display_excerpt == "no" && $home_page == "yes" && $thumbnail == "yes"){
//         if($BlogWorthy_allsingleid == 0){
//         } else {
//             if (in_array($cd->cat_ID, $all_catid))  {
//             } else {
//                 if (in_array($BlogWorthy_allsingleid, $all_postid)){
//                 } else {
//                     echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a><div class="BlogWorthy_thumb_image"><img src='.$image[0].'  height="50px" width="54px"  /></div></div></li></ul>';
//                 }
//             }
//         }
//     }

//     elseif($display_excerpt == "no" && $home_page == "yes" && $thumbnail == ""){
//         if($BlogWorthy_allsingleid == 0){
//         } else {
//             if (in_array($cd->cat_ID, $all_catid))  {
//             } else {
//                 if (in_array($BlogWorthy_allsingleid, $all_postid)){
//                 } else {
//                     echo $all_post_output= '<ul><li><div class="BlogWorthy_most_viewed_post"><a href='.$BlogWorthy_allpagepath[$BlogWorthy_allsingleid].'>'.$titleStr.'</a></div></li></ul>';
//                 }
//             }
//         }
//     } else {
//         echo $all_post_output= 'Something wrong!! Please try again...';
//     }

// }
?>