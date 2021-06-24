            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" />
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
            <link href="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.css" rel="stylesheet">
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <script src="<?php echo ASSETS ?>buyer_order/moment-with-locales.js"></script>
            <script src="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.js"></script>
            <script type="text/javascript" src="<?php  echo SURL ?>assets/dist/jquery-asPieProgress.js"></script>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
            
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
            
            <style>
                .Input_text_s {
                    float: left;
                    width: 100%;
                    position: relative;
                }
                .Input_text_s > label {
                    float: left;
                    width: 100%;
                    color: #000;
                    font-size: 14px;
                }
                .multiselect-native-select .btn-group {
                    float: left;
                    width: 100% !important;
                }
                .multiselect-native-select .btn-group button {
                    background: #fff;
                    border: 1px solid #ccc;
                    border-radius: 5px !important;
                }
                .Input_text_s > i {
                    position: absolute;
                    right: 8px;
                    bottom: 4px !important;
                    height: 20px;
                    top: auto;
                }
                .ax_2, .ax_3, .ax_4, .ax_5 {
                    padding-bottom: 35px !important;
                }
                .col-radio {
                    float: left;
                    width: 100%;
                    position: relative;
                    padding-left: 30px;
                    height: 30px;
                }
                .col-radio span {
                    position: absolute;
                    left: 0;
                    width: 30px;
                    height: 30px;
                    top: 0;
                    font-size: 23px;
                    line-height: 0;
                }
                .col-radio input[type="radio"] {
                    position: absolute;
                    left: 0;
                    opacity: 0;
                }
                .col-radio input[type="radio"]:checked + span i.fa.fa-dot-circle-o {
                    display: block;
                    color: #72af46;
                }
                .col-radio input[type="radio"]:checked + span i.fa.fa-circle-o {
                    display: none;
                }
                .col-radio span i.fa.fa-dot-circle-o {
                display: none;
                }
                .col-radio label {
                    color: #000;
                    font-size: 15px;
                    padding-top: 1px;
                }
                .Input_text_btn > a > i, .Input_text_btn > button > i {
                    margin-right: 10px;
                }
                .coin_symbol {
                }
                .coin_symbol {
                    color: #fff;
                    font-weight: bold;
                    font-size: 14px;
                    float: left;
                    width: 100%;
                    padding: 12px 20px;
                    background: #31708f;
                    border-radius: 7px 7px 0 0;
                    margin-top: 25px;
                }
                .coin_symbol:first-child {
                    margin-top: 0;
                }
                table.table.table-stripped {
                    border: 1px solid #2d4c5a;
                }
                table.table.table-stripped tr.theadd {
                    background: #ccc;
                    color: #000;
                }
                table.table.table-stripped tr.theadd td {
                    border: 1px solid #2d4c5a;
                    font-weight: bold;
                    font-size: 13px;
                }
                table.table.table-stripped tr td {
                    border: 1px solid #2d4c5a;
                    vertical-align: middle;
                }
                table.table.table-stripped tr td.heading {
                    background: #ccc;
                    color: #000;
                    font-size: 13px;
                    font-weight: bold;
                }
                table.table.table-stripped tr:hover {
                    background: rgba(0,0,0,0.04);
                }
                table.table.table-stripped tr.theadd:hover {
                    background: rgba(204,204,204,1);
                }
                tr.coin_symbol td {
                    border: none !important;
                }
                table.table.table-stripped tr td .table-stripped-column tr td {
                    border: none;
                    padding-bottom: 0;
                    padding-top: 15px;
                    background: #ccc;
                    color: black;
                }
                .modal-dialog {
                    overflow-y: initial !important
                }
                .Opp {
                    height: 550px;
                    padding-left: 10px;
                    overflow-y: auto;
                    overflow-x: hidden;
                }
                .totalAvg {
                    padding-top: 44px;
                }
                .Input_text_btn {
                    padding: 25px 0 0;
                }
          
                /* New CSS Classes for Labels and Boxes */
                .label-box-pending{
                    display:inline-block;
                    width: 22px;
                    float:left;
                    height: 22px;
                    border-radius: 0.7rem;
                    background: #f0ad4e;
                }
                .label-box-approved{
                    display:inline-block;
                    width: 22px;
                    float:left;
                    height: 22px;
                    border-radius: 0.7rem;
                    background: #c3e6cb;
                }
                .label-box-rejected{
                    display:inline-block;
                    width: 22px;
                    float:left;
                    height: 22px;
                    border-radius: 0.7rem;
                    background: #d9534f;
                }
                .label-box-requested{
                    display:inline-block;
                    width: 22px;
                    float:left;
                    height: 22px;
                    border-radius: 0.7rem;
                    background: #5bc0de;
                }
                .status-box-pending{
                    color: white !important;
                    text-align:center;
                    background-color:#f0ad4e;
                }
                .status-box-approved{
                    color: white !important;
                    text-align:center;
                    background-color:#72af46;
                }
                .status-box-rejected{
                    color: white !important;
                    text-align:center;
                    background-color:#d9534f;
                }
                .status-box-requested{
                    color: white !important;
                    text-align:center;
                    background-color:#5bc0de;
                }
                .table_align_head{
                    text-align: left !important;
                }
                .badge {
                    background-color: black!important;
                }
            </style>



                <div id="content">
                    <div class="innerAll bg-white border-bottom">
                        <div class="pull-right" style="padding-right: 12px; padding-top: 8px; margin-left:89px;">
                            <div class=" pull-right alert alert-warning" style=" margin-top: -10px; background: #5c678a;color: white;"> <?php echo date("F j, Y, g:i a").'&nbsp;&nbsp;  <b>'.date_default_timezone_get().' (GMT + 0)'.'<b />' ?></div>
                        </div>
                    </div>
                    <div class="innerAll spacing-x2" style="margin-left:6px">
                       
                        <div class="widget widget-inverse">
                            <div class="widget-body">



                                <!-- Widget -->
                                <style>
                                    /* STYLES FOR PROGRESSBARS */
                                    .progress-radial, .progress-radial * {
                                        -webkit-box-sizing: content-box;
                                        -moz-box-sizing: content-box;
                                        box-sizing: content-box;
                                    }
                                    /* -------------------------------------
                                    * Bar container
                                    * ------------------------------------- */
                                    .progress-radial {
                                        float: left;
                                        margin-right: 4%;
                                        position: relative;
                                        width: 55px;
                                        border-radius: 50%;
                                    }
                                    .progress-radial:first-child {
                                        margin-left: 4%;
                                    }
                                    /* -------------------------------------
                                    * Optional centered circle w/text
                                    * ------------------------------------- */
                                    .progress-radial .overlay {
                                        position: absolute;
                                        width: 80%;
                                        background-color: #f0f0f0;
                                        border-radius: 50%;
                                        font-size: 14px;
                                        top:50%;
                                        left:50%;
                                        -webkit-transform: translate(-50%, -50%);
                                        -ms-transform: translate(-50%, -50%);
                                        transform: translate(-50%, -50%);
                                    }
                                    .progress-radial .overlay p{
                                        position: absolute;
                                        line-height: 40px;
                                        text-align: center;
                                        width: 100%;
                                        top:50%;
                                        margin-top: -20px;
                                    }
                                    .mypai_prog {
                                        display: inline-block;
                                        padding: 2px;
                                    }
                                    .tdmypi{
                                        padding:2px;
                                        text-align:center;
                                    }

                                    div.pie_progress__label {
                                        position: absolute;
                                        top: 20px;
                                        left: 8px;
                                    }
                                    .pie_progress {
                                        position: relative;
                                        width: 60px;
                                        text-align: center;
                                        margin-left: 39px;
                                    }
                                    .circle{
                                        position: relative;
                                    }
                                    .circle strong {
                                        position: absolute;
                                        top: 50%;
                                        left: 28px;
                                        z-index: 2222;
                                        transform: translate(-50%, -50%);
                                        font-size: 15px;
                                        color: black;
                                    }


                                    .account-settings .user-profile .user-avatar img {
                                        width: 90px;
                                        height: 90px;
                                        -webkit-border-radius: 100px;
                                        -moz-border-radius: 100px;
                                        border-radius: 100px;
                                    }

                                </style>
                                <script>

                                    $(".setsize").each(function() {
                                        $(this).height($(this).width());
                                    });
                                    $(window).on('resize', function(){
                                    $(".setsize").each(function() {
                                        $(this).height($(this).width());
                                    });
                                    });
                                </script> 
                    
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12" >
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="account-settings">
                                                <div class="user-profile">
                                                    <div class="user-avatar">  
                                                        <img src="https://app.digiebot.com/assets/profile_images/<?php echo $userData[0]['profile_pic']; ?>" alt="Maxwell Admin">
                                                    </div>
                                                    <h5 class="user-email"><?php echo $userData[0]['first_name'].' '.$userData[0]['last_name']; ?></h5>  
                                                    <h6 class="user-name"><?php echo $userData[0]['username']; ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-left:10%">
                                <div class="card h-100">
                                    <div>
                                        <div class="row gutters"> 
                                        
                                            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">

                                                    <div class="form-group">
                                                            
                                                        <label for="">Sold Per Trade</label>
                                                    </div>
                                                    <div>
                                                       <table> 
                                                            <tr>
                                                                <td>
                                                                    <?php $perTrade = number_format($per_trade_avg, 2); 
                                                                    if($perTrade >= 0 ){ ?>
                                                                    <span title="Per Trade" >
                                                                        <div class="circle" id="circle-a" data-value="<?php echo $perTrade/4;?>" data-fill="{
                                                                        &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">      
                                                                        <strong><?php echo number_format($perTrade, 2);?>%</strong>
                                                                        </div> 
                                                                    </span>
                                                                    <?php } elseif($perTrade < 0){ ?>
                                                                        <span title="Per Trade" >
                                                                        <div class="circle" id="circle-a" data-value="<?php echo $perTrade/-4;?>" data-fill="{
                                                                            &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                                                                            <strong><?php echo number_format($perTrade, 2);?>%</strong>   
                                                                        </div>
                                                                        </span>
                                                                    <?php } ?> </span>
        

                                                                </td>
                                                            </tr>
                                                        </table>
                                                    
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="">Sold Avg</label> 
                                                    <div>
                                                       <table> 
                                                            <tr>
                                                                <td>
                                                                    <?php $avg_sold = number_format($avg_sold, 2); 
                                                                    if($avg_sold >= 0 ){ ?>
                                                                    <span title="Per Trade" >
                                                                        <div class="circle" id="circle-a" data-value="<?php echo $avg_sold/4;?>" data-fill="{
                                                                        &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">      
                                                                        <strong><?php echo number_format($avg_sold, 2);?>%</strong>
                                                                        </div> 
                                                                    </span>
                                                                    <?php } elseif($avg_sold < 0){ ?>
                                                                        <span title="Per Trade" >
                                                                        <div class="circle" id="circle-a" data-value="<?php echo $avg_sold/-4;?>" data-fill="{
                                                                            &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                                                                            <strong><?php echo number_format($avg_sold, 2);?>%</strong>   
                                                                        </div>
                                                                        </span>
                                                                    <?php } ?> </span>
        

                                                                </td>
                                                            </tr>
                                                        </table>
                                                    
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="">Last 30 Days Profit</label>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <?php 
                                                                if(isset($userData[0]['avg_sold'])){
                                                                    $avg_sold = number_format($userData[0]['avg_sold'], 2);
                                                                    if($avg_sold < 0 ){ ?>
                                                                    <div class="circle" id="circle-a" data-value="<?php echo $avg_sold/-4;?>" data-fill="{
                                                                    &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                                                                    <strong><?php echo number_format($avg_sold, 2);?>%</strong>
                                                                    </div>
                                                                    <?php } elseif($avg_sold >= 0 && $avg_sold < 1 ){ ?>
                                                                    <div class="circle" id="circle-a" data-value="<?php echo $avg_sold/4;?>" data-fill="{
                                                                        &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">      
                                                                        <strong><?php echo number_format($avg_sold, 2);?>%</strong>
                                                                    </div> 
                                                                    <?php } elseif($avg_sold >=1 && $avg_sold < 1.2) { ?>
                                                                    <div class="circle" id="circle-a" data-value="<?php echo $avg_sold/4;?>" data-fill="{
                                                                        &quot;color&quot;: &quot;rgba(245, 207, 67) &quot;}">      
                                                                        <strong><?php echo number_format($avg_sold, 2);?>%</strong>
                                                                    </div>
                                                                    <?php } elseif($avg_sold >=1.2 && $avg_sold < 1.6) { ?>
                                                                    <div class="circle" id="circle-a" data-value="<?php echo $avg_sold/4;?>" data-fill="{
                                                                        &quot;color&quot;: &quot;rgba(177, 185, 2) &quot;}">      
                                                                        <strong><?php echo number_format($avg_sold, 2);?>%</strong>
                                                                    </div>
                                                                    <?php } elseif($avg_sold >=1.2 && $avg_sold < 1.6) { ?>
                                                                    <div class="circle" id="circle-a" data-value="<?php echo $avg_sold/4;?>" data-fill="{
                                                                        &quot;color&quot;: &quot;rgba(122, 200, 123) &quot;}">      
                                                                        <strong><?php echo number_format($avg_sold, 2);?>%</strong>
                                                                    </div>
                                                                    <?php } elseif($avg_sold >= 1.6){ ?>
                                                                    <div class="circle" id="circle-a" data-value="<?php echo $avg_sold/4;?>" data-fill="{
                                                                        &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">      
                                                                        <strong><?php echo number_format($avg_sold, 2);?>%</strong>
                                                                    </div>
                                                                    <?php } 
                                                                } ?>
                                                            
                                                            </td>
                                                            
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="">Last Month Invest</label>
                                                    <div>
                                                    
                                                        <table> 
                                                            <tr>
                                                                <td>
                                                                    
                                                                    <?php    //last 30 days invest %

                                                                    $btcPkg  = 0;
                                                                    $usdtPkg = 0;
                                                                    if($userData[0]['customBtcPackage'] > 0 ){
                                                                    $btcPkg  = ($userData[0]['customBtcPackage']   >= $userData[0]['avaliableBtcBalance'])   ?  $userData[0]['avaliableBtcBalance']  : $userData[0]['customBtcPackage']  ;
                                                                    }
                                                                    if($userData[0]['customUsdtPackage'] > 0){
                                                                    $usdtPkg = ($userData[0]['customUsdtPackage']  >= $userData[0]['avaliableUsdtBalance'])  ?  $userData[0]['avaliableUsdtBalance'] : $userData[0]['customUsdtPackage'] ;
                                                                    }

                                                                    if($userData[0]['customBtcPackage'] > 0 && $userData[0]['invest_amount'] > 0 ){ 
                                                                        // customBtcPackage
                                                                        $customBtcPackageDollar = 0;  
                                                                        if($btcPkg > 0){           
                                                                        $customBtcPackageDollar = convert_btc_to_usdt($btcPkg); //helper function for btc to usdt amount    245, 207, 67//yellow  237, 7, 49//red  31, 183, 79//green
                                                                        }
                                                                        $investPercentage =  (($userData[0]['invest_amount'] / ($usdtPkg + $customBtcPackageDollar ))*100);    
                                                                       
                                                                    }else{
                                                                        $investPercentage = 0;
                                                                        $customBtcPackageDollar = 0;
                                                                    }
                                                                    if($investPercentage >= 0 && $investPercentage <= 70){ ?>
                                                                        <div class="circle" id="circle-a" data-value="<?php echo $investPercentage/200;?>" data-fill="{
                                                                        &quot;color&quot;: &quot;rgba(245, 207, 67) &quot;}">       
                                                                        <strong><?php echo number_format($investPercentage, 2);?>%</strong>
                                                                        </div> 
                                                                    <?php } elseif($investPercentage > 70 && $investPercentage < 130) { ?>
                                                                        <div class="circle" id="circle-a" data-value="<?php echo $investPercentage/200;?>" data-fill="{
                                                                        &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">      
                                                                        <strong><?php echo number_format($investPercentage, 2);?>%</strong>
                                                                        </div> 
                                                                    <?php } elseif($investPercentage >= 130){ ?> 
                                                                        <div class="circle" id="circle-a" data-value="<?php echo $investPercentage/200;?>" data-fill="{
                                                                        &quot;color&quot;: &quot;rgba(237, 7, 49 &quot;}">       
                                                                        <strong><?php echo number_format($investPercentage, 2);?>%</strong>
                                                                        </div> 
                                                                    <?php } ?>

                                                                </td>
                                                            </tr>
                                                        </table>
                                                    
                                                    </div>
                                                    
                                                </div>
                                            </div>


                                            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="">Last Month Invest Manual</label>
                                                    <div>
                                                                  
                                                        <table> 
                                                            <tr>
                                                                <td title = "<?php echo "Manul order btc Invest Last Month: ".$userData[0]['manulOrderBtcInvest']."\r\n Manul order Usdt Invest Last Month: ".$userData[0]['manulOrderUsdtInvest']; ?>">
                                                                    
                                                                    <?php    //last 30 days invest % manul

                                                                    $btcPkg  = 0;
                                                                    $usdtPkg = 0;
                                                                    if($userData[0]['customBtcPackage'] > 0 ){
                                                                    $btcPkg  = ($userData[0]['customBtcPackage']   >= $userData[0]['avaliableBtcBalance'])   ?  $userData[0]['avaliableBtcBalance']  : $userData[0]['customBtcPackage']  ;
                                                                    }
                                                                    if($userData[0]['customUsdtPackage'] > 0){
                                                                    $usdtPkg = ($userData[0]['customUsdtPackage']  >= $userData[0]['avaliableUsdtBalance'])  ?  $userData[0]['avaliableUsdtBalance'] : $userData[0]['customUsdtPackage'] ;
                                                                    }

                                                                    if($userData[0]['customBtcPackage'] > 0 && $userData[0]['manulInvestemntTotal'] > 0 ){ 
                                                                        // customBtcPackage
                                                                        $customBtcPackageDollar = 0;  
                                                                        if($btcPkg > 0){           
                                                                        $customBtcPackageDollar = convert_btc_to_usdt($btcPkg); //helper function for btc to usdt amount    245, 207, 67//yellow  237, 7, 49//red  31, 183, 79//green
                                                                        }
                                                                        $investPercentage =  (($userData[0]['manulInvestemntTotal'] / ($usdtPkg + $customBtcPackageDollar ))*100);    
                                                                       
                                                                    }else{
                                                                        $investPercentage = 0;
                                                                        $customBtcPackageDollar = 0;
                                                                    }
                                                                    if($investPercentage >= 0 && $investPercentage <= 70){ ?>
                                                                        <div class="circle" id="circle-a" data-value="<?php echo $investPercentage/200;?>" data-fill="{
                                                                        &quot;color&quot;: &quot;rgba(245, 207, 67) &quot;}">       
                                                                        <strong><?php echo number_format($investPercentage, 2);?>%</strong>
                                                                        </div> 
                                                                    <?php } elseif($investPercentage > 70 && $investPercentage < 130) { ?>
                                                                        <div class="circle" id="circle-a" data-value="<?php echo $investPercentage/200;?>" data-fill="{
                                                                        &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">      
                                                                        <strong><?php echo number_format($investPercentage, 2);?>%</strong>
                                                                        </div> 
                                                                    <?php } elseif($investPercentage >= 130){ ?> 
                                                                        <div class="circle" id="circle-a" data-value="<?php echo $investPercentage/200;?>" data-fill="{
                                                                        &quot;color&quot;: &quot;rgba(237, 7, 49 &quot;}">       
                                                                        <strong><?php echo number_format($investPercentage, 2);?>%</strong>
                                                                        </div> 
                                                                    <?php } ?>

                                                                </td>
                                                            </tr>
                                                        </table>
                                                    
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Account Health -->
                            <div class="container" style="margin-left:10%; margin-top:5%">
                                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                    <div class="card h-100">
                                        <div class="">
                                            <div class="row gutters"> 
                                            
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group text-center">

                                                        <div class="form-group">
                                                            
                                                            <label for="fullName">Account Health</label>
                                                        </div>
                                                        
                                                        <?php
                                                        $ratio = 100 / 17;
                                                        $issueAccount = 0;
                                                        
                                                        $currency_btc  = '';
                                                        $currency_usdt = '';

                                                        if($userData[0]['baseCurrencyArr'][0] == 'BTC' && !empty($userData[0]['baseCurrencyArr'][0]) ){

                                                            $currency_btc = 'BTC';
                                                        }elseif($userData[0]['baseCurrencyArr'][0] == 'USDT' && !empty($userData[0]['baseCurrencyArr'][0])){
                                                            
                                                            $currency_usdt = 'USDT';
                                                        }

                                                        
                                                        if($userData[0]['baseCurrencyArr'][1] == 'USDT'  && !empty($userData[0]['baseCurrencyArr'][1]) ){

                                                            $currency_usdt = 'USDT';

                                                        }elseif($userData[0]['baseCurrencyArr'][1] == 'BTC'  && !empty($userData[0]['baseCurrencyArr'][1])){

                                                            $currency_btc = 'BTC';
                                                        }


                                                        if($userData[0]['lessBalance'] < -50  &&  isset($userData[0]['lessBalance']) ){
                                                            
                                                            $issueAccount += $ratio;
                                                        }

                                                        if($userData[0]['extraBalance'] > 50 && isset($userData[0]['extraBalance']) ){

                                                            $issueAccount += $ratio;
                                                        }

                                                        if($userData[0]['avaliableUsdtBalance'] > 10 && empty($currency_usdt) ){// balance exists but under atg base currency not selected
                                                            
                                                            $issueAccount += $ratio;

                                                        }

                                                        if($userData[0]['avaliableBtcBalance'] > 0 && empty($currency_btc) ){// balance exists but under atg base currency not selected
                                                            
                                                            $issueAccount += $ratio;

                                                        }

                                                        if(count($errorTrades) > 0 ){ //error trade if exists
                                                        
                                                            $issueAccount += $ratio;
                                                        
                                                        } 
                                                        if($userData[0]['tradingStatus'] == "off" && !empty($userData[0]['tradingStatus']) ){ 
                                                            $issueAccount += $ratio;

                                                        }
                                                        if($userData[0]['dailyTradeableUSDTLimit'] <= 5 ){ 

                                                            $issueAccount += $ratio;
                                                        
                                                        } 
                                                        if($userData[0]['dailyTradeableBTCLimit$'] <= 5 ){ 

                                                            $issueAccount += $ratio;
                                                        }
                                                        if($userData[0]['avaliableBtcBalance'] <= 0 ){ 
                                                            $issueAccount += $ratio;
                                                        }

                                                        if($userData[0]['avaliableUsdtBalance'] < 20 ){ 

                                                            $issueAccount += $ratio;     
                                                        }

                                                        if(!isset($userData[0]['exchange_enabled']) || $userData[0]['exchange_enabled'] == 'no'){

                                                            $issueAccount += $ratio;
                                                        } 
                                                        if(!empty($userData[0]['agt']) && $userData[0]['agt'] == 'no'){ 

                                                            $issueAccount += $ratio;
                                                        }
                                                        if(!empty($userData[0]['remainingPoints']) && $userData[0]['remainingPoints'] <= 0){ 

                                                            $issueAccount += $ratio;
                                                        }

                                                        if(!isset($userData[0]['profile_pic']) ){ 

                                                            $issueAccount += $ratio;
                                                        }

                                                        if(!isset($userData[0]['open_order']) || $userData[0]['open_order'] <= 0){   

                                                            $issueAccount += $ratio;
                                                        }

                                                        if(!isset($userData[0]['bnb_balance']) || $userData[0]['bnb_balance'] <= 0 && $userData[0]['exchange'] == 'binance'){
                                                            $issueAccount += $ratio;
                                                        }

                                                        if(!isset($userData[0]['newOrderParents']) || $userData[0]['newOrderParents'] <= 0 ){

                                                            $issueAccount +=$ratio;
                                                        }

                                                        $per = number_format((100 - $issueAccount),2);

                                                        if($per <= 50){?>
                                                            <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:90%">
                                                                <?php echo $per."%"; ?>
                                                            </div>
                                                        <?php } elseif($per > 50 && $per <= 70){ ?>
                                                            <div class="progress-bar progress-bar-striped active progress-bar-warning" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:90%">
                                                                <?php echo $per."%"; ?>
                                                            </div>
                                                        <?php }else{ ?>
                                                            <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:90%">
                                                                <?php echo $per."%"; ?>
                                                            </div>
                                                        <?php } ?>
                                                        
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Points Deduct -->
                            <div class="container" style="margin-left:10%; margin-top:2%">
                                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                    <div class="card h-100">
                                        <div class="">
                                            <div class="row gutters"> 
                                            
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group text-center">

                                                        <div class="form-group">
                                                            
                                                            <label for="fullName">Points Deduct</label>
                                                        </div>
                                                        
                                                        <?php
                                                            $total       =   $userData[0]['totalPointsApi'];
                                                            $consumed    =   $userData[0]['consumed_points'];
                                                            $remaning    =   $userData[0]['remainingPoints'];

                                                            $per = number_format((($consumed/$total)*100),2);

                                                        if($per <= 50){?>
                                                            <span title="<?php echo "Total:".$total."\r\nConsumed:".$consumed."\r\n Remining:".$remaning; ?>">
                                                                <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:90%">
                                                                    <?php echo $per."%"; ?>
                                                                </div>
                                                            </span>
                                                        <?php } elseif($per > 50 && $per <= 70){ ?>
                                                            <span title="<?php echo "Total:".$total."\r\nConsumed:".$consumed."\r\n Remining:".$remaning; ?>">
                                                                <div class="progress-bar progress-bar-striped active progress-bar-warning" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:90%">
                                                                    <?php echo $per."%"; ?>
                                                                </div>
                                                            </span>
                                                        <?php }else{ ?>
                                                            <span title="<?php echo "Total:".$total."\r\nConsumed:".$consumed."\r\n Remining:".$remaning; ?>">
                                                                <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:90%">
                                                                    <?php echo $per."%"; ?>
                                                                </div>
                                                            </span>
                                                        <?php } ?>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- suggestions For Account Health Improvements -->
                            <div class="container" style="margin-left:10%; margin-top:5%">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card h-100">
                                        <div class="">
                                            <div class="row gutters"> 
                                            
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    
                                                <div class="form-group">

                                                    <div class="form-group">
                                                        
                                                        <label for="">suggestions For Account Health Improvements</label>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <table class="table table-response">
                                                            <tr style= "font-weight:normal"> 
                                                                <td class="text-center">

                                                                    <?php

                                                                        if($userData[0]['lessBalance'] < -50  &&  isset($userData[0]['lessBalance']) ){
                                                                                                                                    
                                                                            echo "*. Fix Less Balace Issue <br><br>";
                                                                        }

                                                                        if($userData[0]['extraBalance'] > 50 && isset($userData[0]['extraBalance']) ){

                                                                            echo "*. Fix Extra Balace Issue <br><br>";
                                                                        }
                                                                        
                                                                        if($userData[0]['avaliableUsdtBalance'] > 10 && empty($currency_usdt) ){// balance exists but under atg base currency not selected
                                                                                                                                    
                                                                            echo "*. USDT Balance Exists but base currency not Selected <br><br>";

                                                                        } 
                                                                        if($userData[0]['avaliableBtcBalance'] > 0 && empty($currency_btc) ){// balance exists but under atg base currency not selected
                                                                            
                                                                            echo "*. BTC Balance Exists but base currency not Selected<br><br>";

                                                                        } 

                                                                        if($userData[0]['tradingStatus'] == "off" && !empty($userData[0]['tradingStatus']) ){ 
                                                                            
                                                                            echo "*. Trading Status is off<br><br>";

                                                                        }
                                                                        if($userData[0]['dailyTradeableUSDTLimit'] <= 5 ){ 
                                                                    
                                                                            echo "*. USDT Limit is less than $:5<br><br>";

                                                                        } 

                                                                        if($userData[0]['dailyTradeableBTCLimit$'] <= 5 ){ 
                                                                            echo "*. BTC Limit is less than $:5<br><br>";

                                                                        }
                                                                        if($userData[0]['avaliableBtcBalance'] <= 0 ){ 

                                                                            echo "*. BTC Balance less than 0<br><br>";

                                                                        }

                                                                        if($userData[0]['avaliableUsdtBalance'] < 20 ){ 

                                                                            echo "*. USDT Balance is less than $:20 <br><br>";

                                                                        }

                                                                        if(!isset($userData[0]['exchange_enabled']) || $userData[0]['exchange_enabled'] == 'no'){ 
                                                                            
                                                                            echo "*. API key Invalid<br><br>";

                                                                        } 
                                                                        if(!empty($userData[0]['agt']) && $userData[0]['agt'] == 'no'){
                                                                            
                                                                            echo "*. ATG Disable<br><br>";

                                                                        }  
                                                                        if(!empty($userData[0]['remainingPoints']) && $userData[0]['remainingPoints'] < 10){  
                                                                            
                                                                            echo "*. Remaining Points are less than 10<br><br>";

                                                                        }

                                                                        if(!isset($userData[0]['profile_pic']) ){ 
                                                                            echo "*. Profile Picture Not Set<br><br>";

                                                                        }
                                                                        
                                                                        if(!isset($userData[0]['open_order']) || $userData[0]['open_order'] <= 0){   

                                                                            echo "*. No Open Order Found<br><br>";

                                                                        } 

                                                                        if(!isset($userData[0]['bnb_balance']) || $userData[0]['bnb_balance'] <= 0 && $userData[0]['exchange'] == 'binance'){
                                                                            echo "*. BNB Not Exists<br><br>";

                                                                        }

                                                                        if(count($errorTrades) > 0 ){  
                                                                            echo "*. Some Trades are under Error<br><br>";

                                                                        } 

                                                                        if(!isset($userData[0]['newOrderParents']) || $userData[0]['newOrderParents'] <= 0 ){
                                                                            
                                                                            echo "*. Pick Parent yes 0 <br><br>";
                                                                        }
                                                                        if(isset($userData[0]['comments'])){
                                                                            echo "*.Profile Reviews<br>".$userData[0]['comments']."<br><br>";
                                                                        }

                                                                    ?> 
                                                                </td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                    
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <!-- Error Trades Id -->
                            <div class="" style="margin-left:10%">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:5%">
                                    <div class="card h-100">
                                        <div class="">
                                            <div class="row gutters"> 
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <div class="form-group">

                                                        <div class="form-group">
                                                            
                                                            <label class= "text-center" for="">Error Trades Id</label>
                                                        </div>

                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                            <table class="table table-response">
                                                                <tr class="text-center">
                                                                    <th class="text-center">id</th>
                                                                    <th class="text-center">purchased price</th>
                                                                    <th class="text-center">pl%</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                                <?php foreach($errorTrades as $trades){ ?>
                                                                    <tr style= "font-weight:normal">
                                                                        <td class="text-center"><?php echo $trades['_id']; ?></td>
                                                                        <td class="text-center"><?php echo $trades['purchased_price']; ?></td>
                                                                        <td class="text-center">
                                                                            <?php
                                                                                $res = plCalulate($trades['purchased_price'], '', $trades['symbol'], $exchange );

                                                                                if($res >= 0){
                                                                                    $class="success";
                                                                                }else{
                                                                                    $class="danger";
                                                                                }
                                                                                echo '<span class="text-' . $class . '"> <b> ' .number_format($res, 2). '%</b> </span>';
                                                                            ?>
                                                                        </td>
                                                                        <td><a href="https://trading.digiebot.com/edit-auto-order/<?php echo (string)$trades['_id']; ?>" target="_blank"><i class="fa fa-edit"></i></a></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            
                                                            <label class= "text-center" for="">Last Week Buy Trades Still Not Sold</label>    
                                                        </div>
                                                        
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                            <table class="table table-response">
                                                                <tr>
                                                                    <th class="text-center">id</th>
                                                                    <th class="text-center">purchased price</th>
                                                                    <th class="text-center">pl%</th>
                                                                </tr>
                                                                <?php foreach($errorTradesOpen as $open){ ?>
                                                                    <tr style="font-weight:normal">
                                                                        <td class="text-center"><?php echo $open['_id']; ?></td>
                                                                        <td class="text-center"><?php echo $open['purchased_price']; ?></td>
                                                                        <td class="text-center">
                                                                            <?php
                                                                            
                                                                                $res = plCalulate($open['purchased_price'], '', $open['symbol'], $exchange );

                                                                                if($res >= 0){
                                                                                    $class="success";
                                                                                }else{
                                                                                    $class="danger";
                                                                                }
                                                                                echo '<span class="text-' . $class . '"> <b> ' .number_format($res, 2). '%</b> </span>';
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </table>
                                                        </div> 
                                                    </div>
                                                </div>


                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            
                                                            <label class= "text-center" for="">Last Week Sold Trades</label>
                                                        </div>

                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                            <table class="table table-response">
                                                                <tr>
                                                                    <th class="text-center">id</th>
                                                                    <th class="text-center">purchased price</th>
                                                                    <th class="text-center">pl%</th>
                                                                </tr>
                                                                <?php foreach($errorTradesSold as $sold){ ?>
                                                                    <tr style= "font-weight:normal"> 
                                                                        <td class="text-center"><?php echo $sold['_id']; ?></td>
                                                                        <td class="text-center"><?php echo $sold['purchased_price']; ?></td>
                                                                        <td class="text-center">
                                                                            <?php
                                                                            
                                                                                $res = plCalulate($sold['purchased_price'], $sold['market_sold_price'], $sold['symbol'], $exchange );

                                                                                if($res >= 0){
                                                                                    $class="success";
                                                                                }else{
                                                                                    $class="danger";
                                                                                }
                                                                                echo '<span class="text-' . $class . '"> <b> ' .number_format($res, 2). '%</b> </span>';
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <!-- Last Week Limit Detail -->
                            <div class="container" style="margin-left:10%; margin-top:5%">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card h-100">
                                        <div class="">
                                            <div class="row gutters"> 
                                            
                                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                                                    <div class="form-group">

                                                        <div class="form-group">
                                                            
                                                            <label for="">Last Week Limit Detail</label>
                                                        </div>
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">

                                                            <table class="table table-response">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Date</th>
                                                                    <th>BTC_Limit</th>
                                                                    <th>Worth_Buy($)</th>
                                                                    <th>Buy_Count</th>
                                                                    <th>Expected</th>
                                                                    <th>USDT_Limit</th>
                                                                    <th>Worth_Buy</th>
                                                                    <th>Buy_Count</th>
                                                                    <th>Expected</th>
                                                                   
                                                                </tr>
                                                                <?php
                                                                $count = 1;

                                                                $buyCount          = 0;
                                                                $expectedbuyCount  = 0;

                                                                foreach($userData[0]['history'] as $history){
                                                                ?>
                                                                    <tr style= "font-weight:normal"> 

                                                                        <td class="text-center"><?php echo $count; $count++; ?></td>
                                                                        <td class="text-center">
                                                                            <?php
                                                                            
                                                                                if(isset($history['created'])){
                                                                                    echo $history['created']->toDateTime()->format("Y-m-d H:i:s");

                                                                                }else{
                                                                                    echo "---";
                                                                                }
                                                                        
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-center"><?php echo $history['dailyTradeableBTC_usd_worth']; ?></td> 
                                                                        <td class="text-center"><?php echo $history['daily_bought_btc_usd_worth']; ?></td>
                                                                        <td class="text-center"><?php echo $history['BTCTradesTodayCount']; ?></td>
                                                                        <td class="text-center"><?php echo $history['dailyTradesExpectedBtc']; ?></td>
                                                                        <td class="text-center"><?php echo $history['dailyTradeableUSDT_usd_worth']; ?></td>
                                                                        <td class="text-center"><?php echo $history['daily_bought_usdt_usd_worth']; ?></td>
                                                                        <td class="text-center"><?php echo $history['USDTTradesTodayCount']; ?></td>
                                                                        <td class="text-center"><?php echo $history['dailyTradesExpectedUsdt']; ?></td>

                                                                        <?php 
                                                                            $buyCount          +=    $history['BTCTradesTodayCount'] + $history['USDTTradesTodayCount']; 
                                                                            $expectedbuyCount  +=    $history['dailyTradesExpectedBtc'] + $history['dailyTradesExpectedUsdt'];

                                                                        ?>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <td colspan= "10" >

                                                                        <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:100%;border-radius:3px;color:black">
                                                                            100%
                                                                        </div>
                                                                        
                                                                    </td>
                                                                </tr>

                                                            </table>


                                                        </div>
                                                        
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Last Week Balance Detail -->
                            <div class="container" style="margin-left:10%; margin-top:5%">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card h-100">
                                        <div class="">
                                            <div class="row gutters"> 
                                            
                                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                                    <div class="form-group">

                                                        <div class="form-group">
                                                            <label for="">Last Week Balance Detail</label>
                                                        </div>

                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">


                                                            <table class="table table-response">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Date</th>
                                                                    <th>btc_account_worth</th>
                                                                    <th>usdt_account_worth</th>
                                                                    <th>btc_user_wallet</th>
                                                                    <th>usdt_user_wallet</th>
                                                                    <th>btc_committed</th>
                                                                    <th>usdt_committed</th>
                                                                    <th>btc_weekly_gain</th>
                                                                    <th>usdt_weekly_gain</th>
                                                                    
                                                                </tr>
                                                                <?php
                                                                $count = 0;
                                                                    foreach($balanceDetails as $balance){
                                                                ?>
                                                                    <tr style= "font-weight:normal"> 

                                                                        <td class="text-center"><?php echo $count; $count++; ?></td>
                                                                        <td class="text-center">
                                                                            <?php
                                                                            
                                                                                if(isset($balance['created_date'])){
                                                                                    echo $balance['created_date']->toDateTime()->format("Y-m-d H:i:s");

                                                                                }else{
                                                                                    echo "---";
                                                                                }
                                                                        
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-center"><?php echo $balance['btc_account_worth']; ?></td>
                                                                        <td class="text-center"><?php echo $balance['usdt_account_worth']; ?></td>
                                                                        <td class="text-center"><?php echo $balance['btc_user_wallet']; ?></td>
                                                                        <td class="text-center"><?php echo $balance['usdt_user_wallet']; ?></td>
                                                                        <td class="text-center"><?php echo $balance['btc_committed']; ?></td>
                                                                        <td class="text-center"><?php echo $balance['usdt_committed']; ?></td> 
                                                                        <td class="text-center"><?php echo $balance['btc_weekly_gain']; ?></td>
                                                                        <td class="text-center"><?php echo $balance['usdt_weekly_gain']; ?></td>
                                                                        
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>

                                                            </table>

                                                        </div>
                                                        
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
            
                </div>
           

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.1.3/circle-progress.min.js"></script> 

            <script>
                var progressBarOptions = {
                    startAngle: -1,
                    size: 60,
                };
                $('.circle').circleProgress(progressBarOptions).on('circle-animation-progress', function (event, progress, value) {
                
                });
                $('.pie_progress').asPieProgress({
                    size: 100,
                    ringWidth: 100,
                    strokeWidth: 100,
                    ringEndsRounded: true,
                    valueSelector: "span.value",
                    color: "navy"
                });
                $(document).ready(function() {
                    $('#filter_by_coin, #filter_by_rule_select, #filter_by_level_select').multiselect({
                    includeSelectAllOption: true,
                    buttonWidth: 435.7,
                    enableFiltering: true
                    });
                });

                $(document).ready(function(e){
                    var filter_by_trigger = $("#filter_by_trigger").val();



                    if (filter_by_trigger == 'barrier_trigger') {
                        $(".filter_by_level").hide();
                        $(".filter_by_rule").show();
                    }else if(filter_by_trigger == 'barrier_percentile_trigger'){
                        $(".filter_by_level").show();
                        $(".filter_by_rule").hide();
                    }else{
                        $(".filter_by_level").hide();
                        $(".filter_by_rule").hide();
                    }
                });


                $("body").on("change","#filter_by_trigger",function(e){
                var filter_by_trigger = $("#filter_by_trigger").val();

                $(".filter_by_level").hide();
                $(".filter_by_rule").hide();

                if(filter_by_trigger =='barrier_percentile_trigger'){
                $(".filter_by_level").show();
                $(".filter_by_rule").hide();
                }

                if(filter_by_trigger =='barrier_trigger'){
                $(".filter_by_rule").show();
                $(".filter_by_level").hide();
                }
                if(filter_by_trigger =='no'){
                $(".filter_by_level").hide();
                    $(".filter_by_rule").hide();
                }
                });

                $("body").on("click","input[name=group_filter]",function(e){
                var query = $(this).attr('id');
                if (query == 'trigger_group') {
                    $("#trigger1").hide();

                $("#triggerFirst").show();
                }else if(query == 'rule_group'){
                    $("#trigger1").show();
                $("#triggerFirst").hide();
                }else{
                $("#trigger1").hide();
                }
                });
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            </script> 