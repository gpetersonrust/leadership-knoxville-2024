<?php 

// rest api ini
add_action( 'rest_api_init', 'leadership_knoxville_register_api_hooks' );
function leadership_knoxville_register_api_hooks() {
    // get alumni
    register_rest_route( 'leadership/v1', '/alumni', array(
        'methods' => 'GET',
        'callback' => 'leadership_knoxville_get_alumni',
    ) );

    register_rest_route('email-verification/v1', '/validate', array(
        'methods' => 'post',
        'callback' => 'handle_captcha_validation',
    ));

    register_rest_route('leadership/v1', '/get-current-class-member', array(
        'methods' => 'GET',
        'callback' => 'leadership_knoxville_get_current_class_member',
    ));

    // get pages
    register_rest_route( 'leadership/v1', '/pages', array(
        'methods' => 'GET',
        'callback' => 'leadership_knoxville_get_pages',
    ) );
}

function leadership_knoxville_get_alumni($data) {
   
    $alumni_program = $data['alumni_program'];
    $alumni_conversion = [
        'flagship-program' => 'Flagship Program',
        'leadership-knoxville-scholars' => 'Leadership Knoxville Scholars',
        'youth-leadership-knoxville' => 'Youth Leadership Knoxville',
        'encore' => 'Encore',
        'introduction-knoxville' => 'Introduction Knoxville',

    ]; 
    $alumni_program = $alumni_conversion[$alumni_program];
       
    $args = array(
        'post_type' => 'alumni',
        'posts_per_page' => -1,
        //  order by alumni_year
        'orderby' => 'meta_value',
        'meta_key' => 'alumni_year',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'alumni_program',
                'value' => $alumni_program,
                'compare' => '='
            )
        )

        

    ); 
    $alumnis  = [];
    $alumni_query = new WP_Query($args);
  
    $id = get_the_ID();
    while( $alumni_query->have_posts()) : $alumni_query->the_post();
     $alumni = array(
        'title' => get_the_title(),
        
        'year' =>  get_post_meta(get_the_ID(), 'alumni_year', true),
        'program' => get_post_meta(get_the_ID(), 'alumni_program', true),
        'school' =>  get_post_meta(get_the_ID(), 'alumni_school', true),
        'deceased' => get_post_meta(get_the_ID(), 'alumni_deceased', true),

     );
      array_push($alumnis, $alumni);
    

    endwhile;
    wp_reset_postdata();
     
    
    
    // return data , message and status code
    return array(
        'data' =>  [
            'alumnis' => $alumnis,
           
        ],
        
        'message' => 'success',
        'status' => 200
    );
}


function handle_captcha_validation($data) {
 
    $g_captcha_response = sanitize_text_field($data['g-recaptcha-response']);
    $email_id = sanitize_text_field($data['email_id']);
    // get X-Wp-Nonce from headers
    $nonce = $_SERVER['HTTP_X_WP_NONCE'];
    // Verify the wp-rest nonce from headers
    if (!wp_verify_nonce($nonce, 'wp_rest')) {
        return [
            'success' => false,
            'message' => 'Invalid Nonce',
            'status_code' => '403'
        ];
    }

    
    

    $secret_key = 'removed for security reasons'; // Replace with your actual secret key
    $verified_email;
      if(get_field('email', $email_id)){
        $verified_email = get_field('email', $email_id);
      } else if(get_field('bio_email', $email_id)){
        $verified_email = get_field('bio_email', $email_id);
      } else {
        $verified_email = null;
      }


    if (!$verified_email) {
        return [
            'success' => false,
            'message' => 'Email not found',
            'status_code' => '404'
        ];
    }

    // Google reCAPTCHA verification endpoint
    $verification_url = 'https://www.google.com/recaptcha/api/siteverify';

    // Prepare data for the POST request
    $post_data = array(
        'secret' => $secret_key,
        'response' => $g_captcha_response,
        // You can include additional parameters if needed
    );

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($post_data),
        ),
    );

    

    // Create context for the HTTP request
    $context = stream_context_create($options);

    // Make the request to the reCAPTCHA verification endpoint
    $response = file_get_contents($verification_url, false, $context);

    if ($response === FALSE) {
        // Error handling for failed request
        return 'Error while verifying reCAPTCHA';
    }

    // Decode the JSON response
    $json_response = json_decode($response, true);

    if ($json_response['success']) {
        $email = sanitize_email($data['email']); // Assuming the email is submitted in the form data
        $ip_address = $_SERVER['REMOTE_ADDR'];

        // Add email to the list of requests
        $requested_emails = get_option('requested_emails', array());
        $requested_emails[] = array('email' => $email, 'ip' => $ip_address, 'timestamp' => time());

        // Check if IP address is already in the list and set a limit
        $ip_requests = array_filter($requested_emails, function ($request) use ($ip_address) {
            return $request['ip'] === $ip_address && (time() - $request['timestamp']) < 3600; // Limit to requests within the last hour
        });

        if (count($ip_requests) > 10) {
            // Limit exceeded, handle accordingly
            return [
                'success' => false,
                'message' => 'Too many requests from this IP address',
                'status_code' => '429'
            ];
        }

        // Save the updated list of requested emails
        update_option('requested_emails', $requested_emails);
        return  [
            'success' => true,
            'message' => 'Email verification successful',
            'email' => $verified_email,
            'status_code' => '200'
        ] ;
    } else {
        // reCAPTCHA verification failed
        return  [
            'success' => false,
            'message' => 'reCAPTCHA verification failed',
            'status_code' => '403'
        ];
    }
}


function leadership_knoxville_get_current_class_member() {
    $query = new WP_Query(array(
        'post_type' => 'current-class-member',
        'posts_per_page' => -1,
    ));

    $current_class_members = [];

    while ($query->have_posts()) : $query->the_post();
        $current_class_member = [
            'title' => get_the_title(),
            'id' => get_the_ID(),
            'permalink' => get_the_permalink(),
        ];
        array_push($current_class_members, $current_class_member);
    endwhile;

    wp_reset_postdata();

    // Create a JSON file download
    $json_data = json_encode($current_class_members, JSON_PRETTY_PRINT);

    // Set the path where you want to save the JSON file
    $json_file_path = ABSPATH . 'wp-content/uploads/current_class_members.json';

    // Write the JSON data to the file
    file_put_contents($json_file_path, $json_data);

    // Optionally, you can force a download of the file
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename=current_class_members.json');
    readfile($json_file_path);

    // Optionally, you can delete the file after download if needed
    // unlink($json_file_path);

    // Exit to prevent further output
    exit;
}


function leadership_knoxville_get_pages() {
    $pages = get_posts(array(
        'post_type' =>  ['page', 'program'],
        'posts_per_page' => -1,
    ));

    // map pages and get_permalink and title
    $pages = array_map(function ($page) {
        return [
            'title' => $page->post_title,
            'permalink' => get_permalink($page->ID),
        ];
    }, $pages);

    // return data , message and status code
    return array(
        'data' =>  [
            'pages' => $pages,
        ],
        'message' => 'success',
        'status' => 200
    );


}