<?php
class Vizz_script extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	public function index() {
		// $coin_symbol = 'NCASHBTC';
		// $this->mongo_db->where('coin', $coin_symbol);
		// $this->mongo_db->limit(15);
		// $this->mongo_db->order_by(array('timestampDate' => -1));
		// $get_arr = $this->mongo_db->get('market_chart');
		// $candle_arr = iterator_to_array($get_arr);
		//
		// echo "<pre>";
		// print_r($candle_arr);
		// exit;

		$this->load->library('binance_api');
		$user_arr = $this->binance_api->accountStatus();
		echo "<pre>";
		print_r($user_arr);
		exit;
	}

	public function manual_update_parent_order_profit() {
		$defined_sell_percentage = 1000;
		echo "<pre>";
		$this->mongo_db->where("parent_status", "parent");
		$get_arr = $this->mongo_db->get("buy_orders");
		echo "<pre>";
		print_r(iterator_to_array($get_arr));
		exit;
		foreach ($get_arr as $key => $value) {
			if (!empty($value)) {
				$percentage = $value['defined_sell_percentage'];

				if ($percentage == NULL) {
					$id = $value['_id'];
					$upd_arr = array('defined_sell_percentage' => $defined_sell_percentage);

					$this->mongo_db->where(array("_id" => $this->mongo_db->mongoId($id)));
					$this->mongo_db->set($upd_arr);
					$this->mongo_db->update("buy_orders");
				}
			}
		}
	} ///////////////////////////END FUNCTION ///////////////////////////////////////////

	public function test($symbol = "NCASHBTC") {
		$start_date = date('Y-m-d H:i:s', strtotime("2018-09-24 12:08:00"));
		$end_date = date('Y-m-d H:i:s', strtotime("2018-09-24 12:08:05"));
		$retArr = $this->historical_coin_meta($symbol, $start_date, $end_date);
		echo $status = $this->get_status($symbol, $start_date);
		$depth_type = 'ask';
		$barrier_price = '0.00000089';
		echo $quantity = $this->get_market_quantity($symbol, $start_date, $barrier_price, $depth_type);
		exit;
		echo "<pre>";
		print_r($retArr);
		exit;
	}
	public function historical_coin_meta($symbol, $start_date, $end_date) {

		$search['coin'] = $symbol;
		$search['modified_date'] = array('$gte' => $this->mongo_db->converToMongodttime($start_date), '$lte' => $this->mongo_db->converToMongodttime($end_date));

		$this->mongo_db->where($search);
		$this->mongo_db->limit(1);
		$get_obj = $this->mongo_db->get('coin_meta_history');
		$get_arr = iterator_to_array($get_obj);
		$retArr = array();
		foreach ($get_arr as $key => $value) {
			if (!empty($value)) {
				$retArr['coin'] = $value['coin'];
				$retArr['market_value'] = $value['current_market_value'];
				$retArr['black_wall_pressure'] = $value['black_wall_pressure'];
				$retArr['yellow_wall_pressure'] = $value['yellow_wall_pressure'];
				$retArr['pressure_diff'] = $value['pressure_diff'];
				$retArr['ask_percentage'] = $value['ask_percentage'];
				$retArr['bid_percentage'] = $value['bid_percentage'];
				$retArr['sellers_buyers_per'] = $value['sellers_buyers_per'];
				if ($value['seven_level_type'] == 'negitive') {
					$retArr['seven_level_depth'] = ($value['seven_level_depth'] * -1);
				} else {
					$retArr['seven_level_depth'] = $value['seven_level_depth'];
				}

			} //end if
		} //end forloop

		return $retArr;
	}

	public function get_status($symbol, $start_date) {
		$date_hour_start = date("Y-m-d H:00:00", strtotime($start_date));
		$date_hour_end = date("Y-m-d H:59:59", strtotime($start_date));

		$search1['coin'] = $symbol;
		$search1['timestampDate'] = array('$gte' => $this->mongo_db->converToMongodttime($date_hour_start), '$lte' => $this->mongo_db->converToMongodttime($date_hour_end));

		$this->mongo_db->where($search1);
		$this->mongo_db->limit(1);
		$get_obj1 = $this->mongo_db->get('market_chart');
		$get_arr2 = iterator_to_array($get_obj1);

		$status = $get_arr2[0]['global_swing_status'];

		return $status;
	}

	public function get_market_quantity($coin_symbol, $barrier_check_date, $barrier_price, $depth_type) {

		$barrier_check_date_mongo = $this->mongo_db->converToMongodttime($barrier_check_date);

		$where_depth = array(

			'type' => $depth_type,

			'price' => (float) $barrier_price,

			'coin' => $coin_symbol,

			'modified_date' => array('$gte' => $barrier_check_date_mongo),

		);

		$this->mongo_db->where($where_depth);

		$this->mongo_db->limit(1);

		$depth_obj = $this->mongo_db->get('market_depth_history');

		$depth_arr = iterator_to_array($depth_obj);

		$barrier_quantity = $depth_arr[0]['quantity'];
		if (empty($barrier_quantity)) {
			$barrier_quantity = 0;
		}

		return $barrier_quantity;
	}

	public function testing() {

		$this->load->model('admin/mod_sockets');
		//$this->mod_realtime_candle_socket->save_candle_stick_by_cron_job();
		//exit;
		$all_coins_arr = $this->mod_sockets->get_all_coins();
		for ($i = 0; $i < count($all_coins_arr); $i++) {
			$coin_symbol = $all_coins_arr[$i]['symbol'];
			$this->mongo_db->where('coin', $coin_symbol);
			$this->mongo_db->limit(5);
			$this->mongo_db->order_by(array('timestampDate' => -1));
			$get_arr = $this->mongo_db->get('market_chart');
			$candle_arr = iterator_to_array($get_arr);
			$candle = $candle_arr[0];
			echo "============================================================";
			echo "<br>";
			echo "=====================" . $coin_symbol . "=======================";
			echo "<br>";
			echo "============================================================";
			echo "<br>";
			echo "<pre>";
			print_r($candle_arr);
		}


		/*
						[black_wall_meta] => 2
			            [last_200_qty] => -1.0684466426511
			            [last_qty_buy_vs_sell] => -2.3906872188381
			            [last_qty_timeago] => 28
			            [score] => -8
		*/
		$this->mongo_db->where('coin', 'NCASHBTC');
		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('timestampDate' => -1));
		$get_arr = $this->mongo_db->get('market_chart');
		$candle_arr = iterator_to_array($get_arr);
		$candle = $candle_arr[0];
		$opentime = $this->mongo_db->converToMongodttime($candle['openTime_human_readible']);
		$closetime = $this->mongo_db->converToMongodttime($candle['closeTime_human_readible']);
		$low = $candle['low'];
		$this->mongo_db->where(array('coin' => 'NCASHBTC', 'market_value' => $low, 'time' => array('$gte' => $opentime, '$lte' => $closetime)));
		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('time' => -1));
		$get_arr22 = $this->mongo_db->get('market_price_history');
		$price_arr = iterator_to_array($get_arr22);
		$price = $price_arr[0];
		$time = $price['time'];

		$this->mongo_db->where(array('coin' => 'NCASHBTC', 'current_market_value' => $low, 'modified_date' => array('$lte' => $time)));
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

		$score = 50 - $coin_meta['score'];

		echo $black_wall_pressure . "=>" . $last_200_qty . "=>" . $last_qty_buy_vs_sell . "=>" . $last_qty_timeago . "=>" . $score;
		echo "<br>";
		echo "<pre>";
		print_r($candle);
		print_r($price);
		print_r($coin_meta);
		exit;
		exit;

		/*$array = array(
			'black_wall_meta' => $coin_meta_arr['black_wall'],
			'last_200_qty' => $coin_meta_arr['last_200_qty'],
			'last_qty_buy_vs_sell' => $coin_meta_arr['last_qty_buy_vs_sell'],
			'last_qty_timeago' => $coin_meta_arr['last_qty_timeago'],
			'score' => $coin_meta_arr['score'],
		);*/
	}
	public function update_candle_coin_meta() {
		ini_set('memory_limit', -1);
		$this->load->model('admin/mod_sockets');

		$all_coins_arr = $this->mod_sockets->get_all_coins();
		foreach ($all_coins_arr as $key => $value) {
			$coin_symbol = $value['symbol'];
			$this->mongo_db->where('coin', $coin_symbol);
			$this->mongo_db->limit(25);
			$this->mongo_db->order_by(array('timestampDate' => -1));
			$get_arr = $this->mongo_db->get('market_chart');
			$candle_arr = iterator_to_array($get_arr);
			for ($i = 0; $i < count($candle_arr); $i++) {
				$candle = $candle_arr[$i];

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
				echo "<pre>";
				print_r($update_arr);
				$this->mongo_db->where(array('_id' => $candle_id));
				$this->mongo_db->set($update_arr);
				$this->mongo_db->update('market_chart');
			}

		}
		echo "Updated Done";
		exit;
	}
	public function get_coin_meta_for_candle($low, $open_time, $close_time, $symbol) {
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

	public function run() {
		$this->load->model('admin/mod_barrier_trigger');
		$sell_arr = array("testing" => 'testing');
		$this->mod_barrier_trigger->lock_barrier_trigger_true_rules($coin_symbol = "NCASHBTC", $rule_number = "rule_no_4", $type = 'sell', $current_market_price = "0.00000078", $sell_arr);
		exit;
		$c = $this->mongo_db->customQuery();

		$arr = array('key' => array("$rule_number" => true,
			"coin_symbol" => true,
			"created_date" => true,
			"log" => true),
			'initial' => array(),
			'reduce' => function ($obj, $prev) {},
			'cond' => array('coin_symbol' => 'NCASHBTC'),
		);

		$res = $c->barrier_trigger_true_rules_collection->aggregate($arr);

		var_dump($res);
		exit;

		$pipeline = array(
			array(
				'$group' => array(
					'_id' => '$rule_number',
				),
			),
			array(
				'$match' => array(
					'coin_symbol' => "NCASHBTC",
				),
			),
			array(
				'$sort' => array("_id" => -1),
			),
		);
		$results = $c->barrier_trigger_true_rules_collection->aggregate($pipeline);

		//$p = iterator_to_array($results);
		foreach ($results as $key => $value) {
			echo "<pre>";
			print_r($value);
		}
		exit;
		$ops = array(
			array(
				'$project' => array(
					"rule_number" => 1,
					"created_date" => 1,
				),
			),
			array('$unwind' => '$log'),
			array(
				'$group' => array(
					"_id" => array("rule_number" => '$rule_number'),

				),
			),
		);
		$results = $c->barrier_trigger_true_rules_collection->aggregate($ops);

		$p = iterator_to_array($results);
		exit;

		$where_array['coin_symbol'] = 'NCASHBTC';
		$where_array['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime('2018-10-18 17:00:00'), '$lt' => $this->mongo_db->converToMongodttime('2018-10-18 18:00:00'));

		$group_array = array('_id' => '$rule_number');
		$project_array = array("rule_number" => 1,
			"coin_symbol" => 1,
			"created_date" => 1,
			"log" => 1,
		);
		$order_by = array('_id' => -1);
		$collection_name = 'barrier_trigger_true_rules_collection';
		$get = $this->mongo_db->get_aggregrate_function($where_array, $group_array, $project_array, $order_by, $collection_name);
		echo count($get);
		foreach ($get as $key => $value) {
			echo "<pre>";
			print_r($value);
		}
		exit;
		$this->mongo_db->where($search_arr);
		$this->mongo_db->limit(100);
		$res = $this->mongo_db->get('barrier_trigger_true_rules_collection');
		foreach ($res as $key => $value) {
			echo "<pre>";
			print_r($value);
		}
		exit;
		$this->mongo_db->get_aggregrate_function($where_array, $group_array, $project_array, $order_by, $collection_name);
	}

	public function waqartesting() {
		$this->load->model('admin/mod_candle_new');
		$res = $this->mod_candle_new->get_buy_sell_rules_log('POEBTC', '2018-10-19 11:00:00', '2018-10-19 12:00:00');
		echo "<pre>";
		print_r($res);
		exit;
		$db = $this->mongo_db->customQuery();
		//$market_value = '0.000000078';
		$global_symbol = "NCASHBTC";
		//$priceAsk = (float) $market_value;
		$where_array['type'] = 'buy';
		$where_array['coin_symbol'] = $global_symbol;
		$where_array['rule_number'] = array('$in' => array("rule_no_1", "rule_no_2", "rule_no_3", "rule_no_4", "rule_no_5"));
		$where_array['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime('2018-10-22 12:00:00'), '$lte' => $this->mongo_db->converToMongodttime('2018-10-22 14:00:00'));

		$pipeline = array(
			array(
				'$project' => array(
					"coin_symbol" => 1,
					"log" => 1,
					"type" => 1,
					"_id" => 1,
					"rule_number" => 1,
					'created_date' => 1,
				),
			),

			array(
				'$match' => $where_array,
			),

			array('$sort' => array('created_date' => -1)),
			// array('$sort'=>array('price'=>1)),
			array('$group' => array(
				'_id' => array('rule_number' => '$rule_number'),
				'log' => array('$first' => '$log'),
				'type' => array('$first' => '$type'),
				'rule_number' => array('$first' => '$rule_number'),
				'coin_symbol' => array('$first' => '$coin_symbol'),
				'created_date' => array('$first' => '$created_date'),
			),

			),
			array('$sort' => array('created_date' => 1)),
			array('$limit' => 20),
		);

		$allow = array('allowDiskUse' => true);
		$responseArr = $db->barrier_trigger_true_rules_collection->aggregate($pipeline, $allow);

		echo "<pre>";
		print_r(iterator_to_array($responseArr));
		exit;
	}

	public function calculate_average_score($symbol = "NCASHBTC") {
		$start_date = $this->mongo_db->converToMongodttime("2018-10-18 00:00:00");
		$end_date = $this->mongo_db->converToMongodttime("2018-10-18 00:59:59");

		$this->mongo_db->where(array('coin' => $symbol, 'modified_date' => array('$lte' => $end_date, '$gte' => $start_date)));
		$this->mongo_db->order_by(array('modified_date' => -1));
		$get_arr222 = $this->mongo_db->get('coin_meta_history');

		$score_Arr = iterator_to_array($get_arr222);

		foreach ($score_Arr as $key => $value) {
			$score[] = $value['score'];
		}

		$avg_score = array_sum($score) / count($score);

		return $avg_score;

	}

	public function test_order($value='5bdbc9d3fc9aad18a0179fa4')
	{
		$search['purchased_price'] = (float) '0.00000086';
		$search['market_value'] = (float) '0.00000082';
		$search['trigger_type'] = 'barrier_trigger';

		$upd_arr['market_value'] = (float) '0.00000083';
		/*	$this->mongo_db->where($search);
		$this->mongo_db->set($upd_arr);
		$get = $this->mongo_db->update("orders");*/

		$db = $this->mongo_db->customQuery();
		$get = $db->orders->updateMany($search, array('$set' => $upd_arr));

		echo "<pre>";
		print_r($get);
		exit;
	}

	public function delete_order($value='')
	{

		if ($value != '') {
			$this->mongo_db->where(array('_id' => $this->mongo_db->mongoId($value)));
			$this->mongo_db->delete('buy_orders');


			$this->mongo_db->where(array('buy_order_id' => $this->mongo_db->mongoId($value)));
			$this->mongo_db->delete('orders');
		}
	}

	public function delete_sell_order($value='')
	{

		if ($value != '') {
			$this->mongo_db->where(array('_id' => $this->mongo_db->mongoId($value)));
			echo $this->mongo_db->delete('orders');

			echo "-------------------------------Record Deleted -------------------------------";

			$this->mongo_db->where(array('buy_order_id' => $this->mongo_db->mongoId($value)));
			echo $this->mongo_db->delete('buy_orders');
		}
		echo "<pre>";
		print_r($get);
		exit;
	}

	public function manual_delete_order(){
		exit('GMT: Friday, 30 November 2018 04:00:00');
		$date = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime('2018-11-30 04:00:00')));
		$date2 = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime('2018-11-30 04:10:00')));
		$data['symbol'] = 'TRXBTC';
		$data['created_date'] = array('$gte' => $date, '$lte' => $date2);
		$data['market_value'] = (float) '0.00000353';
		$data['application_mode'] = 'test';
		$db = $this->mongo_db->customQuery();
		$count = $db->buy_orders->find($data);
		$i = 0;
		foreach ($count as $key => $value) {
			$id = $value['_id'];
			$sell_id = $value['sell_order_id'];

			$this->mongo_db->where(array('_id' => $this->mongo_db->mongoId($sell_id)));
			echo $this->mongo_db->delete('orders');

			echo "-------------------------------Record ".$i." Deleted <br> -------------------------------<br>";

			$this->mongo_db->where(array('_id' => $this->mongo_db->mongoId($id)));
		echo $this->mongo_db->delete('buy_orders');
		echo "-------------------------------Record ".$i." Deleted <br> -------------------------------<br>";

		$i++;
		}
		//0.00008910
		exit;
	}
	public function update_manual_order($value = '5bff1c51fc9aad32cd7f327d'){
		//5be40f0efc9aad1cc16e6ee2

		if ($value != '') {
			$this->mongo_db->where(array('_id' => $this->mongo_db->mongoId($value)));
			$this->mongo_db->set(array('quantity' => '360'));
			$this->mongo_db->update('buy_orders');

			$this->mongo_db->where(array('buy_order_id' => $this->mongo_db->mongoId($value)));
			$this->mongo_db->set(array('quantity' => '360'));
			$this->mongo_db->update('orders');

			echo "Updated";
		}
	}


	public function order_qty(){
		$id = '5be06845fc9aadb6897239bb';
		$buy_order_id = '5be06844fc9aadb6897239b6';
		$admin_id = '180';
		$symbol = 'POEBTC';
		$quantity = 600;
		echo 'commming';

		$this->check_order_quantity($id, $buy_order_id, $admin_id, $symbol, $quantity);
	}

	public function check_order_quantity($id, $buy_order_id, $admin_id, $symbol, $quantity) {

		$created_date = date("Y-m-d G:i:s");
		//Get user Details
		$this->db->dbprefix('settings');
		$this->db->where('user_id', $admin_id);
		$get_settings = $this->db->get('settings');
		$setting_arr  = $get_settings->row_array();

		echo '<pre>';
		print_r($setting_arr);
		exit;

		if ($setting_arr['api_key'] != "" && $setting_arr['api_secret'] != "" && $setting_arr['auto_sell_enable'] == "yes") {

			//Get user Balance
			$this->db->dbprefix('coin_balance');
			$this->db->where('coin_symbol', $symbol);
			$this->db->where('user_id', $admin_id);
			$get_coin_record = $this->db->get('coin_balance');
			$coin_record_arr = $get_coin_record->row_array();

			$coin_balance = $coin_record_arr['coin_balance'];

			if ($quantity > $coin_balance) {

				//Update Order Record
				$upd_data = array(
					'quantity'              => $coin_balance,
					'modified_date'         => $this->mongo_db->converToMongodttime($created_date),
					'last_quantity_updated' => 'yes',
				);

				$this->mongo_db->where(array('_id' => $id));
				$this->mongo_db->set($upd_data);
				$this->mongo_db->update('orders');

				//////////////////////////////////////////////////////////////////////////////
				////////////////////////////// Order History Log /////////////////////////////
				$log_msg = "Sell Order Quantity Updated from <b>".$quantity."</b> to <b>".$coin_balance."</b> as per your Last Order Settings";
				$this->insert_order_history_log($buy_order_id, $log_msg, 'auto_update_quantity', $admin_id);
				////////////////////////////// End Order History Log /////////////////////////
				//////////////////////////////////////////////////////////////////////////////

				return $coin_balance;

			} else {

				return "no";
			}

		} else {

			return "no";
		}

	}//end check_order_quantity

	public function get_buy_sell_rules_log($symbol="NCASHBTC") {

		$start_date = '2018-12-05 10:00:00';
		$end_date = '2018-12-05 12:59:59';


		$type = 'buy';
		$buy_arr = $this->get_rules_log($symbol, $start_date, $end_date, $type);

		$type = 'sell';
		$sell_arr = $this->get_rules_log($symbol, $start_date, $end_date, $type);
		$new_sell_arr = [];
		foreach ($sell_arr as $key => $value) {
			$fullTextBuy = explode('<br>',$value['log']);
			$newMessageArr = preg_replace('/<[^>]*>/', '', $fullTextBuy);
			$rule_sort_string = $newMessageArr[1];
			$rule_sort_Arr = explode("=>", $rule_sort_string);
			$new_sell_arr[$value['rule_number']] = $rule_sort_Arr[1];
		}

		echo "<pre>";
		print_r($new_sell_arr);



		exit;
		$buy_rule = array();
		foreach ($buy_arr as $key => $value) {
			$arr = array();
			$arr['rule_number'] = $value['rule_number'];
			$arr['buy_price'] = $value['market_price'];
			$arr['sell_price'] = 0;
			$buy_rule[$value['rule_number']] = $arr;

		}
		$sell_rule = array();
		foreach ($sell_arr as $key => $value) {
			$arr = array();
			$arr['rule_number'] = $value['rule_number'];
			$arr['buy_price'] = 0;
			$arr['sell_price'] = $value['market_price'];
			$sell_rule[$value['rule_number']] = $arr;
		}

		$rule_array = array("rule_no_1", "rule_no_2", "rule_no_3", "rule_no_4", "rule_no_5", "rule_no_6", "rule_no_7", "rule_no_8", "rule_no_9", "rule_no_10");
		$color = array();
		foreach ($rule_array as $key => $value) {
			if (array_key_exists($value,$buy_rule)) {
				$color[$value]['color'] = 'blue';
				$color[$value]['buy_price'] = $buy_rule[$value]['buy_price'];
				$color[$value]['sell_price'] = $buy_rule[$value]['sell_price'];

			}
			if (array_key_exists($value,$sell_rule)) {
				if (array_key_exists($value, $color)) {
					$color[$value]['color'] = 'plum';
					$color[$value]['buy_price'] = $buy_rule[$value]['buy_price'];
					$color[$value]['sell_price'] = $sell_rule[$value]['sell_price'];
				} else {
					$color[$value]['color'] = 'red';
					$color[$value]['buy_price'] = $sell_rule[$value]['buy_price'];
					$color[$value]['sell_price'] = $sell_rule[$value]['sell_price'];
				}
			}

			if (!array_key_exists($value, $color)) {
				$color[$value]['color'] = 'white';
				$color[$value]['buy_price'] = 0;
				$color[$value]['sell_price'] = 0;
			}
		}
			echo "<pre>";
			echo "Buy Rules" . "<br>";
			print_r($buy_rule);
			echo "<br>";
			echo "Sell Rules" . "<br>";
			print_r($sell_rule);
			echo "<br>";
			echo "Colors Rules" . "<br>";
			print_r($color);
			exit;



	}

	public function get_rules_log($symbol, $start_date, $end_date, $type) {
		$db = $this->mongo_db->customQuery();

		$where_array['coin_symbol'] = $symbol;
		$where_array['type'] = $type;
		$where_array['rule_number'] = array('$in' => array("rule_no_1", "rule_no_2", "rule_no_3", "rule_no_4", "rule_no_5", "rule_no_6", "rule_no_7", "rule_no_8", "rule_no_9", "rule_no_10"));
		$where_array['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($start_date), '$lt' => $this->mongo_db->converToMongodttime($end_date));

		$pipeline = array(
			array(
				'$project' => array(
					"coin_symbol" => 1,
					"log" => 1,
					"type" => 1,
					"_id" => 1,
					"rule_number" => 1,
					'created_date' => 1,
					'market_price' => 1,
				),
			),

			array(
				'$match' => $where_array,
			),

			array('$sort' => array('created_date' => -1)),
			// array('$sort'=>array('price'=>1)),
			array('$group' => array(
				'_id' => array('rule_number' => '$rule_number'),
				'log' => array('$first' => '$log'),
				'type' => array('$first' => '$type'),
				'rule_number' => array('$first' => '$rule_number'),
				'coin_symbol' => array('$first' => '$coin_symbol'),
				'created_date' => array('$first' => '$created_date'),
				'market_price' => array('$first' => '$market_price'),
			),

			),
			array('$sort' => array('created_date' => 1)),
		);

		$allow = array('allowDiskUse' => true);
		$responseArr = $db->barrier_trigger_true_rules_collection->aggregate($pipeline, $allow);
		return iterator_to_array($responseArr);
	}

	public function testing_orders()
	{

		$search['trigger_type'] = 'trigger_2';
		$this->mongo_db->where($search);
		$iterator = $this->mongo_db->delete_all('buy_orders');

		echo "<pre>";
		print_r(iterator_to_array($iterator));
		exit;
	}

	public function timezone_time_test()
	{
		echo date("Y-m-d H:i:s e");
	}

	public function update_candles(){
		$value = $this->input->post();
		unset($value['_id']);
		unset($value['timestampDate']);
		$value = (array) $value;
		$filter = array('coin'=>$value['coin'],'openTime_human_readible' => $value['openTime_human_readible']);
		$obj = $this->mongo_db->converToMongodttime($value['openTime_human_readible']);
		$value['timestampDate'] = $obj;
		$value['created_date'] = $obj;





		$this->mongo_db->where($filter);
		$get = $this->mongo_db->get('market_chart');
		$get_obj = iterator_to_array($get);





		if (count($get_obj) > 0) {

			$value['mynewobject'] = 'waqartestingobject';
			$this->mongo_db->where($filter);
			$this->mongo_db->set($value);
			$get11 = $this->mongo_db->update('market_chart');
			echo 'update';
		}else{
			echo 'inserted';
			$value['mynewobject'] = 'waqartestingobject';
			$get11 = $this->mongo_db->insert('market_chart',$value);
			var_dump($get11);
		}


		echo '*********************************************************<br>';

		exit;
	}

	public function waqar(){
			//$this->mongo_db->limit(1);
			//$this->mongo_db->order_by(array('created_date' => -1));
			$get = $this->mongo_db->count("barrier_trigger_true_rules_collection");

			echo "<pre>";
			print_r(($get));
	}
} //End of Model
