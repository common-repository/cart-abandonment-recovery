<?php
/**
 * Trigger this file on Plugin uninstall
 * 
 * @package Cart-Abandonment-Recovery-Chat
 */
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

global $wpdb;
$table_name_a = $wpdb->prefix . "CARC_Abandonment";
$table_name_b = $wpdb->prefix . "CARC_Template";
$table_name_c = $wpdb->prefix . "CARC_Variables";
$table_name_d = $wpdb->prefix . "CARC_Settings";
$wpdb->query("DROP TABLE IF EXISTS $table_name_a, $table_name_b, $table_name_c, $table_name_d");
    