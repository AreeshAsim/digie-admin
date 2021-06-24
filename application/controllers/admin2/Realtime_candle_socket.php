<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Realtime_candle_socket extends CI_Controller {
	
	public function __construct(){
		
		parent::__construct();
		
		// Load Modal
        $this->load->model('admin/mod_sockets');
        $this->load->model('admin/mod_candel');
        $this->load->model('admin/mod_realtime_candle_socket');
        $this->load->library('binance_api');

	}

	public function index()
	{
   
    //Get All Coins
    $all_coins_arr = $this->mod_sockets->get_all_coins();
    $period_array = array('1h');

    for ($i=0; $i<count($all_coins_arr); $i++) { 

      $coin_symbol = $all_coins_arr[$i]['symbol'];

      //Check socket Call
      $check_socket_track = $this->mod_sockets->check_socket_track('market_chart',$coin_symbol);

      if($check_socket_track =='no'){

          //Insert Socket Record
          $created_date = date('Y-m-d G:i:s');

          /*** Run Socket for period***/
          foreach ($period_array as $periods ) {
          
              $api = $this->binance_api->get_master_api();
              $api->chart([$coin_symbol], $periods, function($api, $symbol, $chart) {

                $periods = '1h';
                 
                if (count($chart)>0) {

                    foreach ($chart as $key => $value) {
                       
                        $created_datetime = date('Y-m-d G:i:s');

                        $orig_date = new DateTime($created_datetime);
                        $orig_date = $orig_date->getTimestamp(); 
                        $created_date = new MongoDB\BSON\UTCDateTime($orig_date*1000);
                       
                        $seconds = $value['openTime'] / 1000;
                        $datetime = date("Y-m-d H:i:s", $seconds);

                        $openTime_human_readible = $datetime;


                        $seconds_close = $value['closeTime'] / 1000;
                        $datetime_close = date("Y-m-d H:i:s", $seconds_close);

                        $closeTime_human_readible = $datetime_close;


                        $orig_date22 = new DateTime($datetime);
                        $orig_date22 = $orig_date22->getTimestamp(); 
                        $timestampDate = new MongoDB\BSON\UTCDateTime($orig_date22*1000);
                       
                        $insert22 = array(
                            'open'=> $value['open'],
                            'high'=> $value['high'],
                            'low'=> $value['low'], 
                            'close'=> $value['close'],
                            'volume'=> $value['volume'],
                            'openTime'=> $value['openTime'],
                            'closeTime'=> $value['closeTime'],
                            'coin'=> $symbol,
                            'created_date'=> $created_date,
                            'timestampDate'=> $timestampDate,
                            'periods'=> $periods,
                            'openTime_human_readible'=>$openTime_human_readible,
                            'closeTime_human_readible'=>$closeTime_human_readible,
                            'human_readible_dateTime'=>date('Y-m-d G:i:s')
                        );
                       
                        $check_candle= $this->mod_sockets->check_candle_stick_data_if_exist($symbol,$periods,$value['openTime']);
                        if($check_candle){

                            $this->mongo_db->insert('market_chart',$insert22);
                            
                            echo 'insert'.'<br>';
              
                        }else{

                            $if_current_cand = $this->check_if_current_candle($periods,$value['openTime']);
                            
                            if($if_current_cand){
                                $this->mod_sockets->candle_update($symbol,$periods,$value['openTime'],$insert22);
                                 $update_count_for_canlde_missing = $this->mod_sockets->update_count_for_duplicating_candle();
                                 echo 'update'.'<br>';

                            }else{
                                 $update_count_for_canlde_missing = $this->mod_sockets->update_count_for_ignore_candle();
                                 echo 'nothing'.'<br>';
                            
                            }

                        }/*** End of insert***/
                    }
                }

                //Update Socket Track
                $this->mod_sockets->update_socket_track('market_chart',$symbol);
               
              });

          }/** End of period array**/ 

      }else{

        echo "Socket is Running for ".$coin_symbol."... </br>";
      }

    }//end for


	}



  public function save_candle_stick_by_cron_job()
  {

      //now this functin move to markert_trade_socket controller
   $this->mod_realtime_candle_socket->save_candle_stick_by_cron_job();  
    
  }//end save_candle_stick_by_cron_job



  public function save_candle_stick_by_cron_job_ilyas()
  {
   
   
    $period_array = array('1h');
   
    $coin_symbol = 'EOSBTC';

    //Check socket Call
    $check_socket_track = $this->mod_sockets->check_socket_track('market_chart',$coin_symbol);

    if($check_socket_track =='no'){

        //Insert Socket Record
        $created_date = date('Y-m-d G:i:s');

        /*** Run Socket for period***/
        foreach ($period_array as $periods ) {
        
            $api = $this->binance_api->get_master_api();
            $api->chart([$coin_symbol], $periods, function($api, $symbol, $chart) {


              // echo "<pre>";
              // print_r($chart);
              // exit;

              $periods = '1h';
               
              if (count($chart)>0) {

                  foreach ($chart as $key => $value) {
                     
                      $created_datetime = date('Y-m-d G:i:s');

                      $orig_date = new DateTime($created_datetime);
                      $orig_date = $orig_date->getTimestamp(); 
                      $created_date = new MongoDB\BSON\UTCDateTime($orig_date*1000);
                     
                      $seconds = $value['openTime'] / 1000;
                      $datetime = date("Y-m-d H:i:s", $seconds);

                      $openTime_human_readible = $datetime;


                      $seconds_close = $value['closeTime'] / 1000;
                      $datetime_close = date("Y-m-d H:i:s", $seconds_close);

                      $closeTime_human_readible = $datetime_close;


                      $orig_date22 = new DateTime($datetime);
                      $orig_date22 = $orig_date22->getTimestamp(); 
                      $timestampDate = new MongoDB\BSON\UTCDateTime($orig_date22*1000);
                     
                      $insert22 = array(
                          'open'=> $value['open'],
                          'high'=> $value['high'],
                          'low'=> $value['low'], 
                          'close'=> $value['close'],
                          'volume'=> $value['volume'],
                          'openTime'=> $value['openTime'],
                          'closeTime'=> $value['closeTime'],
                          'coin'=> $symbol,
                          'created_date'=> $created_date,
                          'timestampDate'=> $timestampDate,
                          'periods'=> $periods,
                          'openTime_human_readible'=>$openTime_human_readible,
                          'closeTime_human_readible'=>$closeTime_human_readible,
                          'human_readible_dateTime'=>date('Y-m-d G:i:s')
                      );
                     
                      $check_candle= $this->mod_sockets->check_candle_stick_data_if_exist($symbol,$periods,$value['openTime']);
                      if($check_candle){

                          $this->mongo_db->insert('market_chart',$insert22);
                          
                          echo 'insert'.'<br>';
            
                      }else{

                          $if_current_cand = $this->check_if_current_candle($periods,$value['openTime']);
                          
                          if($if_current_cand){
                              $this->mod_sockets->candle_update($symbol,$periods,$value['openTime'],$insert22);
                               $update_count_for_canlde_missing = $this->mod_sockets->update_count_for_duplicating_candle();
                               echo 'update'.'<br>';

                          }else{
                               $update_count_for_canlde_missing = $this->mod_sockets->update_count_for_ignore_candle();
                               echo 'nothing'.'<br>';
                          
                          }

                      }/*** End of insert***/
                  }
              }


              echo "<pre>";
              print_r($chart);
              exit;

              //Update Socket Track
              $this->mod_sockets->update_socket_track('market_chart',$symbol);
             
            });

        }/** End of period array**/ 

    }else{

      echo "Socket is Running for ".$coin_symbol."... </br>";
    }


  }//end save_candle_stick_by_cron_job_ilyas



 public function check_if_current_candle($periods,$openTime){

        list($alpha,$numeric) = sscanf($periods, "%[A-Z]%d");

        switch ($alpha) {
        case "h":
        $response_period = ($numeric*3600)*2;
        break;

        case "m":
        $response_period = ($numeric*60)*2;
        break;

        default:
        $response_period = 1*2;
        }

        $seconds = $openTime/ 1000;
        $datetime = date("Y-m-d H:i:s", $seconds);

        $seconds_2 = $seconds - $response_period;

        $datetime_2 = date("Y-m-d H:i:s", $seconds_2);


        if($datetime_2<$datetime){
           return true;
        }else{
           return false;
        }
  }/*** End of check_if_current_candle**/


    public function get_and_calculate_volume_for_candel($from_date,$end_date,$volume_type,$coin_type){


          $connect = $this->mongo_db->customQuery();
          $res  = $connect->market_trade_hourly_history->find(array(
            'type'=>$volume_type,
            'coin'=>$coin_type,
            'hour'=>array('$gte'=>$from_date,'$lte'=>$end_date)
          ));
          $volume = 0;
          $res = iterator_to_array($res);
          foreach ($res as $key ) {
              $volume += (float)$key['volume'];
          }

          return $volume;

    }//End of  get_and_calculate_volume_for_candel


    public function calculate_base_candel($coin_symbol){
        $total_volume = 0;
        $volume_arr = array();
        for($index_date = 1 ;$index_date<=68;$index_date++){
          $from_date_for_candel = date("Y-m-d H:00:00",strtotime('-'.$index_date.' hour'));
          $end_date_for_candel = date("Y-m-d H:59:59",strtotime('-'.$index_date.' hour'));
          $ask_volume = $this->get_and_calculate_volume_for_candel($from_date_for_candel,$end_date_for_candel,'ask',$coin_symbol);
          $bid_volume = $this->get_and_calculate_volume_for_candel($from_date_for_candel,$end_date_for_candel,'bid',$coin_symbol);
          $total_volume = $ask_volume+$bid_volume;
          $volume_arr[] = $total_volume;
        }

       rsort($volume_arr);
       $output = array_slice($volume_arr, 0, 25); 
      return  $average = array_sum($output)/count($output);
    }//End of calculate_base_candel




  public function test(){
    $this->mongo_db->order_by(array('_id' => 'desc'));
    $this->mongo_db->limit(2);
    $res = $this->mongo_db->get('market_chart');
    $res= iterator_to_array($res);
    echo '<pre>';
    print_r($res);
    exit();
  }


}/*** End class**/
	
