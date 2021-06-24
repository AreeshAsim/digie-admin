<?php
class Cron_order_backup extends CI_Controller{
  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $now_time = date("Y-m-d H:i:s");
    $time_before_2_hours = date('Y-m-d H:i:s',strtotime('-2 hours'));

    $search_arr['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($time_before_2_hours);
    $search_arr['modified_date']['$lte'] = $this->mongo_db->converToMongodttime($now_time);
    $search_arr['application_mode'] = 'live';

    $this->mongo_db->where($search_arr);
    $iterator = $this->mongo_db->get('buy_orders');
    $data_string = iterator_to_array($iterator);
    $url = 'http://207.180.198.49/admin/orders_api/orders_post';

    $ch=curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_string));
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    $result = curl_exec($ch);
    curl_close($ch);
  }

  public function get_orders_from_api(){
    $url = 'http://207.180.198.49/admin/orders_api/get_orders';
    $ch=curl_init($url);
    $result = curl_exec($ch);
    curl_close($ch);
  }

  public function orders_post()
  {
    $post_data = $this->input->post();
    foreach ($post_data as $key => $value) {
      $filter = array('_id' => $value['_id']);
      $db = $this->mongo_db->customQuery();
			$ins_data = $db->buy_orders_live_backup->updateOne($filter, array('$set' => $value), array('upsert' => true));
    }
  }

  public function testing_waqar()
  {
    $iterator = $this->mongo_db->get('buy_orders_live_backup');
    echo "<pre>";
    print_r(iterator_to_array($iterator));
    exit;
  }

}
