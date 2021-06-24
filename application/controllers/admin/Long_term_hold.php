<?php
/**
 *
 */
class Long_term_hold extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        echo "Index";
    }

    // public function save_setting() {
    //     echo "Save Settings";
    // }

    // public function do_ajax_action() {
    //     $action = $this->input->post("action");
    //     $option = $this->input->post("option");

    //     $admin_id = $this->session->userdata('admin_id');

    //     if ($action == 'winning') {
    //         if ($option == 'all_profit') {
    //             $this->sell_all_lth_orders($admin_id, $coin_symbol = '', $action, $percentage = '');
    //         } else if ($option == 'specific-coin') {
    //             $coin_symbol_arr = $this->input->post("coin");
    //             foreach ($coin_symbol_arr as $coin_symbol) {
    //                 $this->sell_all_lth_orders($admin_id, $coin_symbol, $action, $percentage = '');
    //             }
    //         }
    //     } //%%%%%%%%%%%%%% --  End of winning Trades -- %%%%%%%%%%%%%%

    //     if ($action == 'losing') {
    //         if ($option == 'all_lose') {
    //             $this->sell_all_lth_orders($admin_id, $coin_symbol = '', $action, $percentage = '');
    //         } else if ($option == 'specific-coin') {
    //             $coin = $this->input->post("coin");
    //             $coin_symbol_arr = $this->input->post("coin");
    //             foreach ($coin_symbol_arr as $coin_symbol) {
    //                 $this->sell_all_lth_orders($admin_id, $coin_symbol, $action, $percentage = '');
    //             }
    //         }
    //     } //End of all Winning R

    //     if ($action == 'coin') {
    //         $coin_symbol_arr = $this->input->post("coin");
    //         foreach ($coin_symbol_arr as $coin_symbol) {
    //             $this->sell_all_lth_orders($admin_id, $coin_symbol, $action, $percentage = '');
    //         }
    //     }

    //     if ($action == 'percentage') {
    //         $percentage = $this->input->post("perc");
    //         $this->sell_all_lth_orders($admin_id, $coin_symbol = '', $action, $percentage);
    //     }

    //     if ($action == 'close_All') {
    //         $this->sell_all_lth_orders($admin_id, $coin_symbol, $action, $percentage = '');
    //     }

    //     if ($action == 'all_coin') {
    //         $coin_symbol_arr = $this->input->post("coin");
    //         foreach ($coin_symbol_arr as $coin_symbol) {
    //             $this->sell_all_lth_orders($admin_id, $coin_symbol, $action, $percentage = '');
    //         }
    //     }

    //     if ($action == 'sell_all_trades') {
    //         $this->sell_all_lth_orders($admin_id, $coin_symbol = '', $action, $percentage = '');
    //     }

    //     echo "Your all " . strtoupper(str_replace($action)) . " Trades been submitted";
    //     exit;
    // }

    // public function sell_all_lth_orders($admin_id, $coin_symbol, $action, $percentage) {

    //     $buy_orders_arr = $this->triggers_trades->get_user_porfitable_lth_order($admin_id, $coin_symbol, $percentage);

    //     //%%%%%%%%%%%%%%%%%%%%%%%% -- Get all  -- %%%%%%%%%%%%%%%%
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

    //             //%%%%%%%%%%%%%%%%%%% -- -- %%%%%%%%%%%%%%
    //             $market_price = $this->triggers_trades->market_price($coin_symbol);

    //             //%%%%%%%%%%%%%%%%%%%%%%  -- Check Order  --%%%%%%%%%%%%%%%%%%%
    //             $is_sell_order_status_new = $this->triggers_trades->is_order_not_send_for_sell($order_id);

    //             //%%%%%%%%%%%%%%%% -- Update market heighest value -- %%%%%%%%%%%%%
    //             $this->triggers_trades->market_heighest_value_for_current_order($buy_orders_id, $market_price);

    //             $is_action_true = false;
    //             $los_or_profitable_trades = '';
    //             if ($action == 'winning') {
    //                 if (($market_price >= $market_value)) {
    //                     $is_action_true = true;
    //                     $los_or_profitable_trades = 'Close All Profitable Trades';
    //                 }
    //             } else if ($action == 'losing') {
    //                 if (($market_price <= $market_value)) {
    //                     $is_action_true = true;
    //                     $los_or_profitable_trades = 'Close All Lossing Trades';
    //                 }
    //             } else if ($action == 'coin') {
    //                 $is_action_true = true;
    //                 $los_or_profitable_trades = 'Close All Trades of Specified Coins';
    //             } else if ($action == 'percentage') {

    //                 if ($percentage != '') {
    //                     $target_sell_price = $market_value + ($market_value / 100) * $percentage;
    //                     if (($market_price >= $target_sell_price)) {
    //                         $is_action_true = true;
    //                         $los_or_profitable_trades = 'Close All Trades of Defined Percentage ' . $percentage;
    //                     } //End of condition Meet
    //                 } //End of if percentage is not empty
    //             } else if ($action == 'all_coin') {

    //                 $is_action_true = true;
    //                 $los_or_profitable_trades = 'Close All Trades ';
    //             } else if ($action == 'sell_all_trades') {
    //                 $is_action_true = true;
    //                 $los_or_profitable_trades = 'Sell All Trades ';
    //             }

    //             if (($is_action_true) && $is_sell_order_status_new) {
    //                 if ($this->triggers_trades->is_order_already_not_send($buy_orders_id)) {
    //                     // %%%%%%%%%%%%%%% -- Trading Status   --%%%%%%%%%%%%%%%%
    //                     $this->triggers_trades->update_order_trading_status($order_id);

    //                     // %%%%%%%%%%%%%%% -- Record Log   --%%%%%%%%%%%%%%%%
    //                     $log_msg = ' Order Send for Sell By  <span style="color:orange;font-size: 14px;"><b>Long Term Hold</b></span> ON :<b>';
    //                     $this->triggers_trades->record_order_log($buy_orders_id, $log_msg, 'Sell_lth', 'yes');
    //                     //%%%%%%% Update Status %%%%%%%%%%%%
    //                     $this->mongo_db->where(array('_id' => $buy_orders_id));
    //                     $this->mongo_db->set(array('status' => 'FILLED'));
    //                     //Update data in mongoTable
    //                     $this->mongo_db->update('buy_orders');

    //                     //%%%%%%%%%%%%--  User Ip -- %%%%%%%%%%%%%%%%%%%%
    //                     $trading_ip = $this->triggers_trades->getUserIp($admin_id);

    //                     // %%%%%%%%%%%%%%% -- Record Log   --%%%%%%%%%%%%%%%%
    //                     $log_msg = 'Order Sold By <span style="color:green;font-size: 14px;"><b>' . $los_or_profitable_trades . '</b></span>';
    //                     $this->triggers_trades->record_order_log($buy_orders_id, $log_msg, 'Sell_Price', 'yes');

    //                     // %%%%%%%%%%%%%%% -- Record Log   --%%%%%%%%%%%%%%%%
    //                     $log_msg = 'Order Send for Sell ON :<b>' . num($market_price) . '</b> Price';
    //                     $this->triggers_trades->record_order_log($buy_orders_id, $log_msg, 'Sell_Price', 'yes');

    //                     // %%%%%%%%%%%%%%% -- Record Log   --%%%%%%%%%%%%%%%%
    //                     $log_msg = 'Send Market Orde for sell by Ip: <b>' . $trading_ip . '</b> ';
    //                     $this->triggers_trades->record_order_log($buy_orders_id, $log_msg, 'sell_ip', 'no');

    //                     if ($application_mode == 'live') {
    //                         // %%%%%%%%%%%%%%% -- Sell by Ip   --%%%%%%%%%%%%%%%%
    //                         $this->triggers_trades->send_order_to_sell_by_specific_user_ip($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id, $trading_ip, 'barrier_trigger', 'sell_market_order');
    //                     } else if ($application_mode == 'test') {
    //                         $this->triggers_trades->binance_sell_auto_market_order_test($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id);
    //                     } // %%%%%%%%%%%%% -- End of test live -- %%%%%%%%%
    //                 } //End of application Type
    //             } //if markt price is greater then sell order
    //         } //End  of forEach buy orders
    //     } //Check of orders found
    //     //%%%%%%%%%%%%%%%%%%%%%%%% -- -- %%%%%%%%%%%%%%%%
    // } //End of sell_all_lth_orders

    // public function cronjob_lth_trades() {
    //     $lth_user_setting = $this->triggers_trades->fetch_lth_settings();

    //     foreach ($lth_user_setting as $row) {
    //         $admin_id = $row['admin_id'];
    //         $coin_symbol = $row['coin'];
    //         $percentage = $row['percentage'];
    //         $buy_orders_arr = $this->triggers_trades->get_user_porfitable_lth_order($admin_id, $coin_symbol);

    //         //%%%%%%%%%%%%%%%%%%%%%%%% -- Get all  -- %%%%%%%%%%%%%%%%
    //         if (count($buy_orders_arr) > 0) {
    //             foreach ($buy_orders_arr as $buy_orders) {
    //                 $buy_orders_id = $buy_orders['_id'];
    //                 $coin_symbol = $buy_orders['symbol'];
    //                 $sell_price = $buy_orders['sell_price'];
    //                 $admin_id = $buy_orders['admin_id'];
    //                 $purchased_price = $buy_orders['price'];
    //                 $buy_purchased_price = $buy_orders['market_value'];
    //                 $iniatial_trail_stop = $buy_orders['iniatial_trail_stop'];
    //                 $application_mode = $buy_orders['application_mode'];
    //                 $quantity = $buy_orders['quantity'];
    //                 $order_type = $buy_orders['order_type'];
    //                 $order_mode = $buy_orders['order_mode'];
    //                 $binance_order_id = $buy_orders['binance_order_id'];
    //                 $trigger_type = $buy_orders['trigger_type'];
    //                 $order_id = $buy_orders['sell_order_id'];
    //                 $defined_sell_percentage = $buy_orders['defined_sell_percentage'];
    //                 $market_value = $buy_orders['market_value'];
    //                 $lth_profit = $buy_orders['lth_profit'];

    //                 //%%%%%%%%%%%%%%%%%%% -- -- %%%%%%%%%%%%%%
    //                 $market_price = $this->triggers_trades->market_price($coin_symbol);

    //                 //%%%%%%%%%%%%%%%%%%%%%%  -- Check Order  --%%%%%%%%%%%%%%%%%%%
    //                 $is_sell_order_status_new = $this->triggers_trades->is_order_not_send_for_sell($order_id);

    //                 //%%%%%%%%%%%%%%%% -- Update market heighest value -- %%%%%%%%%%%%%
    //                 $this->triggers_trades->market_heighest_value_for_current_order($buy_orders_id, $market_price);

    //                 $is_action_true = false;
    //                 if ($percentage != '') {
    //                     $target_sell_price = $market_value + ($market_value / 100) * $percentage;
    //                     if (($market_price >= $target_sell_price)) {
    //                         $is_action_true = true;
    //                         $los_or_profitable_trades = 'Close All Trades of Defined Percentage ' . $percentage;
    //                     } //End of condition Meet
    //                 } //End of if percentage is not empty

    //                 if (($is_action_true) && $is_sell_order_status_new) {

    //                     if ($this->triggers_trades->is_order_already_not_send($buy_orders_id)) {
    //                         // %%%%%%%%%%%%%%% -- Trading Status   --%%%%%%%%%%%%%%%%
    //                         $this->triggers_trades->update_order_trading_status($order_id);

    //                         // %%%%%%%%%%%%%%% -- Record Log   --%%%%%%%%%%%%%%%%
    //                         $log_msg = ' Order Send for Sell By  <span style="color:orange;font-size: 14px;"><b>Long Term Hold</b></span> ON :<b>';
    //                         $this->triggers_trades->record_order_log($buy_orders_id, $log_msg, 'Sell_lth', 'yes');
    //                         //%%%%%%% Update Status %%%%%%%%%%%%
    //                         $this->mongo_db->where(array('_id' => $buy_orders_id));
    //                         $this->mongo_db->set(array('status' => 'FILLED'));
    //                         //Update data in mongoTable
    //                         $this->mongo_db->update('buy_orders');

    //                         //%%%%%%%%%%%%--  User Ip -- %%%%%%%%%%%%%%%%%%%%
    //                         $trading_ip = $this->triggers_trades->getUserIp($admin_id);

    //                         // %%%%%%%%%%%%%%% -- Record Log   --%%%%%%%%%%%%%%%%
    //                         $log_msg = 'Order Sold By <span style="color:green;font-size: 14px;"><b>' . $los_or_profitable_trades . '</b></span>';
    //                         $this->triggers_trades->record_order_log($buy_orders_id, $log_msg, 'Sell_Price', 'yes');

    //                         // %%%%%%%%%%%%%%% -- Record Log   --%%%%%%%%%%%%%%%%
    //                         $log_msg = 'Order Send for Sell ON :<b>' . num($market_price) . '</b> Price';
    //                         $this->triggers_trades->record_order_log($buy_orders_id, $log_msg, 'Sell_Price', 'yes');

    //                         // %%%%%%%%%%%%%%% -- Record Log   --%%%%%%%%%%%%%%%%
    //                         $log_msg = 'Send Market Orde for sell by Ip: <b>' . $trading_ip . '</b> ';
    //                         $this->triggers_trades->record_order_log($buy_orders_id, $log_msg, 'sell_ip', 'no');

    //                         if ($order_mode == 'live') {
    //                             // %%%%%%%%%%%%%%% -- Sell by Ip   --%%%%%%%%%%%%%%%%
    //                             $this->triggers_trades->send_order_to_sell_by_specific_user_ip($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id, $trading_ip, 'barrier_trigger', 'sell_market_order');
    //                         } else if ($order_mode == 'test_live') {
    //                             $this->triggers_trades->binance_sell_auto_market_order_test($order_id, $quantity, $market_price, $coin_symbol, $admin_id, $buy_orders_id);
    //                         } // %%%%%%%%%%%%% -- End of test live -- %%%%%%%%%
    //                     } //End of application Type
    //                 } //if markt price is greater then sell order
    //             } //End  of forEach buy orders
    //         } //Check of orders found
    //         //%%%%%%%%%%%%%%%%%%%%%%%% -- -- %%%%%%%%%%%%%%%%

    //     } //End of foreach

    //     echo 'End of Function ' . date('Y-m-d H:i:s') . '<br>';
    //     // print_r($lth_user_setting);

    // } //End of cronjob_lth_trades

} //End of controller