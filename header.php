<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400;500;800&display=swap" rel="stylesheet">
    <title>Document</title>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <!-- Header starts -->
    <div class="header">
        <div class="header-top">
            <div class="logo">
                <?php
                    if( function_exists( 'the_custom_logo' ) ){
                        the_custom_logo();
                    }
                 ?>
            </div>
            <nav>
                <a href="#" class="toggle-bt hide-for-desktop">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
                <?php
                $menu_class = new Menus();
                $header_menu_id = $menu_class->get_menu_id( 'nakhtar_yoga_top_menu' );
                $header_menus = wp_get_nav_menu_items( $header_menu_id );
                if( !empty( $header_menus) && is_array( $header_menus ) ):
                ?>
                <ul id="mb-show">
                    <?php
                    foreach( $header_menus as $menu_item ) :
                        if( $menu_item ) :
                     ?>
                    <li>
                        <a href="<?php echo esc_url( $menu_item->url ); ?>">
                            <?php echo esc_html( $menu_item->title ); ?>            
                        </a>
                    </li>
                    <?php endif; endforeach; ?>
                </ul>
                <?php endif; ?>                
            </nav>
        </div>