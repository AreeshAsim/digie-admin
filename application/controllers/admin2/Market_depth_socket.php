<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Market_depth_socket extends CI_Controller {

	public function __construct() {

		parent::__construct();

		// Load Modal
		$this->load->model('admin/mod_sockets');
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_dashboard');
		$this->load->library('binance_api');
	}
	public $old_array = array();
	public $new_array = array();

	public $old_array_test = array();
	public $new_array_test = array();

	public function index() {
		//Get All Coins
		exit;
		$all_coins_arr = $this->mod_sockets->get_all_coins();

		for ($i = 0; $i < count($all_coins_arr); $i++) {

			$coin_symbol = $all_coins_arr[$i]['symbol'];

			//Check socket Call
			$check_socket_track = $this->mod_sockets->check_socket_track('market_depth', $coin_symbol);

			if ($check_socket_track == 'no') {

				//////////////////////////////// Socket Call //////////////////////////////////
				$api = $this->binance_api->get_master_api();
				$api->depthCache([$coin_symbol], function ($api, $symbol, $depth) {

					$limit = 20000;
					$sorted = $api->sortDepth($symbol, $limit);

					$bids_arr = $sorted['bids'];
					$asks_arr = $sorted['asks'];

					$max_bid = max(array_keys($bids_arr));
					$min_bid = min(array_keys($bids_arr));
					$max_ask = max(array_keys($asks_arr));
					$min_ask = min(array_keys($asks_arr));

					$where1 = array('type' => 'bid', 'coin' => $symbol, 'price' => array('$gte' => (float) $max_bid));

					$db = $this->mongo_db->customQuery();
					$res1 = $db->market_depth->deleteMany($where1);

					$where2 = array('type' => 'ask', 'coin' => $symbol, 'price' => array('$lte' => (float) $min_ask));
					$db = $this->mongo_db->customQuery();
					$res2 = $db->market_depth->deleteMany($where2);
					//Add Bids
					if (count($bids_arr) > 0) {

						foreach ($bids_arr as $key => $value) {

							$price = (float) $key;
							$quantity = (float) $value;

							/////////////////// Check Duplication ////////////////////
							$findArr = array('type' => 'bid', 'coin' => $symbol, 'price' => $price);

							$this->mongo_db->where($findArr);
							$response = $this->mongo_db->get('market_depth');

							$check_duplicate = 'no';
							if (count($response) > 0) {
								$arrrNew = array();
								$arrr = array();
								foreach ($response as $key12 => $value12) {
									$monogoId = $value12['_id'];
									$check_duplicate = 'yes';
								}
							}
							/////////////////// End Check Duplication /////////////////

							$datetime = date('Y-m-d G:i:s');
							$orig_date = new DateTime($datetime);
							$orig_date = $orig_date->getTimestamp();
							$created_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

							$insert22 = array(
								'price' => $price,
								'quantity' => $quantity,
								'type' => 'bid',
								'coin' => $symbol,
								'created_date' => $created_date,
							);

							if ($check_duplicate == 'no') {

								$this->mongo_db->insert('market_depth', $insert22);

							} else {

								$this->mongo_db->where(array('_id' => $monogoId));
								$this->mongo_db->set($insert22);

								//Update data in mongoTable
								$this->mongo_db->update('market_depth');

							} //end if check duplicate

						} /*End of For Each Loop*/

					} /*End of If Condition*/

					//Add Asks
					if (count($asks_arr) > 0) {

						foreach ($asks_arr as $key2 => $value2) {

							$price = (float) $key2;
							$quantity = (float) $value2;

							/////////////////// Check Duplication //////////////////////
							$findArr = array('type' => 'ask', 'coin' => $symbol, 'price' => $price);

							$this->mongo_db->where($findArr);
							$response = $this->mongo_db->get('market_depth');

							$check_duplicate2 = 'no';
							if (count($response) > 0) {
								$arrrNew = array();
								$arrr = array();
								foreach ($response as $key121 => $value121) {
									//$monogoId = $value->_id;
									$monogoId = $value121['_id'];
									$check_duplicate2 = 'yes';
								}
							}
							/////////////////// End Check Duplication ////////////////////

							$datetime = date('Y-m-d G:i:s');
							$orig_date = new DateTime($datetime);
							$orig_date = $orig_date->getTimestamp();
							$created_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

							$insert33 = array(
								'price' => $price,
								'quantity' => $quantity,
								'type' => 'ask',
								'coin' => $symbol,
								'created_date' => $created_date,
							);

							if ($check_duplicate2 == 'no') {

								$this->mongo_db->insert('market_depth', $insert33);

							} else {

								$this->mongo_db->where(array('_id' => $monogoId));
								$this->mongo_db->set($insert33);

								//Update data in mongoTable
								$this->mongo_db->update('market_depth');

							} //end if check duplicate

						} /*End of For Each Loop*/

					} /*End of If Condition*/

					//Update Socket Track
					$this->mod_sockets->update_socket_track('market_depth', $symbol);

				});
				///////////////////////////// Socket Call /////////////////////////////////

			} else {

				echo "Socket is Running for " . $coin_symbol . "... </br>";
			}

		} //end for
	}
	public function index_old() {

		$all_coins_arr = $this->mod_sockets->get_all_coins();

		for ($i = 0; $i < count($all_coins_arr); $i++) {
			$coin_symbol = $all_coins_arr[$i]['symbol'];
			$this->old_array[$coin_symbol] = array();
			$this->new_array[$coin_symbol] = array();
			$check_socket_track = $this->mod_sockets->check_socket_track('market_depth', $coin_symbol);
			if ($check_socket_track == 'no') {

				//////////////////////////////// Socket Call //////////////////////////////////
				$api = $this->binance_api->get_master_api();
				$api->depthCache([$coin_symbol], function ($api, $symbol, $depth) {

					$limit = 2000;
					$sorted = $api->sortDepth($symbol, $limit);

					$bids_arr = $sorted['bids'];
					$asks_arr = $sorted['asks'];

					$this->new_array[$symbol]['bids'] = $bids_arr;
					$this->new_array[$symbol]['asks'] = $asks_arr;

					$max_bid = max(array_keys($this->new_array[$symbol]['bids']));
					$min_bid = min(array_keys($this->new_array[$symbol]['bids']));
					$max_ask = max(array_keys($this->new_array[$symbol]['asks']));
					$min_ask = min(array_keys($this->new_array[$symbol]['asks']));

					$where1 = array('type' => 'bid', 'coin' => $symbol, 'price' => array('$gte' => (float) $max_bid));
					$this->mongo_db->where($where1);
					$this->mongo_db->delete_all('market_depth');
					$db = $this->mongo_db->customQuery();
					$res1 = $db->market_depth->deleteMany($where1);

					$where2 = array('type' => 'ask', 'coin' => $symbol, 'price' => array('$lte' => (float) $min_ask));
					$this->mongo_db->where($where2);
					$this->mongo_db->delete_all('market_depth');

					$db = $this->mongo_db->customQuery();
					$res2 = $db->market_depth->deleteMany($where2);

					/*$filename = $symbol . ".txt";
						$new_line = '\n';
						$fh = fopen('testing/' . $filename, "a");
						fwrite($fh, "======================================================================");
						fwrite($fh, $new_line);
						fwrite($fh, print_r($bids_arr, true));
						fwrite($fh, $new_line);
						fwrite($fh, "======================================================================");
						fwrite($fh, $new_line);
						fwrite($fh, print_r($asks_arr, true));
						fwrite($fh, $new_line);
						fwrite($fh, "======================================================================");
						fwrite($fh, $new_line);
						$text = "Max Bid " . $max_bid . " Min Bid " . $min_bid . " Max Ask " . $max_ask . " Min Ask " . $min_ask;
						fwrite($fh, $text);
						fwrite($fh, $new_line);
						fwrite($fh, "======================================================================");
						fwrite($fh, $new_line);
						fwrite($fh, print_r($res1, true));
						fwrite($fh, $new_line);
						fwrite($fh, "======================================================================");
						fwrite($fh, $new_line);
						fwrite($fh, print_r($res2, true));
						fclose($fh);
					*/

					if (empty($this->old_array[$symbol])) {

						foreach ($this->new_array[$symbol]['bids'] as $key => $value) {

							$price = (float) $key;
							$quantity = (float) $value;

							$check_duplicate = $this->check_duplication('bid', $price, $symbol);
							$datetime = date('Y-m-d G:i:s');
							$orig_date = new DateTime($datetime);
							$orig_date = $orig_date->getTimestamp();
							$created_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

							$insert22 = array(
								'price' => $price,
								'quantity' => $quantity,
								'type' => 'bid',
								'coin' => $symbol,
								'created_date' => $created_date,
							);
							if ($check_duplicate == 'no') {

								$this->insert_data($insert22);

							} else {
								$type = 'bid';
								$findArr = array('type' => $type, 'coin' => $symbol, 'price' => $price);
								$this->update_data($insert22, $findArr);

							}

						}

						foreach ($this->new_array[$symbol]['asks'] as $key => $value) {

							$price = (float) $key;
							$quantity = (float) $value;

							$check_duplicate = $this->check_duplication('ask', $price, $symbol);

							$datetime = date('Y-m-d G:i:s');
							$orig_date = new DateTime($datetime);
							$orig_date = $orig_date->getTimestamp();
							$created_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

							$insert33 = array(
								'price' => $price,
								'quantity' => $quantity,
								'type' => 'ask',
								'coin' => $symbol,
								'created_date' => $created_date,
							);

							if ($check_duplicate == 'no') {

								$this->insert_data($insert33);

							} else {

								$type = 'ask';
								$findArr = array('type' => $type, 'coin' => $symbol, 'price' => $price);
								$this->update_data($insert33, $findArr);
							} //end if check duplicate
						}

					} else {
						$temp_bids = $this->old_array[$symbol]['bids'];
						$temp_asks = $this->old_array[$symbol]['asks'];

						$array_bid_change = array_diff($this->new_array[$symbol]['bids'], $temp_bids);
						$array_ask_change = array_diff($this->new_array[$symbol]['asks'], $temp_asks);

						foreach ($array_bid_change as $key => $value) {
							$price = (float) $key;
							$quantity = (float) $value;
							$check_duplicate = $this->check_duplication('bid', $price, $symbol);
							$datetime = date('Y-m-d G:i:s');
							$orig_date = new DateTime($datetime);
							$orig_date = $orig_date->getTimestamp();
							$created_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

							$insert22 = array(
								'price' => $price,
								'quantity' => $quantity,
								'type' => 'bid',
								'coin' => $symbol,
								'created_date' => $created_date,
							);
							if ($check_duplicate == 'no') {
								$this->insert_data($insert22);
							} else {
								$type = 'bid';
								$findArr = array('type' => $type, 'coin' => $symbol, 'price' => $price);
								$this->update_data($insert22, $findArr);
							}
						}
						foreach ($array_ask_change as $key => $value) {

							$price = (float) $key;
							$quantity = (float) $value;
							$check_duplicate = $this->check_duplication('ask', $price, $symbol);
							$datetime = date('Y-m-d G:i:s');
							$orig_date = new DateTime($datetime);
							$orig_date = $orig_date->getTimestamp();
							$created_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

							$insert33 = array(
								'price' => $price,
								'quantity' => $quantity,
								'type' => 'ask',
								'coin' => $symbol,
								'created_date' => $created_date,
							);
							if ($check_duplicate == 'no') {
								$this->insert_data($insert33);
							} else {
								$type = 'ask';
								$findArr = array('type' => $type, 'coin' => $symbol, 'price' => $price);
								$this->update_data($insert33, $findArr);
							}
						}

						$bid_diff = array_diff($temp_bids, $this->new_array[$symbol]['bids']);
						$ask_diff = array_diff($temp_asks, $this->new_array[$symbol]['asks']);

						foreach ($bid_diff as $key => $value) {
							if ($key > $min_bid) {
								$type = 'bid';
								$findArr = array('type' => $type, 'coin' => $symbol, 'price' => $key);
								$this->deleteIndex($findArr);
							}

						}

						foreach ($ask_diff as $key => $value) {
							if ($key < $max_ask) {
								$type = 'ask';
								$findArr = array('type' => $type, 'coin' => $symbol, 'price' => $key);
								$this->deleteIndex($findArr);
							}

						}

					}
					$this->old_array = $this->new_array;
					$this->mod_sockets->update_socket_track('market_depth', $symbol);

				});

			} else {
				echo "Socket is Running for " . $coin_symbol . "... </br>";
			}

		}
	}

	public function test($symbol) {
		$this->mongo_db->where('coin', $symbol);
		$this->mongo_db->where('type', 'bid');
		$this->mongo_db->order_by(array('created_date' => -1));
		$res = $this->mongo_db->get('market_depth');
		$res = iterator_to_array($res);
		foreach ($res as $key) {
			$price = (string) $key['price'];
			$retArr[num($price)] = $key['quantity'];
		}
		echo '<pre>';
		print_r($retArr);
		exit();

		$res = $this->mongo_db->get('market_history_data_from_api');
		$res = iterator_to_array($res);
		echo '<pre>';
		print_r($res);
		exit();

		$db = $this->mongo_db->customQuery();

		echo $db->market_history_data_from_api->count();
		exit();

		// exit($res );

		$this->mongo_db->limit(100);
		$get_data = $this->mongo_db->get('market_history_data_counter_for_api_call');
		$get_data = iterator_to_array($get_data);
		echo '<pre>';
		print_r($get_data);
	}

	public function new_test($coin_symbol) {
		/*$coin_symbol = "NCASHBTC";*/
		$api = $this->binance_api->get_master_api();
		$api->depthCache([$coin_symbol], function ($api, $symbol, $depth) {

			$limit = 20000;
			$sorted = $api->sortDepth($symbol, $limit);

			$bids_arr = $sorted['bids'];
			$asks_arr = $sorted['asks'];

			$filename = $symbol . ".txt";
			$new_line = '\n';
			$fh = fopen('testing/' . $filename, "a");
			fwrite($fh, "======================================================================");
			fwrite($fh, $new_line);
			fwrite($fh, print_r($bids_arr, true));
			fwrite($fh, $new_line);
			fwrite($fh, "======================================================================");
			fwrite($fh, $new_line);
			fwrite($fh, print_r($asks_arr, true));
			fwrite($fh, $new_line);
			fwrite($fh, "======================================================================");
			fwrite($fh, $new_line);
			echo "<pre>";
			print_r($bids_arr);
			print_r($asks_arr);
			exit;
		});
	}

	public function test_test() {
		$array1 = array(
			'0.00000191' => 243683.00000000,
			'0.00000190' => 2254872.00000000,
			'0.00000189' => 468924.00000000,
			'0.00000188' => 1945864.00000000,
			'0.00000187' => 1219577.00000000,
			'0.00000186' => 529386.00000000,
			'0.00000185' => 1122985.00000000,
			'0.00000184' => 898828.00000000,
			'0.00000183' => 826730.00000000,
			'0.00000182' => 631261.00000000,
			'0.00000181' => 1322378.00000000,
			'0.00000180' => 895304.00000000,
			'0.00000179' => 251310.00000000,
			'0.00000178' => 368973.00000000,
			'0.00000177' => 213556.00000000,
			'0.00000176' => 69960.00000000,
			'0.00000175' => 408271.00000000,
			'0.00000174' => 3425539.00000000,
			'0.00000173' => 11900.00000000,
			'0.00000172' => 1324599.00000000,
			'0.00000171' => 36598.00000000,
			'0.00000170' => 6130027.00000000,
		);

		$array2 = array(
			'0.00000191' => 243683.00000000,
			'0.00000190' => 2261649.00000000,
			'0.00000189' => 409066.00000000,
			'0.00000188' => 2037537.00000000,
			'0.00000187' => 1222209.00000000,
			'0.00000186' => 525934.00000000,
			'0.00000185' => 1122985.00000000,
			'0.00000184' => 898828.00000000,
			'0.00000183' => 826730.00000000,
			'0.00000182' => 635913.00000000,
			'0.00000181' => 1322378.00000000,
			'0.00000180' => 895304.00000000,
			'0.00000179' => 251310.00000000,
			'0.00000178' => 368973.00000000,
			'0.00000177' => 213556.00000000,
			'0.00000176' => 69960.00000000,
			'0.00000175' => 408271.00000000,
			'0.00000174' => 3425539.00000000,
			'0.00000173' => 11900.00000000,
			'0.00000172' => 1324599.00000000,
			'0.00000171' => 36598.00000000,
			'0.00000170' => 6130027.00000000,
			'0.00000169' => 123456,
		);

		$array_bid_change = array_diff($array2, $array1);
		echo max(array_keys($array2));
		echo "<br>";
		echo min(array_keys($array2));

		exit;
	}

	public function check_duplication($type, $price, $symbol) {
		$findArr = array('type' => $type, 'coin' => $symbol, 'price' => $price);
		$this->mongo_db->where($findArr);
		$response = $this->mongo_db->get('market_depth');
		$resp = iterator_to_array($response);
		$check_duplicate = 'no';
		if (count($resp) > 0) {
			$check_duplicate = 'yes';
		}

		return $check_duplicate;
	}

	public function insert_data($data) {
		$this->mongo_db->insert('market_depth', $data);
	}

	public function update_data($data, $find_arr) {
		$this->mongo_db->where($find_arr);
		$this->mongo_db->set($data);
		$this->mongo_db->update('market_depth');
	}

	public function deleteIndex($find_arr) {
		$db = $this->mongo_db->customQuery();
		$db->market_depth->deleteOne($find_arr);
		// $this->mongo_db->where($find_arr);
		// $this->mongo_db->delete('market_depth');
	}

	public function market_depth_data_view() {
		$res = $this->mongo_db->get('market_depth_test');

		echo "<pre>";
		print_r(iterator_to_array($res));
		exit;
	}

	public function deletesocket($id) {
		$this->mongo_db->where(array('_id' => $id));
		$this->mongo_db->delete('sockets_track');
		echo "1";
	}

	// public function delete_data() {
	// 	//Auto Loader
	// 	$x = 1;
	// 	while ($x <= 30) {

	// 		$x++;
	// 		sleep(2);
	// 		$this->delete_unwanted_depth();
	// 	}
	// }
	public function delete_unwanted_depth() {
		echo "<pre>";
		exit;
		$all_coins_arr = $this->mod_sockets->get_all_coins();

		foreach ($all_coins_arr as $key => $value) {
			$coin_symbol = $value['symbol'];

			echo $market_value = $this->mod_dashboard->get_market_value($coin_symbol);

			//Delete Data Logic

			$search_array['coin'] = $coin_symbol;
			$search_array['type'] = 'bid';
			$search_array['price'] = array('$gt' => (float) $market_value);
			$this->mongo_db->where($search_array);
			$data = $this->mongo_db->delete_all('market_depth');

			/*$this->mongo_db->where($search_array);
			$data1 = $this->mongo_db->delete_all('chart4');*/
			///////////////////////////////////////////////////////////////

			$search_array['coin'] = $coin_symbol;
			$search_array['type'] = 'ask';
			$search_array['price'] = array('$lt' => (float) $market_value);

			$this->mongo_db->where($search_array);
			$data2 = $this->mongo_db->delete_all('market_depth');

			/*$this->mongo_db->where($search_array);
			$data3 = $this->mongo_db->delete_all('chart4');*/
			///////////////////////////////////////////////////////////////
		}
		exit;
	}

}
