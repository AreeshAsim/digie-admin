<?php
class Chart3_group extends CI_Controller {

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

	public function index() {

		//Login Check
		redirect(base_url()."admin/indicator");
		$this->mod_login->verify_is_admin_login();
		$symbol = $this->session->userdata('global_symbol');
		$offset = $this->mod_coins->get_coin_offset_value($symbol);
		$limit = 50 * $offset;
		$market_value = $this->mod_chart3->get_market_value($symbol);

		//$ask_array = $this->mod_chart3->get_ask_values_for_chart($symbol,$market_value,$limit);
		$final_array = $this->remainder_group($symbol);

		$ask_array = $final_array['asks'];
		$chunks = array_chunk($ask_array, $offset);
		$sumArray = array();
		$new_ask_arr = array();

		foreach ($chunks as $key => $valve) {
			$price = $valve[0]['price'];

			$sumArray = array();
			$sell_quantity = 0;
			$depth_buy_quantity = 0;
			$depth_sell_quantity = 0;
			$buy_quantity = 0;
			foreach ($valve as $k => $val) {

				$sell_quantity += $val['sell_quantity'];
				$sumArray['sell_quantity'] = $sell_quantity;

				$depth_buy_quantity += $val['depth_buy_quantity'];
				$sumArray['depth_buy_quantity'] = $depth_buy_quantity;

				$depth_sell_quantity += $val['depth_sell_quantity'];
				$sumArray['depth_sell_quantity'] = $depth_sell_quantity;

				$buy_quantity += $val['buy_quantity'];
				$sumArray['buy_quantity'] = $buy_quantity;

				$sumArray['price'] = $price;
				$sumArray['coin'] = $val['coin'];
				$sumArray['type'] = $val['type'];
				$sumArray['price'] = $price;

			}
			$new_ask_arr[] = $sumArray;
		}

		array_multisort(array_column($new_ask_arr, "price"), SORT_DESC, $new_ask_arr);

		//$bid_array = $this->mod_chart3->get_bid_values_for_chart($symbol,$market_value,$limit);
		$bid_array = $final_array['bid'];
		$chunks = array_chunk($bid_array, $offset);

		$sumArray = array();
		$new_bid_arr = array();

		foreach ($chunks as $key => $valve) {
			$price = $valve[$offset - 1]['price'];

			$sumArray = array();
			$sell_quantity = 0;
			$depth_buy_quantity = 0;
			$depth_sell_quantity = 0;
			$buy_quantity = 0;

			foreach ($valve as $k => $val) {

				$sell_quantity += $val['sell_quantity'];
				$sumArray['sell_quantity'] = $sell_quantity;

				$depth_buy_quantity += $val['depth_buy_quantity'];
				$sumArray['depth_buy_quantity'] = $depth_buy_quantity;

				$depth_sell_quantity += $val['depth_sell_quantity'];
				$sumArray['depth_sell_quantity'] = $depth_sell_quantity;

				$buy_quantity += $val['buy_quantity'];
				$sumArray['buy_quantity'] = $buy_quantity;

				$sumArray['price'] = $price;
				$sumArray['coin'] = $val['coin'];
				$sumArray['type'] = $val['type'];
				$sumArray['price'] = $price;

			}
			$new_bid_arr[] = $sumArray;
		}
		array_multisort(array_column($new_bid_arr, "price"), SORT_DESC, $new_bid_arr);
		$data['market_buy_depth_arr'] = $new_ask_arr;
		$buy_big_quantity = 0;
		$buy_sell_quantity = 0;
		foreach ($new_ask_arr as $key => $value) {

			if ($buy_sell_quantity < $value['quantity']) {
				$buy_sell_quantity = $value['quantity'];
			}
		}

		$data['market_sell_depth_arr'] = $new_bid_arr;

		foreach ($new_bid_arr as $key => $value) {

			if ($buy_big_quantity < $value['quantity']) {
				$buy_big_quantity = $value['quantity'];
			}
		}

		if ($buy_big_quantity > $buy_sell_quantity) {
			$biggest_value = $buy_big_quantity;
		} else {
			$biggest_value = $buy_sell_quantity;
		}
		$data['biggest_value'] = $biggest_value;
		$data['market_value'] = num($market_value);
		$data['coins'] = $this->mod_coins->get_all_coins();
		$this->stencil->paint("admin/chart3/chart3_group", $data);

	}

	public function test() {
		/*$chart_target_zones_arr = $this->mod_chart3->get_chart_target_zones();
			echo "<pre>";
			print_r($chart_target_zones_arr);
		*/
		/*$this->mongo_db->where(array('coin' => 'NCASHBTC'));
			$depth_responseArr = $this->mongo_db->get('market_chart');
			echo "<pre>";
			print_r(iterator_to_array($depth_responseArr));
		*/
		//$search_array['price'] = 0.00000219;
		/*$this->mongo_db->where(array('_id' => '5b4352ab819e1261bd5c3bb6'));
		$this->mongo_db->delete('market_depth');*/

		/*$admin_id = $this->session->userdata('admin_id');
			$this->mongo_db->order_by(array('_id' => -1));
			$this->mongo_db->where(array('coin' => 'NCASHBTC'));
			$this->mongo_db->where_in('global_swing_parent_status', array('LL', 'HH', 'LH', 'HL'));
			$this->mongo_db->limit(1);
			$row = $this->mongo_db->get('market_chart');
			echo "<pre>";
			print_r(iterator_to_array($row));
		*/

		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('_id' => -1));
		$res = $this->mongo_db->get('market_price_history');
		$res_arr = iterator_to_array($res);
		echo "<pre>";
		var_dump($res_arr[0]);
		exit;
		$val = (float) "0.00000157";
		$symbol = "NCASHBTC";
		$this->mongo_db->where(array('type' => 'bid', 'coin' => $symbol, 'price' => $val));
		$row = $this->mongo_db->get('market_depth');
		echo "<pre>Bid Depth<br>";
		print_r(iterator_to_array($row));

		//ASK DEPTH
		$this->mongo_db->where(array('type' => 'ask', 'coin' => $symbol, 'price' => $val));
		$row3 = $this->mongo_db->get('market_depth');
		echo "<pre>Ask Depth<br>";
		print_r(iterator_to_array($row3));
		exit;
		echo "True Trades <br>";
		$this->mongo_db->where(array('maker' => 'true', 'coin' => $symbol, 'price' => $val));
		$row2 = $this->mongo_db->get('market_trades');
		//print_r(iterator_to_array($row2));
		foreach ($row2 as $depth_valueArr3) {
			if (!empty($depth_valueArr3)) {

				$depth_buy_quantity7 += $depth_valueArr3['quantity'];
			}
		}
		echo $depth_buy_quantity7;
		$this->mongo_db->where(array('maker' => 'false', 'coin' => $symbol, 'price' => $val));
		$row34 = $this->mongo_db->get('market_trades');
		echo "False Trades <br>";
		//print_r(iterator_to_array($row34));
		foreach ($row34 as $depth_valueArr3) {
			if (!empty($depth_valueArr3)) {

				$depth_buy_quantity8 += $depth_valueArr3['quantity'];
			}
		}
		echo $depth_buy_quantity8;
		exit;
	}

	public function autoload_trading_chart_data() {
		//Login Check
		$this->mod_login->verify_is_admin_login();
		$symbol = $this->input->post('symbol');
		if ($symbol == '') {
			$symbol = $this->session->userdata('global_symbol');
		}
		$previous_market_value = $this->input->post('previous_market_value');
		$market_value = $this->mod_chart3->get_market_value($symbol);
		$unit_value = $this->mod_coins->get_coin_unit_value($symbol);
		$offset = $this->mod_coins->get_coin_offset_value($symbol);
		$biggest_value2 = $this->mod_coins->get_coin_base_order($symbol);
		$biggest_value = $this->mod_coins->get_coin_base_history($symbol);
		$limit = 50 * $offset;
		$chunk = $unit_value * $offset;
		$final_array = $this->remainder_group($symbol);

		//$ask_array = $this->mod_chart3->get_ask_values_for_chart($symbol,$market_value,$limit);
		$ask_array = $final_array['asks'];
		$chunks = array_chunk($ask_array, $offset);

		$sumArray = array();
		$new_ask_arr = array();
		foreach ($chunks as $key => $valve) {
			$price = $valve[0]['price'];

			$sumArray = array();
			$sell_quantity = 0;
			$depth_buy_quantity = 0;
			$depth_sell_quantity = 0;
			$buy_quantity = 0;

			foreach ($valve as $k => $val) {

				$sell_quantity += $val['sell_quantity'];
				$sumArray['sell_quantity'] = $sell_quantity;

				$depth_buy_quantity += $val['depth_buy_quantity'];
				$sumArray['depth_buy_quantity'] = $depth_buy_quantity;

				$depth_sell_quantity += $val['depth_sell_quantity'];
				$sumArray['depth_sell_quantity'] = $depth_sell_quantity;

				$buy_quantity += $val['buy_quantity'];
				$sumArray['buy_quantity'] = $buy_quantity;

				$sumArray['price'] = $price;
				$sumArray['coin'] = $val['coin'];
				$sumArray['type'] = $val['type'];
				$sumArray['price'] = $price;

			}
			$new_ask_arr[] = $sumArray;
		}
		$buy_big_quantity = 0;
		$depth_buy_big_quantity = 0;
		$market_buy_depth_arr = $new_ask_arr;
		array_multisort(array_column($market_buy_depth_arr, "price"), SORT_DESC, $market_buy_depth_arr);

		$bid_array = $final_array['bid'];

		$chunks = array_chunk($bid_array, $offset);

		$sumArray = array();
		$new_bid_arr = array();
		foreach ($chunks as $key => $valve) {
			$price = $valve[$offset - 1]['price'];

			$sumArray = array();
			$sell_quantity = 0;
			$depth_buy_quantity = 0;
			$depth_sell_quantity = 0;
			$buy_quantity = 0;

			foreach ($valve as $k => $val) {

				$sell_quantity += $val['sell_quantity'];
				$sumArray['sell_quantity'] = $sell_quantity;

				$depth_buy_quantity += $val['depth_buy_quantity'];
				$sumArray['depth_buy_quantity'] = $depth_buy_quantity;

				$depth_sell_quantity += $val['depth_sell_quantity'];
				$sumArray['depth_sell_quantity'] = $depth_sell_quantity;

				$buy_quantity += $val['buy_quantity'];
				$sumArray['buy_quantity'] = $buy_quantity;

				$sumArray['price'] = $price;
				$sumArray['coin'] = $val['coin'];
				$sumArray['type'] = $val['type'];
				$sumArray['price'] = $price;

			}
			$new_bid_arr[] = $sumArray;
		}

		$market_sell_depth_arr = $new_bid_arr;

		///////////////////////////////////////////////////
		//Get Last Candle Percentages
		$search_arr['candle_type'] = "demand";
		$search_arr['coin'] = $symbol;
		$this->mongo_db->where($search_arr);
		$this->mongo_db->sort(array('created_date' => -1));
		$this->mongo_db->limit(1);
		$depth_responseArr = $this->mongo_db->get('market_chart');
		$data_arr = iterator_to_array($depth_responseArr);



		$bid_val = $data_arr[0]['bid_volume'];
		$high = $data_arr[0]['high'];
		$low = $data_arr[0]['low'];
		$ask_val = $data_arr[0]['ask_volume'];
		$total = $data_arr[0]['total_volume'];

		$bid_per = ($bid_val / $total) * 100;
		$ask_per = ($ask_val / $total) * 100;
		//////////////////////////////////////////////////

		/*$high = $final_array['high'];
		$low = $final_array['low'];*/
		$response = '<ul class="price_s_r_ul">';
		/*if (count($market_buy_depth_arr) > 0) {
			$buy_depth_wall2 = 0;
			$temp_price = 0;
			$temps = count($market_buy_depth_arr);
			for ($temp = $temps - 1; $temp >= 0; $temp--) {

				$sell_percentage22 = round($market_buy_depth_arr[$temp]['depth_sell_quantity'] * 100 / $biggest_value2);
				if ($sell_percentage22 > $depth_wall && $buy_depth_wall2 == 0) {
					$temp_price = num($market_buy_depth_arr[$temp]['price']);
					$buy_depth_wall2 = 1;
					break;
				}
				$buy_percentage22 = round($market_buy_depth_arr[$temp]['depth_buy_quantity'] * 100 / $biggest_value2);
				if ($buy_percentage22 >= $depth_wall && $buy_depth_wall2 == 0) {
					$temp_price = num($market_buy_depth_arr[$temp]['price']);
					$buy_depth_wall2 = 1;
					break;
				}
			}
		}*/
		$temp_price_buy = $this->calculate_wall($symbol, $market_buy_depth_arr, 'buy', $biggest_value2);
		$temp_price_buy22 = $this->calculate_yellow_wall($symbol, $market_buy_depth_arr, 'buy', $biggest_value2);
		$up_barrier = $this->get_barrier_value($market_value, $symbol, 'up');
		$down_barrier = $this->get_barrier_value($market_value, $symbol, 'down');
		if (count($market_buy_depth_arr) > 0) {
			$i = 0;
			$buy_depth_wall = 0;
			foreach ($market_buy_depth_arr as $key => $value) {
				$x++;
				$price = num($value['price']);

				$response .= '<li class="price_s_r_li with_BS" d_price="' . num($price) . '" index="' . $i . '">

			                         <div class="wbs_seller_prog_main widthdepth">
			                            <div class="wbs_red_prog">
			                                <div class="wbs_red_prog_p">' . number_format_short($value['depth_buy_quantity']) . '</div>';
				$buy_percentage22 = round($value['depth_buy_quantity'] * 100 / $biggest_value2);
				if ($buy_percentage22 > 100) {
					$buy_percentage22 = 100;
				}
				if (($price == $temp_price_buy || $price == $temp_price_buy22) && $this->session->userdata('special_role') == 1) {
					if ($price == $temp_price_buy) {

						$response .= '<div class="wbs_red_prog_bar" style="background: black none repeat scroll 0 0;" wbs_d_prog_percent="' . $buy_percentage22 . '"></div>';
					}
					if ($price == $temp_price_buy22) {
						$response .= '<div class="wbs_red_prog_bar" style="background: #FB8C00 none repeat scroll 0 0;" wbs_d_prog_percent="' . $buy_percentage22 . '"></div>';
					}
				} else {
					$response .= '<div class="wbs_red_prog_bar" WBS_d_prog_percent="' . $buy_percentage22 . '"></div>';
				}

				$response .= '</div></div>
			                        <div class="price_cent_main">';
				// if ($high >= (float)num($price) && $low <= (float)num($price)) {
				// 	if ($up_barrier >= num($price) && $up_barrier < num($price + $chunk)) {
				// 		if ($up_barrier == num($price)) {
				// 			$response .= '<span class="simple_p gray_v_p" style="background: #ff4d4d;">' . num($price) . '</span>';
				// 		} else {
				// 			$response .= '<span class="simple_p gray_v_p" style="background: rgba(43, 43, 43, 0.5);">' . num($price) . '</span>';
				// 		}
				// }
				//
				// } else {
				// 	if ($up_barrier >= num($price) && $up_barrier < num($price + $chunk)) {
				// 		$response .= '<span class="simple_p gray_v_p" style="background:#ff4d4d;">' . num($price) . '</span>';
				// 	} else {
				// 		$response .= '<span class="simple_p gray_v_p">' . num($price) . '</span>';
				// 	}
				// }

				if ($high >= (float)num($price) && $low <= (float)num($price)) {
					if ($up_barrier <= num($price) && $up_barrier > num($price - $chunk)) {
						$response .= '<span class="simple_p gray_v_p" style="background: #ff4d4d;">' . num($price) . '</span>';
					} else {
						$response .= '<span class="simple_p gray_v_p" style="background: rgba(43, 43, 43, 0.5);">' . num($price) . '</span>';
					}

				} else {
					if ($up_barrier <= num($price) && $up_barrier > num($price - $chunk)) {
						$response .= '<span class="simple_p gray_v_p" style="background:#ff4d4d;">' . num($price) . '</span>';
					} else {
						$response .= '<span class="simple_p gray_v_p">' . num($price) . '</span>';
					}
				}
				$response .= '</div>
			                        <div class="buyer_prog_main">
			                            <div class="blu_prog">
			                                <div class="blue_prog_p">' . number_format_short($value['sell_quantity']) . '</div>';
				$sell_percentage = round($value['sell_quantity'] * 100 / $biggest_value);
				if ($sell_percentage > 100) {
					$sell_percentage = 100;
				}
				if ($sell_percentage == 100) {
					$type = 'buy';
				}

				$response .= '<div class="blue_prog_bar" d_prog_percent="' . $sell_percentage . '"></div>
			                            </div>
			                        </div>
			                        <div class="seller_prog_main">
			                            <div class="red_prog">
			                                <div class="red_prog_p">' . number_format_short($value['buy_quantity']) . '</div>';
				$buy_percentage = round($value['buy_quantity'] * 100 / $biggest_value);
				if ($buy_percentage > 100) {
					$buy_percentage = 100;
				}
				if ($buy_percentage == 100) {
					$type = 'sell';
				}

				$response .= '<div class="red_prog_bar" d_prog_percent="' . $buy_percentage . '"></div>
			                            </div>
			                        </div>

			                    </li>';

				$i++;

			} //end foreach
		} //end if

		if ($market_value > $previous_market_value) {
			$class = 'GCV_color_green';
			$icon = 'fa fa-arrow-up';
		} elseif ($market_value < $previous_market_value) {
			$class = 'GCV_color_red';
			$icon = 'fa fa-arrow-down';
		} else {
			$class = 'GCV_color_default';
			$icon = '';
		}

		$response .= '<li class="price_s_r_li with_BS" d_price="' . num($market_value) . '" index="' . $i++ . '">
				            <div class="wbs_buyer_prog_main widthdepth">
	                        </div>

				            <div class="price_cent_main">
				                <span class="simple_p white_v_p" id="response2222">
				                 <span class="' . $class . '">' . num($market_value) . '</span>
				                </span>
				            </div>
				            <div class="seller_prog_main">
				                <div class="red_prog">
				                </div>
				            </div>
				            <div class="wbs_seller_prog_main">
	                        </div>
				        </li>';

		if (count($market_sell_depth_arr) > 0) {
			$temp_price_sell = $this->calculate_wall($symbol, $market_sell_depth_arr, 'sell', $biggest_value2);
			$temp_price_sell22 = $this->calculate_yellow_wall($symbol, $market_sell_depth_arr, 'sell', $biggest_value2);
			foreach ($market_sell_depth_arr as $key => $value2) {

				$price22 = num($value2['price']);

				$response .= '<li class="price_s_r_li with_BS" d_price="' . num($price22) . '" index="' . $i . '">
			                        <div class="wbs_buyer_prog_main widthdepth">
			                            <div class="wbs_blu_prog">
			                                <div class="wbs_blue_prog_p">' . number_format_short($value2['depth_sell_quantity']) . '</div>';
				$sell_percentage222 = round($value2['depth_sell_quantity'] * 100 / $biggest_value2);
				if ($sell_percentage222 > 100) {
					$sell_percentage222 = 100;
				}
				if (($price22 == $temp_price_sell || $price22 == $temp_price_sell22) && $this->session->userdata('special_role') == 1) {
					if ($price22 == $temp_price_sell) {
						$response .= '<div class="wbs_blue_prog_bar" style=" background: black none repeat scroll 0 0;" WBS_d_prog_percent="' . $sell_percentage222 . '"></div>';
					}
					if ($price22 == $temp_price_sell22) {
						$response .= '<div class="wbs_blue_prog_bar" style=" background:  #FB8C00 none repeat scroll 0 0;" WBS_d_prog_percent="' . $sell_percentage222 . '"></div>';
					}
				} else {
					$response .= '<div class="wbs_blue_prog_bar" WBS_d_prog_percent="' . $sell_percentage222 . '"></div>';
				}
				$response .= '</div>
			                        </div>



			                        <div class="price_cent_main">';

				if ($high >= (float)num($price22) && $low <= (float)num($price22)) {
					if ($down_barrier <= num($price22) && $down_barrier > num($price22 - $chunk)) {
						$response .= '<span class="simple_p gray_v_p" style="background: #4b7bec;">' . num($price22) . '</span>';
					} else {
						$response .= '<span class="simple_p gray_v_p" style="background: rgba(43, 43, 43, 0.5);">' . num($price22) . '</span>';
					}

				} else {
					if ($down_barrier <= num($price22) && $down_barrier > num($price22 - $chunk)) {
						$response .= '<span class="simple_p gray_v_p" style="background:#4b7bec;">' . num($price22) . '</span>';
					} else {
						$response .= '<span class="simple_p gray_v_p">' . num($price22) . '</span>';
					}
				}
				$response .= '</div>

			                        <div class="buyer_prog_main">
			                            <div class="blu_prog">
			                                <div class="blue_prog_p">' . number_format_short($value2['sell_quantity']) . '</div>';
				$sell_percentage2 = round($value2['sell_quantity'] * 100 / $biggest_value);
				if ($sell_percentage2 > 100) {
					$sell_percentage2 = 100;
				}
				if ($sell_percentage2 == 100) {
					$type = 'buy';
				}

				$response .= '<div class="blue_prog_bar" d_prog_percent="' . $sell_percentage2 . '"></div>
			                            </div>
			                        </div>

			                         <div class="seller_prog_main">
			                            <div class="red_prog">
			                                <div class="red_prog_p">' . number_format_short($value2['buy_quantity']) . '</div>';
				$buy_percentage2 = round($value2['buy_quantity'] * 100 / $biggest_value);
				if ($buy_percentage2 > 100) {
					$buy_percentage2 = 100;
				}
				if ($buy_percentage2 == 100) {
					$type = 'sell';
				}

				$response .= '<div class="red_prog_bar" d_prog_percent="' . $buy_percentage2 . '"></div>
			                            </div>
			                        </div>
			                    </li>';

				$i++;

			} //end foreach
		} //end if

		$response .= '</ul>';

		//GEt Zone values
		$zone_values_arr = $this->mod_chart3->get_zone_values($market_value, $symbol);

		$buy_quantity = $zone_values_arr['buy_quantity'];
		$sell_quantity = $zone_values_arr['sell_quantity'];
		$buy_percentage = $zone_values_arr['buy_percentage'];
		$sell_percentage = $zone_values_arr['sell_percentage'];
		$zone_id = $zone_values_arr['zone_id'];

		$response2 = '<div class="G_current_val ' . $class . '">
			                <div class="GCV_text"><b>' . num($market_value) . '</b></div>
			                <div class="GCV_icon">
			                    <i class="' . $icon . '" aria-hidden="true"></i>
			                </div>
			            </div>';

		$response3 = $market_value;

		if ($zone_id != "" && $buy_percentage != 'NAN' && $sell_quantity != 'NAN') {

			$response4 = '<div class="verti_bar_prog_top" d_vbpPercent="' . $buy_percentage . '">
		                    <span>' . $buy_quantity . '</span>
		                 </div>
		                 <div class="verti_bar_prog_bottom" d_vbpPercent="' . $sell_percentage . '">
		                    <span>' . $sell_quantity . '</span>
		                 </div>';

		} else {
			$response4 = '';
		}

		//Get zones Record
		$chart_target_zones_arr = array();
		$chart_target_zones_arr = $this->mod_chart3->get_chart_target_zones();

		//Get Sell Orders
		$orders_arr = $this->mod_chart3->get_sell_active_orders();

		//Get Buy Orders
		$buy_orders_arr = $this->mod_chart3->get_buy_active_orders();

		$current = $this->get_current_candle_volume($symbol);
		$curr_bid_per = $current['bid_per'];
		$curr_ask_per = $current['ask_per'];
		$curr_bid = $current['bid_vol'];
		$curr_ask = $current['ask_vol'];

		$rolling = $this->get_rolling_candle_volume($symbol);
		$roll_bid_per = $rolling['bid_per'];
		$roll_ask_per = $rolling['ask_per'];
		$roll_bid = $rolling['bid_vol'];
		$roll_ask = $rolling['ask_vol'];

		//Last Swing Candle

		$this->mongo_db->order_by(array('_id' => -1));
		$this->mongo_db->where(array('coin' => $symbol));
		$this->mongo_db->where_in('global_swing_status', array('LL', 'HH', 'LH', 'HL'));
		$this->mongo_db->limit(1);
		$row = $this->mongo_db->get('market_chart');
		$data_row = iterator_to_array($row);

		$swing_point = $data_row[0]['global_swing_status'];
		$contract_info = $this->get_contract_info($symbol);
		$bid_contract_info = $this->get_bid_contract_info($symbol);
		$ask_contract_info = $this->get_ask_contract_info($symbol);

		$contract_html = number_format_short($contract_info['avg']) . '<br><h4 style="font-size:14px;">' . $contract_info['per'] . ' %</h4>';
		$bid_contract_html = number_format_short($bid_contract_info['avg']) . '<br><h4 style="font-size:14px;">' . $bid_contract_info['max'] . '(' . $bid_contract_info['per'] . ' %)</h4>';
		$ask_contract_html = number_format_short($ask_contract_info['avg']) . '<br><h4 style="font-size:14px;">' . $ask_contract_info['max'] . '(' . $ask_contract_info['per'] . ' %)</h4>';
		$pre_time = date('Y-m-d H:i:00');
		$up_pressure_arr = $this->calculate_pressure($market_sell_depth_arr, $market_buy_depth_arr);
		$up_pressure = $up_pressure_arr['up'];
		$down_pressure = $up_pressure_arr['down'];
		$pressure_wall_array = $this->calculate_big_wall($market_sell_depth_arr, $market_buy_depth_arr, $biggest_value2);
		$big_val = $pressure_wall_array['max'];
		$big_per = $pressure_wall_array['max_per'];
		$pressure_wall = $pressure_wall_array['pressure'];

		if ($up_pressure > $down_pressure) {
			$new_pressure = $up_pressure - $down_pressure;
			$new_p = ($new_pressure / 5) * 100;
			$color_code = 'up';
			$depth_pressure = $new_pressure;
		} else {
			$new_pressure = $down_pressure - $up_pressure;
			$new_p = ($new_pressure / 5) * 100;
			$color_code = 'down';
			$depth_pressure = -1 * $new_pressure;
		}

		$bid_avg = $bid_contract_info['avg'];
		$ask_avg = $ask_contract_info['avg'];
		if ($bid_avg > $ask_avg) {
			$percentage = $bid_contract_info['per'];
			$val = $bid_avg;
			$v_press = 'up';
		} else {
			$percentage = $ask_contract_info['per'];
			$val = $ask_avg;
			$v_press = 'down';
		}
		//$bid_diff = (num($market_value) - $temp_price_sell) / $unit_value;
		//$ask_diff = ($temp_price_buy - num($market_value)) / $unit_value;
		array_multisort(array_column($market_buy_depth_arr, "price"), SORT_ASC, $market_buy_depth_arr);
		$bid_diff = $key = array_search($temp_price_sell, array_column($market_sell_depth_arr, 'price'));
		$ask_diff = $key = array_search($temp_price_buy, array_column($market_buy_depth_arr, 'price'));

		$y_bid_diff = $key = array_search($temp_price_sell22, array_column($market_sell_depth_arr, 'price'));
		$y_ask_diff = $key = array_search($temp_price_buy22, array_column($market_buy_depth_arr, 'price'));

		$up_b = $key = array_search($up_barrier, array_column($market_sell_depth_arr, 'price'));
		$down_b = $key = array_search($down_barrier, array_column($market_buy_depth_arr, 'price'));
		//echo $ask_diff = 50 - $ask_diff;
		if ($up_b > $down_b) {
			$b_p = ($up_b) - $down_b;
			$b_c = 'down';
		} else {
			$b_p = $down_b - $up_b;
			$b_c = 'up';
		}

		if ($bid_diff > $ask_diff) {
			$new_pressure1 = ($bid_diff) - $ask_diff;
			$new_p1 = ($new_pressure1 / 10) * 100;
			$color_code1 = 'down';
			$black_pressure = -1 * $new_pressure1;
		} else {
			$new_pressure1 = $ask_diff - $bid_diff;
			$new_p1 = ($new_pressure1 / 10) * 100;
			$color_code1 = 'up';
			$black_pressure = $new_pressure1;
		}

		if ($y_bid_diff > $y_ask_diff) {
			$new_pressure3 = ($y_bid_diff) - $y_ask_diff;
			$new_p3 = ($new_pressure3 / 10) * 100;
			$color_code3 = 'down';
			$yellow_pressure = -1 * $new_pressure2;
		} else {
			$new_pressure3 = $y_ask_diff - $y_bid_diff;
			$new_p3 = ($new_pressure3 / 10) * 100;
			$color_code3 = 'up';
			$yellow_pressure = $new_pressure2;
		}
		$levels = $this->calculate_bid_ask_levels($market_sell_depth_arr, $market_buy_depth_arr);
		$new_pressure2 = $levels['new_x'];
		$new_p2 = $levels['new_p'];
		$color_code2 = $levels['p'];

		$depth_pressure11 = $this->generate_meter(10, $depth_pressure);
		$black_pressure22 = $this->generate_meter(10, $black_pressure);
		$yellow_pressure22 = $this->generate_meter(10, $yellow_pressure);
		$response5 = '<div class="bottom_prog_left">
                          <div class="bottom_prog_one">
                              <div class="bottom_prog_title">
                                  <h2>Delta S/R</h2>
                                </div>
                                ' . $depth_pressure11 . '
                            </div>
                            <div class="bottom_prog_two">
                              <div class="bottom_prog_title">
                                  <h2>Wall 1<sub>Y</sub></h2>
                                </div>
							' . $yellow_pressure22 . '
                            </div>
                            <div class="bottom_prog_three">
                              <div class="bottom_prog_title">
                                  <h2>Wall 2<sub>B</sub></h2>
                                </div>
                              ' . $black_pressure22 . '
                            </div>
                        </div>';
////////////////////////////////////////////////////////////////////////////////////////////////

		if ($this->session->userdata('special_role') == 1) {
			$response5 .= '<div class="bottom_prog_left">
                          <div class="bottom_prog_one">
                              <div class="bottom_prog_title">
                                  <h2>Delta Pressure</h2>
                                </div>
                                <div class="bottom_progress">';
		if ($color_code2 == 'up') {
			$response5 .= '<div class="prog_box" style="width:' . number_format($new_p2) . '%; background:#4484FF;">' . $new_pressure2 . '</div>';
		} elseif ($color_code2 == 'down') {
			$response5 .= '<div class="prog_box" style="width:' . number_format($new_p2) . '%; background:#f11919;">' . $new_pressure2 . '</div>';
		}
		}else{
			$response5 .= '<div class="bottom_prog_left">
                          <div class="bottom_prog_one">
                              <div class="bottom_prog_title">
                                  <h2>Delta Pressure</h2>
                                </div>
                                <div class="bottom_progress">';
		}

		$response5 .= '</div>
                            </div>
                            <div class="bottom_prog_two">
                              <div class="bottom_prog_title">
                                  <h2>DC Wall</h2>
                                </div>
                                <div class="bottom_progress">';
		if ($pressure_wall == 'down') {
			$response5 .= '<div class="prog_box" style="width:' . number_format($big_per) . '%; background:#4484FF;">' . number_format_short($big_val) . '</div>';
		} elseif ($pressure_wall == 'up') {
			$response5 .= '<div class="prog_box" style="width:' . number_format($big_per) . '%; background:#f11919;">' . number_format_short($big_val) . '</div>';
		}
		$response5 .= '</div>
                            </div>
                            <div class="bottom_prog_three">
                              <div class="bottom_prog_title">
                                  <h2>OBD <sub>QV</sub></h2>
                                </div>
                                <div class="bottom_progress">';
		if ($v_press == 'down') {
			$response5 .= '<div class="prog_box" style="width:' . number_format($percentage) . '%; background:#4484FF;">' . number_format_short($val) . '</div>';
		} elseif ($v_press == 'up') {
			$response5 .= '<div class="prog_box" style="width:' . number_format($percentage) . '%; background:#f11919;">' . number_format_short($val) . '</div>';
		}
		$response5 .= '</div>
                            </div>
                        </div>';
		$bid_ask_level = $this->calculate_fifteen_minutes_contracts($symbol);
		$bid_candle_p = $bid_ask_level['bid'];
		$ask_candle_p = $bid_ask_level['ask'];

		$contract_one = $this->get_contracts_one($symbol);
		$contract_two = $this->get_contracts_two($symbol);

		/*$array = array(
			"bid_quantity" => number_format_short($bid_quantity),
			"ask_quantity" => number_format_short($ask_quantity),
			"bids" => round($bid_per),
			"asks" => round($ask_per),
			"time_string" => $time,
		);*/

		$score_arr = array(
			'depth_pressure' => $new_pressure,
			'depth_pressure_side' => $color_code,
			'black_pressure' => $new_pressure1,
			'black_color_side' => $color_code1,
			'yellow_pressure' => $new_pressure3,
			'yellow_color_side' => $color_code3,
			'seven_level' => $new_pressure2,
			'seven_level_side' => $color_code2,
			'big_pressure' => $pressure_wall,
			'buyers' => $roll_ask_per,
			'sellers' => $roll_bid_per,
			'big_sellers' => $bid_contract_info['per'],
			'big_buyers' => $ask_contract_info['per'],
			'barrier_diff' => $b_p,
			'barrier_side' => $b_c,
			'swing_status' => $swing_point,
			'taf' => $ask_candle_p,
			'tbf' => $bid_candle_p,
			't_h_b' => $contract_two['bids'],
			't_h_a' => $contract_two['asks'],

		);
		$score_array = $this->calculate_score($score_arr);

		$response5 .= $score_array;

		/*$contract_one = $this->get_contracts_one($symbol);
		$contract_two = $this->get_contracts_two($symbol);*/

		echo $response . "|" . $response2 . "|" . $response3 . "|" . $type . "|" . json_encode($chart_target_zones_arr) . "|" . $response4 . "|" . json_encode($orders_arr) . "|" . json_encode($buy_orders_arr) . "|" . round($bid_per) . "|" . round($ask_per) . "|" . round($curr_bid_per) . "|" . round($curr_ask_per) . "|" . number_format_short($curr_bid) . "|" . number_format_short($curr_ask) . "|" . number_format_short($bid_val) . "|" . number_format_short($ask_val) . "|" . $swing_point . "|" . $contract_html . "|" . $bid_contract_html . "|" . $ask_contract_html . "|" . round($roll_bid_per) . "|" . round($roll_ask_per) . "|" . number_format_short($roll_bid) . "|" . number_format_short($roll_ask) . "|" . $up_pressure . "|" . $down_pressure . "|" . $pressure_wall . "|" . $response5 . "|" . json_encode($contract_one) . "|" . json_encode($contract_two) . "|" . $bid_candle_p . "|" . $ask_candle_p;
		exit;
	} //end autoload_trading_chart_data222

	public function get_current_candle_volume($symbol) {
		$datetime = date("Y-m-d H:00:00");
		$orig_date22 = new DateTime($datetime);
		$orig_date22 = $orig_date22->getTimestamp();
		$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);

		$search['created_date'] = array('$gte' => $end_date);
		$search['coin'] = $symbol;
		$search['maker'] = 'true';

		$this->mongo_db->where($search);
		$get = $this->mongo_db->get("market_trades");

		$res = iterator_to_array($get);
		$bid_vol = 0;
		foreach ($res as $key => $value) {
			$vol = $value['quantity'];
			$bid_vol += $vol;
		}

		$search['created_date'] = array('$gte' => $end_date);
		$search['coin'] = $symbol;
		$search['maker'] = 'false';

		$this->mongo_db->where($search);
		$get = $this->mongo_db->get("market_trades");

		$res = iterator_to_array($get);
		$ask_vol = 0;
		foreach ($res as $key => $value) {
			$vol = $value['quantity'];
			$ask_vol += $vol;
		}
		$total_volume = $bid_vol + $ask_vol;

		$bid_per = ($bid_vol * 100) / $total_volume;
		$ask_per = ($ask_vol * 100) / $total_volume;

		return array(
			'bid_per' => $bid_per,
			'ask_per' => $ask_per,
			'bid_vol' => $bid_vol,
			'ask_vol' => $ask_vol,
		);
	}

	public function get_rolling_candle_volume($symbol) {
		$datetime = date("Y-m-d H:i:s", strtotime('-5 minutes'));
		$orig_date22 = new DateTime($datetime);
		$orig_date22 = $orig_date22->getTimestamp();
		$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);

		$search['created_date'] = array('$gte' => $end_date);
		$search['coin'] = $symbol;
		$search['maker'] = 'true';

		$this->mongo_db->where($search);
		$get = $this->mongo_db->get("market_trades");

		$res = iterator_to_array($get);
		$bid_vol = 0;
		foreach ($res as $key => $value) {
			$vol = $value['quantity'];
			$bid_vol += $vol;
		}

		$search['created_date'] = array('$gte' => $end_date);
		$search['coin'] = $symbol;
		$search['maker'] = 'false';

		$this->mongo_db->where($search);
		$get = $this->mongo_db->get("market_trades");

		$res = iterator_to_array($get);
		$ask_vol = 0;
		foreach ($res as $key => $value) {
			$vol = $value['quantity'];
			$ask_vol += $vol;
		}
		$total_volume = $bid_vol + $ask_vol;

		$bid_per = ($bid_vol * 100) / $total_volume;
		$ask_per = ($ask_vol * 100) / $total_volume;

		return array(
			'bid_per' => $bid_per,
			'ask_per' => $ask_per,
			'bid_vol' => $bid_vol,
			'ask_vol' => $ask_vol,
		);
	}

	public function remainder_group($symbol) {
		//$symbol = $this->session->userdata('global_symbol');
		$market_value = $this->mod_chart3->get_market_value($symbol);
		$valasss = $market_value;
		$offset = $this->mod_coins->get_coin_offset_value($symbol);
		$limit = 50 * $offset;
		$fullarray = array();
		$final_array = array();
		$coin_value = $this->mod_coins->get_coin_unit_value($symbol);

		/*
			=================================================================*/
		$this->mongo_db->where(array('type' => 'ask', 'coin' => $symbol, 'price' => (float) $valasss));
		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('created_date' => -1));
		$depth_responseArr5 = $this->mongo_db->get('market_depth');

		foreach ($depth_responseArr5 as $depth_valueArr5) {
			if (!empty($depth_valueArr5)) {
				$low_depth += $depth_valueArr5['quantity'];
			}
		}
		$this->mongo_db->where(array('type' => 'bid', 'coin' => $symbol, 'price' => (float) $valasss));
		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('created_date' => -1));
		$depth_responseArr6 = $this->mongo_db->get('market_depth');

		foreach ($depth_responseArr6 as $depth_valueArr5) {
			if (!empty($depth_valueArr5)) {
				$up_depth += $depth_valueArr5['quantity'];
			}
		}

		if (empty($up_depth)) {$market = 'down';}
		if (empty($down_depth)) {$market = 'up';}
		/*=================================================================
		*/
		$mvalue = num($market_value);

		$divider = num($offset * $coin_value);

		$remainder = fmod($mvalue, $divider);
		$remainder_tes = num($remainder);
		$resultant = num($divider - $remainder);

		if ($offset != 1) {
			$num_Val = (float) ($mvalue + ($resultant));
			$val = $num_Val;
		} else {
			$num_Val = (float) $mvalue;
			$val = $num_Val + $coin_value;
		}

		if ($remainder_tes != '0.00000000' && $resultant == '0.00000000') {
			$val = $num_Val + $remainder;
		}
		for ($i = 0; $i < $limit; $i++) {
			$depth_buy_quantity1 = 0;
			$depth_buy_quantity2 = 0;
			$depth_buy_quantity3 = 0;
			$depth_buy_quantity4 = 0;
			if ($i == 0) {
				if ($offset != 1 && $resultant != '0.00000000') {$num_Val = $num_Val - $divider;}
			}
			if ($i != 0) {
				$num_Val += $coin_value;
			}
			$num_Val = trim($num_Val);
			$num_Val = (float) $num_Val;

			if ($num_Val < 0) {
				continue;
			}
			$this->mongo_db->where(array('type' => 'ask', 'coin' => $symbol, 'price' => $num_Val));
			$depth_responseArr5 = $this->mongo_db->get('market_depth');

			foreach ($depth_responseArr5 as $depth_valueArr5) {
				if (!empty($depth_valueArr5)) {
					$depth_buy_quantity1 += $depth_valueArr5['quantity'];
				}
			}
			$this->mongo_db->where(array('type' => 'bid', 'coin' => $symbol, 'price' => $num_Val));
			$depth_responseArr6 = $this->mongo_db->get('market_depth');

			foreach ($depth_responseArr6 as $depth_valueArr6) {
				if (!empty($depth_valueArr6)) {

					$depth_buy_quantity2 += $depth_valueArr6['quantity'];
				}
			}
			$this->mongo_db->order_by(array('timestampDate' => -1));
			$this->mongo_db->where(array('coin' => $symbol));
			$this->mongo_db->where_in('global_swing_parent_status', array('LL', 'HH', 'LH', 'HL'));
			$this->mongo_db->limit(1);
			$depth_responseArr = $this->mongo_db->get('market_chart');

			//market_trade_hourly_history
			$arr = iterator_to_array($depth_responseArr);
			if (!empty($arr)) {
				$datetime = $arr[0]['timestampDate']->toDateTime();
				$created_date = $datetime->format(DATE_RSS);

				$datetime = new DateTime($created_date);
				$datetime->format('Y-m-d H:i:s');

				$formated_date_time = $datetime->format('Y-m-d H:i:s');
				$end_date = date('Y-m-d H:i:s');

				$responseArr2222 = $this->mod_chart3->get_price_volume_for_hour($symbol, $formated_date_time, $end_date, "bid", $num_Val);
				$this->mongo_db->where(array('maker' => 'true', 'coin' => $symbol, 'price' => $num_Val, 'created_date' => array('$gte' => $this->mongo_db->converToMongodttime(date('Y-m-d H:00:00', strtotime($end_date))))));
				$responseArr22223 = $this->mongo_db->get('market_trades');

				foreach ($responseArr22223 as $depth_valueArr3) {
					if (!empty($depth_valueArr3)) {

						$depth_buy_quantity3 += $depth_valueArr3['quantity'];
					}
				}
				$buy_quantity = 0;
				foreach ($responseArr2222 as $valueArr222) {

					if (!empty($valueArr222)) {

						$depth_buy_quantity3 += $valueArr222['volume'];
					}

				}

				$responseArr2222 = $this->mod_chart3->get_price_volume_for_hour($symbol, $formated_date_time, $end_date, "ask", $num_Val);
				//$responseArr2222 = $this->mongo_db->get('market_trades');

				//////////////
				$this->mongo_db->where(array('maker' => 'false', 'coin' => $symbol, 'price' => $num_Val, 'created_date' => array('$gte' => $this->mongo_db->converToMongodttime(date('Y-m-d H:00:00', strtotime($end_date))))));
				$responseArr22224 = $this->mongo_db->get('market_trades');
				foreach ($responseArr22224 as $depth_valueArr4) {
					if (!empty($depth_valueArr4)) {

						$depth_buy_quantity4 += $depth_valueArr4['quantity'];
					}
				}
				foreach ($responseArr2222 as $valueArr222) {

					if (!empty($valueArr222)) {

						$depth_buy_quantity4 += $valueArr222['volume'];
					}

				}

			} else {
				$this->mongo_db->where(array('maker' => 'true', 'coin' => $symbol, 'price' => $num_Val));
				$responseArr22223 = $this->mongo_db->get('market_trades');

				foreach ($responseArr22223 as $depth_valueArr3) {
					if (!empty($depth_valueArr3)) {

						$depth_buy_quantity3 += $depth_valueArr3['quantity'];
					}
				}
				$this->mongo_db->where(array('maker' => 'false', 'coin' => $symbol, 'price' => $num_Val));
				$responseArr22224 = $this->mongo_db->get('market_trades');
				foreach ($responseArr22224 as $depth_valueArr4) {
					if (!empty($depth_valueArr4)) {

						$depth_buy_quantity4 += $depth_valueArr4['quantity'];
					}
				}
			}

			$returArr['price'] = $num_Val;
			$returArr['quantity'] = $depth_buy_quantity1;
			$returArr['type'] = 'ask';
			$returArr['coin'] = $symbol;
			$returArr['depth_buy_quantity'] = $depth_buy_quantity1;
			$returArr['depth_sell_quantity'] = $depth_buy_quantity2;
			$returArr['buy_quantity'] = $depth_buy_quantity3;
			$returArr['sell_quantity'] = $depth_buy_quantity4;
			$fullarray[] = $returArr;
		}
		//$val = $market_value;

		$final_array['asks'] = $fullarray;
		$fullarray = array();
		for ($i = 0; $i < $limit; $i++) {
			$depth_buy_quantity5 = 0;
			$depth_buy_quantity6 = 0;
			$depth_buy_quantity7 = 0;
			$depth_buy_quantity8 = 0;
			$val -= $coin_value;

			$val = trim($val);
			$val = (float) $val;

			if ($val < 0.00000000) {
				continue;
			}
			$this->mongo_db->where(array('type' => 'ask', 'coin' => $symbol, 'price' => $val));
			$this->mongo_db->limit(1);
			$this->mongo_db->order_by(array('created_date' => -1));
			$depth_responseArr5 = $this->mongo_db->get('market_depth');

			foreach ($depth_responseArr5 as $depth_valueArr5) {
				if (!empty($depth_valueArr5)) {
					$depth_buy_quantity5 += $depth_valueArr5['quantity'];
				}
			}
			$this->mongo_db->where(array('type' => 'bid', 'coin' => $symbol, 'price' => $val));
			$this->mongo_db->limit(1);
			$this->mongo_db->order_by(array('created_date' => -1));
			$depth_responseArr6 = $this->mongo_db->get('market_depth');

			foreach ($depth_responseArr6 as $depth_valueArr6) {
				if (!empty($depth_valueArr6)) {

					$depth_buy_quantity6 += $depth_valueArr6['quantity'];
				}
			}

			$this->mongo_db->order_by(array('timestampDate' => -1));
			$this->mongo_db->where(array('coin' => $symbol));
			$this->mongo_db->where_in('global_swing_parent_status', array('LL', 'HH', 'LH', 'HL'));
			$this->mongo_db->limit(1);
			$depth_responseArr = $this->mongo_db->get('market_chart');

			//market_trade_hourly_history
			$arr = iterator_to_array($depth_responseArr);
			if (!empty($arr)) {
				$datetime = $arr[0]['timestampDate']->toDateTime();
				$created_date = $datetime->format(DATE_RSS);

				$datetime = new DateTime($created_date);
				$datetime->format('Y-m-d H:i:s');

				//$new_timezone = new DateTimeZone('Asia/Karachi');
				//$datetime->setTimezone($new_timezone);
				$formated_date_time = $datetime->format('Y-m-d H:i:s');
				$end_date = date('Y-m-d H:i:s');

				$responseArr2222 = $this->mod_chart3->get_price_volume_for_hour($symbol, $formated_date_time, $end_date, "bid", $val);
				//////////////
				$buy_quantity = 0;
				$this->mongo_db->where(array('maker' => 'true', 'coin' => $symbol, 'price' => $val, 'created_date' => array('$gte' => $this->mongo_db->converToMongodttime(date('Y-m-d H:00:00', strtotime($end_date))))));
				$responseArr22223 = $this->mongo_db->get('market_trades');

				foreach ($responseArr22223 as $depth_valueArr3) {
					if (!empty($depth_valueArr3)) {

						$depth_buy_quantity7 += $depth_valueArr3['quantity'];
					}
				}
				foreach ($responseArr2222 as $valueArr222) {

					if (!empty($valueArr222)) {

						$depth_buy_quantity7 += $valueArr222['volume'];
					}

				}

				$responseArr2222 = $this->mod_chart3->get_price_volume_for_hour($symbol, $formated_date_time, $end_date, "ask", $val);
				//$responseArr2222 = $this->mongo_db->get('market_trades');

				//////////////
				$this->mongo_db->where(array('maker' => 'false', 'coin' => $symbol, 'price' => $val, 'created_date' => array('$gte' => $this->mongo_db->converToMongodttime(date('Y-m-d H:00:00', strtotime($end_date))))));
				$responseArr22224 = $this->mongo_db->get('market_trades');
				foreach ($responseArr22224 as $depth_valueArr4) {
					if (!empty($depth_valueArr4)) {

						$depth_buy_quantity8 += $depth_valueArr4['quantity'];
					}
				}

				foreach ($responseArr2222 as $valueArr222) {

					if (!empty($valueArr222)) {

						$depth_buy_quantity8 += $valueArr222['volume'];
					}
				}
			} else {
				$this->mongo_db->where(array('maker' => 'true', 'coin' => $symbol, 'price' => $val));
				$responseArr22223 = $this->mongo_db->get('market_trades');

				foreach ($responseArr22223 as $depth_valueArr3) {
					if (!empty($depth_valueArr3)) {

						$depth_buy_quantity7 += $depth_valueArr3['quantity'];
					}
				}
				$this->mongo_db->where(array('maker' => 'false', 'coin' => $symbol, 'price' => $val));
				$responseArr22224 = $this->mongo_db->get('market_trades');
				foreach ($responseArr22224 as $depth_valueArr4) {
					if (!empty($depth_valueArr4)) {

						$depth_buy_quantity8 += $depth_valueArr4['quantity'];
					}
				}
			}

			$returArr['price'] = $val;
			$returArr['quantity'] = $depth_buy_quantity5
			;
			$returArr['type'] = 'bid';
			$returArr['coin'] = $symbol;
			$returArr['depth_buy_quantity'] = $depth_buy_quantity5;
			$returArr['depth_sell_quantity'] = $depth_buy_quantity6;
			$returArr['buy_quantity'] = $depth_buy_quantity7;
			$returArr['sell_quantity'] = $depth_buy_quantity8;
			$fullarray[] = $returArr;
		}
		$final_array['bid'] = $fullarray;
		/*echo "<pre>";
			  		print_r($final_array);
		*/
		return $final_array;
	}

	public function update_order_details() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		$type = $this->input->post('type');
		$order_id = $this->input->post('id');

		if ($type == 'sell') {

			//edit_order
			$edit_order = $this->mod_chart3->edit_order($this->input->post());
			$this->get_order_details($order_id, $type);

		} else {

			//edit_buy_order
			$edit_buy_order = $this->mod_chart3->edit_buy_order($this->input->post());
			$this->get_order_details($order_id, $type);

		}

	} //End update_order_details

	public function add_order_details() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		$order_id = $this->mod_chart3->add_buy_order($this->input->post());
		$type = 'buy';
		$this->get_order_details($order_id, $type);

	} //End update_order_details

	public function get_order_details($order_id, $type) {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		if ($type == 'sell') {

			$order_arr = $this->mod_dashboard->get_order($order_id);
			$response = '<div class="boat_points_iner">
					        <div class="boat_points_close">
					            <i class="fa fa-chevron-right" aria-hidden="true"></i>
					            <i class="fa fa-chevron-left" aria-hidden="true"></i>
					        </div>
					        <div class="boat_points_header" style="background: #f11919 none repeat scroll 0 0;">Order Details</div>
					        <div class="boat_points_body">
					            <ul>
					                <li><strong>Entry Price</strong> <span class="color-blue">' . num($order_arr['purchased_price']) . '</span></li>
					                <li><strong>Exit Price</strong> <span class="color-blue">' . num($order_arr['market_value']) . '</span></li>
					                <li><strong>Quantity</strong> <span class="color-blue">' . $order_arr['quantity'] . '</span></li>
					                <li><strong>Profit Target</strong> <span class="color-blue">';
			if ($order_arr['profit_type'] == 'percentage') {
				$response .= $order_arr['sell_profit_percent'] . "%";
			} else {
				$response .= $order_arr['sell_profit_price'];
			}
			$response .= '</span></li>
					               <li><strong>Status</strong> <span class="color-blue">';
			if ($order_arr['status'] == 'sell') {
				$response .= '<span class="label label-danger">Sell</span>';
			} else {
				$response .= '<span class="label label-success">New</span>';
			}
			$response .= '</span></li>

					               <li>
					               <button type="button" class="btn btn-info pull-right" id="edit_order_btn" order_id="' . $order_arr['_id'] . '" data-type="sell">Edit</button>
					               </li>
					            </ul>
					        </div>
					    </div>';

		} else {

			$order_arr = $this->mod_dashboard->get_buy_order($order_id);
			$response = '<div class="boat_points_iner">
					        <div class="boat_points_close">
					            <i class="fa fa-chevron-right" aria-hidden="true"></i>
					            <i class="fa fa-chevron-left" aria-hidden="true"></i>
					        </div>
					        <div class="boat_points_header">Order Details</div>
					        <div class="boat_points_body">
					            <ul>
					                <li><strong>Entry Price</strong> <span class="color-blue">' . num($order_arr['price']) . '</span></li>
					                <li><strong>Quantity</strong> <span class="color-blue">' . $order_arr['quantity'] . '</span></li>
					               <li><strong>Status</strong> <span class="color-blue">';
			if ($order_arr['status'] == 'buy') {
				$response .= '<span class="label label-success">Buy</span>';
			} else {
				$response .= '<span class="label label-success">New</span>';
			}
			$response .= '</span></li>
					               <li>
					               <button type="button" class="btn btn-info pull-right" id="edit_order_btn" order_id="' . $order_arr['_id'] . '" data-type="buy">Edit</button>
					               </li>
					            </ul>
					        </div>
					    </div>';

		}

		echo $response;
		exit;

	} //end get_order_details

	public function get_edit_order_details($order_id, $type) {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		if ($type == 'sell') {

			$order_arr = $this->mod_dashboard->get_order($order_id);
			$response = '<form id="edit_order_form" method="post">
						<div class="boat_points_iner">
					        <div class="boat_points_close">
					            <i class="fa fa-chevron-right" aria-hidden="true"></i>
					            <i class="fa fa-chevron-left" aria-hidden="true"></i>
					        </div>
					        <div class="boat_points_header" style="background: #f11919 none repeat scroll 0 0;">Order Details</div>
					        <div class="boat_points_body">
					            <ul>
					                <li><strong>Entry Price</strong>
					                <span class="color-blue">
					                <input type="text" class="form-control" name="purchased_price" value="' . num($order_arr['purchased_price']) . '" >
					                </span>
					                </li>
					                <li><strong>Quantity</strong>
					                <span class="color-blue">
					                <input type="text" class="form-control" name="quantity" value="' . $order_arr['quantity'] . '" >
					                </span>
					                </li>
					                <li><strong>Profit Type</strong>
					                <span class="color-blue">
					                <select class="form-control" name="profit_type" id="profit_type">
				                      <option value="percentage"';if ($order_arr['profit_type'] == 'percentage') {$response .= 'selected';}$response .= '>Percentage</option>
				                      <option value="fixed_price"';if ($order_arr['profit_type'] == 'fixed_price') {$response .= 'selected';}$response .= '>Fixed Price</option>
				                    </select>
				                    </span>
				                    </li>';
			if ($order_arr['profit_type'] == 'percentage') {
				$style1 = 'style="display:block;"';
				$style2 = 'style="display:none;"';
			} else {
				$style1 = 'style="display:none;"';
				$style2 = 'style="display:block;"';
			}

			$response .= '<li id="sell_profit_percent_div" ' . $style1 . '><strong>Sell Profit (%)</strong>
					               	<span class="color-blue">
					               	<input type="text" name="sell_profit_percent" value="' . $order_arr['sell_profit_percent'] . '" class="form-control">
					               	</span>
					               	</li>

					               <li id="sell_profit_price_div" ' . $style2 . '><strong>Sell Price</strong>
					               <span class="color-blue">
					               <input type="text" name="sell_profit_price" value="' . num($order_arr['sell_profit_price']) . '" class="form-control">
					               </span>
					               </li>

					               <li>
					               <input type="hidden" name="id" value="' . $order_arr['_id'] . '">
					               <button type="button" class="btn btn-info pull-right" id="update_order_btn" data-type="sell">Update</button>
					               </li>
					            </ul>
					        </div>
					    </div>
					    </form>';

		} else {

			$order_arr = $this->mod_dashboard->get_buy_order($order_id);
			$response = '<form id="edit_order_form" method="post">
						<div class="boat_points_iner">
					        <div class="boat_points_close">
					            <i class="fa fa-chevron-right" aria-hidden="true"></i>
					            <i class="fa fa-chevron-left" aria-hidden="true"></i>
					        </div>
					        <div class="boat_points_header">Order Details</div>
					        <div class="boat_points_body">
					            <ul>
					                <li>
					                <strong>Entry Price</strong>
					                <span class="color-blue">
					                <input type="text" class="form-control" name="price" value="' . num($order_arr['price']) . '" >
					                </span>
					                </li>
					                <li>
					                <strong>Quantity</strong>
					                <span class="color-blue">
					                <input type="text" class="form-control" name="quantity" value="' . $order_arr['quantity'] . '" >
					                </span>
					                </li>
					                <li>
					               <input type="hidden" name="id" value="' . $order_arr['_id'] . '">
					               <button type="button" class="btn btn-info pull-right" id="update_order_btn" data-type="buy">Update</button>
					               </li>
					            </ul>
					        </div>
					    </div>
					    </form>';

		}

		echo $response;
		exit;

	} //end get_edit_order_details

	public function add_order_btn() {
		$price = $this->input->post('price');
		$response = '<form id="add_order_form" method="post">
						<div class="boat_points_iner">
					        <div class="boat_points_close">
					            <i class="fa fa-chevron-right" aria-hidden="true"></i>
					            <i class="fa fa-chevron-left" aria-hidden="true"></i>
					        </div>
					        <div class="boat_points_header">Order Details</div>
					        <div class="boat_points_body">
					            <ul>
					            	<li>
					                <strong>Coin</strong>
					                <span class="color-blue">
					                <input type="text" class="form-control" name="coin" value="' . $this->session->userdata('global_symbol') . '" >
					                </span>
					                </li>
					                <li>
					                <strong>Entry Price</strong>
					                <span class="color-blue">
					                <input type="text" class="form-control" name="price" value="' . $price . '" >
					                </span>
					                </li>
					                <li>
					                <strong>Quantity</strong>
					                <span class="color-blue">
					                <input type="text" class="form-control" name="quantity">
					                </span>
					                </li>
					                <li>
					                <strong>Order Type</strong>
					                <span class="color-blue">
					                <select name="order_type" class="form-control valid" aria-invalid="false">
			                          <option value="market_order">Market Order</option>
			                          <option value="limit_order">Limit Order</option>
			                        </select>
					                </span>
					                </li>
					                <li>
					               <button type="button" class="btn btn-info pull-right" id="add_order_btn" data-type="buy">Add Order</button>
					               </li>
					            </ul>
					        </div>
					    </div>
					    </form>';

		echo $response;
		exit;
	}

	public function get_contract_info($symbol) {
		$info = $this->mod_coins->get_coin_contract_value($symbol);

		$contract_per = $info['contract_percentage'];
		$contract_time = $info['contract_time'];

		if ($contract_time == 0) {
			$contract_time = 2;
		}

		if ($contract_per == 0) {
			$contract_per = 10;
		}

		$curr_time = date("Y-m-d H:i:s");
		$nowtime = date('Y-m-d H:i:s', strtotime('-' . $contract_time . 'minutes'));

		$search_array['coin'] = $symbol;
		$search_array['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($nowtime));

		$this->mongo_db->where($search_array);
		$this->mongo_db->order_by(array('created_date' => -1));
		$get_arr = $this->mongo_db->get('market_trades');
		$quantity = array();
		foreach ($get_arr as $key => $value) {
			if (!empty($value)) {
				$quantity[] = $value['quantity'];
			}
		}
		rsort($quantity);

		$q_sum = 0;
		$index = round((count($quantity) / 100) * $contract_per);
		for ($i = 0; $i < $index; $i++) {
			$q_sum += $quantity[$i];
		}

		for ($i = 0; $i < count($quantity); $i++) {
			$t_sum += $quantity[$i];
		}

		$q_avg = $q_sum / $index;

		$cal_per = ($q_sum / $t_sum) * 100;
		$ret_arr['avg'] = round($q_avg);
		$ret_arr['per'] = round($cal_per);
		return $ret_arr;
	}
	public function get_bid_contract_info($symbol) {
		$info = $this->mod_coins->get_coin_contract_value($symbol);

		$contract_per = $info['contract_percentage'];
		$contract_time = $info['contract_time'];

		if ($contract_time == 0) {
			$contract_time = 2;
		}

		if ($contract_per == 0) {
			$contract_per = 10;
		}

		$curr_time = date("Y-m-d H:i:s");
		$nowtime = date('Y-m-d H:i:s', strtotime('-' . $contract_time . 'minutes'));

		$search_array['coin'] = $symbol;
		/*$search_array['maker'] = 'true';*/
		$search_array['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($nowtime));

		$this->mongo_db->where($search_array);
		$this->mongo_db->order_by(array('created_date' => -1));
		$get_arr = $this->mongo_db->get('market_trades');
		$get_arr_1 = iterator_to_array($get_arr);
		array_multisort(array_column($get_arr_1, "quantity"), SORT_DESC, $get_arr_1);
		$index = round((count($get_arr_1) / 100) * $contract_per);
		for ($i = 0; $i < $index; $i++) {
			if ($get_arr_1[$i]['maker'] == 'true') {
				$q_sum += $get_arr_1[$i]['quantity'];
			}

		}

		$q2 = 0;
		$max_price = 0;
		for ($i = 0; $i < $index; $i++) {
			if ($get_arr_1[$i]['maker'] == 'true') {

				$q = $get_arr_1[$i]['quantity'];
				if ($q2 < $q) {
					$q2 = $q;
					$max_price = $get_arr_1[$i]['price'];
				}
			}

		}
		for ($i = 0; $i < count($get_arr_1); $i++) {
			$t_sum += $get_arr_1[$i]['quantity'];
		}

		$q_avg = $q_sum / $index;

		$cal_per = ($q_sum / $t_sum) * 100;
		$ret_arr['avg'] = round($q_avg);
		$ret_arr['per'] = round($cal_per);
		$ret_arr['max'] = num($max_price);
		return $ret_arr;
	}
	public function get_ask_contract_info($symbol) {
		$info = $this->mod_coins->get_coin_contract_value($symbol);

		$contract_per = $info['contract_percentage'];
		$contract_time = $info['contract_time'];

		if ($contract_time == 0) {
			$contract_time = 2;
		}

		if ($contract_per == 0) {
			$contract_per = 10;
		}

		$curr_time = date("Y-m-d H:i:s");
		$nowtime = date('Y-m-d H:i:s', strtotime('-' . $contract_time . 'minutes'));

		$search_array['coin'] = $symbol;

		$search_array['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($nowtime));

		$this->mongo_db->where($search_array);
		$this->mongo_db->order_by(array('created_date' => -1));
		$get_arr = $this->mongo_db->get('market_trades');
		$get_arr_1 = iterator_to_array($get_arr);
		array_multisort(array_column($get_arr_1, "quantity"), SORT_DESC, $get_arr_1);

		$index = round((count($get_arr_1) / 100) * $contract_per);
		$index = round((count($get_arr_1) / 100) * $contract_per);
		for ($i = 0; $i < $index; $i++) {
			if ($get_arr_1[$i]['maker'] == 'false') {
				$q_sum += $get_arr_1[$i]['quantity'];
			}

		}

		$q2 = 0;
		$max_price = 0;
		for ($i = 0; $i < $index; $i++) {
			if ($get_arr_1[$i]['maker'] == 'false') {

				$q = $get_arr_1[$i]['quantity'];
				if ($q2 < $q) {
					$q2 = $q;
					$max_price = $get_arr_1[$i]['price'];
				}
			}

		}

		for ($i = 0; $i < count($get_arr_1); $i++) {
			$t_sum += $get_arr_1[$i]['quantity'];
		}

		$q_avg = $q_sum / $index;

		$cal_per = ($q_sum / $t_sum) * 100;
		$ret_arr['avg'] = round($q_avg);
		$ret_arr['per'] = round($cal_per);
		$ret_arr['max'] = num($max_price);
		return $ret_arr;
	}

	public function calculate_wall($coin_symbol, $depth_arr, $type, $biggest_value) {
		if ($type == 'sell') {
			array_multisort(array_column($depth_arr, "price"), SORT_ASC, $depth_arr);
		} elseif ($type == 'buy') {
			array_multisort(array_column($depth_arr, "price"), SORT_DESC, $depth_arr);
		}

		$setting = $this->mod_coins->get_coin_depth_wall_setting($coin_symbol);
		$temp_price = 0.00;
		///////////////////////////////////////////////////////////////////////////////////
		if ($setting == 'percentage') {
			$depth_wall_val = $this->mod_coins->get_coin_depth_wall_percentage($coin_symbol);
			if (count($depth_arr) > 0) {
				$buy_depth_wall2 = 0;
				$temp_price = 0;
				$temps = count($depth_arr);
				for ($temp = $temps - 1; $temp >= 0; $temp--) {

					if ($depth_arr[$temp]['type'] == 'bid') {
						$sell_percentage22 = round($depth_arr[$temp]['depth_sell_quantity'] * 100 / $biggest_value);
						if ($sell_percentage22 > $depth_wall_val && $buy_depth_wall2 == 0) {
							$temp_price = num($depth_arr[$temp]['price']);
							$buy_depth_wall2 = 1;
							break;
						}
					} elseif ($depth_arr[$temp]['type'] == 'ask') {
						$buy_percentage22 = round($depth_arr[$temp]['depth_buy_quantity'] * 100 / $biggest_value);
						if ($buy_percentage22 >= $depth_wall_val && $buy_depth_wall2 == 0) {
							$temp_price = num($depth_arr[$temp]['price']);
							$buy_depth_wall2 = 1;
							break;
						}
					}
				}
			}

		} elseif ($setting == 'amount') {
			$depth_wall_val = $this->mod_coins->get_coin_depth_wall_value($coin_symbol);
			if (count($depth_arr) > 0) {
				$quantity_t = 0;
				$buy_depth_wall2 = 0;
				$temp_price = 0;
				$temps = count($depth_arr);
				for ($temp = $temps - 1; $temp >= 0; $temp--) {
					if ($depth_arr[$temp]['type'] == 'bid') {
						$quantity_t += $depth_arr[$temp]['depth_sell_quantity'];
						if ($quantity_t >= $depth_wall_val && $buy_depth_wall2 == 0) {
							$temp_price = num($depth_arr[$temp]['price']);
							$buy_depth_wall2 = 1;
						}
					} elseif ($depth_arr[$temp]['type'] == 'ask') {
						$quantity_t += $depth_arr[$temp]['depth_buy_quantity'];
						if ($quantity_t >= $depth_wall_val && $buy_depth_wall2 == 0) {

							$temp_price = num($depth_arr[$temp]['price']);
							$buy_depth_wall2 = 1;
						}
					}
				}
			}

		}

		return $temp_price;
		///////////////////////////////////////////////////////////////////////////////////

	}

	public function calculate_yellow_wall($coin_symbol, $depth_arr, $type, $biggest_value) {
		if ($type == 'sell') {
			array_multisort(array_column($depth_arr, "price"), SORT_ASC, $depth_arr);
		} elseif ($type == 'buy') {
			array_multisort(array_column($depth_arr, "price"), SORT_DESC, $depth_arr);
		}

		$setting = $this->mod_coins->get_coin_yellow_wall_setting($coin_symbol);
		$temp_price = 0.00;
		///////////////////////////////////////////////////////////////////////////////////
		if ($setting == 'percentage') {
			$depth_wall_val = $this->mod_coins->get_coin_yellow_wall_percentage($coin_symbol);
			if (count($depth_arr) > 0) {
				$buy_depth_wall2 = 0;
				$temp_price = 0;
				$temps = count($depth_arr);
				for ($temp = $temps - 1; $temp >= 0; $temp--) {

					if ($depth_arr[$temp]['type'] == 'bid') {
						$sell_percentage22 = round($depth_arr[$temp]['depth_sell_quantity'] * 100 / $biggest_value);
						if ($sell_percentage22 > $depth_wall_val && $buy_depth_wall2 == 0) {
							$temp_price = num($depth_arr[$temp]['price']);
							$buy_depth_wall2 = 1;
							break;
						}
					} elseif ($depth_arr[$temp]['type'] == 'ask') {
						$buy_percentage22 = round($depth_arr[$temp]['depth_buy_quantity'] * 100 / $biggest_value);
						if ($buy_percentage22 >= $depth_wall_val && $buy_depth_wall2 == 0) {
							$temp_price = num($depth_arr[$temp]['price']);
							$buy_depth_wall2 = 1;
							break;
						}
					}
				}
			}

		} elseif ($setting == 'amount') {
			$depth_wall_val = $this->mod_coins->get_coin_yellow_wall_value($coin_symbol);
			if (count($depth_arr) > 0) {
				$quantity_t = 0;
				$buy_depth_wall2 = 0;
				$temp_price = 0;
				$temps = count($depth_arr);
				for ($temp = $temps - 1; $temp >= 0; $temp--) {
					if ($depth_arr[$temp]['type'] == 'bid') {
						$quantity_t += $depth_arr[$temp]['depth_sell_quantity'];
						if ($quantity_t >= $depth_wall_val && $buy_depth_wall2 == 0) {
							$temp_price = num($depth_arr[$temp]['price']);
							$buy_depth_wall2 = 1;
						}
					} elseif ($depth_arr[$temp]['type'] == 'ask') {
						$quantity_t += $depth_arr[$temp]['depth_buy_quantity'];
						if ($quantity_t >= $depth_wall_val && $buy_depth_wall2 == 0) {

							$temp_price = num($depth_arr[$temp]['price']);
							$buy_depth_wall2 = 1;
						}
					}
				}
			}

		}

		return $temp_price;
		///////////////////////////////////////////////////////////////////////////////////

	}

	public function calculate_big_wall($sell_arr, $buy_arr, $biggest_value) {
		$pressure_up = 0;
		$pressure_down = 0;

		array_multisort(array_column($buy_arr, "price"), SORT_ASC, $buy_arr);
		array_multisort(array_column($sell_arr, "price"), SORT_DESC, $sell_arr);

		$bid_max = $sell_arr[0]['depth_sell_quantity'];
		$ask_max = $buy_arr[0]['depth_buy_quantity'];
		for ($i = 0; $i < 5; $i++) {
			if ($bid_max < $sell_arr[$i]['depth_sell_quantity']) {
				$bid_max = $sell_arr[$i]['depth_sell_quantity'];
				$big_bid = $sell_arr[$i];
			}

			if ($ask_max < $buy_arr[$i]['depth_buy_quantity']) {
				$ask_max = $buy_arr[$i]['depth_buy_quantity'];
				$big_ask = $buy_arr[$i];
			}
		}

		if ($bid_max > $ask_max) {
			$pressure = 'down';
			$max_per = ($bid_max / $biggest_value) * 100;
			$max = $bid_max;
		} elseif ($ask_max > $bid_max) {
			$pressure = 'up';
			$max_per = ($ask_max / $biggest_value) * 100;
			$max = $ask_max;
		}
		return array('pressure' => $pressure, 'max_per' => $max_per, 'max' => $max);
	}

	public function calculate_bid_ask_levels($sell_arr, $buy_arr) {
		$pressure_up = 0;
		$pressure_down = 0;

		array_multisort(array_column($buy_arr, "price"), SORT_ASC, $buy_arr);
		array_multisort(array_column($sell_arr, "price"), SORT_DESC, $sell_arr);

		$bid_max = 0;
		$ask_max = 0;
		for ($i = 0; $i < 7; $i++) {

			$bid_max += $sell_arr[$i]['depth_sell_quantity'];
			$ask_max += $buy_arr[$i]['depth_buy_quantity'];
		}

		if ($bid_max > $ask_max) {
			$x = $bid_max / $ask_max;
			$p = 'up';
		} elseif ($ask_max > $bid_max) {
			$x = $ask_max / $bid_max;
			$p = 'down';
		}

		$new_x = $x - 1;
		$new_p = ($new_x / 3) * 100;
		return array('new_x' => number_format($new_x, 2), 'new_p' => $new_p, 'p' => $p);
	}

	public function calculate_pressure($market_sell_depth_arr, $market_buy_depth_arr) {
		$pressure_up = 0;
		$pressure_down = 0;

		array_multisort(array_column($market_buy_depth_arr, "price"), SORT_ASC, $market_buy_depth_arr);
		array_multisort(array_column($market_sell_depth_arr, "price"), SORT_DESC, $market_sell_depth_arr);
		for ($i = 0; $i < 5; $i++) {
			//echo num($market_sell_depth_arr[$i]['price']) . ' ===> ' . num($market_buy_depth_arr[$i]['price']) . "<br>";
			$ret_Arr = array();
			if ($market_sell_depth_arr[$i]['depth_sell_quantity'] > $market_buy_depth_arr[$i]['depth_buy_quantity']) {
				$pressure_up++;
				//$pressure_amount = ($market_sell_depth_arr[$i]['quantity'] / $market_buy_depth_arr[$i]['quantity']);
			} elseif ($market_sell_depth_arr[$i]['depth_sell_quantity'] < $market_buy_depth_arr[$i]['depth_buy_quantity']) {
				$pressure_down++;
				/*echo $market_sell_depth_arr[$i]['price'] . " => " . $market_sell_depth_arr[$i]['quantity'];
					echo "<<==>>";
					echo $market_buy_depth_arr[$i]['price'] . " => " . $market_buy_depth_arr[$i]['quantity'];
					echo "DOWN";
				*/
				//$pressure_amount = ($market_buy_depth_arr[$i]['quantity'] / $market_sell_depth_arr[$i]['quantity']);
			}
		}
		return array("up" => $pressure_up, 'down' => $pressure_down);
	}

	public function get_barrier_value($market_value, $symbol, $type) {
		if ($type == 'up') {
			$search_arr['barier_value'] = array('$gte' => (float) $market_value);
		}
		if ($type == 'down') {
			$search_arr['barier_value'] = array('$lte' => (float) $market_value);
		}
		$search_arr['coin'] = $symbol;
		$search_arr['barrier_type'] = $type;
		$search_arr['barrier_status'] = 'very_strong_barrier';
		$this->mongo_db->where($search_arr);
		$this->mongo_db->order_by(array('created_date' => -1));
		$this->mongo_db->limit(1);
		$depth_responseArr = $this->mongo_db->get('barrier_values_collection');

		$arr = iterator_to_array($depth_responseArr);
		$barrier = num($arr[0]['barier_value']);

		return $barrier;
	}

	public function testing_contracts($symbol) {
		$info = $this->mod_coins->get_coin_contract_value($symbol);

		echo $contract_per = $info['contract_percentage'];
		echo "<br>";
		echo $contract_time = $info['contract_time'];
		echo "<br>";
		if ($contract_time == 0) {
			$contract_time = 2;
		}

		if ($contract_per == 0) {
			$contract_per = 10;
		}

		echo $curr_time = date("Y-m-d H:i:s");
		echo "<br>";
		echo $nowtime = date('Y-m-d H:i:s', strtotime('-' . $contract_time . 'minutes'));
		echo "<br>";

		$search_array['coin'] = $symbol;
		/*$search_array['maker'] = 'true';*/
		//$search_array['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($nowtime));

		$this->mongo_db->where($search_array);
		$this->mongo_db->order_by(array('created_date' => -1));
		$get_arr = $this->mongo_db->get('market_trades');
		$get_arr_1 = iterator_to_array($get_arr);
		array_multisort(array_column($get_arr_1, "quantity"), SORT_DESC, $get_arr_1);
		echo "<pre>";
		print_r($get_arr_1);
		$index = round((count($get_arr_1) / 100) * $contract_per);
		for ($i = 0; $i < $index; $i++) {
			if ($get_arr_1[$i]['maker'] == 'true') {
				$q_sum += $get_arr_1[$i]['quantity'];
			}
		}

		$q2 = 0;
		$max_price = 0;
		for ($i = 0; $i < $index; $i++) {
			if ($get_arr_1[$i]['maker'] == 'true') {

				$q = $get_arr_1[$i]['quantity'];
				if ($q2 < $q) {
					$q2 = $q;
					$max_price = $get_arr_1[$i]['price'];
				}
			}

		}
		for ($i = 0; $i < count($get_arr_1); $i++) {
			$t_sum += $get_arr_1[$i]['quantity'];
		}

		$q_avg = $q_sum / $index;

		$cal_per = ($q_sum / $t_sum) * 100;
		$ret_arr['avg'] = round($q_avg);
		$ret_arr['per'] = round($cal_per);
		$ret_arr['max'] = num($max_price);

		echo "<pre>";
		print_r($ret_arr);
		exit;
	}

	public function calculate_score($score_array) {

		/*
				Array
				(
				    [depth_pressure] => 1+
				    [depth_pressure_side] => up
				    [black_pressure] => 0+
				    [black_color_side] => up
				    [yellow_pressure] => 2+
				    [yellow_color_side] => down
				    [seven_level] => 0.41+
				    [seven_level_side] => up
				    [big_pressure] => down+
				    [buyers] => 44.236008501516+
				    [sellers] => 55.763991498484+
				    [big_sellers] => 32+
				    [big_buyers] => 21+
				    [barrier_diff] => 0
				    [barrier_side] => up+
				    [swing_status] => HH+
				    [taf] => 97
				    [tbf] => 92
				    't_h_b' => $contract_two['bids'],
					't_h_a' => $contract_two['asks'],
				)

		*/

		$depth_pressure = $score_array['depth_pressure'];
		$depth_pressure_side = $score_array['depth_pressure_side'];

		$black_pressure = $score_array['black_pressure'];
		$black_color_side = $score_array['black_color_side'];

		$yellow_pressure = $score_array['yellow_pressure'];
		$yellow_color_side = $score_array['yellow_color_side'];

		$seven_level = $score_array['seven_level'];
		$seven_level_side = $score_array['seven_level_side'];

		$big_pressure = $score_array['big_pressure'];

		$buyers = $score_array['buyers'];
		$sellers = $score_array['sellers'];

		$big_buyers = $score_array['big_buyers'];
		$big_sellers = $score_array['big_sellers'];

		$barrier = $score_array['barrier_diff'];
		$barrier_side = $score_array['barrier_side'];
		$swing_status = $score_array['swing_status'];

		$taf = $score_array['taf'];
		$tbf = $score_array['tbf'];

		$t_h_b = $score_array['t_h_b'];
		$t_h_a = $score_array['t_h_a'];

		$total_array = array();

		/////////////////////////////taf//////////////////////////////////
		if ($taf >= 70) {
			$score_taf = 2;
			array_push($total_array, $score_taf);
		} else {
			$score_taf = 0;
			array_push($total_array, $score_taf);
		}
		///////////////////////////end taf//////////////////////////////////////

		/////////////////////////////tbf//////////////////////////////////
		if ($tbf >= 70) {
			$score_tbf = -2;
			array_push($total_array, $score_tbf);
		} else {
			$score_tbf = 0;
			array_push($total_array, $score_tbf);
		}
		///////////////////////////end tbf//////////////////////////////////////

		////////////////////////// DEPTH SCORE //////////////////////////////////
		if ($depth_pressure_side == 'down') {
			$score_depth = $depth_pressure * -1;
			array_push($total_array, $score_depth);
		} elseif ($depth_pressure_side == 'up') {
			$score_depth = $depth_pressure * 1;
			array_push($total_array, $score_depth);
		}
		///////////////////End Depth Score /////////////////////////////////////

		////////////////////////// SWING SCORE //////////////////////////////////
		if ($swing_status == 'LL') {
			$score_swing_status = -2;
			array_push($total_array, $score_swing_status);
		} elseif ($swing_status == 'LH') {
			$score_swing_status = -1;
			array_push($total_array, $score_swing_status);
		} elseif ($swing_status == 'HL') {
			$score_swing_status = 1;
			array_push($total_array, $score_swing_status);
		} elseif ($swing_status == 'HH') {
			$score_swing_status = 2;
			array_push($total_array, $score_swing_status);
		}
		///////////////////End SWING Score /////////////////////////////////////

		////////////////////////// Barrier SCORE //////////////////////////////////
		if ($barrier_side == 'down') {
			$score_barrier = 2;
			array_push($total_array, $score_barrier);
		} elseif ($barrier_side == 'up') {
			$score_barrier = -2;
			array_push($total_array, $score_barrier);
		}
		///////////////////End Barrier Score /////////////////////////////////////

		////////////////////////// Black Score //////////////////////////////////
		if ($black_pressure >= 5) {
			$score_black = 5;
		} else {
			$score_black = $black_pressure;
		}

		if ($black_color_side == 'down') {
			$score_black = $score_black * -1;
			array_push($total_array, $score_black);
		} elseif ($black_color_side == 'up') {
			$score_black = $score_black * 1;
			array_push($total_array, $score_black);
		}
		///////////////////End Black Score /////////////////////////////////////

		////////////////////////// Yellow Score //////////////////////////////////
		if ($yellow_pressure >= 4) {
			$score_yellow = 4;
		} else {
			$score_yellow = $yellow_pressure;
		}

		if ($yellow_color_side == 'down') {
			$score_yellow = $score_yellow * -1;
			array_push($total_array, $score_yellow);
		} elseif ($yellow_color_side == 'up') {
			$score_yellow = $score_yellow * 1;
			array_push($total_array, $score_yellow);
		}
		///////////////////End Yellow Score /////////////////////////////////////

		////////////////////////// Seven Level Score //////////////////////////////////
		if ($seven_level <= 0.5) {
			$score_seven = 1;
		} elseif ($seven_level <= 1) {
			$score_seven = 2;
		} elseif ($seven_level <= 2) {
			$score_seven = 3;
		} elseif ($seven_level <= 3) {
			$score_seven = 4;
		} else {
			$score_seven = 5;
		}

		if ($seven_level_side == 'up') {
			$score_seven = $score_seven * -1;
			array_push($total_array, $score_seven);
		} elseif ($seven_level_side == 'down') {
			$score_seven = $score_seven * 1;
			array_push($total_array, $score_seven);
		}
		///////////////////End Seven Level Score /////////////////////////////////////

		////////////////////////// Buyers Level Score //////////////////////////////////
		if ($buyers <= 25) {
			$score_buyers = 1;
			array_push($total_array, $score_buyers);
		} elseif ($buyers <= 40) {
			$score_buyers = 2;
			array_push($total_array, $score_buyers);
		} elseif ($buyers <= 60) {
			$score_buyers = 3;
			array_push($total_array, $score_buyers);
		} elseif ($buyers <= 80) {
			$score_buyers = 4;
			array_push($total_array, $score_buyers);
		} elseif ($buyers <= 100) {
			$score_buyers = 5;
			array_push($total_array, $score_buyers);
		}
		///////////////////End Buyers Level Score /////////////////////////////////////

		////////////////////////// sellers Level Score //////////////////////////////////
		if ($sellers <= 25) {
			$score_sellers = -1;
			array_push($total_array, $score_sellers);
		} elseif ($sellers <= 40) {
			$score_sellers = -2;
			array_push($total_array, $score_sellers);
		} elseif ($sellers <= 60) {
			$score_sellers = -3;
			array_push($total_array, $score_sellers);
		} elseif ($sellers <= 80) {
			$score_sellers = -4;
			array_push($total_array, $score_sellers);
		} elseif ($sellers <= 100) {
			$score_sellers = -5;
			array_push($total_array, $score_sellers);
		}
		///////////////////End sellers Level Score /////////////////////////////////////

		////////////////////////// 200 asks Level Score //////////////////////////////////
		if ($t_h_a >= 25 && $t_h_a <= 50) {
			$score_t_h_a = 1;
			array_push($total_array, $score_t_h_a);
		} elseif ($t_h_a >= 50 && $t_h_a <= 75) {
			$score_t_h_a = 2;
			array_push($total_array, $score_t_h_a);
		} elseif ($t_h_a >= 75) {
			$score_t_h_a = 3;
			array_push($total_array, $score_t_h_a);
		}
		///////////////////End 200 asks Level Score /////////////////////////////////////

		////////////////////////// 200 bids Level Score //////////////////////////////////
		if ($t_h_b >= 25 && $t_h_b <= 50) {
			$score_t_h_b = -1;
			array_push($total_array, $score_t_h_b);
		} elseif ($t_h_b >= 50 && $t_h_b <= 75) {
			$score_t_h_a = -2;
			array_push($total_array, $score_t_h_b);
		} elseif ($t_h_b >= 75) {
			$score_t_h_b = -3;
			array_push($total_array, $score_t_h_b);
		}
		///////////////////End 200 bids Level Score /////////////////////////////////////

		////////////////////////// Big Buyers Level Score //////////////////////////////////
		if ($big_buyers >= 10) {
			$score_big_buyers = 1;
			array_push($total_array, $score_big_buyers);
		} elseif ($big_buyers >= 20) {
			$score_big_buyers = 2;
			array_push($total_array, $score_big_buyers);
		} elseif ($big_buyers >= 40) {
			$score_big_buyers = 3;
			array_push($total_array, $score_big_buyers);
		} elseif ($big_buyers >= 60) {
			$score_big_buyers = 4;
			array_push($total_array, $score_big_buyers);
		} elseif ($big_buyers >= 80) {
			$score_big_buyers = 5;
			array_push($total_array, $score_big_buyers);
		} elseif ($big_buyers >= 90) {
			$score_big_buyers = 6;
			array_push($total_array, $score_big_buyers);
		}

		///////////////////End Big Buyers Level Score /////////////////////////////////////

		////////////////////////// Big Sellers Level Score //////////////////////////////////
		if ($big_sellers >= 10) {
			$score_big_sellers = -1;
			array_push($total_array, $score_big_sellers);
		} elseif ($big_sellers >= 20) {
			$score_big_sellers = -2;
			array_push($total_array, $score_big_sellers);
		} elseif ($big_sellers >= 40) {
			$score_big_sellers = -3;
			array_push($total_array, $score_big_sellers);
		} elseif ($big_sellers >= 60) {
			$score_big_sellers = -4;
			array_push($total_array, $score_big_sellers);
		} elseif ($big_sellers >= 80) {
			$score_big_sellers = -5;
			array_push($total_array, $score_big_sellers);
		} elseif ($big_sellers >= 90) {
			$score_big_sellers = -6;
			array_push($total_array, $score_big_sellers);
		}

		///////////////////End Big Sellers Level Score /////////////////////////////////////
		/////////////////////////Big Pressure ///////////////////////////////////////

		if ($big_pressure == 'down') {
			$score_big = 2;
			array_push($total_array, $score_big);
		} elseif ($big_pressure == 'up') {
			$score_big = -2;
			array_push($total_array, $score_big);
		}
		///////////////////////////////////End Big Prssure ////////////////////////

		//$total_score_prev = $score_depth + $score_black + $score_yellow + $score_seven + $score_buyers + $score_big + $score_barrier;
		$total_score = array_sum($total_array);

		$total_score = $total_score + 50;

		if ($total_score <= 40) {
			$color = '#F11919';
		} elseif ($total_score <= 50) {
			$color = '#FF7F50';
		} elseif ($total_score <= 60) {
			$color = '#4484FF';
		} elseif ($total_score > 60) {
			$color = '#5CBC32';
		}

		$total_score = ($total_score - 30) * 2.5;
		$response78 = $this->generate_meter_score(100, $total_score);
		$response7 = '
				<div class="bottom_prog_left">
			      	<div class="bottom_prog_one">
			      		<div class="bottom_prog_title">
			              <h2>Total Score</h2>
			            </div>' . $response78 . '</div>';

		return $response7;
	}

	public function get_contracts_one($symbol) {
		$contract_size = $this->mod_coins->get_coin_contract_size($symbol);

		$nowtime = date("Y-m-d H:i:s");
		//$nowtime = date('Y-m-d H:i:s', strtotime('-' . $contract_time . 'minutes'));

		$search_array['coin'] = $symbol;
		$search_array['created_date'] = array('$lte' => $this->mongo_db->converToMongodttime($nowtime));

		$this->mongo_db->where($search_array);
		$this->mongo_db->order_by(array('created_date' => -1));
		$get_arr = $this->mongo_db->get('market_trades');


		$bids = 0;
		$asks = 0;
		$last_time = null;
		$bid_quantity = 0;
		$ask_quantity = 0;
		$total_quantity = 0;

		foreach ($get_arr as $key => $value) {
			if (!empty($value)) {
				if ($value['maker'] == 'true') {
					$bid_quantity += $value['quantity'];
					$bids++;
				} elseif ($value['maker'] == 'false') {
					$ask_quantity += $value['quantity'];
					$asks++;
				}
				$total_quantity = $bid_quantity + $ask_quantity;
				if ($total_quantity >= $contract_size) {
					$last_time = $value['created_date'];
					break;
				}
			}
		}
		$new_time = $last_time->toDateTime();
		$new_time = $new_time->format("Y-m-d H:i:s");
		$time = $this->time_elapsed_string($new_time);

		$bid_per = ($bid_quantity / $total_quantity) * 100;
		$ask_per = ($ask_quantity / $total_quantity) * 100;

		$array = array(
			"bid_quantity" => number_format_short($bid_quantity),
			"ask_quantity" => number_format_short($ask_quantity),
			"bids" => round($bid_per),
			"asks" => round($ask_per),
			"time_string" => $time,
		);

		return $array;

	}

	public function get_contracts_two($symbol) {
		/*$info = $this->mod_coins->get_coin_contract_value($symbol);

			$contract_per = $info['contract_percentage'];
			$contract_time = $info['contract_time'];

			if ($contract_time == 0) {
				$contract_time = 2;
			}

			if ($contract_per == 0) {
				$contract_per = 10;
			}
		*/

		$nowtime = date("Y-m-d H:i:s");
		//$nowtime = date('Y-m-d H:i:s', strtotime('-' . $contract_time . 'minutes'));

		$search_array['coin'] = $symbol;
		$search_array['created_date'] = array('$lte' => $this->mongo_db->converToMongodttime($nowtime));

		$this->mongo_db->where($search_array);
		$this->mongo_db->limit(200);
		$this->mongo_db->order_by(array('created_date' => -1));
		$get_arr = $this->mongo_db->get('market_trades');
		$bids = 0;
		$asks = 0;
		$last_time = null;
		$bid_quantity = 0;
		$ask_quantity = 0;
		$total_quantity = 0;
		foreach ($get_arr as $key => $value) {
			if (!empty($value)) {
				if ($value['maker'] == 'true') {
					$bid_quantity += $value['quantity'];
					$bids++;
				} elseif ($value['maker'] == 'false') {
					$ask_quantity += $value['quantity'];
					$asks++;
				}
				$last_time = $value['created_date'];
			}
		}
		$total_quantity = $bid_quantity + $ask_quantity;
		$new_time = $last_time->toDateTime();
		$new_time = $new_time->format("Y-m-d H:i:s");
		$time = $this->time_elapsed_string($new_time);
		$bid_per = ($bid_quantity / $total_quantity) * 100;
		$ask_per = ($ask_quantity / $total_quantity) * 100;

		$array = array(
			"bid_quantity" => number_format_short($bid_quantity),
			"ask_quantity" => number_format_short($ask_quantity),
			"bids" => round($bid_per),
			"asks" => round($ask_per),
			"time_string" => $time,
		);

		return $array;

	}

	function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
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

		return " " . $Tmins . " min ago";

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

		/*return*/echo $string ? implode(', ', $string) . '' : 'just now';

	}

	public function generate_meter($node = '', $point = '') {

		$number = $node / 2;
		$pos_arr = array();
		$neg_arr = array();
		for ($i = 1; $i <= $number; $i++) {
			//pos_arr . push(i);
			array_push($pos_arr, $i);
			array_push($neg_arr, $i * -1);
		}
		array_push($neg_arr, 0);
		sort($neg_arr);
		$newArray = array_merge($neg_arr, $pos_arr);
		//$newArray = $.merge( $.merge( [], neg_arr ), pos_arr );
		//console.log(newArray);
		$num = 100 / $node;
		$resp = '';
		$resp .= '<div class="prog_gre">
    	<div class="prog_gre_iner" id="linear">';
		for ($i = 0; $i < count($newArray); $i++) {
			$per = ($i * $num);
			$resp .= '<div class="progx_line" style="left: ' . $per . '%;"><span>' . $newArray[$i] . '</span></div>';

			if ($point == $newArray[$i]) {
				$point_per = $per;
			}

		}
		$resp .= '</div>
        <div id="point_val" class="prog_gre_val" style="left: ' . $point_per . '%;"></div>
	</div>';
		return $resp;
		//$('#point_val').css('left',point_per+'%')

		//$('#linear').html(resp);
	}

	public function generate_meter_score($node = '', $point = '') {

		$number = $node / 10;
		$pos_arr = array();
		//$neg_arr = array();
		for ($i = 0; $i <= $number; $i++) {
			//pos_arr . push(i);
			array_push($pos_arr, $i * 10);
			//array_push($neg_arr, $i * -1);
		}
		//array_push($neg_arr, 0);
		//sort($neg_arr);
		$newArray = $pos_arr; //array_merge($neg_arr, $pos_arr);
		//$newArray = $.merge( $.merge( [], neg_arr ), pos_arr );
		//console.log(newArray);
		$num = 100 / $node;
		$resp = '';
		$resp .= '<div class="prog_gre">
    	<div class="prog_gre_iner" id="linear">';
		for ($i = 0; $i < count($newArray); $i++) {
			$per = ($i * 10 * $num);
			$resp .= '<div class="progx_line" style="left: ' . $per . '%;"><span>' . $newArray[$i] . '</span></div>';

			if ($point >= $newArray[$i] && $point <= $newArray[$i + 1]) {
				$mod = fmod($point, $number);
				//echo "<br>" . $per . "<br>";
				$point_per = $per + $mod;
			}

		}
		//echo $point;
		$resp .= '</div>
        <div id="point_val" class="prog_gre_val" style="left: ' . $point_per . '%;"></div>
	</div>';
		return $resp;
		//$('#point_val').css('left',point_per+'%')

		//$('#linear').html(resp);
	}

	public function calculate_fifteen_minutes_contracts($symbol) {

		$datetime = date("Y-m-d H:i:s", strtotime('-15 minutes'));
		$orig_date22 = new DateTime($datetime);
		$orig_date22 = $orig_date22->getTimestamp();
		$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);

		$search['created_date'] = array('$gte' => $end_date);
		$search['coin'] = $symbol;
		$search['maker'] = 'true';

		$this->mongo_db->where($search);
		$get = $this->mongo_db->get("market_trades");

		$res = iterator_to_array($get);
		$bid_vol = 0;
		foreach ($res as $key => $value) {
			$vol = $value['quantity'];
			$bid_vol += $vol;
		}

		$search['created_date'] = array('$gte' => $end_date);
		$search['coin'] = $symbol;
		$search['maker'] = 'false';

		$this->mongo_db->where($search);
		$get = $this->mongo_db->get("market_trades");

		$res = iterator_to_array($get);
		$ask_vol = 0;
		foreach ($res as $key => $value) {
			$vol = $value['quantity'];
			$ask_vol += $vol;
		}
		$total_volume = $bid_vol + $ask_vol;

		/*$bid_per = ($bid_vol * 100) / $total_volume;
			$ask_per = ($ask_vol * 100) / $total_volume;
			$current = array(
				'bid_vol' => $bid_vol,
				'ask_vol' => $ask_vol,
		*/
		/*echo $bid_vol;
			echo "<br>";
			echo $ask_vol;
		*/
		$bid_ask_volume = $this->get_bid_ask_volume($symbol);
		/*echo "<pre>";
		print_r($bid_ask_volume);*/
		$bids = $bid_ask_volume['bids'];
		$asks = $bid_ask_volume['asks'];
		$bid_index = 0;
		$ask_index = 0;
		for ($i = 0; $i < count($bids); $i++) {
			if ($bid_vol <= $bids[$i]) {
				$bid_index = $i;
				break;
			}
		}

		for ($i = 0; $i < count($asks); $i++) {
			if ($ask_vol <= $asks[$i]) {
				$ask_index = $i;
				break;
			}
		}

		/*echo $bid_index;
			echo "<br>";
			echo $ask_index;
		*/
		//$demand_percentage_index = round((count($volume_arr) / 100) * $reject_per);
		$bid_level_percentage = ($bid_index / 100) * 100;
		$ask_level_percentage = ($ask_index / 100) * 100;

		/*echo $bid_level_percentage;
			echo "<br>";
			echo $ask_level_percentage;
		*/

		return array('bid' => $bid_level_percentage, 'ask' => $ask_level_percentage);
	}
	public function get_bid_ask_volume($coin_symbol) {

		$this->mongo_db->where(array('coin' => $coin_symbol));
		$this->mongo_db->limit(100);
		$this->mongo_db->sort(array('_id' => -1));

		$responseArr222 = $this->mongo_db->get('fifteen_min_market_history');

		$ers = iterator_to_array($responseArr222);
		$bid_array = array();
		$ask_array = array();
		foreach ($ers as $key => $value) {
			$bid_array[] = $value['bid_quantity'];
			$ask_array[] = $value['ask_quantity'];
		}
		sort($bid_array);
		sort($ask_array);
		$full_arr['bids'] = $bid_array;
		$full_arr['asks'] = $ask_array;

		return $full_arr;

	}

}
