<!-- Global -->
<style>
  .tradonof{
    min-width: 272px !important;
  }
</style>
<?php

$page_url = $this->uri->segment(3);
$page2 = $this->uri->segment(2);

?>
<script>
	var basePath = '',
		commonPath = '<?php echo ASSETS; ?>',
		rootPath = '',
		DEV = false,
		componentsPath = '<?php echo ASSETS; ?>components/';

	var primaryColor = '#cb4040',
		dangerColor = '#b55151',
		infoColor = '#466baf',
		successColor = '#8baf46',
		warningColor = '#ab7a4b',
		inverseColor = '#45484d';

	var themerPrimaryColor = primaryColor;
</script>
<script src="<?php echo ASSETS; ?>components/library/bootstrap/js/bootstrap.min.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/plugins/nicescroll/jquery.nicescroll.min.js?v=v1.2.3"></script>



<?php //if($page2=='highchart'){ }else{?>
<script src="<?php echo ASSETS; ?>components/plugins/breakpoints/breakpoints.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/core/js/animations.init.js?v=v1.2.3"></script>
<?php /*?><script src="<?php echo ASSETS;?>components/modules/admin/charts/flot/assets/lib/jquery.flot.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS;?>components/modules/admin/charts/flot/assets/lib/jquery.flot.resize.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS;?>components/modules/admin/charts/flot/assets/lib/plugins/jquery.flot.tooltip.min.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS;?>components/modules/admin/charts/flot/assets/custom/js/flotcharts.common.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS;?>components/modules/admin/charts/flot/assets/custom/js/flotchart-simple.init.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS;?>components/modules/admin/charts/flot/assets/custom/js/flotchart-simple-bars.init.js?v=v1.2.3"></script><?php */?>
<script src="<?php echo ASSETS; ?>components/modules/admin/widgets/widget-chat/assets/js/widget-chat.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/plugins/slimscroll/jquery.slimscroll.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/modules/admin/forms/elements/bootstrap-datepicker/assets/lib/js/bootstrap-datepicker.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/modules/admin/forms/elements/bootstrap-datepicker/assets/custom/js/bootstrap-datepicker.init.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/modules/admin/charts/easy-pie/assets/lib/js/jquery.easy-pie-chart.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/modules/admin/charts/easy-pie/assets/custom/easy-pie.init.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/modules/admin/widgets/widget-scrollable/assets/js/widget-scrollable.init.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/plugins/holder/holder.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/core/js/sidebar.main.init.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/core/js/sidebar.collapse.init.js?v=v1.2.3"></script>
<?php /*?><script src="<?php echo ASSETS;?>components/helpers/themer/assets/plugins/cookie/jquery.cookie.js?v=v1.2.3"></script><?php */?>
<script src="<?php echo ASSETS; ?>components/core/js/core.init.js?v=v1.2.3"></script>

<!-- Form Validation -->
<script src="<?php echo ASSETS; ?>components/modules/admin/forms/validator/assets/lib/jquery-validation/dist/jquery.validate.min.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/modules/admin/forms/validator/assets/custom/form-validator.init.js?v=v1.2.3"></script>
<script type="text/javascript" src="<?php echo ASSETS; ?>js/jquery.validate.js"></script>
<!-- End Form Validation -->

<script src="<?php echo ASSETS; ?>components/modules/admin/forms/wizards/assets/lib/jquery.bootstrap.wizard.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/modules/admin/forms/wizards/assets/custom/js/form-wizards.init.js?v=v1.2.3"></script>

<script src="<?php echo ASSETS; ?>components/modules/admin/forms/elements/fuelux-checkbox/fuelux-checkbox.js?v=v1.2.3"></script>


<script src="<?php echo ASSETS; ?>components/modules/admin/tables/datatables/assets/lib/js/jquery.dataTables.min.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/modules/admin/tables/datatables/assets/lib/extras/TableTools/media/js/TableTools.min.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/modules/admin/tables/datatables/assets/lib/extras/ColVis/media/js/ColVis.min.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/modules/admin/tables/datatables/assets/custom/js/DT_bootstrap.js?v=v1.2.3"></script>
<script src="<?php echo ASSETS; ?>components/modules/admin/tables/datatables/assets/custom/js/datatables.init.js?v=v1.2.3"></script>




<script src="<?php echo ASSETS; ?>toastr/toastr.js"></script>


<!-- <script type="text/javascript">
  function _toastr(_message,_position,_notifyType,_onclick) {

      /** JAVSCRIPT / ON LOAD
       ************************* **/
      if(_message != false) {

          if(_onclick != false) {
            onclick = function() {
              window.location = _onclick;
            }
          } else {
            onclick = null
          }

          toastr.options = {
            "closeButton":      true,
            "debug":        false,
            "newestOnTop":      false,
            "progressBar":      true,
            "positionClass":    "toast-" + _position,
            "preventDuplicates":  false,
            "onclick":        onclick,
            "showDuration":     "300",
            "hideDuration":     "1000",
            "timeOut":        "8000",
            "extendedTimeOut":    "1000",
            "showEasing":       "swing",
            "hideEasing":       "linear",
            "showMethod":       "fadeIn",
            "hideMethod":       "fadeOut"
          }

          setTimeout(function(){
            toastr[_notifyType](_message);
          }, 1000); // delay 1s
      }

  }



  function autoload_notifications(id){

      $.ajax({
        type:'POST',
        url:'<?php echo SURL ?>admin/dashboard/autoload_notifications/'+id,
        data: "",
        success:function(response){

            var res = response.split('|');

            if(res[0] !=""){
               _toastr(res[0],"top-right","success",false);
            }

            setTimeout(function() {
                  autoload_notifications(res[1]);
            }, 60000);

        }
      });

    }//end autoload_notifications()

    autoload_notifications(0);

</script> -->





<!-- DropZone -->
<script src="<?php echo ASSETS ?>dropzone/dropzone.js"></script>

<!-- Jquery Confirm -->
<script src="<?php echo ASSETS; ?>jquery_confirm/jquery-confirm.min.js"></script>


<script type="text/javascript">

  $("body").on("change","#profit_type",function(e){

    var profit_type = $(this).val();
    $("#sell_profit_price").val('');

    if(profit_type == 'percentage'){
       $('#sell_profit_percent_div').show();
       $('#sell_profit_price_div').hide();
    }else{
      $('#sell_profit_price_div').show();
      $('#sell_profit_percent_div').hide();
    }

  });


  $("body").on("change","#main_symbol",function(e){

    var symbol = $(this).val();

    $.ajax({
  		'url': '<?php echo SURL ?>admin/dashboard/set_currency',
  		'type': 'POST', //the way you want to send data to your URL
  		'data': {symbol: symbol},
  		'success': function (response) { //probably this request will return anything, it'll be put in var "data"

  			location.reload();
  		}
  	});

  });


  $("body").on("change",".application_mode",function(e){

    var mode = $(this).val();

    $.ajax({
      'url': '<?php echo SURL ?>admin/dashboard/set_application_mode',
      'type': 'POST', //the way you want to send data to your URL
      'data': {mode: mode},
      'success': function (response) { //probably this request will return anything, it'll be put in var "data"

        location.reload();
      }
    });

  });


  $("body").on("keyup","#sell_profit_percent",function(e){

    var sell_profit_percent = $(this).val();
    var purchased_price = $("#purchased_price").val();

    $.ajax({
		'url': '<?php echo SURL ?>admin/dashboard/convert_price',
		'type': 'POST', //the way you want to send data to your URL
		'data': {purchased_price:purchased_price,sell_profit_percent: sell_profit_percent},
		'success': function (response) { //probably this request will return anything, it'll be put in var "data"

			$("#sell_profit_price").val(response);
			$('#sell_profit_price_div').show();
		}
	});

  });


</script>
<script type="text/javascript">

  setTimeout(function() {
   autoload_balance();
  }, 60000);

  function autoload_balance()
  {
    $.ajax({
      url: '<?php echo SURL ?>admin/coin_balance',
      type: 'POST',
      data: "",
      success: function (response) {
      }
    });

  }//end autoload_balance


  // setTimeout(function() {
  //  autoload_check_lasts_order();
  // }, 70000);

  // function autoload_check_lasts_order()
  // {
  //   $.ajax({
  //     url: '<?php echo SURL ?>admin/check_last_balance',
  //     type: 'POST',
  //     data: "",
  //     success: function (response) {
  //     }
  //   });

  // }//end autoload_check_lasts_order

</script>
<script src="<?php echo JS; ?>js.cookie.min.js"></script>
<script type="text/javascript">
  $(document).ready(function()
    {
    //var leftmenu  = "<?php echo $this->session->userdata('leftmenu'); ?>";
    var leftmenu = Cookies.get('sidebar');
    //alert(leftmenu);
    if(leftmenu == 0)
    {
      $('#user_leftmenu_body').addClass('sidebar-mini');
    }
    else
    {
      $('#user_leftmenu_body').removeClass('sidebar-mini');
    }
});


$('#user_leftmenu_setting').on('click', function(e)
{
  //var leftmenu  = "<?php echo $this->session->userdata('leftmenu'); ?>";
  var leftmenu = Cookies.get('sidebar');

  if(leftmenu == 0)
  {
    var leftmenu  = 1;
  }
  else
  {
    var leftmenu  = 0;
  }
  Cookies.set('sidebar', leftmenu, { expires: 7 });
 /* $.ajax({
      'url': '<?php echo SURL ?>admin/settings/user_leftmenu_setting',
      'type': 'POST', //the way you want to send data to your URL
      'data': {leftmenu: leftmenu},
      'success': function (data) { //probably this request will return anything, it'll be put in var "data"
        console.log(data);
        return;
      }
    });*/
});

$(document).ready(function(){
  // get_tradding_status();
	// check_missing_data();
});


 function get_tradding_status(){
    // $.ajax({
    //   'url': '<?php echo SURL ?>admin/settings/get_tradding_status',
    //   'type': 'POST',
    //   'data': {'post':''},
    //   'success': function (data) {
    //       var data = JSON.parse(data);
    //       var status = data.status
    //       var message = data.message
   

    //     if(status == 'off'){
    //       $('.tradonof').html(message);
    //       $('.tradonof').show();
          
    //     }else{
    //       $('.tradonof').hide();
    //     }
    //     console.log(data);
    //         setTimeout(function() {
    //           get_tradding_status();
    //         }, 60000);
    //   }
    // });
  }

	function check_missing_data(){
		//  $.ajax({
		// 	 'url': '<?php echo SURL ?>admin/Is_data_missing_live/check_missing_data',
		// 	 'type': 'POST',
		// 	 'data': {},
		// 	 'success': function (data) {
		// 		 if(data != ''){
    //        $('#datamissing').html(data);
		// 			 $('.datamissing').show();
		// 		 }else{
    //        $('.datamissing').hide();
		// 		 }
		// 		 console.log(data);
		// 				 setTimeout(function() {
		// 					 check_missing_data();
		// 				 }, 60000);
		// 	 },
		// 	 error: function(e){
		// 		 setTimeout(function() {
		// 			 check_missing_data();
		// 		 }, 60000);
		// 	}
		//  });
	 }
</script>

<script src="https://www.gstatic.com/firebasejs/6.4.2/firebase-app.js"></script>
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
</script>

<?php //}?>