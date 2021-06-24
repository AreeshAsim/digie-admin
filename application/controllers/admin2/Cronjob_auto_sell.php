<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob_auto_sell extends CI_Controller {

	public function __construct(){

		parent::__construct();

		// Load Modal
		$this->load->model('admin/mod_dashboard');

	}




	public function run_cron(){
    echo 'start'.date('Y-m-d H:i:s').'<br>';
    //Call function at the start of function 
		$function_name = 'run_cron';
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

    //Get Orders
    $this->mongo_db->where(array('status'=> 'new','trigger_type'=> 'no'));
    $this->mongo_db->sort(array('_id'=> 'desc'));
    $responseArr = $this->mongo_db->get('orders');

    foreach ($responseArr as  $valueArr) {

      if(!empty($valueArr)){

        $id = $valueArr['_id'];
        $symbol = $valueArr['symbol'];
        $quantity = $valueArr['quantity'];
        $trail_check = $valueArr['trail_check'];
        $trail_interval = num($valueArr['trail_interval']);
        $sell_trail_price = num($valueArr['sell_trail_price']);
        $sell_price = num($valueArr['sell_price']);
        $purchased_price = num($valueArr['purchased_price']);

        $stop_loss = $valueArr['stop_loss'];
        $loss_percentage = $valueArr['loss_percentage'];

        $order_type = $valueArr['order_type'];
        $status = $valueArr['status'];
        $user_id = $valueArr['admin_id'];
        $buy_order_id = $valueArr['buy_order_id'];
        $application_mode = $valueArr['application_mode'];

        //Get Market Price
        $market_value = $this->mod_dashboard->get_market_value($symbol);

        if($market_value !="" && $market_value >0){

          ////////////////////////////////////////////////////////////
          if($trail_check =='yes'){

              ////////////////////// Trial Section /////////////////////
              if($market_value > num($sell_trail_price + $trail_interval) ){

                $new_trial_price = num($market_value - $trail_interval);

                //Update New Trial Price
                $this->mod_dashboard->update_trail_price($id,$sell_trail_price,$new_trial_price,$buy_order_id,$user_id);

              }

              if($market_value < $sell_trail_price){

                if($market_value > $sell_price){

                  if($status =='new'){

                      if($order_type =='market_order'){

                          if($application_mode =='live'){

                            //Auto Sell Binance Market Order Live
                            $this->mod_dashboard->binance_sell_auto_market_order_live($id,$quantity,$market_value,$symbol,$user_id,$buy_order_id);

                          }else{

                            //Auto Sell Binance Market Order Test
                            $this->mod_dashboard->binance_sell_auto_market_order_test($id,$quantity,$market_value,$symbol,$user_id,$buy_order_id);
                          }

                      }else{


                          if($application_mode =='live'){

                            //Auto Buy Binance Limit Order Live
                            $this->mod_dashboard->binance_sell_auto_limit_order_live($id,$quantity,$market_value,$symbol,$user_id,$buy_order_id);

                          }else{

                            //Auto Buy Binance Limit Order Test
                            $this->mod_dashboard->binance_sell_auto_limit_order_test($id,$quantity,$market_value,$symbol,$user_id,$buy_order_id);
                          }
                      }

                  }//end if status is new

                }
              }
              ////////////////// End Trial Section /////////////////////

          }else{

              //Here is goto Auto Sell
              if($market_value >= $sell_price){

                  if($status =='new'){

                      if($order_type =='market_order'){

                          if($application_mode =='live'){

                            //Auto Sell Binance Market Order Live
                            $this->mod_dashboard->binance_sell_auto_market_order_live($id,$quantity,$market_value,$symbol,$user_id,$buy_order_id);

                          }else{

                            //Auto Sell Binance Market Order Test
                            $this->mod_dashboard->binance_sell_auto_market_order_test($id,$quantity,$market_value,$symbol,$user_id,$buy_order_id);
                          }

                      }else{

                          if($application_mode =='live'){

                            //Auto Buy Binance Limit Order Live
                            $this->mod_dashboard->binance_sell_auto_limit_order_live($id,$quantity,$market_value,$symbol,$user_id,$buy_order_id);

                          }else{

                            //Auto Buy Binance Limit Order Test
                            $this->mod_dashboard->binance_sell_auto_limit_order_test($id,$quantity,$market_value,$symbol,$user_id,$buy_order_id);
                          }
                      }

                  }//end if status is new

              }
              //End Auto Sell

          }
          ////////////////////////////////////////////////////////////


          //////////////////////// Stop Losss Section ////////////////
          if($stop_loss =='yes'){

            $current_data = num($purchased_price - $market_value);
            $market_data = ($current_data * 100 / $market_value);

            $market_percentage = number_format((float)$market_data, 2, '.', '');

            if($market_percentage >= $loss_percentage){

                if($status =='new'){

                  if($application_mode =='live'){

                    //Auto Buy Binance Market Order Live

										$is_step = $this->is_stepSize($symbol);

										if ($is_step == 'true') {
											$quantity = floor($quantity);
										}
                    $this->mod_dashboard->binance_sell_auto_market_order_live($id,$quantity,$market_value,$symbol,$user_id,$buy_order_id);

                  }else{

                    //Auto Buy Binance Market Order Test
                    $this->mod_dashboard->binance_sell_auto_market_order_test($id,$quantity,$market_value,$symbol,$user_id,$buy_order_id);
                  }
                }
            }

          }
          //////////////////////// End Stop Losss Section ////////////


        }//End if Market Value not empty


      }//end if

    }//end for
    //%%%%%%%%%%%% if function process complete %%%%%%%%%%%%%
		function_stop($function_name);
    echo 'End of '.date('Y-m-d H:i:s').'<br>';
  }//end index

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


}
