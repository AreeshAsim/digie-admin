<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TradeHistory extends CI_Controller{
  public function __construct(){
      parent::__construct();
      //load main template
      $this->stencil->layout('admin_layout');
      // ini_set("display_errors", E_ALL);
      // error_reporting(E_ALL);
      //load required slices
      $this->stencil->slice('admin_header_script');
      $this->stencil->slice('admin_header');
      $this->stencil->slice('admin_left_sidebar');
      $this->stencil->slice('admin_footer_script');
      // Load Modal
      $this->load->model('admin/mod_login');
      $this->load->model('admin/mod_users');
      $this->load->model('admin/mod_coins');

      $this->load->helper('new_common_helper');
  }

  public function getKrakenTradeHistroyDuplicationCron(){
    $db = $this->mongo_db->customQuery(); 
    $collection1            = 'buy_orders_kraken'; 
    $collection2            = 'sold_buy_orders_kraken';
    $upsertCollection_name  = 'duplicate_orders_kraken'; 
    $current_time_date = $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'));

    $next_date =  date('Y-m-d H:i:s', strtotime('-1 days'));   // run this on 27 date and then run after 1 month
    $pre_time_date =  $this->mongo_db->converToMongodttime($next_date);

    $getUsers = [
      [
        '$match' => [
          '$or' =>[
            ['is_modified_trade_history_kraken' => ['$lte'=>$pre_time_date]],
            ['is_modified_trade_history_kraken' => ['$exists' => false]]
          ],
          // 'username' => 'kentodd',
          'application_mode' => ['$in'=> ['both', 'live']]
        ],
      ],
      [
        '$sort' =>['created_date'=> -1],
      ],
      ['$limit'=> 1]
    ];
    $user_return_collectio = $db->users->aggregate($getUsers);
    $user_return_detail = iterator_to_array($user_return_collectio);
    // print_r($user_return_detail);

    if(count($user_return_detail) > 0){
      $payload = [
          'admin_id' => (string)$user_return_detail[0]['_id'],
          'txid'     => '', 
          'initialOffset'   => 0, 
          'symbol'          => '', 
      ];

      $jsondata1 = json_encode($payload);
      $curl = curl_init();
      curl_setopt_array($curl, array(
          CURLOPT_URL => "http://34.199.235.34:3200/GetUserTradesKraken",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>$jsondata1,
          CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
      ));
      $response_price = curl_exec($curl);	
      curl_close($curl);                                
      $api_response = json_decode($response_price);


      echo "<br>Username:  ".$user_return_detail[0]['username'];
      if(count($api_response) > 0 ){
        foreach ($api_response->data as $orders){

          $arrayUpsert = [
            'TransactionID' =>  $orders->TransactionID,
            'pair'          =>  $orders->AssetPair,
            'time'          =>  $this->mongo_db->converToMongodttime($orders->CloseTime),
            'price'         =>  $orders->Price,
            'cost'          =>  $orders->Cost,
            'OrderType'     =>  $orders->OrderType,
            'qty'           =>  $orders->VolumeExecuted,
            'type'          =>  $orders->Type,
            'fee'           =>  $orders->Fee,
            'leverage'      =>  $orders->Leverage,
            'username'      =>  $user_return_detail[0]['username']
          ];
          if($orders->AssetPair == 'QTUMXBT'){
            $coin = 'QTUMBTC';
          }elseif($orders->AssetPair == 'LINKXBT'){
            $coin = 'LINKBTC';
          }elseif($orders->AssetPair == 'XRPXBT'){
            $coin = 'XRPBTC';
          }elseif($orders->AssetPair == 'XBTUSDT'){
            $coin = 'BTCUSDT';
          }elseif($orders->AssetPair == 'XLMXBT'){
            $coin = 'XLMBTC';
          }elseif($orders->AssetPair == 'ETHXBT'){
            $coin = 'ETHBTC';
          }elseif($orders->AssetPair == 'XMRXBT'){
            $coin = 'XMRBTC';
          }elseif($orders->AssetPair == 'ADAXBT'){
            $coin = 'ADABTC';
          }elseif($orders->AssetPair == 'TRXXBT'){
            $coin = 'TRXBTC';
          }elseif($orders->AssetPair == 'EOSXBT'){
            $coin = 'EOSBTC';
          }elseif($orders->AssetPair == 'ETCXBT'){
            $coin = 'ETCBTC';
          }else{
            $coin = $orders->AssetPair;
          }

          $find_order['admin_id']         =   (string)$user_return_detail[0]['_id'];
          $find_order['kraken_order_id']  =   $orders->TransactionID;     
          $dataReturn = $db->$collection1->count($find_order);

          $findOrderSold['admin_id'] = (string)$user_return_detail[0]['_id'];

          $findOrderSold['sell_kraken_order_id']   = $orders->TransactionID;
          // $findOrderSold2['kraken_order_id']        = $orders->TransactionID;
          // $findOrderSold['$or'] = [$findOrderSold1, $findOrderSold2];

          $dataReturn2  = $db->$collection2->count($findOrderSold);

          $find_order_sold['admin_id']         =   (string)$user_return_detail[0]['_id'];
          $find_order_sold['kraken_order_id']  =   $orders->TransactionID;  
          $dataReturn3  = $db->$collection2->count($find_order_sold);

          if( $orders->OrderType == 'limit'){
            $arrayUpsert['status'] = 'user_confirmed_duplicate';

          }elseif($dataReturn2 > 0 || $dataReturn > 0 || $dataReturn3 > 0 ){
            $arrayUpsert['status'] = 'mapped';
          
          }else{
            $find_order['admin_id'] = (string)$user_return_detail[0]['_id'];

            $time = date("d-m-Y H:i:s", strtotime($orders->CloseTime));

            $start_Date = date($time, strtotime('-5 minutes'));
            $end_Date   = date($time, strtotime('+5 minutes'));

            $start_Date = $this->mongo_db->converToMongodttime($start_Date);
            $end_Date   = $this->mongo_db->converToMongodttime($end_Date);

            $find_order['quantity']      =   $orders->VolumeExecuted;
            $find_order['symbol']        =   $coin;
            $find_order['status']        =   ['$nin' => ['canceled', 'new']];
            $find_order['parent_status'] =   ['$ne' => 'parent'];
            // $find_order['created_date']  =   ['$gte' => $start_Date, '$lte' => $end_Date];

            $dataReturn = $db->$collection1->find($find_order);
            $dataReturn = iterator_to_array($dataReturn);

            $findOrderSold['admin_id'] = (string)$user_return_detail[0]['_id'];

            $findOrderSold['quantity']      =   $orders->VolumeExecuted;
            $findOrderSold['symbol']        =   $coin;
            $findOrderSold['status']        =   ['$nin' => ['canceled', 'new']];
            $findOrderSold['parent_status'] =   ['$ne' => 'parent'];
            // $findOrderSold['created_date']  =   ['$gte' => $start_Date, '$lte' => $end_Date];

            $dataReturn2 = $db->$collection2->find($findOrderSold);
            $dataReturn2 = iterator_to_array($dataReturn2);

            $dataReturn3 = $db->$collection2->find($find_order);
            $dataReturn3 = iterator_to_array($dataReturn3);

            if(count($dataReturn) > 0  || count($dataReturn2) > 0 || count($dataReturn3) > 0){

              echo "<br>coin symbol: ".$orders->AssetPair;
              echo "<br> dataReturn _id matching order: ".(string)$dataReturn[0]['_id'] ;

              echo "<br> dataReturn2 _id matching order: ".(string)$dataReturn2[0]['_id'] ;
              echo "<br> dataReturn3 _id matching order: ".(string)$dataReturn3[0]['_id'] ;

              echo "<br>Trasection id from Kraken:". $orders->TransactionID;
              $arrayUpsert['status'] = 'digie_confirmed_duplicate';

              echo "<br>=======================================================================";
            }else{

              $search_criteria['admin_id'] = (string)$user_return_detail[0]['_id'];

              $quantityLowerRange = $orders->VolumeExecuted  - ((3/100)* $orders->VolumeExecuted);
              $quantityUpperRange = $orders->VolumeExecuted  + ((3/100)* $orders->VolumeExecuted);

              // 5/100 × 200

              $search_criteria['quantity']      =   ['$gte' => $quantityLowerRange, '$lte' =>  $quantityUpperRange];   
              $search_criteria['symbol']        =   $coin;
              $search_criteria['status']        =   ['$nin' => ['canceled', 'new']];
              $search_criteria['parent_status'] =   ['$ne' => 'parent'];                
            
              $search_criteria_get       = $db->$collection1->find($search_criteria);
              $search_criteria_response  = iterator_to_array($search_criteria_get);

              $search_criteria_other['admin_id']      =   (string)$user_return_detail[0]['_id'];  
              $search_criteria_other['quantity']      =   ['$gte' => $quantityLowerRange, '$lte' =>  $quantityUpperRange];   
              $search_criteria_other['symbol']        =   $coin;
              $search_criteria_other['status']        =   ['$nin' => ['canceled', 'new']];
              $search_criteria_other['parent_status'] =   ['$ne' => 'parent'];
              
              $search_criteria_other_get        =   $db->$collection2->find($search_criteria_other);
              $search_criteria_other_response   =   iterator_to_array($search_criteria_other_get);

              $search_criteria_other_getnext        = $db->$collection2->find($search_criteria);
              $search_criteria_other_responsenext   = iterator_to_array($search_criteria_other_getnext);

              if(count($search_criteria_response) > 0  || count($search_criteria_other_response) > 0 || count($search_criteria_other_responsenext) > 0){

                $arrayUpsert['status'] = '97_per_digie_doubt' ;
              }else{
        
                $arrayUpsert['status'] = 'user_doubt';
              }
            }
          }
          $update_where['username']       =   $user_return_detail[0]['username'];
          $update_where['TransactionID']  =   $orders->TransactionID;
          $upsert['upsert'] = true;
          $db->$upsertCollection_name->updateOne($update_where, ['$set'=> $arrayUpsert], $upsert);

        }//end loop
      }//end check of orders count

      $array_update_in_user_colection['is_modified_trade_history_kraken']   =   $current_time_date;
      
      $search_find['_id']       =   $this->mongo_db->mongoId((string)$user_return_detail[0]['_id']);
      $search_find['username']  =   $user_return_detail[0]['username'];
      
      $this->mongo_db->where($search_find);
      $this->mongo_db->set($array_update_in_user_colection); 
      $this->mongo_db->update('users');

      // print_r($api_response);
    }//end count check

  }//end controller
  
  //stepFirst binance
  public function getUnmapedTradeHistroyMapCron(){
    // $whereGetOrders['user_id'] = "5eb5a5a628914a45246bacc6";

    $where1['status']  =  'unmaped' ;
    $where2['status']  = ['$exists' => false];

    $whereGetOrders['$or'] = [$where1, $where2];

    $condition = ['limit' => 100];
    $db        = $this->mongo_db->customQuery();

    $res      =   $db->user_trade_history->find($whereGetOrders, $condition);
    $result   =   iterator_to_array($res);
    
    echo "<br>Count".count($result);

    $collection1 = 'buy_orders'; 
    $collection2 = 'sold_buy_orders';

    if(count($result) > 0){

      for($order = 0 ; $order < count($result); $order++){

        $updateOrder['_id'] = $this->mongo_db->mongoId((string)$result[$order]['_id']); 

        if($result[$order]['trades']['value']['ordertype'] == 'limit' || $result[$order]['trades']['value']['ordertype'] == 'stop-loss'){

          $db->user_trade_history->updateOne($updateOrder, ['$set' => ['status' => 'user_confirmed']]);
          echo "<br>user confirmed order id:". (string)$updateOrder['_id'];          
        }else{
          
          if($result[$order]['trades']['value']['type'] == 'buy'){

            $find_order['admin_id']          =   (string)$result[$order]['user_id'];
            $find_order['binance_order_id']  =   $result[$order]['trades']['value']['orderId'];

            $record  = $db->$collection1->count($find_order);
            $record2 = $db->$collection2->count($find_order);

            if($record > 0 || $record2 > 0){

              $db->user_trade_history->updateOne($updateOrder, ['$set' => ['status' => 'mapped']]);
              echo "<br>Buy mapped order id:". (string)$updateOrder['_id'];
            }else{

              $db->user_trade_history->updateOne($updateOrder, ['$set' => ['status' => 'pending']]);
              echo "<br>Buy pending order id:". (string)$updateOrder['_id'];
            }

          }else{

            $findOrderSold['admin_id']  =   (string)$result[$order]['user_id'];;
            $findOrderSold['binance_order_id_sell']       =   $result[$order]['trades']['value']['orderId'];
            $record1 = $db->$collection2->count($findOrderSold);
            if($record1 > 0 ){

              $db->user_trade_history->updateOne($updateOrder, ['$set' => ['status' => 'mapped']]);
              echo "<br>Sell mapped order id:". (string)$updateOrder['_id'];
            }else{

              $db->user_trade_history->updateOne($updateOrder, ['$set' => ['status' => 'pending']]);
              echo "<br>Sell pending order id:". (string)$updateOrder['_id'];
            }
          }

        }//end else if 
      }
    }
    echo "<br>Done";


  }//end controller   
  

  // get pending make ready for scan 2nd step binance
  public function getPendingTradeCron(){

    // $whereGetOrders['user_id'] = "5eb5a5a628914a45246bacc6";

    $whereGetOrders['status']  = 'pending';

    $condition = ['limit' => 10];
    $db = $this->mongo_db->customQuery();

    $res      =   $db->user_trade_history->find($whereGetOrders,  $condition);
    $result   =   iterator_to_array($res);

    echo "<br> order get Count: ".count($result);

    if(count($result) > 0){

      for($order = 0 ; $order < count($result); $order++){

        $queryGet = [
          [
            '$match' => [
          
              'trades.value.orderId' => $result[$order]['trades']['value']['orderId']
            ]
          ],
        ];

        $ordersGet      =   $db->user_trade_history->aggregate($queryGet);
        $ordersGetRes   =   iterator_to_array($ordersGet);
        
        if(count($ordersGetRes) > 1){

          $qty = 0;
          for($new = 0 ; $new < count($ordersGetRes); $new++){

            $updateOrder['_id'] = $this->mongo_db->mongoId((string)$ordersGetRes[$new]['_id']); 
            $qty += $ordersGetRes[$new]['trades']['value']['vol'];

            if( ($new + 1) != count($ordersGetRes) ){
              
              $db->user_trade_history->updateOne($updateOrder, ['$set' => ['status' => 'fractionChild']]);
              echo "<br>Fraction child order id:". (string)$updateOrder['_id'];
            }
          }
          
          $setNewArry = [

            'trades.value.qty'    =>  $qty,
            'status'              =>  'ready_for_scan'
          ];

          echo "<pre>";print_r($setNewArry);
          $db->user_trade_history->updateOne($updateOrder, ['$set' => $setNewArry]);
          echo "<br>Fraction Prent order id:". (string)$updateOrder['_id'];

        }else{

          $updateOrder['_id'] = $this->mongo_db->mongoId((string)$result[$order]['_id']); 

          $db->user_trade_history->updateOne($updateOrder, ['$set' => ['status' => 'ready_for_scan']]);
          echo "<br>ready for scanning order id:". (string)$updateOrder['_id'];

        }
        echo "<br>Count:".count($ordersGetRes);

      }//end loop
    }//end if
  }

  //3rd step binance
  public function getReadyForScanTradeCron(){

    // $whereGetOrders['user_id'] = "5eb5a5a628914a45246bacc6";
    $whereGetOrders['status']  = 'ready_for_scan';

    $condition = ['limit' => 100];
    $db        = $this->mongo_db->customQuery();

    $res      =   $db->user_trade_history->find($whereGetOrders, $condition);
    $result   =   iterator_to_array($res);

    $collection1 = 'buy_orders'; 
    $collection2 = 'sold_buy_orders';

    echo "<br>count orders: ".count($result);

    if(count($result) > 0){

      for($order = 0 ; $order < count($result); $order++){

        $updateOrder['_id'] = $this->mongo_db->mongoId((string)$result[$order]['_id']); 
        
        $time = date("d-m-Y H:i:s", strtotime($result[$order]['trades']['value']['time']));

        $start_Date = date($time, strtotime('-2 minutes'));
        $end_Date   = date($time, strtotime('+2 minutes'));

        $start_Date = $this->mongo_db->converToMongodttime($start_Date);
        $end_Date   = $this->mongo_db->converToMongodttime($end_Date);

        $quantityRangeLower = $result[$order]['trades']['value']['qty']  - ((1/100)* $result[$order]['trades']['value']['qty']);
        $quantityRangeUpper = $result[$order]['trades']['value']['qty']  + ((1/100)* $result[$order]['trades']['value']['qty']);

        $findOrder['admin_id']          =   (string)$result[$order]['user_id'];
        $findOrder['symbol']            =   $result[$order]['trades']['value']['pair'];
        $findOrder['status']            =   ['$nin' => ['canceled', 'new']];
        $findOrder['parent_status']     =   ['$ne' => 'parent'];
        $findOrder['application_mode']  =   'live';  
        $findOrder['created_date']      =   ['$gte' => $start_Date, '$lte' => $end_Date];
        $findOrder['quantity']          =   ['$gte'=> $quantityRangeLower, '$lte' => $quantityRangeUpper ];

        $record1 = $db->$collection2->count($findOrder);
        $record  = $db->$collection1->count($findOrder);

        if($record1 > 0 || $record > 0){

          $db->user_trade_history->updateOne($updateOrder, ['$set' => ['status' => 'duplicate']]);
          echo "<br>duplicate order id:". (string)$updateOrder['_id'];
        }else{

          // level 1
          $time = date("d-m-Y H:i:s", strtotime($result[$order]['trades']['value']['time']));
          $startDate = date($time, strtotime('-2 minutes'));
          $endDate   = date($time, strtotime('+2 minutes'));

          $startDate = $this->mongo_db->converToMongodttime($startDate);
          $endDate   = $this->mongo_db->converToMongodttime($endDate);

          $quantityLowerRange = $result[$order]['trades']['value']['qty']  - ((1/100)* $result[$order]['trades']['value']['qty']);
          $quantityUpperRange = $result[$order]['trades']['value']['qty']  + ((1/100)* $result[$order]['trades']['value']['qty']);

          $find_order_next['admin_id']      =   (string)$result[$order]['user_id'];
          $find_order_next['quantity']      =   ['$gte'=> $quantityLowerRange, '$lte' => $quantityUpperRange ];
          $find_order_next['symbol']        =   $result[$order]['trades']['value']['symbol'];
          $find_order_next['status']        =   ['$nin' => ['canceled', 'new']];
          $find_order_next['parent_status'] =   ['$ne' => 'parent'];
          $find_order_next['created_date']  =   ['$gte' => $startDate, '$lte' => $endDate];

          $dataReturn3 = $db->$collection1->count($find_order_next);
          $dataReturn4 = $db->$collection2->count($find_order_next);
          
          
          // level 2
          $startDatelevel_2 = date($time, strtotime('-5 minutes'));
          $endDatelevel_2   = date($time, strtotime('+5 minutes'));

          $startDatelevel_2 = $this->mongo_db->converToMongodttime($startDatelevel_2);
          $endDatelevel_2   = $this->mongo_db->converToMongodttime($endDatelevel_2);

          $find_order_next_level_2['admin_id']      =   (string)$result[$order]['user_id'];
          $find_order_next_level_2['quantity']      =   ['$gte'=> $quantityLowerRange, '$lte' => $quantityUpperRange ];
          $find_order_next_level_2['symbol']        =   $result[$order]['trades']['value']['symbol'];
          $find_order_next_level_2['status']        =   ['$nin' => ['canceled', 'new']];
          $find_order_next_level_2['parent_status'] =   ['$ne' => 'parent'];
          $find_order_next_level_2['created_date']  =   ['$gte' => $startDatelevel_2, '$lte' => $endDatelevel_2];

          $dataReturnlevel_2 = $db->$collection1->count($find_order_next_level_2);
          $dataReturnsoldlevel_2 = $db->$collection2->count($find_order_next_level_2);

          //level 3
          $startDatelevel_3 = date($time, strtotime('-60 minutes'));
          $endDatelevel_3   = date($time, strtotime('+60 minutes'));

          $startDatelevel_3 = $this->mongo_db->converToMongodttime($startDatelevel_3);
          $endDatelevel_3   = $this->mongo_db->converToMongodttime($endDatelevel_3);

          $find_order_next_level_3['admin_id']      =   (string)$result[$order]['user_id'];
          $find_order_next_level_3['quantity']      =   ['$gte'=> $quantityLowerRange, '$lte' => $quantityUpperRange ];
          $find_order_next_level_3['symbol']        =   $result[$order]['trades']['value']['symbol'];
          $find_order_next_level_3['status']        =   ['$nin' => ['canceled', 'new']];
          $find_order_next_level_3['parent_status'] =   ['$ne' => 'parent'];
          $find_order_next_level_3['created_date']  =   ['$gte' => $startDatelevel_3, '$lte' => $endDatelevel_3];

          $dataReturnlevel_3     = $db->$collection1->count($find_order_next_level_3);
          $dataReturnSoldlevel_3 = $db->$collection2->count($find_order_next_level_3);

          if( $dataReturn3 > 0 || $dataReturn4 > 0){

            $db->user_trade_history->updateOne($updateOrder, ['$set' => ['status' => 'digie_doubt_duplicate_level_1']]);
            echo "<br>digie_doubt_level_1 order id:". (string)$updateOrder['_id'];

          }elseif($dataReturnlevel_2 > 0 || $dataReturnsoldlevel_2 > 0){

            $db->user_trade_history->updateOne($updateOrder, ['$set' => ['status' => 'digie_doubt_duplicate_level_2']]);
            echo "<br>digie_doubt_level_2 order id:". (string)$updateOrder['_id'];

          }elseif($dataReturnlevel_3 > 0 || $dataReturnSoldlevel_3 > 0){

            $db->user_trade_history->updateOne($updateOrder, ['$set' => ['status' => 'digie_doubt_duplicate_level_3']]);
            echo "<br>digie_doubt_level_3 order id:". (string)$updateOrder['_id'];
          }else{

            $db->user_trade_history->updateOne($updateOrder, ['$set' => ['status' => 'user_doubt']]);
            echo "<br>user doubt order id:". (string)$updateOrder['_id'];
          }

        }
        
      }
    }
    echo "<br>Done";
  }//end controller   

 //stepFirst Test for kraken
  public function getUnmapedTradeHistroyMapKrakenCron(){
    // $whereGetOrders['user_id'] = "5c09137bfc9aadaac61dd0ae";
    $where1['status']  =  'unmaped' ;
    $where2['status']  = ['$exists' => false];

    $whereGetOrders['$or'] = [$where1, $where2];

    $condition = ['limit' => 100];
    $db        = $this->mongo_db->customQuery();

    $res_kraken      =   $db->user_trade_history_kraken->find($whereGetOrders, $condition);
    $result_kraken   =   iterator_to_array($res_kraken);
    
    echo "<br>Count".count($result_kraken);

    $collection1 = 'buy_orders_kraken'; 
    $collection2 = 'sold_buy_orders_kraken';

    if(count($result_kraken) > 0){

      for($order = 0 ; $order < count($result_kraken); $order++){

        $updateOrder['_id'] = $this->mongo_db->mongoId((string)$result_kraken[$order]['_id']); 

        if($result_kraken[$order]['trades']['value']['ordertype'] == 'limit' || $result_kraken[$order]['trades']['value']['ordertype'] == 'stop-loss'){

          $db->user_trade_history_kraken->updateOne($updateOrder, ['$set' => ['status' => 'user_confirmed']]);
          echo "<br>user confirmed order id:". (string)$updateOrder['_id'];          
        }else{
            
          if($result_kraken[$order]['trades']['value']['type'] == 'buy'){


          $find_order['admin_id']          =   (string)$result_kraken[$order]['user_id'];
          $find_order['kraken_order_id']   =   $result_kraken[$order]['trades']['value']['ordertxid'];

          $mapBuyKraken = $db->$collection1->find($find_order);
          $mapBuyKrakenRes = iterator_to_array($mapBuyKraken);

          $mapBuyKraken2 = $db->$collection2->find($find_order);
          $mapBuyKraken2Res = iterator_to_array($mapBuyKraken2);

          if(count($mapBuyKrakenRes) > 0 || count($mapBuyKraken2Res) > 0){

            $arrayUpdate = [
              'status'   => 'mapped',
            ];

            if(count($mapBuyKrakenRes) > 0 ){

              $arrayUpdate['order_id'] =  (string)$mapBuyKrakenRes[0]['_id'];
            }else{

              $arrayUpdate['order_id'] =  (string)$mapBuyKraken2Res[0]['_id'];
            }
            $db->user_trade_history_kraken->updateOne($updateOrder, ['$set' => $arrayUpdate ]);
            echo "<br>Buy mapped order id:". (string)$updateOrder['_id'];
          }else{

            $db->user_trade_history_kraken->updateOne($updateOrder, ['$set' => ['status' => 'pending']]);
            echo "<br>Buy pending order id:". (string)$updateOrder['_id'];
          }

          }else{

            $findOrderSold['admin_id']  =   (string)$result_kraken[$order]['user_id'];;
            $findOrderSold['sell_kraken_order_id']       =   $result_kraken[$order]['trades']['value']['ordertxid'];
            $mappSoldKraken = $db->$collection2->find($findOrderSold);
            $mappSoldKrakenRes = iterator_to_array($mappSoldKraken);

            $arrayUpdate = [
              
              'status'   => 'mapped',
              'order_id' =>  (string)$mappSoldKrakenRes[0]['_id']
            ];
           

            if(count($mappSoldKrakenRes) > 0 ){

              $db->user_trade_history_kraken->updateOne($updateOrder, ['$set' => $arrayUpdate]);
              echo "<br>sell mapped order id:". (string)$updateOrder['_id'];
            }else{

              $db->user_trade_history_kraken->updateOne($updateOrder, ['$set' => ['status' => 'pending']]);
              echo "<br>sell pending order id:". (string)$updateOrder['_id'];
            }

          }
          
        }//end else if 
      }
    }
    echo "<br>Done";
  }

  // get pending make ready for scan 2nd step kraken
  public function getPendingTradeKrakenCron(){
    $whereGetOrders['status']  = 'pending';
    // $whereGetOrders['user_id'] = "5c09137bfc9aadaac61dd0ae";

    $condition = ['limit' => 100];
    $db = $this->mongo_db->customQuery();

    $res      =   $db->user_trade_history_kraken->find($whereGetOrders,  $condition);
    $result   =   iterator_to_array($res);

    echo "<br> order get Count: ".count($result);

    if(count($result) > 0){

      for($order = 0 ; $order < count($result); $order++){

        $updateOrder['_id'] = $this->mongo_db->mongoId((string)$result[$order]['_id']); 

        $db->user_trade_history_kraken->updateOne($updateOrder, ['$set' => ['status' => 'ready_for_scan']]);
        echo "<br>ready for scanning order id:". (string)$updateOrder['_id'];
        
      }//end loop
    }//end if
    echo "<br>Done all";
  }

  //3rd step kraken
  public function getReadyForScanTradeKrakenCron(){
    // $whereGetOrders['user_id'] = "5c09137bfc9aadaac61dd0ae";
    $whereGetOrders['status']  = 'ready_for_scan';

    $condition = ['limit' => 100];
    $db        = $this->mongo_db->customQuery();

    $res      =   $db->user_trade_history_kraken->find($whereGetOrders, $condition);
    $result   =   iterator_to_array($res);

    $collection1 = 'buy_orders_kraken'; 
    $collection2 = 'sold_buy_orders_kraken';

    echo "<br>count orders: ".count($result);

    if(count($result) > 0){

      for($order = 0 ; $order < count($result); $order++){

        $updateOrder['_id'] = $this->mongo_db->mongoId((string)$result[$order]['_id']); 
        
        $time = date("d-m-Y H:i:s", strtotime($result[$order]['trades']['value']['time']));

        $start_Date = date($time, strtotime('-2 minutes'));
        $end_Date   = date($time, strtotime('+2 minutes'));

        $start_Date = $this->mongo_db->converToMongodttime($start_Date);
        $end_Date   = $this->mongo_db->converToMongodttime($end_Date);

        $quantityRangeLower = $result[$order]['trades']['value']['qty']  - ((1/100)* $result[$order]['trades']['value']['qty']);
        $quantityRangeUpper = $result[$order]['trades']['value']['qty']  + ((1/100)* $result[$order]['trades']['value']['qty']);

        $findOrder['admin_id']          =   (string)$result[$order]['user_id'];
        $findOrder['symbol']            =   $result[$order]['trades']['value']['pair'];
        $findOrder['status']            =   ['$nin' => ['canceled', 'new']];
        $findOrder['parent_status']     =   ['$ne' => 'parent'];
        $findOrder['application_mode']  =   'live';  
        $findOrder['created_date']      =   ['$gte' => $start_Date, '$lte' => $end_Date];
        $findOrder['quantity']          =   ['$gte'=> $quantityRangeLower, '$lte' => $quantityRangeUpper ];

        $record1    =   $db->$collection2->find($findOrder);
        $record1Res =   iterator_to_array($record1);
        $record     =   $db->$collection1->find($findOrder);
        $recordRes  =   iterator_to_array($record);

        if(count($record1Res) > 0 || count($recordRes) > 0){

          $updateArray = [
            'status' => 'duplicate'
          ];
          if(count($record1Res) > 0){
            
            $updateArray['order_id'] = (string)$record1Res[0]['_id'];
          }else{

            $updateArray['order_id'] = (string)$recordRes[0]['_id'];
          }

          $db->user_trade_history_kraken->updateOne($updateOrder, ['$set' => $updateArray]);
          echo "<br>duplicate order id:". (string)$updateOrder['_id'];
        }else{

          // level 1
          $time = date("d-m-Y H:i:s", strtotime($result[$order]['trades']['value']['time']));
          $startDate = date($time, strtotime('-2 minutes'));
          $endDate   = date($time, strtotime('+2 minutes'));

          $startDate = $this->mongo_db->converToMongodttime($startDate);
          $endDate   = $this->mongo_db->converToMongodttime($endDate);

          $quantityLowerRange = $result[$order]['trades']['value']['qty']  - ((1/100)* $result[$order]['trades']['value']['qty']);
          $quantityUpperRange = $result[$order]['trades']['value']['qty']  + ((1/100)* $result[$order]['trades']['value']['qty']);

          $find_order_next['admin_id']      =   (string)$result[$order]['user_id'];
          $find_order_next['quantity']      =   ['$gte'=> $quantityLowerRange, '$lte' => $quantityUpperRange ];
          $find_order_next['symbol']        =   $result[$order]['trades']['value']['symbol'];
          $find_order_next['status']        =   ['$nin' => ['canceled', 'new']];
          $find_order_next['parent_status'] =   ['$ne' => 'parent'];
          $find_order_next['created_date']  =   ['$gte' => $startDate, '$lte' => $endDate];

          $dataReturn3 = $db->$collection1->count($find_order_next);
          $dataReturn4 = $db->$collection2->count($find_order_next);
          
          // level 2
          $startDatelevel_2 = date($time, strtotime('-5 minutes'));
          $endDatelevel_2   = date($time, strtotime('+5 minutes'));

          $startDatelevel_2 = $this->mongo_db->converToMongodttime($startDatelevel_2);
          $endDatelevel_2   = $this->mongo_db->converToMongodttime($endDatelevel_2);

          $find_order_next_level_2['admin_id']      =   (string)$result[$order]['user_id'];
          $find_order_next_level_2['quantity']      =   ['$gte'=> $quantityLowerRange, '$lte' => $quantityUpperRange ];
          $find_order_next_level_2['symbol']        =   $result[$order]['trades']['value']['symbol'];
          $find_order_next_level_2['status']        =   ['$nin' => ['canceled', 'new']];
          $find_order_next_level_2['parent_status'] =   ['$ne' => 'parent'];
          $find_order_next_level_2['created_date']  =   ['$gte' => $startDatelevel_2, '$lte' => $endDatelevel_2];

          $dataReturnlevel_2 = $db->$collection1->count($find_order_next_level_2);
          $dataReturnsoldlevel_2 = $db->$collection2->count($find_order_next_level_2);

          //level 3
          $startDatelevel_3 = date($time, strtotime('-60 minutes'));
          $endDatelevel_3   = date($time, strtotime('+60 minutes'));

          $startDatelevel_3 = $this->mongo_db->converToMongodttime($startDatelevel_3);
          $endDatelevel_3   = $this->mongo_db->converToMongodttime($endDatelevel_3);

          $find_order_next_level_3['admin_id']      =   (string)$result[$order]['user_id'];
          $find_order_next_level_3['quantity']      =   ['$gte'=> $quantityLowerRange, '$lte' => $quantityUpperRange ];
          $find_order_next_level_3['symbol']        =   $result[$order]['trades']['value']['symbol'];
          $find_order_next_level_3['status']        =   ['$nin' => ['canceled', 'new']];
          $find_order_next_level_3['parent_status'] =   ['$ne' => 'parent'];
          $find_order_next_level_3['created_date']  =   ['$gte' => $startDatelevel_3, '$lte' => $endDatelevel_3];

          $dataReturnlevel_3     = $db->$collection1->count($find_order_next_level_3);
          $dataReturnSoldlevel_3 = $db->$collection2->count($find_order_next_level_3);

          if( $dataReturn3 > 0 || $dataReturn4 > 0){

            $db->user_trade_history_kraken->updateOne($updateOrder, ['$set' => ['status' => 'digie_doubt_duplicate_level_1']]);
            echo "<br>digie_doubt_level_1 order id:". (string)$updateOrder['_id'];

          }elseif($dataReturnlevel_2 > 0 || $dataReturnsoldlevel_2 > 0){

            $db->user_trade_history_kraken->updateOne($updateOrder, ['$set' => ['status' => 'digie_doubt_duplicate_level_2']]);
            echo "<br>digie_doubt_level_2 order id:". (string)$updateOrder['_id'];

          }elseif($dataReturnlevel_3 > 0 || $dataReturnSoldlevel_3 > 0){

            $db->user_trade_history_kraken->updateOne($updateOrder, ['$set' => ['status' => 'digie_doubt_duplicate_level_3']]);
            echo "<br>digie_doubt_level_3 order id:". (string)$updateOrder['_id'];
          }else{

            $db->user_trade_history_kraken->updateOne($updateOrder, ['$set' => ['status' => 'user_doubt']]);
            echo "<br>user doubt order id:". (string)$updateOrder['_id'];
          }
        }
      }
    }
    echo "<br>Done";
  }//end controller   

  public function showDuplicationTradeHistoryDetails(){
      $this->mod_login->verify_is_admin_login();
      $coin_array_all = $this->mod_coins->get_all_coins();
      $db = $this->mongo_db->customQuery();

      if($this->input->post()){
        $filersData['filters'] =  $this->input->post();
        $this->session->set_userdata($filersData); 
      }
      $sessionData = $this->session->userdata('filters');
      $colledtionGetDuplicates = 'duplicate_orders_'.$sessionData['exchange'];
      if(!empty($sessionData['username'])){
        $searchOrders['username'] = $sessionData['username'];
      }else{
        $searchOrders['username'] = ['$exists' => true];
      }

      if(!empty($sessionData['order']) && $sessionData['order'] != 'both'){
        $searchOrders['type'] = $sessionData['order'];
      }

      if(!empty($sessionData['orderTypes']) && $sessionData['orderTypes'] != 'all'){

        $searchOrders['OrderType'] = $sessionData['orderTypes'];
      }

      if(!empty($sessionData['start_date'])  && !empty($sessionData['end_date'])){
        $startTime =  $this->mongo_db->converToMongodttime($sessionData['start_date']);    
        $endTime  =  $this->mongo_db->converToMongodttime($sessionData['end_date']);  

        $searchOrders['time'] = ['$gte' => $startTime, '$lte' => $endTime];
      }

      if(!empty($sessionData['status']) && $sessionData['status'] != 'all'){
        $searchOrders['status'] = $sessionData['status'];
      }


      if(!empty($sessionData['filter_by_coin'])) {
        $searchOrders['pair']['$in'] = $sessionData['filter_by_coin'];
      }

      $responseCount = $db->$colledtionGetDuplicates->count($searchOrders);
      $config['base_url']   = base_url() .'admin/TradeHistory/showDuplicationTradeHistoryDetails';
      $config['total_rows'] = $responseCount;
  
      $config['per_page'] = 100;
      $config['num_links'] = 3;
      $config['use_page_numbers'] = TRUE;
      $config['uri_segment'] = 4;
      $config['reuse_query_string'] = TRUE;
  
      $config['next_link'] = '&raquo;';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';
  
      $config['prev_link'] = '&laquo;';
  
      $config['prev_tag_open'] = '<li>';
      $config['prev_tag_close'] = '</li>';
  
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';

      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
  
      $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
      $config['cur_tag_close'] = '</b></a></li>';
  
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';
  
      $this->pagination->initialize($config);
      $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
      
      if($page !=0) 
      {
          $page = ($page-1) * $config['per_page'];
      }
      $finalData["links"] = $this->pagination->create_links();
      $query =
      [
          ['$match' => $searchOrders],  
          ['$sort'  => ['time' => 1]],
          ['$skip'  => $page],
          ['$limit' => $config['per_page']],
      ];
      $response = $db->$colledtionGetDuplicates->aggregate($query);   
      $responseOrderReturn = iterator_to_array($response);
      $finalData['total']  = $responseCount;
      $finalData['orders'] = $responseOrderReturn;
      $finalData['coins']  = $coin_array_all;

      $this->stencil->paint('admin/trade_history/duplicate_orders_view', $finalData);

  }//end function

  public function get_all_usernames_ajax(){
      $this->mongo_db->sort(array('_id' => -1));
      $get_users = $this->mongo_db->get('users');
      $users_arr = iterator_to_array($get_users);
      $user_name_array = array_column($users_arr, 'username');
      unset($users_arr, $get_users);
      echo json_encode($user_name_array);
      exit;
  }
}