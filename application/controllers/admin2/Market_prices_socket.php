<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Market_prices_socket extends CI_Controller {

	public function __construct() {

		parent::__construct();

		// Load Modal
		$this->load->model('admin/mod_sockets');
		$this->load->library('binance_api');

	}

	public function index() {
		//Auto Loader
		$x = 1;
		while ($x <= 50) {
			$x++;
			sleep(1);
			$this->run_cron();
		}

	}

	public function run_cron() {
		$api = $this->binance_api->get_master_api();

		//Get latest price of a all coinsymbol listed on binance
		$ticker = $api->prices();

		//Get All Coins
		$all_coins_arr = $this->mod_sockets->get_all_coins();

		for ($i = 0; $i < count($all_coins_arr); $i++) {

			$coin_symbol  = $all_coins_arr[$i]['symbol'];
			$market_value = $ticker[$coin_symbol];

			$datetime     = date('Y-m-d G:i:s');
			$orig_date    = new DateTime($datetime);
			$orig_date    = $orig_date->getTimestamp();
			$created_date = new MongoDB\BSON\UTCDateTime($orig_date*1000);

			if ($market_value != "" && $market_value != "0.00000000") {
				///!empty check
				$insert = array(
					'price'        => (float) $market_value,
					'coin'         => $coin_symbol,
					'created_date' => $created_date,
				);

				$this->mongo_db->insert('market_prices', $insert);

				//$sec = (strtotime($datetime) * 100);
				$insert22 = array(
					'market_value' => (float) $market_value,
					'coin'         => $coin_symbol,
					'time'         => $created_date,
				);
				$this->mongo_db->insert('market_price_history', $insert22);
			}//End if Market Value not empty
		}

		return true;

	}

	public function test($symbol) {
		$api    = $this->binance_api->get_master_api();
		$ticker = $api->prices();

		echo "<pre>";
		print_r($ticker[$symbol]);
		exit;
	}

}
