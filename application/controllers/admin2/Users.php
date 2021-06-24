<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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
		$this->load->model('admin/mod_coins');

	}

	public function index() {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}

		// if ($this->input->get()) {
		// 	$name = $this->input->get();
		// 	$sess_arr['search_query']['filter_name'] = $name;
		// }
		//Fetching users Record
		$count = $this->mod_users->count_all_users();
		$this->load->library('pagination');
		/*********************************************************************************************************************************************/
		$config['base_url'] = SURL.'admin/users/index';
		$config['total_rows'] = $count;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] = 4;
		$config['reuse_query_string'] = TRUE;
		$config["first_tag_open"] = '<li>';
		$config["first_tag_close"] = '</li>';
		$config["last_tag_open"] = '<li>';
		$config["last_tag_close"] = '</li>';
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
		$config['cur_tag_close'] = '</b></a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4))?$this->uri->segment(4):1;
		$start = ($page - 1) * $config["per_page"];

		$data['pagination'] = $this->pagination->create_links();
		/*********************************************************************************************************************************************/
		$users_arr = $this->mod_users->get_all_users($start, $config['per_page']);
		$data['users_arr'] = $users_arr;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/users/users', $data);

	} //End index

	public function add_user() {
		//Login Check
		$this->mod_login->verify_is_admin_login();
		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}
		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/users/add_user');

	} //End add_user

	public function add_user_process() {

		//Login Check
		$this->mod_login->verify_is_admin_login();
		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}
		//Adding add_user
		$user_id = $this->mod_users->add_user($this->input->post());

		if ($user_id) {

			$this->session->set_flashdata('ok_message', 'User added successfully.');
			redirect(base_url() . 'admin/users/add-user');

		} else {

			$this->session->set_flashdata('err_message', 'User cannot added. Something went wrong, please try again.');
			redirect(base_url() . 'admin/users/add-user');

		} //end if

	} //end add_user_process

	public function edit_user($user_id) {
		//Login Check
		$this->mod_login->verify_is_admin_login();
		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}

		//Fetching user Record
		$user_arr = $this->mod_users->get_user($user_id);
		$data['user_arr'] = $user_arr;
		$data['user_id'] = $user_id;

		$this->stencil->paint('admin/users/edit_user', $data);

	} //End edit_user

	public function edit_role($user_id,$role_id){
		$this->mod_login->verify_is_admin_login();
		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}

		//Fetching user Record
		$user_arr = $this->mod_users->update_user_role($user_id,$role_id);
		redirect(base_url() . 'admin/users');
	}

	public function edit_user_process() {

		//Login Check
		$this->mod_login->verify_is_admin_login();
		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}
		//edit_user
		$user_id = $this->mod_users->edit_user($this->input->post());

		if ($user_id) {

			redirect(base_url() . 'admin/users/edit-user/' . $user_id);

		} else {

			redirect(base_url() . 'admin/users/edit-user/' . $user_id);

		} //end if

	} //end edit_user_process

	public function delete_user($user_id) {

		//Login Check
		$this->mod_login->verify_is_admin_login();
		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}
		//Delete user
		$delete_user = $this->mod_users->delete_user($user_id);

		if ($delete_user) {

			$this->session->set_flashdata('ok_message', 'User deleted successfully.');
			redirect(base_url() . 'admin/users');

		} else {

			$this->session->set_flashdata('err_message', 'User can not deleted. Something went wrong, please try again.');
			redirect(base_url() . 'admin/users');

		} //end if

	} //end delete_user

}
