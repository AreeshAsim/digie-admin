<?php
class Dashboard_support extends CI_Controller {
    function __construct() {
        parent::__construct();
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

    public function index() {
        $this->mod_login->verify_is_admin_login();

        $this->stencil->paint('admin/support_dashboard/dashboard', $data);
    }

    // public function check_true_rules() {
        
    //     $this->mod_login->verify_is_admin_login();
    //     if($this->input->post()){
    //         $post = $this->input->post();
    //         //$post['name'] = $url;
    //         $curl = curl_init();

    //         //
    //         curl_setopt_array($curl, array(
    //             CURLOPT_URL => "https://scripts.digiebot.com/admin/api_calls/meta_trending",
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => "",
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 30,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => "POST",
    //             CURLOPT_POSTFIELDS => ($post)
    //         ));

    //         $response = curl_exec($curl);
    //         $err = curl_error($curl);

    //         curl_close($curl);

    //         if ($err) {
    //             echo "cURL Error #:" . $err;
    //         } else {
    //             $res_arr = (array)json_decode($response, TRUE);
    //             $array_headers = array_keys($res_arr[0]);
    //             $table = "<table class=\"table\">";
    //             $table_headers = "<tr>";
    //             foreach($array_headers as $key => $value){
    //                 if($value == 'modified_date' || $value == "increasing_volume" || $value == 'top_wick_aggregate'){
    //                     $table_headers.= "<th>".$value."</th>";
    //                 }
    //             }
    //             $table_headers .= "</tr>";
    //             $table_body = "<tbody>";
                
    //             foreach($res_arr as $key1 => $value1){
    //                 $table_col = "";
    //                 foreach($value1 as $key => $value){
    //                     if($key == 'modified_date' || $key == "increasing_volume" || $key == 'top_wick_aggregate'){
    //                         if($key == 'modified_date'){
    //                             $table_col.= "<td>".$value."</td>";
    //                         }
    //                         if($key == 'increasing_volume'){
    //                             if($value == 1){
    //                                 $table_col.= "<td>"."<span class='text-success'>TRUE</span>"."</td>";
    //                             }else{
    //                                 $table_col.= "<td>"."<span class='text-danger'>FALSE</span>"."</td>";
    //                             }
    //                         }
    //                         if($key == 'top_wick_aggregate'){
    //                             if($value){
    //                                 $table_col.= "<td>"."<span class='text-success'>TRUE</span>"."</td>";
    //                             }else{
    //                                 $table_col.= "<td>"."<span class='text-danger'>FALSE</span>"."</td>";
    //                             }
    //                         }
    //                     }
    //                 }
    //                 $row_html .= "<tr>".$table_col."</tr>";
    //             }
    //             $table_body = "<tbody>".$row_html."</tbody>";
    //             $final_html = $table.$table_headers.$table_body."<table>";
    //             $data['html'] = $final_html;
    //         }
    //     }
    //     $coins = $this->mod_coins->get_all_coins();
    //     $data['coins'] = $coins;
    //     $this->stencil->paint('admin/support_dashboard/testing_rules_true', $data);
    // }

    // public function test_binance_balance($user_name){
    //     //$user_name = $this->input->post("filter_username");
    //     $where_arr_user['username'] = $user_name;
    //     $this->mongo_db->where($where_arr_user);
    //     $this->mongo_db->limit(1);
    //     $get = $this->mongo_db->get("users");

    //     $result = iterator_to_array($get);
    //     $user = $result[0];
    //     $user_id = $user['_id'];

    //     $balance_arr = $this->binance_api->get_account_balance_user($user_id);

    //     echo "<pre>";
    //     print_r($balance_arr);
    //     exit;
    // }

    // public function test_transactions_of_user($user_name){
    //     $this->mongo_db->where(array("username" => $user_name));
    //     $get_obj = $this->mongo_db->get("users");

    //     $get_Arr = iterator_to_array($get_obj);
    //     foreach ($get_Arr as $key => $value) {
    //         $user_id = $value["_id"];
    //         echo $user_id;
    //         echo "<br>";
    //         if (!empty($value['api_key'] || !empty($value['api_secret']))) {
    //             $deposit = $this->binance_api->get_all_deposit_history($user_id);
    //             $withdraw = $this->binance_api->get_all_withdraw_history($user_id);

    //             echo "Deposit : <pre>";
    //             print_r($deposit);

    //             echo "Withdraw : <pre>";
    //             print_r($withdraw);
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
    //             echo "<pre>";
    //             print_r($upd_arr);
    //             //$cursor = $db->user_transaction_history->updateOne($filter, array('$set' => $upd_arr), array('upsert' => true));
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
    //             echo "<pre>";
    //             print_r($upd_arr);

    //             //$cursor = $db->user_transaction_history->updateOne($filter, array('$set' => $upd_arr_), array('upsert' => true));
    //         }
    //     }
    // }
    public function get_binance_user_order_history(){
        $this->mod_login->verify_is_admin_login();
        if($this->input->post()){
            $user_name1['userdata'] = $this->input->post();
            $this->session->set_userdata($user_name1);
            $where_arr_user['username'] = $this->input->post('filter_username');
            $this->mongo_db->where($where_arr_user);
            $this->mongo_db->limit(1);
            $get = $this->mongo_db->get("users");
            $result = iterator_to_array($get);
            $user = $result[0];
            $user_id = $user['_id'];
            $symbol = $this->input->post("filter_by_coin");
            if(count($result) > 0 && !empty($this->input->post("filter_by_coin"))){
                $order_history = $this->binance_api->get_all_orders_history($symbol, $user_id);
                if($order_history > 0){
                    $data['order_arr'] = $order_history;
                }else{
                    $this->session->set_flashdata('message', $order_history);
                    // print_r($order_history);
                }
            }
            $data['pair'] = $symbol;
        }
        $coins = $this->mod_coins->get_all_coins();
        $data['coins'] = $coins;
        $data['admin_id'] = $user_id;
        $this->stencil->paint('admin/support_dashboard/order_history_binance', $data);
    }
    
    public function get_kraken_user_order_history(){
        $this->mod_login->verify_is_admin_login();
        if($this->input->post()){
            $user_name['userdata'] = $this->input->post();
            $this->session->set_userdata($user_name);
            $user_name = $this->input->post("filter_username");

            $where_arr_user['username'] = $user_name;
            $this->mongo_db->where($where_arr_user);
            $this->mongo_db->limit(1);
            $get = $this->mongo_db->get("users");
            $result = iterator_to_array($get);


            $user = $result[0];
            $get123['user_id'] = (string)$result[0]['_id'];
            $user_id =  (string)$result[0]['_id'];

            $this->mongo_db->where($get123);
            $detail = $this->mongo_db->get('kraken_credentials');

            $user_credentials = iterator_to_array($detail);

            $api_key = $user_credentials[0]['api_key'];
            $api_securet = $user_credentials[0]['api_secret'];


            $symbol = $this->input->post("filter_by_coin");
           if($symbol == 'ETCXBT'   ){
            $symbol = 'XETCXXBT';
           }
           elseif($symbol == 'ETHXBT'){
            $symbol = 'XETHXXBT';
           }elseif($symbol == 'XMRXBT'){
            $symbol = 'XXMRXXBT';
           }elseif($symbol == 'XLMXBT'){
            $symbol = 'XXLMXXBT';
           }elseif($symbol == 'ADAXBT'){
            $symbol = 'XADAXXBT';
           }

        
        //    $params =[
        //        'api_key' => $api_key,
        //        'api_securet' => $api_securet
        //    ]; 
        //    $this->load->library('kraken', $params);

        //    $orders = $this->kraken->QueryPublic('Trades', array('pair' => $symbol, 'since' => '137589964200000000'));

           if($this->input->post('trasection_id')){
                $payload = [
                    'admin_id'        => (string)$user_id,
                    'txid'            => $this->input->post('trasection_id'), 
                ];
                $jsondata1 = json_encode($payload);
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://34.199.235.34:3200/QueryOrder",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS =>$jsondata1,
                    CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
                ));
                $response_price = curl_exec($curl);	
                curl_close($curl);                                
                $api_response = json_decode($response_price);
                $data['order_arr'] = $api_response; 
           }else{
                $payload = [
                    'admin_id'        => (string)$user_id,
                    'txid'            => $this->input->post('trasection_id'), 
                    'initialOffset'   => $this->input->post('offset'), 
                    'symbol'          => $symbol, 
                ];
                $jsondata = json_encode($payload);
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://34.199.235.34:3200/GetUserTradesKraken",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS =>$jsondata,
                    CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
                ));
                $response_price = curl_exec($curl);	
                curl_close($curl);                                
                $api_response = json_decode($response_price);
                $data['order_arr'] = $api_response; 
            }
            $data['pair'] = $symbol;
            $data['admin_id'] = $user_id;
        }
        ////////////////////////////////
        $coins = $this->mod_coins->get_all_coins_kraken();
        $data['coins'] = $coins;
        $this->stencil->paint('admin/support_dashboard/order_history_kraken', $data);
    }

    public function getAllDepositHistory(){
        $this->mod_login->verify_is_admin_login();
        if($this->input->post()){
            $user_name['userdata'] = $this->input->post();
            $this->session->set_userdata($user_name);
            $user_name = $this->input->post("filter_username");
            $where_arr_user['username'] = $user_name;
            $this->mongo_db->where($where_arr_user);
            $this->mongo_db->limit(1);
            $get = $this->mongo_db->get("users");

            $result = iterator_to_array($get);
            $user = $result[0];
            $user_id = $user['_id'];          

            $data['admin_id'] = $user_id;
            if($this->input->post('HistoryType') == 'withdrawList'){
                $history = $this->binance_api->get_all_withdraw_history($user_id);
            }else{
                $history = $this->binance_api->get_all_deposit_history($user_id);
            }
            $data['history'] = $history;
        }
        ////////////////////////////////
        // $coins = $this->mod_coins->get_all_coins();
        // $data['coins'] = $coins;
        $this->stencil->paint('admin/support_dashboard/historyWithdrawOrDeposit', $data);
    }

    public function create_child_process(){
        $this->mod_login->verify_is_admin_login();
        $purchase_price  = (float)$this->input->post('purchased_price');
        $userid          = (string)$this->input->post('admin_id');
        $kraken_order_id = (string)$this->input->post('kraken_id');
       
        $quantity  = (float)$this->input->post('quantity');
        $symbol    = $this->input->post('symbol');
        $bot_level = 'level_11';
        $trading_ip = '35.153.9.225';
       
        $price_search['coin'] = $symbol;
        $this->mongo_db->where($price_search);
        $priceses = $this->mongo_db->get('market_prices_kraken');
        $buy_array_collection = 'buy_orders_kraken';
        $sell_array_collection = 'orders_kraken';
    
        $market_prices  = iterator_to_array($priceses);
        $current_market = $market_prices[0]['price'];
        $sell_price = (float)((($purchase_price / 100)* 1.2) + $purchase_price);
        $iniatial_trail_stop = (float)($purchase_price - (($purchase_price / 100)*1.2));
        $current_datetime = $this->mongo_db->converToMongodttime( date('Y-m-d H:i:s'));
        $buy_array = [
            'price'                        => $purchase_price,
            'quantity'                     => $quantity,   
            'symbol'                       => $symbol,
            'order_type'                   => 'market_order',
            'trading_ip'                   => $trading_ip,
            'admin_id'                     => $userid,
            'trigger_type'                 => 'barrier_percentile_trigger',
            'sell_price'                   => (float)$sell_price,
            'lth_functionality'            => 'yes',
            'activate_stop_loss_profit_percentage' => (float)1.2,
            'lth_profit'                   => (float)1.2,
            'stop_loss_rule'               => 'custom_stop_loss',
            'created_date'                 => $current_datetime,
            'modified_date'                => $current_datetime,
            'application_mode'             => 'live',
            'kraken_order_id'              => $kraken_order_id,
            'tradeId'                      => $kraken_order_id,
            'order_mode'                   => 'live',
            'created_buy'                  => 'trade_history_report',
            'market_value'                 => (float)$current_market,
            'iniatial_trail_stop'          => $iniatial_trail_stop,
            'defined_sell_percentage'      => (float)1.2,
            'order_level'                  => $bot_level, 
            'sell_profit_percent'          => (float)1.2,
            'is_sell_order'                => 'yes', 
            'auto_sell'                    => 'yes',
            'purchased_price'              =>  $purchase_price,
            'status'                       =>  'FILLED',
            'sell_order_id'                => '',
            'exchange'                     =>  $this->input->post('exchange'),
            'buy_fraction_filled_order_arr' => [
                'price'           => $purchase_price,
                'commission'      => '0',
                'commissionPercentRatio' => '0',
                'orderFilledId'   => $kraken_order_id,
                'filledQty'       => $quantity,
            ],
        ];
    
        $sell_array = [
            'symbol'                       => $symbol,
            'quantity'                     => $quantity,  
            'market_value'                 => (float)$current_market,
            'sell_price'                   => (float)$sell_price, 
            'lth_functionality'            => 'yes',
            'lth_profit'                   => (float)1.2,
            'activate_stop_loss_profit_percentage' => (float)1.2,
            'stop_loss_rule'               => 'custom_stop_loss',
            'order_type'                   => 'market_order',
            'admin_id'                     => $userid,
            'trading_ip'                   => $trading_ip,
            'created_date'                 =>  $current_datetime,
            'modified_date'                =>  $current_datetime,
            'application_mode'             => 'live',
            'buy_order_id'                 => '',
            'created_buy'                  => 'trade_history_report',
            'iniatial_trail_stop'          => $iniatial_trail_stop,
            'order_mode'                   => 'live',
            'trigger_type'                 => 'barrier_percentile_trigger',
            'sell_profit_percent'          => (float)1.2,
            'order_level'                  => $bot_level, 
            'status'                       => 'new',
            'purchased_price'              => $purchase_price,
            'defined_sell_percentage'      => (float)1.2
        ];
        $db = $this->mongo_db->customQuery();
        $buy_return  = $db->$buy_array_collection->insertOne($buy_array); // insert buy array
        $sell_return = $db->$sell_array_collection->insertOne($sell_array); // insert sell array
        $sell_set =[
            'buy_order_id' =>$buy_return->getInsertedId()
        ];
        $buy_set =[
            'sell_order_id' => $sell_return->getInsertedId()
            ];
        $where_buy['_id']      = $sell_return->getInsertedId();
        $where_buy['admin_id'] = $userid;
        $res = $db->$sell_array_collection->updateOne($where_buy, ['$set'=> $sell_set]);

        $where_sell['_id']      = $buy_return->getInsertedId();
        $where_sell['admin_id'] = $userid;
        $res = $db->$buy_array_collection->updateOne($where_sell, ['$set'=> $buy_set]);
        $this->get_kraken_user_Local_order_history();
    }

    public function first_cron_cron_listing(){
        
        // $data = $this->mongo_db->get('cronjob_execution_logs');
        // $data = iterator_to_array($data);

        $api_url = "http://35.171.172.15:3000/api/all_cronjobs";
        $data_json = file_get_contents($api_url);
        $data_arr = (array)json_decode($data_json);
        $data_arr = (array)$data_arr['data'];
        $arr = json_decode(json_encode($data_arr), TRUE);
        
        $inactive = false;
        foreach($arr as $row){
            $url = $row['name'];
            // $this->mongo_db->where(array('name' => $url));
            // $this->mongo_db->limit(1);
            // $this->mongo_db->order_by(array('_id' => -1));
            // $res = $this->mongo_db->get('cronjob_execution_logs');
            // $res_arr = iterator_to_array($res);

            // $cron_duration = $res_arr[0]['cron_duration'];
            // $last_updatedtime = $res_arr[0]['last_updated_time_human_readible'];

            $post['name'] = $url;
            $curl = curl_init();

            //
            curl_setopt_array($curl, array(
                CURLOPT_PORT => "3000",
                CURLOPT_URL => "http://35.171.172.15:3000/api/all_cronjobs",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($post),
                CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                //echo $response;
            }
            $res_arr = (array)json_decode($response);
            $res_arr = $res_arr['data'];
            $res_arr = json_decode(json_encode($res_arr),TRUE);
            $cron_duration = $res_arr['cron_duration'];
            $last_updatedtime = $res_arr['last_updated_time_human_readible'];

            // $cron_duration_arr = explode(' ',$cron_duration);

            //Umer Abbas [6-11-19]
            $duration_arr = str_split($cron_duration,1);
            $time = array_pop($duration_arr);
            $add_time = strtoupper($time);
            $duration = implode('', $duration_arr);

            $dt = new DateTime($last_updatedtime);
            // echo $dt->format('Y-m-d H:i:s');

            $last_time = date("Y-m-d H:i:s", strtotime($last_updatedtime));

            if($time == 's'){
                $padding_duration = 5;
                $padding_time = "M";
                $interval_str = "PT$padding_duration$padding_time$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param = 12;
                
            }else if($time == 'm'){
                
                $padding_duration = 5;
                $duration = $duration + $padding_duration;
                $interval_str = "PT$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param = 300;
                
            }else if($time == 'h'){
                
                $padding_duration = 15;
                $padding_time = "M";
                $interval_str = "PT$duration$add_time$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param = 900;
                
            }else if($time == 'd'){
                
                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time = "H";
                $interval_str = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param = 3600;
                
            }else if($time == 'w'){
                
                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time = "H";
                $interval_str = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param = 3600;
            }
        
            $dt2 = new DateTime();

            if($dt2 <= $dt){
                //echo $url . " Is Active <br>";
                // $inactive = true;
            }else{
                //echo $url . " Is Inactive <br>";
                $inactive = true;
            }
                }

        $data_to_return = array(
            "success" => $inactive,
            "url" => "https://app.digiebot.com/admin/cron_listing"
        );

        echo json_encode($data_to_return);
        exit;

    }

    // public function error_in_sell_report(){
    //     $start_date = date("Y-m-d H:i:s", strtotime("-5 days"));
    //     $end_date = date("Y-m-d H:i:s");

    //     $where['status'] = "error";
    //     $where['created_date']['$gte'] = $this->mongo_db->converToMongodttime($start_date);
    //     $where['created_date']['$lte'] = $this->mongo_db->converToMongodttime($end_date);

    //     $collection1 = 'buy_orders';
        
    //     $join = [
    //         'from' => $collection1,
    //         'localField' => 'sell_order_id',
    //         'foreignField' => '_id',
    //         'as' => 'sell_order',
    //     ];
        
    //     $query = [
    //         ['$lookup' => $join],
    //         ['$match' => $where],
    //         ['$sort' => ['created_date' => -1]],
    //         ['$limit' => 500],
    //     ];

    //     $collection2 = 'orders';
       
    //     $db = $this->mongo_db->customQuery();
    //     $response = $db->$collection2->aggregate($query);
    //     $records = iterator_to_array($response);

    //     if(count($records) > 0){
    //         $data_to_return = array(
    //             "success" => true,
    //             "url" => "https://app.digiebot.com/admin/trading_reports/error_sell"
    //         );
    
    //     }else{
    //         $data_to_return = array(
    //             "success" => false,
    //             "url" => "https://app.digiebot.com/admin/trading_reports/error_sell"
    //         );
    //     }

    //     echo json_encode($data_to_return);
    // }

    // public function check_auto_trading_last_hour(){
    //     $start_date = date("Y-m-d H:i:s", strtotime("-1 hour"));
    //     $where['status'] = "FILLED";
    //     $where['trigger_type']['$nin'] = array("no", "", null);
    //     $where['created_date']['$gte'] = $this->mongo_db->converToMongodttime($start_date);

    //     $connetct = $this->mongo_db->customQuery();

    //     $sold1_count = $connetct->sold_buy_orders->count($where);
    //     $pending1_count = $connetct->buy_orders->count($where);

    //     $total1_count = $sold1_count + $pending1_count;

    //     if($total1_count > 0){
    //         $data_to_return = array(
    //             "success" => true,
    //             "url" => "https://app.digiebot.com/admin/reports/order_report"
    //         );
    //     }else{
    //         $data_to_return = array(
    //             "success" => false,
    //             "url" => "https://app.digiebot.com/admin/reports/order_report"
    //         );
    //     }
    //     echo json_encode($data_to_return);
    // }

    public function server_usage(){
        // $time = microtime(TRUE);
        // $mem = memory_get_usage();
        // echo "the code you want to measure here";
        // echo "<pre>";
        // print_r(array(
        // 'memory' => (memory_get_usage() - $mem) / (1024 * 1024),
        // 'seconds' => microtime(TRUE) - $time
        // ));

        // echo "<br>*********************** APACHE BENCH **************************<br>";
        // //$usage = shell_exec("ab -n 100 -c 10 https://app.digiebot.com/");
        // $usage = shell_exec("free -g");
        // echo "<pre>";
        // echo $usage;
        // echo "</pre>";

        $memUsage = $this->getServerMemoryUsage(false);
        echo sprintf("Memory usage: %s / %s (%s%%)",
        $this->getNiceFileSize($memUsage["total"] - $memUsage["free"]),
        $this->getNiceFileSize($memUsage["total"]),
        $this->getServerMemoryUsage(true)
    );
    }

    function getNiceFileSize($bytes, $binaryPrefix=true) {
        if ($binaryPrefix) {
            $unit=array('B','KiB','MiB','GiB','TiB','PiB');
            if ($bytes==0) return '0 ' . $unit[0];
            return @round($bytes/pow(1024,($i=floor(log($bytes,1024)))),2) .' '. (isset($unit[$i]) ? $unit[$i] : 'B');
        } else {
            $unit=array('B','KB','MB','GB','TB','PB');
            if ($bytes==0) return '0 ' . $unit[0];
            return @round($bytes/pow(1000,($i=floor(log($bytes,1000)))),2) .' '. (isset($unit[$i]) ? $unit[$i] : 'B');
        }
    }

    // Returns used memory (either in percent (without percent sign) or free and overall in bytes)
    function getServerMemoryUsage($getPercentage=true)
    {
        $memoryTotal = null;
        $memoryFree = null;

        if (stristr(PHP_OS, "win")) {
            // Get total physical memory (this is in bytes)
            $cmd = "wmic ComputerSystem get TotalPhysicalMemory";
            @exec($cmd, $outputTotalPhysicalMemory);

            // Get free physical memory (this is in kibibytes!)
            $cmd = "wmic OS get FreePhysicalMemory";
            @exec($cmd, $outputFreePhysicalMemory);

            if ($outputTotalPhysicalMemory && $outputFreePhysicalMemory) {
                // Find total value
                foreach ($outputTotalPhysicalMemory as $line) {
                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                        $memoryTotal = $line;
                        break;
                    }
                }

                // Find free value
                foreach ($outputFreePhysicalMemory as $line) {
                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                        $memoryFree = $line;
                        $memoryFree *= 1024;  // convert from kibibytes to bytes
                        break;
                    }
                }
            }
        }
        else
        {
            if (is_readable("/proc/meminfo"))
            {
                $stats = @file_get_contents("/proc/meminfo");
                // echo "<pre>";
                // print_r($stats);
                if ($stats !== false) {
                    // Separate lines
                    $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                    $stats = explode("\n", $stats);

                    // Separate values and find correct lines for total and free mem
                    foreach ($stats as $statLine) {
                        $statLineData = explode(":", trim($statLine));

                        //
                        // Extract size (TODO: It seems that (at least) the two values for total and free memory have the unit "kB" always. Is this correct?
                        //

                        // Total memory
                        if (count($statLineData) == 2 && trim($statLineData[0]) == "MemTotal") {
                            $memoryTotal = trim($statLineData[1]);
                            $memoryTotal = explode(" ", $memoryTotal);
                            $memoryTotal = $memoryTotal[0];
                            $memoryTotal *= 1024;  // convert from kibibytes to bytes
                        }

                        // Free memory
                        if (count($statLineData) == 2 && trim($statLineData[0]) == "MemFree") {
                            $memoryFree = trim($statLineData[1]);
                            $memoryFree = explode(" ", $memoryFree);
                            $memoryFree = $memoryFree[0];
                            $memoryFree *= 1024;  // convert from kibibytes to bytes
                        }
                    }
                }
            }
        }

        if (is_null($memoryTotal) || is_null($memoryFree)) {
            return null;
        } else {
            if ($getPercentage) {
                return (100 - ($memoryFree * 100 / $memoryTotal));
            } else {
                return array(
                    "total" => $memoryTotal,
                    "free" => $memoryFree,
                );
            }
        }
    } 
    
    // public function check_trading_on_off(){
    //     $urls =  "http://3.232.17.202:2603/apiEndPoint/check_trading_status";
    //     $resp = file_get_contents($urls);
    //     $data = (array)json_decode($resp);
    //     extract($data);

    //     if($trading_status == 'ON'){
    //         $data_to_return = array(
    //             "success" => true,
    //             "url" => $setting_url
    //         );
    //     }else{
    //         $data_to_return = array(
    //             "success" => false,
    //             "url" => $url
    //         );
    //     }
    //     echo json_encode($data_to_return);
    // }

    // public function check_new_ticket(){
    //     $urls =  "https://users.digiebot.com/cronjob/check-for-new-unread-tickets/";
    //     $resp = file_get_contents($urls);
    //     $data = (array)json_decode($resp);

    //     extract($data);

    //     if($status == 200){
    //         $data_to_return = array(
    //             "success" => true,
    //             "url" => $link
    //         );
    //     }else{
    //         $data_to_return = array(
    //             "success" => false,
    //             "url" => $link
    //         );
    //     }
    //     echo json_encode($data_to_return);
    // }

    // public function check_new_user(){
    //     $urls =  "https://users.digiebot.com/cronjob/get-users-need-approval/";
    //     $resp = file_get_contents($urls);
    //     $data = (array)json_decode($resp);

    //     extract($data);

    //     if($status == 200){
    //         $data_to_return = array(
    //             "success" => true,
    //             "url" => $link
    //         );
    //     }else{
    //         $data_to_return = array(
    //             "success" => false,
    //             "url" => $link
    //         );
    //     }
    //     echo json_encode($data_to_return);
    // }

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
    //             echo "Balance condition True";
    //             $wallet_bal = $wallet_arr[$wallet_bal_ar-1]['coin_balance'];
    //         }            
            
    //         $open_bal_ar = $this->custom_array_search($open_balance_arr, "symbol", $symbol);
    //         if($open_bal_ar != "false"){
    //             echo "Open Balance condition True";
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

    // public function get_kraken_user_Local_order_history(){
    //     $this->mod_login->verify_is_admin_login();
    //     if($this->input->post()){
    //         $user_name['userdata'] = $this->input->post();
    //         $this->session->set_userdata($user_name);
    //     }
    //     $filterData = $this->session->userdata('userdata');

    //     $where_arr_user['username'] =   $filterData['filter_username'];

    //     $this->mongo_db->where($where_arr_user);
    //     $this->mongo_db->limit(1);
    //     $get = $this->mongo_db->get("users");
    //     $result = iterator_to_array($get);

    //     $user_id =  (string)$result[0]['_id'];

    //     $symbol = $this->input->post("filter_by_coin");
    //     if($symbol == 'ETCXBT'   ){
    //     $symbol = 'XETCXXBT';
    //     } elseif($symbol == 'ETHXBT'){
    //     $symbol = 'XETHXXBT';
    //     }elseif($symbol == 'XMRXBT'){
    //     $symbol = 'XXMRXXBT';
    //     }elseif($symbol == 'XLMXBT'){
    //     $symbol = 'XXLMXXBT';
    //     }elseif($symbol == 'ADAXBT'){
    //     $symbol = 'XADAXXBT';
    //     }     
           
    //     $db = $this->mongo_db->customQuery();
    //     $where['user_id'] = $user_id;

    //     $trades = $db->kraken_user_tradehistory->find($where);
    //     $tradeReturn = iterator_to_array($trades);
        
    //     $data['finalHistory']   =   $tradeReturn[0]['trades'];
    //     $data['admin_id']       =   $user_id;
    //     // }

    //     $coins = $this->mod_coins->get_all_coins_kraken();
    //     $data['coins'] = $coins;
    //     $this->stencil->paint('admin/support_dashboard/krakenDuplicateTradeHistoryReport', $data);
    // }

}