<?php
require_once(plugin_dir_path(__FILE__) . '/Db/Db.php');

class user
{
    private $wpdb;

    public function __construct() {
        $a = new Db();
        $this->wpdb = $a->getDb();
    }

    public function getUserName($user_id) {
        $a = array();

        $query_name = "SELECT
        um1.meta_value AS first_name,
        um2.meta_value AS last_name
        FROM
            wp_users AS u
            LEFT JOIN wp_usermeta AS um1 ON (u.ID = um1.user_id AND um1.meta_key = 'first_name')
            LEFT JOIN wp_usermeta AS um2 ON (u.ID = um2.user_id AND um2.meta_key = 'last_name')
        WHERE
            u.ID = $user_id;";

        $a = $this->wpdb->get_results($query_name);
        return $a[0];
    }
}