<?php
/**
 *
 */
class Test_script extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    // public function cron_to_update_parent() {
    //     $this->mongo_db->where(array("status" => 2));
    //     $this->mongo_db->order_by(array('_id' => -1));
    //     $get = $this->mongo_db->get("report_setting_collection");

    //     foreach ($get as $key => $value) {
    //         $is_completed = $this->check_if_completed($value['_id']);

    //         if ($is_completed) {
    //             $start_date = $value['filter_by_start_date'];
    //             $end_date = $value['filter_by_end_date'];
    //             $this->watch_later_test($value['_id'], $start_date, $end_date);
    //         }
    //     }
    // }

    // public function watch_later_test($setting_id, $start_date, $end_date) {

    //     $this->mongo_db->where(array('settings.parent_id' => $this->mongo_db->mongoId($setting_id)));
    //     $get = $this->mongo_db->get("meta_coin_report_results_cron");
    //     $get = iterator_to_array($get);
    //     $results = array();
    //     foreach ($get as $key => $value) {
    //         $results[] = (array) $value['result'];
    //         $total += $value['total'];
    //         $total_number_of_days += $value['total_number_of_days'];
    //         $total_profit += $value['total_profit'];
    //         $winning += $value['winning'];
    //         $losing += $value['losing'];
    //         $winners = $value['winners'];
    //         $losers += $value['losers'];
    //         $symbol = $value['symbol'];
    //         $settings = (array) $value['settings'];
    //         $current_date = $value['current_date'];
    //         $title_to_filter = $value['title_to_filter'];

    //     }

    //     $total_trades = $winning + $losing;
    //     $win_per = ($winning / $total_trades) / 100;
    //     $lose_per = ($losing / $total_trades) / 100;

    //     $total_per_trade = $total_profit / $total_trades;
    //     $total_per_day = $total_profit / $total_number_of_days;

    //     $final['setting_id'] = $setting_id;
    //     $final['title_to_filter'] = $title_to_filter;
    //     $final['settings'] = $settings;
    //     $final['total'] = $total;
    //     $final['winning'] = $winning;
    //     $final['losing'] = $losing;
    //     $final['winners'] = $winners;
    //     $final['losers'] = $losers;
    //     $final['symbol'] = $symbol;
    //     $final['result'] = $this->array_flatten($results);
    //     $final['total_trades'] = $total_trades;
    //     $final['total_number_of_days'] = $total_number_of_days;
    //     $final['per_day'] = $total_per_day;
    //     $final['per_trade'] = $total_per_trade;
    //     $final['current_date'] = $current_date;
    //     $final['created_date'] = $this->mongo_db->converToMongodttime($start_date);
    //     $final['end_date'] = $this->mongo_db->converToMongodttime($end_date);

    //     //$this->mongo_db->insert("meta_coin_report_results", $final);
    //     echo "<pre>";
    //     print_r($final);
    //     exit;
    // }

    // public function array_flatten($array) {
    //     if (!is_array($array)) {
    //         return false;
    //     }
    //     $result = array();
    //     foreach ($array as $key => $value) {
    //         if (is_array($value)) {
    //             $result = array_merge($result, $this->array_flatten($value));
    //         } else {
    //             $result[$key] = $value;
    //         }
    //     }
    //     return $result;
    // }

    // public function check_if_completed($id) {

    //     $this->mongo_db->where(array('parent_id' => $this->mongo_db->mongoId($id), 'status' => 1));
    //     $get = $this->mongo_db->get("child_report_settings");
    //     $get = iterator_to_array($get);

    //     if (count($get) > 0) {
    //         return false;
    //     } else {
    //         return true;
    //     }
    // }

    // public function remove_broken_settings() {
    //     echo date("Y-m-d H:i:s");
    //     exit;
    // }

    // public function update_meta_coin_report() {

    //     $this->mongo_db->limit(500);
    //     $this->mongo_db->order_by(array('_id' => -1));
    //     $result = $this->mongo_db->get("meta_coin_report_results");
    //     $result1 = iterator_to_array($result);

    //     foreach ($result1 as $result_element) {

    //         $id_of_result_element = $result_element['_id'];

    //         $total_orders = $result_element['total'];
    //         $winning_orders = $result_element['winning'];
    //         $losing_orders = $result_element['losing'];

    //         $winning_per = ($winning_orders / $total_orders) * 100;
    //         $losing_per = ($losing_orders / $total_orders) * 100;

    //         $data_to_update = array(
    //             'win_per' => $winning_per,
    //             'lose_per' => $losing_per,
    //         );

    //         $this->mongo_db->where(array('_id' => $id_of_result_element));
    //         $this->mongo_db->set($data_to_update);
    //         $upd = $this->mongo_db->update('meta_coin_report_results');

    //     }

    //     exit;
    // }

    // public function get_candles() {

    //     #ini_set("display_errors", E_ALL);
    //     #error_reporting(E_ALL);
    //     $date = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("2019-06-07 00:00:000")));
    //     $this->mongo_db->limit(500);
    //     $this->mongo_db->order_by(array('_id' => -1));
    //     $this->mongo_db->where(array('timestampDate' => array('$gte' => $date)));

    //     $result = $this->mongo_db->get("market_chart");
    //     $result1 = iterator_to_array($result);

    //     foreach ($result1 as $result_element) {

    //         $candle_id = $result_element['_id'];
    //         $symbol = $result_element['coin'];
    //         $timestampDate = $result_element['timestampDate'];
    //         $ask_volume = $result_element['ask_volume'];
    //         $bid_volume = $result_element['bid_volume'];

    //         $bid_percentiles = $this->calculate_candle_percentile($symbol, $bid_volume, 'bid', $timestampDate);
    //         $ask_percentile = $this->calculate_candle_percentile($symbol, $ask_volume, 'ask', $timestampDate);

    //         $test_array = array('candle_buy_percentile' => $ask_percentile, 'candle_sell_percentile' => $bid_percentiles);

    //         echo "<pre>";
    //         print_r($test_array);

    //         $this->mongo_db->where(array('_id' => $candle_id));
    //         $this->mongo_db->set($test_array);
    //         $this->mongo_db->update('market_chart');
    //     }
    // }

    // public function calculate_candle_percentile($symbol, $totla_volume, $type, $date) {
    //     $this->mongo_db->where(array('coin' => $symbol, 'modified_date' => array('$lte' => $date)));
    //     $this->mongo_db->limit(30);
    //     $this->mongo_db->order_by(array("modified_date" => -1));
    //     $get = $this->mongo_db->get("market_trade_daily_percentile"); 

    //     $result = iterator_to_array($get);
    //     $row = $result[0];

    //     if ($type == 'bid') {
    //     $check = "big_sellers_contracts";
    //     } elseif ($type == 'ask') {
    //     $check = "big_buyers_contracts";
    //     }

    //     $percentile10_arr = array_column($result, $check . '_10');
    //     $percentile5_arr = array_column($result, $check . '_5');
    //     $percentile4_arr = array_column($result, $check . '_4');
    //     $percentile3_arr = array_column($result, $check . '_3');
    //     $percentile2_arr = array_column($result, $check . '_2');
    //     $percentile1_arr = array_column($result, $check . '_1');
    //     echo $totla_volume;
    //     echo "<br>";
    //     echo "<br>";
    //     echo $percentile10 = (array_sum($percentile10_arr) / count($percentile10_arr));
    //     echo "<br>";
    //     echo $percentile5 = (array_sum($percentile5_arr) / count($percentile5_arr));
    //     echo "<br>";

    //     echo $percentile4 = (array_sum($percentile4_arr) / count($percentile4_arr));
    //     echo "<br>";
    //     echo $percentile3 = (array_sum($percentile3_arr) / count($percentile3_arr));
    //     echo "<br>";
    //     echo $percentile2 = (array_sum($percentile2_arr) / count($percentile2_arr));
    //     echo "<br>";
    //     echo $percentile1 = (array_sum($percentile1_arr) / count($percentile1_arr));
    //     echo "<br>";

    //     $quantity = (float) $quantity;

    //     $Html10 = '10';
    //     $Html5 = '5';
    //     $Html1 = '1';
    //     $Html2 = '2';
    //     $Html3 = '3';
    //     $Html4 = '4';
    //     $Html0 = '0';

    //     if ($totla_volume >= $percentile10 && $totla_volume <= $percentile5) {
    //     $LastQtyTimeAgo = $Html10;
    //     } else if ($totla_volume >= $percentile5 && $totla_volume <= $percentile4) {
    //     $LastQtyTimeAgo = $Html5;
    //     } elseif ($totla_volume >= $percentile4 && $totla_volume <= $percentile3) {
    //     $LastQtyTimeAgo = $Html4;
    //     } elseif ($totla_volume >= $percentile3 && $totla_volume <= $percentile2) {
    //     $LastQtyTimeAgo = $Html3;
    //     } elseif ($totla_volume >= $percentile2 && $totla_volume <= $percentile1) {
    //     $LastQtyTimeAgo = $Html2;
    //     } else
    //     if ($totla_volume >= $percentile1) {
    //     $LastQtyTimeAgo = $Html1;
    //     } else {
    //     $LastQtyTimeAgo = $Html0;
    //     } echo "<br>";
    //     echo $LastQtyTimeAgo;
    //     return $LastQtyTimeAgo;
    // }
    //

    // public function test_candle_percentiles(){
    //     $date = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("2019-06-07 00:00:000")));
    //     $this->mongo_db->limit(500);
    //     $this->mongo_db->order_by(array('_id' => -1));
    //     $this->mongo_db->where(array('timestampDate' => array('$gte' => $date)));

    //     $result = $this->mongo_db->get("market_chart");
    //     $result1 = iterator_to_array($result);
    //     echo "<pre>";
    //     print_r($result1);
    // }
}


