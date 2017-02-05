

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
	<input type="text" name="2017.Jan.GPSC" value="<?php put(2017,Jan,GPSC); ?>">
	<input type="text" name="2016.Jan.GPSC" value="<?php put(2016,Jan,GPSC); ?>">
	<input type="text" name="2015.Jan.GPSC" value="<?php put(2015,Jan,GPSC); ?>">
	<input type="text" name="2014.Jan.GPSC" value="<?php put(2014,Jan,GPSC); ?>">
	
	<!-- Manu: This input is hidden. Please add this to the bottom of the form. -->
	<input type="submit" name="" value="submit" hidden>






</form>


</body>
</html>