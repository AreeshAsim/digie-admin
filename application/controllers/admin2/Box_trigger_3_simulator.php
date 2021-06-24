<?php
/**
 *
 */
class Box_trigger_3_simulator extends CI_Controller {

	function __construct() {
		parent::__construct();
		//load main template
		$this->stencil->layout('admin_layout');

		//load required slices
		$this->stencil->slice('admin_header_script');
		$this->stencil->slice('admin_header');
		$this->stencil->slice('admin_left_sidebar');
		$this->stencil->slice('admin_footer_script');

		// Load Modal
		$this->load->model('admin/mod_login');
		$this->load->model('admin/mod_users');
		$this->load->model('admin/mod_dashboard');
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_candel');
		$this->load->model('admin/mod_test');
		$this->load->model('admin/mod_box_trigger_3');
		$this->load->model('admin/mod_sockets');
		$this->load->model('admin/mod_buy_orders');
		$this->load->model('admin/mod_realtime_candle_socket');
	}

	public function run_Box_Trigger_3_auto_sell_and_buy_by_cron_job() {
		
		$date = date('Y-m-d H:00:00');
		$trigger_type = 'box_trigger_3';
		$type = 'live';

			$this->mongo_db->where(array('triggers_type'=> 'box_trigger_3','order_mode'=>'live'));
			$response_obj = $this->mongo_db->get('trigger_global_setting');
			$response_arr = iterator_to_array($response_obj);
			$response = array();
			if (count($response_arr) > 0) {
				$aggressive_stop_rule = $response_arr[0]['aggressive_stop_rule'];
				if($aggressive_stop_rule  == 'stop_loss_rule_2'){  
					$this->mod_box_trigger_3->aggrisive_define_percentage_followup($date,$type,$trigger_type);
				}else if($aggressive_stop_rule  == 'stop_loss_rule_1'){
					//$this->mod_box_trigger_3->Box_Trigger_3_aggressive_trail_stop($date, $coin_symbol,$stop_loss_percent);//problem of coin symbol
				}
			}


	
			$x = 1; 
			while($x <= 17) {
			$x++;
			sleep(3);
				$this->run_cron();
			}

	} //End of run_Box_Trigger_3_auto_sell_and_buy_by_cron_job

	public function run_cron(){
		$date = date('Y-m-d H:00:00');
		$all_coins_arr = $this->mod_sockets->get_all_coins();
		if (count($all_coins_arr) > 0) {
			foreach ($all_coins_arr as $data) {
				$coin_symbol = $data['symbol'];
				$this->buy_order_box_trigger_3_live($date, $coin_symbol);
				$this->sell_orders_by_stop_loss($date,$coin_symbol);
		        $this->sell_orders_on_defined_sell_price($date,$coin_symbol);
			}
		}	
	
	}//End of run_cron


	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           ////////////////////////////////
	//////////////////// Box_Trigger_3  simulator  /////////////////////////////////
	////////////////////                           ////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function create_new_orders_by_Box_Trigger_3_simulator($date = '') {

			$current_date = date('Y-m-d H:00:00');
			$prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour'));
			if ($date) {
				$current_date = date('Y-m-d H:00:00', strtotime($date));
				$prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour', strtotime($date)));
			}

			//Check of Parent Order  Exist
			$parent_orders_arr = $this->get_parent_orders();

			$response_arr['message'] = 'parent order not found';
			//if parent order exist then creat buy orders
			if (count($parent_orders_arr) > 0) {

				foreach ($parent_orders_arr as $buy_orders) {
					$buy_parent_id = $buy_orders['_id'];
					$coin_symbol = $buy_orders['symbol'];
					$buy_quantity = $buy_orders['quantity'];
					$buy_trigger_type = $buy_orders['trigger_type'];
					$admin_id = $buy_orders['admin_id'];
					$application_mode = $buy_orders['application_mode'];
					$order_mode = $buy_orders['order_mode'];

					//Get TRigger setting
					$res_coin_setting_arr = $this->mod_box_trigger_3->get_trigger_setting($coin_symbol,$triggers_type ='box_trigger_3','test');
					$buy_price_percentage = 30;
					$stop_loss_percent = 4;
					$sell_price_percent = 3;
					if (count($res_coin_setting_arr) > 0) {
						foreach ($res_coin_setting_arr as $res_coin_setting) {
							$buy_price_percentage = $res_coin_setting['buy_price'];
							$stop_loss_percent = $res_coin_setting['stop_loss'];
							$sell_price_percent = $res_coin_setting['sell_price'];

						}
					}

					//Check of previous candel is Demond Candel

					$previouse_candel_arr = $this->mod_box_trigger_3->get_demand_candel($prevouse_date, $coin_symbol);

					if (count($previouse_candel_arr) > 0) {

						foreach ($previouse_candel_arr as $candel_data) {
							$demand_candel_high_value = $candel_data['high'];
							$demand_candel_low_value = $candel_data['low'];
							$demand_close_value = $candel_data['close'];
							$box_progress_status = $candel_data['box_progress_status'];
						}

						//Call function to Get Lowest Value
						$lowest_value = $this->mod_box_trigger_3->find_previous_lowest_value($prevouse_date, $coin_symbol);
						//Call Function to calculate Aggrisive_Stop Loss
						$iniatial_trail_stop = $this->mod_box_trigger_3->Box_Trigger_3_aggressive_trail_stop($date, $coin_symbol, $demand_close_value, $stop_loss_percent);

						$differenc_value = $demand_candel_high_value - $lowest_value;
						$buy_price = $lowest_value + ($differenc_value * ($buy_price_percentage / 100));

						$sell_price = $buy_price + ($buy_price / 100) * $sell_price_percent;

						$update_prices_arr = array('price' => $buy_price, 'iniatial_trail_stop' => $iniatial_trail_stop, 'sell_price' => $sell_price, 'unique_time_id_to_check_update' => strtotime($date));

						///////////////////////////////////////////////////////////
						////////////////////////                /////////////////////////////
						///////////////////////  Create Order  /////////////////////////////
						//////////////////////                 ////////////////////////////
						///////////////////////////////////////////////////////////

						$ins_data = array(
							'price' => num($buy_price),
							'quantity' => $buy_quantity,
							'symbol' => $coin_symbol,
							'order_type' => 'MARKET_ORDER',
							'admin_id' => $admin_id,
							'trigger_type' => 'box_trigger_3',
							'sell_price' => num($sell_price),
							'created_date' => $this->mongo_db->converToMongodttime($date),
						);
						$ins_data['trail_check'] = 'no';
						$ins_data['trail_interval'] = '0';
						$ins_data['buy_trail_price'] = '0';
						$ins_data['status'] = 'new';
						$ins_data['auto_sell'] = 'no';
						$ins_data['buy_parent_id'] = $buy_parent_id;
						$ins_data['iniatial_trail_stop'] = $iniatial_trail_stop;
						$ins_data['buy_order_status_new_filled'] = 'wait_for_buyed';
						$ins_data['application_mode'] = $application_mode;
						$ins_data['order_mode'] = $order_mode;
						$ins_data['order_mode_lock_for_update'] = 0;
						$ins_data['parent_aggrive_stop_loss_compare_value'] = $demand_close_value;

						if ($box_progress_status == 'created') {
							///////////////////////////////////////////////
							//////////////////////
							/////////
							//Insert data in mongoTable
							$buy_order_id = $this->mongo_db->insert('buy_orders', $ins_data);
							//////////////////////////////////////////////////////////////////////////////
							////////////////////////////// Order History Log /////////////////////////////

							$log_msg = "Buy Test Order was Created at Price " . num($buy_price);
							$this->insert_order_history_log($buy_order_id, $log_msg, 'buy_created', $admin_id, $date);
							////////////////////////////// End Order History Log /////////////////////////
							//////////////////////////////////////////////////////////////////////////////
							////////////////////// Set Notification //////////////////
							$message = "Buy Market Order is <b>Created</b> as status new";
							$this->add_notification($buy_order_id, 'buy', $message, $admin_id);
							/////////
							/////////////////////
							//////////////////////////////////////////////
						} //End of created
						else if ($box_progress_status == 'updated') {
							///////////////////////////////

							//Check if Status Is Not Lock Then Update it
							$this->mongo_db->where_ne('is_sell_order', 'sold');
							$this->mongo_db->where_ne('unique_time_id_to_check_update', strtotime($date));
							$this->mongo_db->where(array('symbol' => $coin_symbol, 'buy_order_status_new_filled' => 'wait_for_buyed', 'status' => 'new'));

							$responese_obj = $this->mongo_db->get('buy_orders');
							$responese_arr = iterator_to_array($responese_obj);

							if (count($responese_arr) > 0) {

								foreach ($responese_arr as $response_data) {

									$order_id = $response_data['_id'];
									$this->mongo_db->where(array('_id' => $order_id));
									$this->mongo_db->set($update_prices_arr);
									//Update data in mongoTable
									$this->mongo_db->update('buy_orders');
									////////////////////////////// Order History Log /////////////////////////////
									$log_msg = "Buy Test Order was Updated To Price " . num($buy_price);
									$this->insert_order_history_log($order_id, $log_msg, 'buy_created', $admin_id, $date);
									////////////////////////////// End Order History Log /////////////////////////
									//////////////////////////////////////////////////////////////////////////////
									////////////////////// Set Notification //////////////////
									$message = "Buy Market Order is <b>Updated</b> as status new";
									$this->add_notification($order_id, 'buy', $message, $admin_id);
								} //End Of Foreach

							}
							/////////////////////////////////////
						} //End of Updated
					}//End of prious candel
					$response_arr['message'] = $this->buy_order_box_trigger_3_samulater($date, $coin_symbol, $stop_loss_percent);
				} //End Of  parent order exist
			}  
	}//End of create_buy_orders_by_Box_Trigger_3_simulator


	function buy_order_box_trigger_3_samulater($date, $coin_symbol, $stop_loss_percent) {

			$buy_orders_arr = $this->mod_box_trigger_3->get_new_orders($coin_symbol);

			$return_response = '';

			$current_date = date('Y-m-d H:00:00');
			$prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour'));
			if ($date) {
				$current_date = date('Y-m-d H:00:00', strtotime($date));
				$prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour', strtotime($date)));
			}

			$this->mongo_db->where(array('openTime_human_readible' => $current_date, 'coin' => $coin_symbol));
			$current_candel_result = $this->mongo_db->get('market_chart');
			$current_candel_arr = iterator_to_array($current_candel_result);

			$arr_response = array();
			if (count($buy_orders_arr)) {
				foreach ($buy_orders_arr as $buy_orders) {
					$id = $buy_orders['_id'];
					$buy_price = $buy_orders['price'];
					$admin_id = $buy_orders['admin_id'];
					$quantity = $buy_orders['quantity'];
					$application_mode = $buy_orders['application_mode'];
					$coin_symbol = $buy_orders['symbol'];
					$parent_aggrive_stop_loss_compare_value = $buy_orders['parent_aggrive_stop_loss_compare_value'];

					//////////////////////////////////
					/////////////////////////////////

					if (count($current_candel_arr) > 0) {

						$high_value = $current_candel_arr[0]['high'];
						$low_value = $current_candel_arr[0]['low'];
						$open = $current_candel_arr[0]['open'];
						$market_price = $low_value;
						$created_date = date("Y-m-d G:i:s");

						if ($market_price <= $buy_price && $high_value >= $buy_price) {

							////////////////update trail stop
							$update_trail_stop = $this->Box_Trigger_3_aggressive_trail_stop($date, $coin_symbol, $parent_aggrive_stop_loss_compare_value, $stop_loss_percent);

							///////////////////End of update trail stop
							///////////////////////////////////////////
							$upd_data22 = array(
								'status' => 'FILLED',
								'market_value' => $market_price,
								'iniatial_trail_stop' => $update_trail_stop,
								'buy_date' => $this->mongo_db->converToMongodttime($date),
							);
							$this->mongo_db->where(array('_id' => $id));
							$this->mongo_db->set($upd_data22);
							//Update data in mongoTable
							$this->mongo_db->update('buy_orders');
							$log_msg = " Order was Buyed at Price " . number_format($market_price, 8);
							$this->insert_order_history_log($id, $log_msg, 'buy_created', $admin_id, $date);
							////////////////////////////// End Order History Log /////////////////////////
							//////////////////////////////////////////////////////////////////////////////
							////////////////////// Set Notification //////////////////
							$message = "Buy Market Order is <b>buyed</b> as status Filled market_price=" . number_format($market_price, 8) . "  buy_price  " . number_format($buy_price, 8) . '  high_value' . number_format($high_value, 8);
							$this->add_notification($id, 'buy', $message, $admin_id);
							//////////////////////////////////////////////////////////
							//Check Market History
							$commission = $quantity * (0.001);
							$commissionAsset = str_replace('BTC', '', $symbol);
							//Check Market History
							//////////////////////////////////////////////////////////////////////////////////////////////
							////////////////////////////// Order History Log /////////////////////////////////////////////
							$log_msg = "Broker Fee <b>" . num($commission) . " " . $commissionAsset . "</b> has token on this Trade";
							$this->insert_order_history_log($id, $log_msg, 'buy_commision', $admin_id, $date);
							////////////////////////////// End Order History Log /////////////////////////////////////////
							//////////////////////////////////////////////////////////////////////////////////////////////
							$arr_response['message'] = $message . '---->log_msg' . $log_msg;
						} //If Market Price Match

					} //If Current candel  Exist
					else {
						$arr_response['message'] = 'NO Order Buyed';
					}

					////////////////////////////////
					///////////////////////////////

				} //End Of ForEach
			} //End Of if count

			return $arr_response;
	} //End of buy_order_box_trigger_3_samulater
	

	public function sell_order_box_trigger_3_samulater($date = '') {

		$this->mongo_db->where_ne('is_sell_order', 'sold');
		$this->mongo_db->where(array('status' => 'FILLED', 'trigger_type' => 'box_trigger_3', 'order_mode' => 'test_simulator'));
		$buy_orders_result = $this->mongo_db->get('buy_orders');
		$buy_orders_arr = iterator_to_array($buy_orders_result);
		$return_response = '';
		$current_date = date('Y-m-d H:00:00');
		$prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour'));
		if ($date) {
			$current_date = date('Y-m-d H:00:00', strtotime($date));
			$prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour', strtotime($date)));
		}

		$arr_response = array();
		if (count($buy_orders_arr) > 0) {
			foreach ($buy_orders_arr as $buy_orders) {
				$buy_orders_id = $buy_orders['_id'];
				$coin_symbol = $buy_orders['symbol'];
				$sell_price = $buy_orders['sell_price'];
				$admin_id = $buy_orders['admin_id'];
				$purchased_price = $buy_orders['price'];
				$buy_purchased_price = $buy_orders['market_value'];
				$iniatial_trail_stop = $buy_orders['iniatial_trail_stop'];
				$application_mode = $buy_orders['application_mode'];
				$quantity = $buy_orders['quantity'];
				$order_type = $buy_orders['order_type'];
				$trigger_type = $buy_orders['trigger_type'];

				$order_mode = $buy_orders['order_mode'];

				$where = array('openTime_human_readible' => $current_date, 'coin' => $coin_symbol);
				$result_arr = array();
				$this->mongo_db->where($where);
				$current_candel_result = $this->mongo_db->get('market_chart');
				$current_candel_arr = iterator_to_array($current_candel_result);

				//////////////// Test Mode//////////////////////////
				///////////////////////////////////////////////////

				if (count($current_candel_arr) > 0) {
					$high_value = $current_candel_arr[0]['high'];
					$low_value = $current_candel_arr[0]['low'];
					$open = $current_candel_arr[0]['open'];
					$market_price = $low_value;
					$created_date = date("Y-m-d G:i:s");

					//Sell with Stop Loss
					if ($market_price < $iniatial_trail_stop && $iniatial_trail_stop != '') {
						$sell_price = $iniatial_trail_stop;
						$upd_data22 = array(
							'is_sell_order' => 'sold',
							'market_sold_price' => $sell_price,
						);
						$this->mongo_db->where(array('_id' => $buy_orders_id));
						$this->mongo_db->set($upd_data22);
						//Update data in mongoTable
						$this->mongo_db->update('buy_orders');
						//////////////////////////////
						//////////////////////////////
						$ins_data = array(
							'symbol' => $coin_symbol,
							'purchased_price' => num($buy_purchased_price),
							'quantity' => $quantity,
							'profit_type' => 'percentage',
							'order_type' => 'MARKET_ORDER',
							'admin_id' => $admin_id,
							'buy_order_check' => 'yes',
							'buy_order_id' => $buy_orders_id,
							'buy_order_binance_id' => '',
							'stop_loss' => 'no',
							'loss_percentage' => '',
							'created_date' => $this->mongo_db->converToMongodttime($current_date),
							'market_value' => $market_price,
							'application_mode' => $application_mode,
							'order_mode' => $order_mode,
						);

						$ins_data['sell_profit_percent'] = 2;
						$ins_data['sell_price'] = $sell_price;

						$ins_data['trail_check'] = 'no';
						$ins_data['trail_interval'] = '0';
						$ins_data['sell_trail_price'] = '0';
						$ins_data['status'] = 'FILLED';
						$ins_data['sell_date'] = $this->mongo_db->converToMongodttime($date);
						$ins_data['trigger_type'] = $trigger_type;

						//Insert data in mongoTable
						$order_id = $this->mongo_db->insert('orders', $ins_data);

						$upd_data = array(
							'sell_order_id' => $order_id,
						);
						$this->mongo_db->where(array('_id' => $buy_orders_id));
						$this->mongo_db->set($upd_data);
						//Update data in mongoTable
						$this->mongo_db->update('buy_orders');
						//////////////////////////////////////////////////////////////////////////////
						////////////////////////////// Order History Log /////////////////////////////
						$message = 'Sell Order was Sold With Loss';
						$log_msg = $message . " " . number_format($sell_price, 8);
						$this->insert_order_history_log($buy_orders_id, $log_msg, 'sell_created', $admin_id, $current_date);
						////////////////////////////// End Order History Log /////////////////////////
						//////////////////////////////////////////////////////////////////////////////
						////////////////////// Set Notification //////////////////
						$message = $message . " <b>Sold</b>";
						$this->add_notification($buy_orders_id, 'buy', $message, $admin_id);
						//////////////////////////////////////////////////////////
						//Check Market History
						$commission_value = $quantity * (0.001);
						$commission = $commission_value * $market_value;
						$commissionAsset = 'BTC';
						//Check Market History
						//////////////////////////////////////////////////////////////////////////////////////////////
						////////////////////////////// Order History Log /////////////////////////////////////////////
						$log_msg = "Broker Fee <b>" . num($commission) . " " . $commissionAsset . "</b> has token on this Trade";
						$this->insert_order_history_log($buy_orders_id, $log_msg, 'sell_commision', $admin_id, $current_date);
						////////////////////////////// End Order History Log /////////////////////////////////////////
						//////////////////////////////////////////////////////////////////////////////////////////////
						$response['message'] = '$log_msg  ' . $log_msg . '  $message ' . $message;

					} else if ($market_price <= $sell_price && $high_value >= $sell_price) {
						//Sell With Normal Value
						$upd_data22 = array(
							'is_sell_order' => 'sold',
							'market_sold_price' => $sell_price,
						);
						$this->mongo_db->where(array('_id' => $buy_orders_id));
						$this->mongo_db->set($upd_data22);
						//Update data in mongoTable
						$this->mongo_db->update('buy_orders');
						/////////////////////////////////////
						///////////////////////////////////
						$ins_data = array(
							'symbol' => $coin_symbol,
							'purchased_price' => num($buy_purchased_price),
							'quantity' => $quantity,
							'profit_type' => 'percentage',
							'order_type' => 'MARKET_ORDER',
							'admin_id' => $admin_id,
							'buy_order_check' => '',
							'buy_order_id' => $buy_orders_id,
							'buy_order_binance_id' => '',
							'stop_loss' => 'yes',
							'loss_percentage' => '',
							'created_date' => $this->mongo_db->converToMongodttime($current_date),
							'market_value' => $market_price,
							'application_mode' => $application_mode,
							'order_mode' => $order_mode,
						);
						$ins_data['sell_profit_percent'] = 2;
						$ins_data['sell_price'] = $sell_price;
						$ins_data['trail_check'] = 'no';
						$ins_data['trail_interval'] = '0';
						$ins_data['sell_trail_price'] = '0';
						$ins_data['status'] = 'FILLED';
						$ins_data['sell_date'] = $this->mongo_db->converToMongodttime($date);
						$ins_data['trigger_type'] = $trigger_type;
						//Insert data in mongoTable
						$order_id = $this->mongo_db->insert('orders', $ins_data);

						$upd_data = array(
							'sell_order_id' => $order_id,
						);

						$this->mongo_db->where(array('_id' => $buy_orders_id));
						$this->mongo_db->set($upd_data);

						//Update data in mongoTable
						$this->mongo_db->update('buy_orders');
						$message = 'Sell Order was Sold With profit';

						//////////////////////////////////////////////////////////////////////////////
						////////////////////////////// Order History Log /////////////////////////////
						$log_msg = $message . " " . number_format($sell_price, 8);
						$this->insert_order_history_log($buy_orders_id, $log_msg, 'sell_created', $admin_id, $current_date);
						////////////////////////////// End Order History Log /////////////////////////
						//////////////////////////////////////////////////////////////////////////////
						////////////////////// Set Notification //////////////////
						$message = $message . " <b>Sold</b>";
						$this->add_notification($buy_orders_id, 'buy', $message, $admin_id);
						//////////////////////////////////////////////////////////
						//Check Market History
						$commission_value = $quantity * (0.001);
						$commission = $commission_value * $market_value;
						$commissionAsset = 'BTC';
						//////////////////////////////////////////////////////////////////////////////////////////////
						////////////////////////////// Order History Log /////////////////////////////////////////////
						$log_msg = "Broker Fee <b>" . num($commission) . " " . $commissionAsset . "</b> has token on this Trade";
						$this->insert_order_history_log($buy_orders_id, $log_msg, 'sell_commision', $admin_id, $current_date);
						////////////////////////////// End Order History Log /////////////////////////////////////////
						//////////////////////////////////////////////////////////////////////////////////////////////
						$response['message'] = '$log_msg  ' . $log_msg . '  $message ' . $message;
					} else {
						$arr_response['message'] = 'NO trigger match for sell $low_value  ' . number_format($low_value, 8) . '  sell_price ' . number_format($sell_price, 8) . '  high_value' . number_format($high_value, 8);
					}
				} else {
					$arr_response['message'] = 'Order is Not Sold';
				}
				///////////////////////////////////////////////
				///////////////////////////////////////////////

			} //End of for each order
		} //End of End Condition
		return $arr_response['message'];
	} //End of sell_order_trigger_2_samulater


	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////////////////////
	//////////////////// Box_Trigger_3  Live       /////////////////////////////////
	////////////////////                           ////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////


	public function buy_order_box_trigger_3_live($date, $coin_symbol) {

		$order_mode = array('test_live', 'live');
		$current_market_price = $this->mod_dashboard->get_market_value($coin_symbol);
		$current_market_price = (float) $current_market_price;
	
		$buy_orders_arr = $this->mod_box_trigger_3->get_new_orders($coin_symbol,$order_mode,$current_market_price);
	
		$return_response = '';
		$current_date = date('Y-m-d H:00:00');
		$prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour'));
		if ($date) {
			$current_date = date('Y-m-d H:00:00', strtotime($date));
			$prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour', strtotime($date)));
		}



		$arr_response = array();
		if (count($buy_orders_arr)) {
			foreach ($buy_orders_arr as $buy_orders) {
				$id = $buy_orders['_id'];
				$buy_price = $buy_orders['price'];
				$admin_id = $buy_orders['admin_id'];
				$quantity = $buy_orders['quantity'];
				$application_mode = $buy_orders['application_mode'];
				$coin_symbol = $buy_orders['symbol'];
				$parent_aggrive_stop_loss_compare_value = $buy_orders['parent_aggrive_stop_loss_compare_value'];
				$iniatial_trail_stop_parent = $buy_orders['iniatial_trail_stop'];
				$demand_close_value = $buy_orders['demand_close_value'];
				$order_date  = $buy_orders['created_date'];
				$order_mode = $buy_orders['order_mode'];
				$binance_order_id = $buy_orders['binance_order_id'];
				$trigger_type = $buy_orders['trigger_type'];
				$sell_price = $buy_orders['sell_price'];

				//Create Orders///////////////////
				/////////////////////////////////
				   ///////////////////
				        ////////
				$res_coin_setting_arr = $this->mod_box_trigger_3->get_trigger_setting($coin_symbol,$triggers_type ='box_trigger_3','live');
				$buy_price_percentage = 30;
				$stop_loss_percent = 4;
				$sell_price_percent = 3;
				if (count($res_coin_setting_arr) > 0) {
					foreach ($res_coin_setting_arr as $res_coin_setting) {
						$buy_price_percentage = $res_coin_setting['buy_price'];
						$stop_loss_percent = $res_coin_setting['stop_loss'];
						$sell_price_percent = $res_coin_setting['sell_price'];

					}
				}

				$update_trail_stop = $current_market_price-($current_market_price*$stop_loss_percent)/100;
				$update_trail_stop =(float)$update_trail_stop;

					$ins_data = array(
						'symbol' => $coin_symbol,
						'purchased_price' => ($current_market_price),
						'quantity' => $quantity,
						'profit_type' => 'percentage',
						'order_type' => 'MARKET_ORDER',
						'admin_id' => $admin_id,
						'buy_order_check' => 'yes',
						'buy_order_id' => $id,
						'buy_order_binance_id' => $binance_order_id,
						'stop_loss' => 'no',
						'loss_percentage' => '',
						'created_date' => $this->mongo_db->converToMongodttime($current_date),
						'modified_date'=>$this->mongo_db->converToMongodttime($current_date),
						'market_value' => $current_market_price,
						'application_mode' => $application_mode,
						'order_mode' => $order_mode,
						'trigger_type' => $trigger_type,
					);

					$ins_data['sell_profit_percent'] = 2;
					$ins_data['sell_price'] = $sell_price;

					$ins_data['trail_check'] = 'no';
					$ins_data['trail_interval'] = '0';
					$ins_data['sell_trail_price'] = '0';
					$ins_data['status'] = 'new';



					$this->mongo_db->where(array('buy_order_id'=>$id));
					$resp_order_obj = $this->mongo_db->get('orders');
					$resp_order_arr = iterator_to_array($resp_order_obj);

					if(count($resp_order_arr)==0){
						
					   $order_id = $this->mongo_db->insert('orders', $ins_data);
						$upd_data22 = array(
							'sell_order_id' => $order_id,
							'is_sell_order'=>'yes'

						);
						$this->mongo_db->where(array('_id' => $id));
						$this->mongo_db->set($upd_data22);
						//Update data in mongoTable
						$this->mongo_db->update('buy_orders');
					}


                            	
                      /////////////
				//////////////////////////////////
				/////////////////////////////////

				   $created_date = date("Y-m-d G:i:s");

					
					if($current_market_price <= $buy_price){
					
						///////////////////End of update trail stop
						///////////////////////////////////////////
						if ($application_mode == 'live') {
							
							$this->mod_dashboard->binance_buy_auto_market_order_live($id, $quantity, $current_market_price, $coin_symbol, $admin_id);
							$upd_data22 = array(
							'iniatial_trail_stop' =>$update_trail_stop,
							'iniatial_trail_stop_copy' =>$update_trail_stop,
							'modified_date'=>$this->mongo_db->converToMongodttime($created_date),

							);
							$this->mongo_db->where(array('_id' => $id));
							$this->mongo_db->set($upd_data22);
							//Update data in mongoTable
							$this->mongo_db->update('buy_orders');
						}else{
							
							$upd_data22 = array(
							'status' => 'FILLED',
							'market_value' => $current_market_price,
							'iniatial_trail_stop' => $update_trail_stop,
							'buy_date' => $this->mongo_db->converToMongodttime($date),
							'iniatial_trail_stop_copy' => $update_trail_stop,
							'modified_date'=>$this->mongo_db->converToMongodttime($created_date),
							'is_sell_order'=>'yes'
							);
							

							$this->mongo_db->where(array('_id' => $id));
							$this->mongo_db->set($upd_data22);
							//Update data in mongoTable
							$this->mongo_db->update('buy_orders');
							$log_msg = " Order was Buyed at Price " . number_format($current_market_price, 8);
							$this->mod_box_trigger_3->insert_order_history_log($id, $log_msg, 'buy_created', $admin_id, $created_date);
							////////////////////////////// End Order History Log /////////////////////////
							//////////////////////////////////////////////////////////////////////////////
							////////////////////// Set Notification //////////////////
							$message = "Buy Market Order is <b>buyed</b> as status Filled market_price=" . number_format($current_market_price, 8) . "  buy_price  " . number_format($buy_price, 8) . '  high_value' . number_format($high_value, 8);
							$this->mod_box_trigger_3->add_notification($id, 'buy', $message, $admin_id);
							//////////////////////////////////////////////////////////
							//Check Market History
							$commission = $quantity * (0.001);
							$commissionAsset = str_replace('BTC', '', $symbol);
							//Check Market History
							//////////////////////////////////////////////////////////////////////////////////////////////
							////////////////////////////// Order History Log /////////////////////////////////////////////
							$log_msg = "Broker Fee <b>" . num($commission) . " " . $commissionAsset . "</b> has token on this Trade";
							
							$this->mod_box_trigger_3->insert_order_history_log($id, $log_msg, 'buy_commision', $admin_id, $created_date);
							////////////////////////////// End Order History Log 
						
						}
					} //If Market Price Match
			} //End Of ForEach
		} //End Of buy_orders_arr count
	} //End of buy_order_box_trigger_3_live


	public function sell_orders_by_stop_loss($date='',$coin_symbol){
		$created_date = date('Y-m-d G:i:s');
		$market_price = $this->mod_dashboard->get_market_value($coin_symbol);
		$market_price = (float)$market_price;
		$buy_orders_arr= $this->mod_box_trigger_3->get_stop_loss_orders($market_price,$coin_symbol);
		$arr_response = array();
		if (count($buy_orders_arr) > 0) {
			foreach ($buy_orders_arr as $buy_orders) {
				$buy_orders_id = $buy_orders['_id'];
				$coin_symbol = $buy_orders['symbol'];
				$sell_price = $buy_orders['sell_price'];
				$admin_id = $buy_orders['admin_id'];
				$purchased_price = $buy_orders['price'];
				$buy_purchased_price = $buy_orders['market_value'];
				$iniatial_trail_stop = $buy_orders['iniatial_trail_stop'];
				$application_mode = $buy_orders['application_mode'];
				$quantity = $buy_orders['quantity'];
				$order_type = $buy_orders['order_type'];
				$order_mode = $buy_orders['order_mode'];
				$binance_order_id = $buy_orders['binance_order_id'];
				$trigger_type = $buy_orders['trigger_type'];
				$order_id =$buy_orders['sell_order_id']; 

				if ($market_price < $iniatial_trail_stop && $iniatial_trail_stop != '') {
					
					//////////////////////////////
					//////////////////////////////
					$upd_data = array(
						'buy_order_binance_id' => $binance_order_id,
						'market_value' => $market_price,
						'sell_price'=>$sell_price,
						'modified_date' => $this->mongo_db->converToMongodttime($date),
					);

					$this->mongo_db->where(array('_id' => $order_id));
					$this->mongo_db->set($upd_data);
					$this->mongo_db->update('orders');



					if ($application_mode == 'live') {
						
						$res = $this->mod_dashboard->binance_sell_auto_market_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id);
					

					} else {

						$upd_data_1 = array(
							'status' => 'FILLED',
						);
						$this->mongo_db->where(array('_id' => $order_id));
						$this->mongo_db->set($upd_data_1);
						//Update data in mongoTable
						$this->mongo_db->update('orders');
						$sell_price = $iniatial_trail_stop;
						$upd_data22 = array(
							'is_sell_order' => 'sold',
							'market_sold_price' => $market_price,
							'modified_date' => $this->mongo_db->converToMongodttime($date),
							
						);

						$this->mongo_db->where(array('_id' => $buy_orders_id));
						$this->mongo_db->set($upd_data22);
						//Update data in mongoTable
						$this->mongo_db->update('buy_orders');
						//////////////////////////////////////////////////////////////////////////////
						////////////////////////////// Order History Log /////////////////////////////
						$message = 'Sell Order was Sold by stop loss ';
						$log_msg = $message . " " . number_format($sell_price, 8);
						$created_date = date('Y-m-d G:i:s');
						$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'sell_created', $admin_id, $created_date);
						////////////////////////////// End Order History Log /////////////////////////
						//////////////////////////////////////////////////////////////////////////////
						////////////////////// Set Notification //////////////////
						$message = $message . " <b>Sold</b>";
						$this->mod_box_trigger_3->add_notification($buy_orders_id, 'buy', $message, $admin_id);
						//////////////////////////////////////////////////////////
						//Check Market History
						$commission_value = $quantity * (0.001);
						$commission = $commission_value * $market_value;
						$commissionAsset = 'BTC';
						//Check Market History
						//////////////////////////////////////////////////////////////////////////////////////////////
						////////////////////////////// Order History Log /////////////////////////////////////////////
						$log_msg = "Broker Fee <b>" . num($commission) . " " . $commissionAsset . "</b> has token on this Trade";
						$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'sell_commision', $admin_id, $created_date);
						////////////////////////////// End Order History Log /////////////////////////////////////////
						//////////////////////////////////////////////////////////////////////////////////////////////
						$response['message'] = '$log_msg  ' . $log_msg . '  $message ' . $message;
					}

				}//End of check Of market price is less Then Initial trail stop  


			}//End of for Each buy orders	
		}//End of buy orders Exist
	}//End of sell_orders_by_stop_loss


	public function sell_orders_on_defined_sell_price($date='',$coin_symbol){
		$created_date = date('Y-m-d G:i:s');
		$market_price = $this->mod_dashboard->get_market_value($coin_symbol);
		$market_price = (float)$market_price;
		$buy_orders_arr= $this->mod_box_trigger_3->get_profit_sell_orders($market_price,$coin_symbol);

	
		if (count($buy_orders_arr) > 0) {
			foreach ($buy_orders_arr as $buy_orders) {
				$buy_orders_id = $buy_orders['_id'];
				$coin_symbol = $buy_orders['symbol'];
				$sell_price = $buy_orders['sell_price'];
				$admin_id = $buy_orders['admin_id'];
				$purchased_price = $buy_orders['price'];
				$buy_purchased_price = $buy_orders['market_value'];
				$iniatial_trail_stop = $buy_orders['iniatial_trail_stop'];
				$application_mode = $buy_orders['application_mode'];
				$quantity = $buy_orders['quantity'];
				$order_type = $buy_orders['order_type'];
				$order_mode = $buy_orders['order_mode'];
				$binance_order_id = $buy_orders['binance_order_id'];
				$trigger_type = $buy_orders['trigger_type'];
				$order_id =$buy_orders['sell_order_id']; 


			






				if ($market_price >= $sell_price) {
					/////////////////////////////////////
					///////////////////////////////////
					$upd_data = array(
						'buy_order_binance_id' => $binance_order_id,
						'market_value' => $market_price,
						'sell_price'=>$sell_price,
						'modified_date' => $this->mongo_db->converToMongodttime($created_date),
					);
					$this->mongo_db->where(array('_id' => $order_id));
					$this->mongo_db->set($upd_data);
					$this->mongo_db->update('orders');
					//Insert data in mongoTable
					if ($application_mode == 'live') {
						$this->mod_dashboard->binance_sell_auto_market_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id);

					} else {
						//Sell With Normal Value
						$upd_data_1 = array(
							'status' => 'FILLED',
						);
						$this->mongo_db->where(array('_id' => $order_id));
						$this->mongo_db->set($upd_data_1);
						//Update data in mongoTable
						$this->mongo_db->update('orders');
						$upd_data = array(
							'sell_order_id' => $order_id,
							'is_sell_order' => 'sold',
							'market_sold_price' => $market_price,
							'modified_date' => $this->mongo_db->converToMongodttime($created_date),
						);
						$this->mongo_db->where(array('_id' => $buy_orders_id));
						$this->mongo_db->set($upd_data);
						//Update data in mongoTable
						$this->mongo_db->update('buy_orders');
						$message = 'Sell Order was Sold With profit';

						//////////////////////////////////////////////////////////////////////////////
						////////////////////////////// Order History Log /////////////////////////////
						$log_msg = $message . " " . number_format($sell_price, 8);
						$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'sell_created', $admin_id, $current_date);
						////////////////////////////// End Order History Log /////////////////////////
						//////////////////////////////////////////////////////////////////////////////
						////////////////////// Set Notification //////////////////
						$message = $message . " <b>Sold</b>";
						$this->mod_box_trigger_3->add_notification($buy_orders_id, 'buy', $message, $admin_id);
						//////////////////////////////////////////////////////////
						//Check Market History
						$commission_value = $quantity * (0.001);
						$commission = $commission_value * $with;
						$commissionAsset = 'BTC';
						//////////////////////////////////////////////////////////////////////////////////////////////
						////////////////////////////// Order History Log /////////////////////////////////////////////
						$log_msg = "Broker Fee <b>" . num($commission) . " " . $commissionAsset . "</b> has token on this Trade";
						$created_date = date('Y-m-d G:i:s');
						$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'sell_commision', $admin_id, $created_date);
						////////////////////////////// End Order History Log /////////////////////////////////////////
						//////////////////////////////////////////////////////////////////////////////////////////////
						$response['message'] = '$log_msg  ' . $log_msg . '  $message ' . $message;
					}//if test live order
				}//if markt price is greater then sell order

			}//End  of forEach buy orders
		}//Check of orders found		
	}//End of sell_orders_on_defined_sell_price


	public function check_if_box_in_process($date, $coin) {

		$this->mongo_db->where_lt('open_time_object', $this->mongo_db->converToMongodttime($date));
		$this->mongo_db->order_by(array('open_time_object' => 'DESC'));
		$this->mongo_db->where_in('global_swing_parent_status', array('LL', 'HL'));
		$this->mongo_db->where(array('coin'=>$coin));
		$this->mongo_db->limit(1);
		$res_object = $this->mongo_db->get('box_trigger_3_setting');
		$res_arr = iterator_to_array($res_object);
		
		$response = false;
		if (count($res_arr) > 0) {
			$start_date = $res_arr[0]['openTime_human_readible'];
			$created_status = $this->check_created_status_between_swing_low_and_current_candle($start_date,$date,$coin);
			if($created_status){
				$this->mongo_db->where_lt('open_time_object', $this->mongo_db->converToMongodttime($date));
				$this->mongo_db->where_gte('open_time_object', $this->mongo_db->converToMongodttime($start_date));
				$this->mongo_db->where_ne('box_progress_status', 'ignored');
		     	$this->mongo_db->where(array('candle_type' => 'demand', 'coin' => $coin));	
		     	$this->mongo_db->order_by(array('open_time_object'=>-1));
		     	$this->mongo_db->limit(1);
		     	$res_obj_2 = $this->mongo_db->get('box_trigger_3_setting');
		     	$res_arr_2  = iterator_to_array($res_obj_2);
		     	if(count($res_arr_2)>0){
		     		$response = $res_arr_2[0]['close'];
		     	}
		    } 	
		}
		return $response;
	} //End of check_if_box_in_process


	public function check_created_status_between_swing_low_and_current_candle($start_date,$date,$coin){

		$this->mongo_db->where_lt('open_time_object', $this->mongo_db->converToMongodttime($date));
		$this->mongo_db->where_gte('open_time_object', $this->mongo_db->converToMongodttime($start_date));
		$this->mongo_db->where(array('candle_type' => 'demand', 'coin' => $coin,'box_progress_status'=>'created'));
		$res_obj = $this->mongo_db->get('box_trigger_3_setting');	
		$res_arr = iterator_to_array($res_obj);
		$response = false;
		if(count($res_arr)>0){
			$response = true;
		}
		return $response; 
	}//End of check_created_status_between_swing_low_and_current_candle

	public function create_custom_parent_orders(){
	
		$created_date = date('Y-m-d G:i:s');
		$admin_id = $this->session->userdata('admin_id');
	

	

		$ins_data = array(
			'price' => '',
			'quantity' => 20001,
			'symbol' => 'NCASHBTC',
			'order_type' => '',
			'admin_id' => $admin_id,
			'created_date' => $this->mongo_db->converToMongodttime($created_date),
			'trail_check' => '',
			'trail_interval' => '',
			'buy_trail_price' => '',
			'status' => 'new',
			'auto_sell' => '',
			'market_value' => '',
			'binance_order_id' => '',
			'is_sell_order' => '',
			'inactive_time' => '',
			'sell_order_id' => '',
			'trigger_type' => 'box_trigger_3',
			'application_mode' => 'test',
			'order_mode' => 'test_live',
			'modified_date' => '',
			'parent_status'=>'parent'
		);

	
		for($i=1;$i<=1000;$i++){
			$buy_order_id = $this->mongo_db->insert('buy_orders', $ins_data);
			echo '#'.$i.'      '.$buy_order_id;
			echo '<br>';
		}
	}//End of 

}
?>

