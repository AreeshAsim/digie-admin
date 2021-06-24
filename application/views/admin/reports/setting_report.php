<?php $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>



<link href="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.css" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?php echo ASSETS ?>buyer_order/moment-with-locales.js"></script>
<script src="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo SURL ?>assets/dist/jquery-asPieProgress.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<style type="text/css">
/* Required Styling */
label input[type="checkbox"] {
display: none;
}

.custom-checkbox {
margin-left: 2em;
position: relative;
cursor: pointer;
}

.custom-checkbox .glyphicon {
color: red;
position: absolute;
top: 0.4em;
left: -1.25em;
font-size: 0.75em;
}

.custom-checkbox .glyphicon-heart-empty {
color: gray;
}

.custom-checkbox .glyphicon-heart {
opacity: 0;
transition: opacity 0.2s ease-in-out;
}

.custom-checkbox:hover .glyphicon-heart {
opacity: 0.5;
}

.custom-checkbox input[type="checkbox"]:checked ~ .glyphicon-heart {
opacity: 1;
}

.autoresponsive tr th span {
float: right;
width: 1%;
margin-left: 0px;
}

.autoresponsive tr th strong {
float: left;
width: 96%;
display: inline-block;
}

#svg {
transform: rotate(-90deg);
}

#svg circle {
stroke-dashoffset: 0;
stroke: #FFF;
stroke-width: 6px;
}

#progress-text {
position: absolute;
width: 96px;
height: 96px;
text-align: center;
font-size: 25px;
line-height: 96px;
top: 0px;
}

#svg #bar {
stroke: #FF9F1E;
stroke-dasharray: 205.834 263.89;
}

ellipse {
stroke: #dadada !important;
}

.colpanel {
float: left;
width: 100%;
padding: 15px 15px 0;
box-shadow: 0 0 17px 3px rgba(0, 0, 0, 0.1);
border-radius: 10px;
margin-bottom: 15px;
}

.modal-dialog {
width: 96% !important;

}
</style>
<style>
/* STYLES FOR PROGRESSBARS */
.progress-radial, .progress-radial * {
-webkit-box-sizing: content-box;
-moz-box-sizing: content-box;
box-sizing: content-box;
}

/* -------------------------------------
* Bar container
* ------------------------------------- */
.progress-radial {
float: left;
margin-right: 4%;
position: relative;
width: 55px;
border-radius: 50%;
}

.progress-radial:first-child {
margin-left: 4%;
}

/* -------------------------------------
* Optional centered circle w/text
* ------------------------------------- */
.progress-radial .overlay {
position: absolute;
width: 80%;
background-color: #f0f0f0;
border-radius: 50%;
font-size: 14px;
top: 50%;
left: 50%;
-webkit-transform: translate(-50%, -50%);
-ms-transform: translate(-50%, -50%);
transform: translate(-50%, -50%);
}

.progress-radial .overlay p {
position: absolute;
line-height: 40px;
text-align: center;
width: 100%;
top: 50%;
margin-top: -20px;
}

/* -------------------------------------
* Mixin for progress-% class
* ------------------------------------- */
.progress-green-0 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(0deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(90deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-5 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(342deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(108deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-10 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(324deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(126deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-15 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(306deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(144deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-20 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(288deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(162deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-25 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(270deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(180deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-30 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(252deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(198deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-35 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(234deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(216deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-40 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(216deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(234deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-45 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(198deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(252deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-50 {
background-image: -webkit-linear-gradient(180deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(-90deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-55 {
background-image: -webkit-linear-gradient(162deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(-72deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-60 {
background-image: -webkit-linear-gradient(144deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(-54deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-65 {
background-image: -webkit-linear-gradient(126deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(-36deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-70 {
background-image: -webkit-linear-gradient(108deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(-18deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-75 {
background-image: -webkit-linear-gradient(90deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(0deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-80 {
background-image: -webkit-linear-gradient(72deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(18deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-85 {
background-image: -webkit-linear-gradient(54deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(36deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-90 {
background-image: -webkit-linear-gradient(36deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(54deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-95 {
background-image: -webkit-linear-gradient(18deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(72deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-green-100 {
background-image: -webkit-linear-gradient(0deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #4caf50 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #4caf50 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-0 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(0deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(90deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-5 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(342deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(108deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-10 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(324deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(126deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-15 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(306deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(144deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-20 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(288deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(162deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-25 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(270deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(180deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-30 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(252deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(198deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-35 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(234deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(216deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-40 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(216deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(234deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-45 {
background-image: -webkit-linear-gradient(0deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(198deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f0f0f0 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(252deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-50 {
background-image: -webkit-linear-gradient(180deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(-90deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-55 {
background-image: -webkit-linear-gradient(162deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(-72deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-60 {
background-image: -webkit-linear-gradient(144deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(-54deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-65 {
background-image: -webkit-linear-gradient(126deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(-36deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-70 {
background-image: -webkit-linear-gradient(108deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(-18deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-75 {
background-image: -webkit-linear-gradient(90deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(0deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-80 {
background-image: -webkit-linear-gradient(72deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(18deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-85 {
background-image: -webkit-linear-gradient(54deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(36deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-90 {
background-image: -webkit-linear-gradient(36deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(54deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-95 {
background-image: -webkit-linear-gradient(18deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(72deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.progress-red-100 {
background-image: -webkit-linear-gradient(0deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), -webkit-linear-gradient(180deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
background-image: linear-gradient(90deg, #f44336 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), linear-gradient(270deg, #f44336 50%, #f0f0f0 50%, #f0f0f0);
}

.mypai_prog {
display: inline-block;
padding: 2px;
}

.tdmypi {
padding: 2px;
text-align: center;
}

div.pie_progress__label {
position: absolute;
top: 20px;
left: 8px;
}

.pie_progress {
position: relative;
width: 60px;
text-align: center;
margin-left: 39px;
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
<div class="innerAll spacing-x2">
<?php
if ($this->session->flashdata('err_message')) {
    ?>
<div class="alert alert-danger"> <?php echo $this->session->flashdata('err_message'); ?> </div>
<?php
}
if ($this->session->flashdata('ok_message')) {
    ?>
<div class="alert alert-success alert-dismissable"> <?php echo $this->session->flashdata('ok_message'); ?> </div>
<?php
}
?>
<?php //$filter_user_data = $this->session->userdata('filter_order_data'); ?>
<!-- Widget -->
<div class="widget widget-inverse">
<div class="widget-body">
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-info"> The Time using in report is UTC (GMT + 0)</div>
        </div>
    </div>
</div>
</div>
<div class="widget widget-inverse">
<div class="widget-body">
    <form action="<?php echo SURL . "admin/reports/settings_report_listing?trigger=" . $_GET['trigger'] ?>"
          method="post">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="Input_text_s coin_filter">
                    <label>Filter Coin</label>
                    <select id="filter_by_coin" name="filter_by_coin" type="text"
                            class="form-control filter_by_name_margin_bottom_sm">
                        <option value="" <?=(($filter_user_data1['filter_by_coin'] == "") ? "selected" : "")?>>
                            Search By Coin Symbol
                        </option>
                        <?php
for ($i = 0; $i < count($coins); $i++) {
    $selected = ($coins[$i]['symbol'] == $filter_user_data1['filter_by_coin']) ? "selected" : "";
    echo "<option value='" . $coins[$i]['symbol'] . "' $selected>" . $coins[$i]['symbol'] . "</option>";
}
?>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="Input_text_s">
                    <label>Filter by Admin</label>
                    <select id="filter_by_admin" name="filter_by_admin" type="text"
                            class="form-control filter_by_name_margin_bottom_sm">
                        <option value="" <?=(($filter_user_data1['filter_by_admin'] == "") ? "selected" : "")?>>
                            Search By Admin
                        </option>
                        <?php
for ($i = 0; $i < count($admins); $i++) {
    $selected = ($admins[$i]['_id'] == $filter_user_data1['filter_by_admin']) ?
    "selected" : "";
    echo "<option value='" . $admins[$i]['_id'] . "' $selected>" . $admins[$i]['username'] . "</option>";
}
?>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="Input_text_s">
                    <label>Filter by Setting Name</label>
                    <input id="filter_by_name" name="filter_by_name" type="text" class="form-control"
                           value="<?=$filter_user_data1['filter_by_name']?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="Input_text_s">
                    <label>Number of Days More then</label>
                    <input id="filter_by_days" name="filter_by_days" type="text" class="form-control"
                           value="<?=$filter_user_data1['filter_by_days']?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="Input_text_s">
                    <label>Result Percentage more then</label>
                    <input id="filter_by_percentage" name="filter_by_percentage" type="text"
                           class="form-control" value="<?=$filter_user_data1['filter_by_percentage']?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="Input_text_s">
                    <label>Target Profit More then</label>
                    <input id="filter_by_profit" name="filter_by_profit" type="text" class="form-control"
                           value="<?=$filter_user_data1['filter_by_profit']?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="Input_text_s">
                    <label>Stop Loss More then</label>
                    <input id="filter_by_loss" name="filter_by_loss" type="text" class="form-control"
                           value="<?=$filter_user_data1['filter_by_loss']?>">
                </div>
            </div>
            <div class="col-sm-12 col-md-12">
                <div class="col-xs-12 col-sm-12 col-md-6 ax_4">
                    <div class="Input_text_s">
                        <label>From Date Range: <br>
                        </label>
                        <input id="filter_by_start_date" name="filter_by_start_date" type="text"
                               class="form-control datetime_picker filter_by_name_margin_bottom_sm"
                               placeholder="Search By Date"
                               value="<?=(!empty($filter_user_data1['filter_by_start_date']) ? $filter_user_data1['filter_by_start_date'] : "")?>"
                               autocomplete="off">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 ax_5">
                    <div class="Input_text_s">
                        <label>To Date Range: <br>
                        </label>
                        <input id="filter_by_end_date" name="filter_by_end_date" type="text"
                               class="form-control datetime_picker filter_by_name_margin_bottom_sm"
                               placeholder="Search By Date"
                               value="<?=(!empty($filter_user_data1['filter_by_end_date']) ? $filter_user_data1['filter_by_end_date'] : "")?>"
                               autocomplete="off">
                    </div>
                </div>
                <script type="text/javascript">
                    $(function () {
                        $('.datetime_picker').datetimepicker();
                    });
                </script>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 ax_5">
                <div class="Input_text_s">
                    <input id="submit" name="submit" type="submit" class="btn btn-success btn-md"
                           value="Submit">
                </div>
            </div>
        </div>
    </form>
</div>
<div class="widget widget-inverse">
    <div class="widget-body">
        <br>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">All Listing</a></li>
            <li><a data-toggle="tab" href="#menu1">Short Listed</a></li>
        </ul>
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div class="widget widget-inverse">
                    <div class="widget-head">
                        <div class="row">
                            <div class="col-md-12">
                                Settings
                                <span style="float:right;">
                     <!-- <button class="btn btn-info" onclick="exportTableToCSV('report.csv')">Export To CSV File</button> -->
                  </span>
                            </div>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="row" style="padding-bottom: 8px;margin-bottom: 10px;"><span
                                    style="float:right"> <a href="#!" class="btn btn-primary btn-copy"><img
                                            src="https://app.digiebot.com/assets/images/my_icons/copy.png"></a> <a
                                        href="javascript:void(0)" class="btn btn-primary btn-csv"
                                        onclick="exportTableToCSV('report.csv')"><img
                                            src="https://app.digiebot.com/assets/images/my_icons/csv.png"></a> <a
                                        href="#!" class="btn btn-primary btn-excel"><img
                                            src="https://app.digiebot.com/assets/images/my_icons/excel.png"></a> <a
                                        href="javascript:void(0)" class="btn btn-primary btn-pdf"><img
                                            src="https://app.digiebot.com/assets/images/my_icons/pdf.png"></a> <a
                                        href="#!" class="btn btn-primary btn-print"><img
                                            src="https://app.digiebot.com/assets/images/my_icons/print.png"></a> </span>
                        </div>
                        <div class="row">
                            <div class="autoresponsive">
                                <div class="table-responsive">
                                    <table class="example table table-hover" id="example">
                                        <thead>
                                        <tr>
                                            <th><strong>#</strong></th>
                                            <th>
                                                <strong>Coin Symbol</strong>
                                                <span>
                                    <a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=symbol&type=DESC"><i
                                                class="glyphicon glyphicon-chevron-up"></i></a><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=symbol&type=ASC"><i
                                                                class="glyphicon glyphicon-chevron-down"></i>
                                    <a>
                                 </span>
                                            </th>
                                            <th><strong>Setting Name</strong>
                                                <span>
                              <a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=settings.title_to_filter&type=DESC"><i
                                          class="glyphicon glyphicon-chevron-up"></i></a><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=settings.title_to_filter&type=ASC"><i
                                                                class="glyphicon glyphicon-chevron-down"></i>
                              <a>
                              </span>
                                            </th>
                                            <th>
                                                <strong>Total Oppurtunities</strong>
                                                <span>
                              <a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=total&type=DESC"><i
                                          class="glyphicon glyphicon-chevron-up"></i></a><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=total&type=ASC"><i
                                                                class="glyphicon glyphicon-chevron-down"></i>
                              <a>
                              </span>
                                            </th>
                                            <th><strong>Winning Opportunities</strong>
                                                <span>
                              <a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=winning&type=DESC"><i
                                          class="glyphicon glyphicon-chevron-up"></i></a><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=winning&type=ASC"><i
                                                                class="glyphicon glyphicon-chevron-down"></i>
                              <a>
                              </span>
                                            </th>
                                            <th><strong>Losing Opportunities</strong>
                                                <span>
                              <a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=losing&type=DESC"><i
                                          class="glyphicon glyphicon-chevron-up"></i></a><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=losing&type=ASC"><i
                                                                class="glyphicon glyphicon-chevron-down"></i>
                              </span>
                                            </th>
                                            <th><strong>Winning Percentage</strong> <span><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=win_per&type=DESC"><i
                                                                class="glyphicon glyphicon-chevron-up"></i></a><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=win_per&type=ASC"><i
                                                                class="glyphicon glyphicon-chevron-down"></i></span>
                                            </th>
                                            <th><strong>Losing Percentage</strong> <span><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=lose_per&type=DESC"><i
                                                                class="glyphicon glyphicon-chevron-up"></i></a><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=lose_per&type=ASC"><i
                                                                class="glyphicon glyphicon-chevron-down"></i></span>
                                            </th>
                                            <th><strong>Total Winning Profit</strong> <span><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=winners&type=DESC"><i
                                                                class="glyphicon glyphicon-chevron-up"></i></a><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=winners&type=ASC"><i
                                                                class="glyphicon glyphicon-chevron-down"></i></span>
                                            </th>
                                            <th><strong>Total Losing Profit</strong> <span><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=losers&type=DESC"><i
                                                                class="glyphicon glyphicon-chevron-up"></i></a><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=losers&type=ASC"><i
                                                                class="glyphicon glyphicon-chevron-down"></i></span>
                                            </th>
                                            <th><strong>Total Percentage</strong> <span><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=total_profit&type=DESC"><i
                                                                class="glyphicon glyphicon-chevron-up"></i></a><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=total_profit&type=ASC"><i
                                                                class="glyphicon glyphicon-chevron-down"></i></span>
                                            </th>
                                            <th><strong>Per Trade Percentage Profit</strong> <span><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=per_trade&type=DESC"><i
                                                                class="glyphicon glyphicon-chevron-up"></i></a><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=per_trade&type=ASC"><i
                                                                class="glyphicon glyphicon-chevron-down"></i></span>
                                            </th>
                                            <th><strong>Per Day Percentage Profit</strong> <span><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=per_day&type=DESC"><i
                                                                class="glyphicon glyphicon-chevron-up"></i></a><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=per_day&type=ASC"><i
                                                                class="glyphicon glyphicon-chevron-down"></i></span>
                                            </th>
                                            <th><strong>Average Time</strong> <span></span></th>
                                            <th><strong>No of Days</strong> <span><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=total_number_of_days&type=DESC"><i
                                                                class="glyphicon glyphicon-chevron-up"></i></a><a
                                                            href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=total_number_of_days&type=ASC"><i
                                                                class="glyphicon glyphicon-chevron-down"></i></span>
                                            </th>
                                            <th><strong>Start Date</strong> <span></span></th>
                                            <th><strong>End Date</strong> <span></span></th>
                                            <th><strong>Created Date</strong> <span></span></th>
                                            <th><strong>Action</strong> <span></span></th>
                                        </tr>
                                        </thead>
                                        <?php
$i = 1;
foreach ($setting AS $row) {
    ?>
                                            <tr id="row_<?php echo $row['_id']; ?>_1">
                                                <td><?php echo $i++; ?></td>
                                                <td>
                                                    <?php $logo = $this->mod_coins->get_coin_logo($row['symbol']);?>
                                                    <img src="<?php echo ASSETS; ?>coin_logo/thumbs/<?php echo $logo; ?>"
                                                         class="img img-circle" data-toggle="tooltip"
                                                         data-placement="top"
                                                         title="<?php echo $row['symbol'] ?>">
                                                </td>
                                                <td><?=$row['title_to_filter']?></td>
                                                <td><?=$row['total']?></td>
                                                <td><?=number_format($row['winning'], 2)?></td>
                                                <td><?=number_format($row['losing'], 2)?></td>
                                                <td class="tdmypi"><?php
$profit = number_format($row['win_per'], 2);
    if ($profit > 0) {
        $color = 'data-barcolor="#3daf2c"';
        $minumu = '0';
        $maximu = '100';
        $profit = $profit;
        $profitorg = $profit;

    } else if ($profit < 0) {
        $color = 'data-barcolor="#d60606"';
        $minumu = '-100';
        $maximu = '0';
        $profitorg = $profit;
        $profit = -5 - $profit;

    } else if ($profit == 0) {
        $color = '';
        $minumu = '0';
        $maximu = '0';
        $profitorg = $profit;
        $profit = 0;
    }
    ?>
                                                    <script type="text/javascript">
                                                        $(document).ready(function () {

                                                            $('.pie_progress').asPieProgress({
                                                                namespace: 'pie_progress'
                                                            });
                                                            $('.wpie_progress<?php echo $row['_id']; ?>').asPieProgress('go', <?php echo $profit; ?>);
                                                        });

                                                    </script>
                                                    <div class="pie_progress wpie_progress<?php echo $row['_id']; ?>"
                                                         role="progressbar" <?php echo $color; ?>
                                                         data-goal="100"
                                                         aria-valuemin="<?php echo $minumu; ?>"
                                                         aria-valuemax="<?php echo $maximu; ?>">
                                                        <div class="pie_progress__label"> <?php echo $profitorg; ?>
                                                            %
                                                        </div>
                                                    </div>
                                                </td>
                                                <!-- <td><?=number_format($row['win_per'], 2)?></td> -->
                                                <!-- <td><?=number_format($row['lose_per'], 2)?></td> -->
                                                <td class="tdmypi"><?php
$profit = number_format($row['lose_per'], 2);
    if ($profit > 0) {
        $color = 'data-barcolor="#d60606"';
        $minumu = '0';
        $maximu = '100';
        $profit = $profit;
        $profitorg = $profit;

    } else if ($profit < 0) {
        $color = 'data-barcolor="#3daf2c"';
        $minumu = '-100';
        $maximu = '0';
        $profitorg = $profit;
        $profit = -5 - $profit;

    } else if ($profit == 0) {
        $color = '';
        $minumu = '0';
        $maximu = '0';
        $profitorg = $profit;
        $profit = 0;
    }
    ?>
                                                    <script type="text/javascript">
                                                        $(document).ready(function () {

                                                            $('.pie_progress').asPieProgress({
                                                                namespace: 'pie_progress'
                                                            });
                                                            $('.lpie_progress<?php echo $row['_id']; ?>').asPieProgress('go', <?php echo $profit; ?>);
                                                        });

                                                    </script>
                                                    <div class="pie_progress lpie_progress<?php echo $row['_id']; ?>"
                                                         role="progressbar" <?php echo $color; ?>
                                                         data-goal="100"
                                                         aria-valuemin="<?php echo $minumu; ?>"
                                                         aria-valuemax="<?php echo $maximu; ?>">
                                                        <div class="pie_progress__label"> <?php echo $profitorg; ?>
                                                            %
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?=number_format($row['winners'], 2)?></td>
                                                <td><?=number_format($row['losers'], 2)?></td>
                                                <td><?=number_format($row['total_profit'], 2)?></td>
                                                <td><?=number_format($row['per_trade'], 2)?></td>
                                                <td><?=number_format($row['per_day'], 2)?></td>
                                                <td><?=number_format($row['average_time'], 2)?></td>
                                                <td><?php echo $row['total_number_of_days']; ?></td>
                                                <td><?=$row['created_date']->toDatetime()->format("Y-m-d H:i:s");?></td>
                                                <td><?=$row['end_date']->toDatetime()->format("Y-m-d H:i:s");?></td>
                                                <td><?=(!empty($row['current_date']) ? $row['current_date']->toDatetime()->format("Y-m-d H:i:s") : "-")?></td>
                                                <td><label for="id-of-input_<?php echo $i; ?>"
                                                           class="custom-checkbox"
                                                           style="font-size : 40px;left: -25px;">
                                                        <input type="checkbox" class="add_fav"
                                                               id="id-of-input_<?php echo $i; ?>"
                                                               data-id="<?php echo $row['_id']; ?>" <?php if ($row['is_fav'] == 'yes') {
        echo "checked";
    }?>/>
                                                        <i class="glyphicon glyphicon-heart-empty"></i> <i
                                                                class="glyphicon glyphicon-heart"></i></i>
                                                    </label></td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr id="row_<?php echo $row['_id']; ?>_2">
                                                <td><?php echo $i++; ?></td>
                                                <td>
                                                    <?php $logo = $this->mod_coins->get_coin_logo($row['symbol']);?>
                                                    <img src="<?php echo ASSETS; ?>coin_logo/thumbs/<?php echo $logo; ?>"
                                                         class="img img-circle" data-toggle="tooltip"
                                                         data-placement="top"
                                                         title="<?php echo $value['symbol'] ?>">
                                                </td>
                                                <td><?=$row['title_to_filter']?></td>
                                                <td><?=$row['total']?></td>
                                                <td><?=number_format($row['winning2'], 2)?></td>
                                                <td><?=number_format($row['losing2'], 2)?></td>
                                                <td class="tdmypi"><?php
$profit = number_format($row['win_per2'], 2);
    if ($profit > 0) {
        $color = 'data-barcolor="#3daf2c"';
        $minumu = '0';
        $maximu = '100';
        $profit = $profit;
        $profitorg = $profit;

    } else if ($profit < 0) {
        $color = 'data-barcolor="#d60606"';
        $minumu = '-100';
        $maximu = '0';
        $profitorg = $profit;
        $profit = -5 - $profit;

    } else if ($profit == 0) {
        $color = '';
        $minumu = '0';
        $maximu = '0';
        $profitorg = $profit;
        $profit = 0;
    }
    ?>
                                                    <script type="text/javascript">
                                                        $(document).ready(function () {

                                                            $('.pie_progress').asPieProgress({
                                                                namespace: 'pie_progress'
                                                            });
                                                            $('.wpie_progress<?php echo $row['_id']; ?>').asPieProgress('go', <?php echo $profit; ?>);
                                                        });

                                                    </script>
                                                    <div class="pie_progress wpie_progress<?php echo $row['_id']; ?>"
                                                         role="progressbar" <?php echo $color; ?>
                                                         data-goal="100"
                                                         aria-valuemin="<?php echo $minumu; ?>"
                                                         aria-valuemax="<?php echo $maximu; ?>">
                                                        <div class="pie_progress__label"> <?php echo $profitorg; ?>
                                                            %
                                                        </div>
                                                    </div>
                                                </td>
                                                <!-- <td><?=number_format($row['win_per'], 2)?></td> -->
                                                <!-- <td><?=number_format($row['lose_per'], 2)?></td> -->
                                                <td class="tdmypi"><?php
$profit = number_format($row['lose_per2'], 2);
    if ($profit > 0) {
        $color = 'data-barcolor="#d60606"';
        $minumu = '0';
        $maximu = '100';
        $profit = $profit;
        $profitorg = $profit;

    } else if ($profit < 0) {
        $color = 'data-barcolor="#3daf2c"';
        $minumu = '-100';
        $maximu = '0';
        $profitorg = $profit;
        $profit = -5 - $profit;

    } else if ($profit == 0) {
        $color = '';
        $minumu = '0';
        $maximu = '0';
        $profitorg = $profit;
        $profit = 0;
    }
    ?>
                                                    <script type="text/javascript">
                                                        $(document).ready(function () {

                                                            $('.pie_progress').asPieProgress({
                                                                namespace: 'pie_progress'
                                                            });
                                                            $('.lpie_progress<?php echo $row['_id']; ?>').asPieProgress('go', <?php echo $profit; ?>);
                                                        });

                                                    </script>
                                                    <div class="pie_progress lpie_progress<?php echo $row['_id']; ?>"
                                                         role="progressbar" <?php echo $color; ?>
                                                         data-goal="100"
                                                         aria-valuemin="<?php echo $minumu; ?>"
                                                         aria-valuemax="<?php echo $maximu; ?>">
                                                        <div class="pie_progress__label"> <?php echo $profitorg; ?>
                                                            %
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?=number_format($row['winners2'], 2)?></td>
                                                <td><?=number_format($row['losers2'], 2)?></td>
                                                <td><?=number_format($row['total_profit2'], 2)?></td>
                                                <td><?=number_format($row['per_trade2'], 2)?></td>
                                                <td><?=number_format($row['per_day2'], 2)?></td>
                                                <td><?=number_format($row['average_time'], 2)?></td>
                                                <td><?php echo $row['total_number_of_days']; ?></td>
                                                <td><?=$row['created_date']->toDatetime()->format("Y-m-d H:i:s");?></td>
                                                <td><?=$row['end_date']->toDatetime()->format("Y-m-d H:i:s");?></td>
                                                <td><?=(!empty($row['current_date']) ? $row['current_date']->toDatetime()->format("Y-m-d H:i:s") : "-")?></td>
                                                <td><label for="id-of-input_<?php echo $i; ?>"
                                                           class="custom-checkbox"
                                                           style="font-size : 40px;left: -25px;">
                                                        <input type="checkbox" class="add_fav"
                                                               id="id-of-input_<?php echo $i; ?>"
                                                               data-id="<?php echo $row['_id']; ?>" <?php if ($row['is_fav'] == 'yes') {
        echo "checked";
    }?>/>
                                                        <i class="glyphicon glyphicon-heart-empty"></i> <i
                                                                class="glyphicon glyphicon-heart"></i></i>
                                                    </label></td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#myModal1x_<?php echo $row['_id']; ?>">
                                                        <i class="fa fa-file"></i></button>
                                                    <div class="modal fade"
                                                         id="myModal1x_<?php echo $row['_id']; ?>"
                                                         role="dialog">
                                                        <div class="modal-dialog modal-lg"
                                                             style="width: 90%;">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal">&times;
                                                                    </button>
                                                                    <h4 class="modal-title">
                                                                        Report <?php echo $row['title_to_filter']; ?></h4>
                                                                </div>
                                                                <div class="modal-body autoresponsive">
                                                                    <div class="table-responsive">
                                                                        <table class="dynamicTable display table table-stripped"
                                                                           id="my_tables">
                                                                        <thead>
                                                                        <?php
$final = $row['result'];
    if (count($final) > 0) {
        $x = 0;
        foreach ($final as $key => $value) {
            if (!empty($value)) {
                if ($x == 0) {
                    $percentile_log_head = $value['percentile_log'];
                    $x++;
                    break;
                } else {
                    continue;
                }
            }
        }
    }
    ?>
                                                                        <tr>
                                                                              <th>Opportunity Time</th>

                                                                              <th>Market Price</th>

                                                                              <th>Market Time</th>

                                                                              <th>Barrier Value</th>

                                                                              <th>Last Candle Value</th>

                                                                              <th>Message With Loss 1</th>

                                                                              <th>Profit Percentage</th>

                                                                              <th>Profit Time</th>

                                                                              <th>Profit Price</th>

                                                                              <th>Profit Time Ago</th>

                                                                              <th>Loss Percentage</th>

                                                                              <th>Loss Time</th>

                                                                              <th>Loss Price</th>

                                                                              <th>Loss Time Ago</th>

                                                                              <th>Message With Loss 2</th>

                                                                              <th>Loss Percentage2</th>

                                                                              <th>Loss Time2</th>

                                                                              <th>Loss Price 2</th>

                                                                              <th>Loss Time Ago2</th>

                                                                               <th>Top 2 prices</th>
                                                                               <th>Five Hour Max Profit</th>
                                                                               <th>Five Hour Min Profit</th>
                                                                               <th>Verify</th>
                                                                            <?php
foreach ($percentile_log_head as $heading => $val) {?>
                                                                                <th> <?php echo ucfirst(str_replace("_", " ", $heading)) ?> </th>
                                                                            <?php }?>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php
$final = $row['result'];
    if (count($final) > 0) {
        foreach ($final as $key => $value) {
            if (!empty($value)) {
                ?>
                                                                                    <tr>
                                                                                        <td><?=$key;?></td>
                                                                                        <td><?=$value['market_value'];?></td>

                                                                                      <td><?=$value['market_time'];?></td>

                                                                                      <td><?=$value['barrier'];?></td>

                                                                                      <td><?=$value['last_candle_value'];?></td>

                                                                                      <td><?=$value['message'];?></td>

                                                                                      <td><?=$value['profit_percentage'];?></td>

                                                                                      <td><?=$value['profit_date'];?></td>

                                                                                      <td><?=$value['proft_price'];?></td>

                                                                                      <td><?=$value['profit_time'];?></td>

                                                                                      <td><?=$value['loss_percentage'];?></td>

                                                                                      <td><?=$value['loss_date'];?></td>

                                                                                      <td><?=$value['loss_price'];?></td>

                                                                                      <td><?=$value['loss_time'];?></td>

                                                                                      <td><?=$value['message2'];?></td>

                                                                                      <td><?=$value['loss_percentage2'];?></td>

                                                                                      <td><?=$value['loss_date2'];?></td>

                                                                                      <td><?=$value['loss_price2'];?></td>

                                                                                      <td><?=$value['loss_time2'];?></td>

                                                                                      <td><?=$value['top_prices']?></td>
                                                                                        <td><?=number_format(($value['high'] - $value['market_value']) / $value['high'] * 100, 2);?></td>
                                                                                        <td><?=number_format(($value['low'] - $value['market_value']) / $value['low'] * 100, 2);?></td>

                                                                                        <td><button class="btn btn-success btn-verify" data-coin="<?php echo $row['symbol'] ?> id="<?=$key?>">Verify</button></td>
                                                                                        <?php
$percentile_log = $value['percentile_log'];
                foreach ($percentile_log as $heading => $val) {?>
                                                                                            <td><?php echo $val; ?></td>
                                                                                        <?php }?>
                                                                                    </tr>
                                                                                    <?php
}
        }
    }
    ?>
                                                                        </tbody>
                                                                    </table>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                            class="btn btn-primary"
                                                                            data-dismiss="modal">Close
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-info btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#myModal2x_<?php echo $row['_id']; ?>">
                                                        <i class="fa fa-cogs"></i></button>
                                                    <div class="modal fade"
                                                         id="myModal2x_<?php echo $row['_id']; ?>"
                                                         role="dialog">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal">&times;
                                                                    </button>
                                                                    <h4 class="modal-title">Settings</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">

                                                                            <div class="row">
                                                                                <?php $filter_user_data = $row['settings'];?>
                                                                                <div class="col-xs-12 col-md-6">

                                                                                    <div class="colpanel">

                                                                                        <div class="colpanel-h">

                                                                                            <div class="col-xs-12 col-md-6">

                                                                                                <input type="radio"
                                                                                                       class="radiobtn"
                                                                                                       id="radio3"
                                                                                                       name="radio-category"
                                                                                                       value="new"
                                                                                                       checked=""/>

                                                                                                <label for="radio3">New
                                                                                                    Search</label>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-6">

                                                                                                <input type="radio"
                                                                                                       class="radiobtn"
                                                                                                       id="radio4"
                                                                                                       name="radio-category"
                                                                                                       value="history"/>

                                                                                                <label for="radio4">Search
                                                                                                    History</label>

                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="colpanel-b">

                                                                                            <div class="col-xs-12 col-sm-12 new">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Title:
                                                                                                        <small class="pullright">Title
                                                                                                            to
                                                                                                            Filter</small>
                                                                                                    </label>

                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           name="title_to_filter"
                                                                                                           value="<?=$filter_user_data['title_to_filter']?>">

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-sm-12 old"
                                                                                                 style="display: none;">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Filter
                                                                                                        Search:
                                                                                                        <small class="pullright">select
                                                                                                            filter</small></label>

                                                                                                    <select id="<?php echo $row['setting_id'] ?>filter_search"
                                                                                                            name="filter_search"
                                                                                                            type="text"
                                                                                                            class="chosen-select"
                                                                                                            tabindex="4">

                                                                                                        <option value="" <?=(($filter_user_data['filter_search'] == "") ? "selected" : "")?>>
                                                                                                            Search
                                                                                                            Filter
                                                                                                        </option>

                                                                                                        <?php

    for ($i = 0; $i < count($settings); $i++) {

        if (!empty($settings[$i]['title_to_filter'])) {

            $selected = ($settings[$i]['title_to_filter'] == $filter_user_data['title_to_filter']) ? "selected" : "";

            echo "<option value='" . $settings[$i]['_id'] . "' $selected>" . $settings[$i]['title_to_filter'] . "</option>";

        }

    }

    ?>

                                                                                                    </select>

                                                                                                </div>

                                                                                            </div>

                                                                                        </div>

                                                                                    </div>


                                                                                </div>

                                                                                <div class="col-xs-12 col-md-6">

                                                                                    <div class="colpanel">

                                                                                        <div class="colpanel-h">

                                                                                            <div class="col-xs-12 col-md-6">

                                                                                                <input type="radio"
                                                                                                       class="radiobtn1"
                                                                                                       id="<?php echo $row['setting_id'] ?>radio1"
                                                                                                       name="radio-category2"
                                                                                                       value="new_category"
                                                                                                       checked=""/>

                                                                                                <label for="radio1">New
                                                                                                    Category</label>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-6">

                                                                                                <input type="radio"
                                                                                                       class="radiobtn1"
                                                                                                       id="<?php echo $row['setting_id'] ?>radio2"
                                                                                                       name="radio-category2"
                                                                                                       value="history_category"/>

                                                                                                <label for="radio2">Search
                                                                                                    Category</label>

                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="colpanel-b">

                                                                                            <div class="col-xs-12 col-md-12">

                                                                                                <div class="Input_text_s new2">

                                                                                                    <label class="full-label">Category
                                                                                                        Title:
                                                                                                        <small class="pullright">Title
                                                                                                            to
                                                                                                            Category</small>
                                                                                                    </label>

                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           name="title_to_category"
                                                                                                           value="<?=$filter_user_data['title_to_category']?>">

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-12">

                                                                                                <div class="Input_text_s old2"
                                                                                                     style="display: none;">

                                                                                                    <label class="full-label">Filter
                                                                                                        Category:
                                                                                                        <small class="pullright">select
                                                                                                            filter</small></label>

                                                                                                    <select id="<?php echo $row['setting_id'] ?>filter_search"
                                                                                                            name="category_search"
                                                                                                            type="text"
                                                                                                            class="form-control">

                                                                                                        <option value="" <?=(($filter_user_data['filter_search'] == "") ? "selected" : "")?>>
                                                                                                            Search
                                                                                                            Filter
                                                                                                        </option>

                                                                                                        <?php

    $category_arr = array_column($settings, "title_to_category");

    $category_arr = array_unique($category_arr);

    for ($i = 0; $i < count($category_arr); $i++) {

        if (!empty($category_arr[$i])) {

            $selected = ($category_arr[$i] == $filter_user_data['title_to_category']) ? "selected" : "";

            echo "<option value='" . $category_arr[$i] . "' $selected>" . $category_arr[$i] . "</option>";

        }

    }

    ?>

                                                                                                    </select>
                                                                                                    <script type="text/javascript">
                                                                                                        $('.chosen-select').chosen({}).change(function (obj, result) {
                                                                                                            console.debug("changed: %o", arguments);

                                                                                                            console.log("selected: " + result.selected);
                                                                                                        });
                                                                                                    </script>
                                                                                                </div>

                                                                                            </div>

                                                                                        </div>

                                                                                    </div>


                                                                                </div>


                                                                            </div>


                                                                        </div>

                                                                        <div class="col-xs-12">

                                                                            <div class="row">

                                                                                <div class="col-xs-12">

                                                                                    <div class="colpanel"
                                                                                         style="padding-bottom:15px;">

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s coin_filter">

                                                                                                <label class="full-label">Filter
                                                                                                    Coin:
                                                                                                    <small class="pullright">select
                                                                                                        coin</small></label>

                                                                                                <select id="<?php echo $row['setting_id'] ?>filter_by_coin"
                                                                                                        name="filter_by_coin"
                                                                                                        type="text"
                                                                                                        class="form-control filter_by_name_margin_bottom_sm"
                                                                                                        required="required">

                                                                                                    <option value="" <?=(($filter_user_data['filter_by_coin'] == "") ? "selected" : "")?>>
                                                                                                        Search
                                                                                                        By
                                                                                                        Coin
                                                                                                        Symbol
                                                                                                    </option>

                                                                                                    <?php

    for ($i = 0; $i < count($coins); $i++) {

        $selected = ($coins[$i]['symbol'] == $filter_user_data['filter_by_coin']) ? "selected" : "";

        echo "<option value='" . $coins[$i]['symbol'] . "' $selected>" . $coins[$i]['symbol'] . "</option>";

    }

    ?>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Black
                                                                                                    Wall:
                                                                                                    <small class="pullright">black-pressure</small>
                                                                                                </label>

                                                                                                <select id="<?php echo $row['setting_id'] ?>black_wall_percentile"
                                                                                                        name="black_wall_percentile"
                                                                                                        type="text"
                                                                                                        class="form-control filter_by_name_margin_bottom_sm">

                                                                                                    <option value="">
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <?php

    foreach ($options as $key => $value) {

        ?>

                                                                                                        <option value="<?=$key?>" <?php if ($key == $filter_user_data['black_wall_percentile']) {
            echo "selected";
        }?> ><?=$value;?></option>

                                                                                                    <?php }

    ?>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Seven
                                                                                                    Level:
                                                                                                    <small class="pullright">delta
                                                                                                        pressure</small>
                                                                                                </label>

                                                                                                <select id="<?php echo $row['setting_id'] ?>sevenlevel_percentile"
                                                                                                        name="sevenlevel_percentile"
                                                                                                        type="text"
                                                                                                        class="form-control filter_by_name_margin_bottom_sm">

                                                                                                    <option value="">
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <?php

    foreach ($options as $key => $value) {

        ?>

                                                                                                        <option value="<?=$key?>" <?php if ($key == $filter_user_data['sevenlevel_percentile']) {
            echo "selected";
        }?> ><?=$value;?></option>

                                                                                                    <?php }

    ?>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Big
                                                                                                    Buyers:
                                                                                                    <small class="pullright">ask
                                                                                                        contracts</small>
                                                                                                </label>

                                                                                                <select id="<?php echo $row['setting_id'] ?>big_buyers_percentile"
                                                                                                        name="big_buyers_percentile"
                                                                                                        type="text"
                                                                                                        class="form-control filter_by_name_margin_bottom_sm">

                                                                                                    <option value="">
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <?php

    foreach ($options as $key => $value) {

        ?>

                                                                                                        <option value="<?=$key?>" <?php if ($key == $filter_user_data['big_buyers_percentile']) {
            echo "selected";
        }?> ><?=$value;?></option>

                                                                                                    <?php }

    ?>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Big
                                                                                                    Sellers:
                                                                                                    <small class="pullright">bid
                                                                                                        contracts</small>
                                                                                                </label>

                                                                                                <select id="<?php echo $row['setting_id'] ?>big_sellers_percentile"
                                                                                                        name="big_sellers_percentile"
                                                                                                        type="text"
                                                                                                        class="form-control filter_by_name_margin_bottom_sm">

                                                                                                    <option value="">
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <?php

    foreach ($options as $key => $value) {

        ?>

                                                                                                        <option value="<?=$key?>" <?php if ($key == $filter_user_data['big_sellers_percentile']) {
            echo "selected";
        }?> ><?=$value;?></option>

                                                                                                    <?php }

    ?>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">T1
                                                                                                    COT:
                                                                                                    <small class="pullright">5
                                                                                                        min
                                                                                                        buy/sell</small>
                                                                                                </label>

                                                                                                <select id="<?php echo $row['setting_id'] ?>five_buy_sell_percentile"
                                                                                                        name="five_buy_sell_percentile"
                                                                                                        type="text"
                                                                                                        class="form-control filter_by_name_margin_bottom_sm">

                                                                                                    <option value="">
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <?php

    foreach ($options as $key => $value) {

        ?>

                                                                                                        <option value="<?=$key?>" <?php if ($key == $filter_user_data['five_buy_sell_percentile']) {
            echo "selected";
        }?> ><?=$value;?></option>

                                                                                                    <?php }

    ?>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">T4
                                                                                                    COT:
                                                                                                    <small class="pullright">15
                                                                                                        min
                                                                                                        buy/sell</small>
                                                                                                </label>

                                                                                                <select id="<?php echo $row['setting_id'] ?>fifteen_buy_sell_percentile"
                                                                                                        name="fifteen_buy_sell_percentile"
                                                                                                        type="text"
                                                                                                        class="form-control filter_by_name_margin_bottom_sm">

                                                                                                    <option value="">
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <?php

    foreach ($options as $key => $value) {

        ?>

                                                                                                        <option value="<?=$key?>" <?php if ($key == $filter_user_data['fifteen_buy_sell_percentile']) {
            echo "selected";
        }?> ><?=$value;?></option>

                                                                                                    <?php }

    ?>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">T1
                                                                                                    LTC:
                                                                                                    <small class="pullright">last
                                                                                                        qty
                                                                                                        b/s</small>
                                                                                                </label>

                                                                                                <select id="<?php echo $row['setting_id'] ?>last_qty_buy_sell_percentile"
                                                                                                        name="last_qty_buy_sell_percentile"
                                                                                                        type="text"
                                                                                                        class="form-control filter_by_name_margin_bottom_sm">

                                                                                                    <option value="">
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <?php

    foreach ($options as $key => $value) {

        ?>

                                                                                                        <option value="<?=$key?>" <?php if ($key == $filter_user_data['last_qty_buy_sell_percentile']) {
            echo "selected";
        }?> ><?=$value;?></option>

                                                                                                    <?php }

    ?>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">T1
                                                                                                    LTC:
                                                                                                    <small class="pullright">(last
                                                                                                        qty
                                                                                                        time)</small>
                                                                                                </label>

                                                                                                <select id="<?php echo $row['setting_id'] ?>last_qty_time_percentile"
                                                                                                        name="last_qty_time_percentile"
                                                                                                        type="text"
                                                                                                        class="form-control filter_by_name_margin_bottom_sm">

                                                                                                    <option value="">
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <?php

    foreach ($options as $key => $value) {

        ?>

                                                                                                        <option value="<?=$key?>" <?php if ($key == $filter_user_data['last_qty_time_percentile']) {
            echo "selected";
        }?> ><?=$value;?></option>

                                                                                                    <?php }

    ?>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">T3
                                                                                                    LTC:
                                                                                                    <small class="pullright">(last
                                                                                                        qty
                                                                                                        time
                                                                                                        15m)</small>
                                                                                                </label>

                                                                                                <select id="<?php echo $row['setting_id'] ?>last_qty_time_fif_percentile"
                                                                                                        name="last_qty_time_fif_percentile"
                                                                                                        type="text"
                                                                                                        class="form-control filter_by_name_margin_bottom_sm">

                                                                                                    <option value="">
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <?php

    foreach ($options as $key => $value) {

        ?>

                                                                                                        <option value="<?=$key?>" <?php if ($key == $filter_user_data['last_qty_time_fif_percentile']) {
            echo "selected";
        }?> ><?=$value;?></option>

                                                                                                    <?php }

    ?>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Resistance
                                                                                                    Barrier:
                                                                                                    <small class="pullright">(ask)</small>
                                                                                                </label>

                                                                                                <select id="<?php echo $row['setting_id'] ?>virtual_barrier_percentile_ask"
                                                                                                        name="virtual_barrier_percentile_ask"
                                                                                                        type="text"
                                                                                                        class="form-control filter_by_name_margin_bottom_sm">

                                                                                                    <option value="">
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <?php

    foreach ($options as $key => $value) {

        ?>

                                                                                                        <option value="<?=$key?>" <?php if ($key == $filter_user_data['virtual_barrier_percentile_ask']) {
            echo "selected";
        }?> ><?=$value;?></option>

                                                                                                    <?php }

    ?>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">


                                                                                                <label class="full-label">Support
                                                                                                    Barrier:
                                                                                                    <small class="pullright">(bid)</small>
                                                                                                </label>

                                                                                                <select id="<?php echo $row['setting_id'] ?>virtual_barrier_percentile"
                                                                                                        name="virtual_barrier_percentile"
                                                                                                        type="text"
                                                                                                        class="form-control filter_by_name_margin_bottom_sm">

                                                                                                    <option value="">
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <?php

    foreach ($options as $key => $value) {

        ?>

                                                                                                        <option value="<?=$key?>" <?php if ($key == $filter_user_data['virtual_barrier_percentile']) {
            echo "selected";
        }?> ><?=$value;?></option>

                                                                                                    <?php }

    ?>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Binance
                                                                                                    Sell:
                                                                                                    <small class="pullright">(bid)</small>
                                                                                                </label>

                                                                                                <select id="<?php echo $row['setting_id'] ?>bid_percentile"
                                                                                                        name="bid_percentile"
                                                                                                        type="text"
                                                                                                        class="form-control filter_by_name_margin_bottom_sm">

                                                                                                    <option value="">
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <?php

    foreach ($options as $key => $value) {

        ?>

                                                                                                        <option value="<?=$key?>" <?php if ($key == $filter_user_data['bid_percentile']) {
            echo "selected";
        }?> ><?=$value;?></option>

                                                                                                    <?php }

    ?>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Binance
                                                                                                    Buy:
                                                                                                    <small class="pullright">(ask)</small>
                                                                                                </label>

                                                                                                <select id="<?php echo $row['setting_id'] ?>ask_percentile"
                                                                                                        name="ask_percentile"
                                                                                                        type="text"
                                                                                                        class="form-control filter_by_name_margin_bottom_sm">

                                                                                                    <option value="">
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <?php

    foreach ($options as $key => $value) {

        ?>

                                                                                                        <option value="<?=$key?>" <?php if ($key == $filter_user_data['ask_percentile']) {
            echo "selected";
        }?> ><?=$value;?></option>

                                                                                                    <?php }

    ?>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Move:
                                                                                                    <small>

                                                                                                        <label class="radio-inline"><input
                                                                                                                    type="radio"
                                                                                                                    value="g"
                                                                                                                    name="optradio_move">greater</label>

                                                                                                        <label class="radio-inline"><input
                                                                                                                    type="radio"
                                                                                                                    value="l"
                                                                                                                    name="optradio_move">less</label>

                                                                                                    </small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       name="move"
                                                                                                       id="<?php echo $row['setting_id'] ?>move"
                                                                                                       value="<?=$filter_user_data['move']?>">

                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2" style="">

                  <div class="Input_text_s">

                     <label class="full-label">Total Volume: </label>

                     <input type="text" class="form-control" name="total_volume" id="total_volume" value="<?=$filter_user_data['total_volume']?>">

                  </div>

               </div>

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Move:
                                                                                                    <small class="pullright">

                                                                                                        Move
                                                                                                        Color

                                                                                                    </small></label>

                                                                                                <br>

                                                                                                <select class="form-control"
                                                                                                        id="<?php echo $row['setting_id'] ?>move_color"
                                                                                                        name="move_color[]"
                                                                                                        multiple="true">

                                                                                                    <option value="yellow" <?=(in_array("yellow", $filter_user_data['move_color'])) ? "selected" : ""?>>
                                                                                                        Yellow
                                                                                                    </option>

                                                                                                    <option value="white" <?=(in_array("white", $filter_user_data['move_color'])) ? "selected" : ""?>>
                                                                                                        White
                                                                                                    </option>

                                                                                                    <option value="green" <?=(in_array("green", $filter_user_data['move_color'])) ? "selected" : ""?>>
                                                                                                        Green
                                                                                                    </option>

                                                                                                    <option value="blue" <?=(in_array("blue", $filter_user_data['move_color'])) ? "selected" : ""?>>
                                                                                                        Blue
                                                                                                    </option>

                                                                                                    <option value="red" <?=(in_array("red", $filter_user_data['move_color'])) ? "selected" : ""?>>
                                                                                                        Red
                                                                                                    </option>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Big
                                                                                                    Contractors:
                                                                                                    <small class="pullright">Big
                                                                                                        Contractor

                                                                                                    </small></label>

                                                                                                <select class="form-control"
                                                                                                        id="<?php echo $row['setting_id'] ?>big_contractors"
                                                                                                        name="big_contractors">

                                                                                                    <option value="" <?=$filter_user_data['big_contractors'] == '' ? "selected" : ""?>>
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <option value="1" <?=$filter_user_data['big_contractors'] == '1' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        1%
                                                                                                    </option>

                                                                                                    <option value="2" <?=$filter_user_data['big_contractors'] == '2' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        2%
                                                                                                    </option>

                                                                                                    <option value="3" <?=$filter_user_data['big_contractors'] == '3' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        3 %
                                                                                                    </option>

                                                                                                    <option value="4" <?=$filter_user_data['big_contractors'] == '4' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        4%
                                                                                                    </option>

                                                                                                    <option value="5" <?=$filter_user_data['big_contractors'] == '5' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        5%
                                                                                                    </option>

                                                                                                    <option value="10" <?=$filter_user_data['big_contractors'] == '10' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        10%
                                                                                                    </option>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Big
                                                                                                    Contractors
                                                                                                    Delta:
                                                                                                    <small class="pullright">Big
                                                                                                        Contractor

                                                                                                    </small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       name="big_contractors_val"
                                                                                                       id="<?php echo $row['setting_id'] ?>big_contractors_val"
                                                                                                       value="<?=$filter_user_data['big_contractors_val']?>">

                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Big
                                                                                                    Buyer:
                                                                                                    <small class="pullright">Big
                                                                                                        Buyer

                                                                                                    </small></label>

                                                                                                <select class="form-control"
                                                                                                        id="<?php echo $row['setting_id'] ?>big_buyers"
                                                                                                        name="big_buyers">

                                                                                                    <option value="" <?=$filter_user_data['big_buyers'] == '' ? "selected" : ""?>>
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <option value="1" <?=$filter_user_data['big_buyers'] == '1' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        1%
                                                                                                    </option>

                                                                                                    <option value="2" <?=$filter_user_data['big_buyers'] == '2' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        2%
                                                                                                    </option>

                                                                                                    <option value="3" <?=$filter_user_data['big_buyers'] == '3' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        3 %
                                                                                                    </option>

                                                                                                    <option value="4" <?=$filter_user_data['big_buyers'] == '4' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        4%
                                                                                                    </option>

                                                                                                    <option value="5" <?=$filter_user_data['big_buyers'] == '5' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        5%
                                                                                                    </option>

                                                                                                    <option value="10" <?=$filter_user_data['big_buyers'] == '10' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        10%
                                                                                                    </option>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Big
                                                                                                    Buyers
                                                                                                    Value:
                                                                                                    <small class="pullright">Big
                                                                                                        Buyers

                                                                                                    </small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       name="big_buyers_val"
                                                                                                       id="<?php echo $row['setting_id'] ?>big_buyers_val"
                                                                                                       value="<?=$filter_user_data['big_buyers_val']?>">

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Big
                                                                                                    Sellers:
                                                                                                    <small class="pullright">Big
                                                                                                        Sellers

                                                                                                    </small></label>

                                                                                                <select class="form-control"
                                                                                                        id="<?php echo $row['setting_id'] ?>big_sellers"
                                                                                                        name="big_sellers">

                                                                                                    <option value="" <?=$filter_user_data['big_sellers'] == '' ? "selected" : ""?>>
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <option value="1" <?=$filter_user_data['big_sellers'] == '1' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        1%
                                                                                                    </option>

                                                                                                    <option value="2" <?=$filter_user_data['big_sellers'] == '2' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        2%
                                                                                                    </option>

                                                                                                    <option value="3" <?=$filter_user_data['big_sellers'] == '3' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        3 %
                                                                                                    </option>

                                                                                                    <option value="4" <?=$filter_user_data['big_sellers'] == '4' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        4%
                                                                                                    </option>

                                                                                                    <option value="5" <?=$filter_user_data['big_sellers'] == '5' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        5%
                                                                                                    </option>

                                                                                                    <option value="10" <?=$filter_user_data['big_sellers'] == '10' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        10%
                                                                                                    </option>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Big
                                                                                                    Sellers
                                                                                                    Value:
                                                                                                    <small class="pullright">Big
                                                                                                        Sellers

                                                                                                    </small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       name="big_sellers_Val"
                                                                                                       id="<?php echo $row['setting_id'] ?>big_sellers_val"
                                                                                                       value="<?=$filter_user_data['big_sellers_Val']?>">

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Last
                                                                                                    Candle
                                                                                                    Buyers
                                                                                                    Percentile:
                                                                                                    <small class="pullright">Big
                                                                                                        Contractor

                                                                                                    </small></label>

                                                                                                <select class="form-control"
                                                                                                        id="<?php echo $row['setting_id'] ?>last_candle_percentile_buy"
                                                                                                        name="last_candle_percentile_buy">

                                                                                                    <option value="" <?=$filter_user_data['last_candle_percentile_buy'] == '' ? "selected" : ""?>>
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <option value="1" <?=$filter_user_data['last_candle_percentile_buy'] == '1' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        1%
                                                                                                    </option>

                                                                                                    <option value="2" <?=$filter_user_data['last_candle_percentile_buy'] == '2' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        2%
                                                                                                    </option>

                                                                                                    <option value="3" <?=$filter_user_data['last_candle_percentile_buy'] == '3' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        3 %
                                                                                                    </option>

                                                                                                    <option value="4" <?=$filter_user_data['last_candle_percentile_buy'] == '4' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        4%
                                                                                                    </option>

                                                                                                    <option value="5" <?=$filter_user_data['last_candle_percentile_buy'] == '5' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        5%
                                                                                                    </option>

                                                                                                    <option value="10" <?=$filter_user_data['last_candle_percentile_buy'] == '10' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        10%
                                                                                                    </option>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Last
                                                                                                    Candle
                                                                                                    Sellers
                                                                                                    Percentile:
                                                                                                    <small class="pullright">Big
                                                                                                        Contractor

                                                                                                    </small></label>

                                                                                                <select class="form-control"
                                                                                                        id="<?php echo $row['setting_id'] ?>last_candle_percentile_sell"
                                                                                                        name="last_candle_percentile_sell">

                                                                                                    <option value="" <?=$filter_user_data['last_candle_percentile_sell'] == '' ? "selected" : ""?>>
                                                                                                        Select
                                                                                                    </option>

                                                                                                    <option value="1" <?=$filter_user_data['last_candle_percentile_sell'] == '1' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        1%
                                                                                                    </option>

                                                                                                    <option value="2" <?=$filter_user_data['last_candle_percentile_sell'] == '2' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        2%
                                                                                                    </option>

                                                                                                    <option value="3" <?=$filter_user_data['last_candle_percentile_sell'] == '3' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        3 %
                                                                                                    </option>

                                                                                                    <option value="4" <?=$filter_user_data['last_candle_percentile_sell'] == '4' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        4%
                                                                                                    </option>

                                                                                                    <option value="5" <?=$filter_user_data['last_candle_percentile_sell'] == '5' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        5%
                                                                                                    </option>

                                                                                                    <option value="10" <?=$filter_user_data['last_candle_percentile_sell'] == '10' ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        10%
                                                                                                    </option>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Candle
                                                                                                    Status: </label>

                                                                                                <br>

                                                                                                <select class="form-control"
                                                                                                        id="<?php echo $row['setting_id'] ?>candle_status"
                                                                                                        name="candle_status[]"
                                                                                                        multiple="true">


                                                                                                    <option value="Continuation_up" <?=(in_array("Continuation_up", $filter_user_data['candle_status'])) ? "selected" : ""?>>
                                                                                                        Continuation
                                                                                                        up
                                                                                                    </option>

                                                                                                    <option value="Current_up" <?=(in_array("Current_up", $filter_user_data['candle_status'])) ? "selected" : ""?>>
                                                                                                        Current
                                                                                                        up
                                                                                                    </option>

                                                                                                    <option value="Continuation_Down" <?=(in_array("Continuation_Down", $filter_user_data['candle_status'])) ? "selected" : ""?>>
                                                                                                        Continuation
                                                                                                        Down
                                                                                                    </option>

                                                                                                    <option value="Current_Down" <?=(in_array("Current_Down", $filter_user_data['candle_status'])) ? "selected" : ""?>>
                                                                                                        Current
                                                                                                        Down
                                                                                                    </option>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Global
                                                                                                    Candle
                                                                                                    Swing
                                                                                                    Status: </label>

                                                                                                <select class="form-control"
                                                                                                        id="<?php echo $row['setting_id'] ?>swing_status"
                                                                                                        name="swing_status[]"
                                                                                                        multiple="true">

                                                                                                    <option value="HH" <?=(in_array("HH", $filter_user_data['swing_status'])) ? "selected" : ""?>>
                                                                                                        HH
                                                                                                    </option>

                                                                                                    <option value="HL" <?=(in_array("HL", $filter_user_data['swing_status'])) ? "selected" : ""?>>
                                                                                                        HL
                                                                                                    </option>

                                                                                                    <option value="LH" <?=(in_array("LH", $filter_user_data['swing_status'])) ? "selected" : ""?>>
                                                                                                        LH
                                                                                                    </option>

                                                                                                    <option value="LL" <?=(in_array("LL", $filter_user_data['swing_status'])) ? "selected" : ""?>>
                                                                                                        LL
                                                                                                    </option>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Candle
                                                                                                    Type: </label>

                                                                                                <select class="form-control"
                                                                                                        id="<?php echo $row['setting_id'] ?>candle_type"
                                                                                                        name="candle_type[]"
                                                                                                        multiple="true">

                                                                                                    <option value="demand" <?=(in_array("demand", $filter_user_data['candle_type'])) ? "selected" : ""?>>
                                                                                                        Demand
                                                                                                    </option>

                                                                                                    <option value="supply" <?=(in_array("supply", $filter_user_data['candle_type'])) ? "selected" : ""?>>
                                                                                                        Supply
                                                                                                    </option>

                                                                                                    <option value="normal" <?=(in_array("normal", $filter_user_data['candle_type'])) ? "selected" : ""?>>
                                                                                                        Normal
                                                                                                    </option>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Rejection
                                                                                                    Type: </label>

                                                                                                <select class="form-control"
                                                                                                        id="<?php echo $row['setting_id'] ?>rejection"
                                                                                                        name="rejection[]"
                                                                                                        multiple="true">

                                                                                                    <option value="top_demand_rejection" <?=(in_array("top_demand_rejection", $filter_user_data['rejection'])) ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        Demand
                                                                                                        Rejection
                                                                                                    </option>

                                                                                                    <option value="bottom_demand_rejection" <?=(in_array("bottom_demand_rejection", $filter_user_data['rejection'])) ? "selected" : ""?>>
                                                                                                        Bottom
                                                                                                        Demand
                                                                                                        Rejection
                                                                                                    </option>

                                                                                                    <option value="top_supply_rejection" <?=(in_array("top_supply_rejection", $filter_user_data['rejection'])) ? "selected" : ""?>>
                                                                                                        Top
                                                                                                        Supply
                                                                                                        Rejection
                                                                                                    </option>

                                                                                                    <option value="bottom_supply_rejection" <?=(in_array("bottom_supply_rejection", $filter_user_data['rejection'])) ? "selected" : ""?>>
                                                                                                        Bottom
                                                                                                        Supply
                                                                                                        Rejection
                                                                                                    </option>

                                                                                                </select>

                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Total
                                                                                                    Volume: </label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       name="total_volume"
                                                                                                       id="<?php echo $row['setting_id'] ?>total_volume"
                                                                                                       value="<?=$filter_user_data['total_volume']?>">

                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Caption
                                                                                                    Option:<small
                                                                                                            class="pullright">option</small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       name="caption_option"
                                                                                                       id="<?php echo $row['setting_id'] ?>caption_option"
                                                                                                       value="<?=$filter_user_data['caption_option']?>">

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Caption
                                                                                                    Score:<small
                                                                                                            class="pullright">score</small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       name="caption_score"
                                                                                                       id="<?php echo $row['setting_id'] ?>caption_score"
                                                                                                       value="<?=$filter_user_data['caption_score']?>">

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Buy:<small
                                                                                                            class="pullright">buy</small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       name="buy"
                                                                                                       id="<?php echo $row['setting_id'] ?>buy"
                                                                                                       value="<?=$filter_user_data['buy']?>">

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Sell:<small
                                                                                                            class="pullright">sell</small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       id="<?php echo $row['setting_id'] ?>sell"
                                                                                                       name="sell"
                                                                                                       value="<?=$filter_user_data['sell']?>">

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Demand:<small
                                                                                                            class="pullright">demand</small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       id="<?php echo $row['setting_id'] ?>demand"
                                                                                                       name="demand"
                                                                                                       value="<?=$filter_user_data['demand']?>">

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Supply:<small
                                                                                                            class="pullright">supply</small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       id="supply"
                                                                                                       name="supply"
                                                                                                       value="<?=$filter_user_data['supply']?>">

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Market
                                                                                                    Trend:<small
                                                                                                            class="pullright">market_trend</small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       id="market_trend"
                                                                                                       name="market_trend"
                                                                                                       value="<?=$filter_user_data['market_trend']?>">

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Meta
                                                                                                    Trending:<small
                                                                                                            class="pullright">meta_trending</small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       id="<?php echo $row['setting_id'] ?>meta_trending"
                                                                                                       name="meta_trending"
                                                                                                       value="<?=$filter_user_data['meta_trending']?>">

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Risk
                                                                                                    Per
                                                                                                    Share:<small
                                                                                                            class="pullright">risk_per_share</small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       id="<?php echo $row['setting_id'] ?>risk_per_share"
                                                                                                       name="risk_per_share"
                                                                                                       value="<?=$filter_user_data['risk_per_share']?>">

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">RL:<small
                                                                                                            class="pullright">RL</small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       id="<?php echo $row['setting_id'] ?>rl"
                                                                                                       name="rl"
                                                                                                       value="<?=$filter_user_data['rl']?>">

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Target
                                                                                                    Profit:<small
                                                                                                            class="pullright">profit</small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       id="<?php echo $row['setting_id'] ?>target_profit"
                                                                                                       name="target_profit"
                                                                                                       value="<?=$filter_user_data['target_profit']?>"
                                                                                                       required="required">

                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Target
                                                                                                    StopLoss:<small
                                                                                                            class="pullright">loss</small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       id="<?php echo $row['setting_id'] ?>target_stoploss"
                                                                                                       name="target_stoploss"
                                                                                                       value="<?=$filter_user_data['target_stoploss']?>"
                                                                                                       required="required">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-2" style="">

                  <div class="Input_text_s">

                     <label class="full-label">Target StopLoss 2:<small class="pullright">loss second</small></label>

                     <input type="text" class="form-control" id="target_stoploss_two" name="target_stoploss_two" value="<?=$filter_user_data['target_stoploss_two']?>" required="required">

                  </div>

               </div>

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">Lookup
                                                                                                    Period:
                                                                                                    <small class="pullright">duration
                                                                                                        to
                                                                                                        check</small></label>

                                                                                                <input type="text"
                                                                                                       class="form-control"
                                                                                                       id="lookup_period"
                                                                                                       name="lookup_period"
                                                                                                       value="<?=$filter_user_data['lookup_period']?>"
                                                                                                       required="required">

                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">From
                                                                                                    Date
                                                                                                    Range:
                                                                                                    <br></label>

                                                                                                <input id="<?php echo $row['setting_id'] ?>filter_by_start_date"
                                                                                                       name="filter_by_start_date"
                                                                                                       type="text"
                                                                                                       class="form-control datetime_picker filter_by_name_margin_bottom_sm"
                                                                                                       placeholder="Search By Date"
                                                                                                       value="<?=(!empty($filter_user_data['filter_by_start_date']) ? $filter_user_data['filter_by_start_date'] : "")?>"
                                                                                                       autocomplete="off">

                                                                                                <i class="glyphicon glyphicon-calendar"
                                                                                                   required="required"></i>

                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="col-xs-12 col-sm-12 col-md-2"
                                                                                             style="">

                                                                                            <div class="Input_text_s">

                                                                                                <label class="full-label">To
                                                                                                    Date
                                                                                                    Range:
                                                                                                    <br></label>

                                                                                                <input id="<?php echo $row['setting_id'] ?>filter_by_end_date"
                                                                                                       name="filter_by_end_date"
                                                                                                       type="text"
                                                                                                       class="form-control datetime_picker filter_by_name_margin_bottom_sm"
                                                                                                       placeholder="Search By Date"
                                                                                                       value="<?=(!empty($filter_user_data['filter_by_end_date']) ? $filter_user_data['filter_by_end_date'] : "")?>"
                                                                                                       autocomplete="off"
                                                                                                       required="required">

                                                                                                <i class="glyphicon glyphicon-calendar"></i>

                                                                                            </div>

                                                                                        </div>


                                                                                    </div>

                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                        <div class="col-xs-12">
                                                                            <div class="colpanel">

                                                                                <div class="colpanel-h"
                                                                                     style="border-bottom:none; margin-bottom:0;">

                                                                                    <input type="checkbox"
                                                                                           class="form-check-input"
                                                                                           id="<?php echo $row['setting_id'] ?>wick_check"
                                                                                           name="wick_check"
                                                                                           value="yes" <?=$filter_user_data['wick_check'] == 'yes' ? "checked" : ""?>>

                                                                                    <label class="form-check-label"
                                                                                           for="wick_check">Wick
                                                                                        Percentiles</label>

                                                                                    <label class="pullright">Check
                                                                                        wick percentiles and
                                                                                        quantity </label>

                                                                                </div>

                                                                                <div class="colpanel-b candle_w"
                                                                                     style="border-bottom: 1px solid rgb(238, 238, 238); margin-top: 15px;">

                                                                                    <div class="col-xs-12 col-md-3">

                                                                                        <div class="Input_text_s">

                                                                                            <label class="full-label">Wick
                                                                                                Percentile:
                                                                                                <!-- <small class="pullright">duration in hours</small> --></label>

                                                                                            <select class="form-control"
                                                                                                    id="<?php echo $row['setting_id'] ?>wick_percentile"
                                                                                                    name="wick_percentile">

                                                                                                <option value="" <?=$filter_user_data['wick_percentile'] == '' ? "selected" : ""?>>
                                                                                                    Select
                                                                                                </option>

                                                                                                <option value="1" <?=$filter_user_data['wick_percentile'] == '1' ? "selected" : ""?>>
                                                                                                    Top 1%
                                                                                                </option>

                                                                                                <option value="2" <?=$filter_user_data['wick_percentile'] == '2' ? "selected" : ""?>>
                                                                                                    Top 2%
                                                                                                </option>

                                                                                                <option value="3" <?=$filter_user_data['wick_percentile'] == '3' ? "selected" : ""?>>
                                                                                                    Top 3 %
                                                                                                </option>

                                                                                                <option value="4" <?=$filter_user_data['wick_percentile'] == '4' ? "selected" : ""?>>
                                                                                                    Top 4%
                                                                                                </option>

                                                                                                <option value="5" <?=$filter_user_data['wick_percentile'] == '5' ? "selected" : ""?>>
                                                                                                    Top 5%
                                                                                                </option>

                                                                                                <option value="10" <?=$filter_user_data['wick_percentile'] == '10' ? "selected" : ""?>>
                                                                                                    Top 10%
                                                                                                </option>

                                                                                            </select>

                                                                                        </div>

                                                                                    </div>


                                                                                    <div class="col-xs-12 col-md-3">

                                                                                        <div class="Input_text_s">

                                                                                            <label class="full-label">Wick
                                                                                                Quantity:
                                                                                                <!-- <small>percentage</small> --></label>

                                                                                            <input type="text"
                                                                                                   class="form-control"
                                                                                                   id="<?php echo $row['setting_id'] ?>wick_qty"
                                                                                                   name="wick_qty"
                                                                                                   value="<?=$filter_user_data['wick_qty'] != '' ? $filter_user_data['wick_qty'] : ""?>">

                                                                                        </div>

                                                                                    </div>


                                                                                    <div class="col-xs-12 col-md-3">

                                                                                        <div class="Input_text_s">

                                                                                            <label class="full-label">Total
                                                                                                Volume
                                                                                                Percentile:
                                                                                                <!-- <small class="pullright">formula</small> --></label>

                                                                                            <select class="form-control"
                                                                                                    id="<?php echo $row['setting_id'] ?>total_volume"
                                                                                                    name="total_vol_percentile">

                                                                                                <option value="" <?=$filter_user_data['total_vol_percentile'] == '' ? "selected" : ""?>>
                                                                                                    Select
                                                                                                </option>

                                                                                                <option value="1" <?=$filter_user_data['total_vol_percentile'] == '1' ? "selected" : ""?>>
                                                                                                    Top 1%
                                                                                                </option>

                                                                                                <option value="2" <?=$filter_user_data['total_vol_percentile'] == '2' ? "selected" : ""?>>
                                                                                                    Top 2%
                                                                                                </option>

                                                                                                <option value="3" <?=$filter_user_data['total_vol_percentile'] == '3' ? "selected" : ""?>>
                                                                                                    Top 3 %
                                                                                                </option>

                                                                                                <option value="4" <?=$filter_user_data['total_vol_percentile'] == '4' ? "selected" : ""?>>
                                                                                                    Top 4%
                                                                                                </option>

                                                                                                <option value="5" <?=$filter_user_data['total_vol_percentile'] == '5' ? "selected" : ""?>>
                                                                                                    Top 5%
                                                                                                </option>

                                                                                                <option value="10" <?=$filter_user_data['total_vol_percentile'] == '10' ? "selected" : ""?>>
                                                                                                    Top 10%
                                                                                                </option>

                                                                                                <option value="15" <?=$filter_user_data['total_vol_percentile'] == '15' ? "selected" : ""?>>
                                                                                                    Top 15%
                                                                                                </option>

                                                                                                <option value="20" <?=$filter_user_data['total_vol_percentile'] == '20' ? "selected" : ""?>>
                                                                                                    Top 20%
                                                                                                </option>

                                                                                                <option value="25" <?=$filter_user_data['total_vol_percentile'] == '25' ? "selected" : ""?>>
                                                                                                    Top 25%
                                                                                                </option>

                                                                                                <option value="50" <?=$filter_user_data['total_vol_percentile'] == '50' ? "selected" : ""?>>
                                                                                                    Top 50%
                                                                                                </option>

                                                                                                <option value="75" <?=$filter_user_data['total_vol_percentile'] == '75' ? "selected" : ""?>>
                                                                                                    Top 75%
                                                                                                </option>

                                                                                                <option value="100" <?=$filter_user_data['total_vol_percentile'] == '100' ? "selected" : ""?>>
                                                                                                    Top 100%
                                                                                                </option>

                                                                                            </select>

                                                                                        </div>

                                                                                    </div>

                                                                                    <div class="col-xs-12 col-md-3">

                                                                                        <div class="Input_text_s">

                                                                                            <label class="full-label">Current
                                                                                                Hour
                                                                                                Percentile:
                                                                                                <!--  <small class="pullright">candle side</small> --></label>

                                                                                            <select class="form-control"
                                                                                                    id="<?php echo $row['setting_id'] ?>curr_hr_percentile"
                                                                                                    name="curr_hr_percentile">
                                                                                                <option value="" <?=$filter_user_data['curr_hr_percentile'] == '' ? "selected" : ""?>>
                                                                                                    Select
                                                                                                </option>

                                                                                                <option value="1" <?=$filter_user_data['curr_hr_percentile'] == '1' ? "selected" : ""?>>
                                                                                                    Top 1%
                                                                                                </option>

                                                                                                <option value="2" <?=$filter_user_data['curr_hr_percentile'] == '2' ? "selected" : ""?>>
                                                                                                    Top 2%
                                                                                                </option>

                                                                                                <option value="3" <?=$filter_user_data['curr_hr_percentile'] == '3' ? "selected" : ""?>>
                                                                                                    Top 3 %
                                                                                                </option>

                                                                                                <option value="4" <?=$filter_user_data['curr_hr_percentile'] == '4' ? "selected" : ""?>>
                                                                                                    Top 4%
                                                                                                </option>

                                                                                                <option value="5" <?=$filter_user_data['curr_hr_percentile'] == '5' ? "selected" : ""?>>
                                                                                                    Top 5%
                                                                                                </option>

                                                                                                <option value="10" <?=$filter_user_data['curr_hr_percentile'] == '10' ? "selected" : ""?>>
                                                                                                    Top 10%
                                                                                                </option>
                                                                                            </select>

                                                                                        </div>

                                                                                    </div>

                                                                                    <div class="col-xs-12 col-md-3">

                                                                                        <div class="Input_text_s">

                                                                                            <label class="full-label">Current
                                                                                                Hour
                                                                                                Percentile:
                                                                                                <!--  <small class="pullright">candle side</small> --></label>

                                                                                            <select class="form-control"
                                                                                                    id="<?php echo $row['setting_id'] ?>curr_hr_val"
                                                                                                    name="curr_hr_val">
                                                                                                <option value="close" <?=$filter_user_data['curr_hr_val'] == 'close' ? "selected" : ""?>>
                                                                                                    Close
                                                                                                </option>

                                                                                                <option value="high" <?=$filter_user_data['curr_hr_val'] == 'high' ? "selected" : ""?>>
                                                                                                    High
                                                                                                </option>

                                                                                                <option value="open" <?=$filter_user_data['curr_hr_val'] == 'open' ? "selected" : ""?>>
                                                                                                    Open
                                                                                                </option>

                                                                                                <option value="low" <?=$filter_user_data['curr_hr_val'] == 'low' ? "selected" : ""?>>
                                                                                                    Low
                                                                                                </option>
                                                                                            </select>

                                                                                        </div>

                                                                                    </div>


                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xs-12">

                                                                            <div class="colpanel">

                                                                                <div class="colpanel-h"
                                                                                     style="border-bottom:none; margin-bottom:0;">

                                                                                    <div class="col-xs-12 col-md-3">

                                                                                        <div class="Input_text_s">

                                                                                            <label class="full-label">Check
                                                                                                Top X
                                                                                                Contracts:
                                                                                                <!--  <small class="pullright">candle side</small> --></label>

                                                                                            <input type="checkbox"
                                                                                                   class="form-check-input"
                                                                                                   id="<?php echo $row['setting_id'] ?>top3_contracts"
                                                                                                   name="top3_contracts"
                                                                                                   value="yes" <?=$filter_user_data['top3_contracts'] == 'yes' ? "checked" : ""?>>


                                                                                        </div>

                                                                                    </div>

                                                                                    <div class="col-xs-12 col-md-3">

                                                                                        <div class="Input_text_s">

                                                                                            <label class="full-label">No.
                                                                                                Of
                                                                                                Contracts:
                                                                                                <!--  <small class="pullright">Check Wick Side</small> --></label>

                                                                                            <input type="number"
                                                                                                   class="form-control"
                                                                                                   placeholder="no of contractss"
                                                                                                   id="<?php echo $row['setting_id'] ?>no_of_contracts"
                                                                                                   name="no_of_contracts"
                                                                                                   value="<?=$filter_user_data['no_of_contracts']?>">

                                                                                        </div>

                                                                                    </div>

                                                                                    <div class="col-xs-12 col-md-3">

                                                                                        <div class="Input_text_s">

                                                                                            <label class="full-label">Check
                                                                                                Contract
                                                                                                Below:
                                                                                                <!--  <small class="pullright">Check Wick Side</small> --></label>

                                                                                            <select class="form-control"
                                                                                                    id="<?php echo $row['setting_id'] ?>check_wick_below"
                                                                                                    name="check_wick_below">

                                                                                                <option value="" <?=$filter_user_data['check_wick_below'] == '' ? "selected" : ""?>>
                                                                                                    Select
                                                                                                </option>

                                                                                                <option value="lower_wick" <?=$filter_user_data['check_wick_below'] == 'lower_wick' ? "selected" : ""?>>
                                                                                                    Lower
                                                                                                    Wick
                                                                                                </option>

                                                                                                <option value="body" <?=$filter_user_data['check_wick_below'] == 'body' ? "selected" : ""?>>
                                                                                                    Lower
                                                                                                    Wick and
                                                                                                    Body
                                                                                                </option>

                                                                                                <option value="upper_wick" <?=$filter_user_data['check_wick_below'] == 'upper_wick' ? "selected" : ""?>>
                                                                                                    Upper
                                                                                                    Wick
                                                                                                </option>

                                                                                            </select>

                                                                                        </div>

                                                                                    </div>


                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xs-12">

                                                                            <div class="row">

                                                                                <div class="col-xs-12">

                                                                                    <div class="colpanel">

                                                                                        <div class="colpanel-h"
                                                                                             style="border-bottom:none; margin-bottom:0;">

                                                                                            <input type="checkbox"
                                                                                                   class="form-check-input"
                                                                                                   id="<?php echo $row['setting_id'] ?>candle_chk"
                                                                                                   name="candle_chk"
                                                                                                   value="yes" <?php if ($filter_user_data['candle_chk'] == 'yes') {
        echo "checked";
    }?>>

                                                                                            <label class="form-check-label"
                                                                                                   for="candle_chk">check
                                                                                                for big
                                                                                                candle</label>

                                                                                            <label class="pullright">Check
                                                                                                Last 24h
                                                                                                Candle: </label>

                                                                                        </div>

                                                                                        <div class="colpanel-b candle"
                                                                                             style="border-bottom:1px solid #eee; margin-top:15px; <?php if ($filter_user_data['candle_chk'] == 'yes') {
        echo "display:block";
    } else {
        echo "display:none";
    }?>">

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Deep
                                                                                                        Candle
                                                                                                        Range:
                                                                                                        <!-- <small>percentage</small> --></label>

                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="<?php echo $row['setting_id'] ?>candle_range"
                                                                                                           name="candle_range"
                                                                                                           value="<?=$filter_user_data['candle_range']?>">

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Candle
                                                                                                        Side:
                                                                                                        <!-- <small class="pullright">duration in hours</small> --></label>

                                                                                                    <select class="form-control"
                                                                                                            id="<?php echo $row['setting_id'] ?>candle_side"
                                                                                                            name="candle_side">
                                                                                                        <option value="" <?=$filter_user_data['candle_side'] == '' ? "selected" : ""?>>
                                                                                                            Select
                                                                                                        </option>
                                                                                                        <option value="up" <?=$filter_user_data['candle_side'] == 'up' ? "selected" : ""?>>
                                                                                                            Upside
                                                                                                        </option>

                                                                                                        <option value="down" <?=$filter_user_data['candle_side'] == 'down' ? "selected" : ""?>>
                                                                                                            Downside
                                                                                                        </option>

                                                                                                    </select>

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Formula:
                                                                                                        <!-- <small class="pullright">formula</small> --></label>

                                                                                                    <select class="form-control"
                                                                                                            id="<?php echo $row['setting_id'] ?>formula"
                                                                                                            name="formula">
                                                                                                        <option value="" <?=$filter_user_data['formula'] == '' ? "selected" : ""?>>
                                                                                                            Select
                                                                                                        </option>
                                                                                                        <option value="highlow" <?=$filter_user_data['formula'] == 'highlow' ? "selected" : ""?>>
                                                                                                            High
                                                                                                            to
                                                                                                            Low
                                                                                                        </option>

                                                                                                        <option value="openclose" <?=$filter_user_data['formula'] == 'openclose' ? "selected" : ""?>>
                                                                                                            Open
                                                                                                            to
                                                                                                            Close
                                                                                                        </option>

                                                                                                    </select>

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Candle
                                                                                                        Red/Blue:
                                                                                                        <!--  <small class="pullright">candle side</small> --></label>

                                                                                                    <select class="form-control"
                                                                                                            id="<?php echo $row['setting_id'] ?>side"
                                                                                                            name="side">
                                                                                                        <option value="" <?=$filter_user_data['side'] == '' ? "selected" : ""?>>
                                                                                                            Select
                                                                                                        </option>
                                                                                                        <option value="none" <?=$filter_user_data['side'] == 'none' ? "selected" : ""?>>
                                                                                                            None
                                                                                                        </option>

                                                                                                        <option value="above" <?=$filter_user_data['side'] == 'above' ? "selected" : ""?>>
                                                                                                            Above
                                                                                                        </option>

                                                                                                        <option value="below" <?=$filter_user_data['side'] == 'below' ? "selected" : ""?>>
                                                                                                            Below
                                                                                                        </option>

                                                                                                    </select>

                                                                                                </div>

                                                                                            </div>

                                                                                        </div>

                                                                                    </div>

                                                                                </div>

                                                                                <div class="col-xs-12">

                                                                                    <div class="colpanel">

                                                                                        <div class="colpanel-h"
                                                                                             style="border-bottom:none; margin-bottom:0;">

                                                                                            <input type="checkbox"
                                                                                                   class="form-check-input"
                                                                                                   id="<?php echo $row['setting_id'] ?>candle_chk_h"
                                                                                                   name="candle_chk_h"
                                                                                                   value="yes" <?php if ($filter_user_data['candle_chk_h'] == 'yes') {
        echo "checked";
    }?>>

                                                                                            <label class="form-check-label"
                                                                                                   for="candle_chk_h">check
                                                                                                for hourly
                                                                                                candle</label>

                                                                                            <label class="pullright">Check
                                                                                                Last hourly
                                                                                                Candle:
                                                                                                <!-- <small class="pullright">check for hourly candle</small> --></label>

                                                                                        </div>

                                                                                        <div class="colpanel-b candle_h"
                                                                                             style="border-bottom:1px solid #eee; margin-top:15px; <?php if ($filter_user_data['candle_chk_h'] == 'yes') {
        echo "display:block";
    } else {
        echo "display:none";
    }?>">

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Deep
                                                                                                        Candle
                                                                                                        Range:
                                                                                                        <!-- <small class="pullright">percentage</small> --></label>

                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="<?php echo $row['setting_id'] ?>candle_range_h"
                                                                                                           name="candle_range_h"
                                                                                                           value="<?=$filter_user_data['candle_range_h']?>">

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Candle
                                                                                                        Side:
                                                                                                        <!-- <small class="pullright">duration in hours</small> --></label>

                                                                                                    <select class="form-control"
                                                                                                            id="<?php echo $row['setting_id'] ?>candle_side_h"
                                                                                                            name="candle_side_h">
                                                                                                        <option value="" <?=$filter_user_data['candle_side_h'] == '' ? "selected" : ""?>>
                                                                                                            Select
                                                                                                        </option>

                                                                                                        <option value="up" <?=$filter_user_data['candle_side_h'] == 'up' ? "selected" : ""?>>
                                                                                                            Upside
                                                                                                        </option>

                                                                                                        <option value="down" <?=$filter_user_data['candle_side_h'] == 'down' ? "selected" : ""?>>
                                                                                                            Downside
                                                                                                        </option>

                                                                                                    </select>

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Formula:
                                                                                                        <!-- <small class="pullright">formula</small> --></label>

                                                                                                    <select class="form-control"
                                                                                                            id="<?php echo $row['setting_id'] ?>formula_h"
                                                                                                            name="formula_h">
                                                                                                        <option value="" <?=$filter_user_data['formula_h'] == '' ? "selected" : ""?>>
                                                                                                            Select
                                                                                                        </option>
                                                                                                        <option value="highlow" <?=$filter_user_data['formula_h'] == 'highlow' ? "selected" : ""?>>
                                                                                                            High
                                                                                                            to
                                                                                                            Low
                                                                                                        </option>

                                                                                                        <option value="openclose" <?=$filter_user_data['formula_h'] == 'openclose' ? "selected" : ""?>>
                                                                                                            Open
                                                                                                            to
                                                                                                            Close
                                                                                                        </option>

                                                                                                    </select>

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Candle
                                                                                                        Red/Blue:
                                                                                                        <!-- <small class="pullright">candle side</small> --></label>

                                                                                                    <select class="form-control"
                                                                                                            id="<?php echo $row['setting_id'] ?>side_h"
                                                                                                            name="side_h">
                                                                                                        <option value="" <?=$filter_user_data['side_h'] == '' ? "selected" : ""?>>
                                                                                                            Select
                                                                                                        </option>
                                                                                                        <option value="none" <?=$filter_user_data['side_h'] == 'none' ? "selected" : ""?>>
                                                                                                            None
                                                                                                        </option>

                                                                                                        <option value="above" <?=$filter_user_data['side_h'] == 'above' ? "selected" : ""?>>
                                                                                                            Above
                                                                                                        </option>

                                                                                                        <option value="below" <?=$filter_user_data['side_h'] == 'below' ? "selected" : ""?>>
                                                                                                            Below
                                                                                                        </option>

                                                                                                    </select>

                                                                                                </div>

                                                                                            </div>

                                                                                        </div>

                                                                                    </div>

                                                                                </div>

                                                                                <div class="col-xs-12">

                                                                                    <div class="colpanel">

                                                                                        <div class="colpanel-h"
                                                                                             style="border-bottom:none; margin-bottom:0;">

                                                                                            <input type="checkbox"
                                                                                                   class="form-check-input"
                                                                                                   id="<?php echo $row['setting_id'] ?>opp_chk"
                                                                                                   name="opp_chk"
                                                                                                   value="yes" <?php if ($filter_user_data['opp_chk'] == 'yes') {
        echo "checked";
    }?>>

                                                                                            <label class="form-check-label"
                                                                                                   for="opp_chk">Check
                                                                                                Deep
                                                                                                Barrier</label>

                                                                                            <label class="pullright">Deep
                                                                                                Barrier
                                                                                                Check:
                                                                                                <!-- <small class="pullright">check for deep barrier</small> --></label>

                                                                                        </div>

                                                                                        <div class="colpanel-b deeply"
                                                                                             style="border-bottom:1px solid #eee; margin-top:15px; <?php if ($filter_user_data['opp_chk'] == 'yes') {
        echo "display:block";
    } else {
        echo "display:none";
    }?>">

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Deep
                                                                                                        Barrier
                                                                                                        Range:
                                                                                                        <!-- <small class="pullright">range of deep check</small> --></label>

                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="<?php echo $row['setting_id'] ?>deep_price_check"
                                                                                                           name="deep_price_check"
                                                                                                           value="<?=$filter_user_data['deep_price_check']?>">

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Deep
                                                                                                        Barrier
                                                                                                        Lookup:
                                                                                                        <!-- <small class="pullright">duration in hours</small> --></label>

                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="<?php echo $row['setting_id'] ?>deep_price_lookup_in_hours"
                                                                                                           name="deep_price_lookup_in_hours"
                                                                                                           value="<?=$filter_user_data['deep_price_lookup_in_hours']?>">

                                                                                                </div>

                                                                                            </div>

                                                                                        </div>

                                                                                    </div>

                                                                                </div>

                                                                                <div class="col-xs-12">

                                                                                    <div class="colpanel">

                                                                                        <div class="colpanel-h"
                                                                                             style="border-bottom:none; margin-bottom:0;">

                                                                                            <input type="checkbox"
                                                                                                   class="form-check-input"
                                                                                                   id="<?php echo $row['setting_id'] ?>barrier_check"
                                                                                                   name="barrier_check"
                                                                                                   value="yes" <?php if ($filter_user_data['barrier_check'] == 'yes') {
        echo "checked";
    }?>>

                                                                                            <label class="form-check-label"
                                                                                                   for="barrier_check">Include
                                                                                                Barrier
                                                                                                Range</label>

                                                                                            <label class="pullright">Barrier
                                                                                                Check:
                                                                                                <!-- <small class="pullright">check for barrier</small> --></label>

                                                                                        </div>

                                                                                        <div class="colpanel-b barrier"
                                                                                             style="border-bottom:1px solid #eee; margin-top:15px; <?php if ($filter_user_data['barrier_check'] == 'yes') {
        echo "display:block";
    } else {
        echo "display:none";
    }?>">

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Barrier
                                                                                                        Range:
                                                                                                        <!-- <small class="pullright">range of barrier</small> --></label>

                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="<?php echo $row['setting_id'] ?>barrier_range"
                                                                                                           name="barrier_range"
                                                                                                           value="<?=$filter_user_data['barrier_range']?>">

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Barrier
                                                                                                        Side:
                                                                                                        <!-- <small class="pullright">side of barrier</small> --></label>

                                                                                                    <select class="form-control"
                                                                                                            id="<?php echo $row['setting_id'] ?>barrier_side"
                                                                                                            name="barrier_side">

                                                                                                        <option value="up" <?=$filter_user_data['barrier_side'] == 'up' ? "selected" : ""?>>
                                                                                                            Upside
                                                                                                        </option>

                                                                                                        <option value="down" <?=$filter_user_data['barrier_side'] == 'down' ? "selected" : ""?>>
                                                                                                            Downside
                                                                                                        </option>

                                                                                                    </select>

                                                                                                    <!-- <input type="text" class="form-control" name="barrier_side"> -->

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Barrier
                                                                                                        Type:
                                                                                                        <!-- <small class="pullright">type of barrier</small> --></label>

                                                                                                    <select class="form-control"
                                                                                                            id="<?php echo $row['setting_id'] ?>barrier_type"
                                                                                                            name="barrier_type">
                                                                                                        <option value="" <?=$filter_user_data['barrier_type'] == '' ? "selected" : ""?>>
                                                                                                            Select
                                                                                                        </option>
                                                                                                        <option value="very_strong_barrier" <?=$filter_user_data['barrier_type'] == 'very_strong_barrier' ? "selected" : ""?>>
                                                                                                            Very
                                                                                                            Strong
                                                                                                            Barrier
                                                                                                        </option>

                                                                                                        <option value="weak_barrier" <?=$filter_user_data['barrier_type'] == 'weak_barrier' ? "selected" : ""?>>
                                                                                                            Weak
                                                                                                            Barrier
                                                                                                        </option>

                                                                                                        <option value="strong_barrier" <?=$filter_user_data['barrier_type'] == 'strong_barrier' ? "selected" : ""?>>
                                                                                                            Strong
                                                                                                            Barrier
                                                                                                        </option>

                                                                                                    </select>

                                                                                                    <!-- <input type="text" class="form-control" name="barrier_side"> -->

                                                                                                </div>

                                                                                            </div>

                                                                                        </div>

                                                                                    </div>

                                                                                </div>

                                                                                <div class="col-xs-12">

                                                                                    <div class="colpanel">

                                                                                        <div class="colpanel-h"
                                                                                             style="border-bottom:none; margin-bottom:0;">

                                                                                            <input type="checkbox"
                                                                                                   class="form-check-input"
                                                                                                   id="<?php echo $row['setting_id'] ?>candle_wick"
                                                                                                   name="candle_wick"
                                                                                                   value="yes" <?php if ($filter_user_data['candle_wick'] == 'yes') {
        echo "checked";
    }?>>

                                                                                            <label class="form-check-label"
                                                                                                   for="candle_wick">Check
                                                                                                Wick
                                                                                                Candle</label>

                                                                                            <label class="pullright">Check
                                                                                                Wick Candle:
                                                                                                <!-- <small class="pullright">Check Wick Candle</small> --></label>

                                                                                        </div>

                                                                                        <div class="colpanel-b wick"
                                                                                             style="border-bottom:1px solid #eee; margin-top:15px; <?php if ($filter_user_data['candle_wick'] == 'yes') {
        echo "display:block";
    } else {
        echo "display:none";
    }?>">

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Check
                                                                                                        Last
                                                                                                        Candle:
                                                                                                        <!-- <small class="pullright">Check Last Candle</small> --></label>

                                                                                                    <select class="form-control"
                                                                                                            id="<?php echo $row['setting_id'] ?>candle_typ"
                                                                                                            name="candle_typ">
                                                                                                        <option value="" <?=$filter_user_data['candle_typ'] == '' ? "selected" : ""?>>
                                                                                                            Select
                                                                                                        </option>
                                                                                                        <option value="demand" <?=$filter_user_data['candle_typ'] == 'demand' ? "selected" : ""?>>
                                                                                                            demand
                                                                                                        </option>

                                                                                                        <option value="supply" <?=$filter_user_data['candle_typ'] == 'supply' ? "selected" : ""?>>
                                                                                                            supply
                                                                                                        </option>

                                                                                                        <option value="normal_blue" <?=$filter_user_data['candle_typ'] == 'normal_blue' ? "selected" : ""?>>
                                                                                                            normal
                                                                                                            blue
                                                                                                        </option>

                                                                                                        <option value="normal_red" <?=$filter_user_data['candle_typ'] == 'normal_red' ? "selected" : ""?>>
                                                                                                            normal
                                                                                                            red
                                                                                                        </option>

                                                                                                    </select>

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Check
                                                                                                        Wick
                                                                                                        Side:
                                                                                                        <!--  <small class="pullright">Check Wick Side</small> --></label>

                                                                                                    <select class="form-control"
                                                                                                            id="<?php echo $row['setting_id'] ?>wick_side"
                                                                                                            name="wick_side">
                                                                                                        <option value="" <?=$filter_user_data['wick_side'] == '' ? "selected" : ""?>>
                                                                                                            Select
                                                                                                        </option>
                                                                                                        <option value="up" <?=$filter_user_data['wick_side'] == 'up' ? "selected" : ""?>>
                                                                                                            up
                                                                                                        </option>

                                                                                                        <option value="down" <?=$filter_user_data['wick_side'] == 'down' ? "selected" : ""?>>
                                                                                                            down
                                                                                                        </option>

                                                                                                    </select>

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Size
                                                                                                        Wick:
                                                                                                        <!-- <small class="pullright">size of wick</small> --></label>

                                                                                                    <input type="text"
                                                                                                           id="<?php echo $row['setting_id'] ?>wick_size"
                                                                                                           class="form-control"
                                                                                                           name="wick_size"
                                                                                                           value="<?=$filter_user_data['wick_size']?>">

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Wick
                                                                                                        Lookup:
                                                                                                        <!-- <small class="pullright">lookup period in hours</small> --></label>

                                                                                                    <input type="text"
                                                                                                           id="<?php echo $row['setting_id'] ?>wick_lookup"
                                                                                                           class="form-control"
                                                                                                           name="wick_lookup"
                                                                                                           value="<?=$filter_user_data['wick_lookup']?>">

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Trade
                                                                                                        Percentage:
                                                                                                        <!-- <small class="pullright">percentage of trade</small> --></label>

                                                                                                    <input type="text"
                                                                                                           id="<?php echo $row['setting_id'] ?>trade_percentage"
                                                                                                           class="form-control"
                                                                                                           name="trade_percentage"
                                                                                                           value="<?=$filter_user_data['trade_percentage']?>">

                                                                                                </div>

                                                                                            </div>

                                                                                        </div>

                                                                                    </div>

                                                                                </div>

                                                                                <div class="col-xs-12">

                                                                                    <div class="colpanel">

                                                                                        <div class="colpanel-h"
                                                                                             style="border-bottom:none; margin-bottom:0;">

                                                                                            <input type="checkbox"
                                                                                                   class="form-check-input"
                                                                                                   id="<?php echo $row['setting_id'] ?>volume_check"
                                                                                                   name="volume_check"
                                                                                                   value="yes" <?php if ($filter_user_data['volume_check'] == 'yes') {
        echo "checked";
    }?>>

                                                                                            <label class="form-check-label"
                                                                                                   for="volume_check">Increase
                                                                                                in
                                                                                                Volume</label>

                                                                                            <label class="pullright">Increase
                                                                                                in Volume:
                                                                                                <small class="pullright">Increase
                                                                                                    in
                                                                                                    volume</small></label>

                                                                                        </div>

                                                                                        <div class="colpanel-b"
                                                                                             style="border-bottom:1px solid #eee; margin-top:15px; display:none;">


                                                                                        </div>

                                                                                    </div>

                                                                                </div>


                                                                                <div class="col-xs-12">

                                                                                    <div class="colpanel">

                                                                                        <div class="colpanel-h"
                                                                                             style="border-bottom:none; margin-bottom:0;">

                                                                                            <input type="checkbox"
                                                                                                   class="form-check-input"
                                                                                                   id="<?php echo $row['setting_id'] ?>last_demand_candle"
                                                                                                   name="last_demand_candle"

                                                                                                   value="yes" <?php if ($filter_user_data['last_demand_candle'] == 'yes') {
        echo "checked";
    }?>>

                                                                                            <label class="form-check-label"
                                                                                                   for="last_demand_candle">Check
                                                                                                Last Demand
                                                                                                Candle</label>

                                                                                            <label class="pullright">Check
                                                                                                Last Demand
                                                                                                Candle:
                                                                                                <small class="pullright">Check
                                                                                                    Last
                                                                                                    Demand
                                                                                                    Candle</small></label>

                                                                                        </div>

                                                                                        <div class="colpanel-b"
                                                                                             style="border-bottom:1px solid #eee; margin-top:15px; display:none;">


                                                                                        </div>

                                                                                    </div>

                                                                                </div>

                                                                                <div class="col-xs-12">

                                                                                    <div class="colpanel">

                                                                                        <div class="colpanel-h"
                                                                                             style="border-bottom:none; margin-bottom:0;">

                                                                                            <input type="checkbox"
                                                                                                   class="form-check-input"
                                                                                                   id="<?php echo $row['setting_id'] ?>price_check"
                                                                                                   name="price_check"

                                                                                                   value="yes" <?php if ($filter_user_data['price_check'] == 'yes') {
        echo "checked";
    }?>>

                                                                                            <label class="form-check-label"
                                                                                                   for="price_check">Coin
                                                                                                Price
                                                                                                Percentage</label>

                                                                                            <label class="pullright">Coin
                                                                                                Price
                                                                                                Percentage:
                                                                                                <small class="pullright">Coin
                                                                                                    Price
                                                                                                    Percentage</small></label>

                                                                                        </div>

                                                                                        <div class="colpanel-b"
                                                                                             style="border-bottom:1px solid #eee; margin-top:15px;">
                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Coin
                                                                                                        To
                                                                                                        Check:
                                                                                                        <!-- <small class="pullright">percentage of trade</small> --></label>

                                                                                                    <select id="<?php echo $row['setting_id'] ?>price_symbol"
                                                                                                            name="price_symbol"
                                                                                                            type="text"
                                                                                                            class="form-control filter_by_name_margin_bottom_sm">

                                                                                                        <option value="" <?=(($filter_user_data['price_symbol'] == "") ? "selected" : "")?>>
                                                                                                            Search
                                                                                                            By
                                                                                                            Coin
                                                                                                            Symbol
                                                                                                        </option>

                                                                                                        <?php

    for ($i = 0; $i < count($coins); $i++) {

        $selected = ($coins[$i]['symbol'] == $filter_user_data['price_symbol']) ? "selected" : "";

        echo "<option value='" . $coins[$i]['symbol'] . "' $selected>" . $coins[$i]['symbol'] . "</option>";

    }

    ?>

                                                                                                    </select>

                                                                                                </div>

                                                                                            </div>
                                                                                            <div class="col-xs-12 col-md-3">

                                                                                                <div class="Input_text_s">

                                                                                                    <label class="full-label">Profit
                                                                                                        Percentage:
                                                                                                        <!-- <small class="pullright">percentage of trade</small> --></label>

                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="<?php echo $row['setting_id'] ?>price_to_check"
                                                                                                           name="price_to_check"
                                                                                                           value="<?=$filter_user_data['price_to_check']?>">

                                                                                                </div>

                                                                                            </div>
                                                                                        </div>

                                                                                    </div>

                                                                                </div>


                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <!--  <div class="modal-body">
                    <?php $setting_arr = $row['settings'];?>
                    <?php foreach ($setting_arr as $set_key => $set_val) {
        ?>
        <div class="row">
        <div class="col-md-6">
            <?php if ($set_val == '') {
            $color = '#CCC';
        } else {
            $color = '#000';
        }?>
            <p style="font-weight: bolder; padding:10px; color:<?php echo $color; ?>">
                <?=ucfirst(str_replace("_", " ", $set_key))?>
            </p>
        </div>
    <div class="col-md-6">
        <p style="padding: 10px;">
            <?php
if (is_array($value)) {
            echo implode(",", $value);
        } else {
            echo $set_val;
        }
        ?>
                        </p>
                    </div>
                </div>
                <?php
}?>
        </div> -->
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                            class="btn btn-default"
                                                                            data-dismiss="modal">Close
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="<?php echo SURL; ?>admin/reports/delete_setting/<?=trim($row['setting_id']);?>"
                                                       class="btn btn-danger btn-sm btn-del"
                                                       id="<?=$row['setting_id'];?>"><i
                                                                class="fa fa-trash"></i></a></td>
                                            </tr>
                                        <?php }?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo $page_links; ?>
                </div>
                <!-- // Widget END -->
            </div>
            <div id="menu1" class="tab-pane fade">
                <div class="widget widget-inverse">
                    <div class="widget-head">
                        <div class="row">
                            <div class="col-md-12">
                                Settings
                                <span style="float:right;">
                     <!-- <button class="btn btn-info" onclick="exportTableToCSV('report.csv')">Export To CSV File</button> -->
                  </span>
                            </div>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="row" style="padding-bottom: 8px;margin-bottom: 10px;"><span
                                    style="float:right"> <a href="#!" class="btn btn-primary btn-copy"><img
                                            src="https://app.digiebot.com/assets/images/my_icons/copy.png"></a> <a
                                        href="javascript:void(0)" class="btn btn-primary btn-csv"
                                        onclick="exportTableToCSV('report.csv')"><img
                                            src="https://app.digiebot.com/assets/images/my_icons/csv.png"></a> <a
                                        href="#!" class="btn btn-primary btn-excel"><img
                                            src="https://app.digiebot.com/assets/images/my_icons/excel.png"></a> <a
                                        href="javascript:void(0)" class="btn btn-primary btn-pdf"><img
                                            src="https://app.digiebot.com/assets/images/my_icons/pdf.png"></a> <a
                                        href="#!" class="btn btn-primary btn-print"><img
                                            src="https://app.digiebot.com/assets/images/my_icons/print.png"></a> </span>
                        </div>
                        <div class="row">
                            <div class="autoresponsive">
                                <div class="table-responsive">
                                    <table class="example table table-hover" id="example2">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Coin Symbol</th>
                                            <th>Setting Name</th>
                                            <th>Total Oppurtunities</th>
                                            <th>Winning Opportunities</th>
                                            <th>Losing Opportunities</th>
                                            <th>Winning Percentage</th>
                                            <th>Losing Percentage</th>
                                            <th>Total Winning Profit</th>
                                            <th>Total Losing Profit</th>
                                            <th>Total Percentage</th>
                                            <th>Per Trade Percentage Profit</th>
                                            <th>Per Day Percentage Profit</th>
                                            <th>Average Time</th>
                                            <th>No of Days</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Created Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <?php
$i = 1;
foreach ($setting AS $row) {
    if ($row['is_fav'] == 'yes') {
        ?>
                                        <tbody>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?=$row['symbol']?></td>
                                            <td><?=$row['title_to_filter']?></td>
                                            <td><?=$row['total']?></td>
                                            <td><?=number_format($row['winning'], 2)?></td>
                                            <td><?=number_format($row['losing'], 2)?></td>
                                            <td><?=number_format($row['win_per'], 2)?></td>
                                            <td><?=number_format($row['lose_per'], 2)?></td>
                                            <td><?=number_format($row['winners'], 2)?></td>
                                            <td><?=number_format($row['losers'], 2)?></td>
                                            <td><?=number_format($row['total_profit'], 2)?></td>
                                            <td><?=number_format($row['per_trade'], 2)?></td>
                                            <td><?=number_format($row['per_day'], 2)?></td>
                                            <td><?=number_format($row['average_time'], 2)?></td>
                                            <td><?php
// $start_date = $row['created_date']->toDatetime()->format("Y-m-d H:i:s");
        //     $end_date = $row['end_date']->toDatetime()->format("Y-m-d H:i:s");
        //     $date1 = new DateTime($start_date);
        //     $date2 = new DateTime($end_date);
        //     $diff = $date2->diff($date1);
        //     $total_days = $diff->days;

//     echo $total_days;
        echo $row['total_number_of_days'];
        ?></td>
                                            <td><?=$row['created_date']->toDatetime()->format("Y-m-d H:i:s");?></td>
                                            <td><?=$row['end_date']->toDatetime()->format("Y-m-d H:i:s");?></td>
                                            <td><?=(!empty($row['current_date']) ? $row['current_date']->toDatetime()->format("Y-m-d H:i:s") : "-")?></td>
                                            <td><label for="id-of-input_<?php echo $i; ?>"
                                                       class="custom-checkbox"
                                                       style="font-size : 40px;left: -25px;">
                                                    <input type="checkbox" class="add_fav"
                                                           id="id-of-input_<?php echo $i; ?>"
                                                           data-id="<?php echo $row['_id']; ?>" <?php if ($row['is_fav'] == 'yes') {
            echo "checked";
        }?> />
                                                    <i class="glyphicon glyphicon-heart-empty"></i> <i
                                                            class="glyphicon glyphicon-heart"></i></i>
                                                </label>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#myModal_<?php echo $i; ?>"><i
                                                            class="fa fa-file"></i></button>
                                                <div class="modal fade" id="myModal_<?php echo $i; ?>"
                                                     role="dialog">
                                                    <div class="modal-dialog modal-lg" style="width: 90%;">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal">&times;
                                                                </button>
                                                                <h4 class="modal-title">Report</h4>
                                                            </div>
                                                            <div class="modal-body autoresponsive">
                                                                <div class="table-responsive">
                                                                    <table class="dynamicTable display table table-stripped"
                                                                           id="my_tables">
                                                                        <thead>
                                                                        <?php
$final = $row['result'];
        if (count($final) > 0) {
            $x = 0;
            foreach ($final as $key => $value) {
                if (!empty($value)) {
                    if ($x == 0) {
                        $percentile_log_head = $value['percentile_log'];
                        $x++;
                        break;
                    } else {
                        continue;
                    }
                }
            }
        }
		

		
        ?>
                                                                        <tr>
                                                                              <th>Opportunity Time</th>

                                                                              <th>Market Price</th>

                                                                              <th>Market Time</th>

                                                                              <th>Barrier Value</th>

                                                                              <th>Last Candle Value</th>

                                                                              <th>Message With Loss 1</th>

                                                                              <th>Profit Percentage</th>

                                                                              <th>Profit Time</th>

                                                                              <th>Profit Price</th>

                                                                              <th>Profit Time Ago</th>

                                                                              <th>Loss Percentage</th>

                                                                              <th>Loss Time</th>

                                                                              <th>Loss Price</th>

                                                                              <th>Loss Time Ago</th>

                                                                              <th>Message With Loss 2</th>

                                                                              <th>Loss Percentage2</th>

                                                                              <th>Loss Time2</th>

                                                                              <th>Loss Price 2</th>

                                                                              <th>Loss Time Ago2</th>

                                                                               <th>Top 2 prices</th>
                                                                               <th>Five Hour Max Profit</th>
                                                                               <th>Five Hour Min Profit</th>
                                                                            <?php
foreach ($percentile_log_head as $heading => $val) {?>
                                                                                <th> <?php echo ucfirst(str_replace("_", " ", $heading)) ?> </th>
                                                                            <?php }?>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php
$final = $row['result'];
        if (count($final) > 0) {
            foreach ($final as $key => $value) {
                if (!empty($value)) {
                    ?>
                                                                                    <tr>
                                                                                        <td><?=$key;?></td>
                                                                                        <td><?=$value['market_value'];?></td>

                                                                                      <td><?=$value['market_time'];?></td>

                                                                                      <td><?=$value['barrier'];?></td>

                                                                                      <td><?=$value['last_candle_value'];?></td>

                                                                                      <td><?=$value['message'];?></td>

                                                                                      <td><?=$value['profit_percentage'];?></td>

                                                                                      <td><?=$value['profit_date'];?></td>

                                                                                      <td><?=$value['proft_price'];?></td>

                                                                                      <td><?=$value['profit_time'];?></td>

                                                                                      <td><?=$value['loss_percentage'];?></td>

                                                                                      <td><?=$value['loss_date'];?></td>

                                                                                      <td><?=$value['loss_price'];?></td>

                                                                                      <td><?=$value['loss_time'];?></td>

                                                                                      <td><?=$value['message2'];?></td>

                                                                                      <td><?=$value['loss_percentage2'];?></td>

                                                                                      <td><?=$value['loss_date2'];?></td>

                                                                                      <td><?=$value['loss_price2'];?></td>

                                                                                      <td><?=$value['loss_time2'];?></td>

                                                                                      <td><?=$value['top_prices']?></td>
                                                                                        <td><?=number_format(($value['high'] - $value['market_value']) / $value['high'] * 100, 2);?></td>
                                                                                        <td><?=number_format(($value['low'] - $value['market_value']) / $value['low'] * 100, 2);?></td>
                                                                                        <?php
$percentile_log = $value['percentile_log'];
                    foreach ($percentile_log as $heading => $val) {?>
                                                                                            <td><?php echo $val; ?></td>
                                                                                        <?php }?>
                                                                                    </tr>
                                                                                    <?php
}
            }
        }
        ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                        class="btn btn-primary"
                                                                        data-dismiss="modal">Close
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-info btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#myModal2_<?php echo $i; ?>"><i
                                                            class="fa fa-cogs"></i></button>
                                                <div class="modal fade" id="myModal2_<?php echo $i; ?>"
                                                     role="dialog">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal">&times;
                                                                </button>
                                                                <h4 class="modal-title">Settings</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php $setting_arr = $row['settings'];?>
                                                                <?php foreach ($setting_arr as $set_key => $set_val) {
            if (!empty($set_val)) {
                ?>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <p style="font-weight: bolder; padding:10px;">
                                                                                    <?=ucfirst(str_replace("_", " ", $set_key))?>
                                                                                </p>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <p style="padding: 10px;">
                                                                                    <?php
if (is_array($value)) {
                    foreach ($value as $key333 => $value333) {
                        echo $value333 . ",";
                    }
                } else {
                    echo $set_val;
                }
                ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
        }?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                        class="btn btn-default"
                                                                        data-dismiss="modal">Close
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="<?php echo SURL; ?>admin/reports/delete_setting/<?=trim($row['setting_id']);?>"
                                                   class="btn btn-danger btn-sm btn-del"
                                                   id="<?=$row['setting_id'];?>"><i
                                                            class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php }
}?>
                                        <tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- // Widget END -->
            </div>
        </div>
        <br>
    </div>
</div>
</div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<style>
.autoresponsive {
width: 100%;
overflow-x: auto;
}
</style>
<script>
$(document).ready(function () {
$('table.display').dataTable();
});
</script>
<script>


$('#example').DataTable({
buttons: [{
    extend: 'collection',
    text: 'Export',
    buttons: [
        'copy',
        'excel',
        'csv',
        'pdf',
        'print'
    ]
}]
});
$(function () {
availableTags = [];
$.ajax({
    'url': '<?php echo SURL ?>admin/reports/get_all_usernames_ajax',
    'type': 'POST',
    'data': "",
    'success': function (response) {
        availableTags = JSON.parse(response);

        $("#username").autocomplete({
            source: availableTags
        });
    }
});

});
</script>
<script type="text/javascript">
/*$("body").on("click",".btn-del",function(e){
    var id = $(this).attr('id');
    $.confim({
      title:" You are going to delete something",
      content: " Are you sure you want to delete setting with id = "+ id,
      buttons: {
        confirm: function () {
            window.location.href = "<?php echo SURL; ?>admin/reports/delete_setting/"+$id;
   },
   cancel: function () {
     //code
   },
 }
});
});*/

jQuery("body").on("click", "button[data-dismiss='modalx']", function () {
jQuery(this).closest(".modalx").modal("close");
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
<script type="text/javascript"
src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script type="text/javascript">
$(function () {

var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};
$('.btn-pdf').click(function () {
    var doc = new jsPDF();
    doc.fromHTML($('#my_tables').html(), 15, 15, {
        'width': 170,
        'elementHandlers': specialElementHandlers
    });
    doc.save('sample-file.pdf');

    //     html2canvas(document.getElementById('my_tables'),{
    //     onrendered:function(canvas){
    //     var doc = new jsPDF("p", "px", [1224, 6468]);
    //     var width_C = doc.internal.pageSize.getWidth()-10;
    //     var height_C = doc.internal.pageSize.getHeight()-10;
    //     var img=canvas.toDataURL("image/png");
    //     doc.addImage(img,'JPEG',5,5,width_C,height_C);
    //     doc.save('report.pdf');
    // }
    // });
});
});
</script>
<script type="text/javascript">

$("body").on("click",".btn-verify", function(e) {
  var hour = $(this).attr("id");
  var symbol = $(this).attr("data-coin");

  $.confirm({
    title: 'Prompt!',
    content: '' +
    '<form action="" class="formName">' +
    '<div class="form-group">' +
    '<label>Comparing Level</label>' +
    '<input type="text" placeholder="level_13" class="name form-control" required />' +
    '</div>' +
    '</form>',
    buttons: {
        formSubmit: {
            text: 'Submit',
            btnClass: 'btn-blue',
            action: function () {
                var name = this.$content.find('.name').val();
                if(!name){
                    $.alert('provide a valid name');
                    return false;
                }
                $.ajax({

                    url: "https://admin.digiebot.com/admin/tester_report/verify_oppurtunity",
                    type: "POST",
                    data: {name:name, hour:hour, symbol:symbol},
                    success: function(resp){
                      console.log(resp);
                      $.alert(resp.message);
                    }

                });
            }
        },
        cancel: function () {
            //close
        },
    },
    onContentReady: function () {
        // bind to events
        var jc = this;
        this.$content.find('form').on('submit', function (e) {
            // if the user submits the form by pressing enter in the field.
            e.preventDefault();
            jc.$$formSubmit.trigger('click'); // reference the button and click it
        });
    }
});
});

$("body").on("click", ".add_fav", function (e) {
var id = $(this).data("id");


if ($(this).is(":checked")) {
    $.ajax({
        url: "<?php echo SURL; ?>admin/reports/add_remove_favorite",
        type: "POST",
        data: {
            is_fav: "yes",
            id: id
        },
        success: function (resp) {
            alert(resp);
            // var lastRow = $("#row_"+id).html();
            // console.log(lastRow);
            // $('#example2 tbody').append('<tr>' + lastRow + '</tr>');

            var keep_sell_data = $("#row_" + id).html();
            keep_sell_data1 = "<tr>" + keep_sell_data + "</tr>";
            $('#example2 tbody').append('<tr>' + keep_sell_data1 + '</tr>')
            //keep_sell_data.appendTo("#example2 tbody");
        },
        error: function (err) {
            alert("error");
        }
    });
} else {
    $.ajax({
        url: "<?php echo SURL; ?>admin/reports/add_remove_favorite",
        type: "POST",
        data: {
            is_fav: "no",
            id: id
        },
        success: function (resp) {
            alert(resp);
        },
        error: function (err) {
            alert("error");
        }
    });
}
});


</script>

