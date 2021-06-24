<div class="row">
				<?php if(isset($_GET['market_value']) && $_GET['market_value'] !=""){ ?>
                <input type="hidden" value="<?php echo $market_value; ?>" id="market_value">
                <?php } ?>
            	<div class="col-12 col-md-4">
                    <div class="card">
                    	<div class="card-header bg-danger text-white"><strong>Buy (<?php echo number_format($market_value, 7, '.', ''); ?>)</strong> <span class="head-title-img-icon"><img src="<?php echo NEW_ASSETS; ?>images/hand.png"></span></div>
                    	<div class="card-body pt-0">
                        	<div class="row-table">
                            	<div class="table-responsive">
                                  <div id="response_buy_trade">
                                	<table class="table">
                                    	<thead>
                                        	<tr>
                                            	<th class="text-danger text-center">#</th>
                                            	<th class="text-danger">Price (BTC)</th>
                                                <th class="text-danger">Amount (<?php echo $currncy;?>)</th>
                                                <th class="text-danger">Total (BTC)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
											if(count($market_buy_depth_arr)>0){
											$cnt=0;	
											foreach ($market_buy_depth_arr as $key => $value) {
												$cnt++;
												$lenth22 =  strlen(substr(strrchr($value['price'], "."), 1));
												if($lenth22==6){
													$price = $value['price'].'0';
												}else{
												
													$price = $value['price'];
												} 
												
												?>
												
												<tr>
                                                	<td class="text-center"><?php echo $cnt; ?></td>
													<td><?php echo number_format($price,8,".","");?></td>
													<td><?php echo number_format($value['quantity'], 2, '.', '');?></td>
													<td>
														<?php 
														$total_price = $value['price'] * $value['quantity'];
														echo number_format($total_price, 7, '.', '');
														?>
													</td>
												</tr>
											
											<?php }
											} 
                                        ?> 
                                        </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                    	</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                	<div class="card">
                    	<div class="card-header bg-success text-white"><strong>Sell (<?php echo number_format($market_value, 7, '.', ''); ?>)</strong> <span class="head-title-img-icon"><img src="<?php echo NEW_ASSETS; ?>images/wallet.png"></span></div>
                    	<div class="card-body pt-0">
                    		<div class="row-table">
                            	<div class="table-responsive">
                                   <div id="response_sell_trade">
                                	<table class="table">
                                    	<thead>
                                        	<tr>
                                            	<th class="text-success text-center">#</th>
                                            	<th class="text-success">Price (BTC)</th>
                                                <th class="text-success">Amount(<?php echo $currncy;?>)</th>
                                                <th class="text-success">Total (BTC)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php 
                                            if(count($market_sell_depth_arr)>0){
												$cnt2=0;	
												foreach ($market_sell_depth_arr as $key => $value2) { 
												$cnt2++;
												$lenth33 =  strlen(substr(strrchr($value2['price'], "."), 1));
													if($lenth33==6){
													$price22 = $value2['price'].'0';
													}else{
													$price22 = $value2['price'];
													} 
												?>
												<tr>
                                                	<td class="text-center"><?php echo $cnt2; ?></td>
                                                    <td><?php echo number_format($price22,8,".","");?></td>
                                                    <td><?php echo number_format($value2['quantity'], 2, '.', ''); ?></td>
                                                    <td>
                                                    	<?php 
															$total_price2 = $value2['price'] * $value2['quantity'];
															echo number_format($total_price2, 7, '.', '');
                                                    	?>  
                                                    </td>
												</tr>
												<?php }
                                            } 
                                            ?>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                    	</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                	<div class="card">
                    	<div class="card-header bg-primary text-white"><strong>Trade History</strong> <span class="head-title-img-icon"><img src="<?php echo NEW_ASSETS; ?>images/layer.png"></span></div>
                    	<div class="card-body pt-0">
                    		<div class="row-table">
                            	<div class="table-responsive">
                                	<div id="response_market_history">
                                	   <table class="table">
                                    	<thead>
                                        	<tr>
                                            	<th class="text-primary text-center">#</th>
                                            	<th class="text-primary">Price (BTC)</th>
                                                <th class="text-primary">Amount (<?php echo $currncy;?>)</th>
                                                <th class="text-primary text-">Total (BTC)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php 
												if(count($market_history_arr)>0){
													$cnt3=0;	
													foreach ($market_history_arr as $key => $value3) { 
													$cnt3++;
														$maker = $value3['maker'];
														if($maker=='true'){
															$color="text-danger";
														}else{
															$color="text-success";
														}
														?>
														<tr>
                                                        	<td class="<?php echo $color; ?>"><?php echo $cnt3; ?></td>
                                                            <td class="<?php echo $color; ?>"><?php echo number_format($value3['price'], 8, '.', ''); ?></td>
                                                            <td class="<?php echo $color; ?>"><?php echo number_format($value3['quantity'], 2, '.', '');?></td>
                                                            <td class="<?php echo $color; ?>">
																<?php 
                                                                	$total_price3 = $value3['price'] * $value3['quantity'];
                                                                	echo number_format($total_price3, 7, '.', '');
                                                                ?>
                                                            </td>
														</tr>
													<?php }
												} 
                                            ?>
                                        </tbody>
                                    </table>
                                    </div>
                                  </div>
                                </div>
                            </div>
                    	</div>
                    </div>
                </div>
            </div>
 <script type="text/javascript">

  var call_statusinterval;
  var auto_refresh;
 
  function autoload_trading_data(){

      var market_value = $("#market_value").val();
    
      $.ajax({
        type:'POST',
        url:'<?php echo SURL?>admin2/dashboard/autoload_trading_data',
        data: {market_value:market_value},
        success:function(response){

          var split_response = response.split('|');

          if(split_response[0] !=""){
            $('#response_sell_trade').html(split_response[0]);
            $('#response_market_value_sell').html('Sell ('+split_response[3]+')');
          }
          if(split_response[1] !=""){
            $('#response_buy_trade').html(split_response[1]);
            $('#response_market_value_buy').html('Buy ('+split_response[3]+')');
          }
          if(split_response[2] !=""){
            $('#response_market_history').html(split_response[2]);
          }
          
          
          setTimeout(function() {
              autoload_trading_data();
          }, 1000);
         //autoload_trading_data();

        }
      });

  }//end autoload_trading_data() 

  autoload_trading_data();
  
</script>