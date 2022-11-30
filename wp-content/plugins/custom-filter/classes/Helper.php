<?php


class Helper
{
    public static function option_exists($name, $site_wide=false){
        global $wpdb; return $wpdb->query("SELECT * FROM ". ($site_wide ? $wpdb->base_prefix : $wpdb->prefix). "options WHERE option_name ='$name' LIMIT 1");
    }
}