
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
	position:relative;
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
.ax_2, .ax_3, .ax_4, .ax_5, .ax_6, .ax_7, .ax_8, .ax_9, .ax_10, .ax_11, .ax_12, .ax_14 {
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

.coin_symbol {}

.coin_symbol {
  color: #fff;
  font-weight: bold;
  font-size: 16px;
  float: left;
  width: 100%;
  padding: 12px 20px;
  background: #2d4c5a;
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
  text-align: center;
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
/* start circle style */
.circle{
  position: relative;
}
.circle strong {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 15px;
  color: black;
}
/* end circle style */
</style>
<div id="content">
  <h1 class="content-heading bg-white border-bottom">Reports</h1>

  <div class="innerAll bg-white border-bottom">
  <ul class="menubar">
    <li class=""><a href="<?php echo SURL; ?>admin/reports">Reports</a></li>
    <li class="active"><a href="#">Custom Report</a></li>
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
      <?php $filter_user_data = $this->session->userdata('filter_order_data');?>
      <div class="widget widget-inverse">
         <div class="widget-body">
            <form method="POST" action="<?php echo SURL; ?>admin/reports/coin_report">
              <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-12 ax_1">
                <div class="alert alert-info"><?php echo "Server Time: " . date("d-m-y H:i:s a"); ?></label></div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-3  ax_2" style=" min-height: 60px;">
                <label>Filter By: </label>
                <select id="filter_by_search" name="filter_by_search" type="text" class="form-control filter_by_name_margin_bottom_sm">
                  <option value="both" <?php if ($filter_user_data['filter_by_search'] == 'both') {?> selected <?php }?>>Both</option>
                  <option value="level" <?php if ($filter_user_data['filter_by_search'] == 'level') {?> selected <?php }?>>Level</option>
                  <option value="coin" <?php if ($filter_user_data['filter_by_search'] == 'coin') {?> selected <?php }?>>Coins</option>
                  <option value="levelWise" <?php if ($filter_user_data['filter_by_search'] == 'levelWise') {?> selected <?php }?>>Show level Wise</option>
                </select>
              </div> 
             
              <div class="col-xs-12 col-sm-12 col-md-3  ax_2 filter_by_coin"  style=" min-height: 60px;" id="filter_by_coin">
                <div class="Input_text_s filter_by_coin">
                  <label>Filter Coins: </label>
                  <select id="filter_by_coin_select" name="filter_by_coin[]" multiple="multiple" type="text" class="form-control filter_by_name_margin_bottom_sm filter_by_coin" >
                    <?php if (count($coins) > 0) {
                      for ($i = 0; $i < count($coins); $i++) {?>
                        <?php if (in_array($coins[$i]['symbol'], $filter_user_data['filter_by_coin'])) {?>
                          <option value="<?php echo $coins[$i]['symbol'] ?>" selected><?php echo $coins[$i]['symbol']; ?></option>
                        <?php } else {?>
                          <option value="<?php echo $coins[$i]['symbol'] ?>" ><?php echo $coins[$i]['symbol']; ?></option>
                        <?php }
                      }
                    }?>  
                  </select>
                </div>
              </div>
                <!--  level filter start  --> 
              <div class="col-xs-12 col-sm-12 col-md-3  ax_3 filter_by_level"  style=" min-height: 60px;" id="filter_by_level">
                <div class="Input_text_s filter_by_level">
                  <label>Filter Level: </label>
                  <select id="filter_by_level_select" name="filter_by_level[]" multiple="multiple" type="text" class="form-control filter_by_name_margin_bottom_sm filter_by_level" >
                    <option value="level_1" <?php if (in_array('level_1', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 1</option>
                    <option value="level_2" <?php if (in_array('level_2', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 2</option>
                    <option value="level_3" <?php if (in_array('level_3', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 3</option>
                    <option value="level_4" <?php if (in_array('level_4', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 4</option>
                    <option value="level_5" <?php if (in_array('level_5', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 5</option>
                    <option value="level_6" <?php if (in_array('level_6', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 6</option>
                    <option value="level_7" <?php if (in_array('level_7', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 7</option>
                    <option value="level_8" <?php if (in_array('level_8', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 8</option>
                    <option value="level_9" <?php if (in_array('level_9', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 9</option>
                    <option value="level_10"<?php if (in_array('level_10', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 10</option>
                    <option value="level_11"<?php if (in_array('level_11', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 11</option>
                    <option value="level_12"<?php if (in_array('level_12', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 12</option>
                    <option value="level_13"<?php if (in_array('level_13', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 13</option>
                    <option value="level_14"<?php if (in_array('level_14', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 14</option>
                    <option value="">Level 15</option>
                    <option value="level_16"<?php if (in_array('level_16', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 16</option>
                    <option value="level_17"<?php if (in_array('level_17', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 17</option>
                    <option value="level_18"<?php if (in_array('level_18', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 18</option>
                    <option value="level_19"<?php if (in_array('level_19', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 19</option>
                    <option value="level_20"<?php if (in_array('level_20', $filter_user_data['filter_by_level'])) {?> selected <?php }?>>Level 20</option>
                  </select>
                </div>
              </div>
                     
               <!-- End level filter  -->
               <div class="col-xs-12 col-sm-12 col-md-3 ax_4">
                  <div class="Input_text_s">
                    <label>Filter Mode: </label>
                    <select id="filter_by_mode" name="filter_by_mode" type="text" class="form-control filter_by_name_margin_bottom_sm">
                      <option value="live"<?=(($filter_user_data['filter_by_mode'] == "live") ? "selected" : "")?>>Live</option>
                      <option value="test"<?=(($filter_user_data['filter_by_mode'] == "test") ? "selected" : "")?>>Test</option>
                    </select>
                  </div>
               </div>

               <div class="col-xs-12 col-sm-12 col-md-3 ax_5">
                  <div class="Input_text_s">
                    <label>Filter Exchange: </label>
                    <select id="exchange" name="exchange" type="text" class="form-control filter_by_name_margin_bottom_sm">
                      <option value="binance"<?=(($filter_user_data['exchange'] == "binance") ? "selected" : "")?>>Binance</option>
                      <option value="bam"<?=(($filter_user_data['exchange'] == "bam") ? "selected" : "")?>>Bam</option>
                      <option value="kraken"<?=(($filter_user_data['exchange'] == "kraken") ? "selected" : "")?>>Kraken</option>
                    </select>
                  </div>
               </div>

               <div class="col-xs-12 col-sm-12 col-md-3 ax_6">
                  <div class="Input_text_s">
                    <label>From Date Range: </label>
                    <input id="filter_by_start_date" name="filter_by_start_date" type="text" class="form-control datetime_picker filter_by_name_margin_bottom_sm" placeholder="Search By Date" value="<?=(!empty($filter_user_data['filter_by_start_date']) ? $filter_user_data['filter_by_start_date'] : "")?>" autocomplete="off">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-12 col-md-3 ax_7">
                  <div class="Input_text_s">
                    <label>To Date Range: </label>
                    <input id="filter_by_end_date" name="filter_by_end_date" type="text" class="form-control datetime_picker filter_by_name_margin_bottom_sm" placeholder="Search By Date" value="<?=(!empty($filter_user_data['filter_by_end_date']) ? $filter_user_data['filter_by_end_date'] : "")?>" autocomplete="off">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </div>
               </div>
               <script type="text/javascript">
                   $(function () {
                       $('.datetime_picker').datepicker();
                   });
               </script>
               <style>
                  .Input_text_btn {padding: 25px 0 0;}
               </style>
              
               <!-- End Hidden Searches -->
                        
                <div class="col-xs-12 col-sm-12 col-md-3 ax_8">
                  <div class="Input_text_s">
                    <label>Filter Max/Min: </label>
                    <select id="maxMin" name="maxMin" type="text" class="form-control filter_by_name_margin_bottom_sm">
                      <option value="perOneLessPerMax"<?=(($filter_user_data['maxMin'] == 'perOneLessPerMax') ? "selected" : "")?>>1% or less </option>
                      <option value="perOneHalfPerMax"<?=(($filter_user_data['maxMin'] == 'perOneHalfPerMax') ? "selected" : "")?>>1.5% or Greater </option>
                      <option value="perTwoPerMax"<?=(($filter_user_data['maxMin'] == 'perTwoPerMax') ? "selected" : "")?>>2% or Greater </option>
                      <option value="perTwoHalfPerMax"<?=(($filter_user_data['maxMin'] == 'perTwoHalfPerMax') ? "selected" : "")?>>2.5% or Greater</option>
                      <option value= "perThreePerMax"<?=(($filter_user_data['maxMin'] == 'perThreePerMax') ? "selected" : "")?>>3% or Greater </option>
                    </select>
                  </div>
                </div>

               
                <div class="col-xs-12 col-sm-12 col-md-1 ax_9" style="padding-top:25px">
                  <div class="Input_text_s">
                    <label></label> 
                    <input name="resultDisplay" type="radio" class="filter_by_name_margin_bottom_sm" value= "ten"<?php if($filter_user_data['resultDisplay']== 'ten' || $filter_user_data['resultDisplay']== '' ){?> checked <?php }?>>10 Hour
                    <input name="resultDisplay" type="radio" class="filter_by_name_margin_bottom_sm" value="five"<?php if($filter_user_data['resultDisplay'] == 'five'){?> checked <?php }?>>5 Hours
                  </div>
                </div>


                <div class="col-xs-12 col-sm-12 col-md-2 ax_10" style="padding-top:25px">
                  <div class="Input_text_s">
                    <label></label>   
                    <input name="checkBoxFilterMax" type="checkbox" class="filter_by_name_margin_bottom_sm" value= "max"<?php if($filter_user_data['checkBoxFilterMax']== 'max'){?> checked <?php }?>>Max
                    <input name="checkBoxFilterMin" type="checkbox" class="filter_by_name_margin_bottom_sm" value="min"<?php if($filter_user_data['checkBoxFilterMin'] == 'min'){?> checked <?php }?>>Min
                    <input name="checkBoxFiltercurrent" type="checkbox" class="filter_by_name_margin_bottom_sm" value="current"<?php if($filter_user_data['checkBoxFiltercurrent'] == 'current'){?> checked <?php }?>>Current
                    <input name="checkBoxFilterstatus" type="checkbox" class="filter_by_name_margin_bottom_sm" value="status"<?php if($filter_user_data['checkBoxFilterstatus'] == 'status'){?> checked <?php }?>>start to End Status
                  </div>
                </div>
              
               <div class="col-xs-12 col-sm-12 col-md-3 ax_11">
                  <div class="Input_text_btn">
                    <label></label>
                    <button id="submit-form" class="btn btn-success"><i class="glyphicon glyphicon-filter"></i>Search</button>
                    <a href="<?php echo SURL; ?>admin/reports/reset_filters_report/coin" class="btn btn-danger"><i class="fa fa-times-circle"></i>Reset</a>

                    <span class="ax_10"><button class="btn btn-info" onclick="exportTableToCSV('report.csv')">Export To CSV File</button></span>
                    <!-- <span style="float:right;"><a href="<?php //echo SURL; ?>admin/reports/csv_export_trades" class="btn btn-info">Export To CSV File</a></span> -->
                  </div>
               </div>
            </div>
            </form>
          </div>
      </div>
    <!-- Widget -->
    <style type="text/css">
          /* Important part */
          .modal-dialog{
              overflow-y: initial !important
          }
          .Opp{
              height: 550px;
              padding-left: 10px;
              overflow-y: auto;
              overflow-x: hidden;
            }
          .totalAvg {
            padding-top: 44px;
          }
    </style>
   <div class="widget widget-inverse">
  <div class="widget-body">
    <table class="table table-striped" id="dataTable">
      <thead class="thead-dark">
        <tr>
          <th>Selected Filter</th>
          <th>Total Opportunity</th>
          <th>Closing % </th>
          <th>Total Sold Order</th>
          <th>Avg Profit Sold</th>
          <th>Per Trade Sold</th>
          <th>Avg Open/LTh</th>
          <th>Total Open/LTh Order</th>
          <th>Total Other Status</th>
          <th>Avg 5h Max Avg Price</th>
          <th>Avg 5h Min Avg Price</th>
          <th>Avg 10h Max Avg Price</th>
          <th>Avg 10h Min Avg Price</th>
          <th>Less Than 1% </th>
          <!-- <th>1% or Greater </th> -->
          <th>1.5% or Greater </th>
          <th>2% or Greater </th>
          <th>2.5% or Greater</th>
          <th>3% or Greater</th>
          <?php if($filter_user_data['checkBoxFilterMax']== 'max'){?>
            <th>Max</th>
          <?php } if($filter_user_data['checkBoxFilterMin']== 'min'){?>
            <th>Min</th>
          <?php } if($filter_user_data['checkBoxFiltercurrent']== 'current'){?>
            <th>Currrent</th>
          <?php } if($filter_user_data['checkBoxFilterstatus'] == 'status'){ ?>
            <th>Start To End Status</th>
          <?php } ?>
        </tr>
      </thead>
      <tbody>
            <?php
            $count = 0;
            sort($full_arry);
            foreach ($full_arry as  $coin_array){
            ?>
                <tr style="text-align:center;"> 
                  <?php
                    // $completion_total_new = $coin_array['open_lth'] + $coin_array['other_status'] + $coin_array['sold_orders'];
                    // if($coin_array['sold_orders'] == 0){
                    //   $compeletion_bar = 0;
                    // }elseif( ($coin_array['open_lth'] + $coin_array['other_status'] ) == 0){
                    //   $compeletion_bar = 100;
                    // }else{
                    //   $compeletion_bar = ($coin_array['sold_orders'] / $completion_total_new )*100;
                    // }
                    $compeletion_bar = $coin_array['completionBar'];
                  ?>
                  <td>
                    <?=$coin_array['searchFilter'];?>
                    <br>
                    <?=$coin_array['level'];?>
                  </td>  
                  <td><?=$coin_array['countOpportunity'];?></td> 
                  <td>
                    <?php if($coin_array['open_lth'] == 0 && $coin_array['other_status'] == 0 &&  $coin_array['sold_orders'] == 0){?>
                      <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:100%;border-radius:3px;color:black">
                        oops Missed
                      </div>
                    <?php } elseif($compeletion_bar >= 0 && $compeletion_bar <= 70 ){?>
                      <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $compeletion_bar;?>%;border-radius:3px;color:black">
                        <?php echo number_format($compeletion_bar, 2)."%";?>
                      </div>
                    <?php } elseif($compeletion_bar > 70 && $compeletion_bar <= 85){?>  
                      <div class="progress-bar progress-bar-striped active progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $compeletion_bar;?>%;border-radius:3px;color:black">
                        <?php echo number_format($compeletion_bar, 2)."%";?>
                      </div>
                    <?php } elseif($compeletion_bar > 85 && $compeletion_bar <= 90){?>  
                      <div class="progress-bar progress-bar-striped active progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $compeletion_bar;?>%;border-radius:3px;color:black">
                        <?php echo number_format($compeletion_bar, 2)."%";?>
                      </div>
                    <?php } elseif($compeletion_bar > 90){?>  
                      <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $compeletion_bar;?>%;border-radius:3px;color:black">
                        <?php echo number_format($compeletion_bar, 2)."%";?>
                      </div> 
                    <?php } ?> 
                  </td>  
                  <td><?=$coin_array['sold_orders'];?></td>
                  <td>
                    <?php if($coin_array['avg_sold'] == null || $coin_array['avg_sold']== "" || is_nan($coin_array['avg_sold']) || !isset($coin_array['avg_sold'])){
                      $soldAvg = 0;
                    }else{
                      $soldAvg = $coin_array['avg_sold'];
                    }  
                    ?>
                    <?php if($soldAvg >=1.1){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo $soldAvg/4;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">
                      <strong><?php echo number_format($soldAvg, 2);?>%</strong>
                    </div> <?php } elseif($soldAvg >= 0 && $soldAvg< 1.1 ){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo $soldAvg/4;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(255, 195, 0) &quot;}">      
                      <strong><?php echo number_format($soldAvg, 2);?>%</strong>
                    </div> <?php } elseif($soldAvg < 0){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo $soldAvg/-4;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                      <strong><?php echo number_format($soldAvg, 2);?>%</strong>
                    </div><?php } ?>
                    <br>
                  </td>

                  <td>
                    <?php if($coin_array['per_trade_sold'] == null || $coin_array['per_trade_sold']== "" || is_nan($coin_array['per_trade_sold']) || !isset($coin_array['per_trade_sold'])){
                      $PerTradeSold = 0;
                    }else{
                      $PerTradeSold = $coin_array['per_trade_sold'];
                    }  
                    ?>
                    <?php if($PerTradeSold >=1.1){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo $PerTradeSold/4;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">
                      <strong><?php echo number_format($PerTradeSold, 2);?>%</strong>
                    </div> <?php } elseif($PerTradeSold >= 0 && $PerTradeSold< 1.1 ){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo $PerTradeSold/4;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(255, 195, 0) &quot;}">      
                      <strong><?php echo number_format($PerTradeSold, 2);?>%</strong>
                    </div> <?php } elseif($PerTradeSold < 0){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo $PerTradeSold/-4;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                      <strong><?php echo number_format($PerTradeSold, 2);?>%</strong>
                    </div><?php } ?>
                    <br>
                  </td>

                  <td>
                    <?php if($coin_array['avg_open_lth'] == null || $coin_array['avg_open_lth']== "" || is_nan($coin_array['avg_open_lth']) || !isset($coin_array['avg_open_lth'])){
                        $openLthAvg = 0;
                      }else{
                        $openLthAvg = $coin_array['avg_open_lth'];
                      }  
                    ?>
                    <?php if($openLthAvg >=1.1){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo $openLthAvg/4;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">
                      <strong><?php echo number_format($openLthAvg, 2);?>%</strong>
                    </div> <?php } elseif($openLthAvg >= 0 && $openLthAvg< 1.1 ){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo $openLthAvg/4;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(255, 195, 0) &quot;}">      
                      <strong><?php echo number_format($openLthAvg, 2);?>%</strong>
                    </div> <?php } elseif($openLthAvg < 0){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo $openLthAvg/-4;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                      <strong><?php echo number_format($openLthAvg, 2);?>%</strong>
                    </div><?php } ?>
                  </td>
                  <td><?=$coin_array['open_lth'];?></td>
                  <td><?=$coin_array['other_status'];?></td>
                  
                  <td>
                    <?php if(is_infinite($coin_array['5_max_value']) || $coin_array['5_max_value'] == null || $coin_array['5_max_value']== "" || is_nan($coin_array['5_max_value']) || !isset($coin_array['5_max_value'])){
                            $fiveMaxValue = 0;
                          }else{
                            $fiveMaxValue = number_format($coin_array['5_max_value'],2);
                          }  
                    if($fiveMaxValue >=0){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo $fiveMaxValue/5;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">
                      <strong><span><?php echo $fiveMaxValue;?>%</span></strong>
                    </div> <?php } elseif( $fiveMaxValue < 0){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo  $fiveMaxValue/-5;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                      <strong><span><?php echo  $fiveMaxValue;?>%</span></strong>
                    </div><?php } ?>
                  </td>
                  <td>

                  <?php if(is_infinite($coin_array['5_min_value']) || $coin_array['5_min_value'] == null || $coin_array['5_min_value']== "" || is_nan($coin_array['5_min_value']) || !isset($coin_array['5_min_value'])){
                            $fiveMinValue = 0;
                          }else{
                            $fiveMinValue = number_format($coin_array['5_min_value'],2);
                          } 
                    if($fiveMinValue >=0){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo $fiveMinValue/5;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">
                      <strong><span><?php echo $fiveMinValue;?>%</span></strong>
                    </div> <?php } elseif( $fiveMinValue < 0){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo  $fiveMinValue/-5;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                      <strong><span><?php echo  $fiveMinValue;?>%</span></strong>
                    </div><?php } ?>
                  </td>   
                  <td>
                   <?php if(is_infinite($coin_array['10_max_value']) ||$coin_array['10_max_value'] == null || $coin_array['10_max_value']== "" || is_nan($coin_array['10_max_value']) || !isset($coin_array['10_max_value'])){
                            $tenMaxValue = 0;
                          }else{
                            $tenMaxValue = number_format($coin_array['10_max_value'],2);
                          } 
                    if($tenMaxValue >=0){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo $tenMaxValue/5;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">
                      <strong><span><?php echo $tenMaxValue;?>%</span></strong>
                    </div> <?php } elseif( $tenMaxValue < 0){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo  $tenMaxValue/-5;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                      <strong><span><?php echo  $tenMaxValue;?>%</span></strong>
                    </div><?php } ?>
                  </td>
                  <td> 

                   <?php if(is_infinite($coin_array['10_min_value']) || $coin_array['10_min_value'] == null || $coin_array['10_min_value']== "" || is_nan($coin_array['10_min_value']) || !isset($coin_array['10_min_value'])){
                            $tenMinValue = 0;
                          }else{
                            $tenMinValue = number_format($coin_array['10_min_value'],2);
                          } 
                    if($tenMinValue >=0){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo $tenMinValue/5;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">
                      <strong><span><?php echo $tenMinValue;?>%</span></strong>
                    </div> <?php } elseif( $tenMinValue < 0){ ?>
                      <div class="circle" id="circle-a" data-value="<?php echo  $tenMinValue/-5;?>" data-fill="{
                      &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}">
                      <strong><span><?php echo  $tenMinValue;?>%</span></strong>
                    </div><?php } ?>
                  </td>

                  <?php if($filter_user_data['resultDisplay'] == 'five'){?>       
                    <td>                        
                      <?php $perOneLessPerMax = number_format($coin_array['perOneLessPerMax'],2); 
                       if($perOneLessPerMax >= 0 && $perOneLessPerMax < 30 ){?>
                        <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perOneLessPerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($perOneLessPerMax, 2)."%";?>
                        </div>
                      <?php } elseif($perOneLessPerMax >= 30 && $perOneLessPerMax < 50){?>  
                        <div class="progress-bar progress-bar-striped active progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perOneLessPerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($perOneLessPerMax, 2)."%";?>
                        </div>
                      <?php } elseif($perOneLessPerMax >= 50 && $perOneLessPerMax < 70){?>  
                        <div class="progress-bar progress-bar-striped active progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perOneLessPerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($perOneLessPerMax, 2)."%";?>
                        </div>
                      <?php } elseif($perOneLessPerMax >= 70){?>  
                        <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perOneLessPerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($perOneLessPerMax, 2)."%";?>
                        </div> 
                      <?php } ?> 
                      <!-- <br>
                      <span class="label label-info"><?php echo "Count: ".$coin_array['countOneLessPerMax'];?></span> -->
                    </td>  
                    <td>  
                      <?php $perOneHalfPerMax = number_format($coin_array['perOneHalfPerMax'],2); 
                        if($perOneHalfPerMax >= 0 && $perOneHalfPerMax < 30 ){?>
                          <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perOneHalfPerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($perOneHalfPerMax, 2)."%";?>
                          </div>
                      <?php } elseif($perOneHalfPerMax >= 30 && $perOneHalfPerMax < 50){?>  
                          <div class="progress-bar progress-bar-striped active progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perOneHalfPerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($perOneHalfPerMax, 2)."%";?>
                          </div>
                      <?php } elseif($perOneHalfPerMax >= 50 && $perOneHalfPerMax < 70){?>  
                          <div class="progress-bar progress-bar-striped active progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perOneHalfPerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($perOneHalfPerMax, 2)."%";?>
                          </div>
                      <?php } elseif($perOneHalfPerMax >= 70){?>  
                          <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perOneHalfPerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($perOneHalfPerMax, 2)."%";?>
                          </div> 
                      <?php } ?> 
                      <!-- <br>
                        <span class="label label-info"><?php echo "Count: ".$coin_array['countOneHalfPerMax'];?></span> -->
                    </td>  

                    <td>    
                      <?php $perTwoPerMax = number_format($coin_array['perTwoPerMax'],2); 
                        if($perTwoPerMax >= 0 && $perTwoPerMax < 30 ){?>
                          <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perTwoPerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($perTwoPerMax, 2)."%";?>
                          </div>
                      <?php } elseif($perTwoPerMax >= 30 && $perTwoPerMax < 50){?>  
                          <div class="progress-bar progress-bar-striped active progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perTwoPerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($perTwoPerMax, 2)."%";?>
                          </div>
                      <?php } elseif($perTwoPerMax >= 50 && $perTwoPerMax < 70){?>  
                          <div class="progress-bar progress-bar-striped active progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perTwoPerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($perTwoPerMax, 2)."%";?>
                          </div>
                      <?php } elseif($perTwoPerMax >= 70){?>  
                          <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perTwoPerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($perTwoPerMax, 2)."%";?>
                          </div> 
                      <?php } ?> 
                      <!-- <br>
                        <span class="label label-info"><?php echo "Count: ".$coin_array['countTwoPerMax'];?></span> -->
                    </td>  
                  
                    <td> 
                      <?php $perTwoHalfPerMax = number_format($coin_array['perTwoHalfPerMax'],2); 
                          if($perTwoHalfPerMax >= 0 && $perTwoHalfPerMax < 30 ){?>
                            <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perTwoHalfPerMax;?>%;border-radius:3px;color:black">
                              <?php echo number_format($perTwoHalfPerMax, 2)."%";?>
                            </div>
                        <?php } elseif($perTwoHalfPerMax >= 30 && $perTwoHalfPerMax < 50){?>  
                            <div class="progress-bar progress-bar-striped active progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perTwoHalfPerMax;?>%;border-radius:3px;color:black">
                              <?php echo number_format($perTwoHalfPerMax, 2)."%";?>
                            </div>
                        <?php } elseif($perTwoHalfPerMax >= 50 && $perTwoHalfPerMax < 70){?>  
                            <div class="progress-bar progress-bar-striped active progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perTwoHalfPerMax;?>%;border-radius:3px;color:black">
                              <?php echo number_format($perTwoHalfPerMax, 2)."%";?>
                            </div>
                        <?php } elseif($perTwoHalfPerMax >= 70){?>  
                            <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perTwoHalfPerMax;?>%;border-radius:3px;color:black">
                              <?php echo number_format($perTwoHalfPerMax, 2)."%";?>
                            </div> 
                        <?php } ?> 
                        <!-- <br>
                        <span class="label label-info"><?php echo "Count: ".$coin_array['countTwoHalfPerMax'];?></span> -->
                    </td>

                    <td> 
                      <?php $perThreePerMax = number_format($coin_array['perThreePerMax'],2); 
                        if($perThreePerMax >= 0 && $perThreePerMax < 30 ){?>
                          <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perThreePerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($perThreePerMax, 2)."%";?>
                          </div>
                      <?php } elseif($perThreePerMax >= 30 && $perThreePerMax < 50){?>  
                          <div class="progress-bar progress-bar-striped active progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perThreePerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($perThreePerMax, 2)."%";?>
                          </div>
                      <?php } elseif($perThreePerMax >= 50 && $perThreePerMax < 70){?>  
                          <div class="progress-bar progress-bar-striped active progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perThreePerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($perThreePerMax, 2)."%";?>
                          </div>
                      <?php } elseif($perThreePerMax >= 70){?>  
                          <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $perThreePerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($perThreePerMax, 2)."%";?>
                          </div> 
                      <?php } ?> 
                      <!-- <br>
                      <span class="label label-info"><?php echo "Count: ".$coin_array['countThreePerMax'];?></span> -->
                    </td>
                  <?php } else { ?>
                    <td>    
                      <?php $tenPerOneLessPerMax = number_format($coin_array['tenPerOneLessPerMax'],2); 
                        if($tenPerOneLessPerMax >= 0 && $tenPerOneLessPerMax < 30 ){?>
                          <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerOneLessPerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($tenPerOneLessPerMax, 2)."%";?>
                          </div>
                      <?php } elseif($tenPerOneLessPerMax >= 30 && $tenPerOneLessPerMax < 50){?>  
                          <div class="progress-bar progress-bar-striped active progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerOneLessPerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($tenPerOneLessPerMax, 2)."%";?>
                          </div>
                      <?php } elseif($tenPerOneLessPerMax >= 50 && $tenPerOneLessPerMax < 70){?>  
                          <div class="progress-bar progress-bar-striped active progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerOneLessPerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($tenPerOneLessPerMax, 2)."%";?>
                          </div>
                      <?php } elseif($tenPerOneLessPerMax >= 70){?>  
                          <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerOneLessPerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($tenPerOneLessPerMax, 2)."%";?>
                          </div> 
                      <?php } ?> 
                      <!-- <br>
                      <span class="label label-info"><?php echo "Count: ".$coin_array['tenCountOneLessPerMax'];?></span> -->
                    </td>  

                    <td>
                      <?php $tenPerOneHalfPerMax = number_format($coin_array['tenPerOneHalfPerMax'],2); 
                        if($tenPerOneHalfPerMax >= 0 && $tenPerOneHalfPerMax < 30 ){?>
                          <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerOneHalfPerMax;?>%;border-radius:3px;color:black">
                            <?php echo number_format($tenPerOneHalfPerMax, 2)."%";?>
                          </div>
                      <?php } elseif($tenPerOneHalfPerMax >= 30 && $tenPerOneHalfPerMax < 50){?>  
                        <div class="progress-bar progress-bar-striped active progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerOneHalfPerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($tenPerOneHalfPerMax, 2)."%";?>
                        </div>
                      <?php } elseif($tenPerOneHalfPerMax >= 50 && $tenPerOneHalfPerMax < 70){?>  
                        <div class="progress-bar progress-bar-striped active progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerOneHalfPerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($tenPerOneHalfPerMax, 2)."%";?>
                        </div>
                      <?php } elseif($tenPerOneHalfPerMax >= 70){?>  
                        <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerOneHalfPerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($tenPerOneHalfPerMax, 2)."%";?>
                        </div> 
                      <?php } ?> 
                      <!-- <br>
                      <span class="label label-info"><?php echo "Count: ".$coin_array['tenCountOneHalfPerMax'];?></span> -->
                    </td>  

                    <td>   
                      <?php $tenPerTwoPerMax = number_format($coin_array['tenPerTwoPerMax'],2); 
                      if($tenPerTwoPerMax >= 0 && $tenPerTwoPerMax < 30 ){?>
                        <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerTwoPerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($tenPerTwoPerMax, 2)."%";?>
                        </div>
                      <?php } elseif($tenPerTwoPerMax >= 30 && $tenPerTwoPerMax < 50){?>  
                        <div class="progress-bar progress-bar-striped active progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerTwoPerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($tenPerTwoPerMax, 2)."%";?>
                        </div>
                      <?php } elseif($tenPerTwoPerMax >= 50 && $tenPerTwoPerMax < 70){?>  
                        <div class="progress-bar progress-bar-striped active progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerTwoPerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($tenPerTwoPerMax, 2)."%";?>
                        </div>
                      <?php } elseif($tenPerTwoPerMax >= 70){?>  
                        <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerTwoPerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($tenPerTwoPerMax, 2)."%";?>
                        </div> 
                      <?php } ?> 
                      <!-- <br>
                      <span class="label label-info"><?php echo "Count: ".$coin_array['tenCountTwoPerMax'];?></span> -->
                    </td>  
                  
                    <td>  
                      <?php $tenPerTwoHalfPerMax = number_format($coin_array['tenPerTwoHalfPerMax'],2); 
                      if($tenPerTwoHalfPerMax >= 0 && $tenPerTwoHalfPerMax < 30 ){?>
                        <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerTwoHalfPerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($tenPerTwoHalfPerMax, 2)."%";?>
                        </div>
                      <?php } elseif($tenPerTwoHalfPerMax >= 30 && $tenPerTwoHalfPerMax < 50){?>  
                        <div class="progress-bar progress-bar-striped active progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerTwoHalfPerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($tenPerTwoHalfPerMax, 2)."%";?>
                        </div>
                      <?php } elseif($tenPerTwoHalfPerMax >= 50 && $tenPerTwoHalfPerMax < 70){?>  
                        <div class="progress-bar progress-bar-striped active progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerTwoHalfPerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($tenPerTwoHalfPerMax, 2)."%";?>
                        </div>
                      <?php } elseif($tenPerTwoHalfPerMax >= 70){?>  
                        <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerTwoHalfPerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($tenPerTwoHalfPerMax, 2)."%";?>
                        </div> 
                      <?php } ?> 
                      <!-- <br>
                      <span class="label label-info"><?php echo "Count: ".$coin_array['tenCountTwoHalfPerMax'];?></span> -->
                    </td>

                    <td>       
                      <?php $tenPerThreePerMax = number_format($coin_array['tenPerThreePerMax'],2); 
                      if($tenPerThreePerMax >= 0 && $tenPerThreePerMax < 30 ){?>
                        <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerThreePerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($tenPerThreePerMax, 2)."%";?>
                        </div>
                      <?php } elseif($tenPerThreePerMax >= 30 && $tenPerThreePerMax < 50){?>  
                        <div class="progress-bar progress-bar-striped active progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerThreePerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($tenPerThreePerMax, 2)."%";?>
                        </div>
                      <?php } elseif($tenPerThreePerMax >= 50 && $tenPerThreePerMax < 70){?>  
                        <div class="progress-bar progress-bar-striped active progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerThreePerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($tenPerThreePerMax, 2)."%";?>
                        </div>
                      <?php } elseif($tenPerThreePerMax >= 70){?>  
                        <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:<?php echo $tenPerThreePerMax;?>%;border-radius:3px;color:black">
                          <?php echo number_format($tenPerThreePerMax, 2)."%";?>
                        </div> 
                      <?php } ?> 
                      <!-- <br>
                      <span class="label label-info"><?php echo "Count: ".$coin_array['tenCountThreePerMax'];?></span> -->
                    </td>
                  <?php } ?>

                  <?php if($filter_user_data['checkBoxFilterMax']== 'max'){?>
                    <td>    
                      <?php if($coin_array['maxOverAll'] > 0 ){ ?>
                        <span style="color: green; font-weight:bold"><?=number_format($coin_array['maxOverAll'],2)."%";?> </span>
                      <?php } else {?>
                        <span style="color: red; font-weight:bold"><?=number_format($coin_array['maxOverAll'],2)."%";?> </span>
                      <?php } ?>
                    </td>
                  <?php } if($filter_user_data['checkBoxFilterMin']== 'min'){?>
                    <td>  

                      <?php if($coin_array['minOverAll'] > 0 ){ ?>
                        <span style="color: green; font-weight:bold"><?=number_format($coin_array['minOverAll'],2)."%";?> </span>
                      <?php } else {?>
                        <span style="color: red; font-weight:bold"><?=number_format($coin_array['minOverAll'],2)."%";?> </span>
                      <?php } ?>

                    </td>
                  <?php } if($filter_user_data['checkBoxFiltercurrent'] == 'current'){?>
                    <td>         
                      <?php if($coin_array['currentAvg'] > 0 ){ ?>
                          <span style="color: green; font-weight:bold"><?=number_format($coin_array['currentAvg'],2)."%";?> </span>
                        <?php } else {?>
                          <span style="color: red; font-weight:bold"><?=number_format($coin_array['currentAvg'],2)."%";?> </span>
                        <?php } ?>
                    </td>
                    
                  <?php } if($filter_user_data['checkBoxFilterstatus'] == 'status'){?>
                    <td>
                      <?php if($coin_array['status'] > 0 ){ ?>
                          <span style="color: green; font-weight:bold"><?=number_format($coin_array['status'],2)."%";?> </span>
                        <?php } else {?>
                          <span style="color: red; font-weight:bold"><?=number_format($coin_array['status'],2)."%";?> </span>
                      <?php } ?>
                    </td> 
                  <?php } ?>
                </tr>
                <?php $count++; } ?>
                </tbody>
              </table>
          </div>
        <!-- // Table END -->
      </div>
        <?php
        // $a = 1;
        // $b =10;
        $tempArr = [];
        $tempArr2 = [];
        $tempArr3 = [];
        // $count = 0;
        $coinsArr = [];
        $coinsArr2 = [];
        $coinsArr3 = [];
        foreach ($full_arry as  $key=>$level){
          $coinName = $level['searchFilter'];
          $coinsArr[] = $coinName;

          $coinName2 = $level['searchFilter'];
          $coinsArr2[] = $coinName;

          $coinName3 = $level['searchFilter'];
          $coinsArr3[] = $coinName;

          if($filter_user_data['resultDisplay'] == 'five'){ 
            $tempArr[$coinName][] = ["y" => number_format($level[$filter_user_data['maxMin']],2), "label" => $coinName];

            $tempArr2[$coinName2][] = ["x" => number_format($level[$filter_user_data['maxMin']],2), "y" => number_format($level['avg_sold'], 2),  "z" => number_format($level['avg_sold'], 2),  "label" => $coinName2];
            $tempArr3[$coinName3][] = ["x" => number_format($level[$filter_user_data['maxMin']],2), "y" => number_format($level['avg_sold'], 2)];
          }else{
            $variableName = str_replace("p","tenP", $filter_user_data['maxMin']); 
            $tempArr[$coinName][] = ["y" => number_format($level[$variableName],2), "label" => $coinName];
            $tempArr3[$coinName3][] = ["x" => number_format($level[$variableName],2), "y" => number_format($level['avg_sold'], 2)];
            $tempArr2[$coinName2][] = ["x" => number_format($level[$variableName],2), "y" => number_format($level['avg_sold'], 2), "z" => number_format($level['avg_sold'], 2), "label" => $coinName2];
          }
        }
        $tempArr[$coinName][] = ["y" => 100, "label" => "testing"];
        $dataPoints = [];
        $dataPoints3 = [];
        $dataPoints2 = [];
        foreach($coinsArr as $coin){
          $dataPoints = array_merge($dataPoints, $tempArr[$coin]); 
          $dataPoints2 = array_merge($dataPoints2, $tempArr2[$coin]); 
          $dataPoints3 = array_merge($dataPoints3, $tempArr3[$coin]); 
        }
        // echo json_encode($dataPoints2, JSON_NUMERIC_CHECK);
        ?> 
      <script>
        window.onload = function() {
          var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title:{
            text: "Max Min Prices Percentages"
            },
            axisY: {
              title: "",
              includeZero: true,
              suffix:  "%"
            },
            data: [{
              type: "bar",
              yValueFormatString: "",
              indexLabel: "{y}",
              indexLabelPlacement: "inside",
              indexLabelFontColor: "black",
              dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK);?>
            }]
          });
        // bubble chart
      var chart2 = new CanvasJS.Chart("chartContainer2", {
        animationEnabled: true,
        title:{
          text: "Purchased Price Vs count"
        },
        axisX: {
          title:"five/ten Hours Count"
        },
        axisY: {
          title:"Avg Sold",
          includeZero: true
        },
        legend:{
          horizontalAlign: "left"
        },
        data: [{
          type: "bubble",
          showInLegend: true,
          legendText: "",
          legendMarkerType: "circle",
          legendMarkerColor: "grey",

          toolTipContent: "<b>{label}</b><br/>Five/ten Hr: {x}<br/>Avg Sold: {y}",
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK);?>
        }]
      });

        // scatterd chart
        var chart3 = new CanvasJS.Chart("chartContainer3",
          {
          title:{
            text: "purchase Prices VS coin price"
          },

          data: [
          {
          type: "scatter",
          dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK);?>
        }
        ]
      });
      chart.render();
      chart2.render();
      chart3.render();
    }
  </script>
      <div id="chartContainer"  style="height: 100%; width: 100%;"></div>
      <div id="chartContainer2" style="height: 100%; width: 100%;padding-top: 30%"></div>
      <div id="chartContainer3" style="height: 100%; width: 100%;padding-top: 30%"></div>
      <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
      </div>
    </div>

<!-- The modal -->

<!-- Start Model -->

<!-- End Model -->

<!-- Start Model -->

<!-- End Model -->
<script type="text/javascript">

function passwordCheck(){
  $.confirm({
    title: 'Prompt!',
    content: '' +
    '<form action="" class="formName">' +
    '<div class="form-group">' +
    '<label>Enter something here</label>' +
    '<input type="text" placeholder="Please Enter Pin" class="name form-control" required />' +
    '</div>' +
    '</form>',
    buttons: {
        formSubmit: {
            text: 'Submit',
            btnClass: 'btn-blue',
            action: function () {
                var name = this.$content.find('.name').val();
                if(!name){
                    $.alert('provide a valid name');
                    return false;
                }else{
                  if (name == '7869') {
                    $.alert('You are authorized to view this page');
                  }else{
                    window.location.href = "<?php echo SURL; ?>forbidden/"
                  }
                }

            }
        },
        cancel: function () {
            //close
        },
    },
    onContentReady: function () {
        // bind to events
        var jc = this;
        this.$content.find('form').on('submit', function (e) {
            // if the user submits the form by pressing enter in the field.
            e.preventDefault();
            jc.$$formSubmit.trigger('click'); // reference the button and click it
        });
    }
});
}
$(document).ready(function(e){
  //passwordCheck()
});

</script>
<script>
  $(document).ready(function(){
    var query = $("#filter_by_search").val();
    if (query == 'level') {
      $("#filter_by_level").show();
      $("#filter_by_coin").hide();
    }else if(query == 'coin'){
      $("#filter_by_coin").show();
      $("#filter_by_level").hide();
    }else if(query == 'both'){
      $("#filter_by_coin").show();
      $("#filter_by_level").show();
    }else if(query == 'levelWise'){
      $("#filter_by_coin").show();
      $("#filter_by_level").show();
    }else{
      $("#filter_by_coin").hide();
      $("#filter_by_level").hide();
    }
  });

  $(document).change(function(){
    var query = $("#filter_by_search").val();
    if (query == 'level') {
      $("#filter_by_level").show();
      $("#filter_by_coin").hide();
    }else if(query == 'coin'){
      $("#filter_by_coin").show();
      $("#filter_by_level").hide();
    }else if(query == 'both'){
      $("#filter_by_coin").show();
      $("#filter_by_level").show();
    }else if(query == 'levelWise'){
      $("#filter_by_coin").show();
      $("#filter_by_level").show();
    }else{
      $("#filter_by_coin").hide();
      $("#filter_by_level").hide();
    }
  });



$("body").on("click",".glassflter",function(e){
  var query = $("#filter_by_name").val();
  window.location.href = "<?php echo SURL; ?>/admin/users/?query="+query;
});

$("body").on("click",".viewadmininfo",function(e){
  var user_id = $(this).attr('id');
  $.ajax({
    url: "<?php echo SURL; ?>admin/reports/get_user_info",
    data: {user_id:user_id},
    type: "POST",
    success: function(response){
        $("#mymodalresp").html(response);
    }
    });
});

$("body").on("click",".view_order_details",function(e){
    var order_id = $(this).attr("data-id");
      $.ajax({
        'url': '<?php echo SURL ?>admin/dashboard/get_buy_order_details_ajax',
        'type': 'POST',
        'data': {order_id:order_id},
        'success': function (response) {
            $('#response_order_details').html(response);
            $("#modal-order_details").modal('show');
        }
    });
});
</script>

    <script type="text/javascript">
      $(document).ready(function() {
        $('#filter_by_coin_select, #filter_by_level_select').multiselect({
          includeSelectAllOption: true,
          buttonWidth: 435.7,
          enableFiltering: true
        });
      });
    </script> 

<script>
  $( function() {
    availableTags = [];
    $.ajax({
       'url': '<?php echo SURL ?>admin/reports/get_all_usernames_ajax',
       'type': 'POST',
       'data': "",
       'success': function (response) {
          availableTags = JSON.parse(response);

          $( "#username" ).autocomplete({
            source: availableTags
          });
       }
   });

  });
  //Custom switcher by Afzal
  jQuery("body").on("change","#af-swith-asc",function(){
	if(jQuery(".af-switcher-default").hasClass("active")){
		jQuery(".af-switcher-default").removeClass("active");
	}
	else{
		jQuery(".af-switcher-default").addClass("active");
	}
	});
	jQuery("body").on("click",".af-switcher-default",function(){
		if(jQuery(".af-switcher-default").hasClass("active")){
			jQuery(".af-switcher-default").removeClass("active");
		}
		else{
			jQuery(".af-switcher-default").addClass("active");
		}
	});
  jQuery("body").on("change",".af-cust-radio",function(){
		jQuery(".af-form-group-created").addClass("active");
	});
  //----End--------
  </script>

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
    function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}

function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");

    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++)
            row.push(cols[j].innerText);

        csv.push(row.join(","));
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}
  </script>

  <script src="assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script> 
    <script type="text/javascript">
      $(document).ready(function() {
        $('#dataTable').dataTable({
          "pageLength": 100,
          "iDisplayLength": 25,
        });
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

 