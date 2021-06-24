<?php
class Mod_calculation extends CI_Model{

    function __construct() {
        parent::__construct();

        
    }

    public function openOrders($admin_id, $exchange){

        $buyCollectionNameBinance = ($exchange == 'binance') ? 'buy_orders' : 'buy_orders_'.$exchange;
        $db = $this->mongo_db->customQuery();

        $btc_coin_in_arrBinance = ['XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC'];
        $coinArrayUSDTBinance   = ['EOSUSDT', 'LTCUSDT','XRPUSDT','NEOUSDT', 'QTUMUSDT'];
        $coinArrayBTCUSDT       = ['BTCUSDT'];

        $lookup = [
            [
              '$match' => [
                'admin_id'                =>    (string)$admin_id,
                'application_mode'        =>    'live',
                'status'                  =>    ['$in' => ['FILLED', 'FILLED_ERROR','SELL_ID_ERROR']],
                'resume_status'           =>    ['$ne' =>  'completed'],
                'parent_status'           =>    ['$ne' =>  'parent'],
                'is_sell_order'           =>    'yes',
                'is_lth_order'            =>    ['$ne'=> 'yes'],
                'cavg_parent'             =>    ['$exists' => false],
                'count_avg_order'         =>    ['$exists' => false],
                'cost_avg'                =>    ['$nin' => ['yes', 'taking_child', 'completed']],
                'move_to_cost_avg'        =>    ['$ne'  =>    'yes'],
              ]
            ],


            [
              '$group' => [
              
                '_id' =>  '$_id',      
                
                'btc' => [
                  '$push' => [
                    '$cond' => [ 
                      'if' => [ '$in' => [ '$symbol', $btc_coin_in_arrBinance ] ], 
                      'then' => ['$each' , ['$symbol', '$purchased_price', '$quantity']], 
                      'else' => null
                    ]
                  ]
                ],

                'usdt' => [
                  '$push' => [
                    '$cond' => [ 
                      'if' => [ '$in' => ['$symbol' ,  $coinArrayUSDTBinance] ], 
                      'then' => ['$each' , ['$symbol', '$purchased_price', '$quantity']],    
                      'else' => null
                    ]
                  ]
                ],


                'btcusdt' => [
                  '$push' => [
                    '$cond' => [ 
                      'if' => [ '$in' => [ '$symbol', $coinArrayBTCUSDT ] ], 
                      'then' => ['$each' , ['$symbol', '$purchased_price', '$quantity']], 
                      'else' => null
                    ]
                  ]
                ],

              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$arrayElemAt' => ['$btc', 0]],
              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$arrayElemAt' => ['$purchased_pricebtc', 1]],
              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$arrayElemAt' => ['$purchased_pricebtc', 1]],
                'btc_quantity'          => ['$arrayElemAt' => ['$purchased_pricebtc', 2]]
              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$toDouble' => '$purchased_pricebtc'],
                'btc_quantity'          => ['$toDouble' => '$btc_quantity'],

              ]
            ],


            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$arrayElemAt' => ['$usdt', 0]],
              ]
            ],


            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$arrayElemAt' => ['$purchased_priceusdt', 1]],
              ]
            ],


            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$arrayElemAt' => ['$purchased_priceusdt', 1]],
                'usdt_quantity'          => ['$arrayElemAt' => ['$purchased_priceusdt', 2]]
              ]
            ],

            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$toDouble' => '$purchased_priceusdt'],
                'usdt_quantity'          => ['$toDouble' => '$usdt_quantity'],

              ]
            ],




            [
              '$addFields' => [
                'purchased_priceBtcusdt'    => ['$arrayElemAt' => ['$btcusdt', 0]],
              ]
            ],


            [
              '$addFields' => [
                'purchased_priceBtcusdt'    => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 1]],
              ]
            ],

            [
              '$addFields' => [

                'purchased_priceBtcusdt'    => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 1]],
                'btcusdt_quantity'          => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 2]]
              ]
            ],

            [
              '$addFields' => [
                'purchased_priceBtcusdt'    => ['$toDouble' => '$purchased_priceBtcusdt'],
                'btcusdt_quantity'          => ['$toDouble' => '$btcusdt_quantity'],

              ]
            ],

            [
              '$group' => [

                '_id' => null,
                'btcopenTotal'         =>  ['$sum' =>  ['$multiply' => ['$purchased_pricebtc',  '$btc_quantity']] ],
                'usdtopenTotal'        =>  ['$sum' =>  ['$multiply' => ['$purchased_priceusdt',  '$usdt_quantity']] ],
                'btcusdt'              =>  ['$sum' =>  ['$multiply' => ['$purchased_priceBtcusdt',  '$btcusdt_quantity']] ],
                'btcusdtCommited'      =>  ['$sum' => '$btcusdt_quantity'],
                'openCount'            =>   ['$sum' => 1] 
              ]
            ],
          ];

          
        $retun_orders_open            =  $db->$buyCollectionNameBinance->aggregate($lookup);
        $order_return_response_open   =  iterator_to_array($retun_orders_open);  
        return $order_return_response_open;

    }
    public function lthOrders($admin_id, $exchange){
        

        $btc_coin_in_arrBinance = ['XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC'];
        $coinArrayUSDTBinance   = ['EOSUSDT', 'LTCUSDT','XRPUSDT','NEOUSDT', 'QTUMUSDT'];
        $coinArrayBTCUSDT       = ['BTCUSDT'];

        $db = $this->mongo_db->customQuery();

        $buyCollectionNameBinance = ($exchange == 'binance') ? 'buy_orders' : 'buy_orders_'.$exchange;

        $lookupLth = [
            [
              '$match' => [
                'admin_id'                =>    (string)$admin_id,
                'application_mode'        =>    'live',
                'status'                  =>    ['$in' => ['LTH', 'LTH_ERROR']],
                'resume_status'           =>    ['$exists' => false],
                'parent_status'           =>    ['$exists' =>  false],
                'is_sell_order'           =>    'yes',
                'lth_functionality'       =>    'yes',
                'trigger_type'            =>    'barrier_percentile_trigger',
                'is_lth_order'            =>     'yes',
                'cavg_parent'             =>    ['$exists' => false],
                'count_avg_order'         =>    ['$exists' => false],
                'cost_avg'                =>    ['$nin' => ['yes', 'taking_child', 'completed']],
                'cavg_parent'             =>    ['$exists'  =>   false],
              ]
            ],


            [
              '$group' => [
              
                '_id' =>  '$_id',      
                
                'btc' => [
                  '$push' => [
                    '$cond' => [ 
                      'if' => [ '$in' => [ '$symbol', $btc_coin_in_arrBinance ] ], 
                      'then' => ['$each' , ['$symbol', '$purchased_price', '$quantity']], 
                      'else' => null
                    ]
                  ]
                ],

                'usdt' => [
                  '$push' => [
                    '$cond' => [ 
                      'if' => [ '$in' => ['$symbol' ,  $coinArrayUSDTBinance] ], 
                      'then' => ['$each' , ['$symbol', '$purchased_price', '$quantity']],    
                      'else' => null
                    ]
                  ]
                ],


                'btcusdt' => [
                  '$push' => [
                    '$cond' => [ 
                      'if' => [ '$in' => [ '$symbol', $coinArrayBTCUSDT ] ], 
                      'then' => ['$each' , ['$symbol', '$purchased_price', '$quantity']], 
                      'else' => null
                    ]
                  ]
                ],

              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$arrayElemAt' => ['$btc', 0]],
              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$arrayElemAt' => ['$purchased_pricebtc', 1]],
              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$arrayElemAt' => ['$purchased_pricebtc', 1]],
                'btc_quantity'          => ['$arrayElemAt' => ['$purchased_pricebtc', 2]]
              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$toDouble' => '$purchased_pricebtc'],
                'btc_quantity'          => ['$toDouble' => '$btc_quantity'],

              ]
            ],



            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$arrayElemAt' => ['$usdt', 0]],
              ]
            ],


            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$arrayElemAt' => ['$purchased_priceusdt', 1]],
              ]
            ],


            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$arrayElemAt' => ['$purchased_priceusdt', 1]],
                'usdt_quantity'          => ['$arrayElemAt' => ['$purchased_priceusdt', 2]]
              ]
            ],

            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$toDouble' => '$purchased_priceusdt'],
                'usdt_quantity'          => ['$toDouble' => '$usdt_quantity'],

              ]
            ],

            [
              '$addFields' => [
                'purchased_priceBtcusdt'    => ['$arrayElemAt' => ['$btcusdt', 0]],
              ]
            ],


            [
              '$addFields' => [
                'purchased_priceBtcusdt'    => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 1]],
              ]
            ],

            [
              '$addFields' => [

                'purchased_priceBtcusdt'    => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 1]],
                'btcusdt_quantity'          => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 2]]
              ]
            ],

            [
              '$addFields' => [
                'purchased_priceBtcusdt'    => ['$toDouble' => '$purchased_priceBtcusdt'],
                'btcusdt_quantity'          => ['$toDouble' => '$btcusdt_quantity'],

              ]
            ],

            [
              '$group' => [

                '_id' => null,
                'btcLthTotal'             =>  ['$sum' =>  ['$multiply' => ['$purchased_pricebtc',  '$btc_quantity']] ],
                'usdtLthTotal'            =>  ['$sum' =>  ['$multiply' => ['$purchased_priceusdt',  '$usdt_quantity']] ],
                'btcusdtLth'              =>  ['$sum' =>  ['$multiply' => ['$purchased_priceBtcusdt',  '$btcusdt_quantity']] ],
                'btcusdtCommitedLth'      =>  ['$sum' => '$btcusdt_quantity'],
                'lthCount'                =>  ['$sum' => 1]
              ]
            ],
        ];

        $retun_orders_lth           =  $db->$buyCollectionNameBinance->aggregate($lookupLth);
        $order_return_response_lth  =  iterator_to_array($retun_orders_lth);
        return $order_return_response_lth;
    }

    public function caorders($admin_id, $exchange){
        $btc_coin_in_arrBinance = ['XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC'];
        $coinArrayUSDTBinance   = ['EOSUSDT', 'LTCUSDT','XRPUSDT','NEOUSDT', 'QTUMUSDT'];
        $coinArrayBTCUSDT       = ['BTCUSDT'];

        $db = $this->mongo_db->customQuery();

        $buyCollectionNameBinance = ($exchange == 'binance') ? 'buy_orders' : 'buy_orders_'.$exchange;

        $lookupCA = [
            [
              '$match' => [
                'admin_id'                =>    (string)$admin_id,
                'application_mode'        =>    'live',
                'status'                  =>    'FILLED',
                'resume_status'           =>    ['$exists' => false],
                'is_sell_order'           =>    'yes',
                'trigger_type'            =>    'barrier_percentile_trigger',
                'is_lth_order'            =>     ['$ne' => 'yes'],
                'cost_avg'                =>    ['$in' => ['yes', 'taking_child']],
              ]
            ],
           
            [
              '$group' => [
              
                '_id' =>  '$_id',      
                
                'btc' => [
                  '$push' => [
                    '$cond' => [ 
                      'if' => [ '$in' => [ '$symbol', $btc_coin_in_arrBinance ] ], 
                      'then' => ['$each' , ['$symbol', '$purchased_price', '$quantity']], 
                      'else' => null
                    ]
                  ]
                ],

                'usdt' => [
                  '$push' => [
                    '$cond' => [ 
                      'if' => [ '$in' => ['$symbol' ,  $coinArrayUSDTBinance] ], 
                      'then' => ['$each' , ['$symbol', '$purchased_price', '$quantity']],    
                      'else' => null
                    ]
                  ]
                ],


                'btcusdt' => [
                  '$push' => [
                    '$cond' => [ 
                      'if' => [ '$in' => [ '$symbol', $coinArrayBTCUSDT ] ], 
                      'then' => ['$each' , ['$symbol', '$purchased_price', '$quantity']], 
                      'else' => null
                    ]
                  ]
                ],

              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$arrayElemAt' => ['$btc', 0]],
              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$arrayElemAt' => ['$purchased_pricebtc', 1]],
              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$arrayElemAt' => ['$purchased_pricebtc', 1]],
                'btc_quantity'          => ['$arrayElemAt' => ['$purchased_pricebtc', 2]]
              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$toDouble' => '$purchased_pricebtc'],
                'btc_quantity'          => ['$toDouble' => '$btc_quantity'],

              ]
            ],



            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$arrayElemAt' => ['$usdt', 0]],
              ]
            ],


            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$arrayElemAt' => ['$purchased_priceusdt', 1]],
              ]
            ],


            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$arrayElemAt' => ['$purchased_priceusdt', 1]],
                'usdt_quantity'          => ['$arrayElemAt' => ['$purchased_priceusdt', 2]]
              ]
            ],

            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$toDouble' => '$purchased_priceusdt'],
                'usdt_quantity'          => ['$toDouble' => '$usdt_quantity'],

              ]
            ],

            [
              '$addFields' => [
                'purchased_priceBtcusdt'    => ['$arrayElemAt' => ['$btcusdt', 0]],
              ]
            ],


            [
              '$addFields' => [
                'purchased_priceBtcusdt'    => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 1]],
              ]
            ],

            [
              '$addFields' => [

                'purchased_priceBtcusdt'    => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 1]],
                'btcusdt_quantity'          => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 2]]
              ]
            ],

            [
              '$addFields' => [
                'purchased_priceBtcusdt'    => ['$toDouble' => '$purchased_priceBtcusdt'],
                'btcusdt_quantity'          => ['$toDouble' => '$btcusdt_quantity'],

              ]
            ],

            [
              '$group' => [

                '_id' => null,
                'btcCostAvgTotal'             =>  ['$sum' =>  ['$multiply' => ['$purchased_pricebtc',  '$btc_quantity']] ],
                'usdtCostAvgTotal'            =>  ['$sum' =>  ['$multiply' => ['$purchased_priceusdt',  '$usdt_quantity']] ],
                'btcusdtCostAvg'              =>  ['$sum' =>  ['$multiply' => ['$purchased_priceBtcusdt',  '$btcusdt_quantity']] ],
                'btcusdtCommitedCostAvg'      =>  ['$sum' => '$btcusdt_quantity'],
                'caCount'                     =>  ['$sum' => 1]
              ]
            ],
          ];

          
        $retunCostAvgOrders            =  $db->$buyCollectionNameBinance->aggregate($lookupCA);
        $orderReturnResponseCost       =  iterator_to_array($retunCostAvgOrders);

        return $orderReturnResponseCost;
    }

    public function openLthOrders($admin_id, $exchange){

        $current       =  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'));
        $current_date  =  date('Y-m-d H:i:s', strtotime('-1 month'));
        $mongo_time    =  $this->mongo_db->converToMongodttime($current_date);

        $btc_coin_in_arrBinance = ['XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC'];
        $coinArrayUSDTBinance   = ['EOSUSDT', 'LTCUSDT','XRPUSDT','NEOUSDT', 'QTUMUSDT'];
        $coinArrayBTCUSDT       = ['BTCUSDT'];

        $db = $this->mongo_db->customQuery();
        $buyCollectionNameBinance = ($exchange == 'binance') ? 'buy_orders' : 'buy_orders_'.$exchange;


        $lookupOpenLth = [
            [
              '$match' => [
                'admin_id'                =>    (string)$admin_id,
                'application_mode'        =>    'live',
                'status'                  =>    ['$in' => ['LTH', 'FILLED']],
                'resume_status'           =>    ['$exists' => false],
                'is_sell_order'           =>    ['$ne' => 'sold'],
                'trigger_type'            =>    'barrier_percentile_trigger',
                'created_date'            =>    ['$gte' => $mongo_time, '$lte' => $current],
                'count_avg_order'         =>    ['$exists' => false],
                'cavg_parent'             =>    ['$exists' => false]    
              ]
            ],

            [
              '$group' => [
              
                '_id' =>  '$_id',      
                
                'btc' => [
                  '$push' => [
                    '$cond' => [ 
                      'if' => [ '$in' => [ '$symbol', $btc_coin_in_arrBinance ] ], 
                      'then' => ['$each' , ['$symbol', '$purchased_price', '$quantity']], 
                      'else' => null
                    ]
                  ]
                ],

                'usdt' => [
                  '$push' => [
                    '$cond' => [ 
                      'if' => [ '$in' => ['$symbol' ,  $coinArrayUSDTBinance] ], 
                      'then' => ['$each' , ['$symbol', '$purchased_price', '$quantity']],    
                      'else' => null
                    ]
                  ]
                ],


                'btcusdt' => [
                  '$push' => [
                    '$cond' => [ 
                      'if' => [ '$in' => [ '$symbol', $coinArrayBTCUSDT ] ], 
                      'then' => ['$each' , ['$symbol', '$purchased_price', '$quantity']], 
                      'else' => null
                    ]
                  ]
                ],

              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$arrayElemAt' => ['$btc', 0]],
              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$arrayElemAt' => ['$purchased_pricebtc', 1]],
              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$arrayElemAt' => ['$purchased_pricebtc', 1]],
                'btc_quantity'          => ['$arrayElemAt' => ['$purchased_pricebtc', 2]]
              ]
            ],

            [
              '$addFields' => [
                'purchased_pricebtc'    => ['$toDouble' => '$purchased_pricebtc'],
                'btc_quantity'          => ['$toDouble' => '$btc_quantity'],

              ]
            ],



            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$arrayElemAt' => ['$usdt', 0]],
              ]
            ],


            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$arrayElemAt' => ['$purchased_priceusdt', 1]],
              ]
            ],


            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$arrayElemAt' => ['$purchased_priceusdt', 1]],
                'usdt_quantity'          => ['$arrayElemAt' => ['$purchased_priceusdt', 2]]
              ]
            ],

            [
              '$addFields' => [
                'purchased_priceusdt'    => ['$toDouble' => '$purchased_priceusdt'],
                'usdt_quantity'          => ['$toDouble' => '$usdt_quantity'],

              ]
            ],

            [
              '$addFields' => [
                'purchased_priceBtcusdt'    => ['$arrayElemAt' => ['$btcusdt', 0]],
              ]
            ],


            [
              '$addFields' => [
                'purchased_priceBtcusdt'    => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 1]],
              ]
            ],

            [
              '$addFields' => [

                'purchased_priceBtcusdt'    => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 1]],
                'btcusdt_quantity'          => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 2]]
              ]
            ],

            [
              '$addFields' => [
                'purchased_priceBtcusdt'    => ['$toDouble' => '$purchased_priceBtcusdt'],
                'btcusdt_quantity'          => ['$toDouble' => '$btcusdt_quantity'],

              ]
            ],

            [
              '$group' => [

                '_id' => null,
                'btcOpenLthTotal'             =>  ['$sum' =>  ['$multiply' => ['$purchased_pricebtc',  '$btc_quantity']] ],
                'usdtOpenLthTotal'            =>  ['$sum' =>  ['$multiply' => ['$purchased_priceusdt',  '$usdt_quantity']] ],
                'btcusdtOpenLth'              =>  ['$sum' =>  ['$multiply' => ['$purchased_priceBtcusdt',  '$btcusdt_quantity']] ],
                'btcusdtCommitedOpenLth'      =>  ['$sum' => '$btcusdt_quantity'],
              ]
            ],
        ];

        $retunOrdersLTH                  = $db->$buyCollectionNameBinance->aggregate($lookupOpenLth);
        $orderReturnResponseLTH          = iterator_to_array($retunOrdersLTH);

        return $orderReturnResponseLTH;
    }


    public function soldOrders($admin_id, $exchange){

        $btc_coin_in_arrBinance = ['XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC'];
        $coinArrayUSDTBinance   = ['EOSUSDT', 'LTCUSDT','XRPUSDT','NEOUSDT', 'QTUMUSDT'];
        $coinArrayBTCUSDT       = ['BTCUSDT'];


        $db = $this->mongo_db->customQuery();
        $soldCollectionNameBinance = ($exchange == 'binance') ? 'sold_buy_orders' : 'sold_buy_orders_'.$exchange;


        $current        =   $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'));
        $current_date   =   date('Y-m-d H:i:s', strtotime('-1 month'));
        $mongo_time     =   $this->mongo_db->converToMongodttime($current_date);

        $lookupSold = [
            [
                '$match' => [
                'admin_id'                =>    (string)$admin_id,
                'application_mode'        =>    'live',
                'status'                  =>    'FILLED',
                'resume_status'           =>    ['$exists' => false],
                'is_sell_order'           =>    'sold',
                'trigger_type'            =>    'barrier_percentile_trigger',
                'created_date'            =>    ['$gte' => $mongo_time, '$lte' => $current],
                'cavg_parent'             =>    ['$exists' => false],   
                'cost_avg'                =>    ['$nin' => ['yes', 'taking_child', 'completed']],
                ]
            ],


            [
                '$group' => [
                
                '_id' =>  '$_id',      
                
                'btc' => [
                    '$push' => [
                    '$cond' => [ 
                        'if' => [ '$in' => [ '$symbol', $btc_coin_in_arrBinance ] ], 
                        'then' => ['$each' , ['$symbol', '$purchased_price', '$quantity', '$market_sold_price']], 
                        'else' => null
                    ]
                    ]
                ],

                'usdt' => [
                    '$push' => [
                    '$cond' => [ 
                        'if' => [ '$in' => ['$symbol' ,  $coinArrayUSDTBinance] ], 
                        'then' => ['$each' , ['$symbol', '$purchased_price', '$quantity', '$market_sold_price']],    
                        'else' => null
                    ]
                    ]
                ],


                'btcusdt' => [
                    '$push' => [
                    '$cond' => [ 
                        'if' => [ '$in' => [ '$symbol', $coinArrayBTCUSDT ] ], 
                        'then' => ['$each' , ['$symbol', '$purchased_price', '$quantity', '$market_sold_price']], 
                        'else' => null
                    ]
                    ]
                ],

                ]
            ],

            [
                '$addFields' => [
                'purchased_pricebtc'    => ['$arrayElemAt' => ['$btc', 0]],
                ]
            ],

            [
                '$addFields' => [
                'purchased_pricebtc'    => ['$arrayElemAt' => ['$purchased_pricebtc', 1]],
                ]
            ],

            [
                '$addFields' => [
                'purchased_pricebtc'    => ['$arrayElemAt' => ['$purchased_pricebtc', 1]],
                'btc_quantity'          => ['$arrayElemAt' => ['$purchased_pricebtc', 2]],
                'market_sold_price_btc'     => ['$arrayElemAt' => ['$purchased_pricebtc', 3]],

                ]
            ],

            [
                '$addFields' => [
                'purchased_pricebtc'    => ['$toDouble' => '$purchased_pricebtc'],
                'btc_quantity'          => ['$toDouble' => '$btc_quantity'],
                'market_sold_price_btc'     => ['$toDouble' => '$market_sold_price_btc'],


                ]
            ],



            [
                '$addFields' => [
                'purchased_priceusdt'    => ['$arrayElemAt' => ['$usdt', 0]],
                ]
            ],


            [
                '$addFields' => [
                'purchased_priceusdt'    => ['$arrayElemAt' => ['$purchased_priceusdt', 1]],
                ]
            ],


            [
                '$addFields' => [
                'purchased_priceusdt'    => ['$arrayElemAt' => ['$purchased_priceusdt', 1]],
                'usdt_quantity'          => ['$arrayElemAt' => ['$purchased_priceusdt', 2]],
                'market_sold_price_usdt' => ['$arrayElemAt' => ['$purchased_priceusdt', 3]],

                ]
            ],

            [
                '$addFields' => [
                'purchased_priceusdt'    => ['$toDouble' => '$purchased_priceusdt'],
                'usdt_quantity'          => ['$toDouble' => '$usdt_quantity'],
                'market_sold_price_usdt' => ['$toDouble' => '$market_sold_price_usdt'],
                ]
            ],

            // [
            //   '$addFields' => [
            //     'purchased_priceBtcusdt'    => ['$arrayElemAt' => ['$btcusdt', 0]],
            //   ]
            // ],


            // [
            //   '$addFields' => [
            //     'purchased_priceBtcusdt'    => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 1]],
            //   ]
            // ],

            // [
            //   '$addFields' => [

            //     'purchased_priceBtcusdt'    => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 1]],
            //     'btcusdt_quantity'          => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 2]],
            //     'market_sold_price_btcusdt' => ['$arrayElemAt' => ['$purchased_priceBtcusdt', 3]],

            //   ]
            // ],

            // [
            //   '$addFields' => [
            //     'purchased_priceBtcusdt'    => ['$toDouble' => '$purchased_priceBtcusdt'],
            //     'btcusdt_quantity'          => ['$toDouble' => '$btcusdt_quantity'],
            //     'market_sold_price_btcusdt' => ['$toDouble' => '$market_sold_price_btcusdt'],

            //   ]
            // ],

            [
                '$group' => [

                '_id' => null,
                'btcSoldTotal'             =>  ['$sum' =>  ['$multiply' => ['$purchased_pricebtc',  '$btc_quantity']] ],
                'usdtSoldTotal'            =>  ['$sum' =>  ['$multiply' => ['$purchased_priceusdt',  '$usdt_quantity']] ],
                
                'investProfitUSDTBinance'            =>  ['$sum' =>  ['$multiply' => ['$market_sold_price_usdt',  '$usdt_quantity']] ],
                'btcInvestmentCalBinance'            =>  ['$sum' =>  ['$multiply' => ['$market_sold_price_btc',  '$btc_quantity']] ],
                'soldCount'                =>  ['$sum' =>   1]

                ]
            ],
        ];

        $data               =   $db->$soldCollectionNameBinance->aggregate($lookupSold);
        $total_sold_rec     =   iterator_to_array($data);

       return $total_sold_rec;

    }
}