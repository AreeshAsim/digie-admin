
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
  <h1 class="content-heading bg-white border-bottom">Kraken Order History</h1>
  <div class="innerAll bg-white border-bottom">
  <ul class="menubar">
  <li class="active"><a href="<?php echo SURL; ?>/admin/dashboard-support/get_kraken_user_Local_order_history">Kraken Order History</a></li>
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
    <?php $filter_user_data = $this->session->userdata('userdata'); ?>
    <!-- Widget -->
    <div class="widget widget-inverse">
      <div class="widget-body padding-bottom-none">
        <!-- Form -->
        <div class="widget widget-inverse">
         <div class="widget-body">
            <form method="POST" action="<?php echo SURL; ?>admin/dashboard-support/get_kraken_user_Local_order_history">
              <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-3" style="padding-bottom: 6px;">
                  <div class="Input_text_s">
                     <label>Filter Coin: </label>
                     <select id="filter_by_coin" name="filter_by_coin" type="text" class="form-control filter_by_name_margin_bottom_sm">
                        <option value ="" <?=(($filter_user_data['filter_by_coin'] == "") ? "selected" : "")?>>Search By Coin Symbol</option>
                        <?php
                            for ($i = 0; $i < count($coins); $i++) {
                                $selected = ($coins[$i]['kraken_symbol2'] == $filter_user_data['filter_by_coin']) ? "selected" : "";
                                echo "<option value='" . $coins[$i]['kraken_symbol2'] . "' $selected>" . $coins[$i]['kraken_symbol2'] . "</option>";
                            }
                        ?>
                     </select>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-12 col-md-3" style="padding-bottom: 6px;">
                  <div class="Input_text_s">
                     <label>Filter Username: </label>
                     <input type="text" class="form-control" name="filter_username" id="username" value="<?=(!empty($filter_user_data['filter_username']) ? $filter_user_data['filter_username'] : "")?>" required>
                  </div>
               </div>

               <div class="col-xs-12 col-sm-12 col-md-12" style="padding-bottom: 6px;">
                  <div class="Input_text_btn">
                     <label></label>
                     <button id="submit-form" class="btn btn-success"><i class="glyphicon glyphicon-filter"></i>Search</button>
                     <a href="<?php echo SURL; ?>admin/reports/reset_filters_report/all" class="btn btn-danger"><i class="fa fa-times-circle"></i>Reset</a>
                  </div>
               </div>
            </div>
            </form>
          </div>
      </div>
        <!-- End Form -->
        <!-- Table -->
        <table id="example" class="table table-bordered" cellspacing="0" width="100%">
          <!-- Table heading -->
          <thead>
            <tr>
              <th>Sr</th>
              <th>Ordertxid</th>
              <th>Symbol</th>
              <th>Date</th>
              <th>type</th>
              <th>Order type</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Cost</th>
              <th>Fee</th>
              <th>Exists</th>
            </tr>
          </thead>
          <tbody>
          <?php
          // echo "<pre>";
          // print_r($finalHistory);
          $count = 0;
              if (count($finalHistory) > 0) {
                foreach($finalHistory as $value){
                 ?>
                    <tr class="gradeX">
                      <td><?php  echo $count+1; ?></td>
                      <td> <?php echo $value['value']['ordertxid']; ?> </td>
                      <td> <?php echo $value['value']['pair']; ?> </td>
                      <td>---
                        <?php
                          // echo strtotime ($value['value']['time']->toDateTime()->format('Y-m-d H:i:s'));                        
                        ?>
                      </td>
                      <td><?= ($value['value']['type'] == 'sell') ? "<span class='text-danger-custom'>SELL</span>" : "<span class='text-success-custom'>BUY</span>";?></td>
                      <td> <?php echo $value['value']['ordertype']; ?> </td> 
                      <td> <?php echo $value['value']['price']; ?> </td> 
                      <td><?php  echo $value['value']['vol']; ?></td>
                      <td> <?php echo $value['value']['cost']; ?> </td> 
                      <td> <?php echo number_format($value['value']['fee'], 8); ?> </td> 
                      <?php
                      if($value['value']['pair'] == 'QTUMXBT'){
                        $coin = 'QTUMBTC';
                      }elseif($value['value']['pair'] == 'LINKXBT'){
                        $coin = 'LINKBTC';
                      }elseif($value['value']['pair'] == 'XRPXBT'){
                        $coin = 'XRPBTC';
                      }elseif($value['value']['pair'] == 'XBTUSDT'){
                        $coin = 'BTCUSDT';
                      }elseif($value['value']['pair'] == 'XXLMXXBT'){
                        $coin = 'XLMBTC';
                      }elseif($value['value']['pair'] == 'XETHXXBT'){
                        $coin = 'ETHBTC';
                      }elseif($value['value']['pair'] == 'XXMRXXBT'){
                        $coin = 'XMRBTC';
                      }elseif($value['value']['pair'] == 'ADAXBT'){  
                        $coin = 'ADABTC';
                      }elseif($value['value']['pair'] == 'TRXXBT'){
                        $coin = 'TRXBTC';
                      }elseif($value['value']['pair'] == 'EOSXBT'){
                        $coin = 'EOSBTC';
                      }elseif($value['value']['pair'] == 'XETCXXBT'){
                        $coin = 'ETCBTC';
                      }elseif($value['value']['pair'] ==  'DASHXBT'){
                        $coin = 'DASHBTC';
                      }elseif($value['value']['pair'] ==  'XLTCXXBT'){
                        $coin = 'LTCUSDT';
                      }else{
                        $coin = $value['value']['pair'];
                      }
                        $collection1 = 'buy_orders_kraken'; 
                        $collection2 = 'sold_buy_orders_kraken';
                        $find_order['admin_id'] = (string)$admin_id;
                        $find_order['kraken_order_id'] =  $value['value']['ordertxid'];     //[kraken_order_id] => OYK7LZ-AB6U7-UQO4OZ

                        $this->mongo_db->where($find_order);
                        $record     = $this->mongo_db->get($collection1);
                        $dataReturn = iterator_to_array($record);

                        $findOrderSold['admin_id'] = (string)$admin_id;
                        $findOrderSold['sell_kraken_order_id'] = $value['value']['ordertxid'];  

                        $this->mongo_db->where($findOrderSold);
                        $record1      = $this->mongo_db->get($collection2);
                        $dataReturn2  = iterator_to_array($record1);

                        $this->mongo_db->where($find_order);
                        $record3      = $this->mongo_db->get($collection2);
                        $dataReturn3  = iterator_to_array($record3);

                        ?>
                        <td> 
                          <?php if(count($dataReturn2) > 0 || count($dataReturn) > 0 || count($dataReturn3) > 0){ ?>
                            <span class="fa fa-check" style="color:green; float:right"></span> 
                          <?php } else { ?>
                            <span class="fa fa-close" style="color:red; float:right"></span>
                            <br>
                            <?php if($value['value']['type'] != 'sell'){?>
                              <form action="<?php echo SURL; ?>admin/dashboard-support/create_child_process" method="POST">
                                <input type="hidden" name="admin_id" value="<?=$admin_id;?>" />
                                <input type="hidden" name="quantity" value="<?=$value['value']['vol'];?>" />
                                <input type="hidden" name="purchased_price" value="<?=$value['value']['price'];?>" />
                                <input type="hidden" name="symbol" value="<?=$coin;?>" />
                                <input type="hidden" name="kraken_id" value="<?=$value['value']['ordertxid'];?>" />
                                <input type="hidden" name="exchange" value="exchange" />
                                <button type="submit" class="btn btn-success"></i>Create Child</button>
                              </form>
                            <?php } 
                          }?>
                        </td>
                    </tr> 
                <?php  $count++; }
              }?>
          </tbody>
        </table>
        <!-- // Table END -->
      </div>
    </div>
    <!-- // Widget END -->
  </div>
</div>
<script>
$(function() {
$("#example").find("tr").each(function () {
    $("td").filter(function() {
        return $(this).text() === "SELL";
    }).parent().addClass("failed");
    $("td").filter(function() {
        return $(this).text() === "BUY";
    }).parent().addClass("success-custom");
});

// $('.newdynamicTable').dataTable( {
//     "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
//     dom: 'Bfrtip',
//         buttons: [
//             'copy', 'csv', 'excel', 'pdf', 'print'
//         ],
//     "pagingType": "full_numbers",
//     "pageLength": 50,
// });

    $(document).ready(function() {
			//Only needed for the filename of export files.
			//Normally set in the title tag of your page.document.title = 'Simple DataTable';
			//Define hidden columns
			var hCols = [3, 4];
			// DataTable initialisation
			$('#example').DataTable({
          "pageLength" : 50,
				"dom": "<'row'<'col-sm-4'B><'col-sm-2'l><'col-sm-6'p<br/>i>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12'p<br/>i>>",
				"paging": true,
				"buttons": [{
					extend: 'colvis',
					collectionLayout: 'three-column',
					text: function() {
						var totCols = $('#example thead th').length;
						var hiddenCols = hCols.length;
						var shownCols = totCols - hiddenCols;
						return 'Columns (' + shownCols + ' of ' + totCols + ')';
					},
					prefixButtons: [{
						extend: 'colvisGroup',
						text: 'Show all',
						show: ':hidden'
					}, {
						extend: 'colvisRestore',
						text: 'Restore'
					}]
				}, {
					extend: 'collection',
					text: 'Export',
					buttons: [{
							text: 'Excel',
							extend: 'excelHtml5',
							footer: false,
							exportOptions: {
								columns: ':visible'
							}
						}, {
							text: 'CSV',
							extend: 'csvHtml5',
							fieldSeparator: ';',
							exportOptions: {
								columns: ':visible'
							}
						}, {
							text: 'PDF Portrait',
							extend: 'pdfHtml5',
							message: '',
							exportOptions: {
								columns: ':visible'
							}
						}, {
							text: 'PDF Landscape',
							extend: 'pdfHtml5',
							message: '',
							orientation: 'landscape',
							exportOptions: {
								columns: ':visible'
							}
						}]
					}]
				,oLanguage: {
            oPaginate: {
                sNext: '<span class="pagination-default">&#x276f;</span>',
                sPrevious: '<span class="pagination-default">&#x276e;</span>'
            }
        }
					,"initComplete": function(settings, json) {
						// Adjust hidden columns counter text in button -->
						$('#example').on('column-visibility.dt', function(e, settings, column, state) {
							var visCols = $('#example thead tr:first th').length;
							//Below: The minus 2 because of the 2 extra buttons Show all and Restore
							var tblCols = $('.dt-button-collection li[aria-controls=example] a').length - 2;
							$('.buttons-colvis[aria-controls=example] span').html('Columns (' + visCols + ' of ' + tblCols + ')');
							e.stopPropagation();
						});
					}
				});
			});
    });
</script>

<script>
  $( function() {
    availableTags = [];
    $.ajax({
       'url': '<?php echo SURL ?>admin/reports/get_all_usernames_ajax',
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