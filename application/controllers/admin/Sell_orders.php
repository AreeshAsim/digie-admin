<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Sell_orders extends CI_Controller {

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
		$this->load->model('admin/mod_market');
		$this->load->model('admin/mod_sell_orders');
		$this->load->model('admin/mod_candel');

	}

	// public function index() {

	// 	//Login Check
	// 	$this->mod_login->verify_is_admin_login();

	// 	if ($this->input->post()) {

	// 		$data_arr['filter-data'] = $this->input->post();
	// 		$this->session->set_userdata($data_arr);
	// 		redirect(base_url() . 'admin/sell_orders');
	// 	}

	// 	//Fetching coins Record
	// 	$coins_arr = $this->mod_coins->get_all_coins();
	// 	$data['coins_arr'] = $coins_arr;

	// 	$global_symbol = $this->session->userdata('global_symbol');

	// 	$filled_orders = array();
	// 	$new_orders = array();
	// 	$error_orders = array();
	// 	$cancelled = array();
	// 	$skip = 0;
	// 	$limit = 20;
	// 	$orders_arr = $this->mod_sell_orders->get_orders($skip, $limit);
	// 	foreach ($orders_arr as $key => $value) {
	// 		if ($value['status'] == 'new') {
	// 			$new_orders[] = $value;
	// 		} elseif ($value['status'] == 'FILLED') {
	// 			$filled_orders[] = $value;
	// 		} elseif ($value['status'] == 'cancelled') {
	// 			$cancelled[] = $value;
	// 		} elseif ($value['status'] == 'error') {
	// 			$error_orders[] = $value;
	// 		}
	// 	}

	// 	$data['orders_arr'] = $orders_arr;
	// 	$data['filled_arr'] = $filled_orders;
	// 	$data['new_arr'] = $new_orders;

	// 	$data['cancelled_arr'] = $cancelled;
	// 	$data['error_arr'] = $error_orders;
	// 	//Get Market Price
	// 	$this->mongo_db->where(array('coin' => $global_symbol));
	// 	$this->mongo_db->limit(1);
	// 	$this->mongo_db->sort(array('_id' => 'desc'));
	// 	$responseArr = $this->mongo_db->get('market_prices');

	// 	foreach ($responseArr as $valueArr) {
	// 		if (!empty($valueArr)) {
	// 			$market_value = $valueArr['price'];
	// 		}
	// 	}

	// 	$data['market_value'] = $market_value;

	// 	//stencil is our templating library. Simply call view via it
	// 	$this->stencil->paint('admin/sell_order/orders_listing', $data);
	// }

	// public function add_order($buy_id = '') {
	// 	//Login Check
	// 	$this->mod_login->verify_is_admin_login();
	// 	//Fetching coins Record
	// 	$coins_arr = $this->mod_coins->get_all_coins();
	// 	$data['coins_arr'] = $coins_arr;

	// 	if ($buy_id != "") {

	// 		//Get Order Record
	// 		$order_arr = $this->mod_dashboard->get_buy_order($buy_id);
	// 		$data['order_arr'] = $order_arr;
	// 		$data['buy_order_check'] = 'yes';

	// 	} else {

	// 		$data['buy_order_check'] = 'no';
	// 	}

	// 	//Get Order History
	// 	if ($buy_id != "") {
	// 		$order_history_arr = $this->mod_dashboard->get_order_history_log($buy_id);
	// 		$data['order_history_arr'] = $order_history_arr;
	// 	}

	// 	$global_symbol = $this->session->userdata('global_symbol');
	// 	$keywords_str = $this->mod_market->get_coin_keywords($global_symbol);
	// 	$keywords = explode(',', $keywords_str);
	// 	$news = $this->mod_market->get_coin_news($keywords);

	// 	$data['news'] = $news;
	// 	//stencil is our templating library. Simply call view via it
	// 	$this->stencil->paint('admin/sell_order/add_order', $data);

	// } //end add_order

	// public function add_order_process() {

	// 	//Login Check
	// 	$this->mod_login->verify_is_admin_login();

	// 	//add_order
	// 	$add_order = $this->mod_dashboard->add_order($this->input->post());

	// 	$buy_order_id = $this->input->post('buy_order_id');
	// 	$buy_order_check = $this->input->post('buy_order_check');

	// 	if ($add_order) {

	// 		$this->session->set_flashdata('ok_message', 'Record added successfully.');
	// 		redirect(base_url() . 'admin/sell_orders/edit-order/' . $add_order);

	// 	} else {

	// 		$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
	// 		redirect(base_url() . 'admin/sell_orders/add-order');

	// 	} //end if

	// } //end add_order_process

	// public function edit_order($id) {
	// 	//Login Check
	// 	$this->mod_login->verify_is_admin_login();
	// 	$global_symbol = $this->session->userdata('global_symbol');
	// 	//Fetching coins Record
	// 	$coins_arr = $this->mod_coins->get_all_coins();
	// 	$data['coins_arr'] = $coins_arr;

	// 	//Get Order Record
	// 	$order_arr = $this->mod_sell_orders->get_order($id);
	// 	if (empty($order_arr)) {
	// 		redirect(base_url('forbidden'));
	// 	}
	// 	$data['order_arr'] = $order_arr;

	// 	//Get Order History
	// 	$order_history_arr = $this->mod_dashboard->get_order_history_log($order_arr['buy_order_id']);

	// 	$buy_orders = $this->updated_data_info($order_arr['buy_order_id']);
		
	// 	$data['info'] = $buy_orders;

	// 	$data['status'] = $buy_orders['status'];

	// 	$data['order_history_arr'] = $order_history_arr;


	// 	$keywords_str = $this->mod_market->get_coin_keywords($global_symbol);
	// 	$keywords = explode(',', $keywords_str);
	// 	$news = $this->mod_market->get_coin_news($keywords);
	// 	$data['news'] = $news;
	// 	//stencil is our templating library. Simply call view via it
	// 	$this->stencil->paint('admin/sell_order/edit_order', $data);

	// } //end edit_order

	// public function edit_order_process() {

	// 	//Login Check
	// 	$this->mod_login->verify_is_admin_login();

	// 	//edit_order
	// 	$edit_order = $this->mod_dashboard->edit_order($this->input->post());

	// 	$id = $this->input->post('id');

	// 	if ($edit_order['error'] != "") {

	// 		$this->session->set_flashdata('err_message', $edit_order['error']);
	// 		redirect(base_url() . 'admin/sell_orders/edit-order/' . $id);
	// 	}

	// 	if ($edit_order) {

	// 		$this->session->set_flashdata('ok_message', 'Record updated successfully.');
	// 		redirect(base_url() . 'admin/sell_orders/edit-order/' . $id);

	// 	} else {

	// 		$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
	// 		redirect(base_url() . 'admin/sell_orders/edit-order/' . $id);

	// 	} //end if

	// } //end edit_order_process

	// public function delete_order($id, $order_id) {

	// 	//Login Check
	// 	$this->mod_login->verify_is_admin_login();

	// 	//delete_order
	// 	$delete_order = $this->mod_dashboard->delete_order($id, $order_id);

	// 	if ($delete_order) {

	// 		$this->session->set_flashdata('ok_message', 'Record deleted successfully.');
	// 		redirect(base_url() . 'admin/sell_orders');

	// 	} else {

	// 		$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
	// 		redirect(base_url() . 'admin/sell_orders');

	// 	} //end if

	// } //end delete_order

	// public function get_order_ajax() {
	// 	$this->load->library("pagination");

	// 	$old_status = $this->input->get('status');
	// 	if ($old_status == 'all') {
	// 		$count = $this->mod_sell_orders->count_all();
	// 	} else {
	// 		$count = $this->mod_sell_orders->count_by_status($old_status);
	// 	}

	// 	$config = array();
	// 	$config["base_url"] = SURL . "admin/sell_orders/get_order_ajax";
	// 	$config["total_rows"] = $count;
	// 	$config['per_page'] = 20;
	// 	$config['num_links'] = 5;
	// 	$config['use_page_numbers'] = TRUE;
	// 	$config['uri_segment'] = 4;
	// 	$config['reuse_query_string'] = TRUE;
	// 	$config["first_tag_open"] = '<li>';
	// 	$config["first_tag_close"] = '</li>';
	// 	$config["last_tag_open"] = '<li>';
	// 	$config["last_tag_close"] = '</li>';
	// 	$config['next_link'] = '&raquo;';
	// 	$config['next_tag_open'] = '<li>';
	// 	$config['next_tag_close'] = '</li>';

	// 	$config['prev_link'] = '&laquo;';

	// 	$config['prev_tag_open'] = '<li>';
	// 	$config['prev_tag_close'] = '</li>';

	// 	$config['first_link'] = 'First';
	// 	$config['last_link'] = 'Last';

	// 	$config['full_tag_open'] = '<ul class="pagination">';
	// 	$config['full_tag_close'] = '</ul>';

	// 	$config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
	// 	$config['cur_tag_close'] = '</b></a></li>';

	// 	$config['num_tag_open'] = '<li>';
	// 	$config['num_tag_close'] = '</li>';

	// 	$this->pagination->initialize($config);
	// 	$page = $this->uri->segment(4);
	// 	$start = ($page - 1) * $config["per_page"];

	// 	if ($old_status == 'all') {

	// 		$return_data = $this->mod_sell_orders->get_orders($start, $config["per_page"]);
	// 		$orders_arr = $return_data;
	// 	} else {
	// 		$return_data = $this->mod_sell_orders->get_orders_by_status($old_status, $start, $config["per_page"]);
	// 		$orders_arr = $return_data;
	// 	}

	// 	$page_links = $this->pagination->create_links();

	// 	$response = '<div class="widget-body padding-none">';

	// 	$response .= '<table class="table table-condensed">
	//                     <thead>
	//                         <tr>
	//                             <th><strong>Coin</strong></th>
	//                             <th><strong>Entry Price</strong></th>
	//                             <th><strong>Exit Price</strong></th>
	//                             <th><strong>Quantity</strong></th>
	//                             <th><strong>Profit Target</strong></th>
	//                             <th><strong>Sell Price</strong></th>
	//                             <th><strong>Trail Price</strong></th>
	//                             <th class="text-center"><strong>P/L</strong></th>
	//                             <th class="text-center"><strong>Status</strong></th>
	//                             <th class="text-center"><strong>Actions</strong></th>
	//                              <th></th>
	//                         </tr>
	//                     </thead>
    //                     <tbody>';
	// 	if (count($orders_arr) > 0) {
	// 		foreach ($orders_arr as $key => $value) {

	// 			//Get Market Price
	// 			$market_value = $this->mod_dashboard->get_market_value($value['symbol']);
	// 			$logo = $this->mod_coins->get_coin_logo($value['symbol']);
	// 			$response .= '<tr>

    //                        <td><img src=' . ASSETS . 'coin_logo/thumbs/' . $logo . ' class="img img-circle" data-toggle="tooltip" data-placement="top" title="' . $value['symbol'] . '"></td>
    //                         <td>' . num($value['purchased_price']) . '</td>
    //                         <td>';
	// 			if ($value['market_value'] != "") {
	// 				$response .= num($value['market_value']);
	// 			}
	// 			$response .= '</td>
    //                         <td>' . $value['quantity'] . '</td>
    //                         <td>';
	// 			if ($value['profit_type'] == 'percentage') {
	// 				$response .= $value['sell_profit_percent'] . "%";
	// 			} else {
	// 				$response .= num($value['sell_profit_price']);
	// 			}
	// 			$response .= '</td>
    //                         <td>' . num($value['sell_price']) . '</td>
    //                         <td>';
	// 			if ($value['trail_check'] == 'yes') {
	// 				$response .= num($value['sell_trail_price']);
	// 			} else {
	// 				$response .= "-";
	// 			}
	// 			$response .= '</td>
    //                         <td class="center">';

	// 			if ($value['status'] != 'new' && $value['status'] != 'error') {

	// 				$market_value111 = num($value['market_value']);

	// 			} else {

	// 				$market_value111 = num($market_value);
	// 			}

	// 			$current_data = $market_value111 - num($value['purchased_price']);
	// 			$market_data = ($current_data * 100 / $market_value111);

	// 			$market_data = number_format((float) $market_data, 2, '.', '');

	// 			if ($market_value111 > $value['purchased_price']) {
	// 				$class = 'success';
	// 			} else {
	// 				$class = 'danger';
	// 			}

	// 			if ($value['profit_type'] == 'percentage') {

	// 				$response .= '<span class="text-' . $class . '"><b>' . $market_data . '%</b></span>';
	// 			} else {

	// 				$response .= '<span class="text-' . $class . '"><b>' . $market_value111 . '</b></span>';
	// 			}

	// 			$response .= '</td>';

	// 			if ($value['status'] == 'error') {
	// 				$status_cls = "danger";
	// 			} else {
	// 				$status_cls = "success";
	// 			}

	// 			$response .= '<td class="center">
    //                         			  <span class="label label-inverse">' . strtoupper($value['application_mode']) . '</span>

    //                         	<span class="label label-' . $status_cls . '">' . strtoupper($value['status']) . '</span>
    //                         	<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
    //                         		<i class="fa fa-refresh" aria-hidden="true"></i>
    //                         	</span>
    //                         </td>

    //                         <td class="center">
    //                             <div class="btn-group btn-group-xs ">';
	// 			if ($value['status'] == 'new' || $value['status'] == 'error') {
	// 				$response .= '<a href="' . SURL . 'admin/sell_orders/edit-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
	// 			}
	// 			if ($value['status'] != 'FILLED') {
	// 				$response .= '<a href="' . SURL . 'admin/sell_orders/delete-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
	// 			}
	// 			if ($value['status'] == 'FILLED') {
	// 				$response .= '<a href="' . SURL . 'admin/sell_orders/edit-order/' . $value['_id'] . '" class="btn btn-success"><i class="fa fa-eye"></i></a>';
	// 			}
	// 			$response .= '</div>
    //                         </td>
    //                         <td class="text-center">';
	// 			if ($value['status'] == 'new') {
	// 				$response .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num($market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Sell Now</button>';
	// 			}
	// 			$response .= '</td> <td class="center">
    //                             <button class="btn btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i class="fa fa-eye"></i></button>
    //                         </td>
    //                         </tr>';
	// 		}
	// 	}
	// 	$response .= '</tbody>
    //                 </table>
    //                 </div>
	// 				    <div class="page_links text-center">' . $page_links . '</div>
	// 			        </div>
	// 			   </div>
	// 			</div>';

	// 	echo $response;
	// 	exit;
	// }

	// public function get_coin_balance() {
	// 	$id = $this->session->userdata('admin_id');
	// 	$post = $this->input->post('symbol');
	// 	if ($post == '') {
	// 		$post = $this->session->userdata('global_symbol');
	// 	}

	// 	$bal = $this->mod_buy_orders->get_balance($post, $id);

	// 	echo $bal;
	// 	exit;
	// }

	// public function reset_filters($type) {

	// 	$this->session->unset_userdata('filter-data');
	// 	redirect(base_url() . 'admin/sell_orders');

	// } //End reset_buy_filters

	// public function get_all_counts() {
	// 	$count_all = $this->mod_sell_orders->count_all();

	// 	$status = 'FILLED';
	// 	$count_filled = $this->mod_sell_orders->count_by_status($status);

	// 	$status = 'new';
	// 	$count_new = $this->mod_sell_orders->count_by_status($status);

	// 	$status = 'canceled';
	// 	$count_canceled = $this->mod_sell_orders->count_by_status($status);
	// 	$status = 'error';
	// 	$count_error = $this->mod_sell_orders->count_by_status($status);

	// 	echo $count_new . "|" . $count_filled . "|" . $count_canceled . "|" . $count_error . "|" . $count_all;
	// 	/*echo "1|2|3|4|5|6|7|8";*/
	// 	exit;
	// } //End get_all_counts

	// public function sell_trigger_1_process() {

	// 	$buy_orders_arr = $this->mod_dashboard->get_buy_orders_trigger_by_1();

	// 	$response_arr = [];

	// 	if (count($buy_orders_arr) > 0) {

	// 		foreach ($buy_orders_arr as $buy_orders_row) {

	// 			$coin_symbol = $buy_orders_row['symbol'];
	// 			$market_value = $this->mod_dashboard->get_market_value($coin_symbol);

	// 			$date = date('Y-m-d H:00:00', strtotime('-0 hour'));

	// 			$res = $this->mongo_db->get('buy_trigger_1_process_log');
	// 			$result_log = iterator_to_array($res);

	// 			$count_log = 0;
	// 			if (count($result_log)) {
	// 				$start_time = $result_log[0]['date'];

	// 				$date = date('Y-m-d H:00:00', strtotime('+1 hour', strtotime($start_time)));

	// 			}

	// 			echo $date . '<br>';

	// 			/////////////////
	// 			/////////////////

	// 			$candle_type = '';

	// 			$res = $this->mongo_db->get('buy_trigger_1_process_log');
	// 			$result_log = iterator_to_array($res);
	// 			$count_log = 0;
	// 			if (count($result_log)) {

	// 				$count_log = $result_log[0]['count'];
	// 				$count_log = $count_log + 1;
	// 			}

	// 			$upd_array = array('date' => $date, 'count' => $count_log);

	// 			$this->mongo_db->set($upd_array);
	// 			$this->mongo_db->update('buy_trigger_1_process_log');

	// 			//////////////////////
	// 			//////////////////////

	// 			$sell_trigger_result = $this->mod_candel->sell_trigger_1($coin_symbol, $date);

	// 			$quantity = $buy_orders_row['quantity'];
	// 			$coin_symbol = $buy_orders_row['symbol'];

	// 			$order_id = $buy_orders_row['_id'];
	// 			$order_type = $buy_orders_row['order_type'];

	// 			$buy_price = $buy_orders_row['price'];

	// 			$buy_market_value = $buy_orders_row['market_value'];
	// 			$buy_part = $buy_orders_row['buy_part'];
	// 			$trigger_type = $buy_orders_row['trigger_type'];
	// 			$admin_id = $buy_orders_row['admin_id'];

	// 			$trigger_type = $buy_orders_row['trigger_type'];

	// 			$iniatial_trail_stop = $buy_orders_row['iniatial_trail_stop'];

	// 			if (count($sell_trigger_result) > 0) {

	// 				if ($sell_trigger_result['reponse_result']) {

	// 					$candle_type = 'Demand Supply';

	// 					$sell_part_one = $sell_trigger_result['sell_part_1'];
	// 					$sell_part_two = $sell_trigger_result['sell_part_2'];
	// 					$sell_part_three = $sell_trigger_result['sell_part_3'];

	// 					//||

	// 					$status = 'FILLED';

	// 					if ($buy_part == 'one') {

	// 						$sell_success = false;

	// 						if (($market_value >= $sell_part_one) && ($sell_part_one >= $buy_price)) {

	// 							$sell_order_rule = $trigger_type;
	// 							$this->mod_dashboard->add_sell_order_by_triggers($coin_symbol, $buy_price, $quantity, $sell_part_one, $market_value, $iniatial_trail_stop, $status, $admin_id, $order_id, $trigger_type, $sell_order_rule);

	// 							$response_arr['message'] = 'part one selled successfully';
	// 							$sell_success = true;

	// 							$this->update_buy_status_to_sold($order_id);

	// 						} else if ($market_value <= $iniatial_trail_stop) {

	// 							$sell_order_rule = 'by_stop_loss';

	// 							$this->mod_dashboard->add_sell_order_by_triggers($coin_symbol, $buy_price, $quantity, $iniatial_trail_stop, $market_value, $iniatial_trail_stop, $status, $admin_id, $order_id, $trigger_type, $sell_order_rule);

	// 							$response_arr['message'] = 'by_stop_loss selled successfully';
	// 							$sell_success = true;
	// 							$this->update_buy_status_to_sold($order_id);
	// 						}

	// 					} //End of part One

	// 					if ($buy_part == 'two') {

	// 						if (($market_value >= $sell_part_two) && ($sell_part_two >= $buy_price)) {

	// 							$sell_order_rule = $trigger_type;
	// 							$this->mod_dashboard->add_sell_order_by_triggers($coin_symbol, $buy_price, $quantity, $sell_part_two, $market_value, $iniatial_trail_stop, $status, $admin_id, $order_id, $trigger_type, $sell_order_rule);

	// 							$response_arr['message'] = 'part one selled successfully';
	// 							$sell_success = true;
	// 							$this->update_buy_status_to_sold($order_id);

	// 						} else if ($market_value <= $iniatial_trail_stop) {

	// 							$sell_order_rule = 'by_stop_loss';

	// 							$this->mod_dashboard->add_sell_order_by_triggers($coin_symbol, $buy_price, $quantity, $iniatial_trail_stop, $market_value, $iniatial_trail_stop, $status, $admin_id, $order_id, $trigger_type, $sell_order_rule);

	// 							$response_arr['message'] = 'by_stop_loss selled successfully';
	// 							$sell_success = true;
	// 							$this->update_buy_status_to_sold($order_id);
	// 						}

	// 					} //End of part One

	// 					if ($buy_part == 'three') {

	// 						if (($market_value >= $sell_part_three) && ($sell_part_three >= $buy_price)) {

	// 							$sell_order_rule = $trigger_type;
	// 							$this->mod_dashboard->add_sell_order_by_triggers($coin_symbol, $buy_price, $quantity, $sell_part_three, $market_value, $iniatial_trail_stop, $status, $admin_id, $order_id, $trigger_type, $sell_order_rule);

	// 							$response_arr['message'] = 'part one selled successfully';
	// 							$sell_success = true;
	// 							$this->update_buy_status_to_sold($order_id);

	// 						} else if ($market_value <= $iniatial_trail_stop) {

	// 							$sell_order_rule = 'by_stop_loss';

	// 							$this->mod_dashboard->add_sell_order_by_triggers($coin_symbol, $buy_price, $quantity, $iniatial_trail_stop, $market_value, $iniatial_trail_stop, $status, $admin_id, $order_id, $trigger_type, $sell_order_rule);

	// 							$response_arr['message'] = 'by_stop_loss selled successfully';
	// 							$sell_success = true;
	// 							$this->update_buy_status_to_sold($order_id);
	// 						}

	// 					} //End of part One

	// 					if (!$sell_success) {

	// 						$response_arr['message'] = 'Trigger is not match the requirement';
	// 					}

	// 				} else {

	// 					$response_arr['message'] = 'Trigger is not match the requirement';
	// 				}

	// 			} else {

	// 				$response_arr['message'] = 'No candel Found for sell';
	// 			}

	// 		}

	// 	} else {
	// 		$response_arr['message'] = 'No Order Found';
	// 	}

	// 	$upd_array = array('message' => $response_arr['message'], 'candle_type_supply' => $candle_type);
	// 	$this->mongo_db->set($upd_array);
	// 	$this->mongo_db->update('buy_trigger_1_process_log');

	// 	$res = $this->mongo_db->get('buy_trigger_1_process_log');
	// 	$result_log = iterator_to_array($res);
	// 	$look_forward = 0;
	// 	if (count($result_log)) {
	// 		$look_forward = $result_log[0]['look_forward'];
	// 	}

	// 	if ($count_log < $look_forward) {
	// 		$this->sell_trigger_1_process();
	// 	}

	// 	return $response_arr;

	// } //End of sell_trigger_1_process

	// public function update_buy_status_to_sold($order_id) {

	// 	$upd_data = array(
	// 		'status' => 'sold',
	// 	);

	// 	$this->mongo_db->where(array('_id' => $order_id));
	// 	$this->mongo_db->set($upd_data);

	// 	//Update data in mongoTable
	// 	$this->mongo_db->update('buy_orders');

	// } //End of update_buy_status_to_sold

	// public function test() {

	// 	$insert_array = array('count' => 1, 'date' => '2018-04-09 16:00:00');
	// 	$this->mongo_db->set($insert_array);
	// 	$this->mongo_db->update('sell_trigger_1_process_log');

	// 	$this->mongo_db->insert('sell_trigger_1_process_log', $insert_array);

	// 	$res = $this->mongo_db->get('sell_trigger_1_process_log');

	// 	$result = iterator_to_array($res);

	// 	echo '<pre>';
	// 	print_r($result);
	// 	exit();
	// }

	// public function sell_by_loss_stop() {

	// } //End sell_by_loss_stop

	// public function updated_data_info($buy_id) {
	// 	$this->mongo_db->where(array('_id' => $buy_id));
	// 	$res_obj = $this->mongo_db->get('buy_orders');
	// 	$res = iterator_to_array($res_obj);
	// 	$row = array();
	// 	if(count($res)>0){
			
	// 		$new_arr = array('stop_loss' => $res[0]['iniatial_trail_stop'], 'target_sell' => $res[0]['market_sold_price'],'market_heighest_value'=>$res[0]['market_heighest_value'],'market_lowest_value'=>$res[0]['market_lowest_value'],'5_hour_max_market_price'=>$res[0]['5_hour_max_market_price'],'5_hour_min_market_price'=>$res[0]['5_hour_min_market_price']);

	// 		$fl_arr = (array)$res[0];
	// 		$full = array_merge($new_arr,$fl_arr);
	// 		return $full; 
	// 	}else{
	// 		$this->mongo_db->where(array('_id' => $buy_id));
	// 		$res_obj = $this->mongo_db->get('sold_buy_orders');
	// 		$res = iterator_to_array($res_obj);

	// 		$arr = array('stop_loss' => $res[0]['iniatial_trail_stop'], 'target_sell' => $res[0]['market_sold_price'],'market_heighest_value'=>$res[0]['market_heighest_value'],'market_lowest_value'=>$res[0]['market_lowest_value'],'5_hour_max_market_price'=>$res[0]['5_hour_max_market_price'],'5_hour_min_market_price'=>$res[0]['5_hour_min_market_price']);
	// 		$fl_arr = (array)$res[0];
	// 		$full = array_merge($arr,$fl_arr);
	// 		return $full; 
	// 	}
		
	// }

}
