<?php

add_shortcode('email-verification', function(){
//    buffer email-verification-template
    ob_start();
    require_once CHILD_THEME_DIR . "templates/email-verification.php";
    $output = ob_get_clean();
    return $output;
});