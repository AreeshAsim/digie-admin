<div id="content">
    <div class="heading-buttons bg-white border-bottom innerAll">
        <h1 class="content-heading padding-none pull-left">Reports</h1>
        <div class="clearfix"></div>
    </div>
    <div class="bg-white innerAll border-bottom">
        <ul class="menubar">
            <li class="active"><a href="<?php echo SURL; ?>admin/reports/">Reports</a></li>
            <li><a href="<?php echo SURL; ?>admin/coin_meta/view_coin_meta">Coin Meta</a></li>
            <li><a href="<?php echo SURL; ?>admin/reports/barrier_listing">Barrier Listing</a></li>
            <li><a href="<?php echo SURL; ?>admin/reports/indicator_listing">Indicator Listing</a></li>
            <li><a href="<?php echo SURL; ?>admin/reports/order_reports">Order Reports</a></li>
            <li><a href="<?php echo SURL; ?>admin/reports/get_user_order_history">Map User Order History</a></li>
        </ul>
    </div>
    <div class="innerAll spacing-x2">
        <div class="row">
                                                 <div class="table-responsive">
                                      <table class="dynamicTable display table table-stripped" id="my_tables">
                                        <thead>
<?php
if (count($final) > 0) {
	$x = 0;
	foreach ($final as $key => $value) {
		if (!empty($value)) {
			if ($x == 0) {
				$percentile_log_head = $value['percentile_log'];
				$x++;
				break;
			} else {
				continue;
			}
		}
	}
}
?>

                                          <tr>
                                            <th>Opportunity Time</th>
                                            <th>Market Price</th>
                                            <th>Market Time</th>
                                            <th>Barrier Value</th>
                                            <th>Message</th>
                                            <th>Profit Percentage</th>
                                            <th>Profit Time</th>
                                            <th>Profit Time Ago</th>
                                            <th>Loss Percentage</th>
                                            <th>Loss Time</th>
                                            <th>Loss Time Ago</th>
                                            <th>Five Hour Max Profit</th>
                                            <th>Five Hour Min Profit</th>
                                            <?php
foreach ($percentile_log_head as $heading => $val) {?>
                                                <th><?php echo ucfirst(str_replace("_", " ", $heading)) ?></th>
                                            <?php }?>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php
if (count($final) > 0) {
	foreach ($final as $key => $value) {
		if (!empty($value)) {
			?>
                                                  <tr>
                                                    <td><?=$key;?></td>
                                                    <td><?=$value['market_value'];?></td>
                                                    <td><?=$value['market_time'];?></td>
                                                    <td><?=num($value['barrier']);?></td>
                                                    <td><?=$value['message'];?></td>
                                                    <td><?=$value['profit_percentage'];?></td>
                                                    <td><?=$value['profit_date'];?></td>
                                                    <td><?=$value['profit_time'];?></td>
                                                    <td><?=$value['loss_percentage'];?></td>
                                                    <td><?=$value['loss_date'];?></td>
                                                    <td><?=$value['loss_time'];?></td>
                                                    <td><?=number_format(($value['high'] - $value['market_value']) / $value['high'] * 100, 2);?></td>
                                                    <td><?=number_format(($value['low'] - $value['market_value']) / $value['low'] * 100, 2);?></td>
                                                   <?php
$percentile_log = $value['percentile_log'];
			foreach ($percentile_log as $heading => $val) {?>
                                                <td><?php echo $val; ?></td>
                                            <?php }?>
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
</div>