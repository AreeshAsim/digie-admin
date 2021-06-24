	<?php

use phpDocumentor\Reflection\Types\Null_;

/****/
	class Trigger_rule_reports extends CI_Controller
	{

	function __construct(){
		parent::__construct();
		//load main template
		// ini_set("memory_limit", -1);
		// ini_set("display_errors", E_ALL);
		// error_reporting(E_ALL);
		$this->stencil->layout('admin_layout');
		//load required slices
		$this->stencil->slice('admin_header_script');
		$this->stencil->slice('admin_header');
		$this->stencil->slice('admin_left_sidebar');
		$this->stencil->slice('admin_footer_script');

		//load models
		$this->load->model('admin/mod_trigger_rule_report');
		$this->load->model('admin/mod_dashboard');
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_login');
		$this->load->model('admin/mod_buy_orders');

		$this->load->helper('common_helper');
		$this->load->helper('new_common_helper');   

	}

	public function index(){
		//Login Check
		//$this->mod_login->verify_is_admin_login();

		$this->stencil->paint('admin/reports/home', $data);
	}

	// public function basic_reporting(){
	// 	//Login Check
	// 	$this->mod_login->verify_is_admin_login();

	// 	$customers = $this->mod_report->get_all_customers();
	// 	$data['customers'] = $customers;
	// 	$coins = $this->mod_coins->get_all_coins();
	// 	$data['coins'] = $coins;
	// 	//$orders = $this->mod_report->get_parent_orders();
	// 	$orders = array();
	// 	$data['orders'] = $orders;

	// 	$this->stencil->paint('admin/reports/index', $data);
	// }
	// public function get_report()
	// {
	// 	//Login Check
	// 	$this->mod_login->verify_is_admin_login();

	// 	$error = array();
	// 	if (!empty($this->input->post())) {
	// 		$cust_id = $this->input->post('admin_id');
	// 		if (!empty($cust_id)) {
	// 			$data_sess['cust_id'] = $cust_id;
	// 		}
	// 		if (!empty($this->input->post('coin_filter')) || !empty($this->input->post('date_filter')) || !empty($this->input->post('type_filter'))) {
	// 			$filter_data = $this->input->post();
	// 		}
	// 		if (!empty($filter_data)) {
	// 			$date_filter = $filter_data['date_filter'];
	// 			$date_arr = explode('-', $date_filter);
	// 			if (!empty($date_arr)) {
	// 				$start_date = $date_arr[0];
	// 				$end_date   = $date_arr[1];
	// 				$start_date = date('Y-m-d', strtotime($start_date)) . " 00:00:00";
	// 				$end_date   = date('Y-m-d', strtotime($end_date)) . " 23:59:59";
	// 			}
	// 			$data_sess['filter_data']['coin_filter'] = $filter_data['coin_filter'];
	// 			$data_sess['filter_data']['type_filter'] = $filter_data['type_filter'];
	// 			$data_sess['filter_data']['start_date'] = $start_date;
	// 			$data_sess['filter_data']['end_date'] = $end_date;
	// 		}
	// 		$this->session->set_userdata($data_sess);
	// 	}

	// 	////////////////////////////////Pagination Code///////////////////////////////////////////////
	// 	$this->load->library("pagination");
	// 	$resultsArrAll = $this->mod_report->count_all();
	// 	$count = $resultsArrAll['count'];

	// 	if ($_SERVER['REMOTE_ADDR'] == '101.50.127.131') {
	// 		//echo "<pre>";   print_r($resultsArrAll); exit;
	// 	}

	// 	$config = array();
	// 	$config["base_url"] = SURL . "admin/reports/get_report";
	// 	$config["total_rows"] = $count;
	// 	$config['per_page'] = 10;
	// 	$config['num_links'] = 3;
	// 	$config['use_page_numbers'] = TRUE;
	// 	$config['uri_segment'] = 4;
	// 	$config['reuse_query_string'] = TRUE;
	// 	$config["first_tag_open"] = '<li>';
	// 	$config["first_tag_close"] = '</li>';
	// 	$config["last_tag_open"] = '<li>';
	// 	$config["last_tag_close"] = '</li>';
	// 	$config['next_link'] = '&raquo;';
	// 	$config['next_tag_open'] = '<li>';
	// 	$config['next_tag_close'] = '</li>';
	// 	$config['prev_link'] = '&laquo;';
	// 	$config['prev_tag_open'] = '<li>';
	// 	$config['prev_tag_close'] = '</li>';
	// 	$config['first_link'] = 'First';
	// 	$config['last_link'] = 'Last';
	// 	$config['full_tag_open'] = '<ul class="pagination">';
	// 	$config['full_tag_close'] = '</ul>';
	// 	$config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
	// 	$config['cur_tag_close'] = '</b></a></li>';
	// 	$config['num_tag_open'] = '<li>';
	// 	$config['num_tag_close'] = '</li>';
	// 	$this->pagination->initialize($config);
	// 	$page = $this->uri->segment(4);
	// 	if (!isset($page)) {
	// 		$page = 1;
	// 	}
	// 	$start = ($page - 1) * $config["per_page"];
	// 	////////////////////////////End Pagination Code///////////////////////////////////////////////
	// 	$order_arr = $this->mod_report->get_user_orders($start, $config["per_page"]);

	// 	$page_links = $this->pagination->create_links();
	// 	$customer = $this->mod_report->get_customer();
	// 	$coins = $this->mod_coins->get_all_coins();
	// 	// Data To be send
	// 	$market_sold_price_avg = $resultsArrAll['market_sold_price_avg'];
	// 	$current_order_price_avg = $resultsArrAll['current_order_price_avg'];
	// 	$avg_profit = $resultsArrAll['avg_profit'];
	// 	$ErrorInOrder = $resultsArrAll['count'];
	// 	$data['market_sold_price_avg'] = $market_sold_price_avg;
	// 	$data['current_order_price_avg'] = $current_order_price_avg;
	// 	$data['quantity_avg'] = $quantity_avg;
	// 	$data['avg_profit'] = $avg_profit;

	// 	$data['orders'] = $order_arr['fullarray'];
	// 	$data['totalaverage'] = $totalaverage;
	// 	$data['customer'] = $customer;
	// 	$data['coins'] = $coins;
	// 	$data['count'] = $count;
	// 	$data['error'] = $ErrorInOrder;
	// 	$data['page_links'] = $page_links;

	// 	$this->stencil->paint('admin/reports/report', $data);
	// }

	public function reset_filters($type)
	{

		$this->session->unset_userdata('filter_data');

		redirect(base_url() . 'admin/reports/get_report');
	} //End reset_buy_filters

	// public function array2csv($array)
	// {

	// 	if (count($array) == 0) {
	// 		return null;
	// 	}

	// 	ob_start();

	// 	$df = fopen("php://output", 'w');

	// 	fputcsv($df, array_keys((array) reset($array)));

	// 	foreach ($array as $row) {

	// 		fputcsv($df, (array) $row);
	// 	}

	// 	fclose($df);

	// 	return ob_get_clean();
	// }

	// public function download_send_headers($filename)
	// {

	// 	// disable caching

	// 	$now = gmdate("D, d M Y H:i:s");

	// 	header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");

	// 	header("Last-Modified: {$now} GMT");

	// 	header("Content-type: application/csv");

	// 	header("Pragma: no-cache");

	// 	header("Expires: 0");

	// 	// force download

	// 	header("Content-Type: application/force-download");

	// 	header("Content-Type: application/octet-stream");

	// 	header("Content-Type: application/download");

	// 	// disposition / encoding on response body

	// 	header("Content-Disposition: attachment;filename={$filename}");

	// 	header("Content-Transfer-Encoding: binary");
	// }

	// public function download_csv_trades()
	// {
	// 	//Login Check
	// 	$this->mod_login->verify_is_admin_login();

	// 	$timezone = $this->session->userdata('timezone');

	// 	$time = $this->input->post('date');

	// 	$coin_symbol = $this->input->post('coin');

	// 	$time_arr = explode('to', $time);

	// 	$s_date = $time_arr[0];

	// 	$e_date = $time_arr[1];

	// 	$s_dt = new DateTime($s_date, new DateTimeZone($timezone));

	// 	$e_dt = new DateTime($e_date, new DateTimeZone($timezone));

	// 	$s_dt->setTimezone(new DateTimeZone('UTC'));

	// 	$e_dt->setTimezone(new DateTimeZone('UTC'));

	// 	// format the datetime

	// 	$s_time1 = $s_dt->format('Y-m-d H:i:s');

	// 	$e_time1 = $e_dt->format('Y-m-d H:i:s');

	// 	$start_time = date("Y-m-d H:i:00", strtotime($s_time1));

	// 	$end_time = date("Y-m-d H:i:59", strtotime($e_time1));

	// 	$array = $this->mod_report->get_trade_history($coin_symbol, $start_time, $end_time);

	// 	$this->download_send_headers("trade_history_" . date("Y-m-d_ Gisa") . ".csv");

	// 	echo $this->array2csv($array);

	// 	exit;
	// }

	// public function download_csv_prices()
	// {
	// 	//Login Check
	// 	$this->mod_login->verify_is_admin_login();

	// 	$timezone = $this->session->userdata('timezone');

	// 	$time = $this->input->post('date');

	// 	$coin_symbol = $this->input->post('coin');

	// 	$time_arr = explode('to', $time);

	// 	$s_date = $time_arr[0];

	// 	$e_date = $time_arr[1];

	// 	$s_dt = new DateTime($s_date, new DateTimeZone($timezone));

	// 	$e_dt = new DateTime($e_date, new DateTimeZone($timezone));

	// 	$s_dt->setTimezone(new DateTimeZone('UTC'));

	// 	$e_dt->setTimezone(new DateTimeZone('UTC'));

	// 	// format the datetime

	// 	$s_time1 = $s_dt->format('Y-m-d H:i:s');

	// 	$e_time1 = $e_dt->format('Y-m-d H:i:s');

	// 	$start_time = date("Y-m-d H:i:00", strtotime($s_time1));

	// 	$end_time = date("Y-m-d H:i:59", strtotime($e_time1));

	// 	$array = $this->mod_report->get_price_history($coin_symbol, $start_time, $end_time);

	// 	$this->download_send_headers("prices_history_" . date("Y-m-d_ Gisa") . ".csv");

	// 	echo $this->array2csv($array);

	// 	exit;
	// }

	// public function order_history_log()
	// {
	// 	//Login Check
	// 	$this->mod_login->verify_is_admin_login();

	// 	$timezone = $this->session->userdata('timezone');

	// 	$time = $this->input->post('date');

	// 	$order_id = $this->input->post('order_id');

	// 	$s_date = date('Y-m-d H:00:00', strtotime($time));

	// 	$e_date = date('Y-m-d H:59:59', strtotime($time));

	// 	$s_dt = new DateTime($s_date, new DateTimeZone($timezone));

	// 	$e_dt = new DateTime($e_date, new DateTimeZone($timezone));

	// 	$s_dt->setTimezone(new DateTimeZone('UTC'));

	// 	$e_dt->setTimezone(new DateTimeZone('UTC'));

	// 	// format the datetime

	// 	$s_time1 = $s_dt->format('Y-m-d H:i:s');

	// 	$e_time1 = $e_dt->format('Y-m-d H:i:s');

	// 	$start_time = date("Y-m-d H:i:00", strtotime($s_time1));

	// 	$end_time = date("Y-m-d H:i:59", strtotime($e_time1));

	// 	$array = $this->mod_report->get_order_log($order_id, $start_time, $end_time);

	// 	$data['log'] = $array;

	// 	$this->stencil->paint('admin/reports/order_report', $data);
	// }

	// public function barrier_listing()
	// {
	// 	//Login Check
	// 	$this->mod_login->verify_is_admin_login();

	// 	$error = array();
	// 	if (!empty($this->input->post())) {
	// 		if (!empty($this->input->post('status')) || !empty($this->input->post('filter_coin')) || !empty($this->input->post('global_swing_parent_status')) || !empty($this->input->post('start_date')) || !empty($this->input->post('end_date')) || !empty($this->input->post('barrier_type')) || !empty($this->input->post('breakable'))) {
	// 			$filter_data = $this->input->post();
	// 		}
	// 		if (!empty($filter_data)) {

	// 			$data_sess['filter_data']['status'] = $this->input->post('status');
	// 			$data_sess['filter_data']['filter_coin'] = $this->input->post('filter_coin');
	// 			$data_sess['filter_data']['global_swing_parent_status'] = $this->input->post('global_swing_parent_status');
	// 			$data_sess['filter_data']['start_date'] = $this->input->post('start_date');
	// 			$data_sess['filter_data']['end_date'] = $this->input->post('end_date');
	// 			$data_sess['filter_data']['barrier_type'] = $this->input->post('barrier_type');
	// 			$data_sess['filter_data']['breakable'] = $this->input->post('breakable');
	// 		}

	// 		$this->session->set_userdata($data_sess);
	// 	}
	// 	//Pagination Code//
	// 	$this->load->library("pagination");
	// 	$countBarrierListing = $this->mod_dashboard->countBarrierListing();
	// 	$count = $countBarrierListing;

	// 	$config = array();
	// 	$config["base_url"] = SURL . "admin/reports/barrier-listing";
	// 	$config["total_rows"] = $count;
	// 	$config['per_page'] = 20;
	// 	$config['num_links'] = 5;
	// 	$config['use_page_numbers'] = TRUE;
	// 	$config['uri_segment'] = 4;
	// 	$config['reuse_query_string'] = TRUE;
	// 	$config["first_tag_open"] = '<li>';
	// 	$config["first_tag_close"] = '</li>';
	// 	$config["last_tag_open"] = '<li>';
	// 	$config["last_tag_close"] = '</li>';
	// 	$config['next_link'] = '&raquo;';
	// 	$config['next_tag_open'] = '<li>';
	// 	$config['next_tag_close'] = '</li>';
	// 	$config['prev_link'] = '&laquo;';
	// 	$config['prev_tag_open'] = '<li>';
	// 	$config['prev_tag_close'] = '</li>';
	// 	$config['first_link'] = 'First';
	// 	$config['last_link'] = 'Last';
	// 	$config['full_tag_open'] = '<ul class="pagination">';
	// 	$config['full_tag_close'] = '</ul>';
	// 	$config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
	// 	$config['cur_tag_close'] = '</b></a></li>';
	// 	$config['num_tag_open'] = '<li>';
	// 	$config['num_tag_close'] = '</li>';
	// 	$this->pagination->initialize($config);
	// 	$page = $this->uri->segment(4);
	// 	if (!isset($page)) {
	// 		$page = 1;
	// 	}
	// 	$start = ($page - 1) * $config["per_page"];
	// 	////////////////////////////End Pagination Code///////////////////////////////////////////////
	// 	$barrierListing_arr = $this->mod_dashboard->barrierListing($start, $config["per_page"]);
	// 	$page_links = $this->pagination->create_links();
	// 	$data['page_links'] = $page_links;
	// 	$data['barrier_arr'] = $barrierListing_arr['finalArray'];
	// 	$data['coins'] = $this->mod_coins->get_all_coins();
	// 	//  Pagiantion code goes end here

	// 	/*$coin = $this->session->userdata('global_symbol');
	// 				$search_arr['coin'] = $coin;
	// 				$this->mongo_db->where($search_arr);
	// 				$this->mongo_db->limit(20);

	// 				$this->mongo_db->order_by(array('created_date' => -1));
	// 				$depth_responseArr = $this->mongo_db->get('barrier_values_collection');

	// 				$arr = iterator_to_array($depth_responseArr);
	// 				$data['barrier_arr'] = $arr;

	// 	*/

	// 	//echo "<pre>";   print_r($data['coins'] ); exit;

	// 	$this->stencil->paint('admin/barrier/listing', $data);
	// }

	// public function edit_barrier()
	// {
	// 	//Login Check
	// 	$this->mod_login->verify_is_admin_login();

	// 	$search_arr['_id'] = $this->input->post('id');
	// 	$this->mongo_db->where($search_arr);
	// 	$depth_responseArr = $this->mongo_db->get('barrier_values_collection');
	// 	$arr = iterator_to_array($depth_responseArr);
	// 	$response = '';

	// 	$response .= '
	// 	<form class="form-horizontal" id="edit_form" method="POST" action="' . SURL . 'admin/reports/edit_barrier_action">
	// 		<div class="form-group">
	// 		<label class="control-label col-sm-2" for="barrier_val">Barrier Value:</label>
	// 		<div class="col-sm-10">
	// 			<input type="hidden" class="form-control" name="barrier_id" id="barrier_id" value="' . $arr[0]['_id'] . '">
	// 			<input type="text" class="form-control" name="barrier_val" id="barrier_val" value="' . num($arr[0]['barier_value']) . '">
	// 		</div>
	// 		</div>
	// 	</form>';

	// 	echo $response;
	// 	exit;
	// }

	// public function edit_barrier_action()
	// {
	// 	$barrier_val = $this->input->post('barrier_val');
	// 	$barrier_id = $this->input->post('barrier_id');

	// 	$upd_arr = array('barier_value' => (float) $barrier_val);
	// 	$this->mongo_db->where(array('_id' => $barrier_id));
	// 	$this->mongo_db->set($upd_arr);
	// 	$upd = $this->mongo_db->update('barrier_values_collection');
	// 	if ($upd) {
	// 		$this->session->set_flashdata('ok_message', 'Barrier Updated successfully.');
	// 	} else {
	// 		$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
	// 	} //end if
	// 	redirect($_SERVER['HTTP_REFERER']);
	// }

	// public function add_barrier_action()
	// {
	// 	$coin_symbol = $this->input->post('coin_type');
	// 	$created_date = date('Y-m-d H:i:s');
	// 	$barrier_val = $this->input->post('barrier_val');
	// 	$barrier_id = $this->input->post('barrier_type');

	// 	$upd_arr = array('coin' => $coin_symbol, 'barier_value' => (float) $barrier_val, 'barrier_type' => $barrier_id, 'created_date' => $this->mongo_db->converToMongodttime($created_date), 'human_readible_created_date' => $created_date);
	// 	$ins = $this->mongo_db->insert('barrier_values_collection', $upd_arr);
	// 	if ($ins) {

	// 		$this->session->set_flashdata('ok_message', 'Barrier Inserted successfully.');
	// 	} else {

	// 		$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
	// 	} //end if
	// 	redirect($_SERVER['HTTP_REFERER']);
	// }

	// public function delete_barrier($id)
	// {

	// 	$this->mongo_db->where(array('_id' => $this->mongo_db->mongoId($id)));
	// 	$del = $this->mongo_db->delete('barrier_values_collection');
	// 	$this->mongo_db->where(array('barrier_id' => $this->mongo_db->mongoId($id)));
	// 	$del2 = $this->mongo_db->delete('barrier_test_collection');
	// 	if ($del) {

	// 		$this->session->set_flashdata('ok_message', 'Barrier Deleted successfully.');
	// 	} else {

	// 		$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
	// 	} //end if
	// 	redirect($_SERVER['HTTP_REFERER']);
	// }

	// public function show_barrier($barrier_id = '')
	// {
	// 	//Login Check
	// 	$this->mod_login->verify_is_admin_login();

	// 	$this->mongo_db->where(array('barrier_id' => $this->mongo_db->mongoId($barrier_id)));
	// 	$del = $this->mongo_db->get('barrier_test_collection');

	// 	$ret_arr = iterator_to_array($del);

	// 	foreach ($ret_arr as $key => $value) {
	// 		$returArr['barrier_value'] = num($value['barrier_value']);
	// 		$returArr['barrier_type'] = $value['barrier_type'];
	// 		$returArr['barrier_creation_time'] = $value['barrier_creation_time'];
	// 		$returArr['barrier_quantity'] = number_format_short($value['barrier_quantity']);
	// 		$returArr['market_value_time'] = $value['market_value_time'];
	// 		$returArr['black_wall_pressure'] = $value['black_wall_pressure'];
	// 		$returArr['yellow_wall_pressure'] = $value['yellow_wall_pressure'];
	// 		$returArr['depth_pressure'] = $value['depth_pressure'];
	// 		$returArr['bid_contracts'] = number_format_short($value['bid_contracts']);
	// 		$returArr['bid_percentage'] = $value['bid_percentage'];
	// 		$returArr['ask_contract'] = number_format_short($value['ask_contract']);
	// 		$returArr['ask_percentage'] = $value['ask_percentage'];
	// 		if ($value['updated_profit'] == null || $value['updated_loss'] == null) {
	// 			$returArr['profit'] = 0;
	// 			$returArr['loss'] = 0;
	// 		} else {
	// 			$returArr['profit'] = $value['updated_profit'];
	// 			$returArr['loss'] = $value['updated_loss'];
	// 		}
	// 		$returArr['great_wall_quantity'] = number_format_short($value['great_wall_quantity']);
	// 		$returArr['great_wall'] = $value['great_wall'];
	// 		$returArr['seven_level_depth'] = $value['seven_level_depth'];

	// 		$returArr['score'] = $value['score'];
	// 		$returArr['last_qty_buy_vs_sell'] = $value['last_qty_buy_vs_sell'];
	// 		$returArr['last_qty_time_ago'] = (int) filter_var($value['last_qty_time_ago'], FILTER_SANITIZE_NUMBER_INT);
	// 		//..(int) filter_var($str, FILTER_SANITIZE_NUMBER_INT)

	// 		$returArr['last_200_buy_vs_sell'] = $value['last_200_buy_vs_sell'];
	// 		$returArr['last_200_time_ago'] = (int) filter_var($value['last_200_time_ago'], FILTER_SANITIZE_NUMBER_INT);
	// 	}
	// 	$data['down_indicators'] = $returArr;

	// 	$this->stencil->paint('admin/barrier/listing_indicator', $data);
	// }

	public function indicator_listing()
	{
		//Login Check
		$this->mod_login->verify_is_admin_login();

		/////////////////////////////////////////////////////////////

		if (!empty($this->input->post("coin_symbol"))) {
			$coin_symbol = $this->input->post("coin_symbol");
		} else {
			$coin_symbol = "NCASHBTC";
		}

		if (!empty($this->input->post("breakable_barrier"))) {
			$breakable_barrier = $this->input->post("breakable_barrier");
			$search_arr['breakable'] = $breakable_barrier;
		}

		if (!empty($this->input->post("barrier_swing"))) {
			$barrier_swing = $this->input->post("barrier_swing");
			$search_arr['global_swing_parent_status'] = $barrier_swing;
		} else {
			$barrier_swing = '';
		}

		if (!empty($this->input->post("filter_time"))) {
			$filter_time = $this->input->post("filter_time");
		} else {
			$filter_time = '-7 days';
		}

		if (!empty($this->input->post("barrier_status"))) {
			$barrier_status = $this->input->post("barrier_status");
		} else {
			$barrier_status = 'very_strong_barrier';
		}

		$data['coin'] = $coin_symbol;
		$data['barrier_type'] = $barrier_type;
		$data['barrier_swing'] = $barrier_swing;
		$data['break_barrier'] = $breakable_barrier;
		$data['barrier_status'] = $barrier_status;
		$data['filter_time'] = $filter_time;
		$contract_quantity = $this->mod_coins->get_coin_contract_size($coin_symbol);
		////////////////////////////////////////////////////////////
		$barrier_type = "up";
		$search_arr['coin'] = $coin_symbol;
		$search_arr['barrier_type'] = $barrier_type;
		$search_arr['barrier_status'] = $barrier_status;

		$datetime = date("Y-m-d H:i:s", strtotime($filter_time));

		$search_arr['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($datetime));

		$this->mongo_db->where($search_arr);
		$get = $this->mongo_db->get('barrier_values_collection');
		$pre_res = iterator_to_array($get);
		$up_breakable = 0;
		$up_non_breakable = 0;
		foreach ($pre_res as $key => $value) {
			$created_date = $value['created_date'];
			$barrier_value = $value['barier_value'];
			$barrier_id = $value['_id'];

			$new_Date = $created_date->toDateTime()->format("Y-m-d H:i:s");
			$search_arr2['barrier_id'] = $barrier_id;
			$search_arr2['coin'] = $coin_symbol;
			//$search_arr2['created_date'] = $created_date;

			$this->mongo_db->where($search_arr2);
			$this->mongo_db->limit(1);
			$gets = $this->mongo_db->get('barrier_test_collection');
			$coin_meta = iterator_to_array($gets);

			$this->mongo_db->where($search_arr2);
			$this->mongo_db->limit(1);
			$gets = $this->mongo_db->get('barrier_test_collection');
			$coin_meta = iterator_to_array($gets);

			if (!empty($coin_meta)) {
				$res['ups'][] = array(
					'coin' => $coin_symbol,
					'barrier_value' => $barrier_value,
					'barrier_creation_time' => $new_Date222,
					'market_value_time' => $new_Date,
					'quantity' => intval($coin_meta[0]['barrier_quantity']),
					'black_wall_pressure' => intval($coin_meta[0]['black_wall_pressure']),
					'yellow_wall_pressure' => intval($coin_meta[0]['yellow_wall_pressure']),
					'depth_pressure' => intval($coin_meta[0]['depth_pressure']),
					'bid_contracts' => intval($coin_meta[0]['bid_contracts']),
					'bid_percentage' => intval($coin_meta[0]['bid_percentage']),
					'ask_contract' => floatval($coin_meta[0]['ask_contract']),
					'ask_percentage' => floatval($coin_meta[0]['ask_percentage']),
					'buyers' => intval($coin_meta[0]['buyers']),

					'sellers' => intval($coin_meta[0]['sellers']),

					'buyers_percentage' => floatval($coin_meta[0]['buyers_percentage']),

					'sellers_percentage' => floatval($coin_meta[0]['sellers_percentage']),

					'sellers_buyers_per' => floatval($coin_meta[0]['sellers_buyers_per']),

					'trade_type' => $coin_meta['trade_type'],
					'great_wall_quantity' => intval($coin_meta[0]['great_wall_quantity']),
					'great_wall' => $coin_meta[0]['great_wall'],
					'seven_level_depth' => floatval($coin_meta[0]['seven_level_depth']),
					'score' => $coin_meta[0]['score'],
					'last_qty_buy_vs_sell' => $coin_meta[0]['last_qty_buy_vs_sell'],
					'last_qty_time_ago' => (int) filter_var($coin_meta[0]['last_qty_time_ago'], FILTER_SANITIZE_NUMBER_INT),
					'last_200_buy_vs_sell' => $coin_meta[0]['last_200_buy_vs_sell'],
					'last_200_time_ago' => (int) filter_var($coin_meta[0]['last_200_time_ago'], FILTER_SANITIZE_NUMBER_INT),

				);

				if ($coin_meta[0]['breakable'] == 'breakable') {
					$up_breakable++;
				}
				if ($coin_meta[0]['breakable'] == 'non_breakable') {
					$up_non_breakable++;
				}
			}
		}

		$returnArr = array();

		/*=========================Quantity Pressure=====================================*/
		$quantity_arr = array_column($res['ups'], 'quantity');
		$avg_quantity = array_sum($quantity_arr) / count($quantity_arr);
		$max_quantity = max($quantity_arr);
		$min_quantity = min($quantity_arr);
		$returnArr['ups']['barrier_quantity'] = array(
			'avg' => $avg_quantity,
			'max' => $max_quantity,
			'min' => $min_quantity,
		);
		/*=======================End Black Wall Pressure===============================*/
		/*==============================Black Wall Pressure==========================================*/
		$black_wall_array = array_column($res['ups'], 'black_wall_pressure');
		$average_black_wall = array_sum($black_wall_array) / count($black_wall_array);
		$max_black_wall_pressure = max($black_wall_array);
		$min_black_wall_pressure = min($black_wall_array);
		$returnArr['ups']['black_wall_pressure'] = array(
			'avg' => $average_black_wall,
			'max' => $max_black_wall_pressure,
			'min' => $min_black_wall_pressure,
		);
		/*==============================End Black Wall Pressure=======================================*/

		/*==============================Yellow Wall Pressure==========================================*/
		$yellow_wall_array = array_column($res['ups'], 'yellow_wall_pressure');
		$average_yellow_wall = array_sum($yellow_wall_array) / count($yellow_wall_array);
		$max_yellow_wall_pressure = max($yellow_wall_array);
		$min_yellow_wall_pressure = min($yellow_wall_array);

		$returnArr['ups']['yellow_wall_pressure'] = array(

			'avg' => $average_yellow_wall,
			'max' => $max_yellow_wall_pressure,
			'min' => $min_yellow_wall_pressure,
		);
		/*==============================End Yellow Wall Pressure=======================================*/

		/*================================Depth Pressure===============================================*/
		$depth_array = array_column($res['ups'], 'depth_pressure');
		$average_depth = array_sum($depth_array) / count($depth_array);
		$max_depth_pressure = max($depth_array);
		$min_depth_pressure = min($depth_array);

		$returnArr['ups']['depth_pressure'] = array(
			'avg' => $average_depth,
			'max' => $max_depth_pressure,
			'min' => $min_depth_pressure,
		);
		/*==============================End Depth Pressure=======================================*/

		/*================================Bid Contracts==========================================*/
		$bid_contracts_arr = array_column($res['ups'], 'bid_contracts');
		$average_bids = array_sum($bid_contracts_arr) / count($bid_contracts_arr);
		$max_bids = max($bid_contracts_arr);
		$min_bids = min($bid_contracts_arr);

		$returnArr['ups']['bid_contracts'] = array(
			'avg' => $average_bids,
			'max' => $max_bids,
			'min' => $min_bids,
		);
		/*==============================End Bid Contracts========================================*/

		/*================================Ask Contracts==========================================*/
		$ask_contracts_arr = array_column($res['ups'], 'ask_contract');
		$average_asks = array_sum($ask_contracts_arr) / count($ask_contracts_arr);
		$max_asks = max($ask_contracts_arr);
		$min_asks = min($ask_contracts_arr);

		$returnArr['ups']['ask_contract'] = array(
			'avg' => $average_asks,
			'max' => $max_asks,
			'min' => $min_asks,
		);
		/*==============================End Ask Contracts========================================*/

		/*================================Bid Contracts==========================================*/
		$bid_percentage_arr = array_column($res['ups'], 'bid_percentage');
		$average_bids_per = array_sum($bid_percentage_arr) / count($bid_percentage_arr);
		$max_bids_per = max($bid_percentage_arr);
		$min_bids_per = min($bid_percentage_arr);
		$returnArr['ups']['bid_percentage'] = array(
			'avg' => $average_bids_per,
			'max' => $max_bids_per,
			'min' => $min_bids_per,
		);
		/*==============================End Bid Contracts========================================*/

		/*================================Ask Contracts==========================================*/
		$ask_percentage_arr = array_column($res['ups'], 'ask_percentage');
		$average_asks_per = array_sum($ask_percentage_arr) / count($ask_percentage_arr);
		$max_asks_per = max($ask_percentage_arr);
		$min_asks_per = min($ask_percentage_arr);

		$returnArr['ups']['ask_percentage'] = array(
			'avg' => $average_asks_per,
			'max' => $max_asks_per,
			'min' => $min_asks_per,
		);
		/*==============================End Ask Contracts========================================*/

		/*================================Buyers==========================================*/
		$buyers_arr = array_column($res['ups'], 'buyers');
		$average_asks_per = array_sum($buyers_arr) / count($buyers_arr);
		$max_asks_per = max($buyers_arr);
		$min_asks_per = min($buyers_arr);

		$returnArr['ups']['buyers'] = array(
			'avg' => $average_asks_per,
			'max' => $max_asks_per,
			'min' => $min_asks_per,
		);
		/*==============================End Buyers========================================*/

		/*================================Sellers==========================================*/
		$seller_arr = array_column($res['ups'], 'sellers');
		$average_asks_per = array_sum($seller_arr) / count($seller_arr);
		$max_asks_per = max($seller_arr);
		$min_asks_per = min($seller_arr);

		$returnArr['ups']['sellers'] = array(
			'avg' => $average_asks_per,
			'max' => $max_asks_per,
			'min' => $min_asks_per,
		);
		/*==============================End Sellers========================================*/

		/*================================Sellers==========================================*/
		$buyers_percentage_arr = array_column($res['ups'], 'buyers_percentage');
		$average_asks_per = array_sum($buyers_percentage_arr) / count($buyers_percentage_arr);
		$max_asks_per = max($buyers_percentage_arr);
		$min_asks_per = min($buyers_percentage_arr);

		$returnArr['ups']['buyers_percentage'] = array(
			'avg' => $average_asks_per,
			'max' => $max_asks_per,
			'min' => $min_asks_per,
		);
		/*==============================End Sellers========================================*/

		/*================================Sellers==========================================*/
		$buyers_percentage_arr = array_column($res['ups'], 'sellers_percentage');
		$average_asks_per = array_sum($buyers_percentage_arr) / count($buyers_percentage_arr);
		$max_asks_per = max($buyers_percentage_arr);
		$min_asks_per = min($buyers_percentage_arr);

		$returnArr['ups']['sellers_percentage'] = array(
			'avg' => $average_asks_per,
			'max' => $max_asks_per,
			'min' => $min_asks_per,
		);
		/*==============================End Sellers========================================*/

		/*================================Sellers==========================================*/
		$sellers_buyers_percentage_arr = array_column($res['ups'], 'sellers_buyers_per');
		$average_asks_per = array_sum($sellers_buyers_percentage_arr) / count($sellers_buyers_percentage_arr);
		$max_asks_per = max($sellers_buyers_percentage_arr);
		$min_asks_per = min($sellers_buyers_percentage_arr);

		$returnArr['ups']['sellers_buyers_per'] = array(
			'avg' => $average_asks_per,
			'max' => $max_asks_per,
			'min' => $min_asks_per,
		);
		/*==============================End Sellers========================================*/

		/*================================Great Wall==========================================*/
		$great_wall_array = array_column($res['ups'], 'great_wall_quantity');
		$great_wall_avg = array_sum($great_wall_array) / count($great_wall_array);
		$max_great_wall = max($great_wall_array);
		$min_great_wall = min($great_wall_array);

		$returnArr['ups']['great_wall'] = array(
			'avg' => $great_wall_avg,
			'max' => $max_great_wall,
			'min' => $min_great_wall,
		);
		/*==============================End Great Wall========================================*/

		/*================================Sevenlevel==========================================*/
		$seven_level_array = array_column($res['ups'], 'seven_level_depth');
		$seven_level_avg = array_sum($seven_level_array) / count($seven_level_array);
		$max_seven_level = max($seven_level_array);
		$min_seven_level = min($seven_level_array);

		$returnArr['ups']['seven_level_depth'] = array(
			'avg' => $seven_level_avg,
			'max' => $max_seven_level,
			'min' => $min_seven_level,
		);

		/*==============================End Sevenlevel========================================*/

		/*=========================last_qty_buy_vs_sell====================================*/
		$last_qty_buy_vs_sell_arr = array_column($res['ups'], 'last_qty_buy_vs_sell');
		$avg_last_qty_buy_vs_sell = array_sum($last_qty_buy_vs_sell_arr) / count($last_qty_buy_vs_sell_arr);
		$max_last_qty_buy_vs_sell = max($last_qty_buy_vs_sell_arr);
		$min_last_qty_buy_vs_sell = min($last_qty_buy_vs_sell_arr);
		$returnArr['ups']['last_qty_buy_vs_sell (' . number_format_short($contract_quantity) . ')'] = array(
			'avg' => $avg_last_qty_buy_vs_sell,
			'max' => $max_last_qty_buy_vs_sell,
			'min' => $min_last_qty_buy_vs_sell,
		);
		/*=======================End last_qty_buy_vs_sell===============================*/

		/*=========================last_qty_time_ago====================================*/
		$last_qty_time_ago_arr = array_column($res['ups'], 'last_qty_time_ago');
		$avg_last_qty_time_ago = array_sum($last_qty_time_ago_arr) / count($last_qty_time_ago_arr);
		$max_last_qty_time_ago = max($last_qty_time_ago_arr);
		$min_last_qty_time_ago = min($last_qty_time_ago_arr);
		$returnArr['ups']['last_qty_time_ago (' . number_format_short($contract_quantity) . ')'] = array(
			'avg' => $avg_last_qty_time_ago,
			'max' => $max_last_qty_time_ago,
			'min' => $min_last_qty_time_ago,
		);
		/*=======================End last_qty_time_ago===============================*/

		/*=========================last_200_buy_vs_sell====================================*/
		$last_200_buy_vs_sell_arr = array_column($res['ups'], 'last_200_buy_vs_sell');
		$avg_last_200_buy_vs_sell = array_sum($last_200_buy_vs_sell_arr) / count($last_200_buy_vs_sell_arr);
		$max_last_200_buy_vs_sell = max($last_200_buy_vs_sell_arr);
		$min_last_200_buy_vs_sell = min($last_200_buy_vs_sell_arr);
		$returnArr['ups']['last_200_buy_vs_sell'] = array(
			'avg' => $avg_last_200_buy_vs_sell,
			'max' => $max_last_200_buy_vs_sell,
			'min' => $min_last_200_buy_vs_sell,
		);
		/*=======================End last_200_buy_vs_sell===============================*/

		/*=========================last_200_time_ago====================================*/
		$last_200_time_ago_arr = array_column($res['ups'], 'last_200_time_ago');
		$avg_last_200_time_ago = array_sum($last_200_time_ago_arr) / count($last_200_time_ago_arr);
		$max_last_200_time_ago = max($last_200_time_ago_arr);
		$min_last_200_time_ago = min($last_200_time_ago_arr);
		$returnArr['ups']['last_200_time_ago'] = array(
			'avg' => $avg_last_200_time_ago,
			'max' => $max_last_200_time_ago,
			'min' => $min_last_200_time_ago,
		);
		/*=======================End last_200_time_ago===============================*/

		//=========================================Downs=======================================

		$search_arr = array();
		$barrier_type = "down";
		$search_arr['coin'] = $coin_symbol;
		$search_arr['barrier_type'] = $barrier_type;
		$search_arr['barrier_status'] = $barrier_status;
		if (isset($barrier_swing) && $barrier_swing != '') {
			$search_arr['global_swing_parent_status'] = $barrier_swing;
		}
		if (isset($breakable_barrier) && $breakable_barrier != '') {
			$search_arr['breakable'] = $breakable_barrier;
		}
		$datetime = date("Y-m-d H:i:s", strtotime($filter_time));

		$search_arr['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($datetime));

		$this->mongo_db->where($search_arr);
		$get = $this->mongo_db->get('barrier_values_collection');
		$pre_res2 = iterator_to_array($get);
		$down_breakable = 0;
		$down_non_breakable = 0;
		foreach ($pre_res2 as $key => $value) {
			$created_date = $value['created_date'];
			$barrier_value = $value['barier_value'];
			$barrier_id = $value['_id'];

			$search_arr2['barrier_id'] = $barrier_id;
			$search_arr2['coin'] = $coin_symbol;
			//$search_arr2['created_date'] = $created_date;

			$this->mongo_db->where($search_arr2);
			$this->mongo_db->limit(1);
			$gets = $this->mongo_db->get('barrier_test_collection');
			$coin_meta = iterator_to_array($gets);

			if (!empty($coin_meta)) {
				$res['downs'][] = array(
					'coin' => $coin_symbol,
					'barrier_value' => $barrier_value,
					'barrier_creation_time' => $new_Date222,
					'market_value_time' => $new_Date,
					'quantity' => intval($coin_meta[0]['barrier_quantity']),
					'black_wall_pressure' => intval($coin_meta[0]['black_wall_pressure']),
					'yellow_wall_pressure' => intval($coin_meta[0]['yellow_wall_pressure']),
					'depth_pressure' => intval($coin_meta[0]['depth_pressure']),
					'bid_contracts' => intval($coin_meta[0]['bid_contracts']),
					'bid_percentage' => intval($coin_meta[0]['bid_percentage']),
					'ask_contract' => floatval($coin_meta[0]['ask_contract']),
					'ask_percentage' => floatval($coin_meta[0]['ask_percentage']),
					'buyers' => intval($coin_meta[0]['buyers']),

					'sellers' => intval($coin_meta[0]['sellers']),

					'buyers_percentage' => floatval($coin_meta[0]['buyers_percentage']),

					'sellers_percentage' => floatval($coin_meta[0]['sellers_percentage']),

					'sellers_buyers_per' => floatval($coin_meta[0]['sellers_buyers_per']),

					'trade_type' => $coin_meta['trade_type'],
					'great_wall_quantity' => intval($coin_meta[0]['great_wall_quantity']),
					'great_wall' => $coin_meta[0]['great_wall'],
					'seven_level_depth' => floatval($coin_meta[0]['seven_level_depth']),
					'profit' => floatval($coin_meta[0]['updated_profit']),
					'loss' => floatval($coin_meta[0]['updated_loss']),

					'score' => $coin_meta[0]['score'],
					'last_qty_buy_vs_sell' => $coin_meta[0]['last_qty_buy_vs_sell'],
					'last_qty_time_ago' => (int) filter_var($coin_meta[0]['last_qty_time_ago'], FILTER_SANITIZE_NUMBER_INT),
					'last_200_buy_vs_sell' => $coin_meta[0]['last_200_buy_vs_sell'],
					'last_200_time_ago' => (int) filter_var($coin_meta[0]['last_200_time_ago'], FILTER_SANITIZE_NUMBER_INT),

				);

				if ($coin_meta[0]['breakable'] == 'breakable') {
					$down_breakable++;
				}
				if ($coin_meta[0]['breakable'] == 'non_breakable') {
					$down_non_breakable++;
				}
			}
		}
		/*==============================Total Profit ==========================================*/
		$profit_arr = array_column($res['downs'], 'profit');
		$avg_profit = array_sum($profit_arr) / count($profit_arr);
		$max_profit = max($profit_arr);
		$min_profit = min($profit_arr);
		$profit_loss['profit'] = array(
			'avg' => $avg_profit,
			'max' => $max_profit,
			'min' => $min_profit,
		);
		/*==============================End Total Profit=======================================*/
		/*==============================Total Loss==========================================*/
		$loss_arr = array_column($res['downs'], 'loss');
		$avg_loss = array_sum($loss_arr) / count($loss_arr);
		$max_loss = max($loss_arr);
		$min_loss = min($loss_arr);
		$profit_loss['loss'] = array(
			'avg' => $avg_loss,
			'max' => $max_loss,
			'min' => $min_loss,
		);
		/*==============================End Total Loss=======================================*/

		/*==============================Quantity Pressure==========================================*/
		$quantity_arr = array_column($res['downs'], 'quantity');
		$avg_quantity = array_sum($quantity_arr) / count($quantity_arr);
		$max_quantity = max($quantity_arr);
		$min_quantity = min($quantity_arr);
		$returnArr['downs']['barrier_quantity'] = array(
			'avg' => $avg_quantity,
			'max' => $max_quantity,
			'min' => $min_quantity,
		);
		/*==============================End Quantity Pressure=======================================*/

		/*==============================Black Wall Pressure==========================================*/
		$black_wall_array = array_column($res['downs'], 'black_wall_pressure');
		$average_black_wall = array_sum($black_wall_array) / count($black_wall_array);
		$max_black_wall_pressure = max($black_wall_array);
		$min_black_wall_pressure = min($black_wall_array);
		$returnArr['downs']['black_wall_pressure'] = array(
			'avg' => $average_black_wall,
			'max' => $max_black_wall_pressure,
			'min' => $min_black_wall_pressure,
		);
		/*==============================End Black Wall Pressure=======================================*/

		/*==============================Yellow Wall Pressure==========================================*/
		$yellow_wall_array = array_column($res['downs'], 'yellow_wall_pressure');
		$average_yellow_wall = array_sum($yellow_wall_array) / count($yellow_wall_array);
		$max_yellow_wall_pressure = max($yellow_wall_array);
		$min_yellow_wall_pressure = min($yellow_wall_array);

		$returnArr['downs']['yellow_wall_pressure'] = array(

			'avg' => $average_yellow_wall,
			'max' => $max_yellow_wall_pressure,
			'min' => $min_yellow_wall_pressure,
		);
		/*==============================End Yellow Wall Pressure=======================================*/

		/*================================Depth Pressure===============================================*/
		$depth_array = array_column($res['downs'], 'depth_pressure');
		$average_depth = array_sum($depth_array) / count($depth_array);
		$max_depth_pressure = max($depth_array);
		$min_depth_pressure = min($depth_array);

		$returnArr['downs']['depth_pressure'] = array(
			'avg' => $average_depth,
			'max' => $max_depth_pressure,
			'min' => $min_depth_pressure,
		);
		/*==============================End Depth Pressure=======================================*/

		/*================================Bid Contracts==========================================*/
		$bid_contracts_arr = array_column($res['downs'], 'bid_contracts');
		$average_bids = array_sum($bid_contracts_arr) / count($bid_contracts_arr);
		$max_bids = max($bid_contracts_arr);
		$min_bids = min($bid_contracts_arr);

		$returnArr['downs']['bid_contracts'] = array(
			'avg' => $average_bids,
			'max' => $max_bids,
			'min' => $min_bids,
		);
		/*==============================End Bid Contracts========================================*/

		/*================================Ask Contracts==========================================*/
		$ask_contracts_arr = array_column($res['downs'], 'ask_contract');
		$average_asks = array_sum($ask_contracts_arr) / count($ask_contracts_arr);
		$max_asks = max($ask_contracts_arr);
		$min_asks = min($ask_contracts_arr);

		$returnArr['downs']['ask_contract'] = array(
			'avg' => $average_asks,
			'max' => $max_asks,
			'min' => $min_asks,
		);
		/*==============================End Ask Contracts========================================*/

		/*================================Bid Contracts==========================================*/
		$bid_percentage_arr = array_column($res['downs'], 'bid_percentage');
		$average_bids_per = array_sum($bid_percentage_arr) / count($bid_percentage_arr);
		$max_bids_per = max($bid_percentage_arr);
		$min_bids_per = min($bid_percentage_arr);
		$returnArr['downs']['bid_percentage'] = array(
			'avg' => $average_bids_per,
			'max' => $max_bids_per,
			'min' => $min_bids_per,
		);
		/*==============================End Bid Contracts========================================*/

		/*================================Ask Contracts==========================================*/
		$ask_percentage_arr = array_column($res['downs'], 'ask_percentage');
		$average_asks_per = array_sum($ask_percentage_arr) / count($ask_percentage_arr);
		$max_asks_per = max($ask_percentage_arr);
		$min_asks_per = min($ask_percentage_arr);

		$returnArr['downs']['ask_percentage'] = array(
			'avg' => $average_asks_per,
			'max' => $max_asks_per,
			'min' => $min_asks_per,
		);
		/*==============================End Ask Contracts========================================*/

		/*================================Buyers==========================================*/
		$buyers_arr = array_column($res['downs'], 'buyers');
		$average_asks_per = array_sum($buyers_arr) / count($buyers_arr);
		$max_asks_per = max($buyers_arr);
		$min_asks_per = min($buyers_arr);

		$returnArr['downs']['buyers'] = array(
			'avg' => $average_asks_per,
			'max' => $max_asks_per,
			'min' => $min_asks_per,
		);
		/*==============================End Buyers========================================*/

		/*================================Sellers==========================================*/
		$seller_arr = array_column($res['downs'], 'sellers');
		$average_asks_per = array_sum($seller_arr) / count($seller_arr);
		$max_asks_per = max($seller_arr);
		$min_asks_per = min($seller_arr);

		$returnArr['downs']['sellers'] = array(
			'avg' => $average_asks_per,
			'max' => $max_asks_per,
			'min' => $min_asks_per,
		);
		/*==============================End Sellers========================================*/

		/*================================Sellers==========================================*/
		$buyers_percentage_arr = array_column($res['downs'], 'buyers_percentage');
		$average_asks_per = array_sum($buyers_percentage_arr) / count($buyers_percentage_arr);
		$max_asks_per = max($buyers_percentage_arr);
		$min_asks_per = min($buyers_percentage_arr);

		$returnArr['downs']['buyers_percentage'] = array(
			'avg' => $average_asks_per,
			'max' => $max_asks_per,
			'min' => $min_asks_per,
		);
		/*==============================End Sellers========================================*/

		/*================================Sellers==========================================*/
		$buyers_percentage_arr = array_column($res['downs'], 'sellers_percentage');
		$average_asks_per = array_sum($buyers_percentage_arr) / count($buyers_percentage_arr);
		$max_asks_per = max($buyers_percentage_arr);
		$min_asks_per = min($buyers_percentage_arr);

		$returnArr['downs']['sellers_percentage'] = array(
			'avg' => $average_asks_per,
			'max' => $max_asks_per,
			'min' => $min_asks_per,
		);
		/*==============================End Sellers========================================*/

		/*================================Sellers==========================================*/
		$sellers_buyers_percentage_arr = array_column($res['downs'], 'sellers_buyers_per');
		$average_asks_per = array_sum($sellers_buyers_percentage_arr) / count($sellers_buyers_percentage_arr);
		$max_asks_per = max($sellers_buyers_percentage_arr);
		$min_asks_per = min($sellers_buyers_percentage_arr);

		$returnArr['downs']['sellers_buyers_per'] = array(
			'avg' => $average_asks_per,
			'max' => $max_asks_per,
			'min' => $min_asks_per,
		);
		/*==============================End Sellers========================================*/

		/*================================Great Wall==========================================*/
		$great_wall_array = array_column($res['downs'], 'great_wall_quantity');
		$great_wall_avg = array_sum($great_wall_array) / count($great_wall_array);
		$max_great_wall = max($great_wall_array);
		$min_great_wall = min($great_wall_array);

		$returnArr['downs']['great_wall'] = array(
			'avg' => $great_wall_avg,
			'max' => $max_great_wall,
			'min' => $min_great_wall,
		);
		/*==============================End Great Wall========================================*/

		/*================================Great Wall==========================================*/
		$seven_level_array = array_column($res['downs'], 'seven_level_depth');
		$seven_level_avg = array_sum($seven_level_array) / count($seven_level_array);
		$max_seven_level = max($seven_level_array);
		$min_seven_level = min($seven_level_array);

		$returnArr['downs']['seven_level_depth'] = array(
			'avg' => $seven_level_avg,
			'max' => $max_seven_level,
			'min' => $min_seven_level,
		);

		/*=========================last_qty_buy_vs_sell====================================*/
		$last_qty_buy_vs_sell_arr = array_column($res['downs'], 'last_qty_buy_vs_sell');
		$avg_last_qty_buy_vs_sell = array_sum($last_qty_buy_vs_sell_arr) / count($last_qty_buy_vs_sell_arr);
		$max_last_qty_buy_vs_sell = max($last_qty_buy_vs_sell_arr);
		$min_last_qty_buy_vs_sell = min($last_qty_buy_vs_sell_arr);
		$returnArr['downs']['last_qty_buy_vs_sell (' . number_format_short($contract_quantity) . ')'] = array(
			'avg' => $avg_last_qty_buy_vs_sell,
			'max' => $max_last_qty_buy_vs_sell,
			'min' => $min_last_qty_buy_vs_sell,
		);
		/*=======================End last_qty_buy_vs_sell===============================*/

		/*=========================last_qty_time_ago====================================*/
		$last_qty_time_ago_arr = array_column($res['downs'], 'last_qty_time_ago');
		$avg_last_qty_time_ago = array_sum($last_qty_time_ago_arr) / count($last_qty_time_ago_arr);
		$max_last_qty_time_ago = max($last_qty_time_ago_arr);
		$min_last_qty_time_ago = min($last_qty_time_ago_arr);
		$returnArr['downs']['last_qty_time_ago (' . number_format_short($contract_quantity) . ')'] = array(
			'avg' => $avg_last_qty_time_ago,
			'max' => $max_last_qty_time_ago,
			'min' => $min_last_qty_time_ago,
		);
		/*=======================End last_qty_time_ago===============================*/

		/*=========================last_200_buy_vs_sell====================================*/
		$last_200_buy_vs_sell_arr = array_column($res['downs'], 'last_200_buy_vs_sell');
		$avg_last_200_buy_vs_sell = array_sum($last_200_buy_vs_sell_arr) / count($last_200_buy_vs_sell_arr);
		$max_last_200_buy_vs_sell = max($last_200_buy_vs_sell_arr);
		$min_last_200_buy_vs_sell = min($last_200_buy_vs_sell_arr);
		$returnArr['downs']['last_200_buy_vs_sell'] = array(
			'avg' => $avg_last_200_buy_vs_sell,
			'max' => $max_last_200_buy_vs_sell,
			'min' => $min_last_200_buy_vs_sell,
		);
		/*=======================End last_200_buy_vs_sell===============================*/

		/*=========================last_200_time_ago====================================*/
		$last_200_time_ago_arr = array_column($res['downs'], 'last_200_time_ago');
		$avg_last_200_time_ago = array_sum($last_200_time_ago_arr) / count($last_200_time_ago_arr);
		$max_last_200_time_ago = max($last_200_time_ago_arr);
		$min_last_200_time_ago = min($last_200_time_ago_arr);
		$returnArr['downs']['last_200_time_ago'] = array(
			'avg' => $avg_last_200_time_ago,
			'max' => $max_last_200_time_ago,
			'min' => $min_last_200_time_ago,
		);
		/*=======================End last_200_time_ago===============================*/

		//////////////////////////////////////////////////////////////////////////////////
		/*                    Calculate Up/Down Percentage                                */
		//////////////////////////////////////////////////////////////////////////////////
		/*        $search_arr3['coin'] = $coin_symbol;
			$datetime = date("Y-m-d H:i:s", strtotime("-7 days"));
			$search_arr3['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($datetime));
			$search_arr3['barrier_type'] = array('$in' => array('up', 'down'));
			$this->mongo_db->where($search_arr3);
			$this->mongo_db->order_by(array('_id' => 1));
			$get3 = $this->mongo_db->get('barrier_values_collection');
			$pre_res3 = iterator_to_array($get3);

			for ($i = 0; $i < count($pre_res3); $i++) {
			$barrier_1 = $pre_res3[$i]['barier_value'];
			$barrier_2 = $pre_res3[$i + 1]['barier_value'];
			$breakable_barrier = $pre_res3[$i]['breakable'];
			if ($breakable_barrier == 'breakable') {
			$breakable++;
			}
			if ($breakable_barrier == 'non_breakable') {
			$non_breakable++;
			}
			$barrier_1_type = $pre_res3[$i]['barrier_type'];
			$barrier_2_type = $pre_res3[$i + 1]['barrier_type'];
			if ($barrier_1_type != $barrier_2_type && ($i < (count($pre_res3) - 1))) {
			$barrier_per[] = number_format(((($barrier_1 - $barrier_2) / $barrier_1) * 100), 2);

			}
			}
	 */

		// echo "<pre>";
		// print_r($returnArr);
		// exit;
		$data['up_indicators'] = $returnArr['ups'];
		$data['down_indicators'] = $returnArr['downs'];
		$data['profit'] = $profit_loss['profit'];
		$data['loss'] = $profit_loss['loss'];

		$data['up_breakable'] = $up_breakable;
		$data['up_non_breakable'] = $up_non_breakable;
		$data['down_breakable'] = $down_breakable;
		$data['down_non_breakable'] = $down_non_breakable;
		$data['coins'] = $this->mod_coins->get_all_coins();
		$this->stencil->paint('admin/coin_meta/listing_indicator', $data);
	}
	public function reset_filters_report($type)
	{
		$this->session->unset_userdata('filter_order_data');
		if ($type == 'coin') {
			redirect(base_url() . 'admin/reports/coin_report');
		}
		if ($type == 'meta') {
			redirect(base_url() . 'admin/reports/meta_coin_report');
		}
		if ($type == 'percentile') {
			redirect(base_url() . 'admin/reports/meta_coin_report_percentile');
		}
		redirect(base_url() . 'admin/reports/order_reports');
	}

	public function order_reports()
	{
		//Login Check
		// ini_set("display_errors", E_ALL);
		// error_reporting(E_ALL);
		$this->mod_login->verify_is_admin_login();
		if ($this->input->post()) {
			$data_arr['filter_order_data'] = $this->input->post();
			$this->session->set_userdata($data_arr);
		}

		$session_data = $this->session->userdata('filter_order_data');
		if (isset($session_data)) {

			$collection = "buy_orders";
			if ($session_data['filter_by_coin']) {
				$search['symbol'] = $session_data['filter_by_coin'];
			}
			if ($session_data['filter_by_mode']) {
				$search['application_mode'] = $session_data['filter_by_mode'];
			}
			if ($session_data['filter_by_trigger']) {
				$search['trigger_type'] = $session_data['filter_by_trigger'];
			}
			if ($session_data['filter_by_rule'] != "") {
				$filter_by_rule = $session_data['filter_by_rule'];
				//$search['$or'] = array("buy_rule_number" => $filter_by_rule, "sell_rule_number" => $filter_by_rule);
				$search['$or'] = array(
					array("buy_rule_number" => intval($filter_by_rule)),
					array("sell_rule_number" => intval($filter_by_rule)),
				);
			}
			if ($session_data['filter_level'] != "") {
				$order_level = $session_data['filter_level'];
				$search['order_level'] = $order_level;
			}
			if ($session_data['filter_username'] != "") {
				$username = $session_data['filter_username'];
				$admin_id = $this->get_admin_id($username);
				$search['admin_id'] = (string) $admin_id;
			}
			if ($session_data['optradio'] != "") {
				if ($session_data['optradio'] == 'created_date') {
					$oder_arr['created_date'] = -1;
				} elseif ($session_data['optradio'] == 'modified_date') {
					$oder_arr['modified_date'] = -1;
				}
			}
			if ($session_data['filter_by_status'] != "") {
				$order_status = $session_data['filter_by_status'];
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
			if ($session_data['filter_by_start_date'] != "" && $session_data['filter_by_end_date'] != "") {

				$created_datetime = date('Y-m-d G:i:s', strtotime($session_data['filter_by_start_date']));
				$orig_date = new DateTime($created_datetime);
				$orig_date = $orig_date->getTimestamp();
				$start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

				$created_datetime22 = date('Y-m-d G:i:s', strtotime($session_data['filter_by_end_date']));
				$orig_date22 = new DateTime($created_datetime22);
				$orig_date22 = $orig_date22->getTimestamp();
				$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
				$search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
			}

			$search['parent_status'] = array('$ne' => 'parent');
			//$search['status'] = array('$ne' => 'canceled');
			// echo "<pre>";
			// print_r($search);
			// exit;

			$connetct = $this->mongo_db->customQuery();

			$sold1_count = $connetct->sold_buy_orders->count($search);
			$pending1_count = $connetct->buy_orders->count($search);

			$total1_count = $sold1_count + $pending1_count;

			$qr_sold = array('skip' => $skip_sold, 'sort' => array('modified_date' => -1), 'limit' => $limit);
			$qr_pending = array('skip' => $skip_pending, 'sort' => array('modified_date' => -1), 'limit' => $limit);

			$sold_count = $connetct->sold_buy_orders->count($search, $qr_sold);
			$pending_count = $connetct->buy_orders->count($search, $qr_pending);

			$total_count = $sold_count + $pending_count;

			/////////////////////// PAGINATION CODE START HERE /////////////////////////////////////
			$this->load->library("pagination");
			$config = array();
			$config["base_url"] = SURL . "admin/reports/order_reports";
			$config["total_rows"] = $total1_count;
			$config['per_page'] = 250;
			$config['num_links'] = 3;
			$config['use_page_numbers'] = TRUE;
			$config['uri_segment'] = 4;
			$config['reuse_query_string'] = TRUE;
			$config["first_tag_open"] = '<li>';
			$config["first_tag_close"] = '</li>';
			$config["last_tag_open"] = '<li>';
			$config["last_tag_close"] = '</li>';
			$config['next_link'] = '&raquo;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
			$config['cur_tag_close'] = '</b></a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);
			$page = $this->uri->segment(4);

			if (!isset($page)) {
				$page = 1;
			}
			$start = ($page - 1) * $config["per_page"];
			$skip = $start;
			$skip_sold = $skip;
			$skip_pending = $skip;
			$limit = $config["per_page"];
			////////////////////////////End Pagination Code///////////////////////////////////////

			$data['pagination'] = $this->pagination->create_links();

			/////////////////////// PAGINATION CODE END HERE /////////////////////////////////////
			$sold_percentage = ($sold_count / $total_count) * 100;
			$pending_percentage = ($pending_count / $total_count) * 100;

			$pending_limit = (500 / 100) * $pending_percentage;
			$sold_limit = (500 / 100) * $sold_percentage;

			$pending_options = array('skip' => $skip_pending, 'sort' => array('modified_date' => -1), 'limit' => intval($pending_limit));

			$sold_options = array('skip' => $skip_sold, 'sort' => array('modified_date' => -1), 'limit' => intval($sold_limit));

			// $skip_sold = $skip_sold +(int)$sold_limit;
			// $skip_pending = $skip_pending +(int)$pending_limit;
			// $this->session->set_userdata(array('skip_sold'=>$skip_sold,'skip_pending'=>$skip_pending));

			$pending_curser = $connetct->buy_orders->find($search, $pending_options);
			$sold_curser = $connetct->sold_buy_orders->find($search, $sold_options);

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
			// echo "<pre>";
			// print_r($new_order_arrray);exit;
			// $new_order_arrray['average'] = $test_arr;
			$data['orders'] = $new_order_arrray;
		}
		$coins = $this->mod_coins->get_all_coins();
		$data['coins'] = $coins;
		$this->stencil->paint('admin/reports/my_custom_order_report', $data);
	} //End of order_reports

	// working on order_reports_admin

	public function order_reports_admin()
	{

		//Login Check
		$this->mod_login->verify_is_admin_login();
		if ($this->input->post()) {

			$data_arr['filter_order_data'] = $this->input->post();
			$this->session->set_userdata($data_arr);
			$collection = "buy_orders";
			if ($this->input->post('filter_by_coin')) {
				$search['symbol'] = $this->input->post('filter_by_coin');
			}
			if ($this->input->post('filter_by_mode')) {
				$search['application_mode'] = $this->input->post('filter_by_mode');
			}
			if ($this->input->post('filter_by_trigger')) {
				$search['trigger_type'] = $this->input->post('filter_by_trigger');
			}
			if ($this->input->post('filter_level') != "") {
				$order_level = $this->input->post('filter_level');
				$search['order_level'] = $order_level;
			}
			if ($this->input->post('filter_username') != "") {
				$username = $this->input->post('filter_username');
				$admin_id = $this->get_admin_id($username);
				$search['admin_id'] = (string) $admin_id;
			}
			if ($this->input->post('optradio') != "") {
				if ($this->input->post('optradio') == 'created_date') {
					$oder_arr['created_date'] = -1;
				} elseif ($this->input->post('optradio') == 'modified_date') {
					$oder_arr['modified_date'] = -1;
				}
			}
			if ($this->input->post('filter_by_status') != "") {
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

			foreach ($orders as $key => $value) {

				$total_sold_orders++;
				$market_sold_price = $value['market_sold_price'];
				$current_order_price = $value['market_value'];
				$quantity = $value['quantity'];

				$current_data2222 = $market_sold_price - $current_order_price;
				$profit_data = ($current_data2222 * 100 / $market_sold_price);

				$profit_data = number_format((float) $profit_data, 2, '.', '');
				$total_btc = $quantity * (float) $current_order_price;
				$total_profit += $total_btc * $profit_data;
				$total_quantity += $total_btc;
			}
			if ($total_quantity == 0) {
				$total_quantity = 1;
			}
			$avg_profit = $total_profit / $total_quantity;

			$test_arr['total_sold_orders'] = $total_sold_orders;
			$test_arr['avg_profit'] = number_format($avg_profit, 2, '.', '');

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
			// echo "<pre>";
			// print_r($new_order_arrray);exit;

			$order_arr['new_order_arr'] = $new_order_arrray;
			$order_arr['average'] = $test_arr;
			$data['full_arr'] = $order_arr;
		}

		$coins = $this->mod_coins->get_all_coins();
		$data['coins'] = $coins;

		$this->stencil->paint('admin/reports/my_custom_order_report2', $data);
	}

	// end of order_book_admin

	public function get_username_from_user($id)
	{

		// echo $id;
		// echo "<br>";
		if (preg_match('/^[a-f\d]{24}$/i', $id)) {
			$customer = $this->mod_report->get_customer($this->mongo_db->mongoId($id));
		}
		// $customer_name = ucfirst($customer['first_name']).' '.ucfirst($customer['last_name']);
		// $customer_username = $customer['username'];

		return $customer;
	}

	// public function get_error_type($id)
	// {
	// 	$this->mongo_db->limit(1);
	// 	$this->mongo_db->order_by(array('_id' => -1));
	// 	$this->mongo_db->where(array('order_id' => $id, 'type' => array('$in' => array('buy_error', 'sell_error'))));
	// 	$mongo_obj = $this->mongo_db->get('orders_history_log');
	// 	$orders = iterator_to_array($mongo_obj);
	// 	return $orders[0];
	// }

	// public function test_error_type($id)
	// {
	// 	$this->mongo_db->where(array('order_id' => $id, 'type' => array('$in' => array('buy_error', 'sell_error'))));
	// 	$mongo_obj = $this->mongo_db->get('orders_history_log');
	// 	$orders = iterator_to_array($mongo_obj);
	// 	echo "<pre>";
	// 	print_r($orders);
	// 	exit;
	// }

	public function get_admin_id($username)
	{
		$customer = $this->mod_report->get_customer_by_username($username);
		return $customer['_id'];
	}

	function get_all_usernames_ajax()
	{
		$this->mongo_db->sort(array('_id' => -1));
		$get_users = $this->mongo_db->get('users');

		$users_arr = iterator_to_array($get_users);

		$user_name_array = array_column($users_arr, 'username');

		echo json_encode($user_name_array);
		exit;
	}
	public function get_user_info()
	{
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

	// public function test_run()
	// {
	// 	$this_obj = $this->mongo_db->get('users');
	// 	$this_arr = iterator_to_array($this_obj);

	// 	$count = count($this_arr) / 5;
	// 	echo $count;

	// 	for ($i = 0; $i <= count($this_arr); $i++) {
	// 		$search['_id'] = $this_arr[$i]['_id'];
	// 		if (($count * 1) >= $i) {
	// 			$upd_arr['trading_ip'] = "50.28.36.48";
	// 		} elseif (($count * 2) >= $i) {
	// 			$upd_arr['trading_ip'] = "50.28.36.49";
	// 		} elseif (($count * 3) >= $i) {
	// 			$upd_arr['trading_ip'] = "50.28.36.33";
	// 		} elseif (($count * 4) >= $i) {
	// 			$upd_arr['trading_ip'] = "50.28.36.34";
	// 		} elseif (($count * 5) >= $i) {
	// 			$upd_arr['trading_ip'] = "50.28.36.35";
	// 		}
	// 		echo "<pre>";
	// 		print_r($upd_arr);
	// 		echo "<br>";
	// 		$this->mongo_db->where($search);
	// 		$this->mongo_db->set($upd_arr);
	// 		$this->mongo_db->update("users");
	// 	}
	// }

	// public function get_user_order_history()
	// {
	// 	$this->mod_login->verify_is_admin_login();
	// 	$this->load->library("binance_api");
	// 	if ($this->input->post()) {
	// 		$user_id_arr = $this->mod_report->get_customer_by_username($this->input->post("filter_username"));

	// 		$user_id = $user_id_arr['_id'];

	// 		$symbol = $this->input->post("filter_by_coin");
	// 		$data['filter_user_data']['filter_by_coin'] = $symbol;
	// 		$data['filter_user_data']['filter_username'] = $this->input->post("filter_username");
	// 		$order_history = $this->binance_api->get_all_orders_history($symbol, $user_id);
	// 		// echo "<pre>";
	// 		// print_r($order_history);exit;
	// 		$this->mongo_db->where(array('symbol' => $symbol, 'admin_id' => (string) $user_id));
	// 		$get_obj = $this->mongo_db->get('buy_orders');
	// 		$buy_orders1 = iterator_to_array($get_obj);

	// 		$this->mongo_db->where(array('symbol' => $symbol, 'admin_id' => (string) $user_id));
	// 		$get_obj2 = $this->mongo_db->get('sold_buy_orders');
	// 		$buy_orders2 = iterator_to_array($get_obj2);

	// 		$buy_orders = array_merge_recursive($buy_orders1, $buy_orders2);

	// 		$this->mongo_db->where(array('symbol' => $symbol, 'admin_id' => (string) $user_id));
	// 		$get_obj22 = $this->mongo_db->get('orders');
	// 		$sell_orders = iterator_to_array($get_obj22);
	// 		$disp_arr_buy = array();
	// 		$disp_arr_sell = array();
	// 		$disp_arr = array();
	// 		$index = 1;
	// 		if ($_GET['testing']) {
	// 			echo "<pre>";
	// 			print_r($order_history);
	// 			exit;
	// 		}
	// 		foreach ($order_history as $obj) {

	// 			$binance_id = $obj['orderId'];
	// 			$type = $obj['isBuyer'];
	// 			$price = $obj['price'];
	// 			$mil = $obj['time'];
	// 			$seconds = $mil / 1000;
	// 			$time_binance = date("Y-m-d H:i:s", $seconds);

	// 			if (!$type) {
	// 				$new_obj_ = array();
	// 				$search = $this->custom_array_search($sell_orders, 'binance_order_id', $binance_id);
	// 				if ($search != '') {
	// 					$new_obj_['id'] = $sell_orders[$search]['_id'];
	// 					$new_obj_['bid'] = $binance_id;
	// 					$new_obj_['price'] = $price;
	// 					$new_obj_['type'] = "Sell";
	// 					$new_obj_['btime'] = $time_binance;
	// 					$new_obj_['status'] = "Found On Digiebot";
	// 					$new_obj_['order_status'] = $sell_orders[$search]['status'];
	// 					$new_obj_['qty'] = $sell_orders[$search]['quantity'];
	// 					$new_obj_['dtime'] = $sell_orders[$search]['modified_date']->toDateTime()->format("Y-m-d H:i:s");
	// 					$new_obj_['bqty'] = $obj['qty'];
	// 					$new_obj_['buy_id'] = $buy_orders[$search]['buy_order_id'];
	// 					$new_obj_['url'] = SURL . "admin/sell_orders/edit-order/" . (string) $sell_orders[$search]['_id'];
	// 					$new_obj_['ID'] = (string) $sell_orders[$search]['_id'];

	// 					array_push($disp_arr_sell, $new_obj_);
	// 				} else {
	// 					$new_obj_['id'] = '';
	// 					$new_obj_['bid'] = $binance_id;
	// 					$new_obj_['type'] = "Sell";
	// 					$new_obj_['price'] = $price;
	// 					$new_obj_['bqty'] = $obj['qty'];
	// 					$new_obj_['btime'] = $time_binance;
	// 					$new_obj_['status'] = "Not Found On Digiebot";
	// 					$new_obj_['url'] = '';
	// 					array_push($disp_arr_sell, $new_obj_);
	// 				}
	// 			} else {
	// 				$new_obj = array();
	// 				$search = $this->custom_array_search($buy_orders, 'binance_order_id', $binance_id);
	// 				if ($search != '') {
	// 					$new_obj['id'] = $buy_orders[$search]['_id'];
	// 					$new_obj['bid'] = $binance_id;
	// 					$new_obj['bid1'] = $obj['id'];
	// 					$new_obj['btime'] = $time_binance;
	// 					$new_obj['type'] = "Buy";
	// 					$new_obj['price'] = $price;
	// 					$new_obj['status'] = "Found On Digiebot";
	// 					$new_obj['qty'] = $buy_orders[$search]['quantity'];
	// 					$new_obj['bqty'] = $obj['qty'];
	// 					$new_obj['order_status'] = $buy_orders[$search]['status'];
	// 					$new_obj['buy_id'] = $buy_orders[$search]['sell_order_id'];
	// 					$new_obj['dtime'] = $buy_orders[$search]['created_date']->toDateTime()->format("Y-m-d H:i:s");
	// 					$new_obj['url'] = SURL . "admin/buy_orders/edit-buy-order/" . (string) $buy_orders[$search]['_id'];
	// 					$new_obj['cID'] = (string) $buy_orders[$search]['sell_order_id'];
	// 					array_push($disp_arr_buy, $new_obj);
	// 				} else {
	// 					$new_obj['id'] = '';
	// 					$new_obj['bid'] = $binance_id;
	// 					$new_obj['price'] = $price;
	// 					$new_obj['type'] = "Buy";
	// 					$new_obj['btime'] = $time_binance;
	// 					$new_obj['bqty'] = $obj['qty'];
	// 					$new_obj['btime'] = $time_binance;
	// 					$new_obj['status'] = "Not Found On Digiebot";
	// 					$new_obj['url'] = '';
	// 					array_push($disp_arr_buy, $new_obj);
	// 				}
	// 			}

	// 			$disp_arr[] = $new_obj;
	// 		}

	// 		$sellArr = array();
	// 		$full_arr = array();
	// 		foreach ($disp_arr_buy as $row) {
	// 			$cID = $row['cID'];
	// 			$newone = array();
	// 			foreach ($disp_arr_sell as $one) {
	// 				if ($cID == $one['ID']) {
	// 					$newone = $one;
	// 					break;
	// 				}
	// 			}
	// 			$arr['buy'] = $row;
	// 			$arr['sell'] = $newone;
	// 			$full_arr[] = $arr;
	// 		}

	// 		$new_buy_1 = array();
	// 		foreach ($full_arr as $key) {
	// 			$buy_1[] = $key['buy'];
	// 		}

	// 		foreach ($disp_arr_buy as $key1) {

	// 			$cID = $key1['bid'];
	// 			$is_found = true;
	// 			foreach ($buy_1 as $one) {
	// 				if ($cID == $one['bid']) {
	// 					$is_found = false;
	// 					break;
	// 				}
	// 			}

	// 			if ($is_found) {
	// 				$new_buy_1[] = $key1;
	// 			}
	// 		}

	// 		$sell_1 = array();
	// 		foreach ($full_arr as $key) {
	// 			$sell_1[] = $key['sell'];
	// 		}

	// 		// echo '<Pre>';
	// 		// print_r($sell_1);
	// 		// print_r($disp_arr_sell);
	// 		// exit;

	// 		$new_sell_1 = array();
	// 		foreach ($disp_arr_sell as $key1) {

	// 			$cID = $key1['bid'];
	// 			$is_found = true;
	// 			foreach ($sell_1 as $one) {
	// 				if ($cID == $one['bid']) {
	// 					$is_found = false;
	// 					break;
	// 				}
	// 			}

	// 			if ($is_found) {
	// 				$new_sell_1[] = $key1;
	// 			}
	// 		}
	// 		$arr = array();

	// 		if (!empty($new_buy_1)) {
	// 			foreach ($new_buy_1 as $value) {
	// 				$arr['buy'] = $value;
	// 			}
	// 		}
	// 		if (!empty($new_sell_1)) {
	// 			foreach ($new_sell_1 as $value) {
	// 				$arr['sell'] = $value;
	// 			}
	// 		}

	// 		// $buy[]

	// 		// foreach ($arr as  $value) {
	// 		//     if (!empty($value)) {
	// 		//         $arr1['sell'] = $value;
	// 		//          $full_arr[] = $arr1;
	// 		//     }
	// 		// }

	// 		array_push($full_arr, $arr);

	// 		$data['resp'] = $full_arr;
	// 	}
	// 	$coins = $this->mod_coins->get_all_coins();
	// 	$data['coins'] = $coins;
	// 	$this->stencil->paint('admin/reports/user_order_report', $data);
	// }

	// function custom_array_search($array, $field, $value)
	// {
	// 	foreach ($array as $key => $index) {
	// 		if ($index[$field] === $value) {
	// 			return $key;
	// 		}
	// 	}
	// 	return false;
	// }

	// public function user_ledger()
	// {
	// 	$this->mod_login->verify_is_admin_login();
	// 	$this->load->library("binance_api");
	// 	if ($this->input->post()) {
	// 		$user_id_arr = $this->mod_report->get_customer_by_username($this->input->post("filter_username"));

	// 		$user_id = $user_id_arr['_id'];
	// 		$symbol = $this->input->post("filter_by_coin");
	// 		$data['filter_user_data']['filter_by_coin'] = $symbol;
	// 		$data['filter_user_data']['filter_username'] = $this->input->post("filter_username");
	// 		$order_history = $this->binance_api->get_all_orders_history($symbol, $user_id);
	// 		$mytype = "";
	// 		$myarr = array();
	// 		foreach ($order_history as $obj) {
	// 			$test = array();
	// 			$binance_id = $obj['orderId'];
	// 			$type = $obj['isBuyer'];
	// 			$price = $obj['price'];
	// 			$mil = $obj['time'];
	// 			$qty = $obj['qty'];
	// 			$seconds = $mil / 1000;
	// 			$time_binance = date("l jS \of F Y h:i:s A", $seconds);

	// 			if (!$type) {
	// 				$mytype = "sell";
	// 				$test['credit'] = $qty;
	// 			} else {
	// 				$mytype = "buy";
	// 				$test['debit'] = $qty;
	// 			}
	// 			$test['type'] = $mytype;
	// 			$test['price'] = $price;
	// 			$test['binance_id'] = $binance_id;
	// 			$test['time'] = $time_binance;
	// 			$myarr[] = $test;
	// 		}
	// 		$data['rearrangedFinalData'] = $myarr;
	// 	}
	// 	$coins = $this->mod_coins->get_all_coins();
	// 	$data['coins'] = $coins;
	// 	$this->stencil->paint('admin/reports/ledger', $data);
	// }

	// public function user_trade_history_report()
	// {
	// 	$this->mod_login->verify_is_admin_login();
	// 	if ($this->input->post()) {
	// 		$user_id_arr = $this->mod_report->get_customer_by_username($this->input->post("filter_username"));
	// 		$user_id = $user_id_arr['_id'];
	// 		$data['rearrangedFinalData'] = $this->get_user_trade_info($user_id);
	// 	}

	// 	$this->stencil->paint('admin/reports/user_trade_history_report', $data);
	// }

	// public function user_trade_profit_report()
	// {
	// 	$this->mod_login->verify_is_admin_login();
	// 	if ($this->input->post()) {
	// 		$user_id_arr = $this->mod_report->get_customer_by_username($this->input->post("filter_username"));
	// 		$user_id = $user_id_arr['_id'];
	// 		$data['rearrangedFinalData'] = $this->get_user_trade_info($user_id);
	// 	}

	// 	$this->stencil->paint('admin/reports/user_profit_report', $data);
	// }

	// public function get_user_trade_info($user_id = '')
	// {
	// 	$this->mod_login->verify_is_admin_login();
	// 	$this->mongo_db->where(array("admin_id" => (string) $user_id, 'status' => 1));
	// 	$get_response = $this->mongo_db->get("user_account_history");
	// 	$totalBTCspent = 0;
	// 	$totalBTCgain = 0;
	// 	$fullArr = array();
	// 	foreach ($get_response as $key => $value) {
	// 		$retArr = array();

	// 		$retArr['buy_id'] = $value['buy_id'];
	// 		$retArr['coin'] = $value['coin'];
	// 		$retArr['buy_fee_deducted'] = $value['buy_fee_deducted'];
	// 		$retArr['buy_fee_symbol'] = $value['buy_fee_symbol'];
	// 		$retArr['buy_price'] = $value['buy_price'];
	// 		$retArr['buy_qty'] = $value['buy_qty'];
	// 		$retArr['totalBuyBTC'] = ($value['buy_price'] * $value['buy_qty']);
	// 		$retArr['buy_time_btc_usd'] = $value['buy_time_btc_usd'];
	// 		$retArr['buy_time_wallet'] = $value['buy_time_wallet'];
	// 		$retArr['fee_in_btc'] = $value['fee_in_btc'];
	// 		$retArr['sell_fee_deducted'] = $value['sell_fee_deducted'];
	// 		$retArr['sell_fee_in_btc'] = $value['sell_fee_in_btc'];
	// 		$retArr['sell_fee_symbol'] = $value['sell_fee_symbol'];
	// 		$retArr['sell_price'] = $value['sell_price'];
	// 		$retArr['totalSoldBTC'] = ($value['sell_price'] * $value['buy_qty']);
	// 		$retArr['sell_time_btc_usd'] = $value['sell_time_btc_usd'];
	// 		$retArr['sell_time_wallet'] = $value['sell_time_wallet'];
	// 		$retArr['ProfitLossBTC'] = ((($retArr['totalSoldBTC'] - ($retArr['totalBuyBTC'] + $retArr['sell_fee_in_btc'] + $retArr['fee_in_btc'])) / $retArr['totalSoldBTC']) * 100);
	// 		if (!empty($value['buy_qty'])) {
	// 			$totalBTCspent += $retArr['totalBuyBTC'];
	// 			$totalBTCgain += $retArr['totalSoldBTC'];
	// 			array_push($fullArr, $retArr);
	// 		}
	// 	}
	// 	return $fullArr;
	// }

	// public function get_order_error($order_id)
	// {

	// 	$this->mongo_db->where(array('order_id' => $this->mongo_db->mongoId($order_id), 'type' => array('$in' => array('sell_error', 'buy_error'))));
	// 	$this->mongo_db->order_by(array('_id' => -1));
	// 	$get = $this->mongo_db->get('orders_history_log');
	// 	$error_orders = iterator_to_array($get);

	// 	return $error_orders[0]['log_msg'];
	// }

	// public function get_buy_order_error_ajax()
	// {
	// 	$order_id = $this->input->post('order_id');

	// 	$get_arror = $this->get_order_error($order_id);

	// 	$response = '<div class="row">
	// 											<div class="col-md-6">
	// 													<label for="inputTitle">Error :</label>
	// 											</div>
	// 											<div class="col-md-6">
	// 													<p>' . $get_arror . '</p>
	// 											</div>
	// 										</div>';
	// 	$order_arr = $this->mod_buy_orders->get_buy_order($order_id);
	// 	$response .= '<form method="post" action="' . SURL . 'admin/reports/update_manual_order"><div class="row">
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
	// 										</div>';
	// 	$response .= '<div class="row">
	// 										<div class="col-md-12">
	// 												<button type="submit" class="btn btn-success">Remove Error</button>
	// 												<a href="' . SURL . 'admin/buy_orders/get_errors_detail/" class="custom_link" target="_blank">Click here to Check Error Detail</a>
	// 										</div>
	// 									</div></form>';
	// 	echo $response;
	// 	exit;
	// }
	// public function update_manual_order()
	// {
	// 	$id = $this->input->post('order_id');
	// 	$current_date = date("Y-m-d H:i:s");
	// 	$post_edit_data['modified_date'] = $this->mongo_db->converToMongodttime($current_date);

	// 	$this->mongo_db->where(array('_id' => $id));
	// 	$this->mongo_db->set($post_edit_data);
	// 	$this->mongo_db->update('buy_orders');

	// 	$this->mongo_db->where(array('_id' => $id));
	// 	$resp = $this->mongo_db->get('buy_orders');
	// 	$data = iterator_to_array($resp);

	// 	foreach ($data as $row) {
	// 		$sell_order_id = (string) $row['sell_order_id'];
	// 		$post_edit_data['status'] = 'new';
	// 		$this->mongo_db->set($post_edit_data);
	// 		$this->mongo_db->where(array('_id' => $sell_order_id));
	// 		$this->mongo_db->update('orders');
	// 	}

	// 	// $this->mongo_db->where(array('buy_order_id' => $this->mongo_db->mongoId($id)));
	// 	// $post_edit_data['status'] = 'new';
	// 	// $this->mongo_db->set($post_edit_data);
	// 	// $this->mongo_db->update('orders');

	// 	$admin_id = $this->session->userdata('admin_id');
	// 	$message = 'Order was updated';
	// 	$log_msg = $message . " And Moved From Error To Open";
	// 	$this->mod_buy_orders->insert_order_history_log($id, $log_msg, 'sell_created', $admin_id, $current_date);

	// 	redirect(base_url() . 'admin/buy_orders');
	// }

	// public function waqar_test_order()
	// {
	// 	$symbol = "TRXBTC";
	// 	$binance_order_id = "85610009";
	// 	$admin_id = "5c0912d4fc9aadaac61dd07d";
	// 	$ID = "5c4e4180fc9aad623e3ac562";
	// 	$order_status = $this->binance_api->order_status($symbol, $binance_order_id, $admin_id);

	// 	if ($order_status['status'] == 'FILLED') {
	// 		$post_edit_data['status'] = 'submitted';
	// 		$this->mongo_db->set($post_edit_data);
	// 		$this->mongo_db->where(array('_id' => $ID));
	// 		$res = $this->mongo_db->update('orders');
	// 		echo '<pre>';
	// 		print_r($res);
	// 	}
	// }

	// public function get_order_status($value = '')
	// {
	// 	$symbol = "XRPBTC";
	// 	$order_id = 107150442;
	// 	$user_id = "5c0914b6fc9aadaac61dd13d";
	// 	$orderstatus = $this->binance_api->order_status($symbol, $order_id, $user_id);

	// 	echo "<pre>";
	// 	print_r($orderstatus);
	// 	exit();
	// }

	// public function test_waqar()
	// {
	// 	$where['_id'] = '5c362130fc9aad934e00cc57';
	// 	$upd['is_sell_order'] = 'sold';
	// 	$upd['market_sold_price'] = (float) '0.00009107';
	// 	$this->mongo_db->where($where);
	// 	$this->mongo_db->set($upd);
	// 	$set[] = $this->mongo_db->update('buy_orders');

	// 	$where1['_id'] = '5c362133fc9aad950d7af85b';
	// 	$upd1['status'] = 'FILLED';
	// 	$upd1['binance_order_id'] = '110152086';
	// 	$upd1['market_value'] = (float) '0.00009107';
	// 	$this->mongo_db->where($where1);
	// 	$this->mongo_db->set($upd1);
	// 	$set[] = $this->mongo_db->update('orders');

	// 	echo "<pre>";
	// 	print_r($set);
	// 	exit;
	// }

	// public function test_waqar_update()
	// {
	// 	$where['_id'] = '5c2a62e3fc9aad27d1202c0c';
	// 	$upd['quantity'] = 2000.00;
	// 	$upd['market_sold_price'] = (float) '0.00000500';
	// 	$this->mongo_db->where($where);
	// 	$this->mongo_db->set($upd);
	// 	$set[] = $this->mongo_db->update('buy_orders');

	// 	$where1['_id'] = '5c2a62f0fc9aad33092eda08';
	// 	$upd1['status'] = 'FILLED';
	// 	$upd1['binance_order_id'] = '83625487';
	// 	$upd1['quantity'] = 2000.00;
	// 	$upd1['market_value'] = (float) '0.00000500';
	// 	$this->mongo_db->where($where1);
	// 	$this->mongo_db->set($upd1);
	// 	$set[] = $this->mongo_db->update('orders');

	// 	echo "<pre>";
	// 	print_r($set);
	// 	exit;
	// }

	// public function run($value = "admin")
	// {

	// 	$user_id_arr = $this->mod_report->get_customer_by_username($value);

	// 	echo "<pre>";
	// 	print_r($user_id_arr);

	// 	$user_id = $user_id_arr['_id'];
	// 	//5c0912b7fc9aadaac61dd072
	// 	$this->load->library("binance_api");
	// 	//$user_id = "5c0912b7fc9aadaac61dd072";

	// 	$deposit = $this->binance_api->get_all_deposit_history($user_id);
	// 	$withdraw = $this->binance_api->get_all_withdraw_history($user_id);

	// 	echo "<pre>";
	// 	echo "<br>Deposit History <br>";
	// 	print_r($deposit);

	// 	echo "<br>Withdraw History <br>";
	// 	print_r($withdraw);
	// 	exit;
	// }

	// public function run2($value = ''){
	// 	//load the view and saved it into $html variable
	// 	$user_id_arr = $this->mod_report->get_customer_by_username($value);
	// 	$user_id = $user_id_arr['_id'];
	// 	$data['rearrangedFinalData'] = $this->get_user_trade_info($user_id);
	// 	$html = $this->load->view('admin/reports/user_trade_history_report', $data, true);

	// 	//this the the PDF filename that user will get to download
	// 	$pdfFilePath = "output_pdf_name.pdf";

	// 	//load mPDF library
	// 	$this->load->library('m_pdf');
	// 	$path = SURL . "assets/css/admin/module.admin.page.index.min.css";
	// 	$css = file_get_contents($path);
	// 	//generate the PDF from the given html
	// 	$this->m_pdf->pdf->WriteHTML($css);
	// 	$this->m_pdf->pdf->WriteHTML($html);

	// 	//download it.
	// 	$this->m_pdf->pdf->Output($pdfFilePath, "D");
	// }

	// public function csv_export_trades()
	// {

	// 	$data_arr['filter_order_data'] = $this->input->post();
	// 	$session_post_data = $this->session->userdata('filter_order_data');

	// 	$collection = "buy_orders";
	// 	if ($session_post_data['filter_by_coin']) {
	// 		$search['symbol'] = $session_post_data['filter_by_coin'];
	// 	}
	// 	if ($session_post_data['filter_by_mode']) {
	// 		$search['application_mode'] = $session_post_data['filter_by_mode'];
	// 	}
	// 	if ($session_post_data['filter_by_trigger']) {
	// 		$search['trigger_type'] = $session_post_data['filter_by_trigger'];
	// 	}
	// 	if ($session_post_data['filter_level']) {
	// 		$order_level = $session_post_data['filter_level'];
	// 		$search['order_level'] = $order_level;
	// 	}
	// 	if ($session_post_data['filter_username']) {
	// 		$username = $session_post_data['filter_username'];
	// 		$admin_id = $this->get_admin_id($username);
	// 		$search['admin_id'] = (string) $admin_id;
	// 	}
	// 	if ($session_post_data['optradio']) {
	// 		if ($session_post_data['optradio'] == 'created_date') {
	// 			$oder_arr['created_date'] = -1;
	// 		} elseif ($session_post_data['optradio'] == 'modified_date') {
	// 			$oder_arr['modified_date'] = -1;
	// 		}
	// 	}
	// 	if ($session_post_data['filter_by_status']) {
	// 		$order_status = $this->input->post('filter_by_status');
	// 		if ($order_status == 'new') {
	// 			$search['status'] = 'new';
	// 		} elseif ($order_status == 'error') {
	// 			$search['status'] = 'error';
	// 		} elseif ($order_status == 'open') {
	// 			$search['status'] = array('$in' => array('submitted', 'FILLED'));
	// 			$search['is_sell_order'] = 'yes';
	// 		} elseif ($order_status == 'sold') {
	// 			$search['status'] = 'FILLED';
	// 			$search['is_sell_order'] = 'sold';
	// 			$collection = "sold_buy_orders";
	// 		}
	// 	}
	// 	if ($session_post_data['filter_by_start_date'] != "" && $session_post_data['filter_by_end_date'] != "") {

	// 		$created_datetime = date('Y-m-d G:i:s', strtotime($session_post_data['filter_by_start_date']));
	// 		$orig_date = new DateTime($created_datetime);
	// 		$orig_date = $orig_date->getTimestamp();
	// 		$start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

	// 		$created_datetime22 = date('Y-m-d G:i:s', strtotime($session_post_data['filter_by_end_date']));
	// 		$orig_date22 = new DateTime($created_datetime22);
	// 		$orig_date22 = $orig_date22->getTimestamp();
	// 		$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
	// 		$search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
	// 	}
	// 	$search['parent_status'] = array('$ne' => 'parent');
	// 	//$search['status'] = array('$ne' => 'canceled');

	// 	$connetct = $this->mongo_db->customQuery();
	// 	$pending_curser = $connetct->buy_orders->find($search);
	// 	$sold_curser = $connetct->sold_buy_orders->find($search);

	// 	$pending_arr = iterator_to_array($pending_curser);
	// 	$sold_arr = iterator_to_array($sold_curser);

	// 	$orders = array_merge_recursive($pending_arr, $sold_arr);

	// 	foreach ($orders as $key => $part) {
	// 		$sort[$key] = (string) $part['modified_date'];
	// 	}

	// 	array_multisort($sort, SORT_DESC, $orders);

	// 	$new_order_arrray = array();
	// 	foreach ($orders as $order) {
	// 		$id = $order['admin_id'];
	// 		$data_user = $this->get_username_from_user($id);
	// 		$order['admin'] = $data_user;
	// 		$_id = $order['_id'];

	// 		$error = $this->get_error_type($_id);
	// 		$order['log'] = $error;
	// 		array_push($new_order_arrray, $order);
	// 	}
	// 	//$data['orders'] = $new_order_arrray;

	// 	$full_arr = array();
	// 	foreach ($new_order_arrray as $key => $value) {
	// 		if (!empty($value)) {
	// 			$retArr = array();

	// 			if (isset($value['5_hour_max_market_price']) && $value['5_hour_max_market_price'] != '') {

	// 				$five_hour_max_market_price = $value['5_hour_max_market_price'];
	// 				$purchased_price = (float) $value['market_value'];
	// 				$profit = $five_hour_max_market_price - $purchased_price;

	// 				$profit_margin = ($profit / $five_hour_max_market_price) * 100;

	// 				$max_profit_per = ($profit) * (100 / $purchased_price);

	// 				$max_profit_per = number_format($max_profit_per, 2);
	// 			}

	// 			if (isset($value['5_hour_min_market_price']) && $value['5_hour_min_market_price'] != '') {

	// 				$market_lowest_value = $value['5_hour_min_market_price'];
	// 				$purchased_price = (float) $value['market_value'];
	// 				$profit = $market_lowest_value - $purchased_price;

	// 				$profit_margin = ($profit / $market_lowest_value) * 100;

	// 				$min_profit_per = ($profit) * (100 / $purchased_price);
	// 				$min_profit_per = number_format($min_profit_per, 2);
	// 			}

	// 			if (isset($value['market_heighest_value']) && $value['market_heighest_value'] != '') {

	// 				$five_hour_max_market_price1 = $value['market_heighest_value'];
	// 				$purchased_price1 = (float) $value['market_value'];
	// 				$profit1 = $five_hour_max_market_price1 - $purchased_price1;

	// 				$profit_margin1 = ($profit1 / $five_hour_max_market_price1) * 100;

	// 				$max_profit_per1 = ($profit1) * (100 / $purchased_price1);

	// 				$max_profit_per1 = number_format($max_profit_per1, 2);
	// 			}

	// 			if (isset($value['market_lowest_value']) && $value['market_lowest_value'] != '') {

	// 				$market_lowest_value2 = $value['market_lowest_value'];
	// 				$purchased_price2 = (float) $value['market_value'];
	// 				$profit2 = $market_lowest_value2 - $purchased_price2;

	// 				$profit_margin2 = ($profit2 / $market_lowest_value2) * 100;

	// 				$min_profit_per2 = ($profit2) * (100 / $purchased_price2);
	// 				$min_profit_per2 = number_format($min_profit_per2, 2);
	// 			}

	// 			$this->load->model('admin/mod_dashboard');

	// 			$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

	// 			if ($value['status'] == 'FILLED') {

	// 				if ($value['is_sell_order'] == 'yes') {

	// 					$current_data = num($market_value) - num($value['market_value']);
	// 					$market_data = ($current_data * 100 / $market_value);
	// 					$market_data = number_format((float) $market_data, 2, '.', '');
	// 				}
	// 				if ($value['is_sell_order'] == 'sold') {
	// 					$current_data = num($value['market_sold_price']) - num($value['market_value']);
	// 					$market_data = ($current_data * 100 / $value['market_sold_price']);
	// 					$market_data = number_format((float) $market_data, 2, '.', '');
	// 				}
	// 			}

	// 			$retArr['id'] = $value['_id'];
	// 			$retArr['symbol'] = $value['symbol'];
	// 			$retArr['price'] = $value['price'];
	// 			$retArr['quantity'] = $value['quantity'];
	// 			$retArr['order_type'] = $value['order_type'];
	// 			$retArr['trigger_type'] = $value['trigger_type'];
	// 			$retArr['binance_order_id'] = $value['binance_order_id'];
	// 			$retArr['buy_parent_id'] = $value['buy_parent_id'];
	// 			$retArr['application_mode'] = $value['application_mode'];
	// 			$retArr['defined_sell_percentage'] = $value['defined_sell_percentage'];
	// 			$retArr['order_level'] = $value['order_level'];
	// 			$retArr['status'] = $value['status'];
	// 			$retArr['is_sell_order'] = $value['is_sell_order'];
	// 			$retArr['market_value'] = $value['market_value'];
	// 			$retArr['sell_order_id'] = $value['sell_order_id'];
	// 			$retArr['is_manual_buy'] = $value['is_manual_buy'];
	// 			$retArr['is_manual_sold'] = $value['is_manual_sold'];
	// 			$retArr['sell_rule_number'] = $value['sell_rule_number'];
	// 			$retArr['buy_rule_number'] = $value['buy_rule_number'];
	// 			$retArr['market_sold_price'] = $value['market_sold_price'];
	// 			$retArr['profit_data'] = $market_data;
	// 			$retArr['5_hour_max_market_price'] = $value['5_hour_max_market_price'];
	// 			$retArr['5_hour_min_market_price'] = $value['5_hour_min_market_price'];
	// 			$retArr['five_hour_max_profit'] = $max_profit_per;
	// 			$retArr['five_hour_min_profit'] = $min_profit_per;
	// 			$retArr['market_heighest_value'] = $value['market_heighest_value'];
	// 			$retArr['market_lowest_value'] = $value['market_lowest_value'];
	// 			$retArr['market_heighest_profit'] = $max_profit_per1;
	// 			$retArr['market_lowest_profit'] = $min_profit_per2;
	// 			$retArr['username'] = $value['admin']['username'];
	// 			$retArr['email_address'] = $value['admin']['email_address'];
	// 			$retArr['created_date'] = $value['created_date']->toDatetime()->format("d-M, Y H:i:s");
	// 			$retArr['modified_date'] = $value['modified_date']->toDatetime()->format("d-M, Y H:i:s");
	// 			$retArr['created_time_ago'] = time_elapsed_string($value['created_date']->toDatetime()->format("Y-m-d H:i:s"));
	// 			$retArr['last_updated'] = time_elapsed_string($value['modified_date']->toDatetime()->format("Y-m-d H:i:s"));

	// 			$fullarray[] = $retArr;
	// 		}
	// 	}
	// 	$this->download_send_headers("order_report_" . date("Y-m-d_ Gisa") . ".csv");

	// 	echo $this->array2csv($fullarray);

	// 	exit;
	// }

	// public function coin_report()
	// {



	// 	$this->mod_login->verify_is_admin_login();
	// 	if ($this->input->post()) {

	// 		$data_arr['filter_order_data'] = $this->input->post();
	// 		$this->session->set_userdata($data_arr);

	// 		$collection = "buy_orders";
	// 		$coin_array = array();
	// 		if (!empty($this->input->post('filter_by_coin'))) {
	// 			$coin_array = $this->input->post('filter_by_coin');
	// 			//$search['symbol']['$in'] = $this->input->post('filter_by_coin');
	// 		} else {
	// 			$coin_array_all = $this->mod_coins->get_all_coins();
	// 			$coin_array = array_column($coin_array_all, 'symbol');
	// 		}

	// 		if ($this->input->post('filter_by_mode')) {
	// 			$search['order_mode'] = $this->input->post('filter_by_mode');
	// 		}

	// 		if ($this->input->post('group_filter') != "") {
	// 			if ($this->input->post('group_filter') == 'rule_group') {
	// 				$filter = 'rule';
	// 			} elseif ($this->input->post('group_filter') == 'trigger_group') {
	// 				$filter = 'trigger';
	// 			}
	// 		} else {
	// 			$filter = 'all';
	// 		}

	// 		if ($_POST['filter_by_start_date'] != "" && $_POST['filter_by_end_date'] != "") {

	// 			$created_datetime = date('Y-m-d G:i:s', strtotime($_POST['filter_by_start_date']));
	// 			$orig_date = new DateTime($created_datetime);
	// 			$orig_date = $orig_date->getTimestamp();
	// 			$start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

	// 			$created_datetime22 = date('Y-m-d G:i:s', strtotime($_POST['filter_by_end_date']));
	// 			$orig_date22 = new DateTime($created_datetime22);
	// 			$orig_date22 = $orig_date22->getTimestamp();
	// 			$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
	// 			$search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
	// 		}

	// 		if ($filter == 'all') {


	// 			$conn = $this->mongo_db->customQuery();
	// 			$order_arr_all = array();
	// 			//foreach ($coin_array as $key => $value) {
	// 			$search['symbol'] = $this->input->post('filter_by_coin');
	// 			$db_obj = $conn->sold_buy_orders->find($search);
	// 			$order_arr = iterator_to_array($db_obj);
	// 			$order_arr_all[$value] = $order_arr;
	// 			//}
	// 			$data['full_arr'] = $order_arr_all;
	// 			//echo "<pre>";  print_r($data['full_arr']); exit;
	// 		} else if ($filter == 'trigger') {

	// 			$conn = $this->mongo_db->customQuery();
	// 			$order_arr_all = array();
	// 			$trigger_array = array("barrier_trigger", "barrier_percentile_trigger", "box_trigger");
	// 			//foreach ($coin_array as $key => $value) {
	// 			$search['symbol'] =  $this->input->post('filter_by_coin');
	// 			$coin             =  $this->input->post('filter_by_coin');
	// 			//foreach ($trigger_array as $key1 => $value_trigger) {
	// 			$search['trigger_type'] = $this->input->post('filter_by_trigger');
	// 			$value_trigger          = $this->input->post('filter_by_trigger');
	// 			$db_obj = $conn->sold_buy_orders->find($search);
	// 			$order_arr = iterator_to_array($db_obj);
	// 			$order_arr_all[$value_trigger] = $order_arr;
	// 			//}
	// 			//}	
	// 			$resultArr = $this->make_array_for_view($order_arr_all, 'trigger');
	// 			$data['full_arr'] = $resultArr;
	// 		} elseif ($filter == "rule") {


	// 			if ($this->input->post('filter_by_trigger')) {
	// 				$search['trigger_type'] = $this->input->post('filter_by_trigger');
	// 			}
	// 			$conn = $this->mongo_db->customQuery();
	// 			$order_arr_all = array();
	// 			$trigger_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

	// 			if ($this->input->post('filter_by_trigger') == 'barrier_trigger') {
	// 				$trigger_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
	// 			} elseif ($this->input->post('filter_by_trigger') == 'barrier_percentile_trigger') {
	// 				$trigger_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20);
	// 			}




	// 			//foreach ($coin_array as $key => $value) {
	// 			//$search['symbol'] = $value;
	// 			$search['symbol'] = $this->input->post('filter_by_coin');
	// 			$coin             = $this->input->post('filter_by_coin');
	// 			foreach ($trigger_array as $key1 => $value_trigger) {

	// 				if ($this->input->post('filter_by_trigger') == 'barrier_trigger') {
	// 					$search['buy_rule_number'] = $value_trigger;
	// 				} elseif ($this->input->post('filter_by_trigger') == 'barrier_percentile_trigger') {
	// 					$search['order_level'] = "level_" . $value_trigger;
	// 				}

	// 				//echo "<pre>";  print_r($search); 

	// 				$db_obj = $conn->sold_buy_orders->find($search);
	// 				$order_arr = iterator_to_array($db_obj);


	// 				/* echo "<pre>";  print_r($order_arr); 
	// 						echo "*****************************************";
	// 						echo "<br />";*/
	// 				//$order_arr_all[$value][$value_trigger] = $order_arr;
	// 				$order_arr_all[$value_trigger] = $order_arr;
	// 			}
	// 			//}
	// 			$resultArr = $this->make_array_for_view($order_arr_all, 'trigger', $coin);
	// 			$data['full_arr'] = $resultArr;
	// 		}
	// 	}


	// 	if (!empty($this->input->post())) {
	// 		//echo "<pre>";  print_r($this->input->post()); exit;
	// 	}




	// 	$coins = $this->mod_coins->get_all_coins();
	// 	$data['coins'] = $coins;
	// 	$this->stencil->paint('admin/trigger_rule_report/coin_order_report', $data);
	// }

	// public function array_flatten($array)
	// {

	// 	echo "sdafsdf";

	// 	if (!is_array($array)) {
	// 		return FALSE;
	// 	}
	// 	$result = array();
	// 	foreach ($array as $key => $value) {
	// 		if (is_array($value)) {
	// 			$result = array_merge($result, $this->array_flatten($value));
	// 		} else {
	// 			$result[$key] = $value;
	// 		}
	// 	}
	// 	return $result;
	// }

	// public function coin_report_listing()
	// {


	// 	$this->mod_login->verify_is_admin_login();
	// 	$coin_array_all = $this->mod_coins->get_all_coins();
	// 	if ($this->input->post()) {
	// 		$data_arr['filter_order_data'] = $this->input->post();
	// 		$this->session->set_userdata($data_arr);

	// 		$coin_array = array();
	// 		if (!empty($this->input->post('filter_by_coin'))) {
	// 			$coin_array = $this->input->post('filter_by_coin');
	// 		} else {
	// 			$coin_array = array_column($coin_array_all, 'symbol');
	// 		}
	// 		if (!empty($this->input->post('opp_status'))) {
	// 			$opp_status = $this->input->post('opp_status');
	// 			if ($opp_status == 'open') {
	// 				$collection = "buy_orders";
	// 			} else {
	// 				$collection = "sold_buy_orders";
	// 			}
	// 		}
	// 		if ($this->input->post('filter_by_mode')) {
	// 			$search['order_mode'] = $this->input->post('filter_by_mode');
	// 		}
	// 		if ($this->input->post('filter_by_trigger') != "") {
	// 			$filter_by_trigger = $this->input->post('filter_by_trigger');
	// 		} else {
	// 			$filter_by_trigger = array('barrier_trigger', 'barrier_percentile_trigger', 'no');
	// 		}

	// 		if ($this->input->post('filter_by_level') != "" && $filter_by_trigger == 'barrier_percentile_trigger') {
	// 			$filter_by_level = $this->input->post('filter_by_level');
	// 			$search['order_level']['$in'] = $filter_by_level;
	// 			//print_r($filter_by_level);
	// 		} else {
	// 			$filter_by_level = array('level_1', 'level_2', 'level_3', 'level_4', 'level_5', 'level_6', 'level_7', 'level_8', 'level_9', 'level_10', 'level_11', 'level_12', 'level_13', 'level_14', 'level_16', 'level_17', 'level_18', 'level_19', 'level_20');
	// 		}
	// 		if ($this->input->post('filter_by_rule') != "" && $filter_by_trigger == 'barrier_trigger') {
	// 			$filter_by_rule = $this->input->post('filter_by_rule');
	// 			$search['buy_rule_number']['$in'] = $filter_by_rule;
	// 		} else {
	// 			//$filter_by_rule = array(1,2,3,4,5,6,7,8,9,10);
	// 		}
	// 		if ($_POST['filter_by_start_date'] != "" &&  $_POST['filter_by_end_date'] != "") {
	// 			$created_datetime = date('Y-m-d G:i:s', strtotime($_POST['filter_by_start_date']));
	// 			$orig_date = new DateTime($created_datetime);
	// 			$orig_date = $orig_date->getTimestamp();
	// 			$start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

	// 			$created_datetime22 = date('Y-m-d G:i:s', strtotime($_POST['filter_by_end_date']));
	// 			$orig_date22 = new DateTime($created_datetime22);
	// 			$orig_date22 = $orig_date22->getTimestamp();
	// 			$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
	// 			$search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
	// 		}
	// 		if ($_POST['filter_by_oppertunity_id'] != "") {
	// 			$filter_by_oppertunity_id		= $this->input->post('filter_by_oppertunity_id');
	// 			$search['opportunityId'] =  $filter_by_oppertunity_id;
	// 		}
	// 	} else {

	// 		$coin_array           = array_column($coin_array_all, 'symbol');
	// 		// $opp_status           = 'sold';	
	// 		$collection           = "sold_buy_orders";
	// 		$search['order_mode'] = 'test';
	// 		$filter_by_trigger    = 'barrier_percentile_trigger';
	// 		$search['order_level']['$in'] =  array('level_1', 'level_2', 'level_3', 'level_4', 'level_5', 'level_6', 'level_7', 'level_8', 'level_9', 'level_10', 'level_11', 'level_12', 'level_13', 'level_14', 'level_16', 'level_17', 'level_18', 'level_19', 'level_20');

	// 		$filter_by_end_date    = date('Y-m-d G:i a');
	// 		$filter_by_end_date    = date("m/d/Y H:i a", strtotime($filter_by_end_date));
	// 		$filter_by_start_date  = date('Y-m-d G:i a', strtotime('-1 month'));
	// 		$filter_by_start_date  = date("m/d/Y H:i a", strtotime($filter_by_start_date));

	// 		$array['filter_by_mode']       = $search['order_mode'];
	// 		$array['filter_by_start_date'] = $filter_by_start_date;
	// 		$array['filter_by_end_date']   = $filter_by_end_date;
	// 		// $array['opp_status']           = $opp_status;
	// 		$array['filter_by_trigger']    = $filter_by_trigger;
	// 		$array['filter_by_level']      = $search['order_level']['$in'];
	// 		$array['filter_by_coin']       = $coin_array;

	// 		$data_arr['filter_order_data'] = $array;
	// 		$this->session->set_userdata($data_arr);
	// 	}


	// 	foreach ($coin_array as $coin) {
	// 		$conn = $this->mongo_db->customQuery();
	// 		$search['symbol'] = $coin;
	// 		$search['trigger_type'] = $filter_by_trigger;
	// 		$pending_options = array('skip' => $skip_pending, 'sort' => array('modified_date' => -1), 'limit' => intval(10));
	// 		$db_obj = $conn->$collection->find($search, $pending_options);
	// 		$order_arr = iterator_to_array($db_obj);
	// 		$order_arr_all[$coin] = $order_arr;
	// 	}

	// 	$resultArr    = $this->make_array_for_view_new_test($order_arr_all, 'sold_buy_orders');

	// 	////////////$fianlArrr    = $this->filter_array($resultArr);	

	// 	$data['full_arr'] = $resultArr;
	// 	// $data['buy_arr']  = $resultArr2;
	// 	$data['coin_arr']  = $coin_array;
	// 	// $data['full_arr'] = $fianlArrr;
	// 	$data['coins']    = $coin_array_all;
	// 	$this->stencil->paint('admin/trigger_rule_report/coin_order_report_listing', $data);
	// }

	// public function chart_report_listing()
	// {


	// 	$this->mod_login->verify_is_admin_login();
	// 	$coin_array_all = $this->mod_coins->get_all_coins();

	// 	if ($this->input->post()) {
	// 		$data_arr['filter_order_data'] = $this->input->post();
	// 		$this->session->set_userdata($data_arr);

	// 		$coin_array = array();
	// 		if (!empty($this->input->post('filter_by_coin'))) {
	// 			$coin_array = $this->input->post('filter_by_coin');
	// 		} else {
	// 			$coin_array = array_column($coin_array_all, 'symbol');
	// 		}
	// 		if (!empty($this->input->post('opp_status'))) {
	// 			$opp_status = $this->input->post('opp_status');
	// 			if ($opp_status == 'open') {
	// 				$collection = "buy_orders";
	// 			} else {
	// 				$collection = "sold_buy_orders";
	// 			}
	// 		}
	// 		if ($this->input->post('filter_by_mode')) {
	// 			$search['order_mode'] = $this->input->post('filter_by_mode');
	// 		}

	// 		if ($this->input->post('filter_by_trigger') != "") {
	// 			$filter_by_trigger = $this->input->post('filter_by_trigger');
	// 		} else {
	// 			$filter_by_trigger = array('barrier_trigger', 'barrier_percentile_trigger', 'no');
	// 		}

	// 		if ($this->input->post('filter_by_level') != "" && $filter_by_trigger == 'barrier_percentile_trigger') {
	// 			$filter_by_level = $this->input->post('filter_by_level');
	// 			$search['order_level']['$in'] = $filter_by_level;
	// 		}
	// 		if ($this->input->post('filter_by_rule') != "" && $filter_by_trigger == 'barrier_trigger') {
	// 			$filter_by_rule = $this->input->post('filter_by_rule');
	// 			$search['buy_rule_number']['$in'] = $filter_by_rule;
	// 		}
	// 		if ($_POST['filter_by_start_date'] != "" && $_POST['filter_by_end_date'] != "") {
	// 			$created_datetime = date('Y-m-d G:i:s', strtotime($_POST['filter_by_start_date']));
	// 			$orig_date = new DateTime($created_datetime);
	// 			$orig_date = $orig_date->getTimestamp();
	// 			$start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

	// 			$created_datetime22 = date('Y-m-d G:i:s', strtotime($_POST['filter_by_end_date']));
	// 			$orig_date22 = new DateTime($created_datetime22);
	// 			$orig_date22 = $orig_date22->getTimestamp();
	// 			$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
	// 			$search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
	// 		}
	// 	} else {

	// 		$coin_array           = array_column($coin_array_all, 'symbol');
	// 		$opp_status           = 'sold';
	// 		$collection           = "sold_buy_orders";
	// 		$search['order_mode'] = 'live';
	// 		$filter_by_trigger    = 'barrier_percentile_trigger';
	// 		$search['order_level']['$in'] =  array('level_1', 'level_2', 'level_3', 'level_4', 'level_5', 'level_6', 'level_7', 'level_8', 'level_9', 'level_10');

	// 		$filter_by_end_date       = date('Y-m-d G:i:s');
	// 		$filter_by_end_date1111   = date("m/d/Y H:i a", strtotime($filter_by_end_date));
	// 		$filter_by_start_date     = date('Y-m-d G:i:s', strtotime('-1 months'));
	// 		$filter_by_start_date111  = date("m/d/Y H:i a", strtotime($filter_by_start_date));

	// 		$array['filter_by_mode']       = $search['order_mode'];
	// 		$array['filter_by_start_date'] = $filter_by_start_date111;
	// 		$array['filter_by_end_date']   = $filter_by_end_date1111;
	// 		$array['opp_status']           = $opp_status;
	// 		$array['filter_by_trigger']    = $filter_by_trigger;
	// 		$array['filter_by_level']      = $search['order_level']['$in'];
	// 		$array['filter_by_coin']       = $coin_array;

	// 		$data_arr['filter_order_data'] = $array;
	// 		$this->session->set_userdata($data_arr);

	// 		// Start Date 
	// 		$orig_date = new DateTime($filter_by_start_date);
	// 		$orig_date = $orig_date->getTimestamp();
	// 		$start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

	// 		// End Date  
	// 		$orig_date22 = new DateTime($filter_by_end_date);
	// 		$orig_date22 = $orig_date22->getTimestamp();
	// 		$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
	// 		$search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
	// 	}
	// 	foreach ($coin_array as $coin) {

	// 		$conn = $this->mongo_db->customQuery();
	// 		$search['symbol']       = $coin;
	// 		$search['trigger_type'] = $filter_by_trigger;
	// 		$pending_options = array('skip' => $skip_pending, 'sort' => array('modified_date' => -1), 'limit' => intval(500));
	// 		$db_obj = $conn->$collection->find($search, $pending_options);
	// 		$order_arr = iterator_to_array($db_obj);
	// 		$order_arr_all[$coin] = $order_arr;
	// 	}

	// 	$filter_user_data = $this->session->userdata('filter_order_data');
	// 	$filter_hour_day  =  $filter_user_data['filter_hour_day'];

	// 	if ($filter_hour_day == '') {
	// 		$filter_hour_day = 'hours';
	// 	}
	// 	$resultArr  = $this->make_array_for_view_new($order_arr_all, '', 'sold_buy_orders', $filter_hour_day);
	// 	$fianlArrr  = $this->filter_array($resultArr);
	// 	$finalValArr              = '';
	// 	$htmlTime                 = '';
	// 	$prefix                   = ', ';
	// 	$i                        = 0;
	// 	$k                        = 0;
	// 	$MmnutHour                = 60;
	// 	$formate                  = 'd M Y H:i A';

	// 	$order_arr_all   = array_reverse($order_arr_all);

	// 	foreach ($order_arr_all as $coinArr) {
	// 		foreach ($coinArr as $record) {

	// 			$created_date   = (array) $record['created_date'];
	// 			$created_date   = $created_date['milliseconds'];
	// 			$created_date   = $created_date / 1000;
	// 			$endDateHour    = date($formate, ($created_date));
	// 			$timezone       = $this->session->userdata('timezone');

	// 			// only use for GMT and UTC goes here 
	// 			$dtz = new DateTimeZone($timezone);
	// 			$time_in_sofia = new DateTime('now', $dtz);
	// 			$offset = $dtz->getOffset($time_in_sofia) / 3600;
	// 			$fianlUtcGmt = ($offset < 0 ? $offset : "+" . $offset);
	// 			// only use for GMT and UTC goes here 
	// 			$htmlViewTimeAllForSecond   .= "'" . date($formate, ($created_date)) . '<span class="utc"> UTC ( GMT+0 )</span>' . "'" . $prefix;;
	// 			$prefix             = ', ';
	// 			$purchased_price    =  num($record['market_value']);
	// 			$market_sold_price  =  num($record['market_sold_price']);
	// 			$profit             =  $market_sold_price - $purchased_price;
	// 			$finalValArr        =  num($profit) . $prefix;
	// 			$finalValArrA      .=  num($profit) . $prefix;

	// 			if ($finalValArr == 0 || $finalValArr == '') {
	// 				$finalValArr = 0;
	// 			}
	// 		}
	// 	}
	// 	$lowestval1  = explode(',', $finalValArrA);
	// 	$lowestval   = max($lowestval1);
	// 	$fianlArrrForColumnChart  = array_column($fianlArrr, 'avg');
	// 	$fianlDateForColumnChart  = array_column($fianlArrr, 'date');
	// 	$fianlTradeForColumnChart = array_column($fianlArrr, 'count');
	// 	$fianlLevelForColumnChart = array_column($fianlArrr, 'order_level');
	// 	$fianlcoinForColumnChart  = array_column($fianlArrr, 'coin');

	// 	$fianlDateForColumnChart  = array_reverse($fianlDateForColumnChart);
	// 	$fianlArrrForColumnChart  = array_reverse($fianlArrrForColumnChart);
	// 	$fianlTradeForColumnChart = array_reverse($fianlTradeForColumnChart);
	// 	$fianlLevelForColumnChart = array_reverse($fianlLevelForColumnChart);
	// 	$fianlcoinForColumnChart  = array_reverse($fianlcoinForColumnChart);

	// 	$htmlViewTime             = '';
	// 	$htmlViewTimeAll          = '';
	// 	$prefix                   = '';
	// 	$i                        = 0;
	// 	$k                        = 0;
	// 	$MmnutHour                = 60;
	// 	$formate                  = 'd M Y H:i A';

	// 	foreach ($fianlDateForColumnChart as $key => $date) {
	// 		$prefix    = ', ';
	// 		// ************** For view ************ //
	// 		$pre_time  = date('Y-m-d g:i:s', strtotime($date . ':00:00'));
	// 		$second    = strtotime($pre_time) + ((($i) - 1) * $MmnutHour);
	// 		$end_dateB = date($formate, ($second));
	// 		$htmlViewTime .= "'" . $end_dateB . "'";
	// 		// New code goes here 
	// 		$htmlViewTimeAll .= "'" . $end_dateB . ' <br/> <br/><span class="trade"> - Trade Count : <b style="color:red;">' . $fianlTradeForColumnChart[$key] . '</b></span> <br/>' .
	// 			' <br/> <br/><span class="order"> - Order Level : <b style="color:red;">' . $fianlLevelForColumnChart[$key] . '</b> </span><br/>' .
	// 			' <br/> <br/> <span class="coinname"> - Coin        : <b style="color:red;">' . $fianlcoinForColumnChart[$key] . '</b></span> <br/>' . "'";

	// 		if (++$i === $recent_count) {
	// 		} else {
	// 			$htmlViewTime .= ',';
	// 		}
	// 		if (++$i === $recent_count) {
	// 		} else {
	// 			$htmlViewTimeAll .= ',';
	// 		}
	// 	} //foreach($fianlDateForColumnChart as $date){

	// 	$finalColumnArr           = implode(',', $fianlArrrForColumnChart);
	// 	$finalDateColumnArr       = implode(',', $fianlDateForColumnChart);
	// 	$finalTradeColumnArr      = implode(',', $fianlTradeForColumnChart);

	// 	$data['htmlViewTimeAllForSecond']     = $htmlViewTimeAllForSecond;
	// 	$data['finalValArr']      = $finalValArrA;
	// 	$data['lowestval']        = $lowestval;
	// 	$data['column_arr']       = $finalColumnArr;
	// 	$data['date_column_arr']  = $htmlViewTime;
	// 	$data['htmlViewTimeAll']  = rtrim($htmlViewTimeAll, ',');
	// 	$data['trade_column_arr'] = $finalTradeColumnArr;
	// 	$data['sell_arr']         = $resultArr;
	// 	$data['buy_arr']          = $resultArr2;
	// 	$data['full_arr']         = $fianlArrr;
	// 	$data['coins']            = $coin_array_all;

	// 	$this->stencil->paint('admin/trigger_rule_report/chart_order_report_listing', $data);
	// }

	// public function make_array_for_view_new_test($order_arr, $dayHours)
	// {
	// 	if (!empty($order_arr)) {
	// 		$total_sold_orders = '';
	// 		$a = '';
	// 		foreach ($order_arr as $key => $value) {
	// 			$coin          = $key;
	// 			$coin_count    = 0;
	// 			$trigger_count = count($value);
	// 			$coin_count   += $trigger_count;
	// 			$market_heighest_value      = array_column($value, 'market_heighest_value');
	// 			$market_lowest_value        = array_column($value, 'market_lowest_value');
	// 			$five_hour_max_market_price = array_column($value, '5_hour_max_market_price');
	// 			$five_hour_min_market_price = array_column($value, '5_hour_min_market_price');
	// 			$market_heighest_value = array_filter($market_heighest_value);
	// 			if (count($market_heighest_value) == '0' || count($market_heighest_value) == 'null') {
	// 				$max_high_average      = array_sum($market_heighest_value);
	// 			} else {
	// 				$max_high_average      = array_sum($market_heighest_value) / count($market_heighest_value);
	// 			}
	// 			$market_lowest_value   = array_filter($market_lowest_value);
	// 			if (count($market_lowest_value) == '0' || count($market_lowest_value) == 'null') {
	// 				$max_low_average       = array_sum($market_lowest_value);
	// 			} else {
	// 				$max_low_average       = array_sum($market_lowest_value) / count($market_lowest_value);
	// 			}
	// 			$five_hour_max_market_price = array_filter($five_hour_max_market_price);
	// 			if (count($five_hour_max_market_price) == '0' || count($five_hour_max_market_price) == 'null') {
	// 				$high_five_average          = array_sum($five_hour_max_market_price);
	// 			} else {
	// 				$high_five_average          = array_sum($five_hour_max_market_price) / count($five_hour_max_market_price);
	// 			}
	// 			$five_hour_min_market_price = array_filter($five_hour_min_market_price);
	// 			if (count($five_hour_min_market_price) == '0' || count($five_hour_min_market_price) == 'null') {
	// 				$low_five_average           = array_sum($five_hour_min_market_price);
	// 			} else {
	// 				$low_five_average           = array_sum($five_hour_min_market_price) / count($five_hour_min_market_price);
	// 			}
	// 			$a = array_filter(explode(',', $a));
	// 			$avg_profit     = 0;
	// 			$total_quantity = 0;
	// 			$winning        = 0;
	// 			$losing         = 0;
	// 			$top1           = 0;
	// 			$top2           = 0;
	// 			$bottom2        = 0;
	// 			$max_profit_per  = array();
	// 			$min_profit_per1 = array();
	// 			$max_profit_pert = array();
	// 			$min_profit_per2 = array();

	// 			$opp = $this->calculate_no_of_oppurtunities_test($coin, $value, $dayHours);

	// 			foreach ($value as $col => $row) {
	// 				if (!empty($row)) {

	// 					if (isset($row['5_hour_max_market_price']) && $row['5_hour_max_market_price'] != '') {

	// 						$five_hour_max_market_price = $row['5_hour_max_market_price'];
	// 						$purchased_price = (float) $row['market_value'];
	// 						$profit = $five_hour_max_market_price - $purchased_price;

	// 						$profit_margin = ($profit / $five_hour_max_market_price) * 100;

	// 						$max_profit_per_5 = ($profit) * (100 / $purchased_price);

	// 						$max_profit_per[] = number_format($max_profit_per_5, 2);
	// 						// echo"ifasin121212";exit;
	// 					}

	// 					if (isset($row['5_hour_min_market_price']) && $row['5_hour_min_market_price'] != '') {

	// 						$market_lowest_value = $row['5_hour_min_market_price'];
	// 						$purchased_price = (float) $row['market_value'];
	// 						$profit = $market_lowest_value - $purchased_price;

	// 						$profit_margin = ($profit / $market_lowest_value) * 100;

	// 						$min_profit_per_5 = ($profit) * (100 / $purchased_price);
	// 						$min_profit_per1[] = number_format($min_profit_per_5, 2);
	// 					}

	// 					if (isset($row['market_heighest_value']) && $row['market_heighest_value'] != '') {

	// 						$five_hour_max_market_price1 = $row['market_heighest_value'];
	// 						$purchased_price1 = (float) $row['market_value'];
	// 						$profit1 = $five_hour_max_market_price1 - $purchased_price1;

	// 						$profit_margin1 = ($profit1 / $five_hour_max_market_price1) * 100;

	// 						$max_profit_per_t = ($profit1) * (100 / $purchased_price1);

	// 						$max_profit_pert[] = number_format($max_profit_per_t, 2);
	// 					}

	// 					if (isset($row['market_lowest_value']) && $row['market_lowest_value'] != '') {

	// 						$market_lowest_value2 = $row['market_lowest_value'];
	// 						$purchased_price2 = (float) $row['market_value'];
	// 						$profit2 = $market_lowest_value2 - $purchased_price2;

	// 						$profit_margin2 = ($profit2 / $market_lowest_value2) * 100;

	// 						$min_profit_per2_t = ($profit2) * (100 / $purchased_price2);
	// 						$min_profit_per2[] = number_format($min_profit_per2_t, 2);
	// 					}

	// 					$total_sold_orders++;
	// 					$market_sold_price = $row['market_sold_price'];
	// 					$current_order_price = $row['market_value'];
	// 					$quantity = $row['quantity'];

	// 					$current_data2222 = $market_sold_price - $current_order_price;
	// 					$profit_data = ($current_data2222 * 100 / $market_sold_price);
	// 					if ($profit_data > 0) {
	// 						$winning++;
	// 					} elseif ($profit_data < 0) {
	// 						$losing++;
	// 					}

	// 					if ($profit_data >= 1 && $profit_data <= 2) {
	// 						$top1++;
	// 					}
	// 					if ($profit_data >= 2) {
	// 						$top2++;
	// 					}
	// 					if ($profit_data <= -2) {
	// 						$bottom2++;
	// 					}
	// 					$profit_data = $profit_data; //- 0.4;
	// 					$profit_data = number_format((float) $profit_data, 2, '.', '');
	// 					$total_btc = $quantity * (float) $current_order_price;
	// 					$total_profit += $total_btc * $profit_data;
	// 					$total_quantity += $total_btc;
	// 					//echo"ooooooooooo";exit;
	// 				}
	// 			}
	// 			$max_profit_5h = (array_sum($max_profit_per) / count($max_profit_per));
	// 			$avg_profit = $total_profit / $total_quantity;
	// 			//echo"ppppppppppp";exit;
	// 			if ($total_quantity == 0) {
	// 				$total_quantity = 1;
	// 				//echo"ppppppppppp";exit;
	// 			}

	// 			$min_profit_low = (array_sum($min_profit_per2) / count($min_profit_per2));
	// 			$max_profit_high = (array_sum($max_profit_pert) / count($max_profit_pert));
	// 			$min_profit_5h = (array_sum($min_profit_per1) / count($min_profit_per1));
	// 			$retArr = array(
	// 				'trigger_count' => $trigger_count,
	// 				'avg_profit' => number_format($avg_profit, 2),
	// 				'max_high_average' => num($max_high_average),
	// 				'max_low_average' => num($max_low_average),
	// 				'high_five_average' => num($high_five_average),
	// 				'low_five_average' => num($low_five_average),
	// 				'max_profit_5h' => number_format($max_profit_5h, 2),
	// 				'min_profit_5h' => number_format($min_profit_5h, 2),
	// 				'max_profit_high' => number_format($max_profit_high, 2),
	// 				'min_profit_low' => number_format($min_profit_low, 2),
	// 				'winning_trades' => $winning,
	// 				'losing_trades' => $losing,
	// 				'top_1_per' => $top1,
	// 				'top_2_per' => $top2,
	// 				'bottom_2_per' => $bottom2,
	// 				'opp' => $opp
	// 			);
	// 			$t_arr[$coin] = $retArr;
	// 		}
	// 		// $coin_arr = array();
	// 		// $my_coin_data = $this->get_order_arr($coin_arr, $coin);
	// 		// $t_arr['coin_meta'] = $my_coin_data;
	// 		$finalArray = $t_arr;
	// 	}
	// 	return $finalArray;
	// }

	// public function make_array_for_view_new($order_arr, $order_type, $dayHours)
	// {
	// 	// echo "<pre>";
	// 	// print_r($order_arr);die('debugging');
	// 	// error_reporting(E_ALL);
	// 	//display_errors(E_ALL);
	// 	if (!empty($order_arr)) {
	// 		$total_sold_orders = '';
	// 		$a = '';

	// 		foreach ($order_arr as $key => $value) {

	// 			$coin          = $key;
	// 			$coin_count    = 0;
	// 			// $trigger       = $key;
	// 			$trigger_count = count($value);
	// 			$coin_count   += $trigger_count;

	// 			$market_heighest_value      = array_column($value, 'market_heighest_value');
	// 			$market_lowest_value        = array_column($value, 'market_lowest_value');
	// 			$five_hour_max_market_price = array_column($value, '5_hour_max_market_price');
	// 			$five_hour_min_market_price = array_column($value, '5_hour_min_market_price');

	// 			// $max_high = max($market_heighest_value);
	// 			// $min_high = min($market_heighest_value);
	// 			// $max_low  = max($market_lowest_value);
	// 			// $min_low  = min($market_lowest_value);

	// 			$market_heighest_value = array_filter($market_heighest_value);
	// 			if (count($market_heighest_value) == '0' || count($market_heighest_value) == 'null') {
	// 				$max_high_average      = array_sum($market_heighest_value);
	// 			} else {
	// 				$max_high_average      = array_sum($market_heighest_value) / count($market_heighest_value);
	// 			}
	// 			$market_lowest_value   = array_filter($market_lowest_value);
	// 			if (count($market_lowest_value) == '0' || count($market_lowest_value) == 'null') {
	// 				$max_low_average       = array_sum($market_lowest_value);
	// 			} else {
	// 				$max_low_average       = array_sum($market_lowest_value) / count($market_lowest_value);
	// 			}
	// 			$five_hour_max_market_price = array_filter($five_hour_max_market_price);
	// 			if (count($five_hour_max_market_price) == '0' || count($five_hour_max_market_price) == 'null') {
	// 				$high_five_average          = array_sum($five_hour_max_market_price);
	// 			} else {
	// 				$high_five_average          = array_sum($five_hour_max_market_price) / count($five_hour_max_market_price);
	// 			}
	// 			$five_hour_min_market_price = array_filter($five_hour_min_market_price);
	// 			if (count($five_hour_min_market_price) == '0' || count($five_hour_min_market_price) == 'null') {
	// 				$low_five_average           = array_sum($five_hour_min_market_price);
	// 			} else {
	// 				$low_five_average           = array_sum($five_hour_min_market_price) / count($five_hour_min_market_price);
	// 			}
	// 			$max_high_five = max($five_hour_max_market_price);
	// 			$min_high_five = min($five_hour_max_market_price);
	// 			$max_low_five  = max($five_hour_min_market_price);
	// 			$min_low_five  = min($five_hour_min_market_price);
	// 			$a = array_filter(explode(',', $a));
	// 			//$a       = array_filter($a);
	// 			if (count($a) == '0' || count($a) == 'null') {
	// 				$average = array_sum($a);
	// 			} else {
	// 				$average = array_sum($a) / count($a);
	// 			}
	// 			$avg_profit     = 0;
	// 			//$total_profit   = 0;
	// 			$total_quantity = 0;
	// 			$winning        = 0;
	// 			$losing         = 0;
	// 			$top1           = 0;
	// 			$top2           = 0;
	// 			$bottom2        = 0;

	// 			$max_profit_per  = array();
	// 			$min_profit_per1 = array();
	// 			$max_profit_pert = array();
	// 			$min_profit_per2 = array();

	// 			$opp = $this->calculate_no_of_oppurtunities($coin, $value, $order_type, $dayHours);

	// 			foreach ($value as $col => $row) {
	// 				if (!empty($row)) {


	// 					if (isset($row['5_hour_max_market_price']) && $row['5_hour_max_market_price'] != '') {

	// 						$five_hour_max_market_price = $row['5_hour_max_market_price'];
	// 						$purchased_price = (float) $row['market_value'];
	// 						$profit = $five_hour_max_market_price - $purchased_price;

	// 						$profit_margin = ($profit / $five_hour_max_market_price) * 100;

	// 						$max_profit_per_5 = ($profit) * (100 / $purchased_price);

	// 						$max_profit_per[] = number_format($max_profit_per_5, 2);
	// 						// echo"ifasin121212";exit;
	// 					}

	// 					if (isset($row['5_hour_min_market_price']) && $row['5_hour_min_market_price'] != '') {

	// 						$market_lowest_value = $row['5_hour_min_market_price'];
	// 						$purchased_price = (float) $row['market_value'];
	// 						$profit = $market_lowest_value - $purchased_price;

	// 						$profit_margin = ($profit / $market_lowest_value) * 100;

	// 						$min_profit_per_5 = ($profit) * (100 / $purchased_price);
	// 						$min_profit_per1[] = number_format($min_profit_per_5, 2);
	// 						// echo"ifasiassssssssssssssn";exit;
	// 					}

	// 					if (isset($row['market_heighest_value']) && $row['market_heighest_value'] != '') {

	// 						$five_hour_max_market_price1 = $row['market_heighest_value'];
	// 						$purchased_price1 = (float) $row['market_value'];
	// 						$profit1 = $five_hour_max_market_price1 - $purchased_price1;

	// 						$profit_margin1 = ($profit1 / $five_hour_max_market_price1) * 100;

	// 						$max_profit_per_t = ($profit1) * (100 / $purchased_price1);

	// 						$max_profit_pert[] = number_format($max_profit_per_t, 2);
	// 						// echo"ifasin1111111111111111111111";exit;
	// 					}

	// 					if (isset($row['market_lowest_value']) && $row['market_lowest_value'] != '') {

	// 						$market_lowest_value2 = $row['market_lowest_value'];
	// 						$purchased_price2 = (float) $row['market_value'];
	// 						$profit2 = $market_lowest_value2 - $purchased_price2;

	// 						$profit_margin2 = ($profit2 / $market_lowest_value2) * 100;

	// 						$min_profit_per2_t = ($profit2) * (100 / $purchased_price2);
	// 						$min_profit_per2[] = number_format($min_profit_per2_t, 2);
	// 						// echo"ifasin000000000000000000000";exit;
	// 					}

	// 					$total_sold_orders++;
	// 					$market_sold_price = $row['market_sold_price'];
	// 					$current_order_price = $row['market_value'];
	// 					$quantity = $row['quantity'];

	// 					$current_data2222 = $market_sold_price - $current_order_price;
	// 					$profit_data = ($current_data2222 * 100 / $market_sold_price);
	// 					if ($profit_data > 0) {
	// 						$winning++;
	// 						//echo"11111";exit;
	// 					} elseif ($profit_data < 0) {

	// 						$losing++;
	// 						//echo"ifasin0099999";exit;
	// 					}

	// 					if ($profit_data >= 1 && $profit_data <= 2) {
	// 						$top1++;
	// 						//echo"121212";exit;
	// 					}
	// 					if ($profit_data >= 2) {
	// 						$top2++;
	// 						//echo"aaaaaaaaa";exit;
	// 					}
	// 					if ($profit_data <= -2) {
	// 						$bottom2++;
	// 					}
	// 					$profit_data = $profit_data; //- 0.4;
	// 					$profit_data = number_format((float) $profit_data, 2, '.', '');
	// 					$total_btc = $quantity * (float) $current_order_price;
	// 					$total_profit += $total_btc * $profit_data;
	// 					$total_quantity += $total_btc;
	// 					//echo"ooooooooooo";exit;
	// 				}
	// 			}
	// 			$max_profit_5h = (array_sum($max_profit_per) / count($max_profit_per));
	// 			$avg_profit = $total_profit / $total_quantity;
	// 			//echo"ppppppppppp";exit;
	// 			if ($total_quantity == 0) {
	// 				$total_quantity = 1;
	// 				//echo"ppppppppppp";exit;
	// 			}
	// 			//echo"pppasasasasas";exit;
	// 			//  if($total_quantity =='0' || $total_quantity=='null')
	// 			//  {
	// 			// 	$avg_profit = $total_profit;
	// 			//  }
	// 			//  else{
	// 			// 	$avg_profit = $total_profit / $total_quantity;
	// 			//  }
	// 			// 	if(count($max_profit_per)=='0' || count($max_profit_per)=='1')
	// 			// 	{
	// 			// 		$max_profit_5h = (array_sum($max_profit_per));
	// 			// 	}
	// 			// 	else{
	// 			// 		$max_profit_5h = (array_sum($max_profit_per) / count($max_profit_per));
	// 			// 	}
	// 			// 	if(count($min_profit_per1) =='0' || count($min_profit_per1) =='null')
	// 			// 	{
	// 			// 		$min_profit_5h = (array_sum($min_profit_per1));
	// 			// 	}
	// 			// 	else{
	// 			// 		$min_profit_5h = (array_sum($min_profit_per1) / count($min_profit_per1));
	// 			// 	}
	// 			// 		if(count($max_profit_pert) =='0' || count($max_profit_pert) =='null')
	// 			// 		{
	// 			// 			$max_profit_high = (array_sum($max_profit_pert));
	// 			// 		}
	// 			// 		else{
	// 			// 	$max_profit_high = (array_sum($max_profit_pert) / count($max_profit_pert));
	// 			// 		}
	// 			// 		if(count($min_profit_per2)== '0' || count($min_profit_per2)=='null')
	// 			// 		{
	// 			// 			$min_profit_low = (array_sum($min_profit_per2));
	// 			// 		}
	// 			// 		else{
	// 			// 	$min_profit_low = (array_sum($min_profit_per2) / count($min_profit_per2));
	// 			// 		}
	// 			$min_profit_low = (array_sum($min_profit_per2) / count($min_profit_per2));
	// 			$max_profit_high = (array_sum($max_profit_pert) / count($max_profit_pert));
	// 			$min_profit_5h = (array_sum($min_profit_per1) / count($min_profit_per1));
	// 			$retArr = array(
	// 				'trigger_count' => $trigger_count,
	// 				'avg_profit' => number_format($avg_profit, 2),
	// 				'max_high_average' => num($max_high_average),
	// 				'max_low_average' => num($max_low_average),
	// 				'high_five_average' => num($high_five_average),
	// 				'low_five_average' => num($low_five_average),
	// 				'max_profit_5h' => number_format($max_profit_5h, 2),
	// 				'min_profit_5h' => number_format($min_profit_5h, 2),
	// 				'max_profit_high' => number_format($max_profit_high, 2),
	// 				'min_profit_low' => number_format($min_profit_low, 2),
	// 				'winning_trades' => $winning,
	// 				'losing_trades' => $losing,
	// 				'top_1_per' => $top1,
	// 				'top_2_per' => $top2,
	// 				'bottom_2_per' => $bottom2,
	// 				'opp' => $opp
	// 			);
	// 			$t_arr['$trigger'][] = $retArr;
	// 		}
	// 		$coin_arr = array();

	// 		$my_coin_data = $this->get_order_arr($coin_arr, $coin);

	// 		$t_arr['coin_meta'] = $my_coin_data;

	// 		$finalArray = $t_arr;
	// 	}
	// 	// echo"<pre>";
	// 	// 	print_r($finalArray);
	// 	// 	exit;

	// 	return $finalArray;
	// }

	// public function filter_array($resultArr)
	// {

	// 	echo "<pre>";
	// 	print_r($resultArr);
	// 	exit;
	// 	$finalraay = array();
	// 	$resp      = "";

	// 	$count = 0;
	// 	foreach ($resultArr as $keyist => $row) {
	// 		$varaible   = $row['opp']['avg'];

	// 		//$intersect  = $row['opp']['intersect'];
	// 		//$opsold     = $row['opp']['opsold'];
	// 		//$opbuy      = $row['opp']['opbuy'];
	// 		if ($varaible) {

	// 			foreach ($varaible as $key => $rownew) {

	// 				// $coin = $rownew['order_type']['$row'];
	// 				//$coin	= $varaible['$key']['order_type'][0];
	// 				// $rownew['coin'] =  $rownew[0]['symbol'];
	// 				// $rownew['date'] =  $key ;
	// 				$fianlArrr[] =  $rownew;
	// 			}
	// 			$count++;
	// 		}
	// 	}

	// 	usort($fianlArrr, 'date_compare');
	// 	$fianlArrr  =  array_reverse($fianlArrr);
	// 	return $fianlArrr;
	// }

	// public function filter_array_buy($resultArr)
	// {

	// 	$finalraay = array();
	// 	$resp      = "";
	// 	foreach ($resultArr as $keyist => $row) {
	// 		$varaible  = $row['opp']['avg'];
	// 		foreach ($varaible as $key => $rownew) {
	// 			$coin =  $keyist;
	// 			$rownew['coin'] =  $coin;
	// 			$rownew['date'] =  $key;
	// 			$fianlArrr[] =  $rownew;
	// 		}
	// 	}
	// 	usort($fianlArrr, 'date_compare');
	// 	$fianlArrr  =  array_reverse($fianlArrr);
	// 	return $fianlArrr;
	// } //filter_array


	// public function make_array_for_view($order_arr, $values, $coin)
	// {

	// 	if ($values == 'trigger') {
	// 		if (!empty($order_arr)) {

	// 			//foreach ($order_arr as $coin_key => $coin_arr) {
	// 			$coin = $coin;
	// 			$coin_count = 0;

	// 			foreach ($order_arr as $key => $value) {

	// 				$trigger = $key;
	// 				$trigger_count = count($value);
	// 				$coin_count += $trigger_count;

	// 				$market_heighest_value = array_column($value, 'market_heighest_value');
	// 				$market_lowest_value = array_column($value, 'market_lowest_value');
	// 				$five_hour_max_market_price = array_column($value, '5_hour_max_market_price');
	// 				$five_hour_min_market_price = array_column($value, '5_hour_min_market_price');

	// 				$max_high = max($market_heighest_value);
	// 				$min_high = min($market_heighest_value);
	// 				$max_low = max($market_lowest_value);
	// 				$min_low = min($market_lowest_value);

	// 				$market_heighest_value = array_filter($market_heighest_value);
	// 				$max_high_average = array_sum($market_heighest_value) / count($market_heighest_value);

	// 				$market_lowest_value = array_filter($market_lowest_value);
	// 				$max_low_average = array_sum($market_lowest_value) / count($market_lowest_value);

	// 				$five_hour_max_market_price = array_filter($five_hour_max_market_price);
	// 				$high_five_average = array_sum($five_hour_max_market_price) / count($five_hour_max_market_price);

	// 				$five_hour_min_market_price = array_filter($five_hour_min_market_price);
	// 				$low_five_average = array_sum($five_hour_min_market_price) / count($five_hour_min_market_price);

	// 				$max_high_five = max($five_hour_max_market_price);
	// 				$min_high_five = min($five_hour_max_market_price);
	// 				$max_low_five = max($five_hour_min_market_price);
	// 				$min_low_five = min($five_hour_min_market_price);

	// 				$a = array_filter($a);
	// 				$average = array_sum($a) / count($a);

	// 				$avg_profit = 0;
	// 				$total_profit = 0;
	// 				$total_quantity = 0;
	// 				$winning = 0;
	// 				$losing = 0;
	// 				$top1 = 0;
	// 				$top2 = 0;
	// 				$bottom2 = 0;

	// 				$max_profit_per = array();
	// 				$min_profit_per1 = array();
	// 				$max_profit_pert = array();
	// 				$min_profit_per2 = array();



	// 				$opp = $this->calculate_no_of_oppurtunities($coin, $value);

	// 				foreach ($value as $col => $row) {
	// 					if (!empty($row)) {

	// 						if (isset($row['5_hour_max_market_price']) && $row['5_hour_max_market_price'] != '') {

	// 							$five_hour_max_market_price = $row['5_hour_max_market_price'];
	// 							$purchased_price = (float) $row['market_value'];
	// 							$profit = $five_hour_max_market_price - $purchased_price;

	// 							$profit_margin = ($profit / $five_hour_max_market_price) * 100;

	// 							$max_profit_per_5 = ($profit) * (100 / $purchased_price);

	// 							$max_profit_per[] = number_format($max_profit_per_5, 2);
	// 						}

	// 						if (isset($row['5_hour_min_market_price']) && $row['5_hour_min_market_price'] != '') {

	// 							$market_lowest_value = $row['5_hour_min_market_price'];
	// 							$purchased_price = (float) $row['market_value'];
	// 							$profit = $market_lowest_value - $purchased_price;

	// 							$profit_margin = ($profit / $market_lowest_value) * 100;

	// 							$min_profit_per_5 = ($profit) * (100 / $purchased_price);
	// 							$min_profit_per1[] = number_format($min_profit_per_5, 2);
	// 						}

	// 						if (isset($row['market_heighest_value']) && $row['market_heighest_value'] != '') {

	// 							$five_hour_max_market_price1 = $row['market_heighest_value'];
	// 							$purchased_price1 = (float) $row['market_value'];
	// 							$profit1 = $five_hour_max_market_price1 - $purchased_price1;

	// 							$profit_margin1 = ($profit1 / $five_hour_max_market_price1) * 100;

	// 							$max_profit_per_t = ($profit1) * (100 / $purchased_price1);

	// 							$max_profit_pert[] = number_format($max_profit_per_t, 2);
	// 						}

	// 						if (isset($row['market_lowest_value']) && $row['market_lowest_value'] != '') {

	// 							$market_lowest_value2 = $row['market_lowest_value'];
	// 							$purchased_price2 = (float) $row['market_value'];
	// 							$profit2 = $market_lowest_value2 - $purchased_price2;

	// 							$profit_margin2 = ($profit2 / $market_lowest_value2) * 100;

	// 							$min_profit_per2_t = ($profit2) * (100 / $purchased_price2);
	// 							$min_profit_per2[] = number_format($min_profit_per2_t, 2);
	// 						}

	// 						$total_sold_orders++;
	// 						$market_sold_price = $row['market_sold_price'];
	// 						$current_order_price = $row['market_value'];
	// 						$quantity = $row['quantity'];

	// 						$current_data2222 = $market_sold_price - $current_order_price;
	// 						$profit_data = ($current_data2222 * 100 / $market_sold_price);
	// 						if ($profit_data > 0) {
	// 							$winning++;
	// 						} elseif ($profit_data < 0) {
	// 							$losing++;
	// 						}

	// 						if ($profit_data >= 1 && $profit_data <= 2) {
	// 							$top1++;
	// 						}
	// 						if ($profit_data >= 2) {
	// 							$top2++;
	// 						}
	// 						if ($profit_data <= -2) {
	// 							$bottom2++;
	// 						}
	// 						$profit_data = $profit_data; //- 0.4;
	// 						$profit_data = number_format((float) $profit_data, 2, '.', '');
	// 						$total_btc = $quantity * (float) $current_order_price;
	// 						$total_profit += $total_btc * $profit_data;
	// 						$total_quantity += $total_btc;
	// 					}
	// 				}
	// 				if ($total_quantity == 0) {
	// 					$total_quantity = 1;
	// 				}
	// 				$avg_profit = $total_profit / $total_quantity;

	// 				$max_profit_5h = (array_sum($max_profit_per) / count($max_profit_per));
	// 				$min_profit_5h = (array_sum($min_profit_per1) / count($min_profit_per1));
	// 				$max_profit_high = (array_sum($max_profit_pert) / count($max_profit_pert));
	// 				$min_profit_low = (array_sum($min_profit_per2) / count($min_profit_per2));

	// 				$retArr = array(
	// 					'trigger_count' => $trigger_count,
	// 					'avg_profit' => number_format($avg_profit, 2),
	// 					'max_high_average' => num($max_high_average),
	// 					'max_low_average' => num($max_low_average),
	// 					'high_five_average' => num($high_five_average),
	// 					'low_five_average' => num($low_five_average),
	// 					'max_profit_5h' => number_format($max_profit_5h, 2),
	// 					'min_profit_5h' => number_format($min_profit_5h, 2),
	// 					'max_profit_high' => number_format($max_profit_high, 2),
	// 					'min_profit_low' => number_format($min_profit_low, 2),
	// 					'winning_trades' => $winning,
	// 					'losing_trades' => $losing,
	// 					'top_1_per' => $top1,
	// 					'top_2_per' => $top2,
	// 					'bottom_2_per' => $bottom2,
	// 					'opp' => $opp,
	// 				);
	// 				$t_arr[$trigger] = $retArr;
	// 			}
	// 			$my_coin_data = $this->get_order_arr($coin_arr, $coin);
	// 			$t_arr['coin_meta'] = $my_coin_data;
	// 			$finalArray[$coin] = $t_arr;
	// 		}
	// 	}
	// 	return $finalArray;
	// }

	// public function calculate_no_of_oppurtunities_test($coin, $trades, $dayHours)
	// {

	// 	$old_time = "";
	// 	$op       = 0;
	// 	$tempArr  = array();
	// 	array_multisort(array_column($trades, "created_date"), SORT_ASC, $trades);

	// 	foreach ($trades as $key => $value) {

	// 		if ($dayHours == 'days') {
	// 			$time = $value['created_date']->toDateTime()->format("Y-m-d 00");
	// 		} else {
	// 			$time = $value['created_date']->toDateTime()->format("Y-m-d H");
	// 		}
	// 		if ($time != $old_time) {
	// 			$op++;
	// 			$old_time = $time;
	// 			$tempArr[$time][] = $value;
	// 		} else {
	// 			$tempArr[$time][] = $value;
	// 		}
	// 	}

	// 	$retArr = array();
	// 	foreach ($tempArr as $key => $value) {
	// 		$profit_data = 0;
	// 		$total_btc = 0;
	// 		$total_profit = 0;
	// 		$total_quantity = 0;
	// 		$avg_profit = 0;
	// 		$total_sold_orders = 0;
	// 		$max_profit_per = array();
	// 		$min_profit_per1 = array();
	// 		$max_profit_pert = array();
	// 		$min_profit_per2 = array();
	// 		foreach ($value as $key_1 => $valueArr) {
	// 			$total_sold_orders++;

	// 			if (isset($valueArr['5_hour_max_market_price']) && $valueArr['5_hour_max_market_price'] != '') {

	// 				$five_hour_max_market_price = $valueArr['5_hour_max_market_price'];
	// 				$purchased_price = (float) $valueArr['market_value'];
	// 				$profit = $five_hour_max_market_price - $purchased_price;

	// 				$profit_margin = ($profit / $five_hour_max_market_price) * 100;

	// 				$max_profit_per_5 = ($profit) * (100 / $purchased_price);

	// 				$max_profit_per[] = number_format($max_profit_per_5, 2);
	// 			}

	// 			if (isset($valueArr['5_hour_min_market_price']) && $valueArr['5_hour_min_market_price'] != '') {

	// 				$market_lowest_value = $valueArr['5_hour_min_market_price'];
	// 				$purchased_price = (float) $valueArr['market_value'];
	// 				$profit = $market_lowest_value - $purchased_price;

	// 				$profit_margin = ($profit / $market_lowest_value) * 100;

	// 				$min_profit_per_5 = ($profit) * (100 / $purchased_price);
	// 				$min_profit_per1[] = number_format($min_profit_per_5, 2);
	// 			}

	// 			if (isset($valueArr['market_heighest_value']) && $valueArr['market_heighest_value'] != '') {

	// 				$five_hour_max_market_price1 = $valueArr['market_heighest_value'];
	// 				$purchased_price1 = (float) $valueArr['market_value'];
	// 				$profit1 = $five_hour_max_market_price1 - $purchased_price1;

	// 				$profit_margin1 = ($profit1 / $five_hour_max_market_price1) * 100;

	// 				$max_profit_per_t = ($profit1) * (100 / $purchased_price1);

	// 				$max_profit_pert[] = number_format($max_profit_per_t, 2);
	// 			}

	// 			if (isset($valueArr['market_lowest_value']) && $valueArr['market_lowest_value'] != '') {

	// 				$market_lowest_value2 = $valueArr['market_lowest_value'];
	// 				$purchased_price2 = (float) $valueArr['market_value'];
	// 				$profit2 = $market_lowest_value2 - $purchased_price2;

	// 				$profit_margin2 = ($profit2 / $market_lowest_value2) * 100;

	// 				$min_profit_per2_t = ($profit2) * (100 / $purchased_price2);
	// 				$min_profit_per2[] = number_format($min_profit_per2_t, 2);
	// 			}

	// 			$market_sold_price = $valueArr['market_sold_price'];
	// 			$current_order_price = $valueArr['market_value'];
	// 			$quantity = $valueArr['quantity'];
	// 			$order_level = $valueArr['order_level'];
	// 			$coin_temp = $valueArr['symbol'];
	// 			$current_data2222 = $market_sold_price - $current_order_price;
	// 			$profit_data = ($current_data2222 * 100 / $market_sold_price);
	// 			$profit_data = number_format((float) $profit_data, 2, '.', '');
	// 			$total_btc = $quantity * (float) $current_order_price;
	// 			$total_profit += $total_btc * $profit_data;
	// 			$total_quantity += $total_btc;
	// 		}
	// 		if ($total_quantity == 0) {
	// 			$total_quantity = 1;
	// 		}
	// 		$max_profit_5h = (array_sum($max_profit_per) / count($max_profit_per));
	// 		$min_profit_5h = (array_sum($min_profit_per1) / count($min_profit_per1));
	// 		$max_profit_high = (array_sum($max_profit_pert) / count($max_profit_pert));
	// 		$min_profit_low = (array_sum($min_profit_per2) / count($min_profit_per2));
	// 		$avg_profit = $total_profit / $total_quantity;

	// 		$retArr['avg'][$key]['count']           = $total_sold_orders;
	// 		$retArr['avg'][$key]['avg']             = $avg_profit;
	// 		$retArr['avg'][$key]['max_profit_5h']   = $max_profit_5h;
	// 		$retArr['avg'][$key]['min_profit_5h']   = $min_profit_5h;
	// 		$retArr['avg'][$key]['max_profit_high'] = $max_profit_high;
	// 		$retArr['avg'][$key]['min_profit_low']  = $min_profit_low;
	// 		$retArr['avg'][$key]['order_level']     = $order_level;
	// 		$retArr['avg'][$key]['coin']            = $coin_temp;
	// 		//$retArr['avg'][$key]['buy_rule_number'] = $buy_rule_number;

	// 		$five_hr_up_down = $this->get_high_low_value($coin, $key . ":00:00", date("Y-m-d H:i:s", strtotime("+5 hours", strtotime($key . ":00:00"))));
	// 		$retArr['avg'][$key]['high_low'] = $five_hr_up_down;
	// 	}
	// 	$retArr['op'] = $op;
	// 	return $retArr;
	// }


	// public function calculate_no_of_oppurtunities($coin, $trades, $order_type, $dayHours)
	// {

	// 	$old_time = "";
	// 	$op       = 0;
	// 	$tempArr  = array();
	// 	array_multisort(array_column($trades, "created_date"), SORT_ASC, $trades);


	// 	foreach ($trades as $key => $value) {

	// 		if ($dayHours == 'days') {
	// 			$time = $value['created_date']->toDateTime()->format("Y-m-d 00");
	// 		} else {
	// 			$time = $value['created_date']->toDateTime()->format("Y-m-d H");
	// 		}
	// 		if ($time != $old_time) {
	// 			$op++;
	// 			//array_push($tempArr, $value);
	// 			$old_time = $time;
	// 			//array_push($tempArr, $time . ":00:00");
	// 			$tempArr[$time][] = $value;
	// 		} else {
	// 			$tempArr[$time][] = $value;
	// 		}
	// 		//$tempArr[$time][] = $value;
	// 	}




	// 	$retArr = array();
	// 	foreach ($tempArr as $key => $value) {
	// 		$profit_data = 0;
	// 		$total_btc = 0;
	// 		$total_profit = 0;
	// 		$total_quantity = 0;
	// 		$avg_profit = 0;
	// 		$total_sold_orders = 0;
	// 		$max_profit_per = array();
	// 		$min_profit_per1 = array();
	// 		$max_profit_pert = array();
	// 		$min_profit_per2 = array();
	// 		foreach ($value as $key_1 => $valueArr) {
	// 			$total_sold_orders++;

	// 			if (isset($valueArr['5_hour_max_market_price']) && $valueArr['5_hour_max_market_price'] != '') {

	// 				$five_hour_max_market_price = $valueArr['5_hour_max_market_price'];
	// 				$purchased_price = (float) $valueArr['market_value'];
	// 				$profit = $five_hour_max_market_price - $purchased_price;

	// 				$profit_margin = ($profit / $five_hour_max_market_price) * 100;

	// 				$max_profit_per_5 = ($profit) * (100 / $purchased_price);

	// 				$max_profit_per[] = number_format($max_profit_per_5, 2);
	// 			}

	// 			if (isset($valueArr['5_hour_min_market_price']) && $valueArr['5_hour_min_market_price'] != '') {

	// 				$market_lowest_value = $valueArr['5_hour_min_market_price'];
	// 				$purchased_price = (float) $valueArr['market_value'];
	// 				$profit = $market_lowest_value - $purchased_price;

	// 				$profit_margin = ($profit / $market_lowest_value) * 100;

	// 				$min_profit_per_5 = ($profit) * (100 / $purchased_price);
	// 				$min_profit_per1[] = number_format($min_profit_per_5, 2);
	// 			}

	// 			if (isset($valueArr['market_heighest_value']) && $valueArr['market_heighest_value'] != '') {

	// 				$five_hour_max_market_price1 = $valueArr['market_heighest_value'];
	// 				$purchased_price1 = (float) $valueArr['market_value'];
	// 				$profit1 = $five_hour_max_market_price1 - $purchased_price1;

	// 				$profit_margin1 = ($profit1 / $five_hour_max_market_price1) * 100;

	// 				$max_profit_per_t = ($profit1) * (100 / $purchased_price1);

	// 				$max_profit_pert[] = number_format($max_profit_per_t, 2);
	// 			}

	// 			if (isset($valueArr['market_lowest_value']) && $valueArr['market_lowest_value'] != '') {

	// 				$market_lowest_value2 = $valueArr['market_lowest_value'];
	// 				$purchased_price2 = (float) $valueArr['market_value'];
	// 				$profit2 = $market_lowest_value2 - $purchased_price2;

	// 				$profit_margin2 = ($profit2 / $market_lowest_value2) * 100;

	// 				$min_profit_per2_t = ($profit2) * (100 / $purchased_price2);
	// 				$min_profit_per2[] = number_format($min_profit_per2_t, 2);
	// 			}

	// 			$market_sold_price = $valueArr['market_sold_price'];
	// 			$current_order_price = $valueArr['market_value'];
	// 			$quantity = $valueArr['quantity'];
	// 			$order_level = $valueArr['order_level'];
	// 			$coin_temp = $valueArr['symbol'];
	// 			//$buy_rule_number = $valueArr['buy_rule_number'];


	// 			$current_data2222 = $market_sold_price - $current_order_price;
	// 			$profit_data = ($current_data2222 * 100 / $market_sold_price);
	// 			$profit_data = number_format((float) $profit_data, 2, '.', '');
	// 			$total_btc = $quantity * (float) $current_order_price;
	// 			$total_profit += $total_btc * $profit_data;
	// 			$total_quantity += $total_btc;
	// 		}
	// 		if ($total_quantity == 0) {
	// 			$total_quantity = 1;
	// 		}
	// 		// if(count($max_profit_per) =='0' || count($max_profit_per) =='null')
	// 		// {
	// 		// 	$max_profit_5h = (array_sum($max_profit_per));
	// 		// }
	// 		// else{
	// 		// 	$max_profit_5h = (array_sum($max_profit_per) / count($max_profit_per));
	// 		// }
	// 		// if( count($min_profit_per1) =='0' || count($min_profit_per1)== 'null')
	// 		// {
	// 		// 	$min_profit_5h = (array_sum($min_profit_per1));
	// 		// }
	// 		// else{
	// 		// 	$min_profit_5h = (array_sum($min_profit_per1) / count($min_profit_per1));
	// 		// }

	// 		// if(count($max_profit_pert) =='0' || count($max_profit_pert)== 'null')
	// 		// {
	// 		// 	$max_profit_high = (array_sum($max_profit_pert));
	// 		// }
	// 		// else{
	// 		// 	$max_profit_high = (array_sum($max_profit_pert) / count($max_profit_pert));
	// 		// }
	// 		// if(count($min_profit_per2) =='0' || count($min_profit_per2)=='null')
	// 		// {
	// 		// 	$min_profit_low = (array_sum($min_profit_per2));
	// 		// }
	// 		// else{
	// 		// 	$min_profit_low = (array_sum($min_profit_per2) / count($min_profit_per2));
	// 		// }
	// 		// if($total_quantity =='0' || $total_quantity=='null')
	// 		// {
	// 		// 	$avg_profit = $total_profit;
	// 		// }
	// 		// else{
	// 		// 	$avg_profit = $total_profit / $total_quantity;
	// 		// }
	// 		$max_profit_5h = (array_sum($max_profit_per) / count($max_profit_per));
	// 		$min_profit_5h = (array_sum($min_profit_per1) / count($min_profit_per1));
	// 		$max_profit_high = (array_sum($max_profit_pert) / count($max_profit_pert));
	// 		$min_profit_low = (array_sum($min_profit_per2) / count($min_profit_per2));
	// 		$avg_profit = $total_profit / $total_quantity;



	// 		$retArr['avg'][$key]['count']           = $total_sold_orders;
	// 		$retArr['avg'][$key]['order_type']      = $order_type;
	// 		$retArr['avg'][$key]['avg']             = $avg_profit;
	// 		$retArr['avg'][$key]['max_profit_5h']   = $max_profit_5h;
	// 		$retArr['avg'][$key]['min_profit_5h']   = $min_profit_5h;
	// 		$retArr['avg'][$key]['max_profit_high'] = $max_profit_high;
	// 		$retArr['avg'][$key]['min_profit_low']  = $min_profit_low;
	// 		$retArr['avg'][$key]['order_level']     = $order_level;
	// 		$retArr['avg'][$key]['coinsss_']         = $coin_temp;
	// 		//$retArr['avg'][$key]['buy_rule_number'] = $buy_rule_number;

	// 		$five_hr_up_down = $this->get_high_low_value($coin, $key . ":00:00", date("Y-m-d H:i:s", strtotime("+5 hours", strtotime($key . ":00:00"))));
	// 		$retArr['avg'][$key]['high_low'] = $five_hr_up_down;
	// 	}
	// 	$retArr['op'] = $op;

	// 	// echo"<pre>";
	// 	// print_r($retArr);exit;
	// 	return $retArr;
	// }

	// public function get_high_low_value($symbol, $start_date, $end_date)
	// {
	// 	// $start_date = "2019-02-01 00:00:00";
	// 	// $end_date = "2019-03-15 00:00:00";

	// 	$search_arr['coin'] = $symbol;
	// 	$search_arr['timestampDate']['$gte'] = $this->mongo_db->converToMongodttime($start_date);
	// 	$search_arr['timestampDate']['$lte'] = $this->mongo_db->converToMongodttime($end_date);

	// 	$this->mongo_db->where($search_arr);
	// 	$curser = $this->mongo_db->get("market_chart");
	// 	$result = iterator_to_array($curser);

	// 	$high_arr = array_column($result, 'high');
	// 	$low_arr = array_column($result, 'low');

	// 	$high = max($high_arr);
	// 	$low = min($low_arr);

	// 	return array("high" => $high, "low" => $low);
	// }

	// public function get_order_arr($order_arr, $coin)
	// {

	// 	// echo"asdiodksfw";exit;
	// 	$barrier = array();
	// 	foreach ($order_arr as $key1 => $value_arr) {
	// 		foreach ($value_arr as $key2 => $value2) {
	// 			$barrier[] = $value2;
	// 		}
	// 	}
	// 	if (count($barrier)) {
	// 		array_multisort(array_column($barrier, "created_date"), SORT_ASC, $barrier);

	// 		$start_date  = $barrier[0]['created_date']->toDatetime()->format("Y-m-d H:i:s");
	// 		$end_date    = $barrier[count($barrier) - 1]['created_date']->toDatetime()->format("Y-m-d H:i:s");
	// 		$first_price = $barrier[0]['market_value'];
	// 		$last_price  = $barrier[count($barrier) - 1]['market_value'];

	// 		$coin_avg_move = (($last_price - $first_price) / $first_price) * 100;



	// 		$high_low_arr = $this->get_high_low_value($coin, $start_date, $end_date);

	// 		$returnArr = $high_low_arr;
	// 		$returnArr['coin_avg_move'] = number_format($coin_avg_move, 2);
	// 		$returnArr['total'] = count($barrier);
	// 		// echo "121212<pre>";
	// 		// print_r($returnArr);exit;
	// 		return $returnArr;
	// 	} else {
	// 		return array();
	// 	}
	// } //End of make_date_quarter

	// public function meta_coin_report()
	// {
	// 	$this->mod_login->verify_is_admin_login();
	// 	// ini_set("display_errors", E_ALL);
	// 	// error_reporting(E_ALL);
	// 	if ($this->input->post()) {
	// 		$data_arr['filter_order_data'] = $this->input->post();
	// 		$this->session->set_userdata($data_arr);
	// 		if ($this->input->post('watch_later') == 'yes') {
	// 			$final_data = $this->meta_coin_report_calculation($this->input->post());
	// 			$data = $final_data;
	// 		} else {
	// 			$final_data = $this->meta_coin_report_calculation($this->input->post());
	// 			$data = $final_data;
	// 		}
	// 	}
	// 	$this->mongo_db->where(array('trigger' => 'barrier'));
	// 	$sett = $this->mongo_db->get("report_setting_collection");
	// 	$data['settings'] = iterator_to_array($sett);

	// 	$coins = $this->mod_coins->get_all_coins();
	// 	$data['coins'] = $coins;

	// 	$this->stencil->paint('admin/reports/meta_report', $data);
	// }
	// public function meta_coin_report_calculation($data_arr)
	// {
	// 	// ini_set("display_errors", E_ALL);
	// 	// error_reporting(E_ALL);
	// 	// echo "<pre>";
	// 	// print_r($data_arr);
	// 	// exit;
	// 	if ($data_arr['watch_later'] == 'yes') {
	// 		$data_arr['status'] = 1;
	// 		$data_arr['trigger'] = 'barrier';
	// 		$this->mongo_db->insert("report_setting_collection", $data_arr);
	// 		return true;
	// 	} else {
	// 		if (empty($data_arr['black_wall_pressure']) && empty($data_arr['seven_level_depth']) && empty($data_arr['market_depth_ask']) && empty($data_arr['market_depth']) && empty($data_arr['sellers_buyers_per']) && empty($data_arr['last_qty_buy_vs_sell']) && empty($data_arr['last_qty_time_ago']) && empty($data_arr['last_qty_time_ago_15']) && empty($data_arr['yellow_wall_pressure']) && empty($data_arr['bid']) && empty($data_arr['ask'])) {
	// 			$this->session->set_flashdata('ok_message', 'Please Select atleast one indicator.');
	// 			redirect(base_url() . "admin/reports/meta_coin_report");
	// 		}
	// 		$data_arr['status'] = 3;
	// 		$data_arr['trigger'] = 'barrier';
	// 		$this->mongo_db->insert("report_setting_collection", $data_arr);

	// 		$symbol = $data_arr['filter_by_coin'];
	// 		$start_date = $data_arr['filter_by_start_date'];
	// 		$end_date = $data_arr['filter_by_end_date'];

	// 		$date1 = new DateTime($start_date);
	// 		$date2 = new DateTime($end_date);

	// 		$diff = $date2->diff($date1);

	// 		$hours = $diff->h;
	// 		$hours = $hours + ($diff->days * 24);
	// 		$total_days = $diff->days;
	// 		$d1 = $start_date;

	// 		$target_profit = $data_arr['target_profit'];
	// 		$target_stoploss = $data_arr['target_stoploss'];

	// 		$date_range_hour = array();
	// 		for ($i = 0; $i <= $hours; $i++) {
	// 			$start = date("Y-m-d H:00:00", strtotime("+" . $i . " hours", strtotime($d1)));
	// 			$move = date("Y-m-d H:59:59", strtotime("+" . ($i) . " hours", strtotime($d1)));
	// 			$search_arr['coin'] = $symbol;
	// 			$search_arr['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($start);
	// 			$search_arr['modified_date']['$lte'] = $this->mongo_db->converToMongodttime($move);

	// 			$this->mongo_db->where($search_arr);
	// 			$res = $this->mongo_db->get("coin_meta_history");
	// 			$result = iterator_to_array($res);
	// 			$candle_condition = $this->check_candle_data($start, $data_arr);
	// 			foreach ($result as $metakey => $meta_value) {
	// 				if (!empty($meta_value)) {

	// 					$blackwall = false;
	// 					$seven_level = false;

	// 					$yellowall = false;
	// 					$big_buy = false;

	// 					$ask_qty = false;
	// 					$bid_qty = false;
	// 					$bvs = false;
	// 					$lastqty = false;
	// 					$lasttime = false;

	// 					$t3ltc = false;
	// 					$th4cot = false;
	// 					$bid = false;
	// 					$ask = false;
	// 					$meet_condition_for_buy = false;

	// 					$current_market_price = $meta_value['current_market_value'];
	// 					if ($barrier_check == 'yes') {
	// 						$barrier_range_percentage = $data_arr['barrier_range'];
	// 						$barrier_side = $data_arr['barrier_side'];
	// 						$barrier_type = $data_arr['barrier_type'];
	// 						$last_barrrier_value = "";
	// 						// $last_barrrier_value = $this->triggers_trades->list_barrier_status($symbol, 'very_strong_barrier', $current_market_price, 'down');

	// 						//%%%%%%%%%%%%%%%%%%% -- Barrier Status --%%%%%%%%%%%%%%%%%%%%%%%
	// 						$last_barrrier_value = $this->triggers_trades->list_barrier_status_simulator($symbol, $barrier_type, $current_market_price, $barrier_side, $start);

	// 						$barrier_val = $last_barrrier_value;

	// 						$barrier_value_range_upside = $last_barrrier_value + ($last_barrrier_value / 100) * $barrier_range_percentage;
	// 						$barrier_value_range_down_side = $last_barrrier_value - ($last_barrrier_value / 100) * $barrier_range_percentage;

	// 						if ((num($current_market_price) >= num($barrier_value_range_down_side)) && (num($current_market_price) <= num($barrier_value_range_upside))) {
	// 							$meet_condition_for_buy = true;
	// 						}
	// 					} else {
	// 						$meet_condition_for_buy = true;
	// 					}
	// 					if ($this->calculate_ifelse($data_arr['black_wall_pressure'], $meta_value['black_wall_pressure'], $data_arr['optradio_blackwall'])) {
	// 						$blackwall = true;
	// 					}

	// 					if ($this->calculate_ifelse($data_arr['seven_level_depth'], $meta_value['seven_level_depth'], $data_arr['optradio_sevenLevel'])) {
	// 						$seven_level = true;
	// 					}

	// 					if ($this->calculate_ifelse($data_arr['market_depth_ask'], $meta_value['market_depth_ask'], $data_arr['optradio_resistance'])) {
	// 						$ask_qty = true;
	// 					}

	// 					if ($this->calculate_ifelse($data_arr['market_depth_quantity'], $meta_value['market_depth_quantity'], $data_arr['optradio_support'])) {
	// 						$bid_qty = true;
	// 					}

	// 					if ($this->calculate_ifelse($data_arr['sellers_buyers_per'], $meta_value['sellers_buyers_per'], $data_arr['optradio_t1COT'])) {
	// 						$bvs = true;
	// 					}

	// 					if ($this->calculate_ifelse($data_arr['last_qty_buy_vs_sell'], $meta_value['last_qty_buy_vs_sell'], $data_arr['optradio_t1LTCV'])) {
	// 						$lastqty = true;
	// 					}

	// 					if ($this->calculate_ifelse($data_arr['last_qty_time_ago'], $meta_value['last_qty_time_ago'], $data_arr['optradio_t1LTCT'])) {
	// 						$lasttime = true;
	// 					}
	// 					//============================================================
	// 					if ($this->calculate_ifelse($data_arr['last_qty_time_ago_15'], $meta_value['last_qty_time_ago_15'], $data_arr['optradio_t3LTC'])) {
	// 						$t3ltc = true;
	// 					}

	// 					if ($this->calculate_ifelse($data_arr['sellers_buyers_per_fifteen'], $meta_value['sellers_buyers_per_fifteen'], $data_arr['optradio_t4COT'])) {
	// 						$th4cot = true;
	// 					}

	// 					if ($this->calculate_ifelse($data_arr['bid'], $meta_value['bid'], $data_arr['optradio_bsell'])) {
	// 						$bid = true;
	// 					}

	// 					if ($this->calculate_ifelse($data_arr['ask'], $meta_value['ask'], $data_arr['optradio_bbuy'])) {
	// 						$ask = true;
	// 					}

	// 					if ($this->calculate_ifelse($data_arr['yellow_wall_pressure'], $meta_value['yellow_wall_pressure'], $data_arr['optradio_yellow'])) {
	// 						$yellowall = true;
	// 					}

	// 					if ($this->calculate_ifelse($data_arr['ask_percentage'], $meta_value['ask_percentage'], $data_arr['optradio_bigbuyers'])) {
	// 						$big_buy = true;
	// 					}
	// 					// if (empty($data_arr['black_wall_pressure']) || $data_arr['black_wall_pressure'] <= (float) $meta_value['black_wall_pressure']) {
	// 					//     $blackwall = true;
	// 					// }

	// 					// if (empty($data_arr['seven_level_depth']) || $data_arr['seven_level_depth'] <= (float) $meta_value['seven_level_depth']) {
	// 					//     $seven_level = true;
	// 					// }

	// 					// if (empty($data_arr['market_depth_ask']) || $data_arr['market_depth_ask'] >= (float) $meta_value['market_depth_ask']) {
	// 					//     $ask_qty = true;
	// 					// }

	// 					// if (empty($data_arr['market_depth']) || $data_arr['market_depth'] <= (float) $meta_value['market_depth']) {
	// 					//     $bid_qty = true;
	// 					// }

	// 					// if (empty($data_arr['sellers_buyers_per']) || $data_arr['sellers_buyers_per'] <= (float) $meta_value['sellers_buyers_per']) {
	// 					//     $bvs = true;
	// 					// }

	// 					// if (empty($data_arr['last_qty_buy_vs_sell']) || $data_arr['last_qty_buy_vs_sell'] <= (float) $meta_value['last_qty_buy_vs_sell']) {
	// 					//     $lastqty = true;
	// 					// }

	// 					// if (empty($data_arr['last_qty_time_ago']) || $data_arr['last_qty_time_ago'] >= (float) $meta_value['last_qty_time_ago']) {
	// 					//     $lasttime = true;
	// 					// }

	// 					// /////////////////////////////////////////////////////////////////////////////////////////
	// 					// if (empty($data_arr['last_qty_time_ago_15']) || $data_arr['last_qty_time_ago_15'] >= (float) $meta_value['last_qty_time_ago_15']) {
	// 					//     $t3ltc = true;
	// 					// }

	// 					// if (empty($data_arr['sellers_buyers_per_fifteen']) || $data_arr['sellers_buyers_per_fifteen'] <= (float) $meta_value['sellers_buyers_per_fifteen']) {
	// 					//     $th4cot = true;
	// 					// }

	// 					// if (empty($data_arr['bid']) || $data_arr['bid'] >= (float) $meta_value['bid']) {
	// 					//     $bid = true;
	// 					// }

	// 					// if (empty($data_arr['ask']) || $data_arr['ask'] <= (float) $meta_value['ask']) {
	// 					//     $ask = true;
	// 					// }

	// 					// if (empty($data_arr['yellow_wall_pressure']) || $data_arr['yellow_wall_pressure'] >= (float) $meta_value['yellow_wall_pressure']) {
	// 					//     $yellowall = true;
	// 					// }

	// 					// if (empty($data_arr['ask_percentage']) || $data_arr['ask_percentage'] <= (float) $meta_value['ask_percentage']) {
	// 					//     $big_buy = true;
	// 					// }

	// 					if (
	// 						$candle_condition && $meet_condition_for_buy && $blackwall && $seven_level && $ask_qty && $bid_qty && $bvs && $lastqty && $lasttime && $t3ltc
	// 						&& $th4cot && $bid && $ask && $yellowall && $big_buy
	// 					) {
	// 						if (!array_key_exists($meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00"), $date_range_hour)) {
	// 							$date_range_hour[$meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['market_value'] = $meta_value['current_market_value'];
	// 							$date_range_hour[$meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['market_time'] = $meta_value['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 						}
	// 					}
	// 				}
	// 			} //end foreach result
	// 			////////////////////////////////////////////////////////

	// 			///////////////////////////////////////////////////////
	// 		} //end for loop hours

	// 		//echo "<pre>"; print_r($date_range_hour); exit;
	// 		$positive = 0;
	// 		$negitive = 0;
	// 		$winp = 0;
	// 		$losp = 0;
	// 		$retArr = array();
	// 		foreach ($date_range_hour as $key => $value) {
	// 			$profit_time_ago = '';
	// 			$los_time_ago = '';
	// 			$loss = 0;
	// 			$profit = 0;

	// 			$market_value = $value['market_value'];
	// 			$market_time = $value['market_time'];
	// 			$sell_price = $value['market_value'] + ($value['market_value'] * $target_profit) / 100;
	// 			$iniatial_trail_stop = $value['market_value'] - ($value['market_value'] / 100) * $target_stoploss;
	// 			$where['coin'] = $symbol;
	// 			$where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
	// 			$where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));
	// 			$where['current_market_value']['$gte'] = (float) $sell_price;

	// 			$queryHours = [
	// 				['$match' => $where],
	// 				['$sort' => ['modified_date' => 1]],
	// 				['$limit' => 1],
	// 			];

	// 			$db = $this->mongo_db->customQuery();
	// 			$response = $db->coin_meta_history->aggregate($queryHours);
	// 			$row = iterator_to_array($response);
	// 			$profit = 0;
	// 			$profit_date = "";
	// 			if (!empty($row)) {
	// 				$percentage = (($row[0]['current_market_value'] - $value['market_value']) / $row[0]['current_market_value']) * 100;
	// 				$profit = number_format($percentage, 2);
	// 				$profit_date = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 			}

	// 			$where1['coin'] = $symbol;
	// 			$where1['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
	// 			$where1['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));

	// 			$where1['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

	// 			$queryHours1 =
	// 				[
	// 					['$match' => $where1],
	// 					['$sort' => ['modified_date' => 1]],
	// 					['$limit' => 1],
	// 				];

	// 			// $this->mongo_db->where($where);
	// 			// $get = $this->mongo_db->get('coin_meta_history');
	// 			$db = $this->mongo_db->customQuery();
	// 			$response1 = $db->coin_meta_history->aggregate($queryHours1);
	// 			$row1 = iterator_to_array($response1);
	// 			$loss = 0;
	// 			$loss_date = 0;
	// 			if (!empty($row1)) {
	// 				$percentage = (($row1[0]['current_market_value'] - $value['market_value']) / $row1[0]['current_market_value']) * 100;
	// 				$loss = number_format($percentage, 2);
	// 				$loss_date = $row1[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 			}
	// 			$retArr[$key]['market_value'] = num($market_value);
	// 			$retArr[$key]['market_time'] = $market_time;
	// 			if (!empty($profit_date)) {
	// 				$profit_time_ago = $this->time_elapsed_string_min($profit_date, $key); //0
	// 				$retArr[$key]['proft_test_ago'] = $profit_time_ago;
	// 				$retArr[$key]['profit_time'] = $this->time_elapsed_string($profit_date, $key);
	// 				$retArr[$key]['profit_percentage'] = $profit;
	// 				$retArr[$key]['profit_date'] = $profit_date;
	// 			}
	// 			if (!empty($loss_date)) {
	// 				$los_time_ago = $this->time_elapsed_string_min($loss_date, $key);
	// 				$retArr[$key]['los_test_ago'] = $los_time_ago;
	// 				$retArr[$key]['loss_time'] = $this->time_elapsed_string($loss_date, $key);
	// 				$retArr[$key]['loss_percentage'] = $loss;
	// 				$retArr[$key]['loss_date'] = $loss_date;
	// 			}

	// 			// if (!empty($profit_time_ago) && !empty($los_time_ago)) {

	// 			//     if (($profit_time_ago > $los_time_ago)) {
	// 			//         $retArr[$key]['message'] = "Got Loss";
	// 			//     } else if (($profit_time_ago < $los_time_ago)) {
	// 			//         $retArr[$key]['message'] = "Got Profit";
	// 			//     } else {
	// 			//         continue;
	// 			//     }
	// 			// }

	// 			if ($los_time_ago == '' && $profit_time_ago == '') {
	// 				$retArr[$key]['message'] = '';
	// 			}
	// 			if ($los_time_ago != '' && $profit_time_ago == '') {
	// 				$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
	// 				$negitive++;
	// 				$losp += $retArr[$key]['loss_percentage'];
	// 			}
	// 			if ($los_time_ago == '' && $profit_time_ago != '') {
	// 				$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
	// 				$positive++;
	// 				$winp += $retArr[$key]['profit_percentage'];
	// 			}
	// 			if ($los_time_ago != '' && $profit_time_ago != '') {
	// 				if (($profit_time_ago > $los_time_ago)) {
	// 					$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
	// 					$negitive++;
	// 					$losp += $retArr[$key]['loss_percentage'];
	// 				} else if (($profit_time_ago < $los_time_ago)) {
	// 					$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
	// 					$positive++;
	// 					$winp += $retArr[$key]['profit_percentage'];
	// 				} else {
	// 					continue;
	// 				}
	// 			}
	// 		}
	// 		$winning_profit = $winp;
	// 		$losing_profit = $losp;

	// 		$total_profit = $winning_profit + $losing_profit;

	// 		$total_per_trade = $total_profit / (count($date_range_hour));

	// 		$total_per_day = $total_profit / $total_days;

	// 		$data['winners'] = $winning_profit;
	// 		$data['losers'] = $losing_profit;
	// 		$data['total_profit'] = $total_profit;
	// 		$data['per_trade'] = number_format($total_per_trade, 2);
	// 		$data['per_day'] = number_format($total_per_day, 2);

	// 		$data['final'] = $retArr;
	// 		$data['count_msg'] = count($date_range_hour);
	// 		$data['positive_msg'] = $positive;
	// 		$data['negitive_msg'] = $negitive;
	// 		$data['positive_percentage'] = number_format(($positive / ($positive + $negitive) * 100), 2);
	// 		$data['negitive_percentage'] = number_format(($negitive / ($positive + $negitive) * 100), 2);

	// 		$log_data = array(
	// 			'settings' => $data_arr,
	// 			'symbol' => $symbol,
	// 			'winning' => $positive,
	// 			'losing' => $negitive,
	// 			'win_per' => ($positive / ($positive + $negitive) * 100),
	// 			'lose_per' => ($negitive / ($positive + $negitive) * 100),
	// 			'total' => count($date_range_hour),
	// 			'result' => $retArr,
	// 			'created_date' => $this->mongo_db->converToMongodttime($start_date),
	// 			'end_date' => $this->mongo_db->converToMongodttime($end_date),
	// 		);

	// 		$this->mongo_db->insert("meta_report_log", $log_data);
	// 		return $data;
	// 	}
	// } //meta_coin_report_test()

	// function calculate_ifelse($field, $value, $op)
	// {
	// 	if (empty($field)) {
	// 		return true;
	// 	} else if ($op == 'g') {
	// 		if ($field <= (float) $value) {
	// 			return true;
	// 		}
	// 	} else if ($op == 'l') {
	// 		if ($field >= (float) $value) {
	// 			return true;
	// 		}
	// 	} else {
	// 		return false;
	// 	}
	// }

	// public function check_candle_data($hour, $data_arr)
	// {
	// 	$search_arr['coin'] = $data_arr['filter_by_coin'];
	// 	$search_arr['timestampDate'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("-1 hour", strtotime($hour))));

	// 	$this->mongo_db->where($search_arr);
	// 	$this->mongo_db->limit(1);
	// 	$get = $this->mongo_db->get('market_chart');
	// 	$row = iterator_to_array($get);
	// 	$result = $row[0];
	// 	$curr_high = $result['high'];
	// 	$curr_low = $result['low'];
	// 	$current_market_price = ($curr_high + $curr_low) / 2;
	// 	$status = false;
	// 	$swing = false;
	// 	$type = false;
	// 	$move = false;
	// 	$new = false;
	// 	$condition = false;

	// 	if (empty($data_arr['swing_status']) || in_array($result['global_swing_status'], $data_arr['swing_status'])) {
	// 		$swing = true;
	// 	}

	// 	if (empty($data_arr['candle_status']) || in_array($result['candel_status'], $data_arr['candle_status'])) {
	// 		$status = true;
	// 	}

	// 	if (empty($data_arr['candle_type']) || in_array($result['candle_type'], $data_arr['candle_type'])) {
	// 		$type = true;
	// 	}

	// 	if (empty($data_arr['move']) || $result['move'] >= $data_arr['move']) {
	// 		$move = true;
	// 	}
	// 	if ($data_arr['candle_chk'] == 'yes') {
	// 		$open = $result['last_24_hour_open'];
	// 		$close = $result['last_24_hour_close'];
	// 		$high = $result['last_24_hour_high'];
	// 		$low = $result['last_24_hour_low'];

	// 		$formula = $data_arr['formula'];
	// 		if ($formula == 'highlow') {
	// 			$distance = (($high - $low) / 100) * $data_arr['candle_range'];
	// 			$upper_range = $high - $distance;
	// 			$lower_range = $low + $distance;

	// 			if ($data_arr['candle_side'] == 'up') {
	// 				if ($current_market_price >= $upper_range && $current_market_price <= $high) {
	// 					$condition = true;
	// 				}
	// 			} else {
	// 				if ($current_market_price <= $lower_range && $current_market_price >= $low) {
	// 					$condition = true;
	// 				}
	// 			}
	// 		} elseif ($formula == 'openclose') {
	// 			if ($open > $close) {
	// 				$big = $open;
	// 				$small = $close;
	// 			} else {
	// 				$big = $close;
	// 				$small = $open;
	// 			}
	// 			$distance = (($open - $close) / 100) * $data_arr['candle_range'];
	// 			if ($data_arr['candle_side'] == 'up') {
	// 				if ($current_market_price >= $distance && $current_market_price <= $big) {
	// 					$condition = true;
	// 				}
	// 			} else {
	// 				if ($current_market_price <= $distance && $current_market_price >= $small) {
	// 					$condition = true;
	// 				}
	// 			}
	// 		}
	// 	} else {
	// 		$condition = true;
	// 	}

	// 	if ($status && $swing && $type && $move && $condition) {
	// 		$new = true;
	// 	}

	// 	return $new;
	// }

	// function time_elapsed_string_min($datetime, $pre_time, $full = false)
	// {
	// 	$now = new DateTime($pre_time);
	// 	$ago = new DateTime($datetime);
	// 	$diff = $now->diff($ago);

	// 	$diff->w = floor($diff->d / 7);
	// 	$diff->d -= $diff->w * 7;
	// 	$day = $diff->d;
	// 	$dayc = (24 * $day) * 60;
	// 	$hrs = $diff->h;
	// 	$hrsc = $hrs * 60;
	// 	$mins = $diff->i;
	// 	$sec = $diff->s;
	// 	$secc = $sec / 60;
	// 	$Tmins = round($dayc + $hrsc + $mins + $secc);

	// 	return $Tmins;
	// }
	// function time_elapsed_string($datetime, $pre_time, $full = false)
	// {
	// 	$now = new DateTime($pre_time);
	// 	$ago = new DateTime($datetime);
	// 	$diff = $now->diff($ago);

	// 	$diff->w = floor($diff->d / 7);
	// 	$diff->d -= $diff->w * 7;

	// 	$string = array(
	// 		'y' => 'year',
	// 		'm' => 'month',
	// 		'w' => 'week',
	// 		'd' => 'day',
	// 		'h' => 'hour',
	// 		'i' => 'min',
	// 		's' => 'sec',
	// 	);
	// 	foreach ($string as $k => &$v) {
	// 		if ($diff->$k) {
	// 			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	// 		} else {
	// 			unset($string[$k]);
	// 		}
	// 	}

	// 	if (!$full) {
	// 		$string = array_slice($string, 0, 1);
	// 	}

	// 	return $string ? implode(', ', $string) . '' : 'just now';
	// }

	// public function meta_coin_report_percentile()
	// {
	// 	$this->mod_login->verify_is_admin_login();
	// 	// ini_set("display_errors", E_ALL);
	// 	// error_reporting(E_ALL);
	// 	if ($this->input->post()) {
	// 		$data_arr['filter_order_data'] = $this->input->post();
	// 		$this->session->set_userdata($data_arr);
	// 		$final_data = $this->meta_coin_report_test($this->input->post());
	// 		$data['final'] = $final_data;
	// 	}
	// 	$option_arr = array(
	// 		"1" => "Top 1%",
	// 		"2" => "Top 2%",
	// 		"3" => "Top 3%",
	// 		"4" => "Top 4%",
	// 		"5" => "Top 5%",
	// 		"10" => "Top 10%",
	// 		"15" => "Top 15%",
	// 		"20" => "Top 20%",
	// 		"25" => "Top 25%",
	// 		"-25" => "Bottom 25%",
	// 		"-20" => "Bottom 20%",
	// 		"-15" => "Bottom 15%",
	// 		"-10" => "Bottom 10%",
	// 		"-5" => "Bottom 5%",
	// 		"-4" => "Bottom 4%",
	// 		"-3" => "Bottom 3%",
	// 		"-2" => "Bottom 2%",
	// 		"-1" => "Bottom 1%",

	// 	);
	// 	$this->mongo_db->where(array('trigger' => 'percentile'));
	// 	$sett = $this->mongo_db->get("report_setting_collection");
	// 	$data['settings'] = iterator_to_array($sett);

	// 	$coins = $this->mod_coins->get_all_coins();
	// 	$data['coins'] = $coins;
	// 	$data['options'] = $option_arr;
	// 	$this->stencil->paint('admin/reports/meta_report_1', $data);
	// }

	// public function meta_coin_report_test($data_arr)
	// {
	// 	// echo "<pre>";
	// 	// print_r($data_arr);
	// 	// exit;
	// 	// ini_set("display_errors", 1);
	// 	// error_reporting(E_ALL);
	// 	if ($data_arr['watch_later'] == 'yes') {
	// 		$coin_arr = $data_arr['filter_by_coin'];
	// 		foreach ($coin_arr as $key => $value) {
	// 			$data_arr['status'] = 1;
	// 			$data_arr['filter_by_coin'] = $value;
	// 			$data_arr['trigger'] = 'percentile';
	// 			$this->mongo_db->insert("report_setting_collection", $data_arr);
	// 		}
	// 		return true;
	// 	} else {

	// 		$data_arr['status'] = 3;
	// 		$data_arr['trigger'] = 'percentile';
	// 		$this->mongo_db->insert("report_setting_collection", $data_arr);

	// 		$symbol = $data_arr['filter_by_coin'];
	// 		$start_date = $data_arr['filter_by_start_date'];
	// 		$end_date = $data_arr['filter_by_end_date'];
	// 		$barrier_check = $data_arr['barrier_check'];

	// 		$date1 = new DateTime($start_date);
	// 		$date2 = new DateTime($end_date);

	// 		$diff = $date2->diff($date1);

	// 		$hours = $diff->h;
	// 		$hours = $hours + ($diff->days * 24);
	// 		$total_days = $diff->days;
	// 		$d1 = $start_date;

	// 		$target_profit = $data_arr['target_profit'];
	// 		$target_stoploss = $data_arr['target_stoploss'];

	// 		$date_range_hour = array();
	// 		for ($i = 0; $i <= $hours; $i++) {
	// 			$start = date("Y-m-d H:00:00", strtotime("+" . $i . " hours", strtotime($d1)));
	// 			$move = date("Y-m-d H:59:59", strtotime("+" . ($i) . " hours", strtotime($d1)));
	// 			$search_arr['coin'] = $symbol;
	// 			$search_arr['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($start);
	// 			$search_arr['modified_date']['$lte'] = $this->mongo_db->converToMongodttime($move);

	// 			$this->mongo_db->where($search_arr);
	// 			$res = $this->mongo_db->get("coin_meta_history");
	// 			$result = iterator_to_array($res);
	// 			$barrier_val = '';

	// 			$candle_condition = $this->check_candle_data($start, $data_arr);
	// 			foreach ($result as $metakey => $meta_value) {
	// 				if (!empty($meta_value)) {

	// 					$blackwall = false;
	// 					$seven_level = false;
	// 					$big_buy = false;
	// 					$big_sell = false;
	// 					$t1cot = false;
	// 					$t4cot = false;
	// 					$t1ltcq = false;
	// 					$t1ltct = false;
	// 					$t3ltc = false;
	// 					$vbask = false;
	// 					$vbbid = false;
	// 					$bid = false;
	// 					$ask = false;
	// 					$meet_condition_for_buy = false;

	// 					$current_market_price = $meta_value['current_market_value'];
	// 					if ($barrier_check == 'yes') {
	// 						$barrier_range_percentage = $data_arr['barrier_range'];
	// 						$barrier_side = $data_arr['barrier_side'];
	// 						$barrier_type = $data_arr['barrier_type'];
	// 						$last_barrrier_value = "";
	// 						// $last_barrrier_value = $this->triggers_trades->list_barrier_status($symbol, 'very_strong_barrier', $current_market_price, 'down');

	// 						//%%%%%%%%%%%%%%%%%%% -- Barrier Status --%%%%%%%%%%%%%%%%%%%%%%%
	// 						$last_barrrier_value = $this->triggers_trades->list_barrier_status_simulator($symbol, $barrier_type, $current_market_price, $barrier_side, $start);

	// 						$barrier_val = $last_barrrier_value;

	// 						$barrier_value_range_upside = $last_barrrier_value + ($last_barrrier_value / 100) * $barrier_range_percentage;
	// 						$barrier_value_range_down_side = $last_barrrier_value - ($last_barrrier_value / 100) * $barrier_range_percentage;

	// 						if ((num($current_market_price) >= num($barrier_value_range_down_side)) && (num($current_market_price) <= num($barrier_value_range_upside))) {
	// 							$meet_condition_for_buy = true;
	// 						}
	// 					} else {
	// 						$meet_condition_for_buy = true;
	// 					}
	// 					if (empty($data_arr['black_wall_percentile'])) {
	// 						$blackwall = true;
	// 					} else if ($data_arr['black_wall_percentile'] > 0) {
	// 						if ($data_arr['black_wall_percentile'] >= (float) $meta_value['black_wall_percentile'] && ((float) $meta_value['black_wall_percentile'] > 0)) {
	// 							$blackwall = true;
	// 						} else {
	// 							$blackwall = false;
	// 						}
	// 					} else if ($data_arr['black_wall_percentile'] < 0) {
	// 						if ($data_arr['black_wall_percentile'] <= (float) $meta_value['black_wall_percentile'] && ((float) $meta_value['black_wall_percentile'] < 0)) {
	// 							$blackwall = true;
	// 						} else {
	// 							$blackwall = false;
	// 						}
	// 					}

	// 					if (empty($data_arr['sevenlevel_percentile'])) {
	// 						$seven_level = true;
	// 					} else if ($data_arr['sevenlevel_percentile'] > 0) {
	// 						if ($data_arr['sevenlevel_percentile'] >= (float) $meta_value['sevenlevel_percentile'] && ((float) $meta_value['sevenlevel_percentile'] > 0)) {
	// 							$seven_level = true;
	// 						} else {
	// 							$seven_level = false;
	// 						}
	// 					} else if ($data_arr['sevenlevel_percentile'] < 0) {
	// 						if ($data_arr['sevenlevel_percentile'] <= (float) $meta_value['sevenlevel_percentile'] && ((float) $meta_value['sevenlevel_percentile'] < 0)) {
	// 							$seven_level = true;
	// 						} else {
	// 							$seven_level = false;
	// 						}
	// 					}

	// 					if (empty($data_arr['big_buyers_percentile'])) {
	// 						$big_buy = true;
	// 					} else if ($data_arr['big_buyers_percentile'] > 0) {
	// 						if ($data_arr['big_buyers_percentile'] >= (float) $meta_value['big_buyers_percentile'] && ((float) $meta_value['big_buyers_percentile'] > 0)) {
	// 							$big_buy = true;
	// 						} else {
	// 							$big_buy = false;
	// 						}
	// 					} else if ($data_arr['big_buyers_percentile'] < 0) {
	// 						if ($data_arr['big_buyers_percentile'] <= (float) $meta_value['big_buyers_percentile'] && ((float) $meta_value['big_buyers_percentile'] < 0)) {
	// 							$big_buy = true;
	// 						} else {
	// 							$big_buy = false;
	// 						}
	// 					}

	// 					if (empty($data_arr['big_sellers_percentile'])) {
	// 						$big_sell = true;
	// 					} else if ($data_arr['big_sellers_percentile'] > 0) {
	// 						if ($data_arr['big_sellers_percentile'] >= (float) $meta_value['big_sellers_percentile'] && ((float) $meta_value['big_sellers_percentile'] > 0)) {
	// 							$big_sell = true;
	// 						} else {
	// 							$big_sell = false;
	// 						}
	// 					} else if ($data_arr['big_sellers_percentile'] < 0) {
	// 						if ($data_arr['big_sellers_percentile'] <= (float) $meta_value['big_sellers_percentile'] && ((float) $meta_value['big_sellers_percentile'] < 0)) {
	// 							$big_sell = true;
	// 						} else {
	// 							$big_sell = false;
	// 						}
	// 					}

	// 					if (empty($data_arr['five_buy_sell_percentile'])) {
	// 						$t1cot = true;
	// 					} else if ($data_arr['five_buy_sell_percentile'] > 0) {
	// 						if ($data_arr['five_buy_sell_percentile'] >= (float) $meta_value['five_buy_sell_percentile'] && ((float) $meta_value['five_buy_sell_percentile'] > 0)) {
	// 							$t1cot = true;
	// 						} else {
	// 							$t1cot = false;
	// 						}
	// 					} else if ($data_arr['five_buy_sell_percentile'] < 0) {
	// 						if ($data_arr['five_buy_sell_percentile'] <= (float) $meta_value['five_buy_sell_percentile'] && ((float) $meta_value['five_buy_sell_percentile'] < 0)) {
	// 							$t1cot = true;
	// 						} else {
	// 							$t1cot = false;
	// 						}
	// 					}

	// 					if (empty($data_arr['fifteen_buy_sell_percentile'])) {
	// 						$t4cot = true;
	// 					} else if ($data_arr['fifteen_buy_sell_percentile'] > 0) {
	// 						if ($data_arr['fifteen_buy_sell_percentile'] >= (float) $meta_value['fifteen_buy_sell_percentile'] && ((float) $meta_value['fifteen_buy_sell_percentile'] > 0)) {
	// 							$t4cot = true;
	// 						} else {
	// 							$t4cot = false;
	// 						}
	// 					} else if ($data_arr['fifteen_buy_sell_percentile'] < 0) {
	// 						if ($data_arr['fifteen_buy_sell_percentile'] <= (float) $meta_value['fifteen_buy_sell_percentile'] && ((float) $meta_value['fifteen_buy_sell_percentile'] < 0)) {
	// 							$t4cot = true;
	// 						} else {
	// 							$t4cot = false;
	// 						}
	// 					}

	// 					if (empty($data_arr['last_qty_buy_sell_percentile'])) {
	// 						$t1ltcq = true;
	// 					} else if ($data_arr['last_qty_buy_sell_percentile'] > 0) {
	// 						if ($data_arr['last_qty_buy_sell_percentile'] >= (float) $meta_value['last_qty_buy_sell_percentile'] && ((float) $meta_value['last_qty_buy_sell_percentile'] > 0)) {
	// 							$t1ltcq = true;
	// 						} else {
	// 							$t1ltcq = false;
	// 						}
	// 					} else if ($data_arr['last_qty_buy_sell_percentile'] < 0) {
	// 						if ($data_arr['last_qty_buy_sell_percentile'] <= (float) $meta_value['last_qty_buy_sell_percentile'] && ((float) $meta_value['last_qty_buy_sell_percentile'] < 0)) {
	// 							$t1ltcq = true;
	// 						} else {
	// 							$t1ltcq = false;
	// 						}
	// 					}

	// 					if (empty($data_arr['last_qty_time_percentile'])) {
	// 						$t1ltct = true;
	// 					} else if ($data_arr['last_qty_time_percentile'] > 0) {
	// 						if ($data_arr['last_qty_time_percentile'] >= (float) $meta_value['last_qty_time_percentile'] && ((float) $meta_value['last_qty_time_percentile'] > 0)) {
	// 							$t1ltct = true;
	// 						} else {
	// 							$t1ltct = false;
	// 						}
	// 					} else if ($data_arr['last_qty_time_percentile'] < 0) {
	// 						if ($data_arr['last_qty_time_percentile'] <= (float) $meta_value['last_qty_time_percentile'] && ((float) $meta_value['last_qty_time_percentile'] < 0)) {
	// 							$t1ltct = true;
	// 						} else {
	// 							$t1ltct = false;
	// 						}
	// 					}

	// 					if (empty($data_arr['last_qty_time_fif_percentile'])) {
	// 						$t3ltc = true;
	// 					} else if ($data_arr['last_qty_time_fif_percentile'] > 0) {
	// 						if ($data_arr['last_qty_time_fif_percentile'] >= (float) $meta_value['last_qty_time_fif_percentile'] && ((float) $meta_value['last_qty_time_fif_percentile'] > 0)) {
	// 							$t3ltc = true;
	// 						} else {
	// 							$t3ltc = false;
	// 						}
	// 					} else if ($data_arr['last_qty_time_fif_percentile'] < 0) {
	// 						if ($data_arr['last_qty_time_fif_percentile'] <= (float) $meta_value['last_qty_time_fif_percentile'] && ((float) $meta_value['last_qty_time_fif_percentile'] < 0)) {
	// 							$t3ltc = true;
	// 						} else {
	// 							$t3ltc = false;
	// 						}
	// 					}

	// 					if (empty($data_arr['virtual_barrier_percentile_ask'])) {
	// 						$vbask = true;
	// 					} else if ($data_arr['virtual_barrier_percentile_ask'] > 0) {
	// 						if ($data_arr['virtual_barrier_percentile_ask'] >= (float) $meta_value['virtual_barrier_percentile_ask'] && ((float) $meta_value['virtual_barrier_percentile_ask'] > 0)) {
	// 							$vbask = true;
	// 						} else {
	// 							$vbask = false;
	// 						}
	// 					} else if ($data_arr['virtual_barrier_percentile_ask'] < 0) {
	// 						if ($data_arr['virtual_barrier_percentile_ask'] <= (float) $meta_value['virtual_barrier_percentile_ask'] && ((float) $meta_value['virtual_barrier_percentile_ask'] < 0)) {
	// 							$vbask = true;
	// 						} else {
	// 							$vbask = false;
	// 						}
	// 					}

	// 					if (empty($data_arr['virtual_barrier_percentile'])) {
	// 						$vbbid = true;
	// 					} else if ($data_arr['virtual_barrier_percentile'] > 0) {
	// 						if ($data_arr['virtual_barrier_percentile'] >= (float) $meta_value['virtual_barrier_percentile'] && ((float) $meta_value['virtual_barrier_percentile'] > 0)) {
	// 							$vbbid = true;
	// 						} else {
	// 							$vbbid = false;
	// 						}
	// 					} else if ($data_arr['virtual_barrier_percentile'] < 0) {
	// 						if ($data_arr['virtual_barrier_percentile'] <= (float) $meta_value['virtual_barrier_percentile'] && ((float) $meta_value['virtual_barrier_percentile'] < 0)) {
	// 							$vbbid = true;
	// 						} else {
	// 							$vbbid = false;
	// 						}
	// 					}
	// 					if (empty($data_arr['bid_percentile'])) {
	// 						$bid = true;
	// 					} else if ($data_arr['bid_percentile'] > 0) {
	// 						if ($data_arr['bid_percentile'] >= (float) $meta_value['bid_percentile'] && ((float) $meta_value['bid_percentile'] > 0)) {
	// 							$bid = true;
	// 						} else {
	// 							$bid = false;
	// 						}
	// 					} else if ($data_arr['bid_percentile'] < 0) {
	// 						if ($data_arr['bid_percentile'] <= (float) $meta_value['bid_percentile'] && ((float) $meta_value['bid_percentile'] < 0)) {
	// 							$bid = true;
	// 						} else {
	// 							$bid = false;
	// 						}
	// 					}

	// 					if (empty($data_arr['ask_percentile'])) {
	// 						$ask = true;
	// 					} else if ($data_arr['ask_percentile'] > 0) {
	// 						if ($data_arr['ask_percentile'] >= (float) $meta_value['ask_percentile'] && ((float) $meta_value['ask_percentile'] > 0)) {
	// 							$ask = true;
	// 						} else {
	// 							$ask = false;
	// 						}
	// 					} else if ($data_arr['ask_percentile'] < 0) {
	// 						if ($data_arr['ask_percentile'] <= (float) $meta_value['ask_percentile'] && ((float) $meta_value['ask_percentile'] < 0)) {
	// 							$ask = true;
	// 						} else {
	// 							$ask = false;
	// 						}
	// 					}

	// 					if ($candle_condition && $blackwall && $seven_level && $big_buy && $big_sell && $t1cot && $t4cot && $t1ltcq && $t1ltct && $t3ltc && $vbask && $vbbid && $bid && $ask && $meet_condition_for_buy) {
	// 						if (!array_key_exists($meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00"), $date_range_hour)) {
	// 							$date_range_hour[$meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['market_value'] = $meta_value['current_market_value'];
	// 							$date_range_hour[$meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['market_time'] = $meta_value['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 							$date_range_hour[$meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['barrier_value'] = $barrier_val;
	// 						}
	// 					}
	// 				}
	// 			} //end foreach result
	// 			////////////////////////////////////////////////////////

	// 			///////////////////////////////////////////////////////
	// 		} //end for loop hours
	// 		$positive = 0;
	// 		$negitive = 0;
	// 		$winp = 0;
	// 		$losp = 0;
	// 		$retArr = array();
	// 		foreach ($date_range_hour as $key => $value) {

	// 			$market_value = $value['market_value'];
	// 			$market_time = $value['market_time'];
	// 			$deep_price_check = $data_arr['deep_price_check'];
	// 			$deep_price_lookup_in_hours = $data_arr['deep_price_lookup_in_hours'];
	// 			$opp_chk = $data_arr['opp_chk'];
	// 			$is_opp = $this->check_real_oppurtunity($market_value, $market_time, $deep_price_check, $deep_price_lookup_in_hours, $symbol, $opp_chk);

	// 			if ($is_opp) {

	// 				$profit_time_ago = '';
	// 				$los_time_ago = '';
	// 				$loss = 0;
	// 				$profit = 0;
	// 				$market_value = $value['market_value'];
	// 				$market_time = $value['market_time'];
	// 				$barrier = $value['barrier_value'];
	// 				$sell_price = $value['market_value'] + ($value['market_value'] * $target_profit) / 100;
	// 				$deep_price = $market_value - ($market_value / 100) * $deep_price_check;

	// 				$where['coin'] = $symbol;
	// 				$where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
	// 				$where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $deep_price_lookup_in_hours . " hours", strtotime($market_time))));
	// 				$where['current_market_value']['$lte'] = (float) $deep_price;

	// 				$queryHours = [
	// 					['$match' => $where],
	// 					['$sort' => ['modified_date' => 1]],
	// 					['$limit' => 1],
	// 				];

	// 				$db = $this->mongo_db->customQuery();
	// 				$response = $db->coin_meta_history->aggregate($queryHours);
	// 				$row = iterator_to_array($response);

	// 				if (!empty($row[0])) {
	// 					$timep = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 				} else {
	// 					$timep = $market_time;
	// 				}

	// 				$iniatial_trail_stop = $value['market_value'] - ($value['market_value'] / 100) * $target_stoploss;
	// 				$where['coin'] = $symbol;
	// 				$where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($timep);
	// 				$where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $deep_price_lookup_in_hours . " hours", strtotime($timep))));
	// 				$where['current_market_value']['$gte'] = (float) $sell_price;

	// 				$queryHours = [
	// 					['$match' => $where],
	// 					['$sort' => ['modified_date' => 1]],
	// 					['$limit' => 1],
	// 				];

	// 				$db = $this->mongo_db->customQuery();
	// 				$response = $db->coin_meta_history->aggregate($queryHours);
	// 				$row = iterator_to_array($response);
	// 				$profit = 0;
	// 				$profit_date = "";
	// 				if (!empty($row)) {
	// 					$percentage = (($row[0]['current_market_value'] - $value['market_value']) / $row[0]['current_market_value']) * 100;
	// 					$profit = number_format($percentage, 2);
	// 					$profit_date = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 				}

	// 				$where1['coin'] = $symbol;
	// 				$where1['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
	// 				$where1['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));

	// 				$where1['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

	// 				$queryHours1 =
	// 					[
	// 						['$match' => $where1],
	// 						['$sort' => ['modified_date' => 1]],
	// 						['$limit' => 1],
	// 					];

	// 				// $this->mongo_db->where($where);
	// 				// $get = $this->mongo_db->get('coin_meta_history');
	// 				$db = $this->mongo_db->customQuery();
	// 				$response1 = $db->coin_meta_history->aggregate($queryHours1);
	// 				$row1 = iterator_to_array($response1);
	// 				$loss = 0;
	// 				$loss_date = 0;
	// 				if (!empty($row1)) {
	// 					$percentage = (($row1[0]['current_market_value'] - $value['market_value']) / $row1[0]['current_market_value']) * 100;
	// 					$loss = number_format($percentage, 2);
	// 					$loss_date = $row1[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 				}
	// 				$retArr[$key]['market_value'] = num($market_value);
	// 				$retArr[$key]['market_time'] = $market_time;
	// 				$retArr[$key]['barrier'] = num($barrier);
	// 				if (!empty($profit_date)) {
	// 					$profit_time_ago = $this->time_elapsed_string_min($profit_date, $key); //0
	// 					$retArr[$key]['proft_test_ago'] = $profit_time_ago;
	// 					$retArr[$key]['profit_time'] = $this->time_elapsed_string($profit_date, $key);
	// 					$retArr[$key]['profit_percentage'] = $profit;
	// 					$retArr[$key]['profit_date'] = $profit_date;
	// 				}
	// 				if (!empty($loss_date)) {
	// 					$los_time_ago = $this->time_elapsed_string_min($loss_date, $key);
	// 					$retArr[$key]['los_test_ago'] = $los_time_ago;
	// 					$retArr[$key]['loss_time'] = $this->time_elapsed_string($loss_date, $key);
	// 					$retArr[$key]['loss_percentage'] = $loss;
	// 					$retArr[$key]['loss_date'] = $loss_date;
	// 				}

	// 				// if (!empty($profit_time_ago) && !empty($los_time_ago)) {

	// 				//     if (($profit_time_ago > $los_time_ago)) {
	// 				//         $retArr[$key]['message'] = "Got Loss";
	// 				//     } else if (($profit_time_ago < $los_time_ago)) {
	// 				//         $retArr[$key]['message'] = "Got Profit";
	// 				//     } else {
	// 				//         continue;
	// 				//     }
	// 				// }

	// 				if ($los_time_ago == '' && $profit_time_ago == '') {
	// 					$retArr[$key]['message'] = '';
	// 				}
	// 				if ($los_time_ago != '' && $profit_time_ago == '') {
	// 					$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
	// 					$negitive++;
	// 					$losp += $retArr[$key]['loss_percentage'];
	// 				}
	// 				if ($los_time_ago == '' && $profit_time_ago != '') {
	// 					$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
	// 					$positive++;
	// 					$winp += $retArr[$key]['profit_percentage'];
	// 				}
	// 				if ($los_time_ago != '' && $profit_time_ago != '') {
	// 					if (($profit_time_ago > $los_time_ago)) {
	// 						$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
	// 						$negitive++;
	// 						$losp += $retArr[$key]['loss_percentage'];
	// 					} else if (($profit_time_ago < $los_time_ago)) {
	// 						$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
	// 						$positive++;
	// 						$winp += $retArr[$key]['profit_percentage'];
	// 					} else {
	// 						continue;
	// 					}
	// 				}
	// 			} else {

	// 				$profit_time_ago = '';
	// 				$los_time_ago = '';
	// 				$loss = 0;
	// 				$profit = 0;

	// 				$market_value = $value['market_value'];
	// 				$market_time = $value['market_time'];
	// 				$barrier = $value['barrier_value'];
	// 				$sell_price = $value['market_value'] + ($value['market_value'] * $target_profit) / 100;
	// 				$iniatial_trail_stop = $value['market_value'] - ($value['market_value'] / 100) * $target_stoploss;
	// 				$where['coin'] = $symbol;
	// 				$where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
	// 				$where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));
	// 				$where['current_market_value']['$gte'] = (float) $sell_price;

	// 				$queryHours = [
	// 					['$match' => $where],
	// 					['$sort' => ['modified_date' => 1]],
	// 					['$limit' => 1],
	// 				];

	// 				$db = $this->mongo_db->customQuery();
	// 				$response = $db->coin_meta_history->aggregate($queryHours);
	// 				$row = iterator_to_array($response);
	// 				$profit = 0;
	// 				$profit_date = "";
	// 				if (!empty($row)) {
	// 					$percentage = (($row[0]['current_market_value'] - $value['market_value']) / $row[0]['current_market_value']) * 100;
	// 					$profit = number_format($percentage, 2);
	// 					$profit_date = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 				}

	// 				$where1['coin'] = $symbol;
	// 				$where1['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
	// 				$where1['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));

	// 				$where1['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

	// 				$queryHours1 =
	// 					[
	// 						['$match' => $where1],
	// 						['$sort' => ['modified_date' => 1]],
	// 						['$limit' => 1],
	// 					];

	// 				// $this->mongo_db->where($where);
	// 				// $get = $this->mongo_db->get('coin_meta_history');
	// 				$db = $this->mongo_db->customQuery();
	// 				$response1 = $db->coin_meta_history->aggregate($queryHours1);
	// 				$row1 = iterator_to_array($response1);
	// 				$loss = 0;
	// 				$loss_date = 0;
	// 				if (!empty($row1)) {
	// 					$percentage = (($row1[0]['current_market_value'] - $value['market_value']) / $row1[0]['current_market_value']) * 100;
	// 					$loss = number_format($percentage, 2);
	// 					$loss_date = $row1[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 				}
	// 				$retArr[$key]['market_value'] = num($market_value);
	// 				$retArr[$key]['market_time'] = $market_time;
	// 				$retArr[$key]['barrier'] = num($barrier);
	// 				if (!empty($profit_date)) {
	// 					$profit_time_ago = $this->time_elapsed_string_min($profit_date, $key); //0
	// 					$retArr[$key]['proft_test_ago'] = $profit_time_ago;
	// 					$retArr[$key]['profit_time'] = $this->time_elapsed_string($profit_date, $key);
	// 					$retArr[$key]['profit_percentage'] = $profit;
	// 					$retArr[$key]['profit_date'] = $profit_date;
	// 				}
	// 				if (!empty($loss_date)) {
	// 					$los_time_ago = $this->time_elapsed_string_min($loss_date, $key);
	// 					$retArr[$key]['los_test_ago'] = $los_time_ago;
	// 					$retArr[$key]['loss_time'] = $this->time_elapsed_string($loss_date, $key);
	// 					$retArr[$key]['loss_percentage'] = $loss;
	// 					$retArr[$key]['loss_date'] = $loss_date;
	// 				}

	// 				// if (!empty($profit_time_ago) && !empty($los_time_ago)) {

	// 				//     if (($profit_time_ago > $los_time_ago)) {
	// 				//         $retArr[$key]['message'] = "Got Loss";
	// 				//     } else if (($profit_time_ago < $los_time_ago)) {
	// 				//         $retArr[$key]['message'] = "Got Profit";
	// 				//     } else {
	// 				//         continue;
	// 				//     }
	// 				// }

	// 				if ($los_time_ago == '' && $profit_time_ago == '') {
	// 					$retArr[$key]['message'] = '';
	// 				}
	// 				if ($los_time_ago != '' && $profit_time_ago == '') {
	// 					$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
	// 					$negitive++;
	// 					$losp += $retArr[$key]['loss_percentage'];
	// 				}
	// 				if ($los_time_ago == '' && $profit_time_ago != '') {
	// 					$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
	// 					$positive++;
	// 					$winp += $retArr[$key]['profit_percentage'];
	// 				}
	// 				if ($los_time_ago != '' && $profit_time_ago != '') {
	// 					if (($profit_time_ago > $los_time_ago)) {
	// 						$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
	// 						$negitive++;
	// 						$losp += $retArr[$key]['loss_percentage'];
	// 					} else if (($profit_time_ago < $los_time_ago)) {
	// 						$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
	// 						$positive++;
	// 						$winp += $retArr[$key]['profit_percentage'];
	// 					} else {
	// 						continue;
	// 					}
	// 				}
	// 			}
	// 		}
	// 		$winning_profit = $winp;
	// 		$losing_profit = $losp;

	// 		$total_profit = $winning_profit + $losing_profit;

	// 		$total_per_trade = $total_profit / (count($date_range_hour));

	// 		$total_per_day = $total_profit / $total_days;

	// 		$data['winners'] = $winning_profit;
	// 		$data['losers'] = $losing_profit;
	// 		$data['total_profit'] = $total_profit;
	// 		$data['per_trade'] = number_format($total_per_trade, 2);
	// 		$data['per_day'] = number_format($total_per_day, 2);

	// 		$data['final'] = $retArr;
	// 		$data['count_msg'] = count($date_range_hour);
	// 		$data['positive_msg'] = $positive;
	// 		$data['negitive_msg'] = $negitive;
	// 		$data['positive_percentage'] = number_format(($positive / ($positive + $negitive) * 100), 2);
	// 		$data['negitive_percentage'] = number_format(($negitive / ($positive + $negitive) * 100), 2);
	// 		$log_data = array(
	// 			'settings' => $data_arr,
	// 			'symbol' => $symbol,
	// 			'winning' => $positive,
	// 			'losing' => $negitive,
	// 			'win_per' => ($positive / ($positive + $negitive) * 100),
	// 			'lose_per' => ($negitive / ($positive + $negitive) * 100),
	// 			'total' => count($date_range_hour),
	// 			'result' => $retArr,
	// 			'created_date' => $this->mongo_db->converToMongodttime($start_date),
	// 			'end_date' => $this->mongo_db->converToMongodttime($end_date),
	// 		);

	// 		$log_data['winners'] = $winning_profit;
	// 		$log_data['losers'] = $losing_profit;
	// 		$log_data['total_profit'] = $total_profit;
	// 		$log_data['per_trade'] = $total_per_trade;
	// 		$log_data['per_day'] = $total_per_day;

	// 		$this->mongo_db->insert("percentile_report_log", $log_data);

	// 		return $data;
	// 	}
	// } //meta_coin_report_test()

	// public function check_real_oppurtunity($market_value, $market_time, $deep_price_check, $deep_price_lookup_in_hours, $symbol, $opp_chk)
	// {
	// 	if ($opp_chk) {
	// 		$iniatial_trail_stop = $market_value - ($market_value / 100) * $deep_price_check;
	// 		$where['coin'] = $symbol;
	// 		$where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
	// 		$where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $deep_price_lookup_in_hours . " hours", strtotime($market_time))));
	// 		$where['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

	// 		$queryHours = [
	// 			['$match' => $where],
	// 			['$sort' => ['modified_date' => 1]],
	// 			['$limit' => 1],
	// 		];

	// 		$db = $this->mongo_db->customQuery();
	// 		$response = $db->coin_meta_history->aggregate($queryHours);
	// 		$row = iterator_to_array($response);

	// 		if (count($row) > 0) {
	// 			return true;
	// 		} else {
	// 			return false;
	// 		}
	// 	}
	// }

	// public function trigger_report_listing()
	// {
	// 	$this->mod_login->verify_is_admin_login();
	// 	if (isset($_GET['trigger']) && $_GET['trigger'] == 'barrier') {
	// 		$this->mongo_db->where(array("trigger" => 'barrier'));
	// 	} elseif (isset($_GET['trigger']) && $_GET['trigger'] == 'percentile') {
	// 		$this->mongo_db->where(array("trigger" => 'percentile'));
	// 	} else {
	// 		$this->mongo_db->where(array("status" => 1));
	// 	}

	// 	$this->mongo_db->order_by(array('_id' => -1));
	// 	$get = $this->mongo_db->get("report_setting_collection");
	// 	$iter = iterator_to_array($get);
	// 	$data['setting'] = $iter;
	// 	$this->stencil->paint('admin/reports/setting', $data);
	// }

	// public function settings_report_listing()
	// {
	// 	$this->mod_login->verify_is_admin_login();
	// 	if (isset($_GET['trigger']) && $_GET['trigger'] == 'barrier') {
	// 		$this->mongo_db->where(array("settings.trigger" => 'barrier'));
	// 	} elseif (isset($_GET['trigger']) && $_GET['trigger'] == 'percentile') {
	// 		$this->mongo_db->where(array("settings.trigger" => 'percentile'));
	// 	}
	// 	$this->mongo_db->order_by(array('_id' => -1));
	// 	$this->mongo_db->limit(50);
	// 	$get = $this->mongo_db->get("meta_coin_report_results");
	// 	$iter = iterator_to_array($get);
	// 	$data['setting'] = $iter;
	// 	$this->stencil->paint('admin/reports/setting_report', $data);
	// }

	// public function get_report_from_setting($setting_id)
	// {
	// 	$this->mongo_db->where(array('setting_id' => $this->mongo_db->mongoId($setting_id)));
	// 	$get = $this->mongo_db->get("meta_coin_report_results");
	// 	$iter = iterator_to_array($get);

	// 	$data['final'] = $iter[0]['result'];
	// 	$this->stencil->paint("admin/reports/new_report", $data);
	// }
	// public function delete_setting($value = '')
	// {
	// 	$this->mongo_db->where(array("setting_id" => $this->mongo_db->mongoId($value)));
	// 	$this->mongo_db->delete("meta_coin_report_results");

	// 	$this->mongo_db->where(array("_id" => $this->mongo_db->mongoId($value)));
	// 	$this->mongo_db->delete("report_setting_collection");

	// 	redirect($_SERVER['HTTP_REFERER']);
	// }

	// public function rest_filters_meta()
	// {

	// 	$value = $this->input->post('value');

	// 	$trigger = $this->input->post('trigger');

	// 	$this->mongo_db->where(array("_id" => $this->mongo_db->mongoId($value), 'trigger' => $trigger));
	// 	$rest = $this->mongo_db->get("report_setting_collection");

	// 	$arr = iterator_to_array($rest);
	// 	//$arr[0] = ['test1' => "test1", 'test2' => "tes2t", 'test3' => "tes3t"];
	// 	echo json_encode($arr[0]);
	// 	exit;
	// }

	// public function myrun()
	// {
	// 	$key = '2019-03-19 17:00:00';
	// 	$symbol = "ZENBTC";
	// 	$target_profit = 1;
	// 	$target_stoploss = 2.5;
	// 	$value['market_value'] = '0.00167';
	// 	$value['market_time'] = '2019-03-19 17:11:00';
	// 	$data_arr['lookup_period'] = 2000;
	// 	$profit_time_ago = '';
	// 	$los_time_ago = '';
	// 	$loss = 0;
	// 	$profit = 0;

	// 	$market_value = $value['market_value'];
	// 	$market_time = $value['market_time'];
	// 	$barrier = $value['barrier_value'];
	// 	echo $sell_price = $value['market_value'] + ($value['market_value'] * $target_profit) / 100;
	// 	echo "<br>";
	// 	echo $iniatial_trail_stop = $value['market_value'] - ($value['market_value'] / 100) * $target_stoploss;
	// 	$where['coin'] = $symbol;
	// 	$where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
	// 	$where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));
	// 	$where['current_market_value']['$gte'] = (float) $sell_price;

	// 	$queryHours = [
	// 		['$match' => $where],
	// 		['$sort' => ['modified_date' => 1]],
	// 		['$limit' => 1],
	// 	];

	// 	$db = $this->mongo_db->customQuery();
	// 	$response = $db->coin_meta_history->aggregate($queryHours);
	// 	$row = iterator_to_array($response);
	// 	$profit = 0;
	// 	$profit_date = "";
	// 	if (!empty($row)) {
	// 		$percentage = (($row[0]['current_market_value'] - $value['market_value']) / $row[0]['current_market_value']) * 100;
	// 		$profit = number_format($percentage, 2);
	// 		$profit_date = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 	}

	// 	$where1['coin'] = $symbol;
	// 	$where1['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
	// 	$where1['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));

	// 	$where1['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

	// 	$queryHours1 =
	// 		[
	// 			['$match' => $where1],
	// 			['$sort' => ['modified_date' => 1]],
	// 			['$limit' => 1],
	// 		];
	// 	$db = $this->mongo_db->customQuery();
	// 	$response1 = $db->coin_meta_history->aggregate($queryHours1);
	// 	$row1 = iterator_to_array($response1);
	// 	$loss = 0;
	// 	$loss_date = 0;
	// 	if (!empty($row1)) {
	// 		$percentage = (($row1[0]['current_market_value'] - $value['market_value']) / $row1[0]['current_market_value']) * 100;
	// 		$loss = number_format($percentage, 2);
	// 		$loss_date = $row1[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 	}

	// 	$retArr[$key]['market_value'] = num($market_value);
	// 	$retArr[$key]['market_time'] = $market_time;
	// 	$retArr[$key]['barrier'] = $barrier;
	// 	if (!empty($profit_date)) {
	// 		$profit_time_ago = $this->time_elapsed_string_min($profit_date, $key); //0
	// 		$retArr[$key]['proft_test_ago'] = $profit_time_ago;
	// 		$retArr[$key]['profit_time'] = $this->time_elapsed_string($profit_date, $key);
	// 		$retArr[$key]['profit_percentage'] = $profit;
	// 		$retArr[$key]['profit_date'] = $profit_date;
	// 	}
	// 	if (!empty($loss_date)) {
	// 		$los_time_ago = $this->time_elapsed_string_min($loss_date, $key);
	// 		$retArr[$key]['los_test_ago'] = $los_time_ago;
	// 		$retArr[$key]['loss_time'] = $this->time_elapsed_string($loss_date, $key);
	// 		$retArr[$key]['loss_percentage'] = $loss;
	// 		$retArr[$key]['loss_date'] = $loss_date;
	// 	}

	// 	if ($los_time_ago == '' && $profit_time_ago == '') {
	// 		$retArr[$key]['message'] = '';
	// 	}
	// 	if ($los_time_ago != '' && $profit_time_ago == '') {
	// 		$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
	// 		$negitive++;
	// 		$losp += $retArr[$key]['loss_percentage'];
	// 	}
	// 	if ($los_time_ago == '' && $profit_time_ago != '') {
	// 		$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
	// 		$positive++;
	// 		$winp += $retArr[$key]['profit_percentage'];
	// 	}
	// 	if ($los_time_ago != '' && $profit_time_ago != '') {
	// 		if (($profit_time_ago > $los_time_ago)) {
	// 			$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
	// 			$negitive++;
	// 			$losp += $retArr[$key]['loss_percentage'];
	// 		} else if (($profit_time_ago < $los_time_ago)) {
	// 			$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
	// 			$positive++;
	// 			$winp += $retArr[$key]['profit_percentage'];
	// 		} else {
	// 		}
	// 	}
	// }

	// public function rule_trigger_value()
	// {
	// 	if ($this->input->post()) {
	// 		// ini_set("display_errors", E_ALL);
	// 		// error_reporting(E_ALL);
	// 		$data_arr['filter_order_data'] = $this->input->post();
	// 		$this->session->set_userdata($data_arr);

	// 		$start_date = $this->input->post('filter_by_start_date');
	// 		$end_date = $this->input->post('filter_by_end_date');
	// 		$symbol = $this->input->post('filter_by_coin');
	// 		$trigger = $this->input->post('filter_by_trigger');

	// 		$search_arr['symbol'] = $symbol;
	// 		$search_arr['trigger_type'] = $trigger;
	// 		$search_arr['order_mode'] = 'test_live';
	// 		$search_arr['created_date']['$gte'] = $this->mongo_db->converToMongodttime($start_date);
	// 		$search_arr['created_date']['$lte'] = $this->mongo_db->converToMongodttime($end_date);

	// 		// $this->mongo_db->where($search_arr);
	// 		// $this->mongo_db->limit(500);
	// 		// $iterator = $this->mongo_db->get("sold_buy_orders");

	// 		$queryHours =
	// 			[
	// 				['$match' => $search_arr],
	// 				['$group' => ['_id' => [
	// 					'hour' => ['$hour' => '$created_date'],
	// 					'minute' => ['$minute' => '$created_date'],
	// 				], 'application_mode' => ['$last' => '$application_mode'], 'created_date' => ['$last' => '$created_date'], 'trigger_type' => ['$last' => '$trigger_type'], 'buy_rule_number' => ['$last' => '$buy_rule_number'], 'order_level' => ['$last' => '$order_level'], 'symbol' => ['$last' => '$symbol'], 'id' => ['$last' => '$_id']]],
	// 				['$sort' => ['created_date' => -1]],
	// 			];

	// 		$db = $this->mongo_db->customQuery();
	// 		$response = $db->sold_buy_orders->aggregate($queryHours);

	// 		$test_arr = iterator_to_array($response);
	// 		$retArr = array();
	// 		foreach ($test_arr as $key => $value) {
	// 			$srch_arr['symbol'] = $symbol;
	// 			$srch_arr['order_mode'] = 'live';
	// 			$st_date = $value['created_date']->toDatetime()->format("Y-m-d H:i:s");
	// 			$e_date = date("Y-m-d H:i:s", strtotime("+5 minute", strtotime($st_date)));
	// 			$srch_arr['created_date']['$gte'] = $this->mongo_db->converToMongodttime($st_date);
	// 			$srch_arr['created_date']['$lte'] = $this->mongo_db->converToMongodttime($e_date);
	// 			$srch_arr['trigger_type'] = $value['trigger_type'];

	// 			if ($value['trigger_type'] == 'barrier_trigger') {
	// 				$srch_arr['buy_rule_number'] = $value['buy_rule_number'];
	// 			} else if ($value['trigger_type'] == 'barrier_percentile_trigger') {
	// 				$srch_arr['order_level'] = $value['order_level'];
	// 			}

	// 			$this->mongo_db->where($srch_arr);
	// 			$iterator1 = $this->mongo_db->get("sold_buy_orders");

	// 			$live_arr = iterator_to_array($iterator1);

	// 			$print_arr['created_date'] = $st_date;
	// 			$print_arr['trigger_type'] = $value['trigger_type'];
	// 			if ($trigger == 'barrier_trigger') {
	// 				$print_arr['buy_rule_number'] = $value['buy_rule_number'];
	// 			} else {
	// 				$print_arr['buy_rule_number'] = $value['order_level'];
	// 			}
	// 			$print_arr['test_exist'] = "YES";
	// 			$print_arr['test_example'] = (string) $value['id'];
	// 			if (count($live_arr) > 0) {
	// 				$print_arr['live_exist'] = "YES";
	// 				$print_arr['live_example'] = (string) $live_arr[0]['_id'];
	// 			} else {
	// 				$print_arr['live_exist'] = "NO";
	// 				$print_arr['live_example'] = "";
	// 			}
	// 			$retArr[] = $print_arr;
	// 		}
	// 		$data['final'] = $retArr;
	// 	}

	// 	$coins = $this->mod_coins->get_all_coins();
	// 	$data['coins'] = $coins;

	// 	$this->stencil->paint('admin/reports/rule_trigger_value', $data);
	// }

	// public function percentile_hh_ll_avg($symbol)
	// {

	// 	$wherre['coin'] = $symbol;
	// 	$this->mongo_db->where($wherre);
	// 	$this->mongo_db->limit(10);
	// 	$this->mongo_db->order_by(array('_id' => -1));
	// 	$get = $this->mongo_db->get('coin_meta_hourly_percentile_candle_history');
	// 	$rest = (iterator_to_array($get));

	// 	$one_rec = $rest[0];
	// 	$avg_arr = array();
	// 	foreach ($one_rec as $key => $value) {
	// 		$avg = 0;
	// 		$col = '';
	// 		$sum = 0;
	// 		$count = 0;
	// 		if ($key != 'coin' || $key != 'modified_time' || $key != 'hh_time' || $key != 'll_time') {
	// 			$col = array_column($rest, $key);
	// 			$sum = array_sum($col);
	// 			$count = count($col);
	// 			$avg = $sum / $count;

	// 			$avg_arr[$key] = $avg;
	// 		}
	// 	}

	// 	echo "<pre>";
	// 	print_r($avg_arr);
	// 	exit;
	// }

	// public function test()
	// {
	// 	$search_arr['parent_status'] = 'parent';
	// 	$search_arr['admin_comment'] = 'Removing uncertainity to update profit';
	// 	$current_date = date("Y-m-d H:i:s");
	// 	$this->mongo_db->where($search_arr);
	// 	$get = $this->mongo_db->get("buy_orders");
	// 	echo "<pre>";
	// 	print_r(iterator_to_array($get));
	// 	exit;
	// 	foreach ($get as $key => $value) {
	// 		$admin_id = $value['admin_id'];
	// 		$per = $value['defined_sell_percentage'];
	// 		$id = $value['_id'];

	// 		$upd_arr['defined_sell_percentage'] = '1';
	// 		$upd_arr['admin_comment'] = 'Removing uncertainity to update profit';

	// 		$this->mongo_db->where(array('_id' => $id));
	// 		$this->mongo_db->set($upd_arr);
	// 		$this->mongo_db->update("buy_orders");

	// 		$log_msg = "Desired Percentage has been changed to 0% to 1% Programatically to avoid uncertainity";

	// 		$this->mod_buy_orders->insert_order_history_log($id, $log_msg, 'order_update', $admin_id, $current_date);
	// 	}
	// }

	////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////
	public function csv_export_oppertunity(){
		$coin_array_all = $this->mod_coins->get_all_coins();
		
		$previous_5_day_time = date('Y-m-d H:i:s', strtotime('-30 days'));
		$starting_date =  $this->mongo_db->converToMongodttime($previous_5_day_time);
			
		$coin_array = array_column($coin_array_all, 'symbol');
		$where['coin']['$in'] =  $coin_array;
		$where['level'] = array('$ne'=>'level_15');
		$where['created_date'] = array('$gte'=>$starting_date);
		
		$this->mongo_db->sort(array('created_date' => -1));
		$this->mongo_db->where($where);
		$object_return = $this->mongo_db->get('opportunity_logs_binance');
		$log_arry = iterator_to_array($object_return);

		$this->download_send_headers("oppertunity_report". date("Y-m-d_ Gisa") . ".csv");
		echo $this->array2csv($log_arry);
	}
	
	public function oppertunity_reports(){
		$this->mod_login->verify_is_admin_login();
		$db =  $this->mongo_db->customQuery();
		
		$coin_array_all = $this->mod_coins->get_all_coins();
		if ($this->input->post()){
			$data_arr['filter_order_data'] = $this->input->post();
			$this->session->set_userdata($data_arr);
			$coin_array = array();

			if(!empty($this->input->post('coinPair')) && $this->input->post('coinPair')!= 'both'){
				if($this->input->post('coinPair') == "btc"){
					$coin_array  = ['XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC'];
				}else{
					$coin_array = ['EOSUSDT', 'LTCUSDT','XRPUSDT','NEOUSDT', 'QTUMUSDT','BTCUSDT'];
				}
			}elseif (!empty($this->input->post('filter_by_coin'))) {
				$coin_array = $this->input->post('filter_by_coin');
			} else {
				$coin_array = array_column($coin_array_all, 'symbol');
			}
			

			if ($this->input->post('filter_by_mode')) {
				$search['mode'] = $this->input->post('filter_by_mode');
			}
			if ($this->input->post('filter_by_trigger') != "") {
				$filter_by_trigger = $this->input->post('filter_by_trigger');
			} else {
				$filter_by_trigger = array('barrier_percentile_trigger', 'barrier_trigger', 'no');
			}

			if ($this->input->post('filter_by_level') != "" && $filter_by_trigger == 'barrier_percentile_trigger') {
				$filter_by_level = $this->input->post('filter_by_level');
				$search['level']['$in'] = $filter_by_level;
			} else {
				$search['level']['$in'] = array('level_5', 'level_6', 'level_8', 'level_10', 'level_11', 'level_12', 'level_13', 'level_17', 'level_18');
			}
			if ($this->input->post('filter_by_rule') != "" && $filter_by_trigger == 'barrier_trigger') {
				$filter_by_rule = $this->input->post('filter_by_rule');
				
			} else {
			}
			if ($_POST['oppertunity_Id'] != "") {
				$filter_by_oppertunity_id		= $this->input->post('oppertunity_Id');
				$search['opportunity_id'] =  $filter_by_oppertunity_id;
			}
			
			if ($_POST['oppertunity_Id'] != "") {
				$filter_by_oppertunity_id		= $this->input->post('oppertunity_Id');
				$search['opportunity_id'] =  $filter_by_oppertunity_id;
			}
			$exchange = (!empty($_POST['exchange']))? $this->input->post('exchange'): 'binance';
			
			$collection = ($this->input->post('filter_by_mode') == 'live') ? "opportunity_logs_".$exchange : "opportunity_logs_test_".$exchange;

			if ($_POST['filter_by_start_date'] != "" &&  $_POST['filter_by_end_date'] != ""){

				$dayssss=((strtotime($_POST['filter_by_end_date'])-strtotime($_POST['filter_by_start_date']))/3600)/24;
				// echo "\r\n days".$dayssss;

				$time = '7:49:00';
				$newtime =  date('H:i:s', strtotime($time));
				

				for($i = 0; $i < $dayssss ; $i++){

					$startingTime      =  date('Y-m-d',   strtotime($_POST['filter_by_start_date'] . + $i .'days'));
					$combine123 = date($startingTime .' H:i:s',     strtotime($newtime));
					$starting = date('Y-m-d H:i:s', strtotime($combine123));
								
				  
					$endTime      =  date('Y-m-d',   strtotime($startingTime . + 1 .'days'));
					$combineEnd = date($endTime .' H:i:s',     strtotime($newtime));
					$end = date('Y-m-d H:i:s', strtotime($combineEnd));

					$getCountTradeTime   = date('Y-m-d', strtotime($starting. '+1 days'));
					// expected_trade_buy_count_history
					$getTradeNumberCount = [
						'exchange'  	=>  $exchange,
						'created_date'	=>  $this->mongo_db->converToMongodttime($getCountTradeTime)
					];

					$getTradeCount 		= 	$db->expected_trade_buy_count_history->find($getTradeNumberCount);
					$countResponse[]	= 	iterator_to_array($getTradeCount);


					$search['coin']['$in'] = $coin_array;
					$starting_date =  $this->mongo_db->converToMongodttime($starting);
					$ending_date =  $this->mongo_db->converToMongodttime($end);

					
					$search['created_date'] = array('$gte'=>$starting_date, '$lte'=> $ending_date);
					$this->mongo_db->sort(array('created_date' => -1));
					$this->mongo_db->where($search);
					$object_return = $this->mongo_db->get($collection);
					$log_arry[] = iterator_to_array($object_return);


					//get trade count
					$countTradeLookupBTC = [
						[
							'$match' =>[ 
								'coin'			=> 	['$in' 	=>  ['XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC']],
								'level' 		=> 	['$in' 	=> 	['level_5', 'level_6', 'level_8', 'level_10', 'level_11', 'level_12', 'level_13', 'level_17', 'level_18']],  
								'created_date' 	=> 	['$gte'	=>	$starting_date, '$lte'=> $ending_date]
							]
						],
						[
							'$group' => [
								'_id' => 1, 
								'sold_orders' 		=> 	['$sum' => '$sold'],
								'open_lth_orders' 	=> 	['$sum' => '$open_lth'],
								'otherStatus'    	=>	['$sum' => '$other_status']
							]
						],
						[
							'$sort' => ['created_date' => -1]
						]	
					];
	
					$countTradeLookupUSDT = [
						[
							'$match' =>[ 
								'coin'			=> 	['$in' 	=>  ['EOSUSDT', 'LTCUSDT','XRPUSDT','NEOUSDT', 'QTUMUSDT','BTCUSDT']],
								'level' 		=> 	['$in' 	=> 	['level_5', 'level_6', 'level_8', 'level_10', 'level_11', 'level_12', 'level_13', 'level_17', 'level_18']],  
								'created_date' 	=> 	['$gte'	=>	$starting_date, '$lte'=> $ending_date]
							]
						],
	
						[
							'$group' => [
								'_id' => 1, 
								'sold_orders' 		=> 	['$sum' => '$sold'],
								'open_lth_orders' 	=> 	['$sum' => '$open_lth'],
								'otherStatus'    	=>	['$sum' => '$other_status']
							]
						],
						[
							'$sort' => ['created_date' => -1]
						]	
					];
	
					$getCountTradesBTC   = $db->$collection->aggregate($countTradeLookupBTC);
					$getCountTradesBTC1[] = iterator_to_array($getCountTradesBTC);
	
					$getCountTradesUSDT   = $db->$collection->aggregate($countTradeLookupUSDT);
					$getCountTradesUSDT1[] = iterator_to_array($getCountTradesUSDT);
					// $days++;
				}
				
				$data['final_array'] 			= 		$log_arry;
				$data['expectedTrades'] 		= 		$countResponse;
				$data['tradeCountDaily']    	=     	$getCountTradesBTC1;
				$data['tradeCountDailyUSDT']  	= 		$getCountTradesUSDT1;

			}else{

				for($i = 0; $i < 11 ; $i++){
					$days = 10 -$i;
					$startTime = date('Y-m-d 07:59', strtotime(- $days.'days'));
					$endTime   = date('Y-m-d 07:59', strtotime($startTime. '+1 days'));


					$getCountTradeTime   = date('Y-m-d', strtotime($startTime. '+1 days'));
					// expected_trade_buy_count_history
					$getTradeNumberCount = [
						'exchange'  	=>  $exchange,
						'created_date'	=>  $this->mongo_db->converToMongodttime($getCountTradeTime)
					];

					$getTradeCount 		= 	$db->expected_trade_buy_count_history->find($getTradeNumberCount);
					$countResponse[]	= 	iterator_to_array($getTradeCount);


					$starting_date =  $this->mongo_db->converToMongodttime($startTime);
					$ending_date =  $this->mongo_db->converToMongodttime($endTime);

					$search['coin']['$in'] = $coin_array;
					$search['created_date'] = array('$gte'=>$starting_date, '$lte'=> $ending_date);
					$this->mongo_db->sort(array('created_date' => -1));
					$this->mongo_db->where($search);
					$object_return = $this->mongo_db->get($collection);
					$log_arry[] = iterator_to_array($object_return);


					$countTradeLookupBTC = [
						[
							'$match' =>[ 
								'coin'			=> 	['$in' 	=>  ['XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC']],
								'level' 		=> 	['$in' 	=> 	['level_5', 'level_6', 'level_8', 'level_10', 'level_11', 'level_12', 'level_13', 'level_17', 'level_18']],  
								'created_date' 	=> 	['$gte'	=>	$starting_date, '$lte'=> $ending_date]
							]
						],
						[
							'$group' => [
								'_id' => 1, 
								'sold_orders' 		=> 	['$sum' => '$sold'],
								'open_lth_orders' 	=> 	['$sum' => '$open_lth'],
								'otherStatus'    	=>	['$sum' => '$other_status']
							]
						],
						[
							'$sort' => ['created_date' => -1]
						]	
					];
	
					$countTradeLookupUSDT = [
						[
							'$match' =>[ 
								'coin'			=> 	['$in' 	=>  ['EOSUSDT', 'LTCUSDT','XRPUSDT','NEOUSDT', 'QTUMUSDT','BTCUSDT']],
								'level' 		=> 	['$in' 	=> 	['level_5', 'level_6', 'level_8', 'level_10', 'level_11', 'level_12', 'level_13', 'level_17', 'level_18']],  
								'created_date' 	=> 	['$gte'	=>	$starting_date, '$lte'=> $ending_date]
							]
						],
	
						[
							'$group' => [
								'_id' => 1, 
								'sold_orders' 		=> 	['$sum' => '$sold'],
								'open_lth_orders' 	=> 	['$sum' => '$open_lth'],
								'otherStatus'    	=>	['$sum' => '$other_status']
							]
						],
						[
							'$sort' => ['created_date' => -1]
						]	
					];
	
					$getCountTradesBTC   = $db->$collection->aggregate($countTradeLookupBTC);
					$getCountTradesBTC1[] = iterator_to_array($getCountTradesBTC);
	
					$getCountTradesUSDT   = $db->$collection->aggregate($countTradeLookupUSDT);
					$getCountTradesUSDT1[] = iterator_to_array($getCountTradesUSDT);
	
				}
			}
			$data['tradeCountDaily']    	=     	$getCountTradesBTC1;
			$data['tradeCountDailyUSDT']  	= 		$getCountTradesUSDT1;
			$data['final_array'] 			= 		$log_arry;
			$data['expectedTrades'] 		= 		$countResponse;
		}
		////////////////////////////////////////////////////////////////////////////
		else{
			$coin_array = array_column($coin_array_all, 'symbol');
			$this->session->unset_userdata('filter_order_data');

			
			for($i = 0; $i < 11 ; $i++){
				$days = 10 -$i;
				$startTime = date('Y-m-d 07:59', strtotime(- $days.'days'));
				$endTime   = date('Y-m-d 07:59', strtotime($startTime. '+1 days'));
				$starting_date =  $this->mongo_db->converToMongodttime($startTime);
				$ending_date =  $this->mongo_db->converToMongodttime($endTime);


				$getCountTradeTime   = date('Y-m-d', strtotime($startTime. '+1 days'));
					// expected_trade_buy_count_history
				$getTradeNumberCount = [
					'exchange'  	=>  'kraken',
					'created_date'	=>  $this->mongo_db->converToMongodttime($getCountTradeTime)
				];

				$getTradeCount 		= 	$db->expected_trade_buy_count_history->find($getTradeNumberCount);
				$countResponse[]	= 	iterator_to_array($getTradeCount);


				$where['coin']['$in'] =  $coin_array;
				$where['level']['$in'] = array('level_5', 'level_6', 'level_8', 'level_10', 'level_11', 'level_12', 'level_13', 'level_17', 'level_18');  
				$where['created_date'] = array('$gte'=>$starting_date, '$lte'=> $ending_date);
				$this->mongo_db->sort(array('created_date' => -1));
				$this->mongo_db->where($where);
				$object_return = $this->mongo_db->get('opportunity_logs_kraken');
				$log_arry[] = iterator_to_array($object_return);

				//trade count today buy

				$countTradeLookupBTC = [
					[
						'$match' =>[ 
							'coin'			=> 	['$in' 	=>  ['XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC']],
							'level' 		=> 	['$in' 	=> 	['level_5', 'level_6', 'level_8', 'level_10', 'level_11', 'level_12', 'level_13', 'level_17', 'level_18']],  
							'created_date' 	=> 	['$gte'	=>	$starting_date, '$lte'=> $ending_date]
						]
					],
					[
						'$group' => [
							'_id' => 1, 
							'sold_orders' 		=> 	['$sum' => '$sold'],
							'open_lth_orders' 	=> 	['$sum' => '$open_lth'],
							'otherStatus'    	=>	['$sum' => '$other_status']
						]
					],
					[
						'$sort' => ['created_date' => -1]
					]	
				];

				$countTradeLookupUSDT = [
					[
						'$match' =>[ 
							'coin'			=> 	['$in' 	=>  ['EOSUSDT', 'LTCUSDT','XRPUSDT','NEOUSDT', 'QTUMUSDT','BTCUSDT']],
							'level' 		=> 	['$in' 	=> 	['level_5','level_6', 'level_8', 'level_10', 'level_11', 'level_12', 'level_13', 'level_17', 'level_18']],  
							'created_date' 	=> 	['$gte'	=>	$starting_date, '$lte'=> $ending_date]
						]
					],

					[
						'$group' => [
							'_id' => 1, 
							'sold_orders' 		=> 	['$sum' => '$sold'],
							'open_lth_orders' 	=> 	['$sum' => '$open_lth'],
							'otherStatus'    	=>	['$sum' => '$other_status']
						]
					],
					[
						'$sort' => ['created_date' => -1]
					]	
				];

				$getCountTradesBTC   = $db->opportunity_logs_kraken->aggregate($countTradeLookupBTC);
				$getCountTradesBTC1[] = iterator_to_array($getCountTradesBTC);

				$getCountTradesUSDT   = $db->opportunity_logs_kraken->aggregate($countTradeLookupUSDT);
				$getCountTradesUSDT1[] = iterator_to_array($getCountTradesUSDT);

			}
			$data['final_array'] 			= 		$log_arry;
			$data['expectedTrades'] 		= 		$countResponse;
			$data['tradeCountDaily']    	=     	$getCountTradesBTC1;
			$data['tradeCountDailyUSDT']  	= 		$getCountTradesUSDT1;
		}

		$symbol = array_column($coin_array_all, 'symbol');
		array_multisort($symbol, SORT_ASC, $coin_array_all);
		$data['coins'] = $coin_array_all;
		$this->stencil->paint('admin/trigger_rule_report/oppertunity_report', $data);
	}

	/////////////////////////////////////////////////////////////////////////////
	///////////////                ASIM CRONE BINANCE             ///////////////
	/////////////////////////////////////////////////////////////////////////////
	public function insert_latest_oppertunity_into_log_collection_binance(){
		$marketPrices = marketPrices('binance');
		$this->load->helper('new_common_helper');
		foreach($marketPrices as $price){
			if($price['_id'] == 'ETHBTC'){
				$ethbtc = (float)$price['price'];
			}elseif($price['_id'] == 'BTCUSDT'){
				$btcusdt = (float)$price['price'];
			}elseif($price['_id'] == 'XRPBTC'){
				$xrpbtc = (float)$price['price'];
			}elseif($price['_id'] == 'XRPUSDT'){
				$xrpusdt = (float)$price['price'];
			}elseif($price['_id'] == 'NEOBTC'){
				$neobtc = (float)$price['price'];
			}elseif($price['_id'] == 'NEOUSDT'){
				$neousdt = (float)$price['price'];
			}elseif($price['_id'] == 'QTUMBTC'){
				$qtumbtc = (float)$price['price'];
			}elseif($price['_id'] == 'QTUMUSDT'){
				$qtumusdt = (float)$price['price'];
			}elseif($price['_id'] == 'XLMBTC'){
				$xml = (float)$price['price'];
			}elseif($price['_id'] == 'XEMBTC'){
				$xem = (float)$price['price'];
			}elseif($price['_id'] == 'POEBTC'){
				$poe = (float)$price['price'];
			}elseif($price['_id'] == 'TRXBTC'){
				$trx = (float)$price['price'];
			}elseif($price['_id'] == 'ZENBTC'){
				$zen = (float)$price['price'];
			}elseif($price['_id'] == 'ETCBTC'){
				$etcbtc = (float)$price['price'];
			}elseif($price['_id'] =='EOSBTC'){
				$eosbtc = (float)$price['price'];
			}elseif($price['_id'] =='LINKBTC'){
				$linkbtc = (float)$price['price'];
			}elseif($price['_id'] =='DASHBTC'){
				$dashbtc = (float)$price['price'];
			}elseif($price['_id'] =='XMRBTC'){
				$xmrbtc = (float)$price['price'];
			}elseif($price['_id'] =='ADABTC'){
				$adabtc = (float)$price['price'];
			}elseif($price['_id'] =='LTCUSDT'){
				$ltcusdt = (float)$price['price'];
			}elseif($price['_id'] =='EOSUSDT'){
				$eosusdt = (float)$price['price'];
			}				
		}//end inner loop 
		$current_date_time =  date('Y-m-d H:i:s');
		$current_time_date =  $this->mongo_db->converToMongodttime($current_date_time);

		$current_hour =  date('Y-m-d H:i:s', strtotime('-40 minutes'));
		$orig_date1 = $this->mongo_db->converToMongodttime($current_hour);

		$previous_one_month_date_time = date('Y-m-d H:i:s', strtotime(' - 1 month'));
		$pre_date_1 =  $this->mongo_db->converToMongodttime($previous_one_month_date_time);

		$connection = $this->mongo_db->customQuery();      
		$condition = array('sort' => array('created_date' => -1), 'limit'=>3);
		 if(!empty($this->input->get())){
			$where['opportunity_id'] = $this->input->get('opportunityId');
		}else{
			$where['mode'] ='live';
			$where['created_date'] = array('$gte'=>$pre_date_1);
			$where['level'] = array('$ne'=>'level_15');
			$where['is_modified'] = array('$exists'=>false);
			$where['modified_date'] = array('$lte'=>$orig_date1);
		} 
                 
		$find_rec = $connection->opportunity_logs_binance->find($where,  $condition);
		$response = iterator_to_array($find_rec);
		foreach ($response as $value){
			$coin= $value['coin'];
			if(isset($value['sendHitTime']) && !empty($value['sendHitTime'])){
				$sendHitTime     	= strtotime($value['sendHitTime']->toDateTime()->format('Y-m-d H:i:s'));   

			}else{
				$sendHitTime     	= strtotime($value['created_date']->toDateTime()->format('Y-m-d H:i:s'));
			}
			$start_date = $value['created_date']->toDateTime()->format("Y-m-d H:i:s");
			$timestamp = strtotime($start_date);
			$time = $timestamp + (5 * 60 * 60);
			$end_date = date("Y-m-d H:i:s", $time);

			$hours_10 = $timestamp + (10 * 60 * 60);
			$time_10_hours = date("Y-m-d H:i:s", $hours_10);

			$cidition_check = $this->mongo_db->converToMongodttime($end_date);
			$cidition_check_10 = $this->mongo_db->converToMongodttime($time_10_hours);
			$params = [];
			$params = [   
				'coin'       => $value['coin'],
				'start_date' => (string)$start_date,
				'end_date'   => (string)$end_date,
			];	

			if($cidition_check <= $current_time_date){
				$jsondata = json_encode($params);
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS =>$jsondata,
					CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
				));
				$response_price = curl_exec($curl);	
				curl_close($curl);                                
				$api_response = json_decode($response_price);
				echo "<pre>";
				print_r($api_response);
			}// main if check for time comapire
			$params_10_hours = [];         
			$params_10_hours = [
				'coin'       => $value['coin'],
				'start_date' => (string)$start_date,
				'end_date'   => (string)$time_10_hours,
			];
			if($cidition_check_10 <= $current_time_date){
				$jsondata = json_encode($params_10_hours);
				$curl_10 = curl_init();
				curl_setopt_array($curl_10, array(
					CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS =>$jsondata,
					CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
				));
				$response_price_10 = curl_exec($curl_10);	
				curl_close($curl_10);
				$api_response_10 = json_decode($response_price_10);
				echo "<pre>";
				print_r($api_response_10);
			}
			if($value['level'] != 'level_15' ) {
				$open_lth_avg_per_trade = 0;
				$open_lth_avg = 0;
				$avg_sold = 0;
				$parents_executed = 0;
				$parents_executed = $value['parents_executed'];
				
				$search_update['opportunity_id'] = $value['opportunity_id'];
				$search_update['mode']= 'live';
				
				$other['application_mode']= 'live';
				$other['opportunityId'] =  $value['opportunity_id'];
				$other['status'] = array('$nin' => array('LTH', 'FILLED','canceled','new_ERROR'));

				$buyOther = $connection->buy_orders->count($other);
				/////////////////////////////////////////////////////////

				$search_open_lth['application_mode']		= 	'live';
				$search_open_lth['opportunityId'] 			= 	$value['opportunity_id'];
				$search_open_lth['status'] 					= 	array('$in' => array('LTH', 'FILLED'));
				$search_open_lth['is_sell_order']         	=   'yes';
				$search_open_lth['cavg_parent'] 			= 	['$exists' => false];
				$search_open_lth['cost_avg']				=	['$nin' => ['yes', 'completed', '']];


				print_r("<br>oppertunity_id=".$value['opportunity_id']);
				/////
				$search_cancel['application_mode']		= 	'live';
				$search_cancel['opportunityId'] 		= 	$value['opportunity_id'];
				$search_cancel['status'] 				= 	array('$in' => array('canceled'));
				$search_cancel['cavg_parent'] 			= 	['$exists' => false];
				$search_cancel['cost_avg']				=	['$nin' => ['yes', 'completed', '']];
				//////
				$search_new_error['application_mode']	= 'live';
				$search_new_error['opportunityId'] 		= $value['opportunity_id'];
				$search_new_error['status'] 			= array('$in' => array('new_ERROR'));
				$search_new_error['cavg_parent'] 		= 	['$exists' => false];
				$search_new_error['cost_avg']			=	['$nin' => ['yes', 'completed', '']];
				////////
				$search_sold['application_mode']	= 'live';
				$search_sold['opportunityId'] 		= $value['opportunity_id'];
				$search_sold['is_sell_order'] 		= 'sold';
				$search_sold['cavg_parent'] 	= 	['$exists' => false];
				$search_sold['cost_avg']		=	['$nin' => ['yes', 'completed', '']];
				// $search_sold['resume_status']['$ne'] = 'resume';
				// $search_sold['cost_avg']['$ne'] = 'yes';

				$otherSold['application_mode'] 	= 	'live';
				$otherSold['opportunityId'] 	=  	$value['opportunity_id'];
				$otherSold['is_sell_order'] 	= 	array('$nin' => array('sold'));
				$searchSold['cavg_parent'] 		= 	['$exists' => false];
				$searchSold['cost_avg']			=	['$nin' => ['yes', 'completed', '']];

				$otherStatusSold = $connection->sold_buy_orders->count($otherSold);
				$totalOther = $buyOther + $otherStatusSold;

				$minPriceLookUp = [
					[
						'$match' => [
							'application_mode' => 'live',
							'opportunityId'    =>  $value['opportunity_id'],
							'is_sell_order'    =>  'sold'
 						]
					],

					[
						'$group' =>[
							'_id' => '$symbol',
							'minPrice' => ['$min' => '$market_sold_price']
						]
					],

				];

				$minSoldPrice = $connection->sold_buy_orders->aggregate($minPriceLookUp);
				$soldMinPrice  = iterator_to_array($minSoldPrice);

				$maxPriceLookUp = [
					[
						'$match' => [
							'application_mode' => 'live',
							'opportunityId'    =>  $value['opportunity_id'],
							'is_sell_order'    =>  'sold'
 						]
					],

					[
						'$group' =>[
							'_id' => '$symbol',
							'maxPrice' => ['$max' => '$market_sold_price']
						]
					],

				];

				$maxSoldPrice = $connection->sold_buy_orders->aggregate($maxPriceLookUp);
				$soldMaxPrice  = iterator_to_array($maxSoldPrice);
				
				///////////////////////////////////////////////////////////////////
		
				$search_resumed['application_mode']	= 	'live';
				$search_resumed['opportunityId'] 	= 	$value['opportunity_id'];
				$search_resumed['resume_status'] 	= 	array('$in' => array('resume'));
				$search_resumed['cavg_parent'] 		= 	['$exists' => false];
				$search_resumed['cost_avg']			=	['$nin' => ['yes', 'completed', '']];
				
				/////////////////////////////////////////////////////////////// 
				$cosAvg['application_mode']	= 	'live';
				$cosAvg['opportunityId'] 	= 	$value['opportunity_id'];
				$cosAvg['cost_avg']['$ne'] 	= 	'completed';
				$cosAvg['is_sell_order']	= 	'yes';
				$cosAvg['cavg_parent'] 		= 	'yes';

				$cosAvgSold['application_mode']	= 'live';
				$cosAvgSold['opportunityId'] 	= $value['opportunity_id'];
				$cosAvgSold['is_sell_order'] 	= 'sold';
				$cosAvgSold['cost_avg'] 		= 'completed';
				$cosAvgSold['cavg_parent'] 		= 'yes';
				
				$costAvgReturn = $connection->buy_orders->count($cosAvg);
				$soldCostAvgReturn = $connection->sold_buy_orders->count($cosAvgSold);  
				/////////////////////////////////////////////////////////////// 

				$this->mongo_db->where($search_resumed);
				$total_resumed_sold = $this->mongo_db->get('sold_buy_orders');
				$total_reumed_sold   = iterator_to_array($total_resumed_sold);
				
				$this->mongo_db->where($search_resumed);
				$total_resumed = $this->mongo_db->get('buy_orders');
				$total_reumed   = iterator_to_array($total_resumed);

				$this->mongo_db->where($search_open_lth);
				$total_open = $this->mongo_db->get('buy_orders');
				$total_open_lth_rec   = iterator_to_array($total_open);

				$this->mongo_db->where($search_cancel);
				$total_cancel = $this->mongo_db->get('buy_orders');
				$total_cancel_rec   = iterator_to_array($total_cancel);

				///////////////////////////////////////////////////////////////////////////////

				$this->mongo_db->where($search_new_error);
				$total_new_error = $this->mongo_db->get('buy_orders');
				$total_new_error_rec   = iterator_to_array($total_new_error);

				// 	/////////////////////////////////////////////////////////////////////////////

				$this->mongo_db->where($search_sold);
				$total_sold_total = $this->mongo_db->get('sold_buy_orders');
				$total_sold_rec   = iterator_to_array($total_sold_total);
				
				// ////////////////////////////////////////////////CALCULATE LTH AND OPEN ORDERS AVG
				$open_lth_puchase_price = 0;
				$open_lth_avg = 0;
				$open_lth_avg_per_trade= 0;
				$btc = 0;
				$usdt = 0;

				$buySumTimeDelayRange1 = 0;
				$buySumTimeDelayRange2 = 0;
				$buySumTimeDelayRange3 = 0;
				$buySumTimeDelayRange4 = 0;
				$buySumTimeDelayRange5 = 0;
				$buySumTimeDelayRange6 = 0;
				$buySumTimeDelayRange7 = 0;
				$buy_commision_bnb = 0;    
				$buy_fee_respected_coin = 0;

				echo"<br>Total open lth = ".count($total_open_lth_rec);
				if (count($total_open_lth_rec) > 0){
					echo "<br> Open/lth Calculation";
					foreach ($total_open_lth_rec as $key => $value2) {
						$commission_array = $value2['buy_fraction_filled_order_arr'];
						if($value2['symbol'] == 'ETHBTC'){
							$open_lth_puchase_price += (float) ($ethbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'LINKBTC'){
							$open_lth_puchase_price += (float) ($linkbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							$btc +=(float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'DASHBTC'){
							$open_lth_puchase_price += (float) ($dashbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							$btc +=(float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XMRBTC'){
							$open_lth_puchase_price += (float) ($xmrbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							$btc +=(float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'ADABTC'){
							$open_lth_puchase_price += (float) ($adabtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							$btc +=(float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'LTCUSDT'){
							$open_lth_puchase_price += (float) ($ltcusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'BTCUSDT'){
							$open_lth_puchase_price += (float) ($btcusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XRPBTC'){
							$open_lth_puchase_price += (float) ($xrpbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XRPUSDT'){
							$open_lth_puchase_price += (float) ($xrpusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'NEOBTC'){
							$open_lth_puchase_price += (float) ($neobtc - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'NEOUSDT'){
							$open_lth_puchase_price += (float) ($neousdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'QTUMBTC'){
							$open_lth_puchase_price += (float) ($qtumbtc - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'QTUMUSDT'){
							$open_lth_puchase_price += (float) ($qtumusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XLMBTC'){
							$open_lth_puchase_price += (float) ($xml - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XEMBTC'){
							$open_lth_puchase_price += (float) ($xem - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'POEBTC'){
							$open_lth_puchase_price += (float) ($poe - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'TRXBTC'){
							$open_lth_puchase_price += (float) ($trx - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'ZENBTC'){
							$open_lth_puchase_price += (float) ($zen - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'ETCBTC'){
							$open_lth_puchase_price += (float) ($etcbtc - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'EOSBTC'){
							$open_lth_puchase_price += (float) ($eosbtc - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'EOSUSDT'){
							$open_lth_puchase_price += (float) ($eosusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}		
						echo "<br>open_lth_puchase_price +=";
						print_r($open_lth_puchase_price);
						echo "<br> order_id = ".$value2['_id'];

						if( isset($value2['created_date']) && !empty($value2['created_date']) ){

							$orderBUyTime  		= strtotime($value2['created_date']->toDateTime()->format('Y-m-d H:i:s'));

							$differenceBuyInSec = ($orderBUyTime - $sendHitTime);
						}else{
							$differenceBuyInSec = 0;
						}

						if($differenceBuyInSec < 0){
							$differenceBuyInSec = 0;
						}
						if($differenceBuyInSec >= 0 && $differenceBuyInSec < 15 ){
                          	$buySumTimeDelayRange1++; 
						}elseif($differenceBuyInSec >= 15 && $differenceBuyInSec < 30){
							$buySumTimeDelayRange2++;
						}elseif($differenceBuyInSec >= 30 && $differenceBuyInSec < 45){
							$buySumTimeDelayRange3++;
						}elseif($differenceBuyInSec >= 45 && $differenceBuyInSec < 60){
							$buySumTimeDelayRange4++;
						}elseif($differenceBuyInSec >= 60 && $differenceBuyInSec < 75){
							$buySumTimeDelayRange5++;
						}elseif($differenceBuyInSec >= 75 && $differenceBuyInSec < 90 ){
							$buySumTimeDelayRange6++;
						}elseif($differenceBuyInSec >= 90){
							$buySumTimeDelayRange7++;
						}
					}//end loop
					$open_lth_avg_per_trade = (float) $open_lth_puchase_price * 100;
					$open_lth_avg = (float) ($open_lth_avg_per_trade / count($total_open_lth_rec));
				
					echo "<br>avg_sold = ";
					print_r($open_lth_avg);
				}//end if
				// /////////////////////////////////////////////////////////////////END OPEN LTH AVG
			
				// ////////////////////////////////////////////////////////////////CALCULATE SOLD AVG
				$sold_puchase_price = 0;
				$sell_fee_respected_coin = 0;
				$avg_sold_CSL = 0;
				$CSL_per_trade_sold = 0;
				$CSL_sold_purchase_price = 0 ;
				$avg_manul = 0;
				$per_trade_sold_manul = 0;
				$manul_sold_purchase_price = 0;
				$avg_sold = 0;
				$per_trade_sold = 0;
				// $sold_profit_btc = 0;
				$sumTimeDelayRange1 = 0;
				$sumTimeDelayRange2 = 0;
				$sumTimeDelayRange3 = 0;
				$sumTimeDelayRange4 = 0;
				$sumTimeDelayRange5 = 0;
				$sumTimeDelayRange6 = 0;
				$sumTimeDelayRange7 = 0;

				$sumPLSllipageRange1 = 0;
				$sumPLSllipageRange2 = 0;
				$sumPLSllipageRange3 = 0;
				$sumPLSllipageRange4 = 0;
				$sumPLSllipageRange5 = 0;
				// $sold_profit_usdt = 0;
				$btc_sell  = 0;
				$usdt_sell = 0;
				$sell_comssion_bnb = 0;
			
				if(count($total_sold_rec) > 0){
					echo "<br> sold calculation";
					foreach ($total_sold_rec as $key => $value1) {
						$commission_sold_array = $value1['buy_fraction_filled_order_arr'];
						$sell_commission_sold_array = $value1['sell_fraction_filled_order_arr'];
						if($value1['symbol'] == 'ETHBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}
						}elseif($value1['symbol'] == 'XRPBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'NEOBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);
							
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'QTUMBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);
							
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'XLMBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'XEMBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'POEBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'TRXBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'ZENBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'ETCBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'EOSBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'DASHBTC'){     
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);							
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'LINKBTC'){  
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'XMRBTC'){  
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'ADABTC'){       
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'LTCUSDT'){        
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							$usdt_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'BTCUSDT'){    
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							$usdt_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'XRPUSDT'){
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							$usdt_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'NEOUSDT'){
							$usdt += $value1['purchased_price'] * $value1['quantity'];
							$usdt_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'QTUMUSDT'){
							$usdt += $value1['purchased_price']* $value1['quantity'];;
							$usdt_sell +=(float)($value1['market_sold_price'] * $value1['quantity']);

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}	
						if(isset($value1['is_manual_sold'])){
							$manul_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];											
							
						}elseif(isset($value1['csl_sold'])){
							$CSL_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];											
							
						}elseif(isset($value1['trade_history_issue']) && $value1['trade_history_issue'] == "yes"){
							// $CSL_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];											
						}else{
							$sold_puchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
							
						}

						//Sell time delapy and % delay calculate
 						if(isset($value1['order_send_time']) && isset($value1['sell_date']) && !empty($value1['order_send_time']) && !empty($value1['sell_date']) && $value1['is_sell_order'] == "sold"){

							$filledTime     = strtotime($value1['sell_date']->toDateTime()->format('Y-m-d H:i:s'));
							$orderSendTime  = strtotime($value1['order_send_time']->toDateTime()->format('Y-m-d H:i:s'));

							$differenceInSec = ($filledTime - $orderSendTime);
						}else{
							$differenceInSec = 0;
						}
						if($differenceInSec >= 0 && $differenceInSec < 15 ){
                          	$sumTimeDelayRange1++; 
						}elseif($differenceInSec >= 15 && $differenceInSec < 30){
							$sumTimeDelayRange2++;
						}elseif($differenceInSec >= 30 && $differenceInSec < 45){
							$sumTimeDelayRange3++;
						}elseif($differenceInSec >= 45 && $differenceInSec < 60){
							$sumTimeDelayRange4++;
						}elseif($differenceInSec >= 60 && $differenceInSec < 75){
							$sumTimeDelayRange5++;
						}elseif($differenceInSec >= 75 && $differenceInSec < 90 ){
							$sumTimeDelayRange6++;
						}elseif($differenceInSec >= 90){
							$sumTimeDelayRange7++;
						}

						// Buy time delapy and % delay calculate
						if(  isset($value1['created_date']) && !empty($value1['created_date']) ){
							$orderBUyTime  		= strtotime($value1['created_date']->toDateTime()->format('Y-m-d H:i:s'));

							$differenceBuyInSec = ($orderBUyTime - $sendHitTime);
						}else{
							$differenceBuyInSec = 0;
						}
						if($differenceBuyInSec < 0){
							$differenceBuyInSec = 0;
						}
						if($differenceBuyInSec >= 0 && $differenceBuyInSec < 15 ){
                          	$buySumTimeDelayRange1++; 
						}elseif($differenceBuyInSec >= 15 && $differenceBuyInSec < 30){
							$buySumTimeDelayRange2++;
						}elseif($differenceBuyInSec >= 30 && $differenceBuyInSec < 45){
							$buySumTimeDelayRange3++;
						}elseif($differenceBuyInSec >= 45 && $differenceBuyInSec < 60){
							$buySumTimeDelayRange4++;
						}elseif($differenceBuyInSec >= 60 && $differenceBuyInSec < 75){
							$buySumTimeDelayRange5++;
						}elseif($differenceBuyInSec >= 75 && $differenceBuyInSec < 90 ){
							$buySumTimeDelayRange6++;
						}elseif($differenceBuyInSec >= 90){
							$buySumTimeDelayRange7++;
						}

						// sold Pl slippage calculate
						if(isset($value1['sell_market_price']) && $value1['is_sell_order'] == 'sold' && $value1['sell_market_price'] !="" && !is_string($value1['sell_market_price'])){
							$val1 = $value1['market_sold_price'] - $value1['sell_market_price']; 
							$val2 = ($value1['market_sold_price'] + $value1['sell_market_price'])/ 2;
							$slippageOrignalPercentage = ($val1/ $val2) * 100;
							$slippageOrignalPercentage = round($slippageOrignalPercentage, 3) . '%';
						}else{
							$slippageOrignalPercentage = 0;
						}

						if($slippageOrignalPercentage > 0){
							$slippageOrignalPercentage = 0;
						}

						if($slippageOrignalPercentage <= 0 && $slippageOrignalPercentage > -0.2 ){

                          	$sumPLSllipageRange1++; 
						}elseif($slippageOrignalPercentage <= -0.2 && $slippageOrignalPercentage > -0.3){
							
							$sumPLSllipageRange2++;
						}elseif($slippageOrignalPercentage <= -0.3 && $slippageOrignalPercentage > -0.5){
							
							$sumPLSllipageRange3++;
						}elseif($slippageOrignalPercentage <= -0.5 && $slippageOrignalPercentage > -0.75){
							
							$sumPLSllipageRange4++;
						}elseif($slippageOrignalPercentage <= -1 ){
							
							$sumPLSllipageRange5++;
						}
						
					} //end sold foreach

					// if manul sold greater than 0 add in avg parofit 
					if($manul_sold_purchase_price > 0)
					{
						$sold_puchase_price += $manul_sold_purchase_price;
						$manul_sold_purchase_price = 0;
					}

					// if CSL sold greater than 0 add in avg parofit 
					if($CSL_sold_purchase_price > 0)
					{
						$sold_puchase_price += $CSL_sold_purchase_price;
						$CSL_sold_purchase_price = 0;
					}
					if($manul_sold_purchase_price != "0"){
						$per_trade_sold_manul = (float) $manul_sold_purchase_price * 100;
						echo "<br>per tarde manul = ".$per_trade_sold_manul;
						$avg_manul = (float) ($per_trade_sold_manul / (count($total_sold_rec)));
						echo "<br>avg_sold manul = ";
						print_r($avg_manul);
						print_r("<br>sold count = ".count($total_sold_rec));
					}
					if($sold_puchase_price !="0"){
						$per_trade_sold = (float) $sold_puchase_price * 100;
						echo "<br>per tarde = ".$per_trade_sold;
						$avg_sold = (float) ($per_trade_sold / count($total_sold_rec));     
						echo "<br>avg_sold = ";
						print_r($avg_sold);
						print_r("<br>sold count = ".count($total_sold_rec));
					}
					if($CSL_sold_purchase_price !="0"){
						$CSL_per_trade_sold = (float) $CSL_sold_purchase_price * 100;
						echo "<br>per tarde CSL = ".$CSL_per_trade_sold;
						$avg_sold_CSL = (float) ($CSL_per_trade_sold / count($total_sold_rec));
						echo "<br>avg_sold CSL = ";
						print_r($avg_sold_CSL);
						print_r("<br>sold count = ".count($total_sold_rec));
					}
				}//end response > 0 check 

				
				print_r("<br>oppertunity_id=".$value['opportunity_id']."<br>"); 	
				// /////////////////////////////////////////////////////////////////////////END SOLD AVG

				$total_orders = count($total_open_lth_rec) + count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $totalOther;
				$disappear = $parents_executed -  $total_orders;
				$total = count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $disappear;
				if($total == $parents_executed ) {

					$sell_commision_qty_USDT =   ($sell_fee_respected_coin > 0)  ? convertCoinBalanceIntoUSDT($value['coin'], $sell_fee_respected_coin, 'binance') : 0;
					$update_fields = array(
						'open_lth'     			=> 	count($total_open_lth_rec),
						'new_error'    			=> 	count($total_new_error_rec),
						'minOrderSoldPrice' 	=> 	$soldMinPrice[0]['minPrice'],
						'maxOrderSoldPrice' 	=> 	$soldMaxPrice[0]['maxPrice'],
						'reumed_child' 			=> 	count($total_reumed) + count($total_reumed_sold),       
						'costAvgCount' 			=> 	($costAvgReturn + $soldCostAvgReturn),
						'cancelled'    			=> 	count($total_cancel_rec),
						'sold'         			=> 	count($total_sold_rec),         
						'avg_open_lth' 			=> 	$open_lth_avg,
						'other_status' 			=> 	$totalOther,
						'sellTimeDiffRange1' 	=>	$sumTimeDelayRange1 ,
						'sellTimeDiffRange2' 	=>	$sumTimeDelayRange2 ,
						'sellTimeDiffRange3' 	=> 	$sumTimeDelayRange3 ,
						'sellTimeDiffRange4' 	=>	$sumTimeDelayRange4 ,
						'sellTimeDiffRange5' 	=> 	$sumTimeDelayRange5 ,
						'sellTimeDiffRange6' 	=>	$sumTimeDelayRange6 ,
						'sellTimeDiffRange7' 	=>	$sumTimeDelayRange7 ,
						
						'buySumTimeDelayRange1' => $buySumTimeDelayRange1 ,
						'buySumTimeDelayRange2' => $buySumTimeDelayRange2 ,
						'buySumTimeDelayRange3' => $buySumTimeDelayRange3 ,
						'buySumTimeDelayRange4' => $buySumTimeDelayRange4 ,
						'buySumTimeDelayRange5' => $buySumTimeDelayRange5 ,
						'buySumTimeDelayRange6' => $buySumTimeDelayRange6 ,
						'buySumTimeDelayRange7' => $buySumTimeDelayRange7 ,

						'sumPLSllipageRange1'	=> $sumPLSllipageRange1 ,
						'sumPLSllipageRange2' 	=> $sumPLSllipageRange2 ,
						'sumPLSllipageRange3'	=> $sumPLSllipageRange3 ,
						'sumPLSllipageRange4' 	=> $sumPLSllipageRange4 ,
						'sumPLSllipageRange5' 	=> $sumPLSllipageRange5 ,

						'avg_sold'     			=> 	$avg_sold,
						'per_trade_sold' 		=> 	$per_trade_sold,
						'avg_manul'    			=>	$avg_manul,
						'avg_sold_CSL' 			=> 	$avg_sold_CSL,
						'sell_commission' 		=> $sell_comssion_bnb,
						'sell_fee_respected_coin' => $sell_fee_respected_coin,
						'sell_commision_qty_USDT' => $sell_commision_qty_USDT,
						'modified_date' 		=> $current_time_date  
						
					);
					if(isset($value['10_max_value']) && isset($value['5_max_value'])){
						$update_fields['is_modified']  = true;
					}
					if(count($total_open_lth_rec)== 0 && count($total_sold_rec) == 0 &&  $totalOther == 0 ){
						$update_fields['oppertunity_missed'] = true;
					}
				}else { 
					$update_fields = array(
						'open_lth'     			=> 	count($total_open_lth_rec),
						'new_error'    			=> 	count($total_new_error_rec),
						'cancelled'    			=> 	count($total_cancel_rec),
						'costAvgCount' 			=> 	($costAvgReturn + $soldCostAvgReturn),
						'reumed_child' 			=> 	count($total_reumed) + count($total_reumed_sold) ,
						'sold'         			=> 	count($total_sold_rec),
						'avg_open_lth' 			=> 	$open_lth_avg,
						'sellTimeDiffRange1' 	=>	$sumTimeDelayRange1 ,
						'sellTimeDiffRange2' 	=>	$sumTimeDelayRange2 ,
						'sellTimeDiffRange3' 	=> 	$sumTimeDelayRange3 ,
						'sellTimeDiffRange4' 	=>	$sumTimeDelayRange4 ,
						'sellTimeDiffRange5' 	=> 	$sumTimeDelayRange5 ,
						'sellTimeDiffRange6' 	=>	$sumTimeDelayRange6 ,
						'sellTimeDiffRange7' 	=>	$sumTimeDelayRange7 ,

						'buySumTimeDelayRange1' => $buySumTimeDelayRange1 ,
						'buySumTimeDelayRange2' => $buySumTimeDelayRange2 ,
						'buySumTimeDelayRange3' => $buySumTimeDelayRange3 ,
						'buySumTimeDelayRange4' => $buySumTimeDelayRange4 ,
						'buySumTimeDelayRange5' => $buySumTimeDelayRange5 ,
						'buySumTimeDelayRange6' => $buySumTimeDelayRange6 ,
						'buySumTimeDelayRange7' => $buySumTimeDelayRange7 ,

						'sumPLSllipageRange1' 	=> $sumPLSllipageRange1 ,
						'sumPLSllipageRange2' 	=> $sumPLSllipageRange2 ,
						'sumPLSllipageRange3'	=> $sumPLSllipageRange3 ,
						'sumPLSllipageRange4' 	=> $sumPLSllipageRange4 ,
						'sumPLSllipageRange5' 	=> $sumPLSllipageRange5 ,

						'avg_sold'     			=> 	$avg_sold,
						'per_trade_sold' 		=> 	$per_trade_sold,
						'other_status' 			=> 	$totalOther, 
						'minOrderSoldPrice' 	=> 	$soldMinPrice[0]['minPrice'],
						'maxOrderSoldPrice' 	=> 	$soldMaxPrice[0]['maxPrice'],  
						'avg_manul'    			=>	$avg_manul,
						'avg_sold_CSL' 			=> 	$avg_sold_CSL,
						'modified_date'			=>	$current_time_date
					);
				}

				// btc_sell  usdt_sell


				$sell_btc_converted = ($btc_sell > 0)  ? convertCoinBalanceIntoUSDT($value['coin'], $btc_sell, 'binance') : 0; 
				$update_fields['sell_btc_in_$'] =   (float)$sell_btc_converted;
				$update_fields['sell_usdt']   	=   (float)$usdt_sell;
				$update_fields['total_sell_in_usdt'] = (float)($sell_btc_converted + $usdt_sell );


				if($buy_fee_respected_coin > 0 && !isset($value['buy_commision_qty']) && !isset($value['is_modified'])){
					$update_fields['buy_commision_qty'] = $buy_fee_respected_coin;

					$update_fields['buy_commision_qty_USDT'] =   ($buy_fee_respected_coin > 0)  ? convertCoinBalanceIntoUSDT($value['coin'], $buy_fee_respected_coin, 'binance') : 0;
				}
				if($buy_commision_bnb > 0 && !isset($value['buy_commision']) && !isset($value['is_modified'])){
					$update_fields['buy_commision'] = $buy_commision_bnb;
				}

				echo "<pre>";print_r($update_fields);
				$db = $this->mongo_db->customQuery();

				$pipeline = [
					[
						'$match' =>[
							'application_mode' => 'live',
							'parent_status' => ['$exists' => false ],
							'opportunityId' => $value['opportunity_id'],
							'status' => ['$in'=>['LTH','FILLED']],
						],
					],
					[
						'$sort' =>['created_date'=> -1],
					],
					['$limit'=>1]
				];
				$result_buy = $db->buy_orders->aggregate($pipeline);
				$res = iterator_to_array($result_buy);

				$pipeline1 = [
					[
						'$match' =>[
							'application_mode' => 'live',
							'parent_status' => ['$exists' => false ],
							'opportunityId' => $value['opportunity_id'],
							'status' => ['$in'=>['LTH','FILLED']],
						],
					],
					[
					'$sort' =>['created_date'=> 1],
					],
					['$limit'=>1]
				];
				$result_buy1 = $db->buy_orders->aggregate($pipeline1);
				$res1 = iterator_to_array($result_buy1);
				if(!isset($value['first_order_buy']) && !isset($value['last_order_buy'])){
					echo "<br> created_date first =".$res[0]['created_date'];
					echo "<br>created_date last = ".$res1[0]['created_date'];
					$update_fields['first_order_buy'] =  $res[0]['created_date'];
					$update_fields['last_order_buy'] =  $res1[0]['created_date'];
				}

				if(!isset($value['opp_came_binance']) && !isset($value['opp_came_kraken']) && !isset($value['opp_came_bam'])){	
					$opper_search['application_mode']= 'live';
					$opper_search['opportunityId'] = $value['opportunity_id'];	
					$connetct= $this->mongo_db->customQuery();
					$pending_curser = $connetct->buy_orders->find($opper_search);
					$buy_order = iterator_to_array($pending_curser);
					echo "<br>result binance=".count($buy_order);
					$pending_curser_buy = $connetct->sold_buy_order->find($opper_search);
					$sold_bbuy_order = iterator_to_array($pending_curser_buy);
					echo "<br>result binance sold=".count($sold_bbuy_order);

					if(count($buy_order) > 0 || count($sold_bbuy_order) > 0 ){
						$update_fields['opp_came_binance'] = '1';
					}else{
						$update_fields['opp_came_binance'] = '0';
					}
					
					$this->mongo_db->where($opper_search);
					$response_kraken = $this->mongo_db->get('buy_orders_kraken');
					$data_kraken = iterator_to_array($response_kraken);
					echo "<br>result kraken=". count($data_kraken);

					$this->mongo_db->where($opper_search);
					$response_kraken_sold = $this->mongo_db->get('sold_buy_orders_kraken');
					$data_kraken_sold = iterator_to_array($response_kraken_sold);
					echo "<br>result kraken sold=". count($data_kraken_sold);
					if(count($data_kraken) > 0 || count($data_kraken_sold) > 0){
						$update_fields['opp_came_kraken'] = '1';
					}else{
						$update_fields['opp_came_kraken'] = '0';
					}
					
					$this->mongo_db->where($opper_search);
					$response_bam = $this->mongo_db->get('buy_orders_bam');
					$data_bam = iterator_to_array($response_bam);
					echo "<br>result bam=". count($data_bam );

					$this->mongo_db->where($opper_search);
					$response_bam_sold = $this->mongo_db->get('sold_buy_orders_bam');
					$data_bam_sold = iterator_to_array($response_bam_sold);
					echo "<br>result bam sold =". count($data_bam_sold);

					if(count($data_bam) > 0 || count($data_bam_sold) > 0){
						$update_fields['opp_came_bam'] = '1';
					}else{
						$update_fields['opp_came_bam'] = '0';
					}
				}

				if($btc > 0 && $usdt == 0 && !isset($value['usdt_invest_amount']) &&  !isset($value['btc_invest_amount'])){
					$update_fields['usdt_invest_amount'] = $btcusdt * $btc;//(float)$btc;
					$update_fields['btc_invest_amount']  = $btc;  //for chart view 
				}
				elseif($usdt > 0 && $btc == 0 && !isset($value['usdt_invest_amount']) && !isset($value['only_usdt_invest_amount'])) {
					$update_fields['usdt_invest_amount'] = $usdt;
					$update_fields['only_usdt_invest_amount'] = $usdt;  //for chart view
				} //end if ($total == $parents_executed ) 

				
				foreach($api_response as $as_1){
					if($as_1->max_price !='' && $as_1->min_price !='' && $as_1->min_price != 0 && $as_1->max_price != 0){
						$update_fields['5_max_value'] = $as_1->max_price;
						echo "<br>max =". $update_fields['5_max_value'];
						$update_fields['5_min_value'] = $as_1->min_price;  
						echo "<br> min =". $update_fields['5_min_value'];
					} //loop inner check				
				} // foreach loop end


				foreach($api_response_10 as $as){
					if($as->max_price !='' && $as->min_price !='' && $as->min_price !=0 && $as->max_price !=0){
						echo "<br>max 10 = ".$as->max_price;
						$update_fields['10_max_value'] = $as->max_price; 
						echo "<br>min 10=".$as->min_price;
						$update_fields['10_min_value'] = $as->min_price;
					} // if inner check	
				} //end foreach loop

				echo"<br><pre>";
				print_r($update_fields);
				$collection_name = 'opportunity_logs_binance';
				$this->mongo_db->where($search_update);
				$this->mongo_db->set($update_fields);
				$query = $this->mongo_db->update($collection_name);	
			}
		} //end foreach
		echo "<br>current time".$current_date_time;
		echo "<br>Total Picked Oppertunities Ids= " . count($response);

		//Save last Cron Executioon
		$this->last_cron_execution_time('Binance live opportunity', '1m', 'run binance live opportunity logs (* * * * *)', 'reports');


	} //end cron

	//suppopting script for old opportunities binance
	public function insert_latest_oppertunity_into_log_collection_binance_for_old_opportunities(){
		// ini_set("display_errors", E_ALL);
		// error_reporting(E_ALL);

		$marketPrices = marketPrices('binance');
		$this->load->helper('new_common_helper');
		foreach($marketPrices as $price){
			if($price['_id'] == 'ETHBTC'){
				$ethbtc = (float)$price['price'];
			}elseif($price['_id'] == 'BTCUSDT'){
				$btcusdt = (float)$price['price'];
			}elseif($price['_id'] == 'XRPBTC'){
				$xrpbtc = (float)$price['price'];
			}elseif($price['_id'] == 'XRPUSDT'){
				$xrpusdt = (float)$price['price'];
			}elseif($price['_id'] == 'NEOBTC'){
				$neobtc = (float)$price['price'];
			}elseif($price['_id'] == 'NEOUSDT'){
				$neousdt = (float)$price['price'];
			}elseif($price['_id'] == 'QTUMBTC'){
				$qtumbtc = (float)$price['price'];
			}elseif($price['_id'] == 'QTUMUSDT'){
				$qtumusdt = (float)$price['price'];
			}elseif($price['_id'] == 'XLMBTC'){
				$xml = (float)$price['price'];
			}elseif($price['_id'] == 'XEMBTC'){
				$xem = (float)$price['price'];
			}elseif($price['_id'] == 'POEBTC'){
				$poe = (float)$price['price'];
			}elseif($price['_id'] == 'TRXBTC'){
				$trx = (float)$price['price'];
			}elseif($price['_id'] == 'ZENBTC'){
				$zen = (float)$price['price'];
			}elseif($price['_id'] == 'ETCBTC'){
				$etcbtc = (float)$price['price'];
			}elseif($price['_id'] =='EOSBTC'){
				$eosbtc = (float)$price['price'];
			}elseif($price['_id'] =='LINKBTC'){
				$linkbtc = (float)$price['price'];
			}elseif($price['_id'] =='DASHBTC'){
				$dashbtc = (float)$price['price'];
			}elseif($price['_id'] =='XMRBTC'){
				$xmrbtc = (float)$price['price'];
			}elseif($price['_id'] =='ADABTC'){
				$adabtc = (float)$price['price'];
			}elseif($price['_id'] =='LTCUSDT'){
				$ltcusdt = (float)$price['price'];
			}elseif($price['_id'] =='EOSUSDT'){
				$eosusdt = (float)$price['price'];
			}				
		}//end inner loop 
		$startDate =  date('Y-01-d 00:00:00');
		$startTime =  $this->mongo_db->converToMongodttime($startDate);

		$current_date_time =  date('Y-m-d 00:00:00');
		$current_time_date =  $this->mongo_db->converToMongodttime($current_date_time);

		$current_hour =  date('Y-m-d H:i:s', strtotime('-1 month'));
		$orig_date1 = $this->mongo_db->converToMongodttime($current_hour);

		$previous_one_month_date_time = date('Y-m-d H:i:s', strtotime('-1 month'));
		$pre_date_1 =  $this->mongo_db->converToMongodttime($previous_one_month_date_time);

		$connection = $this->mongo_db->customQuery();      
		$condition = array('sort' => array('modified_date' => -1), 'limit'=> 15);
		 
		$where['mode'] 			=	'live';
		$where['created_date'] 	= 	array('$gte'=> $startTime, '$lte'  =>  $pre_date_1);
		$where['level'] 		= 	array('$ne'=>'level_15');
		$where['modified_date'] = 	array('$lte' => $orig_date1);
		$where['is_modified']	=	['$exists' => false];

		$find_rec = $connection->opportunity_logs_binance->find($where,  $condition);
		$response = iterator_to_array($find_rec);
		echo "<br>Count: ". count($response);

		foreach ($response as $value){
			if(isset($value['sendHitTime']) && !empty($value['sendHitTime'])){
				$sendHitTime     	= strtotime($value['sendHitTime']->toDateTime()->format('Y-m-d H:i:s'));   

			}else{
				$sendHitTime     	= strtotime($value['created_date']->toDateTime()->format('Y-m-d H:i:s'));
			}

			if($value['level'] != 'level_15' ) {
				$open_lth_avg_per_trade = 0;
				$open_lth_avg = 0;
				$avg_sold = 0;
				$parents_executed = 0;
				$parents_executed = $value['parents_executed'];
				
				$search_update['opportunity_id'] = (string)$value['opportunity_id'];
				// $search_update['mode']= 'live';
				
				$other['application_mode']= 'live';
				$other['opportunityId'] =  $value['opportunity_id'];
				$other['status'] = array('$nin' => array('LTH', 'FILLED','canceled','new_ERROR'));

				$buyOther = $connection->buy_orders->count($other);
				/////////////////////////////////////////////////////////

				$search_open_lth['application_mode']		= 	'live';
				$search_open_lth['opportunityId'] 			= 	$value['opportunity_id'];
				$search_open_lth['status'] 					= 	array('$in' => array('LTH', 'FILLED'));
				$search_open_lth['is_sell_order']         	=   'yes';
				$search_open_lth['cavg_parent'] 			= 	['$exists' => false];
				$search_open_lth['cost_avg']				=	['$nin' => ['yes', 'completed', '']];

				/////
				$search_cancel['application_mode']		= 	'live';
				$search_cancel['opportunityId'] 		= 	$value['opportunity_id'];
				$search_cancel['status'] 				= 	array('$in' => array('canceled'));
				$search_cancel['cavg_parent'] 			= 	['$exists' => false];
				$search_cancel['cost_avg']				=	['$nin' => ['yes', 'completed', '']];
				//////
				$search_new_error['application_mode']	= 'live';
				$search_new_error['opportunityId'] 		= $value['opportunity_id'];
				$search_new_error['status'] 			= array('$in' => array('new_ERROR'));
				$search_new_error['cavg_parent'] 		= 	['$exists' => false];
				$search_new_error['cost_avg']			=	['$nin' => ['yes', 'completed', '']];
				////////
				$search_sold['application_mode']	= 'live';
				$search_sold['opportunityId'] 		= $value['opportunity_id'];
				$search_sold['is_sell_order'] 		= 'sold';
				$search_sold['cavg_parent'] 		= ['$exists' => false];
				$search_sold['cost_avg']			= ['$nin' => ['yes', 'completed', '']];


				$otherSold['application_mode'] 	= 	'live';
				$otherSold['opportunityId'] 	=  	$value['opportunity_id'];
				$otherSold['is_sell_order'] 	= 	array('$nin' => array('sold'));
				$searchSold['cavg_parent'] 		= 	['$exists' => false];
				$searchSold['cost_avg']			=	['$nin' => ['yes', 'completed', '']];

				$otherStatusSold = $connection->sold_buy_orders->count($otherSold);
				$totalOther = $buyOther + $otherStatusSold;

				$minPriceLookUp = [
					[
						'$match' => [
							'application_mode' => 'live',
							'opportunityId'    =>  $value['opportunity_id'],
							'is_sell_order'    =>  'sold'
 						]
					],

					[
						'$group' =>[
							'_id' => '$symbol',
							'minPrice' => ['$min' => '$market_sold_price']
						]
					],

				];

				$minSoldPrice = $connection->sold_buy_orders->aggregate($minPriceLookUp);
				$soldMinPrice  = iterator_to_array($minSoldPrice);

				$maxPriceLookUp = [
					[
						'$match' => [
							'application_mode' => 'live',
							'opportunityId'    =>  $value['opportunity_id'],
							'is_sell_order'    =>  'sold'
 						]
					],

					[
						'$group' =>[
							'_id' => '$symbol',
							'maxPrice' => ['$max' => '$market_sold_price']
						]
					],

				];

				$maxSoldPrice = $connection->sold_buy_orders->aggregate($maxPriceLookUp);
				$soldMaxPrice  = iterator_to_array($maxSoldPrice);
				
				///////////////////////////////////////////////////////////////////
		
				$search_resumed['application_mode']	= 	'live';
				$search_resumed['opportunityId'] 	= 	$value['opportunity_id'];
				$search_resumed['resume_status'] 	= 	array('$in' => array('resume'));
				$search_resumed['cavg_parent'] 		= 	['$exists' => false];
				$search_resumed['cost_avg']			=	['$nin' => ['yes', 'completed', '']];
				
				/////////////////////////////////////////////////////////////// 
				$cosAvg['application_mode']	= 	'live';
				$cosAvg['opportunityId'] 	= 	$value['opportunity_id'];
				$cosAvg['cost_avg']['$ne'] 	= 	'completed';
				$cosAvg['is_sell_order']	= 	'yes';
				$cosAvg['cavg_parent'] 		= 	'yes';

				$cosAvgSold['application_mode']	= 'live';
				$cosAvgSold['opportunityId'] 	= $value['opportunity_id'];
				$cosAvgSold['is_sell_order'] 	= 'sold';
				$cosAvgSold['cost_avg'] 		= 'completed';
				$cosAvgSold['cavg_parent'] 		= 'yes';
				
				$costAvgReturn 		= $connection->buy_orders->count($cosAvg);
				$soldCostAvgReturn 	= $connection->sold_buy_orders->count($cosAvgSold);  
				/////////////////////////////////////////////////////////////// 

				$this->mongo_db->where($search_resumed);
				$total_resumed_sold = $this->mongo_db->get('sold_buy_orders');
				$total_reumed_sold   = iterator_to_array($total_resumed_sold);
				
				$this->mongo_db->where($search_resumed);
				$total_resumed = $this->mongo_db->get('buy_orders');
				$total_reumed   = iterator_to_array($total_resumed);

				$this->mongo_db->where($search_open_lth);
				$total_open = $this->mongo_db->get('buy_orders');
				$total_open_lth_rec   = iterator_to_array($total_open);

				$this->mongo_db->where($search_cancel);
				$total_cancel = $this->mongo_db->get('buy_orders');
				$total_cancel_rec   = iterator_to_array($total_cancel);

				///////////////////////////////////////////////////////////////////////////////

				$this->mongo_db->where($search_new_error);
				$total_new_error = $this->mongo_db->get('buy_orders');
				$total_new_error_rec   = iterator_to_array($total_new_error);

				// 	/////////////////////////////////////////////////////////////////////////////

				$this->mongo_db->where($search_sold);
				$total_sold_total = $this->mongo_db->get('sold_buy_orders');
				$total_sold_rec   = iterator_to_array($total_sold_total);
				
				// ////////////////////////////////////////////////CALCULATE LTH AND OPEN ORDERS AVG
				$open_lth_puchase_price = 0;
				$open_lth_avg = 0;
				$open_lth_avg_per_trade= 0;
				$btc = 0;
				$usdt = 0;

				$buySumTimeDelayRange1 = 0;
				$buySumTimeDelayRange2 = 0;
				$buySumTimeDelayRange3 = 0;
				$buySumTimeDelayRange4 = 0;
				$buySumTimeDelayRange5 = 0;
				$buySumTimeDelayRange6 = 0;
				$buySumTimeDelayRange7 = 0;
				$buy_commision_bnb = 0;    
				$buy_fee_respected_coin = 0;

				echo"<br>Total open lth = ".count($total_open_lth_rec);
				if (count($total_open_lth_rec) > 0){
					foreach ($total_open_lth_rec as $key => $value2) {
						$commission_array = $value2['buy_fraction_filled_order_arr'];
						if($value2['symbol'] == 'ETHBTC'){
							$open_lth_puchase_price += (float) ($ethbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'LINKBTC'){
							$open_lth_puchase_price += (float) ($linkbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							$btc +=(float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'DASHBTC'){
							$open_lth_puchase_price += (float) ($dashbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							$btc +=(float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XMRBTC'){
							$open_lth_puchase_price += (float) ($xmrbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							$btc +=(float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'ADABTC'){
							$open_lth_puchase_price += (float) ($adabtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							$btc +=(float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'LTCUSDT'){
							$open_lth_puchase_price += (float) ($ltcusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'BTCUSDT'){
							$open_lth_puchase_price += (float) ($btcusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XRPBTC'){
							$open_lth_puchase_price += (float) ($xrpbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XRPUSDT'){
							$open_lth_puchase_price += (float) ($xrpusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'NEOBTC'){
							$open_lth_puchase_price += (float) ($neobtc - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'NEOUSDT'){
							$open_lth_puchase_price += (float) ($neousdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'QTUMBTC'){
							$open_lth_puchase_price += (float) ($qtumbtc - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'QTUMUSDT'){
							$open_lth_puchase_price += (float) ($qtumusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XLMBTC'){
							$open_lth_puchase_price += (float) ($xml - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XEMBTC'){
							$open_lth_puchase_price += (float) ($xem - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'POEBTC'){
							$open_lth_puchase_price += (float) ($poe - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'TRXBTC'){
							$open_lth_puchase_price += (float) ($trx - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'ZENBTC'){
							$open_lth_puchase_price += (float) ($zen - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'ETCBTC'){
							$open_lth_puchase_price += (float) ($etcbtc - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'EOSBTC'){
							$open_lth_puchase_price += (float) ($eosbtc - $value2['purchased_price']) / $value2['purchased_price'] ;
							$btc += (float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'EOSUSDT'){
							$open_lth_puchase_price += (float) ($eosusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt += (float)$value2['purchased_price']  * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}		
						if( isset($value2['created_date']) && !empty($value2['created_date']) ){

							$orderBUyTime  		= strtotime($value2['created_date']->toDateTime()->format('Y-m-d H:i:s'));

							$differenceBuyInSec = ($orderBUyTime - $sendHitTime);
						}else{
							$differenceBuyInSec = 0;
						}

						if($differenceBuyInSec < 0){
							$differenceBuyInSec = 0;
						}
						if($differenceBuyInSec >= 0 && $differenceBuyInSec < 15 ){
                          	$buySumTimeDelayRange1++; 
						}elseif($differenceBuyInSec >= 15 && $differenceBuyInSec < 30){
							$buySumTimeDelayRange2++;
						}elseif($differenceBuyInSec >= 30 && $differenceBuyInSec < 45){
							$buySumTimeDelayRange3++;
						}elseif($differenceBuyInSec >= 45 && $differenceBuyInSec < 60){
							$buySumTimeDelayRange4++;
						}elseif($differenceBuyInSec >= 60 && $differenceBuyInSec < 75){
							$buySumTimeDelayRange5++;
						}elseif($differenceBuyInSec >= 75 && $differenceBuyInSec < 90 ){
							$buySumTimeDelayRange6++;
						}elseif($differenceBuyInSec >= 90){
							$buySumTimeDelayRange7++;
						}
					}//end loop
					$open_lth_avg_per_trade = (float) $open_lth_puchase_price * 100;
					$open_lth_avg = (float) ($open_lth_avg_per_trade / count($total_open_lth_rec));
				
				}//end if
				// /////////////////////////////////////////////////////////////////END OPEN LTH AVG
			
				// ////////////////////////////////////////////////////////////////CALCULATE SOLD AVG
				$sold_puchase_price = 0;
				$sell_fee_respected_coin = 0;
				$avg_sold_CSL = 0;
				$CSL_per_trade_sold = 0;
				$CSL_sold_purchase_price = 0 ;
				$avg_manul = 0;
				$per_trade_sold_manul = 0;
				$manul_sold_purchase_price = 0;
				$avg_sold = 0;
				$per_trade_sold = 0;
				// $sold_profit_btc = 0;
				$sumTimeDelayRange1 = 0;
				$sumTimeDelayRange2 = 0;
				$sumTimeDelayRange3 = 0;
				$sumTimeDelayRange4 = 0;
				$sumTimeDelayRange5 = 0;
				$sumTimeDelayRange6 = 0;
				$sumTimeDelayRange7 = 0;

				$sumPLSllipageRange1 = 0;
				$sumPLSllipageRange2 = 0;
				$sumPLSllipageRange3 = 0;
				$sumPLSllipageRange4 = 0;
				$sumPLSllipageRange5 = 0;
				// $sold_profit_usdt = 0;
				$sell_comssion_bnb = 0;
				$btc_sell 	= 0;
				$usdt_sell 	= 0 ;
			
				if(count($total_sold_rec) > 0){
					foreach ($total_sold_rec as $key => $value1) {
						$commission_sold_array = $value1['buy_fraction_filled_order_arr'];
						if(!empty($value1['sell_fraction_filled_order_arr'])){
							$sell_commission_sold_array = $value1['sell_fraction_filled_order_arr'];
						}else{
							$sell_commission_sold_array = [];
						}
						if($value1['symbol'] == 'ETHBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];
							
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}
						}elseif($value1['symbol'] == 'XRPBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'NEOBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'QTUMBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'XLMBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'XEMBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'POEBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'TRXBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'ZENBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'ETCBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'EOSBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'DASHBTC'){     
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'LINKBTC'){  
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'XMRBTC'){  
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'ADABTC'){       
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'LTCUSDT'){        
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							$usdt_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'BTCUSDT'){    
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							$usdt_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'XRPUSDT'){
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							$usdt_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'NEOUSDT'){
							$usdt += $value1['purchased_price'] * $value1['quantity'];
							$usdt_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'QTUMUSDT'){
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							$usdt_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}	
						if(isset($value1['is_manual_sold'])){
							$manul_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];											
							
						}elseif(isset($value1['csl_sold'])){
							$CSL_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];											
							
						}elseif(isset($value1['trade_history_issue']) && $value1['trade_history_issue'] == "yes"){
							// $CSL_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];											
						}else{
							$sold_puchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
							
						}

						//Sell time delapy and % delay calculate
 						if(isset($value1['order_send_time']) && isset($value1['sell_date']) && !empty($value1['order_send_time']) && !empty($value1['sell_date']) && $value1['is_sell_order'] == "sold"){

							$filledTime     = strtotime($value1['sell_date']->toDateTime()->format('Y-m-d H:i:s'));
							$orderSendTime  = strtotime($value1['order_send_time']->toDateTime()->format('Y-m-d H:i:s'));

							$differenceInSec = ($filledTime - $orderSendTime);
						}else{
							$differenceInSec = 0;
						}
						if($differenceInSec >= 0 && $differenceInSec < 15 ){
                          	$sumTimeDelayRange1++; 
						}elseif($differenceInSec >= 15 && $differenceInSec < 30){
							$sumTimeDelayRange2++;
						}elseif($differenceInSec >= 30 && $differenceInSec < 45){
							$sumTimeDelayRange3++;
						}elseif($differenceInSec >= 45 && $differenceInSec < 60){
							$sumTimeDelayRange4++;
						}elseif($differenceInSec >= 60 && $differenceInSec < 75){
							$sumTimeDelayRange5++;
						}elseif($differenceInSec >= 75 && $differenceInSec < 90 ){
							$sumTimeDelayRange6++;
						}elseif($differenceInSec >= 90){
							$sumTimeDelayRange7++;
						}

						// Buy time delapy and % delay calculate
						if(  isset($value1['created_date']) && !empty($value1['created_date']) ){
							$orderBUyTime  		= strtotime($value1['created_date']->toDateTime()->format('Y-m-d H:i:s'));

							$differenceBuyInSec = ($orderBUyTime - $sendHitTime);
						}else{
							$differenceBuyInSec = 0;
						}
						if($differenceBuyInSec < 0){
							$differenceBuyInSec = 0;
						}
						if($differenceBuyInSec >= 0 && $differenceBuyInSec < 15 ){
                          	$buySumTimeDelayRange1++; 
						}elseif($differenceBuyInSec >= 15 && $differenceBuyInSec < 30){
							$buySumTimeDelayRange2++;
						}elseif($differenceBuyInSec >= 30 && $differenceBuyInSec < 45){
							$buySumTimeDelayRange3++;
						}elseif($differenceBuyInSec >= 45 && $differenceBuyInSec < 60){
							$buySumTimeDelayRange4++;
						}elseif($differenceBuyInSec >= 60 && $differenceBuyInSec < 75){
							$buySumTimeDelayRange5++;
						}elseif($differenceBuyInSec >= 75 && $differenceBuyInSec < 90 ){
							$buySumTimeDelayRange6++;
						}elseif($differenceBuyInSec >= 90){
							$buySumTimeDelayRange7++;
						}

						// sold Pl slippage calculate
						if(isset($value1['sell_market_price']) && $value1['is_sell_order'] == 'sold' && $value1['sell_market_price'] !="" && !is_string($value1['sell_market_price'])){
							$val1 = $value1['market_sold_price'] - $value1['sell_market_price']; 
							$val2 = ($value1['market_sold_price'] + $value1['sell_market_price'])/ 2;
							$slippageOrignalPercentage = ($val1/ $val2) * 100;
							$slippageOrignalPercentage = round($slippageOrignalPercentage, 3) . '%';
						}else{
							$slippageOrignalPercentage = 0;
						}

						if($slippageOrignalPercentage > 0){
							$slippageOrignalPercentage = 0;
						}

						if($slippageOrignalPercentage <= 0 && $slippageOrignalPercentage > -0.2 ){

                          	$sumPLSllipageRange1++; 
						}elseif($slippageOrignalPercentage <= -0.2 && $slippageOrignalPercentage > -0.3){
							
							$sumPLSllipageRange2++;
						}elseif($slippageOrignalPercentage <= -0.3 && $slippageOrignalPercentage > -0.5){
							
							$sumPLSllipageRange3++;
						}elseif($slippageOrignalPercentage <= -0.5 && $slippageOrignalPercentage > -0.75){
							
							$sumPLSllipageRange4++;
						}elseif($slippageOrignalPercentage <= -1 ){
							
							$sumPLSllipageRange5++;
						}
						
					} //end sold foreach

					// if manul sold greater than 0 add in avg parofit 
					if($manul_sold_purchase_price > 0)
					{
						$sold_puchase_price += $manul_sold_purchase_price;
						$manul_sold_purchase_price = 0;
					}

					// if CSL sold greater than 0 add in avg parofit 
					if($CSL_sold_purchase_price > 0)
					{
						$sold_puchase_price += $CSL_sold_purchase_price;
						$CSL_sold_purchase_price = 0;
					}
					if($manul_sold_purchase_price != "0"){

						$per_trade_sold_manul = (float) $manul_sold_purchase_price * 100;
						$avg_manul = (float) ($per_trade_sold_manul / (count($total_sold_rec)));
					}
					if($sold_puchase_price !="0"){

						$per_trade_sold = (float) $sold_puchase_price * 100;
						$avg_sold = (float) ($per_trade_sold / count($total_sold_rec));    
					}
					if($CSL_sold_purchase_price !="0"){

						$CSL_per_trade_sold = (float) $CSL_sold_purchase_price * 100;
						$avg_sold_CSL = (float) ($CSL_per_trade_sold / count($total_sold_rec));
					}
				}//end response > 0 check 

				
				print_r("<br>oppertunity_id=".$value['opportunity_id']."<br>"); 	
				// /////////////////////////////////////////////////////////////////////////END SOLD AVG

				$total_orders = count($total_open_lth_rec) + count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $totalOther;
				$disappear = $parents_executed -  $total_orders;
				$total = count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $disappear;
				if($total == $parents_executed ) {
					$sell_commision_qty_USDT =   ($sell_fee_respected_coin > 0)  ? convertCoinBalanceIntoUSDT($value['coin'], $sell_fee_respected_coin, 'binance') : 0;
					$update_fields = array(
						'open_lth'     			=> 	count($total_open_lth_rec),
						'new_error'    			=> 	count($total_new_error_rec),
						'minOrderSoldPrice' 	=> 	$soldMinPrice[0]['minPrice'],
						'maxOrderSoldPrice' 	=> 	$soldMaxPrice[0]['maxPrice'],
						'reumed_child' 			=> 	count($total_reumed) + count($total_reumed_sold),       
						'costAvgCount' 			=> 	($costAvgReturn + $soldCostAvgReturn),
						'cancelled'    			=> 	count($total_cancel_rec),
						'sold'         			=> 	count($total_sold_rec),         
						'avg_open_lth' 			=> 	$open_lth_avg,
						'other_status' 			=> 	$totalOther,
						'sellTimeDiffRange1' 	=>	$sumTimeDelayRange1 ,
						'sellTimeDiffRange2' 	=>	$sumTimeDelayRange2 ,
						'sellTimeDiffRange3' 	=> 	$sumTimeDelayRange3 ,
						'sellTimeDiffRange4' 	=>	$sumTimeDelayRange4 ,
						'sellTimeDiffRange5' 	=> 	$sumTimeDelayRange5 ,
						'sellTimeDiffRange6' 	=>	$sumTimeDelayRange6 ,
						'sellTimeDiffRange7' 	=>	$sumTimeDelayRange7 ,
						'buySumTimeDelayRange1' => $buySumTimeDelayRange1 ,
						'buySumTimeDelayRange2' => $buySumTimeDelayRange2 ,
						'buySumTimeDelayRange3' => $buySumTimeDelayRange3 ,
						'buySumTimeDelayRange4' => $buySumTimeDelayRange4 ,
						'buySumTimeDelayRange5' => $buySumTimeDelayRange5 ,
						'buySumTimeDelayRange6' => $buySumTimeDelayRange6 ,
						'buySumTimeDelayRange7' => $buySumTimeDelayRange7 ,
						'sumPLSllipageRange1'	=> $sumPLSllipageRange1 ,
						'sumPLSllipageRange2' 	=> $sumPLSllipageRange2 ,
						'sumPLSllipageRange3'	=> $sumPLSllipageRange3 ,
						'sumPLSllipageRange4' 	=> $sumPLSllipageRange4 ,
						'sumPLSllipageRange5' 	=> $sumPLSllipageRange5 ,
						'avg_sold'     			=> 	$avg_sold,
						'per_trade_sold' 		=> 	$per_trade_sold,
						'avg_manul'    			=>	$avg_manul,
						'avg_sold_CSL' 			=> 	$avg_sold_CSL,
						'sell_commission' 		=> $sell_comssion_bnb,
						'sell_commision_qty_USDT' => $sell_commision_qty_USDT,
						'sell_fee_respected_coin' => $sell_fee_respected_coin,
						'modified_date' 		=> $current_time_date  
						
					);
					if(isset($value['10_max_value']) && isset($value['5_max_value'])){
						$update_fields['is_modified']  = true;
					}
					if(count($total_open_lth_rec)== 0 && count($total_sold_rec) == 0 &&  $totalOther == 0 ){
						$update_fields['oppertunity_missed'] = true;
					}
				}else { 
					$update_fields = array(
						'open_lth'     			=> 	count($total_open_lth_rec),
						'new_error'    			=> 	count($total_new_error_rec),
						'cancelled'    			=> 	count($total_cancel_rec),
						'costAvgCount' 			=> 	($costAvgReturn + $soldCostAvgReturn),
						'reumed_child' 			=> 	count($total_reumed) + count($total_reumed_sold) ,
						'sold'         			=> 	count($total_sold_rec),
						'avg_open_lth' 			=> 	$open_lth_avg,
						'sellTimeDiffRange1' 	=>	$sumTimeDelayRange1 ,
						'sellTimeDiffRange2' 	=>	$sumTimeDelayRange2 ,
						'sellTimeDiffRange3' 	=> 	$sumTimeDelayRange3 ,
						'sellTimeDiffRange4' 	=>	$sumTimeDelayRange4 ,
						'sellTimeDiffRange5' 	=> 	$sumTimeDelayRange5 ,
						'sellTimeDiffRange6' 	=>	$sumTimeDelayRange6 ,
						'sellTimeDiffRange7' 	=>	$sumTimeDelayRange7 ,
						'buySumTimeDelayRange1' => $buySumTimeDelayRange1 ,
						'buySumTimeDelayRange2' => $buySumTimeDelayRange2 ,
						'buySumTimeDelayRange3' => $buySumTimeDelayRange3 ,
						'buySumTimeDelayRange4' => $buySumTimeDelayRange4 ,
						'buySumTimeDelayRange5' => $buySumTimeDelayRange5 ,
						'buySumTimeDelayRange6' => $buySumTimeDelayRange6 ,
						'buySumTimeDelayRange7' => $buySumTimeDelayRange7 ,
						'sumPLSllipageRange1' 	=> $sumPLSllipageRange1 ,
						'sumPLSllipageRange2' 	=> $sumPLSllipageRange2 ,
						'sumPLSllipageRange3'	=> $sumPLSllipageRange3 ,
						'sumPLSllipageRange4' 	=> $sumPLSllipageRange4 ,
						'sumPLSllipageRange5' 	=> $sumPLSllipageRange5 ,
						'avg_sold'     			=> 	$avg_sold,
						'per_trade_sold' 		=> 	$per_trade_sold,
						'other_status' 			=> 	$totalOther, 
						'minOrderSoldPrice' 	=> 	$soldMinPrice[0]['minPrice'],
						'maxOrderSoldPrice' 	=> 	$soldMaxPrice[0]['maxPrice'],  
						'avg_manul'    			=>	$avg_manul,
						'avg_sold_CSL' 			=> 	$avg_sold_CSL,
						'modified_date'			=>	$current_time_date
					);
				}



				$sell_btc_converted = ($btc_sell > 0)  ? convertCoinBalanceIntoUSDT($value['coin'], $btc_sell, 'binance') : 0;
				$update_fields['sell_btc_in_$'] =   (float)$sell_btc_converted;
				$update_fields['sell_usdt']   	=   (float)$usdt_sell;
				$update_fields['total_sell_in_usdt'] = (float)($sell_btc_converted + $usdt_sell );

				if($buy_fee_respected_coin > 0 && !isset($value['buy_commision_qty']) && !isset($value['is_modified'])){

					$update_fields['buy_commision_qty']      =   $buy_fee_respected_coin;
					$update_fields['buy_commision_qty_USDT'] =   ($buy_fee_respected_coin > 0)  ? convertCoinBalanceIntoUSDT($value['coin'], $buy_fee_respected_coin, 'binance') : 0;

				}
				if($buy_commision_bnb > 0 && !isset($value['buy_commision']) && !isset($value['is_modified'])){
					
					$update_fields['buy_commision'] = $buy_commision_bnb;
				}
				$db = $this->mongo_db->customQuery();

				$pipeline = [
					[
						'$match' =>[
							'application_mode' => 'live',
							'parent_status' => ['$exists' => false ],
							'opportunityId' => $value['opportunity_id'],
							'status' => ['$in'=>['LTH','FILLED']],
						],
					],
					[
						'$sort' =>['created_date'=> -1],
					],
					['$limit'=>1]
				];
				$result_buy = $db->buy_orders->aggregate($pipeline);
				$res = iterator_to_array($result_buy);

				$pipeline1 = [
					[
						'$match' =>[
							'application_mode' => 'live',
							'parent_status' => ['$exists' => false ],
							'opportunityId' => $value['opportunity_id'],
							'status' => ['$in'=>['LTH','FILLED']],
						],
					],
					[
					'$sort' =>['created_date'=> 1],
					],
					['$limit'=>1]
				];
				$result_buy1 = $db->buy_orders->aggregate($pipeline1);
				$res1 = iterator_to_array($result_buy1);
				if(!isset($value['first_order_buy']) && !isset($value['last_order_buy'])){
					
					$update_fields['first_order_buy'] =  $res[0]['created_date'];
					$update_fields['last_order_buy'] =  $res1[0]['created_date'];
				}

				if(!isset($value['opp_came_binance']) && !isset($value['opp_came_kraken']) && !isset($value['opp_came_bam'])){	
					$opper_search['application_mode']= 'live';
					$opper_search['opportunityId'] = $value['opportunity_id'];	
					$connetct= $this->mongo_db->customQuery();
					$pending_curser = $connetct->buy_orders->find($opper_search);
					$buy_order = iterator_to_array($pending_curser);
					$pending_curser_buy = $connetct->sold_buy_order->find($opper_search);
					$sold_bbuy_order = iterator_to_array($pending_curser_buy);

					if(count($buy_order) > 0 || count($sold_bbuy_order) > 0 ){
						$update_fields['opp_came_binance'] = '1';
					}else{
						$update_fields['opp_came_binance'] = '0';
					}
					
					$this->mongo_db->where($opper_search);
					$response_kraken = $this->mongo_db->get('buy_orders_kraken');
					$data_kraken = iterator_to_array($response_kraken);

					$this->mongo_db->where($opper_search);
					$response_kraken_sold = $this->mongo_db->get('sold_buy_orders_kraken');
					$data_kraken_sold = iterator_to_array($response_kraken_sold);
					if(count($data_kraken) > 0 || count($data_kraken_sold) > 0){
						$update_fields['opp_came_kraken'] = '1';
					}else{
						$update_fields['opp_came_kraken'] = '0';
					}
					
					$this->mongo_db->where($opper_search);
					$response_bam = $this->mongo_db->get('buy_orders_bam');
					$data_bam = iterator_to_array($response_bam);

					$this->mongo_db->where($opper_search);
					$response_bam_sold = $this->mongo_db->get('sold_buy_orders_bam');
					$data_bam_sold = iterator_to_array($response_bam_sold);

					if(count($data_bam) > 0 || count($data_bam_sold) > 0){
						$update_fields['opp_came_bam'] = '1';
					}else{
						$update_fields['opp_came_bam'] = '0';
					}
				}

				if($btc > 0 && $usdt == 0 && !isset($value['usdt_invest_amount']) &&  !isset($value['btc_invest_amount'])){
					$update_fields['usdt_invest_amount'] = $btcusdt * $btc;//(float)$btc;
					$update_fields['btc_invest_amount']  = $btc;  //for chart view 
				}
				elseif($usdt > 0 && $btc == 0 && !isset($value['usdt_invest_amount']) && !isset($value['only_usdt_invest_amount'])) {
					$update_fields['usdt_invest_amount'] = $usdt;
					$update_fields['only_usdt_invest_amount'] = $usdt;  //for chart view
				} //end if ($total == $parents_executed ) 
			
				echo"<br><pre>";
				print_r($update_fields);

				$collection_name = 'opportunity_logs_binance';
				$countcheck = $db->$collection_name->count($search_update);

				echo "<br>count check =====>>>>>..".$countcheck;
				$check = $db->$collection_name->updateOne($search_update,  ['$set' => $update_fields]);
				echo "<br>modified count: ".$check->getModifiedCount();
				

				// echo "<br>modified count: ". $upateCheck->getModifiedCount();
			}
		} //end foreach
		echo "<br>current time".$current_date_time;
		echo "<br>SuccessFully Done!!!";

	} //end cron

	/////////////////////////////////////////////////////////////////////////////
	//////////////////////            ASIM CRONE KRAKEN          ////////////////
	/////////////////////////////////////////////////////////////////////////////						
	public function insert_latest_oppertunity_into_log_collection_kraken(){
		$marketPrices = marketPrices('kraken');					
		$this->load->helper('new_common_helper');    
		foreach($marketPrices as $price){
			if($price['_id'] == 'XRPBTC'){          
				$xrpbtc = (float)$price['price'];
			}elseif($price['_id'] == 'BTCUSDT'){
				$btcusdt = (float)$price['price'];
			}elseif($price['_id'] == 'LINKBTC'){
				$linkbtc = (float)$price['price'];
			}elseif($price['_id'] == 'XLMBTC'){
				$xlmbtc = (float)$price['price'];
			}elseif($price['_id'] == 'ETHBTC'){
				$ethbtc = (float)$price['price'];
			}elseif($price['_id'] == 'XMRBTC'){
				$xmrbtc = (float)$price['price'];
			}elseif($price['_id'] == 'ADABTC'){
				$adabtc = (float)$price['price'];
			}elseif($price['_id'] == 'QTUMBTC'){
				$qtumbtc = (float)$price['price'];
			}elseif($price['_id'] == 'TRXBTC'){
				$trxbtc = (float)$price['price'];
			}elseif($price['_id'] == 'XRPUSDT'){
				$xrpusdt = (float)$price['price'];
			}elseif($price['_id'] == 'LTCUSDT'){
				$ltcusdt = (float)$price['price'];
			}elseif($price['_id'] == 'EOSBTC'){      
				$eosbtc = (float)$price['price'];
			}elseif($price['_id'] == 'EOSUSDT'){      
				$eosusdt = (float)$price['price'];
			}elseif($price['_id'] == 'ETCBTC'){       
				$etcbtc = (float)$price['price'];
			}elseif($price['_id'] == 'DASHBTC'){       
				$dashbtc = (float)$price['price'];
			}elseif($price['_id'] == 'DOTUSDT'){       
				$dotusdt = (float)$price['price'];
			}elseif($price['_id'] == 'ETHUSDT'){       
				$ethusdt = (float)$price['price'];
			}

		}  
		$current_date_time =  date('Y-m-d H:i:s');
		$current_time_date =  $this->mongo_db->converToMongodttime($current_date_time);
		
		$current_hour =  date('Y-m-d H:i:s', strtotime('-40 minutes'));
		$orig_date1 = $this->mongo_db->converToMongodttime($current_hour);

		$previous_one_month_date_time = date('Y-m-d H:i:s', strtotime(' - 1 month'));
		// $previous_one_month_date_time = date('Y-01-1 00:00:00');
		$pre_date_1 =  $this->mongo_db->converToMongodttime($previous_one_month_date_time);

		$connection = $this->mongo_db->customQuery();      
		$condition = array('sort' => array('created_date' => -1), 'limit'=>3);

		if(!empty($this->input->get())){
			$where['opportunity_id'] = $this->input->get('opportunityId');
		}else{
			$where['mode'] ='live';
			$where['created_date'] = array('$gte'=>$pre_date_1);
			$where['level'] = array('$ne'=>'level_15');
			$where['is_modified'] = array('$exists'=>false);
			$where['modified_date'] = array('$lte'=>$orig_date1);
		}  
		
		$find_rec = $connection->opportunity_logs_kraken->find($where,  $condition);
		$response = iterator_to_array($find_rec);

		foreach ($response as $value){
			$coin= $value['coin'];
			if(isset($value['sendHitTime']) && !empty($value['sendHitTime'])){
				// $sendHitTime = $value['sendHitTime'];
				$sendHitTime    = strtotime($value['sendHitTime']->toDateTime()->format('Y-m-d H:i:s'));

			}else{
				// $sendHitTime = $value['created_date'];
				$sendHitTime    = strtotime($value['created_date']->toDateTime()->format('Y-m-d H:i:s'));
			}
			$start_date = $value['created_date']->toDateTime()->format("Y-m-d H:i:s");
			$timestamp = strtotime($start_date);
			$time = $timestamp + (5 * 60 * 60);
			$end_date = date("Y-m-d H:i:s", $time);

			$hours_10 = $timestamp + (10 * 60 * 60);
			$time_10_hours = date("Y-m-d H:i:s", $hours_10);

			$cidition_check = $this->mongo_db->converToMongodttime($end_date);
			$cidition_check_10 = $this->mongo_db->converToMongodttime($time_10_hours);
			$params =[];
			$params = [
			'coin'       => $value['coin'],
			'start_date' => (string)$start_date,
			'end_date'   => (string)$end_date,
			];
			
			if($cidition_check <= $current_time_date){
				$jsondata = json_encode($params);
				$curl = curl_init();
				curl_setopt_array($curl, array(	
					CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS =>$jsondata,
					CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
				));
				$response_price = curl_exec($curl);	
				curl_close($curl);                                
				$api_response = json_decode($response_price);
			} // main if check for time comapire
			$params_10_hours = [];
			$params_10_hours = [
				'coin'       => $value['coin'],
				'start_date' => (string)$start_date,
				'end_date'   => (string)$time_10_hours,
			];
			if($cidition_check_10 <= $current_time_date){
				$jsondata = json_encode($params_10_hours);
					$curl_10 = curl_init();
					curl_setopt_array($curl_10, array(
					CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS =>$jsondata,
					CURLOPT_HTTPHEADER => array(
						"Content-Type: application/json"
					), 
					));
					$response_price_10 = curl_exec($curl_10);	
					curl_close($curl_10);
					$api_response_10 = json_decode($response_price_10);
					//echo "<pre>";print_r($api_response_10);
			}
			if ($value['level'] != 'level_15' ){
				$open_lth_avg_per_trade = 0;
				$open_lth_avg = 0;
				$avg_sold = 0;
				$parents_executed = 0;
				$parents_executed = $value['parents_executed'];
				
				$search_update['opportunity_id'] = $value['opportunity_id'];
				$search_update['mode']= 'live';
				//////////////////////////////////////////////////////////////
				$other['application_mode']= 'live';
				$other['opportunityId'] =  $value['opportunity_id'];
				$other['status'] = array('$nin' => array('LTH', 'FILLED','canceled','new_ERROR'));
				$buyOther = $connection->buy_orders_kraken->count($other);

				$otherSold['application_mode']= 'live';
				$otherSold['opportunityId'] =  $value['opportunity_id'];
				$otherSold['is_sell_order'] = array('$nin' => array('sold'));
				$otherStatusSold = $connection->sold_buy_orders_kraken->count($otherSold);
				$totalOther = $buyOther + $otherStatusSold;
				/////////////////////////////////////////////////////////

				$search_open_lth['application_mode']		= 	'live';
				$search_open_lth['opportunityId'] 			= 	$value['opportunity_id'];
				$search_open_lth['status']					= 	array('$in' => array('LTH', 'FILLED'));
				$search_open_lth['resume_status']['$ne'] 	= 	'resume';
				$search_open_lth['cost_avg']['$ne'] 		= 	'yes';
				$search_open_lth['cavg_parent']['$ne'] 		= 	'yes';
				$search_open_lth['cavg_parent'] 			= 	['$exists' => false];
				$search_open_lth['cost_avg']				=	['$nin' => ['yes', 'completed', '']];

				print_r("<br>oppertunity_id=".$value['opportunity_id']);

				/////
				$search_cancel['application_mode']	= 'live';
				$search_cancel['opportunityId'] 	= $value['opportunity_id'];
				$search_cancel['status'] 			= array('$in' => array('canceled'));
				$search_cancel['cavg_parent'] 		= 	['$exists' => false];
				$search_cancel['cost_avg']			=	['$nin' => ['yes', 'completed', '']];
				//////
				$search_new_error['application_mode']		= 	'live';
				$search_new_error['opportunityId'] 			= 	$value['opportunity_id'];
				$search_new_error['status'] 				= 	array('$in' => array('new_ERROR'));
				$search_new_error['cavg_parent'] 			= 	['$exists' => false];
				$search_new_error['cost_avg']				=	['$nin' => ['yes', 'completed', '']];
				////////
				$search_sold['application_mode']		= 	'live';
				$search_sold['opportunityId'] 			= 	$value['opportunity_id'];
				$search_sold['is_sell_order'] 			= 	'sold';
				$search_sold['cavg_parent'] 			= 	['$exists' => false];
				$search_sold['cost_avg']				=	['$nin' => ['yes', 'completed', '']];

				$search_resumed['application_mode']		= 	'live';
				$search_resumed['opportunityId'] 		= 	$value['opportunity_id'];
				$search_resumed['resume_status'] 		= 	array('$in' => array('resume'));
				$search_resumed['cavg_parent'] 			= 	['$exists' => false];
				$search_resumed['cost_avg']				=	['$nin' => ['yes', 'completed', '']];

				$this->mongo_db->where($search_resumed);
				$total_reumed = $this->mongo_db->get('buy_orders_kraken');
				$total_reumed_order   = iterator_to_array($total_reumed);   

				$this->mongo_db->where($search_resumed);
				$total_reumed_sold = $this->mongo_db->get('sold_buy_orders_kraken');
				$total_reumed_sold_orders   = iterator_to_array($total_reumed_sold);

				$minPriceLookUp = [
					[
						'$match' => [
							'application_mode' => 'live',
							'opportunityId'    =>  $value['opportunity_id'],
							'is_sell_order'    =>  'sold'
							]
					],

					[
						'$group' =>[
							'_id' => '$symbol',
							'minPrice' => ['$min' => '$market_sold_price']
						]
					],

				];
	
				$minSoldPrice = $connection->sold_buy_orders_kraken->aggregate($minPriceLookUp);
				$soldMinPrice  = iterator_to_array($minSoldPrice);

				$maxPriceLookUp = [
					[
						'$match' => [
							'application_mode' => 'live',
							'opportunityId'    =>  $value['opportunity_id'],
							'is_sell_order'    =>  'sold'
						]
					],

					[
						'$group' =>[
							'_id' => '$symbol',
							'maxPrice' => ['$max' => '$market_sold_price']
						]
					],

				];

				$maxSoldPrice = $connection->sold_buy_orders_kraken->aggregate($maxPriceLookUp);
				$soldMaxPrice  = iterator_to_array($maxSoldPrice);

				/////////////////////////////////////////////////////////////// 
				$cosAvg['application_mode'] = 'live';
				$cosAvg['opportunityId']    = $value['opportunity_id'];
				$cosAvg['cost_avg']['$ne']  = 'completed';
				$cosAvg['cavg_parent']      = 'yes';

				$cosAvgSold['application_mode']   =  'live';
				$cosAvgSold['opportunityId']      =  $value['opportunity_id'];
				$cosAvgSold['is_sell_order']      =  'sold';
				$cosAvgSold['cost_avg']           =  'completed';
				$cosAvgSold['cavg_parent']        =  'yes';

				$costAvgReturn = $connection->buy_orders_kraken->count($cosAvg);
				$soldCostAvgReturn = $connection->sold_buy_orders_kraken->count($cosAvgSold); 
				///////////////////////////////////////////////////////////////

				$this->mongo_db->where($search_open_lth);
				$total_open = $this->mongo_db->get('buy_orders_kraken');
				$total_open_lth_rec   = iterator_to_array($total_open);

				$this->mongo_db->where($search_cancel);
				$total_cancel = $this->mongo_db->get('buy_orders_kraken');
				$total_cancel_rec   = iterator_to_array($total_cancel);

				$this->mongo_db->where($search_new_error);
				$total_new_error = $this->mongo_db->get('buy_orders_kraken');
				$total_new_error_rec   = iterator_to_array($total_new_error);

				$this->mongo_db->where($search_sold);
				$total_sold_total = $this->mongo_db->get('sold_buy_orders_kraken');
				$total_sold_rec   = iterator_to_array($total_sold_total);
				
				$open_lth_puchase_price = 0;
				$open_lth_avg = 0;
				$btc = 0;
				$usdt = 0;

				$buySumTimeDelayRange1 = 0;
				$buySumTimeDelayRange2 = 0;
				$buySumTimeDelayRange3 = 0;
				$buySumTimeDelayRange4 = 0;
				$buySumTimeDelayRange5 = 0;
				$buySumTimeDelayRange6 = 0;
				$buySumTimeDelayRange7 = 0;
				$buy_commision_bnb = 0;
				$buy_fee_respected_coin = 0;

				$open_lth_avg_per_trade= 0;
				echo"<br>Total open lth = ".count($total_open_lth_rec);
				if (count($total_open_lth_rec) > 0){
					echo "<br> Open/lth Calculation";
					foreach ($total_open_lth_rec as $key => $value2){
						$commission_array = $value2['buy_fraction_filled_order_arr'];
						if($value2['symbol'] == 'ETHBTC'){    
							$open_lth_puchase_price += (float) ($ethbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];
							echo "<br> btc = ".$btc;

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'BTCUSDT'){
							$open_lth_puchase_price += (float) ($btcusdt - $value2['purchased_price']) / $value2['purchased_price'] ;  
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];
							echo "<br> usdt = ".$usdt;
							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}
						}elseif($value2['symbol'] == 'XRPBTC'){
							$open_lth_puchase_price += (float) ($xrpbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];
							echo "<br> btc = ".$btc;

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}
						}elseif($value2['symbol'] == 'XRPUSDT'){
							$open_lth_puchase_price += (float) ($xrpusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];
							echo "<br> usdt = ".$usdt;

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'LINKBTC'){
							$open_lth_puchase_price += (float) ($linkbtc - $value2['purchased_price']) / $value2['purchased_price'];;
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];


							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XLMBTC'){
							$open_lth_puchase_price += (float) ($xlmbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XMRBTC'){
							$open_lth_puchase_price += (float) ($xmrbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'ADABTC'){
							$open_lth_puchase_price += (float) ($adabtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'QTUMBTC'){
							$open_lth_puchase_price += (float) ($qtumbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'TRXBTC'){
							$open_lth_puchase_price += (float) ($trxbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'LTCUSDT'){
							$open_lth_puchase_price += (float) ($ltcusdt - $value2['purchased_price']) / $value2['purchased_price'];
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'ETHUSDT'){
							$open_lth_puchase_price += (float) ($ethusdt - $value2['purchased_price']) / $value2['purchased_price'];
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'DOTUSDT'){
							$open_lth_puchase_price += (float) ($dotusdt - $value2['purchased_price']) / $value2['purchased_price'];
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'EOSBTC'){
							$open_lth_puchase_price += (float) ($eosbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'ETCBTC'){
							$open_lth_puchase_price += (float) ($etcbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'EOSUSDT'){
							$open_lth_puchase_price += (float) ($eosusdt - $value2['purchased_price']) / $value2['purchased_price'];
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'DASHBTC'){  
							$open_lth_puchase_price += (float) ($dashbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}			    

						if( isset($value2['created_date']) && !empty($value2['created_date']) ){

							$orderBUyTime  		= strtotime($value2['created_date']->toDateTime()->format('Y-m-d H:i:s'));

							$differenceBuyInSec = ($orderBUyTime - $sendHitTime);
						}else{
							$differenceBuyInSec = 0;
						}
						if($differenceBuyInSec >= 0 && $differenceBuyInSec < 15 ){
                          	$buySumTimeDelayRange1++; 
						}elseif($differenceBuyInSec >= 15 && $differenceBuyInSec < 30){
							$buySumTimeDelayRange2++;
						}elseif($differenceBuyInSec >= 30 && $differenceBuyInSec < 45){
							$buySumTimeDelayRange3++;
						}elseif($differenceBuyInSec >= 45 && $differenceBuyInSec < 60){
							$buySumTimeDelayRange4++;
						}elseif($differenceBuyInSec >= 60 && $differenceBuyInSec < 75){
							$buySumTimeDelayRange5++;
						}elseif($differenceBuyInSec >= 75 && $differenceBuyInSec < 90 ){
							$buySumTimeDelayRange6++;
						}elseif($differenceBuyInSec >= 90){
							$buySumTimeDelayRange7++;
						}

					}//end loop
					$open_lth_avg_per_trade = (float) $open_lth_puchase_price * 100;
					$open_lth_avg = (float) ($open_lth_avg_per_trade / count($total_open_lth_rec));
				}//end if
		
				$sold_puchase_price = 0;
				$avg_sold_CSL = 0;
				$CSL_per_trade_sold = 0;
				$CSL_sold_purchase_price = 0 ;
				$avg_manul = 0;
				$per_trade_sold_manul = 0;
				$manul_sold_purchase_price = 0;
				$avg_sold = 0;
				$per_trade_sold = 0;

				$sumTimeDelayRange1 = 0;
				$sumTimeDelayRange2 = 0;
				$sumTimeDelayRange3 = 0;
				$sumTimeDelayRange4 = 0;
				$sumTimeDelayRange5 = 0;
				$sumTimeDelayRange6 = 0;
				$sumTimeDelayRange7 = 0;

				$sumPLSllipageRange1 = 0;
				$sumPLSllipageRange2 = 0;
				$sumPLSllipageRange3 = 0;
				$sumPLSllipageRange4 = 0;
				$sumPLSllipageRange5 = 0;
				$sell_fee_respected_coin = 0;
				$sell_comssion_bnb = 0;
				$btc_sell  = 0;
				$usdt_sell = 0;

				if (count($total_sold_rec) > 0){
					echo "<br> sold calculation";
					foreach ($total_sold_rec as $key => $value1){
						$commission_sold_array = $value1['buy_fraction_filled_order_arr'];
						$sell_commission_sold_array = $value1['sell_fraction_filled_order_arr'];
						if($value1['symbol'] == 'ETHBTC'){ 
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}
						}elseif($value1['symbol'] == 'XRPBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'NEOBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];


							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'QTUMBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];


							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'XLMBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'TRXBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'ETCBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'EOSBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'LINKBTC'){  
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'XMRBTC'){  
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'ADABTC'){       
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'LTCUSDT'){        
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							$usdt_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'ETHUSDT'){        
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							$usdt_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'DOTUSDT'){        
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							$usdt_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'BTCUSDT'){    
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							$usdt_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'DASHBTC'){  
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sold_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}
						if(isset($value1['is_manual_sold'])){
							$manul_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];

						}elseif(isset($value1['csl_sold'])){
							$CSL_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
						}else{
							$sold_puchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];

						}

						if(isset($value1['order_send_time']) && isset($value1['sell_date']) && !empty($value1['order_send_time']) && !empty($value1['sell_date']) && $value1['is_sell_order'] == "sold"){

							$filledTime     = strtotime($value1['sell_date']->toDateTime()->format('Y-m-d H:i:s'));
							$orderSendTime  = strtotime($value1['order_send_time']->toDateTime()->format('Y-m-d H:i:s'));

							$differenceInSec = ($filledTime - $orderSendTime);
						}else{
							$differenceInSec = 0;
						}
						if($differenceInSec >= 0 && $differenceInSec < 15 ){
                          	$sumTimeDelayRange1++; 
						}elseif($differenceInSec >= 15 && $differenceInSec < 30){
							$sumTimeDelayRange2++;
						}elseif($differenceInSec >= 30 && $differenceInSec < 45){
							$sumTimeDelayRange3++;
						}elseif($differenceInSec >= 45 && $differenceInSec < 60){
							$sumTimeDelayRange4++;
						}elseif($differenceInSec >= 60 && $differenceInSec < 75){
							$sumTimeDelayRange5++;
						}elseif($differenceInSec >= 75 && $differenceInSec < 90 ){
							$sumTimeDelayRange6++;
						}elseif($differenceInSec >= 90){
							$sumTimeDelayRange7++;
						}


						if( isset($value1['created_date']) && !empty($value1['created_date']) ){

							$orderBUyTime  		= strtotime($value1['created_date']->toDateTime()->format('Y-m-d H:i:s'));

							$differenceBuyInSec = ($orderBUyTime - $sendHitTime);
						}else{
							$differenceBuyInSec = 0;
						}
						if($differenceBuyInSec >= 0 && $differenceBuyInSec < 15 ){
                          	$buySumTimeDelayRange1++; 
						}elseif($differenceBuyInSec >= 15 && $differenceBuyInSec < 30){
							$buySumTimeDelayRange2++;
						}elseif($differenceBuyInSec >= 30 && $differenceBuyInSec < 45){
							$buySumTimeDelayRange3++;
						}elseif($differenceBuyInSec >= 45 && $differenceBuyInSec < 60){
							$buySumTimeDelayRange4++;
						}elseif($differenceBuyInSec >= 60 && $differenceBuyInSec < 75){
							$buySumTimeDelayRange5++;
						}elseif($differenceBuyInSec >= 75 && $differenceBuyInSec < 90 ){
							$buySumTimeDelayRange6++;
						}elseif($differenceBuyInSec >= 90){
							$buySumTimeDelayRange7++;
						}

						// sold Pl slippage calculate
						if(isset($value1['sell_market_price']) && $value1['is_sell_order'] == 'sold' && $value1['sell_market_price'] !="" && !is_string($value1['sell_market_price'])){
							$val1 = $value1['market_sold_price'] - $value1['sell_market_price']; 
							$val2 = ($value1['market_sold_price'] + $value1['sell_market_price'])/ 2;
							$slippageOrignalPercentage = ($val1/ $val2) * 100;
							$slippageOrignalPercentage = round($slippageOrignalPercentage, 3) . '%';
						}else{
							$slippageOrignalPercentage = 0;
						}

						if($slippageOrignalPercentage > 0){
							$slippageOrignalPercentage = 0;
						}

						if($slippageOrignalPercentage <= 0 && $slippageOrignalPercentage > -0.2 ){

                          	$sumPLSllipageRange1++; 
						}elseif($slippageOrignalPercentage <= -0.2 && $slippageOrignalPercentage > -0.3){
							
							$sumPLSllipageRange2++;
						}elseif($slippageOrignalPercentage <= -0.3 && $slippageOrignalPercentage > -0.5){
							
							$sumPLSllipageRange3++;
						}elseif($slippageOrignalPercentage <= -0.5 && $slippageOrignalPercentage > -0.75){
							
							$sumPLSllipageRange4++;
						}elseif($slippageOrignalPercentage <= -1 ){
							
							$sumPLSllipageRange5++;
						}
						
					} //end sold foreach
					if($manul_sold_purchase_price > 0){
						$sold_puchase_price += $manul_sold_purchase_price;
						$manul_sold_purchase_price = 0;
					}
					if($CSL_sold_purchase_price > 0)
					{
						$sold_puchase_price += $CSL_sold_purchase_price;
						$CSL_sold_purchase_price = 0;
					}
					if($manul_sold_purchase_price != "0"){
						$per_trade_sold_manul = (float) $manul_sold_purchase_price * 100;
						$avg_manul = (float) ($per_trade_sold_manul / count($total_sold_rec));;
					}
					if($sold_puchase_price !="0"){
						$per_trade_sold = (float) $sold_puchase_price * 100;
						$avg_sold = (float) ($per_trade_sold / count($total_sold_rec)); 
					}
					if($CSL_sold_purchase_price !="0"){
						$CSL_per_trade_sold = (float) $CSL_sold_purchase_price * 100;
						$avg_sold_CSL = (float) ($CSL_per_trade_sold / count($total_sold_rec));
					}
				}// End check >0
					
				$total_orders = count($total_open_lth_rec) + count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $totalOther;
				$disappear = $parents_executed -  $total_orders;
				$total = count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $disappear;
				if ($total == $parents_executed){

					$sell_commision_qty_USDT =   ($sell_fee_respected_coin > 0)  ? convertCoinBalanceIntoUSDT($value['coin'], $sell_fee_respected_coin, 'kraken') : 0;
					$update_fields = array(
						'open_lth'     => count($total_open_lth_rec),
						'new_error'    => count($total_new_error_rec),
						'cancelled'    => count($total_cancel_rec),
						'costAvgCount' => ($costAvgReturn + $soldCostAvgReturn),
						'sold'         => count($total_sold_rec),
						'reumed_child' => count($total_reumed_order) + count($total_reumed_sold_orders),
						'avg_open_lth' => $open_lth_avg,
						'other_status' => $totalOther,
						'avg_sold'     => $avg_sold,
						'per_trade_sold' => $per_trade_sold,
						'minOrderSoldPrice' => $soldMinPrice[0]['minPrice'],
						'maxOrderSoldPrice' => $soldMaxPrice[0]['maxPrice'],
						'avg_manul'    =>$avg_manul,
						'sellTimeDiffRange1' 	=>	$sumTimeDelayRange1 ,
						'sellTimeDiffRange2' 	=>	$sumTimeDelayRange2 ,
						'sellTimeDiffRange3' 	=> 	$sumTimeDelayRange3 ,
						'sellTimeDiffRange4' 	=>	$sumTimeDelayRange4 ,
						'sellTimeDiffRange5' 	=> 	$sumTimeDelayRange5 ,
						'sellTimeDiffRange6' 	=>	$sumTimeDelayRange6 ,
						'sellTimeDiffRange7' 	=>	$sumTimeDelayRange7 ,

						'buySumTimeDelayRange1' => $buySumTimeDelayRange1 ,
						'buySumTimeDelayRange2' => $buySumTimeDelayRange2 ,
						'buySumTimeDelayRange3' => $buySumTimeDelayRange3 ,
						'buySumTimeDelayRange4' => $buySumTimeDelayRange4 ,
						'buySumTimeDelayRange5' => $buySumTimeDelayRange5 ,
						'buySumTimeDelayRange6' => $buySumTimeDelayRange6 ,
						'buySumTimeDelayRange7' => $buySumTimeDelayRange7 ,

						'sumPLSllipageRange1' 	=> $sumPLSllipageRange1 ,
						'sumPLSllipageRange2' 	=> $sumPLSllipageRange2 ,
						'sumPLSllipageRange3'	=> $sumPLSllipageRange3 ,
						'sumPLSllipageRange4' 	=> $sumPLSllipageRange4 ,
						'sumPLSllipageRange5' 	=> $sumPLSllipageRange5 ,
						'sell_commission' 		=> $sell_comssion_bnb,
						'sell_commision_qty_USDT' => $sell_commision_qty_USDT,
						'sell_fee_respected_coin' => $sell_fee_respected_coin,

						'avg_sold_CSL' 			=> $avg_sold_CSL,
						'modified_date' 		=> $current_time_date  
					);

					if(isset($value['10_max_value']) && isset($value['5_max_value'])){
						$update_fields['is_modified']  = true;
					}
					if(count($total_open_lth_rec)== 0 && count($total_sold_rec) == 0 &&  $totalOther == 0 ){
						$update_fields['oppertunity_missed'] = true;
					}
				}else{ 
					$update_fields = array(
						'open_lth'     => count($total_open_lth_rec),
						'new_error'    => count($total_new_error_rec),
						'cancelled'    => count($total_cancel_rec),
						'sold'         => count($total_sold_rec),
						'avg_open_lth' => $open_lth_avg,
						'costAvgCount' => ($costAvgReturn + $soldCostAvgReturn),
						'avg_sold'     => $avg_sold,
						'per_trade_sold' => $per_trade_sold,
						'minOrderSoldPrice' => $soldMinPrice[0]['minPrice'],
						'maxOrderSoldPrice' => $soldMaxPrice[0]['maxPrice'],
						'reumed_child' => count($total_reumed_order) + count($total_reumed_sold_orders),
						'other_status' => $totalOther,  
						'sellTimeDiffRange1' 	=>	$sumTimeDelayRange1 ,
						'sellTimeDiffRange2' 	=>	$sumTimeDelayRange2 ,
						'sellTimeDiffRange3' 	=> 	$sumTimeDelayRange3 ,
						'sellTimeDiffRange4' 	=>	$sumTimeDelayRange4 ,
						'sellTimeDiffRange5' 	=> 	$sumTimeDelayRange5 ,
						'sellTimeDiffRange6' 	=>	$sumTimeDelayRange6 ,
						'sellTimeDiffRange7' 	=>	$sumTimeDelayRange7 , 

						'buySumTimeDelayRange1' => $buySumTimeDelayRange1 ,
						'buySumTimeDelayRange2' => $buySumTimeDelayRange2 ,
						'buySumTimeDelayRange3' => $buySumTimeDelayRange3 ,
						'buySumTimeDelayRange4' => $buySumTimeDelayRange4 ,
						'buySumTimeDelayRange5' => $buySumTimeDelayRange5 ,
						'buySumTimeDelayRange6' => $buySumTimeDelayRange6 ,
						'buySumTimeDelayRange7' => $buySumTimeDelayRange7 ,

						'sumPLSllipageRange1' 	=> $sumPLSllipageRange1 ,
						'sumPLSllipageRange2' 	=> $sumPLSllipageRange2 ,
						'sumPLSllipageRange3'	=> $sumPLSllipageRange3 ,
						'sumPLSllipageRange4' 	=> $sumPLSllipageRange4 ,
						'sumPLSllipageRange5' 	=> $sumPLSllipageRange5 ,

						'avg_manul'    =>$avg_manul,
						'avg_sold_CSL' => $avg_sold_CSL,
						'modified_date'=>$current_time_date
					);
				}

				$sell_btc_converted = ($btc_sell > 0)  ? convertCoinBalanceIntoUSDT($value['coin'], $btc_sell, 'kraken') : 0;
				$update_fields['sell_btc_in_$'] =   (float)$sell_btc_converted;
				$update_fields['sell_usdt']   	=   (float)$usdt_sell;
				$update_fields['total_sell_in_usdt'] = (float)($sell_btc_converted + $usdt_sell );

				if($buy_fee_respected_coin > 0 && !isset($value['buy_commision_qty']) && !isset($value['is_modified'])){
					$update_fields['buy_commision_qty'] = $buy_fee_respected_coin;
					$update_fields['buy_commision_qty_USDT'] =   ($buy_fee_respected_coin > 0)  ? convertCoinBalanceIntoUSDT($value['coin'], $buy_fee_respected_coin, 'kraken') : 0;
				}
				if($buy_commision_bnb > 0 && !isset($value['buy_commision']) && !isset($value['is_modified'])){
					$update_fields['buy_commision'] = $buy_commision_bnb;
					echo"total commision = BNB ".$buy_commision_bnb;
				}

				$db = $this->mongo_db->customQuery();
				$pipeline = [
					[
						'$match' =>[
						'application_mode' => 'live',
						'parent_status' => ['$exists' => false ],
						'opportunityId' => $value['opportunity_id'],
						'status' => ['$in'=>['LTH','FILLED']],
						],
					],
					[
					'$sort' =>['created_date'=> -1],
					],
					['$limit'=>1]
				];
				$result_buy = $db->buy_orders_kraken->aggregate($pipeline);
				$res = iterator_to_array($result_buy);

				$pipeline1 = [
					[
						'$match' =>[
						'application_mode' => 'live',
						'parent_status' => ['$exists' => false ],
						'opportunityId' => $value['opportunity_id'],
						'status' => ['$in'=>['LTH','FILLED']],
						],
					],
					[
					'$sort' =>['created_date'=> 1],
					],
					['$limit'=>1]
				];
				$result_buy1 = $db->buy_orders_kraken->aggregate($pipeline1);
				$res1 = iterator_to_array($result_buy1);
				if(!isset($value['first_order_buy']) && !isset($value['last_order_buy'])){
					$update_fields['first_order_buy'] =  $res[0]['created_date'];
					$update_fields['last_order_buy'] =  $res1[0]['created_date'];
				}
				if(!isset($value['opp_came_binance']) && !isset($value['opp_came_kraken']) && !isset($value['opp_came_bam'])){	
					$opper_search['application_mode']= 'live';
					$opper_search['opportunityId'] = $value['opportunity_id'];
					
					$connetct= $this->mongo_db->customQuery();

					$pending_curser = $connetct->buy_orders->find($opper_search);
					$buy_order = iterator_to_array($pending_curser);
					echo "<br>result binance=".count($buy_order);

					$pending_curser_buy = $connetct->sold_buy_order->find($opper_search);
					$sold_bbuy_order = iterator_to_array($pending_curser_buy);
					echo "<br>result binance sold=".count($sold_bbuy_order);

					if(count($buy_order) > 0 || count($sold_bbuy_order) > 0 ){
						$update_fields['opp_came_binance'] = '1';
					}else{
						$update_fields['opp_came_binance'] = '0';
					}
					
					$this->mongo_db->where($opper_search);
					$response_kraken = $this->mongo_db->get('buy_orders_kraken');
					$data_kraken = iterator_to_array($response_kraken);

					$this->mongo_db->where($opper_search);
					$response_kraken_sold = $this->mongo_db->get('sold_buy_orders_kraken');
					$data_kraken_sold = iterator_to_array($response_kraken_sold);
					if(count($data_kraken) > 0 || count($data_kraken_sold) > 0){
						$update_fields['opp_came_kraken'] = '1';
					}else{
						$update_fields['opp_came_kraken'] = '0';
					}
					
					$this->mongo_db->where($opper_search);
					$response_bam = $this->mongo_db->get('buy_orders_bam');
					$data_bam = iterator_to_array($response_bam);

					$this->mongo_db->where($opper_search);
					$response_bam_sold = $this->mongo_db->get('sold_buy_orders_bam');
					$data_bam_sold = iterator_to_array($response_bam_sold);

					if(count($data_bam) > 0 || count($data_bam_sold) > 0){
						$update_fields['opp_came_bam'] = '1';
					}else{
						$update_fields['opp_came_bam'] = '0';
					}
				}

				if($btc > "0" && $usdt == "0" && !isset($value['usdt_invest_amount']) &&  !isset($value['btc_invest_amount'])){
					$update_fields['usdt_invest_amount'] = $btcusdt * $btc;
					$update_fields['btc_invest_amount']  = $btc;  //for chart view 
				}
				elseif($usdt > "0" && $btc == "0" && !isset($value['usdt_invest_amount']) && !isset($value['only_usdt_invest_amount'])) {
					$update_fields['usdt_invest_amount'] = $usdt;
					$update_fields['only_usdt_invest_amount'] = $usdt;  //for chart view
				} 

				foreach($api_response as $as_1){
					echo "testing".$as_1;
					if($as_1->max_price !='' && $as_1->min_price !='' && $as_1->min_price != 0 && $as_1->max_price != 0){
						$update_fields['5_max_value'] = $as_1->max_price;
						$update_fields['5_min_value'] = $as_1->min_price;  
					} //loop inner check				
				} // foreach loop end
				foreach($api_response_10 as $as){
					if($as->max_price !='' && $as->min_price !='' && $as->min_price !=0 && $as->max_price !=0){
						$update_fields['10_max_value'] = $as->max_price; 
						$update_fields['10_min_value'] = $as->min_price;
					} // if inner check	
				} //end foreach loop
				echo"<br><pre>";
				print_r($update_fields);
				$collection_name = 'opportunity_logs_kraken';
				$this->mongo_db->where($search_update);
				$this->mongo_db->set($update_fields);
				$this->mongo_db->update($collection_name);
			}
		} //end foreach
		echo "<br>Total Picked Oppertunities Ids= ".count($response);
		//Save last Cron Executioon
		$this->last_cron_execution_time('kraken live opportunity', '1m', 'run kraken live opportunity logs (* * * * *)','reports');
	} //end cron


	public function insert_latest_oppertunity_into_log_collection_kraken_for_old_opportunities(){
		$marketPrices = marketPrices('kraken');					
		$this->load->helper('new_common_helper');    
		foreach($marketPrices as $price){
			if($price['_id'] == 'XRPBTC'){          
				$xrpbtc = (float)$price['price'];
			}elseif($price['_id'] == 'BTCUSDT'){
				$btcusdt = (float)$price['price'];
			}elseif($price['_id'] == 'LINKBTC'){
				$linkbtc = (float)$price['price'];
			}elseif($price['_id'] == 'XLMBTC'){
				$xlmbtc = (float)$price['price'];
			}elseif($price['_id'] == 'ETHBTC'){
				$ethbtc = (float)$price['price'];
			}elseif($price['_id'] == 'XMRBTC'){
				$xmrbtc = (float)$price['price'];
			}elseif($price['_id'] == 'ADABTC'){
				$adabtc = (float)$price['price'];
			}elseif($price['_id'] == 'QTUMBTC'){
				$qtumbtc = (float)$price['price'];
			}elseif($price['_id'] == 'TRXBTC'){
				$trxbtc = (float)$price['price'];
			}elseif($price['_id'] == 'XRPUSDT'){
				$xrpusdt = (float)$price['price'];
			}elseif($price['_id'] == 'LTCUSDT'){
				$ltcusdt = (float)$price['price'];
			}elseif($price['_id'] == 'EOSBTC'){      
				$eosbtc = (float)$price['price'];
			}elseif($price['_id'] == 'EOSUSDT'){      
				$eosusdt = (float)$price['price'];
			}elseif($price['_id'] == 'ETCBTC'){       
				$etcbtc = (float)$price['price'];
			}elseif($price['_id'] == 'DASHBTC'){       
				$dashbtc = (float)$price['price'];
			}elseif($price['_id'] == 'DOTUSDT'){       
				$dotusdt = (float)$price['price'];
			}elseif($price['_id'] == 'ETHUSDT'){       
				$ethusdt = (float)$price['price'];
			}

		}  
		$current_date_time =  date('Y-m-d H:i:s');
		$current_time_date =  $this->mongo_db->converToMongodttime($current_date_time);

		$startTime =  date('Y-01-d H:i:s');
		$startTime =  $this->mongo_db->converToMongodttime($startTime);

		$current_hour =  date('Y-m-d H:i:s', strtotime('-1 month'));
		$orig_date1 = $this->mongo_db->converToMongodttime($current_hour);

		$previous_one_month_date_time = date('Y-m-d H:i:s', strtotime(' -1 month'));
		$endTime =  $this->mongo_db->converToMongodttime($previous_one_month_date_time);

		$connection = $this->mongo_db->customQuery();      
		$condition = array('sort' => array('modified_date' => -1), 'limit' => 15);

		$where['mode'] 			=	'live';
		$where['created_date'] 	= 	array( '$gte' => $startTime ,'$lte'=>$endTime);
		$where['level'] 		= 	array('$ne'=>'level_15');
		$where['is_modified'] 	= 	array('$exists'=>false);
		$where['modified_date'] = 	array('$lte'=>$orig_date1);
		 
		$find_rec = $connection->opportunity_logs_kraken->find($where,  $condition);
		$response = iterator_to_array($find_rec);

		foreach ($response as $value){
			$coin= $value['coin'];
			if(isset($value['sendHitTime']) && !empty($value['sendHitTime'])){
				// $sendHitTime = $value['sendHitTime'];
				$sendHitTime    = strtotime($value['sendHitTime']->toDateTime()->format('Y-m-d H:i:s'));

			}else{
				// $sendHitTime = $value['created_date'];
				$sendHitTime    = strtotime($value['created_date']->toDateTime()->format('Y-m-d H:i:s'));
			}

			if ($value['level'] != 'level_15' ){
				$open_lth_avg_per_trade = 0;
				$open_lth_avg = 0;
				$avg_sold = 0;
				$parents_executed = 0;
				$parents_executed = $value['parents_executed'];
				
				$search_update['opportunity_id'] = $value['opportunity_id'];
				$search_update['mode']= 'live';
				//////////////////////////////////////////////////////////////
				$other['application_mode']= 'live';
				$other['opportunityId'] =  $value['opportunity_id'];
				$other['status'] = array('$nin' => array('LTH', 'FILLED','canceled','new_ERROR'));
				$buyOther = $connection->buy_orders_kraken->count($other);

				$otherSold['application_mode']= 'live';
				$otherSold['opportunityId'] =  $value['opportunity_id'];
				$otherSold['is_sell_order'] = array('$nin' => array('sold'));
				$otherStatusSold = $connection->sold_buy_orders_kraken->count($otherSold);
				$totalOther = $buyOther + $otherStatusSold;
				/////////////////////////////////////////////////////////

				$search_open_lth['application_mode']		= 	'live';
				$search_open_lth['opportunityId'] 			= 	$value['opportunity_id'];
				$search_open_lth['status']					= 	array('$in' => array('LTH', 'FILLED'));
				$search_open_lth['resume_status']['$ne'] 	= 	'resume';
				$search_open_lth['cost_avg']['$ne'] 		= 	'yes';
				$search_open_lth['cavg_parent']['$ne'] 		= 	'yes';
				$search_open_lth['cavg_parent'] 			= 	['$exists' => false];
				$search_open_lth['cost_avg']				=	['$nin' => ['yes', 'completed', '']];

				echo"<br>oppertunity_id=".$value['opportunity_id'];

				/////
				$search_cancel['application_mode']	= 'live';
				$search_cancel['opportunityId'] 	= $value['opportunity_id'];
				$search_cancel['status'] 			= array('$in' => array('canceled'));
				$search_cancel['cavg_parent'] 		= 	['$exists' => false];
				$search_cancel['cost_avg']			=	['$nin' => ['yes', 'completed', '']];
				//////
				$search_new_error['application_mode']		= 	'live';
				$search_new_error['opportunityId'] 			= 	$value['opportunity_id'];
				$search_new_error['status'] 				= 	array('$in' => array('new_ERROR'));
				$search_new_error['cavg_parent'] 			= 	['$exists' => false];
				$search_new_error['cost_avg']				=	['$nin' => ['yes', 'completed', '']];
				////////
				$search_sold['application_mode']		= 	'live';
				$search_sold['opportunityId'] 			= 	$value['opportunity_id'];
				$search_sold['is_sell_order'] 			= 	'sold';
				$search_sold['cavg_parent'] 			= 	['$exists' => false];
				$search_sold['cost_avg']				=	['$nin' => ['yes', 'completed', '']];

				$search_resumed['application_mode']		= 	'live';
				$search_resumed['opportunityId'] 		= 	$value['opportunity_id'];
				$search_resumed['resume_status'] 		= 	array('$in' => array('resume'));
				$search_resumed['cavg_parent'] 			= 	['$exists' => false];
				$search_resumed['cost_avg']				=	['$nin' => ['yes', 'completed', '']];

				$this->mongo_db->where($search_resumed);
				$total_reumed = $this->mongo_db->get('buy_orders_kraken');
				$total_reumed_order   = iterator_to_array($total_reumed);   

				$this->mongo_db->where($search_resumed);
				$total_reumed_sold = $this->mongo_db->get('sold_buy_orders_kraken');
				$total_reumed_sold_orders   = iterator_to_array($total_reumed_sold);

				$minPriceLookUp = [
					[
						'$match' => [
							'application_mode' => 'live',
							'opportunityId'    =>  $value['opportunity_id'],
							'is_sell_order'    =>  'sold'
							]
					],

					[
						'$group' =>[
							'_id' => '$symbol',
							'minPrice' => ['$min' => '$market_sold_price']
						]
					],

				];
	
				$minSoldPrice = $connection->sold_buy_orders_kraken->aggregate($minPriceLookUp);
				$soldMinPrice  = iterator_to_array($minSoldPrice);

				$maxPriceLookUp = [
					[
						'$match' => [
							'application_mode' => 'live',
							'opportunityId'    =>  $value['opportunity_id'],
							'is_sell_order'    =>  'sold'
						]
					],

					[
						'$group' =>[
							'_id' => '$symbol',
							'maxPrice' => ['$max' => '$market_sold_price']
						]
					],

				];

				$maxSoldPrice = $connection->sold_buy_orders_kraken->aggregate($maxPriceLookUp);
				$soldMaxPrice  = iterator_to_array($maxSoldPrice);

				/////////////////////////////////////////////////////////////// 
				$cosAvg['application_mode'] = 'live';
				$cosAvg['opportunityId']    = $value['opportunity_id'];
				$cosAvg['cost_avg']['$ne']  = 'completed';
				$cosAvg['cavg_parent']      = 'yes';

				$cosAvgSold['application_mode']   =  'live';
				$cosAvgSold['opportunityId']      =  $value['opportunity_id'];
				$cosAvgSold['is_sell_order']      =  'sold';
				$cosAvgSold['cost_avg']           =  'completed';
				$cosAvgSold['cavg_parent']        =  'yes';

				$costAvgReturn = $connection->buy_orders_kraken->count($cosAvg);
				$soldCostAvgReturn = $connection->sold_buy_orders_kraken->count($cosAvgSold); 
				///////////////////////////////////////////////////////////////

				$this->mongo_db->where($search_open_lth);
				$total_open = $this->mongo_db->get('buy_orders_kraken');
				$total_open_lth_rec   = iterator_to_array($total_open);

				$this->mongo_db->where($search_cancel);
				$total_cancel = $this->mongo_db->get('buy_orders_kraken');
				$total_cancel_rec   = iterator_to_array($total_cancel);

				$this->mongo_db->where($search_new_error);
				$total_new_error = $this->mongo_db->get('buy_orders_kraken');
				$total_new_error_rec   = iterator_to_array($total_new_error);

				$this->mongo_db->where($search_sold);
				$total_sold_total = $this->mongo_db->get('sold_buy_orders_kraken');
				$total_sold_rec   = iterator_to_array($total_sold_total);
				
				$open_lth_puchase_price = 0;
				$open_lth_avg = 0;
				$btc = 0;
				$usdt = 0;

				$buySumTimeDelayRange1 = 0;
				$buySumTimeDelayRange2 = 0;
				$buySumTimeDelayRange3 = 0;
				$buySumTimeDelayRange4 = 0;
				$buySumTimeDelayRange5 = 0;
				$buySumTimeDelayRange6 = 0;
				$buySumTimeDelayRange7 = 0;
				$buy_commision_bnb = 0;
				$buy_fee_respected_coin = 0;

				$open_lth_avg_per_trade= 0;
				if (count($total_open_lth_rec) > 0){
					foreach ($total_open_lth_rec as $key => $value2){
						$commission_array = $value2['buy_fraction_filled_order_arr'];
						if($value2['symbol'] == 'ETHBTC'){    
							$open_lth_puchase_price += (float) ($ethbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'BTCUSDT'){
							$open_lth_puchase_price += (float) ($btcusdt - $value2['purchased_price']) / $value2['purchased_price'] ;  
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];
							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}
						}elseif($value2['symbol'] == 'XRPBTC'){
							$open_lth_puchase_price += (float) ($xrpbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}
						}elseif($value2['symbol'] == 'XRPUSDT'){
							$open_lth_puchase_price += (float) ($xrpusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'LINKBTC'){
							$open_lth_puchase_price += (float) ($linkbtc - $value2['purchased_price']) / $value2['purchased_price'];;
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];


							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XLMBTC'){
							$open_lth_puchase_price += (float) ($xlmbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XMRBTC'){
							$open_lth_puchase_price += (float) ($xmrbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'ADABTC'){
							$open_lth_puchase_price += (float) ($adabtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'QTUMBTC'){
							$open_lth_puchase_price += (float) ($qtumbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'TRXBTC'){
							$open_lth_puchase_price += (float) ($trxbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'LTCUSDT'){
							$open_lth_puchase_price += (float) ($ltcusdt - $value2['purchased_price']) / $value2['purchased_price'];
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'ETHUSDT'){
							$open_lth_puchase_price += (float) ($ethusdt - $value2['purchased_price']) / $value2['purchased_price'];
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'DOTUSDT'){
							$open_lth_puchase_price += (float) ($dotusdt - $value2['purchased_price']) / $value2['purchased_price'];
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'EOSBTC'){
							$open_lth_puchase_price += (float) ($eosbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'ETCBTC'){
							$open_lth_puchase_price += (float) ($etcbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'EOSUSDT'){
							$open_lth_puchase_price += (float) ($eosusdt - $value2['purchased_price']) / $value2['purchased_price'];
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'DASHBTC'){  
							$open_lth_puchase_price += (float) ($dashbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}			    

						if( isset($value2['created_date']) && !empty($value2['created_date']) ){

							$orderBUyTime  		= strtotime($value2['created_date']->toDateTime()->format('Y-m-d H:i:s'));

							$differenceBuyInSec = ($orderBUyTime - $sendHitTime);
						}else{
							$differenceBuyInSec = 0;
						}
						if($differenceBuyInSec >= 0 && $differenceBuyInSec < 15 ){
                          	$buySumTimeDelayRange1++; 
						}elseif($differenceBuyInSec >= 15 && $differenceBuyInSec < 30){
							$buySumTimeDelayRange2++;
						}elseif($differenceBuyInSec >= 30 && $differenceBuyInSec < 45){
							$buySumTimeDelayRange3++;
						}elseif($differenceBuyInSec >= 45 && $differenceBuyInSec < 60){
							$buySumTimeDelayRange4++;
						}elseif($differenceBuyInSec >= 60 && $differenceBuyInSec < 75){
							$buySumTimeDelayRange5++;
						}elseif($differenceBuyInSec >= 75 && $differenceBuyInSec < 90 ){
							$buySumTimeDelayRange6++;
						}elseif($differenceBuyInSec >= 90){
							$buySumTimeDelayRange7++;
						}

					}//end loop
					$open_lth_avg_per_trade = (float) $open_lth_puchase_price * 100;
					$open_lth_avg = (float) ($open_lth_avg_per_trade / count($total_open_lth_rec));
				}//end if
		
				$sold_puchase_price = 0;
				$avg_sold_CSL = 0;
				$CSL_per_trade_sold = 0;
				$CSL_sold_purchase_price = 0 ;
				$avg_manul = 0;
				$per_trade_sold_manul = 0;
				$manul_sold_purchase_price = 0;
				$avg_sold = 0;
				$per_trade_sold = 0;

				$sumTimeDelayRange1 = 0;
				$sumTimeDelayRange2 = 0;
				$sumTimeDelayRange3 = 0;
				$sumTimeDelayRange4 = 0;
				$sumTimeDelayRange5 = 0;
				$sumTimeDelayRange6 = 0;
				$sumTimeDelayRange7 = 0;

				$sumPLSllipageRange1 = 0;
				$sumPLSllipageRange2 = 0;
				$sumPLSllipageRange3 = 0;
				$sumPLSllipageRange4 = 0;
				$sumPLSllipageRange5 = 0;
				$sell_fee_respected_coin = 0;
				$sell_comssion_bnb = 0;
				$btc_sell 	= 0 ;
				$usdt_sell 	= 0 ;


				if (count($total_sold_rec) > 0){
					foreach ($total_sold_rec as $key => $value1){
						$commission_sold_array = $value1['buy_fraction_filled_order_arr'];
						$sell_commission_sold_array = $value1['sell_fraction_filled_order_arr'];
						if($value1['symbol'] == 'ETHBTC'){ 
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}
						}elseif($value1['symbol'] == 'XRPBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'NEOBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'QTUMBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'XLMBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'TRXBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'ETCBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							$btc_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'EOSBTC'){
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'LINKBTC'){  
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'XMRBTC'){  
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'ADABTC'){       
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'LTCUSDT'){        
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							$usdt_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'ETHUSDT'){        
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							$usdt_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'DOTUSDT'){        
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							$usdt_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'BTCUSDT'){    
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							$usdt_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'DASHBTC'){  
							$btc += $value1['purchased_price']  * $value1['quantity'];
							$btc_sell += $value1['market_sell_price']  * $value1['quantity'];

							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}
						if(isset($value1['is_manual_sold'])){
							
							$manul_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
						}elseif(isset($value1['csl_sold'])){
							
							$CSL_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
						}else{
						
							$sold_puchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
						}
						if(isset($value1['order_send_time']) && isset($value1['sell_date']) && !empty($value1['order_send_time']) && !empty($value1['sell_date']) && $value1['is_sell_order'] == "sold"){

							$filledTime     = strtotime($value1['sell_date']->toDateTime()->format('Y-m-d H:i:s'));
							$orderSendTime  = strtotime($value1['order_send_time']->toDateTime()->format('Y-m-d H:i:s'));

							$differenceInSec = ($filledTime - $orderSendTime);
						}else{
							$differenceInSec = 0;
						}
						if($differenceInSec >= 0 && $differenceInSec < 15 ){
                          	$sumTimeDelayRange1++; 
						}elseif($differenceInSec >= 15 && $differenceInSec < 30){
							$sumTimeDelayRange2++;
						}elseif($differenceInSec >= 30 && $differenceInSec < 45){
							$sumTimeDelayRange3++;
						}elseif($differenceInSec >= 45 && $differenceInSec < 60){
							$sumTimeDelayRange4++;
						}elseif($differenceInSec >= 60 && $differenceInSec < 75){
							$sumTimeDelayRange5++;
						}elseif($differenceInSec >= 75 && $differenceInSec < 90 ){
							$sumTimeDelayRange6++;
						}elseif($differenceInSec >= 90){
							$sumTimeDelayRange7++;
						}
						if( isset($value1['created_date']) && !empty($value1['created_date']) ){

							$orderBUyTime  		= strtotime($value1['created_date']->toDateTime()->format('Y-m-d H:i:s'));

							$differenceBuyInSec = ($orderBUyTime - $sendHitTime);
						}else{
							$differenceBuyInSec = 0;
						}
						if($differenceBuyInSec >= 0 && $differenceBuyInSec < 15 ){
                          	$buySumTimeDelayRange1++; 
						}elseif($differenceBuyInSec >= 15 && $differenceBuyInSec < 30){
							$buySumTimeDelayRange2++;
						}elseif($differenceBuyInSec >= 30 && $differenceBuyInSec < 45){
							$buySumTimeDelayRange3++;
						}elseif($differenceBuyInSec >= 45 && $differenceBuyInSec < 60){
							$buySumTimeDelayRange4++;
						}elseif($differenceBuyInSec >= 60 && $differenceBuyInSec < 75){
							$buySumTimeDelayRange5++;
						}elseif($differenceBuyInSec >= 75 && $differenceBuyInSec < 90 ){
							$buySumTimeDelayRange6++;
						}elseif($differenceBuyInSec >= 90){
							$buySumTimeDelayRange7++;
						}

						// sold Pl slippage calculate
						if(isset($value1['sell_market_price']) && $value1['is_sell_order'] == 'sold' && $value1['sell_market_price'] !="" && !is_string($value1['sell_market_price'])){
							$val1 = $value1['market_sold_price'] - $value1['sell_market_price']; 
							$val2 = ($value1['market_sold_price'] + $value1['sell_market_price'])/ 2;
							$slippageOrignalPercentage = ($val1/ $val2) * 100;
							$slippageOrignalPercentage = round($slippageOrignalPercentage, 3) . '%';
						}else{
							$slippageOrignalPercentage = 0;
						}

						if($slippageOrignalPercentage > 0){
							$slippageOrignalPercentage = 0;
						}

						if($slippageOrignalPercentage <= 0 && $slippageOrignalPercentage > -0.2 ){

                          	$sumPLSllipageRange1++; 
						}elseif($slippageOrignalPercentage <= -0.2 && $slippageOrignalPercentage > -0.3){
							
							$sumPLSllipageRange2++;
						}elseif($slippageOrignalPercentage <= -0.3 && $slippageOrignalPercentage > -0.5){
							
							$sumPLSllipageRange3++;
						}elseif($slippageOrignalPercentage <= -0.5 && $slippageOrignalPercentage > -0.75){
							
							$sumPLSllipageRange4++;
						}elseif($slippageOrignalPercentage <= -1 ){
							
							$sumPLSllipageRange5++;
						}
						
					} //end sold foreach
					if($manul_sold_purchase_price > 0){
						$sold_puchase_price += $manul_sold_purchase_price;
						$manul_sold_purchase_price = 0;
					}
					if($CSL_sold_purchase_price > 0)
					{
						$sold_puchase_price += $CSL_sold_purchase_price;
						$CSL_sold_purchase_price = 0;
					}
					if($manul_sold_purchase_price != "0"){
						$per_trade_sold_manul = (float) $manul_sold_purchase_price * 100;
						$avg_manul = (float) ($per_trade_sold_manul / count($total_sold_rec));;
					}
					if($sold_puchase_price !="0"){
						$per_trade_sold = (float) $sold_puchase_price * 100;
						$avg_sold = (float) ($per_trade_sold / count($total_sold_rec)); 
					}
					if($CSL_sold_purchase_price !="0"){
						$CSL_per_trade_sold = (float) $CSL_sold_purchase_price * 100;
						$avg_sold_CSL = (float) ($CSL_per_trade_sold / count($total_sold_rec));
					}
				}// End check >0
					
				$total_orders = count($total_open_lth_rec) + count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $totalOther;
				$disappear = $parents_executed -  $total_orders;
				$total = count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $disappear;
				if ($total == $parents_executed){

					$sell_commision_qty_USDT =   ($sell_fee_respected_coin > 0)  ? convertCoinBalanceIntoUSDT($value['coin'], $sell_fee_respected_coin, 'kraken') : 0;
					$update_fields = array(
						'open_lth'     => count($total_open_lth_rec),
						'new_error'    => count($total_new_error_rec),
						'cancelled'    => count($total_cancel_rec),
						'costAvgCount' => ($costAvgReturn + $soldCostAvgReturn),
						'sold'         => count($total_sold_rec),
						'reumed_child' => count($total_reumed_order) + count($total_reumed_sold_orders),
						'avg_open_lth' => $open_lth_avg,
						'other_status' => $totalOther,
						'avg_sold'     => $avg_sold,
						'per_trade_sold' => $per_trade_sold,
						'minOrderSoldPrice' => $soldMinPrice[0]['minPrice'],
						'maxOrderSoldPrice' => $soldMaxPrice[0]['maxPrice'],
						'avg_manul'    =>$avg_manul,
						'sellTimeDiffRange1' 	=>	$sumTimeDelayRange1 ,
						'sellTimeDiffRange2' 	=>	$sumTimeDelayRange2 ,
						'sellTimeDiffRange3' 	=> 	$sumTimeDelayRange3 ,
						'sellTimeDiffRange4' 	=>	$sumTimeDelayRange4 ,
						'sellTimeDiffRange5' 	=> 	$sumTimeDelayRange5 ,
						'sellTimeDiffRange6' 	=>	$sumTimeDelayRange6 ,
						'sellTimeDiffRange7' 	=>	$sumTimeDelayRange7 ,
						'buySumTimeDelayRange1' => $buySumTimeDelayRange1 ,
						'buySumTimeDelayRange2' => $buySumTimeDelayRange2 ,
						'buySumTimeDelayRange3' => $buySumTimeDelayRange3 ,
						'buySumTimeDelayRange4' => $buySumTimeDelayRange4 ,
						'buySumTimeDelayRange5' => $buySumTimeDelayRange5 ,
						'buySumTimeDelayRange6' => $buySumTimeDelayRange6 ,
						'buySumTimeDelayRange7' => $buySumTimeDelayRange7 ,
						'sumPLSllipageRange1' 	=> $sumPLSllipageRange1 ,
						'sumPLSllipageRange2' 	=> $sumPLSllipageRange2 ,
						'sumPLSllipageRange3'	=> $sumPLSllipageRange3 ,
						'sumPLSllipageRange4' 	=> $sumPLSllipageRange4 ,
						'sumPLSllipageRange5' 	=> $sumPLSllipageRange5 ,
						'sell_commission' 		=> $sell_comssion_bnb,
						'sell_fee_respected_coin' => $sell_fee_respected_coin,
						'sell_commision_qty_USDT' => $sell_commision_qty_USDT,
						'avg_sold_CSL' 			=> $avg_sold_CSL,
						'modified_date' 		=> $current_time_date  
					);

					if(isset($value['10_max_value']) && isset($value['5_max_value'])){
						$update_fields['is_modified']  = true;
					}
					if(count($total_open_lth_rec)== 0 && count($total_sold_rec) == 0 &&  $totalOther == 0 ){
						$update_fields['oppertunity_missed'] = true;
					}
				}else{ 
					$update_fields = array(
						'open_lth'     => count($total_open_lth_rec),
						'new_error'    => count($total_new_error_rec),
						'cancelled'    => count($total_cancel_rec),
						'sold'         => count($total_sold_rec),
						'avg_open_lth' => $open_lth_avg,
						'costAvgCount' => ($costAvgReturn + $soldCostAvgReturn),
						'avg_sold'     => $avg_sold,
						'per_trade_sold' => $per_trade_sold,
						'minOrderSoldPrice' => $soldMinPrice[0]['minPrice'],
						'maxOrderSoldPrice' => $soldMaxPrice[0]['maxPrice'],
						'reumed_child' => count($total_reumed_order) + count($total_reumed_sold_orders),
						'other_status' => $totalOther,  
						'sellTimeDiffRange1' 	=>	$sumTimeDelayRange1 ,
						'sellTimeDiffRange2' 	=>	$sumTimeDelayRange2 ,
						'sellTimeDiffRange3' 	=> 	$sumTimeDelayRange3 ,
						'sellTimeDiffRange4' 	=>	$sumTimeDelayRange4 ,
						'sellTimeDiffRange5' 	=> 	$sumTimeDelayRange5 ,
						'sellTimeDiffRange6' 	=>	$sumTimeDelayRange6 ,
						'sellTimeDiffRange7' 	=>	$sumTimeDelayRange7 , 

						'buySumTimeDelayRange1' => $buySumTimeDelayRange1 ,
						'buySumTimeDelayRange2' => $buySumTimeDelayRange2 ,
						'buySumTimeDelayRange3' => $buySumTimeDelayRange3 ,
						'buySumTimeDelayRange4' => $buySumTimeDelayRange4 ,
						'buySumTimeDelayRange5' => $buySumTimeDelayRange5 ,
						'buySumTimeDelayRange6' => $buySumTimeDelayRange6 ,
						'buySumTimeDelayRange7' => $buySumTimeDelayRange7 ,

						'sumPLSllipageRange1' 	=> $sumPLSllipageRange1 ,
						'sumPLSllipageRange2' 	=> $sumPLSllipageRange2 ,
						'sumPLSllipageRange3'	=> $sumPLSllipageRange3 ,
						'sumPLSllipageRange4' 	=> $sumPLSllipageRange4 ,
						'sumPLSllipageRange5' 	=> $sumPLSllipageRange5 ,

						'avg_manul'    =>$avg_manul,
						'avg_sold_CSL' => $avg_sold_CSL,
						'modified_date'=>$current_time_date
					);
				}

				$sell_btc_converted = ($btc_sell > 0)  ? convertCoinBalanceIntoUSDT($value['coin'], $btc_sell, 'kraken') : 0;   
				$update_fields['sell_btc_in_$'] =   (float)$sell_btc_converted;
				$update_fields['sell_usdt']   	=   (float)$usdt_sell;
				$update_fields['total_sell_in_usdt'] = (float)($sell_btc_converted + $usdt_sell );

				if($buy_fee_respected_coin > 0 && !isset($value['buy_commision_qty']) && !isset($value['is_modified'])){
					$update_fields['buy_commision_qty'] = $buy_fee_respected_coin;
					$update_fields['buy_commision_qty_USDT'] =   ($buy_fee_respected_coin > 0)  ? convertCoinBalanceIntoUSDT($value['coin'], $buy_fee_respected_coin, 'kraken') : 0;

				}
				if($buy_commision_bnb > 0 && !isset($value['buy_commision']) && !isset($value['is_modified'])){
					$update_fields['buy_commision'] = $buy_commision_bnb;
				}

				$db = $this->mongo_db->customQuery();
				$pipeline = [
					[
						'$match' =>[
						'application_mode' => 'live',
						'parent_status' => ['$exists' => false ],
						'opportunityId' => $value['opportunity_id'],
						'status' => ['$in'=>['LTH','FILLED']],
						],
					],
					[
					'$sort' =>['created_date'=> -1],
					],
					['$limit'=>1]
				];
				$result_buy = $db->buy_orders_kraken->aggregate($pipeline);
				$res = iterator_to_array($result_buy);

				$pipeline1 = [
					[
						'$match' =>[
						'application_mode' => 'live',
						'parent_status' => ['$exists' => false ],
						'opportunityId' => $value['opportunity_id'],
						'status' => ['$in'=>['LTH','FILLED']],
						],
					],
					[
					'$sort' =>['created_date'=> 1],
					],
					['$limit'=>1]
				];
				$result_buy1 = $db->buy_orders_kraken->aggregate($pipeline1);
				$res1 = iterator_to_array($result_buy1);
				if(!isset($value['first_order_buy']) && !isset($value['last_order_buy'])){
					$update_fields['first_order_buy'] =  $res[0]['created_date'];
					$update_fields['last_order_buy'] =  $res1[0]['created_date'];
				}
				if(!isset($value['opp_came_binance']) && !isset($value['opp_came_kraken']) && !isset($value['opp_came_bam'])){	
					$opper_search['application_mode']= 'live';
					$opper_search['opportunityId'] = $value['opportunity_id'];
					
					$connetct= $this->mongo_db->customQuery();

					$pending_curser = $connetct->buy_orders->find($opper_search);
					$buy_order = iterator_to_array($pending_curser);

					$pending_curser_buy = $connetct->sold_buy_order->find($opper_search);
					$sold_bbuy_order = iterator_to_array($pending_curser_buy);

					if(count($buy_order) > 0 || count($sold_bbuy_order) > 0 ){
						$update_fields['opp_came_binance'] = '1';
					}else{
						$update_fields['opp_came_binance'] = '0';
					}
					
					$this->mongo_db->where($opper_search);
					$response_kraken = $this->mongo_db->get('buy_orders_kraken');
					$data_kraken = iterator_to_array($response_kraken);

					$this->mongo_db->where($opper_search);
					$response_kraken_sold = $this->mongo_db->get('sold_buy_orders_kraken');
					$data_kraken_sold = iterator_to_array($response_kraken_sold);
					if(count($data_kraken) > 0 || count($data_kraken_sold) > 0){
						$update_fields['opp_came_kraken'] = '1';
					}else{
						$update_fields['opp_came_kraken'] = '0';
					}
					
					$this->mongo_db->where($opper_search);
					$response_bam = $this->mongo_db->get('buy_orders_bam');
					$data_bam = iterator_to_array($response_bam);

					$this->mongo_db->where($opper_search);
					$response_bam_sold = $this->mongo_db->get('sold_buy_orders_bam');
					$data_bam_sold = iterator_to_array($response_bam_sold);

					if(count($data_bam) > 0 || count($data_bam_sold) > 0){
						$update_fields['opp_came_bam'] = '1';
					}else{
						$update_fields['opp_came_bam'] = '0';
					}
				}

				if($btc > "0" && $usdt == "0" && !isset($value['usdt_invest_amount']) &&  !isset($value['btc_invest_amount'])){
					$update_fields['usdt_invest_amount'] = $btcusdt * $btc;
					$update_fields['btc_invest_amount']  = $btc;  //for chart view 
				}
				elseif($usdt > "0" && $btc == "0" && !isset($value['usdt_invest_amount']) && !isset($value['only_usdt_invest_amount'])) {
					$update_fields['usdt_invest_amount'] = $usdt;
					$update_fields['only_usdt_invest_amount'] = $usdt;  //for chart view
				} 

				echo"<br><pre>";
				print_r($update_fields);
				$collection_name = 'opportunity_logs_kraken';
				$this->mongo_db->where($search_update);
				$this->mongo_db->set($update_fields);
				$this->mongo_db->update($collection_name);
			}
		} //end foreach
		echo "<br>Total Picked Oppertunities Ids= ".count($response);
	} //end cron


	/////////////////////////////////////////////////////////////////////////////
	//////////////////            BAM CRON ASIM          ////////////////////////
	/////////////////////////////////////////////////////////////////////////////

	public function insert_latest_oppertunity_into_log_collection_bam(){
		// ini_set("error reporting", E_ALL);
		// error_reporting(E_ALL);

		$marketPrices = marketPrices('bam');
		$this->load->helper('new_common_helper');
		foreach($marketPrices as $price){
			if($price['_id'] == 'XRPBTC'){   
				$xrpbtc = (float)$price['price'];
			}elseif($price['_id'] == 'ETHBTC'){
				$ethbtc = (float)$price['price'];
			}elseif($price['_id'] == 'XRPUSDT'){
				$xrpusdt = (float)$price['price'];
			}elseif($price['_id'] == 'BTCUSDT'){       
				$btcusdt = (float)$price['price'];
			}elseif($price['_id'] == 'NEOUSDT'){
				$neousdt = (float)$price['price'];
			}elseif($price['_id'] == 'QTUMUSDT'){
				$qtumusdt = (float)$price['price'];
			}
		}//end loop 
		$current_date_time =  date('Y-m-d H:i:s');
		$current_time_date =  $this->mongo_db->converToMongodttime($current_date_time);
		
		$current_hour =  date('Y-m-d H:i:s', strtotime('-35 minutes'));
		$orig_date1 = $this->mongo_db->converToMongodttime($current_hour);

		$previous_one_month_date_time = date('Y-m-d H:i:s', strtotime(' - 1 month'));
		$pre_date_1 =  $this->mongo_db->converToMongodttime($previous_one_month_date_time);

		$connection = $this->mongo_db->customQuery();      
		$condition = array('sort' => array('created_date' => -1), 'limit'=>3);

		if(!empty($this->input->get())){
			$where['opportunity_id'] = $this->input->get('opportunityId');
		}else{
			$where['mode'] ='live';
			$where['created_date'] = array('$gte'=>$pre_date_1);
			$where['level'] = array('$ne'=>'level_15');
			$where['is_modified'] = array('$exists'=>false);
			$where['modified_date'] = array('$lte'=>$orig_date1);
		} 
		// $where['mode'] ='live'; 
		// $where['created_date'] = array('$gte'=>$pre_date_1);
		// $where['level'] = array('$ne'=>'level_15');
		// $where['is_modified'] = array('$exists'=>false);
		// $where['modified_date'] = array('$lte'=>$orig_date1);
		
		$find_rec = $connection->opportunity_logs_bam->find($where,  $condition);
		$response = iterator_to_array($find_rec);

		foreach ($response as $value){
			$coin= $value['coin'];
			if(isset($value['sendHitTime']) && !empty($value['sendHitTime'])){
				$sendHitTime     	= strtotime($value['sendHitTime']->toDateTime()->format('Y-m-d H:i:s'));				
			}else{
				$sendHitTime     	= strtotime($value['created_date']->toDateTime()->format('Y-m-d H:i:s'));

			}
			$start_date = $value['created_date']->toDateTime()->format("Y-m-d H:i:s");
			$timestamp = strtotime($start_date);
			$time = $timestamp + (5 * 60 * 60);
			$end_date = date("Y-m-d H:i:s", $time);

			$hours_10 = $timestamp + (10 * 60 * 60);
			$time_10_hours = date("Y-m-d H:i:s", $hours_10);
			$cidition_check = $this->mongo_db->converToMongodttime($end_date);
			$cidition_check_10 = $this->mongo_db->converToMongodttime($time_10_hours);
				$params = array(
				'coin'       => $value['coin'],
				'start_date' => (string)$start_date,
				'end_date'   => (string)$end_date,
				);
				echo "<br>current time=".$current_date_time;
				echo"<br>created_date =".$start_date;
				echo"<br>start date +5 =".$end_date;
				echo"<br>start date +10 =".$time_10_hours;

				if($cidition_check <= $current_time_date){
					$jsondata = json_encode($params);
					$curl = curl_init();
					curl_setopt_array($curl, array(	
						CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS =>$jsondata,
						CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
					));
					$response_price = curl_exec($curl);	
					curl_close($curl);                                
					$api_response = json_decode($response_price);
				} // main if check for time comapire

			$params_10_hours = array(
				'coin'       => $value['coin'],
				'start_date' => (string)$start_date,
				'end_date'   => (string)$time_10_hours,
			);
			if($cidition_check_10 <= $current_time_date){
				$jsondata = json_encode($params_10_hours);
					$curl_10 = curl_init();
					curl_setopt_array($curl_10, array(
					CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS =>$jsondata,
					CURLOPT_HTTPHEADER => array(
						"Content-Type: application/json"
					), 
					));
					$response_price_10 = curl_exec($curl_10);	
					curl_close($curl_10);
					$api_response_10 = json_decode($response_price_10);
				}
			if ($value['level'] != 'level_15' ){
				$open_lth_avg_per_trade = 0;
				$open_lth_avg = 0;
				$avg_sold = 0;
				$parents_executed = 0;
				$parents_executed = $value['parents_executed'];
				
				$search_update['opportunity_id'] = $value['opportunity_id'];
				$search_update['mode']= 'live';
				////////////////////////////////////////////////////////////////
				$other['application_mode']= 'live';
				$other['opportunityId'] =  $value['opportunity_id'];
				$other['status'] = array('$nin' => array('LTH', 'FILLED','canceled','new_ERROR'));
				$buyOther = $connection->buy_orders_bam->count($other);
				// $total_other_rec   = iterator_to_array($total_other);

				$otherSold['application_mode']= 'live';
				$otherSold['opportunityId'] =  $value['opportunity_id'];
				$otherSold['is_sell_order'] = array('$nin' => array('sold'));
				$otherStatusSold = $connection->sold_buy_orders_bam->count($otherSold);
				$totalOther = $buyOther + $otherStatusSold;
				//////////////////////////////////////////////////////////////

				$search_open_lth['application_mode']		= 	'live';
				$search_open_lth['opportunityId'] 			= 	$value['opportunity_id'];
				$search_open_lth['status'] 					= 	array('$in' => array('LTH', 'FILLED'));
				$search_open_lth['resume_status']['$ne'] 	= 	'resume';
				$search_open_lth['cost_avg']['$ne'] 		= 	'yes';
				$search_open_lth['cavg_parent']['$ne'] 		= 	'yes';
				$search_open_lth['cavg_parent'] 			= 	['$exists' => false];
				$search_open_lth['cost_avg']				=	['$nin' => ['yes', 'completed', '']];

				print_r("<br>oppertunity_id=".$value['opportunity_id']);
				/////
				$search_cancel['application_mode']		= 	'live';
				$search_cancel['opportunityId'] 		= 	$value['opportunity_id'];
				$search_cancel['status'] 				= 	array('$in' => array('canceled'));
				$search_cancel['cavg_parent'] 			= 	['$exists' => false];
				$search_cancel['cost_avg']				=	['$nin' => ['yes', 'completed', '']];
				//////
				$search_new_error['application_mode']	= 	'live';
				$search_new_error['opportunityId'] 		= 	$value['opportunity_id'];
				$search_new_error['status'] 			= 	array('$in' => array('new_ERROR'));
				$search_new_error['cavg_parent'] 		= 	['$exists' => false];
				$search_new_error['cost_avg']			=	['$nin' => ['yes', 'completed', '']];
				////////
				$search_sold['application_mode']	= 	'live';
				$search_sold['opportunityId'] 		= 	$value['opportunity_id'];
				$search_sold['is_sell_order'] 		= 	array('$in' => array('sold'));
				$search_sold['cavg_parent'] 		= 	['$exists' => false];
				$search_sold['cost_avg']			=	['$nin' => ['yes', 'completed', '']];

				$search_reumed['application_mode']	= 'live';
				$search_reumed['opportunityId'] 	= $value['opportunity_id'];
				$search_reumed['resume_status'] 	= array('$in' => array('resume'));  
				$search_resumed['cavg_parent'] 		= 	['$exists' => false];
				$search_resumed['cost_avg']			=	['$nin' => ['yes', 'completed', '']];

				$this->mongo_db->where($search_reumed);
				$total_reumed = $this->mongo_db->get('buy_orders_bam');
				$total_reumed_order   = iterator_to_array($total_reumed);

				$this->mongo_db->where($search_reumed);
				$total_reumed_sold = $this->mongo_db->get('sold_buy_orders_bam');
				$total_reumed_sold_order   = iterator_to_array($total_reumed_sold);   



				$minPriceLookUp = [
					[
						'$match' => [
							'application_mode' => 'live',
							'opportunityId'    =>  $value['opportunity_id'],
							'is_sell_order'    =>  'sold'
						 ]
					],

					[
						'$group' =>[
							'_id' => '$symbol',
							'minPrice' => ['$min' => '$market_sold_price']
						]
					],

				];

				$minSoldPrice = $connection->sold_buy_orders_bam->aggregate($minPriceLookUp);
				$soldMinPrice  = iterator_to_array($minSoldPrice);

				$maxPriceLookUp = [
					[
						'$match' => [
							'application_mode' => 'live',
							'opportunityId'    =>  $value['opportunity_id'],
							'is_sell_order'    =>  'sold'
						 ]
					],

					[
						'$group' =>[
							'_id' => '$symbol',
							'maxPrice' => ['$max' => '$market_sold_price']
						]
					],

				];

				$maxSoldPrice = $connection->sold_buy_orders_bam->aggregate($maxPriceLookUp);
				$soldMaxPrice  = iterator_to_array($maxSoldPrice);

				/////////////////////////////////////////////////////////////// 
				$cosAvg['application_mode'] = 'live';
				$cosAvg['opportunityId']    = $value['opportunity_id'];
				$cosAvg['cost_avg']['$ne']  = 'completed';
                $costAvg['cavg_parent']     =  'yes';


				$cosAvgSold['application_mode']  =  'live';
				$cosAvgSold['opportunityId']     =  $value['opportunity_id'];
				$cosAvgSold['is_sell_order']     =  'sold';
				$cosAvgSold['cost_avg']          =  'complete';
				$cosAvgSold['cavg_parent']       =  'yes';

				$costAvgReturn = $connection->buy_orders_bam->count($cosAvg);
				$soldCostAvgReturn = $connection->sold_buy_orders_bam->count($cosAvgSold);  
				///////////////////////////////////////////////////////////////

				$this->mongo_db->where($search_open_lth);
				$total_open = $this->mongo_db->get('buy_orders_bam');
				$total_open_lth_rec   = iterator_to_array($total_open);
				

				$this->mongo_db->where($search_cancel);
				$total_cancel = $this->mongo_db->get('buy_orders_bam');
				$total_cancel_rec   = iterator_to_array($total_cancel);

				$this->mongo_db->where($search_new_error);
				$total_new_error = $this->mongo_db->get('buy_orders_bam');
				$total_new_error_rec   = iterator_to_array($total_new_error);

				$this->mongo_db->where($search_sold);
				$total_sold_total = $this->mongo_db->get('sold_buy_orders_bam');
				$total_sold_rec   = iterator_to_array($total_sold_total);
				echo"<br>total sold count = ".count($total_sold_rec);
				
				$open_lth_puchase_price = 0;
				$open_lth_avg = 0;
				$btc = 0;
				$usdt = 0;

				$buySumTimeDelayRange1 = 0;
				$buySumTimeDelayRange2 = 0;
				$buySumTimeDelayRange3 = 0;
				$buySumTimeDelayRange4 = 0;
				$buySumTimeDelayRange5 = 0;
				$buySumTimeDelayRange6 = 0;
				$buySumTimeDelayRange7 = 0;
				$buy_commision_bnb = 0;
				$buy_fee_respected_coin = 0;

				$open_lth_avg_per_trade= 0;  
				echo"<br>Total open lth = ".count($total_open_lth_rec);
				if (count($total_open_lth_rec) > 0) {
					echo "<br> Open/lth Calculation";
					foreach ($total_open_lth_rec as $key => $value2){
						$commission_array = $value2['buy_fraction_filled_order_arr'];
						if($value2['symbol'] == 'ETHBTC'){
							$open_lth_puchase_price += (float) ($ethbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];

							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'BTCUSDT'){
							$open_lth_puchase_price += (float) ($btcusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];
							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XRPBTC'){
							$open_lth_puchase_price += (float) ($xrpbtc - $value2['purchased_price']) / $value2['purchased_price'];
							$btc +=(float)$value2['purchased_price'] * $value2['quantity'];
							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'XRPUSDT'){
							$open_lth_puchase_price += (float) ($xrpusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];
							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'NEOUSDT'){
							$open_lth_puchase_price += (float) ($neousdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];
							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}elseif($value2['symbol'] == 'QTUMUSDT'){
							$open_lth_puchase_price += (float) ($qtumusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							$usdt +=(float)$value2['purchased_price'] * $value2['quantity'];
							foreach($commission_array as $commBuy){
								if($commBuy['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $commBuy['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $commBuy['commission'];
								}  
							}

						}	
						echo "<br>open_lth_puchase_price +=";
						print_r($open_lth_puchase_price);
						echo "<br> order_id = ".$value2['_id'];

						if( isset($value2['created_date']) && !empty($value2['created_date']) ){

							$orderBUyTime  		= strtotime($value2['created_date']->toDateTime()->format('Y-m-d H:i:s'));

							$differenceBuyInSec = ($orderBUyTime - $sendHitTime);
						}else{
							$differenceBuyInSec = 0;
						}
						if($differenceBuyInSec >= 0 && $differenceBuyInSec < 15 ){
                          	$buySumTimeDelayRange1++; 
						}elseif($differenceBuyInSec >= 15 && $differenceBuyInSec < 30){
							$buySumTimeDelayRange2++;
						}elseif($differenceBuyInSec >= 30 && $differenceBuyInSec < 45){
							$buySumTimeDelayRange3++;
						}elseif($differenceBuyInSec >= 45 && $differenceBuyInSec < 60){
							$buySumTimeDelayRange4++;
						}elseif($differenceBuyInSec >= 60 && $differenceBuyInSec < 75){
							$buySumTimeDelayRange5++;
						}elseif($differenceBuyInSec >= 75 && $differenceBuyInSec < 90 ){
							$buySumTimeDelayRange6++;
						}elseif($differenceBuyInSec >= 90){
							$buySumTimeDelayRange7++;
						}


					}//end loop
						$open_lth_avg_per_trade = (float) $open_lth_puchase_price * 100;
						$open_lth_avg = (float) ($open_lth_avg_per_trade / count($total_open_lth_rec));
				
						echo "<br>avg_open-lth = ";
						print_r($open_lth_avg);
				}//end if

				$sold_puchase_price = 0;
				$avg_sold_CSL = 0;
				$CSL_per_trade_sold = 0;
				$CSL_sold_purchase_price = 0 ;
				$avg_manul = 0;
				$per_trade_sold_manul = 0;
				$manul_sold_purchase_price = 0;
				$avg_sold = 0;

				$sumTimeDelayRange1 = 0;
				$sumTimeDelayRange2 = 0;
				$sumTimeDelayRange3 = 0;
				$sumTimeDelayRange4 = 0;
				$sumTimeDelayRange5 = 0;
				$sumTimeDelayRange6 = 0;
				$sumTimeDelayRange7 = 0;

				$sumPLSllipageRange1 = 0;
				$sumPLSllipageRange2 = 0;
				$sumPLSllipageRange3 = 0;
				$sumPLSllipageRange4 = 0;
				$sumPLSllipageRange5 = 0;
				$sell_fee_respected_coin = 0;
				$sell_comssion_bnb =0;

				$per_trade_sold = 0;
				if (count($total_sold_rec) > 0){
					echo "<br> sold calculation";
					foreach ($total_sold_rec as $key => $value1){
						$commission_sold_array = $value1['buy_fraction_filled_order_arr'];
						$sell_commission_sold_array = $value1['sell_fraction_filled_order_arr'];
						if($value1['symbol'] == 'XRPBTC'){     
							$btc += $value1['purchased_price']  * $value1['quantity'];
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}

						}elseif($value1['symbol'] == 'ETHBTC'){
							$btc += $value1['purchased_price'] * $value1['quantity'];
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}
						}elseif($value1['symbol'] == 'XRPUSDT'){
							$usdt += $value1['purchased_price'] * $value1['quantity'];
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}
						}elseif($value1['symbol'] == 'BTCUSDT'){
							$usdt += $value1['purchased_price'] * $value1['quantity'];
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}
						}elseif($value1['symbol'] == 'QTUMUSDT'){
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}
						}elseif($value1['symbol'] == 'NEOUSDT'){
							$usdt += $value1['purchased_price']  * $value1['quantity'];
							foreach($sell_commission_sold_array as $sell_comm){
								if($sell_comm['commissionAsset'] =='BNB'){
									$sell_comssion_bnb += (float)$sell_comm['commission'];
									echo "<br>sell commission BTC = ".$sell_comssion_bnb;
								}else{
									$sell_fee_respected_coin += (float) $sell_comm['commission'];
								}
							}
							foreach($commission_sold_array as $comm_1){
								if($comm_1['commissionAsset'] =='BNB'){
									$buy_commision_bnb +=(float) $comm_1['commission'];
									echo "<br>buy commission BTC = ".$buy_commision_bnb;	
								}else{
									$buy_fee_respected_coin += (float) $comm_1['commission'];
								}  
							}
						}
						if(isset($value1['is_manual_sold'])){
							$manul_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
							print_r("<br> Market sold price manul = ".$value1['market_sold_price']);
							print_r("<br>purchase price manul =".$value1['purchased_price']);
							print_r("<br> sold_puchase_price manul + =".$manul_sold_purchase_price);
							echo '<br>order_id manul ='.$value1['_id'];	
						}elseif(isset($value1['csl_sold'])){
							$CSL_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
							print_r("<br> Market sold price = ".$value1['market_sold_price']);
							print_r("<br>purchase price =".$value1['purchased_price']);
							print_r("<br> CSL sold_puchase_price + =".$CSL_sold_purchase_price);
							echo '<br>order_id ='.$value1['_id'];
						}else{
							$sold_puchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
							print_r("<br> Market sold price = ".$value1['market_sold_price']);
							print_r("<br>purchase price =".$value1['purchased_price']);
							print_r("<br> sold_puchase_price + =".$sold_puchase_price);
							echo '<br>order_id ='.$value1['_id'];
						}


						if(isset($value1['order_send_time']) && isset($value1['sell_date']) && !empty($value1['order_send_time']) && !empty($value1['sell_date']) && $value1['is_sell_order'] == "sold"){

							$filledTime     = strtotime($value1['sell_date']->toDateTime()->format('Y-m-d H:i:s'));
							$orderSendTime  = strtotime($value1['order_send_time']->toDateTime()->format('Y-m-d H:i:s'));

							$differenceInSec = ($filledTime - $orderSendTime);
						}else{
							$differenceInSec = 0;
						}
						if($differenceInSec >= 0 && $differenceInSec < 15 ){
                          	$sumTimeDelayRange1++; 
						}elseif($differenceInSec >= 15 && $differenceInSec < 30){
							$sumTimeDelayRange2++;
						}elseif($differenceInSec >= 30 && $differenceInSec < 45){
							$sumTimeDelayRange3++;
						}elseif($differenceInSec >= 45 && $differenceInSec < 60){
							$sumTimeDelayRange4++;
						}elseif($differenceInSec >= 60 && $differenceInSec < 75){
							$sumTimeDelayRange5++;
						}elseif($differenceInSec >= 75 && $differenceInSec < 90 ){
							$sumTimeDelayRange6++;
						}elseif($differenceInSec >= 90){
							$sumTimeDelayRange7++;
						}


						if( isset($value1['created_date']) && !empty($value1['created_date']) ){

							$orderBUyTime  		= strtotime($value1['created_date']->toDateTime()->format('Y-m-d H:i:s'));

							$differenceBuyInSec = ($orderBUyTime - $sendHitTime);
						}else{
							$differenceBuyInSec = 0;
						}
						if($differenceBuyInSec >= 0 && $differenceBuyInSec < 15 ){
                          	$buySumTimeDelayRange1++; 
						}elseif($differenceBuyInSec >= 15 && $differenceBuyInSec < 30){
							$buySumTimeDelayRange2++;
						}elseif($differenceBuyInSec >= 30 && $differenceBuyInSec < 45){
							$buySumTimeDelayRange3++;
						}elseif($differenceBuyInSec >= 45 && $differenceBuyInSec < 60){
							$buySumTimeDelayRange4++;
						}elseif($differenceBuyInSec >= 60 && $differenceBuyInSec < 75){
							$buySumTimeDelayRange5++;
						}elseif($differenceBuyInSec >= 75 && $differenceBuyInSec < 90 ){
							$buySumTimeDelayRange6++;
						}elseif($differenceBuyInSec >= 90){
							$buySumTimeDelayRange7++;
						}

						// sold Pl slippage calculate
						if(isset($value1['sell_market_price']) && $value1['is_sell_order'] == 'sold' && $value1['sell_market_price'] !="" && !is_string($value1['sell_market_price'])){
							$val1 = $value1['market_sold_price'] - $value1['sell_market_price']; 
							$val2 = ($value1['market_sold_price'] + $value1['sell_market_price'])/ 2;
							$slippageOrignalPercentage = ($val1/ $val2) * 100;
							$slippageOrignalPercentage = round($slippageOrignalPercentage, 3) . '%';
						}else{
							$slippageOrignalPercentage = 0;
						}

						if($slippageOrignalPercentage > 0){
							$slippageOrignalPercentage = 0;
						}

						if($slippageOrignalPercentage <= 0 && $slippageOrignalPercentage > -0.2 ){

                          	$sumPLSllipageRange1++; 
						}elseif($slippageOrignalPercentage <= -0.2 && $slippageOrignalPercentage > -0.3){
							
							$sumPLSllipageRange2++;
						}elseif($slippageOrignalPercentage <= -0.3 && $slippageOrignalPercentage > -0.5){
							
							$sumPLSllipageRange3++;
						}elseif($slippageOrignalPercentage <= -0.5 && $slippageOrignalPercentage > -0.75){
							
							$sumPLSllipageRange4++;
						}elseif($slippageOrignalPercentage <= -1 ){
							
							$sumPLSllipageRange5++;
						}
				

					} //end sold foreach
					if($manul_sold_purchase_price > 0){
						$sold_puchase_price += $manul_sold_purchase_price;
						$manul_sold_purchase_price = 0;
					}
					if($CSL_sold_purchase_price > 0){
						$sold_puchase_price += $CSL_sold_purchase_price;
						$CSL_sold_purchase_price = 0;
					}
					if($manul_sold_purchase_price != "0"){
						$per_trade_sold_manul = (float) $manul_sold_purchase_price * 100;
						echo "<br>per tarde manul = ".$per_trade_sold_manul;
						$avg_manul = (float) ($per_trade_sold_manul / count($total_sold_rec));
						echo "<br>avg_sold manul = ";
						print_r($avg_manul);
						print_r("<br>sold count = ".count($total_sold_rec));
					}
					if($sold_puchase_price !="0"){
						$per_trade_sold = (float) $sold_puchase_price * 100;
						echo "<br>per tarde = ".$per_trade_sold;
						$avg_sold = (float) ($per_trade_sold / count($total_sold_rec));
						echo "<br>avg_sold = ";
						print_r($avg_sold);
						print_r("<br>sold count = ".count($total_sold_rec));
					}
					if($CSL_sold_purchase_price !="0"){
						$CSL_per_trade_sold = (float) $CSL_sold_purchase_price * 100;
						echo "<br>per tarde CSL = ".$CSL_per_trade_sold;
						$avg_sold_CSL = (float) ($CSL_per_trade_sold / count($total_sold_rec));
						echo "<br>avg_sold CSL = ";
						print_r($avg_sold_CSL);
						print_r("<br>sold count = ".count($total_sold_rec));
					}
				}// End check >0
				print_r("<br>oppertunity_id=".$value['opportunity_id']."<br>");
				$total_orders = count($total_open_lth_rec) + count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $totalOther;
				$disappear = $parents_executed -  $total_orders;
				$total = count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $disappear;
				if ($total == $parents_executed ){
					$update_fields = array(
						'open_lth'     => count($total_open_lth_rec),
						'new_error'    => count($total_new_error_rec),
						'cancelled'    => count($total_cancel_rec),
						'costAvgCount' => ($costAvgReturn + $soldCostAvgReturn),
						'sold'         => count($total_sold_rec),
						'avg_open_lth' => $open_lth_avg,
						'other_status' => $totalOther,
						'minOrderSoldPrice' => $soldMinPrice[0]['minPrice'],
						'maxOrderSoldPrice' => $soldMaxPrice[0]['maxPrice'],
						'reumed_child'  => count($total_reumed_sold_order) + count($total_reumed_order),
						'avg_sold'     => $avg_sold,
						'sellTimeDiffRange1' 	=>	$sumTimeDelayRange1 ,
						'sellTimeDiffRange2' 	=>	$sumTimeDelayRange2 ,
						'sellTimeDiffRange3' 	=> 	$sumTimeDelayRange3 ,
						'sellTimeDiffRange4' 	=>	$sumTimeDelayRange4 ,
						'sellTimeDiffRange5' 	=> 	$sumTimeDelayRange5 ,
						'sellTimeDiffRange6' 	=>	$sumTimeDelayRange6 ,
						'sellTimeDiffRange7' 	=>	$sumTimeDelayRange7 ,

						'buySumTimeDelayRange1' => $buySumTimeDelayRange1 ,
						'buySumTimeDelayRange2' => $buySumTimeDelayRange2 ,
						'buySumTimeDelayRange3' => $buySumTimeDelayRange3 ,
						'buySumTimeDelayRange4' => $buySumTimeDelayRange4 ,
						'buySumTimeDelayRange5' => $buySumTimeDelayRange5 ,
						'buySumTimeDelayRange6' => $buySumTimeDelayRange6 ,
						'buySumTimeDelayRange7' => $buySumTimeDelayRange7 ,

						'sumPLSllipageRange1' 	=> $sumPLSllipageRange1 ,
						'sumPLSllipageRange2' 	=> $sumPLSllipageRange2 ,
						'sumPLSllipageRange3'	=> $sumPLSllipageRange3 ,
						'sumPLSllipageRange4' 	=> $sumPLSllipageRange4 ,
						'sumPLSllipageRange5' 	=> $sumPLSllipageRange5 ,

						'per_trade_sold'     	=> $per_trade_sold,
						'avg_manul'    			=> $avg_manul,
						'avg_sold_CSL' 			=> $avg_sold_CSL,
						'modified_date' 		=> $current_time_date,  
						'sell_commission' 		=> $sell_comssion_bnb,
						'sell_fee_respected_coin' => $sell_fee_respected_coin,
					);
					if(isset($value['10_max_value']) && isset($value['5_max_value'])){
						$update_fields['is_modified']  = true;
					}
					if(count($total_open_lth_rec)== 0 && count($total_sold_rec) == 0 &&  $totalOther == 0){
						$update_fields['oppertunity_missed'] = true;
					}
					}else{ 
						$update_fields = array(
							'open_lth'     => count($total_open_lth_rec),
							'new_error'    => count($total_new_error_rec),
							'cancelled'    => count($total_cancel_rec),
							'costAvgCount' => ($costAvgReturn + $soldCostAvgReturn),
							'sold'         => count($total_sold_rec),
							'reumed_child' => count($total_reumed_sold_order) + count($total_reumed_order),
							'avg_open_lth' => $open_lth_avg,
							'avg_sold'     => $avg_sold,
							'per_trade_sold' => $per_trade_sold,
							'minOrderSoldPrice' => $soldMinPrice[0]['minPrice'],
							'maxOrderSoldPrice' => $soldMaxPrice[0]['maxPrice'],
							'other_status' => $totalOther,   
							'sellTimeDiffRange1' 	=>	$sumTimeDelayRange1 ,
							'sellTimeDiffRange2' 	=>	$sumTimeDelayRange2 ,
							'sellTimeDiffRange3' 	=> 	$sumTimeDelayRange3 ,
							'sellTimeDiffRange4' 	=>	$sumTimeDelayRange4 ,
							'sellTimeDiffRange5' 	=> 	$sumTimeDelayRange5 ,
							'sellTimeDiffRange6' 	=>	$sumTimeDelayRange6 ,
							'sellTimeDiffRange7' 	=>	$sumTimeDelayRange7 ,

							'buySumTimeDelayRange1' => $buySumTimeDelayRange1 ,
							'buySumTimeDelayRange2' => $buySumTimeDelayRange2 ,
							'buySumTimeDelayRange3' => $buySumTimeDelayRange3 ,
							'buySumTimeDelayRange4' => $buySumTimeDelayRange4 ,
							'buySumTimeDelayRange5' => $buySumTimeDelayRange5 ,
							'buySumTimeDelayRange6' => $buySumTimeDelayRange6 ,
							'buySumTimeDelayRange7' => $buySumTimeDelayRange7 ,

							'sumPLSllipageRange1' 	=> $sumPLSllipageRange1 ,
							'sumPLSllipageRange2' 	=> $sumPLSllipageRange2 ,
							'sumPLSllipageRange3'	=> $sumPLSllipageRange3 ,
							'sumPLSllipageRange4' 	=> $sumPLSllipageRange4 ,
							'sumPLSllipageRange5' 	=> $sumPLSllipageRange5 ,

							'avg_manul'    =>$avg_manul,
							'avg_sold_CSL' => $avg_sold_CSL,
							'modified_date'=>$current_time_date
						);
					}


					if($buy_fee_respected_coin > 0 && !isset($value['buy_commision_qty']) && !isset($value['is_modified'])){
						$update_fields['buy_commision_qty'] = $buy_fee_respected_coin;
						echo"<br> qty buy feee = ".$buy_fee_respected_coin;
					}
					if($buy_commision_bnb > 0 && !isset($value['buy_commision']) && !isset($value['is_modified'])){
						$update_fields['buy_commision'] = $buy_commision_bnb;
						echo"total commision = BNB ".$buy_commision_bnb;
					}
					$db = $this->mongo_db->customQuery();
					$pipeline = [
					[
						'$match' =>[
						'application_mode' => 'live',
						'parent_status' => ['$exists' => false ],
						'opportunityId' => $value['opportunity_id'],
						'status' => ['$in'=>['LTH','FILLED']],
						],
					],
						[
						'$sort' =>['created_date'=> -1],
						],
						['$limit'=>1]
					];
					$result_buy = $db->buy_orders_bam->aggregate($pipeline);
					$res = iterator_to_array($result_buy);

					$pipeline1 = [
					[
						'$match' =>[
						'application_mode' => 'live',
						'parent_status' => ['$exists' => false ],
						'opportunityId' => $value['opportunity_id'],
						'status' => ['$in'=>['LTH','FILLED']],
						],
					],
						[
						'$sort' =>['created_date'=> 1],
						],
						['$limit'=>1]
					];
					$result_buy1 = $db->buy_orders_bam->aggregate($pipeline1);
					$res1 = iterator_to_array($result_buy1);
					if(!isset($value['first_order_buy']) && !isset($value['last_order_buy'])){
						echo "<br> created_date first =".$res[0]['created_date'];
						echo "<br>created_date last = ".$res1[0]['created_date'];
						$update_fields['first_order_buy'] =  $res[0]['created_date'];
						$update_fields['last_order_buy'] =  $res1[0]['created_date'];
					}
					if(!isset($value['opp_came_binance']) && !isset($value['opp_came_kraken']) && !isset($value['opp_came_bam'])){	
						$opper_search['application_mode']= 'live';
						$opper_search['opportunityId'] = $value['opportunity_id'];
						
						$connetct= $this->mongo_db->customQuery();

						$pending_curser = $connetct->buy_orders->find($opper_search);
						$buy_order = iterator_to_array($pending_curser);
						echo "<br>result binance=".count($buy_order);

						$pending_curser_buy = $connetct->sold_buy_order->find($opper_search);
						$sold_bbuy_order = iterator_to_array($pending_curser_buy);
						echo "<br>result binance sold=".count($sold_bbuy_order);

						if(count($buy_order) > 0 || count($sold_bbuy_order) > 0 ){
							$update_fields['opp_came_binance'] = '1';
						}else{
							$update_fields['opp_came_binance'] = '0';
						}
						
						$this->mongo_db->where($opper_search);
						$response_kraken = $this->mongo_db->get('buy_orders_kraken');
						$data_kraken = iterator_to_array($response_kraken);
						echo "<br>result kraken=". count($data_kraken);

						$this->mongo_db->where($opper_search);
						$response_kraken_sold = $this->mongo_db->get('sold_buy_orders_kraken');
						$data_kraken_sold = iterator_to_array($response_kraken_sold);
						echo "<br>result kraken sold=". count($data_kraken_sold);
						if(count($data_kraken) > 0 || count($data_kraken_sold) > 0){
							$update_fields['opp_came_kraken'] = '1';
						}else{
							$update_fields['opp_came_kraken'] = '0';
						}
						
						$this->mongo_db->where($opper_search);
						$response_bam = $this->mongo_db->get('buy_orders_bam');
						$data_bam = iterator_to_array($response_bam);
						echo "<br>result bam=". count($data_bam );

						$this->mongo_db->where($opper_search);
						$response_bam_sold = $this->mongo_db->get('sold_buy_orders_bam');
						$data_bam_sold = iterator_to_array($response_bam_sold);
						echo "<br>result bam sold =". count($data_bam_sold);

						if(count($data_bam) > 0 || count($data_bam_sold) > 0){
							$update_fields['opp_came_bam'] = '1';
						}else{
							$update_fields['opp_came_bam'] = '0';
						}
					}


					if($btc > "0" && $usdt == "0" && !isset($value['usdt_invest_amount']) &&  !isset($value['btc_invest_amount'])){
						$update_fields['usdt_invest_amount'] = $btcusdt * $btc;//(float)$btc;
						$update_fields['btc_invest_amount']  = $btc;  //for chart view 

					}
					elseif($usdt > "0" && $btc == "0" && !isset($value['usdt_invest_amount']) && !isset($value['only_usdt_invest_amount'])) {
						$update_fields['usdt_invest_amount'] = $usdt;
						$update_fields['only_usdt_invest_amount'] = $usdt;  //for chart view
					}

					foreach($api_response as $as_1){
						if($as_1->max_price !='' && $as_1->min_price !='' && $as_1->min_price != 0 && $as_1->max_price != 0){
							$update_fields['5_max_value'] = $as_1->max_price;
							echo "<br>max =". $update_fields['5_max_value'];
							$update_fields['5_min_value'] = $as_1->min_price;  
							echo "<br> min =". $update_fields['5_min_value'];
						} //loop inner check				
					} // foreach loop end


					foreach($api_response_10 as $as){
						if($as->max_price !='' && $as->min_price !='' && $as->min_price !=0 && $as->max_price !=0){
							echo "<br>max 10 = ".$as->max_price;
							$update_fields['10_max_value'] = $as->max_price; 
							echo "<br>min 10=".$as->min_price;
							$update_fields['10_min_value'] = $as->min_price;
						} // if inner check	
					} //end foreach loop
			
					echo"<br><pre>";
					print_r($update_fields);
						$collection_name = 'opportunity_logs_bam';
						$this->mongo_db->where($search_update);
						$this->mongo_db->set($update_fields);
						$query = $this->mongo_db->update($collection_name);
			}
		} //end foreach
		echo "<br>current time".$current_date_time;
		echo "<br>Total Picked Oppertunities Ids= " . count($response);
		//Save last Cron Executioon
		$this->last_cron_execution_time('Bam live opportunity', '1m', 'run bam live opportunity logs (* * * * *)', 'reports');
	} //end cron


	/////////////////////////////////////////////////////////////////////////////
	///////////////          ASIM CRONE TEST BINANCE           /////////////////
	/////////////////////////////////////////////////////////////////////////////
	public function insert_latest_oppertunity_into_log_collection_test_binance(){
		$this->load->helper('new_common_helper');
		$marketPrices = marketPrices('binance');
		foreach($marketPrices as $price){
			if($price['_id'] == 'ETHBTC'){
				$ethbtc = (float)$price['price'];
			}elseif($price['_id'] == 'BTCUSDT'){
				$btcusdt = (float)$price['price'];
			}elseif($price['_id'] == 'XRPBTC'){
				$xrpbtc = (float)$price['price'];
			}elseif($price['_id'] == 'XRPUSDT'){
				$xrpusdt = (float)$price['price'];
			}elseif($price['_id'] == 'NEOBTC'){
				$neobtc = (float)$price['price'];
			}elseif($price['_id'] == 'NEOUSDT'){
				$neousdt = (float)$price['price'];
			}elseif($price['_id'] == 'QTUMBTC'){
				$qtumbtc = (float)$price['price'];
			}elseif($price['_id'] == 'QTUMUSDT'){
				$qtumusdt = (float)$price['price'];
			}elseif($price['_id'] == 'XLMBTC'){
				$xml = (float)$price['price'];
			}elseif($price['_id'] == 'XEMBTC'){
				$xem = (float)$price['price'];
			}elseif($price['_id'] == 'POEBTC'){
				$poe = (float)$price['price'];
			}elseif($price['_id'] == 'TRXBTC'){
				$trx = (float)$price['price'];
			}elseif($price['_id'] == 'ZENBTC'){
				$zen = (float)$price['price'];
			}elseif($price['_id'] == 'ETCBTC'){
				$etcbtc = (float)$price['price'];
			}elseif($price['_id'] =='EOSBTC'){
				$eosbtc = (float)$price['price'];
			}elseif($price['_id'] =='LINKBTC'){
				$linkbtc = (float)$price['price'];
			}elseif($price['_id'] =='DASHBTC'){
				$dashbtc = (float)$price['price'];
			}elseif($price['_id'] =='XMRBTC'){
				$xmrbtc = (float)$price['price'];
			}elseif($price['_id'] =='ADABTC'){
				$adabtc = (float)$price['price'];
			}elseif($price['_id'] =='LTCUSDT'){
				$ltcusdt = (float)$price['price'];
			}elseif($price['_id'] =='EOSUSDT'){
				$eosusdt = (float)$price['price'];
			}				
		} //end loop 
		$current_date_time =  date('Y-m-d H:i:s');
		$current_time_date =  $this->mongo_db->converToMongodttime($current_date_time);

		$current_hour =  date('Y-m-d H:i:s', strtotime('-40 minutes'));
		$orig_date1 = $this->mongo_db->converToMongodttime($current_hour);

		$previous_one_month_date_time = date('Y-m-d H:i:s', strtotime('- 1 month'));
		$pre_date_1 =  $this->mongo_db->converToMongodttime($previous_one_month_date_time);

		// $startDate = $this->mongo_db->converToMongodttime(date('Y-10-1 00:00:00'));
		// $endDate = $this->mongo_db->converToMongodttime(date('Y-10-31 23:59:59'));

		$connection = $this->mongo_db->customQuery();      
		$condition = array('sort' => array('created_date' => -1), 'limit'=> 3);
		if(!empty($this->input->get())){
			$where['opportunity_id'] = $this->input->get('opportunityId');
		}else{
			$where['mode'] ='live';
			$where['created_date'] = array('$gte'=>$pre_date_1);
			$where['level'] = array('$ne'=>'level_15');
			$where['is_modified'] = array('$exists'=>false);
			$where['modified_date'] = array('$lte'=>$orig_date1);
		}

		// $where['mode'] ='test';
		// $where['created_date'] = array('$gte'=>$pre_date_1);
		// $where['level'] = array('$ne'=>'level_15');
		// $where['is_modified'] = array('$exists'=>false);
		// $where['modified_date'] = array('$lte'=>$orig_date1);
		// $where['modified_date'] = array('$gte'=>$startDate, '$lte' => $endDate);
		//$where['opportunity_id']['$in'] = array('5f8d91cc410eaf18a7496996');
		$find_rec = $connection->opportunity_logs_test_binance->find($where,  $condition);
		$response = iterator_to_array($find_rec);
		foreach ($response as $value){
			$coin= $value['coin'];
			$start_date = $value['created_date']->toDateTime()->format("Y-m-d H:i:s");
			$timestamp = strtotime($start_date);
			$time = $timestamp + (5 * 60 * 60);
			$end_date = date("Y-m-d H:i:s", $time);

			$hours_10 = $timestamp + (10 * 60 * 60);
			$time_10_hours = date("Y-m-d H:i:s", $hours_10);

			$cidition_check = $this->mongo_db->converToMongodttime($end_date);
			$cidition_check_10 = $this->mongo_db->converToMongodttime($time_10_hours);
				$params = array(   
					'coin'       => $value['coin'],
					'start_date' => (string)$start_date,
					'end_date'   => (string)$end_date,
				);	
				echo "<br>current time=".$current_date_time;
				echo"<br>created_date =".$start_date;
				echo"<br>start date +5 =".$end_date;
				echo"<br>start date +10 =".$time_10_hours;

				if($cidition_check <= $current_time_date){
					$jsondata = json_encode($params);
					$curl = curl_init();
					curl_setopt_array($curl, array(
					CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS =>$jsondata,
					CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
					));
					$response_price = curl_exec($curl);	
					curl_close($curl);                                
					$api_response = json_decode($response_price);
					echo "<pre>";print_r($api_response);
				}// main if check for time comapire

				$params_10_hours = array(
					'coin'       => $value['coin'],
					'start_date' => (string)$start_date,
					'end_date'   => (string)$time_10_hours,
				);
				if($cidition_check_10 <= $current_time_date){
					$jsondata = json_encode($params_10_hours);
					$curl_10 = curl_init();
					curl_setopt_array($curl_10, array(
						CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS =>$jsondata,
						CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
					));
					$response_price_10 = curl_exec($curl_10);	
					curl_close($curl_10);
					$api_response_10 = json_decode($response_price_10);
					echo "<pre>";print_r($api_response_10);
				}
			if ($value['level'] != 'level_15' ) {
				$open_lth_avg_per_trade = 0;
				$open_lth_avg = 0;
				$avg_sold = 0;
				$parents_executed = 0;
				$parents_executed = $value['parents_executed'];
				
				$search_update['opportunity_id'] = $value['opportunity_id'];
				$search_update['mode']= 'test';
				
				$other['application_mode']= 'test';
				$other['opportunityId'] =  $value['opportunity_id'];
				$other['status'] = array('$nin' => array('LTH', 'FILLED','canceled','new_ERROR'));
				$buyOther = $connection->buy_orders->count($other);
				/////////////////////////////////////////////////////////

				$otherSold['application_mode']= 'test';
				$otherSold['opportunityId'] =  $value['opportunity_id'];
				$otherSold['is_sell_order'] = array('$nin' => array('sold'));
				$otherSold = $connection->sold_buy_orders->count($otherSold);
				$totalOther = $buyOther+ $otherSold;
				///////////////////////////////////////////////////////////
				$search_open_lth['application_mode']= 'test';
				$search_open_lth['opportunityId'] = $value['opportunity_id'];
				$search_open_lth['status'] = array('$in' => array('LTH', 'FILLED'));

				print_r("<br>oppertunity_id=".$value['opportunity_id']);
				/////
				$search_cancel['application_mode']= 'test';
				$search_cancel['opportunityId'] = $value['opportunity_id'];
				$search_cancel['status'] = array('$in' => array('canceled'));
				//////
				$search_new_error['application_mode']= 'test';
				$search_new_error['opportunityId'] = $value['opportunity_id'];
				$search_new_error['status'] = array('$in' => array('new_ERROR'));
				////////
				$search_sold['application_mode']= 'test';
				$search_sold['opportunityId'] = $value['opportunity_id'];
				$search_sold['is_sell_order'] = array('$in' => array('sold'));

				$search_resumed['application_mode']= 'test';
				$search_resumed['opportunityId'] = $value['opportunity_id'];
				$search_resumed['resume_status'] = array('$in' => array('resume'));
				
				///////////////////////////////////////////////////////////////
				$this->mongo_db->where($search_resumed);
				$total_resumed_sold = $this->mongo_db->get('sold_buy_orders');
				$total_reumed_sold   = iterator_to_array($total_resumed_sold);
				
				foreach($total_reumed_sold as $value){
					echo "<br>Resume sold order_id = ".$value['_id'];
				}
				$this->mongo_db->where($search_resumed);
				$total_resumed = $this->mongo_db->get('buy_orders');
				$total_reumed   = iterator_to_array($total_resumed);
				foreach($total_reumed as $value){
					echo "<br>Resume open order_id = ".$value['_id'];
				}
				$this->mongo_db->where($search_open_lth);
				$total_open = $this->mongo_db->get('buy_orders');
				$total_open_lth_rec   = iterator_to_array($total_open);

				$this->mongo_db->where($search_cancel);
				$total_cancel = $this->mongo_db->get('buy_orders');
				$total_cancel_rec   = iterator_to_array($total_cancel);

				///////////////////////////////////////////////////////////////////////////////

				$this->mongo_db->where($search_new_error);
				$total_new_error = $this->mongo_db->get('buy_orders');
				$total_new_error_rec   = iterator_to_array($total_new_error);

				// 	/////////////////////////////////////////////////////////////////////////////

				$this->mongo_db->where($search_sold);
				$total_sold_total = $this->mongo_db->get('sold_buy_orders');
				$total_sold_rec   = iterator_to_array($total_sold_total);
				
				// ////////////////////////////////////////////////CALCULATE LTH AND OPEN ORDERS AVG
				$open_lth_puchase_price = 0;
				$open_lth_avg = 0;
				$open_lth_avg_per_trade= 0;
				
				echo"<br>Total open lth = ".count($total_open_lth_rec);
				if (count($total_open_lth_rec) > 0){
					echo "<br> Open/lth Calculation";
					foreach ($total_open_lth_rec as $key => $value2) {
						// $commission_array = $value2['buy_fraction_filled_order_arr'];
						if($value2['symbol'] == 'ETHBTC'){
							$open_lth_puchase_price += (float) ($ethbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$ethbtc;
						}elseif($value2['symbol'] == 'LINKBTC'){
							$open_lth_puchase_price += (float) ($linkbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$linkbtc;
						}elseif($value2['symbol'] == 'DASHBTC'){
							$open_lth_puchase_price += (float) ($dashbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$dashbtc;
						}elseif($value2['symbol'] == 'XMRBTC'){
							$open_lth_puchase_price += (float) ($xmrbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$xmrbtc;
						}elseif($value2['symbol'] == 'ADABTC'){
							$open_lth_puchase_price += (float) ($adabtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$adabtc;
						}elseif($value2['symbol'] == 'LTCUSDT'){
							$open_lth_puchase_price += (float) ($ltcusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "btc current price =".$ltcusdt."<br>";
							echo "purchase price =".$value2['purchased_price']."<br>";
						}elseif($value2['symbol'] == 'BTCUSDT'){
							$open_lth_puchase_price += (float) ($btcusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "btc current price =".$btcusdt."<br>";
							echo "purchase price =".$value2['purchased_price']."<br>";
						}elseif($value2['symbol'] == 'XRPBTC'){
							$open_lth_puchase_price += (float) ($xrpbtc - $value2['purchased_price']) / $value2['purchased_price'];
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$xrpbtc;
						}elseif($value2['symbol'] == 'XRPUSDT'){
							$open_lth_puchase_price += (float) ($xrpusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$xrpusdt;
						}elseif($value2['symbol'] == 'NEOBTC'){
							$open_lth_puchase_price += (float) ($neobtc - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$neobtc;
						}elseif($value2['symbol'] == 'NEOUSDT'){
							$open_lth_puchase_price += (float) ($neousdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$neousdt;
						}elseif($value2['symbol'] == 'QTUMBTC'){
							$open_lth_puchase_price += (float) ($qtumbtc - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$qtumbtc;
						}elseif($value2['symbol'] == 'QTUMUSDT'){
							$open_lth_puchase_price += (float) ($qtumusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$qtumusdt;
						}elseif($value2['symbol'] == 'XLMBTC'){
							$open_lth_puchase_price += (float) ($xml - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$xml;		
						}elseif($value2['symbol'] == 'XEMBTC'){
							$open_lth_puchase_price += (float) ($xem - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$xem;								
						}elseif($value2['symbol'] == 'POEBTC'){
							$open_lth_puchase_price += (float) ($poe - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$poe;										
						}elseif($value2['symbol'] == 'TRXBTC'){
							$open_lth_puchase_price += (float) ($trx - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$trx;				
						}elseif($value2['symbol'] == 'ZENBTC'){
							$open_lth_puchase_price += (float) ($zen - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$zen;										
						}elseif($value2['symbol'] == 'ETCBTC'){
							$open_lth_puchase_price += (float) ($etcbtc - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$etcbtc;				
						}elseif($value2['symbol'] == 'EOSBTC'){
							$open_lth_puchase_price += (float) ($eosbtc - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$eosbtc;										
						}elseif($value2['symbol'] == 'EOSUSDT'){
							$open_lth_puchase_price += (float) ($eosusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$eosusdt;
						}		
						echo "<br>open_lth_puchase_price +=";
						print_r($open_lth_puchase_price);
						//	array_sum($value2['sell_price']);
						echo "<br> order_id = ".$value2['_id'];
					}//end loop
					$open_lth_avg_per_trade = (float) $open_lth_puchase_price * 100;
					$open_lth_avg = (float) ($open_lth_avg_per_trade / count($total_open_lth_rec));
				
					echo "<br>avg_sold = ";
					print_r($open_lth_avg);
				}//end if
				// /////////////////////////////////////////////////////////////////END OPEN LTH AVG
			
				// ////////////////////////////////////////////////////////////////CALCULATE SOLD AVG
				$sold_puchase_price = 0;
				$avg_sold_CSL = 0;
				$CSL_per_trade_sold = 0;
				$CSL_sold_purchase_price = 0 ;
				$avg_manul = 0;
				$per_trade_sold_manul = 0;
				$manul_sold_purchase_price = 0;
				$avg_sold = 0;
				$per_trade_sold = 0;
			
				if(count($total_sold_rec) > 0){
					echo "<br> sold calculation";
					foreach ($total_sold_rec as $key => $value1) {
						if(isset($value1['is_manual_sold'])){
							$manul_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];											
							print_r("<br> Market sold price manul = ".$value1['market_sold_price']);
							print_r("<br>purchase price manul =".$value1['purchased_price']);
							print_r("<br> sold_puchase_price manul + =".$manul_sold_purchase_price);
							echo '<br>order_id manul ='.$value1['_id'];	
						}elseif(isset($value1['csl_sold'])){
							$CSL_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];											
							print_r("<br> Market sold price = ".$value1['market_sold_price']);
							print_r("<br>purchase price =".$value1['purchased_price']);
							print_r("<br> CSL sold_puchase_price + =".$CSL_sold_purchase_price);
							echo '<br>order_id ='.$value1['_id'];
						}else{
							$sold_puchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
							print_r("<br> Market sold price = ".$value1['market_sold_price']);
							print_r("<br>purchase price =".$value1['purchased_price']);
							print_r("<br> sold_puchase_price + =".$sold_puchase_price);
							echo '<br>order_id ='.$value1['_id'];
						}
					} //end sold foreach

					// if manul sold greater than 0 add in avg parofit 
					if($manul_sold_purchase_price > 0)
					{
						$sold_puchase_price += $manul_sold_purchase_price;
						$manul_sold_purchase_price = 0;
					}

					// if CSL sold greater than 0 add in avg parofit 
					if($CSL_sold_purchase_price > 0)
					{
						$sold_puchase_price += $CSL_sold_purchase_price;
						$CSL_sold_purchase_price = 0;
					}
					if($manul_sold_purchase_price != "0"){
						$per_trade_sold_manul = (float) $manul_sold_purchase_price * 100;
						echo "<br>per tarde manul = ".$per_trade_sold_manul;
						$avg_manul = (float) ($per_trade_sold_manul / (count($total_sold_rec)));
						echo "<br>avg_sold manul = ";
						print_r($avg_manul);
						print_r("<br>sold count = ".count($total_sold_rec));
					}
					if($sold_puchase_price !="0"){
						$per_trade_sold = (float) $sold_puchase_price * 100;
						echo "<br>per tarde = ".$per_trade_sold;
						$avg_sold = (float) ($per_trade_sold / count($total_sold_rec)); 
						// $per_trade_sold1 = $avg_sold * count($total_sold_rec);    
						echo "<br>avg_sold = ";
						// echo "<br> per_trade_sold1 ".$per_trade_sold1 ;
						print_r($avg_sold);
						print_r("<br>sold count = ".count($total_sold_rec));
					}
					if($CSL_sold_purchase_price !="0"){
						$CSL_per_trade_sold = (float) $CSL_sold_purchase_price * 100;
						echo "<br>per tarde CSL = ".$CSL_per_trade_sold;
						$avg_sold_CSL = (float) ($CSL_per_trade_sold / count($total_sold_rec));
						echo "<br>avg_sold CSL = ";
						print_r($avg_sold_CSL);
						print_r("<br>sold count = ".count($total_sold_rec));
					}
				}//end response > 0 check 
				print_r("<br>oppertunity_id=".$value['opportunity_id']."<br>"); 	
			
				// /////////////////////////////////////////////////////////////////////////END SOLD AVG

				$total_orders = count($total_open_lth_rec) + count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $totalOther;
				$disappear = $parents_executed -  $total_orders;
				$total = count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $disappear;
				if($total == $parents_executed ) {
					$update_fields = array(
						'open_lth'     => count($total_open_lth_rec),
						'new_error'    => count($total_new_error_rec),
						'reumed_child' => count($total_reumed) + count($total_reumed_sold),       
						'costAvgCount' => ($costAvgReturn + $soldCostAvgReturn),
						'cancelled'    => count($total_cancel_rec),
						'sold'         => count($total_sold_rec),         
						'avg_open_lth' => $open_lth_avg,
						'other_status' => $totalOther,
						// 'per_trade_sold' => $per_trade_sold1,
						'avg_sold'     => $avg_sold,
						'avg_manul'    =>$avg_manul,
						'avg_sold_CSL' => $avg_sold_CSL,
						'modified_date' =>$current_time_date  
					);
					if(isset($value['10_max_value']) && isset($value['5_max_value'])){
						$update_fields['is_modified']  = true;
					}
					if(count($total_open_lth_rec)== 0 && count($total_sold_rec) == 0 &&  $totalOther == 0 ){
						$update_fields['oppertunity_missed'] = true;
					}
					}else { 
						$update_fields = array(
							'open_lth'     => count($total_open_lth_rec),
							'new_error'    => count($total_new_error_rec),
							'cancelled'    => count($total_cancel_rec),
							'costAvgCount' => ($costAvgReturn + $soldCostAvgReturn),
							'reumed_child' => count($total_reumed) + count($total_reumed_sold) ,
							'sold'         => count($total_sold_rec),
							'avg_open_lth' => $open_lth_avg,
							// 'per_trade_sold' => $per_trade_sold1,
							'avg_sold'     => $avg_sold,
							'other_status' => $totalOther,   
							'avg_manul'    =>$avg_manul,
							'avg_sold_CSL' => $avg_sold_CSL,
							'modified_date'=>$current_time_date
						);
					}
					$db = $this->mongo_db->customQuery();
					$pipeline = [
					[
						'$match' =>[
						'application_mode' => 'test',
						'parent_status' => ['$exists' => false ],
						'opportunityId' => $value['opportunity_id'],
						'status' => ['$in'=>['LTH','FILLED']],
						],
					],
						[
						'$sort' =>['created_date'=> -1],
						],
						['$limit'=>1]
					];
					$result_buy = $db->buy_orders->aggregate($pipeline);
					$res = iterator_to_array($result_buy);

					$pipeline1 = [
					[
						'$match' =>[
						'application_mode' => 'test',
						'parent_status' => ['$exists' => false ],
						'opportunityId' => $value['opportunity_id'],
						'status' => ['$in'=>['LTH','FILLED']],
						],
					],
						[
						'$sort' =>['created_date'=> 1],
						],
						['$limit'=>1]
					];
					$result_buy1 = $db->buy_orders->aggregate($pipeline1);
					$res1 = iterator_to_array($result_buy1);
					if(!isset($value['first_order_buy']) && !isset($value['last_order_buy'])){
						echo "<br> created_date first =".$res[0]['created_date'];
						echo "<br>created_date last = ".$res1[0]['created_date'];
						$update_fields['first_order_buy'] =  $res[0]['created_date'];
						$update_fields['last_order_buy'] =  $res1[0]['created_date'];
					}
					foreach($api_response as $as_1){
						if($as_1->max_price !='' && $as_1->min_price !='' && $as_1->min_price != 0 && $as_1->max_price != 0){
							$update_fields['5_max_value'] = $as_1->max_price;
							echo "<br>max =". $update_fields['5_max_value'];
							$update_fields['5_min_value'] = $as_1->min_price;  
							echo "<br> min =". $update_fields['5_min_value'];
						} //loop inner check				
					} // foreach loop end

					foreach($api_response_10 as $as){
						if($as->max_price !='' && $as->min_price !='' && $as->min_price !=0 && $as->max_price !=0){
							echo "<br>max 10 = ".$as->max_price;
							$update_fields['10_max_value'] = $as->max_price; 
							echo "<br>min 10=".$as->min_price;
							$update_fields['10_min_value'] = $as->min_price;
						} // if inner check	
					} //end foreach loop

				echo"<br><pre>";
				print_r($update_fields);
				$collection_name = 'opportunity_logs_test_binance';
				$this->mongo_db->where($search_update);
				$this->mongo_db->set($update_fields);
				$query = $this->mongo_db->update($collection_name);	
			}
		} //end foreach
		echo "<br>current time".$current_date_time;
		echo "<br>Total Picked Oppertunities Ids= " . count($response);
		//Save last Cron Executioon
		$this->last_cron_execution_time('Binance test opportunity', '9m', 'start time.'.$current_date_time.'run binance test opportunity calculation (9 * * * *)end time'.date('Y-m-d H:i:s'), 'reports');
	} //end cron

	/////////////////////////////////////////////////////////////////////////////
	///////////////           ASIM CRONE TEST KRAKEN            /////////////////
	/////////////////////////////////////////////////////////////////////////////

	public function insert_latest_oppertunity_into_log_collection_test_kraken(){
		$collection_name = 'opportunity_logs_test_kraken';
		$marketPrices = marketPrices('kraken');
		$this->load->helper('new_common_helper');    
		foreach($marketPrices as $price){
			if($price['_id'] == 'XRPBTC'){   
				$xrpbtc = (float)$price['price'];
			}elseif($price['_id'] == 'BTCUSDT'){
				$btcusdt = (float)$price['price'];
			}elseif($price['_id'] == 'LINKBTC'){
				$linkbtc = (float)$price['price'];
			}elseif($price['_id'] == 'XLMBTC'){
				$xlmbtc = (float)$price['price'];
			}elseif($price['_id'] == 'ETHBTC'){
				$ethbtc = (float)$price['price'];
			}elseif($price['_id'] == 'XMRBTC'){
				$xmrbtc = (float)$price['price'];
			}elseif($price['_id'] == 'ADABTC'){
				$adabtc = (float)$price['price'];
			}elseif($price['_id'] == 'QTUMBTC'){
				$qtumbtc = (float)$price['price'];
			}elseif($price['_id'] == 'TRXBTC'){
				$trxbtc = (float)$price['price'];
			}elseif($price['_id'] == 'XRPUSDT'){
				$xrpusdt = (float)$price['price'];
			}elseif($price['_id'] == 'LTCUSDT'){
				$ltcusdt = (float)$price['price'];
			}elseif($price['_id'] == 'EOSBTC'){      
				$eosbtc = (float)$price['price'];
			}elseif($price['_id'] == 'EOSUSDT'){      
				$eosusdt = (float)$price['price'];
			}elseif($price['_id'] == 'ETCBTC'){       
				$etcbtc = (float)$price['price'];
			}elseif($price['_id'] == 'DASHBTC'){       
				$dashbtc = (float)$price['price'];
			}				
		}//end loop
		$current_date_time =  date('Y-m-d H:i:s');
		$current_time_date =  $this->mongo_db->converToMongodttime($current_date_time);
		
		$current_hour =  date('Y-m-d H:i:s', strtotime('-59 minutes'));
		$orig_date1 = $this->mongo_db->converToMongodttime($current_hour);

		$previous_one_month_date_time = date('Y-m-d H:i:s', strtotime(' - 1 month'));
		$pre_date_1 =  $this->mongo_db->converToMongodttime($previous_one_month_date_time);

		$connection = $this->mongo_db->customQuery();      
		$condition = array('sort' => array('created_date' => -1), 'limit'=>3);

		if(!empty($this->input->get())){
			$where['opportunity_id'] = $this->input->get('opportunityId');
		}else{
			$where['mode'] ='live';
			$where['created_date'] = array('$gte'=>$pre_date_1);
			$where['level'] = array('$ne'=>'level_15');
			$where['is_modified'] = array('$exists'=>false);
			$where['modified_date'] = array('$lte'=>$orig_date1);
		}
		// $where['mode'] ='test';
		// $where['created_date'] = array('$gte'=>$pre_date_1);
		// $where['level'] = array('$ne'=>'level_15');
		// $where['is_modified'] = array('$exists'=>false);
		// $where['modified_date'] = array('$lte'=>$orig_date1);
		
		// $where['opportunity_id']['$in'] = array('5f20d870e17fd050105ea813', '5f204bdbe17fd050105ea7c7');
		$find_rec = $connection->$collection_name->find($where,  $condition);
		$response = iterator_to_array($find_rec);

		foreach ($response as $value){
			$coin= $value['coin'];
			$start_date = $value['created_date']->toDateTime()->format("Y-m-d H:i:s");
			$timestamp = strtotime($start_date);
			$time = $timestamp + (5 * 60 * 60);
			$end_date = date("Y-m-d H:i:s", $time);

			$hours_10 = $timestamp + (10 * 60 * 60);
			$time_10_hours = date("Y-m-d H:i:s", $hours_10);

			$cidition_check = $this->mongo_db->converToMongodttime($end_date);
			$cidition_check_10 = $this->mongo_db->converToMongodttime($time_10_hours);
				$params = array(
				'coin'       => $value['coin'],
				'start_date' => (string)$start_date,
				'end_date'   => (string)$end_date,
				);
				echo "<br>current time=".$current_date_time;
				echo"<br>created_date =".$start_date;
				echo"<br>start date +5 =".$end_date;
				echo"<br>start date +10 =".$time_10_hours;

				if($cidition_check <= $current_time_date){
					$jsondata = json_encode($params);
					$curl = curl_init();
					curl_setopt_array($curl, array(	
						CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS =>$jsondata,
						CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
					));
					$response_price = curl_exec($curl);	
					curl_close($curl);                                
					$api_response = json_decode($response_price);
				} // main if check for time comapire

				$params_10_hours = array(
					'coin'       => $value['coin'],
					'start_date' => (string)$start_date,
					'end_date'   => (string)$time_10_hours,
				);
				if($cidition_check_10 <= $current_time_date){
					$jsondata = json_encode($params_10_hours);
						$curl_10 = curl_init();
						curl_setopt_array($curl_10, array(
						CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS =>$jsondata,
						CURLOPT_HTTPHEADER => array(
							"Content-Type: application/json"
						), 
						));
						$response_price_10 = curl_exec($curl_10);	
						curl_close($curl_10);
						$api_response_10 = json_decode($response_price_10);
						//echo "<pre>";print_r($api_response_10);
				}
			if ($value['level'] != 'level_15' ){
				$open_lth_avg_per_trade = 0;
				$open_lth_avg = 0;
				$avg_sold = 0;
				$parents_executed = 0;
				$parents_executed = $value['parents_executed'];
				
				$search_update['opportunity_id'] = $value['opportunity_id'];
				$search_update['mode']= 'test';
				
				$other['application_mode']= 'test';
				$other['opportunityId'] =  $value['opportunity_id'];
				$other['status'] = array('$nin' => array('LTH', 'FILLED','canceled','new_ERROR'));
				$buyOther = $connection->buy_orders_kraken->count($other);

				$otherSold['application_mode']= 'test';
				$otherSold['opportunityId'] =  $value['opportunity_id'];
				$otherSold['is_sell_order'] = array('$nin' => array('sold'));
				$otherSold = $connection->sold_buy_orders_kraken->count($otherSold);
				$totalOther = $buyOther+ $otherSold;
				///////////////////////////////////////////////////////////
				$search_open_lth['application_mode']= 'test';
				$search_open_lth['opportunityId'] = $value['opportunity_id'];
				$search_open_lth['status'] = array('$in' => array('LTH', 'FILLED'));
				/////
				$search_cancel['application_mode']= 'test';
				$search_cancel['opportunityId'] = $value['opportunity_id'];
				$search_cancel['status'] = array('$in' => array('canceled'));
				//////
				$search_new_error['application_mode']= 'test';
				$search_new_error['opportunityId'] = $value['opportunity_id'];
				$search_new_error['status'] = array('$in' => array('new_ERROR'));
				////////
				$search_sold['application_mode']= 'test';
				$search_sold['opportunityId'] = $value['opportunity_id'];
				$search_sold['is_sell_order'] = array('$in' => array('sold'));

				$search_resumed['application_mode']= 'test';
				$search_resumed['opportunityId'] = $value['opportunity_id'];
				$search_resumed['resume_status'] = array('$in' => array('resume'));

				///////////////////////////////////////////////////////////////

				$this->mongo_db->where($search_resumed);
				$total_reumed = $this->mongo_db->get('buy_orders_kraken');
				$total_reumed_order   = iterator_to_array($total_reumed);   

				$this->mongo_db->where($search_resumed);
				$total_reumed_sold = $this->mongo_db->get('sold_buy_orders_kraken');
				$total_reumed_sold_orders   = iterator_to_array($total_reumed_sold);

				$this->mongo_db->where($search_open_lth);
				$total_open = $this->mongo_db->get('buy_orders_kraken');
				$total_open_lth_rec   = iterator_to_array($total_open);

				$this->mongo_db->where($search_cancel);
				$total_cancel = $this->mongo_db->get('buy_orders_kraken');
				$total_cancel_rec   = iterator_to_array($total_cancel);

				$this->mongo_db->where($search_new_error);
				$total_new_error = $this->mongo_db->get('buy_orders_kraken');
				$total_new_error_rec   = iterator_to_array($total_new_error);

				$this->mongo_db->where($search_sold);
				$total_sold_total = $this->mongo_db->get('sold_buy_orders_kraken');
				$total_sold_rec   = iterator_to_array($total_sold_total);
				
				$open_lth_puchase_price = 0;
				$open_lth_avg = 0;
				$open_lth_avg_per_trade= 0;
				echo"<br>Total open lth = ".count($total_open_lth_rec);
				if (count($total_open_lth_rec) > 0){
					$puschasePrice = $value2['purchased_price'];
					echo "<br> Open/lth Calculation";
					foreach ($total_open_lth_rec as $key => $value2){
						if($value2['symbol'] == 'ETHBTC'){    
							$open_lth_puchase_price += (float) ($ethbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$ethbtc;
						}elseif($value2['symbol'] == 'BTCUSDT'){
							$open_lth_puchase_price += (float) ($btcusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "btc current price =".$btcusdt."<br>";
							echo "purchase price =".$value2['purchased_price']."<br>";
						}elseif($value2['symbol'] == 'XRPBTC'){
							$open_lth_puchase_price += (float) ($xrpbtc - $value2['purchased_price']) / $value2['purchased_price'];
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$xrpbtc;
						}elseif($value2['symbol'] == 'XRPUSDT'){
							$open_lth_puchase_price += (float) ($xrpusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$xrpusdt;
						}elseif($value2['symbol'] == 'LINKBTC'){
							$open_lth_puchase_price += (float) ($linkbtc - $value2['purchased_price']) / $value2['purchased_price'];
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$linkbtc;
						}elseif($value2['symbol'] == 'XLMBTC'){
							$open_lth_puchase_price += (float) ($xlmbtc - $value2['purchased_price']) / $value2['purchased_price'];
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$xlmbtc;
						}elseif($value2['symbol'] == 'XMRBTC'){
							$open_lth_puchase_price += (float) ($xmrbtc - $value2['purchased_price']) / $value2['purchased_price'];
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$xmrbtc;
						}elseif($value2['symbol'] == 'ADABTC'){
							$open_lth_puchase_price += (float) ($adabtc - $value2['purchased_price']) / $value2['purchased_price'];
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$adabtc;
						}elseif($value2['symbol'] == 'QTUMBTC'){
							$open_lth_puchase_price += (float) ($qtumbtc - $value2['purchased_price']) / $value2['purchased_price'];
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$qtumbtc;   
						}elseif($value2['symbol'] == 'TRXBTC'){
							$open_lth_puchase_price += (float) ($trxbtc - $value2['purchased_price']) / $value2['purchased_price'];
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$trxbtc;
						}elseif($value2['symbol'] == 'LTCUSDT'){
							$open_lth_puchase_price += (float) ($ltcusdt - $value2['purchased_price']) / $value2['purchased_price'];
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$ltcusdt;
						}elseif($value2['symbol'] == 'EOSBTC'){
							$open_lth_puchase_price += (float) ($eosbtc - $value2['purchased_price']) / $value2['purchased_price'];
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$eosbtc;
						}elseif($value2['symbol'] == 'ETCBTC'){
							$open_lth_puchase_price += (float) ($etcbtc - $value2['purchased_price']) / $value2['purchased_price'];
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$etcbtc;
						}elseif($value2['symbol'] == 'EOSUSDT'){
							$open_lth_puchase_price += (float) ($eosusdt - $value2['purchased_price']) / $value2['purchased_price'];
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$eosusdt;
						}elseif($value2['symbol'] == 'DASHBTC'){
							$open_lth_puchase_price += (float) ($dashbtc - $value2['purchased_price']) / $value2['purchased_price'];
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$dashbtc;
						}		    
						echo "<br>open_lth_puchase_price +=";
						print_r($open_lth_puchase_price);
					//	array_sum($value2['sell_price']);
						echo "<br> order_id = ".$value2['_id'];
					}//end loop
						$open_lth_avg_per_trade = (float) $open_lth_puchase_price * 100;
						$open_lth_avg = (float) ($open_lth_avg_per_trade / count($total_open_lth_rec));
				
						echo "<br>avg_sold = ";
						print_r($open_lth_avg);
				}//end if

				$sold_puchase_price = 0;
				$avg_sold_CSL = 0;
				$CSL_per_trade_sold = 0;
				$CSL_sold_purchase_price = 0 ;
				$avg_manul = 0;
				$per_trade_sold_manul = 0;
				$manul_sold_purchase_price = 0;
				$avg_sold = 0;
				$per_trade_sold = 0;
				if (count($total_sold_rec) > 0){
					echo "<br> sold calculation";
					foreach ($total_sold_rec as $key => $value1){
						$puschasePrice = $value1['purchased_price'];
						if(isset($value1['is_manual_sold'])){
							$manul_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
							print_r("<br> Market sold price manul = ".$value1['market_sold_price']);
							print_r("<br>purchase price manul =".$value1['purchased_price']);
							print_r("<br> sold_puchase_price manul + =".$manul_sold_purchase_price);
							echo '<br>order_id manul ='.$value1['_id'];	
						}elseif(isset($value1['csl_sold'])){
							$CSL_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
							print_r("<br> Market sold price = ".$value1['market_sold_price']);
							print_r("<br>purchase price =".$value1['purchased_price']);
							print_r("<br> CSL sold_puchase_price + =".$CSL_sold_purchase_price);
							echo '<br>order_id ='.$value1['_id'];
						}else{
							$sold_puchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
							print_r("<br> Market sold price = ".$value1['market_sold_price']);
							print_r("<br>purchase price =".$value1['purchased_price']);
							print_r("<br> sold_puchase_price + =".$sold_puchase_price);
							echo '<br>order_id ='.$value1['_id'];
						}
					} //end sold foreach
					if($manul_sold_purchase_price > 0){
						$sold_puchase_price += $manul_sold_purchase_price;
						$manul_sold_purchase_price = 0;
					}
					if($CSL_sold_purchase_price > 0)
					{
						$sold_puchase_price += $CSL_sold_purchase_price;
						$CSL_sold_purchase_price = 0;
					}
					if($manul_sold_purchase_price != "0"){
						$per_trade_sold_manul = (float) $manul_sold_purchase_price * 100;
						echo "<br>per tarde manul = ".$per_trade_sold_manul;
						$avg_manul = (float) ($per_trade_sold_manul / count($total_sold_rec));
						echo "<br>avg_sold manul = ";
						print_r($avg_manul);
						print_r("<br>sold count = ".count($total_sold_rec));
					}
					if($sold_puchase_price !="0"){
						$per_trade_sold = (float) $sold_puchase_price * 100;
						echo "<br>per tarde = ".$per_trade_sold;
						$avg_sold = (float) ($per_trade_sold / count($total_sold_rec)); 
						echo "<br>avg_sold = ";
						print_r($avg_sold);
						print_r("<br>sold count = ".count($total_sold_rec));
					}
					if($CSL_sold_purchase_price !="0"){
						$CSL_per_trade_sold = (float) $CSL_sold_purchase_price * 100;
						echo "<br>per tarde CSL = ".$CSL_per_trade_sold;
						$avg_sold_CSL = (float) ($CSL_per_trade_sold / count($total_sold_rec));
						echo "<br>avg_sold CSL = ";
						print_r($avg_sold_CSL);
						print_r("<br>sold count = ".count($total_sold_rec));
					}
				}// End check >0
				print_r("<br>oppertunity_id=".$value['opportunity_id']."<br>");
				$total_orders = count($total_open_lth_rec) + count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $totalOther;
				$disappear = $parents_executed -  $total_orders;
				$total = count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $disappear;
				if ($total == $parents_executed){
					$update_fields = array(
						'open_lth'        => count($total_open_lth_rec),
						'new_error'       => count($total_new_error_rec),
						'cancelled'       => count($total_cancel_rec),
						'sold'            => count($total_sold_rec),
						'reumed_child'    => count($total_reumed_order) + count($total_reumed_sold_orders),
						'avg_open_lth'    => $open_lth_avg,
						'other_status'    => $totalOther,
						'per_trade_sold' => $per_trade_sold,
						'avg_sold'        => $avg_sold,
						'avg_manul'       =>$avg_manul,
						'avg_sold_CSL'    => $avg_sold_CSL,
						'modified_date'   =>$current_time_date  
					);

					if(isset($value['10_min_value']) && isset($value['10_max_value']) && isset($value['5_max_value']) && isset($value['5_min_value'])){
						$update_fields['is_modified']  = true;
					}
					if(count($total_open_lth_rec)== 0 && count($total_sold_rec) == 0 &&  $totalOther == 0 ){
						$update_fields['oppertunity_missed'] = true;
					}
					}else{ 
						$update_fields = array(
							'open_lth'     => count($total_open_lth_rec),
							'new_error'    => count($total_new_error_rec),
							'cancelled'    => count($total_cancel_rec),
							'sold'         => count($total_sold_rec),
							'avg_open_lth' => $open_lth_avg,
							'avg_sold'     => $avg_sold,
							'per_trade_sold' => $per_trade_sold,
							'reumed_child' => count($total_reumed_order) + count($total_reumed_sold_orders),
							'other_status' => $totalOther,   
							'avg_manul'    =>$avg_manul,
							'avg_sold_CSL' => $avg_sold_CSL,
							'modified_date'=>$current_time_date
						);
					}
					$db = $this->mongo_db->customQuery();
					$pipeline = [
					[
						'$match' =>[
						'application_mode' => 'test',
						'parent_status' => ['$exists' => false ],
						'opportunityId' => $value['opportunity_id'],
						'status' => ['$in'=>['LTH','FILLED']],
						],
					],
						[
						'$sort' =>['created_date'=> -1],
						],
						['$limit'=>1]
					];
					$result_buy = $db->buy_orders_kraken->aggregate($pipeline);
					$res = iterator_to_array($result_buy);

					$pipeline1 = [
					[
						'$match' =>[
						'application_mode' => 'test',
						'parent_status' => ['$exists' => false ],
						'opportunityId' => $value['opportunity_id'],
						'status' => ['$in'=>['LTH','FILLED']],
						],
					],
						[
						'$sort' =>['created_date'=> 1],
						],
						['$limit'=>1]
					];
					$result_buy1 = $db->buy_orders_kraken->aggregate($pipeline1);
					$res1 = iterator_to_array($result_buy1);
					if(!isset($value['first_order_buy']) && !isset($value['last_order_buy'])){
						echo "<br> created_date first =".$res[0]['created_date'];
						echo "<br>created_date last = ".$res1[0]['created_date'];
						$update_fields['first_order_buy'] =  $res[0]['created_date'];
						$update_fields['last_order_buy'] =  $res1[0]['created_date'];
					}
					if(!isset($value['opp_came_binance']) && !isset($value['opp_came_kraken']) && !isset($value['opp_came_bam'])){	
						$opper_search['application_mode']= 'test';
						$opper_search['opportunityId'] = $value['opportunity_id'];
						
						$connetct= $this->mongo_db->customQuery();
						$pending_curser = $connetct->buy_orders->find($opper_search);
						$buy_order = iterator_to_array($pending_curser);
						echo "<br>result binance=".count($buy_order);

						$pending_curser_buy = $connetct->sold_buy_order->find($opper_search);
						$sold_bbuy_order = iterator_to_array($pending_curser_buy);
						echo "<br>result binance sold=".count($sold_bbuy_order);

						if(count($buy_order) > 0 || count($sold_bbuy_order) > 0 ){
							$update_fields['opp_came_binance'] = '1';
						}else{
							$update_fields['opp_came_binance'] = '0';
						}
						
						$this->mongo_db->where($opper_search);
						$response_kraken = $this->mongo_db->get('buy_orders_kraken');
						$data_kraken = iterator_to_array($response_kraken);
						echo "<br>result kraken=". count($data_kraken);

						$this->mongo_db->where($opper_search);
						$response_kraken_sold = $this->mongo_db->get('sold_buy_orders_kraken');
						$data_kraken_sold = iterator_to_array($response_kraken_sold);
						echo "<br>result kraken sold=". count($data_kraken_sold);
						if(count($data_kraken) > 0 || count($data_kraken_sold) > 0){
							$update_fields['opp_came_kraken'] = '1';
						}else{
							$update_fields['opp_came_kraken'] = '0';
						}
						
						$this->mongo_db->where($opper_search);
						$response_bam = $this->mongo_db->get('buy_orders_bam');
						$data_bam = iterator_to_array($response_bam);
						echo "<br>result bam=". count($data_bam );

						$this->mongo_db->where($opper_search);
						$response_bam_sold = $this->mongo_db->get('sold_buy_orders_bam');
						$data_bam_sold = iterator_to_array($response_bam_sold);
						echo "<br>result bam sold =". count($data_bam_sold);

						if(count($data_bam) > 0 || count($data_bam_sold) > 0){
							$update_fields['opp_came_bam'] = '1';
						}else{
							$update_fields['opp_came_bam'] = '0';
						}
					}
					foreach($api_response as $as_1){
						echo "testing".$as_1;
						if($as_1->max_price !='' && $as_1->min_price !='' && $as_1->min_price != 0 && $as_1->max_price != 0){
							$update_fields['5_max_value'] = $as_1->max_price;
							echo "<br>max =". $update_fields['5_max_value'];
							$update_fields['5_min_value'] = $as_1->min_price;  
							echo "<br> min =". $update_fields['5_min_value'];
						} //loop inner check				
					} // foreach loop end

					foreach($api_response_10 as $as){
						if($as->max_price !='' && $as->min_price !='' && $as->min_price !=0 && $as->max_price !=0){
							echo "<br>max 10 = ".$as->max_price;
							$update_fields['10_max_value'] = $as->max_price; 
							echo "<br>min 10=".$as->min_price;
							$update_fields['10_min_value'] = $as->min_price;
						} // if inner check	
					} //end foreach loop
			
				echo"<br><pre>";
				print_r($update_fields);
				$this->mongo_db->where($search_update);
				$this->mongo_db->set($update_fields);
				$this->mongo_db->update($collection_name);
			}
		} //end foreach
		echo "<br>Total Picked Oppertunities Ids= " . count($response);
		//Save last Cron Executioon
		$this->last_cron_execution_time('Kraken test opportunity', '7m', 'run kraken test opportunity calculation (7 * * * *)', 'reports');
	} //end cron

	/////////////////////////////////////////////////////////////////////////////
	///////////////           ASIM CRONE TEST BAM          ///////////////////////
	/////////////////////////////////////////////////////////////////////////////
	public function insert_latest_oppertunity_into_log_collection_test_bam(){
		$collection_name = 'opportunity_logs_test_bam';
		$marketPrices = marketPrices('bam');
		$this->load->helper('new_common_helper');
		foreach($marketPrices as $price){
			if($price['_id'] == 'XRPBTC'){
				$xrpbtc = (float)$price['price'];
			}elseif($price['_id'] == 'ETHBTC'){
				$ethbtc = (float)$price['price'];
			}elseif($price['_id'] == 'XRPUSDT'){
				$xrpusdt = (float)$price['price'];
			}elseif($price['_id'] == 'BTCUSDT'){       
				$btcusdt = (float)$price['price'];
			}elseif($price['_id'] == 'NEOUSDT'){
				$neousdt = (float)$price['price'];
			}elseif($price['_id'] == 'QTUMUSDT'){
				$qtumusdt = (float)$price['price'];
			}
		}//end loop  
		$current_date_time =  date('Y-m-d H:i:s');
		$current_time_date =  $this->mongo_db->converToMongodttime($current_date_time);
		
		$current_hour =  date('Y-m-d H:i:s', strtotime('-40 minutes'));
		$orig_date1 = $this->mongo_db->converToMongodttime($current_hour);

		$previous_one_month_date_time = date('Y-m-d H:i:s', strtotime(' - 1 month'));
		$pre_date_1 =  $this->mongo_db->converToMongodttime($previous_one_month_date_time);

		$connection = $this->mongo_db->customQuery();      
		$condition = array('sort' => array('created_date' => -1),'limit'=>3);
		
		if(!empty($this->input->get())){
			$where['opportunity_id'] = $this->input->get('opportunityId');
		}else{
			$where['mode'] ='live';
			$where['created_date'] = array('$gte'=>$pre_date_1);
			$where['level'] = array('$ne'=>'level_15');
			$where['is_modified'] = array('$exists'=>false);
			$where['modified_date'] = array('$lte'=>$orig_date1);
		}
		// $where['mode'] ='test';
		// $where['created_date'] = array('$gte'=>$pre_date_1);
		// $where['level'] = array('$ne'=>'level_15');
		// $where['is_modified'] = array('$exists'=>false);
		// $where['modified_date'] = array('$lte'=>$orig_date1);
		
		$find_rec = $connection->$collection_name->find($where,  $condition);
		$response = iterator_to_array($find_rec);

		foreach ($response as $value){
			$coin= $value['coin'];
			$start_date = $value['created_date']->toDateTime()->format("Y-m-d H:i:s");
			$timestamp = strtotime($start_date);
			$time = $timestamp + (5 * 60 * 60);
			$end_date = date("Y-m-d H:i:s", $time);

			$hours_10 = $timestamp + (10 * 60 * 60);
			$time_10_hours = date("Y-m-d H:i:s", $hours_10);

			$cidition_check = $this->mongo_db->converToMongodttime($end_date);
			$cidition_check_10 = $this->mongo_db->converToMongodttime($time_10_hours);
				$params = array(
				'coin'       => $value['coin'],
				'start_date' => (string)$start_date,
				'end_date'   => (string)$end_date,
				);
				echo "<br>current time=".$current_date_time;
				echo"<br>created_date =".$start_date;
				echo"<br>start date +5 =".$end_date;
				echo"<br>start date +10 =".$time_10_hours;

				if($cidition_check <= $current_time_date){
					$jsondata = json_encode($params);
					$curl = curl_init();
					curl_setopt_array($curl, array(	
						CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS =>$jsondata,
						CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
					));
					$response_price = curl_exec($curl);	
					curl_close($curl);                                
					$api_response = json_decode($response_price);
				} // main if check for time comapire

			$params_10_hours = array(
				'coin'       => $value['coin'],
				'start_date' => (string)$start_date,
				'end_date'   => (string)$time_10_hours,
			);
			if($cidition_check_10 <= $current_time_date){
				$jsondata = json_encode($params_10_hours);
					$curl_10 = curl_init();
					curl_setopt_array($curl_10, array(
					CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS =>$jsondata,
					CURLOPT_HTTPHEADER => array(
						"Content-Type: application/json"
					), 
					));
				$response_price_10 = curl_exec($curl_10);	
				curl_close($curl_10);
				$api_response_10 = json_decode($response_price_10);
			}
			if ($value['level'] != 'level_15' ){
				$open_lth_avg_per_trade = 0;
				$open_lth_avg = 0;
				$avg_sold = 0;
				$parents_executed = 0;
				$parents_executed = $value['parents_executed'];
				
				$search_update['opportunity_id'] = $value['opportunity_id'];
				$search_update['mode']= 'test';
				//////////////////////////////////////////////////////////////
				$other['application_mode']= 'test';
				$other['opportunityId'] =  $value['opportunity_id'];
				$other['status'] = array('$nin' => array('LTH', 'FILLED','canceled','new_ERROR'));
				// $this->mongo_db->where($other);
				$buyOther = $connection->buy_orders_bam->count($other);
				// $total_other_rec   = iterator_to_array($total_other);

				$otherSold['application_mode']= 'test';
				$otherSold['opportunityId'] =  $value['opportunity_id'];
				$otherSold['is_sell_order'] = array('$nin' => array('sold'));
				$otherSold = $connection->sold_buy_orders_bam->count($otherSold);
				$totalOther = $buyOther+ $otherSold;
				//////////////////////////////////////////////////////////////
				$search_open_lth['application_mode']= 'test';
				$search_open_lth['opportunityId'] = $value['opportunity_id'];
				$search_open_lth['status'] = array('$in' => array('LTH', 'FILLED'));

				print_r("<br>oppertunity_id=".$value['opportunity_id']);
				/////
				$search_cancel['application_mode']= 'test';
				$search_cancel['opportunityId'] = $value['opportunity_id'];
				$search_cancel['status'] = array('$in' => array('canceled'));
				//////
				$search_new_error['application_mode']= 'test';
				$search_new_error['opportunityId'] = $value['opportunity_id'];
				$search_new_error['status'] = array('$in' => array('new_ERROR'));
				////////
				$search_sold['application_mode']= 'test';
				$search_sold['opportunityId'] = $value['opportunity_id'];
				$search_sold['is_sell_order'] = array('$in' => array('sold'));

				$search_reumed['application_mode']= 'test';
				$search_reumed['opportunityId'] = $value['opportunity_id'];
				$search_reumed['resume_status'] = array('$in' => array('resume'));  

				///////////////////////////////////////////////////////////////

				$this->mongo_db->where($search_reumed);
				$total_reumed = $this->mongo_db->get('buy_orders_bam');
				$total_reumed_order   = iterator_to_array($total_reumed);

				$this->mongo_db->where($search_reumed);
				$total_reumed_sold = $this->mongo_db->get('sold_buy_orders_bam');
				$total_reumed_sold_order   = iterator_to_array($total_reumed_sold);   

				$this->mongo_db->where($search_open_lth);
				$total_open = $this->mongo_db->get('buy_orders_bam');
				$total_open_lth_rec   = iterator_to_array($total_open);
				
				$this->mongo_db->where($search_cancel);
				$total_cancel = $this->mongo_db->get('buy_orders_bam');
				$total_cancel_rec   = iterator_to_array($total_cancel);

				$this->mongo_db->where($search_new_error);
				$total_new_error = $this->mongo_db->get('buy_orders_bam');
				$total_new_error_rec   = iterator_to_array($total_new_error);

				$this->mongo_db->where($search_sold);
				$total_sold_total = $this->mongo_db->get('sold_buy_orders_bam');
				$total_sold_rec   = iterator_to_array($total_sold_total);
				echo"<br>total sold count = ".count($total_sold_rec);
				
				$open_lth_puchase_price = 0;
				$open_lth_avg = 0;
				$open_lth_avg_per_trade= 0;
				echo"<br>Total open lth = ".count($total_open_lth_rec);
				if (count($total_open_lth_rec) > 0) {
					echo "<br> Open/lth Calculation";
					foreach ($total_open_lth_rec as $key => $value2){
						if($value2['symbol'] == 'ETHBTC'){
							$open_lth_puchase_price += (float) ($ethbtc - $value2['purchased_price'])/ $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$ethbtc;
						}elseif($value2['symbol'] == 'BTCUSDT'){
							$open_lth_puchase_price += (float) ($btcusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "btc current price =".$btcusdt."<br>";
							echo "purchase price =".$value2['purchased_price']."<br>";
						}elseif($value2['symbol'] == 'XRPBTC'){
							$open_lth_puchase_price += (float) ($xrpbtc - $value2['purchased_price']) / $value2['purchased_price'];
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$xrpbtc;
						}elseif($value2['symbol'] == 'XRPUSDT'){
							$open_lth_puchase_price += (float) ($xrpusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$xrpusdt;
						}elseif($value2['symbol'] == 'NEOUSDT'){
							$open_lth_puchase_price += (float) ($neousdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "btc current price =".$neousdt."<br>";
							echo "purchase price =".$value2['purchased_price']."<br>"; 
						}elseif($value2['symbol'] == 'QTUMUSDT'){
							$open_lth_puchase_price += (float) ($qtumusdt - $value2['purchased_price']) / $value2['purchased_price'] ;
							echo "<br>purchase price = ".$value2['purchased_price'];
							echo "<br> current market value = ".$qtumusdt;
						}	
						echo "<br>open_lth_puchase_price +=";
						print_r($open_lth_puchase_price);
					//	array_sum($value2['sell_price']);
						echo "<br> order_id = ".$value2['_id'];
					}//end loop
						$open_lth_avg_per_trade = (float) $open_lth_puchase_price * 100;
						$open_lth_avg = (float) ($open_lth_avg_per_trade / count($total_open_lth_rec));
				
						echo "<br>avg_open-lth = ";
						print_r($open_lth_avg);
				}//end if

				$sold_puchase_price = 0;
				$avg_sold_CSL = 0;
				$CSL_per_trade_sold = 0;
				$CSL_sold_purchase_price = 0 ;
				$avg_manul = 0;
				$per_trade_sold_manul = 0;
				$manul_sold_purchase_price = 0;
				$avg_sold = 0;
				$per_trade_sold = 0;
				if (count($total_sold_rec) > 0){
					echo "<br> sold calculation";
					foreach ($total_sold_rec as $key => $value1){
						if(isset($value1['is_manual_sold'])){
							$manul_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
							print_r("<br> Market sold price manul = ".$value1['market_sold_price']);
							print_r("<br>purchase price manul =".$value1['purchased_price']);
							print_r("<br> sold_puchase_price manul + =".$manul_sold_purchase_price);
							echo '<br>order_id manul ='.$value1['_id'];	
						}elseif(isset($value1['csl_sold'])){
							$CSL_sold_purchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
							print_r("<br> Market sold price = ".$value1['market_sold_price']);
							print_r("<br>purchase price =".$value1['purchased_price']);
							print_r("<br> CSL sold_puchase_price + =".$CSL_sold_purchase_price);
							echo '<br>order_id ='.$value1['_id'];
						}else{
							$sold_puchase_price += (float) ($value1['market_sold_price'] - $value1['purchased_price']) / $value1['purchased_price'];
							print_r("<br> Market sold price = ".$value1['market_sold_price']);
							print_r("<br>purchase price =".$value1['purchased_price']);
							print_r("<br> sold_puchase_price + =".$sold_puchase_price);
							echo '<br>order_id ='.$value1['_id'];
						}
					} //end sold foreach
					if($manul_sold_purchase_price > 0){
						$sold_puchase_price += $manul_sold_purchase_price;
						$manul_sold_purchase_price = 0;
					}
					if($CSL_sold_purchase_price > 0){
						$sold_puchase_price += $CSL_sold_purchase_price;
						$CSL_sold_purchase_price = 0;
					}
					if($manul_sold_purchase_price != "0"){
						$per_trade_sold_manul = (float) $manul_sold_purchase_price * 100;
						echo "<br>per tarde manul = ".$per_trade_sold_manul;
						$avg_manul = (float) ($per_trade_sold_manul / count($total_sold_rec));
						echo "<br>avg_sold manul = ";
						print_r($avg_manul);
						print_r("<br>sold count = ".count($total_sold_rec));
					}
					if($sold_puchase_price !="0"){
						$per_trade_sold = (float) $sold_puchase_price * 100;
						echo "<br>per tarde = ".$per_trade_sold;
						$avg_sold = (float) ($per_trade_sold / count($total_sold_rec));
						echo "<br>avg_sold = ";
						print_r($avg_sold);
						print_r("<br>sold count = ".count($total_sold_rec));
					}
					if($CSL_sold_purchase_price !="0"){
						$CSL_per_trade_sold = (float) $CSL_sold_purchase_price * 100;
						echo "<br>per tarde CSL = ".$CSL_per_trade_sold;
						$avg_sold_CSL = (float) ($CSL_per_trade_sold / count($total_sold_rec));
						echo "<br>avg_sold CSL = ";
						print_r($avg_sold_CSL);
						print_r("<br>sold count = ".count($total_sold_rec));
					}
				}// End check >0
				print_r("<br>oppertunity_id=".$value['opportunity_id']."<br>");
				$total_orders = count($total_open_lth_rec) + count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $totalOther;
				$disappear = $parents_executed -  $total_orders;
				$total = count($total_new_error_rec) + count($total_cancel_rec) + count($total_sold_rec) + $disappear;
				if ($total == $parents_executed ){
					$update_fields = array(
						'open_lth'     => count($total_open_lth_rec),
						'new_error'    => count($total_new_error_rec),
						'cancelled'    => count($total_cancel_rec),
						'sold'         => count($total_sold_rec),
						'avg_open_lth' => $open_lth_avg,
						'other_status' => $totalOther,
						'per_trade_sold' => $per_trade_sold,
						'reumed_child'  => count($total_reumed_sold_order) + count($total_reumed_order),
						'avg_sold'     => $avg_sold,
						'avg_manul'    =>$avg_manul,
						'avg_sold_CSL' => $avg_sold_CSL,
						'modified_date' =>$current_time_date  
					);
					if(isset($value['10_max_value']) && isset($value['5_max_value'])){
						$update_fields['is_modified']  = true;
					}
					if(count($total_open_lth_rec)== 0 && count($total_sold_rec) == 0 &&  $totalOther == 0 ){
						$update_fields['oppertunity_missed'] = true;
					}
					}else{ 
						$update_fields = array(
							'open_lth'     => count($total_open_lth_rec),
							'new_error'    => count($total_new_error_rec),
							'cancelled'    => count($total_cancel_rec),
							'sold'         => count($total_sold_rec),
							'reumed_child' => count($total_reumed_sold_order) + count($total_reumed_order),
							'avg_open_lth' => $open_lth_avg,
							'avg_sold'     => $avg_sold,
							'per_trade_sold' => $per_trade_sold,
							'other_status' => $totalOther,   
							'avg_manul'    =>$avg_manul,
							'avg_sold_CSL' => $avg_sold_CSL,
							'modified_date'=>$current_time_date
						);
					}
					$db = $this->mongo_db->customQuery();
					$pipeline = [
					[
						'$match' =>[
						'application_mode' => 'test',
						'parent_status' => ['$exists' => false ],
						'opportunityId' => $value['opportunity_id'],
						'status' => ['$in'=>['LTH','FILLED']],
						],
					],
						[
						'$sort' =>['created_date'=> -1],
						],
						['$limit'=>1]
					];
					$result_buy = $db->buy_orders_bam->aggregate($pipeline);
					$res = iterator_to_array($result_buy);

					$pipeline1 = [
					[
						'$match' =>[
						'application_mode' => 'test',
						'parent_status' => ['$exists' => false ],
						'opportunityId' => $value['opportunity_id'],
						'status' => ['$in'=>['LTH','FILLED']],
						],
					],
						[
						'$sort' =>['created_date'=> 1],
						],
						['$limit'=>1]
					];
					$result_buy1 = $db->buy_orders_bam->aggregate($pipeline1);
					$res1 = iterator_to_array($result_buy1);
					if(!isset($value['first_order_buy']) && !isset($value['last_order_buy'])){
						echo "<br> created_date first =".$res[0]['created_date'];
						echo "<br>created_date last = ".$res1[0]['created_date'];
						$update_fields['first_order_buy'] =  $res[0]['created_date'];
						$update_fields['last_order_buy'] =  $res1[0]['created_date'];
					}
					if(!isset($value['opp_came_binance']) && !isset($value['opp_came_kraken']) && !isset($value['opp_came_bam'])){	
						$opper_search['application_mode']= 'test';
						$opper_search['opportunityId'] = $value['opportunity_id'];
						
						$connetct= $this->mongo_db->customQuery();

						$pending_curser = $connetct->buy_orders->find($opper_search);
						$buy_order = iterator_to_array($pending_curser);
						echo "<br>result binance=".count($buy_order);

						$pending_curser_buy = $connetct->sold_buy_order->find($opper_search);
						$sold_bbuy_order = iterator_to_array($pending_curser_buy);
						echo "<br>result binance sold=".count($sold_bbuy_order);

						if(count($buy_order) > 0 || count($sold_bbuy_order) > 0 ){
							$update_fields['opp_came_binance'] = '1';
						}else{
							$update_fields['opp_came_binance'] = '0';
						}
						
						$this->mongo_db->where($opper_search);
						$response_kraken = $this->mongo_db->get('buy_orders_kraken');
						$data_kraken = iterator_to_array($response_kraken);
						echo "<br>result kraken=". count($data_kraken);

						$this->mongo_db->where($opper_search);
						$response_kraken_sold = $this->mongo_db->get('sold_buy_orders_kraken');
						$data_kraken_sold = iterator_to_array($response_kraken_sold);
						echo "<br>result kraken sold=". count($data_kraken_sold);
						if(count($data_kraken) > 0 || count($data_kraken_sold) > 0){
							$update_fields['opp_came_kraken'] = '1';
						}else{
							$update_fields['opp_came_kraken'] = '0';
						}
						
						$this->mongo_db->where($opper_search);
						$response_bam = $this->mongo_db->get('buy_orders_bam');
						$data_bam = iterator_to_array($response_bam);
						echo "<br>result bam=". count($data_bam );

						$this->mongo_db->where($opper_search);
						$response_bam_sold = $this->mongo_db->get('sold_buy_orders_bam');
						$data_bam_sold = iterator_to_array($response_bam_sold);
						echo "<br>result bam sold =". count($data_bam_sold);

						if(count($data_bam) > 0 || count($data_bam_sold) > 0){
							$update_fields['opp_came_bam'] = '1';
						}else{
							$update_fields['opp_came_bam'] = '0';
						}
					}
						foreach($api_response as $as_1){
								if($as_1->max_price !='' && $as_1->min_price !='' && $as_1->min_price != 0 && $as_1->max_price != 0){
										$update_fields['5_max_value'] = $as_1->max_price;
										echo "<br>max =". $update_fields['5_max_value'];
										$update_fields['5_min_value'] = $as_1->min_price;  
										echo "<br> min =". $update_fields['5_min_value'];
										} //loop inner check				
						} // foreach loop end
						foreach($api_response_10 as $as){
								if($as->max_price !='' && $as->min_price !='' && $as->min_price !=0 && $as->max_price !=0){
										echo "<br>max 10 = ".$as->max_price;
										$update_fields['10_max_value'] = $as->max_price; 
										echo "<br>min 10=".$as->min_price;
										$update_fields['10_min_value'] = $as->min_price;
								} // if inner check	
						} //end foreach loop
					echo"<br><pre>";
					print_r($update_fields);
					$this->mongo_db->where($search_update);
					$this->mongo_db->set($update_fields);
					$query = $this->mongo_db->update($collection_name);
			}
		} //end foreach
		echo "<br>current time".$current_date_time;
		echo "<br>Total Picked Oppertunities Ids= " . count($response);
		//Save last Cron Executioon
		$this->last_cron_execution_time('Bam test opportunity', '5m', 'start time ='.$current_date_time.'run bam test opportunity calculation (5 * * * *)end time'. date('Y-m-d H:i:s'), 'reports');
	} //end cron

	////////////////////////////////////////////////////////////////////////////
	////////////////////       ASIM MONTH OPPERTUNITY REPORT      //////////////
	///////////////////////////////////////////////////////////////////////////

	public function oppertunity_monthly(){
		header("Access-Control-Allow-Origin: https://digiebot.com");
		header('Content-type: application/json');
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: GET, POST");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		
		ini_set("display_errors", E_ALL);
		error_reporting(E_ALL);
		
		$month = $this->input->get('month');
		if($month ==''){
			$month = date('Y-m');
		}
		$exchange = $this->input->get('exchange'); 

		// echo "<br>exchange===>  ",$exchange;
		// echo "<br>month===>  ",$month;

		$sorting = ['sort' => ['avg_sold' => -1]];
		$collection_name = 'opportunity_logs_monthly_'.$exchange;		
		$search['month'] = $month; 

		$db = $this->mongo_db->customQuery();
		$object3 = $db->$collection_name->find($search, $sorting); 
		$log_arry = iterator_to_array($object3);

		// echo "<pre>";print_r($log_arry);
		$data['final_array'] = $log_arry;
		$this->session->set_userdata('data_session',$log_arry);
		echo json_encode($log_arry);

	}
	public function oppertunity_month(){
		$year = date('Y');
		$curent = date('Y-m');
		$coin_array_all = $this->mod_coins->get_all_coins();
		if($this->input->post()){
				if($this->input->post('filter_by_coin')){
					$filter['coin']['$in'] = $this->input->post('filter_by_coin');
				}else{
					$filter['coin']['$in'] = array_column($coin_array_all, 'symbol');
				}
				if($this->input->post('exchange')){
					$collection_name = 'opportunity_logs_monthly_'.$this->input->post('exchange'); 
				}else{
					$collection_name = 'opportunity_logs_monthly_binance';
				}
				if($this->input->post('filter_by_month')){
					$filter['month'] = $year.'-'.$this->input->post('filter_by_month');
					}
					$this->mongo_db->sort(array('created_date' => -1));
					$this->mongo_db->where($filter);
					$object3 = $this->mongo_db->get($collection_name);
					$log_arry = iterator_to_array($object3);
					$data['final_array'] = $log_arry;
					
			}else{
			$this->mongo_db->sort(array('created_date' => -1));
			$search['month'] = $curent; 
			$this->mongo_db->where($search);
			$object3 = $this->mongo_db->get('opportunity_logs_monthly_binance');
			$log_arry = iterator_to_array($object3);
			$data['final_array'] = $log_arry;
		}
		$data['coins'] = $coin_array_all;
		$this->stencil->paint('admin/trigger_rule_report/oppertunity_monthly', $data);
	}

	/////////////////////////////////////////////////////////////////////////////
	///////////////            ASIM CRONE BINANCE MONTHLY          //////////////
	/////////////////////////////////////////////////////////////////////////////

	public function insert_latest_oppertunity_into_log_collection_monthly(){
		//Save last Cron Executioon
		$this->last_cron_execution_time('Binance live opportunity monthly', '55m', 'current ='.date('Y-m-d H:i:s').'run binance live opportunity avg calculation monthly end time(55 * * * *)'.date('Y-m-d H:i:s'), 'reports');

		$compaire_month = date('Y-m');
		$month = date('Y-m');
		$start_date_time =  date('Y-m-01 00:00:00');
		$time_date =  $this->mongo_db->converToMongodttime($start_date_time);

		$end = date('Y-m-d 23:59:59');
		$enddate = $this->mongo_db->converToMongodttime($end);
		
		$current_date = date('Y-m-d H:i:s');
		$current_time_date =  $this->mongo_db->converToMongodttime($current_date);

		// $current_hour1 =  date('Y-m-d H:i:s', strtotime('-2 minutes'));
		// $pre_time_date =  $this->mongo_db->converToMongodttime($current_hour1);

		$coin_array_all = $this->mod_coins->get_all_coins();
		$coin_count = 0;
		foreach($coin_array_all as $value){
			echo "<br>count check= ".$coin_count;
			$custom = $this->mongo_db->customQuery(); 
			$condtn = array('sort'=>array('created_date'=> -1));
			// $coin = $value['symbol'];
			$coin = $coin_array_all[$coin_count]['symbol'];
			$where['coin'] = $coin; 
			$where['mode'] = 'live';
			$where['oppertunity_missed'] = array('$exists'=>false);
			$where['created_date'] = array('$gte' => $time_date, '$lte'=>$enddate);
			// $where['month_modified_time'] =array('$lte'=>$pre_time_date);
			$where['level'] = array('$in'=>array('level_5', 'level_6', 'level_8', 'level_10','level_11','level_12','level_13', 'level_17', 'level_18'));
			
			$resps = $custom->opportunity_logs_binance->find($where, $condtn);
			$result_1 = iterator_to_array($resps);  
			echo"<br>coin name =".$coin;
			$sold = 0;
			$open_lth =0;
			$avg_sold_manul = 0;
			$avg_sold = 0;
			$avg_open_lth =0;
			$picket_parent = 0;
			$execuated_parent = 0;
			$other_status = 0;
			$cancelled = 0;        
			$new_error = 0;
			$created_date ='';
			$sum_all = 0;
			$total_investment_btc = 0;						
			$total_profit_btc = 0;
			$total_buy_comission_btc = 0;
			$total_sell_comission_btc = 0;
			$buy_comission_BNB =0;
			$sell_comission_BNB =0;
			$total_gain_btc = 0;

			$sellTimeDiffRange1 = 0 ;
			$sellTimeDiffRange2 = 0 ;	
			$sellTimeDiffRange3 = 0 ;
			$sellTimeDiffRange4 = 0 ;
			$sellTimeDiffRange5 = 0 ;
			$sellTimeDiffRange6 = 0 ;
			$sellTimeDiffRange7 = 0 ;

			$buyTimeDiffRange1 = 0 ;
			$buyTimeDiffRange2 = 0 ;	
			$buyTimeDiffRange3 = 0 ;
			$buyTimeDiffRange4 = 0 ;
			$buyTimeDiffRange5 = 0 ;
			$buyTimeDiffRange6 = 0 ;
			$buyTimeDiffRange7 = 0 ;

			$sumPLSllipageRange1 = 0 ;
			$sumPLSllipageRange2 = 0 ; 
			$sumPLSllipageRange3 = 0 ;
			$sumPLSllipageRange4 = 0 ;
			$sumPLSllipageRange5 = 0 ;

			if(count($result_1) > 0){
				foreach($result_1 as $value_1){  
					$total_investment_btc += $value_1['btc_investment'];
					$total_profit_btc += $value_1['total_btc_profit'];
					$total_buy_comission_btc += $value_1['buy_commission'];  
					$total_sell_comission_btc += $value_1['sell_commission'];  
					$buy_comission_BNB  += $value_1['buy_commision_qty'];
					$sell_comission_BNB += $value_1['sell_fee_respected_coin'];
					$total_gain_btc +=   $value_1['sold_btc_profit'];      
					echo"<br>oppertunity Id = ".$value_1['opportunity_id'];
					$opp['opportunity_id'] = $value_1['opportunity_id']; 
					$opp['mode'] = 'live';			
					$created_date = $value_1['created_date'];
					$avg_sold_manul += $value_1['avg_manul'];
					$sold +=  $value_1['sold'];
					$open_lth += $value_1['open_lth'];
					$avg_sold += $value_1['avg_sold'];
					$avg_open_lth += $value_1['avg_open_lth'];
					$picket_parent += $value_1['parents_picked'];
					$execuated_parent +=  $value_1['parents_executed'];
					$other_status += $value_1['other_status'];
					$cancelled += $value_1['cancelled'];        
					$new_error += $value_1['new_error'];
					$sum_all = $sold + $cancelled + $new_error;

					$sellTimeDiffRange1 += 	$value_1['sellTimeDiffRange1']; 	
					$sellTimeDiffRange2 +=	$value_1['sellTimeDiffRange2']; 	
					$sellTimeDiffRange3 +=	$value_1['sellTimeDiffRange3']; 	
					$sellTimeDiffRange4 +=	$value_1['sellTimeDiffRange4']; 	
					$sellTimeDiffRange5 +=	$value_1['sellTimeDiffRange5']; 	
					$sellTimeDiffRange6 +=	$value_1['sellTimeDiffRange6']; 	
					$sellTimeDiffRange7 +=	$value_1['sellTimeDiffRange7']; 
					
					$buyTimeDiffRange1 += 	$value_1['buySumTimeDelayRange1']; 	
					$buyTimeDiffRange2 +=	$value_1['buySumTimeDelayRange2']; 	
					$buyTimeDiffRange3 +=	$value_1['buySumTimeDelayRange3']; 	
					$buyTimeDiffRange4 +=	$value_1['buySumTimeDelayRange4']; 	
					$buyTimeDiffRange5 +=	$value_1['buySumTimeDelayRange5']; 	
					$buyTimeDiffRange6 +=	$value_1['buySumTimeDelayRange6']; 	
					$buyTimeDiffRange7 +=	$value_1['buySumTimeDelayRange7']; 

					$sumPLSllipageRange1 += $value_1['sumPLSllipageRange1']; 	
					$sumPLSllipageRange2 += $value_1['sumPLSllipageRange2']; 	 
					$sumPLSllipageRange3 +=	$value_1['sumPLSllipageRange3']; 	
					$sumPLSllipageRange4 += $value_1['sumPLSllipageRange4']; 	
					$sumPLSllipageRange5 += $value_1['sumPLSllipageRange5']; 	

				}
				$time = $created_date->toDateTime()->format("Y-m-d H:i:s");
				$created_date_mnth_year = date("Y-m",strtotime($time));
				$created_month_year =  $this->mongo_db->converToMongodttime($created_date_mnth_year);
				$current_month_year = $this->mongo_db->converToMongodttime($compaire_month);
			
				$final_open_avg = 0;
				$final_avg_manul_sold = 0;
				$final_sold_avg = 0;
				$final_open_avg = $avg_open_lth / count($result_1);
				$final_sold_avg = $avg_sold / count($result_1);
				$final_avg_manul_sold = $avg_sold_manul/ count($result_1);
				if($final_open_avg == '' || $final_open_avg == null || is_infinite($final_open_avg)){
					$final_open_avg = 0;
				}
				if($final_sold_avg == '' || $final_sold_avg == null || is_infinite($final_sold_avg)){
					$final_sold_avg = 0;
				}
				if($final_avg_manul_sold == '' || $final_avg_manul_sold == null || is_infinite($final_avg_manul_sold)){
					$final_avg_manul_sold = 0;
				}
				$new_array = array(
					'sold' 					=> 	$sold,
					'month'        			=> 	$month,
					'coin'					=> 	$coin,
					'mode' 					=> 	'live',
					'sellTimeDiffRange1'	=>	($sellTimeDiffRange1 / $sold) * 100,
					'sellTimeDiffRange2'	=>	($sellTimeDiffRange2 / $sold) * 100,	
					'sellTimeDiffRange3'	=>	($sellTimeDiffRange3 / $sold) * 100,
					'sellTimeDiffRange4'	=>	($sellTimeDiffRange4 / $sold) * 100,
					'sellTimeDiffRange5'	=>	($sellTimeDiffRange5 / $sold) * 100,
					'sellTimeDiffRange6'	=>	($sellTimeDiffRange6 / $sold) * 100,
					'sellTimeDiffRange7'	=>	($sellTimeDiffRange7 / $sold) * 100,

					'buyTimeDiffRange1'		=> 	($buyTimeDiffRange1 / ($sold + $open_lth)) * 100 , 		 	
					'buyTimeDiffRange2' 	=> 	($buyTimeDiffRange2 / ($sold + $open_lth)) * 100 ,	
					'buyTimeDiffRange3' 	=> 	($buyTimeDiffRange3 / ($sold + $open_lth)) * 100 , 	
					'buyTimeDiffRange4' 	=> 	($buyTimeDiffRange4 / ($sold + $open_lth)) * 100 , 	
					'buyTimeDiffRange5' 	=> 	($buyTimeDiffRange5 / ($sold + $open_lth)) * 100 , 	
					'buyTimeDiffRange6' 	=> 	($buyTimeDiffRange6 / ($sold + $open_lth)) * 100 ,  	
					'buyTimeDiffRange7' 	=> 	($buyTimeDiffRange7 / ($sold + $open_lth)) * 100 ,  

					'sumPLSllipageRange1'	=>	($sumPLSllipageRange1 / $sold) * 100,
					'sumPLSllipageRange2'	=>	($sumPLSllipageRange2 / $sold) * 100,	
					'sumPLSllipageRange3'	=>	($sumPLSllipageRange3 / $sold) * 100,
					'sumPLSllipageRange4'	=>	($sumPLSllipageRange4 / $sold) * 100,
					'sumPLSllipageRange5'	=>	($sumPLSllipageRange5 / $sold) * 100,

					'open_lth' 				=> 	$open_lth,
					'avg_sold'	    		=> 	$final_sold_avg,
					'avg_open_lth'     		=> 	$final_open_avg,
					'execuated_parent' 		=> 	$execuated_parent,
					'other_status' 	   		=> 	$other_status,
					'last_modified_time'	=> 	$current_time_date,
					'total_oppertunities'	=>	count($result_1),
					'avg_sold_manul'  		=> 	$final_avg_manul_sold,
					'total_investment' 		=> 	$total_investment_btc,
					'buy_comission_BNB'		=> 	$buy_comission_BNB,
					'buy_comission' 		=> 	$total_buy_comission_btc
				);

				if($execuated_parent == $sum_all && $created_month_year != $current_month_year && ($open_lth + $other_status) == 0){
					echo"<br>asasas";
					$new_array['total_profit'] =$total_profit_btc;
					$new_array['total_gain'] = $total_gain_btc; 
					$new_array['sell_comission'] =  $total_sell_comission_btc;
					$new_array['sell_comission_BNB'] = $sell_comission_BNB;
				}
				echo "<pre>";
				print_r($new_array);
				$search_find['month'] = $month;
				$search_find['coin']  = $coin;
				$search_find['mode'] = 'live';
				$upsert['upsert'] = true;
				$res = $custom->opportunity_logs_monthly_binance->updateOne($search_find, ['$set'=> $new_array], $upsert);
			}
			$coin_count++;
		}//end loop	
		echo "<br>total picked records = ".count($result_1);
	} //end cron


	public function insert_latest_oppertunity_into_log_collection_monthly_old_opportunity_scan(){
		$monthStart = date('m');
		$monthStart = $monthStart - 1 ;
		$custom = $this->mongo_db->customQuery(); 

		$coin_array  = ['EOSUSDT', 'LTCUSDT','XRPUSDT','NEOUSDT', 'QTUMUSDT','BTCUSDT', 'XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC'];

		for($i = 1; $i <= $monthStart; $i++){
			for($coin = 1; $coin < count($coin_array); $coin++){
				$month           =  date('Y-'.$i);
				$compaire_month  =  date('Y-'.$i);
				$startDate = date('Y-'.$i.'-01 00:00:00');
				$endDate   = date('t', strtotime($startDate));

				$endDate = date('Y-'.$i.'-'.$endDate .' 23:59:59');

				echo "<br>start Time: ".$startDate;
				echo "<br>End Time: ".$endDate;
				$startDate = $this->mongo_db->converToMongodttime($startDate);
				$endDate   = $this->mongo_db->converToMongodttime(date($endDate));

				$lookUpQuery = [
					[
						'$match' => [
							'coin' 				 => 	$coin_array[$coin], 
							'mode' 				 => 	'live',
							'oppertunity_missed' => 	['$exists' => false ],
							'created_date' 		 => 	['$gte' => $startDate, '$lte'=>$endDate ],
							'level' 			 => 	array('$in'=>array('level_5', 'level_6', 'level_8', 'level_10','level_11','level_12','level_13', 'level_17', 'level_18'))
						]
					],

					[
						'$group' =>[
							'_id'  => '$coin',
							'total_investment_btc' 		=>  ['$sum' => '$btc_investment'],
							'total_profit_btc'	   		=>  ['$sum' => '$total_btc_profit'],
							'total_buy_comission_btc' 	=>  ['$sum' => '$buy_commission'],
							'total_sell_comission_btc' 	=>  ['$sum' => '$sell_commission'],
							'buy_comission_BNB'			=> 	['$sum' => '$buy_commision_qty'],
							'sell_comission_BNB'		=> 	['$sum' => '$sell_fee_respected_coin'],
							'total_gain_btc'			=>	['$sum' => '$sold_btc_profit'],
							'opportunity_id'			=> 	['$sum' => '$opportunity_id'],
							'sold'		 				=>  ['$sum' => '$sold'],
							'avg_sold_manul'	        =>  ['$sum' => '$avg_manul'],
							'open_lth'					=>  ['$sum' => '$open_lth'],
							'avg_sold'					=>	['$sum' => '$avg_sold'],
							'avg_open_lth'				=> 	['$sum' => '$avg_open_lth'],
							'picket_parent'				=>	['$sum' => '$parents_picked'],
							'execuated_parent'			=> 	['$sum' => '$parents_executed'],
							'other_status'				=> 	['$sum' => '$other_status'],
							'cancelled'                 =>  ['$sum' => '$cancelled'],
							'new_error'					=>	['$sum' => '$new_error'],
							'sellTimeDiffRange1'        =>  ['$sum' => '$sellTimeDiffRange1'],
							'sellTimeDiffRange2'		=>	['$sum' => '$sellTimeDiffRange2'],
							'sellTimeDiffRange3'		=>	['$sum' => '$sellTimeDiffRange3'],
							'sellTimeDiffRange4'		=>	['$sum' => '$sellTimeDiffRange4'],
							'sellTimeDiffRange5'		=>	['$sum' => '$sellTimeDiffRange5'],
							'sellTimeDiffRange6'		=>	['$sum' => '$sellTimeDiffRange6'],
							'sellTimeDiffRange7'		=>	['$sum' => '$sellTimeDiffRange7'],
							'buyTimeDiffRange1'			=> 	['$sum' => '$buySumTimeDelayRange1'],
							'buyTimeDiffRange2'			=>  ['$sum' => '$buySumTimeDelayRange2'],
							'buyTimeDiffRange3'			=>	['$sum'  => '$buySumTimeDelayRange3'],
							'buyTimeDiffRange4'			=>	['$sum' => '$buySumTimeDelayRange4'],
							'buyTimeDiffRange5'			=> 	['$sum' => '$buySumTimeDelayRange5'],
							'buyTimeDiffRange6'			=> 	['$sum' => '$buySumTimeDelayRange6'],
							'buyTimeDiffRange7'			=> 	['$sum' => '$buySumTimeDelayRange7'],
							'sumPLSllipageRange1'		=> 	['$sum' => '$sumPLSllipageRange1'],
							'sumPLSllipageRange2'		=>	['$sum' => '$sumPLSllipageRange2'],
							'sumPLSllipageRange3'		=>	['$sum' => '$sumPLSllipageRange3'],
							'sumPLSllipageRange4'		=>	['$sum' => '$sumPLSllipageRange4'],
							'sumPLSllipageRange5'		=>	['$sum' => '$sumPLSllipageRange5'],
							'count'						=>	['$sum' => 1],
						]
					],


					[
						'$project' => [
							'_id' => null,
							'final_open_avg'  		=>  ['$divide' => ['$avg_open_lth' , '$count']],
							'final_sold_avg'  		=>  ['$divide' => ['$avg_sold', '$count']],
							'final_avg_manul_sold'	=>	['$divide' => ['$avg_sold_manul', '$count']],
							'sold' 					=> 	'$sold',
							'month'        			=> 	$month,
							'coin'					=> 	$coin_array[$coin],
							'mode' 					=> 	'live',
							'sum_all' 				=>	['$sum' => [ '$sold', '$cancelled' , '$new_error']],
							'created_date'			=>  '$created_date',
							'sellTimeDiffRange1'	=>	['$multiply' => [['$divide'  => [ '$sellTimeDiffRange1', '$sold']] , 100]],
							'sellTimeDiffRange2'	=>	['$multiply' => [['$divide'  => [ '$sellTimeDiffRange2', '$sold']] , 100]],	
							'sellTimeDiffRange3'	=>	['$multiply' => [['$divide'  => [ '$sellTimeDiffRange3', '$sold']] , 100]],
							'sellTimeDiffRange4'	=>	['$multiply' => [['$divide'  => [ '$sellTimeDiffRange4', '$sold']] , 100]],
							'sellTimeDiffRange5'	=>	['$multiply' => [['$divide'  => [ '$sellTimeDiffRange5', '$sold']] , 100]],
							'sellTimeDiffRange6'	=>	['$multiply' => [['$divide'  => [ '$sellTimeDiffRange6', '$sold']] , 100]],
							'sellTimeDiffRange7'	=>	['$multiply' => [['$divide'  => ['$sellTimeDiffRange7' , '$sold']] , 100]],
							'buyTimeDiffRange1'		=>  ['$multiply' => [ ['$divide' => [ '$buyTimeDiffRange1' , ['$sum' => [ '$sold' , '$open_lth']] ]] , 100]], 		 	
							'buyTimeDiffRange2'		=>  ['$multiply' => [ ['$divide' => [ '$buyTimeDiffRange2' , ['$sum' => [ '$sold' , '$open_lth']] ]] , 100]],
							'buyTimeDiffRange3'		=>  ['$multiply' => [ ['$divide' => [ '$buyTimeDiffRange3' , ['$sum' => [ '$sold' , '$open_lth']] ]] , 100]],
							'buyTimeDiffRange4'		=>  ['$multiply' => [ ['$divide' => [ '$buyTimeDiffRange4' , ['$sum' => [ '$sold' , '$open_lth']] ]] , 100]],
							'buyTimeDiffRange5'		=>  ['$multiply' => [ ['$divide' => [ '$buyTimeDiffRange5' , ['$sum' => [ '$sold' , '$open_lth']] ]] , 100]],
							'buyTimeDiffRange6'		=>  ['$multiply' => [ ['$divide' => [ '$buyTimeDiffRange6' , ['$sum' => [ '$sold' , '$open_lth']] ]] , 100]],
							'buyTimeDiffRange7'		=>  ['$multiply' => [ ['$divide' => [ '$buyTimeDiffRange7' , ['$sum' => [ '$sold' , '$open_lth']] ]] , 100]],
 							'sumPLSllipageRange1'	=> 	['$multiply' => [ ['$divide' => ['$sumPLSllipageRange1', '$sold' ]], 100]],    
							'sumPLSllipageRange2'	=> 	['$multiply' => [ ['$divide' => ['$sumPLSllipageRange2', '$sold' ]], 100]],
							'sumPLSllipageRange3'	=> 	['$multiply' => [ ['$divide' => ['$sumPLSllipageRange3', '$sold' ]], 100]],
							'sumPLSllipageRange4'	=> 	['$multiply' => [ ['$divide' => ['$sumPLSllipageRange4', '$sold' ]], 100]],
							'sumPLSllipageRange5'	=> 	['$multiply' => [ ['$divide' => ['$sumPLSllipageRange5', '$sold' ]], 100]],
							'open_lth' 				=> 	'$open_lth',
							'avg_sold'	    		=> 	'$final_sold_avg',
							'avg_open_lth'     		=> 	'$final_open_avg',
							'execuated_parent' 		=> 	'$execuated_parent',
							'other_status' 	   		=> 	'$other_status',
							'last_modified_time'	=> 	'$current_time_date',
							'total_oppertunities'	=>	'$count',
							'avg_sold_manul'  		=> 	'$final_avg_manul_sold',
							'total_investment' 		=> 	'$total_investment_btc',
							'buy_comission_BNB'		=> 	'$buy_comission_BNB',
							'buy_comission' 		=> 	'$total_buy_comission_btc',
							'total_profit' 			=>  '$total_profit_btc',
							'total_gain'			=>	'$total_gain_btc',
							'sell_comission'        =>  '$total_sell_comission_btc',
							'sell_comission_BNB'    =>  '$sell_comission_BNB',
						]
					],

					[
						'$sort' => ['created_date'=> -1]
					]
				];

				$resps = $custom->opportunity_logs_binance->aggregate($lookUpQuery);
				$result_1 = iterator_to_array($resps);
				if(count($result_1) > 0 ){
					$updateArray = [
						'final_open_avg'  		=>  $result_1[0]['final_open_avg'],
						'final_sold_avg'  		=>  $result_1[0]['final_sold_avg'],
						'final_avg_manul_sold'	=>	$result_1[0]['final_avg_manul_sold'],
						'sold' 					=> 	$result_1[0]['sold'],
						'month'        			=> 	$result_1[0]['month'],
						'coin'					=> 	$result_1[0]['coin'],
						'mode' 					=> 	$result_1[0]['mode'],
						'sum_all' 				=>	$result_1[0]['sum_all'],
						'created_date'			=>  $result_1[0]['created_date'],
						'sellTimeDiffRange1'	=>	$result_1[0]['sellTimeDiffRange1'],
						'sellTimeDiffRange2'	=>	$result_1[0]['sellTimeDiffRange2'],	
						'sellTimeDiffRange3'	=>	$result_1[0]['sellTimeDiffRange3'],
						'sellTimeDiffRange4'	=>	$result_1[0]['sellTimeDiffRange4'],
						'sellTimeDiffRange5'	=>	$result_1[0]['sellTimeDiffRange5'],
						'sellTimeDiffRange6'	=>	$result_1[0]['sellTimeDiffRange6'],
						'sellTimeDiffRange7'	=>	$result_1[0]['sellTimeDiffRange7'],
						'buyTimeDiffRange1'		=>  $result_1[0]['buyTimeDiffRange1'], 		 	
						'buyTimeDiffRange2'		=>  $result_1[0]['buyTimeDiffRange2'],
						'buyTimeDiffRange3'		=>  $result_1[0]['buyTimeDiffRange3'],
						'buyTimeDiffRange4'		=>  $result_1[0]['buyTimeDiffRange4'],
						'buyTimeDiffRange5'		=>  $result_1[0]['buyTimeDiffRange5'],
						'buyTimeDiffRange6'		=>  $result_1[0]['buyTimeDiffRange6'],
						'buyTimeDiffRange7'		=>  $result_1[0]['buyTimeDiffRange7'],
						'sumPLSllipageRange1'	=> 	$result_1[0]['sumPLSllipageRange1'],    
						'sumPLSllipageRange2'	=> 	$result_1[0]['sumPLSllipageRange2'],
						'sumPLSllipageRange3'	=> 	$result_1[0]['sumPLSllipageRange3'],
						'sumPLSllipageRange4'	=> 	$result_1[0]['sumPLSllipageRange4'],
						'sumPLSllipageRange5'	=> 	$result_1[0]['sumPLSllipageRange5'],
						'open_lth' 				=> 	$result_1[0]['open_lth'],
						'avg_sold'	    		=> 	$result_1[0]['avg_sold'],
						'avg_open_lth'     		=> 	$result_1[0]['avg_open_lth'],
						'execuated_parent' 		=> 	$result_1[0]['execuated_parent'],
						'other_status' 	   		=> 	$result_1[0]['other_status'],
						'last_modified_time'	=> 	$result_1[0]['last_modified_time'],
						'total_oppertunities'	=>	$result_1[0]['total_oppertunities'],
						'avg_sold_manul'  		=> 	$result_1[0]['avg_sold_manul'],
						'total_investment' 		=> 	$result_1[0]['total_investment'],
						'buy_comission_BNB'		=> 	$result_1[0]['buy_comission_BNB'],
						'buy_comission' 		=> 	$result_1[0]['buy_comission'],
						'total_profit' 			=>  $result_1[0]['total_profit'],
						'total_gain'			=>	$result_1[0]['total_gain'],
						'sell_comission'        =>  $result_1[0]['sell_comission'],
						'sell_comission_BNB'    =>  $result_1[0]['sell_comission_BNB'],
						'last_modified_time'	=> 	$this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))
					];

					$search_find['month'] = $month;
					$search_find['coin']  = $coin_array[$coin];
					$search_find['mode']  = 'live';
					echo "<pre>";print_r($search_find);
					$res = $custom->opportunity_logs_monthly_binance->updateOne($search_find, ['$set'=> $updateArray]);
				}
			}
		}
		
		echo "<br>All Done!!!";
	} //end cron


	/////////////////////////////////////////////////////////////////////////////
	///////////////         ASIM CRONE KRAKEN MONTHLY        ////////////////////
	/////////////////////////////////////////////////////////////////////////////

	public function insert_latest_oppertunity_into_log_collection_monthly_kraken(){

		//Save last Cron Executioon
		$this->last_cron_execution_time('Kraken live opportunity monthly', '55m', 'run kraken live opportunity avg calculation monthly (55 * * * *)', 'reports');

		$compaire_month = date('Y-m');
		$month = date('Y-m');
		$start_date_time =  date('Y-m-01 00:00:00');
		$time_date =  $this->mongo_db->converToMongodttime($start_date_time);

		$end = date('Y-m-d 23:59:59');
		$enddate = $this->mongo_db->converToMongodttime($end);

		$current_date = date('Y-m-d H:i:s');
		$current_time_date =  $this->mongo_db->converToMongodttime($current_date);

		$coin_array_all = $this->mod_coins->get_all_coins_kraken();
		$coin_count = 0;
		foreach($coin_array_all as $value){
			echo "<br>count coin = ".$coin_count;
			$custom = $this->mongo_db->customQuery(); 
			$condtn = array('sort'=>array('created_date'=> -1));
			$coin = $coin_array_all[$coin_count]['symbol'];
			echo"<br>coin name= ".$coin_array_all[$coin_count]['symbol'];
			$where['coin'] = $coin; 
			$where['mode'] = 'live';
			$where['oppertunity_missed'] = array('$exists'=>false);
			$where['created_date'] = array('$gte' => $time_date, '$lte'=>$enddate);
			$where['level'] = array('$in'=>array('level_5', 'level_6', 'level_8', 'level_10','level_11','level_12','level_13', 'level_17', 'level_18'));

			$resps = $custom->opportunity_logs_kraken->find($where, $condtn);
			$result_1 = iterator_to_array($resps);  
			echo "<br>count= ".count($result_1);
			
			$sold = 0;
			$open_lth =0;
			$avg_sold_manul = 0;
			$avg_sold = 0;
			$avg_open_lth =0;
			$picket_parent = 0;
			$execuated_parent = 0;
			$other_status = 0;
			$cancelled = 0;        
			$new_error = 0;
			$created_date ='';
			$sum_all = 0;
			$total_investment_btc = 0;						
			$total_profit_btc = 0;
			$total_buy_comission_btc = 0;
			$total_sell_comission_btc = 0;
			$buy_comission_BNB =0;
			$sell_comission_BNB =0;
			$total_gain_btc = 0;

			$sellTimeDiffRange1 = 0 ;
			$sellTimeDiffRange2 = 0 ;	
			$sellTimeDiffRange3 = 0 ;
			$sellTimeDiffRange4 = 0 ;
			$sellTimeDiffRange5 = 0 ;
			$sellTimeDiffRange6 = 0 ;
			$sellTimeDiffRange7 = 0 ;

			$buyTimeDiffRange1 = 0 ;
			$buyTimeDiffRange2 = 0 ;	
			$buyTimeDiffRange3 = 0 ;
			$buyTimeDiffRange4 = 0 ;
			$buyTimeDiffRange5 = 0 ;
			$buyTimeDiffRange6 = 0 ;
			$buyTimeDiffRange7 = 0 ;

			$sumPLSllipageRange1 = 0 ;
			$sumPLSllipageRange2 = 0 ; 
			$sumPLSllipageRange3 = 0 ;
			$sumPLSllipageRange4 = 0 ;
			$sumPLSllipageRange5 = 0 ;

			if(count($result_1) > 0){
				foreach($result_1 as $value_1){  
					$total_investment_btc += $value_1['btc_investment'];
					$total_profit_btc += $value_1['total_btc_profit'];
					$total_buy_comission_btc += $value_1['buy_commission'];  
					$total_sell_comission_btc += $value_1['sell_commission'];  
					$buy_comission_BNB  += $value_1['buy_commision_qty'];
					$sell_comission_BNB += $value_1['sell_fee_respected_coin'];
					$total_gain_btc +=   $value_1['sold_btc_profit'];      
					echo"<br>oppertunity Id = ".$value_1['opportunity_id'];
					$opp['opportunity_id'] = $value_1['opportunity_id']; 
					$opp['mode'] = 'live';			
					$created_date = $value_1['created_date'];
					$avg_sold_manul += $value_1['avg_manul'];
					$sold +=  $value_1['sold'];
					$open_lth += $value_1['open_lth'];
					$avg_sold += $value_1['avg_sold'];
					$avg_open_lth += $value_1['avg_open_lth'];
					$picket_parent += $value_1['parents_picked'];
					$execuated_parent +=  $value_1['parents_executed'];
					$other_status += $value_1['other_status'];
					$cancelled += $value_1['cancelled'];        
					$new_error += $value_1['new_error'];
					$sum_all = $sold + $cancelled + $new_error;


					$sellTimeDiffRange1 += 	$value_1['sellTimeDiffRange1']; 	
					$sellTimeDiffRange2 +=	$value_1['sellTimeDiffRange2']; 	
					$sellTimeDiffRange3 +=	$value_1['sellTimeDiffRange3']; 	
					$sellTimeDiffRange4 +=	$value_1['sellTimeDiffRange4']; 	
					$sellTimeDiffRange5 +=	$value_1['sellTimeDiffRange5']; 	
					$sellTimeDiffRange6 +=	$value_1['sellTimeDiffRange6']; 	
					$sellTimeDiffRange7 +=	$value_1['sellTimeDiffRange7']; 

					$buyTimeDiffRange1 += 	$value_1['buySumTimeDelayRange1']; 	
					$buyTimeDiffRange2 +=	$value_1['buySumTimeDelayRange2']; 	
					$buyTimeDiffRange3 +=	$value_1['buySumTimeDelayRange3']; 	
					$buyTimeDiffRange4 +=	$value_1['buySumTimeDelayRange4']; 	
					$buyTimeDiffRange5 +=	$value_1['buySumTimeDelayRange5']; 	
					$buyTimeDiffRange6 +=	$value_1['buySumTimeDelayRange6']; 	
					$buyTimeDiffRange7 +=	$value_1['buySumTimeDelayRange7'];

					$sumPLSllipageRange1 += $value_1['sumPLSllipageRange1']; 	
					$sumPLSllipageRange2 += $value_1['sumPLSllipageRange2']; 	 
					$sumPLSllipageRange3 +=	$value_1['sumPLSllipageRange3']; 	
					$sumPLSllipageRange4 += $value_1['sumPLSllipageRange4']; 	
					$sumPLSllipageRange5 += $value_1['sumPLSllipageRange5']; 	


				}
				$time = $created_date->toDateTime()->format("Y-m-d H:i:s");
				$created_date_mnth_year = date("Y-m",strtotime($time));
				$created_month_year =  $this->mongo_db->converToMongodttime($created_date_mnth_year);
				$current_month_year = $this->mongo_db->converToMongodttime($compaire_month);
				
				echo "<br>datetime month year = ". date("Y-m",strtotime($time));
				echo "<br>execuated =".$execuated_parent;
				echo "<br>Sum of all = ".$sum_all;
				echo"<br>open lth =".$open_lth;
				echo"<br> if check value = ".$created_month_year."!=".$current_month_year;
				
				$final_open_avg = 0;
				$final_avg_manul_sold = 0;
				$final_sold_avg = 0;
				$final_open_avg = $avg_open_lth / count($result_1);
				$final_sold_avg = $avg_sold / count($result_1);
				$final_avg_manul_sold = $avg_sold_manul/ count($result_1);
				if($final_open_avg == '' || $final_open_avg == null || is_infinite($final_open_avg)){
					$final_open_avg = 0;
				}
				if($final_sold_avg == '' || $final_sold_avg == null || is_infinite($final_sold_avg)){
					$final_sold_avg = 0;
				}
				if($final_avg_manul_sold == '' || $final_avg_manul_sold == null || is_infinite($final_avg_manul_sold)){
					$final_avg_manul_sold = 0;
				}
				$new_array = array(
					'sold' 				=> $sold,
					'month'        		=> $month,
					'coin'				=> $coin,
					'mode' 				=> 'live',
					'open_lth' 			=> $open_lth,
					'avg_sold'	    	=> $final_sold_avg,
					'avg_open_lth'     	=> $final_open_avg,
					'execuated_parent' 	=> $execuated_parent,
					'other_status' 	   	=> $other_status,
					'last_modified_time'=> $current_time_date,

					'sellTimeDiffRange1'	=>	($sellTimeDiffRange1 / $sold) * 100,
					'sellTimeDiffRange2'	=>	($sellTimeDiffRange2 / $sold) * 100,	
					'sellTimeDiffRange3'	=>	($sellTimeDiffRange3 / $sold) * 100,
					'sellTimeDiffRange4'	=>	($sellTimeDiffRange4 / $sold) * 100,
					'sellTimeDiffRange5'	=>	($sellTimeDiffRange5 / $sold) * 100,
					'sellTimeDiffRange6'	=>	($sellTimeDiffRange6 / $sold) * 100,
					'sellTimeDiffRange7'	=>	($sellTimeDiffRange7 / $sold) * 100,

					'buyTimeDiffRange1'		=> 	($buyTimeDiffRange1 / ($sold + $open_lth)) * 100 , 		 	
					'buyTimeDiffRange2' 	=> 	($buyTimeDiffRange2 / ($sold + $open_lth)) * 100 ,	
					'buyTimeDiffRange3' 	=> 	($buyTimeDiffRange3 / ($sold + $open_lth)) * 100 , 	
					'buyTimeDiffRange4' 	=> 	($buyTimeDiffRange4 / ($sold + $open_lth)) * 100 , 	
					'buyTimeDiffRange5' 	=> 	($buyTimeDiffRange5 / ($sold + $open_lth)) * 100 , 	
					'buyTimeDiffRange6' 	=> 	($buyTimeDiffRange6 / ($sold + $open_lth)) * 100 ,  	
					'buyTimeDiffRange7' 	=> 	($buyTimeDiffRange7 / ($sold + $open_lth)) * 100 ,  

					'sumPLSllipageRange1'	=>	($sumPLSllipageRange1 / $sold) * 100,
					'sumPLSllipageRange2'	=>	($sumPLSllipageRange2 / $sold) * 100,	
					'sumPLSllipageRange3'	=>	($sumPLSllipageRange3 / $sold) * 100,
					'sumPLSllipageRange4'	=>	($sumPLSllipageRange4 / $sold) * 100,
					'sumPLSllipageRange5'	=>	($sumPLSllipageRange5 / $sold) * 100,

					'total_oppertunities'=>count($result_1),
					'avg_sold_manul'  	=> $final_avg_manul_sold,
					'total_investment' 	=> $total_investment_btc,
					'buy_comission_BNB'=> $buy_comission_BNB,
					'buy_comission' 	=> $total_buy_comission_btc
				);
				if($execuated_parent == $sum_all && $created_month_year != $current_month_year && ($open_lth + $other_status) == 0){
					echo"<br>asasas";
					$new_array['total_profit'] =$total_profit_btc;
					$new_array['total_gain'] = $total_gain_btc; 
					$new_array['sell_comission'] =  $total_sell_comission_btc;
					$new_array['sell_comission_BNB'] = $sell_comission_BNB;
				}
				echo "<pre>";
				print_r($new_array);
				$search_find['month'] = $month;
				$search_find['coin']  = $coin;
				$search_find['mode'] = 'live';
				$upsert['upsert'] = true;
				$res = $custom->opportunity_logs_monthly_kraken->updateOne($search_find, ['$set'=> $new_array], $upsert);
			}
			$coin_count++;
			echo "<br>total picked records = ".count($result_1);
			
		}// end coin loop			
	} //end cron


	public function insert_latest_oppertunity_into_log_collection_monthly_kraken_old_opportunity_scan(){
		$monthStart = date('m');
		$monthStart = $monthStart - 1 ;
		$custom = $this->mongo_db->customQuery(); 

		$coin_array  = ['EOSUSDT', 'LTCUSDT','XRPUSDT','NEOUSDT', 'QTUMUSDT','BTCUSDT', 'XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC'];
		for($i = 1; $i <= $monthStart; $i++){
			for($coin = 1; $coin < count($coin_array); $coin++){
				$month           =  date('Y-'.$i);
				$compaire_month  =  date('Y-'.$i);
				$startDate = date('Y-'.$i.'-01 00:00:00');
				$endDate   = date('t', strtotime($startDate));
				$endDate = date('Y-'.$i.'-'.$endDate .' 23:59:59');
				echo "<br>start Time: ".$startDate;
				echo "<br>End Time: ".$endDate;
				$startDate = $this->mongo_db->converToMongodttime($startDate);
				$endDate   = $this->mongo_db->converToMongodttime(date($endDate));

				$lookUpQuery = [
					[
						'$match' => [
							'coin' 				 => 	$coin_array[$coin], 
							'mode' 				 => 	'live',
							'oppertunity_missed' => 	['$exists' => false ],
							'created_date' 		 => 	['$gte' => $startDate, '$lte'=>$endDate ],
							'level' 			 => 	array('$in'=>array('level_5', 'level_6', 'level_8', 'level_10','level_11','level_12','level_13', 'level_17', 'level_18'))
						]
					],

					[
						'$group' =>[
							'_id'  => '$coin',
							'total_investment_btc' 		=>  ['$sum' => '$btc_investment'],
							'total_profit_btc'	   		=>  ['$sum' => '$total_btc_profit'],
							'total_buy_comission_btc' 	=>  ['$sum' => '$buy_commission'],
							'total_sell_comission_btc' 	=>  ['$sum' => '$sell_commission'],
							'buy_comission_BNB'			=> 	['$sum' => '$buy_commision_qty'],
							'sell_comission_BNB'		=> 	['$sum' => '$sell_fee_respected_coin'],
							'total_gain_btc'			=>	['$sum' => '$sold_btc_profit'],
							'opportunity_id'			=> 	['$sum' => '$opportunity_id'],
							'sold'		 				=>  ['$sum' => '$sold'],
							'avg_sold_manul'	        =>  ['$sum' => '$avg_manul'],
							'open_lth'					=>  ['$sum' => '$open_lth'],
							'avg_sold'					=>	['$sum' => '$avg_sold'],
							'avg_open_lth'				=> 	['$sum' => '$avg_open_lth'],
							'picket_parent'				=>	['$sum' => '$parents_picked'],
							'execuated_parent'			=> 	['$sum' => '$parents_executed'],
							'other_status'				=> 	['$sum' => '$other_status'],
							'cancelled'                 =>  ['$sum' => '$cancelled'],
							'new_error'					=>	['$sum' => '$new_error'],
							'sellTimeDiffRange1'        =>  ['$sum' => '$sellTimeDiffRange1'],
							'sellTimeDiffRange2'		=>	['$sum' => '$sellTimeDiffRange2'],
							'sellTimeDiffRange3'		=>	['$sum' => '$sellTimeDiffRange3'],
							'sellTimeDiffRange4'		=>	['$sum' => '$sellTimeDiffRange4'],
							'sellTimeDiffRange5'		=>	['$sum' => '$sellTimeDiffRange5'],
							'sellTimeDiffRange6'		=>	['$sum' => '$sellTimeDiffRange6'],
							'sellTimeDiffRange7'		=>	['$sum' => '$sellTimeDiffRange7'],
							'buyTimeDiffRange1'			=> 	['$sum' => '$buySumTimeDelayRange1'],
							'buyTimeDiffRange2'			=>  ['$sum' => '$buySumTimeDelayRange2'],
							'buyTimeDiffRange3'			=>	['$sum'  => '$buySumTimeDelayRange3'],
							'buyTimeDiffRange4'			=>	['$sum' => '$buySumTimeDelayRange4'],
							'buyTimeDiffRange5'			=> 	['$sum' => '$buySumTimeDelayRange5'],
							'buyTimeDiffRange6'			=> 	['$sum' => '$buySumTimeDelayRange6'],
							'buyTimeDiffRange7'			=> 	['$sum' => '$buySumTimeDelayRange7'],
							'sumPLSllipageRange1'		=> 	['$sum' => '$sumPLSllipageRange1'],
							'sumPLSllipageRange2'		=>	['$sum' => '$sumPLSllipageRange2'],
							'sumPLSllipageRange3'		=>	['$sum' => '$sumPLSllipageRange3'],
							'sumPLSllipageRange4'		=>	['$sum' => '$sumPLSllipageRange4'],
							'sumPLSllipageRange5'		=>	['$sum' => '$sumPLSllipageRange5'],
							'count'						=>	['$sum' => 1],
						]
					],


					[
						'$project' => [
							'_id' => null,
							'final_open_avg'  		=>  ['$divide' => ['$avg_open_lth' , '$count']],
							'final_sold_avg'  		=>  ['$divide' => ['$avg_sold', '$count']],
							'final_avg_manul_sold'	=>	['$divide' => ['$avg_sold_manul', '$count']],
							'sold' 					=> 	'$sold',
							'month'        			=> 	$month,
							'coin'					=> 	$coin_array[$coin],
							'mode' 					=> 	'live',
							'sum_all' 				=>	['$sum' => [ '$sold', '$cancelled' , '$new_error']],
							'created_date'			=>  '$created_date',
							'sellTimeDiffRange1'	=>	['$multiply' => [['$divide'  => [ '$sellTimeDiffRange1', '$sold']] , 100]],
							'sellTimeDiffRange2'	=>	['$multiply' => [['$divide'  => [ '$sellTimeDiffRange2', '$sold']] , 100]],	
							'sellTimeDiffRange3'	=>	['$multiply' => [['$divide'  => [ '$sellTimeDiffRange3', '$sold']] , 100]],
							'sellTimeDiffRange4'	=>	['$multiply' => [['$divide'  => [ '$sellTimeDiffRange4', '$sold']] , 100]],
							'sellTimeDiffRange5'	=>	['$multiply' => [['$divide'  => [ '$sellTimeDiffRange5', '$sold']] , 100]],
							'sellTimeDiffRange6'	=>	['$multiply' => [['$divide'  => [ '$sellTimeDiffRange6', '$sold']] , 100]],
							'sellTimeDiffRange7'	=>	['$multiply' => [['$divide'  => ['$sellTimeDiffRange7' , '$sold']] , 100]],
							'buyTimeDiffRange1'		=>  ['$multiply' => [ ['$divide' => [ '$buyTimeDiffRange1' , ['$sum' => [ '$sold' , '$open_lth']] ]] , 100]], 		 	
							'buyTimeDiffRange2'		=>  ['$multiply' => [ ['$divide' => [ '$buyTimeDiffRange2' , ['$sum' => [ '$sold' , '$open_lth']] ]] , 100]],
							'buyTimeDiffRange3'		=>  ['$multiply' => [ ['$divide' => [ '$buyTimeDiffRange3' , ['$sum' => [ '$sold' , '$open_lth']] ]] , 100]],
							'buyTimeDiffRange4'		=>  ['$multiply' => [ ['$divide' => [ '$buyTimeDiffRange4' , ['$sum' => [ '$sold' , '$open_lth']] ]] , 100]],
							'buyTimeDiffRange5'		=>  ['$multiply' => [ ['$divide' => [ '$buyTimeDiffRange5' , ['$sum' => [ '$sold' , '$open_lth']] ]] , 100]],
							'buyTimeDiffRange6'		=>  ['$multiply' => [ ['$divide' => [ '$buyTimeDiffRange6' , ['$sum' => [ '$sold' , '$open_lth']] ]] , 100]],
							'buyTimeDiffRange7'		=>  ['$multiply' => [ ['$divide' => [ '$buyTimeDiffRange7' , ['$sum' => [ '$sold' , '$open_lth']] ]] , 100]],
 							'sumPLSllipageRange1'	=> 	['$multiply' => [ ['$divide' => ['$sumPLSllipageRange1', '$sold' ]], 100]],    
							'sumPLSllipageRange2'	=> 	['$multiply' => [ ['$divide' => ['$sumPLSllipageRange2', '$sold' ]], 100]],
							'sumPLSllipageRange3'	=> 	['$multiply' => [ ['$divide' => ['$sumPLSllipageRange3', '$sold' ]], 100]],
							'sumPLSllipageRange4'	=> 	['$multiply' => [ ['$divide' => ['$sumPLSllipageRange4', '$sold' ]], 100]],
							'sumPLSllipageRange5'	=> 	['$multiply' => [ ['$divide' => ['$sumPLSllipageRange5', '$sold' ]], 100]],
							'open_lth' 				=> 	'$open_lth',
							'avg_sold'	    		=> 	'$final_sold_avg',
							'avg_open_lth'     		=> 	'$final_open_avg',
							'execuated_parent' 		=> 	'$execuated_parent',
							'other_status' 	   		=> 	'$other_status',
							'last_modified_time'	=> 	'$current_time_date',
							'total_oppertunities'	=>	'$count',
							'avg_sold_manul'  		=> 	'$final_avg_manul_sold',
							'total_investment' 		=> 	'$total_investment_btc',
							'buy_comission_BNB'		=> 	'$buy_comission_BNB',
							'buy_comission' 		=> 	'$total_buy_comission_btc',
							'total_profit' 			=>  '$total_profit_btc',
							'total_gain'			=>	'$total_gain_btc',
							'sell_comission'        =>  '$total_sell_comission_btc',
							'sell_comission_BNB'    =>  '$sell_comission_BNB',
						]
					],

					[
						'$sort' => ['created_date'=> -1]
					]
				];

				$resps = $custom->opportunity_logs_kraken->aggregate($lookUpQuery);
				$result_1 = iterator_to_array($resps);
				if(count($result_1) > 0 ){
					$updateArray = [
						'final_open_avg'  		=>  $result_1[0]['final_open_avg'],
						'final_sold_avg'  		=>  $result_1[0]['final_sold_avg'],
						'final_avg_manul_sold'	=>	$result_1[0]['final_avg_manul_sold'],
						'sold' 					=> 	$result_1[0]['sold'],
						'month'        			=> 	$result_1[0]['month'],
						'coin'					=> 	$result_1[0]['coin'],
						'mode' 					=> 	$result_1[0]['mode'],
						'sum_all' 				=>	$result_1[0]['sum_all'],
						'created_date'			=>  $result_1[0]['created_date'],
						'sellTimeDiffRange1'	=>	$result_1[0]['sellTimeDiffRange1'],
						'sellTimeDiffRange2'	=>	$result_1[0]['sellTimeDiffRange2'],	
						'sellTimeDiffRange3'	=>	$result_1[0]['sellTimeDiffRange3'],
						'sellTimeDiffRange4'	=>	$result_1[0]['sellTimeDiffRange4'],
						'sellTimeDiffRange5'	=>	$result_1[0]['sellTimeDiffRange5'],
						'sellTimeDiffRange6'	=>	$result_1[0]['sellTimeDiffRange6'],
						'sellTimeDiffRange7'	=>	$result_1[0]['sellTimeDiffRange7'],
						'buyTimeDiffRange1'		=>  $result_1[0]['buyTimeDiffRange1'], 		 	
						'buyTimeDiffRange2'		=>  $result_1[0]['buyTimeDiffRange2'],
						'buyTimeDiffRange3'		=>  $result_1[0]['buyTimeDiffRange3'],
						'buyTimeDiffRange4'		=>  $result_1[0]['buyTimeDiffRange4'],
						'buyTimeDiffRange5'		=>  $result_1[0]['buyTimeDiffRange5'],
						'buyTimeDiffRange6'		=>  $result_1[0]['buyTimeDiffRange6'],
						'buyTimeDiffRange7'		=>  $result_1[0]['buyTimeDiffRange7'],
						'sumPLSllipageRange1'	=> 	$result_1[0]['sumPLSllipageRange1'],    
						'sumPLSllipageRange2'	=> 	$result_1[0]['sumPLSllipageRange2'],
						'sumPLSllipageRange3'	=> 	$result_1[0]['sumPLSllipageRange3'],
						'sumPLSllipageRange4'	=> 	$result_1[0]['sumPLSllipageRange4'],
						'sumPLSllipageRange5'	=> 	$result_1[0]['sumPLSllipageRange5'],
						'open_lth' 				=> 	$result_1[0]['open_lth'],
						'avg_sold'	    		=> 	$result_1[0]['avg_sold'],
						'avg_open_lth'     		=> 	$result_1[0]['avg_open_lth'],
						'execuated_parent' 		=> 	$result_1[0]['execuated_parent'],
						'other_status' 	   		=> 	$result_1[0]['other_status'],
						'last_modified_time'	=> 	$result_1[0]['last_modified_time'],
						'total_oppertunities'	=>	$result_1[0]['total_oppertunities'],
						'avg_sold_manul'  		=> 	$result_1[0]['avg_sold_manul'],
						'total_investment' 		=> 	$result_1[0]['total_investment'],
						'buy_comission_BNB'		=> 	$result_1[0]['buy_comission_BNB'],
						'buy_comission' 		=> 	$result_1[0]['buy_comission'],
						'total_profit' 			=>  $result_1[0]['total_profit'],
						'total_gain'			=>	$result_1[0]['total_gain'],
						'sell_comission'        =>  $result_1[0]['sell_comission'],
						'sell_comission_BNB'    =>  $result_1[0]['sell_comission_BNB'],
						'last_modified_time'	=> 	$this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))
					];

					$search_find['month'] = $month;
					$search_find['coin']  = $coin_array[$coin];
					$search_find['mode']  = 'live';
					echo "<pre>";print_r($updateArray);
					$res = $custom->opportunity_logs_monthly_krakesn->updateOne($search_find, ['$set'=> $updateArray]);
				}
			}
		}
		
		echo "<br>All Done!!!";		
	} //end cron

	/////////////////////////////////////////////////////////////////////////////
	///////////////          ASIM CRONE BSM MONTHLY            //////////////////
	/////////////////////////////////////////////////////////////////////////////

	public function insert_latest_oppertunity_into_log_collection_monthly_bam(){

		//Save last Cron Executioon
		$this->last_cron_execution_time('Bam live opportunity monthly', '55m', 'run Bam live opportunity avg calculation monthly (55 * * * *)', 'reports');

		$compaire_month = date('Y-m');
		$month = date('Y-m');
		$start_date_time =  date('Y-m-01 00:00:00');
		$time_date =  $this->mongo_db->converToMongodttime($start_date_time);

		$end = date('Y-m-d 23:59:59');
		$enddate = $this->mongo_db->converToMongodttime($end);

		$current_date = date('Y-m-d H:i:s');
		$current_time_date =  $this->mongo_db->converToMongodttime($current_date);
		$coin_array_all = $this->mod_coins->get_all_coins_bam();
		$coin_count = 0;
		foreach($coin_array_all as $value){
			echo"<br>coin count = ".$coin_count;
			$custom = $this->mongo_db->customQuery(); 
			$condtn = array('sort'=>array('created_date'=> -1));
			$coin = $coin_array_all[$coin_count]['symbol'];
			$where['coin'] = $coin; 
			$where['mode'] = 'live';
			$where['oppertunity_missed'] = array('$exists'=>false);
			$where['created_date'] = array('$gte' => $time_date, '$lte'=>$enddate);
			$where['level'] = array('$in'=>array('level_5','level_6', 'level_8', 'level_10','level_11','level_12','level_13', 'level_17', 'level_17'));

			$resps = $custom->opportunity_logs_bam->find($where, $condtn);
			$result_1 = iterator_to_array($resps);  
			echo "<br>count= ".count($result_1);
			
			$sold = 0;
			$open_lth =0;
			$avg_sold_manul = 0;
			$avg_sold = 0;
			$avg_open_lth =0;
			$picket_parent = 0;
			$execuated_parent = 0;
			$other_status = 0;
			$cancelled = 0;        
			$new_error = 0;
			$created_date ='';
			$sum_all = 0;
			$total_investment_btc = 0;						
			$total_profit_btc = 0;
			$total_buy_comission_btc = 0;
			$total_sell_comission_btc = 0;
			$buy_comission_BNB =0;
			$sell_comission_BNB =0;
			$total_gain_btc = 0;


			$sellTimeDiffRange1 = 0 ;
			$sellTimeDiffRange2 = 0 ;	
			$sellTimeDiffRange3 = 0 ;
			$sellTimeDiffRange4 = 0 ;
			$sellTimeDiffRange5 = 0 ;
			$sellTimeDiffRange6 = 0 ;
			$sellTimeDiffRange7 = 0 ;

			$buyTimeDiffRange1 = 0 ;
			$buyTimeDiffRange2 = 0 ;	
			$buyTimeDiffRange3 = 0 ;
			$buyTimeDiffRange4 = 0 ;
			$buyTimeDiffRange5 = 0 ;
			$buyTimeDiffRange6 = 0 ;
			$buyTimeDiffRange7 = 0 ;

			$sumPLSllipageRange1 = 0 ;
			$sumPLSllipageRange2 = 0 ; 
			$sumPLSllipageRange3 = 0 ;
			$sumPLSllipageRange4 = 0 ;
			$sumPLSllipageRange5 = 0 ;

			if(count($result_1) > 0){
				foreach($result_1 as $value_1){  
					$total_investment_btc += $value_1['btc_investment'];
					$total_profit_btc += $value_1['total_btc_profit'];
					$total_buy_comission_btc += $value_1['buy_commission'];  
					$total_sell_comission_btc += $value_1['sell_commission'];  
					$buy_comission_BNB  += $value_1['buy_commision_qty'];
					$sell_comission_BNB += $value_1['sell_fee_respected_coin'];
					$total_gain_btc +=   $value_1['sold_btc_profit'];      
					echo"<br>oppertunity Id = ".$value_1['opportunity_id'];
					$opp['opportunity_id'] = $value_1['opportunity_id']; 
					$opp['mode'] = 'live';			
					$created_date = $value_1['created_date'];
					$avg_sold_manul += $value_1['avg_manul'];
					$sold +=  $value_1['sold'];
					$open_lth += $value_1['open_lth'];
					$avg_sold += $value_1['avg_sold'];
					$avg_open_lth += $value_1['avg_open_lth'];
					$picket_parent += $value_1['parents_picked'];
					$execuated_parent +=  $value_1['parents_executed'];
					$other_status += $value_1['other_status'];
					$cancelled += $value_1['cancelled'];        
					$new_error += $value_1['new_error'];
					$sum_all = $sold + $cancelled + $new_error;

					$sellTimeDiffRange1 += 	$value_1['sellTimeDiffRange1']; 	
					$sellTimeDiffRange2 +=	$value_1['sellTimeDiffRange2']; 	
					$sellTimeDiffRange3 +=	$value_1['sellTimeDiffRange3']; 	
					$sellTimeDiffRange4 +=	$value_1['sellTimeDiffRange4']; 	
					$sellTimeDiffRange5 +=	$value_1['sellTimeDiffRange5']; 	
					$sellTimeDiffRange6 +=	$value_1['sellTimeDiffRange6']; 	
					$sellTimeDiffRange7 +=	$value_1['sellTimeDiffRange7']; 

					$buyTimeDiffRange1 += 	$value_1['buySumTimeDelayRange1']; 	
					$buyTimeDiffRange2 +=	$value_1['buySumTimeDelayRange2']; 	
					$buyTimeDiffRange3 +=	$value_1['buySumTimeDelayRange3']; 	
					$buyTimeDiffRange4 +=	$value_1['buySumTimeDelayRange4']; 	
					$buyTimeDiffRange5 +=	$value_1['buySumTimeDelayRange5']; 	
					$buyTimeDiffRange6 +=	$value_1['buySumTimeDelayRange6']; 	
					$buyTimeDiffRange7 +=	$value_1['buySumTimeDelayRange7'];

					$sumPLSllipageRange1 += $value_1['sumPLSllipageRange1']; 	
					$sumPLSllipageRange2 += $value_1['sumPLSllipageRange2']; 	 
					$sumPLSllipageRange3 +=	$value_1['sumPLSllipageRange3']; 	
					$sumPLSllipageRange4 += $value_1['sumPLSllipageRange4']; 	
					$sumPLSllipageRange5 += $value_1['sumPLSllipageRange5']; 	


				}
				$time = $created_date->toDateTime()->format("Y-m-d H:i:s");
				$created_date_mnth_year = date("Y-m",strtotime($time));
				$created_month_year =  $this->mongo_db->converToMongodttime($created_date_mnth_year);
				$current_month_year = $this->mongo_db->converToMongodttime($compaire_month);
				
				echo "<br>datetime month year = ". date("Y-m",strtotime($time));
				echo "<br>execuated =".$execuated_parent;
				echo "<br>Sum of all = ".$sum_all;
				echo"<br>open lth =".$open_lth;
				echo"<br> if check value = ".$created_month_year."!=".$current_month_year;
				
				$final_open_avg = 0;
				$final_avg_manul_sold = 0;
				$final_sold_avg = 0;
				$final_open_avg = $avg_open_lth / count($result_1);
				$final_sold_avg = $avg_sold / count($result_1);
				$final_avg_manul_sold = $avg_sold_manul/ count($result_1);
				if($final_open_avg == '' || $final_open_avg == null || is_infinite($final_open_avg)){
					$final_open_avg = 0;
				}
				if($final_sold_avg == '' || $final_sold_avg == null || is_infinite($final_sold_avg)){
					$final_sold_avg = 0;
				}
				if($final_avg_manul_sold == '' || $final_avg_manul_sold == null || is_infinite($final_avg_manul_sold)){
					$final_avg_manul_sold = 0;
				}
				$new_array = array(
					'sold' 				=> $sold,
					'month'        		=> $month,
					'coin'				=> $coin,
					'mode' 				=> 'live',
					'open_lth' 			=> $open_lth,
					'avg_sold'	    	=> $final_sold_avg,
					'avg_open_lth'     	=> $final_open_avg,

					'sellTimeDiffRange1'	=>	($sellTimeDiffRange1 / $sold) * 100,
					'sellTimeDiffRange2'	=>	($sellTimeDiffRange2 / $sold) * 100,	
					'sellTimeDiffRange3'	=>	($sellTimeDiffRange3 / $sold) * 100,
					'sellTimeDiffRange4'	=>	($sellTimeDiffRange4 / $sold) * 100,
					'sellTimeDiffRange5'	=>	($sellTimeDiffRange5 / $sold) * 100,
					'sellTimeDiffRange6'	=>	($sellTimeDiffRange6 / $sold) * 100,
					'sellTimeDiffRange7'	=>	($sellTimeDiffRange7 / $sold) * 100,

					'buyTimeDiffRange1'		=> 	($buyTimeDiffRange1 / ($sold + $open_lth)) * 100 , 		 	
					'buyTimeDiffRange2' 	=> 	($buyTimeDiffRange2 / ($sold + $open_lth)) * 100 ,	
					'buyTimeDiffRange3' 	=> 	($buyTimeDiffRange3 / ($sold + $open_lth)) * 100 , 	
					'buyTimeDiffRange4' 	=> 	($buyTimeDiffRange4 / ($sold + $open_lth)) * 100 , 	
					'buyTimeDiffRange5' 	=> 	($buyTimeDiffRange5 / ($sold + $open_lth)) * 100 , 	
					'buyTimeDiffRange6' 	=> 	($buyTimeDiffRange6 / ($sold + $open_lth)) * 100 ,  	
					'buyTimeDiffRange7' 	=> 	($buyTimeDiffRange7 / ($sold + $open_lth)) * 100 , 
					
					'sumPLSllipageRange1'	=>	($sumPLSllipageRange1 / $sold) * 100,
					'sumPLSllipageRange2'	=>	($sumPLSllipageRange2 / $sold) * 100,	
					'sumPLSllipageRange3'	=>	($sumPLSllipageRange3 / $sold) * 100,
					'sumPLSllipageRange4'	=>	($sumPLSllipageRange4 / $sold) * 100,
					'sumPLSllipageRange5'	=>	($sumPLSllipageRange5 / $sold) * 100,

					'execuated_parent' 	=> $execuated_parent,
					'other_status' 	   	=> $other_status,
					'last_modified_time'=> $current_time_date,
					'total_oppertunities'=>count($result_1),
					'avg_sold_manul'  	=> $final_avg_manul_sold,
					'total_investment' 	=> $total_investment_btc,
					'buy_comission_BNB'=> $buy_comission_BNB,
					'buy_comission' 	=> $total_buy_comission_btc
				);
				if($execuated_parent == $sum_all && $created_month_year != $current_month_year && ($open_lth + $other_status) == 0){
					echo"<br>asasas";
					$new_array['total_profit'] =$total_profit_btc;
					$new_array['total_gain'] = $total_gain_btc; 
					$new_array['sell_comission'] =  $total_sell_comission_btc;
					$new_array['sell_comission_BNB'] = $sell_comission_BNB;
				}
				echo "<pre>";
				print_r($new_array);
				$search_find['month'] = $month;
				$search_find['coin']  = $coin;
				$search_find['mode'] = 'live';
				$upsert['upsert'] = true;
				$custom->opportunity_logs_monthly_bam->updateOne($search_find, ['$set'=> $new_array], $upsert);
			}
			$coin_count++;
			echo "<br>total picked records = ".count($result_1)."coin = ".$value['symbol'];
			
		}//end loop			
	} //end cron

	//  add for crontab details
	public function last_cron_execution_time($name, $duration, $summary, $type){
	
		$this->load->library('mongo_db_3');
		$db_3 = $this->mongo_db_3->customQuery();
		$params = [
			'name' => $name,
			'cron_duration' 					=> 	$duration,
			'cron_summary'  					=> 	$summary,
			'type'          					=> 	$type,
			'last_updated_time_human_readible'	=> 	date('Y-m-d H:i:s')
		];
		echo "<pre>";print_r($params);
		$whereUpdate['name'] = $name;
		$upsert['upsert'] = true;
		$db_3->cronjob_execution_logs->updateOne($whereUpdate ,['$set' => $params], $upsert);
		echo "<br>update done";
	}//End last_cron_execution_time


	public function countDailyExpectedTrade(){
		$db = $this->mongo_db->customQuery();

		$collectionGetTradeCountBinance =  'auto_trade_settings'; 
		$collectionGetTradeCountKraken  =  'auto_trade_settings_kraken';
		
		$getTradeNumberCount = [
			[
				'$group' => [
					'_id' => 1,
					'total_usdt_count' => ['$sum' => '$step_4.dailyTradesExpectedUsdt'],
					'total_btc_count'  => ['$sum' => '$step_4.dailyTradesExpectedBtc']   
				]
			],
		];

		$binanceTradeCountResponse 		= 	$db->$collectionGetTradeCountBinance->aggregate($getTradeNumberCount);  //binance trade count
		$binanceTradeCountResponse 		= 	iterator_to_array($binanceTradeCountResponse);

		$krakenTradeCountResponse 		= 	$db->$collectionGetTradeCountKraken->aggregate($getTradeNumberCount);  //kraken trade count
		$krakenTradeCountResponse       = 	iterator_to_array($krakenTradeCountResponse);



		//getting active users count
		$search_criteria =[
			'avaliableBtcBalance'       => ['$gt' => 0 ],
			'exchange_enabled'          => 'yes',
			'remainingPoints'           => ['$gt' => 0 ],
		];
		$binanceActiveUserCount  	=  	$db->user_investment_binance->count($search_criteria);
		$krakenActiveUserCount  	=  	$db->user_investment_kraken->count($search_criteria);
		//end get user count



		$arrayInsertBinance = [
			'total_usdt_count'  	=>  $binanceTradeCountResponse[0]['total_usdt_count'],
			'total_btc_count'   	=>  $binanceTradeCountResponse[0]['total_btc_count'],
			'exchange'				=>	'binance',	
			'activeUserCount' 		=>	$binanceActiveUserCount
		];

		$arrayInsertKraken = [
			'total_usdt_count'  	=>  $krakenTradeCountResponse[0]['total_usdt_count'],
			'total_btc_count'   	=>  $krakenTradeCountResponse[0]['total_btc_count'],
			'exchange' 				=>	'kraken',	
			'activeUserCount' 		=>	$krakenActiveUserCount
		];


		$upsert_criteria['created_date']  =  $this->mongo_db->converToMongodttime(date('Y-m-d'));
		$upsert_criteria['exchange']     =  'binance';
		$db->expected_trade_buy_count_history->updateOne($upsert_criteria, ['$set' => $arrayInsertBinance], ['upsert' => true]);

		$upsert_criteria_kraken['created_date']  =  $this->mongo_db->converToMongodttime(date('Y-m-d'));
		$upsert_criteria_kraken['exchange']     =  'kraken';
		$db->expected_trade_buy_count_history->updateOne($upsert_criteria_kraken, ['$set' => $arrayInsertKraken], ['upsert' => true]);

		echo"<pre>";
		print_r($arrayInsertBinance);

		echo "<br>Kraken";
		print_r($arrayInsertKraken);


	}//end function

}//end controller