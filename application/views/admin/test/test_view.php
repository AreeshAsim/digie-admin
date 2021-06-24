
		<?php 
		$total_open_lth =0; $other_status_total= 0; $total_sold =0 ; $compeletion_bar = 30; ?>
		

          
            <td>
			<?php if($total_open_lth == 0 && $other_status_total == 0 &&  $total_sold == 0){?>
              <div class="progress-bar progress-bar-striped active progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:100%;border-radius:3px;color:black">
                oops Missed
			  </div>
			  <?php } elseif($compeletion_bar == 0){?>

				<div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:100%;border-radius:3px;color:black">
                <?php echo number_format($compeletion_bar, 2)."%";?>
              </div>

			  <?php } elseif($compeletion_bar != 0){?>

				<div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="10" style="width:100%;border-radius:3px;color:black">
                <?php echo number_format($compeletion_bar, 2)."%";?>
              </div>
			  <?php } ?>  
            </td>
          
           












