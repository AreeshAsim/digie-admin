<?php $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
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
                <form action="<?php echo SURL . "admin/reports/settings_report_listing?trigger=" . $_GET['trigger'] ?>" method="post">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="Input_text_s coin_filter">
                                <label>Filter Coin</label>
                                <select id="filter_by_coin" name="filter_by_coin" type="text" class="form-control filter_by_name_margin_bottom_sm">
                                    <option value="" <?=(($filter_user_data['filter_by_coin'] == "") ? "selected" : "")?>>Search By Coin Symbol</option>
                                    <?php
                                    for ($i = 0; $i < count($coins); $i++) {
                                        $selected = ($coins[$i]['symbol'] == $filter_user_data['filter_by_coin']) ? "selected" : "";
                                        echo "<option value='" . $coins[$i]['symbol'] . "' $selected>" . $coins[$i]['symbol'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="Input_text_s">
                                <label>Filter by Admin</label>
                                <select id="filter_by_admin" name="filter_by_admin" type="text" class="form-control filter_by_name_margin_bottom_sm">
                                    <option value="" <?=(($filter_user_data['filter_by_admin'] == "") ? "selected" : "")?>>Search By Admin</option>
                                    <?php
                                    for ($i = 0; $i < count($admins); $i++) {
                                        $selected = ($admins[$i]['_id'] == $filter_user_data['filter_by_admin']) ?
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
                                <input id="filter_by_name" name="filter_by_name" type="text" class="form-control" value="<?=$filter_user_data['filter_by_name']?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="Input_text_s">
                                <label>Number of Days More then</label>
                                <input id="filter_by_days" name="filter_by_days" type="text" class="form-control" value="<?=$filter_user_data['filter_by_days']?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="Input_text_s">
                                <label>Result Percentage more then</label>
                                <input id="filter_by_percentage" name="filter_by_percentage" type="text" class="form-control" value="<?=$filter_user_data['filter_by_percentage']?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="Input_text_s">
                                <label>Target Profit More then</label>
                                <input id="filter_by_profit" name="filter_by_profit" type="text" class="form-control" value="<?=$filter_user_data['filter_by_profit']?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="Input_text_s">
                                <label>Stop Loss More then</label>
                                <input id="filter_by_loss" name="filter_by_loss" type="text" class="form-control" value="<?=$filter_user_data['filter_by_loss']?>">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="col-xs-12 col-sm-12 col-md-6 ax_4">
                                <div class="Input_text_s">
                                    <label>From Date Range: <br>
                                    </label>
                                    <input id="filter_by_start_date" name="filter_by_start_date" type="text" class="form-control datetime_picker filter_by_name_margin_bottom_sm" placeholder="Search By Date" value="<?=(!empty($filter_user_data['filter_by_start_date']) ? $filter_user_data['filter_by_start_date'] : "")?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 ax_5">
                                <div class="Input_text_s">
                                    <label>To Date Range: <br>
                                    </label>
                                    <input id="filter_by_end_date" name="filter_by_end_date" type="text" class="form-control datetime_picker filter_by_name_margin_bottom_sm" placeholder="Search By Date" value="<?=(!empty($filter_user_data['filter_by_end_date']) ? $filter_user_data['filter_by_end_date'] : "")?>" autocomplete="off">
                                </div>
                            </div>
                            <script type="text/javascript">
                                $(function() {
                                    $('.datetime_picker').datetimepicker();
                                });
                            </script>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 ax_5">
                            <div class="Input_text_s">
                                <input id="submit" name="submit" type="submit" class="btn btn-success btn-md" value="Submit">
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
                                    <div class="row" style="padding-bottom: 8px;margin-bottom: 10px;"> <span style="float:right"> <a href="#!" class="btn btn-primary btn-copy"><img src="https://app.digiebot.com/assets/images/my_icons/copy.png"></a> <a href="javascript:void(0)" class="btn btn-primary btn-csv" onclick="exportTableToCSV('report.csv')"><img src="https://app.digiebot.com/assets/images/my_icons/csv.png"></a> <a href="#!" class="btn btn-primary btn-excel"><img src="https://app.digiebot.com/assets/images/my_icons/excel.png"></a> <a href="javascript:void(0)" class="btn btn-primary btn-pdf"><img src="https://app.digiebot.com/assets/images/my_icons/pdf.png"></a> <a href="#!" class="btn btn-primary btn-print"><img src="https://app.digiebot.com/assets/images/my_icons/print.png"></a> </span> </div>
                                    <div class="row">
                                        <div class="autoresponsive">
                                            <div class="table-responsive">
                                                <table class="example table table-hover" id="example">
                                                    <thead>
                                                    <tr>
                                                        <th><strong>#</strong> </th>
                                                        <th>
                                                            <strong>Coin Symbol</strong>
                                                            <span>
                                                <a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=symbol&type=DESC"><i class="glyphicon glyphicon-chevron-up"></i></a><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=symbol&type=ASC"><i class="glyphicon glyphicon-chevron-down"></i>
                                                <a>
                                             </span>
                                                        </th>
                                                        <th><strong>Setting Name</strong>
                                                            <span>
                                          <a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=settings.title_to_filter&type=DESC"><i class="glyphicon glyphicon-chevron-up"></i></a><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=settings.title_to_filter&type=ASC"><i class="glyphicon glyphicon-chevron-down"></i>
                                          <a>
                                          </span>
                                                        </th>
                                                        <th>
                                                            <strong>Total Oppurtunities</strong>
                                                            <span>
                                          <a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=total&type=DESC"><i class="glyphicon glyphicon-chevron-up"></i></a><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=total&type=ASC"><i class="glyphicon glyphicon-chevron-down"></i>
                                          <a>
                                          </span>
                                                        </th>
                                                        <th><strong>Winning Opportunities</strong>
                                                            <span>
                                          <a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=winning&type=DESC"><i class="glyphicon glyphicon-chevron-up"></i></a><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=winning&type=ASC"><i class="glyphicon glyphicon-chevron-down"></i>
                                          <a>
                                          </span>
                                                        </th>
                                                        <th><strong>Losing Opportunities</strong>
                                                            <span>
                                          <a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=losing&type=DESC"><i class="glyphicon glyphicon-chevron-up"></i></a><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=losing&type=ASC"><i class="glyphicon glyphicon-chevron-down"></i>
                                          </span>
                                                        </th>
                                                        <th><strong>Winning Percentage</strong> <span><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=win_per&type=DESC"><i class="glyphicon glyphicon-chevron-up"></i></a><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=win_per&type=ASC"><i class="glyphicon glyphicon-chevron-down"></i></span> </th>
                                                        <th><strong>Losing Percentage</strong> <span><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=lose_per&type=DESC"><i class="glyphicon glyphicon-chevron-up"></i></a><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=lose_per&type=ASC"><i class="glyphicon glyphicon-chevron-down"></i></span> </th>
                                                        <th><strong>Total Winning Profit</strong> <span><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=winners&type=DESC"><i class="glyphicon glyphicon-chevron-up"></i></a><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=winners&type=ASC"><i class="glyphicon glyphicon-chevron-down"></i></span> </th>
                                                        <th><strong>Total Losing Profit</strong> <span><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=losers&type=DESC"><i class="glyphicon glyphicon-chevron-up"></i></a><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=losers&type=ASC"><i class="glyphicon glyphicon-chevron-down"></i></span> </th>
                                                        <th><strong>Total Percentage</strong> <span><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=total_profit&type=DESC"><i class="glyphicon glyphicon-chevron-up"></i></a><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=total_profit&type=ASC"><i class="glyphicon glyphicon-chevron-down"></i></span> </th>
                                                        <th><strong>Per Trade Percentage Profit</strong> <span><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=per_trade&type=DESC"><i class="glyphicon glyphicon-chevron-up"></i></a><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=per_trade&type=ASC"><i class="glyphicon glyphicon-chevron-down"></i></span> </th>
                                                        <th><strong>Per Day Percentage Profit</strong> <span><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=per_day&type=DESC"><i class="glyphicon glyphicon-chevron-up"></i></a><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=per_day&type=ASC"><i class="glyphicon glyphicon-chevron-down"></i></span> </th>
                                                        <th><strong>Average Time</strong> <span></span> </th>
                                                        <th><strong>No of Days</strong> <span><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=total_number_of_days&type=DESC"><i class="glyphicon glyphicon-chevron-up"></i></a><a href="<?php echo SURL; ?>admin/reports/settings_report_listing?trigger=<?php echo $_GET['trigger']; ?>&order=total_number_of_days&type=ASC"><i class="glyphicon glyphicon-chevron-down"></i></span> </th>
                                                        <th><strong>Start Date</strong> <span></span> </th>
                                                        <th><strong>End Date</strong> <span></span> </th>
                                                        <th><strong>Created Date</strong> <span></span> </th>
                                                        <th><strong>Action</strong> <span></span> </th>
                                                    </tr>
                                                    </thead>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($setting AS $row) {
                                                        ?>
                                                        <tr id="row_<?php echo $row['_id']; ?>">
                                                            <td><?php echo $i++; ?></td>
                                                            <td>
                                                                <?php $logo = $this->mod_coins->get_coin_logo($row['symbol']);?>
                                                                <img src="<?php echo ASSETS; ?>coin_logo/thumbs/<?php echo $logo; ?>" class="img img-circle" data-toggle="tooltip" data-placement="top" title="<?php echo $value['symbol'] ?>">
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
                                                                    $( document ).ready(function() {

                                                                        $('.pie_progress').asPieProgress({
                                                                            namespace: 'pie_progress'
                                                                        });
                                                                        $('.wpie_progress<?php echo $row['_id']; ?>').asPieProgress('go', <?php echo $profit; ?>);
                                                                    });

                                                                </script>
                                                                <div class="pie_progress wpie_progress<?php echo $row['_id']; ?>" role="progressbar" <?php echo $color; ?> data-goal="100" aria-valuemin="<?php echo $minumu; ?>" aria-valuemax="<?php echo $maximu; ?>">
                                                                    <div class="pie_progress__label"> <?php echo $profitorg; ?>%</div>
                                                                </div></td>
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
                                                                    $( document ).ready(function() {

                                                                        $('.pie_progress').asPieProgress({
                                                                            namespace: 'pie_progress'
                                                                        });
                                                                        $('.lpie_progress<?php echo $row['_id']; ?>').asPieProgress('go', <?php echo $profit; ?>);
                                                                    });

                                                                </script>
                                                                <div class="pie_progress lpie_progress<?php echo $row['_id']; ?>" role="progressbar" <?php echo $color; ?> data-goal="100" aria-valuemin="<?php echo $minumu; ?>" aria-valuemax="<?php echo $maximu; ?>">
                                                                    <div class="pie_progress__label"> <?php echo $profitorg; ?>%</div>
                                                                </div></td>
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
                                                            <td><label for="id-of-input_<?php echo $i; ?>" class="custom-checkbox" style="font-size : 40px;left: -25px;" >
                                                                    <input type="checkbox" class="add_fav" id="id-of-input_<?php echo $i; ?>" data-id="<?php echo $row['_id']; ?>" <?php if ($row['is_fav'] == 'yes') {echo "checked";}?>/>
                                                                    <i class="glyphicon glyphicon-heart-empty"></i> <i class="glyphicon glyphicon-heart"></i></i> </label></td>
                                                            <td><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal1x_<?php echo $i; ?>"><i class="fa fa-file"></i></button>
                                                                <div class="modal fade" id="myModal1x_<?php echo $i; ?>" role="dialog">
                                                                    <div class="modal-dialog modal-lg" style="width: 90%;">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                <h4 class="modal-title">Report</h4>
                                                                            </div>
                                                                            <div class="modal-body autoresponsive">
                                                                                <div class="table-responsive">
                                                                                    <table class="dynamicTable display table table-stripped" id="my_tables">
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
                                                                                            <th>Message</th>
                                                                                            <th>Profit Percentage</th>
                                                                                            <th>Profit Time</th>
                                                                                            <th>Profit Time Ago</th>
                                                                                            <th>Loss Percentage</th>
                                                                                            <th>Loss Time</th>
                                                                                            <th>Loss Time Ago</th>
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
                                                                                                        <td><?=num($value['barrier']);?></td>
                                                                                                        <td><?=$value['message'];?></td>
                                                                                                        <td><?=$value['profit_percentage'];?></td>
                                                                                                        <td><?=$value['profit_date'];?></td>
                                                                                                        <td><?=$value['profit_time'];?></td>
                                                                                                        <td><?=$value['loss_percentage'];?></td>
                                                                                                        <td><?=$value['loss_date'];?></td>
                                                                                                        <td><?=$value['loss_time'];?></td>
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
                                                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal2x_<?php echo $i; ?>"><i class="fa fa-cogs"></i></button>
                                                                <div class="modal fade" id="myModal2x_<?php echo $i; ?>" role="dialog">
                                                                    <div class="modal-dialog modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                <h4 class="modal-title">Settings</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <?php $setting_arr = $row['settings'];?>
                                                                                <?php foreach ($setting_arr as $set_key => $set_val) {
                                                                                    ?>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <?php if ($set_val == '') {$color = '#CCC';} else { $color = '#000';}?>
                                                                                            <p style="font-weight: bolder; padding:10px; color:<?php echo $color; ?>">
                                                                                                <?=ucfirst(str_replace("_", " ", $set_key))?>
                                                                                            </p>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <p style="padding: 10px;">
                                                                                                <?=$set_val?>
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }?>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <a href="<?php echo SURL; ?>admin/reports/delete_setting/<?=trim($row['setting_id']);?>" class="btn btn-danger btn-sm btn-del" id="<?=$row['setting_id'];?>"><i class="fa fa-trash"></i></a></td>
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
                                    <div class="row" style="padding-bottom: 8px;margin-bottom: 10px;"> <span style="float:right"> <a href="#!" class="btn btn-primary btn-copy"><img src="https://app.digiebot.com/assets/images/my_icons/copy.png"></a> <a href="javascript:void(0)" class="btn btn-primary btn-csv" onclick="exportTableToCSV('report.csv')"><img src="https://app.digiebot.com/assets/images/my_icons/csv.png"></a> <a href="#!" class="btn btn-primary btn-excel"><img src="https://app.digiebot.com/assets/images/my_icons/excel.png"></a> <a href="javascript:void(0)" class="btn btn-primary btn-pdf"><img src="https://app.digiebot.com/assets/images/my_icons/pdf.png"></a> <a href="#!" class="btn btn-primary btn-print"><img src="https://app.digiebot.com/assets/images/my_icons/print.png"></a> </span> </div>
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
                                                        <td><label for="id-of-input_<?php echo $i; ?>" class="custom-checkbox" style="font-size : 40px;left: -25px;">
                                                                <input type="checkbox" class="add_fav" id="id-of-input_<?php echo $i; ?>" data-id="<?php echo $row['_id']; ?>" <?php if ($row['is_fav'] == 'yes') {echo "checked";}?> />
                                                                <i class="glyphicon glyphicon-heart-empty"></i> <i class="glyphicon glyphicon-heart"></i></i> </label>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal_<?php echo $i; ?>"><i class="fa fa-file"></i></button>
                                                            <div class="modal fade" id="myModal_<?php echo $i; ?>" role="dialog">
                                                                <div class="modal-dialog modal-lg" style="width: 90%;">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            <h4 class="modal-title">Report</h4>
                                                                        </div>
                                                                        <div class="modal-body autoresponsive">
                                                                            <div class="table-responsive">
                                                                                <table class="dynamicTable display table table-stripped" id="my_tables">
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
                                                                                        <th>Message</th>
                                                                                        <th>Profit Percentage</th>
                                                                                        <th>Profit Time</th>
                                                                                        <th>Profit Time Ago</th>
                                                                                        <th>Loss Percentage</th>
                                                                                        <th>Loss Time</th>
                                                                                        <th>Loss Time Ago</th>
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
                                                                                                    <td><?=num($value['barrier']);?></td>
                                                                                                    <td><?=$value['message'];?></td>
                                                                                                    <td><?=$value['profit_percentage'];?></td>
                                                                                                    <td><?=$value['profit_date'];?></td>
                                                                                                    <td><?=$value['profit_time'];?></td>
                                                                                                    <td><?=$value['loss_percentage'];?></td>
                                                                                                    <td><?=$value['loss_date'];?></td>
                                                                                                    <td><?=$value['loss_time'];?></td>
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
                                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal2_<?php echo $i; ?>"><i class="fa fa-cogs"></i></button>
                                                            <div class="modal fade" id="myModal2_<?php echo $i; ?>" role="dialog">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            <h4 class="modal-title">Settings</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <?php $setting_arr = $row['settings'];?>
                                                                            <?php foreach ($setting_arr as $set_key => $set_val) {
                                                                                if (!empty($set_val)) {?>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <p style="font-weight: bolder; padding:10px;">
                                                                                                <?=ucfirst(str_replace("_", " ", $set_key))?>
                                                                                            </p>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <p style="padding: 10px;">
                                                                                                <?=$set_val?>
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php }
                                                                            }?>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="<?php echo SURL; ?>admin/reports/delete_setting/<?=trim($row['setting_id']);?>" class="btn btn-danger btn-sm btn-del" id="<?=$row['setting_id'];?>"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php }}?>
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
        $(document).ready(function() {
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
        $(function() {
            availableTags = [];
            $.ajax({
                'url': '<?php echo SURL ?>admin/reports/get_all_usernames_ajax',
                'type': 'POST',
                'data': "",
                'success': function(response) {
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

        jQuery("body").on("click", "button[data-dismiss='modalx']", function() {
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
    <script type="text/javascript">
        $(function() {

            var specialElementHandlers = {
                '#editor': function(element, renderer) {
                    return true;
                }
            };
            $('.btn-pdf').click(function() {
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
        $("body").on("click", ".add_fav", function(e) {
            var id = $(this).data("id");


            if ($(this).is(":checked")) {
                $.ajax({
                    url: "<?php echo SURL; ?>admin/reports/add_remove_favorite",
                    type: "POST",
                    data: {
                        is_fav: "yes",
                        id:id
                    },
                    success: function(resp) {
                        alert(resp);
                        // var lastRow = $("#row_"+id).html();
                        // console.log(lastRow);
                        // $('#example2 tbody').append('<tr>' + lastRow + '</tr>');

                        var keep_sell_data = $("#row_"+id).html();
                        keep_sell_data1 = "<tr>"+keep_sell_data+"</tr>";
                        $('#example2 tbody').append('<tr>' + keep_sell_data1 + '</tr>')
                        //keep_sell_data.appendTo("#example2 tbody");
                    },
                    error: function(err) {
                        alert("error");
                    }
                });
            } else {
                $.ajax({
                    url: "<?php echo SURL; ?>admin/reports/add_remove_favorite",
                    type: "POST",
                    data: {
                        is_fav: "no",
                        id:id
                    },
                    success: function(resp) {
                        alert(resp);
                    },
                    error: function(err) {
                        alert("error");
                    }
                });
            }
        })
    </script>