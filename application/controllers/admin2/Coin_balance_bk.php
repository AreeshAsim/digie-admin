<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coin_balance extends CI_Controller {
	
	public function __construct(){
		
		parent::__construct();
		
		// Load Modal
		$this->load->model('admin/mod_balance');
    $this->load->model('admin/mod_coins');
		$this->load->library('binance_api');
		
	}
  public function index()
  {
      $coins = $this->mod_coins->get_all_coins();
      
      foreach ($coins as $coin) {
      $symbol = $coin['symbol'];
      $balance = $this->binance_api->get_account_balance($symbol);

      $upd = $this->mod_balance->update_coin_balance($symbol,$balance);

      if ($upd) {
        echo "Data Updated Successfully";
        echo "<br>";
      }
    }
  }
}
	
