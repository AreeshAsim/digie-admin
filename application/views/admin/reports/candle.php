<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

<div id="content">
  <h1 class="content-heading bg-white border-bottom">Reports</h1>
  <div class="innerAll bg-white border-bottom">
  <ul class="menubar">
    <li class=""><a href="<?php echo SURL; ?>admin/reports">Reports</a></li>
    <li class="active"><a href="#">Custom Report</a></li>
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
      <?php //$filter_user_data = $this->session->userdata('filter_order_data'); ?>

    <!-- Widget -->
    <div class="widget widget-inverse">
    	<div class="widget-head">
            <div class="row">
                <div class="col-xs-12">
                    Settings
                    <span style="float:right;">
                        <!-- <button class="btn btn-info" onclick="exportTableToCSV('report.csv')">Export To CSV File</button> -->
                    </span>
                </div>
            </div>
      	</div>
        <div class="widget-body">
            <form method="post" action="<?php echo SURL; ?>admin/tester_report/run_cron">
              <div class="row" style="padding-bottom: 8px;margin-bottom: 10px;">
               <div class="col-md-12">
                 <label>Coin</label>
                 <input type="text" name="coin" class="form-control" value = "TRXBTC">
               </div>
               <div class="col-md-12">
                 <label>Candle Date</label>
                 <input type="text" name="candle_date" class="form-control" value = "2019-05-19">
               </div>
               <div class="col-md-12">
                  <input type="submit" name="submit" class="btn btn-md btn-success" value = "Submit">
               </div>
            </div>
            </form>
        </div>
    </div>
    <!-- // Widget END -->

  </div>
</div>