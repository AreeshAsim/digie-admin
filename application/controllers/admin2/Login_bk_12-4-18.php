<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->view('admin/login/login');
	}
	
	
	public function login_process(){
	
		if(!$this->input->post()) redirect(base_url());		
		
		$username = trim($this->input->post('username'));
		$password = trim($this->input->post('password'));
		
		
		if($username=="" || $password=="" ){
			
			$this->session->set_flashdata('err_message', 'Username or Password is empty');
			redirect(base_url().'admin/login');	
		  
		}else{

			$this->load->model('admin/mod_login');
			
			$chk_isvalid_user = $this->mod_login->validate_credentials($this->input->post('username'),$this->input->post('password'));
		
			if($chk_isvalid_user){

				//Fetching coins Record
				$this->load->model('admin/mod_coins');
				$coins_arr = $this->mod_coins->get_all_coins();
				$coin_symbol = $coins_arr[0]['symbol'];


				//Check user Settings
				$user_id = $chk_isvalid_user['id'];
				$this->db->dbprefix('settings');
		        $this->db->where('user_id', $user_id);
				$get_settings = $this->db->get('settings');

				//echo $this->db->last_query();
				$settings_arr = $get_settings->row_array();

				if(count($settings_arr)>0){
					$check_api_settings = 'yes';
				}else{
					$check_api_settings = 'no';
				}
				
				
				$login_sess_array = array(
					'logged_in' => true,
					'admin_id' => $chk_isvalid_user['id'],
					'first_name'	=>	$chk_isvalid_user['first_name'],
					'last_name'	=>	$chk_isvalid_user['last_name'],
					'username'	=>	$chk_isvalid_user['username'],
					'profile_image'	=>	$chk_isvalid_user['profile_image'],
					'email_address'	=>	$chk_isvalid_user['email_address'],
					'check_api_settings' =>	$check_api_settings,
					'global_symbol'	=>	$coin_symbol
					);
			
				$this->session->set_userdata($login_sess_array);
				
				//Update Signin Date
				//$this->mod_login->update_signin_date($chk_isvalid_user['id']);

				redirect(base_url().'admin/dashboard');
				
			}else{

				$this->session->set_flashdata('err_message', 'Invalid Username or Password');
				redirect(base_url().'admin/login');
				
			}//end if($chk_isvalid_user) 
			
		} //end if($username=="" || $password=="" )
		
	}//end public function login_process()
	
}
