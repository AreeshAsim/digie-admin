<?php
class mod_reports_rules extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    //======================================================================
    // Check Which coin need to run in Cron job  getRuningCoinName
    //======================================================================
    public function getRuningCoinName()
    {
        $hour = date('H');
        switch ($hour) {
            case $hour == '01':
                $coinName = 'NCASHBTC';
                return $coinName;
                break;
            case $hour == '02':
                $coinName = 'TRXBTC';
                return $coinName;
                break;
            case $hour == '03':
                $coinName = 'EOSBTC';
                return $coinName;
                break;
            case $hour == '04':
                $coinName = 'POEBTC';
                return $coinName;
                break;
            case $hour == '05':
                $coinName = 'NEOBTC';
                return $coinName;
                break;
            case $hour == '06':
                $coinName = 'ETCBTC';
                return $coinName;
                break;
            case $hour == '07':
                $coinName = 'XRPBTC';
                return $coinName;
                break;
            case $hour == '08':
                $coinName = 'XEMBTC';
                return $coinName;
                break;
            case $hour == '09':
                $coinName = 'XLMBTC';
                return $coinName;
                break;
            case $hour == '10':
                $coinName = 'TRXBTC';
                return $coinName;
                break;
            case $hour == '11':
                $coinName = 'ZENBTC';
                return $coinName;
                break;
            case $hour == '12':
                $coinName = 'TRXBTC';
                return $coinName;
                break;
            case $hour == '13':
                $coinName = 'EOSBTC';
                return $coinName;
                break;
            case $hour == '14':
                $coinName = 'POEBTC';
                return $coinName;
                break;
			case $hour == '15':
                $coinName = 'NEOBTC';
                return $coinName;
                break;
		     case $hour == '16':
                $coinName = 'POEBTC';
                return $coinName;
                break;
			 case $hour == '17':
                $coinName = 'ETCBTC';
                return $coinName;
                break;
			 case $hour == '18':
                $coinName = 'POEBTC';
                return $coinName;
                break;
			 case $hour == '19':
                $coinName = 'XRPBTC';
                return $coinName;
                break;
			 case $hour == '20':
                $coinName = 'POEBTC';
                return $coinName;
                break;			
			case $hour == '21':
                $coinName = 'XEMBTC';
                return $coinName;
                break;				
			case $hour == '22':
                $coinName = 'XLMBTC';
                return $coinName;
                break;				
			case $hour == '23':
                $coinName = 'POEBTC';
                return $coinName;
                break;		
			case $hour == '00':
                $coinName = 'TRXBTC';
                return $coinName;
                break;										
            default:
                $coinName = 'NEOBTC';
                return $coinName;
                break;
                return $coinName;
        }
    } // getRuningCoinName
    //======================================================================
    // Get all Rules settings against coin is_triggers_qualify_to_buy_orders
    //======================================================================
    public function list_barrier_status_simulator($coin_symbol, $barrier_status, $market_price, $type, $simulator_date)
    {
        $this->mongo_db->limit(1);
        $where = array();
        if ($type == 'down') {
            $where['barier_value'] = array(
                '$lte' => (float) $market_price
            );
        }
        $simulator_date                   = $this->mongo_db->converToMongodttime($simulator_date);
        $where['created_date']            = array(
            '$lte' => $simulator_date
        );
        $where['coin']                    = $coin_symbol;
        $where['original_barrier_status'] = $barrier_status;
        $where['barrier_type']            = $type;
        $this->mongo_db->order_by(array(
            'created_date' => -1
        ));
        $this->mongo_db->where($where);
        $res_obj      = $this->mongo_db->get('barrier_values_collection');
        $res_arr      = iterator_to_array($res_obj);
        $barier_value = '';
        $data         = array();
        if (count($res_arr) > 0) {
            $row                                 = $res_arr[0];
            $barier_value                        = $row['barier_value'];
            $data['barrier_status']              = $row['original_barrier_status'];
            $data['barier_value']                = $row['barier_value'];
            $data['human_readible_created_date'] = $row['human_readible_created_date'];
        } //End of Count
        return $barier_value;
    } //End of barrier_status
    //======================================================================
    // Get all Rules settings against coin last_procedding_candle_status_history
    //======================================================================
    public function last_procedding_candle_status_history($coin, $simulator_date)
    {
        $this->mongo_db->limit(1);
        $this->mongo_db->order_by(array(
            'timestampDate' => -1
        ));
        $simulator_date         = $this->mongo_db->converToMongodttime($simulator_date);
        $where['timestampDate'] = array(
            '$lte' => $simulator_date
        );
        $where['coin']          = $coin;
        $this->mongo_db->where_in('candle_type', array(
            'demand',
            'supply'
        ));
        $this->mongo_db->where($where);
        $response    = $this->mongo_db->get('market_chart');
        $response    = iterator_to_array($response);
        $candle_type = '';
        if (!empty($response)) {
            $candle_type = $response[0]['candle_type'];
        }
        return $candle_type;
    } //%%%%%%%%%%%%%   End of last_procedding_candle_status_history %%%%%%%%%%%%%5
    //======================================================================
    // Get all Rules settings against coin is_triggers_qualify_to_buy_orders
    //======================================================================
    public function is_triggers_qualify_to_buy_orders_new($coin_symbol, $order_level, $global_setting_arr, $current_market_price, $coin_meta_arr, $coin_meta_hourly_arr, $simulator_date)
    {
		
		
		
        $log_arr                       = array();
        $barrier_range_percentage      = $global_setting_arr['barrier_percentile_trigger_barrier_range_percentage'];
        $five_minute_rolling_candel    = $coin_meta_arr['sellers_buyers_per'];
        $fifteen_minute_rolling_candel = $coin_meta_arr['sellers_buyers_per_fifteen'];
        $buyers_fifteen                = $coin_meta_arr['buyers_fifteen'];
        $sellers_fifteen               = $coin_meta_arr['sellers_fifteen'];
        $black_wall_pressure           = $coin_meta_arr['black_wall_pressure'];
        $seven_level_depth             = $coin_meta_arr['seven_level_depth'];
        $last_200_buy_vs_sell          = $coin_meta_arr['last_200_buy_vs_sell'];
        $last_200_time_ago             = (float) $coin_meta_arr['last_200_time_ago'];
        $last_qty_buy_vs_sell          = $coin_meta_arr['last_qty_buy_vs_sell'];
        $last_qty_time_ago             = (float) $coin_meta_arr['last_qty_time_ago'];
        $enable_buy_barrier_percentile = $global_setting_arr['enable_buy_barrier_percentile'];
        //%%%%%%%%%%% -- Check if rule is Enable -- %%%%%%%%%%%%%%%%%
        if ($enable_buy_barrier_percentile == 'not' || $enable_buy_barrier_percentile == '') {
            $log_arr['Percentile_Level_' . $order_level . '_status'] = '<span style="color:red">OFF</span>';
            return $log_arr;
        } //%%%%%%%%%%%% -- End of rule is Enable -- %%%%%%%%%%%%%%%%%%
        $log_arr['-']                                = '<span style="color: green;font-size: 27px;">Buy Rules</span><br>';
        $log_arr['Order_Is_Buyed_By_Level']          = $order_level . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%% Buyers  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $barrier_percentile_trigger_buyers_buy       = $global_setting_arr['barrier_percentile_trigger_buyers_buy'];
        $barrier_percentile_trigger_buyers_buy_apply = $global_setting_arr['barrier_percentile_trigger_buyers_buy_apply'];
        $buyers_recommended_percentile_value         = $coin_meta_hourly_arr['buyers_fifteen_' . $barrier_percentile_trigger_buyers_buy];
        $buyers_yes_no                               = true;
        $rule_on_off                                 = '<span style="background-color:yellow">OFF</span>';
        if ($barrier_percentile_trigger_buyers_buy_apply == 'yes') {
            if ($buyers_fifteen >= $buyers_recommended_percentile_value) {
                $buyers_yes_no = true;
                $rule_on_off   = '<span style="color:green">YES</span>';
            } else {
                $buyers_yes_no = false;
                $rule_on_off   = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['Buyers_status']                       = $rule_on_off;
        $log_arr['Buyers_recommended_percentile']       = $barrier_percentile_trigger_buyers_buy;
        $log_arr['Buyers_recommended_percentile_value'] = $buyers_recommended_percentile_value;
        $log_arr['Buyer_current_value']                 = $buyers_fifteen . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $seller_percentile                              = $global_setting_arr['barrier_percentile_trigger_sellers_buy'];
        $barrier_percentile_trigger_sellers_buy_apply   = $global_setting_arr['barrier_percentile_trigger_sellers_buy_apply'];
        $sellers_recommended_percentile_value           = $coin_meta_hourly_arr['sellers_fifteen_b_' . $seller_percentile];
        $sellers_yes_no                                 = true;
        $rule_on_off                                    = '<span style="background-color:yellow">OFF</span>';
        if ($barrier_percentile_trigger_sellers_buy_apply == 'yes') {
            if ($sellers_fifteen <= $sellers_recommended_percentile_value) {
                $sellers_yes_no = true;
                $rule_on_off    = '<span style="color:green">YES</span>';
            } else {
                $sellers_yes_no = false;
                $rule_on_off    = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['Sellers_status']                       = $rule_on_off;
        $log_arr['Sellers_recommended_percentile']       = $seller_percentile;
        $log_arr['Sellers_recommended_percentile_value'] = $sellers_recommended_percentile_value;
        $log_arr['Sellers_current_value']                = $sellers_fifteen . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%% -- Barrier Status --%%%%%%%%%%%%%%%%%%%%%%%
        $last_barrrier_value                             = $this->mod_reports_rules->list_barrier_status_simulator($coin_symbol, 'very_strong_barrier', $current_market_price, 'down', $simulator_date);
        $barrier_value_range_upside                      = $last_barrrier_value + ($last_barrrier_value / 100) * $barrier_range_percentage;
        $barrier_value_range_down_side                   = $last_barrrier_value - ($last_barrrier_value / 100) * $barrier_range_percentage;
        $meet_condition_for_buy                          = false;
        if ($barrier_range_percentage == '') {
            $rule_on_off            = '<span style="color:black">OFF</span>';
            $meet_condition_for_buy = true;
        } else {
            $rule_on_off = '<span style="color:red">NO</span>';
            if ((num($current_market_price) >= num($barrier_value_range_down_side)) && (num($current_market_price) <= num($barrier_value_range_upside))) {
                $meet_condition_for_buy = true;
                $rule_on_off            = '<span style="color:green">YES</span>';
            }
        }
        $log_arr['is_Barrier_Meet']                               = $rule_on_off;
        $log_arr['Last_Barrier_price']                            = num($last_barrrier_value);
        $log_arr['Barrier_Range_percentage']                      = $barrier_range_percentage;
        $log_arr['Barrier_Range']                                 = 'Barrir From <b>(' . num($barrier_value_range_down_side) . ')</b> To  <b>(' . num($barrier_value_range_upside) . ')</b><br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $percentile_trigger_15_minute_rolling_candel              = $global_setting_arr['barrier_percentile_trigger_15_minute_rolling_candel'];
        $percentile_trigger_15_minute_rolling_candel_apply        = $global_setting_arr['barrier_percentile_trigger_15_minute_rolling_candel_apply'];
        $percentile_trigger_15_minute_rolling_candel_actual_value = $coin_meta_hourly_arr['fifteen_min_' . $percentile_trigger_15_minute_rolling_candel];
        $fifteen_minute_rolling_candel_yes_no                     = true;
        $rule_on_off                                              = '<span style="background-color:yellow">OFF</span>';
        if ($percentile_trigger_15_minute_rolling_candel_apply == 'yes') {
            if ($percentile_trigger_15_minute_rolling_candel_actual_value <= $fifteen_minute_rolling_candel) {
                $fifteen_minute_rolling_candel_yes_no = true;
                $rule_on_off                          = '<span style="color:green">YES</span>';
            } else {
                $fifteen_minute_rolling_candel_yes_no = false;
                $rule_on_off                          = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['15_minute_rolling_candel_status']                       = $rule_on_off;
        $log_arr['15_minute_rolling_candel_recommended_percentile']       = $percentile_trigger_15_minute_rolling_candel;
        $log_arr['15_minute_rolling_candel_recommended_percentile_value'] = $percentile_trigger_15_minute_rolling_candel_actual_value;
        $log_arr['15_minute_rolling_candel_current_value']                = $fifteen_minute_rolling_candel . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $percentile_trigger_5_minute_rolling_candel                       = $global_setting_arr['barrier_percentile_trigger_5_minute_rolling_candel'];
        $percentile_trigger_5_minute_rolling_candel_apply                 = $global_setting_arr['barrier_percentile_trigger_5_minute_rolling_candel_apply'];
        $percentile_trigger_5_minute_rolling_candel_actual_value          = $coin_meta_hourly_arr['five_min_' . $percentile_trigger_5_minute_rolling_candel];
        $five_minute_rolling_candel_yes_no                                = true;
        $rule_on_off                                                      = '<span style="background-color:yellow">OFF</span>';
        if ($percentile_trigger_5_minute_rolling_candel_apply == 'yes') {
            if ($percentile_trigger_5_minute_rolling_candel_actual_value <= $five_minute_rolling_candel) {
                $five_minute_rolling_candel_yes_no = true;
                $rule_on_off                       = '<span style="color:green">YES</span>';
            } else {
                $five_minute_rolling_candel_yes_no = false;
                $rule_on_off                       = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['5_minute_rolling_candel_status']                       = $rule_on_off;
        $log_arr['5_minute_rolling_candel_recommended_percentile']       = $percentile_trigger_5_minute_rolling_candel;
        $log_arr['5_minute_rolling_candel_recommended_percentile_value'] = $percentile_trigger_5_minute_rolling_candel_actual_value;
        $log_arr['5_minute_rolling_candel_current_value']                = $five_minute_rolling_candel . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $percentile_trigger_black_wall                                   = $global_setting_arr['barrier_percentile_trigger_buy_black_wall'];
        $percentile_trigger_black_wall_apply                             = $global_setting_arr['barrier_percentile_trigger_buy_black_wall_apply'];
        $percentile_trigger_black_wall_actual_value                      = $coin_meta_hourly_arr['blackwall_' . $percentile_trigger_black_wall];
        $black_wall_yes_no                                               = true;
        $rule_on_off                                                     = '<span style="background-color:yellow">OFF</span>';
        if ($percentile_trigger_black_wall_apply == 'yes') {
            if ($percentile_trigger_black_wall_actual_value <= $black_wall_pressure) {
                $black_wall_yes_no = true;
                $rule_on_off       = '<span style="color:green">YES</span>';
            } else {
                $black_wall_yes_no = false;
                $rule_on_off       = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['black_wall_status']                       = $rule_on_off;
        $log_arr['black_wall_recommended_percentile']       = $percentile_trigger_black_wall;
        $log_arr['black_wall_recommended_percentile_value'] = $percentile_trigger_black_wall_actual_value;
        $log_arr['black_wall_current_value']                = $black_wall_pressure . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $percentile_trigger_virtual_barrier                 = $global_setting_arr['barrier_percentile_trigger_buy_virtual_barrier'];
        $percentile_trigger_virtual_barrier_apply           = $global_setting_arr['barrier_percentile_trigger_buy_virtual_barrier_apply'];
        $barrrier_actual_value                              = $coin_meta_hourly_arr['bid_quantity_' . $percentile_trigger_virtual_barrier];
        //*********************************************************************/
        $total_bid_quantity                                 = $coin_meta_arr['market_depth_quantity'];
        //*********************************************************************/
        $virtual_barrier_yes_no                             = true;
        $rule_on_off                                        = '<span style="background-color:yellow">OFF</span>';
        if ($percentile_trigger_virtual_barrier_apply == 'yes') {
            if ($barrrier_actual_value <= $total_bid_quantity) {
                $virtual_barrier_yes_no = true;
                $rule_on_off            = '<span style="color:green">YES</span>';
            } else {
                $virtual_barrier_yes_no = false;
                $rule_on_off            = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['virtual_barrier_status']                       = $rule_on_off;
        $log_arr['virtual_barrier_recommended_percentile']       = $percentile_trigger_virtual_barrier;
        $log_arr['virtual_barrier_recommended_percentile_value'] = $barrrier_actual_value;
        $log_arr['virtual_barrier_current_value']                = $total_bid_quantity . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $percentile_trigger_seven_level_pressure                 = $global_setting_arr['barrier_percentile_trigger_buy_seven_level_pressure'];
        $percentile_trigger_seven_level_pressure_apply           = $global_setting_arr['barrier_percentile_trigger_buy_seven_level_pressure_apply'];
        $seven_level_pressure_actual_value                       = $coin_meta_hourly_arr['sevenlevel_' . $percentile_trigger_seven_level_pressure];
        $seven_level_pressure_yes_no                             = true;
        $rule_on_off                                             = '<span style="background-color:yellow">OFF</span>';
        if ($percentile_trigger_seven_level_pressure_apply == 'yes') {
            if ($seven_level_pressure_actual_value <= $seven_level_depth) {
                $seven_level_pressure_yes_no = true;
                $rule_on_off                 = '<span style="color:green">YES</span>';
            } else {
                $seven_level_pressure_yes_no = false;
                $rule_on_off                 = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['seven_level_pressure_status']                       = $rule_on_off;
        $log_arr['seven_level_pressure_recommended_percentile']       = $percentile_trigger_seven_level_pressure;
        $log_arr['seven_level_pressure_recommended_percentile_value'] = $seven_level_pressure_actual_value;
        $log_arr['seven_level_pressure_current_value']                = $seven_level_depth . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $last_200_contracts_buy_vs_sell_percentile_trigger            = $global_setting_arr['barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell'];
        $last_200_contracts_buy_vs_sell_percentile_trigger_apply      = $global_setting_arr['barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell_apply'];
        $last_200_contracts_yes_no                                    = true;
        $rule_on_off                                                  = '<span style="background-color:yellow">OFF</span>';
        if ($last_200_contracts_buy_vs_sell_percentile_trigger_apply == 'yes') {
            if ($last_200_buy_vs_sell >= $last_200_contracts_buy_vs_sell_percentile_trigger) {
                $last_200_contracts_yes_no = true;
                $rule_on_off               = '<span style="color:green">YES</span>';
            } else {
                $last_200_contracts_yes_no = false;
                $rule_on_off               = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['last_200_buy_vs_sell_status']            = $rule_on_off;
        $log_arr['last_200_buy_vs_sell_recommended_value'] = $last_200_contracts_buy_vs_sell_percentile_trigger;
        $log_arr['last_200_buy_vs_sell_current_value']     = $last_200_buy_vs_sell . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $last_200_contracts_time_percentile_trigger        = $global_setting_arr['barrier_percentile_trigger_buy_last_200_contracts_time'];
        $last_200_contracts_time_percentile_trigger_apply  = $global_setting_arr['barrier_percentile_trigger_buy_last_200_contracts_time_apply'];
        $last_200_contracts_time_yes_no                    = true;
        $rule_on_off                                       = '<span style="background-color:yellow">OFF</span>';
        if ($last_200_contracts_time_percentile_trigger_apply == 'yes') {
            if ($last_200_time_ago <= $last_200_contracts_time_percentile_trigger) {
                $last_200_contracts_time_yes_no = true;
                $rule_on_off                    = '<span style="color:green">YES</span>';
            } else {
                $last_200_contracts_time_yes_no = false;
                $rule_on_off                    = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['last_200_time_ago_status']                         = $rule_on_off;
        $log_arr['last_200_time_ago_recommended_value']              = $last_200_contracts_time_percentile_trigger;
        $log_arr['last_200_time_ago_current_value']                  = $last_200_time_ago . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $last_qty_contracts_buyer_vs_seller_percentile_trigger       = $global_setting_arr['barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller'];
        $last_qty_contracts_buyer_vs_seller_percentile_trigger_apply = $global_setting_arr['barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller_apply'];
        $last_200_contracts_qty_yes_no                               = true;
        $rule_on_off                                                 = '<span style="background-color:yellow">OFF</span>';
        if ($last_qty_contracts_buyer_vs_seller_percentile_trigger_apply == 'yes') {
            if ($last_qty_buy_vs_sell >= $last_qty_contracts_buyer_vs_seller_percentile_trigger) {
                $last_200_contracts_qty_yes_no = true;
                $rule_on_off                   = '<span style="color:green">YES</span>';
            } else {
                $last_200_contracts_qty_yes_no = false;
                $rule_on_off                   = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['last_qty_buy_vs_sell_status']            = $rule_on_off;
        $log_arr['last_qty_buy_vs_sell_recommended_value'] = $last_qty_contracts_buyer_vs_seller_percentile_trigger;
        $log_arr['last_qty_buy_vs_sell_current_value']     = $last_qty_buy_vs_sell . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $last_qty_contracts_time_percentile_trigger        = $global_setting_arr['barrier_percentile_trigger_buy_last_qty_contracts_time'];
        $last_qty_contracts_time_percentile_trigger_apply  = $global_setting_arr['barrier_percentile_trigger_buy_last_qty_contracts_time_apply'];
        $last_qty_contracts_time_yes_no                    = true;
        $rule_on_off                                       = '<span style="background-color:yellow">OFF</span>';
        if ($last_qty_contracts_time_percentile_trigger_apply == 'yes') {
            if ($last_qty_time_ago <= $last_qty_contracts_time_percentile_trigger) {
                $last_qty_contracts_time_yes_no = true;
                $rule_on_off                    = '<span style="color:green">YES</span>';
            } else {
                $last_qty_contracts_time_yes_no = false;
                $rule_on_off                    = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['last_qty_contracts_time_status']            = $rule_on_off;
        $log_arr['last_qty_contracts_time_recommended_value'] = $last_qty_contracts_time_percentile_trigger;
        $log_arr['last_qty_contracts_time_current_value']     = $last_qty_time_ago . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% Last Procedding Orders %%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $last_procedding_status                               = $this->mod_reports_rules->last_procedding_candle_status_history($coin_symbol, $simulator_date);
        $current_candel_status                                = $global_setting_arr['percentile_trigger_last_candle_type'];
        $candel_status_meet                                   = true;
        $rule_on_off                                          = '<span style="background-color:yellow">OFF</span>';
        if ($global_setting_arr['barrier_percentile_is_previous_blue_candel'] == 'yes') {
            if ($last_procedding_status == $current_candel_status) {
                $candel_status_meet = true;
                $rule_on_off        = '<span style="color:green">YES</span>';
            } else {
                $candel_status_meet = false;
                $rule_on_off        = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['last_candel_status']            = $rule_on_off;
        $log_arr['recommended_candel_status']     = $current_candel_status;
        $log_arr['Last_procedding_candel_status'] = $last_procedding_status . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%-- -- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $log_msg                                  = '';
        foreach ($log_arr as $key => $value) {
            $log_msg .= $key . '=>' . $value . '<br>';
        }
        $is_buy_rule_on = false;
        if ($global_setting_arr['enable_buy_barrier_percentile'] == 'yes') {
            $is_buy_rule_on = true;
        }
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $is_rules_true = 'NO';
        if ($last_200_contracts_qty_yes_no && $last_200_contracts_time_yes_no && $last_200_contracts_yes_no && $black_wall_yes_no && $virtual_barrier_yes_no && $seven_level_pressure_yes_no && $last_qty_contracts_time_yes_no && $is_buy_rule_on && $five_minute_rolling_candel_yes_no && $fifteen_minute_rolling_candel_yes_no && $meet_condition_for_buy && $buyers_yes_no && $sellers_yes_no && $candel_status_meet) {
            $is_rules_true = 'YES';
			            	
							
							
        }
        $response['success_message'] = $is_rules_true;
        $response['log_message']     = $log_msg;
		
        return $response;
    } //End of is_triggers_qualify_to_buy_orders
    //======================================================================
    // Get all Rules settings against coin percentile_trigger_rule
    //======================================================================
    public function list_hourly_percentile_coin_meta_history($symbol, $simulator_date)
    {
        $search['coin']          = $symbol;
        $simulator_date          = date('Y-m-d H:00:00', strtotime($simulator_date));
        $simulator_date          = $this->mongo_db->converToMongodttime($simulator_date);
        $search['modified_time'] = $simulator_date;
        $this->mongo_db->where($search);
        $response_obj = $this->mongo_db->get('coin_meta_hourly_percentile_history');
        $response_arr = iterator_to_array($response_obj);
        return $response_arr[0];
    } //End of list_hourly_percentile_coin_meta_history
    
	//======================================================================
    // Get all Rules settings against coin percentile_trigger_report
    //======================================================================
    public function percentile_trigger_report($symbol, $start_date, $end_date)
    {
        $search['coin']          = $symbol;
        $search['modified_date'] = array(
            '$gte' => $this->mongo_db->converToMongodttime($start_date),
            '$lte' => $this->mongo_db->converToMongodttime($end_date)
        );
        $this->mongo_db->limit(10);
        //$this->mongo_db->where($search);
        $response_obj = $this->mongo_db->get('percentile_rules_report_log');
        $response_arr = iterator_to_array($response_obj);
        return $response_arr;
    } //End of percentile_trigger_report
	
	
	//======================================================================
    // Get all Rules settings against coin percentile_trigger_rule
    //======================================================================
    public function list_historical_coin_meta($symbol, $start_date, $end_date)
    {
        $search['coin']          = $symbol;
        $search['modified_date'] = array(
            '$gte' => $this->mongo_db->converToMongodttime($start_date),
            '$lte' => $this->mongo_db->converToMongodttime($end_date)
        );
        $this->mongo_db->where($search);
        $this->mongo_db->limit(10000);
        $this->mongo_db->where($search);
        $response_obj = $this->mongo_db->get('coin_meta_history');
        $response_arr = iterator_to_array($response_obj);
        return $response_arr;
    } //End of list_historical_coin_meta
    //======================================================================
    // Get all Rules settings against coin percentile_trigger_rule
    //======================================================================
    public function triggers_setting($triggers_type, $order_mode, $coin_symbol, $order_level = '')
    {
        $where['triggers_type'] = $triggers_type;
        $where['order_mode']    = $order_mode;
        $where['coin']          = $coin_symbol;
        if ($order_level != '') {
            $where['trigger_level'] = $order_level;
        }
        $this->mongo_db->where($where);
        $response_obj = $this->mongo_db->get('trigger_global_setting');
        $response_arr = iterator_to_array($response_obj);
        return $response_arr[0];
    } //End of triggers_setting
    //======================================================================
    // Get all Rules settings against coin percentile_trigger_rule
    //======================================================================
    public function list_coin_meta($symbol, $start_date, $end_date)
    {
        $search_arr['modified_date']['$gte'] = $this->mongo_db->converToMongodttime($start_date);
        $search_arr['modified_date']['$lte'] = $this->mongo_db->converToMongodttime($end_date);
        $this->mongo_db->where('coin', $symbol);
        $this->mongo_db->limit(1);
        $this->mongo_db->where($search_arr);
        $response_obj = $this->mongo_db->get('coin_meta_history');
        $response_arr = iterator_to_array($response_obj);
        return $response_arr[0];
    } //End of list_coin_meta
    //======================================================================
    // Get all Rules settings against coin percentile_trigger_rule
    //======================================================================
    public function list_hourly_percentile_coin_meta($symbol, $start_date, $end_date)
    {
        $search_arr['modified_time']['$gte'] = $this->mongo_db->converToMongodttime($start_date);
        $search_arr['modified_time']['$lte'] = $this->mongo_db->converToMongodttime($end_date);
        $this->mongo_db->where('coin', $symbol); // pass the hourly date
        $this->mongo_db->where($search_arr);
        $response_obj = $this->mongo_db->get('coin_meta_hourly_percentile_history');
        $response_arr = iterator_to_array($response_obj);
        return $response_arr[0];
    } //End of list_hourly_percentile_coin_meta
    //======================================================================
    // Get all Rules settings against coin list_barrier_status
    //======================================================================
    public function list_barrier_status($coin_symbol, $barrier_status, $market_price, $type)
    {
        $this->mongo_db->limit(1);
        $where = array();
        if ($type == 'down') {
            $where['barier_value'] = array(
                '$lte' => (float) $market_price
            );
        }
        $where['coin']           = $coin_symbol;
        $where['barrier_status'] = $barrier_status;
        $where['barrier_type']   = $type;
        $this->mongo_db->order_by(array(
            'created_date' => -1
        ));
        $this->mongo_db->where($where);
        $res_obj      = $this->mongo_db->get('barrier_values_collection');
        $res_arr      = iterator_to_array($res_obj);
        $barier_value = '';
        $data         = array();
        if (count($res_arr) > 0) {
            $row                                 = $res_arr[0];
            $barier_value                        = $row['barier_value'];
            $data['barrier_status']              = $row['barrier_status'];
            $data['barier_value']                = $row['barier_value'];
            $data['human_readible_created_date'] = $row['human_readible_created_date'];
        } //End of Count
        return $barier_value;
    } //End of list_barrier_status
    //======================================================================
    // Get all Rules settings against coin calculate_one_minute_rolling_volume
    //======================================================================
    public function calculate_one_minute_rolling_volume($coin_symbol, $start_date, $end_date)
    {
        $search_arr['created_date']['$gte'] = $this->mongo_db->converToMongodttime($start_date);
        $search_arr['created_date']['$lte'] = $this->mongo_db->converToMongodttime($end_date);
        $this->mongo_db->limit(1);
        $search_arr['coin'] = $coin_symbol;
        $this->mongo_db->where($search_arr);
        $iterator = $this->mongo_db->get('market_trade_history');
        $bid      = 0;
        $ask      = 0;
        $buy      = 0;
        $sell     = 0;
        foreach ($iterator as $key => $value) {
            $quantity = $value['quantity'];
            if ($value['maker'] == 'true') {
                $bid += $quantity;
            }
            if ($value['maker'] == 'false') {
                $ask += $quantity;
            }
            if ($value['type'] == 'buy') {
                $buy += $quantity;
            }
            if ($value['type'] == 'sell') {
                $sell += $quantity;
            }
        }
        $retArr['bid']  = $bid;
        $retArr['ask']  = $ask;
        $retArr['buy']  = $buy;
        $retArr['sell'] = $sell;
        return $retArr;
    } //End of calculate_one_minute_rolling_volume
    //======================================================================
    // Get all Rules settings against coin list_market_trends
    //======================================================================
    public function list_market_trends($coin)
    {
        $search_schema['coin'] = $coin;
        $this->mongo_db->limit(1);
        $this->mongo_db->where($search_schema);
        $data_row = $this->mongo_db->get('market_trending');
        $row      = iterator_to_array($data_row);
        $resp     = array();
        if (!empty($row)) {
            $resp = $row;
        }
        return $resp;
    } // End of list_market_trends
    //======================================================================
    // Get all Rules settings against coin get_coin_detail
    //======================================================================
    public function get_coin_detail($coin_symbol = '')
    {
        $where = array();
        if ($coin_symbol != '') {
            $where['symbol'] = $coin_symbol;
        }
        $where['user_id'] = 'global';
        $this->mongo_db->where($where);
        $get_coin = $this->mongo_db->get('coins');
        $coin_arr = iterator_to_array($get_coin);
        return $coin_arr[0];
    } //End of get_coin_detail
    //======================================================================
    // Get all Rules settings against coin get_coin_detail
    //======================================================================
    public function list_market_volume($market_price, $coin_symbol, $type)
    {
        $where['coin']  = $coin_symbol;
        $where['type']  = $type;
        $where['price'] = $market_price;
        $this->mongo_db->where($where);
        $responseobj = $this->mongo_db->get('market_depth');
        $responseArr = iterator_to_array($responseobj);
        ;
        $global_quantity = '';
        if (count($responseArr) > 0) {
            $global_quantity = $responseArr[0]['quantity'];
        }
        return $global_quantity;
    } //End of list_market_volume
    //======================================================================
    // Get all Rules settings against coin last_procedding_candle_status
    //======================================================================
    public function last_procedding_candle_status($coin)
    {
        $this->mongo_db->limit(1);
        $this->mongo_db->order_by(array(
            'timestampDate' => -1
        ));
        $this->mongo_db->where_in('candle_type', array(
            'demand',
            'supply'
        ));
        $this->mongo_db->where(array(
            'coin' => $coin
        ));
        $response    = $this->mongo_db->get('market_chart');
        $response    = iterator_to_array($response);
        $candle_type = '';
        if (!empty($response)) {
            $candle_type = $response[0]['candle_type'];
        }
        return $candle_type;
    } //%%%%%%%%%%%%%   End of last_procedding_candle_status %%%%%%%%%%%%%5
    //======================================================================
    // Get all Rules settings against coin is_triggers_qualify_to_buy_orders
    //======================================================================
    public function is_triggers_qualify_to_buy_orders($coin_symbol, $order_level, $global_setting_arr, $current_market_price, $coin_meta_arr, $coin_meta_hourly_arr, $one_m_rolling_volume, $list_market_trends_arr)
    {
        $log_arr                       = array();
        $barrier_range_percentage      = $global_setting_arr['barrier_percentile_trigger_barrier_range_percentage'];
        $barrier_range_percentage      = ($barrier_range_percentage == '') ? 1 : $barrier_range_percentage;
        $five_minute_rolling_candel    = $coin_meta_arr['sellers_buyers_per'];
        $fifteen_minute_rolling_candel = $coin_meta_arr['sellers_buyers_per_fifteen'];
        $buyers_fifteen                = $coin_meta_arr['buyers_fifteen'];
        $sellers_fifteen               = $coin_meta_arr['sellers_fifteen'];
        $black_wall_pressure           = $coin_meta_arr['black_wall_pressure'];
        $seven_level_depth             = $coin_meta_arr['seven_level_depth'];
        $last_200_buy_vs_sell          = $coin_meta_arr['last_200_buy_vs_sell'];
        $last_200_time_ago             = (float) $coin_meta_arr['last_200_time_ago'];
        $last_qty_buy_vs_sell          = $coin_meta_arr['last_qty_buy_vs_sell'];
        $last_qty_time_ago             = (float) $coin_meta_arr['last_qty_time_ago'];
        $last_qty_time_ago_15          = (float) $coin_meta_arr['last_qty_time_ago_15'];
        $ask_contract                  = (float) $coin_meta_arr['ask_contract'];
        $bid_contracts                 = (float) $coin_meta_arr['bid_contracts'];
        $enable_buy_barrier_percentile = $global_setting_arr['enable_buy_barrier_percentile'];
        if ($enable_buy_barrier_percentile == 'not' || $enable_buy_barrier_percentile == '') {
            $log_arr['Percentile_Level_' . $order_level . '_status'] = '<span style="color:red">OFF</span>';
            return $log_arr;
        } //End of 
        $log_arr['-']                                = '<span style="color: green;font-size: 27px;">Buy Rules</span><br>';
        $log_arr['Order_Is_Buyed_By_Level']          = $order_level . '<br>';
        /* Buyer ---------------------------------------- */
        $barrier_percentile_trigger_buyers_buy       = $global_setting_arr['barrier_percentile_trigger_buyers_buy'];
        $barrier_percentile_trigger_buyers_buy_apply = $global_setting_arr['barrier_percentile_trigger_buyers_buy_apply'];
        $buyers_recommended_percentile_value         = $coin_meta_hourly_arr['buyers_fifteen_' . $barrier_percentile_trigger_buyers_buy];
        $buyers_yes_no                               = true;
        $rule_on_off                                 = '<span style="background-color:yellow">OFF</span>';
        if ($barrier_percentile_trigger_buyers_buy_apply == 'yes') {
            if ($buyers_fifteen >= $buyers_recommended_percentile_value) {
                $buyers_yes_no = true;
                $rule_on_off   = '<span style="color:green">YES</span>';
            } else {
                $buyers_yes_no = false;
                $rule_on_off   = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['Buyers_status']                       = $rule_on_off;
        $log_arr['Buyers_recommended_percentile']       = $barrier_percentile_trigger_buyers_buy;
        $log_arr['Buyers_recommended_percentile_value'] = $buyers_recommended_percentile_value;
        $log_arr['Buyer_current_value']                 = $buyers_fifteen . '<br>';
        /* Buyer ---------------------------------------- */
        $seller_percentile                              = $global_setting_arr['barrier_percentile_trigger_sellers_buy'];
        $barrier_percentile_trigger_sellers_buy_apply   = $global_setting_arr['barrier_percentile_trigger_sellers_buy_apply'];
        $sellers_recommended_percentile_value           = $coin_meta_hourly_arr['sellers_fifteen_b_' . $seller_percentile];
        $sellers_yes_no                                 = true;
        $rule_on_off                                    = '<span style="background-color:yellow">OFF</span>';
        if ($barrier_percentile_trigger_sellers_buy_apply == 'yes') {
            if ($sellers_fifteen <= $sellers_recommended_percentile_value) {
                $sellers_yes_no = true;
                $rule_on_off    = '<span style="color:green">YES</span>';
            } else {
                $sellers_yes_no = false;
                $rule_on_off    = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['Sellers_status']                       = $rule_on_off;
        $log_arr['Sellers_recommended_percentile']       = $seller_percentile;
        $log_arr['Sellers_recommended_percentile_value'] = $sellers_recommended_percentile_value;
        $log_arr['Sellers_current_value']                = $sellers_fifteen . '<br>';
        /* Barrier Status ---------------------------------------- */
        $last_barrrier_value                             = $this->mod_reports_rules->list_barrier_status($coin_symbol, 'very_strong_barrier', $current_market_price, 'down');
        $barrier_value_range_upside                      = $last_barrrier_value + ($last_barrrier_value / 100) * $barrier_range_percentage;
        $barrier_value_range_down_side                   = $last_barrrier_value - ($last_barrrier_value / 100) * $barrier_range_percentage;
        $meet_condition_for_buy                          = true;
        $rule_on_off                                     = '<span style="background-color:yellow">OFF</span>';
        if ($barrier_range_percentage != '' || $barrier_range_percentage != 0) {
            if ((num($current_market_price) >= num($barrier_value_range_down_side)) && (num($current_market_price) <= num($barrier_value_range_upside))) {
                $meet_condition_for_buy = true;
                $rule_on_off            = '<span style="color:green">YES</span>';
            } else {
                $meet_condition_for_buy = false;
                $rule_on_off            = '<span style="color:red">NO</span>';
            }
        } //%%%%%%%%%% --  End of barrier range percentage -- %%%%%%%%%%555
        $log_arr['is_Barrier_Meet']                               = $rule_on_off;
        $log_arr['Last_Barrier_price']                            = num($last_barrrier_value);
        $log_arr['Barrier_Range_percentage']                      = $barrier_range_percentage;
        $log_arr['Barrier_Range']                                 = 'Barrir From <b>(' . num($barrier_value_range_down_side) . ')</b> To  <b>(' . num($barrier_value_range_upside) . ')</b><br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $percentile_trigger_15_minute_rolling_candel              = $global_setting_arr['barrier_percentile_trigger_15_minute_rolling_candel'];
        $percentile_trigger_15_minute_rolling_candel_apply        = $global_setting_arr['barrier_percentile_trigger_15_minute_rolling_candel_apply'];
        $percentile_trigger_15_minute_rolling_candel_actual_value = $coin_meta_hourly_arr['fifteen_min_' . $percentile_trigger_15_minute_rolling_candel];
        $fifteen_minute_rolling_candel_yes_no                     = true;
        $rule_on_off                                              = '<span style="background-color:yellow">OFF</span>';
        if ($percentile_trigger_15_minute_rolling_candel_apply == 'yes') {
            if ($percentile_trigger_15_minute_rolling_candel_actual_value <= $fifteen_minute_rolling_candel) {
                $fifteen_minute_rolling_candel_yes_no = true;
                $rule_on_off                          = '<span style="color:green">YES</span>';
            } else {
                $fifteen_minute_rolling_candel_yes_no = false;
                $rule_on_off                          = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['15_minute_rolling_candel_status']                       = $rule_on_off;
        $log_arr['15_minute_rolling_candel_recommended_percentile']       = $percentile_trigger_15_minute_rolling_candel;
        $log_arr['15_minute_rolling_candel_recommended_percentile_value'] = $percentile_trigger_15_minute_rolling_candel_actual_value;
        $log_arr['15_minute_rolling_candel_current_value']                = $fifteen_minute_rolling_candel . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $percentile_trigger_5_minute_rolling_candel                       = $global_setting_arr['barrier_percentile_trigger_5_minute_rolling_candel'];
        $percentile_trigger_5_minute_rolling_candel_apply                 = $global_setting_arr['barrier_percentile_trigger_5_minute_rolling_candel_apply'];
        $percentile_trigger_5_minute_rolling_candel_actual_value          = $coin_meta_hourly_arr['five_min_' . $percentile_trigger_5_minute_rolling_candel];
        $five_minute_rolling_candel_yes_no                                = true;
        $rule_on_off                                                      = '<span style="background-color:yellow">OFF</span>';
        if ($percentile_trigger_5_minute_rolling_candel_apply == 'yes') {
            if ($percentile_trigger_5_minute_rolling_candel_actual_value <= $five_minute_rolling_candel) {
                $five_minute_rolling_candel_yes_no = true;
                $rule_on_off                       = '<span style="color:green">YES</span>';
            } else {
                $five_minute_rolling_candel_yes_no = false;
                $rule_on_off                       = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['5_minute_rolling_candel_status']                       = $rule_on_off;
        $log_arr['5_minute_rolling_candel_recommended_percentile']       = $percentile_trigger_5_minute_rolling_candel;
        $log_arr['5_minute_rolling_candel_recommended_percentile_value'] = $percentile_trigger_5_minute_rolling_candel_actual_value;
        $log_arr['5_minute_rolling_candel_current_value']                = $five_minute_rolling_candel . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $percentile_trigger_black_wall                                   = $global_setting_arr['barrier_percentile_trigger_buy_black_wall'];
        $percentile_trigger_black_wall_apply                             = $global_setting_arr['barrier_percentile_trigger_buy_black_wall_apply'];
        $percentile_trigger_black_wall_actual_value                      = $coin_meta_hourly_arr['blackwall_' . $percentile_trigger_black_wall];
        $black_wall_yes_no                                               = true;
        $rule_on_off                                                     = '<span style="background-color:yellow">OFF</span>';
        if ($percentile_trigger_black_wall_apply == 'yes') {
            if ($percentile_trigger_black_wall_actual_value <= $black_wall_pressure) {
                $black_wall_yes_no = true;
                $rule_on_off       = '<span style="color:green">YES</span>';
            } else {
                $black_wall_yes_no = false;
                $rule_on_off       = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['black_wall_status']                       = $rule_on_off;
        $log_arr['black_wall_recommended_percentile']       = $percentile_trigger_black_wall;
        $log_arr['black_wall_recommended_percentile_value'] = $percentile_trigger_black_wall_actual_value;
        $log_arr['black_wall_current_value']                = $black_wall_pressure . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $percentile_trigger_virtual_barrier                 = $global_setting_arr['barrier_percentile_trigger_buy_virtual_barrier'];
        $percentile_trigger_virtual_barrier_apply           = $global_setting_arr['barrier_percentile_trigger_buy_virtual_barrier_apply'];
        $barrrier_recommended_value                         = $coin_meta_hourly_arr['bid_quantity_' . $percentile_trigger_virtual_barrier];
        //*********************************************************************/
        //%%%%%%%%%%%%%%%% -- Coin Unit Detail --%%%%%%%%%%%%%%%%%%%%%
        $coin_detail                                        = $this->mod_reports_rules->get_coin_detail($coin_symbol);
        $coin_offset_value                                  = $coin_detail['offset_value'];
        $coin_unit_value                                    = $coin_detail['unit_value'];
        $total_bid_quantity                                 = 0;
        for ($i = 0; $i < $coin_offset_value; $i++) {
            $new_last_barrrier_value = (float) trim($current_market_price - ($coin_unit_value * $i));
            $bid                     = $this->mod_reports_rules->list_market_volume($new_last_barrrier_value, $coin_symbol, 'bid');
            $total_bid_quantity += $bid;
        } //End of Coin off Set
        $virtual_barrier_yes_no = true;
        $rule_on_off            = '<span style="background-color:yellow">OFF</span>';
        if ($percentile_trigger_virtual_barrier_apply == 'yes') {
            if ($total_bid_quantity >= $barrrier_recommended_value) {
                $virtual_barrier_yes_no = true;
                $rule_on_off            = '<span style="color:green">YES</span>';
            } else {
                $virtual_barrier_yes_no = false;
                $rule_on_off            = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['virtual_bid_barrier_status']                       = $rule_on_off;
        $log_arr['virtual_bid_barrier_recommended_percentile']       = $percentile_trigger_virtual_barrier;
        $log_arr['virtual_bid_barrier_recommended_percentile_value'] = $barrrier_recommended_value;
        $log_arr['virtual_bid_barrier_current_value']                = $total_bid_quantity . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%% virtual Ask barrier %%%%%%%%%%%%%%%%%%%%%%
        $percentile_trigger_virtual_barrier                          = $global_setting_arr['barrier_percentile_trigger_sell_virtual_barrier_for_buy'];
        $percentile_trigger_virtual_barrier_apply                    = $global_setting_arr['barrier_percentile_trigger_sell_virtual_barrier_for_buy_apply'];
        $barrrier_recommended_value                                  = $coin_meta_hourly_arr['ask_quantity_b_' . $percentile_trigger_virtual_barrier];
        $total_ask_quantity                                          = 0;
        for ($i = 0; $i < $coin_offset_value; $i++) {
            $new_last_barrrier_value = (float) trim($current_market_price - ($coin_unit_value * $i));
            $ask                     = $this->mod_reports_rules->list_market_volume($new_last_barrrier_value, $coin_symbol, 'ask');
            $total_ask_quantity += $ask;
        } //End of Coin off Set
        //*********************************************************************/
        $virtual_barrier_ask_yes_no = true;
        $rule_on_off                = '<span style="background-color:yellow">OFF</span>';
        if ($percentile_trigger_virtual_barrier_apply == 'yes') {
            if ($total_ask_quantity <= $barrrier_recommended_value) {
                $virtual_barrier_ask_yes_no = true;
                $rule_on_off                = '<span style="color:green">YES</span>';
            } else {
                $virtual_barrier_ask_yes_no = false;
                $rule_on_off                = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['virtual_ask_barrier_status']                       = $rule_on_off;
        $log_arr['virtual_ask_barrier_recommended_percentile']       = $percentile_trigger_virtual_barrier;
        $log_arr['virtual_ask_barrier_recommended_percentile_value'] = $barrrier_recommended_value;
        $log_arr['virtual_ask_barrier_current_value--']              = $total_ask_quantity . '<br>';
        //%%%%%%%%%%%% End of ask barrier %%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $percentile_trigger_seven_level_pressure                     = $global_setting_arr['barrier_percentile_trigger_buy_seven_level_pressure'];
        $percentile_trigger_seven_level_pressure_apply               = $global_setting_arr['barrier_percentile_trigger_buy_seven_level_pressure_apply'];
        $seven_level_pressure_actual_value                           = $coin_meta_hourly_arr['sevenlevel_' . $percentile_trigger_seven_level_pressure];
        $seven_level_pressure_yes_no                                 = true;
        $rule_on_off                                                 = '<span style="background-color:yellow">OFF</span>';
        if ($percentile_trigger_seven_level_pressure_apply == 'yes') {
            if ($seven_level_pressure_actual_value <= $seven_level_depth) {
                $seven_level_pressure_yes_no = true;
                $rule_on_off                 = '<span style="color:green">YES</span>';
            } else {
                $seven_level_pressure_yes_no = false;
                $rule_on_off                 = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['seven_level_pressure_status']                       = $rule_on_off;
        $log_arr['seven_level_pressure_recommended_percentile']       = $percentile_trigger_seven_level_pressure;
        $log_arr['seven_level_pressure_recommended_percentile_value'] = $seven_level_pressure_actual_value;
        $log_arr['seven_level_pressure_current_value']                = $seven_level_depth . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $last_200_contracts_buy_vs_sell_percentile_trigger            = $global_setting_arr['barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell'];
        $last_200_contracts_buy_vs_sell_percentile_trigger_apply      = $global_setting_arr['barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell_apply'];
        $last_200_contracts_yes_no                                    = true;
        $rule_on_off                                                  = '<span style="background-color:yellow">OFF</span>';
        if ($last_200_contracts_buy_vs_sell_percentile_trigger_apply == 'yes') {
            if ($last_200_buy_vs_sell >= $last_200_contracts_buy_vs_sell_percentile_trigger) {
                $last_200_contracts_yes_no = true;
                $rule_on_off               = '<span style="color:green">YES</span>';
            } else {
                $last_200_contracts_yes_no = false;
                $rule_on_off               = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['last_200_buy_vs_sell_status']            = $rule_on_off;
        $log_arr['last_200_buy_vs_sell_recommended_value'] = $last_200_contracts_buy_vs_sell_percentile_trigger;
        $log_arr['last_200_buy_vs_sell_current_value']     = $last_200_buy_vs_sell . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $last_200_contracts_time_percentile_trigger        = $global_setting_arr['barrier_percentile_trigger_buy_last_200_contracts_time'];
        $last_200_contracts_time_percentile_trigger_apply  = $global_setting_arr['barrier_percentile_trigger_buy_last_200_contracts_time_apply'];
        $last_200_contracts_time_yes_no                    = true;
        $rule_on_off                                       = '<span style="background-color:yellow">OFF</span>';
        if ($last_200_contracts_time_percentile_trigger_apply == 'yes') {
            if ($last_200_time_ago <= $last_200_contracts_time_percentile_trigger) {
                $last_200_contracts_time_yes_no = true;
                $rule_on_off                    = '<span style="color:green">YES</span>';
            } else {
                $last_200_contracts_time_yes_no = false;
                $rule_on_off                    = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['last_200_time_ago_status']                         = $rule_on_off;
        $log_arr['last_200_time_ago_recommended_value']              = $last_200_contracts_time_percentile_trigger;
        $log_arr['last_200_time_ago_current_value']                  = $last_200_time_ago . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $last_qty_contracts_buyer_vs_seller_percentile_trigger       = $global_setting_arr['barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller'];
        $last_qty_contracts_buyer_vs_seller_percentile_trigger_apply = $global_setting_arr['barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller_apply'];
        $last_200_contracts_qty_yes_no                               = true;
        $rule_on_off                                                 = '<span style="background-color:yellow">OFF</span>';
        if ($last_qty_contracts_buyer_vs_seller_percentile_trigger_apply == 'yes') {
            if ($last_qty_buy_vs_sell >= $last_qty_contracts_buyer_vs_seller_percentile_trigger) {
                $last_200_contracts_qty_yes_no = true;
                $rule_on_off                   = '<span style="color:green">YES</span>';
            } else {
                $last_200_contracts_qty_yes_no = false;
                $rule_on_off                   = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['last_qty_buy_vs_sell_status']            = $rule_on_off;
        $log_arr['last_qty_buy_vs_sell_recommended_value'] = $last_qty_contracts_buyer_vs_seller_percentile_trigger;
        $log_arr['last_qty_buy_vs_sell_current_value']     = $last_qty_buy_vs_sell . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $last_qty_contracts_time_percentile_trigger        = $global_setting_arr['barrier_percentile_trigger_buy_last_qty_contracts_time'];
        $last_qty_contracts_time_percentile_trigger_apply  = $global_setting_arr['barrier_percentile_trigger_buy_last_qty_contracts_time_apply'];
        $last_qty_contracts_time_yes_no                    = true;
        $rule_on_off                                       = '<span style="background-color:yellow">OFF</span>';
        if ($last_qty_contracts_time_percentile_trigger_apply == 'yes') {
            if ($last_qty_time_ago <= $last_qty_contracts_time_percentile_trigger) {
                $last_qty_contracts_time_yes_no = true;
                $rule_on_off                    = '<span style="color:green">YES</span>';
            } else {
                $last_qty_contracts_time_yes_no = false;
                $rule_on_off                    = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['last_qty_contracts_time_status']            = $rule_on_off;
        $log_arr['last_qty_contracts_time_recommended_value'] = $last_qty_contracts_time_percentile_trigger;
        $log_arr['last_qty_contracts_time_current_value']     = $last_qty_time_ago . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% Last Procedding Orders %%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $last_procedding_status                               = $this->mod_reports_rules->last_procedding_candle_status($coin_symbol);
        $current_candel_status                                = $global_setting_arr['percentile_trigger_last_candle_type'];
        $candel_status_meet                                   = true;
        $rule_on_off                                          = '<span style="background-color:yellow">OFF</span>';
        if ($global_setting_arr['barrier_percentile_is_previous_blue_candel'] == 'yes') {
            if ($last_procedding_status == $current_candel_status) {
                $candel_status_meet = true;
                $rule_on_off        = '<span style="color:green">YES</span>';
            } else {
                $candel_status_meet = false;
                $rule_on_off        = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['last_candel_status']            = $rule_on_off;
        $log_arr['recommended_candel_status']     = $current_candel_status;
        $log_arr['Last_procedding_candel_status'] = $last_procedding_status . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%-- -- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $is_buy_rule_on                           = false;
        if ($global_setting_arr['enable_buy_barrier_percentile'] == 'yes') {
            $is_buy_rule_on = true;
        }
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%% --  One Minute Rolling Candle -- %%%%%%%%%%%%%%%%%%%%%%%%%
        $buy                              = $one_m_rolling_volume['buy'];
        $bid                              = $one_m_rolling_volume['bid'];
        $ask                              = $one_m_rolling_volume['ask'];
        $sell                             = $one_m_rolling_volume['sell'];
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%  Buy Percentile Part  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $buy_percentile                   = $global_setting_arr['barrier_percentile_trigger_buy'];
        $buy_percentile_apply             = $global_setting_arr['barrier_percentile_trigger_buy_apply'];
        $buy_percentile_recommended_value = $coin_meta_hourly_arr['buy_' . $buy_percentile];
        $buy_percentile_yes_no            = true;
        $rule_on_off                      = '<span style="background-color:yellow">OFF</span>';
        if ($buy_percentile_apply == 'yes') {
            if ($buy >= $buy_percentile_recommended_value) {
                $buy_percentile_yes_no = true;
                $rule_on_off           = '<span style="color:green">YES</span>';
            } else {
                $buy_percentile_yes_no = false;
                $rule_on_off           = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['Buy_percentile_status']                       = $rule_on_off;
        $log_arr['Buy_percentile_recommended_percentile']       = $buy_percentile;
        $log_arr['Buy_percentile_recommended_percentile_value'] = $buy_percentile_recommended_value;
        $log_arr['Buy_percentile_current_value']                = $buy . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%  Ask Percentile Part  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $ask_percentile                                         = $global_setting_arr['barrier_percentile_trigger_ask'];
        $ask_percentile_apply                                   = $global_setting_arr['barrier_percentile_trigger_ask_apply'];
        $ask_percentile_recommended_value                       = $coin_meta_hourly_arr['ask_' . $ask_percentile];
        $ask_percentile_yes_no                                  = true;
        $rule_on_off                                            = '<span style="background-color:yellow">OFF</span>';
        if ($ask_percentile_apply == 'yes') {
            if ($ask >= $ask_percentile_recommended_value) {
                $ask_percentile_yes_no = true;
                $rule_on_off           = '<span style="color:green">YES</span>';
            } else {
                $ask_percentile_yes_no = false;
                $rule_on_off           = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['ask_percentile_status']                       = $rule_on_off;
        $log_arr['ask_percentile_recommended_percentile']       = $ask_percentile;
        $log_arr['ask_percentile_recommended_percentile_value'] = $ask_percentile_recommended_value;
        $log_arr['ask_percentile_current_value']                = $ask . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%  Sell Percentile Part  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $sell_percentile_apply                                  = $global_setting_arr['barrier_percentile_trigger_sell_apply'];
        $sell_percentile                                        = $global_setting_arr['barrier_percentile_trigger_sell'];
        $sell_percentile_recommended_value                      = $coin_meta_hourly_arr['sell_b_' . $sell_percentile];
        $sell_percentile_yes_no                                 = true;
        $rule_on_off                                            = '<span style="background-color:yellow">OFF</span>';
        if ($sell_percentile_apply == 'yes') {
            if ($sell <= $sell_percentile_recommended_value) {
                $sell_percentile_yes_no = true;
                $rule_on_off            = '<span style="color:green">YES</span>';
            } else {
                $sell_percentile_yes_no = false;
                $rule_on_off            = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['sell_percentile_status']                       = $rule_on_off;
        $log_arr['sell_percentile_recommended_percentile']       = $sell_percentile;
        $log_arr['sell_percentile_recommended_percentile_value'] = $sell_percentile_recommended_value;
        $log_arr['sell_percentile_current_value']                = $sell . '<br>';
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%  Bid Percentile Part  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $bid_percentile_apply                                    = $global_setting_arr['barrier_percentile_trigger_bid_apply'];
        $bid_percentile                                          = $global_setting_arr['barrier_percentile_trigger_bid'];
        $bid_percentile_recommended_value                        = $coin_meta_hourly_arr['bid_b_' . $bid_percentile];
        $bid_percentile_yes_no                                   = true;
        $rule_on_off                                             = '<span style="background-color:yellow">OFF</span>';
        if ($bid_percentile_apply == 'yes') {
            if ($bid <= $bid_percentile_recommended_value) {
                $bid_percentile_yes_no = true;
                $rule_on_off           = '<span style="color:green">YES</span>';
            } else {
                $bid_percentile_yes_no = false;
                $rule_on_off           = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['bid_percentile_status']                       = $rule_on_off;
        $log_arr['bid_percentile_recommended_percentile']       = $bid_percentile;
        $log_arr['bid_percentile_recommended_percentile_value'] = $bid_percentile_recommended_value;
        $log_arr['bid_percentile_current_value']                = $bid . '<br>';
        //%%%%%%%%%%%%%%%%%%%%% End of Bid %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%% --  End of One minute Rolling Candle-- %%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%  Ask Contract  Part  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $ask_contract                                           = (float) $coin_meta_arr['ask_contract'];
        $bid_contracts                                          = (float) $coin_meta_arr['bid_contracts'];
        $ask_contrc_percentile_apply                            = $global_setting_arr['barrier_percentile_trigger_ask_contracts_apply'];
        $ask_contrc_percentile                                  = $global_setting_arr['barrier_percentile_trigger_ask_contracts'];
        $ask_contrc_percentile_recommended_value                = $coin_meta_hourly_arr['ask_contract_' . $ask_contrc_percentile];
        $ask_contrc_percentile_yes_no                           = true;
        $rule_on_off                                            = '<span style="background-color:yellow">OFF</span>';
        if ($ask_contrc_percentile_apply == 'yes') {
            if ($ask_contract >= $ask_contrc_percentile_recommended_value) {
                $ask_contrc_percentile_yes_no = true;
                $rule_on_off                  = '<span style="color:green">YES</span>';
            } else {
                $ask_contrc_percentile_yes_no = false;
                $rule_on_off                  = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['ask_contrc_percentile_status']                       = $rule_on_off;
        $log_arr['ask_contrc_percentile_recommended_percentile']       = $ask_contrc_percentile;
        $log_arr['ask_contrc_percentile_recommended_percentile_value'] = $ask_contrc_percentile_recommended_value;
        $log_arr['ask_contrc_percentile_current_value']                = $ask_contract . '<br>';
        //%%%%%%%%%%%%%%%%%%%%% End of Ask Contracts %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%  Bid Contract  Part  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        $ask_contract                                                  = (float) $coin_meta_arr['ask_contract'];
        $bid_contracts                                                 = (float) $coin_meta_arr['bid_contracts'];
        $bid_contrc_percentile_apply                                   = $global_setting_arr['barrier_percentile_trigger_bid_contracts_apply'];
        $bid_contrc_percentile                                         = $global_setting_arr['barrier_percentile_trigger_bid_contracts'];
        $bid_contrc_percentile_recommended_value                       = $coin_meta_hourly_arr['bid_contracts_b_' . $bid_contrc_percentile];
        $bid_contrc_percentile_yes_no                                  = true;
        $rule_on_off                                                   = '<span style="background-color:yellow">OFF</span>';
        if ($bid_contrc_percentile_apply == 'yes') {
            if ($bid_contracts <= $bid_contrc_percentile_recommended_value) {
                $bid_contrc_percentile_yes_no = true;
                $rule_on_off                  = '<span style="color:green">YES</span>';
            } else {
                $bid_contrc_percentile_yes_no = false;
                $rule_on_off                  = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['bid_contrc_percentile_status']                       = $rule_on_off;
        $log_arr['bid_contrc_percentile_recommended_percentile']       = $bid_contrc_percentile;
        $log_arr['bid_contrc_percentile_recommended_percentile_value'] = $bid_contrc_percentile_recommended_value;
        $log_arr['bid_contrc_percentile_current_value']                = $bid_contracts . '<br>';
        //%%%%%%%%%%%%%%%%%%%%% End of Bid Contracts %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%% -- 15 minute Ago -- %%%%%%%%%%%%%%%%%%%%%%
        $barrier_percentile_trigger_15_minute_last_time_ago_apply      = $global_setting_arr['barrier_percentile_trigger_15_minute_last_time_ago_apply'];
        $barrier_percentile_trigger_15_minute_last_time_ago            = $global_setting_arr['barrier_percentile_trigger_15_minute_last_time_ago'];
        $recommended_value                                             = $coin_meta_hourly_arr['last_qty_time_ago_fif_' . $barrier_percentile_trigger_15_minute_last_time_ago];
        $last_time_ago_15_m_yes_no                                     = true;
        $rule_on_off                                                   = '<span style="background-color:yellow">OFF</span>';
        if ($barrier_percentile_trigger_15_minute_last_time_ago_apply == 'yes') {
            if ($last_qty_time_ago_15 <= $recommended_value) {
                $last_time_ago_15_m_yes_no = true;
                $rule_on_off               = '<span style="color:green">YES</span>';
            } else {
                $last_time_ago_15_m_yes_no = false;
                $rule_on_off               = '<span style="color:red">NO</span>';
            }
        }
        $log_arr['lat_15_minute_time_ago_percentile_status']            = $rule_on_off;
        $log_arr['lat_15_minute_time_ago_recommended_percentile']       = $barrier_percentile_trigger_15_minute_last_time_ago;
        $log_arr['lat_15_minute_time_ago_recommended_percentile_value'] = $recommended_value;
        $log_arr['lat_15_minute_time_ago_percentile_current_value']     = $last_qty_time_ago_15 . '<br>';
        //%%%%%%%%%%%%%%%%%%% -- End 15 minute Ago -- %%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%% Market Trends %%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        // By Ali 5-30-2019
        /*$caption_option                                                 = $list_market_trends_arr['caption_option'];
        $recommended_value                                              = $global_setting_arr['percentile_trigger_caption_option_buy'];
        $is_on                                                          = $global_setting_arr['percentile_trigger_caption_option_buy_apply'];
        $is_on_off_caption                                              = true;
        $rule_on_off                                                    = '<span style="background-color:yellow">OFF</span>';
        if ($is_on == 'yes') {
        if ($caption_option > $recommended_value) {
        $is_on_off_caption = true;
        $rule_on_off       = '<span style="color:green">YES</span>';
        } else {
        $is_on_off_caption = false;
        $rule_on_off       = '<span style="color:red">NO</span>';
        }
        }
        $log_arr['caption_option_status']            = $rule_on_off;
        $log_arr['caption_option_recommended_value'] = $recommended_value;
        $log_arr['caption_option_current_value']     = $caption_option . '<br>';
        */
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        // By Ali 5-30-2019
        /* $current_val                                 = $list_market_trends_arr['caption_score'];
        $recommended_value                           = $global_setting_arr['percentile_trigger_caption_score_buy'];
        $is_on                                       = $global_setting_arr['percentile_trigger_caption_score_buy_apply'];
        $is_on_off_caption_score                     = true;
        $rule_on_off                                 = '<span style="background-color:yellow">OFF</span>';
        if ($is_on == 'yes') {
        if ($current_val == $recommended_value) {
        $is_on_off_caption_score = true;
        $rule_on_off             = '<span style="color:green">YES</span>';
        } else {
        $is_on_off_caption_score = false;
        $rule_on_off             = '<span style="color:red">NO</span>';
        }
        }
        $log_arr['caption_score_status']            = $rule_on_off;
        $log_arr['caption_score_recommended_value'] = $recommended_value;
        $log_arr['caption_score_current_value']     = $current_val . '<br>';*/
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        /* $current_val                                = $list_market_trends_arr['buy'];
        $recommended_value                          = $global_setting_arr['percentile_trigger_buy_trend_buy'];
        $is_on                                      = $global_setting_arr['percentile_trigger_buy_trend_buy_apply'];
        $is_on_off_buy                              = true;
        $rule_on_off                                = '<span style="background-color:yellow">OFF</span>';
        if ($is_on == 'yes') {
        if ($current_val >= $recommended_value) {
        $is_on_off_buy = true;
        $rule_on_off   = '<span style="color:green">YES</span>';
        } else {
        $is_on_off_buy = false;
        $rule_on_off   = '<span style="color:red">NO</span>';
        }
        }
        $log_arr['buy_status']            = $rule_on_off;
        $log_arr['buy_recommended_value'] = $recommended_value;
        $log_arr['buy_current_value']     = $current_val . '<br>';*/
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        /*  $current_val                      = $list_market_trends_arr['sell'];
        $recommended_value                = $global_setting_arr['percentile_trigger_sell_buy'];
        $is_on                            = $global_setting_arr['percentile_trigger_sell_buy_apply'];
        $is_on_off_sell                   = true;
        $rule_on_off                      = '<span style="background-color:yellow">OFF</span>';
        if ($is_on == 'yes') {
        if ($current_val < $recommended_value) {
        $is_on_off_sell = true;
        $rule_on_off    = '<span style="color:green">YES</span>';
        } else {
        $is_on_off_sell = false;
        $rule_on_off    = '<span style="color:red">NO</span>';
        }
        }
        $log_arr['sell_status']            = $rule_on_off;
        $log_arr['sell_recommended_value'] = $recommended_value;
        $log_arr['sell_current_value']     = $current_val . '<br>';*/
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        /*$current_val                       = $list_market_trends_arr['demand'];
        $recommended_value                 = $global_setting_arr['percentile_trigger_demand_buy'];
        $is_on                             = $global_setting_arr['percentile_trigger_demand_buy_apply'];
        $is_on_off_demand                  = true;
        $rule_on_off                       = '<span style="background-color:yellow">OFF</span>';
        if ($is_on == 'yes') {
        if ($current_val > $recommended_value) {
        $is_on_off_demand = true;
        $rule_on_off      = '<span style="color:green">YES</span>';
        } else {
        $is_on_off_demand = false;
        $rule_on_off      = '<span style="color:red">NO</span>';
        }
        }
        $log_arr['demand_status']            = $rule_on_off;
        $log_arr['demand_recommended_value'] = $recommended_value;
        $log_arr['demand_current_value']     = $current_val . '<br>';*/
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        /*  $current_val                         = $list_market_trends_arr['supply'];
        $recommended_value                   = $global_setting_arr['percentile_trigger_supply_buy'];
        $is_on                               = $global_setting_arr['percentile_trigger_supply_buy_apply'];
        $is_on_off_supply                    = true;
        $rule_on_off                         = '<span style="background-color:yellow">OFF</span>';
        if ($is_on == 'yes') {
        if ($current_val < $recommended_value) {
        $is_on_off_supply = true;
        $rule_on_off      = '<span style="color:green">YES</span>';
        } else {
        $is_on_off_supply = false;
        $rule_on_off      = '<span style="color:red">NO</span>';
        }
        }
        $log_arr['supply_status']            = $rule_on_off;
        $log_arr['supply_recommended_value'] = $recommended_value;
        $log_arr['supply_current_value']     = $current_val . '<br>';*/
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        /* $current_val                         = $list_market_trends_arr['market_trend'];
        $recommended_value                   = $global_setting_arr['percentile_trigger_market_trend_buy'];
        $is_on                               = $global_setting_arr['percentile_trigger_market_trend_buy_apply'];
        $is_on_off_market_trende             = true;
        $rule_on_off                         = '<span style="background-color:yellow">OFF</span>';
        if ($is_on == 'yes') {
        if ($current_val == $recommended_value) {
        $is_on_off_market_trende = true;
        $rule_on_off             = '<span style="color:green">YES</span>';
        } else {
        $is_on_off_market_trende = false;
        $rule_on_off             = '<span style="color:red">NO</span>';
        }
        }
        $log_arr['market_trend_status']            = $rule_on_off;
        $log_arr['market_trend_recommended_value'] = $recommended_value;
        $log_arr['market_trend_current_value']     = $current_val . '<br>';*/
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        /*  $current_val                               = $list_market_trends_arr['meta_trading'];
        $recommended_value                         = $global_setting_arr['percentile_trigger_meta_trading_buy'];
        $is_on                                     = $global_setting_arr['percentile_trigger_meta_trading_buy_apply'];
        $is_on_off_meta_trading                    = true;
        $rule_on_off                               = '<span style="background-color:yellow">OFF</span>';
        if ($is_on == 'yes') {
        if ($current_val > $recommended_value) {
        $is_on_off_meta_trading = true;
        $rule_on_off            = '<span style="color:green">YES</span>';
        } else {
        $is_on_off_meta_trading = false;
        $rule_on_off            = '<span style="color:red">NO</span>';
        }
        }
        $log_arr['market_meta_trading']            = $rule_on_off;
        $log_arr['meta_trading_recommended_value'] = $recommended_value;
        $log_arr['meta_trading_current_value']     = $current_val . '<br>';*/
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        /*$current_val                               = $list_market_trends_arr['riskpershare'];
        $recommended_value                         = $global_setting_arr['percentile_trigger_riskpershare_buy'];
        $is_on                                     = $global_setting_arr['percentile_trigger_riskpershare_buy_apply'];
        $is_on_off_riskpershare                    = true;
        $rule_on_off                               = '<span style="background-color:yellow">OFF</span>';
        if ($is_on == 'yes') {
        if ($current_val < $recommended_value) {
        $is_on_off_riskpershare = true;
        $rule_on_off            = '<span style="color:green">YES</span>';
        } else {
        $is_on_off_riskpershare = false;
        $rule_on_off            = '<span style="color:red">NO</span>';
        }
        }
        $log_arr['riskpershare_trading']           = $rule_on_off;
        $log_arr['riskpershare_recommended_value'] = $recommended_value;
        $log_arr['riskpershare_current_value']     = $current_val . '<br>';*/
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        /* $current_val                               = $list_market_trends_arr['RL'];
        $recommended_value                         = $global_setting_arr['percentile_trigger_RL_buy'];
        $is_on                                     = $global_setting_arr['percentile_trigger_RL_buy_apply'];
        $is_on_off_RL                              = true;
        $rule_on_off                               = '<span style="background-color:yellow">OFF</span>';
        if ($is_on == 'yes') {
        if ($current_val == $recommended_value) {
        $is_on_off_RL = true;
        $rule_on_off  = '<span style="color:green">YES</span>';
        } else {
        $is_on_off_RL = false;
        $rule_on_off  = '<span style="color:red">NO</span>';
        }
        }
        $log_arr['RL_trading']           = $rule_on_off;
        $log_arr['RL_recommended_value'] = $recommended_value;
        $log_arr['RL_current_value']     = $current_val . '<br>';*/
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        /* $current_val                     = $list_market_trends_arr['long_term_intension'];
        $recommended_value               = $global_setting_arr['percentile_trigger_long_term_intension_buy'];
        $is_on                           = $global_setting_arr['percentile_trigger_long_term_intension_buy_apply'];
        $is_on_off_long_term_intension   = true;
        $rule_on_off                     = '<span style="background-color:yellow">OFF</span>';
        if ($is_on == 'yes') {
        if ($current_val >= $recommended_value) {
        $is_on_off_long_term_intension = true;
        $rule_on_off                   = '<span style="color:green">YES</span>';
        } else {
        $is_on_off_long_term_intension = false;
        $rule_on_off                   = '<span style="color:red">NO</span>';
        }
        }
        $log_arr['long_term_intension_trading']           = $rule_on_off;
        $log_arr['long_term_intension_recommended_value'] = $recommended_value;
        $log_arr['long_term_intension_current_value']     = $current_val . '<br>';*/
        //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //%%%%%%%%%%%%%%%%%%%  End of market Trends %%%%%%%%%%%%%%%%%%%%%%
        $is_rules_true                                                  = 'NO';
        /*if ($last_200_contracts_qty_yes_no && $last_200_contracts_time_yes_no && $last_200_contracts_yes_no && $black_wall_yes_no && $virtual_barrier_yes_no && $seven_level_pressure_yes_no && $last_qty_contracts_time_yes_no && $is_buy_rule_on && $five_minute_rolling_candel_yes_no && $fifteen_minute_rolling_candel_yes_no && $meet_condition_for_buy && $buyers_yes_no && $sellers_yes_no && $candel_status_meet && $buy_percentile_yes_no && $ask_percentile_yes_no && $sell_percentile_yes_no && $bid_percentile_yes_no && $ask_contrc_percentile_yes_no && $bid_contrc_percentile_yes_no && $last_time_ago_15_m_yes_no && $virtual_barrier_ask_yes_no && $is_on_off_caption && $is_on_off_caption_score && $is_on_off_buy && $is_on_off_sell && $is_on_off_demand && $is_on_off_supply && $is_on_off_market_trende && $is_on_off_meta_trading && $is_on_off_riskpershare && $is_on_off_RL && $is_on_off_long_term_intension) {
        $is_rules_true = 'YES';
        }*/
        if ($last_200_contracts_qty_yes_no && $last_200_contracts_time_yes_no && $last_200_contracts_yes_no && $black_wall_yes_no && $virtual_barrier_yes_no && $seven_level_pressure_yes_no && $last_qty_contracts_time_yes_no && $is_buy_rule_on && $five_minute_rolling_candel_yes_no && $fifteen_minute_rolling_candel_yes_no && $meet_condition_for_buy && $buyers_yes_no && $sellers_yes_no && $candel_status_meet && $buy_percentile_yes_no && $ask_percentile_yes_no && $sell_percentile_yes_no && $bid_percentile_yes_no && $ask_contrc_percentile_yes_no && $bid_contrc_percentile_yes_no && $last_time_ago_15_m_yes_no && $virtual_barrier_ask_yes_no) {
            $is_rules_true = 'YES';
        }
        echo "<pre>";
        print_r($log_arr);
        //%%%%%%%%%%%%% -- Log Message -- %%%%%%%%%%%%  
        $log_msg = '';
        foreach ($log_arr as $key => $value) {
            $log_msg .= $key . '=>' . $value . '<br>';
        }
        $response['success_message'] = $is_rules_true;
        $response['log_message']     = $log_msg;
        return $response;
    } //End of is_triggers_qualify_to_buy_orders
    //======================================================================
    // Get all Rules settings against coin market_price
    //======================================================================
    public function market_price($symbol = '')
    {
        $this->mongo_db->where(array(
            'coin' => $symbol
        ));
        $this->mongo_db->limit(1);
        $this->mongo_db->sort(array(
            '_id' => 'desc'
        ));
        $responseArr = $this->mongo_db->get('market_prices');
        $price       = iterator_to_array($responseArr);
        $resp        = 0;
        if (!empty($price)) {
            $resp = (float) $price[0]['price'];
        }
        return num($resp);
    } //End of market_price
    //======================================================================
    // Get all Rules settings against coin check_candle_data
    //======================================================================
    public function check_candle_data($hour, $data_arr, $symbol)
    {
        $search_arr['coin']          = $symbol;
        $search_arr['timestampDate'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("-1 hour", strtotime($hour))));
        $this->mongo_db->where($search_arr);
        $this->mongo_db->limit(1000);
        $get = $this->mongo_db->get('coin_meta_history');
        $row = iterator_to_array($get);
        echo "<pre>";
        print_r($row);
        exit;
        $result               = $row[0];
        $curr_high            = $result['high'];
        $curr_low             = $result['low'];
        $current_market_price = ($curr_high + $curr_low) / 2;
        $status               = false;
        $swing                = false;
        $type                 = false;
        $move                 = false;
        $new                  = false;
        $condition            = false;
        if (empty($data_arr['swing_status']) || in_array($result['global_swing_status'], $data_arr['swing_status'])) {
            $swing = true;
        }
        if (empty($data_arr['candle_status']) || in_array($result['candel_status'], $data_arr['candle_status'])) {
            $status = true;
        }
        if (empty($data_arr['candle_type']) || in_array($result['candle_type'], $data_arr['candle_type'])) {
            $type = true;
        }
        if (empty($data_arr['move']) || $result['move'] >= $data_arr['move']) {
            $move = true;
        }
        if ($data_arr['candle_chk'] == 'yes') {
            $open    = $result['last_24_hour_open'];
            $close   = $result['last_24_hour_close'];
            $high    = $result['last_24_hour_high'];
            $low     = $result['last_24_hour_low'];
            $formula = $data_arr['formula'];
            if ($formula == 'highlow') {
                $distance    = (($high - $low) / 100) * $data_arr['candle_range'];
                $upper_range = $high - $distance;
                $lower_range = $low + $distance;
                if ($data_arr['candle_side'] == 'up') {
                    if ($current_market_price >= $upper_range && $current_market_price <= $high) {
                        $condition = true;
                    }
                } else {
                    if ($current_market_price <= $lower_range && $current_market_price >= $low) {
                        $condition = true;
                    }
                }
            } elseif ($formula == 'openclose') {
                if ($open > $close) {
                    $big   = $open;
                    $small = $close;
                } else {
                    $big   = $close;
                    $small = $open;
                }
                $distance = (($open - $close) / 100) * $data_arr['candle_range'];
                if ($data_arr['candle_side'] == 'up') {
                    if ($current_market_price >= $distance && $current_market_price <= $big) {
                        $condition = true;
                    }
                } else {
                    if ($current_market_price <= $distance && $current_market_price >= $small) {
                        $condition = true;
                    }
                }
            }
        } else {
            $condition = true;
        }
        if ($status && $swing && $type && $move && $condition) {
            $new = true;
        }
        return $new;
    } //check_candle_data
}
?>