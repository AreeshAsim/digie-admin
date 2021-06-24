<?php

/**

 *

 */

class Candle_day extends CI_Controller {

	function __construct() {

		parent::__construct();

		//load main template

		$this->stencil->layout('admin_layout');

		//load required slices

		$this->stencil->slice('admin_header_script');

		$this->stencil->slice('admin_header');

		$this->stencil->slice('admin_left_sidebar');

		$this->stencil->slice('admin_footer_script');

		// Load Modal

		$this->load->model('admin/mod_candle_chart_day');

		$this->load->model('admin/mod_login');

		$this->load->model('admin/mod_users');

		$this->load->model('admin/mod_dashboard');

		$this->load->model('admin/mod_coins');

		$this->load->model('admin/mod_candel');

		$this->load->model('admin/mod_sockets');

	}

	// public function index() {


	// 	/*echo $start_date_1  = '2018-10-08 00:00:00';
	// 	echo $end_date_1    = '2018-10-09 00:00:00';
	// 	$periods = '1d';
	// 	$global_symbol='NCASHBTC';
	// 	$dataArrSocial = $this->mod_candle_chart_day->getSentimentReportDay($type='', $source='twitter', $global_symbol, $start_date_1, $end_date_1, $formula, $periods);
	// 	echo "<pre>";    print_r($dataArrSocial); exit;*/



	// 	ini_set("memory_limit", -1);

	// 	$this->mod_login->verify_is_admin_login();

	// 	$global_symbol = $this->session->userdata('global_symbol');

	// 	$global_mode = $this->session->userdata('global_mode');

	// 	$admin_id = $this->session->userdata('admin_id');

	// 	$periods = '1d';

	// 	$order_data = $this->mod_candle_chart_day->get_order_array($global_symbol, $admin_id, $global_mode);

	// 	$candel_stick_arr = $this->mod_candle_chart_day->get_candelstick_data_from_database($global_symbol, $periods);

	// 	//echo "<pre>";  print_r($candel_stick_arr); exit;

	// 	if (count($candel_stick_arr) > 0) {

	// 		$start_date_for_time_zone = $candel_stick_arr[0]['openTime'];

	// 		$end_date_for_time_zone = $candel_stick_arr[count($candel_stick_arr) - 1]['openTime'];

	// 	}

	// 	//Call function to get task Manager setting

	// 	$task_manager_setting_arr = $this->mod_candle_chart_day->get_task_manager_setting($global_symbol);


	// 	//echo "<pre>";  print_r($task_manager_setting_arr); exit;




	// 	$data['task_manager_setting_arr'] = $task_manager_setting_arr;

	// 	$coin_unit_val = $this->mod_coins->get_coin_unit_value($global_symbol);

	// 	//$candel_stick_arr = $this->binance_api->get_candelstick($global_symbol,$periods);

	// 	$draw_target_zone_arr = $this->mod_candle_chart_day->get_chart_target_zones($global_symbol);

	// 	$draw_target_zone_arr_full = array();

	// 	/***Check if target zone Exist***/

	// 	if (count($draw_target_zone_arr) > 0) {

	// 		foreach ($draw_target_zone_arr as $target_zone_value) {

	// 			$start_date_second = $start_date_for_time_zone / 1000;

	// 			$end_date_second = $end_date_for_time_zone / 1000;

	// 			$unit_value = $coin_unit_val;

	// 			$start_date = date("Y-m-d H:i:00", $start_date_second);

	// 			$end_date = date("Y-m-d H:i:59", $end_date_second);

	// 			$get_market_history_for_candel = $this->mod_candle_chart_day->get_candle_price_volume_detail($global_symbol, $start_date, $end_date, $unit_value);

	// 			$target_zone_value['draw_target_zone'] = $get_market_history_for_candel;

	// 			array_push($draw_target_zone_arr_full, $target_zone_value);

	// 		}

	// 	}/** End of for each **/

	// 	$from_date_for_candel = $candel_stick_arr[0]['openTime'];

	// 	$end_date_for_candel = $candel_stick_arr[count($candel_stick_arr) - 1]['openTime'];

	// 	$from_date_for_candel_second = $from_date_for_candel / 1000;

	// 	$end_date_for_candel_second = $end_date_for_candel / 1000;

	// 	$from_date_for_candel = date("Y-m-d H:i:00", $from_date_for_candel_second);

	// 	$end_date_for_candel = date("Y-m-d H:i:59", $end_date_for_candel_second);

	// 	$all_candle_volume_detail = $this->mod_candle_chart_day->get_candle_price_volume_detail($global_symbol, $from_date_for_candel, $end_date_for_candel, $unit_value = 0);

	// 	$all_Hour_candle_volume_detail = $this->mod_candle_chart_day->get_hour_volume_array_detail($global_symbol, $from_date_for_candel, $end_date_for_candel);

	// 	$bid_hour_arr_volume = $all_Hour_candle_volume_detail['bid_hour_arr_volume'];

	// 	$ask_hour_arr_volume = $all_Hour_candle_volume_detail['ask_hour_arr_volume'];

	// 	$max_volume_hourly = $all_Hour_candle_volume_detail['max_volume_hourly'];

	// 	$total_hour_volume_arr = $all_Hour_candle_volume_detail['total_hour_volume_arr'];

	// 	$candel_stick_arr_new = array();

	// 	foreach ($candel_stick_arr as $candel_stick_single_arr) {

	// 		$openTime_current_time_zone = $candel_stick_single_arr['openTime'];

	// 		$open_time_zone_time = $this->convert_time_zone($openTime_current_time_zone);

	// 		$candel_stick_single_arr['open_time_zone_time'] = $open_time_zone_time;

	// 		$openTime = $candel_stick_single_arr['openTime'] / 1000;

	// 		$start_date_1 = date("Y-m-d H:00:00", $openTime_current_time_zone / 1000);

	// 		$end_date_1 = date("Y-m-d H:00:00", strtotime('+1 day', $openTime_current_time_zone / 1000));

	// 		//$down_status = $this->mod_candle_chart_day->calculate_pressure_up_and_down($start_date_1, $end_date_1, $candel_stick_single_arr['coin'], $pressure_type = 'down');

	// 		//$up_status = $this->mod_candle_chart_day->calculate_pressure_up_and_down($start_date_1, $end_date_1, $candel_stick_single_arr['coin'], $pressure_type = 'up');

	// 		$calculate_up_down_wall = $this->mod_candle_chart_day->calculate_up_down_wall($candel_stick_single_arr['coin'], $start_date_1);

	// 		// By Ali 19 september Get sentiment Report Goes here
	// 		$dataArr = $this->mod_candle_chart_day->getSentimentReportDay($type='', $source='twitter', $global_symbol, $start_date_1, $end_date_1, $formula, $periods);
	// 		//$dataArrSocial = $this->mod_candle_chart_day->getSentimentReportSocialDay($type='', $source='reddit', $global_symbol, $start_date_1, $end_date_1, $formula, $periods);
	// 		//echo "<pre>";  print_r($dataArr);

	// 		$downstatus   =  $dataArr['t_pos_divide_t'];
	// 		$upstatus     =  $dataArr['t_neg_divide_t'];


	// 		$candel_stick_single_arr['down_status'] = 5*$downstatus;
	// 		$candel_stick_single_arr['up_status']   = 5*$upstatus;

	// 		$candel_stick_single_arr['down_status_social']   = $dataArrSocial['sum_positive'];
	// 		$candel_stick_single_arr['up_status_social']   = $dataArrSocial['sum_nageative'];



	// 		$ask_diff = $calculate_up_down_wall['ask_diff'];

	// 		$bid_diff = $calculate_up_down_wall['bid_diff'];

	// 		$candel_stick_single_arr['bid_diff'] = $bid_diff;

	// 		$candel_stick_single_arr['ask_diff'] = $ask_diff;

	// 	    // $candel_stick_single_arr['down_status'] = $down_status;

	// 		//$candel_stick_single_arr['up_status'] = $up_status;

	// 		$candel_stick_single_arr['ask_volume'] = $ask_hour_arr_volume[$openTime];

	// 		$candel_stick_single_arr['bid_volume'] = $bid_hour_arr_volume[$openTime];

	// 		$candel_stick_single_arr['total_volume'] = $total_hour_volume_arr[$openTime];

    //  		$candel_stick_single_arr['max_volume'] = $max_volume_hourly;

	// 		$candel_stick_single_arr['time_index'] = $openTime;

	// 		array_push($candel_stick_arr_new, $candel_stick_single_arr);

	// 	}


	//     //echo "<pre>";  print_r($candel_stick_arr_new); exit;





	// 	$data['all_candle_volume_detail'] = $all_candle_volume_detail;

	// 	$data['all_Hour_candle_volume_detail'] = $all_Hour_candle_volume_detail;

	// 	$data["compare_val"] = $resp;




	// 	$data["candlesdtickArrDay"] = $candel_stick_arr_new;

	// 	$data["candle_period"] = $periods;

	// 	$data["get_market_history_for_candel"] = $get_market_history_for_candel;

	// 	$data["draw_target_zone_arr"] = $draw_target_zone_arr_full;

	// 	$ask_volume_arr = $get_market_history_for_candel['ask_arr_volume'];

	// 	$bid_volume_arr = $get_market_history_for_candel['bid_arr_volume'];

	// 	$total_volume_arr = $get_market_history_for_candel['total_volume_arr'];

	// 	$max_volume = $get_market_history_for_candel['max_volume'];

	// 	$unit_value = $get_market_history_for_candel['unit_value'];

	// 	$max_volumer = $max_volume;

	// 	$data["ask_volume_arr"] = $ask_volume_arr;

	// 	$data["bid_volume_arr"] = $bid_volume_arr;

	// 	$data["total_volume_arr"] = $total_volume_arr;

	// 	$data["max_volumer"] = $max_volumer;

	// 	$data["unit_value"] = $unit_value;

	// 	$data['order_data'] = $order_data;

	// 	$this->stencil->paint('admin/candle_stick/candlesdtick_dyamic_7_day', $data);

	// }

	// public function autoload_candle_stick_data_from_database_ajax() {

	// 	$this->mod_login->verify_is_admin_login();

	// 	$global_symbol = $this->session->userdata('global_symbol');

	// 	$admin_id = $this->session->userdata('admin_id');

	// 	$global_mode = $this->session->userdata('global_mode');

	// 	$order_data = $this->mod_candle_chart_day->get_order_array($global_symbol, $admin_id, $global_mode);

	// 	$periods = '1d';

	// 	$from_date_object = '';

	// 	$to_date_object = '';

	// 	$previous_date = '';

	// 	if ($this->input->post('previous_date')) {

	// 		$previous_date = $this->input->post('previous_date');

	// 	}

	// 	$forward_date = '';

	// 	if ($this->input->post('forward_date')) {

	// 		$forward_date = $this->input->post('forward_date');

	// 	}

	// 	$candel_stick_arr = $this->mod_candle_chart_day->get_candelstick_data_from_database($global_symbol, $periods, $from_date_object, $to_date_object, $previous_date, $forward_date);

	// 	if (count($candel_stick_arr) > 0) {

	// 		$start_date_for_time_zone = $candel_stick_arr[0]['openTime'];

	// 		$end_date_for_time_zone = $candel_stick_arr[count($candel_stick_arr) - 1]['openTime'];

	// 	}

	// 	$coin_unit_val = $this->mod_coins->get_coin_unit_value($global_symbol);

	// 	//$candel_stick_arr = $this->binance_api->get_candelstick($global_symbol,$periods);

	// 	$draw_target_zone_arr = $this->mod_candle_chart_day->get_chart_target_zones($global_symbol);

	// 	$draw_target_zone_arr_full = array();

	// 	/***Check if target zone Exist***/

	// 	if (count($draw_target_zone_arr) > 0) {

	// 		foreach ($draw_target_zone_arr as $target_zone_value) {

	// 			$start_date_second = $start_date_for_time_zone / 1000;

	// 			$end_date_second = $end_date_for_time_zone / 1000;

	// 			$unit_value = $coin_unit_val;

	// 			$start_date = date("Y-m-d H:00:00", $start_date_second);

	// 			$end_date = date("Y-m-d H:59:59", $end_date_second);

	// 			$get_market_history_for_candel = $this->mod_candle_chart_day->get_candle_price_volume_detail($global_symbol, $start_date, $end_date, $unit_value);

	// 			$target_zone_value['draw_target_zone'] = $get_market_history_for_candel;

	// 			array_push($draw_target_zone_arr_full, $target_zone_value);

	// 		}

	// 	}/** End of for each **/

	// 	$from_date_for_candel = $candel_stick_arr[0]['openTime'];

	// 	$end_date_for_candel = $candel_stick_arr[count($candel_stick_arr) - 1]['openTime'];

	// 	$from_date_for_candel_second = $from_date_for_candel / 1000;

	// 	$end_date_for_candel_second = $end_date_for_candel / 1000;

	// 	$from_date_for_candel = date("Y-m-d H:00:00", $from_date_for_candel_second);

	// 	$end_date_for_candel = date("Y-m-d H:59:59", $end_date_for_candel_second);

	// 	$all_candle_volume_detail = $this->mod_candle_chart_day->get_candle_price_volume_detail($global_symbol, $from_date_for_candel, $end_date_for_candel, $unit_value = 0);

	// 	$all_Hour_candle_volume_detail = $this->mod_candle_chart_day->get_hour_volume_array_detail($global_symbol, $from_date_for_candel, $end_date_for_candel);

	// 	$bid_hour_arr_volume = $all_Hour_candle_volume_detail['bid_hour_arr_volume'];

	// 	$ask_hour_arr_volume = $all_Hour_candle_volume_detail['ask_hour_arr_volume'];

	// 	$max_volume_hourly = $all_Hour_candle_volume_detail['max_volume_hourly'];

	// 	$total_hour_volume_arr = $all_Hour_candle_volume_detail['total_hour_volume_arr'];

	// 	$candel_stick_arr_new = array();

	// 	foreach ($candel_stick_arr as $candel_stick_single_arr) {

	// 		$openTime_current_time_zone = $candel_stick_single_arr['openTime'];

	// 		$open_time_zone_time = $this->convert_time_zone($openTime_current_time_zone);

	// 		$candel_stick_single_arr['open_time_zone_time'] = $open_time_zone_time;

	// 		$openTime = $candel_stick_single_arr['openTime'] / 1000;

	// 		$start_date_1 = date("Y-m-d H:00:00", $openTime_current_time_zone / 1000);

	// 		$end_date_1 = date("Y-m-d H:00:00", strtotime('+1 day', $openTime_current_time_zone / 1000));

	// 		$down_status = $this->mod_candle_chart_day->calculate_pressure_up_and_down($start_date_1, $end_date_1, $candel_stick_single_arr['coin'], $pressure_type = 'down');

	// 		$up_status = $this->mod_candle_chart_day->calculate_pressure_up_and_down($start_date_1, $end_date_1, $candel_stick_single_arr['coin'], $pressure_type = 'up');

	// 		$calculate_up_down_wall = $this->mod_candle_chart_day->calculate_up_down_wall($candel_stick_single_arr['coin'], $start_date_1);


	// 		$dataArr = $this->mod_candle_chart_day->getSentimentReportDay($type='', $source='twitter', $global_symbol, $start_date_1, $end_date_1, $formula, $periods);
	// 		$dataArrSocial = $this->mod_candle_chart_day->getSentimentReportSocialDay($type='', $source='reddit', $global_symbol, $start_date_1, $end_date_1, $formula, $periods);

	// 		$candel_stick_single_arr['down_status'] = $dataArr['sum_positive'];
	// 		$candel_stick_single_arr['up_status']   = $dataArr['sum_nageative'];

	// 		$candel_stick_single_arr['down_status_social']   = $dataArrSocial['sum_positive'];
	// 		$candel_stick_single_arr['up_status_social']   = $dataArrSocial['sum_nageative'];






	// 		$ask_diff = $calculate_up_down_wall['ask_diff'];

	// 		$bid_diff = $calculate_up_down_wall['bid_diff'];

	// 		$candel_stick_single_arr['bid_diff'] = $bid_diff;

	// 		$candel_stick_single_arr['ask_diff'] = $ask_diff;

	// 		//$candel_stick_single_arr['down_status'] = $down_status;

	// 		//$candel_stick_single_arr['up_status'] = $up_status;

	// 		$candel_stick_single_arr['ask_volume'] = $ask_hour_arr_volume[$openTime];

	// 		$candel_stick_single_arr['bid_volume'] = $bid_hour_arr_volume[$openTime];

	// 		$candel_stick_single_arr['total_volume'] = $total_hour_volume_arr[$openTime];

	// 		$candel_stick_single_arr['max_volume'] = $max_volume_hourly;

	// 		$candel_stick_single_arr['time_index'] = $openTime;

	// 		array_push($candel_stick_arr_new, $candel_stick_single_arr);

	// 	}

	// 	$data['all_candle_volume_detail'] = $all_candle_volume_detail;

	// 	$data['all_Hour_candle_volume_detail'] = $all_Hour_candle_volume_detail;

	// 	$data["compare_val"] = $resp;

	// 	$data["candlesdtickArr"] = $candel_stick_arr_new;

	// 	$data["candle_period"] = $periods;

	// 	$data["get_market_history_for_candel"] = $get_market_history_for_candel;

	// 	$data["draw_target_zone_arr"] = $draw_target_zone_arr_full;

	// 	$ask_volume_arr = $get_market_history_for_candel['ask_arr_volume'];

	// 	$bid_volume_arr = $get_market_history_for_candel['bid_arr_volume'];

	// 	$total_volume_arr = $get_market_history_for_candel['total_volume_arr'];

	// 	$max_volume = $get_market_history_for_candel['max_volume'];

	// 	$unit_value = $get_market_history_for_candel['unit_value'];

	// 	$max_volumer = $max_volume;

	// 	$data["ask_volume_arr"] = $ask_volume_arr;

	// 	$data["bid_volume_arr"] = $bid_volume_arr;

	// 	$data["total_volume_arr"] = $total_volume_arr;

	// 	$data["max_volumer"] = $max_volumer;

	// 	$data["unit_value"] = $unit_value;

	// 	$data['order_data'] = $order_data;

	// 	echo json_encode($data);

	// }/** End of autoload_candle_stick_data_from_database_ajax**/

	// public function delete_data_from_data_base() {

	// 	$this->mod_login->verify_is_admin_login();

	// 	$this->mod_candle_chart_day->delete_data_from_data_base();

	// } //End of delete_data_from_data_base

	// public function save_candel_ajax() {

	// 	$this->mod_login->verify_is_admin_login();

	// 	$global_symbol = $this->session->userdata('global_symbol');

	// 	$data = json_decode(stripslashes($this->input->post('cande_status_and_type_stringify')));

	// 	echo $update_candels = $this->mod_candle_chart_day->update_candel_for_formul_values($data, $global_symbol);

	// 	exit();

	// } //End of save_candel_ajax

	// public function combine_api_and_current_historical_data() {

	// 	exit('remove to continue');

	// 	$this->mod_login->verify_is_admin_login();

	// 	ini_set('memory_limit', '1000M');

	// 	$removeTime = date('Y-m-d G:i:s', strtotime('-1 hour', strtotime(date("Y-m-d G:i:s"))));

	// 	$orig_date = new DateTime($removeTime);

	// 	$orig_date = $orig_date->getTimestamp();

	// 	$created_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

	// 	$db = $this->mongo_db->customQuery();

	// 	//2018-05-22 14:00:00

	// 	$start_date = '2018-05-01 00:00:00';

	// 	$start_date = date("Y-m-d H:00:00", strtotime($start_date));

	// 	$start_date_mongo = $this->mongo_db->converToMongodttime($start_date);

	// 	$end_date = '2018-05-30 23:00:00';

	// 	$end_date = date("Y-m-d H:59:59", strtotime($end_date));

	// 	$end_date_mongo = $this->mongo_db->converToMongodttime($end_date);

	// 	//$this->mongo_db->limit(10);

	// 	$this->mongo_db->where_gte('timestamp', $start_date_mongo);

	// 	$this->mongo_db->where_lte('timestamp', $end_date_mongo);

	// 	$this->mongo_db->where('coin', 'ZECBTC');

	// 	$res = $this->mongo_db->get('market_trade_hourly_history_for_api_collection');

	// 	// $this->mongo_db->limit(5);

	// 	// $res = $this->mongo_db->get('market_trade_hourly_history_for_api_collection');

	// 	$result = iterator_to_array($res);

	// 	$new_arr = array();

	// 	foreach ($result as $data) {

	// 		unset($data['_id']);

	// 		$new_arr[] = (array) $data;

	// 	}

	// 	$rst = $this->mongo_db->batch_insert('market_trade_hourly_history', $new_arr);

	// 	echo '<pre>';

	// 	print_r($rst);

	// 	exit();

	// 	//////////////////////////////////////////////////////////////

	// } //End  of combine_api_and_current_historical_data

	// public function save_task_manager_setting_ajax() {

	// 	$this->mod_login->verify_is_admin_login();

	// 	$global_symbol = $this->session->userdata('global_symbol');

	// 	$this->mod_candle_chart_day->save_task_manager_setting($this->input->post(), $global_symbol);

	// } //End Of save_task_manager_setting_ajax

	// public function convert_time_zone($mil) {

	// 	$seconds = $mil / 1000;

	// 	$datetime = date("Y-m-d g:i:s A", $seconds);

	// 	$timezone = $this->session->userdata('timezone');

	// 	$date = date_create($datetime);

	// 	date_timezone_set($date, timezone_open($timezone));

	// 	return date_format($date, 'Y-m-d g:i:s A');

	// } //End of convert_time_zone

	// public function test() {

	// 	/*$date = '2018-05-31 08:00:00';

	// 		$second = strtotime($date);

	// 		$coin = 'NCASHBTC';

	// 		$first_second = $second;

	// 		for ($i = 0; $i < 1000; $i++) {

	// 			$last_second = $first_second + 900;

	// 			$search_array['time'] = array('$gte' => $first_second, '$lte' => $last_second, '$ne' => NULL);

	// 			$this->mongo_db->where($search_array);

	// 			$responseArr = $this->mongo_db->get('market_history_data_from_api_ncash');

	// 			$sum_bid_quantity = 0;

	// 			$sum_ask_quantity = 0;

	// 			foreach ($responseArr as $key => $value) {

	// 				$price = $value['price'];

	// 				$quantity = $value['quantity'];

	// 				if ($value['maker'] == 'true') {

	// 					$sum_bid_quantity += $quantity;

	// 				} elseif ($value['maker'] == 'false') {

	// 					$sum_ask_quantity += $quantity;

	// 				}

	// 			}

	// 			//insert into array

	// 			$ins_arr = array(

	// 				'time' => $first_second,

	// 				'coin' => $coin,

	// 				'bid_quantity' => $sum_bid_quantity,

	// 				'ask_quantity' => $sum_ask_quantity,

	// 			);

	// 			$this->mongo_db->insert('fifteen_min_market_history', $ins_arr);

	// 			$first_second = $last_second;

	// 		}

	// 		echo "<pre>";

	// 		$this->mongo_db->limit(1);

	// 		$this->mongo_db->order_by(array('_id' => -1));

	// 		$responseArr222 = $this->mongo_db->get('fifteen_min_market_history');

	// 		print_r(iterator_to_array($responseArr222));

	// 	*/

	// 	/*$this->mongo_db->order_by(array('_id' => -1));

	// 		$responseArr = $this->mongo_db->get('fifteen_min_market_history');

	// 		foreach ($responseArr as $key => $value) {

	// 			$maker = $value['maker'];

	// 			$id = $value['_id'];

	// 			$bid_quantity = $value['bid_quantity'];

	// 			$ask_quantity = $value['ask_quantity'];

	// 			$upd_arr['bid_quantity'] = $ask_quantity;

	// 			$upd_arr['ask_quantity'] = $bid_quantity;

	// 			$this->mongo_db->where(array('_id' => $id));

	// 			$this->mongo_db->set($upd_arr);

	// 			$this->mongo_db->update('fifteen_min_market_history');

	// 			echo 'Updated Record';

	// 			echo "<br>";

	// 	*/

	// 	//echo "Hello Hi By Bye";

	// 	/*$coin_symbol = "NCASHBTC";

	// 		$periods = "15m";

	// 		$chart = $this->binance_api->get_candelstick($coin_symbol, $periods);

	// 		echo "<pre>";

	// 		print_r($chart);

	// 	*/

	// 	echo "<pre>";

	// 	$this->mongo_db->where(array('coin' => 'NCASHBTC'));

	// 	$this->mongo_db->sort(array('_id' => 1));

	// 	$responseArr222 = $this->mongo_db->get('market_trade_quarterly_history');

	// 	/*	foreach ($responseArr222 as $key => $value) {

	// 			$id = $value['_id'];

	// 			$time = $value['time'];

	// 			$date = date('Y-m-d G:i:00', $time);

	// 			$new_time = strtotime($date);

	// 			$upd_arr['time'] = $new_time;

	// 			$this->mongo_db->where(array('_id' => $id));

	// 			$this->mongo_db->set($upd_arr);

	// 			$this->mongo_db->update('fifteen_min_market_history');

	// 			echo "Updated => " . $date . "<br>";}

	// 			*/

	// 	print_r(iterator_to_array($responseArr222));

	// 	exit;

	// }

	// public function save_candles_daiylbase() {

	// 	$all_coins_arr = $this->mod_sockets->get_all_coins();

	// 	$periods = '1d';

	// 	foreach ($all_coins_arr as $key => $coin) {

	// 		$coin_symbol = $coin['symbol'];

	// 		$candle_data = $this->binance_api->get_candelstick($coin_symbol, $periods);

	// 		if (count($candle_data) > 0) {

	// 			foreach ($candle_data as $key => $value) {

	// 				$created_datetime = date('Y-m-d H:i:s');

	// 				$orig_date = new DateTime($created_datetime);

	// 				$orig_date = $orig_date->getTimestamp();

	// 				$created_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

	// 				$seconds = ($value['openTime']) / 1000;

	// 				$datetime = date("Y-m-d H:i:s", $seconds);

	// 				$openTime_human_readible = $datetime;

	// 				$seconds_close = ($value['openTime'] / 1000) + 899;

	// 				$datetime_close = date("Y-m-d H:i:s", $seconds_close);

	// 				$closeTime = strtotime($datetime_close) * 1000;

	// 				$openTime = $value['openTime'];

	// 				$closeTime_human_readible = $datetime_close;

	// 				$orig_date22 = new DateTime($datetime);

	// 				$orig_date22 = $orig_date22->getTimestamp();

	// 				$timestampDate = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);

	// 				$date_for_candel = date('Y-m-d H:i:00', strtotime('-1 day'));

	// 				//////////////////////////////////////////////////////////////////////////////////////////

	// 				/// ASK AND BID VOLUME IN CANDLE SAVE ///

	// 				//////////////////////////////////////////////////////////////////////////////////////////

	// 				$volume_arr = $this->get_bid_ask_volume($openTime, $closeTime, $coin_symbol);

	// 				$bid_quantity = 0;

	// 				$ask_quantity = 0;

	// 				foreach ($volume_arr as $key => $volume) {

	// 					$bid_quantity += $volume['bid_quantity'];

	// 					$ask_quantity += $volume['ask_quantity'];

	// 				}

	// 				$total_volume = $bid_quantity + $ask_quantity;

	// 				$time = $openTime / 1000;

	// 				$rejection = $this->calculate_rejection_candle($coin_symbol, $time);

	// 				$response_detail = $this->calculate_swing_poinst($coin_symbol, $value['high'], $value['low'], $date_for_candel);

	// 				/*//update Candel Three Hour Back

	// 					$four_day_back = date('Y-m-d H:00:00', strtotime('-4 hour'));

	// 				*/

	// 				extract($response_detail);


	// 				//echo "<pre>";  print_r($response_detail);   exit;




	// 				$base_candel_arr = $this->calculate_base_candel($coin_symbol, $demand_percentage, $supply_percentage);

	// 				$DemandTrigger = $base_candel_arr['demond_max_volume'];

	// 				$SupplyTrigger = $base_candel_arr['supply_max_volume'];

	// 				$demand_base_candel = $DemandTrigger;

	// 				$supply_base_candel = $SupplyTrigger;

	// 				// $DemandTrigger = ($base_candel/100)*$demand_percentage;

	// 				// $SupplyTrigger = ($base_candel/100)*$supply_percentage;

	// 				$DemandCandle = ($ask_quantity > $bid_quantity && $ask_quantity >= $DemandTrigger) ? 1 : 0;

	// 				$SupplyCandle = ($bid_quantity > $ask_quantity && $bid_quantity >= $SupplyTrigger) ? 1 : 0;

	// 				$candle_type = 'normal';

	// 				if ($DemandCandle == 1) {

	// 					$candle_type = 'demand';

	// 				}

	// 				if ($SupplyCandle == 1) {

	// 					$candle_type = 'supply';

	// 				}

	// 				//////////////////////////////////////////////////////////////////////////////////////////

	// 				/// ASK AND BID VOLUME IN CANDLE SAVE ///

	// 				//////////////////////////////////////////////////////////////////////////////////////////

	// 				$insert22 = array(

	// 					'open' => $value['open'],

	// 					'high' => $value['high'],

	// 					'low' => $value['low'],

	// 					'close' => $value['close'],

	// 					'volume' => $value['volume'],

	// 					'openTime' => $openTime,

	// 					'closeTime' => $closeTime,

	// 					'coin' => $coin_symbol,

	// 					'created_date' => $created_date,

	// 					'timestampDate' => $timestampDate,

	// 					'periods' => $periods,

	// 					'openTime_human_readible' => $openTime_human_readible,

	// 					'closeTime_human_readible' => $closeTime_human_readible,

	// 					'human_readible_dateTime' => date('Y-m-d G:i:s'),

	// 					'candel_status' => $candel_status,

	// 					'candle_type' => $candle_type,

	// 					'ask_volume' => $ask_quantity,

	// 					'bid_volume' => $bid_quantity,

	// 					'total_volume' => $total_volume,

	// 					'demand_base_candel' => $demand_base_candel,

	// 					'supply_base_candel' => $supply_base_candel,

	// 					'trigger_status' => 0,

	// 					'triggert_type' => '',

	// 					'highest_swing_point' => $highest_swing_point,

	// 					'lowest_swing_point' => $lowest_swing_point,

	// 					'candel_highest_swing_status' => $candel_highest_swing_status,

	// 					'candel_lowest_swing_status' => $candel_lowest_swing_status,

	// 					'global_swing_status' => $global_swing_status,

	// 					'global_swing_parent_status' => $global_swing_parent_status,

	// 					'rejected_candle' => $rejection,

	// 				);

	// 				$check_candle_data = $this->check_candle_stick_data_if_exist($coin_symbol, $periods, $openTime);

	// 				//var_dump($check_candle_data);exit;

	// 				if ($check_candle_data) {

	// 					$this->mongo_db->insert('market_chart_dailybase', $insert22);

	// 					echo 'insert' . '<br>';

	// 				} else {

	// 					$if_current_cand = $this->check_if_current_candle($periods, $value['openTime']);

	// 					if ($if_current_cand) {

	// 						$this->candle_update($coin_symbol, $periods, $value['openTime'], $insert22);

	// 						echo 'update' . '<br>';

	// 					}

	// 				}

	// 			}

	// 		}

	// 	}

	// }

	// public function check_candle_stick_data_if_exist($coin_symbol, $period, $openTime) {

	// 	$this->mongo_db->where(array('coin' => $coin_symbol, 'periods' => $period, 'openTime' => $openTime));

	// 	$responseArr = $this->mongo_db->get('market_chart_dailybase');

	// 	$exist = 0;

	// 	foreach ($responseArr as $key) {

	// 		$exist = 1;

	// 		break;

	// 	}

	// 	if ($exist == 1) {

	// 		return false;

	// 	} else {

	// 		return true;

	// 	}

	// }/** End of check_candle_stick_data_if_exist***/

	// public function candle_update($coin_symbol, $period, $openTime, $insert22) {

	// 	$this->mongo_db->where(array('coin' => $coin_symbol, 'periods' => $period, 'openTime' => $openTime));

	// 	$this->mongo_db->set($insert22);

	// 	$this->mongo_db->update('market_chart_dailybase');

	// }/** candle_update***/

	// public function check_if_current_candle($periods, $openTime) {

	// 	list($alpha, $numeric) = sscanf($periods, "%[A-Z]%d");

	// 	switch ($alpha) {

	// 	case "h":

	// 		$response_period = ($numeric * 3600) * 2;

	// 		break;

	// 	case "m":

	// 		$response_period = ($numeric * 60) * 2;

	// 		break;

	// 	default:

	// 		$response_period = 1 * 2;

	// 	}

	// 	$seconds = $openTime / 1000;

	// 	$datetime = date("Y-m-d H:i:s", $seconds);

	// 	$seconds_2 = $seconds - $response_period;

	// 	$datetime_2 = date("Y-m-d H:i:s", $seconds_2);

	// 	if ($datetime_2 < $datetime) {

	// 		return true;

	// 	} else {

	// 		return false;

	// 	}

	// } /*** End of check_if_current_candle**/

	// public function get_market_trade_quarterly_history() {

	// 	$all_coins_arr = $this->mod_sockets->get_all_coins();

	// 	foreach ($all_coins_arr as $key => $coin) {

	// 		$coin_symbol = $coin['symbol'];


	// 		$datetime = date('Y-m-d G:i:00', strtotime('- 1 day'));

	// 		$mongodTime = $this->mongo_db->converToMongodttime($datetime);

	// 		$search_array = array(

	// 			'coin' => $coin_symbol,

	// 			'created_date' => array('$gte' => $mongodTime),

	// 		);

	// 		$this->mongo_db->where($search_array);

	// 		$respArr = $this->mongo_db->get('market_trades');

	// 		$sum_bid_quantity = 0;

	// 		$sum_ask_quantity = 0;

	// 		foreach ($respArr as $key => $value) {

	// 			$quantity = $value['quantity'];

	// 			if ($value['maker'] == 'true') {

	// 				$sum_bid_quantity += $quantity;

	// 			} elseif ($value['maker'] == 'false') {

	// 				$sum_ask_quantity += $quantity;

	// 			}

	// 		}

	// 		//insert into array

	// 		$ins_arr = array(

	// 			'time' => strtotime($datetime),

	// 			'coin' => $coin_symbol,

	// 			'bid_quantity' => $sum_bid_quantity,

	// 			'ask_quantity' => $sum_ask_quantity,

	// 		);

	// 		$this->mongo_db->insert('market_chart_dailybase', $ins_arr);

	// 	}
	// 	$summary = "This cronjob Run for calculation of daily market_history";
	// 	$duration = "1 day";
	// 	track_execution_of_cronjob($duration,$summary);
	// }

	// public function get_bid_ask_volume($start_date, $end_date, $coin_symbol) {

	// 	$start_date = $start_date / 1000;

	// 	$end_date = $end_date / 1000;

	// 	$this->mongo_db->where(array('coin' => $coin_symbol, 'time' => array('$gte' => $start_date, '$lte' => $end_date)));

	// 	$this->mongo_db->sort(array('_id' => -1));

	// 	$responseArr222 = $this->mongo_db->get('market_chart_dailybase');

	// 	$ers = iterator_to_array($responseArr222);

	// 	return $ers;

	// }

	// public function update_candle_demand_supply() {

	// 	$this->mongo_db->where(array('coin' => 'NCASHBTC'));

	// 	$this->mongo_db->order_by(array("_id" => -1));

	// 	$get = $this->mongo_db->get('market_chart_dailybase');

	// 	foreach ($get as $key => $arr) {

	// 		$coin = $arr['coin'];

	// 		$openTime = $arr['openTime'];

	// 		$time = $openTime / 1000;

	// 		$candle_id = $arr['_id'];

	// 		$rejection = $this->calculate_rejection_candle($coin, $time);

	// 		$update_arr['rejected_candle'] = $rejection;

	// 		$this->mongo_db->where(array('_id' => $candle_id));

	// 		$this->mongo_db->set($update_arr);

	// 		$this->mongo_db->update('market_chart_dailybase');

	// 		echo $rejection;

	// 		echo "<br>";

	// 	}

	// }

	///////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////Rejection Candle //////////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////////////////////////////////

	// public function calculate_rejection_candle($coin, $time) {

	// 	//date_default_timezone_set("Asia/Karachi");

	// 	$new_time = date("Y-m-d H:i:00", $time);

	// 	$start_date = $new_time;

	// 	$end_date = date("Y-m-d H:i:00", strtotime('+15 minutes', strtotime($new_time)));

	// 	$data_array = $this->get_current_candel(($time * 1000), $coin);

	// 	$open = $data_array[0]['open'];

	// 	$close = $data_array[0]['close'];

	// 	$high = $data_array[0]['high'];

	// 	$low = $data_array[0]['low'];

	// 	$bid_volume = $data_array[0]['bid_volume'];

	// 	$ask_volume = $data_array[0]['ask_volume'];

	// 	$total_volume = $ask_volume + $bid_volume;

	// 	$rejected = 0;

	// 	$rejection = '';

	// 	$last_25_per_volume = $this->calculate_base_candel_for_rejection($coin, $start_date, $end_date);

	// 	if ($total_volume > $last_25_per_volume) {

	// 		if ($open < $close) {

	// 			$candle_type = 'Demand';

	// 			//Top Demand Rejection

	// 			$top_percentage = ((($high - $close) / ($close - $open)) * 100);

	// 			if ($top_percentage >= 40) {

	// 				$rejected = 1;

	// 			} else {

	// 				$rejected = 0;

	// 			}

	// 			//Bottom Demand Rejection

	// 			$bottom_percentage = ((($open - $low) / ($close - $open)) * 100);

	// 			if ($bottom_percentage >= 40) {

	// 				$rejected = 1;

	// 			} else {

	// 				if ($rejected == 0) {

	// 					$rejected = 0;

	// 				}

	// 			}

	// 			if (($top_percentage > $bottom_percentage) && $rejected == 1) {

	// 				$rejection = 'top_demand_rejection';

	// 			} elseif (($bottom_percentage > $top_percentage) && $rejected == 1) {

	// 				$rejection = "bottom_demand_rejection";

	// 			}

	// 		}

	// 		if ($open > $close) {

	// 			//Top Supply Rejection

	// 			$top_percentage = ((($high - $open) / ($open - $close)) * 100);

	// 			if ($top_percentage >= 40) {

	// 				$rejected = 1;

	// 			} else {

	// 				$rejected = 0;

	// 			}

	// 			//Bottom Supply Rejection

	// 			$bottom_percentage = ((($close - $low) / ($open - $close)) * 100);

	// 			if ($bottom_percentage >= 40) {

	// 				$rejected = 1;

	// 			} else {

	// 				if ($rejected == 0) {

	// 					$rejected = 0;

	// 				}

	// 			}

	// 			if (($top_percentage > $bottom_percentage) && $rejected == 1) {

	// 				$rejection = 'top_supply_rejection';

	// 			} elseif (($bottom_percentage > $top_percentage) && $rejected == 1) {

	// 				$rejection = "bottom_supply_rejection";

	// 			}

	// 		}

	// 		if ($open == $close) {

	// 			$candle_type = 'Normal';

	// 		}

	// 	}

	// 	return $rejection;

	// }

	// public function get_current_candel($curretn_date, $coin_symbol) {

	// 	$this->mongo_db->where(array('openTime' => $curretn_date, 'coin' => $coin_symbol));

	// 	$previouse_candel_result = $this->mongo_db->get('market_chart_dailybase');

	// 	return $previouse_candel_arr = iterator_to_array($previouse_candel_result);

	// } //End of get_current_candel

	// public function calculate_base_candel_for_rejection($coin_symbol, $started_date, $end_date) {

	// 	$total_volume = 0;

	// 	$volume_arr = array();

	// 	for ($index_date = 1; $index_date <= 168; $index_date++) {

	// 		$from_date_for_candel = date("Y-m-d H:i:00", strtotime('-' . ($index_date * 15) . ' minutes', strtotime($started_date)));

	// 		$end_date_for_candel = date("Y-m-d H:i:00", strtotime('-' . ($index_date * 15) . ' minutes', strtotime($started_date)));

	// 		$reject_per = $this->get_coin_rejection_value($coin_symbol);

	// 		$start_date = strtotime($from_date_for_candel) * 1000;

	// 		$end_date = strtotime($end_date_for_candel) * 1000;

	// 		$ask_volume = $this->get_bid_ask_volume($start_date, $end_date, $coin_symbol);

	// 		$volume_arr[] = ($ask_volume[0]['bid_quantity'] + $ask_volume[0]['ask_quantity']);

	// 	}

	// 	sort($volume_arr);

	// 	$greater_ask_volume = 0;

	// 	$demand_percentage_index = round((count($volume_arr) / 100) * $reject_per);

	// 	$demond_greater_ask_volume = $volume_arr[$demand_percentage_index];

	// 	return $demond_greater_ask_volume;

	// } //End of calculate_base_candel

	// public function get_coin_rejection_value($symbol) {

	// 	$this->db->dbprefix('coins');

	// 	$this->db->select('rejection');

	// 	$this->db->where('symbol', $symbol);

	// 	$get = $this->db->get('coins');

	// 	$get_arr = $get->row_array();

	// 	return $get_arr['rejection'];

	// } //end get_coin_rejection_value()

	///////////////////////////////////////////////////////////////////////////////////////////////////////////

	/////////////////////////////////////// End Rejection Candle //////////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////////////////////////////////

	// public function calculate_base_candel($coin_symbol, $demand_percentage, $supply_percentage) {

	// 	$total_volume = 0;

	// 	$volume_arr = array();

	// 	for ($index_date = 1; $index_date <= 168; $index_date++) {

	// 		$from_date_for_candel = date("Y-m-d H:i:00", strtotime('-' . ($index_date * 15) . ' minutes'));

	// 		$end_date_for_candel = date("Y-m-d H:i:00", strtotime('-' . ($index_date * 15) . ' minutes'));

	// 		$start_date = strtotime($from_date_for_candel) * 1000;

	// 		$end_date = strtotime($end_date_for_candel) * 1000;

	// 		$ask_volume = $this->get_bid_ask_volume($start_date, $end_date, $coin_symbol);

	// 		$bid_arr[] = $ask_volume[0]['bid_quantity'];

	// 		$ask_arr[] = $ask_volume[0]['ask_quantity'];

	// 		$volume_arr[] = ($ask_volume[0]['bid_quantity'] + $ask_volume[0]['ask_quantity']);

	// 	}

	// 	sort($bid_arr);

	// 	sort($ask_arr);

	// 	$greater_ask_volume = 0;

	// 	$demand_percentage_index = round((count($ask_arr) / 100) * $demand_percentage);

	// 	$demond_greater_ask_volume = $ask_arr[$demand_percentage_index];

	// 	$supply_percentage_index = round((count($bid_arr) / 100) * $supply_percentage);

	// 	$supply_greater_ask_volume = $bid_arr[$supply_percentage_index];

	// 	$response_arr['demond_max_volume'] = $demond_greater_ask_volume;

	// 	$response_arr['supply_max_volume'] = $supply_greater_ask_volume;

	// 	return $response_arr;

	// } //End of calculate_base_candel

	// public function calculate_swing_poinst($coin_symbol, $current_highest_point, $current_lowest_point, $date_for_candel) {

	// 	///////////////////////////////////////////////////////////////////////

	// 	///////////////Get Task Manager Setting Details //////////////////////

	// 	$task_manager_setting_obj = $this->mongo_db->get('task_manager_setting');

	// 	$task_manager_setting_arr = iterator_to_array($task_manager_setting_obj);

	// 	$number_of_look_back = 5;

	// 	$number_of_look_forward = 3;

	// 	$maxLvlLen = 0;

	// 	$ShowHHLL = 0;

	// 	$WaitForClose = 1;

	// 	$LH_Percentile = 10;

	// 	$LH_Percentile_supply = 10;

	// 	$Continuation_up_Percentile = 30;

	// 	$Continuation_up_Percentile_supply = 30;

	// 	$Current_up_Percentile = 25;

	// 	$Current_up_Percentile_supply = 25;

	// 	$HL_Percentile = 10;

	// 	$HL_Percentile_supply = 10;

	// 	$Continuation_Down_Percentile = 20;

	// 	$Continuation_Down_Percentile_supply = 20;

	// 	$Current_Down_Percentile = 25;

	// 	$Current_Down_Percentile_supply = 25;

	// 	if (count($task_manager_setting_arr) > 0) {

	// 		$number_of_look_back = $task_manager_setting_arr[0]['pvtLenL'];

	// 		$number_of_look_forward = $task_manager_setting_arr[0]['pvtLenR'];

	// 		$maxLvlLen = $task_manager_setting_arr[0]['maxLvlLen'];

	// 		$ShowHHLL = $task_manager_setting_arr[0]['ShowHHLL'];

	// 		$WaitForClose = $task_manager_setting_arr[0]['WaitForClose'];

	// 		$LH_Percentile = $task_manager_setting_arr[0]['LH_Percentile'];

	// 		$LH_Percentile_supply = $task_manager_setting_arr[0]['LH_Percentile_supply'];

	// 		$Continuation_up_Percentile = $task_manager_setting_arr[0]['Continuation_up_Percentile'];

	// 		$Continuation_up_Percentile_supply = $task_manager_setting_arr[0]['Continuation_up_Percentile_supply'];

	// 		$Current_up_Percentile = $task_manager_setting_arr[0]['Current_up_Percentile'];

	// 		$Current_up_Percentile_supply = $task_manager_setting_arr[0]['Current_up_Percentile_supply'];

	// 		$HL_Percentile = $task_manager_setting_arr[0]['HL_Percentile'];

	// 		$HL_Percentile_supply = $task_manager_setting_arr[0]['HL_Percentile_supply'];

	// 		$Continuation_Down_Percentile = $task_manager_setting_arr[0]['Continuation_Down_Percentile'];

	// 		$Continuation_Down_Percentile_supply = $task_manager_setting_arr[0]['Continuation_Down_Percentile_supply'];

	// 		$Current_Down_Percentile = $task_manager_setting_arr[0]['Current_Down_Percentile'];

	// 		$Current_Down_Percentile_supply = $task_manager_setting_arr[0]['Current_Down_Percentile_supply'];

	// 	}

	// 	///////////////End Task Manager Setting Details //////////////////////

	// 	/////////////////////////////////////////////////////////////////////

	// 	//////////////////////////////////////////////////////////////////

	// 	//////////////////Get Look Back Detail //////////////////////////

	// 	$number_of_look_forward = 0;

	// 	$current_swing_heighst_point = $this->find_swing_heighst_points($number_of_look_back, $number_of_look_forward, $date_for_candel, $coin_symbol);

	// 	// echo '<pre>';

	// 	// print_r($current_swing_heighst_point);

	// 	// exit();

	// 	$current_swing_lowest_point = $this->find_swing_lowest_points($number_of_look_back, $number_of_look_forward, $date_for_candel, $coin_symbol);

	// 	$prevouse_date = date('Y-m-d H:i:00', strtotime('-1 day', strtotime($date_for_candel)));

	// 	$this->mongo_db->limit(2);

	// 	$this->mongo_db->order_by(array('timestampDate' => -1));

	// 	$this->mongo_db->where_lte('timestampDate', $this->mongo_db->converToMongodttime($prevouse_date));

	// 	$this->mongo_db->where(array('coin' => $coin_symbol));

	// 	$response_detail = $this->mongo_db->get('market_chart_dailybase');

	// 	$market_chart_arr = iterator_to_array($response_detail);

	// 	$previous_highest_point = 0;

	// 	$previous_lowest_point = 0;

	// 	$previous_swing_high_status = '';

	// 	$second_last_high_swing_status = '';

	// 	$second_last_lowest_swing_status = '';

	// 	$previous_swing_lowest_status = '';

	// 	if (count($market_chart_arr) > 0) {

	// 		$previous_highest_point = $market_chart_arr[0]['highest_swing_point'];

	// 		$previous_lowest_point = $market_chart_arr[0]['lowest_swing_point'];

	// 		$candel_status = $market_chart_arr[0]['candel_status'];

	// 		$global_swing_status = $market_chart_arr[0]['global_swing_status'];

	// 		$second_last_high_swing_status = $market_chart_arr[1]['candel_highest_swing_status'];

	// 		$previous_swing_high_status = $market_chart_arr[0]['candel_highest_swing_status'];

	// 		$second_last_lowest_swing_status = $market_chart_arr[1]['candel_lowest_swing_status'];

	// 		$previous_swing_lowest_status = $market_chart_arr[0]['candel_lowest_swing_status'];

	// 	} //End of if

	// 	$demand_percentage = 90;

	// 	$supply_percentage = 90;

	// 	$candel_highest_swing_status = '';

	// 	$global_swing_parent_status = '';

	// 	if ($current_swing_heighst_point != '') {

	// 		if ($current_swing_heighst_point <= $previous_highest_point) {

	// 			$candel_status = 'normal';

	// 			$candel_highest_swing_status = 'LH';

	// 			$demand_percentage = $LH_Percentile;

	// 			$supply_percentage = $LH_Percentile_supply;

	// 			$global_swing_status = 'LH';

	// 			$global_swing_parent_status = 'LH';

	// 		} else {

	// 			$candel_highest_swing_status = 'HH';

	// 			$global_swing_status = 'HH';

	// 			$global_swing_parent_status = 'HH';

	// 			if ($previous_swing_high_status == 'HH' && $second_last_high_swing_status == 'HH') {

	// 				$demand_percentage = $Continuation_up_Percentile;

	// 				$supply_percentage = $Continuation_up_Percentile_supply;

	// 				$candel_status = 'Continuation_up';

	// 			} else {

	// 				$candel_status = 'Current_up';

	// 				$demand_percentage = $Current_up_Percentile;

	// 				$supply_percentage = $Current_up_Percentile_supply;

	// 			}

	// 		}

	// 	} else {

	// 		if ($candel_status == 'normal') {

	// 			$demand_percentage = $LH_Percentile;

	// 			$supply_percentage = $LH_Percentile_supply;

	// 		} else if ($candel_status == 'Continuation_up') {

	// 			$demand_percentage = $Continuation_up_Percentile;

	// 			$supply_percentage = $Continuation_up_Percentile_supply;

	// 		} else if ($candel_status == 'Current_up') {

	// 			$demand_percentage = $Current_up_Percentile;

	// 			$supply_percentage = $Current_up_Percentile_supply;

	// 		}

	// 		$current_highest_point = $previous_highest_point;

	// 		$candel_highest_swing_status = $candel_highest_swing_status;

	// 	}

	// 	if ($current_swing_lowest_point != '') {

	// 		if ($current_swing_lowest_point >= $previous_lowest_point) {

	// 			$candel_lowest_swing_status = 'HL';

	// 			$global_swing_parent_status = 'HL';

	// 			$global_swing_status = 'HL';

	// 			$demand_percentage = $HL_Percentile;

	// 			$supply_percentage = $HL_Percentile_supply;

	// 		} else {

	// 			$candel_lowest_swing_status = 'LL';

	// 			$global_swing_parent_status = 'LL';

	// 			$global_swing_status = 'LL';

	// 			if (($previous_swing_lowest_status == 'LL') && ($second_last_lowest_swing_status == 'LL')) {

	// 				$demand_percentage = $Continuation_Down_Percentile;

	// 				$supply_percentage = $Continuation_Down_Percentile_supply;

	// 				$candel_status = 'Continuation_Down';

	// 			} else {

	// 				$demand_percentage = $Current_Down_Percentile;

	// 				$supply_percentage = $Current_Down_Percentile_supply;

	// 				$candel_status = 'Current_Down';

	// 			}

	// 		}

	// 	} else {

	// 		if ($candel_status == 'normal') {

	// 			$demand_percentage = $HL_Percentile;

	// 			$supply_percentage = $HL_Percentile_supply;

	// 		} else if ($candel_status == 'Continuation_Down') {

	// 			$demand_percentage = $Continuation_Down_Percentile;

	// 			$supply_percentage = $Continuation_Down_Percentile_supply;

	// 		} else if ($candel_status == 'Current_Down') {

	// 			$demand_percentage = $Current_Down_Percentile;

	// 			$supply_percentage = $Current_Down_Percentile_supply;

	// 		}

	// 		$current_lowest_point = $previous_lowest_point;

	// 		$candel_lowest_swing_status = $previous_swing_lowest_status;

	// 	}

	// 	$return_arr = array();

	// 	$return_arr['candel_status'] = $candel_status;

	// 	$return_arr['highest_swing_point'] = $current_highest_point;

	// 	$return_arr['lowest_swing_point'] = $current_lowest_point;

	// 	$return_arr['candel_highest_swing_status'] = $candel_highest_swing_status;

	// 	$return_arr['candel_lowest_swing_status'] = $candel_lowest_swing_status;

	// 	$return_arr['demand_percentage'] = $demand_percentage;

	// 	$return_arr['supply_percentage'] = $supply_percentage;

	// 	$return_arr['global_swing_status'] = $global_swing_status;

	// 	$return_arr['global_swing_parent_status'] = $global_swing_parent_status;

	// 	return $return_arr;

	// } //End of calculate_swing_poinst

	// public function find_swing_heighst_points($number_of_look_back, $number_of_look_forward, $date_for_candel, $coin_symbol) {

	// 	$limit_no = $number_of_look_back + $number_of_look_forward + 1;

	// 	$prevouse_date = date('Y-m-d H:i:00', strtotime('-' . ($number_of_look_back * 15) . ' minutes', strtotime($date_for_candel)));

	// 	$this->mongo_db->limit($limit_no);

	// 	$this->mongo_db->order_by(array('timestampDate' => 1));

	// 	$this->mongo_db->where_gte('timestampDate', $this->mongo_db->converToMongodttime($prevouse_date));

	// 	$this->mongo_db->where(array('coin' => $coin_symbol));

	// 	$market_chart_object = $this->mongo_db->get('market_chart_dailybase');

	// 	$market_chart_arr = iterator_to_array($market_chart_object);

	// 	$current_heigh_value = '';

	// 	$look_forward_index = -1;

	// 	$heighs_pont_arr = array();

	// 	$look_forward_heigh_array = array();

	// 	$date_for_candel2 = $this->make_date_quarter($date_for_candel);

	// 	if (count($market_chart_arr) > 0) {

	// 		$index = 0;

	// 		foreach ($market_chart_arr as $chart_data) {

	// 			$current = 'no';

	// 			if ($chart_data['openTime_human_readible'] == $date_for_candel2) {

	// 				$current_heigh_value = $chart_data['high'];

	// 				unset($market_chart_arr[$index]);

	// 				$look_forward_index = $index;

	// 				$current = 'yes';

	// 			} else {

	// 				array_push($heighs_pont_arr, $chart_data['high']);

	// 			}

	// 			if (($look_forward_index != -1) && ($current == 'no')) {

	// 				array_push($look_forward_heigh_array, $chart_data['high']);

	// 			}

	// 			$index++;

	// 		}

	// 	}

	// 	$heighst_swing_point = max($heighs_pont_arr);

	// 	$look_forward_heigh = max($look_forward_heigh_array);

	// 	$response_value = '';

	// 	if ($current_heigh_value >= $heighst_swing_point) {

	// 		$response_value = $current_heigh_value;

	// 	}

	// 	return $response_value;

	// } //End of find_swing_heighst_points

	// public function find_swing_lowest_points($number_of_look_back, $number_of_look_forward, $date_for_candel, $coin_symbol) {

	// 	$limit_no = $number_of_look_back + $number_of_look_forward + 1;

	// 	$prevouse_date = date('Y-m-d H:i:00', strtotime('-' . ($number_of_look_back * 15) . ' minutes', strtotime($date_for_candel)));

	// 	$this->mongo_db->limit($limit_no);

	// 	$this->mongo_db->order_by(array('timestampDate' => 1));

	// 	$this->mongo_db->where_gte('timestampDate', $this->mongo_db->converToMongodttime($prevouse_date));

	// 	$this->mongo_db->where(array('coin' => $coin_symbol));

	// 	$market_chart_object = $this->mongo_db->get('market_chart_dailybase');

	// 	$market_chart_arr = iterator_to_array($market_chart_object);

	// 	$current_low_value = '';

	// 	$look_forward_index = -1;

	// 	$heighs_pont_arr = array();

	// 	$look_forward_heigh_array = array();

	// 	if (count($market_chart_arr) > 0) {

	// 		$index = 0;

	// 		$date_for_candel2 = $this->make_date_quarter($date_for_candel);

	// 		foreach ($market_chart_arr as $chart_data) {

	// 			$current = 'no';

	// 			if ($chart_data['openTime_human_readible'] == $date_for_candel2) {

	// 				$current_low_value = $chart_data['low'];

	// 				unset($market_chart_arr[$index]);

	// 				$look_forward_index = $index;

	// 				$current = 'yes';

	// 			} else {

	// 				array_push($heighs_pont_arr, $chart_data['low']);

	// 			}

	// 			if (($look_forward_index != -1) && ($current == 'no')) {

	// 				array_push($look_forward_heigh_array, $chart_data['low']);

	// 			}

	// 			$index++;

	// 		}

	// 	}

	// 	$lowest_swing_point = min($heighs_pont_arr);

	// 	$look_forward_heigh = min($look_forward_heigh_array);

	// 	$response_value = '';

	// 	if ($current_low_value <= $lowest_swing_point) {

	// 		$response_value = $current_low_value;

	// 	}

	// 	return $response_value;

	// } //End of Find_swing_lowest_points

	// public function make_date_quarter($date_q) {

	// 	$response_arr = [];

	// 	$date_quart = array('H:00:00' => 'H:14:59', 'H:15:00' => 'H:29:59', 'H:30:00' => 'H:44:59', 'H:45:00' => 'H:59:59');

	// 	$start_dt = '';

	// 	foreach ($date_quart as $start_date => $end_date) {

	// 		$start_second1 = (date("Y-m-d " . $start_date, strtotime($date_q)));

	// 		$end_second1 = (date("Y-m-d " . $end_date, strtotime($date_q)));

	// 		if ($date_q >= $start_second1 && $date_q <= $end_second1) {

	// 			$start_dt = (date("Y-m-d " . $start_date, strtotime($date_q)));

	// 		}

	// 	}

	// 	return $start_dt;

	// } //End of make_date_quarter

	// public function get_all_latest_candle() {

	// 	$this->mongo_db->where(array('coin' => 'NCASHBTC', 'openTime_human_readible' => array('$gte' => '2018-08-01 00:00:00')));

	// 	$this->mongo_db->order_by(array("openTime" => 1));

	// 	$this->mongo_db->limit(10);

	// 	$get = $this->mongo_db->get('market_chart_dailybase');

	// 	echo "<pre>";

	// 	print_r(iterator_to_array($get));

	// 	exit;

	// }

	// public function cronjoboDailyReport(){

	// 	$order_data = $this->mod_candle_chart_day->save_candle_stick_by_cron_job();
	// 	echo "<pre>";  print_r($order_data); exit;

	// }


	// public function real_time_market_socket() {

	// 	//Get All Coins

	// 	$all_coins_arr = $this->mod_sockets->get_all_coins();

	// 	$period_array = array('15m');

	// 	for ($i = 0; $i < count($all_coins_arr); $i++) {

	// 		$coin_symbol = $all_coins_arr[$i]['symbol'];

	// 		//Check socket Call

	// 		$check_socket_track = $this->mod_sockets->check_socket_track('market_chart2', $coin_symbol);

	// 		if ($check_socket_track == 'no') {

	// 			//Insert Socket Record

	// 			$created_date = date('Y-m-d G:i:s');

	// 			/*** Run Socket for period***/

	// 			foreach ($period_array as $periods) {

	// 				$api = $this->binance_api->get_master_api();

	// 				$api->chart([$coin_symbol], $periods, function ($api, $symbol, $chart) {

	// 					$periods = '15m';

	// 					if (count($chart) > 0) {

	// 						foreach ($chart as $key => $value) {

	// 							$created_datetime = date('Y-m-d G:i:s');

	// 							$orig_date = new DateTime($created_datetime);

	// 							$orig_date = $orig_date->getTimestamp();

	// 							$created_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

	// 							$seconds = $value['openTime'] / 1000;

	// 							$datetime = date("Y-m-d H:i:s", $seconds);

	// 							$openTime_human_readible = $datetime;

	// 							$seconds_close = $value['closeTime'] / 1000;

	// 							$datetime_close = date("Y-m-d H:i:s", $seconds_close);

	// 							$closeTime_human_readible = $datetime_close;

	// 							$orig_date22 = new DateTime($datetime);

	// 							$orig_date22 = $orig_date22->getTimestamp();

	// 							$timestampDate = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);

	// 							$insert22 = array(

	// 								'open' => $value['open'],

	// 								'high' => $value['high'],

	// 								'low' => $value['low'],

	// 								'close' => $value['close'],

	// 								'volume' => $value['volume'],

	// 								'openTime' => $value['openTime'],

	// 								'closeTime' => $value['closeTime'],

	// 								'coin' => $symbol,

	// 								'created_date' => $created_date,

	// 								'timestampDate' => $timestampDate,

	// 								'periods' => $periods,

	// 								'openTime_human_readible' => $openTime_human_readible,

	// 								'closeTime_human_readible' => $closeTime_human_readible,

	// 								'human_readible_dateTime' => date('Y-m-d G:i:s'),

	// 							);

	// 							$check_candle = $this->check_candle_stick_data_if_exist($symbol, $periods, $value['openTime']);


	// 							echo 'check_candle '.$check_candle; exit;




	// 							if ($check_candle) {

	// 								$this->mongo_db->insert('market_chart_dailybase', $insert22);

	// 								echo 'insert' . '<br>';

	// 							} else {

	// 								$if_current_cand = $this->check_if_current_candle($periods, $value['openTime']);

	// 								if ($if_current_cand) {

	// 									$this->candle_update($symbol, $periods, $value['openTime'], $insert22);

	// 									$update_count_for_canlde_missing = $this->mod_sockets->update_count_for_duplicating_candle();

	// 									echo 'update' . '<br>';

	// 								}

	// 							} /*** End of insert***/

	// 						}

	// 					}

	// 					//Update Socket Track

	// 					$this->mod_sockets->update_socket_track('market_chart2', $symbol);

	// 				});

	// 			}/** End of period array**/

	// 		} else {

	// 			echo "Socket is Running for " . $coin_symbol . "... </br>";

	// 		}

	// 	} //end for

	// }
}
