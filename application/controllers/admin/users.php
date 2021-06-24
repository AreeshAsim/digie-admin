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


        $admin_id = $this->session->userdata('admin_id');

        if ($this->session->userdata('special_role') != 1 && $this->session->userdata('admin_id') != '5c3a4986fc9aad6bbd55b4f2') {
            redirect(base_url() . 'forbidden');
        }

        if ($this->input->post()) {
            $data_arr['filter_user_data'] = $this->input->post();
            $this->session->set_userdata($data_arr);
            redirect(base_url() . 'admin/users/');
        }
        //Fetching users Record
        $count = $this->mod_users->count_all_users();
        $this->load->library('pagination');
        /*********************************************************************************************************************************************/
        $config['base_url'] = SURL . 'admin/users/index';
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

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $start = ($page - 1) * $config["per_page"];

        $data['pagination'] = $this->pagination->create_links();
        /*********************************************************************************************************************************************/
        $users_arr = $this->mod_users->get_all_users($start, $config['per_page']);
        $data['users_arr'] = $users_arr;



        //stencil is our templating library. Simply call view via it
        $this->stencil->paint('admin/users/users', $data);

    } //End index

    public function csvreport() {

        $usersArr = $this->mod_users->getAllUsersForCsv();

        foreach ($usersArr as $row) {

            $finalArr['First Name'] = $row['first_name'];
            $finalArr['Last Name'] = $row['last_name'];
            $finalArr['Username'] = $row['username'];
            $finalArr['Email Address'] = $row['email_address'];
            $finalArr['Phone Number'] = $row['phone_number'];
            $finalArr['Application Mode'] = $row['application_mode'];
            $finalArr['Status'] = ($row['status'] == 0) ? 'Active' : 'InActive';
            $finalArr['User Role'] = ($row['user_role'] == 1) ? 'Role 1' : ' Other Role';
            $finalArr['Special Role'] = ($row['special_role'] == 1) ? 'Yes' : 'NO';
            $finalArr['Registeration Date'] = date('d, M Y g:i a', strtotime($row['created_date_human']));
            $finalArr['Trading IP'] = $row['trading_ip'];
            $finalArr['Last Login'] = date('d, M Y g:i a', strtotime($row['last_login_datetime']));
            $finalArrAll[] = $finalArr;
        }
        if ($finalArrAll) {

            $filename = ("Users :" . date("Y-m-d Gis") . ".csv");
            // Set the Headers for csv
            $now = gmdate("D, d M Y H:i:s");
            header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
            header("Last-Modified: {$now} GMT");
            header('Content-Type: text/csv;');
            header("Pragma: no-cache");
            header("Expires: 0");
            // force download
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");

            // disposition / encoding on response body
            header("Content-Disposition: attachment;filename={$filename}");
            header("Content-Transfer-Encoding: binary");
            echo $this->array2csv($finalArrAll);
        } //if($order_Array){
        exit;
    } //csvreport

    // public function array2csv($array) {

    //     if (count($array) == 0) {
    //         return null;
    //     }
    //     ob_start();
    //     $df = fopen("php://output", 'w');
    //     fputcsv($df, array_keys((array) reset($array)));

    //     foreach ($array as $key => $row) {
    //         //$rowNew  =  htmlspecialchars(trim(strip_tags($row)));
    //         fputcsv($df, (array) $row);
    //     }
    //     fclose($df);
    //     return ob_get_clean();
    // } //array2csv

    public function reset_filters($type = '') {
        //Login Check
        $this->mod_login->verify_is_admin_login();
        $this->session->unset_userdata('filter_user_data');
        redirect(base_url() . 'admin/users');

    } //End reset_buy_filters
    public function add_user() {
        //Login Check
        $this->mod_login->verify_is_admin_login();
        if ($this->session->userdata('user_role') != 1) {
            redirect(base_url() . 'forbidden');
        }
        //stencil is our templating library. Simply call view via it
        $this->stencil->paint('admin/users/add_user');

    } //End add_user

    public function contact_us_process() {

        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData);
        //Adding contact_us_process
        $InsertData = $this->mod_users->contact_us_process($data);
        if ($InsertData) {
            $json_array['success'] = true;
            $json_array['userData'] = '';
        } else {
            $json_array['success'] = false;
            $json_array['userData'] = 'Error';
        }
        echo json_encode($json_array);
        exit;

    } //end add_user_process

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

    // public function edit_role($user_id, $role_id) {
    //     $this->mod_login->verify_is_admin_login();
    //     if ($this->session->userdata('user_role') != 1) {
    //         redirect(base_url() . 'forbidden');
    //     }

    //     //Fetching user Record
    //     $user_arr = $this->mod_users->update_user_role($user_id, $role_id);
    //     redirect(base_url() . 'admin/users');
    // }

    // public function edit_status($user_id, $role_id) {
    //     $this->mod_login->verify_is_admin_login();
    //     if ($this->session->userdata('user_role') != 1) {
    //         redirect(base_url() . 'forbidden');
    //     }

    //     //Fetching user Record
    //     $user_arr = $this->mod_users->update_user_status($user_id, $role_id);
    //     redirect(base_url() . 'admin/users');
    // }

    // public function edit_user_process() {

    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();
    //     if ($this->session->userdata('user_role') != 1) {
    //         redirect(base_url() . 'forbidden');
    //     }
    //     //edit_user
    //     $user_id = $this->mod_users->edit_user($this->input->post());

    //     if ($user_id) {

    //         redirect(base_url() . 'admin/users/edit-user/' . $user_id);

    //     } else {

    //         redirect(base_url() . 'admin/users/edit-user/' . $user_id);

    //     } //end if

    // } //end edit_user_process

    // public function delete_user($user_id) {

    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();
    //     if ($this->session->userdata('user_role') != 1) {
    //         redirect(base_url() . 'forbidden');
    //     }
    //     //Delete user
    //     $delete_user = $this->mod_users->delete_user($user_id);

    //     if ($delete_user) {

    //         $this->session->set_flashdata('ok_message', 'User deleted successfully.');
    //         redirect(base_url() . 'admin/users');

    //     } else {

    //         $this->session->set_flashdata('err_message', 'User can not deleted. Something went wrong, please try again.');
    //         redirect(base_url() . 'admin/users');

    //     } //end if

    // } //end delete_user

    // public function update_application_mode() {
    //     $user_id = $this->input->post('user_id');
    //     $mode = $this->input->post('mode');

    //     $user_arr = $this->mod_users->update_application_mode($user_id, $mode);
    //     redirect(base_url() . 'admin/users');
    // }

    // public function update_trigger_mode() {
    //     $user_id = $this->input->post('user_id');
    //     $mode = $this->input->post('mode');

    //     $user_arr = $this->mod_users->update_trigger_mode($user_id, $mode);
    //     echo "User Updated";
    //     exit;
    // }
    // public function update_app_mode() {
    //     $user_id = $this->input->post('user_id');
    //     $mode = $this->input->post('mode');

    //     $user_arr = $this->mod_users->update_app_mode($user_id, $mode);
    //     echo "User Updated";
    //     exit;
    // }

}//end controller 
