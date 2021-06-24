<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Binance_api{

	function __construct($param)
	{
		
	}

	public function get_api()
	{
		$CI =& get_instance();
		require 'binance_class/autoload.php';

		//Get User Settings
		$user_id = $CI->session->userdata('admin_id');
		$CI->db->dbprefix('settings');
        $CI->db->where('user_id', $user_id);
		$get_settings = $CI->db->get('settings');

		//echo $this->db->last_query();
		$settings_arr = $get_settings->row_array();
		$api_key = $settings_arr['api_key'];
		$api_secret = $settings_arr['api_secret'];

		$api = new Binance\API($api_key, $api_secret, ['useServerTime'=>true]);

		return $api;
		
	}//get_api


	public function user_testing()
	{

		$api = $this->get_api();

		$balance_update = function($api, $balances) {
			print_r($balances);
			echo "Balance update".PHP_EOL;
			exit;
		};

		$order_update = function($api, $report) {
			echo "Order update".PHP_EOL;
			print_r($report);
			$price = $report['price'];
			$quantity = $report['quantity'];
			$symbol = $report['symbol'];
			$side = $report['side'];
			$orderType = $report['orderType'];
			$orderId = $report['orderId'];
			$orderStatus = $report['orderStatus'];
			$executionType = $report['orderStatus'];
			if ( $executionType == "NEW" ) {
				if ( $executionType == "REJECTED" ) {
					echo "Order Failed! Reason: {$report['rejectReason']}".PHP_EOL;
				}
				echo "{$symbol} {$side} {$orderType} ORDER #{$orderId} ({$orderStatus})".PHP_EOL;
				echo "..price: {$price}, quantity: {$quantity}".PHP_EOL;
				return;
			}
			//NEW, CANCELED, REPLACED, REJECTED, TRADE, EXPIRED
			echo "{$symbol} {$side} {$executionType} {$orderType} ORDER #{$orderId}".PHP_EOL;
			exit;
		};
		$api->userData($balance_update, $order_update);

	}


	public function place_buy_limit_order($symbol,$quantity,$price)
	{

		$api = $this->get_api();

		//Place a LIMIT order
		$price_formated =number_format($price,8,'.','');
		$order = $api->buy($symbol, $quantity, $price_formated);

		return $order;
		
	}//place_buy_limit_order


	public function place_sell_limit_order($symbol,$quantity,$price)
	{

		$api = $this->get_api();

		//Place a LIMIT order
		$price_formated =number_format($price,8,'.','');
		$order = $api->sell($symbol, $quantity, $price_formated);

		return $order;
		
	}//place_sell_limit_order


	public function place_buy_market_order($symbol,$quantity)
	{

		$api = $this->get_api();

		//Place a Market order
		$order = $api->marketBuy($symbol, $quantity);

		return $order;
		
	}//place_buy_market_order


	public function place_sell_market_order($symbol,$quantity)
	{

		$api = $this->get_api();

		//Place a Market order
		$order = $api->marketSell($symbol, $quantity);

		return $order;
		
	}//place_sell_market_order


	public function cancel_order($symbol,$order_id)
	{

		$api = $this->get_api();

		//Cancel Order
		$response = $api->cancel($symbol, $order_id);

		return $response;
		
	}//cancel_order


	public function order_status($symbol, $order_id)
	{

		$api = $this->get_api();

		//Get Order Status
		$orderstatus = $api->orderStatus($symbol, $order_id);

		return $orderstatus;
		
	}//order_status


	public function get_all_orders($symbol)
	{

		$api = $this->get_api();

		//Get All Orders
		$orders = $api->orders($symbol);

		return $orders;
		
	}//get_all_orders



	public function get_market_prices()
	{

		require 'binance_class/autoload.php';

		$api = new Binance\API("PyA8BGGQmDyB33193xrFZly5kHHrdsW3gvraAFgd5IicYDDh5Z03w8L6D08TiaXz", "VAtJFRZwtGZvMe0EZitQsGYX5T9l6lwEs1yLfBr0HGLTqGXsVCQoCIuOa2aqBy2I", ['useServerTime'=>true]);


		//Get latest price of a symbol
		$ticker = $api->prices();

		return $ticker;
		
	}/*End get_market_prices*/


	/*get_candelstick*/
	public function get_candelstick(){
		
           require 'binance_class/autoload.php';

			$api = new Binance\API("PyA8BGGQmDyB33193xrFZly5kHHrdsW3gvraAFgd5IicYDDh5Z03w8L6D08TiaXz", "VAtJFRZwtGZvMe0EZitQsGYX5T9l6lwEs1yLfBr0HGLTqGXsVCQoCIuOa2aqBy2I", ['useServerTime'=>true]);

			$coin_symbol = 'BNBBTC';
			$periods = '1m';

			//Periods: 1m,3m,5m,15m,30m,1h,2h,4h,6h,8h,12h,1d,3d,1w,1M
			$ticks = $api->candlesticks($coin_symbol, $periods);

			$index  = 0; 
			$arrrNew = [];
			if(count($ticks)>0){

				foreach ($ticks as $key => $value) {

					if($index>910 && $index<1000){
					   $arrrNew[] = $value;
					}
					$index++;
				}
			}


			return $arrrNew;

	}/*End */
	
}
