<?php

/**
 * This is the scripting controller created for manual scripts don't try to delete it
 */
class Waqar extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    error_reporting(E_ALL);
    ini_set('display_errors', E_ALL);
    ini_set('memory_limit', -1);
  }

  public function index(){
    echo "Hello Brother!! This is your controller";
    exit;
  }

  public function get_all_candles_for_this_month($coin_symbol = 'NCASHBTC')  {
  		$this->mongo_db->where('coin', $coin_symbol);
  		$this->mongo_db->limit(100);
  		$this->mongo_db->order_by(array('timestampDate' => -1));
  		$get_arr = $this->mongo_db->get('market_chart');
  		$candle_arr = iterator_to_array($get_arr);
      foreach ($candle_arr as $key => $candle) {
        $url = 'https://app.digiebot.com/admin/vizz_script/update_candles/';
        $ch=curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($candle));
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $result = curl_exec($ch);
        curl_close($ch);
        echo "<pre>";
        echo $result;
        echo "<br>";
      }
      // echo "<pre>";
      // print_r($candle_arr);
      // echo "</pre>";
      // exit;
  }

  public function get_all_prices()  {
      $this->mongo_db->order_by(array('timestampDate' => -1));
      $get_arr = $this->mongo_db->get('market_price_history');
      $candle_arr = iterator_to_array($get_arr);
      foreach ($candle_arr as $key => $candle) {
        $url = 'https://app.digiebot.com/admin/vizz_script/update_price_history/';
        $ch=curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($candle));
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $result = curl_exec($ch);
        curl_close($ch);
        echo "<pre>";
        echo $result;
        echo "<br>";
      }
    }


    public function get_all_contracts_size($coin_symbol = "NCASHBTC"){
      echo date("Y-m-d H:i:s");
      echo "<br>";
      $start_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-24 hours")));
      $end_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-1 hour")));
      $search_array = array(
  			'coin' => $coin_symbol,
  			'timestamp' => array('$gte' => $start_date, '$lte' => $end_date));

  		$this->mongo_db->where($search_array);
  		$res = $this->mongo_db->get('market_trade_hourly_history');
  		$ask_volume_arr = iterator_to_array($res);
      $volume_Arr = array_column($ask_volume_arr, 'volume');

      echo "<pre>";
      print_r($volume_Arr);

      $total_volume = array_sum($volume_Arr);
      echo "Total Sum: ".round($total_volume);
      echo "<br>";

      $per_day = $total_volume/7;
      echo "Per Day Volume: ".round($per_day);
      echo "<br>";

      $per_five_min = $per_day/288;
      echo "Per 5 Min Volume: ".round($per_five_min);
      echo "<br>";
      echo date("Y-m-d H:i:s");
      echo "<br>";
    }

    public function get_all_contracts_time($symbol = "NCASHBTC"){
      $start_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-5 hours")));
      $end_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-1 hour")));

      $search_array = array(
  			'coin' => $symbol,
  			'created_date' => array('$gte' => $start_date, '$lte' => $end_date));

      $this->mongo_db->where($search_array);
      $this->mongo_db->limit(10);
      $res = $this->mongo_db->get('market_trade_history');
  		$ask_volume_arr = iterator_to_array($res);

      $total = count($ask_volume_arr);

      $fiv_min_avg = $total/60;

      echo $total;
    }

    public function run($symbol="NCASHBTC"){
      $start_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-24 days")));
      $end_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-1 hour")));
      $search_array = array(
        'coin' => $symbol,
        'modified_date' => array('$gte' => $start_date, '$lte' => $end_date));

      $this->mongo_db->where($search_array);
      $res = $this->mongo_db->get('coin_meta_history');
      $ask_volume_arr = iterator_to_array($res);
      $volume_Arr = array_column($ask_volume_arr, 'black_wall_pressure');
      rsort($volume_Arr);
      $black_wall_percentile_index = round((count($volume_Arr) / 100) * 10);
      $black_wall_percentile = $volume_Arr[$black_wall_percentile_index];
      echo $black_wall_percentile;
    }
    public function blackwall_percentile($coin_symbol = "NCASHBTC"){
      echo date("Y-m-d H:i:s");
      echo "<br>";

      $start_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-7 days")));
      $end_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-1 hour")));
      $search_array = array(
  			'coin' => $coin_symbol,
  			'modified_date' => array('$gte' => $start_date, '$lte' => $end_date));

  		$this->mongo_db->where($search_array);
  		$res = $this->mongo_db->get('coin_meta_history');
  		$ask_volume_arr = iterator_to_array($res);
      $volume_Arr = array_column($ask_volume_arr, 'black_wall_pressure');
      rsort($volume_Arr);
      $black_wall_percentile_index = round((count($volume_Arr) / 100) * 10);
      $black_wall_percentile = $volume_Arr[$black_wall_percentile_index];
      echo $black_wall_percentile;
      echo "<br>";
      echo date("Y-m-d H:i:s");
      echo "<br>";

      $seven_level_depth = array_column($ask_volume_arr, 'seven_level_depth');
      rsort($seven_level_depth);
      $seven_level_depth_percentile_index = round((count($seven_level_depth) / 100) * 10);
      $seven_level_depth_percentile = $seven_level_depth[$seven_level_depth_percentile_index];
      echo $seven_level_depth_percentile;
      echo "<br>";

      $market_depth_quantity = array_column($ask_volume_arr, 'market_depth_quantity');
      rsort($market_depth_quantity);
      $market_depth_quantity_percentile_index = round((count($market_depth_quantity) / 100) * 10);
      $market_depth_quantity_percentile = $market_depth_quantity[$market_depth_quantity_percentile_index];
      echo $market_depth_quantity_percentile;
      echo "<br>";

      $market_depth_ask = array_column($ask_volume_arr, 'market_depth_ask');
      rsort($market_depth_ask);
      $market_depth_ask_percentile_index = round((count($market_depth_ask) / 100) * 10);
      $market_depth_ask_percentile = $market_depth_ask[$market_depth_ask_percentile_index];
      echo $market_depth_ask_percentile;
      echo "<br>";
    }

    public function update_candle_coin_meta_fif() {
      $this->load->model('admin/mod_sockets');
		$all_coins_arr = $this->mod_sockets->get_all_coins();
    foreach ($all_coins_arr as $key => $value) {
      $coin_symbol = $value['symbol'];
      $meta_arr = $this->get_coin_meta_for_candle_fif($coin_symbol);
      $end_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00"));

        $update_arr = $meta_arr;
        $update_arr['coin'] = $coin_symbol;
        $update_arr['modified_time'] = $end_date;
        $update_arr['modified_date_human'] = date("Y-m-d H:00:00");
        echo "<pre>";
        print_r($update_arr);
        $db = $this->mongo_db->customQuery();
        $findArr = array('coin' => $coin_symbol);
      	$ins_data = $db->coin_meta_hourly_percentile->updateOne($findArr, array('$set' => $update_arr), array('upsert' => true));
        // $this->mongo_db->update('coin_meta_hourly_percentile');
    }

}
public function get_coin_meta_for_candle_fif($global_symbol){
    $start_date_1 = date("Y-m-d H:i:s");
    $calculated_array = $this->get_all_indicators_from_last_week($global_symbol,$start_date_1);
    return $calculated_array;
}
public function get_all_indicators_from_last_week($coin_symbol,$date)
  {
    $start_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime("-24 hours",strtotime($date))));
    $end_date = $this->mongo_db->converToMongodttime(date("Y-m-d H:00:00", strtotime($date)));
    $search_array = array(
      'coin' => $coin_symbol,
      'modified_date' => array('$gte' => $start_date, '$lte' => $end_date));

    $this->mongo_db->where($search_array);
    $res = $this->mongo_db->get('coin_meta_history');
    $ask_volume_arr = iterator_to_array($res);

    $volume_Arr = array_column($ask_volume_arr, 'black_wall_pressure');

    rsort($volume_Arr);
    $black_wall_percentile_index_5 = round((count($volume_Arr) / 100) * 5);
    $black_wall_percentile_5 = $volume_Arr[$black_wall_percentile_index_5];
    $ret_arr['blackwall_5'] =  $black_wall_percentile_5;

    $black_wall_percentile_index_10 = round((count($volume_Arr) / 100) * 10);
    $black_wall_percentile_10 = $volume_Arr[$black_wall_percentile_index_10];
    $ret_arr['blackwall_10'] =  $black_wall_percentile_10;

    $black_wall_percentile_index_15 = round((count($volume_Arr) / 100) * 15);
    $black_wall_percentile_15 = $volume_Arr[$black_wall_percentile_index_15];
    $ret_arr['blackwall_15'] =  $black_wall_percentile_15;

    $black_wall_percentile_index_20 = round((count($volume_Arr) / 100) * 20);
    $black_wall_percentile_20 = $volume_Arr[$black_wall_percentile_index_20];
    $ret_arr['blackwall_20'] =  $black_wall_percentile_20;

    $black_wall_percentile_index_25 = round((count($volume_Arr) / 100) * 25);
    $black_wall_percentile_25 = $volume_Arr[$black_wall_percentile_index_25];
    $ret_arr['blackwall_25'] =  $black_wall_percentile_25;
    ////////////////////////////////////////////////////////////////////////////////
    $seven_level_depth = array_column($ask_volume_arr, 'seven_level_depth');
    rsort($seven_level_depth);
    $seven_level_depth_percentile_index_5 = round((count($seven_level_depth) / 100) * 5);
    $seven_level_depth_percentile_5 = $seven_level_depth[$seven_level_depth_percentile_index_5];
    $ret_arr['sevenlevel_5'] =  $seven_level_depth_percentile_5;

    $seven_level_depth_percentile_index_10 = round((count($seven_level_depth) / 100) * 10);
    $seven_level_depth_percentile_10 = $seven_level_depth[$seven_level_depth_percentile_index_10];
    $ret_arr['sevenlevel_10'] =  $seven_level_depth_percentile_10;

    $seven_level_depth_percentile_index_15 = round((count($seven_level_depth) / 100) * 15);
    $seven_level_depth_percentile_15 = $seven_level_depth[$seven_level_depth_percentile_index_15];
    $ret_arr['sevenlevel_15'] =  $seven_level_depth_percentile_15;

    $seven_level_depth_percentile_index_20 = round((count($seven_level_depth) / 100) * 20);
    $seven_level_depth_percentile_20 = $seven_level_depth[$seven_level_depth_percentile_index_20];
    $ret_arr['sevenlevel_20'] =  $seven_level_depth_percentile_20;

    $seven_level_depth_percentile_index_25 = round((count($seven_level_depth) / 100) * 25);
    $seven_level_depth_percentile_25 = $seven_level_depth[$seven_level_depth_percentile_index_25];
    $ret_arr['sevenlevel_25'] =  $seven_level_depth_percentile_25;
    /////////////////////////////////////////////////////////////////////////////////
    $market_depth_quantity = array_column($ask_volume_arr, 'market_depth_quantity');
    rsort($market_depth_quantity);
    $market_depth_quantity_percentile_index_5 = round((count($market_depth_quantity) / 100) * 5);
    $market_depth_quantity_percentile_5 = $market_depth_quantity[$market_depth_quantity_percentile_index_5];
    $ret_arr['bid_quantity_5'] =  $market_depth_quantity_percentile_5;

    $market_depth_quantity_percentile_index_10 = round((count($market_depth_quantity) / 100) * 10);
    $market_depth_quantity_percentile_10 = $market_depth_quantity[$market_depth_quantity_percentile_index_10];
    $ret_arr['bid_quantity_10'] =  $market_depth_quantity_percentile_10;

    $market_depth_quantity_percentile_index_15 = round((count($market_depth_quantity) / 100) * 15);
    $market_depth_quantity_percentile_15 = $market_depth_quantity[$market_depth_quantity_percentile_index_15];
    $ret_arr['bid_quantity_15'] =  $market_depth_quantity_percentile_15;

    $market_depth_quantity_percentile_index_20 = round((count($market_depth_quantity) / 100) * 20);
    $market_depth_quantity_percentile_20 = $market_depth_quantity[$market_depth_quantity_percentile_index_20];
    $ret_arr['bid_quantity_20'] =  $market_depth_quantity_percentile_20;

    $market_depth_quantity_percentile_index_25 = round((count($market_depth_quantity) / 100) * 25);
    $market_depth_quantity_percentile_25 = $market_depth_quantity[$market_depth_quantity_percentile_index_25];
    $ret_arr['bid_quantity_25'] =  $market_depth_quantity_percentile_25;
    ///////////////////////////////////////////////////////////////////////////////////

    $market_depth_ask = array_column($ask_volume_arr, 'market_depth_ask');
    rsort($market_depth_ask);

    $market_depth_ask_percentile_index_5 = round((count($market_depth_ask) / 100) * 5);
    $market_depth_ask_percentile_5 = $market_depth_ask[$market_depth_ask_percentile_index_5];
    $ret_arr['ask_quantity_5'] =  $market_depth_ask_percentile_5;

    $market_depth_ask_percentile_index_10 = round((count($market_depth_ask) / 100) * 10);
    $market_depth_ask_percentile_10 = $market_depth_ask[$market_depth_ask_percentile_index_10];
    $ret_arr['ask_quantity_10'] =  $market_depth_ask_percentile_10;

    $market_depth_ask_percentile_index_15 = round((count($market_depth_ask) / 100) * 15);
    $market_depth_ask_percentile_15 = $market_depth_ask[$market_depth_ask_percentile_index_15];
    $ret_arr['ask_quantity_15'] =  $market_depth_ask_percentile_15;

    $market_depth_ask_percentile_index_20 = round((count($market_depth_ask) / 100) * 20);
    $market_depth_ask_percentile_20 = $market_depth_ask[$market_depth_ask_percentile_index_20];
    $ret_arr['ask_quantity_20'] =  $market_depth_ask_percentile_20;

    $market_depth_ask_percentile_index_25 = round((count($market_depth_ask) / 100) * 25);
    $market_depth_ask_percentile_25 = $market_depth_ask[$market_depth_ask_percentile_index_25];
    $ret_arr['ask_quantity_25'] =  $market_depth_ask_percentile_25;
    ///////////////////////////////////////////////////////////////////////////////////

    $last_qty_buy_vs_sell = array_column($ask_volume_arr, 'last_qty_buy_vs_sell');
    rsort($last_qty_buy_vs_sell);

    $last_qty_buy_vs_sell_percentile_index_5 = round((count($last_qty_buy_vs_sell) / 100) * 5);
    $last_qty_buy_vs_sell_percentile_5 = $last_qty_buy_vs_sell[$last_qty_buy_vs_sell_percentile_index_5];
    $ret_arr['last_qty_buy_vs_sell_5'] =  $last_qty_buy_vs_sell_percentile_5;

    $last_qty_buy_vs_sell_percentile_index_10 = round((count($last_qty_buy_vs_sell) / 100) * 10);
    $last_qty_buy_vs_sell_percentile_10 = $last_qty_buy_vs_sell[$last_qty_buy_vs_sell_percentile_index_10];
    $ret_arr['last_qty_buy_vs_sell_10'] =  $last_qty_buy_vs_sell_percentile_10;

    $last_qty_buy_vs_sell_percentile_index_15 = round((count($last_qty_buy_vs_sell) / 100) * 15);
    $last_qty_buy_vs_sell_percentile_15 = $last_qty_buy_vs_sell[$last_qty_buy_vs_sell_percentile_index_15];
    $ret_arr['last_qty_buy_vs_sell_15'] =  $last_qty_buy_vs_sell_percentile_15;

    $last_qty_buy_vs_sell_percentile_index_20 = round((count($last_qty_buy_vs_sell) / 100) * 20);
    $last_qty_buy_vs_sell_percentile_20 = $last_qty_buy_vs_sell[$last_qty_buy_vs_sell_percentile_index_20];
    $ret_arr['last_qty_buy_vs_sell_20'] =  $last_qty_buy_vs_sell_percentile_20;

    $last_qty_buy_vs_sell_percentile_index_25 = round((count($last_qty_buy_vs_sell) / 100) * 25);
    $last_qty_buy_vs_sell_percentile_25 = $last_qty_buy_vs_sell[$last_qty_buy_vs_sell_percentile_index_25];
    $ret_arr['last_qty_buy_vs_sell_25'] =  $last_qty_buy_vs_sell_percentile_25;

    ///////////////////////////////////////////////////////////////////////////////////

    $last_200_buy_vs_sell = array_column($ask_volume_arr, 'last_200_buy_vs_sell');
    rsort($last_200_buy_vs_sell);

    $last_200_buy_vs_sell_percentile_index_5 = round((count($last_200_buy_vs_sell) / 100) * 5);
    $last_200_buy_vs_sell_percentile_5 = $last_200_buy_vs_sell[$last_200_buy_vs_sell_percentile_index_5];
    $ret_arr['last_200_buy_vs_sell_5'] =  $last_200_buy_vs_sell_percentile_5;

    $last_200_buy_vs_sell_percentile_index_10 = round((count($last_200_buy_vs_sell) / 100) * 10);
    $last_200_buy_vs_sell_percentile_10 = $last_200_buy_vs_sell[$last_200_buy_vs_sell_percentile_index_10];
    $ret_arr['last_200_buy_vs_sell_10'] =  $last_200_buy_vs_sell_percentile_10;

    $last_200_buy_vs_sell_percentile_index_15 = round((count($last_200_buy_vs_sell) / 100) * 15);
    $last_200_buy_vs_sell_percentile_15 = $last_200_buy_vs_sell[$last_200_buy_vs_sell_percentile_index_15];
    $ret_arr['last_200_buy_vs_sell_15'] =  $last_200_buy_vs_sell_percentile_15;

    $last_200_buy_vs_sell_percentile_index_20 = round((count($last_200_buy_vs_sell) / 100) * 20);
    $last_200_buy_vs_sell_percentile_20 = $last_200_buy_vs_sell[$last_200_buy_vs_sell_percentile_index_20];
    $ret_arr['last_200_buy_vs_sell_20'] =  $last_200_buy_vs_sell_percentile_20;

    $last_200_buy_vs_sell_percentile_index_25 = round((count($last_200_buy_vs_sell) / 100) * 25);
    $last_200_buy_vs_sell_percentile_25 = $last_200_buy_vs_sell[$last_200_buy_vs_sell_percentile_index_25];
    $ret_arr['last_200_buy_vs_sell_25'] =  $last_200_buy_vs_sell_percentile_25;

    ///////////////////////////////////////////////////////////////////////////////////

    $last_qty_time_ago_x = array_column($ask_volume_arr, 'last_qty_time_ago');
    //$last_qty_time_ago = $this->waqar_run($last_qty_time_ago_x);
    $last_qty_time_ago = array_map(array($this, 'scratch_num'), $last_qty_time_ago_x);
    sort($last_qty_time_ago);
    $last_qty_time_ago_percentile_index_5 = round((count($last_qty_time_ago) / 100) * 5);
    $last_qty_time_ago_percentile_5 = $last_qty_time_ago[$last_qty_time_ago_percentile_index_5];
    $ret_arr['last_qty_time_ago_5'] =  $last_qty_time_ago_percentile_5;

    $last_qty_time_ago_percentile_index_10 = round((count($last_qty_time_ago) / 100) * 10);
    $last_qty_time_ago_percentile_10 = $last_qty_time_ago[$last_qty_time_ago_percentile_index_10];
    $ret_arr['last_qty_time_ago_10'] =  $last_qty_time_ago_percentile_10;

    $last_qty_time_ago_percentile_index_15 = round((count($last_qty_time_ago) / 100) * 15);
    $last_qty_time_ago_percentile_15 = $last_qty_time_ago[$last_qty_time_ago_percentile_index_15];
    $ret_arr['last_qty_time_ago_15'] =  $last_qty_time_ago_percentile_15;

    $last_qty_time_ago_percentile_index_20 = round((count($last_qty_time_ago) / 100) * 20);
    $last_qty_time_ago_percentile_20 = $last_qty_time_ago[$last_qty_time_ago_percentile_index_20];
    $ret_arr['last_qty_time_ago_20'] =  $last_qty_time_ago_percentile_20;

    $last_qty_time_ago_percentile_index_25 = round((count($last_qty_time_ago) / 100) * 25);
    $last_qty_time_ago_percentile_25 = $last_qty_time_ago[$last_qty_time_ago_percentile_index_25];
    $ret_arr['last_qty_time_ago_25'] =  $last_qty_time_ago_percentile_25;

    ///////////////////////////////////////////////////////////////////////////////////

    $last_qty_sell_vs_buy = array_column($ask_volume_arr, 'last_qty_buy_vs_sell');
    sort($last_qty_sell_vs_buy);

    $last_qty_sell_vs_buy_percentile_index_5 = round((count($last_qty_sell_vs_buy) / 100) * 5);
    $last_qty_sell_vs_buy_percentile_5 = $last_qty_sell_vs_buy[$last_qty_sell_vs_buy_percentile_index_5];
    $ret_arr['last_qty_sell_vs_buy_5'] =  $last_qty_sell_vs_buy_percentile_5;

    $last_qty_sell_vs_buy_percentile_index_10 = round((count($last_qty_sell_vs_buy) / 100) * 10);
    $last_qty_sell_vs_buy_percentile_10 = $last_qty_sell_vs_buy[$last_qty_sell_vs_buy_percentile_index_10];
    $ret_arr['last_qty_sell_vs_buy_10'] =  $last_qty_sell_vs_buy_percentile_10;

    $last_qty_sell_vs_buy_percentile_index_15 = round((count($last_qty_sell_vs_buy) / 100) * 15);
    $last_qty_sell_vs_buy_percentile_15 = $last_qty_sell_vs_buy[$last_qty_sell_vs_buy_percentile_index_15];
    $ret_arr['last_qty_sell_vs_buy_15'] =  $last_qty_sell_vs_buy_percentile_15;

    $last_qty_sell_vs_buy_percentile_index_20 = round((count($last_qty_sell_vs_buy) / 100) * 20);
    $last_qty_sell_vs_buy_percentile_20 = $last_qty_sell_vs_buy[$last_qty_sell_vs_buy_percentile_index_20];
    $ret_arr['last_qty_sell_vs_buy_20'] =  $last_qty_sell_vs_buy_percentile_20;

    $last_qty_sell_vs_buy_percentile_index_25 = round((count($last_qty_sell_vs_buy) / 100) * 25);
    $last_qty_sell_vs_buy_percentile_25 = $last_qty_sell_vs_buy[$last_qty_sell_vs_buy_percentile_index_25];
    $ret_arr['last_qty_sell_vs_buy_25'] =  $last_qty_sell_vs_buy_percentile_25;

    ///////////////////////////////////////////////////////////////////////////////////

    $last_200_sell_vs_buy = array_column($ask_volume_arr, 'last_200_buy_vs_sell');
    sort($last_200_sell_vs_buy);

    $last_200_sell_vs_buy_percentile_index_5 = round((count($last_200_sell_vs_buy) / 100) * 5);
    $last_200_sell_vs_buy_percentile_5 = $last_200_sell_vs_buy[$last_200_sell_vs_buy_percentile_index_5];
    $ret_arr['last_200_sell_vs_buy_5'] =  $last_200_sell_vs_buy_percentile_5;

    $last_200_sell_vs_buy_percentile_index_10 = round((count($last_200_sell_vs_buy) / 100) * 10);
    $last_200_sell_vs_buy_percentile_10 = $last_200_sell_vs_buy[$last_200_sell_vs_buy_percentile_index_10];
    $ret_arr['last_200_sell_vs_buy_10'] =  $last_200_sell_vs_buy_percentile_10;

    $last_200_sell_vs_buy_percentile_index_15 = round((count($last_200_sell_vs_buy) / 100) * 15);
    $last_200_sell_vs_buy_percentile_15 = $last_200_sell_vs_buy[$last_200_sell_vs_buy_percentile_index_15];
    $ret_arr['last_200_sell_vs_buy_15'] =  $last_200_sell_vs_buy_percentile_15;

    $last_200_sell_vs_buy_percentile_index_20 = round((count($last_200_sell_vs_buy) / 100) * 20);
    $last_200_sell_vs_buy_percentile_20 = $last_200_sell_vs_buy[$last_200_sell_vs_buy_percentile_index_20];
    $ret_arr['last_200_sell_vs_buy_20'] =  $last_200_sell_vs_buy_percentile_20;

    $last_200_sell_vs_buy_percentile_index_25 = round((count($last_200_sell_vs_buy) / 100) * 25);
    $last_200_sell_vs_buy_percentile_25 = $last_200_sell_vs_buy[$last_200_sell_vs_buy_percentile_index_25];
    $ret_arr['last_200_sell_vs_buy_25'] =  $last_200_sell_vs_buy_percentile_25;

    ///////////////////////////////////////////////////////////////////////////////////
    return $ret_arr;
  }

  function scratch_num($n)
  {
    $res = preg_replace("/[^0-9]/", "", $n );
    return $res;
  }

  public function get_all_indicator_percentile(){
    $res = $this->mongo_db->get('coin_meta_hourly_percentile');
    $ask_volume_arr = iterator_to_array($res);
    echo "<pre>";
    print_r($ask_volume_arr);
  }
  public function get_all_indicators($coin_symbol, $start_date, $end_date){
    $start_date = $this->mongo_db->converToMongodttime($start_date);
    $end_date = $this->mongo_db->converToMongodttime($end_date);
    $search_array = array(
      'coin' => $coin_symbol,
      'modified_date' => array('$gte' => $start_date, '$lte' => $end_date));
    $this->mongo_db->where($search_array);
    $res = $this->mongo_db->get('coin_meta_history');
    $ask_volume_arr = iterator_to_array($res);

    $volume_Arr = array_column($ask_volume_arr, 'black_wall_pressure');
    rsort($volume_Arr);
    $ret_arr['blackwall'] =  array_sum($volume_Arr)/count($volume_Arr);

    $seven_level_depth = array_column($ask_volume_arr, 'seven_level_depth');
    rsort($seven_level_depth);
    $ret_arr['sevenlevel'] =  array_sum($seven_level_depth)/count($seven_level_depth);

    $market_depth_quantity = array_column($ask_volume_arr, 'market_depth_quantity');
    rsort($market_depth_quantity);
    $ret_arr['bid_quantity'] =  array_sum($market_depth_quantity)/count($market_depth_quantity);

    $market_depth_ask = array_column($ask_volume_arr, 'market_depth_ask');
    rsort($market_depth_ask);
    $ret_arr['ask_quantity'] =  array_sum($market_depth_ask)/count($market_depth_ask);

    return $ret_arr;
  }
}
