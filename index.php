<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="eng">
<head>
	<title>Index</title>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	
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
		  background-image: url("Images/World_Map.jpg");
		  background-position: center;
		  background-repeat: no-repeat;
		  background-size: cover;

		}
		
		.table1 {
			border: 0;
			width: 225;
			border-radius: 25x;
			padding: 20px; 
		}
		
		.round{
			border-radius: 25px;
			border: 2px solid #73AD21;
			padding: 5px; 
		}
		
		.info{
			
			color:#AEFEF9;
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
	<!--<center><h2 style="Lucida Console, Monaco, monospace"> Welcome to our Page</h2></center>-->
	<br>
	<br>
	<form name="login" method="post" action="Login_Register/login.php">
	<table class="table1" align="center">
		<tr>
			<td class="round" width="219"  bgcolor="#387C0B">
				<p align="center"><font color="black"><span style="font-size:14pt;"><b>Login</b></span></font></p>
			</td>
		</tr>
		<tr>
			<td width="219">
				<table border="0" width="320" align="center">
					<tr>
						<td width="71" class="info">Username:</td>
						<td width="139"><input type="text" name="username"></td>
					</tr>
					<tr>
						<td width="71" class="info">Password:</td>
						<td width="139"><input type="password" name="password"></td>
					</tr>
					<tr>
						
						
						
					</tr>
					<tr>
						<td width="71">&nbsp;</td>
							<td width="139">
								<p align="right"><input type="submit" name="submit" value="Submit"></p>
							</td>
					</tr>
				</table>
			</td>
		</tr>
		
		<tr>
			
			<?php
			
				$out = '<td width="220"><span style="font-size:11pt;">';
				if(isset($_GET['error'])){
					if($_GET['error'] == 2){
								
						$out .= '
								 *Please write both your username and password
								';
						$_GET['error'] == 0;
					}
					else if($_GET['error'] == 1){
						$out .= '  
								 *Problem with database connection
								';
						$_GET['error'] == 0;
					}
					else if($_GET['error'] == 3){
						$out .= '  
								 *Wrong username or password
								';
						$_GET['error'] == 0;
					}
				}
				$out .= '</span></td>';	
				
				echo $out;
			?>
		</tr>
		<tr>
			<td class="round" width="219" bgcolor="#387C0B"><font color="black">Not Registered? </font><a href="Login_Register/register.php" target="_self"><font color="#29CEBE">Register</font></a><font color="#29CEBE"> </font><b><i><font color="black"> Now!</font></i></b></td>
		</tr>
	</table>
	</form>

	
	<!-- Facebook login or logout button -->
	<center><a href="javascript:void(0);" onclick="fbLogin()" id="fbLink" ><img src="Images/fblogin.png" height="80" width="330"/></a></center>

	</div>
</body>
	
<script>

window.fbAsyncInit = function() {
    // FB JavaScript SDK configuration and setup
    FB.init({
      appId      : '370867696733649', // FB App ID
      cookie     : true,  // enable cookies to allow the server to access the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.8' // use graph api version 2.8
    });
    
    // Check whether the user already logged in
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            //display user data
            getFbUserData();
        }
    });
};

// Load the JavaScript SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Facebook login with JavaScript SDK
function fbLogin() {
    FB.login(function (response) {
        if (response.authResponse) {
            // Get and display the user profile data
            getFbUserData();
        } else {
            document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
        }
    }, {scope: 'email'});
}

// Fetch the user profile data from facebook
function getFbUserData(){
    FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email'},
    function (response) {
        //document.getElementById('fbLink').setAttribute("onclick","fbLogout()");
        //document.getElementById('fbLink').innerHTML = 'Logout from Facebook';
        //document.getElementById('status').innerHTML = 'Thanks for logging in, ' + response.first_name + '!';
        
		savefbUserData(response);
		
		window.location = 'https://localhost/geo/Menu/menu.php';
		
		
		
    });
}

function savefbUserData(userData){
    $.post('fbUserData.php', {oauth_provider:'facebook',userData: JSON.stringify(userData)}, function(data){ return true; });
}


	
	
</script>
	
	