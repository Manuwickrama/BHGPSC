

<!DOCTYPE html>
<html>
<head>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Manu:1 Add this PhP file to your page. -->
	<?php require_once('connection.php'); ?>
	<title>Title</title>
</head>
<body id="main" onload="">
<form id="form1" name="form1" method="POST" enctype="multipart/form-data" action="">

	<!-- Manu:2 All Input tags need a name like below and respective php tags. -->
	<input type="text" name="2017.Jan.GPSC" value="<?php put(2017,Jan,GPSC); ?>">
	<input type="text" name="2016.Jan.GPSC" value="<?php put(2016,Jan,GPSC); ?>">
	<input type="text" name="2015.Jan.GPSC" value="<?php put(2015,Jan,GPSC); ?>">
	<input type="text" name="2014.Jan.GPSC" value="<?php put(2014,Jan,GPSC); ?>">
	<input type="text" name="2013.Jan.GPSC" value="<?php put(2013,Jan,GPSC); ?>">







	<!-- Manu:3 This input is hidden. Please add this to the bottom of the form. -->
	<input type="submit" name="loading" value="submit" hidden>
</form>


</body>
</html>