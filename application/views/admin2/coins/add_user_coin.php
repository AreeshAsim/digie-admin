


<div class="row loader-outer">


  <div class="loader-iner" style="display:none;">
    <div class="loadicon">
      <div class="spinner-border text-primary" role="status"> <span class="sr-only">Loading...</span> </div>
    </div>
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-header bg-primary text-white"><strong>User Coin Listing</strong> <span class="head-title-img-icon"><img src="<?php echo SURL ?>assets/new_assets/images/hand.png"></span></div>
      <div class="card-body pt-5 pb-5 pl-5 pr-5">
        <div class="col-12">
          <div class="alert alert-primary alert-dismissable showmessage" style="display:none;"></div>
          <div class="row">
            <?php
                  if (count($all_coins_arr) > 0) {
                    for ($i=0; $i < count($all_coins_arr); $i++) {
                    ?>
            <?php if (in_array($all_coins_arr[$i]['symbol'], $coins_arr)){ ?>
            <div class="form-group col-12 col-sm-4 col-md-3 col-lg-2">
              <div class="btnchecbox">
                <div class="btn-test-checked">
                  <input type="checkbox"  value="<?php echo $all_coins_arr[$i]['_id'] ?>" checked="checked"   readonly="readonly">
                  <span><?php echo $all_coins_arr[$i]['coin_name']; ?></span> </div>
              </div>
            </div>
            <?php }else{ ?>
            <div class="form-group col-12 col-sm-4 col-md-3 col-lg-2">
              <div class="btnchecbox">
                <div class="btn-test-checked">
                  <input type="checkbox" class="checkbox" value="<?php echo $all_coins_arr[$i]['_id'] ?>">
                  <span><?php echo $all_coins_arr[$i]['coin_name']; ?></span> </div>
              </div>
            </div>
            <?php 
							 }
                            }
                         }
                       ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">


			jQuery(".checkbox").change(function() {
				
				if(this.checked) {
					 var checkedVal = [];
					 jQuery.each($(".checkbox:checked"), function(){            
						checkedVal.push($(this).val());
					 });	
				}
				
				jQuery('.loader-iner').show();
				var coin    =   jQuery(this).val(); 
				var coinVal =   jQuery(this).closest(".btn-test-checked").find("span").text();
                jQuery.confirm({
                    title: 'Confirmation',
                    content: 'Are you sure you want to add the coin in your profile <b>'+coinVal+'</b>',
                    icon: 'fa fa-warning',
                    animation: 'zoom',
                    closeAnimation: 'zoom',
                    opacity: 0.5,
                    buttons: {
                    confirm: {
                        text: 'Yes, sure!',
                        btnClass: 'btn-green',
                        action: function (){
							jQuery.ajax({
									url: '<?php echo SURL ?>admin2/user_coins/updateUserCoin',
									type: 'POST',
									data: {checkedVal:checkedVal},
									dataType: "json",
									success: function (response) {
									 jQuery('.showmessage').show();
									 jQuery('.showmessage').html('You have succesfully update the coins name  <b>'+coinVal+'</b>' );
									 jQuery('.loader-iner').hide();
									 setTimeout(function() {
									   jQuery('.showmessage').hide();
									 }, 3000);		 
									}
							});
                        }
                    },
                    cancel: function () {jQuery('.loader-iner').hide();}
                }
           });
		});		
			
			
			
		
</script>

