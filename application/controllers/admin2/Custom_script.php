<?php
/**
 *
 */
class Custom_script extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {

	}

	public function seven_level_pressure_sell($symbol) {
		$this->mongo_db->where('coin', $symbol);

		$res = $this->mongo_db->get('coin_meta');

		$res_arr = iterator_to_array($res);

		$seven_level_depth = $res_arr[0]['seven_level_depth'];

		$seven_level_type = $res_arr[0]['seven_level_type'];

		if ($seven_level_type == 'negitive') {
			$value = "-" . $seven_level_depth;
		} else {
			$value = $seven_level_depth;
		}
		$value = (float) $value;
		echo $value;
		exit;
	}

	public function is_big_trade($symbol) {

		$this->mongo_db->where('coin', $symbol);

		$res = $this->mongo_db->get('coin_meta');

		$res_arr = iterator_to_array($res);

		$ask_trades = $res_arr[0]['ask_contract'];

		$bid_trades = $res_arr[0]['bid_contracts'];

		return array(
			'ask_trades' => $ask_trades,
			'bid_trades' => $bid_trades,
		);
	}

	public function testing($order_id) {

		$this->mongo_db->where(array('_id' => $order_id));
		$res = $this->mongo_db->delete('buy_orders');
		echo "<pre>";
		print_r($res);
		exit;
	}

	public function get_order_history_log() {
		$start_date11 = date('Y-m-d H:i:s', strtotime('2018-09-10 10:00:00'));
		$start_date = $this->mongo_db->converToMongodttime($start_date11);

		$end_date11 = date('Y-m-d H:i:s', strtotime('2018-09-10 11:59:59'));
		$end_date = $this->mongo_db->converToMongodttime($end_date11);
		//$this->mongo_db->where('coin', 'NCASHBTC');
		$this->mongo_db->where_gte('created_date', $start_date);
		$this->mongo_db->where_lte('created_date', $end_date);
		$this->mongo_db->sort(array('_id' => 'desc'));
		//$this->mongo_db->limit(100);
		$responseArr = $this->mongo_db->get('orders_history_log');
		echo "<pre>";
		print_r(iterator_to_array($responseArr));
		exit;
	} //End get_order_history_log
}