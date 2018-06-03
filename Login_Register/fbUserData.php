<?php
session_start();
//Load the database configuration file
include 'connect.php';

//Convert JSON data into PHP variable
$userData = json_decode($_POST['userData']);
if(!empty($userData)){
    $oauth_provider = $_POST['oauth_provider'];
    //Check whether user data already exists in database
    $prevQuery = "SELECT * FROM users WHERE oauth_provider = '".$oauth_provider."' AND username = '".$userData->id."'";

    $prevResult = $link->query($prevQuery);
    if($prevResult->num_rows > 0){ 
        //Update user data if already exists
        $query = "UPDATE users SET first_name = '".$userData->first_name."', last_name = '".$userData->last_name."', email = '".$userData->email."', modified = '".date("Y-m-d H:i:s")."' WHERE oauth_provider = '".$oauth_provider."' AND username = '".$userData->id."'";
        $update = $link->query($query);
		$_SESSION['username'] = $userData->first_name;
    }else{
        //Insert user data
        //$query = "INSERT INTO users SET oauth_provider = '".$oauth_provider."', username = '".$userData->id."', first_name = '".$userData->first_name."', last_name = '".$userData->last_name."', email = '".$userData->email."', created = '".date("Y-m-d H:i:s")."' ";
        
		$oauth_provider = mysqli_real_escape_string($link, $oauth_provider);
		$fname = mysqli_real_escape_string($link, $userData->first_name);
		$lname = mysqli_real_escape_string($link, $userData->last_name);
		$username = mysqli_real_escape_string($link, $userData->id);
		$email = mysqli_real_escape_string($link, $userData->email);
			
		mysqli_autocommit($link, false);
		
		$query = "insert into users 
                            (
                                oauth_provider,
                                username,
                                first_name,
                                last_name,
                                email,
                                created
                            )
							Values
                            (
                                '$oauth_provider',
                                '$username',
                                '$fname',
                                '$lname',
                                '$email',
                                 now()
                            )";
		
		$result = mysqli_query($link, $query);
		
		if ($result) {
        mysqli_commit($link);
		$_SESSION['username'] = $fname;
		
    } else {
        mysqli_rollback($link);
    }
		
    }
}
?>