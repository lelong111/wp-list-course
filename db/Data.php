<?php
require_once(plugin_dir_path(__FILE__) . '/Db/Db.php');

class Data {
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function getData() {
        $a = new Db();
        $wpdb = $a->getDb();

        $table_name = $wpdb->prefix . $this->data;

        $query_name = "SELECT * FROM $table_name";
        
        $results_name = $wpdb->get_results($query_name); //
        return $results_name;
    }
}