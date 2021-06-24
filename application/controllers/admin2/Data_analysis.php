<?php

class Data_analysis extends CI_Controller
{
  public function __construct(){
    parent::__construct();
    //load main template
      $this->stencil->layout('admin_layout');

      //load required slices
      $this->stencil->slice('admin_header_script');
      $this->stencil->slice('admin_header');
      $this->stencil->slice('admin_left_sidebar');
      $this->stencil->slice('admin_footer_script');
		// Load Modal
  }

  public function index(){
    $this->load->model('admin/mod_sockets');
    $all_coins_arr = $this->mod_sockets->get_all_coins();
    $data['coin_arr'] = $all_coins_arr;
    $this->stencil->paint('admin/data_analysis/index',$data);
  }

  public function get_the_data(){
    $datetime = $this->input->post('time');

    $start_datetime = date('Y-m-d H:00:00', strtotime($datetime));
    $end_datetime   = date('Y-m-d H:59:59', strtotime($datetime));
    $symbol = $this->input->post('coin');
    $data = $this->get_all_responses_live($start_datetime, $end_datetime,$symbol);
    $data2 = $this->get_all_responses_test($start_datetime, $end_datetime,$symbol);
    $response = '<table class="table">
    <thead>
    <tr>
    <th></th>
    <th>Live Server</th>
    <th>Test Server</th>
    <th>Action</th>
    </tr>
    </thead>

    <tbody>
    <tr>
    <th>Order Book: </th>
    <td>'.$data['order_book'].'</td>
    <td>'.$data2['order_book'].'</td>
    <td><button class="btn btn-success btn-sm analysis" data-toggle="modal" data-target="#basicExampleModal" data-id="order_book">Analysis</button></td>
    </tr>
    <tr>
    <th>Trade History: </th>
    <td>'.$data['market_trade'].'</td>
    <td>'.$data2['market_trade'].'</td>
    <td><button class="btn btn-success btn-sm analysis" data-toggle="modal" data-target="#basicExampleModal" data-id="market_trade">Analysis</button></td>
    </tr>
    <tr>
    <th>Price History: </th>
    <td>'.$data['market_price'].'</td>
    <td>'.$data2['market_price'].'</td>
    <td><button class="btn btn-success btn-sm analysis" data-toggle="modal" data-target="#basicExampleModal" data-id="market_price">Analysis</button></td>
    </tr>
    <tr>
    <th>Coin Meta History: </th>
    <td>'.$data['coin_meta'].'</td>
    <td>'.$data2['coin_meta'].'</td>
    <td><button class="btn btn-success btn-sm analysis" data-toggle="modal" data-target="#basicExampleModal" data-id="coin_meta">Analysis</button></td>
    </tr>
    </tbody>
    </table>';

    echo $response;
    exit;
  }

  public function get_all_responses_live($sdate, $edate,$symbol){
    $response_date_s = $this->mongo_db->converToMongodttime($sdate);
    $response_date_e = $this->mongo_db->converToMongodttime($edate);

    $search_arr['coin'] = $symbol;
    $search_arr['created_date']['$gte'] = $response_date_s;
    $search_arr['created_date']['$lte'] = $response_date_e;
    $search_arr22['coin'] = $symbol;
    $search_arr22['modified_date']['$gte'] = $response_date_s;
    $search_arr22['modified_date']['$lte'] = $response_date_e;
    $db = $this->mongo_db->customQuery();
    $data_arr = array();
    $data_arr['order_book']   = $db->market_depth->count($search_arr);
    $data_arr['market_trade'] = $db->market_trades->count($search_arr);
    $data_arr['market_price'] = $db->market_prices->count($search_arr);
    $data_arr['coin_meta']    = $db->coin_meta_history->count($search_arr22);

    return $data_arr;
  }

  public function get_all_responses_test($sdate, $edate,$symbol){
    $post = [
        'sdate'=> $sdate,
        'edate' => $edate,
        'symbol' => $symbol
    ];
    $data_string = http_build_query($post);

    $ch = curl_init();
    $url = "http://207.180.198.49/admin/vizz_script/get_all_responses_test";
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, count($post));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($result,true);
    return $result;
  }


  public function analyze_data(){
    $type = $this->input->post('type');
    $datetime = $this->input->post('time');
    $symbol = $this->input->post('coin');

    $start_datetime = date('Y-m-d H:00:00', strtotime($datetime));
    $end_datetime   = date('Y-m-d H:59:59', strtotime($datetime));

    if ($type == 'market_trade') {
      $data_arr_live = $this->get_all_trade_history_live($start_datetime,$end_datetime,$symbol);
      $data_arr_test = $this->get_all_trade_history_test($start_datetime,$end_datetime,$symbol);

      $candle = $this->get_candle_volume($symbol, $start_datetime);
      $low = $candle[0]['low'];
      $volume = $candle[0]['volume'];
      $total_volume = $candle[0]['total_volume'];

      $btc = $this->calculate_my_volume_in_btc($total_volume, $low);

      $btc_test = $this->calculate_btc_test($symbol,$start_datetime);
    }

    echo "<pre>";
    echo "Live"."<br>";
    echo "======================================================================";
    echo "<br>";
    echo "Low Price: ".$low."===> Volume: ".$volume." ====> My BTC ".$btc;
    echo "<br>";
    echo "======================================================================";
    echo "<br>";
    print_r($data_arr_live);
    echo "Test"."<br>";
    echo $btc_test;
    print_r($data_arr_test);
    exit;
  }
  public function get_all_trade_history_live($sdate, $edate,$symbol)
  {
    $response_date_s = $this->mongo_db->converToMongodttime($sdate);
    $response_date_e = $this->mongo_db->converToMongodttime($edate);
    $search_arr['coin'] = $symbol;
    $search_arr['created_date']['$gte'] = $response_date_s;
    $search_arr['created_date']['$lte'] = $response_date_e;
    $db = $this->mongo_db->customQuery();
    $get_object = $db->market_trades->find($search_arr);
    $total_volume = 0;
    $bid_volume = 0;
    $ask_volume = 0;
    $get_array = iterator_to_array($get_object);
    foreach ($get_array as $key => $value) {
      $total_volume +=  $value['quantity'];
      if ($value['maker'] == 'true') {
        $ask_volume += $value['quantity'];
      }elseif($value['maker'] == 'false'){
        $bid_volume += $value['quantity'];
      }
    }

    return array(
      'bid' => $bid_volume,
      'ask' => $ask_volume,
      'total' => $total_volume
    );
  }

  public function get_all_trade_history_test($sdate, $edate,$symbol){
    $post = [
        'sdate'=> $sdate,
        'edate' => $edate,
        'symbol' => $symbol
    ];
    $data_string = http_build_query($post);

    $ch = curl_init();
    $url = "http://207.180.198.49/admin/vizz_script/get_all_trade_history_live";
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, count($post));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($result,true);

    return $result;
  }
  public function calculate_btc_test($symbol,$candle_date){
    $post = [
        'time'=> $candle_date,
        'coin' => $symbol
    ];
    $data_string = http_build_query($post);

    $ch = curl_init();
    $url = "http://207.180.198.49/admin/vizz_script/analyze_data";
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, count($post));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    //$result = json_decode($result,true);

    return $result;
  }
  public function get_candle_volume($symbol,$candle_date){
    echo "Symbol: ".$symbol." Date: ".$candle_date;
    $response_date_s = $this->mongo_db->converToMongodttime($candle_date);
    $search_arr['coin'] = $symbol;
    $search_arr['openTime_human_readible'] = $candle_date;
    $this->mongo_db->where($search_arr);
    $this->mongo_db->limit(1);
    $this->mongo_db->order_by(array("_id" => -1));
    $db = $this->mongo_db->get('market_chart');
    $arr = iterator_to_array($db);
    return $arr;

    //$get_object = $db->market_chart->find($search_arr);
  }

  public function calculate_my_volume_in_btc($myVolume, $low){
      $btc = $myVolume * $low;

      return $btc;
  }
}
