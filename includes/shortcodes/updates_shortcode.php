<?php 



add_shortcode('updates', function(){
    $updates  = []; 

    $query = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        // order by meta_value update_cat
        'orderby' => 'meta_value',
        'meta_key' => 'update_cat',
        'order' => 'ASC',
    ));

    while($query->have_posts()) : $query->the_post();
    $id = get_the_ID();
    $update_cat = get_field('update_cat');
    $update_date = get_field('update_date');
    $title = get_the_title();
    $permalink = get_the_permalink();
    $date =  get_the_date();
    $thumbnail_url = get_the_post_thumbnail_url($id, 'full');
    // format date to Month and year
    $date = date('F Y', strtotime($date));
    // use update_cat as key for $updates array
    if(!isset($updates[$update_cat])) {
        $updates[$update_cat] = [];
    }
     $updates[$update_cat][] = array(
        'update_cat' => $update_cat,
        'update_date' => $update_date,
        'title' => $title,
        'permalink' => $permalink,
        'date' => $date,
        'ID' => $id,
        'thumbnail_url' => $thumbnail_url,

    );
    endwhile;
    wp_reset_postdata();
    
    // get the template
    $template_directory = get_stylesheet_directory();
    $template_file = $template_directory . '/templates/updates.php';
    ob_start();
    include($template_file);
    return ob_get_clean();

});