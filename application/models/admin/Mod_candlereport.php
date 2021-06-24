<?php
class mod_candlereport extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    //======================================================================
    // Get Coin Offest Value
    //======================================================================
    public function get_coin_offset_value($symbol)
    {
        $this->mongo_db->where(array(
            'symbol' => $symbol,
            'user_id' => 'global'
        ));
        $get_coin = $this->mongo_db->get('coins');
        $coin_arr = iterator_to_array($get_coin);
        $data     = $coin_arr[0];
        return $data['offset_value'];
    } //end get_coin_offset_value()
    //======================================================================
    // Get Candle stick Data from database 
    //======================================================================
    public function get_candelstick_data_from_database($global_symbol, $periods, $from_date_object, $to_date_object, $previous_date, $forward_date)
    {
        $this->mongo_db->where(array(
            'coin' => $global_symbol,
            'periods' => $periods
        ));
        if ($from_date_object && $to_date_object) {
            $this->mongo_db->where_gte('timestampDate', $from_date_object);
            $this->mongo_db->where_lte('timestampDate', $to_date_object);
        }
        if ($previous_date != '') {
            $previous_date            = $previous_date / 1000;
            $previous_date            = date("Y-m-d H:i:s", $previous_date);
            $previous_date_date_mongo = $this->mongo_db->converToMongodttime($previous_date);
            $this->mongo_db->where_lte('timestampDate', $previous_date_date_mongo);
        }
        if ($forward_date != '') {
            $forward_date            = $forward_date / 1000;
            $forward_date            = date("Y-m-d H:i:s", $forward_date);
            $forward_date_date_mongo = $this->mongo_db->converToMongodttime($forward_date);
            $this->mongo_db->where_gt('timestampDate', $forward_date_date_mongo);
            $this->mongo_db->sort(array(
                'timestampDate' => 'ASC'
            )); //ASC/DESC
        } else {
            $this->mongo_db->sort(array(
                'timestampDate' => 'DESC'
            )); //ASC/DESC
        }
        $this->mongo_db->limit(500);
        $responseArr          = $this->mongo_db->get('market_chart');
        $final_arr            = array();
        $total_volume_arr     = array();
        $total_volume_arr_bvs = array();
        foreach ($responseArr as $val_arr) {
            array_push($total_volume_arr, $val_arr['total_volume']);
            array_push($total_volume_arr_bvs, $val_arr['total_volume_bvs']);
            $final_arr[] = array(
                '_id' => $myText = (string) $val_arr['_id'],
                'timestampDate' => $val_arr['timestampDate'],
                'close' => num($val_arr['close']),
                'open' => num($val_arr['open']),
                'high' => num($val_arr['high']),
                'low' => num($val_arr['low']),
                'volume' => $val_arr['volume'],
                'openTime' => $val_arr['openTime'],
                'closeTime' => $val_arr['closeTime'],
                'coin' => $val_arr['coin'],
                'candel_status' => $val_arr['candel_status'],
                'candle_type' => $val_arr['candle_type'],
                'openTime_human_readible' => $val_arr['openTime_human_readible'],
                'closeTime_human_readible' => $val_arr['closeTime_human_readible'],
                'demand_base_candel' => $val_arr['demand_base_candel'],
                'supply_base_candel' => $val_arr['supply_base_candel'],
                'global_swing_status' => $val_arr['global_swing_status'],
                'global_swing_parent_status' => $val_arr['global_swing_parent_status'],
                'rejected_candle' => $val_arr['rejected_candle'],
                'ask_volume' => $val_arr['ask_volume'],
                'bid_volume' => $val_arr['bid_volume'],
                'total_volume' => $val_arr['total_volume'],
                'buy_volume' => $val_arr['buy_volume'],
                'sell_volume' => $val_arr['sell_volume'],
                'move' => $val_arr['move'],
                'black_ask_diff' => $val_arr['black_ask_diff'],
                'black_bid_diff' => $val_arr['black_bid_diff'],
                'yellow_ask_diff' => $val_arr['yellow_ask_diff'],
                'yellow_bid_diff' => $val_arr['yellow_bid_diff']
            );
        }
        if ($forward_date == '') {
            $final_arr = array_reverse($final_arr);
        }
        $data['candle_arr']     = $final_arr;
        $max_volume             = max($total_volume_arr);
        $data['max_volume']     = $max_volume;
        $max_volume_bvs         = max($total_volume_arr_bvs);
        $data['max_volume_bvs'] = $max_volume_bvs;
        return $data;
    }
    /** End of get_candelstick_data_from_database **/
    //======================================================================
    // Get Orderss Array
    //======================================================================
    public function get_order_array($symbol, $admin_id, $global_mode, $start_date_for_time_zone_time, $end_date_for_time_zone_time)
    {
        $search_Array = array(
            'symbol' => $symbol,
            'is_sell_order' => 'sold',
            'admin_id' => $admin_id,
            'application_mode' => $global_mode,
            'created_date' => array(
                '$gte' => $start_date_for_time_zone_time,
                '$lte' => $end_date_for_time_zone_time
            )
        );
        $this->mongo_db->where($search_Array);
        $res            = $this->mongo_db->get('buy_orders');
        $final_arr      = array();
        $buy_orders_arr = iterator_to_array($res);
        foreach ($buy_orders_arr as $key => $arr) {
            $buy_order_id = $arr['_id'];
            $buy_date     = $arr['created_date'];
            if ($arr['buy_date']) {
                $buy_date = $arr['buy_date'];
            }
            $datetime          = $buy_date->toDateTime();
            $created_date      = $datetime->format(DATE_RSS);
            $market_sold_price = $arr['market_sold_price'];
            $datetime          = new DateTime($created_date);
            $datetime->format('Y-m-d H:00:00');
            $formated_date_time     = $datetime->format('Y-m-d H:00:00');
            $buy_order_date         = $formated_date_time;
            $search['buy_order_id'] = $buy_order_id;
            $this->mongo_db->where($search);
            $res_sold       = $this->mongo_db->get('orders');
            $sold_order_arr = iterator_to_array($res_sold);
            foreach ($sold_order_arr as $key => $value) {
                $buy_order_price  = $value['purchased_price'];
                $sell_order_price = $value['sell_price'];
                $sell_date        = $value['created_date'];
                if ($value['sell_date']) {
                    $sell_date = $value['sell_date'];
                }
                $datetime     = $sell_date->toDateTime();
                $created_date = $datetime->format(DATE_RSS);
                $datetime     = new DateTime($created_date);
                $datetime->format('Y-m-d H:00:00');
                $formated_date_time = $datetime->format('Y-m-d H:00:00');
                $sell_date          = $formated_date_time;
                $final_arr[]        = array(
                    'buy_date' => $buy_order_date,
                    'sell_date' => $sell_date,
                    'buy_price' => $buy_order_price,
                    'sell_price' => $market_sold_price
                );
            }
        }
        return $final_arr;
    } //end get_order_array
    //======================================================================
    // Get Task Manger Settings
    //======================================================================
    public function get_task_manager_setting($global_symbol)
    {
        $this->mongo_db->where(array(
            'coin' => $global_symbol
        ));
        $res = $this->mongo_db->get('task_manager_setting');
        return iterator_to_array($res);
    } //End of get_task_manager_setting
    //======================================================================
    // Get Coin unit Value
    //======================================================================
    public function get_coin_unit_value($symbol)
    {
        $this->mongo_db->where(array(
            'symbol' => $symbol
        ));
        $get_coin = $this->mongo_db->get('coins');
        $coin_arr = iterator_to_array($get_coin);
        $coin_arr = $coin_arr[0];
        return $coin_arr['unit_value'];
    } //end get_coin_unit_value()
    //======================================================================
    // Get Coin unit Value
    //======================================================================
    public function get_chart_target_zones($global_symbol)
    {
        $admin_id = $this->session->userdata('admin_id');
        $this->mongo_db->where(array(
            'coin' => $global_symbol
        ));
        $this->mongo_db->limit(5);
        $this->mongo_db->sort(array(
            '_id' => 'desc'
        ));
        $responseArr = $this->mongo_db->get('chart_target_zones');
        $fullarray   = array();
        foreach ($responseArr as $valueArr) {
            $start_date = $valueArr['start_date'];
            $end_date   = $valueArr['end_date'];
            if (!empty($valueArr)) {
                $returArr['start_value'] = (string) ($valueArr['start_value']);
                $returArr['end_value']   = (string) ($valueArr['end_value']);
                $returArr['unit_value']  = (string) ($valueArr['unit_value']);
                $returArr['start_date']  = (string) json_decode($start_date);
                $returArr['end_date']    = (string) json_decode($end_date);
                $returArr['type']        = $valueArr['type'];
            }
            $fullarray[] = $returArr;
        }
        return $fullarray;
    } //end get_chart_target_zones
    //======================================================================
    // Get  get_candle_price_volume_detail
    //======================================================================
    public function get_candle_price_volume_detail($symbol, $start_date, $end_date, $unit_value)
    {
        $bid_arr_volume   = $this->get_bid_price_volume($symbol, $start_date, $end_date);
        $ask_arr_volume   = $this->get_ask_price_volume($symbol, $start_date, $end_date);
        $total_volume_arr = array();
        $total_volume     = 0;
        if (count($ask_arr_volume) > 0) {
            foreach ($ask_arr_volume as $price => $valume) {
                $total_volume_arr[$price] = $bid_arr_volume[$price] + $valume;
            }
        }
        foreach ($bid_arr_volume as $bid_price => $bid_volume) {
            if (!array_key_exists($bid_price, $total_volume_arr)) {
                $total_volume_arr[$bid_price] = $bid_volume;
            }
        }
        $max_volume                     = max($total_volume_arr);
        $retur_data['bid_arr_volume']   = $bid_arr_volume;
        $retur_data['ask_arr_volume']   = $ask_arr_volume;
        $retur_data['total_volume_arr'] = $total_volume_arr;
        $retur_data['max_volume']       = $max_volume;
        $retur_data['unit_value']       = $unit_value;
        return $retur_data;
    }
    /** End of get_candle_price_volume_detail **/
    //======================================================================
    // Get  get_candle_price_volume_detail
    //======================================================================
    public function get_ask_price_volume($symbol, $start_date, $end_date)
    {
        $connect = $this->mongo_db->customQuery();
        $this->mongo_db->where('type', 'ask');
        $this->mongo_db->where('coin', $symbol);
        $this->mongo_db->where_gte('hour', $start_date);
        $this->mongo_db->where_lte('hour', $end_date);
        $this->mongo_db->sort(array(
            'hour' => 'desc'
        ));
        $responseArr          = $this->mongo_db->get('market_trade_hourly_history');
        $responseArr          = iterator_to_array($responseArr);
        $ask_price_volume_arr = array();
        $full_arr             = array();
        if (count($responseArr) > 0) {
            foreach ($responseArr as $value) {
                $ask_price_volume_arr[number_format($value['price'], 8)] = $value['volume'];
            }
        }
        ksort($ask_price_volume_arr);
        return $ask_price_volume_arr;
    }
    /** End of get_bid_price_volume**/
    //======================================================================
    // Get  get_candle_price_volume_detail
    //======================================================================
    public function get_bid_price_volume($symbol, $start_date, $end_date)
    {
        $connect = $this->mongo_db->customQuery();
        $this->mongo_db->where_gte('hour', $start_date);
        $this->mongo_db->where_lte('hour', $end_date);
        $this->mongo_db->where('type', 'bid');
        $this->mongo_db->where('coin', $symbol);
        $this->mongo_db->sort(array(
            'hour' => 'desc'
        ));
        $responseArr          = $this->mongo_db->get('market_trade_hourly_history');
        $responseArr          = iterator_to_array($responseArr);
        $bid_price_volume_arr = array();
        if (count($responseArr) > 0) {
            foreach ($responseArr as $value) {
                $bid_price_volume_arr[number_format($value['price'], 8)] = $value['volume'];
            }
        }
        ksort($bid_price_volume_arr);
        return $bid_price_volume_arr;
    }
    /** End of get_bid_price_volume**/
    //======================================================================
    // Get  get_candle_price_volume_detail
    //======================================================================
    public function is_box_trigger_trade_buyed($start_date, $end_date, $symbol)
    {
        $start_date            = $this->mongo_db->converToMongodttime($start_date);
        $end_date              = $this->mongo_db->converToMongodttime($end_date);
        $where['trigger_type'] = 'box_trigger_3';
        $where['buy_date']     = array(
            '$gte' => $start_date,
            '$lte' => $end_date
        );
        $where['symbol']       = $symbol;
        $this->mongo_db->where($where);
        $this->mongo_db->limit(1);
        $data             = $this->mongo_db->get('buy_orders');
        $data             = iterator_to_array($data);
        $resp['is_exist'] = 'no';
        $resp['price']    = '';
        if (!empty($data)) {
            $resp['is_exist'] = 'yes';
            $resp['price']    = num($data[0]['price']);
        } else {
            $this->mongo_db->where($where);
            $this->mongo_db->limit(1);
            $data = $this->mongo_db->get('sold_buy_orders');
            $data = iterator_to_array($data);
            if (!empty($data)) {
                $resp['is_exist'] = 'yes';
                $resp['price']    = num($data[0]['price']);
            }
        }
        return $resp;
    } //End of is_box_trigger_trade_buyed
    //======================================================================
    // Get  get_candle_price_volume_detail
    //======================================================================
    public function convert_time_zone($mil)
    {
        $seconds  = $mil / 1000;
        $datetime = date("Y-m-d g:i:s A", $seconds);
        $timezone = $this->session->userdata('timezone');
        $date     = date_create($datetime);
        date_timezone_set($date, timezone_open($timezone));
        return date_format($date, 'Y-m-d g:i:s A');
    } //End of convert_time_zone
    //======================================================================
    // Get  get_candle_price_volume_detail
    //======================================================================
    public function calculate_pressure_up_and_down($start_date, $end_date, $coin, $pressure_type)
    {
        $this->mongo_db->where_gte('created_date', $this->mongo_db->converToMongodttime($start_date));
        $this->mongo_db->where_lt('created_date', $this->mongo_db->converToMongodttime($end_date));
        $this->mongo_db->where(array(
            'coin' => $coin,
            'pressure' => $pressure_type
        ));
        $res     = $this->mongo_db->get('order_book_pressure');
        $res_arr = iterator_to_array($res);
        return $total_pressure = count($res_arr);
    } //End of calculate_pressure_up_and_down
    //======================================================================
    // Get  get_candle_price_volume_detail
    //======================================================================
    public function calculate_average_score($symbol, $start_d, $end_d)
    {
        $start_date = $this->mongo_db->converToMongodttime($start_d);
        $end_date   = $this->mongo_db->converToMongodttime($end_d);
        $this->mongo_db->where(array(
            'coin' => $symbol,
            'modified_date' => array(
                '$lte' => $end_date,
                '$gte' => $start_date
            )
        ));
        $this->mongo_db->order_by(array(
            'modified_date' => -1
        ));
        $get_arr222 = $this->mongo_db->get('coin_meta_history');
        $score_Arr  = iterator_to_array($get_arr222);
        foreach ($score_Arr as $key => $value) {
            $score[] = $value['score'];
        }
        if (count($score) > 0) {
            $avg_score = array_sum($score) / count($score);
        } else {
            $avg_score = 0;
        }
        return $avg_score;
    }//calculate_average_score
}
?>
