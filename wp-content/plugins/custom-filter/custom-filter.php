<?php

/*
Plugin Name: ACF Filter
Description: Фильтр по полям ACF
Version: 0.1
Author: dima.k
*/
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