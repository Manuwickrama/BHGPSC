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
 * @param  int $Year   Year
 * @param  enum $Month  Jan,Feb,Mar,Etc
 * @param  enum $Clinic GPSC,SMC,BHMC
 * @return int         Patient Count
 */
function getCount($Year, $Month, $Clinic){
	$result = DB::queryFirstField(
		"SELECT * FROM OnlineBookings WHERE year=%i0 AND month=%s1 AND clinic=%s2",$Year,$Month,$Clinic
		);
	return $result;
}

/**
 * Function returns the Primary Key for a record with the given
 * criteria.
 * @param  int $Year   Year
 * @param  enum $Month  Jan,Feb,Mar,Etc
 * @param  enum $Clinic GPSC,SMC,BHMC
 * @return int         id as PK
 */
function getID($Year, $Month, $Clinic){
	$result = DB::queryFirstRow(
		"SELECT * FROM OnlineBookings WHERE year=%i0 AND month=%s1 AND clinic=%s2",$Year, $Month, $Clinic
		);
	return $result['id'];
}

/**
 * Function enters OR updates the existing record according
 * to the criteria. If it finds that the record has no changes,
 * it will not do anything.
 * @param  [type] $Year    [description]
 * @param  [type] $Month   [description]
 * @param  [type] $Clinic  [description]
 * @param  [type] $ptCount [description]
 * @return [type]          [description]
 */
try {
	function putCount($Year, $Month, $Clinic, $ptCount){
		$check = getCount($Year, $Month, $Clinic); // Returns null if not found.
		if ($check!==$ptCount){

			$id = getID($Year,$Month,$Clinic); // Returns null if not found.
			// Manu: The replace function will insert a new record with
			// a unique PK as id if one isn't found.
			DB::replace('OnlineBookings', array(
			  'id' => $id,
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

function htmlNameFilter($Tag){
	$codes = explode('_', $Tag);
	return $codes;
}

function put($y,$m,$c){
	echo getCount(intval($y),$m,$c);
}


foreach ($_POST as $name => $value) {
   $Y = intval(htmlNameFilter($name)[0]);
   $M = htmlNameFilter($name)[1];
   $C = htmlNameFilter($name)[2];
   putCount($Y,$M,$C,intval($value));
}


// foreach ($_POST as $name => $value) {
//    echo $name; // email, for example
//    echo $value; // the same as echo $_POST['email'], in this case
// }
//var_dump($_POST);
?>