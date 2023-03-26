<?php
/*
 * Архитектура свойства в базе на примере массива:
 * Столбец option_name - название опции, в нашем случае cf_тип_таксономии
 * Столбец option_value хранит значения всех сохраненных свойств в виде массива:
    $arr = [
        'field_name' => [
            'type' => 'checkbox',
            'show' => 'Y',
            'sort' => '500',
        ],
        'field_name2' => [
            'type' => 'checkbox',
            'show' => 'Y',
            'sort' => '500',
        ]
    ];
 * в формате json
 * */
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

        foreach ( $post_types  as $post_type ) {
            $postTypeName = $post_type->name;
            echo '<p>' . $post_type->label . '</p>';
            echo '<p>' . $postTypeName . '</p>';
            $postTypeSettingsObj = PropertyFactory::getPropertyByName($postTypeName);
            $settingsArray = $postTypeSettingsObj->getPropertyArray();
            $groups = acf_get_field_groups(array('post_type' => $postTypeName));
            foreach ($groups as $group_key) { //todo сделать форму ?>
                <div>
                    <?
                    $fields = acf_get_fields($group_key['key']);
                    foreach ($fields as $field) {
                        if(!FieldWatcher::checkIsFieldTypeAllowed($field['type'])){
                            continue;
                        }
                        $type = '';
                        $acfType = $field['type'];
                        $acfName = $field['name'];
                        $checked = '';
                        $sort = '500';
                        if (!empty($settingsArray) && array_key_exists($acfName, $settingsArray)) {
                            if ($settingsArray[$acfName]['type']) {
                                $type = $settingsArray[$acfName]['type'];
                            }
                            if ($settingsArray[$acfName]['checked']) {
                                $checked = $settingsArray[$acfName]['checked'];
                            }
                            if ($settingsArray[$acfName]['sort']) {
                               $sort = $settingsArray[$acfName]['sort'];
                            }
                        }
                        ?>
                        <form action="">
                            <input type="hidden" value="<?=$postTypeName?>" name="property_name">
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
                            code: <b><?=$acfName?></b>
                            type: <b><?=$acfType?></b>
                        </form>
                        <?
                    } ?>
                </div>
                <?
            }
        }
    }
}
