

<!DOCTYPE html>
<html>
<head>
	<!-- Manu: Add this PhP file to your page. -->
	<?php require_once('connection.php'); ?>
	<title>Title</title>
</head>
<body id="main" onload="">
<form id="form1" name="form1" method="POST" enctype="multipart/form-data" action="">
	<input type="number" id="2017.Jan.GPSC" name="2017.Jan.GPSC" value="<?php put(2017,Jan,GPSC); ?>">






	<!-- Manu: This input is hidden. Please add this to the bottom of the form. -->
	<input type="text" id="loaded" name="loaded"  value="YES" hidden>
</form>

<!-- Manu: Add this script to load all values, if not loaded at all.
It is testing to see the hidden input above. -->
<?php
    if ( !isset($_POST['loaded']) ) { // not submitted yet
?>
   <script>
      document.getElementById("form1").submit();
   </script>
<?php
    }
?>
</body>
</html>