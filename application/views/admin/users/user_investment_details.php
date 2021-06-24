<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<link href="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.css" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?php echo ASSETS ?>buyer_order/moment-with-locales.js"></script>
<script src="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php  echo SURL ?>assets/dist/jquery-asPieProgress.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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
</style>

<style>
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
<h1 class="content-heading bg-white border-bottom">Reports</h1>
<div class="innerAll bg-white border-bottom">
<div class="pull-right" style="padding-right: 12px; padding-top: 8px;">
  <div class=" pull-right alert alert-warning" style=" margin-top: -10px; background: #5c678a;color: white;"> <?php echo date("F j, Y, g:i a").'&nbsp;&nbsp;  <b>'.date_default_timezone_get().' (GMT + 0)'.'<b />' ?></div>     

</div>
<ul class="menubar">
  <li class=""><a href="<?php echo SURL; ?>/admin/users_list/display_user_list">Reports</a></li>
</ul>
</div>
<div class="innerAll spacing-x2">
<?php
if ($this->session->flashdata('err_message')) {
?>
<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
<?php
}
if ($this->session->flashdata('ok_message')) {
?>
<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
<?php
}
?>
<?php $filter_data = $this->session->userdata('filter_investment_report');?>
<div class="widget widget-inverse">
  <div class="widget-body">
    <form method="POST" action="<?php echo SURL; ?>admin/users_list/display_user_list">
      <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 ax_1">
        <div class="col-xs-12 col-sm-12 col-md-3 ax_2">
          <div class="Input_text_s">
            <label>Filter Coin: </label>
            <select id="filter_by_coin" multiple="multiple" name="filter_by_coin[]" type="text" class=" filter_by_name_margin_bottom_sm">
              <?php foreach($coins as $coinRow){  ?>      
              <option value="<?php echo $coinRow['symbol']?>" <?php if (in_array($coinRow['symbol'], $filter_data['filter_by_coin'])) {?> selected <?php }?> ><?php echo $coinRow['symbol'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 ax_3">
          <div class="Input_text_s">
            <label>Exchange: </label>
            <select id="exchange" name="exchange" type="text" class="form-control filter_by_name_margin_bottom_sm">
              <option value="bam"<?=(($filter_data['exchange'] == "bam") ? "selected" : "")?>>Bam</option>
              <option value="binance"<?=(($filter_data['exchange'] == "binance") ? "selected" : "")?>>Binance</option>
              <option value="kraken"<?=(($filter_data['exchange'] == "kraken") ? "selected" : "")?>>kraken</option>
            </select>
          </div>
        </div> 
        
        
        <div class="col-xs-12 col-sm-12 col-md-3  ax_8 filter_by_month"  style=" min-height: 60px;">
          <div class="Input_text_s filter_by_month"   <?php if ($filter_data['group_filter'] == 'rule_group') {?> <?php  } else {?>  <?php  }?>>
            <label>Filter Month: </label>
            <select id="filter_by_level_select" name="filter_by_month[]" multiple="multiple" type="text" class="form-control filter_by_name_margin_bottom_sm filter_by_month">
              <option value="01" <?php if (in_array('01', $filter_data['filter_by_month'])) {?> selected <?php }?>>January</option>
              <option value="02" <?php if (in_array('02', $filter_data['filter_by_month'])) {?> selected <?php }?>>February</option>
              <option value="03" <?php if (in_array('03', $filter_data['filter_by_month'])) {?> selected <?php }?>>March</option>
              <option value="04" <?php if (in_array('04', $filter_data['filter_by_month'])) {?> selected <?php }?>>April</option>
              <option value="05" <?php if (in_array('05', $filter_data['filter_by_month'])) {?> selected <?php }?>>May</option>
              <option value="06" <?php if (in_array('06', $filter_data['filter_by_month'])) {?> selected <?php }?>>June</option>
              <option value="07" <?php if (in_array('07', $filter_data['filter_by_month'])) {?> selected <?php }?>>July</option>
              <option value="08" <?php if (in_array('08', $filter_data['filter_by_month'])) {?> selected <?php }?>>August</option>
              <option value="09" <?php if (in_array('09', $filter_data['filter_by_month'])) {?> selected <?php }?>>September</option>
              <option value="10"<?php if (in_array('10', $filter_data['filter_by_month'])) {?> selected <?php }?>>October</option>
              <option value="11"<?php if (in_array('11', $filter_data['filter_by_month'])) {?> selected <?php }?>>November</option>
              <option value="12"<?php if (in_array('12', $filter_data['filter_by_month'])) {?> selected <?php }?>>December</option>
            </select>
          </div>
        </div> 

        <div class="col-xs-12 col-sm-12 col-md-3 ax_4">
          <div class="Input_text_s">
            <label>username: </label>
            <input id="user_name" name="user_name" type="text" class="form-control filter_by_name_margin_bottom_sm" placeholder="Search By Username" value="<?=(!empty($filter_data['user_name']) ? $filter_data['user_name'] : "")?>" autocomplete="off">
            </div>
        </div>
       
        <div class="col-xs-12 col-sm-12 col-md-3 ax_10">
          <div class="Input_text_btn">
            <label></label>
            <button id="submit-form" class="btn btn-success"><i class="glyphicon glyphicon-filter"></i>Search</button>
            <a href="<?php echo SURL; ?>admin/trigger_rule_reports/csv_export_oppertunity_month"  class="btn btn-info">Export To CSV File</a>
            </span>
           
            <!-- <span style="float:right;"><a href="<?php //echo SURL; ?>admin/reports/csv_export_trades" class="btn btn-info">Export To CSV File</a></span> --> 
          </div>
        </div>
      </div>
      </div>
    </form>
  </div>
</div>
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
            left: 50%;
            z-index: 2222;
            transform: translate(-50%, -50%);
            font-size: 15px;
            color: black;
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
<div class="widget widget-inverse">
  <div class="widget-body padding-bottom-none">
    <table class=" table table-bordered">
      <tr class="theadd">
        <th>#</th>
        <th>Coin</th>
        <th>User Name </th>
        <th>Join Date</th> 
        <th>Investment</th>
        <th>Gain</th>
        <th>Profit</th>
        <th>profit In Percentage</th>
        <th>Profit Amount</th>
        <th>Total Sold</th>
        <th>Total open/lth</th>
        <th>Open/Lth Balance</th>
        <th>Buy fee BNB</th>
        <th>Buy fee Qty</th>
        <th>Sell Fee BNB</th>
        <th>Sell fee Qty</th>
        <th>Month</th>
        <th>Last Modified</th>
      </tr>
    <?php
   $count = 0;
  foreach ($final_array as $key => $value) { 
    $count++;
      if($value['coin'] =='NCASHBTC'){
          $coinImage  =  'ncashhhhhhh.png';
      }elseif($value['coin'] =='ETHBTC'){
        $coinImage = 'ethereum-black-symbol-chrystal-vector-20393411.jpg';
      }else if($value['coin'] =='TRXBTC'){
          $coinImage  =  'aaaaaw.jpg'; 
      }else if($value['coin'] =='EOSBTC'){
        $coinImage  =  'EOS.jpg';
      }else if($value['coin'] =='POEBTC'){
        $coinImage  =  'original.jpg';
      }else if($value['coin'] =='NEOBTC'){
        $coinImage  =  'NEO.jpg';
      }else if($value['coin'] =='ETCBTC'){
        $coinImage  =  'etc.jpg';
      }else if($value['coin'] =='XRPBTC'){
        $coinImage  =  'ripple.png';
      }else if($value['coin'] =='XEMBTC'){
        $coinImage  =  'nem.png';
      }else if($value['coin'] =='XLMBTC'){
        $coinImage  =  'xlm.png';
      }else if($value['coin'] =='QTUMBTC'){
        $coinImage  =  'QTUMBTC.jpg';
      }else if($value['coin'] =='ZENBTC'){
        $coinImage  =  'ZENBTC.png';
      }elseif($value['coin'] == 'NEOUSDT'){
        $coinImage = 'neousdt.png';
      }elseif($value['coin'] == 'BTCUSDT'){
        $coinImage = 'btc.png';
      }elseif($value['coin'] == 'XRPUSDT'){
        $coinImage  =  'ripple.png';
      }elseif($value['coin'] == 'QTUMUSDT'){      
        $coinImage  =  'QTUMBTC.jpg';
      }elseif($value['coin'] == 'NEOUSDT'){
        $coinImage = 'neousdt.png';
      }elseif($value['coin'] == 'ADABTC'){              
        $coinImage = 'adabtc.png';
      }elseif($value['coin'] == 'LINKBTC'){              
        $coinImage = 'linkbtc.png';
      }elseif($value['coin'] == 'XMRBTC'){              
        $coinImage = 'xmrbtc.png';
      }elseif($value['coin'] == 'DASHBTC'){              
        $coinImage = 'dashbtc.jpg';
      }elseif($value['coin'] == 'LTCUSDT'){              
        $coinImage = 'ltcusdt.png';
      }
      $time_zone = date_default_timezone_get();
      $join_date = $value['created_date']->toDateTime()->format("Y-m-d H:i:s");
      $last_modified_time = $value['last_modified']->toDateTime()->format("Y-m-d H:i:s");
    ?>
    <tr style="text-align:center;">
        <td><?php echo $count; ?></td>
        <td><span title="<?php print_r($final_array['level']);?>"><img class="img img-circle" src="https://admin.digiebot.com/assets/coin_logo/thumbs/<?php echo $coinImage ; ?>" data-toggle="tooltip" data-placement="top" alt="<?php echo $value['coin'];?>" title="<?php echo $value['coin'];?>"></span></td>
        <td>
        <?php if(isset($value['Active_Parents']) || isset($value['btc_balance']) || isset($value['usdt_balance'])){?>  
        <span title="Total active parents =<?php echo $value['Active_Parents'];?>. Avaliable BTC balance =<?php echo $value['btc_balance'];?>.Avaliable USDT balance =<?php echo $value['usdt_balance'];?>"><?php echo $value['username'];?></span>
        <?php }else{
         echo $value['username'];}?>
      </td>
        <?php  
        $profit = 0;
        if(isset($value['investment']) && isset($value['gain_total'])){
        $profit = $value['gain_total']- $value['investment']; 
        }
        ?>
        <td> <span class="label label-info"title="Levels = <?php foreach($value['level'] as $level){echo $level.",";} ?>"><?php echo $join_date; ?></span></td>
        <td>
          <?php
           $in_array =['BTCUSDT', 'XRPUSDT', 'NEOUSDT', 'QTUMUSDT', 'LTCUSDT'];
          if(in_array($value['coin'], $in_array)){
           echo"$".number_format($value['investment'], 8); 
          }else{
            echo"฿".number_format($value['investment'], 8);
          }
          ?>
        </td>
        <td>
          <?php
          if(in_array($value['coin'], $in_array)){
            echo"$".number_format($value['gain_total'],8); 
          }else{
            echo"฿".number_format($value['gain_total'],8); 
          }
          ?>
        </td>
        <td>
          <?php
          if(in_array($value['coin'], $in_array)){
            echo"$".number_format($profit, 8);
          }else{
            echo"฿".number_format($profit, 8);
          }
          ?>
        </td>
        <?php 
        $profit_in_percentage = 0;
        if(isset($value['investment']) && isset($value['profit'])){
         $profit_in_percentage = ($profit/$value['investment'])*100;
        }?>
       
        <td>
      <?php    $profit_percentage   = number_format($profit_in_percentage, 2); ?>
    <?php if($profit_percentage >=0){ ?>
      <div class="circle" id="circle-a" data-value="<?php echo $profit_percentage/3;?>" data-fill="{
                    &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">
                    <strong><span title="<?php echo $value['5_min_value']; ?>"><?php echo number_format($profit_percentage, 2);?>%</span></strong>
      </div> <?php } elseif($profit_percentage < 0){ ?>
        <div class="circle" id="circle-a" data-value="<?php echo $profit_percentage/-3;?>" data-fill="{
                    &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                    <strong><span title="<?php echo $value['5_min_value']; ?>"><?php echo number_format($profit_percentage, 2);?>%</span></strong>
        </div><?php } ?>
    </td>

        <th><?php echo"$".number_format($value['profit_amount'], 4);?></th> 
        <th><?php echo $value['sold'];?></th> 
        <th><?php echo $value['open_lth'];?></th> 
        <td><?php echo $value['open/lth_balance']; ?></td>
        <th><?php echo number_format($value['buy_comission_bnb'],8);?></th>
        <th><?php echo number_format($value['buy_comission_qty'], 8);?></th>  
        <th><?php echo number_format($value['sell_comission_bnb'], 8);?></th>
        <th><?php echo number_format($value['sell_comission_qty'], 8);?></th> 
        <td><span class="label label-info"><?php 
        if($value['month'] =='01'){
          echo "January";
        }elseif($value['month'] =='02'){
          echo "February";
        }elseif($value['month'] =='03'){
          echo "March";
        }elseif($value['month'] =='04'){
          echo "April";
        }elseif($value['month'] =='05'){
          echo "May";
        }elseif($value['month'] =='06'){
          echo "June";
        }elseif($value['month'] =='07'){
          echo "July";
        }elseif($value['month'] =='08'){
          echo "August";
        }elseif($value['month'] =='09'){
          echo "September";
        }elseif($value['month'] =='10'){
          echo "October";
        }elseif($value['month'] =='11'){
          echo "November";
        }elseif($value['month'] =='12'){
          echo "December";
        }
        ?></span></td> 
        <td><?php
        $this->load->helper('common_helper');
        $last_time_ago = time_elapsed_string($last_modified_time , $time_zone);?>
        <span class="label label-info" title="<?php echo $last_modified_time; ?>"> <?php echo $last_time_ago; ?></span>
      </td> 


      <!-- <td class="center has-tooltip" aria-label="<?php echo $last_modified_time;?>"><span class="label label-success"><?php echo $last_modified_time; ?></span></td> -->
    </tr>
  <?php  }   ?>
    </table>
    <div><?php echo $links; ?></div>
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
    </script> 
<script type="text/javascript">
$('.pie_progress').asPieProgress({
size: 100,
ringWidth: 100,
strokeWidth: 100,
ringEndsRounded: true,
valueSelector: "span.value",
color: "navy"
});
</script> 
<script type="text/javascript">
$(document).ready(function() {
    $('#filter_by_coin, #filter_by_rule_select, #filter_by_level_select').multiselect({
      includeSelectAllOption: true,
      buttonWidth: 435.7,
      enableFiltering: true
    });
});
</script> 
<script>
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