<?php
/**
 *
 */
class Tester_report extends CI_Controller {

    function __construct() {
        parent::__construct();

        //load main template
        ini_set("memory_limit", -1);
        // ini_set("display_errors", E_ALL);
        // error_reporting(E_ALL);
        $this->stencil->layout('admin_layout');
        //load required slices
        $this->stencil->slice('admin_header_script');
        $this->stencil->slice('admin_header');
        $this->stencil->slice('admin_left_sidebar');
        $this->stencil->slice('admin_footer_script');
        //if($_SERVER['REMOTE_ADDR'] == '101.50.127.131' ){
        //echo "<pre>";   print_r($responseArr); exit;
        //}

        //load models
        $this->load->model('admin/mod_report');
        $this->load->model('admin/mod_dashboard');
        $this->load->model('admin/mod_coins');
        $this->load->model('admin/mod_login');
        $this->load->model('admin/mod_buy_orders');
    }

    // public function tester_percentile() {
    //     // ini_set("display_errors", E_ALL);
    //     // error_reporting(E_ALL);
    //     if ($this->session->userdata('user_role') != 1) {
    //         redirect(base_url() . "forbidden");
    //     }
    //     if ($this->input->post()) {
    //         $data_arr['filter_order_data'] = $this->input->post();
    //         $this->session->set_userdata($data_arr);
    //         $final_data = $this->meta_coin_report_test($this->input->post());
    //         $data['final'] = $final_data;
    //     }
    //     $option_arr = array(
    //         "1" => "Top 1%",
    //         "2" => "Top 2%",
    //         "3" => "Top 3%",
    //         "4" => "Top 4%",
    //         "5" => "Top 5%",
    //         "10" => "Top 10%",
    //         "15" => "Top 15%",
    //         "20" => "Top 20%",
    //         "25" => "Top 25%",
    //         "-25" => "Bottom 25%",
    //         "-20" => "Bottom 20%",
    //         "-15" => "Bottom 15%",
    //         "-10" => "Bottom 10%",
    //         "-5" => "Bottom 5%",
    //         "-4" => "Bottom 4%",
    //         "-3" => "Bottom 3%",
    //         "-2" => "Bottom 2%",
    //         "-1" => "Bottom 1%",

    //     );
    //     $this->mongo_db->where(array('trigger' => 'percentile'));
    //     $sett = $this->mongo_db->get("report_setting_collection");
    //     $data['settings'] = iterator_to_array($sett);

    //     $coins = $this->mod_coins->get_all_coins();
    //     $data['coins'] = $coins;
    //     $data['options'] = $option_arr;
    //     $this->stencil->paint('admin/reports/meta_report_2', $data);
    // }

    // public function meta_coin_report_test($data_arr) {
    //     // echo "<pre>";
    //     // print_r($data_arr);
    //     // // exit;
    //     if ($_SERVER['REMOTE_ADDR'] == '203.99.188.134') {
    //     //             echo "<pre>";
    //         ////             print_r($data_arr);
    //         ////             exit;
    //     }

    //     if ($data_arr['watch_later'] == 'yes') {
    //         $coin_arr = $data_arr['filter_by_coin'];
    //         foreach ($coin_arr as $key => $value) {
    //             $data_arr['status'] = 1;
    //             $data_arr['filter_by_coin'] = $value;
    //             $data_arr['trigger'] = 'percentile';
    //             if ($data_arr['title_to_category'] == '') {
    //                 $data_arr['title_to_category'] = 'uncatorgrized';
    //             }
    //             $admin_id = $this->session->userdata('admin_id');
    //             $username = $this->session->userdata('username');
    //             $data_arr['admin_id'] = $admin_id;
    //             $data_arr['username'] = $username;
    //             $this->mongo_db->insert("report_setting_collection", $data_arr);
    //         }
    //         return true;
    //     } else {
    //         if ($data_arr['wick_check'] == 'yes') {
    //             $percentiles_arr = $this->calculate_top_candles_percentile($data_arr['filter_by_coin'], $data_arr['filter_by_start_date']);
    //         }
    //         $data_arr['status'] = 3;
    //         $data_arr['trigger'] = 'percentile';
    //         $this->mongo_db->insert("report_setting_collection", $data_arr);

    //         $symbol = $data_arr['filter_by_coin'];
    //         $start_date = $data_arr['filter_by_start_date'];
    //         $end_date = $data_arr['filter_by_end_date'];
    //         $barrier_check = $data_arr['barrier_check'];

    //         $date1 = new DateTime($start_date);
    //         $date2 = new DateTime($end_date);

    //         $diff = $date2->diff($date1);

    //         $hours = $diff->h;
    //         $hours = $hours + ($diff->days * 24);
    //         $total_days = $diff->days;

    //         $d1 = $start_date;

    //         $target_profit = $data_arr['target_profit'];
    //         $target_stoploss = $data_arr['target_stoploss'];

    //         $date_range_hour = array();
    //         for ($i = 0; $i <= $hours; $i++) {
    //             $start = date("Y-m-d H:00:00", strtotime("+" . $i . " hours", strtotime($d1)));
    //             $move = date("Y-m-d H:59:59", strtotime("+" . ($i) . " hours", strtotime($d1)));
    //             $search_arr['coin'] = $symbol;
    //             $search_arr['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($start);
    //             $search_arr['modified_date']['$lte'] = $this->mongo_db->converToMongodttime($move);

    //             $this->mongo_db->where($search_arr);
    //             $res = $this->mongo_db->get("coin_meta_history");
    //             $result = iterator_to_array($res);
    //             $barrier_val = '';
    //             $meet_condition_for_buy = false;
    //             $price_check = false;

    //             if ($data_arr['price_check'] == 'yes') {
    //                 $price_symbol = $data_arr['price_symbol'];
    //                 $price = $this->get_price_change($price_symbol, $start);
    //                 $price_to_check = $data_arr['price_to_check'];

    //                 //echo $price."<br>";
    //                 if ($price > $price_to_check) {
    //                     $price_check = true;
    //                 } else {
    //                     $price_check = false;
    //                 }
    //             } else {
    //                 $price_check = true;
    //             }
    //             if ($data_arr['wick_check'] == 'yes') {

    //                 $wick = $this->wick_filter_advance($data_arr, $start, $percentiles_arr);

    //                 if ($wick['success']) {
    //                     //$current_market_price = $meta_value['current_market_value'];
    //                     /////////////////////////// Barrier ///////////////////////////////////
    //                     if ($barrier_check == 'yes') {
    //                         $barrier_range_percentage = $data_arr['barrier_range'];
    //                         $barrier_side = $data_arr['barrier_side'];
    //                         $barrier_type = $data_arr['barrier_type'];
    //                         $last_barrrier_value = "";
    //                         // $last_barrrier_value = $this->triggers_trades->list_barrier_status($symbol, 'very_strong_barrier', $current_market_price, 'down');

    //                         //%%%%%%%%%%%%%%%%%%% -- Barrier Status --%%%%%%%%%%%%%%%%%%%%%%%
    //                         //$last_barrrier_value = $this->triggers_trades->list_barrier_status_simulator($symbol, $barrier_type, $current_market_price, $barrier_side, $start);

    //                         $last_barrrier_value = $this->waqar($symbol, $start, $barrier_date = '', $barrier_side, $barrier_type);

    //                         // $barrier_val = $last_barrrier_value;

    //                         // $barrier_value_range_upside = $last_barrrier_value + ($last_barrrier_value / 100) * $barrier_range_percentage;
    //                         // $barrier_value_range_down_side = $last_barrrier_value - ($last_barrrier_value / 100) * $barrier_range_percentage;

    //                         // if ((num($current_market_price) >= num($barrier_value_range_down_side)) && (num($current_market_price) <= num($barrier_value_range_upside))) {
    //                         //     $meet_condition_for_buy = true;
    //                         // }
    //                     } else {
    //                         $meet_condition_for_buy = true;
    //                     }

    //                     /////////////////////////// Barrier ///////////////////////////////////

    //                     foreach ($result as $metakey => $meta_value) {
    //                         if (!empty($meta_value)) {

    //                             $blackwall = false;
    //                             $seven_level = false;
    //                             $big_buy = false;
    //                             $big_sell = false;
    //                             $t1cot = false;
    //                             $t4cot = false;
    //                             $t1ltcq = false;
    //                             $t1ltct = false;
    //                             $t3ltc = false;
    //                             $vbask = false;
    //                             $vbbid = false;
    //                             $bid = false;
    //                             $ask = false;
    //                             // $meet_condition_for_buy = false;

    //                             $meet_condition_for_buy = false;

    //                             $current_market_price = $meta_value['current_market_value'];
    //                             /////////////////////////// Barrier ///////////////////////////////////
    //                             if ($barrier_check == 'yes') {
    //                                 $barrier_range_percentage = $data_arr['barrier_range'];
    //                                 $barrier_side = $data_arr['barrier_side'];
    //                                 $barrier_type = $data_arr['barrier_type'];
    //                                 //$last_barrrier_value = "";
    //                                 // $last_barrrier_value = $this->triggers_trades->list_barrier_status($symbol, 'very_strong_barrier', $current_market_price, 'down');

    //                                 //%%%%%%%%%%%%%%%%%%% -- Barrier Status --%%%%%%%%%%%%%%%%%%%%%%%
    //                                 //$last_barrrier_value = $this->triggers_trades->list_barrier_status_simulator($symbol, $barrier_type, $current_market_price, $barrier_side, $start);

    //                                 // $last_barrrier_value = $this->waqar($symbol, $start, $barrier_date = '', $barrier_side, $barrier_type);

    //                                 $barrier_val = $last_barrrier_value;

    //                                 $barrier_value_range_upside = $last_barrrier_value + ($last_barrrier_value / 100) * $barrier_range_percentage;
    //                                 $barrier_value_range_down_side = $last_barrrier_value - ($last_barrrier_value / 100) * $barrier_range_percentage;

    //                                 if ((num($current_market_price) >= num($barrier_value_range_down_side)) && (num($current_market_price) <= num($barrier_value_range_upside))) {
    //                                     $meet_condition_for_buy = true;
    //                                 }
    //                             } else {
    //                                 $meet_condition_for_buy = true;
    //                             }

    //                             /////////////////////////// Barrier ///////////////////////////////////

    //                             if (empty($data_arr['black_wall_percentile'])) {
    //                                 $blackwall = true;
    //                             } else if ($data_arr['black_wall_percentile'] > 0) {
    //                                 if ($data_arr['black_wall_percentile'] >= (float) $meta_value['black_wall_percentile'] && ((float) $meta_value['black_wall_percentile'] > 0)) {
    //                                     $blackwall = true;
    //                                 } else {
    //                                     $blackwall = false;
    //                                 }

    //                             } else if ($data_arr['black_wall_percentile'] < 0) {
    //                                 if ($data_arr['black_wall_percentile'] <= (float) $meta_value['black_wall_percentile'] && ((float) $meta_value['black_wall_percentile'] < 0)) {
    //                                     $blackwall = true;
    //                                 } else {
    //                                     $blackwall = false;
    //                                 }
    //                             }

    //                             if (empty($data_arr['sevenlevel_percentile'])) {
    //                                 $seven_level = true;
    //                             } else if ($data_arr['sevenlevel_percentile'] > 0) {
    //                                 if ($data_arr['sevenlevel_percentile'] >= (float) $meta_value['sevenlevel_percentile'] && ((float) $meta_value['sevenlevel_percentile'] > 0)) {
    //                                     $seven_level = true;
    //                                 } else {
    //                                     $seven_level = false;
    //                                 }

    //                             } else if ($data_arr['sevenlevel_percentile'] < 0) {
    //                                 if ($data_arr['sevenlevel_percentile'] <= (float) $meta_value['sevenlevel_percentile'] && ((float) $meta_value['sevenlevel_percentile'] < 0)) {
    //                                     $seven_level = true;
    //                                 } else {
    //                                     $seven_level = false;
    //                                 }
    //                             }

    //                             if (empty($data_arr['big_buyers_percentile'])) {
    //                                 $big_buy = true;
    //                             } else if ($data_arr['big_buyers_percentile'] > 0) {
    //                                 if ($data_arr['big_buyers_percentile'] >= (float) $meta_value['big_buyers_percentile'] && ((float) $meta_value['big_buyers_percentile'] > 0)) {
    //                                     $big_buy = true;
    //                                 } else {
    //                                     $big_buy = false;
    //                                 }

    //                             } else if ($data_arr['big_buyers_percentile'] < 0) {
    //                                 if ($data_arr['big_buyers_percentile'] <= (float) $meta_value['big_buyers_percentile'] && ((float) $meta_value['big_buyers_percentile'] < 0)) {
    //                                     $big_buy = true;
    //                                 } else {
    //                                     $big_buy = false;
    //                                 }
    //                             }

    //                             if (empty($data_arr['big_sellers_percentile'])) {
    //                                 $big_sell = true;
    //                             } else if ($data_arr['big_sellers_percentile'] > 0) {
    //                                 if ($data_arr['big_sellers_percentile'] >= (float) $meta_value['big_sellers_percentile'] && ((float) $meta_value['big_sellers_percentile'] > 0)) {
    //                                     $big_sell = true;
    //                                 } else {
    //                                     $big_sell = false;
    //                                 }

    //                             } else if ($data_arr['big_sellers_percentile'] < 0) {
    //                                 if ($data_arr['big_sellers_percentile'] <= (float) $meta_value['big_sellers_percentile'] && ((float) $meta_value['big_sellers_percentile'] < 0)) {
    //                                     $big_sell = true;
    //                                 } else {
    //                                     $big_sell = false;
    //                                 }
    //                             }

    //                             if (empty($data_arr['five_buy_sell_percentile'])) {
    //                                 $t1cot = true;
    //                             } else if ($data_arr['five_buy_sell_percentile'] > 0) {
    //                                 if ($data_arr['five_buy_sell_percentile'] >= (float) $meta_value['five_buy_sell_percentile'] && ((float) $meta_value['five_buy_sell_percentile'] > 0)) {
    //                                     $t1cot = true;
    //                                 } else {
    //                                     $t1cot = false;
    //                                 }

    //                             } else if ($data_arr['five_buy_sell_percentile'] < 0) {
    //                                 if ($data_arr['five_buy_sell_percentile'] <= (float) $meta_value['five_buy_sell_percentile'] && ((float) $meta_value['five_buy_sell_percentile'] < 0)) {
    //                                     $t1cot = true;
    //                                 } else {
    //                                     $t1cot = false;
    //                                 }
    //                             }

    //                             if (empty($data_arr['fifteen_buy_sell_percentile'])) {
    //                                 $t4cot = true;
    //                             } else if ($data_arr['fifteen_buy_sell_percentile'] > 0) {
    //                                 if ($data_arr['fifteen_buy_sell_percentile'] >= (float) $meta_value['fifteen_buy_sell_percentile'] && ((float) $meta_value['fifteen_buy_sell_percentile'] > 0)) {
    //                                     $t4cot = true;
    //                                 } else {
    //                                     $t4cot = false;
    //                                 }

    //                             } else if ($data_arr['fifteen_buy_sell_percentile'] < 0) {
    //                                 if ($data_arr['fifteen_buy_sell_percentile'] <= (float) $meta_value['fifteen_buy_sell_percentile'] && ((float) $meta_value['fifteen_buy_sell_percentile'] < 0)) {
    //                                     $t4cot = true;
    //                                 } else {
    //                                     $t4cot = false;
    //                                 }
    //                             }

    //                             if (empty($data_arr['last_qty_buy_sell_percentile'])) {
    //                                 $t1ltcq = true;
    //                             } else if ($data_arr['last_qty_buy_sell_percentile'] > 0) {
    //                                 if ($data_arr['last_qty_buy_sell_percentile'] >= (float) $meta_value['last_qty_buy_sell_percentile'] && ((float) $meta_value['last_qty_buy_sell_percentile'] > 0)) {
    //                                     $t1ltcq = true;
    //                                 } else {
    //                                     $t1ltcq = false;
    //                                 }

    //                             } else if ($data_arr['last_qty_buy_sell_percentile'] < 0) {
    //                                 if ($data_arr['last_qty_buy_sell_percentile'] <= (float) $meta_value['last_qty_buy_sell_percentile'] && ((float) $meta_value['last_qty_buy_sell_percentile'] < 0)) {
    //                                     $t1ltcq = true;
    //                                 } else {
    //                                     $t1ltcq = false;
    //                                 }
    //                             }

    //                             if (empty($data_arr['last_qty_time_percentile'])) {
    //                                 $t1ltct = true;
    //                             } else if ($data_arr['last_qty_time_percentile'] > 0) {
    //                                 if ($data_arr['last_qty_time_percentile'] >= (float) $meta_value['last_qty_time_percentile'] && ((float) $meta_value['last_qty_time_percentile'] > 0)) {
    //                                     $t1ltct = true;
    //                                 } else {
    //                                     $t1ltct = false;
    //                                 }

    //                             } else if ($data_arr['last_qty_time_percentile'] < 0) {
    //                                 if ($data_arr['last_qty_time_percentile'] <= (float) $meta_value['last_qty_time_percentile'] && ((float) $meta_value['last_qty_time_percentile'] < 0)) {
    //                                     $t1ltct = true;
    //                                 } else {
    //                                     $t1ltct = false;
    //                                 }
    //                             }

    //                             if (empty($data_arr['last_qty_time_fif_percentile'])) {
    //                                 $t3ltc = true;
    //                             } else if ($data_arr['last_qty_time_fif_percentile'] > 0) {
    //                                 if ($data_arr['last_qty_time_fif_percentile'] >= (float) $meta_value['last_qty_time_fif_percentile'] && ((float) $meta_value['last_qty_time_fif_percentile'] > 0)) {
    //                                     $t3ltc = true;
    //                                 } else {
    //                                     $t3ltc = false;
    //                                 }

    //                             } else if ($data_arr['last_qty_time_fif_percentile'] < 0) {
    //                                 if ($data_arr['last_qty_time_fif_percentile'] <= (float) $meta_value['last_qty_time_fif_percentile'] && ((float) $meta_value['last_qty_time_fif_percentile'] < 0)) {
    //                                     $t3ltc = true;
    //                                 } else {
    //                                     $t3ltc = false;
    //                                 }
    //                             }

    //                             if (empty($data_arr['virtual_barrier_percentile_ask'])) {
    //                                 $vbask = true;
    //                             } else if ($data_arr['virtual_barrier_percentile_ask'] > 0) {
    //                                 if ($data_arr['virtual_barrier_percentile_ask'] >= (float) $meta_value['virtual_barrier_percentile_ask'] && ((float) $meta_value['virtual_barrier_percentile_ask'] > 0)) {
    //                                     $vbask = true;
    //                                 } else {
    //                                     $vbask = false;
    //                                 }

    //                             } else if ($data_arr['virtual_barrier_percentile_ask'] < 0) {
    //                                 if ($data_arr['virtual_barrier_percentile_ask'] <= (float) $meta_value['virtual_barrier_percentile_ask'] && ((float) $meta_value['virtual_barrier_percentile_ask'] < 0)) {
    //                                     $vbask = true;
    //                                 } else {
    //                                     $vbask = false;
    //                                 }
    //                             }

    //                             if (empty($data_arr['virtual_barrier_percentile'])) {
    //                                 $vbbid = true;
    //                             } else if ($data_arr['virtual_barrier_percentile'] > 0) {
    //                                 if ($data_arr['virtual_barrier_percentile'] >= (float) $meta_value['virtual_barrier_percentile'] && ((float) $meta_value['virtual_barrier_percentile'] > 0)) {
    //                                     $vbbid = true;
    //                                 } else {
    //                                     $vbbid = false;
    //                                 }

    //                             } else if ($data_arr['virtual_barrier_percentile'] < 0) {
    //                                 if ($data_arr['virtual_barrier_percentile'] <= (float) $meta_value['virtual_barrier_percentile'] && ((float) $meta_value['virtual_barrier_percentile'] < 0)) {
    //                                     $vbbid = true;
    //                                 } else {
    //                                     $vbbid = false;
    //                                 }
    //                             }
    //                             if (empty($data_arr['bid_percentile'])) {
    //                                 $bid = true;
    //                             } else if ($data_arr['bid_percentile'] > 0) {
    //                                 if ($data_arr['bid_percentile'] >= (float) $meta_value['bid_percentile'] && ((float) $meta_value['bid_percentile'] > 0)) {
    //                                     $bid = true;
    //                                 } else {
    //                                     $bid = false;
    //                                 }

    //                             } else if ($data_arr['bid_percentile'] < 0) {
    //                                 if ($data_arr['bid_percentile'] <= (float) $meta_value['bid_percentile'] && ((float) $meta_value['bid_percentile'] < 0)) {
    //                                     $bid = true;
    //                                 } else {
    //                                     $bid = false;
    //                                 }
    //                             }

    //                             if (empty($data_arr['ask_percentile'])) {
    //                                 $ask = true;
    //                             } else if ($data_arr['ask_percentile'] > 0) {
    //                                 if ($data_arr['ask_percentile'] >= (float) $meta_value['ask_percentile'] && ((float) $meta_value['ask_percentile'] > 0)) {
    //                                     $ask = true;
    //                                 } else {
    //                                     $ask = false;
    //                                 }

    //                             } else if ($data_arr['ask_percentile'] < 0) {
    //                                 if ($data_arr['ask_percentile'] <= (float) $meta_value['ask_percentile'] && ((float) $meta_value['ask_percentile'] < 0)) {
    //                                     $ask = true;
    //                                 } else {
    //                                     $ask = false;
    //                                 }
    //                             }
    //                             if ($price_check && $blackwall && $seven_level && $big_buy && $big_sell && $t1cot && $t4cot && $t1ltcq && $t1ltct && $t3ltc && $vbask && $vbbid && $bid && $ask && $meet_condition_for_buy) {
    //                                 $candle_condition = $this->check_candle_data($start, $data_arr, $meta_value['current_market_value']);

    //                                 if ($candle_condition) {
    //                                     if (!array_key_exists($wick['time']->toDatetime()->format("Y-m-d H:00:00"), $date_range_hour)) {
    //                                         //echo "<br>All indicators are ok now checking candle";
    //                                         $date_range_hour[$wick['time']->toDatetime()->format("Y-m-d H:00:00")]['market_value'] = $wick['price'];
    //                                         $date_range_hour[$wick['time']->toDatetime()->format("Y-m-d H:00:00")]['market_time'] = $wick['time']->toDatetime()->format("Y-m-d H:i:s");
    //                                         $date_range_hour[$wick['time']->toDatetime()->format("Y-m-d H:00:00")]['barrier_value'] = $barrier_val;
    //                                         $date_range_hour[$wick['time']->toDatetime()->format("Y-m-d H:00:00")]['last_candle_value'] = $wick['last_candle_value'];
    //                                     }

    //                                 }

    //                             }
    //                         }
    //                     } //end foreach result
    //                     ////////////////////////////////////////////////////////
    //                 } //end if wick
    //             } else {
    //                 //$current_market_price = $meta_value['current_market_value'];
    //                 /////////////////////////// Barrier ///////////////////////////////////
    //                 if ($barrier_check == 'yes') {
    //                     $barrier_range_percentage = $data_arr['barrier_range'];
    //                     $barrier_side = $data_arr['barrier_side'];
    //                     $barrier_type = $data_arr['barrier_type'];
    //                     $last_barrrier_value = "";
    //                     // $last_barrrier_value = $this->triggers_trades->list_barrier_status($symbol, 'very_strong_barrier', $current_market_price, 'down');

    //                     //%%%%%%%%%%%%%%%%%%% -- Barrier Status --%%%%%%%%%%%%%%%%%%%%%%%
    //                     //$last_barrrier_value = $this->triggers_trades->list_barrier_status_simulator($symbol, $barrier_type, $current_market_price, $barrier_side, $start);

    //                     $last_barrrier_value = $this->waqar($symbol, $start, $barrier_date = '', $barrier_side, $barrier_type);

    //                     // $barrier_val = $last_barrrier_value;

    //                     // $barrier_value_range_upside = $last_barrrier_value + ($last_barrrier_value / 100) * $barrier_range_percentage;
    //                     // $barrier_value_range_down_side = $last_barrrier_value - ($last_barrrier_value / 100) * $barrier_range_percentage;

    //                     // if ((num($current_market_price) >= num($barrier_value_range_down_side)) && (num($current_market_price) <= num($barrier_value_range_upside))) {
    //                     //     $meet_condition_for_buy = true;
    //                     // }
    //                 } else {
    //                     $meet_condition_for_buy = true;
    //                 }

    //                 /////////////////////////// Barrier ///////////////////////////////////

    //                 foreach ($result as $metakey => $meta_value) {
    //                     if (!empty($meta_value)) {

    //                         $blackwall = false;
    //                         $seven_level = false;
    //                         $big_buy = false;
    //                         $big_sell = false;
    //                         $t1cot = false;
    //                         $t4cot = false;
    //                         $t1ltcq = false;
    //                         $t1ltct = false;
    //                         $t3ltc = false;
    //                         $vbask = false;
    //                         $vbbid = false;
    //                         $bid = false;
    //                         $ask = false;
    //                         // $meet_condition_for_buy = false;

    //                         $meet_condition_for_buy = false;

    //                         $current_market_price = $meta_value['current_market_value'];
    //                         /////////////////////////// Barrier ///////////////////////////////////
    //                         if ($barrier_check == 'yes') {
    //                             $barrier_range_percentage = $data_arr['barrier_range'];
    //                             $barrier_side = $data_arr['barrier_side'];
    //                             $barrier_type = $data_arr['barrier_type'];
    //                             //$last_barrrier_value = "";
    //                             // $last_barrrier_value = $this->triggers_trades->list_barrier_status($symbol, 'very_strong_barrier', $current_market_price, 'down');

    //                             //%%%%%%%%%%%%%%%%%%% -- Barrier Status --%%%%%%%%%%%%%%%%%%%%%%%
    //                             //$last_barrrier_value = $this->triggers_trades->list_barrier_status_simulator($symbol, $barrier_type, $current_market_price, $barrier_side, $start);

    //                             // $last_barrrier_value = $this->waqar($symbol, $start, $barrier_date = '', $barrier_side, $barrier_type);

    //                             $barrier_val = $last_barrrier_value;

    //                             $barrier_value_range_upside = $last_barrrier_value + ($last_barrrier_value / 100) * $barrier_range_percentage;
    //                             $barrier_value_range_down_side = $last_barrrier_value - ($last_barrrier_value / 100) * $barrier_range_percentage;

    //                             if ((num($current_market_price) >= num($barrier_value_range_down_side)) && (num($current_market_price) <= num($barrier_value_range_upside))) {
    //                                 $meet_condition_for_buy = true;
    //                             }
    //                         } else {
    //                             $meet_condition_for_buy = true;
    //                         }

    //                         /////////////////////////// Barrier ///////////////////////////////////

    //                         if (empty($data_arr['black_wall_percentile'])) {
    //                             $blackwall = true;
    //                         } else if ($data_arr['black_wall_percentile'] > 0) {
    //                             if ($data_arr['black_wall_percentile'] >= (float) $meta_value['black_wall_percentile'] && ((float) $meta_value['black_wall_percentile'] > 0)) {
    //                                 $blackwall = true;
    //                             } else {
    //                                 $blackwall = false;
    //                             }

    //                         } else if ($data_arr['black_wall_percentile'] < 0) {
    //                             if ($data_arr['black_wall_percentile'] <= (float) $meta_value['black_wall_percentile'] && ((float) $meta_value['black_wall_percentile'] < 0)) {
    //                                 $blackwall = true;
    //                             } else {
    //                                 $blackwall = false;
    //                             }
    //                         }

    //                         if (empty($data_arr['sevenlevel_percentile'])) {
    //                             $seven_level = true;
    //                         } else if ($data_arr['sevenlevel_percentile'] > 0) {
    //                             if ($data_arr['sevenlevel_percentile'] >= (float) $meta_value['sevenlevel_percentile'] && ((float) $meta_value['sevenlevel_percentile'] > 0)) {
    //                                 $seven_level = true;
    //                             } else {
    //                                 $seven_level = false;
    //                             }

    //                         } else if ($data_arr['sevenlevel_percentile'] < 0) {
    //                             if ($data_arr['sevenlevel_percentile'] <= (float) $meta_value['sevenlevel_percentile'] && ((float) $meta_value['sevenlevel_percentile'] < 0)) {
    //                                 $seven_level = true;
    //                             } else {
    //                                 $seven_level = false;
    //                             }
    //                         }

    //                         if (empty($data_arr['big_buyers_percentile'])) {
    //                             $big_buy = true;
    //                         } else if ($data_arr['big_buyers_percentile'] > 0) {
    //                             if ($data_arr['big_buyers_percentile'] >= (float) $meta_value['big_buyers_percentile'] && ((float) $meta_value['big_buyers_percentile'] > 0)) {
    //                                 $big_buy = true;
    //                             } else {
    //                                 $big_buy = false;
    //                             }

    //                         } else if ($data_arr['big_buyers_percentile'] < 0) {
    //                             if ($data_arr['big_buyers_percentile'] <= (float) $meta_value['big_buyers_percentile'] && ((float) $meta_value['big_buyers_percentile'] < 0)) {
    //                                 $big_buy = true;
    //                             } else {
    //                                 $big_buy = false;
    //                             }
    //                         }

    //                         if (empty($data_arr['big_sellers_percentile'])) {
    //                             $big_sell = true;
    //                         } else if ($data_arr['big_sellers_percentile'] > 0) {
    //                             if ($data_arr['big_sellers_percentile'] >= (float) $meta_value['big_sellers_percentile'] && ((float) $meta_value['big_sellers_percentile'] > 0)) {
    //                                 $big_sell = true;
    //                             } else {
    //                                 $big_sell = false;
    //                             }

    //                         } else if ($data_arr['big_sellers_percentile'] < 0) {
    //                             if ($data_arr['big_sellers_percentile'] <= (float) $meta_value['big_sellers_percentile'] && ((float) $meta_value['big_sellers_percentile'] < 0)) {
    //                                 $big_sell = true;
    //                             } else {
    //                                 $big_sell = false;
    //                             }
    //                         }

    //                         if (empty($data_arr['five_buy_sell_percentile'])) {
    //                             $t1cot = true;
    //                         } else if ($data_arr['five_buy_sell_percentile'] > 0) {
    //                             if ($data_arr['five_buy_sell_percentile'] >= (float) $meta_value['five_buy_sell_percentile'] && ((float) $meta_value['five_buy_sell_percentile'] > 0)) {
    //                                 $t1cot = true;
    //                             } else {
    //                                 $t1cot = false;
    //                             }

    //                         } else if ($data_arr['five_buy_sell_percentile'] < 0) {
    //                             if ($data_arr['five_buy_sell_percentile'] <= (float) $meta_value['five_buy_sell_percentile'] && ((float) $meta_value['five_buy_sell_percentile'] < 0)) {
    //                                 $t1cot = true;
    //                             } else {
    //                                 $t1cot = false;
    //                             }
    //                         }

    //                         if (empty($data_arr['fifteen_buy_sell_percentile'])) {
    //                             $t4cot = true;
    //                         } else if ($data_arr['fifteen_buy_sell_percentile'] > 0) {
    //                             if ($data_arr['fifteen_buy_sell_percentile'] >= (float) $meta_value['fifteen_buy_sell_percentile'] && ((float) $meta_value['fifteen_buy_sell_percentile'] > 0)) {
    //                                 $t4cot = true;
    //                             } else {
    //                                 $t4cot = false;
    //                             }

    //                         } else if ($data_arr['fifteen_buy_sell_percentile'] < 0) {
    //                             if ($data_arr['fifteen_buy_sell_percentile'] <= (float) $meta_value['fifteen_buy_sell_percentile'] && ((float) $meta_value['fifteen_buy_sell_percentile'] < 0)) {
    //                                 $t4cot = true;
    //                             } else {
    //                                 $t4cot = false;
    //                             }
    //                         }

    //                         if (empty($data_arr['last_qty_buy_sell_percentile'])) {
    //                             $t1ltcq = true;
    //                         } else if ($data_arr['last_qty_buy_sell_percentile'] > 0) {
    //                             if ($data_arr['last_qty_buy_sell_percentile'] >= (float) $meta_value['last_qty_buy_sell_percentile'] && ((float) $meta_value['last_qty_buy_sell_percentile'] > 0)) {
    //                                 $t1ltcq = true;
    //                             } else {
    //                                 $t1ltcq = false;
    //                             }

    //                         } else if ($data_arr['last_qty_buy_sell_percentile'] < 0) {
    //                             if ($data_arr['last_qty_buy_sell_percentile'] <= (float) $meta_value['last_qty_buy_sell_percentile'] && ((float) $meta_value['last_qty_buy_sell_percentile'] < 0)) {
    //                                 $t1ltcq = true;
    //                             } else {
    //                                 $t1ltcq = false;
    //                             }
    //                         }

    //                         if (empty($data_arr['last_qty_time_percentile'])) {
    //                             $t1ltct = true;
    //                         } else if ($data_arr['last_qty_time_percentile'] > 0) {
    //                             if ($data_arr['last_qty_time_percentile'] >= (float) $meta_value['last_qty_time_percentile'] && ((float) $meta_value['last_qty_time_percentile'] > 0)) {
    //                                 $t1ltct = true;
    //                             } else {
    //                                 $t1ltct = false;
    //                             }

    //                         } else if ($data_arr['last_qty_time_percentile'] < 0) {
    //                             if ($data_arr['last_qty_time_percentile'] <= (float) $meta_value['last_qty_time_percentile'] && ((float) $meta_value['last_qty_time_percentile'] < 0)) {
    //                                 $t1ltct = true;
    //                             } else {
    //                                 $t1ltct = false;
    //                             }
    //                         }

    //                         if (empty($data_arr['last_qty_time_fif_percentile'])) {
    //                             $t3ltc = true;
    //                         } else if ($data_arr['last_qty_time_fif_percentile'] > 0) {
    //                             if ($data_arr['last_qty_time_fif_percentile'] >= (float) $meta_value['last_qty_time_fif_percentile'] && ((float) $meta_value['last_qty_time_fif_percentile'] > 0)) {
    //                                 $t3ltc = true;
    //                             } else {
    //                                 $t3ltc = false;
    //                             }

    //                         } else if ($data_arr['last_qty_time_fif_percentile'] < 0) {
    //                             if ($data_arr['last_qty_time_fif_percentile'] <= (float) $meta_value['last_qty_time_fif_percentile'] && ((float) $meta_value['last_qty_time_fif_percentile'] < 0)) {
    //                                 $t3ltc = true;
    //                             } else {
    //                                 $t3ltc = false;
    //                             }
    //                         }

    //                         if (empty($data_arr['virtual_barrier_percentile_ask'])) {
    //                             $vbask = true;
    //                         } else if ($data_arr['virtual_barrier_percentile_ask'] > 0) {
    //                             if ($data_arr['virtual_barrier_percentile_ask'] >= (float) $meta_value['virtual_barrier_percentile_ask'] && ((float) $meta_value['virtual_barrier_percentile_ask'] > 0)) {
    //                                 $vbask = true;
    //                             } else {
    //                                 $vbask = false;
    //                             }

    //                         } else if ($data_arr['virtual_barrier_percentile_ask'] < 0) {
    //                             if ($data_arr['virtual_barrier_percentile_ask'] <= (float) $meta_value['virtual_barrier_percentile_ask'] && ((float) $meta_value['virtual_barrier_percentile_ask'] < 0)) {
    //                                 $vbask = true;
    //                             } else {
    //                                 $vbask = false;
    //                             }
    //                         }

    //                         if (empty($data_arr['virtual_barrier_percentile'])) {
    //                             $vbbid = true;
    //                         } else if ($data_arr['virtual_barrier_percentile'] > 0) {
    //                             if ($data_arr['virtual_barrier_percentile'] >= (float) $meta_value['virtual_barrier_percentile'] && ((float) $meta_value['virtual_barrier_percentile'] > 0)) {
    //                                 $vbbid = true;
    //                             } else {
    //                                 $vbbid = false;
    //                             }

    //                         } else if ($data_arr['virtual_barrier_percentile'] < 0) {
    //                             if ($data_arr['virtual_barrier_percentile'] <= (float) $meta_value['virtual_barrier_percentile'] && ((float) $meta_value['virtual_barrier_percentile'] < 0)) {
    //                                 $vbbid = true;
    //                             } else {
    //                                 $vbbid = false;
    //                             }
    //                         }
    //                         if (empty($data_arr['bid_percentile'])) {
    //                             $bid = true;
    //                         } else if ($data_arr['bid_percentile'] > 0) {
    //                             if ($data_arr['bid_percentile'] >= (float) $meta_value['bid_percentile'] && ((float) $meta_value['bid_percentile'] > 0)) {
    //                                 $bid = true;
    //                             } else {
    //                                 $bid = false;
    //                             }

    //                         } else if ($data_arr['bid_percentile'] < 0) {
    //                             if ($data_arr['bid_percentile'] <= (float) $meta_value['bid_percentile'] && ((float) $meta_value['bid_percentile'] < 0)) {
    //                                 $bid = true;
    //                             } else {
    //                                 $bid = false;
    //                             }
    //                         }

    //                         if (empty($data_arr['ask_percentile'])) {
    //                             $ask = true;
    //                         } else if ($data_arr['ask_percentile'] > 0) {
    //                             if ($data_arr['ask_percentile'] >= (float) $meta_value['ask_percentile'] && ((float) $meta_value['ask_percentile'] > 0)) {
    //                                 $ask = true;
    //                             } else {
    //                                 $ask = false;
    //                             }

    //                         } else if ($data_arr['ask_percentile'] < 0) {
    //                             if ($data_arr['ask_percentile'] <= (float) $meta_value['ask_percentile'] && ((float) $meta_value['ask_percentile'] < 0)) {
    //                                 $ask = true;
    //                             } else {
    //                                 $ask = false;
    //                             }
    //                         }
    //                         if ($price_check && $blackwall && $seven_level && $big_buy && $big_sell && $t1cot && $t4cot && $t1ltcq && $t1ltct && $t3ltc && $vbask && $vbbid && $bid && $ask && $meet_condition_for_buy) {
    //                             $candle_condition = $this->check_candle_data($start, $data_arr, $meta_value['current_market_value']);

    //                             if ($candle_condition) {
    //                                 if (!array_key_exists($meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00"), $date_range_hour)) {
    //                                     //echo "<br>All indicators are ok now checking candle";
    //                                     $date_range_hour[$meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['market_value'] = $meta_value['current_market_value'];
    //                                     $date_range_hour[$meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['market_time'] = $meta_value['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //                                     $date_range_hour[$meta_value['modified_date']->toDatetime()->format("Y-m-d H:00:00")]['barrier_value'] = $barrier_val;
    //                                 }

    //                             }

    //                         }
    //                     }
    //                 } //end foreach result
    //                 ////////////////////////////////////////////////////////
    //             }

    //             ///////////////////////////////////////////////////////
    //         } //end for loop hours

    //         // echo "<pre>";
    //         // print_r($date_range_hour);
    //         //exit;

    //         $positive = 0;
    //         $negitive = 0;
    //         $winp = 0;
    //         $losp = 0;
    //         $retArr = array();
    //         foreach ($date_range_hour as $key => $value) {

    //             $market_value = $value['market_value'];
    //             $market_time = $value['market_time'];
    //             $deep_price_check = $data_arr['deep_price_check'];
    //             $deep_price_lookup_in_hours = $data_arr['deep_price_lookup_in_hours'];
    //             $opp_chk = $data_arr['opp_chk'];

    //             if ($opp_chk == 'yes') {
    //                 $is_opp_arr = $this->check_real_oppurtunity($market_value, $market_time, $deep_price_check, $deep_price_lookup_in_hours, $symbol, $opp_chk);

    //                 $profit_time_ago = '';
    //                 $los_time_ago = '';
    //                 $loss = 0;
    //                 $profit = 0;
    //                 $market_value = $value['market_value'];
    //                 $market_time = $value['market_time'];
    //                 $barrier = $value['barrier_value'];
    //                 $deep_price = $market_value - ($market_value / 100) * $deep_price_check;
    //                 //echo "Deep Value = " . $deep_price;
    //                 //echo " Original Value = " . $market_value;
    //                 //echo "<pre>";
    //                 //print_r($is_opp_arr);
    //                 if (!empty($is_opp_arr)) {
    //                     $timep = $is_opp_arr['modified_date']->toDateTime()->format("Y-m-d H:i:s");
    //                     $sell_price = $is_opp_arr['current_market_value'] + ($is_opp_arr['current_market_value'] * $target_profit) / 100;
    //                     $iniatial_trail_stop = $is_opp_arr['current_market_value'] - ($is_opp_arr['current_market_value'] / 100) * $target_stoploss;
    //                     $where['coin'] = $symbol;
    //                     $where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($timep);
    //                     $where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $deep_price_lookup_in_hours . " hours", strtotime($timep))));
    //                     $where['current_market_value']['$gte'] = (float) $sell_price;
    //                     $queryHours = [
    //                         ['$match' => $where],
    //                         ['$sort' => ['modified_date' => 1]],
    //                         ['$limit' => 1],
    //                     ];

    //                     $db = $this->mongo_db->customQuery();
    //                     $response = $db->coin_meta_history->aggregate($queryHours);
    //                     $row = iterator_to_array($response);
    //                     $profit = 0;
    //                     $profit_date = "";
    //                     if (!empty($row)) {
    //                         $percentage = (($row[0]['current_market_value'] - $is_opp_arr['current_market_value']) / $row[0]['current_market_value']) * 100;
    //                         $profit = number_format($percentage, 2);
    //                         $profit_date = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //                     }

    //                     $where1['coin'] = $symbol;
    //                     $where1['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
    //                     $where1['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));

    //                     $where1['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

    //                     $queryHours1 =
    //                         [
    //                         ['$match' => $where1],
    //                         ['$sort' => ['modified_date' => 1]],
    //                         ['$limit' => 1],
    //                     ];

    //                     // $this->mongo_db->where($where);
    //                     // $get = $this->mongo_db->get('coin_meta_history');
    //                     $db = $this->mongo_db->customQuery();
    //                     $response1 = $db->coin_meta_history->aggregate($queryHours1);
    //                     $row1 = iterator_to_array($response1);
    //                     $loss = 0;
    //                     $loss_date = 0;
    //                     if (!empty($row1)) {
    //                         $percentage = (($row1[0]['current_market_value'] - $is_opp_arr['current_market_value']) / $row1[0]['current_market_value']) * 100;
    //                         $loss = number_format($percentage, 2);
    //                         $loss_date = $row1[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //                     }
    //                     $retArr[$key]['market_value'] = num($market_value);
    //                     $retArr[$key]['market_time'] = $market_time;
    //                     $retArr[$key]['barrier'] = num($barrier);

    //                     if (!empty($profit_date)) {
    //                         $profit_time_ago = $this->time_elapsed_string_min($profit_date, $key); //0 //$profit_date //2019-05-22 14:31:12     ///$key; //2019-05-22 12:00:00
    //                         $retArr[$key]['proft_test_ago'] = $profit_time_ago;
    //                         $retArr[$key]['profit_time'] = $this->time_elapsed_string($profit_date, $key);
    //                         $retArr[$key]['profit_percentage'] = $profit;
    //                         $retArr[$key]['profit_date'] = $profit_date;
    //                     }
    //                     if (!empty($loss_date)) {
    //                         $los_time_ago = $this->time_elapsed_string_min($loss_date, $key);
    //                         $retArr[$key]['los_test_ago'] = $los_time_ago;
    //                         $retArr[$key]['loss_time'] = $this->time_elapsed_string($loss_date, $key);
    //                         $retArr[$key]['loss_percentage'] = $loss;
    //                         $retArr[$key]['loss_date'] = $loss_date;
    //                     }

    //                     // if (!empty($profit_time_ago) && !empty($los_time_ago)) {

    //                     //     if (($profit_time_ago > $los_time_ago)) {
    //                     //         $retArr[$key]['message'] = "Got Loss";
    //                     //     } else if (($profit_time_ago < $los_time_ago)) {
    //                     //         $retArr[$key]['message'] = "Got Profit";
    //                     //     } else {
    //                     //         continue;
    //                     //     }
    //                     // }

    //                     if ($los_time_ago == '' && $profit_time_ago == '') {
    //                         $retArr[$key]['message'] = '';
    //                     }
    //                     if ($los_time_ago != '' && $profit_time_ago == '') {
    //                         $retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
    //                         $negitive++;
    //                         $losp += $retArr[$key]['loss_percentage'];
    //                     }
    //                     if ($los_time_ago == '' && $profit_time_ago != '') {
    //                         $retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
    //                         $positive++;
    //                         $winp += $retArr[$key]['profit_percentage'];
    //                     }
    //                     if ($los_time_ago != '' && $profit_time_ago != '') {
    //                         if (($profit_time_ago > $los_time_ago)) {
    //                             $retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
    //                             $negitive++;
    //                             $losp += $retArr[$key]['loss_percentage'];
    //                         } else if (($profit_time_ago < $los_time_ago)) {
    //                             $retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
    //                             $positive++;
    //                             $winp += $retArr[$key]['profit_percentage'];
    //                         } else {
    //                             continue;
    //                         }
    //                     }

    //                 } else {
    //                     //$retArr[$key]['message'] = '<span class="text-warning">Opportunities doesnot exist in deep range</span>';
    //                 }

    //             } else {

    //                 $profit_time_ago = '';
    //                 $los_time_ago = '';
    //                 $loss = 0;
    //                 $profit = 0;

    //                 $market_value = $value['market_value'];
    //                 $market_time = $value['market_time'];
    //                 $barrier = $value['barrier_value'];
    //                 $last_candle_val = $value['last_candle_value'];
    //                 $sell_price = $value['market_value'] + ($value['market_value'] * $target_profit) / 100;
    //                 $iniatial_trail_stop = $value['market_value'] - ($value['market_value'] / 100) * $target_stoploss;
    //                 $where['coin'] = $symbol;
    //                 $where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
    //                 $where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));
    //                 $where['current_market_value']['$gte'] = (float) $sell_price;

    //                 $queryHours = [
    //                     ['$match' => $where],
    //                     ['$sort' => ['modified_date' => 1]],
    //                     ['$limit' => 1],
    //                 ];

    //                 $db = $this->mongo_db->customQuery();
    //                 $response = $db->coin_meta_history->aggregate($queryHours);
    //                 $row = iterator_to_array($response);
    //                 $profit = 0;
    //                 $profit_date = "";
    //                 if (!empty($row)) {
    //                     $percentage = (($row[0]['current_market_value'] - $value['market_value']) / $row[0]['current_market_value']) * 100;
    //                     $profit = number_format($percentage, 2);
    //                     $profit_date = $row[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //                 }

    //                 $where1['coin'] = $symbol;
    //                 $where1['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
    //                 $where1['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $data_arr['lookup_period'] . " hours", strtotime($market_time))));

    //                 $where1['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

    //                 $queryHours1 =
    //                     [
    //                     ['$match' => $where1],
    //                     ['$sort' => ['modified_date' => 1]],
    //                     ['$limit' => 1],
    //                 ];

    //                 // $this->mongo_db->where($where);
    //                 // $get = $this->mongo_db->get('coin_meta_history');
    //                 $db = $this->mongo_db->customQuery();
    //                 $response1 = $db->coin_meta_history->aggregate($queryHours1);
    //                 $row1 = iterator_to_array($response1);
    //                 $loss = 0;
    //                 $loss_date = 0;
    //                 if (!empty($row1)) {
    //                     $percentage = (($row1[0]['current_market_value'] - $value['market_value']) / $row1[0]['current_market_value']) * 100;
    //                     $loss = number_format($percentage, 2);
    //                     $loss_date = $row1[0]['modified_date']->toDatetime()->format("Y-m-d H:i:s");
    //                 }
    //                 $retArr[$key]['market_value'] = num($market_value);
    //                 $retArr[$key]['market_time'] = $market_time;
    //                 $retArr[$key]['barrier'] = num($barrier);
    //                 $retArr[$key]['last_candle_value'] = num($last_candle_val);
    //                 if (!empty($profit_date)) {
    //                     $profit_time_ago = $this->time_elapsed_string_min($profit_date, $key); //0
    //                     $retArr[$key]['proft_test_ago'] = $profit_time_ago;
    //                     $retArr[$key]['profit_time'] = $this->time_elapsed_string($profit_date, $key);
    //                     $retArr[$key]['profit_percentage'] = $profit;
    //                     $retArr[$key]['profit_date'] = $profit_date;
    //                 }
    //                 if (!empty($loss_date)) {
    //                     $los_time_ago = $this->time_elapsed_string_min($loss_date, $key);
    //                     $retArr[$key]['los_test_ago'] = $los_time_ago;
    //                     $retArr[$key]['loss_time'] = $this->time_elapsed_string($loss_date, $key);
    //                     $retArr[$key]['loss_percentage'] = $loss;
    //                     $retArr[$key]['loss_date'] = $loss_date;
    //                 }

    //                 // if (!empty($profit_time_ago) && !empty($los_time_ago)) {

    //                 //     if (($profit_time_ago > $los_time_ago)) {
    //                 //         $retArr[$key]['message'] = "Got Loss";
    //                 //     } else if (($profit_time_ago < $los_time_ago)) {
    //                 //         $retArr[$key]['message'] = "Got Profit";
    //                 //     } else {
    //                 //         continue;
    //                 //     }
    //                 // }

    //                 if ($los_time_ago == '' && $profit_time_ago == '') {
    //                     $retArr[$key]['message'] = '';
    //                 }
    //                 if ($los_time_ago != '' && $profit_time_ago == '') {
    //                     $retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
    //                     $negitive++;
    //                     $losp += $retArr[$key]['loss_percentage'];
    //                 }
    //                 if ($los_time_ago == '' && $profit_time_ago != '') {
    //                     $retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
    //                     $positive++;
    //                     $winp += $retArr[$key]['profit_percentage'];
    //                 }
    //                 if ($los_time_ago != '' && $profit_time_ago != '') {
    //                     if (($profit_time_ago > $los_time_ago)) {
    //                         $retArr[$key]['message'] = '<span class="text-danger">Opportunities Got Loss</span>';
    //                         $negitive++;
    //                         $losp += $retArr[$key]['loss_percentage'];
    //                     } else if (($profit_time_ago < $los_time_ago)) {
    //                         $retArr[$key]['message'] = '<span class="text-success">Opportunities Got Profit</span>';
    //                         $positive++;
    //                         $winp += $retArr[$key]['profit_percentage'];
    //                     } else {
    //                         continue;
    //                     }
    //                 }

    //             }
    //         }
    //         // echo "<pre>";
    //         // print_r($retArr);
    //         // exit;
    //         $winning_profit = $winp;
    //         $losing_profit = $losp;

    //         $total_profit = $winning_profit + $losing_profit;

    //         $total_per_trade = $total_profit / (count($date_range_hour));

    //         $total_per_day = $total_profit / $total_days;

    //         $data['winners'] = $winning_profit;
    //         $data['losers'] = $losing_profit;
    //         $data['total_profit'] = $total_profit;
    //         $data['per_trade'] = number_format($total_per_trade, 2);
    //         $data['per_day'] = number_format($total_per_day, 2);

    //         $data['final'] = $retArr;
    //         $data['count_msg'] = count($date_range_hour);
    //         $data['positive_msg'] = $positive;
    //         $data['negitive_msg'] = $negitive;
    //         $data['positive_percentage'] = number_format(($positive / ($positive + $negitive) * 100), 2);
    //         $data['negitive_percentage'] = number_format(($negitive / ($positive + $negitive) * 100), 2);

    //     //            if($_SERVER['REMOTE_ADDR'] == '203.99.188.134'){
    //         //                echo "<pre>";
    //         //                print_r($retArr);
    //         //                exit;
    //         //            }

    //         $log_data = array(
    //             'settings' => $data_arr,
    //             'symbol' => $symbol,
    //             'winning' => $positive,
    //             'losing' => $negitive,
    //             'win_per' => ($positive / ($positive + $negitive) * 100),
    //             'lose_per' => ($negitive / ($positive + $negitive) * 100),
    //             'total' => count($date_range_hour),
    //             'result' => $retArr,
    //             'created_date' => $this->mongo_db->converToMongodttime($start_date),
    //             'end_date' => $this->mongo_db->converToMongodttime($end_date),
    //             'current_date' => $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s")),
    //         );

    //         $log_data['winners'] = $winning_profit;
    //         $log_data['losers'] = $losing_profit;
    //         $log_data['total_profit'] = $total_profit;
    //         $log_data['per_trade'] = $total_per_trade;
    //         $log_data['per_day'] = $total_per_day;
    //         $this->mongo_db->insert("percentile_report_log", $log_data);
    //         return $data;
    //     }

    // } //meta_coin_report_test()

    // public function check_real_oppurtunity($market_value, $market_time, $deep_price_check, $deep_price_lookup_in_hours, $symbol, $opp_chk) {
    //     if ($opp_chk) {
    //         $iniatial_trail_stop = $market_value - ($market_value / 100) * $deep_price_check;
    //         $where['coin'] = $symbol;
    //         $where['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($market_time);
    //         $where['modified_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+" . $deep_price_lookup_in_hours . " hours", strtotime($market_time))));
    //         $where['current_market_value']['$lte'] = (float) $iniatial_trail_stop;

    //         $queryHours = [
    //             ['$match' => $where],
    //             ['$sort' => ['modified_date' => 1]],
    //             ['$limit' => 1],
    //         ];

    //         $db = $this->mongo_db->customQuery();
    //         $response = $db->coin_meta_history->aggregate($queryHours);
    //         $row = iterator_to_array($response);

    //         return $row[0];
    //     }
    // }

    // function calculate_ifelse($field, $value, $op) {
    //     if (empty($field)) {
    //         return true;
    //     } else if ($op == 'g') {
    //         if ($field <= (float) $value) {
    //             return true;
    //         }
    //     } else if ($op == 'l') {
    //         if ($field >= (float) $value) {
    //             return true;
    //         }
    //     } else {
    //         return false;
    //     }
    // }

    // public function check_candle_data($hour, $data_arr, $market_val) {

    //     // echo "<pre>";
    //     // print_r($data_arr);
    //     // exit;
    //     $search_arr['coin'] = $data_arr['filter_by_coin'];
    //     $search_arr['timestampDate'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("-1 hour", strtotime($hour))));
    //     $symbol = $data_arr['filter_by_coin'];
    //     $this->mongo_db->where($search_arr);
    //     $this->mongo_db->limit(1);
    //     $get = $this->mongo_db->get('market_chart');
    //     $row = iterator_to_array($get);
    //     $result = $row[0];
    //     $curr_high = $result['high'];
    //     $curr_low = $result['low'];
    //     $curr_open = $result['open'];
    //     $curr_close = $result['close'];
    //     $current_market_price = $market_val; // ($curr_high + $curr_low) / 2;
    //     $status = false;
    //     $swing = false;
    //     $type = false;
    //     $move = false;
    //     $new = false;
    //     $condition = false;
    //     $last_demand_candle = false;
    //     $wick_filter = false;
    //     $move_clr = false;
    //     $big_contractors = false;
    //     $condition_h = false;
    //     $big_h = false;
    //     $total_vol = false;
    //     $rejection = false;
    //     $big_buy = false;
    //     $big_sell = false;
    //     $wick_chk = false;
    //     $last_candle_buy = false;
    //     $last_candle_sell = false;
    //     $volume_check = false;

    //     if ($data_arr['top3_contracts'] == 'yes') {
    //         $body_range = $curr_close;
    //         $upper_range = $curr_high;
    //         $wick_range = $curr_open;
    //         $no_of_contracts = $data_arr['no_of_contracts'];
    //         if ($data_arr['check_wick_below'] == 'lower_wick') {
    //             $wocl = $this->check_last_3_top_values($hour, $symbol, $wick_range,$no_of_contracts);
    //         } else if ($data_arr['check_wick_below'] == 'body') {
    //             $wocl = $this->check_last_3_top_values($hour, $symbol, $body_range,$no_of_contracts);
    //         } else {
    //             $wocl = $this->check_last_3_top_values($hour, $symbol, $upper_range,$no_of_contracts);
    //         }
    //     } else {
    //         $wocl = true;
    //     }

    //     if ($data_arr['volume_check'] == 'yes') {
    //         $volume_check = $this->check_increased_volume($hour, $symbol);
    //     } else {
    //         $volume_check = true;
    //     }
    //     if (empty($data_arr['swing_status']) || in_array($result['global_swing_status'], $data_arr['swing_status'])) {
    //         $swing = true;
    //     }

    //     if (empty($data_arr['candle_status']) || in_array($result['candel_status'], $data_arr['candle_status'])) {
    //         $status = true;

    //     }

    //     if (empty($data_arr['candle_type']) || in_array($result['candle_type'], $data_arr['candle_type'])) {
    //         $type = true;

    //     }

    //     if (empty($data_arr['rejection']) || in_array($result['rejected_candle'], $data_arr['rejection'])) {
    //         $rejection = true;

    //     }

    //     if (empty($data_arr['move']) || $result['move'] >= $data_arr['move']) {
    //         $move = true;

    //     }

    //     if (empty($data_arr['total_volume']) || $result['total_volume'] >= $data_arr['total_volume']) {
    //         $total_vol = true;

    //     }

    //     if (empty($data_arr['last_candle_percentile_buy']) || ($result['candle_buy_percentile'] <= $data_arr['last_candle_percentile_buy'] && $result['candle_buy_percentile'] > 0)) {
    //         $last_candle_buy = true;

    //     }

    //     if (empty($data_arr['last_candle_percentile_sell']) || ($result['candle_sell_percentile'] <= $data_arr['last_candle_percentile_sell'] && $result['candle_buy_percentile'] > 0)) {
    //         $last_candle_sell = true;

    //     }

    //     // if (empty($data_arr['contractor'])) {
    //     //     $big_buy = true;
    //     // } else {
    //     //     if (empty($data_arr['contract_value']) || $result['bigBuyerContract' . $data_arr['contractor']] >= $data_arr['contract_value']) {
    //     //         $big_buy = true;

    //     //     }
    //     // }
    //     /////////////////// MOVE COLORS /////////////////////////////////
    //     if (empty($data_arr['move_color'])) {
    //         $move_clr = true;
    //     } else {
    //         $move = (float) $result['per_move'];
    //         //            if ($move > 3) {
    //         //                $color = 'green';
    //         //            } else if ($move > 2) {
    //         //                $color = 'blue';
    //         //            } else if ($move > 1) {
    //         //                $color = 'yellow';
    //         //            } else {
    //         //                $color = 'red';
    //         //            }

    //         // if ($move > 3) {
    //         //     $color = 'yellow';
    //         // } else if ($move > 2) {
    //         //     $color = 'green';
    //         // } else if ($move > 1) {
    //         //     $color = 'blue';
    //         // } else {
    //         //     $color = 'red';
    //         // }

    //         if ($move > 4) {
    //             $color == 'yellow';
    //         } else if ($move > 3) {
    //             $color = 'white';
    //         } else if ($move > 2) {
    //             $color = 'green';
    //         } else if ($move > 1) {
    //             $color = 'blue';
    //         } else {
    //             $color = 'red';
    //         }
    //         if (in_array($color, $data_arr['move_color'])) {
    //             $move_clr = true;
    //         } else {
    //             $move_clr = false;
    //         }

    //     }

    //     /////////////////// MOVE COLORS /////////////////////////////////

    //     /////////////////// Big Contractors /////////////////////////////////

    //     if (empty($data_arr['big_contractors'])) {
    //         $big_contractors = true;
    //     } elseif (!empty($data_arr['big_contractors_val'])) {
    //         $contractor = $data_arr['big_contractors'];
    //         $contract_val = (float) $data_arr['big_contractors_val'];

    //         if ($contractor == 10) {
    //             $seller = $result['bigSellerContract1'] + $result['bigSellerContract2'] + $result['bigSellerContract3'] + $result['bigSellerContract4'] + $result['bigSellerContract5'] + $result['bigSellerContract10'];
    //             $buyer = $result['bigBuyerContract1'] + $result['bigBuyerContract2'] + $result['bigBuyerContract3'] + $result['bigBuyerContract4'] + $result['bigBuyerContract5'] + $result['bigSellerContract10'];
    //         }

    //         if ($contractor == 5) {
    //             $seller = $result['bigSellerContract1'] + $result['bigSellerContract2'] + $result['bigSellerContract3'] + $result['bigSellerContract4'] + $result['bigSellerContract5'];
    //             $buyer = $result['bigBuyerContract1'] + $result['bigBuyerContract2'] + $result['bigBuyerContract3'] + $result['bigBuyerContract4'] + $result['bigBuyerContract5'];
    //         }

    //         if ($contractor == 4) {
    //             $seller = $result['bigSellerContract1'] + $result['bigSellerContract2'] + $result['bigSellerContract3'] + $result['bigSellerContract4'];
    //             $buyer = $result['bigBuyerContract1'] + $result['bigBuyerContract2'] + $result['bigBuyerContract3'] + $result['bigBuyerContract4'];

    //         }

    //         if ($contractor == 3) {
    //             $seller = $result['bigSellerContract1'] + $result['bigSellerContract2'] + $result['bigSellerContract3'];
    //             $buyer = $result['bigBuyerContract1'] + $result['bigBuyerContract2'] + $result['bigBuyerContract3'];
    //         }

    //         if ($contractor == 2) {
    //             $seller = $result['bigSellerContract1'] + $result['bigSellerContract2'];
    //             $buyer = $result['bigBuyerContract1'] + $result['bigBuyerContract2'];
    //         }
    //         if ($contractor == 1) {
    //             $seller = $result['bigSellerContract1'];
    //             $buyer = $result['bigBuyerContract1'];
    //         }

    //         // $buyer = $result['bigBuyerContract' . $contractor];
    //         // $seller = $result['bigSellerContract' . $contractor];
    //         if ($buyer > $seller) {
    //             $delta = $buyer / $seller;
    //         } else {
    //             $delta = $seller / $buyer;
    //             $delta = $delta * -1;
    //         }

    //         if ($contract_val <= $delta) {
    //             $big_contractors = true;
    //         } else {
    //             $big_contractors = false;
    //         }
    //     } else {
    //         $big_contractors = true;
    //     }

    //     ///////////////////End Big Contractors /////////////////////////////////

    //     //..................................................................................................................
    //     //.BBBBBBBBBB..BIIII....GGGGGGG......... BBBBBBBBB...BUUU...UUUU.UYYY....YYYY.YEEEEEEEEEE.ERRRRRRRRR....SSSSSSS.....
    //     //.BBBBBBBBBBB.BIIII..GGGGGGGGGG........ BBBBBBBBBB..BUUU...UUUU.UYYYY..YYYYY.YEEEEEEEEEE.ERRRRRRRRRR..RSSSSSSSS....
    //     //.BBBBBBBBBBB.BIIII.GGGGGGGGGGGG....... BBBBBBBBBB..BUUU...UUUU..YYYY..YYYY..YEEEEEEEEEE.ERRRRRRRRRR..RSSSSSSSSS...
    //     //.BBBB...BBBB.BIIII.GGGGG..GGGGG....... BBB...BBBB..BUUU...UUUU..YYYYYYYYY...YEEE........ERRR...RRRRRRRSSS..SSSS...
    //     //.BBBB...BBBB.BIIIIIGGGG....GGG........ BBB...BBBB..BUUU...UUUU...YYYYYYYY...YEEE........ERRR...RRRRRRRSSS.........
    //     //.BBBBBBBBBBB.BIIIIIGGG................ BBBBBBBBBB..BUUU...UUUU....YYYYYY....YEEEEEEEEE..ERRRRRRRRRR..RSSSSSS......
    //     //.BBBBBBBBBB..BIIIIIGGG..GGGGGGGG...... BBBBBBBBB...BUUU...UUUU....YYYYYY....YEEEEEEEEE..ERRRRRRRRRR...SSSSSSSSS...
    //     //.BBBBBBBBBBB.BIIIIIGGG..GGGGGGGG...... BBBBBBBBBB..BUUU...UUUU.....YYYY.....YEEEEEEEEE..ERRRRRRR........SSSSSSS...
    //     //.BBBB....BBBBBIIIIIGGGG.GGGGGGGG...... BBB....BBBB.BUUU...UUUU.....YYYY.....YEEE........ERRR.RRRR..........SSSSS..
    //     //.BBBB....BBBBBIIII.GGGGG....GGGG...... BBB....BBBB.BUUU...UUUU.....YYYY.....YEEE........ERRR..RRRR..RRSS....SSSS..
    //     //.BBBBBBBBBBBBBIIII.GGGGGGGGGGGG....... BBBBBBBBBBB.BUUUUUUUUUU.....YYYY.....YEEEEEEEEEE.ERRR..RRRRR.RRSSSSSSSSSS..
    //     //.BBBBBBBBBBB.BIIII..GGGGGGGGGG........ BBBBBBBBBB...UUUUUUUUU......YYYY.....YEEEEEEEEEE.ERRR...RRRRR.RSSSSSSSSS...
    //     //.BBBBBBBBBB..BIIII....GGGGGGG......... BBBBBBBBB.....UUUUUUU.......YYYY.....YEEEEEEEEEE.ERRR....RRRR..SSSSSSSS....
    //     //..................................................................................................................

    //     if (empty($data_arr['big_buyers'])) {
    //         $big_buy = true;
    //     } elseif (!empty($data_arr['big_buyers_val'])) {
    //         $contractor_b = $data_arr['big_buyers'];
    //         $contract_val_b = (float) $data_arr['big_buyers_val'];

    //         if ($contractor_b == 10) {
    //             $buyer_b = $result['bigBuyerContract1'] + $result['bigBuyerContract2'] + $result['bigBuyerContract3'] + $result['bigBuyerContract4'] + $result['bigBuyerContract5'] + $result['bigSellerContract10'];
    //         }

    //         if ($contractor_b == 5) {
    //             $buyer_b = $result['bigBuyerContract1'] + $result['bigBuyerContract2'] + $result['bigBuyerContract3'] + $result['bigBuyerContract4'] + $result['bigBuyerContract5'];
    //         }

    //         if ($contractor_b == 4) {
    //             $buyer_b = $result['bigBuyerContract1'] + $result['bigBuyerContract2'] + $result['bigBuyerContract3'] + $result['bigBuyerContract4'];

    //         }

    //         if ($contractor_b == 3) {
    //             $buyer_b = $result['bigBuyerContract1'] + $result['bigBuyerContract2'] + $result['bigBuyerContract3'];
    //         }

    //         if ($contractor_b == 2) {
    //             $buyer_b = $result['bigBuyerContract1'] + $result['bigBuyerContract2'];
    //         }
    //         if ($contractor_b == 1) {
    //             $buyer_b = $result['bigBuyerContract1'];
    //         }

    //         // $buyer = $result['bigBuyerContract' . $contractor];
    //         // $seller = $result['bigSellerContract' . $contractor];

    //         if ($contract_val_b <= $buyer_b) {
    //             $big_buy = true;
    //         } else {
    //             $big_buy = false;
    //         }
    //     } else {
    //         $big_buy = true;
    //     }

    //     //////////////////////////////////////// End Big Buyers /////////////////////////////////////////

    //     //...................................................................................
    //     // BBBBBBBBB..BBIII....GGGGGGG..........SSSSSSS....SEEEEEEEEEE.ELLL.......LLLL.......
    //     // BBBBBBBBBB.BBIII..GGGGGGGGGG........ SSSSSSSS...SEEEEEEEEEE.ELLL.......LLLL.......
    //     // BBBBBBBBBB.BBIII.IGGGGGGGGGGG....... SSSSSSSSS..SEEEEEEEEEE.ELLL.......LLLL.......
    //     // BBB...BBBB.BBIII.IGGGG..GGGGG...... SSS..SSSS..SEEE........ELLL.......LLLL.......
    //     // BBB...BBBB.BBIIIIIGGG....GGG....... SSS........SEEE........ELLL.......LLLL.......
    //     // BBBBBBBBBB.BBIIIIIGG................ SSSSSS.....SEEEEEEEEE..ELLL.......LLLL.......
    //     // BBBBBBBBB..BBIIIIIGG..GGGGGGGG.......SSSSSSSSS..SEEEEEEEEE..ELLL.......LLLL.......
    //     // BBBBBBBBBB.BBIIIIIGG..GGGGGGGG.........SSSSSSS..SEEEEEEEEE..ELLL.......LLLL.......
    //     // BBB....BBBBBBIIIIIGGG.GGGGGGGG............SSSSS.SEEE........ELLL.......LLLL.......
    //     // BBB....BBBBBBIII.IGGGG....GGGG..... SS....SSSS.SEEE........ELLL.......LLLL.......
    //     // BBBBBBBBBBBBBIII.IGGGGGGGGGGG...... SSSSSSSSSS.SEEEEEEEEEE.ELLLLLLLLL.LLLLLLLLLL.
    //     // BBBBBBBBBB.BBIII..GGGGGGGGGG........ SSSSSSSSS..SEEEEEEEEEE.ELLLLLLLLL.LLLLLLLLLL.
    //     // BBBBBBBBB..BBIII....GGGGGGG..........SSSSSSSS...SEEEEEEEEEE.ELLLLLLLLL.LLLLLLLLLL.
    //     //...................................................................................

    //     if (empty($data_arr['big_sellers'])) {
    //         $big_sell = true;
    //     } elseif (!empty($data_arr['big_sellers_Val'])) {
    //         $contractor_s = $data_arr['big_sellers'];
    //         $contract_val_s = (float) $data_arr['big_sellers_Val'];

    //         if ($contractor_s == 10) {
    //             $seller_s = $result['bigSellerContract1'] + $result['bigSellerContract2'] + $result['bigSellerContract3'] + $result['bigSellerContract4'] + $result['bigSellerContract5'] + $result['bigSellerContract10'];
    //         }

    //         if ($contractor_s == 5) {
    //             $seller_s = $result['bigSellerContract1'] + $result['bigSellerContract2'] + $result['bigSellerContract3'] + $result['bigSellerContract4'] + $result['bigSellerContract5'];
    //         }

    //         if ($contractor_s == 4) {
    //             $seller_s = $result['bigSellerContract1'] + $result['bigSellerContract2'] + $result['bigSellerContract3'] + $result['bigSellerContract4'];
    //         }

    //         if ($contractor_s == 3) {
    //             $seller_s = $result['bigSellerContract1'] + $result['bigSellerContract2'] + $result['bigSellerContract3'];
    //         }

    //         if ($contractor_s == 2) {
    //             $seller_s = $result['bigSellerContract1'] + $result['bigSellerContract2'];
    //         }
    //         if ($contractor_s == 1) {
    //             $seller_s = $result['bigSellerContract1'];
    //         }

    //         // $buyer = $result['bigBuyerContract' . $contractor_s];
    //         // $seller_s = $result['bigSellerContract' . $contractor];

    //         if ($contract_val_s >= $seller_s) {
    //             $big_sell = true;
    //         } else {
    //             $big_sell = false;
    //         }
    //     } else {
    //         $big_sell = true;
    //     }

    //     //...................................................................................
    //     // BBBBBBBBB..BBIII....GGGGGGG..........SSSSSSS....SEEEEEEEEEE.ELLL.......LLLL.......
    //     // BBBBBBBBBB.BBIII..GGGGGGGGGG........ SSSSSSSS...SEEEEEEEEEE.ELLL.......LLLL.......
    //     // BBBBBBBBBB.BBIII.IGGGGGGGGGGG....... SSSSSSSSS..SEEEEEEEEEE.ELLL.......LLLL.......
    //     // BBB...BBBB.BBIII.IGGGG..GGGGG...... SSS..SSSS..SEEE........ELLL.......LLLL.......
    //     // BBB...BBBB.BBIIIIIGGG....GGG....... SSS........SEEE........ELLL.......LLLL.......
    //     // BBBBBBBBBB.BBIIIIIGG................ SSSSSS.....SEEEEEEEEE..ELLL.......LLLL.......
    //     // BBBBBBBBB..BBIIIIIGG..GGGGGGGG.......SSSSSSSSS..SEEEEEEEEE..ELLL.......LLLL.......
    //     // BBBBBBBBBB.BBIIIIIGG..GGGGGGGG.........SSSSSSS..SEEEEEEEEE..ELLL.......LLLL.......
    //     // BBB....BBBBBBIIIIIGGG.GGGGGGGG............SSSSS.SEEE........ELLL.......LLLL.......
    //     // BBB....BBBBBBIII.IGGGG....GGGG..... SS....SSSS.SEEE........ELLL.......LLLL.......
    //     // BBBBBBBBBBBBBIII.IGGGGGGGGGGG...... SSSSSSSSSS.SEEEEEEEEEE.ELLLLLLLLL.LLLLLLLLLL.
    //     // BBBBBBBBBB.BBIII..GGGGGGGGGG........ SSSSSSSSS..SEEEEEEEEEE.ELLLLLLLLL.LLLLLLLLLL.
    //     // BBBBBBBBB..BBIII....GGGGGGG..........SSSSSSSS...SEEEEEEEEEE.ELLLLLLLLL.LLLLLLLLLL.
    //     //...................................................................................

    //     if ($data_arr['last_demand_candle'] == 'yes') {
    //         $last_demand_candle = $this->check_last_demand_candle($hour, $data_arr['filter_by_coin']);
    //     } else {
    //         $last_demand_candle = true;
    //     }

    //     if ($data_arr['candle_wick'] == 'yes') {
    //         $wick_filter = $this->calculate_candle_wick_filter($hour, $data_arr, $market_val);
    //     } else {
    //         $wick_filter = true;
    //     }
    //     $open = $result['last_24_hour_open'];
    //     $close = $result['last_24_hour_close'];
    //     $high = $result['last_24_hour_high'];
    //     $low = $result['last_24_hour_low'];
    //     if ($data_arr['candle_chk'] == 'yes') {

    //         $formula = $data_arr['formula'];
    //         if ($formula == 'highlow') {
    //             $distance = (($high - $low) / 100) * $data_arr['candle_range'];
    //             $upper_range = $high - $distance;
    //             $lower_range = $low + $distance;
    //             // echo "<pre>";
    //             // print_r($result);

    //             // echo " Current MArket : " . $current_market_price;
    //             // echo " Highest High : " . $high . " Upper Range : " . $upper_range;

    //             // echo " Lowest Low : " . $low . " Lower Range : " . $lower_range;
    //             // echo " Side To Check " . $data_arr['candle_side'];

    //             if ($data_arr['candle_side'] == 'up') {
    //                 if ($current_market_price >= $upper_range) {$condition = true;}
    //             } else {
    //                 if ($current_market_price <= $lower_range) {
    //                     $condition = true;
    //                 }
    //             }
    //             // echo " ";
    //             // var_dump($condition);
    //         } elseif ($formula == 'openclose') {
    //             if ($open > $close) {
    //                 $big = $open;
    //                 $small = $close;
    //             } else {
    //                 $big = $close;
    //                 $small = $open;
    //             }

    //             $distance = (($open - $close) / 100) * $data_arr['candle_range'];
    //             $upper_range = $big - $distance;
    //             $lower_range = $small + $distance;

    //             if ($current_market_price >= $upper_range) {$condition = true;}
    //         } else {
    //             if ($current_market_price <= $lower_range) {
    //                 $condition = true;
    //             }
    //         }

    //     } else {
    //         $condition = true;
    //     }
    //     $big = true;
    //     if ($data_arr['side'] != 'none' && $data_arr['candle_chk'] == 'yes') {
    //         if ($data_arr['side'] == 'above') {
    //             if ($close > $open) {
    //                 $big = true;
    //             } else {
    //                 $big = false;
    //             }
    //         } else {
    //             if ($open > $close) {
    //                 $big = true;
    //             } else {
    //                 $big = false;
    //             }
    //         }
    //     } else {
    //         $big = true;
    //     }

    //     ///////////////////////////////////////////////////////////////
    //     if ($data_arr['candle_chk_h'] == 'yes') {

    //         $formula_h = $data_arr['formula_h'];
    //         if ($formula_h == 'highlow') {
    //             $distance = (($curr_high - $curr_low) / 100) * $data_arr['candle_range_h'];
    //             $upper_range = $curr_high - $distance;
    //             $lower_range = $curr_low + $distance;
    //             // echo "<pre>";
    //             // print_r($result);

    //             // echo " Current MArket : " . $current_market_price;
    //             // echo " Highest High : " . $high . " Upper Range : " . $upper_range;

    //             // echo " Lowest Low : " . $low . " Lower Range : " . $lower_range;
    //             // echo " Side To Check " . $data_arr['candle_side'];

    //             if ($data_arr['candle_side_h'] == 'up') {
    //                 if ($current_market_price >= $upper_range) {$condition_h = true;}
    //             } else {
    //                 if ($current_market_price <= $lower_range) {
    //                     $condition_h = true;
    //                 }
    //             }
    //             // echo " ";
    //             // var_dump($condition);
    //         } elseif ($formula_h == 'openclose') {
    //             if ($curr_open > $curr_close) {
    //                 $curr_big = $curr_open;
    //                 $curr_small = $curr_close;
    //             } else {
    //                 $curr_big = $curr_close;
    //                 $curr_small = $curr_open;
    //             }

    //             $distance = (($curr_open - $curr_close) / 100) * $data_arr['candle_range_h'];
    //             $upper_range = $curr_big - $curr_distance;
    //             $lower_range = $curr_small + $curr_distance;

    //             if ($current_market_price >= $upper_range) {$condition_h = true;}
    //         } else {
    //             if ($current_market_price <= $lower_range) {
    //                 $condition_h = true;
    //             }
    //         }

    //     } else {
    //         $condition_h = true;
    //     }
    //     $big_h = true;
    //     if ($data_arr['side_h'] != 'none' && $data_arr['candle_chk_h'] == 'yes') {
    //         if ($data_arr['side_h'] == 'above') {
    //             if ($curr_close > $curr_open) {
    //                 $big_h = true;
    //             } else {
    //                 $big_h = false;
    //             }
    //         } else {
    //             if ($curr_open > $curr_close) {
    //                 $big_h = true;
    //             } else {
    //                 $big_h = false;
    //             }
    //         }
    //     } else {
    //         $big_h = true;
    //     }
    //     ///////////////////////////////////////////////////////////////

    //     if ($last_candle_buy && $last_candle_sell && $wick_filter && $last_demand_candle && $status && $swing && $type && $move && $condition && $big && $big_h && $condition_h && $big_contractors && $move_clr && $big_buy && $big_sell && $rejection && $total_vol && $wocl && $volume_check) {
    //         $new = true;

    //         // echo "Start Date: " . $hour . "<br>";
    //         // echo "<pre>";
    //         // print_r($result);
    //     }

    //     return $new;
    // }
    // public function check_increased_volume($hour, $symbol) {

    //     $search_arr['coin'] = $symbol;
    //     $search_arr['timestampDate']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-1 hour", strtotime($hour))));
    //     $this->mongo_db->where($search_arr);
    //     $this->mongo_db->limit(2);
    //     $this->mongo_db->order_by(array("timestampDate" => -1));
    //     $res = $this->mongo_db->get("market_chart");
    //     $res = iterator_to_array($res);

    //     // echo "<pre>";
    //     // print_r($res);

    //     $new_volume = $res[0]['total_volume'];
    //     $old_volume = $res[1]['total_volume'];

    //     if ($new_volume > $old_volume) {
    //         return true;
    //     }

    // }
    // public function check_last_demand_candle($hour, $filter_by_coin) {
    //     $search_arr['coin'] = $filter_by_coin;
    //     $search_arr['timestampDate']['$lte'] = $this->mongo_db->converToMongodttime($hour);
    //     $search_arr['candle_type']['$in'] = array('demand', 'supply');

    //     $this->mongo_db->where($search_arr);
    //     $this->mongo_db->limit(1);
    //     $this->mongo_db->order_by(array("timestampDate" => -1));
    //     $res = $this->mongo_db->get("market_chart");

    //     $result = iterator_to_array($res);
    //     if (count($result) > 0) {
    //         if ($result[0]['candle_type'] == 'demand') {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     } else {
    //         return false;
    //     }
    // }

    // public function calculate_candle_wick_filter($hour, $data_arr, $market_val) {
    //     $coin = $data_arr['filter_by_coin'];
    //     $type = $data_arr['candle_typ'];
    //     $wick_side = $data_arr['wick_side'];
    //     $wick_size = $data_arr['wick_size'];
    //     $wick_lookup = $data_arr['wick_lookup'];
    //     $trade_per = $data_arr['trade_percentage'];

    //     $search_arr['coin'] = $coin;
    //     $search_arr['timestampDate']['$lte'] = $this->mongo_db->converToMongodttime($hour);
    //     $search_arr['timestampDate']['$gte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("-" . $wick_lookup . " hours", strtotime($hour))));
    //     $this->mongo_db->where($search_arr);
    //     $this->mongo_db->order_by(array("timestampDate" => -1));
    //     $res = $this->mongo_db->get("market_chart");

    //     // echo num($market_val) . '<br>';

    //     // return true;
    //     $result = iterator_to_array($res);

    //     foreach ($result as $key => $value) {
    //         $conditionx = false;
    //         if (($type == 'demand' && $value['candle_type'] == 'demand') || ($type == 'supply' && $value['candle_type'] == 'supply') || ($type == 'normal_blue' && $value['close'] > $value['open']) || ($type == 'normal_red' && $value['close'] < $value['open'])) {
    //             $conditionx = true;
    //         }

    //         if ($conditionx) {

    //             $open = $value['open'];
    //             $close = $value['close'];
    //             $high = $value['high'];
    //             $low = $value['low'];

    //             if ($open > $close) {
    //                 $big = $open;
    //                 $small = $close;
    //             } else {
    //                 $big = $close;
    //                 $small = $open;
    //             }

    //             if ($type == 'demand') {
    //                 if ($wick_side == 'up') {
    //                     $check_wick = (($high - $big) / $big) * 100;

    //                     if ($check_wick >= $wick_size) {
    //                         $distance = (($high - $big) / 100) * $trade_per;
    //                         $original_value = $high - $distance;
    //                         break;
    //                     }
    //                 } else if ($wick_side == 'down') {
    //                     $check_wick = (($small - $low) / $low) * 100;

    //                     if ($check_wick >= $wick_size) {
    //                         $distance = (($small - $low) / 100) * $trade_per;
    //                         $original_value = $low - $distance;
    //                         break;
    //                     }
    //                 } ///////////////wick side check for demand candle
    //             } ////////////////// check for demand candle
    //             elseif ($type == 'supply') {
    //                 if ($wick_side == 'up') {
    //                     $check_wick = (($high - $big) / $open) * 100;

    //                     if ($check_wick >= $wick_size) {
    //                         $distance = (($high - $big) / 100) * $trade_per;
    //                         $original_value = $high - $distance;
    //                         //echo "Wick Filter Applied <br>";
    //                         break;
    //                     }
    //                 } else if ($wick_side == 'down') {
    //                     $check_wick = (($small - $low) / $low) * 100;

    //                     if ($check_wick >= $wick_size) {
    //                         $distance = (($small - $low) / 100) * $trade_per;
    //                         $original_value = $low - $distance;
    //                         //echo "Wick Filter Applied <br>";
    //                         break;
    //                     }
    //                 } ///////////////wick side check for supply candle
    //             } ////////////////// check for supply candle

    //         }
    //     } //end foreach loop

    //     if ($wick_side == 'up') {
    //         if ($market_val >= $original_value) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     } else if ($wick_side == 'down') {
    //         if ($market_val <= $original_value) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     } else {
    //         return false;
    //     }

    // }

    // function time_elapsed_string_min($datetime, $pre_time, $full = false) {

    //     // echo $datetime; //2019-05-22 14:31:12

    //     // echo "<br />";
    //     // echo $pre_time; //2019-05-22 12:00:00
    //     // echo "<br />";
    //     //exit;

    //     $now = new DateTime($pre_time);
    //     $ago = new DateTime($datetime);
    //     $diff = $now->diff($ago);

    //     //        $diff->w = floor($diff->d / 7);
    //     //        $diff->d -= $diff->w * 7;
    //     //        $day = $diff->d;
    //     //        $dayc = (24 * $day) * 60;
    //     //        $hrs = $diff->h;
    //     //        $hrsc = $hrs * 60;
    //     //        $mins = $diff->i;
    //     //        $sec = $diff->s;
    //     //        $secc = $sec / 60;
    //     //        $Tmins = round($dayc + $hrsc + $mins + $secc);

    //     $Tmins = $diff->days * 24 * 60;
    //     $Tmins += $diff->h * 60;
    //     $Tmins += $diff->i;
    //     return $Tmins;
    // }
    // function time_elapsed_string($datetime, $pre_time, $full = false) {
    //     $now = new DateTime($pre_time);
    //     $ago = new DateTime($datetime);
    //     $diff = $now->diff($ago);

    //     $diff->w = floor($diff->d / 7);
    //     $diff->d -= $diff->w * 7;

    //     $string = array(
    //         'y' => 'year',
    //         'm' => 'month',
    //         'w' => 'week',
    //         'd' => 'day',
    //         'h' => 'hour',
    //         'i' => 'min',
    //         's' => 'sec',
    //     );
    //     foreach ($string as $k => &$v) {
    //         if ($diff->$k) {
    //             $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
    //         } else {
    //             unset($string[$k]);
    //         }
    //     }

    //     if (!$full) {
    //         $string = array_slice($string, 0, 1);
    //     }

    //     return $string ? implode(', ', $string) . '' : 'just now';
    // }

    // public function my_run($symbol) {

    //     $this->load->model('admin/mod_realtime_candle_socket');

    //     $this->mod_realtime_candle_socket->save_candle_stick_by_cron_job();

    //     exit;

    //     $search_arr['coin'] = $symbol;
    //     $search_arr['timestampDate']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("2019-05-21 00:00:00")));

    //     $this->mongo_db->where($search_arr);
    //     $this->mongo_db->order_by(array('timestampDate' => -1));
    //     $this->mongo_db->limit(500);
    //     $get_Arr = $this->mongo_db->get("market_chart");

    //     echo "<pre>";
    //     print_r(iterator_to_array($get_Arr));
    //     exit;
    // }

    // public function test_canldes() {
    //     $this->stencil->paint("admin/reports/candle");
    // }

    // public function run_cron() {
    //     //$headers = array('X-FullContact-APIKey:d1056ef1b108f753');
    //     $coin = $this->input->post('coin');
    //     $candle_date = $this->input->post('candle_date');
    //     $url = 'https://scripts.digiebot.com/admin/api/get_candles';

    //     $ch = curl_init();

    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS,
    //         "coin=" . $coin . "&candle_date=" . $candle_date . "");

    //     // in real life you should use something like:
    //     // curl_setopt($ch, CURLOPT_POSTFIELDS,
    //     //          http_build_query(array('postvar1' => 'value1')));

    //     // receive server response ...
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     $server_output = curl_exec($ch);

    //     curl_close($ch);

    //     echo "<pre>";
    //     print_r((array) json_decode($server_output));
    //     exit;
    // }

    // public function waqar($coin_symbol = 'TRXBTC', $simulator_date = '2019-06-13 17:00:00', $barrier_date = '', $barrier_Type = 'down', $barrier_status = 'very_strong_barrier', $index = 0) {

    //     if ($barrier_date == '') {
    //         $simulator_date = date('Y-m-d H:i:s', strtotime('-3 hour', strtotime($simulator_date)));
    //     }

    //     $simulator_date_obj = $this->mongo_db->converToMongodttime($simulator_date);
    //     $barrier_date = ($barrier_date == '') ? $simulator_date_obj : $barrier_date;
    //     $this->mongo_db->order_by(array('created_date' => -1));
    //     $this->mongo_db->limit(1);
    //     $where['coin'] = $coin_symbol;
    //     $where['barrier_type'] = $barrier_Type;
    //     $where['original_barrier_status'] = $barrier_status;
    //     $where['created_date'] = array('$lt' => $barrier_date);
    //     // $where['barier_value'] = array('$lte'=>(float) $market_price);
    //     $this->mongo_db->where($where);
    //     $responseobj = $this->mongo_db->get('barrier_values_collection');
    //     $responseArr = iterator_to_array($responseobj);
    //     $min_arr = array();
    //     $barrier_min_val = 0;
    //     if (!empty($responseArr)) {
    //         $barrier_date = $responseArr[0]['created_date'];
    //         $barrier_min_val = $responseArr[0]['barier_value'];
    //         $barrir_obj_id = $responseArr[0]['_id'];
    //         //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //         $search['coin'] = $coin_symbol;
    //         $search['timestampDate'] = array('$gte' => $barrier_date, '$lte' => $simulator_date_obj);
    //         $this->mongo_db->where($search);
    //         $data = $this->mongo_db->get('market_chart');
    //         $row = iterator_to_array($data);
    //         foreach ($row as $rwo_1) {
    //             array_push($min_arr, num($rwo_1['open']));
    //             array_push($min_arr, num($rwo_1['close']));
    //         }
    //         //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     }
    //     $min_value = min($min_arr);
    //     if (($min_value < $barrier_min_val) && ($index < 6)) {
    //         $index++;
    //         $this->waqar($coin_symbol, $simulator_date, $barrier_date, $index);
    //     } else {
    //         return $barrier_min_val;
    //     }
    // } //End of run

    // public function cron_to_update_parent() {
    //     $this->mongo_db->where(array("status" => 2));
    //     $get = $this->mongo_db->get("report_setting_collection");
    //     foreach ($get as $key => $value) {
    //         $is_completed = $this->check_if_completed($value['_id']);
    //         var_dump($is_completed);
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
    //     $win_per = ($winning / $total_trades) * 100;
    //     $lose_per = ($losing / $total_trades) * 100;

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
    //     $final['win_per'] = $win_per;
    //     $final['lose_per'] = $lose_per;
    //     $final['per_trade'] = $total_per_trade;
    //     $final['current_date'] = $current_date;
    //     $final['created_date'] = $this->mongo_db->converToMongodttime($start_date);
    //     $final['end_date'] = $this->mongo_db->converToMongodttime($end_date);

    //     $this->mongo_db->insert("meta_coin_report_results", $final);

    //     $this->mongo_db->where(array("_id" => $setting_id));
    //     $this->mongo_db->set(array('status' => 0));
    //     $this->mongo_db->update("report_setting_collection");
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
    //     $this->mongo_db->where(array("status" => 2));
    //     $get = $this->mongo_db->get("report_setting_collection");

    //     foreach ($get as $key => $value) {
    //         $setting_id = $value['_id'];
    //         $this->mongo_db->where(array("_id" => $setting_id));
    //         $this->mongo_db->set(array('status' => 0));
    //         $this->mongo_db->update("report_setting_collection");
    //     }
    // }

    // public function test_del() {
    //     $where = array('modified_date' => array('$gte' => $this->mongo_db->converToMongodttime("2019-07-11 00:00:00")));
    //     $db = $this->mongo_db->customQuery();

    //     $db->market_trade_daily_percentile->deleteMany($where);

    // }

    // public function wick_filter_advance($data_arr, $hour, $percentile_arr) {

    //     $symbol = $data_arr['filter_by_coin'];
    //     $time = $hour;
    //     $this->mongo_db->where(array("coin" => $symbol, 'timestampDate' => $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-1 hour", strtotime($time))))));
    //     $this->mongo_db->order_by(array("timestampDate" => -1));
    //     $get = $this->mongo_db->get("market_chart");
    //     $get = iterator_to_array($get);
    //     // echo "<pre>";
    //     // print_r($get);
    //     $check_qty = $data_arr['wick_qty'];

    //     $check_per = $data_arr['wick_percentile'];

    //     $chk_t_v_per = $data_arr['total_vol_percentile'];

    //     $curr_hr_percentile = $data_arr['curr_hr_percentile'];

    //     $curr_hr_val = $data_arr['curr_hr_val'];

    //     $candle1 = $get[0];

    //     $last_open = $candle1['open'];
    //     $last_close = $candle1['close'];
    //     $last_high = $candle1['high'];
    //     $last_low = $candle1['low'];
    //     $last_candle_date = $candle1['openTime_human_readible'];

    //     if ($last_close > $last_open) {
    //         //echo $hour. " == " .$last_candle_date." Close: " . num($last_close) . " Open " . num($last_open) . " <br> ";
    //         $low_wick_qty = $candle1['lower_wick_contracts_' . $check_per];
    //         $body_qty = $candle1['body_contracts_' . $check_per];
    //         $total_qty = 0;
    //         if ($check_per == 10) {
    //             $total_qty += $candle1['lower_wick_contracts_1'] + $candle1['lower_wick_contracts_2'] + $candle1['lower_wick_contracts_3'] + $candle1['lower_wick_contracts_4'] + $candle1['lower_wick_contracts_5'] + $candle1['lower_wick_contracts_10'];
    //             $total_qty += $candle1['body_contracts_1'] + $candle1['body_contracts_2'] + $candle1['body_contracts_3'] + $candle1['body_contracts_4'] + $candle1['body_contracts_5'] + $candle1['body_contracts_10'];
    //         }

    //         if ($check_per == 5) {
    //             $total_qty += $candle1['lower_wick_contracts_1'] + $candle1['lower_wick_contracts_2'] + $candle1['lower_wick_contracts_3'] + $candle1['lower_wick_contracts_4'] + $candle1['lower_wick_contracts_5'];
    //             $total_qty += $candle1['body_contracts_1'] + $candle1['body_contracts_2'] + $candle1['body_contracts_3'] + $candle1['body_contracts_4'] + $candle1['body_contracts_5'];
    //         }

    //         if ($check_per == 4) {
    //             $total_qty += $candle1['lower_wick_contracts_1'] + $candle1['lower_wick_contracts_2'] + $candle1['lower_wick_contracts_3'] + $candle1['lower_wick_contracts_4'];
    //             $total_qty += $candle1['body_contracts_1'] + $candle1['body_contracts_2'] + $candle1['body_contracts_3'] + $candle1['body_contracts_4'];
    //         }

    //         if ($check_per == 3) {
    //             $total_qty += $candle1['lower_wick_contracts_1'] + $candle1['lower_wick_contracts_2'] + $candle1['lower_wick_contracts_3'];
    //             $total_qty += $candle1['body_contracts_1'] + $candle1['body_contracts_2'] + $candle1['body_contracts_3'];
    //         }

    //         if ($check_per == 2) {
    //             $total_qty += $candle1['lower_wick_contracts_1'] + $candle1['lower_wick_contracts_2'];
    //             $total_qty += $candle1['body_contracts_1'] + $candle1['body_contracts_2'];
    //         }
    //         if ($check_per == 1) {
    //             $total_qty += $candle1['lower_wick_contracts_1'];
    //             $total_qty += $candle1['body_contracts_1'];
    //         }

    //         $total_volume = $candle1['total_volume'];
    //         //echo "Volume of Total Percentile " . ($low_wick_qty + $body_qty) . " And To Check is " . $check_qty . "<br>";
    //         if ($total_qty >= $check_qty) {

    //             $total_v_percentile = $this->get_the_volume_in_percentile_arr($total_volume, $percentile_arr);
    //             //$total_v_percentile = $candle1['total_volume_percentile'];
    //             //echo "Volume of Total Percentile " . $total_v_percentile . " And To Check is " . $chk_t_v_per . "<br>";
    //             if (($total_v_percentile <= $chk_t_v_per) && ($total_v_percentile > "0")) {
    //                 if ($curr_hr_val == 'open') {
    //                     $value1 = $last_open;
    //                 } else if ($curr_hr_val == 'close') {
    //                     $value1 = $last_close;
    //                 } else if ($curr_hr_val == 'high') {
    //                     $value1 = $last_high;
    //                 } else if ($curr_hr_val == 'low') {
    //                     $value1 = $last_low;
    //                 } else {
    //                     $value1 = $close;
    //                 }
    //                 $wocl = true;
    //                 if ($wocl) {
    //                     $check_contract = $this->check_current_hour_contract_less_close_last_candle($hour, $curr_hr_percentile, $symbol, $value1);

    //                     if ($check_contract['success']) {
    //                         // echo "<pre>";
    //                         // print_r($check_contract);
    //                         return $check_contract;

    //                     } else {
    //                         //echo " False Contracts Not Found<br>";
    //                         return false;
    //                     }
    //                 } else {
    //                     // echo "Top 3 contracts are not in lower range <br>";
    //                     return false;
    //                 }

    //             } else {
    //                 //echo " Total Percentile Not Found<br>";
    //                 return false;
    //             }
    //         } else {
    //             //echo " Qty is Less Not Found<br>";
    //             return false;
    //         }
    //     } else {
    //         //echo " Candle is not Green<br>";
    //         return false;
    //     }

    // }

    // public function check_last_3_top_values($hour, $symbol, $range, $no_of_contracts) {

    //     $search_arr['coin'] = $symbol;
    //     $search_arr['created_date']['$gte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-1 hour", strtotime($hour))));

    //     $search_arr['created_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:59:59", strtotime("-1 hour", strtotime($hour))));

    //     $this->mongo_db->where($search_arr);
    //     $get = $this->mongo_db->get("market_trade_history");
    //     $get_arr = iterator_to_array($get);

    //     array_multisort(array_column($get_arr, "quantity"), SORT_DESC, $get_arr);

    //     // $top_1_contract = $get_arr[0];
    //     // $top_2_contract = $get_arr[1];
    //     // $top_3_contract = $get_arr[2];
    //     $flag = 0;
    //     for ($i = 0; $i < $no_of_contracts; $i++) {
    //         $price = $get_arr[$i]['price'];
    //         if ($price > $range) {
    //             $flag = 1;
    //             break;
    //         }
    //     }

    //     if ($flag == 0) {
    //         return true;
    //     } else {
    //         return false;

    //     }

    // }

    // public function check_current_hour_contract_less_close_last_candle($hour, $curr_hr_percentile, $symbol, $close) {
    //     $search_arr['coin'] = $symbol;
    //     $search_arr['price']['$lte'] = (float) $close;
    //     $search_arr['created_date']['$gte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime($hour)));
    //     $search_arr['created_date']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:59:59", strtotime($hour)));
    //     $search_arr['big_contracts_percentile']['$lte'] = $curr_hr_percentile;
    //     $search_arr['big_contracts_percentile']['$gt'] = '0';
    //     $this->mongo_db->where($search_arr);
    //     $this->mongo_db->limit(1);
    //     $this->mongo_db->order_by(array("created_date" => 1));
    //     $get = $this->mongo_db->get("market_trade_history");

    //     $get = iterator_to_array($get);
    //     // echo "<pre>";
    //     //print_r($get);
    //     if (count($get) > 0) {
    //         return array("price" => $get[0]['price'], "time" => $get[0]['created_date'], "success" => true, "last_candle_value" => $close);
    //     } else {
    //         return array("success" => false);
    //     }
    // }

    // public function get_the_volume_in_percentile($symbol = "TRXBTC", $quantity = 99197, $type = "ask", $time = "") {
    //     $this->mongo_db->where(array('coin' => $symbol, 'modified_date' => array('$lte' => $this->mongo_db->converToMongodttime($time))));
    //     $this->mongo_db->limit(30);
    //     $this->mongo_db->order_by(array("modified_date" => -1));
    //     $get = $this->mongo_db->get("market_trade_daily_percentile");

    //     $result = iterator_to_array($get);
    //     $row = $result[0];

    //     if ($type == 'bid') {
    //         $check = "big_sellers_contracts";
    //     } elseif ($type == 'ask') {
    //         $check = "big_buyers_contracts";
    //     } else {
    //         $check = 'big_contractors';
    //     }

    //     $percentile10_arr = array_column($result, $check . '_10');
    //     $percentile5_arr = array_column($result, $check . '_5');
    //     $percentile4_arr = array_column($result, $check . '_4');
    //     $percentile3_arr = array_column($result, $check . '_3');
    //     $percentile2_arr = array_column($result, $check . '_2');
    //     $percentile1_arr = array_column($result, $check . '_1');

    //     $percentile10 = (array_sum($percentile10_arr) / count($percentile10_arr));

    //     $percentile5 = (array_sum($percentile5_arr) / count($percentile5_arr));
    //     $percentile4 = (array_sum($percentile4_arr) / count($percentile4_arr));
    //     $percentile3 = (array_sum($percentile3_arr) / count($percentile3_arr));

    //     $percentile2 = (array_sum($percentile2_arr) / count($percentile2_arr));
    //     $percentile1 = (array_sum($percentile1_arr) / count($percentile1_arr));

    //     $quantity = (float) $quantity;
    //     echo "Quantity To Check is " . $quantity;
    //     echo " Time: " . $time . " Top10 " . $percentile10 . " Top5 " . $percentile5 . " Top4 " . $percentile4 . " Top3 " . $percentile3 . " Top2 " . $percentile2 . " Top1 " . $percentile1 . "<br>";

    //     //$top10avg = $percentile10 + $percentile5 + $percentile4 + $percentile3 + $percentile2 + $percentile1;

    //     //$top5avg = $percentile5 + $percentile4 + $percentile3 + $percentile2 + $percentile1;

    //     //$top4avg = $percentile4 + $percentile3 + $percentile2 + $percentile1;

    //     //$top3avg = $percentile3 + $percentile2 + $percentile1;

    //     //$top2avg = $percentile2 + $percentile1;

    //     //$top1avg = $percentile1;

    //     $Html10 = '10';

    //     $Html5 = '5';

    //     $Html1 = '1';

    //     $Html2 = '2';

    //     $Html3 = '3';

    //     $Html4 = '4';

    //     $Html0 = '0';

    //     if ($quantity >= $percentile10 && $quantity <= $percentile5) {
    //         $LastQtyTimeAgo = $Html10;
    //     } else if ($quantity >= $percentile5 && $quantity <= $percentile4) {
    //         $LastQtyTimeAgo = $Html5;
    //     } elseif ($quantity >= $percentile4 && $quantity <= $percentile3) {
    //         $LastQtyTimeAgo = $Html4;
    //     } elseif ($quantity >= $percentile3 && $quantity <= $percentile2) {
    //         $LastQtyTimeAgo = $Html3;
    //     } elseif ($quantity >= $percentile2 && $quantity <= $percentile1) {
    //         $LastQtyTimeAgo = $Html2;
    //     } else
    //     if ($quantity >= $percentile1) {
    //         $LastQtyTimeAgo = $Html1;
    //     } else {
    //         $LastQtyTimeAgo = $Html0;
    //     }
    //     return $LastQtyTimeAgo;
    // }

    // public function get_the_volume_in_percentile_arr($quantity = 99197, $percentile_arr) {
    //     $check = "volume_percentile";
    //     $percentile15 = $percentile_arr[$check . '_15'];
    //     $percentile20 = $percentile_arr[$check . '_20'];
    //     $percentile25 = $percentile_arr[$check . '_25'];
    //     $percentile50 = $percentile_arr[$check . '_50'];
    //     $percentile75 = $percentile_arr[$check . '_75'];
    //     $percentile100 = $percentile_arr[$check . '_100'];
    //     $percentile5 = $percentile_arr[$check . '_5'];
    //     $percentile4 = $percentile_arr[$check . '_4'];
    //     $percentile3 = $percentile_arr[$check . '_3'];
    //     $percentile2 = $percentile_arr[$check . '_2'];
    //     $percentile1 = $percentile_arr[$check . '_1'];
    //     // echo "Quantity To Check is " . $quantity;
    //     // echo " Time: " . $time . " Top10 " . $percentile10 . " Top5 " . $percentile5 . " Top4 " . $percentile4 . " Top3 " . $percentile3 . " Top2 " . $percentile2 . " Top1 " . $percentile1 . "<br>";

    //     $Html100 = '100';
    //     $Html75 = '75';
    //     $Html50 = '50';
    //     $Html25 = '25';
    //     $Html20 = '20';
    //     $Html15 = '15';

    //     $Html10 = '10';

    //     $Html5 = '5';

    //     $Html1 = '1';

    //     $Html2 = '2';

    //     $Html3 = '3';

    //     $Html4 = '4';

    //     $Html0 = '0';

    //     if ($quantity >= $percentile100 && $quantity <= $percentile75) {
    //         $LastQtyTimeAgo = $Html100;
    //     } elseif ($quantity >= $percentile75 && $quantity <= $percentile50) {
    //         $LastQtyTimeAgo = $Html75;
    //     } elseif ($quantity >= $percentile50 && $quantity <= $percentile25) {
    //         $LastQtyTimeAgo = $Html50;
    //     } elseif ($quantity >= $percentile25 && $quantity <= $percentile20) {
    //         $LastQtyTimeAgo = $Html25;
    //     } elseif ($quantity >= $percentile20 && $quantity <= $percentile15) {
    //         $LastQtyTimeAgo = $Html20;
    //     } elseif ($quantity >= $percentile15 && $quantity <= $percentile10) {
    //         $LastQtyTimeAgo = $Html15;
    //     } else if ($quantity >= $percentile10 && $quantity <= $percentile5) {
    //         $LastQtyTimeAgo = $Html10;
    //     } else if ($quantity >= $percentile5 && $quantity <= $percentile4) {
    //         $LastQtyTimeAgo = $Html5;
    //     } elseif ($quantity >= $percentile4 && $quantity <= $percentile3) {
    //         $LastQtyTimeAgo = $Html4;
    //     } elseif ($quantity >= $percentile3 && $quantity <= $percentile2) {
    //         $LastQtyTimeAgo = $Html3;
    //     } elseif ($quantity >= $percentile2 && $quantity <= $percentile1) {
    //         $LastQtyTimeAgo = $Html2;
    //     } else
    //     if ($quantity >= $percentile1) {
    //         $LastQtyTimeAgo = $Html1;
    //     } else {
    //         $LastQtyTimeAgo = $Html0;
    //     }
    //     return $LastQtyTimeAgo;
    // }

    // public function test($symbol = "TRXBTC") {

    //     $time = "2019-07-09 04:00:00";
    //     $this->mongo_db->where(array("coin" => $symbol, 'timestampDate' => array('$gte' => $this->mongo_db->converToMongodttime($time))));
    //     $this->mongo_db->order_by(array("timestampDate" => 1));
    //     $get = $this->mongo_db->get("market_chart");
    //     $get = iterator_to_array($get);

    //     foreach ($get as $key => $value) {
    //         $id = $value['_id'];
    //         $open = $value['open'];
    //         $high = $value['high'];
    //         $low = $value['low'];
    //         $close = $value['close'];
    //         $total_volume = $value['total_volume'];
    //         $start_date = $value['openTime_human_readible'];
    //         $symbol = $value['coin'];
    //         $end_date = $value['closeTime_human_readible'];

    //         if ($open > $close) {
    //             $big = $open;
    //             $small = $close;
    //         } else {
    //             $big = $close;
    //             $small = $open;
    //         }

    //         $body_contracts = $this->get_market_trade_data_for_range($symbol, $start_date, $end_date, $high, $big);
    //         $upper_wick_contracts = $this->get_market_trade_data_for_range($symbol, $start_date, $end_date, $high, $big);
    //         $lower_wick_contracts = $this->get_market_trade_data_for_range($symbol, $start_date, $end_date, $close, $low);
    //         echo $start_date . "<br>";
    //         $update_arr = array(
    //             'body_contracts_10' => $body_contracts['qty10'],
    //             'upper_wick_contracts_10' => $upper_wick_contracts['qty10'],
    //             'lower_wick_contracts_10' => $lower_wick_contracts['qty10'],

    //             'body_contracts_5' => $body_contracts['qty5'],
    //             'upper_wick_contracts_5' => $upper_wick_contracts['qty5'],
    //             'lower_wick_contracts_5' => $lower_wick_contracts['qty5'],

    //             'body_contracts_4' => $body_contracts['qty4'],
    //             'upper_wick_contracts_4' => $upper_wick_contracts['qty4'],
    //             'lower_wick_contracts_4' => $lower_wick_contracts['qty4'],

    //             'body_contracts_3' => $body_contracts['qty3'],
    //             'upper_wick_contracts_3' => $upper_wick_contracts['qty3'],
    //             'lower_wick_contracts_3' => $lower_wick_contracts['qty3'],

    //             'body_contracts_2' => $body_contracts['qty2'],
    //             'upper_wick_contracts_2' => $upper_wick_contracts['qty2'],
    //             'lower_wick_contracts_2' => $lower_wick_contracts['qty2'],

    //             'body_contracts_1' => $body_contracts['qty1'],
    //             'upper_wick_contracts_1' => $upper_wick_contracts['qty1'],
    //             'lower_wick_contracts_1' => $lower_wick_contracts['qty1'],
    //         );

    //         $db = $this->mongo_db->customQuery();
    //         $findArr = array('_id' => $id);
    //         $ins_data = $db->market_chart->updateOne($findArr, array('$set' => $update_arr));

    //         echo "Updated Now: " . $start_date . " <br>";

    //         echo "<pre>";
    //         print_r($update_arr);
    //     }
    //     exit;
    // }

    // public function get_market_trade_data_for_range($symbol, $start, $end, $up_price, $low_price) {

    //     $search_arr['coin'] = $symbol;
    //     $search_arr['created_date']['$gte'] = $this->mongo_db->converToMongodttime($start);
    //     $search_arr['created_date']['$lte'] = $this->mongo_db->converToMongodttime($end);

    //     $search_arr['price']['$gte'] = (float) $low_price;
    //     $search_arr['price']['$lte'] = (float) $up_price;

    //     //$search_arr['maker'] = 'true';
    //     //$search_arr['big_contracts_percentile']['$in'] = array('1', '2');

    //     $this->mongo_db->where($search_arr);
    //     $res = $this->mongo_db->get("market_trade_history");

    //     //$search_arr['maker'] = 'false';

    //     // $this->mongo_db->where($search_arr);
    //     // $res1 = $this->mongo_db->get("market_trade_history");

    //     $true_qty_10 = 0;
    //     $true_qty_5 = 0;
    //     $true_qty_4 = 0;
    //     $true_qty_3 = 0;
    //     $true_qty_2 = 0;
    //     $true_qty_1 = 0;

    //     foreach ($res as $val) {

    //         if ($val['big_contracts_percentile'] == '10') {
    //             $true_qty_10 += $val['quantity'];
    //         }

    //         if ($val['big_contracts_percentile'] == '5') {
    //             $true_qty_5 += $val['quantity'];
    //         }

    //         if ($val['big_contracts_percentile'] == '4') {
    //             $true_qty_4 += $val['quantity'];
    //         }

    //         if ($val['big_contracts_percentile'] == '3') {
    //             $true_qty_3 += $val['quantity'];
    //         }

    //         if ($val['big_contracts_percentile'] == '2') {
    //             $true_qty_2 += $val['quantity'];
    //         }

    //         if ($val['big_contracts_percentile'] == '1') {
    //             $true_qty_1 += $val['quantity'];
    //         }

    //     }

    //     $retArr['qty10'] = $true_qty_10;
    //     $retArr['qty5'] = $true_qty_5;
    //     $retArr['qty4'] = $true_qty_4;
    //     $retArr['qty3'] = $true_qty_3;
    //     $retArr['qty2'] = $true_qty_2;
    //     $retArr['qty1'] = $true_qty_1;

    //     return $retArr;
    // }

    // public function run() {
    //     $search_arr['symbol'] = "TRXBTC";
    //     $search_arr['market_value'] = (float) 0.00366120;

    //     $this->mongo_db->where($search_arr);
    //     $get = $this->mongo_db->get("sold_buy_orders");
    //     $get = iterator_to_array($get);

    //     echo "<pre>";
    //     print_r($get);
    //     exit;

    // }

    // public function calculate_top_candles_percentile($coin_symbol = "TRXBTC", $start_date = "2019-07-11 00:00:00") {
    //     $search_arr['coin'] = $coin_symbol;
    //     $search_arr['timestampDate']['$lte'] = $this->mongo_db->converToMongodttime($start_date);
    //     $search_arr['timestampDate']['$gte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("-10 days", strtotime($start_date))));
    //     $this->mongo_db->where($search_arr);

    //     $get = $this->mongo_db->get("market_chart");

    //     $get = iterator_to_array($get);

    //     $total_volume = array_column($get, "total_volume");
    //     rsort($total_volume);

    //     $percentiles = $this->calculate_percentile_history($total_volume, "volume_percentile");

    //     return $percentiles;

    // }

    // public function calculate_top_candles_percentile_csv($coin_symbol = "TRXBTC", $start_date = "2019-07-11 00:00:00") {
    //     $start_date = date("Y-m-d 00:00:00");
    //     $search_arr['coin'] = $coin_symbol;
    //     $search_arr['timestampDate']['$lte'] = $this->mongo_db->converToMongodttime($start_date);
    //     $search_arr['timestampDate']['$gte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("-10 days", strtotime($start_date))));
    //     $this->mongo_db->where($search_arr);

    //     $get = $this->mongo_db->get("market_chart");

    //     $get = iterator_to_array($get);

    //     $total_volume = array_column($get, "total_volume");
    //     rsort($total_volume);

    //     $this->download_send_headers("trade_history_" . date("Y-m-d_ Gisa") . ".csv");

    //     echo $this->array2csv($total_volume);

    //     exit;

    // }

    // public function calculate_percentile_history($arr, $index) {
    //     $sell_index_1 = round((count($arr) / 100) * 1);
    //     $sell_1 = $arr[$sell_index_1];
    //     $ret_arr[$index . '_1'] = $sell_1;

    //     $sell_index_1 = round((count($arr) / 100) * 2);
    //     $sell_1 = $arr[$sell_index_1];
    //     $ret_arr[$index . '_2'] = $sell_1;

    //     $sell_index_1 = round((count($arr) / 100) * 3);
    //     $sell_1 = $arr[$sell_index_1];
    //     $ret_arr[$index . '_3'] = $sell_1;

    //     $sell_index_1 = round((count($arr) / 100) * 4);
    //     $sell_1 = $arr[$sell_index_1];
    //     $ret_arr[$index . '_4'] = $sell_1;

    //     $sell_index_1 = round((count($arr) / 100) * 5);
    //     $sell_1 = $arr[$sell_index_1];
    //     $ret_arr[$index . '_5'] = $sell_1;

    //     $sell_index_1 = round((count($arr) / 100) * 10);
    //     $sell_1 = $arr[$sell_index_1];
    //     $ret_arr[$index . '_10'] = $sell_1;

    //     $sell_index_15 = round((count($arr) / 100) * 15);
    //     $sell_15 = $arr[$sell_index_15];
    //     $ret_arr[$index . '_15'] = $sell_15;

    //     $sell_index_20 = round((count($arr) / 100) * 20);
    //     $sell_20 = $arr[$sell_index_20];
    //     $ret_arr[$index . '_20'] = $sell_20;

    //     $sell_index_25 = round((count($arr) / 100) * 25);
    //     $sell_25 = $arr[$sell_index_25];
    //     $ret_arr[$index . '_25'] = $sell_25;

    //     $sell_index_50 = round((count($arr) / 100) * 50);
    //     $sell_50 = $arr[$sell_index_50];
    //     $ret_arr[$index . '_50'] = $sell_50;

    //     $sell_index_75 = round((count($arr) / 100) * 75);
    //     $sell_75 = $arr[$sell_index_75];
    //     $ret_arr[$index . '_75'] = $sell_75;

    //     $sell_index_100 = round((count($arr) / 100) * 100);
    //     $sell_100 = $arr[$sell_index_100];
    //     $ret_arr[$index . '_100'] = $sell_100;

    //     return $ret_arr;
    // }

    // public function get_price_change($symbol, $start_date) {
    //     //$symbol = "TRXBTC";
    //     //$start_date = "2019-07-12 00:00:00";

    //     $search['coin'] = $symbol;
    //     $search['time']['$gte'] = $this->mongo_db->converToMongodttime($start_date);
    //     $search['time']['$lte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("+5 minutes", strtotime($start_date))));

    //     $this->mongo_db->where($search);
    //     $this->mongo_db->order_by(array("time" => -1));
    //     $get = $this->mongo_db->get("market_price_minut");

    //     $res = iterator_to_array($get);

    //     $first_price = $res[0]['market_value'];

    //     $last_price = $res[count($res) - 1]['market_value'];

    //     $margin = $first_price - $last_price;
    //     $percentage = ($margin / $last_price) * 100;

    //     return $percentage;
    // }

    // public function array2csv($array) {

    //     if (count($array) == 0) {

    //         return null;

    //     }

    //     ob_start();

    //     $df = fopen("php://output", 'w');

    //     fputcsv($df, array_keys((array) reset($array)));

    //     foreach ($array as $row) {

    //         fputcsv($df, (array) $row);

    //     }

    //     fclose($df);

    //     return ob_get_clean();

    // }

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

}
?>