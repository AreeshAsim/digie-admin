<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
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
		$this->load->model('admin/mod_market');
	}

	public function test_market() {

		$global_symbol = $this->session->userdata('global_symbol');

		//Get Market Prices
		$this->mongo_db->where(array('coin' => 'NCASHBTC'));
		$this->mongo_db->limit(100);
		$this->mongo_db->sort(array('_id' => 'desc'));
		$responseArr = $this->mongo_db->get('market_prices');

		$final_arr = array();
		foreach ($responseArr as $valueArr) {
			if (!empty($valueArr)) {
				$market_value = $valueArr['price'];

				$fullarray[] = num($market_value);
			}
		}

		echo "<pre>";
		print_r($fullarray);
		exit;

	}
	public function test_session() {
		echo "<pre>";
		print_r($this->session->userdata());
		exit;
	}
	public function new_test() {

		$global_symbol = $this->session->userdata('global_symbol');
		$market_value = $this->mod_dashboard->get_market_value($global_symbol);

		$priceAsk = num((float) $market_value);
		$db = $this->mongo_db->customQuery();

		$params = array(
			'start_value' => array('$gte' => $priceAsk),
			'end_value' => array('$lte' => $priceAsk),
			'coin' => $global_symbol,
		);

		$res = $db->chart_target_zones->find($params);

		foreach ($res as $valueArr) {
			if (!empty($valueArr)) {

				echo "<pre>";
				print_r($valueArr);
				exit;

			}
		}

		exit;

	}

	public function get_order_custom($id) {

		$order_arr = $this->mod_dashboard->get_order($id);

		echo "<pre>";
		print_r($order_arr);
		exit;

	}

	public function get_buy_order_custom($id) {

		$order_arr = $this->mod_dashboard->get_buy_order($id);

		echo "<pre>";
		print_r($order_arr);
		exit;

	}

	public function manual_update($id) {

		$global_symbol = $this->session->userdata('global_symbol');

		//limit_order market_order
		$upd_data = array(
			'trigger_type' => 'no',
		);

		$this->mongo_db->where(array('_id' => $id));
		$this->mongo_db->set($upd_data);

		//Update data in mongoTable
		$this->mongo_db->update('orders');

	}

	public function manual_update22($id) {

		$global_symbol = $this->session->userdata('global_symbol');

		//limit_order market_order
		$upd_data = array(
			'application_mode' => 'live',
		);

		$this->mongo_db->where(array('_id' => $id));
		$this->mongo_db->set($upd_data);

		//Update data in mongoTable
		$this->mongo_db->update('buy_orders');

	}

	public function manual_delete($id) {
		$this->mongo_db->where(array('_id' => $id));

		//Delete data in mongoTable
		$this->mongo_db->delete('buy_orders');
	}

	public function user_testing() {
		$user_testing = $this->binance_api->user_testing();
	}

	public function get_account_balance() {

		$this->binance_api->get_account_balance();
	}

	public function manual_buy() {

		$created_date = date('Y-m-d G:i:s');
		$admin_id = $this->session->userdata('admin_id');
		$global_symbol = $this->session->userdata('global_symbol');

		$ins_data = array(
			'price' => '0.00000247',
			'quantity' => '420',
			'symbol' => 'NCASHBTC',
			'order_type' => 'limit_order',
			'admin_id' => $admin_id,
			'created_date' => $this->mongo_db->converToMongodttime($created_date),
		);

		$ins_data['trail_check'] = 'no';
		$ins_data['trail_interval'] = '0';
		$ins_data['buy_trail_price'] = '0';
		$ins_data['market_value'] = '0.00000247';
		$ins_data['status'] = 'submitted';
		$ins_data['binance_order_id'] = '15325247';

		//Insert data in mongoTable
		$this->mongo_db->insert('buy_orders', $ins_data);
	}

	public function manual_sell() {

		$created_date = date('Y-m-d G:i:s');
		$admin_id = $this->session->userdata('admin_id');
		$global_symbol = $this->session->userdata('global_symbol');

		$ins_data = array(
			'purchased_price' => '0.00000390',
			'quantity' => '260',
			'profit_type' => 'percentage',
			'order_type' => 'limit_order',
			'admin_id' => $admin_id,
			'buy_order_check' => 'yes',
			'buy_order_id' => '5ac638e91c0b7623e117d792',
			'buy_order_binance_id' => '6069005',
			'created_date' => $this->mongo_db->converToMongodttime($created_date),
		);

		$ins_data['sell_profit_percent'] = '1';
		$ins_data['sell_price'] = '0.00000413';

		$ins_data['trail_check'] = 'no';
		$ins_data['trail_interval'] = '0';
		$ins_data['sell_trail_price'] = '0';

		$ins_data['market_value'] = '0.00000413';
		$ins_data['status'] = 'FILLED';
		$ins_data['binance_order_id'] = '5879337';

		//Insert data in mongoTable
		$order_id = $this->mongo_db->insert('orders', $ins_data);

		//Update Buy Order
		$upd_data = array(
			'is_sell_order' => 'yes',
			'sell_order_id' => $order_id,
		);

		$this->mongo_db->where(array('_id' => '5ac638e91c0b7623e117d792'));
		$this->mongo_db->set($upd_data);

		//Update data in mongoTable
		$this->mongo_db->update('buy_orders');

	}

	public function place_buy_order() {

		$pirces = $this->binance_api->place_buy_order();
	}

	public function order_status() {

		$pirces = $this->binance_api->order_status();
	}

	public function get_all_orders() {

		$this->mod_dashboard->get_all_orders();

	}

	public function get_market_data() {

		//get_market_data
		$market_buy_depth_arr = $this->mod_dashboard->get_market_data();
	}

	public function index() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Fetching Market Buy Depth
		$market_buy_depth_data = $this->mod_dashboard->get_market_buy_depth();
		$data['market_buy_depth_arr'] = $market_buy_depth_data['fullarray'];

		$market_value = $market_buy_depth_data['market_value'];
		$data['market_value'] = num($market_value);

		//Fetching Market Sell Depth
		$market_sell_depth_data = $this->mod_dashboard->get_market_sell_depth();
		$data['market_sell_depth_arr'] = $market_sell_depth_data['fullarray'];

		//Fetching Market History
		$market_history_arr = $this->mod_dashboard->get_market_history();
		$data['market_history_arr'] = $market_history_arr;

		$global_symbol = $this->session->userdata('global_symbol');
		$currncy = str_replace('BTC', '', $global_symbol);
		$data['currncy'] = $currncy;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/dashboard', $data);

	}

	public function chart() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Fetching Market Buy Depth
		$market_buy_depth_data = $this->mod_dashboard->get_market_buy_depth_chart();
		$data['market_buy_depth_arr'] = $market_buy_depth_data['fullarray'];
		$buy_big_quantity = $market_buy_depth_data['buy_big_quantity'];

		$market_value = $market_buy_depth_data['market_value'];
		$data['market_value'] = num($market_value);

		//Fetching Market Sell Depth
		$market_sell_depth_data = $this->mod_dashboard->get_market_sell_depth_chart();
		$data['market_sell_depth_arr'] = $market_sell_depth_data['fullarray'];
		$sell_big_quantity = $market_sell_depth_data['sell_big_quantity'];

		if ($buy_big_quantity > $sell_big_quantity) {
			$biggest_value = $buy_big_quantity;
		} else {
			$biggest_value = $sell_big_quantity;
		}

		$data['biggest_value'] = $biggest_value;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/chart', $data);
	}

	public function chart2() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Fetching Market Buy Depth
		$market_buy_depth_data = $this->mod_dashboard->get_market_buy_depth_chart();
		$data['market_buy_depth_arr'] = $market_buy_depth_data['fullarray'];
		$buy_big_quantity = $market_buy_depth_data['buy_big_quantity'];

		$market_value = $market_buy_depth_data['market_value'];
		$data['market_value'] = num($market_value);

		//Fetching Market Sell Depth
		$market_sell_depth_data = $this->mod_dashboard->get_market_sell_depth_chart();
		$data['market_sell_depth_arr'] = $market_sell_depth_data['fullarray'];
		$sell_big_quantity = $market_sell_depth_data['sell_big_quantity'];

		if ($buy_big_quantity > $sell_big_quantity) {
			$biggest_value = $buy_big_quantity;
		} else {
			$biggest_value = $sell_big_quantity;
		}

		$data['biggest_value'] = $biggest_value;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/chart2', $data);
	}

	public function chart3() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Fetching Market Buy Depth
		$market_buy_depth_data = $this->mod_dashboard->get_market_buy_depth_chart();
		$data['market_buy_depth_arr'] = $market_buy_depth_data['fullarray'];
		$buy_big_quantity = $market_buy_depth_data['buy_big_quantity'];

		$market_value = $market_buy_depth_data['market_value'];
		$data['market_value'] = num($market_value);

		//Fetching Market Sell Depth
		$market_sell_depth_data = $this->mod_dashboard->get_market_sell_depth_chart();
		$data['market_sell_depth_arr'] = $market_sell_depth_data['fullarray'];
		$sell_big_quantity = $market_sell_depth_data['sell_big_quantity'];

		if ($buy_big_quantity > $sell_big_quantity) {
			$biggest_value = $buy_big_quantity;
		} else {
			$biggest_value = $sell_big_quantity;
		}

		$data['biggest_value'] = $biggest_value;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/chart3', $data);
	}

	public function autoload_trading_data() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		$global_symbol = $this->session->userdata('global_symbol');
		$currncy = str_replace('BTC', '', $global_symbol);

		$market_value = $this->input->post('market_value');

		//Fetching Market Sell Depth
		$market_sell_depth_data = $this->mod_dashboard->get_market_sell_depth($market_value);
		$market_value = $market_sell_depth_data['market_value'];
		$market_sell_depth_arr = $market_sell_depth_data['fullarray'];

		$market_value = num($market_value);

		$response = '';
		if (count($market_sell_depth_arr) > 0) {
			$response = '<table class="table table-condensed">
                            <thead>
                                <tr>
                                  <td><strong>Price(BTC)</strong></td>
                                  <td><strong>Amount(' . $currncy . ')</strong></td>
                                  <td><strong>Total(BTC)</strong></td>
                                </tr>
                            </thead>
                          	<tbody>';
			foreach ($market_sell_depth_arr as $key => $value) {

				$price = num($value['price']);

				$response .= '<tr>
                                <td>' . number_format($price, 8, '.', '') . '</td>
                                <td>' . number_format($value['quantity'], 2, '.', '') . '</td>
                                <td>';
				$total_price = $value['price'] * $value['quantity'];
				$response .= number_format($total_price, 8, '.', '');
				$response .= '</td>
                             </tr>';
			}
			$response .= '</tbody>
                    </table>';
		}

		//Fetching Market Buy Depth
		$market_buy_depth_data = $this->mod_dashboard->get_market_buy_depth($market_value);
		$market_value = $market_buy_depth_data['market_value'];
		$market_buy_depth_arr = $market_buy_depth_data['fullarray'];

		$response2 = '';
		if (count($market_buy_depth_arr) > 0) {
			$response2 = '<table class="table table-condensed">
                            <thead>
                                <tr>
                                  <td><strong>Price(BTC)</strong></td>
                                  <td><strong>Amount(' . $currncy . ')</strong></td>
                                  <td><strong>Total(BTC)</strong></td>
                                </tr>
                            </thead>
                          	<tbody>';
			foreach ($market_buy_depth_arr as $key => $value2) {

				$price22 = num($value2['price']);

				$response2 .= '<tr>
                                <td>' . number_format($price22, 8, '.', '') . '</td>
                                <td>' . number_format($value2['quantity'], 2, '.', '') . '</td>
                                <td>';
				$total_price2 = $value2['price'] * $value2['quantity'];
				$response2 .= number_format($total_price2, 8, '.', '');
				$response2 .= '</td>
                             </tr>';
			}
			$response2 .= '</tbody>
                    </table>';

		}

		//Fetching Market History
		$market_history_arr = $this->mod_dashboard->get_market_history();

		$response3 = '';
		if (count($market_history_arr) > 0) {
			$response3 = '<table class="table table-condensed">
                            <thead>
                                <tr>
                                  <td><strong>Price(BTC)</strong></td>
                                  <td><strong>Amount(' . $currncy . ')</strong></td>
                                  <td><strong>Total(BTC)</strong></td>
                                </tr>
                            </thead>
                          	<tbody>';
			foreach ($market_history_arr as $key => $value3) {

				$maker = $value3['maker'];
				if ($maker == 'true') {
					$color = "red";
				} else {
					$color = "green";
				}
				if ($_SERVER['REMOTE_ADDR'] == '58.65.164.72') {
					$response3 .= '<tr style="color:' . $color . ';">
                                    <td>' . number_format($value3['price'], 8, '.', '') . '(' . $value3['counter'] . ')</td>
                                    <td>' . number_format($value3['quantity'], 2, '.', '') . '</td>
                                    <td>';
					$total_price3 = $value3['price'] * $value3['quantity'];
					$response3 .= number_format($total_price3, 8, '.', '');
					$response3 .= '</td>
                                             </tr>';
				} else {
					$response3 .= '<tr style="color:' . $color . ';">
                                                    <td>' . number_format($value3['price'], 8, '.', '') . '</td>
                                                    <td>' . number_format($value3['quantity'], 2, '.', '') . '</td>
                                                    <td>';
					$total_price3 = $value3['price'] * $value3['quantity'];
					$response3 .= number_format($total_price3, 8, '.', '');
					$response3 .= '</td>
                                                 </tr>';
				}
			}
			$response3 .= '</tbody>
                    </table>';
		}

		echo $response . "|" . $response2 . "|" . $response3 . "|" . number_format($market_value, 8, '.', '');
		exit;

	} //end autoload_trading_data

	public function autoload_trading_chart_data() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		$market_value = $this->input->post('market_value');
		$previous_market_value = $this->input->post('previous_market_value');

		//Fetching Market Buy Depth
		$market_buy_depth_data = $this->mod_dashboard->get_market_buy_depth_chart($market_value);
		$market_value = $market_buy_depth_data['market_value'];
		$market_buy_depth_arr = $market_buy_depth_data['fullarray'];
		$buy_big_quantity = $market_buy_depth_data['buy_big_quantity'];

		//Fetching Market Sell Depth
		$market_sell_depth_data = $this->mod_dashboard->get_market_sell_depth_chart($market_value);
		$market_value = $market_sell_depth_data['market_value'];
		$market_sell_depth_arr = $market_sell_depth_data['fullarray'];
		$sell_big_quantity = $market_sell_depth_data['sell_big_quantity'];

		if ($buy_big_quantity > $sell_big_quantity) {
			$biggest_value = $buy_big_quantity;
		} else {
			$biggest_value = $sell_big_quantity;
		}

		$market_value = num($market_value);

		$response = '<ul class="price_s_r_ul">';

		if (count($market_buy_depth_arr) > 0) {
			$i = 0;
			foreach ($market_buy_depth_arr as $key => $value) {

				$price = num($value['price']);

				$response .= '<li class="price_s_r_li" d_price="' . $price . '" index="' . $i . '">
			                        <div class="buyer_prog_main">
			                            <div class="blu_prog">
			                                <div class="blue_prog_p">' . $value['sell_quantity'] . '</div>';
				$sell_percentage = round($value['sell_quantity'] * 100 / $biggest_value);

				if ($sell_percentage == 100) {
					$type = 'buy';
				}

				$response .= '<div class="blue_prog_bar" d_prog_percent="' . $sell_percentage . '"></div>
			                            </div>
			                        </div>
			                        <div class="price_cent_main">
			                            <span class="simple_p gray_v_p">' . $price . '</span>
			                        </div>
			                        <div class="seller_prog_main">
			                            <div class="red_prog">
			                                <div class="red_prog_p">' . $value['buy_quantity'] . '</div>';
				$buy_percentage = round($value['buy_quantity'] * 100 / $biggest_value);

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

		$response .= '<li class="price_s_r_li" d_price="' . $market_value . '" index="' . $i++ . '">
				            <div class="buyer_prog_main">
				            </div>
				            <div class="price_cent_main">
				                <span class="simple_p white_v_p" id="response2222">
				                 <span class="' . $class . '">' . $market_value . '</span>
				                </span>
				            </div>
				            <div class="seller_prog_main">
				                <div class="red_prog">
				                </div>
				            </div>
				        </li>';

		if (count($market_sell_depth_arr) > 0) {

			foreach ($market_sell_depth_arr as $key => $value2) {

				$price22 = num($value2['price']);

				$response .= '<li class="price_s_r_li" d_price="' . $price22 . '" index="' . $i . '">
			                        <div class="buyer_prog_main">
			                            <div class="blu_prog">
			                                <div class="blue_prog_p">' . $value2['sell_quantity'] . '</div>';
				$sell_percentage2 = round($value2['sell_quantity'] * 100 / $biggest_value);

				if ($sell_percentage2 == 100) {
					$type = 'buy';
				}

				$response .= '<div class="blue_prog_bar" d_prog_percent="' . $sell_percentage2 . '"></div>
			                            </div>
			                        </div>
			                        <div class="price_cent_main">
			                            <span class="simple_p light_gray_v_p">' . $price22 . '</span>
			                        </div>
			                        <div class="seller_prog_main">
			                            <div class="red_prog">
			                                <div class="red_prog_p">' . $value2['buy_quantity'] . '</div>';
				$buy_percentage2 = round($value2['buy_quantity'] * 100 / $biggest_value);

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
		$zone_values_arr = $this->mod_dashboard->get_zone_values($market_value);

		$buy_quantity = $zone_values_arr['buy_quantity'];
		$sell_quantity = $zone_values_arr['sell_quantity'];
		$buy_percentage = $zone_values_arr['buy_percentage'];
		$sell_percentage = $zone_values_arr['sell_percentage'];
		$zone_id = $zone_values_arr['zone_id'];

		$response2 = '<div class="G_current_val ' . $class . '">
			                <div class="GCV_text"><b>' . $market_value . '</b></div>
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
		$chart_target_zones_arr = $this->mod_dashboard->get_chart_target_zones();

		echo $response . "|" . $response2 . "|" . $response3 . "|" . $type . "|" . json_encode($chart_target_zones_arr) . "|" . $response4;
		exit;

	} //end autoload_trading_chart_data

	public function autoload_trading_chart_data222() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		$market_value = $this->input->post('market_value');
		$previous_market_value = $this->input->post('previous_market_value');

		//Fetching Market Buy Depth
		$market_buy_depth_data = $this->mod_dashboard->get_market_buy_depth_chart($market_value);
		$market_value = num($market_buy_depth_data['market_value']);
		$market_buy_depth_arr = $market_buy_depth_data['fullarray'];
		$buy_big_quantity = $market_buy_depth_data['buy_big_quantity'];
		$depth_buy_big_quantity = $market_buy_depth_data['depth_buy_big_quantity'];

		//Fetching Market Sell Depth
		$market_sell_depth_data = $this->mod_dashboard->get_market_sell_depth_chart($market_value);
		$market_value = num($market_sell_depth_data['market_value']);
		$market_sell_depth_arr = $market_sell_depth_data['fullarray'];
		$sell_big_quantity = $market_sell_depth_data['sell_big_quantity'];
		$depth_sell_big_quantity = $market_buy_depth_data['depth_sell_big_quantity'];

		if ($buy_big_quantity > $sell_big_quantity) {
			$biggest_value = $buy_big_quantity;
		} else {
			$biggest_value = $sell_big_quantity;
		}

		if ($depth_buy_big_quantity > $depth_sell_big_quantity) {
			$biggest_value2 = $depth_buy_big_quantity;
		} else {
			$biggest_value2 = $depth_sell_big_quantity;
		}

		$response = '<ul class="price_s_r_ul">';

		if (count($market_buy_depth_arr) > 0) {
			$i = 0;
			foreach ($market_buy_depth_arr as $key => $value) {

				$price = num($value['price']);

				$response .= '<li class="price_s_r_li with_BS" d_price="' . num($price) . '" index="' . $i . '">
			                        <div class="wbs_buyer_prog_main">
			                            <div class="wbs_blu_prog">
			                                <div class="wbs_blue_prog_p">' . number_format($value['depth_sell_quantity'], 2, '.', '') . '</div>';
				$sell_percentage22 = round($value['depth_sell_quantity'] * 100 / $biggest_value2);

				$response .= '<div class="wbs_blue_prog_bar" WBS_d_prog_percent="' . $sell_percentage22 . '"></div>
			                            </div>
			                        </div>
			                        <div class="buyer_prog_main">
			                            <div class="blu_prog">
			                                <div class="blue_prog_p">' . number_format($value['sell_quantity'], 2, '.', '') . '</div>';
				$sell_percentage = round($value['sell_quantity'] * 100 / $biggest_value);

				if ($sell_percentage == 100) {
					$type = 'buy';
				}

				$response .= '<div class="blue_prog_bar" d_prog_percent="' . $sell_percentage . '"></div>
			                            </div>
			                        </div>
			                        <div class="price_cent_main">
			                            <span class="simple_p gray_v_p">' . num($price) . '</span>
			                        </div>
			                        <div class="seller_prog_main">
			                            <div class="red_prog">
			                                <div class="red_prog_p">' . number_format($value['buy_quantity'], 2, '.', '') . '</div>';
				$buy_percentage = round($value['buy_quantity'] * 100 / $biggest_value);

				if ($buy_percentage == 100) {
					$type = 'sell';
				}

				$response .= '<div class="red_prog_bar" d_prog_percent="' . $buy_percentage . '"></div>
			                            </div>
			                        </div>
			                        <div class="wbs_seller_prog_main">
			                            <div class="wbs_red_prog">
			                                <div class="wbs_red_prog_p">' . number_format($value['depth_buy_quantity'], 2, '.', '') . '</div>';
				$buy_percentage22 = round($value['depth_buy_quantity'] * 100 / $biggest_value2);

				$response .= '<div class="wbs_red_prog_bar" wbs_d_prog_percent="' . $buy_percentage22 . '"></div>
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
				            <div class="wbs_buyer_prog_main">
	                        </div>
				            <div class="buyer_prog_main">
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

			foreach ($market_sell_depth_arr as $key => $value2) {

				$price22 = num($value2['price']);

				$response .= '<li class="price_s_r_li with_BS" d_price="' . num($price22) . '" index="' . $i . '">
			                        <div class="wbs_buyer_prog_main">
			                            <div class="wbs_blu_prog">
			                                <div class="wbs_blue_prog_p">' . number_format($value2['depth_sell_quantity'], 2, '.', '') . '</div>';
				$sell_percentage222 = round($value2['depth_sell_quantity'] * 100 / $biggest_value2);

				$response .= '<div class="wbs_blue_prog_bar" WBS_d_prog_percent="' . $sell_percentage222 . '"></div>
			                            </div>
			                        </div>
			                        <div class="buyer_prog_main">
			                            <div class="blu_prog">
			                                <div class="blue_prog_p">' . number_format($value2['sell_quantity'], 2, '.', '') . '</div>';
				$sell_percentage2 = round($value2['sell_quantity'] * 100 / $biggest_value);

				if ($sell_percentage2 == 100) {
					$type = 'buy';
				}

				$response .= '<div class="blue_prog_bar" d_prog_percent="' . $sell_percentage2 . '"></div>
			                            </div>
			                        </div>
			                        <div class="price_cent_main">
			                            <span class="simple_p light_gray_v_p">' . num($price22) . '</span>
			                        </div>
			                        <div class="seller_prog_main">
			                            <div class="red_prog">
			                                <div class="red_prog_p">' . number_format($value2['buy_quantity'], 2, '.', '') . '</div>';
				$buy_percentage2 = round($value2['buy_quantity'] * 100 / $biggest_value);

				if ($buy_percentage2 == 100) {
					$type = 'sell';
				}

				$response .= '<div class="red_prog_bar" d_prog_percent="' . $buy_percentage2 . '"></div>
			                            </div>
			                        </div>
			                        <div class="wbs_seller_prog_main">
			                            <div class="wbs_red_prog">
			                                <div class="wbs_red_prog_p">' . number_format($value2['depth_buy_quantity'], 2, '.', '') . '</div>';
				$buy_percentage222 = round($value2['depth_buy_quantity'] * 100 / $biggest_value2);

				$response .= '<div class="wbs_red_prog_bar" wbs_d_prog_percent="' . $buy_percentage222 . '"></div>
			                            </div>
			                        </div>
			                    </li>';

				$i++;

			} //end foreach
		} //end if

		$response .= '</ul>';

		//GEt Zone values
		$zone_values_arr = $this->mod_dashboard->get_zone_values($market_value);

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
		$chart_target_zones_arr = $this->mod_dashboard->get_chart_target_zones();

		//Get Sell Orders
		$orders_arr = $this->mod_dashboard->get_sell_active_orders();

		//Get Buy Orders
		$buy_orders_arr = $this->mod_dashboard->get_buy_active_orders();

		echo $response . "|" . $response2 . "|" . $response3 . "|" . $type . "|" . json_encode($chart_target_zones_arr) . "|" . $response4 . "|" . json_encode($orders_arr) . "|" . json_encode($buy_orders_arr);
		exit;

	} //end autoload_trading_chart_data222

	public function edit_profile() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Fetching user Record
		$user_arr = $this->mod_users->get_user($this->session->userdata('admin_id'));
		$data['user_arr'] = $user_arr;
		$time_zone_arr = $this->mod_dashboard->get_time_zone();
		$data['time_zone_arr'] = $time_zone_arr;
		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/edit_profile', $data);
	}

	public function edit_profile_process() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//edit_user
		$user_id = $this->mod_users->edit_user($this->input->post());

		if ($user_id) {

			redirect(base_url() . 'admin/dashboard/edit-profile');

		} else {

			redirect(base_url() . 'admin/dashboard/edit-profile');

		} //end if

	} //end edit_profile_process

	public function test($price) {

		$this->mongo_db->where(array('type' => 'ask', 'coin' => 'BNBBTC', 'price' => (float) $price));
		$responseArr2222 = $this->mongo_db->get('market_depth');

		//////////////
		$fullarray = array();
		foreach ($responseArr2222 as $valueArr) {
			$returArr = array();

			if (!empty($valueArr)) {

				$datetime = $valueArr['created_date']->toDateTime();
				$created_date = $datetime->format(DATE_RSS);

				$datetime = new DateTime($created_date);
				$datetime->format('Y-m-d g:i:s A');

				$new_timezone = new DateTimeZone('Asia/Karachi');
				$datetime->setTimezone($new_timezone);
				$formated_date_time = $datetime->format('Y-m-d g:i:s A');

				$returArr['_id'] = $valueArr['_id'];
				$returArr['price'] = $valueArr['price'];
				$returArr['quantity'] = $valueArr['quantity'];
				$returArr['maker'] = $valueArr['maker'];
				$returArr['coin'] = $valueArr['coin'];
				$returArr['created_date'] = $formated_date_time;

			}

			$fullarray[] = $returArr;
		}

		echo "<pre>";
		print_r($fullarray);
		exit;
	}

	public function add_zone() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_coins();
		$data['coins_arr'] = $coins_arr;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/add_zone', $data);
	}

	public function add_zone_process() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//add_zone
		$add_zone = $this->mod_dashboard->add_zone($this->input->post());

		if ($add_zone) {

			$this->session->set_flashdata('ok_message', 'Record added successfully.');
			redirect(base_url() . 'admin/dashboard/add-zone');

		} else {

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
			redirect(base_url() . 'admin/dashboard/add-zone');

		} //end if

	} //end add_zone_process

	public function edit_zone($id) {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Get zone Record
		$zone_arr = $this->mod_dashboard->get_zone($id);
		$data['zone_arr'] = $zone_arr;

		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_coins();
		$data['coins_arr'] = $coins_arr;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/edit_zone', $data);
	}

	public function edit_zone_process() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//edit_zone
		$edit_zone = $this->mod_dashboard->edit_zone($this->input->post());

		$id = $this->input->post('id');

		if ($edit_zone) {

			$this->session->set_flashdata('ok_message', 'Record updated successfully.');
			redirect(base_url() . 'admin/dashboard/zone-listing');

		} else {

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
			redirect(base_url() . 'admin/dashboard/edit-zone/' . $id);

		} //end if

	} //end edit_zone_process

	public function delete_zone($id) {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//delete_zone
		$delete_zone = $this->mod_dashboard->delete_zone($id);

		if ($delete_zone) {

			$this->session->set_flashdata('ok_message', 'Record deleted successfully.');
			redirect(base_url() . 'admin/dashboard/zone-listing');

		} else {

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
			redirect(base_url() . 'admin/dashboard/edit-zone');

		} //end if

	} //end delete_zone

	public function zone_listing() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Get zones Record
		$chart_target_zones_arr = $this->mod_dashboard->get_chart_target_zones();
		$data['chart_target_zones_arr'] = $chart_target_zones_arr;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/zone_listing', $data);
	}

	public function add_order($buy_id = '') {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_coins();
		$data['coins_arr'] = $coins_arr;

		if ($buy_id != "") {

			//Get Order Record
			$order_arr = $this->mod_dashboard->get_buy_order($buy_id);
			$data['order_arr'] = $order_arr;
			$data['buy_order_check'] = 'yes';

		} else {

			$data['buy_order_check'] = 'no';
		}

		//Get Order History
		$order_history_arr = $this->mod_dashboard->get_order_history_log($buy_id);
		$data['order_history_arr'] = $order_history_arr;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/add_order', $data);

	} //end add_order

	public function add_order_process() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//add_order
		$add_order = $this->mod_dashboard->add_order($this->input->post());

		$buy_order_id = $this->input->post('buy_order_id');
		$buy_order_check = $this->input->post('buy_order_check');

		if ($add_order['error'] != "") {

			if ($buy_order_check == 'yes') {

				$this->session->set_flashdata('err_message', $add_order['error']);
				redirect(base_url() . 'admin/dashboard/add-order/' . $buy_order_id);

			} else {

				$this->session->set_flashdata('err_message', $add_order['error']);
				redirect(base_url() . 'admin/dashboard/add-order');
			}

		}

		if ($add_order) {

			$this->session->set_flashdata('ok_message', 'Record added successfully.');
			redirect(base_url() . 'admin/dashboard/edit-order/' . $buy_order_id);

		} else {

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
			redirect(base_url() . 'admin/dashboard/add-order');

		} //end if

	} //end add_order_process

	public function edit_order($id) {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_coins();
		$data['coins_arr'] = $coins_arr;

		//Get Order Record
		$order_arr = $this->mod_dashboard->get_order($id);
		$data['order_arr'] = $order_arr;

		//Get Order History
		$order_history_arr = $this->mod_dashboard->get_order_history_log($order_arr['buy_order_id']);
		$data['order_history_arr'] = $order_history_arr;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/edit_order', $data);

	} //end edit_order

	public function edit_order_process() {

		//Login Check
		$this->mod_login->verify_is_admin_login();
		//edit_order
		$edit_order = $this->mod_dashboard->edit_order($this->input->post());

		$id = $this->input->post('id');

		if ($edit_order['error'] != "") {

			$this->session->set_flashdata('err_message', $edit_order['error']);
			redirect(base_url() . 'admin/dashboard/edit-order/' . $id);
		}

		if ($edit_order) {

			$this->session->set_flashdata('ok_message', 'Record updated successfully.');
			redirect(base_url() . 'admin/dashboard/edit-order/' . $id);

		} else {

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
			redirect(base_url() . 'admin/dashboard/edit-order/' . $id);

		} //end if

	} //end edit_order_process

	public function delete_order($id, $order_id) {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//delete_order
		$delete_order = $this->mod_dashboard->delete_order($id, $order_id);

		if ($delete_order) {

			$this->session->set_flashdata('ok_message', 'Record deleted successfully.');
			redirect(base_url() . 'admin/dashboard/orders-listing');

		} else {

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
			redirect(base_url() . 'admin/dashboard/edit-order');

		} //end if

	} //end delete_order

	/*public function orders_listing()
		{
			//Login Check
			$this->mod_login->verify_is_admin_login();

			if($this->input->post()){

			 	$data_arr['filter-data'] = $this->input->post();
				$this->session->set_userdata($data_arr);
				redirect(base_url().'admin/dashboard/orders-listing');
			}

			//Fetching coins Record
			$coins_arr = $this->mod_coins->get_all_coins();
			$data['coins_arr'] = $coins_arr;

			$global_symbol = $this->session->userdata('global_symbol');

			//Get Orders
			$orders_arr = $this->mod_dashboard->get_orders();
			$data['orders_arr'] = $orders_arr;

			//Get Market Price
			$this->mongo_db->where(array('coin'=> $global_symbol));
			$this->mongo_db->limit(1);
			$this->mongo_db->sort(array('_id'=> 'desc'));
			$responseArr = $this->mongo_db->get('market_prices');

			foreach ($responseArr as  $valueArr) {
				if(!empty($valueArr)){
					$market_value = $valueArr['price'];
				}
			}

			$data['market_value'] = $market_value;

			//stencil is our templating library. Simply call view via it
			$this->stencil->paint('admin/dashboard/orders_listing',$data);

		}//end orders_listing
	*/
	public function orders_listing() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		if ($this->input->post()) {

			$data_arr['filter-data'] = $this->input->post();
			$this->session->set_userdata($data_arr);
			redirect(base_url() . 'admin/dashboard/orders-listing');
		}

		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_coins();
		$data['coins_arr'] = $coins_arr;

		$global_symbol = $this->session->userdata('global_symbol');

		$filled_orders = array();
		$new_orders = array();
		$error_orders = array();
		$cancelled = array();
		$orders_arr = $this->mod_dashboard->get_orders();
		foreach ($orders_arr as $key => $value) {
			if ($value['status'] == 'new') {
				$new_orders[] = $value;
			} elseif ($value['status'] == 'FILLED') {
				$filled_orders[] = $value;
			} elseif ($value['status'] == 'cancelled') {
				$cancelled[] = $value;
			} elseif ($value['status'] == 'error') {
				$error_orders[] = $value;
			}
		}

		$data['orders_arr'] = $orders_arr;
		$data['filled_arr'] = $filled_orders;
		$data['new_arr'] = $new_orders;
		$data['cancelled_arr'] = $cancelled;
		$data['error_arr'] = $error_orders;
		//Get Market Price
		$this->mongo_db->where(array('coin' => $global_symbol));
		$this->mongo_db->limit(1);
		$this->mongo_db->sort(array('_id' => 'desc'));
		$responseArr = $this->mongo_db->get('market_prices');

		foreach ($responseArr as $valueArr) {
			if (!empty($valueArr)) {
				$market_value = $valueArr['price'];
			}
		}

		$data['market_value'] = $market_value;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/orders_listing', $data);
	}

	public function add_buy_order() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_coins();
		$data['coins_arr'] = $coins_arr;

		//Get Market Value
		$market_value = $this->mod_dashboard->get_market_value();
		$data['market_value'] = $market_value;

		//Check Buy Zones
		$check_buy_zones = $this->mod_dashboard->check_buy_zones($market_value);
		$data['in_zone'] = $check_buy_zones['in_zone'];
		$data['type'] = $check_buy_zones['type'];
		$data['start_value'] = $check_buy_zones['start_value'];
		$data['end_value'] = $check_buy_zones['end_value'];

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/add_buy_order', $data);

	} //end add_buy_order

	public function add_buy_order_process() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//add_buy_order
		$add_buy_order = $this->mod_dashboard->add_buy_order($this->input->post());

		if ($add_buy_order['error'] != "") {

			$this->session->set_flashdata('err_message', $add_buy_order['error']);
			redirect(base_url() . 'admin/dashboard/add-buy-order');
		}

		if ($add_buy_order) {

			$this->session->set_flashdata('ok_message', 'Buy Order added successfully.');
			redirect(base_url() . 'admin/dashboard/add-buy-order');

		} else {

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
			redirect(base_url() . 'admin/dashboard/add-buy-order');

		} //end if

	} //end add_buy_order_process

	public function edit_buy_order($id) {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_coins();
		$data['coins_arr'] = $coins_arr;

		//Get Market Value
		$market_value = $this->mod_dashboard->get_market_value();
		$data['market_value'] = $market_value;

		//Check Buy Zones
		$check_buy_zones = $this->mod_dashboard->check_buy_zones($market_value);
		$data['in_zone'] = $check_buy_zones['in_zone'];
		$data['type'] = $check_buy_zones['type'];
		$data['start_value'] = $check_buy_zones['start_value'];
		$data['end_value'] = $check_buy_zones['end_value'];

		//Get Order Record
		$order_arr = $this->mod_dashboard->get_buy_order($id);
		$data['order_arr'] = $order_arr;

		//Get Temp Sell Order Record
		$temp_sell_arr = $this->mod_dashboard->get_temp_sell_data($id);
		$data['temp_sell_arr'] = $temp_sell_arr;

		//Get Order History
		$order_history_arr = $this->mod_dashboard->get_order_history_log($id);
		$data['order_history_arr'] = $order_history_arr;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/edit_buy_order', $data);

	} //end edit_buy_order

	public function edit_buy_order_process() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//edit_buy_order
		$edit_buy_order = $this->mod_dashboard->edit_buy_order($this->input->post());

		$id = $this->input->post('id');

		if ($edit_buy_order['error'] != "") {

			$this->session->set_flashdata('err_message', $add_buy_order['error']);
			redirect(base_url() . 'admin/dashboard/edit-buy-order/' . $id);
		}

		if ($edit_buy_order) {

			$this->session->set_flashdata('ok_message', 'Edit Order updated successfully.');
			redirect(base_url() . 'admin/dashboard/edit-buy-order/' . $id);

		} else {

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
			redirect(base_url() . 'admin/dashboard/edit-buy-order/' . $id);

		} //end if

	} //end edit_buy_order_process

	public function delete_buy_order($id, $order_id) {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//delete_buy_order
		$delete_buy_order = $this->mod_dashboard->delete_buy_order($id, $order_id);

		if ($delete_buy_order) {

			$this->session->set_flashdata('ok_message', 'Record deleted successfully.');
			redirect(base_url() . 'admin/dashboard/buy-orders-listing');

		} else {

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
			redirect(base_url() . 'admin/dashboard/edit-buy-order');

		} //end if

	} //end delete_buy_order

	public function buy_orders_listing22222() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		if ($this->input->post()) {

			$data_arr['filter-data-buy'] = $this->input->post();
			$this->session->set_userdata($data_arr);
			redirect(base_url() . 'admin/dashboard/buy-orders-listing');
		}

		$global_symbol = $this->session->userdata('global_symbol');

		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_coins();
		$data['coins_arr'] = $coins_arr;

		//Get Orders
		$return_data = $this->mod_dashboard->get_buy_orders();

		$data['orders_arr'] = $return_data['fullarray'];
		$data['total_buy_amount'] = $return_data['total_buy_amount'];
		$data['total_sell_amount'] = $return_data['total_sell_amount'];
		$data['total_sold_orders'] = $return_data['total_sold_orders'];
		$data['avg_profit'] = $return_data['avg_profit'];

		//Get Market Price
		$this->mongo_db->where(array('coin' => $global_symbol));
		$this->mongo_db->limit(1);
		$this->mongo_db->sort(array('_id' => 'desc'));
		$responseArr = $this->mongo_db->get('market_prices');

		foreach ($responseArr as $valueArr) {
			if (!empty($valueArr)) {
				$market_value = $valueArr['price'];
			}
		}

		$data['market_value'] = $market_value;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/buy_orders_listing', $data);

	} //end buy_orders_listing

	public function buy_orders_listing() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		if ($this->input->post()) {

			$data_arr['filter-data-buy'] = $this->input->post();
			$this->session->set_userdata($data_arr);
			redirect(base_url() . 'admin/dashboard/buy-orders-listing');
		}
		$filled_orders = array();
		$new_orders = array();
		$error_orders = array();
		$cancelled = array();
		$submitted = array();
		$open_trades = array();
		$sold_trades = array();
		$return_data = $this->mod_dashboard->get_buy_orders();

		$orders_arr = $return_data['fullarray'];
		// echo "<pre>";
		// print_r($orders_arr);
		// exit;
		$data['total_buy_amount'] = $return_data['total_buy_amount'];
		$data['total_sell_amount'] = $return_data['total_sell_amount'];
		$data['total_sold_orders'] = $return_data['total_sold_orders'];
		$data['avg_profit'] = $return_data['avg_profit'];

		foreach ($orders_arr as $key => $value) {
			if ($value['status'] == 'new') {
				$new_orders[] = $value;
			} elseif ($value['status'] == 'FILLED') {
				if ($value['is_sell_order'] == 'yes') {
					$open_trades[] = $value;
				}
				if ($value['is_sell_order'] == 'sold') {
					$sold_trades[] = $value;
				}

				$filled_orders[] = $value;

			} elseif ($value['status'] == 'canceled') {
				$cancelled[] = $value;
			} elseif ($value['status'] == 'error') {
				$error_orders[] = $value;
			} elseif ($value['status'] == 'submitted') {
				$submitted[] = $value;
				$open_trades[] = $value;
			}
		}

		// echo "<pre>";
		// print_r($open_trades);
		// exit;
		$data['orders_arr'] = $orders_arr;
		$data['filled_arr'] = $filled_orders;
		$data['new_arr'] = $new_orders;
		$data['cancelled_arr'] = $cancelled;
		$data['error_arr'] = $error_orders;
		$data['submitted'] = $submitted;
		$data['open_trades'] = $open_trades;
		$data['sold_trades'] = $sold_trades;

		$global_symbol = $this->session->userdata('global_symbol');

		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_coins();
		$data['coins_arr'] = $coins_arr;

		//Get Market Price
		$this->mongo_db->where(array('coin' => $global_symbol));
		$this->mongo_db->limit(1);
		$this->mongo_db->sort(array('_id' => 'desc'));
		$responseArr = $this->mongo_db->get('market_prices');

		foreach ($responseArr as $valueArr) {
			if (!empty($valueArr)) {
				$market_value = $valueArr['price'];
			}
		}

		$data['market_value'] = $market_value;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/buy_orders_listing', $data);
	}

	public function drawCandlestick() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		$resp = $this->mod_dashboard->get_candelstick_data();
		$data["candlesdtickArr"] = $resp;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/candlesdtick', $data);
	}

	public function drawCandlestick_custom() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		$resp = $this->mod_candel->get_candelstick_data();
		$data["candlesdtickArr"] = $resp;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/dashboard/candlesdtick_custom', $data);
		//$this->load->view('admin/dashboard/candlesdtick_custom',$data);
	}

	public function candle_stick_data() {
		$abc = $this->mod_dashboard->get_candelstick_data();
		echo "<pre>";
		print_r($abc);
		exit;
	}

	public function autoload_market_data() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Get Orders
		$orders_arr = $this->mod_dashboard->get_orders();

		$response = '<table class="table table-condensed">
	                    <thead>
	                        <tr>
	                            <th></th>
	                            <th><strong>Coin</strong></th>
	                            <th><strong>Entry Price</strong></th>
	                            <th><strong>Exit Price</strong></th>
	                            <th><strong>Quantity</strong></th>
	                            <th><strong>Profit Target</strong></th>
	                            <th><strong>Sell Price</strong></th>
	                            <th><strong>Trail Price</strong></th>
	                            <th class="text-center"><strong>P/L</strong></th>
	                            <th class="text-center"><strong>Status</strong></th>
	                            <th class="text-center"><strong>Actions</strong></th>
	                        </tr>
	                    </thead>
                        <tbody>';
		if (count($orders_arr) > 0) {
			foreach ($orders_arr as $key => $value) {

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

				$response .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>' . $value['symbol'] . '</td>
                            <td>' . num($value['purchased_price']) . '</td>
                            <td>';
				if ($value['market_value'] != "") {
					$response .= num($value['market_value']);
				}
				$response .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td>';
				if ($value['profit_type'] == 'percentage') {
					$response .= $value['sell_profit_percent'] . "%";
				} else {
					$response .= num($value['sell_profit_price']);
				}
				$response .= '</td>
                            <td>' . num($value['sell_price']) . '</td>
                            <td>';
				if ($value['trail_check'] == 'yes') {
					$response .= num($value['sell_trail_price']);
				} else {
					$response .= "-";
				}
				$response .= '</td>
                            <td class="center">';

				if ($value['status'] != 'new' && $value['status'] != 'error') {

					$market_value111 = num($value['market_value']);

				} else {

					$market_value111 = num($market_value);
				}

				$current_data = $market_value111 - num($value['purchased_price']);
				$market_data = ($current_data * 100 / $market_value111);

				$market_data = number_format((float) $market_data, 2, '.', '');

				if ($market_value111 > $value['purchased_price']) {
					$class = 'success';
				} else {
					$class = 'danger';
				}

				if ($value['profit_type'] == 'percentage') {

					$response .= '<span class="text-' . $class . '"><b>' . $market_data . '%</b></span>';
				} else {

					$response .= '<span class="text-' . $class . '"><b>' . $market_value111 . '</b></span>';
				}

				$response .= '</td>';

				if ($value['status'] == 'error') {
					$status_cls = "danger";
				} else {
					$status_cls = "success";
				}

				$response .= '<td class="center">
                            	<span class="label label-' . $status_cls . '">' . strtoupper($value['status']) . '</span>
                            	<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
                            		<i class="fa fa-refresh" aria-hidden="true"></i>
                            	</span>
                            </td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
				if ($value['status'] == 'new' || $value['status'] == 'error') {
					$response .= '<a href="' . SURL . 'admin/dashboard/edit-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
				}
				if ($value['status'] != 'FILLED') {
					$response .= '<a href="' . SURL . 'admin/dashboard/delete-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
				}
				$response .= '</div>
                            </td>
                            <td class="text-center">';
				if ($value['status'] == 'new') {
					$response .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';
				}
				$response .= '</td>
                            </tr>';
			}
		}
		$response .= '</tbody>
                    </table>';

		echo $response;
		exit;

	} //end autoload_market_data

	public function autoload_market_data2() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Get Orders
		$orders_arr = $this->mod_dashboard->get_orders();
		$filled_orders = array();
		$new_orders = array();
		$error_orders = array();
		$cancelled = array();

		foreach ($orders_arr as $key => $value) {
			if ($value['status'] == 'new') {
				$new_orders[] = $value;
			} elseif ($value['status'] == 'FILLED') {
				$filled_orders[] = $value;
			} elseif ($value['status'] == 'cancelled') {
				$cancelled[] = $value;
			} elseif ($value['status'] == 'error') {
				$error_orders[] = $value;
			}
		}
		$response = '<table class="table table-condensed">
	                    <thead>
	                        <tr>
	                            <th></th>
	                            <th><strong>Coin</strong></th>
	                            <th><strong>Entry Price</strong></th>
	                            <th><strong>Exit Price</strong></th>
	                            <th><strong>Quantity</strong></th>
	                            <th><strong>Profit Target</strong></th>
	                            <th><strong>Sell Price</strong></th>
	                            <th><strong>Trail Price</strong></th>
	                            <th class="text-center"><strong>P/L</strong></th>
	                            <th class="text-center"><strong>Status</strong></th>
	                            <th class="text-center"><strong>Actions</strong></th>
	                        </tr>
	                    </thead>
                        <tbody>';
		if (count($orders_arr) > 0) {
			foreach ($orders_arr as $key => $value) {

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

				$response .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>' . $value['symbol'] . '</td>
                            <td>' . num($value['purchased_price']) . '</td>
                            <td>';
				if ($value['market_value'] != "") {
					$response .= num($value['market_value']);
				}
				$response .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td>';
				if ($value['profit_type'] == 'percentage') {
					$response .= $value['sell_profit_percent'] . "%";
				} else {
					$response .= num($value['sell_profit_price']);
				}
				$response .= '</td>
                            <td>' . num($value['sell_price']) . '</td>
                            <td>';
				if ($value['trail_check'] == 'yes') {
					$response .= num($value['sell_trail_price']);
				} else {
					$response .= "-";
				}
				$response .= '</td>
                            <td class="center">';

				if ($value['status'] != 'new' && $value['status'] != 'error') {

					$market_value111 = num($value['market_value']);

				} else {

					$market_value111 = num($market_value);
				}

				$current_data = $market_value111 - num($value['purchased_price']);
				$market_data = ($current_data * 100 / $market_value111);

				$market_data = number_format((float) $market_data, 2, '.', '');

				if ($market_value111 > $value['purchased_price']) {
					$class = 'success';
				} else {
					$class = 'danger';
				}

				if ($value['status'] == 'submitted') {

					$response .= '<span class="text-' . $class . '"><b>-</b></span>';

				} elseif ($value['profit_type'] == 'percentage') {

					$response .= '<span class="text-' . $class . '"><b>' . $market_data . '%</b></span>';
				} else {

					$response .= '<span class="text-' . $class . '"><b>' . $market_value111 . '</b></span>';
				}

				$response .= '</td>';

				if ($value['status'] == 'error') {
					$status_cls = "danger";
				} else {
					$status_cls = "success";
				}

				$response .= '<td class="center">
                            	<span class="label label-' . $status_cls . '">' . strtoupper($value['status']) . '</span>
                            	<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
                            		<i class="fa fa-refresh" aria-hidden="true"></i>
                            	</span>
                            </td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
				if ($value['status'] == 'new' || $value['status'] == 'error') {
					$response .= '<a href="' . SURL . 'admin/dashboard/edit-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
				}
				if ($value['status'] != 'FILLED') {
					$response .= '<a href="' . SURL . 'admin/dashboard/delete-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
				}
				$response .= '</div>
                            </td>
                            <td class="text-center">';
				if ($value['status'] == 'new') {
					$response .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';
				}
				$response .= '</td>
                            </tr>';
			}
		}
		$response .= '</tbody>
                    </table>';

		$response1 = '<table class="table table-condensed">
	                    <thead>
	                        <tr>
	                            <th></th>
	                            <th><strong>Coin</strong></th>
	                            <th><strong>Entry Price</strong></th>
	                            <th><strong>Exit Price</strong></th>
	                            <th><strong>Quantity</strong></th>
	                            <th><strong>Profit Target</strong></th>
	                            <th><strong>Sell Price</strong></th>
	                            <th><strong>Trail Price</strong></th>
	                            <th class="text-center"><strong>P/L</strong></th>
	                            <th class="text-center"><strong>Status</strong></th>
	                            <th class="text-center"><strong>Actions</strong></th>
	                        </tr>
	                    </thead>
                        <tbody>';
		if (count($new_orders) > 0) {
			foreach ($new_orders as $key => $value) {

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

				$response1 .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>' . $value['symbol'] . '</td>
                            <td>' . num($value['purchased_price']) . '</td>
                            <td>';
				if ($value['market_value'] != "") {
					$response1 .= num($value['market_value']);
				}
				$response1 .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td>';
				if ($value['profit_type'] == 'percentage') {
					$response1 .= $value['sell_profit_percent'] . "%";
				} else {
					$response1 .= num($value['sell_profit_price']);
				}
				$response1 .= '</td>
                            <td>' . num($value['sell_price']) . '</td>
                            <td>';
				if ($value['trail_check'] == 'yes') {
					$response1 .= num($value['sell_trail_price']);
				} else {
					$response1 .= "-";
				}
				$response1 .= '</td>
                            <td class="center">';

				if ($value['status'] != 'new' && $value['status'] != 'error') {

					$market_value111 = num($value['market_value']);

				} else {

					$market_value111 = num($market_value);
				}

				$current_data = $market_value111 - num($value['purchased_price']);
				$market_data = ($current_data * 100 / $market_value111);

				$market_data = number_format((float) $market_data, 2, '.', '');

				if ($market_value111 > $value['purchased_price']) {
					$class = 'success';
				} else {
					$class = 'danger';
				}

				if ($value['status'] == 'submitted') {

					$response1 .= '<span class="text-' . $class . '"><b>-</b></span>';

				} elseif ($value['profit_type'] == 'percentage') {

					$response1 .= '<span class="text-' . $class . '"><b>' . $market_data . '%</b></span>';
				} else {

					$response1 .= '<span class="text-' . $class . '"><b>' . $market_value111 . '</b></span>';
				}

				$response1 .= '</td>';

				if ($value['status'] == 'error') {
					$status_cls = "danger";
				} else {
					$status_cls = "success";
				}

				$response1 .= '<td class="center">
                            	<span class="label label-' . $status_cls . '">' . strtoupper($value['status']) . '</span>
                            	<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
                            		<i class="fa fa-refresh" aria-hidden="true"></i>
                            	</span>
                            </td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
				if ($value['status'] == 'new' || $value['status'] == 'error') {
					$response1 .= '<a href="' . SURL . 'admin/dashboard/edit-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
				}
				if ($value['status'] != 'FILLED') {
					$response1 .= '<a href="' . SURL . 'admin/dashboard/delete-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
				}
				$response1 .= '</div>
                            </td>
                            <td class="text-center">';
				if ($value['status'] == 'new') {
					$response1 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';
				}
				$response1 .= '</td>
                            </tr>';
			}
		}
		$response1 .= '</tbody>
                    </table>';

		$response2 = '<table class="table table-condensed">
	                    <thead>
	                        <tr>
	                            <th></th>
	                            <th><strong>Coin</strong></th>
	                            <th><strong>Entry Price</strong></th>
	                            <th><strong>Exit Price</strong></th>
	                            <th><strong>Quantity</strong></th>
	                            <th><strong>Profit Target</strong></th>
	                            <th><strong>Sell Price</strong></th>
	                            <th><strong>Trail Price</strong></th>
	                            <th class="text-center"><strong>P/L</strong></th>
	                            <th class="text-center"><strong>Status</strong></th>
	                            <th class="text-center"><strong>Actions</strong></th>
	                        </tr>
	                    </thead>
                        <tbody>';
		if (count($filled_orders) > 0) {
			foreach ($filled_orders as $key => $value) {

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

				$response2 .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>' . $value['symbol'] . '</td>
                            <td>' . num($value['purchased_price']) . '</td>
                            <td>';
				if ($value['market_value'] != "") {
					$response2 .= num($value['market_value']);
				}
				$response2 .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td>';
				if ($value['profit_type'] == 'percentage') {
					$response2 .= $value['sell_profit_percent'] . "%";
				} else {
					$response2 .= num($value['sell_profit_price']);
				}
				$response2 .= '</td>
                            <td>' . num($value['sell_price']) . '</td>
                            <td>';
				if ($value['trail_check'] == 'yes') {
					$response2 .= num($value['sell_trail_price']);
				} else {
					$response2 .= "-";
				}
				$response2 .= '</td>
                            <td class="center">';

				if ($value['status'] != 'new' && $value['status'] != 'error') {

					$market_value111 = num($value['market_value']);

				} else {

					$market_value111 = num($market_value);
				}

				$current_data = $market_value111 - num($value['purchased_price']);
				$market_data = ($current_data * 100 / $market_value111);

				$market_data = number_format((float) $market_data, 2, '.', '');

				if ($market_value111 > $value['purchased_price']) {
					$class = 'success';
				} else {
					$class = 'danger';
				}

				if ($value['status'] == 'submitted') {

					$response2 .= '<span class="text-' . $class . '"><b>-</b></span>';

				} elseif ($value['profit_type'] == 'percentage') {

					$response2 .= '<span class="text-' . $class . '"><b>' . $market_data . '%</b></span>';
				} else {

					$response2 .= '<span class="text-' . $class . '"><b>' . $market_value111 . '</b></span>';
				}

				$response2 .= '</td>';

				if ($value['status'] == 'error') {
					$status_cls = "danger";
				} else {
					$status_cls = "success";
				}

				$response2 .= '<td class="center">
                            	<span class="label label-' . $status_cls . '">' . strtoupper($value['status']) . '</span>
                            	<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
                            		<i class="fa fa-refresh" aria-hidden="true"></i>
                            	</span>
                            </td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
				if ($value['status'] == 'new' || $value['status'] == 'error') {
					$response2 .= '<a href="' . SURL . 'admin/dashboard/edit-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
				}
				if ($value['status'] != 'FILLED') {
					$response2 .= '<a href="' . SURL . 'admin/dashboard/delete-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
				}
				$response2 .= '</div>
                            </td>
                            <td class="text-center">';
				if ($value['status'] == 'new') {
					$response2 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';
				}
				$response2 .= '</td>
                            </tr>';
			}
		}
		$response2 .= '</tbody>
                    </table>';

		$response3 = '<table class="table table-condensed">
	                    <thead>
	                        <tr>
	                            <th></th>
	                            <th><strong>Coin</strong></th>
	                            <th><strong>Entry Price</strong></th>
	                            <th><strong>Exit Price</strong></th>
	                            <th><strong>Quantity</strong></th>
	                            <th><strong>Profit Target</strong></th>
	                            <th><strong>Sell Price</strong></th>
	                            <th><strong>Trail Price</strong></th>
	                            <th class="text-center"><strong>P/L</strong></th>
	                            <th class="text-center"><strong>Status</strong></th>
	                            <th class="text-center"><strong>Actions</strong></th>
	                        </tr>
	                    </thead>
                        <tbody>';
		if (count($cancelled) > 0) {
			foreach ($cancelled as $key => $value) {

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

				$response3 .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>' . $value['symbol'] . '</td>
                            <td>' . num($value['purchased_price']) . '</td>
                            <td>';
				if ($value['market_value'] != "") {
					$response3 .= num($value['market_value']);
				}
				$response3 .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td>';
				if ($value['profit_type'] == 'percentage') {
					$response3 .= $value['sell_profit_percent'] . "%";
				} else {
					$response3 .= num($value['sell_profit_price']);
				}
				$response3 .= '</td>
                            <td>' . num($value['sell_price']) . '</td>
                            <td>';
				if ($value['trail_check'] == 'yes') {
					$response3 .= num($value['sell_trail_price']);
				} else {
					$response3 .= "-";
				}
				$response3 .= '</td>
                            <td class="center">';

				if ($value['status'] != 'new' && $value['status'] != 'error') {

					$market_value111 = num($value['market_value']);

				} else {

					$market_value111 = num($market_value);
				}

				$current_data = $market_value111 - num($value['purchased_price']);
				$market_data = ($current_data * 100 / $market_value111);

				$market_data = number_format((float) $market_data, 2, '.', '');

				if ($market_value111 > $value['purchased_price']) {
					$class = 'success';
				} else {
					$class = 'danger';
				}

				if ($value['status'] == 'submitted') {

					$response3 .= '<span class="text-' . $class . '"><b>-</b></span>';

				} elseif ($value['profit_type'] == 'percentage') {

					$response3 .= '<span class="text-' . $class . '"><b>' . $market_data . '%</b></span>';
				} else {

					$response3 .= '<span class="text-' . $class . '"><b>' . $market_value111 . '</b></span>';
				}

				$response3 .= '</td>';

				if ($value['status'] == 'error') {
					$status_cls = "danger";
				} else {
					$status_cls = "success";
				}

				$response3 .= '<td class="center">
                            	<span class="label label-' . $status_cls . '">' . strtoupper($value['status']) . '</span>
                            	<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
                            		<i class="fa fa-refresh" aria-hidden="true"></i>
                            	</span>
                            </td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
				if ($value['status'] == 'new' || $value['status'] == 'error') {
					$response3 .= '<a href="' . SURL . 'admin/dashboard/edit-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
				}
				if ($value['status'] != 'FILLED') {
					$response3 .= '<a href="' . SURL . 'admin/dashboard/delete-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
				}
				$response3 .= '</div>
                            </td>
                            <td class="text-center">';
				if ($value['status'] == 'new') {
					$response3 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';
				}
				$response3 .= '</td>
                            </tr>';
			}
		}
		$response3 .= '</tbody>
                    </table>';

		$response4 = '<table class="table table-condensed">
	                    <thead>
	                        <tr>
	                            <th></th>
	                            <th><strong>Coin</strong></th>
	                            <th><strong>Entry Price</strong></th>
	                            <th><strong>Exit Price</strong></th>
	                            <th><strong>Quantity</strong></th>
	                            <th><strong>Profit Target</strong></th>
	                            <th><strong>Sell Price</strong></th>
	                            <th><strong>Trail Price</strong></th>
	                            <th class="text-center"><strong>P/L</strong></th>
	                            <th class="text-center"><strong>Status</strong></th>
	                            <th class="text-center"><strong>Actions</strong></th>
	                        </tr>
	                    </thead>
                        <tbody>';
		if (count($error_orders) > 0) {
			foreach ($error_orders as $key => $value) {

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

				$response4 .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>' . $value['symbol'] . '</td>
                            <td>' . num($value['purchased_price']) . '</td>
                            <td>';
				if ($value['market_value'] != "") {
					$response4 .= num($value['market_value']);
				}
				$response4 .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td>';
				if ($value['profit_type'] == 'percentage') {
					$response4 .= $value['sell_profit_percent'] . "%";
				} else {
					$response4 .= num($value['sell_profit_price']);
				}
				$response4 .= '</td>
                            <td>' . num($value['sell_price']) . '</td>
                            <td>';
				if ($value['trail_check'] == 'yes') {
					$response4 .= num($value['sell_trail_price']);
				} else {
					$response4 .= "-";
				}
				$response4 .= '</td>
                            <td class="center">';

				if ($value['status'] != 'new' && $value['status'] != 'error') {

					$market_value111 = num($value['market_value']);

				} else {

					$market_value111 = num($market_value);
				}

				$current_data = $market_value111 - num($value['purchased_price']);
				$market_data = ($current_data * 100 / $market_value111);

				$market_data = number_format((float) $market_data, 2, '.', '');

				if ($market_value111 > $value['purchased_price']) {
					$class = 'success';
				} else {
					$class = 'danger';
				}

				if ($value['status'] == 'submitted') {

					$response4 .= '<span class="text-' . $class . '"><b>-</b></span>';

				} elseif ($value['profit_type'] == 'percentage') {

					$response4 .= '<span class="text-' . $class . '"><b>' . $market_data . '%</b></span>';
				} else {

					$response4 .= '<span class="text-' . $class . '"><b>' . $market_value111 . '</b></span>';
				}

				$response4 .= '</td>';

				if ($value['status'] == 'error') {
					$status_cls = "danger";
				} else {
					$status_cls = "success";
				}

				$response4 .= '<td class="center">
                            	<span class="label label-' . $status_cls . '">' . strtoupper($value['status']) . '</span>
                            	<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
                            		<i class="fa fa-refresh" aria-hidden="true"></i>
                            	</span>
                            </td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
				if ($value['status'] == 'new' || $value['status'] == 'error') {
					$response4 .= '<a href="' . SURL . 'admin/dashboard/edit-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
				}
				if ($value['status'] != 'FILLED') {
					$response4 .= '<a href="' . SURL . 'admin/dashboard/delete-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
				}
				$response4 .= '</div>
                            </td>
                            <td class="text-center">';
				if ($value['status'] == 'new') {
					$response4 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';
				}
				$response4 .= '</td>
                            </tr>';
			}
		}
		$response4 .= '</tbody>
                    </table>';

		$count_new_arr = count($new_orders);
		$count_filled_arr = count($filled_orders);
		$count_cancelled_arr = count($cancelled);
		$count_error_arr = count($error_orders);
		$count_orders_arr = count($orders_arr);

		echo $response . '|' . $response1 . '|' . $response2 . '|' . $response3 . '|' . $response4 . "|" . $count_new_arr . "|" . $count_filled_arr . "|" . $count_cancelled_arr . "|" . $count_error_arr . "|" . $count_orders_arr;
		exit;

	} //end autoload_market_data

	public function autoload_market_buy_data() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Get Buy Orders
		$return_data = $this->mod_dashboard->get_buy_orders();

		$orders_arr = $return_data['fullarray'];
		$total_buy_amount = $return_data['total_buy_amount'];

		$response = '<table class="table table-condensed">
	                    <thead>
	                        <tr>
	                            <th></th>
	                            <th><strong>Coin</strong></th>
	                            <th><strong>Price</strong></th>
	                            <th><strong>Trail Price</strong></th>
	                            <th><strong>Quantity</strong></th>
	                            <th class="text-center"><strong>P/L</strong></th>
	                            <th class="text-center"><strong>Market(%)</strong></th>
	                            <th class="text-center"><strong>Status</strong></th>
	                            <th class="text-center"><strong>Profit(%)</strong></th>
	                            <th class="text-center"><strong>Actions</strong></th>
	                        </tr>
	                    </thead>
                        <tbody>';
		if (count($orders_arr) > 0) {
			foreach ($orders_arr as $key => $value) {

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

				if ($value['status'] != 'new') {
					$market_value333 = num($value['market_value']);
				} else {
					$market_value333 = num($market_value);
				}

				if ($value['status'] == 'new') {
					$current_order_price = num($value['price']);
				} else {
					$current_order_price = num($value['market_value']);
				}

				$current_data = $market_value333 - $current_order_price;
				$market_data = ($current_data * 100 / $market_value333);

				$market_data = number_format((float) $market_data, 2, '.', '');

				if ($market_value333 > $current_order_price) {
					$class = 'success';
				} else {
					$class = 'danger';
				}

				$response .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>' . $value['symbol'] . '</td>
                            <td>' . num($value['price']) . '</td>
                            <td>';
				if ($value['trail_check'] == 'yes') {
					$response .= num($value['buy_trail_price']);
				} else {
					$response .= "-";
				}
				$response .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td class="center"><b>' . num($market_value333) . '</b></td>';

				if ($value['is_sell_order'] != 'sold' && $value['is_sell_order'] != 'yes') {

					$response .= '<td class="center"><span class="text-' . $class . '"><b>' . $market_data . '%</b></span></td>';

				} else {

					$response .= '<td class="center"><span class="text-default"><b>-</b></span></td>';
				}

				$response .= '<td class="center">';

				$response .= '<span class="label label-success">' . ucfirst($value['status']) . '</span>
                            			  <span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
		                            		<i class="fa fa-refresh" aria-hidden="true"></i>
		                            	  </span>';

				$response .= '</td>

                            <td class="center">';

				if ($value['market_sold_price'] != "") {

					$market_sold_price = num($value['market_sold_price']);

					$current_data2222 = $market_sold_price - $current_order_price;
					$profit_data = ($current_data2222 * 100 / $market_sold_price);

					$profit_data = number_format((float) $profit_data, 2, '.', '');

					if ($market_sold_price > $current_order_price) {
						$class222 = 'success';
					} else {
						$class222 = 'danger';
					}

					$response .= '<span class="text-' . $class222 . '">
		                        				<b>' . $profit_data . '%</b>
		                        			  </span>';
				} else {

					$response .= '<span class="text-default">
		                        					<b>-</b>
		                        			   </span>';
				}

				$response .= '</td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
				if ($value['status'] == 'new') {
					$response .= '<a href="' . SURL . 'admin/dashboard/edit-buy-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
				}
				if ($value['status'] != 'FILLED') {
					$response .= '<a href="' . SURL . 'admin/dashboard/delete-buy-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
				}

				if ($value['status'] == 'FILLED') {

					if ($value['is_sell_order'] == 'yes') {
						$response .= '<button class="btn btn-info">Submited For Sell</button>';
					} elseif ($value['is_sell_order'] == 'sold') {
						$response .= '<button class="btn btn-success">Sold</button>';
					} else {
						$response .= '<a href="' . SURL . 'admin/dashboard/add-order/' . $value['_id'] . '" class="btn btn-warning" target="_blank">Sell Now</a>';
					}

				}

				$response .= '</div>
                            </td>



                            <td class="text-center">';
				if ($value['status'] == 'new') {

					$response .= '<button class="btn btn-danger buy_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Buy Now</button>';
				}
				$response .= '</td>
                            </tr>';
			}
		}
		$response .= '</tbody>
                    </table>';

		echo $response;
		exit;

	} //end autoload_market_buy_data

	public function autoload_market_buy_data2() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Get Buy Orders
		$return_data = $this->mod_dashboard->get_buy_orders();

		$orders_arr = $return_data['fullarray'];
		$total_buy_amount = $return_data['total_buy_amount'];
		$filled_orders = array();
		$new_orders = array();
		$error_orders = array();
		$cancelled = array();
		$submitted = array();
		$open_trades = array();
		$sold_trades = array();
		foreach ($orders_arr as $key => $value) {
			if ($value['status'] == 'new') {
				$new_orders[] = $value;
			} elseif ($value['status'] == 'FILLED') {
				$filled_orders[] = $value;
				if ($value['is_sell_order'] == 'yes') {
					$open_trades[] = $value;
				}
				if ($value['is_sell_order'] == 'sold') {
					$sold_trades[] = $value;
				}
			} elseif ($value['status'] == 'canceled') {
				$cancelled[] = $value;
			} elseif ($value['status'] == 'error') {
				$error_orders[] = $value;
			} elseif ($value['status'] == 'submitted') {
				$submitted[] = $value;
				$open_trades[] = $value;
			}
		}

		$response = '<table class="table table-condensed">
	                    <thead>
	                        <tr>
	                            <th></th>
	                            <th><strong>Coin</strong></th>
	                            <th><strong>Price</strong></th>
	                            <th><strong>Trail Price</strong></th>
	                            <th><strong>Quantity</strong></th>
	                            <th class="text-center"><strong>P/L</strong></th>
	                            <th class="text-center"><strong>Market(%)</strong></th>
	                            <th class="text-center"><strong>Status</strong></th>
	                            <th class="text-center"><strong>Profit(%)</strong></th>
	                            <th class="text-center"><strong>Actions</strong></th>
	                        </tr>
	                    </thead>
                        <tbody>';
		if (count($orders_arr) > 0) {
			foreach ($orders_arr as $key => $value) {

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

				if ($value['status'] != 'new' && $value['status'] != 'error') {
					$market_value333 = num($value['market_value']);
				} else {
					$market_value333 = num($market_value);
				}

				if ($value['status'] == 'new') {
					$current_order_price = num($value['price']);
				} else {
					$current_order_price = num($value['market_value']);
				}

				$current_data = $market_value333 - $current_order_price;
				$market_data = ($current_data * 100 / $market_value333);

				$market_data = number_format((float) $market_data, 2, '.', '');

				if ($market_value333 > $current_order_price) {
					$class = 'success';
				} else {
					$class = 'danger';
				}

				$response .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>' . $value['symbol'] . '</td>
                            <td>' . num($value['price']) . '</td>
                            <td>';
				if ($value['trail_check'] == 'yes') {
					$response .= num($value['buy_trail_price']);
				} else {
					$response .= "-";
				}
				$response .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td class="center"><b>' . num($market_value333) . '</b></td>';

				if ($value['is_sell_order'] != 'sold' && $value['is_sell_order'] != 'yes') {

					$response .= '<td class="center"><span class="text-' . $class . '"><b>' . $market_data . '%</b></span></td>';

				} else {

					$response .= '<td class="center"><span class="text-default"><b>-</b></span></td>';
				}

				$response .= '<td class="center">';

				if ($value['status'] == 'FILLED' && $value['is_sell_order'] == 'yes') {

					$response .= '<span class="label label-info">SUBMITTED FOR SELL</span>';

				} else {

					if ($value['status'] == 'error') {
						$status_cls = "danger";
					} else {
						$status_cls = "success";
					}

					$response .= '<span class="label label-' . $status_cls . '">' . strtoupper($value['status']) . '</span>';
				}

				$response .= '<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
		                            		<i class="fa fa-refresh" aria-hidden="true"></i>
		                            	  </span>';

				$response .= '</td>

                            <td class="center">';

				if ($value['market_sold_price'] != "") {

					$market_sold_price = num($value['market_sold_price']);

					$current_data2222 = $market_sold_price - $current_order_price;
					$profit_data = ($current_data2222 * 100 / $market_sold_price);

					$profit_data = number_format((float) $profit_data, 2, '.', '');

					if ($market_sold_price > $current_order_price) {
						$class222 = 'success';
					} else {
						$class222 = 'danger';
					}

					$response .= '<span class="text-' . $class222 . '">
		                        				<b>' . $profit_data . '%</b>
		                        			  </span>';
				} else {

					if ($value['status'] == 'FILLED') {

						if ($value['is_sell_order'] == 'yes') {

							$current_data = num($market_value) - num($value['market_value']);
							$market_data = ($current_data * 100 / $market_value);

							$market_data = number_format((float) $market_data, 2, '.', '');

							if ($market_value > $value['market_value']) {
								$class = 'success';
							} else {
								$class = 'danger';
							}

							$response .= '<span class="text-' . $class . '"><b>' . $market_data . '%</b></span>';

						} else {

							$response .= '<span class="text-default"><b>-</b></span>';
						}

					} else {

						$response .= '<span class="text-default"><b>-</b></span>';

					}

				}

				$response .= '</td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
				if ($value['status'] == 'new' || $value['status'] == 'error') {
					$response .= '<a href="' . SURL . 'admin/dashboard/edit-buy-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
				}
				if ($value['status'] != 'FILLED') {
					$response .= '<a href="' . SURL . 'admin/dashboard/delete-buy-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
				}

				if ($value['status'] == 'FILLED') {

					if ($value['is_sell_order'] == 'yes') {

						$response .= '<a href="' . SURL . 'admin/dashboard/edit-order/' . $value['sell_order_id'] . '" class="btn btn-inverse" target="_blank"><i class="fa fa-pencil"></i></a>';
						$response .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';

					} elseif ($value['is_sell_order'] == 'sold') {
						$response .= '<button class="btn btn-success">Sold</button>';
					} else {
						$response .= '<a href="' . SURL . 'admin/dashboard/add-order/' . $value['_id'] . '" class="btn btn-warning" target="_blank">Set For Sell</a>';
						$response .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';
					}

				}

				$response .= '</div>
                            </td>



                            <td class="text-center">';
				if ($value['status'] == 'new') {

					$response .= '<button class="btn btn-danger buy_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Buy Now</button>';
				}
				$response .= '</td>
                            </tr>';
			}
		}
		$response .= '</tbody>
                    </table>';

		$response1 = '<table class="table table-condensed">
                        <thead>
                            <tr>
                                <th></th>
                                <th><strong>Coin</strong></th>
                                <th><strong>Price</strong></th>
                                <th><strong>Trail Price</strong></th>
                                <th><strong>Quantity</strong></th>
                                <th class="text-center"><strong>P/L</strong></th>
                                <th class="text-center"><strong>Market(%)</strong></th>
                                <th class="text-center"><strong>Status</strong></th>
                                <th class="text-center"><strong>Profit(%)</strong></th>
                                <th class="text-center"><strong>Actions</strong></th>
                            </tr>
                        </thead>
                        <tbody>';
		if (count($new_orders) > 0) {
			foreach ($new_orders as $key => $value) {

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

				if ($value['status'] != 'new') {
					$market_value333 = num($value['market_value']);
				} else {
					$market_value333 = num($market_value);
				}

				if ($value['status'] == 'new') {
					$current_order_price = num($value['price']);
				} else {
					$current_order_price = num($value['market_value']);
				}

				$current_data = $market_value333 - $current_order_price;
				$market_data = ($current_data * 100 / $market_value333);

				$market_data = number_format((float) $market_data, 2, '.', '');

				if ($market_value333 > $current_order_price) {
					$class = 'success';
				} else {
					$class = 'danger';
				}

				$response1 .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>' . $value['symbol'] . '</td>
                            <td>' . num($value['price']) . '</td>
                            <td>';
				if ($value['trail_check'] == 'yes') {
					$response1 .= num($value['buy_trail_price']);
				} else {
					$response1 .= "-";
				}
				$response1 .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td class="center"><b>' . num($market_value333) . '</b></td>';

				if ($value['is_sell_order'] != 'sold' && $value['is_sell_order'] != 'yes') {

					$response1 .= '<td class="center"><span class="text-' . $class . '"><b>' . $market_data . '%</b></span></td>';

				} else {

					$response1 .= '<td class="center"><span class="text-default"><b>-</b></span></td>';
				}

				$response1 .= '<td class="center">';

				if ($value['status'] == 'FILLED' && $value['is_sell_order'] == 'yes') {

					$response1 .= '<span class="label label-info">SUBMITTED FOR SELL</span>';

				} else {

					$response1 .= '<span class="label label-success">' . strtoupper($value['status']) . '</span>';
				}

				$response1 .= '<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
                                            <i class="fa fa-refresh" aria-hidden="true"></i>
                                          </span>';

				$response1 .= '</td>

                            <td class="center">';

				if ($value['market_sold_price'] != "") {

					$market_sold_price = num($value['market_sold_price']);

					$current_data2222 = $market_sold_price - $current_order_price;
					$profit_data = ($current_data2222 * 100 / $market_sold_price);

					$profit_data = number_format((float) $profit_data, 2, '.', '');

					if ($market_sold_price > $current_order_price) {
						$class222 = 'success';
					} else {
						$class222 = 'danger';
					}

					$response1 .= '<span class="text-' . $class222 . '">
                                                <b>' . $profit_data . '%</b>
                                              </span>';
				} else {

					$response1 .= '<span class="text-default">
                                                    <b>-</b>
                                               </span>';
				}

				$response1 .= '</td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
				if ($value['status'] == 'new') {
					$response1 .= '<a href="' . SURL . 'admin/dashboard/edit-buy-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
				}
				if ($value['status'] != 'FILLED') {
					$response1 .= '<a href="' . SURL . 'admin/dashboard/delete-buy-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
				}

				if ($value['status'] == 'FILLED') {

					if ($value['is_sell_order'] == 'yes') {

						$response1 .= '<a href="' . SURL . 'admin/dashboard/edit-order/' . $value['sell_order_id'] . '" class="btn btn-inverse" target="_blank"><i class="fa fa-pencil"></i></a>';
						$response1 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';

					} elseif ($value['is_sell_order'] == 'sold') {
						$response1 .= '<button class="btn btn-success">Sold</button>';
					} else {
						$response1 .= '<a href="' . SURL . 'admin/dashboard/add-order/' . $value['_id'] . '" class="btn btn-warning" target="_blank">Set For Sell</a>';
						$response1 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';
					}

				}

				$response1 .= '</div>
                            </td>



                            <td class="text-center">';
				if ($value['status'] == 'new') {

					$response1 .= '<button class="btn btn-danger buy_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Buy Now</button>';
				}
				$response1 .= '</td>
                            </tr>';
			}
		}
		$response1 .= '</tbody>
                    </table>';

		$response2 = '<table class="table table-condensed">
                        <thead>
                            <tr>
                                <th></th>
                                <th><strong>Coin</strong></th>
                                <th><strong>Price</strong></th>
                                <th><strong>Trail Price</strong></th>
                                <th><strong>Quantity</strong></th>
                                <th class="text-center"><strong>P/L</strong></th>
                                <th class="text-center"><strong>Market(%)</strong></th>
                                <th class="text-center"><strong>Status</strong></th>
                                <th class="text-center"><strong>Profit(%)</strong></th>
                                <th class="text-center"><strong>Actions</strong></th>
                            </tr>
                        </thead>
                        <tbody>';
		if (count($filled_orders) > 0) {
			foreach ($filled_orders as $key => $value) {

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

				if ($value['status'] != 'new') {
					$market_value333 = num($value['market_value']);
				} else {
					$market_value333 = num($market_value);
				}

				if ($value['status'] == 'new') {
					$current_order_price = num($value['price']);
				} else {
					$current_order_price = num($value['market_value']);
				}

				$current_data = $market_value333 - $current_order_price;
				$market_data = ($current_data * 100 / $market_value333);

				$market_data = number_format((float) $market_data, 2, '.', '');

				if ($market_value333 > $current_order_price) {
					$class = 'success';
				} else {
					$class = 'danger';
				}

				$response2 .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>' . $value['symbol'] . '</td>
                            <td>' . num($value['price']) . '</td>
                            <td>';
				if ($value['trail_check'] == 'yes') {
					$response2 .= num($value['buy_trail_price']);
				} else {
					$response2 .= "-";
				}
				$response2 .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td class="center"><b>' . num($market_value333) . '</b></td>';

				if ($value['is_sell_order'] != 'sold' && $value['is_sell_order'] != 'yes') {

					$response2 .= '<td class="center"><span class="text-' . $class . '"><b>' . $market_data . '%</b></span></td>';

				} else {

					$response2 .= '<td class="center"><span class="text-default"><b>-</b></span></td>';
				}

				$response2 .= '<td class="center">';

				if ($value['status'] == 'FILLED' && $value['is_sell_order'] == 'yes') {

					$response2 .= '<span class="label label-info">SUBMITTED FOR SELL</span>';

				} else {

					$response2 .= '<span class="label label-success">' . strtoupper($value['status']) . '</span>';
				}

				$response2 .= '<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
                                            <i class="fa fa-refresh" aria-hidden="true"></i>
                                          </span>';

				$response2 .= '</td>

                            <td class="center">';

				if ($value['market_sold_price'] != "") {

					$market_sold_price = num($value['market_sold_price']);

					$current_data2222 = $market_sold_price - $current_order_price;
					$profit_data = ($current_data2222 * 100 / $market_sold_price);

					$profit_data = number_format((float) $profit_data, 2, '.', '');

					if ($market_sold_price > $current_order_price) {
						$class222 = 'success';
					} else {
						$class222 = 'danger';
					}

					$response2 .= '<span class="text-' . $class222 . '">
                                                <b>' . $profit_data . '%</b>
                                              </span>';
				} else {

					if ($value['status'] == 'FILLED') {

						if ($value['is_sell_order'] == 'yes') {

							$current_data = num($market_value) - num($value['market_value']);
							$market_data = ($current_data * 100 / $market_value);

							$market_data = number_format((float) $market_data, 2, '.', '');

							if ($market_value > $value['market_value']) {
								$class = 'success';
							} else {
								$class = 'danger';
							}

							$response2 .= '<span class="text-' . $class . '"><b>' . $market_data . '%</b></span>';

						} else {

							$response2 .= '<span class="text-default"><b>-</b></span>';
						}

					} else {

						$response2 .= '<span class="text-default"><b>-</b></span>';

					}
				}

				$response2 .= '</td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
				if ($value['status'] == 'new') {
					$response2 .= '<a href="' . SURL . 'admin/dashboard/edit-buy-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
				}
				if ($value['status'] != 'FILLED') {
					$response2 .= '<a href="' . SURL . 'admin/dashboard/delete-buy-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
				}

				if ($value['status'] == 'FILLED') {

					if ($value['is_sell_order'] == 'yes') {

						$response2 .= '<a href="' . SURL . 'admin/dashboard/edit-order/' . $value['sell_order_id'] . '" class="btn btn-inverse" target="_blank"><i class="fa fa-pencil"></i></a>';
						$response2 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';

					} elseif ($value['is_sell_order'] == 'sold') {
						$response2 .= '<button class="btn btn-success">Sold</button>';
					} else {
						$response2 .= '<a href="' . SURL . 'admin/dashboard/add-order/' . $value['_id'] . '" class="btn btn-warning" target="_blank">Set For Sell</a>';
						$response2 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';
					}

				}

				$response2 .= '</div>
                            </td>



                            <td class="text-center">';
				if ($value['status'] == 'new') {

					$response2 .= '<button class="btn btn-danger buy_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Buy Now</button>';
				}
				$response2 .= '</td>
                            </tr>';
			}
		}
		$response2 .= '</tbody>
                    </table>';

		$response3 = '<table class="table table-condensed">
                        <thead>
                            <tr>
                                <th></th>
                                <th><strong>Coin</strong></th>
                                <th><strong>Price</strong></th>
                                <th><strong>Trail Price</strong></th>
                                <th><strong>Quantity</strong></th>
                                <th class="text-center"><strong>P/L</strong></th>
                                <th class="text-center"><strong>Market(%)</strong></th>
                                <th class="text-center"><strong>Status</strong></th>
                                <th class="text-center"><strong>Profit(%)</strong></th>
                                <th class="text-center"><strong>Actions</strong></th>
                            </tr>
                        </thead>
                        <tbody>';
		if (count($cancelled) > 0) {
			foreach ($cancelled as $key => $value) {

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

				if ($value['status'] != 'new') {
					$market_value333 = num($value['market_value']);
				} else {
					$market_value333 = num($market_value);
				}

				if ($value['status'] == 'new') {
					$current_order_price = num($value['price']);
				} else {
					$current_order_price = num($value['market_value']);
				}

				$current_data = $market_value333 - $current_order_price;
				$market_data = ($current_data * 100 / $market_value333);

				$market_data = number_format((float) $market_data, 2, '.', '');

				if ($market_value333 > $current_order_price) {
					$class = 'success';
				} else {
					$class = 'danger';
				}

				$response3 .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>' . $value['symbol'] . '</td>
                            <td>' . num($value['price']) . '</td>
                            <td>';
				if ($value['trail_check'] == 'yes') {
					$response3 .= num($value['buy_trail_price']);
				} else {
					$response3 .= "-";
				}
				$response3 .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td class="center"><b>' . num($market_value333) . '</b></td>';

				if ($value['is_sell_order'] != 'sold' && $value['is_sell_order'] != 'yes') {

					$response3 .= '<td class="center"><span class="text-' . $class . '"><b>' . $market_data . '%</b></span></td>';

				} else {

					$response3 .= '<td class="center"><span class="text-default"><b>-</b></span></td>';
				}

				$response3 .= '<td class="center">';

				if ($value['status'] == 'FILLED' && $value['is_sell_order'] == 'yes') {

					$response3 .= '<span class="label label-info">SUBMITTED FOR SELL</span>';

				} else {

					$response3 .= '<span class="label label-success">' . strtoupper($value['status']) . '</span>';
				}

				$response3 .= '<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
                                            <i class="fa fa-refresh" aria-hidden="true"></i>
                                          </span>';

				$response3 .= '</td>

                            <td class="center">';

				if ($value['market_sold_price'] != "") {

					$market_sold_price = num($value['market_sold_price']);

					$current_data2222 = $market_sold_price - $current_order_price;
					$profit_data = ($current_data2222 * 100 / $market_sold_price);

					$profit_data = number_format((float) $profit_data, 2, '.', '');

					if ($market_sold_price > $current_order_price) {
						$class222 = 'success';
					} else {
						$class222 = 'danger';
					}

					$response3 .= '<span class="text-' . $class222 . '">
                                                <b>' . $profit_data . '%</b>
                                              </span>';
				} else {

					$response3 .= '<span class="text-default">
                                                    <b>-</b>
                                               </span>';
				}

				$response3 .= '</td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
				if ($value['status'] == 'new') {
					$response3 .= '<a href="' . SURL . 'admin/dashboard/edit-buy-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
				}
				if ($value['status'] != 'FILLED') {
					$response3 .= '<a href="' . SURL . 'admin/dashboard/delete-buy-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
				}

				if ($value['status'] == 'FILLED') {

					if ($value['is_sell_order'] == 'yes') {

						$response3 .= '<a href="' . SURL . 'admin/dashboard/edit-order/' . $value['sell_order_id'] . '" class="btn btn-inverse" target="_blank"><i class="fa fa-pencil"></i></a>';

					} elseif ($value['is_sell_order'] == 'sold') {
						$response3 .= '<button class="btn btn-success">Sold</button>';
					} else {
						$response3 .= '<a href="' . SURL . 'admin/dashboard/add-order/' . $value['_id'] . '" class="btn btn-warning" target="_blank">Set For Sell</a>';
						$response2 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';
					}

				}

				$response3 .= '</div>
                            </td>



                            <td class="text-center">';
				if ($value['status'] == 'new') {

					$response3 .= '<button class="btn btn-danger buy_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Buy Now</button>';
				}
				$response3 .= '</td>
                            </tr>';
			}
		}
		$response3 .= '</tbody>
                    </table>';

		$response4 = '<table class="table table-condensed">
                        <thead>
                            <tr>
                                <th></th>
                                <th><strong>Coin</strong></th>
                                <th><strong>Price</strong></th>
                                <th><strong>Trail Price</strong></th>
                                <th><strong>Quantity</strong></th>
                                <th class="text-center"><strong>P/L</strong></th>
                                <th class="text-center"><strong>Market(%)</strong></th>
                                <th class="text-center"><strong>Status</strong></th>
                                <th class="text-center"><strong>Profit(%)</strong></th>
                                <th class="text-center"><strong>Actions</strong></th>
                            </tr>
                        </thead>
                        <tbody>';
		if (count($error_orders) > 0) {
			foreach ($error_orders as $key => $value) {

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

				if ($value['status'] != 'new' && $value['status'] != 'error') {
					$market_value333 = num($value['market_value']);
				} else {
					$market_value333 = num($market_value);
				}

				if ($value['status'] == 'new') {
					$current_order_price = num($value['price']);
				} else {
					$current_order_price = num($value['market_value']);
				}

				$current_data = $market_value333 - $current_order_price;
				$market_data = ($current_data * 100 / $market_value333);

				$market_data = number_format((float) $market_data, 2, '.', '');

				if ($market_value333 > $current_order_price) {
					$class = 'success';
				} else {
					$class = 'danger';
				}

				$response4 .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>' . $value['symbol'] . '</td>
                            <td>' . num($value['price']) . '</td>
                            <td>';
				if ($value['trail_check'] == 'yes') {
					$response4 .= num($value['buy_trail_price']);
				} else {
					$response4 .= "-";
				}
				$response4 .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td class="center"><b>' . num($market_value333) . '</b></td>';

				if ($value['is_sell_order'] != 'sold' && $value['is_sell_order'] != 'yes') {

					$response4 .= '<td class="center"><span class="text-' . $class . '"><b>' . $market_data . '%</b></span></td>';

				} else {

					$response4 .= '<td class="center"><span class="text-default"><b>-</b></span></td>';
				}

				$response4 .= '<td class="center">';

				if ($value['status'] == 'FILLED' && $value['is_sell_order'] == 'yes') {

					$response4 .= '<span class="label label-info">SUBMITTED FOR SELL</span>';

				} else {

					if ($value['status'] == 'error') {
						$status_cls = "danger";
					} else {
						$status_cls = "success";
					}

					$response4 .= '<span class="label label-' . $status_cls . '">' . strtoupper($value['status']) . '</span>';
				}

				$response4 .= '<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
                                            <i class="fa fa-refresh" aria-hidden="true"></i>
                                          </span>';

				$response4 .= '</td>

                            <td class="center">';

				if ($value['market_sold_price'] != "") {

					$market_sold_price = num($value['market_sold_price']);

					$current_data2222 = $market_sold_price - $current_order_price;
					$profit_data = ($current_data2222 * 100 / $market_sold_price);

					$profit_data = number_format((float) $profit_data, 2, '.', '');

					if ($market_sold_price > $current_order_price) {
						$class222 = 'success';
					} else {
						$class222 = 'danger';
					}

					$response4 .= '<span class="text-' . $class222 . '">
                                                <b>' . $profit_data . '%</b>
                                              </span>';
				} else {

					$response4 .= '<span class="text-default">
                                                    <b>-</b>
                                               </span>';
				}

				$response4 .= '</td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
				if ($value['status'] == 'new' || $value['status'] == 'error') {
					$response4 .= '<a href="' . SURL . 'admin/dashboard/edit-buy-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
				}
				if ($value['status'] != 'FILLED') {
					$response4 .= '<a href="' . SURL . 'admin/dashboard/delete-buy-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
				}

				if ($value['status'] == 'FILLED') {

					if ($value['is_sell_order'] == 'yes') {

						$response4 .= '<a href="' . SURL . 'admin/dashboard/edit-order/' . $value['sell_order_id'] . '" class="btn btn-inverse" target="_blank"><i class="fa fa-pencil"></i></a>';
						$response4 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';

					} elseif ($value['is_sell_order'] == 'sold') {
						$response4 .= '<button class="btn btn-success">Sold</button>';
					} else {
						$response4 .= '<a href="' . SURL . 'admin/dashboard/add-order/' . $value['_id'] . '" class="btn btn-warning" target="_blank">Set For Sell</a>';
						$response4 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';
					}

				}

				$response4 .= '</div>
                            </td>



                            <td class="text-center">';
				if ($value['status'] == 'new') {

					$response4 .= '<button class="btn btn-danger buy_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Buy Now</button>';
				}
				$response4 .= '</td>
                            </tr>';
			}
		}
		$response4 .= '</tbody>
                    </table>';

		$response5 = '<table class="table table-condensed">
                        <thead>
                            <tr>
                                <th></th>
                                <th><strong>Coin</strong></th>
                                <th><strong>Price</strong></th>
                                <th><strong>Trail Price</strong></th>
                                <th><strong>Quantity</strong></th>
                                <th class="text-center"><strong>P/L</strong></th>
                                <th class="text-center"><strong>Market(%)</strong></th>
                                <th class="text-center"><strong>Status</strong></th>
                                <th class="text-center"><strong>Profit(%)</strong></th>
                                <th class="text-center"><strong>Actions</strong></th>
                            </tr>
                        </thead>
                        <tbody>';
		if (count($submitted) > 0) {
			foreach ($submitted as $key => $value) {

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

				if ($value['status'] != 'new') {
					$market_value333 = num($value['market_value']);
				} else {
					$market_value333 = num($market_value);
				}

				if ($value['status'] == 'new') {
					$current_order_price = num($value['price']);
				} else {
					$current_order_price = num($value['market_value']);
				}

				$current_data = $market_value333 - $current_order_price;
				$market_data = ($current_data * 100 / $market_value333);

				$market_data = number_format((float) $market_data, 2, '.', '');

				if ($market_value333 > $current_order_price) {
					$class = 'success';
				} else {
					$class = 'danger';
				}

				$response5 .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>' . $value['symbol'] . '</td>
                            <td>' . num($value['price']) . '</td>
                            <td>';
				if ($value['trail_check'] == 'yes') {
					$response5 .= num($value['buy_trail_price']);
				} else {
					$response5 .= "-";
				}
				$response5 .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td class="center"><b>' . num($market_value333) . '</b></td>';

				if ($value['is_sell_order'] != 'sold' && $value['is_sell_order'] != 'yes') {

					$response5 .= '<td class="center"><span class="text-' . $class . '"><b>' . $market_data . '%</b></span></td>';

				} else {

					$response5 .= '<td class="center"><span class="text-default"><b>-</b></span></td>';
				}

				$response5 .= '<td class="center">';

				if ($value['status'] == 'FILLED' && $value['is_sell_order'] == 'yes') {

					$response5 .= '<span class="label label-info">SUBMITTED FOR SELL</span>';

				} else {

					$response5 .= '<span class="label label-success">' . strtoupper($value['status']) . '</span>';
				}

				$response5 .= '<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
                                            <i class="fa fa-refresh" aria-hidden="true"></i>
                                          </span>';

				$response5 .= '</td>

                            <td class="center">';

				if ($value['market_sold_price'] != "") {

					$market_sold_price = num($value['market_sold_price']);

					$current_data2222 = $market_sold_price - $current_order_price;
					$profit_data = ($current_data2222 * 100 / $market_sold_price);

					$profit_data = number_format((float) $profit_data, 2, '.', '');

					if ($market_sold_price > $current_order_price) {
						$class222 = 'success';
					} else {
						$class222 = 'danger';
					}

					$response5 .= '<span class="text-' . $class222 . '">
                                                <b>' . $profit_data . '%</b>
                                              </span>';
				} else {

					$response5 .= '<span class="text-default">
                                                    <b>-</b>
                                               </span>';
				}

				$response5 .= '</td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
				if ($value['status'] == 'new') {
					$response5 .= '<a href="' . SURL . 'admin/dashboard/edit-buy-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
				}
				if ($value['status'] != 'FILLED') {
					$response5 .= '<a href="' . SURL . 'admin/dashboard/delete-buy-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
				}

				if ($value['status'] == 'FILLED') {

					if ($value['is_sell_order'] == 'yes') {

						$response5 .= '<a href="' . SURL . 'admin/dashboard/edit-order/' . $value['sell_order_id'] . '" class="btn btn-inverse" target="_blank"><i class="fa fa-pencil"></i></a>';
						$response5 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';

					} elseif ($value['is_sell_order'] == 'sold') {
						$response5 .= '<button class="btn btn-success">Sold</button>';
					} else {
						$response5 .= '<a href="' . SURL . 'admin/dashboard/add-order/' . $value['_id'] . '" class="btn btn-warning" target="_blank">Set For Sell</a>';
						$response5 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';
					}

				}

				$response5 .= '</div>
                            </td>



                            <td class="text-center">';
				if ($value['status'] == 'new') {

					$response5 .= '<button class="btn btn-danger buy_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Buy Now</button>';
				}
				$response5 .= '</td>
                            </tr>';
			}
		}
		$response5 .= '</tbody>
                    </table>';

		$response6 = '<table class="table table-condensed">
	                    <thead>
	                        <tr>
	                            <th></th>
	                            <th><strong>Coin</strong></th>
	                            <th><strong>Price</strong></th>
	                            <th><strong>Trail Price</strong></th>
	                            <th><strong>Quantity</strong></th>
	                            <th class="text-center"><strong>P/L</strong></th>
	                            <th class="text-center"><strong>Market(%)</strong></th>
	                            <th class="text-center"><strong>Status</strong></th>
	                            <th class="text-center"><strong>Profit(%)</strong></th>
	                            <th class="text-center"><strong>Actions</strong></th>
	                        </tr>
	                    </thead>
                        <tbody>';
		if (count($open_trades) > 0) {
			foreach ($open_trades as $key => $value) {

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

				if ($value['status'] != 'new') {
					$market_value333 = num($value['market_value']);
				} else {
					$market_value333 = num($market_value);
				}

				if ($value['status'] == 'new') {
					$current_order_price = num($value['price']);
				} else {
					$current_order_price = num($value['market_value']);
				}

				$current_data = $market_value333 - $current_order_price;
				$market_data = ($current_data * 100 / $market_value333);

				$market_data = number_format((float) $market_data, 2, '.', '');

				if ($market_value333 > $current_order_price) {
					$class = 'success';
				} else {
					$class = 'danger';
				}

				$response6 .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>' . $value['symbol'] . '</td>
                            <td>' . num($value['price']) . '</td>
                            <td>';
				if ($value['trail_check'] == 'yes') {
					$response6 .= num($value['buy_trail_price']);
				} else {
					$response6 .= "-";
				}
				$response6 .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td class="center"><b>' . num($market_value333) . '</b></td>';

				if ($value['is_sell_order'] != 'sold' && $value['is_sell_order'] != 'yes') {

					$response6 .= '<td class="center"><span class="text-' . $class . '"><b>' . $market_data . '%</b></span></td>';

				} else {

					$response6 .= '<td class="center"><span class="text-default"><b>-</b></span></td>';
				}

				$response6 .= '<td class="center">';

				if ($value['status'] == 'FILLED' && $value['is_sell_order'] == 'yes') {

					$response6 .= '<span class="label label-info">SUBMITTED FOR SELL</span>';

				} else {

					$response6 .= '<span class="label label-success">' . strtoupper($value['status']) . '</span>';
				}

				$response6 .= '<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
		                            		<i class="fa fa-refresh" aria-hidden="true"></i>
		                            	  </span>';

				$response6 .= '</td>

                            <td class="center">';

				if ($value['market_sold_price'] != "") {

					$market_sold_price = num($value['market_sold_price']);

					$current_data2222 = $market_sold_price - $current_order_price;
					$profit_data = ($current_data2222 * 100 / $market_sold_price);

					$profit_data = number_format((float) $profit_data, 2, '.', '');

					if ($market_sold_price > $current_order_price) {
						$class222 = 'success';
					} else {
						$class222 = 'danger';
					}

					$response6 .= '<span class="text-' . $class222 . '">
		                        				<b>' . $profit_data . '%</b>
		                        			  </span>';
				} else {

					if ($value['status'] == 'FILLED') {

						if ($value['is_sell_order'] == 'yes') {

							$current_data = num($market_value) - num($value['market_value']);
							$market_data = ($current_data * 100 / $market_value);

							$market_data = number_format((float) $market_data, 2, '.', '');

							if ($market_value > $value['market_value']) {
								$class = 'success';
							} else {
								$class = 'danger';
							}

							$response6 .= '<span class="text-' . $class . '"><b>' . $market_data . '%</b></span>';

						} else {

							$response6 .= '<span class="text-default"><b>-</b></span>';
						}

					} else {

						$response6 .= '<span class="text-default"><b>-</b></span>';

					}
				}

				$response6 .= '</td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
				if ($value['status'] == 'new') {
					$response6 .= '<a href="' . SURL . 'admin/dashboard/edit-buy-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
				}
				if ($value['status'] != 'FILLED') {
					$response6 .= '<a href="' . SURL . 'admin/dashboard/delete-buy-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
				}

				if ($value['status'] == 'FILLED') {

					if ($value['is_sell_order'] == 'yes') {

						$response6 .= '<a href="' . SURL . 'admin/dashboard/edit-order/' . $value['sell_order_id'] . '" class="btn btn-inverse" target="_blank"><i class="fa fa-pencil"></i></a>';
						$response6 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';

					} elseif ($value['is_sell_order'] == 'sold') {
						$response6 .= '<button class="btn btn-success">Sold</button>';
					} else {
						$response6 .= '<a href="' . SURL . 'admin/dashboard/add-order/' . $value['_id'] . '" class="btn btn-warning" target="_blank">Set For Sell</a>';
						$response6 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';
					}

				}

				$response6 .= '</div>
                            </td>



                            <td class="text-center">';
				if ($value['status'] == 'new') {

					$response6 .= '<button class="btn btn-danger buy_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Buy Now</button>';
				}
				$response6 .= '</td>
                            </tr>';
			}
		}
		$response6 .= '</tbody>
                    </table>';

		$response7 = '<table class="table table-condensed">
	                    <thead>
	                        <tr>
	                            <th></th>
	                            <th><strong>Coin</strong></th>
	                            <th><strong>Price</strong></th>
	                            <th><strong>Trail Price</strong></th>
	                            <th><strong>Quantity</strong></th>
	                            <th class="text-center"><strong>P/L</strong></th>
	                            <th class="text-center"><strong>Market(%)</strong></th>
	                            <th class="text-center"><strong>Status</strong></th>
	                            <th class="text-center"><strong>Profit(%)</strong></th>
	                            <th class="text-center"><strong>Actions</strong></th>
	                        </tr>
	                    </thead>
                        <tbody>';
		if (count($sold_trades) > 0) {
			foreach ($sold_trades as $key => $value) {

				//Get Market Price
				$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

				if ($value['status'] != 'new') {
					$market_value333 = num($value['market_value']);
				} else {
					$market_value333 = num($market_value);
				}

				if ($value['status'] == 'new') {
					$current_order_price = num($value['price']);
				} else {
					$current_order_price = num($value['market_value']);
				}

				$current_data = $market_value333 - $current_order_price;
				$market_data = ($current_data * 100 / $market_value333);

				$market_data = number_format((float) $market_data, 2, '.', '');

				if ($market_value333 > $current_order_price) {
					$class = 'success';
				} else {
					$class = 'danger';
				}

				$response7 .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>' . $value['symbol'] . '</td>
                            <td>' . num($value['price']) . '</td>
                            <td>';
				if ($value['trail_check'] == 'yes') {
					$response7 .= num($value['buy_trail_price']);
				} else {
					$response7 .= "-";
				}
				$response7 .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td class="center"><b>' . num($market_value333) . '</b></td>';

				if ($value['is_sell_order'] != 'sold' && $value['is_sell_order'] != 'yes') {

					$response7 .= '<td class="center"><span class="text-' . $class . '"><b>' . $market_data . '%</b></span></td>';

				} else {

					$response7 .= '<td class="center"><span class="text-default"><b>-</b></span></td>';
				}

				$response7 .= '<td class="center">';

				if ($value['status'] == 'FILLED' && $value['is_sell_order'] == 'yes') {

					$response7 .= '<span class="label label-info">SUBMITTED FOR SELL</span>';

				} else {

					$response7 .= '<span class="label label-success">' . strtoupper($value['status']) . '</span>';
				}

				$response7 .= '<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
		                            		<i class="fa fa-refresh" aria-hidden="true"></i>
		                            	  </span>';

				$response7 .= '</td>

                            <td class="center">';

				if ($value['market_sold_price'] != "") {

					$market_sold_price = num($value['market_sold_price']);

					$current_data2222 = $market_sold_price - $current_order_price;
					$profit_data = ($current_data2222 * 100 / $market_sold_price);

					$profit_data = number_format((float) $profit_data, 2, '.', '');

					if ($market_sold_price > $current_order_price) {
						$class222 = 'success';
					} else {
						$class222 = 'danger';
					}

					$response7 .= '<span class="text-' . $class222 . '">
		                        				<b>' . $profit_data . '%</b>
		                        			  </span>';
				} else {

					$response7 .= '<span class="text-default">
		                        					<b>-</b>
		                        			   </span>';
				}

				$response7 .= '</td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
				if ($value['status'] == 'new') {
					$response7 .= '<a href="' . SURL . 'admin/dashboard/edit-buy-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
				}
				if ($value['status'] != 'FILLED') {
					$response7 .= '<a href="' . SURL . 'admin/dashboard/delete-buy-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
				}

				if ($value['status'] == 'FILLED') {
					if ($value['is_sell_order'] == 'yes') {

					} elseif ($value['is_sell_order'] == 'sold') {
						$response7 .= '<button class="btn btn-success">Sold</button>';
					} else {
						$response7 .= '<a href="' . SURL . 'admin/dashboard/add-order/' . $value['_id'] . '" class="btn btn-warning" target="_blank">Set For Sell</a>';
						$response7 .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';
					}
				}

				$response7 .= '</div>
                            </td>



                            <td class="text-center">';
				if ($value['status'] == 'new') {

					$response7 .= '<button class="btn btn-danger buy_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Buy Now</button>';
				}
				$response7 .= '</td>
                            </tr>';
			}
		}
		$response7 .= '</tbody>
                    </table>';

		$count_new_orders = count($new_orders);
		$count_filled_orders = count($filled_orders);
		$count_submitted = count($submitted);
		$count_cancelled = count($cancelled);
		$count_error_orders = count($error_orders);
		$count_open_trades = count($open_trades);
		$count_sold_trades = count($sold_trades);
		$count_orders_arr = count($orders_arr);

		echo $response . '@@@@@@' . $response1 . '@@@@@@' . $response2 . '@@@@@@' . $response3 . '@@@@@@' . $response4 . '@@@@@@' . $response5 . '@@@@@@' . $response6 . '@@@@@@' . $response7 . '@@@@@@' . $count_new_orders . '@@@@@@' . $count_filled_orders . '@@@@@@' . $count_submitted . '@@@@@@' . $count_cancelled . '@@@@@@' . $count_error_orders . '@@@@@@' . $count_open_trades . '@@@@@@' . $count_sold_trades . '@@@@@@' . $count_orders_arr;
		exit;

	} //end autoload_market_buy_data2

	public function sell_order() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		$id = $this->input->post('id');
		$market_value = $this->input->post('market_value');
		$quantity = $this->input->post('quantity');
		$symbol = $this->input->post('symbol');
		$user_id = $this->session->userdata('admin_id');

		$order_arr = $this->mod_dashboard->get_order($id);

		if ($order_arr['status'] == 'new') {

			$application_mode = $order_arr['application_mode'];

			if ($application_mode == 'live') {

				//Auto Sell Binance Market Order Live
				$this->mod_dashboard->binance_sell_auto_market_order_live($id, $quantity, $market_value, $symbol, $user_id);

			} else {

				//Auto Sell Binance Market Order Test
				$this->mod_dashboard->binance_sell_auto_market_order_test($id, $quantity, $market_value, $symbol, $user_id);
			}

			echo 1;

		} else {

			echo "Order is already in <b>" . strtoupper($order_arr['status']) . "</b> status";

		}

		exit;

	} //end sell_order

	public function sell_all_orders() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		$sell_all_orders = $this->mod_dashboard->sell_all_orders();

		if ($sell_all_orders) {
			$this->autoload_market_data2();
		}

	} //end sell_all_orders

	public function buy_order() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		$id = $this->input->post('id');
		$market_value = $this->input->post('market_value');
		$quantity = $this->input->post('quantity');
		$symbol = $this->input->post('symbol');
		$user_id = $this->session->userdata('admin_id');

		$order_arr = $this->mod_dashboard->get_buy_order($id);
		$application_mode = $order_arr['application_mode'];

		if ($application_mode == 'live') {

			//Auto Buy Binance Market Order Live
			$this->mod_dashboard->binance_buy_auto_market_order_live($id, $quantity, $market_value, $symbol, $user_id);

		} else {

			//Auto Buy Binance Market Order Test
			$this->mod_dashboard->binance_buy_auto_market_order_test($id, $quantity, $market_value, $symbol, $user_id);
		}

		echo 1;
		exit;

	} //end buy_order

	public function buy_all_orders() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		$buy_all_orders = $this->mod_dashboard->buy_all_orders();

		if ($buy_all_orders) {
			$this->autoload_market_buy_data2();
		}

	} //end buy_all_orders

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
					                <li><strong>Entry Price</strong> <span class="color-blue">' . $order_arr['purchased_price'] . '</span></li>
					                <li><strong>Exit Price</strong> <span class="color-blue">' . $order_arr['market_value'] . '</span></li>
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
					                <li><strong>Entry Price</strong> <span class="color-blue">' . $order_arr['price'] . '</span></li>
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
					                <input type="text" class="form-control" name="purchased_price" value="' . $order_arr['purchased_price'] . '" >
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
					               <input type="text" name="sell_profit_price" value="' . $order_arr['sell_profit_price'] . '" class="form-control">
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
					                <input type="text" class="form-control" name="price" value="' . $order_arr['price'] . '" >
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

	public function update_order_details() {

		//Login Check
		$this->mod_login->verify_is_admin_login();

		$type = $this->input->post('type');
		$order_id = $this->input->post('id');

		if ($type == 'sell') {

			//edit_order
			$edit_order = $this->mod_dashboard->edit_order($this->input->post());
			$this->get_order_details($order_id, $type);

		} else {

			//edit_buy_order
			$edit_buy_order = $this->mod_dashboard->edit_buy_order($this->input->post());
			$this->get_order_details($order_id, $type);

		}

	} //End update_order_details

	public function set_currency() {

		$symbol = $this->input->post('symbol');

		$sess_symbol = array(
			'global_symbol' => $symbol,
		);

		$this->session->set_userdata($sess_symbol);

	} //End set_currency

	public function set_application_mode() {

		$mode = $this->input->post('mode');

		$user_id = $this->session->userdata('admin_id');

/*		$upd_data = array(
'application_mode' => $this->db->escape_str(trim($mode))
);

$this->db->dbprefix('users');
$this->db->where('id', $user_id);
$this->db->update('users', $upd_data);*/

		$sess_symbol = array(
			'global_mode' => $mode,
		);

		$this->session->set_userdata($sess_symbol);

	} //End set_application_mode

	public function convert_price() {

		$sell_profit_percent = $this->input->post('sell_profit_percent');
		$purchased_price = $this->input->post('purchased_price');

		$sell_price = $purchased_price * $sell_profit_percent;
		$sell_price = $sell_price / 100;
		$sell_price = $sell_price + $purchased_price;

		echo number_format($sell_price, 8, '.', '');
		exit;

	} //End convert_price

	public function get_sell_order_status() {

		$order_id = $this->input->post('order_id');
		$id = $this->input->post('id');

		$order_status = $this->mod_dashboard->get_sell_order_status($id, $order_id);

		if ($order_status) {
			$this->autoload_market_data();
		}

	} //End get_sell_order_status

	public function get_buy_order_status() {

		$order_id = $this->input->post('order_id');
		$id = $this->input->post('id');

		$order_status = $this->mod_dashboard->get_buy_order_status($id, $order_id);

		if ($order_status) {
			$this->autoload_market_buy_data();
		}

	} //End get_buy_order_status

	public function get_buy_order_details_ajax() {

		$order_id = $this->input->post('order_id');
		$order_arr = $this->mod_dashboard->get_buy_order($order_id);
		if ($order_arr['parent_status'] == 'parent') {
			$order_count = $this->mod_dashboard->count_child_buy_order($order_id);
		}

		$response = '<div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">ID :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . $order_arr['_id'] . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Price :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . $order_arr['price'] . '</p>
                        </div>
                     </div>';
		if ($order_arr['parent_status'] == 'parent') {
			$response .= ' <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Child Orders :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . $order_count . '</p>
                        </div>
                     </div>';
		}

		$response .= ' <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Market Buy Price :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . $order_arr['market_value'] . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Trigger Type:</label>
                        </div>
                        <div class="col-md-6">';
		if ($order_arr['trigger_type'] == 'no' || $order_arr['trigger_type'] == '') {
			$response .= '<td> Manual Order</td>';
		} else {
			$response .= '<td>' . strtoupper(str_replace('_', ' ', $order_arr['trigger_type'])) . '</td>';
		}
		$response .= '</div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Quantity :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . $order_arr['quantity'] . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Trail :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . ucfirst($order_arr['trail_check']) . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Trail Interval :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . $order_arr['trail_interval'] . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Order Type :</label>
                        </div>
                        <div class="col-md-6">
                            <label for="inputTitle">' . strtoupper($order_arr['order_type']) . '</label>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Created Date :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . $order_arr['created_date'] . '</p>
                        </div>
                     </div>
                      <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Last Action Date :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . $order_arr['modified_date'] . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Binance Order ID :</label>
                        </div>
                        <div class="col-md-6">
                            <span class="label label-success">' . $order_arr['binance_order_id'] . '</span>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Status :</label>
                        </div>
                        <div class="col-md-6">
                            <span class="label label-success">' . ucfirst($order_arr['status']) . '</span>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Order Mode :</label>
                        </div>
                        <div class="col-md-6">
                            <span class="label label-success">' . strtoupper($order_arr['order_mode']) . '</span>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Auto Sell :</label>
                        </div>
                        <div class="col-md-6">';
		if ($order_arr['auto_sell'] == 'yes') {
			$auto_sell = 'yes';
			$auto_sell_class = 'success';
		} else {
			$auto_sell = 'no';
			$auto_sell_class = 'danger';
		}
		$response .= '<span class="label label-' . $auto_sell_class . '">' . ucfirst($auto_sell) . '</span>
                        </div>
                     </div>';

		if ($order_arr['auto_sell'] == 'yes') {

			//Get Sell Temp Data
			$sell_data_arr = $this->mod_dashboard->get_temp_sell_data($order_id);
			$profit_type = $sell_data_arr['profit_type'];
			$sell_profit_percent = $sell_data_arr['profit_percent'];
			$sell_profit_price = $sell_data_arr['profit_price'];
			$order_type = $sell_data_arr['order_type'];
			$trail_check = $sell_data_arr['trail_check'];
			$trail_interval = $sell_data_arr['trail_interval'];
			$stop_loss = $sell_data_arr['stop_loss'];
			$loss_percentage = $sell_data_arr['loss_percentage'];

			$response .= '<br>
							 <div class="row">
		                        <div class="col-md-6">
		                            <label for="inputTitle">Profit Type :</label>
		                        </div>
		                        <div class="col-md-6">
		                            <p>' . ucfirst($profit_type) . '</p>
		                        </div>
		                     </div>
		                     <div class="row">
		                        <div class="col-md-6">
		                            <label for="inputTitle">Profit Percentage :</label>
		                        </div>
		                        <div class="col-md-6">
		                            <p>' . $sell_profit_percent . '</p>
		                        </div>
		                     </div>
		                     <div class="row">
		                        <div class="col-md-6">
		                            <label for="inputTitle">Profit Price :</label>
		                        </div>
		                        <div class="col-md-6">
		                            <p>' . $sell_profit_price . '</p>
		                        </div>
		                     </div>
		                     <div class="row">
		                        <div class="col-md-6">
		                            <label for="inputTitle">Order Type :</label>
		                        </div>
		                        <div class="col-md-6">
		                            <p>' . strtoupper($order_type) . '</p>
		                        </div>
		                     </div>
		                     <div class="row">
		                        <div class="col-md-6">
		                            <label for="inputTitle">Trail Check:</label>
		                        </div>
		                        <div class="col-md-6">
		                            <p>' . $trail_check . '</p>
		                        </div>
		                     </div>
		                     <div class="row">
		                        <div class="col-md-6">
		                            <label for="inputTitle">Trail Interval:</label>
		                        </div>
		                        <div class="col-md-6">
		                            <p>' . $trail_interval . '</p>
		                        </div>
		                     </div>
		                     <div class="row">
		                        <div class="col-md-6">
		                            <label for="inputTitle">Stop Loss:</label>
		                        </div>
		                        <div class="col-md-6">
		                            <p>' . $stop_loss . '</p>
		                        </div>
		                     </div>
		                     <div class="row">
		                        <div class="col-md-6">
		                            <label for="inputTitle">Loss Percentage:</label>
		                        </div>
		                        <div class="col-md-6">
		                            <p>' . $loss_percentage . '</p>
		                        </div>
		                     </div>';
		}

		echo $response;
		exit;

	} //End get_buy_order_details_ajax

	public function get_sell_order_details_ajax() {

		$order_id = $this->input->post('order_id');
		$order_arr = $this->mod_dashboard->get_order($order_id);

		$response = '<div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">ID :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . $order_arr['_id'] . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Purchased Price :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . $order_arr['purchased_price'] . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Market Sell Price :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . num($order_arr['market_value']) . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Quantity :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . $order_arr['quantity'] . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Trail :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . ucfirst($order_arr['trail_check']) . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Trail Interval :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . $order_arr['trail_interval'] . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Order Type :</label>
                        </div>
                        <div class="col-md-6">
                            <label for="inputTitle">' . strtoupper($order_arr['order_type']) . '</label>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Created Date :</label>
                        </div>
                        <div class="col-md-6">
                            <p>' . $order_arr['created_date'] . '</p>
                        </div>
                     </div>';

		if ($order_arr['stop_loss'] == 'yes') {
			$response .= '<div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Stop Loss :</label>
                        </div>
                        <div class="col-md-6">
                            <label for="inputTitle">' . ucfirst($order_arr['stop_loss']) . '</label>
                        </div>
	                    </div>
	                   	<div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Stop Loss Percentage :</label>
                        </div>
                        <div class="col-md-6">
                            <label for="inputTitle">' . $order_arr['loss_percentage'] . '%</label>
                        </div>
	                    </div>';
		}

		$response .= '<div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Binance Order ID :</label>
                        </div>
                        <div class="col-md-6">
                            <span class="label label-success">' . $order_arr['binance_order_id'] . '</span>
                        </div>
                     </div>
                      <div class="row">
                        <div class="col-md-6">
                            <label for="inputTitle">Status :</label>
                        </div>
                        <div class="col-md-6">
                            <span class="label label-success">' . ucfirst($order_arr['status']) . '</span>
                        </div>
                     </div>';

		echo $response;
		exit;

	} //End get_sell_order_details_ajax

	public function autoload_market_statistics() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Get Market Value
		$symbol = $this->input->post('coin');
		if (empty($symbol)) {
			$symbol = $this->session->userdata('global_symbol');
		}
		$market_value = $this->mod_dashboard->get_market_value($symbol);

		//Check Buy Zones
		$check_buy_zones = $this->mod_dashboard->check_buy_zones($market_value);
		$in_zone = $check_buy_zones['in_zone'];
		$type = $check_buy_zones['type'];
		$start_value = $check_buy_zones['start_value'];
		$end_value = $check_buy_zones['end_value'];

		//Get Coin Balance
		$coin_balance = $this->mod_dashboard->get_coin_balance($symbol);

		$response = '<ul>
	                 <li>
	                    <span><b>Current Market</b></span>
	                    <span class="count">' . $market_value . '</span>
	                 </li>
	                 <li>
	                    <span><b>In Zone ' . ucfirst($type) . '</b></span>
	                    <span class="count">' . ucfirst($in_zone) . '</span>
	                 </li>';
		if ($type == 'sell') {
			$response .= '<li>
	                    <span><b>Closest Sell Zone</b></span>
	                    <span class="count">' . $start_value . ' - ' . $end_value . '</span>
	                 </li>';
		} else {
			$response .= '<li>
	                    <span><b>Closest Buy Zone</b></span>
	                    <span class="count">' . $start_value . ' - ' . $end_value . '</span>
	                 </li>';
		}
		$response .= '<li>
	                    <span><b>Pressure</b></span>
	                    <span class="count">Up</span>
	                 </li>
	                 <li>
	                    <span><b>Available Quantity</b></span>
	                    <span class="count">' . $coin_balance . '</span>
	                 </li>
	                </ul>';

		echo $response;
		exit;

	} //end autoload_market_statistics

	public function reset_filters($type) {

		$this->session->unset_userdata('filter-data');
		redirect(base_url() . 'admin/dashboard/orders-listing');

	} //End reset_filters

	public function reset_buy_filters($type) {

		$this->session->unset_userdata('filter-data-buy');
		redirect(base_url() . 'admin/buy_orders');

	} //End reset_buy_filters

	public function autoload_notifications($id) {

		$notifications = $this->mod_dashboard->get_notifications($id);

		echo $message = $notifications['message'] . "|" . $notifications['id'];
		exit;

	} //End autoload_notifications

	public function set_buy_price() {

		//Get Market Value
		$coin = $this->input->post('coin');
		$market_value = $this->mod_dashboard->get_market_value($coin);

		$keywords_str = $this->mod_market->get_coin_keywords($coin);
		$keywords = explode(',', $keywords_str);
		$news = $this->mod_market->get_coin_news($keywords);

		$score_avg = 0;
		$psum = 0;
		$nsum = 0;
		$sum = 0;
		$x = 0;
		$count = 0;

		foreach ($news as $key => $value) {
			if ($value['score'] >= 0) {
				$psum = $psum + $value['score'];
			} else {
				$nsum = $nsum + $value['score'];
			}
			$count++;
		}
		$sum = $psum + (-1 * ($nsum));
		$x = $psum / $sum;
		$score_avg = round($x * 100);
		echo $market_value . '|' . $score_avg;
		exit;

	} //End set_buy_price

	public function get_coin_balance() {
		$balance = $this->mod_dashboard->get_coin_balance();
		echo $balance;
		exit;
	}

	public function barrier_listing() {

		$error = array();
		if (!empty($this->input->post())) {

			$cust_id = $this->input->post('admin_id');
			if (!empty($cust_id)) {
				$data_sess['cust_id'] = $cust_id;
			}
			if (!empty($this->input->post('status')) || !empty($this->input->post('filter_coin')) || !empty($this->input->post('global_swing_parent_status')) || !empty($this->input->post('start_date')) || !empty($this->input->post('end_date')) || !empty($this->input->post('barrier_type'))) {
				$filter_data = $this->input->post();
			}
			if (!empty($filter_data)) {

				$data_sess['filter_data']['status'] = $this->input->post('status');
				$data_sess['filter_data']['filter_coin'] = $this->input->post('filter_coin');
				$data_sess['filter_data']['global_swing_parent_status'] = $this->input->post('global_swing_parent_status');
				$data_sess['filter_data']['start_date'] = $this->input->post('start_date');
				$data_sess['filter_data']['end_date'] = $this->input->post('end_date');
				$data_sess['filter_data']['barrier_type'] = $this->input->post('barrier_type');
			}
			$this->session->set_userdata($data_sess);
		}
		//Pagination Code//
		$this->load->library("pagination");
		$countBarrierListing = $this->mod_dashboard->countBarrierListing($filter_data);
		$count = $countBarrierListing;

		$config = array();
		$config["base_url"] = SURL . "admin/dashboard/barrier-listing";
		$config["total_rows"] = $count;
		$config['per_page'] = 50;
		$config['num_links'] = 10;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] = 4;
		$config['reuse_query_string'] = TRUE;
		$config["first_tag_open"] = '<li>';
		$config["first_tag_close"] = '</li>';
		$config["last_tag_open"] = '<li>';
		$config["last_tag_close"] = '</li>';
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
		$config['cur_tag_close'] = '</b></a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		$page = $this->uri->segment(4);
		if (!isset($page)) {$page = 1;}
		$start = ($page - 1) * $config["per_page"];
		////////////////////////////End Pagination Code///////////////////////////////////////////////
		$barrierListing_arr = $this->mod_dashboard->barrierListing($start, $config["per_page"], $filter_data);
		$page_links = $this->pagination->create_links();
		$data['page_links'] = $page_links;
		$data['barrier_arr'] = $barrierListing_arr['finalArray'];
		$data['coins'] = $this->mod_coins->get_all_coins();
		//  Pagiantion code goes end here

		/*$coin = $this->session->userdata('global_symbol');
			$search_arr['coin'] = $coin;
			$this->mongo_db->where($search_arr);
			$this->mongo_db->limit(20);

			$this->mongo_db->order_by(array('created_date' => -1));
			$depth_responseArr = $this->mongo_db->get('barrier_values_collection');

			$arr = iterator_to_array($depth_responseArr);
			$data['barrier_arr'] = $arr;

		*/

		//echo "<pre>";   print_r($data['coins'] ); exit;

		$this->stencil->paint('admin/barrier/listing', $data);
	}

	public function edit_barrier() {

		$search_arr['_id'] = $this->input->post('id');
		$this->mongo_db->where($search_arr);
		$depth_responseArr = $this->mongo_db->get('barrier_values_collection');
		$arr = iterator_to_array($depth_responseArr);
		$response = '';

		$response .= '<form class="form-horizontal" id="edit_form" method="POST" action="' . SURL . 'admin/dashboard/edit_barrier_action">
  <div class="form-group">
    <label class="control-label col-sm-2" for="barrier_val">Barrier Value:</label>
    <div class="col-sm-10">
      <input type="hidden" class="form-control" name="barrier_id" id="barrier_id" value="' . $arr[0]['_id'] . '">
      <input type="text" class="form-control" name="barrier_val" id="barrier_val" value="' . num($arr[0]['barier_value']) . '">
    </div>
  </div>
</form>';

		echo $response;
		exit;
	}

	public function edit_barrier_action() {
		$barrier_val = $this->input->post('barrier_val');
		$barrier_id = $this->input->post('barrier_id');

		$upd_arr = array('barier_value' => (float) $barrier_val);
		$this->mongo_db->where(array('_id' => $barrier_id));
		$this->mongo_db->set($upd_arr);
		$upd = $this->mongo_db->update('barrier_values_collection');
		if ($upd) {

			$this->session->set_flashdata('ok_message', 'Barrier Updated successfully.');
		} else {

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');

		} //end if
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function add_barrier_action() {
		$coin_symbol = $this->input->post('coin_type');
		$created_date = date('Y-m-d H:i:s');
		$barrier_val = $this->input->post('barrier_val');
		$barrier_id = $this->input->post('barrier_type');

		$upd_arr = array('coin' => $coin_symbol, 'barier_value' => (float) $barrier_val, 'barrier_type' => $barrier_id, 'created_date' => $this->mongo_db->converToMongodttime($created_date), 'human_readible_created_date' => $created_date);
		$ins = $this->mongo_db->insert('barrier_values_collection', $upd_arr);
		if ($ins) {

			$this->session->set_flashdata('ok_message', 'Barrier Inserted successfully.');
		} else {

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');

		} //end if
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_barrier($id) {
		$this->mongo_db->where(array('_id' => $this->mongo_db->mongoId($id)));
		$del = $this->mongo_db->delete('barrier_values_collection');
		$this->mongo_db->where(array('barrier_id' => $this->mongo_db->mongoId($id)));
		$del2 = $this->mongo_db->delete('barrier_test_collection');
		if ($del) {

			$this->session->set_flashdata('ok_message', 'Barrier Deleted successfully.');
		} else {

			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');

		} //end if
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function show_barrier($barrier_id = '') {
		$this->mongo_db->where(array('barrier_id' => $this->mongo_db->mongoId($barrier_id)));
		$del = $this->mongo_db->get('barrier_test_collection');

		$ret_arr = iterator_to_array($del);

		foreach ($ret_arr as $key => $value) {
			$returArr['barrier_value'] = num($value['barrier_value']);
			$returArr['barrier_type'] = $value['barrier_type'];
			$returArr['barrier_quantity'] = number_format_short($value['barrier_quantity']);
			$returArr['market_value_time'] = $value['market_value_time'];
			$returArr['black_wall_pressure'] = $value['black_wall_pressure'];
			$returArr['yellow_wall_pressure'] = $value['yellow_wall_pressure'];
			$returArr['depth_pressure'] = $value['depth_pressure'];
			$returArr['bid_contracts'] = number_format_short($value['bid_contracts']);
			$returArr['bid_percentage'] = $value['bid_percentage'];
			$returArr['ask_contract'] = number_format_short($value['ask_contract']);
			$returArr['ask_percentage'] = $value['ask_percentage'];
			$returArr['great_wall_quantity'] = number_format_short($value['great_wall_quantity']);
			$returArr['great_wall'] = $value['great_wall'];
			$returArr['seven_level_depth'] = $value['seven_level_depth'];
		}
		$data['down_indicators'] = $returArr;

		$this->stencil->paint('admin/barrier/listing_indicator', $data);
	}

	public function indicator_test() {

		/////////////////////////////////////////////////////////////

		if (!empty($this->input->post("coin_symbol"))) {
			$coin_symbol = $this->input->post("coin_symbol");
		} else {
			$coin_symbol = "NCASHBTC";
		}

		if (!empty($this->input->post("barrier_swing"))) {
			$barrier_swing = $this->input->post("barrier_swing");
			$search_arr['global_swing_parent_status'] = $barrier_swing;
		} else {
			$barrier_swing = '';
		}

		$data['coin'] = $coin_symbol;
		$data['barrier_type'] = $barrier_type;
		$data['barrier_swing'] = $barrier_swing;

		////////////////////////////////////////////////////////////
		$barrier_type = "up";
		$search_arr['coin'] = $coin_symbol;
		$search_arr['barrier_type'] = $barrier_type;

		$datetime = date("Y-m-d H:i:s", strtotime("-7 days"));

		$search_arr['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($datetime));

		$this->mongo_db->where($search_arr);
		$get = $this->mongo_db->get('barrier_values_collection');
		$pre_res = iterator_to_array($get);

		foreach ($pre_res as $key => $value) {
			$created_date = $value['created_date'];
			$barrier_value = $value['barier_value'];
			$barrier_id = $value['_id'];
			$new_Date = $created_date->toDateTime()->format("Y-m-d H:i:s");
			$search_arr2['barrier_id'] = $barrier_id;
			$search_arr2['coin'] = $coin_symbol;
			//$search_arr2['created_date'] = $created_date;

			$this->mongo_db->where($search_arr2);
			$this->mongo_db->limit(1);
			$gets = $this->mongo_db->get('barrier_test_collection');
			$coin_meta = iterator_to_array($gets);

			$this->mongo_db->where($search_arr2);
			$this->mongo_db->limit(1);
			$gets = $this->mongo_db->get('barrier_test_collection');
			$coin_meta = iterator_to_array($gets);

			if (!empty($coin_meta)) {
				$res['ups'][] = array(
					'coin' => $coin_symbol,
					'barrier_value' => $barrier_value,
					'barrier_creation_time' => $new_Date222,
					'market_value_time' => $new_Date,
					'black_wall_pressure' => $coin_meta[0]['black_wall_pressure'],
					'yellow_wall_pressure' => $coin_meta[0]['yellow_wall_pressure'],
					'depth_pressure' => $coin_meta[0]['depth_pressure'],
					'bid_contracts' => $coin_meta[0]['bid_contracts'],
					'bid_percentage' => $coin_meta[0]['bid_percentage'],
					'ask_contract' => $coin_meta[0]['ask_contract'],
					'ask_percentage' => $coin_meta[0]['ask_percentage'],
					'great_wall_quantity' => $coin_meta[0]['great_wall_quantity'],
					'great_wall' => $coin_meta[0]['great_wall'],
					'seven_level_depth' => $coin_meta[0]['seven_level_depth'],
				);
			}

		}

		$returnArr = array();
		/*==============================Black Wall Pressure==========================================*/
		$black_wall_array = array_column($res['ups'], 'black_wall_pressure');
		$average_black_wall = array_sum($black_wall_array) / count($black_wall_array);
		$max_black_wall_pressure = max($black_wall_array);
		$min_black_wall_pressure = min($black_wall_array);
		$returnArr['ups']['black_wall_pressure'] = array(
			'avg' => $average_black_wall,
			'max' => $max_black_wall_pressure,
			'min' => $min_black_wall_pressure,
		);
		/*==============================End Black Wall Pressure=======================================*/

		/*==============================Yellow Wall Pressure==========================================*/
		$yellow_wall_array = array_column($res['ups'], 'yellow_wall_pressure');
		$average_yellow_wall = array_sum($yellow_wall_array) / count($yellow_wall_array);
		$max_yellow_wall_pressure = max($yellow_wall_array);
		$min_yellow_wall_pressure = min($yellow_wall_array);

		$returnArr['ups']['yellow_wall_pressure'] = array(

			'avg' => $average_yellow_wall,
			'max' => $max_yellow_wall_pressure,
			'min' => $min_yellow_wall_pressure,
		);
		/*==============================End Yellow Wall Pressure=======================================*/

		/*================================Depth Pressure===============================================*/
		$depth_array = array_column($res['ups'], 'depth_pressure');
		$average_depth = array_sum($depth_array) / count($depth_array);
		$max_depth_pressure = max($depth_array);
		$min_depth_pressure = min($depth_array);

		$returnArr['ups']['depth_pressure'] = array(
			'avg' => $average_depth,
			'max' => $max_depth_pressure,
			'min' => $min_depth_pressure,
		);
		/*==============================End Depth Pressure=======================================*/

		/*================================Bid Contracts==========================================*/
		$bid_contracts_arr = array_column($res['ups'], 'bid_contracts');
		$average_bids = array_sum($bid_contracts_arr) / count($bid_contracts_arr);
		$max_bids = max($bid_contracts_arr);
		$min_bids = min($bid_contracts_arr);

		$returnArr['ups']['bid_contracts'] = array(
			'avg' => $average_bids,
			'max' => $max_bids,
			'min' => $min_bids,
		);
		/*==============================End Bid Contracts========================================*/

		/*================================Ask Contracts==========================================*/
		$ask_contracts_arr = array_column($res['ups'], 'ask_contract');
		$average_asks = array_sum($ask_contracts_arr) / count($ask_contracts_arr);
		$max_asks = max($ask_contracts_arr);
		$min_asks = min($ask_contracts_arr);

		$returnArr['ups']['ask_contract'] = array(
			'avg' => $average_asks,
			'max' => $max_asks,
			'min' => $min_asks,
		);
		/*==============================End Ask Contracts========================================*/

		/*================================Bid Contracts==========================================*/
		$bid_percentage_arr = array_column($res['ups'], 'bid_percentage');
		$average_bids_per = array_sum($bid_percentage_arr) / count($bid_percentage_arr);
		$max_bids_per = max($bid_percentage_arr);
		$min_bids_per = min($bid_percentage_arr);
		$returnArr['ups']['bid_percentage'] = array(
			'avg' => $average_bids_per,
			'max' => $max_bids_per,
			'min' => $min_bids_per,
		);
		/*==============================End Bid Contracts========================================*/

		/*================================Ask Contracts==========================================*/
		$ask_percentage_arr = array_column($res['ups'], 'ask_percentage');
		$average_asks_per = array_sum($ask_percentage_arr) / count($ask_percentage_arr);
		$max_asks_per = max($ask_percentage_arr);
		$min_asks_per = min($ask_percentage_arr);

		$returnArr['ups']['ask_percentage'] = array(
			'avg' => $average_asks_per,
			'max' => $max_asks_per,
			'min' => $min_asks_per,
		);
		/*==============================End Ask Contracts========================================*/

		/*================================Great Wall==========================================*/
		$great_wall_array = array_column($res['ups'], 'great_wall_quantity');
		$great_wall_avg = array_sum($great_wall_array) / count($great_wall_array);
		$max_great_wall = max($great_wall_array);
		$min_great_wall = min($great_wall_array);

		$returnArr['ups']['great_wall'] = array(
			'avg' => $great_wall_avg,
			'max' => $max_great_wall,
			'min' => $min_great_wall,
		);
		/*==============================End Great Wall========================================*/

		/*================================Great Wall==========================================*/
		$seven_level_array = array_column($res['ups'], 'seven_level_depth');
		$seven_level_avg = array_sum($seven_level_array) / count($seven_level_array);
		$max_seven_level = max($seven_level_array);
		$min_seven_level = min($seven_level_array);

		$returnArr['ups']['seven_level_depth'] = array(
			'avg' => $seven_level_avg,
			'max' => $max_seven_level,
			'min' => $min_seven_level,
		);

		/*==============================End Great Wall========================================*/
		//=========================================Downs=======================================

		$search_arr = array();
		$barrier_type = "down";
		$search_arr['coin'] = $coin_symbol;
		$search_arr['barrier_type'] = $barrier_type;
		if (isset($barrier_swing) && $barrier_swing != '') {
			$search_arr['global_swing_parent_status'] = $barrier_swing;
		}
		$datetime = date("Y-m-d H:i:s", strtotime("-7 days"));

		$search_arr['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($datetime));

		$this->mongo_db->where($search_arr);
		$get = $this->mongo_db->get('barrier_values_collection');
		$pre_res2 = iterator_to_array($get);
		foreach ($pre_res2 as $key => $value) {
			$created_date = $value['created_date'];
			$barrier_value = $value['barier_value'];
			$barrier_id = $value['_id'];
			$new_Date = $created_date->toDateTime()->format("Y-m-d H:i:s");
			$search_arr2['barrier_id'] = $barrier_id;
			$search_arr2['coin'] = $coin_symbol;
			//$search_arr2['created_date'] = $created_date;

			$this->mongo_db->where($search_arr2);
			$this->mongo_db->limit(1);
			$gets = $this->mongo_db->get('barrier_test_collection');
			$coin_meta = iterator_to_array($gets);

			if (!empty($coin_meta)) {
				$res['downs'][] = array(
					'coin' => $coin_symbol,
					'barrier_value' => $barrier_value,
					'barrier_creation_time' => $new_Date222,
					'market_value_time' => $new_Date,
					'black_wall_pressure' => $coin_meta[0]['black_wall_pressure'],
					'yellow_wall_pressure' => $coin_meta[0]['yellow_wall_pressure'],
					'depth_pressure' => $coin_meta[0]['depth_pressure'],
					'bid_contracts' => $coin_meta[0]['bid_contracts'],
					'bid_percentage' => $coin_meta[0]['bid_percentage'],
					'ask_contract' => $coin_meta[0]['ask_contract'],
					'ask_percentage' => $coin_meta[0]['ask_percentage'],
					'great_wall_quantity' => $coin_meta[0]['great_wall_quantity'],
					'great_wall' => $coin_meta[0]['great_wall'],
					'seven_level_depth' => $coin_meta[0]['seven_level_depth'],
				);
			}

		}
		/*==============================Black Wall Pressure==========================================*/
		$black_wall_array = array_column($res['downs'], 'black_wall_pressure');
		$average_black_wall = array_sum($black_wall_array) / count($black_wall_array);
		$max_black_wall_pressure = max($black_wall_array);
		$min_black_wall_pressure = min($black_wall_array);
		$returnArr['downs']['black_wall_pressure'] = array(
			'avg' => $average_black_wall,
			'max' => $max_black_wall_pressure,
			'min' => $min_black_wall_pressure,
		);
		/*==============================End Black Wall Pressure=======================================*/

		/*==============================Yellow Wall Pressure==========================================*/
		$yellow_wall_array = array_column($res['downs'], 'yellow_wall_pressure');
		$average_yellow_wall = array_sum($yellow_wall_array) / count($yellow_wall_array);
		$max_yellow_wall_pressure = max($yellow_wall_array);
		$min_yellow_wall_pressure = min($yellow_wall_array);

		$returnArr['downs']['yellow_wall_pressure'] = array(

			'avg' => $average_yellow_wall,
			'max' => $max_yellow_wall_pressure,
			'min' => $min_yellow_wall_pressure,
		);
		/*==============================End Yellow Wall Pressure=======================================*/

		/*================================Depth Pressure===============================================*/
		$depth_array = array_column($res['downs'], 'depth_pressure');
		$average_depth = array_sum($depth_array) / count($depth_array);
		$max_depth_pressure = max($depth_array);
		$min_depth_pressure = min($depth_array);

		$returnArr['downs']['depth_pressure'] = array(
			'avg' => $average_depth,
			'max' => $max_depth_pressure,
			'min' => $min_depth_pressure,
		);
		/*==============================End Depth Pressure=======================================*/

		/*================================Bid Contracts==========================================*/
		$bid_contracts_arr = array_column($res['downs'], 'bid_contracts');
		$average_bids = array_sum($bid_contracts_arr) / count($bid_contracts_arr);
		$max_bids = max($bid_contracts_arr);
		$min_bids = min($bid_contracts_arr);

		$returnArr['downs']['bid_contracts'] = array(
			'avg' => $average_bids,
			'max' => $max_bids,
			'min' => $min_bids,
		);
		/*==============================End Bid Contracts========================================*/

		/*================================Ask Contracts==========================================*/
		$ask_contracts_arr = array_column($res['downs'], 'ask_contract');
		$average_asks = array_sum($ask_contracts_arr) / count($ask_contracts_arr);
		$max_asks = max($ask_contracts_arr);
		$min_asks = min($ask_contracts_arr);

		$returnArr['downs']['ask_contract'] = array(
			'avg' => $average_asks,
			'max' => $max_asks,
			'min' => $min_asks,
		);
		/*==============================End Ask Contracts========================================*/

		/*================================Bid Contracts==========================================*/
		$bid_percentage_arr = array_column($res['downs'], 'bid_percentage');
		$average_bids_per = array_sum($bid_percentage_arr) / count($bid_percentage_arr);
		$max_bids_per = max($bid_percentage_arr);
		$min_bids_per = min($bid_percentage_arr);
		$returnArr['downs']['bid_percentage'] = array(
			'avg' => $average_bids_per,
			'max' => $max_bids_per,
			'min' => $min_bids_per,
		);
		/*==============================End Bid Contracts========================================*/

		/*================================Ask Contracts==========================================*/
		$ask_percentage_arr = array_column($res['downs'], 'ask_percentage');
		$average_asks_per = array_sum($ask_percentage_arr) / count($ask_percentage_arr);
		$max_asks_per = max($ask_percentage_arr);
		$min_asks_per = min($ask_percentage_arr);

		$returnArr['downs']['ask_percentage'] = array(
			'avg' => $average_asks_per,
			'max' => $max_asks_per,
			'min' => $min_asks_per,
		);
		/*==============================End Ask Contracts========================================*/

		/*================================Great Wall==========================================*/
		$great_wall_array = array_column($res['downs'], 'great_wall_quantity');
		$great_wall_avg = array_sum($great_wall_array) / count($great_wall_array);
		$max_great_wall = max($great_wall_array);
		$min_great_wall = min($great_wall_array);

		$returnArr['downs']['great_wall'] = array(
			'avg' => $great_wall_avg,
			'max' => $max_great_wall,
			'min' => $min_great_wall,
		);
		/*==============================End Great Wall========================================*/

		/*================================Great Wall==========================================*/
		$seven_level_array = array_column($res['downs'], 'seven_level_depth');
		$seven_level_avg = array_sum($seven_level_array) / count($seven_level_array);
		$max_seven_level = max($seven_level_array);
		$min_seven_level = min($seven_level_array);

		$returnArr['downs']['seven_level_depth'] = array(
			'avg' => $seven_level_avg,
			'max' => $max_seven_level,
			'min' => $min_seven_level,
		);

		//////////////////////////////////////////////////////////////////////////////////
		/*					Calculate Up/Down Percentage								*/
		//////////////////////////////////////////////////////////////////////////////////
		$search_arr3['coin'] = $coin_symbol;
		$datetime = date("Y-m-d H:i:s", strtotime("-7 days"));
		$search_arr3['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($datetime));
		$search_arr3['barrier_type'] = array('$in' => array('up', 'down'));
		$this->mongo_db->where($search_arr3);
		$this->mongo_db->order_by(array('_id' => 1));
		$get3 = $this->mongo_db->get('barrier_values_collection');
		$pre_res3 = iterator_to_array($get3);

		for ($i = 0; $i < count($pre_res3); $i++) {
			$barrier_1 = $pre_res3[$i]['barier_value'];
			$barrier_2 = $pre_res3[$i + 1]['barier_value'];

			$barrier_1_type = $pre_res3[$i]['barrier_type'];
			$barrier_2_type = $pre_res3[$i + 1]['barrier_type'];
			if ($barrier_1_type != $barrier_2_type && ($i < (count($pre_res3) - 1))) {
				$barrier_per[] = number_format(((($barrier_1 - $barrier_2) / $barrier_1) * 100), 2);

			}
		}

		echo "<pre>";
		print_r($barrier_per);
		print_r($pre_res3);
		exit;

		$data['up_indicators'] = $returnArr['ups'];
		$data['down_indicators'] = $returnArr['downs'];
		$data['coins'] = $this->mod_coins->get_all_coins();
		$this->stencil->paint('admin/coin_meta/listing_indicator', $data);
	}

}
