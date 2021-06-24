<?php //echo "<pre>";  print_r($coins_arr); exit; ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header bg-primary text-white"><strong>Coin Market</strong> <span class="head-title-img-icon"><img src="<?php echo SURL ?>assets/new_assets/images/hand.png"></span></div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table m-0">
            <thead>
              <tr>
                <th>Sr</th>
                <th>Coin Logo</th>
                <th>Coin Name</th>
                <th>Symbol</th>
                <th>KeyWords</th>
                <th>Unit Value</th>
                <th>Created Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
if (count($coins_arr) > 0) {
	for ($i = 0; $i < count($coins_arr); $i++) {
		?>
              <tr class="gradeX">
                <th scope="row" class="text-danger"><?php echo $i + 1; ?></th>
                <td width="100px"> <a href="<?php echo SURL . 'admin2/coins/edit-coin/' . $coins_arr[$i]['_id']; ?>" ><img class="img img-circle" src="<?php echo SURL; ?>assets/coin_logo/thumbs/<?php echo $coins_arr[$i]['coin_logo']; ?>"></a></td>
                <td><?php echo $coins_arr[$i]['coin_name']; ?></td>
                <td><?php echo $coins_arr[$i]['symbol']; ?></td>
                <td><?php echo $coins_arr[$i]['coin_keywords']; ?></td>
                <td><?php echo $coins_arr[$i]['unit_value']; ?></td>
                <td><?php echo date('d, M Y', strtotime($coins_arr[$i]['created_date_human'])); ?></td>
                <td class="center"><div class="btn-group btn-group-xs "> <a href="<?php echo SURL . 'admin2/coins/edit-coin/' . $coins_arr[$i]['_id']; ?>" class="btn btn-primary ripple light btn-sm"><i data-feather="info"></i></a> <a href="<?php echo SURL . 'admin2/coins/delete-coin/' . $coins_arr[$i]['_id']; ?>" class="btn btn-danger ripple light btn-sm" onclick="return confirm('Are you sure want to delete?')"><i data-feather="trash-2"></i></a> </div></td>
              </tr>
              <?php }
}?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
