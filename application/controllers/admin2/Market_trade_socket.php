<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Market_trade_socket extends CI_Controller {

	public function __construct() {

		parent::__construct();

		// Load Modal
		$this->load->model('admin/mod_sockets');
		$this->load->model('admin/mod_realtime_candle_socket');
		$this->load->model('admin/mod_box_trigger_3');
		$this->load->model('admin/mod_rg_15_trigger');

		$this->load->library('binance_api');

	}

	public $price = array();
	public $status = 'equal';
	public function index() {
		//Get All Coins
		$all_coins_arr = $this->mod_sockets->get_all_coins();
		exit;
		for ($i = 0; $i < count($all_coins_arr); $i++) {
			$coin_symbol = $all_coins_arr[$i]['symbol'];
			$this->price[$coin_symbol] = 0;
			$this->status = 'equal';
			//Check socket Call
			$check_socket_track = $this->mod_sockets->check_socket_track('market_trades', $coin_symbol);
			if ($check_socket_track == 'no') {
				//Update Socket Counter
				$GLOBALS['counter'] = $this->mod_sockets->update_socket_counter_track('market_trades', $coin_symbol);
				$api = $this->binance_api->get_master_api();
				$counter = $GLOBALS['counter'];

				$api->trades([$coin_symbol], $counter, function ($api, $symbol, $trades) {
					$orig_date = $trades['timestamp'];
					$created_date = new MongoDB\BSON\UTCDateTime($orig_date);

					//ask
					if ($trades['price'] > $this->price[$coin_symbol]) {
						$this->status = 'greater';
						$this->price[$coin_symbol] = $trades['price'];
					} elseif ($trades['price'] < $this->price) {
						$this->status = 'less';
						$this->price[$coin_symbol] = $trades['price'];
					} else {
						$this->status = 'equal';
						$this->price[$coin_symbol] = $trades['price'];
					}
					$insert22 = array(
						'price' => (float) $trades['price'],
						'quantity' => (float) $trades['quantity'],
						'created_date' => $created_date,
						'maker' => $trades['maker'],
						'coin' => $symbol,
						'counter' => $trades['counter'],
						'status' => $this->status,
					);
					$current_counter = $this->mod_sockets->get_current_socket_counter('market_trades', $symbol);

					if ($insert22['counter'] == $current_counter) {
						$this->mongo_db->insert('market_trades', $insert22);
						$this->mongo_db->insert('market_trade_history', $insert22);
						$this->mod_sockets->update_socket_track('market_trades', $symbol);
					}

//                    $insert22['counter_current'] = $current_counter;
					//                    $this->db->insert('market_trades_test',$insert22);
					if ($insert22['counter'] != $current_counter) {

						$trades['loop_instant']->stop();
					}

					$this->old_value = $trades['quantity'];
					$this->price_val = $trades['price'];
				});

			} else {
				echo "Socket is Running for " . $coin_symbol . "... </br>";
			}
		} //end for
	}

	/*** Savem marekt hour trade hitory***/

	public function market_trade_hourly_history() {

		$date = date('Y-m-d H:00:00');
		$this->mod_sockets->market_trade_hourly_history();

		$this->mod_realtime_candle_socket->save_candle_stick_by_cron_job();


		$order_mode = 'live';
		$this->mod_box_trigger_3->create_box_trigger_3_setting($date, $order_mode);



		$this->mod_box_trigger_3->make_orders_ready_for_box_trigger_3();

		$buy_Message = $this->mod_box_trigger_3->create_new_orders_by_Box_Trigger_3_live($date);

		//$buy_Message = $this->mod_rg_15_trigger->create_new_orders_by_Trigger_rg_15_live($date);

		$this->mongo_db->where(array('triggers_type' => 'box_trigger_3', 'order_mode' => 'live'));
		$response_obj = $this->mongo_db->get('trigger_global_setting');
		$response_arr = iterator_to_array($response_obj);
		$response = array();
		if (count($response_arr) > 0) {
			$aggressive_stop_rule = $response_arr[0]['aggressive_stop_rule'];
			if ($aggressive_stop_rule == 'stop_loss_rule_2') {
				$this->mod_box_trigger_3->aggrisive_define_percentage_followup($date, $type = 'live');
			}

		} //End of Trigger Setting

		echo 'its running greate';
		echo date('y-m-d h:i:s');
		echo '<br>';
	} //End of market_trade_hourly_history

	public function testdata($coin_symbol) {
		$counter = $this->mod_sockets->get_current_socket_counter('market_trades', $symbol);
		$api = $this->binance_api->get_master_api();
		
		$api->trades([$coin_symbol], $counter, function ($api, $symbol, $trades) {
			$orig_date = $trades['timestamp'];
			$created_date = new MongoDB\BSON\UTCDateTime($orig_date);

			echo "<pre>";
			print_r($trades);
			exit;
		});
	}

} //End of Controller
