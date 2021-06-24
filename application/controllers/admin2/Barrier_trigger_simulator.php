<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Barrier_trigger_simulator extends CI_Controller {

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
		$this->load->model('admin/mod_login');
		$this->load->model('admin/mod_users');
		$this->load->model('admin/mod_dashboard');
		$this->load->model('admin/mod_market');
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_buy_orders');
		$this->load->model('admin/mod_candel');
		$this->load->model('admin/mod_realtime_candle_socket');
		$this->load->model('admin/mod_box_trigger_3');
		$this->load->model('admin/mod_barrier_trigger_simulator');
		$this->load->model('admin/mod_chart3');
		$this->load->model('admin/mod_barrier_trigger');
	}

	public function create_and_buy_order($coin_symbol = "NCASHBTC", $simulator_date = "2018-10-10 00:00:00") {
		$date = date('Y-m-d H:00:00');
		$triggers_type = 'barrier_trigger';
		$order_mode = 'test';

		/**************************************************************************/
		/***************************Codded BY WAQAR********************************/
		/**************************************************************************/

		if (isset($_POST['datetime_simulator']) && $_POST['datetime_simulator'] != '') {
			$simulator_date_new_obj = $_POST['datetime_simulator'];
			$timezone = $this->session->userdata('timezone');

		 $dt = new DateTime($simulator_date_new_obj, new DateTimeZone($timezone));

		 $dt->setTimezone(new DateTimeZone('UTC'));

		 // format the datetime
		 echo "Rules History For Time: ";
		 echo $simulator_date = $dt->format('Y-m-d H:i:s');
		 echo "<br>";
		}

		/**************************************************************************/
		/***************************End Codded BY WAQAR****************************/
		/**************************************************************************/

		$res_time_arr = $this->mod_barrier_trigger_simulator->get_every_5_second_in_an_hour($simulator_date);



		$meet_condition_for_buy = false;
		if (count($res_time_arr) > 0) {
			foreach ($res_time_arr as $start_date => $end_date) {

				$historical_data = $this->mod_barrier_trigger_simulator->
					historical_coin_meta($coin_symbol, $start_date, $end_date);


				//Get simulator values
				if (!empty($historical_data)) {
					$this->go_buy_rules($coin_symbol, $historical_data, $start_date);
					$this->go_sell_rules($coin_symbol, $historical_data, $start_date);
				} //End of historical_data

			} //End of time arr for each
		} //End of time array have values
	} //End Of create_and_buy_order

	public function go_buy_rules($coin_symbol, $historical_data, $start_date) {
		$rule_meet_arr = array();
		extract($historical_data);

		for ($rule_number = 1; $rule_number <= 10; $rule_number++) {

			$buy_arr = $this->go_buy($coin_symbol, $rule_number, $historical_data, $start_date);

			echo '<pre>';
			print_r($buy_arr);

			$log_arr = $buy_arr['Rule_' . $rule_number];
			$sell_per = $buy_arr['sell_per'];
			$stop_loss_percent = $buy_arr['stop_loss_percent'];
			$aggressive_stop_rule = $buy_arr['aggressive_stop_rule'];

			if ($buy_arr['response_message'] == 'YES') {
				if (empty($rule_meet_arr)) {

					$rule_meet_arr['rule_number'] = $rule_number;
					$rule_meet_arr['sell_per'] = $sell_per;
					$rule_meet_arr['log_arr'] = $log_arr;
					$rule_meet_arr['stop_loss_percent'] = $stop_loss_percent;
					$rule_meet_arr['aggressive_stop_rule'] = $aggressive_stop_rule;
				}
			}
		} //End of rules loop

		if (!empty($rule_meet_arr)) {
			$log_arr = $rule_meet_arr['log_arr'];
			$sell_per = $rule_meet_arr['sell_per'];
			$stop_loss_percent = $rule_meet_arr['stop_loss_percent'];
			$aggressive_stop_rule = $rule_meet_arr['aggressive_stop_rule'];
			$show_error_log = 'yes';
			$this->go_buy_barrier_trigger_order($start_date, $current_market_value, $coin_symbol, $sell_per, $stop_loss_percent, $log_arr, $show_error_log, $aggressive_stop_rule);
			echo 'Condition Meet for order creation';

		} //End of rule_meet_arr
	} //End of go_buy_rules

	public function go_sell_rules($coin_symbol, $historical_data, $start_date) {
		extract($historical_data);

		$current_market_price = (float) $current_market_value;

		$rule_meet_arr = array();
		for ($rule_number = 1; $rule_number <= 10; $rule_number++) {
			$sell_arr = $this->go_sell($coin_symbol, $rule_number, $historical_data, $start_date);
			$sell_percentage = $sell_arr['sell_percent_rule_' . $rule_number];
			$log_arr = $sell_arr['Rule_' . $rule_number];

			echo '<pre>';
			print_r($sell_arr);

			if ($sell_arr['response_message'] == 'NO') {
				if (empty($rule_meet_arr)) {
					$rule_meet_arr['rule_number'] = $rule_number;
					$rule_meet_arr['sell_percentage'] = $sell_percentage;
					$rule_meet_arr['log_arr'] = $log_arr;
				} else {
					$previous_percentage = $rule_meet_arr['sell_percentage'];
					if ($sell_percentage < $previous_percentage) {
						$rule_meet_arr['rule_number'] = $rule_number;
						$rule_meet_arr['sell_percentage'] = $sell_percentage;
						$rule_meet_arr['log_arr'] = $log_arr;
					} //End of

				} //End of
			}
		}

		if (!empty($rule_meet_arr)) {

			$show_error_log = 'yes';
			$date = date('Y-m-d H:00:00');
			$log_arr = $rule_meet_arr['log_arr'];
			$sell_percentage = $rule_meet_arr['sell_percentage'];
			$rule_number = $rule_meet_arr['rule_number'];

			$this->go_sell_orders_on_defined_sell_price($current_market_price, $coin_symbol, $log_arr, $show_error_log, $sell_percentage, $rule_number, $start_date);
		} //If Not Empty

	} //End of go_sell_rules

	public function go_buy($coin_symbol, $rule_number, $historical_data, $start_date) {
		extract($historical_data);

		$date = date('Y-m-d H:00:00');
		$triggers_type = 'barrier_trigger';
		$order_mode = 'test';
		$rule = 'Rule_' . $rule_number;

		$global_setting_arr = $this->mod_barrier_trigger->get_trigger_global_setting($triggers_type, $order_mode, $coin_symbol);

		$global_setting_arr = $global_setting_arr[0];

		$log_arr = array('Message_type' => '********Buy Message *************');

		$rule_on_off_setting = $global_setting_arr['enable_buy_rule_no_' . $rule_number];

		if ($rule_on_off_setting == 'not' || $rule_on_off_setting == '') {

			$log_arr['Rule_NO_' . $rule_number . '_Off'] = '<span style="color:red">OFF</span>';
			return $log_arr;
		}

		$sell_per = $global_setting_arr['sell_profit_percet'];
		$stop_loss_percent = $global_setting_arr['stop_loss_percet'];

		$data['sell_per'] = $sell_per;
		$data['stop_loss_percent'] = $stop_loss_percent;
		$data['aggressive_stop_rule'] = $global_setting_arr['aggressive_stop_rule'];

		$rule_on_off = 'buy_status_rule_' . $rule_number . '_enable';
		$rule_name = 'buy_status_rule_' . $rule_number;

		$status_rule_1 = $this->buy_rule_status($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $start_date);
		$log_arr = (array_merge($log_arr, $status_rule_1['log_arr']));

		$status_rule_1_result = false;
		if ($status_rule_1['success_message'] == 'YES' || $status_rule_1['success_message'] == 'OFF') {
			$status_rule_1_result = true;
		}

		$rule_on_off = 'buy_check_volume_rule_' . $rule_number;
		$rule_name = 'buy_volume_rule_' . $rule_number;

		$barrier_volume_rule_1 = $this->buy_rule_barrier_volume($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $rule_number, $current_market_value, $start_date);

		$log_arr = (array_merge($log_arr, $barrier_volume_rule_1['log_arr']));

		$barrier_volume_rule_1_result = false;
		if ($barrier_volume_rule_1['success_message'] == 'YES' || $barrier_volume_rule_1['success_message'] == 'OFF') {
			$barrier_volume_rule_1_result = true;
		}

		$rule_on_off = 'done_pressure_rule_' . $rule_number . '_buy_enable';
		$rule_name = 'done_pressure_rule_' . $rule_number . '_buy';

		$down_pressure_rule_1 = $this->buy_rule_down_pressure($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $pressure_diff);

		$log_arr = (array_merge($log_arr, $down_pressure_rule_1['log_arr']));

		$down_pressure_rule_1_result = false;
		if ($down_pressure_rule_1['success_message'] == 'YES' || $down_pressure_rule_1['success_message'] == 'OFF') {
			$down_pressure_rule_1_result = true;
		}

		$rule_on_off = 'big_seller_percent_compare_rule_' . $rule_number . '_buy_enable';
		$rule_name = 'big_seller_percent_compare_rule_' . $rule_number . '_buy';

		$big_seller_rule_1 = $this->buy_rule_big_seller($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $ask_percentage);

		$log_arr = (array_merge($log_arr, $big_seller_rule_1['log_arr']));
		$big_seller_rule_1_rule_1_result = false;
		if ($big_seller_rule_1['success_message'] == 'YES' || $big_seller_rule_1['success_message'] == 'OFF') {
			$big_seller_rule_1_rule_1_result = true;
		}

		$rule_on_off = 'closest_black_wall_rule_' . $rule_number . '_buy_enable';
		$rule_name = 'closest_black_wall_rule_' . $rule_number . '_buy';

		$black_wall_rule_1 = $this->buy_rule_black_wall($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $black_wall_pressure);

		$log_arr = (array_merge($log_arr, $black_wall_rule_1['log_arr']));
		$black_wall_rule_1_result = false;
		if ($black_wall_rule_1['success_message'] == 'YES' || $black_wall_rule_1['success_message'] == 'OFF') {
			$black_wall_rule_1_result = true;
		}

		$rule_on_off = 'closest_yellow_wall_rule_' . $rule_number . '_buy_enable';
		$rule_name = 'closest_yellow_wall_rule_' . $rule_number . '_buy';

		$yellow_wall_rule_1 = $this->buy_rule_yellow_wall($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $yellow_wall_pressure);
		$log_arr = (array_merge($log_arr, $yellow_wall_rule_1['log_arr']));
		$yellow_wall_rule_1_result = false;
		if ($yellow_wall_rule_1['success_message'] == 'YES' || $yellow_wall_rule_1['success_message'] == 'OFF') {
			$yellow_wall_rule_1_result = true;
		}

		$rule_on_off = 'seven_level_pressure_rule_' . $rule_number . '_buy_enable';
		$rule_name = 'seven_level_pressure_rule_' . $rule_number . '_buy';

		$seven_level_rule_1 = $this->buy_rule_seven_level($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $seven_level_depth);

		$log_arr = (array_merge($log_arr, $seven_level_rule_1['log_arr']));

		$seven_level_rule_1_result = false;
		if ($seven_level_rule_1['success_message'] == 'YES' || $seven_level_rule_1['success_message'] == 'OFF') {
			$seven_level_rule_1_result = true;
		}

		/************Buy buyer_vs_seller_rule_1_buy **************/
		$rule_on_off = 'buyer_vs_seller_rule_' . $rule_number . '_buy_enable';
		$rule_name = 'buyer_vs_seller_rule_' . $rule_number . '_buy';

		$buyer_vs_seller_rule = $this->buyer_vs_seller($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $sellers_buyers_per);
		$log_arr = (array_merge($log_arr, $buyer_vs_seller_rule['log_arr']));

		$buyer_vs_seller_rule_result = false;
		if ($buyer_vs_seller_rule['success_message'] == 'YES' || $buyer_vs_seller_rule['success_message'] == 'OFF') {
			$buyer_vs_seller_rule_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/
		$rule_on_off = 'buy_last_candle_type' . $rule_number . '_enable';
		$rule_name = 'last_candle_type' . $rule_number . '_buy';

		$is_candle_type = $this->is_candle_type($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_candle_type);

		$log_arr = (array_merge($log_arr, $is_candle_type['log_arr']));

		$is_last_candle_type_result = false;
		if ($is_candle_type['success_message'] == 'YES' || $is_candle_type['success_message'] == 'OFF') {
			$is_last_candle_type_result = true;
		}
		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'buy_rejection_candle_type' . $rule_number . '_enable';
		$rule_name = 'rejection_candle_type' . $rule_number . '_buy';

		$is_rejection_candle = $this->is_rejection_candle($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_candle_rejection_status);

		$log_arr = (array_merge($log_arr, $is_rejection_candle['log_arr']));

		$is_rejection_candle_result = false;
		if ($is_rejection_candle['success_message'] == 'YES' || $is_rejection_candle['success_message'] == 'OFF') {
			$is_rejection_candle_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'buy_last_200_contracts_buy_vs_sell' . $rule_number . '_enable';
		$rule_name = 'last_200_contracts_buy_vs_sell' . $rule_number . '_buy';

		$is_last_200_contracts_buy_vs_sell = $this->is_last_200_contracts_buy_vs_sell($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_200_buy_vs_sell);

		$log_arr = (array_merge($log_arr, $is_last_200_contracts_buy_vs_sell['log_arr']));

		$is_last_200_contracts_buy_vs_sell_result = false;
		if ($is_last_200_contracts_buy_vs_sell['success_message'] == 'YES' || $is_last_200_contracts_buy_vs_sell['success_message'] == 'OFF') {
			$is_last_200_contracts_buy_vs_sell_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'buy_last_200_contracts_time' . $rule_number . '_enable';
		$rule_name = 'last_200_contracts_time' . $rule_number . '_buy';

		$is_last_200_contracts_time = $this->is_last_200_contracts_time($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_200_time_ago);

		$log_arr = (array_merge($log_arr, $is_last_200_contracts_time['log_arr']));

		$is_last_200_contracts_time_result = false;
		if ($is_last_200_contracts_time['success_message'] == 'YES' || $is_last_200_contracts_time['success_message'] == 'OFF') {
			$is_last_200_contracts_time_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'buy_last_qty_buyers_vs_seller' . $rule_number . '_enable';
		$rule_name = 'last_qty_buyers_vs_seller' . $rule_number . '_buy';

		$is_last_qty_buyers_vs_seller = $this->is_last_qty_buyers_vs_seller($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_qty_buy_vs_sell);

		$log_arr = (array_merge($log_arr, $is_last_qty_buyers_vs_seller['log_arr']));

		$is_last_qty_buyers_vs_seller_result = false;
		if ($is_last_qty_buyers_vs_seller['success_message'] == 'YES' || $is_last_qty_buyers_vs_seller['success_message'] == 'OFF') {
			$is_last_qty_buyers_vs_seller_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'buy_last_qty_time' . $rule_number . '_enable';
		$rule_name = 'last_qty_time' . $rule_number . '_buy';

		$is_last_qty_time = $this->is_last_qty_time($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_qty_time_ago);

		$log_arr = (array_merge($log_arr, $is_last_qty_time['log_arr']));

		$is_last_qty_time_result = false;
		if ($is_last_qty_time['success_message'] == 'YES' || $is_last_qty_time['success_message'] == 'OFF') {
			$is_last_qty_time_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/
		$rule_on_off = 'buy_score' . $rule_number . '_enable';
		$rule_name = 'score' . $rule_number . '_buy';

		$is_score = $this->is_score($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $score);

		$log_arr = (array_merge($log_arr, $is_score['log_arr']));

		$is_score_result = false;
		if ($is_score['success_message'] == 'YES' || $is_score['success_message'] == 'OFF') {
			$is_score_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		/************ End Buy buyer_vs_seller_rule_1_buy **************/

		$meet_all_condition_for_rule_1 = false;

		if ($status_rule_1_result && $barrier_volume_rule_1_result & $down_pressure_rule_1_result && $big_seller_rule_1_rule_1_result & $black_wall_rule_1_result & $yellow_wall_rule_1_result & $seven_level_rule_1_result && $buyer_vs_seller_rule_result & $is_last_candle_type_result && $is_rejection_candle_result && $is_last_200_contracts_buy_vs_sell_result && $is_last_200_contracts_time_result && $is_last_qty_buyers_vs_seller_result && $is_last_qty_time_result && $is_score_result) {

			$meet_all_condition_for_rule_1 = true;
		}

		var_dump($meet_all_condition_for_rule_1);

		$response_message = 'NO';
		if ($meet_all_condition_for_rule_1) {
			$response_message = 'YES';
		}

		$data['Rule_' . $rule_number] = $log_arr;
		$data['response_message'] = $response_message;

		return $data;
	} //End of Function

	public function is_score($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $score) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_score = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($score >= $recommended_score) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_score' . $rule . '_buy_enable'] = $_status_rule_color;
		$log_arr['score'] = $score;
		$log_arr['recommended_score'] = $recommended_score;

		if (isset($_GET['setting'])) {
			if ($_GET['setting'] == 'onlyon') {
				if ($_status_rule == 'OFF') {
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of is_score

	public function is_last_5_minute_candle_buys_vs_seller($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $sellers_buyers_per) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_last_5_minute_candle_buys_vs_seller = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($sellers_buyers_per >= $recommended_last_5_minute_candle_buys_vs_seller) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_5_minute_candle_buys_vs_seller' . $rule . '_buy_enable'] = $_status_rule_color;
		$log_arr['last_5_minute_candle_buys_vs_seller'] = $sellers_buyers_per;
		$log_arr['recommended_last_5_minute_candle_buys_vs_seller'] = $recommended_last_5_minute_candle_buys_vs_seller;
		if (isset($_GET['setting'])) {
			if ($_GET['setting'] == 'onlyon') {
				if ($_status_rule == 'OFF') {
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of is_last_5_minute_candle_buys_vs_seller

	public function is_last_qty_time($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_qty_time_ago) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_last_qty_time = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($last_qty_time_ago <= $recommended_last_qty_time) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_qty_time' . $rule . '_buy_enable'] = $_status_rule_color;
		$log_arr['is_last_qty_time'] = $last_qty_time_ago;
		$log_arr['recommended_last_qty_time'] = $recommended_last_qty_time;

		if (isset($_GET['setting'])) {
			if ($_GET['setting'] == 'onlyon') {
				if ($_status_rule == 'OFF') {
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of is_last_qty_time

	public function is_last_qty_buyers_vs_seller($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_qty_buy_vs_sell) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_is_last_qty_buyers_vs_seller = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($last_qty_buy_vs_sell >= $recommended_is_last_qty_buyers_vs_seller) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_qty_buyers_vs_seller' . $rule . '_buy_enable'] = $_status_rule_color;
		$log_arr['last_qty_buyers_vs_seller'] = $last_qty_buy_vs_sell;
		$log_arr['recommended_is_last_qty_buyers_vs_seller'] = $recommended_is_last_qty_buyers_vs_seller;

		if (isset($_GET['setting'])) {
			if ($_GET['setting'] == 'onlyon') {
				if ($_status_rule == 'OFF') {
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of is_last_qty_buyers_vs_seller

	public function is_last_200_contracts_time($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_200_time_ago) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_is_last_200_contracts_time = $global_setting_arr[$rule_name];
			$last_200_time_ago_1 = (float) $last_200_time_ago;
			$_status_rule = '<span style="color:red">NO</span>';
			if ($last_200_time_ago_1 <= $recommended_is_last_200_contracts_time) {
				$_status_rule = 'YES';

			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_200_contracts_time' . $rule . '_buy_enable'] = $_status_rule_color;
		$log_arr['last_200_contracts_time'] = $last_200_time_ago;
		$log_arr['recommended_last_200_contracts_time'] = $recommended_is_last_200_contracts_time;

		if (isset($_GET['setting'])) {
			if ($_GET['setting'] == 'onlyon') {
				if ($_status_rule == 'OFF') {
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of is_last_200_contracts_time

	public function is_last_200_contracts_buy_vs_sell($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_200_buy_vs_sell) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_last_200_contracts_buy_vs_sell = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($last_200_buy_vs_sell >= $recommended_last_200_contracts_buy_vs_sell) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_200_contracts_buy_vs_sell_' . $rule . '_buy_enable'] = $_status_rule_color;
		$log_arr['last_200_buy_vs_sell'] = $last_200_buy_vs_sell;
		$log_arr['recommended_last_200_contracts_buy_vs_sell'] = $recommended_last_200_contracts_buy_vs_sell;
		if (isset($_GET['setting'])) {
			if ($_GET['setting'] == 'onlyon') {
				if ($_status_rule == 'OFF') {
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of is_last_200_contracts_buy_vs_sell

	public function is_rejection_candle($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_candle_rejection_status) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_last_rejection_candle = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($last_candle_rejection_status == $recommended_last_rejection_candle) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_rejection_candle_' . $rule . '_buy_enable'] = $_status_rule_color;
		$log_arr['last_rejection_candle_type'] = $last_candle_rejection_status;
		$log_arr['recommended_rejection_candle_type'] = $recommended_last_rejection_candle;
		if (isset($_GET['setting'])) {
			if ($_GET['setting'] == 'onlyon') {
				if ($_status_rule == 'OFF') {
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of is_rejection_candle

	public function is_candle_type($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_candle_type) {
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_candle_type = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($last_candle_type == $recommended_candle_type) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['Candle_type_' . $rule . '_buy_enable'] = $_status_rule_color;
		$log_arr['last_candle_type'] = $last_candle_type;
		$log_arr['recommended_candle_type'] = $recommended_candle_type;
		if (isset($_GET['setting'])) {
			if ($_GET['setting'] == 'onlyon') {
				if ($_status_rule == 'OFF') {
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of is_candle_type

	public function buy_rule_status($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $start_date) {
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];

		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$current_swing_point = $this->mod_barrier_trigger_simulator->get_status($coin_symbol, $start_date);
			$swing_status = (array) $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if (in_array($current_swing_point, $swing_status)) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {

			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_swing_status_buy_' . $rule . '_yes'] = $_status_rule_color;
		$log_arr['current_swing_point'] = $current_swing_point;
		$log_arr['Recommended_swing_status'] = implode('--', $swing_status);

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of buy_status

	public function buy_rule_barrier_volume($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $rule_number, $market_value, $start_date) {
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';

		if ($_enable_disable_rule == 'yes') {
			$current_market_price = (float) $market_value;
			$range_percentage = $global_setting_arr['buy_range_percet'];

			/////////////////Barrier Type ///////////////////////////
			$rule_on_off = 'buy_trigger_type_rule_' . $rule_number . '_enable';
			$rule_name = 'buy_trigger_type_rule_' . $rule_number;

			$trigger_type = $this->buy_rule_trigger($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $current_market_price, $start_date);

			$trigger_type_log_arr = $trigger_type['log_arr'];
			$log_arr['is_trigger_status_buy_Rule_1_yes'] = $trigger_type_log_arr['is_trigger_status_buy_Rule_1_yes'];
			$log_arr['Recommended_trigger_status'] = $trigger_type_log_arr['Recommended_trigger_status'];
			$log_arr['last_barrier_value'] = $trigger_type_log_arr['last_barrier_value'];

			$last_barrrier_value = $trigger_type_log_arr['last_barrier_value'];
			$barrier_value_range = $last_barrrier_value + ($last_barrrier_value / 100) * $range_percentage;

			$meet_condition_for_buy = false;

			if ((num($current_market_price) >= num($last_barrrier_value)) && (num($current_market_price) <= num($barrier_value_range))) {
				$meet_condition_for_buy = true;
			}

			if ($meet_condition_for_buy) {

				$coin_offset_value = $this->mod_coins->get_coin_offset_value($coin_symbol);
				$coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);

				$total_bid_quantity = 0;
				for ($i = 0; $i < $coin_offset_value; $i++) {
					$new_last_barrrier_value = '';
					$new_last_barrrier_value = $last_barrrier_value - ($coin_unit_value * $i);
					$bid = $this->mod_barrier_trigger_simulator->get_market_quantity($coin_symbol, $start_date, $new_last_barrrier_value, $type = 'bid');
					$total_bid_quantity += $bid;
				} //End of Coin off Set

				$bid_quantity = $total_bid_quantity;
				$bid_volume = $global_setting_arr['buy_volume_rule_' . $rule_number];
				if ($bid_quantity >= $bid_volume) {
					$_status_rule = 'YES';
				} else {
					$_status_rule = '<span style="color:red">NO</span>';
				}
				$log_arr['total_bid_quantity_for_barrier_range'] = $total_bid_quantity;
				$log_arr['Recommended_bid_quantity'] = $bid_volume;

			} else {
				$_status_rule = '<span style="color:red">NO</span>';
			} //End of Meet barrier

			$log_arr['current_market_price'] = num($current_market_price);
			$log_arr['last_barrrier_value'] = num($last_barrrier_value);
			$log_arr['barrier_value_range'] = num($barrier_value_range);
			$log_arr['bid_quantity'] = $bid_quantity;
		} //End of enable disable rule

		if ($_status_rule == 'YES') {

			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_bid_quantity_buy_' . $rule . '_yes'] = $_status_rule_color;
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of barrier_volume_buy_rule

	public function buy_rule_trigger($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $c_price, $start_date) {
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$current_barrier_status = $this->mod_barrier_trigger_simulator->get_current_barrier_status($coin_symbol, $c_price, $start_date);
			$barrier_status = (array) $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			$last_barrier_value = '';
			if (count($current_barrier_status) > 0) {
				foreach ($current_barrier_status as $row) {
					if (in_array($row['barrier_status'], $barrier_status)) {
						$_status_rule = 'YES';
						$last_barrier_value = $row['barier_value'];
						break;
					}
				} //End Of
			} //End Of if Barrier is Greater
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}
		$log_arr['is_trigger_status_buy_' . $rule . '_yes'] = $_status_rule_color;
		$log_arr['current_trigger_status'] = $current_barrier_status;
		$log_arr['Recommended_trigger_status'] = implode('--', $barrier_status);
		$log_arr['last_barrier_value'] = num($last_barrier_value);
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of buy_rule_trigger

	public function buy_rule_down_pressure($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $current_down_pressure) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_pressure = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($current_down_pressure >= $recommended_pressure) {
				$_status_rule = 'YES';
			}

		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {

			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_down_pressure_buy_' . $rule . '_yes'] = $_status_rule_color;
		$log_arr['current_down_pressure'] = $current_down_pressure;
		$log_arr['recommended_down_pressure'] = $recommended_pressure;

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of buy_rule_down_pressure

	public function buy_rule_big_seller($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $ask_percent) {
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_percentage = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($ask_percent >= $recommended_percentage) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_big_seller_buy_' . $rule . '_yes'] = $_status_rule_color;
		$log_arr['big_seller_percentage'] = $ask_percent;
		$log_arr['recommended_percentage'] = $recommended_percentage;
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of buy_rule_big_seller

	public function buy_rule_black_wall($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $closest_black_bottom_wall_value) {
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_closest_black_wall = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($closest_black_bottom_wall_value >= $recommended_closest_black_wall) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_big_black_closest_wall_buy_' . $rule . '_yes'] = $_status_rule_color;
		$log_arr['closest_black_bottom_wall_value'] = $closest_black_bottom_wall_value;
		$log_arr['recommended_closest_black_wall'] = $recommended_closest_black_wall;

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of buy_rule_black_wall

	public function buy_rule_yellow_wall($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $closest_yelllow_bottom_wall_value) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {

			$recommended_closest_yellow_wall = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if ($closest_yelllow_bottom_wall_value >= $recommended_closest_yellow_wall) {
				$_status_rule = 'YES';
			}

		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {

			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}
		$log_arr['is_big_yellow_closest_wall_buy_' . $rule . '_yes'] = $_status_rule_color;
		$log_arr['closest_yellow_bottom_wall_value'] = $closest_yelllow_bottom_wall_value;
		$log_arr['recommended_closest_yellow_bottom_wall_value'] = $recommended_closest_yellow_wall;

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of buy_rule_black_wall

	public function buy_rule_seven_level($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $seven_levele_pressure_value) {
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_seven_levele_pressure_value = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($seven_levele_pressure >= $recommended_seven_levele_pressure_value) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_seven_levele_pressure_buy_' . $rule . '_yes'] = $_status_rule_color;
		$log_arr['seven_levele_pressure_value'] = $seven_levele_pressure_value;
		$log_arr['recommended_seven_levele_pressure_value'] = $recommended_seven_levele_pressure_value;
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of buy_rule_seven_level

	public function buyer_vs_seller($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $current_buyer_vs_seller) {
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_buyer_vs_seller = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($current_buyer_vs_seller >= $recommended_buyer_vs_seller) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['buyer_vs_seller_rule_' . $rule . '_buy_enable'] = $_status_rule_color;
		$log_arr['current_buyer_vs_seller'] = $current_buyer_vs_seller;
		$log_arr['recommended_buyer_vs_seller'] = $recommended_buyer_vs_seller;
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of buyer_vs_seller

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           ////////////////////////////////
	////////////////////  Create and Buy Orders    /////////////////////////////////
	////////////////////                           ////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function go_buy_barrier_trigger_order($date, $current_market_price, $coin_symbol, $sell_per, $stop_loss_percent, $log_arr, $show_error_log, $aggressive_stop_rule) {

		$parent_orders_arr = $this->mod_barrier_trigger_simulator->get_parent_orders($coin_symbol);

		$log_msg_success = '';
		foreach ($log_arr as $key => $value) {
			$log_msg_success .= $key . '  :  ' . $value . '<br>';
		}

		$coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);

		if (count($parent_orders_arr) > 0) {
			foreach ($parent_orders_arr as $buy_orders) {
				$buy_parent_id = $buy_orders['_id'];
				$coin_symbol = $buy_orders['symbol'];
				$buy_quantity = $buy_orders['quantity'];
				$buy_trigger_type = $buy_orders['trigger_type'];
				$admin_id = $buy_orders['admin_id'];
				$application_mode = $buy_orders['application_mode'];
				$order_mode = $buy_orders['order_mode'];
				$defined_sell_percentage = $buy_orders['defined_sell_percentage'];

				$sell_price = $current_market_price + ($current_market_price * $sell_per) / 100;

				$iniatial_trail_stop = $current_market_price - ($current_market_price / 100) * $stop_loss_percent;

				$ins_data_buy_order = array(
					'price' => $current_market_price,
					'quantity' => $buy_quantity,
					'symbol' => $coin_symbol,
					'order_type' => 'MARKET_ORDER',
					'admin_id' => $admin_id,
					'trigger_type' => 'barrier_trigger',
					'sell_price' => $sell_price,
					'created_date' => $this->mongo_db->converToMongodttime($date),
					'modified_date' => $this->mongo_db->converToMongodttime($date),
					'buy_date' => $this->mongo_db->converToMongodttime($date),
					'trail_check' => 'no',
					'trail_interval' => '0',
					'buy_trail_price' => '0',
					'auto_sell' => 'no',
					'buy_parent_id' => $buy_parent_id,
					'iniatial_trail_stop' => $iniatial_trail_stop,
					'iniatial_trail_stop_copy' => $iniatial_trail_stop,
					'buy_order_status_new_filled' => 'wait_for_buyed',
					'application_mode' => $application_mode,
					'order_mode' => $order_mode,
					'defined_sell_percentage' => $defined_sell_percentage,
				);

				$check_exist = $this->mod_barrier_trigger->check_of_previous_buy_order_exist_for_current_user($admin_id, $buy_parent_id);

				if ($check_exist) {

					$ins_data_buy_order['is_sell_order'] = 'yes';
					$ins_data_buy_order['status'] = 'FILLED';
					$ins_data_buy_order['market_value'] = $current_market_price;

					$buy_order_id = $this->mongo_db->insert('buy_orders', $ins_data_buy_order);

					$log_msg = "<span style='color:red'>Test simulator</span> Order was Buyed at Price " . number_format($current_market_price, 8);
					$this->mod_barrier_trigger->insert_order_history_log($buy_order_id, $log_msg, 'buy_created', $admin_id, $date);

					$this->mod_barrier_trigger->insert_developer_log($buy_order_id, $log_msg_success, 'Message', $date, $show_error_log);

					////////////////////////////// End Order History Log /////////////////////////
					//////////////////////////////////////////////////////////////////////////////
					////////////////////// Set Notification //////////////////
					$message = "Buy Market Order is <b>buyed</b> as status Filled market_price=" . number_format($current_market_price, 8) . "  buy_price  " . number_format($buy_price, 8);
					$this->mod_barrier_trigger->add_notification($buy_order_id, 'buy', $message, $admin_id);
					//////////////////////////////////////////////////////////
					//Check Market History
					$commission = $buy_quantity * (0.001);
					$commissionAsset = str_replace('BTC', '', $symbol);
					//Check Market History
					//////////////////////////////////////////////////////////////////////////////////////////////
					////////////////////////////// Order History Log /////////////////////////////////////////////
					$log_msg = "Broker Fee <b>" . num($commission) . " " . $commissionAsset . "</b> has token on this Trade";
					$this->mod_barrier_trigger->insert_order_history_log($buy_order_id, $log_msg, 'buy_commision', $admin_id, $date);
					////////////////////////////// End Order History Log /////////////////////////////////////////
					//////////////////////////////////////////////////////////////////////////////////////////////

					$ins_data = array(
						'symbol' => $coin_symbol,
						'purchased_price' => ($current_market_price),
						'quantity' => $buy_quantity,
						'profit_type' => 'percentage',
						'order_type' => 'MARKET_ORDER',
						'admin_id' => $admin_id,
						'buy_order_check' => 'yes',
						'buy_order_id' => $buy_order_id,
						'buy_order_binance_id' => '',
						'stop_loss' => 'no',
						'loss_percentage' => '',
						'created_date' => $this->mongo_db->converToMongodttime($date),
						'modified_date' => $this->mongo_db->converToMongodttime($created_date),
						'market_value' => $current_market_price,
						'application_mode' => $application_mode,
						'order_mode' => $order_mode,
						'trigger_type' => $buy_trigger_type,
					);

					$ins_data['sell_profit_percent'] = 2;
					$ins_data['sell_price'] = $sell_price;

					$ins_data['trail_check'] = 'no';
					$ins_data['trail_interval'] = '0';
					$ins_data['sell_trail_price'] = '0';
					$ins_data['status'] = 'new';
					$order_id = $this->mongo_db->insert('orders', $ins_data);

					$upd_data22 = array(
						'sell_order_id' => $order_id,
						'is_sell_order' => 'yes',

					);
					$this->mongo_db->where(array('_id' => $buy_order_id));
					$this->mongo_db->set($upd_data22);
					//Update data in mongoTable
					$this->mongo_db->update('buy_orders');
				} //if open trade Exist

			} //End of parent order array
		} //End of parent ordr count
	} //End of buy_barrier_trigger_order

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           ////////////////////////////////
	////////////////////  SELL SECTION             /////////////////////////////////
	////////////////////                           ////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function go_sell($coin_symbol, $rule_number, $historical_data, $start_date) {
		extract($historical_data);

		$date = date('Y-m-d H:00:00');
		$triggers_type = 'barrier_trigger';
		$order_mode = 'test';
		$rule = 'Rule_' . $rule_number;

		$global_setting_arr = $this->mod_barrier_trigger->get_trigger_global_setting($triggers_type, $order_mode, $coin_symbol);
		$global_setting_arr = $global_setting_arr[0];

		$log_arr = array('Message_type' => '*******SEll Message**');

		$rule_on_off_setting = $global_setting_arr['enable_sell_rule_no_' . $rule_number];

		if ($rule_on_off_setting == 'not' || $rule_on_off_setting == '') {

			$log_arr['Rule_NO_' . $rule_number . '_Off'] = '<span style="color:red">OFF</span>';
			return $log_arr;
		}

		$data['sell_percent_rule_' . $rule_number] = $global_setting_arr['sell_percent_rule_' . $rule_number];

		$rule_on_off = 'sell_status_rule_' . $rule_number . '_enable';
		$rule_name = 'sell_status_rule_' . $rule_number;

		$status_rule_1 = $this->sell_rule_status($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $start_date);

		$log_arr = (array_merge($log_arr, $status_rule_1['log_arr']));

		$status_rule_1_result = false;
		if ($status_rule_1['success_message'] == 'YES' || $status_rule_1['success_message'] == 'OFF') {
			$status_rule_1_result = true;
		}

		$rule_on_off = 'sell_check_volume_rule_' . $rule_number;
		$rule_name = 'sell_volume_rule_' . $rule_number;

		$barrier_volume_rule_1 = $this->sell_rule_barrier_volume($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $rule_number, $current_market_value, $start_date);

		$log_arr = (array_merge($log_arr, $barrier_volume_rule_1['log_arr']));

		$barrier_volume_rule_1_result = false;
		if ($barrier_volume_rule_1['success_message'] == 'YES' || $barrier_volume_rule_1['success_message'] == 'OFF') {
			$barrier_volume_rule_1_result = true;
		}

		$rule_on_off = 'done_pressure_rule_' . $rule_number . '_enable';
		$rule_name = 'done_pressure_rule_' . $rule_number;

		$down_pressure_rule_1 = $this->sell_rule_down_pressure($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $pressure_diff);

		$log_arr = (array_merge($log_arr, $down_pressure_rule_1['log_arr']));

		$down_pressure_rule_1_result = false;
		if ($down_pressure_rule_1['success_message'] == 'YES' || $down_pressure_rule_1['success_message'] == 'OFF') {
			$down_pressure_rule_1_result = true;
		}

		$rule_on_off = 'big_seller_percent_compare_rule_' . $rule_number . '_enable';
		$rule_name = 'big_seller_percent_compare_rule_' . $rule_number;

		$big_seller_rule_1 = $this->sell_rule_big_seller($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $bid_percentage);

		$log_arr = (array_merge($log_arr, $big_seller_rule_1['log_arr']));

		$big_seller_rule_1_rule_1_result = false;
		if ($big_seller_rule_1['success_message'] == 'YES' || $big_seller_rule_1['success_message'] == 'OFF') {
			$big_seller_rule_1_rule_1_result = true;
		}

		$rule_on_off = 'closest_black_wall_rule_' . $rule_number . '_enable';
		$rule_name = 'closest_black_wall_rule_' . $rule_number;

		$black_wall_rule_1 = $this->sell_rule_black_wall($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $black_wall_pressure);

		$log_arr = (array_merge($log_arr, $black_wall_rule_1['log_arr']));

		$black_wall_rule_1_result = false;
		if ($black_wall_rule_1['success_message'] == 'YES' || $black_wall_rule_1['success_message'] == 'OFF') {
			$black_wall_rule_1_result = true;
		}

		$rule_on_off = 'closest_yellow_wall_rule_' . $rule_number . '_enable';
		$rule_name = 'closest_yellow_wall_rule_' . $rule_number;

		$yellow_wall_rule_1 = $this->sell_rule_yellow_wall($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $yellow_wall_pressure);

		$log_arr = (array_merge($log_arr, $yellow_wall_rule_1['log_arr']));

		$yellow_wall_rule_1_result = false;
		if ($yellow_wall_rule_1['success_message'] == 'YES' || $yellow_wall_rule_1['success_message'] == 'OFF') {
			$yellow_wall_rule_1_result = true;
		}

		$rule_on_off = 'seven_level_pressure_rule_' . $rule_number . '_enable';
		$rule_name = 'seven_level_pressure_rule_' . $rule_number;

		$seven_level_rule_1 = $this->sell_rule_seven_level($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $seven_level_depth);

		$log_arr = (array_merge($log_arr, $seven_level_rule_1['log_arr']));

		$seven_level_rule_1_result = false;
		if ($seven_level_rule_1['success_message'] == 'YES' || $seven_level_rule_1['success_message'] == 'OFF') {
			$seven_level_rule_1_result = true;
		}

		/****************seller_vs_buyer_rule_1_sell **************/
		$rule_on_off = 'seller_vs_buyer_rule_' . $rule_number . '_sell_enable';
		$rule_name = 'seller_vs_buyer_rule_' . $rule_number . '_sell';

		$seller_vs_buyer_rule = $this->seller_vs_buyer($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $sellers_buyers_per);

		$log_arr = (array_merge($log_arr, $seller_vs_buyer_rule['log_arr']));

		$seller_vs_buyer_rule_result = false;
		if ($seller_vs_buyer_rule['success_message'] == 'YES' || $seller_vs_buyer_rule['success_message'] == 'OFF') {
			$seller_vs_buyer_rule_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'sell_last_candle_type' . $rule_number . '_enable';
		$rule_name = 'last_candle_type' . $rule_number . '_sell';

		$is_candle_type = $this->is_candle_type_sell($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_candle_type);

		$log_arr = (array_merge($log_arr, $is_candle_type['log_arr']));

		$is_last_candle_type_result = false;
		if ($is_candle_type['success_message'] == 'YES' || $is_candle_type['success_message'] == 'OFF') {
			$is_last_candle_type_result = true;
		}
		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'sell_rejection_candle_type' . $rule_number . '_enable';
		$rule_name = 'rejection_candle_type' . $rule_number . '_sell';

		$is_rejection_candle = $this->is_rejection_candle_sell($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_candle_rejection_status);

		$log_arr = (array_merge($log_arr, $is_rejection_candle['log_arr']));

		$is_rejection_candle_result = false;
		if ($is_rejection_candle['success_message'] == 'YES' || $is_rejection_candle['success_message'] == 'OFF') {
			$is_rejection_candle_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'sell_last_200_contracts_buy_vs_sell' . $rule_number . '_enable';
		$rule_name = 'last_200_contracts_buy_vs_sell' . $rule_number . '_sell';
		$is_last_200_contracts_buy_vs_sell = $this->is_last_200_contracts_buy_vs_sell_rule($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_200_buy_vs_sell);

		$log_arr = (array_merge($log_arr, $is_last_200_contracts_buy_vs_sell['log_arr']));

		$is_last_200_contracts_buy_vs_sell_result = false;
		if ($is_last_200_contracts_buy_vs_sell['success_message'] == 'YES' || $is_last_200_contracts_buy_vs_sell['success_message'] == 'OFF') {
			$is_last_200_contracts_buy_vs_sell_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'sell_last_200_contracts_time' . $rule_number . '_enable';
		$rule_name = 'last_200_contracts_time' . $rule_number . '_sell';

		$is_last_200_contracts_time = $this->is_last_200_contracts_time_sell($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_200_time_ago);
		$log_arr = (array_merge($log_arr, $is_last_200_contracts_time['log_arr']));

		$is_last_200_contracts_time_result = false;
		if ($is_last_200_contracts_time['success_message'] == 'YES' || $is_last_200_contracts_time['success_message'] == 'OFF') {
			$is_last_200_contracts_time_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'sell_last_qty_buyers_vs_seller' . $rule_number . '_enable';
		$rule_name = 'last_qty_buyers_vs_seller' . $rule_number . '_sell';

		$is_last_qty_buyers_vs_seller = $this->is_last_qty_buyers_vs_seller_sell($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_qty_buy_vs_sell);

		$log_arr = (array_merge($log_arr, $is_last_qty_buyers_vs_seller['log_arr']));

		$is_last_qty_buyers_vs_seller_result = false;
		if ($is_last_qty_buyers_vs_seller['success_message'] == 'YES' || $is_last_qty_buyers_vs_seller['success_message'] == 'OFF') {
			$is_last_qty_buyers_vs_seller_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'sell_last_qty_time' . $rule_number . '_enable';
		$rule_name = 'last_qty_time' . $rule_number . '_sell';

		$is_last_qty_time = $this->is_last_qty_time_sell($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_qty_time_ago);

		$log_arr = (array_merge($log_arr, $is_last_qty_time['log_arr']));

		$is_last_qty_time_result = false;
		if ($is_last_qty_time['success_message'] == 'YES' || $is_last_qty_time['success_message'] == 'OFF') {
			$is_last_qty_time_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/
		$rule_on_off = 'sell_score' . $rule_number . '_enable';
		$rule_name = 'score' . $rule_number . '_sell';

		$is_score = $this->is_score_sell($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $score);

		$log_arr = (array_merge($log_arr, $is_score['log_arr']));

		$is_score_result = false;
		if ($is_score['success_message'] == 'YES' || $is_score['success_message'] == 'OFF') {
			$is_score_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		/****************End seller_vs_buyer_rule_1_sell **************/

		$meet_all_condition_for_rule_1 = false;
		if ($status_rule_1_result && $barrier_volume_rule_1_result && $down_pressure_rule_1_result && $big_seller_rule_1_rule_1_result && $black_wall_rule_1_result && $yellow_wall_rule_1_result && $seven_level_rule_1_result && $seller_vs_buyer_rule_result & $is_last_candle_type_result && $is_rejection_candle_result && $is_last_200_contracts_buy_vs_sell_result && $is_last_200_contracts_time_result && $is_last_qty_buyers_vs_seller_result && $is_last_qty_time_result && $is_score_result) {
			$meet_all_condition_for_rule_1 = true;
		}

		$response_message = 'NO';
		if ($meet_all_condition_for_rule_1) {
			$response_message = 'YES';
		}

		$data['Rule_' . $rule_number] = $log_arr;
		$data['response_message'] = $response_message;
		return $data;
	} //End of Function

	//########################################
	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	//****************************************
	public function sell_rule_status($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $start_date) {
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';

		if ($_enable_disable_rule == 'yes') {

			$current_swing_point = $this->mod_barrier_trigger_simulator->get_status($coin_symbol, $start_date);

			$swing_status = (array) $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if (in_array($current_swing_point, $swing_status)) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		$log_arr['is_swing_status_sell_' . $rule] = $_status_rule;
		$log_arr['current_swing_point'] = $current_swing_point;
		$log_arr['Recommended_swing_status'] = implode('--', $swing_status);
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of buy_status

	public function sell_rule_barrier_volume($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $rule_number, $current_market_price, $start_date) {
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {

			$range_percentage = $global_setting_arr['range_previous_barrier_values'];

			///////////////////////////
			//////////////////////////////
			///////////////////////

			/////////////////Barrier Type ///////////////////////////

			$rule_on_off = 'sell_trigger_type_rule_' . $rule_number . '_enable';
			$rule_name = 'sell_trigger_type_rule_' . $rule_number;

			$trigger_type = $this->sell_rule_trigger($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $current_market_price, $start_date);

			$trigger_type_log_arr = $trigger_type['log_arr'];

			$log_arr['Recommended_trigger_status'] = $trigger_type_log_arr['Recommended_trigger_status'];

			$log_arr['last_barrier_value'] = $trigger_type_log_arr['last_barrier_value'];

			$last_barrrier_value = $trigger_type_log_arr['last_barrier_value'];

			//////////////////////////
			//////////////////////
			///////////////

			$barrier_value_range = $last_barrrier_value - ($last_barrrier_value / 100) * $range_percentage;

			$log_arr['barrier_value_range'] = num($barrier_value_range);

			$log_arr['current_market_price'] = num($current_market_price);

			$meet_condition_for_sell = false;

			if ((num($current_market_price) <= num($last_barrrier_value)) && (num($current_market_price) >= num($barrier_value_range))) {
				$meet_condition_for_sell = true;
			}

			if ($meet_condition_for_sell) {

				$coin_offset_value = $this->mod_coins->get_coin_offset_value($coin_symbol);
				$coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);

				$total_bid_quantity = 0;
				for ($i = 0; $i < $coin_offset_value; $i++) {
					$new_last_barrrier_value = '';
					$new_last_barrrier_value = $last_barrrier_value - ($coin_unit_value * $i);
					$ask = $this->mod_barrier_trigger_simulator->get_market_quantity($coin_symbol, $start_date, $new_last_barrrier_value, $type = 'ask');
					$total_bid_quantity += $ask;
				} //End of Coin off Set

				$bid_quantity = $total_bid_quantity;
				$log_arr['ask_quantity'] = $bid_quantity;

				$rl_ = 'sell_volume_rule_' . $rule_number;

				$bid_volume = $global_setting_arr[$rl_];

				if ($bid_quantity >= $bid_volume) {
					$_status_rule = 'YES';
				} else {

					$_status_rule = '<span style="color:red">NO</span>';
				}

				$log_arr['Recommended_ask_quantity'] = $bid_volume;

			} else {
				$_status_rule = '<span style="color:red">NO</span>';
			} //End of Meet barrier

		} //End of enable disable rule

		$log_arr['is_ask_quantity_sell_' . $rule] = $_status_rule;
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of sell_rule_barrier_volume

	public function sell_rule_trigger($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $current_market_price, $start_date) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];

		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {

			$current_barrier_status = $this->mod_barrier_trigger_simulator->get_current_barrier_status_up($coin_symbol, $current_market_price, $start_date);

			$barrier_status = (array) $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			$last_barrier_value = '';
			if (count($current_barrier_status) > 0) {
				foreach ($current_barrier_status as $row) {
					if (in_array($row['barrier_status'], $barrier_status)) {
						$_status_rule = 'YES';
						$last_barrier_value = $row['barier_value'];
						$log_arr['last_barrier_value'] = num($last_barrier_value);
						break;
					}
				} //End Of
			} //End Of if Barrier is Greater

		} //End of buy_status_rule_1_enable

		//echo num($last_barrier_value);
		if ($_status_rule == 'YES') {

			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_trigger_status_sell_' . $rule . '_yes'] = $_status_rule_color;
		$log_arr['current_trigger_status'] = $current_barrier_status;
		$log_arr['Recommended_trigger_status'] = implode('--', $barrier_status);

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of buy_rule_trigger

	public function sell_rule_down_pressure($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $current_down_pressure) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {

			$recommended_pressure = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if ($current_down_pressure <= $recommended_pressure) {
				$_status_rule = 'YES';
			}

		} //End of buy_status_rule_1_enable

		$log_arr['is_down_pressure_sell_' . $rule] = $_status_rule;
		$log_arr['current_down_pressure'] = $current_down_pressure;
		$log_arr['recommended_down_pressure'] = $recommended_pressure;

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of sell_rule_down_pressure

	public function sell_rule_big_seller($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $bid_percent) {
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {

			$recommended_percentage = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if ($bid_percent <= $recommended_percentage) {
				$_status_rule = 'YES';
			}

		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {

			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_big_seller_sell_' . $rule] = $_status_rule_color;
		$log_arr['big_seller_percentage'] = $bid_percent;
		$log_arr['recommended_percentage'] = $recommended_percentage;

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of sell_rule_big_seller

	public function sell_rule_black_wall($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $closest_black_bottom_wall_value) {
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {

			$recommended_closest_black_wall = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if ($closest_black_bottom_wall_value <= $recommended_closest_black_wall) {
				$_status_rule = 'YES';
			}

		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {

			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_big_black_closest_wall_sell_' . $rule] = $_status_rule_color;
		$log_arr['closest_black_wall_value'] = $closest_black_bottom_wall_value;
		$log_arr['recommended_closest_black_wall'] = $recommended_closest_black_wall;

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of sell_rule_black_wall

	public function sell_rule_yellow_wall($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $closest_yelllow_bottom_wall_value) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {

			$recommended_closest_yellow_wall = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if ($closest_yelllow_bottom_wall_value <= $recommended_closest_yellow_wall) {
				$_status_rule = 'YES';
			}

		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {

			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_big_yellow_closest_wall_sell_' . $rule] = $_status_rule_color;
		$log_arr['closest_yellow_bottom_wall_value'] = $closest_yelllow_bottom_wall_value;
		$log_arr['recommended_closest_yellow_wall_value'] = $recommended_closest_yellow_wall;

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of sell_rule_yellow_wall

	public function sell_rule_seven_level($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $seven_levele_pressure_value) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];

		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_seven_levele_pressure_value = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if ($seven_levele_pressure <= $recommended_seven_levele_pressure_value) {
				$_status_rule = 'YES';
			}

		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {

			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_seven_levele_pressure_sell_' . $rule] = $_status_rule_color;
		$log_arr['seven_levele_pressure_value'] = $seven_levele_pressure_value;
		$log_arr['recommended_seven_levele_pressure_value'] = $recommended_seven_levele_pressure_value;

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of sell_rule_seven_level

	public function seller_vs_buyer($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $current_seller_vs_buyer) {
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {

			$recommended_seller_vs_buyer = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if ($current_seller_vs_buyer <= $recommended_seller_vs_buyer) {
				$_status_rule = 'YES';
			}

		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {

			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['seller_vs_buyer_rule_' . $rule . '_buy_enable'] = $_status_rule_color;
		$log_arr['current_seller_vs_buyer'] = $current_seller_vs_buyer;
		$log_arr['recommended_seller_vs_buyer'] = $recommended_seller_vs_buyer;

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of seller_vs_buyer

	public function is_candle_type_sell($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_candle_type) {
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_candle_type = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($last_candle_type == $recommended_candle_type) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['Candle_type_' . $rule . '_sell_enable'] = $_status_rule_color;
		$log_arr['last_candle_type'] = $last_candle_type;
		$log_arr['recommended_candle_type'] = $recommended_candle_type;
		if (isset($_GET['setting'])) {
			if ($_GET['setting'] == 'onlyon') {
				if ($_status_rule == 'OFF') {
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of is_candle_type

	public function is_rejection_candle_sell($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_candle_rejection_status) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_last_rejection_candle = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($last_candle_rejection_status == $recommended_last_rejection_candle) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_rejection_candle_' . $rule . '_sell_enable'] = $_status_rule_color;
		$log_arr['last_rejection_candle_type'] = $last_candle_rejection_status;
		$log_arr['recommended_rejection_candle_type'] = $recommended_last_rejection_candle;

		if (isset($_GET['setting'])) {
			if ($_GET['setting'] == 'onlyon') {
				if ($_status_rule == 'OFF') {
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of is_rejection_candle

	public function is_last_200_contracts_buy_vs_sell_rule($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_200_buy_vs_sell) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_last_200_contracts_buy_vs_sell = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($last_200_buy_vs_sell <= $recommended_last_200_contracts_buy_vs_sell) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_200_contracts_buy_vs_sell_' . $rule . '_sell_enable'] = $_status_rule_color;
		$log_arr['last_200_buy_vs_sell'] = $last_200_buy_vs_sell;
		$log_arr['recommended_last_200_contracts_buy_vs_sell'] = $recommended_last_200_contracts_buy_vs_sell;

		if (isset($_GET['setting'])) {
			if ($_GET['setting'] == 'onlyon') {
				if ($_status_rule == 'OFF') {
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of is_last_200_contracts_buy_vs_sell

	public function is_last_200_contracts_time_sell($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_200_time_ago) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_is_last_200_contracts_time = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			$last_200_time_ago_1 = (float) $last_200_time_ago;
			if ($last_200_time_ago_1 <= $recommended_is_last_200_contracts_time) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_200_contracts_time' . $rule . '_sell_enable'] = $_status_rule_color;
		$log_arr['last_200_contracts_time'] = $last_200_time_ago;
		$log_arr['recommended_last_200_contracts_time'] = $recommended_is_last_200_contracts_time;

		if (isset($_GET['setting'])) {
			if ($_GET['setting'] == 'onlyon') {
				if ($_status_rule == 'OFF') {
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of is_last_200_contracts_time

	public function is_last_qty_buyers_vs_seller_sell($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_qty_buy_vs_sell) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_is_last_qty_buyers_vs_seller = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($last_qty_buy_vs_sell <= $recommended_is_last_qty_buyers_vs_seller) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_qty_buyers_vs_seller' . $rule . '_sell_enable'] = $_status_rule_color;
		$log_arr['last_qty_buyers_vs_seller'] = $last_qty_buy_vs_sell;
		$log_arr['recommended_is_last_qty_buyers_vs_seller'] = $recommended_is_last_qty_buyers_vs_seller;
		if (isset($_GET['setting'])) {
			if ($_GET['setting'] == 'onlyon') {
				if ($_status_rule == 'OFF') {
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of is_last_qty_buyers_vs_seller

	public function is_last_qty_time_sell($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $last_qty_time_ago) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_last_qty_time = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			$last_qty_time_ago_1 = (float) $last_qty_time_ago;
			if ($last_qty_time_ago_1 <= $recommended_last_qty_time) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_qty_time' . $rule . '_sell_enable'] = $_status_rule_color;
		$log_arr['is_last_qty_time'] = $last_qty_time_ago;
		$log_arr['recommended_last_qty_time'] = $recommended_last_qty_time;
		if (isset($_GET['setting'])) {
			if ($_GET['setting'] == 'onlyon') {
				if ($_status_rule == 'OFF') {
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of is_last_qty_time

	public function is_score_sell($coin_symbol, $rule, $rule_name, $rule_on_off, $global_setting_arr, $score) {

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if ($_enable_disable_rule == 'yes') {
			$recommended_score = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if ($score <= $recommended_score) {
				$_status_rule = 'YES';
			}
		} //End of buy_status_rule_1_enable

		if ($_status_rule == 'YES') {
			$_status_rule_color = '<span style="color:green">YES</span>';
		} else {
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_score' . $rule . '_sell_enable'] = $_status_rule_color;
		$log_arr['score'] = $score;
		$log_arr['recommended_score'] = $recommended_score;
		if (isset($_GET['setting'])) {
			if ($_GET['setting'] == 'onlyon') {
				if ($_status_rule == 'OFF') {
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data;
	} //End of is_score

	///////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           ////////////////////////////////
	////////////////////  Sell Order by Profit     /////////////////////////////////
	////////////////////                           ////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function go_sell_orders_on_defined_sell_price($market_price, $coin_symbol, $log_arr, $show_error_log, $admin_sell_percentage, $rule, $start_date) {

		$created_date = date('Y-m-d G:i:s');

		$buy_orders_arr = $this->mod_barrier_trigger_simulator->get_profit_sell_orders($target_sell_price, $coin_symbol);

		$log_message = '';
		foreach ($log_arr as $key => $value) {
			$log_message .= $key . ' =>' . $value . '<br>';
		}

		if (count($buy_orders_arr) > 0) {
			foreach ($buy_orders_arr as $buy_orders) {
				$buy_orders_id = $buy_orders['_id'];
				$coin_symbol = $buy_orders['symbol'];
				$sell_price = $buy_orders['sell_price'];
				$admin_id = $buy_orders['admin_id'];
				$purchased_price = $buy_orders['price'];
				$buy_purchased_price = $buy_orders['market_value'];
				$iniatial_trail_stop = $buy_orders['iniatial_trail_stop'];
				$application_mode = $buy_orders['application_mode'];
				$quantity = $buy_orders['quantity'];
				$order_type = $buy_orders['order_type'];
				$order_mode = $buy_orders['order_mode'];
				$binance_order_id = $buy_orders['binance_order_id'];
				$trigger_type = $buy_orders['trigger_type'];
				$order_id = $buy_orders['sell_order_id'];
				$defined_sell_percentage = $buy_orders['defined_sell_percentage'];
				$market_value = $buy_orders['market_value'];

				$sell_percentage = $admin_sell_percentage;

				if ($defined_sell_percentage) {
					if ($defined_sell_percentage < $admin_sell_percentage) {
						$sell_percentage = $defined_sell_percentage;
					}
				}

				$target_sell_price = $market_value + ($market_value / 100) * $sell_percentage;

				if ($market_price >= $target_sell_price) {

					$this->mod_barrier_trigger->insert_developer_log($buy_orders_id, $log_message, 'Message Sell', $start_date, $show_error_log);

					/////////////////////////////////////
					///////////////////////////////////
					$upd_data = array(
						'buy_order_binance_id' => $binance_order_id,
						'market_value' => $market_price,
						'sell_price' => $market_price,
						'modified_date' => $this->mongo_db->converToMongodttime($start_date),
					);

					$this->mongo_db->where(array('_id' => $order_id));
					$this->mongo_db->set($upd_data);
					$this->mongo_db->update('orders');
					//Insert data in mongoTable

					//Sell With Normal Value
					$upd_data_1 = array(
						'status' => 'FILLED',
					);
					$this->mongo_db->where(array('_id' => $order_id));
					$this->mongo_db->set($upd_data_1);
					//Update data in mongoTable
					$this->mongo_db->update('orders');
					$upd_data = array(
						'sell_order_id' => $order_id,
						'is_sell_order' => 'sold',
						'market_sold_price' => $market_price,
						'modified_date' => $this->mongo_db->converToMongodttime($start_date),
					);
					$this->mongo_db->where(array('_id' => $buy_orders_id));
					$this->mongo_db->set($upd_data);
					//Update data in mongoTable
					$this->mongo_db->update('buy_orders');

					$this->mod_barrier_trigger->save_rules_for_orders($buy_orders_id, $coin_symbol, $order_type = 'sell', $rule, $mode = 'test_live');

					$message = 'Sell Order was Sold With profit';

					//////////////////////////////////////////////////////////////////////////////
					////////////////////////////// Order History Log /////////////////////////////
					$log_msg = $message . " " . number_format($market_price, 8);
					$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'sell_created', $admin_id, $start_date);
					////////////////////////////// End Order History Log /////////////////////////
					//////////////////////////////////////////////////////////////////////////////
					////////////////////// Set Notification //////////////////
					$message = $message . " <b>Sold</b>";
					$this->mod_box_trigger_3->add_notification($buy_orders_id, 'buy', $message, $admin_id);
					//////////////////////////////////////////////////////////
					//Check Market History
					$commission_value = $quantity * (0.001);
					$commission = $commission_value * $with;
					$commissionAsset = 'BTC';
					//////////////////////////////////////////////////////////////////////////////////////////////
					////////////////////////////// Order History Log /////////////////////////////////////////////
					$log_msg = "Broker Fee <b>" . num($commission) . " " . $commissionAsset . "</b> has token on this Trade";
					$created_date = date('Y-m-d G:i:s');
					$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'sell_commision', $admin_id, $start_date);
					////////////////////////////// End Order History Log

				} //if markt price is greater then sell order

			} //End  of forEach buy orders
		} //Check of orders found
	} //End of sell_orders_on_defined_sell_price

	public function run_triggers_auto_sell_and_buy() {

		$trigger_type = $this->input->post('trigger_type');
		$coin = $this->input->post('coin');

		$date = date('Y-m-d H:00:00', strtotime('-0 hour'));
		$this->mongo_db->where('trigger_type', $trigger_type);
		$res = $this->mongo_db->get('buy_trigger_process_log');
		$result_log = iterator_to_array($res);
		$count_log = 0;
		if (count($result_log)) {
			$start_time = $result_log[0]['date'];
			$date = date('Y-m-d H:00:00', strtotime('+0 hour', strtotime($start_time)));
		}

		if ($trigger_type == 'barrier_trigger') {

			$this->create_and_buy_order($coin, $date);

		}

		$this->mongo_db->where('trigger_type', $trigger_type);
		$res = $this->mongo_db->get('buy_trigger_process_log');
		$result_log = iterator_to_array($res);

		$look_forward = 0;
		$count_log = 0;
		if (count($result_log)) {
			$count_log = $result_log[0]['count'];

			$count_log = $count_log + 1;
		}

		$date = date('Y-m-d H:00:00', strtotime('+1 hour', strtotime($date)));

		$this->mongo_db->where('trigger_type', $trigger_type);
		$upd_array = array('date' => $date, 'count' => $count_log, 'sell_Message' => $sell_Message, 'buy_Message' => $buy_Message);
		$this->mongo_db->set($upd_array);

		$this->mongo_db->update('buy_trigger_process_log');

		$look_forward = 0;
		if (count($result_log)) {
			$look_forward = $result_log[0]['look_forward'];
		}

	} //End of  buy_trigger_2

} //En of controller
