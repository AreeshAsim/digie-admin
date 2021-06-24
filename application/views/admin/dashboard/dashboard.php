<div id="content">
	<style>
.notification_popup {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.7);
    z-index: 99999;
    display:none;
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
    box-shadow: 0 0 59px 24px rgba(0,0,43,0.2);
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
    </style>
    <div class="notification_popup">
        <div class="notification_popup_iner">
        	<div class="npclss">X</div>
            <div class="conternta-pop">
              <h2>
              WARNING: You have less than <codet>$10 USD in BNB </codet> balance. To reduce your Binance trading fees, please Maintain a Minimum of <codet>$10 USD in BNB </codet> coin balance in your Binance account.Your digiebot trading account will still trade if you do not have any BNB, but your Binance trading fees will be slightly higher. Binance Fee Schedule https://www.binance.com/en/fee/schedule
              </h2>
            </div>
        </div>
    </div> 
  <div class="innerAll spacing-x2">
    <div class="row">
      <div class="col-md-12">
        <div class="widget">
          <div class="widget-body padding-none">
            <div class="row row-merge">
              <div class="col-sm-4">
                <div class="back">
                  <div class="widget widget-inverse widget-scroll" data-scroll-height="700px">
                    <div class="widget-head">

                      <?php if(isset($_GET['market_value']) && $_GET['market_value'] !=""){ ?>
                      <input type="hidden" value="<?php echo $market_value; ?>" id="market_value">
                      <?php } ?>
                      
                      <h4 class="heading" id="response_market_value_buy" style="color: #ff5d5d;font-weight: bold;">Buy (<?php echo number_format($market_value, 7, '.', ''); ?>)</h4>
                    </div>
                    <div class="widget-body padding-none">
                      <div id="response_buy_trade">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                  <td><strong>Price(BTC)</strong></td>
                                  <td><strong>Amount(<?php echo $currncy;?>)</strong></td>
                                  <td><strong>Total(BTC)</strong></td>
                                </tr>
                            </thead>
                          	<tbody>
                            <?php 
                            if(count($market_buy_depth_arr)>0){
                              foreach ($market_buy_depth_arr as $key => $value) {

                              $lenth22 =  strlen(substr(strrchr($value['price'], "."), 1));
                              if($lenth22==6){
                                $price = $value['price'].'0';
                              }else{
                                $price = $value['price'];
                              } 

                            ?>

                              <tr>
                                <td><?php echo number_format($price,8,".","");?></td>
                                <td><?php echo number_format($value['quantity'], 2, '.', '');?></td>
                                <td>
                                <?php 
                                  $total_price = $value['price'] * $value['quantity'];
                                  number_format($total_price, 7, '.', '');
                                ?>
                                </td>
                              </tr>
                               
                            <?php }
                            } 
                            ?> 
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-sm-4">
                <div class="back">
                  <div class="widget widget-inverse widget-scroll" data-scroll-height="700px">
                    <div class="widget-head">
                      <h4 class="heading" id="response_market_value_sell" style="color: #72ff85;
    font-weight: bold;">Sell (<?php echo number_format($market_value, 7, '.', ''); ?>)</h4>
                    </div>
                    <div class="widget-body padding-none">
                      <div id="response_sell_trade">
                       <table class="table table-condensed">
                            <thead>
                                <tr>
                                  <td><strong>Price(BTC)</strong></td>
                                  <td><strong>Amount(<?php echo $currncy;?>)</strong></td>
                                  <td><strong>Total(BTC)</strong></td>
                                </tr>
                            </thead>
                          	<tbody>
                              <?php 
                              if(count($market_sell_depth_arr)>0){
                                foreach ($market_sell_depth_arr as $key => $value2) { 

                                $lenth33 =  strlen(substr(strrchr($value2['price'], "."), 1));
                                if($lenth33==6){
                                  $price22 = $value2['price'].'0';
                                }else{

                                  $price22 = $value2['price'];
                                } 


                              ?>

                                <tr>
                                  <td><?php echo number_format($price22,8,".","");?></td>
                                  <td><?php echo number_format($value2['quantity'], 2, '.', ''); ?></td>
                                  <td>
                                  <?php 
                                    $total_price2 = $value2['price'] * $value2['quantity'];
                                    number_format($total_price2, 7, '.', '');
                                  ?>  
                                  </td>
                                </tr>
                                 
                              <?php }
                              } 
                              ?> 
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-sm-4">
                <div class="back">
                  <div class="widget widget-inverse widget-scroll" data-scroll-height="700px">
                    <div class="widget-head">
                      <h4 class="heading">Trade History</h4>
                    </div>
                    <div class="widget-body padding-none">
                      <div id="response_market_history">
                       <table class="table table-condensed">
                            <thead>
                                <tr>
                                  <td><strong>Price(BTC)</strong></td>
                                  <td><strong>Amount(<?php echo $currncy;?>)</strong></td>
                                  <td><strong>Total(BTC)</strong></td>
                                </tr>
                            </thead>
                          	<tbody>
                              <?php 
                              if(count($market_history_arr)>0){
                                foreach ($market_history_arr as $key => $value3) { 

                                $maker = $value3['maker'];
                                if($maker=='true'){
                                  $color="red";
                                }else{
                                  $color="green";
                                }
                                ?>
                                <tr style="color:<?php echo $color; ?>">
                                  <td><?php echo number_format($value3['price'], 8, '.', ''); ?></td>
                                  <td><?php echo number_format($value3['quantity'], 2, '.', '');?></td>
                                  <td>
                                  <?php 
                                  $total_price3 = $value3['price'] * $value3['quantity'];
                                  number_format($total_price3, 7, '.', '');
                                  ?>
                                  </td>
                                </tr>                                
                              <?php }
                              } 
                              ?> 
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
        
      </div>
      
    </div>
  </div>
</div>
<!-- // Content END -->


<script type="text/javascript">
$(document).ready(function(e) {
    $("body").on("click",".npclss",function(){
		$(".notification_popup").hide();
	});

  var is_bnb_balance = "<?php echo $is_bnb_balance; ?>";
  if(is_bnb_balance =='NO'){
    $(".notification_popup").show();
  }
  
});
  var call_statusinterval;
  // var auto_refresh;
 
  //auto_refresh = setInterval(autoload_trading_data, 2000);

  // function autoload_trading_data(){

  //     var market_value = $("#market_value").val();
    
  //     $.ajax({
  //       type:'POST',
  //       url:'<?php echo SURL?>admin/dashboard/autoload_trading_data',
  //       data: {market_value:market_value},
  //       success:function(response){

  //         var split_response = response.split('|');

  //         if(split_response[0] !=""){
  //           $('#response_sell_trade').html(split_response[0]);
  //           $('#response_market_value_sell').html('Sell ('+split_response[3]+')');
  //         }
  //         if(split_response[1] !=""){
  //           $('#response_buy_trade').html(split_response[1]);
  //           $('#response_market_value_buy').html('Buy ('+split_response[3]+')');
  //         }
  //         if(split_response[2] !=""){
  //           $('#response_market_history').html(split_response[2]);
  //         }
          
  //         // setTimeout(function() {
  //         //     autoload_trading_data();
  //         // }, 1000);
  //        //autoload_trading_data();
  //       }
  //     });

  // }//end autoload_trading_data() 

  // autoload_trading_data();
</script>

<!-- <script src="https://www.gstatic.com/firebasejs/6.4.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.4.2/firebase-messaging.js"></script>
<script>
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  var firebaseConfig = {
    apiKey: "AIzaSyCYGBSgqmf_fz6wy_AmzDvxzzynfQQQeag",
    authDomain: "cronpushwebnotifications.firebaseapp.com",
    databaseURL: "https://cronpushwebnotifications.firebaseio.com",
    projectId: "cronpushwebnotifications",
    storageBucket: "cronpushwebnotifications.appspot.com",
    messagingSenderId: "150124304503",
    appId: "1:150124304503:web:7920c09685e67dce388e72",
    measurementId: "G-Z1540WB6D2"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  // firebase.analytics();
  // [START get_messaging_object]
  // Retrieve Firebase Messaging object.
  const messaging = firebase.messaging();
  // [END get_messaging_object]
  // [START set_public_vapid_key]
  // Add the public key generated from the console here.
  messaging.usePublicVapidKey('BJ5VEHUPC42i_9Qu_iT2uT6yP5GunAzwxnAuAxyHwTzpEwguvWlfj_7pmtWofZTFUL-KsxuqrtSpSc5vjBQkO0s');
  // [END set_public_vapid_key]
  // IDs of divs that display Instance ID token UI or request permission UI.
  const tokenDivId = 'token_div';
  const permissionDivId = 'permission_div';
  // [START refresh_token]
  // Callback fired if Instance ID token is updated.
  messaging.onTokenRefresh(() => {
    messaging.getToken().then((refreshedToken) => {
      console.log('Token refreshed.');
      // Indicate that the new Instance ID token has not yet been sent to the
      // app server.
      setTokenSentToServer(false);
      // Send Instance ID token to app server.
      sendTokenToServer(refreshedToken);
      // [START_EXCLUDE]
      // Display new Instance ID token and clear UI of all previous messages.
      resetUI();
      // [END_EXCLUDE]
    }).catch((err) => {
      console.log('Unable to retrieve refreshed token ', err);
      showToken('Unable to retrieve refreshed token ', err);
    });
  });
  // [END refresh_token]
  // [START receive_message]
  // Handle incoming messages. Called when:
  // - a message is received while the app has focus
  // - the user clicks on an app notification created by a service worker
  //   `messaging.setBackgroundMessageHandler` handler.
  messaging.onMessage((payload) => {
    console.log('Message received. ', payload);
    // [START_EXCLUDE]
    // Update the UI to include the received message.
    appendMessage(payload);
    // [END_EXCLUDE]
  });
  // [END receive_message]

  function resetUI() {
    clearMessages();
    showToken('loading...');
    // [START get_token]
    // Get Instance ID token. Initially this makes a network call, once retrieved
    // subsequent calls to getToken will return from cache.
    messaging.getToken().then((currentToken) => {
      if (currentToken) {
        sendTokenToServer(currentToken);
        updateUIForPushEnabled(currentToken);
      } else {
        // Show permission request.
        console.log('No Instance ID token available. Request permission to generate one.');
        // Show permission UI.
        updateUIForPushPermissionRequired();
        setTokenSentToServer(false);
      }
    }).catch((err) => {
      console.log('An error occurred while retrieving token. ', err);
      showToken('Error retrieving Instance ID token. ', err);
      setTokenSentToServer(false);
    });
    // [END get_token]
  }
  function showToken(currentToken) {
    // Show token in console and UI.
    // const tokenElement = document.querySelector('#token');
    // tokenElement.textContent = currentToken;
    // console.log(currentToken);
  }
  // Send the Instance ID token your application server, so that it can:
  // - send messages back to this app
  // - subscribe/unsubscribe the token from topics
  function sendTokenToServer(currentToken) {
    if (!isTokenSentToServer()) {
      console.log('Sending token::: '+currentToken+' ::: to server...');
     
      var adminId = <?php echo json_encode($_SESSION['admin_id']) ?>;
      console.log('admin Id: '+adminId);
        var surl = '<?php echo SURL ?>';
        $.ajax({
            url: surl + "/admin/dashboard/insertTocken",
            data: { currentToken: currentToken, adminId: adminId },
            type: "POST",
            success: function(datajson) {
                console.log(datajson);
            }
      });
      // TODO(developer): Send the current token to your server.
      console.log(setTokenSentToServer(true));

      
    } else {
      console.log('Token already sent to server so won\'t send it again ' +
          'unless it changes');
    }
  }
  function isTokenSentToServer() {
    return window.localStorage.getItem('sentToServer') === '1';
  }
  function setTokenSentToServer(sent) {

    window.localStorage.setItem('sentToServer', sent ? '1' : '0');
    return true;
  }
  function showHideDiv(divId, show) {
    // const div = document.querySelector('#' + divId);
    // if (show) {
    //   div.style = 'display: visible';
    // } else {
    //   div.style = 'display: none';
    // }
  }

  $('document').ready(function(){
    // console.log('Requesting permission...');
    // [START request_permission]
    Notification.requestPermission().then((permission) => {
      if (permission === 'granted') {
        console.log('Notification permission granted.');

        // TODO(developer): //Retrieve an Instance ID token for use with FCM.
        // [START_EXCLUDE]
        // In many cases once an app has been granted notification permission,
        // it should update its UI reflecting this.
        resetUI();
        // [END_EXCLUDE]
      } else {
        console.log('Unable to get permission to notify.');
      }
    });
    // [END request_permission]
  });

  function deleteToken() {
    // Delete Instance ID token.
    // [START delete_token]
    messaging.getToken().then((currentToken) => {
      messaging.deleteToken(currentToken).then(() => {
        console.log('Token deleted.');
        setTokenSentToServer(false);
        // [START_EXCLUDE]
        // Once token is deleted update UI.
        resetUI();
        // [END_EXCLUDE]
      }).catch((err) => {
        console.log('Unable to delete token. ', err);
      });
      // [END delete_token]
    }).catch((err) => {
      console.log('Error retrieving Instance ID token. ', err);
      showToken('Error retrieving Instance ID token. ', err);
    });
  }
  // Add a message to the messages element.
  function appendMessage(payload) {
    console.log(payload);
    const messagesElement = document.querySelector('#messages');
    const dataHeaderELement = document.createElement('h5');
    const dataElement = document.createElement('pre');
    dataElement.style = 'overflow-x:hidden;';
    dataHeaderELement.textContent = 'Received message:';
    dataElement.textContent = JSON.stringify(payload, null, 2);
    messagesElement.appendChild(dataHeaderELement);
    messagesElement.appendChild(dataElement);
    console.log(dataElement);
  }
  // Clear the messages element of all children.
  function clearMessages() {
    // const messagesElement = document.querySelector('#messages');
    // while (messagesElement.hasChildNodes()) {
    //   messagesElement.removeChild(messagesElement.lastChild);
    // }
  }
  function updateUIForPushEnabled(currentToken) {
    // showHideDiv(tokenDivId, true);
    // showHideDiv(permissionDivId, false);
    // showToken(currentToken);
  }
  function updateUIForPushPermissionRequired() {
    // showHideDiv(tokenDivId, false);
    // showHideDiv(permissionDivId, true);
  }
  resetUI();
</script> -->