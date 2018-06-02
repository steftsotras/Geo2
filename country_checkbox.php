<?php
session_start();
include "connect.php";

$view = '';
$sql = "SELECT ogname FROM user_country WHERE username= '".$_SESSION['username']."' ORDER BY ogname ASC";
$sql_query = mysqli_query($link, $sql) or die (mysqli_error($link));
while($row = mysqli_fetch_assoc($sql_query)){
	$view .= '    '.$row['ogname'].'<input type = "checkbox" value = "'.$row['ogname'].'" title="'.$row['ogname'].'" name = "country[]" form ="form1" id = "country" class = "check" />' ;        
};

echo $view;      
   
mysqli_free_result($sql_query);
mysqli_close($link);
?>