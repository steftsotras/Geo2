<?php

session_start();
include "../connect.php";


//Convert JSON data into PHP variable
$data = json_decode(file_get_contents("php://input"));
$ogname = $data->ogname;
$flag = $data->flag;
$name = $data->name;
$cname = $data->cname;
$lat = (float)$data->lat;
$lon = (float)$data->lon;
$area = (int) str_replace(",","", $data->area);
$pop = (int) str_replace(",","", $data->pop);
$gdp = (int) str_replace(",","", $data->gdp);
$hdi = (float)$data->hdi;
$gini = (float)$data->gini;



    //Check whether user data already exists in database
    $prevQuery = "SELECT * FROM countries WHERE ogname = '".$ogname."'";

    $prevResult = $link->query($prevQuery);
	
	
	
    if($prevResult->num_rows > 0){ 
        echo "Country already stored in database";
    }else{
        
		//$flag = mysqli_real_escape_string($link, $flag);
		//$name = mysqli_real_escape_string($link, $name);
		//$cname = mysqli_real_escape_string($link, $cname);
		// $lat = floatval(mysqli_real_escape_string($link, $lat));
		// $lon = floatval(mysqli_real_escape_string($link, $lon));
		// $area =  mysqli_real_escape_string($link, $area);
		// $pop = mysqli_real_escape_string($link, $pop);
		// $gdp =  mysqli_real_escape_string($link, $gdp);
		// $hdi =  floatval(mysqli_real_escape_string($link, $hdi));
		// $gini = floatval(mysqli_real_escape_string($link, $gini));
		
		
		mysqli_autocommit($link, false);
		
		$query = "insert into countries 
                            (
								ogname,
                                flag,
                                country_name,
                                capital_name,
                                lat,
                                lon,
								area,
								pop,
								gdp,
								hdi,
								gini,
                                created
                            )
							Values
                            (
								'$ogname',
                                '$flag',
                                '$name',
                                '$cname',
                                '$lat',
                                '$lon',
								'$area',
								'$pop',
								'$gdp',
								'$hdi',
								'$gini',
                                 now()
                            )";
		
		$result = mysqli_query($link, $query);
		
		if ($result) {
			mysqli_commit($link);
			echo "Country saved in database";
		
		} else {
			mysqli_rollback($link);
			echo "database failure";
		}
		
    }
	
	
	$prevquery2 = "SELECT * FROM user_country WHERE ogname = '".$ogname."' AND username = '".$_SESSION['username']."'";
	
	$prevResult2 = $link->query($prevquery2);
	
	if($prevResult2->num_rows > 0){ 
		
		echo "<br>";
		echo "Country saved already!";
	}
	else{
		
		$user = $_SESSION['username'];
    
		$query2 = "insert into user_country(username,ogname)Values('$user','$ogname')";
		$result = mysqli_query($link, $query2);
		if($result){
			mysqli_commit($link);
		}
		else{
			mysqli_rollback($link);
			echo "<br>";
			echo "Error with user_country database";
		}
	}
	
	
	

?>
