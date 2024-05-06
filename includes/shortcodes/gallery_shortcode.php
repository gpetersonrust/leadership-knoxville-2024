<?php


add_shortcode(('event-gallery'), function(){
    $event_id = eventID();
    // event_gallery
    $images = get_field('event_gallery', $event_id);
 
    // get the template parts
    $template_directory = get_stylesheet_directory();
    $template_file = $template_directory . '/templates/gallery.php';

    // if event_id = 0 redirect to 404  

    // if($event_id == 0) {
    //     wp_redirect( home_url() . '/404', 404 );
    //     exit;
    // }

    ob_start();
    include($template_file);

    return ob_get_clean();

});


add_shortcode('gallery-title', function(){
    $event_id = eventID();
    $title = get_the_title($event_id);
    return $title;
    

});

function eventID(){
    $request_uri = $_SERVER['REQUEST_URI'];
    // /photo-gallery/1837/
    // remove /photo-gallery/ and trailing slash
    $event_id = str_replace('/photo-gallery/', '', $request_uri);
    $event_id = str_replace('/', '', $event_id);
    $event_id = intval($event_id);
    $event_id = $event_id ? $event_id : 0;
    return $event_id;
}