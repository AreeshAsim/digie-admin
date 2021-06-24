<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_market_depth extends CI_Controller {
	public function __construct()
     {
		
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
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_chart_market_depth');
		
	}
	public function index()
	{
		$symbol = $this->session->userdata('global_symbol');
		$depth_ask = $this->mod_chart_market_depth->get_market_ask_depth($symbol);
		$depth_bid = $this->mod_chart_market_depth->get_market_bid_depth($symbol);
		array_multisort( array_column($depth_ask, "price"), SORT_ASC, $depth_ask );
		array_multisort( array_column($depth_bid, "price"), SORT_ASC, $depth_bid );
		$data['depth_ask'] = $depth_ask;
		$data['depth_bid'] = $depth_bid;
		$this->stencil->paint('admin/market_depth_chart/market_depth_chart',$data);
	}
	
}
