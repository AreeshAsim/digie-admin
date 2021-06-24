<?php 

/**
 * 
 */
class Order_array extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$this->load->model('admin/mod_coins');
	}

	public function index()
	{
		$symbol = $this->input->post('symbol');

		if (!isset($symbol)) {
			$symbol = 'NCASHBTC';
		}
		$search_Array = array(
			'symbol' => $symbol,
			'status' => 'FILLED',
			'is_sell_order' => 'sold'
		);
		$this->mongo_db->where($search_Array);
		$res = $this->mongo_db->get('buy_orders');
		$final_arr = array();
		$buy_orders_arr = iterator_to_array($res);
		foreach ($buy_orders_arr as $key => $arr) {
			$buy_order_id = $arr['_id'];
			$datetime = $arr['created_date']->toDateTime();
	        $created_date = $datetime->format(DATE_RSS);

	        $datetime = new DateTime($created_date);
	        $datetime->format('Y-m-d g:00:00');

	        $formated_date_time =  $datetime->format('Y-m-d g:00:00');
			$buy_order_date = $formated_date_time;

			$search['buy_order_id'] = $buy_order_id;
			$this->mongo_db->where($search);
			$res_sold = $this->mongo_db->get('orders');
			$sold_order_arr = iterator_to_array($res_sold);

			foreach ($sold_order_arr as $key => $value) {
				$buy_order_price = $value['purchased_price'];
				$sell_order_price = $value['sell_price'];
				$datetime = $value['created_date']->toDateTime();
		        $created_date = $datetime->format(DATE_RSS);

		        $datetime = new DateTime($created_date);
		        $datetime->format('Y-m-d g:00:00');

		        $formated_date_time =  $datetime->format('Y-m-d g:00:00');
				$sell_date = $formated_date_time;

				$final_arr[] = array(
					'buy_date' => $buy_order_date,
					'sell_date' => $sell_date,
					'buy_price' => $buy_order_price,
					'sell_price' => $sell_order_price
				);	 
			}
		}
		echo json_encode($final_arr);
		exit;
	}
}