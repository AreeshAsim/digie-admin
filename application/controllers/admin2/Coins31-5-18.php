<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coins extends CI_Controller {
	
	
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
		
	}
	

	public function index()
	{
		//Login Check
		$this->mod_login->verify_is_admin_login();
		
		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_coins();
		$data['coins_arr'] = $coins_arr;
		
	    
		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/coins/coins',$data);
		
	}//End index
	
	
	public function add_coin()
	{
		//Login Check
		$this->mod_login->verify_is_admin_login();
	    
		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/coins/add_coin');
		
	}//End add_coin
	
	
	public function add_coin_process(){
		
		//Login Check
		$this->mod_login->verify_is_admin_login();
		
		//Adding add_coin
		$coin_id = $this->mod_coins->add_coin($this->input->post());

		if($coin_id){		
			
			$this->session->set_flashdata('ok_message', 'Coin added successfully.');
			redirect(base_url().'admin/coins/add-coin');
			
		}else{
				
			$this->session->set_flashdata('err_message', 'Coin cannot added. Something went wrong, please try again.');
			redirect(base_url().'admin/coins/add-coin');
			
		}//end if

	}//end add_coin_process
	
	
	public function edit_coin($coin_id)
	{
		//Login Check
		$this->mod_login->verify_is_admin_login();
		
		
		//Fetching coin Record
		$coin_arr = $this->mod_coins->get_coin($coin_id);
		$data['coin_arr'] = $coin_arr;
		$data['coin_id'] = $coin_id;
		
	    
		$this->stencil->paint('admin/coins/edit_coin',$data);
		
	}//End edit_coin
	
	
	public function edit_coin_process(){
		
		//Login Check
		$this->mod_login->verify_is_admin_login();
		
		//edit_coin
		$coin_id = $this->mod_coins->edit_coin($this->input->post());
		
		if($coin_id){		
			
			redirect(base_url().'admin/coins/edit-coin/'.$coin_id);
			
		}else{
				
			redirect(base_url().'admin/coins/edit-coin/'.$coin_id);
			
		}//end if

	}//end edit_coin_process
	
	
	public function delete_coin($coin_id){
		
		//Login Check
		$this->mod_login->verify_is_admin_login();
		
		//Delete coin
		$delete_coin = $this->mod_coins->delete_coin($coin_id);
	
		if($delete_coin){		
			
			$this->session->set_flashdata('ok_message', 'coin deleted successfully.');
			redirect(base_url().'admin/coins');
			
		}else{
			
			$this->session->set_flashdata('err_message', 'coin can not deleted. Something went wrong, please try again.');
			redirect(base_url().'admin/coins');
			
		}//end if

	}//end delete_coin

	public function create_thumbnail()
	{
		$error = 0;
		$userfile = $_FILES['image']['tmp_name']; 
		$userfile_name = $_FILES['image']['name']; 
		$userfile_size = $_FILES['image']['size']; 
		$userfile_type = $_FILES['image']['type']; 
		/////////////////////////  
		//GET-DECLARE DIMENSIONS // 
		$dimension = getimagesize($userfile); 

		$large_width = $dimension[0]; // GET PHOTO WIDTH 
		$large_height = $dimension[1]; //GET PHOTO HEIGHT 
		$small_width = 30; // DECLARE THUMB WIDTH 
		$small_height = 30; // DECLARE THUMB HEIGHT 

		//////////////////////////////// 
		// CHECK TYPE (IE AND OTHERS) // 

		if ($userfile_type="image/jpeg"){ 
		    if ($userfile_type!="image/jpeg"){ 
		       $error=1; 
		       $msg = "The photo must be JPG"; 
		    } 
		} 

		////////////////////////////// 
		//CHECK WIDTH/HEIGHT // 
		/*if ($large_width!=600 or$large_height!=400){ 
		$error=1; 
		$msg = "The photo must be 600x400 pixels"; 
		} */

		/////////////////////////////////////////// 
		//CREATE THUMB / UPLOAD THUMB AND PHOTO /// 

		if ($error != 1){ 
		     
		    $image = $userfile_name; //if you want to insert it to the database 
		    $pic = imagecreatefromjpeg($userfile); 
		    $small = imagecreatetruecolor($small_width,$small_height); 
		    imagecopyresampled($small,$pic,0,0,0,0, $small_width, $small_height, $large_width, $large_height); 
		    if (imagejpeg($small,$_SERVER["DOCUMENT_ROOT"].'/assets/coin_logo/thumbs/'.$userfile_name, 100)){     
		        $large = imagecreatetruecolor($large_width,$large_height); 
		    imagecopyresampled($large,$pic,0,0,0,0, $large_width, $large_height, $large_width, $large_height); 
		        if (imagejpeg($large,$_SERVER["DOCUMENT_ROOT"].'/assets/coin_logo/'.$userfile_name, 100)) 
		      {		
		      		$msg = $userfile_name;
			  		//$msg .= "<img src ='".SURL."assets/coin_logo/thumbs/".$userfile_name."'>";
			  } 
		           else {$msg="A problem1 has occured. Please try again."; $error=1;} 
		    } 
		    else { 
		      $msg="A problem3 has occured. Please try again."; $error=1; 
		    } 
		} 

		echo $msg; 
		exit;
		////////////////////////////////////////////// 

		/// If everything went right a photo (600x400) and 
		/// a thumb(120x90) were uploaded to the given folders 
	}

	public function test()
	{
		echo $_SERVER["DOCUMENT_ROOT"];
	}
}
