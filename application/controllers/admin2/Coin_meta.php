<?php
class Coin_meta extends CI_Controller {

	function __construct() {

		parent::__construct();

		//load main template
		$this->stencil->layout('admin_layout');

		//load required slices
		$this->stencil->slice('admin_header_script');
		$this->stencil->slice('admin_header');
		$this->stencil->slice('admin_left_sidebar');
		$this->stencil->slice('admin_footer_script');
		//load models
		$this->load->model('admin/mod_script');
		$this->load->model('admin/mod_login');
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_chart3');
	}


	public function index($coin_symbol) {

			//Call function at the start of function
		$function_name = 'coin_meta_index'.$coin_symbol;
		$is_function_process_complete = is_function_process_complete($function_name);
		function_start($function_name);

		$is_script_take_more_time = is_script_take_more_time($function_name);

		if($is_script_take_more_time){
			track_execution_of_function_time($function_name);
			function_stop($function_name);
		}

		if(!$is_function_process_complete){
			echo 'previous process is still running';
			return false;
		}

			echo 'start date'.date('y-m-d H:i:s').'<br>';
			//=================================== Buy Sell Array Creation ===================================//


			$biggest_value2 = $this->mod_coins->get_coin_base_order($coin_symbol);

			$biggest_value = $this->mod_coins->get_coin_base_history($coin_symbol);

			$final_array = $this->get_remainder_data($coin_symbol);

			$ask_array = $final_array['asks'];

			$offset = $this->mod_coins->get_coin_offset_value($coin_symbol);

			$chunks = array_chunk($ask_array, $offset);

			$sumArray = array();

			$new_ask_arr = array();

			foreach ($chunks as $key => $valve) {

				$price = $valve[0]['price'];

				$sumArray = array();

				$sell_quantity = 0;

				$depth_buy_quantity = 0;

				$depth_sell_quantity = 0;

				$buy_quantity = 0;

				foreach ($valve as $k => $val) {

					$sell_quantity += $val['sell_quantity'];

					$sumArray['sell_quantity'] = $sell_quantity;

					$depth_buy_quantity += $val['depth_buy_quantity'];

					$sumArray['depth_buy_quantity'] = $depth_buy_quantity;

					$depth_sell_quantity += $val['depth_sell_quantity'];

					$sumArray['depth_sell_quantity'] = $depth_sell_quantity;

					$buy_quantity += $val['buy_quantity'];

					$sumArray['buy_quantity'] = $buy_quantity;

					$sumArray['price'] = $price;

					$sumArray['coin'] = $val['coin'];

					$sumArray['type'] = $val['type'];


				}

				$new_ask_arr[] = $sumArray;

			}

			$market_buy_depth_arr = $new_ask_arr;

			array_multisort(array_column($market_buy_depth_arr, "price"), SORT_ASC, $market_buy_depth_arr);

			$bid_array = $final_array['bid'];

			$chunks = array_chunk($bid_array, $offset);

			$sumArray = array();

			$new_bid_arr = array();

			foreach ($chunks as $key => $valve) {

				$price = $valve[$offset - 1]['price'];

				$sumArray = array();

				$sell_quantity = 0;

				$depth_buy_quantity = 0;

				$depth_sell_quantity = 0;

				$buy_quantity = 0;

				foreach ($valve as $k => $val) {

					$sell_quantity += $val['sell_quantity'];

					$sumArray['sell_quantity'] = $sell_quantity;

					$depth_buy_quantity += $val['depth_buy_quantity'];

					$sumArray['depth_buy_quantity'] = $depth_buy_quantity;

					$depth_sell_quantity += $val['depth_sell_quantity'];

					$sumArray['depth_sell_quantity'] = $depth_sell_quantity;

					$buy_quantity += $val['buy_quantity'];

					$sumArray['buy_quantity'] = $buy_quantity;

					$sumArray['coin'] = $val['coin'];

					$sumArray['type'] = $val['type'];

					$sumArray['price'] = $price;

				}

				$new_bid_arr[] = $sumArray;

			}

			$market_sell_depth_arr = $new_bid_arr;
			//==================================End Buy Sell Array Creation ===================================//


			/******************************** INSERTION IN CHART 3 TABLE *********************/
			$db = $this->mongo_db->customQuery();
			foreach ($market_buy_depth_arr as $key => $value) {
				$db = $this->mongo_db->customQuery();
				$value['created_date'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s"));
				$findArr = array('type' => 'ask', 'coin' => $coin_symbol, 'price' => (float)$value['price']);
				$ins_data = $db->chart3_group->updateOne($findArr, array('$set' => $value), array('upsert' => true));
			}

			foreach ($market_sell_depth_arr as $key => $value) {
				$db = $this->mongo_db->customQuery();
				$value['created_date'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s"));
				$findArr = array('type' => 'bid', 'coin' => $coin_symbol, 'price' => (float)$value['price']);
				$ins_data2 = $db->chart3_group->updateOne($findArr, array('$set' => $value), array('upsert' => true));
			}

			/****************************END INSERTION IN CHART 3 TABLE *********************/
			//===============================Wall Calculation==============================//
			$temp_price_buy = $this->calculate_wall($coin_symbol, $market_buy_depth_arr, 'buy', $biggest_value2);

			$temp_price_buy22 = $this->calculate_yellow_wall($coin_symbol, $market_buy_depth_arr, 'buy', $biggest_value2);

			$temp_price_sell = $this->calculate_wall($coin_symbol, $market_sell_depth_arr, 'sell', $biggest_value2);

			$temp_price_sell22 = $this->calculate_yellow_wall($coin_symbol, $market_sell_depth_arr, 'sell', $biggest_value2);

			array_multisort(array_column($market_buy_depth_arr, "price"), SORT_ASC, $market_buy_depth_arr);
			$bid_diff = $key = array_search($temp_price_sell, array_column($market_sell_depth_arr, 'price'));
			$ask_diff = $key = array_search($temp_price_buy, array_column($market_buy_depth_arr, 'price'));

			$y_bid_diff = $key = array_search($temp_price_sell22, array_column($market_sell_depth_arr, 'price'));
			$y_ask_diff = $key = array_search($temp_price_buy22, array_column($market_buy_depth_arr, 'price'));

			if ($bid_diff >= $ask_diff) {
				$black_type = "negitive";
			} else {
				$black_type = 'positive';
			}
			$black_wall_difference = $ask_diff - $bid_diff;
			if ($y_bid_diff >= $y_ask_diff) {
				$yellow_type = 'negitive';
			} else {
				$yellow_type = 'positive';
			}
			$yellow_wall_differnce = $y_ask_diff - $y_bid_diff;

			$current_market_value = $final_array['market_value'];
			//===============================End Wall Calculation==============================//
			$array_to_ins2 = array(

				'coin' => $coin_symbol,

				'current_market_value' => $current_market_value,

				'ask_black_wall' => $temp_price_buy,

				'bid_black_wall' => $temp_price_sell,

				'black_ask_diff' => $ask_diff,

				'black_bid_diff' => $bid_diff,

				'black_wall_type' => $black_type,

				'black_wall_diff' => $black_wall_difference,

				'ask_yellow_wall' => $temp_price_buy22,

				'bid_yellow_wall' => $temp_price_sell22,

				'yellow_ask_diff' => $y_ask_diff,

				'yellow_bid_diff' => $y_bid_diff,

				'yellow_wall_type' => $yellow_type,

				'yellow_wall_diff' => $yellow_wall_differnce,

				'created_date' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),

				'created_date_human_readable' => date('Y-m-d H:i:s'),

			);

			$this->mongo_db->insert('depth_wall_history', $array_to_ins2);
			//===============================End Wall Insertion==============================//

			//===============================Contracts Info==============================//
			$bid_contract_info = $this->get_bid_contract_info($coin_symbol);

			$bid_contract_avg = $bid_contract_info['avg'];

			if (is_nan($bid_contract_avg)) {

				$bid_contract_avg = 0;

			}

			$bid_contract_per = $bid_contract_info['per'];

			$ask_contract_info = $this->get_ask_contract_info($coin_symbol);

			$ask_contract_avg = $ask_contract_info['avg'];

			if (is_nan($ask_contract_avg)) {

				$ask_contract_avg = 0;

			}

			$ask_contract_per = $ask_contract_info['per'];
			//==============================End Contracts Info==============================//

			//===============================Pressure Calculation==============================//
			$pre_time = date("Y-m-d H:i:s", strtotime('-5 minutes'));

			$new_date = date("Y-m-d H:i:s");

			$up_pressure_arr = $this->calculate_pressure($market_sell_depth_arr, $market_buy_depth_arr);
			$up_pressure = $up_pressure_arr['up'];
			$down_pressure = $up_pressure_arr['down'];
			if ($up_pressure > $down_pressure) {
				$pressure_type = 'positive';
			} else {
				$pressure_type = 'negitive';
			}

			$pressure_difference = $up_pressure - $down_pressure;
			//============================End Pressure Calculation==============================//

			//===============================Big Wall Calculation==============================//
			$pressure_wall = $this->calculate_big_wall($market_sell_depth_arr, $market_buy_depth_arr);

			$ask_max = $pressure_wall['up_big_wall'];
			$bid_max = $pressure_wall['down_big_wall'];
			$ask_price = $pressure_wall['up_big_price'];
			$bid_price = $pressure_wall['down_big_price'];
			$max_price = $pressure_wall['great_wall_price'];
			$max = $pressure_wall['great_wall_quantity'];
			$pressure = $pressure_wall['great_wall'];
			$color = $pressure_wall['great_wall_color'];

			//=======================End Big Wall Calculation==============================//

			//==========================7 Level Depth=======================================//
			$levels = $this->calculate_bid_ask_levels($market_sell_depth_arr, $market_buy_depth_arr);

			$val = $levels['new_x'];
			$t = $levels['p'];
			//=======================End 7 Level Depth=======================================//

			//============================Buyers Calculation==============================//
			$current = $this->get_current_candle_volume($coin_symbol);
			$curr_bid_per = $current['bid_per'];

			if (is_nan($curr_bid_per)) {

				$curr_bid_per = 0;

			}

			$curr_ask_per = $current['ask_per'];

			if (is_nan($curr_ask_per)) {

				$curr_ask_per = 0;

			}

			$curr_bid = $current['bid_vol'];

			if (is_nan($curr_bid)) {

				$curr_bid = 0;

			}

			$curr_ask = $current['ask_vol'];

			if (is_nan($curr_ask)) {

				$curr_ask = 0;

			}
			if ($curr_bid > $curr_ask) {
				if ($curr_ask == 0) {$curr_ask = 1;}
				$divide = $curr_bid / $curr_ask;
				$divide = $divide * -1;
				$trade_type = 'blue';

			} else if ($curr_ask > $curr_bid) {
				if ($curr_bid == 0) {$curr_bid = 1;}
				$divide = $curr_ask / $curr_bid;

				$trade_type = 'red';

			}
			//======================End Buyers Calculation==============================//

			//================================ 2M Calc===================================//
			$contract_one = $this->get_contracts_one($coin_symbol);
			$m_b_quantity = $contract_one['bid_quantity'];
			$m_a_quantity = $contract_one['ask_quantity'];
			$m_time_str = $contract_one['time_string'];

			if ($m_b_quantity > $m_a_quantity) {
				if ($m_a_quantity == 0) {$m_a_quantity = 1;}
				$divide_m = $m_b_quantity / $m_a_quantity;
				$divide_m = $divide_m * -1;
				//$/trade_type = 'blue';

			} else if ($m_a_quantity > $m_b_quantity) {
				if ($m_b_quantity == 0) {$m_b_quantity = 1;}
				$divide_m = $m_a_quantity / $m_b_quantity;

				//$trade_type = 'red';

			}
			//================================End 2M Calc===================================//

			//================================ 200 Calc===================================//
			$contract_two = $this->get_contracts_two($coin_symbol);
			$h_b_quantity = $contract_two['bid_quantity'];
			$h_a_quantity = $contract_two['ask_quantity'];
			$h_time_str = $contract_two['time_string'];

			if ($h_b_quantity > $h_a_quantity) {
				if ($h_a_quantity == 0) {$h_a_quantity = 1;}
				$divide_h = $h_b_quantity / $h_a_quantity;
				$divide_h = $divide_h * -1;
				//$trade_type = 'blue';

			} else if ($h_a_quantity > $h_b_quantity) {
				if ($h_b_quantity == 0) {$h_b_quantity = 1;}
				$divide_h = $h_a_quantity / $h_b_quantity;

				//$trade_type = 'red';

			}

			//======================== Score Calculation ===============================//
			$up_barrier = $this->get_barrier_value($current_market_value, $coin_symbol, 'up');
			$down_barrier = $this->get_barrier_value($current_market_value, $coin_symbol, 'down');
			$up_b = $key = array_search($up_barrier, array_column($market_sell_depth_arr, 'price'));
			$down_b = $key = array_search($down_barrier, array_column($market_buy_depth_arr, 'price'));
			//echo $ask_diff = 50 - $ask_diff;
			if ($up_b > $down_b) {
				$b_p = ($up_b) - $down_b;
				$b_c = 'down';
			} else {
				$b_p = $down_b - $up_b;
				$b_c = 'up';
			}
			$bid_ask_level = $this->calculate_fifteen_minutes_contracts($coin_symbol);
			$bid_candle_p = $bid_ask_level['bid'];
			$ask_candle_p = $bid_ask_level['ask'];
			$this->mongo_db->order_by(array('_id' => -1));
			$this->mongo_db->where(array('coin' => $coin_symbol));
			$this->mongo_db->where_in('global_swing_status', array('LL', 'HH', 'LH', 'HL'));
			$this->mongo_db->limit(1);
			$row = $this->mongo_db->get('market_chart');
			$data_row = iterator_to_array($row);

			$swing_point = $data_row[0]['global_swing_status'];

			$score_arr = array(
				'depth_pressure' => $pressure_difference,
				'depth_pressure_side' => $pressure_type,
				'black_pressure' => $black_wall_difference,
				'black_color_side' => $black_type,
				'yellow_pressure' => $yellow_wall_differnce,
				'yellow_color_side' => $yellow_type,
				'seven_level' => $val,
				'seven_level_side' => $t,
				'big_pressure' => $pressure_wall,
				'buyers' => $curr_ask,
				'sellers' => $curr_bid,
				'big_sellers' => $bid_contract_info['per'],
				'big_buyers' => $ask_contract_info['per'],
				'barrier_diff' => $b_p,
				'barrier_side' => $b_c,
				'swing_status' => $swing_point,
				'taf' => $ask_candle_p,
				'tbf' => $bid_candle_p,
				't_h_b' => $contract_two['bids'],
				't_h_a' => $contract_two['asks'],

			);
			$market_depth = $this->get_market_depth_group($coin_symbol,$current_market_value);
			$market_depth_ask = $this->get_market_depth_group_ask($coin_symbol,$current_market_value);
			$score_array = $this->calculate_score($score_arr);
			//========================End Score Calc===================================//

			//================================End 200 Calc===================================//
			$array_to_ins = array(

				'coin' => $coin_symbol,

				'current_market_value' => (float) $current_market_value,

				'ask_black_wall' => (float) $temp_price_buy,

				'ask_yellow_wall' => (float) $temp_price_buy22,

				'bid_black_wall' => (float) $temp_price_sell,

				'bid_yellow_wall' => (float) $temp_price_sell22,

				'black_wall_type' => $black_type,

				'black_wall_pressure' => $black_wall_difference,

				'yellow_wall_type' => $yellow_type,

				'yellow_wall_pressure' => $yellow_wall_differnce,

				'up_pressure' => (float) $up_pressure,

				'down_pressure' => (float) $down_pressure,

				'pressure_type' => $pressure_type,

				'pressure_diff' => (float) $pressure_difference,

				'bid_contracts' => $bid_contract_avg,

				'bid_percentage' => $bid_contract_per,

				'ask_contract' => $ask_contract_avg,

				'ask_percentage' => $ask_contract_per,

				'buyers' => $curr_ask,

				'sellers' => $curr_bid,

				'buyers_percentage' => $curr_ask_per,

				'sellers_percentage' => $curr_bid_per,

				'sellers_buyers_per' => $divide,

				'trade_type' => $trade_type,

				'up_big_wall' => $ask_max,
				'down_big_wall' => $bid_max,
				'up_big_price' => $ask_price,
				'down_big_price' => $bid_price,
				'great_wall_price' => $max_price,
				'great_wall_quantity' => $max,
				'great_wall' => $pressure,
				'great_wall_color' => $color,

				'seven_level_depth' => $val,
				'seven_level_type' => $t,

				'score' => $score_array,
				'last_qty_buy_vs_sell' => $divide_m,
				'last_qty_time_ago' => $m_time_str,

				'last_200_buy_vs_sell' => $divide_h,
				'last_200_time_ago' => $h_time_str,
				'bid_percentile' => $tbf,
				'ask_percentile' => $taf,
				'modified_date' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
				'market_depth_quantity' => $market_depth,
				'market_depth_ask' => $market_depth_ask,
			);

			$this->mongo_db->insert("coin_meta_history", $array_to_ins);
			$db = $this->mongo_db->customQuery();

			$findArr = array('coin' => $coin_symbol);

			$ins_data = $db->coin_meta->updateOne($findArr, array('$set' => $array_to_ins), array('upsert' => true));
			echo 'End date'.date('y-m-d H:i:s').'<br>';
			function_stop($function_name);
	}// %%%%%%%%%%%%%% End of index %%%%%%%%%%%%%

	public function get_remainder_data($symbol) {

		$offset = $this->mod_coins->get_coin_offset_value($symbol);

		$coin_value = $this->mod_coins->get_coin_unit_value($symbol);

		$market_value = $this->mod_script->get_market_value($symbol);

		$limit = 50 * $offset;

		$valasss = $market_value;

		$fullarray = array();

		$mvalue = num($market_value);

		$divider = num($offset * $coin_value);

		$remainder = fmod($mvalue, $divider);
		$remainder_tes = num($remainder);
		$resultant = num($divider - $remainder);

		if ($offset != 1) {
			$num_Val = (float) ($mvalue + ($resultant));
			$val = $num_Val;
		} else {
			$num_Val = (float) $mvalue;
			$val = $num_Val + $coin_value;
		}

		if ($remainder_tes != '0.00000000' && $resultant == '0.00000000') {
			$val = $num_Val + $remainder;
		}


		//+++++++++++++++++++++++++++++++++ Calculating the last swing point ++++++++++++++++++++++++++++++++++++++++++++//

		$this->mongo_db->order_by(array('timestampDate' => -1));
		$this->mongo_db->where(array('coin' => $symbol));
		$this->mongo_db->where_in('global_swing_parent_status', array('LL', 'HH', 'LH', 'HL'));
		$this->mongo_db->limit(1);
		$depth_responseArr = $this->mongo_db->get('market_chart');

		//market_trade_hourly_history
		$arr = iterator_to_array($depth_responseArr);

		//_____________________________End Calculating Swing Point___________________________________////



		for ($i = 0; $i < $limit; $i++) {
			$depth_buy_quantity1 = 0;
			$depth_buy_quantity2 = 0;
			$depth_buy_quantity3 = 0;
			$depth_buy_quantity4 = 0;
			if ($i == 0) {
				if ($offset != 1 && $resultant != '0.00000000') {$num_Val = $num_Val - $divider;}
			}

			if ($i != 0) {

				$num_Val += $coin_value;

			}

			$num_Val = trim($num_Val);

			$num_Val = (float) $num_Val;

			if ($num_Val < 0) {

				continue;

			}

			$this->mongo_db->where(array('type' => 'ask', 'coin' => $symbol, 'price' => $num_Val));

			$depth_responseArr5 = $this->mongo_db->get('market_depth');

			foreach ($depth_responseArr5 as $depth_valueArr5) {

				if (!empty($depth_valueArr5)) {

					$depth_buy_quantity1 += $depth_valueArr5['quantity'];

				}

			}

			$this->mongo_db->where(array('type' => 'bid', 'coin' => $symbol, 'price' => $num_Val));

			$depth_responseArr6 = $this->mongo_db->get('market_depth');

			foreach ($depth_responseArr6 as $depth_valueArr6) {

				if (!empty($depth_valueArr6)) {

					$depth_buy_quantity2 += $depth_valueArr6['quantity'];

				}

			}


			if (!empty($arr)) {
				$datetime = $arr[0]['timestampDate']->toDateTime();
				$created_date = $datetime->format(DATE_RSS);

				$datetime = new DateTime($created_date);
				$datetime->format('Y-m-d H:i:s');

				$formated_date_time = $datetime->format('Y-m-d H:i:s');
				$end_date = date('Y-m-d H:i:s');

				$responseArr2222 = $this->mod_chart3->get_price_volume_for_hour($symbol, $formated_date_time, $end_date, "bid", $num_Val);
				$this->mongo_db->where(array('maker' => 'true', 'coin' => $symbol, 'price' => $num_Val, 'created_date' => array('$gte' => $this->mongo_db->converToMongodttime(date('Y-m-d H:00:00', strtotime($end_date))))));
				$responseArr22223 = $this->mongo_db->get('market_trades');

				foreach ($responseArr22223 as $depth_valueArr3) {
					if (!empty($depth_valueArr3)) {

						$depth_buy_quantity3 += $depth_valueArr3['quantity'];
					}
				}
				$buy_quantity = 0;
				foreach ($responseArr2222 as $valueArr222) {

					if (!empty($valueArr222)) {

						$depth_buy_quantity3 += $valueArr222['volume'];
					}

				}

				$responseArr2222 = $this->mod_chart3->get_price_volume_for_hour($symbol, $formated_date_time, $end_date, "ask", $num_Val);
				//$responseArr2222 = $this->mongo_db->get('market_trades');

				//////////////
				$this->mongo_db->where(array('maker' => 'false', 'coin' => $symbol, 'price' => $num_Val, 'created_date' => array('$gte' => $this->mongo_db->converToMongodttime(date('Y-m-d H:00:00', strtotime($end_date))))));
				$responseArr22224 = $this->mongo_db->get('market_trades');
				foreach ($responseArr22224 as $depth_valueArr4) {
					if (!empty($depth_valueArr4)) {

						$depth_buy_quantity4 += $depth_valueArr4['quantity'];
					}
				}
				foreach ($responseArr2222 as $valueArr222) {

					if (!empty($valueArr222)) {

						$depth_buy_quantity4 += $valueArr222['volume'];
					}

				}

			} else {
				$this->mongo_db->where(array('maker' => 'true', 'coin' => $symbol, 'price' => $num_Val));
				$responseArr22223 = $this->mongo_db->get('market_trades');

				foreach ($responseArr22223 as $depth_valueArr3) {
					if (!empty($depth_valueArr3)) {

						$depth_buy_quantity3 += $depth_valueArr3['quantity'];
					}
				}
				$this->mongo_db->where(array('maker' => 'false', 'coin' => $symbol, 'price' => $num_Val));
				$responseArr22224 = $this->mongo_db->get('market_trades');
				foreach ($responseArr22224 as $depth_valueArr4) {
					if (!empty($depth_valueArr4)) {

						$depth_buy_quantity4 += $depth_valueArr4['quantity'];
					}
				}
			}

			$returArr['price'] = $num_Val;

			$returArr['quantity'] = $depth_buy_quantity1;

			$returArr['type'] = 'ask';

			$returArr['coin'] = $symbol;

			$returArr['depth_buy_quantity'] = $depth_buy_quantity1;

			$returArr['depth_sell_quantity'] = $depth_buy_quantity2;

			$returArr['buy_quantity'] = $depth_buy_quantity3;

			$returArr['sell_quantity'] = $depth_buy_quantity4;

			$fullarray[] = $returArr;

		}

		//$val = $market_value;

		$final_array['asks'] = $fullarray;

		$fullarray = array();

		for ($i = 0; $i < $limit; $i++) {

			$depth_buy_quantity5 = 0;

			$depth_buy_quantity6 = 0;

			$depth_buy_quantity7 = 0;

			$depth_buy_quantity8 = 0;

			$val -= $coin_value;

			$val = trim($val);

			$val = (float) $val;

			if ($val < 0.00000000) {

				continue;

			}

			$this->mongo_db->where(array('type' => 'ask', 'coin' => $symbol, 'price' => $val));

			$depth_responseArr5 = $this->mongo_db->get('market_depth');

			foreach ($depth_responseArr5 as $depth_valueArr5) {

				if (!empty($depth_valueArr5)) {

					$depth_buy_quantity5 += $depth_valueArr5['quantity'];

				}

			}

			$this->mongo_db->where(array('type' => 'bid', 'coin' => $symbol, 'price' => $val));

			$depth_responseArr6 = $this->mongo_db->get('market_depth');

			foreach ($depth_responseArr6 as $depth_valueArr6) {

				if (!empty($depth_valueArr6)) {

					$depth_buy_quantity6 += $depth_valueArr6['quantity'];

				}

			}

			if (!empty($arr)) {
				$datetime = $arr[0]['timestampDate']->toDateTime();
				$created_date = $datetime->format(DATE_RSS);

				$datetime = new DateTime($created_date);
				$datetime->format('Y-m-d H:i:s');

				//$new_timezone = new DateTimeZone('Asia/Karachi');
				//$datetime->setTimezone($new_timezone);
				$formated_date_time = $datetime->format('Y-m-d H:i:s');
				$end_date = date('Y-m-d H:i:s');

				$responseArr2222 = $this->mod_chart3->get_price_volume_for_hour($symbol, $formated_date_time, $end_date, "bid", $val);
				//////////////
				$buy_quantity = 0;
				$this->mongo_db->where(array('maker' => 'true', 'coin' => $symbol, 'price' => $val, 'created_date' => array('$gte' => $this->mongo_db->converToMongodttime(date('Y-m-d H:00:00', strtotime($end_date))))));
				$responseArr22223 = $this->mongo_db->get('market_trades');

				foreach ($responseArr22223 as $depth_valueArr3) {
					if (!empty($depth_valueArr3)) {

						$depth_buy_quantity7 += $depth_valueArr3['quantity'];
					}
				}
				foreach ($responseArr2222 as $valueArr222) {

					if (!empty($valueArr222)) {

						$depth_buy_quantity7 += $valueArr222['volume'];
					}

				}

				$responseArr2222 = $this->mod_chart3->get_price_volume_for_hour($symbol, $formated_date_time, $end_date, "ask", $val);
				//$responseArr2222 = $this->mongo_db->get('market_trades');

				//////////////
				$this->mongo_db->where(array('maker' => 'false', 'coin' => $symbol, 'price' => $val, 'created_date' => array('$gte' => $this->mongo_db->converToMongodttime(date('Y-m-d H:00:00', strtotime($end_date))))));
				$responseArr22224 = $this->mongo_db->get('market_trades');
				foreach ($responseArr22224 as $depth_valueArr4) {
					if (!empty($depth_valueArr4)) {

						$depth_buy_quantity8 += $depth_valueArr4['quantity'];
					}
				}

				foreach ($responseArr2222 as $valueArr222) {

					if (!empty($valueArr222)) {

						$depth_buy_quantity8 += $valueArr222['volume'];
					}
				}
			} else {
				$this->mongo_db->where(array('maker' => 'true', 'coin' => $symbol, 'price' => $val));
				$responseArr22223 = $this->mongo_db->get('market_trades');

				foreach ($responseArr22223 as $depth_valueArr3) {
					if (!empty($depth_valueArr3)) {

						$depth_buy_quantity7 += $depth_valueArr3['quantity'];
					}
				}
				$this->mongo_db->where(array('maker' => 'false', 'coin' => $symbol, 'price' => $val));
				$responseArr22224 = $this->mongo_db->get('market_trades');
				foreach ($responseArr22224 as $depth_valueArr4) {
					if (!empty($depth_valueArr4)) {

						$depth_buy_quantity8 += $depth_valueArr4['quantity'];
					}
				}
			}

			$returArr['price'] = $val;

			$returArr['quantity'] = $depth_buy_quantity5;

			$returArr['type'] = 'bid';

			$returArr['coin'] = $symbol;

			$returArr['depth_buy_quantity'] = $depth_buy_quantity5;

			$returArr['depth_sell_quantity'] = $depth_buy_quantity6;

			$returArr['buy_quantity'] = $depth_buy_quantity7;

			$returArr['sell_quantity'] = $depth_buy_quantity8;

			$fullarray[] = $returArr;

		}

		$final_array['bid'] = $fullarray;

		$final_array['market_value'] = $market_value;

		return $final_array;
	}

	public function get_contract_info($symbol) {

		$datetime = date('Y-m-d H:i:s');

		$info = $this->mod_coins->get_coin_contract_value($symbol);

		$contract_per = $info['contract_percentage'];

		$contract_time = $info['contract_time'];

		if ($contract_time == 0) {

			$contract_time = 2;

		}

		if ($contract_per == 0) {

			$contract_per = 10;

		}

		$nowtime = date('Y-m-d H:i:s', strtotime('-' . $contract_time . 'minutes'));

		$search_array['coin'] = $symbol;

		$search_array['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($nowtime), '$lte' => $this->mongo_db->converToMongodttime($datetime));

		$this->mongo_db->where($search_array);

		$this->mongo_db->order_by(array('created_date' => -1));

		$get_arr = $this->mongo_db->get('market_trades');

		$quantity = array();

		foreach ($get_arr as $key => $value) {

			if (!empty($value)) {

				$quantity[] = $value['quantity'];

			}

		}

		rsort($quantity);

		$q_sum = 0;

		$index = round((count($quantity) / 100) * $contract_per);

		for ($i = 0; $i < $index; $i++) {

			$q_sum += $quantity[$i];

		}

		for ($i = 0; $i < count($quantity); $i++) {

			$t_sum += $quantity[$i];

		}

		$q_avg = $q_sum / $index;

		$cal_per = ($q_sum / $t_sum) * 100;

		$ret_arr['avg'] = round($q_avg);

		$ret_arr['per'] = round($cal_per);

		return $ret_arr;
	}

	public function get_bid_contract_info($symbol) {
		$info = $this->mod_coins->get_coin_contract_value($symbol);

		$contract_per = $info['contract_percentage'];
		$contract_time = $info['contract_time'];

		if ($contract_time == 0) {
			$contract_time = 2;
		}

		if ($contract_per == 0) {
			$contract_per = 10;
		}

		$curr_time = date("Y-m-d H:i:s");
		$nowtime = date('Y-m-d H:i:s', strtotime('-' . $contract_time . 'minutes'));

		$search_array['coin'] = $symbol;
		/*$search_array['maker'] = 'true';*/
		$search_array['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($nowtime));

		$this->mongo_db->where($search_array);
		$this->mongo_db->order_by(array('created_date' => -1));
		$get_arr = $this->mongo_db->get('market_trades');
		$get_arr_1 = iterator_to_array($get_arr);
		array_multisort(array_column($get_arr_1, "quantity"), SORT_DESC, $get_arr_1);
		$index = round((count($get_arr_1) / 100) * $contract_per);
		for ($i = 0; $i < $index; $i++) {
			if ($get_arr_1[$i]['maker'] == 'true') {
				$q_sum += $get_arr_1[$i]['quantity'];
			}

		}

		$q2 = 0;
		$max_price = 0;
		for ($i = 0; $i < $index; $i++) {
			if ($get_arr_1[$i]['maker'] == 'true') {

				$q = $get_arr_1[$i]['quantity'];
				if ($q2 < $q) {
					$q2 = $q;
					$max_price = $get_arr_1[$i]['price'];
				}
			}

		}
		for ($i = 0; $i < count($get_arr_1); $i++) {
			$t_sum += $get_arr_1[$i]['quantity'];
		}

		$q_avg = $q_sum / $index;

		$cal_per = ($q_sum / $t_sum) * 100;
		$ret_arr['avg'] = round($q_avg);
		$ret_arr['per'] = round($cal_per);
		$ret_arr['max'] = num($max_price);
		return $ret_arr;
	}
	public function get_ask_contract_info($symbol) {
		$info = $this->mod_coins->get_coin_contract_value($symbol);

		$contract_per = $info['contract_percentage'];
		$contract_time = $info['contract_time'];

		if ($contract_time == 0) {
			$contract_time = 2;
		}

		if ($contract_per == 0) {
			$contract_per = 10;
		}

		$curr_time = date("Y-m-d H:i:s");
		$nowtime = date('Y-m-d H:i:s', strtotime('-' . $contract_time . 'minutes'));

		$search_array['coin'] = $symbol;

		$search_array['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($nowtime));

		$this->mongo_db->where($search_array);
		$this->mongo_db->order_by(array('created_date' => -1));
		$get_arr = $this->mongo_db->get('market_trades');
		$get_arr_1 = iterator_to_array($get_arr);
		array_multisort(array_column($get_arr_1, "quantity"), SORT_DESC, $get_arr_1);

		$index = round((count($get_arr_1) / 100) * $contract_per);
		$index = round((count($get_arr_1) / 100) * $contract_per);
		for ($i = 0; $i < $index; $i++) {
			if ($get_arr_1[$i]['maker'] == 'false') {
				$q_sum += $get_arr_1[$i]['quantity'];
			}

		}

		$q2 = 0;
		$max_price = 0;
		for ($i = 0; $i < $index; $i++) {
			if ($get_arr_1[$i]['maker'] == 'false') {

				$q = $get_arr_1[$i]['quantity'];
				if ($q2 < $q) {
					$q2 = $q;
					$max_price = $get_arr_1[$i]['price'];
				}
			}

		}

		for ($i = 0; $i < count($get_arr_1); $i++) {
			$t_sum += $get_arr_1[$i]['quantity'];
		}

		$q_avg = $q_sum / $index;

		$cal_per = ($q_sum / $t_sum) * 100;
		$ret_arr['avg'] = round($q_avg);
		$ret_arr['per'] = round($cal_per);
		$ret_arr['max'] = num($max_price);
		return $ret_arr;
	}

	public function calculate_wall($coin_symbol, $depth_arr, $type, $biggest_value) {

		if ($type == 'sell') {

			array_multisort(array_column($depth_arr, "price"), SORT_ASC, $depth_arr);

		} elseif ($type == 'buy') {

			array_multisort(array_column($depth_arr, "price"), SORT_DESC, $depth_arr);

		}

		$setting = $this->mod_coins->get_coin_depth_wall_setting($coin_symbol);

		$temp_price = 0.00;

		///////////////////////////////////////////////////////////////////////////////////

		if ($setting == 'percentage') {

			$depth_wall_val = $this->mod_coins->get_coin_depth_wall_percentage($coin_symbol);

			if (count($depth_arr) > 0) {

				$buy_depth_wall2 = 0;

				$temp_price = 0;

				$temps = count($depth_arr);

				for ($temp = $temps - 1; $temp >= 0; $temp--) {

					if ($depth_arr[$temp]['type'] == 'bid') {

						$sell_percentage22 = round($depth_arr[$temp]['depth_sell_quantity'] * 100 / $biggest_value);

						if ($sell_percentage22 > $depth_wall_val && $buy_depth_wall2 == 0) {

							$temp_price = num($depth_arr[$temp]['price']);

							$buy_depth_wall2 = 1;

							break;

						}

					} elseif ($depth_arr[$temp]['type'] == 'ask') {

						$buy_percentage22 = round($depth_arr[$temp]['depth_buy_quantity'] * 100 / $biggest_value);

						if ($buy_percentage22 >= $depth_wall_val && $buy_depth_wall2 == 0) {

							$temp_price = num($depth_arr[$temp]['price']);

							$buy_depth_wall2 = 1;

							break;

						}

					}

				}

			}

		} elseif ($setting == 'amount') {

			$depth_wall_val = $this->mod_coins->get_coin_depth_wall_value($coin_symbol);

			if (count($depth_arr) > 0) {

				$quantity_t = 0;

				$buy_depth_wall2 = 0;

				$temp_price = 0;

				$temps = count($depth_arr);

				for ($temp = $temps - 1; $temp >= 0; $temp--) {

					if ($depth_arr[$temp]['type'] == 'bid') {

						$quantity_t += $depth_arr[$temp]['depth_sell_quantity'];

						if ($quantity_t >= $depth_wall_val && $buy_depth_wall2 == 0) {

							$temp_price = num($depth_arr[$temp]['price']);

							$buy_depth_wall2 = 1;

						}

					} elseif ($depth_arr[$temp]['type'] == 'ask') {

						$quantity_t += $depth_arr[$temp]['depth_buy_quantity'];

						if ($quantity_t >= $depth_wall_val && $buy_depth_wall2 == 0) {

							$temp_price = num($depth_arr[$temp]['price']);

							$buy_depth_wall2 = 1;

						}

					}

				}

			}

		}

		return $temp_price;

		///////////////////////////////////////////////////////////////////////////////////
	}

	public function calculate_yellow_wall($coin_symbol, $depth_arr, $type, $biggest_value) {

		if ($type == 'sell') {

			array_multisort(array_column($depth_arr, "price"), SORT_ASC, $depth_arr);

		} elseif ($type == 'buy') {

			array_multisort(array_column($depth_arr, "price"), SORT_DESC, $depth_arr);

		}

		$setting = $this->mod_coins->get_coin_yellow_wall_setting($coin_symbol);

		$temp_price = 0.00;

		///////////////////////////////////////////////////////////////////////////////////

		if ($setting == 'percentage') {

			$depth_wall_val = $this->mod_coins->get_coin_yellow_wall_percentage($coin_symbol);

			if (count($depth_arr) > 0) {

				$buy_depth_wall2 = 0;

				$temp_price = 0;

				$temps = count($depth_arr);

				for ($temp = $temps - 1; $temp >= 0; $temp--) {

					if ($depth_arr[$temp]['type'] == 'bid') {

						$sell_percentage22 = round($depth_arr[$temp]['depth_sell_quantity'] * 100 / $biggest_value);

						if ($sell_percentage22 > $depth_wall_val && $buy_depth_wall2 == 0) {

							$temp_price = num($depth_arr[$temp]['price']);

							$buy_depth_wall2 = 1;

							break;

						}

					} elseif ($depth_arr[$temp]['type'] == 'ask') {

						$buy_percentage22 = round($depth_arr[$temp]['depth_buy_quantity'] * 100 / $biggest_value);

						if ($buy_percentage22 >= $depth_wall_val && $buy_depth_wall2 == 0) {

							$temp_price = num($depth_arr[$temp]['price']);

							$buy_depth_wall2 = 1;

							break;

						}

					}

				}

			}

		} elseif ($setting == 'amount') {

			$depth_wall_val = $this->mod_coins->get_coin_yellow_wall_value($coin_symbol);

			if (count($depth_arr) > 0) {

				$quantity_t = 0;

				$buy_depth_wall2 = 0;

				$temp_price = 0;

				$temps = count($depth_arr);

				for ($temp = $temps - 1; $temp >= 0; $temp--) {

					if ($depth_arr[$temp]['type'] == 'bid') {

						$quantity_t += $depth_arr[$temp]['depth_sell_quantity'];

						if ($quantity_t >= $depth_wall_val && $buy_depth_wall2 == 0) {

							$temp_price = num($depth_arr[$temp]['price']);

							$buy_depth_wall2 = 1;

						}

					} elseif ($depth_arr[$temp]['type'] == 'ask') {

						$quantity_t += $depth_arr[$temp]['depth_buy_quantity'];

						if ($quantity_t >= $depth_wall_val && $buy_depth_wall2 == 0) {

							$temp_price = num($depth_arr[$temp]['price']);

							$buy_depth_wall2 = 1;

						}

					}

				}

			}

		}

		return $temp_price;

		///////////////////////////////////////////////////////////////////////////////////
	}

	public function calculate_big_wall($sell_arr, $buy_arr) {
		$pressure_up = 0;
		$pressure_down = 0;

		array_multisort(array_column($buy_arr, "price"), SORT_ASC, $buy_arr);
		array_multisort(array_column($sell_arr, "price"), SORT_DESC, $sell_arr);

		$bid_max = $sell_arr[0]['depth_sell_quantity'];
		$ask_max = $buy_arr[0]['depth_buy_quantity'];
		$bid_price = $sell_arr[0]['price'];
		$ask_price = $buy_arr[0]['price'];
		for ($i = 0; $i < 5; $i++) {
			if ($bid_max < $sell_arr[$i]['depth_sell_quantity']) {
				$bid_max = $sell_arr[$i]['depth_sell_quantity'];
				$bid_price = $sell_arr[$i]['price'];
			}

			if ($ask_max < $buy_arr[$i]['depth_buy_quantity']) {
				$ask_max = $buy_arr[$i]['depth_buy_quantity'];
				$ask_price = $buy_arr[$i]['price'];
			}
		}

		if ($bid_max > $ask_max) {
			$pressure = 'downside';
			$color = 'blue';
			$max_price = $bid_price;
			$max = $bid_max;
		} elseif ($ask_max > $bid_max) {
			$pressure = 'upside';
			$color = 'red';
			$max_price = $ask_price;
			$max = $ask_max;
		}

		$pressure_arr['up_big_wall'] = $ask_max;
		$pressure_arr['down_big_wall'] = $bid_max;
		$pressure_arr['up_big_price'] = $ask_price;
		$pressure_arr['down_big_price'] = $bid_price;
		$pressure_arr['great_wall_price'] = $max_price;
		$pressure_arr['great_wall_quantity'] = $max;
		$pressure_arr['great_wall'] = $pressure;
		$pressure_arr['great_wall_color'] = $color;

		return $pressure_arr;
	}

	public function calculate_pressure($market_sell_depth_arr, $market_buy_depth_arr) {
		$pressure_up = 0;
		$pressure_down = 0;

		array_multisort(array_column($market_buy_depth_arr, "price"), SORT_ASC, $market_buy_depth_arr);
		array_multisort(array_column($market_sell_depth_arr, "price"), SORT_DESC, $market_sell_depth_arr);
		for ($i = 0; $i < 5; $i++) {
			$ret_Arr = array();
			if ($market_sell_depth_arr[$i]['depth_sell_quantity'] > $market_buy_depth_arr[$i]['depth_buy_quantity']) {
				$pressure_up++;
			} elseif ($market_sell_depth_arr[$i]['depth_sell_quantity'] < $market_buy_depth_arr[$i]['depth_buy_quantity']) {
				$pressure_down++;
			}
		}
		return array("up" => $pressure_up, 'down' => $pressure_down);
	}
	public function get_current_candle_volume($symbol) {

		$new_datetime = date("Y-m-d H:i:s", strtotime("-5 minutes"));

		$orig_date22 = new DateTime($new_datetime);

		$orig_date22 = $orig_date22->getTimestamp();

		$start_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);

		$datetime2 = date("Y-m-d H:i:s");

		$orig_date322 = new DateTime($datetime2);

		$orig_date322 = $orig_date322->getTimestamp();

		$end_date = new MongoDB\BSON\UTCDateTime($orig_date322 * 1000);

		$search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);

		$search['coin'] = $symbol;

		$search['maker'] = 'true';

		$this->mongo_db->where($search);

		$get = $this->mongo_db->get("market_trades");

		$res = iterator_to_array($get);

		$bid_vol = 0;

		foreach ($res as $key => $value) {

			$vol = $value['quantity'];

			$bid_vol += $vol;

		}

		$search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);

		$search['coin'] = $symbol;

		$search['maker'] = 'false';

		$this->mongo_db->where($search);

		$get = $this->mongo_db->get("market_trades");

		$res = iterator_to_array($get);

		$ask_vol = 0;

		foreach ($res as $key => $value) {

			$vol = $value['quantity'];

			$ask_vol += $vol;

		}

		$total_volume = $bid_vol + $ask_vol;

		$bid_per = ($bid_vol * 100) / $total_volume;

		$ask_per = ($ask_vol * 100) / $total_volume;

		return array(

			'bid_per' => $bid_per,

			'ask_per' => $ask_per,

			'bid_vol' => $bid_vol,

			'ask_vol' => $ask_vol,

		);
	}

	public function calculate_bid_ask_levels($sell_arr, $buy_arr) {
		$pressure_up = 0;
		$pressure_down = 0;

		array_multisort(array_column($buy_arr, "price"), SORT_ASC, $buy_arr);
		array_multisort(array_column($sell_arr, "price"), SORT_DESC, $sell_arr);

		$bid_max = 0;
		$ask_max = 0;
		for ($i = 0; $i < 7; $i++) {

			$bid_max += $sell_arr[$i]['depth_sell_quantity'];
			$ask_max += $buy_arr[$i]['depth_buy_quantity'];
		}

		if ($bid_max > $ask_max) {
			if ($ask_max == 0) {
				$ask_max = 1;
			}
			$x = $bid_max / $ask_max;
			$p = 'positive';
		} elseif ($ask_max > $bid_max) {
			if ($bid_max == 0) {
				$bid_max = 1;
			}
			$x = $ask_max / $bid_max;
			$x = $x*-1;
			$p = 'negitive';
		}

		$new_x = $x - 1;
		return array('new_x' => number_format($new_x, 2), 'p' => $p);
	}

	public function calculate_candle_data() {

		$coin_array = $this->mod_coins->get_all_coins();

		foreach ($coin_array as $key => $value) {
			$symbol = $value['symbol'];
			$this->mongo_db->where('coin', $symbol);
			$this->mongo_db->order_by(array('timestampDate' => -1));
			$this->mongo_db->limit(1);
			$get = $this->mongo_db->get('market_chart');
			$candle_arr = iterator_to_array($get);

			$high = $candle_arr[0]['high'];
			$low = $candle_arr[0]['low'];
			$candle_type = $candle_arr[0]['candle_type'];
			$rejected_candle = $candle_arr[0]['rejected_candle'];
			$black_ask_diff = $candle_arr[0]['black_ask_diff'];
			$black_bid_diff = $candle_arr[0]['black_bid_diff'];
			$yellow_ask_diff = $candle_arr[0]['yellow_ask_diff'];
			$yellow_bid_diff = $candle_arr[0]['yellow_bid_diff'];
			$yellow_bid_diff = $candle_arr[0]['yellow_bid_diff'];
			$openTime_human_readible = $candle_arr[0]['openTime_human_readible'];

			if ($rejected_candle == 'top_demand_rejection' || $rejected_candle == 'top_supply_rejection') {
				$rejection_value = $high;
				$rejection_status = $rejected_candle;
			} elseif ($rejected_candle == 'bottom_demand_rejection' || $rejected_candle == 'bottom_supply_rejection') {
				$rejection_value = $low;
				$rejection_status = $rejected_candle;
			} else {
				$rejection_value = 0;
				$rejection_status = 'no_rejection';
			}

			$yellow_diff = $yellow_ask_diff - $yellow_bid_diff;
			$black_diff = $black_ask_diff - $black_bid_diff;
			$last_candle_type = $candle_type;

			$up_pressure = $this->calculate_pressure_up_and_down($openTime_human_readible, $symbol, 'up');
			$down_pressure = $this->calculate_pressure_up_and_down($openTime_human_readible, $symbol, 'down');

			$score_arr = $this->calculate_sentiment_score($symbol);
			$social = $score_arr['social_score'];
			$news = $score_arr['news_score'];
			$depth_pressure = $up_pressure - $down_pressure;
			$array = array(
				'last_candle_type' => $last_candle_type,
				'last_candle_rejection_value' => $rejection_value,
				'last_candle_rejection_status' => $rejection_status,
				'last_candle_yellow_diff' => $yellow_diff,
				'last_candle_black_diff' => $black_diff,
				'last_candle_depth_pressure' => $depth_pressure,
				'social_score' => $social,
				'news_score' => $news,
			);

			$this->mongo_db->where('coin', $symbol);
			$this->mongo_db->set($array);
			$this->mongo_db->update('coin_meta');

			//mail('khan.waqar278@gmail.com', 'Coin Meta Updated', 'Email Testing Trigger By Email SMTP PHP Developer');
		}
	}

	public function calculate_sentiment_score($symbol) {
		$social_score = 0;
		$news_score = 0;

		return array('social_score' => $social_score, 'news_score' => $news_score);
	}
	public function run() {
		$type = '';
		$source = 'twitter';
		$coin = 'ncash';
		$start = date("Y-m-d H:00:00", strtotime("-2 hour"));
		$end = date("Y-m-d H:00:00", strtotime("-1 hour"));
		$formula = 'one';
		$time = '1h';
		$sentiment_report['social'] = $this->getSentimentReport($type, $source, $coin, $start, $end, $formula, $time);
		$source = 'reddit';
		$sentiment_report['news'] = $this->getSentimentReportSocial($type, $source, $coin, $start, $end, $formula, $time);

		echo "<pre>";
		print_r($sentiment_report);
		exit;
	}
	public function getSentimentReport($type, $source, $coin, $startDateSocail, $end, $formula, $time) {

		if ($time == '1h') {

			if ($source == 'twitter') {$Table = 'tweets_sent_data';}
			// Custome QueryGoes Here
			ini_set("memory_limit", -1);

			$startNew = $this->mongo_db->converToMongodttime($startDateSocail);
			$endNew = $this->mongo_db->converToMongodttime($end);

			$this->mongo_db->where_gte('created_date', $startNew);
			$this->mongo_db->where_lt('created_date', $endNew);

			//$this->mongo_db->limit(100);
			$this->mongo_db->where('keyword', ($coin));
			//$this->mongo_db->limit(1);
			$res = $this->mongo_db->get($Table);

			$result = iterator_to_array($res);

			$countTotalRecord = count($result);
			if ($countTotalRecord != '') {}

			$negative_sentiment = 0;
			$positive_sentiment = 0;
			$countnegative = '';
			$countpositive = '';
			$potivrat = 0;
			$negative = 0;
			$negative_count = 0;
			$potivrat_count = 0;
			foreach ($result as $key => $value) {
				if ($value['negative_sentiment'] != '') {
					$negative_sentiment += $value['negative_sentiment'];
					$countnegative++;
				}
				if ($value['positive_sentiment'] != '') {
					$positive_sentiment += $value['positive_sentiment'];
					$countpositive++;
				}
			}
			$totalrecord = $countTotalRecord;
			$negative_sentiment = $negative_sentiment;
			$positive_sentiment = $positive_sentiment;
			$count_negative_sentiment = $countnegative;
			$count_positive_sentiment = $countpositive;

			if ($positive_sentiment != 0) {
				$potivrat = $positive_sentiment / $totalrecord;
				$potivrat_count = $positive_sentiment / $count_negative_sentiment;
			}
			if ($negative_sentiment != 0) {
				$negative = $negative_sentiment / $totalrecord;
				$negative_count = $negative_sentiment / $count_positive_sentiment;
			}
			//$temp = array();
			$temp['totalrecord'] = round($totalrecord);
			$temp['sum_nageative'] = round($negative_sentiment);
			$temp['sum_positive'] = round($positive_sentiment);
			$temp['t_neg_divide_t'] = round($negative);
			$temp['t_pos_divide_t'] = round($potivrat);
			$temp['t_neg_divide_t_neg'] = round($negative_count);
			$temp['t_pos_divide_t_pos'] = round($potivrat_count);
			$final_array = $temp;

		} //   for ($k = 1; $k < $totalDays; $k++) {

		return $final_array;
	} //end getSentimentReport

	public function getSentimentReportSocial($type, $source, $coin, $startDateSocail, $end, $formula, $time) {

		if ($coin == 'NCASHBTC') {
			$coin = 'ncash';
		} else {
			$coin = $coin;
		}
		if ($time == '1h') {

			if ($source == 'reddit') {$Table = 'reddi_comments';}
			// Custome QueryGoes Here
			ini_set("memory_limit", -1);

			$startNew = $this->mongo_db->converToMongodttime($startDateSocail);
			$endNew = $this->mongo_db->converToMongodttime($end);

			$this->mongo_db->where_gte('created_date', $startNew);
			$this->mongo_db->where_lt('created_date', $endNew);

			//$this->mongo_db->limit(100);
			$this->mongo_db->where('keyword', ($coin));
			//$this->mongo_db->limit(1);
			$res = $this->mongo_db->get($Table);
			$result = iterator_to_array($res);

			$countTotalRecord = count($result);
			if ($countTotalRecord != '') {}

			$negative_sentiment = 0;
			$positive_sentiment = 0;
			$countnegative = '';
			$countpositive = '';
			$potivrat = 0;
			$negative = 0;
			$negative_count = 0;
			$potivrat_count = 0;
			foreach ($result as $key => $value) {
				if ($value['negative_sentiment'] != '') {
					$negative_sentiment += $value['negative_sentiment'];
					$countnegative++;
				}
				if ($value['positive_sentiment'] != '') {
					$positive_sentiment += $value['positive_sentiment'];
					$countpositive++;
				}
				if ($value['neutral_sentiment'] != '') {
					$neutral_sentiment += $value['neutral_sentiment'];
					$countneutral++;
				}
			}
			$totalrecord = $countTotalRecord;
			$negative_sentiment = $negative_sentiment;
			$positive_sentiment = $positive_sentiment;
			$neutral_sentiment = $neutral_sentiment;

			$count_negative_sentiment = $countnegative;
			$count_positive_sentiment = $countpositive;
			$count_neutral_sentiment = $countneutral;

			if ($positive_sentiment) {
				$potivrat = $positive_sentiment / $totalrecord;
				$potivrat_count = $positive_sentiment / $count_negative_sentiment;
			}
			if ($negative_sentiment) {
				$negative = $negative_sentiment / $totalrecord;
				$negative_count = $negative_sentiment / $count_positive_sentiment;
			}
			if ($neutral_sentiment) {
				$neutrat = $neutral_sentiment / $totalrecord;
				$neutral_count = $neutral_sentiment / $count_neutral_sentiment;
			}
			//$temp = array();
			$temp['totalrecord'] = ($totalrecord);
			$temp['sum_nageative'] = ($negative_sentiment);
			$temp['sum_positive'] = ($positive_sentiment);
			$temp['sum_neutral'] = ($neutral_sentiment);
			$temp['t_neg_divide_t'] = ($negative);
			$temp['t_pos_divide_t'] = ($potivrat);
			$temp['t_neu_divide_t'] = ($neutrat);
			$temp['t_neg_divide_t_neg'] = ($negative_count);
			$temp['t_pos_divide_t_pos'] = ($potivrat_count);
			$temp['t_neu_divide_t_neu'] = ($neutral_count);
			$final_array = $temp;

		} //   for ($k = 1; $k < $totalDays; $k++) {

		return $final_array;
	} //end getSentimentReportSocial

	public function calculate_score($score_array) {

		/*
				Array
				(
				    [depth_pressure] => 1+
				    [depth_pressure_side] => up
				    [black_pressure] => 0+
				    [black_color_side] => up
				    [yellow_pressure] => 2+
				    [yellow_color_side] => down
				    [seven_level] => 0.41+
				    [seven_level_side] => up
				    [big_pressure] => down+
				    [buyers] => 44.236008501516+
				    [sellers] => 55.763991498484+
				    [big_sellers] => 32+
				    [big_buyers] => 21+
				    [barrier_diff] => 0
				    [barrier_side] => up+
				    [swing_status] => HH+
				    [taf] => 97
				    [tbf] => 92
				    't_h_b' => $contract_two['bids'],
					't_h_a' => $contract_two['asks'],
				)

		*/

		$depth_pressure = $score_array['depth_pressure'];
		$depth_pressure_side = $score_array['depth_pressure_side'];

		$black_pressure = $score_array['black_pressure'];
		$black_color_side = $score_array['black_color_side'];

		$yellow_pressure = $score_array['yellow_pressure'];
		$yellow_color_side = $score_array['yellow_color_side'];

		$seven_level = $score_array['seven_level'];
		$seven_level_side = $score_array['seven_level_side'];

		$big_pressure = $score_array['big_pressure'];

		$buyers = $score_array['buyers'];
		$sellers = $score_array['sellers'];

		$big_buyers = $score_array['big_buyers'];
		$big_sellers = $score_array['big_sellers'];

		$barrier = $score_array['barrier_diff'];
		$barrier_side = $score_array['barrier_side'];
		$swing_status = $score_array['swing_status'];

		$taf = $score_array['taf'];
		$tbf = $score_array['tbf'];

		$t_h_b = $score_array['t_h_b'];
		$t_h_a = $score_array['t_h_a'];

		$total_array = array();

		/////////////////////////////taf//////////////////////////////////
		if ($taf >= 70) {
			$score_taf = 2;
			array_push($total_array, $score_taf);
		} else {
			$score_taf = 0;
			array_push($total_array, $score_taf);
		}
		///////////////////////////end taf//////////////////////////////////////

		/////////////////////////////tbf//////////////////////////////////
		if ($tbf >= 70) {
			$score_tbf = -2;
			array_push($total_array, $score_tbf);
		} else {
			$score_tbf = 0;
			array_push($total_array, $score_tbf);
		}
		///////////////////////////end tbf//////////////////////////////////////

		////////////////////////// DEPTH SCORE //////////////////////////////////
			$score_depth = $depth_pressure * 1;
			array_push($total_array, $score_depth);

		///////////////////End Depth Score /////////////////////////////////////

		////////////////////////// SWING SCORE //////////////////////////////////
		if ($swing_status == 'LL') {
			$score_swing_status = -2;
			array_push($total_array, $score_swing_status);
		} elseif ($swing_status == 'LH') {
			$score_swing_status = -1;
			array_push($total_array, $score_swing_status);
		} elseif ($swing_status == 'HL') {
			$score_swing_status = 1;
			array_push($total_array, $score_swing_status);
		} elseif ($swing_status == 'HH') {
			$score_swing_status = 2;
			array_push($total_array, $score_swing_status);
		}
		///////////////////End SWING Score /////////////////////////////////////

		////////////////////////// Barrier SCORE //////////////////////////////////
		if ($barrier_side == 'down') {
			$score_barrier = 2;
			array_push($total_array, $score_barrier);
		} elseif ($barrier_side == 'up') {
			$score_barrier = -2;
			array_push($total_array, $score_barrier);
		}
		///////////////////End Barrier Score /////////////////////////////////////

		////////////////////////// Black Score //////////////////////////////////
		if ($black_pressure >= 5) {
			$score_black = 5;
		} else {
			$score_black = $black_pressure;
		}

			array_push($total_array, $score_black);
		///////////////////End Black Score /////////////////////////////////////

		////////////////////////// Yellow Score //////////////////////////////////
		if ($yellow_pressure >= 4) {
			$score_yellow = 4;
		} else {
			$score_yellow = $yellow_pressure;
		}

			$score_yellow = $score_yellow * 1;
			array_push($total_array, $score_yellow);
		///////////////////End Yellow Score /////////////////////////////////////

		////////////////////////// Seven Level Score //////////////////////////////////
		if ($seven_level <= 0.5) {
			$score_seven = 1;
		} elseif ($seven_level <= 1) {
			$score_seven = 2;
		} elseif ($seven_level <= 2) {
			$score_seven = 3;
		} elseif ($seven_level <= 3) {
			$score_seven = 4;
		} else {
			$score_seven = 5;
		}

			array_push($total_array, $score_seven);
		///////////////////End Seven Level Score /////////////////////////////////////

		////////////////////////// Buyers Level Score //////////////////////////////////
		if ($buyers <= 25) {
			$score_buyers = 1;
			array_push($total_array, $score_buyers);
		} elseif ($buyers <= 40) {
			$score_buyers = 2;
			array_push($total_array, $score_buyers);
		} elseif ($buyers <= 60) {
			$score_buyers = 3;
			array_push($total_array, $score_buyers);
		} elseif ($buyers <= 80) {
			$score_buyers = 4;
			array_push($total_array, $score_buyers);
		} elseif ($buyers <= 100) {
			$score_buyers = 5;
			array_push($total_array, $score_buyers);
		}
		///////////////////End Buyers Level Score /////////////////////////////////////

		////////////////////////// sellers Level Score //////////////////////////////////
		if ($sellers <= 25) {
			$score_sellers = -1;
			array_push($total_array, $score_sellers);
		} elseif ($sellers <= 40) {
			$score_sellers = -2;
			array_push($total_array, $score_sellers);
		} elseif ($sellers <= 60) {
			$score_sellers = -3;
			array_push($total_array, $score_sellers);
		} elseif ($sellers <= 80) {
			$score_sellers = -4;
			array_push($total_array, $score_sellers);
		} elseif ($sellers <= 100) {
			$score_sellers = -5;
			array_push($total_array, $score_sellers);
		}
		///////////////////End sellers Level Score /////////////////////////////////////

		////////////////////////// 200 asks Level Score //////////////////////////////////
		if ($t_h_a >= 25 && $t_h_a <= 50) {
			$score_t_h_a = 1;
			array_push($total_array, $score_t_h_a);
		} elseif ($t_h_a >= 50 && $t_h_a <= 75) {
			$score_t_h_a = 2;
			array_push($total_array, $score_t_h_a);
		} elseif ($t_h_a >= 75) {
			$score_t_h_a = 3;
			array_push($total_array, $score_t_h_a);
		}
		///////////////////End 200 asks Level Score /////////////////////////////////////

		////////////////////////// 200 bids Level Score //////////////////////////////////
		if ($t_h_b >= 25 && $t_h_b <= 50) {
			$score_t_h_b = -1;
			array_push($total_array, $score_t_h_b);
		} elseif ($t_h_b >= 50 && $t_h_b <= 75) {
			$score_t_h_a = -2;
			array_push($total_array, $score_t_h_b);
		} elseif ($t_h_b >= 75) {
			$score_t_h_b = -3;
			array_push($total_array, $score_t_h_b);
		}
		///////////////////End 200 bids Level Score /////////////////////////////////////

		////////////////////////// Big Buyers Level Score //////////////////////////////////
		if ($big_buyers >= 10) {
			$score_big_buyers = 1;
			array_push($total_array, $score_big_buyers);
		} elseif ($big_buyers >= 20) {
			$score_big_buyers = 2;
			array_push($total_array, $score_big_buyers);
		} elseif ($big_buyers >= 40) {
			$score_big_buyers = 3;
			array_push($total_array, $score_big_buyers);
		} elseif ($big_buyers >= 60) {
			$score_big_buyers = 4;
			array_push($total_array, $score_big_buyers);
		} elseif ($big_buyers >= 80) {
			$score_big_buyers = 5;
			array_push($total_array, $score_big_buyers);
		} elseif ($big_buyers >= 90) {
			$score_big_buyers = 6;
			array_push($total_array, $score_big_buyers);
		}

		///////////////////End Big Buyers Level Score /////////////////////////////////////

		////////////////////////// Big Sellers Level Score //////////////////////////////////
		if ($big_sellers >= 10) {
			$score_big_sellers = -1;
			array_push($total_array, $score_big_sellers);
		} elseif ($big_sellers >= 20) {
			$score_big_sellers = -2;
			array_push($total_array, $score_big_sellers);
		} elseif ($big_sellers >= 40) {
			$score_big_sellers = -3;
			array_push($total_array, $score_big_sellers);
		} elseif ($big_sellers >= 60) {
			$score_big_sellers = -4;
			array_push($total_array, $score_big_sellers);
		} elseif ($big_sellers >= 80) {
			$score_big_sellers = -5;
			array_push($total_array, $score_big_sellers);
		} elseif ($big_sellers >= 90) {
			$score_big_sellers = -6;
			array_push($total_array, $score_big_sellers);
		}

		///////////////////End Big Sellers Level Score /////////////////////////////////////
		/////////////////////////Big Pressure ///////////////////////////////////////

		if ($big_pressure == 'downside') {
			$score_big = 2;
			array_push($total_array, $score_big);
		} elseif ($big_pressure == 'upside') {
			$score_big = -2;
			array_push($total_array, $score_big);
		}
		///////////////////////////////////End Big Prssure ////////////////////////

		//$total_score_prev = $score_depth + $score_black + $score_yellow + $score_seven + $score_buyers + $score_big + $score_barrier;
		$total_score = array_sum($total_array);

		$total_score = $total_score + 50;

		return $total_score;
	}

	public function get_contracts_one($symbol) {
		$contract_size = $this->mod_coins->get_coin_contract_size($symbol);

		$nowtime = date("Y-m-d H:i:s");
		//$nowtime = date('Y-m-d H:i:s', strtotime('-' . $contract_time . 'minutes'));

		$search_array['coin'] = $symbol;
		$search_array['created_date'] = array('$lte' => $this->mongo_db->converToMongodttime($nowtime));

		$this->mongo_db->where($search_array);
		$this->mongo_db->order_by(array('created_date' => -1));
		$get_arr = $this->mongo_db->get('market_trades');
		$bids = 0;
		$asks = 0;
		$last_time = null;
		$bid_quantity = 0;
		$ask_quantity = 0;
		$total_quantity = 0;

		foreach ($get_arr as $key => $value) {
			if (!empty($value)) {
				if ($value['maker'] == 'true') {
					$bid_quantity += $value['quantity'];
					$bids++;
				} elseif ($value['maker'] == 'false') {
					$ask_quantity += $value['quantity'];
					$asks++;
				}
				$total_quantity = $bid_quantity + $ask_quantity;
				if ($total_quantity >= $contract_size) {
					$last_time = $value['created_date'];
					break;
				}
			}
		}
		if (!empty($last_time)) {
			$new_time = $last_time->toDateTime();
			$new_time = $new_time->format("Y-m-d H:i:s");
			$time = $this->time_elapsed_string($new_time);
		}else{
			$time = "0 min ago";
		}

		$bid_per = ($bid_quantity / $total_quantity) * 100;
		$ask_per = ($ask_quantity / $total_quantity) * 100;

		$array = array(
			"bid_quantity" => ($bid_quantity),
			"ask_quantity" => ($ask_quantity),
			"bids" => round($bid_per),
			"asks" => round($ask_per),
			"time_string" => $time,
		);

		return $array;

	}

	public function get_contracts_two($symbol) {

		$nowtime = date("Y-m-d H:i:s");
		//$nowtime = date('Y-m-d H:i:s', strtotime('-' . $contract_time . 'minutes'));

		$search_array['coin'] = $symbol;
		$search_array['created_date'] = array('$lte' => $this->mongo_db->converToMongodttime($nowtime));
		$contract_period = $this->mod_coins->get_coin_contract_period($symbol);
		$this->mongo_db->where($search_array);
		$this->mongo_db->limit($contract_period);
		$this->mongo_db->order_by(array('created_date' => -1));
		$get_arr = $this->mongo_db->get('market_trades');
		$bids = 0;
		$asks = 0;
		$last_time = null;
		$bid_quantity = 0;
		$ask_quantity = 0;
		$total_quantity = 0;
		foreach ($get_arr as $key => $value) {
			if (!empty($value)) {
				if ($value['maker'] == 'true') {
					$bid_quantity += $value['quantity'];
					$bids++;
				} elseif ($value['maker'] == 'false') {
					$ask_quantity += $value['quantity'];
					$asks++;
				}
				$last_time = $value['created_date'];
			}
		}
		$total_quantity = $bid_quantity + $ask_quantity;
		$new_time = $last_time->toDateTime();
		$new_time = $new_time->format("Y-m-d H:i:s");
		$time = $this->time_elapsed_string($new_time);
		$bid_per = ($bid_quantity / $total_quantity) * 100;
		$ask_per = ($ask_quantity / $total_quantity) * 100;

		$array = array(
			"bid_quantity" => ($bid_quantity),
			"ask_quantity" => ($ask_quantity),
			"bids" => round($bid_per),
			"asks" => round($ask_per),
			"time_string" => $time,
		);

		return $array;

	}

	function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;
		$day = $diff->d;
		$dayc = (24 * $day) * 60;
		$hrs = $diff->h;
		$hrsc = $hrs * 60;
		$mins = $diff->i;
		$sec = $diff->s;
		$secc = $sec / 60;
		$Tmins = round($dayc + $hrsc + $mins + $secc);

		return " " . $Tmins . " min ago";

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'min',
			's' => 'sec',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) {
			$string = array_slice($string, 0, 1);
		}

		return $string ? implode(', ', $string) . '' : 'just now';
	}

	public function get_barrier_value($market_value, $symbol, $type) {
		if ($type == 'up') {
			$search_arr['barier_value'] = array('$gte' => (float) $market_value);
		}
		if ($type == 'down') {
			$search_arr['barier_value'] = array('$lte' => (float) $market_value);
		}
		$search_arr['coin'] = $symbol;
		$search_arr['barrier_type'] = $type;
		$this->mongo_db->where($search_arr);
		$this->mongo_db->order_by(array('created_date' => -1));
		$this->mongo_db->limit(1);
		$depth_responseArr = $this->mongo_db->get('barrier_values_collection');

		$arr = iterator_to_array($depth_responseArr);
		$barrier = num($arr[0]['barier_value']);

		return $barrier;
	}

	public function calculate_pressure_up_and_down($datetime, $coin, $pressure_type) {
		$start_date = $datetime;
		$end_date = date('Y-m-d H:i:s', strtotime("+59 minutes", strtotime($datetime)));
		$this->mongo_db->where_gte('created_date', $this->mongo_db->converToMongodttime($start_date));
		$this->mongo_db->where_lt('created_date', $this->mongo_db->converToMongodttime($end_date));
		$this->mongo_db->where(array('coin' => $coin, 'pressure' => $pressure_type));
		$this->mongo_db->limit(100);
		$this->mongo_db->order_by(array('created_date' => -1));
		$res = $this->mongo_db->get('order_book_pressure');
		$res_arr = iterator_to_array($res);

		return $total_pressure = count($res_arr);
	} //End of calculate_pressure_up_and_down

	public function get_all_metadata($symbol = '') {
		if (!empty($symbol)) {
			$this->mongo_db->where('coin', $symbol);
		}
		$res = $this->mongo_db->get('coin_meta');

		echo "<pre>";

		print_r(iterator_to_array($res));

		exit;
	}

	public function view_coin_meta() {
		//Login Check
		$this->mod_login->verify_is_admin_login();
		$res = $this->mongo_db->get('coin_meta');
		$res_arr = iterator_to_array($res);

		$data['info'] = $res_arr;
		$this->stencil->paint("admin/coin_meta/coin_meta", $data);
	}

	public function autoload_meta() {
		//Login Check
		$this->mod_login->verify_is_admin_login();
		$res = $this->mongo_db->get('coin_meta');
		$info = iterator_to_array($res);
		$response = '';
		if (count($info) > 0) {
			foreach ($info as $key => $value) {
				$response .= '<div class="widget widget-inverse">

		          <!-- Widget heading -->
		          <div class="widget-head">
		           <span style="float:left;"> <h4 class="heading">' . $value['coin'] . '</h4></span>
		            <span style="float:right; padding: 5px auto;"><a href="#" id="edtbtn" data-coin="' . $value['coin'] . '" data-channel="' . $value['channel'] . '" class="btn btn-info">Edit</a></span>
		            <span style="float:right; padding: 5px auto;"><a href="' . SURL . 'admin/coin_meta/delete_meta/' . $value['coin'] . '" class="btn btn-primary">Delete</a></span>
		          </div>
		          <div class="widget-body">

		            <!-- 4 Column Grid / One Fourth -->
		            <div class="row">

		              <!-- One Fourth Column -->
		              <div class="col-md-3">
		                <h4>Current Market Value</h4>
		                <p>' . num($value['current_market_value']) . '</p>
		              </div>
		              <!-- // One Fourth Column END -->
		              <div class="col-md-3">
		                <h4>Black Wall Difference</h4>
		                <p>' . ($value['black_wall_pressure']) . '</p>
		              </div>

		            <!-- // One Fourth Column END -->
		              <div class="col-md-3">
		                <h4>Yellow Wall Difference</h4>
		                <p>' . ($value['yellow_wall_pressure']) . '</p>
		              </div>

		            <!-- // One Fourth Column END -->
		              <div class="col-md-3">
		                <h4>Pressure Difference</h4>
		                <p>' . ($value['pressure_diff']) . '</p>
		              </div>

		            <!-- // One Fourth Column END -->
		              <div class="col-md-3">
		                <h4>Ask Contracts</h4>
		                <p>' . number_format_short($value['ask_contract']) . '</p>
		              </div>

		            <!-- // One Fourth Column END -->
		              <div class="col-md-3">
		                <h4>Ask Contracts (%)</h4>
		                <p>' . number_format($value['ask_percentage'], 2) . '</p>
		              </div>

		            <!-- // One Fourth Column END -->
		              <div class="col-md-3">
		                <h4>Bid Contracts</h4>
		                <p>' . number_format_short($value['bid_contracts']) . '</p>
		              </div>

		            <!-- // One Fourth Column END -->
		              <div class="col-md-3">
		                <h4>Bid Contracts (%)</h4>
		                <p>' . number_format($value['bid_percentage'], 2) . '</p>
		              </div>

		               <!-- // One Fourth Column END -->
		              <div class="col-md-3">
		                <h4>Buyers</h4>
		                <p>' . number_format_short($value['buyers']) . '</p>
		              </div>
		                <!-- // One Fourth Column END -->
		              <div class="col-md-3">
		                <h4>Buyers (%)</h4>
		                <p>' . number_format($value['buyers_percentage'], 2) . '</p>
		              </div>
		                <!-- // One Fourth Column END -->
		              <div class="col-md-3">
		                <h4>Sellers</h4>
		                <p>' . number_format_short($value['sellers']) . '</p>
		              </div>
		              <div class="col-md-3">
		                <h4>Sellers percentage</h4>
		                <p>' . number_format($value['sellers_percentage'], 2) . '</p>
		              </div>
		                <!-- // One Fourth Column END -->
		              <div class="col-md-3">
		                <h4>Buyers Sellers Difference</h4>
		                <p style="color:' . $value['trade_type'] . ';">' . number_format($value['sellers_buyers_per'], 2) . '</p>
		              </div>
		              <div class="col-md-3">
		                <h4>Up Big Wall</h4>
		                <p>' . num($value['up_big_price']) . "(" . number_format_short($value['up_big_wall']) . ")" . '</p>
		              </div>
		              <!-- // One Fourth Column END -->
		             <div class="col-md-3">
		                <h4>Down Big Wall</h4>
		                <p>' . num($value['down_big_price']) . "(" . number_format_short($value['down_big_wall']) . ")" . '</p>
		              </div>
		              <!-- // One Fourth Column END -->
		              <div class="col-md-3">
		                <h4>Great Big Wall</h4>
		                <p style="color:' . $value['great_wall_color'] . ';">' . num($value['great_wall_price']) . "(" . number_format_short($value['great_wall_quantity']) . ")" . '</p>
		              </div>
		              <!-- // One Fourth Column END -->
		              <div class="col-md-3">
		                <h4>Great Wall Pressure</h4>
		                <p>' . ($value['great_wall']) . '</p>
		              </div>
		              <!-- // One Fourth Column END -->
		              <div class="col-md-3">
		                <h4>Seven Level Depth</h4>
		                <p>';
				if ($value['seven_level_type'] == 'negitive') {
					$response .= "-" . number_format($value['seven_level_depth'], 2);
				} else {
					$response .= number_format($value['seven_level_depth'], 2);
				}
				$response .= '</p>
		              </div>
		            <!-- // 4 Column Grid / One Fourth END -->
		          </div>
		      </div>
		      </div>';
			}
		}
		echo $response;
		exit;
	}

	public function delete_meta($coin_symbol = '') {
		//Login Check
		$this->mod_login->verify_is_admin_login();
		$this->mongo_db->where('coin', $coin_symbol);
		$this->mongo_db->delete('coin_meta');

		redirect($_SERVER['HTTP_REFERER']);
	} //End delete_meta()

	public function edit_meta() {
		//Login Check
		$this->mod_login->verify_is_admin_login();
		$data_Arr = $this->input->post();

		$coin = $data_Arr['coin'];

		$upd_arr = array(
			'channel' => $data_Arr['channel'],
		);

		$this->mongo_db->where('coin', $coin);
		$this->mongo_db->set($upd_arr);
		$this->mongo_db->update('coin_meta');

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function calculate_fifteen_minutes_contracts($symbol) {

		$datetime = date("Y-m-d H:i:s", strtotime('-15 minutes'));
		$orig_date22 = new DateTime($datetime);
		$orig_date22 = $orig_date22->getTimestamp();
		$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);

		$search['created_date'] = array('$gte' => $end_date);
		$search['coin'] = $symbol;
		$search['maker'] = 'true';

		$this->mongo_db->where($search);
		$get = $this->mongo_db->get("market_trades");

		$res = iterator_to_array($get);
		$bid_vol = 0;
		foreach ($res as $key => $value) {
			$vol = $value['quantity'];
			$bid_vol += $vol;
		}

		$search['created_date'] = array('$gte' => $end_date);
		$search['coin'] = $symbol;
		$search['maker'] = 'false';

		$this->mongo_db->where($search);
		$get = $this->mongo_db->get("market_trades");

		$res = iterator_to_array($get);
		$ask_vol = 0;
		foreach ($res as $key => $value) {
			$vol = $value['quantity'];
			$ask_vol += $vol;
		}
		$total_volume = $bid_vol + $ask_vol;

		/*$bid_per = ($bid_vol * 100) / $total_volume;
			$ask_per = ($ask_vol * 100) / $total_volume;
			$current = array(
				'bid_vol' => $bid_vol,
				'ask_vol' => $ask_vol,
		*/
		/*echo $bid_vol;
			echo "<br>";
			echo $ask_vol;
		*/
		$bid_ask_volume = $this->get_bid_ask_volume($symbol);
		/*echo "<pre>";
		print_r($bid_ask_volume);*/
		$bids = $bid_ask_volume['bids'];
		$asks = $bid_ask_volume['asks'];
		$bid_index = 0;
		$ask_index = 0;
		for ($i = 0; $i < count($bids); $i++) {
			if ($bid_vol <= $bids[$i]) {
				$bid_index = $i;
				break;
			}
		}

		for ($i = 0; $i < count($asks); $i++) {
			if ($ask_vol <= $asks[$i]) {
				$ask_index = $i;
				break;
			}
		}

		/*echo $bid_index;
			echo "<br>";
			echo $ask_index;
		*/
		//$demand_percentage_index = round((count($volume_arr) / 100) * $reject_per);
		$bid_level_percentage = ($bid_index / 100) * 100;
		$ask_level_percentage = ($ask_index / 100) * 100;

		/*echo $bid_level_percentage;
			echo "<br>";
			echo $ask_level_percentage;
		*/

		return array('bid' => $bid_level_percentage, 'ask' => $ask_level_percentage);
	}
	public function get_bid_ask_volume($coin_symbol) {

		$this->mongo_db->where(array('coin' => $coin_symbol));
		$this->mongo_db->limit(100);
		$this->mongo_db->sort(array('_id' => -1));

		$responseArr222 = $this->mongo_db->get('fifteen_min_market_history');

		$ers = iterator_to_array($responseArr222);
		$bid_array = array();
		$ask_array = array();
		foreach ($ers as $key => $value) {
			$bid_array[] = $value['bid_quantity'];
			$ask_array[] = $value['ask_quantity'];
		}
		sort($bid_array);
		sort($ask_array);
		$full_arr['bids'] = $bid_array;
		$full_arr['asks'] = $ask_array;

		return $full_arr;
	}

	public function meta_test($symbol = "NCASHBTC")
	{
		// $start_date = '2018-11-22 13:01:07';
		// $end_date = '2018-11-22 13:10:05';
		$search['coin'] = $symbol;
		//$search['modified_date'] = array('$gte' => $this->mongo_db->converToMongodttime($start_date), '$lte' => $this->mongo_db->converToMongodttime($end_date));
		$this->mongo_db->where($search);

		$this->mongo_db->order_by(array('_id'=>-1));
		$this->mongo_db->limit(10);
		$get_obj = $this->mongo_db->get('coin_meta_history');
		$get_arr = iterator_to_array($get_obj);

		echo "<pre>";
		print_r($get_arr);
		exit;
	}

	public function mytest()
	{
		$db = $this->mongo_db->customQuery();
		$ins_data = $db->chart3_group->count();
		echo $ins_data;
	}

	public function delete_old_data() {
		//date_default_timezone_set("ASIA/KARACHI");
		$created_date = date('Y-m-d H:i:s', strtotime('-2 minutes'));
		echo $created_date;
		echo "<br>";
		$db = $this->mongo_db->customQuery();

		///////////////////////////////////////////////////////////////
		$delectchart4 = $db->chart3_group->deleteMany(array('created_date' => array('$lte' => $this->mongo_db->converToMongodttime($created_date))));
		echo "<pre>";
		print_r($delectchart4);
		exit;
	}

	public function get_market_depth_group($coin_symbol,$last_barrrier_value,$depth_type){
		$coin_offset_value = $this->mod_coins->get_coin_offset_value($coin_symbol);
		$coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);

		$this->load->model('admin/mod_barrier_trigger');

			$depth_type = 'bid';
			$total_bid_quantity = 0;
			for ($i = 0; $i < $coin_offset_value; $i++) {
				$new_last_barrrier_value = '';
				$new_last_barrrier_value = $last_barrrier_value - ($coin_unit_value * $i);
				$bid = $this->mod_barrier_trigger->get_market_volume($new_last_barrrier_value, $coin_symbol, $type = 'bid');
				$total_bid_quantity += $bid;
			}
			$barrier_quantity = $total_bid_quantity;

			return $barrier_quantity;
	}

	public function get_market_depth_group_ask($coin_symbol,$last_barrrier_value,$depth_type){
		$coin_offset_value = $this->mod_coins->get_coin_offset_value($coin_symbol);
		$coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);

		$this->load->model('admin/mod_barrier_trigger');

			$depth_type = 'ask';
			$total_bid_quantity = 0;
			for ($i = 0; $i < $coin_offset_value; $i++) {
				$new_last_barrrier_value = '';
				$new_last_barrrier_value = $last_barrrier_value + ($coin_unit_value * $i);
				$bid = $this->mod_barrier_trigger->get_market_volume($new_last_barrrier_value, $coin_symbol, $type = 'ask');
				$total_bid_quantity += $bid;
			}
			$barrier_quantity = $total_bid_quantity;

			return $barrier_quantity;
	}

}
