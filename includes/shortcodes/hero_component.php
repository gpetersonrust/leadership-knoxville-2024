<?php 

// Add the shortcode function to your theme's functions.php file or a custom plugin

function hero_banner_shortcode($atts) {

  
    // Extract and sanitize the attributes
    $atts = shortcode_atts(
        array(
            'hero_banner_image' => '', // Default image URL
            'title' => '',            // Default title
            'content' => '',          // Default content
            'button' => '',           // Default button text
        ),
        $atts
    );

    // Retrieve the attribute values
    $thumbnail_url = get_field('hero_thumbnail') ;
    $title = get_field('hero_banner_title');
    $subtitle = get_field('hero_banner_subtitle');
    $description= wp_kses_post(get_field('hero_banner_description'));
    $button_link = get_field('hero_banner_button_link');
    $button = get_field('hero_banner_button');
//    $cta which will be from a wysig field
   $cta = get_field('hero_banner_cta');

 
 

    $template_directory =   get_stylesheet_directory_uri();

        $template =  CHILD_THEME_DIR . '/components/home_page_banner.php';
  
    // Buffer output
    ob_start();

    // Include the template file
    include $template;

    // Return the buffered output

    $content = ob_get_clean();

    return $content;
}

// Register the shortcode
add_shortcode('hero_banner', 'hero_banner_shortcode');
