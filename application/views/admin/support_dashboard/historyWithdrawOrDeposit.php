<!-- <link rel="stylesheet" type="text/css" href = "https://cdn.datatables.net/2.10.20/css/jquery.dataTables.min.css"> 
<link rel="stylesheet" type="text/css" href = "https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css"> 
<link rel="stylesheet" type="text/css" href = "https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">


<scrpt src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script> -->

<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.2.2/css/buttons.bootstrap.min.css'>
<script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-de7e2ef6bfefd24b79a3f68b414b87b8db5b08439cac3f1012092b2290c719cd.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/5.1.0/jquery.min.js'></script>
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
  <h1 class="content-heading bg-white border-bottom">Withdraw or Deposit Binance History</h1>
  <div class="innerAll bg-white border-bottom">
  <ul class="menubar">
  <li class="active"><a href="<?php echo SURL; ?>/admin/dashboard-support/getAllDepositHistory">Binance Order History</a></li>
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
            <form method="POST" action="<?php echo SURL; ?>admin/dashboard-support/getAllDepositHistory">
              <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-3" style="padding-bottom: 6px;">
                <div class="Input_text_s">
                  <label>Filter History Type: </label>
                  <select id="HistoryType" name="HistoryType" type="text" class="form-control filter_by_name_margin_bottom_sm">
                    <option value ="withdrawList" <?php if ( $filter_user_data['HistoryType'] == "withdrawList") {?> selected <?php }?>>Withdraw History</option>
                    <option value ="depositList"  <?php if ( $filter_user_data['HistoryType'] == "depositList") {?> selected <?php }?>>Deposit History</option>    <?php if (in_array(1, $filter_user_data['filter_by_rule'])) {?> selected <?php }?>   
                  </select>  
                </div>
               </div>

               <div class="col-xs-12 col-sm-12 col-md-3" style="padding-bottom: 6px;">
                  <div class="Input_text_s">
                     <label>Filter Username: </label>
                     <input type="text" class="form-control" name="filter_username" id="username" value="<?=(!empty($filter_user_data['filter_username']) ? $filter_user_data['filter_username'] : "")?>">
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
              <th>Date</th>
              <th>Coin</th>
              <th>Amount</th>
              <th>Creator</th>
              <th>Adress</th>
              <th>Adress Tag</th>
              <th>Trasection Id</th>
              <?php if($filter_user_data['HistoryType'] == "withdrawList"){?>
                <th>Trasection Fee</th>
                <th>Withdraw Order Id</th>
                <th>Id</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
           <?php
              if (count($history[$filter_user_data['HistoryType']]) > 0) {
                for ($i = 0; $i < count($history[$filter_user_data['HistoryType']]); $i++) {
                  ?>
                  <tr class="gradeX">
                
                    <td><?php echo $i + 1; ?></td>
                    <?php if($filter_user_data['HistoryType'] == "withdrawList"){?>
                      <td><?= date("d-m-Y H:i:s", ((int)($history[$filter_user_data['HistoryType']][$i]['applyTime']/1000)))?></td>  
                    <?php }else{?>
                      <td><?= date("d-m-Y H:i:s", ((int)($history[$filter_user_data['HistoryType']][$i]['insertTime']/1000)))?></td>  
                    <?php } ?>
                    <td><?=$history[$filter_user_data['HistoryType']][$i]['asset']; ?></td>
                    <td><?=$history[$filter_user_data['HistoryType']][$i]['amount']?></td>
                    <td><?=$history[$filter_user_data['HistoryType']][$i]['creator']?></td>
                    <td><?=$history[$filter_user_data['HistoryType']][$i]['address']?></td>
                    <td><?=$history[$filter_user_data['HistoryType']][$i]['addressTag']?></td>
                    <td><?=$history[$filter_user_data['HistoryType']][$i]['txId']?></td>

                    <?php if($filter_user_data['HistoryType'] == "withdrawList"){?>
                      <td><?=$history[$filter_user_data['HistoryType']][$i]['transactionFee']?></td>
                      <td><?=$history[$filter_user_data['HistoryType']][$i]['withdrawOrderId']?></td>
                      <td><?=$history[$filter_user_data['HistoryType']][$i]['id']?></td>
                    <?php } ?>

                </tr>
                <?php }
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