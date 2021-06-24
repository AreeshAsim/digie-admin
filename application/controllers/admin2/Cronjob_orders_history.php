<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob_orders_history extends CI_Controller {

	public function __construct() {

		parent::__construct();

		// Load Modal
		$this->load->model('admin/mod_dashboard');

	}



	public function index() {

		/////////////////////////////////////////////////////////////////////////
		//////////////////////////// Get Sell Orders ////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		$this->mongo_db->where(array('status' => 'submitted'));
		$this->mongo_db->sort(array('_id' => 'desc'));
		$responseArr = $this->mongo_db->get('orders');

		foreach ($responseArr as $valueArr) {

			$upd_data = array();
			if (!empty($valueArr)) {

				$id = $valueArr['_id'];
				$binance_order_id = $valueArr['binance_order_id'];
				$symbol = $valueArr['symbol'];
				$user_id = $valueArr['admin_id'];
				$order_type = $valueArr['order_type'];
				$buy_order_check = $valueArr['buy_order_check'];
				$buy_order_id = $valueArr['buy_order_id'];
				$application_mode = $valueArr['application_mode'];

				//Check user Settings
				

				$is_user_api_credential_exist = is_user_api_credential_exist($user_id);

				if ($application_mode == 'live' && $is_user_api_credential_exist) {
					$order_status = $this->binance_api->order_status($symbol, $binance_order_id, $user_id);

					$status = $order_status['status'];
					$type = $order_status['type'];
					$market_price = $order_status['price'];

					$order_price = $market_price;

					//Check Market History
					$orders_history = $this->binance_api->get_all_orders_history($symbol, $user_id);
					for ($i = 0; $i < count($orders_history); $i++) {

						if ($orders_history[$i]['orderId'] == $binance_order_id) {
							$market_price = $orders_history[$i]['price'];
							$commission = $orders_history[$i]['commission'];
							$commissionAsset = $orders_history[$i]['commissionAsset'];
						}
					}

				} else {

					$status = 'FILLED';
					$market_price = $valueArr['market_value'];

					//Check Market History
					$commission_value = $valueArr['quantity'] * (0.001);
					$commission = $commission_value * $valueArr['market_value'];
					$commissionAsset = 'BTC';

				}

				////////////////////////////// Update Order Record ////////////////////////
				if ($status == 'FILLED') {

					$upd_data['status'] = $status;
					$upd_data['market_value'] = $market_price;

					$this->mongo_db->where(array('_id' => $id));
					$this->mongo_db->set($upd_data);
					$this->mongo_db->update('orders');

					////////////////////// Set Notification //////////////////
					$message = "Sell " . ucfirst($type) . " Order is <b>FILLED</b> at price " . $market_price;
					$this->mod_dashboard->add_notification($id, 'sell', $message, $user_id);
					//////////////////////////////////////////////////////////

					//////////////////////////////////////////////////////////////////////////////////////////////
					////////////////////////////// Order History Log /////////////////////////////////////////////
					$log_msg = "Sell " . ucfirst($type) . " Order is <b>FILLED</b> at price " . $market_price;
					$this->mod_dashboard->insert_order_history_log($buy_order_id, $log_msg, 'sell_filled', $user_id);
					////////////////////////////// End Order History Log /////////////////////////////////////////
					//////////////////////////////////////////////////////////////////////////////////////////////

					//////////////////////////////////////////////////////////////////////////////////////////////
					////////////////////////////// Order History Log /////////////////////////////////////////////
					$log_msg = "Broker Fee <b>" . $commission . " " . $commissionAsset . "</b> has token on this Trade";
					$this->mod_dashboard->insert_order_history_log($buy_order_id, $log_msg, 'sell_commision', $user_id);
					////////////////////////////// End Order History Log /////////////////////////////////////////
					//////////////////////////////////////////////////////////////////////////////////////////////

				}

				if ($status == 'FILLED' && $buy_order_id != '') {

					//Update Buy Order
					$upd_data22 = array(
						'is_sell_order' => 'sold',
						'market_sold_price' => $market_price,
					);

					$this->mongo_db->where(array('_id' => $buy_order_id));
					$this->mongo_db->set($upd_data22);

					//Update data in mongoTable
					$this->mongo_db->update('buy_orders');
				}
				/////////////////////////////// End Update Order Record //////////////////

			} //end if

		}
		/////////////////////////////////////////////////////////////////////////
		//////////////////////////// End Sell Orders ////////////////////////////
		/////////////////////////////////////////////////////////////////////////

		/////////////////////////////////////////////////////////////////////////
		//////////////////////////// Get Buy Orders ////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		$this->mongo_db->where(array('status' => 'submitted'));
		$this->mongo_db->sort(array('_id' => 'desc'));
		$responseArr222 = $this->mongo_db->get('buy_orders');

		foreach ($responseArr222 as $valueArr) {

			$upd_data = array();
			if (!empty($valueArr)) {

				$id = $valueArr['_id'];
				$binance_order_id = $valueArr['binance_order_id'];
				$symbol = $valueArr['symbol'];
				$user_id = $valueArr['admin_id'];
				$order_type = $valueArr['order_type'];
				$application_mode = $valueArr['application_mode'];
				$sell_order_id =  $valueArr['sell_order_id'];

				$quantity = $valueArr['quantity'];

				$trigger_type = $valueArr['trigger_type'];

				//Check user Settings
				

				$is_user_api_credential_exist = is_user_api_credential_exist($user_id);

				if ($application_mode == 'live' && $is_user_api_credential_exist) {

					$order_status = $this->binance_api->order_status($symbol, $binance_order_id, $user_id);

					$status = $order_status['status'];
					$type = $order_status['type'];
					$market_price = $order_status['price'];

					$order_price = $market_price;

					//Check Market History
					$orders_history = $this->binance_api->get_all_orders_history($symbol, $user_id);
					for ($i = 0; $i < count($orders_history); $i++) {

						if ($orders_history[$i]['orderId'] == $binance_order_id) {
							$market_price = $orders_history[$i]['price'];
							$commission = $orders_history[$i]['commission'];
							$commissionAsset = $orders_history[$i]['commissionAsset'];
						}
					}

				} else {

					$status = 'FILLED';
					$market_price = $valueArr['market_value'];

					//Check Market History
					$commission = $valueArr['quantity'] * (0.001);
					$commissionAsset = str_replace('BTC', '', $symbol);
				}

				////////////////////////////// Update Order Record ////////////////////////
				if ($status == 'FILLED') {




					$order_upd = array();
					//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


					$compare_symbol  = str_replace('BTC', '', $symbol);

					if($compare_symbol == $commissionAsset){
						$quantity = $quantity - $commission;

							$log_msg = "Broker Fee <b>" . $commission  . "</b> Has been deducted from sell quantity ";
						    $this->mod_dashboard->insert_order_history_log($id, $log_msg, 'buy_commision', $user_id);

						    $log_msg = "Order Quantity Updated to  ".$quantity;
						    $this->mod_dashboard->insert_order_history_log($id, $log_msg, 'buy_commision', $user_id);
						
							$stepSize = $this->is_stepSize($symbol);
							if ($stepSize == 'true') {
								$quantity = floor($quantity);
							}
							$quantity = $quantity;

							$order_upd['quantity'] = $quantity;

							$upd_data['quantity'] = $quantity;
							$upd_data['update_quantity_after_commision_deducted'] = $quantity;
					}


					$upd_data['status'] = $status;
					$upd_data['market_value'] = $market_price;
					$upd_data['purchased_price'] = $market_price;
					
					




					$this->mongo_db->where(array('_id' => $id));
					$this->mongo_db->set($upd_data);
					$this->mongo_db->update('buy_orders');



					$order_upd['purchased_price'] = $market_price;

					$this->mongo_db->where(array('_id' => $sell_order_id));
					$this->mongo_db->set($order_upd);
					$this->mongo_db->update('orders');


					////////////////////// Set Notification //////////////////
					$message = "Buy " . ucfirst($type) . " Order is <b>FILLED</b> at price " . $market_price;
					$this->mod_dashboard->add_notification($id, 'buy', $message, $user_id);
					//////////////////////////////////////////////////////////

					//////////////////////////////////////////////////////////////////////////////////////////////
					////////////////////////////// Order History Log /////////////////////////////////////////////
					$log_msg = "Buy " . ucfirst($type) . " Order is <b>FILLED</b> at price " . $market_price;
					$this->mod_dashboard->insert_order_history_log($id, $log_msg, 'buy_filled', $user_id);
					////////////////////////////// End Order History Log /////////////////////////////////////////
					//////////////////////////////////////////////////////////////////////////////////////////////

					//////////////////////////////////////////////////////////////////////////////////////////////
					////////////////////////////// Order History Log /////////////////////////////////////////////
					$log_msg = "Broker Fee <b>" . $commission . " From " . $commissionAsset . "</b> has token on this Trade";
					$this->mod_dashboard->insert_order_history_log($id, $log_msg, 'buy_commision', $user_id);
					////////////////////////////// End Order History Log /////////////////////////////////////////
					//////////////////////////////////////////////////////////////////////////////////////////////

					///////////////////// going to auto sell /////////////////
					$this->mod_dashboard->auto_sell_now($id);
					/////////////////// End going to auto sell ///////////////

				}
				/////////////////////////////// End Update Order Record //////////////////

			} //end if

		}
		/////////////////////////////////////////////////////////////////////////
		//////////////////////////// End Buy Orders ////////////////////////////
		/////////////////////////////////////////////////////////////////////////

	} //end index_backup


	public function get_quantity_of_sell_order($sell_order_id){
		$this->mongo_db->where(array('_id'=>$sell_order_id));
		$data  =  $this->mongo_db->get('orders');
		$row = iterator_to_array($data);
		$quantity = '';
		if(!empty($row)){
			$quantity = $row[0]['quantity'];
		}
		return $quantity;

	}//End of get_quantity_of_sell_order


	public function  is_stepSize($symbol){

		$this->mongo_db->where(array('symbol'=>$symbol));
		$resp = $this->mongo_db->get('market_min_notation');
		$resp = iterator_to_array($resp);
		$resp = $resp[0];
		$stepSize = $resp['stepSize'];
		$resp2 = 'true';
		if($stepSize < 1 ){
			$resp2 = 'false';
		}
		return $resp2;
	}//%%%%%%% is_stepSize %%%%%%%%%%%%%

	//function for Test Orders
	public function index_backup_test() {

		/////////////////////////////////////////////////////////////////////////
		//////////////////////////// Get Sell Orders ////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		$this->mongo_db->where(array('status' => 'submitted'));
		$this->mongo_db->sort(array('_id' => 'desc'));
		$responseArr = $this->mongo_db->get('orders');

		foreach ($responseArr as $valueArr) {

			$upd_data = array();
			if (!empty($valueArr)) {

				$id = $valueArr['_id'];
				$binance_order_id = $valueArr['binance_order_id'];
				$symbol = $valueArr['symbol'];
				$user_id = $valueArr['admin_id'];
				$order_type = $valueArr['order_type'];
				$buy_order_check = $valueArr['buy_order_check'];
				$buy_order_id = $valueArr['buy_order_id'];
				$market_price = $valueArr['market_value'];
				$quantity = $valueArr['quantity'];

				//$order_status = $this->binance_api->order_status($symbol,$binance_order_id,$user_id);
				// $status = $order_status['status'];
				// $type = $order_status['type'];
				// $market_price = $order_status['price'];

				$status = 'FILLED';

				//Check Market History
				$commission_value = $quantity * (0.001);
				$commission = $commission_value * $market_price;
				$commissionAsset = 'BTC';
				//Check Market History

				////////////////////////////// Update Order Record ////////////////////////
				if ($status == 'FILLED') {

					$upd_data['status'] = $status;

					$this->mongo_db->where(array('_id' => $id));
					$this->mongo_db->set($upd_data);
					$this->mongo_db->update('orders');

					////////////////////// Set Notification //////////////////
					$message = "Sell " . ucfirst($type) . " Order is <b>FILLED</b> at price " . $market_price;
					$this->mod_dashboard->add_notification($id, 'sell', $message, $user_id);
					//////////////////////////////////////////////////////////

					//////////////////////////////////////////////////////////////////////////////////////////////
					////////////////////////////// Order History Log /////////////////////////////////////////////
					$log_msg = "Sell " . ucfirst($type) . " Order is <b>FILLED</b> at price " . $market_price;
					$this->mod_dashboard->insert_order_history_log($buy_order_id, $log_msg, 'sell_filled', $user_id);
					////////////////////////////// End Order History Log /////////////////////////////////////////
					//////////////////////////////////////////////////////////////////////////////////////////////

					//////////////////////////////////////////////////////////////////////////////////////////////
					////////////////////////////// Order History Log /////////////////////////////////////////////
					$log_msg = "Broker Fee <b>" . $commission . " " . $commissionAsset . "</b> has token on this Trade";
					$this->mod_dashboard->insert_order_history_log($buy_order_id, $log_msg, 'sell_commision', $user_id);
					////////////////////////////// End Order History Log /////////////////////////////////////////
					//////////////////////////////////////////////////////////////////////////////////////////////

				}

				if ($status == 'FILLED' && $buy_order_id != '') {

					//Update Buy Order
					$upd_data22 = array(
						'is_sell_order' => 'sold',
						'market_sold_price' => $market_price,
					);

					$this->mongo_db->where(array('_id' => $buy_order_id));
					$this->mongo_db->set($upd_data22);

					//Update data in mongoTable
					$this->mongo_db->update('buy_orders');
				}
				/////////////////////////////// End Update Order Record //////////////////

			} //end if

		}
		/////////////////////////////////////////////////////////////////////////
		//////////////////////////// End Sell Orders ////////////////////////////
		/////////////////////////////////////////////////////////////////////////

		/////////////////////////////////////////////////////////////////////////
		//////////////////////////// Get Buy Orders ////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		$this->mongo_db->where(array('status' => 'submitted'));
		$this->mongo_db->sort(array('_id' => 'desc'));
		$responseArr222 = $this->mongo_db->get('buy_orders');

		foreach ($responseArr222 as $valueArr) {

			$upd_data = array();
			if (!empty($valueArr)) {

				$id = $valueArr['_id'];
				$binance_order_id = $valueArr['binance_order_id'];
				$symbol = $valueArr['symbol'];
				$user_id = $valueArr['admin_id'];
				$order_type = $valueArr['order_type'];
				$market_price = $valueArr['market_value'];
				$quantity = $valueArr['quantity'];

				//$order_status = $this->binance_api->order_status($symbol,$binance_order_id,$user_id);
				// $status = $order_status['status'];
				// $type = $order_status['type'];
				// $market_price = $order_status['price'];

				$status = 'FILLED';

				//Check Market History
				$commission = $quantity * (0.001);
				$commissionAsset = str_replace('BTC', '', $symbol);
				//Check Market History

				////////////////////////////// Update Order Record ////////////////////////
				if ($status == 'FILLED') {

					$upd_data['status'] = $status;

					$this->mongo_db->where(array('_id' => $id));
					$this->mongo_db->set($upd_data);
					$this->mongo_db->update('buy_orders');

					////////////////////// Set Notification //////////////////
					$message = "Buy " . ucfirst($type) . " Order is <b>FILLED</b> at price " . $market_price;
					$this->mod_dashboard->add_notification($id, 'buy', $message, $user_id);
					//////////////////////////////////////////////////////////

					//////////////////////////////////////////////////////////////////////////////////////////////
					////////////////////////////// Order History Log /////////////////////////////////////////////
					$log_msg = "Buy " . ucfirst($type) . " Order is <b>FILLED</b> at price " . $market_price;
					$this->mod_dashboard->insert_order_history_log($id, $log_msg, 'buy_filled', $user_id);
					////////////////////////////// End Order History Log /////////////////////////////////////////
					//////////////////////////////////////////////////////////////////////////////////////////////

					//////////////////////////////////////////////////////////////////////////////////////////////
					////////////////////////////// Order History Log /////////////////////////////////////////////
					$log_msg = "Broker Fee <b>" . $commission . " " . $commissionAsset . "</b> has token on this Trade";
					$this->mod_dashboard->insert_order_history_log($id, $log_msg, 'buy_commision', $user_id);
					////////////////////////////// End Order History Log /////////////////////////////////////////
					//////////////////////////////////////////////////////////////////////////////////////////////

					///////////////////// going to auto sell /////////////////
					$this->mod_dashboard->auto_sell_now($id);
					/////////////////// End going to auto sell ///////////////

				}
				/////////////////////////////// End Update Order Record //////////////////

			} //end if

		}
		/////////////////////////////////////////////////////////////////////////
		//////////////////////////// End Buy Orders ////////////////////////////
		/////////////////////////////////////////////////////////////////////////

	} //end run_cron

}
