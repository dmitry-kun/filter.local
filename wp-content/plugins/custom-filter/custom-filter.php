<?php

/*
Plugin Name: ACF Filter
Description: Фильтр по полям ACF
Version: 0.1
Author: dima.k
*/
//https://wp-admin.com.ua/hranenie-dannyih-v-vordpress/ - про хранение настроек в бд
// планирую сохранять настройки а ля json (или в сериализованном виде)
// {post_type: {field_name : { type : 'select/range/checkbox/radio', show: Y/N }, {type...} }, {field{...}...}} -  может быть дополнить
//при выводе нужно выводить поля как сейчас. данные будут отправляться формой. данные о типе, выводе и пр. получать из настроек по post_type и field
// выводимый тип поля зависит от типа поля в acf, например range может быть только у number
add_action('admin_menu', 'addMenu');
function addMenu()
{
    add_menu_page('Filter options', 'Filter options', 4, 'acf-filter-settings', 'filterSettingsPage');
}
function filterSettingsPage()
{
    $args = array(
        'public'   => true,
        '_builtin' => false,
    );

    $output = 'objects'; // names or objects, note names is the default
    $operator = 'and'; // 'and' or 'or'

    $post_types = get_post_types( $args, $output, $operator );

    foreach ( $post_types  as $post_type ) {
        echo '<p>' . $post_type->label . '</p>';
        $groups = acf_get_field_groups(array('post_type' => $post_type->name));
        foreach ($groups as $group_key) {
            $fields = acf_get_fields($group_key['key']);
            foreach ($fields as $field) {
                ?>
                <div>
                    field: <b><?=$field['label']?></b>
                    code: <b><?=$field['name']?></b>
                    type: <b><?=$field['type']?></b>
                </div>
                <?
            }
        }
    }
}