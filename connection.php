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
function getCount($Type,$Year, $Month, $Clinic){
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
function getID($Type,$Year, $Month, $Clinic){
	$result = DB::queryFirstRow(
		"SELECT * FROM OnlineBookings WHERE type= %s0 AND year=%i1 AND month=%s2 AND clinic=%s3",$Type,$Year, $Month, $Clinic
		);
	return $result['id'];
}


try {
	/**
 * Function enters OR updates the existing record according
 * to the criteria. If it finds that the record has no changes,
 * it will not do anything.
 * @param  string $Type   Type of Stat
 * @param  [type] $Year    [description]
 * @param  [type] $Month   [description]
 * @param  [type] $Clinic  [description]
 * @param  [type] $ptCount [description]
 * @return [type]          [description]
 */
	function putCount($Type,$Year,$Month,$Clinic,$ptCount){
		$check = getCount($Type,$Year, $Month, $Clinic); // Returns null if not found.
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
    if ($Y!==0 && $V!==0){
	 putCount($T,$Y,$M,$C,$V);
    }
}

?>

