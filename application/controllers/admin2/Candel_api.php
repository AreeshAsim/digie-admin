<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Candel_api extends CI_Controller {
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

		$this->load->model('admin/mod_coins');

		$this->load->model('admin/mod_candel_api');

		$this->load->model('admin/mod_sockets');

		$this->load->model('admin/mod_candel');
		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}
	}

	public function drawCandlestick_custom() {
		//Login Check
		$this->mod_login->verify_is_admin_login();
		$global_symbol = $this->session->userdata('global_symbol');
		if ($this->session->userdata('periods')) {
		} else {
			$this->session->set_userdata('periods', '1h');
		}

		$periods = $this->session->userdata('periods');
		$user_testing = $this->binance_api->get_candelstick($global_symbol, $periods);
		$resp = $this->mod_candel_api->get_chart_target_zones($global_symbol);

		//$resp = $this->mod_candel_api->get_candelstick_data();

		$data["compare_val"] = $resp;
		$data["candlesdtickArr"] = $user_testing;
		$data["candle_period"] = $periods;
		//stencil is our templating library. Simply call view via it

		$this->stencil->paint('admin/dashboard/candlesdtick_custom', $data);

		//$this->load->view('admin/dashboard/candlesdtick_custom',$data);

	} /*** End of  drawCandlestick_custom***/

	public function candlesdtick_dyamic() {

		//Login Check

		$this->mod_login->verify_is_admin_login();
		$global_symbol = $this->session->userdata('global_symbol');

		// if($this->session->userdata('periods')){

		// }else{

		// 	$this->session->set_userdata('periods', '1h');

		// }

		// $periods = $this->session->userdata('periods');

		$periods = '1h';

		$user_testing = $this->binance_api->get_candelstick($global_symbol, $periods);

		$resp = $this->mod_candel_api->get_chart_target_zones($global_symbol);
		//$resp = $this->mod_candel_api->get_candelstick_data();

		$data["compare_val"] = $resp;

		$data["candlesdtickArr"] = $user_testing;

		$data["candle_period"] = $periods;

		//stencil is our templating library. Simply call view via it

		$this->stencil->paint('admin/dashboard/candlesdtick_dyamic', $data);

		//$this->load->view('admin/dashboard/candlesdtick_dyamic',$data);

	} /*** End of  drawCandlestick_custom***/

	public function autoload_candle_stick_data_ajax() {

		//Login Ceck
		$this->mod_login->verify_is_admin_login();
		$periods = $this->input->post('period');
		$global_symbol = $this->session->userdata('global_symbol');

		$this->session->set_userdata('periods', $periods);

		$periods = $this->session->userdata('periods');

		$user_testing = $this->binance_api->get_candelstick($global_symbol, $periods);

		//$user_testing = $this->mod_candel_api->get_candelstick_data_from_database($global_symbol,$periods);

		$resp = $this->mod_candel_api->get_chart_target_zones($global_symbol);

		//$resp = $this->mod_candel_api->get_candelstick_data();

		$data["compare_val"] = $resp;

		$data["candlesdtickArr"] = $user_testing;

		$data["candle_period"] = $periods;

		echo json_encode($data);

	}

	public function autoload_candle_stick_data_pre() {
		//Login Check

		$this->mod_login->verify_is_admin_login();
		$resp = $this->mod_candel_api->get_candelstick_data_pre($this->input->post());
		$data["candlesdtickArr"] = $resp;
		echo json_encode($data);
	}

	public function autoload_candle_stick_data_next() {
		//Login Check
		$this->mod_login->verify_is_admin_login();
		$resp = $this->mod_candel_api->get_candelstick_data_next($this->input->post());
		$data["candlesdtickArr"] = $resp;
		echo json_encode($data);
	}

	public function autoload_candle_stick_data_minute() {

		//Login Check

		$this->mod_login->verify_is_admin_login();

		$resp = $this->mod_candel_api->get_candelstick_data_minute();

		$data["candlesdtickArr"] = $resp;

		echo json_encode($data);

	} /*** End autoload_candle_stick_data_minute***/

	public function autoload_candle_stick_data_day() {

		//Login Check

		$this->mod_login->verify_is_admin_login();

		$resp = $this->mod_candel_api->get_candelstick_data_day();

		$data["candlesdtickArr"] = $resp;

		echo json_encode($data);

	} /***/

	public function drawCandlestick_custom1() {
		//Login Check
		$this->mod_login->verify_is_admin_login();
		$resp = $this->mod_candel_api->get_candelstick_data1();
		$data["candlesdtickArr"] = $resp;
		//stencil is our templating library. Simply call view via it

		//$this->stencil->paint('admin/dashboard/candlesdtick_custom',$data);

		$this->load->view('admin/dashboard/candlesdtick_custom', $data);

	}

	public function autoload_candle_stick_data() {
		$resp = $this->mod_candel_api->get_candelstick_data_by_ajax();
		$data["candlesdtickArr"] = $resp;
		echo json_encode($data);
	}
	public function run_one() {

		$global_symbol = $this->session->userdata('global_symbol');
		// $resp = $this->mod_candel_api->save_market_history_for_candel($global_symbol);
		$resp = $this->mod_candel_api->get_market_history_for_candel($global_symbol);
		$total_volume_arr = $resp['total_volume_arr'];

		echo max($total_volume_arr);

		echo '<pre>';

		print_r($resp);

		exit;

	}

	public function volume_from_market_history() {
		$this->mod_login->verify_is_admin_login();
		$global_symbol = $this->session->userdata('global_symbol');
		$periods = '1h';
		$user_testing = $this->mod_candel_api->get_candelstick_data_from_database($global_symbol, $periods);
		$get_market_history_for_candel = $this->mod_candel_api->get_market_history_for_candel($global_symbol);
		$resp = $this->mod_candel_api->get_chart_target_zones($global_symbol);
		$total_volume_arr = $get_market_history_for_candel['total_volume_arr'];
		$total_volume_arr = array_reverse($total_volume_arr);
		$max_volumer = max($total_volume_arr);

		$data["compare_val"] = $resp;
		$data["candlesdtickArr"] = $user_testing;
		$data["candle_period"] = $periods;
		$data["get_market_history_for_candel"] = $get_market_history_for_candel;
		$data['max_volume'] = $max_volumer;
		$data['total_volume_arr'] = $total_volume_arr;
		$data["candle_period"] = $periods;

		$this->stencil->paint('admin/dashboard/volume_from_market_history', $data);

	} /*** End of volume_from_market_history.php **/

	public function run() {

		ini_set("memory_limit", -1);
		$this->mod_login->verify_is_admin_login();
		$global_symbol = $this->session->userdata('global_symbol');
		$periods = '1h';

		$candel_stick_arr = $this->mod_candel_api->get_candelstick_data_from_database($global_symbol, $periods);

		$order_data = $this->mod_candel_api->get_order_array($global_symbol);

		if (count($candel_stick_arr) > 0) {
			$start_date_for_time_zone = $candel_stick_arr[0]['openTime'];
			$end_date_for_time_zone = $candel_stick_arr[count($candel_stick_arr) - 1]['openTime'];
		}

		$coin_unit_val = $this->mod_coins->get_coin_unit_value($global_symbol);

		//$candel_stick_arr = $this->binance_api->get_candelstick($global_symbol,$periods);
		$draw_target_zone_arr = $this->mod_candel_api->get_chart_target_zones($global_symbol);

		$draw_target_zone_arr_full = array();
		/***Check if target zone Exist***/

		if (count($draw_target_zone_arr) > 0) {
			foreach ($draw_target_zone_arr as $target_zone_value) {
				$start_date_second = $start_date_for_time_zone / 1000;
				$end_date_second = $end_date_for_time_zone / 1000;
				$unit_value = $coin_unit_val;
				$start_date = date("Y-m-d H:00:00", $start_date_second);
				$end_date = date("Y-m-d H:59:59", $end_date_second);
				$get_market_history_for_candel = $this->mod_candel_api->get_candle_price_volume_detail($global_symbol, $start_date, $end_date, $unit_value);
				$target_zone_value['draw_target_zone'] = $get_market_history_for_candel;
				array_push($draw_target_zone_arr_full, $target_zone_value);

			}
		}/** End of for each **/

		$from_date_for_candel = $candel_stick_arr[0]['openTime'];
		$end_date_for_candel = $candel_stick_arr[count($candel_stick_arr) - 1]['openTime'];
		$from_date_for_candel_second = $from_date_for_candel / 1000;
		$end_date_for_candel_second = $end_date_for_candel / 1000;
		$from_date_for_candel = date("Y-m-d H:00:00", $from_date_for_candel_second);
		$end_date_for_candel = date("Y-m-d H:59:59", $end_date_for_candel_second);

		$all_candle_volume_detail = $this->mod_candel_api->get_candle_price_volume_detail($global_symbol, $from_date_for_candel, $end_date_for_candel, $unit_value = 0);
		$all_Hour_candle_volume_detail = $this->mod_candel_api->get_hour_volume_array_detail($global_symbol, $from_date_for_candel, $end_date_for_candel);

		$bid_hour_arr_volume = $all_Hour_candle_volume_detail['bid_hour_arr_volume'];
		$ask_hour_arr_volume = $all_Hour_candle_volume_detail['ask_hour_arr_volume'];
		$max_volume_hourly = $all_Hour_candle_volume_detail['max_volume_hourly'];
		$total_hour_volume_arr = $all_Hour_candle_volume_detail['total_hour_volume_arr'];

		$candel_stick_arr_new = array();
		foreach ($candel_stick_arr as $candel_stick_single_arr) {
			$candel_stick_single_arr['ask_volume'] = $ask_hour_arr_volume[$candel_stick_single_arr['openTime_human_readible']];

			$candel_stick_single_arr['bid_volume'] = $bid_hour_arr_volume[$candel_stick_single_arr['openTime_human_readible']];

			$candel_stick_single_arr['total_volume'] = $total_hour_volume_arr[$candel_stick_single_arr['openTime_human_readible']];

			$candel_stick_single_arr['max_volume'] = $max_volume_hourly;

			$candel_stick_single_arr['time_index'] = $candel_stick_single_arr['openTime_human_readible'];

			array_push($candel_stick_arr_new, $candel_stick_single_arr);
		}

		$data['all_candle_volume_detail'] = $all_candle_volume_detail;

		$data['all_Hour_candle_volume_detail'] = $all_Hour_candle_volume_detail;

		$data["compare_val"] = $resp;

		$data["candlesdtickArr"] = $candel_stick_arr_new;

		$data["candle_period"] = $periods;

		$data["get_market_history_for_candel"] = $get_market_history_for_candel;

		$data["draw_target_zone_arr"] = $draw_target_zone_arr_full;

		$ask_volume_arr = $get_market_history_for_candel['ask_arr_volume'];

		$bid_volume_arr = $get_market_history_for_candel['bid_arr_volume'];

		$total_volume_arr = $get_market_history_for_candel['total_volume_arr'];

		$max_volume = $get_market_history_for_candel['max_volume'];

		$unit_value = $get_market_history_for_candel['unit_value'];

		$max_volumer = $max_volume;

		$data["ask_volume_arr"] = $ask_volume_arr;

		$data["bid_volume_arr"] = $bid_volume_arr;

		$data["total_volume_arr"] = $total_volume_arr;

		$data["max_volumer"] = $max_volumer;

		$data["unit_value"] = $unit_value;

		$data['order_data'] = $order_data;

		$this->stencil->paint('admin/dashboard/candlesdtick_dyamic_api', $data);

	} /*** End of  drawCandlestick_custom***/

	public function autoload_candle_stick_data_from_database_ajax() {

		$this->mod_login->verify_is_admin_login();
		$global_symbol = $this->session->userdata('global_symbol');
		$order_data = $this->mod_candel_api->get_order_array($global_symbol);

		$periods = '1h';
		$from_date_object = '';
		$to_date_object = '';

		// if($this->input->post('from_date') &&  $this->input->post('to_date')){

		// 	$from_date = $this->input->post('from_date');

		// 	$to_date = $this->input->post('to_date');

		// 	$from_date = date("Y-m-d 00:00:00", strtotime($from_date ));

		// 	$to_date =   date("Y-m-d 23:59:59", strtotime($to_date));

		// 	$from_date_object = $this->convert_date_time_to_server_date_time($from_date);

		// 	$to_date_object =  $this->convert_date_time_to_server_date_time($to_date);

		// }

		$previous_date = '';
		if ($this->input->post('previous_date')) {
			$previous_date = $this->input->post('previous_date');

		}

		$forward_date = '';
		if ($this->input->post('forward_date')) {
			$forward_date = $this->input->post('forward_date');
		}

		$candel_stick_arr = $this->mod_candel_api->get_candelstick_data_from_database($global_symbol, $periods, $from_date_object, $to_date_object, $previous_date, $forward_date);

		if (count($candel_stick_arr) > 0) {
			$start_date_for_time_zone = $candel_stick_arr[0]['openTime'];
			$end_date_for_time_zone = $candel_stick_arr[count($candel_stick_arr) - 1]['openTime'];
		}

		$coin_unit_val = $this->mod_coins->get_coin_unit_value($global_symbol);
		//$candel_stick_arr = $this->binance_api->get_candelstick($global_symbol,$periods);
		$draw_target_zone_arr = $this->mod_candel_api->get_chart_target_zones($global_symbol);
		$draw_target_zone_arr_full = array();
		/***Check if target zone Exist***/

		if (count($draw_target_zone_arr) > 0) {
			foreach ($draw_target_zone_arr as $target_zone_value) {
				$start_date_second = $start_date_for_time_zone / 1000;
				$end_date_second = $end_date_for_time_zone / 1000;
				$unit_value = $coin_unit_val;

				$start_date = date("Y-m-d H:00:00", $start_date_second);

				$end_date = date("Y-m-d H:59:59", $end_date_second);

				$get_market_history_for_candel = $this->mod_candel_api->get_candle_price_volume_detail($global_symbol, $start_date, $end_date, $unit_value);
				$target_zone_value['draw_target_zone'] = $get_market_history_for_candel;
				array_push($draw_target_zone_arr_full, $target_zone_value);
			}

		}/** End of for each **/

		$from_date_for_candel = $candel_stick_arr[0]['openTime'];
		$end_date_for_candel = $candel_stick_arr[count($candel_stick_arr) - 1]['openTime'];
		$from_date_for_candel_second = $from_date_for_candel / 1000;
		$end_date_for_candel_second = $end_date_for_candel / 1000;
		$from_date_for_candel = date("Y-m-d H:00:00", $from_date_for_candel_second);
		$end_date_for_candel = date("Y-m-d H:59:59", $end_date_for_candel_second);
		$all_candle_volume_detail = $this->mod_candel_api->get_candle_price_volume_detail($global_symbol, $from_date_for_candel, $end_date_for_candel, $unit_value = 0);
		// echo '$global_symbol'.$global_symbol.'-->from_date_for_candel'>$from_date_for_candel.'----->end_date_for_candel'.$end_date_for_candel;

		$all_Hour_candle_volume_detail = $this->mod_candel_api->get_hour_volume_array_detail($global_symbol, $from_date_for_candel, $end_date_for_candel);
		// echo '<pre>';

		// print_r($all_Hour_candle_volume_detail);

		// exit();

		$bid_hour_arr_volume = $all_Hour_candle_volume_detail['bid_hour_arr_volume'];
		$ask_hour_arr_volume = $all_Hour_candle_volume_detail['ask_hour_arr_volume'];
		$max_volume_hourly = $all_Hour_candle_volume_detail['max_volume_hourly'];
		$total_hour_volume_arr = $all_Hour_candle_volume_detail['total_hour_volume_arr'];
		$candel_stick_arr_new = array();
		foreach ($candel_stick_arr as $candel_stick_single_arr) {
			$candel_stick_single_arr['ask_volume'] = $ask_hour_arr_volume[$candel_stick_single_arr['openTime_human_readible']];
			$candel_stick_single_arr['bid_volume'] = $bid_hour_arr_volume[$candel_stick_single_arr['openTime_human_readible']];
			$candel_stick_single_arr['total_volume'] = $total_hour_volume_arr[$candel_stick_single_arr['openTime_human_readible']];
			$candel_stick_single_arr['max_volume'] = $max_volume_hourly;
			$candel_stick_single_arr['time_index'] = $candel_stick_single_arr['openTime_human_readible'];
			array_push($candel_stick_arr_new, $candel_stick_single_arr);
		}

		$data['all_candle_volume_detail'] = $all_candle_volume_detail;
		$data['all_Hour_candle_volume_detail'] = $all_Hour_candle_volume_detail;
		$data["compare_val"] = $resp;
		$data["candlesdtickArr"] = $candel_stick_arr_new;
		$data["candle_period"] = $periods;
		$data["get_market_history_for_candel"] = $get_market_history_for_candel;
		$data["draw_target_zone_arr"] = $draw_target_zone_arr_full;
		$ask_volume_arr = $get_market_history_for_candel['ask_arr_volume'];
		$bid_volume_arr = $get_market_history_for_candel['bid_arr_volume'];
		$total_volume_arr = $get_market_history_for_candel['total_volume_arr'];
		$max_volume = $get_market_history_for_candel['max_volume'];
		$unit_value = $get_market_history_for_candel['unit_value'];
		$max_volumer = $max_volume;
		$data["ask_volume_arr"] = $ask_volume_arr;
		$data["bid_volume_arr"] = $bid_volume_arr;
		$data["total_volume_arr"] = $total_volume_arr;
		$data["max_volumer"] = $max_volumer;
		$data["unit_value"] = $unit_value;
		$data['order_data'] = $order_data;
		echo json_encode($data);
	}/** End of autoload_candle_stick_data_from_database_ajax**/

	public function save_candel_api_ajax() {

		$global_symbol = $this->session->userdata('global_symbol');
		$data = json_decode(stripslashes($this->input->post('cande_status_and_type_stringify')));
		echo $update_candels = $this->mod_candel->update_candel_for_formul_values($data, $global_symbol);
		exit();

	} //End of save_candel_ajax

	public function delete_data_from_data_base() {
		$this->mod_candel_api->delete_data_from_data_base();
	}

	public function test() {
		$global_symbol = $this->session->userdata('global_symbol');
		$data = $this->mod_candel_api->get_order_array($global_symbol);
		echo "<pre>";
		print_r($data);
		exit;

	}

}
