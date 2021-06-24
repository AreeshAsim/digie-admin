<?php
class Mod_realtime_candle_socket extends CI_Model {

    function __construct() {

        parent::__construct();
        $this->load->model("admin/mod_sockets");
        $this->load->model("admin/mod_custom_script");
    }

    public function save_candle_stick_by_cron_job() {
        echo "Function start <br>";
        //Get All Coins
        $make_log = array();
        $make_log['call_enter_at'] = date('Y-m-d H:i:s');
        $all_coins_arr = $this->mod_sockets->get_all_coins();
        $period_array = array('1h');
        for ($i = 0; $i < count($all_coins_arr); $i++) {
            $coin_symbol = $all_coins_arr[$i]['symbol'];
            //Insert Socket Record

            $make_log['coin_symbol'] = $coin_symbol;


            /*** Run Socket for period***/
            foreach ($period_array as $periods) {

                $chart = $this->binance_api->get_candelstick($coin_symbol, $periods);
              
                if (count($chart) > 0) {
                    echo "Call Start";
                    foreach ($chart as $key => $value) {
                        $created_datetime = date('Y-m-d H:i:s', strtotime('-1 hour'));
                        $orig_date = new DateTime($created_datetime);
                        $orig_date = $orig_date->getTimestamp();
                        $created_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);
                        $seconds = $value['openTime'] / 1000;
                        $datetime = date("Y-m-d H:i:s", $seconds);
                        $openTime_human_readible = $datetime;
                        $seconds_close = $value['closeTime'] / 1000;
                        $datetime_close = date("Y-m-d H:i:s", $seconds_close);
                        $closeTime_human_readible = $datetime_close;
                        $orig_date22 = new DateTime($datetime);
                        $orig_date22 = $orig_date22->getTimestamp();
                        $timestampDate = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);

                        //Check if candel is previos then Execuite it
                        $date_for_candel = date('Y-m-d H:00:00', strtotime('-1 hour'));
                        $end_date_for_candel = date('Y-m-d H:59:59', strtotime('-1 hour'));

                        $make_log['candle_stick_call'] = 'yes';

                        $ask_volume = $this->get_and_calculate_volume_for_candel($date_for_candel, $end_date_for_candel, 'ask', $coin_symbol);

                        $make_log['ask_volume_calculated'] = $ask_volume;

                        $bid_volume = $this->get_and_calculate_volume_for_candel($date_for_candel, $end_date_for_candel, 'bid', $coin_symbol);

                        $make_log['bid_volume_calculated'] = $bid_volume;

                        $totla_volume = $ask_volume + $bid_volume;

                        $buy_volume = $this->get_and_calculate_volume_for_candel_bvs($date_for_candel, $end_date_for_candel, 'buy', $coin_symbol);
                        $sell_volume = $this->get_and_calculate_volume_for_candel_bvs($date_for_candel, $end_date_for_candel, 'sell', $coin_symbol);
                        $total_volume_bvs = $buy_volume + $sell_volume;
                        $make_log['buy_volume_calculated'] = $buy_volume;
                        $make_log['sell_volume_calculated'] = $sell_volume;

                        $response_detail = $this->calculate_swing_poinst($coin_symbol, $value['high'], $value['low'], $date_for_candel);

                        $make_log['swing_point_calculated'] = 'yes';

                        //update Candel Three Hour Back
                        $four_day_back = date('Y-m-d H:00:00', strtotime('-4 hour'));

                        //%%%%%%%%%%%%%%%%%%%%%%%%%

                        //%%%%%%%%%%%%%%%%%%%%%%%%

                        $current_candle_date = $openTime_human_readible;

                        extract($response_detail);

                        $base_candel_arr = $this->calculate_base_candel($coin_symbol, $demand_percentage, $supply_percentage);

                        $make_log['base_candle_calculated'] = 'yes';

                        $DemandTrigger = $base_candel_arr['demond_max_volume'];
                        $SupplyTrigger = $base_candel_arr['supply_max_volume'];
                        $demand_base_candel = $DemandTrigger;
                        $supply_base_candel = $SupplyTrigger;

                        // $DemandTrigger = ($base_candel/100)*$demand_percentage;
                        // $SupplyTrigger = ($base_candel/100)*$supply_percentage;

                        $ask_plus_bid = $ask_volume + $bid_volume;

                        // $DemandCandle = ($ask_volume > $bid_volume && $ask_volume >= $DemandTrigger) ? 1 : 0;
                        // $SupplyCandle = ($bid_volume > $ask_volume && $bid_volume >= $SupplyTrigger) ? 1 : 0;

                        $DemandCandle = ($ask_volume > $bid_volume && $ask_plus_bid >= $DemandTrigger) ? 1 : 0;
                        $SupplyCandle = ($bid_volume > $ask_volume && $ask_plus_bid >= $SupplyTrigger) ? 1 : 0;

                        $candle_type = 'normal';
                        if ($DemandCandle == 1) {
                            $candle_type = 'demand';
                        }
                        if ($SupplyCandle == 1) {
                            $candle_type = 'supply';
                        }
                        $rejection_status = $this->calculate_rejection_candle($coin_symbol, $date_for_candel);

                        $make_log['find_rejection_status'] = 'yes';

                        $depth_wall_array = $this->get_hourly_depthwall($date_for_candel, $end_date_for_candel, $coin_symbol);
                        $black_ask_diff = $depth_wall_array['black_ask_diff'];
                        $black_bid_diff = $depth_wall_array['black_bid_diff'];
                        $yellow_ask_diff = $depth_wall_array['yellow_ask_diff'];
                        $yellow_bid_diff = $depth_wall_array['yellow_bid_diff'];
                        /////////////////////////////////////////////////////////////////////////

                        $market_move_arr = $this->calculate_market_move($coin_symbol); // Abbas latest change , market move , volume move , per_move

                        /////////////////////////////////////////////////////////////////////////
                        $insert22 = array(
                            'open' => (float) $value['open'],
                            'high' => (float) $value['high'],
                            'low' => (float) $value['low'],
                            'close' => (float) $value['close'],
                            'volume' => (float) $value['volume'],
                            'openTime' => $value['openTime'],
                            'closeTime' => $value['closeTime'],
                            'coin' => $coin_symbol,
                            'created_date' => $created_date,
                            'timestampDate' => $timestampDate,
                            'periods' => $periods,
                            'openTime_human_readible' => $openTime_human_readible,
                            'closeTime_human_readible' => $closeTime_human_readible,
                            'human_readible_dateTime' => date('Y-m-d H:i:s', strtotime('-1 hour')),
                            'candel_status' => $candel_status,
                            'candle_type' => $candle_type,
                            'ask_volume' => $ask_volume,
                            'bid_volume' => $bid_volume,
                            'total_volume' => $totla_volume,
                            'buy_volume' => $buy_volume,
                            'sell_volume' => $sell_volume,
                            'total_volume_bvs' => $total_volume_bvs,
                            'demand_base_candel' => $demand_base_candel,
                            'supply_base_candel' => $demand_base_candel, //supply_base_candel
                            'trigger_status' => 0,
                            'triggert_type' => '',
                            'highest_swing_point' => $highest_swing_point,
                            'lowest_swing_point' => $lowest_swing_point,
                            'candel_highest_swing_status' => $candel_highest_swing_status,
                            'candel_lowest_swing_status' => $candel_lowest_swing_status,
                            'global_swing_status' => $global_swing_status,
                            'global_swing_parent_status' => '',
                            'black_ask_diff' => $black_ask_diff,
                            'black_bid_diff' => $black_bid_diff,
                            'yellow_ask_diff' => $yellow_ask_diff,
                            'yellow_bid_diff' => $yellow_bid_diff,
                            'rejected_candle' => $rejection_status,
                            'per_move' => $market_move_arr['per_move'],
                            'move' => $market_move_arr['move'],
                            'vol_move' => $market_move_arr['vol_move'],
                        );
                     
                        
                        if ($openTime_human_readible == $date_for_candel) {
                            $check_candle = $this->mod_sockets->check_candle_stick_data_if_exist($coin_symbol, $periods, $value['openTime']);
                            if ($check_candle) {
                                $candle_id = $this->mongo_db->insert('market_chart', $insert22);
                                echo 'insert' . '<br>';
                                // this for current candel rejection status so we can check after inserting the date in db , 
                                $rejection_status = $this->calculate_rejection_candle($coin_symbol, $date_for_candel);

                                $make_log['calculate_rejetion_candle'] = 'yes';
                                $upd['rejected_candle'] = $rejection_status;
                                $this->mongo_db->where(array('_id' => $candle_id));
                                $this->mongo_db->set($upd);
                                $this->mongo_db->update('market_chart');
                            } else {
                                $if_current_cand = $this->check_if_current_candle($periods, $value['openTime']);
                                if ($if_current_cand) {

                                    $this->mod_sockets->candle_update($coin_symbol, $periods, $value['openTime'], $insert22);
                                    echo 'update' . '<br>';
                                } else {
                                    $update_count_for_canlde_missing = $this->mod_sockets->update_count_for_ignore_candle();
                                    echo 'nothing' . '<br>';

                                } /*** End of update***/
                            } /*** End of insert***/

                        } // End of if candel is pervious

                        //calcualte for candel after candel insert

                        if ($current_candle_date == $date_for_candel) {
                            $this->calculate_candel_status_demand_supply($four_day_back, $coin_symbol);
                            $make_log['calculate_candle_status_demand_supply'] = 'yes';
                        }

                        $this->mongo_db->insert('log_for_candle_creation_and_its_all_calculations', $make_log);

                    } //End of for each
                }/** End of chart count*/

            }/** End of period array**/

        } //end for
    } //End of save_candle_stick_by_cron_job

    public function get_hourly_depthwall($start_date, $end_date, $coin_symbol) {

        //$coin_symbol = $value['symbol'];

        $where['coin'] = $coin_symbol;
        $where['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($start_date), '$lte' => $this->mongo_db->converToMongodttime($end_date));

        $order_by['created_date'] = -1;
        $this->mongo_db->where($where);
        $this->mongo_db->order_by($order_by);
        $get = $this->mongo_db->get('depth_wall_history');
        $array = iterator_to_array($get);

        $x = 1;
        $bid_diff = array();
        $ask_diff = array();
        $y_bid_diff = array();
        $y_ask_diff = array();
        for ($i = 0; $i < count($array); $i++) {

            $ask_wall = $array[$i]['black_ask_diff'];
            $bid_wall = $array[$i]['black_bid_diff'];

            $y_ask_wall = $array[$i]['yellow_ask_diff'];
            $y_bid_wall = $array[$i]['yellow_bid_diff'];

            $bid_diff[] = $bid_wall;
            $ask_diff[] = $ask_wall;

            $y_bid_diff[] = $y_bid_wall;
            $y_ask_diff[] = $y_ask_wall;

            $x++;

        }

        $bid_diff_sum = array_sum($bid_diff);

        $bid = round($bid_diff_sum / $x);

        $ask_diff_sum = array_sum($ask_diff);
        $ask = round($ask_diff_sum / $x);

        $y_bid_diff_sum = array_sum($y_bid_diff);
        $y_bid = round($y_bid_diff_sum / $x);

        $y_ask_diff_sum = array_sum($y_ask_diff);
        $y_ask = round($y_ask_diff_sum / $x);

        /*$ins_arr = array('coin' => $coin_symbol, "ask_diff" => $ask, 'bid_diff' => $bid, 'datetime' => $this->mongo_db->converToMongodttime($start_date), 'date_time_human_readable' => $start_date);

        $this->mongo_db->insert('market_depth_hourly_wall', $ins_arr);

        $ins_arr22 = array('coin' => $coin_symbol, "ask_diff" => $y_ask, 'bid_diff' => $y_bid, 'datetime' => $this->mongo_db->converToMongodttime($start_date), 'date_time_human_readable' => $start_date);
        $this->mongo_db->insert('market_depth_yellow_hourly_wall', $ins_arr22);
         */

        $ret_arr = array(
            'black_ask_diff' => $ask,
            'black_bid_diff' => $bid,
            'yellow_ask_diff' => $y_ask,
            'yellow_bid_diff' => $y_bid,
        );

        return $ret_arr;
    }

    public function get_and_calculate_volume_for_candel($from_date, $end_date, $volume_type, $coin_type) {
        $connect = $this->mongo_db->customQuery();
        $res = $connect->market_trade_hourly_history->find(array(
            'type' => $volume_type,
            'coin' => $coin_type,
            'hour' => array('$gte' => $from_date, '$lte' => $end_date),
        ));
        $volume = 0;
        $res = iterator_to_array($res);
        foreach ($res as $key) {
            $volume += (float) $key['volume'];
        }
        return $volume;
    } //End of  get_and_calculate_volume_for_candel

    public function get_and_calculate_volume_for_candel_bvs($from_date, $end_date, $volume_type, $coin_type) {
        $connect = $this->mongo_db->customQuery();
        $res = $connect->market_trade_hourly_history_bvs->find(array(
            'type' => $volume_type,
            'coin' => $coin_type,
            'hour' => array('$gte' => $from_date, '$lte' => $end_date),
        ));
        $volume = 0;
        $res = iterator_to_array($res);
        foreach ($res as $key) {
            $volume += (float) $key['volume'];
        }
        // echo "<pre>";
        // print_r(array(
        //     'type' => $volume_type,
        //     'coin' => $coin_type,
        //     'hour' => array('$gte' => $from_date, '$lte' => $end_date),
        // ));
        // exit;
        return $volume;
    } //End of  get_and_calculate_volume_for_candel

    public function check_if_current_candle($periods, $openTime) {
        list($alpha, $numeric) = sscanf($periods, "%[A-Z]%d");
        switch ($alpha) {
        case "h":
            $response_period = ($numeric * 3600) * 2;
            break;
        case "m":
            $response_period = ($numeric * 60) * 2;
            break;
        default:
            $response_period = 1 * 2;
        }
        $seconds = $openTime / 1000;
        $datetime = date("Y-m-d H:i:s", $seconds);
        $seconds_2 = $seconds - $response_period;
        $datetime_2 = date("Y-m-d H:i:s", $seconds_2);
        if ($datetime_2 < $datetime) {
            return true;
        } else {
            return false;
        }
    } /*** End of check_if_current_candle**/

    ////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////
    ////////////////////                       /////////////////
    ////////////////////                       ////////////////////////////////
    //////////////////// Swing Point Live      ////////////////////////////////
    ////////////////////                       ////////////////////////////////
    ////////////////////                       /////////////////
    ////////////////////                       /////////////////
    ////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////

    // we calculate swing points accoridng to given settings in candel chart , and also we calucate the continuse status on the bases on hardcoded setting given by client , 


    public function calculate_swing_poinst($coin_symbol, $current_highest_point, $current_lowest_point, $date_for_candel) {

        ///////////////////////////////////////////////////////////////////////
        ///////////////Get Task Manager Setting Details //////////////////////
        $task_manager_setting_obj = $this->mongo_db->get('task_manager_setting');
        $task_manager_setting_arr = iterator_to_array($task_manager_setting_obj);
        //if coin have no setting then pick this by defualt , 
        $number_of_look_back = 5;
        $number_of_look_forward = 3;
        $maxLvlLen = 0;
        $ShowHHLL = 0;
        $WaitForClose = 1;
        $LH_Percentile = 10;
        $LH_Percentile_supply = 10;
        $Continuation_up_Percentile = 30;
        $Continuation_up_Percentile_supply = 30;
        $Current_up_Percentile = 25;
        $Current_up_Percentile_supply = 25;
        $HL_Percentile = 10;
        $HL_Percentile_supply = 10;
        $Continuation_Down_Percentile = 20;
        $Continuation_Down_Percentile_supply = 20;
        $Current_Down_Percentile = 25;
        $Current_Down_Percentile_supply = 25;

        if (count($task_manager_setting_arr) > 0) {
            $number_of_look_back = $task_manager_setting_arr[0]['pvtLenL'];
            $number_of_look_forward = $task_manager_setting_arr[0]['pvtLenR'];

            $maxLvlLen = $task_manager_setting_arr[0]['maxLvlLen'];
            $ShowHHLL = $task_manager_setting_arr[0]['ShowHHLL'];
            $WaitForClose = $task_manager_setting_arr[0]['WaitForClose'];
            // diffrent percentails for diffrent states , for down diffrent for up diffrent for continue down diffrent etc , assignes on the bases on state
            $LH_Percentile = $task_manager_setting_arr[0]['LH_Percentile'];
            $LH_Percentile_supply = $task_manager_setting_arr[0]['LH_Percentile_supply'];
            $Continuation_up_Percentile = $task_manager_setting_arr[0]['Continuation_up_Percentile'];
            $Continuation_up_Percentile_supply = $task_manager_setting_arr[0]['Continuation_up_Percentile_supply'];
            $Current_up_Percentile = $task_manager_setting_arr[0]['Current_up_Percentile'];
            $Current_up_Percentile_supply = $task_manager_setting_arr[0]['Current_up_Percentile_supply'];
            $HL_Percentile = $task_manager_setting_arr[0]['HL_Percentile'];
            $HL_Percentile_supply = $task_manager_setting_arr[0]['HL_Percentile_supply'];
            $Continuation_Down_Percentile = $task_manager_setting_arr[0]['Continuation_Down_Percentile'];
            $Continuation_Down_Percentile_supply = $task_manager_setting_arr[0]['Continuation_Down_Percentile_supply'];
            $Current_Down_Percentile = $task_manager_setting_arr[0]['Current_Down_Percentile'];
            $Current_Down_Percentile_supply = $task_manager_setting_arr[0]['Current_Down_Percentile_supply'];
        }
        ///////////////End Task Manager Setting Details //////////////////////
        /////////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////////////////////
        //////////////////Get Look Back Detail //////////////////////////
        $number_of_look_forward = 0;

        $current_swing_heighst_point = $this->find_swing_heighst_points($number_of_look_back, $number_of_look_forward, $date_for_candel, $coin_symbol);

        // echo '<pre>';
        // print_r($current_swing_heighst_point);
        // exit();

        $current_swing_lowest_point = $this->find_swing_lowest_points($number_of_look_back, $number_of_look_forward, $date_for_candel, $coin_symbol);

        $prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour', strtotime($date_for_candel)));

        $this->mongo_db->limit(2);
        $this->mongo_db->order_by(array('timestampDate' => -1));
        $this->mongo_db->where_lte('timestampDate', $this->mongo_db->converToMongodttime($prevouse_date));

        $this->mongo_db->where(array('coin' => $coin_symbol));
        $response_detail = $this->mongo_db->get('market_chart');
        $market_chart_arr = iterator_to_array($response_detail);

        $previous_highest_point = 0;
        $previous_lowest_point = 0;

        $previous_swing_high_status = '';
        $second_last_high_swing_status = '';

        $second_last_lowest_swing_status = '';
        $previous_swing_lowest_status = '';

        if (count($market_chart_arr) > 0) {

            $previous_highest_point = $market_chart_arr[0]['highest_swing_point'];
            $previous_lowest_point = $market_chart_arr[0]['lowest_swing_point'];
            $candel_status = $market_chart_arr[0]['candel_status'];
            $global_swing_status = $market_chart_arr[0]['global_swing_status'];

            $second_last_high_swing_status = $market_chart_arr[1]['candel_highest_swing_status'];
            $previous_swing_high_status = $market_chart_arr[0]['candel_highest_swing_status'];

            $second_last_lowest_swing_status = $market_chart_arr[1]['candel_lowest_swing_status'];
            $previous_swing_lowest_status = $market_chart_arr[0]['candel_lowest_swing_status'];

        } //End of if

        $demand_percentage = 90;
        $supply_percentage = 90;

        $candel_highest_swing_status = '';
        $global_swing_parent_status = '';

        if ($current_swing_heighst_point != '') {

            if ($current_swing_heighst_point <= $previous_highest_point) {
                $candel_status = 'normal';
                $candel_highest_swing_status = 'LH';
                $demand_percentage = $LH_Percentile;
                $supply_percentage = $LH_Percentile_supply;
                $global_swing_status = 'LH';

                $global_swing_parent_status = 'LH';

            } else {

                $candel_highest_swing_status = 'HH';
                $global_swing_status = 'HH';
                $global_swing_parent_status = 'HH';
                if ($previous_swing_high_status == 'HH' && $second_last_high_swing_status == 'HH') {

                    $demand_percentage = $Continuation_up_Percentile;
                    $supply_percentage = $Continuation_up_Percentile_supply;
                    $candel_status = 'Continuation_up';

                } else {
                    $candel_status = 'Current_up';
                    $demand_percentage = $Current_up_Percentile;
                    $supply_percentage = $Current_up_Percentile_supply;
                }
            }

        } else {

            if ($candel_status == 'normal') {
                $demand_percentage = $LH_Percentile;
                $supply_percentage = $LH_Percentile_supply;
            } else if ($candel_status == 'Continuation_up') {
                $demand_percentage = $Continuation_up_Percentile;
                $supply_percentage = $Continuation_up_Percentile_supply;
            } else if ($candel_status == 'Current_up') {
                $demand_percentage = $Current_up_Percentile;
                $supply_percentage = $Current_up_Percentile_supply;
            }

            $current_highest_point = $previous_highest_point;
            $candel_highest_swing_status = $candel_highest_swing_status;

        }

        if ($current_swing_lowest_point != '') {

            if ($current_swing_lowest_point >= $previous_lowest_point) {

                $candel_lowest_swing_status = 'HL';
                $global_swing_parent_status = 'HL';
                $global_swing_status = 'HL';
                $demand_percentage = $HL_Percentile;
                $supply_percentage = $HL_Percentile_supply;

            } else {

                $candel_lowest_swing_status = 'LL';
                $global_swing_parent_status = 'LL';
                $global_swing_status = 'LL';
                if (($previous_swing_lowest_status == 'LL') && ($second_last_lowest_swing_status == 'LL')) {

                    $demand_percentage = $Continuation_Down_Percentile;
                    $supply_percentage = $Continuation_Down_Percentile_supply;
                    $candel_status = 'Continuation_Down';
                } else {

                    $demand_percentage = $Current_Down_Percentile;
                    $supply_percentage = $Current_Down_Percentile_supply;
                    $candel_status = 'Current_Down';
                }
            }

        } else {

            if ($candel_status == 'normal') {
                $demand_percentage = $HL_Percentile;
                $supply_percentage = $HL_Percentile_supply;
            } else if ($candel_status == 'Continuation_Down') {
                $demand_percentage = $Continuation_Down_Percentile;
                $supply_percentage = $Continuation_Down_Percentile_supply;
            } else if ($candel_status == 'Current_Down') {
                $demand_percentage = $Current_Down_Percentile;
                $supply_percentage = $Current_Down_Percentile_supply;
            }

            $current_lowest_point = $previous_lowest_point;
            $candel_lowest_swing_status = $previous_swing_lowest_status;

        }

        $return_arr = array();
        $return_arr['candel_status'] = $candel_status;
        $return_arr['highest_swing_point'] = $current_highest_point;
        $return_arr['lowest_swing_point'] = $current_lowest_point;
        $return_arr['candel_highest_swing_status'] = $candel_highest_swing_status;
        $return_arr['candel_lowest_swing_status'] = $candel_lowest_swing_status;
        $return_arr['demand_percentage'] = $demand_percentage;
        $return_arr['supply_percentage'] = $supply_percentage;
        $return_arr['global_swing_status'] = $global_swing_status;
        $return_arr['global_swing_parent_status'] = $global_swing_parent_status;

        return $return_arr;
    } //End of calculate_swing_poinst
   
    // we make the base candel with look back and use that for comparsion with current candels , 
    public function calculate_base_candel($coin_symbol, $demand_percentage, $supply_percentage) { 
        $total_volume = 0;
        $volume_arr = array();
        for ($index_date = 1; $index_date <= 50; $index_date++) {  // we look back 50 hours to get our base candel , which approx 2 days , 
            $from_date_for_candel = date("Y-m-d H:00:00", strtotime('-' . $index_date . ' hour'));
            $end_date_for_candel = date("Y-m-d H:59:59", strtotime('-' . $index_date . ' hour'));
            $ask_volume = $this->get_and_calculate_volume_for_candel($from_date_for_candel, $end_date_for_candel, 'ask', $coin_symbol);
            $bid_volume = $this->get_and_calculate_volume_for_candel($from_date_for_candel, $end_date_for_candel, 'bid', $coin_symbol);

            $bid_volume_arr[] = $ask_volume + $bid_volume;

            //$total_volume = $ask_volume+$bid_volume;
            $volume_arr[] = $ask_volume + $bid_volume;
        }

        sort($volume_arr);
        sort($bid_volume_arr);
        $greater_ask_volume = 0;
        $demand_percentage_index = round((count($volume_arr) / 100) * $demand_percentage);
        $demond_greater_ask_volume = $volume_arr[$demand_percentage_index];

        $supply_percentage_index = round((count($bid_volume_arr) / 100) * $supply_percentage);
        $supply_greater_ask_volume = $bid_volume_arr[$supply_percentage_index];

        $response_arr['demond_max_volume'] = $demond_greater_ask_volume;
        $response_arr['supply_max_volume'] = $supply_greater_ask_volume;
        return $response_arr;
    } //End of calculate_base_candel

    public function find_swing_heighst_points($number_of_look_back, $number_of_look_forward, $date_for_candel, $coin_symbol) {

        $limit_no = $number_of_look_back + $number_of_look_forward + 1;
        $prevouse_date = date('Y-m-d H:00:00', strtotime('-' . $number_of_look_back . ' hour', strtotime($date_for_candel)));

        $this->mongo_db->limit($limit_no);
        $this->mongo_db->order_by(array('timestampDate' => 1));
        $this->mongo_db->where_gte('timestampDate', $this->mongo_db->converToMongodttime($prevouse_date));
        $this->mongo_db->where(array('coin' => $coin_symbol));
        $market_chart_object = $this->mongo_db->get('market_chart');
        $market_chart_arr = iterator_to_array($market_chart_object);

        $current_heigh_value = '';
        $look_forward_index = -1;
        $heighs_pont_arr = array();
        $look_forward_heigh_array = array();

        if (count($market_chart_arr) > 0) {
            $index = 0;
            foreach ($market_chart_arr as $chart_data) {
                $current = 'no';
                if ($chart_data['openTime_human_readible'] == $date_for_candel) {
                    $current_heigh_value = $chart_data['high'];
                    unset($market_chart_arr[$index]);
                    $look_forward_index = $index;
                    $current = 'yes';
                } else {
                    array_push($heighs_pont_arr, $chart_data['high']);
                }

                if (($look_forward_index != -1) && ($current == 'no')) {
                    array_push($look_forward_heigh_array, $chart_data['high']);
                }

                $index++;
            }
        }

        $heighst_swing_point = max($heighs_pont_arr);
        $look_forward_heigh = max($look_forward_heigh_array);

        $response_value = '';
        if ($current_heigh_value >= $heighst_swing_point) {
            $response_value = $current_heigh_value;
        }

        return $response_value;
    } //End of find_swing_heighst_points

    public function find_swing_lowest_points($number_of_look_back, $number_of_look_forward, $date_for_candel, $coin_symbol) {

        $limit_no = $number_of_look_back + $number_of_look_forward + 1;
        $prevouse_date = date('Y-m-d H:00:00', strtotime('-' . $number_of_look_back . ' hour', strtotime($date_for_candel)));

        $this->mongo_db->limit($limit_no);
        $this->mongo_db->order_by(array('timestampDate' => 1));
        $this->mongo_db->where_gte('timestampDate', $this->mongo_db->converToMongodttime($prevouse_date));
        $this->mongo_db->where(array('coin' => $coin_symbol));
        $market_chart_object = $this->mongo_db->get('market_chart');
        $market_chart_arr = iterator_to_array($market_chart_object);

        $current_low_value = '';
        $look_forward_index = -1;
        $heighs_pont_arr = array();
        $look_forward_heigh_array = array();

        if (count($market_chart_arr) > 0) {
            $index = 0;
            foreach ($market_chart_arr as $chart_data) {
                $current = 'no';
                if ($chart_data['openTime_human_readible'] == $date_for_candel) {
                    $current_low_value = $chart_data['low'];
                    unset($market_chart_arr[$index]);
                    $look_forward_index = $index;
                    $current = 'yes';
                } else {
                    array_push($heighs_pont_arr, $chart_data['low']);
                }

                if (($look_forward_index != -1) && ($current == 'no')) {
                    array_push($look_forward_heigh_array, $chart_data['low']);
                }

                $index++;
            }
        }

        $lowest_swing_point = min($heighs_pont_arr);
        $look_forward_heigh = min($look_forward_heigh_array);
        $response_value = '';

        if ($current_low_value <= $lowest_swing_point) {

            $response_value = $current_low_value;

        }
        return $response_value;
    } //End of Find_swing_lowest_points

    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////                       /////////////////
    ////////////////////                       ////////////////////////////////
    //////////////////// Swing Point simulator ////////////////////////////////
    ////////////////////                       ////////////////////////////////
    ////////////////////                       /////////////////
    ////////////////////                       /////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////

    public function calculate_swing_poinst_simulator($coin_symbol, $current_highest_point, $current_lowest_point, $date_for_candel) {

        ///////////////////////////////////////////////////////////////////////
        ///////////////Get Task Manager Setting Details //////////////////////
        $task_manager_setting_obj = $this->mongo_db->get('task_manager_setting');
        $task_manager_setting_arr = iterator_to_array($task_manager_setting_obj);

        $number_of_look_back = 5;
        $number_of_look_forward = 3;
        $maxLvlLen = 0;
        $ShowHHLL = 0;
        $WaitForClose = 1;
        $LH_Percentile = 10;
        $LH_Percentile_supply = 10;
        $Continuation_up_Percentile = 30;
        $Continuation_up_Percentile_supply = 30;
        $Current_up_Percentile = 25;
        $Current_up_Percentile_supply = 25;
        $HL_Percentile = 10;
        $HL_Percentile_supply = 10;
        $Continuation_Down_Percentile = 20;
        $Continuation_Down_Percentile_supply = 20;
        $Current_Down_Percentile = 25;
        $Current_Down_Percentile_supply = 25;

        if (count($task_manager_setting_arr) > 0) {
            $number_of_look_back = $task_manager_setting_arr[0]['pvtLenL'];
            $number_of_look_forward = $task_manager_setting_arr[0]['pvtLenR'];

            $maxLvlLen = $task_manager_setting_arr[0]['maxLvlLen'];
            $ShowHHLL = $task_manager_setting_arr[0]['ShowHHLL'];
            $WaitForClose = $task_manager_setting_arr[0]['WaitForClose'];

            $LH_Percentile = $task_manager_setting_arr[0]['LH_Percentile'];
            $LH_Percentile_supply = $task_manager_setting_arr[0]['LH_Percentile_supply'];
            $Continuation_up_Percentile = $task_manager_setting_arr[0]['Continuation_up_Percentile'];
            $Continuation_up_Percentile_supply = $task_manager_setting_arr[0]['Continuation_up_Percentile_supply'];
            $Current_up_Percentile = $task_manager_setting_arr[0]['Current_up_Percentile'];
            $Current_up_Percentile_supply = $task_manager_setting_arr[0]['Current_up_Percentile_supply'];
            $HL_Percentile = $task_manager_setting_arr[0]['HL_Percentile'];
            $HL_Percentile_supply = $task_manager_setting_arr[0]['HL_Percentile_supply'];
            $Continuation_Down_Percentile = $task_manager_setting_arr[0]['Continuation_Down_Percentile'];
            $Continuation_Down_Percentile_supply = $task_manager_setting_arr[0]['Continuation_Down_Percentile_supply'];
            $Current_Down_Percentile = $task_manager_setting_arr[0]['Current_Down_Percentile'];
            $Current_Down_Percentile_supply = $task_manager_setting_arr[0]['Current_Down_Percentile_supply'];
        }
        ///////////////End Task Manager Setting Details //////////////////////
        /////////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////////////////////
        //////////////////Get Look Back Detail //////////////////////////

        $current_swing_heighst_point = $this->find_swing_heighst_points_simulator($number_of_look_back, $number_of_look_forward, $date_for_candel, $coin_symbol);

        $current_swing_lowest_point = $this->find_swing_lowest_points_simulator($number_of_look_back, $number_of_look_forward, $date_for_candel, $coin_symbol);

        $prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour', strtotime($date_for_candel)));

        $this->mongo_db->limit(2);
        $this->mongo_db->order_by(array('timestampDate' => -1));
        $this->mongo_db->where_lte('timestampDate', $this->mongo_db->converToMongodttime($prevouse_date));

        $this->mongo_db->where(array('coin' => $coin_symbol));
        $response_detail = $this->mongo_db->get('market_chart');
        $market_chart_arr = iterator_to_array($response_detail);

        $previous_highest_point = 0;
        $previous_lowest_point = 0;

        $previous_swing_high_status = '';
        $second_last_high_swing_status = '';

        $second_last_lowest_swing_status = '';
        $previous_swing_lowest_status = '';

        if (count($market_chart_arr) > 0) {

            $previous_highest_point = $market_chart_arr[0]['highest_swing_point'];
            $previous_lowest_point = $market_chart_arr[0]['lowest_swing_point'];
            $candel_status = $market_chart_arr[0]['candel_status'];
            $global_swing_status = $market_chart_arr[0]['global_swing_status'];

            $second_last_high_swing_status = $market_chart_arr[1]['candel_highest_swing_status'];
            $previous_swing_high_status = $market_chart_arr[0]['candel_highest_swing_status'];

            $second_last_lowest_swing_status = $market_chart_arr[1]['candel_lowest_swing_status'];
            $previous_swing_lowest_status = $market_chart_arr[0]['candel_lowest_swing_status'];

        } //End of if

        $demand_percentage = 90;
        $supply_percentage = 90;

        $candel_highest_swing_status = '';

        $global_swing_parent_status = '';
        if ($current_swing_heighst_point != '') {

            if ($current_swing_heighst_point <= $previous_highest_point) {
                $candel_status = 'normal';
                $candel_highest_swing_status = 'LH';
                $demand_percentage = $LH_Percentile;
                $supply_percentage = $LH_Percentile_supply;
                $global_swing_status = 'LH';
                $global_swing_parent_status = 'LH';

            } else {

                $candel_highest_swing_status = 'HH';
                $global_swing_parent_status = 'HH';
                $global_swing_status = 'HH';
                if ($previous_swing_high_status == 'HH' && $second_last_high_swing_status == 'HH') {

                    $demand_percentage = $Continuation_up_Percentile;
                    $supply_percentage = $Continuation_up_Percentile_supply;
                    $candel_status = 'Continuation_up';

                } else {
                    $candel_status = 'Current_up';
                    $demand_percentage = $Current_up_Percentile;
                    $supply_percentage = $Current_up_Percentile_supply;
                }
            }

        } else {

            if ($candel_status == 'normal') {
                $demand_percentage = $LH_Percentile;
                $supply_percentage = $LH_Percentile_supply;
            } else if ($candel_status == 'Continuation_up') {
                $demand_percentage = $Continuation_up_Percentile;
                $supply_percentage = $Continuation_up_Percentile_supply;
            } else if ($candel_status == 'Current_up') {
                $demand_percentage = $Current_up_Percentile;
                $supply_percentage = $Current_up_Percentile_supply;
            }

            $current_highest_point = $previous_highest_point;
            $candel_highest_swing_status = $candel_highest_swing_status;

        }

        if ($current_swing_lowest_point != '') {

            if ($current_swing_lowest_point >= $previous_lowest_point) {

                $candel_lowest_swing_status = 'HL';
                $global_swing_parent_status = 'HL';
                $global_swing_status = 'HL';
                $demand_percentage = $HL_Percentile;
                $supply_percentage = $HL_Percentile_supply;

            } else {

                $candel_lowest_swing_status = 'LL';
                $global_swing_parent_status = 'LL';
                $global_swing_status = 'LL';
                if (($previous_swing_lowest_status == 'LL') && ($second_last_lowest_swing_status == 'LL')) {

                    $demand_percentage = $Continuation_Down_Percentile;
                    $supply_percentage = $Continuation_Down_Percentile_supply;
                    $candel_status = 'Continuation_Down';
                } else {

                    $demand_percentage = $Current_Down_Percentile;
                    $supply_percentage = $Current_Down_Percentile_supply;
                    $candel_status = 'Current_Down';
                }
            }

        } else {

            if ($candel_status == 'normal') {
                $demand_percentage = $HL_Percentile;
                $supply_percentage = $HL_Percentile_supply;
            } else if ($candel_status == 'Continuation_Down') {
                $demand_percentage = $Continuation_Down_Percentile;
                $supply_percentage = $Continuation_Down_Percentile_supply;
            } else if ($candel_status == 'Current_Down') {
                $demand_percentage = $Current_Down_Percentile;
                $supply_percentage = $Current_Down_Percentile_supply;
            }

            $current_lowest_point = $previous_lowest_point;
            $candel_lowest_swing_status = $previous_swing_lowest_status;

        }

        $return_arr = array();
        $return_arr['candel_status'] = $candel_status;
        $return_arr['highest_swing_point'] = $current_highest_point;
        $return_arr['lowest_swing_point'] = $current_lowest_point;
        $return_arr['candel_highest_swing_status'] = $candel_highest_swing_status;
        $return_arr['candel_lowest_swing_status'] = $candel_lowest_swing_status;
        $return_arr['demand_percentage'] = $demand_percentage;
        $return_arr['supply_percentage'] = $supply_percentage;
        $return_arr['global_swing_status'] = $global_swing_status;
        $return_arr['global_swing_parent_status'] = $global_swing_parent_status;
        return $return_arr;
    } //End of calculate_swing_poinst

    public function calculate_candel_status_demand_supply($date, $coin) {

        $rejection_status = $this->calculate_rejection_candle($coin, $date);

        //Check if candel is previos then Execuite it
        $date_for_candel = date('Y-m-d H:00:00', strtotime($date));
        $end_date_for_candel = date('Y-m-d H:59:59', strtotime($date));

        $this->mongo_db->where(array('openTime_human_readible' => $date_for_candel, 'coin' => $coin));
        $response_detail = $this->mongo_db->get('market_chart');
        $candel_detail_arr = iterator_to_array($response_detail);
        $message_candel = '';
        if (count($candel_detail_arr) > 0) {
            foreach ($candel_detail_arr as $candel_data) {
                $candel_id = $candel_data['_id'];
                $high_value = $candel_data['high'];
                $low_value = $candel_data['low'];
                $coin_symbol = $candel_data['coin'];

                $ask_volume = $this->get_and_calculate_volume_for_candel($date_for_candel, $end_date_for_candel, 'ask', $coin_symbol);
                $bid_volume = $this->get_and_calculate_volume_for_candel($date_for_candel, $end_date_for_candel, 'bid', $coin_symbol);
                $totla_volume = $ask_volume + $bid_volume;

                $response_detail = $this->calculate_swing_poinst_simulator($coin_symbol, $high_value, $low_value, $date_for_candel);
                extract($response_detail);

                $base_candel_arr = $this->calculate_base_candel_samulater($coin_symbol, $date_for_candel, $end_date_for_candel, $demand_percentage, $supply_percentage);

                $DemandTrigger = $base_candel_arr['demond_max_volume'];
                $SupplyTrigger = $base_candel_arr['supply_max_volume'];

                $demand_base_candel = $DemandTrigger;
                $supply_base_candel = $SupplyTrigger;

                // $DemandTrigger = ($base_candel/100)*$demand_percentage;
                // $SupplyTrigger = ($base_candel/100)*$supply_percentage;

                // $DemandCandle = ($ask_volume > $bid_volume && $ask_volume >= $DemandTrigger) ? 1 : 0;
                // $SupplyCandle = ($bid_volume > $ask_volume && $bid_volume >= $SupplyTrigger) ? 1 : 0;

                $ask_plus_bid = $ask_volume + $bid_volume;
                $DemandCandle = ($ask_volume > $bid_volume && $ask_plus_bid >= $DemandTrigger) ? 1 : 0;
                $SupplyCandle = ($bid_volume > $ask_volume && $ask_plus_bid >= $SupplyTrigger) ? 1 : 0;

                $candle_type = 'normal';

                if ($DemandCandle == 1) {
                    $candle_type = 'demand';
                }
                if ($SupplyCandle == 1) {
                    $candle_type = 'supply';
                }

                //////////////////////////////////////
                /////////////////////////////////////
                $update_arr = array(
                    'candel_status' => $candel_status,
                    'candle_type' => $candle_type,
                    'ask_volume' => $ask_volume,
                    'bid_volume' => $bid_volume,
                    'total_volume' => $totla_volume,
                    'demand_base_candel' => $demand_base_candel,
                    'supply_base_candel' => $supply_base_candel,
                    //'trigger_status' => 0,
                    'triggert_type' => '',
                    'highest_swing_point' => $highest_swing_point,
                    'lowest_swing_point' => $lowest_swing_point,
                    'candel_highest_swing_status' => $candel_highest_swing_status,
                    'candel_lowest_swing_status' => $candel_lowest_swing_status,
                    'global_swing_status' => $global_swing_status,
                    //'order_mode_lock_for_update' => 0,
                    'global_swing_parent_status' => $global_swing_parent_status,
                    'rejected_candle' => $rejection_status,
                );

                $this->mongo_db->where(array('_id' => $candel_id));
                $this->mongo_db->set($update_arr);
                //Update data in mongoTable
                $this->mongo_db->update('market_chart');

                if ($global_swing_parent_status != '') {

                    $barrier_type = 'up';
                    $last_barrrier_value = (float) $high_value;

                    if ($global_swing_parent_status == 'HL' || $global_swing_parent_status == 'LL') {
                        $barrier_type = 'down';
                        $last_barrrier_value = (float) $low_value;
                    }
                    $this->save_last_barrier_value($last_barrrier_value, $coin_symbol, $global_swing_parent_status, $barrier_type, $date_for_candel);

                }

                //Update Global status for trigger_3_setting
                $this->update_trigger_3_setting_for_global_status($date, $coin, $global_swing_parent_status);

                ///////////////////////////////////////
                //////////////////////////////////////
            }
        }
        return $message_candel;
    } //calculate_candel_status_demand_supply

    public function update_trigger_3_setting_for_global_status($date, $coin, $global_swing_parent_status) {
        $box_lock_status = 0;
        $order_lock_status = 0;
        if (($global_swing_parent_status == 'LL') || ($global_swing_parent_status == 'HL')) {
            $box_lock_status = 1;
            $order_lock_status = 1;

            $this->lock_order_status();
        }
        $this->mongo_db->where(array('open_time_object' => $this->mongo_db->converToMongodttime($date), 'coin' => $coin));
        $upd_arr = array('global_swing_parent_status' => $global_swing_parent_status, 'box_lock_status' => $box_lock_status);
        $this->mongo_db->set($upd_arr);
        $this->mongo_db->update('box_trigger_3_setting');

        return true;
    } //End of update_trigger_3_setting_for_global_status

    public function lock_order_status() {

        $this->mongo_db->where_in('order_mode', array('test_live', 'live'));
        $this->mongo_db->where_ne('is_sell_order', 'sold');
        $this->mongo_db->where(array('symbol' => $coin, 'buy_order_status_new_filled' => 'wait_for_buyed', 'status' => 'new', 'trigger_type' => 'box_trigger_3'));
        $responese_obj = $this->mongo_db->get('buy_orders');
        $responese_arr = iterator_to_array($responese_obj);
        if (count($responese_arr) > 0) {
            foreach ($responese_arr as $data) {
                $order_id = $data['_id'];
                $this->mongo_db->where(array('_id' => $order_id));
                $update_arr = array('order_lock_status' => 1);
                $this->mongo_db->set($update_arr);
                $this->mongo_db->update('buy_orders');
            }
        }
    } //End of lock_order_status

    public function calculate_base_candel_samulater($coin_symbol, $date, $end_date, $demand_percentage, $supply_percentage, $totla_volume) {

        $total_volume = 0;
        $volume_arr = array();
        for ($index_date = 1; $index_date <= 50; $index_date++) {
            $from_date_for_candel = date("Y-m-d H:00:00", strtotime($date . ' -' . $index_date . ' hour'));
            $end_date_for_candel = date("Y-m-d H:59:59", strtotime($end_date . ' -' . $index_date . ' hour'));

            $ask_volume = $this->get_and_calculate_volume_for_candel($from_date_for_candel, $end_date_for_candel, 'ask', $coin_symbol);

            if ($ask_volume != 0) {
                $volume_arr[] = $ask_volume + $bid_volume;
            }

            $bid_volume = $this->get_and_calculate_volume_for_candel($from_date_for_candel, $end_date_for_candel, 'bid', $coin_symbol);
            if ($bid_volume != 0) {
                $bid_volume_arr[] = $bid_volume + $ask_volume;
            }
        }
        sort($volume_arr);
        sort($bid_volume_arr);

        // $top_percent =

        $greater_ask_volume = 0;
        $demand_percentage_index = round((count($volume_arr) / 100) * $demand_percentage);

        $demond_greater_ask_volume = $volume_arr[$demand_percentage_index];

        $supply_percentage_index = round((count($bid_volume_arr) / 100) * $supply_percentage);
        $supply_greater_ask_volume = $bid_volume_arr[$supply_percentage_index];

        $response_arr['demond_max_volume'] = $demond_greater_ask_volume;
        $response_arr['supply_max_volume'] = $supply_greater_ask_volume;

        return $response_arr;
    } //End of calculate_base_candel

    public function find_swing_heighst_points_simulator($number_of_look_back, $number_of_look_forward, $date_for_candel, $coin_symbol) {

        $limit_no = $number_of_look_back + $number_of_look_forward + 1;
        $prevouse_date = date('Y-m-d H:00:00', strtotime('-' . $number_of_look_back . ' hour', strtotime($date_for_candel)));

        $this->mongo_db->limit($limit_no);
        $this->mongo_db->order_by(array('timestampDate' => 1));
        $this->mongo_db->where_gte('timestampDate', $this->mongo_db->converToMongodttime($prevouse_date));
        $this->mongo_db->where(array('coin' => $coin_symbol));
        $market_chart_object = $this->mongo_db->get('market_chart');
        $market_chart_arr = iterator_to_array($market_chart_object);

        $current_heigh_value = '';
        $look_forward_index = -1;
        $heighs_pont_arr = array();
        $look_forward_heigh_array = array();

        if (count($market_chart_arr) > 0) {
            $index = 0;
            foreach ($market_chart_arr as $chart_data) {
                $current = 'no';
                if ($chart_data['openTime_human_readible'] == $date_for_candel) {
                    $current_heigh_value = $chart_data['high'];
                    unset($market_chart_arr[$index]);
                    $look_forward_index = $index;
                    $current = 'yes';
                } else {
                    array_push($heighs_pont_arr, $chart_data['high']);
                }

                if (($look_forward_index != -1) && ($current == 'no')) {
                    array_push($look_forward_heigh_array, $chart_data['high']);
                }

                $index++;
            }
        }

        $heighst_swing_point = max($heighs_pont_arr);
        $look_forward_heigh = max($look_forward_heigh_array);

        $response_value = '';
        if ($current_heigh_value >= $heighst_swing_point) {
            if ($look_forward_heigh < $current_heigh_value) {
                $response_value = $current_heigh_value;
            }
        }

        return $response_value;
    } //End of find_swing_heighst_points

    public function find_swing_lowest_points_simulator($number_of_look_back, $number_of_look_forward, $date_for_candel, $coin_symbol) {

        $limit_no = $number_of_look_back + $number_of_look_forward + 1;
        $prevouse_date = date('Y-m-d H:00:00', strtotime('-' . $number_of_look_back . ' hour', strtotime($date_for_candel)));

        $this->mongo_db->limit($limit_no);
        $this->mongo_db->order_by(array('timestampDate' => 1));
        $this->mongo_db->where_gte('timestampDate', $this->mongo_db->converToMongodttime($prevouse_date));
        $this->mongo_db->where(array('coin' => $coin_symbol));
        $market_chart_object = $this->mongo_db->get('market_chart');
        $market_chart_arr = iterator_to_array($market_chart_object);

        $current_low_value = '';
        $look_forward_index = -1;
        $heighs_pont_arr = array();
        $look_forward_heigh_array = array();

        if (count($market_chart_arr) > 0) {
            $index = 0;
            foreach ($market_chart_arr as $chart_data) {
                $current = 'no';
                if ($chart_data['openTime_human_readible'] == $date_for_candel) {
                    $current_low_value = $chart_data['low'];
                    unset($market_chart_arr[$index]);
                    $look_forward_index = $index;
                    $current = 'yes';
                }

                if (($look_forward_index != -1) && ($current == 'no')) {
                    array_push($look_forward_heigh_array, $chart_data['low']);
                } else {
                    if ($current == 'no') {
                        array_push($heighs_pont_arr, $chart_data['low']);
                    }
                }
                $index++;
            }
        }

        $heighst_swing_point = min($heighs_pont_arr);
        $look_forward_heigh = min($look_forward_heigh_array);

        $response_value = '';
        if ($current_low_value <= $heighst_swing_point) {
            if ($look_forward_heigh > $current_low_value) {
                $response_value = $current_low_value;
            }
        }

        return $response_value;
    } //End of Find_swing_lowest_points

    public function calculate_rejection_candle($coin, $time) {
        //date_default_timezone_set("Asia/Karachi");
        $new_time = date("Y-m-d H", strtotime($time));

        $start_date = $new_time . ":00:00";
        $end_date = $new_time . ":59:59";

        $data_array = $this->get_current_candel($start_date, $coin);

        $open = $data_array[0]['open'];
        $close = $data_array[0]['close'];
        $high = $data_array[0]['high'];
        $low = $data_array[0]['low'];
        $bid_volume = $data_array[0]['bid_volume'];
        $ask_volume = $data_array[0]['ask_volume'];
        $total_volume = $ask_volume + $bid_volume;
        $rejected = 0;
        $rejection = '';
        $last_25_per_volume = $this->calculate_base_candel_for_rejection($coin, $start_date, $end_date);

        if ($total_volume > $last_25_per_volume) {
            if ($open < $close) {
                $candle_type = 'Demand';

                //Top Demand Rejection
                $top_percentage = ((($high - $close) / ($close - $open)) * 100);
                if ($top_percentage >= 40) {
                    $rejected = 1;
                } else {
                    $rejected = 0;
                }
                //Bottom Demand Rejection
                $bottom_percentage = ((($open - $low) / ($close - $open)) * 100);
                if ($bottom_percentage >= 40) {
                    $rejected = 1;
                } else {
                    if ($rejected == 0) {
                        $rejected = 0;
                    }
                }

                if (($top_percentage > $bottom_percentage) && $rejected == 1) {
                    $rejection = 'top_demand_rejection';
                } elseif (($bottom_percentage > $top_percentage) && $rejected == 1) {
                    $rejection = "bottom_demand_rejection";
                }

            }
            if ($open > $close) {
                //Top Supply Rejection
                $top_percentage = ((($high - $open) / ($open - $close)) * 100);
                if ($top_percentage >= 40) {
                    $rejected = 1;
                } else {
                    $rejected = 0;
                }
                //Bottom Supply Rejection
                $bottom_percentage = ((($close - $low) / ($open - $close)) * 100);
                if ($bottom_percentage >= 40) {
                    $rejected = 1;
                } else {
                    if ($rejected == 0) {
                        $rejected = 0;
                    }
                }

                if (($top_percentage > $bottom_percentage) && $rejected == 1) {
                    $rejection = 'top_supply_rejection';
                } elseif (($bottom_percentage > $top_percentage) && $rejected == 1) {
                    $rejection = "bottom_supply_rejection";
                }
            }
            if ($open == $close) {
                $candle_type = 'Normal';
            }
        }

        return $rejection;
    }

    public function get_current_candel($curretn_date, $coin_symbol) {
        $this->mongo_db->where(array('openTime_human_readible' => $curretn_date, 'coin' => $coin_symbol));
        $previouse_candel_result = $this->mongo_db->get('market_chart');
        return $previouse_candel_arr = iterator_to_array($previouse_candel_result);
    } //End of get_current_candel

    public function calculate_base_candel_for_rejection($coin_symbol, $start_date, $end_date) {
        $total_volume = 0;
        $volume_arr = array();
        for ($index_date = 1; $index_date <= 50; $index_date++) {
            $from_date_for_candel = date("Y-m-d H:00:00", strtotime('-' . $index_date . ' hour', strtotime($start_date)));
            $end_date_for_candel = date("Y-m-d H:59:59", strtotime('-' . $index_date . ' hour', strtotime($start_date)));
            $reject_per = $this->get_coin_rejection_value($coin_symbol);
            $ask_volume = $this->get_and_calculate_volume_for_candel_for_rejection($from_date_for_candel, $end_date_for_candel, $coin_symbol);
            $volume_arr[] = $ask_volume;
        }

        sort($volume_arr);
        $greater_ask_volume = 0;
        $demand_percentage_index = round((count($volume_arr) / 100) * $reject_per);

        $demond_greater_ask_volume = $volume_arr[$demand_percentage_index];
        return $demond_greater_ask_volume;
    } //End of calculate_base_candel

    public function get_and_calculate_volume_for_candel_for_rejection($from_date, $end_date, $coin_type) {
        $connect = $this->mongo_db->customQuery();
        $res = $connect->market_trade_hourly_history->find(array(
            'coin' => $coin_type,
            'hour' => array('$gte' => $from_date, '$lte' => $end_date),
        ));
        $volume = 0;
        $res = iterator_to_array($res);
        foreach ($res as $key) {
            $volume += (float) $key['volume'];
        }
        return $volume;
    } //End of  get_and_calculate_volume_for_candel

    public function get_coin_rejection_value($symbol) {
        $this->mongo_db->where(array('symbol' => $symbol));
        $get_coin = $this->mongo_db->get('coins');
        $coin_arr = iterator_to_array($get_coin);
        $coin_arr = $coin_arr[0];
        return $coin_arr['rejection'];
    } //end get_coin_rejection_value()

    public function save_last_barrier_value($last_barrrier_value, $coin_symbol, $global_swing_parent_status, $barrier_type, $date_for_candel) {

        $created_date = date('Y-m-d H:00:00', strtotime($date_for_candel));

        $barrier_creation_date = date('Y-m-d g:i:s');
        $barrier_creation_date = $this->mongo_db->converToMongodttime($barrier_creation_date);

        $insert_arr = array('barier_value' => (float) $last_barrrier_value, 'coin' => $coin_symbol, 'human_readible_created_date' => $created_date, 'created_date' => $this->mongo_db->converToMongodttime($created_date), 'barrier_type' => $barrier_type, 'global_swing_parent_status' => $global_swing_parent_status, 'status' => 0, 'barrier_status' => 'very_strong_barrier', 'original_barrier_status'=>'very_strong_barrier','barrier_creation_date' => $barrier_creation_date);

        $this->mongo_db->insert('barrier_values_collection', $insert_arr);

    } //End of

    public function calculate_market_move($coin_symbol){
        //%%%%%%%%%%%%%%%%%%% --Coin List --%%%%%%%%%%%%%%%%%%%%%
     
        $limit =51;

               $data_arr = $this->triggers_trades->list_candles($coin_symbol,$limit);
               $created_date = date('Y-m-d H:i:s'); 
               $demand = 0;
               $supply = 0;
               $index = 1;
               $count = count($data_arr);
               $high_current = 0;
               $low_current = 0;
               $high_previous = 0;
               $low_previous = 0;
               $per_move_current = 0;
               $per_move_previous = 0;
               $current_five_time_volume = 0;
               $previous_vol = 0;
               if(!empty($data_arr)){
                   $high_current = $data_arr[0]['high'];
                   $low_current = $data_arr[0]['low'];
                   $current_five_time_volume = ($data_arr[0]['total_volume'])*5;
                   $high_previous = $data_arr[1]['high'];
                   $low_previous = $data_arr[1]['low'];
                   foreach ($data_arr as $row) {
                       if($index <=4){$previous_vol += $row[$inex]['total_volume'];}
                       $close = $row['close'];
                       $open  = $row['open'];
                       //%%%%%%%%%%%%%% open 
                       if($open == $close){
                           if($index <= $count){
                               if($data_arr[$index]['close'] > $open){
                                   $supply ++;
                               }else{
                                   $demand ++;
                               }
                           }//End of array iteration is not empty
                       }else{//if open is  equl to close
                           if($close > $open){
                               $demand ++;
                           }else{
                               $supply ++;
                           }
                       }//%%%%%%% -- End of open and close not equal
                       $index ++;
                   }//End of foreach
                   $per_move_current = (($high_current - $low_current)/$low_current)*100;
                   $per_move_previous = (($high_previous - $low_previous)/$low_previous)*100;
               }//End of Data Array is empty
       
               $per_move_var = $per_move_previous - $per_move_current;
               $move = ($per_move_var >= 0 )?($demand/$supply):($supply/$demand);
               $vol_move = ($current_five_time_volume > $previous_vol)?'POSSITIVE':'NEGATIVE';
       
               $insert_arr['per_move'] = (float)$per_move_current;
               $insert_arr['move'] = (float)($move);
               $insert_arr['vol_move'] = $vol_move;
               return  $insert_arr;
   }//End of calculate_market_move

} //End of Mod_realtime_candle_socket
