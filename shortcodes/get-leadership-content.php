<?php 

add_shortcode('get-leadership-content', function($atts){
    $args = shortcode_atts(array(
        'id' => 0,
    ), $atts);
    $content = get_post_field('post_content', $args['id']);
    
    return $content;
});