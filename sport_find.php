<!doctype html>
<html>
<head>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css">
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script	src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOfSTwM1cDJD6mP_U1az9dsfR-mDUvE4o&signed_in=true&callback=initMap"></script>
<script src="purl.js"></script>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<style>
dt{
	color:rgb(66,134,245);
	font-size:1.3em;
	font-weight:bold;
	}
dd{
	font-size:1.1em;
	}
</style>

<script type="text/javascript">
function getEventTrigger(event) { 
    x = event.target; 
	var dataFromLi=x.innerHTML;
    $(".result_location").attr("href","map.html?data="+dataFromLi);
}
</script>
<script>
function popMap(){
	var dataFromLi=[$(this).text()];
	$(".toMap").attr("href","map.html?data="+dataFromLi);
	window.open('map.html?data='+dataFromLi,'_blank')}
</script>

</head>

<body onload="init()">
<?php
	/* echo "<h2>Acount Information</h2>";
	echo "<br>";
	echo $_POST["account"];
	echo "<br>"; */

$con = mysqli_connect("localhost","admin","admin","teamup_db");
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	// mysql_select_db("teamup_db", $con);
	$data = array();
	if (isset($_POST['date_event'])) $data['Date'] = '="'.$_POST['date_event'].'"';
	if (isset($_POST['sport_find'])) $data['Sporttype'] = '="'.$_POST['sport_find'].'"';
	if (isset($_POST['time_start'])) $data['Timebegin'] = '>="'.$_POST['time_start'].'"';
	if (isset($_POST['time_end'])) $data['Timeend'] = '<="'.$_POST['time_end'].'"';
	$conutdata = count($data);
	$where = ' ';
	if($conutdata > 0){
		$i =0;
		foreach($data as $key=>$data_val){
			if($i > 0){
				$where .= 'AND '.$key.$data_val.' ';
			}else{
				$where .= $key.$data_val.' ';
			}
			$i++;
		}
	}
	if($where == ' '){
		$sql = "SELECT * FROM Sports_Event";
	}else{
		$sql = "SELECT * FROM Sports_Event where".$where;
	}
	$null_result = mysqli_query($con, $sql);	
	$i = 0;
	while($null_row = mysqli_fetch_assoc($null_result))
	{
		$output[$i] = $null_row;
		$i++;
	}
	
	mysqli_close($con);
?>
<div data-role="page" id="find_result" > 
<div  data-role="header" data-tap-toggle="false" data-position="fixed" data-theme="b" >
			<h1>Event list</h1>
</div>
<div id="find_result_dynamic">
<?php
	if( isset($output) && is_array($output)){
		foreach($output as $val){?>
<div>

<dl>
<dt class="result_sporttype">Sport type: <?php echo $val['Sporttype']?> </dt>
<dd class="result_founder">Founder: <?php echo $val['Sporttype']?></dd>
<dd class="result_sportname">Event name: <?php echo $val['Eventname']?></dd>
<dd class="result_time">Date: <?php echo $val['Date']?></dd>
<dd class="result_time">Time: <?php echo $val['Timebegin']?></dd>
<a href="map.html" class="result_location" onClick="getEventTrigger(event)" target="_blank"> <?php echo $val['Location']?></a>

<script>


    var dataFromLi=[$(".result_location").text()];
	$(".result_location").attr("href","map.html?data="+dataFromLi);


</script>





</dl>
</div>

	<?php }}else{ ?>
Sorry, no result was found.
	<?php } ?>
</div>

<div data-role="footer"  data-id="footernav" data-tap-toggle="false" data-position="fixed"  data-theme="c">
	<div data-role="navbar">
		<ul>
			
			<li><a href="index.html#create_index" data-icon="home">Create Events</a></li>
			<li><a href="index.html#find_index" data-icon="home">Find Events</a></li>
			<li><a href="" class="ui-btn-active ui-state-persist" data-icon="home">Recent Events</a></li>
			<li><a href="index.html#profile_index" data-icon="home">Profile</a></li>
		</ul>
	</div>
</div>
</div>
</body>
</html>
