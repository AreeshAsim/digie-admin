<?php
/**
 *
 */
class Script extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("admin/mod_coins");
	}
	public function index() {
		$this->mongo_db->insert('pressure_count', array('count' => 0, 'datetime' => 1535068800));

		$this->mongo_db->order_by(array('count' => -1));
		$this->mongo_db->limit(1);
		$get = $this->mongo_db->get('pressure_count');
		$get_Arr = iterator_to_array($get);
		echo count($get_Arr);
		echo "<br>";
		$datetime = $get_Arr[0]['datetime'];

		echo $datetime = date('Y-m-d H:i:s', $datetime);
		echo "<pre>";
		print_r(array("Hellow World"));
		exit;

	}
	public function calculate_pressure() {
		$this->load->model('admin/mod_coins');
		$coin_array = $this->mod_coins->get_all_coins();
		foreach ($coin_array as $key => $value) {
			$symbol = $value['symbol'];
			$offset = $this->mod_coins->get_coin_offset_value($symbol);
			$final_array = $this->get_remainder_data($symbol);
			$ask_array = $final_array['asks'];
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

					$depth_buy_quantity += $val['quantity'];
					$sumArray['quantity'] = $depth_buy_quantity;
					$sumArray['coin'] = $val['coin'];
					$sumArray['type'] = $val['type'];
					$sumArray['price'] = num($price);

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

					$depth_buy_quantity += $val['quantity'];
					$sumArray['quantity'] = $depth_buy_quantity;

					$sumArray['price'] = $price;
					$sumArray['coin'] = $val['coin'];
					$sumArray['type'] = $val['type'];
					$sumArray['price'] = num($price);

				}
				$new_bid_arr[] = $sumArray;
			}

			$market_sell_depth_arr = $new_bid_arr;
			array_multisort(array_column($market_sell_depth_arr, "price"), SORT_DESC, $market_sell_depth_arr);
			$market_value = $final_array['market_value'];
			$fullarray = array();
			for ($i = 0; $i < 5; $i++) {
				$ret_Arr = array();
				if ($market_sell_depth_arr[$i]['quantity'] > $market_buy_depth_arr[$i]['quantity']) {
					$pressure = 'up';
					$pressure_amount = ($market_sell_depth_arr[$i]['quantity'] / $market_buy_depth_arr[$i]['quantity']);
				} elseif ($market_sell_depth_arr[$i]['quantity'] < $market_buy_depth_arr[$i]['quantity']) {
					$pressure = 'down';
					$pressure_amount = ($market_buy_depth_arr[$i]['quantity'] / $market_sell_depth_arr[$i]['quantity']);
				}
				if (is_infinite($pressure_amount)) {
					$pressure_amount = 0;
				}
				$ret_Arr['price'] = $market_value;
				$ret_Arr['created_date'] = $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'));
				$ret_Arr['created_date_human_readable'] = date('Y-m-d H:i:s');
				$ret_Arr['pressure'] = $pressure;
				$ret_Arr['pressure_amount'] = $pressure_amount;
				$ret_Arr['coin'] = $symbol;
				$ret_Arr['level'] = $i + 1;

				$this->mongo_db->insert('order_book_pressure', $ret_Arr);
				/*$fullarray[] = $ret_Arr;*/
			}
		}

	}

	public function get_pressure() {
		$this->mongo_db->limit(35);
		$this->mongo_db->order_by(array('created_date' => -1));
		$res = $this->mongo_db->get('order_book_pressure');

		echo "<pre>";
		print_r(iterator_to_array($res));
		exit;
	}

	public function get_remainder_data($symbol) {
		$this->load->model('admin/mod_script');
		$this->load->model('admin/mod_coins');
		$offset = $this->mod_coins->get_coin_offset_value($symbol);
		$coin_value = $this->mod_coins->get_coin_unit_value($symbol);
		$market_value = $this->mod_script->get_market_value($symbol);
		$limit = 5 * $offset;

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

			$returArr['price'] = $num_Val;
			$returArr['quantity'] = $depth_buy_quantity1;
			$returArr['type'] = 'ask';
			$returArr['coin'] = $symbol;
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

			$returArr['price'] = $val;
			$returArr['quantity'] = $depth_buy_quantity6;
			$returArr['type'] = 'bid';
			$returArr['coin'] = $symbol;
			$fullarray[] = $returArr;
		}
		$final_array['bid'] = $fullarray;
		$final_array['market_value'] = $market_value;
		return $final_array;
	}

	public function calculate_historical_pressure($datetime = 1535075940) {

		//mail("khan.waqar278@gmail.com", "Hello World Test", "Hellow world");
		$this->load->model('admin/mod_coins');
		$coin_array = $this->mod_coins->get_all_coins();

		$datetime = date('Y-m-d H:i:s', $datetime);

		for ($kk = 0; $kk < 60; $kk++) {
			$new_datetime = date('Y-m-d H:i:s', strtotime("+" . $kk . "minutes", strtotime($datetime)));
			if ($new_datetime == '2018-08-27 13:00:00') {
				exit();
			}
			foreach ($coin_array as $key => $value) {
				$symbol = $value['symbol'];
				$offset = $this->mod_coins->get_coin_offset_value($symbol);
				$final_array = $this->get_historical_remainder_data($symbol, $new_datetime);
				$ask_array = $final_array['asks'];
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

						$depth_buy_quantity += $val['quantity'];
						$sumArray['quantity'] = $depth_buy_quantity;
						$sumArray['coin'] = $val['coin'];
						$sumArray['type'] = $val['type'];
						$sumArray['price'] = num($price);

					}
					$new_ask_arr[] = $sumArray;
				}
				$market_buy_depth_arr = $new_ask_arr;
				array_multisort(array_column($market_buy_depth_arr, "price"), SORT_DESC, $market_buy_depth_arr);

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

						$depth_buy_quantity += $val['quantity'];
						$sumArray['quantity'] = $depth_buy_quantity;

						$sumArray['price'] = $price;
						$sumArray['coin'] = $val['coin'];
						$sumArray['type'] = $val['type'];
						$sumArray['price'] = num($price);

					}
					$new_bid_arr[] = $sumArray;
				}

				$market_sell_depth_arr = $new_bid_arr;
				array_multisort(array_column($market_sell_depth_arr, "price"), SORT_DESC, $market_sell_depth_arr);
				$market_value = $final_array['market_value'];
				$fullarray = array();
				for ($i = 0; $i < 5; $i++) {
					$ret_Arr = array();
					if ($market_sell_depth_arr[$i]['quantity'] > $market_buy_depth_arr[$i]['quantity']) {
						$pressure = 'up';
						$pressure_amount = ($market_sell_depth_arr[$i]['quantity'] / $market_buy_depth_arr[$i]['quantity']);
					} elseif ($market_sell_depth_arr[$i]['quantity'] < $market_buy_depth_arr[$i]['quantity']) {
						$pressure = 'down';
						$pressure_amount = ($market_buy_depth_arr[$i]['quantity'] / $market_sell_depth_arr[$i]['quantity']);
					}

					$ret_Arr['price'] = $market_value;
					$ret_Arr['created_date'] = $this->mongo_db->converToMongodttime($new_datetime);
					$ret_Arr['created_date_human_readable'] = $new_datetime;
					$ret_Arr['pressure'] = $pressure;
					$ret_Arr['pressure_amount'] = $pressure_amount;
					$ret_Arr['coin'] = $symbol;
					$ret_Arr['level'] = $i + 1;

					$this->mongo_db->insert('order_book_pressure', $ret_Arr);
				}
			}
		}

		$count++;
		$this->mongo_db->insert('pressure_count', array('count' => $count, 'datetime' => strtotime($new_datetime)));

		$this->mongo_db->order_by(array('datetime' => -1));
		$this->mongo_db->limit(1);
		$get = $this->mongo_db->get('pressure_count');
		$get_Arr = iterator_to_array($get);
		$datetime = $get_Arr[0]['datetime'];
		$datetime = $datetime + 3600;
		$datetime_compare = date('Y-m-d H:i:s', $datetime);

		if (strtotime($datetime_compare) <= 1535374800) {
			$this->calculate_historical_pressure($datetime);
		}

	}

	public function delete_report() {
		echo date("Y-m-d H:i:s");
		$where['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime("2018-08-24 00:00:00"), '$lte' => $this->mongo_db->converToMongodttime("2018-08-25 23:59:59"));

		$this->mongo_db->where($where);

		$get = $this->mongo_db->get('order_book_pressure');

		echo "<pre>";
		print_r(iterator_to_array($get));
		exit;
	}

	public function get_historical_remainder_data($symbol, $datetime) {
		$this->load->model('admin/mod_chart3');
		$this->load->model('admin/mod_coins');

		$datetime2 = $this->mongo_db->converToMongodttime($datetime);

		$offset = $this->mod_coins->get_coin_offset_value($symbol);
		$coin_value = $this->mod_coins->get_coin_unit_value($symbol);
		$market_value = $this->mod_chart3->get_historical_market_value($symbol, $datetime);
		$limit = 5 * $offset;

		$valasss = $market_value;
		$fullarray = array();

		$value = num($market_value);

		$divider = num($offset * $coin_value);

		$remainder = fmod($value, $divider);

		$num_Val = $value + ($divider - $remainder);
		$val = $num_Val;
		for ($i = 0; $i < $limit; $i++) {
			$depth_buy_quantity1 = 0;
			$depth_buy_quantity2 = 0;
			$depth_buy_quantity3 = 0;
			$depth_buy_quantity4 = 0;
			if ($i != 0) {
				$num_Val += $coin_value;
			}
			$num_Val = trim($num_Val);
			$num_Val = (float) $num_Val;

			if ($num_Val < 0) {
				continue;
			}
			$this->mongo_db->where(array('type' => 'ask', 'coin' => $symbol, 'price' => $num_Val, 'modified_date' => array('$gte' => $datetime2)));
			$this->mongo_db->limit(1);
			$this->mongo_db->order_by(array('_id' => 1));
			$depth_responseArr5 = $this->mongo_db->get('market_depth_history');

			foreach ($depth_responseArr5 as $depth_valueArr5) {
				if (!empty($depth_valueArr5)) {
					$depth_buy_quantity1 += $depth_valueArr5['quantity'];
				}
			}
			$this->mongo_db->where(array('type' => 'bid', 'coin' => $symbol, 'price' => $num_Val, 'modified_date' => array('$gte' => $datetime2)));
			$this->mongo_db->limit(1);
			$this->mongo_db->order_by(array('_id' => 1));
			$depth_responseArr6 = $this->mongo_db->get('market_depth_history');

			foreach ($depth_responseArr6 as $depth_valueArr6) {
				if (!empty($depth_valueArr6)) {

					$depth_buy_quantity2 += $depth_valueArr6['quantity'];
				}
			}

			$returArr['price'] = $num_Val;
			$returArr['quantity'] = $depth_buy_quantity1;
			$returArr['type'] = 'ask';
			$returArr['coin'] = $symbol;
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
			$this->mongo_db->where(array('type' => 'ask', 'coin' => $symbol, 'price' => $num_Val, 'modified_date' => array('$gte' => $datetime2)));
			$this->mongo_db->limit(1);
			$this->mongo_db->order_by(array('_id' => 1));
			$depth_responseArr5 = $this->mongo_db->get('market_depth_history');
			foreach ($depth_responseArr5 as $depth_valueArr5) {
				if (!empty($depth_valueArr5)) {
					$depth_buy_quantity5 += $depth_valueArr5['quantity'];
				}
			}
			$this->mongo_db->where(array('type' => 'bid', 'coin' => $symbol, 'price' => $num_Val, 'modified_date' => array('$gte' => $datetime2)));
			$this->mongo_db->limit(1);
			$this->mongo_db->order_by(array('_id' => 1));
			$depth_responseArr6 = $this->mongo_db->get('market_depth_history');
			foreach ($depth_responseArr6 as $depth_valueArr6) {
				if (!empty($depth_valueArr6)) {

					$depth_buy_quantity6 += $depth_valueArr6['quantity'];
				}
			}

			$returArr['price'] = $val;
			$returArr['quantity'] = $depth_buy_quantity6;
			$returArr['type'] = 'bid';
			$returArr['coin'] = $symbol;
			$fullarray[] = $returArr;
		}
		$final_array['bid'] = $fullarray;
		$final_array['market_value'] = $market_value;
		return $final_array;
	}
	public function test($value='')
	{
		$db = $this->mongo_db->customQuery();
		$ncash_created_date = date('Y-m-d H:i:s', strtotime("-24 hours"));
		$search_ncash['created_date'] = array('$lte' => $this->mongo_db->converToMongodttime($ncash_created_date));
		$ncash_delete[] = $db->market_trade_history->deleteMany($search_ncash);
	}
	public function delete_market_depth_history() {
		$db = $this->mongo_db->customQuery();

		$ncash_created_date = date('Y-m-d H:i:s', strtotime("-3 days"));
		$ncash_created_date22 = date('Y-m-d H:i:s', strtotime("-3 days"));
		$search_ncash['created_date'] = array('$lte' => $this->mongo_db->converToMongodttime($ncash_created_date));
		$search_new['time'] = array('$lte' => $this->mongo_db->converToMongodttime($ncash_created_date22));
		$ncash_delete[] = $db->market_depth_history->deleteMany($search_ncash);
		$ncash_delete[] = $db->market_trade_history->deleteMany($search_ncash);
		$ncash_delete[] = $db->market_price_history->deleteMany($search_new);


		echo "<pre>";
		print_r($ncash_delete);
		exit;
	}

	public function delete_indicators() {

		$db = $this->mongo_db->customQuery();

		echo $ncash_created_date = date('Y-m-d 23:59:59', strtotime("-4 days"));
		$search_ncash['created_date'] = array('$lte' => $this->mongo_db->converToMongodttime($ncash_created_date));
		$search_new['created_date'] = array('$lte' => $this->mongo_db->converToMongodttime($ncash_created_date));
		$ncash_delete = $db->barrier_test_collection->deleteMany($search_new);

		/*$this->mongo_db->where("coin", "NCASHBTC");
			$this->mongo_db->where_lte("created_date", $this->mongo_db->converToMongodttime($ncash_created_date));
		*/
		/*$ncash_delete = $db->market_depth_history->deleteMany($search_ncash);

			$all_other_created_date = date('Y-m-d H:i:s', strtotime("-7 days"));
			$this->mongo_db->where_ne("coin", "NCASHBTC");
			$this->mongo_db->where_lte("created_date", $this->mongo_db->converToMongodttime($all_other_created_date));
			$get_arr = $this->mongo_db->delete_all("market_depth_history");
		*/

		/*$all_other_created_date = date('Y-m-d H:i:s', strtotime("-7 days"));
			$this->mongo_db->where_lte("created_date", $this->mongo_db->converToMongodttime($all_other_created_date));
			$get_arr = $this->mongo_db->delete_all("market_trade_history");

			$all_other_created_date = date('Y-m-d H:i:s', strtotime("-7 days"));
			$this->mongo_db->where_lte("time", $this->mongo_db->converToMongodttime($all_other_created_date));
			$get_arr = $this->mongo_db->delete_all("market_price_history");
		*/
		echo "<pre>";
		print_r($ncash_delete);
		exit;
	}

	public function update_candle_coin_meta() {
		$this->load->model('admin/mod_sockets');

		$all_coins_arr = $this->mod_sockets->get_all_coins();
		foreach ($all_coins_arr as $key => $value) {
			$coin_symbol = $value['symbol'];
			$this->mongo_db->where('coin', $coin_symbol);
			$this->mongo_db->limit(1);
			$this->mongo_db->order_by(array('timestampDate' => -1));
			$get_arr = $this->mongo_db->get('market_chart');
			$candle_arr = iterator_to_array($get_arr);
			$candle = $candle_arr[0];

			$open_time = $candle['openTime_human_readible'];
			$close_time = $candle['closeTime_human_readible'];
			$low = $candle['low'];

			$candle_id = $candle['_id'];

			$meta_arr = $this->get_coin_meta_for_candle($low, $open_time, $close_time, $coin_symbol);

			$update_arr = array(
				'black_wall_meta' => $meta_arr['black_wall_meta'],
				'last_200_qty' => $meta_arr['last_200_qty'],
				'last_qty_buy_vs_sell' => $meta_arr['last_qty_buy_vs_sell'],
				'last_qty_timeago' => $meta_arr['last_qty_timeago'],
				'score' => $meta_arr['score'],
				'seven_level_depth' => $meta_arr['seven_level_depth'],
				'market_depth_quantity' => $meta_arr['market_depth_quantity']
			);

			$this->mongo_db->where(array('_id' => $candle_id));
			$this->mongo_db->set($update_arr);
			$this->mongo_db->update('market_chart');

		}
	}
	public function get_coin_meta_for_candle($low, $open_time, $close_time, $symbol) {
		$this->load->model('admin/mod_coins');
		$unit_value = $this->mod_coins->get_coin_unit_value($symbol);
		$opentime = $this->mongo_db->converToMongodttime($open_time);
		$closetime = $this->mongo_db->converToMongodttime($close_time);
		$this->mongo_db->where(array('coin' => $symbol, 'market_value' => $low, 'time' => array('$gte' => $opentime, '$lte' => $closetime)));
		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('time' => -1));
		$get_arr22 = $this->mongo_db->get('market_price_history');
		$price_arr = iterator_to_array($get_arr22);


		if (!empty($price_arr)) {
			$price = $price_arr[0];
			$time = $price['time'];
		}else{
			$time = $this->mongo_db->converToMongodttime($close_time);
		}

		$this->mongo_db->where(array('coin' => $symbol, 'modified_date' => array('$lte' => $time)));
		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('modified_date' => -1));
		$get_arr222 = $this->mongo_db->get('coin_meta_history');
		$coin_meta_arr = iterator_to_array($get_arr222);
		$coin_meta = $coin_meta_arr[0];

		$black_wall_pressure = $coin_meta['black_wall_pressure'];
		$last_200_qty_x = $coin_meta['last_200_buy_vs_sell'];

		if ($last_200_qty_x - 1 >= 5) {
			$last_200_qty = 5;
		} else {
			$last_200_qty = $last_200_qty_x;
		}

		if ($last_200_qty - 1 <= -5) {
			$last_200_qty = -5;
		} else {
			$last_200_qty = $last_200_qty;
		}

		$last_qty_buy_vs_sell_x = (float) $coin_meta['last_qty_buy_vs_sell'];
		//echo $last_qty_buy_vs_sell_x - 1;

		if ($last_qty_buy_vs_sell_x - 1 >= 5) {
			$last_qty_buy_vs_sell = 5;
		} else {
			$last_qty_buy_vs_sell = $last_qty_buy_vs_sell_x;
		}

		if ($last_qty_buy_vs_sell - 1 <= -5) {
			$last_qty_buy_vs_sell = -5;
		} else {
			$last_qty_buy_vs_sell = $last_qty_buy_vs_sell;
		}

		$last_qty_timeago = (int) str_replace(' min ago', '', $coin_meta['last_qty_time_ago']);

		if ($last_qty_timeago >= 50) {
			$last_qty_timeago = 50;
		} else {
			$last_qty_timeago = $last_qty_timeago;
		}

		$score = $coin_meta['score'] - 50;

		$market_depth_quantity = $coin_meta['market_depth_quantity'];
		$seven_level_depth = $coin_meta['seven_level_depth'];
		$seven_level_type = $coin_meta['seven_level_type'];

		if ($seven_level_type == 'negitive') {
			$seven_level_depth = $seven_level_depth * -1;
		}

		$coin_arr = array(
			'black_wall_meta' => $black_wall_pressure,
			'last_200_qty' => $last_200_qty,
			'last_qty_buy_vs_sell' => $last_qty_buy_vs_sell,
			'last_qty_timeago' => $last_qty_timeago,
			'score' => $score,
			'seven_level_depth' => $seven_level_depth,
			'market_depth_quantity' => $market_depth_quantity
		);
		return $coin_arr;

	}

	public function update_candle_coin_meta_fif() {
		$this->load->model('admin/mod_sockets');
		$all_coins_arr = $this->mod_sockets->get_all_coins();
		foreach ($all_coins_arr as $key => $value) {
			echo $coin_symbol = $value['symbol'];
			$this->mongo_db->where('coin', $coin_symbol);
			$this->mongo_db->limit(1);
			$this->mongo_db->order_by(array('timestampDate' => -1));
			$get_arr = $this->mongo_db->get('market_chart_fifteen_minutes');
			$candle_arr = iterator_to_array($get_arr);
			$candle = $candle_arr[0];

			$open_time = $candle['openTime_human_readible'];
			$close_time = $candle['closeTime_human_readible'];
			$low = $candle['low'];

			$candle_id = $candle['_id'];

			$meta_arr = $this->get_coin_meta_for_candle_fif($coin_symbol, $open_time, $close_time);

			$update_arr = array(
				'blackwall' => $meta_arr['blackwall'],
				'sevenlevel' => $meta_arr['sevenlevel'],
				'bid_quantity' => $meta_arr['bid_quantity'],
				'ask_quantity' => $meta_arr['ask_quantity'],
				'blackwall_percentile' => $meta_arr['blackwall_percentile'],
				'sevenlevel_percentile' => $meta_arr['sevenlevel_percentile'],
				'bid_percentile' => $meta_arr['bid_percentile'],
				'ask_percentile' => $meta_arr['ask_percentile'],
			);

			$this->mongo_db->where(array('_id' => $candle_id));
			$this->mongo_db->set($update_arr);
			$this->mongo_db->update('market_chart_fifteen_minutes');

		}
	}
	public function get_coin_meta_for_candle_fif($global_symbol,$start_date_1,$end_date_1){
		$calculated_array = $this->get_all_indicators_from_last_week($global_symbol,$start_date_1);
		$indicator_arr = $this->get_all_indicators($global_symbol, $start_date_1, $end_date_1);

		if ($indicator_arr['blackwall'] >= $calculated_array['blackwall']) {
					$candel_stick_single_arr['blackwall'] = "true";
					$candel_stick_single_arr['blackwall_percentile'] = $indicator_arr['blackwall'];
		}else{
				$candel_stick_single_arr['blackwall'] = "false";
				$candel_stick_single_arr['blackwall_percentile'] = $indicator_arr['blackwall'];
		}
		if ($indicator_arr['sevenlevel'] >= $calculated_array['sevenlevel']) {
					$candel_stick_single_arr['sevenlevel'] = "true";
					$candel_stick_single_arr['sevenlevel_percentile'] = $indicator_arr['sevenlevel'];
		}else{
			$candel_stick_single_arr['sevenlevel'] = "false";
			$candel_stick_single_arr['sevenlevel_percentile'] = $indicator_arr['sevenlevel'];
		}
		if ($indicator_arr['bid_quantity'] >= $calculated_array['bid_quantity']) {
				$candel_stick_single_arr['bid_quantity'] = "true";
				$candel_stick_single_arr['bid_percentile'] = $indicator_arr['bid_quantity'];
		}else{
				$candel_stick_single_arr['bid_quantity'] = "false";
				$candel_stick_single_arr['bid_percentile'] = $indicator_arr['bid_quantity'];
		}
		if ($indicator_arr['ask_quantity'] >= $calculated_array['ask_quantity']) {
				$candel_stick_single_arr['ask_quantity'] = "true";
				$candel_stick_single_arr['ask_percentile'] = $indicator_arr['ask_quantity'];
		}else{
			$candel_stick_single_arr['ask_quantity'] = "false";
				$candel_stick_single_arr['ask_percentile'] = $indicator_arr['ask_quantity'];
		}

			return $candel_stick_single_arr;
	}
	public function get_all_indicators_from_last_week($coin_symbol,$date)
	{
      $start_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-24 hours",strtotime($date))));
      $end_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime($date)));
      $search_array = array(
  			'coin' => $coin_symbol,
  			'modified_date' => array('$gte' => $start_date, '$lte' => $end_date));

  		$this->mongo_db->where($search_array);
  		$res = $this->mongo_db->get('coin_meta_history');
  		$ask_volume_arr = iterator_to_array($res);

  		$volume_Arr = array_column($ask_volume_arr, 'black_wall_pressure');

			rsort($volume_Arr);
      $black_wall_percentile_index = round((count($volume_Arr) / 100) * 10);
      $black_wall_percentile = $volume_Arr[$black_wall_percentile_index];
      $ret_arr['blackwall'] =  $black_wall_percentile;

      $seven_level_depth = array_column($ask_volume_arr, 'seven_level_depth');
      rsort($seven_level_depth);
      $seven_level_depth_percentile_index = round((count($seven_level_depth) / 100) * 10);
      $seven_level_depth_percentile = $seven_level_depth[$seven_level_depth_percentile_index];
      $ret_arr['sevenlevel'] =  $seven_level_depth_percentile;

      $market_depth_quantity = array_column($ask_volume_arr, 'market_depth_quantity');
      rsort($market_depth_quantity);
      $market_depth_quantity_percentile_index = round((count($market_depth_quantity) / 100) * 10);
      $market_depth_quantity_percentile = $market_depth_quantity[$market_depth_quantity_percentile_index];
      $ret_arr['bid_quantity'] =  $market_depth_quantity_percentile;

  		$market_depth_ask = array_column($ask_volume_arr, 'market_depth_ask');
      rsort($market_depth_ask);
      $market_depth_ask_percentile_index = round((count($market_depth_ask) / 100) * 10);
      $market_depth_ask_percentile = $market_depth_ask[$market_depth_ask_percentile_index];
      $ret_arr['ask_quantity'] =  $market_depth_ask_percentile;
			return $ret_arr;
    }

	public function get_all_indicators($coin_symbol, $start_date, $end_date){
		$start_date = $this->mongo_db->converToMongodttime($start_date);
		$end_date = $this->mongo_db->converToMongodttime($end_date);
		$search_array = array(
		'coin' => $coin_symbol,
		'modified_date' => array('$gte' => $start_date, '$lte' => $end_date));
		$this->mongo_db->where($search_array);
		$res = $this->mongo_db->get('coin_meta_history');
		$ask_volume_arr = iterator_to_array($res);

		$volume_Arr = array_column($ask_volume_arr, 'black_wall_pressure');
		rsort($volume_Arr);
		$ret_arr['blackwall'] =  array_sum($volume_Arr)/count($volume_Arr);

		$seven_level_depth = array_column($ask_volume_arr, 'seven_level_depth');
		rsort($seven_level_depth);
		$ret_arr['sevenlevel'] =  array_sum($seven_level_depth)/count($seven_level_depth);

		$market_depth_quantity = array_column($ask_volume_arr, 'market_depth_quantity');
		rsort($market_depth_quantity);
		$ret_arr['bid_quantity'] =  array_sum($market_depth_quantity)/count($market_depth_quantity);

		$market_depth_ask = array_column($ask_volume_arr, 'market_depth_ask');
		rsort($market_depth_ask);
		$ret_arr['ask_quantity'] =  array_sum($market_depth_ask)/count($market_depth_ask);

		return $ret_arr;
	}
	public function index_old() {
		$json = file_get_contents('https://app.digiebot.com/assets/json/test.json');
		exit("Hello");
		$obj = json_decode($json);
		$symbol_arr1 = $obj->symbols;
		$symbol_arr = (array) $symbol_arr1;
		foreach ($symbol_arr as $key => $value) {

			$value_live = (array) $value;
			echo "<pre>";

			$symbol = $value_live['symbol'];
			$min_notation = $value_live['filters'][2]->minNotional;
			$step_size = $value_live['filters'][1]->stepSize;
			$where_Arr = array('symbol' => $symbol);
			$update_arr = array('min_notation' => $min_notation, 'stepSize' => $step_size);

			$this->mongo_db->where($where_Arr);
			$this->mongo_db->set($update_arr);
			$this->mongo_db->update("market_min_notation");

			echo "Updated ".$symbol."<br>";
		}
	}

	public function get_min_notation() {
		$res = $this->mongo_db->get('market_min_notation');

		echo "<pre>";
		print_r(iterator_to_array($res));
		exit;
	}

	public function get_market_price_test() {

		$start = "2018-04-04 15:00:00";
		$created_datetime = date('Y-m-d G:i:s', strtotime($start));
		$orig_date = new DateTime($created_datetime);
		$orig_date = $orig_date->getTimestamp();
		$start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);
		$end = "2018-04-04 15:59:59";
		$created_datetime22 = date('Y-m-d G:i:s', strtotime($end));
		$orig_date22 = new DateTime($created_datetime22);
		$orig_date22 = $orig_date22->getTimestamp();
		$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
		$search_array['time'] = array('$gte' => $start_date, '$lte' => $end_date);

		$this->mongo_db->where($search_array);
		$res = $this->mongo_db->get('market_price_history');
		//$result = iterator_to_array($res);

		foreach ($res as $key => $value) {
			$datetime = $value['time']->toDateTime();
			$created_date = $datetime->format(DATE_RSS);

			$datetime = new DateTime($created_date);
			$formated_date_time = $datetime->format('Y-m-d g:i:s A');

			$result[$formated_date_time] = num($value['market_value']);
		}
		echo "<pre>";
		print_r($result);
		exit;
	}

	public function get_market_prices() {

		$date = date('Y-m-d H:i:s', strtotime('-24 hours'));
		$this->mongo_db->where(array('coin' => 'BNBBTC'));
		$this->mongo_db->where(array('time' => array('$gte' => $this->mongo_db->converToMongodttime($date))));
		$this->mongo_db->order_by(array('time' => -1));
		$res = $this->mongo_db->get('market_price_history');
		$result_arr = iterator_to_array($res);

		$count = count($result_arr);
		$new_number = (float) $result_arr[0]->market_value;
		$old_number = (float) $result_arr[$count - 1]->market_value;

		$number = (float) $new_number - $old_number;

		$per_number = (float) ($number / $new_number) * 100;

		echo "Change: " . num($number) . "<br>" . "Percentage: " . number_format($per_number, 2);
		exit;

	}

	public function insert_timezone_in_db() {
		$timezone_arr = $this->get_time_zone();

		foreach ($timezone_arr as $key => $value) {
			$ins_arr = array(
				'zone_name' => $value,
				'zone_key' => $key,
			);

			//$this->mongo_db->insert('timezones', $ins_arr);

		}

	}

	public function get_timezones() {
		$row = $this->mongo_db->geT('timezones');

		echo "<pre>";
		print_r(iterator_to_array($row));
		exit;
	}

	public function get_time_zone() {
		$timezones = array(
			'America/Adak' => '(GMT-10:00) America/Adak (Hawaii-Aleutian Standard Time)',
			'America/Atka' => '(GMT-10:00) America/Atka (Hawaii-Aleutian Standard Time)',
			'America/Anchorage' => '(GMT-9:00) America/Anchorage (Alaska Standard Time)',
			'America/Juneau' => '(GMT-9:00) America/Juneau (Alaska Standard Time)',
			'America/Nome' => '(GMT-9:00) America/Nome (Alaska Standard Time)',
			'America/Yakutat' => '(GMT-9:00) America/Yakutat (Alaska Standard Time)',
			'America/Dawson' => '(GMT-8:00) America/Dawson (Pacific Standard Time)',
			'America/Ensenada' => '(GMT-8:00) America/Ensenada (Pacific Standard Time)',
			'America/Los_Angeles' => '(GMT-8:00) America/Los_Angeles (Pacific Standard Time)',
			'America/Tijuana' => '(GMT-8:00) America/Tijuana (Pacific Standard Time)',
			'America/Vancouver' => '(GMT-8:00) America/Vancouver (Pacific Standard Time)',
			'America/Whitehorse' => '(GMT-8:00) America/Whitehorse (Pacific Standard Time)',
			'Canada/Pacific' => '(GMT-8:00) Canada/Pacific (Pacific Standard Time)',
			'Canada/Yukon' => '(GMT-8:00) Canada/Yukon (Pacific Standard Time)',
			'Mexico/BajaNorte' => '(GMT-8:00) Mexico/BajaNorte (Pacific Standard Time)',
			'America/Boise' => '(GMT-7:00) America/Boise (Mountain Standard Time)',
			'America/Cambridge_Bay' => '(GMT-7:00) America/Cambridge_Bay (Mountain Standard Time)',
			'America/Chihuahua' => '(GMT-7:00) America/Chihuahua (Mountain Standard Time)',
			'America/Dawson_Creek' => '(GMT-7:00) America/Dawson_Creek (Mountain Standard Time)',
			'America/Denver' => '(GMT-7:00) America/Denver (Mountain Standard Time)',
			'America/Edmonton' => '(GMT-7:00) America/Edmonton (Mountain Standard Time)',
			'America/Hermosillo' => '(GMT-7:00) America/Hermosillo (Mountain Standard Time)',
			'America/Inuvik' => '(GMT-7:00) America/Inuvik (Mountain Standard Time)',
			'America/Mazatlan' => '(GMT-7:00) America/Mazatlan (Mountain Standard Time)',
			'America/Phoenix' => '(GMT-7:00) America/Phoenix (Mountain Standard Time)',
			'America/Shiprock' => '(GMT-7:00) America/Shiprock (Mountain Standard Time)',
			'America/Yellowknife' => '(GMT-7:00) America/Yellowknife (Mountain Standard Time)',
			'Canada/Mountain' => '(GMT-7:00) Canada/Mountain (Mountain Standard Time)',
			'Mexico/BajaSur' => '(GMT-7:00) Mexico/BajaSur (Mountain Standard Time)',
			'America/Belize' => '(GMT-6:00) America/Belize (Central Standard Time)',
			'America/Cancun' => '(GMT-6:00) America/Cancun (Central Standard Time)',
			'America/Chicago' => '(GMT-6:00) America/Chicago (Central Standard Time)',
			'America/Costa_Rica' => '(GMT-6:00) America/Costa_Rica (Central Standard Time)',
			'America/El_Salvador' => '(GMT-6:00) America/El_Salvador (Central Standard Time)',
			'America/Guatemala' => '(GMT-6:00) America/Guatemala (Central Standard Time)',
			'America/Knox_IN' => '(GMT-6:00) America/Knox_IN (Central Standard Time)',
			'America/Managua' => '(GMT-6:00) America/Managua (Central Standard Time)',
			'America/Menominee' => '(GMT-6:00) America/Menominee (Central Standard Time)',
			'America/Merida' => '(GMT-6:00) America/Merida (Central Standard Time)',
			'America/Mexico_City' => '(GMT-6:00) America/Mexico_City (Central Standard Time)',
			'America/Monterrey' => '(GMT-6:00) America/Monterrey (Central Standard Time)',
			'America/Rainy_River' => '(GMT-6:00) America/Rainy_River (Central Standard Time)',
			'America/Rankin_Inlet' => '(GMT-6:00) America/Rankin_Inlet (Central Standard Time)',
			'America/Regina' => '(GMT-6:00) America/Regina (Central Standard Time)',
			'America/Swift_Current' => '(GMT-6:00) America/Swift_Current (Central Standard Time)',
			'America/Tegucigalpa' => '(GMT-6:00) America/Tegucigalpa (Central Standard Time)',
			'America/Winnipeg' => '(GMT-6:00) America/Winnipeg (Central Standard Time)',
			'Canada/Central' => '(GMT-6:00) Canada/Central (Central Standard Time)',
			'Canada/East-Saskatchewan' => '(GMT-6:00) Canada/East-Saskatchewan (Central Standard Time)',
			'Canada/Saskatchewan' => '(GMT-6:00) Canada/Saskatchewan (Central Standard Time)',
			'Chile/EasterIsland' => '(GMT-6:00) Chile/EasterIsland (Easter Is. Time)',
			'Mexico/General' => '(GMT-6:00) Mexico/General (Central Standard Time)',
			'America/Atikokan' => '(GMT-5:00) America/Atikokan (Eastern Standard Time)',
			'America/Bogota' => '(GMT-5:00) America/Bogota (Colombia Time)',
			'America/Cayman' => '(GMT-5:00) America/Cayman (Eastern Standard Time)',
			'America/Coral_Harbour' => '(GMT-5:00) America/Coral_Harbour (Eastern Standard Time)',
			'America/Detroit' => '(GMT-5:00) America/Detroit (Eastern Standard Time)',
			'America/Fort_Wayne' => '(GMT-5:00) America/Fort_Wayne (Eastern Standard Time)',
			'America/Grand_Turk' => '(GMT-5:00) America/Grand_Turk (Eastern Standard Time)',
			'America/Guayaquil' => '(GMT-5:00) America/Guayaquil (Ecuador Time)',
			'America/Havana' => '(GMT-5:00) America/Havana (Cuba Standard Time)',
			'America/Indianapolis' => '(GMT-5:00) America/Indianapolis (Eastern Standard Time)',
			'America/Iqaluit' => '(GMT-5:00) America/Iqaluit (Eastern Standard Time)',
			'America/Jamaica' => '(GMT-5:00) America/Jamaica (Eastern Standard Time)',
			'America/Lima' => '(GMT-5:00) America/Lima (Peru Time)',
			'America/Louisville' => '(GMT-5:00) America/Louisville (Eastern Standard Time)',
			'America/Montreal' => '(GMT-5:00) America/Montreal (Eastern Standard Time)',
			'America/Nassau' => '(GMT-5:00) America/Nassau (Eastern Standard Time)',
			'America/New_York' => '(GMT-5:00) America/New_York (Eastern Standard Time)',
			'America/Nipigon' => '(GMT-5:00) America/Nipigon (Eastern Standard Time)',
			'America/Panama' => '(GMT-5:00) America/Panama (Eastern Standard Time)',
			'America/Pangnirtung' => '(GMT-5:00) America/Pangnirtung (Eastern Standard Time)',
			'America/Port-au-Prince' => '(GMT-5:00) America/Port-au-Prince (Eastern Standard Time)',
			'America/Resolute' => '(GMT-5:00) America/Resolute (Eastern Standard Time)',
			'America/Thunder_Bay' => '(GMT-5:00) America/Thunder_Bay (Eastern Standard Time)',
			'America/Toronto' => '(GMT-5:00) America/Toronto (Eastern Standard Time)',
			'Canada/Eastern' => '(GMT-5:00) Canada/Eastern (Eastern Standard Time)',
			'America/Caracas' => '(GMT-4:-30) America/Caracas (Venezuela Time)',
			'America/Anguilla' => '(GMT-4:00) America/Anguilla (Atlantic Standard Time)',
			'America/Antigua' => '(GMT-4:00) America/Antigua (Atlantic Standard Time)',
			'America/Aruba' => '(GMT-4:00) America/Aruba (Atlantic Standard Time)',
			'America/Asuncion' => '(GMT-4:00) America/Asuncion (Paraguay Time)',
			'America/Barbados' => '(GMT-4:00) America/Barbados (Atlantic Standard Time)',
			'America/Blanc-Sablon' => '(GMT-4:00) America/Blanc-Sablon (Atlantic Standard Time)',
			'America/Boa_Vista' => '(GMT-4:00) America/Boa_Vista (Amazon Time)',
			'America/Campo_Grande' => '(GMT-4:00) America/Campo_Grande (Amazon Time)',
			'America/Cuiaba' => '(GMT-4:00) America/Cuiaba (Amazon Time)',
			'America/Curacao' => '(GMT-4:00) America/Curacao (Atlantic Standard Time)',
			'America/Dominica' => '(GMT-4:00) America/Dominica (Atlantic Standard Time)',
			'America/Eirunepe' => '(GMT-4:00) America/Eirunepe (Amazon Time)',
			'America/Glace_Bay' => '(GMT-4:00) America/Glace_Bay (Atlantic Standard Time)',
			'America/Goose_Bay' => '(GMT-4:00) America/Goose_Bay (Atlantic Standard Time)',
			'America/Grenada' => '(GMT-4:00) America/Grenada (Atlantic Standard Time)',
			'America/Guadeloupe' => '(GMT-4:00) America/Guadeloupe (Atlantic Standard Time)',
			'America/Guyana' => '(GMT-4:00) America/Guyana (Guyana Time)',
			'America/Halifax' => '(GMT-4:00) America/Halifax (Atlantic Standard Time)',
			'America/La_Paz' => '(GMT-4:00) America/La_Paz (Bolivia Time)',
			'America/Manaus' => '(GMT-4:00) America/Manaus (Amazon Time)',
			'America/Marigot' => '(GMT-4:00) America/Marigot (Atlantic Standard Time)',
			'America/Martinique' => '(GMT-4:00) America/Martinique (Atlantic Standard Time)',
			'America/Moncton' => '(GMT-4:00) America/Moncton (Atlantic Standard Time)',
			'America/Montserrat' => '(GMT-4:00) America/Montserrat (Atlantic Standard Time)',
			'America/Port_of_Spain' => '(GMT-4:00) America/Port_of_Spain (Atlantic Standard Time)',
			'America/Porto_Acre' => '(GMT-4:00) America/Porto_Acre (Amazon Time)',
			'America/Porto_Velho' => '(GMT-4:00) America/Porto_Velho (Amazon Time)',
			'America/Puerto_Rico' => '(GMT-4:00) America/Puerto_Rico (Atlantic Standard Time)',
			'America/Rio_Branco' => '(GMT-4:00) America/Rio_Branco (Amazon Time)',
			'America/Santiago' => '(GMT-4:00) America/Santiago (Chile Time)',
			'America/Santo_Domingo' => '(GMT-4:00) America/Santo_Domingo (Atlantic Standard Time)',
			'America/St_Barthelemy' => '(GMT-4:00) America/St_Barthelemy (Atlantic Standard Time)',
			'America/St_Kitts' => '(GMT-4:00) America/St_Kitts (Atlantic Standard Time)',
			'America/St_Lucia' => '(GMT-4:00) America/St_Lucia (Atlantic Standard Time)',
			'America/St_Thomas' => '(GMT-4:00) America/St_Thomas (Atlantic Standard Time)',
			'America/St_Vincent' => '(GMT-4:00) America/St_Vincent (Atlantic Standard Time)',
			'America/Thule' => '(GMT-4:00) America/Thule (Atlantic Standard Time)',
			'America/Tortola' => '(GMT-4:00) America/Tortola (Atlantic Standard Time)',
			'America/Virgin' => '(GMT-4:00) America/Virgin (Atlantic Standard Time)',
			'Antarctica/Palmer' => '(GMT-4:00) Antarctica/Palmer (Chile Time)',
			'Atlantic/Bermuda' => '(GMT-4:00) Atlantic/Bermuda (Atlantic Standard Time)',
			'Atlantic/Stanley' => '(GMT-4:00) Atlantic/Stanley (Falkland Is. Time)',
			'Brazil/Acre' => '(GMT-4:00) Brazil/Acre (Amazon Time)',
			'Brazil/West' => '(GMT-4:00) Brazil/West (Amazon Time)',
			'Canada/Atlantic' => '(GMT-4:00) Canada/Atlantic (Atlantic Standard Time)',
			'Chile/Continental' => '(GMT-4:00) Chile/Continental (Chile Time)',
			'America/St_Johns' => '(GMT-3:-30) America/St_Johns (Newfoundland Standard Time)',
			'Canada/Newfoundland' => '(GMT-3:-30) Canada/Newfoundland (Newfoundland Standard Time)',
			'America/Araguaina' => '(GMT-3:00) America/Araguaina (Brasilia Time)',
			'America/Bahia' => '(GMT-3:00) America/Bahia (Brasilia Time)',
			'America/Belem' => '(GMT-3:00) America/Belem (Brasilia Time)',
			'America/Buenos_Aires' => '(GMT-3:00) America/Buenos_Aires (Argentine Time)',
			'America/Catamarca' => '(GMT-3:00) America/Catamarca (Argentine Time)',
			'America/Cayenne' => '(GMT-3:00) America/Cayenne (French Guiana Time)',
			'America/Cordoba' => '(GMT-3:00) America/Cordoba (Argentine Time)',
			'America/Fortaleza' => '(GMT-3:00) America/Fortaleza (Brasilia Time)',
			'America/Godthab' => '(GMT-3:00) America/Godthab (Western Greenland Time)',
			'America/Jujuy' => '(GMT-3:00) America/Jujuy (Argentine Time)',
			'America/Maceio' => '(GMT-3:00) America/Maceio (Brasilia Time)',
			'America/Mendoza' => '(GMT-3:00) America/Mendoza (Argentine Time)',
			'America/Miquelon' => '(GMT-3:00) America/Miquelon (Pierre & Miquelon Standard Time)',
			'America/Montevideo' => '(GMT-3:00) America/Montevideo (Uruguay Time)',
			'America/Paramaribo' => '(GMT-3:00) America/Paramaribo (Suriname Time)',
			'America/Recife' => '(GMT-3:00) America/Recife (Brasilia Time)',
			'America/Rosario' => '(GMT-3:00) America/Rosario (Argentine Time)',
			'America/Santarem' => '(GMT-3:00) America/Santarem (Brasilia Time)',
			'America/Sao_Paulo' => '(GMT-3:00) America/Sao_Paulo (Brasilia Time)',
			'Antarctica/Rothera' => '(GMT-3:00) Antarctica/Rothera (Rothera Time)',
			'Brazil/East' => '(GMT-3:00) Brazil/East (Brasilia Time)',
			'America/Noronha' => '(GMT-2:00) America/Noronha (Fernando de Noronha Time)',
			'Atlantic/South_Georgia' => '(GMT-2:00) Atlantic/South_Georgia (South Georgia Standard Time)',
			'Brazil/DeNoronha' => '(GMT-2:00) Brazil/DeNoronha (Fernando de Noronha Time)',
			'America/Scoresbysund' => '(GMT-1:00) America/Scoresbysund (Eastern Greenland Time)',
			'Atlantic/Azores' => '(GMT-1:00) Atlantic/Azores (Azores Time)',
			'Atlantic/Cape_Verde' => '(GMT-1:00) Atlantic/Cape_Verde (Cape Verde Time)',
			'Africa/Abidjan' => '(GMT+0:00) Africa/Abidjan (Greenwich Mean Time)',
			'Africa/Accra' => '(GMT+0:00) Africa/Accra (Ghana Mean Time)',
			'Africa/Bamako' => '(GMT+0:00) Africa/Bamako (Greenwich Mean Time)',
			'Africa/Banjul' => '(GMT+0:00) Africa/Banjul (Greenwich Mean Time)',
			'Africa/Bissau' => '(GMT+0:00) Africa/Bissau (Greenwich Mean Time)',
			'Africa/Casablanca' => '(GMT+0:00) Africa/Casablanca (Western European Time)',
			'Africa/Conakry' => '(GMT+0:00) Africa/Conakry (Greenwich Mean Time)',
			'Africa/Dakar' => '(GMT+0:00) Africa/Dakar (Greenwich Mean Time)',
			'Africa/El_Aaiun' => '(GMT+0:00) Africa/El_Aaiun (Western European Time)',
			'Africa/Freetown' => '(GMT+0:00) Africa/Freetown (Greenwich Mean Time)',
			'Africa/Lome' => '(GMT+0:00) Africa/Lome (Greenwich Mean Time)',
			'Africa/Monrovia' => '(GMT+0:00) Africa/Monrovia (Greenwich Mean Time)',
			'Africa/Nouakchott' => '(GMT+0:00) Africa/Nouakchott (Greenwich Mean Time)',
			'Africa/Ouagadougou' => '(GMT+0:00) Africa/Ouagadougou (Greenwich Mean Time)',
			'Africa/Sao_Tome' => '(GMT+0:00) Africa/Sao_Tome (Greenwich Mean Time)',
			'Africa/Timbuktu' => '(GMT+0:00) Africa/Timbuktu (Greenwich Mean Time)',
			'America/Danmarkshavn' => '(GMT+0:00) America/Danmarkshavn (Greenwich Mean Time)',
			'Atlantic/Canary' => '(GMT+0:00) Atlantic/Canary (Western European Time)',
			'Atlantic/Faeroe' => '(GMT+0:00) Atlantic/Faeroe (Western European Time)',
			'Atlantic/Faroe' => '(GMT+0:00) Atlantic/Faroe (Western European Time)',
			'Atlantic/Madeira' => '(GMT+0:00) Atlantic/Madeira (Western European Time)',
			'Atlantic/Reykjavik' => '(GMT+0:00) Atlantic/Reykjavik (Greenwich Mean Time)',
			'Atlantic/St_Helena' => '(GMT+0:00) Atlantic/St_Helena (Greenwich Mean Time)',
			'Europe/Belfast' => '(GMT+0:00) Europe/Belfast (Greenwich Mean Time)',
			'Europe/Dublin' => '(GMT+0:00) Europe/Dublin (Greenwich Mean Time)',
			'Europe/Guernsey' => '(GMT+0:00) Europe/Guernsey (Greenwich Mean Time)',
			'Europe/Isle_of_Man' => '(GMT+0:00) Europe/Isle_of_Man (Greenwich Mean Time)',
			'Europe/Jersey' => '(GMT+0:00) Europe/Jersey (Greenwich Mean Time)',
			'Europe/Lisbon' => '(GMT+0:00) Europe/Lisbon (Western European Time)',
			'Europe/London' => '(GMT+0:00) Europe/London (Greenwich Mean Time)',
			'Africa/Algiers' => '(GMT+1:00) Africa/Algiers (Central European Time)',
			'Africa/Bangui' => '(GMT+1:00) Africa/Bangui (Western African Time)',
			'Africa/Brazzaville' => '(GMT+1:00) Africa/Brazzaville (Western African Time)',
			'Africa/Ceuta' => '(GMT+1:00) Africa/Ceuta (Central European Time)',
			'Africa/Douala' => '(GMT+1:00) Africa/Douala (Western African Time)',
			'Africa/Kinshasa' => '(GMT+1:00) Africa/Kinshasa (Western African Time)',
			'Africa/Lagos' => '(GMT+1:00) Africa/Lagos (Western African Time)',
			'Africa/Libreville' => '(GMT+1:00) Africa/Libreville (Western African Time)',
			'Africa/Luanda' => '(GMT+1:00) Africa/Luanda (Western African Time)',
			'Africa/Malabo' => '(GMT+1:00) Africa/Malabo (Western African Time)',
			'Africa/Ndjamena' => '(GMT+1:00) Africa/Ndjamena (Western African Time)',
			'Africa/Niamey' => '(GMT+1:00) Africa/Niamey (Western African Time)',
			'Africa/Porto-Novo' => '(GMT+1:00) Africa/Porto-Novo (Western African Time)',
			'Africa/Tunis' => '(GMT+1:00) Africa/Tunis (Central European Time)',
			'Africa/Windhoek' => '(GMT+1:00) Africa/Windhoek (Western African Time)',
			'Arctic/Longyearbyen' => '(GMT+1:00) Arctic/Longyearbyen (Central European Time)',
			'Atlantic/Jan_Mayen' => '(GMT+1:00) Atlantic/Jan_Mayen (Central European Time)',
			'Europe/Amsterdam' => '(GMT+1:00) Europe/Amsterdam (Central European Time)',
			'Europe/Andorra' => '(GMT+1:00) Europe/Andorra (Central European Time)',
			'Europe/Belgrade' => '(GMT+1:00) Europe/Belgrade (Central European Time)',
			'Europe/Berlin' => '(GMT+1:00) Europe/Berlin (Central European Time)',
			'Europe/Bratislava' => '(GMT+1:00) Europe/Bratislava (Central European Time)',
			'Europe/Brussels' => '(GMT+1:00) Europe/Brussels (Central European Time)',
			'Europe/Budapest' => '(GMT+1:00) Europe/Budapest (Central European Time)',
			'Europe/Copenhagen' => '(GMT+1:00) Europe/Copenhagen (Central European Time)',
			'Europe/Gibraltar' => '(GMT+1:00) Europe/Gibraltar (Central European Time)',
			'Europe/Ljubljana' => '(GMT+1:00) Europe/Ljubljana (Central European Time)',
			'Europe/Luxembourg' => '(GMT+1:00) Europe/Luxembourg (Central European Time)',
			'Europe/Madrid' => '(GMT+1:00) Europe/Madrid (Central European Time)',
			'Europe/Malta' => '(GMT+1:00) Europe/Malta (Central European Time)',
			'Europe/Monaco' => '(GMT+1:00) Europe/Monaco (Central European Time)',
			'Europe/Oslo' => '(GMT+1:00) Europe/Oslo (Central European Time)',
			'Europe/Paris' => '(GMT+1:00) Europe/Paris (Central European Time)',
			'Europe/Podgorica' => '(GMT+1:00) Europe/Podgorica (Central European Time)',
			'Europe/Prague' => '(GMT+1:00) Europe/Prague (Central European Time)',
			'Europe/Rome' => '(GMT+1:00) Europe/Rome (Central European Time)',
			'Europe/San_Marino' => '(GMT+1:00) Europe/San_Marino (Central European Time)',
			'Europe/Sarajevo' => '(GMT+1:00) Europe/Sarajevo (Central European Time)',
			'Europe/Skopje' => '(GMT+1:00) Europe/Skopje (Central European Time)',
			'Europe/Stockholm' => '(GMT+1:00) Europe/Stockholm (Central European Time)',
			'Europe/Tirane' => '(GMT+1:00) Europe/Tirane (Central European Time)',
			'Europe/Vaduz' => '(GMT+1:00) Europe/Vaduz (Central European Time)',
			'Europe/Vatican' => '(GMT+1:00) Europe/Vatican (Central European Time)',
			'Europe/Vienna' => '(GMT+1:00) Europe/Vienna (Central European Time)',
			'Europe/Warsaw' => '(GMT+1:00) Europe/Warsaw (Central European Time)',
			'Europe/Zagreb' => '(GMT+1:00) Europe/Zagreb (Central European Time)',
			'Europe/Zurich' => '(GMT+1:00) Europe/Zurich (Central European Time)',
			'Africa/Blantyre' => '(GMT+2:00) Africa/Blantyre (Central African Time)',
			'Africa/Bujumbura' => '(GMT+2:00) Africa/Bujumbura (Central African Time)',
			'Africa/Cairo' => '(GMT+2:00) Africa/Cairo (Eastern European Time)',
			'Africa/Gaborone' => '(GMT+2:00) Africa/Gaborone (Central African Time)',
			'Africa/Harare' => '(GMT+2:00) Africa/Harare (Central African Time)',
			'Africa/Johannesburg' => '(GMT+2:00) Africa/Johannesburg (South Africa Standard Time)',
			'Africa/Kigali' => '(GMT+2:00) Africa/Kigali (Central African Time)',
			'Africa/Lubumbashi' => '(GMT+2:00) Africa/Lubumbashi (Central African Time)',
			'Africa/Lusaka' => '(GMT+2:00) Africa/Lusaka (Central African Time)',
			'Africa/Maputo' => '(GMT+2:00) Africa/Maputo (Central African Time)',
			'Africa/Maseru' => '(GMT+2:00) Africa/Maseru (South Africa Standard Time)',
			'Africa/Mbabane' => '(GMT+2:00) Africa/Mbabane (South Africa Standard Time)',
			'Africa/Tripoli' => '(GMT+2:00) Africa/Tripoli (Eastern European Time)',
			'Asia/Amman' => '(GMT+2:00) Asia/Amman (Eastern European Time)',
			'Asia/Beirut' => '(GMT+2:00) Asia/Beirut (Eastern European Time)',
			'Asia/Damascus' => '(GMT+2:00) Asia/Damascus (Eastern European Time)',
			'Asia/Gaza' => '(GMT+2:00) Asia/Gaza (Eastern European Time)',
			'Asia/Istanbul' => '(GMT+2:00) Asia/Istanbul (Eastern European Time)',
			'Asia/Jerusalem' => '(GMT+2:00) Asia/Jerusalem (Israel Standard Time)',
			'Asia/Nicosia' => '(GMT+2:00) Asia/Nicosia (Eastern European Time)',
			'Asia/Tel_Aviv' => '(GMT+2:00) Asia/Tel_Aviv (Israel Standard Time)',
			'Europe/Athens' => '(GMT+2:00) Europe/Athens (Eastern European Time)',
			'Europe/Bucharest' => '(GMT+2:00) Europe/Bucharest (Eastern European Time)',
			'Europe/Chisinau' => '(GMT+2:00) Europe/Chisinau (Eastern European Time)',
			'Europe/Helsinki' => '(GMT+2:00) Europe/Helsinki (Eastern European Time)',
			'Europe/Istanbul' => '(GMT+2:00) Europe/Istanbul (Eastern European Time)',
			'Europe/Kaliningrad' => '(GMT+2:00) Europe/Kaliningrad (Eastern European Time)',
			'Europe/Kiev' => '(GMT+2:00) Europe/Kiev (Eastern European Time)',
			'Europe/Mariehamn' => '(GMT+2:00) Europe/Mariehamn (Eastern European Time)',
			'Europe/Minsk' => '(GMT+2:00) Europe/Minsk (Eastern European Time)',
			'Europe/Nicosia' => '(GMT+2:00) Europe/Nicosia (Eastern European Time)',
			'Europe/Riga' => '(GMT+2:00) Europe/Riga (Eastern European Time)',
			'Europe/Simferopol' => '(GMT+2:00) Europe/Simferopol (Eastern European Time)',
			'Europe/Sofia' => '(GMT+2:00) Europe/Sofia (Eastern European Time)',
			'Europe/Tallinn' => '(GMT+2:00) Europe/Tallinn (Eastern European Time)',
			'Europe/Tiraspol' => '(GMT+2:00) Europe/Tiraspol (Eastern European Time)',
			'Europe/Uzhgorod' => '(GMT+2:00) Europe/Uzhgorod (Eastern European Time)',
			'Europe/Vilnius' => '(GMT+2:00) Europe/Vilnius (Eastern European Time)',
			'Europe/Zaporozhye' => '(GMT+2:00) Europe/Zaporozhye (Eastern European Time)',
			'Africa/Addis_Ababa' => '(GMT+3:00) Africa/Addis_Ababa (Eastern African Time)',
			'Africa/Asmara' => '(GMT+3:00) Africa/Asmara (Eastern African Time)',
			'Africa/Asmera' => '(GMT+3:00) Africa/Asmera (Eastern African Time)',
			'Africa/Dar_es_Salaam' => '(GMT+3:00) Africa/Dar_es_Salaam (Eastern African Time)',
			'Africa/Djibouti' => '(GMT+3:00) Africa/Djibouti (Eastern African Time)',
			'Africa/Kampala' => '(GMT+3:00) Africa/Kampala (Eastern African Time)',
			'Africa/Khartoum' => '(GMT+3:00) Africa/Khartoum (Eastern African Time)',
			'Africa/Mogadishu' => '(GMT+3:00) Africa/Mogadishu (Eastern African Time)',
			'Africa/Nairobi' => '(GMT+3:00) Africa/Nairobi (Eastern African Time)',
			'Antarctica/Syowa' => '(GMT+3:00) Antarctica/Syowa (Syowa Time)',
			'Asia/Aden' => '(GMT+3:00) Asia/Aden (Arabia Standard Time)',
			'Asia/Baghdad' => '(GMT+3:00) Asia/Baghdad (Arabia Standard Time)',
			'Asia/Bahrain' => '(GMT+3:00) Asia/Bahrain (Arabia Standard Time)',
			'Asia/Kuwait' => '(GMT+3:00) Asia/Kuwait (Arabia Standard Time)',
			'Asia/Qatar' => '(GMT+3:00) Asia/Qatar (Arabia Standard Time)',
			'Europe/Moscow' => '(GMT+3:00) Europe/Moscow (Moscow Standard Time)',
			'Europe/Volgograd' => '(GMT+3:00) Europe/Volgograd (Volgograd Time)',
			'Indian/Antananarivo' => '(GMT+3:00) Indian/Antananarivo (Eastern African Time)',
			'Indian/Comoro' => '(GMT+3:00) Indian/Comoro (Eastern African Time)',
			'Indian/Mayotte' => '(GMT+3:00) Indian/Mayotte (Eastern African Time)',
			'Asia/Tehran' => '(GMT+3:30) Asia/Tehran (Iran Standard Time)',
			'Asia/Baku' => '(GMT+4:00) Asia/Baku (Azerbaijan Time)',
			'Asia/Dubai' => '(GMT+4:00) Asia/Dubai (Gulf Standard Time)',
			'Asia/Muscat' => '(GMT+4:00) Asia/Muscat (Gulf Standard Time)',
			'Asia/Tbilisi' => '(GMT+4:00) Asia/Tbilisi (Georgia Time)',
			'Asia/Yerevan' => '(GMT+4:00) Asia/Yerevan (Armenia Time)',
			'Europe/Samara' => '(GMT+4:00) Europe/Samara (Samara Time)',
			'Indian/Mahe' => '(GMT+4:00) Indian/Mahe (Seychelles Time)',
			'Indian/Mauritius' => '(GMT+4:00) Indian/Mauritius (Mauritius Time)',
			'Indian/Reunion' => '(GMT+4:00) Indian/Reunion (Reunion Time)',
			'Asia/Kabul' => '(GMT+4:30) Asia/Kabul (Afghanistan Time)',
			'Asia/Aqtau' => '(GMT+5:00) Asia/Aqtau (Aqtau Time)',
			'Asia/Aqtobe' => '(GMT+5:00) Asia/Aqtobe (Aqtobe Time)',
			'Asia/Ashgabat' => '(GMT+5:00) Asia/Ashgabat (Turkmenistan Time)',
			'Asia/Ashkhabad' => '(GMT+5:00) Asia/Ashkhabad (Turkmenistan Time)',
			'Asia/Dushanbe' => '(GMT+5:00) Asia/Dushanbe (Tajikistan Time)',
			'Asia/Karachi' => '(GMT+5:00) Asia/Karachi (Pakistan Time)',
			'Asia/Oral' => '(GMT+5:00) Asia/Oral (Oral Time)',
			'Asia/Samarkand' => '(GMT+5:00) Asia/Samarkand (Uzbekistan Time)',
			'Asia/Tashkent' => '(GMT+5:00) Asia/Tashkent (Uzbekistan Time)',
			'Asia/Yekaterinburg' => '(GMT+5:00) Asia/Yekaterinburg (Yekaterinburg Time)',
			'Indian/Kerguelen' => '(GMT+5:00) Indian/Kerguelen (French Southern & Antarctic Lands Time)',
			'Indian/Maldives' => '(GMT+5:00) Indian/Maldives (Maldives Time)',
			'Asia/Calcutta' => '(GMT+5:30) Asia/Calcutta (India Standard Time)',
			'Asia/Colombo' => '(GMT+5:30) Asia/Colombo (India Standard Time)',
			'Asia/Kolkata' => '(GMT+5:30) Asia/Kolkata (India Standard Time)',
			'Asia/Katmandu' => '(GMT+5:45) Asia/Katmandu (Nepal Time)',
			'Antarctica/Mawson' => '(GMT+6:00) Antarctica/Mawson (Mawson Time)',
			'Antarctica/Vostok' => '(GMT+6:00) Antarctica/Vostok (Vostok Time)',
			'Asia/Almaty' => '(GMT+6:00) Asia/Almaty (Alma-Ata Time)',
			'Asia/Bishkek' => '(GMT+6:00) Asia/Bishkek (Kirgizstan Time)',
			'Asia/Dacca' => '(GMT+6:00) Asia/Dacca (Bangladesh Time)',
			'Asia/Dhaka' => '(GMT+6:00) Asia/Dhaka (Bangladesh Time)',
			'Asia/Novosibirsk' => '(GMT+6:00) Asia/Novosibirsk (Novosibirsk Time)',
			'Asia/Omsk' => '(GMT+6:00) Asia/Omsk (Omsk Time)',
			'Asia/Qyzylorda' => '(GMT+6:00) Asia/Qyzylorda (Qyzylorda Time)',
			'Asia/Thimbu' => '(GMT+6:00) Asia/Thimbu (Bhutan Time)',
			'Asia/Thimphu' => '(GMT+6:00) Asia/Thimphu (Bhutan Time)',
			'Indian/Chagos' => '(GMT+6:00) Indian/Chagos (Indian Ocean Territory Time)',
			'Asia/Rangoon' => '(GMT+6:30) Asia/Rangoon (Myanmar Time)',
			'Indian/Cocos' => '(GMT+6:30) Indian/Cocos (Cocos Islands Time)',
			'Antarctica/Davis' => '(GMT+7:00) Antarctica/Davis (Davis Time)',
			'Asia/Bangkok' => '(GMT+7:00) Asia/Bangkok (Indochina Time)',
			'Asia/Ho_Chi_Minh' => '(GMT+7:00) Asia/Ho_Chi_Minh (Indochina Time)',
			'Asia/Hovd' => '(GMT+7:00) Asia/Hovd (Hovd Time)',
			'Asia/Jakarta' => '(GMT+7:00) Asia/Jakarta (West Indonesia Time)',
			'Asia/Krasnoyarsk' => '(GMT+7:00) Asia/Krasnoyarsk (Krasnoyarsk Time)',
			'Asia/Phnom_Penh' => '(GMT+7:00) Asia/Phnom_Penh (Indochina Time)',
			'Asia/Pontianak' => '(GMT+7:00) Asia/Pontianak (West Indonesia Time)',
			'Asia/Saigon' => '(GMT+7:00) Asia/Saigon (Indochina Time)',
			'Asia/Vientiane' => '(GMT+7:00) Asia/Vientiane (Indochina Time)',
			'Indian/Christmas' => '(GMT+7:00) Indian/Christmas (Christmas Island Time)',
			'Antarctica/Casey' => '(GMT+8:00) Antarctica/Casey (Western Standard Time (Australia))',
			'Asia/Brunei' => '(GMT+8:00) Asia/Brunei (Brunei Time)',
			'Asia/Choibalsan' => '(GMT+8:00) Asia/Choibalsan (Choibalsan Time)',
			'Asia/Chongqing' => '(GMT+8:00) Asia/Chongqing (China Standard Time)',
			'Asia/Chungking' => '(GMT+8:00) Asia/Chungking (China Standard Time)',
			'Asia/Harbin' => '(GMT+8:00) Asia/Harbin (China Standard Time)',
			'Asia/Hong_Kong' => '(GMT+8:00) Asia/Hong_Kong (Hong Kong Time)',
			'Asia/Irkutsk' => '(GMT+8:00) Asia/Irkutsk (Irkutsk Time)',
			'Asia/Kashgar' => '(GMT+8:00) Asia/Kashgar (China Standard Time)',
			'Asia/Kuala_Lumpur' => '(GMT+8:00) Asia/Kuala_Lumpur (Malaysia Time)',
			'Asia/Kuching' => '(GMT+8:00) Asia/Kuching (Malaysia Time)',
			'Asia/Macao' => '(GMT+8:00) Asia/Macao (China Standard Time)',
			'Asia/Macau' => '(GMT+8:00) Asia/Macau (China Standard Time)',
			'Asia/Makassar' => '(GMT+8:00) Asia/Makassar (Central Indonesia Time)',
			'Asia/Manila' => '(GMT+8:00) Asia/Manila (Philippines Time)',
			'Asia/Shanghai' => '(GMT+8:00) Asia/Shanghai (China Standard Time)',
			'Asia/Singapore' => '(GMT+8:00) Asia/Singapore (Singapore Time)',
			'Asia/Taipei' => '(GMT+8:00) Asia/Taipei (China Standard Time)',
			'Asia/Ujung_Pandang' => '(GMT+8:00) Asia/Ujung_Pandang (Central Indonesia Time)',
			'Asia/Ulaanbaatar' => '(GMT+8:00) Asia/Ulaanbaatar (Ulaanbaatar Time)',
			'Asia/Ulan_Bator' => '(GMT+8:00) Asia/Ulan_Bator (Ulaanbaatar Time)',
			'Asia/Urumqi' => '(GMT+8:00) Asia/Urumqi (China Standard Time)',
			'Australia/Perth' => '(GMT+8:00) Australia/Perth (Western Standard Time (Australia))',
			'Australia/West' => '(GMT+8:00) Australia/West (Western Standard Time (Australia))',
			'Australia/Eucla' => '(GMT+8:45) Australia/Eucla (Central Western Standard Time (Australia))',
			'Asia/Dili' => '(GMT+9:00) Asia/Dili (Timor-Leste Time)',
			'Asia/Jayapura' => '(GMT+9:00) Asia/Jayapura (East Indonesia Time)',
			'Asia/Pyongyang' => '(GMT+9:00) Asia/Pyongyang (Korea Standard Time)',
			'Asia/Seoul' => '(GMT+9:00) Asia/Seoul (Korea Standard Time)',
			'Asia/Tokyo' => '(GMT+9:00) Asia/Tokyo (Japan Standard Time)',
			'Asia/Yakutsk' => '(GMT+9:00) Asia/Yakutsk (Yakutsk Time)',
			'Australia/Adelaide' => '(GMT+9:30) Australia/Adelaide (Central Standard Time (South Australia))',
			'Australia/Broken_Hill' => '(GMT+9:30) Australia/Broken_Hill (Central Standard Time (South Australia/New South Wales))',
			'Australia/Darwin' => '(GMT+9:30) Australia/Darwin (Central Standard Time (Northern Territory))',
			'Australia/North' => '(GMT+9:30) Australia/North (Central Standard Time (Northern Territory))',
			'Australia/South' => '(GMT+9:30) Australia/South (Central Standard Time (South Australia))',
			'Australia/Yancowinna' => '(GMT+9:30) Australia/Yancowinna (Central Standard Time (South Australia/New South Wales))',
			'Antarctica/DumontDUrville' => '(GMT+10:00) Antarctica/DumontDUrville (Dumont-d\'Urville Time)',
			'Asia/Sakhalin' => '(GMT+10:00) Asia/Sakhalin (Sakhalin Time)',
			'Asia/Vladivostok' => '(GMT+10:00) Asia/Vladivostok (Vladivostok Time)',
			'Australia/ACT' => '(GMT+10:00) Australia/ACT (Eastern Standard Time (New South Wales))',
			'Australia/Brisbane' => '(GMT+10:00) Australia/Brisbane (Eastern Standard Time (Queensland))',
			'Australia/Canberra' => '(GMT+10:00) Australia/Canberra (Eastern Standard Time (New South Wales))',
			'Australia/Currie' => '(GMT+10:00) Australia/Currie (Eastern Standard Time (New South Wales))',
			'Australia/Hobart' => '(GMT+10:00) Australia/Hobart (Eastern Standard Time (Tasmania))',
			'Australia/Lindeman' => '(GMT+10:00) Australia/Lindeman (Eastern Standard Time (Queensland))',
			'Australia/Melbourne' => '(GMT+10:00) Australia/Melbourne (Eastern Standard Time (Victoria))',
			'Australia/NSW' => '(GMT+10:00) Australia/NSW (Eastern Standard Time (New South Wales))',
			'Australia/Queensland' => '(GMT+10:00) Australia/Queensland (Eastern Standard Time (Queensland))',
			'Australia/Sydney' => '(GMT+10:00) Australia/Sydney (Eastern Standard Time (New South Wales))',
			'Australia/Tasmania' => '(GMT+10:00) Australia/Tasmania (Eastern Standard Time (Tasmania))',
			'Australia/Victoria' => '(GMT+10:00) Australia/Victoria (Eastern Standard Time (Victoria))',
			'Australia/LHI' => '(GMT+10:30) Australia/LHI (Lord Howe Standard Time)',
			'Australia/Lord_Howe' => '(GMT+10:30) Australia/Lord_Howe (Lord Howe Standard Time)',
			'Asia/Magadan' => '(GMT+11:00) Asia/Magadan (Magadan Time)',
			'Antarctica/McMurdo' => '(GMT+12:00) Antarctica/McMurdo (New Zealand Standard Time)',
			'Antarctica/South_Pole' => '(GMT+12:00) Antarctica/South_Pole (New Zealand Standard Time)',
			'Asia/Anadyr' => '(GMT+12:00) Asia/Anadyr (Anadyr Time)',
			'Asia/Kamchatka' => '(GMT+12:00) Asia/Kamchatka (Petropavlovsk-Kamchatski Time)',
		);
		return $timezones;
	} //End of get_time_zone

	public function get_all_contracts_size(){
		echo "Start Time: ".date("Y-m-d H:i:s");
		echo "<br>";
		$all_coin_Arr = $this->mod_coins->get_all_coins();
		foreach ($all_coin_Arr as $key => $value) {
			$coin_symbol = $value['symbol'];
			$start_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-7 days")));
			$end_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-1 hour")));
			$search_array = array(
				'coin' => $coin_symbol,
				'timestamp' => array('$gte' => $start_date, '$lte' => $end_date));

			$this->mongo_db->where($search_array);
			$res = $this->mongo_db->get('market_trade_hourly_history');
			$ask_volume_arr = iterator_to_array($res);
			$volume_Arr = array_column($ask_volume_arr, 'volume');

			$total_volume = array_sum($volume_Arr);
			$per_day = $total_volume/7;
			$per_five_min = round($per_day/288);
			/********************************************************************/

			$this_id = $value['_id'];
			$contract_size = $value['contract_size'];
			$this->mongo_db->where(array('_id' => $this->mongo_db->mongoId($this_id)));
			$this->mongo_db->set(array('contract_size' => $per_five_min));
			$this->mongo_db->update('coins');

			$log_arr = array(
				'message' => 'contract size has been changed from '.$contract_size." to ".$per_five_min,
				'symbol' => $coin_symbol,
				'old_contract_size' => $contract_size,
				'type' => 'size',
				'created_date' => $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s")),
				'created_date_human_readable' => date("Y-m-d H:i:s")
		 			);
			$this->mongo_db->insert('coin_update_log',$log_arr);
		}
		echo "End Time: ".date("Y-m-d H:i:s");
		echo "<br>";
	}

	public function get_all_contracts_time(){
		echo "Start Time: ".date("Y-m-d H:i:s");
		echo "<br>";
		$all_coin_Arr = $this->mod_coins->get_all_coins();
		foreach ($all_coin_Arr as $key => $value) {
			$coin_symbol = $value['symbol'];
			$start_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-5 hours")));
      $end_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-1 hour")));

      $search_array = array(
  			'coin' => $coin_symbol,
  			'created_date' => array('$gte' => $start_date, '$lte' => $end_date));

      $this->mongo_db->where($search_array);
  		$res = $this->mongo_db->get('market_trade_history');
  		$ask_volume_arr = iterator_to_array($res);

      $total = count($ask_volume_arr);

      $fiv_min_avg = round($total/60);

			/********************************************************************/

			$this_id = $value['_id'];
			$contract_period = $value['contract_period'];
			$this->mongo_db->where(array('_id' => $this->mongo_db->mongoId($this_id)));
			$this->mongo_db->set(array('contract_period' => $fiv_min_avg));
			$this->mongo_db->update('coins');

			$log_arr = array(
				'message' => 'contract time has been changed from '.$contract_period." to ".$fiv_min_avg,
				'symbol' => $coin_symbol,
				'old_contract_period' => $contract_period,
				'type' => 'period',
				'created_date' => $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s")),
				'created_date_human_readable' => date("Y-m-d H:i:s")
		 			);
			$this->mongo_db->insert('coin_update_log',$log_arr);
		}
		echo "End Time: ".date("Y-m-d H:i:s");
		echo "<br>";
	}
}
