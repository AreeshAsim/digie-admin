<?php

/**
 *
 */
class Trades_test extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('admin/mod_sockets');

	}

	public function index() {

		$epoch = 1527932237612;
		$created_date = new MongoDB\BSON\UTCDateTime($epoch);

		echo '<pre>';
		print_r($created_date);

		/*
			$created_date = $this->mongo_db->converToMongodttime($orig_date);

		*/
		$insert22 = array(
			'maker' => 'false',
			'coin' => 'NCASHBTC',
		);
		$this->mongo_db->where($insert22);
		$this->mongo_db->sort(array("_id" => -1));
		$this->mongo_db->limit(1000);
		$data = $this->mongo_db->get('market_trades');

		$data_arr = iterator_to_array($data);

		echo "<pre>";
		print_r($data_arr);
		exit;

	}

	public function historical_data($time_stamp) {

		if (!$time_stamp) {

			return array();
		}

		$header = array(
			//Free Token : 6e80f4879da5a0c2f7f2eb2b641033b12541538e
			//Paid Token first  : cf0fc855ba948e64af7ab897631ef67d1a02c007

			//second paid token : 625ecb409c9efe54b7c15ed6952d48544b9ddaa1

			'Accept: application/json',
			'Authorization: Token 625ecb409c9efe54b7c15ed6952d48544b9ddaa1',
		);

		$set_url = "https://coinograph.io/trades/?symbol=binance:BNBBTC&limit=300&start=$time_stamp";

		//echo $set_url; exit;
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $set_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => $header,
		));

		$response = curl_exec($curl);

		if (curl_error($ch)) {
			$error_msg = curl_error($ch);
		}
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;

		} else {

			return json_decode($response);
			exit;
		}
	}

	public function save_market_history_data($time_stamp = '') {

		//$this->mongo_db->where(array('tid'=>3957291));
		// $this->mongo_db->limit(50);
		// $this->mongo_db->order_by(array('created_date'=> -1));

		// $res = $this->mongo_db->get('market_history_data_from_api_EOS_BTC_second');
		// $res = iterator_to_array($res);

		// echo '<pre>';
		// print_r($res);
		// exit();

		$time_stamp = '1527860017';

		$insert_array = array('timestamp' => $time_stamp, 'no_of_duplication' => 0);
		$this->mongo_db->set($insert_array);
		$this->mongo_db->update('market_history_data_counter_for_api_call');
		exit;
		// $res = $this->mongo_db->get('market_history_data_counter_for_api_call');
		// $res =iterator_to_array($res);

		// echo '<pre>';
		// print_r($res);
		// exit();

		$history_data = $this->historical_data($time_stamp);

		// echo '<pre>';
		// print_r($history_data);
		// exit();

		// // echo '<pre>';
		// // print_r($history_data);
		// // exit();

		if (count($history_data) > 0) {

			foreach ($history_data as $key => $trades) {

				$time_stamp_date = $trades->time;

				$primary_key = $trades->tid;

				if ($trades->type == 0) {
					$maker = 'true';
				} else {
					$maker = 'false';
				}

				$orig_date = ($trades->time) * 1000;

				$created_date = new MongoDB\BSON\UTCDateTime($orig_date);

				$insert22 = array(
					'price' => (float) $trades->price,
					'quantity' => (float) $trades->amount,
					'created_date' => $created_date,
					'maker' => $maker,
					'coin' => 'BNBBTC',
					'time' => $trades->time,
					'type' => $trades->type,
					'tid' => $trades->tid,

				);
				$this->mongo_db->insert('market_history_data_from_api_BNBBTC', $insert22);

			}

			$insert_array = array('timestamp' => $time_stamp_date, 'tid' => $primary_key);
			$this->mongo_db->set($insert_array);
			$this->mongo_db->update('market_history_data_counter_for_api_call');

		} //if data not exist

		$res = $this->mongo_db->get('market_history_data_counter_for_api_call');
		$res = iterator_to_array($res);

		if (count($res) > 0) {
			foreach ($res as $value1) {
				$timestamp = $value1['timestamp'];
				$counter = $value1['counter'];
				$tid = $value1['tid'];
				$no_of_duplication = $value1['no_of_duplication'];

			}
		}

		if ($primary_key == $tid) {

			$no_of_duplication = $no_of_duplication + 1;
			$insert_array = array('no_of_duplication' => $no_of_duplication);
			$this->mongo_db->set($insert_array);
			$this->mongo_db->update('market_history_data_counter_for_api_call');
		} else {
			$no_of_duplication = 0;
		}

		if ($no_of_duplication == 3) {

			$no_of_duplication = 0;
			$insert_array = array('no_of_duplication' => $no_of_duplication);
			$this->mongo_db->set($insert_array);
			$this->mongo_db->update('market_history_data_counter_for_api_call');
			$timestamp = $timestamp + 1;
		}

		$counter = $counter + 1;
		$update_counter = array('counter' => $counter);
		$this->mongo_db->set($update_counter);
		$this->mongo_db->update('market_history_data_counter_for_api_call');

		if ($counter <= 500) {
			$this->save_market_history_data($timestamp);
		} else {

			$update_counter = array('counter' => 1);
			$this->mongo_db->set($update_counter);
			$this->mongo_db->update('market_history_data_counter_for_api_call');
			exit();
		}

	} //End if Function save_market_history_data

	public function make_date_arr($start_date) {

		$startTime = date($start_date);

		$end = date($start_date);
		$dates_arr = array();
		for ($tm = 0; $tm < 24; $tm++) {
			$start_time = date('Y-m-d H:00:00', strtotime('+' . $tm . ' hour', strtotime($startTime)));
			$end_time = date('Y-m-d H:59:59', strtotime('+' . $tm . ' hour', strtotime($end)));

			$dates_arr[$start_time] = $end_time;

		}
		return $dates_arr;
	} //End of make_date_arr

	/******* Function for gettong  history data from data base and ********/

	public function market_trade_hourly_history_from_api() {

		if (isset($_GET['start_date'])) {
			$start_date = $_GET['start_date'];
		}

		$res = $this->make_date_arr($start_date);

		foreach ($res as $start_tm => $end_tm) {

			echo '<a href="https://app.digiebot.com/admin/trades_test/market_trade_hourly_history_from_api?start_date=' . $start_tm . '">' . $start_tm . '</a>';

			echo '<br>';

			$start_second = strtotime(date($start_tm));
			$end_second = strtotime(date($end_tm));
			$current_date = date($start_tm);

			$start_milli_second = $start_second * 1000;
			$end_milli_second = $end_second * 1000;

			$start_milli_second_obj = new MongoDB\BSON\UTCDateTime($start_milli_second);
			$end_milli_second_obj = new MongoDB\BSON\UTCDateTime($end_milli_second);

			$current_date_milli_second = $current_date * 1000;
			$current_date_milli_second_obj = new MongoDB\BSON\UTCDateTime($current_date_milli_second);

			$pipeline = array(
				'$group' => array('_id' => '$price', 'quantity' => array('$sum' => '$quantity'),
					'maker' => array('$first' => '$maker'),
					'coin' => array('$first' => '$coin'),
					'created_date' => array('$first' => '$created_date'),
					'price' => array('$first' => '$price'),
					'type' => array('$first' => '$type'),
				),
			);

			$project = array(
				'$project' => array(
					"_id" => 1,
					"price" => 1,
					"quantity" => 1,
					"maker" => 1,
					"coin" => 1,
					'created_date' => 1,
					'type' => 1,
				),
			);

			/*** For ask insertion**/

			//$coin_symbol = 'EOSBTC';
			$coin_symbol = 'BNBBTC';
			$match = array(
				'$match' => array(
					'coin' => $coin_symbol,
					'type' => 0,
					'created_date' => array('$gte' => $start_milli_second_obj,
						'$lte' => $end_milli_second_obj),
				),
			);

			$connect = $this->mongo_db->customQuery();

			//market_history_data_from_api_BNBBTC
			//$market_history_Arr = $connect->market_history_data_from_api_EOS_BTC_second->aggregate(array($project, $match, $pipeline));

			$market_history_Arr = $connect->market_history_data_from_api_BNBBTC->aggregate(array($project, $match, $pipeline));

			$market_history_Arr = iterator_to_array($market_history_Arr);

			foreach ($market_history_Arr as $key => $value) {

				$type = 'ask';
				$newmakert = 'false';

				$insert_array = array(
					'coin' => $value['coin'],
					'hour' => $current_date,
					'hour_timestamp' => $current_date_milli_second,
					'price' => (float) $value['price'],
					'volume' => (float) $value['quantity'],
					'timestamp' => $value['created_date'],
					'type' => $type,
					'maker' => $newmakert,
				);

				$this->mongo_db->where(array('hour' => $current_date, 'coin' => $value['coin'], 'price' => (float) $value['price'], 'type' => $type));

				$result = $this->mongo_db->get('market_trade_hourly_history_for_api_collection');

				$result = iterator_to_array($result);

				if (count($result) > 0) {

					$this->mongo_db->where(array('hour' => $current_date, 'coin' => $value['coin'], 'price' => (float) $value['price'], 'type' => $type));
					$this->mongo_db->set($insert_array);
					//Update data in mongoTable
					$this->mongo_db->update('market_trade_hourly_history_for_api_collection');

					// echo 'coin updated at '.$current_date.'--- con'.$value['coin'].'<br>';
					// echo '... AAAAAAASSSSSSSSkk.'.'<br>';

				} else {

					$this->mongo_db->insert('market_trade_hourly_history_for_api_collection', $insert_array);
					// echo 'coin inserted at '.$current_date.'--- con'.$value['coin'].'<br>';
					// echo '... AAAAAAASSSSSSSSkk.'.'<br>';
				}

			}

			/** End of  for each coin symbol**/

			/***** End of ask insetion****/

			/*** For bid insertion**/

			$coin_symbol = 'EOSBTC';

			$match = array(
				'$match' => array(
					'coin' => $coin_symbol,
					'type' => 1,
					'created_date' => array('$gte' => $start_milli_second_obj,
						'$lte' => $end_milli_second_obj),
				),
			);

			$connect = $this->mongo_db->customQuery();

			$market_history_Arr = $connect->market_history_data_from_api_EOS_BTC_second->aggregate(array($project, $match, $pipeline));

			$market_history_Arr = iterator_to_array($market_history_Arr);

			foreach ($market_history_Arr as $key => $value) {

				$type = 'bid';
				$newmakert = 'true';

				$insert_array = array(
					'coin' => $value['coin'],
					'hour' => $current_date,
					'hour_timestamp' => $current_date_milli_second,
					'price' => (float) $value['price'],
					'volume' => (float) $value['quantity'],
					'timestamp' => $value['created_date'],
					'type' => $type,
					'maker' => $newmakert,
				);

				$this->mongo_db->where(array('hour' => $current_date, 'coin' => $value['coin'], 'price' => (float) $value['price'], 'type' => $type));

				$result = $this->mongo_db->get('market_trade_hourly_history_for_api_collection');

				$result = iterator_to_array($result);

				if (count($result) > 0) {

					$this->mongo_db->where(array('hour' => $current_date, 'coin' => $value['coin'], 'price' => (float) $value['price'], 'type' => $type));
					$this->mongo_db->set($insert_array);
					//Update data in mongoTable
					$this->mongo_db->update('market_trade_hourly_history_for_api_collection');

					// echo 'coin updated at '.$current_date.'--- con'.$value['coin'].'<br>';
					// echo '... bBBBBBBBBBBBBBBIIIIIIIIIIID.'.'<br>';

				} else {

					$this->mongo_db->insert('market_trade_hourly_history_for_api_collection', $insert_array);
					// echo 'coin inserted at '.$current_date.'--- con'.$value['coin'].'<br>';
					// echo '... bBBBBBBBBBBBBBBIIIIIIIIIIID.'.'<br>';
				}

			}

		} //End of Date Array

		/** End of  for each coin symbol**/

	} /*** End of get_market_history***/

	public function market_trade_hourly_history_from_api_saeedullah_backup() {

		if (isset($_GET['start_date'])) {
			$start_date = $_GET['start_date'];

		}
		$res = $this->make_date_arr($start_date);

		foreach ($res as $start_tm => $end_tm) {

			echo '<a href="https://app.digiebot.com/admin/trades_test/market_trade_hourly_history_from_api?start_date=' . $start_tm . '">' . $start_tm . '</a>';

			echo '<br>';

			$start_second = strtotime(date($start_tm));
			$end_second = strtotime(date($end_tm));
			$current_date = date($start_tm);

			$start_milli_second = $start_second * 1000;
			$end_milli_second = $end_second * 1000;

			$start_milli_second_obj = new MongoDB\BSON\UTCDateTime($start_milli_second);
			$end_milli_second_obj = new MongoDB\BSON\UTCDateTime($end_milli_second);

			$current_date_milli_second = $current_date * 1000;
			$current_date_milli_second_obj = new MongoDB\BSON\UTCDateTime($current_date_milli_second);

			$pipeline = array(
				'$group' => array('_id' => '$price', 'quantity' => array('$sum' => '$quantity'),
					'maker' => array('$first' => '$maker'),
					'coin' => array('$first' => '$coin'),
					'created_date' => array('$first' => '$created_date'),
					'price' => array('$first' => '$price'),
					'type' => array('$first' => '$type'),
				),
			);

			$project = array(
				'$project' => array(
					"_id" => 1,
					"price" => 1,
					"quantity" => 1,
					"maker" => 1,
					"coin" => 1,
					'created_date' => 1,
					'type' => 1,
				),
			);

			/*** For ask insertion**/

			$coin_symbol = 'ZECBTC';

			$match = array(
				'$match' => array(
					'coin' => $coin_symbol,
					'type' => 0,
					'created_date' => array('$gte' => $start_milli_second_obj,
						'$lte' => $end_milli_second_obj),
				),
			);

			$connect = $this->mongo_db->customQuery();

			$market_history_Arr = $connect->market_history_data_from_api_ZEC_BTC_second->aggregate(array($project, $match, $pipeline));

			$market_history_Arr = iterator_to_array($market_history_Arr);

			foreach ($market_history_Arr as $key => $value) {
				// $type = 'ask';

				// if($value['maker'] =='true'){
				// $type = 'bid';
				// }

				$type = 'ask';
				$newmakert = 'false';

				if ($value['maker'] == 'false') {
					$type = 'bid';
					$newmakert = 'true';
				}

				$insert_array = array(
					'coin' => $value['coin'],
					'hour' => $current_date,
					'hour_timestamp' => $current_date_milli_second,
					'price' => (float) $value['price'],
					'volume' => (float) $value['quantity'],
					'timestamp' => $value['created_date'],
					'type' => $type,
					// 'maker'=>$value['maker']
					'maker' => $newmakert,
				);

				$this->mongo_db->where(array('hour' => $current_date, 'coin' => $value['coin'], 'price' => (float) $value['price'], 'type' => $type));

				$result = $this->mongo_db->get('market_trade_hourly_history_for_api_collection');

				$result = iterator_to_array($result);

				if (count($result) > 0) {

					$this->mongo_db->where(array('hour' => $current_date, 'coin' => $value['coin'], 'price' => (float) $value['price'], 'type' => $type));
					$this->mongo_db->set($insert_array);
					//Update data in mongoTable
					$this->mongo_db->update('market_trade_hourly_history_for_api_collection');

					// echo 'coin updated at '.$current_date.'--- con'.$value['coin'].'<br>';
					// echo '... AAAAAAASSSSSSSSkk.'.'<br>';

				} else {
					$this->mongo_db->insert('market_trade_hourly_history_for_api_collection', $insert_array);
					// echo 'coin inserted at '.$current_date.'--- con'.$value['coin'].'<br>';
					// echo '... AAAAAAASSSSSSSSkk.'.'<br>';
				}

			}

			/** End of  for each coin symbol**/

			/***** End of ask insetion****/

			/*** For bid insertion**/

			$coin_symbol = 'ZECBTC';

			$match = array(
				'$match' => array(
					'coin' => $coin_symbol,
					'type' => 1,
					'created_date' => array('$gte' => $start_milli_second_obj,
						'$lte' => $end_milli_second_obj),
				),
			);

			$connect = $this->mongo_db->customQuery();

			$market_history_Arr = $connect->market_history_data_from_api_ZEC_BTC->aggregate(array($project, $match, $pipeline));

			$market_history_Arr = iterator_to_array($market_history_Arr);

			foreach ($market_history_Arr as $key => $value) {

				// $type = 'ask';

				// if($value['maker'] =='true'){
				//     $type = 'bid';
				// }

				$type = 'ask';
				$newmakert = 'true';
				if ($value['maker'] == 'true') {
					$type = 'bid';
					$newmakert = 'false';
				}

				$insert_array = array(
					'coin' => $value['coin'],
					'hour' => $current_date,
					'hour_timestamp' => $current_date_milli_second,
					'price' => (float) $value['price'],
					'volume' => (float) $value['quantity'],
					'timestamp' => $value['created_date'],
					'type' => $type,
					// 'maker'=>$value['maker']

					'maker' => $newmakert,
				);

				$this->mongo_db->where(array('hour' => $current_date, 'coin' => $value['coin'], 'price' => (float) $value['price'], 'type' => $type));

				$result = $this->mongo_db->get('market_trade_hourly_history_for_api_collection');

				$result = iterator_to_array($result);

				if (count($result) > 0) {

					$this->mongo_db->where(array('hour' => $current_date, 'coin' => $value['coin'], 'price' => (float) $value['price'], 'type' => $type));
					$this->mongo_db->set($insert_array);
					//Update data in mongoTable
					$this->mongo_db->update('market_trade_hourly_history_for_api_collection');

					// echo 'coin updated at '.$current_date.'--- con'.$value['coin'].'<br>';
					// echo '... bBBBBBBBBBBBBBBIIIIIIIIIIID.'.'<br>';

				} else {
					$this->mongo_db->insert('market_trade_hourly_history_for_api_collection', $insert_array);
					// echo 'coin inserted at '.$current_date.'--- con'.$value['coin'].'<br>';
					// echo '... bBBBBBBBBBBBBBBIIIIIIIIIIID.'.'<br>';
				}

			}

		} //End of Date Array

		/** End of  for each coin symbol**/

	} /*** End of market_trade_hourly_history_from_api_saeedullah_backup***/

	public function test() {

		$connect = $this->mongo_db->customQuery();

		// $where= array('type'=>'bid');
		// $set = array('$set'=>array('maker'=>'true'));

		// $res = $connect->market_trade_hourly_history_for_api_collection->updateMany($where,$set);

		// echo '<pre>';
		// print_r($res);
		// exit();

		//  $this->mongo_db->limit(100);
		//  $this->mongo_db->order_by(array('_id'=>-1));
		// $res  = $this->mongo_db->get('market_trade_hourly_history_for_api_collection');

		// $res = iterator_to_array($res);

		// echo '<pre>';
		// print_r($res);
		// exit();

		//   $this->mongo_db->order_by(array('_id'=>-1));
		//   $this->mongo_db->limit(400);
		// $res  = $this->mongo_db->get('market_history_data_from_api_ncash');
		// $res =iterator_to_array($res);
		//       echo '<pre>';
		//       print_r($res);
		//       exit();

		//  $this->mongo_db->order_by(array('_id'=>-1));
		//  $this->mongo_db->limit(100);
		// $res = $this->mongo_db->get('market_history_data_from_api_EOS_BTC');

		// $res = iterator_to_array($res);

		// echo '<pre>';
		// print_r($res);
		// exit();

		$db = $this->mongo_db->customQuery();
//         echo $db->market_history_data_from_api_EOS_BTC_second->count();
		//          $start_milli_second_obj = new MongoDB\BSON\UTCDateTime('1509693265000');
		//          $res= $db->market_history_data_from_api_EOS_BTC_second->deleteMany(array('created_date'=>array('$lt'=>$start_milli_second_obj )));

//          echo '<br>';
		// echo $db->market_history_data_from_api_EOS_BTC_second->count();

//          echo '<pre>';
		//          print_r($res);
		//          exit();

		/*echo $db->market_history_data_from_api_EOS_BTC_second->count();*/
		//market_history_data_from_api_BNBBTC
		echo $db->market_history_data_from_api_BNBBTC->count();
		//$res = $this->mongo_db->get('market_history_data_counter_for_api_call');
		$res = $this->mongo_db->get('market_history_data_counter_for_api_call');
		$res = iterator_to_array($res);
		echo '<pre>';
		print_r($res);
		exit();
	}

	public function candle_historical_data($time_stamp) {

		//1522540800

		//625ecb409c9efe54b7c15ed6952d48544b9ddaa1
		$header = array(
			'Accept: application/json',
			'Authorization: Token cf0fc855ba948e64af7ab897631ef67d1a02c007',
		);

		$set_url = "https://coinograph.io/candles/?symbol=binance:eosbtc&limit=300&step=3600&start=" . $time_stamp;
		// $set_url = "https://coinograph.io/trades/?symbol=binance:eosbtc&limit=300&start=$time_stamp";

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $set_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => $header,
		));

		$response = curl_exec($curl);

		if (curl_error($ch)) {
			$error_msg = curl_error($ch);
		}
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;

		} else {

			return json_decode($response);
			exit;
		}

	}

	public function get_candle_data($time_stamp = '') {

		$candle_data = $this->candle_historical_data($time_stamp);

		$coin_symbol = 'EOSBTC';
		$periods = '1h';

		if (count($candle_data) > 0) {

			foreach ($candle_data as $key => $value) {

				$created_datetime = date('Y-m-d G:i:s');

				$orig_date = new DateTime($created_datetime);
				$orig_date = $orig_date->getTimestamp();
				$created_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

				$seconds = $value->time;
				$datetime = date("Y-m-d H:i:s", $seconds);
				$openTime_human_readible = $datetime;

				$seconds_close = $value->time;
				$datetime_close = date("Y-m-d H:59:59", $seconds_close);

				$closeTime = strtotime($datetime_close) * 1000;
				$openTime = $value->time * 1000;

				$closeTime_human_readible = $datetime_close;

				$orig_date22 = new DateTime($datetime);
				$orig_date22 = $orig_date22->getTimestamp();
				$timestampDate = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);

				$insert22 = array(
					'open' => $value->open,
					'high' => $value->high,
					'low' => $value->low,
					'close' => $value->close,
					'volume' => $value->volume,
					'openTime' => $openTime,
					'closeTime' => $closeTime,
					'coin' => $coin_symbol,
					'created_date' => $created_date,
					'timestampDate' => $timestampDate,
					'periods' => $periods,
					'openTime_human_readible' => $openTime_human_readible,
					'closeTime_human_readible' => $closeTime_human_readible,
					'human_readible_dateTime' => date('Y-m-d G:i:s'),
					'candel_status' => '',
					'candle_type' => '',
					'ask_volume' => '',
					'bid_volume' => '',
					'total_volume' => '',
				);

				$check_candle = $this->mod_sockets->check_candle_stick_data_if_exist($coin_symbol, $periods, $openTime);

				if ($check_candle) {

					$this->mongo_db->insert('market_chart', $insert22);
					echo 'insert' . '<br>';

				} else {

					$if_current_cand = $this->check_if_current_candle($periods, $openTime);
					if ($if_current_cand) {

						$this->mod_sockets->candle_update($coin_symbol, $periods, $openTime, $insert22);
						echo 'update' . '<br>';

					} else {

						$update_count_for_canlde_missing = $this->mod_sockets->update_count_for_ignore_candle();
						echo 'nothing' . '<br>';

					} /*** End of update***/

				} /*** End of insert***/

			}

		} //if data not exist

		echo "<pre>";
		print_r($candle_data);
		exit;

	} //End if Function save_market_history_data

	public function check_if_current_candle($periods, $openTime) {

		list($alpha, $numeric) = sscanf($periods, "%[A-Z]%d");

		switch ($alpha) {
		case "h":
			$response_period = ($numeric * 3600) * 2;
			break;

		case "m":
			$response_period = ($numeric * 60) * 2;
			break;

		default:
			$response_period = 1 * 2;
		}

		$seconds = $openTime / 1000;
		$datetime = date("Y-m-d H:i:s", $seconds);

		$seconds_2 = $seconds - $response_period;

		$datetime_2 = date("Y-m-d H:i:s", $seconds_2);

		if ($datetime_2 < $datetime) {
			return true;
		} else {
			return false;
		}

	} /*** End of check_if_current_candle**/

}