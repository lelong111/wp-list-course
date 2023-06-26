<?php

class Db {
    private $wpdb;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    public function getDb() {
        return $this->wpdb;
    }
}