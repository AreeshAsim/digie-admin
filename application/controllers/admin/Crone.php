<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');
/** **/
class Crone extends CI_Controller
{
    function __construct(){
        parent::__construct();
        //load main template
        // 	ini_set("display_errors", E_ALL);
		// error_reporting(E_ALL);
        $this->load->helper('new_common_helper');
    }
    
    //crone for those orders who don't have ip's and status are submiited_for_sell
    public function ipTradingAssignScript(){


        ini_set("display_errors", E_ALL);
		error_reporting(E_ALL);


        $db = $this->mongo_db->customQuery();


        $getOrders = [
            'application_mode'  =>  "live", 
            'status'            =>  "submitted_for_sell",
            "trading_ip"        =>   ['$in' =>  ['null', ' ', 'NULL', null]]
        ];

        $setArray = [

            "trading_ip" => "35.153.9.225",
            "status"     => "FILLED"      
        ];

        $getCount = $db->buy_orders->updateMany($getOrders, ['$set' => $setArray] );
        echo "Binance order updated Count: ".$getCount->getModifiedCount();


        $getCount_kraken = $db->buy_orders_kraken->updateMany($getOrders, ['$set' => $setArray] );
        echo "<br>kraken order updated Count: ".$getCount_kraken->getModifiedCount();

    }

    //fixed orders temp Blocked Orders
    public function temBlockedOrdersStatusFixed(){
        
        $olderDate = $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s', strtotime('-3 hours')));

        $search = [

            'application_mode' => 'live',
            'status'           =>  "TEMPAPILOCK_ERROR", 
            'modified_date'    =>  ['$lte' => $olderDate],
            'remove_error'     =>  ['$exists' => false],
        ];

        // for orders collections
         $db          =  $this->mongo_db->customQuery();
         $orderCountKraken  =  $db->orders_kraken->updateMany($search, ['$set' => ['status' => 'new', 'remove_error' => 'yes' ]]);
         echo "<br>Order collection Modified Count Kraken: ", $orderCountKraken->getModifiedCount();   
 
         $orderCountBinance  =  $db->orders->updateMany($search, ['$set' => ['status' => 'new', 'remove_error' => 'yes' ]]);
         echo "<br>Order collection Modified Count Binance: ", $orderCountBinance->getModifiedCount();


         //for buy orders 
        $buyOrderCount  =  $db->buy_orders_kraken->updateMany($search, ['$set' => ['status' => 'FILLED','remove_error' => 'yes', 'modified_date' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')) ]]);
        echo "<br>Order Modified Count Kraken: ", $buyOrderCount->getModifiedCount();   

        $buyOrderCountBinance  =  $db->buy_orders->updateMany($search, ['$set' => ['status' => 'FILLED', 'remove_error' => 'yes', 'modified_date' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')) ]]);
        echo "<br>Order Modified Count Binance: ", $buyOrderCountBinance->getModifiedCount();
    }//end function

    public function submittedForSellOrdesFixed(){

        $getSubmittedForSellOrdesMatch = [
            'application_mode'       => 'live',
            'status'                 =>  "submitted_for_sell", 
            'binance_order_id_sell'  =>  ['$exists' => true, '$nin' => ['', null, 'null', 'NULL', '0', 0]],
            'market_sold_price'      =>  ['$exists' => true, '$nin' => ['', null, 'null', 'NULL', 0, '0']],
            'cost_avg'               =>  ['$nin' => ['yes', 'taking_child']]          

        ];

        $getSubmittedForSellOrdesMatchKraken = [
            'application_mode'       => 'live',
            'status'                 =>  "submitted_for_sell",
            'sell_kraken_order_id'  =>  ['$exists' => true, '$nin' => ['', null, 'null', 'NULL', '0', 0]],
            'market_sold_price'      =>  ['$exists' => true, '$nin' => ['', null, 'null', 'NULL', 0, '0']],
            'cost_avg'               =>  ['$nin' => ['yes', 'taking_child']]          

        ];



        
        $db = $this->mongo_db->customQuery();
        $orders = $db->buy_orders->updateMany($getSubmittedForSellOrdesMatch, ['$set'=> ['status' => "FILLED", 'is_sell_order' => 'sold', 'trading_status' => 'complete'] ]);

        echo "<br>Binance Order Updated Count: ".$orders->getModifiedCount();
        $orderskraken = $db->buy_orders_kraken->updateMany($getSubmittedForSellOrdesMatchKraken, ['$set'=> ['status' => "FILLED", 'is_sell_order' => 'sold', 'trading_status' => 'complete']]);
        echo "<br>Kraken Order Updated Count: ".$orderskraken->getModifiedCount();


        // check in sold collection
        $soldBuyOrders       =  $db->sold_buy_orders->updateMany($getSubmittedForSellOrdesMatch, ['$set'=> ['status' => "FILLED", 'is_sell_order' => 'sold', 'trading_status' => 'complete'] ]);
        echo "<br>sold Binance Order Updated Count: ".$soldBuyOrders->getModifiedCount();

        $soldBuyordersKraken =  $db->sold_buy_orders_kraken->updateMany($getSubmittedForSellOrdesMatchKraken, ['$set'=> ['status' => "FILLED", 'is_sell_order' => 'sold', 'trading_status' => 'complete'] ]);
        echo "<br>sold Kraken Order Updated Count: ".$soldBuyordersKraken->getModifiedCount();

    }

    public function submittedForSellOrdesBinanceIdExistsFixed(){

        $getSubmittedForSellOrdesMatch = [
            'application_mode'       => 'live',
            'status'                 =>  "submitted_for_sell",
            'binance_order_id_sell'  =>  ['$exists' => true, '$nin' => ['', null, 'null', 'NULL', '0', 0]],
            'cost_avg'               =>  ['$nin' => ['yes', 'taking_child']]          
        ];

        $getSubmittedForSellOrdesMatchKraken = [
            'application_mode'       => 'live',
            'status'                 =>  "submitted_for_sell",
            'sell_kraken_order_id'   =>  ['$exists' => true, '$nin' => ['', null, 'null', 'NULL', '0', 0]],
            'cost_avg'               =>  ['$nin' => ['yes', 'taking_child']]          

        ];

        $db = $this->mongo_db->customQuery();
        $orders = $db->buy_orders->find($getSubmittedForSellOrdesMatch);
        $ordersBinance = iterator_to_array($orders);
        echo "<br> Binance count:".count($ordersBinance);

        for($i = 0; $i < count($ordersBinance); $i++){
            $updateArray = [

                'market_sold_price' =>  $ordersBinance[0]['sell_price'],
                'status'            =>  "FILLED",
                'trading_status'    =>  "complete",
                'is_sell_order'     =>  "sold"
            ];
            $where['_id'] = $this->mongo_db->mongoId((string)$ordersBinance[0]['_id']);
            $orders = $db->buy_orders->updateOne($where, ['$set'=> $updateArray]);
            echo "<br>Buy binance Order Updated Count: ".$orders->getModifiedCount();

            $whereSell['_id'] = $this->mongo_db->mongoId((string)$ordersBinance[0]['sell_order_id']);
            $sellOrders = $db->orders->updateOne($whereSell, ['$set'=> ['status' => 'new']]);
            echo "<br>sell binance Order Updated Count: ".$sellOrders->getModifiedCount();
        }
        

        //for kraken
        $orderskraken = $db->buy_orders_kraken->find($getSubmittedForSellOrdesMatchKraken);
        $orderskrakenRes = iterator_to_array($orderskraken);
        echo"<br> count Kraken: ". count($orderskrakenRes);
        for($i = 0; $i < count($orderskrakenRes); $i++){
            
            $updateArray = [

                'market_sold_price' =>  $orderskrakenRes[0]['sell_price'],
                'status'            =>  "FILLED",
                'trading_status'    =>  "complete",
                'is_sell_order'     =>  "sold"
            ];
            $where['_id'] = $this->mongo_db->mongoId((string)$orderskrakenRes[0]['_id']);
            $orderskrakenResCount = $db->buy_orders_kraken->updateOne($where, ['$set'=> $updateArray]);
            echo "<br>kraken Order Updated Count: ".$orderskrakenResCount->getModifiedCount();

            $whereSellKraken['_id'] = $this->mongo_db->mongoId((string)$orderskrakenRes[0]['sell_order_id']);
            $Sellorders = $db->orders_kraken->updateOne($whereSellKraken, ['$set'=> ['status' => 'new']]);
            echo "<br>sell kraken Order Updated Count: ".$Sellorders->getModifiedCount();

        }

    }

    //fix this "HTMLJSON" status orders 
    public function HTMLJSONOrdersStatusFixed(){
        
        $olderDate = $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s', strtotime('-1 hours')));

        $search = [

            'application_mode' => 'live',
            'status'           =>  "HTMLJSON", 
            'modified_date'    =>  ['$lte' => $olderDate],
            'remove_error'     =>  ['$exists' => false],
        ];

        // for orders collections
         $db          =  $this->mongo_db->customQuery();
         $orderCountKraken  =  $db->orders_kraken->updateMany($search, ['$set' => ['status' => 'new', 'remove_error' => 'yes' ]]);
         echo "<br>Order collection Modified Count Kraken: ", $orderCountKraken->getModifiedCount();   
 
         $orderCountBinance  =  $db->orders->updateMany($search, ['$set' => ['status' => 'new', 'remove_error' => 'yes' ]]);
         echo "<br>Order collection Modified Count Binance: ", $orderCountBinance->getModifiedCount();


         //for buy orders 
        $buyOrderCount  =  $db->buy_orders_kraken->updateMany($search, ['$set' => ['status' => 'FILLED','remove_error' => 'yes', 'modified_date' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')) ]]);
        echo "<br>Order Modified Count Kraken: ", $buyOrderCount->getModifiedCount();   

        $buyOrderCountBinance  =  $db->buy_orders->updateMany($search, ['$set' => ['status' => 'FILLED', 'remove_error' => 'yes', 'modified_date' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')) ]]);
        echo "<br>Order Modified Count Binance: ", $buyOrderCountBinance->getModifiedCount();
    }//end function

    //checking is BNB exists or not ?
    public function checking_BNB_exists(){

        $db = $this->mongo_db->customQuery();
        $olderTime = $this->mongo_db->converToMongodttime(Date('Y-m-d H:i:s',strtotime('-12 hours') ));

        $db = $this->mongo_db->customQuery();
        if( !empty($this->input->get()) ){

            $lookup = [
                [
                    '$match' => [
                        'username'  => $this->input->get('userName'),
                        '$and' => [
                            [
                                'api_key' => ['$exists' => true],
                            ],
                            [
                                'api_key' => ['$nin' => ['', null] ],
                            ],
                            [
                                'api_secret' => ['$exists' => true],
                            ],
                            [
                                'api_secret' => ['$nin' => ['', null] ],
                            ],
                        ],
                    ]
                ],
                [
                    '$project' =>[
                        '_id'       =>  '$_id',
                        'username'  =>  '$username',
                    ]
                ],
                
            ];
        }else{

            $lookup = [
                [
                    '$match' => [
                        'application_mode' => ['$in' => ['both', 'live']],
                    
                        '$or'  => [
                            ['bnb_exists_checking' => ['$exists' => false]],
                            ['bnb_exists_checking' => ['$lte' => $olderTime]]
                        ],

                        '$and' => [
                            [
                                'api_key' => ['$exists' => true],
                            ],
                            [
                                'api_key' => ['$nin' => ['', null] ],
                            ],
                            [
                                'api_secret' => ['$exists' => true],
                            ],
                            [
                                'api_secret' => ['$nin' => ['', null] ],
                            ],
                        ],
                    ]
                ],
                [
                    '$project' =>[
                        '_id'       =>  '$_id',
                        'username'  =>  '$username',
                    ]
                ],


                [
                    '$sort' => ['bnb_exists_checking' => 1]
                ],
                [
                    '$limit' => 20
                ]
            ];
        }
        $get_users     =  $db->users->aggregate($lookup);
        $filter_Users  =  iterator_to_array($get_users);
        
        echo "<br>Get user Count: ".count($filter_Users);
        
        if( count($filter_Users)> 0 ){
            
            for ($i = 0; $i < count($filter_Users); $i++){
                echo "<br> admin_id: ".(string)$filter_Users[$i]['_id'];
                echo "<br> User Name: ".$filter_Users[$i]['username'];

                $findMatch = [

                    'user_id'      =>  (string)$filter_Users[$i]['_id'],
                    'coin_symbol'  => 'BNB',

                ];
                $result = $db->user_wallet->find($findMatch);
                $convertResult = iterator_to_array($result);

                echo 'bnb balance: ',$convertResult[$i]['coin_balance'];
                // BNBBTC   
                $bnb_converted = convertCoinBalanceIntobtctoUSDT('BNBBTC', $convertResult[$i]['coin_balance'], 'binance' );
                if($bnb_converted > 2 ){

                    echo "<br>if condition wokring";
                    $db->users->updateOne(['_id' => $this->mongo_db->mongoId((string)$filter_Users[$i]['_id']) ], ['$set' =>  ['bnb_exists' => 'yes', 'bnb_exists_checking' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))]]);
                }else{

                    echo "<br>else condition wokring";
                    $db->users->updateOne(['_id' => $this->mongo_db->mongoId((string)$filter_Users[$i]['_id']) ], ['$set' =>  ['bnb_exists' => 'no', 'bnb_exists_checking' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))]]);
                }

            }//end loop
        }
        echo "<br>Done All!";
    }//end controller


    //delete 2 month old data foo monthly volume chart report
    public function deleteOldData(){

        exit;
        $db = $this->mongo_db->customQuery();
        $startTime = $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s', strtotime('-2 month')));

        $whereDelete['created_date'] = ['$lte' => $startTime ];

        $db->user_analysis_chart_data->deleteMany($whereDelete);
        $db->daily_investment_chart_data->deleteMany($whereDelete);

        echo "<br> Deleted Successfully!!!";  
    }


    //calculate how many btc and usdt he earn and how many fee he paids
    public function calculateAccumulation_Binance(){

        $lookUp = [
            [
                '$match' => [
                    
                    'application_mode' =>  ['$in' => ['both', 'live']],
                    'username'         =>  'jamesparker'  
                ]
            ],
            [
                '$project' => [
                    '_id'  => 1
                ]
            ],
            [
                
                '$lookup' => [
                    "from" => "sold_buy_orders",
                    "let" => [
                        "user_id" => ['$toString' =>  '$_id']
                    ],
                    'pipeline' => [
                        [
                            '$match'=> [
                                '$expr' => [
                                    '$eq' => [
                                    '$admin_id',
                                    '$$user_id'
                                    ]
                                ],

                                'is_sell_order'  => 'sold',
                                'accumulations'  => ['$exists' => true],
                                'created_date'   => ['$gte' => $this->mongo_db->converToMongodttime(date('Y-m-01 00:00:00')), '$lte' => $this->mongo_db->converToMongodttime(date('Y-m-d 23:59:59'))]
                            ],

                        ],

                        [
                            '$project' => [
                                '_id'            =>   1,
                                'accumulations'  =>   '$accumulations',
                                'admin_id'       =>   '$admin_id',
                                'symbol' => [
                                    '$substr' => [
                                        '$symbol',
                                        ['$subtract' => [['$strLenCP' => '$symbol'],3]], ['$strLenCP' => '$symbol']
                                    ]
                                ]
                            ]
                        ],

                        [
                            '$project' => [
                                '_id'  => 1,
                                'admin_id'  => '$admin_id',
                                    'total_btc_invest'  => [
                                        '$sum' => [
                                            '$cond' => [
                                                'if' => ['$eq' => ['$symbol' , 'BTC']],
                                                'then' => '$accumulations.invest',
                                                'else' => 0
                                            ]
                                        ]
                                    ],

                                'total_usdt_invest'  => [
                                    '$sum' => [
                                        '$cond' => [
                                            'if' => ['$ne' => ['$symbol' , 'BTC']],
                                            'then' => '$accumulations.invest',
                                            'else' => 0
                                        ]
                                    ]
                                ],


                                'total_btc_gain'  => [
                                    '$sum' => [
                                        '$cond' => [
                                            'if' => ['$eq' => ['$symbol' , 'BTC']],
                                            'then' => '$accumulations.return',
                                            'else' => 0
                                        ]
                                    ]
                                ],

                                'total_usdt_gain'  => [
                                    '$sum' => [
                                        '$cond' => [
                                            'if' => ['$ne' => ['$symbol' , 'BTC']],
                                            'then' => '$accumulations.return',
                                            'else' => 0
                                        ]
                                    ]
                                ],

                                'total_bnb_buy_fee'  => [
                                    '$sum' => [
                                        '$cond' => [
                                            'if' => ['$eq' => ['$accumulations.buy_commission_type_bnb' , 'BNB']],
                                            'then' => '$accumulations.buy_commission_bnb',
                                            'else' => 0
                                        ]
                                    ]
                                ],

                                'total_coin_buy_fee'  => [
                                    '$sum' => [
                                        '$cond' => [
                                            'if' => ['$ne' => ['$accumulations.buy_commission_type_coin' , 'BNB']],
                                            'then' => '$accumulations.buy_commission_coin',
                                            'else' => 0
                                        ]
                                    ]
                                ],

                                'total_bnb_sell__fee'  => [
                                    '$sum' => [
                                        '$cond' => [
                                            'if' => ['$eq' => ['$accumulations.sell_commission_type_bnb' , 'BNB']],
                                            'then' => '$accumulations.sell_commission_bnb',
                                            'else' => 0
                                        ]
                                    ]
                                ],

                                'total_coin_sell_fee'  => [
                                    '$sum' => [
                                        '$cond' => [
                                            'if' => ['$ne' => ['$accumulations.sell_commission_type_coin' , 'BNB']],
                                            'then' => '$accumulations.sell_commission_coin',
                                            'else' => 0
                                        ]
                                    ]
                                ],
                            ]
                        ],

                        [
                            '$group' => [

                                '_id'  => '$admin_id',
                                'total_btc_invest'      =>  ['$sum' => '$total_btc_invest'],
                                'total_usdt_invest'     =>  ['$sum' => '$total_usdt_invest'],
                                'total_btc_gain'        =>  ['$sum' => '$total_btc_gain'],
                                'total_usdt_gain'       =>  ['$sum' => '$total_usdt_gain'],
                                'total_bnb_buy_fee'     =>  ['$sum' => '$total_bnb_buy_fee'],
                                'total_coin_buy_fee'    =>  ['$sum' => '$total_coin_buy_fee'],
                                'total_bnb_sell__fee'   =>  ['$sum' => '$total_bnb_sell__fee'],
                                'total_coin_sell_fee'   =>  ['$sum' => '$total_coin_sell_fee']
                            ]
                        ]
                    ],
                    "as" => "new_data"
                ]
            ],

            ['$limit' => 10]
        ];
        $db  = $this->mongo_db->customQuery();
        $data = $db->users->aggregate($lookUp);
        $responseData  = iterator_to_array($data);
        echo "<br>count: ".count($responseData);
        for($i = 0; $i < count($responseData); $i++){

            $insertArray = [
                'user_id'               =>  (string)$responseData[$i]['new_data'][0]['_id'],
                'total_btc_invest'      =>  (float)$responseData[$i]['new_data'][0]['total_btc_invest'],
                'total_usdt_invest'     =>  (float)$responseData[$i]['new_data'][0]['total_usdt_invest'],
                'total_btc_gain'        =>  (float)$responseData[$i]['new_data'][0]['total_btc_gain'],
                'total_usdt_gain'       =>  (float)$responseData[$i]['new_data'][0]['total_usdt_gain'],
                'total_bnb_buy_fee'     =>  (float)$responseData[$i]['new_data'][0]['total_bnb_buy_fee'],
                'total_coin_buy_fee'    =>  (float)$responseData[$i]['new_data'][0]['total_coin_buy_fee'],
                'total_bnb_sell__fee'   =>  (float)$responseData[$i]['new_data'][0]['total_bnb_sell__fee'],
                'total_coin_sell_fee'   =>  (float)$responseData[$i]['new_data'][0]['total_coin_sell_fee'],
                'created_date'          =>  $this->mongo_db->converToMongodttime(date('Y-m-d')),
                'exchange'              =>  'binance'
            ];
            echo "<pre>";print_r($insertArray);

            $matchWhere = [
                'user_id'       =>  (string)$responseData[$i]['new_data'][0]['_id'],
                'created_date'  =>  $this->mongo_db->converToMongodttime(date('Y-m-d')),
                'exchange'      =>  'binance'
    
            ];
            // $db->monthly_accumolution->updateOne($matchWhere, ['$set' => $insertArray ], ['upsert' => true] );
        }//end loop

        
        
    }


    //calculate how many btc and usdt he earn and how many fee he paids
    public function calculateAccumulation_Kraken(){

        $lookUp = [
            
            [
                '$project' => [
                    '_id'  => '$user_id'
                ]
            ],
            [
                
                '$lookup' => [
                    "from" => "sold_buy_orders_kraken",
                    "let" => [
                        "user_id" => ['$toString' =>  '$_id']
                    ],
                    'pipeline' => [
                        [
                            '$match'=> [
                                '$expr' => [
                                    '$eq' => [
                                    '$admin_id',
                                    '$$user_id'
                                    ]
                                ],

                                'is_sell_order'  => 'sold',
                                'accumulations'  => ['$exists' => true],
                                'created_date'   => ['$gte' => $this->mongo_db->converToMongodttime(date('Y-m-01 00:00:00')), '$lte' => $this->mongo_db->converToMongodttime(date('Y-m-d 23:59:59'))]
                            ],

                        ],

                        [
                            '$project' => [
                                '_id'            =>   1,
                                'accumulations'  =>   '$accumulations',
                                'admin_id'       =>   '$admin_id',
                                'symbol' => [
                                    '$substr' => [
                                        '$symbol',
                                        ['$subtract' => [['$strLenCP' => '$symbol'],3]], ['$strLenCP' => '$symbol']
                                    ]
                                ]
                            ]
                        ],

                        [
                            '$project' => [
                                '_id'  => 1,
                                'admin_id'  => '$admin_id',
                                    'total_btc_invest'  => [
                                        '$sum' => [
                                            '$cond' => [
                                                'if' => ['$eq' => ['$symbol' , 'BTC']],
                                                'then' => '$accumulations.invest',
                                                'else' => 0
                                            ]
                                        ]
                                    ],

                                'total_usdt_invest'  => [
                                    '$sum' => [
                                        '$cond' => [
                                            'if' => ['$ne' => ['$symbol' , 'BTC']],
                                            'then' => '$accumulations.invest',
                                            'else' => 0
                                        ]
                                    ]
                                ],


                                'total_btc_gain'  => [
                                    '$sum' => [
                                        '$cond' => [
                                            'if' => ['$eq' => ['$symbol' , 'BTC']],
                                            'then' => '$accumulations.return',
                                            'else' => 0
                                        ]
                                    ]
                                ],

                                'total_usdt_gain'  => [
                                    '$sum' => [
                                        '$cond' => [
                                            'if' => ['$ne' => ['$symbol' , 'BTC']],
                                            'then' => '$accumulations.return',
                                            'else' => 0
                                        ]
                                    ]
                                ],

                                'total_bnb_buy_fee'  => [
                                    '$sum' => [
                                        '$cond' => [
                                            'if' => ['$eq' => ['$accumulations.buy_commission_type_bnb' , 'BNB']],
                                            'then' => '$accumulations.buy_commission_bnb',
                                            'else' => 0
                                        ]
                                    ]
                                ],

                                'total_coin_buy_fee'  => [
                                    '$sum' => [
                                        '$cond' => [
                                            'if' => ['$ne' => ['$accumulations.buy_commission_type_coin' , 'BNB']],
                                            'then' => '$accumulations.buy_commission_coin',
                                            'else' => 0
                                        ]
                                    ]
                                ],

                                'total_bnb_sell__fee'  => [
                                    '$sum' => [
                                        '$cond' => [
                                            'if' => ['$eq' => ['$accumulations.sell_commission_type_bnb' , 'BNB']],
                                            'then' => '$accumulations.sell_commission_bnb',
                                            'else' => 0
                                        ]
                                    ]
                                ],

                                'total_coin_sell_fee'  => [
                                    '$sum' => [
                                        '$cond' => [
                                            'if' => ['$ne' => ['$accumulations.sell_commission_type_coin' , 'BNB']],
                                            'then' => '$accumulations.sell_commission_coin',
                                            'else' => 0
                                        ]
                                    ]
                                ],
                            ]
                        ],

                        [
                            '$group' => [

                                '_id'                   =>  '$admin_id',
                                'total_btc_invest'      =>  ['$sum' => '$total_btc_invest'],
                                'total_usdt_invest'     =>  ['$sum' => '$total_usdt_invest'],
                                'total_btc_gain'        =>  ['$sum' => '$total_btc_gain'],
                                'total_usdt_gain'       =>  ['$sum' => '$total_usdt_gain'],
                                'total_bnb_buy_fee'     =>  ['$sum' => '$total_bnb_buy_fee'],
                                'total_coin_buy_fee'    =>  ['$sum' => '$total_coin_buy_fee'],
                                'total_bnb_sell__fee'   =>  ['$sum' => '$total_bnb_sell__fee'],
                                'total_coin_sell_fee'   =>  ['$sum' => '$total_coin_sell_fee']
                            ]
                        ]
                    ],
                    "as" => "new_data"
                ]
            ],
            ['$limit' => 10]
        ];
        $db  = $this->mongo_db->customQuery();
        $data = $db->kraken_credentials->aggregate($lookUp);
        $responseData  = iterator_to_array($data);
        
        for($i = 0; $i < count($responseData); $i++){

            $insertArray = [
                'user_id'               =>  (string)$responseData[$i]['new_data'][0]['_id'],
                'total_btc_invest'      =>  (float)$responseData[$i]['new_data'][0]['total_btc_invest'],
                'total_usdt_invest'     =>  (float)$responseData[$i]['new_data'][0]['total_usdt_invest'],
                'total_btc_gain'        =>  (float)$responseData[$i]['new_data'][0]['total_btc_gain'],
                'total_usdt_gain'       =>  (float)$responseData[$i]['new_data'][0]['total_usdt_gain'],
                'total_bnb_buy_fee'     =>  (float)$responseData[$i]['new_data'][0]['total_bnb_buy_fee'],
                'total_coin_buy_fee'    =>  (float)$responseData[$i]['new_data'][0]['total_coin_buy_fee'],
                'total_bnb_sell__fee'   =>  (float)$responseData[$i]['new_data'][0]['total_bnb_sell__fee'],
                'total_coin_sell_fee'   =>  (float)$responseData[$i]['new_data'][0]['total_coin_sell_fee'],
                'created_date'          =>  $this->mongo_db->converToMongodttime(date('Y-m-d')),
                'exchange'              =>  'kraken'
            ];

            $matchWhere = [
                'user_id'       =>  (string)$responseData[$i]['new_data'][0]['_id'],
                'created_date'  =>  $this->mongo_db->converToMongodttime(date('Y-m-d')),
                'exchange'      =>  'kraken'
            ];
            // $db->monthly_accumolution->updateOne($matchWhere, ['$set' => $insertArray ], ['upsert' => true] );
            echo "<pre>";print_r($insertArray);
        }//end loop
    }// end function
}



