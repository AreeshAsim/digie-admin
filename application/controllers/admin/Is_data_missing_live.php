<?php

/**
 *
 */
class Is_data_missing_live extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    // public function index() {
    //     $this->load->model('admin/mod_sockets');
    //     $all_coins_arr = $this->mod_sockets->get_all_coins();

    //     $edate = date("Y-m-d H:i:s");
    //     $sdate = date("Y-m-d H:00:00", strtotime("-1 hour"));
    //     echo "<br>" . $edate . "<====>" . $sdate . "<br>";
    //     $to = "khan.waqar278@gmail.com";
    //     $subject = "Data Missing Issue";
    //     foreach ($all_coins_arr as $key => $value) {

    //         $symbol = $value['symbol'];
    //         $data_arr = $this->get_all_responses_live($sdate, $edate, $symbol);
    //         extract($data_arr);

    //         if ($order_book == 0) {
    //             echo $message = "There is a problem in Order Book Socket, Data is not Coming For Coin Symbol " . $symbol;
    //             $log_arr['type'] = 'order_book';
    //             $log_arr['created_date_human'] = $sdate;
    //             $log_arr['created_date'] = $this->mongo_db->converToMongodttime($sdate);
    //             $log_arr['message'] = $message;
    //             $log_arr['coin'] = $symbol;

    //             $this->mongo_db->insert("data_missing_log", $log_arr);

    //             mail($to, $subject, $message);
    //         }
    //         if ($market_trade == 0) {
    //             echo $message = "There is a problem in Trade Socket, Data is not Coming For Coin Symbol " . $symbol;
    //             $log_arr['type'] = 'market_trade';
    //             $log_arr['created_date_human'] = $sdate;
    //             $log_arr['created_date'] = $this->mongo_db->converToMongodttime($sdate);
    //             $log_arr['message'] = $message;
    //             $log_arr['coin'] = $symbol;
    //             $this->mongo_db->insert("data_missing_log", $log_arr);

    //             mail($to, $subject, $message);
    //         }
    //         if ($market_price == 0) {
    //             echo $message = "There is a problem in Price Socket, Data is not Coming For Coin Symbol " . $symbol;
    //             $log_arr['type'] = 'market_price';
    //             $log_arr['created_date_human'] = $sdate;
    //             $log_arr['created_date'] = $this->mongo_db->converToMongodttime($sdate);
    //             $log_arr['message'] = $message;
    //             $log_arr['coin'] = $symbol;
    //             $this->mongo_db->insert("data_missing_log", $log_arr);

    //             mail($to, $subject, $message);
    //         }
    //         if ($candles == 0) {
    //             echo $message = "There is a problem in Candle Cronjob, Data is not Coming For Coin Symbol " . $symbol;
    //             $log_arr['type'] = 'candles';
    //             $log_arr['created_date_human'] = $sdate;
    //             $log_arr['created_date'] = $this->mongo_db->converToMongodttime($sdate);
    //             $log_arr['message'] = $message;
    //             $log_arr['coin'] = $symbol;
    //             $this->mongo_db->insert("data_missing_log", $log_arr);

    //             mail($to, $subject, $message);
    //         }
    //     }
    // }

    // public function get_all_responses_live($sdate, $edate, $symbol) {
    //     $response_date_s = $this->mongo_db->converToMongodttime($sdate);
    //     $response_date_e = $this->mongo_db->converToMongodttime($edate);

    //     if ($symbol != "") {
    //         $search_arr['coin'] = $symbol;
    //     }
    //     $search_arr['created_date']['$gte'] = $response_date_s;
    //     $search_arr['created_date']['$lte'] = $response_date_e;
    //     $db = $this->mongo_db->customQuery();
    //     $data_arr = array();
    //     $data_arr['order_book'] = $db->market_depth->count($search_arr);
    //     $data_arr['market_trade'] = $db->market_trades->count($search_arr);
    //     $data_arr['market_price'] = $db->market_prices->count($search_arr);
    //     $data_arr['candles'] = $db->market_chart->count($search_arr);

    //     return $data_arr;
    // }

    // public function check_missing_data() {
    //     $edate = date("Y-m-d H:i:s");
    //     $sdate = date("Y-m-d H:00:00", strtotime("-1 hour"));
    //     $to = "khan.waqar278@gmail.com";
    //     $subject = "Data Missing Issue";

    //     $data_arr = $this->get_all_responses_live($sdate, $edate, $symbol = "");

    //     extract($data_arr);
    //     $message = '';
    //     if ($order_book == 0) {
    //         $message .= "There is a problem in Order Book Socket, Data is not Coming <br>";
    //     }
    //     if ($market_trade == 0) {
    //         $message .= "There is a problem in Trade Socket, Data is not Coming <br>";
    //     }
    //     if ($market_price == 0) {
    //         $message .= "There is a problem in Price Socket, Data is not Coming <br>";
    //     }
    //     if ($candles == 0) {
    //         $current_date = date('Y-m-d H:i:s');
    //         $hour_with_one_minute =  date('Y-m-d H:01:s');
    //         if(strtotime($current_date) > strtotime($hour_with_one_minute)){
    //             $message .= "There is a problem in Candle Cronjob, Data is not Coming <br>";
    //         }
    //     }
      
        
    //     echo $message;
    //     exit;
    // }
}
