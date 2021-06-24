<?php
/**
 *
 */
class Chart3 extends CI_Controller {

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
		$this->load->model('admin/mod_chart3');
	}
// 	public function index($symbol) {
// 		//Auto Loader
// 		$x = 1;
// 		while ($x <= 5) {

// 			$x++;
// 			sleep(3);
// 			$this->run_cron($symbol);
// 		}

// 	}
// 	public function run_cron($symbol) {

// 		$coins = $this->mod_coins->get_all_coins();

// 		//$symbol = $this->input->get('coin');
// 		$ins_array = array();

// 		$market_buy_depth_data = $this->mod_chart3->get_market_buy_depth_chart($symbol);
// 		$market_buy_depth = $market_buy_depth_data['fullarray'];
// 		// $buy_big_quantity = $market_buy_depth_data['buy_big_quantity'];

// 		$market_value = $market_buy_depth_data['market_value'];

// 		//Fetching Market Sell Depth
// 		$market_sell_depth_data = $this->mod_chart3->get_market_sell_depth_chart($symbol);
// 		$market_sell_depth = $market_sell_depth_data['fullarray'];

// /*		$insert = $this->mod_chart3->insert_chart3($market_buy_depth);
// $insert = $this->mod_chart3->insert_chart3($market_sell_depth);
//  */
// 		$db = $this->mongo_db->customQuery();
// 		foreach ($market_buy_depth as $key => $value) {
// 			$db = $this->mongo_db->customQuery();
// 			$findArr = array('type' => 'ask', 'coin' => $symbol, 'price' => $value['price']);
// 			$ins_data = $db->chart4->updateOne($findArr, array('$set' => $value), array('upsert' => true));
// 		}

// 		foreach ($market_sell_depth as $key => $value) {
// 			$db = $this->mongo_db->customQuery();
// 			$findArr = array('type' => 'bid', 'coin' => $symbol, 'price' => $value['price']);
// 			$ins_data = $db->chart4->updateOne($findArr, array('$set' => $value), array('upsert' => true));
// 		}
// 	}

// 	public function dropTable() {
// 		$get_data = $this->mongo_db->drop_collection('chart4');

// 		echo $get_data;
// 		exit;
// 	}

// 	public function test() {
// 		/*$search_arr['price'] = (float) '0.00000092';*/
// 		$search_arr['symbol'] = 'NCASHBTC';
// 		//$this->mongo_db->where($search_arr);
// 		//$this->mongo_db->order_by(array('created_date' => -1));
// 		$depth_responseArr = $this->mongo_db->get('barrier_values_collection');

// 		echo "<pre>";
// 		print_r(iterator_to_array($depth_responseArr));
// 		exit;
// 	}

// 	public function test2() {
// 		$search_arr['candle_type'] = "demand";
// 		$search_arr['coin'] = "NCASHBTC";
// 		$this->mongo_db->where($search_arr);
// 		$this->mongo_db->sort(array('created_date' => -1));
// 		$this->mongo_db->limit(1);
// 		$depth_responseArr = $this->mongo_db->get('market_chart');
// 		//market_trade_hourly_history
// 		$arr = iterator_to_array($depth_responseArr);
// 		echo "<pre>";
// 		print_r($arr);
// 		exit;
// 		$datetime = $arr[0]['timestampDate']->toDateTime();
// 		$created_date = $datetime->format(DATE_RSS);

// 		$datetime = new DateTime($created_date);
// 		$datetime->format('Y-m-d g:i:s');

// 		/*$new_timezone = new DateTimeZone('Asia/Karachi');
// 	    $datetime->setTimezone($new_timezone);*/
// 		echo $start_date = $datetime->format('Y-m-d H:i:s');
// 		/*$search_arr['coin'] = "NCASHBTC";
// 				$this->mongo_db->where($search_arr);
// 			  	$this->mongo_db->sort(array('timestamp' => -1));
// 				$this->mongo_db->limit(1);
// 				$depth_responseArr = $this->mongo_db->get('market_trade_hourly_history');
// 		*/
// 		echo "<br>";
// 		echo $end_date = date('Y-m-d H:i:s');
// 		/*$search_array = array(
// 			     'type'=>$type,
// 			     'coin'=>$symbol,
// 			     'price'=>$price,
// 			     'hour'=>array('$gte'=>$start_date,'$lte'=>$end_date));*/
// 		$search_array['type'] = "ask";
// 		$search_array['price'] = 0.00000229;
// 		$search_array['coin'] = "NCASHBTC";
// 		$search_array['hour'] = array('$gte' => $start_date, '$lte' => $end_date);
// 		$this->mongo_db->where($search_array);
// 		$res = $this->mongo_db->get('market_trade_hourly_history');
// 		$ask_volume_arr = iterator_to_array($res);

// 		echo "<pre>";
// 		print_r($ask_volume_arr);
// 		exit;
// 	}

// 	public function countTotal() {
// 		$db = $this->mongo_db->customQuery();
// 		$count = $db->chart4->count();
// 		echo $count;
// 		exit;
// 	}

// 	public function get_current_candle_volume($symbol) {
// 		$datetime = date("Y-m-d H:00:00");
// 		$orig_date22 = new DateTime($datetime);
// 		$orig_date22 = $orig_date22->getTimestamp();
// 		$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);

// 		$search['created_date'] = array('$gte' => $end_date);
// 		$search['coin'] = $symbol;
// 		$search['maker'] = 'true';

// 		$this->mongo_db->where($search);
// 		$get = $this->mongo_db->get("market_trades");

// 		$res = iterator_to_array($get);
// 		$bid_vol = 0;
// 		foreach ($res as $key => $value) {
// 			$vol = $value['quantity'];
// 			$bid_vol += $vol;
// 		}

// 		$search['created_date'] = array('$gte' => $end_date);
// 		$search['coin'] = $symbol;
// 		$search['maker'] = 'false';

// 		$this->mongo_db->where($search);
// 		$get = $this->mongo_db->get("market_trades");

// 		$res = iterator_to_array($get);
// 		$ask_vol = 0;
// 		foreach ($res as $key => $value) {
// 			$vol = $value['quantity'];
// 			$ask_vol += $vol;
// 		}
// 		$total_volume = $bid_vol + $ask_vol;

// 		$bid_per = ($bid_vol * 100) / $total_volume;
// 		$ask_per = ($ask_vol * 100) / $total_volume;

// 		return array(
// 			'bid_per' => $bid_per,
// 			'ask_per' => $ask_per,
// 			'bid_vol' => $bid_vol,
// 			'ask_vol' => $ask_vol,
// 		);
// 	}

// 	public function get_rolling_candle_volume($symbol) {
// 		$datetime = date("Y-m-d H:i:s", strtotime('-15 minutes'));
// 		$orig_date22 = new DateTime($datetime);
// 		$orig_date22 = $orig_date22->getTimestamp();
// 		$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);

// 		$search['created_date'] = array('$gte' => $end_date);
// 		$search['coin'] = $symbol;
// 		$search['maker'] = 'true';

// 		$this->mongo_db->where($search);
// 		$get = $this->mongo_db->get("market_trades");

// 		$res = iterator_to_array($get);
// 		$bid_vol = 0;
// 		foreach ($res as $key => $value) {
// 			$vol = $value['quantity'];
// 			$bid_vol += $vol;
// 		}

// 		$search['created_date'] = array('$gte' => $end_date);
// 		$search['coin'] = $symbol;
// 		$search['maker'] = 'false';

// 		$this->mongo_db->where($search);
// 		$get = $this->mongo_db->get("market_trades");

// 		$res = iterator_to_array($get);
// 		$ask_vol = 0;
// 		foreach ($res as $key => $value) {
// 			$vol = $value['quantity'];
// 			$ask_vol += $vol;
// 		}
// 		$total_volume = $bid_vol + $ask_vol;

// 		$bid_per = ($bid_vol * 100) / $total_volume;
// 		$ask_per = ($ask_vol * 100) / $total_volume;

// 		$new_arr = array(
// 			'bid_per' => $bid_per,
// 			'ask_per' => $ask_per,
// 			'bid_vol' => $bid_vol,
// 			'ask_vol' => $ask_vol,
// 		);

// 		return $new_arr;
// 	}

// 	public function delete_old_data() {
// 		//date_default_timezone_set("ASIA/KARACHI");
// 		$created_date = date('Y-m-d g:i:s A', strtotime('-2 minutes'));
// 		echo $created_date;
// 		echo "<br>";
// 		$db = $this->mongo_db->customQuery();

// 		///////////////////////////////////////////////////////////////
// 		$delectchart4 = $db->chart4->deleteMany(array('created_date' => array('$lte' => $created_date)));

// 		echo "<pre>";
// 		print_r($delectchart4);
// 		exit;
// 	}
// 	public function test_test() {
// 		//date_default_timezone_set("ASIA/KARACHI");
// 		$created_date = date('Y-m-d g:i:s A', strtotime("-2 minutes"));
// 		echo $created_date;
// 		echo "<br>";
// 		echo "<br>";
// 		//$search['created_date'] = array('$lte' => $created_date);

// 		//$this->mongo_db->where($search);
// 		$this->mongo_db->sort(array('created_date' => 'desc'));
// 		$this->mongo_db->limit(40);

// 		$data = $this->mongo_db->get('chart4');
// 		$dat_ar = iterator_to_array($data);
// 		echo "<pre>";
// 		print_r($dat_ar);
// 		exit;
// 	}
// 	public function autoload_trading_chart_data() {
// 		$symbol = $this->input->post('symbol');
// 		if ($symbol == '') {
// 			$symbol = $this->session->userdata('global_symbol');
// 		}
// 		$previous_market_value = $this->input->post('previous_market_value');
// 		$market_value = $this->mod_chart3->get_market_value($symbol);
// 		$biggest_value2 = $this->mod_coins->get_coin_base_order($symbol);
// 		$biggest_value = $this->mod_coins->get_coin_base_history($symbol);
// 		$unit_value = $this->mod_coins->get_coin_unit_value($symbol);
// 		$market_buy_depth_arr = $this->mod_chart3->get_ask_values_for_chart($symbol, $market_value);
// 		$buy_big_quantity = 0;
// 		$depth_buy_big_quantity = 0;

// 		/*foreach ($market_buy_depth_arr as $key => $value) {

// 			if ($buy_big_quantity < $value['buy_quantity']) {
// 				$buy_big_quantity = $value['buy_quantity'];
// 			}
// 			if ($depth_buy_big_quantity < $value['depth_buy_quantity']) {
// 				$depth_buy_big_quantity = $value['depth_buy_quantity'];
// 			}
// 		}*/
// 		$market_sell_depth_arr = $this->mod_chart3->get_bid_values_for_chart($symbol, $market_value);
// 		$sell_big_quantity = 0;
// 		$depth_sell_big_quantity = 0;
// 		/*	foreach ($market_sell_depth_arr as $key => $value) {

// 			if ($sell_big_quantity < $value['sell_quantity']) {
// 				$sell_big_quantity = $value['sell_quantity'];
// 			}
// 			if ($depth_sell_big_quantity < $value['depth_sell_quantity']) {
// 				$depth_sell_big_quantity = $value['depth_sell_quantity'];
// 			}
// 		}*/

// 		/*if ($buy_big_quantity > $sell_big_quantity) {
// 				$biggest_value = $buy_big_quantity;
// 			} else {
// 				$biggest_value = $sell_big_quantity;
// 			}
// 			echo number_format_short($biggest_value); exit;
// 			if ($depth_buy_big_quantity > $depth_sell_big_quantity) {
// 				$biggest_value2 = $depth_buy_big_quantity;
// 			} else {
// 				$biggest_value2 = $depth_sell_big_quantity;
// 		*/

// 		///////////////////////////////////////////////////
// 		//Get Last Candle Percentages
// 		$search_arr['candle_type'] = "demand";
// 		$search_arr['coin'] = $symbol;
// 		$this->mongo_db->where($search_arr);
// 		$this->mongo_db->sort(array('created_date' => -1));
// 		$this->mongo_db->limit(1);
// 		$depth_responseArr = $this->mongo_db->get('market_chart');
// 		$data_arr = iterator_to_array($depth_responseArr);

// 		$bid_val = $data_arr[0]['bid_volume'];
// 		$high = $data_arr[0]['high'];
// 		$low = $data_arr[0]['low'];
// 		$ask_val = $data_arr[0]['ask_volume'];
// 		$total = $data_arr[0]['total_volume'];

// 		$bid_per = ($bid_val / $total) * 100;
// 		$ask_per = ($ask_val / $total) * 100;
// 		//////////////////////////////////////////////////

// 		/*$high = $final_array['high'];
// 		$low = $final_array['low'];*/
// 		$response = '<ul class="price_s_r_ul">';
// 		/*if (count($market_buy_depth_arr) > 0) {
// 			$buy_depth_wall2 = 0;
// 			$temp_price = 0;
// 			$temps = count($market_buy_depth_arr);
// 			for ($temp = $temps - 1; $temp >= 0; $temp--) {

// 				$sell_percentage22 = round($market_buy_depth_arr[$temp]['depth_sell_quantity'] * 100 / $biggest_value2);
// 				if ($sell_percentage22 > $depth_wall && $buy_depth_wall2 == 0) {
// 					$temp_price = num($market_buy_depth_arr[$temp]['price']);
// 					$buy_depth_wall2 = 1;
// 					break;
// 				}
// 				$buy_percentage22 = round($market_buy_depth_arr[$temp]['depth_buy_quantity'] * 100 / $biggest_value2);
// 				if ($buy_percentage22 >= $depth_wall && $buy_depth_wall2 == 0) {
// 					$temp_price = num($market_buy_depth_arr[$temp]['price']);
// 					$buy_depth_wall2 = 1;
// 					break;
// 				}
// 			}
// 		}*/
// 		$temp_price_buy = $this->calculate_wall($symbol, $market_buy_depth_arr, 'buy', $biggest_value2);
// 		$temp_price_buy22 = $this->calculate_yellow_wall($symbol, $market_buy_depth_arr, 'buy', $biggest_value2);
// 		$up_barrier = $this->get_barrier_value($market_value, $symbol, 'up');
// 		$down_barrier = $this->get_barrier_value($market_value, $symbol, 'down');
// 		if (count($market_buy_depth_arr) > 0) {
// 			$i = 0;
// 			$buy_depth_wall = 0;
// 			foreach ($market_buy_depth_arr as $key => $value) {

// 				$price = num($value['price']);

// 				$response .= '<li class="price_s_r_li with_BS" d_price="' . num($price) . '" index="' . $i . '">

// 			                         <div class="wbs_seller_prog_main widthdepth">
// 			                            <div class="wbs_red_prog">
// 			                                <div class="wbs_red_prog_p">' . number_format_short($value['depth_buy_quantity']) . '</div>';
// 				$buy_percentage22 = round($value['depth_buy_quantity'] * 100 / $biggest_value2);
// 				if ($buy_percentage22 > 100) {
// 					$buy_percentage22 = 100;
// 				}
// 				if ($price == $temp_price_buy || $price == $temp_price_buy22) {

// 					if ($price == $temp_price_buy22) {
// 						$response .= '<div class="wbs_red_prog_bar" style="background: #FB8C00 none repeat scroll 0 0;" wbs_d_prog_percent="' . $buy_percentage22 . '"></div>';
// 					}
// 					if ($price == $temp_price_buy) {

// 						$response .= '<div class="wbs_red_prog_bar" style="background: black none repeat scroll 0 0;" wbs_d_prog_percent="' . $buy_percentage22 . '"></div>';
// 					}
// 				} else {
// 					$response .= '<div class="wbs_red_prog_bar" WBS_d_prog_percent="' . $buy_percentage22 . '"></div>';
// 				}

// 				$response .= '</div></div>
// 			                        <div class="price_cent_main">';
// 				if ($high >= num($price) && $low <= num($price)) {
// 					if ($up_barrier == num($price)) {
// 						$response .= '<span class="simple_p gray_v_p" style="background: #ff4d4d;">' . num($price) . '</span>';
// 					} else {
// 						$response .= '<span class="simple_p gray_v_p" style="background: rgba(43, 43, 43, 0.5);">' . num($price) . '</span>';
// 					}

// 				} else {
// 					if ($up_barrier == num($price)) {
// 						$response .= '<span class="simple_p gray_v_p" style="background:#ff4d4d;">' . num($price) . '</span>';
// 					} else {
// 						$response .= '<span class="simple_p gray_v_p">' . num($price) . '</span>';
// 					}
// 				}

// 				$response .= '</div>
// 			                        <div class="buyer_prog_main">
// 			                            <div class="blu_prog">
// 			                                <div class="blue_prog_p">' . number_format_short($value['sell_quantity']) . '</div>';
// 				$sell_percentage = round($value['sell_quantity'] * 100 / $biggest_value);
// 				if ($sell_percentage > 100) {
// 					$sell_percentage = 100;
// 				}
// 				if ($sell_percentage == 100) {
// 					$type = 'buy';
// 				}

// 				$response .= '<div class="blue_prog_bar" d_prog_percent="' . $sell_percentage . '"></div>
// 			                            </div>
// 			                        </div>
// 			                        <div class="seller_prog_main">
// 			                            <div class="red_prog">
// 			                                <div class="red_prog_p">' . number_format_short($value['buy_quantity']) . '</div>';
// 				$buy_percentage = round($value['buy_quantity'] * 100 / $biggest_value);
// 				if ($buy_percentage > 100) {
// 					$buy_percentage = 100;
// 				}
// 				if ($buy_percentage == 100) {
// 					$type = 'sell';
// 				}

// 				$response .= '<div class="red_prog_bar" d_prog_percent="' . $buy_percentage . '"></div>
// 			                            </div>
// 			                        </div>

// 			                    </li>';

// 				$i++;

// 			} //end foreach
// 		} //end if

// 		if ($market_value > $previous_market_value) {
// 			$class = 'GCV_color_green';
// 			$icon = 'fa fa-arrow-up';
// 		} elseif ($market_value < $previous_market_value) {
// 			$class = 'GCV_color_red';
// 			$icon = 'fa fa-arrow-down';
// 		} else {
// 			$class = 'GCV_color_default';
// 			$icon = '';
// 		}

// 		$response .= '<li class="price_s_r_li with_BS" d_price="' . num($market_value) . '" index="' . $i++ . '">
// 				            <div class="wbs_buyer_prog_main widthdepth">
// 	                        </div>

// 				            <div class="price_cent_main">
// 				                <span class="simple_p white_v_p" id="response2222">
// 				                 <span class="' . $class . '">' . num($market_value) . '</span>
// 				                </span>
// 				            </div>
// 				            <div class="seller_prog_main">
// 				                <div class="red_prog">
// 				                </div>
// 				            </div>
// 				            <div class="wbs_seller_prog_main">
// 	                        </div>
// 				        </li>';

// 		if (count($market_sell_depth_arr) > 0) {
// 			$temp_price_sell = $this->calculate_wall($symbol, $market_sell_depth_arr, 'sell', $biggest_value2);
// 			$temp_price_sell22 = $this->calculate_yellow_wall($symbol, $market_sell_depth_arr, 'sell', $biggest_value2);
// 			foreach ($market_sell_depth_arr as $key => $value2) {

// 				$price22 = num($value2['price']);

// 				$response .= '<li class="price_s_r_li with_BS" d_price="' . num($price22) . '" index="' . $i . '">
// 			                        <div class="wbs_buyer_prog_main widthdepth">
// 			                            <div class="wbs_blu_prog">
// 			                                <div class="wbs_blue_prog_p">' . number_format_short($value2['depth_sell_quantity']) . '</div>';
// 				$sell_percentage222 = round($value2['depth_sell_quantity'] * 100 / $biggest_value2);
// 				if ($sell_percentage222 > 100) {
// 					$sell_percentage222 = 100;
// 				}
// 				if ($price22 == $temp_price_sell || $price22 == $temp_price_sell22) {

// 					if ($price22 == $temp_price_sell22) {
// 						$response .= '<div class="wbs_blue_prog_bar" style=" background:  #FB8C00 none repeat scroll 0 0;" WBS_d_prog_percent="' . $sell_percentage222 . '"></div>';
// 					}
// 					if ($price22 == $temp_price_sell) {
// 						$response .= '<div class="wbs_blue_prog_bar" style=" background: black none repeat scroll 0 0;" WBS_d_prog_percent="' . $sell_percentage222 . '"></div>';
// 					}
// 				} else {
// 					$response .= '<div class="wbs_blue_prog_bar" WBS_d_prog_percent="' . $sell_percentage222 . '"></div>';
// 				}
// 				$response .= '</div>
// 			                        </div>



// 			                        <div class="price_cent_main">';

// 				if ($high >= num($price22) && $low <= num($price22)) {
// 					if ($down_barrier == num($price22)) {
// 						$response .= '<span class="simple_p gray_v_p" style="background: #4b7bec;">' . num($price22) . '</span>';
// 					} else {
// 						$response .= '<span class="simple_p gray_v_p" style="background: rgba(43, 43, 43, 0.5);">' . num($price22) . '</span>';
// 					}

// 				} else {
// 					if ($down_barrier == num($price22)) {
// 						$response .= '<span class="simple_p gray_v_p" style="background:#4b7bec;">' . num($price22) . '</span>';
// 					} else {
// 						$response .= '<span class="simple_p gray_v_p">' . num($price22) . '</span>';
// 					}
// 				}
// 				$response .= '</div>

// 			                        <div class="buyer_prog_main">
// 			                            <div class="blu_prog">
// 			                                <div class="blue_prog_p">' . number_format_short($value2['sell_quantity']) . '</div>';
// 				$sell_percentage2 = round($value2['sell_quantity'] * 100 / $biggest_value);
// 				if ($sell_percentage2 > 100) {
// 					$sell_percentage2 = 100;
// 				}
// 				if ($sell_percentage2 == 100) {
// 					$type = 'buy';
// 				}

// 				$response .= '<div class="blue_prog_bar" d_prog_percent="' . $sell_percentage2 . '"></div>
// 			                            </div>
// 			                        </div>

// 			                         <div class="seller_prog_main">
// 			                            <div class="red_prog">
// 			                                <div class="red_prog_p">' . number_format_short($value2['buy_quantity']) . '</div>';
// 				$buy_percentage2 = round($value2['buy_quantity'] * 100 / $biggest_value);
// 				if ($buy_percentage2 > 100) {
// 					$buy_percentage2 = 100;
// 				}
// 				if ($buy_percentage2 == 100) {
// 					$type = 'sell';
// 				}

// 				$response .= '<div class="red_prog_bar" d_prog_percent="' . $buy_percentage2 . '"></div>
// 			                            </div>
// 			                        </div>
// 			                    </li>';

// 				$i++;

// 			} //end foreach
// 		} //end if

// 		$response .= '</ul>';

// 		//GEt Zone values
// 		$zone_values_arr = $this->mod_chart3->get_zone_values($market_value, $symbol);

// 		$buy_quantity = $zone_values_arr['buy_quantity'];
// 		$sell_quantity = $zone_values_arr['sell_quantity'];
// 		$buy_percentage = $zone_values_arr['buy_percentage'];
// 		$sell_percentage = $zone_values_arr['sell_percentage'];
// 		$zone_id = $zone_values_arr['zone_id'];

// 		$response2 = '<div class="G_current_val ' . $class . '">
// 			                <div class="GCV_text"><b>' . num($market_value) . '</b></div>
// 			                <div class="GCV_icon">
// 			                    <i class="' . $icon . '" aria-hidden="true"></i>
// 			                </div>
// 			            </div>';

// 		$response3 = $market_value;

// 		if ($zone_id != "" && $buy_percentage != 'NAN' && $sell_quantity != 'NAN') {

// 			$response4 = '<div class="verti_bar_prog_top" d_vbpPercent="' . $buy_percentage . '">
// 		                    <span>' . $buy_quantity . '</span>
// 		                 </div>
// 		                 <div class="verti_bar_prog_bottom" d_vbpPercent="' . $sell_percentage . '">
// 		                    <span>' . $sell_quantity . '</span>
// 		                 </div>';

// 		} else {
// 			$response4 = '';
// 		}

// 		//Get zones Record
// 		$chart_target_zones_arr = $this->mod_chart3->get_chart_target_zones();

// 		//Get Sell Orders
// 		$orders_arr = $this->mod_chart3->get_sell_active_orders();

// 		//Get Buy Orders
// 		$buy_orders_arr = $this->mod_chart3->get_buy_active_orders();

// 		$current = $this->get_current_candle_volume($symbol);
// 		$curr_bid_per = $current['bid_per'];
// 		$curr_ask_per = $current['ask_per'];
// 		$curr_bid = $current['bid_vol'];
// 		$curr_ask = $current['ask_vol'];

// 		//Last Swing Candle

// 		$this->mongo_db->order_by(array('_id' => -1));
// 		$this->mongo_db->where(array('coin' => $symbol));
// 		$this->mongo_db->where_in('global_swing_parent_status', array('LL', 'HH', 'LH', 'HL'));
// 		$this->mongo_db->limit(1);
// 		$row = $this->mongo_db->get('market_chart');
// 		$data_row = iterator_to_array($row);

// 		$swing_point = $data_row[0]['global_swing_parent_status'];

// 		$rolling = $this->get_rolling_candle_volume($symbol);

// 		$roll_bid_per = $rolling['bid_per'];
// 		$roll_ask_per = $rolling['ask_per'];
// 		$roll_bid = $rolling['bid_vol'];
// 		$roll_ask = $rolling['ask_vol'];

// 		$contract_info = $this->get_contract_info($symbol);
// 		$bid_contract_info = $this->get_bid_contract_info($symbol);
// 		$ask_contract_info = $this->get_ask_contract_info($symbol);

// 		$contract_html = number_format_short($contract_info['avg']) . '<br><span style="font-size:12px;">' . $contract_info['per'] . ' %</span>';
// 		$bid_contract_html = number_format_short($bid_contract_info['avg']) . '<br><span style="font-size:12px;">' . $bid_contract_info['max'] . '(' . $bid_contract_info['per'] . ' %)</span>';
// 		$ask_contract_html = number_format_short($ask_contract_info['avg']) . '<br><span style="font-size:12px;">' . $ask_contract_info['max'] . '(' . $ask_contract_info['per'] . ' %)</span>';
// 		///End Last Swing Candle
// 		$pre_time = date('Y-m-d H:i:00');
// 		$up_pressure_arr = $this->calculate_pressure($market_sell_depth_arr, $market_buy_depth_arr);
// 		$up_pressure = $up_pressure_arr['up'];
// 		$down_pressure = $up_pressure_arr['down'];
// 		$pressure_wall_array = $this->calculate_big_wall($market_sell_depth_arr, $market_buy_depth_arr, $biggest_value2);

// 		$big_val = $pressure_wall_array['great_wall_quantity'];
// 		$big_per = $pressure_wall_array['max_per'];
// 		$pressure_wall = $pressure_wall_array['great_wall'];

// 		if ($up_pressure > $down_pressure) {
// 			$new_pressure = $up_pressure - $down_pressure;
// 			$new_p = ($new_pressure / 5) * 100;
// 			$color_code = 'up';
// 		} else {
// 			$new_pressure = $down_pressure - $up_pressure;
// 			$new_p = ($new_pressure / 5) * 100;
// 			$color_code = 'down';
// 		}

// 		$bid_avg = $bid_contract_info['avg'];
// 		$ask_avg = $ask_contract_info['avg'];
// 		if ($bid_avg > $ask_avg) {
// 			$percentage = $bid_contract_info['per'];
// 			$val = $bid_avg;
// 			$v_press = 'up';
// 		} else {
// 			$percentage = $ask_contract_info['per'];
// 			$val = $ask_avg;
// 			$v_press = 'down';
// 		}
// 		//$bid_diff = (num($market_value) - $temp_price_sell) / $unit_value;
// 		//$ask_diff = ($temp_price_buy - num($market_value)) / $unit_value;
// 		array_multisort(array_column($market_buy_depth_arr, "price"), SORT_ASC, $market_buy_depth_arr);
// 		$bid_diff = $key = array_search($temp_price_sell, array_column($market_sell_depth_arr, 'price'));
// 		$ask_diff = $key = array_search($temp_price_buy, array_column($market_buy_depth_arr, 'price'));

// 		$y_bid_diff = $key = array_search($temp_price_sell22, array_column($market_sell_depth_arr, 'price'));
// 		$y_ask_diff = $key = array_search($temp_price_buy22, array_column($market_buy_depth_arr, 'price'));
// 		//echo $ask_diff = 50 - $ask_diff;
// 		if ($bid_diff > $ask_diff) {
// 			$new_pressure1 = ($bid_diff) - $ask_diff;
// 			$new_p1 = ($new_pressure1 / 10) * 100;
// 			$color_code1 = 'down';
// 		} else {
// 			$new_pressure1 = $ask_diff - $bid_diff;
// 			$new_p1 = ($new_pressure1 / 10) * 100;
// 			$color_code1 = 'up';
// 		}

// 		if ($y_bid_diff > $y_ask_diff) {
// 			$new_pressure3 = ($y_bid_diff) - $y_ask_diff;
// 			$new_p3 = ($new_pressure3 / 10) * 100;
// 			$color_code3 = 'down';
// 		} else {
// 			$new_pressure3 = $y_ask_diff - $y_bid_diff;
// 			$new_p3 = ($new_pressure3 / 10) * 100;
// 			$color_code3 = 'up';
// 		}
// 		$levels = $this->calculate_bid_ask_levels($market_sell_depth_arr, $market_buy_depth_arr);
// 		$new_pressure2 = $levels['new_x'];
// 		$new_p2 = $levels['new_p'];
// 		$color_code2 = $levels['p'];

// 		$response5 = '<div class="bottom_prog_left">
//                           <div class="bottom_prog_one">
//                               <div class="bottom_prog_title">
//                                   <h2>Depth Pressure</h2>
//                                 </div>
//                                 <div class="bottom_progress">';
// 		if ($color_code == 'up') {
// 			$response5 .= '<div class="prog_box" style="width:' . $new_p . '%; background:#4484FF;">' . number_format($new_pressure) . '</div>';
// 		} elseif ($color_code == 'down') {
// 			$response5 .= '<div class="prog_box" style="width:' . $new_p . '%; background:#f11919;">' . number_format($new_pressure) . '</div>';
// 		}
// 		$response5 .= '</div>
//                             </div>
//                             <div class="bottom_prog_two">
//                               <div class="bottom_prog_title">
//                                   <h2>Black Wall Pressure</h2>
//                                 </div>
//                                 <div class="bottom_progress">';
// 		if ($color_code1 == 'up') {
// 			$response5 .= '<div class="prog_box" style="width:' . number_format($new_p1) . '%; background:#4484FF;">' . number_format($new_pressure1) . '</div>';
// 		} elseif ($color_code1 == 'down') {
// 			$response5 .= '<div class="prog_box" style="width:' . number_format($new_p1) . '%; background:#f11919;">' . number_format($new_pressure1) . '</div>';
// 		}
// 		$response5 .= '</div>
//                             </div>
//                             <div class="bottom_prog_three">
//                               <div class="bottom_prog_title">
//                                   <h2>7 Levels Up/Down Pressure</h2>
//                                 </div>
//                                 <div class="bottom_progress">';
// 		if ($color_code2 == 'up') {
// 			$response5 .= '<div class="prog_box" style="width:' . number_format($new_p2) . '%; background:#4484FF;">' . $new_pressure2 . '</div>';
// 		} elseif ($color_code2 == 'down') {
// 			$response5 .= '<div class="prog_box" style="width:' . number_format($new_p2) . '%; background:#f11919;">' . $new_pressure2 . '</div>';
// 		}
// 		$response5 .= '</div>
//                             </div>
//                         </div>';
// ////////////////////////////////////////////////////////////////////////////////////////////////

// 		$response5 .= '<div class="bottom_prog_left">
//                           <div class="bottom_prog_one">
//                               <div class="bottom_prog_title">
//                                   <h2>Yellow Wall Pressure</h2>
//                                 </div>
//                                 <div class="bottom_progress">';
// 		if ($color_code3 == 'up') {
// 			$response5 .= '<div class="prog_box" style="width:' . $new_p3 . '%; background:#4484FF;">' . number_format($new_pressure3) . '</div>';
// 		} elseif ($color_code3 == 'down') {
// 			$response5 .= '<div class="prog_box" style="width:' . $new_p3 . '%; background:#f11919;">' . number_format($new_pressure3) . '</div>';
// 		}
// 		$response5 .= '</div>
//                             </div>
//                             <div class="bottom_prog_two">
//                               <div class="bottom_prog_title">
//                                   <h2>Big Pressure</h2>
//                                 </div>
//                                 <div class="bottom_progress">';
// 		if ($pressure_wall == 'down') {
// 			$response5 .= '<div class="prog_box" style="width:' . number_format($big_per) . '%; background:#4484FF;">' . number_format_short($big_val) . '</div>';
// 		} elseif ($pressure_wall == 'up') {
// 			$response5 .= '<div class="prog_box" style="width:' . number_format($big_per) . '%; background:#f11919;">' . number_format_short($big_val) . '</div>';
// 		}
// 		$response5 .= '</div>
//                             </div>
//                             <div class="bottom_prog_three">
//                               <div class="bottom_prog_title">
//                                   <h2>Big Buyers/Sellers Pressure</h2>
//                                 </div>
//                                 <div class="bottom_progress">';
// 		if ($v_press == 'down') {
// 			$response5 .= '<div class="prog_box" style="width:' . number_format($percentage) . '%; background:#4484FF;">' . number_format_short($val) . '</div>';
// 		} elseif ($v_press == 'up') {
// 			$response5 .= '<div class="prog_box" style="width:' . number_format($percentage) . '%; background:#f11919;">' . number_format_short($val) . '</div>';
// 		}
// 		$response5 .= '</div>
//                             </div>
//                         </div>';
// 		echo $response . "|" . $response2 . "|" . $response3 . "|" . $type . "|" . json_encode($chart_target_zones_arr) . "|" . $response4 . "|" . json_encode($orders_arr) . "|" . json_encode($buy_orders_arr) . "|" . round($bid_per) . "|" . round($ask_per) . "|" . round($curr_bid_per) . "|" . round($curr_ask_per) . "|" . number_format_short($curr_bid) . "|" . number_format_short($curr_ask) . "|" . number_format_short($bid_val) . "|" . number_format_short($ask_val) . "|" . $swing_point . "|" . $contract_html . "|" . $bid_contract_html . "|" . $ask_contract_html . "|" . round($roll_bid_per) . "|" . round($roll_ask_per) . "|" . number_format_short($roll_bid) . "|" . number_format_short($roll_ask) . "|" . $up_pressure . "|" . $down_pressure . "|" . $pressure_wall . "|" . $response5;
// 		exit;

// 	} //end autoload_trading_chart_data222

	// public function view_chart3() {
	// 	//Login Check
	// 	$this->mod_login->verify_is_admin_login();

	// 	$symbol = $this->session->userdata('global_symbol');
	// 	$market_value = $this->mod_chart3->get_market_value($symbol);

	// 	$ask_array = $this->mod_chart3->get_ask_values_for_chart($symbol, $market_value);

	// 	$data['market_buy_depth_arr'] = $ask_array;
	// 	$buy_big_quantity = 0;
	// 	$buy_sell_quantity = 0;
	// 	foreach ($ask_array as $key => $value) {

	// 		if ($buy_sell_quantity < $value['quantity']) {
	// 			$buy_sell_quantity = $value['quantity'];
	// 		}
	// 	}

	// 	$bid_array = $this->mod_chart3->get_bid_values_for_chart($symbol, $market_value);
	// 	$data['market_sell_depth_arr'] = $bid_array;

	// 	foreach ($bid_array as $key => $value) {

	// 		if ($buy_big_quantity < $value['quantity']) {
	// 			$buy_big_quantity = $value['quantity'];
	// 		}
	// 	}

	// 	if ($buy_big_quantity > $buy_sell_quantity) {
	// 		$biggest_value = $buy_big_quantity;
	// 	} else {
	// 		$biggest_value = $buy_sell_quantity;
	// 	}
	// 	$data['coins'] = $this->mod_coins->get_all_coins();
	// 	$data['biggest_value'] = $biggest_value;
	// 	$data['market_value'] = num($market_value);
	// 	$this->stencil->paint("admin/chart3/chart3", $data);

	// 	$data['biggest_value'] = $biggest_value;
	// 	$data['market_value'] = num($market_value);
	// }

	// public function market_percentage() {
	// 	$coins = $this->mod_coins->get_all_coins();

	// 	foreach ($coins as $key => $coin) {
	// 		$symbol = $coin['symbol'];
	// 		$market_value = $this->mod_chart3->get_market_value($symbol);
	// 		$market_sell_depth_arr = $this->mod_chart3->get_bid_values_for_chart($symbol, $market_value);
	// 		$market_buy_depth_arr = $this->mod_chart3->get_ask_values_for_chart($symbol, $market_value);
	// 		$sell_big_quantity = 0;
	// 		$depth_sell_big_quantity = 0;
	// 		foreach ($market_sell_depth_arr as $key => $value) {

	// 			if ($sell_big_quantity < $value['sell_quantity']) {
	// 				$sell_big_quantity = $value['sell_quantity'];
	// 			}
	// 			if ($depth_sell_big_quantity < $value['depth_sell_quantity']) {
	// 				$depth_sell_big_quantity = $value['depth_sell_quantity'];
	// 			}
	// 		}

	// 		foreach ($market_buy_depth_arr as $key => $value) {

	// 			if ($buy_big_quantity < $value['buy_quantity']) {
	// 				$buy_big_quantity = $value['buy_quantity'];
	// 			}
	// 			if ($depth_buy_big_quantity < $value['depth_buy_quantity']) {
	// 				$depth_buy_big_quantity = $value['depth_buy_quantity'];
	// 			}
	// 		}

	// 		if ($buy_big_quantity > $sell_big_quantity) {
	// 			$biggest_value = $buy_big_quantity;
	// 		} else {
	// 			$biggest_value = $sell_big_quantity;
	// 		}

	// 		if ($depth_buy_big_quantity > $depth_sell_big_quantity) {
	// 			$biggest_value2 = $depth_buy_big_quantity;
	// 		} else {
	// 			$biggest_value2 = $depth_sell_big_quantity;
	// 		}

	// 		foreach ($market_sell_depth_arr as $key => $value) {
	// 			$sell_percentage22 = round($value['depth_sell_quantity'] * 100 / $biggest_value2);
	// 			$buy_percentage22 = round($value['depth_buy_quantity'] * 100 / $biggest_value2);
	// 			$sell_percentage = round($value['sell_quantity'] * 100 / $biggest_value);
	// 			$buy_percentage = round($value['buy_quantity'] * 100 / $biggest_value);
	// 			$type = $value['type'];
	// 			$price = $value['price'];
	// 			$findArr = array('coin' => $symbol, 'price' => $price, 'type' => $type);
	// 			$arrToIns = array(
	// 				'coin' => $symbol,
	// 				'price' => $price,
	// 				'buy_percentage' => $buy_percentage,
	// 				'sell_percentage' => $sell_percentage,
	// 				'depth_buy_per' => $buy_percentage22,
	// 				'depth_sell_per' => $sell_percentage22,
	// 				'type' => $type,
	// 			);
	// 			$db = $this->mongo_db->customQuery();
	// 			$ins_data = $db->trade_percentage->updateOne($findArr, array('$set' => $arrToIns), array('upsert' => true));
	// 		}

	// 		foreach ($market_buy_depth_arr as $key => $value) {

	// 			$sell_percentage22 = round($value['depth_sell_quantity'] * 100 / $biggest_value2);
	// 			$buy_percentage22 = round($value['depth_buy_quantity'] * 100 / $biggest_value2);
	// 			$sell_percentage = round($value['sell_quantity'] * 100 / $biggest_value);
	// 			$buy_percentage = round($value['buy_quantity'] * 100 / $biggest_value);
	// 			$type = $value['type'];
	// 			$price = $value['price'];
	// 			$findArr = array('coin' => $symbol, 'price' => $price, 'type' => $type);
	// 			$arrToIns = array(
	// 				'coin' => $symbol,
	// 				'price' => $price,
	// 				'buy_percentage' => $buy_percentage,
	// 				'sell_percentage' => $sell_percentage,
	// 				'depth_buy_per' => $buy_percentage22,
	// 				'depth_sell_per' => $sell_percentage22,
	// 				'type' => $type,
	// 			);
	// 			$db = $this->mongo_db->customQuery();
	// 			$ins_data = $db->trade_percentage->updateOne($findArr, array('$set' => $arrToIns), array('upsert' => true));
	// 		}

	// 	}
	// }

	// public function get_market_percentage() {
	// 	$res = $this->mongo_db->get('trade_percentage');
	// 	echo "<pre>";
	// 	echo count(iterator_to_array($res));
	// 	exit;
	// }

	// public function testing_swing() {

	// 	$this->mongo_db->order_by(array('timestampDate' => -1));
	// 	$this->mongo_db->where(array('coin' => $symbol));
	// 	$this->mongo_db->where_in('global_swing_parent_status', array('LL', 'HH', 'LH', 'HL'));
	// 	$this->mongo_db->limit(1);
	// 	$row = $this->mongo_db->get('market_chart');
	// 	$data_row = iterator_to_array($row);

	// 	$swing_point = $data_row[$i]['global_swing_parent_status'];

	// 	$datetime = $data_row[$i]['timestampDate'];

	// 	exit;

	// }
	// public function get_contract_info($symbol) {
	// 	$info = $this->mod_coins->get_coin_contract_value($symbol);

	// 	$contract_per = $info['contract_percentage'];
	// 	$contract_time = $info['contract_time'];

	// 	if ($contract_time == 0) {
	// 		$contract_time = 2;
	// 	}

	// 	if ($contract_per == 0) {
	// 		$contract_per = 10;
	// 	}

	// 	$curr_time = date("Y-m-d H:i:s");
	// 	$nowtime = date('Y-m-d H:i:s', strtotime('-' . $contract_time . 'minutes'));

	// 	$search_array['coin'] = $symbol;
	// 	$search_array['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($nowtime));

	// 	$this->mongo_db->where($search_array);
	// 	$this->mongo_db->order_by(array('created_date' => -1));
	// 	$get_arr = $this->mongo_db->get('market_trades');
	// 	$quantity = array();
	// 	foreach ($get_arr as $key => $value) {
	// 		if (!empty($value)) {
	// 			$quantity[] = $value['quantity'];
	// 		}
	// 	}
	// 	rsort($quantity);

	// 	$q_sum = 0;
	// 	$index = round((count($quantity) / 100) * $contract_per);
	// 	for ($i = 0; $i < $index; $i++) {
	// 		$q_sum += $quantity[$i];
	// 	}

	// 	for ($i = 0; $i < count($quantity); $i++) {
	// 		$t_sum += $quantity[$i];
	// 	}

	// 	$q_avg = $q_sum / $index;

	// 	$cal_per = ($q_sum / $t_sum) * 100;
	// 	$ret_arr['avg'] = round($q_avg);
	// 	$ret_arr['per'] = round($cal_per);
	// 	return $ret_arr;
	// }
	// public function get_bid_contract_info($symbol) {
	// 	$info = $this->mod_coins->get_coin_contract_value($symbol);

	// 	$contract_per = $info['contract_percentage'];
	// 	$contract_time = $info['contract_time'];

	// 	if ($contract_time == 0) {
	// 		$contract_time = 2;
	// 	}

	// 	if ($contract_per == 0) {
	// 		$contract_per = 10;
	// 	}

	// 	$curr_time = date("Y-m-d H:i:s");
	// 	$nowtime = date('Y-m-d H:i:s', strtotime('-' . $contract_time . 'minutes'));

	// 	$search_array['coin'] = $symbol;
	// 	/*$search_array['maker'] = 'true';*/
	// 	$search_array['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($nowtime));

	// 	$this->mongo_db->where($search_array);
	// 	$this->mongo_db->order_by(array('created_date' => -1));
	// 	$get_arr = $this->mongo_db->get('market_trades');
	// 	$get_arr_1 = iterator_to_array($get_arr);
	// 	array_multisort(array_column($get_arr_1, "quantity"), SORT_DESC, $get_arr_1);
	// 	$index = round((count($get_arr_1) / 100) * $contract_per);
	// 	for ($i = 0; $i < $index; $i++) {
	// 		if ($get_arr_1[$i]['maker'] == 'true') {
	// 			$q_sum += $get_arr_1[$i]['quantity'];
	// 		}

	// 	}

	// 	$q2 = 0;
	// 	$max_price = 0;
	// 	for ($i = 0; $i < $index; $i++) {
	// 		if ($get_arr_1[$i]['maker'] == 'true') {

	// 			$q = $get_arr_1[$i]['quantity'];
	// 			if ($q2 < $q) {
	// 				$q2 = $q;
	// 				$max_price = $get_arr_1[$i]['price'];
	// 			}
	// 		}

	// 	}
	// 	for ($i = 0; $i < count($get_arr_1); $i++) {
	// 		$t_sum += $get_arr_1[$i]['quantity'];
	// 	}

	// 	$q_avg = $q_sum / $index;

	// 	$cal_per = ($q_sum / $t_sum) * 100;
	// 	$ret_arr['avg'] = round($q_avg);
	// 	$ret_arr['per'] = round($cal_per);
	// 	$ret_arr['max'] = num($max_price);
	// 	return $ret_arr;
	// }
	// public function get_ask_contract_info($symbol) {
	// 	$info = $this->mod_coins->get_coin_contract_value($symbol);

	// 	$contract_per = $info['contract_percentage'];
	// 	$contract_time = $info['contract_time'];

	// 	if ($contract_time == 0) {
	// 		$contract_time = 2;
	// 	}

	// 	if ($contract_per == 0) {
	// 		$contract_per = 10;
	// 	}

	// 	$curr_time = date("Y-m-d H:i:s");
	// 	$nowtime = date('Y-m-d H:i:s', strtotime('-' . $contract_time . 'minutes'));

	// 	$search_array['coin'] = $symbol;

	// 	$search_array['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($nowtime));

	// 	$this->mongo_db->where($search_array);
	// 	$this->mongo_db->order_by(array('created_date' => -1));
	// 	$get_arr = $this->mongo_db->get('market_trades');
	// 	$get_arr_1 = iterator_to_array($get_arr);
	// 	array_multisort(array_column($get_arr_1, "quantity"), SORT_DESC, $get_arr_1);

	// 	$index = round((count($get_arr_1) / 100) * $contract_per);
	// 	$index = round((count($get_arr_1) / 100) * $contract_per);
	// 	for ($i = 0; $i < $index; $i++) {
	// 		if ($get_arr_1[$i]['maker'] == 'false') {
	// 			$q_sum += $get_arr_1[$i]['quantity'];
	// 		}

	// 	}

	// 	$q2 = 0;
	// 	$max_price = 0;
	// 	for ($i = 0; $i < $index; $i++) {
	// 		if ($get_arr_1[$i]['maker'] == 'false') {

	// 			$q = $get_arr_1[$i]['quantity'];
	// 			if ($q2 < $q) {
	// 				$q2 = $q;
	// 				$max_price = $get_arr_1[$i]['price'];
	// 			}
	// 		}

	// 	}

	// 	for ($i = 0; $i < count($get_arr_1); $i++) {
	// 		$t_sum += $get_arr_1[$i]['quantity'];
	// 	}

	// 	$q_avg = $q_sum / $index;

	// 	$cal_per = ($q_sum / $t_sum) * 100;
	// 	$ret_arr['avg'] = round($q_avg);
	// 	$ret_arr['per'] = round($cal_per);
	// 	$ret_arr['max'] = num($max_price);
	// 	return $ret_arr;
	// }

	// public function calculate_wall($coin_symbol, $depth_arr, $type, $biggest_value) {
	// 	if ($type == 'sell') {
	// 		array_multisort(array_column($depth_arr, "price"), SORT_ASC, $depth_arr);
	// 	} elseif ($type == 'buy') {
	// 		array_multisort(array_column($depth_arr, "price"), SORT_DESC, $depth_arr);
	// 	}

	// 	$setting = $this->mod_coins->get_coin_depth_wall_setting($coin_symbol);
	// 	$temp_price = 0.00;
	// 	///////////////////////////////////////////////////////////////////////////////////
	// 	if ($setting == 'percentage') {
	// 		$depth_wall_val = $this->mod_coins->get_coin_depth_wall_percentage($coin_symbol);
	// 		if (count($depth_arr) > 0) {
	// 			$buy_depth_wall2 = 0;
	// 			$temp_price = 0;
	// 			$temps = count($depth_arr);
	// 			for ($temp = $temps - 1; $temp >= 0; $temp--) {

	// 				if ($depth_arr[$temp]['type'] == 'bid') {
	// 					$sell_percentage22 = round($depth_arr[$temp]['depth_sell_quantity'] * 100 / $biggest_value);
	// 					if ($sell_percentage22 > $depth_wall_val && $buy_depth_wall2 == 0) {
	// 						$temp_price = num($depth_arr[$temp]['price']);
	// 						$buy_depth_wall2 = 1;
	// 						break;
	// 					}
	// 				} elseif ($depth_arr[$temp]['type'] == 'ask') {
	// 					$buy_percentage22 = round($depth_arr[$temp]['depth_buy_quantity'] * 100 / $biggest_value);
	// 					if ($buy_percentage22 >= $depth_wall_val && $buy_depth_wall2 == 0) {
	// 						$temp_price = num($depth_arr[$temp]['price']);
	// 						$buy_depth_wall2 = 1;
	// 						break;
	// 					}
	// 				}
	// 			}
	// 		}

	// 	} elseif ($setting == 'amount') {
	// 		$depth_wall_val = $this->mod_coins->get_coin_depth_wall_value($coin_symbol);
	// 		if (count($depth_arr) > 0) {
	// 			$quantity_t = 0;
	// 			$buy_depth_wall2 = 0;
	// 			$temp_price = 0;
	// 			$temps = count($depth_arr);
	// 			for ($temp = $temps - 1; $temp >= 0; $temp--) {
	// 				if ($depth_arr[$temp]['type'] == 'bid') {
	// 					$quantity_t += $depth_arr[$temp]['depth_sell_quantity'];
	// 					if ($quantity_t >= $depth_wall_val && $buy_depth_wall2 == 0) {
	// 						$temp_price = num($depth_arr[$temp]['price']);
	// 						$buy_depth_wall2 = 1;
	// 					}
	// 				} elseif ($depth_arr[$temp]['type'] == 'ask') {
	// 					$quantity_t += $depth_arr[$temp]['depth_buy_quantity'];
	// 					if ($quantity_t >= $depth_wall_val && $buy_depth_wall2 == 0) {

	// 						$temp_price = num($depth_arr[$temp]['price']);
	// 						$buy_depth_wall2 = 1;
	// 					}
	// 				}
	// 			}
	// 		}

	// 	}

	// 	return $temp_price;
	// 	///////////////////////////////////////////////////////////////////////////////////

	// }

	// public function calculate_yellow_wall($coin_symbol, $depth_arr, $type, $biggest_value) {
	// 	if ($type == 'sell') {
	// 		array_multisort(array_column($depth_arr, "price"), SORT_ASC, $depth_arr);
	// 	} elseif ($type == 'buy') {
	// 		array_multisort(array_column($depth_arr, "price"), SORT_DESC, $depth_arr);
	// 	}

	// 	$setting = $this->mod_coins->get_coin_yellow_wall_setting($coin_symbol);
	// 	$temp_price = 0.00;
	// 	///////////////////////////////////////////////////////////////////////////////////
	// 	if ($setting == 'percentage') {
	// 		$depth_wall_val = $this->mod_coins->get_coin_yellow_wall_percentage($coin_symbol);
	// 		if (count($depth_arr) > 0) {
	// 			$buy_depth_wall2 = 0;
	// 			$temp_price = 0;
	// 			$temps = count($depth_arr);
	// 			for ($temp = $temps - 1; $temp >= 0; $temp--) {

	// 				if ($depth_arr[$temp]['type'] == 'bid') {
	// 					$sell_percentage22 = round($depth_arr[$temp]['depth_sell_quantity'] * 100 / $biggest_value);
	// 					if ($sell_percentage22 > $depth_wall_val && $buy_depth_wall2 == 0) {
	// 						$temp_price = num($depth_arr[$temp]['price']);
	// 						$buy_depth_wall2 = 1;
	// 						break;
	// 					}
	// 				} elseif ($depth_arr[$temp]['type'] == 'ask') {
	// 					$buy_percentage22 = round($depth_arr[$temp]['depth_buy_quantity'] * 100 / $biggest_value);
	// 					if ($buy_percentage22 >= $depth_wall_val && $buy_depth_wall2 == 0) {
	// 						$temp_price = num($depth_arr[$temp]['price']);
	// 						$buy_depth_wall2 = 1;
	// 						break;
	// 					}
	// 				}
	// 			}
	// 		}

	// 	} elseif ($setting == 'amount') {
	// 		$depth_wall_val = $this->mod_coins->get_coin_yellow_wall_value($coin_symbol);
	// 		if (count($depth_arr) > 0) {
	// 			$quantity_t = 0;
	// 			$buy_depth_wall2 = 0;
	// 			$temp_price = 0;
	// 			$temps = count($depth_arr);
	// 			for ($temp = $temps - 1; $temp >= 0; $temp--) {
	// 				if ($depth_arr[$temp]['type'] == 'bid') {
	// 					$quantity_t += $depth_arr[$temp]['depth_sell_quantity'];
	// 					if ($quantity_t >= $depth_wall_val && $buy_depth_wall2 == 0) {
	// 						$temp_price = num($depth_arr[$temp]['price']);
	// 						$buy_depth_wall2 = 1;
	// 					}
	// 				} elseif ($depth_arr[$temp]['type'] == 'ask') {
	// 					$quantity_t += $depth_arr[$temp]['depth_buy_quantity'];
	// 					if ($quantity_t >= $depth_wall_val && $buy_depth_wall2 == 0) {

	// 						$temp_price = num($depth_arr[$temp]['price']);
	// 						$buy_depth_wall2 = 1;
	// 					}
	// 				}
	// 			}
	// 		}

	// 	}

	// 	return $temp_price;
	// 	///////////////////////////////////////////////////////////////////////////////////

	// }

	// public function calculate_pressure($market_sell_depth_arr, $market_buy_depth_arr) {
	// 	$pressure_up = 0;
	// 	$pressure_down = 0;

	// 	array_multisort(array_column($market_buy_depth_arr, "price"), SORT_ASC, $market_buy_depth_arr);
	// 	array_multisort(array_column($market_sell_depth_arr, "price"), SORT_DESC, $market_sell_depth_arr);
	// 	for ($i = 0; $i < 5; $i++) {
	// 		//echo num($market_sell_depth_arr[$i]['price']) . ' ===> ' . num($market_buy_depth_arr[$i]['price']) . "<br>";
	// 		$ret_Arr = array();
	// 		if ($market_sell_depth_arr[$i]['depth_sell_quantity'] > $market_buy_depth_arr[$i]['depth_buy_quantity']) {
	// 			$pressure_up++;
	// 			//$pressure_amount = ($market_sell_depth_arr[$i]['quantity'] / $market_buy_depth_arr[$i]['quantity']);
	// 		} elseif ($market_sell_depth_arr[$i]['depth_sell_quantity'] < $market_buy_depth_arr[$i]['depth_buy_quantity']) {
	// 			$pressure_down++;
	// 			/*echo $market_sell_depth_arr[$i]['price'] . " => " . $market_sell_depth_arr[$i]['quantity'];
	// 				echo "<<==>>";
	// 				echo $market_buy_depth_arr[$i]['price'] . " => " . $market_buy_depth_arr[$i]['quantity'];
	// 				echo "DOWN";
	// 			*/
	// 			//$pressure_amount = ($market_buy_depth_arr[$i]['quantity'] / $market_sell_depth_arr[$i]['quantity']);
	// 		}
	// 	}
	// 	return array("up" => $pressure_up, 'down' => $pressure_down);
	// }

	// public function calculate_big_wall($sell_arr, $buy_arr, $biggest_value) {
	// 	$pressure_up = 0;
	// 	$pressure_down = 0;

	// 	array_multisort(array_column($buy_arr, "price"), SORT_ASC, $buy_arr);
	// 	array_multisort(array_column($sell_arr, "price"), SORT_DESC, $sell_arr);

	// 	$bid_max = $sell_arr[0]['depth_sell_quantity'];
	// 	$ask_max = $buy_arr[0]['depth_buy_quantity'];
	// 	for ($i = 0; $i < 5; $i++) {
	// 		if ($bid_max < $sell_arr[$i]['depth_sell_quantity']) {
	// 			$bid_max = $sell_arr[$i]['depth_sell_quantity'];
	// 			$bid_price = $sell_arr[$i]['price'];
	// 		}

	// 		if ($ask_max < $buy_arr[$i]['depth_buy_quantity']) {
	// 			$ask_max = $buy_arr[$i]['depth_buy_quantity'];
	// 			$ask_price = $buy_arr[$i]['price'];
	// 		}
	// 	}

	// 	if ($bid_max > $ask_max) {
	// 		$pressure = 'down';
	// 		$color = 'blue';
	// 		$max_price = $bid_price;
	// 		$max = $bid_max;
	// 		$max_per = ($bid_max / $biggest_value) * 100;
	// 	} elseif ($ask_max > $bid_max) {
	// 		$pressure = 'up';
	// 		$color = 'red';
	// 		$max_price = $ask_price;
	// 		$max_per = ($ask_max / $biggest_value) * 100;
	// 		$max = $ask_max;
	// 	}

	// 	/*if ($bid_max > $ask_max) {
	// 			$pressure = 'down';
	// 			$max_per = ($bid_max / $biggest_value) * 100;
	// 			$max = $bid_max;
	// 		} elseif ($ask_max > $bid_max) {
	// 			$pressure = 'up';
	// 			$max_per = ($ask_max / $biggest_value) * 100;
	// 			$max = $ask_max;
	// 	*/

	// 	$pressure_arr['up_big_wall'] = $ask_max;
	// 	$pressure_arr['down_big_wall'] = $bid_max;
	// 	$pressure_arr['up_big_price'] = $ask_price;
	// 	$pressure_arr['down_big_price'] = $bid_price;
	// 	$pressure_arr['great_wall_price'] = $max_price;
	// 	$pressure_arr['great_wall_quantity'] = $max;
	// 	$pressure_arr['great_wall'] = $pressure;
	// 	$pressure_arr['max_per'] = $max_per;
	// 	$pressure_arr['great_wall_color'] = $color;
	// 	return $pressure_arr;
	// }
	// public function calculate_big_wall_($sell_arr, $buy_arr, $biggest_value) {
	// 	$pressure_up = 0;
	// 	$pressure_down = 0;

	// 	array_multisort(array_column($buy_arr, "price"), SORT_ASC, $buy_arr);
	// 	array_multisort(array_column($sell_arr, "price"), SORT_DESC, $sell_arr);

	// 	$bid_max = $sell_arr[0]['depth_sell_quantity'];
	// 	$ask_max = $buy_arr[0]['depth_buy_quantity'];
	// 	for ($i = 0; $i < 5; $i++) {
	// 		if ($bid_max < $sell_arr[$i]['depth_sell_quantity']) {
	// 			$bid_max = $sell_arr[$i]['depth_sell_quantity'];
	// 			$big_bid = $sell_arr[$i];
	// 		}

	// 		if ($ask_max < $buy_arr[$i]['depth_buy_quantity']) {
	// 			$ask_max = $buy_arr[$i]['depth_buy_quantity'];
	// 			$big_ask = $buy_arr[$i];
	// 		}
	// 	}

	// 	if ($bid_max > $ask_max) {
	// 		$pressure = 'down';
	// 		$max_per = ($bid_max / $biggest_value) * 100;
	// 		$max = $bid_max;
	// 	} elseif ($ask_max > $bid_max) {
	// 		$pressure = 'up';
	// 		$max_per = ($ask_max / $biggest_value) * 100;
	// 		$max = $ask_max;
	// 	}
	// 	return array('pressure' => $pressure, 'max_per' => $max_per, 'max' => $max);
	// }

	// public function calculate_bid_ask_levels($sell_arr, $buy_arr) {
	// 	$pressure_up = 0;
	// 	$pressure_down = 0;

	// 	array_multisort(array_column($buy_arr, "price"), SORT_ASC, $buy_arr);
	// 	array_multisort(array_column($sell_arr, "price"), SORT_DESC, $sell_arr);

	// 	$bid_max = 0;
	// 	$ask_max = 0;
	// 	for ($i = 0; $i < 7; $i++) {

	// 		$bid_max += $sell_arr[$i]['depth_sell_quantity'];
	// 		$ask_max += $buy_arr[$i]['depth_buy_quantity'];
	// 	}

	// 	if ($bid_max > $ask_max) {
	// 		$x = $bid_max / $ask_max;
	// 		$p = 'up';
	// 	} elseif ($ask_max > $bid_max) {
	// 		$x = $ask_max / $bid_max;
	// 		$p = 'down';
	// 	}

	// 	$new_x = $x - 1;
	// 	$new_p = ($new_x / 2) * 100;
	// 	return array('new_x' => number_format($new_x, 2), 'new_p' => $new_p, 'p' => $p);
	// }

	// public function get_barrier_value($market_value, $symbol, $type) {
	// 	if ($type == 'up') {
	// 		$search_arr['barier_value'] = array('$gte' => (float) $market_value);
	// 	}
	// 	if ($type == 'down') {
	// 		$search_arr['barier_value'] = array('$lte' => (float) $market_value);
	// 	}
	// 	$search_arr['coin'] = $symbol;
	// 	$search_arr['barrier_type'] = $type;
	// 	$this->mongo_db->where($search_arr);
	// 	$this->mongo_db->order_by(array('created_date' => -1));
	// 	$this->mongo_db->limit(1);
	// 	$depth_responseArr = $this->mongo_db->get('barrier_values_collection');

	// 	$arr = iterator_to_array($depth_responseArr);
	// 	$barrier = num($arr[0]['barier_value']);

	// 	return $barrier;
	// }

	// public function test_1($symbol = 'NCASHBTC', $type = "up") {
	// 	$search_arr['coin'] = $symbol;
	// 	$search_arr['barrier_type'] = $type;
	// 	$this->mongo_db->where($search_arr);
	// 	$this->mongo_db->order_by(array('created_date' => -1));
	// 	$this->mongo_db->limit(1);
	// 	$depth_responseArr = $this->mongo_db->get('barrier_values_collection');

	// 	$arr = iterator_to_array($depth_responseArr);
	// 	$barrier = num($arr[0]['barier_value']);
	// 	echo $barrier;
	// 	exit;
	// 	$symbol = 'NCASHBTC';
	// 	$market_value = $this->mod_chart3->get_market_value($symbol);
	// 	$market_sell_depth_arr = $this->mod_chart3->get_bid_values_for_chart($symbol, $market_value);

	// 	$market_buy_depth_arr = $this->mod_chart3->get_ask_values_for_chart($symbol, $market_value);

	// 	$up_pressure_arr = $this->calculate_pressure($market_sell_depth_arr, $market_buy_depth_arr);

	// 	echo '<pre>';
	// 	print_r($up_pressure_arr);
	// 	exit();
	// 	$up_pressure = $up_pressure_arr['up'];
	// 	$down_pressure = $up_pressure_arr['down'];

	// }
}