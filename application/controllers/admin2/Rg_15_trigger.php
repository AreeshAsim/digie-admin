<?php
/**
 *
 */
class Rg_15_trigger extends CI_Controller {

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
		$this->load->model('admin/mod_rg_15_trigger');
	}



	public function run_trigger_rg_15_auto_sell_and_buy_by_cron_job() {
		exit();

		$trigger_type = 'rg_15';
		$date = date('Y-m-d H:00:00');
		$x = 1; 
		while($x <= 60) {
		$x++;
		sleep(1);
			$this->run_cron();
		}

		$this->mongo_db->where(array('triggers_type' => $trigger_type, 'order_mode' => 'live'));
		$response_obj = $this->mongo_db->get('trigger_global_setting');
		$response_arr = iterator_to_array($response_obj);
		$response = array();
		if (count($response_arr) > 0) {
			$aggressive_stop_rule = $response_arr[0]['aggressive_stop_rule'];
			if ($aggressive_stop_rule == 'stop_loss_rule_2') {
				$this->mod_box_trigger_3->aggrisive_define_percentage_followup($date, $type = 'live', $trigger_type);
			}
		} //End of
	} //End of run_trigger_rg_15_auto_sell_and_buy_by_cron_job


	public function run_cron(){
		$date = date('Y-m-d H:00:00');
		$all_coins_arr = $this->mod_sockets->get_all_coins();
		if (count($all_coins_arr) > 0) {
			foreach ($all_coins_arr as $data) {
				$coin_symbol = $data['symbol'];
				$this->buy_order_trigger_rg_15_live($date, $coin_symbol);
				$this->sell_orders_by_stop_loss($date,$coin_symbol);
		        $this->sell_orders_on_defined_sell_price($date,$coin_symbol);
			}
		}	
	}//End of run_cron


	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////////////////////
	////////////////////  Trigger_rg_15   Live          /////////////////////////////////
	////////////////////                           ////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////






	public function buy_order_trigger_rg_15_live($date, $coin_symbol) {

		$order_mode = array('test_live', 'live');	
		$current_market_price = $this->mod_rg_15_trigger->get_market_value($coin_symbol);
		$current_market_price = (float)$current_market_price;
		$buy_orders_arr = $this->mod_rg_15_trigger->get_new_orders_rg_15($coin_symbol,$order_mode,$current_market_price);

		
		$return_response = '';
		$current_date = date('Y-m-d H:00:00');
		$prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour'));
		if ($date) {
			$current_date = date('Y-m-d H:00:00', strtotime($date));
			$prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour', strtotime($date)));
		}

		$created_date = date("Y-m-d G:i:s");

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


				$res_coin_setting_arr = $this->mod_box_trigger_3->get_trigger_setting($coin_symbol,$triggers_type ='rg_15','live');
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


				//Create Orders///////////////////
				/////////////////////////////////
				   ///////////////////
				        ////////
					$ins_data = array(
						'symbol' => $coin_symbol,
						'purchased_price' => num($current_market_price),
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
						'modified_date' => $this->mongo_db->converToMongodttime($current_date),
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
				
					$market_price = 0; 
					if($current_market_price <= $buy_price){
						$market_price = $current_market_price;
					}

					if($market_price !=0){
						$update_trail_stop = $market_price - ($market_price / 100) * $stop_loss_percent;
						///////////////////End of update trail stop
						///////////////////////////////////////////
						if ($application_mode == 'live') {
							$this->mod_dashboard->binance_buy_auto_market_order_live($id, $quantity, $market_price, $coin_symbol, $admin_id);
							$upd_data22 = array(
							'iniatial_trail_stop' => $update_trail_stop,
							'iniatial_trail_stop_copy' => $update_trail_stop,
							'modified_date' => $this->mongo_db->converToMongodttime($created_date),
							);
							$this->mongo_db->where(array('_id' => $id));
							$this->mongo_db->set($upd_data22);
							//Update data in mongoTable
							$this->mongo_db->update('buy_orders');
						}else{

							$upd_data22 = array(
							'status' => 'FILLED',
							'market_value' => $market_price,
							'iniatial_trail_stop' => $update_trail_stop,
							'buy_date' => $this->mongo_db->converToMongodttime($date),
							'iniatial_trail_stop_copy' => $update_trail_stop,
							'is_sell_order'=>'yes',
							'modified_date' => $this->mongo_db->converToMongodttime($created_date),
							);
							$this->mongo_db->where(array('_id' => $id));
							$this->mongo_db->set($upd_data22);
							//Update data in mongoTable
							$this->mongo_db->update('buy_orders');
							$log_msg = " Order was Buyed at Price " . number_format($market_price, 8);
							$this->mod_rg_15_trigger->insert_order_history_log($id, $log_msg, 'buy_created', $admin_id, $date);
							////////////////////////////// End Order History Log /////////////////////////
							//////////////////////////////////////////////////////////////////////////////
							////////////////////// Set Notification //////////////////
							$message = "Buy Market Order is <b>buyed</b> as status Filled market_price=" . number_format($market_price, 8) . "  buy_price  " . number_format($buy_price, 8) . '  high_value' . number_format($high_value, 8);
							$this->mod_rg_15_trigger->add_notification($id, 'buy', $message, $admin_id);
							//////////////////////////////////////////////////////////
							//Check Market History
							$commission = $quantity * (0.001);
							$commissionAsset = str_replace('BTC', '', $symbol);
							//Check Market History
							//////////////////////////////////////////////////////////////////////////////////////////////
							////////////////////////////// Order History Log /////////////////////////////////////////////
							$log_msg = "Broker Fee <b>" . num($commission) . " " . $commissionAsset . "</b> has token on this Trade";
							$created_date = date('Y-m-d G:i:s');
							$this->mod_rg_15_trigger->insert_order_history_log($id, $log_msg, 'buy_commision', $admin_id, $created_date);
						}
												
					}//if market price match	
			}
		} //If Current candel  Exist
	} //End of buy_order_trigger_rg_15_samulater


	public function sell_orders_by_stop_loss($date='',$coin_symbol){
		$created_date = date('Y-m-d G:i:s');
		$market_price = $this->mod_dashboard->get_market_value($coin_symbol);
		$market_price = (float)$market_price;
		$buy_orders_arr= $this->mod_rg_15_trigger->get_stop_loss_orders($market_price,$coin_symbol);
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
						$message = 'Sell Order was Sold With Loss';
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

	

}
?>

