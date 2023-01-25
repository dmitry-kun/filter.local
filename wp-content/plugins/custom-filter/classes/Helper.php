<?php


class Helper
{
    public static function option_exists($name, $site_wide=false){
        global $wpdb; return $wpdb->query("SELECT * FROM ". ($site_wide ? $wpdb->base_prefix : $wpdb->prefix). "options WHERE option_name ='$name' LIMIT 1");
    }

    /**
     * @param bool $bPostOnly
     * @return bool
     */
    static public function isAjax($bPostOnly = false)
    {
        if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest' || !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            return false;
        }
        if ($bPostOnly && $_SERVER['REQUEST_METHOD'] != 'POST') {
            return false;
        }

        return true;
    }
}