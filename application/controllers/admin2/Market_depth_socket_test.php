<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Market_depth_socket_test extends CI_Controller {

	public function __construct() {

		parent::__construct();

		// Load Modal
		$this->load->model('admin/mod_sockets');
		$this->load->model('admin/mod_coins');
		$this->load->library('binance_api');
	}
	public $old_array = array();
	public $new_array = array();

	public function index() {

		$all_coins_arr = $this->mod_sockets->get_all_coins();

		for ($i = 0; $i < 1; $i++) {
			echo $coin_symbol = $all_coins_arr[$i]['symbol'];
			echo "---<br>";
			$coin_symbol = "NCASHBTC";
			$this->old_array[$coin_symbol] = array();
			$this->new_array[$coin_symbol] = array();
			$check_socket_track = $this->mod_sockets->check_socket_track('market_depth_history', $coin_symbol);
			if (true || $check_socket_track == 'no') {

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
								'status' => 1,
								'created_date' => $created_date,
							);
							if ($check_duplicate == 'no') {

								$this->insert_data($insert22);

							} else {
								$upd_data['status'] = 0;
								$upd_data['modified_date'] = $created_date;
								$this->update_data($upd_data, $price, 'bid');
								$this->insert_data($insert22);

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
								'status' => 1,
							);

							if ($check_duplicate == 'no') {

								$this->insert_data($insert33);

							} else {
								$update_data_2['status'] = 0;
								$update_data_2['modified_date'] = $created_date;
								$this->update_data($update_data_2, $price, 'ask');
								$this->insert_data($insert33);
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
								'status' => 1,
							);
							if ($check_duplicate == 'no') {
								//$this->insert_data($insert22);
							} else {
								$update_data_3['status'] = 0;
								$update_data_3['modified_date'] = $created_date;
								$this->update_data($update_data_3, $price, 'bid');
								$this->insert_data($insert22);
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
								'status' => 1,
							);
							if ($check_duplicate == 'no') {
								$this->insert_data($insert33);
							} else {
								$update_data_4['status'] = 0;
								$update_data_4['modified_date'] = $created_date;
								$this->update_data($update_data_4, $price, 'ask');
								$this->insert_data($insert33);
							}
						}

					}
					$this->old_array = $this->new_array;
					$this->mod_sockets->update_socket_track('market_depth_history', $symbol);

				});

			} else {
				echo "Socket is Running for " . $coin_symbol . "... </br>";
			}

		}
	}

	public function check_duplication($type, $price, $symbol) {
		$findArr = array('type' => $type, 'coin' => $symbol, 'price' => $price);
		$this->mongo_db->where($findArr);
		$response = $this->mongo_db->get('market_depth_history');
		$resp = iterator_to_array($response);
		$check_duplicate = 'no';
		if (count($resp) > 0) {
			$check_duplicate = 'yes';
		}

		echo $check_duplicate;

		return $check_duplicate;
	}

	public function insert_data($data) {
		//$this->mongo_db->insert('market_depth_history', $data);
	}

	public function update_data($data, $price, $type) {
		$this->mongo_db->where(array('price' => $price, 'type' => $type, 'status' => 1));
		$this->mongo_db->order_by(array('_id' => -1));
		$this->mongo_db->limit(1);
		$get_db = $this->mongo_db->get('market_depth_history');
		foreach ($get_db as $key => $value) {
			if (!empty($value)) {
				$get_id = $value['_id'];
			}
		}
		/*$this->mongo_db->where(array('_id' => $get_id));
			$this->mongo_db->set($data);
			$this->mongo_db->update('market_depth_history');
		*/
	}

	public function market_depth_data_view() {
		$res = $this->mongo_db->get('market_depth_history');

		echo "<pre>";
		print_r(iterator_to_array($res));
		exit;
	}

	public function deletesocket($id) {
		$this->mongo_db->where(array('_id' => $id));
		$this->mongo_db->delete('sockets_track');
		echo "1";
	}

}
