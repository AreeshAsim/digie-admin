
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.2.2/css/buttons.bootstrap.min.css'>
<script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-de7e2ef6bfefd24b79a3f68b414b87b8db5b08439cac3f1012092b2290c719cd.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
<script src='https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js'></script>
<script src='https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js'></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js'></script>
<script src='https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js'></script>
<script src='https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js'></script>


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<style>
.failed {
    background: #e8bdbd !important;
}

.ax_2, .ax_3, .ax_4, .ax_5, .ax_6, .ax_7, .ax_8, .ax_9, .ax_10, .ax_11, .ax_12, .ax_13, .ax_14, .ax_15, .ax_16, .ax_17, .ax_18, .ax_19, .ax_20, .ax_21, .ax_22, .ax_23, .ax_24 {
    padding-bottom: 35px !important;
}
.success-custom {
    background: rgb(203, 255, 203) !important;
}
.text-success-custom {
    color : #0d420d;
}
.text-danger-custom {
    color : #801515;
}
</style>
<div id="content">
  <h1 class="content-heading bg-white border-bottom"></h1>
  <div class="innerAll bg-white border-bottom">
  <ul class="menubar">
  <li class="active"><a href="<?php echo SURL; ?>/admin/dashboard-support/get_kraken_user_order_history"></a></li>
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
    <?php $filter_user_data = $this->session->userdata('filters'); ?>
    <!-- Widget -->
    <div class="widget widget-inverse">
      <div class="widget-body padding-bottom-none">
        <!-- Form -->
        <div class="widget widget-inverse">
         <div class="widget-body">
            <form method="POST" action="<?php echo SURL; ?>admin/TradeHistory/showDuplicationTradeHistoryDetails">
              <div class="row">


              <!-- <div class="col-xs-12 col-sm-12 col-md-3 ax_2">
                <div class="Input_text_s">
                  <label>Filter Coin: </label>
                  <select id="filter_by_coin" multiple="multiple" name="filter_by_coin[]" type="text" class=" filter_by_name_margin_bottom_sm">
                    <?php foreach($coins as $coinRow){  ?>      
                    <option value="<?php echo $coinRow['symbol'] ?>" <?php if (in_array($coinRow['symbol'], $filter_user_data['filter_by_coin'])) {?> selected <?php }?>><?php echo $coinRow['symbol'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div> -->

                <div class="col-xs-12 col-sm-12 col-md-3 ax_2">
                    <div class="Input_text_s">
                        <label>Exchange: </label>
                        <select id="exchange" name="exchange" type="text" class="form-control filter_by_name_margin_bottom_sm">
                            <option value="binance"<?=(($filter_user_data['exchange'] == "binance") ? "selected" : "")?>>Binance</option>
                            <option value="bam"<?=(($filter_user_data['exchange'] == "bam") ? "selected" : "")?>>Bam</option>
                            <option value="kraken"<?=(($filter_user_data['exchange'] == "kraken") ? "selected" : "")?>>kraken</option>
                        </select>
                    </div>
                </div> 
               
               <div class="col-xs-12 col-sm-12 col-md-3 ax_3"  style="padding-bottom: 6px;">
                  <div class="Input_text_s">
                     <label>Filter Username: </label>
                     <input type="text" class="form-control filter_by_name_margin_bottom_sm" placeholder="username" name="username" id="username" value="<?=(!empty($filter_user_data['username']) ? $filter_user_data['username'] : "")?>">
                  </div>
               </div>


               <div class="col-xs-12 col-sm-12 col-md-3 ax_4">
                    <div class="Input_text_s">
                        <label>Type: </label>
                        <select id="order" name="order" type="text" class="form-control filter_by_name_margin_bottom_sm">
                            <option value="both"<?=(($filter_user_data['order'] == "both") ? "selected" : "")?>>Both</option>
                            <option value="buy" <?=(($filter_user_data['order'] == "buy")  ? "selected" : "")?>>Buy</option>
                            <option value="sell"<?=(($filter_user_data['order'] == "sell") ? "selected" : "")?>>Sell</option>
                        </select>
                    </div>
                </div> 



               <div class="col-xs-12 col-sm-12 col-md-3 ax_4">
                    <div class="Input_text_s">
                        <label>Order Type: </label>
                        <select id="orderTypes" name="orderTypes" type="text" class="form-control filter_by_name_margin_bottom_sm">
                            <option value="all"<?=(($filter_user_data['orderTypes'] =="all") ? "selected" : "")?>>All</option>
                            <option value="market" <?=(($filter_user_data['orderTypes'] == "market")  ? "selected" : "")?>>Market Order</option>
                            <option value="limit"<?=(($filter_user_data['orderTypes'] == "limit") ? "selected" : "")?>>Limit Order</option>
                        </select>
                    </div>
                </div> 



                <div class="col-xs-12 col-sm-12 col-md-3 ax_5">
                    <div class="Input_text_s">
                        <label>Status: </label>
                        <select id="status" name="status" type="text" class="form-control filter_by_name_margin_bottom_sm">
                            <option value="all"<?=(($filter_user_data['status'] =="all") ? "selected" : "")?>>All</option>
                            <option value="user_doubt" <?=(($filter_user_data['status'] == "user_doubt")  ? "selected" : "")?>>User Doubt</option>
                            <option value="digie_confirmed_duplicate"<?=(($filter_user_data['status'] == "digie_confirmed_duplicate") ? "selected" : "")?>>Digie Confirmed Duplicate</option>
                            <option value="mapped"<?=(($filter_user_data['status'] == "mapped") ? "selected" : "")?>>Mapped</option>
                            <option value="user_confirmed_duplicate"<?=(($filter_user_data['status'] == "user_confirmed_duplicate") ? "selected" : "")?>> User Confirmed Duplicate</option>
                            <option value="97_per_digie_doubt"<?=(($filter_user_data['status'] == "97_per_digie_doubt") ? "selected" : "")?>> 97 per digie duplicate doubt </option>
                            
                        </select>
                    </div>
                </div> 
            

                <div class="col-xs-12 col-sm-12 col-md-3 ax_6">
                    <div class="Input_text_s">
                        <label>From Date Range: </label>
                        <input id="start_date" name="start_date" type="date" class="form-control datetime_picker filter_by_name_margin_bottom_sm" value="<?=(!empty($filter_user_data['start_date']) ? $filter_user_data['start_date'] : "")?>" autocomplete="off">
                        
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-3 ax_7">
                    <div class="Input_text_s">
                        <label>To Date Range: </label>
                        <input id="end_date" name="end_date" type="date" class="form-control datetime_picker filter_by_name_margin_bottom_sm" value="<?=(!empty($filter_user_data['end_date']) ? $filter_user_data['end_date'] : "")?>" autocomplete="off">
                    </div>
                </div>

               <div class="col-xs-12 col-sm-12 col-md-12 ax_8" style="padding-bottom: 6px;">
                  <div class="Input_text_btn">
                     <label></label>
                     <button id="submit-form" class="btn btn-success"><i class="glyphicon glyphicon-filter"></i>Search</button>
                  </div>
               </div>
            </div>
            </form>
          </div>
      </div>

        <!-- End Form -->
        <!-- Table -->
        <table id="example" class="table table-bordered" cellspacing="0" width="100%">
            <thead class="thead-dark">
                <tr>
                    <th style="text-align:center;" scope="col">#</th>
                    <th style="text-align:center;" scope="col">User Name</th>
                    <th style="text-align:center;" scope="col">Ordertxid</th>
                    <th style="text-align:center;" scope="col">Symbol</th>
                    <th style="text-align:center;" scope="col">Date</th>
                    <th style="text-align:center;" scope="col">type</th>
                    <th style="text-align:center;" scope="col">Order type</th>
                    <th style="text-align:center;" scope="col">Price</th>
                    <th style="text-align:center;" scope="col">Qty</th>
                    <th style="text-align:center;" scope="col">Cost</th>
                    <th style="text-align:center;" scope="col">Fee</th>
                    <th style="text-align:center;" scope="col">Leverage</th>
                    <th style="text-align:center;" scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php for($iteratoin = 0; $iteratoin < count($orders); $iteratoin++ ){ ?>
                    <tr style="text-align:center;" class="gradeX">
                        <td><?php echo $iteratoin; ?></td>
                        <td><?php echo $orders[$iteratoin]['username']; ?></td>
                        <td><?php echo $orders[$iteratoin]['TransactionID']; ?></td>
                        <td><?php echo $orders[$iteratoin]['pair']; ?></td>
                        <td>
                            <?php //echo $orders[$iteratoin]['time']; 
                                echo $orders[$iteratoin]['time']->toDateTime()->format("Y-m-d H:i:s");
                            ?>
                        </td>
                        <td><?= ($orders[$iteratoin]['type'] == 'sell') ? "<span class='text-danger-custom'>SELL</span>" : "<span class='text-success-custom'>BUY</span>";?></td>
                        <td><?php echo $orders[$iteratoin]['OrderType']; ?></td>
                        <td><?php echo $orders[$iteratoin]['price']; ?></td>
                        <td><?php echo $orders[$iteratoin]['qty']; ?></td>
                        <td><?php echo $orders[$iteratoin]['cost']; ?></td>
                        <td><?php echo number_format($orders[$iteratoin]['fee'], 6); ?></td>
                        <td><?php echo $orders[$iteratoin]['leverage']; ?></td>
                        <td><?php echo $orders[$iteratoin]['status'];?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- // Table END -->
      </div>
    </div>
    <div>Total_Count: <?php echo $total; ?></div>
    <div><?php echo $links; ?></div>
    <!-- // Widget END -->
  </div>
</div>
<script>


// $('.click').click(function(){
//   var currentRow=$(this).closest("tr"); 
//   var username = currentRow.find("td:eq(1)").text(); // get current row 1st TD value
//   var symbol   = currentRow.find("td:eq(3)").text(); // get current row 1st TD value
//   var type = currentRow.find("td:eq(5)").text(); // get current row 2nd TD

//   var enable_status = currentRow.find("td:eq(4)").text(); // get current row 4th TD
// });



$(function() {
$("#example").find("tr").each(function () {
    $("td").filter(function() {
        return $(this).text() === "SELL";
    }).parent().addClass("failed");
    $("td").filter(function() {
        return $(this).text() === "BUY";
    }).parent().addClass("success-custom");
});

    $(document).ready(function() {

			// var hCols = [3, 4];

			// $('#example').DataTable({
            //     "pageLength" : 50,
			// 	"dom": "<'row'<'col-sm-4'B><'col-sm-2'l><'col-sm-6'p<br/>i>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12'p<br/>i>>",
			// 	"paging": true,
			// 	"buttons": [{
			// 		extend: 'colvis',
			// 		collectionLayout: 'three-column',
			// 		text: function() {
			// 			var totCols = $('#example thead th').length;
			// 			var hiddenCols = hCols.length;
			// 			var shownCols = totCols - hiddenCols;
			// 			return 'Columns (' + shownCols + ' of ' + totCols + ')';
			// 		},
			// 		prefixButtons: [{
			// 			extend: 'colvisGroup',
			// 			text: 'Show all',
			// 			show: ':hidden'
			// 		}, {
			// 			extend: 'colvisRestore',
			// 			text: 'Restore'
			// 		}]
				// }, {
				// 	extend: 'collection',
				// 	text: 'Export',
				// 	buttons: [{
				// 			text: 'Excel',
				// 			extend: 'excelHtml5',
				// 			footer: false,
				// 			exportOptions: {
				// 				columns: ':visible'
				// 			}
				// 		}, {
				// 			text: 'CSV',
				// 			extend: 'csvHtml5',
				// 			fieldSeparator: ';',
				// 			exportOptions: {
				// 				columns: ':visible'
				// 			}
				// 		}, {
				// 			text: 'PDF Portrait',
				// 			extend: 'pdfHtml5',
				// 			message: '',
				// 			exportOptions: {
				// 				columns: ':visible'
				// 			}
				// 		}, {
				// 			text: 'PDF Landscape',
				// 			extend: 'pdfHtml5',
				// 			message: '',
				// 			orientation: 'landscape',
				// 			exportOptions: {
				// 				columns: ':visible'
				// 			}
				// 		}]
					// }]
		// 		,oLanguage: {
        //     oPaginate: {
        //         sNext: '<span class="pagination-default">&#x276f;</span>',
        //         sPrevious: '<span class="pagination-default">&#x276e;</span>'
        //     }
        // }
					// ,"initComplete": function(settings, json) {
					// 	// Adjust hidden columns counter text in button -->
					// 	$('#example').on('column-visibility.dt', function(e, settings, column, state) {
					// 		var visCols = $('#example thead tr:first th').length;
					// 		//Below: The minus 2 because of the 2 extra buttons Show all and Restore
					// 		var tblCols = $('.dt-button-collection li[aria-controls=example] a').length - 2;
					// 		$('.buttons-colvis[aria-controls=example] span').html('Columns (' + visCols + ' of ' + tblCols + ')');
					// 		e.stopPropagation();
					// 	});
					// }
				// });
			});
    });
</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
    availableTags = [];
    $.ajax({
       'url': '<?php echo SURL ?>admin/TradeHistory/get_all_usernames_ajax',
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