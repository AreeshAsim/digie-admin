<?php
/**
 *
 */
class Api extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    // public function get_coin_meta() {
    //     $username = $this->input->server('PHP_AUTH_USER');
    //     $password = $this->input->server('PHP_AUTH_PW');

    //     echo "<pre>";
    //     print_r($this->input->server());
    //     exit;
    //     echo $username;
    //     echo "<br>";
    //     echo $password;
    //     if ($username == 'digiebot' && $password == 'digiebot') {
    //         $coin = $this->input->post('symbol');
    //         $ip = getenv('HTTP_CLIENT_IP') ?:
    //         getenv('HTTP_X_FORWARDED_FOR') ?:
    //         getenv('HTTP_X_FORWARDED') ?:
    //         getenv('HTTP_FORWARDED_FOR') ?:
    //         getenv('REMOTE_ADDR');

    //         if ($ip == '58.65.164.72' || true) {
    //             // $this->load->model('admin/mod_api');
    //             $coin_meta = $this->mod_api->get_all_coin_meta($coin);
    //             $message = $coin_meta;
    //             $type = '200';
    //             $this->response($message, $type);
    //         } else {
    //             $message = 'You are not allowed To Access this';
    //             $type = '403';
    //             $this->response($message, $type);
    //         }

    //     } else {

    //         $message = 'Sorry You are not Authorized have wrong authentication code';
    //         $type = '401';
    //         $this->response($message, $type);

    //         //echo $orders_arr_arr = $this->mod_coins_info->save_coins_info();
    //     }

    // } //end Coin meta Function

    // public function get_user_orders() {
    //     //Basic ZGlnaWVib3Q6ZGlnaWVib3Q=
    //     $username = $this->input->server('PHP_AUTH_USER');
    //     $password = $this->input->server('PHP_AUTH_PW');

        // if (($username == 'digiebot' && $password == 'digiebot') || true) {
        //     $ip = getenv('HTTP_CLIENT_IP') ?:
        //     getenv('HTTP_X_FORWARDED_FOR') ?:
        //     getenv('HTTP_X_FORWARDED') ?:
        //     getenv('HTTP_FORWARDED_FOR') ?:
        //     getenv('HTTP_FORWARDED') ?:
        //     getenv('REMOTE_ADDR');

        //     if ($ip == '58.65.164.72' || true) {
        //         $admin_id = $this->input->post('user_id');
        //         $start_date = $this->input->post('start_date');
        //         $end_date = $this->input->post('end_date');
        //         $status = $this->input->post('status');

        //         $this->load->model('admin/mod_api');
        //         $user_orders = $this->mod_api->get_all_user_orders($admin_id, $start_date, $end_date, $status);
        //         $message = $user_orders;
        //         $type = '200';
        //         $this->response($message, $type);
        //     } else {
        //         $message = 'You are not allowed To Access this';
        //         $type = '403';
        //         $this->response($message, $type);
        //     }

        // } else {

        //     $message = 'Sorry You are not Authorized';
        //     $type = '401';
        //     $this->response($message, $type);

        //     //echo $orders_arr_arr = $this->mod_coins_info->save_coins_info();
        // }

    // } //end get_user_orders


    // public function get_order_count(){
    //     $username = $this->input->server('PHP_AUTH_USER');
    //     $password = $this->input->server('PHP_AUTH_PW');
    //     $contect_type  = $this->input->server('CONTENT_TYPE');
    //     if ($username == 'digiebot.com' && $password == 'YaAllah' && $contect_type == 'application/json'){
    //         $exchange = $_REQUEST["exchange"];
    //         $opportunityId = $_REQUEST["opportunityId"];
        
    //         if($exchange == 'binance'){
    //             $collection  = 'buy_orders';
    //             $collection1 = 'sold_buy_orders'; 
    //         }elseif($exchange == 'bam'){
    //             $collection  = 'buy_orders_bam';
    //             $collection1 = 'sold_buy_orders_bam';
    //         }elseif($exchange == 'kraken'){
    //             $collection  = 'buy_orders_kraken';
    //             $collection1 = 'sold_buy_orders_kraken';
    //         }
    //         if(!empty($opportunityId) && !empty($exchange)){
        
    //             ////////////////////////   RESUME SEARCH    ////////////////////////
    //             $search_resumed['application_mode']= 'live';
    //             $search_resumed['opportunityId'] = $opportunityId;
    //             $search_resumed['resume_status'] = array('$in' => array('resume'));

    //             $this->mongo_db->where($search_resumed);
    //             $total_resumed_sold = $this->mongo_db->get($collection1);
    //             $total_reumed_sold_live   = iterator_to_array($total_resumed_sold);

    //             $this->mongo_db->where($search_resumed);
    //             $total_resumed_open = $this->mongo_db->get($collection);
    //             $total_reumed_open_live   = iterator_to_array($total_resumed_open);

    //             $search_resumed_test['application_mode']= 'test';
    //             $search_resumed_test['opportunityId'] = $opportunityId;
    //             $search_resumed_test['resume_status'] = array('$in' => array('resume'));  

    //             $this->mongo_db->where($search_resumed_test);
    //             $total_resumed_sold_test = $this->mongo_db->get($collection1);
    //             $total_reumed_sold_test   = iterator_to_array($total_resumed_sold_test);

    //             $this->mongo_db->where($search_resumed_test);
    //             $total_resumed_open_test = $this->mongo_db->get($collection);
    //             $total_reumed_open_test   = iterator_to_array($total_resumed_open_test);
    //             ////////////////////////  END RESUME SEARCH    ////////////////////////


    //             ////////////////////////   SEARCH SOLD    ////////////////////////
    //             $search_sold['application_mode']= 'live';
    //             $search_sold['opportunityId'] = $opportunityId;
    //             $search_sold['is_sell_order'] = array('$in' => array('sold'));

    //             $this->mongo_db->where($search_sold);
    //             $total_sold_total = $this->mongo_db->get($collection1);
    //             $total_sold_rec_live   = iterator_to_array($total_sold_total);

    //             $search_sold_test['application_mode']= 'test';
    //             $search_sold_test['opportunityId'] = $opportunityId;
    //             $search_sold_test['is_sell_order'] = array('$in' => array('sold'));

    //             $this->mongo_db->where($search_sold_test);
    //             $total_sold_total_test = $this->mongo_db->get($collection1);
    //             $total_sold_rec_test   = iterator_to_array($total_sold_total_test);
    //             ////////////////////////  END SEARCH SOLD    ////////////////////////


    //             ////////////////////////  SEARCH NEW_ERROR    ////////////////////////
    //             $search_new_error['application_mode']= 'live';
    //             $search_new_error['opportunityId'] = $opportunityId;
    //             $search_new_error['status'] = array('$in' => array('new_ERROR'));
                
    //             $this->mongo_db->where($search_new_error);
    //             $total_new_error = $this->mongo_db->get($collection);
    //             $total_new_error_rec   = iterator_to_array($total_new_error);

    //             $search_new_error_test['application_mode']= 'test';
    //             $search_new_error_test['opportunityId'] = $opportunityId;
    //             $search_new_error_test['status'] = array('$in' => array('new_ERROR'));
                
    //             $this->mongo_db->where($search_new_error_test);
    //             $total_new_error_test = $this->mongo_db->get($collection);
    //             $total_new_error_rec_test   = iterator_to_array($total_new_error_test);
    //             ////////////////////////  END SEARCH NEW_ERROR    ////////////////////////


    //             ////////////////////////   SEARCH CANCEL    ////////////////////////
    //             $search_cancel['application_mode']= 'live';
    //             $search_cancel['opportunityId'] = $opportunityId;
    //             $search_cancel['status'] = array('$in' => array('canceled'));
                
    //             $this->mongo_db->where($search_cancel);
    //             $total_cancel = $this->mongo_db->get($collection);
    //             $total_cancel_rec   = iterator_to_array($total_cancel);

    //             $search_cancel_test['application_mode']= 'test';
    //             $search_cancel_test['opportunityId'] = $opportunityId;
    //             $search_cancel_test['status'] = array('$in' => array('canceled'));
                
    //             $this->mongo_db->where($search_cancel_test);
    //             $total_cancel_test = $this->mongo_db->get($collection);
    //             $total_cancel_rec_test   = iterator_to_array($total_cancel_test);
    //             ////////////////////////  END SEARCH CANCEL    ////////////////////////


    //             ////////////////////////   SEARCH OPEN    ////////////////////////
    //             $search_open['application_mode']= 'live';
    //             $search_open['opportunityId'] = $opportunityId;
    //             $search_open['status'] = array('$in' => array('FILLED'));

    //             $this->mongo_db->where($search_open);
    //             $total_open = $this->mongo_db->get($collection);
    //             $total_open_rec   = iterator_to_array($total_open);

    //             $search_open_test['application_mode']= 'test';
    //             $search_open_test['opportunityId'] = $opportunityId;
    //             $search_open_test['status'] = array('$in' => array('FILLED'));

    //             $this->mongo_db->where($search_open_test);
    //             $total_open_test = $this->mongo_db->get($collection);
    //             $total_open_rec_test   = iterator_to_array($total_open_test);
    //             ////////////////////////  END SEARCH OPEN    ////////////////////////


    //             ////////////////////////   SEARCH LTH    ////////////////////////
    //             $search_lth['application_mode']= 'live';
    //             $search_lth['opportunityId'] = $opportunityId;
    //             $search_lth['status'] = array('$in' => array('LTH'));

    //             $this->mongo_db->where($search_lth);
    //             $total_lth = $this->mongo_db->get($collection);
    //             $total_lth_rec   = iterator_to_array($total_lth);

    //             $search_lth_test['application_mode']= 'test';
    //             $search_lth_test['opportunityId'] = $opportunityId;
    //             $search_lth_test['status'] = array('$in' => array('LTH'));

    //             $this->mongo_db->where($search_lth_test);
    //             $total_lth_test = $this->mongo_db->get($collection);
    //             $total_lth_rec_test   = iterator_to_array($total_lth_test);
    //             ////////////////////////  END SEARCH LTH    ////////////////////////


    //             ////////////////////////   SEARCH OTHER    ////////////////////////
    //             $other['application_mode']= 'live';
    //             $other['opportunityId'] =  $opportunityId;
    //             $other['status'] = array('$nin' => array('LTH', 'FILLED','canceled','new_ERROR'));
            
    //             $this->mongo_db->where($other);
    //             $total_other = $this->mongo_db->get($collection);
    //             $total_other_rec   = iterator_to_array($total_other);

    //             $other_test['application_mode']= 'test';
    //             $other_test['opportunityId'] =  $opportunityId;
    //             $other_test['status'] = array('$nin' => array('LTH', 'FILLED','canceled','new_ERROR'));
            
    //             $this->mongo_db->where($other_test);
    //             $total_other_test = $this->mongo_db->get($collection);
    //             $total_other_rec_test   = iterator_to_array($total_other_test);
    //             ////////////////////////   END SEARCH OTHER    ////////////////////////
    //             if(count($total_other_rec_test) > 0  || count($total_other_rec) > 0        || count($total_lth_rec) > 0          || count($total_lth_rec_test) > 0     || count($total_open_rec) > 0           || 
    //               count($total_open_rec_test) > 0    ||count($total_reumed_sold_test) > 0  || count($total_reumed_open_test) > 0 || count($total_reumed_sold_live) > 0 || count($total_reumed_open_live) > 0   || count($total_sold_rec_test) > 0|| 
    //               count($total_sold_rec_live) > 0    || count($total_cancel_rec) > 0       || count($total_cancel_rec_test) > 0  || count($total_new_error_rec) > 0    || count($total_new_error_rec_test) > 0 || 
    //               count($total_sold_rec_live) > 0){
    //                 $response = array(
    //                     'other_status_test_orders' => count($total_other_rec_test),
    //                     'other_status_live_orders' => count($total_other_rec),
    //                     'lth_live_orders'          => count($total_lth_rec),
    //                     'lth_test_orders'          => count($total_lth_rec_test),
    //                     'open_live_orders'         => count($total_open_rec),
    //                     'open_test_orders'         => count($total_open_rec_test), 
    //                     'cancel_live_orders'       => count($total_cancel_rec),
    //                     'cancel_test_orders'       => count($total_cancel_rec_test), 
    //                     'new_error_live_orders'    => count($total_new_error_rec),
    //                     'new_error_test_orders'    => count($total_new_error_rec_test),
    //                     'sold_live_orders'         => count($total_sold_rec_live),
    //                     'sold_test_orders'         => count($total_sold_rec_test),
    //                     'resume_live_open_orders'  => count($total_reumed_open_live),
    //                     'resume_live_sold_orders'  => count($total_reumed_sold_live),
    //                     'resume_test_open_orders'  => count($total_reumed_open_test),
    //                     'resume_test_sold_orders'  => count($total_reumed_sold_test),
    //                     'exchange'                 => $exchange,
    //                     'opportunity_id'           => $opportunityId,
    //                     'message'                  => 'success',
    //                     'type'                     => '200',
    //                 );                                     
    //                 echo json_encode($response);
    //             }else{
    //                 $response = array(
    //                     'message' => 'opportunity Id not exists',
    //                     'type' => '404',
    //                 );
    //                 echo json_encode($response);
    //             }
                
    //         }else{
    //             $response = array(
    //                 'message' => 'error',
    //                 'type' => '403',
    //             );
    //             echo json_encode($response);
    //         }
    //     }else{
    //         $response = array(
    //             'message' => 'error',
    //             'type' => '403',
    //         );
    //         echo json_encode($response);
    //     }

    // }

    // public function response($message, $type) {

    //     $response = array('HTTP Response' => $type, 'Message' => $message);

    //     echo json_encode($response);
    //     exit;

    // } /**End of response ***/
}