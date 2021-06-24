<?php
/**
 *
 */
class Api_trigger_setting extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    public function api_percentile_setting() {
        $username = $this->input->server('PHP_AUTH_USER');
        $password = $this->input->server('PHP_AUTH_PW');

        $rule_active_values_arr = array('ON','OFF');
        $percentile_values_arr = array('1','2','3','4','5','6','7','8','9','10');
        $optional_fld_arr = array();
        
        $trigger_type = $this->input->post('trigger_type');

        if($trigger_type == ''){
            $message = 'Trigger name required';
            $type    = '403';
            $this->response($message, $type);
        }else if($trigger_type != 'percentile_trigger'){
            $message = 'Trigger name is wrong';
            $type    = '403';
            $this->response($message, $type);
        }

        $required_fld_arr['triggers_type'] = $trigger_type;

        $trigger_level = $this->input->post('level');
 
        if($trigger_level == ''){
            $message = 'Trigger level required';
            $type    = '403';
            $this->response($message, $type);
        }else if(!in_array($trigger_level,$percentile_values_arr)){
            $message = 'Trigger level Wrong';
            $type    = '403';
            $this->response($message, $type);
        }
        $required_fld_arr['trigger_level'] = 'level_'.$trigger_level;


        $trading_mode = strtolower($this->input->post('trading_mode'));
        $trading_mode_arr = array('live','test','test_simulator');
        if($trading_mode == ''){
            $message = 'Trading mode required';
            $type    = '403';
            $this->response($message, $type);
        }else if(!in_array($trading_mode,$trading_mode_arr)){
            $message = 'Trading mode Wrong';
            $type    = '403';
            $this->response($message, $type);
        }
        $required_fld_arr['order_mode'] = $trading_mode;




        


        $global_coins = $this->triggers_trades->list_system_global_coin();

        $coin_symbol = strtoupper($this->input->post('coin'));
    
        if($coin_symbol == ''){
            $message = 'coin symbol required';
            $type    = '403';
            $this->response($message, $type);
        }else if(!in_array($coin_symbol,$global_coins)){
            $message = 'coin symbol Wrong';
            $type    = '403';
            $this->response($message, $type);
        }
        $required_fld_arr['coin'] = $coin_symbol;


        $trading_type = strtolower($this->input->post('type'));

        
        $trading_type_arr = array('buy','sell','stop_loss');
        if($trading_type == ''){
            $message = 'trading type required';
            $type    = '403';
            $this->response($message, $type);
        }else if(!in_array($trading_type,$trading_type_arr)){
            $message = 'trading type Wrong';
            $type    = '403';
            $this->response($message, $type);
        }

        

        if($this->input->post('rule_active')){
            $rule_active = strtoupper($this->input->post('rule_active'));
           if(!in_array($rule_active,$rule_active_values_arr)){
                $message = 'rule_active_status  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['enable_buy_barrier_percentile'] = $rule_active;
            }
        }


        if($this->input->post('previous_candle_status')){
            $previous_candle_status = strtoupper($this->input->post('previous_candle_status'));
           if(!in_array($previous_candle_status,$rule_active_values_arr)){
                $message = 'candle status  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_is_previous_blue_candel'] = $previous_candle_status;
            }
        }

       
        $candle_typ_arr =  array('normal','demand','supply');
        if($this->input->post('previous_candle_type')){
            $previous_candle_type = strtolower($this->input->post('previous_candle_type'));
           if(!in_array($previous_candle_type,$candle_typ_arr)){
                $message = 'candle type  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_last_candle_type'] = $previous_candle_type;
            }
        }





        if($this->input->post('stop_loss_percentage')){
            $stop_loss_percentage = ($this->input->post('stop_loss_percentage'));
           if($stop_loss_percentage == ''){
                $message = 'stop loss percentage could not be empty';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($stop_loss_percentage)){
                $message = 'please enter correct stop loss percentage';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_default_stop_loss_percenage'] = $stop_loss_percentage;
            }
        }


        if($this->input->post('barrier_range_percentage')){
            $barrier_range_percentage = ($this->input->post('barrier_range_percentage'));
           if($barrier_range_percentage == ''){
                $message = 'barrier range percentage could not be empty';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($barrier_range_percentage)){
                $message = 'please enter correct barrier range percentage';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_barrier_range_percentage'] = $barrier_range_percentage;
            }
        }


        //%%%%%%%%%%%%%%%%%%%%%% -- black wall part  -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('black_wall_active')){
            $black_wall_active = strtoupper($this->input->post('black_wall_active'));
           if(!in_array($black_wall_active,$rule_active_values_arr)){
                $message = 'black_wall_active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($black_wall_active == ''){
                $message = 'black_wall_active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_black_wall_apply'] = $black_wall_active;
            }
        }


        if($this->input->post('black_wall_percentile_val')){
            $black_wall_percentile_val = $this->input->post('black_wall_percentile_val');
            if($black_wall_percentile_val == ''){
                $message = 'balack wall value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($black_wall_percentile_val,$percentile_values_arr)){
                $message = 'balack wall valuel Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_black_wall'] = $black_wall_percentile_val;
            }
        }

        //%%%%%%%%%%%% --  End of black wall part -- %%%%%%%%%%%%%%%%%%%





        //%%%%%%%%%%%%%%%%%%%%%% -- support barrier  -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('virtural_support_barrier_active')){
            $virtural_support_barrier_active = strtoupper($this->input->post('virtural_support_barrier_active'));
           if(!in_array($virtural_support_barrier_active,$rule_active_values_arr)){
                $message = 'support barrier active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($virtural_support_barrier_active == ''){
                $message = 'support barrier active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_virtual_barrier_apply'] = $virtural_support_barrier_active;
            }
        }


        if($this->input->post('virtural_support_barrier_val')){
            $virtural_support_barrier_val = $this->input->post('virtural_support_barrier_val');
            if($virtural_support_barrier_val == ''){
                $message = 'support barrier value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($virtural_support_barrier_val,$percentile_values_arr)){
                $message = 'support barrier valuel Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_virtual_barrier'] = $virtural_support_barrier_val;
            }
        }

        //%%%%%%%%%%%% --  End of support barrier -- %%%%%%%%%%%%%%%%%%%
        



         //%%%%%%%%%%%%%%%%%%%%%% -- resistance barrier  -- %%%%%%%%%%%%%%%%%%%%%
         if($this->input->post('virtural_resistance_barrier_active')){
            $virtural_resistance_barrier_active = strtoupper($this->input->post('virtural_resistance_barrier_active'));
           if(!in_array($virtural_resistance_barrier_active,$rule_active_values_arr)){
                $message = 'resistance barrier active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($virtural_resistance_barrier_active == ''){
                $message = 'resistance barrier active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_virtual_barrier_for_buy_apply'] = $virtural_resistance_barrier_active;
            }
        }


        if($this->input->post('virtual_resistance_barrier_val')){
            $virtual_resistance_barrier_val = $this->input->post('virtual_resistance_barrier_val');
            if($virtual_resistance_barrier_val == ''){
                $message = 'resistance barrier value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($virtual_resistance_barrier_val,$percentile_values_arr)){
                $message = 'resistance barrier valuel Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_virtual_barrier'] = $virtual_resistance_barrier_val;
            }
        }

        //%%%%%%%%%%%% --  End of resistance barrier -- %%%%%%%%%%%%%%%%%%%





        //%%%%%%%%%%%%%%%%%%%%%% -- seven level pressure  -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('seven_level_pressure_active')){
            $seven_level_pressure_active = strtoupper($this->input->post('seven_level_pressure_active'));
           if(!in_array($seven_level_pressure_active,$rule_active_values_arr)){
                $message = 'seven level pressure active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($seven_level_pressure_active == ''){
                $message = 'seven level pressure active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_seven_level_pressure_apply'] = $seven_level_pressure_active;
            }
        }


        if($this->input->post('seven_level_pressure_val')){
            $seven_level_pressure_val = $this->input->post('seven_level_pressure_val');
            if($seven_level_pressure_val == ''){
                $message = 'seven level pressure value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($seven_level_pressure_val,$percentile_values_arr)){
                $message = 'seven level pressure valuel Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_seven_level_pressure'] = $seven_level_pressure_val;
            }
        }

        //%%%%%%%%%%%% --  End of seven level pressure -- %%%%%%%%%%%%%%%%%%%



         //%%%%%%%%%%%%%%%%%%%%%% -- last 200 buy vs sell contracts  -- %%%%%%%%%%%%%%%%%%%%%
         if($this->input->post('last_200_buy_vs_sell_contract_active')){
            $last_200_buy_vs_sell_contract_active = strtoupper($this->input->post('last_200_buy_vs_sell_contract_active'));
           if(!in_array($last_200_buy_vs_sell_contract_active,$rule_active_values_arr)){
                $message = '200 buy vs sell contracts active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($last_200_buy_vs_sell_contract_active == ''){
                $message = '200 buy vs sell contracts active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell_apply'] = $last_200_buy_vs_sell_contract_active;
            }
        }


        if($this->input->post('last_200_buy_vs_sell_contract_val')){
            $last_200_buy_vs_sell_contract_val = $this->input->post('last_200_buy_vs_sell_contract_val');
            if($last_200_buy_vs_sell_contract_val == ''){
                $message = '200 buy vs sell contracts value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($last_200_buy_vs_sell_contract_val,$percentile_values_arr)){
                $message = '200 buy vs sell contracts valuel Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell'] = $last_200_buy_vs_sell_contract_val;
            }
        }

        //%%%%%%%%%%%% --  End of last 200 buy vs sell contracts -- %%%%%%%%%%%%%%%%%%%


         //%%%%%%%%%%%%%%%%%%%%%% --last 200 time  contracts  -- %%%%%%%%%%%%%%%%%%%%%
         if($this->input->post('last_200_contracts_time_active')){
            $last_200_contracts_time_active = strtoupper($this->input->post('last_200_contracts_time_active'));
           if(!in_array($last_200_contracts_time_active,$rule_active_values_arr)){
                $message = '200 buy vs sell contracts active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($last_200_contracts_time_active == ''){
                $message = '200 buy vs sell contracts active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_last_200_contracts_time_apply'] = $last_200_contracts_time_active;
            }
        }


        if($this->input->post('last_200_contracts_time_val')){
            $last_200_contracts_time_val = $this->input->post('last_200_contracts_time_val');
            if($last_200_contracts_time_val == ''){
                $message = '200 time contracts value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($last_200_contracts_time_val,$percentile_values_arr)){
                $message = '200 time contracts value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_last_200_contracts_time'] = $last_200_contracts_time_val;
            }
        }

        //%%%%%%%%%%%% --  End of last 200 time  contracts -- %%%%%%%%%%%%%%%%%%%
       




        //%%%%%%%%%%%%%%%%%%%%%% -- Qty contracts buy vs sell  -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('last_qty_contracts_buy_vs_sellers_active')){
            $last_qty_contracts_buy_vs_sellers_active = strtoupper($this->input->post('last_qty_contracts_buy_vs_sellers_active'));
           if(!in_array($last_qty_contracts_buy_vs_sellers_active,$rule_active_values_arr)){
                $message = 'qty buyer vs seller contracts active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($last_qty_contracts_buy_vs_sellers_active == ''){
                $message = 'qty buyer vs seller contracts active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller_apply'] = $last_qty_contracts_buy_vs_sellers_active;
            }
        }


        if($this->input->post('last_qty_contracts_buy_vs_sellers_val')){
            $last_qty_contracts_buy_vs_sellers_val = $this->input->post('last_qty_contracts_buy_vs_sellers_val');
            if($last_qty_contracts_buy_vs_sellers_val == ''){
                $message = 'qty buyer vs selle contracts value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($last_qty_contracts_buy_vs_sellers_val,$percentile_values_arr)){
                $message = 'qty buyer vs selle contracts value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller'] = $last_qty_contracts_buy_vs_sellers_val;
            }
        }

        //%%%%%%%%%%%% --  End of Qty contracts buy vs sell -- %%%%%%%%%%%%%%%%%%%



         //%%%%%%%%%%%%%%%%%%%%%% -- last Qty contracts time -- %%%%%%%%%%%%%%%%%%%%%
         if($this->input->post('last_qty_contracts_time_active')){
            $last_qty_contracts_time_active = strtoupper($this->input->post('last_qty_contracts_time_active'));
           if(!in_array($last_qty_contracts_time_active,$rule_active_values_arr)){
                $message = 'last Qty contracts time active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($last_qty_contracts_time_active == ''){
                $message = 'last Qty contracts time active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_last_qty_contracts_time_apply'] = $last_qty_contracts_time_active;
            }
        }


        if($this->input->post('last_qty_contracts_time_val')){
            $last_qty_contracts_time_val = $this->input->post('last_qty_contracts_time_val');
            if($last_qty_contracts_time_val == ''){
                $message = 'last Qty contracts time value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($last_qty_contracts_time_val,$percentile_values_arr)){
                $message = 'last Qty contracts time value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_last_qty_contracts_time'] = $last_qty_contracts_time_val;
            }
        }

        //%%%%%%%%%%%% --  End of last Qty contracts time -- %%%%%%%%%%%%%%%%%%%




        //%%%%%%%%%%%%%%%%%%%%%% -- 5 minute rolling candle -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('five_minute_rolling_candle_active')){
            $five_minute_rolling_candle_active = strtoupper($this->input->post('five_minute_rolling_candle_active'));
           if(!in_array($five_minute_rolling_candle_active,$rule_active_values_arr)){
                $message = '5 minute rolling candle active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($five_minute_rolling_candle_active == ''){
                $message = '5 minute rolling candle active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_5_minute_rolling_candel_apply'] = $five_minute_rolling_candle_active;
            }
        }


        if($this->input->post('five_minute_rolling_candle_val')){
            $five_minute_rolling_candle_val = $this->input->post('five_minute_rolling_candle_val');
            if($five_minute_rolling_candle_val == ''){
                $message = '5 minute rolling candle value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($five_minute_rolling_candle_val,$percentile_values_arr)){
                $message = '5 minute rolling candle value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_5_minute_rolling_candel'] = $five_minute_rolling_candle_val;
            }
        }

        //%%%%%%%%%%%% --  End of 5 minute rolling candle -- %%%%%%%%%%%%%%%%%%%





        //%%%%%%%%%%%%%%%%%%%%%% -- 15 minute rolling candle -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('rolling_candle_15_m_active')){
            $rolling_candle_15_m_active = strtoupper($this->input->post('rolling_candle_15_m_active'));
           if(!in_array($rolling_candle_15_m_active,$rule_active_values_arr)){
                $message = '15 minute rolling candle active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($rolling_candle_15_m_active == ''){
                $message = '5 minute rolling candle active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_15_minute_rolling_candel_apply'] = $rolling_candle_15_m_active;
            }
        }


        if($this->input->post('rolling_candle_15_m_val')){
            $rolling_candle_15_m_val = $this->input->post('rolling_candle_15_m_val');
            if($rolling_candle_15_m_val == ''){
                $message = '15 minute rolling candle value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($rolling_candle_15_m_val,$percentile_values_arr)){
                $message = '15 minute rolling candle value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_15_minute_rolling_candel'] = $rolling_candle_15_m_val;
            }
        }

        //%%%%%%%%%%%% --  End of 15 minute rolling candle -- %%%%%%%%%%%%%%%%%%%




         //%%%%%%%%%%%%%%%%%%%%%% -- buyers -- %%%%%%%%%%%%%%%%%%%%%
         if($this->input->post('buyers_active')){
            $buyers_active = strtoupper($this->input->post('buyers_active'));
           if(!in_array($buyers_active,$rule_active_values_arr)){
                $message = 'buyers active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($buyers_active == ''){
                $message = 'buyers active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buyers_buy_apply'] = $buyers_active;
            }
        }


        if($this->input->post('buyers_val')){
            $buyers_val = $this->input->post('buyers_val');
            if($buyers_val == ''){
                $message = 'buyers value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($buyers_val,$percentile_values_arr)){
                $message = 'buyers value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buyers_buy'] = $buyers_val;
            }
        }

        //%%%%%%%%%%%% --  End of buyers -- %%%%%%%%%%%%%%%%%%%






        //%%%%%%%%%%%%%%%%%%%%%% -- sellers -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('sellers_active')){
            $sellers_active = strtoupper($this->input->post('sellers_active'));
           if(!in_array($sellers_active,$rule_active_values_arr)){
                $message = 'sellers active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($sellers_active == ''){
                $message = 'sellers active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sellers_buy_apply'] = $sellers_active;
            }
        }


        if($this->input->post('sellers_val')){
            $sellers_val = $this->input->post('sellers_val');
            if($sellers_val == ''){
                $message = 'sellers value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($sellers_val,$percentile_values_arr)){
                $message = 'sellers value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sellers_buy'] = $sellers_val;
            }
        }

        //%%%%%%%%%%%% --  End of sellers -- %%%%%%%%%%%%%%%%%%%




        //%%%%%%%%%%%%%%%%%%%%%% -- last time age 15 m -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('last_time_ago_15_m_active')){
            $last_time_ago_15_m_active = strtoupper($this->input->post('last_time_ago_15_m_active'));
           if(!in_array($last_time_ago_15_m_active,$rule_active_values_arr)){
                $message = 'last time age 15 m active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($last_time_ago_15_m_active == ''){
                $message = 'last time age 15 m active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_15_minute_last_time_ago_apply'] = $last_time_ago_15_m_active;
            }
        }


        if($this->input->post('last_time_ago_15_m_val')){
            $last_time_ago_15_m_val = $this->input->post('last_time_ago_15_m_val');
            if($last_time_ago_15_m_val == ''){
                $message = 'last time age 15 m value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($last_time_ago_15_m_val,$percentile_values_arr)){
                $message = 'last time age 15 m value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_15_minute_last_time_ago'] = $last_time_ago_15_m_val;
            }
        }

        //%%%%%%%%%%%% --  End of last time age 15 m-- %%%%%%%%%%%%%%%%%%%






        //%%%%%%%%%%%%%%%%%%%%%% --  ask -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('ask_active')){
            $ask_active = strtoupper($this->input->post('ask_active'));
           if(!in_array($ask_active,$rule_active_values_arr)){
                $message = 'ask active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($ask_active == ''){
                $message = 'ask active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_ask_apply'] = $ask_active;
            }
        }


        if($this->input->post('ask_val')){
            $ask_val = $this->input->post('ask_val');
            if($ask_val == ''){
                $message = 'ask value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($ask_val,$percentile_values_arr)){
                $message = 'ask value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_ask'] = $ask_val;
            }
        }

        //%%%%%%%%%%%% --  End of ask-- %%%%%%%%%%%%%%%%%%%





        //%%%%%%%%%%%%%%%%%%%%%% --  bid -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('bid_active')){
            $bid_active = strtoupper($this->input->post('bid_active'));
           if(!in_array($bid_active,$rule_active_values_arr)){
                $message = 'bid active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($bid_active == ''){
                $message = 'bid active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_bid_apply'] = $bid_active;
            }
        }


        if($this->input->post('bid_val')){
            $bid_val = $this->input->post('bid_val');
            if($bid_val == ''){
                $message = 'bid value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($bid_val,$percentile_values_arr)){
                $message = 'bid value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_bid'] = $bid_val;
            }
        }

        //%%%%%%%%%%%% --  End of ask-- %%%%%%%%%%%%%%%%%%%







        //%%%%%%%%%%%%%%%%%%%%%% --  BUY -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('buy_active')){
            $buy_active = strtoupper($this->input->post('buy_active'));
           if(!in_array($buy_active,$rule_active_values_arr)){
                $message = 'buy active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($buy_active == ''){
                $message = 'buy active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_apply'] = $buy_active;
            }
        }


        if($this->input->post('buy_val')){
            $buy_val = $this->input->post('buy_val');
            if($buy_val == ''){
                $message = 'buy value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($buy_val,$percentile_values_arr)){
                $message = 'buy value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy'] = $buy_val;
            }
        }

        //%%%%%%%%%%%% --  End of BUY-- %%%%%%%%%%%%%%%%%%%






        //%%%%%%%%%%%%%%%%%%%%%% --  sell -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('sell_active')){
            $sell_active = strtoupper($this->input->post('sell_active'));
           if(!in_array($sell_active,$rule_active_values_arr)){
                $message = 'buy active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($sell_active == ''){
                $message = 'buy active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_apply'] = $sell_active;
            }
        }


        if($this->input->post('sell_val')){
            $sell_val = $this->input->post('sell_val');
            if($sell_val == ''){
                $message = 'buy value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($sell_val,$percentile_values_arr)){
                $message = 'buy value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell'] = $sell_val;
            }
        }

        //%%%%%%%%%%%% --  End of sell-- %%%%%%%%%%%%%%%%%%%




        //%%%%%%%%%%%%%%%%%%%%%% --  ask contracts -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('ask_contracts_active')){
            $ask_contracts_active = strtoupper($this->input->post('ask_contracts_active'));
           if(!in_array($ask_contracts_active,$rule_active_values_arr)){
                $message = 'ask contracts active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($ask_contracts_active == ''){
                $message = 'ask contracts active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_ask_contracts_apply'] = $ask_contracts_active;
            }
        }


        if($this->input->post('ask_contracts_val')){
            $ask_contracts_val = $this->input->post('ask_contracts_val');
            if($ask_contracts_val == ''){
                $message = 'ask contracts value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($ask_contracts_val,$percentile_values_arr)){
                $message = 'ask contracts value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_ask_contracts'] = $ask_contracts_val;
            }
        }

        //%%%%%%%%%%%% --  End of Ask contracts-- %%%%%%%%%%%%%%%%%%%





        //%%%%%%%%%%%%%%%%%%%%%% --  bid contracts -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('bid_contracts_active')){
            $bid_contracts_active = strtoupper($this->input->post('bid_contracts_active'));
           if(!in_array($bid_contracts_active,$rule_active_values_arr)){
                $message = 'bid contracts active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($bid_contracts_active == ''){
                $message = 'bid contracts active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_bid_contracts_apply'] = $bid_contracts_active;
            }
        }


        if($this->input->post('bid_contracts_val')){
            $bid_contracts_val = $this->input->post('bid_contracts_val');
            if($bid_contracts_val == ''){
                $message = 'bid contracts value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($bid_contracts_val,$percentile_values_arr)){
                $message = 'bid contracts value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_bid_contracts'] = $bid_contracts_val;
            }
        }

        //%%%%%%%%%%%% --  End of Bid contracts-- %%%%%%%%%%%%%%%%%%%



        //%%%%%%%%%%%%%%%%%%%%%% -- caption option -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('caption_option_active')){
            $caption_option_active = strtoupper($this->input->post('caption_option_active'));
           if(!in_array($caption_option_active,$rule_active_values_arr)){
                $message = 'caption option active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($caption_option_active == ''){
                $message = 'caption option active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_caption_option_buy_apply'] = $caption_option_active;
            }
        }


        if($this->input->post('caption_option_val')){
            $caption_option_val = $this->input->post('caption_option_val');
             if($caption_option_val == ''){
                $message = 'caption option required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($caption_option_val)){
                $message = 'please enter correct caption option';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_caption_option_buy'] = $caption_option_val;
            }
        }

        //%%%%%%%%%%%% --  End of Caption Option -- %%%%%%%%%%%%%%%%%%%





        //%%%%%%%%%%%%%%%%%%%%%% -- caption score -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('caption_score_active')){
            $caption_score_active = strtoupper($this->input->post('caption_score_active'));
           if(!in_array($caption_score_active,$rule_active_values_arr)){
                $message = 'caption score active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($caption_score_active == ''){
                $message = 'caption score active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_caption_score_buy_apply'] = $caption_score_active;
            }
        }


        if($this->input->post('caption_score_val')){
            $caption_score_val = $this->input->post('caption_score_val');
             if($caption_score_val == ''){
                $message = 'caption score required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($caption_score_val)){
                $message = 'please enter correct caption score';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_caption_score_buy'] = $caption_score_val;
            }
        }

        //%%%%%%%%%%%% --  End of Caption Option -- %%%%%%%%%%%%%%%%%%%



         //%%%%%%%%%%%%%%%%%%%%%% -- buy market trend -- %%%%%%%%%%%%%%%%%%%%%
         if($this->input->post('buy_market_trend_active')){
            $buy_market_trend_active = strtoupper($this->input->post('buy_market_trend_active'));
           if(!in_array($buy_market_trend_active,$rule_active_values_arr)){
                $message = 'buy market trendactive value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($buy_market_trend_active == ''){
                $message = 'buy market trend active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_buy_trend_buy_apply'] = $buy_market_trend_active;
            }
        }


        if($this->input->post('buy_market_trend_val')){
            $buy_market_trend_val = $this->input->post('buy_market_trend_val');
             if($buy_market_trend_val == ''){
                $message = 'buy market trend required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($buy_market_trend_val)){
                $message = 'please enter correct buy market trend';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_buy_trend_buy'] = $buy_market_trend_val;
            }
        }

        //%%%%%%%%%%%% --  End of buy market trend -- %%%%%%%%%%%%%%%%%%%




         //%%%%%%%%%%%%%%%%%%%%%% -- sell market trend -- %%%%%%%%%%%%%%%%%%%%%
         if($this->input->post('sell_market_trend_active')){
            $sell_market_trend_active = strtoupper($this->input->post('sell_market_trend_active'));
           if(!in_array($sell_market_trend_active,$rule_active_values_arr)){
                $message = 'sell market trendactive value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($sell_market_trend_active == ''){
                $message = 'sell market trend active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_sell_buy_apply'] = $sell_market_trend_active;
            }
        }


        if($this->input->post('sell_market_trend_val')){
            $sell_market_trend_val = $this->input->post('sell_market_trend_val');
             if($sell_market_trend_val == ''){
                $message = 'sell market trend required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($sell_market_trend_val)){
                $message = 'please enter correct sell market trend';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_sell_buy'] = $sell_market_trend_val;
            }
        }

        //%%%%%%%%%%%% --  End of sell market trend -- %%%%%%%%%%%%%%%%%%%



        //%%%%%%%%%%%%%%%%%%%%%% -- demand market trend -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('demand_market_trend_active')){
            $demand_market_trend_active = strtoupper($this->input->post('demand_market_trend_active'));
           if(!in_array($demand_market_trend_active,$rule_active_values_arr)){
                $message = 'demand market trendactive value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($demand_market_trend_active == ''){
                $message = 'demand market trend active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_demand_buy_apply'] = $demand_market_trend_active;
            }
        }


        if($this->input->post('demand_market_trend_val')){
            $demand_market_trend_val = $this->input->post('demand_market_trend_val');
             if($demand_market_trend_val == ''){
                $message = 'demand market trend required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($demand_market_trend_val)){
                $message = 'please enter correct demand market trend';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_demand_buy'] = $demand_market_trend_val;
            }
        }

        //%%%%%%%%%%%% --  End of demand market trend -- %%%%%%%%%%%%%%%%%%%




        //%%%%%%%%%%%%%%%%%%%%%% -- supply market trend -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('supply_market_trend_active')){
            $supply_market_trend_active = strtoupper($this->input->post('supply_market_trend_active'));
           if(!in_array($supply_market_trend_active,$rule_active_values_arr)){
                $message = 'supply market trendactive value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($supply_market_trend_active == ''){
                $message = 'supply market trend active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_supply_buy_apply'] = $supply_market_trend_active;
            }
        }


        if($this->input->post('supply_market_trend_val')){
            $supply_market_trend_val = $this->input->post('supply_market_trend_val');
             if($supply_market_trend_val == ''){
                $message = 'supply market trend required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($supply_market_trend_val)){
                $message = 'please enter correct supply market trend';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_supply_buy'] = $supply_market_trend_val;
            }
        }

        //%%%%%%%%%%%% --  End of supply market trend -- %%%%%%%%%%%%%%%%%%%




        //%%%%%%%%%%%%%%%%%%%%%% --  market trend -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('market_trend_active')){
            $market_trend_active = strtoupper($this->input->post('market_trend_active'));
           if(!in_array($market_trend_active,$rule_active_values_arr)){
                $message = ' market trenda ctive value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($market_trend_active == ''){
                $message = ' market trend active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_market_trend_buy_apply'] = $market_trend_active;
            }
        }


        if($this->input->post('market_trend_val')){
            $market_trend_val = strtoupper($this->input->post('market_trend_val'));
             if($market_trend_val == ''){
                $message = ' market trend required';
                $type    = '403';
                $this->response($message, $type);
            }else if( ($market_trend_val !='POSITIVE') || ($market_trend_val !='NEGATIVE') ){
                $message = 'please enter correct  market trend';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_market_trend_buy'] = $market_trend_val;
            }
        }

        //%%%%%%%%%%%% --  End of  market trend -- %%%%%%%%%%%%%%%%%%%





        //%%%%%%%%%%%%%%%%%%%%%% --  meta trading -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('meta_trading_active')){
            $meta_trading_active = strtoupper($this->input->post('meta_trading_active'));
           if(!in_array($meta_trading_active,$rule_active_values_arr)){
                $message = 'Meta trading  active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($meta_trading_active == ''){
                $message = ' meta trading  active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_meta_trading_buy_apply'] = $meta_trading_active;
            }
        }


        if($this->input->post('meta_trading_val')){
            $meta_trading_val = $this->input->post('meta_trading_val');
             if($meta_trading_val == ''){
                $message = 'meta trading value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($meta_trading_val)){
                $message = 'please enter correct meta trading value';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_meta_trading_buy'] = $meta_trading_val;
            }
        }

        //%%%%%%%%%%%% --  End of meta trading -- %%%%%%%%%%%%%%%%%%%



        //%%%%%%%%%%%%%%%%%%%%%% --  risk per share -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('riskpershare_active')){
            $riskpershare_active = strtoupper($this->input->post('riskpershare_active'));
           if(!in_array($riskpershare_active,$rule_active_values_arr)){
                $message = 'riskpershare active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($riskpershare_active == ''){
                $message = ' riskpershare active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_riskpershare_buy_apply'] = $riskpershare_active;
            }
        }


        if($this->input->post('riskpershare_val')){
            $riskpershare_val = $this->input->post('riskpershare_val');
             if($riskpershare_val == ''){
                $message = 'riskpershare value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($riskpershare_val)){
                $message = 'please enter correct riskpershare value';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_riskpershare_buy'] = $riskpershare_val;
            }
        }

        //%%%%%%%%%%%% --  End of riskpershare -- %%%%%%%%%%%%%%%%%%%



        //%%%%%%%%%%%%%%%%%%%%%% --  RL -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('RL_active')){
            $RL_active = strtoupper($this->input->post('RL_active'));
           if(!in_array($RL_active,$rule_active_values_arr)){
                $message = 'RL active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($RL_active == ''){
                $message = ' RL active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_RL_buy_apply'] = $RL_active;
            }
        }


        if($this->input->post('RL_val')){
            $RL_val = $this->input->post('RL_val');
             if($RL_val == ''){
                $message = 'RL value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($RL_val)){
                $message = 'please enter correct RL value';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_RL_buy'] = $RL_val;
            }
        }

        //%%%%%%%%%%%% --  End of RL -- %%%%%%%%%%%%%%%%%%%

        if(empty($optional_fld_arr)){
            $message = 'Atlease One value   required';
            $type    = '403';
            $this->response($message, $type);
        }

       

    
        if ($username == 'digiebot' && $password == 'digiebot' || true) {
            $coin = $this->input->post('symbol');
            $ip   = getenv('HTTP_CLIENT_IP') ?:
            getenv('HTTP_X_FORWARDED_FOR') ?:
            getenv('HTTP_X_FORWARDED') ?:
            getenv('HTTP_FORWARDED_FOR') ?:
            getenv('HTTP_FORWARDED') ?:
            getenv('REMOTE_ADDR');



            if ($ip == '45.115.84.51' || true) {
               
                $db = $this->mongo_db->customQuery();
                $db = $db->trigger_global_setting->updateOne($required_fld_arr,$optional_fld_arr,array('upsert'=>true));
                $message   = 'percentile trigger setting updated successfully';
                $type      = '200';
                $this->response($message, $type);
            } else {
                $message = 'You are not allowed To Access this';
                $type    = '403';
                $this->response($message, $type);
            }

        } else {

            $message = 'Sorry You are not Authorized';
            $type    = '401';
            $this->response($message, $type);

            //echo $orders_arr_arr = $this->mod_coins_info->save_coins_info();
        }

    } //end Coin meta Function



    public function api_percentile_setting_sell() {
        $username = $this->input->server('PHP_AUTH_USER');
        $password = $this->input->server('PHP_AUTH_PW');

        $rule_active_values_arr = array('ON','OFF');
        $percentile_values_arr = array('1','2','3','4','5','6','7','8','9','10');
        $optional_fld_arr = array();
        
        $trigger_type = $this->input->post('trigger_type');

        if($trigger_type == ''){
            $message = 'Trigger name required';
            $type    = '403';
            $this->response($message, $type);
        }else if($trigger_type != 'percentile_trigger'){
            $message = 'Trigger name is wrong';
            $type    = '403';
            $this->response($message, $type);
        }

        $required_fld_arr['triggers_type'] = $trigger_type;

        $trigger_level = $this->input->post('level');
 
        if($trigger_level == ''){
            $message = 'Trigger level required';
            $type    = '403';
            $this->response($message, $type);
        }else if(!in_array($trigger_level,$percentile_values_arr)){
            $message = 'Trigger level Wrong';
            $type    = '403';
            $this->response($message, $type);
        }
        $required_fld_arr['trigger_level'] = 'level_'.$trigger_level;





        $trading_mode = strtolower($this->input->post('trading_mode'));
        $trading_mode_arr = array('live','test','test_simulator');
        if($trading_mode == ''){
            $message = 'Trading mode required';
            $type    = '403';
            $this->response($message, $type);
        }else if(!in_array($trading_mode,$trading_mode_arr)){
            $message = 'Trading mode Wrong';
            $type    = '403';
            $this->response($message, $type);
        }
        $required_fld_arr['order_mode'] = $trading_mode;




        


        $global_coins = $this->triggers_trades->list_system_global_coin();

        $coin_symbol = strtoupper($this->input->post('coin'));
    
        if($coin_symbol == ''){
            $message = 'coin symbol required';
            $type    = '403';
            $this->response($message, $type);
        }else if(!in_array($coin_symbol,$global_coins)){
            $message = 'coin symbol Wrong';
            $type    = '403';
            $this->response($message, $type);
        }
        $required_fld_arr['coin'] = $coin_symbol;


        $trading_type = strtolower($this->input->post('type'));

        
        $trading_type_arr = array('buy','sell','stop_loss');
        if($trading_type == ''){
            $message = 'trading type required';
            $type    = '403';
            $this->response($message, $type);
        }else if(!in_array($trading_type,$trading_type_arr)){
            $message = 'trading type Wrong';
            $type    = '403';
            $this->response($message, $type);
        }

        

        if($this->input->post('rule_active')){
            $rule_active = strtoupper($this->input->post('rule_active'));
           if(!in_array($rule_active,$rule_active_values_arr)){
                $message = 'rule_active_status  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['enable_sell_barrier_percentile'] = $rule_active;
            }
        }


        if($this->input->post('previous_candle_status')){
            $previous_candle_status = strtoupper($this->input->post('previous_candle_status'));
           if(!in_array($previous_candle_status,$rule_active_values_arr)){
                $message = 'candle status  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_is_previous_blue_candel'] = $previous_candle_status;
            }
        }

       
        $candle_typ_arr =  array('normal','demand','supply');
        if($this->input->post('previous_candle_type')){
            $previous_candle_type = strtolower($this->input->post('previous_candle_type'));
           if(!in_array($previous_candle_type,$candle_typ_arr)){
                $message = 'candle type  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_last_candle_type'] = $previous_candle_type;
            }
        }





        if($this->input->post('stop_loss_percentage')){
            $stop_loss_percentage = ($this->input->post('stop_loss_percentage'));
           if($stop_loss_percentage == ''){
                $message = 'stop loss percentage could not be empty';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($stop_loss_percentage)){
                $message = 'please enter correct stop loss percentage';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_default_stop_loss_percenage'] = $stop_loss_percentage;
            }
        }


        if($this->input->post('barrier_range_percentage')){
            $barrier_range_percentage = ($this->input->post('barrier_range_percentage'));
           if($barrier_range_percentage == ''){
                $message = 'barrier range percentage could not be empty';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($barrier_range_percentage)){
                $message = 'please enter correct barrier range percentage';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_barrier_range_percentage'] = $barrier_range_percentage;
            }
        }


        //%%%%%%%%%%%%%%%%%%%%%% -- black wall part  -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('black_wall_active')){
            $black_wall_active = strtoupper($this->input->post('black_wall_active'));
           if(!in_array($black_wall_active,$rule_active_values_arr)){
                $message = 'black_wall_active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($black_wall_active == ''){
                $message = 'black_wall_active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_black_wall_apply'] = $black_wall_active;
            }
        }


        if($this->input->post('black_wall_percentile_val')){
            $black_wall_percentile_val = $this->input->post('black_wall_percentile_val');
            if($black_wall_percentile_val == ''){
                $message = 'balack wall value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($black_wall_percentile_val,$percentile_values_arr)){
                $message = 'balack wall valuel Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_black_wall'] = $black_wall_percentile_val;
            }
        }

        //%%%%%%%%%%%% --  End of black wall part -- %%%%%%%%%%%%%%%%%%%





        //%%%%%%%%%%%%%%%%%%%%%% -- support barrier  -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('virtural_support_barrier_active')){
            $virtural_support_barrier_active = strtoupper($this->input->post('virtural_support_barrier_active'));
           if(!in_array($virtural_support_barrier_active,$rule_active_values_arr)){
                $message = 'support barrier active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($virtural_support_barrier_active == ''){
                $message = 'support barrier active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_virtual_barrier_for_sell_apply'] = $virtural_support_barrier_active;
            }
        }


        if($this->input->post('virtural_support_barrier_val')){
            $virtural_support_barrier_val = $this->input->post('virtural_support_barrier_val');
            if($virtural_support_barrier_val == ''){
                $message = 'support barrier value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($virtural_support_barrier_val,$percentile_values_arr)){
                $message = 'support barrier valuel Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_virtual_barrier_for_sell'] = $virtural_support_barrier_val;
            }
        }

        //%%%%%%%%%%%% --  End of support barrier -- %%%%%%%%%%%%%%%%%%%
        



         //%%%%%%%%%%%%%%%%%%%%%% -- resistance barrier  -- %%%%%%%%%%%%%%%%%%%%%
         if($this->input->post('virtural_resistance_barrier_active')){
            $virtural_resistance_barrier_active = strtoupper($this->input->post('virtural_resistance_barrier_active'));
           if(!in_array($virtural_resistance_barrier_active,$rule_active_values_arr)){
                $message = 'resistance barrier active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($virtural_resistance_barrier_active == ''){
                $message = 'resistance barrier active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_virtual_barrier_apply'] = $virtural_resistance_barrier_active;
            }
        }


        if($this->input->post('virtual_resistance_barrier_val')){
            $virtual_resistance_barrier_val = $this->input->post('virtual_resistance_barrier_val');
            if($virtual_resistance_barrier_val == ''){
                $message = 'resistance barrier value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($virtual_resistance_barrier_val,$percentile_values_arr)){
                $message = 'resistance barrier valuel Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_virtual_barrier'] = $virtual_resistance_barrier_val;
            }
        }

        //%%%%%%%%%%%% --  End of resistance barrier -- %%%%%%%%%%%%%%%%%%%





        //%%%%%%%%%%%%%%%%%%%%%% -- seven level pressure  -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('seven_level_pressure_active')){
            $seven_level_pressure_active = strtoupper($this->input->post('seven_level_pressure_active'));
           if(!in_array($seven_level_pressure_active,$rule_active_values_arr)){
                $message = 'seven level pressure active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($seven_level_pressure_active == ''){
                $message = 'seven level pressure active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_seven_level_pressure_apply'] = $seven_level_pressure_active;
            }
        }


        if($this->input->post('seven_level_pressure_val')){
            $seven_level_pressure_val = $this->input->post('seven_level_pressure_val');
            if($seven_level_pressure_val == ''){
                $message = 'seven level pressure value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($seven_level_pressure_val,$percentile_values_arr)){
                $message = 'seven level pressure valuel Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_seven_level_pressure'] = $seven_level_pressure_val;
            }
        }

        //%%%%%%%%%%%% --  End of seven level pressure -- %%%%%%%%%%%%%%%%%%%



         //%%%%%%%%%%%%%%%%%%%%%% -- last 200 buy vs sell contracts  -- %%%%%%%%%%%%%%%%%%%%%
         if($this->input->post('last_200_buy_vs_sell_contract_active')){
            $last_200_buy_vs_sell_contract_active = strtoupper($this->input->post('last_200_buy_vs_sell_contract_active'));
           if(!in_array($last_200_buy_vs_sell_contract_active,$rule_active_values_arr)){
                $message = '200 buy vs sell contracts active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($last_200_buy_vs_sell_contract_active == ''){
                $message = '200 buy vs sell contracts active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell_apply'] = $last_200_buy_vs_sell_contract_active;
            }
        }


        if($this->input->post('last_200_buy_vs_sell_contract_val')){
            $last_200_buy_vs_sell_contract_val = $this->input->post('last_200_buy_vs_sell_contract_val');
            if($last_200_buy_vs_sell_contract_val == ''){
                $message = '200 buy vs sell contracts value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($last_200_buy_vs_sell_contract_val,$percentile_values_arr)){
                $message = '200 buy vs sell contracts valuel Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell'] = $last_200_buy_vs_sell_contract_val;
            }
        }

        //%%%%%%%%%%%% --  End of last 200 buy vs sell contracts -- %%%%%%%%%%%%%%%%%%%


         //%%%%%%%%%%%%%%%%%%%%%% --last 200 time  contracts  -- %%%%%%%%%%%%%%%%%%%%%
         if($this->input->post('last_200_contracts_time_active')){
            $last_200_contracts_time_active = strtoupper($this->input->post('last_200_contracts_time_active'));
           if(!in_array($last_200_contracts_time_active,$rule_active_values_arr)){
                $message = '200 buy vs sell contracts active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($last_200_contracts_time_active == ''){
                $message = '200 buy vs sell contracts active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_last_200_contracts_time_apply'] = $last_200_contracts_time_active;
            }
        }


        if($this->input->post('last_200_contracts_time_val')){
            $last_200_contracts_time_val = $this->input->post('last_200_contracts_time_val');
            if($last_200_contracts_time_val == ''){
                $message = '200 time contracts value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($last_200_contracts_time_val,$percentile_values_arr)){
                $message = '200 time contracts value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_last_200_contracts_time'] = $last_200_contracts_time_val;
            }
        }

        //%%%%%%%%%%%% --  End of last 200 time  contracts -- %%%%%%%%%%%%%%%%%%%
       




        //%%%%%%%%%%%%%%%%%%%%%% -- Qty contracts buy vs sell  -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('last_qty_contracts_buy_vs_sellers_active')){
            $last_qty_contracts_buy_vs_sellers_active = strtoupper($this->input->post('last_qty_contracts_buy_vs_sellers_active'));
           if(!in_array($last_qty_contracts_buy_vs_sellers_active,$rule_active_values_arr)){
                $message = 'qty buyer vs seller contracts active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($last_qty_contracts_buy_vs_sellers_active == ''){
                $message = 'qty buyer vs seller contracts active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller_apply'] = $last_qty_contracts_buy_vs_sellers_active;
            }
        }


        if($this->input->post('last_qty_contracts_buy_vs_sellers_val')){
            $last_qty_contracts_buy_vs_sellers_val = $this->input->post('last_qty_contracts_buy_vs_sellers_val');
            if($last_qty_contracts_buy_vs_sellers_val == ''){
                $message = 'qty buyer vs selle contracts value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($last_qty_contracts_buy_vs_sellers_val,$percentile_values_arr)){
                $message = 'qty buyer vs selle contracts value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller'] = $last_qty_contracts_buy_vs_sellers_val;
            }
        }

        //%%%%%%%%%%%% --  End of Qty contracts buy vs sell -- %%%%%%%%%%%%%%%%%%%



         //%%%%%%%%%%%%%%%%%%%%%% -- last Qty contracts time -- %%%%%%%%%%%%%%%%%%%%%
         if($this->input->post('last_qty_contracts_time_active')){
            $last_qty_contracts_time_active = strtoupper($this->input->post('last_qty_contracts_time_active'));
           if(!in_array($last_qty_contracts_time_active,$rule_active_values_arr)){
                $message = 'last Qty contracts time active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($last_qty_contracts_time_active == ''){
                $message = 'last Qty contracts time active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_last_qty_contracts_time_apply'] = $last_qty_contracts_time_active;
            }
        }


        if($this->input->post('last_qty_contracts_time_val')){
            $last_qty_contracts_time_val = $this->input->post('last_qty_contracts_time_val');
            if($last_qty_contracts_time_val == ''){
                $message = 'last Qty contracts time value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($last_qty_contracts_time_val,$percentile_values_arr)){
                $message = 'last Qty contracts time value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_last_qty_contracts_time'] = $last_qty_contracts_time_val;
            }
        }

        //%%%%%%%%%%%% --  End of last Qty contracts time -- %%%%%%%%%%%%%%%%%%%




        //%%%%%%%%%%%%%%%%%%%%%% -- 5 minute rolling candle -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('five_minute_rolling_candle_active')){
            $five_minute_rolling_candle_active = strtoupper($this->input->post('five_minute_rolling_candle_active'));
           if(!in_array($five_minute_rolling_candle_active,$rule_active_values_arr)){
                $message = '5 minute rolling candle active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($five_minute_rolling_candle_active == ''){
                $message = '5 minute rolling candle active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_5_minute_rolling_candel_sell_apply'] = $five_minute_rolling_candle_active;
            }
        }


        if($this->input->post('five_minute_rolling_candle_val')){
            $five_minute_rolling_candle_val = $this->input->post('five_minute_rolling_candle_val');
            if($five_minute_rolling_candle_val == ''){
                $message = '5 minute rolling candle value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($five_minute_rolling_candle_val,$percentile_values_arr)){
                $message = '5 minute rolling candle value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_5_minute_rolling_candel_sell'] = $five_minute_rolling_candle_val;
            }
        }

        //%%%%%%%%%%%% --  End of 5 minute rolling candle -- %%%%%%%%%%%%%%%%%%%





        //%%%%%%%%%%%%%%%%%%%%%% -- 15 minute rolling candle -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('rolling_candle_15_m_active')){
            $rolling_candle_15_m_active = strtoupper($this->input->post('rolling_candle_15_m_active'));
           if(!in_array($rolling_candle_15_m_active,$rule_active_values_arr)){
                $message = '15 minute rolling candle active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($rolling_candle_15_m_active == ''){
                $message = '5 minute rolling candle active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_15_minute_rolling_candel_sell_apply'] = $rolling_candle_15_m_active;
            }
        }


        if($this->input->post('rolling_candle_15_m_val')){
            $rolling_candle_15_m_val = $this->input->post('rolling_candle_15_m_val');
            if($rolling_candle_15_m_val == ''){
                $message = '15 minute rolling candle value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($rolling_candle_15_m_val,$percentile_values_arr)){
                $message = '15 minute rolling candle value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_15_minute_rolling_candel_sell'] = $rolling_candle_15_m_val;
            }
        }

        //%%%%%%%%%%%% --  End of 15 minute rolling candle -- %%%%%%%%%%%%%%%%%%%




         //%%%%%%%%%%%%%%%%%%%%%% -- buyers -- %%%%%%%%%%%%%%%%%%%%%
         if($this->input->post('buyers_active')){
            $buyers_active = strtoupper($this->input->post('buyers_active'));
           if(!in_array($buyers_active,$rule_active_values_arr)){
                $message = 'buyers active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($buyers_active == ''){
                $message = 'buyers active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buyers_sell_apply'] = $buyers_active;
            }
        }


        if($this->input->post('buyers_val')){
            $buyers_val = $this->input->post('buyers_val');
            if($buyers_val == ''){
                $message = 'buyers value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($buyers_val,$percentile_values_arr)){
                $message = 'buyers value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buyers_sell'] = $buyers_val;
            }
        }

        //%%%%%%%%%%%% --  End of buyers -- %%%%%%%%%%%%%%%%%%%






        //%%%%%%%%%%%%%%%%%%%%%% -- sellers -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('sellers_active')){
            $sellers_active = strtoupper($this->input->post('sellers_active'));
           if(!in_array($sellers_active,$rule_active_values_arr)){
                $message = 'sellers active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($sellers_active == ''){
                $message = 'sellers active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sellers_sell_apply'] = $sellers_active;
            }
        }


        if($this->input->post('sellers_val')){
            $sellers_val = $this->input->post('sellers_val');
            if($sellers_val == ''){
                $message = 'sellers value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($sellers_val,$percentile_values_arr)){
                $message = 'sellers value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sellers_sell'] = $sellers_val;
            }
        }

        //%%%%%%%%%%%% --  End of sellers -- %%%%%%%%%%%%%%%%%%%




        //%%%%%%%%%%%%%%%%%%%%%% -- last time age 15 m -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('last_time_ago_15_m_active')){
            $last_time_ago_15_m_active = strtoupper($this->input->post('last_time_ago_15_m_active'));
           if(!in_array($last_time_ago_15_m_active,$rule_active_values_arr)){
                $message = 'last time age 15 m active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($last_time_ago_15_m_active == ''){
                $message = 'last time age 15 m active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_15_minute_last_time_ago_sell_apply'] = $last_time_ago_15_m_active;
            }
        }


        if($this->input->post('last_time_ago_15_m_val')){
            $last_time_ago_15_m_val = $this->input->post('last_time_ago_15_m_val');
            if($last_time_ago_15_m_val == ''){
                $message = 'last time age 15 m value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($last_time_ago_15_m_val,$percentile_values_arr)){
                $message = 'last time age 15 m value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_15_minute_last_time_ago_sell'] = $last_time_ago_15_m_val;
            }
        }

        //%%%%%%%%%%%% --  End of last time age 15 m-- %%%%%%%%%%%%%%%%%%%






        //%%%%%%%%%%%%%%%%%%%%%% --  ask -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('ask_active')){
            $ask_active = strtoupper($this->input->post('ask_active'));
           if(!in_array($ask_active,$rule_active_values_arr)){
                $message = 'ask active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($ask_active == ''){
                $message = 'ask active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_ask_sell_apply'] = $ask_active;
            }
        }


        if($this->input->post('ask_val')){
            $ask_val = $this->input->post('ask_val');
            if($ask_val == ''){
                $message = 'ask value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($ask_val,$percentile_values_arr)){
                $message = 'ask value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_ask_sell'] = $ask_val;
            }
        }

        //%%%%%%%%%%%% --  End of ask-- %%%%%%%%%%%%%%%%%%%





        //%%%%%%%%%%%%%%%%%%%%%% --  bid -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('bid_active')){
            $bid_active = strtoupper($this->input->post('bid_active'));
           if(!in_array($bid_active,$rule_active_values_arr)){
                $message = 'bid active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($bid_active == ''){
                $message = 'bid active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_bid_sell_apply'] = $bid_active;
            }
        }


        if($this->input->post('bid_val')){
            $bid_val = $this->input->post('bid_val');
            if($bid_val == ''){
                $message = 'bid value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($bid_val,$percentile_values_arr)){
                $message = 'bid value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_bid_sell'] = $bid_val;
            }
        }

        //%%%%%%%%%%%% --  End of bid-- %%%%%%%%%%%%%%%%%%%







        //%%%%%%%%%%%%%%%%%%%%%% --  BUY -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('buy_active')){
            $buy_active = strtoupper($this->input->post('buy_active'));
           if(!in_array($buy_active,$rule_active_values_arr)){
                $message = 'buy active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($buy_active == ''){
                $message = 'buy active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy_apply'] = $buy_active;
            }
        }


        if($this->input->post('buy_val')){
            $buy_val = $this->input->post('buy_val');
            if($buy_val == ''){
                $message = 'buy value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($buy_val,$percentile_values_arr)){
                $message = 'buy value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_buy'] = $buy_val;
            }
        }

        //%%%%%%%%%%%% --  End of BUY-- %%%%%%%%%%%%%%%%%%%






        //%%%%%%%%%%%%%%%%%%%%%% --  sell -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('sell_active')){
            $sell_active = strtoupper($this->input->post('sell_active'));
           if(!in_array($sell_active,$rule_active_values_arr)){
                $message = 'buy active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($sell_active == ''){
                $message = 'buy active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell_apply'] = $sell_active;
            }
        }


        if($this->input->post('sell_val')){
            $sell_val = $this->input->post('sell_val');
            if($sell_val == ''){
                $message = 'buy value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($sell_val,$percentile_values_arr)){
                $message = 'buy value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_sell'] = $sell_val;
            }
        }

        //%%%%%%%%%%%% --  End of sell-- %%%%%%%%%%%%%%%%%%%




        //%%%%%%%%%%%%%%%%%%%%%% --  ask contracts -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('ask_contracts_active')){
            $ask_contracts_active = strtoupper($this->input->post('ask_contracts_active'));
           if(!in_array($ask_contracts_active,$rule_active_values_arr)){
                $message = 'ask contracts active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($ask_contracts_active == ''){
                $message = 'ask contracts active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_ask_contracts_apply'] = $ask_contracts_active;
            }
        }


        if($this->input->post('ask_contracts_val')){
            $ask_contracts_val = $this->input->post('ask_contracts_val');
            if($ask_contracts_val == ''){
                $message = 'ask contracts value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($ask_contracts_val,$percentile_values_arr)){
                $message = 'ask contracts value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_ask_contracts'] = $ask_contracts_val;
            }
        }

        //%%%%%%%%%%%% --  End of Ask contracts-- %%%%%%%%%%%%%%%%%%%





        //%%%%%%%%%%%%%%%%%%%%%% --  bid contracts -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('bid_contracts_active')){
            $bid_contracts_active = strtoupper($this->input->post('bid_contracts_active'));
           if(!in_array($bid_contracts_active,$rule_active_values_arr)){
                $message = 'bid contracts active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($bid_contracts_active == ''){
                $message = 'bid contracts active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_bid_contracts_apply'] = $bid_contracts_active;
            }
        }


        if($this->input->post('bid_contracts_val')){
            $bid_contracts_val = $this->input->post('bid_contracts_val');
            if($bid_contracts_val == ''){
                $message = 'bid contracts value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!in_array($bid_contracts_val,$percentile_values_arr)){
                $message = 'bid contracts value Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['barrier_percentile_trigger_bid_contracts'] = $bid_contracts_val;
            }
        }

        //%%%%%%%%%%%% --  End of Bid contracts-- %%%%%%%%%%%%%%%%%%%



        //%%%%%%%%%%%%%%%%%%%%%% -- caption option -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('caption_option_active')){
            $caption_option_active = strtoupper($this->input->post('caption_option_active'));
           if(!in_array($caption_option_active,$rule_active_values_arr)){
                $message = 'caption option active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($caption_option_active == ''){
                $message = 'caption option active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_caption_option_buy_apply'] = $caption_option_active;
            }
        }


        if($this->input->post('caption_option_val')){
            $caption_option_val = $this->input->post('caption_option_val');
             if($caption_option_val == ''){
                $message = 'caption option required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($caption_option_val)){
                $message = 'please enter correct caption option';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_caption_option_buy'] = $caption_option_val;
            }
        }

        //%%%%%%%%%%%% --  End of Caption Option -- %%%%%%%%%%%%%%%%%%%





        //%%%%%%%%%%%%%%%%%%%%%% -- caption score -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('caption_score_active')){
            $caption_score_active = strtoupper($this->input->post('caption_score_active'));
           if(!in_array($caption_score_active,$rule_active_values_arr)){
                $message = 'caption score active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($caption_score_active == ''){
                $message = 'caption score active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_caption_score_buy_apply'] = $caption_score_active;
            }
        }


        if($this->input->post('caption_score_val')){
            $caption_score_val = $this->input->post('caption_score_val');
             if($caption_score_val == ''){
                $message = 'caption score required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($caption_score_val)){
                $message = 'please enter correct caption score';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_caption_score_buy'] = $caption_score_val;
            }
        }

        //%%%%%%%%%%%% --  End of Caption Option -- %%%%%%%%%%%%%%%%%%%



         //%%%%%%%%%%%%%%%%%%%%%% -- buy market trend -- %%%%%%%%%%%%%%%%%%%%%
         if($this->input->post('buy_market_trend_active')){
            $buy_market_trend_active = strtoupper($this->input->post('buy_market_trend_active'));
           if(!in_array($buy_market_trend_active,$rule_active_values_arr)){
                $message = 'buy market trendactive value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($buy_market_trend_active == ''){
                $message = 'buy market trend active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_buy_trend_buy_apply'] = $buy_market_trend_active;
            }
        }


        if($this->input->post('buy_market_trend_val')){
            $buy_market_trend_val = $this->input->post('buy_market_trend_val');
             if($buy_market_trend_val == ''){
                $message = 'buy market trend required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($buy_market_trend_val)){
                $message = 'please enter correct buy market trend';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_buy_trend_buy'] = $buy_market_trend_val;
            }
        }

        //%%%%%%%%%%%% --  End of buy market trend -- %%%%%%%%%%%%%%%%%%%




         //%%%%%%%%%%%%%%%%%%%%%% -- sell market trend -- %%%%%%%%%%%%%%%%%%%%%
         if($this->input->post('sell_market_trend_active')){
            $sell_market_trend_active = strtoupper($this->input->post('sell_market_trend_active'));
           if(!in_array($sell_market_trend_active,$rule_active_values_arr)){
                $message = 'sell market trendactive value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($sell_market_trend_active == ''){
                $message = 'sell market trend active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_sell_buy_apply'] = $sell_market_trend_active;
            }
        }


        if($this->input->post('sell_market_trend_val')){
            $sell_market_trend_val = $this->input->post('sell_market_trend_val');
             if($sell_market_trend_val == ''){
                $message = 'sell market trend required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($sell_market_trend_val)){
                $message = 'please enter correct sell market trend';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_sell_buy'] = $sell_market_trend_val;
            }
        }

        //%%%%%%%%%%%% --  End of sell market trend -- %%%%%%%%%%%%%%%%%%%



        //%%%%%%%%%%%%%%%%%%%%%% -- demand market trend -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('demand_market_trend_active')){
            $demand_market_trend_active = strtoupper($this->input->post('demand_market_trend_active'));
           if(!in_array($demand_market_trend_active,$rule_active_values_arr)){
                $message = 'demand market trendactive value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($demand_market_trend_active == ''){
                $message = 'demand market trend active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_demand_buy_apply'] = $demand_market_trend_active;
            }
        }


        if($this->input->post('demand_market_trend_val')){
            $demand_market_trend_val = $this->input->post('demand_market_trend_val');
             if($demand_market_trend_val == ''){
                $message = 'demand market trend required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($demand_market_trend_val)){
                $message = 'please enter correct demand market trend';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_demand_buy'] = $demand_market_trend_val;
            }
        }

        //%%%%%%%%%%%% --  End of demand market trend -- %%%%%%%%%%%%%%%%%%%




        //%%%%%%%%%%%%%%%%%%%%%% -- supply market trend -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('supply_market_trend_active')){
            $supply_market_trend_active = strtoupper($this->input->post('supply_market_trend_active'));
           if(!in_array($supply_market_trend_active,$rule_active_values_arr)){
                $message = 'supply market trendactive value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($supply_market_trend_active == ''){
                $message = 'supply market trend active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_supply_buy_apply'] = $supply_market_trend_active;
            }
        }


        if($this->input->post('supply_market_trend_val')){
            $supply_market_trend_val = $this->input->post('supply_market_trend_val');
             if($supply_market_trend_val == ''){
                $message = 'supply market trend required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($supply_market_trend_val)){
                $message = 'please enter correct supply market trend';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_supply_buy'] = $supply_market_trend_val;
            }
        }

        //%%%%%%%%%%%% --  End of supply market trend -- %%%%%%%%%%%%%%%%%%%




        //%%%%%%%%%%%%%%%%%%%%%% --  market trend -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('market_trend_active')){
            $market_trend_active = strtoupper($this->input->post('market_trend_active'));
           if(!in_array($market_trend_active,$rule_active_values_arr)){
                $message = ' market trenda ctive value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($market_trend_active == ''){
                $message = ' market trend active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_market_trend_buy_apply'] = $market_trend_active;
            }
        }


        if($this->input->post('market_trend_val')){
            $market_trend_val = strtoupper($this->input->post('market_trend_val'));
             if($market_trend_val == ''){
                $message = ' market trend required';
                $type    = '403';
                $this->response($message, $type);
            }else if( ($market_trend_val !='POSITIVE') || ($market_trend_val !='NEGATIVE') ){
                $message = 'please enter correct  market trend';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_market_trend_buy'] = $market_trend_val;
            }
        }

        //%%%%%%%%%%%% --  End of  market trend -- %%%%%%%%%%%%%%%%%%%





        //%%%%%%%%%%%%%%%%%%%%%% --  meta trading -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('meta_trading_active')){
            $meta_trading_active = strtoupper($this->input->post('meta_trading_active'));
           if(!in_array($meta_trading_active,$rule_active_values_arr)){
                $message = 'Meta trading  active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($meta_trading_active == ''){
                $message = ' meta trading  active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_meta_trading_buy_apply'] = $meta_trading_active;
            }
        }


        if($this->input->post('meta_trading_val')){
            $meta_trading_val = $this->input->post('meta_trading_val');
             if($meta_trading_val == ''){
                $message = 'meta trading value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($meta_trading_val)){
                $message = 'please enter correct meta trading value';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_meta_trading_buy'] = $meta_trading_val;
            }
        }

        //%%%%%%%%%%%% --  End of meta trading -- %%%%%%%%%%%%%%%%%%%



        //%%%%%%%%%%%%%%%%%%%%%% --  risk per share -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('riskpershare_active')){
            $riskpershare_active = strtoupper($this->input->post('riskpershare_active'));
           if(!in_array($riskpershare_active,$rule_active_values_arr)){
                $message = 'riskpershare active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($riskpershare_active == ''){
                $message = ' riskpershare active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_riskpershare_buy_apply'] = $riskpershare_active;
            }
        }


        if($this->input->post('riskpershare_val')){
            $riskpershare_val = $this->input->post('riskpershare_val');
             if($riskpershare_val == ''){
                $message = 'riskpershare value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($riskpershare_val)){
                $message = 'please enter correct riskpershare value';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_riskpershare_buy'] = $riskpershare_val;
            }
        }

        //%%%%%%%%%%%% --  End of riskpershare -- %%%%%%%%%%%%%%%%%%%



        //%%%%%%%%%%%%%%%%%%%%%% --  RL -- %%%%%%%%%%%%%%%%%%%%%
        if($this->input->post('RL_active')){
            $RL_active = strtoupper($this->input->post('RL_active'));
           if(!in_array($RL_active,$rule_active_values_arr)){
                $message = 'RL active value  Wrong';
                $type    = '403';
                $this->response($message, $type);
            }else if($RL_active == ''){
                $message = ' RL active value  required';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_RL_buy_apply'] = $RL_active;
            }
        }


        if($this->input->post('RL_val')){
            $RL_val = $this->input->post('RL_val');
             if($RL_val == ''){
                $message = 'RL value required';
                $type    = '403';
                $this->response($message, $type);
            }else if(!is_numeric($RL_val)){
                $message = 'please enter correct RL value';
                $type    = '403';
                $this->response($message, $type);
            }else{
                $optional_fld_arr['percentile_trigger_RL_buy'] = $RL_val;
            }
        }

        //%%%%%%%%%%%% --  End of RL -- %%%%%%%%%%%%%%%%%%%

        if(empty($optional_fld_arr)){
            $message = 'Atlease One value   required';
            $type    = '403';
            $this->response($message, $type);
        }

       

    
        if ($username == 'digiebot' && $password == 'digiebot' || true) {
            $coin = $this->input->post('symbol');
            $ip   = getenv('HTTP_CLIENT_IP') ?:
            getenv('HTTP_X_FORWARDED_FOR') ?:
            getenv('HTTP_X_FORWARDED') ?:
            getenv('HTTP_FORWARDED_FOR') ?:
            getenv('HTTP_FORWARDED') ?:
            getenv('REMOTE_ADDR');



            if ($ip == '45.115.84.51' || true) {
               
                $db = $this->mongo_db->customQuery();
                $db = $db->trigger_global_setting->updateOne($required_fld_arr,$optional_fld_arr,array('upsert'=>true));
                $message   = 'percentile trigger setting updated successfully';
                $type      = '200';
                $this->response($message, $type);
            } else {
                $message = 'You are not allowed To Access this';
                $type    = '403';
                $this->response($message, $type);
            }

        } else {

            $message = 'Sorry You are not Authorized';
            $type    = '401';
            $this->response($message, $type);

            //echo $orders_arr_arr = $this->mod_coins_info->save_coins_info();
        }

    } //end Coin meta Function

    
    public function get_candles(){
        $global_coins = $this->triggers_trades->list_system_global_coin();
        $coin_symbol = strtoupper($this->input->post('coin'));

        if($coin_symbol == ''){
            $message = 'coin symbol required';
            $type    = '403';
            $this->response($message, $type);
        }else if(!in_array($coin_symbol,$global_coins)){
            $message = 'Coin not registered with Digieboat';
            $type    = '403';
            $this->response($message, $type);
        }

        $required_fld_arr['coin'] = $coin_symbol;
        $candle_date = $this->input->post('candle_date');
        $where['coin'] = $coin_symbol;

        if($candle_date != ''){
            $start_date  = date('Y-m-d H:00:00',strtotime($candle_date));
            $end_date  = date('Y-m-d H:59:59',strtotime($candle_date));
           $start_date = $this->mongo_db->converToMongodttime($start_date);
           $end_date = $this->mongo_db->converToMongodttime($end_date);
           $where['timestampDate'] = array('$gte'=>$start_date,'$lt'=>$end_date);
        }

        $this->mongo_db->limit(1);
        $this->mongo_db->order_by(array('timestampDate'=>-1));
        $this->mongo_db->where($where);
        $data = $this->mongo_db->get('market_chart');
        $data = (array) iterator_to_array($data);
        $data = $data[0];

        unset($data['_id']);
        unset($data['timestampDate']);
        unset($data['openTime_human_readible']);
        unset($data['closeTime_human_readible']);
        unset($data['human_readible_dateTime']);
        unset($data['global_swing_status']);
        unset($data['global_swing_parent_status']);
        unset($data['triggert_type']);
        unset($data['trigger_status']);

        $data = (array)$data;
        $message = $data;
        $type    = '200';
        $this->response($message, $type);
    }//End of get_candles

    // public function response($message, $type) {

    //     $response = array('HTTP Response' => $type, 'Message' => $message);

    //     echo json_encode($response);
    //     exit;

    //} /**End of response ***/




    // public function api_barrier_setting() {
    //     $username = $this->input->server('PHP_AUTH_USER');
    //     $password = $this->input->server('PHP_AUTH_PW');

    //     $rule_active_values_arr = array('ON','OFF');
    //     $percentile_values_arr = array('1','2','3','4','5','6','7','8','9','10');
    //     $optional_fld_arr = array();


    //     $trading_type = strtolower($this->input->post('type'));

        
    //     $trading_type_arr = array('buy','sell','stop_loss');
    //     if($trading_type == ''){
    //         $message = 'trading type required';
    //         $type    = '403';
    //         $this->response($message, $type);
    //     }else if(!in_array($trading_type,$trading_type_arr)){
    //         $message = 'trading type Wrong';
    //         $type    = '403';
    //         $this->response($message, $type);
    //     }


        

    //     if($trading_type == 'sell'){
    //         $post_data = $this->input->post();
    //         $this->api_barrier_setting_sell($post_data);
    //         exit;
    //     }


        
    //     $trigger_type = $this->input->post('trigger_type');

    //     if($trigger_type == ''){
    //         $message = 'Trigger name required';
    //         $type    = '403';
    //         $this->response($message, $type);
    //     }else if($trigger_type != 'barrier_trigger'){
    //         $message = 'Trigger name is wrong';
    //         $type    = '403';
    //         $this->response($message, $type);
    //     }

    //     $required_fld_arr['triggers_type'] = $trigger_type;

    //     $rule_no = $this->input->post('rule_no');

    //     if($rule_no == ''){
    //         $message = 'Trigger rule no required';
    //         $type    = '403';
    //         $this->response($message, $type);
    //     }else if(!in_array($rule_no,$percentile_values_arr)){
    //         $message = 'Trigger Rule not found';
    //         $type    = '403';
    //         $this->response($message, $type);
    //     }
    //     $required_fld_arr['rule_no'] = $rule_no;


       


    //     $trading_mode = strtolower($this->input->post('trading_mode'));
    //     $trading_mode_arr = array('live','test','test_simulator');
    //     if($trading_mode == ''){
    //         $message = 'Trading mode required';
    //         $type    = '403';
    //         $this->response($message, $type);
    //     }else if(!in_array($trading_mode,$trading_mode_arr)){
    //         $message = 'Trading mode Wrong';
    //         $type    = '403';
    //         $this->response($message, $type);
    //     }
    //     $required_fld_arr['order_mode'] = $trading_mode;




       


    //     $global_coins = $this->triggers_trades->list_system_global_coin();

    //     $coin_symbol = strtoupper($this->input->post('coin'));
    
    //     if($coin_symbol == ''){
    //         $message = 'coin symbol required';
    //         $type    = '403';
    //         $this->response($message, $type);
    //     }else if(!in_array($coin_symbol,$global_coins)){
    //         $message = 'coin symbol Wrong';
    //         $type    = '403';
    //         $this->response($message, $type);
    //     }
    //     $required_fld_arr['coin'] = $coin_symbol;


    //     $trading_type = strtolower($this->input->post('type'));

        
    //     $trading_type_arr = array('buy','sell','stop_loss');
    //     if($trading_type == ''){
    //         $message = 'trading type required';
    //         $type    = '403';
    //         $this->response($message, $type);
    //     }else if(!in_array($trading_type,$trading_type_arr)){
    //         $message = 'trading type Wrong';
    //         $type    = '403';
    //         $this->response($message, $type);
    //     }

      
        

    //     if($this->input->post('rule_active')){
    //         $rule_active = strtoupper($this->input->post('rule_active'));
    //        if(!in_array($rule_active,$rule_active_values_arr)){
    //             $message = 'Rule Active Status Wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['enable_buy_rule_no_'.$rule_no] = $rule_active;
    //         }
    //     }
        


        
    //     //%%%%%%%%%%%%% --Swing status -- %%%%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('swing_point_status')){
    //         $swing_point_status = strtoupper($this->input->post('swing_point_status'));
    //        if(!in_array($swing_point_status,array('LL','LH','HH','HL'))){
    //             $message = 'Swing status not found';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_status_rule_'.$rule_no] = $swing_point_status;
    //         }
    //     }
    //     //%%%%%%%%%%%% -- Swing status    -- %%%%%%%%%%%%%%%%%
        



    //     if($this->input->post('swing_point_status_active')){
    //         $swing_point_status_active = strtoupper($this->input->post('swing_point_status_active'));
            
    //        if(!in_array($swing_point_status_active,$rule_active_values_arr)){
    //             $message = 'Rule Active Status Wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_status_rule_'.$rule_no.'_enable'] = $rule_active;
    //         }
    //     }



    //     if($this->input->post('buy_range_percet')){
    //         $buy_range_percet = ($this->input->post('buy_range_percet'));
            
    //        if(!is_numeric($buy_range_percet)){
    //             $message = 'Buy range percent Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($buy_range_percet == ''){
    //             $message = 'Buy range percent empty not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_range_percet'] = $buy_range_percet;
    //         }
    //     }


    //     if($this->input->post('follow_behind_current_market_percentage')){
    //         $sell_profit_percet = ($this->input->post('follow_behind_current_market_percentage'));
            
    //        if(!is_numeric($sell_profit_percet)){
    //             $message = 'Follow Behind stop Loss % Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($sell_profit_percet == ''){
    //             $message = 'Follow Behind stop Loss not be Empty';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['sell_profit_percet'] = $sell_profit_percet;
    //         }
    //     }


    //     if($this->input->post('stop_loss_percet')){
    //         $stop_loss_percet = ($this->input->post('stop_loss_percet'));
            
    //        if(!is_numeric($stop_loss_percet)){
    //             $message = 'Stop Loss % Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($stop_loss_percet == ''){
    //             $message = 'Stop Loss empty not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['stop_loss_percet'] = $stop_loss_percet;
    //         }
    //     }


    //     //%%%%%%%%%%%%% -- Virtual Barrier -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('virtual_barrier_active')){
    //         $virtual_barrier_active = strtoupper($this->input->post('virtual_barrier_active'));   
    //        if(!in_array($virtual_barrier_active,$rule_active_values_arr)){
    //             $message = 'Virtual barrier Active Status Wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_virtual_barrier_rule_'.$rule_no.'_enable'] = $virtual_barrier_active;
    //         }
    //     }

    //     if($this->input->post('virtual_barrier_value')){
    //         $virtual_barrier_value = ($this->input->post('virtual_barrier_value'));
    //        if(!is_numeric($virtual_barrier_value)){
    //             $message = 'virtual barrier value Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($virtual_barrier_value == ''){
    //             $message = 'virtual barrier value empty not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_virtural_rule_'.$rule_no] = $virtual_barrier_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of virtual barrier -- %%%%%%%%%%%%%%



    //     //%%%%%%%%%%%%% -- Resistance Barrier -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('resistance_barrier_active')){
    //         $resistance_barrier_active = strtoupper($this->input->post('resistance_barrier_active'));   
    //        if(!in_array($resistance_barrier_active,$rule_active_values_arr)){
    //             $message = 'resistance barrier Active Status Wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['sell_virtural_for_buy_rule_'.$rule_no.'_enable'] = $resistance_barrier_active;
    //         }
    //     }
        
    //     if($this->input->post('resistance_barrier_value')){
    //         $resistance_barrier_value = ($this->input->post('resistance_barrier_value'));
    //        if(!is_numeric($resistance_barrier_value)){
    //             $message = 'resistance barrier value Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($resistance_barrier_value == ''){
    //             $message = 'resistance barrier value empty not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['sell_virtural_for_buy_rule_'.$rule_no] = $virtual_barrier_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of Resistance barrier -- %%%%%%%%%%%%%%

        


    //     //%%%%%%%%%%%%% -- volume -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('volume_active')){
    //         $volume_active = strtoupper($this->input->post('volume_active'));   
    //        if(!in_array($volume_active,$rule_active_values_arr)){
    //             $message = 'Volume Active Status Wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_check_volume_rule_'.$rule_no] = $volume_active;
    //         }
    //     }
        

    //     if($this->input->post('volume_value')){
    //         $volume_value = ($this->input->post('volume_value'));
    //        if(!is_numeric($resistance_barrier_value)){
    //             $message = 'Volume Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($volume_value == ''){
    //             $message = 'Volume value empty not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_volume_rule_'.$rule_no] = $volume_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of Volume barrier -- %%%%%%%%%%%%%%
        




    //     //%%%%%%%%%%%%% -- Down pressure -- %%%%%%%%%%%%%%%%%%%%%%
    //      if($this->input->post('down_pressure_active')){
    //         $down_pressure_active = strtoupper($this->input->post('down_pressure_active'));   
    //        if(!in_array($down_pressure_active,$rule_active_values_arr)){
    //             $message = 'down pressure active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['done_pressure_rule_'.$rule_no.'_buy_enable'] = $down_pressure_active;
    //         }
    //     }
        
        
    //     if($this->input->post('down_pressure_value')){
    //         $down_pressure_value = ($this->input->post('down_pressure_value'));
    //        if(!is_numeric($down_pressure_value)){
    //             $message = 'Down Pressure Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($down_pressure_value == ''){
    //             $message = 'Empty down pressure not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['done_pressure_rule_'.$rule_no.'_buy'] = $down_pressure_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of down pressure -- %%%%%%%%%%%%%%




    //     //%%%%%%%%%%%%% -- bid buyers -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('big_buyers_active')){
    //         $big_buyers_active = strtoupper($this->input->post('big_buyers_active'));   
    //        if(!in_array($big_buyers_active,$rule_active_values_arr)){
    //             $message = 'big buyers active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['big_seller_percent_compare_rule_'.$rule_no.'_buy_enable'] = $big_buyers_active;
    //         }
    //     }
        
        
    //     if($this->input->post('big_buyers_value')){
    //         $big_buyers_value = ($this->input->post('big_buyers_value'));
    //        if(!is_numeric($big_buyers_value)){
    //             $message = 'big buyers Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($big_buyers_value == ''){
    //             $message = 'Empty big buyers not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['big_seller_percent_compare_rule_'.$rule_no.'_buy'] = $big_buyers_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of big buyers -- %%%%%%%%%%%%%%



    //     //%%%%%%%%%%%%% --Balck wall -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('black_wall_active')){
    //         $black_wall_active = strtoupper($this->input->post('black_wall_active'));   
    //        if(!in_array($black_wall_active,$rule_active_values_arr)){
    //             $message = 'black wall active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['closest_black_wall_rule_'.$rule_no.'_buy_enable'] = $black_wall_active;
    //         }
    //     }
        
        
    //     if($this->input->post('black_wall_value')){
    //         $black_wall_value = ($this->input->post('black_wall_value'));
    //        if(!is_numeric($black_wall_value)){
    //             $message = 'black wall Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($black_wall_value == ''){
    //             $message = 'black wall buyers not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['closest_black_wall_rule_'.$rule_no.'_buy'] = $black_wall_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of black wall -- %%%%%%%%%%%%%%









    //      //%%%%%%%%%%%%% --yellow wall -- %%%%%%%%%%%%%%%%%%%%%%
    //      if($this->input->post('yellow_wall_active')){
    //         $yellow_wall_active = strtoupper($this->input->post('yellow_wall_active'));   
    //        if(!in_array($yellow_wall_active,$rule_active_values_arr)){
    //             $message = 'yellow wall active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['closest_yellow_wall_rule_'.$rule_no.'_buy_enable'] = $yellow_wall_active;
    //         }
    //     }
        
        
    //     if($this->input->post('yellow_wall_value')){
    //         $yellow_wall_value = ($this->input->post('yellow_wall_value'));
    //        if(!is_numeric($yellow_wall_value)){
    //             $message = 'yellow wall Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($yellow_wall_value == ''){
    //             $message = 'yellow wall buyers not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['closest_yellow_wall_rule_'.$rule_no.'_buy'] = $yellow_wall_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of yellow wall -- %%%%%%%%%%%%%%





    //     //%%%%%%%%%%%%% --seven level -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('seven_level_active')){
    //         $seven_level_active = strtoupper($this->input->post('seven_level_active'));   
    //        if(!in_array($seven_level_active,$rule_active_values_arr)){
    //             $message = 'seven level active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['seven_level_pressure_rule_'.$rule_no.'_buy_enable'] = $seven_level_active;
    //         }
    //     }
        
    //     if($this->input->post('seven_level_value')){
    //         $seven_level_value = ($this->input->post('seven_level_value'));
    //        if(!is_numeric($seven_level_value)){
    //             $message = 'seven level Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($seven_level_value == ''){
    //             $message = 'seven level value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['seven_level_pressure_rule_'.$rule_no.'_buy'] = $seven_level_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of seven level -- %%%%%%%%%%%%%%










    //     //%%%%%%%%%%%%% -- buyer vs sellers -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('buyers_vs_sellers_active')){
    //         $buyers_vs_sellers_active = strtoupper($this->input->post('buyers_vs_sellers_active'));   
    //        if(!in_array($buyers_vs_sellers_active,$rule_active_values_arr)){
    //             $message = 'buyers vs sellers active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buyer_vs_seller_rule_'.$rule_no.'_buy_enable'] = $buyers_vs_sellers_active;
    //         }
    //     }
        
    //     if($this->input->post('buyers_vs_sellers_value')){
    //         $buyers_vs_sellers_value = ($this->input->post('buyers_vs_sellers_value'));
    //        if(!is_numeric($buyers_vs_sellers_value)){
    //             $message = 'buyers vs sellers Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($buyers_vs_sellers_value == ''){
    //             $message = 'buyers vs sellersl value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buyer_vs_seller_rule_'.$rule_no.'_buy'] = $buyers_vs_sellers_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of buyers vs sellers -- %%%%%%%%%%%%%%



  

    //     //%%%%%%%%%%%%% -- candle type -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('last_candle_type_active')){
    //         $last_candle_type_active = strtoupper($this->input->post('last_candle_type_active'));
            
    //         if(!in_array($last_candle_type_active,$rule_active_values_arr)){
    //             $message = 'last candle type active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_last_candle_type'.$rule_no.'_enable'] = $last_candle_type_active;
    //         }
    //     }
        
    //     if($this->input->post('last_candle_type_value')){
    //         $last_candle_type_value = strtolower($this->input->post('last_candle_type_value'));

    //        if(!in_array($last_candle_type_value,array('normal','demand','supply'))){
    //             $message = 'last candle type Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($last_candle_type_value == ''){
    //             $message = 'last candle type value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['last_candle_type'.$rule_no.'_buy'] = $last_candle_type_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of last candle type -- %%%%%%%%%%%%%%
        
        


    //     //%%%%%%%%%%%%% -- rejection candle type -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('rejection_candle_active')){

    //         $rejection_candle_active = strtoupper($this->input->post('rejection_candle_active'));
    //         if(!in_array($rejection_candle_active,$rule_active_values_arr)){
    //             $message = 'rejection candle  active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_rejection_candle_type'.$rule_no.'_enable'] = $rejection_candle_active;
    //         }
    //     }
        
    //     if($this->input->post('rejection_candle_value')){
    //         $rejection_candle_value = strtolower($this->input->post('rejection_candle_value'));

    //        if(!in_array($rejection_candle_value,array('top_demand_rejection','bottom_demand_rejection','top_supply_rejection','bottom_supply_rejection','no_rejection'))){
    //             $message = 'rejection candle Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($rejection_candle_value == ''){
    //             $message = 'rejection candle value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['rejection_candle_type'.$rule_no.'_buy'] = $rejection_candle_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of of rejection type -- %%%%%%%%%%%%%%


    //     //%%%%%%%%%%%%% -- last 200 contracts -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('last_200_contracts_active')){
    //         $last_200_contracts_active = strtoupper($this->input->post('last_200_contracts_active'));
    //         if(!in_array($last_200_contracts_active,$rule_active_values_arr)){
    //             $message = 'last 200 contracts  active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_last_200_contracts_buy_vs_sell'.$rule_no.'_enable'] = $last_200_contracts_active;
    //         }
    //     }
        
   

    //     if($this->input->post('last_200_contracts_value')){
    //         $last_200_contracts_value = ($this->input->post('last_200_contracts_value'));
    //        if(!is_numeric($last_200_contracts_value)){
    //             $message = 'last 200 contracts Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($last_200_contracts_value == ''){
    //             $message = 'last 200 contracts value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['last_200_contracts_buy_vs_sell'.$rule_no.'_buy'] = $last_200_contracts_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of last contract -- %%%%%%%%%%%%%%




    //     //%%%%%%%%%%%%% -- last 200 contracts time -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('last_200_contracts_time_active')){
    //         $last_200_contracts_time_active = strtoupper($this->input->post('last_200_contracts_time_active'));
    //         if(!in_array($last_200_contracts_time_active,$rule_active_values_arr)){
    //             $message = 'last 200 contracts time active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_last_200_contracts_time'.$rule_no.'_enable'] = $last_200_contracts_time_active;
    //         }
    //     }

    //     if($this->input->post('last_200_contracts_time_value')){
    //         $last_200_contracts_time_value = ($this->input->post('last_200_contracts_time_value'));
    //        if(!is_numeric($last_200_contracts_time_value)){
    //             $message = 'last 200 contracts time Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($last_200_contracts_time_value == ''){
    //             $message = 'last 200 contracts time value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['last_200_contracts_time'.$rule_no.'_buy'] = $last_200_contracts_time_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of last contract time -- %%%%%%%%%%%%%%



    //     //%%%%%%%%%%%%% -- last Qty contracts  -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('last_qty_contracts_active')){
    //         $last_qty_contracts_active = strtoupper($this->input->post('last_qty_contracts_active'));
    //         if(!in_array($last_qty_contracts_active,$rule_active_values_arr)){
    //             $message = 'last qty contracts active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_last_qty_buyers_vs_seller'.$rule_no.'_enable'] = $last_qty_contracts_active;
    //         }
    //     }

    //     if($this->input->post('last_qty_contracts_value')){
    //         $last_qty_contracts_value = ($this->input->post('last_qty_contracts_value'));
    //        if(!is_numeric($last_qty_contracts_value)){
    //             $message = 'last qty contracts  Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($last_qty_contracts_value == ''){
    //             $message = 'last qty contracts value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['last_qty_buyers_vs_seller'.$rule_no.'_buy'] = $last_qty_contracts_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of last Qty contract -- %%%%%%%%%%%%%%




    //     //%%%%%%%%%%%%% -- last Qty time  -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('last_qty_time_active')){
    //         $last_qty_time_active = strtoupper($this->input->post('last_qty_time_active'));
    //         if(!in_array($last_qty_time_active,$rule_active_values_arr)){
    //             $message = 'last qty time active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_last_qty_time'.$rule_no.'_enable'] = $last_qty_time_active;
    //         }
    //     }

    //     if($this->input->post('last_qty_time_value')){
    //         $last_qty_time_value = ($this->input->post('last_qty_time_value'));
    //        if(!is_numeric($last_qty_time_value)){
    //             $message = 'last qty time  Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($last_qty_time_value == ''){
    //             $message = 'last qty time value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['last_qty_time'.$rule_no.'_buy'] = $last_qty_time_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of last Qty time -- %%%%%%%%%%%%%%





    //     //%%%%%%%%%%%%% -- score  -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('score_active')){
    //         $score_active = strtoupper($this->input->post('score_active'));
    //         if(!in_array($score_active,$rule_active_values_arr)){
    //             $message = 'score active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_score'.$rule_no.'_enable'] = $score_active;
    //         }
    //     }

    //     if($this->input->post('score_value')){
    //         $score_value = ($this->input->post('score_value'));
    //        if(!is_numeric($score_value)){
    //             $message = 'score Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($score_value == ''){
    //             $message = 'score value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['score'.$rule_no.'_buy'] = $score_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of score -- %%%%%%%%%%%%%%






    //      //%%%%%%%%%%%%% -- comment  -- %%%%%%%%%%%%%%%%%%%%%%
    //      if($this->input->post('comment_active')){
    //         $comment_active = strtoupper($this->input->post('comment_active'));
    //         if(!in_array($comment_active,$rule_active_values_arr)){
    //             $message = 'comment active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_comment'.$rule_no.'_enable'] = $comment_active;
    //         }
    //     }

    //     if($this->input->post('comment_value')){
    //         $comment_value = ($this->input->post('comment_value'));
    //       if($comment_value == ''){
    //             $message = 'comment value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['comment'.$rule_no.'_buy'] = $comment_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of comment -- %%%%%%%%%%%%%%


    //     $percentile_values_arr = array('1','2','3','4','5','6','7','8','9','10');

    //     //%%%%%%%%%%%%% -- order level  -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('level_active')){
    //         $level_active = strtoupper($this->input->post('level_active'));
    //         if(!in_array($level_active,$rule_active_values_arr)){
    //             $message = 'level active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_order_level_'.$rule_no.'_enable'] = $level_active;
    //         }
    //     }


    //     if($this->input->post('level_value')){
    //         $level_value = ($this->input->post('level_value'));
            
    //         if(!in_array($level_value,$percentile_values_arr)){
    //             $message = 'level Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($level_value == ''){
    //             $message = 'level value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $level_value = 'level_'.$level_value;
    //             $optional_fld_arr['buy_order_level_'.$rule_no] = $level_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of level -- %%%%%%%%%%%%%%






    //     //%%%%%%%%%%%%% -- rule sorting -- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('rule_sorting_active')){
    //         $rule_sorting_active = strtoupper($this->input->post('rule_sorting_active'));
    //         if(!in_array($rule_sorting_active,$rule_active_values_arr)){
    //             $message = 'rule sorting active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['order_status'.$rule_no.'_enable'] = $rule_sorting_active;
    //         }
    //     }

    //     if($this->input->post('rule_sorting_value')){
    //         $rule_sorting_value = ($this->input->post('rule_sorting_value'));
    //         if(!in_array($rule_sorting_value,$percentile_values_arr)){
    //             $message = 'rule sorting Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($rule_sorting_value == ''){
    //             $message = 'rule value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['order_status'.$rule_no.'_buy'] = $rule_sorting_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of rule sorting -- %%%%%%%%%%%%%%






    //     //%%%%%%%%%%%%% -- rule buy vs seller 15 m-- %%%%%%%%%%%%%%%%%%%%%%
    //     if($this->input->post('buyers_vs_sellers_15_m_active')){
    //         $buyers_vs_sellers_15_m_active = strtoupper($this->input->post('buyers_vs_sellers_15_m_active'));
    //         if(!in_array($buyers_vs_sellers_15_m_active,$rule_active_values_arr)){
    //             $message = 'buy vs sellers 15 minutes active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buyers_vs_sellers_buy'.$rule_no.'_enable'] = $buyers_vs_sellers_15_m_active;
    //         }
    //     }

    //     if($this->input->post('buyers_vs_sellers_15_m_value')){
    //         $buyers_vs_sellers_15_m_value = ($this->input->post('buyers_vs_sellers_15_m_value'));
    //         if(!is_numeric($buyers_vs_sellers_15_m_value)){
    //             $message = 'buy vs sellers 15 minute Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($buyers_vs_sellers_15_m_value == ''){
    //             $message = 'buy vs sellers 15 minute value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buyers_vs_sellers'.$rule_no.'_buy'] = $buyers_vs_sellers_15_m_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of buy vs seller 15 m -- %%%%%%%%%%%%%%





    //      //%%%%%%%%%%%%% -- ask percentile -- %%%%%%%%%%%%%%%%%%%%%%
    //      if($this->input->post('ask_percentile_active')){
    //         $ask_percentile_active = strtoupper($this->input->post('ask_percentile_active'));
    //         if(!in_array($ask_percentile_active,$rule_active_values_arr)){
    //             $message = 'ask percentile active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['ask_percentile_'.$rule_no.'_apply_buy'] = $ask_percentile_active;
    //         }
    //     }

    //     if($this->input->post('ask_percentile_value')){
    //         $ask_percentile_value = ($this->input->post('ask_percentile_value'));
    //         if(!is_numeric($ask_percentile_value)){
    //             $message = 'ask percentile Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($ask_percentile_value == ''){
    //             $message = 'ask percentile value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['ask_percentile_'.$rule_no.'_buy'] = $ask_percentile_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of ask percentile  -- %%%%%%%%%%%%%%




    //      //%%%%%%%%%%%%% -- bid percentile -- %%%%%%%%%%%%%%%%%%%%%%
    //      if($this->input->post('bid_percentile_active')){
    //         $bid_percentile_active = strtoupper($this->input->post('bid_percentile_active'));
    //         if(!in_array($bid_percentile_active,$rule_active_values_arr)){
    //             $message = 'bid percentile active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['bid_percentile_'.$rule_no.'_apply_buy'] = $bid_percentile_active;
    //         }
    //     }

    //     if($this->input->post('bid_percentile_value')){
    //         $bid_percentile_value = ($this->input->post('bid_percentile_value'));
    //         if(!is_numeric($bid_percentile_value)){
    //             $message = 'bid percentile Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($bid_percentile_value == ''){
    //             $message = 'bid percentile value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['bid_percentile_'.$rule_no.'_buy'] = $bid_percentile_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of bid percentile  -- %%%%%%%%%%%%%%




    //      //%%%%%%%%%%%%% -- buy percentile -- %%%%%%%%%%%%%%%%%%%%%%
    //      if($this->input->post('buy_percentile_active')){
    //         $buy_percentile_active = strtoupper($this->input->post('buy_percentile_active'));
    //         if(!in_array($buy_percentile_active,$rule_active_values_arr)){
    //             $message = 'buy percentile active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_percentile_'.$rule_no.'_apply_buy'] = $buy_percentile_active;
    //         }
    //     }

    //     if($this->input->post('buy_percentile_value')){
    //         $buy_percentile_value = ($this->input->post('buy_percentile_value'));
    //         if(!is_numeric($buy_percentile_value)){
    //             $message = 'buy percentile Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($buy_percentile_value == ''){
    //             $message = 'buy percentile value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['buy_percentile_'.$rule_no.'_buy'] = $buy_percentile_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of buy percentile  -- %%%%%%%%%%%%%%




    //      //%%%%%%%%%%%%% -- buy percentile -- %%%%%%%%%%%%%%%%%%%%%%
    //      if($this->input->post('sell_percentile_active')){
    //         $sell_percentile_active = strtoupper($this->input->post('sell_percentile_active'));
    //         if(!in_array($sell_percentile_active,$rule_active_values_arr)){
    //             $message = 'sell percentile active status wrong';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['sell_percentile_'.$rule_no.'_apply_buy'] = $sell_percentile_active;
    //         }
    //     }

    //     if($this->input->post('sell_percentile_value')){
    //         $sell_percentile_value = ($this->input->post('sell_percentile_value'));
    //         if(!is_numeric($sell_percentile_value)){
    //             $message = 'sell percentile Format not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else if($sell_percentile_value == ''){
    //             $message = 'sell percentile value not accepted';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }else{
    //             $optional_fld_arr['sell_percentile_'.$rule_no.'_buy'] = $sell_percentile_value;
    //         }
    //     }
    //     //%%%%%%%%%%%%% -- End of sell percentile  -- %%%%%%%%%%%%%%     
        

    //     if(empty($optional_fld_arr)){
    //         $message = 'Atlease One value   required';
    //         $type    = '403';
    //         $this->response($message, $type);
    //     }

       

    
    //     if ($username == 'digiebot' && $password == 'digiebot' || true) {
    //         $coin = $this->input->post('symbol');
    //         $ip   = getenv('HTTP_CLIENT_IP') ?:
    //         getenv('HTTP_X_FORWARDED_FOR') ?:
    //         getenv('HTTP_X_FORWARDED') ?:
    //         getenv('HTTP_FORWARDED_FOR') ?:
    //         getenv('HTTP_FORWARDED') ?:
    //         getenv('REMOTE_ADDR');



    //         if ($ip == '45.115.84.51' || true) {
               
    //             $db = $this->mongo_db->customQuery();
    //             $db = $db->trigger_global_setting->updateOne($required_fld_arr,$optional_fld_arr,array('upsert'=>true));
    //             $message   = 'barrier trigger setting updated successfully';
    //             $type      = '200';
    //             $this->response($message, $type);
    //         } else {
    //             $message = 'You are not allowed To Access this';
    //             $type    = '403';
    //             $this->response($message, $type);
    //         }

    //     } else {

    //         $message = 'Sorry You are not Authorized';
    //         $type    = '401';
    //         $this->response($message, $type);

    //         //echo $orders_arr_arr = $this->mod_coins_info->save_coins_info();
    //     }

    // } //end Coin meta Function




    // public function api_barrier_setting_sell($post_data) {

    

    //     $rule_active_values_arr = array('ON','OFF');
    //     $percentile_values_arr = array('1','2','3','4','5','6','7','8','9','10');
    //     $optional_fld_arr = array();

        
    //     $trigger_type = $post_data['trigger_type'];

        // if($trigger_type == ''){
        //     $message = 'Trigger name required';
        //     $type    = '403';
        //     $this->response($message, $type);
        // }else if($trigger_type != 'barrier_trigger'){
        //     $message = 'Trigger name is wrong';
        //     $type    = '403';
        //     $this->response($message, $type);
        // }

        // $required_fld_arr['triggers_type'] = $trigger_type;

        // $rule_no = $post_data['rule_no']; 

        // if($rule_no == ''){
        //     $message = 'Trigger rule no required';
        //     $type    = '403';
        //     $this->response($message, $type);
        // }else if(!in_array($rule_no,$percentile_values_arr)){
        //     $message = 'Trigger Rule not found';
        //     $type    = '403';
        //     $this->response($message, $type);
        // }
        // $required_fld_arr['rule_no'] = $rule_no;


        // $trading_mode = strtolower($post_data['trading_mode']);
        // $trading_mode_arr = array('live','test','test_simulator');
        // if($trading_mode == ''){
        //     $message = 'Trading mode required';
        //     $type    = '403';
        //     $this->response($message, $type);
        // }else if(!in_array($trading_mode,$trading_mode_arr)){
        //     $message = 'Trading mode Wrong';
        //     $type    = '403';
        //     $this->response($message, $type);
        // }
        // $required_fld_arr['order_mode'] = $trading_mode;


        // $global_coins = $this->triggers_trades->list_system_global_coin();

        // $coin_symbol = strtoupper($post_data['coin']);
    
        // if($coin_symbol == ''){
        //     $message = 'coin symbol required';
        //     $type    = '403';
        //     $this->response($message, $type);
        // }else if(!in_array($coin_symbol,$global_coins)){
        //     $message = 'coin symbol Wrong';
        //     $type    = '403';
        //     $this->response($message, $type);
        // }
        // $required_fld_arr['coin'] = $coin_symbol;
   
        
        // if($post_data['rule_active']){
        //     $rule_active = strtoupper($post_data['rule_active']);
        //    if(!in_array($rule_active,$rule_active_values_arr)){
        //         $message = 'Rule Active Status Wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['enable_sell_rule_no_'.$rule_no] = $rule_active;
        //     }
        // }
        

        //%%%%%%%%%%%%% --Swing status -- %%%%%%%%%%%%%%%%%%%%%%%%
        // if($post_data['swing_point_status']){
        //     $swing_point_status = strtoupper($post_data['swing_point_status'] );
        //    if(!in_array($swing_point_status,array('LL','LH','HH','HL'))){
        //         $message = 'Swing status not found';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_status_rule_'.$rule_no] = $swing_point_status;
        //     }
        // }
        //%%%%%%%%%%%% -- Swing status    -- %%%%%%%%%%%%%%%%%
        

        // if($post_data['swing_point_status_active']){
        //     $swing_point_status_active = strtoupper($post_data['swing_point_status_active']);
            
        //    if(!in_array($swing_point_status_active,$rule_active_values_arr)){
        //         $message = 'Rule Active Status Wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_status_rule_'.$rule_no.'_enable'] = $rule_active;
        //     }
        // }


        //%%%%%%%%%%%%% -- Virtual Barrier -- %%%%%%%%%%%%%%%%%%%%%%
        
        // if($post_data['virtual_barrier_active']){
        //     $virtual_barrier_active = strtoupper($post_data['virtual_barrier_active']);   
        //    if(!in_array($virtual_barrier_active,$rule_active_values_arr)){
        //         $message = 'Virtual barrier Active Status Wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['buy_virtural_rule_for_sell_'.$rule_no.'_enable'] = $virtual_barrier_active;
        //     }
        // }
       
        // if($post_data['virtual_barrier_value']){
        //     $virtual_barrier_value = $post_data['virtual_barrier_value'];
        //    if(!is_numeric($virtual_barrier_value)){
        //         $message = 'virtual barrier value Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($virtual_barrier_value == ''){
        //         $message = 'virtual barrier value empty not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['buy_virtural_rule_for_sell_'.$rule_no] = $virtual_barrier_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of virtual barrier -- %%%%%%%%%%%%%%



        //%%%%%%%%%%%%% -- Resistance Barrier -- %%%%%%%%%%%%%%%%%%%%%%
        

        // if($post_data['resistance_barrier_active']){
        //     $resistance_barrier_active = strtoupper($post_data['resistance_barrier_active']);   
        //    if(!in_array($resistance_barrier_active,$rule_active_values_arr)){
        //         $message = 'resistance barrier Active Status Wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_virtual_barrier_rule_'.$rule_no.'_enable'] = $resistance_barrier_active;
        //     }
        // }
        
        // if($post_data['resistance_barrier_value']){
        //     $resistance_barrier_value = $post_data['resistance_barrier_value'];
        //    if(!is_numeric($resistance_barrier_value)){
        //         $message = 'resistance barrier value Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($resistance_barrier_value == ''){
        //         $message = 'resistance barrier value empty not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_virtural_rule_'.$rule_no] = $virtual_barrier_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of Resistance barrier -- %%%%%%%%%%%%%%

        


        //%%%%%%%%%%%%% -- volume -- %%%%%%%%%%%%%%%%%%%%%%
        
        // if($post_data['volume_active']){
        //     $volume_active = strtoupper($post_data['volume_active']);   
        //    if(!in_array($volume_active,$rule_active_values_arr)){
        //         $message = 'Volume Active Status Wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_check_volume_rule_'.$rule_no] = $volume_active;
        //     }
        // }
        
        
        // if($post_data['volume_value']){
        //     $volume_value = $post_data['volume_value'];
        //    if(!is_numeric($resistance_barrier_value)){
        //         $message = 'Volume Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($volume_value == ''){
        //         $message = 'Volume value empty not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_volume_rule_'.$rule_no] = $volume_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of Volume barrier -- %%%%%%%%%%%%%%
        




        //%%%%%%%%%%%%% -- Down pressure -- %%%%%%%%%%%%%%%%%%%%%%
        
        //  if($post_data['down_pressure_active']){
        //     $down_pressure_active = strtoupper($post_data['down_pressure_active']);   
        //    if(!in_array($down_pressure_active,$rule_active_values_arr)){
        //         $message = 'down pressure active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['done_pressure_rule_'.$rule_no.'_enable'] = $down_pressure_active;
        //     }
        // }
        
        
        // if($post_data['down_pressure_value']){
        //     $down_pressure_value = $post_data['down_pressure_value'];
        //    if(!is_numeric($down_pressure_value)){
        //         $message = 'Down Pressure Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($down_pressure_value == ''){
        //         $message = 'Empty down pressure not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['done_pressure_rule_'.$rule_no.''] = $down_pressure_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of down pressure -- %%%%%%%%%%%%%%




        //%%%%%%%%%%%%% -- bid buyers -- %%%%%%%%%%%%%%%%%%%%%%
        
        // if($post_data['big_buyers_active']){
        //     $big_buyers_active = strtoupper($post_data['big_buyers_active']);   
        //    if(!in_array($big_buyers_active,$rule_active_values_arr)){
        //         $message = 'big buyers active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['big_seller_percent_compare_rule_'.$rule_no.'_enable'] = $big_buyers_active;
        //     }
        // }
        
        
        // if($post_data['big_buyers_value']){
        //     $big_buyers_value = $post_data['big_buyers_value'];
        //    if(!is_numeric($big_buyers_value)){
        //         $message = 'big buyers Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($big_buyers_value == ''){
        //         $message = 'Empty big buyers not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['big_seller_percent_compare_rule_'.$rule_no] = $big_buyers_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of big buyers -- %%%%%%%%%%%%%%



        //%%%%%%%%%%%%% --Balck wall -- %%%%%%%%%%%%%%%%%%%%%%
        
        // if($post_data['black_wall_active']){
        //     $black_wall_active = strtoupper($post_data['black_wall_active']);   
        //    if(!in_array($black_wall_active,$rule_active_values_arr)){
        //         $message = 'black wall active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['closest_black_wall_rule_'.$rule_no.'_enable'] = $black_wall_active;
        //     }
        // }
        
        
        // if($post_data['black_wall_value']){
        //     $black_wall_value = $post_data['black_wall_value'];
        //    if(!is_numeric($black_wall_value)){
        //         $message = 'black wall Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($black_wall_value == ''){
        //         $message = 'black wall buyers not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['closest_black_wall_rule_'.$rule_no] = $black_wall_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of black wall -- %%%%%%%%%%%%%%









         //%%%%%%%%%%%%% --yellow wall -- %%%%%%%%%%%%%%%%%%%%%%
         
        //  if($post_data['yellow_wall_active']){
        //     $yellow_wall_active = strtoupper($post_data['yellow_wall_active']);   
        //    if(!in_array($yellow_wall_active,$rule_active_values_arr)){
        //         $message = 'yellow wall active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['closest_yellow_wall_rule_'.$rule_no.'_enable'] = $yellow_wall_active;
        //     }
        // }
        
        
        // if($post_data['yellow_wall_value']){
        //     $yellow_wall_value = $post_data['yellow_wall_value'];
        //    if(!is_numeric($yellow_wall_value)){
        //         $message = 'yellow wall Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($yellow_wall_value == ''){
        //         $message = 'yellow wall buyers not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['closest_yellow_wall_rule_'.$rule_no] = $yellow_wall_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of yellow wall -- %%%%%%%%%%%%%%





        //%%%%%%%%%%%%% --seven level -- %%%%%%%%%%%%%%%%%%%%%%
        
        // if($post_data['seven_level_active']){
        //     $seven_level_active = strtoupper($post_data['seven_level_active']);   
        //    if(!in_array($seven_level_active,$rule_active_values_arr)){
        //         $message = 'seven level active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['seven_level_pressure_rule_'.$rule_no.'_enable'] = $seven_level_active;
        //     }
        // }
        
        // if($post_data['seven_level_value']){
        //     $seven_level_value = $post_data['seven_level_value'];
        //    if(!is_numeric($seven_level_value)){
        //         $message = 'seven level Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($seven_level_value == ''){
        //         $message = 'seven level value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['seven_level_pressure_rule_'.$rule_no] = $seven_level_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of seven level -- %%%%%%%%%%%%%%










        //%%%%%%%%%%%%% -- buyer vs sellers -- %%%%%%%%%%%%%%%%%%%%%%
        
        // if($post_data['buyers_vs_sellers_active']){
        //     $buyers_vs_sellers_active = strtoupper($post_data['buyers_vs_sellers_active']);   
        //    if(!in_array($buyers_vs_sellers_active,$rule_active_values_arr)){
        //         $message = 'buyers vs sellers active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['seller_vs_buyer_rule_'.$rule_no.'_sell_enable'] = $buyers_vs_sellers_active;
        //     }
        // }
        
        // if($post_data['buyers_vs_sellers_value']){
        //     $buyers_vs_sellers_value = $post_data['buyers_vs_sellers_value'];
        //    if(!is_numeric($buyers_vs_sellers_value)){
        //         $message = 'buyers vs sellers Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($buyers_vs_sellers_value == ''){
        //         $message = 'buyers vs sellersl value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['seller_vs_buyer_rule_'.$rule_no.'_sell'] = $buyers_vs_sellers_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of buyers vs sellers -- %%%%%%%%%%%%%%



  

        //%%%%%%%%%%%%% -- candle type -- %%%%%%%%%%%%%%%%%%%%%%
        
        // if($post_data['last_candle_type_active']){
        //     $last_candle_type_active = strtoupper($post_data['last_candle_type_active']);
            
        //     if(!in_array($last_candle_type_active,$rule_active_values_arr)){
        //         $message = 'last candle type active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_last_candle_type'.$rule_no.'_enable'] = $last_candle_type_active;
        //     }
        // }
        
        // if($post_data['last_candle_type_value']){
        //     $last_candle_type_value = strtolower($post_data['last_candle_type_value']);

        //    if(!in_array($last_candle_type_value,array('normal','demand','supply'))){
        //         $message = 'last candle type Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($last_candle_type_value == ''){
        //         $message = 'last candle type value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['last_candle_type'.$rule_no.'_sell'] = $last_candle_type_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of last candle type -- %%%%%%%%%%%%%%
        
        

        
        //%%%%%%%%%%%%% -- rejection candle type -- %%%%%%%%%%%%%%%%%%%%%%
        // if($post_data['rejection_candle_active']){

        //     $rejection_candle_active = strtoupper($post_data['rejection_candle_active']);
        //     if(!in_array($rejection_candle_active,$rule_active_values_arr)){
        //         $message = 'rejection candle  active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_rejection_candle_type'.$rule_no.'_enable'] = $rejection_candle_active;
        //     }
        // }
        
        // if($post_data['rejection_candle_value']){
        //     $rejection_candle_value = strtolower($post_data['rejection_candle_value']);

        //    if(!in_array($rejection_candle_value,array('top_demand_rejection','bottom_demand_rejection','top_supply_rejection','bottom_supply_rejection','no_rejection'))){
        //         $message = 'rejection candle Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($rejection_candle_value == ''){
        //         $message = 'rejection candle value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['rejection_candle_type'.$rule_no.'_sell'] = $rejection_candle_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of of rejection type -- %%%%%%%%%%%%%%


        //%%%%%%%%%%%%% -- last 200 contracts -- %%%%%%%%%%%%%%%%%%%%%%
        
        // if($post_data['last_200_contracts_active']){
        //     $last_200_contracts_active = strtoupper($post_data['last_200_contracts_active']);
        //     if(!in_array($last_200_contracts_active,$rule_active_values_arr)){
        //         $message = 'last 200 contracts  active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_last_200_contracts_buy_vs_sell'.$rule_no.'_enable'] = $last_200_contracts_active;
        //     }
        // }
        
        

        // if($post_data['last_200_contracts_value']){
        //     $last_200_contracts_value = $post_data['last_200_contracts_value'];
        //    if(!is_numeric($last_200_contracts_value)){
        //         $message = 'last 200 contracts Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($last_200_contracts_value == ''){
        //         $message = 'last 200 contracts value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['last_200_contracts_buy_vs_sell'.$rule_no.'_sell'] = $last_200_contracts_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of last contract -- %%%%%%%%%%%%%%



        
        //%%%%%%%%%%%%% -- last 200 contracts time -- %%%%%%%%%%%%%%%%%%%%%%
        // if($post_data['last_200_contracts_time_active']){
        //     $last_200_contracts_time_active = strtoupper($post_data['last_200_contracts_time_active']);
        //     if(!in_array($last_200_contracts_time_active,$rule_active_values_arr)){
        //         $message = 'last 200 contracts time active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_last_200_contracts_time'.$rule_no.'_enable'] = $last_200_contracts_time_active;
        //     }
        // }
        
        // if($post_data['last_200_contracts_time_value']){
        //     $last_200_contracts_time_value = $post_data['last_200_contracts_time_value'];
        //    if(!is_numeric($last_200_contracts_time_value)){
        //         $message = 'last 200 contracts time Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($last_200_contracts_time_value == ''){
        //         $message = 'last 200 contracts time value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['last_200_contracts_time'.$rule_no.'_sell'] = $last_200_contracts_time_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of last contract time -- %%%%%%%%%%%%%%


        
        //%%%%%%%%%%%%% -- last Qty contracts  -- %%%%%%%%%%%%%%%%%%%%%%
        // if($post_data['last_qty_contracts_active']){
        //     $last_qty_contracts_active = strtoupper($post_data['last_qty_contracts_active']);
        //     if(!in_array($last_qty_contracts_active,$rule_active_values_arr)){
        //         $message = 'last qty contracts active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_last_qty_buyers_vs_seller'.$rule_no.'_enable'] = $last_qty_contracts_active;
        //     }
        // }

        
        // if($post_data['last_qty_contracts_value']){
        //     $last_qty_contracts_value = $post_data['last_qty_contracts_value'];
        //    if(!is_numeric($last_qty_contracts_value)){
        //         $message = 'last qty contracts  Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($last_qty_contracts_value == ''){
        //         $message = 'last qty contracts value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['last_qty_buyers_vs_seller'.$rule_no.'_sell'] = $last_qty_contracts_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of last Qty contract -- %%%%%%%%%%%%%%




        //%%%%%%%%%%%%% -- last Qty time  -- %%%%%%%%%%%%%%%%%%%%%%
        
        // if($post_data['last_qty_time_active']){
        //     $last_qty_time_active = strtoupper($post_data['last_qty_time_active']);
        //     if(!in_array($last_qty_time_active,$rule_active_values_arr)){
        //         $message = 'last qty time active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_last_qty_time'.$rule_no.'_enable'] = $last_qty_time_active;
        //     }
        // }
        
        // if($post_data['last_qty_time_value']){
        //     $last_qty_time_value = $post_data['last_qty_time_value'];
        //    if(!is_numeric($last_qty_time_value)){
        //         $message = 'last qty time  Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($last_qty_time_value == ''){
        //         $message = 'last qty time value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['last_qty_time'.$rule_no.'_sell'] = $last_qty_time_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of last Qty time -- %%%%%%%%%%%%%%




        
        //%%%%%%%%%%%%% -- score  -- %%%%%%%%%%%%%%%%%%%%%%
        // if($post_data['score_active']){
        //     $score_active = strtoupper($post_data['score_active']);
        //     if(!in_array($score_active,$rule_active_values_arr)){
        //         $message = 'score active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_score'.$rule_no.'_enable'] = $score_active;
        //     }
        // }
        
        // if($post_data['score_value']){
        //     $score_value = $post_data['score_value'];
        //    if(!is_numeric($score_value)){
        //         $message = 'score Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($score_value == ''){
        //         $message = 'score value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['score'.$rule_no.'_sell'] = $score_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of score -- %%%%%%%%%%%%%%





        
         //%%%%%%%%%%%%% -- comment  -- %%%%%%%%%%%%%%%%%%%%%%
        //  if($post_data['comment_active']){
        //     $comment_active = strtoupper($post_data['comment_active']);
        //     if(!in_array($comment_active,$rule_active_values_arr)){
        //         $message = 'comment active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_comment'.$rule_no.'_enable'] = $comment_active;
        //     }
        // }
        
        // if($post_data['comment_value']){
        //     $comment_value = ($post_data['comment_value']);
        //   if($comment_value == ''){
        //         $message = 'comment value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['comment'.$rule_no.'_sell'] = $comment_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of comment -- %%%%%%%%%%%%%%


        // $percentile_values_arr = array('1','2','3','4','5','6','7','8','9','10');

        //%%%%%%%%%%%%% -- order level  -- %%%%%%%%%%%%%%%%%%%%%%
        
        // if($post_data['level_active']){
        //     $level_active = strtoupper($post_data['level_active']);
        //     if(!in_array($level_active,$rule_active_values_arr)){
        //         $message = 'level active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_order_level_'.$rule_no.'_enable'] = $level_active;
        //     }
        // }

        
        // if($post_data['level_value']){
        //     $level_value = ($post_data['level_value']);
            
        //     if(!in_array($level_value,$percentile_values_arr)){
        //         $message = 'level Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($level_value == ''){
        //         $message = 'level value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $level_value = 'level_'.$level_value;
        //         $optional_fld_arr['sell_order_level_'.$rule_no] = $level_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of level -- %%%%%%%%%%%%%%




        

        //%%%%%%%%%%%%% -- rule sorting -- %%%%%%%%%%%%%%%%%%%%%%
        // if($post_data['rule_sorting_active']){
        //     $rule_sorting_active = strtoupper($post_data['rule_sorting_active']);
        //     if(!in_array($rule_sorting_active,$rule_active_values_arr)){
        //         $message = 'rule sorting active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['rule_sorting'.$rule_no.'_enable'] = $rule_sorting_active;
        //     }
        // }
        
        // if($post_data['rule_sorting_value']){
        //     $rule_sorting_value = $post_data['rule_sorting_value'];
        //     if(!in_array($rule_sorting_value,$percentile_values_arr)){
        //         $message = 'rule sorting Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($rule_sorting_value == ''){
        //         $message = 'rule value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['rule_sort'.$rule_no.'_sell'] = $rule_sorting_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of rule sorting -- %%%%%%%%%%%%%%




        

        //%%%%%%%%%%%%% -- rule buy vs seller 15 m-- %%%%%%%%%%%%%%%%%%%%%%
        // if($post_data['buyers_vs_sellers_15_m_active']){
        //     $buyers_vs_sellers_15_m_active = strtoupper($post_data['buyers_vs_sellers_15_m_active']);
        //     if(!in_array($buyers_vs_sellers_15_m_active,$rule_active_values_arr)){
        //         $message = 'buy vs sellers 15 minutes active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['buyers_vs_sellers_sell'.$rule_no.'_enable'] = $buyers_vs_sellers_15_m_active;
        //     }
        // }
        
        
        // if($post_data['buyers_vs_sellers_15_m_value']){
        //     $buyers_vs_sellers_15_m_value = $post_data['buyers_vs_sellers_15_m_value'];
        //     if(!is_numeric($buyers_vs_sellers_15_m_value)){
        //         $message = 'buy vs sellers 15 minute Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($buyers_vs_sellers_15_m_value == ''){
        //         $message = 'buy vs sellers 15 minute value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['buyers_vs_sellers'.$rule_no.'_sell'] = $buyers_vs_sellers_15_m_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of buy vs seller 15 m -- %%%%%%%%%%%%%%




        
         //%%%%%%%%%%%%% -- ask percentile -- %%%%%%%%%%%%%%%%%%%%%%
        //  if($post_data['ask_percentile_active']){
        //     $ask_percentile_active = strtoupper($post_data['ask_percentile_active']);
        //     if(!in_array($ask_percentile_active,$rule_active_values_arr)){
        //         $message = 'ask percentile active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['ask_percentile_'.$rule_no.'_apply_sell'] = $ask_percentile_active;
        //     }
        // }
        
        // if($post_data['ask_percentile_value']){
        //     $ask_percentile_value = $post_data['ask_percentile_value'];
        //     if(!is_numeric($ask_percentile_value)){
        //         $message = 'ask percentile Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($ask_percentile_value == ''){
        //         $message = 'ask percentile value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['ask_percentile_'.$rule_no.'_sell'] = $ask_percentile_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of ask percentile  -- %%%%%%%%%%%%%%



        
         //%%%%%%%%%%%%% -- bid percentile -- %%%%%%%%%%%%%%%%%%%%%%
        //  if($post_data['bid_percentile_active']){
        //     $bid_percentile_active = strtoupper($post_data['bid_percentile_active']);
        //     if(!in_array($bid_percentile_active,$rule_active_values_arr)){
        //         $message = 'bid percentile active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['bid_percentile_'.$rule_no.'_apply_sell'] = $bid_percentile_active;
        //     }
        // }
        
        // if($post_data['bid_percentile_value']){
        //     $bid_percentile_value = $post_data['bid_percentile_value'];
        //     if(!is_numeric($bid_percentile_value)){
        //         $message = 'bid percentile Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($bid_percentile_value == ''){
        //         $message = 'bid percentile value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['bid_percentile_'.$rule_no.'_sell'] = $bid_percentile_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of bid percentile  -- %%%%%%%%%%%%%%



        
         //%%%%%%%%%%%%% -- buy percentile -- %%%%%%%%%%%%%%%%%%%%%%
        //  if($post_data['buy_percentile_active']){
        //     $buy_percentile_active = strtoupper($post_data['buy_percentile_active']);
        //     if(!in_array($buy_percentile_active,$rule_active_values_arr)){
        //         $message = 'buy percentile active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['buy_percentile_'.$rule_no.'_apply_sell'] = $buy_percentile_active;
        //     }
        // }
        
        // if($post_data['buy_percentile_value']){
        //     $buy_percentile_value = $post_data['buy_percentile_value'];
        //     if(!is_numeric($buy_percentile_value)){
        //         $message = 'buy percentile Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($buy_percentile_value == ''){
        //         $message = 'buy percentile value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['buy_percentile_'.$rule_no.'_sell'] = $buy_percentile_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of buy percentile  -- %%%%%%%%%%%%%%


        

         //%%%%%%%%%%%%% -- buy percentile -- %%%%%%%%%%%%%%%%%%%%%%
        //  if($post_data['sell_percentile_active']){
        //     $sell_percentile_active = strtoupper($post_data['sell_percentile_active']);
        //     if(!in_array($sell_percentile_active,$rule_active_values_arr)){
        //         $message = 'sell percentile active status wrong';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_percentile_'.$rule_no.'_apply_sell'] = $sell_percentile_active;
        //     }
        // }
        
        // if($post_data['sell_percentile_value']){
        //     $sell_percentile_value = $post_data['sell_percentile_value'];
        //     if(!is_numeric($sell_percentile_value)){
        //         $message = 'sell percentile Format not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else if($sell_percentile_value == ''){
        //         $message = 'sell percentile value not accepted';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }else{
        //         $optional_fld_arr['sell_percentile_'.$rule_no.'_sell'] = $sell_percentile_value;
        //     }
        // }
        //%%%%%%%%%%%%% -- End of sell percentile  -- %%%%%%%%%%%%%%     
        

        // if(empty($optional_fld_arr)){
        //     $message = 'Atlease One value   required';
        //     $type    = '403';
        //     $this->response($message, $type);
        // }

       

    
        // if ($username == 'digiebot' && $password == 'digiebot' || true) {
        //     $coin = $this->input->post('symbol');
        //     $ip   = getenv('HTTP_CLIENT_IP') ?:
        //     getenv('HTTP_X_FORWARDED_FOR') ?:
        //     getenv('HTTP_X_FORWARDED') ?:
        //     getenv('HTTP_FORWARDED_FOR') ?:
        //     getenv('HTTP_FORWARDED') ?:
        //     getenv('REMOTE_ADDR');



        //     if ($ip == '45.115.84.51' || true) {
               
        //         $db = $this->mongo_db->customQuery();
        //         $db = $db->trigger_global_setting->updateOne($required_fld_arr,$optional_fld_arr,array('upsert'=>true));
        //         $message   = 'barrier trigger setting updated successfully';
        //         $type      = '200';
        //         $this->response($message, $type);
        //     } else {
        //         $message = 'You are not allowed To Access this';
        //         $type    = '403';
        //         $this->response($message, $type);
        //     }

        // } else {

        //     $message = 'Sorry You are not Authorized';
        //     $type    = '401';
            // $this->response($message, $type);

            //echo $orders_arr_arr = $this->mod_coins_info->save_coins_info();
        // }

    // } //end Coin meta Function


    
    


    // public function run(){

    //     $this->mongo_db->limit(100);
    //     $this->mongo_db->order_by(array('timestampDate'=>-1));
    //     $data = $this->mongo_db->get('market_chart');
    //     $data = iterator_to_array($data);

    //     echo '<pre>';
    //     print_r($data);
    //     exit;

    //     $where['triggers_type'] = 'barrier_percentile_trigger';
    //     $where['coin'] = 'TRXBTC';
    //     $where['trigger_level'] = 'level_1';

    //     $this->mongo_db->where($where);
    //     $response_obj = $this->mongo_db->get('trigger_global_setting');
    //     $response_arr = iterator_to_array($response_obj);
    //     echo '<pre>';
    //     print_r($response_arr);
    // }//End of function run()

}//End of api controller