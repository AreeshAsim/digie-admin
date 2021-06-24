<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bitcoin_report extends CI_Controller {

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
        $this->load->model('admin/mod_bitcoin_report');
        $this->load->model('admin/mod_coins');

    }

    // public function show_user_bitcoin() {

   
        //Login Check
        // $this->mod_login->verify_is_admin_login();
        // $per_page = 20;
        // if(isset($_GET['balance']) && $_GET['balance'] ==0){
        //     $per_page = 1000;
        // }

        // $admin_id = $this->session->userdata('admin_id');

        // if ($this->session->userdata('special_role') != 1 && $this->session->userdata('admin_id') != '5c3a4986fc9aad6bbd55b4f2') {
        //     redirect(base_url() . 'forbidden');
        // }

        // if ($this->input->post()) {
        //     $data_arr['filter_bitcoin_report'] = $this->input->post();
        //     $this->session->set_userdata($data_arr);
        //     redirect(base_url() . 'admin/users/');
        // }
        //Fetching users Record
        // $count = $this->mod_bitcoin_report->count_all_users();
        // $this->load->library('pagination');
        // /*********************************************************************************************************************************************/
        // $config['base_url'] = SURL . 'admin/bitcoin_report/show_user_bitcoin';
        // $config['total_rows'] = $count;
        // $config['per_page'] = $per_page;
        // $config['num_links'] = 5;
        // $config['use_page_numbers'] = TRUE;
        // $config['uri_segment'] = 4;
        // $config['reuse_query_string'] = TRUE;
        // $config["first_tag_open"] = '<li>';
        // $config["first_tag_close"] = '</li>';
        // $config["last_tag_open"] = '<li>';
        // $config["last_tag_close"] = '</li>';
        // $config['next_link'] = '&raquo;';
        // $config['next_tag_open'] = '<li>';
        // $config['next_tag_close'] = '</li>';
        // $config['prev_link'] = '&laquo;';
        // $config['prev_tag_open'] = '<li>';
        // $config['prev_tag_close'] = '</li>';
        // $config['first_link'] = 'First';
        // $config['last_link'] = 'Last';
        // $config['full_tag_open'] = '<ul class="pagination">';
        // $config['full_tag_close'] = '</ul>';
        // $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        // $config['cur_tag_close'] = '</b></a></li>';
        // $config['num_tag_open'] = '<li>';
        // $config['num_tag_close'] = '</li>';

        // $this->pagination->initialize($config);

        // $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        // $start = ($page - 1) * $config["per_page"];

        // $data['pagination'] = $this->pagination->create_links();
        /*********************************************************************************************************************************************/
        // $users_arr = $this->mod_bitcoin_report->get_all_users($start, $config['per_page']);
        
        // $full_arr = array();
        // foreach ($users_arr as $row) {
        //     $ID = (string)$row['_id'];
        //     $balance = $this->get_bitcoin_balance($ID);
        //     $row['coin_balance'] = $balance;
        //     if(isset($_GET['balance']) && $_GET['balance'] ==0){
        //         if($balance<=0){
        //             $full_arr[] = $row;
        //         }
        //     }else{
        //         $full_arr[] = $row;
        //     }

            
        // }//End of foreah


        
        

        // $data['users_arr'] = $full_arr;


        //stencil is our templating library. Simply call view via it
        // $this->stencil->paint('admin/users/bit_coin_balance', $data);

    // } //End index

    // public function get_bitcoin_balance($ID){
    //     $this->mongo_db->where(array('user_id'=>$ID,'coin_symbol'=>'BTC'));
    //     $row = $this->mongo_db->get('user_wallet');
    //     $row = iterator_to_array($row);
    //     $balance = 0;
    //     if(!empty($row)){
    //         $balance = ($row[0]['coin_balance'] == '')?0:$row[0]['coin_balance'];

    //     }
    //     return $balance;
    // }//End of get_bitcoin_balance

    // public function reset_filters($type = '') {
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();
    //     $this->session->unset_userdata('filter_bitcoin_report');
    //     redirect(base_url() . 'admin/bitcoin_report/show_user_bitcoin');

    // } //End reset_buy_filters
}
