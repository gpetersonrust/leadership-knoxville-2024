<?php 

function buttons_shortcode($atts) {
    // Define default attributes and merge with user attributes
    $atts = shortcode_atts(
        array(
            'id'      => '',
            'link'    => '',
            'class'   => '',
            'target'  => '',
            'rel'     => '',
            'text'    => 'Button Text',
            "button_type" => "primary"
        ),
        $atts,
        'buttons'
    );

    // Extract attributes
    $id      = $atts['id'];
    $link    = $atts['link'];
    $class   = $atts['class'];
    $target  = $atts['target'] ? 'target="' . esc_attr($atts['target']) . '"' : '';
    $rel     = $atts['rel'] ? 'rel="' . esc_attr($atts['rel']) . '"' : '';
    $button_type = $atts['button_type'];
    $text    = esc_html($atts['text']);

    // Output the  /Users/ginopeterson/Local Beta Sites/leadership-knoxville/app/public/wp-content/themes/leadership-knoxville/components/buttons/primary-button.php
    ob_start();
    include(locate_template('components/buttons/' . $button_type . '-button.php'));
    $output = ob_get_clean();

    return $output;
}

// Register the shortcode
add_shortcode('buttons', 'buttons_shortcode');



add_shortcode('button', function(){
    return "button";
});