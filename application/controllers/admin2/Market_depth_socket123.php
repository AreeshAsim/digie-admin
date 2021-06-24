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

	public function index() {

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

					if (empty($this->old_array[$symbol])) {

						foreach ($this->new_array[$symbol]['bids'] as $key => $value) {

							$price = (float) $key;
							$quantity = $value;

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
								$this->update_data($insert22, $price);

							}

						}

						foreach ($this->new_array[$symbol]['asks'] as $key => $value) {

							$price = (float) $key;
							$quantity = $value;

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

								$this->update_data($insert33, $price);
							} //end if check duplicate
						}
					} else {
						$temp_bids = $this->old_array[$symbol]['bids'];
						$temp_asks = $this->old_array[$symbol]['asks'];

						$array_bid_change = array_diff($this->new_array[$symbol]['bids'], $temp_bids);
						$array_ask_change = array_diff($this->new_array[$symbol]['asks'], $temp_asks);

						foreach ($array_bid_change as $key => $value) {
							$price = (float) $key;
							$quantity = $value;
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
								$this->update_data($insert22, $price);
							}
						}
						foreach ($array_ask_change as $key => $value) {

							$price = (float) $key;
							$quantity = $value;
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
								$this->update_data($insert33, $price);
							}
						}

						$temp_bids_old = $this->old_array[$symbol]['bids'];
						$temp_asks_old = $this->old_array[$symbol]['asks'];

						$array_bid_change_old = array_diff($temp_bids_old, $this->new_array[$symbol]['bids']);
						$array_ask_change_old = array_diff($temp_asks_old, $this->new_array[$symbol]['asks']);

						$max_bid = max(array_keys($this->new_array[$symbol]['bids']));
						/*$max_ask = max(array_keys($this->new_array[$symbol]['asks']));

						$min_bid = min(array_keys($this->new_array[$symbol]['bids']));*/
						$min_ask = min(array_keys($this->new_array[$symbol]['asks']));

						foreach ($array_bid_change_old as $key => $value) {
							if ($key < $max_bid) {
								$price = (float) $key;
								$search_Arr_bid['type'] = 'bid';
								$search_Arr_bid['coin'] = $symbol;
								$search_Arr_bid['price'] = $price;

								$this->mongo_db->where($search_Arr_bid);
								$this->mongo_db->delete_all('market_depth');

								$this->mongo_db->where($search_Arr_bid);
								$this->mongo_db->delete_all('chart4');
							}
						}

						foreach ($array_ask_change_old as $key => $value) {
							if ($key > $min_ask) {
								$price = (float) $key;
								$search_Arr_ask['type'] = 'ask';
								$search_Arr_ask['coin'] = $symbol;
								$search_Arr_ask['price'] = $price;

								$this->mongo_db->where($search_Arr_ask);
								$this->mongo_db->delete_all('market_depth');

								$this->mongo_db->where($search_Arr_ask);
								$this->mongo_db->delete_all('chart4');

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

	public function update_data($data, $price) {
		$this->mongo_db->where(array('price' => $price));
		$this->mongo_db->set($data);
		$this->mongo_db->update('market_depth');
	}

	public function test() {

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

	public function new_test() {
		$coin_symbol = "ZECBTC";
		$api = $this->binance_api->get_master_api();
		$api->depthCache([$coin_symbol], function ($api, $symbol, $depth) {

			$limit = 20000;
			$sorted = $api->sortDepth($symbol, $limit);

			$bids_arr = $sorted['bids'];
			$asks_arr = $sorted['asks'];

			echo "<pre>";
			print_r($bids_arr);
			print_r($asks_arr);
			exit;
		});
	}

	public function delete_data() {
		//Auto Loader
		$x = 1;
		while ($x <= 30) {

			$x++;
			sleep(2);
			$this->delete_unwanted_depth();
		}
	}
	public function delete_unwanted_depth() {
		$all_coins_arr = $this->mod_sockets->get_all_coins();

		foreach ($all_coins_arr as $key => $value) {
			$coin_symbol = $value['symbol'];

			$market_value = $this->mod_dashboard->get_market_value($coin_symbol);

			//Delete Data Logic
			//$findArr = array('type' => 'bid', 'coin' => $symbol, 'price' => $price);

			$search_array['coin'] = $coin_symbol;
			$search_array['type'] = 'bid';
			//$search_array['price'] = array('$lt' => $market_value);
			$this->mongo_db->where($search_array);
			$data = $this->mongo_db->delete_all('market_depth');

			/*$this->mongo_db->where($search_array);
			$data1 = $this->mongo_db->delete_all('chart4');*/
			///////////////////////////////////////////////////////////////

			$search_array['coin'] = $coin_symbol;
			$search_array['type'] = 'ask';
			//$search_array['price'] = array('$gte' => $market_value);

			$this->mongo_db->where($search_array);
			$data3 = $this->mongo_db->delete_all('market_depth');

			/*$this->mongo_db->where($search_array);
			$data4 = $this->mongo_db->delete_all('chart4');*/
			///////////////////////////////////////////////////////////////

		}
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
			'0.00000195' => 243683.00000000,
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

		$ar1 = array_diff($array2, $array1);
		$ar2 = array_diff($array1, $array2);
		echo "<pre>";
		print_r($ar1);
		print_r($ar2);
		exit;
	}
}
