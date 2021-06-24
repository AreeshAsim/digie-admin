<div class="row">
              <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white"><strong>ADD BUY ORDER TRIGGERS</strong> <span class="head-title-img-icon"><img src="<?=NEW_ASSETS;?>images/hand.png"></span></div>
                        <div class="card-body">
							<form>
                            	<div class="form-group col-12">
                                	<label>Coin</label>
                                    <select class="form-control">
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
                                	<label>Select Triggers</label>
                                    <select class="form-control">
                                        <?php if ($this->session->userdata('special_role') == 1) {?>
                                            <option value="trigger_1">trigger_1</option>
                                            <option value="trigger_2">trigger_2</option>
                                            <option value="box_trigger_3">Box Trigger_3</option>
                                            <option value="rg_15">Trigger rg_15</option>
                                            <option value="barrier_trigger">barrier_trigger</option>
                                            <option value="barrier_percentile_trigger">barrier_percentile_trigger</option>
                                          <?php } else {?>
                                            <option value="barrier_trigger">barrier_trigger</option>
                                          <?php }?>
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                	<label>Select Mode</label>
                                    <select class="form-control">
                                        <option value="" selected="selected">Select Mode</option>
                          <?php if ($this->session->userdata('global_mode') == 'live') {
    echo '<option value="live">RealTime Live</option>';
} else {
    echo '<option value="test_simulator" >Simulator Test</option>
                          <option value="test_live">RealTime Test</option>';
}?>
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                	<label>Select Stop Loss</label>
                                    <select class="form-control">
                                        <option value="stop_loss_rule_big_wall">Stop Loss Rule Big Wall </option>
                                        <option value="custom_stop_loss">Custom Stop Loss</option>
                                        <option value="aggrisive_define_percentage_followup">Aggrisive Define Percentage Followup </option>
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                	<label>Select Stop loss percentage</label>
                                    <select class="form-control">
                                       <?php for ($i = 1; $i <= 100; $i++) {?>
                                        <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                	<label>Active big wall stop loss after selected profit percentage</label>
                                    <select class="form-control">
                                        <option value="">select activate dynamic Stoploss</option>
                                        <?php
for ($i = 1; $i <= 20; $i++) {
    ?>
                                <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                                <?php
}
?>
                                    </select>
                                </div>
                                <div class="row m-0">
                                	<div class="form-group col-12 col-sm-8 col-md-8 col-lg-8">
                                        <label>Select Desired Profit Percentage</label>
                                        <select class="form-control">
                                            <option value="1000" selected="selected">Select Percentage</option>
                                            <?php for ($i = 0; $i <= 10; $i++) {?>
                                                <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                                                <?php }?>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-sm-4 col-md-4 col-lg-4">
                                        <label>Decimal</label>
                                        <input type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="row m-0">
                                	<div class="form-group col-12 col-sm-8 col-md-8 col-lg-8">
                                        <label>Select Order Level</label>
                                        <select class="form-control">
                                            <option value="level_1" selected="">Level 1</option>
                                            <option value="level_2">Level 2</option>
                                            <option value="level_3">Level 3</option>
                                            <option value="level_4">Level 4</option>
                                            <option value="level_5">Level 5</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-sm-4 col-md-4 col-lg-4">
                                        <label>Decimal</label>
                                        <input type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="row m-0">
                                    <div class="form-group col-md-12">
                                      <div class="checkbox-animated">
                                          <input id="checkbox_animated_1" name="lth_functionality" value="yes" type="checkbox">
                                          <label for="checkbox_animated_1">
                                              <span class="check"></span>
                                              <span class="box"></span>
                                              Enable Longterm Hold Functionality (If Stoploss the make the trade LTH)
                                          </label>
                                      </div>
                                    </div>
                                </div>
                                <div class="row m-0">
                                	<div class="form-group col-12 col-sm-8 col-md-8 col-lg-8">
                                        <label>Quantityl</label>
                                        <input type="number" class="form-control">
                                    </div>
                                    <div class="form-group col-12 col-sm-4 col-md-4 col-lg-4">
                                        <label>Amount In USD</label>
                                        <div class="btn btn-block btn-success">
                                        	$ 8.786
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                	<label>Inactive Date</label>
                                    <input type="datetime" class="form-control">
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-danger" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        	<span aria-hidden="true">×</span>
                                        </button>
                                    	<h4 class="alert-heading">Non-Relaiable Quantity!</h4>
                                    	<p>Minimum Quantity Should Be 2553.1914893617 Please Enter Valid Quantity</p>
                                    	<hr>
                                    	<p class="mb-0">Are you sure you want to continue click on (x) button to ignore</p>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="col-12">
                                        <button class="btn btn-success ripple light btn-block">Add Order</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
  $(document).ready(function(){

    $(document).on('change','#order_mode',function(){

      if($(this).val()== 'live'){
        $('.order_type').show();
      }else{
        $('.order_type').hide();
      }
    })


    $('#trigger_typeComment').change(function(e){



      if ($(this).val() == 'trigger_1') {
        $('#modal_p').html('Coming Soon');
         $('#myModal').modal('show');
      }else if($(this).val() == 'trigger_2'){
        $('#modal_p').html('In Trigger 2, System Checks the last demand candle and calculate the x percentage of that value, then it compares the value with the market price, if the market price is less then or equal to the x value, it will buy your order. after that it will check the market buy price and calculate the y percentage of that value if market crosses that percentage it will automatically sell your order');
         $('#myModal').modal('show');
      }
    })
  });
  calculate_min_notation();
  calculate_max_notation();
  calculate_price_in_usd();
  $("body").on("change","#coin",function(e){
   calculate_min_notation();
   calculate_max_notation();
   calculate_price_in_usd();
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
  $("body").on('change','#quantity',function() {
     calculate_price_in_usd();
   });
   $("body").on('keyup','#quantity',function() {
      var checked_min = parseFloat($('#quantity_check_min').val());
      var checked_max = parseFloat($('#quantity_check_max').val());
      var quantity = parseFloat($('#quantity').val());

      if (quantity < checked_min) {
        $('#quantitydv').html('<div class="alert alert-danger">Minimum Quantity Should Be '+checked_min+' Please Enter Valid Quantity');
        $("#add_order_p").prop("disabled","true");
         // var quantity = $('#quantity').val(checked);
      }else if(quantity > checked_max){
        $('#quantitydv').html('<div class="alert alert-danger">Maximum Quantity Should Be '+checked_max+' Please Enter Valid Quantity');
        $("#add_order_p").prop("disabled","true");
      }else{
         $('#quantitydv').html('');
         $("#add_order_p").removeAttr("disabled");
      }
    });

   $(document).on('change','.order_type',function(){
        var order_type = $(this).val();

        if(order_type == 'limit_order'){
            $('.show_hide_tip').show();
        console.log('in limit order'+order_type);
        }else{
            console.log('in market order'+order_type);
            $('.show_hide_tip').show();
        }
   })


    $(document).on('change','#checkbox_animated_1',function(){

        var ckbox = $(this);
        if(ckbox.is(':checked')){
            $('.percentage_tip').show();
        }else{
            $('.percentage_tip').hide();
        }
   })

   $(document).on('change','#defined_sell_percentage',function(){
     var sell = parseFloat($('#defined_sell_percentage').val());
     var dec = parseFloat($('#decimal').val());

     var total = sell + dec;
   if ($(this).val() != '1000') {
     $('#sell_per').val(parseFloat(total));
     $('.decimal').show();
   }else{
     $('#sell_per').val(parseFloat(total));
     $('.decimal').hide();
   }
   })

   $(document).on('change','#decimal',function(){
   var sell = parseFloat($('#defined_sell_percentage').val());
   var dec = parseFloat($('#decimal').val());

   var total = sell + dec;

   $('#sell_per').val(parseFloat(total));


   })

    $(document).ready(function(){
      $(document).on('change','#stop_loss',function(){
        var stop_loss = $(this).val();
        if(stop_loss == 'custom_stop_loss'){
           $('.show_hide_cls').show();
        }else{
          $('.show_hide_cls').hide();
        }
      })
    })


</script>