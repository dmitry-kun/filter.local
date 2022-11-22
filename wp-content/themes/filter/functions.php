<?php
/**
 * @package WordPress
 * @subpackage Theme
 * @since 1.0.0
 */

/* Стили и Скрипты */
function theme_styles_scripts(){
    /* Стили */
    wp_enqueue_style('style.css', get_stylesheet_uri());
    wp_enqueue_style('main.css', get_template_directory_uri() . '/css/main.css');
    wp_enqueue_style('media.css', get_template_directory_uri() . '/css/media.css');
    wp_enqueue_style('swiper.min.css', get_template_directory_uri() . '/plugins/swiper/swiper.min.css');
    wp_enqueue_style('fancybox.min.css', get_template_directory_uri() . '/plugins/fancybox/jquery.fancybox.min.css');
    wp_enqueue_style('scrollbar.css', get_template_directory_uri() . '/plugins/malihu/jquery.mCustomScrollbar.css');
    /* Скрипты */
    wp_enqueue_script('script.js', get_template_directory_uri() . '/js/script.js', array(), '1.0', true);
    wp_enqueue_script('swiper.min.js', get_template_directory_uri() . '/plugins/swiper/swiper.min.js', array(), '1.0', true);
    wp_enqueue_script('fancybox.min.js', get_template_directory_uri() . '/plugins/fancybox/jquery.fancybox.min.js', array(), '1.0', true);
    wp_enqueue_script('scrollbar.min.js', get_template_directory_uri() . '/plugins/malihu/jquery.mCustomScrollbar.concat.min.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'theme_styles_scripts', 1);

/* Логотип */
add_theme_support('custom-logo');

/* Опции темы */
include('js/settings.php');

/* Меню */
register_nav_menus(array(
    'top'    => 'Верхнее меню',
    'bottom' => 'Нижнее меню'
));

/* Циклические ссылки в меню */
function wp_nav_menu_no_current_link($atts, $item) {
    if ($item->current) $atts['href'] = '';
    return $atts;
}
add_action( 'nav_menu_link_attributes', 'wp_nav_menu_no_current_link', 10, 4 );

/* Виджеты */
function widget_register_wp_sidebars() {
    /* Боковая панель */
    register_sidebar(
        array(
            'id' => 'sidebar',
            'name' => 'Боковая панель',
            'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.',
            'before_widget' => '<div id="%1$s" class="side widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        )
    );
    /* Подвал */
    register_sidebar(
        array(
            'id' => 'footer',
            'name' => 'Подвал',
            'description' => 'Перетащите сюда виджеты, чтобы добавить их в подвал.',
            'before_widget' => '<div id="%1$s" class="foot widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        )
    );
}
add_action( 'widgets_init', 'widget_register_wp_sidebars' );

/* Изображение записи */
add_theme_support( 'post-thumbnails' );