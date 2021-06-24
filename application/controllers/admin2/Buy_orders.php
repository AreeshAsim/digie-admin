<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/** **/
class Buy_orders extends CI_Controller {

    function __construct() {
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
        $this->load->model('admin/mod_users');
        $this->load->model('admin/mod_dashboard');
        $this->load->model('admin/mod_market');
        $this->load->model('admin/mod_coins');
        $this->load->model('admin/mod_buy_orders');
        $this->load->model('admin/mod_candel');
        $this->load->model('admin/mod_realtime_candle_socket');
        $this->load->model('admin/mod_box_trigger_3');

    }

    public function index() {

        //Login Check
        $this->mod_login->verify_is_admin_login();

        if ($this->input->post()) {

            $data_arr['filter-data-buy'] = $this->input->post();
            $this->session->set_userdata($data_arr);
            redirect(base_url() . 'admin2/buy_orders/');
        }
        $filled_orders = array();
        $new_orders = array();
        $error_orders = array();
        $cancelled = array();
        $submitted = array();
        $open_trades = array();
        $sold_trades = array();
        $parent_arr = array();
        $skip = 0;
        $limit = 20;
        $return_data = $this->mod_buy_orders->get_buy_orders($skip, $limit);

        $orders_arr = $return_data['fullarray'];
        // echo "<pre>";
        // print_r($orders_arr);
        // exit;
        $data['total_buy_amount'] = $return_data['total_buy_amount'];
        $data['total_sell_amount'] = $return_data['total_sell_amount'];
        $data['total_sold_orders'] = $return_data['total_sold_orders'];
        $data['avg_profit'] = $return_data['avg_profit'];

        foreach ($orders_arr as $key => $value) {
            if ($value['status'] == 'new') {
                if (!empty($value['price'])) {
                    $new_orders[] = $value;
                } else {
                    $parent_arr[] = $value;
                }
            } elseif ($value['status'] == 'FILLED') {
                if ($value['is_sell_order'] == 'yes') {
                    $open_trades[] = $value;
                }
                if ($value['is_sell_order'] == 'sold') {
                    $sold_trades[] = $value;
                }

                $filled_orders[] = $value;

            } elseif ($value['status'] == 'canceled') {
                $cancelled[] = $value;
            } elseif ($value['status'] == 'error') {
                $error_orders[] = $value;
            } elseif ($value['status'] == 'submitted') {
                $submitted[] = $value;
                $open_trades[] = $value;
            }
        }

        /*if ($_SERVER['REMOTE_ADDR'] == "101.50.127.200") {
        echo "<pre>";
        print_r($new_orders);
        exit;
        }*/
        $data['orders_arr'] = $orders_arr;
        $data['filled_arr'] = $filled_orders;
        $data['parent_arr'] = $parent_arr;
        $data['new_arr'] = $new_orders;
        $data['cancelled_arr'] = $cancelled;
        $data['error_arr'] = $error_orders;
        $data['submitted'] = $submitted;
        $data['open_trades'] = $open_trades;
        $data['sold_trades'] = $sold_trades;

        $id = $this->session->userdata('admin_id');
        $global_symbol = $this->session->userdata('global_symbol');
        //Fetching coins Record
        $coins_arr = $this->mod_coins->get_all_user_coins($id);
        $data['coins_arr'] = $coins_arr;

        //Get Market Price
        $this->mongo_db->where(array('coin' => $global_symbol));
        $this->mongo_db->limit(1);
        $this->mongo_db->sort(array('_id' => 'desc'));
        $responseArr = $this->mongo_db->get('market_prices');

        foreach ($responseArr as $valueArr) {
            if (!empty($valueArr)) {
                $market_value = $valueArr['price'];
            }
        }

        $data['market_value'] = $market_value;

        //stencil is our templating library. Simply call view via it
        $this->stencil->paint('admin2/buy_order/index', $data);
    }

    public function add_buy_order() {
        //Login Check
        $this->mod_login->verify_is_admin_login();

        $user_id = $this->session->userdata('admin_id');
        $global_symbol = $this->session->userdata('global_symbol');

        //Fetching coins Record
        $coins_arr = $this->mod_coins->get_all_user_coins($user_id);
        $data['coins_arr'] = $coins_arr;

        //Get Market Value
        $market_value = $this->mod_dashboard->get_market_value();
        $data['market_value'] = $market_value;

        //Check Buy Zones
        $check_buy_zones = $this->mod_dashboard->check_buy_zones($market_value);
        $data['in_zone'] = $check_buy_zones['in_zone'];
        $data['type'] = $check_buy_zones['type'];
        $data['start_value'] = $check_buy_zones['start_value'];
        $data['end_value'] = $check_buy_zones['end_value'];

        $keywords_str = $this->mod_market->get_coin_keywords($global_symbol);
        $keywords = explode(',', $keywords_str);
        $news = $this->mod_market->get_coin_news($keywords);
        $data['news'] = $news;

        //stencil is our templating library. Simply call view via it
        $this->stencil->paint('admin2/buy_order/add_buy_order', $data);

    } //end add_buy_order

    /****** Add triggers For Market *****/

    public function add_buy_order_triggers() {
        //Login Check
        $this->mod_login->verify_is_admin_login();

        $user_id = $this->session->userdata('admin_id');
        $global_symbol = $this->session->userdata('global_symbol');

        //Fetching coins Record
        $coins_arr = $this->mod_coins->get_all_user_coins($user_id);

        $data['coins_arr'] = $coins_arr;

        //stencil is our templating library. Simply call view via it
        $this->stencil->paint('admin2/buy_order/add_buy_order_triggers', $data);

    } //end add_buy_order_triggers

    public function add_buy_order_process_trigers() {

        //Login Check
        $this->mod_login->verify_is_admin_login();
        //add_buy_order
        $add_buy_order = $this->mod_dashboard->add_buy_order_triggers($this->input->post());

        if ($add_buy_order) {

            $this->session->set_flashdata('ok_message', 'Order Triggers added successfully.');
            redirect(base_url() . 'admin/buy_orders/add_buy_order_triggers');

        } else {

            $this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
            redirect(base_url() . 'admin/buy_orders/add_buy_order_triggers');

        } //end if

    } //end add_buy_order_process

    public function save_samulation_setting() {
        //Login Check
        $this->mod_login->verify_is_admin_login();
        $date_1 = $this->input->post('date');

        $date = $this->conver_karachi_pakistan_time_zone_to_utc($date_1);
        $look_forward = $this->input->post('look_forward');
        $trigger_type = $this->input->post('select_trigger');

        $this->mongo_db->where('trigger_type', $trigger_type);
        $res = $this->mongo_db->get('buy_trigger_process_log');
        $response_arr = iterator_to_array($res);

        if (count($response_arr) > 0) {

            $upd_array = array('date' => $date, 'count' => 0, 'look_forward' => 1, 'buy_Message' => '', 'sell_Message' => '', 'trigger_type' => $trigger_type);
            $this->mongo_db->where('trigger_type', $trigger_type);
            $this->mongo_db->set($upd_array);
            $this->mongo_db->update('buy_trigger_process_log'); //

        } else {

            $insert_array = array('date' => $date, 'count' => 0, 'look_forward' => 1, 'buy_Message' => '', 'sell_Message' => '', 'trigger_type' => $trigger_type);
            $this->mongo_db->insert('buy_trigger_process_log', $insert_array);
        }

    } //save_samulation_setting

    public function run_trigger_2_auto_sell_and_buy_by_cron_job() {
        $date = date('Y-m-d H:00:00');
        $this->mod_buy_orders->create_buy_orders_by_trigger_2_Live($date);
        $this->mod_buy_orders->sell_order_trigger_2_live($date);
    } //End of run_trigger_2_auto_sell_and_buy_by_cron_job

    public function run() {

        $this->mongo_db->where_in('order_mode', array('test_live', 'live'));
        $this->mongo_db->where_ne('buy_order_status_new_filled', 'wait_for_buyed');
        $this->mongo_db->where(array('status' => 'new', 'trigger_type' => 'trigger_2'));
        $buy_orders_result = $this->mongo_db->get('buy_orders');
        $buy_orders_arr = iterator_to_array($buy_orders_result);
        echo '<pre>';
        print_r($buy_orders_arr);
        exit();

    }

    public function run_triggers_auto_sell_and_buy() {

        $trigger_type = $this->input->post('trigger_type');

        echo '$trigger_type' . $trigger_type;
        exit();

        $coin = $this->input->post('coin');

        $date = date('Y-m-d H:00:00', strtotime('-0 hour'));
        $this->mongo_db->where('trigger_type', $trigger_type);
        $res = $this->mongo_db->get('buy_trigger_process_log');
        $result_log = iterator_to_array($res);
        $count_log = 0;
        if (count($result_log)) {
            $start_time = $result_log[0]['date'];
            $date = date('Y-m-d H:00:00', strtotime('+0 hour', strtotime($start_time)));
        }

        if ($trigger_type == 'trigger_1') {
            $samulater = 'samulater';
            $buy_Message = $this->mod_buy_orders->create_auto_buy_order_using_trigger_1($date, $samulater);
            $sell_message = $this->mod_buy_orders->set_for_sell_order_by_trigger_1($date);

        } else if ($trigger_type == 'trigger_2') {

            $buy_Message = $this->mod_buy_orders->create_buy_orders_by_trigger_2_samulater($date);
            $sell_Message = $this->mod_buy_orders->sell_order_trigger_2_samulater($date);

        } else if ($trigger_type == 'update_candel_type') {

            $buy_Message = $this->mod_realtime_candle_socket->calculate_candel_status_demand_supply($date, $coin);
            $sell_Message = '';
        } else if ($trigger_type == 'box_trigger_3') {
            $order_mode = 'test';
            $this->mod_box_trigger_3->create_box_trigger_3_setting($date, $order_mode);
            $buy_Message = $this->mod_box_trigger_3->create_new_orders_by_Box_Trigger_3_simulator($date);
            $sell_Message = $this->mod_box_trigger_3->sell_order_box_trigger_3_samulater($date);

            $this->mongo_db->where(array('triggers_type' => $trigger_type, 'order_mode' => 'test'));
            $response_obj = $this->mongo_db->get('trigger_global_setting');
            $response_arr = iterator_to_array($response_obj);
            $response = array();
            if (count($response_arr) > 0) {
                $aggressive_stop_rule = $response_arr[0]['aggressive_stop_rule'];
                if ($aggressive_stop_rule == 'stop_loss_rule_2') {
                    $this->mod_box_trigger_3->aggrisive_define_percentage_followup($date);
                }

                $cancel_trade = $response_arr[0]['cancel_trade']; //

                if ($cancel_trade == 'cancel') {
                    //$this->mod_box_trigger_3->cancel_wait_for_buy_orders($date);
                }
            } //End of
        } else if ($trigger_type == 'rg_15') {
            $buy_Message = $this->mod_box_trigger_3->create_new_orders_by_Trigger_rg_15_simulator($date);
            $sell_Message = $this->mod_box_trigger_3->sell_order_trigger_rg_15_samulater($date);

            $this->mongo_db->where(array('triggers_type' => $trigger_type, 'order_mode' => 'test'));
            $response_obj = $this->mongo_db->get('trigger_global_setting');
            $response_arr = iterator_to_array($response_obj);
            $response = array();
            if (count($response_arr) > 0) {
                $aggressive_stop_rule = $response_arr[0]['aggressive_stop_rule'];
                if ($aggressive_stop_rule == 'stop_loss_rule_2') {
                    $this->mod_box_trigger_3->aggrisive_define_percentage_followup($date, $type = '', $trigger_type);
                }
            } //End of
        }

        $this->mongo_db->where('trigger_type', $trigger_type);
        $res = $this->mongo_db->get('buy_trigger_process_log');
        $result_log = iterator_to_array($res);

        $look_forward = 0;
        $count_log = 0;
        if (count($result_log)) {
            $count_log = $result_log[0]['count'];

            $count_log = $count_log + 1;
        }

        $date = date('Y-m-d H:00:00', strtotime('+1 hour', strtotime($date)));

        $this->mongo_db->where('trigger_type', $trigger_type);
        $upd_array = array('date' => $date, 'count' => $count_log, 'sell_Message' => $sell_Message, 'buy_Message' => $buy_Message);
        $this->mongo_db->set($upd_array);

        $this->mongo_db->update('buy_trigger_process_log');

        $look_forward = 0;
        if (count($result_log)) {
            $look_forward = $result_log[0]['look_forward'];
        }

    } //End of  buy_trigger_2

    public function trigger_log_print_ajax() {

        $trigger_type = $this->input->post('trigger_type');
        $this->mongo_db->where('trigger_type', $trigger_type);
        $res = $this->mongo_db->get('buy_trigger_process_log');
        $result_log = iterator_to_array($res);
        $html = '';
        if (count($result_log)) {
            $date = $this->conver_utc_time_zone_to_karachi_pakistan($result_log[0]['date']);
            $html .= '<tr>
			        <td>' . $date . '</td>
			        <td>' . $result_log[0]['trigger_type'] . '</td>

			        <td>' . $result_log[0]['buy_Message'] . '</td>

			        <td>' . $result_log[0]['sell_Message'] . '</td>

			    	<td>' . $result_log[0]['count'] . '</td>
			      </tr>';

        }

        echo $html;
        exit();

    } // trigger_log_print_ajax

    public function buy_sell_trigger_log() {
        $coins = $this->mod_coins->get_all_coins();
        $data['coins'] = $coins;
        $this->stencil->paint('admin/buy_order/buy_sell_trigger_log', $data);

    } //End of buy_sell_trigger_log

    ///////////////////////////
    //////////////////////////
    /////////////////////////
    ////////////////////////
    ////////////////////////

    public function add_buy_order_process() {

        //Login Check
        $this->mod_login->verify_is_admin_login();

        //add_buy_order
        $add_buy_order = $this->mod_dashboard->add_buy_order($this->input->post());

        if ($add_buy_order['error'] != "") {

            $this->session->set_flashdata('err_message', $add_buy_order['error']);
            redirect(base_url() . 'admin/buy_orders/add-buy-order');
        }

        if ($add_buy_order) {

            $this->session->set_flashdata('ok_message', 'Buy Order added successfully.');
            redirect(base_url() . 'admin/buy_orders/add-buy-order');

        } else {

            $this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
            redirect(base_url() . 'admin/buy_orders/add-buy-order');

        } //end if

    } //end add_buy_order_process

    public function edit_buy_order($id) {
        //Login Check
        $this->mod_login->verify_is_admin_login();
        ini_set("memory_limit", -1);
        //Login Check
        $this->mod_login->verify_is_admin_login();

        $user_id = $this->session->userdata('admin_id');
        $global_symbol = $this->session->userdata('global_symbol');

        //Fetching coins Record
        $coins_arr = $this->mod_coins->get_all_user_coins($user_id);
        $data['coins_arr'] = $coins_arr;

        //Get Market Value
        $market_value = $this->mod_dashboard->get_market_value();
        $data['market_value'] = $market_value;

        //Check Buy Zones
        $check_buy_zones = $this->mod_dashboard->check_buy_zones($market_value);
        $data['in_zone'] = $check_buy_zones['in_zone'];
        $data['type'] = $check_buy_zones['type'];
        $data['start_value'] = $check_buy_zones['start_value'];
        $data['end_value'] = $check_buy_zones['end_value'];

        $keywords_str = $this->mod_market->get_coin_keywords($global_symbol);
        $keywords = explode(',', $keywords_str);
        $news = $this->mod_market->get_coin_news($keywords);
        $data['news'] = $news;
        //Get Order Record
        $order_arr = $this->mod_buy_orders->get_buy_order($id);
        $data['order_arr'] = $order_arr;

        //Get Temp Sell Order Record
        $temp_sell_arr = $this->mod_dashboard->get_temp_sell_data($id);
        $data['temp_sell_arr'] = $temp_sell_arr;

        //Get Order History
        $order_history_arr = $this->mod_dashboard->get_order_history_log($id);
        $data['order_history_arr'] = $order_history_arr;

        //stencil is our templating library. Simply call view via it
        $this->stencil->paint('admin/buy_order/edit_buy_order', $data);

    } //end edit_buy_order

    public function edit_buy_order_process() {

        //Login Check
        $this->mod_login->verify_is_admin_login();

        //edit_buy_order
        $edit_buy_order = $this->mod_dashboard->edit_buy_order($this->input->post());

        $id = $this->input->post('id');

        if ($edit_buy_order['error'] != "") {

            $this->session->set_flashdata('err_message', $add_buy_order['error']);
            redirect(base_url() . 'admin/buy_orders/edit-buy-order/' . $id);
        }

        if ($edit_buy_order) {

            $this->session->set_flashdata('ok_message', 'Edit Order updated successfully.');
            redirect(base_url() . 'admin/buy_orders/edit-buy-order/' . $id);

        } else {

            $this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
            redirect(base_url() . 'admin/buy_orders/edit-buy-order/' . $id);

        } //end if

    } //end edit_buy_order_process

    public function edit_buy_trigger_order($id) {
        ini_set("memory_limit", -1);
        //Login Check
        $this->mod_login->verify_is_admin_login();

        $user_id = $this->session->userdata('admin_id');
        $global_symbol = $this->session->userdata('global_symbol');

        //Fetching coins Record
        $coins_arr = $this->mod_coins->get_all_user_coins($user_id);
        $data['coins_arr'] = $coins_arr;

        //Get Order Record
        $order_arr = $this->mod_buy_orders->get_buy_order($id);
        $data['order_arr'] = $order_arr;

        //Get Order History
        $order_history_arr = $this->mod_dashboard->get_order_history_log($id);
        $data['order_history_arr'] = $order_history_arr;

        //stencil is our templating library. Simply call view via it
        $this->stencil->paint('admin/buy_order/edit_buy_order_triggers', $data);
    } //edit_buy_trigger_order

    public function edit_buy_order_process_trigers() {
        //Login Check
        $this->mod_login->verify_is_admin_login();

        //edit_buy_order
        $edit_buy_order = $this->mod_buy_orders->edit_buy_order_triggers($this->input->post());

        $id = $this->input->post('order_id');

        if ($edit_buy_order) {

            $this->session->set_flashdata('ok_message', 'Edit Order updated successfully.');
            redirect(base_url() . 'admin/buy_orders/edit_buy_trigger_order/' . $id);

        } else {

            $this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
            redirect(base_url() . 'admin/buy_orders/edit_buy_trigger_order/' . $id);

        } //end if
    }

    public function delete_buy_order($id, $order_id) {

        //Login Check
        $this->mod_login->verify_is_admin_login();

        //delete_buy_order
        $delete_buy_order = $this->mod_dashboard->delete_buy_order($id, $order_id);

        if ($delete_buy_order) {

            $this->session->set_flashdata('ok_message', 'Record deleted successfully.');
            redirect(base_url() . 'admin/buy_orders');

        } else {

            $this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
            redirect(base_url() . 'admin/buy_orders');

        } //end if

    } //end delete_buy_order

    public function get_order_ajax() {

        $this->load->library("pagination");

        $old_status = $this->input->get('status');

        if ($old_status == 'filled') {
            $status = 'FILLED';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'new') {
            $status = 'new';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'submitted') {
            $status = 'submitted';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'cancelled') {
            $status = 'canceled';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'error') {
            $status = 'error';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'open') {
            $status = 'open';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'sold') {
            $status = 'sold';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'lth') {
            $status = 'lth';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'parent') {
            $status = 'parent';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'all') {
            $count = $this->mod_buy_orders->count_all();
        }

        $config = array();
        $config["base_url"] = SURL . "admin/buy_orders/get_order_ajax";
        $config["total_rows"] = $count;
        $config['per_page'] = 20;
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 4;
        $config['reuse_query_string'] = TRUE;
        $config["first_tag_open"] = '<li class="page-link">';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li class="page-link">';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-link">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-link">';
        $config['prev_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active page-item"><a class="page-link" href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['num_tag_open'] = '<li class="page-link">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $page = $this->uri->segment(4);
        $start = ($page - 1) * $config["per_page"];

        if ($old_status != 'all') {
            if ($old_status == 'sold') {

                $return_data = $this->mod_buy_orders->get_buy_orders_by_status($old_status, $start, $config["per_page"]);
                $orders_arr = $return_data['fullarray'];

            } elseif ($old_status == 'open') {

                $return_data = $this->mod_buy_orders->get_buy_orders_by_status($old_status, $start, $config["per_page"]);
                $orders_arr = $return_data['fullarray'];

            } elseif ($old_status == 'lth') {

                $return_data = $this->mod_buy_orders->get_buy_orders_by_status($old_status, $start, $config["per_page"]);
                $orders_arr = $return_data['fullarray'];

            } elseif ($old_status == 'parent') {

                $return_data = $this->mod_buy_orders->get_buy_orders_by_status($old_status, $start, $config["per_page"]);
                $orders_arr = $return_data['fullarray'];

            } else {
                $return_data = $this->mod_buy_orders->get_buy_orders_by_status($status, $start, $config["per_page"]);
                $orders_arr = $return_data['fullarray'];
            }

        } else {
            $return_data = $this->mod_buy_orders->get_buy_orders($start, $config["per_page"]);
            $orders_arr = $return_data['fullarray'];
        }

        $page_links = $this->pagination->create_links();

        $response = '<table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th><strong>Coin</strong></th>
                                    <th><strong>Price</strong></th>
                                    <th><strong>Order Type</strong></th>
                                    <th><strong>Level</strong></th>
                                    <th><strong>Trail Price</strong></th>
                                    <th><strong>Quantity</strong></th>
                                    <th class="text-center"><strong>P/L</strong></th>
                                    <th class="text-center"><strong>Current Market</strong></th>
                                    <th class="text-center"><strong>Status</strong></th>
                                    <th class="text-center"><strong>Profit(%)</strong></th>
                                    <th class="text-center"><strong>Actions</strong></th>
                                    <th class="text-center"><strong></strong></th>
                                 </tr>
                            </thead>
                        <tbody>';

        if (count($orders_arr) > 0) {
            foreach ($orders_arr as $key => $value) {

                //Get Market Price
                $market_value = $this->mod_dashboard->get_market_value($value['symbol']);

                if ($value['status'] != 'new' && $value['status'] != 'error') {
                    $market_value333 = num((float) $value['market_value']);
                } else {
                    $market_value333 = num((float) $market_value);
                }

                if ($value['status'] == 'new') {
                    $current_order_price = num((float) $value['price']);
                } else {
                    $current_order_price = num((float) $value['market_value']);
                }
                if ($market_value333 == 0) {
                    $market_value333 = 1;
                }
                $current_data = $market_value333 - $current_order_price;
                $market_data = ($current_data * 100 / $market_value333);

                $market_data = number_format((float) $market_data, 2, '.', '');

                if ($market_value333 > $current_order_price) {
                    $class = 'success';
                } else {
                    $class = 'danger';
                }

                $logo = $this->mod_coins->get_coin_logo($value['symbol']);
                if ($value['inactive_status'] == 'inactive' || $value['pause_status'] == 'pause') {
                    $style = "background:#e3e3e3;";
                } else {
                    $style = "";
                }
                $response .= '<tr style="' . $style . '">
                            <td><img src=' . ASSETS . 'coin_logo/thumbs/' . $logo . ' class="img img-circle" data-toggle="tooltip" data-placement="top" title="' . $value['symbol'] . '"></td>';
                if ($value['trigger_type'] != 'no' && $value['price'] == '') {
                    $response .= '<td>' . strtoupper(str_replace('_', ' ', $value['trigger_type'])) . '</td>';
                } else {
                    $response .= '<td>' . num((float) $value['price']) . '</td>';
                }
                if ($value['trigger_type'] == 'no' || $value['trigger_type'] == '') {
                    $response .= '<td> Manual Order</td>';
                } else {
                    $response .= '<td>' . strtoupper(str_replace('_', ' ', $value['trigger_type'])) . '</td>';
                }
                $cls_sty = '';
                if ($value['order_level'] == 'level_1') {
                    $cls_sty = 'style=" color:green;" ';
                }

                $response .= '<td ' . $cls_sty . '>' . $value['order_level'] . '</td>';

                $response .= '<td>';
                if ($value['trail_check'] == 'yes') {
                    $response .= num((float) $value['buy_trail_price']);
                } else {
                    $response .= "-";
                }
                $response .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td  class="text-center"><b>' . num((float) $market_value333) . '</b></td>';

                $response .= '<td  class="text-center"><span class="text-default"><b>' . num((float) $market_value) . '</b></span></td>';

                $response .= '<td  class="text-center">';
                if ($value['inactive_status'] == 'inactive') {
                    $response .= '<span class="badge badge-info">INACTIVE</span>';
                }

                if ($value['status'] == 'FILLED' && $value['is_sell_order'] == 'yes') {

                    $sell_status = $this->mod_buy_orders->is_sell_order_in_error_status($value['sell_order_id']);
                    $sell_status_submit = $this->mod_buy_orders->is_sell_order_in_submitted_status($value['sell_order_id']);

                    if ($sell_status) {
                        $response .= '<span class="badge badge-danger">ERROR IN SELL</span>';
                    } elseif ($sell_status_submit) {
                        $response .= '<span class="badge badge-success">SUBMITTED FOR SELL</span>';
                    } else {
                        $response .= '<span class="badge badge-info">WAITING FOR SELL</span>';
                    }

                } elseif ($value['status'] == 'FILLED' && $value['is_sell_order'] == 'sold') {

                    $response .= '<span class="badge badge-success">Sold</span>';

                } else {

                    if ($value['status'] == 'error') {
                        $status_cls = "danger";
                    } else {
                        $status_cls = "success";
                    }

                    $response .= '<span class="badge badge-' . $status_cls . '">' . strtoupper($value['status']) . '</span>';
                }
                $modified_date = $value['modified_date'];
                $time_ago = $this->time_elapsed_string($modified_date);
                /*$response .= '<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
                <i class="fa fa-refresh" aria-hidden="true"></i>
                 */

                $response .= '<span class="badge badge-default" style="background:#2c2c54!important; color:white; margin-left:4px;">' . $time_ago . '</span>';

                $response .= '</td>

                            <td class="center">';

                if ($value['market_sold_price'] != "") {

                    $market_sold_price = num((float) $value['market_sold_price']);

                    $current_data2222 = $market_sold_price - $current_order_price;
                    $profit_data = ($current_data2222 * 100 / $current_order_price);

                    $profit_data = number_format((float) $profit_data, 2, '.', '');

                    if ($market_sold_price > $current_order_price) {
                        $class222 = 'success';
                    } else {
                        $class222 = 'danger';
                    }

                    $response .= '<span class="text-' . $class222 . '">
                                                <b>' . $profit_data . '%</b>
                                              </span>';
                } else {

                    if ($value['status'] == 'FILLED' || $value['status'] == 'LTH') {

                        if ($value['is_sell_order'] == 'yes' || $value['status'] == 'LTH') {

                            $current_data = num((float) $market_value) - num((float) $value['market_value']);
                            $market_data = ($current_data * 100 / $market_value);

                            $market_data = number_format((float) $market_data, 2, '.', '');

                            if ($market_value > $value['market_value']) {
                                $class = 'success';
                            } else {
                                $class = 'danger';
                            }

                            $response .= '<span class="text-' . $class . '"><b>' . $market_data . '%</b></span>';

                        } else {

                            $response .= '<span class="text-default"><b>-</b></span>';
                        }

                    } else {

                        $response .= '<span class="text-default"><b>-</b></span>';

                    }

                }

                $response .= '</td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
                if ($value['status'] == 'new' || $value['status'] == 'error' || $value['status'] == 'canceled') {
                    $response .= '<a href="' . SURL . 'admin/buy_orders/' . ($value['parent_status'] == 'parent' ? 'edit-buy-trigger-order/' : 'edit-buy-order/') . $value['_id'] . '" class="btn btn-info"><i data-feather="edit"></i></a>';
                }
                /*if ($value['parent_status'] == 'parent') {
                $response .= '<a href="' . SURL . 'admin/buy_orders/edit-buy-trigger-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
                }*/
                if ($value['status'] != 'FILLED' && $value['status'] != 'LTH') {
                    $response .= '<a href="' . SURL . 'admin/buy_orders/delete-buy-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i data-feather="trash"></i></a>';
                }

                if ($value['status'] == 'FILLED') {

                    if ($value['is_sell_order'] == 'yes') {

                        $response .= '<a href="' . SURL . 'admin/sell_orders/edit-order/' . $value['sell_order_id'] . '" class="btn btn-info" target="_blank"><i data-feather="edit"></i></a>';

                        $response .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num((float) $market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '" order_type="' . $value['order_type'] . '"  buy_order_id="' . $value['_id'] . '">Sell Now</button>';

                        $response .= '<button class="btn btn-info make_lth_btn" id="btp_' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num((float) $market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '" order_type="' . $value['order_type'] . '"  buy_order_id="' . $value['_id'] . '">LT Hold</button>';

                    } elseif ($value['is_sell_order'] == 'sold') {
                        $response .= '<a href="' . SURL . 'admin/sell_orders/edit-order/' . $value['sell_order_id'] . '" class="btn btn-success" target="_blank"><i data-feather="eye"></i></a>';
                    } else {
                        $response .= '<a href="' . SURL . 'admin/sell_orders/add-order/' . $value['_id'] . '" class="btn btn-warning" target="_blank">Set For Sell</a>';
                        //$response .= '<button class="btn btn-danger sell_now_btn" id="'.$value['_id'].'" data-id="'.$value['sell_order_id'].'" market_value="'.num((float)$market_value).'" quantity="'.$value['quantity'].'" symbol="'.$value['symbol'].'">Sell Now</button>';
                    }

                } elseif ($value['status'] == "LTH") {
                    $response .= '<a href="' . SURL . 'admin/sell_orders/edit-order/' . $value['sell_order_id'] . '" class="btn btn-info" target="_blank"><i data-feather="edit"></i></a>';

                    $response .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num((float) $market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '" order_type="' . $value['order_type'] . '"  buy_order_id="' . $value['_id'] . '">Sell Now</button>';
                }

                $response .= '</div>
                            </td>



                            <td class="text-center">';
                if ($value['status'] == 'new' && $value['parent_status'] != 'parent') {

                    $response .= '<button class="btn btn-danger btn-xs buy_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num((float) $market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Buy Now</button>';
                }
                if ($value['parent_status'] == 'parent' && ($value['inactive_status'] == '')) {
                    //$response .= '<button class="btn-circle-round inactive_btn" title="Click Here To Inactive this order" id="order_' . $value['_id'] . '" data-id="' . $value['_id'] . '" symbol="' . $value['symbol'] . '"><img src="https://app.digiebot.com/assets/images/states/active.png" width="30px;"></button>';
                    if ($value['pause_status'] == 'pause') {
                        $response .= '<button class="btn btn-success btn-xs play" id="porder_' . $value['_id'] . '" data-id="' . $value['_id'] . '" symbol="' . $value['symbol'] . '"><i data-feather="play-circle"></i></button>';
                    } else {
                        $response .= '<button class="btn btn-default btn-xs pause" id="porder_' . $value['_id'] . '" data-id="' . $value['_id'] . '" symbol="' . $value['symbol'] . '"><i data-feather="pause-circle"></i></button>';
                    }
                } elseif ($value['parent_status'] == 'parent' && ($value['inactive_status'] == 'inactive')) {
                    //$response .= '<button class="btn-circle-round" title="Order is already inactive" disabled="true" id="order_' . $value['_id'] . '" data-id="' . $value['_id'] . '" symbol="' . $value['symbol'] . '"><img src="https://app.digiebot.com/assets/images/states/inactive.png" width="30px;"></button>';
                }
                $response .= '</td><td class="text-center"><button class="btn btn-sm btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i data-feather="eye"></i></button>';
                if ($value['buy_parent_id'] != '' || $value['buy_parent_id'] != NULL) {
                    $response .= '<a href="' . SURL . 'admin/buy_orders/edit-buy-trigger-order/' . $value['buy_parent_id'] . '" target="_blank" class="btn btn-info btn-sm"><i data-feather="link-2"></i></a>';
                }

                if (($value['status'] == 'FILLED' && $value['is_sell_order'] == 'yes')) {
                    if ($this->session->userdata('super_admin_role') == 'super') {
                        $response .= '<button class="btn btn-sm btn-warning admin_edt" id="' . $value['sell_order_id'] . '"><i data-feather="edit-3"></i></button>';
                    }
                }
                if ($sell_status && ($value['status'] == 'FILLED' && $value['is_sell_order'] == 'yes')) {
                    $response .= '<button class="btn btn-sm btn-warning change_error_status" title="Update Error" data-id="' . $value['_id'] . '"><i data-feather="alert-triangle"></i></button>';

                }
                $response .= '</td>
                            </tr>';
            }
        }
        $response .= '</tbody>
                        </table>
                        <div class="page_links text-center">' . $page_links . '</div>
                        </div>
                   </div>
                </div>';

        echo $response;
        exit;
    }

    public function get_order_ajax2() {

        $this->load->library("pagination");

        $old_status = $this->input->get('status');

        if ($old_status == 'filled') {
            $status = 'FILLED';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'new') {
            $status = 'new';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'submitted') {
            $status = 'submitted';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'cancelled') {
            $status = 'canceled';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'error') {
            $status = 'error';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'open') {
            $status = 'open';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'sold') {
            $status = 'sold';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'parent') {
            $status = 'parent';
            $count = $this->mod_buy_orders->count_by_status($status);
        } elseif ($old_status == 'all') {
            $count = $this->mod_buy_orders->count_all();
        }

        $config = array();
        $config["base_url"] = SURL . "admin/buy_orders/get_order_ajax";
        $config["total_rows"] = $count;
        $config['per_page'] = 20;
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 4;
        $config['reuse_query_string'] = TRUE;
        $config["first_tag_open"] = '<li class="page-link">';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li class="page-link">';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-link">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-link">';
        $config['prev_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active page-item"><a class="page-link" href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['num_tag_open'] = '<li class="page-link">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $page = $this->uri->segment(4);
        $start = ($page - 1) * $config["per_page"];

        if ($old_status != 'all') {
            if ($old_status == 'sold') {

                $return_data = $this->mod_buy_orders->get_buy_orders_by_status($old_status, $start, $config["per_page"]);
                $orders_arr = $return_data['fullarray'];

            } elseif ($old_status == 'open') {

                $return_data = $this->mod_buy_orders->get_buy_orders_by_status($old_status, $start, $config["per_page"]);
                $orders_arr = $return_data['fullarray'];

            } elseif ($old_status == 'parent') {

                $return_data = $this->mod_buy_orders->get_buy_orders_by_status($old_status, $start, $config["per_page"]);
                $orders_arr = $return_data['fullarray'];

            } else {
                $return_data = $this->mod_buy_orders->get_buy_orders_by_status($status, $start, $config["per_page"]);
                $orders_arr = $return_data['fullarray'];
            }

        } else {
            $return_data = $this->mod_buy_orders->get_buy_orders($start, $config["per_page"]);
            $orders_arr = $return_data['fullarray'];
        }

        $page_links = $this->pagination->create_links();

        $response = '<table class="table table-condensed">
	                   		<thead>
	                        	<tr>
	                        		<th><strong>Coin</strong></th>
		                            <th><strong>Price</strong></th>
	                        		<th><strong>Order Type</strong></th>
		                            <th><strong>Trail Price</strong></th>
		                            <th><strong>Quantity</strong></th>
		                            <th class="text-center"><strong>P/L</strong></th>
		                            <th class="text-center"><strong>Market(%)</strong></th>
		                            <th class="text-center"><strong>Status</strong></th>
		                            <th class="text-center"><strong>Profit(%)</strong></th>
		                            <th class="text-center"><strong>Actions</strong></th>
		                            <th class="text-center"><strong></strong></th>
	                       		 </tr>
	                    	</thead>
                        <tbody>';

        if (count($orders_arr) > 0) {
            foreach ($orders_arr as $key => $value) {

                //Get Market Price
                $market_value = $this->mod_dashboard->get_market_value($value['symbol']);

                if ($value['status'] != 'new' && $value['status'] != 'error') {
                    $market_value333 = num((float) $value['market_value']);
                } else {
                    $market_value333 = num((float) $market_value);
                }

                if ($value['status'] == 'new') {
                    $current_order_price = num((float) $value['price']);
                } else {
                    $current_order_price = num((float) $value['market_value']);
                }
                if ($market_value333 == 0) {
                    $market_value333 = 1;
                }
                $current_data = $market_value333 - $current_order_price;
                $market_data = ($current_data * 100 / $market_value333);

                $market_data = number_format((float) $market_data, 2, '.', '');

                if ($market_value333 > $current_order_price) {
                    $class = 'success';
                } else {
                    $class = 'danger';
                }

                $logo = $this->mod_coins->get_coin_logo($value['symbol']);
                if ($value['inactive_status'] == 'inactive' || $value['pause_status'] == 'pause') {
                    $style = "background:#fb8585;";
                } else {
                    $style = "";
                }
                $response .= '<tr style="' . $style . '">
                            <td><img src=' . ASSETS . 'coin_logo/thumbs/' . $logo . ' class="img img-circle" data-toggle="tooltip" data-placement="top" title="' . $value['symbol'] . '"></td>';
                if ($value['trigger_type'] != 'no' && $value['price'] == '') {
                    $response .= '<td>' . strtoupper(str_replace('_', ' ', $value['trigger_type'])) . '</td>';
                } else {
                    $response .= '<td>' . num((float) $value['price']) . '</td>';
                }
                if ($value['trigger_type'] == 'no' || $value['trigger_type'] == '') {
                    $response .= '<td> Manual Order</td>';
                } else {
                    $response .= '<td>' . strtoupper(str_replace('_', ' ', $value['trigger_type'])) . '</td>';
                }
                $response .= '<td>';
                if ($value['trail_check'] == 'yes') {
                    $response .= num((float) $value['buy_trail_price']);
                } else {
                    $response .= "-";
                }
                $response .= '</td>
                            <td>' . $value['quantity'] . '</td>
                            <td  class="text-center"><b>' . num((float) $market_value333) . '</b></td>';

                if ($value['is_sell_order'] != 'sold' && $value['is_sell_order'] != 'yes' && $value['status'] != 'error' && $value['status'] != 'new' && $value['parent_status'] != 'parent') {

                    $response .= '<td  class="text-center"><span class="text-' . $class . '"><b>' . $market_data . '%</b></span></td>';

                } else {

                    $response .= '<td  class="text-center"><span class="text-default"><b>-</b></span></td>';
                }

                $response .= '<td  class="text-center">';
                if ($value['inactive_status'] == 'inactive') {
                    $response .= '<span class="badge badge-info">INACTIVE</span>';
                }

                if ($value['status'] == 'FILLED' && $value['is_sell_order'] == 'yes') {

                    $sell_status = $this->mod_buy_orders->is_sell_order_in_error_status($value['sell_order_id']);
                    $sell_status_submit = $this->mod_buy_orders->is_sell_order_in_submitted_status($value['sell_order_id']);

                    if ($sell_status) {
                        $response .= '<span class="badge badge-danger">ERROR IN SELL</span>';
                    } elseif ($sell_status_submit) {
                        $response .= '<span class="badge badge-success">SUBMITTED FOR SELL</span>';
                    } else {
                        $response .= '<span class="badge badge-info">WAITING FOR SELL</span>';
                    }

                } elseif ($value['status'] == 'FILLED' && $value['is_sell_order'] == 'sold') {

                    $response .= '<span class="badge badge-success">Sold</span>';

                } else {

                    if ($value['status'] == 'error') {
                        $status_cls = "danger";
                    } else {
                        $status_cls = "success";
                    }

                    $response .= '<span class="badge badge-' . $status_cls . '">' . strtoupper($value['status']) . '</span>';
                }
                $modified_date = $value['modified_date'];
                $time_ago = $this->time_elapsed_string($modified_date);
                /*$response .= '<span class="custom_refresh" data-id="' . $value['_id'] . '" order_id="' . $value['binance_order_id'] . '">
                <i class="fa fa-refresh" aria-hidden="true"></i>
                 */

                $response .= '<span class="badge badge-defualt" style="background:#2c2c54!important; color:#fff; margin-left:4px;">' . $time_ago . '</span>';

                $response .= '</td>

                            <td class="center">';

                if ($value['market_sold_price'] != "") {

                    $market_sold_price = num((float) $value['market_sold_price']);

                    $current_data2222 = $market_sold_price - $current_order_price;
                    $profit_data = ($current_data2222 * 100 / $current_order_price);

                    $profit_data = number_format((float) $profit_data, 2, '.', '');

                    if ($market_sold_price > $current_order_price) {
                        $class222 = 'success';
                    } else {
                        $class222 = 'danger';
                    }

                    $response .= '<span class="text-' . $class222 . '">
		                        				<b>' . $profit_data . '%</b>
		                        			  </span>';
                } else {

                    if ($value['status'] == 'FILLED') {

                        if ($value['is_sell_order'] == 'yes') {

                            $current_data = num((float) $market_value) - num((float) $value['market_value']);
                            $market_data = ($current_data * 100 / $market_value);

                            $market_data = number_format((float) $market_data, 2, '.', '');

                            if ($market_value > $value['market_value']) {
                                $class = 'success';
                            } else {
                                $class = 'danger';
                            }

                            $response .= '<span class="text-' . $class . '"><b>' . $market_data . '%</b></span>';

                        } else {

                            $response .= '<span class="text-default"><b>-</b></span>';
                        }

                    } else {

                        $response .= '<span class="text-default"><b>-</b></span>';

                    }

                }

                $response .= '</td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
                if ($value['status'] == 'new' || $value['status'] == 'error' || $value['status'] == 'canceled') {
                    $response .= '<a href="' . SURL . 'admin/buy_orders/' . ($value['parent_status'] == 'parent' ? 'edit-buy-trigger-order/' : 'edit-buy-order/') . $value['_id'] . '" class="btn btn-info btn-sm mr-2"><i data-feather="edit"></i></a>';
                }
                /*if ($value['parent_status'] == 'parent') {
                $response .= '<a href="' . SURL . 'admin/buy_orders/edit-buy-trigger-order/' . $value['_id'] . '" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
                }*/
                if ($value['status'] != 'FILLED') {
                    $response .= '<a href="' . SURL . 'admin/buy_orders/delete-buy-order/' . $value['_id'] . '/' . $value['binance_order_id'] . '" class="btn btn-danger btn-sm mr-2" onclick="return confirm(\'Are you sure want to delete?\')"><i data-feather="trash"></i></a>';
                }

                if ($value['status'] == 'FILLED') {

                    if ($value['is_sell_order'] == 'yes') {

                        $response .= '<a href="' . SURL . 'admin/sell_orders/edit-order/' . $value['sell_order_id'] . '" class="btn btn-sm mr-2 btn-info" target="_blank"><i data-feather="edit"></i></a>';

                        $response .= '<button class="btn btn-danger sell_now_btn" id="' . $value['_id'] . '" data-id="' . $value['sell_order_id'] . '" market_value="' . num((float) $market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '" order_type="' . $value['order_type'] . '"  buy_order_id="' . $value['_id'] . '">Sell Now</button>';

                    } elseif ($value['is_sell_order'] == 'sold') {
                        $response .= '<a href="' . SURL . 'admin/sell_orders/edit-order/' . $value['sell_order_id'] . '" class="btn btn-sm mr-2 btn-success" target="_blank"><i data-feather="eye"></i></a>';
                    } else {
                        $response .= '<a href="' . SURL . 'admin/sell_orders/add-order/' . $value['_id'] . '" class="btn btn-warning" target="_blank">Set For Sell</a>';
                        //$response .= '<button class="btn btn-danger sell_now_btn" id="'.$value['_id'].'" data-id="'.$value['sell_order_id'].'" market_value="'.num((float)$market_value).'" quantity="'.$value['quantity'].'" symbol="'.$value['symbol'].'">Sell Now</button>';
                    }

                }

                $response .= '</div>
                            </td>



                            <td class="text-center">';
                if ($value['status'] == 'new' && $value['parent_status'] != 'parent') {

                    $response .= '<button class="btn btn-danger btn-xs buy_now_btn" id="' . $value['_id'] . '" data-id="' . $value['_id'] . '" market_value="' . num((float) $market_value) . '" quantity="' . $value['quantity'] . '" symbol="' . $value['symbol'] . '">Buy Now</button>';
                }
                if ($value['parent_status'] == 'parent' && ($value['inactive_status'] == '')) {
                    // $response .= '<button class="btn btn-inverse btn-xs inactive_btn" id="order_' . $value['_id'] . '" data-id="' . $value['_id'] . '" symbol="' . $value['symbol'] . '">Inactive</button>';
                    if ($value['pause_status'] == 'pause') {
                        $response .= '<button class="btn btn-success btn-xs play" id="porder_' . $value['_id'] . '" data-id="' . $value['_id'] . '" symbol="' . $value['symbol'] . '"><i data-feather="play-circle"></i></button>';
                    } else {
                        $response .= '<button class="btn btn-default btn-xs pause" id="porder_' . $value['_id'] . '" data-id="' . $value['_id'] . '" symbol="' . $value['symbol'] . '"><i data-feather="pause-circle"></i></button>';
                    }
                }
                $response .= '</td><td class="text-center"><button class="btn btn-sm mr-2 btn-default view_order_details" title="View Order Details" data-id="' . $value['_id'] . '"><i data-feather="eye"></i></button>';
                if ($sell_status && ($value['status'] == 'FILLED' && $value['is_sell_order'] == 'yes')) {
                    $response .= '<button class="btn btn-warning change_error_status" title="Update Error" data-id="' . $value['_id'] . '">Remove Error</button>';
                }
                $response .= '</td>
                            </tr>';
            }
        }
        $response .= '</tbody>
                    	</table>
					    <div class="page_links text-center">' . $page_links . '</div>
				        </div>
				   </div>
				</div>';

        echo $response;
        exit;
    }

    public function get_coin_balance() {
        //Login Check
        $this->mod_login->verify_is_admin_login();
        $id = $this->session->userdata('admin_id');
        //$post = $this->input->post('symbol');
        $filter_data = $this->session->userdata('filter-data-buy');
        if ($filter_data['filter_coin'] == '') {
            $post = $this->session->userdata('global_symbol');
        } else {
            $post = $filter_data['filter_coin'];
        }
        $market = $this->mod_dashboard->get_market_value($post);
        $bal1 = $this->mod_buy_orders->get_balance($post, $id);
        $bal1_usd = convert_to_usd_price("USD", ($market * (float) $bal1));
        $post = 'BTC';
        $bal2 = $this->mod_buy_orders->get_balance($post, $id);
        $bal2_usd = convert_to_usd_price("USD", $bal2);

        echo number_format($bal1, 3) . "<br>(" . $bal1_usd . ")" . '|' . number_format($bal2, 3) . "<br>(" . $bal2_usd . ")";
        exit;
    }

    public function reset_buy_filters($type = '') {
        //Login Check
        $this->mod_login->verify_is_admin_login();
        $this->session->unset_userdata('filter-data-buy');
        redirect(base_url() . 'admin/buy_orders');

    } //End reset_buy_filters

    public function get_all_counts() {
        //Login Check
        $this->mod_login->verify_is_admin_login();
        $count_all = $this->mod_buy_orders->count_all();

        $status = 'FILLED';
        $count_filled = $this->mod_buy_orders->count_by_status($status);

        $status = 'new';
        $count_new = $this->mod_buy_orders->count_by_status($status);

        $status = 'submitted';
        $count_submitted = $this->mod_buy_orders->count_by_status($status);

        $status = 'canceled';
        $count_canceled = $this->mod_buy_orders->count_by_status($status);

        $status = 'error';
        $count_error = $this->mod_buy_orders->count_by_status($status);

        $status = 'open';
        $count_open = $this->mod_buy_orders->count_by_status($status);

        $status = 'sold';
        $count_sold = $this->mod_buy_orders->count_by_status($status);

        $status = 'parent';
        $count_parent = $this->mod_buy_orders->count_by_status($status);

        $return_data = $this->mod_buy_orders->user_order_info();
        $sold_orders = $return_data['total_sold_orders'];
        $avg_profit = $return_data['avg_profit'];

        echo $count_new . "|" . $count_filled . "|" . $count_submitted . "|" . $count_canceled . "|" . $count_error . "|" . $count_open . "|" . $count_sold . "|" . $count_all . "|" . $sold_orders . "|" . $avg_profit . "|" . $count_parent;
        /*echo "1|2|3|4|5|6|7|8";*/
        exit;
    } //End get_all_counts

    public function autoload_market_price() {
        //Login Check
        $this->mod_login->verify_is_admin_login();
        $symbol = "NCASHBTC";
        $price = $this->mod_dashboard->get_market_value($symbol);
        $currency = 'bitcoin';
        $url = 'https://api.coinmarketcap.com/v1/ticker/' . $currency . '/?convert=USD';
        //Use file_get_contents to GET the URL in question.
        $contents = file_get_contents($url);

        //If $contents is not a boolean FALSE value.
        if ($contents !== false) {

            $result = json_decode($contents);
            $price_usd = $result[0]->price_usd;

            $convertamount = $price_usd * $price;
            $convertamount = round($convertamount, 5);
        }
        echo $price . '  $' . $convertamount;
        exit;
    }

    public function setting() {
        //Login Check
        $this->mod_login->verify_is_admin_login();
        $es = $this->mongo_db->get('box_trigger_3_setting');
        echo '<pre>';
        print_r(iterator_to_array($es));
    }
    public function delete_coll($col = 'box_trigger_3_setting') {
        $db = $this->mongo_db->customQuery();
        $res = $db->box_trigger_3_setting->drop();
        echo '<pre>';
        print_r($res);
        exit();
    }
    public function test() {

        $this->mongo_db->limit(100);
        $this->mongo_db->where('symbol', 'NCASHBTC');
        $this->mongo_db->order_by(array('modified_date' => -1));
        $res = $this->mongo_db->get('buy_orders');

        $res_arr = iterator_to_array($res);
        echo '<pre>';
        print_r($res_arr);
        exit();

        $defined_quantity = '1000000';
        $current_market_price = $this->mod_dashboard->get_market_value($coin_symbol);
        $current_market_price = (float) $current_market_price;
        $this->mongo_db->limit(10);
        $this->mongo_db->order_by(array('created_date' => -1));
        $this->mongo_db->where(array('coin' => 'NCASHBTC', 'price' => $current_market_price, 'type' => 'ask'));
        $this->mongo_db->where_gte('quantity', $defined_quantity);
        $res = $this->mongo_db->get('market_depth');
        echo '<pre>';
        $variable = iterator_to_array($res);
        print_r($variable);
        foreach ($variable as $row) {

            var_dump($row['quantity']);

        }
        exit();

        //1 + 5b67577d819e1203eb511902
        //2 = 5b66f50d819e122c9421c212
        //-3 5b67577d819e1203eb511902

        $this->mongo_db->where(array('_id' => '5b66a0ad819e120d8c1dc792'));
        $upd_data22 = array('is_sell_order' => '');
        $this->mongo_db->set($upd_data22);
        //Update data in mongoTable
        $res = $this->mongo_db->update('buy_orders');

        echo '<pre>';
        print_r($res);
        exit();

        $admin_id = $this->session->userdata('admin_id');

        // $this->mongo_db->limit(1);

        $this->mongo_db->where(array('admin_id' => $admin_id, ''));

        $res = $this->mongo_db->get('buy_orders');

        echo '<pre>';
        print_r(iterator_to_array($res));
        exit();

        $this->mongo_db->where(array('_id' => '5b7bd4a3819e121db81c4ff0'));

        $res = $this->mongo_db->get('buy_orders');
        echo '<pre>';
        print_r(iterator_to_array($res));
        exit();
        $this->mongo_db->where(array('status' => 'FILLED', 'symbol' => 'ZECBTC', 'quantity' => '206.00')); //symbol
        //$this->mongo_db->limit(4);
        $res = $this->mongo_db->get('buy_orders');
        echo '<pre>';
        print_r(iterator_to_array($res));
        exit();

        $this->mongo_db->where_gte('one', 0.00000090);

        $res = $this->mongo_db->get('test_vizz');
        echo '<pre>';
        print_r(iterator_to_array($res));
        exit();

        $date = '2018-08-20 15:00:00';
        $order_mode = 'test';
        $buy_Message = $this->mod_box_trigger_3->create_new_orders_by_Box_Trigger_3_live($date);
        exit();
        $this->mod_box_trigger_3->create_box_trigger_3_setting($date, $order_mode);
        $buy_Message = $this->mod_box_trigger_3->create_new_orders_by_Box_Trigger_3_simulator($date);
        $sell_Message = $this->mod_box_trigger_3->sell_order_box_trigger_3_samulater($date);
        exit();

        $date = date('Y-m-d H:00:00');

        $date = '2018-08-19 18:00:00';
        $order_mode = 'live';
        $this->mod_box_trigger_3->create_box_trigger_3_setting($date, $order_mode);
        exit();

        //$this->mongo_db->where_ne('trigger_status_trigger_2', 1);
        // $where = array('openTime_human_readible' => $prevouse_date, 'coin' => $coin_symbol, 'candle_type' => 'demand');

        // $where = array('openTime_human_readible' => $prevouse_date, 'coin' => $coin_symbol, 'candle_type' => 'demand');

        echo date('y-m-d H:i:s');
        echo '<br>';
        $this->mongo_db->where(array('coin' => 'NCASHBTC'));
        $this->mongo_db->order_by(array('timestampDate' => -1));
        $this->mongo_db->limit(13);
        $previouse_candel_result = $this->mongo_db->get('market_chart');
        $previouse_candel_arr = iterator_to_array($previouse_candel_result);
        echo date('y-m-d H:i:s');
        echo '<br>';
        echo '<pre>';
        print_r($previouse_candel_arr);
        exit();

        //$this->mongo_db->where(array('openTime_human_readible' => $prevouse_date, 'coin' => $coin_symbol, 'candle_type' => 'demand','trigger_status' => 0));

        $this->mongo_db->where(array('coin' => 'NCASHBTC'));
        $this->mongo_db->order_by(array('open_time_object' => -1));
        $this->mongo_db->limit(11);
        $previouse_candel_result = $this->mongo_db->get('box_trigger_3_setting');
        $res = iterator_to_array($previouse_candel_result);
        echo '<pre>';
        print_r($res);
        exit();
    } //End of Test

    public function delete_triggers_orders() {
        //Login Check
        $this->mod_login->verify_is_admin_login();
        $con = $db = $this->mongo_db->customQuery();
        $select_trigger = $this->input->post('select_trigger');
        $admin_id = $this->session->userdata('admin_id');
        $res = $con->buy_orders->deleteMany(array('trigger_type' => $select_trigger, 'order_mode' => 'test_simulator'));
        $res = $con->orders->deleteMany(array('trigger_type' => $select_trigger, 'order_mode' => 'test_simulator'));
        //$res = $con->box_trigger_3_setting->deleteMany(array());

        echo '<pre>';
        echo print_r($res);
        exit();
    }

    public function test_2() {

        $this->mongo_db->limit(10);
        $this->mongo_db->order_by(array('_id' => -1));
        $res = $this->mongo_db->get('market_history_data_from_api_ZEC_BTC_second');
        $res = iterator_to_array($res);
        echo '<pre>';
        print_r($res);
    }

    public function inactive_status() {
        //Login Check
        $this->mod_login->verify_is_admin_login();
        $id = $this->input->post('id');
        $ids = $this->mod_buy_orders->change_inactive_status($id);
        echo $id;
        exit;
    }

    public function play_pause_status_change() {
        //Login Check
        $this->mod_login->verify_is_admin_login();
        $id = $this->input->post('id');
        $type = $this->input->post('type');

        $this->mongo_db->where("_id", $this->mongo_db->mongoId($id));
        $this->mongo_db->set(array('pause_status' => $type));
        $this->mongo_db->update("buy_orders");

        ///////////////////////////////////////////////////////////////////
        $admin_id = $this->session->userdata('admin_id');
        $log_msg = "Buy Order was " . strtoupper($type);
        $this->mod_dashboard->insert_order_history_log($id, $log_msg, 'order_puse', $admin_id);
        ///////////////////////////////////////////////////////////////////
        echo $id . "=====>" . $type;
        exit;
    }

    public function run_cron_for_inactive_parent() {
        $date_now = date('Y-m-d G:00:00');

        $search_arr['inactive_time'] = array('$lte' => $this->mongo_db->converToMongodttime($date_now));

        $this->mongo_db->where($search_arr);
        $res = $this->mongo_db->get('buy_orders');

        $order_arr = iterator_to_array($res);
        echo "<pre>";
        print_r($order_arr);

        foreach ($order_arr as $key => $value) {

            if (!empty($value)) {
                $id = $value['_id'];

                $this->mod_buy_orders->change_inactive_status($id);
            }
        }
        exit;
    } //End of run_cron_for_inactive_parent

    public function box_trigger_3() {
        //Login Check
        $this->mod_login->verify_is_admin_login();
        $date = date('Y-m-d H:00:00');
        $date = '2018-04-21 08:00:00';
        $this->mod_buy_orders->create_new_orders_by_Box_Trigger_3_simulator($date);
        //$this->mod_realtime_candle_socket->calculate_candel_status_demand_supply('2018-07-01 01:00:00');

    } //End of create_buy_orders_by_Box_Trigger_3_simulator

    public function get_min_notation() {
        $global = $this->input->post('symbol');
        $min_not = get_min_notation($global);
        $market_value = $this->mod_dashboard->get_market_value($global);

        $per = $min_not / $market_value;
        $new_width = ($per) * 1.20;
        echo ($new_width);
        exit;
    }

    public function get_max_notation() {
        $global = $this->input->post('symbol');
        $market_value = $this->mod_dashboard->get_market_value($global);

        $new_market = (0.015 / (float) $market_value);

        echo ($new_market);
        exit;
        //0.016÷0.00000080
    }

    public function array2csv($array) {
        if (count($array) == 0) {
            return null;
        }
        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, array_keys((array) reset($array)));

        foreach ($array as $row) {
            fputcsv($df, (array) $row);
        }
        fclose($df);
        return ob_get_clean();
    }

    public function download_send_headers($filename) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");
        header("Content-type: application/csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }

    public function download_csv() {
        $this->mod_login->verify_is_admin_login();
        $array = $this->mod_buy_orders->get_all_user_orders();
        $this->download_send_headers("data_export_" . date("Y-m-d Gis") . ".csv");
        echo $this->array2csv($array);
        exit;
    }

    public function conver_karachi_pakistan_time_zone_to_utc($date_arg) {
        $date = new DateTime($date_arg, new DateTimeZone('Asia/Karachi'));
        $date->setTimezone(new DateTimeZone('UTC'));
        return $date->format('Y-m-d H:i:s');
    } //End of conver_karachi_pakistan_time_zone_to_utc

    public function conver_utc_time_zone_to_karachi_pakistan($date_arg) {
        $date = new DateTime($date_arg, new DateTimeZone('UTC'));
        $date->setTimezone(new DateTimeZone('Asia/Karachi'));
        return $date->format('Y-m-d H:i:s');
    } //End of conver_karachi_pakistan_time_zone_to_utc

    function time_elapsed_string($datetime, $full = false) {
        $ago = new DateTime($datetime);
        $now1 = $this->convert_time_zone(date("Y-m-d H:i:s"));
        $now = new DateTime($now1);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function convert_time_zone($date) {
        $datetime = date("Y-m-d g:i:s A", strtotime($date));
        $timezone = $this->session->userdata('timezone');
        if (empty($timezone)) {
            $timezone = 'ASIA/KARACHI';
        }
        $date = date_create($datetime);
        date_timezone_set($date, timezone_open($timezone));
        return date_format($date, 'Y-m-d g:i:s A');
    } //End of convert_time_zone

    public function user_order_info() {

        $admin_id = $this->session->userdata('admin_id');
        $application_mode = $this->session->userdata('global_mode');

        $search_array = array('admin_id' => $admin_id, 'application_mode' => $application_mode);
        $search_array['status'] = 'FILLED';
        $search_array['is_sell_order'] = 'sold';

        $connetct = $this->mongo_db->customQuery();
        $cursor = $connetct->buy_orders->find($search_array);
        $total_sold_orders = 0;
        $total_profit = 0;
        $total_quantity = 0;
        foreach ($cursor as $key => $value) {

            $total_sold_orders++;
            $market_sold_price = $value['market_sold_price'];
            $current_order_price = $value['market_value'];
            $quantity = $value['quantity'];

            $current_data2222 = $market_sold_price - $current_order_price;
            $profit_data = ($current_data2222 * 100 / $market_sold_price);

            $profit_data = number_format((float) $profit_data, 2, '.', '');

            $total_profit += $quantity * $profit_data;
            $total_quantity += $quantity;

        }
        $avg_profit = $total_profit / $total_quantity;
        $return_data['total_sold_orders'] = $total_sold_orders;
        $return_data['avg_profit'] = number_format($avg_profit, 2, '.', '');

        return $return_data;
    }

    public function get_manual_buy($id) {
        $this->mongo_db->where("_id", $this->mongo_db->mongoId($id));
        $get = $this->mongo_db->get("buy_orders");
        echo "<pre>";
        print_r(iterator_to_array($get));
        exit;
    }

    public function get_manual_sell($id) {
        $this->mongo_db->where("_id", $this->mongo_db->mongoId($id));
        $get = $this->mongo_db->get("orders");
        echo "<pre>";
        print_r(iterator_to_array($get));
        exit;
    }

    public function run_1() {
        $this->mongo_db->limit(100);
        $res = $this->mongo_db->get('buy_orders');

        echo '<pre>';
        print_r(iterator_to_array($res));
    }

    public function get_order_error($order_id = "5be06849fc9aadb689723b2b") {
        $this->mongo_db->where(array('order_id' => $this->mongo_db->mongoId($order_id), 'type' => 'sell_error'));
        $get = $this->mongo_db->get('orders_history_log');
        $error_orders = iterator_to_array($get);

        return $error_orders[0]['log_msg'];
    }

    public function get_buy_order_error_ajax() {
        $order_id = $this->input->post('order_id');

        $get_arror = $this->get_order_error($order_id);

        $response = '<div class="row">
												<div class="col-md-6">
														<label for="inputTitle">Error :</label>
												</div>
												<div class="col-md-6">
														<p>' . $get_arror . '</p>
												</div>
										 </div>';
        $order_arr = $this->mod_buy_orders->get_buy_order($order_id);
        $response .= '<form method="post" action="' . SURL . 'admin/buy_orders/update_manual_order"><div class="row">
												<div class="col-md-6">
												</div>
												<div class="col-md-6">
													<div class="form-group col-md-6">
														<input type="hidden" value="' . $order_id . '" name="order_id">
														<script type="text/javascript">
															function setTwoNumberDecimal(event) {
																	$("#quantity").val(parseFloat($("#quantity").val()).toFixed(2));
															}
														</script>
													</div>
												</div>
											</div>


											<div class="col-md-12" id="quantitydv"></div>
										 </div>';
        $response .= '<div class="row">
											 <div class="col-md-12">
													 <button type="submit" class="btn btn-success">Update</button>
											 </div>
										</div></form>';

        $response .= '<div class="row">
											<div class="col-md-12">
													<a href="' . SURL . 'admin/buy_orders/get_errors_detail/" class="custom_link" target="_blank">Click here to Check Error Detail</a>
											</div>
									 </div>';
        echo $response;
        exit;

    }
    public function update_manual_order() {
        $id = $this->input->post('order_id');
        $current_date = date("Y-m-d H:i:s");
        $post_edit_data['modified_date'] = $this->mongo_db->converToMongodttime($current_date);

        $this->mongo_db->where(array('_id' => $id));
        $this->mongo_db->set($post_edit_data);
        $this->mongo_db->update('buy_orders');

        $this->mongo_db->where(array('buy_order_id' => $this->mongo_db->mongoId($id)));
        $post_edit_data['status'] = 'new';
        $this->mongo_db->set($post_edit_data);
        $this->mongo_db->update('orders');

        $admin_id = $this->session->userdata('admin_id');
        $message = 'Order was updated';
        $log_msg = $message . " And Moved From Error To Open";
        $this->mod_buy_orders->insert_order_history_log($id, $log_msg, 'sell_created', $admin_id, $current_date);

        redirect(base_url() . 'admin/buy_orders');

    }
    public function get_errors_detail() {
        $this->stencil->paint('admin/buy_order/binance_errors');
    }

    public function is_stepSize($symbol) {

        $this->mongo_db->where(array('symbol' => $symbol));
        $resp = $this->mongo_db->get('market_min_notation');
        $resp = iterator_to_array($resp);
        $resp = $resp[0];
        echo $stepSize = $resp['stepSize'];
        $test = 444.52;
        echo "<br>";
        $resp2 = '1';
        if ($stepSize < 1) {
            $resp2 = '0';
        } else {
            echo floor($test);
        }
        echo $resp2;
    } //%%%%%%% is_stepSize %%%%%%%%%%%%%

    function calculate_amount_in_usd() {
        $currency = 'bitcoin';
        $symbol = $this->input->post('symbol');
        $quantity = $this->input->post('quantity');
        $market_value = $this->mod_dashboard->get_market_value($symbol);
        $price = $quantity * $market_value;
        $url = 'https://api.coinmarketcap.com/v1/ticker/' . $currency . '/?convert=USD';
        //Use file_get_contents to GET the URL in question.
        $contents = file_get_contents($url);

        //If $contents is not a boolean FALSE value.
        if ($contents !== false) {

            $result = json_decode($contents);
            $price_usd = $result[0]->price_usd;

            $convertamount = $price_usd * $price;
            $convertamount = round($convertamount, 3);
        }
        echo '$ ' . $convertamount;
        exit;
    } //end of function

} //En of controller
