<script type="text/javascript" src="<?php echo ASSETS ?>report/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo ASSETS ?>report/moment.min.js"></script>
<script type="text/javascript" src="<?php echo ASSETS ?>report/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo ASSETS ?>report/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="http://users.digiebot.com/assets/admin/stylesheets/animate.css">
<div id="content">
    <style>
        @import "bourbon";

        body {
            font-family: 'Open Sans', "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5em;
            font-weight: 400;
        }

        p,
        span,
        a,
        ul,
        li,
        button {
            font-family: inherit;
            font-size: inherit;
            font-weight: inherit;
            line-height: inherit;
        }

        strong {
            font-weight: 600;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Open Sans', "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
            line-height: 1.5em;
            font-weight: 300;
        }

        strong {
            font-weight: 400;
        }

        .tile {
            width: 100%;
            display: inline-block;
            box-sizing: border-box;
            background: #fff;
            padding: 20px;
            margin-bottom: 10px;
        }

        .tile .title {
            margin-top: 0px;
        }

        .tile.purple,
        .tile.blue,
        .tile.red,
        .tile.orange,
        .tile.green {
            color: #fff;
        }

        .tile.purple {
            background: #5133ab;
        }

        .tile.purple:hover {
            background: #3e2784;
        }

        .tile.red {
            background: #ac193d;
        }

        .tile.red:hover {
            background: #7f132d;
        }

        .tile.green {
            background: #00a600;
            background: linear-gradient(45deg, #00a600, transparent);
            margin: 15px;
            border: 1px solid #eee;
            box-shadow: 0 1px 23px -20px #e8e8e8;
            border-radius: 25px;
            color: black;
        }

        .tile.green:hover {
            background: #007300;
        }

        .tile.blue {
            background: #2672ec;
            background: linear-gradient(45deg, #2672ec, transparent);
            margin: 15px;
            border: 1px solid #eee;
            box-shadow: 0 1px 23px -20px #e8e8e8;
            border-radius: 25px;
            color: black;
        }

        .tile.blue:hover {
            background: #125acd;
        }

        .tile.orange {
            background: #dc572e;
            background: linear-gradient(45deg, #c31e1e, transparent);
            margin: 15px;
            border: 1px solid #eee;
            box-shadow: 0 1px 23px -20px #e8e8e8;
            border-radius: 25px;
            color: black;
        }

        .tile.orange:hover {
            background: linear-gradient(45deg, #c31e1e, transparent);
            margin: 15px;
            border: 1px solid #eee;
            box-shadow: 0 1px 23px -20px #e8e8e8;
            border-radius: 25px;
            color: black;
        }
        a.tile{
            text-decoration : none;
        }
        .tile.grey {
            background: linear-gradient(45deg, whitesmoke, white);
            margin: 15px;
            border: 1px solid #eee;
            box-shadow: 0 1px 23px -20px #e8e8e8;
            border-radius: 25px;
            color: black;

        }

        .notification_popup {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.7);
            z-index: 99999;
            display: none;
        }

        .notification_popup_iner {
            padding: 25px;
            background: #fff;
            margin: auto;
            height: 250px;
            width: 100%;
            max-width: 500px;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            position: absolute;
            box-shadow: 0 0 59px 24px rgba(0, 0, 43, 0.2);
            border-radius: 15px;
        }

        .conternta-pop h2 {
            font-size: 19px;
            text-align: center;
            font-weight: bold;
            color: #000;
            margin-top: 33px !important;
            float: left;
            width: 100%;
        }

        .conternta-pop h2 codet {
            color: #c3a221;
        }

        .npclss {
            position: absolute;
            right: 15px;
            top: 15px;
            height: 30px;
            width: 30px;
            text-align: center;
            border: 1px solid #ccc;
            background: #fff;
            border-radius: 22px;
            padding-top: 5px;
            cursor: pointer;
        }

        a.btn.btn-default.custom-btn {
            height: 120px;
            width: 75%;
            font-size: 20px;
            background: #fff;
            text-align: center;
            padding: 5px;
            padding-top: 20px;
            border-radius: 10px;
        }

        .slideInRight {
            -webkit-animation-name: slideInRight;
            animation-name: slideInRight;
        }

        .animated {
            -webkit-animation-duration: 1s;
            animation-duration: 1s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
        }

        .dash-main {
            background: #fff none repeat scroll 0 0;
            border: 1px solid #eee;
            box-shadow: 0 1px 23px -20px #e8e8e8;
            float: left;
            padding: 15px;
            width: 100%;
        }

        .menu-item.animated {
            height: 175px;
            padding: 15px;
            color: black;
            
        }

        a.btn.btn-default.custom-btn:hover {
            background: #0f1c42;
            color: white !important;
        }

        .custom-btn i {
            padding-bottom: 14px;
        }

        @keyframes bounce {

            0%,
            20%,
            60%,
            100% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
            }

            40% {
                -webkit-transform: translateY(-20px);
                transform: translateY(-20px);
            }

            80% {
                -webkit-transform: translateY(-10px);
                transform: translateY(-10px);
            }
        }

        .menu-item:hover a {
            animation: bounce 1s;
        }
    </style>
    <!-- <div class="notification_popup">
        <div class="notification_popup_iner">
        	<div class="npclss">X</div>
            <div id="popup_text" class="conternta-pop">
              <h2>
              WARNING: You have less than <codet>$10 USD in BNB </codet> balance. To reduce your Binance trading fees, please Maintain a Minimum of <codet>$10 USD in BNB </codet> coin balance in your Binance account.Your digiebot trading account will still trade if you do not have any BNB, but your Binance trading fees will be slightly higher. Binance Fee Schedule https://www.binance.com/en/fee/schedule
              </h2>
            </div>
        </div>
    </div> -->

    <div class="innerAll spacing-x2">
        <div class="row">
            <div class="col-md-12">
                <div class="widget">
                    <div class="widget-body padding-none">
                        <div class = "row">
                        <div class="widget widget-inverse">
                            <div class="widget-body padding-bottom-none">
                                <!-- Form -->
                                <div class="widget widget-inverse">
                                <div class="widget-body">
                                    <form method="POST" action="<?php echo SURL; ?>admin/dashboard-support/check_true_rules">
                                    <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-3" style="padding-bottom: 6px;">
                                        <div class="Input_text_s">
                                            <label>Filter Coin: </label>
                                            <select id="filter_by_coin" name="filter_by_coin" type="text" class="form-control filter_by_name_margin_bottom_sm">
                                                <option value ="" <?=(($filter_user_data['filter_by_coin'] == "") ? "selected" : "")?>>Search By Coin Symbol</option>
                                                <?php
                                                    for ($i = 0; $i < count($coins); $i++) {
                                                        $selected = ($coins[$i]['symbol'] == $filter_user_data['filter_by_coin']) ? "selected" : "";
                                                        echo "<option value='" . $coins[$i]['symbol'] . "' $selected>" . $coins[$i]['symbol'] . "</option>";
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3" style="padding-bottom: 6px;">
                                        <div class="Input_text_s">
                                            <label>Filter Date: </label>
                                            <input type="text" id="reportrange" name="date_filter" class="form-control">
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
                        </div>
                        <div class="row"><?php echo $html; ?></div>
                    </div>
                    
                </div>

            </div>

        </div>
    </div>
</div>
<!-- // Content END -->
<script type="text/javascript">

    $(function() {



        var start = moment().subtract(29, 'days');

        var end = moment();



        function cb(start, end) {

            $('#reportrange').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        }



        $('#reportrange').daterangepicker({

            startDate: start,

            endDate: end,

            ranges: {

                'Today': [moment(), moment()],

                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],

                'Last 7 Days': [moment().subtract(6, 'days'), moment()],

                'Last 30 Days': [moment().subtract(29, 'days'), moment()],

                'This Month': [moment().startOf('month'), moment().endOf('month')],

                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]

            }

        }, cb);



        cb(start, end);



    });

</script>