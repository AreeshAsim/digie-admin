<?php

$score_avg = 0;
$psum      = 0;
$nsum      = 0;
$sum       = 0;
$x         = 0;
$count     = 0;
foreach ($news as $key => $value) {
    if ($value['score'] >= 0) {
        $psum = $psum + $value['score'];
    } else {
        $nsum = $nsum + $value['score'];
    }
    $count++;
}
$sum = $psum + (-1 * ($nsum));
$x   = $psum / $sum;
$score_avg = round($x * 100);

?>
<link rel="stylesheet" href="<?php echo SURL ?>assets/new_assets/css/style_custom.css">
	<div class="row">
              <div class="col-12">
                    <div class="card">
                      <div class="card-header bg-primary text-white"><strong>Coin Information</strong> <span class="head-title-img-icon"><img src="<?php echo SURL ?>assets/new_assets/images/hand.png"></span></div>
                      <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-7">
                                    <ul class="list-group">
                                    	<li class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                                        	Coin Logo: 
                                        	<span><img src="<?php echo SURL; ?>assets/coin_logo/<?php echo $coin['coin_logo']; ?>" class="rounded float-right" alt="<?php echo $coin['coin_name']; ?>" width="50px;"></span>
                                            
                                            
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                                        	Coin Name: 
                                        	<span class="badge badge-primary"><?php echo $coin['coin_name']; ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                                        	Coin Symbol: 
                                        	<span class="badge badge-info"><?php echo $coin['symbol']; ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                                        	Balance: 
                                        	<span class="badge badge-warning"><?php echo $coin['balance']; ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                                        	Coin Last Price:
                                        	<span class="badge badge-dark"><?php echo  $market['last_price']; ?> USD</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                                        	Coin Open Trades:
                                        	<span class="badge badge-secondary"><?php echo  $market['trade']; ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                                        	Last 24h Change: 
                                        	<span class="badge badge-success"><?php echo $market['change']; ?></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-5">
                                    <div class="meater_candle_row">
                                        <div class="meater_candle_bx">
                                            <div class="meater_candle">
                                              <div class="goal_meater_main">
                                                    <div class="goal_meater_img">
                                                        <div class="degits"><?php echo $score_avg; ?></div>
                                                        <div pin-value="<?php echo $score_avg; ?>" class="goal_pin" style="transform: rotate(249deg); zoom: 1;"></div>
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
            </div>
            <div class="row">
              <div class="col-12 mt-3">
                    <div class="card">
                      <div class="card-header bg-primary text-white"><strong>Sentiment Report</strong> <span class="head-title-img-icon"><img src="<?php echo SURL ?>assets/new_assets/images//hand.png"></span></div>
                      <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                	<img src="https://image.prntscr.com/image/aH1DwZ3HQIOAclQ17HKsEw.png" width="100%">
                                </div>
                            </div>                         
                      </div>
                    </div>
                </div>
            </div>
            
            
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