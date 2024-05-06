<?php
add_shortcode('events', function(){
    $featured_events = [];
    $regular_events = [];
 

    $args = array(
        'post_type' => 'event',
        'posts_per_page' => 5, // Get the most recent 5 events
        'orderby' => 'meta_value',
        'meta_key' => 'event_date',
        'order' => 'ASC', // Retrieve the nearest future events first
        'meta_query' => array(
            array(
                'key' => 'event_date',
                'value' => date("Y-m-d"),
                'compare' => '>=', // Check if the 'event_date' timestamp is greater than or equal to the current timestamp
                'type' => 'DATE' // Ensure numeric comparison
            )
        )
    );
     $todays_date = date('Ymd');
    $event_query = new WP_Query($args);
    while( $event_query->have_posts()) : $event_query->the_post();
       $event_date = get_field('event_date');
        

        $event = array(
            'title' => get_the_title(),
            'date' => get_field('event_date'),
             'permalink' => get_the_permalink(),
            'post_thumbnail_url' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
            'featured' => get_field('event_is_featured'),
        );
        if($event['featured'] == 1):
            $featured_events[] = $event;
        else:
            $regular_events[] = $event;
        endif;
    endwhile;
    wp_reset_postdata();
       //  get the template
    $template_directory = get_stylesheet_directory();
    $template_file = $template_directory . '/templates/events.php';
    ob_start();
    include($template_file);
    return ob_get_clean();
    
   
});


add_shortcode('single_event_banner', function(){
     
  

    // Retrieve the attribute values
   
    $title = get_the_title();
    $subtitle = get_field('event_date');
    $description= wp_kses_post(get_field('event_description'));
    $button_link = get_field('event_ticket_url');
    $button = get_field('event_ticket_label');
//    $cta which will be from a wysig field
   $cta = get_field('hero_banner_cta');


//    thumbnail_url full size image
    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    
 
 

    $template_directory =   get_stylesheet_directory_uri();

        $template =  CHILD_THEME_DIR . '/components/home_page_banner.php';
  
    // Buffer output
    ob_start();

    // Include the template file
    include $template;

    // Return the buffered output

    $content = ob_get_clean();

    return $content;
});