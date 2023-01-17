<?php
include 'classes/Helper.php';

define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
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
if( is_admin()) {
    require_once( dirname(__FILE__). '/admin/custom-filter-admin.php');
}

