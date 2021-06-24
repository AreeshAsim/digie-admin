<?php
/****/
class Reports extends CI_Controller {

    function __construct() {

        parent::__construct();
        //load main template
        ini_set("memory_limit", -1);
        // ini_set("display_errors", E_ALL);
        // error_reporting(E_ALL);
        $this->stencil->layout('admin_layout');
        //load required slices
        $this->stencil->slice('admin_header_script');
        $this->stencil->slice('admin_header');
        $this->stencil->slice('admin_left_sidebar');
        $this->stencil->slice('admin_footer_script');
        //if($_SERVER['REMOTE_ADDR'] == '101.50.127.131' ){
        //echo "<pre>";   print_r($responseArr); exit;
        //}

        //load models
        $this->load->model('admin/mod_report');
        $this->load->model('admin/mod_dashboard');
        $this->load->model('admin/mod_coins');
        $this->load->model('admin/mod_login');
        $this->load->model('admin/mod_buy_orders');

        if ($this->session->userdata('user_role') != 1) {
            redirect(base_url() . 'forbidden');
        }
        // if ($this->session->userdata('special_role') != 1) {
        //     redirect(base_url() . 'forbidden');
        // }

    }

    public function index() {
        //Login Check
        $this->mod_login->verify_is_admin_login();

        $this->stencil->paint('admin/reports/home', $data);

    }

    // public function basic_reporting() {
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();

    //     $customers = $this->mod_report->get_all_customers();

    //     $data['customers'] = $customers;

    //     $coins = $this->mod_coins->get_all_coins();

    //     $data['coins'] = $coins;

    //     //$orders = $this->mod_report->get_parent_orders();
    //     $orders = array();
    //     $data['orders'] = $orders;

    //     $this->stencil->paint('admin/reports/index', $data);

    // }
    // public function get_report() {
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();

    //     $error = array();
    //     if (!empty($this->input->post())) {
    //         $cust_id = $this->input->post('admin_id');
    //         if (!empty($cust_id)) {
    //             $data_sess['cust_id'] = $cust_id;
    //         }
    //         if (!empty($this->input->post('coin_filter')) || !empty($this->input->post('date_filter')) || !empty($this->input->post('type_filter'))) {
    //             $filter_data = $this->input->post();
    //         }
    //         if (!empty($filter_data)) {
    //             $date_filter = $filter_data['date_filter'];
    //             $date_arr = explode('-', $date_filter);
    //             if (!empty($date_arr)) {
    //                 $start_date = $date_arr[0];
    //                 $end_date = $date_arr[1];
    //                 $start_date = date('Y-m-d', strtotime($start_date)) . " 00:00:00";
    //                 $end_date = date('Y-m-d', strtotime($end_date)) . " 23:59:59";
    //             }
    //             $data_sess['filter_data']['coin_filter'] = $filter_data['coin_filter'];
    //             $data_sess['filter_data']['type_filter'] = $filter_data['type_filter'];
    //             $data_sess['filter_data']['start_date'] = $start_date;
    //             $data_sess['filter_data']['end_date'] = $end_date;
    //         }
    //         $this->session->set_userdata($data_sess);
    //     }

    //     ////////////////////////////////Pagination Code///////////////////////////////////////////////
    //     $this->load->library("pagination");
    //     $resultsArrAll = $this->mod_report->count_all();
    //     $count = $resultsArrAll['count'];

    //     if ($_SERVER['REMOTE_ADDR'] == '101.50.127.131') {
    //         //echo "<pre>";   print_r($resultsArrAll); exit;
    //     }

    //     $config = array();
    //     $config["base_url"] = SURL . "admin/reports/get_report";
    //     $config["total_rows"] = $count;
    //     $config['per_page'] = 10;
    //     $config['num_links'] = 3;
    //     $config['use_page_numbers'] = TRUE;
    //     $config['uri_segment'] = 4;
    //     $config['reuse_query_string'] = TRUE;
    //     $config["first_tag_open"] = '<li>';
    //     $config["first_tag_close"] = '</li>';
    //     $config["last_tag_open"] = '<li>';
    //     $config["last_tag_close"] = '</li>';
    //     $config['next_link'] = '&raquo;';
    //     $config['next_tag_open'] = '<li>';
    //     $config['next_tag_close'] = '</li>';
    //     $config['prev_link'] = '&laquo;';
    //     $config['prev_tag_open'] = '<li>';
    //     $config['prev_tag_close'] = '</li>';
    //     $config['first_link'] = 'First';
    //     $config['last_link'] = 'Last';
    //     $config['full_tag_open'] = '<ul class="pagination">';
    //     $config['full_tag_close'] = '</ul>';
    //     $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
    //     $config['cur_tag_close'] = '</b></a></li>';
    //     $config['num_tag_open'] = '<li>';
    //     $config['num_tag_close'] = '</li>';
    //     $this->pagination->initialize($config);
    //     $page = $this->uri->segment(4);
    //     if (!isset($page)) {$page = 1;}
    //     $start = ($page - 1) * $config["per_page"];
    //     ////////////////////////////End Pagination Code///////////////////////////////////////////////
    //     $order_arr = $this->mod_report->get_user_orders($start, $config["per_page"]);

    //     $page_links = $this->pagination->create_links();
    //     $customer = $this->mod_report->get_customer();
    //     $coins = $this->mod_coins->get_all_coins();
    //     // Data To be send
    //     $market_sold_price_avg = $resultsArrAll['market_sold_price_avg'];
    //     $current_order_price_avg = $resultsArrAll['current_order_price_avg'];
    //     $avg_profit = $resultsArrAll['avg_profit'];
    //     $ErrorInOrder = $resultsArrAll['count'];
    //     $data['market_sold_price_avg'] = $market_sold_price_avg;
    //     $data['current_order_price_avg'] = $current_order_price_avg;
    //     $data['quantity_avg'] = $quantity_avg;
    //     $data['avg_profit'] = $avg_profit;

    //     $data['orders'] = $order_arr['fullarray'];
    //     $data['totalaverage'] = $totalaverage;
    //     $data['customer'] = $customer;
    //     $data['coins'] = $coins;
    //     $data['count'] = $count;
    //     $data['error'] = $ErrorInOrder;
    //     $data['page_links'] = $page_links;

    //     $this->stencil->paint('admin/reports/report', $data);

    // }

    // public function reset_filters($type) {

    //     $this->session->unset_userdata('filter_data');

    //     redirect(base_url() . 'admin/reports/get_report');

    // } //End reset_buy_filters

    // public function array2csv($array) {

    //     if (count($array) == 0) {

    //         return null;

    //     }

    //     ob_start();

    //     $df = fopen("php://output", 'w');

    //     fputcsv($df, array_keys((array) reset($array)));

    //     foreach ($array as $row) {

    //         fputcsv($df, (array) $row);

    //     }

    //     fclose($df);

    //     return ob_get_clean();

    // }

    // public function download_send_headers($filename) {

    //     // disable caching

    //     $now = gmdate("D, d M Y H:i:s");

    //     header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");

    //     header("Last-Modified: {$now} GMT");

    //     header("Content-type: application/csv");

    //     header("Pragma: no-cache");

    //     header("Expires: 0");

    //     // force download

    //     header("Content-Type: application/force-download");

    //     header("Content-Type: application/octet-stream");

    //     header("Content-Type: application/download");

    //     // disposition / encoding on response body

    //     header("Content-Disposition: attachment;filename={$filename}");

    //     header("Content-Transfer-Encoding: binary");

    // }

    // public function download_csv_trades() {
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();

    //     $timezone = $this->session->userdata('timezone');

    //     $time = $this->input->post('date');

    //     $coin_symbol = $this->input->post('coin');

    //     $time_arr = explode('to', $time);

    //     $s_date = $time_arr[0];

    //     $e_date = $time_arr[1];

    //     $s_dt = new DateTime($s_date, new DateTimeZone($timezone));

    //     $e_dt = new DateTime($e_date, new DateTimeZone($timezone));

    //     $s_dt->setTimezone(new DateTimeZone('UTC'));

    //     $e_dt->setTimezone(new DateTimeZone('UTC'));

    //     // format the datetime

    //     $s_time1 = $s_dt->format('Y-m-d H:i:s');

    //     $e_time1 = $e_dt->format('Y-m-d H:i:s');

    //     $start_time = date("Y-m-d H:i:00", strtotime($s_time1));

    //     $end_time = date("Y-m-d H:i:59", strtotime($e_time1));

    //     $array = $this->mod_report->get_trade_history($coin_symbol, $start_time, $end_time);

    //     $this->download_send_headers("trade_history_" . date("Y-m-d_ Gisa") . ".csv");

    //     echo $this->array2csv($array);

    //     exit;

    // }

    // public function download_csv_prices() {
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();

    //     $timezone = $this->session->userdata('timezone');

    //     $time = $this->input->post('date');

    //     $coin_symbol = $this->input->post('coin');

    //     $time_arr = explode('to', $time);

    //     $s_date = $time_arr[0];

    //     $e_date = $time_arr[1];

    //     $s_dt = new DateTime($s_date, new DateTimeZone($timezone));

    //     $e_dt = new DateTime($e_date, new DateTimeZone($timezone));

    //     $s_dt->setTimezone(new DateTimeZone('UTC'));

    //     $e_dt->setTimezone(new DateTimeZone('UTC'));

    //     // format the datetime

    //     $s_time1 = $s_dt->format('Y-m-d H:i:s');

    //     $e_time1 = $e_dt->format('Y-m-d H:i:s');

    //     $start_time = date("Y-m-d H:i:00", strtotime($s_time1));

    //     $end_time = date("Y-m-d H:i:59", strtotime($e_time1));

    //     $array = $this->mod_report->get_price_history($coin_symbol, $start_time, $end_time);

    //     $this->download_send_headers("prices_history_" . date("Y-m-d_ Gisa") . ".csv");

    //     echo $this->array2csv($array);

    //     exit;

    // }

    // public function order_history_log() {
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();

    //     $timezone = $this->session->userdata('timezone');

    //     $time = $this->input->post('date');

    //     $order_id = $this->input->post('order_id');

    //     $s_date = date('Y-m-d H:00:00', strtotime($time));

    //     $e_date = date('Y-m-d H:59:59', strtotime($time));

    //     $s_dt = new DateTime($s_date, new DateTimeZone($timezone));

    //     $e_dt = new DateTime($e_date, new DateTimeZone($timezone));

    //     $s_dt->setTimezone(new DateTimeZone('UTC'));

    //     $e_dt->setTimezone(new DateTimeZone('UTC'));

    //     // format the datetime

    //     $s_time1 = $s_dt->format('Y-m-d H:i:s');

    //     $e_time1 = $e_dt->format('Y-m-d H:i:s');

    //     $start_time = date("Y-m-d H:i:00", strtotime($s_time1));

    //     $end_time = date("Y-m-d H:i:59", strtotime($e_time1));

    //     $array = $this->mod_report->get_order_log($order_id, $start_time, $end_time);

    //     $data['log'] = $array;

    //     $this->stencil->paint('admin/reports/order_report', $data);

    // }

    // public function barrier_listing() {
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();

    //     $error = array();
    //     if (!empty($this->input->post())) {
    //         if (!empty($this->input->post('status')) || !empty($this->input->post('filter_coin')) || !empty($this->input->post('global_swing_parent_status')) || !empty($this->input->post('start_date')) || !empty($this->input->post('end_date')) || !empty($this->input->post('barrier_type')) || !empty($this->input->post('breakable'))) {
    //             $filter_data = $this->input->post();
    //         }
    //         if (!empty($filter_data)) {

    //             $data_sess['filter_data']['status'] = $this->input->post('status');
    //             $data_sess['filter_data']['filter_coin'] = $this->input->post('filter_coin');
    //             $data_sess['filter_data']['global_swing_parent_status'] = $this->input->post('global_swing_parent_status');
    //             $data_sess['filter_data']['start_date'] = $this->input->post('start_date');
    //             $data_sess['filter_data']['end_date'] = $this->input->post('end_date');
    //             $data_sess['filter_data']['barrier_type'] = $this->input->post('barrier_type');
    //             $data_sess['filter_data']['breakable'] = $this->input->post('breakable');
    //         }

    //         $this->session->set_userdata($data_sess);
    //     }
    //     //Pagination Code//
    //     $this->load->library("pagination");
    //     $countBarrierListing = $this->mod_dashboard->countBarrierListing();
    //     $count = $countBarrierListing;

    //     $config = array();
    //     $config["base_url"] = SURL . "admin/reports/barrier-listing";
    //     $config["total_rows"] = $count;
    //     $config['per_page'] = 20;
    //     $config['num_links'] = 5;
    //     $config['use_page_numbers'] = TRUE;
    //     $config['uri_segment'] = 4;
    //     $config['reuse_query_string'] = TRUE;
    //     $config["first_tag_open"] = '<li>';
    //     $config["first_tag_close"] = '</li>';
    //     $config["last_tag_open"] = '<li>';
    //     $config["last_tag_close"] = '</li>';
    //     $config['next_link'] = '&raquo;';
    //     $config['next_tag_open'] = '<li>';
    //     $config['next_tag_close'] = '</li>';
    //     $config['prev_link'] = '&laquo;';
    //     $config['prev_tag_open'] = '<li>';
    //     $config['prev_tag_close'] = '</li>';
    //     $config['first_link'] = 'First';
    //     $config['last_link'] = 'Last';
    //     $config['full_tag_open'] = '<ul class="pagination">';
    //     $config['full_tag_close'] = '</ul>';
    //     $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
    //     $config['cur_tag_close'] = '</b></a></li>';
    //     $config['num_tag_open'] = '<li>';
    //     $config['num_tag_close'] = '</li>';
    //     $this->pagination->initialize($config);
    //     $page = $this->uri->segment(4);
    //     if (!isset($page)) {$page = 1;}
    //     $start = ($page - 1) * $config["per_page"];
    //     ////////////////////////////End Pagination Code///////////////////////////////////////////////
    //     $barrierListing_arr = $this->mod_dashboard->barrierListing($start, $config["per_page"]);
    //     $page_links = $this->pagination->create_links();
    //     $data['page_links'] = $page_links;
    //     $data['barrier_arr'] = $barrierListing_arr['finalArray'];
    //     $data['coins'] = $this->mod_coins->get_all_coins();
    //     //  Pagiantion code goes end here

    //     /*$coin = $this->session->userdata('global_symbol');
    //     $search_arr['coin'] = $coin;
    //     $this->mongo_db->where($search_arr);
    //     $this->mongo_db->limit(20);

    //     $this->mongo_db->order_by(array('created_date' => -1));
    //     $depth_responseArr = $this->mongo_db->get('barrier_values_collection');

    //     $arr = iterator_to_array($depth_responseArr);
    //     $data['barrier_arr'] = $arr;

    //      */

    //     //echo "<pre>";   print_r($data['coins'] ); exit;

    //     $this->stencil->paint('admin/barrier/listing', $data);
    // }

    // public function edit_barrier() {
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();

    //     $search_arr['_id'] = $this->input->post('id');
    //     $this->mongo_db->where($search_arr);
    //     $depth_responseArr = $this->mongo_db->get('barrier_values_collection');
    //     $arr = iterator_to_array($depth_responseArr);
    //     $response = '';

    //     $response .= '
	// 	<form class="form-horizontal" id="edit_form" method="POST" action="' . SURL . 'admin/reports/edit_barrier_action">
	// 	  <div class="form-group">
	// 	    <label class="control-label col-sm-2" for="barrier_val">Barrier Value:</label>
	// 	    <div class="col-sm-10">
	// 	      <input type="hidden" class="form-control" name="barrier_id" id="barrier_id" value="' . $arr[0]['_id'] . '">
	// 	      <input type="text" class="form-control" name="barrier_val" id="barrier_val" value="' . num($arr[0]['barier_value']) . '">
	// 	    </div>
	// 	  </div>
	// 	</form>';

    //     echo $response;
    //     exit;

    // }

    // public function edit_barrier_action() {
    //     $barrier_val = $this->input->post('barrier_val');
    //     $barrier_id = $this->input->post('barrier_id');

    //     $upd_arr = array('barier_value' => (float) $barrier_val);
    //     $this->mongo_db->where(array('_id' => $barrier_id));
    //     $this->mongo_db->set($upd_arr);
    //     $upd = $this->mongo_db->update('barrier_values_collection');
    //     if ($upd) {

    //         $this->session->set_flashdata('ok_message', 'Barrier Updated successfully.');
    //     } else {

    //         $this->session->set_flashdata('err_message', 'Something went wrong, please try again.');

    //     } //end if
    //     redirect($_SERVER['HTTP_REFERER']);

    // }

    // public function add_barrier_action() {
    //     $coin_symbol = $this->input->post('coin_type');
    //     $created_date = date('Y-m-d H:i:s');
    //     $barrier_val = $this->input->post('barrier_val');
    //     $barrier_id = $this->input->post('barrier_type');

    //     $upd_arr = array('coin' => $coin_symbol, 'barier_value' => (float) $barrier_val, 'barrier_type' => $barrier_id, 'created_date' => $this->mongo_db->converToMongodttime($created_date), 'human_readible_created_date' => $created_date);
    //     $ins = $this->mongo_db->insert('barrier_values_collection', $upd_arr);
    //     if ($ins) {

    //         $this->session->set_flashdata('ok_message', 'Barrier Inserted successfully.');
    //     } else {

    //         $this->session->set_flashdata('err_message', 'Something went wrong, please try again.');

    //     } //end if
    //     redirect($_SERVER['HTTP_REFERER']);

    // }

    // public function delete_barrier($id) {

    //     $this->mongo_db->where(array('_id' => $this->mongo_db->mongoId($id)));
    //     $del = $this->mongo_db->delete('barrier_values_collection');
    //     $this->mongo_db->where(array('barrier_id' => $this->mongo_db->mongoId($id)));
    //     $del2 = $this->mongo_db->delete('barrier_test_collection');
    //     if ($del) {

    //         $this->session->set_flashdata('ok_message', 'Barrier Deleted successfully.');
    //     } else {

    //         $this->session->set_flashdata('err_message', 'Something went wrong, please try again.');

    //     } //end if
    //     redirect($_SERVER['HTTP_REFERER']);

    // }

    // public function show_barrier($barrier_id = '') {
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();

    //     $this->mongo_db->where(array('barrier_id' => $this->mongo_db->mongoId($barrier_id)));
    //     $del = $this->mongo_db->get('barrier_test_collection');

    //     $ret_arr = iterator_to_array($del);

    //     foreach ($ret_arr as $key => $value) {
    //         $returArr['barrier_value'] = num($value['barrier_value']);
    //         $returArr['barrier_type'] = $value['barrier_type'];
    //         $returArr['barrier_creation_time'] = $value['barrier_creation_time'];
    //         $returArr['barrier_quantity'] = number_format_short($value['barrier_quantity']);
    //         $returArr['market_value_time'] = $value['market_value_time'];
    //         $returArr['black_wall_pressure'] = $value['black_wall_pressure'];
    //         $returArr['yellow_wall_pressure'] = $value['yellow_wall_pressure'];
    //         $returArr['depth_pressure'] = $value['depth_pressure'];
    //         $returArr['bid_contracts'] = number_format_short($value['bid_contracts']);
    //         $returArr['bid_percentage'] = $value['bid_percentage'];
    //         $returArr['ask_contract'] = number_format_short($value['ask_contract']);
    //         $returArr['ask_percentage'] = $value['ask_percentage'];
    //         if ($value['updated_profit'] == null || $value['updated_loss'] == null) {
    //             $returArr['profit'] = 0;
    //             $returArr['loss'] = 0;
    //         } else {
    //             $returArr['profit'] = $value['updated_profit'];
    //             $returArr['loss'] = $value['updated_loss'];
    //         }
    //         $returArr['great_wall_quantity'] = number_format_short($value['great_wall_quantity']);
    //         $returArr['great_wall'] = $value['great_wall'];
    //         $returArr['seven_level_depth'] = $value['seven_level_depth'];

    //         $returArr['score'] = $value['score'];
    //         $returArr['last_qty_buy_vs_sell'] = $value['last_qty_buy_vs_sell'];
    //         $returArr['last_qty_time_ago'] = (int) filter_var($value['last_qty_time_ago'], FILTER_SANITIZE_NUMBER_INT);
    //         //..(int) filter_var($str, FILTER_SANITIZE_NUMBER_INT)

    //         $returArr['last_200_buy_vs_sell'] = $value['last_200_buy_vs_sell'];
    //         $returArr['last_200_time_ago'] = (int) filter_var($value['last_200_time_ago'], FILTER_SANITIZE_NUMBER_INT);
    //     }
    //     $data['down_indicators'] = $returArr;

    //     $this->stencil->paint('admin/barrier/listing_indicator', $data);

    // }

    // public function indicator_listing() {
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();

    //     /////////////////////////////////////////////////////////////

    //     if (!empty($this->input->post("coin_symbol"))) {
    //         $coin_symbol = $this->input->post("coin_symbol");
    //     } else {
    //         $coin_symbol = "NCASHBTC";
    //     }

    //     if (!empty($this->input->post("breakable_barrier"))) {
    //         $breakable_barrier = $this->input->post("breakable_barrier");
    //         $search_arr['breakable'] = $breakable_barrier;
    //     }

    //     if (!empty($this->input->post("barrier_swing"))) {
    //         $barrier_swing = $this->input->post("barrier_swing");
    //         $search_arr['global_swing_parent_status'] = $barrier_swing;
    //     } else {
    //         $barrier_swing = '';
    //     }

    //     if (!empty($this->input->post("filter_time"))) {
    //         $filter_time = $this->input->post("filter_time");

    //     } else {
    //         $filter_time = '-7 days';
    //     }

    //     if (!empty($this->input->post("barrier_status"))) {
    //         $barrier_status = $this->input->post("barrier_status");

    //     } else {
    //         $barrier_status = 'very_strong_barrier';
    //     }

    //     $data['coin'] = $coin_symbol;
    //     $data['barrier_type'] = $barrier_type;
    //     $data['barrier_swing'] = $barrier_swing;
    //     $data['break_barrier'] = $breakable_barrier;
    //     $data['barrier_status'] = $barrier_status;
    //     $data['filter_time'] = $filter_time;
    //     $contract_quantity = $this->mod_coins->get_coin_contract_size($coin_symbol);
    //     ////////////////////////////////////////////////////////////
    //     $barrier_type = "up";
    //     $search_arr['coin'] = $coin_symbol;
    //     $search_arr['barrier_type'] = $barrier_type;
    //     $search_arr['barrier_status'] = $barrier_status;

    //     $datetime = date("Y-m-d H:i:s", strtotime($filter_time));

    //     $search_arr['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($datetime));

    //     $this->mongo_db->where($search_arr);
    //     $get = $this->mongo_db->get('barrier_values_collection');
    //     $pre_res = iterator_to_array($get);
    //     $up_breakable = 0;
    //     $up_non_breakable = 0;
    //     foreach ($pre_res as $key => $value) {
    //         $created_date = $value['created_date'];
    //         $barrier_value = $value['barier_value'];
    //         $barrier_id = $value['_id'];

    //         $new_Date = $created_date->toDateTime()->format("Y-m-d H:i:s");
    //         $search_arr2['barrier_id'] = $barrier_id;
    //         $search_arr2['coin'] = $coin_symbol;
    //         //$search_arr2['created_date'] = $created_date;

    //         $this->mongo_db->where($search_arr2);
    //         $this->mongo_db->limit(1);
    //         $gets = $this->mongo_db->get('barrier_test_collection');
    //         $coin_meta = iterator_to_array($gets);

    //         $this->mongo_db->where($search_arr2);
    //         $this->mongo_db->limit(1);
    //         $gets = $this->mongo_db->get('barrier_test_collection');
    //         $coin_meta = iterator_to_array($gets);

    //         if (!empty($coin_meta)) {
    //             $res['ups'][] = array(
    //                 'coin' => $coin_symbol,
    //                 'barrier_value' => $barrier_value,
    //                 'barrier_creation_time' => $new_Date222,
    //                 'market_value_time' => $new_Date,
    //                 'quantity' => intval($coin_meta[0]['barrier_quantity']),
    //                 'black_wall_pressure' => intval($coin_meta[0]['black_wall_pressure']),
    //                 'yellow_wall_pressure' => intval($coin_meta[0]['yellow_wall_pressure']),
    //                 'depth_pressure' => intval($coin_meta[0]['depth_pressure']),
    //                 'bid_contracts' => intval($coin_meta[0]['bid_contracts']),
    //                 'bid_percentage' => intval($coin_meta[0]['bid_percentage']),
    //                 'ask_contract' => floatval($coin_meta[0]['ask_contract']),
    //                 'ask_percentage' => floatval($coin_meta[0]['ask_percentage']),
    //                 'buyers' => intval($coin_meta[0]['buyers']),

    //                 'sellers' => intval($coin_meta[0]['sellers']),

    //                 'buyers_percentage' => floatval($coin_meta[0]['buyers_percentage']),

    //                 'sellers_percentage' => floatval($coin_meta[0]['sellers_percentage']),

    //                 'sellers_buyers_per' => floatval($coin_meta[0]['sellers_buyers_per']),

    //                 'trade_type' => $coin_meta['trade_type'],
    //                 'great_wall_quantity' => intval($coin_meta[0]['great_wall_quantity']),
    //                 'great_wall' => $coin_meta[0]['great_wall'],
    //                 'seven_level_depth' => floatval($coin_meta[0]['seven_level_depth']),
    //                 'score' => $coin_meta[0]['score'],
    //                 'last_qty_buy_vs_sell' => $coin_meta[0]['last_qty_buy_vs_sell'],
    //                 'last_qty_time_ago' => (int) filter_var($coin_meta[0]['last_qty_time_ago'], FILTER_SANITIZE_NUMBER_INT),
    //                 'last_200_buy_vs_sell' => $coin_meta[0]['last_200_buy_vs_sell'],
    //                 'last_200_time_ago' => (int) filter_var($coin_meta[0]['last_200_time_ago'], FILTER_SANITIZE_NUMBER_INT),

    //             );

    //             if ($coin_meta[0]['breakable'] == 'breakable') {
    //                 $up_breakable++;
    //             }
    //             if ($coin_meta[0]['breakable'] == 'non_breakable') {
    //                 $up_non_breakable++;
    //             }
    //         }

    //     }

    //     $returnArr = array();

    //     /*=========================Quantity Pressure=====================================*/
    //     $quantity_arr = array_column($res['ups'], 'quantity');
    //     $avg_quantity = array_sum($quantity_arr) / count($quantity_arr);
    //     $max_quantity = max($quantity_arr);
    //     $min_quantity = min($quantity_arr);
    //     $returnArr['ups']['barrier_quantity'] = array(
    //         'avg' => $avg_quantity,
    //         'max' => $max_quantity,
    //         'min' => $min_quantity,
    //     );
    //     /*=======================End Black Wall Pressure===============================*/
    //     /*==============================Black Wall Pressure==========================================*/
    //     $black_wall_array = array_column($res['ups'], 'black_wall_pressure');
    //     $average_black_wall = array_sum($black_wall_array) / count($black_wall_array);
    //     $max_black_wall_pressure = max($black_wall_array);
    //     $min_black_wall_pressure = min($black_wall_array);
    //     $returnArr['ups']['black_wall_pressure'] = array(
    //         'avg' => $average_black_wall,
    //         'max' => $max_black_wall_pressure,
    //         'min' => $min_black_wall_pressure,
    //     );
    //     /*==============================End Black Wall Pressure=======================================*/

    //     /*==============================Yellow Wall Pressure==========================================*/
    //     $yellow_wall_array = array_column($res['ups'], 'yellow_wall_pressure');
    //     $average_yellow_wall = array_sum($yellow_wall_array) / count($yellow_wall_array);
    //     $max_yellow_wall_pressure = max($yellow_wall_array);
    //     $min_yellow_wall_pressure = min($yellow_wall_array);

    //     $returnArr['ups']['yellow_wall_pressure'] = array(

    //         'avg' => $average_yellow_wall,
    //         'max' => $max_yellow_wall_pressure,
    //         'min' => $min_yellow_wall_pressure,
    //     );
    //     /*==============================End Yellow Wall Pressure=======================================*/

    //     /*================================Depth Pressure===============================================*/
    //     $depth_array = array_column($res['ups'], 'depth_pressure');
    //     $average_depth = array_sum($depth_array) / count($depth_array);
    //     $max_depth_pressure = max($depth_array);
    //     $min_depth_pressure = min($depth_array);

    //     $returnArr['ups']['depth_pressure'] = array(
    //         'avg' => $average_depth,
    //         'max' => $max_depth_pressure,
    //         'min' => $min_depth_pressure,
    //     );
    //     /*==============================End Depth Pressure=======================================*/

    //     /*================================Bid Contracts==========================================*/
    //     $bid_contracts_arr = array_column($res['ups'], 'bid_contracts');
    //     $average_bids = array_sum($bid_contracts_arr) / count($bid_contracts_arr);
    //     $max_bids = max($bid_contracts_arr);
    //     $min_bids = min($bid_contracts_arr);

    //     $returnArr['ups']['bid_contracts'] = array(
    //         'avg' => $average_bids,
    //         'max' => $max_bids,
    //         'min' => $min_bids,
    //     );
    //     /*==============================End Bid Contracts========================================*/

    //     /*================================Ask Contracts==========================================*/
    //     $ask_contracts_arr = array_column($res['ups'], 'ask_contract');
    //     $average_asks = array_sum($ask_contracts_arr) / count($ask_contracts_arr);
    //     $max_asks = max($ask_contracts_arr);
    //     $min_asks = min($ask_contracts_arr);

    //     $returnArr['ups']['ask_contract'] = array(
    //         'avg' => $average_asks,
    //         'max' => $max_asks,
    //         'min' => $min_asks,
    //     );
    //     /*==============================End Ask Contracts========================================*/

    //     /*================================Bid Contracts==========================================*/
    //     $bid_percentage_arr = array_column($res['ups'], 'bid_percentage');
    //     $average_bids_per = array_sum($bid_percentage_arr) / count($bid_percentage_arr);
    //     $max_bids_per = max($bid_percentage_arr);
    //     $min_bids_per = min($bid_percentage_arr);
    //     $returnArr['ups']['bid_percentage'] = array(
    //         'avg' => $average_bids_per,
    //         'max' => $max_bids_per,
    //         'min' => $min_bids_per,
    //     );
    //     /*==============================End Bid Contracts========================================*/

    //     /*================================Ask Contracts==========================================*/
    //     $ask_percentage_arr = array_column($res['ups'], 'ask_percentage');
    //     $average_asks_per = array_sum($ask_percentage_arr) / count($ask_percentage_arr);
    //     $max_asks_per = max($ask_percentage_arr);
    //     $min_asks_per = min($ask_percentage_arr);

    //     $returnArr['ups']['ask_percentage'] = array(
    //         'avg' => $average_asks_per,
    //         'max' => $max_asks_per,
    //         'min' => $min_asks_per,
    //     );
    //     /*==============================End Ask Contracts========================================*/

    //     /*================================Buyers==========================================*/
    //     $buyers_arr = array_column($res['ups'], 'buyers');
    //     $average_asks_per = array_sum($buyers_arr) / count($buyers_arr);
    //     $max_asks_per = max($buyers_arr);
    //     $min_asks_per = min($buyers_arr);

    //     $returnArr['ups']['buyers'] = array(
    //         'avg' => $average_asks_per,
    //         'max' => $max_asks_per,
    //         'min' => $min_asks_per,
    //     );
    //     /*==============================End Buyers========================================*/

    //     /*================================Sellers==========================================*/
    //     $seller_arr = array_column($res['ups'], 'sellers');
    //     $average_asks_per = array_sum($seller_arr) / count($seller_arr);
    //     $max_asks_per = max($seller_arr);
    //     $min_asks_per = min($seller_arr);

    //     $returnArr['ups']['sellers'] = array(
    //         'avg' => $average_asks_per,
    //         'max' => $max_asks_per,
    //         'min' => $min_asks_per,
    //     );
    //     /*==============================End Sellers========================================*/

    //     /*================================Sellers==========================================*/
    //     $buyers_percentage_arr = array_column($res['ups'], 'buyers_percentage');
    //     $average_asks_per = array_sum($buyers_percentage_arr) / count($buyers_percentage_arr);
    //     $max_asks_per = max($buyers_percentage_arr);
    //     $min_asks_per = min($buyers_percentage_arr);

    //     $returnArr['ups']['buyers_percentage'] = array(
    //         'avg' => $average_asks_per,
    //         'max' => $max_asks_per,
    //         'min' => $min_asks_per,
    //     );
    //     /*==============================End Sellers========================================*/

    //     /*================================Sellers==========================================*/
    //     $buyers_percentage_arr = array_column($res['ups'], 'sellers_percentage');
    //     $average_asks_per = array_sum($buyers_percentage_arr) / count($buyers_percentage_arr);
    //     $max_asks_per = max($buyers_percentage_arr);
    //     $min_asks_per = min($buyers_percentage_arr);

    //     $returnArr['ups']['sellers_percentage'] = array(
    //         'avg' => $average_asks_per,
    //         'max' => $max_asks_per,
    //         'min' => $min_asks_per,
    //     );
    //     /*==============================End Sellers========================================*/

    //     /*================================Sellers==========================================*/
    //     $sellers_buyers_percentage_arr = array_column($res['ups'], 'sellers_buyers_per');
    //     $average_asks_per = array_sum($sellers_buyers_percentage_arr) / count($sellers_buyers_percentage_arr);
    //     $max_asks_per = max($sellers_buyers_percentage_arr);
    //     $min_asks_per = min($sellers_buyers_percentage_arr);

    //     $returnArr['ups']['sellers_buyers_per'] = array(
    //         'avg' => $average_asks_per,
    //         'max' => $max_asks_per,
    //         'min' => $min_asks_per,
    //     );
    //     /*==============================End Sellers========================================*/

    //     /*================================Great Wall==========================================*/
    //     $great_wall_array = array_column($res['ups'], 'great_wall_quantity');
    //     $great_wall_avg = array_sum($great_wall_array) / count($great_wall_array);
    //     $max_great_wall = max($great_wall_array);
    //     $min_great_wall = min($great_wall_array);

    //     $returnArr['ups']['great_wall'] = array(
    //         'avg' => $great_wall_avg,
    //         'max' => $max_great_wall,
    //         'min' => $min_great_wall,
    //     );
    //     /*==============================End Great Wall========================================*/

    //     /*================================Sevenlevel==========================================*/
    //     $seven_level_array = array_column($res['ups'], 'seven_level_depth');
    //     $seven_level_avg = array_sum($seven_level_array) / count($seven_level_array);
    //     $max_seven_level = max($seven_level_array);
    //     $min_seven_level = min($seven_level_array);

    //     $returnArr['ups']['seven_level_depth'] = array(
    //         'avg' => $seven_level_avg,
    //         'max' => $max_seven_level,
    //         'min' => $min_seven_level,
    //     );

    //     /*==============================End Sevenlevel========================================*/

    //     /*=========================last_qty_buy_vs_sell====================================*/
    //     $last_qty_buy_vs_sell_arr = array_column($res['ups'], 'last_qty_buy_vs_sell');
    //     $avg_last_qty_buy_vs_sell = array_sum($last_qty_buy_vs_sell_arr) / count($last_qty_buy_vs_sell_arr);
    //     $max_last_qty_buy_vs_sell = max($last_qty_buy_vs_sell_arr);
    //     $min_last_qty_buy_vs_sell = min($last_qty_buy_vs_sell_arr);
    //     $returnArr['ups']['last_qty_buy_vs_sell (' . number_format_short($contract_quantity) . ')'] = array(
    //         'avg' => $avg_last_qty_buy_vs_sell,
    //         'max' => $max_last_qty_buy_vs_sell,
    //         'min' => $min_last_qty_buy_vs_sell,
    //     );
    //     /*=======================End last_qty_buy_vs_sell===============================*/

    //     /*=========================last_qty_time_ago====================================*/
    //     $last_qty_time_ago_arr = array_column($res['ups'], 'last_qty_time_ago');
    //     $avg_last_qty_time_ago = array_sum($last_qty_time_ago_arr) / count($last_qty_time_ago_arr);
    //     $max_last_qty_time_ago = max($last_qty_time_ago_arr);
    //     $min_last_qty_time_ago = min($last_qty_time_ago_arr);
    //     $returnArr['ups']['last_qty_time_ago (' . number_format_short($contract_quantity) . ')'] = array(
    //         'avg' => $avg_last_qty_time_ago,
    //         'max' => $max_last_qty_time_ago,
    //         'min' => $min_last_qty_time_ago,
    //     );
    //     /*=======================End last_qty_time_ago===============================*/

    //     /*=========================last_200_buy_vs_sell====================================*/
    //     $last_200_buy_vs_sell_arr = array_column($res['ups'], 'last_200_buy_vs_sell');
    //     $avg_last_200_buy_vs_sell = array_sum($last_200_buy_vs_sell_arr) / count($last_200_buy_vs_sell_arr);
    //     $max_last_200_buy_vs_sell = max($last_200_buy_vs_sell_arr);
    //     $min_last_200_buy_vs_sell = min($last_200_buy_vs_sell_arr);
    //     $returnArr['ups']['last_200_buy_vs_sell'] = array(
    //         'avg' => $avg_last_200_buy_vs_sell,
    //         'max' => $max_last_200_buy_vs_sell,
    //         'min' => $min_last_200_buy_vs_sell,
    //     );
    //     /*=======================End last_200_buy_vs_sell===============================*/

    //     /*=========================last_200_time_ago====================================*/
    //     $last_200_time_ago_arr = array_column($res['ups'], 'last_200_time_ago');
    //     $avg_last_200_time_ago = array_sum($last_200_time_ago_arr) / count($last_200_time_ago_arr);
    //     $max_last_200_time_ago = max($last_200_time_ago_arr);
    //     $min_last_200_time_ago = min($last_200_time_ago_arr);
    //     $returnArr['ups']['last_200_time_ago'] = array(
    //         'avg' => $avg_last_200_time_ago,
    //         'max' => $max_last_200_time_ago,
    //         'min' => $min_last_200_time_ago,
    //     );
    //     /*=======================End last_200_time_ago===============================*/

    //     //=========================================Downs=======================================

    //     $search_arr = array();
    //     $barrier_type = "down";
    //     $search_arr['coin'] = $coin_symbol;
    //     $search_arr['barrier_type'] = $barrier_type;
    //     $search_arr['barrier_status'] = $barrier_status;
    //     if (isset($barrier_swing) && $barrier_swing != '') {
    //         $search_arr['global_swing_parent_status'] = $barrier_swing;
    //     }
    //     if (isset($breakable_barrier) && $breakable_barrier != '') {
    //         $search_arr['breakable'] = $breakable_barrier;
    //     }
    //     $datetime = date("Y-m-d H:i:s", strtotime($filter_time));

    //     $search_arr['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($datetime));

    //     $this->mongo_db->where($search_arr);
    //     $get = $this->mongo_db->get('barrier_values_collection');
    //     $pre_res2 = iterator_to_array($get);
    //     $down_breakable = 0;
    //     $down_non_breakable = 0;
    //     foreach ($pre_res2 as $key => $value) {
    //         $created_date = $value['created_date'];
    //         $barrier_value = $value['barier_value'];
    //         $barrier_id = $value['_id'];

    //         $search_arr2['barrier_id'] = $barrier_id;
    //         $search_arr2['coin'] = $coin_symbol;
    //         //$search_arr2['created_date'] = $created_date;

    //         $this->mongo_db->where($search_arr2);
    //         $this->mongo_db->limit(1);
    //         $gets = $this->mongo_db->get('barrier_test_collection');
    //         $coin_meta = iterator_to_array($gets);

    //         if (!empty($coin_meta)) {
    //             $res['downs'][] = array(
    //                 'coin' => $coin_symbol,
    //                 'barrier_value' => $barrier_value,
    //                 'barrier_creation_time' => $new_Date222,
    //                 'market_value_time' => $new_Date,
    //                 'quantity' => intval($coin_meta[0]['barrier_quantity']),
    //                 'black_wall_pressure' => intval($coin_meta[0]['black_wall_pressure']),
    //                 'yellow_wall_pressure' => intval($coin_meta[0]['yellow_wall_pressure']),
    //                 'depth_pressure' => intval($coin_meta[0]['depth_pressure']),
    //                 'bid_contracts' => intval($coin_meta[0]['bid_contracts']),
    //                 'bid_percentage' => intval($coin_meta[0]['bid_percentage']),
    //                 'ask_contract' => floatval($coin_meta[0]['ask_contract']),
    //                 'ask_percentage' => floatval($coin_meta[0]['ask_percentage']),
    //                 'buyers' => intval($coin_meta[0]['buyers']),

    //                 'sellers' => intval($coin_meta[0]['sellers']),

    //                 'buyers_percentage' => floatval($coin_meta[0]['buyers_percentage']),

    //                 'sellers_percentage' => floatval($coin_meta[0]['sellers_percentage']),

    //                 'sellers_buyers_per' => floatval($coin_meta[0]['sellers_buyers_per']),

    //                 'trade_type' => $coin_meta['trade_type'],
    //                 'great_wall_quantity' => intval($coin_meta[0]['great_wall_quantity']),
    //                 'great_wall' => $coin_meta[0]['great_wall'],
    //                 'seven_level_depth' => floatval($coin_meta[0]['seven_level_depth']),
    //                 'profit' => floatval($coin_meta[0]['updated_profit']),
    //                 'loss' => floatval($coin_meta[0]['updated_loss']),

    //                 'score' => $coin_meta[0]['score'],
    //                 'last_qty_buy_vs_sell' => $coin_meta[0]['last_qty_buy_vs_sell'],
    //                 'last_qty_time_ago' => (int) filter_var($coin_meta[0]['last_qty_time_ago'], FILTER_SANITIZE_NUMBER_INT),
    //                 'last_200_buy_vs_sell' => $coin_meta[0]['last_200_buy_vs_sell'],
    //                 'last_200_time_ago' => (int) filter_var($coin_meta[0]['last_200_time_ago'], FILTER_SANITIZE_NUMBER_INT),

    //             );

    //             if ($coin_meta[0]['breakable'] == 'breakable') {
    //                 $down_breakable++;
    //             }
    //             if ($coin_meta[0]['breakable'] == 'non_breakable') {
    //                 $down_non_breakable++;
    //             }

    //         }

    //     }
    //     /*==============================Total Profit ==========================================*/
    //     $profit_arr = array_column($res['downs'], 'profit');
    //     $avg_profit = array_sum($profit_arr) / count($profit_arr);
    //     $max_profit = max($profit_arr);
    //     $min_profit = min($profit_arr);
    //     $profit_loss['profit'] = array(
    //         'avg' => $avg_profit,
    //         'max' => $max_profit,
    //         'min' => $min_profit,
    //     );
    //     /*==============================End Total Profit=======================================*/
    //     /*==============================Total Loss==========================================*/
    //     $loss_arr = array_column($res['downs'], 'loss');
    //     $avg_loss = array_sum($loss_arr) / count($loss_arr);
    //     $max_loss = max($loss_arr);
    //     $min_loss = min($loss_arr);
    //     $profit_loss['loss'] = array(
    //         'avg' => $avg_loss,
    //         'max' => $max_loss,
    //         'min' => $min_loss,
    //     );
    //     /*==============================End Total Loss=======================================*/

    //     /*==============================Quantity Pressure==========================================*/
    //     $quantity_arr = array_column($res['downs'], 'quantity');
    //     $avg_quantity = array_sum($quantity_arr) / count($quantity_arr);
    //     $max_quantity = max($quantity_arr);
    //     $min_quantity = min($quantity_arr);
    //     $returnArr['downs']['barrier_quantity'] = array(
    //         'avg' => $avg_quantity,
    //         'max' => $max_quantity,
    //         'min' => $min_quantity,
    //     );
    //     /*==============================End Quantity Pressure=======================================*/

    //     /*==============================Black Wall Pressure==========================================*/
    //     $black_wall_array = array_column($res['downs'], 'black_wall_pressure');
    //     $average_black_wall = array_sum($black_wall_array) / count($black_wall_array);
    //     $max_black_wall_pressure = max($black_wall_array);
    //     $min_black_wall_pressure = min($black_wall_array);
    //     $returnArr['downs']['black_wall_pressure'] = array(
    //         'avg' => $average_black_wall,
    //         'max' => $max_black_wall_pressure,
    //         'min' => $min_black_wall_pressure,
    //     );
    //     /*==============================End Black Wall Pressure=======================================*/

    //     /*==============================Yellow Wall Pressure==========================================*/
    //     $yellow_wall_array = array_column($res['downs'], 'yellow_wall_pressure');
    //     $average_yellow_wall = array_sum($yellow_wall_array) / count($yellow_wall_array);
    //     $max_yellow_wall_pressure = max($yellow_wall_array);
    //     $min_yellow_wall_pressure = min($yellow_wall_array);

    //     $returnArr['downs']['yellow_wall_pressure'] = array(

    //         'avg' => $average_yellow_wall,
    //         'max' => $max_yellow_wall_pressure,
    //         'min' => $min_yellow_wall_pressure,
    //     );
    //     /*==============================End Yellow Wall Pressure=======================================*/

    //     /*================================Depth Pressure===============================================*/
    //     $depth_array = array_column($res['downs'], 'depth_pressure');
    //     $average_depth = array_sum($depth_array) / count($depth_array);
    //     $max_depth_pressure = max($depth_array);
    //     $min_depth_pressure = min($depth_array);

    //     $returnArr['downs']['depth_pressure'] = array(
    //         'avg' => $average_depth,
    //         'max' => $max_depth_pressure,
    //         'min' => $min_depth_pressure,
    //     );
    //     /*==============================End Depth Pressure=======================================*/

    //     /*================================Bid Contracts==========================================*/
    //     $bid_contracts_arr = array_column($res['downs'], 'bid_contracts');
    //     $average_bids = array_sum($bid_contracts_arr) / count($bid_contracts_arr);
    //     $max_bids = max($bid_contracts_arr);
    //     $min_bids = min($bid_contracts_arr);

    //     $returnArr['downs']['bid_contracts'] = array(
    //         'avg' => $average_bids,
    //         'max' => $max_bids,
    //         'min' => $min_bids,
    //     );
    //     /*==============================End Bid Contracts========================================*/

    //     /*================================Ask Contracts==========================================*/
    //     $ask_contracts_arr = array_column($res['downs'], 'ask_contract');
    //     $average_asks = array_sum($ask_contracts_arr) / count($ask_contracts_arr);
    //     $max_asks = max($ask_contracts_arr);
    //     $min_asks = min($ask_contracts_arr);

    //     $returnArr['downs']['ask_contract'] = array(
    //         'avg' => $average_asks,
    //         'max' => $max_asks,
    //         'min' => $min_asks,
    //     );
    //     /*==============================End Ask Contracts========================================*/

    //     /*================================Bid Contracts==========================================*/
    //     $bid_percentage_arr = array_column($res['downs'], 'bid_percentage');
    //     $average_bids_per = array_sum($bid_percentage_arr) / count($bid_percentage_arr);
    //     $max_bids_per = max($bid_percentage_arr);
    //     $min_bids_per = min($bid_percentage_arr);
    //     $returnArr['downs']['bid_percentage'] = array(
    //         'avg' => $average_bids_per,
    //         'max' => $max_bids_per,
    //         'min' => $min_bids_per,
    //     );
    //     /*==============================End Bid Contracts========================================*/

    //     /*================================Ask Contracts==========================================*/
    //     $ask_percentage_arr = array_column($res['downs'], 'ask_percentage');
    //     $average_asks_per = array_sum($ask_percentage_arr) / count($ask_percentage_arr);
    //     $max_asks_per = max($ask_percentage_arr);
    //     $min_asks_per = min($ask_percentage_arr);

    //     $returnArr['downs']['ask_percentage'] = array(
    //         'avg' => $average_asks_per,
    //         'max' => $max_asks_per,
    //         'min' => $min_asks_per,
    //     );
    //     /*==============================End Ask Contracts========================================*/

    //     /*================================Buyers==========================================*/
    //     $buyers_arr = array_column($res['downs'], 'buyers');
    //     $average_asks_per = array_sum($buyers_arr) / count($buyers_arr);
    //     $max_asks_per = max($buyers_arr);
    //     $min_asks_per = min($buyers_arr);

    //     $returnArr['downs']['buyers'] = array(
    //         'avg' => $average_asks_per,
    //         'max' => $max_asks_per,
    //         'min' => $min_asks_per,
    //     );
    //     /*==============================End Buyers========================================*/

    //     /*================================Sellers==========================================*/
    //     $seller_arr = array_column($res['downs'], 'sellers');
    //     $average_asks_per = array_sum($seller_arr) / count($seller_arr);
    //     $max_asks_per = max($seller_arr);
    //     $min_asks_per = min($seller_arr);

    //     $returnArr['downs']['sellers'] = array(
    //         'avg' => $average_asks_per,
    //         'max' => $max_asks_per,
    //         'min' => $min_asks_per,
    //     );
    //     /*==============================End Sellers========================================*/

    //     /*================================Sellers==========================================*/
    //     $buyers_percentage_arr = array_column($res['downs'], 'buyers_percentage');
    //     $average_asks_per = array_sum($buyers_percentage_arr) / count($buyers_percentage_arr);
    //     $max_asks_per = max($buyers_percentage_arr);
    //     $min_asks_per = min($buyers_percentage_arr);

    //     $returnArr['downs']['buyers_percentage'] = array(
    //         'avg' => $average_asks_per,
    //         'max' => $max_asks_per,
    //         'min' => $min_asks_per,
    //     );
    //     /*==============================End Sellers========================================*/

    //     /*================================Sellers==========================================*/
    //     $buyers_percentage_arr = array_column($res['downs'], 'sellers_percentage');
    //     $average_asks_per = array_sum($buyers_percentage_arr) / count($buyers_percentage_arr);
    //     $max_asks_per = max($buyers_percentage_arr);
    //     $min_asks_per = min($buyers_percentage_arr);

    //     $returnArr['downs']['sellers_percentage'] = array(
    //         'avg' => $average_asks_per,
    //         'max' => $max_asks_per,
    //         'min' => $min_asks_per,
    //     );
    //     /*==============================End Sellers========================================*/

    //     /*================================Sellers==========================================*/
    //     $sellers_buyers_percentage_arr = array_column($res['downs'], 'sellers_buyers_per');
    //     $average_asks_per = array_sum($sellers_buyers_percentage_arr) / count($sellers_buyers_percentage_arr);
    //     $max_asks_per = max($sellers_buyers_percentage_arr);
    //     $min_asks_per = min($sellers_buyers_percentage_arr);

    //     $returnArr['downs']['sellers_buyers_per'] = array(
    //         'avg' => $average_asks_per,
    //         'max' => $max_asks_per,
    //         'min' => $min_asks_per,
    //     );
    //     /*==============================End Sellers========================================*/

    //     /*================================Great Wall==========================================*/
    //     $great_wall_array = array_column($res['downs'], 'great_wall_quantity');
    //     $great_wall_avg = array_sum($great_wall_array) / count($great_wall_array);
    //     $max_great_wall = max($great_wall_array);
    //     $min_great_wall = min($great_wall_array);

    //     $returnArr['downs']['great_wall'] = array(
    //         'avg' => $great_wall_avg,
    //         'max' => $max_great_wall,
    //         'min' => $min_great_wall,
    //     );
    //     /*==============================End Great Wall========================================*/

    //     /*================================Great Wall==========================================*/
    //     $seven_level_array = array_column($res['downs'], 'seven_level_depth');
    //     $seven_level_avg = array_sum($seven_level_array) / count($seven_level_array);
    //     $max_seven_level = max($seven_level_array);
    //     $min_seven_level = min($seven_level_array);

    //     $returnArr['downs']['seven_level_depth'] = array(
    //         'avg' => $seven_level_avg,
    //         'max' => $max_seven_level,
    //         'min' => $min_seven_level,
    //     );

    //     /*=========================last_qty_buy_vs_sell====================================*/
    //     $last_qty_buy_vs_sell_arr = array_column($res['downs'], 'last_qty_buy_vs_sell');
    //     $avg_last_qty_buy_vs_sell = array_sum($last_qty_buy_vs_sell_arr) / count($last_qty_buy_vs_sell_arr);
    //     $max_last_qty_buy_vs_sell = max($last_qty_buy_vs_sell_arr);
    //     $min_last_qty_buy_vs_sell = min($last_qty_buy_vs_sell_arr);
    //     $returnArr['downs']['last_qty_buy_vs_sell (' . number_format_short($contract_quantity) . ')'] = array(
    //         'avg' => $avg_last_qty_buy_vs_sell,
    //         'max' => $max_last_qty_buy_vs_sell,
    //         'min' => $min_last_qty_buy_vs_sell,
    //     );
    //     /*=======================End last_qty_buy_vs_sell===============================*/

    //     /*=========================last_qty_time_ago====================================*/
    //     $last_qty_time_ago_arr = array_column($res['downs'], 'last_qty_time_ago');
    //     $avg_last_qty_time_ago = array_sum($last_qty_time_ago_arr) / count($last_qty_time_ago_arr);
    //     $max_last_qty_time_ago = max($last_qty_time_ago_arr);
    //     $min_last_qty_time_ago = min($last_qty_time_ago_arr);
    //     $returnArr['downs']['last_qty_time_ago (' . number_format_short($contract_quantity) . ')'] = array(
    //         'avg' => $avg_last_qty_time_ago,
    //         'max' => $max_last_qty_time_ago,
    //         'min' => $min_last_qty_time_ago,
    //     );
    //     /*=======================End last_qty_time_ago===============================*/

    //     /*=========================last_200_buy_vs_sell====================================*/
    //     $last_200_buy_vs_sell_arr = array_column($res['downs'], 'last_200_buy_vs_sell');
    //     $avg_last_200_buy_vs_sell = array_sum($last_200_buy_vs_sell_arr) / count($last_200_buy_vs_sell_arr);
    //     $max_last_200_buy_vs_sell = max($last_200_buy_vs_sell_arr);
    //     $min_last_200_buy_vs_sell = min($last_200_buy_vs_sell_arr);
    //     $returnArr['downs']['last_200_buy_vs_sell'] = array(
    //         'avg' => $avg_last_200_buy_vs_sell,
    //         'max' => $max_last_200_buy_vs_sell,
    //         'min' => $min_last_200_buy_vs_sell,
    //     );
    //     /*=======================End last_200_buy_vs_sell===============================*/

    //     /*=========================last_200_time_ago====================================*/
    //     $last_200_time_ago_arr = array_column($res['downs'], 'last_200_time_ago');
    //     $avg_last_200_time_ago = array_sum($last_200_time_ago_arr) / count($last_200_time_ago_arr);
    //     $max_last_200_time_ago = max($last_200_time_ago_arr);
    //     $min_last_200_time_ago = min($last_200_time_ago_arr);
    //     $returnArr['downs']['last_200_time_ago'] = array(
    //         'avg' => $avg_last_200_time_ago,
    //         'max' => $max_last_200_time_ago,
    //         'min' => $min_last_200_time_ago,
    //     );
    //     /*=======================End last_200_time_ago===============================*/

    //     //////////////////////////////////////////////////////////////////////////////////
    //     /*                    Calculate Up/Down Percentage                                */
    //     //////////////////////////////////////////////////////////////////////////////////
    //     /*        $search_arr3['coin'] = $coin_symbol;
    //     $datetime = date("Y-m-d H:i:s", strtotime("-7 days"));
    //     $search_arr3['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($datetime));
    //     $search_arr3['barrier_type'] = array('$in' => array('up', 'down'));
    //     $this->mongo_db->where($search_arr3);
    //     $this->mongo_db->order_by(array('_id' => 1));
    //     $get3 = $this->mongo_db->get('barrier_values_collection');
    //     $pre_res3 = iterator_to_array($get3);

    //     for ($i = 0; $i < count($pre_res3); $i++) {
    //     $barrier_1 = $pre_res3[$i]['barier_value'];
    //     $barrier_2 = $pre_res3[$i + 1]['barier_value'];
    //     $breakable_barrier = $pre_res3[$i]['breakable'];
    //     if ($breakable_barrier == 'breakable') {
    //     $breakable++;
    //     }
    //     if ($breakable_barrier == 'non_breakable') {
    //     $non_breakable++;
    //     }
    //     $barrier_1_type = $pre_res3[$i]['barrier_type'];
    //     $barrier_2_type = $pre_res3[$i + 1]['barrier_type'];
    //     if ($barrier_1_type != $barrier_2_type && ($i < (count($pre_res3) - 1))) {
    //     $barrier_per[] = number_format(((($barrier_1 - $barrier_2) / $barrier_1) * 100), 2);

    //     }
    //     }
    //      */

    //     // echo "<pre>";
    //     // print_r($returnArr);
    //     // exit;
    //     $data['up_indicators'] = $returnArr['ups'];
    //     $data['down_indicators'] = $returnArr['downs'];
    //     $data['profit'] = $profit_loss['profit'];
    //     $data['loss'] = $profit_loss['loss'];

    //     $data['up_breakable'] = $up_breakable;
    //     $data['up_non_breakable'] = $up_non_breakable;
    //     $data['down_breakable'] = $down_breakable;
    //     $data['down_non_breakable'] = $down_non_breakable;
    //     $data['coins'] = $this->mod_coins->get_all_coins();
    //     $this->stencil->paint('admin/coin_meta/listing_indicator', $data);
    // }
    // public function reset_filters_report($type) {
    //     $this->session->unset_userdata('filter_order_data');
    //     if ($type == 'coin') {
    //         redirect(base_url() . 'admin/reports/coin_report');
    //     }if ($type == 'meta') {
    //         redirect(base_url() . 'admin/reports/meta_coin_report');
    //     }if ($type == 'percentile') {
    //         redirect(base_url() . 'admin/reports/meta_coin_report_percentile');
    //     }
    //     redirect(base_url() . 'admin/reports/order_reports');
    // }

    // public function order_reports() {
    //     //Login Check
    //     // ini_set("display_errors", E_ALL);
    //     // error_reporting(E_ALL);
    //     $this->mod_login->verify_is_admin_login();
    //     if ($this->input->post()) {
    //         $data_arr['filter_order_data'] = $this->input->post();
    //         $this->session->set_userdata($data_arr);
    //     }

    //     $session_data = $this->session->userdata('filter_order_data');
    //     if (isset($session_data)) {

    //         $collection = "buy_orders";
    //         if ($session_data['filter_by_coin']) {
    //             $search['symbol'] = $session_data['filter_by_coin'];
    //         }
    //         if ($session_data['filter_by_mode']) {
    //             $search['application_mode'] = $session_data['filter_by_mode'];
    //         }
    //         if ($session_data['filter_by_trigger']) {
    //             $search['trigger_type'] = $session_data['filter_by_trigger'];
    //         }
    //         if ($session_data['filter_by_rule'] != "") {
    //             $filter_by_rule = $session_data['filter_by_rule'];
    //             //$search['$or'] = array("buy_rule_number" => $filter_by_rule, "sell_rule_number" => $filter_by_rule);
    //             $search['$or'] = array(
    //                 array("buy_rule_number" => intval($filter_by_rule)),
    //                 array("sell_rule_number" => intval($filter_by_rule)),
    //             );

    //         }
    //         if ($session_data['filter_level'] != "") {
    //             $order_level = $session_data['filter_level'];
    //             $search['order_level'] = $order_level;
    //         }
    //         if ($session_data['filter_username'] != "") {
    //             $username = $session_data['filter_username'];
    //             $admin_id = $this->get_admin_id($username);
    //             $search['admin_id'] = (string) $admin_id;
    //         }
    //         if ($session_data['optradio'] != "") {
    //             if ($session_data['optradio'] == 'created_date') {
    //                 $oder_arr['created_date'] = -1;
    //             } elseif ($session_data['optradio'] == 'modified_date') {
    //                 $oder_arr['modified_date'] = -1;
    //             }
    //         }
    //         if ($session_data['filter_by_status'] != "") {
    //             $order_status = $session_data['filter_by_status'];
    //             if ($order_status == 'new') {
    //                 $search['status'] = 'new';
    //             } elseif ($order_status == 'error') {
    //                 $search['status'] = 'error';
    //             } elseif ($order_status == 'open') {
    //                 $search['status'] = array('$in' => array('submitted', 'FILLED'));
    //                 $search['is_sell_order'] = 'yes';
    //             } elseif ($order_status == 'sold') {
    //                 $search['status'] = 'FILLED';
    //                 $search['is_sell_order'] = 'sold';
    //                 $collection = "sold_buy_orders";
    //             }
    //         }
    //         if ($session_data['filter_by_start_date'] != "" && $session_data['filter_by_end_date'] != "") {

    //             $created_datetime = date('Y-m-d G:i:s', strtotime($session_data['filter_by_start_date']));
    //             $orig_date = new DateTime($created_datetime);
    //             $orig_date = $orig_date->getTimestamp();
    //             $start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

    //             $created_datetime22 = date('Y-m-d G:i:s', strtotime($session_data['filter_by_end_date']));
    //             $orig_date22 = new DateTime($created_datetime22);
    //             $orig_date22 = $orig_date22->getTimestamp();
    //             $end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
    //             $search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
    //         }

    //         $search['parent_status'] = array('$ne' => 'parent');
    //         //$search['status'] = array('$ne' => 'canceled');
    //         // echo "<pre>";
    //         // print_r($search);
    //         // exit;

    //         $connetct = $this->mongo_db->customQuery();

    //         $sold1_count = $connetct->sold_buy_orders->count($search);
    //         $pending1_count = $connetct->buy_orders->count($search);

    //         $total1_count = $sold1_count + $pending1_count;

    //         $qr_sold = array('skip' => $skip_sold, 'sort' => array('modified_date' => -1), 'limit' => $limit);
    //         $qr_pending = array('skip' => $skip_pending, 'sort' => array('modified_date' => -1), 'limit' => $limit);

    //         $sold_count = $connetct->sold_buy_orders->count($search, $qr_sold);
    //         $pending_count = $connetct->buy_orders->count($search, $qr_pending);

    //         $total_count = $sold_count + $pending_count;

    //         /////////////////////// PAGINATION CODE START HERE /////////////////////////////////////
    //         $this->load->library("pagination");
    //         $config = array();
    //         $config["base_url"] = SURL . "admin/reports/order_reports";
    //         $config["total_rows"] = $total1_count;
    //         $config['per_page'] = 250;
    //         $config['num_links'] = 3;
    //         $config['use_page_numbers'] = TRUE;
    //         $config['uri_segment'] = 4;
    //         $config['reuse_query_string'] = TRUE;
    //         $config["first_tag_open"] = '<li>';
    //         $config["first_tag_close"] = '</li>';
    //         $config["last_tag_open"] = '<li>';
    //         $config["last_tag_close"] = '</li>';
    //         $config['next_link'] = '&raquo;';
    //         $config['next_tag_open'] = '<li>';
    //         $config['next_tag_close'] = '</li>';
    //         $config['prev_link'] = '&laquo;';
    //         $config['prev_tag_open'] = '<li>';
    //         $config['prev_tag_close'] = '</li>';
    //         $config['first_link'] = 'First';
    //         $config['last_link'] = 'Last';
    //         $config['full_tag_open'] = '<ul class="pagination">';
    //         $config['full_tag_close'] = '</ul>';
    //         $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
    //         $config['cur_tag_close'] = '</b></a></li>';
    //         $config['num_tag_open'] = '<li>';
    //         $config['num_tag_close'] = '</li>';
    //         $this->pagination->initialize($config);
    //         $page = $this->uri->segment(4);

    //         if (!isset($page)) {$page = 1;}
    //         $start = ($page - 1) * $config["per_page"];
    //         $skip = $start;
    //         $skip_sold = $skip;
    //         $skip_pending = $skip;
    //         $limit = $config["per_page"];
    //         ////////////////////////////End Pagination Code///////////////////////////////////////

    //         $data['pagination'] = $this->pagination->create_links();

    //         /////////////////////// PAGINATION CODE END HERE /////////////////////////////////////
    //         $sold_percentage = ($sold_count / $total_count) * 100;
    //         $pending_percentage = ($pending_count / $total_count) * 100;

    //         $pending_limit = (500 / 100) * $pending_percentage;
    //         $sold_limit = (500 / 100) * $sold_percentage;

    //         $pending_options = array('skip' => $skip_pending, 'sort' => array('modified_date' => -1), 'limit' => intval($pending_limit));

    //         $sold_options = array('skip' => $skip_sold, 'sort' => array('modified_date' => -1), 'limit' => intval($sold_limit));

    //         // $skip_sold = $skip_sold +(int)$sold_limit;
    //         // $skip_pending = $skip_pending +(int)$pending_limit;
    //         // $this->session->set_userdata(array('skip_sold'=>$skip_sold,'skip_pending'=>$skip_pending));

    //         $pending_curser = $connetct->buy_orders->find($search, $pending_options);
    //         $sold_curser = $connetct->sold_buy_orders->find($search, $sold_options);

    //         $pending_arr = iterator_to_array($pending_curser);
    //         $sold_arr = iterator_to_array($sold_curser);
    //         $orders = array_merge_recursive($pending_arr, $sold_arr);

    //         foreach ($orders as $key => $part) {
    //             $sort[$key] = (string) $part['modified_date'];
    //         }

    //         array_multisort($sort, SORT_DESC, $orders);

    //         $new_order_arrray = array();
    //         foreach ($orders as $order) {
    //             $id = $order['admin_id'];
    //             $data_user = $this->get_username_from_user($id);
    //             $order['admin'] = $data_user;
    //             $_id = $order['_id'];

    //             $error = $this->get_error_type($_id);
    //             $order['log'] = $error;
    //             array_push($new_order_arrray, $order);
    //         }
    //         // echo "<pre>";
    //         // print_r($new_order_arrray);exit;
    //         // $new_order_arrray['average'] = $test_arr;
    //         $data['orders'] = $new_order_arrray;

    //     }
    //     $coins = $this->mod_coins->get_all_coins();
    //     $data['coins'] = $coins;
    //     $this->stencil->paint('admin/reports/my_custom_order_report', $data);
    // } //End of order_reports

    // // working on order_reports_admin

    // public function order_reports_admin() {

    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();
    //     if ($this->input->post()) {

    //         $data_arr['filter_order_data'] = $this->input->post();
    //         $this->session->set_userdata($data_arr);
    //         $collection = "buy_orders";
    //         if ($this->input->post('filter_by_coin')) {
    //             $search['symbol'] = $this->input->post('filter_by_coin');
    //         }
    //         if ($this->input->post('filter_by_mode')) {
    //             $search['application_mode'] = $this->input->post('filter_by_mode');
    //         }
    //         if ($this->input->post('filter_by_trigger')) {
    //             $search['trigger_type'] = $this->input->post('filter_by_trigger');
    //         }
    //         if ($this->input->post('filter_level') != "") {
    //             $order_level = $this->input->post('filter_level');
    //             $search['order_level'] = $order_level;
    //         }
    //         if ($this->input->post('filter_username') != "") {
    //             $username = $this->input->post('filter_username');
    //             $admin_id = $this->get_admin_id($username);
    //             $search['admin_id'] = (string) $admin_id;
    //         }
    //         if ($this->input->post('optradio') != "") {
    //             if ($this->input->post('optradio') == 'created_date') {
    //                 $oder_arr['created_date'] = -1;
    //             } elseif ($this->input->post('optradio') == 'modified_date') {
    //                 $oder_arr['modified_date'] = -1;
    //             }
    //         }
    //         if ($this->input->post('filter_by_status') != "") {
    //             $order_status = $this->input->post('filter_by_status');
    //             if ($order_status == 'new') {
    //                 $search['status'] = 'new';
    //             } elseif ($order_status == 'error') {
    //                 $search['status'] = 'error';
    //             } elseif ($order_status == 'open') {
    //                 $search['status'] = array('$in' => array('submitted', 'FILLED'));
    //                 $search['is_sell_order'] = 'yes';
    //             } elseif ($order_status == 'sold') {
    //                 $search['status'] = 'FILLED';
    //                 $search['is_sell_order'] = 'sold';
    //                 $collection = "sold_buy_orders";
    //             }
    //         }
    //         if ($_POST['filter_by_start_date'] != "" && $_POST['filter_by_end_date'] != "") {

    //             $created_datetime = date('Y-m-d G:i:s', strtotime($_POST['filter_by_start_date']));
    //             $orig_date = new DateTime($created_datetime);
    //             $orig_date = $orig_date->getTimestamp();
    //             $start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

    //             $created_datetime22 = date('Y-m-d G:i:s', strtotime($_POST['filter_by_end_date']));
    //             $orig_date22 = new DateTime($created_datetime22);
    //             $orig_date22 = $orig_date22->getTimestamp();
    //             $end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
    //             $search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
    //         }

    //         $search['parent_status'] = array('$ne' => 'parent');
    //         //$search['status'] = array('$ne' => 'canceled');

    //         $connetct = $this->mongo_db->customQuery();
    //         $pending_curser = $connetct->buy_orders->find($search);
    //         $sold_curser = $connetct->sold_buy_orders->find($search);

    //         $pending_arr = iterator_to_array($pending_curser);
    //         $sold_arr = iterator_to_array($sold_curser);

    //         $orders = array_merge_recursive($pending_arr, $sold_arr);

    //         foreach ($orders as $key => $part) {
    //             $sort[$key] = (string) $part['modified_date'];
    //         }

    //         array_multisort($sort, SORT_DESC, $orders);

    //         foreach ($orders as $key => $value) {

    //             $total_sold_orders++;
    //             $market_sold_price = $value['market_sold_price'];
    //             $current_order_price = $value['market_value'];
    //             $quantity = $value['quantity'];

    //             $current_data2222 = $market_sold_price - $current_order_price;
    //             $profit_data = ($current_data2222 * 100 / $market_sold_price);

    //             $profit_data = number_format((float) $profit_data, 2, '.', '');
    //             $total_btc = $quantity * (float) $current_order_price;
    //             $total_profit += $total_btc * $profit_data;
    //             $total_quantity += $total_btc;

    //         }
    //         if ($total_quantity == 0) {
    //             $total_quantity = 1;
    //         }
    //         $avg_profit = $total_profit / $total_quantity;

    //         $test_arr['total_sold_orders'] = $total_sold_orders;
    //         $test_arr['avg_profit'] = number_format($avg_profit, 2, '.', '');

    //         $new_order_arrray = array();
    //         foreach ($orders as $order) {
    //             $id = $order['admin_id'];
    //             $data_user = $this->get_username_from_user($id);
    //             $order['admin'] = $data_user;
    //             $_id = $order['_id'];

    //             $error = $this->get_error_type($_id);
    //             $order['log'] = $error;
    //             array_push($new_order_arrray, $order);
    //         }
    //         // echo "<pre>";
    //         // print_r($new_order_arrray);exit;

    //         $order_arr['new_order_arr'] = $new_order_arrray;
    //         $order_arr['average'] = $test_arr;
    //         $data['full_arr'] = $order_arr;

    //     }

    //     $coins = $this->mod_coins->get_all_coins();
    //     $data['coins'] = $coins;

    //     $this->stencil->paint('admin/reports/my_custom_order_report2', $data);

    // }

    // end of order_book_admin

    // public function get_username_from_user($id) {

    //     // echo $id;
    //     // echo "<br>";
    //     if (preg_match('/^[a-f\d]{24}$/i', $id)) {
    //         $customer = $this->mod_report->get_customer($this->mongo_db->mongoId($id));
    //     }
    //     // $customer_name = ucfirst($customer['first_name']).' '.ucfirst($customer['last_name']);
    //     // $customer_username = $customer['username'];

    //     return $customer;

    // }

    // public function get_error_type($id) {
    //     $this->mongo_db->limit(1);
    //     $this->mongo_db->order_by(array('_id' => -1));
    //     $this->mongo_db->where(array('order_id' => $id, 'type' => array('$in' => array('buy_error', 'sell_error'))));
    //     $mongo_obj = $this->mongo_db->get('orders_history_log');
    //     $orders = iterator_to_array($mongo_obj);
    //     return $orders[0];

    // }

    // public function test_error_type($id) {
    //     $this->mongo_db->where(array('order_id' => $id, 'type' => array('$in' => array('buy_error', 'sell_error'))));
    //     $mongo_obj = $this->mongo_db->get('orders_history_log');
    //     $orders = iterator_to_array($mongo_obj);
    //     echo "<pre>";
    //     print_r($orders);exit;

    // }

    // public function get_admin_id($username) {
    //     $customer = $this->mod_report->get_customer_by_username($username);
    //     return $customer['_id'];
    // }

    function get_all_usernames_ajax() {
        $this->mongo_db->sort(array('_id' => -1));
        $get_users = $this->mongo_db->get('users');

        $users_arr = iterator_to_array($get_users);

        $user_name_array = array_column($users_arr, 'username');

        echo json_encode($user_name_array);
        exit;
    }
    public function get_user_info() {
        $id = $this->input->post('user_id');
        $customer = $this->mod_report->get_customer($id);

        $response = '<div class="col-12 col-sm-6 col-md-4 col-lg-12">
						      <div class="our-team">
						        <div class="picture">
						          <img class="img-fluid" src="' . SURL . "assets/profile_images/" . (!empty($customer['profile_image']) ? $customer['profile_image'] : "user.png") . '">
						        </div>
						        <div class="team-content">
						          <h3 class="name">' . ucfirst($customer['first_name']) . ' ' . ucfirst($customer['last_name']) . '</h3>
											<h5><span class="label label-info">@' . $customer['username'] . '</span></h5>
						          <h4 class="title">Last Login: ' . date("jS F Y H:i:s", strtotime($customer['last_login_datetime'])) . '</h4>
						        </div>
						      </div>
						    </div>
								<div class="table-responsive">
									  <table class="table">
											<tr>
												<th>User Id</td>
												<td>' . $customer['_id'] . '</td>
											<tr>

											<tr>
												<th>Email Address</td>
												<td>' . $customer['email_address'] . '</td>
											<tr>

											<tr>
												<th>Trading Ip</td>
												<td>' . $customer['trading_ip'] . '</td>
											<tr>
											<tr>
												<th>Application Mode</td>
												<td>' . $customer['application_mode'] . '</td>
											<tr>
											<tr>
												<th></td>
												<td>' . (($customer['special_role'] == 1) ? "<label class='label label-success'>Special User</label>" : "<label class='label label-warning'>Normal User</label>") . '</td>
											<tr>
									  </table>
									</div>';

        echo $response;
        exit;

    }

    // public function test_run() {
    //     $this_obj = $this->mongo_db->get('users');
    //     $this_arr = iterator_to_array($this_obj);

    //     $count = count($this_arr) / 5;
    //     echo $count;

    //     for ($i = 0; $i <= count($this_arr); $i++) {
    //         $search['_id'] = $this_arr[$i]['_id'];
    //         if (($count * 1) >= $i) {
    //             $upd_arr['trading_ip'] = "50.28.36.48";
    //         } elseif (($count * 2) >= $i) {
    //             $upd_arr['trading_ip'] = "50.28.36.49";
    //         } elseif (($count * 3) >= $i) {
    //             $upd_arr['trading_ip'] = "50.28.36.33";
    //         } elseif (($count * 4) >= $i) {
    //             $upd_arr['trading_ip'] = "50.28.36.34";
    //         } elseif (($count * 5) >= $i) {
    //             $upd_arr['trading_ip'] = "50.28.36.35";
    //         }
    //         echo "<pre>";
    //         print_r($upd_arr);
    //         echo "<br>";
    //         $this->mongo_db->where($search);
    //         $this->mongo_db->set($upd_arr);
    //         $this->mongo_db->update("users");
    //     }
    // }

    // public function get_user_order_history() {
    //     $this->mod_login->verify_is_admin_login();
    //     $this->load->library("binance_api");
    //     if ($this->input->post()) {
    //         $user_id_arr = $this->mod_report->get_customer_by_username($this->input->post("filter_username"));

    //         $user_id = $user_id_arr['_id'];

    //         $symbol = $this->input->post("filter_by_coin");
    //         $data['filter_user_data']['filter_by_coin'] = $symbol;
    //         $data['filter_user_data']['filter_username'] = $this->input->post("filter_username");
    //         $order_history = $this->binance_api->get_all_orders_history($symbol, $user_id);
    //         // echo "<pre>";
    //         // print_r($order_history);exit;
    //         $this->mongo_db->where(array('symbol' => $symbol, 'admin_id' => (string) $user_id));
    //         $get_obj = $this->mongo_db->get('buy_orders');
    //         $buy_orders1 = iterator_to_array($get_obj);

    //         $this->mongo_db->where(array('symbol' => $symbol, 'admin_id' => (string) $user_id));
    //         $get_obj2 = $this->mongo_db->get('sold_buy_orders');
    //         $buy_orders2 = iterator_to_array($get_obj2);

    //         $buy_orders = array_merge_recursive($buy_orders1, $buy_orders2);

    //         $this->mongo_db->where(array('symbol' => $symbol, 'admin_id' => (string) $user_id));
    //         $get_obj22 = $this->mongo_db->get('orders');
    //         $sell_orders = iterator_to_array($get_obj22);
    //         $disp_arr_buy = array();
    //         $disp_arr_sell = array();
    //         $disp_arr = array();
    //         $index = 1;
    //         if ($_GET['testing']) {
    //             echo "<pre>";
    //             print_r($order_history);
    //             exit;
    //         }
    //         foreach ($order_history as $obj) {

    //             $binance_id = $obj['orderId'];
    //             $type = $obj['isBuyer'];
    //             $price = $obj['price'];
    //             $mil = $obj['time'];
    //             $seconds = $mil / 1000;
    //             $time_binance = date("Y-m-d H:i:s", $seconds);

    //             if (!$type) {
    //                 $new_obj_ = array();
    //                 $search = $this->custom_array_search($sell_orders, 'binance_order_id', $binance_id);
    //                 if ($search != '') {
    //                     $new_obj_['id'] = $sell_orders[$search]['_id'];
    //                     $new_obj_['bid'] = $binance_id;
    //                     $new_obj_['price'] = $price;
    //                     $new_obj_['type'] = "Sell";
    //                     $new_obj_['btime'] = $time_binance;
    //                     $new_obj_['status'] = "Found On Digiebot";
    //                     $new_obj_['order_status'] = $sell_orders[$search]['status'];
    //                     $new_obj_['qty'] = $sell_orders[$search]['quantity'];
    //                     $new_obj_['dtime'] = $sell_orders[$search]['modified_date']->toDateTime()->format("Y-m-d H:i:s");
    //                     $new_obj_['bqty'] = $obj['qty'];
    //                     $new_obj_['buy_id'] = $buy_orders[$search]['buy_order_id'];
    //                     $new_obj_['url'] = SURL . "admin/sell_orders/edit-order/" . (string) $sell_orders[$search]['_id'];
    //                     $new_obj_['ID'] = (string) $sell_orders[$search]['_id'];

    //                     array_push($disp_arr_sell, $new_obj_);
    //                 } else {
    //                     $new_obj_['id'] = '';
    //                     $new_obj_['bid'] = $binance_id;
    //                     $new_obj_['type'] = "Sell";
    //                     $new_obj_['price'] = $price;
    //                     $new_obj_['bqty'] = $obj['qty'];
    //                     $new_obj_['btime'] = $time_binance;
    //                     $new_obj_['status'] = "Not Found On Digiebot";
    //                     $new_obj_['url'] = '';
    //                     array_push($disp_arr_sell, $new_obj_);
    //                 }
    //             } else {
    //                 $new_obj = array();
    //                 $search = $this->custom_array_search($buy_orders, 'binance_order_id', $binance_id);
    //                 if ($search != '') {
    //                     $new_obj['id'] = $buy_orders[$search]['_id'];
    //                     $new_obj['bid'] = $binance_id;
    //                     $new_obj['bid1'] = $obj['id'];
    //                     $new_obj['btime'] = $time_binance;
    //                     $new_obj['type'] = "Buy";
    //                     $new_obj['price'] = $price;
    //                     $new_obj['status'] = "Found On Digiebot";
    //                     $new_obj['qty'] = $buy_orders[$search]['quantity'];
    //                     $new_obj['bqty'] = $obj['qty'];
    //                     $new_obj['order_status'] = $buy_orders[$search]['status'];
    //                     $new_obj['buy_id'] = $buy_orders[$search]['sell_order_id'];
    //                     $new_obj['dtime'] = $buy_orders[$search]['created_date']->toDateTime()->format("Y-m-d H:i:s");
    //                     $new_obj['url'] = SURL . "admin/buy_orders/edit-buy-order/" . (string) $buy_orders[$search]['_id'];
    //                     $new_obj['cID'] = (string) $buy_orders[$search]['sell_order_id'];
    //                     array_push($disp_arr_buy, $new_obj);
    //                 } else {
    //                     $new_obj['id'] = '';
    //                     $new_obj['bid'] = $binance_id;
    //                     $new_obj['price'] = $price;
    //                     $new_obj['type'] = "Buy";
    //                     $new_obj['btime'] = $time_binance;
    //                     $new_obj['bqty'] = $obj['qty'];
    //                     $new_obj['btime'] = $time_binance;
    //                     $new_obj['status'] = "Not Found On Digiebot";
    //                     $new_obj['url'] = '';
    //                     array_push($disp_arr_buy, $new_obj);
    //                 }
    //             }

    //             $disp_arr[] = $new_obj;
    //         }

    //         $sellArr = array();
    //         $full_arr = array();
    //         foreach ($disp_arr_buy as $row) {
    //             $cID = $row['cID'];
    //             $newone = array();
    //             foreach ($disp_arr_sell as $one) {
    //                 if ($cID == $one['ID']) {
    //                     $newone = $one;
    //                     break;
    //                 }
    //             }
    //             $arr['buy'] = $row;
    //             $arr['sell'] = $newone;
    //             $full_arr[] = $arr;

    //         }

    //         $new_buy_1 = array();
    //         foreach ($full_arr as $key) {
    //             $buy_1[] = $key['buy'];
    //         }

    //         foreach ($disp_arr_buy as $key1) {

    //             $cID = $key1['bid'];
    //             $is_found = true;
    //             foreach ($buy_1 as $one) {
    //                 if ($cID == $one['bid']) {
    //                     $is_found = false;
    //                     break;
    //                 }
    //             }

    //             if ($is_found) {
    //                 $new_buy_1[] = $key1;
    //             }

    //         }

    //         $sell_1 = array();
    //         foreach ($full_arr as $key) {
    //             $sell_1[] = $key['sell'];
    //         }

    //         // echo '<Pre>';
    //         // print_r($sell_1);
    //         // print_r($disp_arr_sell);
    //         // exit;

    //         $new_sell_1 = array();
    //         foreach ($disp_arr_sell as $key1) {

    //             $cID = $key1['bid'];
    //             $is_found = true;
    //             foreach ($sell_1 as $one) {
    //                 if ($cID == $one['bid']) {
    //                     $is_found = false;
    //                     break;
    //                 }
    //             }

    //             if ($is_found) {
    //                 $new_sell_1[] = $key1;
    //             }

    //         }
    //         $arr = array();

    //         if (!empty($new_buy_1)) {
    //             foreach ($new_buy_1 as $value) {
    //                 $arr['buy'] = $value;
    //             }
    //         }
    //         if (!empty($new_sell_1)) {
    //             foreach ($new_sell_1 as $value) {
    //                 $arr['sell'] = $value;
    //             }
    //         }

    //         // $buy[]

    //         // foreach ($arr as  $value) {
    //         //     if (!empty($value)) {
    //         //         $arr1['sell'] = $value;
    //         //          $full_arr[] = $arr1;
    //         //     }
    //         // }

    //         array_push($full_arr, $arr);

    //         $data['resp'] = $full_arr;
    //     }
    //     $coins = $this->mod_coins->get_all_coins();
    //     $data['coins'] = $coins;
    //     $this->stencil->paint('admin/reports/user_order_report', $data);
    // }

    // function custom_array_search($array, $field, $value) {
    //     foreach ($array as $key => $index) {
    //         if ($index[$field] === $value) {
    //             return $key;
    //         }

    //     }
    //     return false;
    // }

    // public function user_ledger() {
    //     $this->mod_login->verify_is_admin_login();
    //     $this->load->library("binance_api");
    //     if ($this->input->post()) {
    //         $user_id_arr = $this->mod_report->get_customer_by_username($this->input->post("filter_username"));

    //         $user_id = $user_id_arr['_id'];
    //         $symbol = $this->input->post("filter_by_coin");
    //         $data['filter_user_data']['filter_by_coin'] = $symbol;
    //         $data['filter_user_data']['filter_username'] = $this->input->post("filter_username");
    //         $order_history = $this->binance_api->get_all_orders_history($symbol, $user_id);
    //         $mytype = "";
    //         $myarr = array();
    //         foreach ($order_history as $obj) {
    //             $test = array();
    //             $binance_id = $obj['orderId'];
    //             $type = $obj['isBuyer'];
    //             $price = $obj['price'];
    //             $mil = $obj['time'];
    //             $qty = $obj['qty'];
    //             $seconds = $mil / 1000;
    //             $time_binance = date("l jS \of F Y h:i:s A", $seconds);

    //             if (!$type) {
    //                 $mytype = "sell";
    //                 $test['credit'] = $qty;
    //             } else {
    //                 $mytype = "buy";
    //                 $test['debit'] = $qty;
    //             }
    //             $test['type'] = $mytype;
    //             $test['price'] = $price;
    //             $test['binance_id'] = $binance_id;
    //             $test['time'] = $time_binance;
    //             $myarr[] = $test;
    //         }
    //         $data['rearrangedFinalData'] = $myarr;

    //     }
    //     $coins = $this->mod_coins->get_all_coins();
    //     $data['coins'] = $coins;
    //     $this->stencil->paint('admin/reports/ledger', $data);
    // }

    // public function user_trade_history_report() {
    //     $this->mod_login->verify_is_admin_login();
    //     if ($this->input->post()) {
    //         $user_id_arr = $this->mod_report->get_customer_by_username($this->input->post("filter_username"));
    //         $user_id = $user_id_arr['_id'];
    //         $data['rearrangedFinalData'] = $this->get_user_trade_info($user_id);
    //     }

    //     $this->stencil->paint('admin/reports/user_trade_history_report', $data);

    // }

    // public function user_trade_profit_report() {
    //     $this->mod_login->verify_is_admin_login();
    //     if ($this->input->post()) {
    //         $user_id_arr = $this->mod_report->get_customer_by_username($this->input->post("filter_username"));
    //         $user_id = $user_id_arr['_id'];
    //         $data['rearrangedFinalData'] = $this->get_user_trade_info($user_id);
    //     }

    //     $this->stencil->paint('admin/reports/user_profit_report', $data);

    // }

    // public function get_user_trade_info($user_id = '') {
    //     $this->mod_login->verify_is_admin_login();
    //     $this->mongo_db->where(array("admin_id" => (string) $user_id, 'status' => 1));
    //     $get_response = $this->mongo_db->get("user_account_history");
    //     $totalBTCspent = 0;
    //     $totalBTCgain = 0;
    //     $fullArr = array();
    //     foreach ($get_response as $key => $value) {
    //         $retArr = array();

    //         $retArr['buy_id'] = $value['buy_id'];
    //         $retArr['coin'] = $value['coin'];
    //         $retArr['buy_fee_deducted'] = $value['buy_fee_deducted'];
    //         $retArr['buy_fee_symbol'] = $value['buy_fee_symbol'];
    //         $retArr['buy_price'] = $value['buy_price'];
    //         $retArr['buy_qty'] = $value['buy_qty'];
    //         $retArr['totalBuyBTC'] = ($value['buy_price'] * $value['buy_qty']);
    //         $retArr['buy_time_btc_usd'] = $value['buy_time_btc_usd'];
    //         $retArr['buy_time_wallet'] = $value['buy_time_wallet'];
    //         $retArr['fee_in_btc'] = $value['fee_in_btc'];
    //         $retArr['sell_fee_deducted'] = $value['sell_fee_deducted'];
    //         $retArr['sell_fee_in_btc'] = $value['sell_fee_in_btc'];
    //         $retArr['sell_fee_symbol'] = $value['sell_fee_symbol'];
    //         $retArr['sell_price'] = $value['sell_price'];
    //         $retArr['totalSoldBTC'] = ($value['sell_price'] * $value['buy_qty']);
    //         $retArr['sell_time_btc_usd'] = $value['sell_time_btc_usd'];
    //         $retArr['sell_time_wallet'] = $value['sell_time_wallet'];
    //         $retArr['ProfitLossBTC'] = ((($retArr['totalSoldBTC'] - ($retArr['totalBuyBTC'] + $retArr['sell_fee_in_btc'] + $retArr['fee_in_btc'])) / $retArr['totalSoldBTC']) * 100);
    //         if (!empty($value['buy_qty'])) {
    //             $totalBTCspent += $retArr['totalBuyBTC'];
    //             $totalBTCgain += $retArr['totalSoldBTC'];
    //             array_push($fullArr, $retArr);
    //         }
    //     }
    //     return $fullArr;
    // }

    // public function get_order_error($order_id) {

    //     $this->mongo_db->where(array('order_id' => $this->mongo_db->mongoId($order_id), 'type' => array('$in' => array('sell_error', 'buy_error'))));
    //     $this->mongo_db->order_by(array('_id' => -1));
    //     $get = $this->mongo_db->get('orders_history_log');
    //     $error_orders = iterator_to_array($get);

    //     return $error_orders[0]['log_msg'];
    // }

    // public function get_buy_order_error_ajax() {
    //     $order_id = $this->input->post('order_id');

    //     $get_arror = $this->get_order_error($order_id);

    //     $response = '<div class="row">
	// 											<div class="col-md-6">
	// 													<label for="inputTitle">Error :</label>
	// 											</div>
	// 											<div class="col-md-6">
	// 													<p>' . $get_arror . '</p>
	// 											</div>
	// 									 </div>';
    //     $order_arr = $this->mod_buy_orders->get_buy_order($order_id);
    //     $response .= '<form method="post" action="' . SURL . 'admin/reports/update_manual_order"><div class="row">
	// 											<div class="col-md-6">
	// 											</div>
	// 											<div class="col-md-6">
	// 												<div class="form-group col-md-6">
	// 													<input type="hidden" value="' . $order_id . '" name="order_id">
	// 													<script type="text/javascript">
	// 														function setTwoNumberDecimal(event) {
	// 																$("#quantity").val(parseFloat($("#quantity").val()).toFixed(2));
	// 														}
	// 													</script>
	// 												</div>
	// 											</div>
	// 										</div>


	// 										<div class="col-md-12" id="quantitydv"></div>
	// 									 </div>';
    //     $response .= '<div class="row">
	// 										<div class="col-md-12">
	// 												<button type="submit" class="btn btn-success">Remove Error</button>
	// 												<a href="' . SURL . 'admin/buy_orders/get_errors_detail/" class="custom_link" target="_blank">Click here to Check Error Detail</a>
	// 										</div>
	// 								 </div></form>';
    //     echo $response;
    //     exit;

    // }
    // public function update_manual_order() {
    //     $id = $this->input->post('order_id');
    //     $current_date = date("Y-m-d H:i:s");
    //     $post_edit_data['modified_date'] = $this->mongo_db->converToMongodttime($current_date);

    //     $this->mongo_db->where(array('_id' => $id));
    //     $this->mongo_db->set($post_edit_data);
    //     $this->mongo_db->update('buy_orders');

    //     $this->mongo_db->where(array('_id' => $id));
    //     $resp = $this->mongo_db->get('buy_orders');
    //     $data = iterator_to_array($resp);

    //     foreach ($data as $row) {
    //         $sell_order_id = (string) $row['sell_order_id'];
    //         $post_edit_data['status'] = 'new';
    //         $this->mongo_db->set($post_edit_data);
    //         $this->mongo_db->where(array('_id' => $sell_order_id));
    //         $this->mongo_db->update('orders');

    //     }

    //     // $this->mongo_db->where(array('buy_order_id' => $this->mongo_db->mongoId($id)));
    //     // $post_edit_data['status'] = 'new';
    //     // $this->mongo_db->set($post_edit_data);
    //     // $this->mongo_db->update('orders');

    //     $admin_id = $this->session->userdata('admin_id');
    //     $message = 'Order was updated';
    //     $log_msg = $message . " And Moved From Error To Open";
    //     $this->mod_buy_orders->insert_order_history_log($id, $log_msg, 'sell_created', $admin_id, $current_date);

    //     redirect(base_url() . 'admin/buy_orders');

    // }

    // public function waqar_test_order() {
    //     $symbol = "TRXBTC";
    //     $binance_order_id = "85610009";
    //     $admin_id = "5c0912d4fc9aadaac61dd07d";
    //     $ID = "5c4e4180fc9aad623e3ac562";
    //     $order_status = $this->binance_api->order_status($symbol, $binance_order_id, $admin_id);

    //     if ($order_status['status'] == 'FILLED') {
    //         $post_edit_data['status'] = 'submitted';
    //         $this->mongo_db->set($post_edit_data);
    //         $this->mongo_db->where(array('_id' => $ID));
    //         $res = $this->mongo_db->update('orders');
    //         echo '<pre>';
    //         print_r($res);
    //     }
    // }

    // public function get_order_status($value = '') {
    //     $symbol = "XRPBTC";
    //     $order_id = 107150442;
    //     $user_id = "5c0914b6fc9aadaac61dd13d";
    //     $orderstatus = $this->binance_api->order_status($symbol, $order_id, $user_id);

    //     echo "<pre>";
    //     print_r($orderstatus);
    //     exit();
    // }

    // public function test_waqar() {
    //     $where['_id'] = '5c362130fc9aad934e00cc57';
    //     $upd['is_sell_order'] = 'sold';
    //     $upd['market_sold_price'] = (float) '0.00009107';
    //     $this->mongo_db->where($where);
    //     $this->mongo_db->set($upd);
    //     $set[] = $this->mongo_db->update('buy_orders');

    //     $where1['_id'] = '5c362133fc9aad950d7af85b';
    //     $upd1['status'] = 'FILLED';
    //     $upd1['binance_order_id'] = '110152086';
    //     $upd1['market_value'] = (float) '0.00009107';
    //     $this->mongo_db->where($where1);
    //     $this->mongo_db->set($upd1);
    //     $set[] = $this->mongo_db->update('orders');

    //     echo "<pre>";
    //     print_r($set);
    //     exit;

    // }

    // public function test_waqar_update() {
    //     $where['_id'] = '5c2a62e3fc9aad27d1202c0c';
    //     $upd['quantity'] = 2000.00;
    //     $upd['market_sold_price'] = (float) '0.00000500';
    //     $this->mongo_db->where($where);
    //     $this->mongo_db->set($upd);
    //     $set[] = $this->mongo_db->update('buy_orders');

    //     $where1['_id'] = '5c2a62f0fc9aad33092eda08';
    //     $upd1['status'] = 'FILLED';
    //     $upd1['binance_order_id'] = '83625487';
    //     $upd1['quantity'] = 2000.00;
    //     $upd1['market_value'] = (float) '0.00000500';
    //     $this->mongo_db->where($where1);
    //     $this->mongo_db->set($upd1);
    //     $set[] = $this->mongo_db->update('orders');

    //     echo "<pre>";
    //     print_r($set);
    //     exit;

    // }

    // public function run($value = "admin") {

    //     $user_id_arr = $this->mod_report->get_customer_by_username($value);

    //     echo "<pre>";
    //     print_r($user_id_arr);

    //     $user_id = $user_id_arr['_id'];
    //     //5c0912b7fc9aadaac61dd072
    //     $this->load->library("binance_api");
    //     //$user_id = "5c0912b7fc9aadaac61dd072";

    //     $deposit = $this->binance_api->get_all_deposit_history($user_id);
    //     $withdraw = $this->binance_api->get_all_withdraw_history($user_id);

    //     echo "<pre>";
    //     echo "<br>Deposit History <br>";
    //     print_r($deposit);

    //     echo "<br>Withdraw History <br>";
    //     print_r($withdraw);
    //     exit;
    // }

    // public function run2($value = '') {
    //     //load the view and saved it into $html variable
    //     $user_id_arr = $this->mod_report->get_customer_by_username($value);
    //     $user_id = $user_id_arr['_id'];
    //     $data['rearrangedFinalData'] = $this->get_user_trade_info($user_id);
    //     $html = $this->load->view('admin/reports/user_trade_history_report', $data, true);

    //     //this the the PDF filename that user will get to download
    //     $pdfFilePath = "output_pdf_name.pdf";

    //     //load mPDF library
    //     $this->load->library('m_pdf');
    //     $path = SURL . "assets/css/admin/module.admin.page.index.min.css";
    //     $css = file_get_contents($path);
    //     //generate the PDF from the given html
    //     $this->m_pdf->pdf->WriteHTML($css);
    //     $this->m_pdf->pdf->WriteHTML($html);

    //     //download it.
    //     $this->m_pdf->pdf->Output($pdfFilePath, "D");
    // }

    public function csv_export_trades() {

        $data_arr['filter_order_data'] = $this->input->post();
        $session_post_data = $this->session->userdata('filter_order_data');

        $collection = "buy_orders";
        if ($session_post_data['filter_by_coin']) {
            $search['symbol'] = $session_post_data['filter_by_coin'];
        }
        if ($session_post_data['filter_by_mode']) {
            $search['application_mode'] = $session_post_data['filter_by_mode'];
        }
        if ($session_post_data['filter_by_trigger']) {
            $search['trigger_type'] = $session_post_data['filter_by_trigger'];
        }
        if ($session_post_data['filter_level']) {
            $order_level = $session_post_data['filter_level'];
            $search['order_level'] = $order_level;
        }
        if ($session_post_data['filter_username']) {
            $username = $session_post_data['filter_username'];
            $admin_id = $this->get_admin_id($username);
            $search['admin_id'] = (string) $admin_id;
        }
        if ($session_post_data['optradio']) {
            if ($session_post_data['optradio'] == 'created_date') {
                $oder_arr['created_date'] = -1;
            } elseif ($session_post_data['optradio'] == 'modified_date') {
                $oder_arr['modified_date'] = -1;
            }
        }
        if ($session_post_data['filter_by_status']) {
            $order_status = $this->input->post('filter_by_status');
            if ($order_status == 'new') {
                $search['status'] = 'new';
            } elseif ($order_status == 'error') {
                $search['status'] = 'error';
            } elseif ($order_status == 'open') {
                $search['status'] = array('$in' => array('submitted', 'FILLED'));
                $search['is_sell_order'] = 'yes';
            } elseif ($order_status == 'sold') {
                $search['status'] = 'FILLED';
                $search['is_sell_order'] = 'sold';
                $collection = "sold_buy_orders";
            }
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
            $search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
        }
        $search['parent_status'] = array('$ne' => 'parent');
        //$search['status'] = array('$ne' => 'canceled');

        $connetct = $this->mongo_db->customQuery();
        $pending_curser = $connetct->buy_orders->find($search);
        $sold_curser = $connetct->sold_buy_orders->find($search);

        $pending_arr = iterator_to_array($pending_curser);
        $sold_arr = iterator_to_array($sold_curser);

        $orders = array_merge_recursive($pending_arr, $sold_arr);

        foreach ($orders as $key => $part) {
            $sort[$key] = (string) $part['modified_date'];
        }

        array_multisort($sort, SORT_DESC, $orders);

        $new_order_arrray = array();
        foreach ($orders as $order) {
            $id = $order['admin_id'];
            $data_user = $this->get_username_from_user($id);
            $order['admin'] = $data_user;
            $_id = $order['_id'];

            $error = $this->get_error_type($_id);
            $order['log'] = $error;
            array_push($new_order_arrray, $order);
        }
        //$data['orders'] = $new_order_arrray;

        $full_arr = array();
        foreach ($new_order_arrray as $key => $value) {
            if (!empty($value)) {
                $retArr = array();

                if (isset($value['5_hour_max_market_price']) && $value['5_hour_max_market_price'] != '') {

                    $five_hour_max_market_price = $value['5_hour_max_market_price'];
                    $purchased_price = (float) $value['market_value'];
                    $profit = $five_hour_max_market_price - $purchased_price;

                    $profit_margin = ($profit / $five_hour_max_market_price) * 100;

                    $max_profit_per = ($profit) * (100 / $purchased_price);

                    $max_profit_per = number_format($max_profit_per, 2);
                }

                if (isset($value['5_hour_min_market_price']) && $value['5_hour_min_market_price'] != '') {

                    $market_lowest_value = $value['5_hour_min_market_price'];
                    $purchased_price = (float) $value['market_value'];
                    $profit = $market_lowest_value - $purchased_price;

                    $profit_margin = ($profit / $market_lowest_value) * 100;

                    $min_profit_per = ($profit) * (100 / $purchased_price);
                    $min_profit_per = number_format($min_profit_per, 2);
                }

                if (isset($value['market_heighest_value']) && $value['market_heighest_value'] != '') {

                    $five_hour_max_market_price1 = $value['market_heighest_value'];
                    $purchased_price1 = (float) $value['market_value'];
                    $profit1 = $five_hour_max_market_price1 - $purchased_price1;

                    $profit_margin1 = ($profit1 / $five_hour_max_market_price1) * 100;

                    $max_profit_per1 = ($profit1) * (100 / $purchased_price1);

                    $max_profit_per1 = number_format($max_profit_per1, 2);
                }

                if (isset($value['market_lowest_value']) && $value['market_lowest_value'] != '') {

                    $market_lowest_value2 = $value['market_lowest_value'];
                    $purchased_price2 = (float) $value['market_value'];
                    $profit2 = $market_lowest_value2 - $purchased_price2;

                    $profit_margin2 = ($profit2 / $market_lowest_value2) * 100;

                    $min_profit_per2 = ($profit2) * (100 / $purchased_price2);
                    $min_profit_per2 = number_format($min_profit_per2, 2);
                }

                $this->load->model('admin/mod_dashboard');

                $market_value = $this->mod_dashboard->get_market_value($value['symbol']);

                if ($value['status'] == 'FILLED') {

                    if ($value['is_sell_order'] == 'yes') {

                        $current_data = num($market_value) - num($value['market_value']);
                        $market_data = ($current_data * 100 / $market_value);
                        $market_data = number_format((float) $market_data, 2, '.', '');
                    }
                    if ($value['is_sell_order'] == 'sold') {
                        $current_data = num($value['market_sold_price']) - num($value['market_value']);
                        $market_data = ($current_data * 100 / $value['market_sold_price']);
                        $market_data = number_format((float) $market_data, 2, '.', '');
                    }
                }

                $retArr['id'] = $value['_id'];
                $retArr['symbol'] = $value['symbol'];
                $retArr['price'] = $value['price'];
                $retArr['quantity'] = $value['quantity'];
                $retArr['order_type'] = $value['order_type'];
                $retArr['trigger_type'] = $value['trigger_type'];
                $retArr['binance_order_id'] = $value['binance_order_id'];
                $retArr['buy_parent_id'] = $value['buy_parent_id'];
                $retArr['application_mode'] = $value['application_mode'];
                $retArr['defined_sell_percentage'] = $value['defined_sell_percentage'];
                $retArr['order_level'] = $value['order_level'];
                $retArr['status'] = $value['status'];
                $retArr['is_sell_order'] = $value['is_sell_order'];
                $retArr['market_value'] = $value['market_value'];
                $retArr['sell_order_id'] = $value['sell_order_id'];
                $retArr['is_manual_buy'] = $value['is_manual_buy'];
                $retArr['is_manual_sold'] = $value['is_manual_sold'];
                $retArr['sell_rule_number'] = $value['sell_rule_number'];
                $retArr['buy_rule_number'] = $value['buy_rule_number'];
                $retArr['market_sold_price'] = $value['market_sold_price'];
                $retArr['profit_data'] = $market_data;
                $retArr['5_hour_max_market_price'] = $value['5_hour_max_market_price'];
                $retArr['5_hour_min_market_price'] = $value['5_hour_min_market_price'];
                $retArr['five_hour_max_profit'] = $max_profit_per;
                $retArr['five_hour_min_profit'] = $min_profit_per;
                $retArr['market_heighest_value'] = $value['market_heighest_value'];
                $retArr['market_lowest_value'] = $value['market_lowest_value'];
                $retArr['market_heighest_profit'] = $max_profit_per1;
                $retArr['market_lowest_profit'] = $min_profit_per2;
                $retArr['username'] = $value['admin']['username'];
                $retArr['email_address'] = $value['admin']['email_address'];
                $retArr['created_date'] = $value['created_date']->toDatetime()->format("d-M, Y H:i:s");
                $retArr['modified_date'] = $value['modified_date']->toDatetime()->format("d-M, Y H:i:s");
                $retArr['created_time_ago'] = time_elapsed_string($value['created_date']->toDatetime()->format("Y-m-d H:i:s"));
                $retArr['last_updated'] = time_elapsed_string($value['modified_date']->toDatetime()->format("Y-m-d H:i:s"));

                $fullarray[] = $retArr;
            }
        }
        $this->download_send_headers("order_report_" . date("Y-m-d_ Gisa") . ".csv");

        echo $this->array2csv($fullarray);

        exit;

    }

    public function coin_report() {
		
        $this->mod_login->verify_is_admin_login();
        if ($this->input->post()) {

            $data_arr['filter_order_data'] = $this->input->post();
            $this->session->set_userdata($data_arr);

            $collection = "buy_orders";
            $coin_array = array();
            if (!empty($this->input->post('filter_by_coin'))) {
                $coin_array = $this->input->post('filter_by_coin');
                //$search['symbol']['$in'] = $this->input->post('filter_by_coin');
            } else {
                $coin_array_all = $this->mod_coins->get_all_coins();
                $coin_array = array_column($coin_array_all, 'symbol');
            }

            if ($this->input->post('filter_by_mode')) {
                $search['order_mode'] = $this->input->post('filter_by_mode');
            }

            if ($this->input->post('group_filter') != "") {
                if ($this->input->post('group_filter') == 'rule_group') {
                    $filter = 'rule';
                } elseif ($this->input->post('group_filter') == 'trigger_group') {
                    $filter = 'trigger';
                }
            } else {
                $filter = 'all';
            }

            if ($this->input->post('trade_type') != "") {
                if ($this->input->post('trade_type') == 'lth_trade') {
                    $search['lth_functionality'] = 'yes';
                } elseif ($this->input->post('trade_type') == 'normal_trade') {
                    $search['lth_functionality']['$ne'] = 'yes';
                }
            }

            if ($_POST['filter_by_start_date'] != "" && $_POST['filter_by_end_date'] != "") {

                $created_datetime = date('Y-m-d G:i:s', strtotime($_POST['filter_by_start_date']));
                $orig_date = new DateTime($created_datetime);
                $orig_date = $orig_date->getTimestamp();
                $start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

                $created_datetime22 = date('Y-m-d G:i:s', strtotime($_POST['filter_by_end_date']));
                $orig_date22 = new DateTime($created_datetime22);
                $orig_date22 = $orig_date22->getTimestamp();
                $end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
                $search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
            }

            //xit;

            if ($filter == 'all') {
                $conn = $this->mongo_db->customQuery();
                $order_arr_all = array();
                foreach ($coin_array as $key => $value) {
                    $search['symbol'] = $value;
                    $db_obj = $conn->sold_buy_orders->find($search);
                    $order_arr = iterator_to_array($db_obj);
                    $order_arr_all[$value] = $order_arr;
                }
                $data['full_arr'] = $order_arr_all;
                //exit;
            } else if ($filter == 'trigger') {
                $conn = $this->mongo_db->customQuery();
                $order_arr_all = array();
                $trigger_array = array("barrier_trigger", "barrier_percentile_trigger", "box_trigger");
                foreach ($coin_array as $key => $value) {
                    $search['symbol'] = $value;
                    foreach ($trigger_array as $key1 => $value_trigger) {
                        $search['trigger_type'] = $value_trigger;

                        $db_obj = $conn->sold_buy_orders->find($search);
                        $order_arr = iterator_to_array($db_obj);
                        $order_arr_all[$value][$value_trigger] = $order_arr;
                    }
                }
                $resultArr = $this->make_array_for_view($order_arr_all, 'trigger');
                $data['full_arr'] = $resultArr;
            } elseif ($filter == "rule") {
                if ($this->input->post('filter_by_trigger')) {
                    $search['trigger_type'] = $this->input->post('filter_by_trigger');
                }
                $conn = $this->mongo_db->customQuery();
                $order_arr_all = array();
                $trigger_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

                if ($this->input->post('filter_by_trigger') == 'barrier_trigger') {
                    $trigger_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
                } elseif ($this->input->post('filter_by_trigger') == 'barrier_percentile_trigger') {
                    $trigger_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
                }

                foreach ($coin_array as $key => $value) {
                    $search['symbol'] = $value;
                    foreach ($trigger_array as $key1 => $value_trigger) {

                        if ($this->input->post('filter_by_trigger') == 'barrier_trigger') {
                            $search['buy_rule_number'] = $value_trigger;
                        } elseif ($this->input->post('filter_by_trigger') == 'barrier_percentile_trigger') {
                            $search['order_level'] = "level_" . $value_trigger;
                        }

                        $db_obj = $conn->sold_buy_orders->find($search);
                        $order_arr = iterator_to_array($db_obj);
                        $order_arr_all[$value][$value_trigger] = $order_arr;
                    }
                }
                $resultArr = $this->make_array_for_view($order_arr_all, 'trigger');

                $data['full_arr'] = $resultArr;
            }

        }
        $coins = $this->mod_coins->get_all_coins();
        $data['coins'] = $coins;
        $this->stencil->paint('admin/reports/coin_order_report', $data);
    }

    // public function make_array_for_view($order_arr, $values) {
    //     if ($values == 'trigger') {
    //         if (!empty($order_arr)) {

    //             foreach ($order_arr as $coin_key => $coin_arr) {
    //                 $coin = $coin_key;
    //                 $coin_count = 0;

    //                 foreach ($coin_arr as $key => $value) {
    //                     $trigger = $key;
    //                     $trigger_count = count($value);
    //                     $coin_count += $trigger_count;

    //                     $market_heighest_value = array_column($value, 'market_heighest_value');
    //                     $market_lowest_value = array_column($value, 'market_lowest_value');
    //                     $five_hour_max_market_price = array_column($value, '5_hour_max_market_price');
    //                     $five_hour_min_market_price = array_column($value, '5_hour_min_market_price');

    //                     $max_high = max($market_heighest_value);
    //                     $min_high = min($market_heighest_value);
    //                     $max_low = max($market_lowest_value);
    //                     $min_low = min($market_lowest_value);

    //                     $market_heighest_value = array_filter($market_heighest_value);
    //                     $max_high_average = array_sum($market_heighest_value) / count($market_heighest_value);

    //                     $market_lowest_value = array_filter($market_lowest_value);
    //                     $max_low_average = array_sum($market_lowest_value) / count($market_lowest_value);

    //                     $five_hour_max_market_price = array_filter($five_hour_max_market_price);
    //                     $high_five_average = array_sum($five_hour_max_market_price) / count($five_hour_max_market_price);

    //                     $five_hour_min_market_price = array_filter($five_hour_min_market_price);
    //                     $low_five_average = array_sum($five_hour_min_market_price) / count($five_hour_min_market_price);

    //                     $max_high_five = max($five_hour_max_market_price);
    //                     $min_high_five = min($five_hour_max_market_price);
    //                     $max_low_five = max($five_hour_min_market_price);
    //                     $min_low_five = min($five_hour_min_market_price);

    //                     $a = array_filter($a);
    //                     $average = array_sum($a) / count($a);

    //                     $avg_profit = 0;
    //                     $total_profit = 0;
    //                     $total_quantity = 0;
    //                     $winning = 0;
    //                     $losing = 0;
    //                     $top1 = 0;
    //                     $top2 = 0;
    //                     $bottom2 = 0;

    //                     $max_profit_per = array();
    //                     $min_profit_per1 = array();
    //                     $max_profit_pert = array();
    //                     $min_profit_per2 = array();

    //                     $opp = $this->calculate_no_of_oppurtunities($coin, $value);

    //                     foreach ($value as $col => $row) {
    //                         if (!empty($row)) {

    //                             if (isset($row['5_hour_max_market_price']) && $row['5_hour_max_market_price'] != '') {

    //                                 $five_hour_max_market_price = $row['5_hour_max_market_price'];
    //                                 $purchased_price = (float) $row['market_value'];
    //                                 $profit = $five_hour_max_market_price - $purchased_price;

    //                                 $profit_margin = ($profit / $five_hour_max_market_price) * 100;

    //                                 $max_profit_per_5 = ($profit) * (100 / $purchased_price);

    //                                 $max_profit_per[] = number_format($max_profit_per_5, 2);
    //                             }

    //                             if (isset($row['5_hour_min_market_price']) && $row['5_hour_min_market_price'] != '') {

    //                                 $market_lowest_value = $row['5_hour_min_market_price'];
    //                                 $purchased_price = (float) $row['market_value'];
    //                                 $profit = $market_lowest_value - $purchased_price;

    //                                 $profit_margin = ($profit / $market_lowest_value) * 100;

    //                                 $min_profit_per_5 = ($profit) * (100 / $purchased_price);
    //                                 $min_profit_per1[] = number_format($min_profit_per_5, 2);
    //                             }

    //                             if (isset($row['market_heighest_value']) && $row['market_heighest_value'] != '') {

    //                                 $five_hour_max_market_price1 = $row['market_heighest_value'];
    //                                 $purchased_price1 = (float) $row['market_value'];
    //                                 $profit1 = $five_hour_max_market_price1 - $purchased_price1;

    //                                 $profit_margin1 = ($profit1 / $five_hour_max_market_price1) * 100;

    //                                 $max_profit_per_t = ($profit1) * (100 / $purchased_price1);

    //                                 $max_profit_pert[] = number_format($max_profit_per_t, 2);
    //                             }

    //                             if (isset($row['market_lowest_value']) && $row['market_lowest_value'] != '') {

    //                                 $market_lowest_value2 = $row['market_lowest_value'];
    //                                 $purchased_price2 = (float) $row['market_value'];
    //                                 $profit2 = $market_lowest_value2 - $purchased_price2;

    //                                 $profit_margin2 = ($profit2 / $market_lowest_value2) * 100;

    //                                 $min_profit_per2_t = ($profit2) * (100 / $purchased_price2);
    //                                 $min_profit_per2[] = number_format($min_profit_per2_t, 2);
    //                             }

    //                             $total_sold_orders++;
    //                             $market_sold_price = $row['market_sold_price'];
    //                             $current_order_price = $row['market_value'];
    //                             $quantity = $row['quantity'];

    //                             $current_data2222 = $market_sold_price - $current_order_price;
    //                             $profit_data = ($current_data2222 * 100 / $market_sold_price);
    //                             if ($profit_data > 0) {
    //                                 $winning++;
    //                             } elseif ($profit_data < 0) {
    //                                 $losing++;
    //                             }

    //                             if ($profit_data >= 1 && $profit_data <= 2) {
    //                                 $top1++;
    //                             }
    //                             if ($profit_data >= 2) {
    //                                 $top2++;
    //                             }
    //                             if ($profit_data <= -2) {
    //                                 $bottom2++;
    //                             }
    //                             $profit_data = $profit_data; //- 0.4;
    //                             $profit_data = number_format((float) $profit_data, 2, '.', '');
    //                             $total_btc = $quantity * (float) $current_order_price;
    //                             $total_profit += $total_btc * $profit_data;
    //                             $total_quantity += $total_btc;
    //                         }
    //                     }
    //                     if ($total_quantity == 0) {
    //                         $total_quantity = 1;
    //                     }
    //                     $avg_profit = $total_profit / $total_quantity;

    //                     $max_profit_5h = (array_sum($max_profit_per) / count($max_profit_per));
    //                     $min_profit_5h = (array_sum($min_profit_per1) / count($min_profit_per1));
    //                     $max_profit_high = (array_sum($max_profit_pert) / count($max_profit_pert));
    //                     $min_profit_low = (array_sum($min_profit_per2) / count($min_profit_per2));

    //                     $retArr = array(
    //                         'trigger_count' => $trigger_count,
    //                         'avg_profit' => number_format($avg_profit, 2),
    //                         'max_high_average' => num($max_high_average),
    //                         'max_low_average' => num($max_low_average),
    //                         'high_five_average' => num($high_five_average),
    //                         'low_five_average' => num($low_five_average),
    //                         'max_profit_5h' => number_format($max_profit_5h, 2),
    //                         'min_profit_5h' => number_format($min_profit_5h, 2),
    //                         'max_profit_high' => number_format($max_profit_high, 2),
    //                         'min_profit_low' => number_format($min_profit_low, 2),
    //                         'winning_trades' => $winning,
    //                         'losing_trades' => $losing,
    //                         'top_1_per' => $top1,
    //                         'top_2_per' => $top2,
    //                         'bottom_2_per' => $bottom2,
    //                         'opp' => $opp,
    //                     );
    //                     $t_arr[$trigger] = $retArr;
    //                 }
    //                 $my_coin_data = $this->get_order_arr($coin_arr, $coin);
    //                 $t_arr['coin_meta'] = $my_coin_data;
    //                 $finalArray[$coin] = $t_arr;
    //             }

    //         }
    //     }
    //     //exit;
    //     // print_me($finalArray, "waqar");
    //     return $finalArray;
    // }

    // public function calculate_no_of_oppurtunities($coin, $trades) {
    //     $old_time = "";
    //     $op = 0;
    //     $tempArr = array();
    //     array_multisort(array_column($trades, "created_date"), SORT_ASC, $trades);
    //     foreach ($trades as $key => $value) {
    //         $time = $value['created_date']->toDateTime()->format("Y-m-d H");
    //         if ($time != $old_time) {
    //             $op++;
    //             $old_time = $time;
    //             $tempArr[$time][] = $value;
    //         } else {
    //             $tempArr[$time][] = $value;
    //         }
    //     }
    //     $retArr = array();
    //     foreach ($tempArr as $key => $value) {
    //         $profit_data = 0;
    //         $total_btc = 0;
    //         $total_profit = 0;
    //         $total_quantity = 0;
    //         $avg_profit = 0;
    //         $total_sold_orders = 0;
    //         $max_profit_per = array();
    //         $min_profit_per1 = array();
    //         $max_profit_pert = array();
    //         $min_profit_per2 = array();
    //         $first_buy_price = $value[0]['market_value'];
    //         $first_sell_price = $value[0]['market_sold_price'];
    //         foreach ($value as $key_1 => $valueArr) {
    //             $total_sold_orders++;

    //             if (isset($valueArr['5_hour_max_market_price']) && $valueArr['5_hour_max_market_price'] != '') {

    //                 $five_hour_max_market_price = $valueArr['5_hour_max_market_price'];
    //                 $purchased_price = (float) $valueArr['market_value'];
    //                 $profit = $five_hour_max_market_price - $purchased_price;

    //                 $profit_margin = ($profit / $five_hour_max_market_price) * 100;

    //                 $max_profit_per_5 = ($profit) * (100 / $purchased_price);

    //                 $max_profit_per[] = number_format($max_profit_per_5, 2);
    //             }

    //             if (isset($valueArr['5_hour_min_market_price']) && $valueArr['5_hour_min_market_price'] != '') {

    //                 $market_lowest_value = $valueArr['5_hour_min_market_price'];
    //                 $purchased_price = (float) $valueArr['market_value'];
    //                 $profit = $market_lowest_value - $purchased_price;

    //                 $profit_margin = ($profit / $market_lowest_value) * 100;

    //                 $min_profit_per_5 = ($profit) * (100 / $purchased_price);
    //                 $min_profit_per1[] = number_format($min_profit_per_5, 2);
    //             }

    //             if (isset($valueArr['market_heighest_value']) && $valueArr['market_heighest_value'] != '') {

    //                 $five_hour_max_market_price1 = $valueArr['market_heighest_value'];
    //                 $purchased_price1 = (float) $valueArr['market_value'];
    //                 $profit1 = $five_hour_max_market_price1 - $purchased_price1;

    //                 $profit_margin1 = ($profit1 / $five_hour_max_market_price1) * 100;

    //                 $max_profit_per_t = ($profit1) * (100 / $purchased_price1);

    //                 $max_profit_pert[] = number_format($max_profit_per_t, 2);
    //             }

    //             if (isset($valueArr['market_lowest_value']) && $valueArr['market_lowest_value'] != '') {

    //                 $market_lowest_value2 = $valueArr['market_lowest_value'];
    //                 $purchased_price2 = (float) $valueArr['market_value'];
    //                 $profit2 = $market_lowest_value2 - $purchased_price2;

    //                 $profit_margin2 = ($profit2 / $market_lowest_value2) * 100;

    //                 $min_profit_per2_t = ($profit2) * (100 / $purchased_price2);
    //                 $min_profit_per2[] = number_format($min_profit_per2_t, 2);
    //             }

    //             $market_sold_price = $valueArr['market_sold_price'];
    //             $current_order_price = $valueArr['market_value'];
    //             $quantity = $valueArr['quantity'];
    //             $current_data2222 = $market_sold_price - $current_order_price;
    //             $profit_data = ($current_data2222 * 100 / $market_sold_price);
    //             $profit_data = number_format((float) $profit_data, 2, '.', '');
    //             $total_btc = $quantity * (float) $current_order_price;
    //             $total_profit += $total_btc * $profit_data;
    //             $total_quantity += $total_btc;
    //         }
    //         if ($total_quantity == 0) {
    //             $total_quantity = 1;
    //         }
    //         $max_profit_5h = (array_sum($max_profit_per) / count($max_profit_per));
    //         $min_profit_5h = (array_sum($min_profit_per1) / count($min_profit_per1));
    //         $max_profit_high = (array_sum($max_profit_pert) / count($max_profit_pert));
    //         $min_profit_low = (array_sum($min_profit_per2) / count($min_profit_per2));
    //         $avg_profit = $total_profit / $total_quantity;

    //         $retArr['avg'][$key]['count'] = $total_sold_orders;
    //         $retArr['avg'][$key]['avg'] = $avg_profit;

    //         $retArr['avg'][$key]['max_profit_5h'] = $max_profit_5h;
    //         $retArr['avg'][$key]['min_profit_5h'] = $min_profit_5h;

    //         $retArr['avg'][$key]['first_sell_price'] = $first_sell_price;
    //         $retArr['avg'][$key]['first_buy_price'] = $first_buy_price;

    //         $retArr['avg'][$key]['max_profit_high'] = $max_profit_high;
    //         $retArr['avg'][$key]['min_profit_low'] = $min_profit_low;

    //         $five_hr_up_down = $this->get_high_low_value($coin, $key . ":00:00", date("Y-m-d H:i:s", strtotime("+5 hours", strtotime($key . ":00:00"))));
    //         $retArr['avg'][$key]['high_low'] = $five_hr_up_down;

    //     }
    //     // echo "<pre>";
    //     // print_r($tempArr);

    //     //print_me($retArr['avg'], 'waqar');
    //     $retArr['op'] = $op;
    //     return $retArr;
    // }

    // public function get_high_low_value($symbol, $start_date, $end_date) {
    //     // $start_date = "2019-02-01 00:00:00";
    //     // $end_date = "2019-03-15 00:00:00";

    //     $search_arr['coin'] = $symbol;
    //     $search_arr['timestampDate']['$gte'] = $this->mongo_db->converToMongodttime($start_date);
    //     $search_arr['timestampDate']['$lte'] = $this->mongo_db->converToMongodttime($end_date);

    //     $this->mongo_db->where($search_arr);
    //     $curser = $this->mongo_db->get("market_chart");
    //     $result = iterator_to_array($curser);

    //     $high_arr = array_column($result, 'high');
    //     $low_arr = array_column($result, 'low');

    //     $high = max($high_arr);
    //     $low = min($low_arr);

    //     return array("high" => $high, "low" => $low);

    // }

    // public function get_order_arr($order_arr, $coin) {

    //     foreach ($order_arr as $key1 => $value_arr) {
    //         foreach ($value_arr as $key2 => $value2) {
    //             $barrier[] = $value2;
    //         }
    //     }

    //     if (count($barrier)) {
    //         array_multisort(array_column($barrier, "created_date"), SORT_ASC, $barrier);

    //         $start_date = $barrier[0]['created_date']->toDatetime()->format("Y-m-d H:i:s");
    //         $end_date = $barrier[count($barrier) - 1]['created_date']->toDatetime()->format("Y-m-d H:i:s");
    //         $first_price = $barrier[0]['market_value'];
    //         $last_price = $barrier[count($barrier) - 1]['market_value'];

    //         $coin_avg_move = (($last_price - $first_price) / $first_price) * 100;

    //         $high_low_arr = $this->get_high_low_value($coin, $start_date, $end_date);

    //         $returnArr = $high_low_arr;
    //         $returnArr['coin_avg_move'] = number_format($coin_avg_move, 2);
    //         $returnArr['total'] = count($barrier);
    //         return $returnArr;
    //     } else {
    //         return array();
    //     }

    // } //End of make_date_quarter

    // public function meta_coin_report() {
    //     $this->mod_login->verify_is_admin_login();
    //     // ini_set("display_errors", E_ALL);
    //     // error_reporting(E_ALL);
    //     if ($this->input->post()) {
    //         $data_arr['filter_order_data'] = $this->input->post();
    //         $this->session->set_userdata($data_arr);
    //         if ($this->input->post('watch_later') == 'yes') {
    //             $final_data = $this->meta_coin_report_calculation($this->input->post());
    //             $data = $final_data;
    //         } else {
    //             $final_data = $this->meta_coin_report_calculation($this->input->post());
    //             $data = $final_data;
    //         }
    //     }
    //     $this->mongo_db->where(array('trigger' => 'barrier'));
    //     $sett = $this->mongo_db->get("report_setting_collection");
    //     $data['settings'] = iterator_to_array($sett);

    //     $coins = $this->mod_coins->get_all_coins();
    //     $data['coins'] = $coins;

    //     $this->stencil->paint('admin/reports/meta_report', $data);
    // }
    // public function meta_coin_report_calculation($data_arr) {
    //     // ini_set("display_errors", E_ALL);
    //     // error_reporting(E_ALL);
    //     // echo "<pre>";
    //     // print_r($data_arr);
    //     // exit;
    //     if ($data_arr['watch_later'] == 'yes') {
    //         $data_arr['status'] = 1;
    //         $data_arr['trigger'] = 'barrier';
    //         $admin_id = $this->session->userdata('admin_id');
    //         $username = $this->session->userdata('username');
    //         $data_arr['admin_id'] = $admin_id;
    //         $data_arr['username'] = $username;
    //         $this->mongo_db->insert("report_setting_collection", $data_arr);
    //         return true;
    //     } else {
    //         if (empty($data_arr['black_wall_pressure']) && empty($data_arr['seven_level_depth']) && empty($data_arr['market_depth_ask']) && empty($data_arr['market_depth']) && empty($data_arr['sellers_buyers_per']) && empty($data_arr['last_qty_buy_vs_sell']) && empty($data_arr['last_qty_time_ago']) && empty($data_arr['last_qty_time_ago_15']) && empty($data_arr['yellow_wall_pressure']) && empty($data_arr['bid']) && empty($data_arr['ask'])) {
    //             $this->session->set_flashdata('ok_message', 'Please Select atleast one indicator.');
    //             redirect(base_url() . "admin/reports/meta_coin_report");
    //         }
    //         $data_arr['status'] = 3;
    //         $data_arr['trigger'] = 'barrier';
    //         $this->mongo_db->insert("report_setting_collection", $data_arr);

    //         $symbol = $data_arr['filter_by_coin'];
    //         $start_date = $data_arr['filter_by_start_date'];
    //         $end_date = $data_arr['filter_by_end_date'];

    //         $date1 = new DateTime($start_date);
    //         $date2 = new DateTime($end_date);

    //         $diff = $date2->diff($date1);

    //         $hours = $diff->h;
    //         $hours = $hours + ($diff->days * 24);
    //         $total_days = $diff->days;
    //         $d1 = $start_date;

    //         $target_profit = $data_arr['target_profit'];
    //         $target_stoploss = $data_arr['target_stoploss'];

    //         $date_range_hour = array();
    //         for ($i = 0; $i <= $hours; $i++) {
    //             $start = date("Y-m-d H:00:00", strtotime("+" . $i . " hours", strtotime($d1)));
    //             $move = date("Y-m-d H:59:59", strtotime("+" . ($i) . " hours", strtotime($d1)));
    //             $search_arr['coin'] = $symbol;
    //             $search_arr['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($start);
    //             $search_arr['modified_date']['$lte'] = $this->mongo_db->converToMongodttime($move);

    //             $this->mongo_db->where($search_arr);
    //             $res = $this->mongo_db->get("coin_meta_history");
    //             $result = iterator_to_array($res);
    //             $candle_condition = $this->check_candle_data($start, $data_arr);
    //             foreach ($result as $metakey => $meta_value) {
    //                 if (!empty($meta_value)) {

    //                     $blackwall = false;
    //                     $seven_level = false;

    //                     $yellowall = false;
    //                     $big_buy = false;

    //                     $ask_qty = false;
    //                     $bid_qty = false;
    //                     $bvs = false;
    //                     $lastqty = false;
    //                     $lasttime = false;

    //                     $t3ltc = false;
    //                     $th4cot = false;
    //                     $bid = false;
    //                     $ask = false;
    //                     $meet_condition_for_buy = false;

    //                     $current_market_price = $meta_value['current_market_value'];
    //                     if ($barrier_check == 'yes') {
    //                         $barrier_range_percentage = $data_arr['barrier_range'];
    //                         $barrier_side = $data_arr['barrier_side'];
    //                         $barrier_type = $data_arr['barrier_type'];
    //                         $last_barrrier_value = "";
    //                         // $last_barrrier_value = $this->triggers_trades->list_barrier_status($symbol, 'very_strong_barrier', $current_market_price, 'down');

    //                         //%%%%%%%%%%%%%%%%%%% -- Barrier Status --%%%%%%%%%%%%%%%%%%%%%%%
    //                         $last_barrrier_value = $this->triggers_trades->list_barrier_status_simulator($symbol, $barrier_type, $current_market_price, $barrier_side, $start);

    //                         $barrier_val = $last_barrrier_value;

    //                         $barrier_value_range_upside = $last_barrrier_value + ($last_barrrier_value / 100) * $barrier_range_percentage;
    //                         $barrier_value_range_down_side = $last_barrrier_value - ($last_barrrier_value / 100) * $barrier_range_percentage;

    //                         if ((num($current_market_price) >= num($barrier_value_range_down_side)) && (num($current_market_price) <= num($barrier_value_range_upside))) {
    //                             $meet_condition_for_buy = true;
    //                         }
    //                     } else {
    //                         $meet_condition_for_buy = true;
    //                     }
    //                     if ($this->calculate_ifelse($data_arr['black_wall_pressure'], $meta_value['black_wall_pressure'], $data_arr['optradio_blackwall'])) {
    //                         $blackwall = true;
    //                     }

    //                     if ($this->calculate_ifelse($data_arr['seven_level_depth'], $meta_value['seven_level_depth'], $data_arr['optradio_sevenLevel'])) {
    //                         $seven_level = true;
    //                     }

    //                     if ($this->calculate_ifelse($data_arr['market_depth_ask'], $meta_value['market_depth_ask'], $data_arr['optradio_resistance'])) {
    //                         $ask_qty = true;
    //                     }

    //                     if ($this->calculate_ifelse($data_arr['market_depth_quantity'], $meta_value['market_depth_quantity'], $data_arr['optradio_support'])) {
    //                         $bid_qty = true;
    //                     }

    //                     if ($this->calculate_ifelse($data_arr['sellers_buyers_per'], $meta_value['sellers_buyers_per'], $data_arr['optradio_t1COT'])) {
    //                         $bvs = true;
    //                     }

    //                     if ($this->calculate_ifelse($data_arr['last_qty_buy_vs_sell'], $meta_value['last_qty_buy_vs_sell'], $data_arr['optradio_t1LTCV'])) {
    //                         $lastqty = true;
    //                     }

    //                     if ($this->calculate_ifelse($data_arr['last_qty_time_ago'], $meta_value['last_qty_time_ago'], $data_arr['optradio_t1LTCT'])) {
    //                         $lasttime = true;
    //                     }
    //                     //============================================================
    //                     if ($this->calculate_ifelse($data_arr['last_qty_time_ago_15'], $meta_value['last_qty_time_ago_15'], $data_arr['optradio_t3LTC'])) {
    //                         $t3ltc = true;
    //                     }

    //                     if ($this->calculate_ifelse($data_arr['sellers_buyers_per_fifteen'], $meta_value['sellers_buyers_per_fifteen'], $data_arr['optradio_t4COT'])) {
    //                         $th4cot = true;
    //                     }

    //                     if ($this->calculate_ifelse($data_arr['bid'], $meta_value['bid'], $data_arr['optradio_bsell'])) {
    //                         $bid = true;
    //                     }

    //                     if ($this->calculate_ifelse($data_arr['ask'], $meta_value['ask'], $data_arr['optradio_bbuy'])) {
    //                         $ask = true;
    //                     }

    //                     if ($this->calculate_ifelse($data_arr['yellow_wall_pressure'], $meta_value['yellow_wall_pressure'], $data_arr['optradio_yellow'])) {
    //                         $yellowall = true;
    //                     }

    //                     if ($this->calculate_ifelse($data_arr['ask_percentage'], $meta_value['ask_percentage'], $data_arr['optradio_bigbuyers'])) {
    //                         $big_buy = true;
    //                     }
    //                     // if (empty($data_arr['black_wall_pressure']) || $data_arr['black_wall_pressure'] <= (float) $meta_value['black_wall_pressure']) {
    //                     //     $blackwall = true;
    //                     // }

    //                     // if (empty($data_arr['seven_level_depth']) || $data_arr['seven_level_depth'] <= (float) $meta_value['seven_level_depth']) {
    //                     //     $seven_level = true;
    //                     // }

    //                     // if (empty($data_arr['market_depth_ask']) || $data_arr['market_depth_ask'] >= (float) $meta_value['market_depth_ask']) {
    //                     //     $ask_qty = true;
    //                     // }

    //                     // if (empty($data_arr['market_depth']) || $data_arr['market_depth'] <= (float) $meta_value['market_depth']) {
    //                     //     $bid_qty = true;
    //                     // }

    //                     // if (empty($data_arr['sellers_buyers_per']) || $data_arr['sellers_buyers_per'] <= (float) $meta_value['sellers_buyers_per']) {
    //                     //     $bvs = true;
    //                     // }

    //                     // if (empty($data_arr['last_qty_buy_vs_sell']) || $data_arr['last_qty_buy_vs_sell'] <= (float) $meta_value['last_qty_buy_vs_sell']) {
    //                     //     $lastqty = true;
    //                     // }

    //                     // if (empty($data_arr['last_qty_time_ago']) || $data_arr['last_qty_time_ago'] >= (float) $meta_value['last_qty_time_ago']) {
    //                     //     $lasttime = true;
    //                     // }

    //                     // /////////////////////////////////////////////////////////////////////////////////////////
    //                     // if (empty($data_arr['last_qty_time_ago_15']) || $data_arr['last_qty_time_ago_15'] >= (float) $meta_value['last_qty_time_ago_15']) {
    //                     //     $t3ltc = true;
    //                     // }

    //                     // if (empty($data_arr['sellers_buyers_per_fifteen']) || $data_arr['sellers_buyers_per_fifteen'] <= (float) $meta_value['sellers_buyers_per_fifteen']) {
    //                     //     $th4cot = true;
    //                     // }

    //                     // if (empty($data_arr['bid']) || $data_arr['bid'] >= (float) $meta_value['bid']) {
    //                     //     $bid = true;
    //                     // }

    //                     // if (empty($data_arr['ask']) || $data_arr['ask'] <= (float) $meta_value['ask']) {
    //                     //     $ask = true;
    //                     // }

    //                     // if (empty($data_arr['yellow_wall_pressure']) || $data_arr['yellow_wall_pressure'] >= (float) $meta_value['yellow_wall_pressure']) {
    //                     //     $yellowall = true;
    //                     // }

    //                     // if (empty($data_arr['ask_percentage']) || $data_arr['ask_percentage'] <= (float) $meta_value['ask_percentage']) {
    //                     //     $big_buy = true;
    //                     // }

    //                     if ($candle_condition && $meet_condition_for_buy && $blackwall && $seven_level && $ask_qty && $bid_qty && $bvs && $lastqty && $lasttime && $t3ltc
    //                         && $th4cot && $bid && $ask && $yellowall && $big_buy) {
    //                         if (!array_key_exists($meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00"), $date_range_hour)) {
    //                             $date_range_hour[$meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['market_value'] = $meta_value['current_market_value'];
    //                             $date_range_hour[$meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['market_time'] = $meta_value['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //                         }
    //                     }
    //                 }
    //             } //end foreach result
    //             ////////////////////////////////////////////////////////

    //             ///////////////////////////////////////////////////////
    //         } //end for loop hours

    //         //echo "<pre>"; print_r($date_range_hour); exit;
    //         $positive = 0;
    //         $negitive = 0;
    //         $winp = 0;
    //         $losp = 0;
    //         $retArr = array();
    //         foreach ($date_range_hour as $key => $value) {
    //             $profit_time_ago = '';
    //             $los_time_ago = '';
    //             $loss = 0;
    //             $profit = 0;

    //             $market_value = $value['market_value'];
    //             $market_time = $value['market_time'];
    //             $sell_price = $value['market_value'] + ($value['market_value'] * $target_profit) / 100;
    //             $iniatial_trail_stop = $value['market_value'] - ($value['market_value'] / 100) * $target_stoploss;
    //             $where['coin'] = $symbol;
    //             $where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
    //             $where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));
    //             $where['current_market_value']['$gte'] = (float) $sell_price;

    //             $queryHours = [
    //                 ['$match' => $where],
    //                 ['$sort' => ['modified_date' => 1]],
    //                 ['$limit' => 1],
    //             ];

    //             $db = $this->mongo_db->customQuery();
    //             $response = $db->coin_meta_history->aggregate($queryHours);
    //             $row = iterator_to_array($response);
    //             $profit = 0;
    //             $profit_date = "";
    //             if (!empty($row)) {
    //                 $percentage = (($row[0]['current_market_value'] - $value['market_value']) / $row[0]['current_market_value']) * 100;
    //                 $profit = number_format($percentage, 2);
    //                 $profit_date = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //             }

    //             $where1['coin'] = $symbol;
    //             $where1['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
    //             $where1['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));

    //             $where1['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

    //             $queryHours1 =
    //                 [
    //                 ['$match' => $where1],
    //                 ['$sort' => ['modified_date' => 1]],
    //                 ['$limit' => 1],
    //             ];

    //             // $this->mongo_db->where($where);
    //             // $get = $this->mongo_db->get('coin_meta_history');
    //             $db = $this->mongo_db->customQuery();
    //             $response1 = $db->coin_meta_history->aggregate($queryHours1);
    //             $row1 = iterator_to_array($response1);
    //             $loss = 0;
    //             $loss_date = 0;
    //             if (!empty($row1)) {
    //                 $percentage = (($row1[0]['current_market_value'] - $value['market_value']) / $row1[0]['current_market_value']) * 100;
    //                 $loss = number_format($percentage, 2);
    //                 $loss_date = $row1[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //             }
    //             $retArr[$key]['market_value'] = num($market_value);
    //             $retArr[$key]['market_time'] = $market_time;
    //             if (!empty($profit_date)) {
    //                 $profit_time_ago = $this->time_elapsed_string_min($profit_date, $key); //0
    //                 $retArr[$key]['proft_test_ago'] = $profit_time_ago;
    //                 $retArr[$key]['profit_time'] = $this->time_elapsed_string($profit_date, $key);
    //                 $retArr[$key]['profit_percentage'] = $profit;
    //                 $retArr[$key]['profit_date'] = $profit_date;
    //             }
    //             if (!empty($loss_date)) {
    //                 $los_time_ago = $this->time_elapsed_string_min($loss_date, $key);
    //                 $retArr[$key]['los_test_ago'] = $los_time_ago;
    //                 $retArr[$key]['loss_time'] = $this->time_elapsed_string($loss_date, $key);
    //                 $retArr[$key]['loss_percentage'] = $loss;
    //                 $retArr[$key]['loss_date'] = $loss_date;
    //             }

    //             // if (!empty($profit_time_ago) && !empty($los_time_ago)) {

    //             //     if (($profit_time_ago > $los_time_ago)) {
    //             //         $retArr[$key]['message'] = "Got Loss";
    //             //     } else if (($profit_time_ago < $los_time_ago)) {
    //             //         $retArr[$key]['message'] = "Got Profit";
    //             //     } else {
    //             //         continue;
    //             //     }
    //             // }

    //             if ($los_time_ago == '' && $profit_time_ago == '') {
    //                 $retArr[$key]['message'] = '';
    //             }
    //             if ($los_time_ago != '' && $profit_time_ago == '') {
    //                 $retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
    //                 $negitive++;
    //                 $losp += $retArr[$key]['loss_percentage'];
    //             }
    //             if ($los_time_ago == '' && $profit_time_ago != '') {
    //                 $retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
    //                 $positive++;
    //                 $winp += $retArr[$key]['profit_percentage'];
    //             }
    //             if ($los_time_ago != '' && $profit_time_ago != '') {
    //                 if (($profit_time_ago > $los_time_ago)) {
    //                     $retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
    //                     $negitive++;
    //                     $losp += $retArr[$key]['loss_percentage'];
    //                 } else if (($profit_time_ago < $los_time_ago)) {
    //                     $retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
    //                     $positive++;
    //                     $winp += $retArr[$key]['profit_percentage'];
    //                 } else {
    //                     continue;
    //                 }
    //             }
    //         }
    //         $winning_profit = $winp;
    //         $losing_profit = $losp;

    //         $total_profit = $winning_profit + $losing_profit;

    //         $total_per_trade = $total_profit / (count($date_range_hour));

    //         $total_per_day = $total_profit / $total_days;
    //         $data['winners'] = $winning_profit;
    //         $data['losers'] = $losing_profit;
    //         $data['total_profit'] = $total_profit;
    //         $data['per_trade'] = number_format($total_per_trade, 2);
    //         $data['per_day'] = number_format($total_per_day, 2);

    //         $data['final'] = $retArr;
    //         $data['count_msg'] = count($date_range_hour);
    //         $data['positive_msg'] = $positive;
    //         $data['negitive_msg'] = $negitive;
    //         $data['positive_percentage'] = number_format(($positive / ($positive + $negitive) * 100), 2);
    //         $data['negitive_percentage'] = number_format(($negitive / ($positive + $negitive) * 100), 2);

    //         $log_data = array(
    //             'settings' => $data_arr,
    //             'symbol' => $symbol,
    //             'winning' => $positive,
    //             'losing' => $negitive,
    //             'win_per' => ($positive / ($positive + $negitive) * 100),
    //             'lose_per' => ($negitive / ($positive + $negitive) * 100),
    //             'total' => count($date_range_hour),
    //             'result' => $retArr,
    //             'created_date' => $this->mongo_db->converToMongodttime($start_date),
    //             'end_date' => $this->mongo_db->converToMongodttime($end_date),
    //         );

    //         $this->mongo_db->insert("meta_report_log", $log_data);
    //         return $data;
    //     }
    // } //meta_coin_report_test()

    // function calculate_ifelse($field, $value, $op) {
    //     if (empty($field)) {
    //         return true;
    //     } else if ($op == 'g') {
    //         if ($field <= (float) $value) {
    //             return true;
    //         }
    //     } else if ($op == 'l') {
    //         if ($field >= (float) $value) {
    //             return true;
    //         }
    //     } else {
    //         return false;
    //     }
    // }

    // public function check_candle_data($hour, $data_arr) {
    //     $search_arr['coin'] = $data_arr['filter_by_coin'];
    //     $search_arr['timestampDate'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("-1 hour", strtotime($hour))));

    //     $this->mongo_db->where($search_arr);
    //     $this->mongo_db->limit(1);
    //     $get = $this->mongo_db->get('market_chart');
    //     $row = iterator_to_array($get);
    //     $result = $row[0];
    //     $curr_high = $result['high'];
    //     $curr_low = $result['low'];
    //     $current_market_price = ($curr_high + $curr_low) / 2;
    //     $status = false;
    //     $swing = false;
    //     $type = false;
    //     $move = false;
    //     $new = false;
    //     $condition = false;

    //     if (empty($data_arr['swing_status']) || in_array($result['global_swing_status'], $data_arr['swing_status'])) {
    //         $swing = true;
    //     }

    //     if (empty($data_arr['candle_status']) || in_array($result['candel_status'], $data_arr['candle_status'])) {
    //         $status = true;

    //     }

    //     if (empty($data_arr['candle_type']) || in_array($result['candle_type'], $data_arr['candle_type'])) {
    //         $type = true;

    //     }

    //     if (empty($data_arr['move']) || $result['move'] >= $data_arr['move']) {
    //         $move = true;

    //     }
    //     if ($data_arr['candle_chk'] == 'yes') {
    //         $open = $result['last_24_hour_open'];
    //         $close = $result['last_24_hour_close'];
    //         $high = $result['last_24_hour_high'];
    //         $low = $result['last_24_hour_low'];

    //         $formula = $data_arr['formula'];
    //         if ($formula == 'highlow') {
    //             $distance = (($high - $low) / 100) * $data_arr['candle_range'];
    //             $upper_range = $high - $distance;
    //             $lower_range = $low + $distance;

    //             if ($data_arr['candle_side'] == 'up') {
    //                 if ($current_market_price >= $upper_range && $current_market_price <= $high) {$condition = true;}
    //             } else {
    //                 if ($current_market_price <= $lower_range && $current_market_price >= $low) {
    //                     $condition = true;
    //                 }
    //             }
    //         } elseif ($formula == 'openclose') {
    //             if ($open > $close) {
    //                 $big = $open;
    //                 $small = $close;
    //             } else {
    //                 $big = $close;
    //                 $small = $open;
    //             }
    //             $distance = (($open - $close) / 100) * $data_arr['candle_range'];
    //             if ($data_arr['candle_side'] == 'up') {
    //                 if ($current_market_price >= $distance && $current_market_price <= $big) {$condition = true;}
    //             } else {
    //                 if ($current_market_price <= $distance && $current_market_price >= $small) {$condition = true;}
    //             }
    //         }

    //     } else {
    //         $condition = true;
    //     }

    //     if ($status && $swing && $type && $move && $condition) {
    //         $new = true;
    //     }

    //     return $new;
    // }

    // function time_elapsed_string_min($datetime, $pre_time, $full = false) {
    //     $now = new DateTime($pre_time);
    //     $ago = new DateTime($datetime);
    //     $diff = $now->diff($ago);

    //     $diff->w = floor($diff->d / 7);
    //     $diff->d -= $diff->w * 7;
    //     $day = $diff->d;
    //     $dayc = (24 * $day) * 60;
    //     $hrs = $diff->h;
    //     $hrsc = $hrs * 60;
    //     $mins = $diff->i;
    //     $sec = $diff->s;
    //     $secc = $sec / 60;
    //     $Tmins = round($dayc + $hrsc + $mins + $secc);

    //     return $Tmins;
    // }
    // function time_elapsed_string($datetime, $pre_time, $full = false) {
    //     $now = new DateTime($pre_time);
    //     $ago = new DateTime($datetime);
    //     $diff = $now->diff($ago);

    //     $diff->w = floor($diff->d / 7);
    //     $diff->d -= $diff->w * 7;

    //     $string = array(
    //         'y' => 'year',
    //         'm' => 'month',
    //         'w' => 'week',
    //         'd' => 'day',
    //         'h' => 'hour',
    //         'i' => 'min',
    //         's' => 'sec',
    //     );
    //     foreach ($string as $k => &$v) {
    //         if ($diff->$k) {
    //             $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
    //         } else {
    //             unset($string[$k]);
    //         }
    //     }

    //     if (!$full) {
    //         $string = array_slice($string, 0, 1);
    //     }

    //     return $string ? implode(', ', $string) . '' : 'just now';
    // }

    // public function meta_coin_report_percentile() {
    //     $this->mod_login->verify_is_admin_login();
    //     // ini_set("display_errors", E_ALL);
    //     // error_reporting(E_ALL);
    //     if ($this->input->post()) {
    //         $data_arr['filter_order_data'] = $this->input->post();
    //         $this->session->set_userdata($data_arr);
    //         $final_data = $this->meta_coin_report_test($this->input->post());
    //         $data['final'] = $final_data;
    //     }
    //     $option_arr = array(
    //         "1" => "Top 1%",
    //         "2" => "Top 2%",
    //         "3" => "Top 3%",
    //         "4" => "Top 4%",
    //         "5" => "Top 5%",
    //         "10" => "Top 10%",
    //         "15" => "Top 15%",
    //         "20" => "Top 20%",
    //         "25" => "Top 25%",
    //         "-25" => "Bottom 25%",
    //         "-20" => "Bottom 20%",
    //         "-15" => "Bottom 15%",
    //         "-10" => "Bottom 10%",
    //         "-5" => "Bottom 5%",
    //         "-4" => "Bottom 4%",
    //         "-3" => "Bottom 3%",
    //         "-2" => "Bottom 2%",
    //         "-1" => "Bottom 1%",

    //     );
    //     $this->mongo_db->where(array('trigger' => 'percentile'));
    //     $sett = $this->mongo_db->get("report_setting_collection");
    //     $data['settings'] = iterator_to_array($sett);

    //     $coins = $this->mod_coins->get_all_coins();
    //     $data['coins'] = $coins;
    //     $data['options'] = $option_arr;
    //     $this->stencil->paint('admin/reports/meta_report_1', $data);
    // }

    // public function meta_coin_report_test($data_arr) {
    //     // echo "<pre>";
    //     // print_r($data_arr);
    //     // exit;
    //     // ini_set("display_errors", 1);
    //     // error_reporting(E_ALL);
    //     if ($data_arr['watch_later'] == 'yes') {
    //         $coin_arr = $data_arr['filter_by_coin'];
    //         foreach ($coin_arr as $key => $value) {
    //             $data_arr['status'] = 1;
    //             $data_arr['filter_by_coin'] = $value;
    //             $data_arr['trigger'] = 'percentile';
    //             if ($data_arr['title_to_category'] == '') {
    //                 $data_arr['title_to_category'] = 'uncatorgrized';
    //             }
    //             $admin_id = $this->session->userdata('admin_id');
    //             $username = $this->session->userdata('username');
    //             $data_arr['admin_id'] = $admin_id;
    //             $data_arr['username'] = $username;
    //             $this->mongo_db->insert("report_setting_collection", $data_arr);
    //         }
    //         return true;
    //     } else {

    //         $data_arr['status'] = 3;
    //         $data_arr['trigger'] = 'percentile';
    //         $this->mongo_db->insert("report_setting_collection", $data_arr);

    //         $symbol = $data_arr['filter_by_coin'];
    //         $start_date = $data_arr['filter_by_start_date'];
    //         $end_date = $data_arr['filter_by_end_date'];
    //         $barrier_check = $data_arr['barrier_check'];

    //         $date1 = new DateTime($start_date);
    //         $date2 = new DateTime($end_date);

    //         $diff = $date2->diff($date1);

    //         $hours = $diff->h;
    //         $hours = $hours + ($diff->days * 24);
    //         $total_days = $diff->days;
    //         $d1 = $start_date;

    //         $target_profit = $data_arr['target_profit'];
    //         $target_stoploss = $data_arr['target_stoploss'];

    //         $date_range_hour = array();
    //         for ($i = 0; $i <= $hours; $i++) {
    //             $start = date("Y-m-d H:00:00", strtotime("+" . $i . " hours", strtotime($d1)));
    //             $move = date("Y-m-d H:59:59", strtotime("+" . ($i) . " hours", strtotime($d1)));
    //             $search_arr['coin'] = $symbol;
    //             $search_arr['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($start);
    //             $search_arr['modified_date']['$lte'] = $this->mongo_db->converToMongodttime($move);

    //             $this->mongo_db->where($search_arr);
    //             $res = $this->mongo_db->get("coin_meta_history");
    //             $result = iterator_to_array($res);
    //             $barrier_val = '';

    //             $candle_condition = $this->check_candle_data($start, $data_arr);
    //             foreach ($result as $metakey => $meta_value) {
    //                 if (!empty($meta_value)) {

    //                     $blackwall = false;
    //                     $seven_level = false;
    //                     $big_buy = false;
    //                     $big_sell = false;
    //                     $t1cot = false;
    //                     $t4cot = false;
    //                     $t1ltcq = false;
    //                     $t1ltct = false;
    //                     $t3ltc = false;
    //                     $vbask = false;
    //                     $vbbid = false;
    //                     $bid = false;
    //                     $ask = false;
    //                     $meet_condition_for_buy = false;

    //                     $current_market_price = $meta_value['current_market_value'];
    //                     if ($barrier_check == 'yes') {
    //                         $barrier_range_percentage = $data_arr['barrier_range'];
    //                         $barrier_side = $data_arr['barrier_side'];
    //                         $barrier_type = $data_arr['barrier_type'];
    //                         $last_barrrier_value = "";
    //                         // $last_barrrier_value = $this->triggers_trades->list_barrier_status($symbol, 'very_strong_barrier', $current_market_price, 'down');

    //                         //%%%%%%%%%%%%%%%%%%% -- Barrier Status --%%%%%%%%%%%%%%%%%%%%%%%
    //                         $last_barrrier_value = $this->triggers_trades->list_barrier_status_simulator($symbol, $barrier_type, $current_market_price, $barrier_side, $start);

    //                         $barrier_val = $last_barrrier_value;

    //                         $barrier_value_range_upside = $last_barrrier_value + ($last_barrrier_value / 100) * $barrier_range_percentage;
    //                         $barrier_value_range_down_side = $last_barrrier_value - ($last_barrrier_value / 100) * $barrier_range_percentage;

    //                         if ((num($current_market_price) >= num($barrier_value_range_down_side)) && (num($current_market_price) <= num($barrier_value_range_upside))) {
    //                             $meet_condition_for_buy = true;
    //                         }
    //                     } else {
    //                         $meet_condition_for_buy = true;
    //                     }
    //                     if (empty($data_arr['black_wall_percentile'])) {
    //                         $blackwall = true;
    //                     } else if ($data_arr['black_wall_percentile'] > 0) {
    //                         if ($data_arr['black_wall_percentile'] >= (float) $meta_value['black_wall_percentile'] && ((float) $meta_value['black_wall_percentile'] > 0)) {
    //                             $blackwall = true;
    //                         } else {
    //                             $blackwall = false;
    //                         }

    //                     } else if ($data_arr['black_wall_percentile'] < 0) {
    //                         if ($data_arr['black_wall_percentile'] <= (float) $meta_value['black_wall_percentile'] && ((float) $meta_value['black_wall_percentile'] < 0)) {
    //                             $blackwall = true;
    //                         } else {
    //                             $blackwall = false;
    //                         }
    //                     }

    //                     if (empty($data_arr['sevenlevel_percentile'])) {
    //                         $seven_level = true;
    //                     } else if ($data_arr['sevenlevel_percentile'] > 0) {
    //                         if ($data_arr['sevenlevel_percentile'] >= (float) $meta_value['sevenlevel_percentile'] && ((float) $meta_value['sevenlevel_percentile'] > 0)) {
    //                             $seven_level = true;
    //                         } else {
    //                             $seven_level = false;
    //                         }

    //                     } else if ($data_arr['sevenlevel_percentile'] < 0) {
    //                         if ($data_arr['sevenlevel_percentile'] <= (float) $meta_value['sevenlevel_percentile'] && ((float) $meta_value['sevenlevel_percentile'] < 0)) {
    //                             $seven_level = true;
    //                         } else {
    //                             $seven_level = false;
    //                         }
    //                     }

    //                     if (empty($data_arr['big_buyers_percentile'])) {
    //                         $big_buy = true;
    //                     } else if ($data_arr['big_buyers_percentile'] > 0) {
    //                         if ($data_arr['big_buyers_percentile'] >= (float) $meta_value['big_buyers_percentile'] && ((float) $meta_value['big_buyers_percentile'] > 0)) {
    //                             $big_buy = true;
    //                         } else {
    //                             $big_buy = false;
    //                         }

    //                     } else if ($data_arr['big_buyers_percentile'] < 0) {
    //                         if ($data_arr['big_buyers_percentile'] <= (float) $meta_value['big_buyers_percentile'] && ((float) $meta_value['big_buyers_percentile'] < 0)) {
    //                             $big_buy = true;
    //                         } else {
    //                             $big_buy = false;
    //                         }
    //                     }

    //                     if (empty($data_arr['big_sellers_percentile'])) {
    //                         $big_sell = true;
    //                     } else if ($data_arr['big_sellers_percentile'] > 0) {
    //                         if ($data_arr['big_sellers_percentile'] >= (float) $meta_value['big_sellers_percentile'] && ((float) $meta_value['big_sellers_percentile'] > 0)) {
    //                             $big_sell = true;
    //                         } else {
    //                             $big_sell = false;
    //                         }

    //                     } else if ($data_arr['big_sellers_percentile'] < 0) {
    //                         if ($data_arr['big_sellers_percentile'] <= (float) $meta_value['big_sellers_percentile'] && ((float) $meta_value['big_sellers_percentile'] < 0)) {
    //                             $big_sell = true;
    //                         } else {
    //                             $big_sell = false;
    //                         }
    //                     }

    //                     if (empty($data_arr['five_buy_sell_percentile'])) {
    //                         $t1cot = true;
    //                     } else if ($data_arr['five_buy_sell_percentile'] > 0) {
    //                         if ($data_arr['five_buy_sell_percentile'] >= (float) $meta_value['five_buy_sell_percentile'] && ((float) $meta_value['five_buy_sell_percentile'] > 0)) {
    //                             $t1cot = true;
    //                         } else {
    //                             $t1cot = false;
    //                         }

    //                     } else if ($data_arr['five_buy_sell_percentile'] < 0) {
    //                         if ($data_arr['five_buy_sell_percentile'] <= (float) $meta_value['five_buy_sell_percentile'] && ((float) $meta_value['five_buy_sell_percentile'] < 0)) {
    //                             $t1cot = true;
    //                         } else {
    //                             $t1cot = false;
    //                         }
    //                     }

    //                     if (empty($data_arr['fifteen_buy_sell_percentile'])) {
    //                         $t4cot = true;
    //                     } else if ($data_arr['fifteen_buy_sell_percentile'] > 0) {
    //                         if ($data_arr['fifteen_buy_sell_percentile'] >= (float) $meta_value['fifteen_buy_sell_percentile'] && ((float) $meta_value['fifteen_buy_sell_percentile'] > 0)) {
    //                             $t4cot = true;
    //                         } else {
    //                             $t4cot = false;
    //                         }

    //                     } else if ($data_arr['fifteen_buy_sell_percentile'] < 0) {
    //                         if ($data_arr['fifteen_buy_sell_percentile'] <= (float) $meta_value['fifteen_buy_sell_percentile'] && ((float) $meta_value['fifteen_buy_sell_percentile'] < 0)) {
    //                             $t4cot = true;
    //                         } else {
    //                             $t4cot = false;
    //                         }
    //                     }

    //                     if (empty($data_arr['last_qty_buy_sell_percentile'])) {
    //                         $t1ltcq = true;
    //                     } else if ($data_arr['last_qty_buy_sell_percentile'] > 0) {
    //                         if ($data_arr['last_qty_buy_sell_percentile'] >= (float) $meta_value['last_qty_buy_sell_percentile'] && ((float) $meta_value['last_qty_buy_sell_percentile'] > 0)) {
    //                             $t1ltcq = true;
    //                         } else {
    //                             $t1ltcq = false;
    //                         }

    //                     } else if ($data_arr['last_qty_buy_sell_percentile'] < 0) {
    //                         if ($data_arr['last_qty_buy_sell_percentile'] <= (float) $meta_value['last_qty_buy_sell_percentile'] && ((float) $meta_value['last_qty_buy_sell_percentile'] < 0)) {
    //                             $t1ltcq = true;
    //                         } else {
    //                             $t1ltcq = false;
    //                         }
    //                     }

    //                     if (empty($data_arr['last_qty_time_percentile'])) {
    //                         $t1ltct = true;
    //                     } else if ($data_arr['last_qty_time_percentile'] > 0) {
    //                         if ($data_arr['last_qty_time_percentile'] >= (float) $meta_value['last_qty_time_percentile'] && ((float) $meta_value['last_qty_time_percentile'] > 0)) {
    //                             $t1ltct = true;
    //                         } else {
    //                             $t1ltct = false;
    //                         }

    //                     } else if ($data_arr['last_qty_time_percentile'] < 0) {
    //                         if ($data_arr['last_qty_time_percentile'] <= (float) $meta_value['last_qty_time_percentile'] && ((float) $meta_value['last_qty_time_percentile'] < 0)) {
    //                             $t1ltct = true;
    //                         } else {
    //                             $t1ltct = false;
    //                         }
    //                     }

    //                     if (empty($data_arr['last_qty_time_fif_percentile'])) {
    //                         $t3ltc = true;
    //                     } else if ($data_arr['last_qty_time_fif_percentile'] > 0) {
    //                         if ($data_arr['last_qty_time_fif_percentile'] >= (float) $meta_value['last_qty_time_fif_percentile'] && ((float) $meta_value['last_qty_time_fif_percentile'] > 0)) {
    //                             $t3ltc = true;
    //                         } else {
    //                             $t3ltc = false;
    //                         }

    //                     } else if ($data_arr['last_qty_time_fif_percentile'] < 0) {
    //                         if ($data_arr['last_qty_time_fif_percentile'] <= (float) $meta_value['last_qty_time_fif_percentile'] && ((float) $meta_value['last_qty_time_fif_percentile'] < 0)) {
    //                             $t3ltc = true;
    //                         } else {
    //                             $t3ltc = false;
    //                         }
    //                     }

    //                     if (empty($data_arr['virtual_barrier_percentile_ask'])) {
    //                         $vbask = true;
    //                     } else if ($data_arr['virtual_barrier_percentile_ask'] > 0) {
    //                         if ($data_arr['virtual_barrier_percentile_ask'] >= (float) $meta_value['virtual_barrier_percentile_ask'] && ((float) $meta_value['virtual_barrier_percentile_ask'] > 0)) {
    //                             $vbask = true;
    //                         } else {
    //                             $vbask = false;
    //                         }

    //                     } else if ($data_arr['virtual_barrier_percentile_ask'] < 0) {
    //                         if ($data_arr['virtual_barrier_percentile_ask'] <= (float) $meta_value['virtual_barrier_percentile_ask'] && ((float) $meta_value['virtual_barrier_percentile_ask'] < 0)) {
    //                             $vbask = true;
    //                         } else {
    //                             $vbask = false;
    //                         }
    //                     }

    //                     if (empty($data_arr['virtual_barrier_percentile'])) {
    //                         $vbbid = true;
    //                     } else if ($data_arr['virtual_barrier_percentile'] > 0) {
    //                         if ($data_arr['virtual_barrier_percentile'] >= (float) $meta_value['virtual_barrier_percentile'] && ((float) $meta_value['virtual_barrier_percentile'] > 0)) {
    //                             $vbbid = true;
    //                         } else {
    //                             $vbbid = false;
    //                         }

    //                     } else if ($data_arr['virtual_barrier_percentile'] < 0) {
    //                         if ($data_arr['virtual_barrier_percentile'] <= (float) $meta_value['virtual_barrier_percentile'] && ((float) $meta_value['virtual_barrier_percentile'] < 0)) {
    //                             $vbbid = true;
    //                         } else {
    //                             $vbbid = false;
    //                         }
    //                     }
    //                     if (empty($data_arr['bid_percentile'])) {
    //                         $bid = true;
    //                     } else if ($data_arr['bid_percentile'] > 0) {
    //                         if ($data_arr['bid_percentile'] >= (float) $meta_value['bid_percentile'] && ((float) $meta_value['bid_percentile'] > 0)) {
    //                             $bid = true;
    //                         } else {
    //                             $bid = false;
    //                         }

    //                     } else if ($data_arr['bid_percentile'] < 0) {
    //                         if ($data_arr['bid_percentile'] <= (float) $meta_value['bid_percentile'] && ((float) $meta_value['bid_percentile'] < 0)) {
    //                             $bid = true;
    //                         } else {
    //                             $bid = false;
    //                         }
    //                     }

    //                     if (empty($data_arr['ask_percentile'])) {
    //                         $ask = true;
    //                     } else if ($data_arr['ask_percentile'] > 0) {
    //                         if ($data_arr['ask_percentile'] >= (float) $meta_value['ask_percentile'] && ((float) $meta_value['ask_percentile'] > 0)) {
    //                             $ask = true;
    //                         } else {
    //                             $ask = false;
    //                         }

    //                     } else if ($data_arr['ask_percentile'] < 0) {
    //                         if ($data_arr['ask_percentile'] <= (float) $meta_value['ask_percentile'] && ((float) $meta_value['ask_percentile'] < 0)) {
    //                             $ask = true;
    //                         } else {
    //                             $ask = false;
    //                         }
    //                     }

    //                     if ($candle_condition && $blackwall && $seven_level && $big_buy && $big_sell && $t1cot && $t4cot && $t1ltcq && $t1ltct && $t3ltc && $vbask && $vbbid && $bid && $ask && $meet_condition_for_buy) {
    //                         if (!array_key_exists($meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00"), $date_range_hour)) {
    //                             $date_range_hour[$meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['market_value'] = $meta_value['current_market_value'];
    //                             $date_range_hour[$meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['market_time'] = $meta_value['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //                             $date_range_hour[$meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['barrier_value'] = $barrier_val;
    //                         }
    //                     }
    //                 }
    //             } //end foreach result
    //             ////////////////////////////////////////////////////////

    //             ///////////////////////////////////////////////////////
    //         } //end for loop hours
    //         $positive = 0;
    //         $negitive = 0;
    //         $winp = 0;
    //         $losp = 0;
    //         $retArr = array();
    //         foreach ($date_range_hour as $key => $value) {

    //             $market_value = $value['market_value'];
    //             $market_time = $value['market_time'];
    //             $deep_price_check = $data_arr['deep_price_check'];
    //             $deep_price_lookup_in_hours = $data_arr['deep_price_lookup_in_hours'];
    //             $opp_chk = $data_arr['opp_chk'];
    //             $is_opp = $this->check_real_oppurtunity($market_value, $market_time, $deep_price_check, $deep_price_lookup_in_hours, $symbol, $opp_chk);

    //             if ($is_opp) {

    //                 $profit_time_ago = '';
    //                 $los_time_ago = '';
    //                 $loss = 0;
    //                 $profit = 0;
    //                 $market_value = $value['market_value'];
    //                 $market_time = $value['market_time'];
    //                 $barrier = $value['barrier_value'];
    //                 $sell_price = $value['market_value'] + ($value['market_value'] * $target_profit) / 100;
    //                 $deep_price = $market_value - ($market_value / 100) * $deep_price_check;

    //                 $where['coin'] = $symbol;
    //                 $where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
    //                 $where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $deep_price_lookup_in_hours . " hours", strtotime($market_time))));
    //                 $where['current_market_value']['$lte'] = (float) $deep_price;

    //                 $queryHours = [
    //                     ['$match' => $where],
    //                     ['$sort' => ['modified_date' => 1]],
    //                     ['$limit' => 1],
    //                 ];

    //                 $db = $this->mongo_db->customQuery();
    //                 $response = $db->coin_meta_history->aggregate($queryHours);
    //                 $row = iterator_to_array($response);

    //                 if (!empty($row[0])) {
    //                     $timep = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //                 } else {
    //                     $timep = $market_time;
    //                 }

    //                 $iniatial_trail_stop = $value['market_value'] - ($value['market_value'] / 100) * $target_stoploss;
    //                 $where['coin'] = $symbol;
    //                 $where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($timep);
    //                 $where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $deep_price_lookup_in_hours . " hours", strtotime($timep))));
    //                 $where['current_market_value']['$gte'] = (float) $sell_price;

    //                 $queryHours = [
    //                     ['$match' => $where],
    //                     ['$sort' => ['modified_date' => 1]],
    //                     ['$limit' => 1],
    //                 ];

    //                 $db = $this->mongo_db->customQuery();
    //                 $response = $db->coin_meta_history->aggregate($queryHours);
    //                 $row = iterator_to_array($response);
    //                 $profit = 0;
    //                 $profit_date = "";
    //                 if (!empty($row)) {
    //                     $percentage = (($row[0]['current_market_value'] - $value['market_value']) / $row[0]['current_market_value']) * 100;
    //                     $profit = number_format($percentage, 2);
    //                     $profit_date = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //                 }

    //                 $where1['coin'] = $symbol;
    //                 $where1['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
    //                 $where1['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));

    //                 $where1['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

    //                 $queryHours1 =
    //                     [
    //                     ['$match' => $where1],
    //                     ['$sort' => ['modified_date' => 1]],
    //                     ['$limit' => 1],
    //                 ];

    //                 // $this->mongo_db->where($where);
    //                 // $get = $this->mongo_db->get('coin_meta_history');
    //                 $db = $this->mongo_db->customQuery();
    //                 $response1 = $db->coin_meta_history->aggregate($queryHours1);
    //                 $row1 = iterator_to_array($response1);
    //                 $loss = 0;
    //                 $loss_date = 0;
    //                 if (!empty($row1)) {
    //                     $percentage = (($row1[0]['current_market_value'] - $value['market_value']) / $row1[0]['current_market_value']) * 100;
    //                     $loss = number_format($percentage, 2);
    //                     $loss_date = $row1[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //                 }
    //                 $retArr[$key]['market_value'] = num($market_value);
    //                 $retArr[$key]['market_time'] = $market_time;
    //                 $retArr[$key]['barrier'] = num($barrier);
    //                 if (!empty($profit_date)) {
    //                     $profit_time_ago = $this->time_elapsed_string_min($profit_date, $key); //0
    //                     $retArr[$key]['proft_test_ago'] = $profit_time_ago;
    //                     $retArr[$key]['profit_time'] = $this->time_elapsed_string($profit_date, $key);
    //                     $retArr[$key]['profit_percentage'] = $profit;
    //                     $retArr[$key]['profit_date'] = $profit_date;
    //                 }
    //                 if (!empty($loss_date)) {
    //                     $los_time_ago = $this->time_elapsed_string_min($loss_date, $key);
    //                     $retArr[$key]['los_test_ago'] = $los_time_ago;
    //                     $retArr[$key]['loss_time'] = $this->time_elapsed_string($loss_date, $key);
    //                     $retArr[$key]['loss_percentage'] = $loss;
    //                     $retArr[$key]['loss_date'] = $loss_date;
    //                 }

    //                 // if (!empty($profit_time_ago) && !empty($los_time_ago)) {

    //                 //     if (($profit_time_ago > $los_time_ago)) {
    //                 //         $retArr[$key]['message'] = "Got Loss";
    //                 //     } else if (($profit_time_ago < $los_time_ago)) {
    //                 //         $retArr[$key]['message'] = "Got Profit";
    //                 //     } else {
    //                 //         continue;
    //                 //     }
    //                 // }

    //                 if ($los_time_ago == '' && $profit_time_ago == '') {
    //                     $retArr[$key]['message'] = '';
    //                 }
    //                 if ($los_time_ago != '' && $profit_time_ago == '') {
    //                     $retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
    //                     $negitive++;
    //                     $losp += $retArr[$key]['loss_percentage'];
    //                 }
    //                 if ($los_time_ago == '' && $profit_time_ago != '') {
    //                     $retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
    //                     $positive++;
    //                     $winp += $retArr[$key]['profit_percentage'];
    //                 }
    //                 if ($los_time_ago != '' && $profit_time_ago != '') {
    //                     if (($profit_time_ago > $los_time_ago)) {
    //                         $retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
    //                         $negitive++;
    //                         $losp += $retArr[$key]['loss_percentage'];
    //                     } else if (($profit_time_ago < $los_time_ago)) {
    //                         $retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
    //                         $positive++;
    //                         $winp += $retArr[$key]['profit_percentage'];
    //                     } else {
    //                         continue;
    //                     }
    //                 }

    //             } else {

    //                 $profit_time_ago = '';
    //                 $los_time_ago = '';
    //                 $loss = 0;
    //                 $profit = 0;

    //                 $market_value = $value['market_value'];
    //                 $market_time = $value['market_time'];
    //                 $barrier = $value['barrier_value'];
    //                 $sell_price = $value['market_value'] + ($value['market_value'] * $target_profit) / 100;
    //                 $iniatial_trail_stop = $value['market_value'] - ($value['market_value'] / 100) * $target_stoploss;
    //                 $where['coin'] = $symbol;
    //                 $where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
    //                 $where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));
    //                 $where['current_market_value']['$gte'] = (float) $sell_price;

    //                 $queryHours = [
    //                     ['$match' => $where],
    //                     ['$sort' => ['modified_date' => 1]],
    //                     ['$limit' => 1],
    //                 ];

    //                 $db = $this->mongo_db->customQuery();
    //                 $response = $db->coin_meta_history->aggregate($queryHours);
    //                 $row = iterator_to_array($response);
    //                 $profit = 0;
    //                 $profit_date = "";
    //                 if (!empty($row)) {
    //                     $percentage = (($row[0]['current_market_value'] - $value['market_value']) / $row[0]['current_market_value']) * 100;
    //                     $profit = number_format($percentage, 2);
    //                     $profit_date = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //                 }

    //                 $where1['coin'] = $symbol;
    //                 $where1['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
    //                 $where1['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));

    //                 $where1['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

    //                 $queryHours1 =
    //                     [
    //                     ['$match' => $where1],
    //                     ['$sort' => ['modified_date' => 1]],
    //                     ['$limit' => 1],
    //                 ];

    //                 // $this->mongo_db->where($where);
    //                 // $get = $this->mongo_db->get('coin_meta_history');
    //                 $db = $this->mongo_db->customQuery();
    //                 $response1 = $db->coin_meta_history->aggregate($queryHours1);
    //                 $row1 = iterator_to_array($response1);
    //                 $loss = 0;
    //                 $loss_date = 0;
    //                 if (!empty($row1)) {
    //                     $percentage = (($row1[0]['current_market_value'] - $value['market_value']) / $row1[0]['current_market_value']) * 100;
    //                     $loss = number_format($percentage, 2);
    //                     $loss_date = $row1[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //                 }
    //                 $retArr[$key]['market_value'] = num($market_value);
    //                 $retArr[$key]['market_time'] = $market_time;
    //                 $retArr[$key]['barrier'] = num($barrier);
    //                 if (!empty($profit_date)) {
    //                     $profit_time_ago = $this->time_elapsed_string_min($profit_date, $key); //0
    //                     $retArr[$key]['proft_test_ago'] = $profit_time_ago;
    //                     $retArr[$key]['profit_time'] = $this->time_elapsed_string($profit_date, $key);
    //                     $retArr[$key]['profit_percentage'] = $profit;
    //                     $retArr[$key]['profit_date'] = $profit_date;
    //                 }
    //                 if (!empty($loss_date)) {
    //                     $los_time_ago = $this->time_elapsed_string_min($loss_date, $key);
    //                     $retArr[$key]['los_test_ago'] = $los_time_ago;
    //                     $retArr[$key]['loss_time'] = $this->time_elapsed_string($loss_date, $key);
    //                     $retArr[$key]['loss_percentage'] = $loss;
    //                     $retArr[$key]['loss_date'] = $loss_date;
    //                 }

    //                 // if (!empty($profit_time_ago) && !empty($los_time_ago)) {

    //                 //     if (($profit_time_ago > $los_time_ago)) {
    //                 //         $retArr[$key]['message'] = "Got Loss";
    //                 //     } else if (($profit_time_ago < $los_time_ago)) {
    //                 //         $retArr[$key]['message'] = "Got Profit";
    //                 //     } else {
    //                 //         continue;
    //                 //     }
    //                 // }

    //                 if ($los_time_ago == '' && $profit_time_ago == '') {
    //                     $retArr[$key]['message'] = '';
    //                 }
    //                 if ($los_time_ago != '' && $profit_time_ago == '') {
    //                     $retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
    //                     $negitive++;
    //                     $losp += $retArr[$key]['loss_percentage'];
    //                 }
    //                 if ($los_time_ago == '' && $profit_time_ago != '') {
    //                     $retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
    //                     $positive++;
    //                     $winp += $retArr[$key]['profit_percentage'];
    //                 }
    //                 if ($los_time_ago != '' && $profit_time_ago != '') {
    //                     if (($profit_time_ago > $los_time_ago)) {
    //                         $retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
    //                         $negitive++;
    //                         $losp += $retArr[$key]['loss_percentage'];
    //                     } else if (($profit_time_ago < $los_time_ago)) {
    //                         $retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
    //                         $positive++;
    //                         $winp += $retArr[$key]['profit_percentage'];
    //                     } else {
    //                         continue;
    //                     }
    //                 }

    //             }
    //         }
    //         $winning_profit = $winp;
    //         $losing_profit = $losp;

    //         $total_profit = $winning_profit + $losing_profit;

    //         $total_per_trade = $total_profit / (count($date_range_hour));

    //         $total_per_day = $total_profit / $total_days;

    //         $data['winners'] = $winning_profit;
    //         $data['losers'] = $losing_profit;
    //         $data['total_profit'] = $total_profit;
    //         $data['per_trade'] = number_format($total_per_trade, 2);
    //         $data['per_day'] = number_format($total_per_day, 2);

    //         $data['final'] = $retArr;
    //         $data['count_msg'] = count($date_range_hour);
    //         $data['positive_msg'] = $positive;
    //         $data['negitive_msg'] = $negitive;
    //         $data['positive_percentage'] = number_format(($positive / ($positive + $negitive) * 100), 2);
    //         $data['negitive_percentage'] = number_format(($negitive / ($positive + $negitive) * 100), 2);
    //         $log_data = array(
    //             'settings' => $data_arr,
    //             'symbol' => $symbol,
    //             'winning' => $positive,
    //             'losing' => $negitive,
    //             'win_per' => ($positive / ($positive + $negitive) * 100),
    //             'lose_per' => ($negitive / ($positive + $negitive) * 100),
    //             'total' => count($date_range_hour),
    //             'result' => $retArr,
    //             'created_date' => $this->mongo_db->converToMongodttime($start_date),
    //             'end_date' => $this->mongo_db->converToMongodttime($end_date),
    //         );

    //         $log_data['winners'] = $winning_profit;
    //         $log_data['losers'] = $losing_profit;
    //         $log_data['total_profit'] = $total_profit;
    //         $log_data['per_trade'] = $total_per_trade;
    //         $log_data['per_day'] = $total_per_day;

    //         $this->mongo_db->insert("percentile_report_log", $log_data);

    //         return $data;
    //     }

    // } //meta_coin_report_test()

    // public function check_real_oppurtunity($market_value, $market_time, $deep_price_check, $deep_price_lookup_in_hours, $symbol, $opp_chk) {
    //     if ($opp_chk) {
    //         $iniatial_trail_stop = $market_value - ($market_value / 100) * $deep_price_check;
    //         $where['coin'] = $symbol;
    //         $where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
    //         $where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $deep_price_lookup_in_hours . " hours", strtotime($market_time))));
    //         $where['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

    //         $queryHours = [
    //             ['$match' => $where],
    //             ['$sort' => ['modified_date' => 1]],
    //             ['$limit' => 1],
    //         ];

    //         $db = $this->mongo_db->customQuery();
    //         $response = $db->coin_meta_history->aggregate($queryHours);
    //         $row = iterator_to_array($response);

    //         if (count($row) > 0) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     }
    // }

    // public function trigger_report_listing() {
    //     $this->mod_login->verify_is_admin_login();
    //     if (isset($_GET['trigger']) && $_GET['trigger'] == 'barrier') {
    //         $this->mongo_db->where(array("trigger" => 'barrier'));
    //     } elseif (isset($_GET['trigger']) && $_GET['trigger'] == 'percentile') {
    //         $this->mongo_db->where(array("trigger" => 'percentile'));
    //     } else {
    //         $this->mongo_db->where(array("status" => 1));
    //     }

    //     $this->mongo_db->order_by(array('_id' => -1));
    //     $get = $this->mongo_db->get("report_setting_collection");
    //     $iter = iterator_to_array($get);
    //     $data['setting'] = $iter;
    //     $this->stencil->paint('admin/reports/setting', $data);
    // }

    // public function settings_report_listing() {

    //     // ini_set("display_errors", E_ALL);
    //     // error_reporting(E_ALL);

    //     $this->mod_login->verify_is_admin_login();

    //     if (!empty($this->input->post('filter_by_coin'))) {
    //         $search_arr['symbol'] = $this->input->post('filter_by_coin');
    //     }

    //     if (!empty($this->input->post('filter_by_name'))) {
    //         $search_arr['settings.title_to_filter'] = $this->input->post('filter_by_name');
    //     }

    //     if (!empty($this->input->post('filter_by_days'))) {
    //         $search_arr['total_number_of_days']['$gte'] = (int) $this->input->post('filter_by_days');
    //     }

    //     if (!empty($this->input->post('filter_by_admin'))) {
    //         $search_arr['settings.admin_id'] = (string) $this->input->post('filter_by_admin');
    //     }

    //     if (!empty($this->input->post('filter_by_percentage'))) {
    //         $search_arr['win_per']['$gte'] = (float) $this->input->post('filter_by_percentage');
    //     }

    //     if (!empty($this->input->post('filter_by_profit'))) {
    //         $search_arr['settings.target_profit']['$gte'] = $this->input->post('filter_by_profit');
    //     }

    //     if (!empty($this->input->post('filter_by_loss'))) {
    //         $search_arr['settings.target_stoploss']['$gte'] = $this->input->post('filter_by_loss');
    //     }

    //     if (!empty($this->input->post('filter_by_start_date')) && !empty($this->input->post('filter_by_end_date'))) {
    //         $created_datetime = date('Y-m-d G:i:s', strtotime($this->input->post('filter_by_start_date')));
    //         $orig_date = new DateTime($created_datetime);
    //         $orig_date = $orig_date->getTimestamp();
    //         $start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

    //         $created_datetime22 = date('Y-m-d G:i:s', strtotime($this->input->post('filter_by_end_date')));
    //         $orig_date22 = new DateTime($created_datetime22);
    //         $orig_date22 = $orig_date22->getTimestamp();
    //         $end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
    //         $search_arr['current_date'] = array('$gte' => $start_date, '$lte' => $end_date);
    //     }

    //     if (isset($_GET['order'])) {
    //         $sort_field = $_GET['order'];
    //         if (isset($_GET['type'])) {
    //             if ($_GET['type'] == 'ASC') {
    //                 $sort = 1;
    //             } else {
    //                 $sort = -1;
    //             }
    //             $sort_arr[$sort_field] = $sort;
    //         } else {
    //             $sort_arr[$sort_field] = -1;
    //         }
    //     } else {
    //         $sort_arr['_id'] = -1;
    //     }

    //     if (isset($_GET['trigger']) && $_GET['trigger'] == 'barrier') {
    //         // $this->mongo_db->where(array("settings.trigger" => 'barrier'));
    //         $search_arr['settings.trigger'] = 'barrier';
    //     } elseif (isset($_GET['trigger']) && $_GET['trigger'] == 'percentile') {
    //         //$this->mongo_db->where(array("settings.trigger" => 'percentile'));
    //         $search_arr['settings.trigger'] = 'percentile';
    //     }
    //     // echo "<pre>";
    //     // print_r($this->input->post());
    //     // print_r($search_arr);
    //     // exit;
    //     //////////////////////////////////////////////////////////////////////////////////////////////
    //     //Pagination Code//
    //     $this->load->library("pagination");

    //     $db = $this->mongo_db->customQuery();
    //     $count = $db->meta_coin_report_results->count($search_arr);
    //     $config = array();
    //     $config["base_url"] = SURL . "admin/reports/settings_report_listing";
    //     $config["total_rows"] = $count;
    //     $config['per_page'] = 20;
    //     $config['num_links'] = 5;
    //     $config['use_page_numbers'] = TRUE;
    //     $config['uri_segment'] = 4;
    //     $config['reuse_query_string'] = TRUE;
    //     $config["first_tag_open"] = '<li>';
    //     $config["first_tag_close"] = '</li>';
    //     $config["last_tag_open"] = '<li>';
    //     $config["last_tag_close"] = '</li>';
    //     $config['next_link'] = '&raquo;';
    //     $config['next_tag_open'] = '<li>';
    //     $config['next_tag_close'] = '</li>';
    //     $config['prev_link'] = '&laquo;';
    //     $config['prev_tag_open'] = '<li>';
    //     $config['prev_tag_close'] = '</li>';
    //     $config['first_link'] = 'First';
    //     $config['last_link'] = 'Last';
    //     $config['full_tag_open'] = '<ul class="pagination">';
    //     $config['full_tag_close'] = '</ul>';
    //     $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
    //     $config['cur_tag_close'] = '</b></a></li>';
    //     $config['num_tag_open'] = '<li>';
    //     $config['num_tag_close'] = '</li>';
    //     $this->pagination->initialize($config);
    //     $page = $this->uri->segment(4);
    //     if (!isset($page)) {$page = 1;}
    //     $start = ($page - 1) * $config["per_page"];
    //     $page_links = $this->pagination->create_links();
    //     $data['page_links'] = $page_links;

    //     ////////////////////////////End Pagination Code///////////////////////////////////////////////
    //     /////////////////////////////////////////////////////////////////////////////////////////////

    //     $qr = array('skip' => $start, 'limit' => $config['per_page'], 'sort' => $sort_arr);
    //     // $this->mongo_db->where($search_arr);
    //     // $this->mongo_db->order_by(array('_id' => -1));
    //     // $this->mongo_db->limit($config['per_page']);
    //     // $get = $this->mongo_db->get("meta_coin_report_results");
    //     $db = $this->mongo_db->customQuery();
    //     $get = $db->meta_coin_report_results->find($search_arr, $qr);

    //     $iter = iterator_to_array($get);

    //     // if ($this->input->post()) {
    //     //     echo "<pre>";
    //     //     print_r($iter);
    //     //     exit;
    //     // }

    //     $data['setting'] = $iter;
    //     $data['filter_user_data'] = $this->input->post();
    //     $coins = $this->mod_coins->get_all_coins();
    //     $data['coins'] = $coins;
    //     $data['admins'] = $this->get_all_admins();
    //     $this->stencil->paint('admin/reports/setting_report', $data);
    // }

    // public function get_report_from_setting($setting_id) {
    //     $this->mongo_db->where(array('setting_id' => $this->mongo_db->mongoId($setting_id)));
    //     $get = $this->mongo_db->get("meta_coin_report_results");
    //     $iter = iterator_to_array($get);

    //     $data['final'] = $iter[0]['result'];
    //     $this->stencil->paint("admin/reports/new_report", $data);

    // }

    // public function get_all_admins() {
    //     $search['user_role']['$in'] = array('1', 1);
    //     $this->mongo_db->where($search);
    //     $rest = $this->mongo_db->get("users");

    //     $arr = iterator_to_array($rest);
    //     //$arr[0] = ['test1' => "test1", 'test2' => "tes2t", 'test3' => "tes3t"];
    //     return $arr;
    // }

    // public function delete_setting($value = '') {
    //     $this->mongo_db->where(array("setting_id" => $this->mongo_db->mongoId($value)));
    //     $this->mongo_db->delete("meta_coin_report_results");

    //     $this->mongo_db->where(array("_id" => $this->mongo_db->mongoId($value)));
    //     $this->mongo_db->delete("report_setting_collection");

    //     redirect($_SERVER['HTTP_REFERER']);
    // }

    // public function rest_filters_meta() {

    //     $value = $this->input->post('value');

    //     $trigger = $this->input->post('trigger');

    //     $this->mongo_db->where(array("_id" => $this->mongo_db->mongoId($value), 'trigger' => $trigger));
    //     $rest = $this->mongo_db->get("report_setting_collection");

    //     $arr = iterator_to_array($rest);
    //     //$arr[0] = ['test1' => "test1", 'test2' => "tes2t", 'test3' => "tes3t"];
    //     echo json_encode($arr[0]);
    //     exit;
    // }

    // public function rest_filters_meta_filter() {

    //     $value = $this->input->post('value');

    //     $trigger = $this->input->post('trigger');

    //     $this->mongo_db->where(array("_id" => $this->mongo_db->mongoId($value), 'trigger' => $trigger));
    //     $rest = $this->mongo_db->get("report_setting_collection");

    //     $arr = iterator_to_array($rest);
    //     //$arr[0] = ['test1' => "test1", 'test2' => "tes2t", 'test3' => "tes3t"];
    //     echo json_encode($arr[0]);
    //     exit;
    // }

    // public function myrun() {
    //     $key = '2019-03-19 17:00:00';
    //     $symbol = "ZENBTC";
    //     $target_profit = 1;
    //     $target_stoploss = 2.5;
    //     $value['market_value'] = '0.00167';
    //     $value['market_time'] = '2019-03-19 17:11:00';
    //     $data_arr['lookup_period'] = 2000;
    //     $profit_time_ago = '';
    //     $los_time_ago = '';
    //     $loss = 0;
    //     $profit = 0;

    //     $market_value = $value['market_value'];
    //     $market_time = $value['market_time'];
    //     $barrier = $value['barrier_value'];
    //     echo $sell_price = $value['market_value'] + ($value['market_value'] * $target_profit) / 100;
    //     echo "<br>";
    //     echo $iniatial_trail_stop = $value['market_value'] - ($value['market_value'] / 100) * $target_stoploss;
    //     $where['coin'] = $symbol;
    //     $where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
    //     $where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));
    //     $where['current_market_value']['$gte'] = (float) $sell_price;

    //     $queryHours = [
    //         ['$match' => $where],
    //         ['$sort' => ['modified_date' => 1]],
    //         ['$limit' => 1],
    //     ];

    //     $db = $this->mongo_db->customQuery();
    //     $response = $db->coin_meta_history->aggregate($queryHours);
    //     $row = iterator_to_array($response);
    //     $profit = 0;
    //     $profit_date = "";
    //     if (!empty($row)) {
    //         $percentage = (($row[0]['current_market_value'] - $value['market_value']) / $row[0]['current_market_value']) * 100;
    //         $profit = number_format($percentage, 2);
    //         $profit_date = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //     }

    //     $where1['coin'] = $symbol;
    //     $where1['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
    //     $where1['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));

    //     $where1['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

    //     $queryHours1 =
    //         [
    //         ['$match' => $where1],
    //         ['$sort' => ['modified_date' => 1]],
    //         ['$limit' => 1],
    //     ];
    //     $db = $this->mongo_db->customQuery();
    //     $response1 = $db->coin_meta_history->aggregate($queryHours1);
    //     $row1 = iterator_to_array($response1);
    //     $loss = 0;
    //     $loss_date = 0;
    //     if (!empty($row1)) {
    //         $percentage = (($row1[0]['current_market_value'] - $value['market_value']) / $row1[0]['current_market_value']) * 100;
    //         $loss = number_format($percentage, 2);
    //         $loss_date = $row1[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //     }

    //     $retArr[$key]['market_value'] = num($market_value);
    //     $retArr[$key]['market_time'] = $market_time;
    //     $retArr[$key]['barrier'] = $barrier;
    //     if (!empty($profit_date)) {
    //         $profit_time_ago = $this->time_elapsed_string_min($profit_date, $key); //0
    //         $retArr[$key]['proft_test_ago'] = $profit_time_ago;
    //         $retArr[$key]['profit_time'] = $this->time_elapsed_string($profit_date, $key);
    //         $retArr[$key]['profit_percentage'] = $profit;
    //         $retArr[$key]['profit_date'] = $profit_date;
    //     }
    //     if (!empty($loss_date)) {
    //         $los_time_ago = $this->time_elapsed_string_min($loss_date, $key);
    //         $retArr[$key]['los_test_ago'] = $los_time_ago;
    //         $retArr[$key]['loss_time'] = $this->time_elapsed_string($loss_date, $key);
    //         $retArr[$key]['loss_percentage'] = $loss;
    //         $retArr[$key]['loss_date'] = $loss_date;
    //     }

    //     if ($los_time_ago == '' && $profit_time_ago == '') {
    //         $retArr[$key]['message'] = '';
    //     }
    //     if ($los_time_ago != '' && $profit_time_ago == '') {
    //         $retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
    //         $negitive++;
    //         $losp += $retArr[$key]['loss_percentage'];
    //     }
    //     if ($los_time_ago == '' && $profit_time_ago != '') {
    //         $retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
    //         $positive++;
    //         $winp += $retArr[$key]['profit_percentage'];
    //     }
    //     if ($los_time_ago != '' && $profit_time_ago != '') {
    //         if (($profit_time_ago > $los_time_ago)) {
    //             $retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
    //             $negitive++;
    //             $losp += $retArr[$key]['loss_percentage'];
    //         } else if (($profit_time_ago < $los_time_ago)) {
    //             $retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
    //             $positive++;
    //             $winp += $retArr[$key]['profit_percentage'];
    //         } else {
    //         }
    //     }

    //     echo "<pre>";
    //     print_r($retArr);
    //     exit;
    // }

    // public function rule_trigger_value() {
    //     if ($this->input->post()) {
    //         // ini_set("display_errors", E_ALL);
    //         // error_reporting(E_ALL);
    //         $data_arr['filter_order_data'] = $this->input->post();
    //         $this->session->set_userdata($data_arr);

    //         $start_date = $this->input->post('filter_by_start_date');
    //         $end_date = $this->input->post('filter_by_end_date');
    //         $symbol = $this->input->post('filter_by_coin');
    //         $trigger = $this->input->post('filter_by_trigger');

    //         $search_arr['symbol'] = $symbol;
    //         $search_arr['trigger_type'] = $trigger;
    //         $search_arr['order_mode'] = 'test_live';
    //         $search_arr['created_date']['$gte'] = $this->mongo_db->converToMongodttime($start_date);
    //         $search_arr['created_date']['$lte'] = $this->mongo_db->converToMongodttime($end_date);

    //         // $this->mongo_db->where($search_arr);
    //         // $this->mongo_db->limit(500);
    //         // $iterator = $this->mongo_db->get("sold_buy_orders");

    //         $queryHours =
    //             [
    //             ['$match' => $search_arr],
    //             ['$group' => ['_id' => [
    //                 'hour' => ['$hour' => '$created_date'],
    //                 'minute' => ['$minute' => '$created_date'],
    //             ], 'application_mode' => ['$last' => '$application_mode'], 'created_date' => ['$last' => '$created_date'], 'trigger_type' => ['$last' => '$trigger_type'], 'buy_rule_number' => ['$last' => '$buy_rule_number'], 'order_level' => ['$last' => '$order_level'], 'symbol' => ['$last' => '$symbol'], 'id' => ['$last' => '$_id']]],
    //             ['$sort' => ['created_date' => -1]],
    //         ];

    //         $db = $this->mongo_db->customQuery();
    //         $response = $db->sold_buy_orders->aggregate($queryHours);

    //         $test_arr = iterator_to_array($response);
    //         $retArr = array();
    //         foreach ($test_arr as $key => $value) {
    //             $srch_arr['symbol'] = $symbol;
    //             $srch_arr['order_mode'] = 'live';
    //             $st_date = $value['created_date']->toDatetime()->format("Y-m-d H:i:s");
    //             $e_date = date("Y-m-d H:i:s", strtotime("+5 minute", strtotime($st_date)));
    //             $srch_arr['created_date']['$gte'] = $this->mongo_db->converToMongodttime($st_date);
    //             $srch_arr['created_date']['$lte'] = $this->mongo_db->converToMongodttime($e_date);
    //             $srch_arr['trigger_type'] = $value['trigger_type'];

    //             if ($value['trigger_type'] == 'barrier_trigger') {
    //                 $srch_arr['buy_rule_number'] = $value['buy_rule_number'];
    //             } else if ($value['trigger_type'] == 'barrier_percentile_trigger') {
    //                 $srch_arr['order_level'] = $value['order_level'];
    //             }

    //             $this->mongo_db->where($srch_arr);
    //             $iterator1 = $this->mongo_db->get("sold_buy_orders");

    //             $live_arr = iterator_to_array($iterator1);

    //             $print_arr['created_date'] = $st_date;
    //             $print_arr['trigger_type'] = $value['trigger_type'];
    //             if ($trigger == 'barrier_trigger') {
    //                 $print_arr['buy_rule_number'] = $value['buy_rule_number'];
    //             } else {
    //                 $print_arr['buy_rule_number'] = $value['order_level'];
    //             }
    //             $print_arr['test_exist'] = "YES";
    //             $print_arr['test_example'] = (string) $value['id'];
    //             if (count($live_arr) > 0) {
    //                 $print_arr['live_exist'] = "YES";
    //                 $print_arr['live_example'] = (string) $live_arr[0]['_id'];
    //             } else {
    //                 $print_arr['live_exist'] = "NO";
    //                 $print_arr['live_example'] = "";
    //             }
    //             $retArr[] = $print_arr;
    //         }
    //         $data['final'] = $retArr;
    //     }

    //     $coins = $this->mod_coins->get_all_coins();
    //     $data['coins'] = $coins;

    //     $this->stencil->paint('admin/reports/rule_trigger_value', $data);
    // }

    // public function percentile_hh_ll_avg($symbol) {

    //     $wherre['coin'] = $symbol;
    //     $this->mongo_db->where($wherre);
    //     $this->mongo_db->limit(10);
    //     $this->mongo_db->order_by(array('_id' => -1));
    //     $get = $this->mongo_db->get('coin_meta_hourly_percentile_candle_history');
    //     $rest = (iterator_to_array($get));

    //     $one_rec = $rest[0];
    //     $avg_arr = array();
    //     foreach ($one_rec as $key => $value) {
    //         $avg = 0;
    //         $col = '';
    //         $sum = 0;
    //         $count = 0;
    //         if ($key != 'coin' || $key != 'modified_time' || $key != 'hh_time' || $key != 'll_time') {
    //             $col = array_column($rest, $key);
    //             $sum = array_sum($col);
    //             $count = count($col);
    //             $avg = $sum / $count;

    //             $avg_arr[$key] = $avg;
    //         }
    //     }

    //     echo "<pre>";
    //     print_r($avg_arr);
    //     exit;

    // }

    // public function test() {
    //     $search_arr['parent_status'] = 'parent';
    //     $search_arr['admin_comment'] = 'Removing uncertainity to update profit';
    //     $current_date = date("Y-m-d H:i:s");
    //     $this->mongo_db->where($search_arr);
    //     $get = $this->mongo_db->get("buy_orders");
    //     echo "<pre>";
    //     print_r(iterator_to_array($get));
    //     exit;
    //     foreach ($get as $key => $value) {
    //         $admin_id = $value['admin_id'];
    //         $per = $value['defined_sell_percentage'];
    //         $id = $value['_id'];

    //         $upd_arr['defined_sell_percentage'] = '1';
    //         $upd_arr['admin_comment'] = 'Removing uncertainity to update profit';

    //         $this->mongo_db->where(array('_id' => $id));
    //         $this->mongo_db->set($upd_arr);
    //         $this->mongo_db->update("buy_orders");

    //         $log_msg = "Desired Percentage has been changed to 0% to 1% Programatically to avoid uncertainity";

    //         $this->mod_buy_orders->insert_order_history_log($id, $log_msg, 'order_update', $admin_id, $current_date);
    //     }
    // }

    // public function add_remove_favorite() {
    //     $is_fav = $this->input->post('is_fav');
    //     $id = $this->input->post('id');
    //     $upd_arr['is_fav'] = $is_fav;
    //     $where_arr['_id'] = $this->mongo_db->mongoId($id);

    //     $this->mongo_db->where($where_arr);
    //     $this->mongo_db->set($upd_arr);
    //     $this->mongo_db->update('meta_coin_report_results');

    //     if ($is_fav == 'yes') {
    //         echo "Added to Favorite";
    //     } else {
    //         echo "Removed from Favorite";
    //     }
    //     exit;
    // }

    // public function splitTimeIntoIntervals($work_starts = "2019-01-01 00:00:00", $work_ends = "2019-02-01 00:00:00", $break_starts = null, $break_ends = null, $minutes_per_interval = 7200) {
    //     $intervals = array();
    //     $time = date("Y-m-d H:i", strtotime($work_starts));
    //     $first_after_break = false;
    //     while (strtotime($time) < strtotime($work_ends)) {
    //         // if at least one of the arguments associated with breaks is mising - act like there is no break
    //         if ($break_starts == null || $break_ends == null) {
    //             $time_starts = date("Y-m-d H:i", strtotime($time));
    //             $time_ends = date("Y-m-d H:i", strtotime($time_starts . "+$minutes_per_interval minutes"));
    //         }
    //         // if the break start/end time is specified
    //         else {
    //             if ($first_after_break == true) {
    //                 //first start time after break
    //                 $time = (date("Y-m-d H:i", strtotime($break_ends)));
    //                 $first_after_break = false;
    //             }
    //             $time_starts = (date("Y-m-d H:i", strtotime($time)));
    //             $time_ends = date("Y-m-d H:i", strtotime($time_starts . "+$minutes_per_interval minutes"));
    //             //if end_time intersects break_start and break_end times
    //             if ($this->timesIntersects($time_starts, $time_ends, $break_starts, $break_ends)) {
    //                 $time_ends = date("Y-m-d H:i", strtotime($break_starts));
    //                 $first_after_break = true;
    //             }
    //         }
    //         //if end_time is after work_ends
    //         if (date("Y-m-d H:i", strtotime($time_ends)) > date("Y-m-d H:i", strtotime($work_ends))) {
    //             $time_ends = date("Y-m-d H:i", strtotime($work_ends));
    //         }
    //         $intervals[] = array('starts' => $time_starts, 'ends' => $time_ends);
    //         $time = $time_ends;
    //     }

    //     return $intervals;
    // }
//time intersects if order of parametrs is one of the following 1342 or 1324

    // function timesIntersects($time1_from, $time1_till, $time2_from, $time2_till) {
    //     $out;
    //     $time1_st = strtotime($time1_from);
    //     $time1_end = strtotime($time1_till);
    //     $time2_st = strtotime($time2_from);
    //     $time2_end = strtotime($time2_till);
    //     $duration1 = $time1_end - $time1_st;
    //     $duration2 = $time2_end - $time2_st;
    //     $time1_length = date("i", strtotime($time1_till . "-$time1_from"));
    //     if (
    //         (($time1_st <= $time2_st && $time2_st <= $time1_end && $time1_end <= $time2_end)
    //             ||
    //             ($time1_st <= $time2_st && $time2_st <= $time2_end && $time2_end <= $time1_end)
    //             &&
    //             ($duration1 >= $duration2)
    //         )
    //         ||
    //         ($time1_st <= $time2_st && $time2_st <= $time1_end && $time1_end <= $time2_end)
    //         &&
    //         ($duration1 < $duration2)
    //     ) {
    //         return true;
    //     }

    //     return false;
    // }

    // public function testing_nested_function() {
    //     echo "Nested Function";
    //     $where['symbol'] = "TRXBTC";
    //     $where['settings.username'] = "vizzdev";
    //     $this->mongo_db->where($where);
    //     $this->mongo_db->limit(1);
    //     $get = $this->mongo_db->get("meta_coin_report_results");

    //     echo "<pre>";
    //     print_r(iterator_to_array($get));
    //     exit;
    // }

}
