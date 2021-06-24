<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

    public function __construct() {

        parent::__construct();

        // Load Modal
        $this->load->model('admin/mod_users');
        $this->load->model('admin/mod_dashboard');
    }

    public function index() {
        $time_zone_arr = $this->mod_dashboard->get_time_zone();
        $data['time_zone_arr'] = $time_zone_arr;
        $this->load->view('admin/signup/signup', $data);
    }

    public function run_test($username = "coolvan44@outlook.com") {
        $upd_arr['password'] = md5("digiebot@2018");
        $search['email_address'] = $username;

        $this->mongo_db->where($search);
        $this->mongo_db->set($upd_arr);
        $this->mongo_db->update("users");
    }

    public function signup_process() {

        //Check User
        $security_code = $this->input->post('security_code');

        if ($security_code != 'crypto_trading@2019') {

            $data_arr['form-data'] = $this->input->post();
            $this->session->set_userdata($data_arr);

            $this->session->set_flashdata('err_message', 'Security Code is wrong, please try again.');
            redirect(base_url() . 'admin/signup');

        } else {

            $this->session->unset_userdata('form-data');

            //User Signup
            $user_signup = $this->mod_users->user_signup($this->input->post());

            if ($user_signup) {

                $this->session->set_flashdata('ok_message', 'Your account has been created successfully. pleaes login below');
                redirect(base_url() . 'admin/login');

            } else {

                $this->session->set_flashdata('err_message', 'You are not registered. Something went wrong, please try again.');
                redirect(base_url() . 'admin/signup');

            } //end if

        }

    } //end public function login_process()

    public function add_users_digiebot() {

        $rawData = file_get_contents("php://input");
        $data = (array) json_decode($rawData);

        // // Response return from ongage
        // $post_data = print_r($data, true);
        // $data1 = $post_data;
        // $fp = fopen('shahzaddddd.txt', 'a') or exit("Unable to open file!");
        // fwrite($fp, $data1);
        // fclose($fp);
        // //User Signup
        // exit;
        $user_signup = $this->mod_users->add_users_digiebot_from_report($data);

        echo  $user_signup;  exit;

    } //end public function add_users_digiebot()
	
	
	 public function get_users_exists() {
	
        $rawData = file_get_contents("php://input");
        $data    = (array) json_decode($rawData);
		
        // Response return from ongage
        // $post_data = print_r($data, true);
        // $data1 = $post_data;
        // $fp = fopen('shahzaddddd.txt', 'a') or exit("Unable to open file!");
        // fwrite($fp, $data1);
        // fclose($fp);
        // exit;
        $user_signup = $this->mod_users->report_user_email_exists($data);
		
		if($user_signup){
			echo $user_signup ;  exit;
		}else{
		    echo 0;  exit;	
		}
    } //end public function add_users_digiebot()
	
	
	
	
	
	

    public function activate($user_id, $activation_code) {

        //Account Activation
        $account_activation = $this->mod_users->account_activation($user_id, $activation_code);

        if ($account_activation) {

            $this->session->set_flashdata('ok_message', 'Your account has been Activated, please login here');
            redirect(base_url() . 'admin/login');

        } else {

            $this->session->set_flashdata('err_message', 'Your not Activated. Something went wrong, please try again.');
            redirect(base_url() . 'admin/login');

        } //end if

    }

    public function check_user_info() {
        if ($this->input->post('user_name')) {
            $name = $this->input->post('user_name');

            //$this->db->dbprefix('users');
            $this->mongo_db->where(array('username' => $name));
            $res = $this->mongo_db->get('users');
            $row = iterator_to_array($res);

            if (count($row) > 0) {
                echo "<div class='alert alert-danger alert-dismissable'>Username already Exist</div>" . "@@" . "0";
                exit;
            } else {
                echo "" . "@@" . "1";
                exit;
            }
        }

        if ($this->input->post('user_email')) {
            $email = $this->input->post('user_email');

            $this->mongo_db->where(array('email_address' => $email));
            $res = $this->mongo_db->get('users');
            $row = iterator_to_array($res);

            if (count($row) > 0) {
                echo "<div class='alert alert-danger alert-dismissable'>Email already Exist</div>" . "@@" . "0";
                exit;
            } else {
                echo "" . "@@" . "1";
                exit;
            }
        }
    }

}
