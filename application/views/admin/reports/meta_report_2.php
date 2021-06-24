<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>

<link href="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.css" rel="stylesheet">

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="<?php echo ASSETS ?>buyer_order/moment-with-locales.js"></script>

<script src="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">

<style>

[tooltip]{
  /* margin:20px 60px; */
  position:relative;
  display:inline-block;
}
[tooltip]::before {
    content: "";
    position: absolute;
    top:-6px;
    left:50%;
    transform: translateX(-50%);
    border-width: 4px 6px 0 6px;
    border-style: solid;
    border-color: rgba(0,0,0,0.7) transparent transparent     transparent;
    z-index: 99;
    opacity:0;
}

[tooltip-position='left']::before{
  left:0%;
  top:50%;
  margin-left:-12px;
  transform:translatey(-50%) rotate(-90deg)
}
[tooltip-position='top']::before{
  left:50%;
}
[tooltip-position='buttom']::before{
  top:100%;
  margin-top:8px;
  transform: translateX(-50%) translatey(-100%) rotate(-180deg)
}
[tooltip-position='right']::before{
  left:100%;
  top:50%;
  margin-left:1px;
  transform:translatey(-50%) rotate(90deg)
}

[tooltip]::after {
    content: attr(tooltip);
    position: absolute;
    left:50%;
    top:-6px;
    transform: translateX(-50%)   translateY(-100%);
    background: rgba(0,0,0,0.7);
    text-align: center;
    color: #fff;
    padding:4px 2px;
    font-size: 12px;
    min-width: 80px;
    border-radius: 5px;
    pointer-events: none;
    padding: 4px 4px;
    z-index:99;
    opacity:0;
}

[tooltip-position='left']::after{
  left:0%;
  top:50%;
  margin-left:-8px;
  transform: translateX(-100%)   translateY(-50%);
}
[tooltip-position='top']::after{
  left:50%;
}
[tooltip-position='buttom']::after{
  top:100%;
  margin-top:8px;
  transform: translateX(-50%) translateY(0%);
}
[tooltip-position='right']::after{
  left:100%;
  top:50%;
  margin-left:8px;
  transform: translateX(0%)   translateY(-50%);
}

[tooltip]:hover::after,[tooltip]:hover::before {
   opacity:1
}

.chosen-container {
    width: 100% !important;
}
.Input_text_s {

    float: left;

    width: 100%;

  position:relative;

  min-height: 80px;

}

.check_spec .Input_text_s {

    min-height: 0px;

}

.Input_text_s > i {

    position: absolute;

    right: 8px;

    bottom: 25px !important;

    height: 20px;

    top: auto;

}

.Input_text_btn > a > i, .Input_text_btn > button > i {

    margin-right: 10px;

}



.af-ledger-titles {

  width: 100%;

  float: left;

  display: inline-block;

}



.af-ledger-titles h2 {

  display: inline-block;

  float: left;

  width: 50%;

  text-align: center;

  border-bottom: 2px solid #eee;

  margin: 0;

  padding-bottom: 10px;

}

.af-ledger-table-debit {

  width: 50%;

  float: left;

  display: inline-table;

  text-align: center;

  border-right: 2px solid #eee;

}

.af-ledger-table-credit {

  width: 50%;

  float: left;

  display: inline-table;

  text-align: center;

}

.af-ledger-table-debit th {

  text-align: center;

  border-bottom: 2px solid #eee;

}

.af-ledger-table-credit th {

  text-align: center;

  border-bottom: 2px solid #eee;

}

.af-ledger-table-debit tbody {

  border-bottom: 2px solid #eee;

  background: #f7f7f7;

}

.af-ledger-table-credit tbody {

  border-bottom: 2px solid #eee;

  background: #f7f7f7;

}

.af-ledger-table-debit tr {

  height: 40px;

}

.af-ledger-table-credit tr {

  height: 40px;

}

.af-ledger-table-debit tfoot {

  border-bottom: 2px solid #eee;

}

.af-ledger-table-credit tfoot {

  border-bottom: 2px solid #eee;

}

.colpanel {

    float: left;

    width: 100%;

    padding: 15px 15px 0;

    box-shadow: 0 0 17px 3px rgba(0,0,0,0.1);

    border-radius: 10px;

    margin-bottom:15px;

}



.colpanel-h {

    float: left;

    width: 100%;

    border-bottom: 1px solid #eee;

    margin-bottom: 10px;

    padding-bottom: 10px;

}



.colpanel-b {

    float: left;

    width: 100%;

}

.pullright{

  float:right;

}

.full-label{

  width:100%;

}

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

            <div class="row">

              <div class="col-xs-12">

                <div class="alert alert-info"> The Time using in report is UTC (GMT + 0)</div>

              </div>

            </div>

            <form method="POST" action="<?php echo SURL; ?>admin/tester_report/tester_percentile">

              <div class="row">

                <div class="col-md-12">





                  <div class="row">

                      <div class="col-xs-12 col-md-6">

                          <div class="colpanel">

                              <div class="colpanel-h">

                                  <div class="col-xs-12 col-md-6" tooltip="Enter The new title" tooltip-position="right">

                                        <input type="radio" class="radiobtn" id="radio3" name="radio-category" value="new" checked="" />

                                        <label for="radio3">New Search</label>

                                    </div>

                                    <div class="col-xs-12 col-md-6" tooltip="Select from recent searches" tooltip-position="right">

                                        <input type="radio" class="radiobtn" id="radio4" name="radio-category" value="history" />

                                        <label for="radio4">Search History</label>

                                    </div>

                                </div>

                                <div class="colpanel-b">

                                  <div class="col-xs-12 col-sm-12 new">

                                      <div class="Input_text_s">

                                         <label class="full-label">Title: <small class="pullright">Title to Filter</small> </label>

                                         <input type="text" class="form-control" name="title_to_filter" value="<?=$filter_user_data['title_to_filter']?>">

                                      </div>

                                   </div>

                                    <div class="col-xs-12 col-sm-12 old" style="display: none;">

                                      <div class="Input_text_s">

                                         <label class="full-label">Filter Search: <small class="pullright">select filter</small></label>

                                         <select id="filter_search" name="filter_search" type="text" class="chosen-select" tabindex="4">

                                            <option value ="" <?=(($filter_user_data['filter_search'] == "") ? "selected" : "")?>>Search Filter</option>

                                            <?php

for ($i = 0; $i < count($settings); $i++) {

    if (!empty($settings[$i]['title_to_filter'])) {

        $selected = ($settings[$i]['title_to_filter'] == $filter_user_data['title_to_filter']) ? "selected" : "";

        echo "<option value='" . $settings[$i]['_id'] . "' $selected>" . $settings[$i]['title_to_filter'] . "</option>";

    }

}

?>

                                         </select>

                                      </div>

                                   </div>

                                </div>

                            </div>





                        </div>

                        <div class="col-xs-12 col-md-6">

                          <div class="colpanel">

                              <div class="colpanel-h">

                                  <div class="col-xs-12 col-md-6">

                                        <input type="radio" class="radiobtn1" id="radio1" name="radio-category2" value="new_category" checked="" />

                                        <label for="radio1">New Category</label>

                                    </div>

                                    <div class="col-xs-12 col-md-6">

                                        <input type="radio" class="radiobtn1" id="radio2" name="radio-category2" value="history_category" />

                                        <label for="radio2">Search Category</label>

                                    </div>

                                </div>

                                <div class="colpanel-b">

                                  <div class="col-xs-12 col-md-12">

                                        <div class="Input_text_s new2">

                                            <label class="full-label">Category Title:  <small class="pullright">Title to Category</small> </label>

                                            <input type="text" class="form-control" name="title_to_category" value="<?=$filter_user_data['title_to_category']?>">

                                        </div>

                                    </div>

                                    <div class="col-xs-12 col-md-12">

                                        <div class="Input_text_s old2"  style="display: none;">

                                             <label class="full-label">Filter Category: <small class="pullright">select filter</small></label>

                                             <select id="filter_search" name="category_search" type="text" class="form-control">

                                                <option value ="" <?=(($filter_user_data['filter_search'] == "") ? "selected" : "")?>>Search Filter</option>

                                                <?php

$category_arr = array_column($settings, "title_to_category");

$category_arr = array_unique($category_arr);

for ($i = 0; $i < count($category_arr); $i++) {

    if (!empty($category_arr[$i])) {

        $selected = ($category_arr[$i] == $filter_user_data['title_to_category']) ? "selected" : "";

        echo "<option value='" . $category_arr[$i] . "' $selected>" . $category_arr[$i] . "</option>";

    }

}

?>

                                             </select>
                                            <script type="text/javascript">
                                              $('.chosen-select').chosen({}).change( function(obj, result) {
                                                  console.debug("changed: %o", arguments);

                                                  console.log("selected: " + result.selected);
                                              });
                                            </script>
                                          </div>

                                    </div>

                                </div>

                            </div>





                        </div>



                    </div>



                </div>

                <div class="col-xs-12">

                    <div class="row">

                        <div class="col-xs-12">

                          <div class="colpanel" style="padding-bottom:15px;">

                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s coin_filter" tooltip="Select Coin" tooltip-position="right">

                                 <label class="full-label">Filter Coin: <small class="pullright">select coin</small></label>

                                 <select id="filter_by_coin" name="filter_by_coin" type="text" class="form-control filter_by_name_margin_bottom_sm" required="required">

                                    <option value ="" <?=(($filter_user_data['filter_by_coin'] == "") ? "selected" : "")?>>Search By Coin Symbol</option>

                                    <?php

for ($i = 0; $i < count($coins); $i++) {

    $selected = ($coins[$i]['symbol'] == $filter_user_data['filter_by_coin']) ? "selected" : "";

    echo "<option value='" . $coins[$i]['symbol'] . "' $selected>" . $coins[$i]['symbol'] . "</option>";

}

?>

                                 </select>

                              </div>

                           </div>

                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s" tooltip="Black Wall" tooltip-position="right">

                                 <label class="full-label">Black Wall:  <small class="pullright">black-pressure</small> </label>

                                 <select id="black_wall_percentile" name="black_wall_percentile" type="text" class="form-control filter_by_name_margin_bottom_sm">

                                  <option value ="">Select</option>

                                   <?php

foreach ($options as $key => $value) {

    ?>

                                    <option value ="<?=$key?>" <?php if ($key == $filter_user_data['black_wall_percentile']) {echo "selected";}?> ><?=$value;?></option>

                                   <?php }

?>

                                 </select>

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s" tooltip="Seven Level Delta pressure" tooltip-position="right">

                                 <label class="full-label">Seven Level: <small class="pullright">delta pressure</small> </label>

                                 <select id="sevenlevel_percentile" name="sevenlevel_percentile" type="text" class="form-control filter_by_name_margin_bottom_sm">

                                    <option value ="">Select</option>

                                   <?php

foreach ($options as $key => $value) {

    ?>

                                    <option value ="<?=$key?>" <?php if ($key == $filter_user_data['sevenlevel_percentile']) {echo "selected";}?> ><?=$value;?></option>

                                   <?php }

?>

                                 </select>

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s" tooltip="Big Buyers of Last 5 minute" tooltip-position="right">

                                 <label class="full-label">Big Buyers: <small class="pullright">ask contracts</small> </label>

                                 <select id="big_buyers_percentile" name="big_buyers_percentile" type="text" class="form-control filter_by_name_margin_bottom_sm">

                                  <option value ="">Select</option>

                                   <?php

foreach ($options as $key => $value) {

    ?>

                                    <option value ="<?=$key?>" <?php if ($key == $filter_user_data['big_buyers_percentile']) {echo "selected";}?> ><?=$value;?></option>

                                   <?php }

?>

                                 </select>

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Big Sellers: <small class="pullright">bid contracts</small> </label>

                                 <select id="big_sellers_percentile" name="big_sellers_percentile" type="text" class="form-control filter_by_name_margin_bottom_sm">

                                  <option value ="">Select</option>

                                   <?php

foreach ($options as $key => $value) {

    ?>

                                    <option value ="<?=$key?>" <?php if ($key == $filter_user_data['big_sellers_percentile']) {echo "selected";}?> ><?=$value;?></option>

                                   <?php }

?>

                                 </select>

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">T1 COT: <small class="pullright">5 min buy/sell</small> </label>

                                 <select id="five_buy_sell_percentile" name="five_buy_sell_percentile" type="text" class="form-control filter_by_name_margin_bottom_sm">

                                  <option value ="">Select</option>

                                   <?php

foreach ($options as $key => $value) {

    ?>

                                    <option value ="<?=$key?>" <?php if ($key == $filter_user_data['five_buy_sell_percentile']) {echo "selected";}?> ><?=$value;?></option>

                                   <?php }

?>

                                 </select>

                              </div>

                           </div>

                          <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">T4 COT: <small class="pullright">15 min buy/sell</small> </label>

                                 <select id="fifteen_buy_sell_percentile" name="fifteen_buy_sell_percentile" type="text" class="form-control filter_by_name_margin_bottom_sm">

                                  <option value ="">Select</option>

                                   <?php

foreach ($options as $key => $value) {

    ?>

                                    <option value ="<?=$key?>" <?php if ($key == $filter_user_data['fifteen_buy_sell_percentile']) {echo "selected";}?> ><?=$value;?></option>

                                   <?php }

?>

                                 </select>

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">T1 LTC: <small class="pullright">last qty b/s</small> </label>

                                 <select id="last_qty_buy_sell_percentile" name="last_qty_buy_sell_percentile" type="text" class="form-control filter_by_name_margin_bottom_sm">

                                  <option value ="">Select</option>

                                   <?php

foreach ($options as $key => $value) {

    ?>

                                    <option value ="<?=$key?>" <?php if ($key == $filter_user_data['last_qty_buy_sell_percentile']) {echo "selected";}?> ><?=$value;?></option>

                                   <?php }

?>

                                 </select>

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">T1 LTC: <small class="pullright">(last qty time)</small> </label>

                                 <select id="last_qty_time_percentile" name="last_qty_time_percentile" type="text" class="form-control filter_by_name_margin_bottom_sm">

                                  <option value ="">Select</option>

                                   <?php

foreach ($options as $key => $value) {

    ?>

                                    <option value ="<?=$key?>" <?php if ($key == $filter_user_data['last_qty_time_percentile']) {echo "selected";}?> ><?=$value;?></option>

                                   <?php }

?>

                                 </select>

                              </div>

                           </div>

                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">T3 LTC: <small class="pullright">(last qty time 15m)</small> </label>

                                 <select id="last_qty_time_fif_percentile" name="last_qty_time_fif_percentile" type="text" class="form-control filter_by_name_margin_bottom_sm">

                                  <option value ="">Select</option>

                                   <?php

foreach ($options as $key => $value) {

    ?>

                                    <option value ="<?=$key?>" <?php if ($key == $filter_user_data['last_qty_time_fif_percentile']) {echo "selected";}?> ><?=$value;?></option>

                                   <?php }

?>

                                 </select>

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Resistance Barrier: <small class="pullright">(ask)</small> </label>

                                 <select id="virtual_barrier_percentile_ask" name="virtual_barrier_percentile_ask" type="text" class="form-control filter_by_name_margin_bottom_sm">

                                  <option value ="">Select</option>

                                   <?php

foreach ($options as $key => $value) {

    ?>

                                    <option value ="<?=$key?>" <?php if ($key == $filter_user_data['virtual_barrier_percentile_ask']) {echo "selected";}?> ><?=$value;?></option>

                                   <?php }

?>

                                 </select>

                              </div>

                           </div>

                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">



                                 <label class="full-label">Support Barrier: <small class="pullright">(bid)</small> </label>

                                 <select id="virtual_barrier_percentile" name="virtual_barrier_percentile" type="text" class="form-control filter_by_name_margin_bottom_sm">

                                  <option value ="">Select</option>

                                   <?php

foreach ($options as $key => $value) {

    ?>

                                    <option value ="<?=$key?>" <?php if ($key == $filter_user_data['virtual_barrier_percentile']) {echo "selected";}?> ><?=$value;?></option>

                                   <?php }

?>

                                 </select>

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Binance Sell: <small class="pullright">(bid)</small> </label>

                                 <select id="bid_percentile" name="bid_percentile" type="text" class="form-control filter_by_name_margin_bottom_sm">

                                  <option value ="">Select</option>

                                   <?php

foreach ($options as $key => $value) {

    ?>

                                    <option value ="<?=$key?>" <?php if ($key == $filter_user_data['bid_percentile']) {echo "selected";}?> ><?=$value;?></option>

                                   <?php }

?>

                                 </select>

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Binance Buy: <small class="pullright">(ask)</small> </label>

                                 <select id="ask_percentile" name="ask_percentile" type="text" class="form-control filter_by_name_margin_bottom_sm">

                                  <option value ="">Select</option>

                                   <?php

foreach ($options as $key => $value) {

    ?>

                                    <option value ="<?=$key?>" <?php if ($key == $filter_user_data['ask_percentile']) {echo "selected";}?> ><?=$value;?></option>

                                   <?php }

?>

                                 </select>

                              </div>

                           </div>

                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Move: <small>

                                    <label class="radio-inline"><input type="radio" value="g"  name="optradio_move">greater</label>

                                    <label class="radio-inline"><input type="radio"  value="l" name="optradio_move">less</label>

                                  </small></label>

                                 <input type="text" class="form-control" name="move" id="move" value="<?=$filter_user_data['move']?>">

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Move: <small class="pullright">

                                  Move Color

                                  </small></label>

                                  <br>

                                  <select class="form-control" id="move_color" name="move_color[]" multiple="true">

                                   <option value="yellow" <?=(in_array("yellow", $filter_user_data['move_color'])) ? "selected" : ""?>>Yellow</option>

                                   <option value="white" <?=(in_array("white", $filter_user_data['move_color'])) ? "selected" : ""?>>White</option>

                                   <option value="green" <?=(in_array("green", $filter_user_data['move_color'])) ? "selected" : ""?>>Green </option>

                                   <option value="blue" <?=(in_array("blue", $filter_user_data['move_color'])) ? "selected" : ""?>>Blue</option>

                                   <option value="red" <?=(in_array("red", $filter_user_data['move_color'])) ? "selected" : ""?>>Red</option>

                                 </select>

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Big Contractors: <small class="pullright">Big Contractor

                                </small></label>

                                 <select class="form-control" id="big_contractors" name="big_contractors">

                                   <option value="" <?=$filter_user_data['big_contractors'] == '' ? "selected" : ""?>>Select</option>

                                   <option value="1" <?=$filter_user_data['big_contractors'] == '1' ? "selected" : ""?>>Top 1%</option>

                                   <option value="2" <?=$filter_user_data['big_contractors'] == '2' ? "selected" : ""?>>Top 2%</option>

                                   <option value="3" <?=$filter_user_data['big_contractors'] == '3' ? "selected" : ""?>>Top 3 %</option>

                                   <option value="4" <?=$filter_user_data['big_contractors'] == '4' ? "selected" : ""?>>Top 4%</option>

                                   <option value="5" <?=$filter_user_data['big_contractors'] == '5' ? "selected" : ""?>>Top 5%</option>

                                   <option value="10" <?=$filter_user_data['big_contractors'] == '10' ? "selected" : ""?>>Top 10%</option>

                                 </select>

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Big Contractors Delta: <small class="pullright">Big Contractor

                                </small></label>

                                  <input type="text" class="form-control" name="big_contractors_val" id="big_contractors_val" value="<?=$filter_user_data['big_contractors_val']?>">

                              </div>

                           </div>

                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Big Buyer: <small class="pullright">Big Buyer

                                </small></label>

                                 <select class="form-control" id="big_buyers" name="big_buyers">

                                   <option value="" <?=$filter_user_data['big_buyers'] == '' ? "selected" : ""?>>Select</option>

                                   <option value="1" <?=$filter_user_data['big_buyers'] == '1' ? "selected" : ""?>>Top 1%</option>

                                   <option value="2" <?=$filter_user_data['big_buyers'] == '2' ? "selected" : ""?>>Top 2%</option>

                                   <option value="3" <?=$filter_user_data['big_buyers'] == '3' ? "selected" : ""?>>Top 3 %</option>

                                   <option value="4" <?=$filter_user_data['big_buyers'] == '4' ? "selected" : ""?>>Top 4%</option>

                                   <option value="5" <?=$filter_user_data['big_buyers'] == '5' ? "selected" : ""?>>Top 5%</option>

                                   <option value="10" <?=$filter_user_data['big_buyers'] == '10' ? "selected" : ""?>>Top 10%</option>

                                 </select>

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Big Buyers Value: <small class="pullright">Big Buyers

                                </small></label>

                                  <input type="text" class="form-control" name="big_buyers_val" id="big_buyers_val" value="<?=$filter_user_data['big_buyers_val']?>">

                              </div>

                           </div>





















                            <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Big Sellers: <small class="pullright">Big Sellers

                                </small></label>

                                 <select class="form-control" id="big_sellers" name="big_sellers">

                                   <option value="" <?=$filter_user_data['big_sellers'] == '' ? "selected" : ""?>>Select</option>

                                   <option value="1" <?=$filter_user_data['big_sellers'] == '1' ? "selected" : ""?>>Top 1%</option>

                                   <option value="2" <?=$filter_user_data['big_sellers'] == '2' ? "selected" : ""?>>Top 2%</option>

                                   <option value="3" <?=$filter_user_data['big_sellers'] == '3' ? "selected" : ""?>>Top 3 %</option>

                                   <option value="4" <?=$filter_user_data['big_sellers'] == '4' ? "selected" : ""?>>Top 4%</option>

                                   <option value="5" <?=$filter_user_data['big_sellers'] == '5' ? "selected" : ""?>>Top 5%</option>

                                   <option value="10" <?=$filter_user_data['big_sellers'] == '10' ? "selected" : ""?>>Top 10%</option>

                                 </select>

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Big Sellers Value: <small class="pullright">Big Sellers

                                </small></label>

                                  <input type="text" class="form-control" name="big_sellers_Val" id="big_sellers_val" value="<?=$filter_user_data['big_sellers_Val']?>">

                              </div>

                           </div>




                                <div class="col-xs-12 col-sm-12 col-md-2" style="">

                                    <div class="Input_text_s">

                                        <label class="full-label">Last Candle Buyers Percentile: <small class="pullright">Big Contractor

                                            </small></label>

                                        <select class="form-control" id="last_candle_percentile_buy" name="last_candle_percentile_buy">

                                        <option value="" <?=$filter_user_data['last_candle_percentile_buy'] == '' ? "selected" : ""?>>Select</option>

                                            <option value="1" <?=$filter_user_data['last_candle_percentile_buy'] == '1' ? "selected" : ""?>>Top 1%</option>

                                            <option value="2" <?=$filter_user_data['last_candle_percentile_buy'] == '2' ? "selected" : ""?>>Top 2%</option>

                                            <option value="3" <?=$filter_user_data['last_candle_percentile_buy'] == '3' ? "selected" : ""?>>Top 3 %</option>

                                            <option value="4" <?=$filter_user_data['last_candle_percentile_buy'] == '4' ? "selected" : ""?>>Top 4%</option>

                                            <option value="5" <?=$filter_user_data['last_candle_percentile_buy'] == '5' ? "selected" : ""?>>Top 5%</option>

                                            <option value="10" <?=$filter_user_data['last_candle_percentile_buy'] == '10' ? "selected" : ""?>>Top 10%</option>

                                        </select>

                                    </div>

                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-2" style="">

                                    <div class="Input_text_s">

                                        <label class="full-label">Last Candle Sellers Percentile: <small class="pullright">Big Contractor

                                            </small></label>

                                        <select class="form-control" id="last_candle_percentile_sell" name="last_candle_percentile_sell">

                                            <option value="" <?=$filter_user_data['last_candle_percentile_sell'] == '' ? "selected" : ""?>>Select</option>

                                            <option value="1" <?=$filter_user_data['last_candle_percentile_sell'] == '1' ? "selected" : ""?>>Top 1%</option>

                                            <option value="2" <?=$filter_user_data['last_candle_percentile_sell'] == '2' ? "selected" : ""?>>Top 2%</option>

                                            <option value="3" <?=$filter_user_data['last_candle_percentile_sell'] == '3' ? "selected" : ""?>>Top 3 %</option>

                                            <option value="4" <?=$filter_user_data['last_candle_percentile_sell'] == '4' ? "selected" : ""?>>Top 4%</option>

                                            <option value="5" <?=$filter_user_data['last_candle_percentile_sell'] == '5' ? "selected" : ""?>>Top 5%</option>

                                            <option value="10" <?=$filter_user_data['last_candle_percentile_sell'] == '10' ? "selected" : ""?>>Top 10%</option>

                                        </select>

                                    </div>

                                </div>




                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Total Volume Percentile: <!-- <small class="pullright">formula</small> --></label>

                                                <select class="form-control" id="total_volume_percentile" name="total_volume_percentile">

                          <option value="" <?=$filter_user_data['total_volume_percentile'] == '' ? "selected" : ""?>>Select</option>

                          <option value="1" <?=$filter_user_data['total_volume_percentile'] == '1' ? "selected" : ""?>>Top 1%</option>

                          <option value="2" <?=$filter_user_data['total_volume_percentile'] == '2' ? "selected" : ""?>>Top 2%</option>

                          <option value="3" <?=$filter_user_data['total_volume_percentile'] == '3' ? "selected" : ""?>>Top 3 %</option>

                          <option value="4" <?=$filter_user_data['total_volume_percentile'] == '4' ? "selected" : ""?>>Top 4%</option>

                          <option value="5" <?=$filter_user_data['total_volume_percentile'] == '5' ? "selected" : ""?>>Top 5%</option>

                          <option value="10" <?=$filter_user_data['total_volume_percentile'] == '10' ? "selected" : ""?>>Top 10%</option>

                          <option value="15" <?=$filter_user_data['total_volume_percentile'] == '15' ? "selected" : ""?>>Top 15%</option>

                          <option value="20" <?=$filter_user_data['total_volume_percentile'] == '20' ? "selected" : ""?>>Top 20%</option>

                          <option value="25" <?=$filter_user_data['total_volume_percentile'] == '25' ? "selected" : ""?>>Top 25%</option>

                          <option value="50" <?=$filter_user_data['total_volume_percentile'] == '50' ? "selected" : ""?>>Top 50%</option>

                          <option value="75" <?=$filter_user_data['total_volume_percentile'] == '75' ? "selected" : ""?>>Top 75%</option>

                          <option value="100" <?=$filter_user_data['total_volume_percentile'] == '100' ? "selected" : ""?>>Top 100%</option>

                                                </select>

                                            </div>

                                        </div>









                                <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Candle Status: </label>

                                 <br>

                                 <select class="form-control" id="candle_status" name="candle_status[]" multiple="true">



                                   <option value="Continuation_up" <?=(in_array("Continuation_up", $filter_user_data['candle_status'])) ? "selected" : ""?>>Continuation up</option>

                                   <option value="Current_up" <?=(in_array("Current_up", $filter_user_data['candle_status'])) ? "selected" : ""?>>Current up</option>

                                   <option value="Continuation_Down" <?=(in_array("Continuation_Down", $filter_user_data['candle_status'])) ? "selected" : ""?>>Continuation Down </option>

                                   <option value="Current_Down" <?=(in_array("Current_Down", $filter_user_data['candle_status'])) ? "selected" : ""?>>Current Down</option>

                                 </select>

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Global Candle Swing Status: </label>

                                 <select class="form-control" id="swing_status" name="swing_status[]" multiple="true">

                                   <option value="HH" <?=(in_array("HH", $filter_user_data['swing_status'])) ? "selected" : ""?>>HH</option>

                                   <option value="HL" <?=(in_array("HL", $filter_user_data['swing_status'])) ? "selected" : ""?>>HL</option>

                                   <option value="LH" <?=(in_array("LH", $filter_user_data['swing_status'])) ? "selected" : ""?>>LH</option>

                                   <option value="LL" <?=(in_array("LL", $filter_user_data['swing_status'])) ? "selected" : ""?>>LL</option>

                                 </select>

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Candle Type: </label>

                                 <select class="form-control" id="candle_type" name="candle_type[]" multiple="true">

                                   <option value="demand" <?=(in_array("demand", $filter_user_data['candle_type'])) ? "selected" : ""?>>Demand</option>

                                   <option value="supply" <?=(in_array("supply", $filter_user_data['candle_type'])) ? "selected" : ""?>>Supply</option>

                                   <option value="normal" <?=(in_array("normal", $filter_user_data['candle_type'])) ? "selected" : ""?>>Normal</option>

                                 </select>

                              </div>

                           </div>

                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Rejection Type: </label>

                                 <select class="form-control" id="rejection" name="rejection[]" multiple="true">

                                   <option value="top_demand_rejection" <?=(in_array("top_demand_rejection", $filter_user_data['rejection'])) ? "selected" : ""?>>Top Demand Rejection</option>

                                   <option value="bottom_demand_rejection" <?=(in_array("bottom_demand_rejection", $filter_user_data['rejection'])) ? "selected" : ""?>>Bottom Demand Rejection</option>

                                   <option value="top_supply_rejection" <?=(in_array("top_supply_rejection", $filter_user_data['rejection'])) ? "selected" : ""?>>Top Supply Rejection </option>

                                   <option value="bottom_supply_rejection" <?=(in_array("bottom_supply_rejection", $filter_user_data['rejection'])) ? "selected" : ""?>>Bottom Supply Rejection </option>

                                 </select>

                              </div>

                           </div>

                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Total Volume: </label>

                                 <input type="text" class="form-control" name="total_volume" id="total_volume" value="<?=$filter_user_data['total_volume']?>">

                              </div>

                           </div>

                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Caption Option:<small class="pullright">option</small></label>

                                 <input type="text" class="form-control" name="caption_option" id="caption_option" value="<?=$filter_user_data['caption_option']?>">

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Caption Score:<small class="pullright">score</small></label>

                                 <input type="text" class="form-control" name="caption_score" id="caption_score" value="<?=$filter_user_data['caption_score']?>">

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Buy:<small class="pullright">buy</small></label>

                                 <input type="text" class="form-control" name="buy" id="buy" value="<?=$filter_user_data['buy']?>">

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Sell:<small class="pullright">sell</small></label>

                                 <input type="text" class="form-control" id="sell" name="sell" value="<?=$filter_user_data['sell']?>">

                              </div>

                           </div>



                            <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Demand:<small class="pullright">demand</small></label>

                                 <input type="text" class="form-control" id="demand" name="demand" value="<?=$filter_user_data['demand']?>">

                              </div>

                           </div>



                            <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Supply:<small class="pullright">supply</small></label>

                                 <input type="text" class="form-control" id ="supply" name="supply" value="<?=$filter_user_data['supply']?>">

                              </div>

                           </div>



                            <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Market Trend:<small class="pullright">market_trend</small></label>

                                 <input type="text" class="form-control" id = "market_trend" name="market_trend" value="<?=$filter_user_data['market_trend']?>">

                              </div>

                           </div>



                            <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Meta Trending:<small class="pullright">meta_trending</small></label>

                                 <input type="text" class="form-control" id="meta_trending" name="meta_trending" value="<?=$filter_user_data['meta_trending']?>">

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Risk Per Share:<small class="pullright">risk_per_share</small></label>

                                 <input type="text" class="form-control" id="risk_per_share" name="risk_per_share" value="<?=$filter_user_data['risk_per_share']?>">

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">RL:<small class="pullright">RL</small></label>

                                 <input type="text" class="form-control" id="rl" name="rl" value="<?=$filter_user_data['rl']?>">

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Target Profit:<small class="pullright">profit</small></label>

                                 <input type="text" class="form-control" id="target_profit" name="target_profit" value="<?=$filter_user_data['target_profit']?>" required="required">

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Target StopLoss:<small class="pullright">loss</small></label>

                                 <input type="text" class="form-control" id="target_stoploss" name="target_stoploss" value="<?=$filter_user_data['target_stoploss']?>" required="required">

                              </div>

                           </div>

                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Target StopLoss 2:<small class="pullright">loss second</small></label>

                                 <input type="text" class="form-control" id="target_stoploss_two" name="target_stoploss_two" value="<?=$filter_user_data['target_stoploss_two']?>" required="required">

                              </div>

                           </div>



                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">Lookup Period: <small class="pullright">duration to check</small></label>

                                 <input type="text" class="form-control" id = "lookup_period" name="lookup_period" value="<?=$filter_user_data['lookup_period']?>" required="required">

                              </div>

                           </div>

                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">From Date Range: <br></label>

                                 <input id="filter_by_start_date" name="filter_by_start_date" type="text" class="form-control datetime_picker filter_by_name_margin_bottom_sm" placeholder="Search By Date" value="<?=(!empty($filter_user_data['filter_by_start_date']) ? $filter_user_data['filter_by_start_date'] : "")?>" autocomplete="off">

                                 <i class="glyphicon glyphicon-calendar" required="required"></i>

                              </div>

                           </div>

                           <div class="col-xs-12 col-sm-12 col-md-2" style="">

                              <div class="Input_text_s">

                                 <label class="full-label">To Date Range: <br></label>

                                 <input id="filter_by_end_date" name="filter_by_end_date" type="text" class="form-control datetime_picker filter_by_name_margin_bottom_sm" placeholder="Search By Date" value="<?=(!empty($filter_user_data['filter_by_end_date']) ? $filter_user_data['filter_by_end_date'] : "")?>" autocomplete="off" required="required">

                                 <i class="glyphicon glyphicon-calendar"></i>

                              </div>

                           </div>





                           </div>

                        </div>

                    </div>

                </div>



                <div class="col-xs-12">





               <!--=================  =================== -->
                <div class="row">
                  <div class="col-xs-12">

                              <div class="colpanel">

                                  <div class="colpanel-h" style="border-bottom:none; margin-bottom:0;">

                                        <input type="checkbox" class="form-check-input" id="wick_check" name="wick_check" value="yes" <?=$filter_user_data['wick_check'] == 'yes' ? "checked" : ""?>>

                                        <label class="form-check-label" for="wick_check">Wick Percentiles</label>

                                        <label class="pullright">Check wick percentiles and quantity </label>

                                    </div>

                                    <div class="colpanel-b candle_w" style="border-bottom: 1px solid rgb(238, 238, 238); margin-top: 15px;">

                                      <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Wick Percentile: <!-- <small class="pullright">duration in hours</small> --></label>

                                                <select class="form-control" id="wick_percentile" name="wick_percentile">

                          <option value="" <?=$filter_user_data['wick_percentile'] == '' ? "selected" : ""?>>Select</option>

                          <option value="1" <?=$filter_user_data['wick_percentile'] == '1' ? "selected" : ""?>>Top 1%</option>

                          <option value="2" <?=$filter_user_data['wick_percentile'] == '2' ? "selected" : ""?>>Top 2%</option>

                          <option value="3" <?=$filter_user_data['wick_percentile'] == '3' ? "selected" : ""?>>Top 3 %</option>

                          <option value="4" <?=$filter_user_data['wick_percentile'] == '4' ? "selected" : ""?>>Top 4%</option>

                          <option value="5" <?=$filter_user_data['wick_percentile'] == '5' ? "selected" : ""?>>Top 5%</option>

                          <option value="10" <?=$filter_user_data['wick_percentile'] == '10' ? "selected" : ""?>>Top 10%</option>

                                                </select>

                                            </div>

                                        </div>


                                      <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Wick Quantity: <!-- <small>percentage</small> --></label>

                                                <input type="text" class="form-control" id="wick_qty" name="wick_qty" value="<?=$filter_user_data['wick_qty'] != '' ? $filter_user_data['wick_qty'] : ""?>">

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Total Volume Percentile: <!-- <small class="pullright">formula</small> --></label>

                                                <select class="form-control" id="total_volume" name="total_vol_percentile">

                          <option value="" <?=$filter_user_data['total_vol_percentile'] == '' ? "selected" : ""?>>Select</option>

                          <option value="1" <?=$filter_user_data['total_vol_percentile'] == '1' ? "selected" : ""?>>Top 1%</option>

                          <option value="2" <?=$filter_user_data['total_vol_percentile'] == '2' ? "selected" : ""?>>Top 2%</option>

                          <option value="3" <?=$filter_user_data['total_vol_percentile'] == '3' ? "selected" : ""?>>Top 3 %</option>

                          <option value="4" <?=$filter_user_data['total_vol_percentile'] == '4' ? "selected" : ""?>>Top 4%</option>

                          <option value="5" <?=$filter_user_data['total_vol_percentile'] == '5' ? "selected" : ""?>>Top 5%</option>

                          <option value="10" <?=$filter_user_data['total_vol_percentile'] == '10' ? "selected" : ""?>>Top 10%</option>

                          <option value="15" <?=$filter_user_data['total_vol_percentile'] == '15' ? "selected" : ""?>>Top 15%</option>

                          <option value="20" <?=$filter_user_data['total_vol_percentile'] == '20' ? "selected" : ""?>>Top 20%</option>

                          <option value="25" <?=$filter_user_data['total_vol_percentile'] == '25' ? "selected" : ""?>>Top 25%</option>

                          <option value="50" <?=$filter_user_data['total_vol_percentile'] == '50' ? "selected" : ""?>>Top 50%</option>

                          <option value="75" <?=$filter_user_data['total_vol_percentile'] == '75' ? "selected" : ""?>>Top 75%</option>

                          <option value="100" <?=$filter_user_data['total_vol_percentile'] == '100' ? "selected" : ""?>>Top 100%</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Current Hour Percentile:<!--  <small class="pullright">candle side</small> --></label>

                                                <select class="form-control" id="curr_hr_percentile" name="curr_hr_percentile">
                          <option value="" <?=$filter_user_data['curr_hr_percentile'] == '' ? "selected" : ""?>>Select</option>

                          <option value="1" <?=$filter_user_data['curr_hr_percentile'] == '1' ? "selected" : ""?>>Top 1%</option>

                          <option value="2" <?=$filter_user_data['curr_hr_percentile'] == '2' ? "selected" : ""?>>Top 2%</option>

                          <option value="3" <?=$filter_user_data['curr_hr_percentile'] == '3' ? "selected" : ""?>>Top 3 %</option>

                          <option value="4" <?=$filter_user_data['curr_hr_percentile'] == '4' ? "selected" : ""?>>Top 4%</option>

                          <option value="5" <?=$filter_user_data['curr_hr_percentile'] == '5' ? "selected" : ""?>>Top 5%</option>

                          <option value="10" <?=$filter_user_data['curr_hr_percentile'] == '10' ? "selected" : ""?>>Top 10%</option>
                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Current Hour Percentile:<!--  <small class="pullright">candle side</small> --></label>

                                                <select class="form-control" id="curr_hr_val" name="curr_hr_val">
                                                    <option value="close" <?=$filter_user_data['curr_hr_val'] == 'close' ? "selected" : ""?>>Close</option>

                                                    <option value="high" <?=$filter_user_data['curr_hr_val'] == 'high' ? "selected" : ""?>>High</option>

                                                    <option value="open" <?=$filter_user_data['curr_hr_val'] == 'open' ? "selected" : ""?>>Open</option>

                                                    <option value="low" <?=$filter_user_data['curr_hr_val'] == 'low' ? "selected" : ""?>>Low</option>
                                                </select>

                                            </div>

                                        </div>



                                    </div>

                                </div>

                            </div>
                </div>


                <div class="row">
                  <div class="col-xs-12">

                              <div class="colpanel">

                                  <div class="colpanel-h" style="border-bottom:none; margin-bottom:0;">

                                    <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Check Top X Contracts:<!--  <small class="pullright">candle side</small> --></label>

                                                <input type="checkbox" class="form-check-input" id="top3_contracts" name="top3_contracts" value="yes" <?=$filter_user_data['top3_contracts'] == 'yes' ? "checked" : ""?>>


                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">No. Of Contracts:<!--  <small class="pullright">Check Wick Side</small> --></label>

                                                <input type="number" class="form-control" placeholder="no of contractss" id="no_of_contracts" name="no_of_contracts" value="<?=$filter_user_data['no_of_contracts']?>">

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Check Contract Below:<!--  <small class="pullright">Check Wick Side</small> --></label>

                                                <select class="form-control" id="check_wick_below" name="check_wick_below">

                                                <option value="" <?=$filter_user_data['check_wick_below'] == '' ? "selected" : ""?>>Select</option>

                                                <option value="lower_wick" <?=$filter_user_data['check_wick_below'] == 'lower_wick' ? "selected" : ""?>>Lower Wick</option>

                                                <option value="body" <?=$filter_user_data['check_wick_below'] == 'body' ? "selected" : ""?>>Lower Wick and Body</option>

                                                <option value="upper_wick" <?=$filter_user_data['check_wick_below'] == 'upper_wick' ? "selected" : ""?>>Upper Wick</option>

                                                </select>

                                            </div>

                                        </div>


                                </div>

                            </div>
                          </div>
                </div>

                 <div class="row">

                  <div class="col-xs-12">

                      <div class="row">

                          <div class="col-xs-12">

                              <div class="colpanel">

                                  <div class="colpanel-h" style="border-bottom:none; margin-bottom:0;">

                                        <input type="checkbox" class="form-check-input" id="candle_chk" name="candle_chk" value="yes" <?php if ($filter_user_data['candle_chk'] == 'yes') {echo "checked";}?>>

                                        <label class="form-check-label" for="candle_chk">check for big candle</label>

                                        <label class="pullright">Check Last 24h Candle: </label>

                                    </div>

                                    <div class="colpanel-b candle" style="border-bottom:1px solid #eee; margin-top:15px; display:none;">

                                      <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Deep Candle Range: <!-- <small>percentage</small> --></label>

                                                <input type="text" class="form-control" id="candle_range" name="candle_range" value="<?=$filter_user_data['candle_range']?>">

                                            </div>

                                        </div>

                                      <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Candle Side: <!-- <small class="pullright">duration in hours</small> --></label>

                                                <select class="form-control" id="candle_side" name="candle_side">
                                                  <option value="" <?=$filter_user_data['candle_side'] == '' ? "selected" : ""?>>Select</option>
                                                <option value="up" <?=$filter_user_data['candle_side'] == 'up' ? "selected" : ""?>>Upside</option>

                                                <option value="down" <?=$filter_user_data['candle_side'] == 'down' ? "selected" : ""?>>Downside</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Formula: <!-- <small class="pullright">formula</small> --></label>

                                                <select class="form-control" id="formula" name="formula">
                                                  <option value="" <?=$filter_user_data['formula'] == '' ? "selected" : ""?>>Select</option>
                                                <option value="highlow" <?=$filter_user_data['formula'] == 'highlow' ? "selected" : ""?>>High to Low</option>

                                                <option value="openclose" <?=$filter_user_data['formula'] == 'openclose' ? "selected" : ""?>>Open to Close</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Candle Red/Blue:<!--  <small class="pullright">candle side</small> --></label>

                                                <select class="form-control" id="side" name="side">
                                                  <option value="" <?=$filter_user_data['side'] == '' ? "selected" : ""?>>Select</option>
                                                <option value="none" <?=$filter_user_data['side'] == 'none' ? "selected" : ""?>>None</option>

                                                <option value="above" <?=$filter_user_data['side'] == 'above' ? "selected" : ""?>>Above</option>

                                                <option value="below" <?=$filter_user_data['side'] == 'below' ? "selected" : ""?>>Below</option>

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-xs-12">

                              <div class="colpanel">

                                  <div class="colpanel-h" style="border-bottom:none; margin-bottom:0;">

                                         <input type="checkbox" class="form-check-input" id="candle_chk_h" name="candle_chk_h" value="yes" <?php if ($filter_user_data['candle_chk_h'] == 'yes') {echo "checked";}?>>

                                         <label class="form-check-label" for="candle_chk_h">check for hourly candle</label>

                                         <label class="pullright">Check Last hourly Candle: <!-- <small class="pullright">check for hourly candle</small> --></label>

                                    </div>

                                    <div class="colpanel-b candle_h" style="border-bottom:1px solid #eee; margin-top:15px; display:none;">

                                      <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Deep Candle Range: <!-- <small class="pullright">percentage</small> --></label>

                                                <input type="text" class="form-control" id="candle_range_h" name="candle_range_h" value="<?=$filter_user_data['candle_range_h']?>">

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                          <div class="Input_text_s">

                                                <label class="full-label">Candle Side: <!-- <small class="pullright">duration in hours</small> --></label>

                                                <select class="form-control" id="candle_side_h" name="candle_side_h">
                                                <option value="" <?=$filter_user_data['candle_side_h'] == '' ? "selected" : ""?>>Select</option>

                                                <option value="up" <?=$filter_user_data['candle_side_h'] == 'up' ? "selected" : ""?>>Upside</option>

                                                <option value="down" <?=$filter_user_data['candle_side_h'] == 'down' ? "selected" : ""?>>Downside</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                          <div class="Input_text_s">

                                                <label class="full-label">Formula: <!-- <small class="pullright">formula</small> --></label>

                                                <select class="form-control" id="formula_h" name="formula_h">
                                                  <option value="" <?=$filter_user_data['formula_h'] == '' ? "selected" : ""?>>Select</option>
                                                <option value="highlow" <?=$filter_user_data['formula_h'] == 'highlow' ? "selected" : ""?>>High to Low</option>

                                                <option value="openclose" <?=$filter_user_data['formula_h'] == 'openclose' ? "selected" : ""?>>Open to Close</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                          <div class="Input_text_s">

                                                <label class="full-label">Candle Red/Blue: <!-- <small class="pullright">candle side</small> --></label>

                                                <select class="form-control" id="side_h" name="side_h">
                                                  <option value="" <?=$filter_user_data['side_h'] == '' ? "selected" : ""?>>Select</option>
                                                <option value="none" <?=$filter_user_data['side_h'] == 'none' ? "selected" : ""?>>None</option>

                                                <option value="above" <?=$filter_user_data['side_h'] == 'above' ? "selected" : ""?>>Above</option>

                                                <option value="below" <?=$filter_user_data['side_h'] == 'below' ? "selected" : ""?>>Below</option>

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-xs-12">

                              <div class="colpanel">

                                  <div class="colpanel-h" style="border-bottom:none; margin-bottom:0;">

                                         <input type="checkbox" class="form-check-input" id="opp_chk" name="opp_chk" value="yes" <?php if ($filter_user_data['opp_chk'] == 'yes') {echo "checked";}?>>

                                         <label class="form-check-label" for="opp_chk">Check Deep Barrier</label>

                                         <label class="pullright">Deep Barrier Check: <!-- <small class="pullright">check for deep barrier</small> --></label>

                                    </div>

                                    <div class="colpanel-b deeply" style="border-bottom:1px solid #eee; margin-top:15px; display:none;">

                                      <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Deep Barrier Range: <!-- <small class="pullright">range of deep check</small> --></label>

                                                <input type="text" class="form-control" id="deep_price_check" name="deep_price_check" value="<?=$filter_user_data['deep_price_check']?>">

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Deep Barrier Lookup: <!-- <small class="pullright">duration in hours</small> --></label>

                                                <input type="text" class="form-control" id="deep_price_lookup_in_hours" name="deep_price_lookup_in_hours" value="<?=$filter_user_data['deep_price_lookup_in_hours']?>">

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-xs-12">

                              <div class="colpanel">

                                  <div class="colpanel-h" style="border-bottom:none; margin-bottom:0;">

                                         <input type="checkbox" class="form-check-input" id="barrier_check" name="barrier_check" value="yes" <?php if ($filter_user_data['barrier_check'] == 'yes') {echo "checked";}?>>

                                         <label class="form-check-label" for="barrier_check">Include Barrier Range</label>

                                         <label class="pullright">Barrier Check: <!-- <small class="pullright">check for barrier</small> --></label>

                                    </div>

                                    <div class="colpanel-b barrier" style="border-bottom:1px solid #eee; margin-top:15px; display:none;">

                                      <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Barrier Range: <!-- <small class="pullright">range of barrier</small> --></label>

                                                <input type="text" class="form-control" id="barrier_range" name="barrier_range" value="<?=$filter_user_data['barrier_range']?>">

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Barrier Side: <!-- <small class="pullright">side of barrier</small> --></label>

                                                <select class="form-control" id="barrier_side" name="barrier_side">

                                                <option value="up" <?=$filter_user_data['barrier_side'] == 'up' ? "selected" : ""?>>Upside</option>

                                                <option value="down" <?=$filter_user_data['barrier_side'] == 'down' ? "selected" : ""?>>Downside</option>

                                                </select>

                                                <!-- <input type="text" class="form-control" name="barrier_side"> -->

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Barrier Type: <!-- <small class="pullright">type of barrier</small> --></label>

                                                <select class="form-control" id="barrier_type" name="barrier_type">
                                                  <option value="" <?=$filter_user_data['barrier_type'] == '' ? "selected" : ""?>>Select</option>
                                                <option value="very_strong_barrier" <?=$filter_user_data['barrier_type'] == 'very_strong_barrier' ? "selected" : ""?>>Very Strong Barrier</option>

                                                <option value="weak_barrier" <?=$filter_user_data['barrier_type'] == 'weak_barrier' ? "selected" : ""?>>Weak Barrier</option>

                                                <option value="strong_barrier" <?=$filter_user_data['barrier_type'] == 'strong_barrier' ? "selected" : ""?>>Strong Barrier</option>

                                                </select>

                                                <!-- <input type="text" class="form-control" name="barrier_side"> -->

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-xs-12">

                              <div class="colpanel">

                                  <div class="colpanel-h" style="border-bottom:none; margin-bottom:0;">

                                         <input type="checkbox" class="form-check-input" id="candle_wick" name="candle_wick" value="yes" <?php if ($filter_user_data['candle_wick'] == 'yes') {echo "checked";}?>>

                                         <label class="form-check-label" for="candle_wick">Check Wick Candle</label>

                                         <label class="pullright">Check Wick Candle: <!-- <small class="pullright">Check Wick Candle</small> --></label>

                                    </div>

                                    <div class="colpanel-b wick" style="border-bottom:1px solid #eee; margin-top:15px; display:none;">

                                      <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Check Last Candle: <!-- <small class="pullright">Check Last Candle</small> --></label>

                                                <select class="form-control" id="candle_typ" name="candle_typ">
                                                  <option value="" <?=$filter_user_data['candle_typ'] == '' ? "selected" : ""?>>Select</option>
                                                <option value="demand" <?=$filter_user_data['candle_typ'] == 'demand' ? "selected" : ""?>>demand</option>

                                                <option value="supply" <?=$filter_user_data['candle_typ'] == 'supply' ? "selected" : ""?>>supply</option>

                                                <option value="normal_blue" <?=$filter_user_data['candle_typ'] == 'normal_blue' ? "selected" : ""?>>normal blue</option>

                                                <option value="normal_red" <?=$filter_user_data['candle_typ'] == 'normal_red' ? "selected" : ""?>>normal red</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Check Wick Side:<!--  <small class="pullright">Check Wick Side</small> --></label>

                                                <select class="form-control" id="wick_side" name="wick_side">
                                                  <option value="" <?=$filter_user_data['wick_side'] == '' ? "selected" : ""?>>Select</option>
                                                <option value="up" <?=$filter_user_data['wick_side'] == 'up' ? "selected" : ""?>>up</option>

                                                <option value="down" <?=$filter_user_data['wick_side'] == 'down' ? "selected" : ""?>>down</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Size Wick: <!-- <small class="pullright">size of wick</small> --></label>

                                                <input type="text" id="wick_size" class="form-control" name="wick_size" value="<?=$filter_user_data['wick_size']?>">

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Wick Lookup: <!-- <small class="pullright">lookup period in hours</small> --></label>

                                                <input type="text" id="wick_lookup" class="form-control" name="wick_lookup" value="<?=$filter_user_data['wick_lookup']?>">

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Trade Percentage: <!-- <small class="pullright">percentage of trade</small> --></label>

                                                <input type="text" id="trade_percentage" class="form-control" name="trade_percentage" value="<?=$filter_user_data['trade_percentage']?>">

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-xs-12">

                              <div class="colpanel">

                                  <div class="colpanel-h" style="border-bottom:none; margin-bottom:0;">

                                        <input type="checkbox" class="form-check-input" id="volume_check" name="volume_check" value="yes" <?php if ($filter_user_data['volume_check'] == 'yes') {echo "checked";}?>>

                                        <label class="form-check-label" for="volume_check">Increase in Volume</label>

                                        <label class="pullright">Increase in Volume: <small class="pullright">Increase in volume</small></label>

                                    </div>

                                    <div class="colpanel-b" style="border-bottom:1px solid #eee; margin-top:15px; display:none;">



                                    </div>

                                </div>

                            </div>

                            <div class="col-xs-12">

                              <div class="colpanel">

                                  <div class="colpanel-h" style="border-bottom:none; margin-bottom:0;">

                                        <input type="checkbox" class="form-check-input" id="tw_contract" name="tw_contract" value="yes" <?=$filter_user_data['tw_contract'] == 'yes' ? "checked" : ""?>>

                                        <label class="form-check-label" for="tw_contract">TW Contract Check</label>

                                        <label class="pullright">Exclude Trade Rules: <small class="pullright">Not to take trade</small></label>

                                    </div>

                                    <div class="colpanel-b" style="border-bottom:1px solid #eee; margin-top:15px;">

                                      <div class="colpanel-hggg">

                                  <div class="colpanel-h" style="border-bottom:none; margin-bottom:0;">

                                    <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Candle Move Color:<!--  <small class="pullright">candle side</small> --></label>

                                                <input type="checkbox" class="form-check-input" id="negate_move_color_chk" name="negate_move_color_chk" value="yes" <?=$filter_user_data['negate_move_color_chk'] == 'yes' ? "checked" : ""?>>


                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                 <label class="full-label">Move Color: <!-- <small class="pullright">

                                  Move Color

                                  </small> --></label>

                                  <br>

                                  <select class="form-control" id="negate_move_color" name="negate_move_color[]" multiple="true">

                                   <option value="yellow" <?=(in_array("yellow", $filter_user_data['negate_move_color'])) ? "selected" : ""?>>Yellow</option>

                                   <option value="white" <?=(in_array("white", $filter_user_data['negate_move_color'])) ? "selected" : ""?>>White</option>

                                   <option value="green" <?=(in_array("green", $filter_user_data['negate_move_color'])) ? "selected" : ""?>>Green </option>

                                   <option value="blue" <?=(in_array("blue", $filter_user_data['negate_move_color'])) ? "selected" : ""?>>Blue</option>

                                   <option value="red" <?=(in_array("red", $filter_user_data['negate_move_color'])) ? "selected" : ""?>>Red</option>

                                 </select>

                              </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                             <label class="full-label">Candle Type: </label>

                                             <select class="form-control" id="negate_candle_type" name="negate_candle_type[]" multiple="true">

                                               <option value="demand" <?=(in_array("demand", $filter_user_data['negate_candle_type'])) ? "selected" : ""?>>Demand</option>

                                               <option value="supply" <?=(in_array("supply", $filter_user_data['negate_candle_type'])) ? "selected" : ""?>>Supply</option>

                                               <option value="normal" <?=(in_array("normal", $filter_user_data['negate_candle_type'])) ? "selected" : ""?>>Normal</option>

                                             </select>

                                          </div>

                                        </div>


                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                             <label class="full-label">Look back period: </label>

                                             <input type="text" class="form-control" id="look_back_for_negation" name="look_back_for_negation" value="<?=$filter_user_data['look_back_for_negation']?>">

                                          </div>

                                        </div>


                                </div>

                            </div>


                            <div class="colpanel-hggg">

                                  <div class="colpanel-h" style="border-bottom:none; margin-bottom:0;">

                                    <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Candle Top Percentile:<!--  <small class="pullright">candle side</small> --></label>

                                                <input type="checkbox" class="form-check-input" id="negate_vol_chk" name="negate_vol_chk" value="yes" <?=$filter_user_data['negate_vol_chk'] == 'yes' ? "checked" : ""?>>


                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">
                                              <label class="full-label">Candle Top Percentile: </label>
                                 <select class="form-control" id="total_volume_percentile_negate" name="total_volume_percentile_negate">

                                                                    <option value="" <?=$filter_user_data['total_volume_percentile_negate'] == '' ? "selected" : ""?>>Select</option>

                                                                    <option value="1" <?=$filter_user_data['total_volume_percentile_negate'] == '1' ? "selected" : ""?>>Top 1%</option>

                                                                    <option value="2" <?=$filter_user_data['total_volume_percentile_negate'] == '2' ? "selected" : ""?>>Top 2%</option>

                                                                    <option value="3" <?=$filter_user_data['total_volume_percentile_negate'] == '3' ? "selected" : ""?>>Top 3 %</option>

                                                                    <option value="4" <?=$filter_user_data['total_volume_percentile_negate'] == '4' ? "selected" : ""?>>Top 4%</option>

                                                                    <option value="5" <?=$filter_user_data['total_volume_percentile_negate'] == '5' ? "selected" : ""?>>Top 5%</option>

                                                                    <option value="10" <?=$filter_user_data['total_volume_percentile_negate'] == '10' ? "selected" : ""?>>Top 10%</option>

                                                                    <option value="15" <?=$filter_user_data['total_volume_percentile_negate'] == '15' ? "selected" : ""?>>Top 15%</option>

                                                                    <option value="20" <?=$filter_user_data['total_volume_percentile_negate'] == '20' ? "selected" : ""?>>Top 20%</option>

                                                                    <option value="25" <?=$filter_user_data['total_volume_percentile_negate'] == '25' ? "selected" : ""?>>Top 25%</option>

                                                                    <option value="50" <?=$filter_user_data['total_volume_percentile_negate'] == '50' ? "selected" : ""?>>Top 50%</option>

                                                                    <option value="75" <?=$filter_user_data['total_volume_percentile_negate'] == '75' ? "selected" : ""?>>Top 75%</option>

                                                                    <option value="100" <?=$filter_user_data['total_volume_percentile_negate'] == '100' ? "selected" : ""?>>Top 100%</option>

                                                                </select>

                              </div>

                                        </div>

                                </div>

                            </div>


                            </div>

                                    </div>

                                </div>




                            <div class="col-xs-12">

                              <div class="colpanel">

                                  <div class="colpanel-h" style="border-bottom:none; margin-bottom:0;">

                                        <input type="checkbox" class="form-check-input" id="watch_later" name="watch_later" value="yes" >

                                        <label class="form-check-label" for="watch_later">Watch Later</label>

                                        <label class="pullright">Watch Later: <small class="pullright">wait for calculation</small></label>

                                    </div>

                                    <div class="colpanel-b" style="border-bottom:1px solid #eee; margin-top:15px; display:none;">



                                    </div>

                                </div>

                            </div>

                            <div class="col-xs-12">

                              <div class="colpanel">

                                  <div class="colpanel-h" style="border-bottom:none; margin-bottom:0;">

                                      <input type="checkbox" class="form-check-input" id="last_top2_aggregate" name="last_top2_aggregate"

                                        value="yes"  <?php if ($filter_user_data['last_top2_aggregate'] == 'yes') {echo "checked";}?>>

                                        <label class="form-check-label" for="last_top2_aggregate">Last Candle Top 2 Aggregate</label>

                                        <label class="pullright">Last Candle Top 2 Aggregate: <small class="pullright">Last Candle Top 2 Aggregate</small></label>

                                    </div>

                                    <div class="colpanel-b" style="border-bottom:1px solid #eee; margin-top:15px; display:none;">



                                    </div>

                                </div>

                            </div>

                            <div class="col-xs-12">

                              <div class="colpanel">

                                  <div class="colpanel-h" style="border-bottom:none; margin-bottom:0;">

                                      <input type="checkbox" class="form-check-input" id="last_demand_candle" name="last_demand_candle"

                                        value="yes"  <?php if ($filter_user_data['last_demand_candle'] == 'yes') {echo "checked";}?>>

                                        <label class="form-check-label" for="last_demand_candle">Check Last Demand Candle</label>

                                        <label class="pullright">Check Last Demand Candle: <small class="pullright">Check Last Demand Candle</small></label>

                                    </div>

                                    <div class="colpanel-b" style="border-bottom:1px solid #eee; margin-top:15px; display:none;">



                                    </div>

                                </div>

                            </div>

                            <div class="col-xs-12">

                              <div class="colpanel">

                                  <div class="colpanel-h" style="border-bottom:none; margin-bottom:0;">

                                      <input type="checkbox" class="form-check-input" id="price_check" name="price_check"

                                        value="yes"  <?php if ($filter_user_data['price_check'] == 'yes') {echo "checked";}?>>

                                        <label class="form-check-label" for="price_check">Coin Price Percentage</label>

                                        <label class="pullright">Coin Price Percentage: <small class="pullright">Coin Price Percentage</small></label>

                                    </div>

                                    <div class="colpanel-b" style="border-bottom:1px solid #eee; margin-top:15px;">
                                      <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Coin To Check: <!-- <small class="pullright">percentage of trade</small> --></label>

                                                <select id="price_symbol" name="price_symbol" type="text" class="form-control filter_by_name_margin_bottom_sm">

                                    <option value ="" <?=(($filter_user_data['price_symbol'] == "") ? "selected" : "")?>>Search By Coin Symbol</option>

                                    <?php

for ($i = 0; $i < count($coins); $i++) {

    $selected = ($coins[$i]['symbol'] == $filter_user_data['price_symbol']) ? "selected" : "";

    echo "<option value='" . $coins[$i]['symbol'] . "' $selected>" . $coins[$i]['symbol'] . "</option>";

}

?>

                                 </select>

                                            </div>

                                        </div>
                                        <div class="col-xs-12 col-md-3">

                                            <div class="Input_text_s">

                                                <label class="full-label">Profit Percentage: <!-- <small class="pullright">percentage of trade</small> --></label>

                                                <input type="text" class="form-control" id="price_to_check" name="price_to_check" value="<?=$filter_user_data['price_to_check']?>">

                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>



                        </div>

                    </div>

                 </div>





                   <div class="col-xs-12 col-sm-12 col-md-12">





               <!--=================  =================== -->

               <!-- ============================== -->

               <!--=================  =================== -->



        <!----------------------------------------- ---------------------------------------------->



               <script type="text/javascript">

                   $(function () {

                        $('.datetime_picker').datetimepicker({format: 'YYYY-MM-DD 12:00 A'});

                   });

               </script>

                <style>

                  .Input_text_btn {padding: 25px 0 0;}

               </style>

               <div class="col-xs-12 col-sm-12 col-md-12" style="">

                  <div class="Input_text_btn">

                     <label></label>

                     <button id="submit-form" class="btn btn-success"><i class="glyphicon glyphicon-filter"></i>Search</button>

                     <a href="<?php echo SURL; ?>admin/reports/reset_filters_report/percentile" class="btn btn-danger"><i class="fa fa-times-circle"></i>Reset</a><br><br>

                  </div>

               </div>

            </div>

            </form>

          </div>

      </div>

    <!-- Widget -->

    <div class="widget widget-inverse">

      <div class="widget-head">

       <span style="padding-left:10px;"> Meta Report </span>

        <span style="float:right;"><button class="btn btn-info" onclick="exportTableToCSV('report.csv')">Export To CSV File</button></span>

      </div>

        <div class="widget-body">

           <div class="table-responsive">

              <table class="table table-bordered">

                <thead>

                  <tr>

                    <th>Total Oppurtunities</th>

                    <th>Winning Opportunities</th>

                    <th>Winning Percentage</th>

                    <th>Losing Opportunities</th>

                    <th>Losing Percentage</th>

                    <th>Total Winning Percentage</th>

                    <th>Total Losing Percentage</th>

                    <th>Total Percentage</th>

                    <th>Per Trade Percentage Profit</th>

                    <th>Per Day Percentage Profit</th>

                  </tr>

                </thead>

                <tbody>

                  <tr>

                    <td><?php echo $final['count_msg']; ?></td>

                    <td><?php echo $final['positive_msg']; ?></td>

                    <td><?php echo $final['positive_percentage']; ?></td>

                    <td><?php echo $final['negitive_msg']; ?></td>

                    <td><?php echo $final['negitive_percentage']; ?></td>

                    <td><?php echo $final['winners']; ?></td>

                    <td><?php echo $final['losers']; ?></td>

                    <td><?php echo $final['total_profit']; ?></td>

                    <td><?php echo $final['per_trade']; ?></td>

                    <td><?php echo $final['per_day']; ?></td>

                  </tr>

                </tbody>



            </table>

            </div>

        </div>

        <div class="widget-body">

           <div class="table-responsive">

              <table class="table table-bordered">

                <thead>

                  <tr>

                    <th>Total Oppurtunities</th>

                    <th>Winning Opportunities</th>

                    <th>Winning Percentage</th>

                    <th>Losing Opportunities</th>

                    <th>Losing Percentage</th>

                    <th>Total Winning Percentage</th>

                    <th>Total Losing Percentage</th>

                    <th>Total Percentage</th>

                    <th>Per Trade Percentage Profit</th>

                    <th>Per Day Percentage Profit</th>

                  </tr>

                </thead>

                <tbody>

                  <tr>

                    <td><?php echo $final['count_msg2']; ?></td>

                    <td><?php echo $final['positive_msg2']; ?></td>

                    <td><?php echo $final['positive_percentage2']; ?></td>

                    <td><?php echo $final['negitive_msg2']; ?></td>

                    <td><?php echo $final['negitive_percentage2']; ?></td>

                    <td><?php echo $final['winners2']; ?></td>

                    <td><?php echo $final['losers2']; ?></td>

                    <td><?php echo $final['total_profit2']; ?></td>

                    <td><?php echo $final['per_trade2']; ?></td>

                    <td><?php echo $final['per_day2']; ?></td>

                  </tr>

                </tbody>



            </table>

            </div>

        </div>

        <div class="widget-body">

          <div class="table-responsive">

            <table class="table table-stripped">

              <thead>

                <tr>

                  <th>Opportunity Time</th>

                  <th>Market Price</th>

                  <th>Market Time</th>

                  <th>Barrier Value</th>

                  <th>Last Candle Value</th>

                  <th>Message With Loss 1</th>

                  <th>Profit Percentage</th>

                  <th>Profit Time</th>

                  <th>Profit Price</th>

                  <th>Profit Time Ago</th>

                  <th>Loss Percentage</th>

                  <th>Loss Time</th>

                  <th>Loss Price</th>

                  <th>Loss Time Ago</th>

                  <th>Message With Loss 2</th>

                  <th>Loss Percentage2</th>

                  <th>Loss Time2</th>

                  <th>Loss Price 2</th>

                  <th>Loss Time Ago2</th>

                   <th>Top 2 prices</th>

                   <th>Action</th>


                </tr>

              </thead>

              <tbody>

                <?php

if (count($final) > 0) {

    foreach ($final['final'] as $key => $value) {

        if (!empty($value)) {

            ?>

                        <tr>

                          <td><?=$key;?></td>

                          <td><?=$value['market_value'];?></td>

                          <td><?=$value['market_time'];?></td>

                          <td><?=$value['barrier'];?></td>

                          <td><?=$value['last_candle_value'];?></td>

                          <td><?=$value['message'];?></td>

                          <td><?=$value['profit_percentage'];?></td>

                          <td><?=$value['profit_date'];?></td>

                          <td><?=$value['proft_price'];?></td>

                          <td><?=$value['profit_time'];?></td>

                          <td><?=$value['loss_percentage'];?></td>

                          <td><?=$value['loss_date'];?></td>

                          <td><?=$value['loss_price'];?></td>

                          <td><?=$value['loss_time'];?></td>

                          <td><?=$value['message2'];?></td>

                          <td><?=$value['loss_percentage2'];?></td>

                          <td><?=$value['loss_date2'];?></td>

                          <td><?=$value['loss_price2'];?></td>

                          <td><?=$value['loss_time2'];?></td>

                          <td><?=$value['top_prices']?></td>

                          <td><button class="btn btn-success btn-verify" data-coin="<?php echo $filter_user_data['filter_by_coin'] ?>" id="<?=$key?>">Verify</button></td>
                        </tr>

                      <?php

        }

    }

}

?>

              </tbody>

            </table>

          </div>

        </div>

    </div>

    <div id="code_backup" style="display: none;"></div>

    <!-- // Widget END -->



  </div>

</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<script type="text/javascript">



$(document).on('click','.radiobtn',function(){

  var val_resp = $( ".radiobtn:checked" ).val()

    if (val_resp == 'history') {

      $(".old").show();

      $(".new").hide();

    }else if (val_resp == 'new') {

      $(".new").show();

      $(".old").hide();

    }

})



$("body").on("click",".btn-verify", function(e) {
  var hour = $(this).attr("id");
  var symbol = $(this).attr("data-coin");

  $.confirm({
    title: 'Prompt!',
    content: '' +
    '<form action="" class="formName">' +
    '<div class="form-group">' +
    '<label>Comparing Level</label>' +
    '<input type="text" placeholder="level_13" class="name form-control" required />' +
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
                }
                $.ajax({

                    url: "https://admin.digiebot.com/admin/tester_report/verify_oppurtunity",
                    type: "POST",
                    data: {name:name, hour:hour, symbol:symbol},
                    success: function(resp){
                      console.log(resp);
                      $.alert(resp.message);
                    }

                });
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
});



$("body").on("click",".radiobtn1",function(e){

  var value = $( ".radiobtn1:checked" ).val()





  if (value == 'history_category') {

    $(".old2").show();

    $(".new2").hide();

  }else if (value == 'new_category') {

    $(".new2").show();

    $(".old2").hide();

  }

});



$("body").on("change","#filter_search",function(e){

  var value = $(this).val()



  $.ajax({

    url: "<?=SURL;?>admin/reports/rest_filters_meta",

    type: "POST",

    data: {value:value, trigger:"percentile"},

    success: function(rep){
      $('input:checkbox').removeAttr('checked');
      console.log(rep);

      var rep = JSON.parse(rep);

      $.each(rep, function( key, value ) {

        if (key != 'filter_search') {

          $('#'+key).val(value);

        }

        if (key == 'candle_type' || key == 'candle_status' || key == 'rejection' || key == 'move_color') {


        // for (let elements of value) {
        //  console.log('moazam '+elements);
        //  $("#"+key+" option[value='" + elements + "']").attr('selected', 'selected');;

        $('#'+key).multiselect();
        $('#'+key).multiselect('select', value);
        $('#'+key).multiselect('refresh');
      }



        if (key == 'wick_check' || key == 'top3_contracts' || key == 'candle_chk' || key == 'candle_chk_h' || key == 'opp_chk' || key == 'barrier_check'|| key == 'candle_wick' || key == 'volume_check' || key == 'last_demand_candle' || key == 'price_check' ) {
          if (value == 'yes') {
            $("#"+key).prop( "checked", true );
          }else{
            $("#"+key).prop( "checked", false );
          }

          passwordCheck();
        }

      });

    }

  });

});



function passwordCheck(){





       if($("#opp_chk").is(":checked")) {

          $('.deeply').show();

        }else{

          $('.deeply').hide();

        }



       if($("#barrier_check").is(":checked")) {

          $('.barrier').show();

        }else{

          $('.barrier').hide();

        }





       if($("#candle_chk").is(":checked")) {

          $('.candle').show();

        }else{

          $('.candle').hide();

        }



        if($("#candle_chk_h").is(":checked")) {

          $('.candle_h').show();

        }else{

          $('.candle_h').hide();

        }



        if($("#candle_wick").is(":checked")) {

          $('.wick').show();

        }else{

          $('.wick').hide();

        }

        if($("#wick_check").is(":checked")) {

          $('.candle_w').show();

        }else{

          $('.candle_w').hide();

        }



}

$(document).ready(function(e){

  passwordCheck()

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

  </script>

  <script type="text/javascript">

    $("body").on("click","#barrier_check",function(e){

       if($(this).is(":checked")) {

          $('.barrier').show();

        }else{

          $('.barrier').hide();

        }

    });



    $("body").on("click","#opp_chk",function(e){

       if($(this).is(":checked")) {

          $('.deeply').show();

      }else{

          $('.deeply').hide();

        }

    });



    $("body").on("click","#candle_chk",function(e){

       if($(this).is(":checked")) {

          $('.candle').show();

        }else{

          $('.candle').hide();

        }

    });



    $("body").on("click","#candle_chk_h",function(e){

       if($(this).is(":checked")) {

          $('.candle_h').show();

        }else{

          $('.candle_h').hide();

        }

    });

    $("body").on("click","#wick_check",function(e){

       if($(this).is(":checked")) {

          $('.candle_w').show();

        }else{

          $('.candle_w').hide();

        }

    });



    $("body").on("click","#candle_wick",function(e){

       if($(this).is(":checked")) {

          $('.wick').show();

        }else{

          $('.wick').hide();

        }

    });



    $("body").on("click","#watch_later",function(e){

       if($(this).is(":checked")) {

          $('#code_backup').html($('.coin_filter').html());

          $('#filter_by_coin').prop("name" , "filter_by_coin[]");

          $('#filter_by_coin').prop("multiple",true);

          $('#filter_by_coin').prop("required",true);

          $('#filter_by_coin').multiselect({

          includeSelectAllOption: true,

          buttonWidth: 250,

          enableFiltering: true

        });

        }else{

          $('.btn-group').remove();

          $('.coin_filter').html($("#code_backup").html());

          $('#filter_by_coin').prop("name" , "filter_by_coin");

          $('#filter_by_coin').removeAttr("multiple");

        }

    });



    $('#candle_type').multiselect({

          includeSelectAllOption: true,

          buttonWidth: 150,

          enableFiltering: true

    });

    $('#negate_candle_type').multiselect({

          includeSelectAllOption: true,

          buttonWidth: 150,

          enableFiltering: true

    });

    $('#rejection').multiselect({

          includeSelectAllOption: true,

          buttonWidth: 150,

          enableFiltering: true

    });



    $('#move_color').multiselect({

          includeSelectAllOption: true,

          buttonWidth: 150,

          enableFiltering: true

        });

    $('#negate_move_color').multiselect({

          includeSelectAllOption: true,

          buttonWidth: 150,

          enableFiltering: true

        });


    $('#candle_status').multiselect({

          includeSelectAllOption: true,

          buttonWidth: 150,

          enableFiltering: true

        });



    $('#swing_status').multiselect({

          includeSelectAllOption: true,

          buttonWidth: 150,

          enableFiltering: true

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