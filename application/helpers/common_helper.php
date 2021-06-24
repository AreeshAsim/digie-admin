			<?php if (!defined('BASEPATH')) {
				exit('No direct script access allowed');
			}

			if (!function_exists('get_coins')) {

				function get_coins() {

					$CI = &get_instance();
					if ($CI->session->userdata('user_role') == '1') {
						$CI->load->model('admin/mod_coins');
						$coins_arr = $CI->mod_coins->get_all_coins();
					} else {
						$CI->load->model('admin/mod_market');
						$coins_arr = $CI->mod_market->get_coins();

					}
					return $coins_arr;
				}

			} //end get_coins



			if (!function_exists('date_compare')) {
				function date_compare($a, $b)
				{
					$t1 = strtotime($a['date'].":00:00");
					$t2 = strtotime($b['date'].":00:00");
					
					return $t1 - $t2;
				}    

			}

			if (!function_exists('calculate_percentage')) {

				function calculate_percentage($purchased_price, $sell_price) {

					$profit_percentage = (($sell_price - $purchased_price) / $purchased_price) * 100;
					return $profit_percentage;
				}

			} //end calculate_percentage

			if (!function_exists('get_global_password')) {

				function get_global_password() {

					$CI = &get_instance();
					$filter_arr['subtype'] = "superadmin_password";
					$CI->mongo_db->where($filter_arr);
					$get = $CI->mongo_db->get("superadmin_settings");

					$res = iterator_to_array($get);
					return $res[0]['updated_system_password'];
				}

			} //end get_global_password

			if (!function_exists('cmp')) {
				function cmp($a, $b) {
					return strcmp($a["numeric_level"], $b["numeric_level"]);
				}

			} //end get_coins

			if (!function_exists('get_user_timezone')) {

				function get_user_timezone($user_id) {

					$CI = &get_instance();

					$CI->load->model('admin/mod_users');
					$timezone = $CI->mod_users->get_user_timezone($user_id);
					return $timezone;
				}

			} //end get_coins

			if (!function_exists('encrypt_decrypt')) {

				function encrypt_decrypt($action, $string) {
					$output = false;

					$encrypt_method = "AES-256-CBC";
					$secret_key = 'This is my secret key';
					$secret_iv = 'This is my secret iv';

					// hash
					$key = hash('sha256', $secret_key);

					// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
					$iv = substr(hash('sha256', $secret_iv), 0, 16);

					if ($action == 'encrypt') {
						$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
						$output = base64_encode($output);
					} else if ($action == 'decrypt') {
						$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
					}

					return $output;
				}

			} //end get_coins

			function roundUpToAny($profit) {
				if($profit < 5 && $profit > 4.75){ 
				$percent  = 95; 
				$profit   = $profit;  
				$color   = 'green';   
				}else if($profit > 4.75 && $profit > 4.50){
				$percent  = 90; 
				$profit   = $profit;  
				$color   = 'green';  
				}else if($profit > 4 && $profit > 4.25){
				$percent  = 100; 
				$profit   = $profit;  
				$color   = 'green';  
				}else if($profit < 3.5 && $profit > 4){ 
				$percent  = 85; 
				$profit   = $profit;  
				$color   = 'green';   
				}else if($profit < 3 && $profit > 3.75){
				$percent  = 75; 
				$profit   = $profit;  
				$color   = 'green';  
				}else if($profit < 2.5 && $profit > 3.50){
				$percent  = 60; 
				$profit   = $profit;  
				$color   = 'green';  
				}else if($profit < 2 && $profit > 3.25){
				$percent  = 50; 
				$profit   = $profit;  
				$color   = 'green';  
				}else if($profit < 1.5 && $profit > 3){
				$percent  = 35; 
				$profit   = $profit;  
				$color   = 'green';  
				}else if($profit < 1 && $profit > 2.75){
				$percent  = 25; 
				$profit   = $profit;  
				$color   = 'green';  
				}else if($profit < 0.5 && $profit > 2.50){
				$percent  = 10; 
				$profit   = $profit;  
				$color   = 'green'; 
				}else if($profit < 0.5 && $profit > 2.25){
				$percent  = 10; 
				$profit   = $profit;  
				$color   = 'green'; 
				}else if($profit < 0.5 && $profit > 2){
					$percent  = 10; 
					$profit   = $profit;  
					$color   = 'green'; 
				}else if($profit < 0.5 && $profit > 1.75){
					$percent  = 10; 
					$profit   = $profit;  
					$color   = 'green'; 
				}else if($profit < 0.5 && $profit > 1.50){
					$percent  = 10; 
					$profit   = $profit;  
					$color   = 'green'; 
				}else if($profit < 0.5 && $profit > 1.25){
					$percent  = 10; 
					$profit   = $profit;  
					$color   = 'green'; 
				}else if($profit < 0.5 && $profit > 1){
					$percent  = 10; 
					$profit   = $profit;  
					$color   = 'green'; 
				}else if($profit < 0.5 && $profit > 0.75){
					$percent  = 10; 
					$profit   = $profit;  
					$color   = 'green'; 						
				}else if($profit < 0.5 && $profit > 0.50){
					$percent  = 10; 
					$profit   = $profit;  
					$color   = 'green'; 						
				}else if($profit < 0.5 && $profit > 0.25){
					$percent  = 10; 
					$profit   = $profit;  
					$color   = 'green';
				}else if($profit < 0.5 && $profit > 0.00){
					$percent  = 10; 
					$profit   = $profit;  
					$color   = 'green'; 			 						
					
				
				}else if($profit == 0 ){
				$percent  = 0; 
				$profit   = $profit;  
				$color   = 'green'; 	
				}else if($profit < 0 && $profit > -0.5){
				$percent  = 10; 
				$profit   = $profit;  
				$color   = 'red'; 
				}else if($profit < -0.5 && $profit > -1){
				$percent  = 25; 
				$profit   = $profit;  
				$color   = 'red';  
				}else if($profit < -1 && $profit > -1.5){
				$percent  = 35; 
				$profit   = $profit;  
				$color   = 'red';  
				}else if($profit < -1.5 && $profit > -2){
				$percent  = 50; 
				$profit   = $profit;  
				$color   = 'red';  
				}else if($profit < -2 && $profit > -2.5){
				$percent  = 65; 
				$profit   = $profit;  
				$color   = 'red';  
				}else if($profit < -2.5 && $profit > -3){
				$percent  = 75; 
				$profit   = $profit;  
				$color   = 'red';  
				}else if($profit < -3 && $profit > -3.5){
				$percent  = 85; 
				$profit   = $profit;  
				$color   = 'red';  
				}else if($profit < -3.5 && $profit > -4){
				$percent  = 100; 
				$profit   = $profit;  
				$color   = 'red';  
				}else if($profit < -4 ){
				$percent  = 100; 
				$profit   = $profit;  
				$color   = 'red';  
				}
				$array['percent']  = $percent;	  
				$array['profit']   = $profit;	  
				$array['color']    = $color;	
				
				return $array;   
			}

			if (!function_exists('time_elapsed_string')) {
				function time_elapsed_string($datetime, $timezone, $full = false) {
					$CI = &get_instance();
					$datetime2 = date("Y-m-d g:i:s A");
					$timezone = $timezone;
					$date = date_create($datetime2);
					date_timezone_set($date, timezone_open($timezone));
					$now1 = date_format($date, 'Y-m-d g:i:s A');
					$now = new DateTime($now1);
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
						'i' => 'minute',
						's' => 'second',
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

					return $string ? implode(', ', $string) . ' ago' : 'just now';
				}

			} //end get_coins

			if (!function_exists('walk')) {
				function walk($val, $key, $new_array) {

					$nums = explode(':', $val);
					$new_array[$nums[0]] = $nums[1];

					return $new_array;
				}
			} // %%%%%%%%%% -- %%%%%%%%%%%%%

			if (!function_exists('check_active_cron')) {
				function check_active_cron($url) {
					$CI = &get_instance();
					$CI->load->model("admin/mod_cronjob_listing");
					$test = $CI->mod_cronjob_listing->check_when_last_cron_ran($url);
					return $test;
				}
			} // %%%%%%%%%% -- %%%%%%%%%%%%%

			if (!function_exists('is_user_api_credential_exist')) {
				function is_user_api_credential_exist($user_id) {
					$CI = &get_instance();
					$CI->mongo_db->where(array("_id" => $user_id));
					$get_arr = $CI->mongo_db->get('users');
					$settings_arr = iterator_to_array($get_arr);
					$settings_arr = $settings_arr[0];
					$check_api_settings = false;
					if ($settings_arr['api_key'] != '' && $settings_arr['api_key'] != '') {
						$check_api_settings = true;
					}
					return $check_api_settings;
				} //End of is_user_api_credential_exist
			} // %%%%%%%%%% -- %%%%%%%%%%%%%

			if (!function_exists('function_start')) {
				function function_start($function_name) {
					$CI = &get_instance();
					$start_date_human_readible = date('Y-m-d H:i:s');
					$call_back_url = current_url();
					$start_date = $CI->mongo_db->converToMongodttime($start_date_human_readible);
					$insert_arr = array('function_name' => $function_name, 'start_date' => $start_date, 'start_date_human_readible' => $start_date_human_readible, 'start_status' => 'yes', 'cron_url' => $call_back_url);
					$CI->mongo_db->insert('function_process_completion_time', $insert_arr);
				}
			} // %%%%%%%%%% -- %%%%%%%%%%%%%

			if (!function_exists('function_stop')) {
				function function_stop($function_name) {
					$CI = &get_instance();
					$stop_date_human_readible = date('Y-m-d H:i:s');
					$stop_date = $CI->mongo_db->converToMongodttime($stop_date_human_readible);

					$upd_arr = array('function_name' => $function_name, 'stop_date' => $stop_date, 'stop_date_human_readible' => $stop_date_human_readible, 'stop_status' => 'yes');

					$where = array('function_name' => $function_name);
					$conn = $CI->mongo_db->customQuery();

					$conn->function_process_completion_time->updateMany($where, array('$set' => $upd_arr));
				}
			} // %%% -- %%%%%

			if (!function_exists('is_function_process_complete')) {
				function is_function_process_complete($function_name) {
					$CI = &get_instance();
					$CI->mongo_db->where(array('function_name' => $function_name));
					$CI->mongo_db->limit(1);
					$CI->mongo_db->order_by(array('start_date' => -1));
					$row = $CI->mongo_db->get('function_process_completion_time');
					$data = iterator_to_array($row);

					$response = false;
					if (!empty($data)) {
						$data = (array) $data[0];
						$stop_status = $data['stop_status'];
						if ($stop_status == 'yes') {
							$response = true;
						}

					}
					return $response;
				}
			} // %%% -- %%%%%

			if (!function_exists('is_script_take_more_time')) {
				function is_script_take_more_time($function_name, $wait_seconds = '') {
					$CI = &get_instance();

					$date = date('Y-m-d H:i:s', strtotime('-10 seconds'));
					if ($wait_seconds != '') {
						$date = date('Y-m-d H:i:s', strtotime('-' . $wait_seconds . ' seconds'));
					}
					$created_date = $CI->mongo_db->converToMongodttime($date);

					$where = array('stop_status' => null, 'function_name' => $function_name, 'start_date' => array('$lte' => $created_date));

					$conn = $CI->mongo_db->customQuery();
					$response = $conn->function_process_completion_time->find($where);
					$response = iterator_to_array($response);

					$reponse = false;
					if (!empty($response)) {
						$reponse = true;
					}

					return $reponse;

				} //End of
			} //End of is_script_take_more_time

			if (!function_exists('track_execution_of_function_time')) {

				function track_execution_of_function_time($function_name) {
					$CI = &get_instance();
					$call_back_url = current_url();
					$start_date_human_readible = date('Y-m-d H:i:s');
					$start_date = $CI->mongo_db->converToMongodttime($start_date_human_readible);
					$insert_arr = array('function_name' => $function_name, 'created_date' => $start_date, 'created_date_human_readible' => $start_date_human_readible, 'cron_url' => $call_back_url);
					$CI->mongo_db->insert('track_execution_of_function_time', $insert_arr);
				} // End of

			} // --- End of track_execution_of_function_time ---

			if (!function_exists('track_execution_of_cronjob')) {

				function track_execution_of_cronjob($duration, $summary) {
					$CI = &get_instance();
					$call_back_url = current_url();
					$start_date_human_readible = date('Y-m-d H:i:s');
					$start_date = $CI->mongo_db->converToMongodttime($start_date_human_readible);
					$insert_arr = array('last_updated_time' => $start_date, 'last_updated_time_human_readible' => $start_date_human_readible, 'cron_url' => $call_back_url, 'cron_duration' => $duration, 'cron_summary' => $summary);
					$where = array('cron_url' => $call_back_url);
					$conn = $CI->mongo_db->customQuery();
					$conn->cronjob_listing_update->updateOne($where, array('$set' => $insert_arr), array('upsert' => true));
				} // End of

			} // --- End of track_execution_of_cronjob ---


			if (!function_exists('save_cronjob_description')) {

				function save_cronjob_description($name, $duration, $summary) {
					$CI = &get_instance();
					//"name": cronname, "description": desc, "period": period
					$start_date_human_readible = date('Y-m-d H:i:s');
					$start_date = $CI->mongo_db->converToMongodttime($start_date_human_readible);
					$insert_arr = array('last_updated_time' => $start_date, 'last_updated_time_human_readible' => $start_date_human_readible, 'name' => $name, 'cron_duration' => $duration, 'cron_summary' => $summary);
					$where = array('name' => $name);
					$conn = $CI->mongo_db->customQuery();
					$conn->cronjob_execution_logs->updateOne($where, array('$set' => $insert_arr), array('upsert' => true));
				} // End of

			} // --- End of save_cronjob_description ---

			if (!function_exists('convert_digits')) {

				function convert_digits($data) {

					$CI = &get_instance();

					$lenth = strlen(substr(strrchr($data, "."), 1));
					if ($lenth == 6) {
						$new_data = $data . '0';
					} else {

						$new_data = $data;
					}

					return $new_data;

				}

			} //end convert_digits

			if (!function_exists('num')) {

				function num($data) {
					$data = (float) $data;
					return number_format($data, 8, '.', '');
				}

			} //end num

			if (!function_exists('number_format_short')) {

				function number_format_short($n) {
					if ($n > 0 && $n < 1000) {
						// 1 - 999
						$n_format = number_format($n, 2, '.', '');
						$suffix = '';
					} else if ($n >= 1000 && $n < 1000000) {
						// 1k-999k
						$n_format = number_format($n / 1000, 2, '.', '');
						$suffix = 'K+';
					} else if ($n >= 1000000 && $n < 1000000000) {
						// 1m-999m
						$n_format = number_format($n / 1000000, 2, '.', '');
						$suffix = 'M+';
					} else if ($n >= 1000000000 && $n < 1000000000000) {
						// 1b-999b
						$n_format = number_format($n / 1000000000, 2, '.', '');
						$suffix = 'B+';
					} else if ($n >= 1000000000000) {
						// 1t+
						$n_format = number_format($n / 1000000000000, 2, '.', '');
						$suffix = 'T+';
					} else if ($n == 0) {
						$n_format = number_format($n, 2, '.', '');
						$suffix = '';
					}

					return !empty($n_format . $suffix) ? $n_format . $suffix : 0;
				}
			}

			/*?>  <option value="100" <?php
			echo ($page_post_data['ask_buy_for'] == '100') ? 'selected="selected"' : '';
			?>> Show 100</option>
			<option value="1000" <?php
			echo ($page_post_data['ask_buy_for'] == '1000') ? 'selected="selected"' : '';
			?>> Show K</option>
			<option value="10000" <?php
			echo ($page_post_data['ask_buy_for'] == '10000') ? 'selected="selected"' : '';
			?>> Show 10K</option>
			<option value="100000" <?php
			echo ($page_post_data['ask_buy_for'] == '100000') ? 'selected="selected"' : '';
			?> > Show 100K</option>
			<option value="1000000" <?php
			echo ($page_post_data['ask_buy_for'] == '1000000') ? 'selected="selected"' : '';
			?> > Show M</option>
			<option value="10000000" <?php
			echo ($page_post_data['ask_buy_for'] == '10000000') ? 'selected="selected"' : '';
			?> > Show 10M</option><?php */

			if (!function_exists('number_format_symbol')) {

				function number_format_symbol($n) {
					if ($n > 0 && $n < 1000) {
						// 1 - 999
						$n_format = number_format($n, 2, '.', '');
						$suffix = '';
					} else if ($n >= 1000 && $n < 10000) {
						// 1k-999k
						$n_format = number_format($n / 1000, 2, '.', '');
						$suffix = 'K+';
					} else if ($n >= 10000 && $n < 100000) {
						// 1m-999m
						$n_format = number_format($n / 1000000, 2, '.', '');
						$suffix = '10 K+';
					} else if ($n >= 100000 && $n < 1000000) {
						// 1b-999b
						$n_format = number_format($n / 1000000000, 2, '.', '');
						$suffix = '100 K+';
					} else if ($n >= 1000000 && $n < 10000000) {
						// 1t+
						$n_format = number_format($n / 1000000000000, 2, '.', '');
						$suffix = 'M+';
					} else if ($n >= 10000000 && $n < 100000000) {
						$n_format = number_format($n, 2, '.', '');
						$suffix = '10 M+';
					}

					return !empty($suffix) ? $suffix : 0;
				}
			}

			if (!function_exists('get_min_notation')) {

				function get_min_notation($symbol) {

					$CI = &get_instance();
					$CI->load->model('admin/mod_dashboard');

					$min_notation = $CI->mod_dashboard->get_coin_min_notation($symbol);
					return $min_notation;
				}

			} //end get_coins

			if (!function_exists('show_error_404()')) {
				function show_error_404() {
					redirect(base_url('not_found'));
				}
			}

			if (!function_exists('getAvgPrice')) {
				function getAvgPrice($symbol, $rule_number, $trigger_type) {

					$CI = &get_instance();
					$project = array(
						'$project' => array(
							"buy_order_id" => 1,

							"coin_symbol" => 1,
							"order_type" => 1,
							"rule" => 1,
						),
					);
					$match = array(

						'$match' => array(
							'order_type' => 'sell',
							'coin_symbol' => $symbol,
							"rule" => $rule_number,
						),

					);

					$sort = array('$sort' => array('hour' => -1));
					$limit = array('$limit' => 10000);
					$connect = $CI->mongo_db->customQuery();
					$record_of_rules_for_orders = $connect->record_of_rules_for_orders->aggregate(array($project, $match, $sort, $limit));
					$rulesSet_arr = iterator_to_array($record_of_rules_for_orders);
					$buy_order_IDS = array_column($rulesSet_arr, 'buy_order_id');

					if ($_SERVER['REMOTE_ADDR'] == '101.50.127.163') { //echo "<prE>";  print_r(  $buy_order_IDS); exit;
					}

					if (!empty($buy_order_IDS)) {

						$pipeline = array(
							'$group' => array(
								'_id' => null,
								'totalmarketsum' => array(
									'$sum' => '$market_value',
								),
								'totalsold_price' => array(
									'$sum' => '$market_sold_price',
								),
							),
						);
						$project = array(
							'$project' => array(
								"_id" => 1,
								"market_value" => 1,
								"market_sold_price" => 1,
							),
						);
						$match = array('_id', $buy_order_IDS);
						$sort = array(
							'$sort' => array(),
						);
						$limit = array(
							'$limit' => 1000,
						);
						$connect = $CI->mongo_db->customQuery();
						$record_of_rules_for_orders_rule = $connect->buy_orders->aggregate(array(
							$project,
							$pipeline,
							$limit,
						));
						$dataSum = iterator_to_array($record_of_rules_for_orders_rule);
						$sumArr = $dataSum[0];

						$market_sold_priceAll = num($sumArr['totalmarketsum']);
						$purachased_priceAll = num($sumArr['totalsold_price']);

						$soldPurchase = (num($market_sold_priceAll) - num($purachased_priceAll));
						$avgProfit = ($soldPurchase / $purachased_priceAll) * 100;
						return $avgProfit;
					} else {
						return 0;
					}
				}

			}

			if (!function_exists('getAvgProfitLoss')) {
				function getAvgProfitLoss($symbol, $rule_number, $trigger_type) {

					$CI = &get_instance();
					$connect = $CI->mongo_db->customQuery();
					//'order_type' => 'sell',
					$project = array(
						'$project' => array(
							"buy_order_id" => 1,

							"coin_symbol" => 1,
							"order_type" => 1,
							"rule" => 1,
						),
					);
					$match = array(
						'$match' => array(
							'coin_symbol' => $symbol,
							"rule" => $rule_number,
						),
					);

					$sort = array('$sort' => array('hour' => -1));
					$limit = array('$limit' => 10000);

					$record_of_rules_for_orders = $connect->record_of_rules_for_orders->aggregate(array($project, $match, $sort, $limit));
					$rulesSet_arr = iterator_to_array($record_of_rules_for_orders);

					$sum = 0;
					$countBuyOrder = 1;
					foreach ($rulesSet_arr as $row) {

						$buy_order_id = $row['buy_order_id'];
						$skip = 0;
						$limit = 10000;
						$search_array = array('symbol' => $symbol);
						$search_array['_id'] = $CI->mongo_db->mongoId($buy_order_id);
						$qr = array('skip' => $skip, 'sort' => array('modified_date' => -1), 'limit' => $limit);
						$cursor = $connect->buy_orders->find($search_array, $qr);
						$res = iterator_to_array($cursor);
						$valueArr = (array) $res[0];

						$returArr = array();

						if (!empty($valueArr)) {

							$returArr['_id'] = $valueArr['_id'];
							$returArr['symbol'] = $valueArr['symbol'];
							$returArr['binance_order_id'] = isset($valueArr['binance_order_id']) ? $valueArr['binance_order_id'] : 0;
							$returArr['price'] = isset($valueArr['price']) ? $valueArr['price'] : 0;
							$returArr['quantity'] = isset($valueArr['quantity']) ? $valueArr['quantity'] : 0;
							$returArr['order_type'] = isset($valueArr['order_type']) ? $valueArr['order_type'] : 0;
							$returArr['market_value'] = isset($valueArr['market_value']) ? $valueArr['market_value'] : 0;
							$returArr['trail_check'] = isset($valueArr['trail_check']) ? $valueArr['trail_check'] : 0;
							$returArr['trail_interval'] = isset($valueArr['trail_interval']) ? $valueArr['trail_interval'] : 0;
							$returArr['buy_trail_price'] = isset($valueArr['buy_trail_price']) ? $valueArr['buy_trail_price'] : 0;
							$returArr['status'] = isset($valueArr['status']) ? $valueArr['status'] : '';
							$returArr['is_sell_order'] = isset($valueArr['is_sell_order']) ? $valueArr['is_sell_order'] : '';
							$returArr['market_sold_price'] = isset($valueArr['market_sold_price']) ? $valueArr['market_sold_price'] : '';
							$returArr['sell_order_id'] = isset($valueArr['sell_order_id']) ? $valueArr['sell_order_id'] : '';
							$returArr['admin_id'] = $valueArr['admin_id'];
							$returArr['trigger_type'] = isset($valueArr['trigger_type']) ? $valueArr['trigger_type'] : '';
							$returArr['buy_parent_id'] = isset($valueArr['buy_parent_id']) ? $valueArr['buy_parent_id'] : '';
							$returArr['inactive_status'] = isset($valueArr['inactive_status']) ? $valueArr['inactive_status'] : '';

							$returArr['pause_status'] = isset($valueArr['pause_status']) ? $valueArr['pause_status'] : '';
							$returArr['parent_status'] = isset($valueArr['parent_status']) ? $valueArr['parent_status'] : '';
							$returArr['application_mode'] = isset($valueArr['application_mode']) ? $valueArr['application_mode'] : '';

							if ($valueArr['status'] == 'FILLED') {
								$total_buy_amount += num($returArr['market_value']);
							}
							if ($returArr['is_sell_order'] == 'sold') {
								$total_sold_orders += 1;
								$total_sell_amount += num($returArr['market_sold_price']);
							}
							if ($returArr['is_sell_order'] == 'sold') {
								$market_sold_price = $returArr['market_sold_price'];
								$current_order_price = $returArr['market_value'];
								$quantity = $returArr['quantity'];
								$current_data2222 = $market_sold_price - $current_order_price;
								$profit_data = ($current_data2222 * 100 / $market_sold_price);
								$profit_data = number_format((float) $profit_data, 2, '.', '');
								$total_profit += $quantity * $profit_data;
								$total_quantity += $quantity;
							}
						}
						$fullarray[] = $returArr;
						$sum += $value;
						$countBuyOrder++;
					}

					if ($total_quantity == 0) {$total_quantity = 1;}

					$avg_profit = $total_profit / $total_quantity;
					$return_data['fullarray'] = $fullarray;
					$return_data['buyorder'] = $sum;
					$return_data['total_buy_amount'] = num($total_buy_amount);
					$return_data['total_sell_amount'] = num($total_sell_amount);
					$return_data['total_sold_orders'] = $total_sold_orders;
					$return_data['avg_profit'] = number_format($avg_profit, 2, '.', '');

					return $return_data;

				}

			}

			if (!function_exists('getBuyorderData')) {
				function getBuyorderData($symbol, $rule_number, $trigger_type) {

					$CI = &get_instance();
					$connect = $CI->mongo_db->customQuery();
					//'order_type' => 'sell',
					$project = array(
						'$project' => array(
							"buy_order_id" => 1,

							"coin_symbol" => 1,
							"order_type" => 1,
							"rule" => 1,
						),
					);
					$match = array(
						'$match' => array(
							'coin_symbol' => $symbol,
							"rule" => $rule_number,
						),
					);

					$sort = array('$sort' => array('hour' => -1));
					$limit = array('$limit' => 10000);

					$record_of_rules_for_orders = $connect->record_of_rules_for_orders->aggregate(array($project, $match, $sort, $limit));
					$rulesSet_arr = iterator_to_array($record_of_rules_for_orders);

					$sum = 0;
					$countBuyOrder = 1;
					foreach ($rulesSet_arr as $row) {

						$buy_order_id = $row['buy_order_id'];
						$skip = 0;
						$limit = 10000;
						$admin_id = '169';

						$search_array['symbol'] = $symbol;
						$search_array['admin_id'] = $admin_id;

						$search_array['_id'] = $CI->mongo_db->mongoId($buy_order_id);
						$qr = array('skip' => $skip, 'sort' => array('modified_date' => -1), 'limit' => $limit);
						$cursor = $connect->buy_orders->find($search_array, $qr);
						$res = iterator_to_array($cursor);

						$valueArr = (array) $res[0];
						$returArr = array();

						if (!empty($valueArr)) {

							$returArr['_id'] = $valueArr['_id'];
							$returArr['symbol'] = $valueArr['symbol'];
							$returArr['binance_order_id'] = isset($valueArr['binance_order_id']) ? $valueArr['binance_order_id'] : 0;
							$returArr['price'] = isset($valueArr['price']) ? $valueArr['price'] : 0;
							$returArr['quantity'] = isset($valueArr['quantity']) ? $valueArr['quantity'] : 0;
							$returArr['order_type'] = isset($valueArr['order_type']) ? $valueArr['order_type'] : 0;
							$returArr['market_value'] = isset($valueArr['market_value']) ? $valueArr['market_value'] : 0;
							$returArr['trail_check'] = isset($valueArr['trail_check']) ? $valueArr['trail_check'] : 0;
							$returArr['trail_interval'] = isset($valueArr['trail_interval']) ? $valueArr['trail_interval'] : 0;
							$returArr['buy_trail_price'] = isset($valueArr['buy_trail_price']) ? $valueArr['buy_trail_price'] : 0;
							$returArr['status'] = isset($valueArr['status']) ? $valueArr['status'] : '';
							$returArr['is_sell_order'] = isset($valueArr['is_sell_order']) ? $valueArr['is_sell_order'] : '';
							$returArr['market_sold_price'] = isset($valueArr['market_sold_price']) ? $valueArr['market_sold_price'] : '';
							$returArr['sell_order_id'] = isset($valueArr['sell_order_id']) ? $valueArr['sell_order_id'] : '';
							$returArr['admin_id'] = $valueArr['admin_id'];
							$returArr['trigger_type'] = isset($valueArr['trigger_type']) ? $valueArr['trigger_type'] : '';
							$returArr['buy_parent_id'] = isset($valueArr['buy_parent_id']) ? $valueArr['buy_parent_id'] : '';
							$returArr['inactive_status'] = isset($valueArr['inactive_status']) ? $valueArr['inactive_status'] : '';

							$returArr['pause_status'] = isset($valueArr['pause_status']) ? $valueArr['pause_status'] : '';
							$returArr['parent_status'] = isset($valueArr['parent_status']) ? $valueArr['parent_status'] : '';
							$returArr['application_mode'] = isset($valueArr['application_mode']) ? $valueArr['application_mode'] : '';

							if ($valueArr['status'] == 'FILLED') {
								$total_buy_amount += num($returArr['market_value']);
							}
							if ($returArr['is_sell_order'] == 'sold') {
								$total_sold_orders += 1;
								$total_sell_amount += num($returArr['market_sold_price']);
							}
							if ($returArr['is_sell_order'] == 'sold') {
								$market_sold_price = $returArr['market_sold_price'];
								$current_order_price = $returArr['market_value'];
								$quantity = $returArr['quantity'];
								$current_data2222 = $market_sold_price - $current_order_price;
								$profit_data = ($current_data2222 * 100 / $market_sold_price);
								$profit_data = number_format((float) $profit_data, 2, '.', '');
								$total_profit += $quantity * $profit_data;
								$total_quantity += $quantity;
							}
						}
						$fullarray[] = $returArr;
						$sum += $countBuyOrder;
						//$countBuyOrder++;
					}

					if ($total_quantity == 0) {$total_quantity = 1;}

					$avg_profit = $total_profit / $total_quantity;
					$return_data['fullarray'] = $fullarray;
					$return_data['buyorder'] = $sum;
					$return_data['total_buy_amount'] = num($total_buy_amount);
					$return_data['total_sell_amount'] = num($total_sell_amount);
					$return_data['total_sold_orders'] = $total_sold_orders;
					$return_data['avg_profit'] = number_format($avg_profit, 2, '.', '');
					//echo "<pre>";  print_r($return_data);    exit;
					return $return_data;
				}
			}

			if (!function_exists('verify_login()')) {
				function verify_login() {

					$ci = &get_instance();
					$logged_in = $ci->session->userdata('logged_in');
					if (!$logged_in) {
						$ci->session->set_flashdata('err_message', 'Please Login to access this section');
						redirect(base_url() . 'login');
					}
				}
			}

			if (!function_exists('convert_to_usd_price')) {
				function convert_to_usd_price($currency = 'USD', $value = "1") {
					$url = 'https://bitpay.com/api/rates/' . $currency;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15"));
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					$result = curl_exec($ch);
					curl_close($ch);
					$info = json_decode($result, true);
					$ret = $info['rate'] * $value;
					return "$ " . number_format($ret, 2);
				}
			}

			if (!function_exists('btc_usd_convert')) {
				function btc_usd_convert($currency = 'USD', $value = "1") {
					$url = 'https://bitpay.com/api/rates/' . $currency;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15"));
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					$result = curl_exec($ch);
					curl_close($ch);
					$info = json_decode($result, true);
					$ret = $info['rate'] * $value;
					return ($ret);
				}
			}

			if (!function_exists('print_me')) {
				function print_me($array, $name = 'shahzad') {

					if ($_SERVER['REMOTE_ADDR'] == '58.65.164.72' && $name == 'shahzad') {
						echo '<pre>';
						print_r($array);
						echo '</pre>';
						exit;

					} else if ($_SERVER['REMOTE_ADDR'] == '45.115.84.51' && $name == 'waqar') {
						echo '<pre>';
						print_r($array);
						echo '</pre>';
						exit;

					} else if ($_SERVER['REMOTE_ADDR'] == '58.65.164.72' && $name == 'saeed') {
						echo '<pre>';
						print_r($array);
						echo '</pre>';
						exit;

					}
				}
			} //print_me

			function unique_array($my_array, $key) {
				$result = array();
				$i = 0;
				$key_array = array();

				foreach ($my_array as $val) {
					if (!in_array($val[$key], $key_array)) {
						$key_array[$i] = $val[$key];
						$result[$i] = $val;
					}
					$i++;
				}
				return $result;
			}

			if(!function_exists('marketPrices')){
				function marketPrices($exchange){
					$CI = &get_instance();
					$CI->load->model('admin/mod_coins');
					$getCoinFunctionName = ($exchange == 'binance')? 'get_all_coins': 'get_all_coins_'.$exchange;
					$coin_array_all = $CI->mod_coins->$getCoinFunctionName();
					$coins = array_column($coin_array_all, 'symbol');

					$collectionName = ($exchange == 'binance')? 'market_prices': 'market_prices_'.$exchange;
					$db = $CI->mongo_db->customQuery();

					$lookup = [
						[
							'$match' => [
								'coin' => ['$in' => $coins]
							]
						],
						[
							'$group' =>[
								'_id'   => '$coin',
								'price' => ['$first' => '$price'],
							]
						]
					];

					$data = $db->$collectionName->aggregate($lookup);
					$response = iterator_to_array($data);
					return $response;
					
				}
			}//end function

			// hit for cron time equation 
			if (!function_exists('hitCurlRequest')) {
				function hitCurlRequest($req) {
					$req_params = $req['req_params'];
					$req_type = $req['req_type'];
					$req_url = $req['req_url'];
					$post_json = json_encode($req_params);
					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_URL => $req_url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => $req_type,
						CURLOPT_POSTFIELDS => $post_json,
						CURLOPT_HTTPHEADER => array(
							"content-type: application/json",
						),
					));
					$response = curl_exec($curl);
					$err = curl_error($curl);
					$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
					curl_close($curl);
					$response = json_decode($response, TRUE);
					$resp = array(
						'http_code' => $http_code,
						'response' => $response,
						'error' => $err,
					);
					return $resp;
				}
			} //end num