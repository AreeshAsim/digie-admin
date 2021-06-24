<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Candel_hour extends CI_Controller {

	public function __construct() {

		parent::__construct();

		//load main template

		$this->stencil->layout('admin_layout');

		//load required slices

		$this->stencil->slice('admin_header_script');

		$this->stencil->slice('admin_header');

		$this->stencil->slice('admin_left_sidebar');

		$this->stencil->slice('admin_footer_script');

		// Load Modal

		$this->load->model('admin/mod_login');

		$this->load->model('admin/mod_users');

		$this->load->model('admin/mod_dashboard');

		$this->load->model('admin/mod_new_candel');

		$this->load->model('admin/mod_coins');

		$this->load->model('admin/mod_new_candel');

		$this->load->model('admin/mod_sockets');

	}

	// public function run() {

	// 	// ini_set("memory_limit", -1);

	// 	$this->mod_login->verify_is_admin_login();

	// 	$global_symbol = $this->session->userdata('global_symbol');

	// 	$global_mode = $this->session->userdata('global_mode');

	// 	$admin_id = $this->session->userdata('admin_id');
	// 	$offset   = $this->mod_coins->get_coin_offset_value($global_symbol);
	// 	$data['offset'] = $offset;
	// 	$periods = '1h';

	// 	//$order_data = $this->mod_new_candel->get_order_array($global_symbol,$admin_id,$global_mode);

	// 	$order_data = array();
	// 	$candel_stick_arr = $this->mod_new_candel->get_candelstick_data_from_database($global_symbol, $periods);
	// 	$candel_stick_arr = $candel_stick_arr['candle_arr'];

	// 	$max_volume_hourly = $candel_stick_arr['max_volume'];

	// 	if (count($candel_stick_arr) > 0) {

	// 		$start_date_for_time_zone = $candel_stick_arr[0]['openTime'];

	// 		$end_date_for_time_zone = $candel_stick_arr[count($candel_stick_arr) - 1]['openTime'];

	// 	}

	// 	//Call function to get task Manager setting

	// 	$task_manager_setting_arr = $this->mod_new_candel->get_task_manager_setting($global_symbol);

	// 	$data['task_manager_setting_arr'] = $task_manager_setting_arr;

	// 	$coin_unit_val = $this->mod_coins->get_coin_unit_value($global_symbol);

	// 	//$candel_stick_arr = $this->binance_api->get_candelstick($global_symbol,$periods);

	// 	$draw_target_zone_arr = $this->mod_new_candel->get_chart_target_zones($global_symbol);

	// 	$draw_target_zone_arr_full = array();

	// 	/***Check if target zone Exist***/

	// 	if (count($draw_target_zone_arr) > 0) {

	// 		foreach ($draw_target_zone_arr as $target_zone_value) {

	// 			$start_date_second = $start_date_for_time_zone / 1000;

	// 			$end_date_second = $end_date_for_time_zone / 1000;

	// 			$unit_value = $coin_unit_val;

	// 			$start_date = date("Y-m-d H:00:00", $start_date_second);

	// 			$end_date = date("Y-m-d H:59:59", $end_date_second);

	// 			$get_market_history_for_candel = $this->mod_new_candel->get_candle_price_volume_detail($global_symbol, $start_date, $end_date, $unit_value);

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

	// 	$all_candle_volume_detail = $this->mod_new_candel->get_candle_price_volume_detail($global_symbol, $from_date_for_candel, $end_date_for_candel, $unit_value = 0);

	// 	//$all_Hour_candle_volume_detail = $this->mod_new_candel->get_hour_volume_array_detail($global_symbol,$from_date_for_candel,$end_date_for_candel);

	// 	$candel_stick_arr_new = array();

	// 	$bid_hour_arr_volume = array();
	// 	$ask_hour_arr_volume = array();
	// 	$total_hour_volume_arr = array();

	// 	foreach ($candel_stick_arr as $candel_stick_single_arr) {

	// 		$openTime_current_time_zone = $candel_stick_single_arr['openTime'];

	// 		$start_date_1 = date("Y-m-d H:00:00", $openTime_current_time_zone / 1000);

	// 		$end_date_1 = date("Y-m-d H:59:59", $openTime_current_time_zone / 1000);

	// 		$bid_hour_arr_volume[$start_date_1] = $candel_stick_single_arr['bid_volume'];
	// 		$ask_hour_arr_volume[$start_date_1] = $candel_stick_single_arr['ask_volume'];
	// 		$total_hour_volume_arr[$start_date_1] = $candel_stick_single_arr['total_volume'];

	// 		//$down_status = $this->mod_new_candel->calculate_pressure_up_and_down($start_date_1, $end_date_1, $candel_stick_single_arr['coin'], $pressure_type = 'down');

	// 		//$up_status = $this->mod_new_candel->calculate_pressure_up_and_down($start_date_1, $end_date_1, $candel_stick_single_arr['coin'], $pressure_type = 'up');

	// 		//$calculate_up_down_wall = $this->mod_new_candel->calculate_up_down_wall($candel_stick_single_arr['coin'], $start_date_1);

	// 		//$//calculate_up_down_wall22 = $this->mod_new_candel->calculate_up_down_yellow_wall($candel_stick_single_arr['coin'], $start_date_1);

	// 		// By Ali 19 september Get sentiment Report Goes here

	// 		$dataArr = $this->mod_new_candel->getSentimentReport($type = '', $source = 'twitter', $global_symbol, $start_date_1, $end_date_1, $formula, $periods);

	// 		$dataArrSocial = $this->mod_new_candel->getSentimentReportSocial($type = '', $source = 'reddit', $global_symbol, $start_date_1, $end_date_1, $formula, $periods);

	// 		$candel_stick_single_arr['news_p'] = $dataArr['t_pos_divide_t'];
	// 		$candel_stick_single_arr['news_n'] = $dataArr['t_neg_divide_t'];

	// 		$candel_stick_single_arr['social_p'] = $dataArrSocial['sum_nageative'];
	// 		$candel_stick_single_arr['social_n'] = $dataArrSocial['sum_positive'];

	// 		// $ask_diff = $calculate_up_down_wall['ask_diff'];
	// 		// $bid_diff = $calculate_up_down_wall['bid_diff'];

	// 		// $y_ask_diff = $calculate_up_down_wall22['ask_diff'];
	// 		// $y_bid_diff = $calculate_up_down_wall22['bid_diff'];
	// 		$bid_diff = 0;
	// 		$ask_diff = 0;
	// 		$y_bid_diff = 0;
	// 		$y_ask_diff = 0;
	// 		$candel_stick_single_arr['bid_diff'] = $bid_diff;
	// 		$candel_stick_single_arr['ask_diff'] = $ask_diff;
	// 		$candel_stick_single_arr['y_ask_diff'] = $y_ask_diff;
	// 		$candel_stick_single_arr['y_bid_diff'] = $y_bid_diff;
	// 		//$candel_stick_single_arr['down_status'] = $down_status;
	// 		//$candel_stick_single_arr['up_status'] = $up_status;

	// 		$open_time_zone_time = $this->convert_time_zone($openTime_current_time_zone);
	// 		$candel_stick_single_arr['open_time_zone_time'] = $open_time_zone_time;

	// 		$candel_stick_single_arr['ask_volume'] = $ask_hour_arr_volume[$candel_stick_single_arr['openTime_human_readible']];

	// 		$candel_stick_single_arr['bid_volume'] = $bid_hour_arr_volume[$candel_stick_single_arr['openTime_human_readible']];

	// 		$candel_stick_single_arr['total_volume'] = $total_hour_volume_arr[$candel_stick_single_arr['openTime_human_readible']];

	// 		$candel_stick_single_arr['max_volume'] = $max_volume_hourly;

	// 		$candel_stick_single_arr['time_index'] = $candel_stick_single_arr['openTime_human_readible'];

	// 		array_push($candel_stick_arr_new, $candel_stick_single_arr);

	// 	}
		
		
		
	// 	///echo "<pre>";  print_r($candel_stick_arr_new); exit;
		
		
		
		

	// 	$all_Hour_candle_volume_detail['total_hour_volume_arr'] = $total_hour_volume_arr;
	// 	$all_Hour_candle_volume_detail['bid_hour_arr_volume'] = $bid_hour_arr_volume;
	// 	$all_Hour_candle_volume_detail['ask_hour_arr_volume'] = $ask_hour_arr_volume;
	// 	$all_Hour_candle_volume_detail['max_volume_hourly'] = $max_volume_hourly;

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

	// 	$this->stencil->paint('admin/dashboard/new_candlesdtick_dyamic_7', $data);

	// } /*** End of  drawCandlestick_custom***/

	// public function convert_time_zone($mil) {
	// 	$seconds = $mil / 1000;
	// 	$datetime = date("Y-m-d g:i:s A", $seconds);
	// 	$timezone = $this->session->userdata('timezone');
	// 	$date = date_create($datetime);
	// 	date_timezone_set($date, timezone_open($timezone));
	// 	return date_format($date, 'Y-m-d g:i:s A');
	// } //End of convert_time_zone

	// public function autoload_candle_stick_data_from_database_ajax() {

	// 	$this->mod_login->verify_is_admin_login();

	// 	$global_symbol = $this->session->userdata('global_symbol');

	// 	$admin_id = $this->session->userdata('admin_id');

	// 	$global_mode = $this->session->userdata('global_mode');

	// 	$order_data = array();
	// 	//$order_data = $this->mod_new_candel->get_order_array($global_symbol,$admin_id,$global_mode);

	// 	$periods = '1h';

	// 	$from_date_object = '';

	// 	$to_date_object = '';

	// 	$previous_date = '';

	// 	$is_sma_checked = '';
	// 	$sma_offset = '';

	// 	if ($this->input->post('is_sma')) {
	// 		$is_sma_checked = $this->input->post('is_sma');
	// 		$sma_offset = $this->input->post('sma_offset');
	// 	}

	// 	if ($this->input->post('previous_date')) {

	// 		$previous_date = $this->input->post('previous_date');

	// 	}

	// 	$forward_date = '';

	// 	if ($this->input->post('forward_date')) {

	// 		$forward_date = $this->input->post('forward_date');

	// 	}

	// 	$candel_stick_arr = $this->mod_new_candel->get_candelstick_data_from_database($global_symbol, $periods, $from_date_object, $to_date_object, $previous_date, $forward_date);

	// 	$candel_stick_arr = $candel_stick_arr['candle_arr'];
	// 	$max_volume_hourly = $candel_stick_arr['max_volume'];

	// 	if (count($candel_stick_arr) > 0) {

	// 		$start_date_for_time_zone = $candel_stick_arr[0]['openTime'];

	// 		$end_date_for_time_zone = $candel_stick_arr[count($candel_stick_arr) - 1]['openTime'];

	// 	}

	// 	//Call function to get task Manager setting

	// 	$task_manager_setting_arr = $this->mod_new_candel->get_task_manager_setting($global_symbol);

	// 	$data['task_manager_setting_arr'] = $task_manager_setting_arr;

	// 	$coin_unit_val = $this->mod_coins->get_coin_unit_value($global_symbol);

	// 	//$candel_stick_arr = $this->binance_api->get_candelstick($global_symbol,$periods);

	// 	$draw_target_zone_arr = $this->mod_new_candel->get_chart_target_zones($global_symbol);

	// 	$draw_target_zone_arr_full = array();

	// 	/***Check if target zone Exist***/

	// 	if (count($draw_target_zone_arr) > 0) {

	// 		foreach ($draw_target_zone_arr as $target_zone_value) {

	// 			$start_date_second = $start_date_for_time_zone / 1000;

	// 			$end_date_second = $end_date_for_time_zone / 1000;

	// 			$unit_value = $coin_unit_val;

	// 			$start_date = date("Y-m-d H:00:00", $start_date_second);

	// 			$end_date = date("Y-m-d H:59:59", $end_date_second);

	// 			$get_market_history_for_candel = $this->mod_new_candel->get_candle_price_volume_detail($global_symbol, $start_date, $end_date, $unit_value);

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

	// 	$all_candle_volume_detail = $this->mod_new_candel->get_candle_price_volume_detail($global_symbol, $from_date_for_candel, $end_date_for_candel, $unit_value = 0);

	// 	//$all_Hour_candle_volume_detail = $this->mod_new_candel->get_hour_volume_array_detail($global_symbol,$from_date_for_candel,$end_date_for_candel);

	// 	$candel_stick_arr_new = array();

	// 	$bid_hour_arr_volume = array();
	// 	$ask_hour_arr_volume = array();
	// 	$total_hour_volume_arr = array();

	// 	foreach ($candel_stick_arr as $candel_stick_single_arr) {

	// 		$openTime_current_time_zone = $candel_stick_single_arr['openTime'];

	// 		$start_date_1 = date("Y-m-d H:00:00", $openTime_current_time_zone / 1000);

	// 		$end_date_1 = date("Y-m-d H:59:59", $openTime_current_time_zone / 1000);

	// 		$bid_hour_arr_volume[$start_date_1] = $candel_stick_single_arr['bid_volume'];
	// 		$ask_hour_arr_volume[$start_date_1] = $candel_stick_single_arr['ask_volume'];
	// 		$total_hour_volume_arr[$start_date_1] = $candel_stick_single_arr['total_volume'];

	// 		$down_status = $this->mod_new_candel->calculate_pressure_up_and_down($start_date_1, $end_date_1, $candel_stick_single_arr['coin'], $pressure_type = 'down');

	// 		$up_status = $this->mod_new_candel->calculate_pressure_up_and_down($start_date_1, $end_date_1, $candel_stick_single_arr['coin'], $pressure_type = 'up');

	// 		if ($is_sma_checked == 'yes') {
	// 			$status_arrr = $this->mod_new_candel->sma_of_pressure($start_date_1, $end_date_1, $candel_stick_single_arr['coin'], $sma_offset);

	// 			$up_status = $status_arrr['up_sma'];
	// 			$down_status = $status_arrr['down_sma'];

	// 		}

	// 		$calculate_up_down_wall = $this->mod_new_candel->calculate_up_down_wall($candel_stick_single_arr['coin'], $start_date_1);

	// 		// By Ali 19 september Get sentiment Report Goes here

	// 		$dataArr = $this->mod_new_candel->getSentimentReport($type = '', $source = 'twitter', $global_symbol, $start_date_1, $end_date_1, $formula, $periods);

	// 		$dataArrSocial = $this->mod_new_candel->getSentimentReportSocial($type = '', $source = 'reddit', $global_symbol, $start_date_1, $end_date_1, $formula, $periods);

	// 		$candel_stick_single_arr['down_status'] = $dataArr['sum_positive'];
	// 		$candel_stick_single_arr['up_status'] = $dataArr['sum_nageative'];

	// 		$candel_stick_single_arr['down_status_social'] = $dataArrSocial['sum_positive'];
	// 		$candel_stick_single_arr['up_status_social'] = $dataArrSocial['sum_nageative'];

	// 		$ask_diff = $calculate_up_down_wall['ask_diff'];
	// 		$bid_diff = $calculate_up_down_wall['bid_diff'];

	// 		$candel_stick_single_arr['bid_diff'] = $bid_diff;
	// 		$candel_stick_single_arr['ask_diff'] = $ask_diff;
	// 		//$candel_stick_single_arr['down_status'] = $down_status;
	// 		//$candel_stick_single_arr['up_status'] = $up_status;

	// 		$open_time_zone_time = $this->convert_time_zone($openTime_current_time_zone);
	// 		$candel_stick_single_arr['open_time_zone_time'] = $open_time_zone_time;

	// 		$candel_stick_single_arr['ask_volume'] = $ask_hour_arr_volume[$candel_stick_single_arr['openTime_human_readible']];

	// 		$candel_stick_single_arr['bid_volume'] = $bid_hour_arr_volume[$candel_stick_single_arr['openTime_human_readible']];

	// 		$candel_stick_single_arr['total_volume'] = $total_hour_volume_arr[$candel_stick_single_arr['openTime_human_readible']];

	// 		$candel_stick_single_arr['max_volume'] = $max_volume_hourly;

	// 		$candel_stick_single_arr['time_index'] = $candel_stick_single_arr['openTime_human_readible'];

	// 		array_push($candel_stick_arr_new, $candel_stick_single_arr);

	// 	}

	// 	$all_Hour_candle_volume_detail['total_hour_volume_arr'] = $total_hour_volume_arr;
	// 	$all_Hour_candle_volume_detail['bid_hour_arr_volume'] = $bid_hour_arr_volume;
	// 	$all_Hour_candle_volume_detail['ask_hour_arr_volume'] = $ask_hour_arr_volume;
	// 	$all_Hour_candle_volume_detail['max_volume_hourly'] = $max_volume_hourly;

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

	// 	$this->mod_new_candel->delete_data_from_data_base();

	// } //End of delete_data_from_data_base

	// public function save_candel_ajax() {

	// 	$this->mod_login->verify_is_admin_login();

	// 	$global_symbol = $this->session->userdata('global_symbol');

	// 	$data = json_decode(stripslashes($this->input->post('cande_status_and_type_stringify')));

	// 	echo $update_candels = $this->mod_new_candel->update_candel_for_formul_values($data, $global_symbol);

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

	// 	$this->mod_new_candel->save_task_manager_setting($this->input->post(), $global_symbol);

	// } //End Of save_task_manager_setting_ajax

	// public function test() {

	// 	$start_date_1 = '2018-08-30 00:00:00';

	// 	$calculate_up_down_wall = $this->mod_new_candel->calculate_up_down_wall($candel_stick_single_arr['coin'], $start_date_1);

	// 	$this->mod_new_candel->calculate_pressure_up_and_down();
	// 	exit();
	// 	$this->mongo_db->order_by(array('created_date' => -1));

	// 	$res = $this->mongo_db->get('buy_orders');

	// 	echo '<pre>';

	// 	print_r(iterator_to_array($res));

	// 	exit();

	// }

}
