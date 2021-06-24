<link href="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.css" rel="stylesheet">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="<?php echo ASSETS ?>buyer_order/moment-with-locales.js"></script>
  <script src="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.js"></script>
  <script type="text/javascript" src="<?php  echo SURL ?>assets/dist/jquery-asPieProgress.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>       
   <!--  for pie chart script   -->

  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css'>
  <link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.2.2/css/buttons.bootstrap.min.css'>
  <script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-de7e2ef6bfefd24b79a3f68b414b87b8db5b08439cac3f1012092b2290c719cd.js"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
  <script src='https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js'></script>
  <script src='https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js'></script>
  <script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js'></script>
  <script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js'></script>
  <script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js'></script>
  <script src='https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js'></script>
  <script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.bootstrap.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js'></script>
  <script src='https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js'></script>
  <script src='https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js'></script>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
  
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

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
    .ax_2, .ax_3, .ax_4, .ax_5, .ax_6, .ax_7, .ax_8, .ax_9, .ax_10, .ax_11, .ax_12, .ax_13, .ax_14, .ax_15, .ax_16, .ax_17, .ax_18, .ax_19 {
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
  <h1 class="content-heading bg-white border-bottom">Reports</h1>
  <div class="innerAll bg-white border-bottom">
    <div class="pull-right" style="padding-right: 12px; padding-top: 8px;">
      <div class=" pull-right alert alert-warning" style=" margin-top: -10px; background: #5c678a;color: white;"> <?php echo date("F j, Y, g:i a").'&nbsp;&nbsp;  <b>'.date_default_timezone_get().' (GMT + 0)'.'<b />' ?></div>     

    </div>
    <ul class="menubar">
      <li class=""><a href="<?php echo SURL; ?>/admin/coins/coinSlippage">Reports</a></li>
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
  <?php $filter_data = $this->session->userdata('filterSlippageReport');?>    
  <div class="widget widget-inverse">
    <div class="widget-body">
      <form method="POST" action="<?php echo SURL; ?>admin/coins/coinSlippage">
        <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 ax_1">

            <div class="col-xs-12 col-sm-12 col-md-3 ax_2">
                <div class="Input_text_s">
                    <label>Filter Coin: </label>
                    <select id="filter_by_coin" multiple="multiple" name="filter_by_coin[]" type="text" class=" filter_by_name_margin_bottom_sm">
                    <?php foreach($coins as $coinRow){  ?>      
                    <option value="<?php echo $coinRow['symbol'] ?>" <?php if (in_array($coinRow['symbol'], $filter_data['filter_by_coin'])) {?> selected <?php }?>><?php echo $coinRow['symbol'] ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>


          <div class="col-xs-12 col-sm-12 col-md-3 ax_3">
            <div class="Input_text_s">
              <label>Exchange: </label>
              <select id="exchange" name="exchange" type="text" class="form-control filter_by_name_margin_bottom_sm">
                <option value="binance"<?=(($filter_data['exchange'] == "binance") ? "selected" : "")?>>Binance</option>
                <option value="bam"<?=(($filter_data['exchange'] == "bam") ? "selected" : "")?>>Bam</option>
                <option value="kraken"<?=(($filter_data['exchange'] == "kraken") ? "selected" : "")?>>kraken</option>
              </select>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-3 ax_4 filter_by_month"  style=" min-height: 60px;" id="filter_by_month">
          <div class="Input_text_s filter_by_month"   <?php if ($filter_user_data['group_filter'] == 'rule_group') {?> <?php  } else {?>  <?php  }?>>
            <label>Filter Month: </label>
            <select id="filter_by_month_select" name="filter_by_month[]" multiple="multiple" type="text" class="form-control filter_by_name_margin_bottom_sm filter_by_month">
              <option value="2020-01" <?php if (in_array('2020-01', $filter_data['filter_by_month'])) {?> selected <?php }?>> January   </option>
              <option value="2020-02" <?php if (in_array('2020-02', $filter_data['filter_by_month'])) {?> selected <?php }?>> February  </option>
              <option value="2020-03" <?php if (in_array('2020-03', $filter_data['filter_by_month'])) {?> selected <?php }?>> March     </option>
              <option value="2020-04" <?php if (in_array('2020-04', $filter_data['filter_by_month'])) {?> selected <?php }?>> April     </option>
              <option value="2020-05" <?php if (in_array('2020-05', $filter_data['filter_by_month'])) {?> selected <?php }?>> May       </option>
              <option value="2020-06" <?php if (in_array('2020-06', $filter_data['filter_by_month'])) {?> selected <?php }?>> June      </option>
              <option value="2020-07" <?php if (in_array('2020-07', $filter_data['filter_by_month'])) {?> selected <?php }?>> Jully     </option>
              <option value="2020-08" <?php if (in_array('2020-08', $filter_data['filter_by_month'])) {?> selected <?php }?>> August    </option>
              <option value="2020-09" <?php if (in_array('2020-09', $filter_data['filter_by_month'])) {?> selected <?php }?>> September </option>
              <option value="2020-10" <?php if (in_array('2020-10', $filter_data['filter_by_month'])) {?> selected <?php }?>> October   </option>
              <option value="2020-11" <?php if (in_array('2020-11', $filter_data['filter_by_month'])) {?> selected <?php }?>> November  </option>
              <option value="2020-12" <?php if (in_array('2020-12', $filter_data['filter_by_month'])) {?> selected <?php }?>> December  </option>
            </select>
          </div>
        </div> 

          <!-- <div class="col-xs-12 col-sm-12 col-md-3 ax_4">
            <div class="Input_text_s">
              <label>Mode: </label>
              <select id="mode" name="mode" type="text" class="form-control filter_by_name_margin_bottom_sm">
                <option value="live"<?=(($filter_data['mode'] == "live") ? "selected" : "")?>>Live</option>
                <option value="test"<?=(($filter_data['mode'] == "test") ? "selected" : "")?>>Test</option>
              </select>
            </div>
          </div>  -->

       <!-- <div class="col-xs-12 col-sm-12 col-md-3 ax_5">
          <div class="Input_text_s">
            <label>From Date Range: </label>
            <input id="filter_by_start_date" name="filter_by_start_date" type="datetime-local" class="form-control datetime_picker filter_by_name_margin_bottom_sm" placeholder="Search By Date" value="<?=(!empty($filter_data['filter_by_start_date']) ? $filter_data['filter_by_start_date'] : "")?>" autocomplete="off">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 ax_6">
          <div class="Input_text_s">
            <label>To Date Range: </label>
            <input id="filter_by_end_date" name="filter_by_end_date" type="datetime-local" class="form-control datetime_picker filter_by_name_margin_bottom_sm" placeholder="Search By Date" value="<?=(!empty($filter_data['filter_by_end_date']) ? $filter_data['filter_by_end_date'] : "")?>" autocomplete="off">
            </div>
        </div> -->

        <!-- <div class="col-xs-12 col-sm-12 col-md-3 ax_7">
          <div class="Input_text_s">
            <label>username: </label>
            <input id="userName" name="userName" type="text" class="form-control filter_by_name_margin_bottom_sm" placeholder="Search By username" value="<?=(!empty($filter_data['userName']) ? $filter_data['userName'] : "")?>">
          </div>
        </div> -->

        <!-- <div class="col-xs-12 col-sm-12 col-md-3 ax_8">
          <div class="Input_text_s">
            <label>Opportunity Id: </label>
            <input id="opportunityId" name="opportunityId" type="text" class="form-control filter_by_name_margin_bottom_sm" placeholder="Search By opportunity Id" value="<?=(!empty($filter_data['opportunityId']) ? $filter_data['opportunityId'] : "")?>">
          </div>
        </div> -->

        <!-- <div class="col-xs-12 col-sm-12 col-md-3 ax_9">
          <div class="Input_text_s">
            <label>Order Id: </label>
            <input id="orderId" name="orderId" type="text" class="form-control filter_by_name_margin_bottom_sm" placeholder="Search By order Id" value="<?=(!empty($filter_data['orderId']) ? $filter_data['orderId'] : "")?>">
          </div>
        </div> -->

<!-- 
        <div class="col-xs-12 col-sm-12 col-md-3  ax_10 filter_by_level"  style=" min-height: 60px;" id="filter_by_level">
          <div class="Input_text_s filter_by_level"   <?php if ($filter_user_data['group_filter'] == 'rule_group') {?> <?php  } else {?>  <?php  }?>>
            <label>Filter Level: </label>
            <select id="filter_by_level_select" name="filter_by_level[]" multiple="multiple" type="text" class="form-control filter_by_name_margin_bottom_sm filter_by_level">
              <option value="level_1" <?php if (in_array('level_1', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 1</option>
              <option value="level_2" <?php if (in_array('level_2', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 2</option>
              <option value="level_3" <?php if (in_array('level_3', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 3</option>
              <option value="level_4" <?php if (in_array('level_4', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 4</option>
              <option value="level_5" <?php if (in_array('level_5', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 5</option>
              <option value="level_6" <?php if (in_array('level_6', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 6</option>
              <option value="level_7" <?php if (in_array('level_7', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 7</option>
              <option value="level_8" <?php if (in_array('level_8', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 8</option>
              <option value="level_9" <?php if (in_array('level_9', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 9</option>
              <option value="level_10"<?php if (in_array('level_10', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 10</option>
              <option value="level_11"<?php if (in_array('level_11', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 11</option>
              <option value="level_12"<?php if (in_array('level_12', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 12</option>
              <option value="level_13"<?php if (in_array('level_13', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 13</option>
              <option value="level_14"<?php if (in_array('level_14', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 14</option>
              <option value="level_15"<?php if (in_array('level_15', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 15</option>
              <option value="level_16"<?php if (in_array('level_16', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 16</option>
              <option value="level_17"<?php if (in_array('level_17', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 17</option>
              <option value="level_18"<?php if (in_array('level_18', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 18</option>
              <option value="level_19"<?php if (in_array('level_19', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 19</option>
              <option value="level_20"<?php if (in_array('level_20', $filter_data['filter_by_level'])) {?> selected <?php }?>>Level 20</option>
            </select>
          </div>
        </div> -->

        <div class="col-xs-12 col-sm-12 col-md-2 ax_11">
          <div class="Input_text_btn">
            <label></label>
            <button id="submit-form" class="btn btn-success"><i class="glyphicon glyphicon-filter"></i>Search</button>
            <a href="<?php echo SURL; ?>admin/coins/resetSlippageReport"class="btn btn-danger">Reset</a>
            </span>   
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
            /* z-index: 2222; */
            transform: translate(-50%, -50%);
            font-size: 15px;
            color: black;

            
        }
  
    /* Pie chart CSS start*/
    *, *::after, *::before {
    box-sizing: border-box;
  }

  .donut {
    --donut-size: 90px;
    --donut-border-width: 15px;
    --donut-spacing: 0;
    --donut-spacing-color: 255, 255, 255;
    --donut-spacing-deg: calc(1deg * var(--donut-spacing));
    border-radius: 25%;
    height: var(--donut-size);

    position: relative;
    width: var(--donut-size);
  }

  .donut__slice {
    height: 100%;
    position: absolute;
    width: 100%;
  }
  .donut__slice::before,
  .donut__slice::after {
    border: var(--donut-border-width) solid rgba(0, 0, 0, 0);
    border-radius: 50%;
    content: '';
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
    width: 100%;
  }

  .donut__slice::before {
    border-width: calc(var(--donut-border-width) + 1px);
    box-shadow: 0 0 1px 0 rgba(var(--donut-spacing-color), calc(100 * var(--donut-spacing)));
  }

  .donut__slice__first {
    --first-start: 0;
  }

  .donut__slice__first::before {
    border-top-color: rgba(var(--donut-spacing-color), calc(100 * var(--donut-spacing)));
    -webkit-transform: rotate(calc(360deg * var(--first-start) + 45deg));
            transform: rotate(calc(360deg * var(--first-start) + 45deg));
  }

  .donut__slice__first::after {
    border-top-color: #ff6838;
    border-right-color: rgba(255, 104, 56, calc(100 * (var(--first) - .25)));
    border-bottom-color: rgba(255, 104, 56, calc(100 * (var(--first) - .5)));
    border-left-color: rgba(255, 104, 56, calc(100 * (var(--first) - .75)));
    -webkit-transform: rotate(calc(360deg * var(--first-start) + 45deg + var(--donut-spacing-deg)));
            transform: rotate(calc(360deg * var(--first-start) + 45deg + var(--donut-spacing-deg)));
  }

  .donut__slice__second {
    --second-start: calc(var(--first));
    --second-check: max(calc(var(--second-start) - .5), 0);
    -webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
            clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
  }

  .donut__slice__second::before {
    border-top-color: rgba(var(--donut-spacing-color), calc(100 * var(--donut-spacing)));
    -webkit-transform: rotate(calc(360deg * var(--second-start) + 45deg));
            transform: rotate(calc(360deg * var(--second-start) + 45deg));
  }

  .donut__slice__second::after {
    border-top-color: #ffc820;
    border-right-color: rgba(255, 200, 32, calc(100 * (var(--second) - .25)));
    border-bottom-color: rgba(255, 200, 32, calc(100 * (var(--second) - .5)));
    border-left-color: rgba(255, 200, 32, calc(100 * (var(--second) - .75)));
    -webkit-transform: rotate(calc(360deg * var(--second-start) + 45deg + var(--donut-spacing-deg)));
            transform: rotate(calc(360deg * var(--second-start) + 45deg + var(--donut-spacing-deg)));
  }

  .donut__slice__third {
    --third-start: calc(var(--first) + var(--second));
    --third-check: max(calc(var(--third-start) - .5), 0);
    -webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
            clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
  }

  .donut__slice__third::before {
    border-top-color: rgba(var(--donut-spacing-color), calc(100 * var(--donut-spacing)));
    -webkit-transform: rotate(calc(360deg * var(--third-start) + 45deg));
            transform: rotate(calc(360deg * var(--third-start) + 45deg));
  }

  .donut__slice__third::after {
    border-top-color: #97c95c;
    border-right-color: rgba(151, 201, 92, calc(100 * (var(--third) - .25)));
    border-bottom-color: rgba(151, 201, 92, calc(100 * (var(--third) - .5)));
    border-left-color: rgba(151, 201, 92, calc(100 * (var(--third) - .75)));
    -webkit-transform: rotate(calc(360deg * var(--third-start) + 45deg + var(--donut-spacing-deg)));
            transform: rotate(calc(360deg * var(--third-start) + 45deg + var(--donut-spacing-deg)));
    }
  .donut__slice__fourth {
    --fourth-start: calc(var(--first) + var(--second) + var(--third));
    --fourth-check: max(calc(var(--fourth-start) - .5), 0);
    -webkit-clip-path: inset(0 calc(50% * (var(--fourth-check) / var(--fourth-check))) 0 0);
            clip-path: inset(0 calc(50% * (var(--fourth-check) / var(--fourth-check))) 0 0);
  }

  .donut__slice__fourth::before {
    border-top-color: rgba(var(--donut-spacing-color), calc(100 * var(--donut-spacing)));
    -webkit-transform: rotate(calc(360deg * var(--fourth-start) + 45deg));
            transform: rotate(calc(360deg * var(--fourth-start) + 45deg));
  }

  .donut__slice__fourth::after {
    border-top-color: #1cb2f6;
    border-right-color: rgba(28, 178, 246, calc(100 * (var(--fourth) - .25)));
    border-bottom-color: rgba(28, 178, 246, calc(100 * (var(--fourth) - .5)));
    border-left-color: rgba(28, 178, 246, calc(100 * (var(--fourth) - .75)));
    -webkit-transform: rotate(calc(360deg * var(--fourth-start) + 45deg + var(--donut-spacing-deg)));
            transform: rotate(calc(360deg * var(--fourth-start) + 45deg + var(--donut-spacing-deg)));
  }

  /* pie chart CSS end */

  .blinking{
    animation:blinkingText 3s infinite;
  }

  /* css for flashing  */
  @keyframes blinkingText{
    0%{	background-color: red;	}
    49%{	color: transparent;	}
    50%{	color: transparent;	}
    99%{	color:transparent;	}
    100%{	color: #000;	}
  }

      html,
      body {
        height: 100%;
      }
      .dataTables_filter{
        float:right;
      }
      .paginate_disabled_previous{
        margin-right: 10%;
      }
      .paginate_enabled_next{
        margin-left: 10%;
      }
      .dataTables_length{
        margin-bottom: -1%;
      }
      body {
        -webkit-box-align: center;
                align-items: center;
        /* display: -webkit-box;
        display: flex; */
        flex-wrap: wrap;
        -webkit-box-pack: center;
                justify-content: center;
        }
  /* end flashing TD */
     td{
       vertical-align: middle !important;
     }

     .size{
     width: 170px; 
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
    <div class="widget-body padding-bottom-none col-xs-12 col-sm-12 col-md-12 ax_12">
        <!-- <table class=" table table-bordered table table-striped" id="datatable" width="100%">  -->
        <table class=" table table-bordered table table-striped" width="100%"> 
          <thead class="theadd">
            <th>#</th>
            <th><a href="#" data-toggle="tooltip" title="coin name">Coin</a></th>
            <th><a href="#" data-toggle="tooltip" title="">Sell Delay 0-14  </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Sell Delay 15-29 </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Sell Delay 29-44 </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Sell Delay 45-59 </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Sell Delay 60-74 </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Sell Delay 75-89 </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Sell Delay 90 or greater </a></th>

            <th><a href="#" data-toggle="tooltip" title="">Buy delay 0-14  </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Buy delay 15-29 </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Buy delay 29-44 </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Buy delay 45-59 </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Buy delay 60-74 </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Buy delay 75-89 </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Buy delay 90 or greater </a></th>

            <th><a href="#" data-toggle="tooltip" title="">Sell slippage -0.2 -- 0  </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Sell slippage -0.2 -- -0.3 </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Sell slippage -0.3 -- -0.5 </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Sell slippage -0.5 -- -0.75 </a></th>
            <th><a href="#" data-toggle="tooltip" title="">Sell slippage -1 or Less </a></th>

            <th><a href="#" data-toggle="tooltip" title="">Month</a></th>
            <th><a href="#" data-toggle="tooltip" title="">Action</a></th>
          </thead>
          <tbody>
            <?php  
            $time_zone = date_default_timezone_get();
            $this->load->helper('common_helper');
            $count = 1; 
            foreach ($orders as $key => $value) {?>
              <tr style="text-align:center;">
                <td><?php echo $count; $count++;?></td>
                <td><?php echo $value['coin'];?></td>
                <td><?php echo number_format($value['sellTimeDiffRange1'], 2)."%";?></td>
                <td><?php echo  number_format($value['sellTimeDiffRange2'], 2)."%";?></td>
                <td><?php echo  number_format($value['sellTimeDiffRange3'], 2)."%";?></td>
                <td><?php echo  number_format($value['sellTimeDiffRange4'], 2)."%";?></td>
                <td><?php echo  number_format($value['sellTimeDiffRange5'], 2)."%";?></td>
                <td><?php echo  number_format($value['sellTimeDiffRange6'], 2)."%";?></td>
                <td><?php echo  number_format($value['sellTimeDiffRange7'], 2)."%";?></td>

                <td><?php echo  number_format($value['buyTimeDiffRange1'], 2)."%";?></td>
                <td><?php echo  number_format($value['buyTimeDiffRange2'], 2)."%";?></td>
                <td><?php echo  number_format($value['buyTimeDiffRange3'], 2)."%";?></td>
                <td><?php echo  number_format($value['buyTimeDiffRange4'], 2)."%";?></td>
                <td><?php echo  number_format($value['buyTimeDiffRange5'], 2)."%";?></td>
                <td><?php echo  number_format($value['buyTimeDiffRange6'], 2)."%";?></td>
                <td><?php echo  number_format($value['buyTimeDiffRange7'], 2)."%";?></td>

                <td><?php echo  number_format($value['sumPLSllipageRange1'], 2)."%";?></td>
                <td><?php echo  number_format($value['sumPLSllipageRange2'], 2)."%";?></td>
                <td><?php echo  number_format($value['sumPLSllipageRange3'], 2)."%";?></td>
                <td><?php echo  number_format($value['sumPLSllipageRange4'], 2)."%";?></td>
                <td><?php echo  number_format($value['sumPLSllipageRange5'], 2)."%";?></td>

                <td><?php echo $value['month']; ?></td>

                  <?php
                    // if(isset($value['sell_market_price']) && $value['is_sell_order'] == 'sold' && $value['sell_market_price'] !="" && !is_string($value['sell_market_price'])){
                    //   $val1 = $value['market_sold_price'] - $value['sell_market_price']; 
                    //   $val2 = ($value['market_sold_price'] + $value['sell_market_price'])/ 2;
                    //   $slippageOrignalPercentage = ($val1/ $val2) * 100;
                    //   $slippageOrignalPercentage = round($slippageOrignalPercentage, 3) . '%';

                    //   if($slippageOrignalPercentage >= 0 ){
                    //     $class = 'success';
                    //   }else{
                    //     $class = 'danger';
                    //   }
                    // }else{
                    //   $class = 'default';
                    //   $slippageOrignalPercentage = '-';
                    // }
                    // echo '<span class="text-'.$class.'"><b>'.$slippageOrignalPercentage.'</b></span>';
                  ?>
              
                <td>---</td>
              </tr>
            <?php  }   ?>
          </tbody>
        </table>
        <div><?php echo $links; ?></div>
        <div><?php echo "Total: ".$total; ?></div>
  </div>
  </div>
  </div>
  </div>
</div>
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.1.3/circle-progress.min.js"></script> 
  <script>
    var progressBarOptions = {
      startAngle: -1,
      size: 60,
    };
    $('.circle').circleProgress(progressBarOptions).on('circle-animation-progress', function (event, progress, value){
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

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
      $(function() {
        availableTags = [];
        $.ajax({
          'url': '<?php echo SURL ?>admin/users_list/get_all_usernames_ajax',
          'type': 'POST',
          'data': "",
          'success': function (response) {
            availableTags = JSON.parse(response);
            $("#user_name").autocomplete({
              source: availableTags
            });
          }
        });
      });
    </script>

    <script type="text/javascript">
    
    //   $(document).ready(function() {
    //     var hCols = [3,4,6,7,8,9,14,15,21]; 
    //     $('#datatable').DataTable({
    //       "aLengthMenu": [[25, 50, 100, 500, -1], [25, 50, 100, 500, "All"]],
    //       "iDisplayLength": 100,
    //       "dom": "<'row'<'col-sm-4'B><'col-sm-2'l><'col-sm-6'p<br/>i>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12'p<br/>i>>",
    //       "paging": true,
         
    //       "buttons": [{
    //         extend: 'colvis',
    //         collectionLayout: 'three-column',
    //         text: function() {
    //           var totCols = $('#datatable thead th').length;
    //           var hiddenCols = hCols.length;
    //           var shownCols = totCols - hiddenCols;
    //           return 'Columns (' + shownCols + ' of ' + totCols + ')';
    //         },
    //         prefixButtons: [{
    //           extend: 'colvisGroup',
    //           text: 'Show all',
    //           show: ':hidden'
    //         }, {
    //           extend: 'colvisRestore',
    //           text: 'Restore'
    //         }]
    //       }, {
    //         extend: 'collection',
    //         text: 'Export',
    //         buttons: [{
    //             text: 'Excel',
    //             extend: 'excelHtml5',
    //             footer: false,
    //             exportOptions: {
    //               columns: ':visible'
    //             }
    //           }, {
    //             text: 'CSV',
    //             extend: 'csvHtml5',
    //             fieldSeparator: ';',
    //             exportOptions: {
    //               columns: ':visible'
    //             }
    //           }, {
    //             text: 'PDF Portrait',
    //             extend: 'pdfHtml5',
    //             message: '',
    //             exportOptions: {
    //               columns: ':visible'
    //             }
    //           }, {
    //             text: 'PDF Landscape',
    //             extend: 'pdfHtml5',
    //             message: '',
    //             orientation: 'landscape',
    //             exportOptions: {
    //               columns: ':visible'
    //             }
    //           }]
    //         }]
    //       ,oLanguage: {
    //           oPaginate: {
    //               sNext: '<span class="pagination-default">&#x276f;</span>',
    //               sPrevious: '<span class="pagination-default">&#x276e;</span>'
    //           }
    //       }
    //         ,"initComplete": function(settings, json) {
    //           // Adjust hidden columns counter text in button -->
    //           $('#datatable').on('column-visibility.dt', function(e, settings, column, state) {
    //             var visCols = $('#datatable thead tr:first th').length;
    //             //Below: The minus 2 because of the 2 extra buttons Show all and Restore
    //             var tblCols = $('.dt-button-collection li[aria-controls=datatable] a').length - 2;
    //             $('.buttons-colvis[aria-controls=datatable] span').html('Columns (' + visCols + ' of ' + tblCols + ')');
    //             e.stopPropagation();
    //           });
    //         }
    //       });
    //     });
    </script>
    <!-- end data table -->
    <script type="text/javascript">
    $(document).ready(function() {
      $('#filter_by_coin, #filter_by_rule_select, #filter_by_month_select').multiselect({
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
  // Tooltips script
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });
</script> 


