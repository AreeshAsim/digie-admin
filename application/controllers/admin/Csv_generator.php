<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Csv_generator extends CI_Controller {

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

        if ($this->session->userdata('user_role') != 1) {
            redirect(base_url() . 'forbidden');
        }
        // if ($this->session->userdata('special_role') != 1) {
        //     redirect(base_url() . 'forbidden');
        // }

    }
    // public function get_csv_of_collection($collection){
    //     // $this->mongo_db->get("ready_orders_for_sell_ip_based");
    //     $get = $this->mongo_db->get($collection);
    //     $array = iterator_to_array($get);
    //     $this->download_send_headers($collection."_" . date("Y-m-d_ Gisa") . ".csv");

    //     echo $this->array2csv($array);
    // }


    // public function get_csv_of_sold_orders()
    // {
    //     $collection = 'sold_buy_orders';
    //     $where['application_mode'] = 'live';
    //     $where['created_date']['$gte'] = $this->mongo_db->converToMongodttime(date("Y-m-d H:i:s", strtotime("2019-07-01 00:00:00")));
    //     $this->mongo_db->where($where);
    //     $get = $this->mongo_db->get($collection);
    //     $array = iterator_to_array($get);
    //     // echo count($array);
    //     // echo "<pre>";
    //     // print_r($where);
    //     // print_r($array);
    //     // exit;
    //     $full_arr = [];
    //     foreach($array as $row){
    //         $row1 = [];
    //         $purchase_price = $row['purchased_price'];
    //         $sold_price = $row['market_sold_price'];

    //         $profit = (($sold_price - $purchase_price)/$purchase_price) * 100;
    //         $row1['_id'] = (string)$row['_id'];
    //         $row1["admin_id"] = $row["admin_id"];
    //         $row1["application_mode"] = $row["application_mode"];
    //         $row1["binance_order_id"] = $row["binance_order_id"];
    //         $row1["buy_date"] = $row["buy_date"]->toDateTime()->format("Y-m-d H:i:s");
    //         $row1["buy_parent_id"] = (string)$row["buy_parent_id"];
    //         $row1["created_date"] = $row["created_date"]->toDateTime()->format("Y-m-d H:i:s");
    //         $row1["custom_stop_loss_percentage"] = $row["custom_stop_loss_percentage"];
    //         $row1["deep_price_on_off"] = $row["deep_price_on_off"];
    //         $row1["deep_price_percentage_buy"] = $row["deep_price_percentage_buy"];
    //         $row1["defined_sell_percentage"] = $row["defined_sell_percentage"];
    //         $row1["iniatial_trail_stop"] = $row["iniatial_trail_stop"];
    //         $row1["is_sell_order"] = $row["is_sell_order"];
    //         $row1["lth_functionality"] = $row["lth_functionality"];
    //         $row1["lth_profit"] = $row["lth_profit"];
    //         $row1["market_sold_price"] = $row["market_sold_price"];
    //         $row1["market_sold_price_usd"] = $row["market_sold_price_usd"];
    //         $row1["market_value"] = $row["market_value"];
    //         $row1["market_value_usd"] = $row["market_value_usd"];
    //         $row1['profit'] = $profit;
    //         $row1["modified_date"]  = $row["modified_date"]->toDateTime()->format("Y-m-d H:i:s");
    //         $row1["order_level"] = $row["order_level"];
    //         $row1["order_mode"] = $row["order_mode"];
    //         $row1["order_type"] = $row["order_type"];
    //         $row1["price"] = $row["price"];
    //         $row1["purchased_price"] = $row["purchased_price"];
    //         $row1["quantity"] = $row["quantity"];
    //         $row1["sell_order_id"] = (string)$row["sell_order_id"];
    //         $row1["sell_price"] = $row["sell_price"];
    //         $row1["sell_profit_percent"] = $row["sell_profit_percent"];
    //         $row1["status"] = $row["status"];
    //         $row1["stop_loss_rule"] = $row["stop_loss_rule"];
    //         $row1["symbol"] = $row["symbol"];
    //         $row1["tradeId"] = $row["tradeId"];
    //         $row1["trading_ip"] = $row["trading_ip"];
    //         $row1["trading_status"] = $row["trading_status"];
    //         $row1["transactTime"] = $row["transactTime"];
    //         $row1["trigger_type"] = $row["trigger_type"];
    //         $full_arr[] = $row1;
    //     }
        
    //     $this->download_send_headers($collection."_" . date("Y-m-d_ Gisa") . ".csv");

    //     echo $this->array2csv($full_arr);
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

    // public function download_send_headers($filename) {

    //     // disable caching

    //     $now = gmdate("D, d M Y H:i:s");

    //     header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");

    //     header("Last-Modified: {$now} GMT");

    //     header("Content-type: application/csv");

    //     header("Pragma: no-cache");

    //     header("Expires: 0");

    //     // force download

    //     header("Content-Type: application/force-download");

    //     header("Content-Type: application/octet-stream");

    //     header("Content-Type: application/download");

    //     // disposition / encoding on response body

    //     header("Content-Disposition: attachment;filename={$filename}");

    //     header("Content-Transfer-Encoding: binary");

    // }

    // public function download_csv_trades() {
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();

    //     $timezone = $this->session->userdata('timezone');

    //     $time = $this->input->post('date');

    //     $coin_symbol = $this->input->post('coin');

    //     $time_arr = explode('to', $time);

    //     $s_date = $time_arr[0];

    //     $e_date = $time_arr[1];

    //     $s_dt = new DateTime($s_date, new DateTimeZone($timezone));

    //     $e_dt = new DateTime($e_date, new DateTimeZone($timezone));

    //     $s_dt->setTimezone(new DateTimeZone('UTC'));

    //     $e_dt->setTimezone(new DateTimeZone('UTC'));

    //     // format the datetime

    //     $s_time1 = $s_dt->format('Y-m-d H:i:s');

    //     $e_time1 = $e_dt->format('Y-m-d H:i:s');

    //     $start_time = date("Y-m-d H:i:00", strtotime($s_time1));

    //     $end_time = date("Y-m-d H:i:59", strtotime($e_time1));

    //     $array = $this->mod_report->get_trade_history($coin_symbol, $start_time, $end_time);

    //     $this->download_send_headers("trade_history_" . date("Y-m-d_ Gisa") . ".csv");

    //     echo $this->array2csv($array);

    //     exit;

    // }

        
}
        
    /* End of file  Csv_generator.php */
        
                            