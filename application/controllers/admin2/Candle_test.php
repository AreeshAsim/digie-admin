<?php
/**
 *
 */
 
class Candle_test extends CI_Controller {

	function __construct() {
		
		parent::__construct();
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_candle_chart_day');
	}
	

	
	public function deleteDataFromTable() {

		$removeTime = date('Y-m-d G:i:s', strtotime( (date("2018-10-10 00:00:00"))));
		
		$orig_date = new DateTime($removeTime);

		$orig_date = $orig_date->getTimestamp();

		$created_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);
	

		$db = $this->mongo_db->customQuery();

		///////////////////////////////////////////////////////////////

		$delectmarket_prices = $db->market_chart_dailybase->deleteMany(array('openTime_human_readible' => array('$gte' => $removeTime)));

		$delectmarket_trades = $db->market_chart_dailybase->deleteMany(array('openTime_human_readible' => array('$gte' => $removeTime)));
		
		
		echo $delectmarket_trades; exit;
		

	} //delete_data_from_data_base

	

	public function index() {
		
		/*$coin_symbol = 'NCAHBTC'; 
		   $res = $this->mongo_db->get('market_chart_dailybase');
					$result = iterator_to_array($res);
					
		  echo "<pre>";  print_r($result); exit;			
					*/
		   
		   
		   //$allArray  =  $this->mod_candle_chart_day->save_candle_stick_by_cron_job();
		    
		   //echo "<pre>";  print_r($allArray); exit;
		
		   echo  $curr_time   = date('Y-m-d G:i:s', 1538870400);  
		   
		   echo "<br />";
		   echo  $curr_time   = date('Y-m-d G:i:s', 1539302400);  
		   echo "<br />";

		    echo $curr_time   = date('Y-m-d G:i:s', strtotime('-3 days'));  
			echo "<br />";
		    $time_stamp  = strtotime($curr_time);
			echo $time_stamp  = $time_stamp;
			
			
			//exit;
			//$time_stamp  = $curr_time;
			//$time_stamp = 1522540800;

			$candle_data = $this->candle_historical_data($time_stamp);
			
			//echo "<pre>";  print_r($candle_data); exit;
			

			$coin_symbol = 'BCNBTC'; 
			
			
			//Fetching coins Record
			$coins_arr = $this->mod_coins->get_all_coins();
			   
		
			$periods = '1d';

			if (count($candle_data) > 0) {



				foreach ($candle_data as $key => $value) {



					$created_datetime = date('Y-m-d G:i:s');



					$orig_date = new DateTime($created_datetime);

					$orig_date = $orig_date->getTimestamp();

					$created_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);



					$seconds = $value->time;

					$datetime = date("Y-m-d H:i:s", $seconds);

					$openTime_human_readible = $datetime;



					$seconds_close = $value->time + 86399;

					$datetime_close = date("Y-m-d H:i:s", $seconds_close);



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
                      

					$check_candle_data = $this->check_candle_stick_data_if_exist($coin_symbol, $periods, $openTime);

					//var_dump($check_candle_data);exit;

					if ($check_candle_data) {

						$this->mongo_db->insert('market_chart_dailybase', $insert22);

						echo 'insert' . '<br>';

					} else {

						$if_current_cand = $this->check_if_current_candle($periods, $openTime);

						if ($if_current_cand) {



							$this->candle_update($coin_symbol, $periods, $openTime, $insert22);

							echo 'update ' . $openTime . '<br>';

						}

					}

				}



			} else {

				echo "api Completed";

			}

		

		exit;

	}



	public function candle_historical_data($time_stamp) {



          $time_stamp  ='1539317387';
         //echo $datetime_close = date("Y-m-d H:i:s", '1529960800');    e
		 
		 
		

		//1522540800

		//625ecb409c9efe54b7c15ed6952d48544b9ddaa1 //paid

		//6e80f4879da5a0c2f7f2eb2b641033b12541538e

		//61b9b44432dab57fff21937469e241215b6c3997

		//cf0fc855ba948e64af7ab897631ef67d1a02c007 //paid

		$header = array(

			'Accept: application/json',

			'Authorization: Token 61b9b44432dab57fff21937469e241215b6c3997',

		);



		$set_url = "https://coinograph.io/candles/?symbol=binance:bcnbtc&limit=7&step=86400&start=" . $time_stamp;



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



	public function get_market_prices() {

		$this->mongo_db->order_by(array('_id' => -1));

		$this->mongo_db->limit(1);

		$res = $this->mongo_db->get('market_chart_dailydata');



		echo "<pre>";

		print_r(iterator_to_array($res));

		exit;

	}



	public function check_candle_stick_data_if_exist($coin_symbol, $period, $openTime) {



		$this->mongo_db->where(array('coin' => $coin_symbol, 'periods' => $period, 'openTime' => $openTime));

		$responseArr = $this->mongo_db->get('market_chart_dailybase');



		$exist = 0;

		foreach ($responseArr as $key) {

			$exist = 1;

			break;

		}

		if ($exist == 1) {

			return false;

		} else {

			return true;

		}



	}/** End of check_candle_stick_data_if_exist***/



	public function candle_update($coin_symbol, $period, $openTime, $insert22) {

		$this->mongo_db->where(array('coin' => $coin_symbol, 'periods' => $period, 'openTime' => $openTime));

		$this->mongo_db->set($insert22);

		$this->mongo_db->update('market_chart_dailybase');



	}/** candle_update***/



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



	public function get_values_from_market_chart() {

		//openTime

		//5b5ab703819e125ea624efa2, 5b5ab703819e125ea624efa2

		$this->mongo_db->where(array('coin' => 'NCASHBTC', 'openTime' => array('$gte' => 1528011600)));

		$this->mongo_db->order_by(array('_id' => 1));

		$get = $this->mongo_db->get('market_chart');

		$candle_data = iterator_to_array($get);

		$coin_symbol = 'NCASHBTC';

		foreach ($candle_data as $key => $value) {

			$openTime = $value->openTime;

			$insert22 = array(

				'market_value' => $value->high,

				'time' => $openTime,

				'coin' => $coin_symbol,

			);



			$this->mongo_db->insert('market_chart_dailybase', $insert22);

			echo 'insert' . $openTime . '<br>';

		}

	}



	public function auto_insert() {

		$curr_time = date('Y-m-d G:i:s', strtotime('-5 minutes'));

		$seconds = $this->mongo_db->converToMongodttime($curr_time);

		$search['created_date'] = array('$lte' => $seconds);

		$search['coin'] = 'NCASHBTC';

		$this->mongo_db->where($search);

		$get = $this->mongo_db->get('market_prices');



		echo "<pre>";

		print_r(iterator_to_array($get));

		exit;



	}



	public function auto_update() {

		$search['coin'] = 'NCASHBTC';

		$this->mongo_db->where($search);

		$get = $this->mongo_db->get('market_price_history_daily');

		foreach ($get as $key => $value) {

			if (!empty($value)) {

				$time = $value->time;

				echo $time;

				echo "<br>";

				$datetime = date("Y-m-d G:i:s", ($time / 1000));

				$mongo_time = $this->mongo_db->converToMongodttime($datetime);



				$upd_arr = array("time" => $mongo_time);



				$this->mongo_db->where(array("time" => $time));

				$this->mongo_db->set($upd_arr);

				echo $this->mongo_db->update("market_chart_dailybase");

				echo "<br>";

			}

		}



	}
	
	public function dropTable() {
	  $get_data = $this->mongo_db->drop_collection('sdsd');
	
	  echo $get_data;
	  exit;
    }
	
	public function delete_data_from_data_base() {

		echo $removeTime = date('Y-m-d G:i:s',  strtotime(date("2018-10-09 00:00:00")));
		
		
		$orig_date = new DateTime($removeTime);
		$orig_date = $orig_date->getTimestamp();
		$created_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);
		$db = $this->mongo_db->customQuery();

		///////////////////////////////////////////////////////////////

		echo $delectmarket_prices = $db->market_chart_dailybase->deleteMany(array('openTime_human_readible' => array('$gte' => $removeTime)));

		exit;

	} //delete_data_from_data_base
	
	 public function deleteTweetsTable() {
		 
		$db = $this->mongo_db->customQuery();
		$res = $db->sentiments_tweet->drop();
		var_dump($res);
		exit(); 
		$connetct = $this->mongo_db->delete('reddit_all_comments');
		echo "<pre>";   print_r($connetct); exit;
	}//deleteTweetsTable



}