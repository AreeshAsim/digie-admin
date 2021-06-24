<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monthly_trading_volume extends CI_Controller {

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

        $this->load->helper('new_common_helper');
    }

    public function index(){
        
        $this->mod_login->verify_is_admin_login();
        // $custom = $this->mongo_db->customQuery();
        $this->load->library('mongo_db_3');
        $db_3 = $this->mongo_db_3->customQuery();

        $coin_array_all = $this->mod_coins->get_all_coins();

        if( $_GET['button'] == 'reset' ){

            $this->session->unset_userdata('user_post_data');
        }

        if($this->input->post()){

            $setSession['user_post_data'] = $this->input->post();
            $this->session->set_userdata($setSession);
        }

        $getFilterData = $this->session->userdata('user_post_data');

        if($getFilterData){
            if( !empty($getFilterData['filter_by_coin']) ){ 

                $searchCriteria['coin']['$in']  =   $getFilterData['filter_by_coin'];
            }else{

                $searchCriteria['coin'] = 'BTCUSDT';
            }

            if( !empty($getFilterData['start_date']) && !empty($getFilterData['end_date'])){
                $startDate  =  $this->mongo_db->converToMongodttime($getFilterData['start_date']);
                $endDate    =  $this->mongo_db->converToMongodttime($getFilterData['end_date']);
                
                $searchCriteria['timestampDate'] = ['$gte' => $startDate, '$lte' => $endDate];

            } else{

                $startDate  =  $this->mongo_db->converToMongodttime(date('Y-m-d 00:00'));
                $endDate    =  $this->mongo_db->converToMongodttime(date('Y-m-d 23:00'));

                $searchCriteria['timestampDate'] = ['$gte' => $startDate, '$lte' => $endDate];

            }

            $lookup = [
                [
                    '$match' => $searchCriteria
                ],
                [
                    '$project' => [

                        '_id' => 1,
                        'timestampDate' =>  '$timestampDate',
                        'coins'         =>  '$coin',
                        'high'          =>  '$high',
                        'low'           =>  '$low',
                    ]
                ],
                    
                // [
                //     '$limit' => 20
                // ]
            ];


            // $limitCount = count($getFilterData['filter_by_coin']);
            $get = $db_3->market_chart->aggregate($lookup);  
            $res = iterator_to_array($get);

        }

		$data['coins']   = $coin_array_all;
        $data['resData'] = $res;

        $this->stencil->paint('admin/monthly_trading_volume/high_low_chart', $data); 
    }
    //////////////////////////////
    //////////Cron for Chart ///////
    //////////////////////////////
    
    public function fee_analysis_binance(){

        ini_set("display_errors", E_ALL);
        error_reporting(E_ALL);
        $coin_arrayBtc  = ['XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC'];
        $coin_arrayUSDT = ['EOSUSDT', 'LTCUSDT','XRPUSDT','NEOUSDT', 'QTUMUSDT','BTCUSDT'];

        $startDate = $this->mongo_db->converToMongodttime(date('Y-m-d 07:59', strtotime('-1 days') ) );
        $endDate   = $this->mongo_db->converToMongodttime(date('Y-m-d 07:59'));
        
        $lookup = [
            [
                '$match' => [
                    
                    'created_date' => ['$gte' => $startDate, '$lte' => $endDate],
                    'level'        => ['$in'  => ['level_5', 'level_6', 'level_8', 'level_10', 'level_11', 'level_12', 'level_13', 'level_17', 'level_18']],
                ]
            ],
            [
                '$group' => [

                    '_id' => null,
                    'btc_invest_amount'         => ['$sum' => '$btc_invest_amount'],
                    'usdt_invest_amount'        => ['$sum' => '$usdt_invest_amount'],
                    'buy_commision'             => ['$sum' => '$buy_commision'],
                    'sell_fee_coin_USDT'        => ['$sum' => '$sell_commision_qty_USDT'],
                    'sell_commission'           => ['$sum' => '$sell_commission'],
                    'buy_commision_qty'         => ['$sum' => '$buy_commision_qty_USDT'],
                    'count'                     => ['$sum' => 1 ] ,    
                    'sell_btc_in_$'             => ['$sum' => '$sell_btc_in_$'],
                    'sell_usdt'                 => ['$sum' => '$sell_usdt'],
                    'total_sell_in_usdt'        => ['$sum' => '$total_sell_in_usdt'],
                ]
            ],
        ];

    
        $db = $this->mongo_db->customQuery();
        
        $result = $db->opportunity_logs_binance->aggregate($lookup);
        $resultResponse = iterator_to_array($result);

        $convertedUSDAmount   =   ($resultResponse[0]['btc_invest_amount'] > 0)  ?  convertCoinBalanceIntoUSDT('BTCUSDT', $resultResponse[0]['btc_invest_amount'], 'binance') : 0;
        $sell_commission_Usdt =   ($resultResponse[0]['sell_commission'] > 0)  ?  convertCoinBalanceIntoUSDT('BNB', $resultResponse[0]['sell_commission'], 'binance') : 0;
        
        //new query for calculate total buy/sell trade counts
        $lookupCount = [
            [
                '$match' => [
                    
                    'created_date' => ['$gte' => $startDate, '$lte' => $endDate],
                    'level'        => ['$in'  => ['level_5', 'level_6', 'level_8', 'level_10', 'level_11', 'level_12', 'level_13', 'level_17', 'level_18']],
                ]
            ],
            
            [
                '$addFields' => [

                    'open_lth'      => ['$toDouble' => '$open_lth'],
                    'sold'          => ['$toDouble' => '$sold'],
                    'other_status'  => ['$toDouble' => '$other_status'],
                    

                ]
            ],

            [
                '$project' => [

                    '_id' => 1,

                    'totalBuyCount'  =>  ['$sum' => ['$open_lth', '$sold', '$other_status']],
                    'totalSoldCount' =>  ['$sum' => '$sold'],

                     'totalBuyBtc' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$in' => ['$coin', $coin_arrayBtc]],
                                'then' => ['$sum' => ['$open_lth', '$sold', '$other_status']],
                                'else' => 0
                            ]
                        ]
                    ],

                    'totalBuyUsdt' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$in' => ['$coin' , $coin_arrayUSDT]],
                                'then' => ['$sum' => ['$open_lth', '$sold', '$other_status']],
                                'else' => 0
                            ]
                        ]
                    ],

                    'totalSoldUsdt' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$in' => ['$coin',  $coin_arrayUSDT]],
                                'then' => ['$sum' => '$sold'],
                                'else' => 0
                            ]
                        ]
                    ],

                    'totalSoldBtc' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$in' => ['$coin', $coin_arrayBtc]],
                                'then' => ['$sum' => '$sold'],
                                'else' => 0
                            ]
                        ]
                    ],

                ]
            ],

            [
                '$group' => [
                    '_id' => null,
                    'totalBuyCount'   => ['$sum' => '$totalBuyCount'],
                    'totalSoldCount'  => ['$sum' => '$totalSoldCount'],
                    'totalBuyBtc'     => ['$sum' => '$totalBuyBtc'],
                    'totalBuyUsdt'    => ['$sum' => '$totalBuyUsdt'],
                    'totalSoldUsdt'   => ['$sum' => '$totalSoldUsdt'],
                    'totalSoldBtc'    => ['$sum' => '$totalSoldBtc'],
                    
                ]
            ],
        ];

        $resultCount         = $db->opportunity_logs_binance->aggregate($lookupCount);
        $resultResponseCount = iterator_to_array($resultCount);

        //get expected count
        $getTradeNumberCount = [
            'exchange'  	=>  'binance',
            'created_date'  =>   $this->mongo_db->converToMongodttime(date('Y-m-d')),
        ];

        $getTradeCount 		    = 	$db->expected_trade_buy_count_history->find($getTradeNumberCount);
        $expectedCountResponse  = 	iterator_to_array($getTradeCount);
       
        $upsertedArray = [
            'created_date'           =>  $this->mongo_db->converToMongodttime(date('Y-m-d 07:59')),
            'total_invest'           =>  (float)($convertedUSDAmount + $resultResponse[0]['usdt_invest_amount']),
            'totaolInvestInbtc'      =>  $convertedUSDAmount,
            'totalInvestInbtc'       =>  $resultResponse[0]['btc_invest_amount'],
            'totaolInvestInUSDT'     =>  $resultResponse[0]['usdt_invest_amount'],
            'buy_commision'          =>  (float)($resultResponse[0]['buy_commision'] + $resultResponse[0]['buy_commision_qty_USDT']),            
            'sell_commission'        =>  (float)($sell_commission_Usdt + $resultResponse[0]['sell_fee_coin_USDT']),
            'numberOfOpportunities'  =>  $resultResponse[0]['count'],
            'totalBuyTradeCount'     =>  (float)($resultResponseCount[0]['totalBuyCount']),
            'totalSoldTradeCount'    =>  (float)($resultResponseCount[0]['totalSoldCount']),
            'totalBuyBtc'            =>  (float)($resultResponseCount[0]['totalBuyBtc']),
            'totalBuyUsdt'           =>  (float)($resultResponseCount[0]['totalBuyUsdt']),
            'totalSoldUsdt'          =>  (float)($resultResponseCount[0]['totalSoldUsdt']),
            'totalSoldBtc'           =>  (float)($resultResponseCount[0]['totalSoldBtc']),
            'expected_btc_count'     =>  (float)($expectedCountResponse[0]['total_btc_count']),
            'expected_usdt_count'    =>  (float)($expectedCountResponse[0]['total_usdt_count']),
            'month'                  =>  date('Y-m-d'),
            'exchange'               =>  'binance',
            'mode'                   =>  'live',
            'sell_btc_in_$'          =>  (float)$resultResponse[0]['$sell_btc_in_$'],
            'sell_usdt'              =>  (float)$resultResponse[0]['$sell_usdt'],
            'total_sell_in_usdt'     =>  (float)$resultResponse[0]['$total_sell_in_usdt'],
        ];
        echo "<pre>"; print_r($upsertedArray);
        $upsertedWhere['month']          =  date('Y-m-d');
        $upsertedWhere['exchange']       =  'binance';
        $upsertedWhere['mode']           =  'live';

        $getRes = $db->daily_investment_chart_data->updateOne($upsertedWhere, ['$set' => $upsertedArray],  ['upsert' => true]);
        echo "<br>modified count". $getRes->getModifiedCount();
        echo "<br>upserted count". $getRes->getUpsertedCount();
        echo "<br>sucessfull updated";
    }

    public function fee_analysis_kraken(){

        $coin_arrayBtc  = ['XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC'];
        $coin_arrayUSDT = ['EOSUSDT', 'LTCUSDT','XRPUSDT','NEOUSDT', 'QTUMUSDT','BTCUSDT'];

        $startDate = $this->mongo_db->converToMongodttime(date('Y-m-d 07:59', strtotime('-1 days') ) );
        $endDate   = $this->mongo_db->converToMongodttime(date('Y-m-d 07:59'));
        
        $lookup = [
            [
                '$match' => [
                    
                    'created_date' => ['$gte' => $startDate, '$lte' => $endDate],
                    'level'        => ['$in'  => ['level_5', 'level_6', 'level_8', 'level_10', 'level_11', 'level_12', 'level_13', 'level_17', 'level_18']],
                ]
            ],
            [
                '$group' => [

                    '_id' => null,
                    'btc_invest_amount'         => ['$sum' => '$btc_invest_amount'],
                    'usdt_invest_amount'        => ['$sum' => '$usdt_invest_amount'],
                    'sell_fee_respected_coin'   => ['$sum' => '$sell_fee_respected_coin'],
                    'count'                     => ['$sum' => 1 ],
                    'buy_commision_qty'         => ['$sum' => '$buy_commision_qty_USDT'],   
                    'open_lth'                  => ['$sum' =>  '$open_lth'],
                    'sold'                      => ['$sum' =>  '$sold'],   
                    'sell_commession'           => ['$sum' => '$sell_commision_qty_USDT'],
                    'other_status'              => ['$sum' =>  '$other_status'],
                    'sell_btc_in_$'             => ['$sum' => '$sell_btc_in_$'],
                    'sell_usdt'                 => ['$sum' => '$sell_usdt'],
                    'total_sell_in_usdt'        => ['$sum' => '$total_sell_in_usdt'],
                ]
            ],
        ];

        $db = $this->mongo_db->customQuery();
        $result = $db->opportunity_logs_kraken->aggregate($lookup);   
        $resultResponse = iterator_to_array($result);

        $convertedUSDAmount =   ($resultResponse[0]['btc_invest_amount'] > 0) ?   convertCoinBalanceIntoUSDT('BTCUSDT', $resultResponse[0]['btc_invest_amount'], 'kraken') : 0;
        
        $lookupCount = [
            [
                '$match' => [
                    
                    'created_date' => ['$gte' => $startDate, '$lte' => $endDate],
                    'level'        => ['$in'  => ['level_5', 'level_6', 'level_8', 'level_10', 'level_11', 'level_12', 'level_13', 'level_17', 'level_18']],
                ]
            ],
            
            [
                '$addFields' => [

                    'open_lth'      => ['$toDouble' => '$open_lth'],
                    'sold'          => ['$toDouble' => '$sold'],
                    'other_status'  => ['$toDouble' => '$other_status'],
                    

                ]
            ],

            [
                '$project' => [

                    '_id' => 1,

                    'totalBuyCount'  =>  ['$sum' => ['$open_lth', '$sold', '$other_status']],
                    'totalSoldCount' =>  ['$sum' => '$sold'],

                     'totalBuyBtc' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$in' => ['$coin', $coin_arrayBtc]],
                                'then' => ['$sum' => ['$open_lth', '$sold', '$other_status']],
                                'else' => 0
                            ]
                        ]
                    ],

                    'totalBuyUsdt' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$in' => ['$coin' , $coin_arrayUSDT]],
                                'then' => ['$sum' => ['$open_lth', '$sold', '$other_status']],
                                'else' => 0
                            ]
                        ]
                    ],

                    'totalSoldUsdt' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$in' => ['$coin',  $coin_arrayUSDT]],
                                'then' => ['$sum' => '$sold'],
                                'else' => 0
                            ]
                        ]
                    ],

                    'totalSoldBtc' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$in' => ['$coin', $coin_arrayBtc]],
                                'then' => ['$sum' => '$sold'],
                                'else' => 0
                            ]
                        ]
                    ],

                ]
            ],

            [
                '$group' => [
                    '_id' => null,
                    'totalBuyCount'   => ['$sum' => '$totalBuyCount'],
                    'totalSoldCount'  => ['$sum' => '$totalSoldCount'],
                    'totalBuyBtc'     => ['$sum' => '$totalBuyBtc'],
                    'totalBuyUsdt'    => ['$sum' => '$totalBuyUsdt'],
                    'totalSoldUsdt'   => ['$sum' => '$totalSoldUsdt'],
                    'totalSoldBtc'    => ['$sum' => '$totalSoldBtc'],
                    
                ]
            ],
        ];
       
        $resultCount         = $db->opportunity_logs_kraken->aggregate($lookupCount);
        $resultResponseCount = iterator_to_array($resultCount);

        //get expected count
        $getTradeNumberCount = [
            'exchange'  	=>  'kraken',
            'created_date'  =>   $this->mongo_db->converToMongodttime(date('Y-m-d')),
        ];

        $getTradeCount 		    = 	$db->expected_trade_buy_count_history->find($getTradeNumberCount);
        $expectedCountResponse  = 	iterator_to_array($getTradeCount);

        $upsertedArray = [
            'created_date'              =>  $this->mongo_db->converToMongodttime(date('Y-m-d 07:59')),
            'totaolInvestInbtc'         =>  $convertedUSDAmount,
            'total_invest'              =>  (float)($convertedUSDAmount + $resultResponse[0]['usdt_invest_amount']),
            'totalInvestInbtc'          =>  $resultResponse[0]['btc_invest_amount'],  
            'totaolInvestInUSDT'        =>  $resultResponse[0]['usdt_invest_amount'],
            'buy_commision_qty'         =>  $resultResponse[0]['buy_commision_qty_USDT'],
            'sell_commission'           =>  $resultResponse[0]['sell_commission'],
            'numberOfOpportunities'     =>  $resultResponse[0]['count'],
            'totalBuyTradeCount'        =>  (float)($resultResponse[0]['open_lth'] + $resultResponse[0]['sold'] + $resultResponse[0]['other_status']),
            'totalSoldTradeCount'       =>  (float)($resultResponse[0]['sold']),
            'totalBuyTradeCount'        =>  (float)($resultResponseCount[0]['totalBuyCount']),
            'totalSoldTradeCount'       =>  (float)($resultResponseCount[0]['totalSoldCount']),
            'totalBuyBtc'               =>  (float)($resultResponseCount[0]['totalBuyBtc']),
            'totalBuyUsdt'              =>  (float)($resultResponseCount[0]['totalBuyUsdt']),
            'totalSoldUsdt'             =>  (float)($resultResponseCount[0]['totalSoldUsdt']),
            'totalSoldBtc'              =>  (float)($resultResponseCount[0]['totalSoldBtc']),
            'expected_btc_count'        =>  (float)($expectedCountResponse[0]['total_btc_count']),
            'expected_usdt_count'       =>  (float)($expectedCountResponse[0]['total_usdt_count']),
            'month'                     =>  date('Y-m-d'),
            'exchange'                  =>  'kraken',
            'mode'                      =>  'live',
            'sell_btc_in_$'             =>  (float)$resultResponse[0]['$sell_btc_in_$'],
            'sell_usdt'                 =>  (float)$resultResponse[0]['$sell_usdt'],
            'total_sell_in_usdt'        =>  (float)$resultResponse[0]['$total_sell_in_usdt'],
        ];

        echo "<pre>";print_r($upsertedArray);
        $upsertedWhere['exchange']       =  'kraken';
        $upsertedWhere['month']          =   date('Y-m-d');
        $upsertedWhere['mode']           =  'live';

        $getRes = $db->daily_investment_chart_data->updateOne($upsertedWhere, ['$set' => $upsertedArray],  ['upsert' => true]);
        echo "<br>modified count". $getRes->getModifiedCount();
        echo "<br>upserted count". $getRes->getUpsertedCount();
        echo "<br>Successfully update";
    }

    public function fee_analysis_bam(){
        
        $coin_arrayBtc = ['XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC'];    
        $USDTcoin_array = ['EOSUSDT', 'LTCUSDT','XRPUSDT','NEOUSDT', 'QTUMUSDT'];

        $startDate = $this->mongo_db->converToMongodttime(date('Y-m-d 07:59'));
        $endDate   = $this->mongo_db->converToMongodttime(date('Y-m-d 07:59', strtotime('+1 days')) );
        
        $lookup = [
            [
                '$match' => [
                    
                    'created_date' => ['$gte' => $startDate, '$lte' => $endDate],
                    'level'        => ['$in'  => ['level_5', 'level_6', 'level_8', 'level_10', 'level_11', 'level_12', 'level_13', 'level_17', 'level_18']],
                ]
            ],
            [
                '$group' => [

                    '_id' => null,
                    'btc_invest_amount'         => ['$sum' => '$btc_invest_amount'],
                    'usdt_invest_amount'        => ['$sum' => '$usdt_invest_amount'],
                    'buy_commision_qty'         => ['$sum' => '$buy_commision_qty'],
                    'buy_commision'             => ['$sum' => '$buy_commision'],
                    'sell_fee_respected_coin'   => ['$sum' => '$sell_fee_respected_coin'],
                    'sell_commission'           => ['$sum' => '$sell_commission'],
                    'count'                     => ['$sum' => 1 ],
                    'open_lth'                  => ['$sum' =>  '$open_lth'],
                    'sold'                      => ['$sum' =>  '$sold'],   
                    'other_status'              => ['$sum' =>  '$other_status'],
                    'sell_btc_in_$'             => ['$sum' => '$sell_btc_in_$'],
                    'sell_usdt'                 => ['$sum' => '$sell_usdt'],
                    'total_sell_in_usdt'        => ['$sum' => '$total_sell_in_usdt'],
                           
                ]
            ],
        ];

        $db = $this->mongo_db->customQuery();
        $result = $db->opportunity_logs_bam->aggregate($lookup);
        $resultResponse = iterator_to_array($result);
        $convertedUSDAmount =   ($resultResponse[0]['btc_invest_amount'] > 0) ?   convertCoinBalanceIntoUSDT('BTCUSDT', $resultResponse[0]['btc_invest_amount'], 'bam') : 0;

        //new query for calculate total buy/sell trade counts
        $lookupCount = [
            [
                '$match' => [
                    
                    'created_date' => ['$gte' => $startDate, '$lte' => $endDate],
                    'level'        => ['$in'  => ['level_5', 'level_6', 'level_8', 'level_10', 'level_11', 'level_12', 'level_13', 'level_17', 'level_18']],
                ]
            ],
            
            [
                '$addFields' => [

                    'open_lth'      => ['$toDouble' => '$open_lth'],
                    'sold'          => ['$toDouble' => '$sold'],
                    'other_status'  => ['$toDouble' => '$other_status'],
                    

                ]
            ],

            [
                '$project' => [

                    '_id' => 1,

                    'totalBuyCount'  =>  ['$sum' => ['$open_lth', '$sold', '$other_status']],
                    'totalSoldCount' =>  ['$sum' => '$sold'],

                     'totalBuyBtc' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$in' => ['$coin', $coin_arrayBtc]],
                                'then' => ['$sum' => ['$open_lth', '$sold', '$other_status']],
                                'else' => 0
                            ]
                        ]
                    ],

                    'totalBuyUsdt' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$in' => ['$coin' , $USDTcoin_array]],
                                'then' => ['$sum' => ['$open_lth', '$sold', '$other_status']],
                                'else' => 0
                            ]
                        ]
                    ],

                    'totalSoldUsdt' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$in' => ['$coin',  $coin_arrayUSDT]],
                                'then' => ['$sum' => '$sold'],
                                'else' => 0
                            ]
                        ]
                    ],

                    'totalSoldBtc' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$in' => ['$coin', $coin_arrayBtc]],
                                'then' => ['$sum' => '$sold'],
                                'else' => 0
                            ]
                        ]
                    ],

                ]
            ],

            [
                '$group' => [
                    '_id' => null,
                    'totalBuyCount'   => ['$sum' => '$totalBuyCount'],
                    'totalSoldCount'  => ['$sum' => '$totalSoldCount'],
                    'totalBuyBtc'     => ['$sum' => '$totalBuyBtc'],
                    'totalBuyUsdt'    => ['$sum' => '$totalBuyUsdt'],
                    'totalSoldUsdt'   => ['$sum' => '$totalSoldUsdt'],
                    'totalSoldBtc'    => ['$sum' => '$totalSoldBtc'],
                    
                ]
            ],
        ];

        $resultCount         = $db->opportunity_logs_bam->aggregate($lookupCount);
        $resultResponseCount = iterator_to_array($resultCount);


        //get expected count
        $getTradeNumberCount = [
            'exchange'  	=>  'bam',
            'created_date'  =>   $this->mongo_db->converToMongodttime(date('Y-m-d')),
        ];

        $getTradeCount 		    = 	$db->expected_trade_buy_count_history->find($getTradeNumberCount);
        $expectedCountResponse  = 	iterator_to_array($getTradeCount);


        $upsertedArray = [
            'created_date'            =>  $this->mongo_db->converToMongodttime(date('Y-m-d 07:59')),
            'totaolInvestInbtc'       =>  $convertedUSDAmount,
            'total_invest'            =>  (float)($convertedUSDAmount + $resultResponse[0]['usdt_invest_amount']),
            'totaolInvestInUSDT'      =>  $resultResponse[0]['usdt_invest_amount'],
            'buy_commision_qty'       =>  $resultResponse[0]['buy_commision_qty'],
            'buy_commision'           =>  $resultResponse[0]['buy_commision'],
            'sell_fee_respected_coin' =>  $resultResponse[0]['sell_fee_respected_coin'],
            'sell_commission'         =>  $resultResponse[0]['sell_commission'],
            'numberOfOpportunities'   =>  $resultResponse[0]['count'],
            'totalBuyTradeCount'      =>  (float)($resultResponse[0]['open_lth'] + $resultResponse[0]['sold'] + $resultResponse[0]['other_status']),
            'totalSoldTradeCount'     =>  (float)($resultResponse[0]['sold']),
            'totalBuyTradeCount'      =>  (float)($resultResponseCount[0]['totalBuyCount']),
            'totalSoldTradeCount'     =>  (float)($resultResponseCount[0]['totalSoldCount']),
            'totalBuyBtc'             =>  (float)($resultResponseCount[0]['totalBuyBtc']),
            'totalBuyUsdt'            =>  (float)($resultResponseCount[0]['totalBuyUsdt']),
            'totalSoldUsdt'           =>  (float)($resultResponseCount[0]['totalSoldUsdt']),
            'totalSoldBtc'            =>  (float)($resultResponseCount[0]['totalSoldBtc']),
            'expected_btc_count'      =>  (float)($expectedCountResponse[0]['total_btc_count']),
            'expected_usdt_count'     =>  (float)($expectedCountResponse[0]['total_usdt_count']),
            'month'                   =>  date('Y-m-d'),
            'exchange'                =>  'bam',
            'mode'                    =>  'live',
            'sell_btc_in_$'           =>  (float)$resultResponse[0]['$sell_btc_in_$'],
            'sell_usdt'               =>  (float)$resultResponse[0]['$sell_usdt'],
            'total_sell_in_usdt'      =>  (float)$resultResponse[0]['$total_sell_in_usdt'],
        ];
        $upsertedWhere['exchange']       =  'bam';
        $upsertedWhere['month']          =  date('Y-m-d');
        $upsertedWhere['mode']           =  'live';

        $getRes = $db->daily_investment_chart_data->updateOne($upsertedWhere, ['$set' => $upsertedArray],  ['upsert' => true]);
        echo "<br>modified count". $getRes->getModifiedCount();
        echo "<br>upserted count". $getRes->getUpsertedCount();
        echo "<br>Successfully update";
    }

    public function count_users_records_charts(){
         
        $startDate = $this->mongo_db->converToMongodttime(date('Y-m-d 07:59'));
        
        $collection_name_Binance    = 'user_investment_binance';
        $collection_name_kraken     = 'user_investment_kraken';
        $collection_name_Bam        = 'user_investment_bam';
        $db  = $this->mongo_db->customQuery();
        
        $lookup = [
            [
                '$group' => [
                    '_id' => null,
                    'Total' => ['$sum' => 1],
                    'active' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$eq' => ['$exchange_enabled', 'yes']],
                                'then' => 1,
                                'else' => 0
                            ]
                        ]
                    ],
                    
                    
                    'unactive' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$eq' => ['$exchange_enabled', 'no']],
                                'then' => 1,
                                'else' => 0
                            ]
                        ]
                    ],
                    
                    'test' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$in' => ['$exchange_enabled', ['yes', 'no']]],
                                'then' => 0,
                                'else' => 1
                            ]
                        ]
                    ],
                ]
            ],
        ];
        $get_binance    =    $db->$collection_name_Binance->aggregate($lookup);
        $get_binanceRes =    iterator_to_array($get_binance); /// Binance result

        $get_kraken     =    $db->$collection_name_kraken->aggregate($lookup);
        $get_krakenRes  =    iterator_to_array($get_kraken); ///// Kraken result
        
        $get_bam        =    $db->$collection_name_Bam->aggregate($lookup);
        $get_bamRes     =    iterator_to_array($get_bam);////// Bam result
        
        $loockupForInvestmentRepost = [
            [
                '$project' => [
                    '_id'  => 1,

                    'loginCount' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$gte' => ['$last_login_time', $startDate]] ,
                                'then' => 1,
                                'else' => 0
                            ]
                        ]
                    ],


                    'blockUsers' => [
                        '$sum' =>[
                            '$cond' => [
                                'if' => ['$eq' => ['$exchange_enabled', 'block']],
                                'then' => 1,
                                'else' => 0
                            ]
                        ]
                    ],

                    'balanceAre500_Greater' => [
                        '$sum' => [
                            '$cond' => [
                                
                                'if' => ['$gte' => ['$actual_deposit', 500]],
                                'then' => 1,
                                'else' => 0
                            ]
                        ]
                    ],


                    'balanceAre1000_Greater' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$gte' => ['$actual_deposit', 1000]],
                                'then' => 1,
                                'else' => 0
                            ]
                        ]
                    ],

                    'balanceAre2500_Greater' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$gte' => ['$actual_deposit', 2500]],
                                'then' => 1,
                                'else' => 0
                            ]
                        ]
                    ],


                    'lthBalance50_grater_per' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$gte' => ['$lth_cost_avg_balance_percentage', 50]],
                                'then' => 1,
                                'else' => 0
                            ]
                        ]
                    ],


                    'lthBalance30_grater_per' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$gte' => ['$lth_cost_avg_balance_percentage', 30]],
                                'then' => 1,
                                'else' => 0
                            ]
                        ]
                    ],


                    'lthBalance70_grater_per' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$gte' => ['$lth_cost_avg_balance_percentage', 70]],
                                'then' => 1,
                                'else' => 0
                            ]
                        ]
                    ],

                    'lthBalance100_grater_per' => [
                        '$sum' => [
                            '$cond' => [
                                'if' => ['$gte' => ['$lth_cost_avg_balance_percentage', 100]],
                                'then' => 1,
                                'else' => 0
                            ]
                        ]
                    ],


                ],
            ],


            [
                '$group' => [
                    '_id' => null,

                    'lthBalance50_grater_per' => ['$sum' => '$lthBalance50_grater_per'],
                    'lthBalance30_grater_per' => ['$sum' => '$lthBalance30_grater_per'],
                    'lthBalance70_grater_per' => ['$sum' => '$lthBalance70_grater_per'],
                    'lthBalance100_grater_per'=> ['$sum' => '$lthBalance100_grater_per'],

                    'blockUsers'              => ['$sum' => '$blockUsers'],
                    'balanceAre500_Greater'   => ['$sum' => '$balanceAre500_Greater'],
                    'balanceAre1000_Greater'  => ['$sum' => '$balanceAre1000_Greater'],
                    'balanceAre2500_Greater'  => ['$sum' => '$balanceAre2500_Greater'],
                    'loginCount'              => ['$sum' => '$loginCount']
                ]
            ]
        ];

        $userDetails 		    = 	$db->$collection_name_Binance->aggregate($loockupForInvestmentRepost);
        $userDSetailsBinance    = 	iterator_to_array($userDetails);

        $userDetails 		    = 	$db->$collection_name_kraken->aggregate($loockupForInvestmentRepost);
        $userDSetailsKraken     = 	iterator_to_array($userDetails);

        $userDetails 		    = 	$db->$collection_name_Bam->aggregate($loockupForInvestmentRepost);
        $userDSetailsBam        = 	iterator_to_array($userDetails);

        $upsertedArray_binance = [
            'created_date'              =>  $this->mongo_db->converToMongodttime(date('Y-m-d 07:59')),
            'Total_users'               =>  $get_binanceRes[0]['Total'],
            'Active_users'              =>  $get_binanceRes[0]['active'],
            'Unactive_users'            =>  $get_binanceRes[0]['unactive'],
            'Test_users'                =>  $get_binanceRes[0]['test'],
            'exchange'                  =>  'binance',
            'month'                     =>  date('Y-m-d'),
            'lthBalance50_grater_per'   =>  $userDSetailsBinance[0]['lthBalance50_grater_per'],
            'blockUsers'                =>  $userDSetailsBinance[0]['blockUsers'],
            'lthBalance30_grater_per'   =>  $userDSetailsBinance[0]['lthBalance30_grater_per'],
            'lthBalance70_grater_per'   =>  $userDSetailsBinance[0]['lthBalance70_grater_per'],
            'lthBalance100_grater_per'  =>  $userDSetailsBinance[0]['lthBalance100_grater_per'],
            'balanceAre500_Greater'     =>  $userDSetailsBinance[0]['balanceAre500_Greater'],
            'balanceAre1000_Greater'    =>  $userDSetailsBinance[0]['balanceAre1000_Greater'],
            'balanceAre2500_Greater'    =>  $userDSetailsBinance[0]['balanceAre2500_Greater'],
            'loginCount'                =>  $userDSetailsBinance[0]['loginCount'],
        ]; // Binance array
        $upsertedArray_kraken = [
            'created_date'              =>  $this->mongo_db->converToMongodttime(date('Y-m-d 07:59')),
            'Total_users'               =>  $get_krakenRes[0]['Total'],
            'Active_users'              =>  $get_krakenRes[0]['active'],
            'Unactive_users'            =>  $get_krakenRes[0]['unactive'],
            'Test_users'                =>  $get_krakenRes[0]['test'],
            'exchange'                  =>  'kraken',
            'month'                     =>  date('Y-m-d'),
            'lthBalance50_grater_per'   =>  $userDSetailsKraken[0]['lthBalance50_grater_per'],
            'lthBalance30_grater_per'   =>  $userDSetailsBinance[0]['lthBalance30_grater_per'],
            'lthBalance70_grater_per'   =>  $userDSetailsBinance[0]['lthBalance70_grater_per'],
            'lthBalance100_grater_per'  =>  $userDSetailsBinance[0]['lthBalance100_grater_per'],
            'blockUsers'                =>  $userDSetailsKraken[0]['blockUsers'],
            'balanceAre500_Greater'     =>  $userDSetailsKraken[0]['balanceAre500_Greater'],
            'balanceAre1000_Greater'    =>  $userDSetailsKraken[0]['balanceAre1000_Greater'],
            'balanceAre2500_Greater'    =>  $userDSetailsKraken[0]['balanceAre2500_Greater'],
            'loginCount'                =>  $userDSetailsKraken[0]['loginCount'],
        ]; // Kraken array
        $upsertedArray_bam = [
            'created_date'              =>  $this->mongo_db->converToMongodttime(date('Y-m-d 07:59')),
            'Total_users'               =>  $get_bamRes[0]['Total'],
            'Active_users'              =>  $get_bamRes[0]['active'],
            'Unactive_users'            =>  $get_bamRes[0]['unactive'],
            'Test_users'                =>  $get_bamRes[0]['test'],
            'exchange'                  =>  'bam',
            'month'                     =>  date('Y-m-d'),
            'lthBalance50_grater_per'   =>  $userDSetailsBam[0]['lthBalance50_grater_per'],
            'lthBalance30_grater_per'   =>  $userDSetailsBinance[0]['lthBalance30_grater_per'],
            'lthBalance70_grater_per'   =>  $userDSetailsBinance[0]['lthBalance70_grater_per'],
            'lthBalance100_grater_per'  =>  $userDSetailsBinance[0]['lthBalance100_grater_per'],
            'blockUsers'                =>  $userDSetailsBam[0]['blockUsers'],
            'balanceAre500_Greater'     =>  $userDSetailsBam[0]['balanceAre500_Greater'],
            'balanceAre1000_Greater'    =>  $userDSetailsBam[0]['balanceAre1000_Greater'],
            'balanceAre2500_Greater'    =>  $userDSetailsBam[0]['balanceAre2500_Greater'],
            'loginCount'                =>  $userDSetailsBam[0]['loginCount'],
        
        ]; // Bam array

        $upsertedWhere['exchange']          =  'binance';
        $upsertedWhere['month']             =  date('Y-m-d');

        $upsertedWhereKraken['exchange']    =  'kraken';
        $upsertedWhereKraken['month']       =  date('Y-m-d');

        $upsertedWhereBam['exchange']       =  'bam';
        $upsertedWhereBam['month']          =  date('Y-m-d');

        $db->user_analysis_chart_data->updateOne($upsertedWhere,       ['$set' => $upsertedArray_binance],  ['upsert' => true]);
        $upd = $db->user_analysis_chart_data->updateOne($upsertedWhereKraken, ['$set' => $upsertedArray_kraken],   ['upsert' => true]);

        echo "<br>update: ".$upd->getModifiedCount();
        echo "<br>upserted: ".$upd->getUpsertedCount();
        $db->user_analysis_chart_data->updateOne($upsertedWhereBam,    ['$set' => $upsertedArray_bam],      ['upsert' => true]);
        
        echo "<br>Successfully update";
    }
    
    //////////////////////////////
    //////////Cron for Chart ////
    //////////////////////////////

    // /fee_analysis
    public function fee_analysis(){

        $this->mod_login->verify_is_admin_login();
     
        $startDate = date('Y-m-d' , strtotime('-30 days'));
        $startMongoTime = $this->mongo_db->converToMongodttime($startDate);
        $endDate = date('Y-m-d');
        $endMongoTime = $this->mongo_db->converToMongodttime($endDate);
        $db = $this->mongo_db->customQuery();
        $search = [
            [

                '$match' => [
                    'created_date'  =>  ['$gte' => $startMongoTime, '$lte' => $endMongoTime],
                    'exchange'      => 'binance'
                ]
            ],
        ];
        $cursor_binance = $db->daily_investment_chart_data->aggregate($search);
        $binance_result = iterator_to_array($cursor_binance);  

        $data = array();
        $binance_result[0]['buy_commision']             = 0;
        $binance_result[0]['numberOfOpportunities']     = 0;
        $binance_result[0]['sell_fee_respected_coin']   = 0;
        $binance_result[0]['totalInvestInbtc']          = 0;
        $binance_result[0]['totaolInvestInUSDT']        = 0;
        $binance_result[0]['totaolInvestInbtc']         = 0;
        $binance_result[0]['sell_commission']           = 0;
        $binance_result[0]['totalBuyTradeCount']        = 0;
        $binance_result[0]['totalBuyUsdt']              = 0;
        $binance_result[0]['totalSoldBtc']              = 0;
        $binance_result[0]['totalSoldTradeCount']       = 0;
        $binance_result[0]['totalSoldUsdt']             = 0;
        $binance_result[0]['expected_btc_count']        = 0;
        $binance_result[0]['expected_usdt_count']       = 0;
        $binance_result[0]['total_invest']              = 0;
        $binance_result[0]['sell_btc_in_$']             = 0;     
        $binance_result[0]['sell_usdt']                 = 0;
        $binance_result[0]['total_sell_in_usdt']        = 0;

        $data['binance_result'] = $binance_result;
        $searchKraken = [
            [
                
                '$match' => [
                    'created_date'  =>  ['$gte' => $startMongoTime, '$lte' => $endMongoTime],
                    'exchange'      => 'kraken'
                ]
            ],
        ];      
        $cursor_kraken = $db->daily_investment_chart_data->aggregate($searchKraken);
        $kraken_result=iterator_to_array($cursor_kraken);

        $kraken_result[0]['buy_commision_qty']         = 0;
        $kraken_result[0]['numberOfOpportunities']     = 0;
        $kraken_result[0]['sell_fee_respected_coin']   = 0;
        $kraken_result[0]['totalInvestInbtc']          = 0;
        $kraken_result[0]['totaolInvestInUSDT']        = 0;
        $kraken_result[0]['totaolInvestInbtc']         = 0;
        $kraken_result[0]['totalBuyTradeCount']        = 0;
        $kraken_result[0]['totalBuyUsdt']              = 0;
        $kraken_result[0]['totalSoldBtc']              = 0;
        $kraken_result[0]['totalSoldTradeCount']       = 0;
        $kraken_result[0]['totalSoldUsdt']             = 0;
        $kraken_result[0]['expected_btc_count']        = 0;
        $kraken_result[0]['expected_usdt_count']       = 0;
        $kraken_result[0]['total_invest']              = 0;
        $kraken_result[0]['sell_commission']           = 0;
        $kraken_result[0]['sell_btc_in_$']             = 0;     
        $kraken_result[0]['sell_usdt']                 = 0;
        $kraken_result[0]['total_sell_in_usdt']        = 0;

        // 'totalBuyBtc'               =>  (float)($resultResponseCount[0]['totalBuyBtc']),

        $data['kraken_result'] = $kraken_result;
                
        $searchBam = [
            [
                '$match' => [
                    'created_date'  =>  ['$gte' => $startMongoTime, '$lte' => $endMongoTime],
                    'exchange'      => 'bam'
                ]
            ],
        ];
        $cursor_bam = $db->daily_investment_chart_data->aggregate($searchBam);
        $bam_result=iterator_to_array($cursor_bam);

        $bam_result[0]['buy_commision']             = 0;
        $bam_result[0]['buy_commision_qty']         = 0;
        $bam_result[0]['numberOfOpportunities']     = 0;
        $bam_result[0]['sell_fee_respected_coin']   = 0;
        $bam_result[0]['totalInvestInbtc']          = 0;
        $bam_result[0]['totaolInvestInUSDT']        = 0;
        $bam_result[0]['totaolInvestInbtc']         = 0;
        $bam_result[0]['sell_commission']           = 0;
        $bam_result[0]['totalBuyTradeCount']        = 0;
        $bam_result[0]['totalBuyUsdt']              = 0;
        $bam_result[0]['totalSoldBtc']              = 0;
        $bam_result[0]['totalSoldTradeCount']       = 0;
        $bam_result[0]['totalSoldUsdt']             = 0;
        $bam_result[0]['expected_btc_count']        = 0;
        $bam_result[0]['expected_usdt_count']       = 0;
        $bam_result[0]['sell_btc_in_$']             = 0;     
        $bam_result[0]['sell_usdt']                 = 0;
        $bam_result[0]['total_sell_in_usdt']        = 0;

        $data['bam_result'] = $bam_result;
        $binance_search = [
            [

                '$match' => [
                    'created_date'  =>  ['$gte' => $startMongoTime, '$lte' => $endMongoTime],
                    'exchange'      => 'binance'
                ]
            ],
        ];
        $cursor_user_binance = $db->user_analysis_chart_data->aggregate($binance_search);
        $binance_users_results = iterator_to_array($cursor_user_binance);
        $kraken_search = [
            [

                '$match' => [
                    'created_date'  =>  ['$gte' => $startMongoTime, '$lte' => $endMongoTime],
                    'exchange'      => 'kraken'
                ]
            ],
        ];
        $cursor_user_kraken = $db->user_analysis_chart_data->aggregate($kraken_search);
        $kraken_users_results = iterator_to_array($cursor_user_kraken);

        // echo "<pre>";print_r($kraken_users_results);
        $bam_search = [
            [

                '$match' => [
                    'created_date'  =>  ['$gte' => $startMongoTime, '$lte' => $endMongoTime],
                    'exchange'      => 'bam'
                ]
            ],
        ];
        $cursor_user_bam = $db->user_analysis_chart_data->aggregate($bam_search);
        $bam_users_results = iterator_to_array($cursor_user_bam);

        $binance_users_results[0]['Active_users']              = 0;
        $binance_users_results[0]['Test_users']                = 0;
        $binance_users_results[0]['Total_users']               = 0;
        $binance_users_results[0]['Unactive_users']            = 0;
        $binance_users_results[0]['lthBalance50_grater_per']   = 0;
        $binance_users_results[0]['blockUsers']                = 0;
        $binance_users_results[0]['balanceAre500_Greater']     = 0;
        $binance_users_results[0]['balanceAre1000_Greater']    = 0;
        $binance_users_results[0]['balanceAre2500_Greater']    = 0;
        $binance_users_results[0]['loginCount']                = 0;
        $$binance_users_results[0]['lthBalance30_grater_per']  = 0;
        $binance_users_results[0]['lthBalance70_grater_per']   = 0;
        $binance_users_results[0]['lthBalance100_grater_per']  = 0;

        $kraken_users_results[0]['Active_users']              = 0;
        $kraken_users_results[0]['Test_users']                = 0;
        $kraken_users_results[0]['Total_users']               = 0;
        $kraken_users_results[0]['Unactive_users']            = 0;
        $kraken_users_results[0]['lthBalance50_grater_per']   = 0;
        $kraken_users_results[0]['blockUsers']                = 0;
        $kraken_users_results[0]['balanceAre500_Greater']     = 0;
        $kraken_users_results[0]['balanceAre1000_Greater']    = 0;
        $kraken_users_results[0]['balanceAre2500_Greater']    = 0;
        $kraken_users_results[0]['loginCount']                = 0;
        $$kraken_users_results[0]['lthBalance30_grater_per']  = 0;
        $kraken_users_results[0]['lthBalance70_grater_per']   = 0;
        $kraken_users_results[0]['lthBalance100_grater_per']  = 0;

        $bam_users_results[0]['Active_users']              = 0;
        $bam_users_results[0]['Test_users']                = 0;
        $bam_users_results[0]['Total_users']               = 0;
        $bam_users_results[0]['Unactive_users']            = 0;
        $bam_users_results[0]['lthBalance50_grater_per']   = 0;
        $bam_users_results[0]['blockUsers']                = 0;
        $bam_users_results[0]['balanceAre500_Greater']     = 0;
        $bam_users_results[0]['balanceAre1000_Greater']    = 0;
        $bam_users_results[0]['balanceAre2500_Greater']    = 0;
        $bam_users_results[0]['loginCount']                = 0;
        $$bam_users_results[0]['lthBalance30_grater_per']  = 0;
        $bam_users_results[0]['lthBalance70_grater_per']   = 0;
        $bam_users_results[0]['lthBalance100_grater_per']  = 0;

        $data['binance_users_results'] = $binance_users_results;
        $data['kraken_users_results']  = $kraken_users_results;
        $data['bam_users_results']     = $bam_users_results;
        // echo "<pre>";print_r($data);
    
        $this->stencil->paint('admin/monthly_trading_volume/fee_investegation', $data); 
    }//fee_analysis

    //get_count_users_records_chart 
    public function get_count_users_records_chart(){
        
        $collection_name_Binance    = 'user_investment_binance';
        $collection_name_kraken     = 'user_investment_kraken';
        $collection_name_Bam        = 'user_investment_bam';



        $db= $this->mongo_db->customQuery();
        $lookup = [
            [
                '$group' => [
                    '_id' => null,
                    'Total' => ['$sum' => 1],
                    
                    'active' => [
                        '$sum' => [
                        '$cond' => [
                            'if' => ['$eq' => ['$exchange_enabled', 'yes']],
                            'then' => 1,
                            'else' => 0
                            ]
                        ]
                    ],
                    
                    
                    'unactive' => [
                        '$sum' => [
                        '$cond' => [
                            'if' => ['$eq' => ['$exchange_enabled', 'no']],
                            'then' => 1,
                            'else' => 0
                            ]
                        ]
                    ],
                    
                    'test' => [
                        '$sum' => [
                            '$cond' => [
                            'if' => ['$in' => ['$exchange_enabled', ['yes', 'no']]],
                            'then' => 0,
                            'else' => 1
                            ]
                        ]
                    ],
                ]
            ],
        ];
        $get_binance    =    $db->$collection_name_Binance->aggregate($lookup);
        $get_binanceRes =    iterator_to_array($get_binance);

        $get_kraken     =    $db->$collection_name_kraken->aggregate($lookup);
        $get_krakenRes  =     iterator_to_array($get_kraken);

        $get_bam        =    $db->$collection_name_Bam->aggregate($lookup);
        $get_bamRes     =    iterator_to_array($get_bam);

        echo "<pre>";
        print_r($get_binanceRes).'next';
        print_r($get_krakenRes).'next';
        print_r($get_bamRes).'next';


    } //get_count_users_records_chart
}