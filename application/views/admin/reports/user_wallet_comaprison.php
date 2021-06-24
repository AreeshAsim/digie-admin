<link href="https://raw.githubusercontent.com/daneden/animate.css/master/animate.css">
<link href="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.css" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?php echo ASSETS ?>buyer_order/moment-with-locales.js"></script>
<script src="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
    .blink_me {animation: blinker 1s cubic-bezier(0.4, 0, 1, 1) infinite;}
    @keyframes blinker { 
    50% { opacity: 0.5; }
    }
    .panel-danger {
        border-color: #c31e1e;
    }
    .danger{
        background: #c31e1e !important;
    }
    .wrapper {
        width: 70%;
    }
    
    @media(max-width:992px) {
        .wrapper {
            width: 100%;
        }
    }
    
    .panel-heading {
        padding: 0;
        border: 0;
    }
    
    .panel-title>a,
    .panel-title>a:active {
        display: block;
        padding: 15px;
        color: #555;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        word-spacing: 3px;
        text-decoration: none;
    }
    
    .panel-heading a:before {
        font-family: 'Glyphicons Halflings';
        content: "\e114";
        float: right;
        transition: all 0.5s;
    }
    
    .panel-heading.active a:before {
        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        transform: rotate(180deg);
    }
</style>

<div id="content">
    <h1 class="content-heading bg-white border-bottom">Reports</h1>
    <div class="innerAll bg-white border-bottom">
        <ul class="menubar">
            <li class=""><a href="<?php echo SURL; ?>admin/reports">Reports</a></li>
            <li class="active"><a href="#">Custom Report</a></li>
        </ul>
    </div>

    <div class="widget widget-inverse">
        <div class="widget-head">
            <span> User Wallet Report </span>
            <span style="float:right;"><button class="btn btn-info" onclick="exportTableToCSV('report.csv')">Export To CSV File</button></span>
        </div>
        <div class="widget-body">

            <div class="wrapper center-block">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <?php 
                        $useri = 1;
                        foreach($users as $user){
                        $useri++;
                        $user_id = (string)$user['_id'];
                    ?>
                    <div class="panel panel-<?php echo $user['class'] ?>" id="panelId<?php echo $user_id ?>">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" class="icon-btn" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $useri ?>" aria-expanded="true" aria-controls="collapseOne">
                                <?php echo $user['first_name']. "". $user['last_name']. "(".$user['username'].")" ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse<?php echo $useri ?>" data-id="<?php echo $user_id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body" id="innerHTML<?php echo $user_id ?>">
                                <?php echo $user['html'] ?>
                            </div>
                        </div>
                    </div>
                    <?php 
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- // Widget END -->

</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $('.panel-collapse').on('show.bs.collapse', function() {

        // var user_id = $(this).attr('data-id');
        // $.ajax({
        //     url: "<?php echo SURL; ?>admin/reports/user_wallet_report_ajax", 
        //     data : {id: user_id},
        //     type: "POST",
        //     success: function(resp){
        //         resp = JSON.parse(resp);
        //         var res = resp.html;
        //         var class1 = resp.class;
        //         $("#innerHTML"+user_id).html(res);
        //         $(this).siblings('.panel-heading').addClass('active');
        //         $("#panelId"+user_id).removeClass("panel-defualt").addClass("panel-"+class1);
        //     },
        //     error: function(e){

        //     }
        // });
        // //ajax

        $(this).siblings('.panel-heading').addClass('active');
    });

    $('.panel-collapse').on('hide.bs.collapse', function() {
        $(this).siblings('.panel-heading').removeClass('active');
    });
</script>
<script type="text/javascript">
    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV file
        csvFile = new Blob([csv], {
            type: "text/csv"
        });

        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename;

        // Create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Hide download link
        downloadLink.style.display = "none";

        // Add the link to DOM
        document.body.appendChild(downloadLink);

        // Click download link
        downloadLink.click();
    }

    function exportTableToCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("table tr");

        for (var i = 0; i < rows.length; i++) {
            var row = [],
                cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++)
                row.push(cols[j].innerText);

            csv.push(row.join(","));
        }

        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
    }
</script>