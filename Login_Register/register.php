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
		  background-image: url("../Images/World_Map.jpg");
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
		
		/* The message box is shown when the user clicks on the password field */
		#message {
			display:none;
			background: #c4a740;
			color: #000;
			position: relative;
			padding: 10px;
			margin-top: 10px;
			width:40%;
			border-radius: 25px;
			border: 2px solid #73AD21;
		}

		#message p {
			padding: 10px 35px;
			font-size: 18px;
		}

		/* Add a green text color and a checkmark when the requirements are right */
		.valid {
			color: green;
		}

		.valid:before {
			position: relative;
			left: -35px;
			content: "✔";
		}

		/* Add a red text color and an "x" when the requirements are wrong */
		.invalid {
			color: red;
		}

		.invalid:before {
			position: relative;
			left: -35px;
			content: "✖";
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
include "../connect.php";

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
		
        header("Location: ../index.php");
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
                            <td width="256"><input type="text" name="fname" maxlength="100" required> </td>
                        </tr>
                        <tr>
                            <td width="116" class="info">Last Name:</td>
                            <td width="156"><input type="text" name="lname" maxlength="100" required> </td>
                        </tr>
                        <tr>
                            <td width="116" class="info">Email:</span></td>
                            <td width="156"><input type="text" name="email" maxlength="100" required> * </td>
                        </tr>
                        <tr>
                            <td width="116" class="info">Username:</td>
                            <td width="156"><input type="text" name="username" required> * </td>
                        </tr>
                        <tr>
                            <td width="116" class="info">Password:</td>
                            <td width="156"><input type="password" id="pass" name="password" pattern="(?=.*\W|_)(?=.*\d\d)(?=.*[A-Z][A-Z]).{6,8}" required> * </td>
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
                <td class="round" width="219" bgcolor="#387C0B"><font color="black">Already Registered?? </font><a href="../index.php" target="_self"><font color="#29CEBE">Log in</font></a><font color="#29CEBE"> </font><b><i><font color="black"> Now!</font></i></b></td>
            </tr>
        </table>
    </form>
	<center>
	<div id="message" align="left">
	  <h3>Password must contain the following:</h3>
	  <p id="special" class="invalid">A <b>special</b> character</p>
	  <p id="capital" class="invalid">Two <b>capital (uppercase)</b> letters</p>
	  <p id="number" class="invalid">Two <b>numbers</b></p>
	  <p id="length" class="invalid">Minimum <b>6 characters</b> and Maximum 8</p>
	</div>
	</center>

</div>

<script>

var myInput = document.getElementById("pass");
var special = document.getElementById("special");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
    document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
    document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  
  
  // Validate lowercase specials
  var lowerCasespecials = /\W|_/g;
  if(myInput.value.match(lowerCasespecials)) {  
    special.classList.remove("invalid");
    special.classList.add("valid");
  } else {
    special.classList.remove("valid");
    special.classList.add("invalid");
  }
  
  // Validate capital specials
  var upperCasespecials = /[A-Z][A-Z]+/g;
  if(myInput.value.match(upperCasespecials)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9][0-9]+/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 6 && myInput.value.length <= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}


</script>

</body>
	
</html>

