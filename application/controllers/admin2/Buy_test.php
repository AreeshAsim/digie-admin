<?php
/**
 *
 */
class Buy_test extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('admin/mod_login');
		$this->load->model('admin/mod_users');
		$this->load->model('admin/mod_dashboard');
		$this->load->model('admin/mod_market');
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_buy_orders');
		$this->load->model('admin/mod_candel');
		$this->load->model('admin/mod_realtime_candle_socket');
		$this->load->model('admin/mod_box_trigger_3');
	}

	public function index() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		if ($this->input->post()) {

			$data_arr['filter-data-buy'] = $this->input->post();
			$this->session->set_userdata($data_arr);
			redirect(base_url() . 'admin/buy_orders/');
		}
		$filled_orders = array();
		$new_orders = array();
		$error_orders = array();
		$cancelled = array();
		$submitted = array();
		$open_trades = array();
		$sold_trades = array();
		$parent_arr = array();
		$skip = 0;
		$limit = 20;
		$return_data = $this->mod_buy_orders->get_buy_orders($skip, $limit);

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
				if (!empty($value['price'])) {
					$new_orders[] = $value;
				} else {
					$parent_arr[] = $value;
				}
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

		/*if ($_SERVER['REMOTE_ADDR'] == "101.50.127.200") {
			echo "<pre>";
			print_r($new_orders);
			exit;
		}*/
		$data['orders_arr'] = $orders_arr;
		$data['filled_arr'] = $filled_orders;
		$data['parent_arr'] = $parent_arr;
		$data['new_arr'] = $new_orders;
		$data['cancelled_arr'] = $cancelled;
		$data['error_arr'] = $error_orders;
		$data['submitted'] = $submitted;
		$data['open_trades'] = $open_trades;
		$data['sold_trades'] = $sold_trades;

		$id = $this->session->userdata('admin_id');
		$global_symbol = $this->session->userdata('global_symbol');
		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_user_coins($id);
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
		$this->load->view('admin/buy_order/index', $data);
	}
}