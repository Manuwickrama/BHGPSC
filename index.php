

<!DOCTYPE html>
<html>
<head>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Manu: Add this PhP file to your page. -->
	<?php require_once('connection.php'); ?>
	<title>Title</title>
</head>
<body id="main" onload="">
<form id="form1" name="form1" method="POST" enctype="multipart/form-data" action="">

	<!-- Manu: All Input tags need a name like below and respective php tags. -->
	<input type="text" name="2017.Jan.GPSC">
	<input type="text" name="2016.Jan.GPSC" value="<?php put(2016,Jan,GPSC); ?>">
	<input type="text" name="2015.Jan.GPSC" value="<?php put(2015,Jan,GPSC); ?>">
	<input type="text" name="2014.Jan.GPSC" value="<?php put(2014,Jan,GPSC); ?>">
	<input type="text" name="2013.Jan.GPSC" value="<?php put(2013,Jan,GPSC); ?>">

	<!-- Manu: This input is hidden. Please add this to the bottom of the form. -->
	<input type="submit" name="loading" value="submit" hidden>






</form>
<script type="text/javascript">
var inputs = document.getElementsByTagName("input");
for (x = 0 ; x < inputs.length ; x++){
    myname = inputs[x].getAttribute("name");
    if(myname.indexOf("20")==0){
    	//document.write(myname);
    	var codes = myname.split(".");
    	var y = codes[0];
    	var m = codes[1];
    	var c = codes[2];
    	document.getElementsByName(myname)[0].value = <?php put(
    		2017,
    		Jan,
    		GPSC
    		); ?>;
       }
    }

document.getElementsByName('2017.Jan.GPSC')[0].value = <?php put(2017,Jan,GPSC); ?>;
</script>

</body>
</html>