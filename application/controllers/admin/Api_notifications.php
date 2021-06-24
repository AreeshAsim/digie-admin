<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - notification_test()
* - cronjob_push_notification()
* Classes list:
* - Api_notifications extends CI_Controller
*/
defined('BASEPATH') or exit('No direct script access allowed');
//require APPPATH . 'libraries/REST_Controller.php';

class Api_notifications extends CI_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }

        $this->stencil->layout('admin_layout');
        //load required slices
        $this->stencil->slice('admin_header_script');
        $this->stencil->slice('admin_header');
        $this->stencil->slice('admin_left_sidebar');
        $this->stencil->slice('admin_footer_script');

        $this->load->library('push_notifications');
        $this->load->library('mongo_db_3');

        $this->load->model('admin/mod_cronjob_listing');
        $this->load->model('admin/mod_settings');
        $this->load->model('admin/mod_report');
        $this->load->model('admin/mod_Api_crownjob_status');
        //$this->load->model('admin/mod_cronjob_status');

        $this->load->model('admin/mod_coins');
        $this->load->model('admin/mod_dashboard');

        
    }

    // public function notification_test() {
    //     $data = array(
    //         "title" => "Cronjob Alert",
    //         "url" => "http://google.com",
    //         "last_run" => "1 minute ago",
    //         "priority" => "high",
    //         "cron_duration" => ""
    //     );
    //     // $this->push_notifications->android_notification_topic($data);
    // }

    /**
     * @Author: Muhammad Waqar
     * @DateTime : 17-12-2019 (Tuesday)
     * @Description : Function To Send the Push Notifications. 
     * Cronjob To Run Every Minute to Check If There is any stopped Cronjob
     */
    // public function cronjob_push_notification_mobile() {
    //     $this->load->library('mongo_db_3');
    //     $db_3 = $this->mongo_db_3->customQuery();
    //     $api_url   = "http://35.171.172.15:3000/api/all_cronjobs";
    //     $data_json = file_get_contents($api_url);
    //     $data_arr  = (array)json_decode($data_json);
    //     $data_arr  = (array)$data_arr['data'];
    //     $arr       = json_decode(json_encode($data_arr) , true);
    //     $inactive  = false;
    //     // echo "<pre>";print_r(json_decode($data_arr));
    //     foreach ($arr as $row) {
    //         $url = $row['name'];
    //         $post['name'] = $url;
    //         $curl = curl_init();
    //         //
    //         curl_setopt_array($curl, array(
    //             CURLOPT_PORT           => "3000",
    //             CURLOPT_URL            => "http://35.171.172.15:3000/api/all_cronjobs",
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING       => "",
    //             CURLOPT_MAXREDIRS      => 10,
    //             CURLOPT_TIMEOUT        => 30,
    //             CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST  => "POST",
    //             CURLOPT_POSTFIELDS     => json_encode($post) ,
    //             CURLOPT_HTTPHEADER     => array(
    //                 "cache-control: no-cache",
    //                 "content-type: application/json"
    //             ) ,
    //         ));

    //         $response              = curl_exec($curl);
    //         $err                   = curl_error($curl);
            
    //         curl_close($curl);

    //         if ($err) {
    //             echo "cURL Error #:" . $err;
    //         }
    //         else {
    //             //echo $response;
    //         }
    //         $res_arr          = (array)json_decode($response);
    //         $res_arr          = $res_arr['data'];
    //         $res_arr          = json_decode(json_encode($res_arr) , true);
    //         $cron_duration    = $res_arr['cron_duration'];
    //         $last_updatedtime = $res_arr['last_updated_time_human_readible'];
            
    //         // $cron_duration_arr = explode(' ',$cron_duration);
    //         //Umer Abbas [6-11-19]
    //         $duration_arr     = str_split($cron_duration, 1);
    //         $time             = array_pop($duration_arr);
    //         $add_time         = strtoupper($time);
    //         $duration         = implode('', $duration_arr);

    //         $dt               = new DateTime($last_updatedtime);
    //         // echo $dt->format('Y-m-d H:i:s');
    //         $last_time        = date("Y-m-d H:i:s", strtotime($last_updatedtime));

    //         if ($time == 's') {
    //             $padding_duration = 2;
    //             $padding_time     = "M";
    //             $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
    //             $dt->add(new DateInterval($interval_str));
    //             $param            = 12;

    //         }
    //         else if ($time == 'm') {

    //             $padding_duration = 5;
    //             $duration         = $duration + $padding_duration;
    //             $interval_str     = "PT$duration$add_time";
    //             $dt->add(new DateInterval($interval_str));
    //             $param            = 300;

    //         }
    //         else if ($time == 'h') {

    //             $padding_duration = 15;
    //             $padding_time     = "M";
    //             $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
    //             $dt->add(new DateInterval($interval_str));

    //             $param        = 900;

    //         }
    //         else if ($time == 'd') {

    //             $interval_str = "P$duration$add_time";
    //             $dt->add(new DateInterval($interval_str));
    //             $padding_duration = 1;
    //             $padding_time     = "H";
    //             $interval_str     = "PT$padding_duration$padding_time";
    //             $dt->add(new DateInterval($interval_str));

    //             $param        = 3600;

    //         }
    //         else if ($time == 'w') {

    //             $interval_str = "P$duration$add_time";
    //             $dt->add(new DateInterval($interval_str));
    //             $padding_duration = 1;
    //             $padding_time     = "H";
    //             $interval_str     = "PT$padding_duration$padding_time";
    //             $dt->add(new DateInterval($interval_str));
    //             $param    = 3600;
    //         }

    //         $dt2 = new DateTime();
    //         $timezone = date_default_timezone_get();

    //         if ($dt2 <= $dt) {
    //             $data     = array(
    //                 "title" => "Cronjob Alert",
    //                 "url" => $url,
    //                 "last_run" => time_elapsed_string($last_updatedtime, $timezone, $full = true),
    //                 "priority" => "high",
    //                 "cron_duration" => $cron_duration
    //             );
    //             $updateCronWhere['_id'] = $this->mongo_db_3->mongoId($row['_id']);
    //             $updateArray = [
    //                 'status' => 'up',
    //             ];
    //             $set['$set'] = $updateArray;
    //             $db_3->cronjob_execution_logs->updateOne($updateCronWhere, $set);
    //         }
    //         else{
    //             if($res_arr['priority_setting'] == 'email') {
    //                 $displayArray = [
    //                     'status' => $row['status'], 
    //                     '_id' => $row['_id'],
    //                     'condition' => 'email'
    //                 ];

    //             }elseif($row['status'] == 'up'){
    //                 $displayArray = [
    //                     'status' => $row['status'], 
    //                     '_id' => $row['_id'],
    //                     'condition' => 'stop'
    //                 ];
    //                 $updateCronWhere['_id'] = $this->mongo_db_3->mongoId($row['_id']);
    //                 $updateArray = [
    //                     'status' => 'down',
    //                 ];
    //                 $set['$set'] = $updateArray;
    //                 $db_3->cronjob_execution_logs->updateOne($updateCronWhere, $set);
    //                 $inactive = true;
    //                 $timezone = "UTC";
    //                 $data     = array(
    //                     "title" => "Cronjob Alert",
    //                     "url" => $url,
    //                     "last_run" => time_elapsed_string($last_updatedtime, $timezone, $full = true),
    //                     "priority" => "high",
    //                     "cron_duration" => $cron_duration
    //                 );
    //                 //send push on mobile and Desktop
    //                 $this->desktop_notification($data);
    //                 $this->push_notifications->android_notification_topic($data);
    //             }
    //             $db = $this->mongo_db->customQuery();
    //             $whereHistorySave['dayMonth'] = date('m-d');
    //             $whereHistorySave['url'] = $url;
    //             $data['enteryTime'] = $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'));
    //             $upsert['upsert'] = true;
    //             $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $data], $upsert);
    //         }
    //     }
    //     $this->last_cron_execution_time('cronjob_push_notification', '1m', 'Cronjob to send alerts about stopped cronjob on mobile app');
    // }
    /**
     * End CronJob For Notification
    */
    // public function hourly_cron_notification(){
    //     // $this->cronjob_check_error_in_sell();
    //     $this->trade_on_off();
    //     // $this->autotradebox();
    //     // $this->newTicket();
    //     // $this->newUser();
    // }

    // public function trade_on_off(){
    //     $res_arr = $this->check_trading_on_off();
    //     if(!$res_arr['status']){
    //         $timezone = "UTC";
    //         $data     = array(
    //             "title" => "Trading Alert",
    //             "url" => "All Type of Trading is Off By Admin",
    //             "last_run" => "",
    //             "priority" => "medium",
    //             "cron_duration" => ""
    //         );
    //         $this->push_notifications->android_notification_topic($data);
    //     }
    // }

    /**
     * @Author: Muhammad Waqar
     * @DateTime : 17-12-2019 (Tuesday)
     * @Description : API For Dashboard Of APP. 
     * Cronjob To Run Every Minute to Check If There is any stopped Cronjob
     */
    // public function app_dashboard(){
        // $crons_json = $this->first_cron_cron_listing();
        // $error_in_sell_json = $this->error_in_sell_report();
        // $auto_trade_last_hour = $this->check_auto_trading_last_hour();
        // $trading_on_off = $this->check_trading_on_off();
        // $new_ticket_json = $this->check_new_ticket();
        // $new_user_json = $this->check_new_user();

    //     $final_json_arr = array(
    //         "cronbox" => $crons_json,
    //         "errorbox" => $error_in_sell_json,
    //         "autotradebox" => $auto_trade_last_hour,
    //         "tradeonoff" => $trading_on_off,
    //         "ticketbox" => $new_ticket_json,
    //         "newuserbox" => $new_user_json
    //     );

    //     $returnArr = array(
    //         "status" => 200,
    //         "data" => $final_json_arr,
    //         "message" => "Api Executed Successfully"
    //     );
    //     echo json_encode($returnArr);
    // }
    /**
     * End API For Dashboard Of APP
    */
    //HELPERS: 
    // public function first_cron_cron_listing(){
        
    //     // $data = $this->mongo_db->get('cronjob_execution_logs');
    //     // $data = iterator_to_array($data);

    //     $api_url = "http://35.171.172.15:3000/api/all_cronjobs";
    //     $data_json = file_get_contents($api_url);
    //     $data_arr = (array)json_decode($data_json);
    //     $data_arr = (array)$data_arr['data'];
    //     $arr = json_decode(json_encode($data_arr), TRUE);
        
    //     $inactive = false;
    //     foreach($arr as $row){
    //         $url = $row['name'];
    //         // $this->mongo_db->where(array('name' => $url));
    //         // $this->mongo_db->limit(1);
    //         // $this->mongo_db->order_by(array('_id' => -1));
    //         // $res = $this->mongo_db->get('cronjob_execution_logs');
    //         // $res_arr = iterator_to_array($res);

    //         // $cron_duration = $res_arr[0]['cron_duration'];
    //         // $last_updatedtime = $res_arr[0]['last_updated_time_human_readible'];

    //         $post['name'] = $url;
    //         $curl = curl_init();

    //         //
    //         curl_setopt_array($curl, array(
    //             CURLOPT_PORT => "3000",
    //             CURLOPT_URL => "http://35.171.172.15:3000/api/all_cronjobs",
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => "",
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 30,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => "POST",
    //             CURLOPT_POSTFIELDS => json_encode($post),
    //             CURLOPT_HTTPHEADER => array(
    //             "cache-control: no-cache",
    //             "content-type: application/json"
    //             ),
    //         ));

    //         $response = curl_exec($curl);
    //         $err = curl_error($curl);

    //         curl_close($curl);

    //         if ($err) {
    //             echo "cURL Error #:" . $err;
    //         } else {
    //             //echo $response;
    //         }
    //         $res_arr = (array)json_decode($response);
    //         $res_arr = $res_arr['data'];
    //         $res_arr = json_decode(json_encode($res_arr),TRUE);
    //         $cron_duration = $res_arr['cron_duration'];
    //         $last_updatedtime = $res_arr['last_updated_time_human_readible'];

    //         // $cron_duration_arr = explode(' ',$cron_duration);

    //         //Umer Abbas [6-11-19]
    //         $duration_arr = str_split($cron_duration,1);
    //         $time = array_pop($duration_arr);
    //         $add_time = strtoupper($time);
    //         $duration = implode('', $duration_arr);

    //         $dt = new DateTime($last_updatedtime);
    //         // echo $dt->format('Y-m-d H:i:s');

    //         $last_time = date("Y-m-d H:i:s", strtotime($last_updatedtime));

    //         if($time == 's'){
    //             $padding_duration = 2;
    //             $padding_time = "M";
    //             $interval_str = "PT$padding_duration$padding_time$duration$add_time";
    //             $dt->add(new DateInterval($interval_str));
    //             $param = 12;
                
    //         }else if($time == 'm'){
                
    //             $padding_duration = 5;
    //             $duration = $duration + $padding_duration;
    //             $interval_str = "PT$duration$add_time";
    //             $dt->add(new DateInterval($interval_str));
    //             $param = 300;
                
    //         }else if($time == 'h'){
                
    //             $padding_duration = 15;
    //             $padding_time = "M";
    //             $interval_str = "PT$duration$add_time$padding_duration$padding_time";
    //             $dt->add(new DateInterval($interval_str));

    //             $param = 900;
                
    //         }else if($time == 'd'){
                
    //             $interval_str = "P$duration$add_time";
    //             $dt->add(new DateInterval($interval_str));
    //             $padding_duration = 1;
    //             $padding_time = "H";
    //             $interval_str = "PT$padding_duration$padding_time";
    //             $dt->add(new DateInterval($interval_str));

    //             $param = 3600;
                
    //         }else if($time == 'w'){
                
    //             $interval_str = "P$duration$add_time";
    //             $dt->add(new DateInterval($interval_str));
    //             $padding_duration = 1;
    //             $padding_time = "H";
    //             $interval_str = "PT$padding_duration$padding_time";
    //             $dt->add(new DateInterval($interval_str));

    //             $param = 3600;
    //         }
        
    //         $dt2 = new DateTime();

    //         if($dt2 <= $dt){
    //             //echo $url . " Is Active <br>";
    //             // $inactive = true;
    //         }else{
    //             //echo $url . " Is Inactive <br>";
    //             $inactive = true;
    //         }
    //             }
    //     $data_to_return = array(
    //         "success" => $inactive,
    //         "url" => "https://app.digiebot.com/admin/cron_listing"
    //     );
    //     return ($data_to_return);
    // }

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

    //     return ($data_to_return);
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
    //     return ($data_to_return);
    // }

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
    //     return ($data_to_return);
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
    //     return ($data_to_return);
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
    //     return ($data_to_return);
    // }

    public function last_cron_execution_time($name, $duration, $summary){
        //Hit CURL to update last cron execution time
        $params = [
           'name' => $name,
           'cron_duration' => $duration, 
           'cron_summary' => $summary,
        ];
        $req_arr = [
            'req_type' => 'POST',
            'req_params' => $params,
            'req_endpoint' => '',
            'req_url' => 'http://35.171.172.15:3000/api/save_cronjob_execution',
        ];

  
        //print_r($req_arr);
       // curl_exec($req_arr);
        $resp = hitCurlRequest($req_arr);

    }//End last_cron_execution_time

    public function candle_trade_push_notification(){  //send volume and candle missing notification
        $current_time = date('Y-m-d H:i:s');
        $db = $this->mongo_db->customQuery();
        $collection_name = "trade_history_logs";
        $parameters = array(
            'start_hour' => '',
            'end_hour'   => ''
        );
        $parameter_jaso = json_encode($parameters);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://scripts.digiebot.com/admin/api/candle_alert_api/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 30,
            CURLOPT_TIMEOUT=> 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $parameter_jaso, 
            CURLOPT_HTTPHEADER => array( 
                "authorization: candle_alert:9284f328a447126e3163b43f62350e71",
                "cache-control: no-cache",
                "postman-token: 1e2d1784-df20-d2df-a4e7-5381d50bd5f6"),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $candle_trade_history_responce = json_decode($response);
        // echo "<pre>";print_r($candle_trade_history_responce);
        $countVolume = 0;
        $countCandle = 0;
        foreach($candle_trade_history_responce->Message->data as $value){
           if($value->candle == 'false' || $value->volume == 'false'){
              $data     = array(
                    "title" => "Candle or trade History data missing",
                    "priority" => "high",
                    "start_hour" => $candle_trade_history_responce->Message->post->start_hour,
                    "end_hour"   => $candle_trade_history_responce->Message->post->end_hour,
                    "coin"       => $value->coin 
                );
                if($value->candle== 'false'){
                    $data['candle_missed'] = true;
                }
                if($value->volume== 'false'){
                    $data['volume_missed'] = true;
                }
            }
            $data_insert     = array(
                "title"         => "Candle or trade History data missing",
                "priority"      => "high",
                "start_hour"    => $this->mongo_db->converToMongodttime($candle_trade_history_responce->Message->post->start_hour),
                "end_hour"      => $this->mongo_db->converToMongodttime($candle_trade_history_responce->Message->post->end_hour),
                "coin"          => $value->coin,
                "volume"        => $value->volume, 
                "candle"        => $value->candle,
                "cron_run_time" => $this->mongo_db->converToMongodttime($current_time),
            );
            // echo"<pre>";print_r($data_insert);
            $where['coin'] =  $value->coin;
            $where['start_hour'] = $this->mongo_db->converToMongodttime($candle_trade_history_responce->Message->post->start_hour);
            $where['end_hour']   = $this->mongo_db->converToMongodttime($candle_trade_history_responce->Message->post->end_hour);
            
            $upsert['upsert'] = true;
            $db->$collection_name->updateOne($where, ['$set' => $data_insert], $upsert);
            if($value->volume <= 90 && $value->coin != 'POEBTC' && $value->coin != 'ZENBTC' && $value->coin !='NCASHBTC'){
                $countVolume++;
                $data_insert['title'] = 'Volume Missing '.$value->coin;
                $this->push_notifications->android_notification_topic($data_insert);
            }
            if($value->candle == false && $value->coin != 'POEBTC' && $value->coin != 'ZENBTC' && $value->coin !='NCASHBTC'){
                $countCandle++;
                $data_insert['title'] = 'Candle Not Exists '.$value->coin;
                $this->push_notifications->android_notification_topic($data_insert);
            }
        }// end loop  
        if($countVolume == 0){
            $data_insert['title'] = 'Working Volume';
            $this->push_notifications->android_notification_topic($data_insert);
        }   
        if($countCandle == 0){
            $data_insert['title'] = 'Working candle';
            $this->push_notifications->android_notification_topic($data_insert);
        }   
    }// end function 

    public function trade_history_report(){
        $collection_name = "trade_history_logs";
        $db = $this->mongo_db->customQuery(); 
        $coins = $this->mod_coins->get_all_coins();
        $data['coins'] = $coins;

        //delete deta older than 15 days
        $current_to_previous = date('Y-m-d H:i:s', strtotime('-15 days'));
        $converted_time      = $this->mongo_db->converToMongodttime($current_to_previous);
        $where['cron_run_time'] = array('$lte' => $converted_time);
        $where['coin']['$in'] = array_column($coins, 'symbol');
        $db->$collection_name->deleteMany($where);
       //end 

        if($this->input->post('filter_by_coin')){
            $search_arr['coin']['$in'] = $this->input->post('filter_by_coin');
        }else{
            $search_arr['coin']['$in'] = array_column($coins, 'symbol');
        }

        if($this->input->post('filter_by_start_date')){
            $input_start = date('Y-m-d H:00:00', strtotime($_POST['filter_by_start_date']));
            $start_hour_convert = $this->mongo_db->converToMongodttime($input_start);
        
            $search_arr['start_hour'] = $start_hour_convert;
        }
        $sreach_date = $db->$collection_name->find($search_arr);
        $responce = iterator_to_array($sreach_date);

        $config['base_url'] = base_url() .'admin/Api_notifications/trade_history_report';
        $config['total_rows'] = count($responce);
    
        $config['per_page'] = 21;
        $config['num_links'] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 4;
        $config['reuse_query_string'] = TRUE;
    
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
    
        $config['prev_link'] = '&laquo;';
    
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
    
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
    
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
    
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
    
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            
        if($page !=0) 
        {
            $page = ($page-1) * $config['per_page'];
        }
        $data["links"] = $this->pagination->create_links();
        $query =
            [
                ['$match' => $search_arr],  
                ['$sort'  => ['start_hour' => -1]],
                ['$skip'  => $page],
                ['$limit' => $config['per_page']],
            ];
        $response_1 = $db->$collection_name->aggregate($query);   
        $response_data = iterator_to_array($response_1);
        $data['final_array'] = $response_data;
        $this->stencil->paint('admin/api_notification/data_history_report',$data);
    }//end function
    public function mobilePushNotificationALterCron(){
        $this->coinMetaPushNotificationForMobile();
        $this->marketPricesPushNotificationForMobile();
        $this->pickParentPushNotificationForMobile();
        $this->dailyLimitPushNotificationForMobile();
        $this->bnbPushNotificationForMobile();
        $this->updateQtyUSDWorthPushNotificationForMobile();
        $this->randomizeSortPushNotificationForMobile();
        $this->soldOrderminmaxPushNotificationForMobile();
        $this->tradingPointsPushNotificationForMobile();
        $this-> atgPushNotificationForMobile();
        $this->upDownServerStatusCheck();
        $this->reportsPushNotificationForMobile();
        $this->opportunityMissedAlert();
        $this->tradeHistoryPointsPushNotificationForMobile();
        $this->upDownServerManulEnteriesPushNotificationForMobile();
    }
    public function coinMetaPushNotificationForMobile() {  
        // $this->load->library('mongo_db_3');
        $db_3 = $this->mongo_db_3->customQuery();
        $where['type'] = 'coinMeta';
        $data = $db_3->cronjob_execution_logs->find($where);
        $coinMetaCrons = iterator_to_array($data);
        foreach ($coinMetaCrons as $value){
            $cron_duration    = $value['cron_duration'];
            $last_updatedtime = $value['last_updated_time_human_readible'];

            $duration_arr     = str_split($cron_duration, 1);
            $time             = array_pop($duration_arr);
            $add_time         = strtoupper($time);
            $duration         = implode('', $duration_arr);

            $dt               = new DateTime($last_updatedtime);
            $last_time        = date("Y-m-d H:i:s", strtotime($last_updatedtime));

            if ($time == 's') {
                $padding_duration = 2;
                $padding_time     = "M";
                $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 12;

            }
            else if ($time == 'm') {

                $padding_duration = 5;
                $duration         = $duration + $padding_duration;
                $interval_str     = "PT$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 300;

            }
            else if ($time == 'h') {
                $padding_duration = 15;
                $padding_time     = "M";
                $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param        = 900;
            }
            else if ($time == 'd') {
                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param        = 3600;
            }
            else if ($time == 'w') {
                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param    = 3600;
            }
            $dt2 = new DateTime();
            $timezone = date_default_timezone_get();

            if ($dt2 <= $dt) {
                $data     = array(
                    "name" => $value['name']
                );
            }else{
                $inactive = true;
                $timezone = "UTC";
                $data     = array(
                    "name" => $value['name']
                );
                $res[] = $data;
                $db = $this->mongo_db->customQuery();
                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['name'] = $value['name'];

                $data1 = [
                    'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'url'        =>  $value['name'],
                    'cron_duration'  => $cron_duration,
                    'priority'       => 'high',
                    'last_run'       => $this->mongo_db->converToMongodttime($last_updatedtime)

                ];

                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $data1], $upsert);
            }
        }//end foreach
        if(count($res) > 0){
            $result['url'] = $res;
            $data1['title'] = 'Coin Meta Stop';
            $data = array_merge( $data1, $result);
            echo json_encode($data);
            $this->push_notifications->android_notification_topic($data);
        }else{
            $working['title'] = 'Working Coin Meta';
            echo json_encode($working);
            $this->push_notifications->android_notification_topic($working);
        }
        $this->last_cron_execution_time('cronjob_push_notification', '1m', 'Cronjob to send alerts about stopped cronjob on mobile app');
    }
    public function marketPricesPushNotificationForMobile() {        
        
        $db_3 = $this->mongo_db_3->customQuery();
        $where['type'] = 'marketPrices';
        $data = $db_3->cronjob_execution_logs->find($where);
        $coinMetaCrons = iterator_to_array($data);
        foreach ($coinMetaCrons as $value){
            $cron_duration    = $value['cron_duration'];
            $last_updatedtime = $value['last_updated_time_human_readible'];
            $duration_arr     = str_split($cron_duration, 1);
            $time             = array_pop($duration_arr);
            $add_time         = strtoupper($time);
            $duration         = implode('', $duration_arr);
            $dt               = new DateTime($last_updatedtime);
            $last_time        = date("Y-m-d H:i:s", strtotime($last_updatedtime));;
            if ($time == 's') {
                $padding_duration = 2;
                $padding_time     = "M";
                $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 12;

            }
            else if ($time == 'm') {

                $padding_duration = 5;
                $duration         = $duration + $padding_duration;
                $interval_str     = "PT$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 300;

            }
            else if ($time == 'h') {

                $padding_duration = 15;
                $padding_time     = "M";
                $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 900;

            }
            else if ($time == 'd') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 3600;

            }
            else if ($time == 'w') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param    = 3600;
            }

            $dt2 = new DateTime();
            $timezone = date_default_timezone_get();

            if ($dt2 <= $dt) {
                $data     = array(
                    "name" => $value['name']
                );
                $updateCronWhere['_id'] = $this->mongo_db_3->mongoId($value['_id']);
                $updateArray = [
                    'status' => 'up',
                ];
                $set['$set'] = $updateArray;
                $db_3->cronjob_execution_logs->updateOne($updateCronWhere, $set);
            }else{
                $updateCronWhere['_id'] = $this->mongo_db_3->mongoId($value['_id']);
                $updateArray = [
                    'status' => 'down',
                ];
                $set['$set'] = $updateArray;
                $db_3->cronjob_execution_logs->updateOne($updateCronWhere, $set);

                $inactive = true;
                $timezone = "UTC";
                $data     = array(
                    "name" => $value['name']
                );
                $res[] = $data;
                $db = $this->mongo_db->customQuery();
                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['name'] = $value['name'];

                $data1 = [
                    'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'url'        =>  $value['name'],
                    'cron_duration'  => $cron_duration,
                    'priority'       => 'high',
                    'last_run'       => $this->mongo_db->converToMongodttime($last_updatedtime)

                ];

                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $data1], $upsert);
            }
        }//end foreach
        if(count($res) > 0){
            $result['url'] = $res;
            $data1['title'] = 'Market Prices Stopped';
            $data = array_merge( $data1, $result);
            echo json_encode($data);
            $this->push_notifications->android_notification_topic($data);
        }else{
            $working['title'] = 'Working Market Prices';
            echo json_encode($working);
            $this->push_notifications->android_notification_topic($working);
        }
        $this->last_cron_execution_time('cronjob_push_notification', '1m', 'Cronjob to send alerts about stopped cronjob on mobile app');
    }
    public function reportsPushNotificationForMobile() {        
        // $this->load->library('mongo_db_3');
        $db_3 = $this->mongo_db_3->customQuery();
        $where['type'] = 'reports';
        $returnData = $db_3->cronjob_execution_logs->find($where);
        $reports = iterator_to_array($returnData);

        // echo "<pre>";print_r($reports);

        foreach ($reports as $value){
            $cron_duration    = $value['cron_duration'];
            $last_updatedtime = $value['last_updated_time_human_readible'];

            $time       =  preg_replace('/[^a-zA-Z]/', '', $cron_duration);
            $add_time   =  strtoupper($time);
           
            $duration   = preg_replace('/[^0-9]/', '', $cron_duration);
            $dt               = new DateTime($last_updatedtime);

            $last_time = date("Y-m-d H:i:s", strtotime($last_updatedtime));
            if ($time == 's') {
                $padding_duration = 2;
                $padding_time     = "M";
                $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 12;

            }
            else if ($time == 'm') {

                $padding_duration = 5;
                $duration         = $duration + $padding_duration;
                $interval_str     = "PT$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 300;

            }
            else if ($time == 'h') {

                $padding_duration = 15;
                $padding_time     = "M";
                $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 900;

            }
            else if ($time == 'd') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 3600;

            }
            else if ($time == 'w') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param    = 3600;
            }

            $dt2 = new DateTime();
            $timezone = date_default_timezone_get();
            if ($dt2 <= $dt) {
                $data     = array(
                    "name" => $value['name']
                );
            }else{
                $inactive = true;
                $timezone = "UTC";
                $data     = array(
                    "name" => $value['name']
                );
                $res[] = $data;
                $db = $this->mongo_db->customQuery();
                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['name'] = $value['name'];

                $insert = [
                    'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'url'        =>  $value['name'],
                    'cron_duration'  => $cron_duration,
                    'priority'       => 'high',
                    'last_run'       => $this->mongo_db->converToMongodttime($last_updatedtime)

                ];

                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);
            }
        }//end foreach
        if(count($res) > 0){
            $result['url'] = $res;
            $data1['title'] = 'Reports Are Stopped';
            // $data1['title'] = 'Reports ruk ge ha please wasiq check Thank you';
            $data = array_merge( $data1, $result);
            echo json_encode($data);
            $this->push_notifications->android_notification_topic($data);
        }else{
            $working['title'] = 'Working Reports';
            echo json_encode($working);
            $this->push_notifications->android_notification_topic($working);
        }
        $this->last_cron_execution_time('cronjob_push_notification', '1m', 'Cronjob to send alerts about stopped cronjob on mobile app');
    }
    public function atgPushNotificationForMobile() {        
        // $this->load->library('mongo_db_3');
        $db_3 = $this->mongo_db_3->customQuery();
        $where['type'] = 'atg';
        $data = $db_3->cronjob_execution_logs->find($where);
        $coinMetaCrons = iterator_to_array($data);
        foreach ($coinMetaCrons as $value){
            $cron_duration    = $value['cron_duration'];
            $last_updatedtime = $value['last_updated_time_human_readible'];

            $duration_arr     = str_split($cron_duration, 1);
            $time             = array_pop($duration_arr);
            $add_time         = strtoupper($time);
            $duration         = implode('', $duration_arr);

            $dt               = new DateTime($last_updatedtime);
            $last_time        = date("Y-m-d H:i:s", strtotime($last_updatedtime));

            if ($time == 's') {
                $padding_duration = 2;
                $padding_time     = "M";
                $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 12;

            }
            else if ($time == 'm') {

                $padding_duration = 5;
                $duration         = $duration + $padding_duration;
                $interval_str     = "PT$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 300;

            }
            else if ($time == 'h') {

                $padding_duration = 15;
                $padding_time     = "M";
                $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 900;

            }
            else if ($time == 'd') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 3600;

            }
            else if ($time == 'w') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param    = 3600;
            }

            $dt2 = new DateTime();
            $timezone = date_default_timezone_get();

            if ($dt2 <= $dt) {
                $data     = array(
                    "name" => $value['name']
                );
            }else{
                $inactive = true;
                $timezone = "UTC";
                $data     = array(
                    "name" => $value['name']
                );
                $res[] = $data;
                $db = $this->mongo_db->customQuery();
                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['name'] = $value['name'];

                $insert = [
                    'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'url'        =>  $value['name'],
                    'cron_duration'  => $cron_duration,
                    'priority'       => 'high',
                    'last_run'       => $this->mongo_db->converToMongodttime($last_updatedtime)

                ];

                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);
            }
        }//end foreach
        if(count($res) > 0){
            $result['url'] = $res;
            $data1['title'] = 'Atg Stopped';
            $data = array_merge($data1, $result);
            echo json_encode($data);
            $this->push_notifications->android_notification_topic($data);
        }else{
            $working['title'] = 'Working ATG';
            echo json_encode($working);
            $this->push_notifications->android_notification_topic($working);
        }
        $this->last_cron_execution_time('cronjob_push_notification', '1m', 'Cronjob to send alerts about stopped cronjob on mobile app');
    }
    public function pickParentPushNotificationForMobile() {        
        // $this->load->library('mongo_db_3');
        $db_3 = $this->mongo_db_3->customQuery();
        $where['type'] = 'pickParent';
        $data = $db_3->cronjob_execution_logs->find($where);
        $coinMetaCrons = iterator_to_array($data);
        foreach ($coinMetaCrons as $value){
            $cron_duration    = $value['cron_duration'];
            $last_updatedtime = $value['last_updated_time_human_readible'];

            $duration_arr     = str_split($cron_duration, 1);
            $time             = array_pop($duration_arr);
            $add_time         = strtoupper($time);
            $duration         = implode('', $duration_arr);

            $dt               = new DateTime($last_updatedtime);
            $last_time        = date("Y-m-d H:i:s", strtotime($last_updatedtime));

            if ($time == 's') {
                $padding_duration = 2;
                $padding_time     = "M";
                $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 12;

            }
            else if ($time == 'm') {

                $padding_duration = 5;
                $duration         = $duration + $padding_duration;
                $interval_str     = "PT$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 300;

            }
            else if ($time == 'h') {

                $padding_duration = 15;
                $padding_time     = "M";
                $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 900;

            }
            else if ($time == 'd') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 3600;

            }
            else if ($time == 'w') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param    = 3600;
            }

            $dt2 = new DateTime();
            $timezone = date_default_timezone_get();

            if ($dt2 <= $dt) {
                $data     = array(
                    "name" => $value['name']
                );
            }else{
                $inactive = true;
                $timezone = "UTC";
                $data     = array(
                    "name" => $value['name']
                );
                $res[] = $data; 
                $db = $this->mongo_db->customQuery();
                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['name'] = $value['name'];

                $insert = [
                    'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'url'        =>  $value['name'],
                    'cron_duration'  => $cron_duration,
                    'priority'       => 'high',
                    'last_run'       => $this->mongo_db->converToMongodttime($last_updatedtime)

                ];

                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);
            }
        }//end foreach
        if(count($res) > 0){
            $result['url'] = $res;
            $data1['title'] = 'PICK Parent Cron Stopped';
            $data = array_merge( $data1, $result);
            echo json_encode($data);
            $this->push_notifications->android_notification_topic($data);
        }else{
            $working['title'] = 'Working Pick Parent';
            echo json_encode($working);
            $this->push_notifications->android_notification_topic($working);
        }
        $this->last_cron_execution_time('cronjob_push_notification', '1m', 'Cronjob to send alerts about stopped cronjob on mobile app');
    }
    public function dailyLimitPushNotificationForMobile() {        
        // $this->load->library('mongo_db_3');
        $db_3 = $this->mongo_db_3->customQuery();
        $where['type'] = 'dailyLimit';
        $data = $db_3->cronjob_execution_logs->find($where);
        $coinMetaCrons = iterator_to_array($data);
        foreach ($coinMetaCrons as $value){
            $cron_duration    = $value['cron_duration'];
            $last_updatedtime = $value['last_updated_time_human_readible'];

            $duration_arr     = str_split($cron_duration, 1);
            $time             = array_pop($duration_arr);
            $add_time         = strtoupper($time);
            $duration         = implode('', $duration_arr);

            $dt               = new DateTime($last_updatedtime);
            $last_time        = date("Y-m-d H:i:s", strtotime($last_updatedtime));

            if ($time == 's') {
                $padding_duration = 2;
                $padding_time     = "M";
                $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 12;

            }
            else if ($time == 'm') {

                $padding_duration = 5;
                $duration         = $duration + $padding_duration;
                $interval_str     = "PT$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 300;

            }
            else if ($time == 'h') {

                $padding_duration = 15;
                $padding_time     = "M";
                $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 900;

            }
            else if ($time == 'd') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 3600;

            }
            else if ($time == 'w') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param    = 3600;
            }

            $dt2 = new DateTime();
            $timezone = date_default_timezone_get();

            if ($dt2 <= $dt) {
                $data     = array(
                    "name" => $value['name']
                );
            }else{
                $inactive = true;
                $timezone = "UTC";
                $data     = array(
                    "name" => $value['name']
                );
                $res[] = $data;
                $db = $this->mongo_db->customQuery();
                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['name'] = $value['name'];

                $insert = [
                    'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'url'        =>  $value['name'],
                    'cron_duration'  => $cron_duration,
                    'priority'       => 'high',
                    'last_run'       => $this->mongo_db->converToMongodttime($last_updatedtime)

                ];

                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);
            }
        }//end foreach
        if(count($res) > 0){
            $result['url'] = $res;
            $data1['title'] = 'Daily Limit buy Worth Cron Stopped';
            $data = array_merge( $data1, $result);
            echo json_encode($data);
            $this->push_notifications->android_notification_topic($data);
        }else{
            $working['title'] = 'Working Daily Limit Buy Worth';
            echo json_encode($working);
            $this->push_notifications->android_notification_topic($working);
        }
        $this->last_cron_execution_time('cronjob_push_notification', '1m', 'Cronjob to send alerts about stopped cronjob on mobile app');
    }
    public function bnbPushNotificationForMobile() {        
        // $this->load->library('mongo_db_3');
        $db_3 = $this->mongo_db_3->customQuery();
        $where['type'] = 'bnb';
        $data = $db_3->cronjob_execution_logs->find($where);
        $coinMetaCrons = iterator_to_array($data);
        foreach ($coinMetaCrons as $value){
            $cron_duration    = $value['cron_duration'];
            $last_updatedtime = $value['last_updated_time_human_readible'];

            $duration_arr     = str_split($cron_duration, 1);
            $time             = array_pop($duration_arr);
            $add_time         = strtoupper($time);
            $duration         = implode('', $duration_arr);

            $dt               = new DateTime($last_updatedtime);
            $last_time        = date("Y-m-d H:i:s", strtotime($last_updatedtime));

            if ($time == 's') {
                $padding_duration = 2;
                $padding_time     = "M";
                $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 12;

            }
            else if ($time == 'm') {

                $padding_duration = 5;
                $duration         = $duration + $padding_duration;
                $interval_str     = "PT$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 300;

            }
            else if ($time == 'h') {

                $padding_duration = 15;
                $padding_time     = "M";
                $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 900;

            }
            else if ($time == 'd') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 3600;

            }
            else if ($time == 'w') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param    = 3600;
            }

            $dt2 = new DateTime();
            $timezone = date_default_timezone_get();

            if ($dt2 <= $dt) {
                $data     = array(
                    "name" => $value['name']
                );
            }else{
                $inactive = true;
                $timezone = "UTC";
                $data     = array(
                    "name" => $value['name']
                );
                $res[] = $data;
                $db = $this->mongo_db->customQuery();
                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['name'] = $value['name'];

                $insert = [
                    'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'url'        =>  $value['name'],
                    'cron_duration'  => $cron_duration,
                    'priority'       => 'high',
                    'last_run'       => $this->mongo_db->converToMongodttime($last_updatedtime)

                ];

                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);
            }
        }//end foreach
        if(count($res) > 0){
            $result['url'] = $res;
            $data1['title'] = 'BNB Auto Buy Cron Stopped';
            $data = array_merge( $data1, $result);
            echo json_encode($data);
            $this->push_notifications->android_notification_topic($data);
        }else{
            $working['title'] = 'Working BNB Auto Buy';
            echo json_encode($working);
            $this->push_notifications->android_notification_topic($working);
        }
        $this->last_cron_execution_time('cronjob_push_notification', '1m', 'Cronjob to send alerts about stopped cronjob on mobile app');
    }
    public function updateQtyUSDWorthPushNotificationForMobile() {        
        // $this->load->library('mongo_db_3');
        $db_3 = $this->mongo_db_3->customQuery();
        $where['type'] = 'updateQtyUSDWorth';
        $data = $db_3->cronjob_execution_logs->find($where);
        $coinMetaCrons = iterator_to_array($data);
        foreach ($coinMetaCrons as $value){
            $cron_duration    = $value['cron_duration'];
            $last_updatedtime = $value['last_updated_time_human_readible'];

            $duration_arr     = str_split($cron_duration, 1);
            $time             = array_pop($duration_arr);
            $add_time         = strtoupper($time);
            $duration         = implode('', $duration_arr);

            $dt               = new DateTime($last_updatedtime);
            $last_time        = date("Y-m-d H:i:s", strtotime($last_updatedtime));

            if ($time == 's') {
                $padding_duration = 2;
                $padding_time     = "M";
                $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 12;

            }
            else if ($time == 'm') {

                $padding_duration = 5;
                $duration         = $duration + $padding_duration;
                $interval_str     = "PT$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 300;

            }
            else if ($time == 'h') {

                $padding_duration = 15;
                $padding_time     = "M";
                $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 900;

            }
            else if ($time == 'd') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 3600;

            }
            else if ($time == 'w') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param    = 3600;
            }

            $dt2 = new DateTime();
            $timezone = date_default_timezone_get();

            if ($dt2 <= $dt) {
                $data     = array(
                    "name" => $value['name']
                );
            }else{
                $inactive = true;
                $timezone = "UTC";
                $data     = array(
                    "name" => $value['name']
                );
                $res[] = $data;
                $db = $this->mongo_db->customQuery();
                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['name'] = $value['name'];

                $insert = [
                    'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'url'        =>  $value['name'],
                    'cron_duration'  => $cron_duration,
                    'priority'       => 'high',
                    'last_run'       => $this->mongo_db->converToMongodttime($last_updatedtime)

                ];

                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);
            }
        }//end foreach
        if(count($res) > 0){
            $result['url'] = $res;
            $data1['title'] = 'Update Quantity by USDT Worth Cron Stopped';
            $data = array_merge( $data1, $result);
            echo json_encode($data);
            $this->push_notifications->android_notification_topic($data);
        }else{
            $working['title'] = 'Working Update Qty USDT';
            echo json_encode($working);
            $this->push_notifications->android_notification_topic($working);
        }
        $this->last_cron_execution_time('cronjob_push_notification', '1m', 'Cronjob to send alerts about stopped cronjob on mobile app');
    }
    public function randomizeSortPushNotificationForMobile() {        
        // $this->load->library('mongo_db_3');
        $db_3 = $this->mongo_db_3->customQuery();
        $where['type'] = 'randomizeSort';
        $data = $db_3->cronjob_execution_logs->find($where);
        $coinMetaCrons = iterator_to_array($data);
        foreach ($coinMetaCrons as $value){
            $cron_duration    = $value['cron_duration'];
            $last_updatedtime = $value['last_updated_time_human_readible'];

            $duration_arr     = str_split($cron_duration, 1);
            $time             = array_pop($duration_arr);
            $add_time         = strtoupper($time);
            $duration         = implode('', $duration_arr);

            $dt               = new DateTime($last_updatedtime);
            $last_time        = date("Y-m-d H:i:s", strtotime($last_updatedtime));

            if ($time == 's') {
                $padding_duration = 2;
                $padding_time     = "M";
                $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 12;

            }
            else if ($time == 'm') {

                $padding_duration = 5;
                $duration         = $duration + $padding_duration;
                $interval_str     = "PT$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 300;

            }
            else if ($time == 'h') {

                $padding_duration = 15;
                $padding_time     = "M";
                $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 900;

            }
            else if ($time == 'd') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 3600;

            }
            else if ($time == 'w') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param    = 3600;
            }

            $dt2 = new DateTime();
            $timezone = date_default_timezone_get();

            if ($dt2 <= $dt) {
                $data     = array(
                    "name" => $value['name']
                );
            }else{
                $inactive = true;
                $timezone = "UTC";
                $data     = array(
                    "name" => $value['name']
                );
                $res[] = $data;
                $db = $this->mongo_db->customQuery();
                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['name'] = $value['name'];

                $insert = [
                    'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'url'        =>  $value['name'],
                    'cron_duration'  => $cron_duration,
                    'priority'       => 'high',
                    'last_run'       => $this->mongo_db->converToMongodttime($last_updatedtime)

                ];

                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);
            }
        }//end foreach
        if(count($res) > 0){
            $result['url'] = $res;
            $data1['title'] = 'Randomize Sort Cron Stopped';
            $data = array_merge( $data1, $result);
            echo json_encode($data);
            $this->push_notifications->android_notification_topic($data);
        }else{
            $working['title'] = 'Working Randomize Sort';
            echo json_encode($working);
            $this->push_notifications->android_notification_topic($working);
        }
        $this->last_cron_execution_time('cronjob_push_notification', '1m', 'Cronjob to send alerts about stopped cronjob on mobile app');
    }
    public function soldOrderminmaxPushNotificationForMobile() {        
        // $this->load->library('mongo_db_3');
        $db_3 = $this->mongo_db_3->customQuery();
        $where['type'] = 'soldOrderminmax';
        $data = $db_3->cronjob_execution_logs->find($where);
        $coinMetaCrons = iterator_to_array($data);
        foreach ($coinMetaCrons as $value){
            $cron_duration    = $value['cron_duration'];
            $last_updatedtime = $value['last_updated_time_human_readible'];

            $duration_arr     = str_split($cron_duration, 1);
            $time             = array_pop($duration_arr);
            $add_time         = strtoupper($time);
            $duration         = implode('', $duration_arr);

            $dt               = new DateTime($last_updatedtime);
            $last_time        = date("Y-m-d H:i:s", strtotime($last_updatedtime));

            if ($time == 's') {
                $padding_duration = 2;
                $padding_time     = "M";
                $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 12;

            }
            else if ($time == 'm') {

                $padding_duration = 5;
                $duration         = $duration + $padding_duration;
                $interval_str     = "PT$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 300;

            }
            else if ($time == 'h') {

                $padding_duration = 15;
                $padding_time     = "M";
                $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 900;

            }
            else if ($time == 'd') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 3600;

            }
            else if ($time == 'w') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param    = 3600;
            }

            $dt2 = new DateTime();
            $timezone = date_default_timezone_get();

            if ($dt2 <= $dt) {
                $data     = array(
                    "name" => $value['name']
                );
            }else{
                $inactive = true;
                $timezone = "UTC";
                $data     = array(
                    "name" => $value['name']
                );
                $res[] = $data;
                $db = $this->mongo_db->customQuery();
                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['name'] = $value['name'];

                $insert = [
                    'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'url'        =>  $value['name'],
                    'cron_duration'  => $cron_duration,
                    'priority'       => 'high',
                    'last_run'       => $this->mongo_db->converToMongodttime($last_updatedtime)

                ];

                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);
            }
        }//end foreach
        if(count($res) > 0){
            $result['url'] = $res;
            $data1['title'] = 'Sold Orders Min/Max Cron Stopped';
            $data = array_merge( $data1, $result);
            echo json_encode($data);
            $this->push_notifications->android_notification_topic($data);
        }else{
            $working['title'] = 'Working Sold Orders Min/Max';
            echo json_encode($working);
            $this->push_notifications->android_notification_topic($working);
        }
        $this->last_cron_execution_time('cronjob_push_notification', '1m', 'Cronjob to send alerts about stopped cronjob on mobile app');
    }
    public function tradingPointsPushNotificationForMobile() {        
        // $this->load->library('mongo_db_3');
        $db_3 = $this->mongo_db_3->customQuery();
        $where['type'] = 'tradingPoints';
        $data = $db_3->cronjob_execution_logs->find($where);
        $coinMetaCrons = iterator_to_array($data);
        foreach ($coinMetaCrons as $value){
            $cron_duration    = $value['cron_duration'];
            $last_updatedtime = $value['last_updated_time_human_readible'];

            $duration_arr     = str_split($cron_duration, 1);
            $time             = array_pop($duration_arr);
            $add_time         = strtoupper($time);
            $duration         = implode('', $duration_arr);

            $dt               = new DateTime($last_updatedtime);
            $last_time        = date("Y-m-d H:i:s", strtotime($last_updatedtime));

            if ($time == 's') {
                $padding_duration = 2;
                $padding_time     = "M";
                $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 12;

            }
            else if ($time == 'm') {

                $padding_duration = 5;
                $duration         = $duration + $padding_duration;
                $interval_str     = "PT$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 300;

            }
            else if ($time == 'h') {

                $padding_duration = 15;
                $padding_time     = "M";
                $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 900;

            }
            else if ($time == 'd') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 3600;

            }
            else if ($time == 'w') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param    = 3600;
            }

            $dt2 = new DateTime();
            $timezone = date_default_timezone_get();

            if ($dt2 <= $dt) {
                $data     = array(
                    "name" => $value['name']
                );
            }else{
                $inactive = true;
                $timezone = "UTC";
                $data     = array(
                    "name" => $value['name']
                );
                $res[] = $data;
                $db = $this->mongo_db->customQuery();
                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['name'] = $value['name'];

                $insert = [
                    'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'url'        =>  $value['name'],
                    'cron_duration'  => $cron_duration,
                    'priority'       => 'high',
                    'last_run'       => $this->mongo_db->converToMongodttime($last_updatedtime)

                ];

                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);
            }
        }//end foreach
        if(count($res) > 0){
            $result['url'] = $res;
            $data1['title'] = 'trading Points Cron Stopped';
            $data = array_merge( $data1, $result);
            echo json_encode($data);
            $this->push_notifications->android_notification_topic($data);
        }else{
            $working['title'] = 'Working Trading Points';
            echo json_encode($working);
            $this->push_notifications->android_notification_topic($working);
        }
        $this->last_cron_execution_time('cronjob_push_notification', '1m', 'Cronjob to send alerts about stopped cronjob on mobile app');
    }

    public function tradeHistoryPointsPushNotificationForMobile() {        
        // $this->load->library('mongo_db_3');
        $db_3 = $this->mongo_db_3->customQuery();
        $where['type'] = 'tradeHistory';
        $data = $db_3->cronjob_execution_logs->find($where);
        $coinMetaCrons = iterator_to_array($data);
        foreach ($coinMetaCrons as $value){
            $cron_duration    = $value['cron_duration'];
            $last_updatedtime = $value['last_updated_time_human_readible'];

            $duration_arr     = str_split($cron_duration, 1);
            $time             = array_pop($duration_arr);
            $add_time         = strtoupper($time);
            $duration         = implode('', $duration_arr);

            $dt               = new DateTime($last_updatedtime);
            $last_time        = date("Y-m-d H:i:s", strtotime($last_updatedtime));

            if ($time == 's') {
                $padding_duration = 2;
                $padding_time     = "M";
                $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 12;

            }
            else if ($time == 'm') {

                $padding_duration = 5;
                $duration         = $duration + $padding_duration;
                $interval_str     = "PT$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 300;

            }
            else if ($time == 'h') {

                $padding_duration = 15;
                $padding_time     = "M";
                $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 900;

            }
            else if ($time == 'd') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 3600;

            }
            else if ($time == 'w') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param    = 3600;
            }

            $dt2 = new DateTime();
            $timezone = date_default_timezone_get();

            if ($dt2 <= $dt) {
                $data     = array(
                    "name" => $value['name']
                );
            }else{
                $inactive = true;
                $timezone = "UTC";
                $data     = array(
                    "name" => $value['name']
                );
                $res[] = $data;
                $db = $this->mongo_db->customQuery();
                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['name'] = $value['name'];

                $insert = [
                    'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'url'        =>  $value['name'],
                    'cron_duration'  => $cron_duration,
                    'priority'       => 'high',
                    'last_run'       => $this->mongo_db->converToMongodttime($last_updatedtime)

                ];

                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);
            }
        }//end foreach
        if(count($res) > 0){
            $result['url'] = $res;
            $data1['title'] = 'Trade History Crone Stopped';
            $data = array_merge( $data1, $result);
            echo json_encode($data);
            $this->push_notifications->android_notification_topic($data);
        }else{
            $working['title'] = 'Working Trade History Crone';
            echo json_encode($working);
            $this->push_notifications->android_notification_topic($working);
        }
        $this->last_cron_execution_time('cronjob_push_notification', '1m', 'Cronjob to send alerts about stopped cronjob on mobile app');
    }

    public function upDownServerStatusCheck(){
        $db = $this->mongo_db->customQuery();
        $whereHistorySave['dayMonth'] = date('m-d');

        $working['title'] = 'Server is Down';
        $adminIp = "3.225.96.166";
        $adminPort = "80";
        if (! $sock=@fsockopen($adminIp, $adminPort, $num, $error, 20)){
            $stop['url'][]['name'] = 'Admin.digiebot server is down ip: '.$adminIp.' port: '.$adminPort." system Level erro Number: ".$num." error: ".$error;

            $whereHistorySave['name'] = 'Admin.digiebot server is down';
            $upsert['upsert'] = true;

            $insert = [
                'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                'url'        =>  'Admin.digiebot server is down',
                'cron_duration'  => '',
                'priority'       => 'high',
                'last_run'       => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))

            ];

            $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);

        }

        //rules.digiebot 
        $ruleIp = "3.232.17.202";
        $rulePort = "80";
        if (! $sock=@fsockopen($ruleIp, $rulePort, $num, $error, 20)){
            $stop['url'][]['name'] = 'rule.digiebot server is down ip: '.$ruleIp.' port: '.$rulePort." system Level erro Number: ".$num." error: ".$error;

            $whereHistorySave['name'] = 'rule.digiebot server is down';

            $insert = [
                'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                'url'        =>  'rule.digiebot server is down',
                'cron_duration'  => '',
                'priority'       => 'high',
                'last_run'       => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))

            ];

            $upsert['upsert'] = true;
            $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);
        }

        // users.digiebot alert
        $userIp = "3.230.138.47";
        $userport = "80";
        if (! $sock=@fsockopen($userIp, $userport, $num, $error, 20)){
            $stop['url'][]['name'] = 'User.digiebot server down ip : '.$userIp.' port: '.$userport." system Level erro Number: ".$num." error: ".$error;
            
            $whereHistorySave['name'] = 'User.digiebot server down';

            $insert = [
                'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                'url'        =>  'User.digiebot server down',
                'cron_duration'  => '',
                'priority'       => 'high',
                'last_run'       => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))

            ];

            $upsert['upsert'] = true;
            $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);
        }
        // trading.digiebot alert
        $tradingIp = "34.205.124.51";
        $tradingPort = "80";
        if (! $sock=@fsockopen($tradingIp, $tradingPort, $num, $error, 20)){
            $stop['url'][]['name'] = 'Trading.digiebot server down ip: '.$tradingIp.' port: '.$tradingPort." system Level erro Number: ".$num." error: ".$error;

            $whereHistorySave['name'] = 'Trading.digiebot server down';
            $insert = [
                'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                'url'        =>  'Trading.digiebot server down',
                'cron_duration'  => '',
                'priority'       => 'high',
                'last_run'       => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))

            ];
            $upsert['upsert'] = true;
            $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);

        }

        if(count($stop) > 0){
            $final  = array_merge($working, $stop);
            echo json_encode($final);
            $this->push_notifications->android_notification_topic($final);
        }else{
            $working1['title'] = 'Server is Working';
            echo json_encode($working1);
            $this->push_notifications->android_notification_topic($working1);
        }
    }

    public function upDownServerManulEnteriesPushNotificationForMobile() {        
        $db_3 = $this->mongo_db_3->customQuery();
        $where['type'] = 'server';
        $returnData = $db_3->cronjob_execution_logs->find($where);
        $reports = iterator_to_array($returnData);

        foreach ($reports as $value){
            $cron_duration    = $value['cron_duration'];
            $last_updatedtime = $value['last_updated_time_human_readible'];

            $time       =  preg_replace('/[^a-zA-Z]/', '', $cron_duration);
            $add_time   =  strtoupper($time);
           
            $duration   = preg_replace('/[^0-9]/', '', $cron_duration);
            $dt               = new DateTime($last_updatedtime);

            $last_time = date("Y-m-d H:i:s", strtotime($last_updatedtime));
            if ($time == 's') {
                $padding_duration = 2;
                $padding_time     = "M";
                $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 12;

            }
            else if ($time == 'm') {

                $padding_duration = 5;
                $duration         = $duration + $padding_duration;
                $interval_str     = "PT$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 300;

            }
            else if ($time == 'h') {

                $padding_duration = 15;
                $padding_time     = "M";
                $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 900;

            }
            else if ($time == 'd') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 3600;

            }
            else if ($time == 'w') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param    = 3600;
            }

            $dt2 = new DateTime();
            $timezone = date_default_timezone_get();
            if ($dt2 <= $dt) {
                $data     = array(
                    "name" => $value['name']
                );
            }else{
                $inactive = true;
                $timezone = "UTC";
                $data     = array(
                    "name" => $value['cron_summary']
                );
                $res[] = $data;
                $db = $this->mongo_db->customQuery();
                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['name'] = $value['name'];

                $insert = [
                    'enteryTime'     =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'url'            =>  $value['name'],
                    'cron_duration'  =>  $cron_duration,
                    'priority'       =>  'high',
                    'last_run'       =>  $this->mongo_db->converToMongodttime($last_updatedtime)

                ];

                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);
            }
        }//end foreach
        if(count($res) > 0){
            $result['url'] = $res;
            $data1['title'] = 'Server is Down';

            $data = array_merge( $data1, $result);
            echo json_encode($data);
            $this->push_notifications->android_notification_topic($data);
        }else{
            $working['title'] = 'Server is Working';
            echo json_encode($working);
            $this->push_notifications->android_notification_topic($working);
        }
        $this->last_cron_execution_time('cronjob_push_notification', '1m', 'Cronjob to send alerts about stopped cronjob on mobile app');
    }

    public function marketPricesPushNotificationForMobileForAli(){

        $name           =   $_REQUEST['name'];
        $cron_duration  =   $_REQUEST['cron_duration'];
        $summery        =   $_REQUEST['summery'];

        if(!empty($name) && !empty($cron_duration) && !empty($summery) ){

            $db = $this->mongo_db->customQuery();
            $whereHistorySave['dayMonth']   =   date('m-d');
            $whereHistorySave['name']       =   $name;

            $insert = [
                'enteryTime'     =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                'url'            =>  $summery,
                'cron_duration'  =>  $cron_duration,
                'priority'       =>  'high',
            ];

            $upsert['upsert'] = true;
            $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);

            $result['url']  = $summery;
            $result['title'] = 'Market Prices Stopped';

            echo json_encode($result);
            $this->push_notifications->android_notification_topic($result);
        }else{
            $returnArray= [
                'type'      =>  404,
                'status'    =>  'parameter wrong'
            ];

            echo json_encode($returnArray);
        }
    }

    public function opportunityMissedAlert(){

        $db = $this->mongo_db->customQuery();
        $binanceCollection = 'opportunity_logs_binance';
        $krakenCollection  = 'opportunity_logs_kraken';

        $startingTime   = $this->mongo_db->converToMongodttime(date('Y-m-d 00:00:00'));
        $endTime        = $this->mongo_db->converToMongodttime(date('Y-m-d 23:59:59'));

        $lookup = [
            [
                '$match' => [
                    'oppertunity_missed'    =>  ['$exists'  =>  true],
                    '$or' =>[
                        ['parents_picked'   => ['$lte' => 0]],
                        ['parents_picked'   => ['$exists' => false]],
                    ],
                    'alertSended'           => ['$exists' => false],
                    'pickParentYes'         =>  ['$gt'  => 0 ],
                    'created_date'          =>  ['$gte' => $startingTime, '$lte' => $endTime]
                ]
            ],
        ];
        
        $getRecord      = $db->$binanceCollection->aggregate($lookup);
        $getRecordRes   =  iterator_to_array($getRecord);

        if(count($getRecordRes) > 0 ){
            foreach ($getRecordRes as $opprtunities){

                $whereUpdate['_id'] =  $this->mongo_db->mongoId((string)$opprtunities['_id']);
                $data['title'] = 'Binance opportunity missed opportunity id :'.$opprtunities['opportunity_id'];
                echo json_encode($data);
                $this->push_notifications->android_notification_topic($data);
                $db->$binanceCollection->updateOne($whereUpdate, ['$set' => ['alertSended' => true]]);

                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['name'] = 'Binance opportunity missed opportunity id :'.$opprtunities['opportunity_id'];

                $insert = [
                    'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'url'        =>  'Binance opportunity missed opportunity id :'.$opprtunities['opportunity_id'],
                    'cron_duration'  => '',
                    'priority'       => 'high',

                ];

                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);

            }//end loop
        }// end for binance

        $getRecordKraken = $db->$krakenCollection->aggregate($lookup);
        $getRecordKrakenRes =  iterator_to_array($getRecordKraken);

        if(count($getRecordKrakenRes) > 0 ){
            foreach ($getRecordKrakenRes as $opprtunities){

                $whereUpdate['_id'] =  $this->mongo_db->mongoId((string)$opprtunities['_id']);
                $data1['title'] = 'kraken opportunity missed opportunity id :'.$opprtunities['opportunity_id'];
                echo json_encode($data1);
                $this->push_notifications->android_notification_topic($data1);
                $db->$krakenCollection->updateOne($whereUpdate, ['$set' => ['alertSended' => true]]);

                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['name'] = 'Kraken opportunity missed opportunity id :'.$opprtunities['opportunity_id'];

                $insert = [
                    'enteryTime' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'url'        =>  'Kraken opportunity missed opportunity id :'.$opprtunities['opportunity_id'],
                    'cron_duration'  => '',
                    'priority'       => 'high',

                ];

                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $insert], $upsert);

            }//end loop
        }//end for kraken
    }//end fundtion

    //send notification on desktop
    public function cronjob_push_notification_desktop(){
        $api_url   = "http://35.171.172.15:3000/api/all_cronjobs";
        $data_json = file_get_contents($api_url);
        $data_arr  = (array)json_decode($data_json);
        $data_arr  = (array)$data_arr['data'];
        $arr       = json_decode(json_encode($data_arr) , true);
        $inactive  = false;
        // echo "<pre>";print_r(json_decode($data_arr));
        foreach ($arr as $row) {
            $url = $row['name'];
            $post['name'] = $url;
            $curl = curl_init();
            //
            curl_setopt_array($curl, array(
                CURLOPT_PORT           => "3000",
                CURLOPT_URL            => "http://35.171.172.15:3000/api/all_cronjobs",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => "",
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => "POST",
                CURLOPT_POSTFIELDS     => json_encode($post) ,
                CURLOPT_HTTPHEADER     => array(
                    "cache-control: no-cache",
                    "content-type: application/json"
                ) ,
            ));

            $response              = curl_exec($curl);
            $err                   = curl_error($curl);
            
            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            }
            else {
                //echo $response;
            }
            $res_arr          = (array)json_decode($response);
            $res_arr          = $res_arr['data'];
            $res_arr          = json_decode(json_encode($res_arr) , true);
            $cron_duration    = $res_arr['cron_duration'];
            $last_updatedtime = $res_arr['last_updated_time_human_readible'];
            
            // $cron_duration_arr = explode(' ',$cron_duration);
            //Umer Abbas [6-11-19]
            $duration_arr     = str_split($cron_duration, 1);
            $time             = array_pop($duration_arr);
            $add_time         = strtoupper($time);
            $duration         = implode('', $duration_arr);

            $dt               = new DateTime($last_updatedtime);
            // echo $dt->format('Y-m-d H:i:s');
            $last_time        = date("Y-m-d H:i:s", strtotime($last_updatedtime));

            if ($time == 's') {
                $padding_duration = 2;
                $padding_time     = "M";
                $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 12;

            }
            else if ($time == 'm') {

                $padding_duration = 5;
                $duration         = $duration + $padding_duration;
                $interval_str     = "PT$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $param            = 300;

            }
            else if ($time == 'h') {

                $padding_duration = 15;
                $padding_time     = "M";
                $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 900;

            }
            else if ($time == 'd') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));

                $param        = 3600;

            }
            else if ($time == 'w') {

                $interval_str = "P$duration$add_time";
                $dt->add(new DateInterval($interval_str));
                $padding_duration = 1;
                $padding_time     = "H";
                $interval_str     = "PT$padding_duration$padding_time";
                $dt->add(new DateInterval($interval_str));
                $param    = 3600;
            }

            $dt2 = new DateTime();
            $timezone = date_default_timezone_get();

            if ($dt2 <= $dt) {
                //echo $url . " Is Active <br>";
                // $inactive = true;
                $data     = array(
                    "title" => "Cronjob Alert",
                    "url" => $url,
                    "last_run" => time_elapsed_string($last_updatedtime, $timezone, $full = true),
                    "priority" => "high",
                    "cron_duration" => $cron_duration
                );
            }
            else{
                echo"<br>".$url;
                $inactive = true;
                $timezone = "UTC";
                $data     = array(
                    "title" => "Cronjob Alert",
                    "url" => $url,
                    "last_run" => time_elapsed_string($last_updatedtime, $timezone, $full = true),
                    "priority" => "high",
                    "cron_duration" => $cron_duration
                );
                    //send push on desktop
                $this->desktop_notification($data);
                $db = $this->mongo_db->customQuery();
                $whereHistorySave['dayMonth'] = date('m-d');
                $whereHistorySave['url'] = $url;
                $data['enteryTime'] = $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'));
                $upsert['upsert'] = true;
                $db->corn_stops_history->updateOne($whereHistorySave, ['$set' => $data], $upsert);
            }
        }
        $this->last_cron_execution_time('cronjob_push_notification', '1m', 'Cronjob to send alerts about stopped cronjob on mobile app');
    }
    function desktop_notification($data){
        // echo "<pre>";print_r($data);
        $admin_id = $_SESSION['admin_id'];
        $whereGetTocken['_id'] = $this->mongo_db->mongoId($admin_id);
        $db = $this->mongo_db->customQuery();
        $dataReturn = $db->users->find($whereGetTocken);
        $userData = iterator_to_array($dataReturn);
        $webToken = $userData[0]['webToken'];
        echo "<br>".$webToken;
		$api_access_key	= 'AAAAIvQbGHc:APA91bH9kjKbOugIuwoc9jYLXxW-iwFmYPDCwzLqoUsCrd7KJuPIIc4AQ-eeVrprjeCuCH68e3lCmfKb-FZSGSdB111-NkM7KWlXLJRCHRMZah3xbHfXMyocBmgnbAelUxZQgSKTqWaR';

		$fields	= array(
            'to'		=> $webToken,
            'notification' =>[
                'body'			=> $data['url'],
                'title'			=> $data['title'],
                'icon'			=> 'default',//Default Icon
                'sound'			=> 'default',//Default sound
                'click_action'	=> 'FROM_DIGIEBOT'
            ],		
        );
        $headers	= array(
            'Authorization: key=' . $api_access_key,
            'Content-Type: application/json'
        );
        #Send Reponse To FireBase Server
        $ch	= curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result	= curl_exec($ch );
        $result = json_decode($result); 
        curl_close( $ch );
        if (isset($result->failure) && $result->failure > 0){
            echo "<br>Error";
            return 'error';
        }else{
            // echo "<br>Success";
            return 'success';
        }
    }
}//end controler 


