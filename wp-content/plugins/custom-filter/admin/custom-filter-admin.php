<?php
add_action('admin_menu', 'addMenu');
if(! function_exists('addMenu')) {
    function addMenu()
    {
        add_menu_page('Filter options', 'Filter options', 4, 'acf-filter-settings', 'filterSettingsPage');
    }
}

if(! function_exists('loadClasses')) {
    function loadClasses() {
        include( MY_PLUGIN_PATH . 'classes/PropertyFactory.php');
        include( MY_PLUGIN_PATH . 'classes/PropertyWorker.php');
    }
}
add_action('plugins_loaded', 'loadClasses');

if(!function_exists('filterSettingsPage')) {
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
            $postTypeSettingsObj = PropertyFactory::getPropertyByName($post_type->name);
            var_dump($postTypeSettingsObj);
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
}
