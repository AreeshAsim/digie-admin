<?php
/**
 *
 */
class Reports extends CI_Controller {

	function __construct() {

		parent::__construct();
		//load main template
		ini_set("memory_limit", -1);
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

		// $this->mod_login->verify_is_admin_login();
		// if ($this->session->userdata('user_role') != 1) {
		// 	redirect(base_url() . 'forbidden');
		// }

	}

	public function index() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		$customers = $this->mod_report->get_all_customers();

		$data['customers'] = $customers;

		$coins = $this->mod_report->get_coins();

		$data['coins'] = $coins;

		$orders = $this->mod_report->get_parent_orders();

		$data['orders'] = $orders;

		$this->stencil->paint('admin/reports/index', $data);

	}
	public function get_report() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		$error = array();
		if (!empty($this->input->post())) {
			$cust_id = $this->input->post('admin_id');
			if (!empty($cust_id)) {
				$data_sess['cust_id'] = $cust_id;
			}
			if (!empty($this->input->post('coin_filter')) || !empty($this->input->post('date_filter')) || !empty($this->input->post('type_filter'))) {
				$filter_data = $this->input->post();
			}
			if (!empty($filter_data)) {
				$date_filter = $filter_data['date_filter'];
				$date_arr = explode('-', $date_filter);
				if (!empty($date_arr)) {
					$start_date = $date_arr[0];
					$end_date = $date_arr[1];
					$start_date = date('Y-m-d', strtotime($start_date)) . " 00:00:00";
					$end_date = date('Y-m-d', strtotime($end_date)) . " 23:59:59";
				}
				$data_sess['filter_data']['coin_filter'] = $filter_data['coin_filter'];
				$data_sess['filter_data']['type_filter'] = $filter_data['type_filter'];
				$data_sess['filter_data']['start_date'] = $start_date;
				$data_sess['filter_data']['end_date'] = $end_date;
			}
			$this->session->set_userdata($data_sess);
		}

		////////////////////////////////Pagination Code///////////////////////////////////////////////
		$this->load->library("pagination");
		$resultsArrAll = $this->mod_report->count_all();
		$count = $resultsArrAll['count'];

		if ($_SERVER['REMOTE_ADDR'] == '101.50.127.131') {
			//echo "<pre>";   print_r($resultsArrAll); exit;
		}

		$config = array();
		$config["base_url"] = SURL . "admin/reports/get_report";
		$config["total_rows"] = $count;
		$config['per_page'] = 10;
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
		if (!isset($page)) {$page = 1;}
		$start = ($page - 1) * $config["per_page"];
		////////////////////////////End Pagination Code///////////////////////////////////////////////
		$order_arr = $this->mod_report->get_user_orders($start, $config["per_page"]);

		$page_links = $this->pagination->create_links();
		$customer = $this->mod_report->get_customer();
		$coins = $this->mod_report->get_coins();
		// Data To be send
		$market_sold_price_avg = $resultsArrAll['market_sold_price_avg'];
		$current_order_price_avg = $resultsArrAll['current_order_price_avg'];
		$avg_profit = $resultsArrAll['avg_profit'];
		$ErrorInOrder = $resultsArrAll['count'];
		$data['market_sold_price_avg'] = $market_sold_price_avg;
		$data['current_order_price_avg'] = $current_order_price_avg;
		$data['quantity_avg'] = $quantity_avg;
		$data['avg_profit'] = $avg_profit;

		$data['orders'] = $order_arr['fullarray'];
		$data['totalaverage'] = $totalaverage;
		$data['customer'] = $customer;
		$data['coins'] = $coins;
		$data['count'] = $count;
		$data['error'] = $ErrorInOrder;
		$data['page_links'] = $page_links;

		$this->stencil->paint('admin/reports/report', $data);

	}

	public function reset_filters($type) {

		$this->session->unset_userdata('filter_data');

		redirect(base_url() . 'admin/reports/get_report');

	} //End reset_buy_filters

	public function array2csv($array) {

		if (count($array) == 0) {

			return null;

		}

		ob_start();

		$df = fopen("php://output", 'w');

		fputcsv($df, array_keys((array) reset($array)));

		foreach ($array as $row) {

			fputcsv($df, (array) $row);

		}

		fclose($df);

		return ob_get_clean();

	}

	public function download_send_headers($filename) {

		// disable caching

		$now = gmdate("D, d M Y H:i:s");

		header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");

		header("Last-Modified: {$now} GMT");

		header("Content-type: application/csv");

		header("Pragma: no-cache");

		header("Expires: 0");

		// force download

		header("Content-Type: application/force-download");

		header("Content-Type: application/octet-stream");

		header("Content-Type: application/download");

		// disposition / encoding on response body

		header("Content-Disposition: attachment;filename={$filename}");

		header("Content-Transfer-Encoding: binary");

	}

	public function download_csv_trades() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		$timezone = $this->session->userdata('timezone');

		$time = $this->input->post('date');

		$coin_symbol = $this->input->post('coin');

		$time_arr = explode('to', $time);

		$s_date = $time_arr[0];

		$e_date = $time_arr[1];

		$s_dt = new DateTime($s_date, new DateTimeZone($timezone));

		$e_dt = new DateTime($e_date, new DateTimeZone($timezone));

		$s_dt->setTimezone(new DateTimeZone('UTC'));

		$e_dt->setTimezone(new DateTimeZone('UTC'));

		// format the datetime

		$s_time1 = $s_dt->format('Y-m-d H:i:s');

		$e_time1 = $e_dt->format('Y-m-d H:i:s');

		$start_time = date("Y-m-d H:i:00", strtotime($s_time1));

		$end_time = date("Y-m-d H:i:59", strtotime($e_time1));

		$array = $this->mod_report->get_trade_history($coin_symbol, $start_time, $end_time);

		$this->download_send_headers("trade_history_" . date("Y-m-d_ Gisa") . ".csv");

		echo $this->array2csv($array);

		exit;

	}

	public function download_csv_prices() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		$timezone = $this->session->userdata('timezone');

		$time = $this->input->post('date');

		$coin_symbol = $this->input->post('coin');

		$time_arr = explode('to', $time);

		$s_date = $time_arr[0];

		$e_date = $time_arr[1];

		$s_dt = new DateTime($s_date, new DateTimeZone($timezone));

		$e_dt = new DateTime($e_date, new DateTimeZone($timezone));

		$s_dt->setTimezone(new DateTimeZone('UTC'));

		$e_dt->setTimezone(new DateTimeZone('UTC'));

		// format the datetime

		$s_time1 = $s_dt->format('Y-m-d H:i:s');

		$e_time1 = $e_dt->format('Y-m-d H:i:s');

		$start_time = date("Y-m-d H:i:00", strtotime($s_time1));

		$end_time = date("Y-m-d H:i:59", strtotime($e_time1));

		$array = $this->mod_report->get_price_history($coin_symbol, $start_time, $end_time);

		$this->download_send_headers("prices_history_" . date("Y-m-d_ Gisa") . ".csv");

		echo $this->array2csv($array);

		exit;

	}

	public function test() {

		$this->mongo_db->limit(10);

		$this->mongo_db->order_by(array('_id' => -1));

		$get = $this->mongo_db->get('orders_history_log');

		echo "<pre>";

		print_r(iterator_to_array($get));

		exit;

	}

	public function order_history_log() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		$timezone = $this->session->userdata('timezone');

		$time = $this->input->post('date');

		$order_id = $this->input->post('order_id');

		$s_date = date('Y-m-d H:00:00', strtotime($time));

		$e_date = date('Y-m-d H:59:59', strtotime($time));

		$s_dt = new DateTime($s_date, new DateTimeZone($timezone));

		$e_dt = new DateTime($e_date, new DateTimeZone($timezone));

		$s_dt->setTimezone(new DateTimeZone('UTC'));

		$e_dt->setTimezone(new DateTimeZone('UTC'));

		// format the datetime

		$s_time1 = $s_dt->format('Y-m-d H:i:s');

		$e_time1 = $e_dt->format('Y-m-d H:i:s');

		$start_time = date("Y-m-d H:i:00", strtotime($s_time1));

		$end_time = date("Y-m-d H:i:59", strtotime($e_time1));

		$array = $this->mod_report->get_order_log($order_id, $start_time, $end_time);

		$data['log'] = $array;

		$this->stencil->paint('admin/reports/order_report', $data);

	}

	public function barrier_listing() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		$error = array();
		if (!empty($this->input->post())) {
			if (!empty($this->input->post('status')) || !empty($this->input->post('filter_coin')) || !empty($this->input->post('global_swing_parent_status')) || !empty($this->input->post('start_date')) || !empty($this->input->post('end_date')) || !empty($this->input->post('barrier_type')) || !empty($this->input->post('breakable'))) {
				$filter_data = $this->input->post();
			}
			if (!empty($filter_data)) {

				$data_sess['filter_data']['status'] = $this->input->post('status');
				$data_sess['filter_data']['filter_coin'] = $this->input->post('filter_coin');
				$data_sess['filter_data']['global_swing_parent_status'] = $this->input->post('global_swing_parent_status');
				$data_sess['filter_data']['start_date'] = $this->input->post('start_date');
				$data_sess['filter_data']['end_date'] = $this->input->post('end_date');
				$data_sess['filter_data']['barrier_type'] = $this->input->post('barrier_type');
				$data_sess['filter_data']['breakable'] = $this->input->post('breakable');
			}

			$this->session->set_userdata($data_sess);
		}
		//Pagination Code//
		$this->load->library("pagination");
		$countBarrierListing = $this->mod_dashboard->countBarrierListing();
		$count = $countBarrierListing;

		$config = array();
		$config["base_url"] = SURL . "admin/reports/barrier-listing";
		$config["total_rows"] = $count;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
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
		if (!isset($page)) {$page = 1;}
		$start = ($page - 1) * $config["per_page"];
		////////////////////////////End Pagination Code///////////////////////////////////////////////
		$barrierListing_arr = $this->mod_dashboard->barrierListing($start, $config["per_page"]);
		$page_links = $this->pagination->create_links();
		$data['page_links'] = $page_links;
		$data['barrier_arr'] = $barrierListing_arr['finalArray'];
		$data['coins'] = $this->mod_coins->get_all_coins();
		//  Pagiantion code goes end here

		/*$coin = $this->session->userdata('global_symbol');
			$search_arr['coin'] = $coin;
			$this->mongo_db->where($search_arr);
			$this->mongo_db->limit(20);

			$this->mongo_db->order_by(array('created_date' => -1));
			$depth_responseArr = $this->mongo_db->get('barrier_values_collection');

			$arr = iterator_to_array($depth_responseArr);
			$data['barrier_arr'] = $arr;

		*/

		//echo "<pre>";   print_r($data['coins'] ); exit;

		$this->stencil->paint('admin/barrier/listing', $data);
	}

	public function edit_barrier() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		$search_arr['_id'] = $this->input->post('id');
		$this->mongo_db->where($search_arr);
		$depth_responseArr = $this->mongo_db->get('barrier_values_collection');
		$arr = iterator_to_array($depth_responseArr);
		$response = '';

		$response .= '
		<form class="form-horizontal" id="edit_form" method="POST" action="' . SURL . 'admin/reports/edit_barrier_action">
		  <div class="form-group">
		    <label class="control-label col-sm-2" for="barrier_val">Barrier Value:</label>
		    <div class="col-sm-10">
		      <input type="hidden" class="form-control" name="barrier_id" id="barrier_id" value="' . $arr[0]['_id'] . '">
		      <input type="text" class="form-control" name="barrier_val" id="barrier_val" value="' . num($arr[0]['barier_value']) . '">
		    </div>
		  </div>
		</form>';

		echo $response;
		exit;

	}

	public function edit_barrier_action() {
		$barrier_val = $this->input->post('barrier_val');
		$barrier_id = $this->input->post('barrier_id');

		$upd_arr = array('barier_value' => (float) $barrier_val);
		$this->mongo_db->where(array('_id' => $barrier_id));
		$this->mongo_db->set($upd_arr);
		$upd = $this->mongo_db->update('barrier_values_collection');
		if ($upd) {

			$this->session->set_flashdata('ok_message', 'Barrier Updated successfully.');
		} else {

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');

		} //end if
		redirect($_SERVER['HTTP_REFERER']);

	}

	public function add_barrier_action() {
		$coin_symbol = $this->input->post('coin_type');
		$created_date = date('Y-m-d H:i:s');
		$barrier_val = $this->input->post('barrier_val');
		$barrier_id = $this->input->post('barrier_type');

		$upd_arr = array('coin' => $coin_symbol, 'barier_value' => (float) $barrier_val, 'barrier_type' => $barrier_id, 'created_date' => $this->mongo_db->converToMongodttime($created_date), 'human_readible_created_date' => $created_date);
		$ins = $this->mongo_db->insert('barrier_values_collection', $upd_arr);
		if ($ins) {

			$this->session->set_flashdata('ok_message', 'Barrier Inserted successfully.');
		} else {

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');

		} //end if
		redirect($_SERVER['HTTP_REFERER']);

	}

	public function delete_barrier($id) {

		$this->mongo_db->where(array('_id' => $this->mongo_db->mongoId($id)));
		$del = $this->mongo_db->delete('barrier_values_collection');
		$this->mongo_db->where(array('barrier_id' => $this->mongo_db->mongoId($id)));
		$del2 = $this->mongo_db->delete('barrier_test_collection');
		if ($del) {

			$this->session->set_flashdata('ok_message', 'Barrier Deleted successfully.');
		} else {

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');

		} //end if
		redirect($_SERVER['HTTP_REFERER']);

	}

	public function show_barrier($barrier_id = '') {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		$this->mongo_db->where(array('barrier_id' => $this->mongo_db->mongoId($barrier_id)));
		$del = $this->mongo_db->get('barrier_test_collection');

		$ret_arr = iterator_to_array($del);

		foreach ($ret_arr as $key => $value) {
			$returArr['barrier_value'] = num($value['barrier_value']);
			$returArr['barrier_type'] = $value['barrier_type'];
			$returArr['barrier_creation_time'] = $value['barrier_creation_time'];
			$returArr['barrier_quantity'] = number_format_short($value['barrier_quantity']);
			$returArr['market_value_time'] = $value['market_value_time'];
			$returArr['black_wall_pressure'] = $value['black_wall_pressure'];
			$returArr['yellow_wall_pressure'] = $value['yellow_wall_pressure'];
			$returArr['depth_pressure'] = $value['depth_pressure'];
			$returArr['bid_contracts'] = number_format_short($value['bid_contracts']);
			$returArr['bid_percentage'] = $value['bid_percentage'];
			$returArr['ask_contract'] = number_format_short($value['ask_contract']);
			$returArr['ask_percentage'] = $value['ask_percentage'];
			if ($value['updated_profit'] == null || $value['updated_loss'] == null) {
				$returArr['profit'] = 0;
				$returArr['loss'] = 0;
			} else {
				$returArr['profit'] = $value['updated_profit'];
				$returArr['loss'] = $value['updated_loss'];
			}
			$returArr['great_wall_quantity'] = number_format_short($value['great_wall_quantity']);
			$returArr['great_wall'] = $value['great_wall'];
			$returArr['seven_level_depth'] = $value['seven_level_depth'];

			$returArr['score'] = $value['score'];
			$returArr['last_qty_buy_vs_sell'] = $value['last_qty_buy_vs_sell'];
			$returArr['last_qty_time_ago'] = (int) filter_var($value['last_qty_time_ago'], FILTER_SANITIZE_NUMBER_INT);
			//..(int) filter_var($str, FILTER_SANITIZE_NUMBER_INT)

			$returArr['last_200_buy_vs_sell'] = $value['last_200_buy_vs_sell'];
			$returArr['last_200_time_ago'] = (int) filter_var($value['last_200_time_ago'], FILTER_SANITIZE_NUMBER_INT);
		}
		$data['down_indicators'] = $returArr;

		$this->stencil->paint('admin/barrier/listing_indicator', $data);

	}

	public function indicator_listing() {
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
		/*					Calculate Up/Down Percentage								*/
		//////////////////////////////////////////////////////////////////////////////////
		/*		$search_arr3['coin'] = $coin_symbol;
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

}