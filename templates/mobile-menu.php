<?php
// Get all registered menus
$menus = get_registered_nav_menus();

 
// Get all registered menus
$menus = get_registered_nav_menus(); ?> 
<div class="site-mobile-menu">
    <div id="hamburger-menu" class="hamburger-menu closed">
        <div class="mobile-closed">
            <div class="hamburger-menu__line"></div>
            <div class="hamburger-menu__line"></div>
            <div class="hamburger-menu__line"></div>
        </div>
       
        <div class="mobile-opened">
            X
        </div>
    </div>
    <?php
// Check if "primary" menu is registered
if (isset($menus['primary'])) {
    // Display the "Primary Menu" with its children
  wp_nav_menu(array(
        'theme_location' => 'primary', // Use the menu location name
        'menu_class'     => 'mobile-menu', // CSS class for the menu
        // id
        'menu_id'        => 'mobile-menu',
        // Add more parameters as needed

        // ul class
        'container_class' => 'mobile-menu-container',
        // mobile container a nav element 
        'container' => 'nav',

    ));
} else {
    echo "Primary menu is not registered.";
}
?>

</div>
 