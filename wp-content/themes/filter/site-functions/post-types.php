<?php
//Общий шаблон
/*
add_action('init', 'register_post_types');
function register_post_types(){
    $args = array(
        'label'  => null,
        'labels' => array(
            'name'               => '', // основное название для типа записи
            'singular_name'      => '', // название для одной записи этого типа
            'all_items' 	     => '', //названия для всех записей этого вида
            'add_new'            => '', // для добавления новой записи
            'add_new_item'       => '', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => '', // для редактирования типа записи
            'new_item'           => '', // текст новой записи
            'view_item'          => '', // для просмотра записи этого типа.
            'search_items'       => '', // для поиска по этим типам записи
            'not_found'          => '', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => '', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родительских типов. для древовидных типов
            'menu_name'          => '', // название меню
        ),
        'description'         => '',
        'public'              => false,
        'publicly_queryable'  => null,
        'exclude_from_search' => null,
        'show_ui'             => null,
        'show_in_menu'        => null,
        'menu_position'       => null,
        'menu_icon'           => null,
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => false,
        'supports'            => array('title','editor'),
        'taxonomies'          => array(),
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
        'show_in_nav_menus'   => null,
    );

    register_post_type('type_name', $args );
}
*/

function register_site_taxonomy() {
    register_taxonomy('compilations',array('articles'), array(
        'label'                 => 'Подборки', // определяется параметром $labels->name
        'labels'                => [
            'name'              => 'Подборки',
            'singular_name'     => 'Подборка',
            'search_items'      => 'Искать подборки',
            'all_items'         => 'Все подборки',
            'view_item '        => 'Посмотреть подборку',
            'parent_item'       => 'Родительская подборка',
            'edit_item'         => 'Редактировать подборку',
            'update_item'       => 'Обновить подборку',
            'add_new_item'      => 'Добавить новую подборку',
            'new_item_name'     => 'Новая подборка',
            'menu_name'         => 'Подборки',
        ],
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'compilations' ),
    ));

    register_taxonomy('listing',array('cases'), array(
        'label'                 => 'Листинг', // определяется параметром $labels->name
        'labels'                => [
            'name'              => 'Листинг',
            'singular_name'     => 'Листинг',
            'search_items'      => 'Искать Листинг',
            'all_items'         => 'Все Листинг',
            'view_item '        => 'Посмотреть Листинг',
            'parent_item'       => 'Родительская Листинг',
            'edit_item'         => 'Редактировать Листинг',
            'update_item'       => 'Обновить Листинг',
            'add_new_item'      => 'Добавить новую Листинг',
            'new_item_name'     => 'Новая Листинг',
            'menu_name'         => 'Листинг',
        ],
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'listing' ),
    ));
}
add_action( 'init', 'register_site_taxonomy', 0 );

//Статьи
add_action('init', 'register_post_types');
function register_post_types(){
    $articleArgs = array(
        'label'  => __( 'Статьи'),
        'labels' => array(
            'name'               => 'Статьи', // основное название для типа записи
            'singular_name'      => 'Статья', // название для одной записи этого типа
            'all_items' 	     => 'Все статьи', //названия для всех записей этого вида
            'add_new'            => 'Добавить статью', // для добавления новой записи
            'add_new_item'       => 'Добавить новую статью', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Редактировать статью', // для редактирования типа записи
            'new_item'           => 'Новая статья', // текст новой записи
            'view_item'          => 'Посмотреть статью на сайте', // для просмотра записи этого типа.
            'search_items'       => 'Найти статью', // для поиска по этим типам записи
            'not_found'          => 'Статей не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'В корзине нет статей', // если не было найдено в корзине
            'menu_name'          => 'Статьи', // название меню
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 30,
        'menu_icon'           => 'dashicons-text-page',
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => false,
        'supports'            => array('title','editor'),
        'taxonomies'          => array('post_tag'),
        'has_archive'         => true,
    );
    register_post_type('articles', $articleArgs );
    $casesArgs = array(
        'label'  => __( 'Кейсы'),
        'labels' => array(
            'name'               => 'Кейсы', // основное название для типа записи
            'singular_name'      => 'Кейс', // название для одной записи этого типа
            'all_items' 	     => 'Все кейсы', //названия для всех записей этого вида
            'add_new'            => 'Добавить кейс', // для добавления новой записи
            'add_new_item'       => 'Добавить новый кейс', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Редактировать кейс', // для редактирования типа записи
            'new_item'           => 'Новый кейс', // текст новой записи
            'view_item'          => 'Посмотреть кейс на сайте', // для просмотра записи этого типа.
            'search_items'       => 'Найти кейс', // для поиска по этим типам записи
            'not_found'          => 'Кейсов не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'В корзине нет кейсов', // если не было найдено в корзине
            'menu_name'          => 'Кейсы', // название меню
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 31,
        'menu_icon'           => 'dashicons-welcome-write-blog',
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => false,
        'supports'            => array('title','editor'),
        'taxonomies'          => array('post_tag'),
        'has_archive'         => true,
    );
    register_post_type('cases', $casesArgs );
}
