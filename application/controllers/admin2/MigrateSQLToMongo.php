<?php
/**
 *
 */
class MigrateSQLToMongo extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    ini_set("memory_limit", -1);
  }

  public function index(){
    echo "==============================SQL To Mongo Conversion==================================";
    echo "<br>";
    exit;
    echo "============================== Importing Users Data ==================================";
    echo "<br>";
    $this->import_users();
    echo "==============================Importing Coin Data==================================";
    echo "<br>";
    $this->import_coins();
    echo "==============================Importing Notifications ==================================";
    echo "<br>";
    $this->import_notification();
  }

  public function import_users(){
    $sql = "SELECT tr_users.*, tr_settings.id as settings_id,tr_settings.api_key,tr_settings.api_secret,tr_settings.auto_sell_enable FROM `tr_users` LEFT JOIN tr_settings ON tr_users.id = tr_settings.user_id";
    $query = $this->db->query($sql);
    $row_array = $query->result_array();

    foreach ($row_array as $key => $value) {
      $sql_id = $value['id'];
      $value['created_date_human'] = $value['created_date'];
      $value['created_date'] = $this->mongo_db->converToMongodttime($value['created_date']);
      $mongo_id = $this->mongo_db->insert('users',$value);

      $update_arr['mongo_user_id'] = (string) $mongo_id;
      $update_arr2['user_mongo_id'] = (string) $mongo_id;
      $this->db->where('admin_id', $sql_id);
      $this->db->update('notification',$update_arr);

      $this->db->where('user_id', $sql_id);
      $this->db->update('user_login_log',$update_arr2);
      $this->db->where('user_id', $sql_id);
      $this->db->update('user_coins',$update_arr2);
      $this->db->where('user_id', $sql_id);
      $this->db->update('coin_balance',$update_arr2);
      echo "Inserted <br>";
    }
  }
  public function import_c(){
    $sql_u = "SELECT * FROM tr_coins";
    $query_u = $this->db->query($sql_u);
    $row_array_u = $query_u->result_array();
    foreach ($row_array_u as $key => $value) {
      $sql_id = $value['id'];
      $value['user_id'] = 'global';
      $value['created_date_human'] = $value['created_date'];
      $value['created_date'] = $this->mongo_db->converToMongodttime($value['created_date']);
      $mongo_id = $this->mongo_db->insert('coins',$value);
    }
  }
  public function import_coins(){
      $sql = "SELECT * FROM tr_user_coins";
      $query = $this->db->query($sql);
      $row_array = $query->result_array();

      foreach ($row_array as $key => $value) {
        $id = $value['coin_id'];
        $user_id_sql = $value['user_id'];
        $user_id = $value['user_mongo_id'];

        $sql_u = "SELECT * FROM tr_coins WHERE id = $id";
        $query_u = $this->db->query($sql_u);
        $row_array_u = $query_u->row_array();

        $symbol = $row_array_u['symbol'];

        $sql_b = "SELECT * FROM tr_coin_balance WHERE coin_symbol = '$symbol' AND user_id = $user_id_sql";
        $query_b = $this->db->query($sql_b);
        $row_array_b= $query_b->row_array();

        $balance = $row_array_b['coin_balance'];

        $row_array_u['user_id_sql'] = $user_id_sql;
        $row_array_u['user_id'] = $user_id;
        $row_array_u['coin_balance'] = $balance;
        $row_array_u['created_date_human'] = $row_array_u['created_date'];
        $row_array_u['created_date'] = $this->mongo_db->converToMongodttime($row_array_u['created_date']);
        $mongo_id = $this->mongo_db->insert('coins',$row_array_u);
      }

  }

  public function import_notification(){
    $sql = "SELECT * FROM tr_notification";
    $query = $this->db->query($sql);
    $row_array = $query->result_array();

    foreach ($row_array as $key => $value) {
        $array['admin_id'] = $value['mongo_user_id'];
        $array['order_id'] = $value['order_id'];
        $array['type'] = $value['type'];
        $array['message'] = $value['message'];
        $array['status'] = $value['status'];
        $array['created_date_human'] = $value['created_date'];
        $array['created_date'] = $this->mongo_db->converToMongodttime($value['created_date']);
        $mongo_id = $this->mongo_db->insert('notification',$array);
    }
  }

  public function fetch_data($collection= ""){
    $this->mongo_db->limit(500);
    $this->mongo_db->order_by(array('_id' => -1));
    $get_obj = $this->mongo_db->get($collection);

    echo "<pre>";
    print_r(iterator_to_array($get_obj));
    exit;
  }

  public function truncate_collection($collection = ""){
      $resp = $this->mongo_db->drop_collection($collection);
  }
}

 ?>
