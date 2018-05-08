<?php
session_start();
?>

<head>
	<title>Register</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<style>
		
		body, html {
		  height: 100%;
		  margin: 0;
		  font: 400 15px/1.8 "Lato", sans-serif;
		  color: #777;
		}

		.bgimg-1 {
		  position: relative;
		  height: 100%;
		  background-image: url("World_Map.jpg");
		  background-position: center;
		  background-repeat: no-repeat;
		  background-size: cover;

		}
		
		.table1 {
			border: 0;
			width: 225;
			border-radius: 25px;
			padding: 20px; 
		}
		
		.round{
			
			border-radius: 25px;
			border: 2px solid #73AD21;
			padding: 5px; 
		}
		
		.info{
			
			color:#AEFEF1;
			font-size:12pt;
		}

	</style>
	
</head>

<body>

<div class="bgimg-1"> 
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>

<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] == "POST" && (isset($_POST['submit'])) && ($_POST['submit'] == 'Submit')) {

    $fname = mysqli_real_escape_string($link, $_POST['fname']);
    $lname = mysqli_real_escape_string($link, $_POST['lname']);
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, md5($_POST['password']));
    $email = mysqli_real_escape_string($link, $_POST['email']);
	
	if (empty($email) || (empty($username)) || empty($password)) {
		
		echo "<center><div class='success'>";
        echo "Πρέπει να συμπληρώσετε τα υποχρεωτικά πεδία (με τον αστερίσκο *)";
        echo "</div></center>";
		
		
        header("Location: register.php");
        exit();
    }
	
    mysqli_autocommit($link, false);

    $query = "insert into users 
                            (
                                oauth_provider,
                                username,
								password,
                                first_name,
                                last_name,
                                email,
                                created
                            ) 
                            Values
                            (
                                'original',
                                '$username',
								'$password',
                                '$fname',
                                '$lname',
                                '$email',
                                 now()
                            )";
//echo $query;
//die;
    $result = mysqli_query($link, $query);

    if ($result) {
        mysqli_commit($link);
		
		echo "<center><div class='success'>";
        echo "Τα στοιχεία σας καταχωρήθηκαν με επιτυχία";
        echo "</div></center>";
		
        header("Location: index.php");
        exit();
    } else {
        mysqli_rollback($link);
		
		echo "<center><div class='fail'>";
        echo "Εμφανίστηκε πρόβλημα στην βάση";
        echo "</div></center>";
		
    }
}
?>

    <form action="register.php" method="post">
        <table class="table1"border="0" width="225" align="center">
            <tr>
                <td class="round" width="219" bgcolor="#387C0B">
                    <p align="center"><font color="black"><span style="font-size:14pt;"><b>Registration</b></span></font></p>
                </td>
            </tr>
            <tr>
                <td width="219">
                    <table border="0" width="382" align="center">
                        <tr>
                            <td width="116" class="info">First Name:</td>
                            <td width="256"><input type="text" name="fname" maxlength="100"> </td>
                        </tr>
                        <tr>
                            <td width="116" class="info">Last Name:</td>
                            <td width="156"><input type="text" name="lname" maxlength="100"> </td>
                        </tr>
                        <tr>
                            <td width="116" class="info">Email:</span></td>
                            <td width="156"><input type="text" name="email" maxlength="100"> * </td>
                        </tr>
                        <tr>
                            <td width="116" class="info">Username:</td>
                            <td width="156"><input type="text" name="username"> * </td>
                        </tr>
                        <tr>
                            <td width="116" class="info">Password:</td>
                            <td width="156"><input type="password" name="password"> * </td>
                        </tr>
                        <tr>
                            <td width="116">&nbsp;</td>
                            <td width="156">
                                 
                                <p align="left"><input type="submit" name="submit" value="Submit"></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="round" width="219" bgcolor="#387C0B"><font color="black">Already Registered?? </font><a href="index.php" target="_self"><font color="#29CEBE">Log in</font></a><font color="#29CEBE"> </font><b><i><font color="black"> Now!</font></i></b></td>
            </tr>
        </table>
    </form>

</div>
</body>
	
</html>