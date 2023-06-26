<?php
require_once(plugin_dir_path(__FILE__) . '/Db/Db.php');

class Process
{
    private $wpdb;

    public function __construct() {
        $a = new Db();
        $this->wpdb = $a->getDb();
    }

    public function getCountLession($courseId) {
        $arr = array();

        $query_name = "SELECT COUNT(*) AS total_lessons
        FROM wp_learnpress_sections AS ls
        JOIN wp_learnpress_section_items AS lsi ON ls.section_id = lsi.section_id
        WHERE ls.section_course_id = $courseId";

        $arr = $this->wpdb->get_results($query_name);
        return $arr[0]->total_lessons;
    }

    public function getCountLessionPass($user_id) {
        $arr = array();

        $query_name = "SELECT COUNT(*) AS count_course FROM `wp_learnpress_user_items`
        WHERE item_type = 'lp_lesson' and status = 'completed' and user_id = $user_id";

        $arr = $this->wpdb->get_results($query_name);
        return $arr[0]->count_course;
    }


    public function getProcess($courseId, $user_id) {
        $process = ($this->getCountLessionPass($user_id)/$this->getCountLession($courseId))*100;

        if (floor($process) == $process) {
            return $process;
        } else {
            return number_format($process, 2);
        }
    }
}