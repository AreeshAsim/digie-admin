<?php
/**
 *
 */
class Bitcoin_balance extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->mod_login->verify_is_admin_login();
		$this->load->library('binance_api');
		$symbol = "BTC";
		$balance = $this->binance_api->get_bitcoin_balance($symbol);
		echo $balance;
		exit;
	}
}
?>