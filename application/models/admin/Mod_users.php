<?php
class mod_users extends CI_Model {

    function __construct() {

        parent::__construct();
    }

    //count all users
    public function count_all_users_sql() {

        if (!empty($_GET['query'])) {
            $search_sting = $_GET['query'];
            $filter .= " AND (tr_users.first_name LIKE '%" . $search_sting . "%' OR tr_users.last_name LIKE '%" . $search_sting . "%' OR tr_users.username LIKE '%" . $search_sting . "%' OR tr_users.email_address LIKE '%" . $search_sting . "%' OR tr_users.phone_number LIKE '%" . $search_sting . "%')";
        }
        //$rest = $this->db->count_all_results('users');
        $query = $this->db->query("SELECT count(*) as total FROM tr_users WHERE 1=1 " . $filter . " ORDER BY id DESC");
        $users_arr = $query->row_array();

        $rest = $users_arr['total'];

        return $rest;

    } //end count_all_users_sql

    public function count_all_users() {
        $filter = array();
        $session_post_data = $this->session->userdata('filter_user_data');
        if ($session_post_data['filter_by_name'] != "") {
            $filter_by_name = $session_post_data['filter_by_name'];
            $search_sting = trim($filter_by_name);
            $search_sting = str_replace("\\", "\\\\", $search_sting);
            $search_sting_like = new MongoDB\BSON\Regex(".*{$search_sting}.*", 'i');
            //$search_sting_like = new MongoDB\BSON\Regex(preg_quote($search_sting), 'i');
            $filter['$or'] = array(
                array('_id' => $search_sting_like),
                array('first_name' => $search_sting_like),
                array('last_name' => $search_sting_like),
                array('username' => $search_sting_like),
                array('phone_number' => $search_sting_like),
                array('email_address' => $search_sting_like),
            );
        }
        if ($session_post_data['filter_by_ip'] != "") {
            $filter_by_ip = $session_post_data['filter_by_ip'];
            $filter['trading_ip'] = $filter_by_ip;
        }

        if ($session_post_data['filter_by_id'] != "") {

            $filter_by_id = $session_post_data['filter_by_id'];
            $filter['_id'] = $this->mongo_db->mongoId($filter_by_id);
        }

        if ($session_post_data['filter_by_mode'] != "") {
            $filter_by_mode = $session_post_data['filter_by_mode'];
            $filter['application_mode'] = $filter_by_mode;
        }

        if ($session_post_data['filter_special'] != "") {
            $filter_special = $session_post_data['filter_special'];
            $filter['special_role'] = '1';
        }

        if ($session_post_data['filter_active'] != "") {
            $filter_special = $session_post_data['filter_active'];
            $filter['status'] = '1';
        }

        if ($session_post_data['filter_inactive'] != "") {
            $filter_special = $session_post_data['filter_inactive'];
            $filter['status'] = '0';
        }

        if ($session_post_data['filter_by_start_date'] != "" && $session_post_data['filter_by_end_date'] != "") {

            $created_datetime = date('Y-m-d G:i:s', strtotime($session_post_data['filter_by_start_date']));
            $orig_date = new DateTime($created_datetime);
            $orig_date = $orig_date->getTimestamp();
            $start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

            $created_datetime22 = date('Y-m-d G:i:s', strtotime($session_post_data['filter_by_end_date']));
            $orig_date22 = new DateTime($created_datetime22);
            $orig_date22 = $orig_date22->getTimestamp();
            $end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);

            $order_type = $session_post_data['filter_type'];
            $filter['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
        }
        if (!empty($_GET['query'])) {
            $search_sting = $_GET['query'];
            $search_sting = str_replace("\\", "\\\\", $search_sting);
            $search_sting_like = new MongoDB\BSON\Regex(preg_quote($search_sting), 'i');
            $filter['$or'] = array(
                array('first_name' => $search_sting_like),
                array('last_name' => $search_sting_like),
                array('username' => $search_sting_like),
                array('home_phone' => $search_sting_like),
                array('email_address' => $search_sting_like),
            );
        }

        $this->mongo_db->where($filter);
        $total = $this->mongo_db->count("users");

        //$rest = $users_arr['total'];
        $rest = $total;

        return $rest;

    } //end count_all_users_sql

    public function getAllUsersForCsv() {
        $filter = array();
        $session_post_data = $this->session->userdata('filter_user_data');
        if ($session_post_data['filter_by_name'] != "") {
            $filter_by_name = $session_post_data['filter_by_name'];
            $search_sting = trim($filter_by_name);
            $search_sting = str_replace("\\", "\\\\", $search_sting);
            $search_sting_like = new MongoDB\BSON\Regex(".*{$search_sting}.*", 'i');
            //$search_sting_like = new MongoDB\BSON\Regex(preg_quote($search_sting), 'i');
            $filter['$or'] = array(
                array('_id' => $search_sting_like),
                array('first_name' => $search_sting_like),
                array('last_name' => $search_sting_like),
                array('username' => $search_sting_like),
                array('phone_number' => $search_sting_like),
                array('email_address' => $search_sting_like),
            );
        }
        if ($session_post_data['filter_by_ip'] != "") {

            $filter_by_ip = $session_post_data['filter_by_ip'];
            $filter['trading_ip'] = $filter_by_ip;
        }

        if ($session_post_data['filter_by_id'] != "") {

            $filter_by_id = $session_post_data['filter_by_id'];
            $filter['_id'] = $this->mongo_db->mongoId($filter_by_id);
        }

        if ($session_post_data['filter_by_mode'] != "") {

            $filter_by_mode = $session_post_data['filter_by_mode'];
            $filter['application_mode'] = $filter_by_mode;
        }

        if ($session_post_data['filter_special'] != "") {

            $filter_special = $session_post_data['filter_special'];
            $filter['special_role'] = '1';
        }

        if ($session_post_data['filter_active'] != "") {
            $filter_special = $session_post_data['filter_active'];
            $filter['status'] = '0';
        }

        if ($session_post_data['filter_inactive'] != "") {
            $filter_special = $session_post_data['filter_inactive'];
            $filter['status'] = '1';
        }

        if ($session_post_data['filter_by_start_date'] != "" && $session_post_data['filter_by_end_date'] != "") {

            $created_datetime = date('Y-m-d G:i:s', strtotime($session_post_data['filter_by_start_date']));
            $orig_date = new DateTime($created_datetime);
            $orig_date = $orig_date->getTimestamp();
            $start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

            $created_datetime22 = date('Y-m-d G:i:s', strtotime($session_post_data['filter_by_end_date']));
            $orig_date22 = new DateTime($created_datetime22);
            $orig_date22 = $orig_date22->getTimestamp();
            $end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);

            $order_type = $session_post_data['filter_type'];
            $filter['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
        }
        if (!empty($_GET['query'])) {
            $search_sting = $_GET['query'];
            $search_sting = str_replace("\\", "\\\\", $search_sting);
            $search_sting_like = new MongoDB\BSON\Regex(preg_quote($search_sting), 'i');
            $filter['$or'] = array(
                array('_id' => $search_sting_like),
                array('first_name' => $search_sting_like),
                array('last_name' => $search_sting_like),
                array('username' => $search_sting_like),
                array('phone_number' => $search_sting_like),
                array('email_address' => $search_sting_like),
            );
        }
        $db = $this->mongo_db->customQuery();
        $search = array();
        $qrr = array('sort' => array('_id' => -1), 'skip' => $start, 'limit' => $end);
        $get_users = $db->users->find($filter, $qrr);

        $users_arr = iterator_to_array($get_users);

        return $users_arr;

    } //end getAllUsersForCsv

    //get_all_users
    public function get_all_users_sql($start, $end) {

        if (!empty($_GET['query'])) {
            $search_sting = $_GET['query'];
            $filter .= " AND (tr_users.first_name LIKE '%" . $search_sting . "%' OR tr_users.last_name LIKE '%" . $search_sting . "%' OR tr_users.username LIKE '%" . $search_sting . "%' OR tr_users.email_address LIKE '%" . $search_sting . "%' OR tr_users.phone_number LIKE '%" . $search_sting . "%')";
        }
        $query = $this->db->query("SELECT * FROM tr_users WHERE 1=1 " . $filter . " ORDER BY id DESC LIMIT " . $start . "," . $end . "");
        // $this->db->dbprefix('users');
        // $this->db->limit($end, $start);
        // $this->db->order_by('id DESC');
        // $get_users = $this->db->get('users');
        $users_arr = $query->result_array();

        return $users_arr;

    } //end get_all_users

    public function get_all_users($start, $end) {
        $filter = array();
        $session_post_data = $this->session->userdata('filter_user_data');
        if ($session_post_data['filter_by_name'] != "") {
            $filter_by_name = $session_post_data['filter_by_name'];
            $search_sting = trim($filter_by_name);
            $search_sting = str_replace("\\", "\\\\", $search_sting);
            $search_sting_like = new MongoDB\BSON\Regex(".*{$search_sting}.*", 'i');
            //$search_sting_like = new MongoDB\BSON\Regex(preg_quote($search_sting), 'i');
            $filter['$or'] = array(
                array('_id' => $search_sting_like),
                array('first_name' => $search_sting_like),
                array('last_name' => $search_sting_like),
                array('username' => $search_sting_like),
                array('phone_number' => $search_sting_like),
                array('email_address' => $search_sting_like),
            );
        }
        if ($session_post_data['filter_by_ip'] != "") {

            $filter_by_ip = $session_post_data['filter_by_ip'];
            $filter['trading_ip'] = $filter_by_ip;
        }

        if ($session_post_data['filter_by_id'] != "") {

            $filter_by_id = $session_post_data['filter_by_id'];
            $filter['_id'] = $this->mongo_db->mongoId($filter_by_id);
        }

        if ($session_post_data['filter_by_mode'] != "") {

            $filter_by_mode = $session_post_data['filter_by_mode'];
            $filter['application_mode'] = $filter_by_mode;
        }

        if ($session_post_data['filter_special'] != "") {

            $filter_special = $session_post_data['filter_special'];
            $filter['special_role'] = '1';
        }

        if ($session_post_data['filter_active'] != "") {
            $filter_special = $session_post_data['filter_active'];
            $filter['status'] = '0';
        }

        if ($session_post_data['filter_inactive'] != "") {
            $filter_special = $session_post_data['filter_inactive'];
            $filter['status'] = '1';
        }

        if ($session_post_data['filter_by_start_date'] != "" && $session_post_data['filter_by_end_date'] != "") {

            $created_datetime = date('Y-m-d G:i:s', strtotime($session_post_data['filter_by_start_date']));
            $orig_date = new DateTime($created_datetime);
            $orig_date = $orig_date->getTimestamp();
            $start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

            $created_datetime22 = date('Y-m-d G:i:s', strtotime($session_post_data['filter_by_end_date']));
            $orig_date22 = new DateTime($created_datetime22);
            $orig_date22 = $orig_date22->getTimestamp();
            $end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);

            $order_type = $session_post_data['filter_type'];
            $filter['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
        }
        if (!empty($_GET['query'])) {
            $search_sting = $_GET['query'];
            $search_sting = str_replace("\\", "\\\\", $search_sting);
            $search_sting_like = new MongoDB\BSON\Regex(preg_quote($search_sting), 'i');
            $filter['$or'] = array(
                array('_id' => $search_sting_like),
                array('first_name' => $search_sting_like),
                array('last_name' => $search_sting_like),
                array('username' => $search_sting_like),
                array('phone_number' => $search_sting_like),
                array('email_address' => $search_sting_like),
            );
        }
        $db = $this->mongo_db->customQuery();
        $search = array();
        $qrr = array('sort' => array('_id' => -1), 'skip' => $start, 'limit' => $end);
        $get_users = $db->users->find($filter, $qrr);

        $users_arr = iterator_to_array($get_users);

        return $users_arr;

    } //end get_all_users

    //get_all_users
    public function getAllUsersWithMemberId_sql($start, $end) {

        $this->db->dbprefix('users');
        $this->db->where('kula_member_id >', 0);
        $this->db->order_by('id DESC');
        $get_users = $this->db->get('users');
        $users_arr = $get_users->result_array();

        return $users_arr;

    } //end get_all_users

    public function getUser($start, $end) {

        $this->mongo_db->where(array('kula_member_id' => array('$gte' => 0)));
        $this->mongo_db->order_by(array('id' => -1));
        $get_users = $this->mongo_db->get('users');
        $users_arr = iterator_to_array($get_users);

        return $users_arr;

    } //end get_all_users

    public function getAllUsersWithMemberId($start, $end) {

        $this->mongo_db->where(array('kula_member_id' => array('$gte' => 0)));
        $this->mongo_db->order_by(array('id' => -1));
        $get_users = $this->mongo_db->get('users');
        $users_arr = iterator_to_array($get_users);

        return $users_arr;

    } //end get_all_users

    //get_all_users
    public function get_all_users_bk() {

        $this->db->dbprefix('users');
        $this->db->order_by('id DESC');
        $get_users = $this->db->get('users');

        //echo $this->db->last_query();
        $users_arr = $get_users->result_array();

        return $users_arr;

    } //end get_all_users

    //get_all_users_mongo
    public function get_all_users_mongo() {

        $this->mongo_db->sort(array('_id' => -1));
        $get_users = $this->mongo_db->get('users');

        //echo $this->db->last_query();
        $users_arr = iterator_to_array($get_users);

        return $users_arr;

    } //end get_all_users_mongo

    //get_user
    public function get_user($user_id) {

        $this->mongo_db->where(array('_id' => $user_id));
        $get_users = $this->mongo_db->get('users');

        //echo $this->db->last_query();
        $user_arr = iterator_to_array($get_users);

        //echo "<pre>";  print_r( $user_arr); exit;

        return $user_arr[0];

    } //end get_user

    //get_user
    public function report_user_email_exists($data) {

        extract($data);

        // // Response return from ongage
        /*$post_data = print_r($data, true);
        $data1 = $post_data;
        $fp = fopen('shahzaddddd.txt', 'a') or exit("Unable to open file!");
        fwrite($fp, $data1);
        fclose($fp);
        //User Signup
        exit;
         */

        $this->mongo_db->where(array('email_address' => $email_address));
        $get_users = $this->mongo_db->get('users');

        //echo $this->db->last_query();
        $user_arr = iterator_to_array($get_users);
        return (string) $user_arr[0]->_id;

    } //end get_user

    // Ali khan Work Goes herer ************************************************************

    //checkUserExist
    public function checkDgUserRefferAllinKB($email_address) {

        $get_users = $this->mongo_db->get('users');
        $user_arr = iterator_to_array($get_users);
        return $user_arr; // return $user_arr;

    } //end checkUserExistThroughEmail

    //checkUserExist
    // public function checkUserExist($user_id,$email_address) {
    //
    //     $this->db->dbprefix('users');
    //     $this->db->where('id', $user_id);
    //     $this->db->where('email_address', $email_address);
    //     $get_user = $this->db->get('users');
    //     $user_arr = $get_user->row_array();
    //     return $user_arr;
    //
    // } //end checkUserExist
    //
    // //checkUserExist
    // public function checkUserExistThroughEmail($email_address) {
    //
    //     $this->db->dbprefix('users');
    //     $this->db->where('email_address', $email_address);
    //     $get_user = $this->db->get('users');
    //     $user_arr = $get_user->row_array();
    //     return $user_arr;
    //
    // } //end checkUserExistThroughEmail
    //
    //
    // //updateUserReposrtId
    // public function updateUserReposrtId($report_id,$member_id,$dg_id) {
    //
    //         $upd_data = array(
    //            'report_id' => $this->db->escape_str(trim($report_id)),
    //            'kula_member_id' => $this->db->escape_str(trim($member_id))
    //         );
    //
    //         $this->db->dbprefix('users');
    //         $this->db->where('id',$dg_id);
    //         $upd_into_db = $this->db->update('users', $upd_data);
    //
    //     return $upd_into_db;
    //
    // } //end updateUserReposrtId

    public function checkUserExist($user_id, $email_address) {

        // $this->db->dbprefix('users');
        // $this->db->where('id', $user_id);
        // $this->db->where('email_address', $email_address);
        // $get_user = $this->db->get('users');
        // $user_arr = $get_user->row_array();
        //

        $this->mongo_db->where(array('_id' => $user_id, 'email_address' => $email_address));
        $get_users = $this->mongo_db->get('users');
        $user_arr = iterator_to_array($get_users);
        return $user_arr[0];
        //return $user_arr;

    } //end checkUserExist

    //checkUserExist
    public function checkUserExistThroughEmail($email_address) {

        // $this->db->dbprefix('users');
        // $this->db->where('email_address', $email_address);
        // $get_user = $this->db->get('users');
        // $user_arr = $get_user->row_array();

        $this->mongo_db->where(array('email_address' => $email_address));
        $get_users = $this->mongo_db->get('users');
        $user_arr = iterator_to_array($get_users);
        return $user_arr[0];
        // return $user_arr;

    } //end checkUserExistThroughEmail

    //updateUserReposrtId
    public function updateUserReposrtId($report_id, $member_id, $dg_id) {

        $upd_data = array(
            'report_id' => $this->db->escape_str(trim($report_id)),
            'kula_member_id' => $this->db->escape_str(trim($member_id)),
        );

        //$this->db->dbprefix('users');
        $this->db->where('_id', $dg_id);
        $this->mongo_db->set($upd_data);
        $upd_into_db = $this->mongo_db->update('users');

        return $upd_into_db;

    } //end updateUserReposrtId

    //get_user_mongo
    public function get_user_sql($user_id) {

        $this->db->dbprefix('users');
        $this->db->where('id', $user_id);
        $get_user = $this->db->get('users');

        //echo $this->db->last_query(); exit;
        $user_arr = $get_user->row_array();

        return $user_arr;

    } //end get_user_mongo

    //add_user
    public function add_user($data) {
        extract($data);

        $created_date = date('Y-m-d G:i:s');
        $created_date_mongo = $this->mongo_db->converToMongodttime($created_date);
        $ins_data = array(
            'first_name' => $this->db->escape_str(trim($first_name)),
            'last_name' => $this->db->escape_str(trim($last_name)),
            'username' => $this->db->escape_str(trim($username)),
            'email_address' => $this->db->escape_str(trim($email_address)),
            'phone_number' => $this->db->escape_str(trim($phone_number)),
            'password' => $this->db->escape_str(trim(md5($password))),
            'status' => $this->db->escape_str(trim(0)),
            'user_role' => $this->db->escape_str(trim(2)),
            'user_soft_delete' => $this->db->escape_str(trim(0)),
            'special_role' => $this->db->escape_str(trim(0)),
            'google_auth' => $this->db->escape_str(trim('no')),
            'created_date_human' => $this->db->escape_str(trim($created_date)),
            'created_date' => $created_date_mongo,
            'source' => 'admin',
            'application_mode' => $this->db->escape_str(trim($application_mode)),
        );
        if ($trading_ip != "") {
            $ins_data['trading_ip'] = $trading_ip;
        }

        $ins_data['profile_image'] = "profile_5bced7720892a1540282226";
        //Insert the record into the database.

        $ins_into_db = $this->mongo_db->insert('users', $ins_data);
        //echo $this->db->last_query();exit;

        return true;

    } //end add_user()

    //add_user_mongo
    public function add_user_sql($data) {

        extract($data);

        $created_date = $this->mongo_db->converToMongodttime(date('Y-m-d G:i:s'));

        $ins_data = array(
            'first_name' => $this->db->escape_str(trim($first_name)),
            'last_name' => $this->db->escape_str(trim($last_name)),
            'username' => $this->db->escape_str(trim($username)),
            'email_address' => $this->db->escape_str(trim($email_address)),
            'phone_number' => $this->db->escape_str(trim($phone_number)),
            'password' => $this->db->escape_str(trim(md5($password))),
            'created_date' => $this->db->escape_str(trim($created_date)),
        );
        if ($application_mode != "") {
            $ins_data['application_mode'] = $application_mode;
        }
        if ($trading_ip != "") {
            $ins_data['trading_ip'] = $trading_ip;
        }
        //Insert the record into the database.
        $ins_into_db = $this->mongo_db->insert('users', $ins_data);
        //echo $this->db->last_query();exit;

        if ($ins_into_db) {
            return $ins_into_db;
        }

    } //end add_user_mongo()

    //contact_us_process
    public function contact_us_process($data) {

        extract($data);

        $created_date = date('Y-m-d G:i:s');
        $created_date_mongo = $this->mongo_db->converToMongodttime($created_date);
        $ins_data = array(
            'member_id' => $this->db->escape_str(trim($data->member_id)),
            'username' => $this->db->escape_str(trim($data->username)),
            'kula_subject' => $this->db->escape_str(trim($data->kula_subject)),
            'kula_message' => $this->db->escape_str(trim($data->kula_message)),
            'email_address' => $this->db->escape_str(trim($data->email_address)),
            'first_name' => $this->db->escape_str(trim(($data->first_name))),
            'last_name' => $this->db->escape_str(trim($data->first_name)),
            'subject' => $this->db->escape_str(trim($data->subject)),
            'message' => $this->db->escape_str(trim($data->message)),
            'created_date_human' => $this->db->escape_str(trim($created_date)),
            'created_date_mongo' => $created_date_mongo,
        );
        //Insert the record into the database.
        $this->db->dbprefix('contact_us');
        $ins_into_db = $this->mongo_db->insert('contact_us', $ins_data);
        return true;
    } //end contact_us_process()

    //edit_user
    public function edit_user_sql($data) {
        extract($data);

        $upd_data = array(
            'report_id' => $this->db->escape_str(trim($report_id)),
            'first_name' => $this->db->escape_str(trim($first_name)),
            'last_name' => $this->db->escape_str(trim($last_name)),
            'username' => $this->db->escape_str(trim($username)),
            'email_address' => $this->db->escape_str(trim($email_address)),
            'phone_number' => $this->db->escape_str(trim($phone_number)),
            'timezone' => $this->db->escape_str(trim($timezone)),
        );

        if ($application_mode != "") {
            $upd_data['application_mode'] = $application_mode;
        }
        if ($trading_ip != "") {
            $upd_data['trading_ip'] = $trading_ip;
        }
        if ($password != "") {
            $upd_data['password'] = md5($password);
        }

        //Uploading profile Imaage
        if ($_FILES['profile_image']['name'] != '') {

            //Create User Directory if not exist
            $user_folder_path = 'assets/profile_images/';

            if (!is_dir($user_folder_path)) {
                mkdir($user_folder_path);
            }

            $profile_file_name = $_FILES['profile_image']['name'];
            $ext = pathinfo($profile_file_name, PATHINFO_EXTENSION);
            $new_name = 'profile_' . uniqid() . time() . '.' . $ext;

            $config['upload_path'] = $user_folder_path;
            $config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
            $config['max_size'] = '1000';
            $config['overwrite'] = true;
            $config['file_name'] = $new_name;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('profile_image')) {

                $error_file_arr = array('error' => $this->upload->display_errors());
                return $error_file_arr;
            }

            $upd_data['profile_image'] = $this->db->escape_str(trim($new_name));

            $profile_session = array(
                'profile_image' => trim($new_name),
            );

            $this->session->set_userdata($profile_session);

        } else {
            $upd_data['profile_image'] = "profile_5bced7720892a1540282226";
        } //end if($_FILES['profile_image']['name'] != '')

        //Update the record into the database.

        $this->db->dbprefix('users');
        $this->db->where('id', $user_id);
        $upd_into_db = $this->db->update('users', $upd_data);

        $filter_arr['timezone'] = $timezone;

        $this->session->set_userdata($filter_arr);

        if ($upd_into_db) {
            return $user_id;
        }

    } //end edit_user()

    //edit_user_mongo
    public function edit_user($data) {

        extract($data);

        $upd_data = array(
            'first_name' => $this->db->escape_str(trim($first_name)),
            'last_name' => $this->db->escape_str(trim($last_name)),
            'username' => $this->db->escape_str(trim($username)),
            'email_address' => $this->db->escape_str(trim($email_address)),
            'phone_number' => $this->db->escape_str(trim($phone_number)),

        );

        if ($password != "") {
            $upd_data['password'] = md5($password);
            $upd_data['is_password_changed'] = 'yes';
        }

        if ($timezone != "") {
            $upd_data['timezone'] = ($timezone);
        }

        if ($trading_ip != "") {
            $upd_data['trading_ip'] = $trading_ip;
        }

        if ($google_auth == "no") {
            $upd_data['google_auth'] = $google_auth;
            $upd_data['google_auth_code'] = "";
        }
        //Uploading profile Imaage
        if ($_FILES['profile_image']['name'] != '') {

            //Create User Directory if not exist
            $user_folder_path = 'assets/profile_images/';

            if (!is_dir($user_folder_path)) {
                mkdir($user_folder_path);
            }

            $profile_file_name = $_FILES['profile_image']['name'];
            $ext = pathinfo($profile_file_name, PATHINFO_EXTENSION);
            $new_name = 'profile_' . uniqid() . time() . '.' . $ext;

            $config['upload_path'] = $user_folder_path;
            $config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
            $config['max_size'] = '1000';
            $config['overwrite'] = true;
            $config['file_name'] = $new_name;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('profile_image')) {

                $error_file_arr = array('error' => $this->upload->display_errors());
                return $error_file_arr;
            }

            $upd_data['profile_image'] = $this->db->escape_str(trim($new_name));

            $profile_session = array(
                'profile_image' => trim($new_name),
            );

            $this->session->set_userdata($profile_session);

        } //end if($_FILES['profile_image']['name'] != '')

        //Update the record into the database.

        $this->mongo_db->where(array('_id' => $user_id));
        $this->mongo_db->set($upd_data);
        $upd_into_db = $this->mongo_db->update('users', $upd_data);

        if ($upd_into_db) {
            return $user_id;
        }

    } //end edit_user_mongo()

    //delete_user
    public function delete_user_sql($user_id) {

        //Delete user Record
        $this->db->dbprefix('users');
        $this->db->where('id', $user_id);
        $this->db->delete('users');

        return true;

    } //end delete_user()

    public function update_user_role_sql($user_id, $role_id) {

        //Delete user Record

        $upd_arr['special_role'] = $role_id;
        $this->db->dbprefix('users');
        $this->db->where('id', $user_id);
        $this->db->update('users', $upd_arr);

        return true;

    } //end delete_user()

    public function update_user_role($user_id, $role_id) {

        //Delete user Record

        $upd_arr['special_role'] = $role_id;
        $this->mongo_db->where(array('_id' => $user_id));
        $this->mongo_db->set($upd_arr);
        $this->mongo_db->update('users');

        return true;

    } //end delete_user()

    public function update_user_status($user_id, $role_id) {

        //Delete user Record

        $upd_arr['status'] = $role_id;
        $this->mongo_db->where(array('_id' => $user_id));
        $this->mongo_db->set($upd_arr);
        $this->mongo_db->update('users');

        return true;

    } //end delete_user()

    //delete_user_mongo
    public function delete_user($user_id) {

        //Delete user Record
        $this->mongo_db->where(array('_id' => $user_id));
        $this->mongo_db->delete('users');

        return true;

    } //end delete_user_mongo()

    //user_signup
    public function user_signup_sql($data) {

        extract($data);

        $created_date = date('Y-m-d G:i:s');

        //Generate Random code
        $get_random_data = $this->random_number_generator(10);
        $activation_code = md5($get_random_data);
        $trading_ip = $this->get_random_ip();

        $ins_data = array(
            'first_name' => $this->db->escape_str(trim($first_name)),
            'last_name' => $this->db->escape_str(trim($last_name)),
            'username' => $this->db->escape_str(trim($username)),
            'email_address' => $this->db->escape_str(trim($email_address)),
            'phone_number' => $this->db->escape_str(trim($phone_number)),
            'password' => $this->db->escape_str(trim(md5($password))),
            'application_mode' => 'test',
            'activation_code' => $this->db->escape_str(trim($activation_code)),
            'status' => $this->db->escape_str(trim(0)),
            'created_date' => $this->db->escape_str(trim($created_date)),
            'timezone' => $this->db->escape_str(trim($timezone)),
            'trading_ip' => $trading_ip,
        );

        //Insert the record into the database.
        $this->db->dbprefix('users');
        $ins_into_db = $this->db->insert('users', $ins_data);
        //echo $this->db->last_query();exit;

        $user_id = $this->db->insert_id();

        //$activation_link = SURL."admin/signup/activate/".$user_id."/".$activation_code;

        // /********************************/
        // $this->load->helper(array('email', 'url'));

        // $email_from_txt = 'DigieBot';
        // $noreply_email = 'noreplyl@digiebot.com';
        // $email_subject = 'DigieBot Account Activation';

        // $email_body = 'Please click the link for Account Activation <a href="'.$activation_link.'" target="_blank">Click Here</a>';

        // To send HTML mail, the Content-type header must be set
        // $headers  = 'MIME-Version: 1.0' . "\r\n";
        // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // // Additional headers
        // $headers .= 'To: <'.$email_address.'>' . "\r\n";
        // $headers .= 'From: '.$email_from_txt.' <'.$noreply_email.'>' . "\r\n";

        // // Mail it
        // mail($to, $email_subject, $email_body, $headers);

        //Preparing Sending Email
        // $config['charset'] = 'utf-8';
        // $config['mailtype'] = 'html';
        // $config['wordwrap'] = TRUE;
        // $config['protocol'] = 'mail';

        // $this->load->library('email',$config);

        // $this->email->from($noreply_email, $email_from_txt);
        // $this->email->to($email_address);
        // $this->email->subject($email_subject);
        // $this->email->message($email_body);
        // $this->email->send();
        // //echo $this->email->print_debugger();
        // $this->email->clear();
        //echo $this->db->last_query(); exit;

        return $user_id;

    } //end user_signup()

    //user_signup
    public function user_signup($data) {

        extract($data);

        $created_date = date('Y-m-d G:i:s');
        $created_date_mongo = $this->mongo_db->converToMongodttime(date('Y-m-d G:i:s'));
        //Generate Random code
        $get_random_data = $this->random_number_generator(10);
        $activation_code = md5($get_random_data);

        $trading_ip = $this->get_random_ip();

        $ins_data = array(
            'first_name' => $this->db->escape_str(trim($first_name)),
            'last_name' => $this->db->escape_str(trim($last_name)),
            'username' => $this->db->escape_str(trim($username)),
            'email_address' => $this->db->escape_str(trim($email_address)),
            'phone_number' => $this->db->escape_str(trim($phone_number)),
            'password' => $this->db->escape_str(trim(md5($password))),
            'activation_code' => $this->db->escape_str(trim($activation_code)),
            'application_mode' => 'test',
            'status' => $this->db->escape_str(trim(0)),
            'user_role' => $this->db->escape_str(trim(2)),
            'user_soft_delete' => $this->db->escape_str(trim(0)),
            'special_role' => $this->db->escape_str(trim(0)),
            'google_auth' => $this->db->escape_str(trim('no')),
            'created_date_human' => $this->db->escape_str(trim($created_date)),
            'created_date' => $created_date_mongo,
            'timezone' => $this->db->escape_str(trim($timezone)),
            'trading_ip' => $trading_ip,
            'source' => 'digie_signup',
        );
        $ins_data['profile_image'] = "profile_5bced7720892a1540282226";
        //Insert the record into the database.
        $user_id = $this->mongo_db->insert('users', $ins_data);
        //echo $this->db->last_query();exit;

        //$user_id = $this->db->insert_id();

        //$activation_link = SURL."admin/signup/activate/".$user_id."/".$activation_code;

        // /********************************/
        // $this->load->helper(array('email', 'url'));

        // $email_from_txt = 'DigieBot';
        // $noreply_email = 'noreplyl@digiebot.com';
        // $email_subject = 'DigieBot Account Activation';

        // $email_body = 'Please click the link for Account Activation <a href="'.$activation_link.'" target="_blank">Click Here</a>';

        // To send HTML mail, the Content-type header must be set
        // $headers  = 'MIME-Version: 1.0' . "\r\n";
        // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // // Additional headers
        // $headers .= 'To: <'.$email_address.'>' . "\r\n";
        // $headers .= 'From: '.$email_from_txt.' <'.$noreply_email.'>' . "\r\n";

        // // Mail it
        // mail($to, $email_subject, $email_body, $headers);

        //Preparing Sending Email
        // $config['charset'] = 'utf-8';
        // $config['mailtype'] = 'html';
        // $config['wordwrap'] = TRUE;
        // $config['protocol'] = 'mail';

        // $this->load->library('email',$config);

        // $this->email->from($noreply_email, $email_from_txt);
        // $this->email->to($email_address);
        // $this->email->subject($email_subject);
        // $this->email->message($email_body);
        // $this->email->send();
        // //echo $this->email->print_debugger();
        // $this->email->clear();
        //echo $this->db->last_query(); exit;

        return $user_id;

    } //end user_signup()

    //add_users_digiebot_from_report
    public function add_users_digiebot_from_report($data) {

        extract($data);
        //$this->db->dbprefix('user_login_log');
        $this->mongo_db->where(array('email_address' => $email_address));
        $this->mongo_db->limit(1);
        $this->mongo_db->order_by(array('_id' => -1));
        $get_user = $this->mongo_db->get('users');

        $user_info = iterator_to_array($get_user);
        if (count($user_info) > 0) {
            return $user_info[0]['_id'];
        } else {

            $created_date = date('Y-m-d G:i:s');
            $created_date_mongo = $this->mongo_db->converToMongodttime(date('Y-m-d G:i:s'));
            //Generate Random code
            $get_random_data = $this->random_number_generator(10);
            $activation_code = md5($get_random_data);
            $trading_ip = $this->get_random_ip();

            $ins_data = array(
                'first_name' => $this->db->escape_str(trim($first_name)),
                'last_name' => $this->db->escape_str(trim($last_name)),
                'username' => $this->db->escape_str(trim($username)),
                'email_address' => $this->db->escape_str(trim($email_address)),
                'phone_number' => $this->db->escape_str(trim($phone_number)),
                'password' => $this->db->escape_str(trim(md5($password))),
                'org_password' => $this->db->escape_str(trim(($password))),
                'activation_code' => $this->db->escape_str(trim($activation_code)),
                'application_mode' => 'test',
                'status' => $this->db->escape_str(trim(0)),
                'user_role' => $this->db->escape_str(trim(2)),
                'user_soft_delete' => $this->db->escape_str(trim(0)),
                'special_role' => $this->db->escape_str(trim(0)),
                'google_auth' => $this->db->escape_str(trim('no')),
                'created_date_human' => $this->db->escape_str(trim($created_date)),
                'created_date' => $created_date_mongo,
                'timezone' => $this->db->escape_str(trim($timezone)),
                'trading_ip' => $trading_ip,
                'source' => 'digie_report',
            );
            $ins_data['profile_image'] = "profile_5bced7720892a1540282226";

            //echo "<pre>";  print_r($ins_data); exit;
            //Insert the record into the database.
            $user_id = $this->mongo_db->insert('users', $ins_data);
            //echo $this->db->last_query();exit;

            //$user_id = $this->db->insert_id();

            //$activation_link = SURL."admin/signup/activate/".$user_id."/".$activation_code;

            // /********************************/
            // $this->load->helper(array('email', 'url'));

            // $email_from_txt = 'DigieBot';
            // $noreply_email = 'noreplyl@digiebot.com';
            // $email_subject = 'DigieBot Account Activation';

            // $email_body = 'Please click the link for Account Activation <a href="'.$activation_link.'" target="_blank">Click Here</a>';

            // To send HTML mail, the Content-type header must be set
            // $headers  = 'MIME-Version: 1.0' . "\r\n";
            // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            // // Additional headers
            // $headers .= 'To: <'.$email_address.'>' . "\r\n";
            // $headers .= 'From: '.$email_from_txt.' <'.$noreply_email.'>' . "\r\n";

            // // Mail it
            // mail($to, $email_subject, $email_body, $headers);

            //Preparing Sending Email
            // $config['charset'] = 'utf-8';
            // $config['mailtype'] = 'html';
            // $config['wordwrap'] = TRUE;
            // $config['protocol'] = 'mail';

            // $this->load->library('email',$config);

            // $this->email->from($noreply_email, $email_from_txt);
            // $this->email->to($email_address);
            // $this->email->subject($email_subject);
            // $this->email->message($email_body);
            // $this->email->send();
            // //echo $this->email->print_debugger();
            // $this->email->clear();
            //echo $this->db->last_query(); exit;

            return $user_id;
        }

    } //end add_users_digiebot_from_report()

    //Random Password Generator
    public function random_number_generator($digit) {

        $randnumber = '';
        $totalChar = $digit; //length of random number
        $salt = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"; // salt to select chars
        srand((double) microtime() * 1000000); // start the random generator
        $password = ""; // set the inital variable

        for ($i = 0; $i < $totalChar; $i++) // loop and create number
        {
            $randnumber = $randnumber . substr($salt, rand() % strlen($salt), 1);
        }

        return $randnumber;

    } // random_password_generator()

    //account_activation
    public function account_activation_sql($user_id, $activation_code) {

        $this->db->dbprefix('users');
        $this->db->where('id', $user_id);
        $this->db->where('activation_code', $activation_code);
        $get_user = $this->db->get('users');

        //echo $this->db->last_query(); exit;
        $user_arr = $get_user->row_array();

        if (count($user_arr) > 0) {

            $upd_data = array(
                'status' => $this->db->escape_str(trim(0)),
            );

            //Update the record into the database.
            $this->db->dbprefix('users');
            $this->db->where('id', $user_id);
            $this->db->update('users', $upd_data);

            return true;

        } else {

            return false;
        }

    } //end account_activation

    public function account_activation($user_id, $activation_code) {

        $this->db->where(array('_id' => $user_id, 'activation_code', $activation_code));
        $get_user = $this->mongo_db->get('users');

        //echo $this->db->last_query(); exit;
        $user_arr = iterator_to_array($get_user);

        if (count($user_arr) > 0) {

            $upd_data = array(
                'status' => $this->db->escape_str(trim(0)),
            );

            //Update the record into the database.
            //$this->db->dbprefix('users');
            $this->mongo_db->where(array('_id' => $user_id));
            $this->mongo_db->set($upd_data);
            $this->mongo_db->update('users', $upd_data);

            return true;

        } else {

            return false;
        }

    } //end account_activation_mongo

    public function get_user_login_info($user_id) {
        //$this->db->dbprefix('user_login_log');
        $this->mongo_db->where(array('user_id' => $user_id));
        $this->mongo_db->limit(10);
        $this->mongo_db->order_by(array('_id' => -1));
        $get_user = $this->mongo_db->get('user_login_log');

        $user_info = iterator_to_array($get_user);

        return $user_info;
    }

    public function get_user_transaction_info($user_id) {
        $this->mongo_db->where(array('user_id' => $this->mongo_db->mongoId($user_id), 'txType' => "Deposit"));
        $get_user = $this->mongo_db->get('user_transaction_history');

        $user_info['deposit'] = iterator_to_array($get_user);

        $this->mongo_db->where(array('user_id' => $this->mongo_db->mongoId($user_id), 'txType' => "Withdraw"));
        $get_user2 = $this->mongo_db->get('user_transaction_history');

        $user_info['withdraw'] = iterator_to_array($get_user2);

        return $user_info;
    }

    public function get_random_ip() {
        $ip_arr = array('50.28.36.48', '50.28.36.49', '50.28.36.33', '50.28.36.34', '50.28.36.35');
        $i = array_rand($ip_arr, 1);
        return $ip_arr[$i];

    }

    public function update_application_mode($user_id, $mode) {
        $upd_arr['application_mode'] = $mode;
        $this->mongo_db->where(array('_id' => $user_id));
        $this->mongo_db->set($upd_arr);
        $this->mongo_db->update('users');
    }

    public function update_trigger_mode($user_id, $mode) {
        $upd_arr['trigger_enable'] = $mode;
        $this->mongo_db->where(array('_id' => $user_id));
        $this->mongo_db->set($upd_arr);
        $this->mongo_db->update('users');
    }

    public function update_app_mode($user_id, $mode) {
        $upd_arr['app_enable'] = $mode;
        $this->mongo_db->where(array('_id' => $user_id));
        $this->mongo_db->set($upd_arr);
        $this->mongo_db->update('users');
    }

    public function get_user_timezone($user_id) {
        $user_arr = $this->get_user($user_id);
        return $user_arr['timezone'];
    }

}
?>
