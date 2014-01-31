<?php
/**
 * Template Engine
 * Creates Html templates to be used as needed
 */
function CreateListItem ( $link, $title, $thumbnail, $excerpt, $views ) {
    if(!$link){return;}
    if(!$title){return;}
    $image = ($display_thumbnail ? '<img src="' . $thumbnail . '" alt="' . $title . '"/>' : '' );
    $content = ($display_excerpt ? '<h4>' . $excerpt . '</h4>' : '' );
    $view_count = ($display_views ? '<span>' . $views . '</span>' : '' );

    $template = '<li class="bpp_list_item bpp_list_today">
                    <a href="' . $link . '">
                        <h3>' . $title . '</h3>
                        ' . $image . '
                        ' . $content . '
                        ' . $view_count . '
                    </a>
                </li>';
    return $template;
}
?>