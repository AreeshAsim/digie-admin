


<div id="content" style="margin-top: 111px">
    
   


    

   
<link rel="stylesheet" type="text/css" href="https://app.digiebot.com/assets/cube_chart/style.css">



<div class="formbox"  style="display: none;">
    <div class="formitem">
    	<label>Time</label>
		<select class="s_time">
			<option value="0">0Hr</option>
			<option value="1">1Hr</option>
			<option value="2">2Hr</option>
			<option value="3">3Hr</option>
			<option value="4">4Hr</option>
			<option value="5">5Hr</option>
			<option value="6">6Hr</option>
			<option value="7">7Hr</option>
			<option value="8">8Hr</option>
			<option value="9">9Hr</option>
		</select>
	</div>
    <div class="formitem">
    	<label>High Value</label>
		<select class="s_high">
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
		</select>
	</div>
	<div class="formitem">
    	<label>Low Value</label>
		<select class="s_low">
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
		</select>
	</div>
	<div class="formitem">
    	<label>Open Value</label>
		<select class="s_open">
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
		</select>
	</div>
	<div class="formitem">
    	<label>Close Value</label>
		<select class="s_close">
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
		</select>
	</div>
	<div class="formitem">
    	<label>Submit</label>
		<button class="s_submit">Submit</button>
	</div>
</div>
<div class="formbox"  style="display: none;">
    <div class="formitem">
    	<label>Pline<span class="pl">100</span></label>
		<input class="Pline" type="range" min="10" max="500" value="100">
	</div>
    <div class="formitem">
    	<label>Tline<span class="tl">72</span></label>
		<input class="Tline" type="range" min="20" max="500" value="72">
	</div>
</div>
<div id="canvasbox_outer">
	
</div>
	<canvas id="myCanvas" style="border:1px solid #000;"></canvas> 





<script>
       var  SURL = '<?php echo SURL; ?>';
       var  TempArrayChart = <?php echo json_encode($final_arr); ?>;
       
</script>


<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<!--<script src="https://app.digiebot.com/assets/cube_chart/js.js" type="text/javascript"></script>-->

<script>

TempArray=[{"close":"0.00104060","open":"0.00104790","high":"0.00104800","low":"0.00103880","volume":"81.01186226","openTime":1518552000000,"closeTime":1518555599999},{"close":"0.00104220","open":"0.00104020","high":"0.00104230","low":"0.00103640","volume":"73.72795708","openTime":1518555600000,"closeTime":1518559199999},{"close":"0.00104720","open":"0.00104220","high":"0.00104900","low":"0.00104100","volume":"98.93361388","openTime":1518559200000,"closeTime":1518562799999},{"close":"0.00105500","open":"0.00104740","high":"0.00105560","low":"0.00104060","volume":"135.14113560","openTime":1518562800000,"closeTime":1518566399999},{"close":"0.00105050","open":"0.00105510","high":"0.00106000","low":"0.00104600","volume":"90.99297372","openTime":1518566400000,"closeTime":1518569999999},{"close":"0.00104180","open":"0.00104970","high":"0.00105170","low":"0.00104000","volume":"78.18474625","openTime":1518570000000,"closeTime":1518573599999},{"close":"0.00104010","open":"0.00104180","high":"0.00104520","low":"0.00103890","volume":"72.25559557","openTime":1518573600000,"closeTime":1518577199999},{"close":"0.00104300","open":"0.00103900","high":"0.00104620","low":"0.00103860","volume":"70.30792588","openTime":1518577200000,"closeTime":1518580799999},{"close":"0.00104470","open":"0.00104300","high":"0.00104700","low":"0.00104000","volume":"71.69209134","openTime":1518580800000,"closeTime":1518584399999},{"close":"0.00104730","open":"0.00104470","high":"0.00104820","low":"0.00104090","volume":"86.08849105","openTime":1518584400000,"closeTime":1518587999999},{"close":"0.00104170","open":"0.00104740","high":"0.00104940","low":"0.00103910","volume":"69.05388529","openTime":1518588000000,"closeTime":1518591599999},{"close":"0.00104060","open":"0.00104170","high":"0.00104220","low":"0.00103280","volume":"79.03965024","openTime":1518591600000,"closeTime":1518595199999},{"close":"0.00104270","open":"0.00103940","high":"0.00104530","low":"0.00103920","volume":"77.94509868","openTime":1518595200000,"closeTime":1518598799999},{"close":"0.00103800","open":"0.00104320","high":"0.00104450","low":"0.00103800","volume":"81.07701973","openTime":1518598800000,"closeTime":1518602399999},{"close":"0.00104130","open":"0.00103810","high":"0.00104390","low":"0.00103650","volume":"81.27937224","openTime":1518602400000,"closeTime":1518605999999},{"close":"0.00103780","open":"0.00104130","high":"0.00104240","low":"0.00103740","volume":"72.99417186","openTime":1518606000000,"closeTime":1518609599999},{"close":"0.00103780","open":"0.00103790","high":"0.00103850","low":"0.00102470","volume":"107.30330367","openTime":1518609600000,"closeTime":1518613199999},{"close":"0.00103670","open":"0.00103780","high":"0.00104600","low":"0.00103350","volume":"111.38408602","openTime":1518613200000,"closeTime":1518616799999},{"close":"0.00104490","open":"0.00103670","high":"0.00104600","low":"0.00103400","volume":"89.08075304","openTime":1518616800000,"closeTime":1518620399999},{"close":"0.00105340","open":"0.00104470","high":"0.00105800","low":"0.00104020","volume":"102.41755125","openTime":1518620400000,"closeTime":1518623999999},{"close":"0.00106470","open":"0.00105340","high":"0.00109800","low":"0.00105100","volume":"259.11473697","openTime":1518624000000,"closeTime":1518627599999},{"close":"0.00106660","open":"0.00106470","high":"0.00108000","low":"0.00106180","volume":"152.71368248","openTime":1518627600000,"closeTime":1518631199999},{"close":"0.00107430","open":"0.00106550","high":"0.00107660","low":"0.00105500","volume":"160.94900321","openTime":1518631200000,"closeTime":1518634799999},{"close":"0.00106870","open":"0.00107410","high":"0.00107910","low":"0.00106700","volume":"132.85915205","openTime":1518634800000,"closeTime":1518638399999},{"close":"0.00107160","open":"0.00106870","high":"0.00107200","low":"0.00106600","volume":"113.35163303","openTime":1518638400000,"closeTime":1518641999999},{"close":"0.00107000","open":"0.00107140","high":"0.00107370","low":"0.00106350","volume":"116.64666927","openTime":1518642000000,"closeTime":1518645599999},{"close":"0.00106970","open":"0.00107120","high":"0.00107400","low":"0.00106100","volume":"97.52650711","openTime":1518645600000,"closeTime":1518649199999},{"close":"0.00110100","open":"0.00106960","high":"0.00112470","low":"0.00106950","volume":"226.96643457","openTime":1518649200000,"closeTime":1518652799999},{"close":"0.00108130","open":"0.00109880","high":"0.00110760","low":"0.00107300","volume":"163.00347206","openTime":1518652800000,"closeTime":1518656399999},{"close":"0.00108430","open":"0.00108130","high":"0.00109550","low":"0.00108010","volume":"113.27805972","openTime":1518656400000,"closeTime":1518659999999},{"close":"0.00109680","open":"0.00108410","high":"0.00109730","low":"0.00107800","volume":"132.82635430","openTime":1518660000000,"closeTime":1518663599999},{"close":"0.00109660","open":"0.00109680","high":"0.00110860","low":"0.00108410","volume":"170.66111909","openTime":1518663600000,"closeTime":1518667199999},{"close":"0.00108920","open":"0.00109660","high":"0.00110000","low":"0.00108630","volume":"119.07540604","openTime":1518667200000,"closeTime":1518670799999},{"close":"0.00110590","open":"0.00108910","high":"0.00111360","low":"0.00108800","volume":"178.49778375","openTime":1518670800000,"closeTime":1518674399999},{"close":"0.00110650","open":"0.00110710","high":"0.00111260","low":"0.00109710","volume":"103.56203171","openTime":1518674400000,"closeTime":1518677999999},{"close":"0.00111480","open":"0.00110610","high":"0.00111520","low":"0.00109840","volume":"87.60808219","openTime":1518678000000,"closeTime":1518681599999},{"close":"0.00114280","open":"0.00111490","high":"0.00114670","low":"0.00111330","volume":"291.70313366","openTime":1518681600000,"closeTime":1518685199999},{"close":"0.00111150","open":"0.00114290","high":"0.00114330","low":"0.00110780","volume":"174.89351413","openTime":1518685200000,"closeTime":1518688799999},{"close":"0.00111760","open":"0.00111110","high":"0.00113000","low":"0.00108000","volume":"202.33270978","openTime":1518688800000,"closeTime":1518692399999},{"close":"0.00111040","open":"0.00111760","high":"0.00113890","low":"0.00109550","volume":"165.43828489","openTime":1518692400000,"closeTime":1518695999999},{"close":"0.00110640","open":"0.00111040","high":"0.00112000","low":"0.00110400","volume":"80.51930433","openTime":1518696000000,"closeTime":1518699599999},{"close":"0.00108510","open":"0.00110640","high":"0.00110790","low":"0.00108210","volume":"105.64183994","openTime":1518699600000,"closeTime":1518703199999},{"close":"0.00111020","open":"0.00108540","high":"0.00111350","low":"0.00108500","volume":"115.55221165","openTime":1518703200000,"closeTime":1518706799999},{"close":"0.00110220","open":"0.00111020","high":"0.00111200","low":"0.00109000","volume":"104.10816905","openTime":1518706800000,"closeTime":1518710399999},{"close":"0.00108360","open":"0.00110200","high":"0.00110280","low":"0.00108000","volume":"110.46818738","openTime":1518710400000,"closeTime":1518713999999},{"close":"0.00107930","open":"0.00108360","high":"0.00108740","low":"0.00107500","volume":"113.92870880","openTime":1518714000000,"closeTime":1518717599999},{"close":"0.00108960","open":"0.00107850","high":"0.00110210","low":"0.00107770","volume":"173.38614817","openTime":1518717600000,"closeTime":1518721199999},{"close":"0.00108350","open":"0.00108960","high":"0.00109000","low":"0.00107560","volume":"87.37345456","openTime":1518721200000,"closeTime":1518724799999},{"close":"0.00106790","open":"0.00108340","high":"0.00108410","low":"0.00106510","volume":"95.14152341","openTime":1518724800000,"closeTime":1518728399999},{"close":"0.00107220","open":"0.00106720","high":"0.00109790","low":"0.00105980","volume":"220.85599381","openTime":1518728400000,"closeTime":1518731999999},{"close":"0.00104060","open":"0.00104790","high":"0.00104800","low":"0.00103880","volume":"81.01186226","openTime":1518552000000,"closeTime":1518555599999},{"close":"0.00104220","open":"0.00104020","high":"0.00104230","low":"0.00103640","volume":"73.72795708","openTime":1518555600000,"closeTime":1518559199999},{"close":"0.00104720","open":"0.00104220","high":"0.00104900","low":"0.00104100","volume":"98.93361388","openTime":1518559200000,"closeTime":1518562799999},{"close":"0.00105500","open":"0.00104740","high":"0.00105560","low":"0.00104060","volume":"135.14113560","openTime":1518562800000,"closeTime":1518566399999},{"close":"0.00105050","open":"0.00105510","high":"0.00106000","low":"0.00104600","volume":"90.99297372","openTime":1518566400000,"closeTime":1518569999999},{"close":"0.00104180","open":"0.00104970","high":"0.00105170","low":"0.00104000","volume":"78.18474625","openTime":1518570000000,"closeTime":1518573599999},{"close":"0.00104010","open":"0.00104180","high":"0.00104520","low":"0.00103890","volume":"72.25559557","openTime":1518573600000,"closeTime":1518577199999},{"close":"0.00104300","open":"0.00103900","high":"0.00104620","low":"0.00103860","volume":"70.30792588","openTime":1518577200000,"closeTime":1518580799999},{"close":"0.00104470","open":"0.00104300","high":"0.00104700","low":"0.00104000","volume":"71.69209134","openTime":1518580800000,"closeTime":1518584399999},{"close":"0.00104730","open":"0.00104470","high":"0.00104820","low":"0.00104090","volume":"86.08849105","openTime":1518584400000,"closeTime":1518587999999},{"close":"0.00104170","open":"0.00104740","high":"0.00104940","low":"0.00103910","volume":"69.05388529","openTime":1518588000000,"closeTime":1518591599999},{"close":"0.00104060","open":"0.00104170","high":"0.00104220","low":"0.00103280","volume":"79.03965024","openTime":1518591600000,"closeTime":1518595199999},{"close":"0.00104270","open":"0.00103940","high":"0.00104530","low":"0.00103920","volume":"77.94509868","openTime":1518595200000,"closeTime":1518598799999},{"close":"0.00103800","open":"0.00104320","high":"0.00104450","low":"0.00103800","volume":"81.07701973","openTime":1518598800000,"closeTime":1518602399999},{"close":"0.00104130","open":"0.00103810","high":"0.00104390","low":"0.00103650","volume":"81.27937224","openTime":1518602400000,"closeTime":1518605999999},{"close":"0.00103780","open":"0.00104130","high":"0.00104240","low":"0.00103740","volume":"72.99417186","openTime":1518606000000,"closeTime":1518609599999},{"close":"0.00103780","open":"0.00103790","high":"0.00103850","low":"0.00102470","volume":"107.30330367","openTime":1518609600000,"closeTime":1518613199999},{"close":"0.00103670","open":"0.00103780","high":"0.00104600","low":"0.00103350","volume":"111.38408602","openTime":1518613200000,"closeTime":1518616799999},{"close":"0.00104490","open":"0.00103670","high":"0.00104600","low":"0.00103400","volume":"89.08075304","openTime":1518616800000,"closeTime":1518620399999},{"close":"0.00105340","open":"0.00104470","high":"0.00105800","low":"0.00104020","volume":"102.41755125","openTime":1518620400000,"closeTime":1518623999999},{"close":"0.00106470","open":"0.00105340","high":"0.00109800","low":"0.00105100","volume":"259.11473697","openTime":1518624000000,"closeTime":1518627599999},{"close":"0.00106660","open":"0.00106470","high":"0.00108000","low":"0.00106180","volume":"152.71368248","openTime":1518627600000,"closeTime":1518631199999},{"close":"0.00107430","open":"0.00106550","high":"0.00107660","low":"0.00105500","volume":"160.94900321","openTime":1518631200000,"closeTime":1518634799999},{"close":"0.00106870","open":"0.00107410","high":"0.00107910","low":"0.00106700","volume":"132.85915205","openTime":1518634800000,"closeTime":1518638399999},{"close":"0.00107160","open":"0.00106870","high":"0.00107200","low":"0.00106600","volume":"113.35163303","openTime":1518638400000,"closeTime":1518641999999},{"close":"0.00107000","open":"0.00107140","high":"0.00107370","low":"0.00106350","volume":"116.64666927","openTime":1518642000000,"closeTime":1518645599999},{"close":"0.00106970","open":"0.00107120","high":"0.00107400","low":"0.00106100","volume":"97.52650711","openTime":1518645600000,"closeTime":1518649199999},{"close":"0.00110100","open":"0.00106960","high":"0.00112470","low":"0.00106950","volume":"226.96643457","openTime":1518649200000,"closeTime":1518652799999},{"close":"0.00108130","open":"0.00109880","high":"0.00110760","low":"0.00107300","volume":"163.00347206","openTime":1518652800000,"closeTime":1518656399999},{"close":"0.00108430","open":"0.00108130","high":"0.00109550","low":"0.00108010","volume":"113.27805972","openTime":1518656400000,"closeTime":1518659999999},{"close":"0.00109680","open":"0.00108410","high":"0.00109730","low":"0.00107800","volume":"132.82635430","openTime":1518660000000,"closeTime":1518663599999},{"close":"0.00109660","open":"0.00109680","high":"0.00110860","low":"0.00108410","volume":"170.66111909","openTime":1518663600000,"closeTime":1518667199999},{"close":"0.00108920","open":"0.00109660","high":"0.00110000","low":"0.00108630","volume":"119.07540604","openTime":1518667200000,"closeTime":1518670799999},{"close":"0.00110590","open":"0.00108910","high":"0.00111360","low":"0.00108800","volume":"178.49778375","openTime":1518670800000,"closeTime":1518674399999},{"close":"0.00110650","open":"0.00110710","high":"0.00111260","low":"0.00109710","volume":"103.56203171","openTime":1518674400000,"closeTime":1518677999999},{"close":"0.00111480","open":"0.00110610","high":"0.00111520","low":"0.00109840","volume":"87.60808219","openTime":1518678000000,"closeTime":1518681599999},{"close":"0.00114280","open":"0.00111490","high":"0.00114670","low":"0.00111330","volume":"291.70313366","openTime":1518681600000,"closeTime":1518685199999},{"close":"0.00111150","open":"0.00114290","high":"0.00114330","low":"0.00110780","volume":"174.89351413","openTime":1518685200000,"closeTime":1518688799999},{"close":"0.00111760","open":"0.00111110","high":"0.00113000","low":"0.00108000","volume":"202.33270978","openTime":1518688800000,"closeTime":1518692399999},{"close":"0.00111040","open":"0.00111760","high":"0.00113890","low":"0.00109550","volume":"165.43828489","openTime":1518692400000,"closeTime":1518695999999},{"close":"0.00110640","open":"0.00111040","high":"0.00112000","low":"0.00110400","volume":"80.51930433","openTime":1518696000000,"closeTime":1518699599999},{"close":"0.00108510","open":"0.00110640","high":"0.00110790","low":"0.00108210","volume":"105.64183994","openTime":1518699600000,"closeTime":1518703199999},{"close":"0.00111020","open":"0.00108540","high":"0.00111350","low":"0.00108500","volume":"115.55221165","openTime":1518703200000,"closeTime":1518706799999},{"close":"0.00110220","open":"0.00111020","high":"0.00111200","low":"0.00109000","volume":"104.10816905","openTime":1518706800000,"closeTime":1518710399999},{"close":"0.00108360","open":"0.00110200","high":"0.00110280","low":"0.00108000","volume":"110.46818738","openTime":1518710400000,"closeTime":1518713999999},{"close":"0.00107930","open":"0.00108360","high":"0.00108740","low":"0.00107500","volume":"113.92870880","openTime":1518714000000,"closeTime":1518717599999},{"close":"0.00108960","open":"0.00107850","high":"0.00110210","low":"0.00107770","volume":"173.38614817","openTime":1518717600000,"closeTime":1518721199999},{"close":"0.00108350","open":"0.00108960","high":"0.00109000","low":"0.00107560","volume":"87.37345456","openTime":1518721200000,"closeTime":1518724799999},{"close":"0.00106790","open":"0.00108340","high":"0.00108410","low":"0.00106510","volume":"95.14152341","openTime":1518724800000,"closeTime":1518728399999},{"close":"0.00107220","open":"0.00106720","high":"0.00109790","low":"0.00105980","volume":"220.85599381","openTime":1518728400000,"closeTime":1518731999999},{"close":"0.00104060","open":"0.00104790","high":"0.00104800","low":"0.00103880","volume":"81.01186226","openTime":1518552000000,"closeTime":1518555599999},{"close":"0.00104220","open":"0.00104020","high":"0.00104230","low":"0.00103640","volume":"73.72795708","openTime":1518555600000,"closeTime":1518559199999},{"close":"0.00104720","open":"0.00104220","high":"0.00104900","low":"0.00104100","volume":"98.93361388","openTime":1518559200000,"closeTime":1518562799999},{"close":"0.00105500","open":"0.00104740","high":"0.00105560","low":"0.00104060","volume":"135.14113560","openTime":1518562800000,"closeTime":1518566399999},{"close":"0.00105050","open":"0.00105510","high":"0.00106000","low":"0.00104600","volume":"90.99297372","openTime":1518566400000,"closeTime":1518569999999},{"close":"0.00104180","open":"0.00104970","high":"0.00105170","low":"0.00104000","volume":"78.18474625","openTime":1518570000000,"closeTime":1518573599999},{"close":"0.00104010","open":"0.00104180","high":"0.00104520","low":"0.00103890","volume":"72.25559557","openTime":1518573600000,"closeTime":1518577199999},{"close":"0.00104300","open":"0.00103900","high":"0.00104620","low":"0.00103860","volume":"70.30792588","openTime":1518577200000,"closeTime":1518580799999},{"close":"0.00104470","open":"0.00104300","high":"0.00104700","low":"0.00104000","volume":"71.69209134","openTime":1518580800000,"closeTime":1518584399999},{"close":"0.00104730","open":"0.00104470","high":"0.00104820","low":"0.00104090","volume":"86.08849105","openTime":1518584400000,"closeTime":1518587999999},{"close":"0.00104170","open":"0.00104740","high":"0.00104940","low":"0.00103910","volume":"69.05388529","openTime":1518588000000,"closeTime":1518591599999},{"close":"0.00104060","open":"0.00104170","high":"0.00104220","low":"0.00103280","volume":"79.03965024","openTime":1518591600000,"closeTime":1518595199999},{"close":"0.00104270","open":"0.00103940","high":"0.00104530","low":"0.00103920","volume":"77.94509868","openTime":1518595200000,"closeTime":1518598799999},{"close":"0.00103800","open":"0.00104320","high":"0.00104450","low":"0.00103800","volume":"81.07701973","openTime":1518598800000,"closeTime":1518602399999},{"close":"0.00104130","open":"0.00103810","high":"0.00104390","low":"0.00103650","volume":"81.27937224","openTime":1518602400000,"closeTime":1518605999999},{"close":"0.00103780","open":"0.00104130","high":"0.00104240","low":"0.00103740","volume":"72.99417186","openTime":1518606000000,"closeTime":1518609599999},{"close":"0.00103780","open":"0.00103790","high":"0.00103850","low":"0.00102470","volume":"107.30330367","openTime":1518609600000,"closeTime":1518613199999},{"close":"0.00103670","open":"0.00103780","high":"0.00104600","low":"0.00103350","volume":"111.38408602","openTime":1518613200000,"closeTime":1518616799999},{"close":"0.00104490","open":"0.00103670","high":"0.00104600","low":"0.00103400","volume":"89.08075304","openTime":1518616800000,"closeTime":1518620399999},{"close":"0.00105340","open":"0.00104470","high":"0.00105800","low":"0.00104020","volume":"102.41755125","openTime":1518620400000,"closeTime":1518623999999},{"close":"0.00106470","open":"0.00105340","high":"0.00109800","low":"0.00105100","volume":"259.11473697","openTime":1518624000000,"closeTime":1518627599999},{"close":"0.00106660","open":"0.00106470","high":"0.00108000","low":"0.00106180","volume":"152.71368248","openTime":1518627600000,"closeTime":1518631199999},{"close":"0.00107430","open":"0.00106550","high":"0.00107660","low":"0.00105500","volume":"160.94900321","openTime":1518631200000,"closeTime":1518634799999},{"close":"0.00106870","open":"0.00107410","high":"0.00107910","low":"0.00106700","volume":"132.85915205","openTime":1518634800000,"closeTime":1518638399999},{"close":"0.00107160","open":"0.00106870","high":"0.00107200","low":"0.00106600","volume":"113.35163303","openTime":1518638400000,"closeTime":1518641999999},{"close":"0.00107000","open":"0.00107140","high":"0.00107370","low":"0.00106350","volume":"116.64666927","openTime":1518642000000,"closeTime":1518645599999},{"close":"0.00106970","open":"0.00107120","high":"0.00107400","low":"0.00106100","volume":"97.52650711","openTime":1518645600000,"closeTime":1518649199999},{"close":"0.00110100","open":"0.00106960","high":"0.00112470","low":"0.00106950","volume":"226.96643457","openTime":1518649200000,"closeTime":1518652799999},{"close":"0.00108130","open":"0.00109880","high":"0.00110760","low":"0.00107300","volume":"163.00347206","openTime":1518652800000,"closeTime":1518656399999},{"close":"0.00108430","open":"0.00108130","high":"0.00109550","low":"0.00108010","volume":"113.27805972","openTime":1518656400000,"closeTime":1518659999999},{"close":"0.00109680","open":"0.00108410","high":"0.00109730","low":"0.00107800","volume":"132.82635430","openTime":1518660000000,"closeTime":1518663599999},{"close":"0.00109660","open":"0.00109680","high":"0.00110860","low":"0.00108410","volume":"170.66111909","openTime":1518663600000,"closeTime":1518667199999},{"close":"0.00108920","open":"0.00109660","high":"0.00110000","low":"0.00108630","volume":"119.07540604","openTime":1518667200000,"closeTime":1518670799999},{"close":"0.00110590","open":"0.00108910","high":"0.00111360","low":"0.00108800","volume":"178.49778375","openTime":1518670800000,"closeTime":1518674399999},{"close":"0.00110650","open":"0.00110710","high":"0.00111260","low":"0.00109710","volume":"103.56203171","openTime":1518674400000,"closeTime":1518677999999},{"close":"0.00111480","open":"0.00110610","high":"0.00111520","low":"0.00109840","volume":"87.60808219","openTime":1518678000000,"closeTime":1518681599999},{"close":"0.00114280","open":"0.00111490","high":"0.00114670","low":"0.00111330","volume":"291.70313366","openTime":1518681600000,"closeTime":1518685199999},{"close":"0.00111150","open":"0.00114290","high":"0.00114330","low":"0.00110780","volume":"174.89351413","openTime":1518685200000,"closeTime":1518688799999},{"close":"0.00111760","open":"0.00111110","high":"0.00113000","low":"0.00108000","volume":"202.33270978","openTime":1518688800000,"closeTime":1518692399999},{"close":"0.00111040","open":"0.00111760","high":"0.00113890","low":"0.00109550","volume":"165.43828489","openTime":1518692400000,"closeTime":1518695999999},{"close":"0.00110640","open":"0.00111040","high":"0.00112000","low":"0.00110400","volume":"80.51930433","openTime":1518696000000,"closeTime":1518699599999},{"close":"0.00108510","open":"0.00110640","high":"0.00110790","low":"0.00108210","volume":"105.64183994","openTime":1518699600000,"closeTime":1518703199999},{"close":"0.00111020","open":"0.00108540","high":"0.00111350","low":"0.00108500","volume":"115.55221165","openTime":1518703200000,"closeTime":1518706799999},{"close":"0.00110220","open":"0.00111020","high":"0.00111200","low":"0.00109000","volume":"104.10816905","openTime":1518706800000,"closeTime":1518710399999},{"close":"0.00108360","open":"0.00110200","high":"0.00110280","low":"0.00108000","volume":"110.46818738","openTime":1518710400000,"closeTime":1518713999999},{"close":"0.00107930","open":"0.00108360","high":"0.00108740","low":"0.00107500","volume":"113.92870880","openTime":1518714000000,"closeTime":1518717599999},{"close":"0.00108960","open":"0.00107850","high":"0.00110210","low":"0.00107770","volume":"173.38614817","openTime":1518717600000,"closeTime":1518721199999},{"close":"0.00108350","open":"0.00108960","high":"0.00109000","low":"0.00107560","volume":"87.37345456","openTime":1518721200000,"closeTime":1518724799999},{"close":"0.00106790","open":"0.00108340","high":"0.00108410","low":"0.00106510","volume":"95.14152341","openTime":1518724800000,"closeTime":1518728399999},{"close":"0.00107220","open":"0.00106720","high":"0.00109790","low":"0.00105980","volume":"220.85599381","openTime":1518728400000,"closeTime":1518731999999},{"close":"0.00104060","open":"0.00104790","high":"0.00104800","low":"0.00103880","volume":"81.01186226","openTime":1518552000000,"closeTime":1518555599999},{"close":"0.00104220","open":"0.00104020","high":"0.00104230","low":"0.00103640","volume":"73.72795708","openTime":1518555600000,"closeTime":1518559199999},{"close":"0.00104720","open":"0.00104220","high":"0.00104900","low":"0.00104100","volume":"98.93361388","openTime":1518559200000,"closeTime":1518562799999},{"close":"0.00105500","open":"0.00104740","high":"0.00105560","low":"0.00104060","volume":"135.14113560","openTime":1518562800000,"closeTime":1518566399999},{"close":"0.00105050","open":"0.00105510","high":"0.00106000","low":"0.00104600","volume":"90.99297372","openTime":1518566400000,"closeTime":1518569999999},{"close":"0.00104180","open":"0.00104970","high":"0.00105170","low":"0.00104000","volume":"78.18474625","openTime":1518570000000,"closeTime":1518573599999},{"close":"0.00104010","open":"0.00104180","high":"0.00104520","low":"0.00103890","volume":"72.25559557","openTime":1518573600000,"closeTime":1518577199999},{"close":"0.00104300","open":"0.00103900","high":"0.00104620","low":"0.00103860","volume":"70.30792588","openTime":1518577200000,"closeTime":1518580799999},{"close":"0.00104470","open":"0.00104300","high":"0.00104700","low":"0.00104000","volume":"71.69209134","openTime":1518580800000,"closeTime":1518584399999},{"close":"0.00104730","open":"0.00104470","high":"0.00104820","low":"0.00104090","volume":"86.08849105","openTime":1518584400000,"closeTime":1518587999999},{"close":"0.00104170","open":"0.00104740","high":"0.00104940","low":"0.00103910","volume":"69.05388529","openTime":1518588000000,"closeTime":1518591599999},{"close":"0.00104060","open":"0.00104170","high":"0.00104220","low":"0.00103280","volume":"79.03965024","openTime":1518591600000,"closeTime":1518595199999},{"close":"0.00104270","open":"0.00103940","high":"0.00104530","low":"0.00103920","volume":"77.94509868","openTime":1518595200000,"closeTime":1518598799999},{"close":"0.00103800","open":"0.00104320","high":"0.00104450","low":"0.00103800","volume":"81.07701973","openTime":1518598800000,"closeTime":1518602399999},{"close":"0.00104130","open":"0.00103810","high":"0.00104390","low":"0.00103650","volume":"81.27937224","openTime":1518602400000,"closeTime":1518605999999},{"close":"0.00103780","open":"0.00104130","high":"0.00104240","low":"0.00103740","volume":"72.99417186","openTime":1518606000000,"closeTime":1518609599999},{"close":"0.00103780","open":"0.00103790","high":"0.00103850","low":"0.00102470","volume":"107.30330367","openTime":1518609600000,"closeTime":1518613199999},{"close":"0.00103670","open":"0.00103780","high":"0.00104600","low":"0.00103350","volume":"111.38408602","openTime":1518613200000,"closeTime":1518616799999},{"close":"0.00104490","open":"0.00103670","high":"0.00104600","low":"0.00103400","volume":"89.08075304","openTime":1518616800000,"closeTime":1518620399999},{"close":"0.00105340","open":"0.00104470","high":"0.00105800","low":"0.00104020","volume":"102.41755125","openTime":1518620400000,"closeTime":1518623999999},{"close":"0.00106470","open":"0.00105340","high":"0.00109800","low":"0.00105100","volume":"259.11473697","openTime":1518624000000,"closeTime":1518627599999},{"close":"0.00106660","open":"0.00106470","high":"0.00108000","low":"0.00106180","volume":"152.71368248","openTime":1518627600000,"closeTime":1518631199999},{"close":"0.00107430","open":"0.00106550","high":"0.00107660","low":"0.00105500","volume":"160.94900321","openTime":1518631200000,"closeTime":1518634799999},{"close":"0.00106870","open":"0.00107410","high":"0.00107910","low":"0.00106700","volume":"132.85915205","openTime":1518634800000,"closeTime":1518638399999},{"close":"0.00107160","open":"0.00106870","high":"0.00107200","low":"0.00106600","volume":"113.35163303","openTime":1518638400000,"closeTime":1518641999999},{"close":"0.00107000","open":"0.00107140","high":"0.00107370","low":"0.00106350","volume":"116.64666927","openTime":1518642000000,"closeTime":1518645599999},{"close":"0.00106970","open":"0.00107120","high":"0.00107400","low":"0.00106100","volume":"97.52650711","openTime":1518645600000,"closeTime":1518649199999},{"close":"0.00110100","open":"0.00106960","high":"0.00112470","low":"0.00106950","volume":"226.96643457","openTime":1518649200000,"closeTime":1518652799999},{"close":"0.00108130","open":"0.00109880","high":"0.00110760","low":"0.00107300","volume":"163.00347206","openTime":1518652800000,"closeTime":1518656399999},{"close":"0.00108430","open":"0.00108130","high":"0.00109550","low":"0.00108010","volume":"113.27805972","openTime":1518656400000,"closeTime":1518659999999},{"close":"0.00109680","open":"0.00108410","high":"0.00109730","low":"0.00107800","volume":"132.82635430","openTime":1518660000000,"closeTime":1518663599999},{"close":"0.00109660","open":"0.00109680","high":"0.00110860","low":"0.00108410","volume":"170.66111909","openTime":1518663600000,"closeTime":1518667199999},{"close":"0.00108920","open":"0.00109660","high":"0.00110000","low":"0.00108630","volume":"119.07540604","openTime":1518667200000,"closeTime":1518670799999},{"close":"0.00110590","open":"0.00108910","high":"0.00111360","low":"0.00108800","volume":"178.49778375","openTime":1518670800000,"closeTime":1518674399999},{"close":"0.00110650","open":"0.00110710","high":"0.00111260","low":"0.00109710","volume":"103.56203171","openTime":1518674400000,"closeTime":1518677999999},{"close":"0.00111480","open":"0.00110610","high":"0.00111520","low":"0.00109840","volume":"87.60808219","openTime":1518678000000,"closeTime":1518681599999},{"close":"0.00114280","open":"0.00111490","high":"0.00114670","low":"0.00111330","volume":"291.70313366","openTime":1518681600000,"closeTime":1518685199999},{"close":"0.00111150","open":"0.00114290","high":"0.00114330","low":"0.00110780","volume":"174.89351413","openTime":1518685200000,"closeTime":1518688799999},{"close":"0.00111760","open":"0.00111110","high":"0.00113000","low":"0.00108000","volume":"202.33270978","openTime":1518688800000,"closeTime":1518692399999},{"close":"0.00111040","open":"0.00111760","high":"0.00113890","low":"0.00109550","volume":"165.43828489","openTime":1518692400000,"closeTime":1518695999999},{"close":"0.00110640","open":"0.00111040","high":"0.00112000","low":"0.00110400","volume":"80.51930433","openTime":1518696000000,"closeTime":1518699599999},{"close":"0.00108510","open":"0.00110640","high":"0.00110790","low":"0.00108210","volume":"105.64183994","openTime":1518699600000,"closeTime":1518703199999},{"close":"0.00111020","open":"0.00108540","high":"0.00111350","low":"0.00108500","volume":"115.55221165","openTime":1518703200000,"closeTime":1518706799999},{"close":"0.00110220","open":"0.00111020","high":"0.00111200","low":"0.00109000","volume":"104.10816905","openTime":1518706800000,"closeTime":1518710399999},{"close":"0.00108360","open":"0.00110200","high":"0.00110280","low":"0.00108000","volume":"110.46818738","openTime":1518710400000,"closeTime":1518713999999},{"close":"0.00107930","open":"0.00108360","high":"0.00108740","low":"0.00107500","volume":"113.92870880","openTime":1518714000000,"closeTime":1518717599999},{"close":"0.00108960","open":"0.00107850","high":"0.00110210","low":"0.00107770","volume":"173.38614817","openTime":1518717600000,"closeTime":1518721199999},{"close":"0.00108350","open":"0.00108960","high":"0.00109000","low":"0.00107560","volume":"87.37345456","openTime":1518721200000,"closeTime":1518724799999},{"close":"0.00106790","open":"0.00108340","high":"0.00108410","low":"0.00106510","volume":"95.14152341","openTime":1518724800000,"closeTime":1518728399999},{"close":"0.00107220","open":"0.00106720","high":"0.00109790","low":"0.00105980","volume":"220.85599381","openTime":1518728400000,"closeTime":1518731999999}];

TempArray_tow = <?php echo json_encode($final_arr); ?>;



var cube_percent = 4; 
// JavaScript Document
var WindowOfsetX = 100;
var WindowOfsetY = 100;

var canvas = document.getElementById("myCanvas");
var c = canvas.getContext("2d");
var cHeight = window.innerHeight;
var cWidth = window.innerWidth - WindowOfsetX;
var cOffse_right = 1;
var cOffse_left = 100;
var cOffse_top = 100;
var cOffse_bottom = 100;
canvas.height = cHeight;
canvas.width = cWidth;

var cFull_height = canvas.height;

var canvasContainerHeight = cHeight - cOffse_top - cOffse_bottom;
var canvasContainerWidth  = cWidth - cOffse_left - cOffse_right;

// Rect
/*c.fillStyle = "rgba(255,0,0,0.5)";
c.fillRect(100,100,100,100);
c.fillStyle = "rgba(0,255,0,0.5)";
c.fillRect(200,100,100,100);
c.fillStyle = "rgba(0,0,255,0.5)";
c.fillRect(300,100,100,100);*/


// Time line 



// Price line




var scroll=0;

jQuery(document).ready(function(){
	jQuery(window).scroll(function() {
        scroll = window.pageYOffset || document.documentElement.scrollTop;

    });

});




////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////



function drwTimeLine(Tlength){
	var T_LfromX = cOffse_left;
	var T_LtoX = cOffse_left;
	var T_LfromY = cOffse_top-10;
	var T_LtoY = cHeight - cOffse_bottom + (10);
	
	
		var startY = cHeight ;
	// Base Time line
	c.beginPath();
	c.moveTo(T_LfromX,T_LfromY);
	c.lineTo(T_LtoX,startY);
	c.strokeStyle="rgba(0,255,0,0.9)";
	c.stroke();


	var lineSpace = cWidth - cOffse_left - cOffse_right;
	lineSpace = lineSpace/Tlength;

	for(var i = 0; i <= Tlength; i++){
		c.beginPath();
		c.moveTo(T_LfromX+(lineSpace),T_LfromY);
		c.lineTo(T_LtoX+(lineSpace),T_LtoY);
		c.strokeStyle="rgba(200,200,200,0.2)";
		c.stroke();

		if(i != 0){
			T_LfromX +=lineSpace ;
			T_LtoX +=lineSpace;
			c.font="9px Arial";
			c.fillStyle = "#444";
			c.fillText(i+"H",T_LfromX-10,T_LtoY+30);
			//drawCandle(T_LfromX,Tlength);

		}

		jQuery(".s_time").append('<option value="'+i+'">'+i+'Hr</option>');

		

	}
	
}

function drwPriceLine(Plength){
	var P_LfromX = cOffse_left-10;
	var P_LtoX = cWidth - cOffse_right+10;
	var P_LfromY = cHeight - cOffse_bottom ;
	var P_LtoY = cHeight - cOffse_bottom ;

		
		
	// Base Price Line
		c.beginPath();
		c.moveTo(P_LfromX,P_LfromY);
		c.lineTo(P_LtoX,P_LfromY);
		c.strokeStyle="rgba(255,0,0,0.9)";
		c.stroke(); 

	var lineSpace = cHeight - cOffse_top - cOffse_bottom;
	lineSpace = lineSpace/Plength;

	for(var i = 0; i <= Plength; i++){
		c.beginPath();
		c.moveTo(P_LfromX,P_LfromY-(lineSpace*i));
		c.lineTo(P_LtoX,P_LtoY-(lineSpace*i));
		c.strokeStyle="rgba(200,200,200,0.2";
		c.stroke(); 

		//P_LfromY +=lineSpace;
		//P_LtoY +=lineSpace;
		
		c.font="5px Arial";
		c.fillStyle = "#fff";
		c.fillText("$"+i,P_LfromX-20,P_LfromY-(lineSpace*i)+2);

		jQuery(".s_high").append('<option value="'+i+'">'+i+'</option>');
		jQuery(".s_low").append('<option value="'+i+'">'+i+'</option>');
		jQuery(".s_open").append('<option value="'+i+'">'+i+'</option>');
		jQuery(".s_close").append('<option value="'+i+'">'+i+'</option>');
		
	}


	var P_divided = 100 / cube_percent;
	var P_div_form=jQuery(".Pline").val();
	var P_cl_per = P_div_form/P_divided;

	
	var linespace_dvide = cHeight - cOffse_top - cOffse_bottom;
	linespace_dvide = linespace_dvide/P_divided;
	for(var i_dv = 0; i_dv <= P_divided; i_dv++){
		var mns = i_dv*P_cl_per;
		c.beginPath();
		c.moveTo(P_LfromX,P_LfromY-(linespace_dvide*i_dv));
		c.lineTo(P_LtoX,P_LtoY-(linespace_dvide*i_dv));
		c.strokeStyle="rgba(100,100,100,0.3)";
		c.stroke(); 

		//P_LfromY +=lineSpace;
		//P_LtoY +=lineSpace;
		
		c.font="14px Arial";
		c.fillStyle = "#f00";
		c.fillText(mns,P_LfromX-60,P_LfromY-(linespace_dvide*i_dv)+2);
		
		
		console.log(P_cl_per);
	}
	
}



ToolArray = [];
function drawCandle(cd_x,cd_l,cd_high,cd_low,cd_color){
	var ToolArray_obj = {};


	var cd_time     =    cd_x;
	var cd_l        =    cd_l;
	var cd_high     =    cd_high;
	var cd_low      =    cd_low;
	var cd_color     =   cd_color;

	//alert("cd_time"+cd_time+"cd_l"+cd_l+"cd_high"+cd_high+"cd_low"+cd_low+"cd_open"+cd_open+"cd_close"+cd_close);
	//////////////////////////// Formula for calculate Ratio For Y

	var InerHeight = canvasContainerHeight;
	var total_P_length = jQuery(".Pline").val();

	var PerPriceHeight = InerHeight / total_P_length;

	var TopOffSet = cOffse_top;
	/////////////////////////////
	//////////////////////////// Formula for calculate Ratio For X

	var InerWidth = canvasContainerWidth;
	var total_T_length = cd_l; //jQuery(".Tline").val();

	var PerTimeWidth = InerWidth / total_T_length;

	var LeftOffSet = cOffse_left;
	/////////////////////////////

	var cd_xx = (PerTimeWidth*cd_x*cube_percent) + LeftOffSet;

			
	var cd_y = InerHeight - (PerPriceHeight*cd_high) + TopOffSet;

	var cd_y_b = InerHeight - (PerPriceHeight*cd_low) + TopOffSet;

	var cd_h  = cd_y_b - cd_y ; 

	var cdwr = candleSize(cd_l)*cube_percent;

		cd_w = cdwr

	var cd_x = cd_xx - (cd_w/2);

	if(cd_color == 'red'){
		cd_color = '#ff0000';
	}else{
		cd_color = '#0000ff';
	}
	
	c.fillStyle = cd_color;
	c.fillRect(cd_x,cd_y,cd_w,cd_h);
	



}


function candleSize(cd_l){
	var cd_l = cd_l;
	var cdSiz = canvasContainerWidth / cd_l;
	// 80% // cdSiz =  (80/100)*cdSiz
	cdSiz =  (100/100)*cdSiz
	jQuery(".dddd").text(cdSiz);

	return cdSiz;
}

function randerChart(){
	

	var LengthOfItems = TempArray_tow.length;
	


		jQuery(".s_time").html('');
		jQuery(".s_high").html('');
		jQuery(".s_low").html('');
		jQuery(".s_open").html('');
		jQuery(".s_close").html('');

		var Tlength = canvasContainerHeight / cube_percent;
		var Plength = jQuery(".Pline").val();
		jQuery(".pl").text(Plength);

		c.clearRect(0,0,cWidth,cFull_height);
		drwPriceLine(Plength);
		
		
		drwTimeLine(Tlength);




				var time = Tlength;
				var Price = Plength;

				
				for(indexi in TempArray_tow){
						
							var cd_high  =TempArray_tow[indexi].top;
							var cd_low    = TempArray_tow[indexi].bottom;
							var cd_color = TempArray_tow[indexi].color;

					 	var cd_x = indexi;
					 	var cd_l = time;
					 drawCandle(cd_x,cd_l,cd_high,cd_low,cd_color);
				}

}
function get_index_Value(arr){

	if(typeof arr !='undefined' && arr.length>0){
	 var newArr = {};
	 var fullArr = [];
	 for(index in arr){
	 
	 newArr[arr[index].top] = arr[index].top;
	 newArr[arr[index].bottom] = arr[index].bottom; 
	 newArr[arr[index].clor] = arr[index].color;
	 	
	 }
	 
	 for(index in newArr){
	 
	 	fullArr.push(newArr[index]);
	  
	 }
	 
	 
	 var sorArr= fullArr.sort(function(a, b){return a - b});

	 return sorArr;
	 
	}

}
requestAnimationFrame(randerChart);






function SetWidthOfCanvsBox(){
	var get_cansWidth = jQuery("canvas").width();
	jQuery("#canvasbox_X").width(get_cansWidth);
	jQuery("#canvasbox_Y").width(get_cansWidth);
	jQuery("#tooltipbox").width(get_cansWidth);
}
SetWidthOfCanvsBox();


function SetHeightOfCanvsBox(){
	
	var get_cansHeight = jQuery("canvas").height();
	//console.log(get_cansHeight+'aaa');
	jQuery("#main_time_line").css("height",get_cansHeight+"px");
	
}
SetHeightOfCanvsBox();



jQuery("body").on("click","canvas",function(){
		var yx_line_d_val = jQuery("#main_price_line .c_pdgn").text();
		var yx_line_style = jQuery("#main_price_line").attr("style");
		jQuery("#canvasbox_X").append('<div class="c_main_price_line cmpl_Red" style="'+yx_line_style+'"><div id="pdgn" class="c_pdgn">'+yx_line_d_val+'</div><span class="c_removePL">x</span></div>');
});
jQuery("body").on("click",".c_removePL",function(){
	jQuery(this).closest(".c_main_price_line").remove();		
});
function dateConvert(milliseconds){

        var dateobj = new Date(+milliseconds);
        var year = dateobj.getFullYear();
        var month= ("0" + (dateobj.getMonth()+1)).slice(-2);
        var date = ("0" + dateobj.getDate()).slice(-2);
        var hours = ("0" + dateobj.getHours()).slice(-2);
        var minutes = ("0" + dateobj.getMinutes()).slice(-2);
        var seconds = ("0" + dateobj.getSeconds()).slice(-2);
        var day = dateobj.getDay();
        var months = ["JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC"];
        var dates = ["SUN","MON","TUE","WED","THU","FRI","SAT"];
        var converted_date = "";
        converted_date = date + "-" + months[parseInt(month)-1]  + "-" +year +', ' +hours +':'+minutes+':'+seconds;

        return converted_date;
}
function findArryVal(x, ys, array){
	var respose = false;

	if(typeof array !='undefined' && array.length>0){
		for(index in array){
			if(x >= array[index].start_x && x <= array[index].end_x && ys >= array[index].start_y && ys <= array[index].end_y){

			var tooltip_html = '\
				<ul>\
					<li><strong>High:</strong> '+array[index].A_cd_high+'</li>\
					<li><strong>Low:</strong> '+array[index].A_cd_low+'</li>\
					<li><strong>Open:</strong> '+array[index].A_cd_open+'</li>\
					<li><strong>Close:</strong> '+array[index].A_cd_close+'</li>\
					<li><strong>Volume:</strong> '+array[index].A_cd_volume+'</li>\
					<li><strong>Time:</strong> '+array[index].A_cd_time+'</li>\
				</ul>\
			';	

			respose = tooltip_html;
			break;
			}else{
			respose = false;
			}
		}
	}
	return respose;
}
function findTimeCordinate(x, array){
	var respose = false;

	if(typeof array !='undefined' && array.length>0){
		for(index in array){
			if(x >= array[index].start_x && x <= array[index].end_x){

			var TimeCordinate_html = array[index].A_cd_time;	

			respose = TimeCordinate_html;
			break;
			}else{
			respose = false;
			}
		}
	}
	return respose;
}







</script>

<!-- // Content END -->

<div class="clearfix"></div>
</div>

</body></html>

<?php 
//exit;
 ?>