<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barrier_trigger extends CI_Controller {
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
		$this->load->model('admin/mod_market');
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_buy_orders');
		$this->load->model('admin/mod_candel');
		$this->load->model('admin/mod_realtime_candle_socket');
		$this->load->model('admin/mod_box_trigger_3');
		$this->load->model('admin/mod_barrier_trigger');
		$this->load->model('admin/mod_chart3');
		$this->load->model('admin/mod_custom_script');
		$this->load->model('admin/mod_limit_order');
		$this->load->model('admin/mod_balance');
	}
	
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           ////////////////////////////////
	////////////////////  Function Call Part        //////////////////////////////
	////////////////////                           ////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////


	public function run_barrier_trigger_auto_update_stop_loss() {

		echo '%%%%%%%%%%'.date('Y-m-d H:i:s').'<br>';
		//Call function at the start of function 
		$function_name = 'run_barrier_trigger_auto_update_stop_loss';
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
			 echo 'Trade Is  being Off';
			 return false;
		}

			
		$trigger_type = 'barrier_trigger';
		$type = 'live';
		
		$all_coins_arr = $this->mod_sockets->get_all_coins();
	
		if (count($all_coins_arr) > 0) {
			foreach ($all_coins_arr as $data) {
				$coin_symbol = $data['symbol'];
				
				$this->mongo_db->where(array('triggers_type'=>$trigger_type ,'order_mode'=>$type,'coin'=>$coin_symbol));
				$response_obj = $this->mongo_db->get('trigger_global_setting');
				$response_arr = iterator_to_array($response_obj);
				$response = array();
				if (count($response_arr) > 0) {
					$aggressive_stop_rule = $response_arr[0]['aggressive_stop_rule'];


					if($aggressive_stop_rule  == 'stop_loss_rule_2'){  
						$this->mod_box_trigger_3->aggrisive_define_percentage_followup($date,$type,$trigger_type);
					}else if($aggressive_stop_rule  == 'stop_loss_rule_big_wall'){

						$sell_profit_percet = $response_arr[0]['sell_profit_percet'];

						$current_market_price  = $this->mod_dashboard->get_market_value($coin_symbol);
						$current_market_price  =  (float)$current_market_price;

						
						 $this->mod_barrier_trigger->is_market_deep_price_order($current_market_price, $coin_symbol);

						 $this->mod_barrier_trigger->is_market_deep_ready_stop_loss_update($coin_symbol,$sell_profit_percet,$current_market_price);

						$this->mod_barrier_trigger->stop_loss_big_wall_barrier_trigger($coin_symbol,$sell_profit_percet,$current_market_price);
					}
				}
		       
			}//End of coin array for each
		}//Check if coin exist	

		//%%%%%%%%%%%% if function process complete %%%%%%%%%%%%%
		function_stop($function_name);
		echo 'End Date ******'.date('Y-m-d H:i:s').'<br>';
		
	}//End run_barrier_trigger_auto_update_stop_loss

	public function run_barrier_trigger_auto_sell_stop_loss_cron_job(){

		// $txt = "run_barrier_trigger_auto_sell_stop_loss_cron_job---  ".date('y-m-d g:i:s');
		// $myfile = file_put_contents('/home/digiebot/public_html/app.digiebot.com/custom_cornjobs/check_box_logs.txt', $txt . PHP_EOL, FILE_APPEND | LOCK_EX);

		$function_name = 'run_barrier_trigger_auto_sell_stop_loss_cron_job';
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

		$trigger_type = 'barrier_trigger';
		$date = date('Y-m-d H:i:s');
		$type = 'live';

		$all_coins_arr = $this->mod_sockets->get_all_coins();

		if (count($all_coins_arr) > 0) {
			foreach ($all_coins_arr as $data) {
				$coin_symbol = $data['symbol'];
				/******************************/
				$this->sell_orders_by_stop_loss($date,$coin_symbol);
				/******************************/
				
			}//End of Foreach
		}//End of if count is greater then 0	

		function_stop($function_name);

	}//End of run_barrier_trigger_auto_sell_stop_loss_cron_job



	public function run_barrier_trigger_auto_buy_cron_job(){
	
		$function_name = 'run_barrier_trigger_auto_buy_cron_job';
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

		$trigger_type = 'barrier_trigger';
		$date = date('Y-m-d H:00:00');
		$type = 'live';

		$all_coins_arr = $this->mod_sockets->get_all_coins();

		if (count($all_coins_arr) > 0) {
			foreach ($all_coins_arr as $data) {
				$coin_symbol = $data['symbol'];
				/******************************/
				$this->go_buy_rules($coin_symbol);
				/******************************/
			}//End of Foreach
		}//End of if count is greater then 0
		
		function_stop($function_name);
	}//End of run_barrier_trigger_auto_buy_cron_job



	public function run_barrier_trigger_auto_sell_cron_job(){

		$function_name = 'run_barrier_trigger_auto_sell_cron_job';
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

		$trigger_type = 'barrier_trigger';
		$date = date('Y-m-d H:i:s');
		$type = 'live';

		$all_coins_arr = $this->mod_sockets->get_all_coins();

		if (count($all_coins_arr) > 0) {
			foreach ($all_coins_arr as $data) {
				$coin_symbol = $data['symbol'];
				/******************************/
				$this->go_sell_rules($coin_symbol);
				/******************************/
			}//End of Foreach
		}//End of if count is greater then 0
		
		function_stop($function_name);
	}//End of run_barrier_trigger_auto_buy_cron_job


   


	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           ////////////////////////////////
	////////////////////  Create and Buy Orders    /////////////////////////////////
	////////////////////                           ////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function go_buy_barrier_trigger_order($date,$current_market_price,$coin_symbol,$sell_per, $stop_loss_percent,$log_arr,$show_error_log,$aggressive_stop_rule,$recommended_order_level,$recommended_order_level_on_off){
		
		$parent_orders_arr = $this->mod_barrier_trigger->get_parent_orders($coin_symbol);



		$log_msg_success = '';
		foreach ($log_arr as $key => $value) {
			$log_msg_success .= $key.'  :  '.$value.'<br>';
		}

		$coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);

		$is_order_created = $this->mod_barrier_trigger->is_order_is_created_just_now($coin_symbol);

		if (count($parent_orders_arr) > 0) {
			foreach ($parent_orders_arr as $buy_orders) {
				$buy_parent_id = $buy_orders['_id'];
				$coin_symbol = $buy_orders['symbol'];
				$buy_quantity = $buy_orders['quantity'];
				$buy_trigger_type = $buy_orders['trigger_type'];
				$admin_id = $buy_orders['admin_id'];
				$application_mode = $buy_orders['application_mode'];
				$order_mode = $buy_orders['order_mode'];
				$defined_sell_percentage = $buy_orders['defined_sell_percentage'];
				$order_type = $buy_orders['order_type'];	
				$buy_one_tip_above =  $buy_orders['buy_one_tip_above'];
				$sell_one_tip_below = $buy_orders['sell_one_tip_below'];
				$order_level = $buy_orders['order_level'];

			
				$sell_price = $current_market_price+($current_market_price*$sell_per)/100;
				$stop_loss_rule = '';
				if($aggressive_stop_rule=='stop_loss_rule_big_wall'){
					$down_big_price_value = $this->mod_barrier_trigger->get_down_big_price($coin_symbol);
					$iniatial_trail_stop = $down_big_price_value-$coin_unit_value;
					
					$stop_loss_rule = 'stop_loss_rule_big_wall';

				}else{
					$iniatial_trail_stop = $current_market_price - ($current_market_price / 100) * $stop_loss_percent;
					$stop_loss_rule = 'stop_loss_rule_big_wall';
				}

			
				$created_date = date('Y-m-d G:i:s');
				$ins_data_buy_order = array(
							'price' => (float)$current_market_price,
							'quantity' => $buy_quantity,
							'symbol' => $coin_symbol,
							'order_type' => $order_type,
							'admin_id' => $admin_id,
							'trigger_type' => 'barrier_trigger',
							'sell_price' => (float)$sell_price,
							'created_date' => $this->mongo_db->converToMongodttime($date),
							'modified_date' => $this->mongo_db->converToMongodttime($created_date),
							'buy_date' => $this->mongo_db->converToMongodttime($date),
							'trail_check'=>'no',
							'trail_interval'=> '0',
							'buy_trail_price'=> '0',
							'auto_sell' => 'no',
							'buy_parent_id'=> $buy_parent_id,
							'iniatial_trail_stop'=> (float)$iniatial_trail_stop,
							'iniatial_trail_stop_copy'=>(float) $iniatial_trail_stop,
							'buy_order_status_new_filled'=> 'wait_for_buyed',
							'application_mode'=>$application_mode,
							'order_mode'=> $order_mode,
							'defined_sell_percentage'=>$defined_sell_percentage,
							'buy_one_tip_above'=>$buy_one_tip_above,
							'sell_one_tip_below'=>$sell_one_tip_below,
							'order_level'=>$order_level
						);

												
					$check_exist = $this->mod_barrier_trigger->check_of_previous_buy_order_exist_for_current_user($admin_id,$buy_parent_id);

					//%%%%%%%%%%%%%% Check of Level Meet %%%%%%%%%%
					$is_order_level = true;
					if( ($recommended_order_level_on_off == 'ON' ) && $order_level){
						if (in_array($order_level, $recommended_order_level)) {
							$is_order_level = true;
						}else{
							$is_order_level = false;
						}
					}

		

				   if($check_exist && $is_order_created && $is_order_level){
					//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
					$ins_orders_data = array(
						'symbol' => $coin_symbol,
						'purchased_price' =>(float) ($current_market_price),
						'quantity' => $buy_quantity,
						'profit_type' => 'percentage',
						'order_type' => $order_type,
						'admin_id' => $admin_id,
						'buy_order_check' => 'yes',
						'buy_order_binance_id' => '',
						'stop_loss' => 'no',
						'loss_percentage' => '',
						'created_date' => $this->mongo_db->converToMongodttime($date),
						'modified_date'=>$this->mongo_db->converToMongodttime($created_date),
						'market_value' => (float)$current_market_price,
						'application_mode' => $application_mode,
						'order_mode' => $order_mode,
						'trigger_type' => $buy_trigger_type,
						'buy_one_tip_above'=>$buy_one_tip_above,
						'sell_one_tip_below'=>$sell_one_tip_below,
						'order_level'=>$order_level
					);

					$ins_orders_data['sell_profit_percent'] = $sell_per;
					$ins_orders_data['sell_price'] =(float) $sell_price;

					$ins_orders_data['trail_check'] = 'no';
					$ins_orders_data['trail_interval'] = '0';
					$ins_orders_data['sell_trail_price'] = '0';
					$ins_orders_data['status'] = 'new';



					//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


						
						//%%%%%%%%%%%%%%  %%%%%%%%%%%%%%%%%%%%
						$trading_ip = $this->mod_barrier_trigger->get_user_trading_ip($admin_id);
					  	$this->mod_barrier_trigger->save_order_time_track($coin_symbol);
					   
						$make_new_order_in_orders_collection = true;
						$is_live_order = false;

						if ($application_mode == 'live') {

							$is_live_order = true;
							$ins_data_buy_order['status'] = 'new';
							$buy_order_id = $this->mongo_db->insert('buy_orders', $ins_data_buy_order);
							// %%%%%%%%%%%% store order id in array %%%%%%%%%%%%%%%%%%%%%%%%
							$ins_orders_data['buy_order_id'] = $buy_order_id;

							//%%%%%%%%%%%%%%%%%%%%%% Save Temporders %%%%%%%%%%%%%%
							$this->mongo_db->insert('temp_ip_orders',$ins_orders_data);


							$this->mod_barrier_trigger->save_rules_for_orders($buy_order_id,$coin_symbol,'buy',$rule,$mode='live');
							

							if($order_type =='limit_order'){

								//Add unit value to current market Price
								
								
								//%%%%%%%%%%%%%%%%%%%%%%% Order send
								$log_msg = 'Current Market Price : <b>'.num($current_market_price).'</b> ';
								$this->mod_box_trigger_3->insert_order_history_log($buy_order_id, $log_msg, 'buy_price', $admin_id, $created_date);

								$send_value_for_buy = $current_market_price+$coin_unit_value;

								if($buy_one_tip_above == 'yes'){
									$log_msg = 'Limit Order was send for buy With one tick above : <b>'.num($send_value_for_buy).'</b> ';
								    $this->mod_box_trigger_3->insert_order_history_log($buy_order_id, $log_msg, 'buy_price', $admin_id, $created_date);
								}else{

									$send_value_for_buy = $current_market_price;

									$log_msg = 'Limit Order was send for buy With current market price : <b>'.num($send_value_for_buy).'</b> ';
								    $this->mod_box_trigger_3->insert_order_history_log($buy_order_id, $log_msg, 'buy_price', $admin_id, $created_date);
								}

								$log_msg = 'Send order for buy by Ip:<blod>'.$trading_ip.'</bold>';
								$this->mod_box_trigger_3->insert_order_history_log($buy_order_id, $log_msg, 'buy_price', $admin_id, $created_date);

								$trigger_type = 'barrier_trigger';
								$this->mod_barrier_trigger->order_ready_for_buy_by_ip($buy_order_id, $buy_quantity, $send_value_for_buy, $coin_symbol, $admin_id,$trading_ip,$trigger_type,'buy_limit_order');
								//%%%%%%%%% Need to delete %%%%

								// $res_limit_order = $this->mod_dashboard->binance_buy_auto_limit_order_live($buy_order_id, $buy_quantity, $send_value_for_buy, $coin_symbol, $admin_id);

								// if(isset($res_limit_order['error'])){
								// 	$make_new_order_in_orders_collection = false;
								// }

								$this->mod_limit_order->save_follow_up_of_limit_order($buy_order_id,$type='buy');

							}else{

								//%%%%%%%%%%%%%%%%%%%%%%% Order send
								$log_msg = 'Order was send for buy on : <b>'.num($current_market_price).'</b> ';
								$this->mod_box_trigger_3->insert_order_history_log($buy_order_id, $log_msg, 'buy_price', $admin_id, $created_date);


								$log_msg = 'Send order for buy by Ip:<blod>'.$trading_ip.'</bold>';
								$this->mod_box_trigger_3->insert_order_history_log($buy_order_id, $log_msg, 'buy_price', $admin_id, $created_date);

								$trigger_type = 'barrier_trigger';
								$this->mod_barrier_trigger->order_ready_for_buy_by_ip($buy_order_id, $buy_quantity, $current_market_price, $coin_symbol, $admin_id,$trading_ip,$trigger_type,'buy_market_order');

								// $res_market_order = $this->mod_dashboard->binance_buy_auto_market_order_live($buy_order_id, $buy_quantity, $current_market_price, $coin_symbol, $admin_id);

								// if(isset($res_market_order['error'])){
								// 	$make_new_order_in_orders_collection = false;
								// }
							}


							//%%%%%%%%%%%%%%%%55 Live Order Log %%%%%%%%%%%%%%%%%%%%%%%

							$this->mod_barrier_trigger->insert_developer_log($buy_order_id,$log_msg_success,'Message',$created_date,$show_error_log);

							$log_m = 'Initial Trail Stop is : '.num($iniatial_trail_stop).'  By Rule '.$stop_loss_rule;

							$this->mod_barrier_trigger->insert_order_history_log($buy_order_id, $log_m, 'buy_commision', $admin_id, $created_date);
							

							////////////////////// Set Notification //////////////////
							$message = "Buy Market Order is <b>buyed</b> as status Filled market_price=" . number_format($current_market_price, 8) . "  buy_price  " . number_format($buy_price, 8);
							$this->mod_barrier_trigger->add_notification($buy_order_id, 'buy', $message, $admin_id);
							//////////////////////////////////////////////////////////
							//Check Market History
					

							//%%%%%%%%%%%%%%%%%% End of Live Order Log %%%%%%%%%%%%%%%%%


						}else{
							// %%%%%%%%%%% Test Order Part Start %%%%%%%%%%%%%%%%%%
							//****************************************************** */
							$ins_data_buy_order['is_sell_order'] = 'yes';
							$ins_data_buy_order['status'] = 'FILLED';
							$ins_data_buy_order['market_value'] = $current_market_price;

							$buy_order_id = $this->mongo_db->insert('buy_orders', $ins_data_buy_order);
							
							// %%%%%%%%%%%% store order id in array %%%%%%%%%%%%%%%%%%%%%%%%
							$ins_orders_data['buy_order_id'] = $buy_order_id;

							$this->mod_barrier_trigger->save_rules_for_orders($buy_order_id,$coin_symbol,$order_type='buy',$rule,$mode='test_live');

							//%%%%%%%%%%% Messages Part %%%%%%%%%%%%%%%%%%%%%%%%%%%%%
							//Message Lof For Test
							$log_msg = " Order was Buyed at Price " . number_format($current_market_price, 8);
							$this->mod_barrier_trigger->insert_order_history_log($buy_order_id, $log_msg, 'buy_created', $admin_id, $created_date);


							$this->mod_barrier_trigger->insert_developer_log($buy_order_id,$log_msg_success,'Message',$created_date,$show_error_log);

						

							$m_log = 'Initial Trail Stop is : '.num($iniatial_trail_stop).'  By Rule '.$stop_loss_rule;

							$this->mod_barrier_trigger->insert_order_history_log($buy_order_id, $m_log, 'buy_commision', $admin_id, $created_date);

							////////////////////// Set Notification //////////////////
							$message = "Buy Market Order is <b>buyed</b> as status Filled market_price=" . number_format($current_market_price, 8) . "  buy_price  " . number_format($buy_price, 8);
							$this->mod_barrier_trigger->add_notification($buy_order_id, 'buy', $message, $admin_id);


							//Check Market History
							$commission = $buy_quantity * (0.001);
							$commissionAsset = str_replace('BTC', '', $symbol);

							////////////////////////////// Order History Log /////////////////////////////////////////////
							$log_msg = "Broker Fee <b>" . num($commission) . " " . $commissionAsset . "</b> has token on this Trade";
							$this->mod_barrier_trigger->insert_order_history_log($buy_order_id, $log_msg, 'buy_commision', $admin_id, $created_date);
							////////////////////////////// End Order History Log 

							//%%%%%%%%%%%%%%%%% End of Messages Part %%%%%%%%%%%%%%%%%
							$order_id = $this->mongo_db->insert('orders', $ins_orders_data);
							$upd_data22 = array(
								'sell_order_id' => $order_id,
								'is_sell_order' => 'yes'
							);
							$this->mongo_db->where(array('_id' => $buy_order_id));
							$this->mongo_db->set($upd_data22);
							//Update data in mongoTable
							$this->mongo_db->update('buy_orders');
							
						}//End of test part

				}//if open trade Exist

					
			}//End of parent order array
		}//End of parent ordr count
	}//End of buy_barrier_trigger_order


	 ///////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           ////////////////////////////////
	////////////////////  Sell Order by Profit     /////////////////////////////////
	////////////////////                           ////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////



	public function go_sell_orders_on_defined_sell_price($market_price,$coin_symbol,$log_arr,$show_error_log,$admin_sell_percentage,$rule,$recommended_order_level_on_off,$recommended_order_level){

		$created_date = date('Y-m-d G:i:s');
		$target_sell_price = '';
		$buy_orders_arr = $this->mod_barrier_trigger->get_profit_sell_orders($target_sell_price,$coin_symbol);



		// $txt = "box trigger hit---  ".date('y-m-d g:i:s');
		// $myfile = file_put_contents('/home/digiebot/public_html/app.digiebot.com/custom_cornjobs/check_box_logs.txt', $txt . PHP_EOL, FILE_APPEND | LOCK_EX);

	

		$coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);
		
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
				$order_id = $buy_orders['sell_order_id']; 
				$defined_sell_percentage = $buy_orders['defined_sell_percentage'];

				$market_value = $buy_orders['market_value'];
				$order_level = $buy_orders['order_level'];

				
				$is_order_level = true;
				if( ($recommended_order_level_on_off == 'ON') && $order_level){
					if (in_array($order_level, $recommended_order_level)) {
						$is_order_level = true;
					}else{
						$is_order_level = false;
					}
				}
				

				$sell_percentage = $admin_sell_percentage;

				$sell_one_tip_below = $buy_orders['sell_one_tip_below'];

				$log_message = '';
				foreach ($log_arr as $key => $value) {
					$log_message .= $key.' =>'.$value.'<br>';
				}
		
				if($defined_sell_percentage){
					if($defined_sell_percentage<$admin_sell_percentage){
						$sell_percentage = $defined_sell_percentage;
						$log_message ='Message_type =>**********SELL MESSAGE*******<br> Sell Type => Order has been Sold by User Defined percentage :'.$defined_sell_percentage;
					}
				}

		
				//If no rule Apply
				if($rule == 0){
					if($defined_sell_percentage !='' && $defined_sell_percentage>0){

					}else{
						echo 'return false';
						return false;
					}
				}
			

				$target_sell_price = $market_value + ($market_value/100)*$sell_percentage;



				//Check of sell percentag is greatert then zero
				$is_sell_percentage_greater_then_zero = false;
				if($sell_percentage>0){
					$is_sell_percentage_greater_then_zero = true;	
				}
				

			//Is sell or status is new
			$is_sell_order_status_new = $this->mod_barrier_trigger->is_sell_order_status_new($order_id);

		

			if ( ($market_price >= $target_sell_price) && $is_sell_percentage_greater_then_zero  && $is_sell_order_status_new && $is_order_level) {

				$trading_ip = $this->mod_barrier_trigger->get_user_trading_ip($admin_id);

				$this->mod_barrier_trigger->insert_developer_log($buy_orders_id,$log_message,'Message Sell',$created_date,$show_error_log);

					/////////////////////////////////////
					///////////////////////////////////
					$upd_data = array(
						'buy_order_binance_id' => $binance_order_id,
						'market_value' => (float)$market_price,
						'sell_price'=>(float)$market_price,
						'modified_date' => $this->mongo_db->converToMongodttime($created_date),
					);
				
					$this->mongo_db->where(array('_id' => $order_id));
					$this->mongo_db->set($upd_data);
					$this->mongo_db->update('orders');
					//Insert data in mongoTable
					if ($application_mode == 'live') {

						if($this->is_order_already_not_send($buy_orders_id)){
								//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
								$created_date = date('Y-m-d G:i:s');
								$log_msg = 'Order Send for Sell ON :<b>'.num($market_price).'</b> Price';
								$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'Sell_Price', $admin_id, $created_date);
							
								//Target price %%%%%%%%%%% 
								
								$log_msg = 'Order Target Sell Price : <b>'.num($target_sell_price).'</b> Price';
								$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'target_Price', $admin_id, $created_date);

								//Profit Percentage
								$log_msg = 'Order Profit percentage : <b>'.num($sell_percentage).'</b> ';
								$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'profit_percantage', $admin_id, $created_date);


								if($order_type =='limit_order'){

									if($sell_one_tip_below =='yes'){
										$one_unit_below_value = $market_price-$coin_unit_value;
										$market_price = $one_unit_below_value;
										//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
										$log_msg = 'Send Limit Order On One tick Below: <b>'.num($market_price).'</b> ';
										$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);

									}else{
										//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
										$log_msg = 'Send Limit Order On Current Market Price: <b>'.num($market_price).'</b> ';
										$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);
									}
									
									
									//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


									// $res_limit_order = $this->mod_dashboard->binance_sell_auto_limit_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id);

									$log_msg = 'Send Limit Orde for sell by Ip: <b>'.$trading_ip.'</b> ';
									$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);



									$trigger_type = 'barrier_trigger';
									$this->mod_barrier_trigger->order_ready_for_sell_by_ip($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id,$trading_ip,$trigger_type,'sell_limit_order');

									// //if No Error Occure  
									// if(!isset($res_limit_order['error'])){
									// 	$this->mod_limit_order->save_follow_up_of_limit_sell_order($order_id,$buy_orders_id,$type='sell');
									// }

								}else if($order_type =='stop_loss_limit_order'){

									$log_msg = 'Send stop loss limit order by Profit On Current Market Price: <b>'.num($market_price).'</b> ';
									$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);

									$log_msg = 'Send stop loss limit order by stop_loss On trail stop price: <b>'.num($iniatial_trail_stop).'</b> ';
									$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);

									$res_limit_order = $this->mod_dashboard->binance_sell_auto_stop_loss_limit_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id,$iniatial_trail_stop);

									
								}else{


									$log_msg = 'Send Market Orde for sell by Ip: <b>'.$trading_ip.'</b> ';
									$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);

									$trigger_type = 'barrier_trigger';
									$this->mod_barrier_trigger->order_ready_for_sell_by_ip($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id,$trading_ip,$trigger_type,'sell_market_order');

									// $this->mod_dashboard->binance_sell_auto_market_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id);
								}
								

								$this->mod_barrier_trigger->save_rules_for_orders($buy_orders_id,$coin_symbol,$order_type='sell',$rule,$mode='live');
						}//End of if order already not send


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
							'market_sold_price' => (float)$market_price,
							'modified_date' => $this->mongo_db->converToMongodttime($created_date),
						);
						$this->mongo_db->where(array('_id' => $buy_orders_id));
						$this->mongo_db->set($upd_data);
						//Update data in mongoTable
						$this->mongo_db->update('buy_orders');

						$this->mod_barrier_trigger->save_rules_for_orders($buy_orders_id,$coin_symbol,$order_type='sell',$rule,$mode='test_live');

						$message = 'Sell Order was Sold With profit';

						//////////////////////////////////////////////////////////////////////////////
						////////////////////////////// Order History Log /////////////////////////////
						$log_msg = $message . " " . number_format($market_price, 8);
						$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'sell_created', $admin_id, $created_date);
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
						////////////////////////////// End Order History Log 
					}//if test live order
				}//if markt price is greater then sell order

			}//End  of forEach buy orders
		}//Check of orders found	
	}//End of sell_orders_on_defined_sell_price
    

	///////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           ////////////////////////////////
	////////////////////  test                     /////////////////////////////////
	////////////////////                           ////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////


	public function go_buy_rules($coin_symbol){

		$current_market_price  = $this->mod_dashboard->get_market_value($coin_symbol);
		$current_market_price  =  (float)$current_market_price;

		//Check if market price is empty
		$this->mod_barrier_trigger->is_market_price_empty($current_market_price);


		$rule_meet_arr = array(); 
		$coin_meta_arr = $this->mod_barrier_trigger->get_coin_meta_data($coin_symbol);
		$coin_meta_arr = (array)$coin_meta_arr[0];

		for($rule_number = 1; $rule_number<=10;$rule_number++){
			$buy_arr  = $this->go_buy($coin_symbol,$rule_number,$coin_meta_arr);

			echo '<pre>';
			print_r($buy_arr);
			
			$buy_arr_1 = $buy_arr;
			unset($buy_arr_1['Rule_'.$rule_number]);
			$rule_arr_message = $buy_arr['Rule_'.$rule_number];
			$new = array();
			if(!empty($rule_arr_message)){

				foreach ($rule_arr_message as $key => $value) {
					if($value == '<span style="color:green">YES</span>'){
						$new_key = '<span style="background-color:yellow">'.$key.'</span>';
						$new[$new_key] = '<span style="background-color:yellow">'.$value.'</span>';
					}else if($value == '<span style="color:red">NO</span>'){
						$new_key = '<span style="background-color:#ede1e1">'.$key.'</span>';
						$new[$new_key] = '<span style="background-color:#ede1e1">'.$value.'</span>';
					}else{
						$new[$key] = $value;
					}
					
				}
			}

			$buy_arr_1['Rule_'.$rule_number] = $new;
			
			
			$buy_arr['Rule_'.$rule_number] = $new;
			$log_arr = $buy_arr['Rule_'.$rule_number];

			$sell_per = $buy_arr['sell_per'];
			$stop_loss_percent = $buy_arr['stop_loss_percent'];
			$aggressive_stop_rule = $buy_arr['aggressive_stop_rule'];

			$recommended_order_level = $buy_arr['recommended_order_level'];
			$recommended_order_level_on_off = $buy_arr['recommended_order_level_on_off'];
			
		


			if($buy_arr['response_message'] == 'YES'){

				//Funcion For Locking true rules
				$this->mod_barrier_trigger->lock_barrier_trigger_true_rules($coin_symbol,$rule_number,$type='buy',$current_market_price,$buy_arr); 
				$recommended_order_level_arr = array();
				if(empty($rule_meet_arr)){
					$rule_meet_arr['recommended_order_level'] = $recommended_order_level;
					$rule_meet_arr['recommended_order_level_on_off'] = $recommended_order_level_on_off;
					$rule_meet_arr['rule_number'] = $rule_number;
					$rule_meet_arr['sell_per'] = $sell_per;
					$rule_meet_arr['log_arr'] = $log_arr;
					$rule_meet_arr['stop_loss_percent'] = $stop_loss_percent;
					$rule_meet_arr['aggressive_stop_rule'] = $aggressive_stop_rule;
				}
			}		
		}//End of rules loop

	

		if(!empty($rule_meet_arr)){

				$recommended_order_level = $rule_meet_arr['recommended_order_level'];
				$recommended_order_level_on_off = $rule_meet_arr['recommended_order_level_on_off'];

			    $log_arr = $rule_meet_arr['log_arr'];
				$sell_per = $rule_meet_arr['sell_per'];
				$stop_loss_percent = $rule_meet_arr['stop_loss_percent'];
				$aggressive_stop_rule = $rule_meet_arr['aggressive_stop_rule'];
				$show_error_log = 'yes';
			    $date = date('Y-m-d H:i:s');
			
			    $this->go_buy_barrier_trigger_order($date,$current_market_price,$coin_symbol,$sell_per, $stop_loss_percent,$log_arr,$show_error_log,$aggressive_stop_rule,$recommended_order_level,$recommended_order_level_on_off);
				echo 'Condition Meet for order creation';
			
		}//End of rule_meet_arr
	}//End of go_buy_rules


	public function go_sell_rules($coin_symbol){

		$current_market_price  = $this->mod_dashboard->get_market_value($coin_symbol);
		$current_market_price  =  (float)$current_market_price;

		//Check if market price is empty
		$this->mod_barrier_trigger->is_market_price_empty($current_market_price);

		$coin_meta_arr = $this->mod_barrier_trigger->get_coin_meta_data($coin_symbol);
		$coin_meta_arr = (array)$coin_meta_arr[0];

		$rule_meet_arr = array();
		for($rule_number = 1; $rule_number<=10;$rule_number++){
			$sell_arr = $this->go_sell($coin_symbol,$rule_number,$coin_meta_arr);
			



			$sell_percentage = $sell_arr['sell_percent_rule_'.$rule_number];
			$recommended_order_level_on_off = $sell_arr['recommended_order_level_on_off'];
			$recommended_order_level = $sell_arr['recommended_order_level'];

			$log_arr = $sell_arr['Rule_'.$rule_number];

	

			/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */
			$sell_arr_1 = $sell_arr;
			unset($sell_arr_1['Rule_'.$rule_number]);
			$rule_arr_message = $sell_arr['Rule_'.$rule_number];
			$new = array();
			if(!empty($rule_arr_message)){

				foreach ($rule_arr_message as $key => $value) {
					if($value == '<span style="color:green">YES</span>'){
						$new_key = '<span style="background-color:yellow">'.$key.'</span>';
						$new[$new_key] = '<span style="background-color:yellow">'.$value.'</span>';
					}else if($value == '<span style="color:red">NO</span>'){
						$new_key = '<span style="background-color:#ede1e1">'.$key.'</span>';
						$new[$new_key] = '<span style="background-color:#ede1e1">'.$value.'</span>';
					}else{
						$new[$key] = $value;
					}
					
				}
			}

			$sell_arr_1['Rule_'.$rule_number] = $new;
			
			
			$sell_arr['Rule_'.$rule_number] = $new;
			$log_arr = $sell_arr['Rule_'.$rule_number];
			/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */
		
			echo '<pre>';
			print_r($sell_arr);


			if($sell_arr['response_message'] == 'YES'){
            //CALL function to lock barrier trigger success rule
			$this->mod_barrier_trigger->lock_barrier_trigger_true_rules($coin_symbol,$rule_number,$type='sell',$current_market_price,$sell_arr);


				if(empty($rule_meet_arr)){
					$rule_meet_arr['recommended_order_level_on_off'] = $recommended_order_level_on_off;
					$rule_meet_arr['recommended_order_level'] = $recommended_order_level;

					$rule_meet_arr['rule_number'] = $rule_number;
					$rule_meet_arr['sell_percentage'] = $sell_percentage;
					$rule_meet_arr['log_arr'] = $log_arr;
				}else{

					$previous_percentage = $rule_meet_arr['sell_percentage'];
					if($sell_percentage < $previous_percentage){
							$rule_meet_arr['recommended_order_level_on_off'] = $recommended_order_level_on_off;
							$rule_meet_arr['recommended_order_level'] = $recommended_order_level;

							$rule_meet_arr['rule_number'] = $rule_number;
							$rule_meet_arr['sell_percentage'] = $sell_percentage;
							$rule_meet_arr['log_arr'] = $log_arr;
					}//End of

				}//End of 
			}				
		}


		/************************* */

	


		$show_error_log = 'yes';
		$date = date('Y-m-d H:i:s');
		if(!empty($rule_meet_arr)){

			$log_arr = $rule_meet_arr['log_arr'];
			$sell_percentage = $rule_meet_arr['sell_percentage'];
			$rule_number = $rule_meet_arr['rule_number']; 
			$recommended_order_level_on_off = $rule_meet_arr['recommended_order_level_on_off'];
			$recommended_order_level = $rule_meet_arr['recommended_order_level'];

			$this->go_sell_orders_on_defined_sell_price($current_market_price,$coin_symbol,$log_arr,$show_error_log,$sell_percentage,$rule_number,$recommended_order_level_on_off,$recommended_order_level);
		}else{
			$log_arr =array('Message_type'=>'**********SELL MESSAGE*******','Sell Type'=> 'Order has been Sold by User Defined Value');
			$rule_number = 0;
			$sell_percentage = '';
			$this->go_sell_orders_on_defined_sell_price($current_market_price,$coin_symbol,$log_arr,$show_error_log,$sell_percentage,$rule_number);
		}//If Not Empty
		
	}//End of go_sell_rules


	public function go_sell($coin_symbol,$rule_number,$coin_meta_arr){
		extract($coin_meta_arr);
		$date = date('Y-m-d H:i:s');
		$triggers_type = 'barrier_trigger';
		$order_mode = 'live';
		$rule = 'Rule_'.$rule_number;

		$global_setting_arr = $this->mod_barrier_trigger->get_trigger_global_setting($triggers_type,$order_mode,$coin_symbol);
		$global_setting_arr = $global_setting_arr[0];

		$log_arr = array('Message_type'=>'*******SEll Message**');
		

		$rule_on_off_setting = $global_setting_arr['enable_sell_rule_no_'.$rule_number];
		if($rule_on_off_setting == 'not' || $rule_on_off_setting ==''){

			$log_arr['Rule_NO_'.$rule_number.'_Off'] = '<span style="color:red">OFF</span>';
			return $log_arr;
		}

		$log_arr['rule_sort'] = $global_setting_arr['rule_sort'.$rule_number.'_sell'];

		//%%%%%%%%%%%%%%%%% Check if Level For Buy  %%%%%%%%%%%%%%%%%%
		
		$sell_order_level_on_off = $global_setting_arr['sell_order_level_'.$rule_number.'_enable'];
		$recommended_order_level =  $global_setting_arr['sell_order_level_'.$rule_number];
		if($sell_order_level_on_off == 'not' || $sell_order_level_on_off == ''){
			$log_arr['sell_order_level'.$rule_number] = '<span style="color:red">OFF</span>';
			$data['recommended_order_level_on_off'] ='OFF';
		}else{
			//%%%%%%%%%%%%%%%%%%%%%%% On %%%%%%%%%%%%%%%%%%%%%%%%%
			$log_arr['sell_order_level'.$rule_number] = '<span style="color:green">ON</span>';
			$log_arr['recommended_order_level_'.$rule_number] = implode(',',(array)$recommended_order_level);

			$data['recommended_order_level_on_off'] ='ON';

		}
		//%%%%%%%%%%%%%%%%% Recommended  buy levels%%%%%%%%%%%%%%%%%%%%%%%%%
		$data['recommended_order_level'] =(array) $recommended_order_level;


		
		$data['sell_percent_rule_'.$rule_number] = $global_setting_arr['sell_percent_rule_'.$rule_number];
		

		//%%%%%%%%%%%%%%%% status Rule %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		$rule_on_off = 'sell_status_rule_'.$rule_number.'_enable';
		$rule_name =  'sell_status_rule_'.$rule_number;

		$status_rule_1 = $this->sell_rule_status($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);

		$log_arr = (array_merge($log_arr,$status_rule_1['log_arr']));

		$status_rule_1_result = false;
		if($status_rule_1['success_message'] == 'YES' || $status_rule_1['success_message'] == 'OFF'){
			$status_rule_1_result = true;
		}	

		//%%%%%%%%%%%%%%%%%%%%% Rule End %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


		//%%%%%%%%%%%%%%%%% check candle procedding status %%%%%%%%%%%%%%%%%%%
		$rule_on_off = 'sell_last_candle_status'.$rule_number.'_enable';
		$rule_name =  'last_candle_status'.$rule_number.'_sell';
		
		$candle_procedding_status = $this->sell_candle_lalst_procedding_status($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);	
		

		$log_arr = (array_merge($log_arr,$candle_procedding_status['log_arr']));

	
		$candle_procedding_status_result = false;
		if($candle_procedding_status['success_message'] == 'YES' || $candle_procedding_status['success_message'] == 'OFF'){
			$candle_procedding_status_result = true;
		}
	
		//%%%%%%%%%%%%%%%% End of candle Procedding status %%%%%%%%%%%%%%%%%%%


	


		$rule_on_off = 'sell_check_volume_rule_'.$rule_number;
		$rule_name =  'sell_volume_rule_'.$rule_number;

		$barrier_volume_rule_1 = $this->sell_rule_barrier_volume($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$rule_number);



		$log_arr = (array_merge($log_arr,$barrier_volume_rule_1['log_arr']));

		$barrier_volume_rule_1_result = false;
		if($barrier_volume_rule_1['success_message'] == 'YES' || $barrier_volume_rule_1['success_message'] == 'OFF'){
			$barrier_volume_rule_1_result = true;
		}



		$rule_on_off = 'done_pressure_rule_'.$rule_number.'_enable';
		$rule_name =  'done_pressure_rule_'.$rule_number;

		$down_pressure_rule_1 = $this->sell_rule_down_pressure($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);

		$log_arr = (array_merge($log_arr,$down_pressure_rule_1['log_arr']));

		$down_pressure_rule_1_result = false;
		if($down_pressure_rule_1['success_message'] == 'YES' || $down_pressure_rule_1['success_message'] == 'OFF'){
			$down_pressure_rule_1_result = true;
		}
		


		$rule_on_off = 'big_seller_percent_compare_rule_'.$rule_number.'_enable';
		$rule_name =  'big_seller_percent_compare_rule_'.$rule_number;

		$big_seller_rule_1 = $this->sell_rule_big_seller($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);

		$log_arr = (array_merge($log_arr,$big_seller_rule_1['log_arr']));

		$big_seller_rule_1_rule_1_result = false;
		if($big_seller_rule_1['success_message'] == 'YES' || $big_seller_rule_1['success_message'] == 'OFF'){
			$big_seller_rule_1_rule_1_result = true;
		}
		



		$rule_on_off = 'closest_black_wall_rule_'.$rule_number.'_enable';
		$rule_name =  'closest_black_wall_rule_'.$rule_number;


		$black_wall_rule_1 = $this->sell_rule_black_wall($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);

		$log_arr = (array_merge($log_arr,$black_wall_rule_1['log_arr']));

		$black_wall_rule_1_result = false;
		if($black_wall_rule_1['success_message'] == 'YES' || $black_wall_rule_1['success_message'] == 'OFF'){
			$black_wall_rule_1_result = true;
		}




		$rule_on_off = 'closest_yellow_wall_rule_'.$rule_number.'_enable';
		$rule_name =  'closest_yellow_wall_rule_'.$rule_number;	


	    $yellow_wall_rule_1 = $this->sell_rule_yellow_wall($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);

	    $log_arr = (array_merge($log_arr,$yellow_wall_rule_1['log_arr']));

		$yellow_wall_rule_1_result = false;
		if($yellow_wall_rule_1['success_message'] == 'YES' || $yellow_wall_rule_1['success_message'] == 'OFF'){
			$yellow_wall_rule_1_result = true;
		}



		$rule_on_off = 'seven_level_pressure_rule_'.$rule_number.'_enable';
		$rule_name =  'seven_level_pressure_rule_'.$rule_number;


	    $seven_level_rule_1 = $this->sell_rule_seven_level($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);

	    $log_arr = (array_merge($log_arr,$seven_level_rule_1['log_arr']));

		$seven_level_rule_1_result = false;
		if($seven_level_rule_1['success_message'] == 'YES' || $seven_level_rule_1['success_message'] == 'OFF'){
			$seven_level_rule_1_result = true;
		}

		
		/****************seller_vs_buyer_rule_1_sell **************/
		$rule_on_off = 'seller_vs_buyer_rule_'.$rule_number.'_sell_enable';
		$rule_name =  'seller_vs_buyer_rule_'.$rule_number.'_sell';


	    $seller_vs_buyer_rule = $this->seller_vs_buyer($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);

	    $log_arr = (array_merge($log_arr,$seller_vs_buyer_rule['log_arr']));

		$seller_vs_buyer_rule_result = false;
		if($seller_vs_buyer_rule['success_message'] == 'YES' || $seller_vs_buyer_rule['success_message'] == 'OFF'){
			$seller_vs_buyer_rule_result = true;
		}



		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/
		

		$rule_on_off = 'sell_last_candle_type'.$rule_number.'_enable';
		$rule_name =  'last_candle_type'.$rule_number.'_sell';

	    $is_candle_type = $this->is_candle_type_sell($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_candle_type);

	    $log_arr = (array_merge($log_arr,$is_candle_type['log_arr']));

	    $is_last_candle_type_result = false;
		if($is_candle_type['success_message'] == 'YES' || $is_candle_type['success_message'] == 'OFF'){
			$is_last_candle_type_result = true;
		}
		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/



		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/



		$rule_on_off = 'sell_rejection_candle_type'.$rule_number.'_enable';
		$rule_name =  'rejection_candle_type'.$rule_number.'_sell';

	    $is_rejection_candle = $this->is_rejection_candle_sell($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_candle_rejection_status);
	    	
	  
	    $log_arr = (array_merge($log_arr,$is_rejection_candle['log_arr']));

	    $is_rejection_candle_result = false;
		if($is_rejection_candle['success_message'] == 'YES' || $is_rejection_candle['success_message'] == 'OFF'){
			$is_rejection_candle_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/


		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'sell_last_200_contracts_buy_vs_sell'.$rule_number.'_enable';
		$rule_name =  'last_200_contracts_buy_vs_sell'.$rule_number.'_sell';
	    $is_last_200_contracts_buy_vs_sell = $this->is_last_200_contracts_buy_vs_sell_rule($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_200_buy_vs_sell);

	    $log_arr = (array_merge($log_arr,$is_last_200_contracts_buy_vs_sell['log_arr']));

	    $is_last_200_contracts_buy_vs_sell_result = false;
		if($is_last_200_contracts_buy_vs_sell['success_message'] == 'YES' || $is_last_200_contracts_buy_vs_sell['success_message'] == 'OFF'){
			$is_last_200_contracts_buy_vs_sell_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/



		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'sell_last_200_contracts_time'.$rule_number.'_enable';
		$rule_name =  'last_200_contracts_time'.$rule_number.'_sell';

	    $is_last_200_contracts_time = $this->is_last_200_contracts_time_sell($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_200_time_ago);
	    $log_arr = (array_merge($log_arr,$is_last_200_contracts_time['log_arr']));

	    $is_last_200_contracts_time_result = false;
		if($is_last_200_contracts_time['success_message'] == 'YES' || $is_last_200_contracts_time['success_message'] == 'OFF'){
			$is_last_200_contracts_time_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/



		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'sell_last_qty_buyers_vs_seller'.$rule_number.'_enable';
		$rule_name =  'last_qty_buyers_vs_seller'.$rule_number.'_sell';

	    $is_last_qty_buyers_vs_seller = $this->is_last_qty_buyers_vs_seller_sell($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_qty_buy_vs_sell);
    
	   
	    $log_arr = (array_merge($log_arr,$is_last_qty_buyers_vs_seller['log_arr']));

	    $is_last_qty_buyers_vs_seller_result = false;
		if($is_last_qty_buyers_vs_seller['success_message'] == 'YES' || $is_last_qty_buyers_vs_seller['success_message'] == 'OFF'){
			$is_last_qty_buyers_vs_seller_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/



		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'sell_last_qty_time'.$rule_number.'_enable';
		$rule_name =  'last_qty_time'.$rule_number.'_sell';

	    $is_last_qty_time = $this->is_last_qty_time_sell($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_qty_time_ago);
    	
    
	    $log_arr = (array_merge($log_arr,$is_last_qty_time['log_arr']));

	    $is_last_qty_time_result = false;
		if($is_last_qty_time['success_message'] == 'YES' || $is_last_qty_time['success_message'] == 'OFF'){
			$is_last_qty_time_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/



		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/
		$rule_on_off = 'sell_score'.$rule_number.'_enable';
		$rule_name =  'score'.$rule_number.'_sell';

	    $is_score = $this->is_score_sell($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$score);

    
	    $log_arr = (array_merge($log_arr,$is_score['log_arr']));

	    $is_score_result = false;
		if($is_score['success_message'] == 'YES' || $is_score['success_message'] == 'OFF'){
			$is_score_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/



		/****************End seller_vs_buyer_rule_1_sell **************/

		$meet_all_condition_for_rule_1 = false;
		if($status_rule_1_result && $barrier_volume_rule_1_result && $down_pressure_rule_1_result && $big_seller_rule_1_rule_1_result && $black_wall_rule_1_result && $yellow_wall_rule_1_result && $seven_level_rule_1_result && $seller_vs_buyer_rule_result & $is_last_candle_type_result && $is_rejection_candle_result && $is_last_200_contracts_buy_vs_sell_result && $is_last_200_contracts_time_result && $is_last_qty_buyers_vs_seller_result && $is_last_qty_time_result  && $is_score_result && $candle_procedding_status_result ){
			$meet_all_condition_for_rule_1 = true;
		}

		$response_message = 'NO';
		if($meet_all_condition_for_rule_1){
			$response_message = 'YES';
		}

		$data['Rule_'.$rule_number] = $log_arr;
		$data['response_message'] = $response_message;
		return $data;
	}//End of Function 

	public function go_buy($coin_symbol,$rule_number,$coin_meta_arr){
		extract($coin_meta_arr);

		$date = date('Y-m-d H:i:s');
		$triggers_type = 'barrier_trigger';
		$order_mode = 'live';
		$rule = 'Rule_'.$rule_number;

		$global_setting_arr = $this->mod_barrier_trigger->get_trigger_global_setting($triggers_type,$order_mode,$coin_symbol);
	
		$global_setting_arr = $global_setting_arr[0];

		$log_arr = array('Message_type'=>'********Buy Message *************');

		$rule_on_off_setting = $global_setting_arr['enable_buy_rule_no_'.$rule_number];

		
		if($rule_on_off_setting == 'not' || $rule_on_off_setting ==''){

			$log_arr['Rule_NO_'.$rule_number.'_Off'] = '<span style="color:red">OFF</span>';
			return $log_arr;
		}

		$log_arr['rule_sort'] = $global_setting_arr['order_status'.$rule_number.'_buy'];
		

		//%%%%%%%%%%%%%%%%% Check if Level For Buy  %%%%%%%%%%%%%%%%%%
		
		$buy_order_level_on_off = $global_setting_arr['buy_order_level_'.$rule_number.'_enable'];
		$recommended_order_level =  $global_setting_arr['buy_order_level_'.$rule_number];
		if($buy_order_level_on_off == 'not' || $buy_order_level_on_off == ''){
			$log_arr['buy_order_level'.$rule_number] = '<span style="color:red">OFF</span>';
			$data['recommended_order_level_on_off'] ='OFF';
		}else{
			//%%%%%%%%%%%%%%%%%%%%%%% On %%%%%%%%%%%%%%%%%%%%%%%%%
			$log_arr['buy_order_level'.$rule_number] = '<span style="color:green">ON</span>';
			$log_arr['recommended_order_level_'.$rule_number] = implode(',',(array)$recommended_order_level);

			$data['recommended_order_level_on_off'] ='ON';

		}
		//%%%%%%%%%%%%%%%%% Recommended  buy levels%%%%%%%%%%%%%%%%%%%%%%%%%
		$data['recommended_order_level'] =(array) $recommended_order_level;

		$sell_per = $global_setting_arr['sell_profit_percet']; 
		$stop_loss_percent = $global_setting_arr['stop_loss_percet']; 

		$data['sell_per'] = $sell_per;
		$data['stop_loss_percent'] = $stop_loss_percent;
		$data['aggressive_stop_rule'] = $global_setting_arr['aggressive_stop_rule']; 

		
	
		$rule_on_off = 'buy_status_rule_'.$rule_number.'_enable';
		$rule_name =  'buy_status_rule_'.$rule_number;

		

		$status_rule_1 = $this->buy_rule_status($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);

		$log_arr = (array_merge($log_arr,$status_rule_1['log_arr']));

		$test_arr = array();

		$status_rule_1_result = false;
		if($status_rule_1['success_message'] == 'YES' || $status_rule_1['success_message'] == 'OFF'){
			$status_rule_1_result = true;
		}	

		$test_arr['status_rule_1'] = $status_rule_1['success_message'];


	

		$rule_on_off = 'buy_check_volume_rule_'.$rule_number;
		$rule_name =  'buy_volume_rule_'.$rule_number;

		$barrier_volume_rule_1 = $this->buy_rule_barrier_volume($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$rule_number);
		$log_arr = (array_merge($log_arr,$barrier_volume_rule_1['log_arr']));



		$barrier_volume_rule_1_result = false;
		if($barrier_volume_rule_1['success_message'] == 'YES' || $barrier_volume_rule_1['success_message'] == 'OFF'){
			$barrier_volume_rule_1_result = true;
		}

		$test_arr['barrier_volume_rule_1'] = $barrier_volume_rule_1['success_message'];


		


		$rule_on_off = 'done_pressure_rule_'.$rule_number.'_buy_enable';
		$rule_name =  'done_pressure_rule_'.$rule_number.'_buy';


		$down_pressure_rule_1 = $this->buy_rule_down_pressure($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);

		$log_arr = (array_merge($log_arr,$down_pressure_rule_1['log_arr']));

		$down_pressure_rule_1_result = false;
		if($down_pressure_rule_1['success_message'] == 'YES' || $down_pressure_rule_1['success_message'] == 'OFF'){
			$down_pressure_rule_1_result = true;
		}
		
		$test_arr['down_pressure_rule_1'] = $barrier_volume_rule_1['success_message'];

		//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		$rule_on_off = 'big_seller_percent_compare_rule_'.$rule_number.'_buy_enable';
		$rule_name =  'big_seller_percent_compare_rule_'.$rule_number.'_buy';

		$big_seller_rule_1 = $this->buy_rule_big_seller($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);
		

		$log_arr = (array_merge($log_arr,$big_seller_rule_1['log_arr']));

		$big_seller_rule_1_rule_1_result = false;
		if($big_seller_rule_1['success_message'] == 'YES' || $big_seller_rule_1['success_message'] == 'OFF'){
			$big_seller_rule_1_rule_1_result = true;
		}
			
		$test_arr['big_seller_rule_1'] = $big_seller_rule_1['success_message'];	
		//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

		//%%%%%%%%%%%%%%%%% check candle procedding status %%%%%%%%%%%%%%%%%%%

		$rule_on_off = 'buy_last_candle_status'.$rule_number.'_enable';
		$rule_name =  'last_candle_status'.$rule_number.'_buy';
		

		$candle_procedding_status = $this->buy_candle_lalst_procedding_status($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);	
		$log_arr = (array_merge($log_arr,$candle_procedding_status['log_arr']));

	

		$candle_procedding_status_result = false;
		if($candle_procedding_status['success_message'] == 'YES' || $candle_procedding_status['success_message'] == 'OFF'){
			$candle_procedding_status_result = true;
		}
	
		//%%%%%%%%%%%%%%%% End of candle Procedding status %%%%%%%%%%%%%%%%%%%



		$rule_on_off = 'closest_black_wall_rule_'.$rule_number.'_buy_enable';
		$rule_name =  'closest_black_wall_rule_'.$rule_number.'_buy';


		$black_wall_rule_1 = $this->buy_rule_black_wall($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);

		$log_arr = (array_merge($log_arr,$black_wall_rule_1['log_arr']));

		$black_wall_rule_1_result = false;
		if($black_wall_rule_1['success_message'] == 'YES' || $black_wall_rule_1['success_message'] == 'OFF'){
			$black_wall_rule_1_result = true;
		}


		$test_arr['black_wall_rule_1'] = $black_wall_rule_1['success_message'];	

		$rule_on_off = 'closest_yellow_wall_rule_'.$rule_number.'_buy_enable';
		$rule_name =  'closest_yellow_wall_rule_'.$rule_number.'_buy';	


	    $yellow_wall_rule_1 = $this->buy_rule_yellow_wall($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);

	    $log_arr = (array_merge($log_arr,$yellow_wall_rule_1['log_arr']));

		$yellow_wall_rule_1_result = false;
		if($yellow_wall_rule_1['success_message'] == 'YES' || $yellow_wall_rule_1['success_message'] == 'OFF'){
			$yellow_wall_rule_1_result = true;
		}

		$test_arr['yellow_wall_rule_1'] = $yellow_wall_rule_1['success_message'];	

		$rule_on_off = 'seven_level_pressure_rule_'.$rule_number.'_buy_enable';
		$rule_name =  'seven_level_pressure_rule_'.$rule_number.'_buy';


	    $seven_level_rule_1 = $this->buy_rule_seven_level($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);

	    $log_arr = (array_merge($log_arr,$seven_level_rule_1['log_arr']));

		$seven_level_rule_1_result = false;
		if($seven_level_rule_1['success_message'] == 'YES' || $seven_level_rule_1['success_message'] == 'OFF'){
			$seven_level_rule_1_result = true;
		}


		/************Buy buyer_vs_seller_rule_1_buy **************/

		$rule_on_off = 'buyer_vs_seller_rule_'.$rule_number.'_buy_enable';
		$rule_name =  'buyer_vs_seller_rule_'.$rule_number.'_buy';


	    $buyer_vs_seller_rule = $this->buyer_vs_seller($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);

	    $log_arr = (array_merge($log_arr,$buyer_vs_seller_rule['log_arr']));

		$buyer_vs_seller_rule_result = false;
		if($buyer_vs_seller_rule['success_message'] == 'YES' || $buyer_vs_seller_rule['success_message'] == 'OFF'){
			$buyer_vs_seller_rule_result = true;
		}



		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/
		$rule_on_off = 'buy_last_candle_type'.$rule_number.'_enable';
		$rule_name =  'last_candle_type'.$rule_number.'_buy';

	    $is_candle_type = $this->is_candle_type($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_candle_type);

	    $log_arr = (array_merge($log_arr,$is_candle_type['log_arr']));


	    $is_last_candle_type_result = false;
		if($is_candle_type['success_message'] == 'YES' || $is_candle_type['success_message'] == 'OFF'){
			$is_last_candle_type_result = true;
		}
		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/



		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'buy_rejection_candle_type'.$rule_number.'_enable';
		$rule_name =  'rejection_candle_type'.$rule_number.'_buy';

	    $is_rejection_candle = $this->is_rejection_candle($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_candle_rejection_status);
	    	
	    $log_arr = (array_merge($log_arr,$is_rejection_candle['log_arr']));

	    $is_rejection_candle_result = false;
		if($is_rejection_candle['success_message'] == 'YES' || $is_rejection_candle['success_message'] == 'OFF'){
			$is_rejection_candle_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/


		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'buy_last_200_contracts_buy_vs_sell'.$rule_number.'_enable';
		$rule_name =  'last_200_contracts_buy_vs_sell'.$rule_number.'_buy';

	    $is_last_200_contracts_buy_vs_sell = $this->is_last_200_contracts_buy_vs_sell($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_200_buy_vs_sell);
    	
	    $log_arr = (array_merge($log_arr,$is_last_200_contracts_buy_vs_sell['log_arr']));

	    $is_last_200_contracts_buy_vs_sell_result = false;
		if($is_last_200_contracts_buy_vs_sell['success_message'] == 'YES' || $is_last_200_contracts_buy_vs_sell['success_message'] == 'OFF'){
			$is_last_200_contracts_buy_vs_sell_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/



		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'buy_last_200_contracts_time'.$rule_number.'_enable';
		$rule_name =  'last_200_contracts_time'.$rule_number.'_buy';

	    $is_last_200_contracts_time = $this->is_last_200_contracts_time($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_200_time_ago);

	    $log_arr = (array_merge($log_arr,$is_last_200_contracts_time['log_arr']));

	    $is_last_200_contracts_time_result = false;
		if($is_last_200_contracts_time['success_message'] == 'YES' || $is_last_200_contracts_time['success_message'] == 'OFF'){
			$is_last_200_contracts_time_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/



		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'buy_last_qty_buyers_vs_seller'.$rule_number.'_enable';
		$rule_name =  'last_qty_buyers_vs_seller'.$rule_number.'_buy';

	    $is_last_qty_buyers_vs_seller = $this->is_last_qty_buyers_vs_seller($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_qty_buy_vs_sell);
    	

	    $log_arr = (array_merge($log_arr,$is_last_qty_buyers_vs_seller['log_arr']));

	    $is_last_qty_buyers_vs_seller_result = false;
		if($is_last_qty_buyers_vs_seller['success_message'] == 'YES' || $is_last_qty_buyers_vs_seller['success_message'] == 'OFF'){
			$is_last_qty_buyers_vs_seller_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/



		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

		$rule_on_off = 'buy_last_qty_time'.$rule_number.'_enable';
		$rule_name =  'last_qty_time'.$rule_number.'_buy';

	    $is_last_qty_time = $this->is_last_qty_time($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_qty_time_ago);
    	
	    $log_arr = (array_merge($log_arr,$is_last_qty_time['log_arr']));

	    $is_last_qty_time_result = false;
		if($is_last_qty_time['success_message'] == 'YES' || $is_last_qty_time['success_message'] == 'OFF'){
			$is_last_qty_time_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/



		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/
		$rule_on_off = 'buy_score'.$rule_number.'_enable';
		$rule_name =  'score'.$rule_number.'_buy';

	    $is_score = $this->is_score($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$score);

    	
	    $log_arr = (array_merge($log_arr,$is_score['log_arr']));

	    $is_score_result = false;
		if($is_score['success_message'] == 'YES' || $is_score['success_message'] == 'OFF'){
			$is_score_result = true;
		}

		/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/


		/************ End Buy buyer_vs_seller_rule_1_buy **************/

		$meet_all_condition_for_rule_1 = false;



		if($status_rule_1_result && $barrier_volume_rule_1_result & $down_pressure_rule_1_result && $big_seller_rule_1_rule_1_result & $black_wall_rule_1_result & $yellow_wall_rule_1_result & $seven_level_rule_1_result && $buyer_vs_seller_rule_result & $is_last_candle_type_result && $is_rejection_candle_result && $is_last_200_contracts_buy_vs_sell_result && $is_last_200_contracts_time_result && $is_last_qty_buyers_vs_seller_result && $is_last_qty_time_result  && $is_score_result && $candle_procedding_status_result){

			$meet_all_condition_for_rule_1 = true;
		}


		var_dump($meet_all_condition_for_rule_1);

		$response_message = 'NO';
		if($meet_all_condition_for_rule_1){
			$response_message = 'YES';
		}

	

		$data['Rule_'.$rule_number] = $log_arr;
		$data['response_message'] = $response_message;
		
		return $data;
	}//End of Function 

	///////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           ////////////////////////////////
	////////////////////  Buy Part                 /////////////////////////////////
	////////////////////                           ////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////


	public function is_score($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$score){


		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_score = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if($score >= $recommended_score){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_score'.$rule.'_buy_enable'] = $_status_rule_color;
		$log_arr['score'] = $score;
		$log_arr['recommended_score'] = $recommended_score;

		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_score

	public function is_last_5_minute_candle_buys_vs_seller($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$sellers_buyers_per){

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_last_5_minute_candle_buys_vs_seller = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if($sellers_buyers_per >= $recommended_last_5_minute_candle_buys_vs_seller){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_5_minute_candle_buys_vs_seller'.$rule.'_buy_enable'] = $_status_rule_color;
		$log_arr['last_5_minute_candle_buys_vs_seller'] = $sellers_buyers_per;
		$log_arr['recommended_last_5_minute_candle_buys_vs_seller'] = $recommended_last_5_minute_candle_buys_vs_seller;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_last_5_minute_candle_buys_vs_seller

	public function is_last_qty_time($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_qty_time_ago){


		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_last_qty_time = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if($last_qty_time_ago <= $recommended_last_qty_time){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_qty_time'.$rule.'_buy_enable'] = $_status_rule_color;
		$log_arr['is_last_qty_time'] = $last_qty_time_ago;
		$log_arr['recommended_last_qty_time'] = $recommended_last_qty_time;

		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_last_qty_time

	public function is_last_qty_buyers_vs_seller($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_qty_buy_vs_sell){

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_is_last_qty_buyers_vs_seller = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if($last_qty_buy_vs_sell >= $recommended_is_last_qty_buyers_vs_seller){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_qty_buyers_vs_seller'.$rule.'_buy_enable'] = $_status_rule_color;
		$log_arr['last_qty_buyers_vs_seller'] = $last_qty_buy_vs_sell;
		$log_arr['recommended_is_last_qty_buyers_vs_seller'] = $recommended_is_last_qty_buyers_vs_seller;

		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_last_qty_buyers_vs_seller


	public function is_last_200_contracts_time($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_200_time_ago){


		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_is_last_200_contracts_time = $global_setting_arr[$rule_name];
			$last_200_time_ago_1 = (float)$last_200_time_ago;
			$_status_rule = '<span style="color:red">NO</span>';
			if($last_200_time_ago_1 <= $recommended_is_last_200_contracts_time){
				$_status_rule = 'YES';


			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_200_contracts_time'.$rule.'_buy_enable'] = $_status_rule_color;
		$log_arr['last_200_contracts_time'] = $last_200_time_ago;
		$log_arr['recommended_last_200_contracts_time'] = $recommended_is_last_200_contracts_time;


		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_last_200_contracts_time

	public function is_last_200_contracts_buy_vs_sell($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_200_buy_vs_sell){

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_last_200_contracts_buy_vs_sell = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if($last_200_buy_vs_sell>=$recommended_last_200_contracts_buy_vs_sell){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_200_contracts_buy_vs_sell_'.$rule.'_buy_enable'] = $_status_rule_color;
		$log_arr['last_200_buy_vs_sell'] = $last_200_buy_vs_sell;
		$log_arr['recommended_last_200_contracts_buy_vs_sell'] = $recommended_last_200_contracts_buy_vs_sell;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_last_200_contracts_buy_vs_sell

	public function is_rejection_candle($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_candle_rejection_status){

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_last_rejection_candle = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if($last_candle_rejection_status==$recommended_last_rejection_candle){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_rejection_candle_'.$rule.'_buy_enable'] = $_status_rule_color;
		$log_arr['last_rejection_candle_type'] = $last_candle_rejection_status;
		$log_arr['recommended_rejection_candle_type'] = $recommended_last_rejection_candle;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_rejection_candle


	public function is_candle_type($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_candle_type){
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_candle_type = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if($last_candle_type==$recommended_candle_type){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['Candle_type_'.$rule.'_buy_enable'] = $_status_rule_color;
		$log_arr['last_candle_type'] = $last_candle_type;
		$log_arr['recommended_candle_type'] = $recommended_candle_type;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_candle_type

	public function buyer_vs_seller($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){

			$current_buyer_vs_seller = $this->mod_barrier_trigger->get_buyer_vs_seller_rule($coin_symbol);

			$recommended_buyer_vs_seller = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if($current_buyer_vs_seller>=$recommended_buyer_vs_seller){
				$_status_rule = 'YES';
			}

		}//End of buy_status_rule_1_enable


		if($_status_rule  =='YES'){

			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['buyer_vs_seller_rule_'.$rule.'_buy_enable'] = $_status_rule_color;
		$log_arr['current_buyer_vs_seller'] = $current_buyer_vs_seller;
		$log_arr['recommended_buyer_vs_seller'] = $recommended_buyer_vs_seller;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of buyer_vs_seller


	public function buy_rule_seven_level($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$seven_levele_pressure_value = $seven_levele_pressure = $this->mod_barrier_trigger->seven_level_pressure_sell($coin_symbol);
			$recommended_seven_levele_pressure_value = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if($seven_levele_pressure>=$recommended_seven_levele_pressure_value){
				$_status_rule = 'YES';
			}

		}//End of buy_status_rule_1_enable


		if($_status_rule  =='YES'){

			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_seven_levele_pressure_buy_'.$rule.'_yes'] = $_status_rule_color;
		$log_arr['seven_levele_pressure_value'] = $seven_levele_pressure_value;
		$log_arr['recommended_seven_levele_pressure_value'] = $recommended_seven_levele_pressure_value;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of buy_rule_seven_level
	
	public function buy_rule_yellow_wall($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
				$closest_yelllow_bottom_wall_value = $this->mod_barrier_trigger->get_yellow_closet_wall($coin_symbol);
			$recommended_closest_yellow_wall = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if($closest_yelllow_bottom_wall_value>=$recommended_closest_yellow_wall){
				$_status_rule = 'YES';
			}

		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){

			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}
		$log_arr['is_big_yellow_closest_wall_buy_'.$rule.'_yes'] = $_status_rule_color;
		$log_arr['closest_yellow_bottom_wall_value'] = $closest_yelllow_bottom_wall_value;
		$log_arr['recommended_closest_yellow_bottom_wall_value'] = $recommended_closest_yellow_wall;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of buy_rule_black_wall
				

	public function buy_rule_black_wall($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$closest_black_bottom_wall_value = $this->mod_barrier_trigger->get_black_closet_wall($coin_symbol);
			$recommended_closest_black_wall = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if($closest_black_bottom_wall_value>=$recommended_closest_black_wall){
				$_status_rule = 'YES';
			}

		}//End of buy_status_rule_1_enable


		if($_status_rule  =='YES'){

		$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_big_black_closest_wall_buy_'.$rule.'_yes'] = $_status_rule_color;
		$log_arr['closest_black_bottom_wall_value'] = $closest_black_bottom_wall_value;
		$log_arr['recommended_closest_black_wall'] = $recommended_closest_black_wall;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of buy_rule_black_wall


	public function buy_rule_big_seller($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$ask_percent = $this->mod_barrier_trigger->buy_contract_percentage($coin_symbol);
			$recommended_percentage = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if($ask_percent>=$recommended_percentage){
				$_status_rule = 'YES';
			}

		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){

		$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_big_buyers_'.$rule] = $_status_rule_color;
		$log_arr['big_buyers_percentage'] = $ask_percent;
		$log_arr['recommended_percentage'] = $recommended_percentage;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of buy_rule_big_seller

	public function buy_candle_lalst_procedding_status($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){


		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){

			$current_procedding_status= $this->mod_barrier_trigger->last_procedding_candle_status($coin_symbol);

			$recommended_procedding_status = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if($current_procedding_status == $recommended_procedding_status){
				$_status_rule = 'YES';
			}


		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){

		$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_candle_procedding_status_'.$rule.'_yes'] = $_status_rule_color;
		if($_status_rule  !='OFF'){
			$log_arr['current_procedding_status'] = $current_procedding_status;
			$log_arr['recommended_procedding_status'] = $recommended_procedding_status;
		}
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	
	}//End of buy_candle_lalst_procedding_status

	public function buy_rule_down_pressure($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$current_down_pressure = $this->mod_barrier_trigger->pressure_calculate_from_coin_meta($coin_symbol);
			$recommended_pressure = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if($current_down_pressure >= $recommended_pressure){
				$_status_rule = 'YES';
			}


		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){

		$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_down_pressure_buy_'.$rule.'_yes'] = $_status_rule_color;
		$log_arr['current_down_pressure'] = $current_down_pressure;
		$log_arr['recommended_down_pressure'] = $recommended_pressure;

		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of buy_rule_down_pressure


	public function buy_rule_barrier_volume($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$rule_number){


		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';

		$current_market_price  = $this->mod_dashboard->get_market_value($coin_symbol);
			$current_market_price  =  (float)$current_market_price;
		$m_price  =  (float)$current_market_price;

		if($_enable_disable_rule == 'yes'){

			
			$range_percentage = $global_setting_arr['buy_range_percet'];


			/////////////////Barrier Type ///////////////////////////

			$rule_on_off = 'buy_trigger_type_rule_'.$rule_number.'_enable';
			$rule_name =  'buy_trigger_type_rule_'.$rule_number;



			$trigger_type = $this->buy_rule_trigger($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);

			$trigger_type_log_arr = $trigger_type['log_arr'];

			
			$log_arr['is_trigger_status_buy_Rule_1_yes'] = $trigger_type_log_arr['is_trigger_status_buy_Rule_1_yes'];
			$log_arr['Recommended_trigger_status'] = $trigger_type_log_arr['Recommended_trigger_status'];
			$log_arr['last_barrier_value'] = $trigger_type_log_arr['last_barrier_value'];
		
			$last_barrrier_value =  $trigger_type_log_arr['last_barrier_value'];




			

			$barrier_value_range = $last_barrrier_value+($last_barrrier_value/100)*$range_percentage;

			$meet_condition_for_buy = false;

			if((num($current_market_price) >= num($last_barrrier_value)) && (num($current_market_price) <= num($barrier_value_range))){
				$meet_condition_for_buy = true;
			}

		
		

			if($meet_condition_for_buy){

				$coin_offset_value = $this->mod_coins->get_coin_offset_value($coin_symbol);
				$coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);



				$total_bid_quantity = 0;
				for($i = 0;$i<$coin_offset_value;$i++){
					$new_last_barrrier_value = '';
					$new_last_barrrier_value = $last_barrrier_value - ($coin_unit_value*$i);	
					$bid = $this->mod_barrier_trigger->get_market_volume($new_last_barrrier_value,$coin_symbol,$type='bid');


					$total_bid_quantity += $bid;
				}//End of Coin off Set

				$bid_quantity = $total_bid_quantity;

				

				$bid_volume = $global_setting_arr['buy_volume_rule_'.$rule_number];



				if($bid_quantity>=$bid_volume){
					$_status_rule = 'YES';
				}else{

					$_status_rule = '<span style="color:red">NO</span>';
				}

				$log_arr['total_bid_quantity_for_barrier_range'] = $total_bid_quantity;

				$log_arr['Recommended_bid_quantity'] = $bid_volume;

			}else{
				$_status_rule = '<span style="color:red">NO</span>';
			}//End of Meet barrier
			



			
			$log_arr['current_market_price'] = num($current_market_price);
			$log_arr['last_barrrier_value'] = num($last_barrrier_value);
			$log_arr['barrier_value_range'] = num($barrier_value_range);
			$log_arr['bid_quantity'] = $bid_quantity;

			if($_status_rule  =='YES'){
				$_status_rule_color = '<span style="color:green">YES</span>';
				$log_arr['is_bid_quantity_buy_'.$rule.'_yes'] = $_status_rule_color;
			}else{
				$log_arr['is_bid_quantity_buy_'.$rule.'_yes'] = $_status_rule;
			}
		}else{//End of enable disable rule
				$log_arr['is_bid_quantity_buy_'.$rule.'_yes'] = $_status_rule;
				/*#################################*/
				//IF barrier_not_Meet Then use virturl barrier
				$virtual_barrier_response = $this->is_virtual_barrier($coin_symbol,$global_setting_arr,$rule_number,$m_price);
			

				$log_arr = (array_merge($log_arr,$virtual_barrier_response['log_arr']));

				$is_virtual_barrier = $virtual_barrier_response['success_message'];
			if($is_virtual_barrier =='YES'){
				$_status_rule = $is_virtual_barrier;
				$_status_rule_color = '<span style="color:green">YES</span>';
			}else{
				$_status_rule_color = $_status_rule;
				$_status_rule = $is_virtual_barrier;
			}
			/*#################################*/    

		}//End of rule is disable

		
	
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr; 
		$data['success_message'] = $_status_rule;
		return $data; 		
	}//End of barrier_volume_buy_rule

	public function buy_rule_status($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){

			$current_swing_point = $this->mod_barrier_trigger->get_current_swing_point($coin_symbol);
			$swing_status = (array)$global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if(in_array($current_swing_point, $swing_status)){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){

		$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_swing_status_buy_'.$rule.'_yes'] = $_status_rule_color;
		$log_arr['current_swing_point'] = $current_swing_point;
		$log_arr['Recommended_swing_status'] = implode('--',$swing_status);
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of buy_status

	public function buy_rule_trigger($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];

		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){


			$c_price  = $this->mod_dashboard->get_market_value($coin_symbol);
			$c_price  =  (float)$c_price;

			$current_barrier_status = $this->mod_barrier_trigger->get_current_barrier_status($coin_symbol,$c_price);


			$barrier_status = (array)$global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			$last_barrier_value = '';
			if(count($current_barrier_status)>0){
				foreach ($current_barrier_status as $row) {
					if(in_array($row['barrier_status'], $barrier_status)){
						$_status_rule = 'YES';
						$last_barrier_value = $row['barier_value']; 
						break;
					}
					break;// %%%%%%%%%% Check only First Barrier %%%%%%%%%
				}//End Of 
			}//End Of if Barrier is Greater
			
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){

		$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_trigger_status_buy_'.$rule.'_yes'] = $_status_rule_color;
		$log_arr['current_trigger_status'] = $current_barrier_status;
		$log_arr['Recommended_trigger_status'] = implode('--',$barrier_status);
		$log_arr['last_barrier_value'] = num($last_barrier_value);

		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		
		return $data; 
	}//End of buy_rule_trigger
	
	public function is_virtual_barrier($coin_symbol,$global_setting_arr,$rule_number,$current_market_price){
		
		
		$rule_on_off = 'buy_virtual_barrier_rule_'.$rule_number.'_enable';
		$rule_name =  'buy_virtural_rule_'.$rule_number;

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_quantity = (float)$global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';

			/* %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */

				$coin_offset_value = $this->mod_coins->get_coin_offset_value($coin_symbol);
				$coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);
				$total_bid_quantity = 0;
				for($i = 0;$i<$coin_offset_value;$i++){
					$new_last_barrrier_value = $current_market_price - ($coin_unit_value*$i);

					$bid = $this->mod_barrier_trigger->get_market_volume($new_last_barrrier_value,$coin_symbol,$type='bid');
					$total_bid_quantity += $bid;
				}//End of Coin off Set

			/* %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */
		
			if($total_bid_quantity >= $recommended_quantity){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}
		$log_arr['is_order_book_barrier_enable_'.$rule_number] = $_status_rule_color;

		if($_status_rule !='OFF'){
			$log_arr['calculated_quantity'] = $total_bid_quantity;
			$log_arr['recommended_quantity'] = $recommended_quantity;
		}

	

		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_score

	///////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           ////////////////////////
	////////////////////  Sell Part                 //////////////////////
	////////////////////                           //////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function sell_candle_lalst_procedding_status($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){


		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){

			$current_procedding_status= $this->mod_barrier_trigger->last_procedding_candle_status($coin_symbol);

			$recommended_procedding_status = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if($current_procedding_status == $recommended_procedding_status){
				$_status_rule = 'YES';
			}


		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){

		$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_candle_procedding_status_'.$rule.'_yes'] = $_status_rule_color;
		if($_status_rule  !='OFF'){
			$log_arr['current_procedding_status'] = $current_procedding_status;
			$log_arr['recommended_procedding_status'] = $recommended_procedding_status;
		}
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	
	}//End of sell_candle_lalst_procedding_status

	public function is_virtual_barrier_sell($coin_symbol,$global_setting_arr,$rule_number,$current_market_price){
		
	
		$rule_on_off = 'sell_virtual_barrier_rule_'.$rule_number.'_enable';
		$rule_name =  'sell_virtural_rule_'.$rule_number;

	

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_quantity = $global_setting_arr[$rule_name];


			$_status_rule = '<span style="color:red">NO</span>';

			/* %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */

				$coin_offset_value = $this->mod_coins->get_coin_offset_value($coin_symbol);
				$coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);
				$total_bid_quantity = 0;
				for($i = 0;$i<$coin_offset_value;$i++){
					$new_last_barrrier_value = $current_market_price +($coin_unit_value*$i);	
					$bid = $this->mod_barrier_trigger->get_market_volume($new_last_barrrier_value,$coin_symbol,$type='ask');
					$total_bid_quantity += $bid;
				}//End of Coin off Set

			/* %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */


			if($total_bid_quantity >= $recommended_quantity){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}
		$log_arr['is_order_book_barrier_enable_'.$rule_number] = $_status_rule_color;

		if($_status_rule !='OFF'){
			$log_arr['calculated_quantity'] = $total_bid_quantity;
			$log_arr['recommended_quantity'] = $recommended_quantity;
		}

	

		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_score


	public function seller_vs_buyer($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){

			$current_seller_vs_buyer = $this->mod_barrier_trigger->get_buyer_vs_seller_rule($coin_symbol);

			$recommended_seller_vs_buyer = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if($current_seller_vs_buyer<=$recommended_seller_vs_buyer){
				$_status_rule = 'YES';
			}

		}//End of buy_status_rule_1_enable


		if($_status_rule  =='YES'){

			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['seller_vs_buyer_rule_'.$rule.'_buy_enable'] = $_status_rule_color;
		$log_arr['current_seller_vs_buyer'] = $current_seller_vs_buyer;
		$log_arr['recommended_seller_vs_buyer'] = $recommended_seller_vs_buyer;

		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of seller_vs_buyer
	public function sell_rule_trigger($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];

		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){

			$current_market_price  = $this->mod_dashboard->get_market_value($coin_symbol);
			$current_market_price  =  (float)$current_market_price;

			$current_barrier_status = $this->mod_barrier_trigger->get_current_barrier_status_up($coin_symbol,$current_market_price);

			$barrier_status = (array)$global_setting_arr[$rule_name];

			// echo '<pre>';
			// print_r($current_barrier_status);
			// print_r($barrier_status);
			

			$_status_rule = '<span style="color:red">NO</span>';
			$last_barrier_value = '';
			if(count($current_barrier_status)>0){
				foreach ($current_barrier_status as $row) {
					if(in_array($row['barrier_status'], $barrier_status)){
						$_status_rule = 'YES';
						$last_barrier_value = $row['barier_value']; 
						$log_arr['last_barrier_value'] = num($last_barrier_value);
						break;
					}
				}//End Of 
			}//End Of if Barrier is Greater

		}//End of buy_status_rule_1_enable

		//echo num($last_barrier_value);
		if($_status_rule  =='YES'){

		$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_trigger_status_sell_'.$rule.'_yes'] = $_status_rule_color;
		$log_arr['current_trigger_status'] = $current_barrier_status;
		$log_arr['Recommended_trigger_status'] = implode('--',$barrier_status);
	
	
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of buy_rule_trigger

	public function sell_rule_seven_level($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$seven_levele_pressure_value = $seven_levele_pressure = $this->mod_barrier_trigger->seven_level_pressure_sell($coin_symbol);
			$recommended_seven_levele_pressure_value = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if($seven_levele_pressure<=$recommended_seven_levele_pressure_value){
				$_status_rule = 'YES';
			}

		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){

		$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_seven_levele_pressure_sell_'.$rule] = $_status_rule_color;
		$log_arr['seven_levele_pressure_value'] = $seven_levele_pressure_value;
		$log_arr['recommended_seven_levele_pressure_value'] = $recommended_seven_levele_pressure_value;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of sell_rule_seven_level

	public function sell_rule_yellow_wall($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
				$closest_yelllow_bottom_wall_value = $this->mod_barrier_trigger->get_yellow_closet_wall($coin_symbol);
			$recommended_closest_yellow_wall = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if($closest_yelllow_bottom_wall_value<=$recommended_closest_yellow_wall){
				$_status_rule = 'YES';
			}

		}//End of buy_status_rule_1_enable	

		if($_status_rule  =='YES'){

		$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_big_yellow_closest_wall_sell_'.$rule] = $_status_rule_color;
		$log_arr['closest_yellow_bottom_wall_value'] = $closest_yelllow_bottom_wall_value;
		$log_arr['recommended_closest_yellow_wall_value'] = $recommended_closest_yellow_wall;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of sell_rule_yellow_wall

	public function sell_rule_black_wall($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$closest_black_bottom_wall_value = $this->mod_barrier_trigger->get_black_closet_wall($coin_symbol);
			$recommended_closest_black_wall = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if($closest_black_bottom_wall_value<=$recommended_closest_black_wall){
				$_status_rule = 'YES';
			}

		}//End of buy_status_rule_1_enable


		if($_status_rule  =='YES'){

		$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}


		$log_arr['is_big_black_closest_wall_sell_'.$rule] = $_status_rule_color;
		$log_arr['closest_black_wall_value'] = $closest_black_bottom_wall_value;
		$log_arr['recommended_closest_black_wall'] = $recommended_closest_black_wall;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of sell_rule_black_wall
	public function sell_rule_big_seller($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$ask_percent = $this->mod_barrier_trigger->sell_contract_percentage($coin_symbol);
			$recommended_percentage = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if($ask_percent>=$recommended_percentage){
				$_status_rule = 'YES';
			}

		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){

		$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_big_seller_sell_'.$rule] = $_status_rule_color;
		$log_arr['big_seller_percentage'] = $ask_percent;
		$log_arr['recommended_percentage'] = $recommended_percentage;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of sell_rule_big_seller

	public function sell_rule_down_pressure($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$current_down_pressure = $this->mod_barrier_trigger->pressure_calculate_from_coin_meta($coin_symbol);
			$recommended_pressure = $global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if($current_down_pressure <= $recommended_pressure){
				$_status_rule = 'YES';
			}


		}//End of buy_status_rule_1_enable

		$log_arr['is_down_pressure_sell_'.$rule] = $_status_rule;
		$log_arr['current_down_pressure'] = $current_down_pressure;
		$log_arr['recommended_down_pressure'] = $recommended_pressure;

		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of sell_rule_down_pressure

	public function sell_rule_barrier_volume($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$rule_number){
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		$current_market_price  = $this->mod_dashboard->get_market_value($coin_symbol);
			$current_market_price  =  (float)$current_market_price;
		if($_enable_disable_rule == 'yes'){
			
			$range_percentage = $global_setting_arr['range_previous_barrier_values'];


			///////////////////////////
			//////////////////////////////
			///////////////////////

			/////////////////Barrier Type ///////////////////////////

			$rule_on_off = 'sell_trigger_type_rule_'.$rule_number.'_enable';
		    $rule_name =  'sell_trigger_type_rule_'.$rule_number;


			$trigger_type = $this->sell_rule_trigger($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr);



			$trigger_type_log_arr = $trigger_type['log_arr'];

		

			
		

			$log_arr['Recommended_trigger_status'] = $trigger_type_log_arr['Recommended_trigger_status'];

			$log_arr['last_barrier_value'] = $trigger_type_log_arr['last_barrier_value'];
		
			
			$last_barrrier_value = $trigger_type_log_arr['last_barrier_value'];


			//////////////////////////
			//////////////////////
			///////////////


			$barrier_value_range = $last_barrrier_value-($last_barrrier_value/100)*$range_percentage;

			$log_arr['barrier_value_range'] = num($barrier_value_range);

			$log_arr['current_market_price'] = num($current_market_price);

			$meet_condition_for_sell = false;

			if((num($current_market_price) <= num($last_barrrier_value)) && (num($current_market_price) >= num($barrier_value_range))){
				$meet_condition_for_sell = true;
			}

			echo '$current_market_price'.$current_market_price;
			echo '<br>';
			var_dump($meet_condition_for_sell);
			//exit();

			if($meet_condition_for_sell){

				$coin_offset_value = $this->mod_coins->get_coin_offset_value($coin_symbol);
				$coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);

				$total_bid_quantity = 0;
				for($i = 0;$i<$coin_offset_value;$i++){
					$new_last_barrrier_value = '';
					$new_last_barrrier_value = $last_barrrier_value - ($coin_unit_value*$i);	
					$bid = $this->mod_barrier_trigger->get_market_volume($new_last_barrrier_value,$coin_symbol,$type='ask');
					$total_bid_quantity += $bid;
				}//End of Coin off Set

				$bid_quantity = $total_bid_quantity;
				$log_arr['ask_quantity'] = $bid_quantity;

				$rl_ = 'sell_volume_rule_'.$rule_number;

				$bid_volume = $global_setting_arr[$rl_];

				if($bid_quantity>=$bid_volume){
					$_status_rule = 'YES';
				}else{

					$_status_rule = '<span style="color:red">NO</span>';
				}
				
				$log_arr['Recommended_ask_quantity'] = $bid_volume;

			}else{
				$_status_rule = '<span style="color:red">NO</span>';
			}//End of Meet barrier
			

			
		}//End of enable disable rule

		$log_arr['is_ask_quantity_sell_'.$rule] = $_status_rule;

		
		if($_status_rule =='OFF'){
			/*#################################*/
			//IF barrier_not_Meet Then use virturl barrier
			$virtual_barrier_response = $this->is_virtual_barrier_sell($coin_symbol,$global_setting_arr,$rule_number,$current_market_price);
			$log_arr = (array_merge($log_arr,$virtual_barrier_response['log_arr']));

			$is_virtual_barrier = $virtual_barrier_response['success_message'];

			$_status_rule = $is_virtual_barrier;
		}//End Of Status Yes

	

		
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr; 
		$data['success_message'] = $_status_rule;
		return $data; 		
	}//End of sell_rule_barrier_volume

	public function sell_rule_status($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr){
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){

			$current_swing_point = $this->mod_barrier_trigger->get_current_swing_point($coin_symbol);
			$swing_status = (array)$global_setting_arr[$rule_name];

			$_status_rule = '<span style="color:red">NO</span>';
			if(in_array($current_swing_point, $swing_status)){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		$log_arr['is_swing_status_sell_'.$rule] = $_status_rule;
		$log_arr['current_swing_point'] = $current_swing_point;
		$log_arr['Recommended_swing_status'] = implode('--',$swing_status);
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of buy_status


	public function is_candle_type_sell($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_candle_type){
		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_candle_type = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if($last_candle_type==$recommended_candle_type){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['Candle_type_'.$rule.'_sell_enable'] = $_status_rule_color;
		$log_arr['last_candle_type'] = $last_candle_type;
		$log_arr['recommended_candle_type'] = $recommended_candle_type;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_candle_type


	public function is_rejection_candle_sell($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_candle_rejection_status){

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_last_rejection_candle = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if($last_candle_rejection_status==$recommended_last_rejection_candle){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_rejection_candle_'.$rule.'_sell_enable'] = $_status_rule_color;
		$log_arr['last_rejection_candle_type'] = $last_candle_rejection_status;
		$log_arr['recommended_rejection_candle_type'] = $recommended_last_rejection_candle;

		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_rejection_candle



	public function is_last_200_contracts_buy_vs_sell_rule($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_200_buy_vs_sell){

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_last_200_contracts_buy_vs_sell = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if($last_200_buy_vs_sell<=$recommended_last_200_contracts_buy_vs_sell){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_200_contracts_buy_vs_sell_'.$rule.'_sell_enable'] = $_status_rule_color;
		$log_arr['last_200_buy_vs_sell'] = $last_200_buy_vs_sell;
		$log_arr['recommended_last_200_contracts_buy_vs_sell'] = $recommended_last_200_contracts_buy_vs_sell;

		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_last_200_contracts_buy_vs_sell



	public function is_last_200_contracts_time_sell($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_200_time_ago){


		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_is_last_200_contracts_time = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			$last_200_time_ago_1 = (float)$last_200_time_ago;
			if($last_200_time_ago_1 <= $recommended_is_last_200_contracts_time){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_200_contracts_time'.$rule.'_sell_enable'] = $_status_rule_color;
		$log_arr['last_200_contracts_time'] = $last_200_time_ago;
		$log_arr['recommended_last_200_contracts_time'] = $recommended_is_last_200_contracts_time;

		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_last_200_contracts_time


	public function is_last_qty_buyers_vs_seller_sell($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_qty_buy_vs_sell){

		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_is_last_qty_buyers_vs_seller = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if($last_qty_buy_vs_sell <= $recommended_is_last_qty_buyers_vs_seller){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_qty_buyers_vs_seller'.$rule.'_sell_enable'] = $_status_rule_color;
		$log_arr['last_qty_buyers_vs_seller'] = $last_qty_buy_vs_sell;
		$log_arr['recommended_is_last_qty_buyers_vs_seller'] = $recommended_is_last_qty_buyers_vs_seller;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_last_qty_buyers_vs_seller


	public function is_last_qty_time_sell($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$last_qty_time_ago){


		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_last_qty_time = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			$last_qty_time_ago_1 = (float)$last_qty_time_ago;
			if($last_qty_time_ago_1 <= $recommended_last_qty_time){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_last_qty_time'.$rule.'_sell_enable'] = $_status_rule_color;
		$log_arr['is_last_qty_time'] = $last_qty_time_ago;
		$log_arr['recommended_last_qty_time'] = $recommended_last_qty_time;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}

		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_last_qty_time


	public function is_score_sell($coin_symbol,$rule,$rule_name,$rule_on_off,$global_setting_arr,$score){


		$_enable_disable_rule = $global_setting_arr[$rule_on_off];
		$_status_rule = 'OFF';
		if($_enable_disable_rule == 'yes'){
			$recommended_score = $global_setting_arr[$rule_name];
			$_status_rule = '<span style="color:red">NO</span>';
			if($score <= $recommended_score){
				$_status_rule = 'YES';
			}
		}//End of buy_status_rule_1_enable

		if($_status_rule  =='YES'){
			$_status_rule_color = '<span style="color:green">YES</span>';
		}else{
			$_status_rule_color = $_status_rule;
		}

		$log_arr['is_score'.$rule.'_sell_enable'] = $_status_rule_color;
		$log_arr['score'] = $score;
		$log_arr['recommended_score'] = $recommended_score;
		if(isset($_GET['setting'])){
			if($_GET['setting']=='onlyon')
			{
				if($_status_rule == 'OFF'){
					$log_arr = array();
				}
			}
		}
		
		$data['log_arr'] = $log_arr;
		$data['success_message'] = $_status_rule;
		return $data; 
	}//End of is_score

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           ////////////////////////////////
	////////////////////  Sell Order by stop loss  /////////////////////////////////
	////////////////////                           ////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function sell_orders_by_stop_loss($date='',$coin_symbol){

		$function_name = 'sell_orders_by_stop_loss';
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


		$created_date = date('Y-m-d G:i:s');
		$market_price = $this->mod_dashboard->get_market_value($coin_symbol);
		$market_price = (float)$market_price;
	
		//Check if market price is empty
		$this->mod_barrier_trigger->is_market_price_empty($market_price);
		
		$buy_orders_arr = $this->mod_barrier_trigger->get_stop_loss_orders($market_price,$coin_symbol);
	
	
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

			  
				if ($market_price <= $iniatial_trail_stop && $iniatial_trail_stop != '' && $is_sell_order_status_new) {


					//////////////////////////////
					//////////////////////////////
					$upd_data = array(
						'buy_order_binance_id' => $binance_order_id,
						'market_value' => (float)$market_price,
						'sell_price'=>(float) $sell_price,
						'modified_date' => $this->mongo_db->converToMongodttime($date),
					);

					$this->mongo_db->where(array('_id' => $order_id));
					$this->mongo_db->set($upd_data);
					$this->mongo_db->update('orders');



					if ($application_mode == 'live') {

						if($this->is_order_already_not_send($buy_orders_id)){

							$trading_ip = $this->mod_barrier_trigger->get_user_trading_ip($admin_id);
							//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
							$created_date = date('Y-m-d G:i:s');
							$htm = '<span style="color:red;    font-size: 14px;"><b>Stop Loss</b></span>';

							$log_msg = 'Order Send for Sell by '.$htm.' ON :<b>'.num($market_price).'</b> Price';
							$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'Sell_Price', $admin_id, $created_date);
						
							//%%%%%%%%%%%%%%% Target price %%%%%%%%%%% 
							$log_msg = 'Expected Stop Loss value : <b>'.num($iniatial_trail_stop).'</b> ';
							$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg,'Expected Stop Loss', $admin_id, $created_date);
							

							$log_msg = 'Send Market Orde for sell by Ip: <b>'.$trading_ip.'</b> ';
							$this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);
						
							$trigger_type = 'barrier_trigger';
							$this->mod_barrier_trigger->order_ready_for_sell_by_ip($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id,$trading_ip,$trigger_type,'sell_stop_loss_order');
						}//End of is already not send


						// $res = $this->mod_dashboard->binance_sell_auto_market_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id);

					} else {


						$upd_data_1 = array(
							'status' => 'FILLED',
							'market_value'=> (float)$market_price
						);
						$this->mongo_db->where(array('_id' => $order_id));
						$this->mongo_db->set($upd_data_1);
						//Update data in mongoTable
						$this->mongo_db->update('orders');
						$sell_price = $iniatial_trail_stop;
						$upd_data22 = array(
							'is_sell_order' => 'sold',
							'market_sold_price' => (float)$market_price,
							'modified_date' => $this->mongo_db->converToMongodttime($date),
							
						);

						$this->mongo_db->where(array('_id' => $buy_orders_id));
						$this->mongo_db->set($upd_data22);
						//Update data in mongoTable
						$this->mongo_db->update('buy_orders');
						//////////////////////////////////////////////////////////////////////////////
						////////////////////////////// Order History Log /////////////////////////////
						$message = 'Sell Order was Sold by stop_loss';
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
		//%%%%%%%%%%%% if function process complete %%%%%%%%%%%%%
		function_stop($function_name);
	}//End of sell_orders_by_stop_loss


	public function is_order_already_not_send($buy_orders_id){
		$buy_orders_id_obj = $this->mongo_db->mongoId($buy_orders_id);
		$this->mongo_db->where(array('buy_orders_id'=>$buy_orders_id_obj));
		$response = $this->mongo_db->get('ready_orders_for_sell_ip_based');
		$result = iterator_to_array($response);
		$resp = true;
		if(!empty($result)){
			$resp = false; 
		}
		return $resp;
	}//End of is_order_already_not_send


	///////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           ////////////////////////////////
	////////////////////  Calculate Barriers       /////////////////////////////////
	////////////////////                           ////////////////////////////////
	////////////////////                           /////////////////
	////////////////////                           /////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////


	public function lowest_barrier($coin){
		$start_date =date('Y-m-d H:00:00');
        $this->mongo_db->limit('5');
		$this->mongo_db->where(array('coin'=>$coin));
		$start_date1 = $this->mongo_db->converToMongodttime($start_date);
		$this->mongo_db->where_lt('timestampDate',$start_date1);
		$this->mongo_db->order_by(array('timestampDate'=>-1));
		$data_obj  = $this->mongo_db->get('market_chart');
		$data_row = iterator_to_array($data_obj);


		$low_value_arr   = array();
		$body_value_arr = array();
		if(count($data_row)>0){
			foreach ($data_row as $row) {
				array_push($low_value_arr, num($row['low']));
				if($row['open'] < $row['close']){
					array_push($body_value_arr, num($row['open']));
				}else{
					array_push($body_value_arr, num($row['close']));
				}
			}//End of for each
		}//if coutn is greater then 0



		$lowest_value_in_low_values = min($low_value_arr);
		$lowest_value_in_body_values = min($body_value_arr);

		$is_body_less = true;

		if(count($low_value_arr)>0){
			foreach ($low_value_arr as $low_value) {
				if($lowest_value_in_body_values<$low_value){
					$is_body_less = false;
					break;
				}
			}
		}

	
		$type = 'no_barrier';
		if($is_body_less){
			$boy_low_values = array();
			if(count($body_value_arr)>0){
				$index = 0;
				foreach ($body_value_arr as $body_values) {
					$low_value = $low_value_arr[$index];
					if($low_value == $body_values){
						array_push($boy_low_values,$low_value);
					}else if($low_value<$body_values){
						array_push($boy_low_values,$low_value);
					}else if($body_values<$low_value){
						array_push($boy_low_values,$body_values);
					}
					$index ++;	
				}//End of foreach
			}//End 

			$type = 'no_barrier';
			$number_of_values = array_count_values($boy_low_values);

			

			if(count($number_of_values)>0){
				foreach ($number_of_values as $value  =>$count) {
					if($count == 3){
						$type = 'weak_barrier';
						$barrier_value = $value;
					}else if($count == 4){
						$type = 'strong_barrier';
						$barrier_value = $value;
					}else if($count == 5){
						$type = 'very_strong_barrier';
						$barrier_value = $value;
					}
				}
			}//if count is greater then 0

			echo $type;

			if($type !='no_barrier' && $type !='very_strong_barrier'){
				$barrier_creation_date = date('Y-m-d g:i:s');
				$barrier_creation_date = $this->mongo_db->converToMongodttime($barrier_creation_date);

			$insert_arr = array('barier_value'=>(float)$barrier_value ,'coin'=>$coin,'human_readible_created_date'=>$start_date,'created_date'=>$start_date1,'barrier_type'=>'down','global_swing_parent_status'=>'HL','barrier_status'=>$type,'custom_barrier'=>'custom_barrier','status'=>0,'barrier_creation_date'=>$barrier_creation_date);
		
			$this->mongo_db->insert('barrier_values_collection',$insert_arr);

		

			
		}
		}//if body not Closed Below
	}//End of lowest_barrier

	public function highest_barrier($coin){
		$this->mongo_db->limit('5');
		$this->mongo_db->where(array('coin'=>$coin));
		$start_date =date('Y-m-d H:00:00');
		$start_date1 = $this->mongo_db->converToMongodttime($start_date);
		$this->mongo_db->where_lt('timestampDate',$start_date1);
		$this->mongo_db->order_by(array('timestampDate'=>-1));
		$data_obj  = $this->mongo_db->get('market_chart');
		$data_row = iterator_to_array($data_obj);

		$high_value_arr   = array();
		$body_value_arr = array();
		if(count($data_row)>0){
			foreach ($data_row as $row) {
				array_push($high_value_arr, num($row['high']));
				if($row['open'] > $row['close']){
					array_push($body_value_arr, num($row['open']));
				}else{
					array_push($body_value_arr, num($row['close']));
				}
			}//End of for each
		}//if coutn is greater then 0

		$highest_value_in_high_values = max($high_value_arr);
		$highest_value_in_body_values =  max($body_value_arr);



		$is_body_greater = true;

		if(count($high_value_arr)>0){
			foreach ($high_value_arr as $high_value) {
				if($highest_value_in_body_values>$high_value){
					$is_body_greater = false;
					break;
				}
			}
		}

		var_dump($is_body_greater);

		echo '---'.$is_body_greater;
		
	
		$type = 'no_barrier';
		if($is_body_greater){

			$boy_high_values = array();
			if(count($body_value_arr)>0){
				$index = 0;
				foreach ($body_value_arr as $body_values) {
					$high_value = $low_value_arr[$index];
					if($high_value == $body_values){
						array_push($boy_high_values,$high_value);
					}else if($high_value>$body_values){
						array_push($boy_high_values,$high_value);
					}else if($body_values>$high_value){
						array_push($boy_high_values,$body_values);
					}
					$index ++;	
				}//End of foreach
			}//End 

			
			$number_of_values = array_count_values($boy_high_values);

			
			
			if(count($number_of_values)>0){
				foreach ($number_of_values as $value  =>$count) {
					if($count == 3){
						$type = 'weak_barrier';
						$barrier_value = $value;
					}else if($count == 4){
						$type = 'strong_barrier';
						$barrier_value = $value;
					}else if($count == 5){
						$type = 'very_strong_barrier';
						$barrier_value = $value;
					}
				}
			}//if count is greater then 0

			if($type !='no_barrier' && $type !='very_strong_barrier'){

				$barrier_creation_date = date('Y-m-d g:i:s');
				$barrier_creation_date = $this->mongo_db->converToMongodttime($barrier_creation_date);

				$insert_arr = array('barier_value'=>(float)$barrier_value ,'coin'=>$coin,'human_readible_created_date'=>$start_date,'created_date'=>$start_date1,'barrier_type'=>'up','global_swing_parent_status'=>'LH','barrier_status'=>$type,'custom_barrier'=>'custom_barrier','status'=>0,'barrier_creation_date'=>$barrier_creation_date);
				$this->mongo_db->insert('barrier_values_collection',$insert_arr);
				

				
			}

		}//if body not Closed Below
	}//End of highest_barrier

	public function run_crone_for_save_trigger_type(){
		$all_coins_arr = $this->mod_sockets->get_all_coins();
		if (count($all_coins_arr) > 0) {
			foreach ($all_coins_arr as $data) {
				$coin_symbol = $data['symbol'];
				echo $coin_symbol.'<br>';

				$this->lowest_barrier($coin_symbol);
				$this->highest_barrier($coin_symbol);
			}
		}	
	}//End of run_crone_for_save_trigger_type


	public function get_candle_range_between_dates($start_date,$coin,$high_swing_point){
		$end_date = date('Y-m-d H:00:00');
		$start_date_obj = $start_date;
		$to_date_object = $this->mongo_db->converToMongodttime($end_date);
		$this->mongo_db->where_gt('timestampDate', $start_date_obj);
		$this->mongo_db->where_lt('timestampDate', $to_date_object);
		$this->mongo_db->where('coin',$coin);
		$this->mongo_db->order_by(array('timestampDate'=>1));
		$current_candel_result = $this->mongo_db->get('market_chart');
		$current_candel_arr = iterator_to_array($current_candel_result);

		$is_high_blue = false;
		$compare_high_point = '';
		if(!empty($current_candel_arr)){
			foreach ($current_candel_arr as $row) {
				$current_high_point = $row['high'];
				if($current_high_point > $high_swing_point){
					$compare_high_point = $current_high_point;
					$is_high_blue = true;
					break;
				}

			}//End of foreach
		}//End of Not Empty
		var_dump($is_high_blue);
		exit();
		echo '<pre>';
		print_r($current_candel_arr);
	}//End of get_candle_range_between_dates

	public function is_previous_candle_is_blue(){
	
		$response = false;
		if(!empty($current_candel_arr)){
			$current_candel_arr = $current_candel_arr[0];
			$current_open = $current_candel_arr['open'];
			$current_close = $current_candel_arr['close'];

			if($current_open<$current_close){
				$response = true;
			}else{
				$prevouse_date = date('Y-m-d H:00:00', strtotime('-2 hour'));
				$timestampDate = $this->mongo_db->converToMongodttime($prevouse_date);
				$this->mongo_db->where(array('timestampDate' => $timestampDate, 'coin'=>$coin_symbol));
				$prevouse_candel_result = $this->mongo_db->get('market_chart');
				$prevouse_candel_arr = iterator_to_array($prevouse_candel_result);

				if(!empty($prevouse_candel_arr)){

					$prevouse_candel_arr = $prevouse_candel_arr[0];
					$prevouse_close = $prevouse_candel_arr['close'];


					if($current_open>=$prevouse_close){
						$response = true;
					}
				}//End of previous not empty
				

			}//End of else

		}//if array not empty

		return $response;
	}//End of is_previous_candle_is_blue

	public function sell_order($id=''){

		$this->mongo_db->where(array('_id'=>$id));
		$row = $this->mongo_db->get('orders');
		$data = iterator_to_array($row);
		echo '<pre>';
		print_r($data);
	}

	public function buy_order($id=''){
		$this->mongo_db->where(array('_id'=>$id));
		$row = $this->mongo_db->get('buy_orders');
		$data = iterator_to_array($row);
		echo '<pre>';
		print_r($data);
	}

	public function update_barrier_status(){
		$all_coins_arr = $this->mod_sockets->get_all_coins();
		if (count($all_coins_arr) > 0) {
			foreach ($all_coins_arr as $data) {
				$coin_symbol = $data['symbol'];
				$this->update_barrier_status_run($coin_symbol);
			}//End 
		}	
	}//End of update_barrier_status

	public function update_barrier_status_run($coin_symbol='NCASHBTC'){

		$this->mongo_db->order_by(array('created_date' => -1));
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('coin' => $coin_symbol, 'barrier_type' => 'down', 'barrier_status' => 'very_strong_barrier'));
		$responseobj = $this->mongo_db->get('barrier_values_collection');
		$responseArr = iterator_to_array($responseobj);

		$min_arr = array();

		
		$barrier_min_val = '';
		if(!empty($responseArr)){
			$barrier_date = $responseArr[0]['created_date'];
			$barrier_min_val = $responseArr[0]['barier_value'];
			$barrir_obj_id = $responseArr[0]['_id'];
			//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
				$this->mongo_db->where_gt('timestampDate', $barrier_date);
				$this->mongo_db->where(array('coin'=>$coin_symbol));
				$data = $this->mongo_db->get('market_chart');

				$row  = iterator_to_array($data);
				foreach ($row as $rwo_1) {
					array_push($min_arr,$rwo_1['open']);
					array_push($min_arr,$rwo_1['close']);
				}
		
			//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		}
		
	
		$min_value = min($min_arr);

		if($min_value<$barrier_min_val){
			$created_date = date('Y-m-d G:i:s');
			$created_date_obj = $this->mongo_db->converToMongodttime($created_date);
			$upd_arr = array('barrier_status'=>'strong_barrier','updated_reason'=>'due to the low value after the barrier value','updated_date'=>$created_date_obj);
			$this->mongo_db->where(array('_id'=>$barrir_obj_id));
			$this->mongo_db->set($upd_arr);
			$res = $this->mongo_db->update('barrier_values_collection');
			var_dump($res);
		}
	}//End of update_barrier_status_run


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

	//%%%%%%%%%%%% --- delete_process_completion_old_recode - %%%%%%%%%%%	
	public function delete_process_completion_old_recode(){
		$date = date('Y-m-d H:i:s',strtotime('-10 minutes'));
		$created_date = $this->mongo_db->converToMongodttime($date);
		$db = $this->mongo_db->customQuery();
		$search['start_date'] = array('$lte'=>$created_date);
		$response = $db->function_process_completion_time->deleteMany($search);

		$created_date = $this->mongo_db->converToMongodttime($date);
		$db = $this->mongo_db->customQuery();
		$search['stop_date'] = array('$lte'=>$created_date);
		$response = $db->function_process_completion_time->deleteMany($search);
	}//End of delete_process_completion_old_recode

	public function proxy_ip_test($value='')
	{

		//CURLOPT_URL => 'https://api.binance.com/api/v3/ticker/price',
		$ip = '207.180.198.49:8888'; //put your proxy here

		$proxy = '50.28.36.49';

		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,

		//CURLOPT_HTTPHEADER, array("REMOTE_ADDR: $proxy", "HTTP_X_FORWARDED_FOR: $proxy"),
		CURLOPT_INTERFACE=>$proxy ,

		CURLOPT_URL => 'http://207.180.198.49/admin/script_test',
		//CURLOPT_PROXY=>$proxy,
		CURLOPT_USERAGENT => 'User-Agent: Mozilla/4.0 (compatible; PHP Binance API)\r\n'
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);

		if (curl_error($curl)) {
			$error_msg = curl_error($curl);

			echo '*************************';
			print_r($error_msg);
		}

		$info = curl_getinfo($curl);

		var_dump($resp);

		echo '<pre>';
		print_r($info);

		// echo '<pre>';
		print_r(json_decode($resp));
		// Close request to clear up some resources
		curl_close($curl);
	}//End of run_1

	

	public function run(){

		$symbol = 'EOSBTC';
		$user_id = 1;
		$orders_history = $this->binance_api->get_all_orders_history($symbol, $user_id);
		echo '<pre>';
		print_r($orders_history);

	}//End of function 


} //En of controller

		