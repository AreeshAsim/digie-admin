<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sockets extends CI_Controller {

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
		$this->load->model('admin/mod_sockets');

		$this->mod_login->verify_is_admin_login();
		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}
	}

	public function index() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}

		$count_market_depth = $this->mod_sockets->count_market_depth();
		$data['count_market_depth'] = $count_market_depth;

		$count_market_trade = $this->mod_sockets->count_market_trade();
		$data['count_market_trade'] = $count_market_trade;

		$count_candle_stick_records = $this->mod_sockets->count_candle_stick_records();
		$data['count_candle_stick_records'] = $count_candle_stick_records;

		$count_candle_stick_repeating = $this->mod_sockets->count_candle_stick_repeating();
		$data['count_candle_stick_repeating'] = $count_candle_stick_repeating;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/settings/binance_statistics', $data);
	}

	public function autoload_binance_statistics() {
		$count_market_depth = $this->mod_sockets->count_market_depth();

		$count_market_trade = $this->mod_sockets->count_market_trade();

		$count_candle_stick_records = $this->mod_sockets->count_candle_stick_records();
		$count_candle_stick_repeating = $this->mod_sockets->count_candle_stick_repeating();

		echo number_format($count_market_depth) . "|" . number_format($count_market_trade) . "|" . number_format($count_candle_stick_records) . "|" . number_format($count_candle_stick_repeating);
		exit;

	} //end autoload_binance_statistics

	public function delete_market_depth_socket() {

		$this->mod_sockets->delete_market_depth_socket();

		echo "1";
		exit;
	}

	public function delete_market_trade_socket() {

		$this->mod_sockets->delete_market_trade_socket();

		echo "1";
		exit;
	}

	public function delete_candle_socket() {

		$this->mod_sockets->delete_candle_socket();

		echo "1";
		exit;
	}

	public function delete_candle_repeat() {

		$this->mod_sockets->delete_candle_repeat();

		echo "1";
		exit;
	}

}
