<?php

require_once(dirname(plugin_dir_path(__FILE__)) . '/db/Data.php');
require_once(dirname(plugin_dir_path(__FILE__)) . '/db/Process.php');
require_once(dirname(plugin_dir_path(__FILE__)) . '/db/User.php');

// List User
class ListUser{
    public function __construct()
    {
        add_action('listuser', array( $this, 'show_hook_listuser')); 
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }

    function enqueue() {
        wp_enqueue_style('listUser', plugins_url('../assets/style.css', __FILE__));
    }

    public function show_hook_listuser() {
        $user_data = new Data('users');
        $user_item_data = new Data('learnpress_user_items');

        $users = $user_data->getData();
        $user_items = $user_item_data->getData();
    
        echo '<table style="width:80%" class="table-list-user">';
        echo '<tr>';
        echo    '<th>User Name</th>';
        echo    '<th>Họ tên</th>';
        echo    '<th>Email</th>';
        echo    '<th>Tiến độ</th>';
        echo '</tr>';

        foreach ($user_items as $user_item) {
            if ($user_item->status == 'enrolled' && 
            $user_item->item_id == $_GET['post']) {
                
                foreach ($users as $user) {
                    $a = new User();
                    $p = new Process();
                        
                    $value = $a->getUserName($user->ID);
                    $process = $p->getProcess($_GET['post'], $user->ID);
                        
                    echo '<tr>'; 
                    if ($user->ID == $user_item->user_id) {
                        echo '<td>' . $user->user_login . '</td>';

                        echo '<td>';
                                if (empty($value->first_name) && empty($value->last_name)) {
                                    echo '-';
                                } elseif (empty($value->first_name)) {
                                    echo $value->last_name;
                                } elseif (empty($value->last_name)) {
                                    echo $value->first_name;
                                } else {
                                    echo $value->last_name . ' ' . $value->first_name;
                                }
                        echo '</td>';

                        echo '<td>' . $user->user_email . '</td>';

                        echo '<td>' . $process . ' % </td>';
                    }
                    echo '</tr>';
                }
            }
        }
        echo '</table>'; 
    }

    public function countUser() {
        $user_data = new Data('users');
        $user_item_data = new Data('learnpress_user_items');

        $users = $user_data->getData();
        $user_items = $user_item_data->getData();

        $count = 0;

        if ( isset($_GET['post']) ) {
            foreach ($user_items as $user_item) {
                if ($user_item->status == 'enrolled' && 
                $user_item->item_id == $_GET['post']) {
                    foreach ($users as $user) {
                        $count += 1;
                    }
                }
            }
        }
        return $count;
    }
}