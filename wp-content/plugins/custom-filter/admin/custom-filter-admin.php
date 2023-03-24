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
        include( MY_PLUGIN_PATH . 'classes/Helper.php');
        include( MY_PLUGIN_PATH . 'classes/PropertyFactory.php');
        include( MY_PLUGIN_PATH . 'classes/PropertyWorker.php');
        include( MY_PLUGIN_PATH . 'classes/FieldWatcher.php');
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
            echo '<p>' . $post_type->label . '</p>';
            echo '<p>' . $post_type->name . '</p>';
            $groups = acf_get_field_groups(array('post_type' => $post_type->name));
            foreach ($groups as $group_key) { //todo сделать форму, обработать поля и сделать update_field. поля закинуть в json формат. ключ - код поля ($field['name']), значение - массив из двух ключей: тип (чекбокс, диапазон чисел, радио и т.д.) и checked (значение выводить или нет)?>
                <div>
                    <?
                    $fields = acf_get_fields($group_key['key']);
                    foreach ($fields as $field) { //todo нужно выводить поля как-то по ключу искать значения в массиве из опции. если значение есть, то подставлять в форму, если нет -
                        if(!FieldWatcher::checkIsFieldTypeAllowed($field['type'])){
                            continue;
                        }
                        $propertyBaseName = $post_type->name.'_'.$field['name'];
                        $type = '';
                        $acfType = $field['type'];
                        $acfName = $field['name'];
                        $checked = '';
                        $sort = '500';
                        $fieldSettingsObj = PropertyFactory::getPropertyByName($propertyBaseName);
                        $fieldSettingsObj->setFields();
                        //var_dump($fieldSettingsObj->acfName);
                        if($fieldSettingsObj && $fieldSettingsObj->acfName) { //todo без магического метода
                            $type = $fieldSettingsObj['type'];
                            $acfType = $fieldSettingsObj['acf_type'];
                            $acfName = $fieldSettingsObj['acf_name'];
                            $checked = $fieldSettingsObj['checked'];
                            $sort = $fieldSettingsObj['sort'];
                        }
                        ?>
                        <form action="">
                            <input type="hidden" value="<?=$propertyBaseName?>" name="property_name">
                            <input type="hidden" value="<?=$acfType?>" name="property_acf_type">
                            <input type="hidden" value="<?=$acfName?>" name="property_acf_name">
                            <fieldset>
                                <label for="">
                                    <b><?=$field['label']?></b>
                                    <?FieldWatcher::printFilterTypesSelect('property_type', $acfType, $type)?>
                                </label>
                            </fieldset>
                            <fieldset>
                                <label>
                                    Выводить
                                    <input type="checkbox" name="property_show" value="<?=$checked?>">
                                </label>
                                <label>
                                    Сортировка
                                    <input type="number" name="property_sort" value="<?=$sort?>">
                                </label>
                            </fieldset>
                            <fieldset>
                            </fieldset>
                            field:
                            code: <b><?=$field['name']?></b>
                            type: <b><?=$field['type']?></b>
                        </form>
                        <?
                    } ?>
                </div>
                <?
            }
        }
    }
}
