<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

Class Binance_api {

	function __construct($param = array()) {

	}

	public function get_master_api() {
		$CI = &get_instance();
		require 'binance_class/autoload.php';


		//new created keys
		$api_key    ='rmrpH8YDuTAujVZkSrUEr2NmtOkQTVMXRRg86d4InQBIQxiIlOKWTJ2uSPeT6TQb';
		$api_secret ='Jb7YjdfpOqZqMaKc9QbpOs6tjYrXWMekvlcWvs9QNu32n3jbOgVAGkM8ulY5LkgQ';

		// $api_key = 'h502qVp3O9aHjyFPpJKhLmHYdyPbfSmBErKxHZeTFdqZ6TNG0Bd2H85yFzpuvYIh';
		// $api_secret = 'OVGelESWvaFiTQ2AGw2aZbgwRmYYK8RTPtFnJAbKP2KjMTtC6SdBxvbq5ovkoMpa';


		$api = new Binance\API($api_key, $api_secret, ['useServerTime' => true]);

		return $api;

	} //get_master_api
	
	
	// Ali 11-16 To update the api key 
	public function check_master_api($api_key, $api_secret) {
		
		$CI = &get_instance();
		require 'binance_class/autoload.php';

		//new created keys
		$api_key    = $api_key;
		$api_secret = $api_secret;

		$api = new Binance\API($api_key, $api_secret, ['useServerTime' => true]);

		return $api;

	} //check_master_api
	
	
	

	public function get_api($user_id = '') {
		$CI = &get_instance();
		require 'binance_class/autoload.php';

		//Get User Settings

		if ($user_id == '') {

			$user_id = $CI->session->userdata('admin_id');
		}

		$CI->db->dbprefix('settings');
		$CI->db->where('user_id', $user_id);
		$get_settings = $CI->db->get('settings');

		//echo $this->db->last_query();
		$settings_arr = $get_settings->row_array();

		$api_key = $settings_arr['api_key'];
		$api_secret = $settings_arr['api_secret'];

		$api = new Binance\API($api_key, $api_secret, ['useServerTime' => true]);

		return $api;

	} //get_api

	public function user_testing($user_id) {

		$api = $this->get_api($user_id);

		$balance_update = function ($api, $balances) {
			print_r($balances);
			echo "Balance update" . PHP_EOL;
			exit;
		};

		$order_update = function ($api, $report) {
			echo "Order update" . PHP_EOL;
			print_r($report);
			exit;
			$price = $report['price'];
			$quantity = $report['quantity'];
			$symbol = $report['symbol'];
			$side = $report['side'];
			$orderType = $report['orderType'];
			$orderId = $report['orderId'];
			$orderStatus = $report['orderStatus'];
			$executionType = $report['orderStatus'];
			if ($executionType == "NEW") {
				if ($executionType == "REJECTED") {
					echo "Order Failed! Reason: {$report['rejectReason']}" . PHP_EOL;
				}
				echo "{$symbol} {$side} {$orderType} ORDER #{$orderId} ({$orderStatus})" . PHP_EOL;
				echo "..price: {$price}, quantity: {$quantity}" . PHP_EOL;
				return;
			}
			//NEW, CANCELED, REPLACED, REJECTED, TRADE, EXPIRED
			echo "{$symbol} {$side} {$executionType} {$orderType} ORDER #{$orderId}" . PHP_EOL;
			exit;
		};

		$api->userData($balance_update, $order_update);

	}

	public function accountStatus(){
		$api = $this->get_master_api();
		$Info = $api->accountStatus();
		return $Info;
	}

	public function place_buy_limit_order($symbol, $quantity, $price, $user_id) {

		$api = $this->get_api($user_id);

		//Place a LIMIT order
		$price_formated = number_format($price, 8, '.', '');
		$order = $api->buy($symbol, $quantity, $price_formated);

		return $order;

	} //place_buy_limit_order

	public function exchangeInfo(){

		$api = $this->get_master_api();
		$Info = $api->exchangeInfo();
		return $Info;

	}
	public function checkExchangeInfo($api_key_tr,$api_secret_tr){

		$api = $this->check_master_api($api_key_tr,$api_secret_tr);
		$Info = $api->exchangeInfo();
		return $Info;

	}

	public function place_buy_iceberg_order($symbol, $quantity, $price, $user_id, $icebergQty) {

		$api = $this->get_api($user_id);

		//Place a LIMIT order
		$price_formated = number_format($price, 8, '.', '');
		$flag['icebergQty'] = $icebergQty;
		$type = 'TAKE_PROFIT_LIMIT';
		$order = $api->buy($symbol, $quantity, $price_formated, $type, $flag);

		return $order;

	} //place_buy_iceberg_order

	public function place_buy_take_profit_order($symbol, $quantity, $price, $user_id, $stopPrice) {

		$api = $this->get_api($user_id);

		//Place a LIMIT order
		$price_formated = number_format($price, 8, '.', '');
		$flag['stopPrice'] = $stopPrice;
		$type = 'TAKE_PROFIT_LIMIT';
		$order = $api->buy($symbol, $quantity, $price_formated, $type, $flag);

		return $order;

	} //place_buy_take_profit_order

	public function fire_stop_loss_limit_order($symbol, $quantity, $price, $user_id, $stopPrice){
			$api = $this->get_api($user_id);
			$price_formated = number_format($price, 8, '.', '');
			$stop_price_formated = number_format($stopPrice, 8, '.', '');

			$type = "STOP_LOSS_LIMIT"; // Set the type STOP_LOSS (market) or STOP_LOSS_LIMIT, and TAKE_PROFIT (market) or TAKE_PROFIT_LIMIT
			$order = $api->sell($symbol, $quantity, $price_formated, $type, ["stopPrice"=>$stop_price_formated]);
			return $order; 
	}//End of fire_stop_loss_limit_order


	public function fire_stop_loss_market_order($symbol, $quantity, $price, $user_id, $stopPrice){
		$api = $this->get_api($user_id);
		$price_formated = number_format($price, 8, '.', '');
		$stop_price_formated = number_format($stopPrice, 8, '.', '');
		$type = "STOP_LOSS";
		$order = $api->sell($symbol, $quantity, $price_formated, $type, ["stopPrice"=>$stop_price_formated]);
		return $order; 
}//End of fire_stop_loss_market_order

	public function place_sell_limit_order($symbol, $quantity, $price, $user_id) {

		$api = $this->get_api($user_id);

		//Place a LIMIT order
		$price_formated = number_format($price, 8, '.', '');
		$order = $api->sell($symbol, $quantity, $price_formated);

		return $order;

	} //place_sell_limit_order

	public function place_buy_market_order($symbol, $quantity, $user_id) {

		$api = $this->get_api($user_id);

		//Place a Market order
		$order = $api->marketBuy($symbol, $quantity);

		return $order;

	} //place_buy_market_order

	public function place_sell_market_order($symbol, $quantity, $user_id) {

		$api = $this->get_api($user_id);

		//Place a Market order
		$order = $api->marketSell($symbol, $quantity);

		return $order;

	} //place_sell_market_order

	public function cancel_order($symbol, $order_id, $user_id) {

		$api = $this->get_api($user_id);

		//Cancel Order
		$response = $api->cancel($symbol, $order_id);

		return $response;

	} //cancel_order

	public function order_status($symbol, $order_id, $user_id = '') {

		$api = $this->get_api($user_id);

		//Get Order Status
		$orderstatus = $api->orderStatus($symbol, $order_id);

		return $orderstatus;

	} //order_status

	public function get_all_orders($symbol) {

		$api = $this->get_api();

		//Get All Orders
		$orders = $api->orders($symbol);

		return $orders;

	} //get_all_orders

	public function get_all_orders_history($symbol, $user_id) {

		$api = $this->get_api($user_id);

		//Get All Orders History
		$orders = $api->history($symbol);

		return $orders;

	} //get_all_orders_history

	public function get_market_prices() {

		$api = $this->get_api();

		//Get latest price of a symbol
		$prices = $api->prices();

		return $prices;

	} /*End get_market_prices*/

	/*get_candelstick*/
	public function get_candelstick($coin_symbol = 'BNBBTC', $periods = '1m') {

		$api = $this->get_master_api();

		//Periods: 1m,3m,5m,15m,30m,1h,2h,4h,6h,8h,12h,1d,3d,1w,1M
		$ticks = $api->candlesticks($coin_symbol, $periods);

		$see_back = count($ticks) - 3;

		$index = 0;
		$arrrNew = [];
		if (count($ticks) > 0) {

			foreach ($ticks as $key => $value) {

				if ($index > $see_back && $index <= count($ticks)) {
					$arrrNew[] = $value;
				}
				$index++;
			}
		}

		return $arrrNew;

	} /*End */

	public function get_account_balance($symbol) {

		$api = $this->get_api();

		$balances = $api->balances($symbol);

		$currncy = str_replace('BTC', '', $symbol);
		$account_balance = $balances[$currncy];

		return $account_balance['available'];

	} //End get_account_balance

	public function get_bitcoin_balance($symbol) {

		$api = $this->get_api();

		$balances = $api->balances($symbol);

		//$currncy = str_replace('BTC', '', $symbol);
		$account_balance = $balances[$symbol];

		return $account_balance['available'];

	} //End get_account_balance

}
