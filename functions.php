<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

define('CHILD_THEME_DIR', get_stylesheet_directory() . '/'); 

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'x-stack' ) );
        $app_css = trailingslashit( get_stylesheet_directory_uri() ) . 'dist/app/app' . theme_dynamic_hash() . '.css';
        $theme_name = wp_get_theme()->get( 'Name' );
        wp_enqueue_style( $theme_name . '-app', $app_css, array( ), null );
        $app_js = trailingslashit( get_stylesheet_directory_uri() ) . 'dist/app/app' . theme_dynamic_hash() . '.js';
        wp_enqueue_script( $theme_name . '-app', $app_js, array( 'jquery' ), null, true );
      
        $request_uri = $_SERVER['REQUEST_URI'];

          if($request_uri == '/events/')   wp_enqueue_style( 'events', trailingslashit( get_stylesheet_directory_uri() ) . 'dist/events/events' . theme_dynamic_hash() . '.css', array( ), null );
          if($request_uri == '/updates/') {
            wp_enqueue_style( 'updates', trailingslashit( get_stylesheet_directory_uri() ) . 'dist/updates/updates' . theme_dynamic_hash() . '.css', array( ), null );
            wp_enqueue_script( 'updates', trailingslashit( get_stylesheet_directory_uri() ) . 'dist/updates/updates' . theme_dynamic_hash() . '.js',  [], null, true );
          }
         

            if($request_uri == '/alumni/') : 
                wp_enqueue_style( 'alumni', trailingslashit( get_stylesheet_directory_uri() ) . 'dist/alumni/alumni' . theme_dynamic_hash() . '.css', array( ), null );
                wp_enqueue_script( 'alumni', trailingslashit( get_stylesheet_directory_uri() ) . 'dist/alumni/alumni' . theme_dynamic_hash() . '.js',  [], null, true );
                // localize script site_url
                wp_localize_script( 'alumni', 'site_url', site_url() );
            endif;

            // if request-uri contains email-verification
            if(strpos($request_uri, 'email-verification') !== false) : 
                wp_enqueue_style( 'email-verification', trailingslashit( get_stylesheet_directory_uri() ) . 'dist/verification-form/verification-form' . theme_dynamic_hash() . '.css', array( ), null );
                wp_enqueue_script( 'email-verification', trailingslashit( get_stylesheet_directory_uri() ) . 'dist/verification-form/verification-form' . theme_dynamic_hash() . '.js',  [], null, true );

                // localizse script with wp-rest-nonce
                wp_localize_script( 'email-verification', 'wp_rest_nonce', wp_create_nonce( 'wp_rest' ) );
            endif;

    }

endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION


function initializeCornerstoneColors() {
    // // Check if not empty, don't overwrite
    // if (!empty(get_option('cornerstone_color_items', null))) {
    //     return;
    // }
  
    // // Your initial colors
    $initialColors = [
        [
            "title" => __("Gold"),
            "value" => "#ECAB1F",
            "_id" => "gold",
        ],
        [
            "title" => __("Purple"),
            "value" => "#74308C",
            "_id" => "purple",
        ],
        [
            "title" => __("Green"),
            "value" => "#2C8B4B",
            "_id" => "green",
        ],
        [
            "title" => __("Orange"),
            "value" => "#D34729",
            "_id" => "orange",
        ],
        [
            "title" => __("Maroon"),
            "value" => "#AA1F2D",
            "_id" => "maroon",
        ],
        [
            "title" => __("White"),
            "value" => "#FFFFFF",
            "_id" => "white",
        ],
        [
            "title" => __("Cyan"),
            "value" => "#36b6e6",
            "_id" => "cyan",
        ],
        [
            "title" => __("Blue"),
            "value" => "#1c6591",
            "_id" => "blue",
        ],
        [
            "title" => __("Teal"),
            "value" => "#1c6591",
            "_id" => "teal",
        ],
        [
            "title" => __("Slate"),
            "value" => "#064975",
            "_id" => "slate",
        ],
        // #707070
        [
            "title" => __("Gray"),
            "value" => "#707070",
            "_id" => "gray",
        ],
        [
            "title" => __("Black"),
            "value" => "#000000",
            "_id" => "black",
        ],
    ];
  
    // Encode
    $stored = wp_slash(json_encode($initialColors));
  
    // Update
    update_option('cornerstone_color_items', $stored);
  }
  
  // Call the function to initialize the colors
  initializeCornerstoneColors();
  

  /**
   * Get the dynamic hash generated for assets.
   *
   * This function retrieves the dynamic hash generated for assets by following these steps:
   * 1. Read the 'dist/app' directory and get the first file.
   * 2. Extract the hash from the file name by splitting it with '-wp'.
   * 3. Further extract the hash by splitting it with '.' to remove the file extension.
   * 4. Combine the hash with the '-wp' prefix and return the final dynamic hash.
   *
   * @since    1.0.0
   *
   * @return   string   The dynamic hash for assets.
   */
  function theme_dynamic_hash() {
    // Get the path to the 'dist/app' directory.
    // $directory_path =  get . 'dist/app/';
    $directory_path =  get_stylesheet_directory() . '/dist/app/';
  
    // Get the files in the 'dist/app' directory.
    $files = scandir( $directory_path );
  
    // Find the first file in the directory.
    $first_file = '';
    foreach ( $files as $file ) {
        if ( ! is_dir( $directory_path . $file ) ) {
            $first_file = $file;
            break;
        }
    }
  
    // Extract the hash from the file name.
    $hash_parts = explode( '-wp', $first_file );
    $hash = isset( $hash_parts[1] ) ? $hash_parts[1] : '';
  
    // Further extract the hash by splitting it with '.' to remove the file extension.
    $hash_parts = explode( '.', $hash );
    $hash = isset( $hash_parts[0] ) ? $hash_parts[0] : '';
  
    // Combine the hash with the '-wp' prefix and return the final dynamic hash.
    $dynamic_hash = '-wp' . $hash;
  
    return $dynamic_hash;
  }




 

  add_shortcode('credentials_degreees', function($atts){
    // Attributes
    $atts = shortcode_atts(
        array(
            'type' => 'degree',
            
        ), $atts, 'credentials_degreees' );

    $type = $atts['type'];
   $first_letter_uppercase = ucfirst($type);

     return get_field("bio_{$type}") ? get_field("bio_{$type}") : "{$first_letter_uppercase} coming soon!";
    

});


add_shortcode('fun-facts', function($atts){
     
    return  get_field('bio_fun_facts');


});
 

add_shortcode('logo', 'logo_shortcode');

function logo_shortcode($atts) {
    // Attributes
    $atts = shortcode_atts(
        array(
            'attribute' => 'default_value', // Set a default value if needed
        ), $atts, 'logo' );

    $attribute_value = get_field('logo', $atts['attribute']);

    // You can perform any processing or output you want here
    return  "<img src='{$attribute_value}' alt='logo' />";
}


function alumni_html_shortcode(){
//   alumni query
    $args = array(
        'post_type' => 'alumni',
        'posts_per_page' => -1,
        //  order by alumni_year
        'orderby' => 'meta_value',
        'meta_key' => 'alumni_year',
        'order' => 'ASC',
        // meta_query  alumni_program = Flagship Program
        'meta_query' => array(
            array(
                'key' => 'alumni_program',
                'value' => 'Flagship Program',
                'compare' => '=',
            ),
        ),
        
       


    ); 
    $alumnis  = [];
    $alumni_query = new WP_Query($args);
    $starting_posts = [];

    while( $alumni_query->have_posts()) : $alumni_query->the_post();
     $alumni = array(
        'title' => get_the_title(),
        
        'year' => get_field('alumni_year'),
        'program' => get_field('alumni_program'),
        'school' => get_field('alumni_school'),
        'deceased' => get_field('alumni_deceased'),

     );
      array_push($alumnis, $alumni);
     if($alumni['program'] == 'Flagship Program'): 
        $starting_posts[] = $alumni;
        endif;

    endwhile;
    wp_reset_postdata();
     
    $starting_posts = groupArrayByYear($starting_posts);
       
     $template_directory = get_stylesheet_directory();
     $template_file = $template_directory . '/templates/alumnis.php';
    ob_start();
    include($template_file);
    return ob_get_clean();
}



add_shortcode('alumni_html', 'alumni_html_shortcode');


function groupArrayByYear($data) {
    $result = array();

    foreach ($data as $item) {
        $year = $item['year'];

        if (!isset($result[$year])) {
            $result[$year] = array();
        }

        $result[$year][] = $item;
    }

    return $result;
}

require get_stylesheet_directory() . '/includes/shortcodes/shortcodes.php';



// rewrite rules for events

function custom_rewrite_rules() {
    add_rewrite_rule(
        '^photo-gallery/(\d+)/?$',
        'index.php?pagename=photo-gallery&event_id=$matches[1]',
        'top'
    );
}
add_action('init', 'custom_rewrite_rules');

function custom_query_vars($query_vars) {
    $query_vars[] = 'event_id';
    return $query_vars;
}
add_filter('query_vars', 'custom_query_vars');

 

// define site_url
define('SITE_URL', get_site_url());


function add_ga4_tracking_code() {
    ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-N6SXQWHW6E"></script>
<script>
window.dataLayer = window.dataLayer || [];

function gtag() {
    window.dataLayer.push(arguments);
}
gtag('js', new Date());
gtag('config', 'G-N6SXQWHW6E');
</script>

<!-- Add your custom GA4 event tracking code here -->
<script>
gtag('event', 'conversion', {
    'send_to': 'G-N6SXQWHW6E',
    'event_name': 'pet_adoption_completed',
    'value': 1.0 // optional, assign a value to the conversion
});
</script>
<?php
}

// Use a high priority value (e.g., 1) to add the code as early as possible
add_action('wp_head', 'add_ga4_tracking_code', 1);


function add_gtm_noscript() {
    ?>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M26WRBMN" height="0" width="0"
        style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
}

add_action('wp_footer', 'add_gtm_noscript');



function get_post_content_shortcode($atts) {
    // Set default values for attributes
    $atts = shortcode_atts(
        array(
            'id' => 0, // Default post ID if not provided
        ),
        $atts,
        'get-post-content'
    );

    // Get the ID of the post from the $atts
    $post_id = $atts['id'];

    // Get the post content 
    $post = get_post($post_id);
    $post_content = $post->post_content;

    // Process shortcodes in the post content, including iframes
    $post_content = do_shortcode($post_content);

    // Return the post content
    return $post_content;
}


add_shortcode('get-post-content', 'get_post_content_shortcode');


add_shortcode('get-post-title', function(){
    return get_the_title();
 
});



add_shortcode('leadership-knoxville-faqs', function(){ 
    $faqs = get_field('faq');

// get  templates/faq-accordion.php 
    $template_directory = get_stylesheet_directory();
    $template_file = $template_directory . '/templates/faq-accordion.php';
    ob_start();
    include($template_file);
    return ob_get_clean();
}); 

add_shortcode('dynamic-degree-title', function(){
   $degrees =  get_field('bio_degrees');
//    split by new line
    $degree_title = explode("\n", $degrees);
//    loop thru and remove empty lines  from array
    foreach($degree_title as $key => $value) {
        //  trim value 
        $value = trim($value);
        //  if value is empty remove from array
        if(empty($value) || $value == '') {
            unset($degree_title[$key]);
        }
    }
    //  remove  last item from array
    array_pop($degree_title);
    return count($degree_title) > 1 ?  "Degrees" : "Degree";
  
    
});

require_once CHILD_THEME_DIR . "shortcodes/shortcodes.php";
require CHILD_THEME_DIR . "api/api.php";


 

function delete_posts_by_meta($post_type, $meta_key, $meta_value) {
    // Create a WP_Query with meta_query
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => $meta_key,
                'value' => $meta_value,
                'compare' => '=',
            ),
        ),
    );

    $query = new WP_Query($args);

    // Check if there are posts
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();

            // Delete the post
            wp_delete_post($post_id, true);
        }

        // Reset post data
        wp_reset_postdata();
    }
}

// delete alumni meta_key alumni_program value Flagship Program

// delete_posts_by_meta('alumni', 'alumni_program', 'Flagship Program');

 