<?php
defined('BASEPATH') or exit('No direct script access allowed');
        class Barrier_trigger extends CI_Controller{
            public function __construct()
            {
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
                
            }
            // public function order_test(){
            //     $request = $this->input->get();
            //     if(!empty($request)){
            //         $exchange = (!empty($request['exchange']) ? $request['exchange'] : '');
            //         $exchange = ($exchange == '' || $exchange == 'binance' ? '' : "_$exchange");
            //         $id = (!empty($request['id']) ? $request['id'] : '');

            //         echo "<pre>";
            //         if(!empty($id)){
            //             echo "\r\n Time converted to TimeZone: Asia/Karachi \r\n";
            //             $timezone = "Asia/Karachi";
            //             $new_timezone = new DateTimeZone($timezone);

            //             echo "<br> *** Buy Order *** <br> \r\n";
            //             $collection = "buy_orders$exchange";
            //             $this->mongo_db->where(array('_id' => $id));
            //             $responseArr = $this->mongo_db->get($collection);
            //             $data = iterator_to_array($responseArr);
            //             $row = $data[0];
                    
            //             if(!empty($row)){

            //                 $created_date = '';
            //                 $modified_date = '';
            //                 $buy_date = '';

            //                 if(!empty($row['created_date'])){
            //                     $created_date = $row['created_date']->toDateTime();
            //                     $created_date = $created_date->format(DATE_RSS);
            //                     $created_date = new DateTime($created_date);
            //                     $created_date->setTimezone($new_timezone);
            //                     $created_date = $created_date->format('Y-m-d g:i:s A');
            //                 }
                        
            //                 if(!empty($row['buy_date'])){
            //                     $buy_date = $row['buy_date']->toDateTime();
            //                     $buy_date = $buy_date->format(DATE_RSS);
            //                     $buy_date = new DateTime($buy_date);
            //                     $buy_date->setTimezone($new_timezone);
            //                     $buy_date = $buy_date->format('Y-m-d g:i:s A');
            //                 }

            //                 if(empty($row['modified_date'])){
            //                     $modified_date = $row['modified_date']->toDateTime();
            //                     $modified_date = $modified_date->format(DATE_RSS);
            //                     $modified_date = new DateTime($modified_date);
            //                     $modified_date->setTimezone($new_timezone);
            //                     $modified_date = $modified_date->format('Y-m-d g:i:s A');
            //                 }

            //                 $row['market_value'] = !empty($row['market_value']) ? num($row['market_value']) : 0;
            //                 $row['price'] = !empty($row['price']) ? num($row['price']) : 0;
            //                 $row['buy_trail_price'] = !empty($row['buy_trail_price']) ? num($row['buy_trail_price']) : 0;
            //                 $row['sell_price'] = !empty($row['sell_price']) ? num($row['sell_price']) : 0;
            //                 $row['purchased_price'] = !empty($row['purchased_price']) ? num($row['purchased_price']) : 0;
            //                 $row['market_heighest_value'] = !empty($row['market_heighest_value']) ? num($row['market_heighest_value']) : 0;
            //                 $row['market_lowest_value'] = !empty($row['market_lowest_value']) ? num($row['market_lowest_value']) : 0;
                        
            //                 if(!empty($row['iniatial_trail_stop'])){
            //                     $row['iniatial_trail_stop'] = !empty($row['iniatial_trail_stop']) ? num($row['iniatial_trail_stop']) : 0;
            //                 }

            //                 $row['created_date'] = !empty($created_date) ? $created_date : '';
            //                 $row['modified_date'] = !empty($modified_date) ? $modified_date : '';
            //                 $row['buy_date'] = !empty($buy_date) ? $buy_date : '';

            //                 print_r($row);
            //                 echo"<br>buy array count = ".count($data);

            //                 echo "<br> *** Sell Order ***  <br> \r\n";

            //                 if (!empty($row['sell_order_id'])) {

            //                     $sell_order_id = (String) $row['sell_order_id'];
            //                     $collection2 = "orders$exchange";
            //                     $this->mongo_db->where(array('_id' => $sell_order_id));
            //                     $respArr = $this->mongo_db->get($collection2);
            //                     $data = iterator_to_array($respArr);
            //                     $row2 = $data[0];
                            
            //                     if(!empty($row2)){

            //                         $created_date = '';
            //                         $modified_date = '';
            //                         $buy_date = '';

            //                         if(!empty($row2['created_date'])){
            //                             $created_date = $row2['created_date']->toDateTime();
            //                             $created_date = $created_date->format(DATE_RSS);
            //                             $created_date = new DateTime($created_date);
            //                             $created_date->setTimezone($new_timezone);
            //                             $created_date = $created_date->format('Y-m-d g:i:s A');
            //                         }

            //                         if(!empty($row2['buy_date'])){
            //                             $buy_date = $row2['buy_date']->toDateTime();
            //                             $buy_date = $buy_date->format(DATE_RSS);
            //                             $buy_date = new DateTime($buy_date);
            //                             $buy_date->setTimezone($new_timezone);
            //                             $buy_date = $buy_date->format('Y-m-d g:i:s A');
            //                         }

            //                         if(!empty($row2['modified_date'])){
            //                             $modified_date = $row2['modified_date']->toDateTime();
            //                             $modified_date = $modified_date->format(DATE_RSS);
            //                             $modified_date = new DateTime($modified_date);
            //                             $modified_date->setTimezone($new_timezone);
            //                             $modified_date = $modified_date->format('Y-m-d g:i:s A');
            //                         }
            //                     $row2['sell_price'] = !empty($row2['sell_price']) ? num($row2['sell_price']) : 0;
            //                     $row2['purchased_price'] = !empty($row2['purchased_price']) ? num($row2['purchased_price']) : 0;
            //                     $row2['iniatial_trail_stop'] = !empty($row2['iniatial_trail_stop']) ? num($row2['iniatial_trail_stop']) : '';
            //                     $row2['created_date'] = !empty($created_date) ? $created_date : '';
            //                     $row2['modified_date'] = !empty($modified_date) ? $modified_date : '';
            //                     print_r($row2);
            //                     echo"<br> sell array count =".count($data);
            //                 }

            //                 }else{
            //                     echo "<br> Sell Order Not found <br> \r\n";
            //                 }
            //             }else{
                        
            //                 echo "\r\n *** Buy Order not found  ***  \r\n";
            //                 echo "\r\n  \r\n";
            //                 echo "\r\n *** Try to find in sold orders ***  \r\n \r\n";

            //                 $collection = "sold_buy_orders$exchange";
            //                 $this->mongo_db->where(array('_id' => $id));
            //                 $responseArr = $this->mongo_db->get($collection);
            //                 $data = iterator_to_array($responseArr);
            //                 $row3 = $data[0];
                            
            //                 if(!empty($row3)){

            //                     $created_date = '';
            //                     $modified_date = '';
            //                     $buy_date = '';

            //                     if(!empty($row3['created_date'])){
            //                         $created_date = $row3['created_date']->toDateTime();
            //                         $created_date = $created_date->format(DATE_RSS);
            //                         $created_date = new DateTime($created_date);
            //                         $created_date->setTimezone($new_timezone);
            //                         $created_date = $created_date->format('Y-m-d g:i:s A');
            //                     }

            //                     if(!empty($row3['buy_date'])){
            //                         $buy_date = $row3['buy_date']->toDateTime();
            //                         $buy_date = $buy_date->format(DATE_RSS);
            //                         $buy_date = new DateTime($buy_date);
            //                         $buy_date->setTimezone($new_timezone);
            //                         $buy_date = $buy_date->format('Y-m-d g:i:s A');
            //                     }

            //                     if(!empty($row3['modified_date'])){
            //                         $modified_date = $row3['modified_date']->toDateTime();
            //                         $modified_date = $modified_date->format(DATE_RSS);
            //                         $modified_date = new DateTime($modified_date);
            //                         $modified_date->setTimezone($new_timezone);
            //                         $modified_date = $modified_date->format('Y-m-d g:i:s A');
            //                     }

            //                     $row3['market_value'] = !empty($row3['market_value']) ? num($row3['market_value']) : 0;
            //                     $row3['price'] = !empty($row3['price']) ? num($row3['price']) : 0;
            //                     $row3['buy_trail_price'] = !empty($row3['buy_trail_price']) ? num($row3['buy_trail_price']) : 0;
            //                     $row3['sell_price'] = !empty($row3['sell_price']) ? num($row3['sell_price']) : 0;
            //                     $row3['purchased_price'] = !empty($row3['purchased_price']) ? num($row3['purchased_price']) : 0;
            //                     $row3['market_heighest_value'] = !empty($row3['market_heighest_value']) ? num($row3['market_heighest_value']) : 0;
            //                     $row3['market_lowest_value'] = !empty($row3['market_lowest_value']) ? num($row3['market_lowest_value']) : 0;

            //                     print_r($row3);
            //                 }else{
            //                     echo "\r\n Order not found in sold buy orders \r\n";
            //                 }
            //             }
            //         }else{
            //             echo "\r\n Use get request to print order data like this:  http: //app.digiebot.com/admin/barrier_trigger/order_test?exchange=bam&id=5ddbcd781425211d6253d8e2 \r\n";
            //             echo "\r\n <b>Note</b> if exchange not passed default exchange binance will be used \r\n";
            //         }
            //     }else{
            //         echo "\r\n <b>Use get request to print order data like this: <\b>  http: //app.digiebot.com/admin/barrier_trigger/order_test?exchange=bam&id=5ddbcd781425211d6253d8e2 \r\n";
            //         echo "\r\n <b>Note</b> if exchange not passed default exchange binance will be used \r\n";
            //     }

            //     echo "<br> *** Duplicate Sell Array ***  <br> \r\n";

            //     if (!empty($row['sell_order_id'])){
            //         $collection3 = "orders$exchange";
            //         $this->mongo_db->where(["_id" => new MongoDB\BSON\ObjectID($row['sell_order_id'])]); 
            //         $respArr_1 = $this->mongo_db->get($collection3);
            //         $data = iterator_to_array($respArr_1);
            //         $row3 = $data[3];
            //         if(!empty($row3)){
            //             $created_date = '';
            //             $modified_date = '';
            //             $buy_date = '';

            //             if(!empty($row3['created_date'])){
            //                 $created_date = $row3['created_date']->toDateTime();
            //                 $created_date = $created_date->format(DATE_RSS);
            //                 $created_date = new DateTime($created_date);
            //                 $created_date->setTimezone($new_timezone);
            //                 $created_date = $created_date->format('Y-m-d g:i:s A');
            //             }

            //             if(!empty($row3['buy_date'])){
            //                 $buy_date = $row3['buy_date']->toDateTime();
            //                 $buy_date = $buy_date->format(DATE_RSS);
            //                 $buy_date = new DateTime($buy_date);
            //                 $buy_date->setTimezone($new_timezone);
            //                 $buy_date = $buy_date->format('Y-m-d g:i:s A');
            //             }

            //             if(!empty($row3['modified_date'])){
            //                 $modified_date = $row3['modified_date']->toDateTime();
            //                 $modified_date = $modified_date->format(DATE_RSS);
            //                 $modified_date = new DateTime($modified_date);
            //                 $modified_date->setTimezone($new_timezone);
            //                 $modified_date = $modified_date->format('Y-m-d g:i:s A');
            //             }

            //             $row3['sell_price'] = !empty($row3['sell_price']) ? num($row3['sell_price']) : 0;
            //             $row3['purchased_price'] = !empty($row3['purchased_price']) ? num($row3['purchased_price']) : 0;
            //             $row3['iniatial_trail_stop'] = !empty($row3['iniatial_trail_stop']) ? num($row3['iniatial_trail_stop']) : '';
            //             $row3['created_date'] = !empty($created_date) ? $created_date : '';
            //             $row3['modified_date'] = !empty($modified_date) ? $modified_date : '';

            //             print_r($row3);
            //         }
            //         else {
            //             echo "<br> Duplicate Sell Array Not Found <br> \r\n";
            //         }
            //     } 

            //     die('*************** End Script *****************');
            // }
        }//end controller