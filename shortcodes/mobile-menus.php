<?php


add_shortcode('mobile-menu', function(){
    ob_start();
    get_template_part('templates/mobile-menu');
    return ob_get_clean();
});