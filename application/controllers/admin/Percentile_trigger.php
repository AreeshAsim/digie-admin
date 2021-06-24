<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Percentile_trigger extends CI_Controller {
    function __construct() {
        parent::__construct();
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
        $this->load->model('admin/mod_market');
        $this->load->model('admin/mod_coins');
        $this->load->model('admin/mod_buy_orders');
        $this->load->model('admin/mod_candel');
        $this->load->model('admin/mod_realtime_candle_socket');
        $this->load->model('admin/mod_box_trigger_3');
        $this->load->model('admin/mod_barrier_trigger');
        $this->load->model('admin/mod_chart3');
        $this->load->model('admin/mod_custom_script');
        $this->load->model('admin/mod_limit_order');
        $this->load->model('admin/mod_balance');
        $this->load->model('admin/mod_percentile_trigger');

    }

    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////                           /////////////////
    ////////////////////                           ////////////////////////////////
    ////////////////////  Function Call Part        //////////////////////////////
    ////////////////////                           ////////////////////////////////
    ////////////////////                           /////////////////
    ////////////////////                           /////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////

    // public function is_order_ready_to_update_stop_loss($coin_symbol = 'EOSBTC') {
    //     $current_market_price = $this->mod_dashboard->get_market_value($coin_symbol);
    //     $current_market_price = (float) $current_market_price;

    //     $this->mod_barrier_trigger->stop_loss_big_wall_barrier_trigger($coin_symbol, $current_market_price);

    // } //--- %%%%%%%%% End of is_order_ready_to_update_stop_loss %%%%%%%%%%%%%%

    // public function go_buy_and_sell_cron_job() {
    //     $summary = "This cronjob Run for Barrier  percentile Buy and Sell";
    //     $duration = "2 second";
    //     track_execution_of_cronjob($duration, $summary);

    //     $function_name = 'percentile trigger go_buy_and_sell_cron_job';
    //     $is_function_process_complete = is_function_process_complete($function_name);
    //     function_start($function_name);

    //     $is_script_take_more_time = is_script_take_more_time($function_name);
    //     if ($is_script_take_more_time) {
    //         track_execution_of_function_time($function_name);
    //         function_stop($function_name);
    //     }

    //     if (!$is_function_process_complete) {
    //         echo 'previous process is still running';
    //         return false;
    //     }

    //     //function to see if trade is on
    //     $is_trades_on_of = $this->mod_barrier_trigger->is_trades_on_of();
    //     if (!$is_trades_on_of) {
    //         echo 'Trade Is  being Off';
    //         return false;
    //     }
    //     $order_level_arr = array('level_1', 'level_2', 'level_3', 'level_4', 'level_5');

    //     $all_coins_arr = $this->mod_sockets->get_all_coins();
    //     $created_date = date('Y-m-d H:i:s');
    //     if (count($all_coins_arr) > 0) {
    //         foreach ($all_coins_arr as $data) {
    //             $coin_symbol = $data['symbol'];
    //             $current_market_price = $this->mod_dashboard->get_market_value($coin_symbol);
    //             $current_market_price = (float) $current_market_price;

    //             $this->mod_percentile_trigger->aggrisive_define_percentage_followup('barrier_percentile_trigger', $coin_symbol, $current_market_price, 5);

    //             $this->mod_percentile_trigger->seven_level_bottom_5_percentile_trailing_stop('barrier_percentile_trigger', $coin_symbol, $current_market_price,5);
                
    //             foreach ($order_level_arr as $order_level) {
    //                 $this->go_buy_barrier_percentile_trigger_order($coin_symbol, $order_level);
    //                 $this->go_sell_orders_on_defined_sell_price($coin_symbol, $order_level);
    //             } //End

    //             //%%%%%%%%%%%%%%
    //             $this->sell_lth_profitable_order($coin_symbol);
                
    //             $this->go_sell_order_by_stop_loss($coin_symbol);

    //             //%%%%%%%%%%% Ready Stop Loss %%%%%%%%%%%%%%%%%%%%%%%%%
    //             $this->mod_percentile_trigger->is_order_ready_to_update_stop_loss($coin_symbol, 2.5, $current_market_price);

    //             //%%%%%%%%%%%%%%%%%%%%%%%  --- Run -- %%%%%%%%%%%%%%%%%%%%%%%%%
    //             $this->mod_percentile_trigger->stop_loss_big_wall_barrier_trigger($coin_symbol, $current_market_price);

    //         } // -- %%%%%% End Of For Each %%%%%%%%%%%%%%%---
    //     } //--%%%%%%%%%%%% End of

    //     //%%%%%%%%%%%% if function process complete %%%%%%%%%%%%%
    //     function_stop($function_name);
    //     echo 'End Date ******' . date('Y-m-d H:i:s') . '<br>';
    // } //end of go_buy_and_sell_cron_job

    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////                           /////////////////
    ////////////////////                           ////////////////////////////////
    ////////////////////  Create and Buy Orders    /////////////////////////////////
    ////////////////////                           ////////////////////////////////
    ////////////////////                           /////////////////
    ////////////////////                           /////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////

    // public function go_buy_barrier_percentile_trigger_order($coin_symbol, $order_level) {

    //     $current_market_price = $this->mod_dashboard->get_market_value($coin_symbol);
    //     $current_market_price = (float) $current_market_price;
    //     //$is_order_created = $this->mod_percentile_trigger->is_order_is_created_just_now($coin_symbol);
    //     // %%%%%%%%%%%%%%%%% -- Getting only Test Order -- %%%%%%%%%%%%%%%%%%

    //     $parent_orders_arr = $this->mod_percentile_trigger->get_parent_orders($coin_symbol, $order_level);
    //     // %%%%% -- Call function to Check Rules --- %%%%%%%%%
    //     $triggers_type = 'barrier_percentile_trigger';
    //     $order_mode = 'live';
    //     $global_setting_arr = $this->mod_percentile_trigger->get_trigger_global_setting($triggers_type, $order_mode, $coin_symbol, $order_level);

    //     $is_rules_true = $this->is_rules_true($coin_symbol, $order_level,$global_setting_arr);

    //     $is_barrier_rule_trule = false;
    //     $log_msg_success = '';
    //     if ($is_rules_true['success_message'] == 'YES'){
    //         $log_msg_success = $is_rules_true['log_message'];
    //         $is_barrier_rule_trule = true;
    //         $this->mod_percentile_trigger->lock_barrier_trigger_true_rules($coin_symbol, '1', $type = 'buy', $current_market_price, $log_msg_success, $order_level);
    //     }

    //     $stop_loss_percent = $global_setting_arr[0]['barrier_percentile_trigger_default_stop_loss_percenage'];

    //     $stop_loss_percent = ($stop_loss_percent == '')?2.5:$stop_loss_percent;

         
    //     if (count($parent_orders_arr) > 0) {
    //         foreach ($parent_orders_arr as $buy_orders) {
    //             $buy_parent_id = $buy_orders['_id'];
    //             $coin_symbol = $buy_orders['symbol'];
    //             $buy_quantity = $buy_orders['quantity'];
    //             $buy_trigger_type = $buy_orders['trigger_type'];
    //             $admin_id = $buy_orders['admin_id'];
    //             $application_mode = $buy_orders['application_mode'];
    //             $order_mode = $buy_orders['order_mode'];
    //             $defined_sell_percentage = $buy_orders['defined_sell_percentage'];
    //             $order_type = $buy_orders['order_type'];
    //             $lth_functionality = $buy_order['lth_functionality'];
    //             $lth_profit = $buy_order['lth_profit'];

    //             $sell_price = $current_market_price + ($current_market_price * 1.3) / 100;
    //             $iniatial_trail_stop = $current_market_price - ($current_market_price / 100) * $stop_loss_percent;

    //             $created_date = date('Y-m-d G:i:s');
    //             $ins_data_buy_order = array(
    //                 'price' => (float) $current_market_price,
    //                 'quantity' => $buy_quantity,
    //                 'symbol' => $coin_symbol,
    //                 'order_type' => $order_type,
    //                 'admin_id' => $admin_id,
    //                 'trigger_type' => 'barrier_percentile_trigger',
    //                 'sell_price' => (float) $sell_price,
    //                 'created_date' => $this->mongo_db->converToMongodttime($date),
    //                 'modified_date' => $this->mongo_db->converToMongodttime($created_date),
    //                 'buy_date' => $this->mongo_db->converToMongodttime($date),
    //                 'trail_check' => 'no',
    //                 'trail_interval' => '0',
    //                 'buy_trail_price' => '0',
    //                 'auto_sell' => 'no',
    //                 'buy_parent_id' => $buy_parent_id,
    //                 'iniatial_trail_stop' => (float) $iniatial_trail_stop,
    //                 'iniatial_trail_stop_copy' => (float) $iniatial_trail_stop,
    //                 'buy_order_status_new_filled' => 'wait_for_buyed',
    //                 'application_mode' => $application_mode,
    //                 'order_mode' => $order_mode,
    //                 'defined_sell_percentage' => $defined_sell_percentage,
    //                 'buy_one_tip_above' => $buy_one_tip_above,
    //                 'sell_one_tip_below' => $sell_one_tip_below,
    //                 'order_level' => $order_level,
    //                 'sell_profit_percent' => $defined_sell_percentage,
    //                 'lth_functionality'=>$lth_functionality,
    //                 'lth_profit'=>(float)$lth_profit
    //             );

    //             $check_exist = $this->mod_percentile_trigger->check_of_previous_buy_order_exist_for_current_user($admin_id, $buy_parent_id);

    //             //%%%%%%%%%%%%%% Check of Level Meet %%%%%%%%%%
    //             if ($check_exist && $is_barrier_rule_trule) {

    //                 //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //                 $ins_orders_data = array(
    //                     'symbol' => $coin_symbol,
    //                     'purchased_price' => (float) ($current_market_price),
    //                     'quantity' => $buy_quantity,
    //                     'profit_type' => 'percentage',
    //                     'order_type' => $order_type,
    //                     'admin_id' => $admin_id,
    //                     'buy_order_check' => 'yes',
    //                     'buy_order_binance_id' => '',
    //                     'stop_loss' => 'no',
    //                     'loss_percentage' => '',
    //                     'created_date' => $this->mongo_db->converToMongodttime($date),
    //                     'modified_date' => $this->mongo_db->converToMongodttime($created_date),
    //                     'market_value' => (float) $current_market_price,
    //                     'application_mode' => $application_mode,
    //                     'order_mode' => $order_mode,
    //                     'trigger_type' => $buy_trigger_type,
    //                     'sell_profit_percent' => $defined_sell_percentage,
    //                     'order_level' => $order_level,
    //                 );

    //                 $ins_orders_data['sell_price'] = (float) $sell_price;

    //                 $ins_orders_data['trail_check'] = 'no';
    //                 $ins_orders_data['trail_interval'] = '0';
    //                 $ins_orders_data['sell_trail_price'] = '0';
    //                 $ins_orders_data['status'] = 'new';

    //                 //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //                 $this->mod_barrier_trigger->save_order_time_track($coin_symbol);
    //                 $make_new_order_in_orders_collection = true;
    //                 $is_live_order = false;

    //                 if ($application_mode == 'live') {
    //                     $trading_ip = $this->mod_barrier_trigger->get_user_trading_ip($admin_id);
    //                     $is_live_order = true;
    //                     $ins_data_buy_order['status'] = 'new';
    //                     $ins_data_buy_order['trading_ip'] = 'trading_ip';
    //                     $buy_order_id = $this->mongo_db->insert('buy_orders', $ins_data_buy_order);
    //                     // %%%%%%%%%%%% store order id in array %%%%%%%%%%%%%%%%%%%%%%%%
    //                     $ins_orders_data['buy_order_id'] = $buy_order_id;


                
    //                     //%%%%%%%%%%%%%%%%%%%%%% Save Temp orders %%%%%%%%%%%%%%
    //                     $this->mongo_db->insert('temp_ip_orders', $ins_orders_data);

    //                     //%%%%%%%%%%%%%%%%%%%%%%% Order send
    //                     $log_msg = 'Order was send for buy on : <b>' . num($current_market_price) . '</b> ';
    //                     $this->mod_box_trigger_3->insert_order_history_log($buy_order_id, $log_msg, 'buy_price', $admin_id, $created_date);

    //                     $log_msg = 'Send order for buy by Ip:<blod>' . $trading_ip . '</bold>';

    //                     $this->mod_barrier_trigger->insert_developer_log($buy_order_id, $log_msg, 'Message', $created_date, $show_error_log = 'yes');

    //                     $trigger_type = 'barrier_trigger';
    //                     $this->mod_barrier_trigger->order_ready_for_buy_by_ip($buy_order_id, $buy_quantity, $current_market_price, $coin_symbol, $admin_id, $trading_ip, $trigger_type, 'buy_market_order');

    //                     // $res_market_order = $this->mod_dashboard->binance_buy_auto_market_order_live($buy_order_id, $buy_quantity, $current_market_price, $coin_symbol, $admin_id);

    //                     // if(isset($res_market_order['error'])){
    //                     //     $make_new_order_in_orders_collection = false;
    //                     // }

    //                     //%%%%%%%%%%%%%%%%55 Live Order Log %%%%%%%%%%%%%%%%%%%%%%%

    //                     $this->mod_barrier_trigger->insert_developer_log($buy_order_id, $log_msg_success, 'Message', $created_date, $show_error_log = 'yes');

    //                     $log_m = 'Initial Trail Stop is : ' . num($iniatial_trail_stop) . '  Stop Loss  ' . $stop_loss_percent.' %';

    //                     $this->mod_barrier_trigger->insert_order_history_log($buy_order_id, $log_m, 'buy_commision', $admin_id, $created_date);

    //                     ////////////////////// Set Notification //////////////////
    //                     $message = "Buy Market Order is <b>buyed</b> as status Filled market_price=" . number_format($current_market_price, 8) . "  buy_price  " . number_format($buy_price, 8);
    //                     $this->mod_barrier_trigger->add_notification($buy_order_id, 'buy', $message, $admin_id);

    //                     $this->mod_barrier_trigger->save_rules_for_orders($buy_order_id, $coin_symbol, $order_type = 'buy', $rule, $mode = 'live');

    //                     //%%%%%%%%%%%%%%%%%% End of Live Order Log %%%%%%%%%%%%%%%%%
    //                 } else {
    //                     // %%%%%%%%%%% Test Order Part Start %%%%%%%%%%%%%%%%%%
    //                     //****************************************************** */
    //                     $ins_data_buy_order['is_sell_order'] = 'yes';
    //                     $ins_data_buy_order['status'] = 'FILLED';
    //                     $ins_data_buy_order['market_value'] = $current_market_price;

    //                     $buy_order_id = $this->mongo_db->insert('buy_orders', $ins_data_buy_order);

    //                     // %%%%%%%%%%%% store order id in array %%%%%%%%%%%%%%%%%%%%%%%%
    //                     $ins_orders_data['buy_order_id'] = $buy_order_id;

    //                     $this->mod_barrier_trigger->save_rules_for_orders($buy_order_id, $coin_symbol, $order_type = 'buy', $rule, $mode = 'test_live');

    //                     //%%%%%%%%%%% Messages Part %%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //                     //Message Lof For Test
    //                     $log_msg = " Order was Buyed at Price " . number_format($current_market_price, 8);
    //                     $this->mod_barrier_trigger->insert_order_history_log($buy_order_id, $log_msg, 'buy_created', $admin_id, $created_date);

    //                     $this->mod_barrier_trigger->insert_developer_log($buy_order_id, $log_msg_success, 'Message', $created_date, $show_error_log = 'yes');

    //                     $m_log =  'Initial Trail Stop is : ' . num($iniatial_trail_stop) . '  Stop Loss  ' . $stop_loss_percent.' %';

    //                     $this->mod_barrier_trigger->insert_order_history_log($buy_order_id, $m_log, 'buy_commision', $admin_id, $created_date);

    //                     ////////////////////// Set Notification //////////////////
    //                     $message = "Buy Market Order is <b>buyed</b> as status Filled market_price=" . number_format($current_market_price, 8) . "  buy_price  " . number_format($buy_price, 8);
    //                     $this->mod_barrier_trigger->add_notification($buy_order_id, 'buy', $message, $admin_id);

    //                     //Check Market History
    //                     $commission = $buy_quantity * (0.001);
    //                     $commissionAsset = str_replace('BTC', '', $symbol);

    //                     ////////////////////////////// Order History Log /////////////////////////////////////////////
    //                     $log_msg = "Broker Fee <b>" . num($commission) . " " . $commissionAsset . "</b> has token on this Trade";
    //                     $this->mod_barrier_trigger->insert_order_history_log($buy_order_id, $log_msg, 'buy_commision', $admin_id, $created_date);
    //                     ////////////////////////////// End Order History Log

    //                     //%%%%%%%%%%%%%%%%% End of Messages Part %%%%%%%%%%%%%%%%%
    //                     $order_id = $this->mongo_db->insert('orders', $ins_orders_data);
    //                     $upd_data22 = array(
    //                         'sell_order_id' => $order_id,
    //                         'is_sell_order' => 'yes',
    //                     );
    //                     $this->mongo_db->where(array('_id' => $buy_order_id));
    //                     $this->mongo_db->set($upd_data22);
    //                     //Update data in mongoTable
    //                     $this->mongo_db->update('buy_orders');
    //                 } //End of test part
    //             } //if open trade Exist
    //         } //End of parent order array
    //     } //End of parent ordr count
    //     echo 'end of function' . date('y-m-d H:i:s');
    // } //End of go_buy_barrier_percentile_trigger_order

    // public function is_rules_true($coin_symbol, $order_level,$global_setting_arr) {

    //     $triggers_type = 'barrier_percentile_trigger';
    //     $order_mode = 'live';
    //     $log_arr = array();


    //     $current_market_price = $this->mod_dashboard->get_market_value($coin_symbol);
    //     $current_market_price = (float) $current_market_price;

    //     $global_setting_arr = $global_setting_arr[0];

        

    //     $barrier_range_percentage = $global_setting_arr['barrier_percentile_trigger_barrier_range_percentage'];
    //     $barrier_range_percentage = ($barrier_range_percentage == '')?1:$barrier_range_percentage;

    //     $coin_meta_arr = $this->mod_barrier_trigger->get_coin_meta_data($coin_symbol);
    //     $coin_meta_arr = (array) $coin_meta_arr[0];

    //     $five_minute_rolling_candel = $coin_meta_arr['sellers_buyers_per'];
    //     $fifteen_minute_rolling_candel = $coin_meta_arr['sellers_buyers_per_fifteen'];

    //     $buyers_fifteen = $coin_meta_arr['buyers_fifteen'];
    //     $sellers_fifteen = $coin_meta_arr['sellers_fifteen'];

    //     $black_wall_pressure = $coin_meta_arr['black_wall_pressure'];
    //     $seven_level_depth = $coin_meta_arr['seven_level_depth'];

    //     $last_200_buy_vs_sell = $coin_meta_arr['last_200_buy_vs_sell'];
    //     $last_200_time_ago = (float) $coin_meta_arr['last_200_time_ago'];
    //     $last_qty_buy_vs_sell = $coin_meta_arr['last_qty_buy_vs_sell'];
    //     $last_qty_time_ago = (float) $coin_meta_arr['last_qty_time_ago'];

    //     $coin_meta_hourly_arr = $this->mod_box_trigger_3->get_coin_meta_hourly_percentile($coin_symbol);
    //     $coin_meta_hourly_arr = (array) $coin_meta_hourly_arr[0];


           
        
    //     $enable_buy_barrier_percentile = $global_setting_arr['enable_buy_barrier_percentile'];
    //     if ($enable_buy_barrier_percentile == 'not' || $enable_buy_barrier_percentile == '') {
    //         $log_arr['Percentile_Level_'.$order_level.'_status'] = '<span style="color:red">OFF</span>';
    //         return $log_arr;
    //     }//End of 


    //     $log_arr['Order_Is_Buyed_By_Level'] = $order_level . '<br>';
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%% Buyers  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        
    //     $barrier_percentile_trigger_buyers_buy = $global_setting_arr['barrier_percentile_trigger_buyers_buy'];
    //     $barrier_percentile_trigger_buyers_buy_apply = $global_setting_arr['barrier_percentile_trigger_buyers_buy_apply'];

    //     $buyers_recommended_percentile_value = $coin_meta_hourly_arr['buyers_fifteen_' . $barrier_percentile_trigger_buyers_buy];

    //     $buyers_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($barrier_percentile_trigger_buyers_buy_apply == 'yes') {
    //         if ($buyers_fifteen >= $buyers_recommended_percentile_value) {
    //             $buyers_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $buyers_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['Buyers_status'] = $rule_on_off;
    //     $log_arr['Buyers_recommended_percentile'] = $barrier_percentile_trigger_buyers_buy;
    //     $log_arr['Buyers_recommended_percentile_value'] = $buyers_recommended_percentile_value;
    //     $log_arr['Buyer_current_value'] = $buyers_fifteen . '<br>';

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%% Sellers  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     $seller_percentile = $global_setting_arr['barrier_percentile_trigger_sellers_buy'];
    //     $barrier_percentile_trigger_sellers_buy_apply = $global_setting_arr['barrier_percentile_trigger_sellers_buy_apply'];

    //     $sellers_recommended_percentile_value = $coin_meta_hourly_arr['sellers_fifteen_b_' . $seller_percentile];

    //     $sellers_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($barrier_percentile_trigger_sellers_buy_apply == 'yes') {
    //         if ($sellers_fifteen <= $sellers_recommended_percentile_value) {
    //             $sellers_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $sellers_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['Sellers_status'] = $rule_on_off;
    //     $log_arr['Sellers_recommended_percentile'] = $seller_percentile;
    //     $log_arr['Sellers_recommended_percentile_value'] = $sellers_recommended_percentile_value;
    //     $log_arr['Sellers_current_value'] = $sellers_fifteen . '<br>';

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% Last Procedding Orders %%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     $last_procedding_status = $this->mod_barrier_trigger->last_procedding_candle_status($coin_symbol);
    //     $current_candel_status = $global_setting_arr['percentile_trigger_last_candle_type'];
    //     $candel_status_meet = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($global_setting_arr['barrier_percentile_is_previous_blue_candel'] == 'yes') {
    //         if ($last_procedding_status == $current_candel_status) {
    //             $candel_status_meet = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $candel_status_meet = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['last_candel_status'] = $rule_on_off;
    //     $log_arr['recommended_candel_status'] = $current_candel_status;
    //     $log_arr['Last_procedding_candel_status'] = $last_procedding_status . '<br>';

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%




    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     $last_barrrier_value = $this->mod_percentile_trigger->barrier_status_down($coin_symbol, $barrier_status = 'very_strong_barrier', $current_market_price);

    //     $barrier_value_range_upside = $last_barrrier_value + ($last_barrrier_value / 100) * $barrier_range_percentage;
    //     $barrier_value_range_down_side = $last_barrrier_value - ($last_barrrier_value / 100) * $barrier_range_percentage;

    //     $meet_condition_for_buy = false;
    //     $rule_on_off = '<span style="color:red">NO</span>';
    //     if ((num($current_market_price) >= num($barrier_value_range_down_side)) && (num($current_market_price) <= num($barrier_value_range_upside))) {
    //         $meet_condition_for_buy = true;
    //         $rule_on_off = '<span style="color:green">YES</span>';
    //     }
    //     $log_arr['is_Barrier_Meet'] = $rule_on_off;
    //     $log_arr['Last_Barrier_price'] = num($last_barrrier_value);
    //     $log_arr['Barrier_Range_percentage'] = $barrier_range_percentage;
    //     $log_arr['Barrier_Range'] = 'Barrir From <b>(' . num($barrier_value_range_down_side) . ')</b> To  <b>(' . num($barrier_value_range_upside) . ')</b><br>';

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $percentile_trigger_15_minute_rolling_candel = $global_setting_arr['barrier_percentile_trigger_15_minute_rolling_candel'];
    //     $percentile_trigger_15_minute_rolling_candel_apply = $global_setting_arr['barrier_percentile_trigger_15_minute_rolling_candel_apply'];

    //     $percentile_trigger_15_minute_rolling_candel_actual_value = $coin_meta_hourly_arr['fifteen_min_' . $percentile_trigger_15_minute_rolling_candel];

    //     $fifteen_minute_rolling_candel_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($percentile_trigger_15_minute_rolling_candel_apply == 'yes') {
    //         if ($percentile_trigger_15_minute_rolling_candel_actual_value <= $fifteen_minute_rolling_candel) {
    //             $fifteen_minute_rolling_candel_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $fifteen_minute_rolling_candel_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['15_minute_rolling_candel_status'] = $rule_on_off;
    //     $log_arr['15_minute_rolling_candel_recommended_percentile'] = $percentile_trigger_15_minute_rolling_candel;
    //     $log_arr['15_minute_rolling_candel_recommended_percentile_value'] = $percentile_trigger_15_minute_rolling_candel_actual_value;
    //     $log_arr['15_minute_rolling_candel_current_value'] = $fifteen_minute_rolling_candel . '<br>';

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $percentile_trigger_5_minute_rolling_candel = $global_setting_arr['barrier_percentile_trigger_5_minute_rolling_candel'];
    //     $percentile_trigger_5_minute_rolling_candel_apply = $global_setting_arr['barrier_percentile_trigger_5_minute_rolling_candel_apply'];

    //     $percentile_trigger_5_minute_rolling_candel_actual_value = $coin_meta_hourly_arr['five_min_' . $percentile_trigger_5_minute_rolling_candel];

    //     $five_minute_rolling_candel_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($percentile_trigger_5_minute_rolling_candel_apply == 'yes') {
    //         if ($percentile_trigger_5_minute_rolling_candel_actual_value <= $five_minute_rolling_candel) {
    //             $five_minute_rolling_candel_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $five_minute_rolling_candel_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['5_minute_rolling_candel_status'] = $rule_on_off;
    //     $log_arr['5_minute_rolling_candel_recommended_percentile'] = $percentile_trigger_5_minute_rolling_candel;
    //     $log_arr['5_minute_rolling_candel_recommended_percentile_value'] = $percentile_trigger_5_minute_rolling_candel_actual_value;
    //     $log_arr['5_minute_rolling_candel_current_value'] = $five_minute_rolling_candel . '<br>';

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $percentile_trigger_black_wall = $global_setting_arr['barrier_percentile_trigger_buy_black_wall'];
    //     $percentile_trigger_black_wall_apply = $global_setting_arr['barrier_percentile_trigger_buy_black_wall_apply'];
    //     $percentile_trigger_black_wall_actual_value = $coin_meta_hourly_arr['blackwall_' . $percentile_trigger_black_wall];

    //     $black_wall_yes_no = true;

    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($percentile_trigger_black_wall_apply == 'yes') {
    //         if ($percentile_trigger_black_wall_actual_value <= $black_wall_pressure) {
    //             $black_wall_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $black_wall_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['black_wall_status'] = $rule_on_off;
    //     $log_arr['black_wall_recommended_percentile'] = $percentile_trigger_black_wall;
    //     $log_arr['black_wall_recommended_percentile_value'] = $percentile_trigger_black_wall_actual_value;
    //     $log_arr['black_wall_current_value'] = $black_wall_pressure . '<br>';
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $percentile_trigger_virtual_barrier = $global_setting_arr['barrier_percentile_trigger_buy_virtual_barrier'];
    //     $percentile_trigger_virtual_barrier_apply = $global_setting_arr['barrier_percentile_trigger_buy_virtual_barrier_apply'];
    //     $barrrier_actual_value = $coin_meta_hourly_arr['bid_quantity_' . $percentile_trigger_virtual_barrier];

    //     //*********************************************************************/
    //     $coin_offset_value = $this->mod_coins->get_coin_offset_value($coin_symbol);
    //     $coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);

    //     $total_bid_quantity = 0;
    //     for ($i = 0; $i < $coin_offset_value; $i++) {
    //         $new_last_barrrier_value = $current_market_price - ($coin_unit_value * $i);
    //         $bid = $this->mod_barrier_trigger->get_market_volume($new_last_barrrier_value, $coin_symbol, $type = 'bid');
    //         $total_bid_quantity += $bid;
    //     } //End of Coin off Set

    //     //*********************************************************************/
    //     $virtual_barrier_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($percentile_trigger_virtual_barrier_apply == 'yes') {
    //         if ($barrrier_actual_value <= $total_bid_quantity) {
    //             $virtual_barrier_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $virtual_barrier_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['virtual_barrier_status'] = $rule_on_off;
    //     $log_arr['virtual_barrier_recommended_percentile'] = $percentile_trigger_virtual_barrier;
    //     $log_arr['virtual_barrier_recommended_percentile_value'] = $barrrier_actual_value;
    //     $log_arr['virtual_barrier_current_value'] = $total_bid_quantity . '<br>';
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $percentile_trigger_seven_level_pressure = $global_setting_arr['barrier_percentile_trigger_buy_seven_level_pressure'];
    //     $percentile_trigger_seven_level_pressure_apply = $global_setting_arr['barrier_percentile_trigger_buy_seven_level_pressure_apply'];

    //     $seven_level_pressure_actual_value = $coin_meta_hourly_arr['sevenlevel_' . $percentile_trigger_seven_level_pressure];

    //     $seven_level_pressure_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($percentile_trigger_seven_level_pressure_apply == 'yes') {
    //         if ($seven_level_pressure_actual_value <= $seven_level_depth) {
    //             $seven_level_pressure_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $seven_level_pressure_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }
    //     $log_arr['seven_level_pressure_status'] = $rule_on_off;
    //     $log_arr['seven_level_pressure_recommended_percentile'] = $percentile_trigger_seven_level_pressure;
    //     $log_arr['seven_level_pressure_recommended_percentile_value'] = $seven_level_pressure_actual_value;
    //     $log_arr['seven_level_pressure_current_value'] = $seven_level_depth . '<br>';

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $last_200_contracts_buy_vs_sell_percentile_trigger = $global_setting_arr['barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell'];
    //     $last_200_contracts_buy_vs_sell_percentile_trigger_apply = $global_setting_arr['barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell_apply'];

    //     $last_200_contracts_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($last_200_contracts_buy_vs_sell_percentile_trigger_apply == 'yes') {
    //         if ($last_200_buy_vs_sell >= $last_200_contracts_buy_vs_sell_percentile_trigger) {
    //             $last_200_contracts_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $last_200_contracts_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }
    //     $log_arr['last_200_buy_vs_sell_status'] = $rule_on_off;
    //     $log_arr['last_200_buy_vs_sell_recommended_value'] = $last_200_contracts_buy_vs_sell_percentile_trigger;
    //     $log_arr['last_200_buy_vs_sell_current_value'] = $last_200_buy_vs_sell . '<br>';
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $last_200_contracts_time_percentile_trigger = $global_setting_arr['barrier_percentile_trigger_buy_last_200_contracts_time'];
    //     $last_200_contracts_time_percentile_trigger_apply = $global_setting_arr['barrier_percentile_trigger_buy_last_200_contracts_time_apply'];

    //     $last_200_contracts_time_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($last_200_contracts_time_percentile_trigger_apply == 'yes') {
    //         if ($last_200_time_ago <= $last_200_contracts_time_percentile_trigger) {
    //             $last_200_contracts_time_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $last_200_contracts_time_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }
    //     $log_arr['last_200_time_ago_status'] = $rule_on_off;
    //     $log_arr['last_200_time_ago_recommended_value'] = $last_200_contracts_time_percentile_trigger;
    //     $log_arr['last_200_time_ago_current_value'] = $last_200_time_ago . '<br>';
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $last_qty_contracts_buyer_vs_seller_percentile_trigger = $global_setting_arr['barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller'];
    //     $last_qty_contracts_buyer_vs_seller_percentile_trigger_apply = $global_setting_arr['barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller_apply'];

    //     $last_200_contracts_qty_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($last_qty_contracts_buyer_vs_seller_percentile_trigger_apply == 'yes') {
    //         if ($last_qty_buy_vs_sell >= $last_qty_contracts_buyer_vs_seller_percentile_trigger) {
    //             $last_200_contracts_qty_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $last_200_contracts_qty_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }
    //     $log_arr['last_qty_buy_vs_sell_status'] = $rule_on_off;
    //     $log_arr['last_qty_buy_vs_sell_recommended_value'] = $last_qty_contracts_buyer_vs_seller_percentile_trigger;
    //     $log_arr['last_qty_buy_vs_sell_current_value'] = $last_qty_buy_vs_sell . '<br>';
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $last_qty_contracts_time_percentile_trigger = $global_setting_arr['barrier_percentile_trigger_buy_last_qty_contracts_time'];
    //     $last_qty_contracts_time_percentile_trigger_apply = $global_setting_arr['barrier_percentile_trigger_buy_last_qty_contracts_time_apply'];

    //     $last_qty_contracts_time_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($last_qty_contracts_time_percentile_trigger_apply == 'yes') {
    //         if ($last_qty_time_ago <= $last_qty_contracts_time_percentile_trigger) {
    //             $last_qty_contracts_time_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $last_qty_contracts_time_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['last_qty_contracts_time_status'] = $rule_on_off;
    //     $log_arr['last_qty_contracts_time_recommended_value'] = $last_qty_contracts_time_percentile_trigger;
    //     $log_arr['last_qty_contracts_time_current_value'] = $last_qty_time_ago . '<br>';
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     $log_msg = '';
    //     foreach ($log_arr as $key => $value) {
    //         $log_msg .= $key . '=>' . $value . '<br>';
    //     }

    //     $is_buy_rule_on = false;
    //     if ($global_setting_arr['enable_buy_barrier_percentile'] == 'yes') {
    //         $is_buy_rule_on = true;
    //     }

    //     $is_rules_true = 'NO';
    //     if ($last_200_contracts_qty_yes_no && $last_200_contracts_time_yes_no && $last_200_contracts_yes_no && $black_wall_yes_no && $virtual_barrier_yes_no && $seven_level_pressure_yes_no && $last_qty_contracts_time_yes_no && $is_buy_rule_on && $five_minute_rolling_candel_yes_no && $fifteen_minute_rolling_candel_yes_no && $meet_condition_for_buy && $buyers_yes_no && $sellers_yes_no && $candel_status_meet) {
    //         $is_rules_true = 'YES';
    //     }

    //     $response['success_message'] = $is_rules_true;
    //     $response['log_message'] = $log_msg;

    //     echo '<pre>';
    //     print_r($log_msg);
    //     return $response;
    // } //End of is_rules_true

    //******************************************************************************* */

    ///////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////                           /////////////////
    ////////////////////                           ////////////////////////////////
    ////////////////////  Sell Order by Profit     /////////////////////////////////
    ////////////////////                           ////////////////////////////////
    ////////////////////                           /////////////////
    ////////////////////                           /////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////

    // public function test($coin_symbol,$order_level){
    //     $triggers_type = 'barrier_percentile_trigger';
    //     $order_mode = 'live';
    //     $global_setting_arr = $this->mod_percentile_trigger->get_trigger_global_setting($triggers_type, $order_mode, $coin_symbol, $order_level);
    //     $is_rules_true = $this->is_sell_rules_true($coin_symbol, $order_level,$global_setting_arr);
    // }

    // public function test_buy($coin_symbol,$order_level){
    //     $triggers_type = 'barrier_percentile_trigger';
    //     $order_mode = 'live';
    //     $global_setting_arr = $this->mod_percentile_trigger->get_trigger_global_setting($triggers_type, $order_mode, $coin_symbol, $order_level);
    //     $is_rules_true = $this->is_rules_true($coin_symbol, $order_level,$global_setting_arr);
    // }



    // public function go_sell_orders_on_defined_sell_price($coin_symbol, $order_level) {

    //     $created_date = date('Y-m-d G:i:s');

    //     $current_market_price = $this->mod_dashboard->get_market_value($coin_symbol);
    //     $market_price = (float) $current_market_price;
    //     $buy_orders_arr = $this->mod_percentile_trigger->get_profit_sell_orders($coin_symbol, $order_level);

    //     $coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);

    //     $triggers_type = 'barrier_percentile_trigger';
    //     $order_mode = 'live';
    //     $global_setting_arr = $this->mod_percentile_trigger->get_trigger_global_setting($triggers_type, $order_mode, $coin_symbol, $order_level);

    //     //%%%%%%%%%%%%%% trailing percentage %%%%%%%%%%%%%%%%%%%%%%%
    //     $trailing_stop_percentage = $global_setting_arr[0]['barrier_percentile_trigger_trailing_difference_between_stoploss_and_current_market_percentage'];
    //     $trailing_stop_percentage = ($trailing_stop_percentage == '')?0.2:$trailing_stop_percentage;

    //     //%%%%%%%%%%%%%%%%%%%%%%%% Barrier Trigger Type %%%%%%%%%%%%%%%%%%%%%%%%%%%%
        
    //     $level_profit_percentage = $global_setting_arr[0]['barrier_percentile_trigger_default_profit_percenage'];
        

    //     $is_rules_true = $this->is_sell_rules_true($coin_symbol, $order_level,$global_setting_arr);

   
    //     $is_barrier_rule_trule = false;
    //     $log_message = 'Order Sell By User Defined percentage';
    //     if ($is_rules_true['success_message'] == 'YES') {
    //         $log_message = $is_rules_true['log_message'];
    //         $this->mod_percentile_trigger->lock_barrier_trigger_true_rules($coin_symbol, '1', $type = 'sell', $current_market_price, $log_message, $order_level);
    //         $is_barrier_rule_trule = true;
    //     }

    //     if (count($buy_orders_arr) > 0) {
    //         foreach ($buy_orders_arr as $buy_orders) {
    //             $buy_orders_id = $buy_orders['_id'];
    //             $coin_symbol = $buy_orders['symbol'];
    //             $sell_price = $buy_orders['sell_price'];
    //             $admin_id = $buy_orders['admin_id'];
    //             $purchased_price = $buy_orders['price'];
    //             $buy_purchased_price = $buy_orders['market_value'];
    //             $iniatial_trail_stop = $buy_orders['iniatial_trail_stop'];
    //             $application_mode = $buy_orders['application_mode'];
    //             $quantity = $buy_orders['quantity'];
    //             $order_type = $buy_orders['order_type'];
    //             $order_mode = $buy_orders['order_mode'];
    //             $binance_order_id = $buy_orders['binance_order_id'];
    //             $trigger_type = $buy_orders['trigger_type'];
    //             $order_id = $buy_orders['sell_order_id'];
    //             $defined_sell_percentage = $buy_orders['defined_sell_percentage'];
    //             $market_value = $buy_orders['market_value'];

    //             $defined_sell_percentage = ($defined_sell_percentage == '') ? 0.5 : $defined_sell_percentage;

    //             $target_sell_price_by_user = $market_value + ($market_value / 100) * $defined_sell_percentage;

    //             $target_sell_price_by_level = $market_value + ($market_value / 100) * $level_profit_percentage;

    //             //Is sell or status is new
    //             $is_sell_order_status_new = $this->mod_barrier_trigger->is_sell_order_status_new($order_id);

    //             $sell_ordser_is_ready = false; 
    //             if($is_barrier_rule_trule){

    //                 if($level_profit_percentage != '' && $level_profit_percentage >0){
    //                     if($market_price >= $target_sell_price_by_level){
    //                         $sell_ordser_is_ready = true;
    //                     }
    //                 }

    //                 if(!$sell_ordser_is_ready){
    //                     if($market_price >= $target_sell_price_by_user){
    //                         $sell_ordser_is_ready = true;
    //                     }
    //                 }
    //             }else{
                    
    //                 if($market_price >= $target_sell_price_by_user){
    //                     $sell_ordser_is_ready = true;
    //                 }
    //             }

    //             //%%%%%%%%%%%% if Sell rule Fasle then check

    //             //%%%%%%%%%%%%%%%% -- Update market heighest value -- %%%%%%%%%%%%% 
    //             $this->market_heighest_value_for_current_order($buy_orders_id,$market_price);


    //             if ($sell_ordser_is_ready && $is_sell_order_status_new) {

    //                 $log_msg = 'Order was sell by : <b>' . $order_level . '</b> ';
    //                 $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'target_Price', $admin_id, $created_date);

    //                 $trading_ip = $this->mod_barrier_trigger->get_user_trading_ip($admin_id);

    //                 $log_message = $log_message . '    :<b>' . $defined_sell_percentage . '</b>';
    //                 $this->mod_barrier_trigger->insert_developer_log($buy_orders_id, $log_message, 'Message Sell', $created_date, $show_error_log = 'yes');

    //                 $trailing_price = $market_price - (($market_price / 100) * $trailing_stop_percentage);

    //                 $upd_data22 = array('iniatial_trail_stop' => $trailing_price, 'is_profit_updated_as_stop_loss' => 'yes');

    //                 $this->mongo_db->where(array('_id' => $buy_orders_id));
    //                 $this->mongo_db->set($upd_data22);
    //                 //Update data in mongoTable
    //                 $this->mongo_db->update('buy_orders');

    //                 $log_msg = 'Stop Loss update From: <b>(' . num($iniatial_trail_stop) . ')</b>  To <b> (' . num($trailing_price) . ')</b>  By Profit Meet: ' . $defined_sell_percentage;
    //                 $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'target_Price', $admin_id, $created_date);

    //                 //%%%%%%%%%%%%%%%%%%%% Disable Temporary

    //                 if (1 == 2) {
    //                     //Disable sell Order
    //                     /////////////////////////////////////
    //                     ///////////////////////////////////
    //                     $upd_data = array(
    //                         'buy_order_binance_id' => $binance_order_id,
    //                         'market_value' => (float) $market_price,
    //                         'sell_price' => (float) $market_price,
    //                         'modified_date' => $this->mongo_db->converToMongodttime($created_date),
    //                     );

    //                     $this->mongo_db->where(array('_id' => $order_id));
    //                     $this->mongo_db->set($upd_data);
    //                     $this->mongo_db->update('orders');
    //                     //Insert data in mongoTable
    //                     if ($application_mode == 'live') {

    //                         if ($this->is_order_already_not_send($buy_orders_id)) {
    //                             //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //                             $created_date = date('Y-m-d G:i:s');
    //                             $log_msg = 'Order Send for Sell ON :<b>' . num($market_price) . '</b> Price';
    //                             $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'Sell_Price', $admin_id, $created_date);

    //                             //Target price %%%%%%%%%%%

    //                             $log_msg = 'Order Target Sell Price : <b>' . num($target_sell_price) . '</b> Price';
    //                             $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'target_Price', $admin_id, $created_date);

    //                             //Profit Percentage
    //                             $log_msg = 'Order Profit percentage : <b>' . num($defined_sell_percentage) . '</b> ';
    //                             $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'profit_percantage', $admin_id, $created_date);

    //                             if ($order_type == 'limit_order') {

    //                                 if ($sell_one_tip_below == 'yes') {
    //                                     $one_unit_below_value = $market_price - $coin_unit_value;
    //                                     $market_price = $one_unit_below_value;
    //                                     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //                                     $log_msg = 'Send Limit Order On One tick Below: <b>' . num($market_price) . '</b> ';
    //                                     $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);

    //                                 } else {
    //                                     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //                                     $log_msg = 'Send Limit Order On Current Market Price: <b>' . num($market_price) . '</b> ';
    //                                     $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);
    //                                 }

    //                                 //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //                                 // $res_limit_order = $this->mod_dashboard->binance_sell_auto_limit_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id);

    //                                 $log_msg = 'Send Limit Orde for sell by Ip: <b>' . $trading_ip . '</b> ';

    //                                 $this->mod_barrier_trigger->insert_developer_log($buy_orders_id, $log_msg, 'Message', $created_date, $show_error_log);

    //                                 $trigger_type = 'barrier_trigger';
    //                                 $this->mod_barrier_trigger->order_ready_for_sell_by_ip($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id, $trading_ip, $trigger_type, 'sell_limit_order');

    //                                 // //if No Error Occure
    //                                 // if(!isset($res_limit_order['error'])){
    //                                 //     $this->mod_limit_order->save_follow_up_of_limit_sell_order($order_id,$buy_orders_id,$type='sell');
    //                                 // }

    //                             } else if ($order_type == 'stop_loss_limit_order') {

    //                                 $log_msg = 'Send stop loss limit order by Profit On Current Market Price: <b>' . num($market_price) . '</b> ';
    //                                 $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);

    //                                 $log_msg = 'Send stop loss limit order by stop_loss On trail stop price: <b>' . num($iniatial_trail_stop) . '</b> ';
    //                                 $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);

    //                                 $res_limit_order = $this->mod_dashboard->binance_sell_auto_stop_loss_limit_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id, $iniatial_trail_stop);

    //                             } else {

    //                                 $log_msg = 'Send Market Orde for sell by Ip: <b>' . $trading_ip . '</b> ';
    //                                 $this->mod_barrier_trigger->insert_developer_log($buy_orders_id, $log_msg, 'Message', $created_date, $show_error_log);

    //                                 $trigger_type = 'barrier_trigger';
    //                                 $this->mod_barrier_trigger->order_ready_for_sell_by_ip($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id, $trading_ip, $trigger_type, 'sell_market_order');

    //                                 // $this->mod_dashboard->binance_sell_auto_market_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id);
    //                             }

    //                             $this->mod_barrier_trigger->save_rules_for_orders($buy_orders_id, $coin_symbol, $order_type = 'sell', $rule, $mode = 'live');
    //                         } //End of if order already not send

    //                     } else {
    //                         //Sell With Normal Value
    //                         $upd_data_1 = array(
    //                             'status' => 'FILLED',
    //                         );
    //                         $this->mongo_db->where(array('_id' => $order_id));
    //                         $this->mongo_db->set($upd_data_1);
    //                         //Update data in mongoTable
    //                         $this->mongo_db->update('orders');
    //                         $upd_data = array(
    //                             'sell_order_id' => $order_id,
    //                             'is_sell_order' => 'sold',
    //                             'market_sold_price' => (float) $market_price,
    //                             'modified_date' => $this->mongo_db->converToMongodttime($created_date),
    //                         );
    //                         $this->mongo_db->where(array('_id' => $buy_orders_id));
    //                         $this->mongo_db->set($upd_data);
    //                         //Update data in mongoTable
    //                         $this->mongo_db->update('buy_orders');

    //                         $this->mod_barrier_trigger->save_rules_for_orders($buy_orders_id, $coin_symbol, $order_type = 'sell', $rule, $mode = 'test_live');

    //                         $message = 'Sell Order was Sold With profit';

    //                         //////////////////////////////////////////////////////////////////////////////
    //                         ////////////////////////////// Order History Log /////////////////////////////
    //                         $log_msg = $message . " " . number_format($market_price, 8);
    //                         $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'sell_created', $admin_id, $created_date);
    //                         ////////////////////////////// End Order History Log /////////////////////////
    //                         //////////////////////////////////////////////////////////////////////////////
    //                         ////////////////////// Set Notification //////////////////
    //                         $message = $message . " <b>Sold</b>";
    //                         $this->mod_box_trigger_3->add_notification($buy_orders_id, 'buy', $message, $admin_id);
    //                         //////////////////////////////////////////////////////////
    //                         //Check Market History
    //                         $commission_value = $quantity * (0.001);
    //                         $commission = $commission_value * $with;
    //                         $commissionAsset = 'BTC';
    //                         //////////////////////////////////////////////////////////////////////////////////////////////
    //                         ////////////////////////////// Order History Log /////////////////////////////////////////////
    //                         $log_msg = "Broker Fee <b>" . num($commission) . " " . $commissionAsset . "</b> has token on this Trade";
    //                         $created_date = date('Y-m-d G:i:s');
    //                         $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'sell_commision', $admin_id, $created_date);
    //                         ////////////////////////////// End Order History Log
    //                     } //if test live order
    //                 } //End Of Disable
    //             } //if markt price is greater then sell order
    //         } //End  of forEach buy orders
    //     } //Check of orders found
    // } //End of sell_orders_on_defined_sell_price

    // public function is_sell_rules_true($coin_symbol, $order_level,$global_setting_arr) {
    //     $triggers_type = 'barrier_percentile_trigger';
    //     $order_mode = 'live';

    //     $log_arr = array();
    //     $global_setting_arr = $global_setting_arr[0];

    //     $coin_meta_arr = $this->mod_barrier_trigger->get_coin_meta_data($coin_symbol);
    //     $coin_meta_arr = (array) $coin_meta_arr[0];

    //     $black_wall_pressure = $coin_meta_arr['black_wall_pressure'];
    //     $seven_level_depth = $coin_meta_arr['seven_level_depth'];

    //     $five_minute_rolling_candel = $coin_meta_arr['sellers_buyers_per'];
    //     $fifteen_minute_rolling_candel = $coin_meta_arr['sellers_buyers_per_fifteen'];

    //     $last_200_buy_vs_sell = $coin_meta_arr['last_200_buy_vs_sell'];
    //     $last_200_time_ago = (float) $coin_meta_arr['last_200_time_ago'];
    //     $last_qty_buy_vs_sell = $coin_meta_arr['last_qty_buy_vs_sell'];
    //     $last_qty_time_ago = (float) $coin_meta_arr['last_qty_time_ago'];

    //     $coin_meta_hourly_arr = $this->mod_box_trigger_3->get_coin_meta_hourly_percentile($coin_symbol);
    //     $coin_meta_hourly_arr = (array) $coin_meta_hourly_arr[0];

    //     $buyers_fifteen = $coin_meta_arr['buyers_fifteen'];
    //     $sellers_fifteen = $coin_meta_arr['sellers_fifteen'];

    //     $enable_sell_barrier_percentile = $global_setting_arr['enable_sell_barrier_percentile'];
    //     if ($enable_sell_barrier_percentile == 'not' || $enable_sell_barrier_percentile == '') {
    //         $log_arr['Percentile_Level_'.$order_level.'_status'] = '<span style="color:red">OFF</span>';
    //         return $log_arr;
    //     }

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%% Buyers  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     $barrier_percentile_trigger_buyers_buy = $global_setting_arr['barrier_percentile_trigger_buyers_sell'];
    //     $barrier_percentile_trigger_buyers_buy_apply = $global_setting_arr['barrier_percentile_trigger_buyers_sell_apply'];

    //     $buyers_recommended_percentile_value = $coin_meta_hourly_arr['buyers_fifteen_b_' . $barrier_percentile_trigger_buyers_buy];

    //     $buyers_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($barrier_percentile_trigger_buyers_buy_apply == 'yes') {
    //         if ($buyers_fifteen <= $buyers_recommended_percentile_value) {
    //             $buyers_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $buyers_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['Buyers_status'] = $rule_on_off;
    //     $log_arr['Buyers_recommended_percentile'] = $barrier_percentile_trigger_buyers_buy;
    //     $log_arr['Buyers_recommended_percentile_value'] = $buyers_recommended_percentile_value;
    //     $log_arr['Buyer_current_value'] = $buyers_fifteen . '<br>';

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%% Sellers  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     $seller_percentile = $global_setting_arr['barrier_percentile_trigger_sellers_sell'];
    //     $barrier_percentile_trigger_sellers_buy_apply = $global_setting_arr['barrier_percentile_trigger_sellers_sell_apply'];

    //     $sellers_recommended_percentile_value = $coin_meta_hourly_arr['sellers_fifteen_' . $seller_percentile];

    //     $sellers_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($barrier_percentile_trigger_sellers_buy_apply == 'yes') {
    //         if ($sellers_fifteen >= $sellers_recommended_percentile_value) {
    //             $sellers_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $sellers_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['Sellers_status'] = $rule_on_off;
    //     $log_arr['Sellers_recommended_percentile'] = $seller_percentile;
    //     $log_arr['Sellers_recommended_percentile_value'] = $sellers_recommended_percentile_value;
    //     $log_arr['Sellers_current_value'] = $sellers_fifteen . '<br>';

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $percentile_trigger_15_minute_rolling_candel = $global_setting_arr['barrier_percentile_trigger_15_minute_rolling_candel'];
    //     $percentile_trigger_15_minute_rolling_candel_apply = $global_setting_arr['barrier_percentile_trigger_15_minute_rolling_candel_apply'];

    //     $percentile_trigger_15_minute_rolling_candel_actual_value = $coin_meta_hourly_arr['fifteen_min_b_' . $percentile_trigger_15_minute_rolling_candel];

    //     $fifteen_minute_rolling_candel_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($percentile_trigger_15_minute_rolling_candel_apply == 'yes') {
    //         if ($percentile_trigger_15_minute_rolling_candel_actual_value >= $fifteen_minute_rolling_candel) {
    //             $fifteen_minute_rolling_candel_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $fifteen_minute_rolling_candel_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['15_minute_rolling_candel_status'] = $rule_on_off;
    //     $log_arr['15_minute_rolling_candel_recommended_percentile'] = $percentile_trigger_15_minute_rolling_candel;
    //     $log_arr['15_minute_rolling_candel_recommended_percentile_value'] = $percentile_trigger_15_minute_rolling_candel_actual_value;
    //     $log_arr['15_minute_rolling_candel_current_value'] = $fifteen_minute_rolling_candel . '<br>';

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $percentile_trigger_5_minute_rolling_candel = $global_setting_arr['barrier_percentile_trigger_5_minute_rolling_candel'];
    //     $percentile_trigger_5_minute_rolling_candel_apply = $global_setting_arr['barrier_percentile_trigger_5_minute_rolling_candel_apply'];

    //     $percentile_trigger_5_minute_rolling_candel_actual_value = $coin_meta_hourly_arr['five_min_b_' . $percentile_trigger_5_minute_rolling_candel];

    //     $five_minute_rolling_candel_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($percentile_trigger_5_minute_rolling_candel_apply == 'yes') {
    //         if ($percentile_trigger_5_minute_rolling_candel_actual_value >= $five_minute_rolling_candel) {
    //             $five_minute_rolling_candel_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $five_minute_rolling_candel_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['5_minute_rolling_candel_status'] = $rule_on_off;
    //     $log_arr['5_minute_rolling_candel_recommended_percentile'] = $percentile_trigger_5_minute_rolling_candel;
    //     $log_arr['5_minute_rolling_candel_recommended_percentile_value'] = $percentile_trigger_5_minute_rolling_candel_actual_value;
    //     $log_arr['5_minute_rolling_candel_current_value'] = $five_minute_rolling_candel . '<br>';

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $percentile_trigger_black_wall = $global_setting_arr['barrier_percentile_trigger_sell_black_wall'];

    //     $percentile_trigger_black_wall_apply = $global_setting_arr['barrier_percentile_trigger_sell_black_wall_apply'];

    //     $percentile_trigger_black_wall_actual_value = $coin_meta_hourly_arr['blackwall_b_' . $percentile_trigger_black_wall];

    //     $black_wall_yes_no = true;

    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($percentile_trigger_black_wall_apply == 'yes') {
    //         if ($percentile_trigger_black_wall_actual_value >= $black_wall_pressure) {
    //             $black_wall_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $black_wall_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['black_wall_status'] = $rule_on_off;
    //     $log_arr['black_wall_recommended_percentile'] = $percentile_trigger_black_wall;
    //     $log_arr['black_wall_recommended_percentile_value'] = $percentile_trigger_black_wall_actual_value;
    //     $log_arr['black_wall_current_value'] = $black_wall_pressure . '<br>';

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $percentile_trigger_virtual_barrier = $global_setting_arr['barrier_percentile_trigger_sell_virtual_barrier'];
    //     $percentile_trigger_virtual_barrier_apply = $global_setting_arr['barrier_percentile_trigger_sell_virtual_barrier_apply'];
    //     $barrrier_actual_value = $coin_meta_hourly_arr['bid_quantity_b_' . $percentile_trigger_virtual_barrier];

    //     //*********************************************************************/
    //     $coin_offset_value = $this->mod_coins->get_coin_offset_value($coin_symbol);
    //     $coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);
    //     $current_market_price = $this->mod_dashboard->get_market_value($coin_symbol);
    //     $current_market_price = (float) $current_market_price;

    //     $total_bid_quantity = 0;
    //     for ($i = 0; $i < $coin_offset_value; $i++) {
    //         $new_last_barrrier_value = $current_market_price - ($coin_unit_value * $i);
    //         $bid = $this->mod_barrier_trigger->get_market_volume($new_last_barrrier_value, $coin_symbol, $type = 'ask');
    //         $total_bid_quantity += $bid;
    //     } //End of Coin off Set

    //     //*********************************************************************/
    //     $virtual_barrier_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($percentile_trigger_virtual_barrier_apply == 'yes') {
    //         if ($barrrier_actual_value <= $total_bid_quantity) {
    //             $virtual_barrier_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $virtual_barrier_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['virtual_barrier_status'] = $rule_on_off;
    //     $log_arr['virtual_barrier_recommended_percentile'] = $percentile_trigger_virtual_barrier;
    //     $log_arr['virtual_barrier_recommended_percentile_value'] = $barrrier_actual_value;
    //     $log_arr['virtual_barrier_current_value'] = $total_bid_quantity . '<br>';
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $percentile_trigger_seven_level_pressure = $global_setting_arr['barrier_percentile_trigger_sell_seven_level_pressure'];
    //     $percentile_trigger_seven_level_pressure_apply = $global_setting_arr['barrier_percentile_trigger_sell_seven_level_pressure_apply'];

    //     $seven_level_pressure_actual_value = $coin_meta_hourly_arr['sevenlevel_b_' . $percentile_trigger_seven_level_pressure];

    //     $seven_level_pressure_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($percentile_trigger_seven_level_pressure_apply == 'yes') {
    //         if ($seven_level_pressure_actual_value >= $seven_level_depth) {
    //             $seven_level_pressure_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $seven_level_pressure_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }
    //     $log_arr['seven_level_pressure_status'] = $rule_on_off;
    //     $log_arr['seven_level_pressure_recommended_percentile'] = $percentile_trigger_seven_level_pressure;
    //     $log_arr['seven_level_pressure_recommended_percentile_value'] = $seven_level_pressure_actual_value;
    //     $log_arr['seven_level_pressure_current_value'] = $seven_level_depth . '<br>';
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $last_200_contracts_buy_vs_sell_percentile_trigger = $global_setting_arr['barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell'];
    //     $last_200_contracts_buy_vs_sell_percentile_trigger_apply = $global_setting_arr['barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell_apply'];

    //     $last_200_contracts_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($last_200_contracts_buy_vs_sell_percentile_trigger_apply == 'yes') {
    //         if ($last_200_buy_vs_sell <= $last_200_contracts_buy_vs_sell_percentile_trigger) {
    //             $last_200_contracts_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $last_200_contracts_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }
    //     $log_arr['last_200_buy_vs_sell_status'] = $rule_on_off;
    //     $log_arr['last_200_buy_vs_sell_recommended_value'] = $last_200_contracts_buy_vs_sell_percentile_trigger;
    //     $log_arr['last_200_buy_vs_sell_current_value'] = $last_200_buy_vs_sell . '<br>';
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $last_200_contracts_time_percentile_trigger = $global_setting_arr['barrier_percentile_trigger_sell_last_200_contracts_time'];
    //     $last_200_contracts_time_percentile_trigger_apply = $global_setting_arr['barrier_percentile_trigger_sell_last_200_contracts_time_apply'];

    //     $last_200_contracts_time_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($last_200_contracts_time_percentile_trigger_apply == 'yes') {
    //         if ($last_200_time_ago <= $last_200_contracts_time_percentile_trigger) {
    //             $last_200_contracts_time_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $last_200_contracts_time_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }
    //     $log_arr['last_200_time_ago_status'] = $rule_on_off;
    //     $log_arr['last_200_time_ago_recommended_value'] = $last_200_contracts_time_percentile_trigger;
    //     $log_arr['last_200_time_ago_current_value'] = $last_200_time_ago . '<br>';
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $last_qty_contracts_buyer_vs_seller_percentile_trigger = $global_setting_arr['barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller'];
    //     $last_qty_contracts_buyer_vs_seller_percentile_trigger_apply = $global_setting_arr['barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller_apply'];

    //     $last_200_contracts_qty_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($last_qty_contracts_buyer_vs_seller_percentile_trigger_apply == 'yes') {
    //         if ($last_qty_buy_vs_sell <= $last_qty_contracts_buyer_vs_seller_percentile_trigger) {
    //             $last_200_contracts_qty_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $last_200_contracts_qty_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['last_qty_buy_vs_sell_status'] = $rule_on_off;
    //     $log_arr['last_qty_buy_vs_sell_recommended_value'] = $last_qty_contracts_buyer_vs_seller_percentile_trigger;
    //     $log_arr['last_qty_buy_vs_sell_current_value'] = $last_qty_buy_vs_sell . '<br>';
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $last_qty_contracts_time_percentile_trigger = $global_setting_arr['barrier_percentile_trigger_sell_last_qty_contracts_time'];
    //     $last_qty_contracts_time_percentile_trigger_apply = $global_setting_arr['barrier_percentile_trigger_sell_last_qty_contracts_time_apply'];

    //     $last_qty_contracts_time_yes_no = true;
    //     $rule_on_off = '<span style="background-color:yellow">OFF</span>';
    //     if ($last_qty_contracts_time_percentile_trigger_apply == 'yes') {
    //         if ($last_qty_time_ago <= $last_qty_contracts_time_percentile_trigger) {
    //             $last_qty_contracts_time_yes_no = true;
    //             $rule_on_off = '<span style="color:green">YES</span>';
    //         } else {
    //             $last_qty_contracts_time_yes_no = false;
    //             $rule_on_off = '<span style="color:red">NO</span>';
    //         }
    //     }

    //     $log_arr['last_qty_contracts_time_status'] = $rule_on_off;
    //     $log_arr['last_qty_contracts_time_recommended_value'] = $last_qty_contracts_time_percentile_trigger;
    //     $log_arr['last_qty_contracts_time_current_value'] = $last_qty_time_ago . '<br>';
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     $log_msg = '';
    //     foreach ($log_arr as $key => $value) {
    //         $log_msg .= $key . '=>' . $value . '<br>';
    //     }
    //     $is_rules_true = 'NO';
    //     if ($last_200_contracts_qty_yes_no && $last_200_contracts_time_yes_no && $last_200_contracts_yes_no && $black_wall_yes_no && $virtual_barrier_yes_no && $seven_level_pressure_yes_no && $last_qty_contracts_time_yes_no && $fifteen_minute_rolling_candel_yes_no && $five_minute_rolling_candel_yes_no) {
    //         $is_rules_true = 'YES';
    //     }


    //     echo '<pre>';
    //     print_r($log_msg);
   

    //     $response['success_message'] = $is_rules_true;
    //     $response['log_message'] = $log_msg;

    //     return $response;
    // } //End of is_rules

    //%%%%%%%%%%%%%%%%%%%%%%% Test Trigger End %%%%%%%%%%%%%%%%%%%%%%%%%

    ///////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////                           /////////////////
    ////////////////////                           ////////////////////////
    ////////////////////  Sell Part                 //////////////////////
    ////////////////////                           //////////////////////
    ////////////////////                           /////////////////
    ////////////////////                           /////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////                           /////////////////
    ////////////////////                           ////////////////////////////////
    ////////////////////  Sell Order by stop loss  /////////////////////////////////
    ////////////////////                           ////////////////////////////////
    ////////////////////                           /////////////////
    ////////////////////                           /////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////

    // public function is_order_already_not_send($buy_orders_id) {
    //     $buy_orders_id_obj = $this->mongo_db->mongoId($buy_orders_id);
    //     $this->mongo_db->where(array('buy_orders_id' => $buy_orders_id_obj));
    //     $response = $this->mongo_db->get('ready_orders_for_sell_ip_based');
    //     $result = iterator_to_array($response);
    //     $resp = true;
    //     if (!empty($result)) {
    //         $resp = false;
    //     }
    //     return $resp;
    // } //End of is_order_already_not_send

    // public function go_sell_order_by_stop_loss($coin_symbol) {

    //     $created_date = date('Y-m-d G:i:s');
    //     $current_market_price = $this->mod_dashboard->get_market_value($coin_symbol);
    //     $market_price = (float) $current_market_price;

    //     $buy_orders_arr = $this->mod_percentile_trigger->get_stop_loss_orders($coin_symbol);
    //     $coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);

    //     if (count($buy_orders_arr) > 0) {
    //         foreach ($buy_orders_arr as $buy_orders) {
    //             $buy_orders_id = $buy_orders['_id'];
    //             $coin_symbol = $buy_orders['symbol'];
    //             $sell_price = $buy_orders['sell_price'];
    //             $admin_id = $buy_orders['admin_id'];
    //             $purchased_price = $buy_orders['price'];
    //             $buy_purchased_price = $buy_orders['market_value'];
    //             $iniatial_trail_stop = $buy_orders['iniatial_trail_stop'];
    //             $application_mode = $buy_orders['application_mode'];
    //             $quantity = $buy_orders['quantity'];
    //             $order_type = $buy_orders['order_type'];
    //             $order_mode = $buy_orders['order_mode'];
    //             $binance_order_id = $buy_orders['binance_order_id'];
    //             $trigger_type = $buy_orders['trigger_type'];
    //             $order_id = $buy_orders['sell_order_id'];
    //             $defined_sell_percentage = $buy_orders['defined_sell_percentage'];
    //             $market_value = $buy_orders['market_value'];

    //             $lth_functionality = $buy_orders['lth_functionality'];
    //             $purchase_price = $buy_orders['market_value'];

    //             $iniatial_trail_stop = $buy_orders['iniatial_trail_stop'];

    //             $target_sell_price = $market_value - ($market_value / 100) * $defined_sell_percentage;

    //             //Is sell or status is new
    //             $is_sell_order_status_new = $this->mod_barrier_trigger->is_sell_order_status_new($order_id);


    //             $this->market_heighest_value_for_current_order($buy_orders_id,$market_price);

    //             // -- %%%%%%%%%%% If Long Time Hold is yes --%%%%%%%%%%
    //             $is_long_time_hold = true;
    //             if ($lth_functionality == 'yes') {
    //                 if ($iniatial_trail_stop <= $purchase_price) {
    //                     $is_long_time_hold = false;
    //                     $this->make_order_long_time_hold($order_id, $buy_orders_id, $admin_id);
    //                 }
    //             } // %%%%%%%%%%%% -- End of LTH Status check -- %%%%%%%%

    //             if (($market_price <= $iniatial_trail_stop) && $is_sell_order_status_new && $is_long_time_hold) {

    //                 $trading_ip = $this->mod_barrier_trigger->get_user_trading_ip($admin_id);

    //                 /////////////////////////////////////
    //                 ///////////////////////////////////
    //                 $upd_data = array(
    //                     'buy_order_binance_id' => $binance_order_id,
    //                     'market_value' => (float) $market_price,
    //                     'sell_price' => (float) $market_price,
    //                     'modified_date' => $this->mongo_db->converToMongodttime($created_date),
    //                 );

    //                 $this->mongo_db->where(array('_id' => $order_id));
    //                 $this->mongo_db->set($upd_data);
    //                 $this->mongo_db->update('orders');
    //                 //Insert data in mongoTable
    //                 if ($application_mode == 'live') {

    //                     if ($this->is_order_already_not_send($buy_orders_id)) {

    //                         $trading_ip = $this->mod_barrier_trigger->get_user_trading_ip($admin_id);
    //                         //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //                         $created_date = date('Y-m-d G:i:s');
    //                         $htm = '<span style="color:red;    font-size: 14px;"><b>Stop Loss</b></span>';

    //                         $log_msg = 'Order Send for Sell by ' . $htm . ' ON :<b>' . num($market_price) . '</b> Price';
    //                         $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'Sell_Price', $admin_id, $created_date);

    //                         //%%%%%%%%%%%%%%% Target price %%%%%%%%%%%
    //                         $log_msg = 'Expected Stop Loss value : <b>' . num($iniatial_trail_stop) . '</b> ';
    //                         $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'Expected Stop Loss', $admin_id, $created_date);

    //                         $log_msg = 'Send Market Orde for sell by Ip: <b>' . $trading_ip . '</b> ';
    //                         $this->mod_barrier_trigger->insert_developer_log($buy_orders_id, $log_msg, 'Message', $created_date, $show_error_log = 'yes');

    //                         $trigger_type = 'barrier_trigger';
    //                         $this->mod_barrier_trigger->order_ready_for_sell_by_ip($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id, $trading_ip, $trigger_type, 'sell_stop_loss_order');
    //                     } //End of is already not send

    //                     $this->mod_barrier_trigger->save_rules_for_orders($buy_orders_id, $coin_symbol, $order_type = 'sell', 0, $mode = 'live');

    //                     // $res = $this->mod_dashboard->binance_sell_auto_market_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id);

    //                 } else {
    //                     //Sell With Normal Value
    //                     $upd_data_1 = array(
    //                         'status' => 'FILLED',
    //                     );
    //                     $this->mongo_db->where(array('_id' => $order_id));
    //                     $this->mongo_db->set($upd_data_1);
    //                     //Update data in mongoTable
    //                     $this->mongo_db->update('orders');
    //                     $upd_data = array(
    //                         'sell_order_id' => $order_id,
    //                         'is_sell_order' => 'sold',
    //                         'market_sold_price' => (float) $market_price,
    //                         'modified_date' => $this->mongo_db->converToMongodttime($created_date),
    //                     );
    //                     $this->mongo_db->where(array('_id' => $buy_orders_id));
    //                     $this->mongo_db->set($upd_data);
    //                     //Update data in mongoTable
    //                     $this->mongo_db->update('buy_orders');

    //                     $message = 'Sell Order was Sold With <b style="color:red"> STOP LOSS</b>';

    //                     //////////////////////////////////////////////////////////////////////////////
    //                     ////////////////////////////// Order History Log /////////////////////////////
    //                     $log_msg = $message . " " . number_format($market_price, 8);
    //                     $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'sell_created', $admin_id, $created_date);
    //                     ////////////////////////////// End Order History Log /////////////////////////
    //                     //////////////////////////////////////////////////////////////////////////////
    //                     ////////////////////// Set Notification //////////////////
    //                     $message = $message . " <b>Sold</b>";
    //                     $this->mod_box_trigger_3->add_notification($buy_orders_id, 'buy', $message, $admin_id);
    //                     //////////////////////////////////////////////////////////
    //                     //Check Market History
    //                     $commission_value = $quantity * (0.001);
    //                     $commission = $commission_value * $with;
    //                     $commissionAsset = 'BTC';
    //                     //////////////////////////////////////////////////////////////////////////////////////////////
    //                     ////////////////////////////// Order History Log /////////////////////////////////////////////
    //                     $log_msg = "Broker Fee <b>" . num($commission) . " " . $commissionAsset . "</b> has token on this Trade";
    //                     $created_date = date('Y-m-d G:i:s');
    //                     $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'sell_commision', $admin_id, $created_date);
    //                     ////////////////////////////// End Order History Log
    //                 } //if test live order
    //             } //if markt price is greater then sell order

    //         } //End  of forEach buy orders
    //     } //Check of orders found
    // } //End of go_sell_order_by_stop_loss

    // //%%%%%%%%%%%%%%%%%%%%%%% Hold Order for longtime %%%%%%%%%%%%

    // public function make_order_long_time_hold($order_id, $buy_orders_id, $admin_id) {
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $upd_lth['status'] = 'LTH';
    
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //     $this->mongo_db->where(array('_id' => $buy_orders_id));
    //     $this->mongo_db->set($upd_lth);
    //     //Update data in mongoTable
    //     $this->mongo_db->update('buy_orders');
    //     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //     $log_msg = 'Order Goes to <span style="color:orange;font-size: 14px;"><b>Long Term Hold</b> By System</span>';
    //     $created_date = date('Y-m-d G:i:s');
    //     $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'sell_created', $admin_id, $created_date);
    // } //End of make_order_long_time_hold


    // public function market_heighest_value_for_current_order($buy_orders_id,$market_price){
    //     $market_price = (float)$market_price;
    //     $where['_id'] = $buy_orders_id;
    //     $this->mongo_db->where($where);
    //     $orders = $this->mongo_db->get('buy_orders');
    //     $orders = iterator_to_array($orders);     
    //     if(count($orders)>0){
    //         if($orders[0]['market_heighest_value'] <$market_price){
    //             $heigh_market_value_arr = array('market_heighest_value' => $market_price);
    //             $this->mongo_db->where(array('_id' => $buy_orders_id));
    //             $this->mongo_db->set($heigh_market_value_arr);
    //             //Update data in mongoTable
    //             $this->mongo_db->update('buy_orders');
    //         } //if heigst value is less then   
    //     }//End of if orders Count Greater  
    //     //%%%%%%%%%%%%%%%%%%% Market Heigh value %%%%%%%%%%%%%%%%% 
    // }//End of market_heighest_value_for_current_order

    // public function sell_lth_profitable_order($coin_symbol) {
    //     $created_date = date('Y-m-d G:i:s');

    //     $current_market_price = $this->mod_dashboard->get_market_value($coin_symbol);
    //     $market_price = (float) $current_market_price;

    //     $buy_orders_arr = $this->mod_percentile_trigger->get_profit_defined_lth_orders($coin_symbol);
    //     $coin_unit_value = $this->mod_coins->get_coin_unit_value($coin_symbol);

    //     if (count($buy_orders_arr) > 0) {
    //         foreach ($buy_orders_arr as $buy_orders) {
    //             $buy_orders_id = $buy_orders['_id'];
    //             $coin_symbol = $buy_orders['symbol'];
    //             $sell_price = $buy_orders['sell_price'];
    //             $admin_id = $buy_orders['admin_id'];
    //             $purchased_price = $buy_orders['price'];
    //             $buy_purchased_price = $buy_orders['market_value'];
    //             $iniatial_trail_stop = $buy_orders['iniatial_trail_stop'];
    //             $application_mode = $buy_orders['application_mode'];
    //             $quantity = $buy_orders['quantity'];
    //             $order_type = $buy_orders['order_type'];
    //             $order_mode = $buy_orders['order_mode'];
    //             $binance_order_id = $buy_orders['binance_order_id'];
    //             $trigger_type = $buy_orders['trigger_type'];
    //             $order_id = $buy_orders['sell_order_id'];
    //             $defined_sell_percentage = $buy_orders['defined_sell_percentage'];
    //             $market_value = $buy_orders['market_value'];
    //             $lth_profit = $buy_orders['lth_profit'];

    //             $target_sell_price = $market_value + ($market_value / 100) * $lth_profit;
    //             //Is sell or status is new
    //             $is_sell_order_status_new = $this->mod_barrier_trigger->is_sell_order_status_new($order_id);

    //             //%%%%%%%%%%%%%%%% -- Update market heighest value -- %%%%%%%%%%%%% 
    //             $this->market_heighest_value_for_current_order($buy_orders_id,$market_price);

    //             if ($market_price >= $target_sell_price) {

    //                     ///////////////////////////////////
    //                     $upd_data = array(
    //                         'buy_order_binance_id' => $binance_order_id,
    //                         'market_value' => (float) $market_price,
    //                         'sell_price' => (float) $market_price,
    //                         'modified_date' => $this->mongo_db->converToMongodttime($created_date),
    //                     );

    //                     $this->mongo_db->where(array('_id' => $order_id));
    //                     $this->mongo_db->set($upd_data);
    //                     $this->mongo_db->update('orders');
    //                     //Insert data in mongoTable

    //                     $log_msg = ' Order Send for Sell By  <span style="color:orange;font-size: 14px;"><b>Long Term Hold</b></span> ON :<b>' . num($market_price) . '</b> Price By Profit : % '.$lth_profit;

    //                     $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'Sell_Price', $admin_id, $created_date);
    //                     //%%%%%%% Update Status %%%%%%%%%%%%
    //                     $this->mongo_db->where(array('_id' => $buy_orders_id));
    //                     $this->mongo_db->set(array('status'=>'FILLED'));
    //                         //Update data in mongoTable
    //                     $this->mongo_db->update('buy_orders');


    //                     if ($application_mode == 'live') {
    //                         $trading_ip = $this->mod_barrier_trigger->get_user_trading_ip($admin_id);
    //                         if ($this->is_order_already_not_send($buy_orders_id)) {
    //                             //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
                            
    //                             $log_msg = 'Order Target Sell Price : <b>' . num($target_sell_price) . '</b> Price';
    //                             $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'target_Price', $admin_id, $created_date);

    //                             //Profit Percentage
    //                             $log_msg = 'Order Profit percentage : <b>' . num($defined_sell_percentage) . '</b> ';
    //                             $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'profit_percantage', $admin_id, $created_date);

    //                             if ($order_type == 'limit_order') {

    //                                 if ($sell_one_tip_below == 'yes') {
    //                                     $one_unit_below_value = $market_price - $coin_unit_value;
    //                                     $market_price = $one_unit_below_value;
    //                                     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //                                     $log_msg = 'Send Limit Order On One tick Below: <b>' . num($market_price) . '</b> ';
    //                                     $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);

    //                                 } else {
    //                                     //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //                                     $log_msg = 'Send Limit Order On Current Market Price: <b>' . num($market_price) . '</b> ';
    //                                     $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);
    //                                 }

    //                                 //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //                                 // $res_limit_order = $this->mod_dashboard->binance_sell_auto_limit_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id);

    //                                 $log_msg = 'Send Limit Orde for sell by Ip: <b>' . $trading_ip . '</b> ';

    //                                 $this->mod_barrier_trigger->insert_developer_log($buy_orders_id, $log_msg, 'Message', $created_date, $show_error_log);

    //                                 $trigger_type = 'barrier_trigger';
    //                                 $this->mod_barrier_trigger->order_ready_for_sell_by_ip($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id, $trading_ip, $trigger_type, 'sell_limit_order');

    //                                 // //if No Error Occure
    //                                 // if(!isset($res_limit_order['error'])){
    //                                 //     $this->mod_limit_order->save_follow_up_of_limit_sell_order($order_id,$buy_orders_id,$type='sell');
    //                                 // }

    //                             } else if ($order_type == 'stop_loss_limit_order') {

    //                                 $log_msg = 'Send stop loss limit order by Profit On Current Market Price: <b>' . num($market_price) . '</b> ';
    //                                 $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);

    //                                 $log_msg = 'Send stop loss limit order by stop_loss On trail stop price: <b>' . num($iniatial_trail_stop) . '</b> ';
    //                                 $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'send_limit_order', $admin_id, $created_date);

    //                                 $res_limit_order = $this->mod_dashboard->binance_sell_auto_stop_loss_limit_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id, $iniatial_trail_stop);

    //                             } else {

    //                                 $log_msg = 'Send Market Orde for sell by Ip: <b>' . $trading_ip . '</b> ';
    //                                 $this->mod_barrier_trigger->insert_developer_log($buy_orders_id, $log_msg, 'Message', $created_date, $show_error_log);

    //                                 $trigger_type = 'barrier_trigger';
    //                                 $this->mod_barrier_trigger->order_ready_for_sell_by_ip($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id, $trading_ip, $trigger_type, 'sell_market_order');

    //                                 // $this->mod_dashboard->binance_sell_auto_market_order_live($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id);
    //                             }

    //                             $this->mod_barrier_trigger->save_rules_for_orders($buy_orders_id, $coin_symbol, $order_type = 'sell', $rule, $mode = 'live');
    //                         } //End of if order already not send

    //                     } else {
    //                         //Sell With Normal Value
    //                         $upd_data_1 = array(
    //                             'status' => 'FILLED',
    //                         );
    //                         $this->mongo_db->where(array('_id' => $order_id));
    //                         $this->mongo_db->set($upd_data_1);
    //                         //Update data in mongoTable
    //                         $this->mongo_db->update('orders');
    //                         $upd_data = array(
    //                             'sell_order_id' => $order_id,
    //                             'is_sell_order' => 'sold',
    //                             'market_sold_price' => (float) $market_price,
    //                             'modified_date' => $this->mongo_db->converToMongodttime($created_date),
    //                         );
    //                         $this->mongo_db->where(array('_id' => $buy_orders_id));
    //                         $this->mongo_db->set($upd_data);
    //                         //Update data in mongoTable
    //                         $this->mongo_db->update('buy_orders');

    //                         $this->mod_barrier_trigger->save_rules_for_orders($buy_orders_id, $coin_symbol, $order_type = 'sell', $rule, $mode = 'test_live');

    //                         $message = 'Sell Order was Sold With profit';

    //                         //////////////////////////////////////////////////////////////////////////////
    //                         ////////////////////////////// Order History Log /////////////////////////////
    //                         $log_msg = $message . " " . number_format($market_price, 8);
    //                         $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'sell_created', $admin_id, $created_date);
    //                         ////////////////////////////// End Order History Log /////////////////////////
    //                         //////////////////////////////////////////////////////////////////////////////
    //                         ////////////////////// Set Notification //////////////////
    //                         $message = $message . " <b>Sold</b>";
    //                         $this->mod_box_trigger_3->add_notification($buy_orders_id, 'buy', $message, $admin_id);
    //                         //////////////////////////////////////////////////////////
    //                         //Check Market History
    //                         $commission_value = $quantity * (0.001);
    //                         $commission = $commission_value * $with;
    //                         $commissionAsset = 'BTC';
    //                         //////////////////////////////////////////////////////////////////////////////////////////////
    //                         ////////////////////////////// Order History Log /////////////////////////////////////////////
    //                         $log_msg = "Broker Fee <b>" . num($commission) . " " . $commissionAsset . "</b> has token on this Trade";
    //                         $created_date = date('Y-m-d G:i:s');
    //                         $this->mod_box_trigger_3->insert_order_history_log($buy_orders_id, $log_msg, 'sell_commision', $admin_id, $created_date);
    //                         ////////////////////////////// End Order History Log
    //                     } //if test live order
                   
    //             } //if markt price is greater then sell order
    //         } //End  of forEach buy orders
    //     } //Check of orders found

    // } //End of sell_lth_profitable_order

    

} //En of controller
