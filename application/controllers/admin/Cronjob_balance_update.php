<?php 
class Cronjob_balance_update extends CI_Controller{
    function __construct(){
        parent::__construct();

        /*  Constructor Code Here */
        ini_set("display_errors", 1);
        error_reporting(1);
        ini_set("memory_limit", -1);
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
        $this->load->model('admin/mod_dashboard');
        $this->load->model('admin/mod_coins');
        $this->load->model('admin/mod_candel');
        $this->load->model('admin/mod_market');
        $this->load->model('admin/mod_barrier_trigger');
        $this->load->model('admin/mod_balance');
    }

    // public function cron_to_check_user_balance(){

    //     $where_arr_user['api_key']['$exists'] = true;
    //     $where_arr_user['api_secret']['$exists'] = true;
    //     $where_arr_user['api_key']['$nin'] = ["", null, NULL];
    //     $where_arr_user['api_secret']['$nin'] = ["", null, NULL];

    //     $this->mongo_db->where($where_arr_user);
    //     $this->mongo_db->order_by(array("last_balance_update_time" => 1));
    //     $this->mongo_db->limit(1);
    //     $get = $this->mongo_db->get("users");

    //     $result = iterator_to_array($get);
    //     $user = $result[0];
    //     $user_id = $user['_id'];
    //     // echo "<pre>";
    //     // print_r($user);
    //     $where['application_mode'] = 'live';
    //     $where['status']['$in'] = array('FILLED','LTH');
    //     $where['admin_id'] = (string)$user_id;
    //     $totalQty = 0;

    //     $queryHours =
    //     [
    //         ['$match' => $where],
    //         ['$group' => [
    //             '_id' => [
    //                 'symbol' => '$symbol'
    //             ],
    //              'totalQty' => ['$sum' => '$quantity'],
    //              'symbol' => ['$first' => '$symbol']
    //         ]
    //     ],
    //         ['$sort' => ['symbol' => -1]],
    //     ];

    //     //echo json_encode($queryHours);
    //     $db = $this->mongo_db->customQuery();
    //     $response = $db->buy_orders->aggregate($queryHours);
    //     $open_balance_arr = iterator_to_array($response);
        
    //     $where1['user_id'] = (string)$user_id;
    //     $this->mongo_db->where($where1);
    //     $iter = $this->mongo_db->get('user_wallet');
    //     $wallet_arr = iterator_to_array($iter);

    //     $symbol_arr = array_column($wallet_arr, "coin_symbol");
    //     $balance_arr = $this->binance_api->get_account_balance_user($user_id);

    //     $binance_bal_arr = array();
    //     if(!empty($balance_arr)){
    //         $coin_symbol = 'USDT';
    //         $account_balance = $balance_arr[$coin_symbol];
    //         $account_balance = $account_balance['available'];
    //         array_push($binance_bal_arr, array("user_id"=>$user_id,"symbol" => $coin_symbol, "balance" => $account_balance));
    //     }
            
    //     if(!in_array('BNBBTC', array_column($coinArr, 'symbol'))) {
    //         $coinArr[] = array('symbol'=>'BNBBTC');
    //     }

    //     if(!in_array('BTC', array_column($coinArr, 'symbol'))) {
    //         $coinArr[] = array('symbol'=>'BTC');
    //     }

    //     foreach($symbol_arr as $symbol){
    //         $coinArr[] = array('symbol'=> $symbol);
    //     }

    //     foreach ($coinArr as $row) {
    //         $coin_symbol = $row['symbol'];
    //         if($coin_symbol !=''){
    //             $currncy = 'BTC';
    //             if($coin_symbol !='BTC'){
    //                 $currncy = str_replace('BTC', '', $coin_symbol);
    //             }
    //             $account_balance = $balance_arr[$currncy];
    //             if($account_balance['available']!=''  &&  $account_balance['available']!=0){
    //                     $account_balance = $account_balance['available'];
    //             }else{
    //                     $account_balance =  0 ;
    //             }
    //             array_push($binance_bal_arr, array("user_id"=>$user_id,"symbol" => $coin_symbol, "balance" => $account_balance));

    //         }//End of coin not empty
    //     }//End of dforeach

    //     $final_arr_ins = array("user_id" => $user_id, "modified_date" => date("Y-m-d H:i:s"));
    //     $final_arr = array();

    //     $symbol_arr1 = array_column($wallet_arr, "coin_symbol");
    //     // echo "<pre>";

    //     // echo "************************************************************************";
    //     // echo "<br>";
    //     // echo "Wallet Arr<br>";
    //     // print_r($wallet_arr);
    //     // echo "************************************************************************";
    //     // echo "<br>";
    //     // echo "Open Arr<br>";
    //     // print_r($open_balance_arr);

    //      foreach($symbol_arr1 as $symbol){
    //         $binance_bal = 0;
    //         $wallet_bal = 0;
    //         $open_bal = 0;
    //         $binance_bal_ar = $this->custom_array_search($binance_bal_arr, "symbol", $symbol);
    //         if($binance_bal_ar != "false"){
    //             $binance_bal = $binance_bal_arr[$binance_bal_ar-1]['balance'];
    //         }
            
    //         $wallet_bal_ar = $this->custom_array_search($wallet_arr, "coin_symbol", $symbol);
    //         if($wallet_bal_ar != "false"){
    //             $wallet_bal = $wallet_arr[$wallet_bal_ar-1]['coin_balance'];
    //         }
            
    //         $open_bal_ar = $this->custom_array_search($open_balance_arr, "symbol", $symbol);
    //         if($open_bal_ar != "false"){
    //             $open_bal = $open_balance_arr[$open_bal_ar-1]['totalQty'];
    //         }

    //         $final_arr[$symbol]['binance_balance'] = (double)$binance_bal;
    //         $final_arr[$symbol]['wallet_balance'] = (double) $wallet_bal;
    //         $final_arr[$symbol]['open_balance'] = (double) $open_bal;
            
    //         // /**
    //         //  * Debugging Code. /////////////////////
    //         //  */
    //         // echo "************************************************************************";
    //         // echo "<br>";
    //         //  echo "Coin Symbol is : ".$symbol."<br>";
    //         //  echo "Binance Balance is : ".$binance_bal." And Index is : ".$binance_bal_ar."<br>";
    //         //  echo "Wallet Balance is : ".$wallet_bal." And Index is : ".$wallet_bal_ar."<br>";
    //         //  echo "Open Balance is : ".$open_bal." And Index is : ".$open_bal_ar."<br>";

    //         //  echo "************************************************************************";
    //         //  echo "<br>";
    //     }
        
    //     $final_arr_ins['balances'] = $final_arr;

    //     /**
    //      * Update Balances in Users Table
    //      */

    //      $customQuery = $this->mongo_db->customQuery();

    //      $where21['user_id'] =  $user_id;
    //      $update['$set'] = $final_arr_ins;
    //      $upsert['upsert'] = true;

    //      $respp = $customQuery->user_wallet_comaprison->updateOne($where21, $update, $upsert);
    //      $this->mongo_db->where(array("_id" => $user_id));
    //      $this->mongo_db->set(array("last_balance_update_time" => $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s"))));
    //      $this->mongo_db->update("users");
    // }

    // function custom_array_search($array, $field, $value) {
    //     foreach ($array as $key => $index) {
    //         if ($index[$field] === $value) {
    //             return $key+1;
    //         }
    //     }
    //     return "false";
    // }
}