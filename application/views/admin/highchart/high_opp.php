<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<link href="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.css" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?php echo ASSETS ?>buyer_order/moment-with-locales.js"></script>
<script src="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo SURL ?>assets/dist/jquery-asPieProgress.js"></script>
<script src="<?php echo ASSETS; ?>js/highcharts/highcharts.js"></script>
<script src="<?php echo ASSETS; ?>js/highcharts/series-label.js"></script>
<script src="<?php echo ASSETS; ?>js/highcharts/exporting.js"></script>
<script src="<?php echo ASSETS; ?>js/highcharts/export-data.js"></script>
<?php
// echo "<prE>";   print_r($final_arr); exit;
$filter_user_data = $this->session->userdata('filter_order_data'); ?>
<style>
  .Input_text_s {
    float: left;
    width: 100%;
    position: relative;
  }
  .Input_text_s>label {
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

  .Input_text_s>i {
    position: absolute;
    right: 8px;
    bottom: 4px !important;
    height: 20px;
    top: auto;
  }

  .ax_2,
  .ax_3,
  .ax_4,
  .ax_5 {
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

  .col-radio input[type="radio"]:checked+span i.fa.fa-dot-circle-o {
    display: block;
    color: #72af46;
  }

  .col-radio input[type="radio"]:checked+span i.fa.fa-circle-o {
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

  .Input_text_btn>a>i,
  .Input_text_btn>button>i {
    margin-right: 10px;
  }

  .coin_symbol {}

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
    background: rgba(0, 0, 0, 0.04);
  }

  table.table.table-stripped tr.theadd:hover {
    background: rgba(204, 204, 204, 1);
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

<?php
$page_post_data   = $this->session->userdata('page_post_data');
$box_session_data = $this->session->userdata('page_post_data');
$form_session_session = $this->session->userdata('form_session_session');


if ($box_session_data == '') {
  $checboxValue = '';
}
$checboxValue  = ($box_session_data == '') ? '' :  $checboxValue;

$dataArr  = explode(',', $chart_arr[0]);
$finalArr = array_chunk($chart_arr[0]);

$width     = !empty($page_post_data['chart_width']) ? ($page_post_data['chart_width']) : 1600;
$height    = !empty($page_post_data['chart_height']) ? ($page_post_data['chart_height']) : 1000;
$varWidth  = 'style="height:1200px; width:' . $width . '"';
?>
<style>
  .sidebar.sidebar-inverse {
    z-index: 9999;
  }

  .highcharts-credits {
    display: none;
  }

  .highcharts-legend {
    /*visibility:hidden;*/
  }

  .loader_parent {
    position: relative;
  }

  .loader_image_main {
    bottom: 0;
    height: 50px;
    left: 0;
    margin: auto;
    position: absolute;
    right: 0;
    top: 0;
    width: 50px;
    z-index: 9999;
  }

  .loader_overlay_main {
    background: rgba(255, 255, 255, 0.8) none repeat scroll 0 0;
    height: 100%;
    position: absolute;
    width: 100%;
    z-index: 99;
    display: none;
  }

  /*------------------------------------------------- Check box -------*/
  .fncy_check_label {
    float: left;
    width: calc(100% - 45px);
    margin-left: 10px;
    font-size: 11px;
    font-weight: normal;
  }

  .fncy_check_box {
    float: left;
    height: 18px;
    margin-right: 0;
    margin-top: 0;
    width: 35px;
  }

  .fncy_check_box>label {
    background: #b3b3b3 none repeat scroll 0 0;
    border-radius: 10px;
    box-shadow: 0 1px 3px 3px rgba(0, 0, 0, 0.1) inset;
    float: left;
    height: 14px;
    position: relative;
    width: 100%;
  }

  .fncy_check_box>input {
    height: 100%;
    left: 0;
    margin: 0;
    opacity: 0;
    position: absolute;
    width: 100%;
    z-index: 1;
  }

  .fncy_check_box>label>span {
    background: #fff none repeat scroll 0 0;
    border-radius: 50%;
    box-shadow: 1px 1px 5px #bcbcbc;
    height: 21px;
    left: -5px;
    position: absolute;
    top: -4px;
    transition: 0.3s;
    width: 21px;
  }

  .fncy_check_box>input[type="checkbox"]:checked+label>span {
    left: 20px;
    background: #5cb85c;
    box-shadow: -2px 1px 3px rgba(0, 0, 0, 0.4);
  }

  .fncy_check_box>input[type="checkbox"]:checked+label {
    background: #addaad;
  }

  /*---------------------------------------------------------*/
  .widget-header {
    float: left;
    width: 100%;
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
    margin-bottom: 15px;
  }

  .widget-header h2 {
    float: left;
  }

  .widget-header button {
    float: right;
  }

  .highcharts-title {
    display: none;
  }

  .highcharts-button {
    display: none;
  }

  #container2 .highcharts-xaxis-labels {
    display: none;
  }

  #container2 .highcharts-axis-title {
    display: none;
  }

  .af-border {
    border-bottom: 1px solid #eee;
    margin: 0 0 15px;
  }

  .af-mb-3 {
    margin-bottom: 20px;
  }
</style>

<div id="content">
  <div class="innerAll bg-white border-bottom"> </div>
  <br />
  <div class="innerAll spacing-x2" <?php echo $varWidth; ?>>
    <?php if ($this->session->flashdata('err_message')) { ?>
      <div class="alert alert-danger">
        <?php echo $this->session->flashdata('err_message'); ?>
      </div>
    <?php }
    if ($this->session->flashdata('ok_message')) { ?>
      <div class="alert alert-success alert-dismissable">
        <?php echo $this->session->flashdata('ok_message'); ?>
      </div>
    <?php } ?>
    <div class="alert alert-success alert-dismissable savesessionmessaage" style="display:none;">Successfully Save session against the coin .</div>

    <!-- Widget -->
    <div class="widget widget-inverse" style="height:65px;">
      <div class="widget-header">
        <h2>Filters</h2>
        <div class=" pull-right alert alert-warning" style=" margin-top: -10px; background: #5c678a;color: white;"> <?php echo date("F j, Y, g:i a") . '&nbsp;&nbsp;  <b>' . date_default_timezone_get() . ' (GMT + 0)' . '<b />' ?></div>
      </div>
      <div class="widget-body padding-bottom-none filter-colps-body">
        <!-- Table -->
        <div class="row">
          <div class="col-md-12 af-border">
            <form method="POST" action="<?php echo SURL; ?>admin/highchart-opp/oppertunity">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 ax_1">
                  <div class="col-xs-12 col-sm-12 col-md-3 ax_2">
                    <div class="Input_text_s">
                      <label>Filter Coin: </label>
                      <select id="filter_by_coin" multiple="multiple" name="filter_by_coin[]" type="text" class=" filter_by_name_margin_bottom_sm">
                        <?php foreach ($coin_array_all as $coinRow) {  ?>
                          <option value="<?php echo $coinRow['symbol'] ?>" <?php if (in_array($coinRow['symbol'], $filter_user_data['filter_by_coin'])) { ?> selected <?php } ?>><?php echo $coinRow['symbol'] ?></option>
                        <?php } ?>
                      </select>
                      </select>
                    </div>
                  </div>






                  <!--<div class="col-xs-12 col-sm-12 col-md-2 ax_3">
              <div class="Input_text_s">
                <label>Filter Days/Hours: </label>
                <select id="filter_hour_day" name="filter_hour_day" type="text" class="form-control filter_by_name_margin_bottom_sm">
                  <option value="">Search By Mode</option>
                  <option value="hours"<?= (($filter_user_data['filter_hour_day'] == "hours") ? "selected" : "") ?>>Hours</option>
                  <option value="days"<?= (($filter_user_data['filter_hour_day'] == "days") ? "selected" : "") ?>>Days</option>
                 
                </select>
              </div>
            </div>-->

                  <div class="col-xs-12 col-sm-12 col-md-3 ax_4">
                    <div class="Input_text_s">
                      <label>From Date Range: </label>
                      <input id="filter_by_start_date" name="filter_by_start_date" type="text" class="form-control datetime_picker filter_by_name_margin_bottom_sm" placeholder="Search By Date" value="<?= (!empty($filter_user_data['filter_by_start_date']) ? $filter_user_data['filter_by_start_date'] : "") ?>" autocomplete="off">
                      <i class="glyphicon glyphicon-calendar"></i> </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-3 ax_5">
                    <div class="Input_text_s">
                      <label>To Date Range: </label>
                      <input id="filter_by_end_date" name="filter_by_end_date" type="text" class="form-control datetime_picker filter_by_name_margin_bottom_sm" placeholder="Search By Date" value="<?= (!empty($filter_user_data['filter_by_end_date']) ? $filter_user_data['filter_by_end_date'] : "") ?>" autocomplete="off">
                      <i class="glyphicon glyphicon-calendar"></i> </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 ax_3">
                    <div class="Input_text_s">
                      <label>Filter Mode: </label>
                      <select id="filter_by_mode" name="filter_by_mode" type="text" class="form-control filter_by_name_margin_bottom_sm">
                        <option value="">Search By Mode</option>
                        <option value="live" <?= (($filter_user_data['filter_by_mode'] == "live") ? "selected" : "") ?>>Live</option>
                        <option value="test_live" <?= (($filter_user_data['filter_by_mode'] == "test_live") ? "selected" : "") ?>>Test</option>
                        <option value="test_simulator" <?= (($filter_user_data['filter_by_mode'] == "test_simulator") ? "selected" : "") ?>>Simulator</option>
                      </select>
                    </div>
                  </div>
                  <script type="text/javascript">
                    $(function() {
                      $('.datetime_picker').datetimepicker();
                    });
                  </script>
                  <!--<div class="col-xs-12 col-sm-12 col-md-2 ax_3">
              <div class="Input_text_s">
                <label>Oppertunity Status: </label>
                <select id="opp_status" name="opp_status" type="text" class="form-control filter_by_name_margin_bottom_sm">
                  <option value="sold"<?= (($filter_user_data['opp_status'] == "sold") ? "selected" : "") ?>>Sold</option>
                  <option value="open"<?= (($filter_user_data['opp_status'] == "open") ? "selected" : "") ?>>Open</option>
                </select>
              </div>
            </div>-->
                  <div class="col-xs-12 col-sm-12 col-md-2  ax_8" style=" min-height: 60px;">
                    <div class="Input_text_s" id="triggerFirst" <?php if ($filter_user_data['group_filter'] == 'rule_group') { ?>style="display:block;" <?php } else { ?><?php } ?>>
                      <label>Filter Trigger: </label>
                      <select id="filter_by_trigger" name="filter_by_trigger" type="text" class="form-control  filter_by_trigger">
                        <option value="barrier_trigger" <?php if ($filter_user_data['filter_by_trigger'] == 'barrier_trigger') { ?> selected <?php } ?>>BARRIER TRIGGER</option>
                        <option value="barrier_percentile_trigger" <?php if ($filter_user_data['filter_by_trigger'] == 'barrier_percentile_trigger') { ?> selected <?php } ?>>Barrier Percentile Trigger</option>
                      </select>
                    </div>
                  </div>

                  <!-- End Hidden Searches -->
                  <div class="col-xs-12 col-sm-12 col-md-2  ax_8 filter_by_level" style=" min-height: 60px;" id="filter_by_level">
                    <div class="Input_text_s filter_by_level" <?php if ($filter_user_data['group_filter'] == 'rule_group') { ?> <?php  } else { ?> <?php  } ?>>
                      <label>Filter Level: </label>
                      <select id="filter_by_level_select" name="filter_by_level[]" multiple="multiple" type="text" class="form-control filter_by_name_margin_bottom_sm filter_by_level">
                        <option value="level_1" <?php if (in_array('level_1', $filter_user_data['filter_by_level'])) { ?> selected <?php } ?>>Level 1</option>
                        <option value="level_2" <?php if (in_array('level_2', $filter_user_data['filter_by_level'])) { ?> selected <?php } ?>>Level 2</option>
                        <option value="level_3" <?php if (in_array('level_3', $filter_user_data['filter_by_level'])) { ?> selected <?php } ?>>Level 3</option>
                        <option value="level_4" <?php if (in_array('level_4', $filter_user_data['filter_by_level'])) { ?> selected <?php } ?>>Level 4</option>
                        <option value="level_5" <?php if (in_array('level_5', $filter_user_data['filter_by_level'])) { ?> selected <?php } ?>>Level 5</option>
                        <option value="level_6" <?php if (in_array('level_6', $filter_user_data['filter_by_level'])) { ?> selected <?php } ?>>Level 6</option>
                        <option value="level_7" <?php if (in_array('level_7', $filter_user_data['filter_by_level'])) { ?> selected <?php } ?>>Level 7</option>
                        <option value="level_8" <?php if (in_array('level_8', $filter_user_data['filter_by_level'])) { ?> selected <?php } ?>>Level 8</option>
                        <option value="level_9" <?php if (in_array('level_9', $filter_user_data['filter_by_level'])) { ?> selected <?php } ?>>Level 9</option>
                        <option value="level_10" <?php if (in_array('level_10', $filter_user_data['filter_by_level'])) { ?> selected <?php } ?>>Level 10</option>
                        <option value="level_11" <?php if (in_array('level_11', $filter_user_data['filter_by_level'])) { ?> selected <?php } ?>>Level 11</option>
                        <option value="level_12" <?php if (in_array('level_12', $filter_user_data['filter_by_level'])) { ?> selected <?php } ?>>Level 12</option>
                        <option value="level_13" <?php if (in_array('level_13', $filter_user_data['filter_by_level'])) { ?> selected <?php } ?>>Level 13</option>
                        <option value="level_14" <?php if (in_array('level_14', $filter_user_data['filter_by_level'])) { ?> selected <?php } ?>>Level 14</option>
                        <option value="level_15" <?php if (in_array('level_15', $filter_user_data['filter_by_level'])) { ?> selected <?php } ?>>Level 15</option>

                      </select>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2  ax_8 filter_by_rule" style=" min-height: 60px;" id="filter_by_rule">
                    <div class="Input_text_s filter_by_rule" <?php if ($filter_user_data['group_filter'] == 'rule_group') { ?> <?php } else { ?> <?php } ?>>
                      <label>Filter Rule: </label>
                      <select id="filter_by_rule_select" name="filter_by_rule[]" multiple="multiple" type="text" class="form-control filter_by_name_margin_bottom_sm filter_by_rule">
                        <option value="1" <?php if (in_array(1, $filter_user_data['filter_by_rule'])) { ?> selected <?php } ?>>Rule 1</option>
                        <option value="2" <?php if (in_array(2, $filter_user_data['filter_by_rule'])) { ?> selected <?php } ?>>Rule 2</option>
                        <option value="3" <?php if (in_array(3, $filter_user_data['filter_by_rule'])) { ?> selected <?php } ?>>Rule 3</option>
                        <option value="4" <?php if (in_array(4, $filter_user_data['filter_by_rule'])) { ?> selected <?php } ?>>Rule 4</option>
                        <option value="5" <?php if (in_array(5, $filter_user_data['filter_by_rule'])) { ?> selected <?php } ?>>Rule 5</option>
                        <option value="6" <?php if (in_array(6, $filter_user_data['filter_by_rule'])) { ?> selected <?php } ?>>Rule 6</option>
                        <option value="7" <?php if (in_array(7, $filter_user_data['filter_by_rule'])) { ?> selected <?php } ?>>Rule 7</option>
                        <option value="8" <?php if (in_array(8, $filter_user_data['filter_by_rule'])) { ?> selected <?php } ?>>Rule 8</option>
                        <option value="9" <?php if (in_array(9, $filter_user_data['filter_by_rule'])) { ?> selected <?php } ?>>Rule 9</option>
                        <option value="10" <?php if (in_array(10, $filter_user_data['filter_by_rule'])) { ?> selected <?php } ?>>Rule 10</option>
                        <option value="11" <?php if (in_array(11, $filter_user_data['filter_by_rule'])) { ?> selected <?php } ?>>Rule 11</option>
                        <option value="12" <?php if (in_array(12, $filter_user_data['filter_by_rule'])) { ?> selected <?php } ?>>Rule 12</option>
                        <option value="13" <?php if (in_array(13, $filter_user_data['filter_by_rule'])) { ?> selected <?php } ?>>Rule 13</option>
                        <option value="14" <?php if (in_array(14, $filter_user_data['filter_by_rule'])) { ?> selected <?php } ?>>Rule 14</option>
                        <option value="15" <?php if (in_array(15, $filter_user_data['filter_by_rule'])) { ?> selected <?php } ?>>Rule 15</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-1 ax_3">
                    <div class="Input_text_s">
                      <label>Divide Factor </label>
                      <input type="text" name="peak_factor" id="peak_factor" value="<?php echo $peak_factor; ?>" class="form-control" data-toggle="tooltip" title="Use for to divide the oppertunity by peak factor. Only for to look better the Oppertunity chart." />
                    </div>
                  </div>


                  <div class="col-xs-12 col-sm-12 col-md-1 ax_9">
                    <div class="Input_text_btn">
                      <label></label>
                      <button id="submit-form" class="btn btn-success"><i class="glyphicon glyphicon-filter"></i>Search</button>
                      <span class="ax_10"></span>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <div class="form-group col-md-2 emptydiv"></div>
          </div>
        </div>

        <div class="loader_parent">
          <!--<div class="loader_overlay_main"> <img class="loader_image_main" src="https://app.digiebot.com/assets/images/loader.gif"> </div>
        <div id="container2"></div>-->

          <br />
          <div id="container"></div>
        </div>
      </div>

    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#filter_by_coin, #filter_by_rule_select, #filter_by_level_select').multiselect({
        includeSelectAllOption: true,
        buttonWidth: 435.7,
        enableFiltering: true
      });
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function(e) {

      $("body").on("click", ".check_candle", function() {
        if ($(this).is(":checked")) {
          $("#container").show();
        } else {
          $("#container").hide();
        }
      });
    });

    $(function() {
      $('.datetime_picker').datetimepicker();
    });

    $(document).ready(function(e) {

      $("body").on("click", ".check_alll", function() {

        if ($(this).is(":checked")) {
          $("#highchartform_data .fncy_check_box > input:not(.check_alll)").attr("checked", "checked");
        } else {
          $("#highchartform_data .fncy_check_box > input:not(.check_alll)").removeAttr("checked");
        }
      });

    });
  </script>

  <!--Container  data Goes start here -->
  <?php //if($hide_chart!=1){ 
  ?>
  <script src="https://code.highcharts.com/modules/boost.js"></script>

  <script>
    $(document).ready(function(e) {
      var filter_by_trigger = $("#filter_by_trigger").val();



      if (filter_by_trigger == 'barrier_trigger') {
        $(".filter_by_level").hide();
        $(".filter_by_rule").show();
      } else if (filter_by_trigger == 'barrier_percentile_trigger') {
        $(".filter_by_level").show();
        $(".filter_by_rule").hide();
      } else {
        $(".filter_by_level").hide();
        $(".filter_by_rule").hide();
      }
    });

    $("body").on("change", "#filter_by_trigger", function(e) {
      var filter_by_trigger = $("#filter_by_trigger").val();

      $(".filter_by_level").hide();
      $(".filter_by_rule").hide();

      if (filter_by_trigger == 'barrier_percentile_trigger') {
        $(".filter_by_level").show();
        $(".filter_by_rule").hide();
      }

      if (filter_by_trigger == 'barrier_trigger') {
        $(".filter_by_rule").show();
        $(".filter_by_level").hide();
      }
      if (filter_by_trigger == 'no') {
        $(".filter_by_level").hide();
        $(".filter_by_rule").hide();
      }
    });
  </script>





  <script type="text/javascript">
    $(window).on('load', function() {
      //loadcandle2();
    });

    jQuery(document).ready(function() {
      loadcandle();

    });
    /*****   On load body will open graph  *****/
    function loadcandle() {

      // the button action
      var chart = $('#container').highcharts();
      for (var i = 0; i < $('#highchartform_data input[type=checkbox]').length; i++) {
        var series = chart.series[i];
        series.show();
      }
    }
    /*****  On load body will open graph *****/

    function load_hight_chart() {

      Highcharts.setOptions({
        time: {
          timezone: 'America/New_York'
        }
      });

      function addChartCrosshairs() {
        var chart = this;
        //initialize the X and Y component of the crosshairs (you can adjust the color and size of the crosshair lines here)
        var crosshairX = chart.renderer.path(['M', chart.plotLeft, 2, 'L', chart.plotLeft + chart.plotWidth, 2]).attr({
            stroke: '#686868',
            'stroke-width': 0.5,
            dashStyle: 'shortdot',
            zIndex: 0
          }).add()
          .toFront()
          .hide();

        var crosshairY = chart.renderer.path(['M', 2, chart.plotTop, 'L', 2, chart.plotTop + chart.plotHeight]).attr({
            stroke: '#686868',
            'stroke-width': 0.5,
            dashStyle: 'shortdot',
            zIndex: 0
          }).add()
          .toFront()
          .hide();

        $(chart.container).mousemove(function(event) {
          //onmousemove move our crosshair lines to the current mouse postion
          xpos = (event.offsetX == undefined) ? event.originalEvent.layerX : event.offsetX;
          ypos = (event.offsetY == undefined) ? event.originalEvent.layerY : event.offsetY;

          crosshairX.translate(0, ypos);
          crosshairY.translate(xpos, 0);

          //only show the crosshairs if we are inside of the plot area (the area within the x and y axis)
          if (xpos > chart.plotLeft && xpos < chart.plotLeft + chart.plotWidth &&
            ypos > chart.plotTop && ypos < chart.plotTop + chart.plotHeight) {
            crosshairX.show();
            crosshairY.show();
          } else { //if we are here then we are inside of the container, but outside of the plot area
            crosshairX.hide();
            crosshairY.hide();
          }
        });
      }

      Highcharts.chart('container', {

        time: {
          timezone: 'America/New_York'
        },
        /* title: {
             text: 'Show the data of last <b> <?php echo $totalHours; ?> </b> <?php echo ucfirst($time) . 's'; ?> over the graph .'
           },*/
        width: 500,
        height: 300,
        subtitle: {
          text: ''
        },
        /* tooltip: {
            xDateFormat: '%Y-%m-%d %H:%M',
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y:.2f}</b><br/>'
        },*/

        mapNavigation: {
          enabled: true,
          enableDoubleClickZoomTo: true
        },
        /*   xAxis: {
                            gridLineColor: '#e5eaee',
                            lineColor:     '#e5eaee',
							gridLineWidth: 0.5,
							crosshair: {
									width: 0.5,
									color: '#686868',
									dashStyle: 'shortdot'
							},
                            tickColor: '#e5eaee',
                            title:{ text:'Current Time Zone : <?php echo $timezone; ?>     Current Chart : <?php echo ucfirst($time) . 's'; ?> '},
                            categories: [<?php echo $timView; ?>]
		       },*/





        xAxis: {
          categories: ['Average Profit', 'Max Profit 5 H', 'Min Profit 5 H', 'Max Profit High', 'Min Profit Low', 'Coin Oppertunity ']
        },





        yAxis: {
          title: {
            text: ''
          },
          gridLineWidth: 0.5,
          crosshair: {
            width: 0.5,
            color: '#686868',
            dashStyle: 'shortdot'
          },
          min: -10 ,//<?php //echo $bottom_height;?>
          minRange: 1,
          tickInterval: 1,
          plotLines: [{
            color: 'black', // Color value
            dashStyle: 'longdashdot', // Style of the plot line. Default to solid
            value: 0, // Value of where the line will appear
            width: 1 // Width of the line
          }]
        },

        legend: {
          layout: 'vertical',
          align: 'right',
          verticalAlign: 'middle'
        },



        tooltip: {
          shared: true,
          crosshairs: true
        },

        /* plotOptions: {
             series: {
                 label: {
                     connectorAllowed: false
                 },
                 pointStart: 0
             }
         },*/

        plotOptions: {
          column: {
            //stacking: 'normal'
            pointPadding: 0
          }
        },

        /*plotOptions: {
        		  series: {
        			events: {
        			  legendItemClick: function() {
        				var name = this.name.substring(this.name.length - 4, this.name.length);
        				
        				var _i = this._i;
        				Highcharts.each(this.chart.series, function(p, i) {
        				  if (name === p.name.substring(p.name.length - 4, p.name.length) && _i !== p._i) {
        					(!p.visible) ? p.show(): p.hide()
        				  }
        				})
        			  }
        			}
        		  }
        		},*/

        chart: {
          renderTo: 'chart',
          events: {
            load: addChartCrosshairs
          },
          width: <?php echo $width; ?>,
          height: <?php echo $height; ?>,
          marginRight: 180,
          zoomType: 'x',
          resetZoomButton: {
            position: {
              align: 'right', // by default
              verticalAlign: 'top', // by default
              x: -10,
              y: 10
            },
            relativeTo: 'chart'
          }
        },
        legend: {
          layout: 'vertical',
          align: 'right',
          x: 0,
          verticalAlign: 'right',
          y: 30,
          floating: true,
          backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'rgba(255,255,255,0.25)'
        },
        series: [
          <?php foreach ($final_arr as $key => $row) { ?> {
              name: '<?php echo $key; ?>',
              data: [<?php echo  $row; ?>],
              stack: 'Percentile Trigger',
              type: 'column'
            },
          <?php
          }
          ?>
        ],
        /* series: [
		// Barrier  code goes start here 
		<?php //if (!empty(in_array("check0", $box_session_data))){
    ?>
        {
            name: 'Average Profit Barrier',
            color: 'green',
			type: 'column',
			crosshair: true,
            data: [<?php echo $avg_profit_bar; ?>],
            negativeColor: 'red'
        },
		<?php //}
    ?>
		<?php //if (!empty(in_array("check1", $box_session_data))){
    ?>
		{
            name: 'Maximum Profit 5H Barrier',
            type: 'column',
            color: 'black',
			crosshair: true,
            negativeColor: '#009900',
            data: [<?php echo $max_profit_5h_bar; ?>],
            tooltip: {
               valueSuffix: '  <?php echo $price_format; ?>'
             }

        },
		<?php //}
    ?>
		<?php //if (!empty(in_array("check2", $box_session_data))){
    ?>
		{
            name: 'Minimum Profit 5H Barrier',
            type: 'column',
            color: ' #cc9900',
            negativeColor: ' #cc9900',
            data: [<?php echo $min_profit_5h_bar; ?>],
            tooltip: {
               valueSuffix: '  <?php echo $price_format; ?>'
             }

        },
		<?php //}
    ?>
		<?php //if (!empty(in_array("check3", $box_session_data))){
    ?>
		{
            name: 'Max Profit High Barrier',
			type: 'column',
            color: '#003399',
            data: [<?php echo $max_profit_high_bar; ?>],
            negativeColor: '#003399'
        },
		<?php //}
    ?>
		<?php //if (!empty(in_array("check4", $box_session_data))){
    ?>
		{
           name: 'Min Profit Low Barrier',
            color: '#ff6600',
			type: 'column',
            data: [<?php echo $min_profit_low_bar; ?>],
            negativeColor: '#ff6600'
        },
		<?php //}
    ?>
		// Barrier code goes END here 
		
		
		// Percentile code goes start here 
		<?php //if (!empty(in_array("check0", $box_session_data))){
    ?>
        {
            name: 'Average Profit Percentile',
            color: '#ccffcc',
			type: 'column',
			crosshair: true,
            data: [<?php echo $avg_profit_per; ?>],
            negativeColor: 'red'
        },
		<?php //}
    ?>
		<?php //if (!empty(in_array("check1", $box_session_data))){
    ?>
		{
            name: 'Maximum Profit 5H Percentile',
            type: 'column',
            color: '#336699',
			crosshair: true,
            negativeColor: '#009900',
            data: [<?php echo $max_profit_5h_per; ?>],
            tooltip: {
               valueSuffix: '  <?php echo $price_format; ?>'
             }

        },
		<?php //}
    ?>
		<?php //if (!empty(in_array("check2", $box_session_data))){
    ?>
		{
            name: 'Minimum Profit 5H Percentile',
            type: 'column',
            color: ' #cc9900',
            negativeColor: ' #cc9900',
            data: [<?php echo $min_profit_5h_per; ?>],
             tooltip: {
               valueSuffix: '  <?php echo $price_format; ?>'
             }
        },
		<?php //}
    ?>
		<?php //if (!empty(in_array("check3", $box_session_data))){
    ?>
		{
            name: 'Max Profit High Percentile',
            color: 'green',
			type: 'column',
            data: [<?php echo $max_profit_high_per; ?>],
            negativeColor: '#003399'
        },
		<?php //}
    ?>
		<?php //if (!empty(in_array("check4", $box_session_data))){
    ?>
		{
            name: 'Min Profit Low Percentile',
            color: '#ff6600',
			type: 'column',
            data: [<?php echo $min_profit_low_per; ?>],
            negativeColor: '#cc33ff'
        },
		<?php //}
    ?>
		// Percentile code goes END here 
		
		// BOX Trigger code goes start here 
		<?php //if (!empty(in_array("check0", $box_session_data))){
    ?>
        {
            name: 'Average Profit Box',
            color: '#ff3300',
			type: 'column',
			crosshair: true,
            data: [<?php echo $avg_profit_bar_box; ?>],
            negativeColor: 'red'
        },
		<?php //}
    ?>
		<?php //if (!empty(in_array("check1", $box_session_data))){
    ?>
		{
            name: 'Maximum Profit 5H Box',
            type: 'column',
            color: '#009900',
			crosshair: true,
            negativeColor: '#ffe6e6',
            data: [<?php echo $max_profit_5h_box; ?>],
            tooltip: {
               valueSuffix: '  <?php echo $price_format; ?>'
             }

        },
		<?php //}
    ?>
		<?php //if (!empty(in_array("check2", $box_session_data))){
    ?>
		{
            name: 'Minimum Profit 5H Box',
            type: 'column',
            color: ' #c0c0c0',
            negativeColor: ' #cc9900',
            data: [<?php echo $min_profit_5h_box; ?>],
            tooltip: {
               valueSuffix: '  <?php echo $price_format;  ?>'
             }

        },
		<?php //}
    ?>
		<?php //if (!empty(in_array("check3", $box_session_data))){
    ?>
		{
            name: 'Max Profit High Box',
            color: '#333300',
			type: 'column',
            data: [<?php echo $max_profit_high_box; ?>],
            negativeColor: '#003399'
        },
		<?php //}
    ?>
		<?php //if (!empty(in_array("check4", $box_session_data))){
    ?>
		{
            name: 'Min Profit Low Box',
            color: '#cc9900',
			type: 'column',
            data: [<?php echo $min_profit_low_box; ?>],
            negativeColor: '#ff6600'
        },
		<?php //}
    ?>
		// BOX Trigger code goes END here 
		
		
		],*/

        responsive: {
          rules: [{
            condition: {
              maxWidth: 700
            },
            chartOptions: {
              legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
              }
            }
          }]
        }


      });

      //$('#container').highcharts().xAxis[0].setExtremes(0,9);
    }

    load_hight_chart();
  </script>
  <?php //}
  ?>
  <!--Container  data Goes End here -->