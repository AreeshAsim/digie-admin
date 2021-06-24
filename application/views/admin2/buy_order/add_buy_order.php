<div class="row">
    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header bg-primary text-white"><strong>ADD BUY ORDER</strong> <span class="head-title-img-icon"><img src="<?php echo NEW_ASSETS; ?>images/hand.png"></span></div>
            <div class="card-body">
                <form>
                    <div class="form-group col-12">
                        <label>Coin</label>
                        <select class="form-control" name="coin" id="coin">
                           <?php
if (count($coins_arr) > 0) {
    for ($i = 0; $i < count($coins_arr); $i++) {
        ?>
                          <option value="<?php echo $coins_arr[$i]['symbol']; ?>" <?php if ($this->session->userdata('global_symbol') == $coins_arr[$i]['symbol']) {?> selected <?php }?>><?php echo $coins_arr[$i]['symbol']; ?></option>
                          <?php }
}?>
                        </select>
                    </div>
                    <div class="form-group col-12">
                        <label>Price</label>
                        <input type="text" name="price" value="" id="purchased_price" class="form-control">
                        <input type="hidden" name="price11" value="<?php echo $market_value; ?>" id="purchased_price_hidden" required="required" class="form-control">
                        <div class="price_error"></div>
                    </div>
                    <!-- <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="alert-heading">Non-Relaiable Price!</h4>
                            <p>You should check in the entered price. The price seems to be non-relaiable!</p>
                            <hr>
                            <p class="mb-0">Are you sure you want to continue click on (x) button to ignore</p>
                        </div>
                    </div> -->
                    <div class="form-group col-12">
                        <label>
                            <input type="checkbox" id="buy_now" class="livechecbox mr-3"> Buy On Current Market</label>
                    </div>
                    <div class="form-group col-12">
                        <div class="row">
                            <div class="col-8">
                                <label>Quantity</label>
                                <input type="text" id="quantity" name="quantity" class="form-control">
                                <input type="hidden" id="quantity_check_min" name="quantity_check_min">
                                <input type="hidden" id="quantity_check_max" name="quantity_check_max">
                            </div>
                            <div class="col-4">
                                <label>Amount In USD</label>
                                <div class="btn btn-block btn-success" id="usd">$ 0.014</div>
                            </div>
                        </div>
                         <div class="col-md-12" id="quantitydv" style="padding: 10px 0px;">

                            </div>
                    </div>
                    <div class="form-group col-12">
                        <label>Order Type</label>
                        <select class="form-control" name="order_type">
                            <option value="market_order">Market Order</option>
                        </select>
                    </div>
                    <div class="form-group col-12">
                        <label>
                            <input type="checkbox" class="livechecbox mr-3" id="trail_check" name = "trail_check"> Trail Buy</label>
                    </div>
                    <div class="form-group col-12" id="trail_buy_data" style="display:none;">
                        <label>Trail Interval</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-12">
                        <label>
                            <input type="checkbox" class="livechecbox mr-3" value="yes" id="auto_sell" name = "auto_sell"> Auto Sell</label>
                    </div>
                    <div id="auto_sell_data" style="display:none;">
                        <div class="form-group col-12">
                        <label>Profit Type</label>
                        <select class="form-control" name="profit_type" id="profit_type">
                            <option value="percentage">Percentage</option>
                            <option value="fixed_price">Fixed Price</option>
                        </select>
                    </div>
                    <div class="form-group col-12" id="sell_profit_percent_div">
                        <label>Sell Profit (%)</label>
                        <input type="text" name="sell_profit_percent" id="sell_profit_percent" class="form-control">
                        <div class="form-group col-12">
                        <span class="btn-group btn-group-xs">
                        <span class="btnbtn"><a class="btn btnval" id="btn1" data-id="1">1%</a></span>
                        <span class="btnbtn"><a class="btn btnval" id="btn2" data-id="2">2%</a></span>
                        <span class="btnbtn"><a class="btn btnval" id="btn3" data-id="3">3%</a></span>
                        <span class="btnbtn"><a class="btn btnval" id="btn5" data-id="5">5%</a></span>
                        <span class="btnbtn"><a class="btn btnval" id="btn10" data-id="10">10%</a></span>
                        <span class="btnbtn"><a class="btn btnval" id="btn15" data-id="15">15%</a></span>
                        <span class="btnbtn"><a class="btn btnval" id="btn20" data-id="20">20%</a></span>
                        <span class="btnbtn"><a class="btn btnval" id="btn25" data-id="25">25%</a></span>
                        </span>
                    </div>
                    </div>

                    <div class="form-group col-12" id="sell_profit_price_div">
                        <label>Sell Price</label>
                        <input type="text" name="sell_profit_price" id="sell_profit_price"  class="form-control">
                    </div>
                    <div class="form-group col-12">
                        <label>Order Type</label>
                        <select name="sell_order_type" class="form-control">
                            <option value="market_order">Market Order</option>
                        </select>
                    </div>
                    <div class="form-group col-12">
                        <label>
                            <input type="checkbox" value="trail_sell" id="trail_check22" name="sell_trail_check" class="livechecbox mr-3"> Trail Sell</label>
                    </div>
                    <div class="form-group col-12" id="trail_sell_data" style="display:none;">
                        <label>Trail Interval</label>
                        <input type="text" class="form-control" id="sell_trail_interval" name="sell_trail_interval">
                        <div class="form-group col-12">
                        <span class="btn-group btn-group-xs">
                        <span class="btnbtn"><a class="btn btnval2" id="btn1" data-id="0.1">.1%</a></span>
                        <span class="btnbtn"><a class="btn btnval2" id="btn2" data-id="0.2">.2%</a></span>
                        <span class="btnbtn"><a class="btn btnval2" id="btn3" data-id="0.3">.3%</a></span>
                        <span class="btnbtn"><a class="btn btnval2" id="btn5" data-id="0.4">.4%</a></span>
                        <span class="btnbtn"><a class="btn btnval2" id="btn10" data-id="0.5">.5%</a></span>
                        <span class="btnbtn"><a class="btn btnval2" id="btn15" data-id="0.6">.6%</a></span>
                        <span class="btnbtn"><a class="btn btnval2" id="btn20" data-id="0.7">.7%</a></span>
                        <span class="btnbtn"><a class="btn btnval2" id="btn26" data-id="0.8">.8%</a></span>
                        <span class="btnbtn"><a class="btn btnval2" id="btn27" data-id="0.9">.9%</a></span>
                        </span>
                    </div>
                    </div>

                    <div class="form-group col-12">
                        <label>
                            <input type="checkbox" value="yes" id="stop_loss" name="stop_loss" class="livechecbox mr-3"> Stop Loss</label>
                    </div>
                    <div class="form-group col-12" id="stop_loss_data" style="display:none;">
                        <label>Loss Percentage (%)</label>
                        <input type="text" id= "loss_percentage" name="loss_percentage"  class="form-control">
                        <div class="form-group col-12">
                        <span class="btn-group btn-group-xs">
                        <span class="btnbtn"><a class="btn btnval1" id="btn1" data-id="1">1%</a></span>
                        <span class="btnbtn"><a class="btn btnval1" id="btn2" data-id="2">2%</a></span>
                        <span class="btnbtn"><a class="btn btnval1" id="btn3" data-id="3">3%</a></span>
                        <span class="btnbtn"><a class="btn btnval1" id="btn5" data-id="5">5%</a></span>
                        <span class="btnbtn"><a class="btn btnval1" id="btn10" data-id="10">10%</a></span>
                        <span class="btnbtn"><a class="btn btnval1" id="btn15" data-id="15">15%</a></span>
                        <span class="btnbtn"><a class="btn btnval1" id="btn20" data-id="20">20%</a></span>
                        <span class="btnbtn"><a class="btn btnval1" id="btn25" data-id="25">25%</a></span>
                        </span>
                    </div>
                    </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="row d-flex justify-content-end">
                            <div class="col-12">
                                <button class="btn btn-success ripple light btn-block" id="add_order_p">Add Order</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header bg-primary text-white"><strong>Market Statistics</strong> <!-- <span class="head-title-img-icon mt-0">0.00000047</span> --></div>
            <div class="card-body">
                <!-- <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="m-0">In Zone</span>
                        <span><strong>No</strong></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="m-0">Closest Buy Zone</span>
                        <span><strong>-</strong></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="m-0">Pressure</span>
                        <span><strong>Up</strong></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="m-0">Available Quantity</span>
                        <span><strong>3753.17460000</strong></span>
                    </li>
                </ul> -->
                <div id="response_market_statistics">
                    <ul class="list-group">
                  <li>
                    <span><b>Current Market</b></span>
                    <span class="count"><?php echo $market_value; ?></span>
                  </li>
                  <li>
                    <span><b>In Zone <?php echo ucfirst($type); ?></b></span>
                    <span class="count"><?php echo ucfirst($in_zone); ?></span>
                  </li>
                  <?php if ($type == 'sell') {?>
                  <li>
                    <span><b>Closest Sell Zone</b></span>
                    <span class="count"><?php echo $start_value . ' - ' . $end_value; ?></span>
                  </li>
                  <?php } else {?>
                  <li>
                    <span><b>Closest Buy Zone</b></span>
                    <span class="count"><?php echo $start_value . ' - ' . $end_value; ?></span>
                  </li>
                  <?php }?>
                  <li>
                    <span><b>Pressure</b></span>
                    <span class="count">Up</span>
                  </li>
                  <li>
                    <span><b>Available Quantity</b></span>
                    <span class="count">0</span>
                  </li>
                </ul>
                </div>
                <div class="col-12">
                    <style>
                        @font-face {
                            src: url(https://app.digiebot.com/assets/css/km_charts/fonts/digital-7mono-italic.ttf);
                            font-family: digital-7mono-italic;
                        }

                        .meater_candle {
                            float: left;
                            width: 100%;
                        }

                        .meater_candle img {
                            display: none;
                        }

                        .goal_meater_main {
                            display: inline-block;
                            height: 177px;
                            overflow: hidden;
                        }

                        .goal_meater_img {
                            background-image: url("https://app.digiebot.com/assets/images/meter1.png");
                            background-position: center top;
                            background-repeat: no-repeat;
                            height: 354px;
                            position: relative;
                            width: 248px;
                        }

                        .degits {
                            color: #ff6600;
                            font-family: digital-7mono-italic;
                            font-size: 36px;
                            position: absolute;
                            text-align: center;
                            top: 65px;
                            width: 100%;
                        }

                        .goal_pin {
                            background-image: url("https://app.digiebot.com/assets/images/Pin1.png");
                            background-position: center top;
                            background-repeat: no-repeat;
                            bottom: 0;
                            height: 19px;
                            left: 0;
                            margin: auto;
                            position: absolute;
                            right: 1px;
                            top: -96px;
                            transform: rotate(-90deg);
                            transition: all 0.3s ease 0s;
                            width: 230px;
                        }

                        .meater_candle_row {
                            overflow: hidden;
                            padding: 50px 0;
                        }

                        .meater_candle_bx {
                            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#005cf2+0,0003e0+47,1d00a0+64,1d00a0+64,000000+100 */
                            background: rgb(0, 92, 242);
                            /* Old browsers */
                            background: -moz-radial-gradient(center, ellipse cover, rgba(0, 92, 242, 1) 0%, rgba(0, 3, 224, 1) 47%, rgba(29, 0, 160, 1) 64%, rgba(29, 0, 160, 1) 64%, rgba(0, 0, 0, 1) 100%);
                            /* FF3.6-15 */
                            background: -webkit-radial-gradient(center, ellipse cover, rgba(0, 92, 242, 1) 0%, rgba(0, 3, 224, 1) 47%, rgba(29, 0, 160, 1) 64%, rgba(29, 0, 160, 1) 64%, rgba(0, 0, 0, 1) 100%);
                            /* Chrome10-25,Safari5.1-6 */
                            background: radial-gradient(ellipse at center, rgba(0, 92, 242, 1) 0%, rgba(0, 3, 224, 1) 47%, rgba(29, 0, 160, 1) 64%, rgba(29, 0, 160, 1) 64%, rgba(0, 0, 0, 1) 100%);
                            /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                            filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#005cf2', endColorstr='#000000', GradientType=1);
                            /* IE6-9 fallback on horizontal gradient */
                            width: 292px;
                            padding: 15px 15px 15px;
                            text-align: center;
                            height: 292px;
                            border-radius: 50%;
                            display: table;
                            margin: 0 auto;
                            box-shadow: 3px 3px 18px 4px rgba(0, 0, 160, 0.3);
                        }

                        .score_mater_heading {
                            color: #ff2222;
                            font-family: digital-7mono-italic;
                            font-size: 22px;
                            margin-top: -5px;
                            display: inline-block;
                        }
                    </style>
                    <div class="meater_candle_row">
                        <div class="meater_candle_bx">
                            <div class="meater_candle">
                                <div class="goal_meater_main">
                                    <div class="goal_meater_img">
                                        <div class="degits">40</div>
                                        <div pin-value="40" class="goal_pin" style="transform: rotate(249deg); zoom: 1;"></div>
                                    </div>
                                </div>
                                <div class="score_mater_heading">SCORE METER</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    function autoload_market_buy_price()
{

  var coin = $('#coin').val();
  $.ajax({
      type:'POST',
      url:'<?php echo SURL ?>admin/dashboard/set_buy_price',
      data: {coin:coin},
      success:function(response){

         var resp = response.split('|');
          $('#purchased_price_hidden').val(resp[0]);
           if($('#buy_now').is(':checked'))
          {
            $('#purchased_price').val(resp[0]);
          }
          if (resp[1] == 'NAN') { resp[1] = 0; }
          $('.goal_pin').attr('pin-value',resp[1]);
          $('.degits').html(resp[1]);
          meaterfunction();

          setTimeout(function() {
                autoload_market_buy_price();
          }, 3000);

      }
    });
}
calculate_min_notation();
calculate_max_notation();
function autoload_bitcoin_price()
{
  $.ajax({
      type:'POST',
      url:'<?php echo SURL ?>admin/bitcoin_balance',
      data: "",
      success:function(response){

          $('#bitcoin').html(response);

          setTimeout(function() {
                autoload_bitcoin_price();
          }, 3000);

      }
    });
}
function autoload_market_statistics(){
  var coin = $('#coin').val();
    $.ajax({
      type:'POST',
      url:'<?php echo SURL ?>admin2/dashboard/autoload_market_statistics',
      data: {coin:coin},
      success:function(response){

          $('#response_market_statistics').html(response);

          setTimeout(function() {
                autoload_market_statistics();
          }, 3000);

      }
    });

}//end autoload_market_statistics()

autoload_market_statistics();
autoload_market_buy_price();
autoload_bitcoin_price();

$("body").on("change","#trail_check",function(e){
    if($(this).is(':checked'))
    {
      $('#trail_buy_data').show();
    }
    else
    {
      $('#trail_buy_data').hide();
    }
});

$("body").on("change","#coin",function(e){
   var coin = $('#coin').val();
     $(".optimized-loader").show();
  $.ajax({
      type:'POST',
      url:'<?php echo SURL ?>admin/dashboard/set_buy_price',
      data: {coin:coin},
      success:function(response){
          var resp = response.split('|');
          $('#purchased_price_hidden').val(resp[0]);
          if($('#buy_now').is(':checked'))
          {
            $('#purchased_price').val(resp[0]);
          }
          if (resp[1] == 'NAN') { resp[1] = 0}
          $('.goal_pin').attr('pin-value',resp[1]);
          $('.degits').html(resp[1]);
         meaterfunction();
         calculate_min_notation();
         calculate_max_notation();
                 autoload_market_statistics();
                 autoload_market_buy_price();

                 $(".optimized-loader").hide();


      }
    });
});

  function calculate_min_notation()
  {
    var symbol = $('#coin').val();
    var sss = "1";
    $.ajax({
      type:'POST',
      async: false,
      url:'<?php echo SURL ?>admin/buy_orders/get_min_notation',
      data: {symbol:symbol},
      success:function(response){
       $('#quantity_check_min').val(response);
      }
    });
  }


  function calculate_max_notation()
  {
    var symbol = $('#coin').val();
    var sss = "1";
    $.ajax({
      type:'POST',
      async: false,
      url:'<?php echo SURL ?>admin/buy_orders/get_max_notation',
      data: {symbol:symbol},
      success:function(response){
       $('#quantity_check_max').val(response);
      }
    });
  }
$("body").on("change","#trail_check22",function(e){
    if($(this).is(':checked'))
    {
      $('#trail_sell_data').show();
    }
    else
    {
      $('#trail_sell_data').hide();
    }
});


$("body").on("change","#auto_sell",function(e){
    if($(this).is(':checked'))
    {
      $('#auto_sell_data').show();
    }
    else
    {
      $('#auto_sell_data').hide();
    }
});


$("body").on("change","#stop_loss",function(e){
    if($(this).is(':checked'))
    {
      $('#stop_loss_data').show();
    }
    else
    {
      $('#stop_loss_data').hide();
    }
});

</script>

<script type="text/javascript">
  $('body').on('click','.btnval', function(){
      var data = $(this).attr('data-id');
//      alert(data);
    $('#sell_profit_percent').val(data);

    var sell_profit_percent = data;
    var purchased_price = $("#purchased_price").val();

    $.ajax({
    'url': '<?php echo SURL ?>admin/dashboard/convert_price',
    'type': 'POST', //the way you want to send data to your URL
    'data': {purchased_price:purchased_price,sell_profit_percent: sell_profit_percent},
    'success': function (response) { //probably this request will return anything, it'll be put in var "data"

      $("#sell_profit_price").val(response);
      $('#sell_profit_price_div').show();
    }
  });
  });
</script>


<script type="text/javascript">
  $('body').on('click','.btnval1', function(){
      var data = $(this).attr('data-id');
//      alert(data);
    $('#loss_percentage').val(data);
  });
</script>
<script type="text/javascript" src="<?php echo ASSETS; ?>js/jquery.validate.js"></script>
<script src="<?php echo ASSETS; ?>cdn_links/jquery.inputmask-2.x/dist/jquery.inputmask.bundle.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("#purchased_price").inputmask({
        mask: "9[.99999999]",
        greedy: true,
        definitions: {
            '*': {
                validator: "[0-9]"
            }
        },
        rightAlign: false
        });

        $("#purchased_price").blur(function(e){
            var purchased_price = $(this).val();
            var market_value = parseFloat($('#purchased_price_hidden').val());
            var float_price = parseFloat(purchased_price);
            var purchase_up = float_price * 2;
            var purchase_down = float_price / 2;

            if ((market_value > purchase_down) && (market_value < purchase_up)) {
                $('.price_error').html('');
            }else{
                $('.price_error').html('<br><div class="alert alert-warning alert-dismissible" role="alert">\
  <strong>Non-Relaiable Price!</strong> You should check in the entered price. The price seems to be non-relaiable!<br>Are you sure you want to continue <br> click on (x) button to ignore\
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
    <span aria-hidden="true">&times;</span>\
  </button>\
</div>');
            }


        });
    });
  $("#buy_order_form").validate();
</script>
<script type="text/javascript">

  function meaterfunction(){

var pin_val = jQuery(".goal_pin").attr("pin-value");

  var actual_pin = 2.075 * pin_val;

  var deg_rat = 166 + actual_pin;
  //alert(deg_rat);

  jQuery(".goal_pin").css({
  '-webkit-transform' : 'rotate('+deg_rat+'deg)',
     '-moz-transform' : 'rotate('+deg_rat+'deg)',
      '-ms-transform' : 'rotate('+deg_rat+'deg)',
       '-o-transform' : 'rotate('+deg_rat+'deg)',
          'transform' : 'rotate('+deg_rat+'deg)',
               'zoom' : 1

    });

}

jQuery(document).ready(function(e) {
  meaterfunction();
 });
</script>
<script type="text/javascript">

  $("body").on("click",".close",function(){
   /* $(this).parent().hide()
     if($('.digi_alert').is(':visible')){
      $('#add_order_p').attr('disabled', 'disabled');
    }
    else{
      $('#add_order_p').removeAttr("disabled");
    }*/

  });
  $(document).ready(function(){
   /* if($('.digi_alert').is(':visible')){
      $('#add_order_p').attr('disabled', 'disabled');
    }
    else{
      $('#add_order_p').removeAttr("disabled");
    }*/
  });

  $("body").on("change","#buy_now",function(e){
    if($(this).is(':checked'))
    {
      var price = $('#purchased_price_hidden').val();
      $('#purchased_price').val(price);
      $('#purchased_price').attr("readonly","true");

    }
    else
    {
      $('#purchased_price').val('');
      $('#purchased_price').removeAttr("readonly");
    }
});
</script>

<script type="text/javascript">
  $(document).ready(function(){

    $('body').on('click','.btnval2',function(e){
      //$('.pl').html(parseFloat($(this).val()).toFixed(8));
      var per = parseFloat($(this).data('id'));
      var price = parseFloat($("#purchased_price").val());

      var calculate = (price * per)/100;
     // var calculate = parseFloat(margin_total).toFixed(8);
      $('#sell_trail_interval').val(parseFloat(calculate).toFixed(8));
    });

    $("body").on('keyup','#quantity',function() {
      var checked_min = parseFloat($('#quantity_check_min').val());
      var checked_max = parseFloat($('#quantity_check_max').val());
      var quantity = parseFloat($('#quantity').val());

      if (quantity < checked_min) {
        $('#quantitydv').html('<div class="alert alert-danger">Minimum Quantity Should Be '+checked_min.toFixed(2)+' Please Enter Valid Quantity');
        $("#add_order_p").prop("disabled","true");
         // var quantity = $('#quantity').val(checked);
      }else if(quantity > checked_max){
        $('#quantitydv').html('<div class="alert alert-danger">Maximum Quantity Should Be '+checked_max.toFixed(2)+' Please Enter Valid Quantity');
        $("#add_order_p").prop("disabled","true");
      }else{
         $('#quantitydv').html('');
         $("#add_order_p").removeAttr("disabled");
      }
    });
  });

    function calculate_price_in_usd()
  {
    var quantity = $('#quantity').val();
    var symbol = $('#coin').val();
    $.ajax({
      type:'POST',
      async: false,
      url:'<?php echo SURL ?>admin/buy_orders/calculate_amount_in_usd',
      data: {quantity:quantity,symbol:symbol},
      success:function(response){
       $('#usd').html(response);
      }
    });
  }
  $("body").on('blur','#quantity',function() {
     calculate_price_in_usd();
   });
</script>