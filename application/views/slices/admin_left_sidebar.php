<?php //echo $this->session->userdata('admin_id'); exit; ?>


<link rel="stylesheet" href="<?php echo ASSETS; ?>css/admin/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div id="menu" class="hidden-print hidden-xs">
  <div class="sidebar sidebar-inverse">
    <div class="user-profile media innerAll">
    <a href="" class="pull-left">
    <?php if ($this->session->userdata('profile_image') != "") {?>
        <img src="https://app.digiebot.com/assets/profile_images/<?php echo $this->session->userdata('profile_image'); ?>" alt="" class="img-circle" width="52" height="52">
    <?php } else {?>
        <img src="<?php echo ASSETS; ?>images/empty_user.png" alt="" class="img-circle" width="52" height="52">
    <?php }?>
    </a>
    <div class="media-body"> <a href="" class="strong"><?php echo ucfirst($this->session->userdata('first_name') . " " . $this->session->userdata('last_name')); ?></a>
    <p class="text-success"><i class="fa fa-fw fa-circle"></i> Online</p>
    </div>

    </div>
    <div class="sidebarMenuWrapper">
      <ul class="list-unstyled">

        <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/dashboard') {?> class="active" <?php }?>>
        <a href="<?php echo SURL ?>admin/dashboard"><i class=" icon-projector-screen-line"></i>
        <span>Dashboard</span></a>
        </li>


        <!--li <?php //if($_SERVER['REQUEST_URI']=='/admin/dashboard/chart'){?> class="active" <?php //} ?>>
        <a href="<?php// echo SURL?>admin/dashboard/chart"><i class=" icon-projector-screen-line"></i>
        <span>Chart</span></a>
        </li>

        <li <?php //if($_SERVER['REQUEST_URI']=='/admin/dashboard/chart2'){?> class="active" <?php //} ?>>
        <a href="<?php //echo SURL?>admin/dashboard/chart2"><i class=" icon-projector-screen-line"></i>
        <span>Chart2</span></a>
        </li-->

       <!--  <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/chart3/view_chart3') {?> class="active" <?php }?>>
        <a href="<?php echo SURL ?>admin/chart3/view_chart3"><i class=" icon-projector-screen-line"></i>
        <span>Chart</span></a>
        </li> -->

        <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/chart3_group') {?> class="active" <?php }?>>
        <a href="<?php echo SURL ?>admin/indicator"><i class=" icon-projector-screen-line"></i>
        <span>Chart</span></a>
        </li>

    <?php if ($this->session->userdata('user_role') == 1) {?>
        <!-- <li class="hasSubmenu <?php if ($_SERVER['REQUEST_URI'] == '/admin/dashboard/add-zone' || $_SERVER['REQUEST_URI'] == '/admin/dashboard/zone-listing') {?>active<?php }?>">
        <a href="#" data-target="#menu-style" data-toggle="collapse"><i class="icon-compose"></i>
        <span>Chart Target Zones</span></a>
          <ul class="collapse <?php if ($_SERVER['REQUEST_URI'] == '/admin/dashboard/add-zone' || $_SERVER['REQUEST_URI'] == '/admin/dashboard/zone-listing') {?>in<?php }?>" id="menu-style">
            <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/dashboard/zone-listing') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/dashboard/zone-listing">Target Zones Listing</a></li>
            <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/dashboard/add-zone') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/dashboard/add-zone">Add Target Zones</a></li>
          </ul>
        </li> -->
    <?php }?>



        <!-- <li class="hasSubmenu <?php if ($_SERVER['REQUEST_URI'] == '/admin/buy_orders/add-buy-order' || $_SERVER['REQUEST_URI'] == '/admin/buy_orders/' || $_SERVER['REQUEST_URI'] == '/admin/buy_orders/add_buy_order_triggers/') {?>active<?php }?>">
        <a href="#" data-target="#menu-style3" data-toggle="collapse"><i class="icon-compose"></i>
        <span>Buy Orders</span></a>
          <ul class="collapse <?php if ($_SERVER['REQUEST_URI'] == '/admin/buy_orders/add-buy-order' || $_SERVER['REQUEST_URI'] == '/admin/buy_orders/') {?>in<?php }?>" id="menu-style3">
            <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/buy_orders/') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/buy_orders/">Orders Listing</a></li>
            <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/buy_orders/add-buy-order') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/buy_orders/add-buy-order">Add Digie Manual Order</a></li>
             <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/buy_orders/add_buy_order_triggers') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/buy_orders/add_buy_order_triggers">Add Digie Auto Order</a></li>


             <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/buy_orders/add_buy_order_triggers') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/buy_orders/lth_order_listing">Long Term Hold</a></li>
          </ul>
        </li> -->



        <!-- <li class="hasSubmenu <?php if ($_SERVER['REQUEST_URI'] == '/admin/sell_orders/add-order' || $_SERVER['REQUEST_URI'] == '/admin/sell_orders/') {?>active<?php }?>">
        <a href="#" data-target="#menu-style2" data-toggle="collapse"><i class="icon-compose"></i>
        <span>Sell Orders</span></a>
          <ul class="collapse <?php if ($_SERVER['REQUEST_URI'] == '/admin/sell_orders/add-order' || $_SERVER['REQUEST_URI'] == '/admin/sell_orders/') {?>in<?php }?>" id="menu-style2">
            <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/sell_orders/') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/sell_orders/">Orders Listing</a></li>
            <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/sell_orders/add-order') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/dashboard/add-order">Add Order</a></li>
          </ul>
        </li> -->





        <?php if ($this->session->userdata('user_role') == 1) {
    ?>
        <!-- <li class="hasSubmenu <?php if ($_SERVER['REQUEST_URI'] == '/admin/coins' || $_SERVER['REQUEST_URI'] == '/admin/coins/add-coin') {?>active<?php }?>">
        <a href="#" data-target="#menu-style4" data-toggle="collapse"><i class="icon-compose"></i>
        <span>Coins</span></a>
          <ul class="collapse <?php if ($_SERVER['REQUEST_URI'] == '/admin/coins' || $_SERVER['REQUEST_URI'] == '/admin/coins/add-coin') {?>in<?php }?>" id="menu-style4">
            <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/coins') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/coins">Manage Coins</a></li>
            <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/coins/add-coin') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/coins/add-coin">Add Coin</a></li>
          </ul>
        </li> -->
        <?php }?>
        <?php if ($this->session->userdata('user_role') == 1) {
    ?>
        <li class="hasSubmenu <?php if ($_SERVER['REQUEST_URI'] == '/admin/user_coins' || $_SERVER['REQUEST_URI'] == '/admin/user_coins/add-coin') {?>active<?php }?>">
        <a href="#" data-target="#menu-style4" data-toggle="collapse"><i class="icon-compose"></i> 
        <span>Coins</span></a>
          <ul class="collapse <?php if ($_SERVER['REQUEST_URI'] == '/admin/user_coins' || $_SERVER['REQUEST_URI'] == '/admin/user_coins/add-coin') {?>in<?php }?>" id="menu-style4">
            <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/coin_market') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/coin_market">Manage Coins</a></li>
            <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/user_coins/add-coin') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/user_coins/add-coin">Add Coin</a></li>
            <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/rule_calls/update_rule_status') {?>active<?php }?>"><a href="<?php echo SURL ?>/admin/rule_calls/update_rule_status">Bot on/off</a></li>   
            <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/coins/coin_moves') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/coins/coin_moves">Coin Moves</a></li>          
          </ul>
        </li>
        <?php }?>

        <li class="hasSubmenu <?php if($_SERVER['REQUEST_URI'] == '/admin/buy_orders/create_child_view' || $_SERVER['REQUEST_URI'] == '/admin/Api_notifications/trade_history_report' || $_SERVER['REQUEST_URI'] == '/admin/rule_calls/rules_display' || $_SERVER['REQUEST_URI'] == '/admin/trigger_rule_reports/oppertunity_reports' || $_SERVER['REQUEST_URI'] == '/admin/users_list/investment_report') {?>active<?php }?>">
          <a href="#" data-target="#menu-style5" data-toggle="collapse"><i class="icon-compose"></i> 
          <span>Reports</span></a>
            <ul class="collapse <?php if($_SERVER['REQUEST_URI'] == '/admin/Crons/cornsHistoryDisplay' || $_SERVER['REQUEST_URI'] == '/admin/Api_notifications/trade_history_report' || $_SERVER['REQUEST_URI'] == '/admin/rule_calls/rules_display' || $_SERVER['REQUEST_URI'] == '/admin/trigger_rule_reports/oppertunity_reports' || $_SERVER['REQUEST_URI'] == '/admin/users_list/investment_report') {?>in<?php }?>" id="menu-style5">
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/trigger_rule_reports/oppertunity_reports') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/trigger_rule_reports/oppertunity_reports">Opportunity Report</a></li>
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/users_list/investment_report') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/users_list/investment_report">Investment Detail</a></li>
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/rule_calls/rules_display') {?>active<?php }?>"><a href="<?php echo SURL ?>/admin/rule_calls/rules_display">Rule Setting</a></li>   
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/Api_notifications/trade_history_report') {?>active<?php }?>"><a href="<?php echo SURL ?>/admin/Api_notifications/trade_history_report">Data Report</a></li>          
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/buy_orders/create_child_view') {?>active<?php }?>"><a href="<?php echo SURL ?>/admin/buy_orders/create_child_view">Create Child</a></li>          
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/Crons/cornsHistoryDisplay') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/Crons/cornsHistoryDisplay">Cron Stop History</a></li>
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/coins/coinSlippage') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/coins/coinSlippage">Coin Slippage Report</a></li>
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/Monthly_trading_volume/fee_analysis') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/Monthly_trading_volume/fee_analysis">Monthly Trading Volume</a></li>
            </ul>  
        </li>

        <li class="hasSubmenu <?php if ($_SERVER['REQUEST_URI'] == '/admin/buy_orders/update_now_order' || $_SERVER['REQUEST_URI'] == '/admin/buy_orders/get_sold' || $_SERVER['REQUEST_URI'] == '/admin/buy_orders/get_parent_order') {?>active<?php }?>">
          <a href="#" data-target="#menu-style6" data-toggle="collapse"><i class="icon-compose"></i> 
          <span>Edit Reports</span></a>
            <ul class="collapse <?php if ($_SERVER['REQUEST_URI'] == '/admin/buy_orders/PercentageUpDown' || $_SERVER['REQUEST_URI'] == '/admin/buy_orders/update_now_order' || $_SERVER['REQUEST_URI'] == '/admin/buy_orders/get_sold' || $_SERVER['REQUEST_URI'] == '/admin/buy_orders/get_parent_order') {?>in<?php }?>" id="menu-style6">
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/buy_orders/update_now_order') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/buy_orders/update_now_order">Edit Buy Order</a></li>
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/buy_orders/get_sold') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/buy_orders/get_sold">Edit Sold Order</a></li>
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/buy_orders/get_parent_order') {?>active<?php }?>"><a href="<?php echo SURL ?>/admin/buy_orders/get_parent_order">Edit Parent</a></li>            
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/buy_orders/PercentageUpDown') {?>active<?php }?>"><a href="<?php echo SURL ?>/admin/buy_orders/PercentageUpDown">P/L change</a></li>            
            </ul>
        </li>

        <li class="hasSubmenu <?php if ($_SERVER['REQUEST_URI'] == '/admin/dashboard-support/get_kraken_user_order_history' || $_SERVER['REQUEST_URI'] == '/admin/dashboard-support/get_binance_user_order_history') {?>active<?php }?>">
          <a href="#" data-target="#menu-style7" data-toggle="collapse"><i class="icon-compose"></i> 
          <span>Trade History</span></a>
            <ul class="collapse <?php if ($_SERVER['REQUEST_URI'] == '/admin/dashboard-support/getAllDepositHistory' || $_SERVER['REQUEST_URI'] == '/admin/dashboard-support/get_kraken_user_order_history' || $_SERVER['REQUEST_URI'] == '/admin/buy_orders/get_sold' || $_SERVER['REQUEST_URI'] == '/admin/buy_orders/get_parent_order') {?>in<?php }?>" id="menu-style7">
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/dashboard-support/get_kraken_user_order_history') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/dashboard-support/get_kraken_user_order_history">Kraken Trade History</a></li>
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/dashboard-support/get_binance_user_order_history') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/dashboard-support/get_binance_user_order_history">Binance Trade History</a></li> 
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/dashboard-support/getAllDepositHistory') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/dashboard-support/getAllDepositHistory">Deposit/Withdraw Report</a></li>     
              <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/TradeHistory/showDuplicationTradeHistoryDetails') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/TradeHistory/showDuplicationTradeHistoryDetails">Duplication Founds</a></li>     

            </ul>
        </li>
              <?php if ($this->session->userdata('user_role') == 1 || $this->session->userdata('special_role') == 1 || $this->session->userdata('admin_id') == '5c3a4986fc9aad6bbd55b4f2') {?>

                   <!-- <li class="hasSubmenu <?php if ($_SERVER['REQUEST_URI'] == '/admin/users' || $_SERVER['REQUEST_URI'] == '/admin/users/add-user') {?>active<?php }?>">
                    <a href="#" data-target="#menu-style5" data-toggle="collapse"><i class="icon-compose"></i>
                    <span>Users</span></a>
                      <ul class="collapse <?php if ($_SERVER['REQUEST_URI'] == '/admin/users' || $_SERVER['REQUEST_URI'] == '/admin/users/add-user') {?>in<?php }?>" id="menu-style5">
                        
                        <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/users') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/users">Manage Users</a></li>

                        <?php if ($this->session->userdata('user_role') == 1 || $this->session->userdata('special_role') == 1) {?>
                        <li class="<?php if ($_SERVER['REQUEST_URI'] == '/admin/users/add-user') {?>active<?php }?>"><a href="<?php echo SURL ?>admin/users/add-user">Add User</a></li>
                        <?php }?>
                       
                      </ul>
                    </li> -->
                <?php if ($this->session->userdata('special_role') == 1) {?>
                  <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/candle_chart') {?> class="active" <?php }?>>
                    <a href="<?php echo SURL ?>admin/candle_chart"><i class=" icon-projector-screen-line"></i>
                    <span>15 Minute Candles</span></a>
                  </li>
                  
                  <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/chart3_group_trigger') {?> class="active" <?php }?>>
                    <a href="<?php echo SURL ?>admin/chart3_group_trigger"><i class=" icon-projector-screen-line"></i>
                    <span>Historical Chart</span></a>
                  </li>

                  <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/candel/run') {?> class="active" <?php }?>>
                    <a href="<?php echo SURL ?>admin/candle/candle-old?perc=10"><i class=" icon-projector-screen-line"></i>
                    <span>Candles</span></a>
                  </li>

                  <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/candel/run') {?> class="active" <?php }?>>
                    <a href="<?php echo SURL ?>admin/candle"><i class=" icon-projector-screen-line"></i>
                    <span>Candles Percentiles</span></a>
                  </li>


                  <?php if( $this->session->userdata('admin_id') == '5c0912b7fc9aadaac61dd072'): ?>
                    <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/candle/candle_old') {?> class="active" <?php }?>>
                      <a href="<?php echo SURL ?>admin/candle"><i class=" icon-projector-screen-line"></i>
                      <span>Candle old</span></a>
                    </li>
                  <?php endif; ?>
                    <!-- <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/candel_api/run') {?> class="active" <?php }?>>
                    <a href="<?php echo SURL ?>admin/candel_api/run"><i class=" icon-projector-screen-line"></i>
                    <span>Historical Candles</span></a>
                    </li> -->
                    <!--<li <?php if ($_SERVER['REQUEST_URI'] == '/admin/trigger/rules') {?> class="active" <?php }?>>
                    <a href="<?php echo SURL ?>admin/trigger/rules"><i class=" icon-projector-screen-line"></i>
                    <span>Trigger Rules</span></a>
                    </li>-->

                    <!--
                    <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/highchart/') {?> class="active" <?php }?>>
                    <a href="<?php echo SURL ?>/admin/highchart/candle-report/"><i class="fa fa-line-chart"></i>
                    <span>Highchart Report</span></a>
                    </li>

                    <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/highchart/coin-average/') {?> class="active" <?php }?>>
                    <a href="<?php echo SURL ?>/admin/highchart/coin-average/"><i class="fa fa-area-chart"></i>
                    <span>Coin Average Graph</span></a>
                    </li>

               
                    <?php if ($this->session->userdata('user_role') == 1) {?>
                     <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/rules_order/grid_rules') {?> class="active" <?php }?>>
                    <a href="<?php echo SURL ?>admin/rules_order/grid_rules"><i class="fa fa-th-large"></i>
                    <span>Grid Rules</span></a>
                    </li>
                    <?php }?>   


                    <?php if ($this->session->userdata('user_role') == 1) {?>
                     <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/rules-order/compare-rule') {?> class="active" <?php }?>>
                    <a href="<?php echo SURL ?>admin/rules-order/compare-rule"><i class="fa fa-tasks"></i>
                    <span>Compare Rules</span></a>
                    </li>
                    <?php }?>     -->

                <?php }}?>

                 
                  <?php if($this->session->userdata('admin_id') =='5e4d620140562366e64f0ab3'):?>
                    <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/candle/candle_old') {?> class="active" <?php }?>>
                      <a href="<?php echo SURL ?>admin/candle"><i class=" icon-projector-screen-line"></i>
                      <span>Candle old</span></a>
                    </li>
                  <?php endif; ?>

                  <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/settings') {?> class="active" <?php }?>>
                    <a href="<?php echo SURL ?>admin/settings/"><i class=" icon-projector-screen-line"></i>
                    <span>Settings</span></a>
                  </li>


                  <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/frequently-asked-questions') {?> class="active" <?php }?>>
                    <a href="<?php echo SURL ?>admin/frequently-asked-questions/"><i class="fa fa-fw icon-question"></i>
                    <span>FAQ's</span></a>
                  </li>

                  <?php if ($this->session->userdata('user_role') == 1) {?>
                    <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/sockets') {?> class="active" <?php }?>>
                      <a href="<?php echo SURL ?>admin/sockets/"><i class=" icon-projector-screen-line"></i>
                      <span>Binance API Statistics</span></a>
                    </li>
                  <?php }?>
                  <?php if ($this->session->userdata('user_role') == 1) {?>
                    <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/reports') {?> class="active" <?php }?>>
                      <a href="<?php echo SURL ?>admin/reports/"><i class=" icon-projector-screen-line"></i>
                      <span>Admin Report</span></a>
                    </li>

                    <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/api_documentation') {?> class="active" <?php }?>>
                      <a href="<?php echo SURL ?>admin/api_documentation/"><i class=" icon-projector-screen-line"></i>
                      <span>API Documentation</span></a>
                    </li>

                    <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/app_documentation') {?> class="active" <?php }?>>
                      <a href="<?php echo SURL ?>admin/app_documentation/"><i class=" icon-projector-screen-line"></i>
                      <span>App Documentation</span></a>
                    </li>

                    <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/settings/function_timelog') {?> class="active" <?php }?>>
                      <a href="<?php echo SURL ?>admin/settings/function-timelog/"><i class=" icon-projector-screen-line"></i>
                      <span>Execution Time</span></a>
                    </li>

                    <li <?php if ($_SERVER['REQUEST_URI'] == '/admin/settings/get_barrier_trigger_setting_log') {?> class="active" <?php }?>>
                      <a href="<?php echo SURL ?>admin/settings/get_barrier_trigger_setting_log/"><i class=" icon-projector-screen-line"></i>
                      <span>Trigger Setting Log</span></a>
                    </li>
                  <?php }?>
      </ul>
    </div>
  </div>
</div>
