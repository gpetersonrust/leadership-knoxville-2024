<?php
function readable_date_shortcode($atts) {
    $a = shortcode_atts(array(
        'date' => '20231118',
    ), $atts);

    $timestamp = strtotime($a['date']);
    $readableDate = date("l, F j, Y", $timestamp);

    return $readableDate;
}
add_shortcode('readable_date', 'readable_date_shortcode');
