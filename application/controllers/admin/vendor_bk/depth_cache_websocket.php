<?php

if(isset($_GET['coin_symbol']) && $_GET['coin_symbol'] !=""){


    require 'mongo_db/autoload.php'; // include Composer's autoloader


    $connect = new MongoDB\Client("mongodb://localhost:27017");
    $database = 'binance';
    $db = $connect->$database;

    $created_date = date('Y-m-d G:i:s');
    $insert = array(
                'symbol_name'=>'LTCBTC',
                'created_date'=>$created_date 
              );

     //$result = $db->socket_calls->insertOne($insert);



  $findArr = array('symbol_name'=>'LTCBTCff');

     $response = $db->socket_calls->find($findArr);
     foreach ($response as $key ) {
          echo '<pre>';
          echo  $key->_id;

          echo $key->symbol_name;
     print_r($key);
     }

     
     exit;



	
    require 'vendor/autoload.php';

    $api = new Binance\API("judcT6QzgCRBgZKoRECSzbIbKhjrBlSiKdXMkBzZeaODsPTzzp5xCFZ9HqYben07", "AUfFynZPaYyddWpm8g4x1twpzfT5JTai3nJCA45gSkFrnf4Jpwx6Txzvbwc6Bg5G", ['useServerTime'=>true]);

    $coin_symbol = $_GET['coin_symbol'];
    
    // Grab realtime updated depth cache via WebSockets
    // $api->depthCache([ $coin_symbol], function($api, $symbol, $depth) {
    //     echo "{$symbol} depth cache update <br>";
    //     $limit = 11; // Show only the closest asks/bids
    //     $sorted = $api->sortDepth($symbol, $limit);
    //     $bid = $api->first($sorted['bids']);
    //     $ask = $api->first($sorted['asks']);
    //     echo $api->displayDepth($sorted)."<br>";
    //     echo "ask: {$ask} <br>";
    //     echo "bid: {$bid} <br>";
    // });
    

}else{	

?>

<link href="style.css" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<body class="hm-gradient">
    
    <body class="hm-gradient">
    
    <main>
        
        <!--MDB Forms-->
        <div class="container mt-4">

           
            <!-- Grid row -->
            <div class="row">
               
                <!-- Grid column -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                        <!-- Form register -->
                        <form action="" method="get">
                            <h3 class="text-center pink-text font-bold py-4"><strong>Enter Symbol</strong></h3>

                            <div class="md-form">
                                <i class="fa fa-bitcoin prefix grey-text"></i>
                                <input type="text" name="coin_symbol" id="orangeForm-name37" class="form-control">
                                <label for="orangeForm-name37">Enter Symbol i.e BNBBTC</label>
                            </div>
                          
                            <div class="text-center py-4">
                                <button type="submit" class="btn btn-outline-pink">Submit 
                               	<i class="fa fa-paper-plane-o ml-1"></i></button>
                            </div>
                        </form>
                        <!-- Form register -->
                        </div>
                    </div>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->

        </div>
        <!--MDB Forms-->
      
    </main>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/js/mdb.min.js"></script>
   
</body>

<?php } ?>