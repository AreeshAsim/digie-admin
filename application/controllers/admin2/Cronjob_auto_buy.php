<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob_auto_buy extends CI_Controller {

	public function __construct() {

		parent::__construct();

		// Load Modal
		$this->load->model('admin/mod_dashboard');

	}



	public function run_cron() {
		echo 'start Date'.date('Y-m-d H:i:s').'<br>';
		//Get Orders
		$this->mongo_db->where(array('status' => 'new', 'trigger_type' => 'no'));
		$this->mongo_db->sort(array('_id' => -1));
		$responseArr = $this->mongo_db->get('buy_orders');
		foreach ($responseArr as $valueArr) {

			if (!empty($valueArr)) {

				$id = $valueArr['_id'];
				$symbol = $valueArr['symbol'];
				$quantity = $valueArr['quantity'];
				$trail_check = $valueArr['trail_check'];
				$trail_interval = num($valueArr['trail_interval']);
				$buy_trail_price = num($valueArr['buy_trail_price']);
				$buy_price = num($valueArr['price']);

				$order_type = $valueArr['order_type'];
				$status = $valueArr['status'];
				$user_id = $valueArr['admin_id'];
				$application_mode = $valueArr['application_mode'];

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($symbol);

				if ($market_value != "" && $market_value > 0) {

					////////////////////////////////////////////////////////////////////////
					if ($trail_check == 'yes') {

						////////////////////// Trial Section /////////////////////
						if ($market_value < num($buy_trail_price - $trail_interval)) {

							$new_trial_price = num($market_value + $trail_interval);

							//Update New Trial Price
							$this->mod_dashboard->update_trail_buy_price($id, $buy_trail_price, $new_trial_price, $user_id);

						}

						if ($market_value > $buy_trail_price) {

							if ($market_value < $buy_price) {

								if ($status == 'new') {

									if ($order_type == 'market_order') {

										if ($application_mode == 'live') {

											//Auto Buy Binance Market Order Live
											$this->mod_dashboard->binance_buy_auto_market_order_live($id, $quantity, $market_value, $symbol, $user_id);

										} else {

											//Auto Buy Binance Market Order Test
											$this->mod_dashboard->binance_buy_auto_market_order_test($id, $quantity, $market_value, $symbol, $user_id);
										}

									} else {

										if ($application_mode == 'live') {

											//Auto Buy Binance Limit Order Live
											$this->mod_dashboard->binance_buy_auto_limit_order_live($id, $quantity, $market_value, $symbol, $user_id);

										} else {

											//Auto Buy Binance Limit Order Test
											$this->mod_dashboard->binance_buy_auto_limit_order_test($id, $quantity, $market_value, $symbol, $user_id);
										}
									}

								} //end if status is new

							}

						}
						////////////////// End Trial Section /////////////////////

					} else {

						//Here is goto Auto Sell
						if ($market_value <= $buy_price) {

							if ($status == 'new') {

								if ($order_type == 'market_order') {

									if ($application_mode == 'live') {

										//Auto Buy Binance Market Order Live
										$this->mod_dashboard->binance_buy_auto_market_order_live($id, $quantity, $market_value, $symbol, $user_id);

									} else {

										//Auto Buy Binance Market Order Test

										$this->mod_dashboard->binance_buy_auto_market_order_test($id, $quantity, $market_value, $symbol, $user_id);

									}

								} else {

									if ($application_mode == 'live') {

										//Auto Buy Binance Limit Order Live
										$this->mod_dashboard->binance_buy_auto_limit_order_live($id, $quantity, $market_value, $symbol, $user_id);

									} else {

										//Auto Buy Binance Limit Order Test
										$this->mod_dashboard->binance_buy_auto_limit_order_test($id, $quantity, $market_value, $symbol, $user_id);
									}
								}

							} //end if status is new
						}

					}
					////////////////////////////////////////////////////////////////////////

				} //End if Market Value not empty

			} //end if

		} //end for
		echo "End Date: ".date("Y-m-d H:i:s");
	} //end index

}
