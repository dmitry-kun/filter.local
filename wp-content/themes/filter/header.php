<?php
/**
 * @package WordPress
 * @subpackage Theme
 * @since 1.0.0
 */
global $info;
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php wp_title(); ?></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <?php wp_head(); ?>
    </head>
    <body>
        <div class="header">
            <div class="container">
                <div class="logo">
                    <?php if (is_front_page() || is_home()) : ?>
                        <?php $logo_img = '';
                        if( $custom_logo_id = get_theme_mod('custom_logo')){
                            $logo_img = wp_get_attachment_image($custom_logo_id, 'full', false, array(
                                'class'    => 'custom-logo',
                                'itemprop' => 'logo',
                            ) );
                        }
                        echo $logo_img; ?>
                    <?php else : ?>
                        <a href="<?php echo get_home_url(); ?>">
                            <?php $logo_img = '';
                            if( $custom_logo_id = get_theme_mod('custom_logo')){
                                $logo_img = wp_get_attachment_image($custom_logo_id, 'full', false, array(
                                    'class'    => 'custom-logo',
                                    'itemprop' => 'logo',
                                ) );
                            }
                            echo $logo_img; ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="description">
                    <?php $name = get_bloginfo('name'); ?>
                    <?php $description = get_bloginfo('description'); ?>
                    <?php echo $name ?>
                    <?php echo $description ?>
                </div>
                <div class="header-contacts">
                    <a href="tel:<?php echo $info['phone']; ?>"><?php echo $info['phone']; ?></a>
                    <a href="mailto:<?php echo $info['email']; ?>"><?php echo $info['email']; ?></a>
                    <p><?php echo $info['date']; ?></p>
                    <p><?php echo $info['address']; ?></p>
                </div>
                <div class="menu">
                    <?php wp_nav_menu(array(
                        'theme_location'  => 'top',
                        'container_class' => 'header-menu',
                        'depth'           => 0,
                    )); ?>
                </div>
                <div class="search-block"><?php get_search_form(); ?></div>
            </div>
        </div>