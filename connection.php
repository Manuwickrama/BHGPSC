<?php 
/**
 * Manu: Describes the database connection settings
 * and connecting it to the meekroDB class file.
 *
 * Manu: Additional Functions are being created to make
 * things easier for HTML coding.
 */

/**
 * Manu: Database connection settings.
 */
require_once('meekrodb-master/db.class.php');
DB::$user = 'root';
DB::$password ='root';
DB::$dbName = 'GenieStat';

/**
 * Function returns an INT for the Patient Count given the criteria.
 * @param  string $Type   Type of Stat
 * @param  int $Year   Year
 * @param  enum $Month  Jan,Feb,Mar,Etc
 * @param  enum $Clinic GPSC,SMC,BHMC
 * @return int         Patient Count
 */
function getCount($Type,$Year,$Month,$Clinic){
	$result = DB::queryFirstField(
		"SELECT * FROM OnlineBookings WHERE type= %s0 AND year=%i1 AND month=%s2 AND clinic=%s3",$Type,$Year,$Month,$Clinic
		);
	return $result;
}

/**
 * Function returns the Primary Key for a record with the given
 * criteria.
 * @param  string $Type   Type of Stat
 * @param  int $Year   Year
 * @param  enum $Month  Jan,Feb,Mar,Etc
 * @param  enum $Clinic GPSC,SMC,BHMC
 * @return int         id as PK
 */
function getID($Type,$Year,$Month,$Clinic){
	$result = DB::queryFirstRow(
		"SELECT * FROM OnlineBookings WHERE type= %s0 AND year=%i1 AND month=%s2 AND clinic=%s3",$Type,$Year,$Month,$Clinic
		);
	return $result['id'];
}


try {
	/**
 * Function enters OR updates the existing record according
 * to the criteria. If it finds that the record has no changes,
 * it will not do anything.
 * @param  string $Type   Type of Stat
 * @param  int $Year    Year
 * @param  string $Month   Month code
 * @param  enum $Clinic  GPSC,SMC,BHMC
 * @param  int $ptCount Patient count
 * @return none          none
 */
	function putCount($Type,$Year,$Month,$Clinic,$ptCount){
		$check = getCount($Type,$Year,$Month,$Clinic); // Returns null if not found.
		if ($check!==$ptCount){
			$id = getID($Type,$Year,$Month,$Clinic); // Returns null if not found.
			// Manu: The replace function will insert a new record with
			// a unique PK as id if one isn't found.
			DB::replace('OnlineBookings', array(
			  'id' => $id,
			  'type' => $Type,
			  'year' => $Year,
			  'month' => $Month,
			  'clinic' => $Clinic,
			  'ptCount' => $ptCount
			));
		}
	}
} catch (Exception $e) {
	echo $e;
}
/**
 * Manu: Function that filters the Name tag of inputs.
 * @param  string $Tag input Name tag
 * @return array      array of input Name tags
 */
function htmlNameFilter($Tag){
	$codes = explode('_', $Tag);
	return $codes;
}
try {
	/**
	 * Manu: Outputs Patient Count.
 	 * @param  string $Type   shs,ob,tap,...
	 * @param  string $y Year as string
	 * @param  enum $m Jan,Feb,...
	 * @param  enum $c GPSC,SMC,BHMC
	 * @return int    Patient Count
	 */
	function put($t,$y,$m,$c){
		echo getCount($t,intval($y),$m,$c);
	}
} catch (Exception $e) {
	echo $e;
}

//plotData(ob,2017,Jan);
/**
 * Manu: Function to generate a single plot data sample for all clinics.
 * @param  string $t Any String
 * @param  int $y Year
 * @param  enum $m Jan,Feb,...
 * @return string    Plot Data Sample
 */
function plotData($t,$y,$m){
	echo "{";
	$mInt = monthIntoInt($m);
	echo "month: '".$y."-".$mInt."',";
	$gpscfigure = getCount($t,$y,$m,'GPSC');
	if ($gpscfigure===0) {
		$gpscfigure = 'null';
	}
	$smccfigure = getCount($t,$y,$m,'SMC');
	if ($smccfigure===0) {
		$smccfigure = 'null';
	}
	$bhmcfigure = getCount($t,$y,$m,'BHMC');
	if ($bhmcfigure===0) {
		$bhmcfigure = 'null';
	}
	echo "BHGPSC: ".$gpscfigure.",";
	echo "SMC: ".$smccfigure.",";
	echo "BHMC: ".$bhmcfigure;
	echo "}";
}

/**
 * Manu: Function only produces a single plot point for a single clinic.
 * @param  string $t Type
 * @param  int $y Year
 * @param  enum $m Month
 * @param  enum $c GPSC,SMC,BHMC
 * @return string    Plot data for Morris chart.
 */
function plotDataSingle($t,$y,$m,$c){
	echo "{";
	$mInt = monthIntoInt($m);
	echo "month: '".$y."-".$mInt."',";
	$firgure = getCount($t,$y,$m,$c);
	if ($firgure===0) {
		$firgure = 'null';
	}
	echo $c.": ".$firgure;
	echo "}";
}

//plotDataArray('shs',2017);
/**
 * Manu: Outputs Plot Data. All 3 clinics.
 * It will print out the entire plot data set for the javascript plot used.
 * @param  string $Type shs,ob,tap,...
 * @param  int $Year Year
 * @return string       Plot points string
 */
function plotDataArray($Type,$Year){
	$plotPoints = DB::query("SELECT * FROM OnlineBookings WHERE type=%s0 AND year=%i1 ORDER BY month", $Type, $Year);
	//var_dump($plotPoints);
	foreach ($plotPoints as $key => $value) {
		# code...
		$y = $value['year'];
		$m = $value['month'];
		$t = $value['type'];
		plotData($t,$y,$m);
		echo ",";
	}
}
//plotDataPerClinic('shs',2017,'BHMC');
//plotDataPerClinic('shs',2017,'GPSC');
/**
 * Manu: Outputs Plot Data for a single clinic. Remember ykeys: GPSC,SMC,BHMC
 * @param  string $Type   shs,ob,tap...
 * @param  int $Year   Year
 * @param  enum $Clinic GPSC,SMC,BHMC
 * @return string         Plot Data
 */
function plotDataPerClinic($Type,$Year,$Clinic){
	$plotPoints = DB::query("SELECT * FROM OnlineBookings WHERE type=%s0 AND year=%i1 AND clinic=%s2 ORDER BY month", $Type, $Year, $Clinic);
	//var_dump($plotPoints);
	foreach ($plotPoints as $key => $value) {
		# code...
		$y = $value['year'];
		$m = $value['month'];
		$t = $value['type'];
		plotDataSingle($t,$y,$m,$Clinic);
		echo ",";
	}
}

/**
 * Manu: Function to convert Month strings into int values.
 * Int values were required by the plot.
 * @param  enum $Month Jan,Feb,Mar,...
 * @return int    Month as Int
 */
function monthIntoInt($Month){
	switch ($Month) {
    case "Jan":
        return 1;
        break;
    case "Feb":
        return 2;
        break;
    case "Mar":
        return 3;
        break;
    case "Apr":
        return 4;
        break;
    case "May":
        return 5;
        break;
    case "Jun":
        return 6;
        break;
    case "Jul":
        return 7;
        break;
    case "Aug":
        return 8;
        break;
    case "Sep":
        return 9;
        break;
    case "Oct":
        return 10;
        break;
    case "Nov":
        return 11;
        break;
    case "Dec":
        return 12;
        break;
	}
}




/**
 * Manu: This is the loop that updates/inserts the database records.
 * @var POST
 */
//var_dump($_POST);
foreach ($_POST as $name => $value) {
	$T = htmlNameFilter($name)[0];
    $Y = intval(htmlNameFilter($name)[1]);
    $M = htmlNameFilter($name)[2];
    $C = htmlNameFilter($name)[3];
    $V = intval($value);
    if ($Y!==0 && is_numeric($value)){ // Manu: Checking to see if Year value is a string to make sure we have the correct inputs.
    	putCount($T,$Y,$M,$C,$V);
    } else {
    	if ($Y!==0 && $value==='') { // Manu: Mofified to enter '0' for Patient Count when field is left blank.
    		putCount($T,$Y,$M,$C,0);
    	}
    }
}


?>

