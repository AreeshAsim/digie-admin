  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
  <link href="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.css" rel="stylesheet">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="<?php echo ASSETS ?>buyer_order/moment-with-locales.js"></script>
  <script src="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.js"></script>
  <script type="text/javascript" src="<?php  echo SURL ?>assets/dist/jquery-asPieProgress.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>        <!--  for pie chart script   -->
       
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
  <h1 class="content-heading bg-white border-bottom">Reports</h1>
  <div class="innerAll bg-white border-bottom">
    <div class="pull-right" style="padding-right: 12px; padding-top: 8px;">
      <div class=" pull-right alert alert-warning" style=" margin-top: -10px; background: #5c678a;color: white;"> <?php echo date("F j, Y, g:i a").'&nbsp;&nbsp;  <b>'.date_default_timezone_get().' (GMT + 0)'.'<b />' ?></div>     

    </div>
    <ul class="menubar">
      <li class=""><a href="<?php echo SURL; ?>/admin/users_list/monthly_investment">Reports</a></li>
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
      <form method="POST" action="<?php echo SURL; ?>admin/users_list/monthly_investment">
        <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 ax_1">

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

          <div class="col-xs-12 col-sm-12 col-md-3 ax_3">
            <div class="Input_text_s">
              <label>Account Status: </label>
              <select id="status" name="status" type="text" class="form-control filter_by_name_margin_bottom_sm">
                <option value="both"<?=(($filter_data['status'] == "both") ? "selected" : "")?>>Both</option>
                <option value="active"<?=(($filter_data['status'] == "active") ? "selected" : "")?>>Active</option>
                <option value="inactive"<?=(($filter_data['status'] == "inactive") ? "selected" : "")?>>In Active</option>
              </select>
            </div>
          </div> 

        <div class="col-xs-12 col-sm-12 col-md-3 ax_4">
          <div class="Input_text_s">
            <label>From Date Range: </label>
            <input id="start_subscription_expiry_date" name="start_subscription_expiry_date" type="text" class="form-control datetime_picker filter_by_name_margin_bottom_sm" placeholder="Search By Expiry Date" value="<?=(!empty($filter_data['start_subscription_expiry_date']) ? $filter_data['start_subscription_expiry_date'] : "")?>" autocomplete="off">
            <i class="glyphicon glyphicon-calendar"></i> </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 ax_5">
          <div class="Input_text_s">
            <label>To Date Range: </label>
            <input id="end_subscription_expiry_date" name="end_subscription_expiry_date" type="text" class="form-control datetime_picker filter_by_name_margin_bottom_sm" placeholder="Search By Expiry Date" value="<?=(!empty($filter_data['end_subscription_expiry_date']) ? $filter_data['end_subscription_expiry_date'] : "")?>" autocomplete="off">
            <i class="glyphicon glyphicon-calendar"></i> </div>
        </div>
        <script type="text/javascript">
                $(function () {
                    $('.datetime_picker').datetimepicker();
                });
            </script>

        <!-- <div class="col-xs-12 col-sm-12 col-md-3 ax_3">
          <div class="Input_text_s">
            <label>Sorted by: </label>
            <select id="sort" name="sort" type="text" class="form-control filter_by_name_margin_bottom_sm">
              <option value="Lth_balance"<?=(($filter_data['sort'] == "Lth_balance") ? "selected" : "")?>>Lth balance</option>
              <option value="open_balance"<?=(($filter_data['sort'] == "open_balance") ? "selected" : "")?>>Open Balance</option>
              <option value="joining_date"<?=(($filter_data['sort'] == "joining_date") ? "selected" : "")?>>Joining Date</option>
              <option value="limit"<?=(($filter_data['sort'] == "limit") ? "selected" : "")?>>Trade limit</option>
              <option value="username"<?=(($filter_data['sort'] == "username") ? "selected" : "")?>>Username</option>
              <option value="avaliable_balance"<?=(($filter_data['sort'] == "avaliable_balance") ? "selected" : "")?>>Current Avaliable Balance</option>
              <option value="actual_deposit"<?=(($filter_data['sort'] == "actual_deposit") ? "selected" : "")?>>Actual Deposit</option>
            </select>
          </div>
        </div>  -->
        
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
            <!-- <a href="<?php echo SURL; ?>admin/trigger_rule_reports/csv_export_oppertunity_month"  class="btn btn-info">Export To CSV File</a> -->
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
    <div class="widget-body padding-bottom-none">
      <table class=" table table-bordered table table-striped" id="dataTable" >
        <thead class="theadd">
          <th><a href="#" data-toggle="tooltip" title="User Profile Picture">Profile</a></th>
          <th style="text-align:center; width:130px"><a href="#" data-toggle="tooltip" title="User Full Name and Exchanges Notification if exchange icon is checked it's mean this exchange is enabled for this user">Name</a></th>
          <th><a href="#" data-toggle="tooltip" title="Account Creation Date">Joining Date</a></th>
          <th><a href="#" data-toggle="tooltip" title="Deposit Balance from Joining date to till now">Total Worth $</a></th>
          <th><a href="#" data-toggle="tooltip" title="Available Balance for new trades">Avaliable Balance $</a></th>
          <th><a href="#" data-toggle="tooltip" title="Sold orders from joining date to till now">Sold Order</a></th>
          <th><a href="#" data-toggle="tooltip" title="Current open Order">Open</a></th>
          <th><a href="#" data-toggle="tooltip" title="Current LTH Order">LTH</a></th>
          <th><a href="#" data-toggle="tooltip" title="Open Orders Balance">Open Balance</a></th>
          <th><a href="#" data-toggle="tooltip" title="LTH Orders Balance">LTH Balance</a></th>
          <th><a href="#" data-toggle="tooltip" title="Trade Limit Pakage">Pakage $</a></th>
          <th><a href="#" data-toggle="tooltip" title="Daily trade details">Daily Trade $</a></th>
          <th><a href="#" data-toggle="tooltip" title="">Last Trade Buy/Sold Time</a></th>
          <th><a href="#" data-toggle="tooltip" title="">Last Month Profit/Loss</a></th>
          <th><a href="#" data-toggle="tooltip" title="">Last Login Time</a></th>
          <th><a href="#" data-toggle="tooltip" title="">Expiry Date</a></th>
          <th class="size"><a href="#" data-toggle="tooltip" title="Chart for Balance Distribution">Balance Chart</a></th>
          <!-- <th><a href="#" data-toggle="tooltip" title="Name of Record Month">Month</a></th> -->
          <th><a href="#" data-toggle="tooltip" title="Record Update time">Last Modified</a></th>
        </thead>
       <tbody>
  <?php  
  $time_zone = date_default_timezone_get();
  $this->load->helper('common_helper'); 
  foreach ($final_array as $key => $value) {?>
    <tr style="text-align:center;">
      <td>
        <?php if(isset($value['profile_pic']) && $value['profile_pic'] != ''){?>
          <img src="https://app.digiebot.com/assets/profile_images/<?php echo $value['profile_pic']; ?>" alt="" class="img-circle" width="39" height="39">
        <?php } else {?>
          <img src="<?php echo ASSETS; ?>images/empty_user.png" alt="" class="img-circle" width="39" height="39"/>
        <?php }?>
      </td>
        <td style="font-weight:100" >
          <span style="float:left"><a href="#" data-toggle="tooltip" title="<?php echo $value['username'] ?>"><?php echo $value['first_name'].' '.$value['last_name'] ;?></a></span>
          <br><br>
          <span style="float:left"><?php echo $value['exchange'];?></span><?php if(isset($value['exchange_enabled']) && $value['exchange_enabled'] == 'yes'){?>  <span class="fa fa-check" style="color:green; float:right"></span> <?php }else{?> <span class="fa fa-close" style="color:red; float:right"></span> <?php } ?>
          <br>
          <span style="float:left">ATG</span><?php if(isset($value['agt']) && $value['agt'] == 'yes'){?>  <span class="fa fa-check" style="color:green; float:right"></span> <?php }else{?> <span class="fa fa-close" style="color:red; float:right"></span> <?php } ?>
          <br>
          <span style="float:left">BNB</span><?php if(isset($value['bnb_balance']) && $value['bnb_balance'] > 0){?>  <span class="fa fa-check" style="color:green; float:right"></span> <?php }else{?> <span class="fa fa-close" style="color:red; float:right"></span> <?php } ?>
          <br>
          <span style="float:left">Per/day $</span><?php if(isset($value['per_day_limit']) && $value['per_day_limit'] != 'no'){?> <span style="float:right"><?php echo number_format($value['per_day_limit'], 2);}?></span> 
        </td>
        <td><?php 
              if(isset($value['modified_time'])){
                 $join_date = $value['joining_date']->toDateTime()->format("Y-m-d H:i:s");
                }
                $time_zone = date_default_timezone_get();
                $this->load->helper('common_helper');
                $last_time_ago = time_elapsed_string($join_date , $time_zone);?>
               <ahref="#" class="label label-info" data-toggle="tooltip" title="<?php echo $join_date;?>"><?php echo $last_time_ago;?></a>
         </td>
        <td><span style="float:right"><?php echo (float)number_format($value['actual_deposit'], 2); ?><span></td>
        <?php if($value['total_balance'] < 15){?>
        <td style="background-color:red;color:white"><span style="float:right"><?php echo (float)number_format($value['total_balance'], 2);?></span></td>
        <?php }else{?>
          <td><span style="float:right"><?php echo number_format($value['total_balance'], 2);?></span></td>
        <?php } ?>
        <td style ="text-align:right"><?php echo $value['sold_trades'];?></td>
        <td style ="text-align:right"><?php echo $value['open_order'];?></td>
        <td style ="text-align:right"><?php echo $value['lth_order'];?></td>
        <td><?php
          if($value['open_balance'] == '0'){
          $open_balance_per = 0;
          }else{
              $open_balance_per = ($value['open_balance'] / $value['actual_deposit'] )*100;
          }?>
          <div class="circle" id="circle-a" data-value="<?php echo $open_balance_per/100;?>" data-fill="{
              &quot;color&quot;: &quot;rgba(31, 183, 79) &quot;}">
              <strong><span title="<?php echo "Open Balance $ = ".$value['open_balance']; ?>"><?php echo number_format($open_balance_per, 1);?>%</span></strong>
            </div>
        </td>
        <td><?php
        if($value['lth_balance'] == '0'){
            $lth_balance_per = 0;
        }else{
            $lth_balance_per = ($value['lth_balance'] / $value['actual_deposit'] )*100;
        }      
        ?>
         <div class="circle" id="circle-a" data-value="<?php echo $lth_balance_per/100;?>" data-fill="{
            &quot;color&quot;: &quot;rgba(237, 7, 49) &quot;}"> 
            <strong><span title="<?php echo "LTH balance $ =".$value['lth_balance']; ?>"><?php echo number_format($lth_balance_per, 1);?>%</span></strong>
           </div> 
        </td>
        <td><span style="float:right"><?php echo $value['trade_limit'];?></span></td>
        <td>
        <span class="label label-info"><?php echo "count = ".$value['daily/trade_count'];?></span>
        <br> <br>
        <span title="Traded In $ = "><?php echo number_format($value['daily/trade_$'],3);?></span>
        </td>
        <td>
          <?php if(isset($value['last_trade_buy']) && isset($value['last_trade_sold'])){
             $buy_time = $value['last_trade_buy']->toDateTime()->format("Y-m-d H:i:s");
             $sell_time = $value['last_trade_sold']->toDateTime()->format("Y-m-d H:i:s");
             $buy_time_ago = time_elapsed_string($buy_time , $time_zone);
             $sell_time_ago = time_elapsed_string($sell_time , $time_zone);?>
            <span class="label label-info" title="Buy time= <?php echo $buy_time; ?>"> <?php echo $buy_time_ago; ?></span>
            <br>
            <span class="label label-info" title="Sell time= <?php echo $sell_time; ?>"> <?php echo $sell_time_ago; ?></span>
         <?php } ?>
        </td>
        <td>Loading...</td>
        <td>
          <?php if(isset($value['last_login_time'])){ 
            $login_time = $value['last_login_time']->toDateTime()->format("Y-m-d H:i:s");
            $login_time_ago = time_elapsed_string($login_time , $time_zone);?>
            <span class="label label-info" title="Sell time= <?php echo $login_time; ?>"> <?php echo $login_time_ago; ?></span>
          <?php } ?>
        </td>
        <td>
          <?php if(isset($value['subscription_expiry_date'])){ 
            $expiry_date = $value['subscription_expiry_date']->toDateTime()->format("d, M Y");
            // $login_time_ago = time_elapsed_string($login_time , $time_zone);
            ?>
            <span class="label label-info"> <?php echo $expiry_date; ?></span>
          <?php } ?>
        </td>
        <!-- <td>
          <span style="float:left">bam</span> <?php if(isset($value['agt_bam']) && $value['agt_bam'] == 'yes'){?>  <span class="fa fa-check" style="color:green; float:right"></span> <?php }else{?> <span class="fa fa-close" style="color:red; float:right"></span> <?php } ?>         
          <br>
          <span style="float:left">kraken</span><?php if(isset($value['agt_kraken']) && $value['agt_kraken'] == 'yes'){?>  <span class="fa fa-check" style="color:green; float:right"></span> <?php }else{?> <span class="fa fa-close" style="color:red; float:right"></span> <?php } ?>
          <br>
          <span style="float:left">binance</span><?php if(isset($value['agt_binance']) && $value['agt_binance'] == 'yes'){?>  <span class="fa fa-check" style="color:green; float:right"></span> <?php }else{?> <span class="fa fa-close" style="color:red; float:right"></span> <?php } ?>
          <br>
        </td> -->
        <td>  
     
          <!-- <div class="donut" style="--first:<?php echo number_format($avaliable, 2);?>; --second:<?php echo number_format($open, 2); ?>; --third:<?php echo number_format($lth, 2);?>; --fourth:<?php echo number_format($empty, 2);?>;">
          <?php if($avaliable > 0): ?>  
            <a href="#" data-toggle="tooltip" title="Avaliable"><div class="donut__slice donut__slice__first"></div></a>
          <?php endif; ?>
          <?php if($open > 0): ?> 
            <a href="#" data-toggle="tooltip" title="Open"><div class="donut__slice donut__slice__second"></div></a>
          <?php endif; ?>
          <?php if($lth > 0): ?> 
            <a href="#" data-toggle="tooltip" title="LTH"> <div class="donut__slice donut__slice__third"></div></a>
          <?php endif; ?>
          <?php if($empty > 0): ?> 
            <a href="#" data-toggle="tooltip" title="Empty"><div class="donut__slice donut__slice__fourth"></div></a>
          <?php endif; ?>
          </div> -->
          
          <?php
          // $lth = 0;
          // $open = 0;
          // if($value['open_balance'] != '0' && $value['actual_deposit'] != '0'){
          //   $open = $value['open_balance']/ $value['actual_deposit'];
          // }else{
          //   $open = 0;
          // }
          // if($value['lth_balance'] != '0' && $value['actual_deposit'] != '0'){
          //   $lth = $value['lth_balance']/ $value['actual_deposit'];
          // }else{
          //   $lth = 0;
          // }
          // $avaliable = 0;
          // if($value['total_balance'] != '0' && $value['actual_deposit'] != '0'){
          //   $avaliable = $value['total_balance']/ $value['actual_deposit'];
          // }else{
          //   $avaliable = 0;
          // }
          //  $empty = 0;
          //  if( $avaliable == '0' && $open == '0' && $lth == '0'){
          //    $empty = 1;
          //  }else{
          //    $empty = 0;
          //  }
           ?>
           loading...

          <!-- <div id="piechart<?= $value['username']; ?>" class="size" style="height:110px"></div> -->
          <!-- <script>
            google.charts.load('current', {
              'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
              var avaliable = "<?= $avaliable; ?>"
              var open = "<?= $open; ?>"
              var lth = "<?= $lth; ?>"
              var empty = "<?= $empty;?>"
              var data = google.visualization.arrayToDataTable([
              ['', ''],
              ['Empty',parseFloat(empty*24)],
              ['LTH', parseFloat(lth*24)],
              ['Open',parseFloat(open*24)],
              ['Avaliable', parseFloat(avaliable*24)],
              ]);
              var options = {
              title: ''
              };
              var chart = new google.visualization.PieChart(document.getElementById('piechart<?= $value['username'];?>'));
              chart.draw(data, options);
              $('circle').remove();
              $('text').remove();
            }
          </script> -->
        </td>
      
        <td>
          <?php
         if(isset($value['modified_time'])){
            $last_modified_time = $value['modified_time']->toDateTime()->format("Y-m-d H:i:s");
            }
        $time_zone = date_default_timezone_get();
        $this->load->helper('common_helper');
        $last_time_ago = time_elapsed_string($last_modified_time , $time_zone);?>
        <a href="#" class="label label-info" data-toggle="tooltip" title="<?php echo $last_modified_time;?>"><?php echo $last_time_ago; ?></a>
      </td> 
           </tr>
  <?php  }   ?>
          </tbody>
    </table>
    <div><?php echo $links; ?></div>
  </div>
  </div>
  </div>
  </div>
</div>
  <script src="assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script> 
      <script type="text/javascript">
        $(document).ready(function() {
          // setTimeout(() => {
          $('#dataTable').dataTable({
            "pageLength": 100
          });
          // }, 100);
        });
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
  // Tooltips script
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });
</script> 