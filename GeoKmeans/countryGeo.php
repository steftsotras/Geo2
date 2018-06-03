<?php

include "../connect.php";

$sql = "SELECT ogname,lat,lon FROM countries";  
$result = mysqli_query($link, $sql) or die(mysqli_error($link));

while($row = $result->fetch_row()) {
  $rows[]=$row;
}

echo json_encode($rows);
mysqli_free_result($result);

mysqli_close($link);
?>