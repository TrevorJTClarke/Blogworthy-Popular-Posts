<?php
// return the created list content items
function FormatTodayData( $gaMonthData ){

    $monthArray = array();

    foreach ($gaMonthData as $result) {
        $getPageviews  = $result->getPageviews();
        $getHostname = $result->getHostname();
        $getPagepath = $result->getPagepath();
        $postPagepath = 'http://'.$getHostname.$getPagepath;
        $postID = url_to_postid($postPagepath);

        $titleStr =         get_the_title($postID);
        $contentStr =       strip_tags(mb_substr($post->post_content, 0, 60));
        $categoryID =       get_the_category($postID);
        $image =            wp_get_attachment_image_src( get_post_thumbnail_id($postID), 'single-post-thumbnail' );
        
        // LOGIC:
        // if exclude homepage, skip
        // if in filtered cat id, skip
        // if in filtered post id, skip
        if($home_page != "yes"){
            if($postID == 0) {
            } else {
                if (in_array($categoryID, $all_catid)){
                } else {
                    if (in_array($postID, $all_postid)) {
                    } else {
                        $tempMonthItem = CreateListItem( $postPagepath, $titleStr, $image[0], $contentStr, $getPageviews );
                        array_push($monthArray, $tempMonthItem);
                    }
                }
            }
        }
    }

    return $monthArray;
}
?>