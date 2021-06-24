<?php
/**
 *
 */
class Box_trigger_3 extends CI_Controller {

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
		$this->load->model('admin/mod_limit_order');
		$this->load->model('admin/mod_barrier_trigger');
		$this->load->model('admin/mod_balance');
		
	}

	public function run_Box_Trigger_3_auto_update_stop_loss() {
		

		//function to see if trade is on
		$is_trades_on_of = $this->mod_barrier_trigger->is_trades_on_of();
		if(!$is_trades_on_of){
			return 'Trade Is  being Off';
		}
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

				// $txt = "aggrisive_define_percentage_followup---  ".date('y-m-d g:i:s');
				// $myfile = file_put_contents('/home/digiebot/public_html/app.digiebot.com/custom_cornjobs/check_box_logs.txt', $txt . PHP_EOL, FILE_APPEND | LOCK_EX);

					$this->mod_box_trigger_3->aggrisive_define_percentage_followup($date,$type,$trigger_type);
				}else if($aggressive_stop_rule  == 'stop_loss_rule_1'){
					//$this->mod_box_trigger_3->Box_Trigger_3_aggressive_trail_stop($date, $coin_symbol,$stop_loss_percent);//problem of coin symbol
				}
			}
			
	} //End of run_Box_Trigger_3_auto_sell_and_buy_by_cron_job





	public function run_Box_Trigger_3_auto_buy_by_cron_job(){

		//Call function at the start of function 
		$function_name = 'run_Box_Trigger_3_auto_buy_by_cron_job';
		$is_function_process_complete = is_function_process_complete($function_name);
		function_start($function_name);

		$is_script_take_more_time = is_script_take_more_time($function_name);

		if($is_script_take_more_time){
			track_execution_of_function_time($function_name);
			function_stop($function_name);
		}

		if(!$is_function_process_complete){
			echo 'previous process is still running';
			return false;
		}

		$date = date('Y-m-d H:00:00');
		$all_coins_arr = $this->mod_sockets->get_all_coins();
		if (count($all_coins_arr) > 0) {
			foreach ($all_coins_arr as $data) {
				$coin_symbol = $data['symbol'];
				$this->buy_order_box_trigger_3_live($date, $coin_symbol);
			}
		}	
		
		function_stop($function_name);
	
	}//End of run_Box_Trigger_3_auto_buy_by_cron_job



	public function run_Box_Trigger_3_auto_sell_by_cron_job(){

		//Call function at the start of function 
		$function_name = 'run_Box_Trigger_3_auto_sell_by_cron_job';
		$is_function_process_complete = is_function_process_complete($function_name);
		function_start($function_name);

		$is_script_take_more_time = is_script_take_more_time($function_name);

		if($is_script_take_more_time){
			track_execution_of_function_time($function_name);
			function_stop($function_name);
		}

		if(!$is_function_process_complete){
			echo 'previous process is still running';
			return false;
		}

		//function to see if trade is on
		$is_trades_on_of = $this->mod_barrier_trigger->is_trades_on_of();
		if(!$is_trades_on_of){
			echo  'Trade Is  being Off';
			return false;
		}
		$date = date('Y-m-d H:00:00');
		$all_coins_arr = $this->mod_sockets->get_all_coins();
		if (count($all_coins_arr) > 0) {
			foreach ($all_coins_arr as $data) {
				$coin_symbol = $data['symbol'];
				$this->sell_orders_on_defined_sell_price($date,$coin_symbol);
			
			}
		}	
		function_stop($function_name);
	
		
	}//End of run_Box_Trigger_3_auto_sell_by_cron_job



	public function run_Box_Trigger_3_auto_stop_loss_sell_by_cron_job(){

		$function_name = 'run_Box_Trigger_3_auto_stop_loss_sell_by_cron_job';
		$is_function_process_complete = is_function_process_complete($function_name);
		function_start($function_name);

		$is_script_take_more_time = is_script_take_more_time($function_name);

		if($is_script_take_more_time){
			track_execution_of_function_time($function_name);
			function_stop($function_name);
		}

		if(!$is_function_process_complete){
			echo 'previous process is still running';
			return false;
		}

		//function to see if trade is on
		$is_trades_on_of = $this->mod_barrier_trigger->is_trades_on_of();
		if(!$is_trades_on_of){
			return 'Trade Is  being Off';
		}
		$date = date('Y-m-d H:00:00');
		$all_coins_arr = $this->mod_sockets->get_all_coins();
		if (count($all_coins_arr) > 0) {
			foreach ($all_coins_arr as $data) {
				$coin_symbol = $data['symbol'];
				$this->sell_orders_by_stop_loss($date,$coin_symbol);
			}
		}	
		function_stop($function_name);
		echo 'ok';
	}//End of run_Box_Trigger_3_auto_sell_by_cron_job
	


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

	public function is_previous_blue_or_rejection_candle($coin_symbol)
	{
		
		$trigger_setting = $this->mod_box_trigger_3->get_trigger_global_setting($coin_symbol);
		$trigger_setting = $trigger_setting[0];
	
		$bottom_demand_rejection = $trigger_setting['bottom_demand_rejection'];

		$bottom_demand_rejection_rule_on_off = false;
		if($bottom_demand_rejection  == 'yes'){
			$bottom_demand_rejection_rule_on_off  = true;
		}

		$bottom_supply_rejection_rule_on_off = false;
		$bottom_supply_rejection = $trigger_setting['bottom_supply_rejection'];
		if($bottom_supply_rejection  == 'yes'){   
			$bottom_supply_rejection_rule_on_off  = true;
		}



		$rejection_apply_rule = '';
		if($bottom_demand_rejection_rule_on_off  && $bottom_supply_rejection_rule_on_off){
			$rejection_apply_rule = 'B';
		}else if($bottom_demand_rejection_rule_on_off){
			$rejection_apply_rule = 'D';
		}else if($bottom_supply_rejection_rule_on_off){
			$rejection_apply_rule = 'S';
		}

		$is_rejection_candle =  true;
		
		if($rejection_apply_rule){
			$prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour'));
			$resp_is_rejection_candle = $this->mod_box_trigger_3->check_rejection_candel($prevouse_date,$coin_symbol,$rejection_apply_rule);

			if($resp_is_rejection_candle){
				$is_rejection_candle =  true;
			}else{
				$is_rejection_candle =  false;
			}	
		}//End of rejection_apply_rule
	
		$is_previous_blue_candle = $trigger_setting['is_previous_blue_candle'];
		$previous_blue_result = true;

		$blue_result = false;
		if($is_previous_blue_candle  == 'yes'){
			$is_previous_blue = $this->mod_box_trigger_3->is_previous_candle_is_blue($coin_symbol);
			if($is_previous_blue){
				$previous_blue_result = true;
			}else{//End of is_previous_blue
				$previous_blue_result = false;
			}
		}//End of is_previous_blue_candle
		$resp = false;
		if($previous_blue_result && $is_rejection_candle){
			$resp = true;
		}
		return $resp;

	}//End of is_previous_blue_or_rejection_candle

	public function buy_order_box_trigger_3_live($date, $coin_symbol) {

		$order_mode = array('test_live', 'live');
		$current_market_price = $this->mod_dashboard->get_market_value($coin_symbol);
		$current_market_price = (float) $current_market_price;

		//Check if market price is empty
		$this->mod_barrier_trigger->is_market_price_empty($current_market_price);

		$buy_orders_arr = $this->mod_box_trigger_3->get_new_orders($coin_symbol,$order_mode,$current_market_price);

		//%%%%%%%%%%%%%%%%% Coin Unit value %%%%%%%%%%%%%%%%%%%%%%%%
		$coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);


		//Check of Condition Meet
		$is_ready_to_buy = $this->is_previous_blue_or_rejection_candle($coin_symbol);
		
		$return_response = '';
		$current_date = date('Y-m-d H:00:00');
		$prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour'));
		if ($date) {
			$current_date = date('Y-m-d H:00:00', strtotime($date));
			$prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour', strtotime($date)));
		}

		$arr_response = array();
		if(!empty($buy_orders_arr) && $is_ready_to_buy){
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
				$order_type = $buy_orders['order_type'];

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
						'order_type' => $order_type,
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



				


                            	
                      /////////////
				//////////////////////////////////
				/////////////////////////////////

				   $created_date = date("Y-m-d G:i:s");

				   $is_rules_true = $this->is_rules_true($coin_symbol);
					$is_barrier_rule_trule = false;
				   $log_message = '';
				   if($is_rules_true['success_message'] =='YES'){
					   $log_message = $is_rules_true['log_message']; 
					   $is_barrier_rule_trule = true;
				   }


				   

					
					if($current_market_price <= $buy_price && $is_ready_to_buy && $is_barrier_rule_trule){
						
						if($is_barrier_rule_trule){
							$this->mod_box_trigger_3->insert_order_history_log($id, $log_message, 'barrier_rules', $admin_id, $created_date);
						}

						///////////////////End of update trail stop
						///////////////////////////////////////////

						$make_new_order_in_orders_collection = true;

						if ($application_mode == 'live') {
							
							if($order_type =='limit_order'){

								//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

								$log_msg = 'Current Market Price : <b>'.num($current_market_price).'</b> ';
								$this->mod_box_trigger_3->insert_order_history_log($id, $log_msg, 'buy_price', $admin_id, $created_date);

								$send_value_for_buy = $current_market_price+$coin_unit_value;

								$log_msg = 'Limit Order was send for buy on : <b>'.num($send_value_for_buy).'</b> ';
								$this->mod_box_trigger_3->insert_order_history_log($buy_order_id, $log_msg, 'buy_price', $admin_id, $created_date);
								//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

								$res_limit_order = $this->mod_dashboard->binance_buy_auto_limit_order_live($id, $quantity, $current_market_price, $coin_symbol, $admin_id);


								if(isset($res_limit_order['error'])){
									$make_new_order_in_orders_collection = false;
								}

								$this->mod_limit_order->save_follow_up_of_limit_order($id,$type='buy');

							}else{

								//%%%%%%%%%%%%%%%%%%%%%%% Order send
								$log_msg = 'Order was send for buy on : <b>'.num($current_market_price).'</b> ';
								$this->mod_box_trigger_3->insert_order_history_log($id, $log_msg, 'buy_price', $admin_id, $created_date);

								$res_market_order = $this->mod_dashboard->binance_buy_auto_market_order_live($id, $quantity, $current_market_price, $coin_symbol, $admin_id);

								if(isset($res_market_order['error'])){
									$make_new_order_in_orders_collection = false;
								}
							}
							
							$upd_data22 = array(
							'iniatial_trail_stop' =>$update_trail_stop,
							'iniatial_trail_stop_copy' =>$update_trail_stop,
							'modified_date'=>$this->mongo_db->converToMongodttime($created_date),

							);
							$this->mongo_db->where(array('_id' => $id));
							$this->mongo_db->set($upd_data22);
							//Update data in mongoTable
							$this->mongo_db->update('buy_orders');



							/**%%%%%%%%%%%%%%%%%%%%% */

							if($make_new_order_in_orders_collection){
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
							}

							/**%%%%%%%%%%%%%%%%%%%%% */



						}else{
							

							/*%%%%%%%%%%%%%%%%%% Make buy order */
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
							/**%%%%%%%%%%%%%%%%End of buy order */




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
		//Check if market price is empty
		$this->mod_barrier_trigger->is_market_price_empty($market_price);

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

				//Is sell or status is new
		     	$is_sell_order_status_new = $this->mod_barrier_trigger->is_sell_order_status_new($order_id);

				if (($market_price < $iniatial_trail_stop) && ($iniatial_trail_stop != '') && $is_sell_order_status_new ) {
					
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
						

						//%%%%%%%%%%%%%%%%%%%%%%% Box Trigger Log %%%%%%%%%%%%%%%%%
						$created_date = date('Y-m-d G:i:s');
						$log_msg = 'Order Send for Sell ON :<b>'.num($market_price).'</b> Price';
						$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'Sell_Price', $admin_id, $created_date);
					 
						//Target price %%%%%%%%%%% 
						
						$log_msg = 'Order Target Trail Stop: <b>'.num($iniatial_trail_stop).'</b> Price';
						$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'target_Price', $admin_id, $created_date);

	
						//%%%%%%%%%%%%%%%%%%%%%%% End Of Trigger Log %%%%%%%%%
						$res = $this->mod_dashboard->binance_sell_auto_market_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id);

					}else{

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
		
		$res_coin_setting_arr = $this->mod_box_trigger_3->get_trigger_setting($coin_symbol,$triggers_type ='box_trigger_3','live');
		$sell_price_percent = 5;
		if (!empty($res_coin_setting_arr)) {
			$sell_price_percent = $res_coin_setting_arr[0]['sell_price'];
		}//End of coin setting not empty



		$created_date = date('Y-m-d G:i:s');
		$market_price = $this->mod_dashboard->get_market_value($coin_symbol);
		$market_price = (float)$market_price;
		//Check if market price is empty
		$this->mod_barrier_trigger->is_market_price_empty($market_price);
		
		$target_sell_price = $market_price - ($market_price/100)*$sell_price_percent;

		$buy_orders_arr = $this->mod_box_trigger_3->get_profit_sell_orders($target_sell_price,$coin_symbol);


	
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
				$is_sell_order_status_new = $this->mod_barrier_trigger->is_sell_order_status_new($order_id);
				

				if ($is_sell_order_status_new) {
					/////////////////////////////////////
					///////////////////////////////////
					$upd_data = array(
						'buy_order_binance_id' => $binance_order_id,
						'market_value' => $market_price,
						'sell_price'=>$market_price,
						'modified_date' => $this->mongo_db->converToMongodttime($created_date),
					);
					$this->mongo_db->where(array('_id' => $order_id));
					$this->mongo_db->set($upd_data);
					$this->mongo_db->update('orders');
					//Insert data in mongoTable
					if ($application_mode == 'live') {

						//%%%%%%%%%%%%%%%%%%%%%%% Box Trigger Log %%%%%%%%%%%%%%%%%
						$created_date = date('Y-m-d G:i:s');
						$log_msg = 'Order Send for Sell ON :<b>'.num($market_price).'</b> Price';
						$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'Sell_Price', $admin_id, $created_date);
					 
						//Target price %%%%%%%%%%% 
						
						$log_msg = 'Order Target Sell Price : <b>'.num($target_sell_price).'</b> Price';
						$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'target_Price', $admin_id, $created_date);

						//Profit Percentage
						$log_msg = 'Order Profit percentage : <b>'.num($sell_price_percent).'</b> ';
						$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'profit_percantage', $admin_id, $created_date);
						//%%%%%%%%%%%%%%%%%%%%%%% End Of Trigger Log %%%%%%%%%
						if($order_type =='limit_order'){
							//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
								$log_msg = 'Send Limit Order On: <b>'.num($market_price).'</b> ';
								$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);
							
							//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
							$res_limit_order = $this->mod_dashboard->binance_sell_auto_limit_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id);
						}else{
							$this->mod_dashboard->binance_sell_auto_market_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id);
						}

						

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
						$log_msg = $message . " " . number_format($market_price, 8);
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



	public function is_rules_true($coin_symbol){
		$triggers_type = 'box_trigger_3';
		$order_mode = 'live';

		$log_arr = array();
		
		$global_setting_arr = $this->mod_barrier_trigger->get_trigger_global_setting($triggers_type, $order_mode, $coin_symbol);
		$global_setting_arr = $global_setting_arr[0];


		$coin_meta_arr = $this->mod_barrier_trigger->get_coin_meta_data($coin_symbol);
		$coin_meta_arr = (array)$coin_meta_arr[0];


		$last_200_buy_vs_sell = $coin_meta_arr['last_200_buy_vs_sell'];
		$last_200_time_ago =(float) $coin_meta_arr['last_200_time_ago'];
		$last_qty_buy_vs_sell = $coin_meta_arr['last_qty_buy_vs_sell'];



		$coin_meta_hourly_arr = $this->mod_box_trigger_3->get_coin_meta_hourly_percentile($coin_symbol);
		$coin_meta_hourly_arr = (array)$coin_meta_hourly_arr[0];


		//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

		 $box_trigger_black_wall = $global_setting_arr['box_trigger_black_wall'];
		 $box_trigger_black_wall_apply = $global_setting_arr['box_trigger_black_wall_apply'];

		 $box_trigger_black_wall_actual_value = $coin_meta_hourly_arr['blackwall_'.$box_trigger_black_wall];
		

			$black_wall_yes_no = true;

			$rule_on_off = '<span style="background-color:yellow">OFF</span>';
			if($box_trigger_black_wall_apply =='yes'){
				if($box_trigger_black_wall_actual_value >= $box_trigger_black_wall){
					$black_wall_yes_no = true;
					$rule_on_off = '<span style="color:green">YES</span>';
				}else{
					$black_wall_yes_no = false;
					$rule_on_off = '<span style="color:red">NO</span>';
				}
			}

			$log_arr['black_wall'] = $rule_on_off;
			$log_arr['black_wall_recommended_value'] = $box_trigger_black_wall;
			$log_arr['black_wall_actual_value'] = $box_trigger_black_wall_actual_value;


		//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%




		//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		$box_trigger_virtual_barrier = $global_setting_arr['box_trigger_virtual_barrier'];
	    $box_trigger_virtual_barrier_apply = $global_setting_arr['box_trigger_virtual_barrier_apply'];

		$barrrier_actual_value = $coin_meta_hourly_arr['bid_quantity_'.$box_trigger_virtual_barrier];

			//*********************************************************************/
			$coin_offset_value = $this->mod_coins->get_coin_offset_value($coin_symbol);
			$coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);
			$current_market_price = $this->mod_dashboard->get_market_value($coin_symbol);
		    $current_market_price = (float) $current_market_price;

			$total_bid_quantity = 0;
			for($i = 0;$i<$coin_offset_value;$i++){
				$new_last_barrrier_value = $current_market_price - ($coin_unit_value*$i);
				$bid = $this->mod_barrier_trigger->get_market_volume($new_last_barrrier_value,$coin_symbol,$type='bid');
				$total_bid_quantity += $bid;
			}//End of Coin off Set

			//*********************************************************************/

		   $virtual_barrier_yes_no = true;
		   $rule_on_off = '<span style="background-color:yellow">OFF</span>';
		   if($box_trigger_virtual_barrier_apply =='yes'){
			   if($barrrier_actual_value >= $total_bid_quantity){
				   $virtual_barrier_yes_no = true;
				   $rule_on_off = '<span style="color:green">YES</span>';
			   }else{
				   $virtual_barrier_yes_no = false;
				   $rule_on_off = '<span style="color:red">NO</span>';
			   }
		   }

		   $log_arr['virtual_barrier'] = $rule_on_off;
		   $log_arr['virtual_barrier_recommended_value'] = $box_trigger_virtual_barrier;
		   $log_arr['virtual_barrier_actual_value'] = $barrrier_actual_value;
		   $log_arr['virtual_barrier_volume'] = $total_bid_quantity;

	
	   //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%





	   //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	   $box_trigger_seven_level_pressure = $global_setting_arr['box_trigger_seven_level_pressure'];
	   $box_trigger_seven_level_pressure_apply = $global_setting_arr['box_trigger_seven_level_pressure_apply'];



		$seven_level_pressure_actual_value = $coin_meta_hourly_arr['sevenlevel_'.$box_trigger_seven_level_pressure];
	   
		   $seven_level_pressure_yes_no = true;

		   $rule_on_off = '<span style="background-color:yellow">OFF</span>';
		   if($box_trigger_seven_level_pressure_apply =='yes'){
			   if($seven_level_pressure_actual_value >= $box_trigger_seven_level_pressure){
				   $seven_level_pressure_yes_no = true;
				   $rule_on_off = '<span style="color:green">YES</span>';
			   }else{
				   $seven_level_pressure_yes_no = false;
				   $rule_on_off = '<span style="color:red">NO</span>';
			   }
		   }

		   $log_arr['seven_level_pressure'] = $rule_on_off;
		   $log_arr['seven_level_pressure_recommended_value'] = $box_trigger_seven_level_pressure;
		   $log_arr['seven_level_pressure_actual_value'] = $seven_level_pressure_actual_value;

	
	   //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%



		

		//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		
		$last_200_contracts_buy_vs_sell_box_trigger = $global_setting_arr['last_200_contracts_buy_vs_sell_box_trigger'];

		$last_200_contracts_buy_vs_sell_box_trigger_apply = $global_setting_arr['last_200_contracts_buy_vs_sell_box_trigger_apply'];



		$last_200_contracts_yes_no = true;
		$rule_on_off = '<span style="background-color:yellow">OFF</span>';
		if($last_200_contracts_buy_vs_sell_box_trigger_apply =='yes'){
			if($last_200_buy_vs_sell >= $last_200_contracts_buy_vs_sell_box_trigger){
				$last_200_contracts_yes_no = true;
				$rule_on_off = '<span style="color:green">YES</span>';
			}else{
				$last_200_contracts_yes_no = false;
				$rule_on_off = '<span style="color:red">NO</span>';
			}
		}

		$log_arr['last_200_buy_vs_sell'] = $rule_on_off;
		$log_arr['last_200_buy_vs_sell_recommended_value'] = $last_200_contracts_buy_vs_sell_box_trigger;
		$log_arr['last_200_buy_vs_sell_actual_value'] = $last_200_buy_vs_sell;

		//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	


		//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
			 $last_200_contracts_time_box_trigger = $global_setting_arr['last_200_contracts_time_box_trigger'];
			 
			$last_200_contracts_time_box_trigger_apply = $global_setting_arr['last_200_contracts_time_box_trigger_apply'];

			$last_200_contracts_time_yes_no = true;

		$rule_on_off = '<span style="background-color:yellow">OFF</span>';
		if($last_200_contracts_time_box_trigger_apply =='yes'){
			if($last_200_time_ago >= $last_200_contracts_time_box_trigger){
				$last_200_contracts_time_yes_no = true;
				$rule_on_off = '<span style="color:green">YES</span>';
			}else{
				$last_200_contracts_time_yes_no = false;
				$rule_on_off = '<span style="color:red">NO</span>';
			}
		}

		$log_arr['last_200_time_ago'] = $rule_on_off;
		$log_arr['last_200_time_ago_recommended_value'] = $last_200_contracts_time_box_trigger;
		$log_arr['last_200_time_ago_actual_value'] = $last_200_time_ago;
		//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%



	  


		//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		$last_qty_contracts_buyer_vs_seller_box_trigger = $global_setting_arr['last_qty_contracts_buyer_vs_seller_box_trigger'];

		$last_qty_contracts_buyer_vs_seller_box_trigger_apply = $global_setting_arr['last_qty_contracts_buyer_vs_seller_box_trigger_apply'];

		$last_200_contracts_qty_yes_no = true;
		$rule_on_off = '<span style="background-color:yellow">OFF</span>';
		if($last_qty_contracts_buyer_vs_seller_box_trigger_apply =='yes'){
			if($last_qty_buy_vs_sell >= $last_qty_contracts_buyer_vs_seller_box_trigger){
				$last_200_contracts_qty_yes_no = true;
				$rule_on_off = '<span style="color:green">YES</span>';
			}else{
				$last_200_contracts_qty_yes_no = false;
				$rule_on_off = '<span style="color:red">NO</span>';
			}
		}

		$log_arr['last_qty_buy_vs_sell'] = $rule_on_off;
		$log_arr['last_qty_buy_vs_sell_recommended_value'] = $last_qty_contracts_buyer_vs_seller_box_trigger;
		$log_arr['last_qty_buy_vs_sell_actual_value'] = $last_qty_buy_vs_sell;
		//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	

		$log_msg = '';
		foreach ($log_arr as $key => $value) {
			$log_msg .=$key.'=>'.$value.'<br>';
		}
	
		$is_rules_true = 'NO';
		if($last_200_contracts_qty_yes_no && $last_200_contracts_time_yes_no && $last_200_contracts_yes_no && $black_wall_yes_no && $virtual_barrier_yes_no && $seven_level_pressure_yes_no){
			$is_rules_true = 'YES';
		}

		$response['success_message'] = $is_rules_true;
		$response['log_message'] = $log_msg;
		
		return $response;


	}//End of is_rules_true

}
?>

