              <?php
              defined('BASEPATH') OR exit('No direct script access allowed');
              class Users_list extends CI_Controller {
                public function __construct() {
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
                  $this->load->model('admin/mod_calculation');

                  $this->load->helper('new_common_helper');
                }   

                public function monthly_list(){
                  $coin_array_all = $this->mod_coins->get_all_coins();
                  $month = date('m');
                  $year = date('Y');
                  $collection_name = 'users_calculation_binance_'.$year;
                  $current_date_time =  date('Y-m-d H:i:s');
                  $current_time_date =  $this->mongo_db->converToMongodttime($current_date_time);

                  $next_date =  date('Y-m-d H:i:s', strtotime('-10 days'));
                  // $next_date =  date('Y-m-d H:i:s', strtotime('-30 minutes'));
                  $pre_time_date =  $this->mongo_db->converToMongodttime($next_date);

                  $start_date = date('Y-m-01 00:00:00');
                  $start_date_time =  $this->mongo_db->converToMongodttime($start_date);

                  $end_date = date('Y-m-d 23:59:59');
                  $end_date_time = $this->mongo_db->converToMongodttime($end_date); 
                  
                  $condition = array('sort'=>array('created_date' =>-1));
                  $condition = array('limit'=>1);
                  $where['is_modified'] = array('$lte'=>$pre_time_date);
                  // $where['is_modified'] = array('$exists'=>false);
                  $where['application_mode'] = 'both';

                  $custom = $this->mongo_db->customQuery(); 
                  $user_return_collectio = $custom->users->find($where, $condition);
                  $user_return_detail = iterator_to_array($user_return_collectio);
                  
                  if(count($user_return_detail)>0){
                    foreach($user_return_detail as $user){    
                      if(!isset($user['count'])){
                        $user['count'] =0;
                      }
                      echo "<br>coin =". $coin_array_all[$user['count']]['symbol']; 
                      echo"<br>id =".$user['_id'];            
                      echo"<br>username = ".$user['username'];

                      $open_lth['admin_id'] = (string)$user['_id'];
                      $open_lth['application_mode'] = 'live';
                      $open_lth['order_level'] = array('$ne'=>'level_15');
                      $open_lth['status']= array('$in'=>array('LTH','FILLED'));
                      $open_lth['symbol'] =  $coin_array_all[$user['count']]['symbol'];  
                      $open_lth['created_date'] = array('$gte'=>$start_date_time, '$lte'=>$end_date_time );
                      $retun_orders = $custom->buy_orders->find($open_lth);
                      $order_return_response = iterator_to_array($retun_orders);
                      echo"<br> open/lth count = ".count($order_return_response);

                      $sold['admin_id'] = (string)$user['_id'];
                      $sold['application_mode'] = 'live';
                      $sold['order_level'] = array('$ne'=>'level_15');
                      $sold['is_sell_order']= 'sold';
                      $sold['symbol'] =  $coin_array_all[$user['count']]['symbol']; 
                      $sold['created_date'] = array('$gte'=>$start_date_time, '$lte'=>$end_date_time );
                      $order_return = $custom->sold_buy_orders->find($sold);
                      $order_return_sold = iterator_to_array($order_return);
                      echo"<br> sold count = ".count($order_return_sold);

                      $investment = 0;
                      $buy_commision_Qty  = 0;
                      $buy_commision_BNB  = 0;
                      if($order_return_response > 0){
                        foreach($order_return_response as $value_1){
                          $investment += $value_1['purchased_price']  * $value_1['quantity'];
                          $commission_array_buy = $value_1['buy_fraction_filled_order_arr'];
                            
                          foreach($commission_array_buy as $comm){
                            if($comm['commissionAsset'] =='BNB'){
                              $buy_commision_BNB +=(float) $comm['commission'];
                              echo "<br>buy commission BNB = ".$buy_commision_BNB;
                            }else{
                              $buy_commision_Qty += (float) $comm['commission'];
                              echo "<br>buy Commission Qty =".$buy_commision_Qty;
                            }
                          }//end loop   
                        }//outer loop
                      }//end if
                        $gain_total = 0;
                        $sell_commision_BNB  = 0;  
                        $sell_commision_Qty = 0;
                        if($order_return_sold > 0){
                          foreach($order_return_sold as $value_2){
                            $commission_array_buy = $value_2['buy_fraction_filled_order_arr'];
                            $sell_commission_sold_array = $value_2['sell_fraction_filled_order_arr'];
                            if(!isset($value_2['is_manual_sold']) && !isset($value_2['csl_sold'])){
                              $investment += $value_2['purchased_price']  * $value_2['quantity'];
                              $gain_total += $value_2['sell_price'] * $value_2['quantity'];
                              foreach($commission_array_buy as $comm){
                                if($comm['commissionAsset'] =='BNB'){
                                  $buy_commision_BNB +=(float) $comm['commission'];
                                  echo "<br>buy commission BNB = ".$buy_commision_BNB;
                                }else{
                                  $buy_commision_Qty += (float) $comm['commission'];
                                  echo "<br>buy Commission Qty =".$buy_commision_Qty;
                                }
                              } // commission_array_buy end loop  
                              foreach($sell_commission_sold_array as $comm_sold){
                                if($comm_sold['commissionAsset'] =='BNB'){
                                  $sell_commision_BNB +=(float) $comm_sold['commission'];
                                  echo "<br>sell commission BNB = ".$buy_commision_BNB;
                                }else{
                                  $sell_commision_Qty += (float) $comm_sold['commission'];
                                  echo "<br>Sell Commission Qty =".$sell_commision_Qty;
                                }
                              }  // end sell_commission_sold_array loop 
                            } //end if  
                          }//end foreach
                        }//end if

                          

                      $price_search_2['coin'] = $coin_array_all[$user['count']]['symbol'];
                      $this->mongo_db->where($price_search_2);
                      $priceses_2 = $this->mongo_db->get('market_prices');
                      $final_prices_2 = iterator_to_array($priceses_2);

                      $price_search_1['coin'] ='BTCUSDT';
                      $this->mongo_db->where($price_search_1);
                      $priceses_1 = $this->mongo_db->get('market_prices');
                      $final_prices_1 = iterator_to_array($priceses_1);
                      $in_array =['BTCUSDT', 'XRPUSDT', 'NEOUSDT', 'QTUMUSDT', 'LTCUSDT'];
                      if($buy_commision_Qty > 0 && in_array($coin_array_all[$user['count']]['symbol'], $in_array)){
                        $buy_commision_Qty = (1/$final_prices_1[0]['price']) * $buy_commision_Qty;
                        echo"<br>buy comsion USDT res =".$buy_commision_Qty;
                        echo"<br>respected coin value QTY USDT= ".$final_prices_1[0]['price'];
                        echo"<br>coin respected =".$coin_array_all[$user['count']]['symbol'];
                      }
              
                      if($sell_commision_Qty > 0 && in_array($coin_array_all[$user['count']]['symbol'], $in_array)){
                        $sell_commision_Qty = (1/$final_prices_1[0]['price']) * $sell_commision_Qty;
                        echo"<br>sell comsion btc res =".$sell_commision_Qty;
                        echo"<br>respected coin value QTY USDT= ".$final_prices_1[0]['price'];
                        echo"<br>coin respected =".$coin_array_all[$user['count']]['symbol'];
                      }
                          
                      $in_arr = ['XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC'];
                      if($buy_commision_Qty > 0 && in_array($coin_array_all[$user['count']]['symbol'], $in_arr)){  
                        echo"<br>Qty sum =".$buy_commision_Qty;
                        $buy_commision_Qty = $final_prices_2[0]['price']*$buy_commision_Qty;
                        echo"<br>buy comsion btc res =".$buy_commision_Qty;
                        echo"<br>respected coin value".$final_prices_2[0]['price'];
                        echo"<br>coin respected =".$coin_array_all[$user['count']]['symbol'];
                      }
                
                      if($sell_commision_Qty > 0 && in_array($coin_array_all[$user['count']]['symbol'], $in_arr)){
                        $sell_commision_Qty = $final_prices_2[0]['price']*$sell_commision_Qty;
                        echo"<br>btc res sell comision =".$sell_commision_Qty;
                        echo"<br>respected coin value".$final_prices_2[0]['price'];
                        echo"<br>coin respected =".$coin_array_all[$user['count']]['symbol'];
                      }

                      $amount = 0;
                        if(in_array($coin_array_all[$user['count']]['symbol'], $in_arr) && $investment > 0 && count($order_return_sold) > 0 && count($order_return_response) == 0){
                          $amount = ($gain_total - $investment -$buy_commision_Qty - $sell_commision_Qty) * $final_prices_1[0]['price'];
                          echo"<br> Amount = ".$amount;
                          echo "<br> USDT current price = ".$final_prices_1[0]['price'];
                          echo "<br> BTC price = ".$investment;
                        }elseif(in_array($coin_array_all[$user['count']]['symbol'], $in_array) &&  $investment > 0 && count($order_return_sold) > 0 && count($order_return_response) == 0){   
                          $amount = $gain_total - $investment -$buy_commision_Qty - $sell_commision_Qty;
                        } 
                              
                      $array_update = array(
                        'investment' => $investment,
                        'coin' => $coin_array_all[$user['count']]['symbol'],
                        'open_lth' => count($order_return_response),
                        'sold' => count($order_return_sold),
                        'admin_id' => $user['_id'],
                        'username' => $user['username'],
                        'count'    => '0',
                        'created_date' =>$user['created_date'],
                        'last_modified' => $current_time_date,
                        'buy_comission_bnb' => $buy_commision_BNB,
                        'buy_comission_qty' => $buy_commision_Qty,
                        'profit_amount' => $amount,
                        'month' => $month
                      );
                      if(count($order_return_sold) > 0 || count($order_return_response) > 0){ 
                        if(count($order_return_sold) >= count($order_return_response)){
                          echo"<br>IF sold count =".count($order_return_sold)." open count = ".count($order_return_response)." sold >= open/lth";
                          $array_update['level'] = array_unique(array_column($order_return_sold, 'order_level'));
                        }else{
                          echo"<br>ELSE open count = ".count($order_return_response)."sold count =".count($order_return_sold)."sold <= open lth";
                          $array_update['level'] = array_unique(array_column($order_return_response, 'order_level'));
                        }
                      }
                      $where_balance['user_id'] = (string)$user['_id'];
                      $where_balance['coin_symbol']['$nin'] = array('LTCUSDT','ETCBTC','XEMBTC', 'ZENBTC','BTCUSDT','POEBTC', 'XLMBTC','NEOUSDT','TRXBTC', 'NEOBTC','XRPUSDT','QTUMBTC','NCASHBTC','XRPBTC', 'QTUMUSDT', 'EOSBTC', 'BNBBTC','ETHBTC','NCASH','LINKBTC','XMRBTC', 'DASHBTC', 'ADABTC'); 
                      $this->mongo_db->where($where_balance);
                      $data = $this->mongo_db->get('user_wallet');
                      $balance_res = iterator_to_array($data);
                      if(count($order_return_sold) > 0 || count($order_return_response) > 0){
                        foreach($balance_res as $value_coin ){
                          if($value_coin['coin_symbol'] =='BTC'){
                            $array_update['btc_balance'] = $value_coin['coin_balance'];
                            echo"<br>balance = ".$value_coin['coin_balance'];
                          }elseif($value_coin['coin_symbol'] == 'USDT'){
                            $array_update['usdt_balance'] = $value_coin['coin_balance'];
                            echo"<br>usdt balance = ".$value_coin['coin_balance'];
                          }
                          if($coin_array_all[$user['count']]['symbol'] =='ZENBTC' && $value_coin['coin_symbol'] =='ZEN'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='EOSBTC' && $value_coin['coin_symbol'] =='EOS'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='ETCBTC' && $value_coin['coin_symbol'] =='ETC'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='ETHBTC' && $value_coin['coin_symbol'] =='ETH'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='QTUMBTC' && $value_coin['coin_symbol'] =='QTUM'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='TRXBTC' && $value_coin['coin_symbol'] =='TRX'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='XEMBTC' && $value_coin['coin_symbol'] =='XEM'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='XLMBTC' && $value_coin['coin_symbol'] =='XLM'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='XRPBTC' && $value_coin['coin_symbol'] =='XRP'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='NEOBTC' && $value_coin['coin_symbol'] =='NEO'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='LINKBTC' && $value_coin['coin_symbol'] =='LINK'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='POEBTC' && $value_coin['coin_symbol'] =='POE'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='XMRBTC' && $value_coin['coin_symbol'] =='XMR'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='LTCUSDT' && $value_coin['coin_symbol'] =='LTC'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='DASHBTC' && $value_coin['coin_symbol'] =='DASH'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='ADABTC' && $value_coin['coin_symbol'] =='ADA'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='NEOUSDT' && $value_coin['coin_symbol'] =='NEO'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='QTUMUSDT' && $value_coin['coin_symbol'] =='QTUM'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count']]['symbol'] =='XRPUSDT' && $value_coin['coin_symbol'] =='XRP'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }
                        }
                      }//end balance loop
                    


                      if(count($order_return_sold) > 0 || count($order_return_response) > 0){
                        $where_parent['parent_status'] = 'parent';
                        $where_parent['pause_status'] = 'play';
                        $where_parent['application_mode'] ='live';
                        $where_parent['exchange'] = 'binance';
                        $where_parent['status']['$in'] = array('new','takingOrder');
                        $where_parent['admin_id'] = (string)$user['_id'];

                        $this->mongo_db->where($where_parent);
                        $parents = $this->mongo_db->get('buy_orders');
                        $parent_count = iterator_to_array($parents);
                        $array_update['Active_Parents'] = count($parent_count);
                        echo"<br>Active parents are =".count($parent_count);
                      }

                      if(count($order_return_sold) > 0 && count($order_return_response) == 0){
                        $array_update['sell_comission_bnb'] = $sell_commision_BNB;
                        $array_update['sell_comission_qty'] = $sell_commision_Qty;
                      }

                      if( count($order_return_sold)>0 && count($order_return_response) == 0 ){
                        $array_update['gain_total'] = $gain_total;
                        $array_update['profit'] = $gain_total - $investment -$buy_commision_Qty - $sell_commision_Qty ;
                      }
                      echo "<pre>";
                      print_r($array_update);
                      echo "<br>total investment = ".$investment;
                      echo "<br>total gain = ".$gain_total;

                      $update_where['username'] = $user['username'];
                      $update_where['admin_id'] = (string)$user['_id'];
                      $update_where['coin'] = $coin_array_all[$user['count']]['symbol']; 
                      if(count($order_return_sold) >0 || count($order_return_response)>0){
                        echo"<br>Updated Sucessfully";
                        $custom = $this->mongo_db->customQuery(); 
                        $upsert['upsert'] = true;
                        $custom->$collection_name->updateOne($update_where, ['$set'=> $array_update], $upsert);
                      }//end count check
                      if($coin_array_all[$user['count']+1]['symbol'] =='' || !isset($coin_array_all[$user['count']+1]['symbol'])){
                        $array_update_in_user_colection['is_modified'] = $current_time_date;
                        $array_update_in_user_colection['count'] = '0';
                      }
                      else{
                        $array_update_in_user_colection['count'] = $user['count']+1;
                      }
                      echo"<pre>user colection update array";
                      print_r($array_update_in_user_colection);
                      $search_find['application_mode'] = 'both';
                      $search_find['_id']  = $user['_id'];
                      $search_find['username'] = $user['username'];

                      $this->mongo_db->where($search_find);
                      $this->mongo_db->set($array_update_in_user_colection);
                      $this->mongo_db->update('users');

                    }//end user cllection foreach
                    echo"<br>Total Open/LTH =".count($order_return_response);
                    echo"<br>Total Sold orders =".count($order_return_sold);
                  }//end first check
                }//end function

                public function monthly_list_kraken(){
                  $coin_array_all = $this->mod_coins->get_all_coins_kraken();
                  $month = date('05');
                  $year = date('Y');
                  $collection_name = 'users_calculation_kraken_'.$year;
                  $current_date_time =  date('Y-m-d H:i:s');
                  $current_time_date =  $this->mongo_db->converToMongodttime($current_date_time);

                  $next_date =  date('Y-m-d H:i:s', strtotime('-10 days'));
                  // $next_date =  date('Y-m-d H:i:s', strtotime('-30 minutes'));
                  $pre_time_date =  $this->mongo_db->converToMongodttime($next_date);

                  $start_date = date('Y-05-01 00:00:00');
                  $start_date_time =  $this->mongo_db->converToMongodttime($start_date);

                  $end_date = date('Y-05-31 23:59:59');
                  $end_date_time = $this->mongo_db->converToMongodttime($end_date); 
                  
                  $condition = array('sort'=>array('created_date' =>-1));
                  $condition = array('limit'=>1);
                  $where['is_modified_kraken'] = array('$lte'=>$pre_time_date);
                  // $where['is_modified_kraken'] = array('$exists'=>false);
                  $where['application_mode'] = 'both';

                  $custom = $this->mongo_db->customQuery(); 
                  $user_return_collectio = $custom->users->find($where, $condition);
                  $user_return_detail = iterator_to_array($user_return_collectio);
                  if(count($user_return_detail)>0){
                    foreach($user_return_detail as $user){    
                      if(!isset($user['count_kraken'])){
                        $user['count_kraken'] =0;
                      }
                      echo "<br>coin =". $coin_array_all[$user['count_kraken']]['symbol']; 
                      echo"<br>id =".$user['_id'];            
                      echo"<br>username = ".$user['username'];

                      $open_lth['admin_id'] = (string)$user['_id'];
                      $open_lth['application_mode'] = 'live';
                      $open_lth['order_level'] = array('$ne'=>'level_15');
                      $open_lth['status']= array('$in'=>array('LTH','FILLED'));
                      $open_lth['symbol'] =  $coin_array_all[$user['count_kraken']]['symbol'];  
                      $open_lth['created_date'] = array('$gte'=>$start_date_time, '$lte'=>$end_date_time );
                      $retun_orders = $custom->buy_orders_kraken->find($open_lth);
                      $order_return_response = iterator_to_array($retun_orders);
                      echo"<br> open/lth count = ".count($order_return_response);

                      $sold['admin_id'] = (string)$user['_id'];
                      $sold['application_mode'] = 'live';
                      $sold['order_level'] = array('$ne'=>'level_15');
                      $sold['is_sell_order']= 'sold';
                      $sold['symbol'] =  $coin_array_all[$user['count_kraken']]['symbol']; 
                      $sold['created_date'] = array('$gte'=>$start_date_time, '$lte'=>$end_date_time );
                      $order_return = $custom->sold_buy_orders_kraken->find($sold);
                      $order_return_sold = iterator_to_array($order_return);
                      echo"<br> sold count = ".count($order_return_sold);

                      $investment = 0;
                      $buy_commision_Qty  = 0;
                      $buy_commision_BNB  = 0;
                      if($order_return_response > 0){
                        foreach($order_return_response as $value_1){
                          $investment += $value_1['purchased_price']  * $value_1['quantity'];
                          $commission_array_buy = $value_1['buy_fraction_filled_order_arr'];
                            
                          foreach($commission_array_buy as $comm){
                            if($comm['commissionAsset'] =='BNB'){
                              $buy_commision_BNB +=(float) $comm['commission'];
                              echo "<br>buy commission BNB = ".$buy_commision_BNB;
                            }else{
                              $buy_commision_Qty += (float) $comm['commission'];
                              echo "<br>buy Commission Qty =".$buy_commision_Qty;
                            }
                          }//end loop   
                        }//outer loop
                      }//end if
                        $gain_total = 0;
                        $sell_commision_BNB  = 0;  
                        $sell_commision_Qty = 0;
                        if($order_return_sold > 0){
                          foreach($order_return_sold as $value_2){
                            $commission_array_buy = $value_2['buy_fraction_filled_order_arr'];
                            $sell_commission_sold_array = $value_2['sell_fraction_filled_order_arr'];
                            if(!isset($value_2['is_manual_sold']) && !isset($value_2['csl_sold'])){
                              $investment += $value_2['purchased_price']  * $value_2['quantity'];
                              $gain_total += $value_2['sell_price'] * $value_2['quantity'];
                              foreach($commission_array_buy as $comm){
                                if($comm['commissionAsset'] =='BNB'){
                                  $buy_commision_BNB +=(float) $comm['commission'];
                                  echo "<br>buy commission BNB = ".$buy_commision_BNB;
                                }else{
                                  $buy_commision_Qty += (float) $comm['commission'];
                                  echo "<br>buy Commission Qty =".$buy_commision_Qty;
                                }
                              } // commission_array_buy end loop  
                              foreach($sell_commission_sold_array as $comm_sold){
                                if($comm_sold['commissionAsset'] =='BNB'){
                                  $sell_commision_BNB +=(float) $comm_sold['commission'];
                                  echo "<br>sell commission BNB = ".$buy_commision_BNB;
                                }else{
                                  $sell_commision_Qty += (float) $comm_sold['commission'];
                                  echo "<br>Sell Commission Qty =".$sell_commision_Qty;
                                }
                              }  // end sell_commission_sold_array loop 
                            } //end if  
                          }//end foreach
                        }//end if

                      $price_search_2['coin'] = $coin_array_all[$user['count_kraken']]['symbol'];
                      $this->mongo_db->where($price_search_2);
                      $priceses_2 = $this->mongo_db->get('market_prices_kraken');
                      $final_prices_2 = iterator_to_array($priceses_2);
                    
                      $price_search_1['coin'] ='BTCUSDT';
                      $this->mongo_db->where($price_search_1);
                      $priceses_1 = $this->mongo_db->get('market_prices_kraken');
                      $final_prices_1 = iterator_to_array($priceses_1);
                      $in_array =['BTCUSDT', 'XRPUSDT', 'EOSUSDT', 'LTCUSDT'];
                      if($buy_commision_Qty > 0 && in_array($coin_array_all[$user['count_kraken']]['symbol'], $in_array)){
                        $buy_commision_Qty = (1/$final_prices_1[0]['price']) * $buy_commision_Qty;
                        echo"<br>buy comsion USDT res =".$buy_commision_Qty;
                        echo"<br>respected coin value QTY USDT= ".$final_prices_1[0]['price'];
                        echo"<br>coin respected =".$coin_array_all[$user['count_kraken']]['symbol'];
                      }
              
                      if($sell_commision_Qty > 0 && in_array($coin_array_all[$user['count_kraken']]['symbol'], $in_array)){
                        $sell_commision_Qty = (1/$final_prices_1[0]['price']) * $sell_commision_Qty;
                        echo"<br>sell comsion btc res =".$sell_commision_Qty;
                        echo"<br>respected coin value QTY USDT= ".$final_prices_1[0]['price'];
                        echo"<br>coin respected =".$coin_array_all[$user['count_kraken']]['symbol'];
                      }
                      $in_arr = ['XRPBTC','LINKBTC','XMRBTC','XLMBTC','ETHBTC', 'ADABTC', 'QTUMBTC', 'TRXBTC', 'EOSBTC',  'ETCBTC'];
                      if($buy_commision_Qty > 0 && in_array($coin_array_all[$user['count_kraken']]['symbol'], $in_arr)){  
                        echo"<br>Qty sum =".$buy_commision_Qty;
                        $buy_commision_Qty = $final_prices_2[0]['price']*$buy_commision_Qty;
                        echo"<br>buy comsion btc res =".$buy_commision_Qty;
                        echo"<br>respected coin value".$final_prices_2[0]['price'];
                        echo"<br>coin respected =".$coin_array_all[$user['count_kraken']]['symbol'];
                      }
                
                      if($sell_commision_Qty > 0 && in_array($coin_array_all[$user['count_kraken']]['symbol'], $in_arr)){
                        $sell_commision_Qty = $final_prices_2[0]['price']*$sell_commision_Qty;
                        echo"<br>btc res sell comision =".$sell_commision_Qty;
                        echo"<br>respected coin value".$final_prices_2[0]['price'];
                        echo"<br>coin respected =".$coin_array_all[$user['count_kraken']]['symbol'];
                      }

                      $amount = 0;
                        if(in_array($coin_array_all[$user['count_kraken']]['symbol'], $in_arr) && $investment > 0 && count($order_return_sold) > 0 && count($order_return_response) == 0){
                          $amount = ($gain_total - $investment -$buy_commision_Qty - $sell_commision_Qty) * $final_prices_1[0]['price'];
                          echo"<br> Amount = ".$amount;
                          echo "<br> USDT current price = ".$final_prices_1[0]['price'];
                          echo "<br> BTC price = ".$investment;
                        }elseif(in_array($coin_array_all[$user['count_kraken']]['symbol'], $in_array) &&  $investment > 0 && count($order_return_sold) > 0 && count($order_return_response) == 0){   
                          $amount = $gain_total - $investment -$buy_commision_Qty - $sell_commision_Qty;
                        } 
                              
                      $array_update = array(
                        'investment' => $investment,
                        'coin' => $coin_array_all[$user['count_kraken']]['symbol'],
                        'open_lth' => count($order_return_response),
                        'sold' => count($order_return_sold),
                        'admin_id' => $user['_id'],
                        'username' => $user['username'],
                        'count'    => '0',
                        'created_date' =>$user['created_date'],
                        'last_modified' => $current_time_date,
                        'buy_comission_bnb' => $buy_commision_BNB,
                        'buy_comission_qty' => $buy_commision_Qty,
                        'profit_amount' => $amount,
                        'month' => $month
                      );
                      if(count($order_return_sold) > 0 || count($order_return_response) > 0){ 
                        if(count($order_return_sold) >= count($order_return_response)){
                          echo"<br>IF sold count =".count($order_return_sold)." open count = ".count($order_return_response)." sold >= open/lth";
                          $array_update['level'] = array_unique(array_column($order_return_sold, 'order_level'));
                        }else{
                          echo"<br>ELSE open count = ".count($order_return_response)."sold count =".count($order_return_sold)."sold <= open lth";
                          $array_update['level'] = array_unique(array_column($order_return_response, 'order_level'));
                        }
                      }
                      $where_balance['user_id'] = (string)$user['_id'];
                      $where_balance['coin_symbol']['$nin'] = array('BTCUSDT', 'XRPBTC', 'LINKBTC', 'XLMBTC', 'ETHBTC', 'XMRBTC', 'ADABTC', 'QTUMBTC', 'TRXBTC', 'XRPUSDT', 'LTCUSDT', 'EOSBTC', 'EOSUSDT', 'ETCBTC'); 
                      $this->mongo_db->where($where_balance);
                      $data = $this->mongo_db->get('user_wallet');
                      $balance_res = iterator_to_array($data);
                      if(count($order_return_sold) > 0 || count($order_return_response) > 0){
                        foreach($balance_res as $value_coin ){
                          if($value_coin['coin_symbol'] =='BTC'){
                            $array_update['btc_balance'] = $value_coin['coin_balance'];
                            echo"<br>balance = ".$value_coin['coin_balance'];
                          }elseif($value_coin['coin_symbol'] == 'USDT'){
                            $array_update['usdt_balance'] = $value_coin['coin_balance'];
                            echo"<br>usdt balance = ".$value_coin['coin_balance'];
                          }
                          if($coin_array_all[$user['count_kraken']]['symbol'] =='EOSBTC' && $value_coin['coin_symbol'] =='EOSBTC'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count_kraken']]['symbol'] =='ETCBTC' && $value_coin['coin_symbol'] =='ETCBTC'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count_kraken']]['symbol'] =='EOSUSDT' && $value_coin['coin_symbol'] =='EOSUSDT'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count_kraken']]['symbol'] =='ETHBTC' && $value_coin['coin_symbol'] =='ETHBTC'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count_kraken']]['symbol'] =='QTUMBTC' && $value_coin['coin_symbol'] =='QTUMBTC'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count_kraken']]['symbol'] =='TRXBTC' && $value_coin['coin_symbol'] =='TRXBTC'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count_kraken']]['symbol'] =='XLMBTC' && $value_coin['coin_symbol'] =='XLMBTC'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count_kraken']]['symbol'] =='XRPBTC' && $value_coin['coin_symbol'] =='XRPBTC'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count_kraken']]['symbol'] =='LINKBTC' && $value_coin['coin_symbol'] =='LINKBTC'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count_kraken']]['symbol'] =='XMRBTC' && $value_coin['coin_symbol'] =='XMRBTC'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count_kraken']]['symbol'] =='LTCUSDT' && $value_coin['coin_symbol'] =='LTCUSDT'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count_kraken']]['symbol'] =='ADABTC' && $value_coin['coin_symbol'] =='ADABTC'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }elseif($coin_array_all[$user['count_kraken']]['symbol'] =='XRPUSDT' && $value_coin['coin_symbol'] =='XRPUSDT'){
                            $array_update['open/lth_balance'] = $value_coin['coin_balance'];
                          }
                        }
                      }//end balance loop
                    


                      if(count($order_return_sold) > 0 || count($order_return_response) > 0){
                        $where_parent['parent_status'] = 'parent';
                        $where_parent['pause_status'] = 'play';
                        $where_parent['application_mode'] ='live';
                        $where_parent['exchange'] = 'binance';
                        $where_parent['status']['$in'] = array('new','takingOrder');
                        $where_parent['admin_id'] = (string)$user['_id'];

                        $this->mongo_db->where($where_parent);
                        $parents = $this->mongo_db->get('buy_orders');
                        $parent_count = iterator_to_array($parents);
                        $array_update['Active_Parents'] = count($parent_count);
                        echo"<br>Active parents are =".count($parent_count);
                      }

                      if(count($order_return_sold) > 0 && count($order_return_response) == 0){
                        $array_update['sell_comission_bnb'] = $sell_commision_BNB;
                        $array_update['sell_comission_qty'] = $sell_commision_Qty;
                      }

                      if( count($order_return_sold)>0 && count($order_return_response) == 0 ){
                        $array_update['gain_total'] = $gain_total;
                        $array_update['profit'] = $gain_total - $investment -$buy_commision_Qty - $sell_commision_Qty ;
                      }
                      echo "<pre>";
                      print_r($array_update);
                      echo "<br>total investment = ".$investment;
                      echo "<br>total gain = ".$gain_total;

                      $update_where['username'] = $user['username'];
                      $update_where['admin_id'] = (string)$user['_id'];
                      $update_where['coin'] = $coin_array_all[$user['count_kraken']]['symbol']; 
                      if(count($order_return_sold) >0 || count($order_return_response)>0){
                        echo"<br>Updated Sucessfully";
                        $custom = $this->mongo_db->customQuery(); 
                        $upsert['upsert'] = true;
                        $custom->$collection_name->updateOne($update_where, ['$set'=> $array_update], $upsert);
                      }//end count check
                      if($coin_array_all[$user['count_kraken']+1]['symbol'] =='' || !isset($coin_array_all[$user['count_kraken']+1]['symbol'])){
                        $array_update_in_user_colection['is_modified_kraken'] = $current_time_date;
                        $array_update_in_user_colection['count_kraken'] = '0';
                      }
                      else{
                        $array_update_in_user_colection['count_kraken'] = $user['count_kraken']+1;
                      }
                      echo"<pre>user colection update array";
                      print_r($array_update_in_user_colection);
                      $search_find['application_mode'] = 'both';
                      $search_find['_id']  = $user['_id'];
                      $search_find['username'] = $user['username'];

                      $this->mongo_db->where($search_find);
                      $this->mongo_db->set($array_update_in_user_colection);
                      $this->mongo_db->update('users');

                    }//end user cllection foreach
                    echo"<br>Total Open/LTH =".count($order_return_response);
                    echo"<br>Total Sold orders =".count($order_return_sold);
                  }//end first check
                }//end function

                public function display_user_list(){
                    $year = date('Y');
                    $filter_data['filter_investment_report'] = $this->input->post();
                    $this->session->set_userdata($filter_data);

                    if($this->input->post('exchange')){
                      $collection_name = 'users_calculation_'.$this->input->post('exchange').'_'.$year;
                    }else{
                      $collection_name = 'users_calculation_binance_'.$year;
                    }
                    if($this->input->post('filter_by_coin')){
                        $search['coin']['$in'] = $this->input->post('filter_by_coin');
                    }
                    if($this->input->post('filter_by_month')){
                        $search['month']['$in'] = $this->input->post('filter_by_month');
                        $this->session->set_userdata('month', $this->input->post('filter_by_month'));
                    }else{
                      if($this->session->userdata('month')){
                          $search['month']['$in'] = $this->session->userdata('month');
                      }else{
                          $search['month']['$in'] = array('01','02','03','04','05','06','07','08','09','10','11','12');
                        }
                      }
                    if($this->input->post('user_name')){
                        $search['username'] = $this->input->post('user_name');
                    }

                    $custom = $this->mongo_db->customQuery(); 
                    $condition_1 = array('sort'=>array('created_date'=>-1));
                  
                    $data_return_1 = $custom->$collection_name->find($search, $condition_1);
                    $user_return = iterator_to_array($data_return_1);

                    $config['base_url'] = base_url() .'admin/users_list/display_user_list';
                    $config['total_rows'] = count($user_return);
              
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
                      $data["links"] = $this->pagination->create_links();
                
                    $custom = $this->mongo_db->customQuery(); 
                    $condition = array('sort'=>array('created_date'=>-1));
                    $condition = array('limit'=>$config['per_page'], 'skip'=>$page); 
                    
                    $data_return = $custom->$collection_name->find($search, $condition);
                    $user_return_detail = iterator_to_array($data_return);
                    $data['final_array'] = $user_return_detail;               
                
                    $coin_array_all = $this->mod_coins->get_all_coins();
                    $data['coins'] = $coin_array_all;
                    $this->stencil->paint('admin/users/user_investment_details',$data);
                }

                public function monthly_calculation_user_kraken_test(){
                  $price_search['coin'] = 'BTCUSDT';
                  $this->mongo_db->where($price_search);
                  $priceses = $this->mongo_db->get('market_prices_kraken');
                  $final_prices = iterator_to_array($priceses);
                  echo $btcusdt = $final_prices[0]['price'];
                  $usdt_coin_in_arr = ['XRPUSDT', 'LTCUSDT', 'EOSUSDT']; 
                  $btc_coin_in_arr = ['XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC'];
                  $collection_name = 'user_investment_kraken';
                  $current_date_time =  date('Y-m-d H:i:s');
                  $current_time_date =  $this->mongo_db->converToMongodttime($current_date_time);

                  $next_date =  date('Y-m-d H:i:s', strtotime('-4 hours'));   // run this on 27 date and then run after 1 month
                  $pre_time_date =  $this->mongo_db->converToMongodttime($next_date);
                  $getUsers = [
                    [
                      '$match' =>[
                        '$or' =>[
                          ['is_modified_actual_report_kraken' => ['$lte'=>$pre_time_date]],
                          ['is_modified_actual_report_kraken' => ['$exists' => false]],
                        ],
                        'application_mode' => ['$in'=> ['both', 'live']]
                      ],
                      // '$in' =>[
                        //   'username' => ['CherFosDig13'],
                      // ],
                    ],
                    [
                      '$sort' =>['created_date'=> -1],
                    ],
                    ['$limit'=>2]
                  ];
                  $custom = $this->mongo_db->customQuery(); 
                  $user_return_collectio = $custom->users->aggregate($getUsers);
                  $user_return_detail = iterator_to_array($user_return_collectio);
                  echo"<pre>".count($user_return_detail);
                  if(count($user_return_detail) > 0){
                    foreach($user_return_detail as $user){
                      $where_credential['user_id'] = (string)$user['_id'];
                      $user_return_kraken = $custom->kraken_credentials->find($where_credential);
                      $user_return_detail_kraken = iterator_to_array($user_return_kraken);
                      echo"<pre> kraken = ".count($user_return_detail_kraken);
                      if(count($user_return_detail_kraken)> 0){
                        echo"<br>id =".$user['_id'];                                      
                        $open['admin_id'] = (string)$user['_id'];
                        $open['application_mode'] = 'live';
                        $open['status']= array('$in'=> array('FILLED'));
                        $open['is_sell_order'] = 'yes';

                        $retun_orders_open = $custom->buy_orders_kraken->find($open);
                        $order_return_response_open = iterator_to_array($retun_orders_open);
                        echo"<br> open orders = ".count($order_return_response_open);

                        $open_btc = 0;
                        $open_usdt = 0;
                        $openBTCSUDT = 0;
                        if(count($order_return_response_open) > 0){
                          foreach($order_return_response_open as $open){
                            if(in_array($open['symbol'], $btc_coin_in_arr )){
                              $open_btc += $open['purchased_price'] * $open['quantity']; 
                            }elseif(in_array($open['symbol'], $usdt_coin_in_arr )){
                              $open_usdt += $open['purchased_price'] * $open['quantity']; 
                            }elseif($open['symbol'] == 'BTCUSDT'){
                              $openBTCSUDT += $open['purchased_price'] * $open['quantity'];
                            }
                          }
                        }  
                        echo"<br>open usdt = ".$open_usdt;
                        $open_balance_converted = 0;
                        $openTotalBtc = 0;
                        if($open_btc > 0){
                          $openTotalBtc = $open_btc;
                          $open_balance_converted = convert_btc_to_usdt($open_btc);  // helper function
                          echo "usdt balance converted = ".$open_balance_converted;
                        }

                        $lth['admin_id'] = (string)$user['_id'];
                        $lth['application_mode'] = 'live';
                        $lth['status']['$in'] = ['LTH'];
                        $lth['is_sell_order'] = 'yes';
                        $lth['resume_status']['$ne'] = 'resume';
                        $lth['cost_avg'] = ['$nin'=>['taking_child', 'yes', 'completed']];
                        $lth['lth_functionality'] = 'yes';

                        $retun_orders_lth = $custom->buy_orders_kraken->find($lth);
                        $order_return_response_lth = iterator_to_array($retun_orders_lth);
                        echo"<br> lth orders = ".count($order_return_response_lth);

                        $lth_btc = 0;
                        $lth_usdt = 0;
                        $lthBTCSUDT = 0;
                        if(count($order_return_response_lth) > 0){
                          foreach($order_return_response_lth as $lth){
                            if(in_array($lth['symbol'], $btc_coin_in_arr)){
                              $lth_btc += $lth['purchased_price'] * $lth['quantity']; 
                            }elseif(in_array($lth['symbol'], $usdt_coin_in_arr)){
                              $lth_usdt += $lth['purchased_price'] * $lth['quantity']; 
                            }elseif($lth['symbol'] == 'BTCUSDT'){
                              $lthBTCSUDT  +=$lth['purchased_price'] * $lth['quantity']; 
                            }
                          }
                        }                  
                        $lthBTCTotal = 0;
                        $lth_balance_converted = 0;
                        if($lth_btc > 0){
                          $lthBTCTotal = $lth_btc;
                          $lth_balance_converted = convert_btc_to_usdt($lth_btc);  // helper function
                          echo"<br> lth usdt converted = ".$lth_balance_converted;
                        }
                        echo "<br> lth usdt = ".$lth_usdt;

                        $sold['admin_id'] = (string)$user['_id'];
                        $sold['application_mode'] = 'live';
                        $sold['is_sell_order']= 'sold';
                        $order_return = $custom->sold_buy_orders_kraken->find($sold);
                        $order_return_sold = iterator_to_array($order_return);
                        echo"<br> sold count = ".count($order_return_sold);

                        $where_balance['user_id'] = (string)$user['_id'];
                        $this->mongo_db->where($where_balance);
                        $data = $this->mongo_db->get('user_wallet_kraken');
                        $balance_res = iterator_to_array($data);

                        $total_usdt_balance_converted_total = 0;
                        $total_usdt_balance = 0;
                        $total_btc_balance = 0;
                        $bnb = 0;
                        foreach( $balance_res as $balance){
                          if($balance['coin_symbol'] == 'BTC'){
                            $total_btc_balance = $balance['coin_balance'];
                            $total_usdt_balance_converted_total = convert_btc_to_usdt($balance['coin_balance']); //helper function for btc to usdt amount
                            echo "<br>btc balance = ".$balance['coin_balance'];
                            echo "<br>usdt balance  converted= ".$total_usdt_balance_converted_total;

                          }elseif($balance['coin_symbol'] == 'USDT'){
                            $total_usdt_balance = $balance['coin_balance'];
                            echo "<br>USDT balance = ".$balance['coin_balance'];
                          }
                        } // end loop
                        $handshake = $this->GetRandomAPIaccessToken(); //get api parameter
                        $parameter = array(
                          'handshake' =>  $handshake,
                          'user_id'   => (string)$user['_id'],
                        );
                        $curl = curl_init();
                        $jsondata = json_encode($parameter);
                        curl_setopt_array($curl, array(
                          CURLOPT_URL => "https://users.digiebot.com/cronjob/GetUserSubscriptionDetails",
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_ENCODING => "",
                          CURLOPT_MAXREDIRS => 10,
                          CURLOPT_TIMEOUT => 0,
                          CURLOPT_FOLLOWLOCATION => true,
                          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                          CURLOPT_CUSTOMREQUEST => "POST",
                          CURLOPT_POSTFIELDS =>$jsondata,
                          CURLOPT_HTTPHEADER => array(
                            "Content-Type: application/json"
                          ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        $responce_Data = json_decode($response);
                        $trade_limit = 0;
                        if($responce_Data->trade_limit == null || $responce_Data->trade_limit == 'undifined' || $responce_Data->trade_limit== '0'){
                          $trade_limit = 0;
                        }else{
                          $trade_limit = $responce_Data->trade_limit;
                        } 
                              
                        $playLoadUserId = array(
                          'user_id'   => (string)$user['_id'],
                        );
                        $curl = curl_init();
                        $jsondataPayLoad = json_encode($playLoadUserId);
                        curl_setopt_array($curl, array(
                          CURLOPT_URL => "https://users.digiebot.com/cronjob/GetUserTotalPoints",
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_ENCODING => "",
                          CURLOPT_MAXREDIRS => 10,
                          CURLOPT_TIMEOUT => 30,
                          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                          CURLOPT_CUSTOMREQUEST => "POST",
                          CURLOPT_POSTFIELDS => $jsondataPayLoad,
                          CURLOPT_HTTPHEADER => array(
                            "authorization: Basic cG9pbnRTdXBwbHk6NGU0NmQ5OWFjMjJhNGIwYWJlNTc2OGE3OGVlODdiOGM=",
                            "cache-control: no-cache",
                            "content-type: application/json",
                            "postman-token: b5711a89-ed67-92ba-25a8-685cfdcee2ec"
                          ),
                        ));
                        $response = curl_exec($curl);
                        $err = curl_error($curl);
                        curl_close($curl);
                        $totalPointsDetails = json_decode($response);
                        if($totalPointsDetails->status == 200 || $totalPointsDetails->message == "Data Found!"){
                          $userTotalPointsApiResponse =  $totalPointsDetails->points;
                        }else{
                          $userTotalPointsApiResponse = 0;
                        }

                        // Auto trade Generator setting check 
                        $where_agt['user_id'] =  (string)$user['_id'];
                      
                        $atg_kraken = $custom->auto_trade_settings_kraken->find($where_agt);
                        $atg_return_kraken = iterator_to_array($atg_kraken);
                        echo"<pre> Kraken ATG = ";
                        echo count($atg_return_kraken);
                        // End Auto trade Generator setting check 

                        $btcInvestPercentage = $atg_return_kraken[0]['step_4']['btcInvestPercentage'];
                        $totalTradeAbleInUSD = $atg_return_kraken[0]['step_4']['totalTradeAbleInUSD'];
                        $usdtInvestPercentage = $atg_return_kraken[0]['step_4']['usdtInvestPercentage'];
                        $dailTradeAbleBalancePercentage = $atg_return_kraken[0]['step_4']['dailTradeAbleBalancePercentage'];
          
                        $availableBTC   =  ($total_btc_balance + $open_btc) - $lth_btc;
                        $availableUSDT  =  ($total_usdt_balance + $open_usdt) - $lth_usdt;
                        $btcUSdworth    =  $availableBTC * $btcusdt;
                        
                        $btcPercentTradeableValue = ($btcInvestPercentage * $totalTradeAbleInUSD) / 100 ;
                        $usdtPercentTradeableValue = ($totalTradeAbleInUSD - $btcPercentTradeableValue);
    
                        $tradeAbleUsdWorth = $btcUSdworth <= $btcPercentTradeableValue ? $btcUSdworth : $btcPercentTradeableValue;
                        $actualTradeableBTC = (float)((1 / $btcusdt) * $tradeAbleUsdWorth);
                        $tradeAbleUsd = $availableUSDT <= $usdtPercentTradeableValue ? $availableUSDT : $usdtPercentTradeableValue;
                        $actualTradeableUSDT = (float)$tradeAbleUsd;
                        echo '<br>user_id asa: '.$user['username'].' / '.$actualTradeableBTC.' / '.$actualTradeableUSDT;
                        
                        $where_daily_limit['user_id'] =  (string)$user['_id'];
                        $daily_return = $custom->daily_trade_buy_limit_kraken->find($where_daily_limit);
                        $daily_return_kraken = iterator_to_array($daily_return);
                        echo"<pre> binance daliy limit $ = ";
                        print_r($daily_return_kraken[0]['daily_buy_usd_limit']);    
                              
                        $pipeline = [
                          [
                            '$match' =>[
                              'application_mode' => 'live',
                              'admin_id' => (string)$user['_id'],
                              'status' => ['$in'=>['LTH','FILLED']],
                              'is_sell_order' => 'yes',
                            ],
                          ],
                            [
                              '$sort' =>['buy_date'=> -1],
                            ],
                            ['$limit'=>1]
                        ];
                        $result_buy = $custom->buy_orders_kraken->aggregate($pipeline);
                        $res = iterator_to_array($result_buy);
                        $pipeline_2= [
                          [
                            '$match' =>[
                              'application_mode' => 'live',
                              'admin_id' => (string)$user['_id'],
                              'is_sell_order' => 'sold',
                            ],
                          ],
                          [
                            '$sort' =>['sell_date'=> -1],
                          ],
                          ['$limit'=>1]
                        ];   

                        // $expirydate = date('Y-m-d', strtotime(str_replace(',', '', $responce_Data->subscription_expiry_date)));
                        // echo "<br>=========".$expirydate;
                        // $expiry_date = $this->mongo_db->converToMongodttime($expirydate);
                        // print_r("<br>===aaaa======".$expiry_date);
                        $result_sold = $custom->sold_buy_orders_kraken->aggregate($pipeline_2);
                        $res_sold = iterator_to_array($result_sold);
                          //sold avg calculate 
                        $current = $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'));
                        $current_date = date('Y-m-d H:i:s', strtotime('-1 month'));
                        $mongo_time = $this->mongo_db->converToMongodttime($current_date);

                        $lthOpen['created_date'] = ['$gte' => $mongo_time, '$lte' => $current];
                        $lthOpen['admin_id'] = (string)$user['_id'];
                        $lthOpen['application_mode'] = 'live';
                        $lthOpen['status']['$in'] = ['LTH', 'FILLED'];
                        $retunOrdersLTH = $custom->buy_orders_kraken->find($lthOpen);
                        $orderReturnResponseLTH = iterator_to_array($retunOrdersLTH);
                        echo"<br> lth and open orders = ".count($orderReturnResponseLTH);
          
                        $btc = 0;
                        $usdt = 0;
                        if(count($orderReturnResponseLTH) > 0){
                          foreach($orderReturnResponseLTH as $calculation){
                            if(in_array($calculation['symbol'], $btc_coin_in_arr)){
                              $btc += $calculation['purchased_price'] * $calculation['quantity'];
                              echo "<br> btc = ".$btc;
                            }elseif(in_array($calculation['symbol'], $usdt_coin_in_arr)){
                              $usdt += $calculation['purchased_price'] * $calculation['quantity'];
                              echo "<br> usdt = ".$usdt;
                            }
                          }//end foreach
                        }//end if
                              
                        $where_sold_order['application_mode'] ='live';
                        $where_sold_order['admin_id'] = (string)$user['_id'];
                        $where_sold_order['created_date'] = ['$gte' => $mongo_time, '$lte' => $current];
                        $where_sold_order['is_sell_order'] = 'sold';
                        $this->mongo_db->where($where_sold_order);
                        $data = $this->mongo_db->get('sold_buy_orders_kraken');
                        $total_sold_rec = iterator_to_array($data);

                        $sold_purchase_price = 0;                          
                        $per_trade_sold = 0;
                        $avg_sold = 0;
                        $btcInvestmentCal = 0;
                        $investProfitBTC = 0;
                        $usdtInvestmentCal = 0;
                        $investProfitUSDT = 0;
                        if(count($total_sold_rec) > 0){
                          foreach($total_sold_rec as $sold_orders){
                            $sold_purchase_price += (float) ($sold_orders['market_sold_price'] - $sold_orders['purchased_price']) / $sold_orders['purchased_price'];											
                            print_r("<br> Market sold price  = ".$sold_orders['market_sold_price']);
                            print_r("<br>purchase price  =".$sold_orders['purchased_price']);
                            print_r("<br> sold_puchase_price + =".$sold_purchase_price);
                            echo '<br>order_id  ='.$sold_orders['_id'];
                            if(in_array($sold_orders['symbol'], $btc_coin_in_arr)){
                            $btcInvestmentCal += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                            $investProfitBTC += $sold_orders['market_sold_price'] * $sold_orders['quantity'];
                            $btc += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                            echo "<br> btc = ".$btc;
                          }elseif(in_array($sold_orders['symbol'], $usdt_coin_in_arr)){
                            $usdtInvestmentCal += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                            $investProfitUSDT += $sold_orders['market_sold_price'] * $sold_orders['quantity'];
                            $usdt += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                            echo "<br> usdt = ".$usdt;
                          }	
                          } //end check
                        }//end foreach
                        $convert = 0;
                        if($btc > 0){
                          $convert = $btcusdt * $btc;
                        }
                        if($investProfitBTC > 0){
                          $investProfitBTC = $btcusdt * $investProfitBTC;
                        }
                        if($btcInvestmentCal > 0){
                          $btcInvestmentCal = $btcusdt * $btcInvestmentCal;
                        }
                        $actualProfitLastMonthInSoldOrders = ($investProfitUSDT + $investProfitBTC) - ($btcInvestmentCal + $usdtInvestmentCal);

                        $per_trade_sold = (float) $sold_purchase_price * 100;
                        echo "<br>per tarde = ".$per_trade_sold;
                        if(count($total_sold_rec) > 0){
                          $avg_sold = $per_trade_sold / count($total_sold_rec);
                        }else{
                          $avg_sold = 0;
                        }
                        echo "<br>avg_sold = ";
                        print_r($avg_sold);
                        print_r("<br>sold count = ".count($total_sold_rec));

                        $agregate = [
                          [
                            '$match' => [
                              'user_id' => (string)$user['_id'],
                              'action'  => 'deduct'
                            ],
                          ],
                            [
                              '$group' => [
                                '_id' => 1,
                                'totalPoints' => ['$sum' => '$points_consumed']
                              ],
                            ],
                        ];
                        $data = $custom->trading_points_history_kraken->aggregate($agregate);
                        $response = iterator_to_array($data);

                        $conditionGetHistoryRecord = ['sort' => ['created_date' => -1], 'limit' => 1];
                        $getPreviousHistoryLimit['user_id'] = (string)$user['_id'];
                        $getUserLimitHistory  = $custom->daily_trade_buy_limit_history_kraken->find($getPreviousHistoryLimit, $conditionGetHistoryRecord);
                        $gotDataReturnHistory = iterator_to_array($getUserLimitHistory);
                        if($daily_return_kraken[0]['daily_buy_usd_worth'] == 0) {
                          $todayBuyPercentage = 0;
                        }elseif($daily_return_kraken[0]['daily_buy_usd_worth'] == $daily_return_kraken[0]['daily_buy_usd_limit']){
                          $todayBuyPercentage = 100;
                        }else{
                          $todayBuyPercentage = ($daily_return_kraken[0]['daily_buy_usd_worth'] / $daily_return_kraken[0]['daily_buy_usd_limit'])*100;
                        } 
                        if($gotDataReturnHistory[0]['daily_buy_usd_worth'] == 0){
                          $previousBuyPercentage = 0;
                        }elseif($gotDataReturnHistory[0]['daily_buy_usd_limit'] == $gotDataReturnHistory[0]['daily_buy_usd_worth'] && $gotDataReturnHistory[0]['daily_buy_usd_worth'] !=0 && $gotDataReturnHistory[0]['daily_buy_usd_limit'] !=0){
                          $previousBuyPercentage = 100;
                        }else{
                          $previousBuyPercentage = ($gotDataReturnHistory[0]['daily_buy_usd_worth']/ $gotDataReturnHistory[0]['daily_buy_usd_limit'] )*100;
                        }

                        if(($open_balance_converted + $open_usdt) == '0'){
                          $openBalancePercentage = 0;
                        }else{
                          $openBalancePercentage = (($open_balance_converted + $open_usdt) / (($total_usdt_balance + $total_usdt_balance_converted_total + $open_balance_converted + $open_usdt + $lth_balance_converted + $lth_usdt)))*100;
                        }
    
                        if(($lth_balance_converted + $lth_usdt) == '0'){
                          $lthBalancePercentage = 0;
                        }else{
                          $lthBalancePercentage = ((($lth_balance_converted + $lth_usdt)) / ($total_usdt_balance + $total_usdt_balance_converted_total + $open_balance_converted + $open_usdt + $lth_balance_converted + $lth_usdt))*100;
                        }  

                        $activeParents['admin_id'] = (string)$user['_id'];
                        $activeParents['application_mode'] = 'live';
                        $activeParents['parent_status'] = 'parent'; 
                        $activeParents['status'] = 'new';
                        $activeParents['pause_status'] = 'play';

                        $activeParentsReturn = $custom->buy_orders_kraken->count($activeParents);
                        echo"<br> activeParentsReturn = ".$activeParentsReturn;
                        
                        $takingOrder['admin_id'] = (string)$user['_id'];
                        $takingOrder['application_mode'] = 'live';
                        $takingOrder['parent_status'] = 'parent'; 
                        $takingOrder['status'] = 'takingOrder';
                        $takingOrder['pause_status'] = 'play';
                        
                        $takingOrderReturn = $custom->buy_orders_kraken->count($takingOrder);
                        echo"<br> takingOrderReturn = ".$takingOrderReturn;

                        //end sold order avg calculation
                        $array_update = array(
                          'first_name'      =>  $user['first_name'],
                          'last_name'       =>  $user['last_name'],
                          'profile_pic'     =>  $user['profile_image'],
                          'trading_ip'      =>  (string)$user['trading_ip'],
                          'username'        =>  $user['username'],
                          'avg_sold'        =>  (float)$avg_sold,
                          'admin_id'        =>  (string)$user['_id'],
                          'takingOrderParents' => (float)$takingOrderReturn,
                          'newOrderParents' => (float)$activeParentsReturn,
                          'open_order'      =>  count($order_return_response_open),
                          'lth_order'       =>  count($order_return_response_lth),
                          'actual_deposit'  =>  (float)($total_usdt_balance + $total_usdt_balance_converted_total + $open_balance_converted + $open_usdt + $lth_balance_converted + $lth_usdt + $lthBTCSUDT + $openBTCSUDT),
                          'total_balance'   =>  (float)($total_usdt_balance_converted_total + $total_usdt_balance) - ($lthBTCSUDT + $openBTCSUDT),
                          'open_balance'    =>  (float)($open_balance_converted + $open_usdt), 
                          'openBalancePercentage' => (float)$openBalancePercentage,
                          'lthBalancePercentage' => (float)$lthBalancePercentage,     
                          'lth_balance'     =>  (float)($lth_balance_converted + $lth_usdt), 
                          'joining_date'    =>  $user['created_date'],
                          'bnb_balance'     =>  (float)$bnb,
                          'lastMonthProfitSoldOrders' => $actualProfitLastMonthInSoldOrders,
                          'exchange'        =>  'kraken',
                          'avaliableBtcBalance'  => (float)$total_btc_balance,
                          'avaliableUsdtBalance' => (float)$total_usdt_balance, 
                          'btcInvestPercentage' => $btcInvestPercentage,
                          'usdtInvestPercentage' => $usdtInvestPercentage,
                          'dailTradeAbleBalancePercentage' => $dailTradeAbleBalancePercentage, 
                          'previousDayLimitWas'=> $gotDataReturnHistory[0]['daily_buy_usd_limit'],
                          'previousdayGetCount'=> $gotDataReturnHistory[0]['num_of_trades_buy_today'],
                          'previousDayLimitBuy'=> $gotDataReturnHistory[0]['daily_buy_usd_worth'],
                          'consumed_points' =>   $response[0]['totalPoints'],
                          'totalPointsApi'  =>  $userTotalPointsApiResponse,
                          'remainingPoints' =>  $userTotalPointsApiResponse - $response[0]['totalPoints'],
                          'month'           =>  date('m'),
                          'lth_usdt'        =>  (float)$lth_usdt,
                          'open_usdt'        =>  (float)$open_usdt,
                          'lthBTCTotal'     =>  (float)$lthBTCTotal,
                          'openTotalBtc'    =>  (float)$openTotalBtc,
                          'previousBuyPercentage' => $previousBuyPercentage,
                          'todayBuyPercentage' => $todayBuyPercentage, 
                          'invest_amount'   =>  (float)($usdt + $convert),
                          'daily/trade_count'=> (float)$daily_return_kraken[0]['num_of_trades_buy_today'],   
                          'daily/trade_$'   =>  (float)$daily_return_kraken[0]['daily_buy_usd_worth'], 
                          'last_trade_sold' =>  $res_sold[0]['sell_date'],
                          'last_trade_buy'  =>  $res[0]['buy_date'],
                          'pakageStatusBTC' => $actualTradeableBTC,
                          'pakageStatusUSDT' => $actualTradeableUSDT,
                          // 'subscription_expiry_date' => $expiry_date,
                          'last_login_time' =>  $user['last_login_datetime'],
                          'sold_trades'     =>  (float)count($order_return_sold),
                          'modified_time'   =>  $current_time_date,
                          'trade_limit'     =>  (float)$trade_limit,
                          'exchange_enabled'=> 'yes',
                          'per_day_limit'   =>  (float)$daily_return_kraken[0]['daily_buy_usd_limit'],
                        );

                        $agregateHistory = [
                          [
                            '$match' => [
                              'user_id' => (string)$user['_id']
                            ],
                          ],
                            [
                              '$project' => [
                                '_id'               =>  '$_id',
                                'daily_buy_usd_worth'     =>  '$daily_buy_usd_worth',
                                'num_of_trades_buy_today' =>  '$num_of_trades_buy_today',
                                'daily_buy_usd_limit'     =>  '$daily_buy_usd_limit',
                                'created'           =>  '$created_date'
                              ],
                            ],
                            [
                              '$sort' =>['created_date' => -1],
                            ],
                              ['$limit' => 8]
                        ];
                        $dailyReturnHistory = $custom->daily_trade_buy_limit_kraken->aggregate($agregateHistory);
                        $dailyReturnBinanceHistory = iterator_to_array($dailyReturnHistory);
                        // asort($dailyReturnBinanceHistory);
                        $array_update['history'] = $dailyReturnBinanceHistory;

                        echo "<pre>";print_r($array_update);
                        // check auto trading setting 
                        if(count($atg_return_kraken) > 0 ){
                          $array_update['agt'] = 'yes';
                        }else{
                          $array_update['agt'] = 'no';
                        }
                        // end Auto tarde Generator setting 
                        echo "<pre>";print_r($array_update);
                        $update_where['username'] = $user['username'];
                        echo "<br>colection name".$collection_name;
                        echo"<br>Updated Sucessfully";
                        $custom = $this->mongo_db->customQuery(); 
                        $upsert['upsert'] = true;
                        $custom->$collection_name->updateOne($update_where, ['$set'=> $array_update], $upsert);
                      } //END CREDENTIAL CHECK
                      $array_update_in_user_colection['is_modified_actual_report_kraken'] = $current_time_date;
                      $search_find['_id']  = $user['_id'];
                      $search_find['username'] = $user['username'];
            
                      $this->mongo_db->where($search_find);
                      $this->mongo_db->set($array_update_in_user_colection);
                      $this->mongo_db->update('users');
                    } //end loop
                  }//end if
                }// end cron function

                public function monthly_calculation_user_bam_test(){
                  $price_search['coin'] = 'BTCUSDT';
                  $this->mongo_db->where($price_search);
                  $priceses = $this->mongo_db->get('market_prices_bam');
                  $final_prices = iterator_to_array($priceses);
                  $btcusdt = $final_prices[0]['price'];
                  $usdt_coin_in_arr = ['XRPUSDT', 'BTCUSDT', 'NEOUSDT', 'QTUMUSDT'];
                  $btc_coin_in_arr  = ['ETHBTC','XRPBTC'];

                  $collection_name   = 'user_investment_bam';
                  $current_date_time =  date('Y-m-d H:i:s');
                  $current_time_date =  $this->mongo_db->converToMongodttime($current_date_time);

                  $next_date =  date('Y-m-d H:i:s', strtotime('-5 hours'));   // run this on 27 date and then run after 1 month
                  $pre_time_date =  $this->mongo_db->converToMongodttime($next_date);

                  $getUsers = [
                    [
                      '$match' =>[
                        '$or' =>[
                          ['is_modified_actual_report_bam' => ['$lte'=>$pre_time_date]],
                          ['is_modified_actual_report_bam' => ['$exists' => false]]
                        ],
                        // '$in' =>[
                        //   'username' => ['CherFosDig13'],
                        // ],
                        'application_mode' => ['$in'=> ['both', 'live']]
                      ],
                    ],
                    [
                      '$sort' =>['created_date'=> -1],
                    ],
                    ['$limit'=>2]
                  ];
                  $custom = $this->mongo_db->customQuery(); 
                  $user_return_collectio = $custom->users->aggregate($getUsers);
                  $user_return_detail = iterator_to_array($user_return_collectio);
                  if(count($user_return_detail)>0){
                    foreach($user_return_detail as $user){
                      $where_credential['user_id'] = (string)$user['_id'];
                      $user_return_bam = $custom->bam_credentials->find($where_credential);
                      $user_return_detail_bam = iterator_to_array($user_return_bam);
                      echo"<pre> Bam = ";
                      echo count($user_return_detail_bam);
                      if(count($user_return_detail_bam)> 0){
                        echo"<br>id =".$user['_id'];                                      
                        $open['admin_id'] = (string)$user['_id'];
                        $open['application_mode'] = 'live';
                        $open['status'] = array('$in'=> array('FILLED'));
                        $open['is_sell_order'] = 'yes';

                        $retun_orders_open = $custom->buy_orders_bam->find($open);
                        $order_return_response_open = iterator_to_array($retun_orders_open);
                        echo"<br> open orders = ".count($order_return_response_open);

                        $open_btc = 0;
                        $open_usdt = 0;
                        if(count($order_return_response_open) > 0){
                          foreach($order_return_response_open as $open){
                            if(in_array($open['symbol'], $btc_coin_in_arr )){
                              $open_btc += $open['purchased_price'] * $open['quantity']; 
                            }else{
                              $open_usdt += $open['purchased_price'] * $open['quantity']; 
                            }
                          }
                        }
                        echo"<br>open usdt = ".$open_usdt;
                        $open_balance_converted = 0;
                        $openTotalBtc = 0;
                        if($open_btc > 0){
                          $openTotalBtc = $open_btc;
                          $open_balance_converted = convert_btc_to_usdt($open_btc);  // helper function
                          echo "usdt balance converted = ".$open_balance_converted;
                        }
                        $lth['admin_id'] = (string)$user['_id'];
                        $lth['application_mode'] = 'live';
                        $lth['status']['$in']= ['LTH'];
                        $lth['is_sell_order'] = 'yes';
                        $lth['lth_functionality'] = 'yes';
                        $lth['resume_status']['$ne'] = 'resume';
                        $lth['cost_avg']['$ne'] = 'yes';
                        
                        $retun_orders_lth = $custom->buy_orders_bam->find($lth);
                        $order_return_response_lth = iterator_to_array($retun_orders_lth);
                        echo"<br> lth orders = ".count($order_return_response_lth);

                        $lth_btc = 0;
                        $lth_usdt = 0;
                        if(count($order_return_response_lth) > 0){
                          foreach($order_return_response_lth as $lth){
                            if(in_array($lth['symbol'], $btc_coin_in_arr)){
                              $lth_btc += $lth['purchased_price'] * $lth['quantity']; 
                            }else{
                              $lth_usdt += $lth['purchased_price'] * $lth['quantity']; 
                              //echo "<br>LTH USDT".$lth_usdt ;
                            }
                          }
                        }
                        $lth_balance_converted = 0;
                        $lthBTCTotal = 0;
                        if($lth_btc > 0){
                          $lthBTCTotal = $lth_btc;
                          $lth_balance_converted = convert_btc_to_usdt($lth_btc);  // helper function
                          echo"<br> lth usdt converted = ".$lth_balance_converted;
                        }
                        echo "<br> lth usdt = ".$lth_usdt;

                        $sold['admin_id'] = (string)$user['_id'];
                        $sold['application_mode'] = 'live';
                        $sold['is_sell_order']= 'sold';
                        $order_return = $custom->sold_buy_orders_bam->find($sold);
                        $order_return_sold = iterator_to_array($order_return);
                        echo"<br> sold count = ".count($order_return_sold);

                        $where_balance['user_id'] = (string)$user['_id'];
                        $this->mongo_db->where($where_balance);
                        $data = $this->mongo_db->get('user_wallet_bam');
                        $balance_res = iterator_to_array($data);

                        $total_usdt_balance_converted_total = 0;
                        $total_usdt_balance = 0;
                        $bnb = 0;
                        $total_btc_balance = 0;
                        foreach( $balance_res as $balance){
                          if($balance['coin_symbol'] == 'BTC'){
                            $total_btc_balance = $balance['coin_balance'];
                            $total_usdt_balance_converted_total = convert_btc_to_usdt($balance['coin_balance']); //helper function for btc to usdt amount
                            echo "<br>btc balance = ".$balance['coin_balance'];
                            echo "<br>usdt balance  converted= ".$total_usdt_balance_converted_total;

                          }elseif($balance['coin_symbol'] == 'USDT'){
                          $total_usdt_balance = $balance['coin_balance'];
                          echo "<br>USDT balance = ".$balance['coin_balance'];
                          }elseif($balance['coin_symbol'] == 'BNB'){
                            $bnb = $balance['coin_balance'];
                          }
                        } // end loop
                      $handshake = $this->GetRandomAPIaccessToken(); //get api parameter
                      $parameter = array(
                        'handshake' =>  $handshake,
                        'user_id'   => (string)$user['_id'],
                      );
                      $curl = curl_init();
                      $jsondata = json_encode($parameter);
                      curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://users.digiebot.com/cronjob/GetUserSubscriptionDetails",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS =>$jsondata,
                        CURLOPT_HTTPHEADER => array(
                            "Content-Type: application/json"
                        ),
                      ));
                          
                      $response = curl_exec($curl);
                      curl_close($curl);
                      $responce_Data = json_decode($response);
                      echo "<pre>";print_r($responce_Data);
                      $trade_limit = 0;
                      if($responce_Data->trade_limit == null || $responce_Data->trade_limit == 'undifined' || $responce_Data->trade_limit== '0'){
                        $trade_limit = '0';
                        
                      }else{
                        $trade_limit = $responce_Data->trade_limit;  
                      } 
                            
                      $playLoadUserId = array(
                        'user_id'   => (string)$user['_id'],
                      );
                      $curl = curl_init();
                      $jsondataPayLoad = json_encode($playLoadUserId);
                      curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://users.digiebot.com/cronjob/GetUserTotalPoints",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => $jsondataPayLoad,
                        CURLOPT_HTTPHEADER => array(
                          "authorization: Basic cG9pbnRTdXBwbHk6NGU0NmQ5OWFjMjJhNGIwYWJlNTc2OGE3OGVlODdiOGM=",
                          "cache-control: no-cache",
                          "content-type: application/json",
                          "postman-token: b5711a89-ed67-92ba-25a8-685cfdcee2ec"
                        ),
                      ));
                              $response = curl_exec($curl);
                      $err = curl_error($curl);
                      curl_close($curl);
                      $totalPointsDetails = json_decode($response);
                      if($totalPointsDetails->status == 200 || $totalPointsDetails->message == "Data Found!"){
                        $userTotalPointsApiResponse =  $totalPointsDetails->points;
                      }else{
                        $userTotalPointsApiResponse = 0;
                      }
                      // Auto trade Generator setting check 
                      $where_agt['user_id'] =  (string)$user['_id'];
                    
                      $atg_bam = $custom->auto_trade_settings_bam->find($where_agt);
                      $atg_return_bam = iterator_to_array($atg_bam);
                      echo"<pre> Kraken ATG = ";
                      echo count($atg_return_bam);
                      // End Auto trade Generator setting check 

                      $btcInvestPercentage = $atg_return_bam[0]['step_4']['btcInvestPercentage'];
                      $totalTradeAbleInUSD = $atg_return_bam[0]['step_4']['totalTradeAbleInUSD'];
                      $usdtInvestPercentage = $atg_return_bam[0]['step_4']['usdtInvestPercentage'];
                      $dailTradeAbleBalancePercentage = $atg_return_bam[0]['step_4']['dailTradeAbleBalancePercentage'];
  
                      $availableBTC   =  ($total_btc_balance + $open_btc) - $lth_btc;
                      $availableUSDT  =  ($total_usdt_balance + $open_usdt) - $lth_usdt;
                      $btcUSdworth    =  $availableBTC * $btcusdt;
                              
                      $btcPercentTradeableValue = ($btcInvestPercentage * $totalTradeAbleInUSD) / 100 ;
                      $usdtPercentTradeableValue = ($totalTradeAbleInUSD - $btcPercentTradeableValue);
  
                      $tradeAbleUsdWorth = $btcUSdworth <= $btcPercentTradeableValue ? $btcUSdworth : $btcPercentTradeableValue;
                      $actualTradeableBTC = (float)((1 / $btcusdt) * $tradeAbleUsdWorth);
                      $tradeAbleUsd = $availableUSDT <= $usdtPercentTradeableValue ? $availableUSDT : $usdtPercentTradeableValue;
                      $actualTradeableUSDT = (float)$tradeAbleUsd;
                      echo '<br>user_id asa: '.$user['username'].' / '.$actualTradeableBTC.' / '.$actualTradeableUSDT;
                      
                      $where_daily_limit['user_id'] =  (string)$user['_id'];
                      $daily_return = $custom->daily_trade_buy_limit_bam->find($where_daily_limit);
                      $daily_return_bam = iterator_to_array($daily_return);
                      echo"<pre> binance daliy limit $ = ";
                      print_r($daily_return_bam[0]['daily_buy_usd_limit']);  


                      $pipeline = [
                        [
                          '$match' =>[
                            'application_mode' => 'live',
                            'admin_id' => (string)$user['_id'],
                            'status' => ['$in'=>['LTH','FILLED']],
                            'is_sell_order' => 'yes'
                          ],
                        ],
                          [
                            '$sort' =>['buy_date'=> -1],
                          ],
                          ['$limit'=>1]
                      ];
                      $result_buy = $custom->buy_orders_bam->aggregate($pipeline);
                      $res = iterator_to_array($result_buy);
        
                      $pipeline_2= [
                        [
                          '$match' =>[
                            'application_mode' => 'live',
                            'admin_id' => (string)$user['_id'],
                            'is_sell_order' => 'sold',
                          ],
                        ],
                        [
                          '$sort' =>['sell_date'=> -1],
                        ],
                        ['$limit'=>1]
                      ]; 
                      
                      $current = $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'));
                      $current_date = date('Y-m-d H:i:s', strtotime('-1 month'));
                      $mongo_time = $this->mongo_db->converToMongodttime($current_date);

                      $lthOpen['created_date'] = ['$gte' => $mongo_time, '$lte' => $current];
                      $lthOpen['admin_id'] = (string)$user['_id'];
                      $lthOpen['application_mode'] = 'live';
                      $lthOpen['status']['$in'] = ['LTH', 'FILLED'];
                      $retunOrdersLTH = $custom->buy_orders_bam->find($lthOpen);
                      $orderReturnResponseLTH = iterator_to_array($retunOrdersLTH);
                      echo"<br> lth and open orders = ".count($orderReturnResponseLTH);
        
                      $btc = 0;
                      $usdt = 0;
                      if(count($orderReturnResponseLTH) > 0){
                        foreach($orderReturnResponseLTH as $calculation){
                            if(in_array($calculation['symbol'], $btc_coin_in_arr)){
                              $btc += $calculation['purchased_price'] * $calculation['quantity'];
                              echo "<br> btc = ".$btc;
                            }elseif(in_array($calculation['symbol'], $usdt_coin_in_arr)){
                              $usdt += $calculation['purchased_price'] * $calculation['quantity'];
                              echo "<br> usdt = ".$usdt;
                            }
                          }//end foreach
                        }//end if
                        
                              // $expirydate = date('Y-m-d', strtotime(str_replace(',', '', $responce_Data->subscription_expiry_date)));
                        // $expiry_date = $this->mongo_db->converToMongodttime($expirydate);
                        $result_sold = $custom->sold_buy_orders_bam->aggregate($pipeline_2);
                        $res_sold = iterator_to_array($result_sold);
                        //sold avg calculate 
                        
                        $where_sold_order['application_mode'] ='live';
                        $where_sold_order['admin_id'] = (string)$user['_id'];
                        $where_sold_order['created_date'] = ['$gte' => $mongo_time, '$lte' => $current];
                        $where_sold_order['is_sell_order'] = 'sold';
                        $this->mongo_db->where($where_sold_order);
                        $data = $this->mongo_db->get('sold_buy_orders_bam');
                        $total_sold_rec = iterator_to_array($data);

                        $sold_purchase_price = 0;                          
                        $per_trade_sold = 0;
                        $avg_sold = 0;
                        if(count($total_sold_rec) > 0){
                          foreach($total_sold_rec as $sold_orders){
                            $sold_purchase_price += (float) ($sold_orders['market_sold_price'] - $sold_orders['purchased_price']) / $sold_orders['purchased_price'];											
                            print_r("<br> Market sold price  = ".$sold_orders['market_sold_price']);
                            print_r("<br>purchase price  =".$sold_orders['purchased_price']);
                            print_r("<br> sold_puchase_price + =".$sold_purchase_price);
                            echo '<br>order_id  ='.$sold_orders['_id'];	
                            if(in_array($sold_orders['symbol'], $btc_coin_in_arr)){
                              $btc += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                              echo "<br> btc = ".$btc;
                            }elseif(in_array($sold_orders['symbol'], $usdt_coin_in_arr)){
                              $usdt += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                              echo "<br> usdt = ".$usdt;
                            }
                          } //end check
                        }//end foreach
                        $convert = 0;
                        if($btc > 0){
                          $convert = $btcusdt * $btc;
                        }
                        $per_trade_sold = (float) $sold_purchase_price * 100;
                        echo "<br>per tarde = ".$per_trade_sold;
                        if(count($total_sold_rec) > 0){
                          $avg_sold = (float) ($per_trade_sold / count($total_sold_rec));
                        }else{
                          $avg_sold = 0;
                        }
                        echo "<br>avg_sold = ";
                        print_r($avg_sold);
                        print_r("<br>sold count = ".count($total_sold_rec));
                        $agregate = [
                          [
                            '$match' => [
                              'user_id' => (string)$user['_id'],
                              'action'  => 'deduct'
                            ],
                          ],
                            [
                              '$group' => [
                                '_id' => 1,
                                'totalPoints' => ['$sum' => '$points_consumed']
                              ],
                            ],
                        ];
                        $data = $custom->trading_points_history_bam->aggregate($agregate);
                        $response = iterator_to_array($data);
                        //end sold order avg calculation

                        $conditionGetHistoryRecord = ['sort' => ['created_date' => -1], 'limit' => 1];
                        $getPreviousHistoryLimit['user_id'] = (string)$user['_id'];
                        $getUserLimitHistory  = $custom->daily_trade_buy_limit_history_bam->find($getPreviousHistoryLimit, $conditionGetHistoryRecord);
                        $gotDataReturnHistory = iterator_to_array($getUserLimitHistory);
                        
                        if($daily_return_bam[0]['daily_buy_usd_worth'] == 0) {
                          $todayBuyPercentage = 0;
                        }elseif($daily_return_bam[0]['daily_buy_usd_worth'] == $daily_return_bam[0]['daily_buy_usd_limit']){
                          $todayBuyPercentage = 100;
                        }else{
                          $todayBuyPercentage = ($daily_return_bam[0]['daily_buy_usd_worth'] / $daily_return_bam[0]['daily_buy_usd_limit'])*100;
                        } 

                        if($gotDataReturnHistory[0]['daily_buy_usd_worth'] == 0){
                          $previousBuyPercentage = 0;
                        }elseif($gotDataReturnHistory[0]['daily_buy_usd_limit'] == $gotDataReturnHistory[0]['daily_buy_usd_worth'] && $gotDataReturnHistory[0]['daily_buy_usd_worth'] !=0 && $gotDataReturnHistory[0]['daily_buy_usd_limit'] !=0){
                          $previousBuyPercentage = 100;
                        }else{
                          $previousBuyPercentage = ($gotDataReturnHistory[0]['daily_buy_usd_worth']/ $gotDataReturnHistory[0]['daily_buy_usd_limit'] )*100;
                        }
                        if(($open_balance_converted + $open_usdt) == '0'){
                          $openBalancePercentage = 0;
                        }else{
                          $openBalancePercentage = (($open_balance_converted + $open_usdt) / (($total_usdt_balance + $total_usdt_balance_converted_total + $open_balance_converted + $open_usdt + $lth_balance_converted + $lth_usdt)))*100;
                        }
          
                        if(($lth_balance_converted + $lth_usdt) == '0'){
                          $lthBalancePercentage = 0;
                        }else{
                          $lthBalancePercentage = ((($lth_balance_converted + $lth_usdt)) / ($total_usdt_balance + $total_usdt_balance_converted_total + $open_balance_converted + $open_usdt + $lth_balance_converted + $lth_usdt))*100;
                        }  
                        $activeParents['admin_id'] = (string)$user['_id'];
                        $activeParents['application_mode'] = 'live';
                        $activeParents['parent_status'] = 'parent'; 
                        $activeParents['status'] = 'new';
                        $activeParents['pause_status'] = 'play';

                        $activeParentsReturn = $custom->buy_orders_bam->count($activeParents);
                        echo"<br> activeParentsReturn = ".$activeParentsReturn;
                        
                        $takingOrder['admin_id'] = (string)$user['_id'];
                        $takingOrder['application_mode'] = 'live';
                        $takingOrder['parent_status'] = 'parent'; 
                        $takingOrder['status'] = 'takingOrder';
                        $takingOrder['pause_status'] = 'play';
                        
                        $takingOrderReturn = $custom->buy_orders_bam->count($takingOrder);
                        echo"<br> takingOrderReturn = ".$takingOrderReturn;
                        $array_update = array(
                          'first_name'      =>  $user['first_name'],
                          'last_name'       =>  $user['last_name'],
                          'profile_pic'     =>  $user['profile_image'],
                          'username'        =>  $user['username'],
                          'trading_ip'      =>  (string)$user['trading_ip'],
                          'avg_sold'        =>  $avg_sold,
                          'admin_id'        =>  (string)$user['_id'],
                          'takingOrderParents' => (float)$takingOrderReturn,
                          'newOrderParents' => (float)$activeParentsReturn,
                          'open_order'      =>  count($order_return_response_open),
                          'lth_order'       =>  count($order_return_response_lth),
                          'actual_deposit'  =>  (float)($total_usdt_balance + $total_usdt_balance_converted_total + $open_balance_converted + $open_usdt + $lth_balance_converted + $lth_usdt),
                          'total_balance'   =>  (float)($total_usdt_balance_converted_total + $total_usdt_balance),
                          'open_balance'    =>  (float)($open_balance_converted + $open_usdt),    
                          'lth_balance'     =>  (float)($lth_balance_converted + $lth_usdt), 
                          'openBalancePercentage' => (float)$openBalancePercentage,
                          'lthBalancePercentage' => (float)$lthBalancePercentage,
                          'joining_date'    =>  $user['created_date'],
                          'bnb_balance'     =>  (float)$bnb,
                          'exchange'        =>  'bam',
                          'lth_usdt'        =>  (float)$lth_usdt,
                          'open_usdt'        =>  (float)$open_usdt,
                          'lthBTCTotal'     =>  (float)$lthBTCTotal,
                          'openTotalBtc'    =>  (float)$openTotalBtc,
                          'avaliableBtcBalance'  => (float)$total_btc_balance,
                          'avaliableUsdtBalance' => (float)$total_usdt_balance, 
                          'btcInvestPercentage'  => $btcInvestPercentage,
                          'usdtInvestPercentage' => $usdtInvestPercentage,
                          'dailTradeAbleBalancePercentage' => $dailTradeAbleBalancePercentage, 
                          'previousDayLimitWas'=> $gotDataReturnHistory[0]['daily_buy_usd_limit'],
                          'previousdayGetCount'=> $gotDataReturnHistory[0]['num_of_trades_buy_today'],
                          'previousDayLimitBuy'=> $gotDataReturnHistory[0]['daily_buy_usd_worth'],
                          'invest_amount'   =>  (float)($usdt + $convert),
                          'consumed_points' =>   $response[0]['totalPoints'],
                          'remainingPoints' =>  $userTotalPointsApiResponse - $response[0]['totalPoints'],
                          'totalPointsApi'  =>  $userTotalPointsApiResponse,
                          'daily/trade_count'=> (float)$daily_return_bam[0]['num_of_trades_buy_today'],
                          'daily/trade_$'   =>  (float)$daily_return_bam[0]['daily_buy_usd_worth'], 
                          'last_trade_sold' =>  $res_sold[0]['sell_date'],
                          'last_trade_buy'  =>  $res[0]['buy_date'],
                          'month'           =>  date('m'),
                          'previousBuyPercentage' => $previousBuyPercentage,
                          'todayBuyPercentage' => $todayBuyPercentage,
                          'pakageStatusBTC' => $actualTradeableBTC,
                          'pakageStatusUSDT' => $actualTradeableUSDT,  
                          // 'subscription_expiry_date' => $expiry_date,
                          'last_login_time' =>  $user['last_login_datetime'],
                          'sold_trades'     =>  count($order_return_sold),
                          'modified_time'   =>  $current_time_date,
                          'trade_limit'     =>  (float)$trade_limit,
                          'exchange_enabled'=> 'yes',
                          'per_day_limit'   =>  (float)$daily_return_bam[0]['daily_buy_usd_limit'],
                        );
                        // check auto trading setting 
                        if(count($atg_return_bam) > 0 ){
                          $array_update['agt'] = 'yes';
                        }else{
                          $array_update['agt'] = 'no';
                        }
                        // end Auto tarde Generator setting 
                        echo "<pre>";print_r($array_update);
                        $update_where['username'] = $user['username'];
                          // $update_where['month_year'] = $month_year;
                        echo "<br>colection name".$collection_name;
                        echo"<br>Updated Sucessfully";
                        $custom = $this->mongo_db->customQuery(); 
                        $upsert['upsert'] = true;
                        $custom->$collection_name->updateOne($update_where, ['$set'=> $array_update], $upsert);
                      } //END CREDENTIAL CHECK
                        $array_update_in_user_colection['is_modified_actual_report_bam'] = $current_time_date;
                        $search_find['_id']  = $user['_id'];
                        $search_find['username'] = $user['username'];
                        $this->mongo_db->where($search_find);
                        $this->mongo_db->set($array_update_in_user_colection);
                        $this->mongo_db->update('users');
                    } //end loop
                  }//end if
                }// end cron function

                ////////////////////////////// Investment report binance calculation 

                public function monthly_calculation_user(){

                  $buyCollectionNameBinance                =   'buy_orders';
                  $soldCollectionNameBinance               =   'sold_buy_orders';
                  $marketPriceCollectionBinance            =   'market_prices';
                  $collection_nameBinance                  =   'user_investment_binance';
                  $userWalletCollectionBinance             =   'user_wallet';
                  $atgCollectionNameBinance                =   'auto_trade_settings';
                  $dailyTradeLimitCollectionBinance        =   'daily_trade_buy_limit';
                  $dailyTradeLimitCollectionHistoryBinance =   'daily_trade_buy_limit_history';
                  $exchangeNameBinance                     =   'binance';
                  
                  $custom = $this->mongo_db->customQuery(); 

                  $price_search['coin'] = 'BTCUSDT';
                  $this->mongo_db->where($price_search);
                  $pricesesBinance = $this->mongo_db->get($marketPriceCollectionBinance);
                  $final_pricesBinance = iterator_to_array($pricesesBinance);
                  $btcusdt = $final_pricesBinance[0]['price'];

                  echo "<br>Current Market Price: ".$btcusdt;
                  $current_date_time =  date('Y-m-d H:i:s');
                  $current_time_date =  $this->mongo_db->converToMongodttime($current_date_time);

                  $next_date      =  date('Y-m-d H:i:s', strtotime('-4 hours'));   // run this on 27 date and then run after 1 month
                  $pre_time_date  =  $this->mongo_db->converToMongodttime($next_date);

                  if(!empty($this->input->get())){
                    $whereUser['username'] = $this->input->get('userName');
                  }else{
                    $where1['is_modified_actual_report'] = ['$lte'=>$pre_time_date];
                    $where2['is_modified_actual_report'] = ['$exists' => false];

                    $whereUser['$or'] = [$where1, $where2];
                    $whereUser['application_mode'] = ['$in'=> ['both', 'live']];
                  } 
                 
                  $getUsers = [
                    [
                      '$match' => $whereUser
                    ],
                    [
                      '$sort' =>['is_modified_actual_report'=> -1],
                    ],
                    ['$limit'=> 5]
                  ];
                  $user_return_collectio = $custom->users->aggregate($getUsers);
                  $user_return_detail = iterator_to_array($user_return_collectio);

                  if(count($user_return_detail) > 0){
                    foreach($user_return_detail as $user){    
                      echo"<br>username = ".$user['username'];

                      //open orders calculation
                      $openBinance['admin_id']                =  (string)$user['_id'];
                      $openBinance['application_mode']        =  'live';
                      $openBinance['status']                  =  ['$in' => ['FILLED', 'FILLED_ERROR','SELL_ID_ERROR']];
                      $openBinance['resume_status']['$ne']    =  'completed';
                      $openBinance['trigger_type']            =  "barrier_percentile_trigger";
                      $openBinance['parent_status']['$ne']    =  'parent';
                      $openBinance['is_sell_order']           =  'yes';
                      $openBinance['is_lth_order']            =  ['$ne'=> 'yes'];
                      $openBinance['cavg_parent']             =  ['$exists' => false];
                      $openBinance['count_avg_order']         =  ['$exists' => false];
                      $openBinance['cost_avg']                =  ['$nin' => ['yes', 'taking_child', 'completed']];
                      $openBinance['move_to_cost_avg']['$ne'] =  'yes';
                      
                      $retun_orders_openBinance            =  $custom->$buyCollectionNameBinance->find($openBinance);
                      $order_return_response_openBinance   =  iterator_to_array($retun_orders_openBinance);

                      $open_btcBinance     = 0;
                      $open_usdtBinance    = 0;
                      $openBTCSUDTBinance  = 0;
                      $openBTCSUDTBinanceQty = 0;

                      if(count($order_return_response_openBinance) > 0){
                        foreach($order_return_response_openBinance as $open){

                          $coin_names = substr($open['symbol'], -3);                          
                          if($coin_names == 'BTC' &&  $open['symbol'] != 'BTCUSDT'){

                            $open_btcBinance += $open['purchased_price'] * $open['quantity']; 
                          }elseif($coin_names == 'SDT' &&  $open['symbol'] != 'BTCUSDT' ){
                            
                            $open_usdtBinance += $open['purchased_price'] * $open['quantity']; 
                          }elseif($open['symbol'] == 'BTCUSDT'){
                            
                            $openBTCSUDTBinance += $open['purchased_price'] * $open['quantity'];
                            $openBTCSUDTBinanceQty += $open['quantity'];
                          }
                        }
                      }

                      $open_balance_convertedBinance = 0;
                      $openTotalBtcBinance = 0;
                      if($open_btcBinance > 0){
                        $openTotalBtcBinance = $open_btcBinance;
                        $open_balance_convertedBinance = convert_btc_to_usdt($open_btcBinance);  // helper function
                      }

                      //lth order calculation
                      $lthBinance['admin_id']              = (string)$user['_id'];
                      $lthBinance['application_mode']      = 'live';
                      $lthBinance['status']                = ['$in' => ['LTH', 'LTH_ERROR']];
                      $lthBinance['is_sell_order']         = 'yes';
                      $lthBinance['trigger_type']          =  "barrier_percentile_trigger";
                      $lthBinance['lth_functionality']     = 'yes';
                      $lthBinance['resume_status']         = ['$exists' => false]; 
                      $lthBinance['cost_avg']              = ['$nin' => ['yes', 'taking_child', 'completed']];
                      $lthBinance['cavg_parent']           = ['$exists' => false];

                      $retun_orders_lthBinance = $custom->$buyCollectionNameBinance->find($lthBinance);
                      $order_return_response_lthBinance = iterator_to_array($retun_orders_lthBinance);

                      $lth_btcBinance       = 0;
                      $lth_usdtBinance      = 0;
                      $lthBTCSUDTBinance    = 0;
                      $lthBTCSUDTBinanceQty = 0;

                      if(count($order_return_response_lthBinance) > 0){
                        foreach($order_return_response_lthBinance as $lth){

                          $coin_names = substr($lth['symbol'], -3);

                          if($coin_names == 'BTC' && $lth['symbol'] != 'BTCUSDT'){
                          
                            $lth_btcBinance += $lth['purchased_price'] * $lth['quantity']; 
                          }elseif($coin_names == 'SDT' && $lth['symbol'] != 'BTCUSDT'){
                          
                            $lth_usdtBinance += $lth['purchased_price'] * $lth['quantity']; 
                          }elseif($lth['symbol'] == 'BTCUSDT'){
                          
                            $lthBTCSUDTBinance += $lth['purchased_price'] * $lth['quantity'];
                            $lthBTCSUDTBinanceQty += $lth['quantity'];  
                          }
                        }
                      }

                      $lth_balance_convertedBinance = 0;
                      $lthBTCTotalBinance = 0;  
                      if($lth_btcBinance > 0){
                        $lthBTCTotalBinance = $lth_btcBinance;
                        $lth_balance_convertedBinance = convert_btc_to_usdt($lth_btcBinance);  // helper function
                      }

                      $costAvgOrderBinance['admin_id']          =  (string)$user['_id'];
                      $costAvgOrderBinance['application_mode']  =  'live';
                      $costAvgOrderBinance['is_sell_order']     =  'yes';
                      $costAvgOrderBinance['is_lth_order']      =  ['$ne'=> 'yes'];
                      $costAvgOrderBinance['trigger_type']      =  "barrier_percentile_trigger";
                      $costAvgOrderBinance['resume_status']     =  ['$exists' => false]; 
                      $costAvgOrderBinance['cost_avg']          =  ['$in' => ['yes', 'taking_child']];
                      $costAvgOrderBinance['status']            =  'FILLED';
                      
                      $retunCostAvgOrdersBinance            =  $custom->$buyCollectionNameBinance->find($costAvgOrderBinance);
                      $orderReturnResponseCostBinance       =  iterator_to_array($retunCostAvgOrdersBinance);

                      $costAvgBtcBinance      = 0;
                      $costAvgUsdtBinance     = 0;
                      $costAcgBTCSUDTBinance  = 0;
                      $costAcgBTCSUDTBinanceQty = 0;

                      if(count($orderReturnResponseCostBinance) > 0){
                        foreach($orderReturnResponseCostBinance as $costAvg){
                          $coin_names = substr($costAvg['symbol'], -3);
                          if($coin_names == 'BTC' && $costAvg['symbol']!= 'BTCUSDT' ){

                            $costAvgBtcBinance += $costAvg['purchased_price'] * $costAvg['quantity']; 
                          }elseif($coin_names == 'SDT' && $costAvg['symbol']!= 'BTCUSDT'){
                            
                            $costAvgUsdtBinance += $costAvg['purchased_price'] * $costAvg['quantity']; 
                          }elseif($costAvg['symbol'] == 'BTCUSDT'){

                            $costAcgBTCSUDTBinance += $costAvg['purchased_price'] * $costAvg['quantity'];
                            $costAcgBTCSUDTBinanceQty += $costAvg['quantity'];
                          }
                        }    
                      }

                      $costAvgConvertBalance = 0;
                      $costAvgTotalBtcBinance = 0;
                      if($costAvgBtcBinance > 0){
                        $costAvgTotalBtcBinance = $costAvgBtcBinance;
                        $costAvgConvertBalance = convert_btc_to_usdt($costAvgBtcBinance);  // helper function
                      }

                      //1 month old order profit/loss calculation 
                      $current = $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'));
                      $current_date = date('Y-m-d H:i:s', strtotime('-1 month'));
                      $mongo_time = $this->mongo_db->converToMongodttime($current_date);

                      $lthOpenBinance['created_date']         =  ['$gte' => $mongo_time, '$lte' => $current];
                      $lthOpenBinance['admin_id']             =  (string)$user['_id'];
                      $lthOpenBinance['application_mode']     =  'live';
                      $lthOpenBinance['status']['$in']        =  ['LTH', 'FILLED'];
                      $lthOpenBinance['trigger_type']         =  "barrier_percentile_trigger";
                      $lthOpenBinance['is_sell_order']        =  ['$ne' => 'sold'];
                      $lthOpenBinance['resume_status']        =  ['$exists' => false];
                      $lthOpenBinance['count_avg_order']      =  ['$exists' => false]; 
                      $lthOpenBinance['cavg_parent']          =  ['$exists' => false];

                      $retunOrdersLTHBinance                  = $custom->$buyCollectionNameBinance->find($lthOpenBinance);
                      $orderReturnResponseLTHBinance          = iterator_to_array($retunOrdersLTHBinance);

                      // echo"<br> lth and open orders = ".count($orderReturnResponseLTHBinance);
                      // unset($retunOrdersLTH);
                      
                      $btcBinance = 0;
                      $usdtBinance = 0;
                      $BTCSUDTBinance = 0;
                      if(count($orderReturnResponseLTHBinance) > 0){
                        foreach($orderReturnResponseLTHBinance as $calculation){
                          $coin_names = substr($calculation['symbol'], -3);
                          if($coin_names == 'BTC' && $costAvg['symbol']!= 'BTCUSDT'){

                            $btcBinance += $calculation['purchased_price'] * $calculation['quantity'];
                          }elseif($coin_names == 'SDT' && $costAvg['symbol']!= 'BTCUSDT'){
                          
                            $usdtBinance += $calculation['purchased_price'] * $calculation['quantity'];
                          }elseif($calculation['symbol'] == 'BTCUSDT'){
                          
                            $BTCSUDTBinance += $calculation['purchased_price'] * $calculation['quantity'];
                          }
                        }//end foreach
                      }//end if
                      //end 1 month old orders calculation 

                      //sold orders count get                       
                      $soldBinance['admin_id']             =  (string)$user['_id'];
                      $soldBinance['application_mode']     =  'live';
                      $soldBinance['is_sell_order']        =  'sold';
                      $soldBinance['trigger_type']         =  "barrier_percentile_trigger";
                      $soldBinance['status']               =  'FILLED';
                      $soldBinance['resume_status']        =  ['$exists' => false]; 
                      $soldBinance['cost_avg']             =  ['$nin' => ['yes', 'taking_child', 'completed']];
                      $soldBinance['cavg_parent']          =  ['$exists' => false];

                      $order_returnBinance = $custom->$soldCollectionNameBinance->count($soldBinance);
                      // echo"<br> sold count = ". $order_returnBinance;
                      // end sold orders count get

                      //get last trade buy time 
                      $pipelineBinance = [
                        [
                          '$match' =>[
                            'application_mode'   =>  'live',
                            'admin_id'           =>  (string)$user['_id'],
                            'is_sell_order'      =>  'yes',
                            'status'             =>  ['$in'=>['LTH','FILLED']],
                            'trigger_type'       =>  "barrier_percentile_trigger",
                            'resume_status'      =>  ['$exists' => false],
                            'cost_avg'           =>  ['$nin' => ['yes', 'taking_child', 'completed']],
                            'cavg_parent'        =>  ['$exists' => false]
                          ],
                        ],
                         
                          [
                            '$sort'    =>  ['buy_date'=> -1],
                          ],
                          ['$limit'=>1]
                      ];
                      $result_buyBinance = $custom->$buyCollectionNameBinance->aggregate($pipelineBinance);
                      $resBinance = iterator_to_array($result_buyBinance);
                      // end last order buy time

                      //get last trade sell time 
                      $pipeline_2Binance= [
                        [
                          '$match' =>[
                            'application_mode'    =>  'live',
                            'admin_id'            =>  (string)$user['_id'],
                            'is_sell_order'       =>  'sold',
                            'status'              =>  'FILLED',
                            'trigger_type'       =>  "barrier_percentile_trigger",
                            'resume_status'       =>  ['$exists' => false],
                            'cost_avg'            =>  ['$nin' => ['yes', 'taking_child', 'completed']],
                            'cavg_parent'         =>  ['$exists' => false]
                          ],
                        ],
                        [
                          '$sort'    =>  ['sell_date'=> -1],
                        ],
                        ['$limit'=>1]
                      ];
                     
                      $result_soldBinance = $custom->$soldCollectionNameBinance->aggregate($pipeline_2Binance);
                      $res_soldBinance = iterator_to_array($result_soldBinance);
                      // end last trade sell time 

                      //get user wallet balance
                      $where_balanceBinance['user_id'] = (string)$user['_id'];
                      $this->mongo_db->where($where_balanceBinance);
                      $dataBinance = $this->mongo_db->get($userWalletCollectionBinance);
                      $balance_resBinance = iterator_to_array($dataBinance);

                      $btcKey   = array_search('BTC', array_column($balance_resBinance, 'coin_symbol'));
                      $usdtKey  = array_search('USDT', array_column($balance_resBinance, 'coin_symbol'));
                      $bnbKey   = array_search('BNB', array_column($balance_resBinance, 'coin_symbol'));

                      // btc = coin balance x with coin current market price 

                      $total_usdt_balance_converted_totalBinance =  0 ;
                      $total_usdt_balanceBinance                 =  0 ;
                      $bnbBinance                                =  0 ; 

                      if(!empty($balance_resBinance[$btcKey]['coin_balance'])){
                        $total_btc_balanceBinance = $balance_resBinance[$btcKey]['coin_balance'];
                        $total_usdt_balance_converted_totalBinance = convert_btc_to_usdt($balance_resBinance[$btcKey]['coin_balance']); //helper function for btc to usdt amount 
                      }else{
                        $total_btc_balanceBinance = 0;
                        $total_usdt_balance_converted_totalBinance = 0; 
                      }

                      if(!empty($balance_resBinance[$usdtKey]['coin_balance'])){
                        $total_usdt_balanceBinance = $balance_resBinance[$usdtKey]['coin_balance'];
                      }else{
                        $total_usdt_balanceBinance = 0;
                      }
                      if(!empty($balance_resBinance[$bnbKey]['coin_balance']) ){
                        $bnbBinance = $balance_resBinance[$bnbKey]['coin_balance'];
                      }else{
                        $bnbBinance =  0;
                      }
                      //end get user wallet balance 

                      //get user pakage details 
                      $handshake = $this->GetRandomAPIaccessToken(); //get api parameter
                      $parameter = array(
                        'handshake' =>  $handshake,
                        'user_id'   => (string)$user['_id'],
                      );
                      $curl = curl_init();
                      $jsondata = json_encode($parameter);
                      curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://users.digiebot.com/cronjob/GetUserSubscriptionDetails",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS =>$jsondata,
                        CURLOPT_HTTPHEADER => array(
                          "Content-Type: application/json"
                        ),
                      ));
                      $responseCURL1 = curl_exec($curl);
                      curl_close($curl);
                      $responce_Data = json_decode($responseCURL1);
                      $trade_limit = 0;
                      if($responce_Data->trade_limit == null || $responce_Data->trade_limit == 'undifined' || $responce_Data->trade_limit== 0 || empty($responce_Data->trade_limit)){
                        $trade_limit = 500;
                      }else{
                          $trade_limit = $responce_Data->trade_limit;
                      }                    

                      //get user points detail
                      $playLoadUserId = array(
                        'user_id'   => (string)$user['_id'],
                      );
                      $curl = curl_init();
                      $jsondataPayLoad = json_encode($playLoadUserId);
                      curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://users.digiebot.com/cronjob/GetUserTotalPoints",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => $jsondataPayLoad,
                        CURLOPT_HTTPHEADER => array(
                          "authorization: Basic cG9pbnRTdXBwbHk6NGU0NmQ5OWFjMjJhNGIwYWJlNTc2OGE3OGVlODdiOGM=",
                          "cache-control: no-cache",
                          "content-type: application/json",
                          "postman-token: b5711a89-ed67-92ba-25a8-685cfdcee2ec"
                        ),
                      ));
                      $responseCURL = curl_exec($curl);
                      $err = curl_error($curl);
                      curl_close($curl);
                      $totalPointsDetails = json_decode($responseCURL);
                      if($totalPointsDetails->status == 200 || $totalPointsDetails->message == "Data Found!"){
                        $userTotalPointsApiResponse =  $totalPointsDetails->points;
                      }else{
                        $userTotalPointsApiResponse = 0;
                      }
                      //end user points details 

                      $customBtcPackage  = 0 ;
                      $customUsdtPackage = 0 ; 
                      // Auto trade Generator setting check 
                      $where_agtBinance['user_id']          =  (string)$user['_id'];
                      $where_agtBinance['application_mode'] = 'live';
                      $atg_returnBinance = $custom->$atgCollectionNameBinance->find($where_agtBinance);
                      $atg_returnResponseBinance = iterator_to_array($atg_returnBinance);
                      // unset($atg_return);

                      //remove after one day 
                      $btcInvestPercentageBinance       = $atg_returnResponseBinance[0]['step_4']['btcInvestPercentage'];
                      $usdtInvestPercentageAtgBinance   = $atg_returnResponseBinance[0]['step_4']['usdtInvestPercentage'];
                      // end remove line

                      $customBtcPackage   = $atg_returnResponseBinance[0]['step_4']['customBtcPackage'];
                      $customUsdtPackage  = $atg_returnResponseBinance[0]['step_4']['customUsdtPackage'];
                    
                      $usdtInvestPercentageBinance            =   $atg_returnResponseBinance[0]['step_4']['usdtInvestPercentage'];
                      $dailTradeAbleBalancePercentageBinance  =   $atg_returnResponseBinance[0]['step_4']['dailTradeAbleBalancePercentage'];

                      //get user daily limit 
                      $where_daily_limitBinance['user_id']  =   (string)$user['_id'];
                      $daily_returnBinance                  =   $custom->$dailyTradeLimitCollectionBinance->find($where_daily_limitBinance);
                      $daily_returnResponseBinance = iterator_to_array($daily_returnBinance);
                      //end get user daily limit 
                      
                      //sold avg calculate 
                      $where_sold_orderBinance['application_mode']       =  'live';
                      $where_sold_orderBinance['admin_id']               =  (string)$user['_id'];
                      $where_sold_orderBinance['created_date']           =  ['$gte' => $mongo_time, '$lte' => $current];
                      $where_sold_orderBinance['is_sell_order']          =  'sold';
                      $where_sold_orderBinance['trigger_type']           =  "barrier_percentile_trigger";
                      $where_sold_orderBinance['status']                 =  'FILLED';
                      $where_sold_orderBinance['resume_status']          =  ['$exists' => false];
                      $where_sold_orderBinance['cost_avg']               =  ['$nin' => ['yes', 'taking_child', 'completed']];
                      $where_sold_orderBinance['cavg_parent']            =  ['$exists' => false];

                      $this->mongo_db->where($where_sold_orderBinance);
                      $dataBinance            =   $this->mongo_db->get($soldCollectionNameBinance);
                      $total_sold_recBinance  =   iterator_to_array($dataBinance);

                      $sold_purchase_priceBinance =   0 ;                          
                      $per_trade_soldBinance      =   0 ;
                      $avg_soldBinance            =   0 ;
                      $investProfitBTCBinance     =   0 ;
                      $investProfitUSDTBinance    =   0 ;
                      $usdtInvestmentCalBinance   =   0 ;
                      $btcInvestmentCalBinance    =   0 ;

                      if(count($total_sold_recBinance) > 0){
                        foreach($total_sold_recBinance as $sold_orders){
                          $sold_purchase_priceBinance += (float) ($sold_orders['market_sold_price'] - $sold_orders['purchased_price']) / $sold_orders['purchased_price'];											
                          
                          $coin_names = substr($sold_orders['symbol'], -3);
                          if($coin_names == 'BTC'){
                            
                            $btcBinance += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                            $btcInvestmentCalBinance += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                            $investProfitBTCBinance += $sold_orders['market_sold_price'] * $sold_orders['quantity'];
                          }elseif($coin_names == 'SDT'){
                          
                            $usdtInvestmentCalBinance += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                            $usdtBinance += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                            $investProfitUSDTBinance += $sold_orders['market_sold_price'] * $sold_orders['quantity'];
                          }
                        } //end check
                      }//end foreach

                      $convertBinance = 0;
                      if($btcBinance > 0){
                        $convertBinance = $btcusdt * $btcBinance;
                      }
                      if($investProfitBTCBinance > 0){
                        $investProfitBTCBinance = $btcusdt * $investProfitBTCBinance;
                      }
                      if($btcInvestmentCalBinance > 0){
                        $btcInvestmentCalBinance = $btcusdt * $btcInvestmentCalBinance;
                      }
                      $actualProfitLastMonthInSoldOrdersBinance = ($investProfitUSDTBinance + $investProfitBTCBinance) - ($btcInvestmentCalBinance + $usdtInvestmentCalBinance);
                      $per_trade_soldBinance = (float) $sold_purchase_priceBinance * 100;
                      
                      if(count($total_sold_recBinance) > 0){
                        $avg_soldBinance = ($per_trade_soldBinance / count($total_sold_recBinance));
                      }else{
                        $avg_soldBinance = 0;
                      }
                      //end 1 month sold orders avg calculation 

                      $response  = calculateManulOrdersInvestment($user['_id'], 'binance');
                      // echo "<pre>";print_r($response);

                      $btcConverted = 0;
                      if($response['btcInvest'] > 0){
                        $btcConverted   = $btcusdt * $response['btcInvest'];
                      }
                      $totalManulInvest = ($response['usdtInvest'] + $btcConverted );
                      $manulOrderBtcInvest  = $response['btcInvest'];
                      $manulOrderUsdtInvest = $response['usdtInvest'];

                      //consumed points get 
                      $agregateBinance = [
                        [
                          '$match' => [
                            'user_id' => (string)$user['_id'],
                            'action'  => 'deduct'
                          ],
                        ],
                          [
                            '$group' => [
                              '_id' => 1,
                              'totalPoints' => ['$sum' => '$points_consumed']
                            ],
                          ],
                      ];
                      $datahistoryBinance = $custom->trading_points_history->aggregate($agregateBinance);
                      $responsehistoryBinance = iterator_to_array($datahistoryBinance);
                      //end consumed point get 

                      //get user limit buy and calculate trading points 
                      $conditionGetHistoryRecordBinance = ['sort' => ['created_date' => -1], 'limit' => 1];
                      $getPreviousHistoryLimitBinance['user_id'] = (string)$user['_id'];
                      $getUserLimitHistoryBinance  = $custom->$dailyTradeLimitCollectionHistoryBinance->find($getPreviousHistoryLimitBinance, $conditionGetHistoryRecordBinance);
                      $gotDataReturnHistoryBinance = iterator_to_array($getUserLimitHistoryBinance);
                      // unset($getUserLimitHistory); 

                      //canculating today buy percentage
                      if($daily_returnResponseBinance[0]['daily_bought_btc_usd_worth'] == 0) {
                        $todayBuyPercentagebtcBinance = 0;
                      }elseif($daily_returnResponseBinance[0]['daily_bought_btc_usd_worth'] == $daily_returnResponseBinance[0]['dailyTradeableBTC_usd_worth']){  
                        $todayBuyPercentagebtcBinance = 100;
                      }else{
                        $todayBuyPercentagebtcBinance = ($daily_returnResponseBinance[0]['daily_bought_btc_usd_worth'] / $daily_returnResponseBinance[0]['dailyTradeableBTC_usd_worth'])*100;
                      } 

                      if($daily_returnResponseBinance[0]['daily_bought_usdt_usd_worth'] == 0) {
                        $todayBuyPercentageusdtBinance = 0;
                      }elseif($daily_returnResponseBinance[0]['daily_bought_usdt_usd_worth'] == $daily_returnResponseBinance[0]['dailyTradeableUSDT_usd_worth']){  
                        $todayBuyPercentageusdtBinance = 100;
                      }else{
                        $todayBuyPercentageusdtBinance = ($daily_returnResponseBinance[0]['daily_bought_usdt_usd_worth'] / $daily_returnResponseBinance[0]['dailyTradeableUSDT_usd_worth'])*100;
                      } 
                      //end
                      
                      //canculating previous day buy percentage
                      if($gotDataReturnHistoryBinance[0]['daily_bought_btc_usd_worth'] == 0){
                        $previousBuyPercentagebtcBinance = 0;
                      }elseif($gotDataReturnHistoryBinance[0]['dailyTradeableBTC_usd_worth'] == $gotDataReturnHistoryBinance[0]['daily_bought_btc_usd_worth'] && $gotDataReturnHistoryBinance[0]['daily_bought_btc_usd_worth'] !=0 && $gotDataReturnHistoryBinance[0]['dailyTradeableBTC_usd_worth'] !=0){
                        $previousBuyPercentagebtcBinance = 100;
                      }else{
                        $previousBuyPercentagebtcBinance = ($gotDataReturnHistoryBinance[0]['daily_bought_btc_usd_worth']/ $gotDataReturnHistoryBinance[0]['dailyTradeableBTC_usd_worth'] )*100;
                      }


                      if($gotDataReturnHistoryBinance[0]['daily_bought_usdt_usd_worth'] == 0){
                        $previousBuyPercentageusdtBinance = 0;
                      }elseif($gotDataReturnHistoryBinance[0]['dailyTradeableUSDT_usd_worth'] == $gotDataReturnHistoryBinance[0]['daily_bought_usdt_usd_worth'] && $gotDataReturnHistoryBinance[0]['daily_bought_usdt_usd_worth'] !=0 && $gotDataReturnHistoryBinance[0]['dailyTradeableUSDT_usd_worth'] !=0){
                        $previousBuyPercentageusdtBinance = 100;
                      }else{
                        $previousBuyPercentageusdtBinance = ($gotDataReturnHistoryBinance[0]['daily_bought_usdt_usd_worth']/ $gotDataReturnHistoryBinance[0]['dailyTradeableUSDT_usd_worth'] )*100;
                      }
                      //end
                      $avaliableBtcConvertedBalance = ($total_btc_balanceBinance > 0) ? convert_btc_to_usdt($total_btc_balanceBinance) : 0;  // helper function

                      $totalUSDTopenNew = (float)($total_usdt_balanceBinance + $lth_usdtBinance + $lthBTCSUDTBinance + $open_usdtBinance + $openBTCSUDTBinance + $costAvgUsdtBinance + $costAcgBTCSUDTBinance) ;
                      $totalBtcConverted = (float)($lth_balance_convertedBinance  + $costAvgConvertBalance + $avaliableBtcConvertedBalance + $total_btc_balanceBinance); 

                      echo "<br>jdfasldkfasfvdlghvlkfdhgaklfdhv: ".$totalUSDTopenNew;
                      echo "<br>BTC   jdfasldkfasfvdlghvlkfdhgaklfdhv: ".$totalBtcConverted;
                      $totalUSDTLTH  = ($lth_usdtBinance + $lthBTCSUDTBinance) ;
                      $totalUSDTopen = ($open_usdtBinance + $openBTCSUDTBinance) ;
                      $costAvgUsdt   = ($costAvgUsdtBinance + $costAcgBTCSUDTBinance);

                      $lthBalanceBtcpercentageBinance  = calculatePercentage($lthBTCTotalBinance, $customBtcPackage,  $totalBtcConverted);
                      $lthBalanceUsdtpercentageBinance = calculatePercentage($totalUSDTLTH, $customUsdtPackage,  $totalUSDTopenNew);

                      $openBalanceBtcpercentageBinance  = calculatePercentage($openTotalBtcBinance, $customBtcPackage,  $totalBtcConverted);
                      $openBalanceUsdtpercentageBinance = calculatePercentage($totalUSDTopen, $customUsdtPackage,  $totalUSDTopenNew);

                      $costAvgBalanceBtcpercentageBinance  = calculatePercentage($costAvgTotalBtcBinance, $customBtcPackage,  $totalBtcConverted);
                      $costAvgBalanceUsdtpercentageBinance = calculatePercentage($costAvgUsdt, $customUsdtPackage,  $totalUSDTopenNew);


                      //get active parent details 
                      $activeParentsBinance['admin_id']         =   (string)$user['_id'];
                      $activeParentsBinance['application_mode'] =   'live';
                      $activeParentsBinance['parent_status']    =   'parent'; 
                      $activeParentsBinance['status']           =   'new';
                      $activeParentsBinance['pause_status']     =   'play';
                      $activeParentsReturnBinance = $custom->$buyCollectionNameBinance->count($activeParentsBinance);
                      //end get active parent details 


                      //get taking orders parent 
                      $takingOrderBinance['admin_id']         =   (string)$user['_id'];
                      $takingOrderBinance['application_mode'] =   'live';
                      $takingOrderBinance['parent_status']    =   'parent'; 
                      $takingOrderBinance['status']           =   'takingOrder';
                      $takingOrderBinance['pause_status']     =   'play';
                      $takingOrderReturnBinance = $custom->$buyCollectionNameBinance->count($takingOrderBinance);

                      //end get taking order parent 


                      // last month consumed points get
                      $startTime = $this->mongo_db->converToMongodttime(date('Y-m-1 00:00:00'));
                      $endTime   = $this->mongo_db->converToMongodttime(date('Y-m-d 23:59:59'));

                      $getConsumedPoints['user_id'] = (string)$user['_id'];
                      $getConsumedPoints['created_date'] = [['$gte' => $startTime], ['$lte' => $endTime]];

                      $group = [
                        [
                          '$match' => [
                            'user_id' => (string)$user['_id'],
                            'created_date' => ['$gte' => $startTime, '$lte' => $endTime] 
                          ]
                        ],
                        [
                         '$group' => [
                           '_id' =>  null,
                           'lastMonthConsumedPoints' => ['$sum' => '$points_consumed']
                          ] 
                        ],
                      ];


                      $lastMonthConsumedPointsQuery  = $custom->trading_points_history->aggregate($group);
                      $lastMonthConsumedPointsReturn = iterator_to_array($lastMonthConsumedPointsQuery);
                      
                      $totalBalance = 0;
                      $totalBalance = (float) ($total_usdt_balance_converted_totalBinance + $total_usdt_balanceBinance) - ($lthBTCSUDTBinance + $openBTCSUDTBinance + $costAcgBTCSUDTBinance);

                      $fivePercentOfTotalBalance = 0;
                      $fivePercentOfTotalBalance = (float) ((5/$totalBalance) *100);

                      $totalAccountWorth = ($costAvgUsdtBinance + $costAcgBTCSUDTBinance + $costAvgConvertBalance + $total_usdt_balanceBinance + $total_usdt_balance_converted_totalBinance + $open_balance_convertedBinance + $open_usdtBinance + $lth_balance_convertedBinance + $lth_usdtBinance + $lthBTCSUDTBinance + $openBTCSUDTBinance);
                    
                
                      $TodayBuyWorth = todayBuyBTCAndUsdt('binance', (string)$user['_id']);
                      $savenBuyWorth = savenDaysBuyBTCAndUsdt('binance', (string)$user['_id']);

                      $totalBtc       =   $TodayBuyWorth['sold_btc'][0]['invest_btc']  + $TodayBuyWorth['btc'][0]['invest_btc'] ;
                      $totalUsdt      =   $TodayBuyWorth['sold_usdt'][0]['invest_usdt'] + $TodayBuyWorth['usdt'][0]['invest_usdt'] ;
                      $soldTotalBtc   =   $TodayBuyWorth['sold_btc'][0]['invest_btc'];
                      $soldTotalUsdt  =   $TodayBuyWorth['sold_usdt'][0]['invest_usdt'];
                      
                      $savenTotalBtc      =   $savenBuyWorth['sold_btc'][0]['invest_btc']  + $savenBuyWorth['btc'][0]['invest_btc'] ;
                      $savenTotalUsdt     =   $savenBuyWorth['sold_usdt'][0]['invest_usdt'] + $savenBuyWorth['usdt'][0]['invest_usdt'] ;
                      $soldSavenTotalBtc  =   $savenBuyWorth['sold_btc'][0]['invest_btc'] ;
                      $soldSavenTotalUsdt =   $savenBuyWorth['sold_usdt'][0]['invest_usdt'];


                      //calculate btc close ratio saven days
                      if($savenTotalBtc == 0 || $soldSavenTotalBtc == 0){

                        $savenCloseRatioBtc = 0;
                      }elseif($savenTotalBtc == $soldSavenTotalBtc){
        
                        $savenCloseRatioBtc = 100;
                      }else{
          
                        $savenCloseRatioBtc = ($soldSavenTotalBtc / $savenTotalBtc ) * 100;
                      }

                      //calculate usdt close ratio saven days
                      if($savenTotalUsdt == 0 || $soldSavenTotalUsdt == 0){
                      
                        $savenCloseRatioUsdt = 0 ;
                      }elseif($savenTotalUsdt == $soldSavenTotalUsdt){
          
                        $savenCloseRatioUsdt = 100;
                      }else{
          
                        $savenCloseRatioUsdt = ($soldSavenTotalUsdt / $savenTotalUsdt ) * 100;
                      }

                      //calculate btc close ratio
                      if($totalBtc == 0 || $soldTotalBtc == 0){
                      
                        $todayCloseRatioBtc = 0 ;
                      }elseif($totalBtc == $soldTotalBtc){
          
                        $todayCloseRatioBtc = 100;
                      }else{
          
                        $todayCloseRatioBtc = ($soldTotalBtc / $totalBtc ) * 100;
                      }

                      //calculate usdt close ratio
                      if($totalUsdt == 0 || $soldTotalUsdt == 0){

                        $todayCloseRatioUsdt = 0;
                      }elseif($totalUsdt == $soldTotalUsdt){
          
                        $todayCloseRatioUsdt = 100;
                      }else{
          
                        $todayCloseRatioUsdt = (($soldTotalUsdt / $totalUsdt ) * 100);
                      }

                      $array_update = array(
                        'savenCloseRatioBtc'                =>    (float)$savenCloseRatioBtc,
                        'savenCloseRatioUsdt'               =>    (float)$savenCloseRatioUsdt,
                        'todayCloseRatioBtc'                =>    (float)$todayCloseRatioBtc,
                        'todayCloseRatioUsdt'               =>    (float)$todayCloseRatioUsdt, 
                        'todaybuyWorth_BTC'                 =>    $totalBtc,
                        'todaybuyWorth_USDT'                =>    $totalUsdt,
                        'soldTodaybuyWorth_BTC'             =>    $soldTotalBtc, 
                        'soldTodaybuyWorth_USDT'            =>    $soldTotalUsdt,
                        'savenDayBuyWorth_BTC'              =>    $savenTotalBtc,
                        'savenDayBuyWorth_USDT'             =>    $savenTotalUsdt,
                        'soldSavenDayBuyWorth_BTC'          =>    $soldSavenTotalBtc,
                        'soldSavenDayBuyWorth_USDT'         =>    $soldSavenTotalUsdt,
                        'first_name'                        =>    $user['first_name'],
                        'last_name'                         =>    $user['last_name'],
                        'profile_pic'                       =>    $user['profile_image'],
                        'username'                          =>    $user['username'],
                        'admin_id'                          =>    (string)  $user['_id'],
                        'btcusdtNegitiveTotal'              =>    (float)($lthBTCSUDTBinanceQty + $openBTCSUDTBinanceQty + $costAcgBTCSUDTBinanceQty),
                        'costAvgOrder'                      =>    count($orderReturnResponseCostBinance),
                        'costAvgBalance'                    =>    (float)  ($costAvgUsdtBinance + $costAcgBTCSUDTBinance + $costAvgConvertBalance),   
                        'costAvgBtcBalance'                 =>    (float)  ($costAvgTotalBtcBinance),
                        'costAvgUsdtBalance'                =>    (float)  ($costAvgUsdtBinance + $costAcgBTCSUDTBinance),   
                        'takingOrderParents'                =>    (float)  $takingOrderReturnBinance,
                        'newOrderParents'                   =>    (float)  $activeParentsReturnBinance,
                        'tradingIp'                         =>    (string) $user['trading_ip'],
                        'avg_sold'                          =>    (float)  $avg_soldBinance,
                        'lastMonthProfitSoldOrders'         =>    $actualProfitLastMonthInSoldOrdersBinance,
                        'open_order'                        =>    (float)  count($order_return_response_openBinance),   
                        'lth_order'                         =>    (float)  count($order_return_response_lthBinance),
                        'actual_deposit'                    =>    (float)  $totalAccountWorth,
                        'total_balance'                     =>    (float)  $totalBalance,
                        'open_balance'                      =>    (float)  ($open_balance_convertedBinance + $open_usdtBinance+ $openBTCSUDTBinance),    
                        'lth_balance'                       =>    (float)  ($lth_balance_convertedBinance + $lth_usdtBinance + $lthBTCSUDTBinance), 
                        'avaliableBtcBalance'               =>    (float)  $total_btc_balanceBinance,
                        'avaliableUsdtBalance'              =>    (float)  $total_usdt_balanceBinance, 
                        // 'openBalancePercentage'             =>    (float)  $openBalancePercentageBinance,
                        'lthBalancePercentage'              =>    (float) ($lthBalanceUsdtpercentageBinance + $lthBalanceBtcpercentageBinance),  
                        'lthBalanceUsdtpercentage'          =>    (float)$lthBalanceUsdtpercentageBinance ,     
                        'lthBalanceBtcpercentage'           =>    (float)$lthBalanceBtcpercentageBinance,
                        'openBalanceUsdtpercentage'         =>    (float)$openBalanceUsdtpercentageBinance ,     
                        'openBalanceBtcpercentage'          =>    (float)$openBalanceBtcpercentageBinance,
                        'costAvgBalanceUsdtpercentageBinance'=>   (float)$costAvgBalanceUsdtpercentageBinance ,     
                        'costAvgBalanceBtcpercentageBinance' =>   (float)$costAvgBalanceBtcpercentageBinance,
                        'lth_cost_avg_balance_percentage'   =>   (float)($costAvgBalanceUsdtpercentageBinance + $costAvgBalanceBtcpercentageBinance + $lthBalanceUsdtpercentageBinance + $lthBalanceBtcpercentageBinance),     
                        'customBtcPackage'                  =>    $customBtcPackage,
                        'customUsdtPackage'                 =>    $customUsdtPackage,
                        'joining_date'                      =>    $user['created_date'],
                        'bnb_balance'                       =>    (float)  $bnbBinance,
                        'exchange'                          =>    $exchangeNameBinance,
                        'lth_usdt'                          =>    (float)  ($lth_usdtBinance + $lthBTCSUDTBinance),    
                        'open_usdt'                         =>    (float)  ($open_usdtBinance + $openBTCSUDTBinance),
                        'lthBTCTotal'                       =>    (float)  $lthBTCTotalBinance,
                        'openTotalBtc'                      =>    (float)  $openTotalBtcBinance,
                        'previousDayLimitWas'               =>    $gotDataReturnHistoryBinance[0]['daily_buy_usd_limit'],
                        'previousdayGetCount'               =>    $gotDataReturnHistoryBinance[0]['num_of_trades_buy_today'],
                        'previousDayLimitBuy'               =>    $gotDataReturnHistoryBinance[0]['daily_buy_usd_worth'], 
                        'invest_amount'                     =>    (float)  ($usdtBinance + $convertBinance),
                        'consumed_points'                   =>    $responsehistoryBinance[0]['totalPoints'],
                        'totalPointsApi'                    =>    $userTotalPointsApiResponse,
                        'remainingPoints'                   =>    $userTotalPointsApiResponse - $responsehistoryBinance[0]['totalPoints'],
                        'daily/trade_count'                 =>    (float)  $daily_returnResponseBinance[0]['num_of_trades_buy_today'],
                        'daily/trade_$'                     =>    (float)  $daily_returnResponseBinance[0]['daily_buy_usd_worth'], 
                        'dailyTradeBuyBTCIn$'               =>    (float)  $daily_returnResponseBinance[0]['daily_bought_btc_usd_worth'], 
                        'dailyBtcBuyTradeCount'             =>    (float)  $daily_returnResponseBinance[0]['BTCTradesTodayCount'],  
                        'dailyTradeBuyUSDT'                 =>    (float)  $daily_returnResponseBinance[0]['daily_bought_usdt_usd_worth'], 
                        'dailyUSDTBuyTradeCount'            =>    (float)  $daily_returnResponseBinance[0]['USDTTradesTodayCount'],
                        'previousDailyTradeBuyBTCIn$'       =>    (float)  $gotDataReturnHistoryBinance[0]['daily_bought_btc_usd_worth'],    
                        'previousDailyBtcBuyTradeCount'     =>    (float)  $gotDataReturnHistoryBinance[0]['BTCTradesTodayCount'],     
                        'previousDailyTradeBuyUSDT'         =>    (float)  $gotDataReturnHistoryBinance[0]['daily_bought_usdt_usd_worth'],   
                        'previousDailyUSDTBuyTradeCount'    =>    (float)  $gotDataReturnHistoryBinance[0]['USDTTradesTodayCount'],
                        'last_trade_sold'                   =>    $res_soldBinance[0]['sell_date'],
                        'tradingStatus'                     =>    $user['trading_status'],
                        'last_trade_buy'                    =>    $resBinance[0]['buy_date'],
                        'month'                             =>    date('m'),
                        'btcInvestPercentage'               =>    $btcInvestPercentageBinance,
                        'usdtInvestPercentageAtg'           =>    $usdtInvestPercentageAtgBinance,
                        'usdtInvestPercentage'              =>    $usdtInvestPercentageBinance,
                        'dailTradeAbleBalancePercentage'    =>    $dailTradeAbleBalancePercentageBinance,
                        'todayBuyPercentagebtc'             =>    $todayBuyPercentagebtcBinance,
                        'todayBuyPercentageusdt'            =>    $todayBuyPercentageusdtBinance,
                        'previousBuyPercentagebtc'          =>    $previousBuyPercentagebtcBinance,
                        'previousBuyPercentageusdt'         =>    $previousBuyPercentageusdtBinance,
                        'trade_limit'                       =>    (float)  $trade_limit,  //user pakge
                        'last_login_time'                   =>    $user['last_login_datetime'], 
                        'sold_trades'                       =>    $order_returnBinance ,
                        'modified_time'                     =>    $current_time_date,
                        'thisMonthConsumedPoints'           =>    (float)$lastMonthConsumedPointsReturn[0]['lastMonthConsumedPoints'],
                        'dailyTradeableUSDTLimit'           =>    (float)  $daily_returnResponseBinance[0]['dailyTradeableUSDT_usd_worth'],
                        'dailyTradeableBTCLimit$'           =>    (float)  $daily_returnResponseBinance[0]['dailyTradeableBTC_usd_worth'],
                        'PreviousDailyTradeableUSDTLimit'   =>    (float)  $gotDataReturnHistoryBinance[0]['dailyTradeableUSDT_usd_worth'],
                        'PreviousDailyTradeableBTCLimit$'   =>    (float)  $gotDataReturnHistoryBinance[0]['dailyTradeableBTC_usd_worth'],
                        'dailyTradesExpectedBtc'            =>    $atg_returnResponseBinance[0]['step_4']['dailyTradesExpectedBtc'],
                        'dailyTradesExpectedUsdt'           =>    $atg_returnResponseBinance[0]['step_4']['dailyTradesExpectedUsdt'],
                        'baseCurrencyArr'                   =>    $atg_returnResponseBinance[0]['step_4']['baseCurrencyArr'],
                       'fivePercentOfTotalBalance'          =>    $fivePercentOfTotalBalance,
                        //  'manulOrderInvestcalculationbtc'     =>    $btcdataBinanceManulRes[0]['btcBinance'],
                        //  'manulOrderInvestcalculationusdt'    =>    $usdtdataBinanceManulRes[0]['usdtBinance'],
                        'manulInvestemntTotal'              =>    (float)$totalManulInvest,
                        'manulOrderBtcInvest'               =>    $manulOrderBtcInvest,
                        'manulOrderUsdtInvest'              =>    $manulOrderUsdtInvest,
                        // 'status'                         =>    $status
                      );

                      //start getting coin balance and convert into $   and store into invesment report collection
                      $XMRBTCKey     = array_search('XMRBTC',   array_column($balance_resBinance, 'coin_symbol'));
                      $XLMBTCKey     = array_search('XLMBTC',   array_column($balance_resBinance, 'coin_symbol'));
                      $ETHBTCKey     = array_search('ETHBTC',   array_column($balance_resBinance, 'coin_symbol'));
                      $XRPBTCKey     = array_search('XRPBTC',   array_column($balance_resBinance, 'coin_symbol'));
                      $NEOBTCKey     = array_search('NEOBTC',   array_column($balance_resBinance, 'coin_symbol'));
                      $QTUMBTCKey    = array_search('QTUMBTC',  array_column($balance_resBinance, 'coin_symbol'));
                      $XEMBTCKey     = array_search('XEMBTC',   array_column($balance_resBinance, 'coin_symbol'));
                      $POEBTCKey     = array_search('POEBTC',   array_column($balance_resBinance, 'coin_symbol'));
                      $TRXBTCKey     = array_search('TRXBTC',   array_column($balance_resBinance, 'coin_symbol'));
                      $ZENBTCKey     = array_search('ZENBTC',   array_column($balance_resBinance, 'coin_symbol'));
                      $ETCBTCKey     = array_search('ETCBTC',   array_column($balance_resBinance, 'coin_symbol'));
                      $EOSBTCKey     = array_search('EOSBTC',   array_column($balance_resBinance, 'coin_symbol'));
                      $LINKBTCKey    = array_search('LINKBTC',  array_column($balance_resBinance, 'coin_symbol'));
                      $DASHBTCKey    = array_search('DASHBTC',  array_column($balance_resBinance, 'coin_symbol'));
                      $ADABTCKey     = array_search('ADABTC',   array_column($balance_resBinance, 'coin_symbol'));
                      $EOSUSDTKey    = array_search('EOSUSDT',  array_column($balance_resBinance, 'coin_symbol'));
                      $LTCUSDTKey    = array_search('LTCUSDT',  array_column($balance_resBinance, 'coin_symbol'));
                      $XRPUSDTKey    = array_search('XRPUSDT',  array_column($balance_resBinance, 'coin_symbol'));
                      $NEOUSDTKey    = array_search('NEOUSDT',  array_column($balance_resBinance, 'coin_symbol'));
                      $QTUMUSDTKey   = array_search('QTUMUSDT', array_column($balance_resBinance, 'coin_symbol'));

                      $XMRBTCBalance          =   0 ;
                      $XLMBTCBalance          =   0 ;
                      $ETHBTCBalance          =   0 ;
                      $XRPBTCBalance          =   0 ;
                      $NEOBTCBalance          =   0 ;
                      $QTUMBTCBalance         =   0 ;
                      $XEMBTCBalance          =   0 ;
                      $POEBTCBalance          =   0 ;
                      $TRXBTCBalance          =   0 ;
                      $ZENBTCBalance          =   0 ;
                      $ETCBTCBalance          =   0 ;
                      $EOSBTCBalance          =   0 ;
                      $LINKBTCBalance         =   0 ;
                      $DASHBTCBalance         =   0 ;
                      $ADABTCBalance          =   0 ;
                      $EOSUSDTBalance         =   0 ;
                      $LTCUSDTBalance         =   0 ;
                      $XRPUSDTBalance         =   0 ;
                      $NEOUSDTBalance         =   0 ;
                      $QTUMUSDTBalance        =   0 ;

                      $NEOUSDTBalance               =   ($NEOUSDTKey != '') ? $balance_resBinance[$NEOUSDTKey]['coin_balance'] : 0;
                      echo "<br>colec NEOUSDTBalance: ". $NEOUSDTBalance;
                      $NEOUSDTBalance               =   convertCoinBalanceIntoUSDT('NEOUSDT', $NEOUSDTBalance, 'binance');

                      $QTUMUSDTBalance              =   ($QTUMUSDTKey != '') ? $balance_resBinance[$QTUMUSDTKey]['coin_balance'] : 0;
                      echo "<br>colec QTUMUSDTBalance: ". $QTUMUSDTBalance;

                      $QTUMUSDTBalance              =   convertCoinBalanceIntoUSDT('QTUMUSDT', $QTUMUSDTBalance, 'binance');

                      $XRPUSDTBalance               =   ($XRPUSDTKey != '') ? $balance_resBinance[$XRPUSDTKey]['coin_balance'] : 0;

                      echo "<br>colec XRPUSDTBalance: ". $XRPUSDTBalance;

                      $XRPUSDTBalance               =   convertCoinBalanceIntoUSDT('XRPUSDT', $XRPUSDTBalance, 'binance');

                      $LTCUSDTBalance               =   ($LTCUSDTKey != '') ? $balance_resBinance[$LTCUSDTKey]['coin_balance'] : 0;

                      echo "<br>colec LTCUSDTBalance: ". $LTCUSDTBalance;

                      $LTCUSDTBalance               =   convertCoinBalanceIntoUSDT('LTCUSDT', $LTCUSDTBalance, 'binance');

                      $EOSUSDTBalance               =   ($EOSUSDTKey != '') ? $balance_resBinance[$EOSUSDTKey]['coin_balance'] : 0;
                      echo "<br>colec EOSUSDTBalance: ". $EOSUSDTBalance;


                      $EOSUSDTBalance               =   convertCoinBalanceIntoUSDT('EOSUSDT', $EOSUSDTBalance, 'binance');

                      $ADABTCBalance                =   ($ADABTCKey != '') ? $balance_resBinance[$ADABTCKey]['coin_balance'] : 0;
                      echo "<br>colec ADABTCBalance: ". $ADABTCBalance;

                      $ADABTCBalance                =   convertCoinBalanceIntobtctoUSDT('ADABTC', $ADABTCBalance, 'binance');

                      $DASHBTCBalance               =   ($DASHBTCKey != '') ? $balance_resBinance[$DASHBTCKey]['coin_balance'] : 0;

                      echo "<br>colec DASHBTCBalance: ". $DASHBTCBalance;

                      $DASHBTCBalance               =   convertCoinBalanceIntobtctoUSDT('DASHBTC', $DASHBTCBalance, 'binance');

                      $LINKBTCBalance               =   ($LINKBTCKey != '') ? $balance_resBinance[$LINKBTCKey]['coin_balance'] : 0;
                      echo "<br>colec LINKBTCBalance: ". $LINKBTCBalance;

                      $LINKBTCBalance               =   convertCoinBalanceIntobtctoUSDT('LINKBTC', $LINKBTCBalance, 'binance');

                      $EOSBTCBalance                =   ($EOSBTCKey != '') ? $balance_resBinance[$EOSBTCKey]['coin_balance'] : 0;
                      echo "<br>colec EOSBTCBalance: ". $EOSBTCBalance;

                      $EOSBTCBalance                =   convertCoinBalanceIntobtctoUSDT('EOSBTC', $EOSBTCBalance, 'binance');

                      $ETCBTCBalance                =   ($ETCBTCKey != '') ? $balance_resBinance[$ETCBTCKey]['coin_balance'] : 0;
                      echo "<br>colec ETCBTCBalance: ". $ETCBTCBalance;

                      $ETCBTCBalance                =   convertCoinBalanceIntobtctoUSDT('ETCBTC', $ETCBTCBalance, 'binance');

                      $ZENBTCBalance                =   ($ZENBTCKey != '') ? $balance_resBinance[$ZENBTCKey]['coin_balance'] : 0;
                      echo "<br>colec ZENBTCBalance: ". $ZENBTCBalance;

                      $ZENBTCBalance                =   convertCoinBalanceIntobtctoUSDT('ZENBTC', $ZENBTCBalance, 'binance');

                      $XMRBTCBalance                =   ($XMRBTCKey != '') ? $balance_resBinance[$XMRBTCKey]['coin_balance'] : 0;
                      echo "<br>colec XMRBTCBalance: ". $XMRBTCBalance;

                      $XMRBTCBalance                =   convertCoinBalanceIntobtctoUSDT('XMRBTC', $XMRBTCBalance, 'binance');

                      $XLMBTCBalance                =   ($XLMBTCKey != '') ? $balance_resBinance[$XLMBTCKey]['coin_balance'] : 0;
                      echo "<br>colec XLMBTCBalance: ". $XLMBTCBalance;

                      $XLMBTCBalance                =   convertCoinBalanceIntobtctoUSDT('XLMBTC', $XLMBTCBalance, 'binance');

                      $ETHBTCBalance                =   ($ETHBTCKey != '') ? $balance_resBinance[$ETHBTCKey]['coin_balance'] : 0;
                      echo "<br>colec ETHBTCBalance: ". $ETHBTCBalance;

                      $ETHBTCBalance                =   convertCoinBalanceIntobtctoUSDT('ETHBTC', $ETHBTCBalance, 'binance');
      
                      $XRPBTCBalance                =   ($XRPBTCKey != '') ? $balance_resBinance[$XRPBTCKey]['coin_balance'] : 0;
                      echo "<br>colec XRPBTCBalance: ". $XRPBTCBalance;

                      $XRPBTCBalance                =   convertCoinBalanceIntobtctoUSDT('XRPBTC', $XRPBTCBalance, 'binance');                    

                      $NEOBTCBalance                =   ($NEOBTCKey != '') ? $balance_resBinance[$NEOBTCKey]['coin_balance'] : 0;
                      echo "<br>colec NEOBTCBalance: ". $NEOBTCBalance;

                      $NEOBTCBalance                =   convertCoinBalanceIntobtctoUSDT('NEOBTC', $NEOBTCBalance, 'binance');                    

                      $QTUMBTCBalance               =   ($QTUMBTCKey != '') ? $balance_resBinance[$QTUMBTCKey]['coin_balance'] : 0;

                      echo "<br>colec QTUMBTCBalance: ". $QTUMBTCBalance;

                      $QTUMBTCBalance               =   convertCoinBalanceIntobtctoUSDT('QTUMBTC', $QTUMBTCBalance, 'binance');
                    
                      $XEMBTCBalance                =   ($XEMBTCKey != '') ? $balance_resBinance[$XEMBTCKey]['coin_balance'] : 0;

                      echo "<br>colec XEMBTCBalance: ". $XEMBTCBalance;

                      $XEMBTCBalance                =   convertCoinBalanceIntobtctoUSDT('XEMBTC', $XEMBTCBalance, 'binance');

                      $POEBTCBalance                =   ($POEBTCKey != '') ? $balance_resBinance[$POEBTCKey]['coin_balance'] : 0;

                      echo "<br>colec POEBTCBalance: ". $POEBTCBalance;

                      $POEBTCBalance                =   convertCoinBalanceIntobtctoUSDT('POEBTC', $POEBTCBalance, 'binance');

                      $TRXBTCBalance                =   ($TRXBTCKey != '') ? $balance_resBinance[$TRXBTCKey]['coin_balance'] : 0;

                      echo "<br>colec TRXBTCBalance: ". $TRXBTCBalance;

                      $TRXBTCBalance                =   convertCoinBalanceIntobtctoUSDT('TRXBTC', $TRXBTCBalance, 'binance');


                      //calculate order listing balances
                      $countBalanceCriteria['application_mode']           =   'live';
                      $countBalanceCriteria['status']['$nin']             =   ['credentials_ERROR','canceled_ERROR','error' ,'new', 'new_ERROR', 'canceled', 'pause', 'submitted_buy', 'fraction_submitted_buy'];
                      $countBalanceCriteria['parent_status']['$ne']       =   'parent';
                      $countBalanceCriteria['cost_avg']['$ne']            =   'completed';
                      $countBalanceCriteria['is_sell_order']['$nin']      =   ['sold', 'resume_pause'];
                      $countBalanceCriteria['admin_id']                   =   (string)$user['_id'];
                      $countBalanceCriteria['resume_status']['$ne']       =   'completed';

                      $getAllBuyOrdersBinance        =   $custom->buy_orders->find($countBalanceCriteria);
                      $getAllBuyOrdersReturnBinance  =   iterator_to_array($getAllBuyOrdersBinance);
                      echo "<br>count All: ".count($getAllBuyOrdersReturnBinance);
                      unset($getAllBuyOrdersBinance);

                      $XMRBTCBalanceCal          =   0 ;
                      $XLMBTCBalanceCal          =   0 ;
                      $ETHBTCBalanceCal          =   0 ;
                      $XRPBTCBalanceCal          =   0 ;
                      $NEOBTCBalanceCal          =   0 ;
                      $QTUMBTCBalanceCal         =   0 ;
                      $XEMBTCBalanceCal          =   0 ;
                      $POEBTCBalanceCal          =   0 ;
                      $TRXBTCBalanceCal          =   0 ;
                      $ZENBTCBalanceCal          =   0 ;
                      $ETCBTCBalanceCal          =   0 ;
                      $EOSBTCBalanceCal          =   0 ;
                      $LINKBTCBalanceCal         =   0 ;
                      $DASHBTCBalanceCal         =   0 ;
                      $ADABTCBalanceCal          =   0 ;
                      $EOSUSDTBalanceCal         =   0 ;
                      $LTCUSDTBalanceCal         =   0 ;
                      $XRPUSDTBalanceCal         =   0 ;
                      $NEOUSDTBalanceCal         =   0 ;
                      $QTUMUSDTBalanceCal        =   0 ;

                      foreach($getAllBuyOrdersReturnBinance as $orderCalculate){
                        if($orderCalculate['symbol'] == 'XMRBTC'){
                          $XMRBTCBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'XLMBTC'){
                          $XLMBTCBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'ETHBTC'){
                          $ETHBTCBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'XRPBTC'){
                          $XRPBTCBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'NEOBTC'){
                          $NEOBTCBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'QTUMBTC'){
                          $QTUMBTCBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'XEMBTC'){
                          $XEMBTCBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'POEBTC'){
                          $POEBTCBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'TRXBTC'){
                          $TRXBTCBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'ZENBTC'){
                          $ZENBTCBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'ETCBTC'){
                          $ETCBTCBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'EOSBTC'){
                          $EOSBTCBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'LINKBTC'){
                          $LINKBTCBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'DASHBTC'){
                          $DASHBTCBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'ADABTC'){
                          $ADABTCBalanceCal += $orderCalculate['quantity'];

                        }elseif($orderCalculate['symbol'] == 'EOSUSDT'){
                          $EOSUSDTBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'LTCUSDT'){
                          $LTCUSDTBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'XRPUSDT'){
                          $XRPUSDTBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'NEOUSDT'){
                          $NEOUSDTBalanceCal += $orderCalculate['quantity'] ;

                        }elseif($orderCalculate['symbol'] == 'QTUMUSDT'){
                          $QTUMUSDTBalanceCal += $orderCalculate['quantity'] ;

                        }
                      }
                      // $array_update[]

                      $XMRBTCBalanceCal   =   ($XMRBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('XMRBTC', $XMRBTCBalanceCal,   'binance'): 0;

                      echo "<br>converted XMRBTCBalanceCal: ". $XMRBTCBalanceCal;
                      $XLMBTCBalanceCal   =   ($XLMBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('XLMBTC', $XLMBTCBalanceCal,   'binance'): 0;
                      echo "<br>converted XLMBTCBalanceCal: ". $XLMBTCBalanceCal;

                      $ETHBTCBalanceCal   =   ($ETHBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('ETHBTC', $ETHBTCBalanceCal,   'binance'): 0;
                      echo "<br>converted ETHBTCBalanceCal: ". $ETHBTCBalanceCal;

                      $XRPBTCBalanceCal   =   ($XRPBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('XRPBTC', $XRPBTCBalanceCal,   'binance'): 0;
                      echo "<br>converted XRPBTCBalanceCal: ". $XRPBTCBalanceCal;

                      $NEOBTCBalanceCal   =   ($NEOBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('NEOBTC', $NEOBTCBalanceCal,   'binance'): 0;
                      echo "<br>converted NEOBTCBalanceCal: ". $NEOBTCBalanceCal;

                      $QTUMBTCBalanceCal  =   ($QTUMBTCBalanceCal > 0) ? convertCoinBalanceIntobtctoUSDT('QTUMBTC', $QTUMBTCBalanceCal,'binance'): 0;
                      echo "<br>converted QTUMBTCBalanceCal: ". $QTUMBTCBalanceCal;

                      $XEMBTCBalanceCal   =   ($XEMBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('XEMBTC', $XEMBTCBalanceCal,   'binance'): 0;
                      echo "<br>converted XEMBTCBalanceCal: ". $XEMBTCBalanceCal;

                      $POEBTCBalanceCal   =   ($POEBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('POEBTC', $POEBTCBalanceCal,   'binance'): 0;
                      echo "<br>converted POEBTCBalanceCal: ". $POEBTCBalanceCal;

                      $TRXBTCBalanceCal   =   ($TRXBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('TRXBTC', $TRXBTCBalanceCal,   'binance'): 0;
                      echo "<br>converted TRXBTCBalanceCal: ". $TRXBTCBalanceCal;

                      $ZENBTCBalanceCal   =   ($ZENBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('ZENBTC', $ZENBTCBalanceCal,   'binance'): 0;
                      echo "<br>converted ZENBTCBalanceCal: ". $ZENBTCBalanceCal;

                      $ETCBTCBalanceCal   =   ($ETCBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('ETCBTC', $ETCBTCBalanceCal,   'binance'): 0;
                      echo "<br>converted ETCBTCBalanceCal: ". $ETCBTCBalanceCal;

                      $EOSBTCBalanceCal   =   ($EOSBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('EOSBTC', $EOSBTCBalanceCal,   'binance'): 0;
                      echo "<br>converted EOSBTCBalanceCal: ". $EOSBTCBalanceCal;

                      $LINKBTCBalanceCal  =   ($LINKBTCBalanceCal > 0) ?convertCoinBalanceIntobtctoUSDT('LINKBTC', $LINKBTCBalanceCal, 'binance'): 0;
                      echo "<br>converted LINKBTCBalanceCal: ". $LINKBTCBalanceCal;

                      $DASHBTCBalanceCal  =   ($DASHBTCBalanceCal > 0) ?convertCoinBalanceIntobtctoUSDT('DASHBTC', $DASHBTCBalanceCal, 'binance'): 0;
                      echo "<br>converted DASHBTCBalanceCal: ". $DASHBTCBalanceCal;

                      $ADABTCBalanceCal   =   ($ADABTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('ADABTC', $ADABTCBalanceCal,    'binance'): 0;
                      echo "<br>converted ADABTCBalanceCal: ". $ADABTCBalanceCal;

                      $EOSUSDTBalanceCal  =   ($EOSUSDTBalanceCal > 0) ?  convertCoinBalanceIntoUSDT('EOSUSDT', $EOSUSDTBalanceCal,    'binance'): 0;
                      echo "<br>converted EOSUSDTBalanceCal: ". $EOSUSDTBalanceCal;

                      $LTCUSDTBalanceCal  =   ($LTCUSDTBalanceCal > 0) ?  convertCoinBalanceIntoUSDT('LTCUSDT', $LTCUSDTBalanceCal,    'binance'): 0;
                      echo "<br>converted LTCUSDTBalanceCal: ". $LTCUSDTBalanceCal;

                      $XRPUSDTBalanceCal  =   ($XRPUSDTBalanceCal > 0) ?  convertCoinBalanceIntoUSDT('XRPUSDT', $XRPUSDTBalanceCal,    'binance'): 0;
                      echo "<br>converted XRPUSDTBalanceCal: ". $XRPUSDTBalanceCal;

                      $NEOUSDTBalanceCal  =   ($NEOUSDTBalanceCal > 0) ?  convertCoinBalanceIntoUSDT('NEOUSDT', $NEOUSDTBalanceCal,    'binance'): 0;
                      echo "<br>converted NEOUSDTBalanceCal: ". $NEOUSDTBalanceCal;

                      $QTUMUSDTBalanceCal =   ($QTUMUSDTBalanceCal > 0) ?  convertCoinBalanceIntoUSDT('QTUMUSDT', $QTUMUSDTBalanceCal,    'binance'): 0;
                      echo "<br>converted QTUMUSDTBalanceCal: ". $QTUMUSDTBalanceCal;
                      //end

                      // extra less balance calculation
                      //order listing balance          //wallet balance
                      $xmrbtc   =  $XMRBTCBalance   -  $XMRBTCBalanceCal ;     
                      $xlmbtc   =  $XLMBTCBalance   -  $XLMBTCBalanceCal ;
                      $ethbtc   =  $ETHBTCBalance   -  $ETHBTCBalanceCal ;
                      $xembtc   =  $XEMBTCBalance   -  $XEMBTCBalanceCal ;
                      $poebtc   =  $POEBTCBalance   -  $POEBTCBalanceCal ;
                      $trxbtc   =  $TRXBTCBalance   -  $TRXBTCBalanceCal ;
                      $zenbtc   =  $ZENBTCBalance   -  $ZENBTCBalanceCal ;
                      $etcbtc   =  $ETCBTCBalance   -  $ETCBTCBalanceCal ;
                      $linkbtc  =  $LINKBTCBalance  -  $LINKBTCBalanceCal;
                      $dashbtc  =  $DASHBTCBalance  -  $DASHBTCBalanceCal;
                      $adabtc   =  $ADABTCBalance   -  $ADABTCBalanceCal ;
                      $ltcusdt  =  $LTCUSDTBalance  -  $LTCUSDTBalanceCal;

                      $less     = 0;
                      $extra    = 0;

                      $qtumbtc  =   $QTUMBTCBalance  - ($QTUMUSDTBalanceCal  + $QTUMBTCBalanceCal);
                      $xrpbtc   =   $XRPBTCBalance   - ($XRPUSDTBalanceCal   + $XRPBTCBalanceCal) ;
                      $neobtc   =   $NEOBTCBalance   - ($NEOUSDTBalanceCal   + $NEOBTCBalanceCal) ;
                      $eosbtc   =   $EOSBTCBalance   - ($EOSBTCBalanceCal    + $EOSUSDTBalanceCal);
          
                      $less    += ($xmrbtc <  0) ? $xmrbtc    :  0;
                      $extra   += ($xmrbtc >= 0) ? $xmrbtc    :  0;
          
                      $less    += ($xlmbtc <  0) ? $xlmbtc    :  0;
                      $extra   += ($xlmbtc >= 0) ? $xlmbtc    :  0;
          
                      $less    += ($ethbtc <  0) ? $ethbtc    :  0;
                      $extra   += ($ethbtc >= 0) ? $ethbtc    :  0;
          
                      $less    += ($xembtc <  0) ? $xembtc    :  0;
                      $extra   += ($xembtc >= 0) ? $xembtc    :  0;
          
                      $less    += ($poebtc <  0) ? $poebtc    :  0;
                      $extra   += ($poebtc >= 0) ? $poebtc    :  0;
          
                      $less    += ($trxbtc <  0) ? $trxbtc    :  0;
                      $extra   += ($trxbtc >= 0) ? $trxbtc    :  0;
          
                      $less    += ($zenbtc <  0) ? $zenbtc    :  0;
                      $extra   += ($zenbtc >= 0) ? $zenbtc    :  0;
          
                      $less    += ($etcbtc <  0) ? $etcbtc    :  0;
                      $extra   += ($etcbtc >= 0) ? $etcbtc    :  0;
          
                      $less    += ($linkbtc <  0) ? $linkbtc  :  0;
                      $extra   += ($linkbtc >= 0) ? $linkbtc  :  0;
          
                      $less    += ($dashbtc <  0) ? $dashbtc  :  0;
                      $extra   += ($dashbtc >= 0) ? $dashbtc  :  0;
          
                      $less    += ($adabtc <  0) ? $adabtc    :  0;
                      $extra   += ($adabtc >= 0) ? $adabtc    :  0;
          
                      $less    += ($ltcusdt <  0) ? $ltcusdt  :  0;
                      $extra   += ($ltcusdt >= 0) ? $ltcusdt  :  0;
          
                      $less    += ($qtumbtc <  0) ? $qtumbtc  :  0;
                      $extra   += ($qtumbtc >= 0) ? $qtumbtc  :  0;
          
                      $less    += ($xrpbtc <  0) ? $xrpbtc    :  0;
                      $extra   += ($xrpbtc >= 0) ? $xrpbtc    :  0;
          
                      $less    += ($neobtc <  0) ? $neobtc    :  0;
                      $extra   += ($neobtc >= 0) ? $neobtc    :  0;
          
                      $less    += ($eosbtc <  0) ? $eosbtc    :  0;
                      $extra   += ($eosbtc >= 0) ? $eosbtc    :  0;
                      $array_update['lessBalance']   =  $less;
                      $array_update['extraBalance']  =  $extra;
                      echo "<br>Less balance total: ".$less;
                      echo "<br>Extra balance total: ".$extra;
                      //end extra less balance

                      // query for this button filters "Last 7 days low trading"
                      $startTime  =   $this->mongo_db->converToMongodttime(date("Y-m-d 00:00:00" , strtotime('-7 days')));
                      $endTime    =   $this->mongo_db->converToMongodttime(date("Y-m-d 23:59:59"));

                      $where_sold_orderCountForCheck_binance['application_mode']       =     'live';
                      $where_sold_orderCountForCheck_binance['admin_id']               =     (string)$user['_id'];
                      $where_sold_orderCountForCheck_binance['created_date']           =     ['$gte' => $startTime, '$lte' => $endTime];
                      $where_sold_orderCountForCheck_binance['is_sell_order']          =     'sold';
                      $where_sold_orderCountForCheck_binance['status']                 =     'FILLED';
                      $where_sold_orderCountForCheck_binance['resume_status']          =     ['$exists' => false];
                      $where_sold_orderCountForCheck_binance['cost_avg']               =     ['$exists' => false];
                      $where_sold_orderCountForCheck_binance['cavg_parent']            =     ['$exists' => false];

                      $lthOpenCountForCheck_binance['created_date']                    =     ['$gte' => $startTime, '$lte' => $endTime];
                      $lthOpenCountForCheck_binance['admin_id']                        =     (string)$user['_id'];
                      $lthOpenCountForCheck_binance['application_mode']                =     'live';
                      $lthOpenCountForCheck_binance['status']['$nin']                  =     ['credentials_ERROR','canceled_ERROR','error' ,'new', 'new_ERROR', 'canceled', 'pause', 'submitted_buy', 'fraction_submitted_buy'];
                      $lthOpenCountForCheck_binance['is_sell_order']                   =     ['$ne' => 'sold'];
                      $lthOpenCountForCheck_binance['trigger_type']                    =     "barrier_percentile_trigger";
                      $lthOpenCountForCheck_binance['resume_status']                   =     ['$exists' => false]; 
                      $lthOpenCountForCheck_binance['cavg_parent']                     =     ['$exists' => false];
                      $lthOpenCountForCheck_binance['count_avg_order']                 =     ['$exists' => false];

                      $soldCount =  $custom->buy_orders->count($lthOpenCountForCheck_binance);
                      $buyCount  =  $custom->sold_buy_orders->count($where_sold_orderCountForCheck_binance);

                      $array_update['totalbuySellOrdersCountWithinSavenDays'] =  (float) ($soldCount + $buyCount) ;

                      // echo "<br>last 7 days count orders: ".($soldCount + $buyCount);

                      // get user limit buy history 
                      $agregateHistoryBinance = [
                        [
                          '$match' => [
                            'user_id' => (string)$user['_id']
                          ]
                        ],

                        [
                          '$project' => [
                            '_id'                           =>  '$_id',
                            'daily_bought_btc_usd_worth'    =>  '$daily_bought_btc_usd_worth',
                            'BTCTradesTodayCount'           =>  '$BTCTradesTodayCount',
                            'daily_bought_usdt_usd_worth'   =>  '$daily_bought_usdt_usd_worth',
                            'USDTTradesTodayCount'          =>  '$USDTTradesTodayCount',
                            'dailyTradeableUSDT_usd_worth'  =>  '$dailyTradeableUSDT_usd_worth',
                            'dailyTradeableBTC_usd_worth'   =>  '$dailyTradeableBTC_usd_worth',
                            'created'                       =>  '$created_date',
                            'dailyTradesExpectedBtc'        =>  '$dailyTradesExpectedBtc',
                            'dailyTradesExpectedUsdt'       =>  '$dailyTradesExpectedUsdt'
                          ]
                        ],

                        [
                          '$sort'  => ['created_date' => -1],
                        ],
                        ['$limit' => 8]
                      ];

                      $dailyReturnHistoryBinance         =   $custom->$dailyTradeLimitCollectionHistoryBinance->aggregate($agregateHistoryBinance);
                      $dailyReturnHistoryResponseBinance =   iterator_to_array($dailyReturnHistoryBinance);
                      $array_update['history']           =   $dailyReturnHistoryResponseBinance;
                      //end history

                      if($totalAccountWorth >= $trade_limit){
                        $array_update['tradeAbleBalanceBaseOnPakge']  =  $trade_limit;
                      }else{
                        $array_update['tradeAbleBalanceBaseOnPakge']  =  $totalAccountWorth;
                      }
                      // check auto trading setting 
                      if(count($atg_returnResponseBinance) > 0 ){
                        $array_update['agt'] = 'yes';
                      }else{
                        $array_update['agt'] = 'no';
                      }

                      echo "<pre>";print_r($array_update);

                      $update_where['username'] = $user['username'];
                    
                      $upsert['upsert'] = true;
                      $custom->$collection_nameBinance->updateOne($update_where, ['$set'=> $array_update], $upsert);

                      $array_update_in_user_colection['is_modified_actual_report'] = $current_time_date;
                      $search_find['_id']       = $this->mongo_db->mongoId((string)$user['_id']);
                      $search_find['username']  = $user['username'];
                      $this->mongo_db->where($search_find);
                      $this->mongo_db->set($array_update_in_user_colection); 
                      $this->mongo_db->update('users');
                    } //end loop
                  }//end if
                }// end cron function


                public function monthly_calculation_user_kraken(){

                  $buyCollectionNamekraken                =   'buy_orders_kraken';
                  $soldCollectionNamekraken               =   'sold_buy_orders_kraken';
                  $marketPriceCollectionkraken            =   'market_prices_kraken';
                  $collection_namekraken                  =   'user_investment_kraken';
                  $userWalletCollectionkraken             =   'user_wallet_kraken';
                  $atgCollectionNamekraken                =   'auto_trade_settings_kraken';
                  $dailyTradeLimitCollectionkraken        =   'daily_trade_buy_limit_kraken'; 
                  $dailyTradeLimitCollectionHistorykraken =   'daily_trade_buy_limit_history_kraken';
                  $exchangeNamekraken                     =   'kraken';
                  $credentialVarificationkraken           =   'kraken_credentials';
                  
                  $price_search['coin'] = 'BTCUSDT';
                  $this->mongo_db->where($price_search);
                  $priceseskraken = $this->mongo_db->get($marketPriceCollectionkraken);
                  $final_priceskraken = iterator_to_array($priceseskraken);
                  $btcusdt = $final_priceskraken[0]['price'];

                  $current_date_time =  date('Y-m-d H:i:s');
                  $current_time_date =  $this->mongo_db->converToMongodttime($current_date_time);

                  $next_date =  date('Y-m-d H:i:s', strtotime('-4 hours'));   // run this on 27 date and then run after 1 month
                  $pre_time_date =  $this->mongo_db->converToMongodttime($next_date);

                  if(!empty($this->input->get())){
                    $whereUser['username'] = $this->input->get('userName');
                  }else{
                    $where1['is_modified_actual_report_kraken'] = ['$lte'=>$pre_time_date];
                    $where2['is_modified_actual_report_kraken'] = ['$exists' => false];

                    $whereUser['$or'] = [$where1, $where2];
                    $whereUser['application_mode'] = ['$in'=> ['both', 'live']];
                  } 

                  $getUsers = [
                    [
                      '$match' => $whereUser
                    ],
                    [
                      '$sort' =>['is_modified_actual_report_kraken'=> -1],
                    ],
                    ['$limit'=> 5]
                  ];
                  $custom = $this->mongo_db->customQuery(); 
                  $user_return_collectiokraken = $custom->users->aggregate($getUsers);
                  $user_return_detailkraken = iterator_to_array($user_return_collectiokraken);
                  // unset($user_return_collectio);
                  if(count($user_return_detailkraken) > 0){
                    foreach($user_return_detailkraken as $user){    
                      $where_credential['user_id'] = (string)$user['_id'];

                      $user_returnkraken         = $custom->$credentialVarificationkraken->find($where_credential);
                      $user_returnResponsekraken = iterator_to_array($user_returnkraken);
                      if(count($user_returnResponsekraken)> 0){
                        $openkraken['admin_id']                 =  (string)$user['_id'];
                        $openkraken['application_mode']         =  'live';
                        $openkraken['status']                   =  ['$in' => ['FILLED', 'FILLED_ERROR','SELL_ID_ERROR']];
                        $openkraken['is_sell_order']            =  'yes';
                        $openkraken['is_lth_order']             =  ['$ne'=> 'yes'];
                        $openkraken['resume_status']            =  ['$exists' => false]; 
                        $openkraken['cavg_parent']              =  ['$exists' => false];
                        $openkraken['count_avg_order']          =  ['$exists' => false];
                        $openkraken['parent_status']            =  ['$exists' => false];
                        $openkraken['trigger_type']             =  "barrier_percentile_trigger";
                        $openkraken['resume_status']['$ne']     =  'completed';
                        $openkraken['cost_avg']                 =  ['$nin' => ['yes', 'taking_child', 'completed']];
                        $openkraken['move_to_cost_avg']['$ne']  =  'yes';
                        
                        $retun_orders_openkraken            =  $custom->$buyCollectionNamekraken->find($openkraken);
                        $order_return_response_openkraken   =  iterator_to_array($retun_orders_openkraken);
                        // unset($retun_orders_open);
                        $open_btckraken       = 0;
                        $open_usdtkraken      = 0;
                        $openBTCSUDTkraken    = 0;
                        $openBTCSUDTkrakenQty = 0;

                        if(count($order_return_response_openkraken) > 0){
                          foreach($order_return_response_openkraken as $open){
                            $coin_names = substr($open['symbol'], -3);                          
                            if($coin_names == 'BTC' && $open['symbol'] != 'BTCUSDT'){

                              $open_btckraken += $open['purchased_price'] * $open['quantity']; 
                            }elseif($coin_names == 'SDT' && $open['symbol'] != 'BTCUSDT'){
                              
                              $open_usdtkraken += $open['purchased_price'] * $open['quantity']; 
                            }elseif($open['symbol'] == 'BTCUSDT'){
                              
                              $openBTCSUDTkraken += $open['purchased_price'] * $open['quantity'];
                              $openBTCSUDTkrakenQty += $open['quantity'];
                            }
                          }
                        }
                        $open_balance_convertedkraken = 0;
                        $openTotalBtckraken = 0;
                        if($open_btckraken > 0){
                          $openTotalBtckraken = $open_btckraken;
                          $open_balance_convertedkraken = convert_btc_to_usdt($open_btckraken);  // helper function
                        }
                        //end open orders calculation 

                        //lth order calculation
                        $lthkraken['admin_id']              =   (string)$user['_id'];
                        $lthkraken['application_mode']      =   'live';
                        $lthkraken['status']                =   ['$in' => ['LTH', 'LTH_ERROR']];
                        $lthkraken['is_sell_order']         =   'yes';
                        $lthkraken['trigger_type']          =    "barrier_percentile_trigger";
                        $lthkraken['lth_functionality']     =   'yes';
                        $lthkraken['resume_status']         =   ['$exists' => false]; 
                        $lthkraken['cost_avg']              =   ['$nin' => ['yes', 'taking_child', 'completed']];
                        $lthkraken['cavg_parent']           =   ['$exists' => false];

                        $retun_orders_lthkraken           =   $custom->$buyCollectionNamekraken->find($lthkraken);
                        $order_return_response_lthkraken  =   iterator_to_array($retun_orders_lthkraken);
                        // unset($retun_orders_lth);

                        $lth_btckraken = 0;
                        $lth_usdtkraken = 0;
                        $lthBTCSUDTkraken = 0;
                        $lthBTCSUDTkrakenQty = 0;
                        if(count($order_return_response_lthkraken) > 0){
                          foreach($order_return_response_lthkraken as $lth){
                            
                            $coin_names = substr($lth['symbol'], -3);                          
                            if($coin_names == 'BTC' && $lth['symbol'] != 'BTCUSDT'){
                            
                              $lth_btckraken += $lth['purchased_price'] * $lth['quantity']; 
                            }elseif($coin_names == 'SDT' && $lth['symbol'] != 'BTCUSDT'){
                            
                              $lth_usdtkraken += $lth['purchased_price'] * $lth['quantity']; 
                            }elseif($lth['symbol'] == 'BTCUSDT'){
                            
                              $lthBTCSUDTkraken += $lth['purchased_price'] * $lth['quantity'];
                              $lthBTCSUDTkrakenQty += $lth['quantity'];
                            }
                          }
                        }

                        $lth_balance_convertedkraken = 0;
                        $lthBTCTotalkraken = 0;  
                        if($lth_btckraken > 0){
                          $lthBTCTotalkraken = $lth_btckraken;
                          $lth_balance_convertedkraken = convert_btc_to_usdt($lth_btckraken);  // helper function
                        }
                        //end lth orders calculation

                        //cost avg orders calculation 
                        $costAvgOrderkraken['admin_id']          =  (string)$user['_id'];
                        $costAvgOrderkraken['application_mode']  =  'live';
                        $costAvgOrderkraken['trigger_type']      =  "barrier_percentile_trigger";
                        $costAvgOrderkraken['is_sell_order']     =  'yes';
                        $costAvgOrderkraken['is_lth_order']      =  ['$ne'=> 'yes'];
                        $costAvgOrderkraken['resume_status']     =  ['$exists' => false]; 
                        $costAvgOrderkraken['cost_avg']          =  ['$in' => ['yes', 'taking_child']];
                        $costAvgOrderkraken['status']            =  'FILLED';
                        
                        $retunCostAvgOrderskraken            =  $custom->$buyCollectionNamekraken->find($costAvgOrderkraken);
                        $orderReturnResponseCostkraken       =  iterator_to_array($retunCostAvgOrderskraken);

                        // unset($retunCostAvgOrders);

                        $costAvgBtckraken      = 0;
                        $costAvgUsdtkraken     = 0;
                        $costAcgBTCSUDTkraken  = 0;
                        $costAcgBTCSUDTkrakenQty = 0;

                        if(count($orderReturnResponseCostkraken) > 0){
                          foreach($orderReturnResponseCostkraken as $costAvg){
                            $coin_names = substr($costAvg['symbol'], -3);                          

                            if($coin_names == 'BTC' && $costAvg['symbol'] != 'BTCUSDT'){

                              $costAvgBtckraken += $costAvg['purchased_price'] * $costAvg['quantity']; 
                            }elseif($coin_names == 'STD' && $costAvg['symbol'] != 'BTCUSDT'){
                              
                              $costAvgUsdtkraken += $costAvg['purchased_price'] * $costAvg['quantity']; 
                            }elseif($costAvg['symbol'] == 'BTCUSDT'){
                              
                              $costAcgBTCSUDTkraken += $costAvg['purchased_price'] * $costAvg['quantity'];
                              $costAcgBTCSUDTkrakenQty += $costAvg['quantity'];
                            }
                          }    
                        }
                        
                        $costAvgConvertBalancekraken  = 0;
                        $costAvgTotalBtckraken        = 0;
                        if($costAvgBtckraken > 0){
                          $costAvgTotalBtckraken = $costAvgBtckraken;
                          $costAvgConvertBalancekraken = convert_btc_to_usdt($costAvgBtckraken);  // helper function
                        }
                        //end Cost Average orders calculation 

                        //1 month old order profit/loss calculation 
                        $current = $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'));
                        $current_date = date('Y-m-d H:i:s', strtotime('-1 month'));
                        $mongo_time = $this->mongo_db->converToMongodttime($current_date);

                        $lthOpenkraken['created_date']         =  ['$gte' => $mongo_time, '$lte' => $current];
                        $lthOpenkraken['admin_id']             =  (string)$user['_id'];
                        $lthOpenkraken['application_mode']     =  'live';
                        $lthOpenkraken['status']['$in']        =  ['LTH', 'FILLED'];
                        $lthOpenkraken['is_sell_order']        =  ['$ne' => 'sold'];
                        $lthOpenkraken['trigger_type']         =  "barrier_percentile_trigger";
                        $lthOpenkraken['resume_status']        =  ['$exists' => false]; 
                        $lthOpenkraken['cavg_parent']          =  ['$exists' => false];
                        $lthOpenkraken['count_avg_order']      =  ['$exists' => false];

                        $retunOrdersLTHkraken                  =  $custom->$buyCollectionNamekraken->find($lthOpenkraken);
                        $orderReturnResponseLTHkraken          =  iterator_to_array($retunOrdersLTHkraken);

                        echo"<br> lth and open orders = ".count($orderReturnResponseLTHkraken);
                        // unset($retunOrdersLTH);
                        
                        $btckraken = 0;
                        $usdtkraken = 0;
                        $BTCSUDTkraken = 0;
                        if(count($orderReturnResponseLTHkraken) > 0){
                          foreach($orderReturnResponseLTHkraken as $calculation){

                            $coin_names = substr($calculation['symbol'], -3);                          
                            if($coin_names == 'BTC' && $calculation['symbol'] != 'BTCUSDT'){

                              $btckraken += $calculation['purchased_price'] * $calculation['quantity'];
                            }elseif($coin_names == 'STD' && $calculation['symbol'] != 'BTCUSDT'){
                            
                              $usdtkraken += $calculation['purchased_price'] * $calculation['quantity'];
                            }elseif($calculation['symbol'] == 'BTCUSDT'){
                            
                              $BTCSUDTkraken += $calculation['purchased_price'] * $calculation['quantity'];
                            }
                          }//end foreach
                        }//end if
                        //end 1 month old orders calculation 

                        //sold orders count get 
                        
                        $soldkraken['admin_id']             = (string)$user['_id'];
                        $soldkraken['application_mode']     = 'live';
                        $soldkraken['is_sell_order']        = 'sold';
                        $soldkraken['trigger_type']         =  "barrier_percentile_trigger";
                        $soldkraken['status']               = 'FILLED';
                        $soldkraken['resume_status']        =  ['$exists' => false]; 
                        $soldkraken['cost_avg']             =  ['$nin' => ['yes', 'taking_child','completed']];
                        $soldkraken['cavg_parent']          =  ['$exists' => false];

                        $order_returnkraken = $custom->$soldCollectionNamekraken->count($soldkraken);
                        // end sold orders count get

                        //get last trade buy time 
                        $pipelinekraken = [
                          [
                            '$match' =>[
                              'application_mode'   =>  'live',
                              'admin_id'           =>  (string)$user['_id'],
                              'is_sell_order'      =>  'yes',
                              'status'             =>  ['$in'=>['LTH','FILLED']],
                              'resume_status'      =>  ['$exists' => false],
                              'trigger_type'       =>  "barrier_percentile_trigger",
                              'cost_avg'           =>  ['$nin' => ['yes', 'taking_child', 'completed']],
                              'cavg_parent'        =>  ['$exists' => false]
                            ],
                          ],
                          
                            [
                              '$sort'    =>  ['buy_date'=> -1],
                            ],
                            ['$limit'=>1]
                        ];
                        $result_buykraken   =   $custom->$buyCollectionNamekraken->aggregate($pipelinekraken);
                        $reskraken          =   iterator_to_array($result_buykraken);
                        // end last order buy time

                        //get last trade sell time 
                        $pipeline_2kraken= [
                          [
                            '$match' =>[
                              'application_mode'    =>  'live',
                              'admin_id'            =>  (string)$user['_id'],
                              'is_sell_order'       =>  'sold',
                              'status'              =>  'FILLED',
                              'trigger_type'       =>  "barrier_percentile_trigger",
                              'resume_status'       =>  ['$exists' => false],
                              'cost_avg'            =>  ['$nin' => ['yes', 'taking_child', 'completed']],
                              'cavg_parent'         =>  ['$exists' => false]
                            ],
                          ],
                          [
                            '$sort'    =>  ['sell_date'=> -1],
                          ],
                          ['$limit'=>1]
                        ];
                      
                        $result_soldkraken  =   $custom->$soldCollectionNamekraken->aggregate($pipeline_2kraken);
                        $res_soldkraken     =   iterator_to_array($result_soldkraken);
                        // end last trade sell time 

                        //get user wallet balance
                        $where_balance['user_id'] =   (string)$user['_id'];
                        $this->mongo_db->where($where_balance);
                        $datakraken1              =   $this->mongo_db->get($userWalletCollectionkraken);
                        $balance_reskraken        =   iterator_to_array($datakraken1);

                        // echo"<pre>";print_r($balance_reskraken);

                        $total_usdt_balance_converted_totalkraken =   0;
                        $total_usdt_balancekraken                 =   0;
                        $bnbkraken                                =   0;   

                        foreach( $balance_reskraken as $balance){
                          if($balance['coin_symbol'] == 'BTC'){
                        
                            $total_btc_balancekraken = $balance['coin_balance'];
                            $total_usdt_balance_converted_totalkraken = convert_btc_to_usdt($balance['coin_balance']); //helper function for btc to usdt amount     
                          }elseif($balance['coin_symbol'] == 'USDT'){
                        
                            $total_usdt_balancekraken = $balance['coin_balance'];
                          }elseif($balance['coin_symbol'] == 'BNB'){
                        
                            $bnbkraken =  $balance['coin_balance'];
                          }//end else if
                  
                        } // end loop

                        //end get user wallet balance 

                        //get user pakage details 
                        $handshake = $this->GetRandomAPIaccessToken(); //get api parameter
                        $parameter = array(
                          'handshake' =>  $handshake,
                          'user_id'   => (string)$user['_id'],
                        );
                        $curl = curl_init();
                        $jsondata = json_encode($parameter);
                        curl_setopt_array($curl, array(
                          CURLOPT_URL => "https://users.digiebot.com/cronjob/GetUserSubscriptionDetails",
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_ENCODING => "",
                          CURLOPT_MAXREDIRS => 10,
                          CURLOPT_TIMEOUT => 0,
                          CURLOPT_FOLLOWLOCATION => true,
                          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                          CURLOPT_CUSTOMREQUEST => "POST",
                          CURLOPT_POSTFIELDS =>$jsondata,
                          CURLOPT_HTTPHEADER => array(
                            "Content-Type: application/json"
                          ),
                        ));
                        $responsekraken = curl_exec($curl);
                        curl_close($curl);
                        $responce_Datakraken = json_decode($responsekraken);
                        $trade_limit = 0;

                        if($responce_Datakraken->trade_limit == null || $responce_Datakraken->trade_limit == 'undifined' || $responce_Datakraken->trade_limit== 0 || empty($responce_Datakraken->trade_limit)){
                          $trade_limit = 500;
                        }else{
                            $trade_limit = $responce_Datakraken->trade_limit;
                        }                    

                        //get user points detail
                        $playLoadUserId = array(
                          'user_id'   => (string)$user['_id'],
                        );
                        $curl = curl_init();
                        $jsondataPayLoad = json_encode($playLoadUserId);
                        curl_setopt_array($curl, array(
                          CURLOPT_URL => "https://users.digiebot.com/cronjob/GetUserTotalPoints",
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_ENCODING => "",
                          CURLOPT_MAXREDIRS => 10,
                          CURLOPT_TIMEOUT => 30,
                          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                          CURLOPT_CUSTOMREQUEST => "POST",
                          CURLOPT_POSTFIELDS => $jsondataPayLoad,
                          CURLOPT_HTTPHEADER => array(
                            "authorization: Basic cG9pbnRTdXBwbHk6NGU0NmQ5OWFjMjJhNGIwYWJlNTc2OGE3OGVlODdiOGM=",
                            "cache-control: no-cache",
                            "content-type: application/json",
                            "postman-token: b5711a89-ed67-92ba-25a8-685cfdcee2ec"
                          ),
                        ));
                        $responsekraken1 = curl_exec($curl);
                        $err = curl_error($curl);
                        curl_close($curl);
                        $totalPointsDetailskraken = json_decode($responsekraken1);
                        if($totalPointsDetailskraken->status == 200 || $totalPointsDetailskraken->message == "Data Found!"){
                          $userTotalPointsApiResponsekraken =  $totalPointsDetailskraken->points;
                        }else{
                          $userTotalPointsApiResponsekraken = 0;
                        }
                        //end user points details 

                        // Auto trade Generator setting check 
                        $where_agt['user_id']           =   (string)$user['_id'];
                        $where_agt['application_mode']  =   'live';
                        $atg_returnkraken               =   $custom->$atgCollectionNamekraken->find($where_agt);
                        $atg_returnResponsekraken       =   iterator_to_array($atg_returnkraken);
                        // unset($atg_return);

                        $btcInvestPercentagekraken            =   $atg_returnResponsekraken[0]['step_4']['btcInvestPercentage'];
                        $usdtInvestPercentagekraken           =   $atg_returnResponsekraken[0]['step_4']['usdtInvestPercentage'];
                        $dailTradeAbleBalancePercentagekraken =   $atg_returnResponsekraken[0]['step_4']['dailTradeAbleBalancePercentage'];

                        $customBtcPackage   =   $atg_returnResponsekraken[0]['step_4']['customBtcPackage'];
                        $customUsdtPackage  =   $atg_returnResponsekraken[0]['step_4']['customUsdtPackage'];
                        // End Auto trade Generator setting check

                        //get user daily limit 
                        $where_daily_limitkraken['user_id'] =  (string)$user['_id'];
                        $daily_returnkraken           =   $custom->$dailyTradeLimitCollectionkraken->find($where_daily_limitkraken);
                        $daily_returnResponsekraken   =   iterator_to_array($daily_returnkraken);                        
                        //end get user daily limit 
                        
                        //sold avg calculate 
                        $where_sold_orderkraken['application_mode']       =  'live';
                        $where_sold_orderkraken['admin_id']               =  (string)$user['_id'];
                        $where_sold_orderkraken['created_date']           =  ['$gte' => $mongo_time, '$lte' => $current];
                        $where_sold_orderkraken['is_sell_order']          =  'sold';
                        // $where_sold_orderkraken['trigger_type']           =  "barrier_percentile_trigger";
                        $where_sold_orderkraken['status']                 =  'FILLED';
                        $where_sold_orderkraken['resume_status']          =  ['$exists' => false];
                        $where_sold_orderkraken['cost_avg']               =  ['$exists' => false];
                        $where_sold_orderkraken['cavg_parent']            =  ['$exists' => false];

                        $this->mongo_db->where($where_sold_orderkraken);
                        $datakraken           =   $this->mongo_db->get($soldCollectionNamekraken);
                        $total_sold_reckraken =   iterator_to_array($datakraken);

                        $sold_purchase_pricekraken  =   0;                          
                        $per_trade_soldkraken       =   0;
                        $avg_soldkraken             =   0;
                        $investProfitBTCkraken      =   0;
                        $investProfitUSDTkraken     =   0;
                        $usdtInvestmentCalkraken    =   0;
                        $btcInvestmentCalkraken     =   0;

                        if(count($total_sold_reckraken) > 0){
                          foreach($total_sold_reckraken as $sold_orders){
                            $sold_purchase_pricekraken += (float) ($sold_orders['market_sold_price'] - $sold_orders['purchased_price']) / $sold_orders['purchased_price'];		

                            $coin_names = substr($sold_orders['symbol'], -3);                          

                            if($coin_names == 'BTC'){
                              
                              $btckraken += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                              $btcInvestmentCalkraken += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                              $investProfitBTCkraken += $sold_orders['market_sold_price'] * $sold_orders['quantity'];
                            }elseif($coin_names == 'SDT'){
                            
                              $usdtInvestmentCalkraken += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                              $usdtkraken += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                              $investProfitUSDTkraken += $sold_orders['market_sold_price'] * $sold_orders['quantity'];
                            }
                          } //end check
                        }//end foreach

                        $convertkraken = 0;
                        if($btckraken > 0){
                          $convertkraken = $btcusdt * $btckraken;
                        }
                        if($investProfitBTCkraken > 0){
                          $investProfitBTCkraken = $btcusdt * $investProfitBTCkraken;
                        }
                        if($btcInvestmentCalkraken > 0){
                          $btcInvestmentCalkraken = $btcusdt * $btcInvestmentCalkraken;
                        }
                        $actualProfitLastMonthInSoldOrderskraken = ($investProfitUSDTkraken + $investProfitBTCkraken) - ($btcInvestmentCalkraken + $usdtInvestmentCalkraken);
                        $per_trade_soldkraken = (float) $sold_purchase_pricekraken * 100;
                        
                        if(count($total_sold_reckraken) > 0){
                          $avg_soldkraken = ($per_trade_soldkraken / count($total_sold_reckraken));
                        }else{
                          $avg_soldkraken = 0;
                        }

                        //end 1 month sold orders avg calculation 
    

                        $response  = calculateManulOrdersInvestment($user['_id'], 'kraken');
  
                        $btcConverted = 0;
                        if($response['btcInvest'] > 0){
                          $btcConverted   = $btcusdt * $response['btcInvest'];
                        }
                        $totalManulInvest = ($response['usdtInvest'] + $btcConverted );

                        $manulOrderBtcInvest    =    $response['btcInvest'];
                        $manulOrderUsdtInvest   =    $response['usdtInvest'];
                        
                        //consumed points get 
                        $agregatekraken = [
                          [
                            '$match' => [
                              'user_id' => (string)$user['_id'],
                              'action'  => 'deduct'
                            ],
                          ],
                            [
                              '$group' => [
                                '_id' => 1,
                                'totalPoints' => ['$sum' => '$points_consumed']
                              ],
                            ],
                        ];
                        $dataResponcekraken   =   $custom->trading_points_history->aggregate($agregatekraken);
                        $responsekraken       =   iterator_to_array($dataResponcekraken);
                        //end consumed point get 


                        //get user limit buy and calculate trading points 
                        $conditionGetHistoryRecordkraken      =   ['sort' => ['created_date' => -1], 'limit' => 1];
                        $getPreviousHistoryLimit['user_id']   =   (string)$user['_id'];
                        $getUserLimitHistorykraken            =   $custom->$dailyTradeLimitCollectionHistorykraken->find($getPreviousHistoryLimit, $conditionGetHistoryRecordkraken);
                        $gotDataReturnHistorykraken           =   iterator_to_array($getUserLimitHistorykraken);
                        // unset($getUserLimitHistory);



                        //canculating today buy percentage
                        if($daily_returnResponsekraken[0]['daily_bought_btc_usd_worth'] == 0) {
                          
                          $todayBuyPercentagebtckraken = 0;
                        }elseif($daily_returnResponsekraken[0]['daily_bought_btc_usd_worth'] == $daily_returnResponsekraken[0]['dailyTradeableBTC_usd_worth']){  
                          
                          $todayBuyPercentagebtckraken = 100;
                        }else{
                          
                          $todayBuyPercentagebtckraken = ($daily_returnResponsekraken[0]['daily_bought_btc_usd_worth'] / $daily_returnResponsekraken[0]['dailyTradeableBTC_usd_worth'])*100;
                        } 



                        if($daily_returnResponsekraken[0]['daily_bought_usdt_usd_worth'] == 0) {
                          
                          $todayBuyPercentageusdtkraken = 0;
                        }elseif($daily_returnResponsekraken[0]['daily_bought_usdt_usd_worth'] == $daily_returnResponsekraken[0]['dailyTradeableUSDT_usd_worth']){  
                          
                          $todayBuyPercentageusdtkraken = 100;
                        }else{
                          
                          $todayBuyPercentageusdtkraken = ($daily_returnResponsekraken[0]['daily_bought_usdt_usd_worth'] / $daily_returnResponsekraken[0]['dailyTradeableUSDT_usd_worth'])*100;
                        } 
                        //end

                        //canculating previous day buy percentage
                        if($gotDataReturnHistorykraken[0]['daily_bought_btc_usd_worth'] == 0){
                          
                          $previousBuyPercentagebtckraken = 0;
                        }elseif($gotDataReturnHistorykraken[0]['dailyTradeableBTC_usd_worth'] == $gotDataReturnHistorykraken[0]['daily_bought_btc_usd_worth'] && $gotDataReturnHistorykraken[0]['daily_bought_btc_usd_worth'] !=0 && $gotDataReturnHistorykraken[0]['dailyTradeableBTC_usd_worth'] !=0){
                          
                          $previousBuyPercentagebtckraken = 100;
                        }else{
                          
                          $previousBuyPercentagebtckraken = ($gotDataReturnHistorykraken[0]['daily_bought_btc_usd_worth']/ $gotDataReturnHistorykraken[0]['dailyTradeableBTC_usd_worth'] )*100;
                        }

                        if($gotDataReturnHistorykraken[0]['daily_bought_usdt_usd_worth'] == 0){
                          
                          $previousBuyPercentageusdtkraken = 0;
                        }elseif($gotDataReturnHistorykraken[0]['dailyTradeableUSDT_usd_worth'] == $gotDataReturnHistorykraken[0]['daily_bought_usdt_usd_worth'] && $gotDataReturnHistorykraken[0]['daily_bought_usdt_usd_worth'] !=0 && $gotDataReturnHistorykraken[0]['dailyTradeableUSDT_usd_worth'] !=0){
                          
                          $previousBuyPercentageusdtkraken = 100;
                        }else{
                          
                          $previousBuyPercentageusdtkraken = ($gotDataReturnHistorykraken[0]['daily_bought_usdt_usd_worth']/ $gotDataReturnHistorykraken[0]['dailyTradeableUSDT_usd_worth'] )*100;
                        }
                        //end
                        $avaliableBtcConvertedBalance = ($total_btc_balancekraken > 0) ? convert_btc_to_usdt($total_btc_balancekraken) : 0;  // helper function

                        $totalUSDTopenNew = (float)($total_usdt_balancekraken + $lth_usdtkraken + $lthBTCSUDTkraken + $open_usdtkraken + $openBTCSUDTkraken + $costAvgUsdtkraken + $costAcgBTCSUDTkraken);
                        $totalBtcConverted = (float)($lth_balance_convertedkraken  + $costAvgConvertBalancekraken + $avaliableBtcConvertedBalance + $total_btc_balancekraken);  

                        $totalUSDTLTH  =  ($lth_usdtkraken + $lthBTCSUDTkraken );
                        $totalUSDTOpen =  ($open_usdtkraken + $openBTCSUDTkraken);
                        $costAvgUsdt   =  ($costAvgUsdtkraken + $costAcgBTCSUDTkraken);

                        $lthBalanceBtcpercentageKraken  = calculatePercentage($lthBTCTotalkraken, $customBtcPackage,  $totalBtcConverted);
                        $lthBalanceUsdtpercentageKraken = calculatePercentage($totalUSDTLTH, $customUsdtPackage,  $totalUSDTopenNew);


                        $openBalanceBtcpercentageKraken  = calculatePercentage($openTotalBtckraken, $customBtcPackage,  $totalBtcConverted);
                        $openBalanceUsdtpercentageKraken = calculatePercentage($totalUSDTOpen, $customUsdtPackage,  $totalUSDTopenNew);


                        $costAvgBalanceBtcpercentageBinance  = calculatePercentage($costAvgTotalBtckraken, $customBtcPackage,  $totalBtcConverted);
                        $costAvgBalanceUsdtpercentageBinance = calculatePercentage($costAvgUsdt, $customUsdtPackage,  $totalUSDTopenNew);

                        // echo "<br>total_usdt_balance_converted_total:".$total_usdt_balance_converted_totalkraken.' :total_usdt_balance: '.$totalUSDTopenNew." : lthBTCSUDT: ".$lthBTCSUDTkraken. ": openBTCSUDT: " .$openBTCSUDTkraken;
                        //end get user limit buy and trading calculate points 

                        //get active parent details 
                        $activeParentskraken['admin_id']          =    (string)$user['_id'];
                        $activeParentskraken['application_mode']  =   'live';
                        $activeParentskraken['parent_status']     =   'parent'; 
                        $activeParentskraken['status']            =   'new';
                        $activeParentskraken['pause_status']      =   'play';
                        $activeParentsReturnkraken = $custom->$buyCollectionNamekraken->count($activeParentskraken);
                        //end get active parent details 

                        //get taking orders parent 
                        $takingOrderkraken['admin_id']          = (string)$user['_id'];
                        $takingOrderkraken['application_mode']  = 'live';
                        $takingOrderkraken['parent_status']     = 'parent'; 
                        $takingOrderkraken['status']            = 'takingOrder';
                        $takingOrderkraken['pause_status']      = 'play';
                        $takingOrderReturnkraken = $custom->$buyCollectionNamekraken->count($takingOrderkraken);
                        //end get taking order parent 

                        // last month consumed points get
                        $startTime = $this->mongo_db->converToMongodttime(date('Y-m-1 00:00:00'));
                        $endTime   = $this->mongo_db->converToMongodttime(date('Y-m-d 23:59:59'));
                        $getConsumedPoints['user_id']       = (string)$user['_id'];
                        $getConsumedPoints['created_date']  = [['$gte' => $startTime], ['$lte' => $endTime]];

                        $groupkraken = [
                          [
                            '$match' => [
                              'user_id' => (string)$user['_id'],
                              'created_date' => ['$gte' => $startTime, '$lte' => $endTime] 
                            ]
                          ],
                          [
                          '$group' => [
                            '_id' =>  null,
                            'lastMonthConsumedPoints' => ['$sum' => '$points_consumed']
                            ] 
                          ],
                        ];

                        $lastMonthConsumedPointsQuerykraken  = $custom->trading_points_history->aggregate($groupkraken);
                        $lastMonthConsumedPointsReturnkraken = iterator_to_array($lastMonthConsumedPointsQuerykraken);

                        $totalBalance = 0;
                        $totalBalance = (float) ($total_usdt_balance_converted_totalkraken + $total_usdt_balancekraken) - ($lthBTCSUDTkraken + $openBTCSUDTkraken + $costAcgBTCSUDTkraken);

                        $fivePercentOfTotalBalance = 0;
                        $fivePercentOfTotalBalance = (float) ((5/$totalBalance) *100);
                       

                        $totalAccountWorthkraken = ($costAvgUsdtkraken + $costAcgBTCSUDTkraken + $costAvgConvertBalancekraken + $total_usdt_balancekraken + $total_usdt_balance_converted_totalkraken + $open_balance_convertedkraken + $open_usdtkraken + $lth_balance_convertedkraken + $lth_usdtkraken + $lthBTCSUDTkraken + $openBTCSUDTkraken);
                        
                        $TodayBuyWorth = todayBuyBTCAndUsdt('kraken', (string)$user['_id']);
                        $savenBuyWorth = savenDaysBuyBTCAndUsdt('kraken', (string)$user['_id']);
  
                        $totalBtc       =   $TodayBuyWorth['sold_btc'][0]['invest_btc']  + $TodayBuyWorth['btc'][0]['invest_btc'] ;
                        $totalUsdt      =   $TodayBuyWorth['sold_usdt'][0]['invest_usdt'] + $TodayBuyWorth['usdt'][0]['invest_usdt'] ;
                        $soldTotalBtc   =   $TodayBuyWorth['sold_btc'][0]['invest_btc'];
                        $soldTotalUsdt  =   $TodayBuyWorth['sold_usdt'][0]['invest_usdt'];
                        
                        $savenTotalBtc      =   $savenBuyWorth['sold_btc'][0]['invest_btc']  + $savenBuyWorth['btc'][0]['invest_btc'] ;
                        $savenTotalUsdt     =   $savenBuyWorth['sold_usdt'][0]['invest_usdt'] + $savenBuyWorth['usdt'][0]['invest_usdt'] ;
                        $soldSavenTotalBtc  =   $savenBuyWorth['sold_btc'][0]['invest_btc'] ;
                        $soldSavenTotalUsdt =   $savenBuyWorth['sold_usdt'][0]['invest_usdt'];

                        //calculate btc close ratio saven days
                        if($savenTotalBtc == 0 || $soldSavenTotalBtc == 0){

                          $savenCloseRatioBtc = 0;
                        }elseif($savenTotalBtc == $soldSavenTotalBtc){
          
                          $savenCloseRatioBtc = 100;
                        }else{
            
                          $savenCloseRatioBtc = ($soldSavenTotalBtc / $savenTotalBtc ) * 100;
                        }

                        //calculate usdt close ratio saven days
                        if($savenTotalUsdt == 0 || $soldSavenTotalUsdt == 0){
                        
                          $savenCloseRatioUsdt = 0 ;
                        }elseif($savenTotalUsdt == $soldSavenTotalUsdt){
            
                          $savenCloseRatioUsdt = 100;
                        }else{
            
                          $savenCloseRatioUsdt = ($soldSavenTotalUsdt / $savenTotalUsdt ) * 100;
                        }

                        //calculate btc close ratio
                        if($totalBtc == 0 || $soldTotalBtc == 0){
                        
                          $todayCloseRatioBtc = 0 ;
                        }elseif($totalBtc == $soldTotalBtc){
            
                          $todayCloseRatioBtc = 100;
                        }else{
            
                          $todayCloseRatioBtc = ($soldTotalBtc / $totalBtc ) * 100;
                        }

                        //calculate usdt close ratio
                        if($totalUsdt == 0 || $soldTotalUsdt == 0 ){

                          $todayCloseRatioUsdt = 0;
                        }elseif($totalUsdt == $soldTotalUsdt){
            
                          $todayCloseRatioUsdt = 100;
                        }else{
            
                          $todayCloseRatioUsdt = (($soldTotalUsdt / $totalUsdt ) * 100);
                        }

                        $array_update = array(

                          'savenCloseRatioBtc'                =>    (float)$savenCloseRatioBtc,
                          'savenCloseRatioUsdt'               =>    (float)$savenCloseRatioUsdt,
                          'todayCloseRatioBtc'                =>    (float)$todayCloseRatioBtc,
                          'todayCloseRatioUsdt'               =>    (float)$todayCloseRatioUsdt,
                          'todaybuyWorth_BTC'                 =>    $totalBtc,
                          'todaybuyWorth_USDT'                =>    $totalUsdt,
                          'soldTodaybuyWorth_BTC'             =>    $soldTotalBtc, 
                          'soldTodaybuyWorth_USDT'            =>    $soldTotalUsdt,
                          'savenDayBuyWorth_BTC'              =>    $savenTotalBtc,
                          'savenDayBuyWorth_USDT'             =>    $savenTotalUsdt,
                          'soldSavenDayBuyWorth_BTC'          =>    $soldSavenTotalBtc,
                          'soldSavenDayBuyWorth_USDT'         =>    $soldSavenTotalUsdt,
                          'first_name'                        =>    $user['first_name'],
                          'last_name'                         =>    $user['last_name'],
                          'profile_pic'                       =>    $user['profile_image'],
                          'btcusdtNegitiveTotal'              =>    ($lthBTCSUDTkrakenQty + $openBTCSUDTkrakenQty + $costAcgBTCSUDTkrakenQty),
                          'username'                          =>    $user['username'],
                          'admin_id'                          =>    (string)  $user['_id'],
                          'costAvgOrder'                      =>    count($orderReturnResponseCostkraken),
                          'costAvgBalance'                    =>    (float)  ($costAvgUsdtkraken + $costAcgBTCSUDTkraken + $costAvgConvertBalancekraken),
                          'costAvgBtcBalance'                 =>    (float)  ($costAvgTotalBtckraken),
                          'costAvgUsdtBalance'                =>    (float)  ($costAvgUsdtkraken + $costAcgBTCSUDTkraken), 
                          'takingOrderParents'                =>    (float)  $takingOrderReturnkraken,
                          'newOrderParents'                   =>    (float)  $activeParentsReturnkraken,
                          'tradingIp'                         =>    (string) $user['trading_ip'],
                          'avg_sold'                          =>    (float)  $avg_soldkraken,
                          'thisMonthConsumedPoints'           =>    (float)$lastMonthConsumedPointsReturnkraken[0]['lastMonthConsumedPoints'],
                          'lastMonthProfitSoldOrders'         =>    $actualProfitLastMonthInSoldOrderskraken,
                          'open_order'                        =>    (float)  count($order_return_response_openkraken),
                          'lth_order'                         =>    (float)  count($order_return_response_lthkraken),
                          'actual_deposit'                    =>    (float)  $totalAccountWorthkraken,
                          'total_balance'                     =>    $totalBalance,
                          'open_balance'                      =>    (float)  ($open_balance_convertedkraken + $open_usdtkraken + $openBTCSUDTkraken),    
                          'lth_balance'                       =>    (float)  ($lth_balance_convertedkraken + $lth_usdtkraken + $lthBTCSUDTkraken), 
                          'avaliableBtcBalance'               =>    (float)  $total_btc_balancekraken,
                          'avaliableUsdtBalance'              =>    (float)  $total_usdt_balancekraken, 
                          // 'openBalancePercentage'             =>    (float)  $openBalancePercentagekraken,
                          'lthBalancePercentage'              =>    (float)($lthBalanceUsdtpercentageKraken + $lthBalanceBtcpercentageKraken),
                          'lth_cost_avg_balance_percentage'   =>    (float)($costAvgBalanceUsdtpercentageBinance + $costAvgBalanceBtcpercentageBinance + $lthBalanceUsdtpercentageKraken + $lthBalanceBtcpercentageKraken),
                          'lthBalanceUsdtpercentage'          =>    (float)$lthBalanceUsdtpercentageKraken ,
                          'lthBalanceBtcpercentage'           =>    (float)$lthBalanceBtcpercentageKraken,
                          'openBalanceUsdtpercentage'         =>    (float)$openBalanceUsdtpercentageKraken ,
                          'openBalanceBtcpercentage'          =>    (float)$openBalanceBtcpercentageKraken,
                          'costAvgBalanceUsdtpercentageBinance'=>   (float)$costAvgBalanceUsdtpercentageBinance ,     
                          'costAvgBalanceBtcpercentageBinance'=>    (float)$costAvgBalanceBtcpercentageBinance,
                          'customBtcPackage'                  =>    $customBtcPackage,
                          'customUsdtPackage'                 =>    $customUsdtPackage,   
                          'joining_date'                      =>    $user['created_date'],
                          'bnb_balance'                       =>    (float)  $bnbkraken,
                          'exchange'                          =>    $exchangeNamekraken,
                          'lth_usdt'                          =>    (float)  ($lth_usdtkraken + $lthBTCSUDTkraken),
                          'open_usdt'                         =>    (float)  ($open_usdtkraken + $openBTCSUDTkraken),
                          'lthBTCTotal'                       =>    (float)  $lthBTCTotalkraken,
                          'openTotalBtc'                      =>    (float)  $openTotalBtckraken,
                          'previousDayLimitWas'               =>    $gotDataReturnHistorykraken[0]['daily_buy_usd_limit'],
                          'previousdayGetCount'               =>    $gotDataReturnHistorykraken[0]['num_of_trades_buy_today'],
                          'previousDayLimitBuy'               =>    $gotDataReturnHistorykraken[0]['daily_buy_usd_worth'], 
                          'invest_amount'                     =>    (float)  ($usdtkraken + $convertkraken),
                          'consumed_points'                   =>    $responsekraken[0]['totalPoints'],
                          'totalPointsApi'                    =>    $userTotalPointsApiResponsekraken,
                          'remainingPoints'                   =>    $userTotalPointsApiResponsekraken - $responsekraken[0]['totalPoints'],
                          'dailyTradeBuyBTCIn$'               =>    (float)  $daily_returnResponsekraken[0]['daily_bought_btc_usd_worth'], 
                          'dailyBtcBuyTradeCount'             =>    (float)  $daily_returnResponsekraken[0]['BTCTradesTodayCount'],
                          'dailyTradeBuyUSDT'                 =>    (float)  $daily_returnResponsekraken[0]['daily_bought_usdt_usd_worth'], 
                          'dailyUSDTBuyTradeCount'            =>    (float)  $daily_returnResponsekraken[0]['USDTTradesTodayCount'],
                          'previousDailyTradeBuyBTCIn$'       =>    (float)  $gotDataReturnHistorykraken[0]['daily_bought_btc_usd_worth'], 
                          'previousDailyBtcBuyTradeCount'     =>    (float)  $gotDataReturnHistorykraken[0]['BTCTradesTodayCount'],  
                          'previousDailyTradeBuyUSDT'         =>    (float)  $gotDataReturnHistorykraken[0]['daily_bought_usdt_usd_worth'], 
                          'previousDailyUSDTBuyTradeCount'    =>    (float)  $gotDataReturnHistorykraken[0]['USDTTradesTodayCount'],
                          'tradingStatus'                     =>    $user['trading_status'],
                          'todayBuyPercentagebtc'             =>    $todayBuyPercentagebtckraken,
                          'todayBuyPercentageusdt'            =>    $todayBuyPercentageusdtkraken,
                          'previousBuyPercentagebtc'          =>    $previousBuyPercentagebtckraken,
                          'previousBuyPercentageusdt'         =>    $previousBuyPercentageusdtkraken,
                          'last_trade_sold'                   =>    $res_soldkraken[0]['sell_date'],
                          'last_trade_buy'                    =>    $reskraken[0]['buy_date'],
                          'month'                             =>    date('m'),
                          'btcInvestPercentage'               =>    $btcInvestPercentagekraken,
                          'usdtInvestPercentage'              =>    $usdtInvestPercentagekraken,
                          'dailTradeAbleBalancePercentage'    =>    $dailTradeAbleBalancePercentagekraken, 
                          'trade_limit'                       =>    (float)  $trade_limit,
                          'last_login_time'                   =>    $user['last_login_datetime'], 
                          'sold_trades'                       =>    $order_returnkraken ,
                          'modified_time'                     =>    $current_time_date,
                          'per_day_limit'                     =>    (float)  $daily_returnResponsekraken[0]['daily_buy_usd_limit'],
                          'dailyTradeableUSDTLimit'           =>    (float)  $daily_returnResponsekraken[0]['dailyTradeableUSDT_usd_worth'],
                          'dailyTradeableBTCLimit$'           =>    (float)  $daily_returnResponsekraken[0]['dailyTradeableBTC_usd_worth'],
                          'PreviousDailyTradeableUSDTLimit'   =>    (float)  $gotDataReturnHistorykraken[0]['dailyTradeableUSDT_usd_worth'],
                          'PreviousDailyTradeableBTCLimit$'   =>    (float)  $gotDataReturnHistorykraken[0]['dailyTradeableBTC_usd_worth'],
                          'dailyTradesExpectedBtc'            =>    $atg_returnResponsekraken[0]['step_4']['dailyTradesExpectedBtc'],
                          'dailyTradesExpectedUsdt'           =>    $atg_returnResponsekraken[0]['step_4']['dailyTradesExpectedUsdt'],
                          'baseCurrencyArr'                   =>    $atg_returnResponsekraken[0]['step_4']['baseCurrencyArr'],
                          'fivePercentOfTotalBalance'         =>    $fivePercentOfTotalBalance,
                          'manulInvestemntTotal'              =>    (float)$totalManulInvest,
                          'manulOrderBtcInvest'               =>    $manulOrderBtcInvest,
                          'manulOrderUsdtInvest'              =>    $manulOrderUsdtInvest
                          
                        );

                        //start getting coin balance and convert into $   and store into invesment report collection
                        $LTCUSDTKeyKraken    =  array_search('LTC',  array_column($balance_reskraken, 'coin_symbol'));
                        $XMRBTCKeyKraken     =  array_search('XMR',  array_column($balance_reskraken, 'coin_symbol'));
                        $XLMBTCKeyKraken     =  array_search('XLM',  array_column($balance_reskraken, 'coin_symbol'));
                        $ETHBTCKeyKraken     =  array_search('ETH',  array_column($balance_reskraken, 'coin_symbol'));
                        $XRPBTCKeyKraken     =  array_search('XRP',  array_column($balance_reskraken, 'coin_symbol'));
                        $QTUMBTCKeyKraken    =  array_search('QTUM', array_column($balance_reskraken, 'coin_symbol'));        
                        $TRXBTCKeyKraken     =  array_search('TRX',  array_column($balance_reskraken, 'coin_symbol'));
                        $ETCBTCKeyKraken     =  array_search('ETC',  array_column($balance_reskraken, 'coin_symbol'));
                        $EOSBTCKeyKraken     =  array_search('EOS',  array_column($balance_reskraken, 'coin_symbol'));
                        $LINKBTCKeyKraken    =  array_search('LINK', array_column($balance_reskraken, 'coin_symbol'));
                        $DASHBTCKeyKraken    =  array_search('DASH', array_column($balance_reskraken, 'coin_symbol'));
                        $ADABTCKeyKraken     =  array_search('ADA',  array_column($balance_reskraken, 'coin_symbol'));

                        
                        $LTCUSDTBalanceKraken  =  0 ;
                        $XMRBTCBalanceKraken   =  0 ;
                        $XLMBTCBalanceKraken   =  0 ;
                        $ETHBTCBalanceKraken   =  0 ;
                        $XRPBTCBalanceKraken   =  0 ;
                        $QTUMBTCBalanceKraken  =  0 ;
                        $TRXBTCBalanceKraken   =  0 ;
                        $ETCBTCBalanceKraken   =  0 ;
                        $EOSBTCBalanceKraken   =  0 ;
                        $LINKBTCBalanceKraken  =  0 ;
                        $DASHBTCBalanceKraken  =  0 ;
                        $ADABTCBalanceKraken   =  0 ;

                        $LTCUSDTBalanceKraken               =  ($LTCUSDTKeyKraken!= '') ? $balance_reskraken[$LTCUSDTKeyKraken]['coin_balance'] : 0;
                        $LTCUSDTBalanceKraken               =   convertCoinBalanceIntoUSDT('LTCUSDT', $LTCUSDTBalanceKraken, 'kraken');

                        $XMRBTCBalanceKraken                =   ( $XMRBTCKeyKraken !='') ? $balance_reskraken[$XMRBTCKeyKraken]['coin_balance'] : 0;
                        $XMRBTCBalanceKraken                =   convertCoinBalanceIntobtctoUSDT('XMRBTC', $XMRBTCBalanceKraken, 'kraken');

                        $XLMBTCBalanceKraken                =   ($XLMBTCKeyKraken !='') ? $balance_reskraken[$XLMBTCKeyKraken]['coin_balance'] : 0;
                        $XLMBTCBalanceKraken                =   convertCoinBalanceIntobtctoUSDT('XLMBTC', $XLMBTCBalanceKraken, 'kraken');

                        $ETHBTCBalanceKraken                =   ($ETHBTCKeyKraken != '') ? $balance_reskraken[$ETHBTCKeyKraken]['coin_balance'] : 0;
                        $ETHBTCBalanceKraken                =   convertCoinBalanceIntobtctoUSDT('ETHBTC', $ETHBTCBalanceKraken, 'kraken');

                        $XRPBTCBalanceKraken                =   ($XRPBTCKeyKraken != '') ? $balance_reskraken[$XRPBTCKeyKraken]['coin_balance'] : 0;
                        $XRPBTCBalanceKraken                =   convertCoinBalanceIntobtctoUSDT('XRPBTC', $XRPBTCBalanceKraken, 'kraken');

                        $QTUMBTCBalanceKraken               =   ($QTUMBTCKeyKraken != '') ? $balance_reskraken[$QTUMBTCKeyKraken]['coin_balance'] : 0;
                        $QTUMBTCBalanceKraken               =   convertCoinBalanceIntobtctoUSDT('QTUMBTC', $QTUMBTCBalanceKraken, 'kraken');

                        $TRXBTCBalanceKraken                =   ($TRXBTCKeyKraken !='') ? $balance_reskraken[$TRXBTCKeyKraken]['coin_balance'] : 0;
                        $TRXBTCBalanceKraken                =   convertCoinBalanceIntobtctoUSDT('TRXBTC', $TRXBTCBalanceKraken, 'kraken');

                        $ETCBTCBalanceKraken                =   ($ETCBTCKeyKraken != '') ? $balance_reskraken[$ETCBTCKeyKraken]['coin_balance'] : 0;
                        $ETCBTCBalanceKraken                =   convertCoinBalanceIntobtctoUSDT('ETCBTC', $ETCBTCBalanceKraken, 'kraken');

                        $EOSBTCBalanceKraken                =   ($EOSBTCKeyKraken != '') ? $balance_reskraken[$EOSBTCKeyKraken]['coin_balance'] : 0;
                        $EOSBTCBalanceKraken                =   convertCoinBalanceIntobtctoUSDT('EOSBTC', $EOSBTCBalanceKraken, 'kraken');

                        $LINKBTCBalanceKraken               =   ($LINKBTCKeyKraken != '') ? $balance_reskraken[$LINKBTCKeyKraken]['coin_balance'] : 0;
                        $LINKBTCBalanceKraken               =   convertCoinBalanceIntobtctoUSDT('LINKBTC', $LINKBTCBalanceKraken, 'kraken');

                        $DASHBTCBalanceKraken               =   ($DASHBTCKeyKraken != '') ? $balance_reskraken[$DASHBTCKeyKraken]['coin_balance'] : 0;
                        $DASHBTCBalanceKraken               =   convertCoinBalanceIntobtctoUSDT('DASHBTC', $DASHBTCBalanceKraken, 'kraken');

                        $ADABTCBalanceKraken                =   ($ADABTCKeyKraken !='') ? $balance_reskraken[$ADABTCKeyKraken]['coin_balance'] : 0;
                        $ADABTCBalanceKraken                =   convertCoinBalanceIntobtctoUSDT('ADABTC', $ADABTCBalanceKraken, 'kraken');

                        if($totalAccountWorthkraken >= $trade_limit){
                          $array_update['tradeAbleBalanceBaseOnPakge']  =  $trade_limit;
                        }else{
                          $array_update['tradeAbleBalanceBaseOnPakge']  =  $totalAccountWorthkraken;
                        }


                        // check auto trading setting 
                        if(count($atg_returnResponsekraken) > 0 ){
                          $array_update['agt'] = 'yes';
                        }else{
                          $array_update['agt'] = 'no';
                        }


                      //calculate order listing balances
                        $countBalanceCriteriaKraken['application_mode']           =   'live';
                        $countBalanceCriteriaKraken['status']['$nin']             =   ['credentials_ERROR','canceled_ERROR','error' ,'new', 'new_ERROR', 'canceled', 'pause', 'submitted_buy', 'fraction_submitted_buy'];
                        $countBalanceCriteriaKraken['parent_status']['$ne']       =   'parent';
                        $countBalanceCriteriaKraken['cost_avg']['$ne']            =   'completed';
                        $countBalanceCriteriaKraken['is_sell_order']['$ne']       =   'sold';
                        $countBalanceCriteriaKraken['admin_id']                   =   (string)$user['_id'];
                        $countBalanceCriteriaKraken['resume_status']['$ne']       =   'completed';

                        $getAllBuyOrdersKraken         =   $custom->buy_orders_kraken->find($countBalanceCriteriaKraken);
                        $getAllBuyOrdersReturnKraken   =   iterator_to_array($getAllBuyOrdersKraken);
                        echo "<br>count All: ".count($getAllBuyOrdersReturnKraken);
                        unset($getAllBuyOrdersKraken);

                        $XMRBTCBalanceCal          =   0 ;
                        $XLMBTCBalanceCal          =   0 ;
                        $ETHBTCBalanceCal          =   0 ;
                        $XRPBTCBalanceCal          =   0 ;
                        $QTUMBTCBalanceCal         =   0 ;
                        $TRXBTCBalanceCal          =   0 ;
                        $ETCBTCBalanceCal          =   0 ;
                        $EOSBTCBalanceCal          =   0 ;
                        $LINKBTCBalanceCal         =   0 ;
                        $DASHBTCBalanceCal         =   0 ;
                        $ADABTCBalanceCal          =   0 ;
                        $LTCUSDTBalanceCal         =   0 ;
                        $XRPUSDTBalanceCal         =   0 ;

                        foreach($getAllBuyOrdersReturnKraken as $orderCalculate){
                          if($orderCalculate['symbol'] == 'XMRBTC'){
                            $XMRBTCBalanceCal += $orderCalculate['quantity'] ;

                          }elseif($orderCalculate['symbol'] == 'XLMBTC'){
                            $XLMBTCBalanceCal += $orderCalculate['quantity'] ;

                          }elseif($orderCalculate['symbol'] == 'ETHBTC'){
                            $ETHBTCBalanceCal += $orderCalculate['quantity'] ;

                          }elseif($orderCalculate['symbol'] == 'XRPBTC'){
                            $XRPBTCBalanceCal += $orderCalculate['quantity'] ;

                          }elseif($orderCalculate['symbol'] == 'QTUMBTC'){
                            $QTUMBTCBalanceCal += $orderCalculate['quantity'] ;

                          }elseif($orderCalculate['symbol'] == 'TRXBTC'){
                            $TRXBTCBalanceCal += $orderCalculate['quantity'] ;

                          }elseif($orderCalculate['symbol'] == 'ETCBTC'){
                            $ETCBTCBalanceCal += $orderCalculate['quantity'] ;

                          }elseif($orderCalculate['symbol'] == 'EOSBTC'){
                            $EOSBTCBalanceCal += $orderCalculate['quantity'] ;

                          }elseif($orderCalculate['symbol'] == 'LINKBTC'){
                            $LINKBTCBalanceCal += $orderCalculate['quantity'] ;

                          }elseif($orderCalculate['symbol'] == 'DASHBTC'){
                            $DASHBTCBalanceCal += $orderCalculate['quantity'] ;

                          }elseif($orderCalculate['symbol'] == 'ADABTC'){
                            $ADABTCBalanceCal += $orderCalculate['quantity'];

                          }elseif($orderCalculate['symbol'] == 'LTCUSDT'){
                            $LTCUSDTBalanceCal += $orderCalculate['quantity'] ;

                          }elseif($orderCalculate['symbol'] == 'XRPUSDT'){
                            $XRPUSDTBalanceCal += $orderCalculate['quantity'] ;
                          }
                        }
                        // $array_update[]

                        $XMRBTCBalanceCal  = ($XMRBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('XMRBTC', $XMRBTCBalanceCal,   'kraken'): 0;

                        $XLMBTCBalanceCal  = ($XLMBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('XLMBTC', $XLMBTCBalanceCal,   'kraken'): 0;

                        $ETHBTCBalanceCal  = ($ETHBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('ETHBTC', $ETHBTCBalanceCal,   'kraken'): 0;

                        $XRPBTCBalanceCal  = ($XRPBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('XRPBTC', $XRPBTCBalanceCal,   'kraken'): 0;

                        $QTUMBTCBalanceCal = ($QTUMBTCBalanceCal > 0) ? convertCoinBalanceIntobtctoUSDT('QTUMBTC', $QTUMBTCBalanceCal,'kraken'): 0;

                        $TRXBTCBalanceCal  = ($TRXBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('TRXBTC', $TRXBTCBalanceCal,   'kraken'): 0;

                        $ETCBTCBalanceCal  = ($ETCBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('ETCBTC', $ETCBTCBalanceCal,   'kraken'): 0;

                        $EOSBTCBalanceCal  = ($EOSBTCBalanceCal > 0) ?  convertCoinBalanceIntobtctoUSDT('EOSBTC', $EOSBTCBalanceCal,   'kraken'): 0;

                        $LINKBTCBalanceCal = ($LINKBTCBalanceCal > 0) ?convertCoinBalanceIntobtctoUSDT('LINKBTC', $LINKBTCBalanceCal, 'kraken'): 0;

                        $DASHBTCBalanceCal = ($DASHBTCBalanceCal > 0) ?convertCoinBalanceIntobtctoUSDT('DASHBTC', $DASHBTCBalanceCal, 'kraken'): 0;

                        $ADABTCBalanceCal  = ($ADABTCBalanceCal > 0) ?  convertCoinBalanceIntoUSDT('ADABTC', $ADABTCBalanceCal,    'kraken'): 0;

                        $LTCUSDTBalanceCal = ($LTCUSDTBalanceCal > 0) ?  convertCoinBalanceIntoUSDT('LTCUSDT', $LTCUSDTBalanceCal,    'kraken'): 0;

                        // $XRPUSDTBalanceCal = ($XRPUSDTBalanceCal > 0) ?  convertCoinBalanceIntoUSDT('XRPUSDT', $XRPUSDTBalanceCal,    'kraken'): 0;
                        //end

                        echo "<br>XMRBTCBalanceKraken : ".$XMRBTCBalanceKraken. "  XMRBTCBalanceCal: ".$XMRBTCBalanceCal;
                        echo "<br>XLMBTCBalanceKraken : ".$XLMBTCBalanceKraken. " XLMBTCBalanceCal: ".$XLMBTCBalanceCal;
                        echo "<br>ETHBTCBalanceKraken : ".$ETHBTCBalanceKraken. " ETHBTCBalanceCal: ".$ETHBTCBalanceCal;
                        echo "<br>TRXBTCBalanceKraken : ".$TRXBTCBalanceKraken. " TRXBTCBalanceCal: ".$TRXBTCBalanceCal;
                        echo "<br>ETCBTCBalanceKraken : ".$ETCBTCBalanceKraken. " ETCBTCBalanceCal: ".$ETCBTCBalanceCal;
                        echo "<br>LINKBTCBalanceKraken : ".$LINKBTCBalanceKraken. " LINKBTCBalanceCal: ".$LINKBTCBalanceCal;
                        echo "<br>DASHBTCBalanceKraken : ".$DASHBTCBalanceKraken. " DASHBTCBalanceCal: ".$DASHBTCBalanceCal;
                        echo "<br>ADABTCBalanceKraken : ".$ADABTCBalanceKraken. " ADABTCBalanceCal: ".$ADABTCBalanceCal;
                        echo "<br>LTCUSDTBalanceKraken : ".$LTCUSDTBalanceKraken. " LTCUSDTBalanceCal: ".$LTCUSDTBalanceCal;
                        echo "<br>EOSBTCBalanceKraken : ".$EOSBTCBalanceKraken. " EOSBTCBalanceCal: ".$EOSBTCBalanceCal;
                        echo "<br>QTUMBTCBalanceKraken : ".$QTUMBTCBalanceKraken. " QTUMBTCBalanceCal: ".$QTUMBTCBalanceCal;

                        echo "<br>XRPBTCBalanceKraken : ".$XRPBTCBalanceKraken. " XRPUSDTBalanceCal + XRPBTCBalanceCal: ".($XRPUSDTBalanceCal + $XRPBTCBalanceCal);

                        // extra less balance calculation
                        //order listing balance          //wallet balance
                        $xmrbtc   =  $XMRBTCBalanceKraken   -  $XMRBTCBalanceCal ;     
                        $xlmbtc   =  $XLMBTCBalanceKraken   -  $XLMBTCBalanceCal ;
                        $ethbtc   =  $ETHBTCBalanceKraken   -  $ETHBTCBalanceCal ;
                        $trxbtc   =  $TRXBTCBalanceKraken   -  $TRXBTCBalanceCal ;
                        $etcbtc   =  $ETCBTCBalanceKraken   -  $ETCBTCBalanceCal ;
                        $linkbtc  =  $LINKBTCBalanceKraken  -  $LINKBTCBalanceCal;
                        $dashbtc  =  $DASHBTCBalanceKraken  -  $DASHBTCBalanceCal;
                        $adabtc   =  $ADABTCBalanceKraken   -  $ADABTCBalanceCal ;
                        $ltcusdt  =  $LTCUSDTBalanceKraken  -  $LTCUSDTBalanceCal;
                        $eosbtc   =  $EOSBTCBalanceKraken   -  $EOSBTCBalanceCal;
                        $qtumbtc  =  $QTUMBTCBalanceKraken  -  $QTUMBTCBalanceCal;
                        $xrpbtc   =  $XRPBTCBalanceKraken   -  $XRPBTCBalanceCal ;

                        $less     = 0;
                        $extra    = 0;

                        $less    += ($xmrbtc <  0) ? $xmrbtc    :  0;
                        $extra   += ($xmrbtc >= 0) ? $xmrbtc    :  0;
            
                        $less    += ($xlmbtc <  0) ? $xlmbtc    :  0;
                        $extra   += ($xlmbtc >= 0) ? $xlmbtc    :  0;
          
                        $less    += ($ethbtc <  0) ? $ethbtc    :  0;
                        $extra   += ($ethbtc >= 0) ? $ethbtc    :  0;
            
                        $less    += ($trxbtc <  0) ? $trxbtc    :  0;
                        $extra   += ($trxbtc >= 0) ? $trxbtc    :  0;
            
                        $less    += ($etcbtc <  0) ? $etcbtc    :  0;
                        $extra   += ($etcbtc >= 0) ? $etcbtc    :  0;
            
                        $less    += ($linkbtc <  0) ? $linkbtc  :  0;
                        $extra   += ($linkbtc >= 0) ? $linkbtc  :  0;
            
                        $less    += ($dashbtc <  0) ? $dashbtc  :  0;
                        $extra   += ($dashbtc >= 0) ? $dashbtc  :  0;
            
                        $less    += ($adabtc <  0) ? $adabtc    :  0;
                        $extra   += ($adabtc >= 0) ? $adabtc    :  0;
            
                        $less    += ($ltcusdt <  0) ? $ltcusdt  :  0;
                        $extra   += ($ltcusdt >= 0) ? $ltcusdt  :  0;
            
                        $less    += ($qtumbtc <  0) ? $qtumbtc  :  0;
                        $extra   += ($qtumbtc >= 0) ? $qtumbtc  :  0;
            
                        $less    += ($xrpbtc <  0) ? $xrpbtc    :  0;
                        $extra   += ($xrpbtc >= 0) ? $xrpbtc    :  0;
            
                        $less    += ($eosbtc <  0) ? $eosbtc    :  0;
                        $extra   += ($eosbtc >= 0) ? $eosbtc    :  0;

                        $array_update['lessBalance']   =  $less;  
                        $array_update['extraBalance']  =  $extra;

                        echo "<br>Less Balance :".$less;
                        echo "<br>Extra Balance :".$extra;

                        $startTime  =   $this->mongo_db->converToMongodttime(date("Y-m-d 00:00:00" , strtotime('-7 days')));
                        $endTime    =   $this->mongo_db->converToMongodttime(date("Y-m-d 23:59:59"));

                        // query for this button filters "Last 7 days low trading"
                        $where_sold_orderCountForCheck_kraken['application_mode']       =     'live';
                        $where_sold_orderCountForCheck_kraken['admin_id']               =     (string)$user['_id'];
                        $where_sold_orderCountForCheck_kraken['created_date']           =     ['$gte' => $startTime, '$lte' => $endTime];
                        $where_sold_orderCountForCheck_kraken['is_sell_order']          =     'sold';
                        $where_sold_orderCountForCheck_kraken['status']                 =     'FILLED';
                        $where_sold_orderCountForCheck_kraken['resume_status']          =     ['$exists' => false];
                        $where_sold_orderCountForCheck_kraken['cost_avg']               =     ['$exists' => false];
                        $where_sold_orderCountForCheck_kraken['cavg_parent']            =     ['$exists' => false];

                        $lthOpenCountForCheck_kraken['created_date']                    =     ['$gte' => $startTime, '$lte' => $endTime];
                        $lthOpenCountForCheck_kraken['admin_id']                        =     (string)$user['_id'];
                        $lthOpenCountForCheck_kraken['application_mode']                =     'live';
                        $lthOpenCountForCheck_kraken['status']['$nin']                  =     ['credentials_ERROR','canceled_ERROR','error' ,'new', 'new_ERROR', 'canceled', 'pause', 'submitted_buy', 'fraction_submitted_buy'];
                        $lthOpenCountForCheck_kraken['is_sell_order']                   =     ['$ne' => 'sold'];
                        $lthOpenCountForCheck_kraken['trigger_type']                    =     "barrier_percentile_trigger";
                        $lthOpenCountForCheck_kraken['resume_status']                   =     ['$exists' => false]; 
                        $lthOpenCountForCheck_kraken['cavg_parent']                     =     ['$exists' => false];
                        $lthOpenCountForCheck_kraken['count_avg_order']                 =     ['$exists' => false];

                        $soldCount =  $custom->buy_orders_kraken->count($lthOpenCountForCheck_kraken);
                        $buyCount  =  $custom->sold_buy_orders_kraken->count($where_sold_orderCountForCheck_kraken);

                        $array_update['totalbuySellOrdersCountWithinSavenDays'] =  (float) ($soldCount + $buyCount) ;

                        echo "<br>last 7 days count orders: ".($soldCount + $buyCount);
                        // get user limit buy history 
                        $agregateHistory = [
                          [
                            '$match' => [
                              'user_id' => (string)$user['_id']
                            ],
                          ],
                            [
                              '$project' => [
                                '_id'                           =>  '$_id',
                                'daily_bought_btc_usd_worth'    =>  '$daily_bought_btc_usd_worth',
                                'BTCTradesTodayCount'           =>  '$BTCTradesTodayCount',
                                'daily_bought_usdt_usd_worth'   =>  '$daily_bought_usdt_usd_worth',
                                'USDTTradesTodayCount'          =>  '$USDTTradesTodayCount',
                                'dailyTradeableUSDT_usd_worth'  =>  '$dailyTradeableUSDT_usd_worth',
                                'dailyTradeableBTC_usd_worth'   =>  '$dailyTradeableBTC_usd_worth',
                                'created'                       =>  '$created_date'
                              ],
                            ],
                            [
                              '$sort'  => ['created_date' => -1],
                            ],
                              ['$limit' => 8]
                        ];

                        $dailyReturnHistorykraken         =   $custom->$dailyTradeLimitCollectionHistorykraken->aggregate($agregateHistory);
                        $dailyReturnHistoryResponsekraken =   iterator_to_array($dailyReturnHistorykraken);
                        $array_update['history']          =   $dailyReturnHistoryResponsekraken;

                        //end get user buy limit history
                        echo "<pre>";print_r($array_update);

                        $update_where['username'] = $user['username'];
                      
                        $upsert['upsert'] = true;
                        $custom->$collection_namekraken->updateOne($update_where, ['$set'=> $array_update], $upsert);
                      }//end kraken user credential varify
                      $array_update_in_user_colection['is_modified_actual_report_kraken'] = $current_time_date;
                      $search_find['_id']       =   $user['_id'];
                      $search_find['username']  =   $user['username'];
            
                      $this->mongo_db->where($search_find);
                      $this->mongo_db->set($array_update_in_user_colection); 
                      $this->mongo_db->update('users');
                    } //end loop
                  }//end if
                }// end cron function


                public function monthly_calculation_user_bam(){

                  $buyCollectionName                =   'buy_orders_bam';
                  $soldCollectionName               =   'sold_buy_orders_bam';
                  $marketPriceCollection            =   'market_prices_bam';
                  $collection_name                  =   'user_investment_bam';
                  $userWalletCollection             =   'user_wallet_bam';
                  $atgCollectionName                =   'auto_trade_settings_bam';
                  $dailyTradeLimitCollection        =   'daily_trade_buy_limit_bam';
                  $dailyTradeLimitCollectionHistory =   'daily_trade_buy_limit_history_bam';
                  $exchangeName                     =   'bam';
                  $credentialVarification           =   'bam_credentials';

                  $price_search['coin'] = 'BTCUSDT';
                  $this->mongo_db->where($price_search);
                  $priceses = $this->mongo_db->get($marketPriceCollection);
                  $final_prices = iterator_to_array($priceses);
                  $btcusdt = $final_prices[0]['price'];
                  echo "<br>Current Market Price: ".$btcusdt;
                  
                  $coinArrayUSDT = ['XRPUSDT', 'BTCUSDT', 'NEOUSDT', 'QTUMUSDT'];
                  $btc_coin_in_arr  = ['ETHBTC','XRPBTC'];
                 
                  $current_date_time =  date('Y-m-d H:i:s');
                  $current_time_date =  $this->mongo_db->converToMongodttime($current_date_time);

                  $next_date =  date('Y-m-d H:i:s', strtotime('-8 hours'));   // run this on 27 date and then run after 1 month
                  $pre_time_date =  $this->mongo_db->converToMongodttime($next_date);
                

                  if(!empty($this->input->get())){
                    $whereUser['username'] = $this->input->get('userName');
                  }else{
                    $where1['is_modified_actual_report_bam'] = ['$lte'=>$pre_time_date];
                    $where2['is_modified_actual_report_bam'] = ['$exists' => false];

                    $whereUser['$or'] = [$where1, $where2];
                    $whereUser['application_mode'] = ['$in'=> ['both', 'live']];
                  } 


                  $getUsers = [
                    [
                      '$match' => $whereUser
                      //   '$or' =>[
                      //     ['is_modified_actual_report_bam' => ['$lte'=>$pre_time_date]],
                      //     ['is_modified_actual_report_bam' => ['$exists' => false]] 
                      //   ],
                      //   // 'username' => 'admin',
                      //   'application_mode' => ['$in'=> ['both', 'live']]
                      // ],
                    ],
                    [
                      '$sort' =>['created_date'=> -1],
                    ],
                    ['$limit'=> 3]
                  ];
                  $custom = $this->mongo_db->customQuery(); 
                  $user_return_collectio = $custom->users->aggregate($getUsers);
                  $user_return_detail = iterator_to_array($user_return_collectio);
                  // unset($user_return_collectio);
                  if(count($user_return_detail) > 0){
                    foreach($user_return_detail as $user){    
                      // echo"<br>id =".$user['_id'];            
                      echo"<br>username = ".$user['username'];
                      $where_credential['user_id'] = (string)$user['_id'];

                      $user_return         = $custom->$credentialVarification->find($where_credential);
                      $user_returnResponse = iterator_to_array($user_return);
                      if(count($user_returnResponse)> 0){
                        //open orders calculation
                        $open['admin_id']          =  (string)$user['_id'];
                        $open['application_mode']  =  'live';
                        $open['status']            =  ['$in' => ['FILLED', 'FILLED_ERROR','SELL_ID_ERROR']];
                        $open['is_sell_order']     =  'yes';
                        // $open['trigger_type']      =  "barrier_percentile_trigger";
                        $open['is_lth_order']      =  ['$ne'=> 'yes'];
                        $open['resume_status']     =  ['$exists' => false]; 
                        $open['cavg_parent']       =  ['$exists' => false];
                        $open['count_avg_order']   =  ['$exists' => false];
                        
                        $retun_orders_open            =  $custom->$buyCollectionName->find($open);
                        $order_return_response_open   =  iterator_to_array($retun_orders_open);

                        echo"<br> open orders = ".count($order_return_response_open);
                        // unset($retun_orders_open);

                        $open_btc     = 0;
                        $open_usdt    = 0;
                        $openBTCSUDT  = 0;

                        if(count($order_return_response_open) > 0){
                          foreach($order_return_response_open as $open){

                            if(in_array($open['symbol'], $btc_coin_in_arr )){

                              $open_btc += $open['purchased_price'] * $open['quantity']; 
                            }elseif(in_array($open['symbol'], $coinArrayUSDT)){
                              
                              $open_usdt += $open['purchased_price'] * $open['quantity']; 
                            }elseif($open['symbol'] == 'BTCUSDT'){
                              
                              $openBTCSUDT += $open['purchased_price'] * $open['quantity'];
                            }

                          }
                        }
                        echo "<br> Total Open orders btc balance  = ".$open_btc;
                        echo "<br> Total Open orders USDT balance  = ".$open_usdt;
                        echo "<br> Total Open orders USDT balance which we will subtractfrom USDT BALANCE = ".$openBTCSUDT;

                        $open_balance_converted = 0;
                        $openTotalBtc = 0;
                        if($open_btc > 0){
                          $openTotalBtc = $open_btc;
                          $open_balance_converted = convert_btc_to_usdt($open_btc);  // helper function
                        }

                        echo "<br> Sum of All balance Worth in $ lth orders  = ".(($open_balance_converted+ $open_usdt) - $openBTCSUDT);
                        //end open orders calculation 


                        //lth order calculation
                        $lth['admin_id']              = (string)$user['_id'];
                        $lth['application_mode']      = 'live';
                        $lth['status']                = ['$in' => ['LTH', 'LTH_ERROR']];
                        $lth['is_sell_order']         = 'yes';
                        $lth['lth_functionality']     = 'yes';
                        // $lth['trigger_type']          = "barrier_percentile_trigger";
                        $lth['resume_status']         = ['$exists' => false]; 
                        $lth['cost_avg']              = ['$nin' => ['yes', 'taking_child', 'completed']];

                        $retun_orders_lth = $custom->$buyCollectionName->find($lth);
                        $order_return_response_lth = iterator_to_array($retun_orders_lth);
                        echo"<br> lth orders = ".count($order_return_response_lth);
                        // unset($retun_orders_lth);

                        $lth_btc = 0;
                        $lth_usdt = 0;
                        $lthBTCSUDT = 0;
                        if(count($order_return_response_lth) > 0){
                          foreach($order_return_response_lth as $lth){
                            
                            if(in_array($lth['symbol'], $btc_coin_in_arr)){
                            
                              $lth_btc += $lth['purchased_price'] * $lth['quantity']; 
                            }elseif(in_array($lth['symbol'], $coinArrayUSDT)){
                            
                              $lth_usdt += $lth['purchased_price'] * $lth['quantity']; 
                            }elseif($lth['symbol'] == 'BTCUSDT'){
                            
                              $lthBTCSUDT += $lth['purchased_price'] * $lth['quantity'];
                            }
                            
                          }
                        }
                        echo "<br> Total lth orders btc balance  = ".$lth_btc;
                        echo "<br> Total lth orders USDT balance  = ".$lth_usdt;
                        echo "<br> Total lth orders USDT balance which we will subtractfrom USDT BALANCE = ".$lthBTCSUDT;


                        $lth_balance_converted = 0;
                        $lthBTCTotal = 0;  
                        if($lth_btc > 0){
                          $lthBTCTotal = $lth_btc;
                          $lth_balance_converted = convert_btc_to_usdt($lth_btc);  // helper function
                        }

                        echo "<br> Sum of All balance Worth in $ lth orders  = ".(($lth_balance_converted+ $lth_usdt) - $lthBTCSUDT);
                        //end lth orders calculation


                        //cost avg orders calculation 

                        $costAvgOrder['admin_id']          =  (string)$user['_id'];
                        $costAvgOrder['application_mode']  =  'live';
                        $costAvgOrder['is_sell_order']     =  'yes';
                        $costAvgOrder['is_lth_order']      =  ['$ne'=> 'yes'];
                        // $costAvgOrder['trigger_type']      =  "barrier_percentile_trigger";
                        $costAvgOrder['resume_status']     =  ['$exists' => false]; 
                        $costAvgOrder['cost_avg']          =  ['$in' => ['yes', 'taking_child']];
                        $costAvgOrder['status']            =  'FILLED';
                        
                        $retunCostAvgOrders            =  $custom->$buyCollectionName->find($costAvgOrder);
                        $orderReturnResponseCost       =  iterator_to_array($retunCostAvgOrders);

                        echo"<br> Cost Avg orders: = ".count($orderReturnResponseCost);
                        // unset($retunCostAvgOrders);

                        $costAvgBtc      = 0;
                        $costAvgUsdt     = 0;
                        $costAcgBTCSUDT  = 0;

                        if(count($orderReturnResponseCost) > 0){
                          foreach($orderReturnResponseCost as $costAvg){

                            if(in_array($costAvg['symbol'], $btc_coin_in_arr )){

                              $costAvgBtc += $costAvg['purchased_price'] * $costAvg['quantity']; 
                            }elseif(in_array($costAvg['symbol'], $coinArrayUSDT)){
                              
                              $costAvgUsdt += $costAvg['purchased_price'] * $costAvg['quantity']; 
                            }elseif($costAvg['symbol'] == 'BTCUSDT'){
                              
                              $costAcgBTCSUDT += $costAvg['purchased_price'] * $costAvg['quantity'];
                            }

                          }    
                        }
                        echo "<br> Total Cost Avg orders btc balance  = ".$costAvgBtc;
                        echo "<br> Total Cost Avg orders USDT balance  = ".$costAvgUsdt;
                        echo "<br> Total Cost Avg orders USDT balance which we will subtractfrom USDT BALANCE = ".$costAcgBTCSUDT;

                        $costAvgConvertBalance = 0;
                        $costAvgTotalBtc = 0;
                        if($costAvgBtc > 0){
                          $costAvgTotalBtc = $costAvgBtc;
                          $costAvgConvertBalance = convert_btc_to_usdt($costAvgBtc);  // helper function
                        }

                        echo "<br> Sum of All balance Worth in $ COST Avg orders  = ".(($costAvgConvertBalance+ $costAvgUsdt) - $costAcgBTCSUDT);
                        //end Cost Average orders calculation 


                        //1 month old order profit/loss calculation 
                        $current = $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'));
                        $current_date = date('Y-m-d H:i:s', strtotime('-1 month'));
                        $mongo_time = $this->mongo_db->converToMongodttime($current_date);

                        $lthOpen['created_date']         =  ['$gte' => $mongo_time, '$lte' => $current];
                        $lthOpen['admin_id']             =  (string)$user['_id'];
                        $lthOpen['application_mode']     =  'live';
                        $lthOpen['status']['$in']        =  ['LTH', 'FILLED'];
                        $lthOpen['is_sell_order']        =  ['$ne' => 'sold'];
                        // $lthOpen['trigger_type']         =  "barrier_percentile_trigger";
                        $lthOpen['resume_status']        =  ['$exists' => false]; 
                        $lthOpen['cavg_parent']          =  ['$exists' => false];
                        $lthOpen['count_avg_order']      =  ['$exists' => false];
                        
                        $retunOrdersLTH                  = $custom->$buyCollectionName->find($lthOpen);
                        $orderReturnResponseLTH          = iterator_to_array($retunOrdersLTH);

                        echo"<br> lth and open orders = ".count($orderReturnResponseLTH);
                        // unset($retunOrdersLTH);
                        
                        $btc = 0;
                        $usdt = 0;
                        $BTCSUDT = 0;
                        if(count($orderReturnResponseLTH) > 0){
                          foreach($orderReturnResponseLTH as $calculation){
                            
                            if(in_array($calculation['symbol'], $btc_coin_in_arr)){
                              $btc += $calculation['purchased_price'] * $calculation['quantity'];
                            }elseif(in_array($calculation['symbol'], $coinArrayUSDT)){
                            
                              $usdt += $calculation['purchased_price'] * $calculation['quantity'];
                            }elseif($calculation['symbol'] == 'BTCUSDT'){
                            
                              $BTCSUDT += $calculation['purchased_price'] * $calculation['quantity'];
                            }
                          }//end foreach
                        }//end if
                        //end 1 month old orders calculation 

                        //sold orders count get 
                        $sold['admin_id']             = (string)$user['_id'];
                        $sold['application_mode']     = 'live';
                        $sold['is_sell_order']        = 'sold';
                        $sold['status']               = 'FILLED';
                        // $sold['trigger_type']         =  "barrier_percentile_trigger";
                        $sold['resume_status']        =  ['$exists' => false]; 
                        $sold['cost_avg']             =  ['$exists' => false];
                        $sold['cavg_parent']          =  ['$exists' => false];

                        $order_return = $custom->$soldCollectionName->count($sold);
                        echo"<br> sold count = ". $order_return;
                        // end sold orders count get


                        //get last trade buy time 
                        $pipeline = [
                          [
                            '$match' =>[
                              'application_mode'   =>  'live',
                              'admin_id'           =>  (string)$user['_id'],
                              'is_sell_order'      =>  'yes',
                              'status'             =>  ['$in'=>['LTH','FILLED']],
                              'resume_status'      =>  ['$exists' => false],
                              'trigger_type'       =>  "barrier_percentile_trigger",
                              'cost_avg'           =>  ['$nin' => ['yes', 'taking_child', 'completed']],
                              'cavg_parent'        =>  ['$exists' => false]
                            ],
                          ],
                          
                            [
                              '$sort'    =>  ['buy_date'=> -1],
                            ],
                            ['$limit'=>1]
                        ];
                        $result_buy = $custom->$buyCollectionName->aggregate($pipeline);
                        $res = iterator_to_array($result_buy);
                        // end last order buy time


                        //get last trade sell time 
                        $pipeline_2= [
                          [
                            '$match' =>[
                              'application_mode'    =>  'live',
                              'admin_id'            =>  (string)$user['_id'],
                              'is_sell_order'       =>  'sold',
                              'status'              =>  'FILLED',
                              'trigger_type'       =>  "barrier_percentile_trigger",
                              'resume_status'       =>  ['$exists' => false],
                              'cost_avg'            =>  ['$nin' => ['yes', 'taking_child', 'completed']],
                              'cavg_parent'         =>  ['$exists' => false]
                            ],
                          ],
                          [
                            '$sort'    =>  ['sell_date'=> -1],
                          ],
                          ['$limit'=>1]
                        ];
                      
                        $result_sold = $custom->$soldCollectionName->aggregate($pipeline_2);
                        $res_sold = iterator_to_array($result_sold);
                        // end last trade sell time 

                      
                        //get user wallet balance
                        $where_balance['user_id'] = (string)$user['_id'];
                        $this->mongo_db->where($where_balance);
                        $data = $this->mongo_db->get($userWalletCollection);
                        $balance_res = iterator_to_array($data);

                        $total_usdt_balance_converted_total = 0;
                        $total_usdt_balance = 0;
                        $total_usdt_balance = 0;
                        $bnb = 0;   

                        foreach( $balance_res as $balance){
                          if($balance['coin_symbol'] == 'BTC'){
                        
                            $total_btc_balance = $balance['coin_balance'];
                            $total_usdt_balance_converted_total = convert_btc_to_usdt($balance['coin_balance']); //helper function for btc to usdt amount     
                          }elseif($balance['coin_symbol'] == 'USDT'){
                        
                            $total_usdt_balance = $balance['coin_balance'];
                          }elseif($balance['coin_symbol'] == 'BNB'){
                        
                            $bnb =  $balance['coin_balance'];
                          }//end else if
                  
                        } // end loop

                        //end get user wallet balance 


                        //get user pakage details 
                        $handshake = $this->GetRandomAPIaccessToken(); //get api parameter
                        $parameter = array(
                          'handshake' =>  $handshake,
                          'user_id'   => (string)$user['_id'],
                        );
                        $curl = curl_init();
                        $jsondata = json_encode($parameter);
                        curl_setopt_array($curl, array(
                          CURLOPT_URL => "https://users.digiebot.com/cronjob/GetUserSubscriptionDetails",
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_ENCODING => "",
                          CURLOPT_MAXREDIRS => 10,
                          CURLOPT_TIMEOUT => 0,
                          CURLOPT_FOLLOWLOCATION => true,
                          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                          CURLOPT_CUSTOMREQUEST => "POST",
                          CURLOPT_POSTFIELDS =>$jsondata,
                          CURLOPT_HTTPHEADER => array(
                            "Content-Type: application/json"
                          ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        $responce_Data = json_decode($response);
                        $trade_limit = 0;
                        if($responce_Data->trade_limit == null || $responce_Data->trade_limit == 'undifined' || $responce_Data->trade_limit== 0 || empty($responce_Data->trade_limit)){
                          $trade_limit = 500;
                        }else{
                            $trade_limit = $responce_Data->trade_limit;
                        }                    

                        //get user points detail
                        $playLoadUserId = array(
                          'user_id'   => (string)$user['_id'],
                        );
                        $curl = curl_init();
                        $jsondataPayLoad = json_encode($playLoadUserId);
                        curl_setopt_array($curl, array(
                          CURLOPT_URL => "https://users.digiebot.com/cronjob/GetUserTotalPoints",
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_ENCODING => "",
                          CURLOPT_MAXREDIRS => 10,
                          CURLOPT_TIMEOUT => 30,
                          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                          CURLOPT_CUSTOMREQUEST => "POST",
                          CURLOPT_POSTFIELDS => $jsondataPayLoad,
                          CURLOPT_HTTPHEADER => array(
                            "authorization: Basic cG9pbnRTdXBwbHk6NGU0NmQ5OWFjMjJhNGIwYWJlNTc2OGE3OGVlODdiOGM=",
                            "cache-control: no-cache",
                            "content-type: application/json",
                            "postman-token: b5711a89-ed67-92ba-25a8-685cfdcee2ec"
                          ),
                        ));
                        $response = curl_exec($curl);
                        $err = curl_error($curl);
                        curl_close($curl);
                        $totalPointsDetails = json_decode($response);
                        if($totalPointsDetails->status == 200 || $totalPointsDetails->message == "Data Found!"){
                          $userTotalPointsApiResponse =  $totalPointsDetails->points;
                        }else{
                          $userTotalPointsApiResponse = 0;
                        }
                        //end user points details 


                        // Auto trade Generator setting check 
                        $where_agt['user_id'] =  (string)$user['_id'];
                        $where_agt['application_mode'] = 'live';
                        $atg_return = $custom->$atgCollectionName->find($where_agt);
                        $atg_returnResponse = iterator_to_array($atg_return);
                        // unset($atg_return);

                        $btcInvestPercentage  = $atg_returnResponse[0]['step_4']['btcInvestPercentage'];
                        $totalTradeAbleInUSD  = $atg_returnResponse[0]['step_4']['totalTradeAbleInUSD'];
                        $usdtInvestPercentage = $atg_returnResponse[0]['step_4']['usdtInvestPercentage'];
                        $dailTradeAbleBalancePercentage = $atg_returnResponse[0]['step_4']['dailTradeAbleBalancePercentage'];

                        $customBtcPackage   = $atg_returnResponse[0]['step_4']['customBtcPackage'];
                        $customUsdtPackage  = $atg_returnResponse[0]['step_4']['customUsdtPackage'];

                        // End Auto trade Generator setting check

                        //Remining points Calculation 
                        $availableBTC   =  ($total_btc_balance + $open_btc) - $lth_btc;
                        $availableUSDT  =  ($total_usdt_balance + $open_usdt) - $lth_usdt;
                        $btcUSdworth    =  $availableBTC * $btcusdt;
                        
                        $btcPercentTradeableValue = ($btcInvestPercentage * $totalTradeAbleInUSD) / 100 ;
                        $usdtPercentTradeableValue = ($totalTradeAbleInUSD - $btcPercentTradeableValue);

                        $tradeAbleUsdWorth = $btcUSdworth <= $btcPercentTradeableValue ? $btcUSdworth : $btcPercentTradeableValue;
                        $actualTradeableBTC = (float)((1 / $btcusdt) * $tradeAbleUsdWorth);
                        $tradeAbleUsd = $availableUSDT <= $usdtPercentTradeableValue ? $availableUSDT : $usdtPercentTradeableValue;
                        $actualTradeableUSDT = (float)$tradeAbleUsd;
                        echo '<br>user_id asa: '.$user['username'].' / '.$actualTradeableBTC.' / '.$actualTradeableUSDT;

                        //end remining point calculation 

                        //get user daily limit 
                        $where_daily_limit['user_id'] =  (string)$user['_id'];
                        $daily_return = $custom->$dailyTradeLimitCollection->find($where_daily_limit);
                        $daily_returnResponse = iterator_to_array($daily_return);
                        
                        //end get user daily limit 
                      
              
                        //sold avg calculate 

                        $where_sold_order['application_mode']       =  'live';
                        $where_sold_order['admin_id']               =  (string)$user['_id'];
                        $where_sold_order['created_date']           =  ['$gte' => $mongo_time, '$lte' => $current];
                        $where_sold_order['is_sell_order']          =  'sold';
                        $where_sold_order['trigger_type']           =  "barrier_percentile_trigger";
                        $where_sold_order['status']                 =  'FILLED';
                        $where_sold_order['resume_status']          =  ['$exists' => false];
                        $where_sold_order['cost_avg']               =  ['$exists' => false];
                        $where_sold_order['cavg_parent']            =  ['$exists' => false];

                        $this->mongo_db->where($where_sold_order);
                        $data = $this->mongo_db->get($soldCollectionName);
                        $total_sold_rec = iterator_to_array($data);

                        $sold_purchase_price = 0;                          
                        $per_trade_sold = 0;
                        $avg_sold = 0;
                        $investProfitBTC = 0;
                        $investProfitUSDT = 0;
                        $usdtInvestmentCal = 0;
                        $btcInvestmentCal = 0;

                        if(count($total_sold_rec) > 0){
                          foreach($total_sold_rec as $sold_orders){
                            $sold_purchase_price += (float) ($sold_orders['market_sold_price'] - $sold_orders['purchased_price']) / $sold_orders['purchased_price'];											

                            if(in_array($sold_orders['symbol'], $btc_coin_in_arr)){
                              
                              $btc += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                              $btcInvestmentCal += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                              $investProfitBTC += $sold_orders['market_sold_price'] * $sold_orders['quantity'];
                            }elseif(in_array($sold_orders['symbol'], $coinArrayUSDT)){
                            
                              $usdtInvestmentCal += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                              $usdt += $sold_orders['purchased_price'] * $sold_orders['quantity'];
                              $investProfitUSDT += $sold_orders['market_sold_price'] * $sold_orders['quantity'];
                            }
                          } //end check
                        }//end foreach

                        $convert = 0;
                        if($btc > 0){
                          $convert = $btcusdt * $btc;
                        }
                        if($investProfitBTC > 0){
                          $investProfitBTC = $btcusdt * $investProfitBTC;
                        }
                        if($btcInvestmentCal > 0){
                          $btcInvestmentCal = $btcusdt * $btcInvestmentCal;
                        }
                        $actualProfitLastMonthInSoldOrders = ($investProfitUSDT + $investProfitBTC) - ($btcInvestmentCal + $usdtInvestmentCal);
                        $per_trade_sold = (float) $sold_purchase_price * 100;
                        
                        if(count($total_sold_rec) > 0){
                          $avg_sold = ($per_trade_sold / count($total_sold_rec));
                        }else{
                          $avg_sold = 0;
                        }

                        //end 1 month sold orders avg calculation 
    

                        //consumed points get 
                        $agregate = [
                          [
                            '$match' => [
                              'user_id' => (string)$user['_id'],
                              'action'  => 'deduct'
                            ],
                          ],
                            [
                              '$group' => [
                                '_id' => 1,
                                'totalPoints' => ['$sum' => '$points_consumed']
                              ],
                            ],
                        ];
                        $data = $custom->trading_points_history->aggregate($agregate);
                        $response = iterator_to_array($data);
                        //end consumed point get 


                        //get user limit buy and calculate trading points 
                        $conditionGetHistoryRecord = ['sort' => ['created_date' => -1], 'limit' => 1];
                        $getPreviousHistoryLimit['user_id'] = (string)$user['_id'];
                        $getUserLimitHistory  = $custom->$dailyTradeLimitCollectionHistory->find($getPreviousHistoryLimit, $conditionGetHistoryRecord);
                        $gotDataReturnHistory = iterator_to_array($getUserLimitHistory);
                        // unset($getUserLimitHistory);
 
                        //canculating today buy percentage
                        if($daily_returnResponse[0]['daily_bought_btc_usd_worth'] == 0) {
                          $todayBuyPercentagebtc = 0;
                        }elseif($daily_returnResponse[0]['daily_bought_btc_usd_worth'] == $daily_returnResponse[0]['dailyTradeableBTC_usd_worth']){  
                          $todayBuyPercentagebtc = 100;
                        }else{
                          $todayBuyPercentagebtc = ($daily_returnResponse[0]['daily_bought_btc_usd_worth'] / $daily_returnResponse[0]['dailyTradeableBTC_usd_worth'])*100;
                        } 

                        if($daily_returnResponse[0]['daily_bought_usdt_usd_worth'] == 0) {
                          $todayBuyPercentageusdt = 0;
                        }elseif($daily_returnResponse[0]['daily_bought_usdt_usd_worth'] == $daily_returnResponse[0]['dailyTradeableUSDT_usd_worth']){  
                          $todayBuyPercentageusdt = 100;
                        }else{
                          $todayBuyPercentageusdt = ($daily_returnResponse[0]['daily_bought_usdt_usd_worth'] / $daily_returnResponse[0]['dailyTradeableUSDT_usd_worth'])*100;
                        } 
                        //end

                        //canculating previous day buy percentage
                        if($gotDataReturnHistory[0]['daily_bought_btc_usd_worth'] == 0){
                          $previousBuyPercentagebtc = 0;
                        }elseif($gotDataReturnHistory[0]['dailyTradeableBTC_usd_worth'] == $gotDataReturnHistory[0]['daily_bought_btc_usd_worth'] && $gotDataReturnHistory[0]['daily_bought_btc_usd_worth'] !=0 && $gotDataReturnHistory[0]['dailyTradeableBTC_usd_worth'] !=0){
                          $previousBuyPercentagebtc = 100;
                        }else{
                          $previousBuyPercentagebtc = ($gotDataReturnHistory[0]['daily_bought_btc_usd_worth']/ $gotDataReturnHistory[0]['dailyTradeableBTC_usd_worth'] )*100;
                        }

                        if($gotDataReturnHistory[0]['daily_bought_usdt_usd_worth'] == 0){
                          $previousBuyPercentageusdt = 0;
                        }elseif($gotDataReturnHistory[0]['dailyTradeableUSDT_usd_worth'] == $gotDataReturnHistory[0]['daily_bought_usdt_usd_worth'] && $gotDataReturnHistory[0]['daily_bought_usdt_usd_worth'] !=0 && $gotDataReturnHistory[0]['dailyTradeableUSDT_usd_worth'] !=0){
                          $previousBuyPercentageusdt = 100;
                        }else{
                          $previousBuyPercentageusdt = ($gotDataReturnHistory[0]['daily_bought_usdt_usd_worth']/ $gotDataReturnHistory[0]['dailyTradeableUSDT_usd_worth'] )*100;
                        }
                        //end


                        if(($open_balance_converted + $open_usdt) == 0){
                          $openBalancePercentage = 0;
                        }else{
                          $openBalancePercentage = (($open_balance_converted + $open_usdt) / $trade_limit)*100; //(($total_usdt_balance + $total_usdt_balance_converted_total + $open_balance_converted + $open_usdt + $lth_balance_converted + $lth_usdt)))*100;
                        }
                        if(($lth_balance_converted + $lth_usdt) == 0){
                          $lthBalancePercentage = 0;
                          $lthBalanceUsdtpercentageBam = 0 ;
                          $lthBalanceBtcpercentageBam  = 0 ;
                        }else{
                          $lthBalanceUsdtpercentageBam = ($lth_usdt / $trade_limit) *100;
                          $lthBalanceBtcpercentageBam  = ($lth_balance_converted /$trade_limit) *100;
                          $lthBalancePercentage = ((($lth_balance_converted + $lth_usdt)) / $trade_limit)*100; //($total_usdt_balance + $total_usdt_balance_converted_total + $open_balance_converted + $open_usdt + $lth_balance_converted + $lth_usdt))*100;
                        } 
                        echo "<br>total_usdt_balance_converted_total:".$total_usdt_balance_converted_total.' :total_usdt_balance: '.$total_usdt_balance." : lthBTCSUDT: ".$lthBTCSUDT. ": openBTCSUDT: " .$openBTCSUDT;
                        //end get user limit buy and trading calculate points 


                        //get active parent details 
                        $activeParents['admin_id'] = (string)$user['_id'];
                        $activeParents['application_mode'] = 'live';
                        $activeParents['parent_status'] = 'parent'; 
                        $activeParents['status'] = 'new';
                        $activeParents['pause_status'] = 'play';

                        $activeParentsReturn = $custom->$buyCollectionName->count($activeParents);
                        //end get active parent details 

                        //get taking orders parent 
                        $takingOrder['admin_id'] = (string)$user['_id'];
                        $takingOrder['application_mode'] = 'live';
                        $takingOrder['parent_status'] = 'parent'; 
                        $takingOrder['status'] = 'takingOrder';
                        $takingOrder['pause_status'] = 'play';
                        
                        $takingOrderReturn = $custom->$buyCollectionName->count($takingOrder);

                        //end get taking order parent 

                        // last month consumed points get

                        $startTime = $this->mongo_db->converToMongodttime(date('Y-m-1 00:00:00'));
                        $endTime   = $this->mongo_db->converToMongodttime(date('Y-m-d 23:59:59'));

                        $getConsumedPoints['user_id'] = (string)$user['_id'];
                        $getConsumedPoints['created_date'] = [['$gte' => $startTime], ['$lte' => $endTime]];


                        // check api is valid or not 
                        // $payLoadExchangeVarify = [
                        //   'exchange'   => "bam",
                        //   'user_id'    =>  (string)$user['_id']
                        // ];
                        
                        // $curl = curl_init();
                        // $jsondataPayLoad = json_encode($payLoadExchangeVarify);
                        // curl_setopt_array($curl, array(
                        //   CURLOPT_URL => "https://app.digiebot.com/admin/api_calls/verify_api_key_secret",
                        //   CURLOPT_RETURNTRANSFER => true,
                        //   CURLOPT_ENCODING => "",
                        //   CURLOPT_MAXREDIRS => 10,
                        //   CURLOPT_TIMEOUT => 30,
                        //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        //   CURLOPT_CUSTOMREQUEST => "POST",
                        //   CURLOPT_POSTFIELDS => $jsondataPayLoad,
                        //   CURLOPT_HTTPHEADER => array(
                        //     "cache-control: no-cache",
                        //     "content-type: application/json",
                        //   ),
                        // ));
                        // $responseExchange = curl_exec($curl);
                        // $err = curl_error($curl);
                        // curl_close($curl);
                        // $exchangeVirificationResponse = json_decode($responseExchange);

                        // if($exchangeVirificationResponse->status == 1 || $exchangeVirificationResponse->message == "valid key secret"){
                        //   $exchangeStatus = 'yes';
                        // }else{
                        //   $exchangeStatus = 'no';
                        // }


                        $group = [
                          [
                            '$match' => [
                              'user_id' => (string)$user['_id'],
                              'created_date' => ['$gte' => $startTime, '$lte' => $endTime] 
                            ]
                          ],
                          [
                          '$group' => [
                            '_id' =>  null,
                            'lastMonthConsumedPoints' => ['$sum' => '$points_consumed']
                            ] 
                          ],
                        ];

                        $lastMonthConsumedPointsQuery  = $custom->trading_points_history->aggregate($group);
                        $lastMonthConsumedPointsReturn = iterator_to_array($lastMonthConsumedPointsQuery);
                        
                        $totalAccountWorth = ($costAvgUsdt + $costAcgBTCSUDT + $costAvgConvertBalance + $total_usdt_balance + $total_usdt_balance_converted_total + $open_balance_converted + $open_usdt + $lth_balance_converted + $lth_usdt + $lthBTCSUDT + $openBTCSUDT);
                        
                        $array_update = array(
                          'first_name'                        =>    $user['first_name'],
                          'last_name'                         =>    $user['last_name'],
                          'profile_pic'                       =>    $user['profile_image'],
                          'username'                          =>    $user['username'],
                          'admin_id'                          =>    (string)  $user['_id'],
                          'costAvgOrder'                      =>    count($orderReturnResponseCost),
                          'costAvgBalance'                    =>    (float)  ($costAvgUsdt + $costAcgBTCSUDT + $costAvgConvertBalance),
                          'costAvgBtcBalance'                 =>    (float)  ($costAvgTotalBtc),
                          'costAvgUsdtBalance'                =>    (float)  $costAvgUsdt, 
                          'takingOrderParents'                =>    (float)  $takingOrderReturn,
                          'newOrderParents'                   =>    (float)  $activeParentsReturn,
                          'tradingIp'                         =>    (string) $user['trading_ip'],
                          'thisMonthConsumedPoints'           =>    (float)$lastMonthConsumedPointsReturn[0]['lastMonthConsumedPoints'],
                          'avg_sold'                          =>    (float)  $avg_sold,
                          'lastMonthProfitSoldOrders'         =>    $actualProfitLastMonthInSoldOrders,
                          'open_order'                        =>    (float)  count($order_return_response_open),
                          'lth_order'                         =>    (float)  count($order_return_response_lth),
                          'actual_deposit'                    =>    (float)  $totalAccountWorth,
                          'total_balance'                     =>    (float)  ($total_usdt_balance_converted_total + $total_usdt_balance) - ($lthBTCSUDT + $openBTCSUDT + $costAcgBTCSUDT),
                          'open_balance'                      =>    (float)  ($open_balance_converted + $open_usdt+ $openBTCSUDT),    
                          'lth_balance'                       =>    (float)  ($lth_balance_converted + $lth_usdt + $lthBTCSUDT), 
                          'avaliableBtcBalance'               =>    (float)  $total_btc_balance,
                          'avaliableUsdtBalance'              =>    (float)  $total_usdt_balance, 
                          'openBalancePercentage'             =>    (float)  $openBalancePercentage,
                          'lthBalancePercentage'              =>    (float)  ($lthBalanceUsdtpercentageBam + $lthBalanceBtcpercentageBam) ,

                          'lthBalanceUsdtpercentage'          =>    (float)$lthBalanceUsdtpercentageBam ,
                          'lthBalanceBtcpercentage'           =>    (float)$lthBalanceBtcpercentageBam,

                          'customBtcPackage'                  =>    $customBtcPackage,
                          'customUsdtPackage'                 =>    $customUsdtPackage,

                          'joining_date'                      =>    $user['created_date'],
                          'bnb_balance'                       =>    (float)  $bnb,
                          'exchange'                          =>    $exchangeName,
                          'lth_usdt'                          =>    (float)  $lth_usdt,
                          'open_usdt'                         =>    (float)  $open_usdt,
                          'lthBTCTotal'                       =>    (float)  $lthBTCTotal,
                          'openTotalBtc'                      =>    (float)  $openTotalBtc,
                          'previousDayLimitWas'               =>    $gotDataReturnHistory[0]['daily_buy_usd_limit'],
                          'previousdayGetCount'               =>    $gotDataReturnHistory[0]['num_of_trades_buy_today'],
                          'previousDayLimitBuy'               =>    $gotDataReturnHistory[0]['daily_buy_usd_worth'], 
                          'invest_amount'                     =>    (float)  ($usdt + $convert),
                          'consumed_points'                   =>    $response[0]['totalPoints'],
                          'totalPointsApi'                    =>    $userTotalPointsApiResponse,
                          'remainingPoints'                   =>    $userTotalPointsApiResponse - $response[0]['totalPoints'],
                          'daily/trade_count'                 =>    (float)  $daily_returnResponse[0]['num_of_trades_buy_today'],
                          'daily/trade_$'                     =>    (float)  $daily_returnResponse[0]['daily_buy_usd_worth'], 
                          
                          'tradingStatus'                     =>    $user['trading_status'],

                          'dailyTradeBuyBTCIn$'               =>    (float)  $daily_returnResponse[0]['daily_bought_btc_usd_worth'], 
                          'dailyBtcBuyTradeCount'             =>    (float)  $daily_returnResponse[0]['BTCTradesTodayCount'],
                          'dailyTradeBuyUSDT'                 =>    (float)  $daily_returnResponse[0]['daily_bought_usdt_usd_worth'], 
                          'dailyUSDTBuyTradeCount'            =>    (float)  $daily_returnResponse[0]['USDTTradesTodayCount'],

                          'previousDailyTradeBuyBTCIn$'       =>    (float)  $gotDataReturnHistory[0]['daily_bought_btc_usd_worth'], 
                          'previousDailyBtcBuyTradeCount'     =>    (float)  $gotDataReturnHistory[0]['BTCTradesTodayCount'],  
                          'previousDailyTradeBuyUSDT'         =>    (float)  $gotDataReturnHistory[0]['daily_bought_usdt_usd_worth'], 
                          'previousDailyUSDTBuyTradeCount'    =>    (float)  $gotDataReturnHistory[0]['USDTTradesTodayCount'],

                          'last_trade_sold'                   =>    $res_sold[0]['sell_date'],
                          'last_trade_buy'                    =>    $res[0]['buy_date'],
                          'month'                             =>    date('m'),
                          'btcInvestPercentage'               =>    $btcInvestPercentage,
                          'usdtInvestPercentage'              =>    $usdtInvestPercentage,
                          'dailTradeAbleBalancePercentage'    =>    $dailTradeAbleBalancePercentage, 

                          'todayBuyPercentagebtc'             =>    $todayBuyPercentagebtc,
                          'todayBuyPercentageusdt'            =>    $todayBuyPercentageusdt,

                          'previousBuyPercentagebtc'          =>    $previousBuyPercentagebtc,
                          'previousBuyPercentageusdt'         =>    $previousBuyPercentageusdt,

                          'trade_limit'                       =>    (float)  $trade_limit,
                          'last_login_time'                   =>    $user['last_login_datetime'], 
                          'sold_trades'                       =>    $order_return ,
                          // 'exchange_enabled'                  =>    $exchangeStatus,
                          'modified_time'                     =>    $current_time_date,
                          'pakageStatusBTC'                   =>    $actualTradeableBTC,
                          'pakageStatusUSDT'                  =>    $actualTradeableUSDT,
                          'per_day_limit'                     =>    (float)  $daily_returnResponse[0]['daily_buy_usd_limit'],
                          'dailyTradeableUSDTLimit'           =>    (float)  $daily_returnResponse[0]['dailyTradeableUSDT_usd_worth'],
                          'dailyTradeableBTCLimit$'           =>    (float)  $daily_returnResponse[0]['dailyTradeableBTC_usd_worth'],
                          'PreviousDailyTradeableUSDTLimit'   =>    (float)  $gotDataReturnHistory[0]['dailyTradeableUSDT_usd_worth'],
                          'PreviousDailyTradeableBTCLimit$'   =>    (float)  $gotDataReturnHistory[0]['dailyTradeableBTC_usd_worth']
                        );

                         if($totalAccountWorth >= $trade_limit){
                            $array_update['tradeAbleBalanceBaseOnPakge']  =  $trade_limit;
                          }else{
                            $array_update['tradeAbleBalanceBaseOnPakge']  =  $totalAccountWorth;
                          }
                        // check auto trading setting 
                        if(count($atg_returnResponse) > 0 ){
                          $array_update['agt'] = 'yes';
                        }else{
                          $array_update['agt'] = 'no';
                        }

                        // get user limit buy history 
                        $agregateHistory = [
                          [
                            '$match' => [
                              'user_id' => (string)$user['_id']
                            ],
                          ],
                            [
                              '$project' => [
                                '_id'                           =>  '$_id',
                                'daily_bought_btc_usd_worth'    =>  '$daily_bought_btc_usd_worth',
                                'BTCTradesTodayCount'           =>  '$BTCTradesTodayCount',
                                'daily_bought_usdt_usd_worth'   =>  '$daily_bought_usdt_usd_worth',
                                'USDTTradesTodayCount'          =>  'USDTTradesTodayCount',
                                'dailyTradeableUSDT_usd_worth'  =>  'dailyTradeableUSDT_usd_worth',
                                'dailyTradeableBTC_usd_worth'   =>  'dailyTradeableBTC_usd_worth',
                                'created'                       =>  '$created_date'
                              ],
                            ],
                            [
                              '$sort'  => ['created_date' => -1],
                            ],
                              ['$limit' => 8]
                        ];
                        $dailyReturnHistory = $custom->$dailyTradeLimitCollectionHistory->aggregate($agregateHistory);
                        $dailyReturnHistoryResponse = iterator_to_array($dailyReturnHistory);
                        $array_update['history'] = $dailyReturnHistoryResponse;

                        //end get user buy limit history
                        echo "<pre>";print_r($array_update);

                        $update_where['username'] = $user['username'];
                      
                        $upsert['upsert'] = true;
                        $custom->$collection_name->updateOne($update_where, ['$set'=> $array_update], $upsert);
                      }// end varify user credentials
                      $array_update_in_user_colection['is_modified_actual_report_bam'] = $current_time_date;
                      $search_find['_id']  = $user['_id'];
                      $search_find['username'] = $user['username'];
            
                      $this->mongo_db->where($search_find);
                      $this->mongo_db->set($array_update_in_user_colection); 
                      $this->mongo_db->update('users');
                    } //end loop
                  }//end if
                }// end cron function


                public function GetRandomAPIaccessToken(){
                  $token_array = array (
                    'cf31f1bc3a0b3729f35832ff25c7f838',
                    '34e0e2a1b05b11dccec3a1f0e55f12ed',
                    'cd6d40934f1b41485a34e551961dea47',
                    '674cf50e89bac56f29d1e7c919608247',
                    'd34aaa3fb16773581167023ddda3b9b2',
                    'e1812af878fb6323b022658aeab88981',
                    '16f1f98832e8a22d334583d1b55ca74e',
                    'e5f604c9e53e8bd397f7a0299a6c67ee',
                    'ec4724447307c2973de0bda64c8ac4f7',
                    'f221ca4ba18d776579cc442defd63c59',
                    '2ef28a3a254745dd124b9425e2c54826',
                    'cfa03debbee649ff160a6b74d83d8ff8',
                    '95b119e31ad12564723790193f118231',
                    '035b4ed3b93bae0e5f912acaf0dbb914',
                    '647240ad2a6edd157c7986261d8527ee',
                    '671837b9788b7f5b59f00815b74cd889',
                    'df632a8d5703229bc031ce40e6dc16d9',
                    '83c86ede18cc3bb07f9ecde100631f1e',
                    '303da99664d5acc06de8ecda890ce52b',
                    '81d1d45dbb19a90fdfae4f87865b136a',
                    '63cdf744b7d76f27357ba1722da51ee6'
                  );
                  return $token_array[array_rand($token_array)];
                }//end function

                // new function
                public function investment_report(){

                  $this->mod_login->verify_is_admin_login();
                  $custom = $this->mongo_db->customQuery();
                  
                  if($this->input->post()){

                    $this->session->unset_userdata('filter_investment_report');

                    $filter_data['filter_investment_report'] = $this->input->post();
                    $this->session->set_userdata($filter_data);

                  }

                  if(!empty($_GET['button']) ){

                    $this->session->unset_userdata('filter_investment_report');

                    $user_data_get['button']   = $_GET['button'];
                    if($_GET['button'] == 'less_trade_kraken_14' || $_GET['button'] ==  'less_trade_kraken' || $_GET['button'] == 'noTrade_kraken' || $_GET['button'] == 'lowTrading_kraken' ||  $_GET['button'] == 'extra_kraken' ||  $_GET['button'] == 'less_kraken'){

                      $user_data_get['exchange'] = 'kraken';
                    }else{

                      $user_data_get['exchange'] = 'binance';
                    }

                    $filter_data['filter_investment_report'] = $user_data_get;
                    $this->session->set_userdata($filter_data);

                  } 

                  $user_data = $this->session->userdata('filter_investment_report');
                  
                  $collection_name = 'user_investment_'.$user_data['exchange'];

                  if($user_data['button'] == 'noTrade'  || $user_data['button'] == 'noTrade_kraken'){

                    $start = date('Y-m-d 00:00:00', strtotime('-7 days'));
                    $joininTime = $this->mongo_db->converToMongodttime($start );   
                    $search = [

                      'agt'               =>  'yes',
                      'exchange_enabled'  =>  'yes',
                      'open_order'        =>   0 ,
                      'lth_order'         =>   0 ,
                      'costAvgOrder'      =>   0,
                      'sold_trades'       =>   0,
                      'total_balance'     =>   ['$gt' => 0],
                      'joining_date'      =>   ['$lte'  => $joininTime]
                    ];

                  }elseif($user_data['button'] == 'lowTrading' ||  $user_data['button'] == 'lowTrading_kraken'){ 
                    $start = date('Y-m-d 00:00:00', strtotime('-14 days'));
                    $joininTime = $this->mongo_db->converToMongodttime($start );
                    
                    //if last 7 days total trades are 14 or less show the user 
                    $search = [
                      'agt'                                     =>  'yes',
                      'exchange_enabled'                        =>  'yes',
                      'total_balance'                           =>  ['$gt' => 0],
                      'totalbuySellOrdersCountWithinSavenDays'  =>  ['$lt' => 14],
                      'joining_date'                            =>  ['$lte'  => $joininTime]
                    ];                   
                  }

                  if($user_data['button'] == 'less_trade_kraken' ||  $user_data['button'] == 'less_trade_binance'){  

                    $search = [
                      'total_balance'                           =>  ['$gt' => 1000],
                      'totalbuySellOrdersCountWithinSavenDays'  =>  ['$lt' => 20],
                    ];        
                  }

                  if($user_data['button'] == 'less_trade_kraken_14' ||  $user_data['button'] == 'less_trade_binance_14'){    

                    $search = [
                      'total_balance'                           =>  ['$gt' => 10, '$lt' => 1000],  
                      'totalbuySellOrdersCountWithinSavenDays'  =>  ['$lt' => 14],
                    ];        
                  }

                   
                  if($user_data['exchange'] == 'binance' ){
                    $search['status']['$ne'] = 'hideBinance';
                  }

                  if($user_data['button'] == 'extra_kraken' || $user_data['button'] == 'extra_binance'){

                    $search['$expr'] =  ['$gt' => ['$extraBalance',  '$fivePercentOfTotalBalance' ]];

                  }   
                  

                  if($user_data['sort'] =='' || !isset($user_data['sort'])){

                    $sorting = 'joining_date';    
                  }else{

                    $sorting = $user_data['sort'];
                  }
                  if($user_data['sortedBy']){

                    $sortedBuy = (integer)$user_data['sortedBy'];
                  }else{

                    $sortedBuy = -1;
                  }

                  if(!empty($user_data['accountIssueFilter'])){

                    $startDate = date('Y-m-d 00:00:00', strtotime('-30 days'));
                    $startMongoTime = $this->mongo_db->converToMongodttime($startDate );

                    $endMongoTime = $this->mongo_db->converToMongodttime(date('Y-m-d 23:59:59'));

                    if($user_data['accountIssueFilter'] == 'activeTodayBtcIssueAccount'){

                      $search = [
                        'dailyTradeableBTCLimit$'   =>  ['$gte' => 10], 
                        'agt'                       =>  'yes',
                        'newOrderParents'           =>  ['$gt' => 0 ],
                        'avaliableBtcBalance'       =>  ['$gt' => 0 ],
                        'exchange_enabled'          =>  'yes',
                        'remainingPoints'           =>  ['$gt' => 0 ],
                        'dailyTradeBuyBTCIn$'       =>  0,
                      ];
                    }elseif($user_data['accountIssueFilter'] == 'activeTodayUsdtIssueAccount'){

                      $search = [
                        'dailyTradeableUSDTLimit'   =>  ['$gte' => 10], 
                        'agt'                       =>  'yes',
                        'newOrderParents'           =>  ['$gt' => 0 ],
                        'avaliableUsdtBalance'      =>  ['$gt' => 10 ],
                        'exchange_enabled'          =>  'yes',
                        'remainingPoints'           =>  ['$gt' => 0 ],
                        'dailyTradeBuyUSDT'         =>  0,
                      ];

                    }elseif($user_data['accountIssueFilter'] == 'activePreviousDayBtcIssueAccount'){

                      $search = [
                        'PreviousDailyTradeableBTCLimit$'   =>  ['$gte' => 10], 
                        'agt'                               =>  'yes',
                        'newOrderParents'                   =>  ['$gt' => 0 ],
                        'avaliableBtcBalance'               =>  ['$gt' => 0 ],
                        'exchange_enabled'                  =>  'yes',
                        'remainingPoints'                   =>  ['$gt' => 0 ],
                        'previousDailyTradeBuyBTCIn$'       =>  0,
                      ];

                    }elseif($user_data['accountIssueFilter'] == 'activePreviousDayUsdtIssueAccount'){

                      $search = [
                        'PreviousDailyTradeableUSDTLimit'   =>  ['$gte' => 10], 
                        'agt'                               =>  'yes',
                        'newOrderParents'                   =>  ['$gt' => 0 ],
                        'avaliableUsdtBalance'              =>  ['$gt' => 10 ],
                        'exchange_enabled'                  =>  'yes',
                        'remainingPoints'                   =>  ['$gt' => 0 ],
                        'previousDailyTradeBuyUSDT'         =>  0,
                      ];

                    }elseif($user_data['accountIssueFilter'] == 'newActiveTodayBtcIssueAccount'){
                      
                      $search = [
                        'dailyTradeableBTCLimit$'   => ['$gte' => 10], 
                        'agt'                       => 'yes',
                        'newOrderParents'           => ['$gt' => 0 ],
                        'avaliableBtcBalance'       => ['$gt' => 0 ],
                        'exchange_enabled'          => 'yes',
                        'remainingPoints'           => ['$gt' => 0 ],
                        'joining_date'              => ['$gte' => $startMongoTime, '$lte' => $endMongoTime],
                        'dailyTradeBuyBTCIn$'       => 0,
                      ];

                    }elseif($user_data['accountIssueFilter'] == 'newActiveTodayUsdtIssueAccount'){

                      $search = [
                        'dailyTradeableUSDTLimit'   => ['$gte' => 10], 
                        'agt'                       => 'yes',
                        'newOrderParents'           => ['$gt' => 0 ],
                        'avaliableUsdtBalance'      => ['$gt' => 10 ],
                        'exchange_enabled'          => 'yes',
                        'remainingPoints'           => ['$gt' => 0 ],
                        'joining_date'              => ['$gte' => $startMongoTime, '$lte' => $endMongoTime],
                        'dailyTradeBuyUSDT'         => 0,
                      ];

                    }elseif($user_data['accountIssueFilter'] == 'newActivePreviousDayBtcIssueAccount'){

                      $search = [
                        'PreviousDailyTradeableBTCLimit$'   => ['$gte' => 10], 
                        'agt'                               => 'yes',
                        'newOrderParents'                   => ['$gt' => 0 ],
                        'avaliableBtcBalance'               => ['$gt' => 0 ],
                        'exchange_enabled'                  => 'yes',
                        'remainingPoints'                   => ['$gt' => 0 ],
                        'joining_date'                      => ['$gte' => $startMongoTime, '$lte' => $endMongoTime],
                        'previousDailyTradeBuyBTCIn$'       => 0,
                      ];

                    }elseif($user_data['accountIssueFilter'] == 'newActivePreviousDayUsdtIssueAccount'){

                      $search = [
                        'PreviousDailyTradeableUSDTLimit'   => ['$gte' => 10], 
                        'agt'                               => 'yes',
                        'newOrderParents'                   => ['$gt' => 0 ],
                        'avaliableUsdtBalance'              => ['$gt' => 10 ],
                        'exchange_enabled'                  => 'yes',
                        'remainingPoints'                   => ['$gt' => 0 ],
                        'joining_date'                      => ['$gte' => $startMongoTime, '$lte' => $endMongoTime],
                        'previousDailyTradeBuyUSDT'         => 0,
                      ];

                    }elseif($user_data['accountIssueFilter'] == 'activeStuckAccount'){

                      $search = [
                        'agt'                               => 'yes',
                        'newOrderParents'                   => ['$gt' => 0 ],
                        'exchange_enabled'                  => 'yes',
                        'lthBalancePercentage'              => ['$gte' => 70],
                      ];
                    }elseif($user_data['accountIssueFilter'] == 'newActiveStuckAccount'){

                      $search = [
                        'agt'                               => 'yes',
                        'newOrderParents'                   => ['$gt' => 0 ],
                        'exchange_enabled'                  => 'yes',
                        'lthBalancePercentage'              => ['$gte' => 70],
                        'joining_date'                      => ['$gte' => $startMongoTime, '$lte' => $endMongoTime],
                      ];
                    }
                  }

                  if(!empty($user_data['customValue']) && !empty($user_data['customFilters']) ){   
                    
                    $fieldName  = $user_data['customFilters'];
                    $value      = (integer)$user_data['customValue']; 
                    $search['$expr'] =  ['$gte' => ["$".$fieldName , $value]];
                  }

                  foreach($user_data['filter_select'] as $filter){
                    if($filter == 'limit_exceed_btc'){
                      $search['$expr'] =  ['$gt' => [ '$dailyTradeBuyBTCIn$' , '$dailyTradeableBTCLimit$' ] ];
                    }
                    if($filter == 'limit_exceed_usdt'){
                      $search['$expr'] =  ['$gt' => [ '$dailyTradeBuyUSDT' , '$dailyTradeableUSDTLimit' ] ];
                    }
                     
                    if($filter == 'takingOrderParents'){
                      $search['takingOrderParents'] = ['$gt' => 0 ];
                    }
                    if($filter == 'newOrderParents'){
                      $search['newOrderParents'] = ['$gt' => 0 ];
                    }

                    if($filter =='previous_limit_exceed_btc'){
                      $search['$expr'] =  ['$gt' => ['$previousDailyTradeBuyBTCIn$' , '$PreviousDailyTradeableBTCLimit$'] ];
                    }
                    if($filter =='previous_limit_exceed_usdt'){
                      $search['$expr'] =  ['$gt' => ['$previousDailyTradeBuyUSDT' , '$PreviousDailyTradeableUSDTLimit'] ];
                    }
                    
                    if($filter =='bnb'){
                      $search['bnb_balance'] = ['$gt' => 0 ];
                    }

                    if($filter =='bnbNotExists'){
                      $search['bnb_balance'] = ['$lte' => 0 ];
                    }
                   
                    if($filter =='balance_exists'){
                      $search['total_balance'] = ['$gt' => 15 ];
                    }

                    if($filter =='USDTbalance_exists'){
                      $search['avaliableUsdtBalance'] = ['$gt' => 0 ];
                    }

                    if($filter =='BTCbalance_exists'){
                      $search['avaliableBtcBalance'] = ['$gt' => 0 ];
                    }
                  
                    if($filter =='api_key'){
                      $search['exchange_enabled'] = 'yes';
                    }
                    if($filter =='api_key_not'){
                      $search['exchange_enabled'] = 'no';
                    }

                    if($filter =='block_user'){
                      $search['exchange_enabled'] = 'block';
                    }

                    if($filter =='pointsRemaningPositive'){
                      $search['remainingPoints'] = ['$gt' => 0 ];
                      
                    }

                    if($filter =='pointsRemaningNegitive'){
                      $search['remainingPoints'] = ['$lt' => 0 ];
                    }
                    
                    if($filter =='atg_enable'){
                      $search['agt'] = 'yes';
                    } 
                    if($filter =='atg_disable'){
                      $search['agt'] = 'no';
                    }
                    if($filter =='todayZerobtc'){
                      $search['dailyTradeBuyBTCIn$'] = 0; //todayZerousdt
                    }
                    if($filter =='todayZerousdt'){
                      $search['dailyTradeBuyUSDT'] = 0;
                    }
                    if($filter =='predayZerobtc'){ 
                      $search['previousDailyTradeBuyBTCIn$'] = 0;
                    }
                    if($filter =='predayZerousdt'){
                      $search['previousDailyTradeBuyUSDT'] = 0;
                    }
                    
                    if($filter =='join_last_week'){
                      $startDate = date('Y-m-d 00:00:00', strtotime('-7 days'));
                      $startMongoTime = $this->mongo_db->converToMongodttime($startDate );
  
                      $endDate = date('Y-m-d 23:59:59');
                      $endMongoTime = $this->mongo_db->converToMongodttime($endDate);
                      
                      $search['joining_date'] = array('$gte' => $startMongoTime, '$lte' => $endMongoTime);
                    }

                    if($filter =='greaterOne'){

                      $search['$or'] = [   ['dailyBtcBuyTradeCount' => ['$gt' => 0]], [  'dailyUSDTBuyTradeCount' => ['$gt' => 0]  ] ];

                    }

                    if($filter =='preGreaterOne'){

                      $search['$or'] = [   ['previousDailyUSDTBuyTradeCount' => ['$gt' => 0]], [  'previousDailyBtcBuyTradeCount' => ['$gt' => 0]  ] ];
                          
                    }
                    
                  }//end foreach

                  $search['month']['$in'] = array('01','02','03','04','05','06','07','08','09','10','11','12');

                  if($user_data['user_name'] ){

                    $search['username'] = $user_data['user_name']; //$this->input->post('user_name');
                  }
                  if( $search['status'] ){

                    if($search['status'] == 'active'){

                      $search['exchange_enabled'] = 'yes';
                    }elseif($search['status'] == 'inactive'){

                      $search['exchange_enabled'] = 'no';
                    }
                  }
                  if($search['tradingIp'] ){

                    $search['tradingIp'] = (string)$search['tradingIp'];
                  }
                  if($user_data['start_joining_date'] != "" &&  $user_data['end_joining_date'] != ""){
                    $start_expiry_datetime = date('Y-m-d G:i:s', strtotime($user_data['start_joining_date']));
                    $orig_date = new DateTime($start_expiry_datetime);
                    $orig_date = $orig_date->getTimestamp();
                    $start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);
      
                    $end_expiry_datetime = date('Y-m-d G:i:s', strtotime($user_data['end_joining_date']));
                    $orig_date22 = new DateTime($end_expiry_datetime);
                    $orig_date22 = $orig_date22->getTimestamp();
                    $end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
                    $search['joining_date'] = array('$gte' => $start_date, '$lte' => $end_date);
                  }   
                  if($user_data['startBuyPerbtc'] != "" &&  $user_data['endBuyPerbtc'] != ""){

                    $startBuyPerbtc = (float)$user_data['startBuyPerbtc'];
                    $endBuyPerbtc   = (float)$user_data['endBuyPerbtc'];
                    
                    $search['todayBuyPercentagebtc'] = array('$gte' => $startBuyPerbtc, '$lte' => $endBuyPerbtc);
                  }  

                  if($user_data['startBuyPerusdt'] != "" &&  $user_data['endBuyPerusdt'] != ""){ 

                    $start = (float)$user_data['startBuyPerusdt'];
                    $end   = (float)$user_data['endBuyPerusdt'];
                    
                    $search['todayBuyPercentageusdt'] = array('$gte' => $start, '$lte' => $end);
                  }   

                  if($user_data['startLimitbtc'] != "" &&  $user_data['endLimitbtc'] != ""){

                    $startLimit1 = (float)$user_data['startLimitbtc'];
                    $endLimit1   = (float)$user_data['endLimitbtc'];
                    
                    $search['dailyTradeableBTCLimit$'] = array('$gte' => $startLimit1, '$lte' =>  $endLimit1);
                  }  

                  if($user_data['startLimitusdt'] != "" &&  $user_data['endLimitusdt'] != ""){

                    $startLimit2 = (float)$user_data['startLimitusdt'];
                    $endLimit2   = (float)$user_data['endLimitusdt'];
                    
                    $search['dailyTradeableUSDTLimit'] = array('$gte' => $startLimit2, '$lte' =>  $endLimit2);
                  } 
                  

                  if(!empty($user_data['prestartBuyPerbtc']) &&  !empty($user_data['preEndBuyPerbtc'])){

                    $start2 = (float)$user_data['prestartBuyPerbtc'];
                    $end2   = (float)$user_data['preEndBuyPerbtc'];

                    $search['previousBuyPercentagebtc'] = array('$gte' => $start2, '$lt' => $end2);
                  }  

                  if($user_data['preStartBuyPerusdt'] != "" &&  $user_data['preEndBuyPerusdt'] != ""){

                    $start1 = (float)$user_data['preStartBuyPerusdt'];
                    $end1   = (float)$user_data['preEndBuyPerusdt'];

                    $search['previousBuyPercentageusdt'] = array('$gte' => $start1, '$lte' => $end1);
                  }   

                  $data_returnCount     =   $custom->$collection_name->count($search);
                  $data['total']        =   $data_returnCount;

                  $config['base_url']           =   base_url() .'admin/users_list/investment_report';
                  $config['total_rows']         =   $data_returnCount;
                  $config['per_page']           =   50;
                  $config['num_links']          =   3;
                  $config['use_page_numbers']   =   TRUE;
                  $config['uri_segment']        =   4;
                  $config['reuse_query_string'] =   TRUE;
                  $config['next_link']          =   '&raquo;';
                  $config['next_tag_open']      =   '<li>';
                  $config['next_tag_close']     =   '</li>';
                  $config['prev_link']          =   '&laquo;';
                  $config['prev_tag_open']      =   '<li>';
                  $config['prev_tag_close']     =   '</li>';
                  $config['first_tag_open']     =   '<li>';
                  $config['first_tag_close']    =   '</li>';
                  $config['last_tag_open']      =   '<li>';
                  $config['last_tag_close']     =   '</li>';
                  $config['full_tag_open']      =   '<ul class="pagination">';
                  $config['full_tag_close']     =   '</ul>';
                  $config['cur_tag_open']       =   '<li class="active"><a href="#"><b>';
                  $config['cur_tag_close']      =   '</b></a></li>'; 
                  $config['num_tag_open']       =   '<li>';
                  $config['num_tag_close']      =   '</li>';
            
                  $this->pagination->initialize($config);
                  $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            
                  if($page !=0) {
                    $page = ($page-1) * $config['per_page'];
                  }
                  $data["links"] = $this->pagination->create_links();

                  $condition = ['skip'=>$page, 'sort'=>[$sorting => $sortedBuy], 'limit' => $config['per_page']]; 
                  
                  $data_return = $custom->$collection_name->find($search, $condition);
                  $user_return_detail = iterator_to_array($data_return);

                  $data['final_array'] = $user_return_detail; 
                 
                  $this->stencil->paint('admin/users/Investment_report',$data); 
                }

                //enter date of good now button
                public function updateDate(){

                  $this->mod_login->verify_is_admin_login();
                  $custom = $this->mongo_db->customQuery();
                  
                  $collectionName = 'user_investment_'.$this->input->get('exchange');
                  $where['admin_id'] = (string)$this->input->get('admin_id');

                  $insertArray = [

                    'goodNowDate' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),   
                    'good_button' => 'hide'
                  ];
                  $count = $custom->$collectionName->updateOne($where, ['$set' => $insertArray]);
                  $this->investment_report();

                }//end 

                //enter date of contact button
                public function updateContactDate(){

                  $this->mod_login->verify_is_admin_login();
                  $custom = $this->mongo_db->customQuery();

                  $post_data = $this->input->post();
                  $collectionName     = 'user_investment_'.$post_data['exchange'];
                  $where['admin_id']  = (string)$post_data['admin_id'];

                  $insertArray = [

                    'contactNowDate' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'contact_button' => 'hide'  
                  ];
                  $count = $custom->$collectionName->updateOne($where, ['$set' => $insertArray]);
                  return true;
                }

                //save user profile comments
                public function addComments() {

                  $this->mod_login->verify_is_admin_login();
                  $custom = $this->mongo_db->customQuery();

                  $post_data          =   $this->input->post();
                  $collectionName     =   'user_investment_'.$post_data['exchange1'];
                  $where['admin_id']  =   (string)$post_data['admin_id1'];

                  $insertArray = [
                    'commentsDate'    => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'comments_button' => 'hide',
                    'comments'        =>  $post_data['comments'],
                  ];
                  
                  $count = $custom->$collectionName->updateOne($where, ['$set' => $insertArray]);

                  if($count->getModifiedCount() >= 1 ){
        
                    $this->session->set_flashdata('commentsMessage', 'Comments Added Successfully.');
                  }else{

                    $this->session->set_flashdata('commentsError', 'SomeThing Went Wrong.');
                  }
                  $this->investment_report();

                }//end

                public function resetFilter(){
                  $this->session->unset_userdata('filter_investment_report');
                  $this->investment_report();
                }

                public function get_all_usernames_ajax(){
                  $this->mongo_db->sort(array('_id' => -1));
                  $get_users = $this->mongo_db->get('user_investment_binance');
                  $users_arr = iterator_to_array($get_users);
                  $user_name_array = array_column($users_arr, 'username');
                  unset($users_arr, $get_users);
                  echo json_encode($user_name_array);
                  exit;
                }

                public function profile(){
                  $this->mod_login->verify_is_admin_login();

                  $admin_id  = (string)$this->input->get('admin_id');
                  $exchange  =  $this->input->get('exchange');

                  $collectionName = 'user_investment_'.$this->input->get('exchange');
                  $soldCollection = ($this->input->get('exchange') == 'binance') ?  'sold_buy_orders': 'sold_buy_orders_'.$this->input->get('exchange');
                  $db = $this->mongo_db->customQuery();
                  $where['admin_id']  =  $admin_id;

                  $getUserData = $db->$collectionName->find($where);
                  $getUserDataRes = iterator_to_array($getUserData);
                  $data['userData'] = $getUserDataRes;


                  $this->load->helper('new_common_helper');
                  $getpriceArray = getAllMarketValue('binance');
                  $pricesJsonArr = [];
          
                  foreach($getpriceArray as $key=>$val){
                    $pricesJsonArr[] = [
                      'symbol' => $key,
                      'price' => $val,
                    ];
                  }
          
                  $whereSOld['application_mode']     =    'live';
                  $whereSOld['admin_id']             =    $admin_id;
                  $whereSOld['is_sell_order']        =    'sold';
                  $whereSOld['trigger_type']         =    "barrier_percentile_trigger";
                  $whereSOld['status']               =    'FILLED';
                  $whereSOld['resume_status']        =    ['$exists' => false]; 
                  $percentage                        =    (float)100;

                  $count = $db->$soldCollection->count($whereSOld);

                  $lookUp = [
                    [
                      '$match' => [
                        'application_mode'     =>    'live',
                        'admin_id'             =>    $admin_id,
                        'is_sell_order'        =>    'sold',
                        'trigger_type'         =>    "barrier_percentile_trigger",
                        'status'               =>    'FILLED',
                        'resume_status'        =>    ['$exists' => false], 
                        'parent_status'        =>    ['$ne' => 'parent']
                      ]
                    ],


                    [
                      '$addFields' => [
                        'market_sold_price'  => ['$toDouble' => '$market_sold_price'],
                        'purchased_price'    => ['$toDouble' => '$purchased_price'],
                        'quantity'           => ['$toDouble' => '$quantity']
                        
                      ]
                    ],

                    [
                      '$group' => [
                        '_id'   => null,
                        'sumOfAllPurchasedPrices'  => ['$sum' =>  ['$divide' => [  ['$subtract' => ['$market_sold_price', '$purchased_price']], '$purchased_price']] ],

                        'totalQuantity'   =>  ['$sum' => ['$multiply'  =>  ['$quantity', '$purchased_price']]  ]
                      ]
                    ],


                    [
                      '$addFields' => [
                        'sumWithMultiply' => ['$multiply' => ['$sumOfAllPurchasedPrices', $percentage]]
                      ]
                    ],
                  

                    [
                      '$addFields' => [
                        'per_trade_avg' => ['$divide' => ['$sumWithMultiply', $count]]
                      ]
                    ],

                    [
                      '$addFields' => [
                        'avg_sold' => ['$divide' => ['$sumWithMultiply' , $count]]
                      ]
                    ],


                  ];

                  $getSold   = $db->$soldCollection->aggregate($lookUp);
                  $getSoldRes = iterator_to_array($getSold);
                  unset($getSold);
                
              
                  $data['per_trade_avg']   =  $getSoldRes[0]['per_trade_avg'];
                  $data['avg_sold']        =  $getSoldRes[0]['avg_sold'];
                
                  
                  $getErrorTradesDetails      =  getErrorTrades($exchange, $admin_id);
                  $getErrorTradesDetailsSold  =  getLastWeekSoldTrades($exchange, $admin_id);  
                  $getErrorTradesDetailsOpen  =  getLastWeekBuyButStillUnderOpenLTH($exchange, $admin_id);  


                  $data['errorTrades']       =   $getErrorTradesDetails;
                  $data['errorTradesSold']   =   $getErrorTradesDetailsSold;  
                  $data['errorTradesOpen']   =   $getErrorTradesDetailsOpen;
                  $data['exchange']          =   $exchange;

                  $collection = ($exchange == 'binance') ? 'weekly_user_wallet_stats' : 'weekly_user_wallet_stats_'.$exchange;


                  $lookup = [
                    [

                      '$match' => [

                        'user_id'  =>  (string)$admin_id

                      ]
                    ],

                    [
                      '$limit' => 7

                    ],

                    [
                      '$sort' => ['created_date' => -1],
                    ]
                  ];

                  $res = $db->$collection->aggregate($lookup);
                  $response = iterator_to_array($res);

                  $data['balanceDetails'] = $response;
                  $this->stencil->paint('admin/account_profile_health/account_health_profile', $data);
                }

                /* *************** Save user weekly balance stats ***************** */

                public function update_weekly_wallet_stats_binance(){

                  $db = $this->mongo_db->customQuery();
                  
                  // $start_date   =  $this->mongo_db->converToMongodttime(date('Y-m-d 00:00:00', strtotime('last sunday')));
                  // $end_date     =  $this->mongo_db->converToMongodttime(date('Y-m-d 23:59:59', strtotime('last sunday')));
                  
                  $getUsers= [
                    [
                      '$match' => [
                        'api_key'             =>  ['$exists' => true, '$nin' => ['', null]],
                        'api_secret'          =>  ['$exists' => true, '$nin' => ['', null]],

                        // '$or' => [
                        //   [
                        //     'weeklyBalanceHistory'  => ['$exists' => false],
                        //   ],
                        //   [
                        //     'weeklyBalanceHistory'  => ['$gte' => $start_date, '$lte' => $end_date],
                        //   ]
                        // ]

                      ]
                      
                    ],
                    // [
                    //   '$limit' => 10
                    // ]

                  ];

                  $details    =   $db->users->aggregate($getUsers);
                  $detailsRes =   iterator_to_array($details);

                  echo "<br>users count: ".count($detailsRes);

                  foreach ($detailsRes as $user){

                    $sumData = [
                      [
                        '$match' => [
                          'admin_id'    =>   (string)$user['_id'],
                        ]
                      ],
                      
                      [
                        '$project' => [
                          
                          '_id'                 =>  null,
                          'btc_account_worth'   =>  ['$subtract' => [ ['$sum' => [ '$openTotalBtc', '$lthBTCTotal', '$costAvgBtcBalance', '$avaliableBtcBalance']], '$btcusdtNegitiveTotal']],
                          'usdt_account_worth'  =>  ['$sum' => ['$open_usdt', '$lth_usdt', '$costAvgUsdtBalance', '$avaliableUsdtBalance']],
                         
                          'wallet_avaliableBtc' =>  ['$subtract' => ['$avaliableBtcBalance', '$btcusdtNegitiveTotal']],
                          'wallet_avaliableUsdt'=>  '$avaliableUsdtBalance', 
                         
                          'btcCommitted'        =>  ['$sum' => ['$openTotalBtc', '$lthBTCTotal', '$costAvgBtcBalance', '$btcusdtNegitiveTotal']],
                          'usdtCommitted'       =>  ['$sum' => ['$open_usdt', '$lth_usdt', '$costAvgUsdtBalance']],

                        ]
                      ],
                    ];
                    $investmentLog    =   $db->user_investment_binance->aggregate($sumData);
                    $investmentLogRes =   iterator_to_array($investmentLog);
  
                    $stats = [
                      'user_id'             =>  (string)$user['_id'],
                      'btc_account_worth'   =>  $investmentLogRes[0]['btc_account_worth'],
                      'usdt_account_worth'  =>  $investmentLogRes[0]['usdt_account_worth'],
                      'btc_user_wallet'     =>  $investmentLogRes[0]['wallet_avaliableBtc'],
                      'usdt_user_wallet'    =>  $investmentLogRes[0]['wallet_avaliableUsdt'],
                      'btc_committed'       =>  $investmentLogRes[0]['btcCommitted'],
                      'usdt_committed'      =>  $investmentLogRes[0]['usdtCommitted'],
                      'created_date'        =>  $this->mongo_db->converToMongodttime(date('Y-m-d G:i:s')),
                    ];

                    $pipeline = [
                      [
                        '$match' => [

                          'user_id' => (string)$user['_id'],
                        ]
                      ],

                      [
                        '$sort' => ['created_date' => -1]
                      ],

                      [
                      '$limit' => 1
                      ],

                    ];

                    $lastWeek = $db->weekly_user_wallet_stats->aggregate($pipeline);
                    $lastWeek = iterator_to_array($lastWeek);
                
                    if(!empty($lastWeek)){
                      $lastWeek = $lastWeek[0];
                      
                      $btc_weekly_gain  =  $investmentLogRes[0]['btc_account_worth']   - $lastWeek['btc_account_worth'];
                      $usdt_weekly_gain =  $investmentLogRes[0]['usdt_account_worth'] - $lastWeek['usdt_account_worth'];
                      
                      $stats['btc_weekly_gain']   =   $btc_weekly_gain;
                      $stats['usdt_weekly_gain']  =   $usdt_weekly_gain;
                    }
                    echo"<pre>";print_r($stats);


                    $insert =[
                      'weeklyBalanceHistory' =>  $this->mongo_db->converToMongodttime(date('Y-m-d G:i:s')),

                    ];

                    $whereUpdate['_id'] = $this->mongo_db->mongoId((string)$user['_id']);

                    $db->users->updateOne($whereUpdate,  ['$set' => $insert]);
                    $db->weekly_user_wallet_stats->insertOne($stats);
                    echo "<br>Successfully updated";

                  }//loop
                }

                /* *************** Save user weekly balance stats ***************** */

                public function update_weekly_wallet_stats_kraken(){

                  $db = $this->mongo_db->customQuery();

                  // $start_date   =  $this->mongo_db->converToMongodttime(date('Y-m-d 00:00:00', strtotime('last sunday')));
                  // $end_date     =  $this->mongo_db->converToMongodttime(date('Y-m-d 23:59:59', strtotime('last sunday')));
                  
                  $getUsers= [
                    [
                      '$match' => [
                        'api_key'             =>  ['$exists' => true, '$nin' => ['', null]],  
                        'api_secret'          =>  ['$exists' => true, '$nin' => ['', null]],
                      
                        // '$or' => [
                        //   [
                        //     'weeklyBalanceHistory'  => ['$exists' => false],
                        //   ],
                        //   [
                        //     'weeklyBalanceHistory'  => ['$gte' => $start_date, '$lte' => $end_date],
                        //   ]
                        // ]
                      ]
                    ],

                    // [
                    //   '$limit' => 10
                    // ]
                    
                  ];

                  $details    =   $db->kraken_credentials->aggregate($getUsers);
                  $detailsRes =   iterator_to_array($details);

                  echo "<br>users count: ".count($detailsRes);

                  foreach ($detailsRes as $user){

                    $sumData = [
                      [
                        '$match' => [
                          'admin_id'    =>   (string)$user['user_id'],
                        ]
                      ],
                      
                      [
                        '$project' => [
                          
                          '_id'                 =>  null,
                          'btc_account_worth'   =>  ['$subtract' => [ ['$sum' => [ '$openTotalBtc', '$lthBTCTotal', '$costAvgBtcBalance', '$avaliableBtcBalance']], '$btcusdtNegitiveTotal']],
                          'usdt_account_worth'  =>  ['$sum' => ['$open_usdt', '$lth_usdt', '$costAvgUsdtBalance', '$avaliableUsdtBalance']],
                         
                          'wallet_avaliableBtc' =>  ['$subtract' => ['$avaliableBtcBalance', '$btcusdtNegitiveTotal']],
                          'wallet_avaliableUsdt'=>  '$avaliableUsdtBalance', 
                         
                          'btcCommitted'        =>  ['$sum' => ['$openTotalBtc', '$lthBTCTotal', '$costAvgBtcBalance', '$btcusdtNegitiveTotal']],
                          'usdtCommitted'       =>  ['$sum' => ['$open_usdt', '$lth_usdt', '$costAvgUsdtBalance']],

                        ]
                      ],
                    ];
                    $investmentLog    =   $db->user_investment_kraken->aggregate($sumData);
                    $investmentLogRes1 =   iterator_to_array($investmentLog);

                    $stats = [
                      'user_id'             =>  (string)$user['user_id'],
                      'btc_account_worth'   =>  $investmentLogRes1[0]['btc_account_worth'],
                      'usdt_account_worth'  =>  $investmentLogRes1[0]['usdt_account_worth'],
                      'btc_user_wallet'     =>  $investmentLogRes1[0]['wallet_avaliableBtc'],
                      'usdt_user_wallet'    =>  $investmentLogRes1[0]['wallet_avaliableUsdt'],
                      'btc_committed'       =>  $investmentLogRes1[0]['btcCommitted'],
                      'usdt_committed'      =>  $investmentLogRes1[0]['usdtCommitted'],
                      'created_date'        =>  $this->mongo_db->converToMongodttime(date('Y-m-d G:i:s')),
                    ];

                    $pipeline = [
                      [
                        '$match' => [

                          'user_id' => (string)$user['user_id'],
                        ]
                      ],

                      [
                        '$sort' => ['created_date' => -1]
                      ],

                      [
                      '$limit' => 1
                      ],

                    ];

                    $lastWeek = $db->weekly_user_wallet_stats->aggregate($pipeline);
                    $lastWeek = iterator_to_array($lastWeek);
                
                    if(!empty($lastWeek)){
                      $lastWeek = $lastWeek[0];
                      
                      $btc_weekly_gain  =  $investmentLogRes1[0]['btc_account_worth']   -  $lastWeek['btc_account_worth'];
                      $usdt_weekly_gain =  $investmentLogRes1[0]['usdt_account_worth']  -  $lastWeek['usdt_account_worth'];
                      
                      $stats['btc_weekly_gain']   =   $btc_weekly_gain;
                      $stats['usdt_weekly_gain']  =   $usdt_weekly_gain;
                    }
                    echo"<pre>";print_r($stats);

                    $insert =[
                      'weeklyBalanceHistory' =>  $this->mongo_db->converToMongodttime(date('Y-m-d G:i:s')),

                    ];

                    $whereUpdate['user_id'] = (string)$user['user_id'];

                    $db->kraken_credentials->updateOne($whereUpdate,  ['$set' => $insert]);
                    $db->weekly_user_wallet_stats_kraken->insertOne($stats);

                    echo "<br>Successfully updated";
                  }//loop
                }

                //testing code
                public function update_weekly_wallet_stats($exchange){
                

                  //   $pipeline = [
                  //   [
                  //     '$match' => [
                  //         'api_key'     => ['$exists' => true, '$nin' => ['', null]],
                  //         'api_secret'  => ['$exists' => true, '$nin' => ['', null]],
                  //       ],
                  //     ],

                  //   [
                  //     '$project' => [

                  //       'my_id' => ['$toString' => $id_field]
                  //     ]
                  //   ],

                  //   [
                  //     '$lookup' => [

                  //       'from' => 'users',
                  //       'let' => [
                  //         'user_id_obj' => ['$toObjectId' => '$my_id'],
                  //       ],


                        
                  //     'pipeline' => [
                  //       [
                  //         '$match' => [
                  //           '$expr' => ['$eq'=> ['$_id', '$$user_id_obj']],

                  //           'application_mode' => ['$in'=>['both', 'live']],

                  //           '$or' => [
                  //             [
                  //               $field_weekly_wallet_stats_updated_date => ['$exists' => false],
                  //             ],
                  //             [
                  //               $field_weekly_wallet_stats_updated_date => ['$gte' => $start_date, '$lte' => $end_date],
                  //             ]
                  //           ]
                  //         ]
                  //       ],




                  //       [
                  //         '$sort' => [ $field_weekly_wallet_stats_updated_date => 1]
                  //       ],

                  //       [
                  //         '$project' => [
                  //           '_id' => 1,
                  //           $field_weekly_wallet_stats_updated_date => 1
                  //         ]
                  //       ],


                  //     ],
                  //     'as' => 'users'
                  //   ]


                  //   ],



                  //   [
                  //     '$match' => [
                  //         '$expr' => [
                  //         '$gt' => [ ['$size' => '$users' ], 0]
                  //       ]
                  //     ]
                  //   ],


                  //   [
                  //     '$project' => [
                  //       'users' => 1,
                  //     ]
                  //   ],


                  //   [
                  //     '$unwind' => '$users'
                  //   ],

                  //   [
                  //     '$sort' => ['users.'.$field_weekly_wallet_stats_updated_date => 1]
                  //   ],

                  //   [
                  //     '$project' => [
                  //       '_id' => 1
                  //     ]
                  //   ],

                  //   [
                  //     '$limit' => 1
                  //   ],

                  //   ];
                  //   $users = $db->$collection_name->aggregate($pipeline);
                  //   $users = iterator_to_array($users);
      
                }

                //crone for button status revert like add commit good now and contact date buttons 
                public function revertbuttonStatus(){
                  $unsertAttay = [

                    "goodNowDate"     =>  "",
                    "good_button"     =>  "",  
                    "contactNowDate"  =>  "",
                    "contact_button"  =>  "",
                    "commentsDate"    =>  "", 
                    "comments_button" =>  "", 
                    "comments"        =>  ""
                  ];

                  $olderDate = $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s', strtotime('-15 days'))); 

                  $lookup = [
                    [
                      '$match' => [

                        'total_balance' => ['$gt' => 20],
                        '$or' => [

                          ['exchange_enabled' =>  'no'],
                          ['tradingStatus'    =>  'off'],
                          ['agt'              =>  'no'],
                          ['remainingPoints'  =>  ['$lte' => 10]]

                        ],

                        '$or' => [
                          
                          [
                            '$and' => [   
                              ['good_button'     =>  ['$exists'=> true]],
                              ['goodNowDate'     =>  ['$lte' => $olderDate]]
                            ]
                          ],
                          [
                            '$and' => [
                              ['comments_button' =>  ['$exists'=> true]],
                              ['goodNowDate'     =>  ['$lte' => $olderDate]]
                            ],
                          ],

                          [
                            '$and' => [
                              ['contact_button'   =>  ['$exists'=> true]],
                              ['commentsDate'     =>  ['$lte' => $olderDate]]
                            ]
                          ]

                        ],
                      ]
                    ],
                    [
                      '$project' => [
                        '_id' => '$admin_id',
                      ]
                    ],
                  ];
                  
                  $db     =   $this->mongo_db->customQuery();
                  $res    =   $db->user_investment_binance->aggregate($lookup);
                  $result =   iterator_to_array($res);

                  for($userLoop = 0; $userLoop <= count($result); $userLoop++ ){

                    echo "<br>binance investment user id :".$result[$userLoop]['_id'];
                    $searchUser['admin_id'] = (string)$result[$userLoop]['_id'];
                    $db->user_investment_binance->updateOne($searchUser, ['$unset' => $unsertAttay]);

                  }


                  $resKraken    =   $db->user_investment_kraken->aggregate($lookup);
                  $resultKraken =   iterator_to_array($resKraken);

                  for($user = 0; $user <= count($resultKraken); $user++ ){

                    echo "<br>kraken investment user id :".$result[$resultKraken]['_id'];
                    $searchUserKraken['admin_id'] = (string)$resultKraken[$user]['_id'];
                    $db->user_investment_binance->updateOne($searchUserKraken, ['$unset' => $unsertAttay]);

                  }

                  echo "<br>done all";
                }
          
              }//end controller