<?php

/**
 * 
 */
class Save_curl extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/mod_sockets');
		$this->load->library('binance_api');
	}
	public function index()
	{
		exit("hello");
	}
	// public function save_error_to_db()
	// {
		
	// 	$symbol = $this->input->post('symbol');
	// 	$type = $this->input->post('type');
	// 	$timestamp = $this->input->post('timestamp');
		

	// 	$ins_data = array(
	// 		'symbol' => $symbol,
	// 		'timestamp' => $timestamp,
	// 		'status' => 1,
	// 		'type' => $type
	// 	);
	// 	$this->db->dbprefix('socket_close_track');
	// 	$insert = $this->db->insert('socket_close_track',$ins_data);

	// }

	// public function test()
	// {
    //     $case_one = false;
    //     $case_two = false;
    //     if($case_two || $case_one)
    //     {
    //        echo  "yes";

    //     }else{

    //         echo "no";
    //     }
 	// }

 /*	public function test()
 	{
 		$arr = $this->mod_sockets->check_socket_track("market_trade","NCASHBTC");

 		echo "<pre>";
 		print_r($arr);
 		exit;


 	}*/
}