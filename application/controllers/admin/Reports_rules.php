<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Reports_rules extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //load main template
        ini_set("memory_limit", -1);
        //ini_set("display_errors", E_ALL);
        //error_reporting(E_ALL);
        $this->stencil->layout('admin_layout');
        //load required slices
        $this->stencil->slice('admin_header_script');
        $this->stencil->slice('admin_header');
        $this->stencil->slice('admin_left_sidebar');
        $this->stencil->slice('admin_footer_script');
        //load models
        $this->load->model('admin/mod_rulesorder');
        $this->load->model('admin/mod_reports_rules');
        $this->load->model('admin/mod_dashboard');
        $this->load->model('admin/mod_coins');
        $this->load->model('admin/mod_login');
        $this->load->model('admin/mod_buy_orders');
        if ($this->session->userdata('user_role') != 1) {
            //redirect(base_url() . 'forbidden');
        }
    }

    // public function reports_rules_listing()
    // {
		
    //     $this->mod_login->verify_is_admin_login();
    //     if ($this->input->post()) {
    //         $data_arr['filter_order_data'] = $this->input->post();
    //         $this->session->set_userdata($data_arr);
    //     }
    //     // Get Percentile trigger Report Listings
    //     $percentile_trigger_report    = $this->mod_reports_rules->percentile_trigger_report($this->input->post());
    //     $data['percentile_trigger_report_Arr']                = $percentile_trigger_report[0];
		
		
		 
	//     //echo "<pre>";  print_r($percentile_trigger_report); exit;
		
		
		
		
    //     $coins_listings               = $this->mod_coins->get_all_coins();
    //     $data['coins_listings']       = $coins_listings;
    //     //$data['options'] = $option_arr;
    //     $this->stencil->paint('admin/reports_rules/reports_rules', $data);
    // }
    // public function cron_rules_report()
    // {
        
	// 	//======================================================================
    //     // Check Which coin need to run in Cron job 
    //     //======================================================================
    //     $symbol          = $this->mod_reports_rules->getRuningCoinName();
    //     $global_mode     = 'live';
    //     $order_level_arr = array(
    //         'level_1',
    //         'level_2',
    //         'level_3',
    //         'level_4',
    //         'level_5',
    //         'level_6',
    //         'level_7',
    //         'level_8',
    //         'level_9',
    //         'level_10'
    //     );
    //     $target_profit   = 1;
    //     $target_stoploss = 1;
		
    //     $trigger_type    = 'barrier_percentile_trigger'; // barrier_percentile_trigger  //barrier_trigger
    //     $start_date      = date("Y-m-d H:00:00", strtotime('-12 hour'));
	// 	$end_date        = date("Y-m-d H:00:00",strtotime('-8 hour'));
      
		
	// 	$date1           = new DateTime($start_date);
    //     $date2           = new DateTime($end_date);
    //     $diff            = $date2->diff($date1);
    //     $hours           = $diff->h;
    //     $hours           = $hours + ($diff->days * 24);
    //     $total_days      = $diff->days;
    //     $d1              = $start_date;
    //     $symbol          = 'NEOBTC';
	// 	$coin_symbol     = $symbol;
    //     $date_range_hour = array();
	// 	$log_msg_success = '';
   
	// 	for ($i = 0; $i <= $hours; $i++) { // Hoursly loop
	// 		$start_date        = date("Y-m-d H:00:00", strtotime("+" . $i . " hours", strtotime($d1)));
	// 		$end_date          = date("Y-m-d H:59:59", strtotime("+" . ($i) . " hours", strtotime($d1)));
	// 		//$fianlArr  = $this->go_buy_and_sell_cron_job($symbol,$start, $move);
	// 		///******************************************************************************************** New code Goe sherer *********************************************************************** //
			
	// 		$simulator_date    = date('Y-m-d H:00:00', strtotime($start_date));
	// 		$coin_meta_arr_all = $this->mod_reports_rules->list_historical_coin_meta($coin_symbol, $start_date, $end_date);
	// 		$finalarr          = array();
	// 		foreach ($coin_meta_arr_all as $coin_meta_arr) {
	// 			//%%%%%%%%%%%%%%%%%%% -- Coin Meta Hourly percentile in  --%%%%%%%%%%%%%%%%%%%%%%%
	// 			$coin_meta_hourly_arr = $this->mod_reports_rules->list_hourly_percentile_coin_meta_history($coin_symbol, $simulator_date);
	// 			//Get simulator values
	// 			if (!empty($coin_meta_arr)) {
	// 				$current_market_price = $coin_meta_arr['current_market_value'];
	// 				if ($current_market_price == '' || $current_market_price == 0) {
	// 					return false;
	// 				}
	// 				foreach ($order_level_arr as $order_level) {
	// 					$global_setting_arr = $this->mod_reports_rules->triggers_setting('barrier_percentile_trigger', 'live', $coin_symbol, $order_level);
	// 					if ($global_setting_arr) {
	// 						$level         = $order_level;
	// 						$is_rules_true = $this->mod_reports_rules->is_triggers_qualify_to_buy_orders_new($coin_symbol, $order_level, $global_setting_arr, $current_market_price, $coin_meta_arr, $coin_meta_hourly_arr, 
	// 						$simulator_date);
	// 						if ($is_rules_true['success_message'] == 'YES') {
	// 							if (!array_key_exists($coin_meta_arr['modified_date']->toDatetime()->format("Y-m-d H:00:00"), $date_range_hour)) {
	// 								$date_range_hour[$coin_meta_arr['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['market_value'] = $coin_meta_arr['current_market_value'];
	// 								$date_range_hour[$coin_meta_arr['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['market_time']  = $coin_meta_arr['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 								//$date_range_hour[$coin_meta_arr['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['barrier_value'] = $barrier_val;
	// 								$ins_data           = array(
	// 									'coin'                 => $this->db->escape_str(trim($coin_symbol)),
	// 									'level'                => $this->db->escape_str(trim($level)),
	// 									'market_value'         => $coin_meta_arr['current_market_value'],
	// 									'market_time'          => $coin_meta_arr['modified_date']->toDatetime()->format("Y-m-d H:i:s"),
	// 									'market_time_second'   => $coin_meta_arr['modified_date'],
	// 									'lookup_period'        => 72,
	// 									'status'               => 0,
	// 									'profit'               => 1,
	// 									'loss'                 => 2,
	// 								);
	// 								//Insert the record into the database.
	// 								$this->db->dbprefix('percentile_trigger_report');
	// 								$ins_into_db = $this->mongo_db->insert('percentile_trigger_report', $ins_data);
	// 							}
	// 						}
	// 					}
	// 				}
	// 			}
	// 		} //End of historical_data
	// 	}
    // }
	
	// public function second_cronjob(){
		
		  
		  
	// 	$this->mongo_db->order_by(array('market_time' => 1));
	// 	$this->mongo_db->limit(20);
	// 	$percentile_trigger_report = $this->mongo_db->get('percentile_trigger_report');
    //     $date_range_hour = iterator_to_array($percentile_trigger_report);
		 
	// 		$positive = 0;
	// 		$negitive = 0;
	// 		$winp = 0;
	// 		$losp = 0;
	// 		$retArr = array();
	// 		foreach ($date_range_hour as $key => $value) {
				
				
	// 			echo "<pre>";  print_r($value); 
			
				
				
    //             $symbol       = $value['coin'];
	// 			$market_value = $value['market_value'];
	// 			$market_time  = $value['market_time'];
	// 			echo 'market_timeKey '.$market_timeKey = $value['market_time'];
	// 			echo "<br />";
	// 			$deep_price_check = $data_arr['deep_price_check'];
	// 			$deep_price_lookup_in_hours = $data_arr['deep_price_lookup_in_hours'];
	// 			$opp_chk         = $data_arr['opp_chk'];
	// 			$target_profit   = $data_arr['profit'];
	// 			$target_stoploss = $data_arr['loss'];
	// 			$data_arr['lookup_period']  = 3;

	// 			if ($opp_chk == 'yes') {
	// 				$is_opp_arr = $this->check_real_oppurtunity($market_value, $market_time, $deep_price_check, $deep_price_lookup_in_hours, $symbol, $opp_chk);

	// 				$profit_time_ago = '';
	// 				$los_time_ago = '';
	// 				$loss = 0;
	// 				$profit = 0;
	// 				$market_value = $value['market_value'];
	// 				$market_time = $value['market_time'];
	// 				$barrier = $value['barrier_value'];
	// 				$deep_price = $market_value - ($market_value / 100) * $deep_price_check;
					
	// 				if (!empty($is_opp_arr)) {
	// 					$timep = $is_opp_arr['modified_date']->toDateTime()->format("Y-m-d H:i:s");
	// 					$sell_price = $is_opp_arr['current_market_value'] + ($is_opp_arr['current_market_value'] * $target_profit) / 100;
	// 					$iniatial_trail_stop = $is_opp_arr['current_market_value'] - ($is_opp_arr['current_market_value'] / 100) * $target_stoploss;
	// 					$where['coin'] = $symbol;
	// 					$where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($timep);
	// 					$where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $deep_price_lookup_in_hours . " hours", strtotime($timep))));
	// 					$where['current_market_value']['$gte'] = (float) $sell_price;
	// 					$queryHours = [
	// 						['$match' => $where],
	// 						['$sort' => ['modified_date' => 1]],
	// 						['$limit' => 1],
	// 					];

	// 					$db = $this->mongo_db->customQuery();
	// 					$response = $db->coin_meta_history->aggregate($queryHours);
	// 					$row = iterator_to_array($response);
	// 					$profit = 0;
	// 					$profit_date = "";
	// 					if (!empty($row)) {
	// 						$percentage = (($row[0]['current_market_value'] - $is_opp_arr['current_market_value']) / $row[0]['current_market_value']) * 100;
	// 						$profit = number_format($percentage, 2);
	// 						$profit_date = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 					}

	// 					$where1['coin'] = $symbol;
	// 					$where1['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
	// 					$where1['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));

	// 					$where1['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

	// 					$queryHours1 =
	// 						[
	// 						['$match' => $where1],
	// 						['$sort' => ['modified_date' => 1]],
	// 						['$limit' => 1],
	// 					];

	// 					// $this->mongo_db->where($where);
	// 					// $get = $this->mongo_db->get('coin_meta_history');
	// 					$db = $this->mongo_db->customQuery();
	// 					$response1 = $db->coin_meta_history->aggregate($queryHours1);
	// 					$row1 = iterator_to_array($response1);
	// 					$loss = 0;
	// 					$loss_date = 0;
	// 					if (!empty($row1)) {
	// 						$percentage = (($row1[0]['current_market_value'] - $is_opp_arr['current_market_value']) / $row1[0]['current_market_value']) * 100;
	// 						$loss = number_format($percentage, 2);
	// 						$loss_date = $row1[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 					}
	// 					$retArr[$key]['market_value'] = num($market_value);
	// 					$retArr[$key]['market_time'] = $market_time;
	// 					$retArr[$key]['barrier'] = num($barrier);
	// 					if (!empty($profit_date)) {
	// 						$profit_time_ago = $this->time_elapsed_string_min($profit_date, $key); //0
	// 						$retArr[$key]['proft_test_ago'] = $profit_time_ago;
	// 						$retArr[$key]['profit_time'] = $this->time_elapsed_string($profit_date, $key);
	// 						$retArr[$key]['profit_percentage'] = $profit;
	// 						$retArr[$key]['profit_date'] = $profit_date;
	// 					}
	// 					if (!empty($loss_date)) {
	// 						$los_time_ago = $this->time_elapsed_string_min($loss_date, $key);
	// 						$retArr[$key]['los_test_ago'] = $los_time_ago;
	// 						$retArr[$key]['loss_time'] = $this->time_elapsed_string($loss_date, $key);
	// 						$retArr[$key]['loss_percentage'] = $loss;
	// 						$retArr[$key]['loss_date'] = $loss_date;
	// 					}

	// 					// if (!empty($profit_time_ago) && !empty($los_time_ago)) {

	// 					//     if (($profit_time_ago > $los_time_ago)) {
	// 					//         $retArr[$key]['message'] = "Got Loss";
	// 					//     } else if (($profit_time_ago < $los_time_ago)) {
	// 					//         $retArr[$key]['message'] = "Got Profit";
	// 					//     } else {
	// 					//         continue;
	// 					//     }
	// 					// }

	// 					if ($los_time_ago == '' && $profit_time_ago == '') {
	// 						$retArr[$key]['message'] = '';
	// 					}
	// 					if ($los_time_ago != '' && $profit_time_ago == '') {
	// 						$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
	// 						$negitive++;
	// 						$losp += $retArr[$key]['loss_percentage'];
	// 					}
	// 					if ($los_time_ago == '' && $profit_time_ago != '') {
	// 						$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
	// 						$positive++;
	// 						$winp += $retArr[$key]['profit_percentage'];
	// 					}
	// 					if ($los_time_ago != '' && $profit_time_ago != '') {
	// 						if (($profit_time_ago > $los_time_ago)) {
	// 							$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
	// 							$negitive++;
	// 							$losp += $retArr[$key]['loss_percentage'];
	// 						} else if (($profit_time_ago < $los_time_ago)) {
	// 							$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
	// 							$positive++;
	// 							$winp += $retArr[$key]['profit_percentage'];
	// 						} else {
	// 							continue;
	// 						}
	// 					}

	// 				} else {
	// 					//$retArr[$key]['message'] = '<span class="text-warning">Opportunities doesnot exist in deep range</span>';
	// 				}

	// 			} else {

	// 				$profit_time_ago = '';
	// 				$los_time_ago = '';
	// 				$loss = 0;
	// 				$profit = 0;

	// 				$market_value = $value['market_value'];
	// 				echo 'market_time '.$market_time = $value['market_time'];  
	// 				echo "<br />";
					
	// 				$market_timeKey = $value['market_time'];
	// 				$barrier = $value['barrier_value'];
	// 				$sell_price = $value['market_value'] + ($value['market_value'] * $target_profit) / 100;
	// 				$iniatial_trail_stop = $value['market_value'] - ($value['market_value'] / 100) * $target_stoploss;
	// 				$where['coin'] = $symbol;
	// 				$where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
					
	// 				$where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));
					
	// 				$where['current_market_value']['$gte'] = (float) $sell_price;

	// 				$queryHours = [
	// 					['$match' => $where],
	// 					['$sort' => ['modified_date' => 1]],
	// 					['$limit' => 1],
	// 				];

	// 				$db = $this->mongo_db->customQuery();
	// 				$response = $db->coin_meta_history->aggregate($queryHours);
	// 				$row = iterator_to_array($response);
					
					
	// 			   echo "<pre>";  print_r($row);
				
				
	// 				$profit = 0;
	// 				$profit_date = "";
	// 				if (!empty($row)) {
	// 					$percentage = (($row[0]['current_market_value'] - $value['market_value']) / $row[0]['current_market_value']) * 100;
	// 					$profit = number_format($percentage, 2);
	// 					echo 'herere '.$profit_date = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 					echo "<br />";
						
	// 				}

	// 				$where1['coin'] = $symbol;
	// 				$where1['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
	// 				$where1['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));

	// 				$where1['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

	// 				$queryHours1 =
	// 					[
	// 					['$match' => $where1],
	// 					['$sort' => ['modified_date' => 1]],
	// 					['$limit' => 1],
	// 				];

	// 				// $this->mongo_db->where($where);
	// 				// $get = $this->mongo_db->get('coin_meta_history');
	// 				$db = $this->mongo_db->customQuery();
	// 				$response1 = $db->coin_meta_history->aggregate($queryHours1);
	// 				$row1 = iterator_to_array($response1);
				      
					 
				
	// 				$loss = 0;
	// 				$loss_date = 0;
	// 				if (!empty($row1)) {
						
	// 					$percentage = (($row1[0]['current_market_value'] - $value['market_value']) / $row1[0]['current_market_value']) * 100;
	// 					$loss = number_format($percentage, 2);
	// 					$loss_date = $row1[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
						
	// 				}
	// 				$retArr[$key]['market_value'] = num($market_value);
	// 				$retArr[$key]['market_time'] = $market_time;
	// 				$retArr[$key]['barrier'] = num($barrier);
	// 				if (!empty($profit_date)) {
	// 					echo "profit_date" .$profit_date;
	// 					echo "<br />";
						
	// 					echo "market_timeKey ".$market_timeKey;
	// 					echo "<br />";
	// 					exit;
						
	// 					$profit_time_ago = $this->time_elapsed_string_min($profit_date, $market_timeKey); //0  // $market_timeKey  this date should be now  
						
	// 					//0 //$profit_date //2019-05-22 14:31:12     ///$key; //2019-05-22 12:00:00
						
	// 					echo 'profit_time_ago '.$profit_time_ago;
	// 					echo "<br />";
	// 					$retArr[$key]['proft_test_ago'] = $profit_time_ago;
	// 					$retArr[$key]['profit_time'] = $this->time_elapsed_string($profit_date, $market_timeKey);
	// 					$retArr[$key]['profit_percentage'] = $profit;
	// 					$retArr[$key]['profit_date'] = $profit_date;
	// 				}
					
					
	// 				exit;
	// 				echo "sssss";
	// 				if ($loss_date!='') {
						
	// 					echo "wale";
	// 					$los_time_ago = '';//$this->time_elapsed_string_min($loss_date, $key);
	// 					$retArr[$key]['los_test_ago'] = $los_time_ago;
	// 					$retArr[$key]['loss_time'] = $this->time_elapsed_string($loss_date, $market_timeKey);
	// 					$retArr[$key]['loss_percentage'] = $loss;
	// 					$retArr[$key]['loss_date'] = $loss_date;
	// 				}

	// 				if ($los_time_ago == '' && $profit_time_ago == '') {
	// 					echo "555";
	// 					$retArr[$key]['message'] = '';
	// 				}
	// 				if ($los_time_ago != '' && $profit_time_ago == '') {
	// 					echo "444";
	// 					$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
	// 					$negitive++;
	// 					$losp += $retArr[$key]['loss_percentage'];
	// 				}
	// 				if ($los_time_ago == '' && $profit_time_ago != '') {
	// 					echo "333";
	// 					$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
	// 					$positive++;
	// 					$winp += $retArr[$key]['profit_percentage'];
	// 				}
	// 				if ($los_time_ago != '' && $profit_time_ago != '') {
	// 					echo "222";
	// 					if (($profit_time_ago > $los_time_ago)) {
	// 						$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
	// 						$negitive++;
	// 						$losp += $retArr[$key]['loss_percentage'];
	// 					} else if (($profit_time_ago < $los_time_ago)) {
	// 						$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
	// 						$positive++;
	// 						$winp += $retArr[$key]['profit_percentage'];
	// 					} else {
	// 						continue;
	// 					}
	// 				}
	// 			}
	// 		}
	// 		echo "<pre>";  print_r($retArr); exit;
			 
	// 		$winning_profit = $winp;
	// 		$losing_profit  = $losp;
	// 		$total_profit   = $winning_profit + $losing_profit;
	// 		$total_per_trade = $total_profit / (count($date_range_hour));
	// 		$total_per_day = $total_profit / $total_days;
			
	// 		$data['winners'] = $winning_profit;
	// 		$data['losers']  = $losing_profit;
	// 		$data['total_profit'] = $total_profit;
	// 		$data['per_trade']    = number_format($total_per_trade, 2);
	// 		$data['per_day']      = number_format($total_per_day, 2);

	// 		$data['final'] = $retArr;
	// 		$data['count_msg'] = count($date_range_hour);
	// 		$data['positive_msg'] = $positive;
	// 		$data['negitive_msg'] = $negitive;
	// 		$data['positive_percentage'] = number_format(($positive / ($positive + $negitive) * 100), 2);
	// 		$data['negitive_percentage'] = number_format(($negitive / ($positive + $negitive) * 100), 2);
	// 		$log_data = array(
	// 			'settings' => $data_arr,
	// 			'symbol' => $symbol,
	// 			'winning' => $positive,
	// 			'losing' => $negitive,
	// 			'win_per' => ($positive / ($positive + $negitive) * 100),
	// 			'lose_per' => ($negitive / ($positive + $negitive) * 100),
	// 			'total' => count($date_range_hour),
	// 			'result' => $retArr,
	// 			'created_date' => $this->mongo_db->converToMongodttime($start_date),
	// 			'end_date' => $this->mongo_db->converToMongodttime($end_date),
	// 		);

	// 		$log_data['winners'] = $winning_profit;
	// 		$log_data['losers'] = $losing_profit;
	// 		$log_data['total_profit'] = $total_profit;
	// 		$log_data['per_trade'] = $total_per_trade;
	// 		$log_data['per_day'] = $total_per_day;
	// 		$this->mongo_db->insert("percentile_rules_report_log", $log_data);
			
	// }
	
    // public function go_buy_and_sell_cron_job($coin_symbol = "NEOBTC",$start_date, $end_date)
    // {
		
	// 	echo $start_date;
	// 	echo "<br />";
	// 	echo $end_date;
	// 	echo "<br />";
		
    //     $order_level_arr      = array(
    //         'level_1',
    //         'level_2',
    //         'level_3',
    //         'level_4',
    //         'level_5',
    //         'level_6',
    //         'level_7',
    //         'level_8',
    //         'level_9',
    //         'level_10'
    //     );
    //     $simulator_date       = date('Y-m-d H:00:00', strtotime($start_date));
    //     $coin_meta_arr_all    = $this->mod_reports_rules->list_historical_coin_meta($coin_symbol, $start_date, $end_date);
		
	// 	$finalarr = array();
	// 	foreach($coin_meta_arr_all as $coin_meta_arr){
		
    //     //%%%%%%%%%%%%%%%%%%% -- Coin Meta Hourly percentile in  --%%%%%%%%%%%%%%%%%%%%%%%
    //     $coin_meta_hourly_arr = $this->mod_reports_rules->list_hourly_percentile_coin_meta_history($coin_symbol, $simulator_date);
    //     //Get simulator values
    //     if (!empty($coin_meta_arr)) {
    //       $current_market_price = $coin_meta_arr['current_market_value'];
    //       if ($current_market_price == '' || $current_market_price == 0) { return false;}
	// 	  foreach ($order_level_arr as $order_level) {
    //         $global_setting_arr = $this->mod_reports_rules->triggers_setting('barrier_percentile_trigger', 'live', $coin_symbol, $order_level);
    //         if($global_setting_arr){
	// 		$level  = $order_level;
	//         $is_rules_true = $this->mod_reports_rules->is_triggers_qualify_to_buy_orders_new($coin_symbol, $order_level, $global_setting_arr, $current_market_price, $coin_meta_arr, $coin_meta_hourly_arr, $simulator_date);
	// 		if($is_rules_true['success_message']=='YES'){ 
	// 		  if (!array_key_exists($coin_meta_arr['modified_date']->toDatetime()->format("Y-m-d H:00:00"), $date_range_hour)) {		
	// 						$date_range_hour[$coin_meta_arr['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['market_value'] = $coin_meta_arr['current_market_value'];
	// 						$date_range_hour[$coin_meta_arr['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['market_time'] = $coin_meta_arr['modified_date']->toDatetime()->format("Y-m-d H:i:s");
	// 						//$date_range_hour[$coin_meta_arr['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['barrier_value'] = $barrier_val;
	// 		  }
			  
			 
	// 		 }
	// 		}
	// 	  }
	//      }
    //    } //End of historical_data
	   
	   
	// 		echo "<pre>";  print_r($finalarr); exit; 
    // } //end of go_buy_and_sell_cron_job
    // public function get_rules_cron()
    // {
    //     //======================================================================
    //     // Check Which coin need to run in Cron job 
    //     //======================================================================
    //     $symbol          = $this->mod_reports_rules->getRuningCoinName();
    //     $global_mode     = 'live';
    //     $order_level_arr = array(
    //         'level_1',
    //         'level_2',
    //         'level_3',
    //         'level_4',
    //         'level_5',
    //         'level_6',
    //         'level_7',
    //         'level_8',
    //         'level_9',
    //         'level_10'
    //     );
    //     $target_profit   = 2;
    //     $target_stoploss = 1;
    //     $trigger_type    = 'barrier_percentile_trigger'; // barrier_percentile_trigger  //barrier_trigger
    //     $start_date      = date("Y-m-d H:00:00", strtotime('-1 hour'));
    //     $end_date        = date("Y-m-d H:00:00");
    //     $date1           = new DateTime($start_date);
    //     $date2           = new DateTime($end_date);
    //     $diff            = $date2->diff($date1);
    //     $hours           = $diff->h;
    //     $hours           = $hours + ($diff->days * 24);
    //     $total_days      = $diff->days;
    //     $d1              = $start_date;
    //     $symbol          = 'ZENBTC';
    //     for ($i = 0; $i <= $hours; $i++) { // Hoursly loop
    //         for ($j = 0; $j <= 60; $j++) { // Minuts loop
    //             for ($k = 0; $k <= 11; $k++) { // Seconds loop)
    //                 $seconds = ($k * 5);
    //                 $minuts  = ($j);
    //                 if ($minuts < 10) {
    //                     $minuts = "0" . $minuts;
    //                 }
    //                 if ($seconds < 10) {
    //                     $seconds = "0" . $seconds;
    //                 }
    //                 echo $start_date = date("Y-m-d H:$minuts:$seconds", strtotime("+" . $i . " hours", strtotime($d1)));
    //                 echo "<br />";
    //                 $secondSeconds = $seconds + 5;
    //                 if ($secondSeconds < 10) {
    //                     $secondSeconds = "0" . $secondSeconds;
    //                 }
    //                 echo $end_date = date("Y-m-d H:$minuts:$secondSeconds", strtotime("+" . $i . " hours", strtotime($d1)));
    //                 echo "<br />";
    //                 ///* *** -- Coin Meta -- *** */
    //                 $coin_meta_arr = $this->mod_reports_rules->list_coin_meta($symbol, $start_date, $end_date); //5 seconds
    //                 echo "<pre>";
    //                 print_r($coin_meta_arr);
    //                 if ($coin_meta_arr) {
    //                     /* *** -- Coin Meta Hour -- *** */
    //                     echo $start = date("Y-m-d H:00:00", strtotime("+" . $i . " hours", strtotime($d1)));
    //                     echo "<br />";
    //                     echo $move = date("Y-m-d H:59:59", strtotime("+" . ($i) . " hours", strtotime($d1)));
    //                     $coin_meta_hourly_arr = $this->mod_reports_rules->list_hourly_percentile_coin_meta($symbol, $start, $move); // one hour
    //                     echo "<pre>";
    //                     print_r($coin_meta_hourly_arr);
    //                     /* ***  -- list market trends -- *** */
    //                     echo "******************  list_market_trends_arr  *******************************";
    //                     echo "<br />";
    //                     //$list_market_trends_arr = $this->mod_reports_rules->list_market_trends($symbol);
    //                     $list_market_trends_arr = array();
    //                     echo "here";
    //                     echo "<br />";
    //                     $current_market_price = num($coin_meta_arr['current_market_value']);
    //                     echo $current_market_price;
    //                     echo "<br />";
    //                     echo $current_market_price2 = $this->mod_reports_rules->market_price($symbol);
    //                     echo "<br />";
    //                     // fetch data from couint meta collecton 
    //                     /* ***  -- Rolling Volume -- *** */
    //                     $one_m_rolling_volume = $this->mod_reports_rules->calculate_one_minute_rolling_volume($symbol, $start_date, $end_date); ////5 seconds
    //                     $order_level          = 'level_1';
    //                     $global_setting_arr   = $this->mod_reports_rules->triggers_setting('barrier_percentile_trigger', 'live', $symbol, $order_level);
    //                     $buyOrderArr          = $this->go_buy_barrier_percentile_trigger_order($symbol, $order_level, $current_market_price, $global_setting_arr, $coin_meta_arr, $coin_meta_hourly_arr, $one_m_rolling_volume, $list_market_trends_arr, $start_date);
    //                 } // if($coin_meta_arr){
    //             } // For Loop Seconds
    //             echo "<br />";
    //         } // Minuts LOop 
    //         echo "<br />";
    //     } // For Loop
    // }
  /*  public function go_buy_barrier_percentile_trigger_order_new($coin_symbol, $order_level, $current_market_price, $global_setting_arr, $coin_meta_arr, $coin_meta_hourly_arr, $simulator_date, $start_date)
    {
        //%%%%%%%%%%%%%%%%%%% -- check triggers --%%%%%%%%%%%%%%%%%%%%%%
        $is_rules_true = $this->mod_reports_rules->is_triggers_qualify_to_buy_orders_new($coin_symbol, $order_level, $global_setting_arr, $current_market_price, $coin_meta_arr, $coin_meta_hourly_arr, $simulator_date);
        return $is_rules_true;
    } //End of go_buy_barrier_percentile_trigger_order*/
	
	
	public function check_real_oppurtunity($market_value, $market_time, $deep_price_check, $deep_price_lookup_in_hours, $symbol, $opp_chk) {
		if ($opp_chk) {
			$iniatial_trail_stop = $market_value - ($market_value / 100) * $deep_price_check;
			$where['coin'] = $symbol;
			$where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
			$where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $deep_price_lookup_in_hours . " hours", strtotime($market_time))));
			$where['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

			$queryHours = [
				['$match' => $where],
				['$sort' => ['modified_date' => 1]],
				['$limit' => 1],
			];

			$db = $this->mongo_db->customQuery();
			$response = $db->coin_meta_history->aggregate($queryHours);
			$row = iterator_to_array($response);

			if (count($row) > 0) {
				return true;
			} else {
				return false;
			}
		}
	}//check_real_oppurtunity
	
	public function percentile_coin_meta_reprot(){
		
		
		
		$symbol                  = 'NEOBTC';   
		$search['coin']          = $symbol;
        $simulator_date          = date('Y-m-d H:00:00', strtotime($simulator_date));
        $simulator_date          = $this->mongo_db->converToMongodttime($simulator_date);
        $search['modified_time'] = $simulator_date;
		$this->mongo_db->limit(100);
        //$this->mongo_db->where($search);
		$this->mongo_db->sort(array(
            '_id' => 'desc'
        ));
        $response_obj = $this->mongo_db->get('percentile_trigger_report');
        $response_arr = iterator_to_array($response_obj);
		
		//echo "<pre>";  print_r($response_arr); exit;
		
		
		
		
		    $positive = 0;
			$negitive = 0;
			$winp     = 0;
			$losp     = 0;
			$retArr   = array();
			foreach ($response_arr as $key => $value) {

				$market_value = $value['market_price'];
				$market_time  = $value['market_time'];
				$deep_price_check = $data_arr['deep_price_check'];
				$deep_price_lookup_in_hours = $data_arr['deep_price_lookup_in_hours'];
				$opp_chk = $data_arr['opp_chk'];
				$is_opp = $this->check_real_oppurtunity($market_value, $market_time, $deep_price_check, $deep_price_lookup_in_hours, $symbol, $opp_chk);
				
				
				

				if ($is_opp) {

					$profit_time_ago = '';
					$los_time_ago = '';
					$loss = 0;
					$profit = 0;
					$market_value = $value['market_value'];
					$market_time = $value['market_time'];
					$barrier = $value['barrier_value'];
					$sell_price = $value['market_value'] + ($value['market_value'] * $target_profit) / 100;
					$deep_price = $market_value - ($market_value / 100) * $deep_price_check;

					$where['coin'] = $symbol;
					$where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
					$where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $deep_price_lookup_in_hours . " hours", strtotime($market_time))));
					$where['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

					$queryHours = [
						['$match' => $where],
						['$sort' => ['modified_date' => 1]],
						['$limit' => 1],
					];

					$db = $this->mongo_db->customQuery();
					$response = $db->coin_meta_history->aggregate($queryHours);
					$row = iterator_to_array($response);

					$timep = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
					$iniatial_trail_stop = $value['market_value'] - ($value['market_value'] / 100) * $target_stoploss;
					$where['coin'] = $symbol;
					$where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($timep);
					$where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $deep_price_lookup_in_hours . " hours", strtotime($timep))));
					$where['current_market_value']['$gte'] = (float) $sell_price;

					$queryHours = [
						['$match' => $where],
						['$sort' => ['modified_date' => 1]],
						['$limit' => 1],
					];

					$db = $this->mongo_db->customQuery();
					$response = $db->coin_meta_history->aggregate($queryHours);
					$row = iterator_to_array($response);
					$profit = 0;
					$profit_date = "";
					if (!empty($row)) {
						$percentage = (($row[0]['current_market_value'] - $value['market_value']) / $row[0]['current_market_value']) * 100;
						$profit = number_format($percentage, 2);
						$profit_date = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
					}

					$where1['coin'] = $symbol;
					$where1['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
					$where1['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));

					$where1['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

					$queryHours1 =
						[
						['$match' => $where1],
						['$sort' => ['modified_date' => 1]],
						['$limit' => 1],
					];

					// $this->mongo_db->where($where);
					// $get = $this->mongo_db->get('coin_meta_history');
					$db = $this->mongo_db->customQuery();
					$response1 = $db->coin_meta_history->aggregate($queryHours1);
					$row1 = iterator_to_array($response1);
					$loss = 0;
					$loss_date = 0;
					if (!empty($row1)) {
						$percentage = (($row1[0]['current_market_value'] - $value['market_value']) / $row1[0]['current_market_value']) * 100;
						$loss = number_format($percentage, 2);
						$loss_date = $row1[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
					}
					$retArr[$key]['market_value'] = num($market_value);
					$retArr[$key]['market_time'] = $market_time;
					$retArr[$key]['barrier'] = num($barrier);
					if (!empty($profit_date)) {
						$profit_time_ago = $this->time_elapsed_string_min($profit_date, $key); //0
						$retArr[$key]['proft_test_ago'] = $profit_time_ago;
						$retArr[$key]['profit_time'] = $this->time_elapsed_string($profit_date, $key);
						$retArr[$key]['profit_percentage'] = $profit;
						$retArr[$key]['profit_date'] = $profit_date;
					}
					if (!empty($loss_date)) {
						$los_time_ago = $this->time_elapsed_string_min($loss_date, $key);
						$retArr[$key]['los_test_ago'] = $los_time_ago;
						$retArr[$key]['loss_time'] = $this->time_elapsed_string($loss_date, $key);
						$retArr[$key]['loss_percentage'] = $loss;
						$retArr[$key]['loss_date'] = $loss_date;
					}

					// if (!empty($profit_time_ago) && !empty($los_time_ago)) {

					//     if (($profit_time_ago > $los_time_ago)) {
					//         $retArr[$key]['message'] = "Got Loss";
					//     } else if (($profit_time_ago < $los_time_ago)) {
					//         $retArr[$key]['message'] = "Got Profit";
					//     } else {
					//         continue;
					//     }
					// }

					if ($los_time_ago == '' && $profit_time_ago == '') {
						$retArr[$key]['message'] = '';
					}
					if ($los_time_ago != '' && $profit_time_ago == '') {
						$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
						$negitive++;
						$losp += $retArr[$key]['loss_percentage'];
					}
					if ($los_time_ago == '' && $profit_time_ago != '') {
						$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
						$positive++;
						$winp += $retArr[$key]['profit_percentage'];
					}
					if ($los_time_ago != '' && $profit_time_ago != '') {
						if (($profit_time_ago > $los_time_ago)) {
							$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
							$negitive++;
							$losp += $retArr[$key]['loss_percentage'];
						} else if (($profit_time_ago < $los_time_ago)) {
							$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
							$positive++;
							$winp += $retArr[$key]['profit_percentage'];
						} else {
							continue;
						}
					}

				} else {

					$profit_time_ago = '';
					$los_time_ago = '';
					$loss = 0;
					$profit = 0;

					$market_value = $value['market_value'];
					$market_time = $value['market_time'];
					$oppertunity_time_mongo = $value['oppertunity_time_mongo'];
					
					$barrier = $value['barrier_value'];
					$sell_price = $value['market_value'] + ($value['market_value'] * $target_profit) / 100;
					$iniatial_trail_stop = $value['market_value'] - ($value['market_value'] / 100) * $target_stoploss;
					$where['coin'] = $symbol;
					$data_arr['lookup_period'] =  2;
					$where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
					$where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));
					$where['current_market_value']['$gte'] = (float) $sell_price;

					$queryHours = [
						['$match' => $where],
						['$sort' => ['modified_date' => 1]],
						['$limit' => 1],
					];

					$db = $this->mongo_db->customQuery();
					$response = $db->coin_meta_history->aggregate($queryHours);
					$row = iterator_to_array($response);
					
					
				
					$profit = 0;
					$profit_date = "";
					if (!empty($row)) {
						$percentage = (($row[0]['current_market_value'] - $value['market_value']) / $row[0]['current_market_value']) * 100;
						$profit = number_format($percentage, 2);
						$profit_date = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
					}

					$where1['coin'] = $symbol;
					$where1['modified_date']['$gte'] = $market_time;//$this->mongo_db->converToMongodttime($market_time);
					$where1['modified_date']['$lte'] = $oppertunity_time_mongo;//$this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));

					$where1['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

					$queryHours1 =
						[
						['$match' => $where1],
						['$sort' => ['modified_date' => 1]],
						['$limit' => 1],
					];

					// $this->mongo_db->where($where);
					// $get = $this->mongo_db->get('coin_meta_history');
					$db = $this->mongo_db->customQuery();
					$response1 = $db->coin_meta_history->aggregate($queryHours1);
					$row1 = iterator_to_array($response1);
					
						
					$loss = 0;
					$loss_date = 0;
					if (!empty($row1)) {
						$percentage = (($row1[0]['current_market_value'] - $value['market_value']) / $row1[0]['current_market_value']) * 100;
						$loss = number_format($percentage, 2);
						$loss_date = $row1[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
					}
					$retArr[$key]['market_value'] = num($market_value);
					$retArr[$key]['market_time'] = $market_time;
					$retArr[$key]['barrier'] = num($barrier);
					if (!empty($profit_date)) {
						$profit_time_ago = $this->time_elapsed_string_min($profit_date, $key); //0
						$retArr[$key]['proft_test_ago'] = $profit_time_ago;
						$retArr[$key]['profit_time'] = $this->time_elapsed_string($profit_date, $key);
						$retArr[$key]['profit_percentage'] = $profit;
						$retArr[$key]['profit_date'] = $profit_date;
					}
					if (!empty($loss_date)) {
						$los_time_ago = $this->time_elapsed_string_min($loss_date, $key);
						$retArr[$key]['los_test_ago'] = $los_time_ago;
						$retArr[$key]['loss_time'] = $this->time_elapsed_string($loss_date, $key);
						$retArr[$key]['loss_percentage'] = $loss;
						$retArr[$key]['loss_date'] = $loss_date;
					}

					// if (!empty($profit_time_ago) && !empty($los_time_ago)) {

					//     if (($profit_time_ago > $los_time_ago)) {
					//         $retArr[$key]['message'] = "Got Loss";
					//     } else if (($profit_time_ago < $los_time_ago)) {
					//         $retArr[$key]['message'] = "Got Profit";
					//     } else {
					//         continue;
					//     }
					// }

					if ($los_time_ago == '' && $profit_time_ago == '') {
						$retArr[$key]['message'] = '';
					}
					if ($los_time_ago != '' && $profit_time_ago == '') {
						$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
						$negitive++;
						$losp += $retArr[$key]['loss_percentage'];
					}
					if ($los_time_ago == '' && $profit_time_ago != '') {
						$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
						$positive++;
						$winp += $retArr[$key]['profit_percentage'];
					}
					if ($los_time_ago != '' && $profit_time_ago != '') {
						if (($profit_time_ago > $los_time_ago)) {
							$retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
							$negitive++;
							$losp += $retArr[$key]['loss_percentage'];
						} else if (($profit_time_ago < $los_time_ago)) {
							$retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
							$positive++;
							$winp += $retArr[$key]['profit_percentage'];
						} else {
							continue;
						}
					}

				}
			}
			$winning_profit = $winp;
			$losing_profit  = $losp;

			$total_profit = $winning_profit + $losing_profit;

			$total_per_trade = $total_profit / (count($date_range_hour));

			$total_per_day = $total_profit / $total_days;

			$data['winners'] = $winning_profit;
			$data['losers'] = $losing_profit;
			$data['total_profit'] = $total_profit;
			$data['per_trade'] = number_format($total_per_trade, 2);
			$data['per_day'] = number_format($total_per_day, 2);

			$data['final'] = $retArr;
			$data['count_msg'] = count($date_range_hour);
			$data['positive_msg'] = $positive;
			$data['negitive_msg'] = $negitive;
			$data['positive_percentage'] = number_format(($positive / ($positive + $negitive) * 100), 2);
			$data['negitive_percentage'] = number_format(($negitive / ($positive + $negitive) * 100), 2);
			$log_data = array(
				'settings' => $data_arr,
				'symbol' => $symbol,
				'winning' => $positive,
				'losing' => $negitive,
				'win_per' => ($positive / ($positive + $negitive) * 100),
				'lose_per' => ($negitive / ($positive + $negitive) * 100),
				'total' => count($date_range_hour),
				'result' => $retArr,
				'created_date' => $this->mongo_db->converToMongodttime($start_date),
				'end_date' => $this->mongo_db->converToMongodttime($end_date),
			);

			$log_data['winners'] = $winning_profit;
			$log_data['losers'] = $losing_profit;
			$log_data['total_profit'] = $total_profit;
			$log_data['per_trade'] = $total_per_trade;
			$log_data['per_day'] = $total_per_day;

			$data = $this->mongo_db->insert("percentile_rules_report_log", $log_data);
			
			
			echo "<pre>"; print_r($data); exit;
		
		
	}
	
	
    public function go_buy_barrier_percentile_trigger_order($coin_symbol, $order_level, $current_market_price, $global_setting_arr, $coin_meta_arr, $coin_meta_hourly_arr, $one_m_rolling_volume, $list_market_trends_arr, 
	$start_date)
    {
        $is_rules_true = $this->mod_reports_rules->is_triggers_qualify_to_buy_orders($coin_symbol, $order_level, $global_setting_arr, $current_market_price, $coin_meta_arr, $coin_meta_hourly_arr, $one_m_rolling_volume, 
		$list_market_trends_arr);
        if ($is_rules_true['success_message'] == 'YES') {
            echo "******** INSERT ********";
            echo "<br />";
            extract($data);
            $message            = '<span style="color:green">    Opportunities Got Profit </span>';
            $created_date       = date('Y-m-d G:i:s');
            $created_date_mongo = $this->mongo_db->converToMongodttime($created_date);
            $ins_data           = array(
                'coin' => $this->db->escape_str(trim($coin_symbol)),
                'level' => $this->db->escape_str(trim($order_level)),
                'oppertunity_time_mongo' => $this->db->escape_str(trim($created_date_mongo)),
                'oppertunity_time' => $this->db->escape_str(trim($created_date)),
                'market_price' => $this->db->escape_str(trim($current_market_price)),
                'market_time' => $this->db->escape_str(trim($coin_meta_arr['modified_date'])),
                'message' => $this->db->escape_str(trim($message))
            );
            //Insert the record into the database.
            $this->db->dbprefix('percentile_trigger_report');
            $ins_into_db = $this->mongo_db->insert('percentile_trigger_report', $ins_data);
        }
        return true;
    } //End of go_buy_barrier_percentile_trigger_order
	
	function time_elapsed_string_min($datetime, $pre_time, $full = false) {
		
		echo 'datetime'.$datetime;
		echo "<br />";
		echo 'pre_time'.$pre_time;
		echo "<br />";
		
		
		echo 'now '.$now = new DateTime($pre_time);
		echo "<br />";
		echo 'ago '.$ago = new DateTime($datetime);
		
		echo "<br />";
		
		exit;
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;
		$day = $diff->d;
		$dayc = (24 * $day) * 60;
		$hrs = $diff->h;
		$hrsc = $hrs * 60;
		$mins = $diff->i;
		$sec = $diff->s;
		$secc = $sec / 60;
		$Tmins = round($dayc + $hrsc + $mins + $secc);

		return $Tmins;
	}
	function time_elapsed_string($datetime, $pre_time, $full = false) {
		$now = new DateTime($pre_time);
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'min',
			's' => 'sec',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) {
			$string = array_slice($string, 0, 1);
		}

		return $string ? implode(', ', $string) . '' : 'just now';
	}
}