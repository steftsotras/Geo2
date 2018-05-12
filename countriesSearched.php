<?php

include "connect.php";

$sql = "SELECT ogname FROM countries";  
$result = mysqli_query($link, $sql) or die(mysqli_error($link));
while($row = $result->fetch_row()) {
  $rows[]=$row[0];
}
echo json_encode($rows);
mysqli_free_result($result);

mysqli_close($link);
?>