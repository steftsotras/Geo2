<?php
 
include "../connect.php";
$data = json_decode(file_get_contents("php://input"));     
$crit = $data->criteria;
$cnt = $data->country;

$numOfRows = count($cnt);
for ($i = 0; $i < $numOfRows; $i++){
	$sql = "SELECT ogname," .$crit. " FROM countries WHERE ogname = '" .$cnt[$i]. "'";
	$query = mysqli_query($link, $sql) or die(mysqli_error($link));
	
	$row = $query->fetch_row();
	$rows[]=$row;
   
}
echo json_encode($rows);

mysqli_free_result($query);
mysqli_close($link);
 
   
?>