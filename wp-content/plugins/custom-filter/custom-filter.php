<?php
include 'classes/Helper.php';
/*
Plugin Name: ACF Filter
Description: Фильтр по полям ACF
Version: 0.1
Author: dima.k
*/
//https://wp-admin.com.ua/hranenie-dannyih-v-vordpress/ - про хранение настроек в бд
//https://wordpress.stackexchange.com/questions/71420/add-option-if-not-exists - проверка существования настройки
// планирую сохранять настройки а ля json (или в сериализованном виде)
// {post_type: {field_name : { type : 'select/range/checkbox/radio', show: Y/N }, {type...} }, {field{...}...}} -  может быть дополнить
// лучше хранить настройки как option_name = 'cf_'.$post_type->name, option_value = сериализованный массив данных полей ACF (тип, вкл\выкл)
//при выводе нужно выводить поля как сейчас. данные будут отправляться формой. данные о типе, выводе и пр. получать из настроек по post_type и field
// выводимый тип поля зависит от типа поля в acf, например range может быть только у number
//
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

    foreach ( $post_types  as $post_type ) { //todo проверять есть ли опция и делать get_option
        if (!Helper::option_exists('cf_'.$post_type->name)) {
            add_option('cf_'.$post_type->name, "");
        }
        $postTypeSettings = json_decode(get_option('cf_'.$post_type->name));
        echo '<p>' . $post_type->label . '</p>';
        echo '<p>' . $post_type->name . '</p>';
        $groups = acf_get_field_groups(array('post_type' => $post_type->name));
        foreach ($groups as $group_key) { //todo сделать форму, обработать поля и сделать update_field. поля закинуть в json формат. ключ - код поля ($field['name']), значение - массив из двух ключей: тип (чекбокс, диапазон чисел, радио и т.д.) и checked (значение выводить или нет)?>
            <form action="">
                <input type="hidden" value="<?='cf_'.$post_type->name?>">
                <?
                $fields = acf_get_fields($group_key['key']);
                foreach ($fields as $field) { //todo нужно выводить поля как-то по ключу искать значения в массиве из опции. если значение есть, то подставлять в форму, если нет -
                    if(array_key_exists($field['name'], $postTypeSettings)) {
                        $type = $postTypeSettings[$field['name']]['type'];
                        $checked = $postTypeSettings[$field['name']]['checked'];
                    }
                    ?>
                        <fieldset>
                            <label for="">
                                <b><?=$field['label']?></b>
                                <select name="<?='type_'.$field['name']?>">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>

                            </label>
                            <label>
                                Выводить
                                <input type="checkbox" name="<?='check_'.$field['name']?>" value="N">
                            </label>
                        </fieldset>
                        field:
                        code: <b><?=$field['name']?></b>
                        type: <b><?=$field['type']?></b>
                    <?
                } ?>
            </form>
            <?
        }
    }
}