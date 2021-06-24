<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_coins extends CI_Controller {


	public function __construct()
     {

		parent::__construct();


		//load main template
		$this->stencil->layout('admin_layout2');

		//load required slices
		$this->stencil->slice('admin_header_script2');
		$this->stencil->slice('admin_header2');
		$this->stencil->slice('admin_left_sidebar2');
		$this->stencil->slice('admin_footer_script2');

		// Load Modal
		$this->load->model('admin/mod_login');
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_user_coins');

	}


	public function index()
	{
		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Fetching coins Record
		$coins_arr = $this->mod_user_coins->get_all_user_coins();
		$data['coins_arr'] = $coins_arr;


		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/user_coins/coins',$data);

	}//End index


	public function add_coin()
	{
		
	
		//Login Check
		$this->mod_login->verify_is_admin_login();
	    $coins_arr = $this->mod_user_coins->get_all_coins();
	    // print_r($coins_arr); exit;
		$new_symbol = array_column($coins_arr, 'symbol');
		$data['coins_arr'] = $new_symbol;
		$data['all_coins_arr'] = $this->mod_coins->get_all_coins();

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin2/coins/add_user_coin',$data);

	}//End add_coin
	
	
	public function updateUserCoin(){
	
		$coinsArr   =  $this->input->post('checkedVal');
	    $coin_id = $this->mod_user_coins->add_coin($coinsArr);
		
		echo json_encode($coin_id);
		exit;
	  
	} //updateUserCoin
	


	public function add_coin_process(){

        
		
		//Login Check
		$this->mod_login->verify_is_admin_login();

		//Adding add_coin
		$coin_id = $this->mod_user_coins->add_coin($this->input->post());

		if($coin_id){

			$this->session->set_flashdata('ok_message', 'Coin added successfully.');
			redirect(base_url().'admin/user_coins/add-coin');

		}else{

			$this->session->set_flashdata('err_message', 'Coin cannot added. Something went wrong, please try again.');
			redirect(base_url().'admin/user_coins/add-coin');

		}//end if

	}//end add_coin_process


	public function edit_coin($coin_id)
	{
		//Login Check
		$this->mod_login->verify_is_admin_login();


		//Fetching coin Record
		$coin_arr = $this->mod_user_coins->get_coin($coin_id);
		$data['coin_arr'] = $coin_arr;
		$data['coin_id'] = $coin_id;


		$this->stencil->paint('admin/user_coins/edit_coin',$data);

	}//End edit_coin


	public function edit_coin_process(){

		//Login Check
		$this->mod_login->verify_is_admin_login();

		//edit_coin
		$coin_id = $this->mod_user_coins->edit_coin($this->input->post());

		if($coin_id){

			redirect(base_url().'admin/user_coins/edit-coin/'.$coin_id);

		}else{

			redirect(base_url().'admin/user_coins/edit-coin/'.$coin_id);

		}//end if

	}//end edit_coin_process


	public function delete_coin(){
           
		exit('1');
		//Login Check
		$this->mod_login->verify_is_admin_login();
		//Delete coin
		$delete_coin = $this->mod_user_coins->delete_coin($coin_id);

		echo json_encode($delete_coin);
		exit;

	}//end delete_coin


}
