<?php
if(! function_exists('loadClasses')) {
    function loadClasses() {
        include( MY_PLUGIN_PATH . 'classes/Helper.php');
        include( MY_PLUGIN_PATH . 'classes/PropertyFactory.php');
        include( MY_PLUGIN_PATH . 'classes/PropertyWorker.php');
    }
}
add_action('plugins_loaded', 'loadClasses');

if(Helper::isAjax(true)) {
    $postData = file_get_contents('php://input');

    if (!$postData) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        return false;
    }
    $formData = json_decode($postData, true);
    if (!$formData['property_name'] &&
        !$formData['property_show'] &&
        !$formData['property_type'] &&
        !$formData['property_acf_name'] &&
        !$formData['property_sort']
    ) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        return false;
    }

    $postTypeSettingsObj = PropertyFactory::getPropertyByName($formData['property_name']);

    $fieldsArr = [
        'acf_name' => $formData['property_acf_name'],
        'type' => $formData['property_type'],
        'show' => $formData['property_show'],
        'sort' => $formData['property_sort']
    ];

    $outputMessage = $postTypeSettingsObj->updateProperty($fieldsArr);

    echo $outputMessage;
}