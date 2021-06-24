
<?php //echo "<pre>";  print_r($coin_market); exit;  ?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header bg-primary text-white"><strong>Coin Market</strong> <span class="head-title-img-icon"><img src="<?php echo SURL ?>assets/new_assets/images/hand.png"></span></div>
      <div class="card-body">
        <div class="table-responsive">
          
          <div class="alert alert-primary successmessage" role="alert"   style="display:none;">
              You have successfully deleted the record .
          </div>
          <table class="table m-0">
            <thead>
              <tr>
                <th>#</th>
                <th>Coin Logo</th>
                <th>Coin Pair</th>
                <th>Last Price</th>
                <th>-24h Change</th>
                <th>Balance</th>
                <th>Open Trades</th>
                <th width="200" class="text-right">Actions</th>
              </tr>
            </thead>
            <tbody>
             <?php
			if (count($coin_market) > 0) {
				for ($i = 0; $i < count($coin_market); $i++) {
					?>
            <tr>
              <th scope="row" class="text-danger"><?php echo $i + 1; ?></td>
              <td class="logo" ><img class="img img-circle" src="<?php echo SURL; ?>assets/coin_logo/thumbs/<?php echo $coin_market[$i]['logo']; ?>" ></td>
              <td class="symbol"><?php echo $coin_market[$i]['symbol']; ?></td>
              <td class="last_price"><?php echo num($coin_market[$i]['last_price']); ?>/<?php echo $coin_market[$i]['usd_amount']; ?> USD</td>
              <td class="change_val"><?php echo num($coin_market[$i]['change']); ?></td>
              <td class="balance"><?php echo $coin_market[$i]['balance']; ?></td>
              <td class="trade"><?php echo $coin_market[$i]['trade']; ?></td>
              
              
          <td class="text-right">
		  <a href="<?php echo SURL; ?>admin2/coin-market/coin-detail/<?php echo $coin_market[$i]['symbol']; ?>" class="btn btn-primary ripple light btn-sm"> <i data-feather="info"></i> </a>
         
          <?php if ($coin_market[$i]['symbol'] != "BTC") {?>
            <a class="btn btn-danger ripple light btn-sm deletRecord"  data-id="<?php echo $coin_market[$i]['coin_id']; ?>"  href="javascript:void(0)"> <i data-feather="trash-2"></i> </a>
          <?php }?> 
         </td>    
          </tr>
          <?php
				}
			}
          ?>
            
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">


$( ".deletRecord" ).click(function() {
	
  var coin_id = $(this).data("id") ;
  
  $.ajax({
    url: '<?php echo SURL ?>admin2/user_coins/delete_coin',
    type: 'POST',
    data: {coin_id : coin_id},
    dataType: "json",
    success: function (response) {
	 $('.successmessage').show();
	 
	 setTimeout(function() {
		$('.successmessage').fadeOut('slow');
	 }, 3000); // <-- time in milliseconds
	 
	}
  });
});
  
  

 
</script>
