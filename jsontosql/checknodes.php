<?php
// Script: Json to Sql Parser 
// written by push, ravenland.org.
// Date: 12/02/2019

if (defined('STDIN')) {
  $file = $argv[1];
} else {
  $file = $_GET['asset'];
}

$file = $argv[1];

function mysql_escape_mimic($inp) {
    if(is_array($inp))
        return array_map(__METHOD__, $inp);

    if(!empty($inp) && is_string($inp)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
    }
    return $inp;
}


$assetfile = file_get_contents("$file");
$nodefiledecode = json_decode($assetfile);

$servername = "localhost";
$username = "ravenstatus";
$password = "yoursecuremysqlpasswordgoeshere";
$dbname = "ravenstatus";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    ie("Connection failed: " . $conn->connect_error);
}

//debug
//print_r($assetfiledecode);

$n=0;
foreach ( $nodefiledecode as $node) 
{
$ip = $node[0];
$_ip = mysql_escape_mimic($ip);
$port = $node[1];
$codeversion = $node[2];
$ravenrelease = $node[3];
$timefound = $node[4];
$unknown = $node[5];
$block = $node[6];
$rdns = $node[7];
$city = $node[8];
$countrycode = $node[9];
$latitude = $node[10];
$longitude = $node[11];


// excuse the slight borkedness it doesnt affect functionality
$locality = $node[12];
$_locality = mysql_escape_mimic($locality);

$as = $node[13];
$_as = mysql_escape_mimic($as);

$isp = $node[14];
$_isp = mysql_escape_mimic($isp);


echo "$_ip $port $codeversion $ravenrelease $timefound $block $rdns $city $countrycode $latitude $longitude $locality $as $isp\n";
$n++;

$sql = "INSERT INTO nodes (ip, port, codeversion, ravenrelease, timefound, unknown, block, rdns, city, countrycode, latitude, longitude, locality, ASnumber, ISP)
VALUES ('$ip', '$port', '$codeversion', '$ravenrelease', '$timefound', '$unknown', '$block', '$rdns', '$city', '$countrycode', '$latitude', '$longitude', '$_locality', '$_as', '$_isp' )";

if ($conn->query($sql) === TRUE) {
	$last_id = $conn->insert_id;
	echo "New record created successfully. Last inserted ID is: " . $last_id;
	print "\n";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

continue;
}
$conn->close();

?>

