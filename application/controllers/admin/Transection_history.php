<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transection_history extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("binance_api");
    }

    // public function fetch_user_transaction_history($ip = "50.28.36.34") {
    //     echo "Start date" . date("Y-m-d H:i:s");
    //     mail("khan.waqar278@gmail.com", $ip, "message");
    //     $date_to_check = date("Y-m-d H:i:s", strtotime("-1 day"));
    //     $now_date = date("Y-m-d H:i:s");
    //     $mongo_date = $this->mongo_db->converToMongodttime($date_to_check);
    //     $this->mongo_db->where(array("trading_ip" => $ip, "check_transaction_history_date" => array('$lte' => $mongo_date)));
    //     $this->mongo_db->order_by(array("check_transaction_history_date" => 1));
    //     $this->mongo_db->limit(10);
    //     $get_obj = $this->mongo_db->get("users");

    //     $get_Arr = iterator_to_array($get_obj);
    //     echo "<pre>";
    //     print_r($get_Arr);
    //     exit;
    //     foreach ($get_Arr as $key => $value) {
    //         $user_id = $value["_id"];
    //         if (!empty($value['api_key'] || !empty($value['api_secret']))) {
    //             $deposit = $this->binance_api->get_all_deposit_history($user_id);
    //             $withdraw = $this->binance_api->get_all_withdraw_history($user_id);
    //         } else {
    //             continue;
    //         }
    //         $depositList = $deposit['depositList'];
    //         foreach ($depositList as $key => $value) {
    //             $upd_arr['insertTime'] = $value['insertTime'];
    //             $mytime = $value['insertTime'] / 1000;
    //             $mydate = date("Y-m-d H:i:s", $mytime);
    //             $upd_arr['txnDateTime'] = $this->mongo_db->converToMongodttime($mydate);
    //             $upd_arr['amount'] = $value['amount'];
    //             $upd_arr['human_date'] = $mydate;
    //             $upd_arr['address'] = $value['address'];
    //             $upd_arr['txId'] = $value['txId'];
    //             $upd_arr['asset'] = $value['asset'];
    //             $upd_arr['status'] = $value['status'];
    //             $upd_arr['user_id'] = $user_id;
    //             $upd_arr['txType'] = "Deposit";
    //             $upd_arr['created_date'] = $now_date;
    //             $db = $this->mongo_db->customQuery();
    //             $filter = array("txId" => $value['txId']);
    //             $cursor = $db->user_transaction_history->updateOne($filter, array('$set' => $upd_arr), array('upsert' => true));
    //         }
    //         $withDrawList = $withdraw['withdrawList'];
    //         foreach ($withDrawList as $key => $value) {
    //             $upd_arr_['amount'] = $value['amount'];
    //             $upd_arr_['address'] = $value['address'];
    //             $upd_arr_['successTime'] = $value['successTime'];
    //             $mytime = $value['successTime'] / 1000;
    //             $mydate = date("Y-m-d H:i:s", $mytime);
    //             $upd_arr_['human_date'] = $mydate;
    //             $upd_arr_['txnDateTime'] = $this->mongo_db->converToMongodttime($mydate);
    //             $upd_arr_['txId'] = $value['txId'];
    //             $upd_arr_['id'] = $value['id'];
    //             $upd_arr_['asset'] = $value['asset'];
    //             $upd_arr_['applyTime'] = $value['applyTime'];
    //             $upd_arr_['status'] = $value['status'];
    //             $upd_arr_['txType'] = "Withdraw";
    //             $upd_arr_['user_id'] = $user_id;
    //             $upd_arr_['created_date'] = $now_date;
    //             $db = $this->mongo_db->customQuery();
    //             $filter = array("txId" => $value['txId']);

    //             $cursor = $db->user_transaction_history->updateOne($filter, array('$set' => $upd_arr_), array('upsert' => true));
    //         }
    //         $this->mongo_db->where(array("_id" => $user_id));
    //         $this->mongo_db->set(array("check_transaction_history_date" => $mongo_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s"))));
    //         $this->mongo_db->update("users");
    //     }
    //     $summary = "This cronjob run to record the users transactions made on Binance";
    //     $duration = "1 minute";
    //     track_execution_of_cronjob($duration, $summary);

    //     echo "End date" . date("Y-m-d H:i:s");
    // } //End of fetch_user_transaction_history

} //En of controller
