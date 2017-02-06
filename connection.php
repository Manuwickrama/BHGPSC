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
 * @param  string $Clinic  Clinic code
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
	 * Manu: Function that is used in HTML (only) to output Patient Count.
 	 * @param  string $Type   Type of Stat
	 * @param  string $y Year as string
	 * @param  string $m Month
	 * @param  string $c Clinic Code
	 * @return int    Patient Count
	 */
	function put($t,$y,$m,$c){
		echo getCount($t,intval($y),$m,$c);
	}
} catch (Exception $e) {
	echo $e;
}

//plotData(ob,2017,Jan);
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

//plotDataArray();
function plotDataArray(){
	$plotPoints = DB::query("SELECT * FROM OnlineBookings ORDER BY year DESC, month DESC");
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
    if ($Y!==0){ // Manu: Checking to see if Year value is a string to make sure we have the correct inputs.
    	putCount($T,$Y,$M,$C,$V);
    }
}


?>

