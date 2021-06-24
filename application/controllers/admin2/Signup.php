<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

	public function __construct()
     {

		parent::__construct();

		// Load Modal
		$this->load->model('admin/mod_users');
		$this->load->model('admin/mod_dashboard');
	}


	public function index()
	{
		$time_zone_arr         = $this->mod_dashboard->get_time_zone();
		$data['time_zone_arr'] = $time_zone_arr;
		$this->load->view('admin/signup/signup', $data);
	}



	public function signup_process(){

		//Check User
		$security_code = $this->input->post('security_code');

		if($security_code !='kulaparty@2018'){

			$data_arr['form-data'] = $this->input->post();
			$this->session->set_userdata($data_arr);

			$this->session->set_flashdata('err_message', 'Security Code is wrong, please try again.');
			redirect(base_url().'admin/signup');

		}else{

			$this->session->unset_userdata('form-data');

			//User Signup
			$user_signup = $this->mod_users->user_signup($this->input->post());

			if($user_signup){

				$this->session->set_flashdata('ok_message', 'Your account has been created successfully. pleaes login below');
				redirect(base_url().'admin/login');

			}else{

				$this->session->set_flashdata('err_message', 'You are not registered. Something went wrong, please try again.');
				redirect(base_url().'admin/signup');

			}//end if

		}


	}//end public function login_process()



	 public function activate($user_id,$activation_code){

		//Account Activation
	  	$account_activation = $this->mod_users->account_activation($user_id,$activation_code);

		if($account_activation){

			$this->session->set_flashdata('ok_message', 'Your account has been Activated, please login here');
			redirect(base_url().'admin/login');

		}else{

			$this->session->set_flashdata('err_message', 'Your not Activated. Something went wrong, please try again.');
			redirect(base_url().'admin/login');

		}//end if

     }


     public function check_user_info()
     {
     	if ($this->input->post('user_name')) {
     		$name = $this->input->post('user_name');

     		$this->db->dbprefix('users');
     		$this->db->where('username',$name);
     		$res = $this->db->get('users');
     		$row = $res->result_array();

     		if (count($row) > 0) {
     			echo "<div class='alert alert-danger alert-dismissable'>Username already Exist</div>"."@@"."0";
     			exit;
     		}else{
     			echo ""."@@"."1";
     			exit;
     		}
     	}

     	if ($this->input->post('user_email')) {
     		$email = $this->input->post('user_email');
     		$this->db->dbprefix('users');
     		$this->db->where('email_address',$email);
     		$res = $this->db->get('users');
     		$row = $res->result_array();

     		if (count($row) > 0) {
     			echo "<div class='alert alert-danger alert-dismissable'>Email already Exist</div>"."@@"."0";
     			exit;
     		}else{
     			echo ""."@@"."1";
     			exit;
     		}
     	}
     }


}
