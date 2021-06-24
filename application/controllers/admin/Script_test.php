<?php

class Script_test extends CI_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model('admin/mod_chart3');

        $this->load->model('admin/mod_coins');

    }

    public function index() {

        $ip = getenv('HTTP_CLIENT_IP') ?:

        getenv('HTTP_X_FORWARDED_FOR') ?:

        getenv('HTTP_X_FORWARDED') ?:

        getenv('HTTP_FORWARDED_FOR') ?:

        getenv('HTTP_FORWARDED') ?:

        getenv('REMOTE_ADDR');

        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

        $detail = (array) $details;

        $returnArr = $this->getBrowser();

        $array = array(

            'IP' => $ip,

            'location' => $detail['city'] . ',' . $detail['region'] . ', ' . $detail['country'],

            'Geometry' => $detail['loc'],

            'Postal Code' => $detail['postal'],

            'Browser' => $returnArr['name'] . " Version " . $returnArr['version'],

            'Operating System' => $returnArr['platform'],

        );

        echo "<pre>";

        print_r($array);

        exit;

    }

    public function server_info() {

        $indicesServer = array('PHP_SELF',

            'argv',

            'argc',

            'GATEWAY_INTERFACE',

            'SERVER_ADDR',

            'SERVER_NAME',

            'SERVER_SOFTWARE',

            'SERVER_PROTOCOL',

            'REQUEST_METHOD',

            'REQUEST_TIME',

            'REQUEST_TIME_FLOAT',

            'QUERY_STRING',

            'DOCUMENT_ROOT',

            'HTTP_ACCEPT',

            'HTTP_ACCEPT_CHARSET',

            'HTTP_ACCEPT_ENCODING',

            'HTTP_ACCEPT_LANGUAGE',

            'HTTP_CONNECTION',

            'HTTP_HOST',

            'HTTP_REFERER',

            'HTTP_USER_AGENT',

            'HTTPS',

            'REMOTE_ADDR',

            'REMOTE_HOST',

            'REMOTE_PORT',

            'REMOTE_USER',

            'REDIRECT_REMOTE_USER',

            'SCRIPT_FILENAME',

            'SERVER_ADMIN',

            'SERVER_PORT',

            'SERVER_SIGNATURE',

            'PATH_TRANSLATED',

            'SCRIPT_NAME',

            'REQUEST_URI',

            'PHP_AUTH_DIGEST',

            'PHP_AUTH_USER',

            'PHP_AUTH_PW',

            'AUTH_TYPE',

            'PATH_INFO',

            'ORIG_PATH_INFO');

        echo '<table cellpadding="10">';

        foreach ($indicesServer as $arg) {

            if (isset($_SERVER[$arg])) {

                echo '<tr><td>' . $arg . '</td><td>' . $_SERVER[$arg] . '</td></tr>';

            } else {

                echo '<tr><td>' . $arg . '</td><td>-</td></tr>';

            }

        }

        echo '</table>';

    }

    public function getBrowser() {

        $u_agent = $_SERVER['HTTP_USER_AGENT'];

        $bname = 'Unknown';

        $platform = 'Unknown';

        $version = "";

        //First get the platform?

        if (preg_match('/linux/i', $u_agent)) {

            $platform = 'linux';

        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {

            $platform = 'mac';

        } elseif (preg_match('/windows|win32/i', $u_agent)) {

            $platform = 'windows';

        }

        // Next get the name of the useragent yes seperately and for good reason

        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {

            $bname = 'Internet Explorer';

            $ub = "MSIE";

        } elseif (preg_match('/Firefox/i', $u_agent)) {

            $bname = 'Mozilla Firefox';

            $ub = "Firefox";

        } elseif (preg_match('/Chrome/i', $u_agent)) {

            $bname = 'Google Chrome';

            $ub = "Chrome";

        } elseif (preg_match('/Safari/i', $u_agent)) {

            $bname = 'Apple Safari';

            $ub = "Safari";

        } elseif (preg_match('/Opera/i', $u_agent)) {

            $bname = 'Opera';

            $ub = "Opera";

        } elseif (preg_match('/Netscape/i', $u_agent)) {

            $bname = 'Netscape';

            $ub = "Netscape";

        }

        // finally get the correct version number

        $known = array('Version', $ub, 'other');

        $pattern = '#(?<browser>' . join('|', $known) .

            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

        if (!preg_match_all($pattern, $u_agent, $matches)) {

            // we have no matching number just continue

        }

        // see how many we have

        $i = count($matches['browser']);

        if ($i != 1) {

            //we will have two since we are not using 'other' argument yet

            //see if version is before or after the name

            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {

                $version = $matches['version'][0];

            } else {

                $version = $matches['version'][1];

            }

        } else {

            $version = $matches['version'][0];

        }

        // check if we have a number

        if ($version == null || $version == "") {$version = "?";}

        $print_arr = array(

            'userAgent' => $u_agent,

            'name' => $bname,

            'version' => $version,

            'platform' => $platform,

            'pattern' => $pattern,

        );

        return $print_arr;

    }

    // public function test() {

    //     $search_arr['coin'] = "TRXBTC";
    //     $search_arr['bid']['$nin'] = array("", null, NULL);
    //     $this->mongo_db->where($search_arr);
    //     $this->mongo_db->order_by(array('_id' => 1));
    //     $this->mongo_db->limit(1);
    //     $get = $this->mongo_db->get("coin_meta_history");
    //     echo "<pre>";
    //     print_r(iterator_to_array($get));
    //     exit;

    // }

    // public function calculate_pressure_up_and_down2($start_date, $end_date, $coin, $pressure_type) {

    //     $this->mongo_db->where_gte('created_date', $this->mongo_db->converToMongodttime($start_date));

    //     $this->mongo_db->where_lt('created_date', $this->mongo_db->converToMongodttime($end_date));

    //     $this->mongo_db->where(array('coin' => $coin, 'pressure' => $pressure_type));

    //     $res = $this->mongo_db->get('order_book_pressure');

    //     $res_arr = iterator_to_array($res);

    //     $total_pressure = count($res_arr);

    //     return $total_pressure;

    // } //End of calculate_pressure_up_and_down

    // public function get_hourly_depthwall() {

    //     $coin_array = $this->mod_coins->get_all_coins();

    //     foreach ($coin_array as $key => $value) {

    //         $coin_symbol = $value['symbol'];

    //         $start_date = date('Y-m-d H:00:00', strtotime("-1 hour"));

    //         $end_date = date('Y-m-d H:59:59', strtotime($start_date));

    //         $where['coin'] = $coin_symbol;

    //         $where['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($start_date), '$lte' => $this->mongo_db->converToMongodttime($end_date));

    //         $order_by['created_date'] = -1;

    //         $this->mongo_db->where($where);

    //         $this->mongo_db->order_by($order_by);

    //         $get = $this->mongo_db->get('depth_wall_history');

    //         $array = iterator_to_array($get);

    //         $x = 1;

    //         for ($i = 0; $i < count($array); $i++) {

    //             if (!empty($array[$i]['current_market_value'])) {

    //                 $current_val = $array[$i]['current_market_value'];

    //                 $ask_wall = $array[$i]['ask_black_wall'];

    //                 $bid_wall = $array[$i]['bid_black_wall'];

    //                 $unit_val = $this->mod_coins->get_coin_unit_value($coin_symbol);

    //                 $bid_diff[] = ($current_val - $bid_wall) / $unit_val;

    //                 $ask_diff[] = ($ask_wall - $current_val) / $unit_val;

    //                 $x++;

    //             }

    //         }

    //         /*$bid_diff_sum = array_sum($bid_diff);

    //         $ask_diff_sum = array_sum($ask_diff);

    //         $ins_arr = array("ask_diff" => $ask_diff_sum, 'bid_diff' => $bid_diff_sum, 'datetime' => $this->mongo_db->converToMongodttime($start_date), 'coin' => $coin_symbol);

    //          */

    //         $bid_diff_sum = array_sum($bid_diff);

    //         $bid = round($bid_diff_sum / $x);

    //         $ask_diff_sum = array_sum($ask_diff);

    //         $ask = round($ask_diff_sum / $x);

    //         $ins_arr = array('coin' => $coin_symbol, "ask_diff" => $ask, 'bid_diff' => $bid, 'datetime' => $this->mongo_db->converToMongodttime($start_date), 'date_time_human_readable' => $start_date);

    //         //$this->mongo_db->insert('market_depth_hourly_wall', $ins_arr);

    //         echo "<pre>";

    //         print_r($ins_arr);

    //     }

    //     exit;

    // }

    // public function testing() {

    //     /*$db = $this->mongo_db->customQuery();

    //     $new_arr = $db->buy_orders->deleteMany(array('buy_parent_id' => $this->mongo_db->mongoId('5b97d541819e1228f61c83f2')));

    //     echo "<pre>";

    //     print_r($new_arr);

    //      */

    //     $search_arr['coin'] = 'NCASHBTC';

    //     $this->mongo_db->where($search_arr);

    //     $this->mongo_db->order_by(array('created_date' => -1));

    //     $depth_responseArr = $this->mongo_db->get('barrier_values_collection');

    //     $arr = iterator_to_array($depth_responseArr);

    //     echo "<pre>";

    //     print_r($arr);

    //     exit;

    // }

    // public function order_test($order_id) {

    //     $this->mongo_db->where(array('_id' => $order_id));

    //     $get = $this->mongo_db->get('buy_orders');

    //     $get_arr = iterator_to_array($get);

    //     $sell_order_id = $get_arr[0]['sell_order_id'];

    //     $upd_buy['is_sell_order'] = 'yes';

    //     $upd_buy['modified_date'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s"));

    //     $upd_sell['status'] = 'new';

    //     $this->mongo_db->where(array('_id' => $order_id));

    //     $this->mongo_db->set($upd_buy);

    //     $this->mongo_db->update('buy_orders');

    //     $this->mongo_db->where(array('_id' => $sell_order_id));

    //     $this->mongo_db->set($upd_sell);

    //     $this->mongo_db->update('orders');
    //     echo 'ok';

    // }

    // public function barrier_listing() {

    //     $search_arr['coin'] = 'NCASHBTC';

    //     $this->mongo_db->where($search_arr);

    //     $this->mongo_db->order_by(array('created_date' => -1));

    //     $depth_responseArr = $this->mongo_db->get('barrier_values_collection');

    //     $arr = iterator_to_array($depth_responseArr);

    //     echo "<pre>";
    //     print_r($arr);
    //     exit;

    // }

    // public function wall_test() {
    //     $this->load->model("admin/mod_realtime_candle_socket");
    //     $start_date = "2018-09-17 01:00:00";
    //     $end_date = "2018-09-17 01:59:59";
    //     $coin_symbol = "NCASHBTC";

    //     $this->mongo_db->order_by(array('timestampDate' => -1));
    //     $this->mongo_db->limit(1);
    //     $get_arr = $this->mongo_db->get('market_chart');
    //     echo "<pre>";
    //     print_r(iterator_to_array($get_arr));
    //     exit;
    // }

    // public function test_collection() {
    //     $this->load->model('admin/mod_custom_script');
    //     /*$coin_symbol = "NCASHBTC";
    //     $search_arr['coin'] = $coin_symbol;
    //     $search_arr['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("- 1 week"))));
    //     $this->mongo_db->where($search_arr);
    //     $this->mongo_db->order_by(array('created_date' => -1));
    //     $depth_responseArr = $this->mongo_db->get('barrier_values_collection');
    //     $arr = iterator_to_array($depth_responseArr);

    //     foreach ($arr as $key => $value) {
    //     $created_date = $value['created_date'];
    //     $barrier_value = $value['barier_value'];
    //     /////////////////////////////////////////
    //     $new_Date222 = $created_date->toDateTime()->format("Y-m-d H:i:s");
    //     $search_arr1['market_value'] = (float) $barrier_value;
    //     $search_arr1['time'] = array('$lte' => $created_date);
    //     $this->mongo_db->where($search_arr1);
    //     $this->mongo_db->order_by(array('time' => -1));
    //     $get_arr = $this->mongo_db->get('market_price_history');
    //     $price_arr = iterator_to_array($get_arr);
    //     $price_time = $price_arr[0]['time'];
    //     $new_Date = $price_time->toDateTime()->format("Y-m-d H:i:s");
    //     //////////////////////////////////////////////////////////////////
    //     $coin_meta = $this->get_coin_meta($coin_symbol, $new_Date);

    //     $res = array(
    //     'coin' => $coin_symbol,
    //     'barrier_value' => $barrier_value,
    //     'barrier_creation_time' => $new_Date222,
    //     'market_value_time' => $new_Date,
    //     'black_wall_pressure' => $coin_meta['black_wall_pressure'],
    //     'yellow_wall_pressure' => $coin_meta['yellow_wall_pressure'],
    //     'depth_pressure' => $coin_meta['pressure_diff'],
    //     'bid_contracts' => $coin_meta['bid_contracts'],
    //     'bid_percentage' => $coin_meta['bid_percentage'],
    //     'ask_contract' => $coin_meta['ask_contract'],
    //     'ask_percentage' => $coin_meta['ask_percentage'],
    //     'great_wall_quantity' => $coin_meta['great_wall_quantity'],
    //     'great_wall' => $coin_meta['great_wall'],
    //     'seven_level_depth' => $coin_meta['seven_level_depth'],
    //     'created_date' => $this->mongo_db->converToMongodttime($new_Date222),
    //     );
    //      */
    //     $barrier_value = 0.00000081;
    //     $created_date = "2018-09-18 4:00:00";
    //     $coin_symbol = "NCASHBTC";
    //     $this->mod_custom_script->insert_script($barrier_value, $created_date, $coin_symbol);

    //     //$this->mongo_db->insert('barrier_test_collection', $res);
    //     exit;
    //     $this->mongo_db->order_by(array('created_date' => -1));
    //     $ress = $this->mongo_db->get('barrier_test_collection');
    //     echo "<pre>";
    //     print_r(iterator_to_array($ress));
    //     exit;
    // }

    // public function indicator_test($coin_symbol = "NCASHBTC") {
    //     $search_arr['coin'] = $coin_symbol;
    //     $search_arr['barrier_type'] = 'up';
    //     //$search_arr['global_swing_parent_status'] = "LH";
    //     $datetime = date("Y-m-d H:i:s", strtotime("last monday"));

    //     $search_arr['created_date'] = array('$gte' => $this->mongo_db->converToMongodttime($datetime));

    //     $this->mongo_db->where($search_arr);
    //     $this->mongo_db->order_by(array('created_date' => -1));
    //     $get = $this->mongo_db->get('barrier_values_collection');
    //     $pre_res = iterator_to_array($get);

    //     echo "<pre>";
    //     print_r($pre_res);
    //     exit;

    //     foreach ($pre_res as $key => $value) {
    //         $created_date = $value['created_date'];
    //         $barrier_value = $value['barier_value'];
    //         echo $new_Date = $created_date->toDateTime()->format("Y-m-d H:i:s");
    //         echo "<br>";
    //         $search_arr2['barrier_value'] = $barrier_value;
    //         $search_arr2['coin'] = $coin_symbol;
    //         $search_arr2['created_date'] = $created_date;

    //         $this->mongo_db->where($search_arr2);
    //         $this->mongo_db->limit(1);
    //         $gets = $this->mongo_db->get('barrier_test_collection');
    //         $coin_meta = iterator_to_array($gets);

    //         if (!empty($coin_meta)) {
    //             $res[] = array(
    //                 'coin' => $coin_symbol,
    //                 'barrier_value' => $barrier_value,
    //                 'barrier_creation_time' => $new_Date222,
    //                 'market_value_time' => $new_Date,
    //                 'black_wall_pressure' => $coin_meta[0]['black_wall_pressure'],
    //                 'yellow_wall_pressure' => $coin_meta[0]['yellow_wall_pressure'],
    //                 'depth_pressure' => $coin_meta[0]['depth_pressure'],
    //                 'bid_contracts' => $coin_meta[0]['bid_contracts'],
    //                 'bid_percentage' => $coin_meta[0]['bid_percentage'],
    //                 'ask_contract' => $coin_meta[0]['ask_contract'],
    //                 'ask_percentage' => $coin_meta[0]['ask_percentage'],
    //                 'great_wall_quantity' => $coin_meta[0]['great_wall_quantity'],
    //                 'great_wall' => $coin_meta[0]['great_wall'],
    //                 'seven_level_depth' => $coin_meta[0]['seven_level_depth'],
    //             );
    //         }

    //     }
    //     echo "<pre>";
    //     print_r($res);
    //     exit;
    //     $returnArr = array();
    //     /*==============================Black Wall Pressure==========================================*/
    //     $black_wall_array = array_column($res, 'black_wall_pressure');
    //     $average_black_wall = array_sum($black_wall_array) / count($black_wall_array);
    //     $max_black_wall_pressure = max($black_wall_array);
    //     $min_black_wall_pressure = min($black_wall_array);
    //     $returnArr['black_wall_pressure'] = array(
    //         'avg' => number_format($average_black_wall, 2),
    //         'max' => $max_black_wall_pressure,
    //         'min' => $min_black_wall_pressure,
    //     );
    //     /*==============================End Black Wall Pressure=======================================*/

    //     /*==============================Yellow Wall Pressure==========================================*/
    //     $yellow_wall_array = array_column($res, 'yellow_wall_pressure');
    //     $average_yellow_wall = array_sum($yellow_wall_array) / count($yellow_wall_array);
    //     $max_yellow_wall_pressure = max($yellow_wall_array);
    //     $min_yellow_wall_pressure = min($yellow_wall_array);

    //     $returnArr['yellow_wall_pressure'] = array(

    //         'avg' => number_format($average_yellow_wall, 2),
    //         'max' => $max_yellow_wall_pressure,
    //         'min' => $min_yellow_wall_pressure,
    //     );
    //     /*==============================End Yellow Wall Pressure=======================================*/

    //     /*================================Depth Pressure===============================================*/
    //     $depth_array = array_column($res, 'depth_pressure');
    //     $average_depth = array_sum($depth_array) / count($depth_array);
    //     $max_depth_pressure = max($depth_array);
    //     $min_depth_pressure = min($depth_array);

    //     $returnArr['depth_pressure'] = array(
    //         'avg' => number_format($average_depth, 2),
    //         'max' => $max_depth_pressure,
    //         'min' => $min_depth_pressure,
    //     );
    //     /*==============================End Depth Pressure=======================================*/

    //     /*================================Bid Contracts==========================================*/
    //     $bid_contracts_arr = array_column($res, 'bid_contracts');
    //     $average_bids = array_sum($bid_contracts_arr) / count($bid_contracts_arr);
    //     $max_bids = max($bid_contracts_arr);
    //     $min_bids = min($bid_contracts_arr);

    //     $returnArr['bid_contracts'] = array(
    //         'avg' => number_format($average_bids, 2),
    //         'max' => $max_bids,
    //         'min' => $min_bids,
    //     );
    //     /*==============================End Bid Contracts========================================*/

    //     /*================================Ask Contracts==========================================*/
    //     $ask_contracts_arr = array_column($res, 'ask_contract');
    //     $average_asks = array_sum($ask_contracts_arr) / count($ask_contracts_arr);
    //     $max_asks = max($ask_contracts_arr);
    //     $min_asks = min($ask_contracts_arr);

    //     $returnArr['ask_contract'] = array(
    //         'avg' => number_format($average_asks, 2),
    //         'max' => $max_asks,
    //         'min' => $min_asks,
    //     );
    //     /*==============================End Ask Contracts========================================*/

    //     /*================================Bid Contracts==========================================*/
    //     $bid_percentage_arr = array_column($res, 'bid_percentage');
    //     $average_bids_per = array_sum($bid_percentage_arr) / count($bid_percentage_arr);
    //     $max_bids_per = max($bid_percentage_arr);
    //     $min_bids_per = min($bid_percentage_arr);
    //     $returnArr['bid_percentage'] = array(
    //         'avg' => number_format($average_bids_per, 2),
    //         'max' => $max_bids_per,
    //         'min' => $min_bids_per,
    //     );
    //     /*==============================End Bid Contracts========================================*/

    //     /*================================Ask Contracts==========================================*/
    //     $ask_percentage_arr = array_column($res, 'ask_percentage');
    //     $average_asks_per = array_sum($ask_percentage_arr) / count($ask_percentage_arr);
    //     $max_asks_per = max($ask_percentage_arr);
    //     $min_asks_per = min($ask_percentage_arr);

    //     $returnArr['ask_percentage'] = array(
    //         'avg' => number_format($average_asks_per, 2),
    //         'max' => $max_asks_per,
    //         'min' => $min_asks_per,
    //     );
    //     /*==============================End Ask Contracts========================================*/

    //     /*================================Great Wall==========================================*/
    //     $great_wall_array = array_column($res, 'great_wall_quantity');
    //     $great_wall_avg = array_sum($great_wall_array) / count($great_wall_array);
    //     $max_great_wall = max($great_wall_array);
    //     $min_great_wall = min($great_wall_array);

    //     $returnArr['great_wall'] = array(
    //         'avg' => number_format($great_wall_avg, 2),
    //         'max' => $max_great_wall,
    //         'min' => $min_great_wall,
    //     );
    //     /*==============================End Great Wall========================================*/

    //     /*================================Great Wall==========================================*/
    //     $seven_level_array = array_column($res, 'seven_level_depth');
    //     $seven_level_avg = array_sum($seven_level_array) / count($seven_level_array);
    //     $max_seven_level = max($seven_level_array);
    //     $min_seven_level = min($seven_level_array);

    //     $returnArr['seven_level_depth'] = array(
    //         'avg' => number_format($seven_level_avg, 2),
    //         'max' => $max_seven_level,
    //         'min' => $min_seven_level,
    //     );

    //     /*==============================End Great Wall========================================*/

    //     $data['returnArr'] = $returnArr;

    // }

    // public function insert_script($barrier_value, $created_date, $coin_symbol) {
    //     $this->load->model("admin/mod_custom_script");
    //     $created_date = $this->mongo_db->converToMongodttime($created_date);
    //     $new_Date222 = $created_date->toDateTime()->format("Y-m-d H:i:s");
    //     $search_arr1['coin'] = $coin_symbol;
    //     $search_arr1['market_value'] = (float) $barrier_value;
    //     $search_arr1['time'] = array('$lte' => $created_date);
    //     $this->mongo_db->where($search_arr1);
    //     $this->mongo_db->order_by(array('time' => -1));
    //     $get_arr = $this->mongo_db->get('market_price_history');
    //     $price_arr = iterator_to_array($get_arr);
    //     $price_time = $price_arr[0]['time'];
    //     $new_Date = $price_time->toDateTime()->format("Y-m-d H:i:s");
    //     //////////////////////////////////////////////////////////////////
    //     $coin_meta = $this->mod_custom_script->get_coin_meta($coin_symbol, $new_Date);

    //     $res = array(
    //         'coin' => $coin_symbol,
    //         'barrier_value' => $barrier_value,
    //         'barrier_creation_time' => $new_Date222,
    //         'market_value_time' => $new_Date,
    //         'black_wall_pressure' => $coin_meta['black_wall_pressure'],
    //         'yellow_wall_pressure' => $coin_meta['yellow_wall_pressure'],
    //         'depth_pressure' => $coin_meta['pressure_diff'],
    //         'bid_contracts' => $coin_meta['bid_contracts'],
    //         'bid_percentage' => $coin_meta['bid_percentage'],
    //         'ask_contract' => $coin_meta['ask_contract'],
    //         'ask_percentage' => $coin_meta['ask_percentage'],
    //         'great_wall_quantity' => $coin_meta['great_wall_quantity'],
    //         'great_wall' => $coin_meta['great_wall'],
    //         'seven_level_depth' => $coin_meta['seven_level_depth'],
    //         'created_date' => $this->mongo_db->converToMongodttime($new_Date222),
    //     );

    //     $this->mongo_db->insert('barrier_test_collection', $res);

    // }

    // public function delete_manual_user_test_orders($user_id = '') {

    //     if ($user_id != '') {
    //         $admin_id = $user_id;
    //         $application_mode = 'test';

    //         $search_arr['admin_id'] = $admin_id;
    //         $search_arr['application_mode'] = $application_mode;
    //         $db = $this->mongo_db->customQuery();

    //         $delete_rec['buy_orders'] = $db->buy_orders->deleteMany($search_arr);
    //         $delete_rec['sell_orders'] = $db->orders->deleteMany($search_arr);

    //         echo "<pre>";
    //         print_r($delete_rec);
    //         exit;
    //     } else {
    //         echo "Please Give Some user id to delete the records";
    //         echo "<br>";
    //         echo "Forexample: https://app.digiebot.com/admin/script_test/delete_manual_user_test_orders/{{xyz}}";
    //         exit;
    //     }
    // }

    // public function coin_meta_percentile($coin_symbol = "TRXBTC"){
    //     $this->mongo_db->where(array('coin' => $coin_symbol));
    //     $get = $this->mongo_db->get("coin_meta_hourly_percentile");

    //     $arr = iterator_to_array($get);
    //     ksort($arr);
    //     $fullarr = array();
    //     foreach ($arr[0] as $key => $value){
    //     	$fullarr[$key] = (string)$value;
    //     }
    //     echo "<pre>";
    //     print_r($fullarr);
    //     exit;
    // }

}