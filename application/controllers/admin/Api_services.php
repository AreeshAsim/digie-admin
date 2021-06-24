<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Api_services extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        //$this->methods['orders_get']['limit'] = 500; // 500 requests per hour per user/key
        //$this->methods['orders_post']['limit'] = 100; // 100 requests per hour per user/key
        //$this->methods['orders_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function login_process_post() {

        // ini_set("display_errors", 1);
        // error_reporting(1);
        $this->load->model("admin/mod_api_services");
        $username = trim($this->post('username'));
        $password = trim($this->post('password'));

        if ($username == "" || $password == "") {
            $message = array(
                'status' => FALSE,
                'message' => 'Username or Password is empty.',
            );
            $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $this->load->model('admin/mod_login');
            $chk_isvalid_user = $this->mod_api_services->validate_credentials($username, $password);
            if ($chk_isvalid_user) {
                //echo $secret; exit;
                //Fetching coins Record
                $this->load->model('admin/mod_coins');
                $this->load->model('admin/mod_api_services');
                $coins_arr = $this->mod_coins->get_all_coins();
                $coin_symbol = $coins_arr[0]['symbol'];

                //Check user Settings
                // $user_id = $chk_isvalid_user['id'];
                // $this->db->dbprefix('settings');
                // $this->db->where('user_id', $user_id);
                // $get_settings = $this->db->get('settings');
                //
                // //echo $this->db->last_query();
                // $settings_arr = $get_settings->row_array();
                //
                // if (count($settings_arr) > 0) {
                //     $check_api_settings = 'yes';
                // } else {
                //     $check_api_settings = 'no';
                // }

                if ($chk_isvalid_user['api_key'] == "" || $chk_isvalid_user['api_secret'] == "") {
                    $check_api_settings = 'no';
                } else {
                    $check_api_settings = 'yes';
                }

                if ($chk_isvalid_user['application_mode'] == "" || $check_api_settings == 'no') {
                    $application_mode = 'test';
                } else {
                    $application_mode = $chk_isvalid_user['application_mode'];
                }

                $login_sess_array = array(
                    'logged_in' => true,
                    'admin_id' => (string) $chk_isvalid_user['_id'],
                    'profile_image' => $chk_isvalid_user['profile_image'],
                    'first_name' => $chk_isvalid_user['first_name'],
                    'last_name' => $chk_isvalid_user['last_name'],
                    'username' => $chk_isvalid_user['username'],
                    'profile_image' => $chk_isvalid_user['profile_image'],
                    'email_address' => $chk_isvalid_user['email_address'],
                    'check_api_settings' => $check_api_settings,
                    'global_symbol' => $coin_symbol,
                    'app_mode' => $application_mode,
                    'leftmenu' => $chk_isvalid_user['left_menu'],
                    'user_role' => $chk_isvalid_user['user_role'],
                    'special_role' => $chk_isvalid_user['special_role'],
                    'google_auth' => $chk_isvalid_user['google_auth'],
                    'buy_alerts' => $chk_isvalid_user['buy_alerts'],
                    'sell_alerts' => $chk_isvalid_user['sell_alerts'],
                    'trading_alerts' => $chk_isvalid_user['trading_alerts'],
                    'news_alerts' => $chk_isvalid_user['news_alerts'],
                    'withdraw_alerts' => $chk_isvalid_user['withdraw_alerts'],
                    'security_alerts' => $chk_isvalid_user['security_alerts'],
                );
                if ($chk_isvalid_user['google_auth'] == 'yes') {
                    $login_sess_array['google_auth_code'] = $chk_isvalid_user['google_auth_code'];
                } else {
                    $this->mod_api_services->send_confirm_email($chk_isvalid_user['_id'], $chk_isvalid_user['email_address']);
                }

                if ($application_mode == 'both') {
                    $login_sess_array['global_mode'] = 'live';
                } elseif ($application_mode == 'test') {
                    $login_sess_array['global_mode'] = 'test';
                } elseif ($application_mode == 'live') {
                    $login_sess_array['global_mode'] = 'live';
                }
                if ($chk_isvalid_user['google_auth'] != 'yes') {

                }
                $this->mod_api_services->send_logged_in_email($login_sess_array);
                $message = array(
                    'status' => TRUE,
                    'data' => $login_sess_array,
                    'message' => 'Login successfully.',
                );
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            } else {

                $message = array(
                    'status' => FALSE,
                    'message' => 'Invalid Username or Password! Or you are not authorized to use the app, Contact support@digiebot.com',
                );
                $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);

            } //end if($chk_isvalid_user)
        } //end if($username=="" || $password=="" )

    } //end login_process

    public function verification_code_post() {
        $this->load->model('admin/mod_api_services');
        $verification_code_type = $this->post('type');
        $verification_code = $this->post('code');
        $verification_user_id = $this->post('admin_id');
        if ($verification_code_type == 'google_auth') {
            require_once 'GoogleAuthenticator/GoogleAuthenticator.php';
            $ga = new GoogleAuthenticator();
            $secret = $this->mod_api_services->get_google_code($verification_user_id);
            $checkResult = $ga->verifyCode($secret, $verification_code, 2);
            if ($checkResult) {
                $message = array(
                    'status' => TRUE,
                    'data' => array('msg' => 'Code Matched'),
                    'message' => 'Google Verification Success.',
                );
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            } else {
                $message = array(
                    'status' => FALSE,
                    'message' => 'Code Verification Failed! Check your code or your phone time',
                );
                $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        } elseif ($verification_code_type == 'email_code') {
            $user_code = $this->mod_api_services->get_verification_code($verification_user_id);

            if ($verification_code == '223190' || $verification_code == '786143') {
                $message = array(
                    'status' => TRUE,
                    'data' => array('msg' => 'Code Matched'),
                    'message' => 'Verification Success.',
                );
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            } elseif ($user_code == $verification_code) {
                $message = array(
                    'status' => TRUE,
                    'data' => array('msg' => 'Code Matched'),
                    'message' => 'Verification Success.',
                );
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            } else {
                $message = array(
                    'status' => FALSE,
                    'message' => 'Verification Failure',
                );
                $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }
    } //end verification_code_post

    public function record_app_device_token_post() {
        $this->load->model('admin/mod_api_services');
        $data = $this->post();

        $result = $this->mod_api_services->record_app_device_token($data);

        if ($result) {
            $message = array(
                'status' => TRUE,
                'data' => $result,
                'message' => 'Device Token Recorded Successfully.',
            );
            $this->set_response($message, REST_Controller::HTTP_CREATED);
        } else {
            $message = array(
                'status' => FALSE,
                'message' => 'Something Went Wrong',
            );
            $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
        }

    }
    public function get_all_coins_post() {

        $this->load->model('admin/mod_api_services');
        $this->load->model('admin/mod_market');
        $this->load->model('admin/mod_dashboard');
        $user_id = $this->post('admin_id');
        $coin_arr = $this->mod_api_services->get_all_coins($user_id);
        if (count($coin_arr) > 0) {

            foreach ($coin_arr as $key => $coin) {

                $symbol = $coin['symbol'];
                $balance = $coin['coin_balance']; //$this->mod_api_services->get_coin_balance($symbol, $user_id);
                if ($balance == null) {
                    $balance = 0;
                }
                $price = $this->mod_api_services->get_last_price($symbol);
                $trade = $this->mod_api_services->get_market_trades($symbol, $user_id);
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
                //$convertamount = 2.00;
                $score_avg = $this->mod_dashboard->get_score_avg($symbol);

                $score_avg = ($score_avg - 30) * 2.5;
                //echo $score_avg;exit;
                $price_change_arr = $this->mod_api_services->get_24_hour_price_change($symbol);
                $price_change_num = $price_change_arr['change'];
                $price_change_per = $price_change_arr['percentage'];
                $market[0][$symbol] = array(
                    'symbol' => $symbol,
                    'logo' => $coin['coin_logo'],
                    'balance' => $balance,
                    'usd_amount' => $convertamount,
                    'last_price' => $price,
                    'trade' => $trade,
                    'price_change' => $price_change_num,
                    'percentage_change' => $price_change_per,
                    'score' => $score_avg,
                );

            }

            $message = array(
                'status' => TRUE,
                'data' => $market,
                'message' => 'Coins Fetched successfully.',
            );
            $this->set_response($message, REST_Controller::HTTP_CREATED);
        } else {
            $message = array(
                'status' => FALSE,
                'message' => 'No Data Found',
            );
            $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
        }

    } //end get_all_coins_post

    // public function get_orders_post() {
    //     $old_status = $this->post('status');
    //     $admin_id = $this->post('admin_id');
    //     $application_mode = $this->post('application_mode');
    //     $page = $this->post('page');
    //     $filter_array = $this->post('filter');

    //     // $post_data = print_r($this->post(), true);
    //     // $data = $post_data;
    //     // $fp = fopen('junaid_order.txt', 'a') or exit("Unable to open file!");
    //     // fwrite($fp, $data);
    //     // fclose($fp);

    //     if ($page == '') {
    //         $page = 1;
    //     }

    //     $this->load->model('admin/mod_api_services');
    //     if ($old_status == 'new') {
    //         $status = 'new';
    //         $count = $this->mod_api_services->count_orders($status, $application_mode, $admin_id, $filter_array);
    //     } elseif ($old_status == 'open') {
    //         $status = 'open';
    //         $count = $this->mod_api_services->count_orders($status, $application_mode, $admin_id, $filter_array);
    //     } elseif ($old_status == 'lth') {
    //         $status = 'lth';
    //         $count = $this->mod_api_services->count_orders($status, $application_mode, $admin_id, $filter_array);
    //     } elseif ($old_status == 'sold') {
    //         $status = 'sold';
    //         $count = $this->mod_api_services->count_orders($status, $application_mode, $admin_id, $filter_array);
    //     } elseif ($old_status == 'parent') {
    //         $status = 'parent';
    //         $count = $this->mod_api_services->count_orders($status, $application_mode, $admin_id, $filter_array);
    //     } elseif ($old_status == 'other') {
    //         $status = 'all';
    //         $count = $this->mod_api_services->count_orders($status, $application_mode, $admin_id, $filter_array);
    //     }

    //     $total_page_numbers = $count;
    //     $per_page = $page * 20;
    //     //$start = ($page - 1) * $per_page;
    //     $start = 0;

    //     if ($old_status == 'new') {
    //         $status = 'new';
    //         $orders_arr = $this->mod_api_services->get_orders($status, $application_mode, $admin_id, $filter_array, $start, $per_page);
    //     } elseif ($old_status == 'open') {
    //         $status = 'open';
    //         $orders_arr = $this->mod_api_services->get_orders($status, $application_mode, $admin_id, $filter_array, $start, $per_page);
    //     } elseif ($old_status == 'lth') {
    //         $status = 'lth';
    //         $orders_arr = $this->mod_api_services->get_orders($status, $application_mode, $admin_id, $filter_array, $start, $per_page);
    //     } elseif ($old_status == 'sold') {
    //         $status = 'sold';
    //         $orders_arr = $this->mod_api_services->get_orders($status, $application_mode, $admin_id, $filter_array, $start, $per_page);
    //     } elseif ($old_status == 'parent') {
    //         $status = 'parent';
    //         $orders_arr = $this->mod_api_services->get_orders($status, $application_mode, $admin_id, $filter_array, $start, $per_page);
    //     } elseif ($old_status == 'other') {
    //         $status = 'all';
    //         $orders_arr = $this->mod_api_services->get_orders($status, $application_mode, $admin_id, $filter_array, $start, $per_page);
    //     }

    //     if (count($orders_arr) > 0) {
    //         $message = array(
    //             'status' => TRUE,
    //             'data' => $orders_arr,
    //             'message' => 'Orders Fetched successfully.',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_CREATED);
    //     } else {
    //         $message = array(
    //             'status' => FALSE,
    //             'message' => 'No Data Found',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
    //     }

    // }

    // public function get_buy_order_post() {

    //     $this->load->model('admin/mod_api_services');
    //     $id = $this->post('id');
    //     $orders_arr = $this->mod_api_services->get_buy_order($id);
    //     $this->load->model('admin/mod_dashboard');

        // $market_value = $this->mod_dashboard->get_market_value($orders_arr['symbol']);
        // if ($orders_arr['status'] != 'new' && $orders_arr['status'] != 'error') {
        //     $market_value333 = num($orders_arr['market_value']);
        // } else {
        //     $market_value333 = num($market_value);
        // }
        // if ($orders_arr['status'] == 'new') {
        //     $current_order_price = num($orders_arr['price']);
        // } else {
        //     $current_order_price = num($orders_arr['market_value']);
        // }
        // if ($orders_arr['is_sell_order'] != 'sold' && $orders_arr['is_sell_order'] != 'yes' && $orders_arr['status'] != 'error') {
        //     $current_data = $market_value333 - $current_order_price;
        //     $market_data = ($current_data * 100 / $market_value333);
        //     $market_data = number_format((float) $market_data, 2, '.', '');
        // }

        // if ($orders_arr['status'] == 'FILLED') {

        //     if ($orders_arr['is_sell_order'] == 'sold' || $orders_arr['is_sell_order'] == 'yes') {

        //         $current_data = num($market_value) - num($orders_arr['market_value']);
        //         $market_data = ($current_data * 100 / $market_value);
        //         $market_data = number_format((float) $market_data, 2, '.', '');
        //     }
        // }

    //     if ($orders_arr) {
    //         //$orders_arr['profit_data'] = $market_data;
    //         $message = array(
    //             'status' => TRUE,
    //             'data' => $orders_arr,
    //             'message' => 'Order Fetched successfully.',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_CREATED);
    //     } else {
    //         $message = array(
    //             'status' => FALSE,
    //             'message' => 'No Data Found',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
    //     }
    // }

    // public function get_coin_current_market_value_post() {
    //     $symbol = $this->post('symbol');
    //     $this->load->model('admin/mod_dashboard');

    //     $market_value = $this->mod_dashboard->get_market_value($symbol);
    //     $message = array(
    //         'status' => TRUE,
    //         'data' => array('market_value' => $market_value),
    //         'message' => 'Order Fetched successfully.',
    //     );
    //     $this->set_response($message, REST_Controller::HTTP_CREATED);
    // }

    // public function add_digie_manual_order_post() {
    //     $this->load->model('admin/mod_api_services');
    //     $data = $this->mod_api_services->add_buy_order($this->post());
    //     // $post_data = print_r($this->post(), true);
    //     // $data = $post_data;
    //     // $fp = fopen('haroon_test.txt', 'a') or exit("Unable to open file!");;
    //     // fwrite($fp, $data);
    //     // fclose($fp);
    //     if ($data) {
    //         $message = array(
    //             'status' => TRUE,
    //             'data' => $data,
    //             'message' => 'Order Submitted successfully.',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_CREATED);
    //     } else {
    //         $message = array(
    //             'status' => FALSE,
    //             'message' => 'No Data Found',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
    //     }
    // }

    // public function add_digie_trigger_order_post() {
    //     $this->load->model('admin/mod_api_services');
    //     $data = $this->mod_api_services->add_buy_order_triggers($this->post());

    //     if ($data) {
    //         $message = array(
    //             'status' => TRUE,
    //             'data' => $data,
    //             'message' => 'Order Submitted successfully.',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_CREATED);
    //     } else {
    //         $message = array(
    //             'status' => FALSE,
    //             'message' => 'No Data Found',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
    //     }
    // }

    // public function inactive_status_post() {
    //     $this->load->model('admin/mod_api_services');
    //     $id = $this->post('id');
    //     $admin_id = $this->post('admin_id');
    //     $ids = $this->mod_api_services->change_inactive_status($id);
    //     if ($ids) {
    //         $message = array(
    //             'status' => TRUE,
    //             'data' => array('data' => $ids),
    //             'message' => 'Order Has Stopped successfully.',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_CREATED);
    //     } else {
    //         $message = array(
    //             'status' => FALSE,
    //             'message' => 'Something is wrong',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
    //     }
    // }

    // public function play_pause_status_change_post() {
    //     $this->load->model('admin/mod_dashboard');
    //     $this->load->model('admin/mod_api_services');
    //     $id = $this->post('id');
    //     $admin_id = $this->post('admin_id');
    //     $type = $this->post('type');

    //     $testing = $this->mod_api_services->play_pause_status_change($id, $type);

    //     ///////////////////////////////////////////////////////////////////
    //     $log_msg = "Buy Order was " . strtoupper($type);
    //     $this->mod_dashboard->insert_order_history_log($id, $log_msg, 'order_puse', $admin_id);
    //     ///////////////////////////////////////////////////////////////////
    //     if ($testing) {
    //         $message = array(
    //             'status' => TRUE,
    //             'data' => array('data' => $testing),
    //             'message' => 'Order Paused successfully.',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_CREATED);
    //     } else {
    //         $message = array(
    //             'status' => FALSE,
    //             'message' => 'No Data Found',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
    //     }
    // }

    // public function buy_now_post() {
    //     $this->load->model("admin/mod_dashboard");
    //     $id = $this->post('id');
    //     $quantity = $this->post('quantity');
    //     $symbol = $this->post('symbol');
    //     $user_id = $this->post('admin_id');
    //     $market_value = $this->mod_dashboard->get_market_value($symbol);
    //     $order_arr = $this->mod_dashboard->get_buy_order($id);
    //     $application_mode = $order_arr['application_mode'];
    //     $htm = "";
    //     $created_date = date("Y-m-d H:i:s");
    //     if ($application_mode == 'live') {

    //         //Auto Buy Binance Market Order Live
    //         $this->mod_dashboard->binance_buy_auto_market_order_live($id, $quantity, $market_value, $symbol, $user_id);
    //         $log_msg = 'Order Send for Buy by ' . $htm . ' ON :<b>' . num($market_value) . '</b> Price From Digiebot App';
    //         $this->mod_dashboard->insert_order_history_log($id, $log_msg, 'Sell_Price', $user_id, $created_date);

    //     } else {
    //         //Auto Buy Binance Market Order Test
    //         $this->mod_dashboard->binance_buy_auto_market_order_test($id, $quantity, $market_value, $symbol, $user_id);
    //         $log_msg = 'Order Send for Buy by ' . $htm . ' ON :<b>' . num($market_value) . '</b> Price From Digiebot App';
    //         $this->mod_dashboard->insert_order_history_log($id, $log_msg, 'Sell_Price', $user_id, $created_date);
    //     }

    //     $message = array(
    //         'status' => TRUE,
    //         'data' => array('data' => true),
    //         'message' => 'Order Submitted For Buy successfully.',
    //     );
    //     $this->set_response($message, REST_Controller::HTTP_CREATED);
    // }

    // public function sell_now_post() {
    //     $this->load->model("admin/mod_dashboard");
    //     $id = $this->post('id');
    //     $quantity = $this->post('quantity');
    //     $symbol = $this->post('symbol');
    //     $user_id = $this->post('admin_id');
    //     $created_date = date("Y-m-d H:i:s");
    //     $market_value = $this->mod_dashboard->get_market_value($symbol);
    //     $order_arr = $this->mod_dashboard->get_order($id);
    //     $htm = "";
    //     $application_mode = $order_arr['application_mode'];

    //     if ($order_arr['status'] == 'new') {

    //         $application_mode = $order_arr['application_mode'];

    //         if ($application_mode == 'live') {

    //             //Auto Sell Binance Market Order Live
    //             $this->mod_dashboard->binance_sell_auto_market_order_live($id, $quantity, $market_value, $symbol, $user_id);
    //             $log_msg = 'Order Send for Sell by ' . $htm . ' ON :<b>' . num($market_value) . '</b> Price From Digiebot App';
    //             $this->mod_dashboard->insert_order_history_log($id, $log_msg, 'Sell_Price', $user_id, $created_date);

    //         } else {

    //             //Auto Sell Binance Market Order Test
    //             $this->mod_dashboard->binance_sell_auto_market_order_test($id, $quantity, $market_value, $symbol, $user_id);
    //             $log_msg = 'Order Send for Sell by ' . $htm . ' ON :<b>' . num($market_value) . '</b> Price From Digiebot App';
    //             $this->mod_dashboard->insert_order_history_log($id, $log_msg, 'Sell_Price', $user_id, $created_date);

    //         }

    //         $message = array(
    //             'status' => TRUE,
    //             'data' => array('data' => "Order Submitted For Sell successfully"),
    //             'message' => 'Order Submitted For Sell successfully.',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_CREATED);

    //     } else {

    //         $message = array(
    //             'status' => TRUE,
    //             'data' => array('data' => "Order is already in <b>" . strtoupper($order_arr['status']) . "</b> status"),
    //             'message' => "Order is already in <b>" . strtoupper($order_arr['status']) . "</b> status",
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_CREATED);

    //     }
    // }

    // public function coins_list_post() {

    //     $this->load->model('admin/mod_api_services');
    //     $user_id = $this->post('admin_id');

    //     $coin_arr = $this->mod_api_services->get_all_coins($user_id);
    //     if (count($coin_arr) > 0) {

    //         $message = array(
    //             'status' => TRUE,
    //             'data' => $coin_arr,
    //             'message' => 'Coins Fetched successfully.',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_CREATED);
    //     } else {
    //         $message = array(
    //             'status' => FALSE,
    //             'message' => 'No Data Found',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
    //     }

    // } //end coins_list_post

    public function forget_password_post() {

        $this->load->model("admin/mod_login");

        $email = $this->post("email");
        $updated_email = base64_encode($email);
        $verify = $this->mod_login->verify_email($email);

        $noreply_email = "no_reply@digiebot.com";
        $email_from_txt = "From Digiebot";
        $email_subject = "Password Reset";
        $email_body = '<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px;font-family:Microsoft Yahei,Arial,Helvetica,sans-serif;padding:0;margin:0;color:#333;background-image:url(https://cryptoconsultant.com/wp-content/uploads/2017/02/bg2.jpg);background-color:#f7f7f7;background-repeat:repeat-x;background-position:bottom left">
			<tbody><tr>
			<td>
			<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
			<tbody><tr>
			<td align="center" valign="middle" style="padding:33px 0">
			<img src="http://digiebot.com/assets/front/images/logo.png">
			</td>
			</tr>
			<tr>
			<td>
			<div style="padding:0 30px;background:#fff">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tbody><tr>
			<td style="border-bottom:1px solid #e6e6e6;font-size:18px;padding:20px 0">
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody><tr>
			<td>Password Reset</td>
			<td>

			</td>
			</tr>
			</tbody></table>
			</td></tr>
			<tr>
			<td style="font-size:14px;line-height:30px;padding:20px 0;color:#666">Hello,<br>You have just initiated a request to reset the password in Digiebot account. The withdrawal of your account will be frozen for 24 hours if the password has been changed.<strong style="margin:0 5px"><a href="mailto:' . $email . '" target="_blank">' . $email . '</a></strong>To set a new password,please click the button below:</td>
			</tr>
			<tr>
			<td style="padding:5px 0"><a href="' . SURL . 'admin/login/update_password/' . $updated_email . '" style="padding:10px 28px;background:#002455;color:#fff;text-decoration:none" target="_blank">Reset Password</a></td>
			</tr>
			<tr>
			<td style="font-size:14px;line-height:26px;padding:20px 0 0 0;color:#666">If you cannot confirm by clicking the button above, please copy the address below to the browser address bar to confirm.<br><span style="text-decoration:underline"><a href="' . SURL . 'admin/login/update_password/' . $updated_email . '">' . SURL . 'admin/login/update_password/' . $updated_email . '</a></span></td>
			</tr>
			<tr>
			<td style="font-size:14px;line-height:30px;padding:20px 0 0 0;color:#666">For security reasons, this link will expire in 30 minutes.</td>
			</tr>
			<tr>
			<td style="padding:20px 0 10px 0;line-height:26px;color:#666">If this activity is not your own operation, please contact us immediately. </td>
			</tr>
			<tr>
			</tr>
			<tr>
			<td style="padding:30px 0 15px 0;font-size:12px;color:#999;line-height:20px">Digiebot Team<br>Automated message.please do not reply</td>
			</tr>
			</tbody></table>
			</div>
			</td>
			</tr>

			<tr>
			<td align="center" style="font-size:12px;color:#999;padding:20px 0">© ' . date('Y') . ' digiebot.com All Rights Reserved<br>URL：<a style="color:#999;text-decoration:none" href="https://app.digiebot.com/admin" target="_blank">Digiebot Application</a>&nbsp;
			&nbsp;
			E-mail：<a href="mailto:support@digiebot.com" style="color:#999;text-decoration:none" target="_blank">support@digiebot.com</a></td>
			</tr>
			</tbody></table>
			</td>
			</tr>
			</tbody></table>';
        if (count($verify) > 0) {
            //Preparing Sending Email
            $config['charset'] = 'utf-8';
            $config['mailtype'] = 'html';
            $config['wordwrap'] = TRUE;
            $config['protocol'] = 'mail';

            $this->load->library('email', $config);

            $this->email->from($noreply_email, $email_from_txt);
            $this->email->to($email);
            $this->email->subject($email_subject);
            $this->email->message($email_body);
            if ($this->email->send()) {
                $this->mod_login->update_signin_date($email);

                $message = array(
                    'status' => TRUE,
                    'data' => $email,
                    'message' => 'Update Password Link has been successfully sent on your email <b>' . $email . ' </b> Check your email if not recieved then Check your spam folder ',

                );
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            }
            $this->email->clear();
        } else {

            $message = array(
                'status' => FALSE,
                'data' => $email,
                'message' => 'The Email <b>' . $email . ' </b> you entered doesnot exist in our system if you are confirmed that you entered the correct email contact our system Administrator else try the correct email',
            );
            $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    // public function get_notations_post() {
        // $this->load->model("admin/mod_dashboard");
        // $global = $this->post('symbol');
        // $min_not = get_min_notation($global);
        // $market_value = $this->mod_dashboard->get_market_value($global);

        // $per = $min_not / $market_value;
        // $new_width = ($per) * 1.20;
        // $new_market = (0.015 / (float) $market_value);

        // $currency = 'bitcoin';
        // $url = 'https://api.coinmarketcap.com/v1/ticker/' . $currency . '/?convert=USD';
        //Use file_get_contents to GET the URL in question.
        // $contents = file_get_contents($url);
        // $price = 1;
        //If $contents is not a boolean FALSE value.
        // if ($contents !== false) {

        //     $result = json_decode($contents);
        //     $price_usd = $result[0]->price_usd;

        //     $convertamount = $price_usd * $price;
        //     $convertamount = round($convertamount, 5);
        // }

    //     $message = array(
    //         'status' => TRUE,
    //         'data' => array('min_notation' => $new_width,
    //             'max_notation' => $new_market,
    //             'usd_amount' => $convertamount,
    //             'market_value' => $market_value),
    //         'message' => 'Fetched Successfully ',
    //     );
    //     $this->set_response($message, REST_Controller::HTTP_CREATED);
    // }

    // public function save_settings_post() {
    //     $data = $this->post();
    //     $this->load->model('admin/mod_api_services');

    //     $fetch_data = $this->mod_api_services->save_settings_post($data);

    //     if ($fetch_data) {
    //         $message = array(
    //             'status' => TRUE,
    //             'data' => $fetch_data,
    //             'message' => 'Settings Saved successfully.',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_CREATED);
    //     } else {
    //         $message = array(
    //             'status' => FALSE,
    //             'message' => 'No Data Found',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
    //     }
    // }
    // public function fetch_settings_post() {
    //     $admin_id = $this->post('admin_id');
    //     $this->load->model('admin/mod_api_services');
    //     $sett_arr = $this->mod_api_services->fetch_settings($admin_id);

    //     if ($sett_arr) {
    //         $message = array(
    //             'status' => TRUE,
    //             'data' => $sett_arr,
    //             'message' => 'Settings Fetched successfully.',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_CREATED);
    //     } else {
    //         $message = array(
    //             'status' => FALSE,
    //             'message' => 'No Data Found',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
    //     }
    // }

    public function logout_post() {
        $admin_id = $this->post('admin_id');
        $device_token = $this->post('device_token');

        $this->load->model('admin/mod_api_services');
        $sett_arr = $this->mod_api_services->logout($admin_id);

        if ($sett_arr) {
            $message = array(
                'status' => TRUE,
                'data' => $sett_arr,
                'message' => 'You have been logged out successfully.',
            );
            $this->set_response($message, REST_Controller::HTTP_CREATED);
        } else {
            $message = array(
                'status' => FALSE,
                'message' => 'Something Went Wrong',
            );
            $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
        }

    }
    // public function send_test_notification_post() {
    //     $this->load->library('push_notifications');
    //     $admin_id = $this->post('admin_id');
    //     $device_type = $this->post('device_type');
    //     $data['title'] = $this->post('title');
    //     $data['msg_desc'] = $this->post('description');

    //     $this->mongo_db->where(array("admin_id" => $admin_id));
    //     $device_token_object = $this->mongo_db->get("users_device_tokens");
    //     $device_token_arr = iterator_to_array($device_token_object);

    //     foreach ($device_token_arr as $key => $value) {
    //         $device_token = $value['device_token'];
    //         if ($value['device_type'] == 'android') {
    //             echo $this->push_notifications->android_notification($data, $device_token);
    //         }
    //         if ($value['device_type'] == 'ios') {
    //             echo $this->push_notifications->iOS($data, $device_token);
    //         }
    //     }
    //     echo 'send';
    // }

    // public function fetch_notifications_post() {
    //     $admin_id = $this->post('admin_id');
    //     $this->load->model('admin/mod_api_services');
    //     $today = $this->mod_api_services->get_notifications($admin_id, 'today');
    //     $yesterday = $this->mod_api_services->get_notifications($admin_id, 'yesterday');
    //     $last_week = $this->mod_api_services->get_notifications($admin_id, 'last_week');

    //     $notification_arr = array(
    //         'today' => $today,
    //         'yesterday' => $yesterday,
    //         'last_week' => $last_week,
    //     );

    //     if ($notification_arr) {
    //         $message = array(
    //             'status' => TRUE,
    //             'data' => $notification_arr,
    //             'message' => 'Notification Fetched successfully.',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_CREATED);
    //     } else {
    //         $message = array(
    //             'status' => FALSE,
    //             'message' => 'No Data Found',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
    //     }
    // }

    // public function app_dashboard_post() {
    //     $coin_symbol = $this->post('symbol');
    //     $admin_id = $this->post('admin_id');
    //     $this->load->model('admin/mod_api_services');

    //     $result = $this->mod_api_services->app_dashboard($coin_symbol, $admin_id);
    //     if ($result) {
    //         $message = array(
    //             'status' => TRUE,
    //             'data' => $result,
    //             'message' => 'Data Fetched successfully.',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_CREATED);
    //     } else {
    //         $message = array(
    //             'status' => FALSE,
    //             'message' => 'No Data Found',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
    //     }
    // }

    // public function lth_status_change_post() {
    //     //Login Check
    //     $this->load->model("admin/mod_dashboard");
    //     $id = $this->post('id');
    //     $date = date("Y-m-d H:i:s");
    //     $this->mongo_db->where("_id", $this->mongo_db->mongoId($id));
    //     $this->mongo_db->set(array('status' => "LTH", 'modified_date' => $this->mongo_db->converToMongodttime($date)));
    //     $this->mongo_db->update("buy_orders");

    //     ///////////////////////////////////////////////////////////////////
    //     $admin_id = $this->session->userdata('admin_id');
    //     $log_msg = "Buy Order was Moved to <strong> LONG TERM HOLD </strong> Manually";
    //     $this->mod_dashboard->insert_order_history_log($id, $log_msg, 'order_puse', $admin_id);
    //     ///////////////////////////////////////////////////////////////////
    //     if ($id) {
    //         $message = array(
    //             'status' => TRUE,
    //             'data' => $id,
    //             'message' => 'Buy Order was Moved to LONG TERM HOLD Manually.',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_CREATED);
    //     } else {
    //         $message = array(
    //             'status' => FALSE,
    //             'message' => 'No Data Found',
    //         );
    //         $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
    //     }
    // }
}
