
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<link href="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.css" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?php echo ASSETS ?>buyer_order/moment-with-locales.js"></script>
<script src="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php  echo SURL ?>assets/dist/jquery-asPieProgress.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
  /* circule css */
.circle{
      position: relative;
    }
  .circle strong {
      position: absolute;
      top: 50%;
      left: 50%;
      /* z-index: 2222; */
      transform: translate(-50%, -50%);
      font-size: 15px;
      color: black;
  }
</style>
          <?php $filter_user_data = $this->session->userdata('filter_order_data');?>
          <div id="content">
            <div class="widget widget-inverse">
              <div class="widget-body">
                <h1 class="content-heading bg-white border-bottom">Reports</h1>
                <div class="innerAll bg-white border-bottom"></div>
                <div class="row">
                  <form method="POST" action="<?php echo SURL; ?>admin/coins/coin_moves">
                    <div class="col-xs-12 col-sm-12 col-md-12 ax_1">
                      <div class="col-xs-12 col-sm-12 col-md-3  ax_8 filter_by_level"  style=" min-height: 60px;" id="filter_by_level">
                        <div class="Input_text_s filter_by_level">
                          <label>Filter By Exchange: </label>
                          <select id="exchange" name="exchange" type="text" class="form-control filter_by_name_margin_bottom_sm exchange" >
                            <option value="binance" <?php if (in_array('binance', $filter_user_data)) {?> selected <?php }?>>Binance</option>   
                            <option value="kraken" <?php if (in_array('kraken', $filter_user_data)) {?> selected <?php }?>>Kraken</option>
                            <option value="bam" <?php if (in_array('bam', $filter_user_data)) {?> selected <?php }?>>Bam</option>
                          </select>
                        </div>
                      </div>  
                      <div class="col-xs-12 col-sm-12 col-md-3 ax_10">
                        <div class="Input_text_btn">
                          <button id="submit-form" class="btn btn-success"><i class="glyphicon glyphicon-filter"></i>Search</button>
                        </div>
                      </div>          
                    </div>
                   
                  </form>
                </div>
              </div>
            </div>
          </div>


<?php //echo "<pre>";  print_r($full_arr); exit; ?>
<div id="content">
<div class="widget widget-inverse">
  <div class="widget-body">
          <table class="table table-striped" id="dataTable">
            <thead class="thead-dark">
              <tr>
                <th style="text-align:center;" scope="col">Coin</th>
                <th style="text-align:center;" scope="col">Last Week Max</th>
                <th style="text-align:center;" scope="col">Last Week Min</th>
                <th style="text-align:center;" scope="col">30 Days Max</th>
                <th style="text-align:center;" scope="col">30 days Min</th>
                <th style="text-align:center;" scope="col">90 Days Max</th>
                <th style="text-align:center;" scope="col">90 Days Min</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($final_array as $value):
                if($value['coin'] =='NCASHBTC'){
                  $coinImage  =  'ncashhhhhhh.png';
              }elseif($value['coin'] =='ETHBTC'){
                $coinImage = 'ethereum-black-symbol-chrystal-vector-20393411.jpg';
              }elseif($value['coin'] =='TRXBTC'){
                  $coinImage  =  'aaaaaw.jpg'; 
              }elseif($value['coin'] =='EOSBTC'){
                $coinImage  =  'EOS.jpg';
              }elseif($value['coin'] =='POEBTC'){
                $coinImage  =  'original.jpg';
              }elseif($value['coin'] =='NEOBTC'){
                $coinImage  =  'NEO.jpg';
              }elseif($value['coin'] =='ETCBTC'){
                $coinImage  =  'etc.jpg';
              }elseif($value['coin'] =='XRPBTC'){
                $coinImage  =  'ripple.png';
              }elseif($value['coin'] =='XEMBTC'){
                $coinImage  =  'nem.png';
              }elseif($value['coin'] =='XLMBTC'){
                $coinImage  =  'xlm.png';
              }elseif($value['coin'] =='QTUMBTC'){
                $coinImage  =  'QTUMBTC.jpg';
              }elseif($value['coin'] =='ZENBTC'){
                $coinImage  =  'ZENBTC.png';
              }elseif($value['coin'] == 'NEOUSDT'){
                $coinImage = 'neousdt.png';
              }elseif($value['coin'] == 'BTCUSDT'){
                $coinImage = 'btc.png';
              }elseif($value['coin'] == 'XRPUSDT'){
                $coinImage  =  'ripple.png';
              }elseif($value['coin'] == 'QTUMUSDT'){      
                $coinImage  =  'QTUMBTC.jpg';
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
              }elseif($value['coin'] == 'EOSUSDT'){                 
                $coinImage = 'EOS.jpg';
              }
              ?>
              <tr style="text-align:center;">
              <td><img class="img img-circle" src="https://admin.digiebot.com/assets/coin_logo/thumbs/<?php echo $coinImage ; ?>" data-toggle="tooltip" data-placement="top" alt="<?php echo $value['coin'];?>" title="<?php echo $value['coin']; ?>"></td>
                  <?php 
                    $min_cal_1 = 0;
                    $min_cal_2 = 0;
                    $per_7_days_min = 0;
                    $max_cal_1  = 0;
                    $max_cal_2 = 0;
                    $per_7_days_max = 0;
                    if(isset($value['min_7_days'])){
                      $per_7_days_min = 0;
                      $min_cal_1 = (float)$value['min_7_days'] - $value['current_market'];
                      $min_cal_2 = ($value['min_7_days'] + $value['current_market']) / 2;
                      $per_7_days_min =  ($min_cal_1/ $min_cal_2)*100;
                      //  7 days max calculation
                      $max_cal_1 = (float)$value['max_7_days'] - $value['current_market'];
                      $max_cal_2 = ($value['max_7_days'] + $value['current_market']) / 2;
                      $per_7_days_max =  ($max_cal_1/ $max_cal_2)*100;
                    }
                    $min_cal_30 = 0;
                    $min_cal2_30 = 0;
                    $per_30_days_min = 0;
                    $max_cal_30  = 0;
                    $max_cal2_30 = 0;
                    $per_30_days_max = 0;
                    if(isset($value['min_30_days'])){
                      $per_30_days_min = 0;
                      $min_cal_30 = (float)$value['min_30_days'] - $value['current_market'];
                      $min_cal2_30 = ($value['min_30_days'] + $value['current_market']) / 2;
                      $per_30_days_min =  ($min_cal_30/ $min_cal2_30)*100;
                      //  30 days max calculation
                      $max_cal_30 = (float)$value['max_30_days'] - $value['current_market'];
                      $max_cal2_30 = ($value['max_30_days'] + $value['current_market']) / 2;
                      $per_30_days_max =  ($max_cal_30/ $max_cal2_30)*100;
                    }
                    $min_cal_90 = 0;
                    $min_cal2_90 = 0;
                    $per_90_days_min = 0;
                    $max_cal_90  = 0;
                    $max_cal2_90 = 0;
                    $per_90_days_max = 0;
                    if(isset($value['min_90_days'])){
                      $per_90_days_min = 0;
                      $min_cal_90 = (float)$value['min_90_days'] - $value['current_market'];
                      $min_cal2_90 = ($value['min_90_days'] + $value['current_market']) / 2;
                      $per_90_days_min =  ($min_cal_90/ $min_cal2_90)*100;
                      //  90 days max calculation
                      $max_cal_90 = (float)$value['max_90_days'] - $value['current_market'];
                      $max_cal2_90 = ($value['max_90_days'] + $value['current_market']) / 2;
                      $per_90_days_max =  ($max_cal_90/ $max_cal2_90)*100;
                    }
                  
                  ?>
                <td>
                  <?php if($per_7_days_max >= 0 ){ ?>
                    <div class="circle" id="circle-a" data-value="<?php echo $per_7_days_max/25;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">      
                      <strong><?php echo number_format($per_7_days_max, 2);?>%</strong>
                    </div> <?php } elseif($per_7_days_max < 0){ ?>
                    <div class="circle" id="circle-a" data-value="<?php echo $per_7_days_max/-25;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                      <strong><?php echo number_format($per_7_days_max, 2);?>%</strong>
                    </div><?php } ?>
                </td>

                <td>
                  <?php if($per_7_days_min >= 0 ){ ?>
                    <div class="circle" id="circle-a" data-value="<?php echo $per_7_days_min/25;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">      
                      <strong><?php echo number_format($per_7_days_min, 2);?>%</strong>
                    </div> <?php } elseif($per_7_days_min < 0){ ?>
                    <div class="circle" id="circle-a" data-value="<?php echo $per_7_days_min/-25;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                      <strong><?php echo number_format($per_7_days_min, 2);?>%</strong>
                    </div><?php } ?>
                </td>

                <td>
                  <?php if($per_30_days_max >= 0){ ?>
                    <div class="circle" id="circle-a" data-value="<?php echo $per_30_days_max/50;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">
                      <strong><?php echo number_format($per_30_days_max, 2);?>%</strong>
                    </div> <?php } elseif($per_30_days_max < 0){ ?>
                    <div class="circle" id="circle-a" data-value="<?php echo $per_30_days_max/-50;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                      <strong><?php echo number_format($per_30_days_max, 2);?>%</strong>
                    </div><?php } ?>
                </td>

                <td>
                  <?php if($per_30_days_min >= 0){ ?>
                    <div class="circle" id="circle-a" data-value="<?php echo $per_30_days_min/50;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">
                      <strong><?php echo number_format($per_30_days_min, 2);?>%</strong>
                    </div> <?php }elseif($per_30_days_min < 0){ ?>
                    <div class="circle" id="circle-a" data-value="<?php echo $per_30_days_min/-50;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                      <strong><?php echo number_format($per_30_days_min, 2);?>%</strong>
                    </div><?php } ?>
                </td>

                <td>
                  <?php if($per_90_days_max >= 0){ ?> 
                    <div class="circle" id="circle-a" data-value="<?php echo $per_90_days_max/100;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">
                      <strong><?php echo number_format($per_90_days_max, 2);?>%</strong>
                    </div> <?php }elseif($per_90_days_max < 0){ ?>
                    <div class="circle" id="circle-a" data-value="<?php echo $per_90_days_max/-100;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                      <strong><?php echo number_format($per_90_days_max, 2);?>%</strong>
                    </div><?php } ?>
                </td>
                <td>
                  <?php if($per_90_days_min >= 0){ ?>
                    <div class="circle" id="circle-a" data-value="<?php echo $per_90_days_min/100;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">
                      <strong><?php echo number_format($per_90_days_min, 2);?>%</strong>
                    </div> <?php } elseif($per_90_days_min < 0){ ?>
                    <div class="circle" id="circle-a" data-value="<?php echo $per_90_days_min/-100;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                      <strong><?php echo number_format($per_90_days_min, 2);?>%</strong>
                    </div><?php } ?>
                </td>
               </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
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
input[type="checkbox"][readonly] {
  pointer-events: none;
}
</style>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.1.3/circle-progress.min.js"></script> 
  <script>
    var progressBarOptions = {
        startAngle: -1,
        size: 60,
    };
    $('.circle').circleProgress(progressBarOptions).on('circle-animation-progress', function (event, progress, value) {
    });
  </script> 

<!-- data table  -->
    <script src="assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script> 
      <script type="text/javascript">
        $(document).ready(function() {
          $('#dataTable').dataTable({
            "pageLength": 100
          });
        });
    </script>
   <!-- end data table -->

<script>
$('.click').click(function(){
    var currentRow=$(this).closest("tr"); 
    var id = currentRow.find("td:eq(0)").text(); // get current row 1st TD value
    var level = currentRow.find("td:eq(1)").text(); // get current row 2nd TD
    var enable_status = currentRow.find("td:eq(4)").text(); // get current row 4th TD
    document.getElementById('id').value= id;
    document.getElementById('level').value= level;
    document.getElementById('enable_status').value= enable_status;
});
$(".setsize").each(function() {
    $(this).height($(this).width());
});

$(window).on('resize', function(){
$(".setsize").each(function() {
    $(this).height($(this).width());
});
});

$(document).ready(function(){
 $('#dataTable_length').css("float", "left");
});

</script> 
</div>
