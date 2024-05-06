<?php 


add_shortcode('sponsors', function(){
    $sponsors_query = new WP_Query(array(
        'post_type' => 'sponsor',
        'posts_per_page' => -1,
        // order alphabetically by  sponsor_cat
        'orderby' => 'meta_value',
        'meta_key' => 'sponsor_cat',
        'order' => 'ASC',
        
    ));

   $sponsors = [];

    while( $sponsors_query->have_posts()) : $sponsors_query->the_post();
    
    $sponsor_cat = get_field( 'sponsor_cat');
    $sponsor_type = get_field( 'sponsor_type');
    // check if $sponsor[$sponsor_cat] exists
    if(!isset($sponsors[$sponsor_cat])) {
        $sponsors[$sponsor_cat] = [];
    }
    // check if $sponsor[$sponsor_cat][$sponsor_type] exists
    if(!isset($sponsors[$sponsor_cat][$sponsor_type])) {
        $sponsors[$sponsor_cat][$sponsor_type] = [];
    }
    $sponsor = array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'post_thumbnail_url' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
    );
    $sponsors[$sponsor_cat][$sponsor_type][] = $sponsor;
    endwhile;
    wp_reset_postdata();

   

    // get the template
    $template_directory = get_stylesheet_directory();
    $template_file = $template_directory . '/templates/sponsors.php';
    ob_start();
    include($template_file);
    return ob_get_clean();

});



add_shortcode('sponsor_logo', function(){
    // get current id
    $id = get_the_ID();
    $sponsor_logo = get_field('sponsor_logo', $id);
 
   
    return $sponsor_logo;
});