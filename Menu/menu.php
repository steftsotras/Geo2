<?php session_start();

?>
<!DOCTYPE html>
<html lang="eng">
<head>
	<title>Welcome</title>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
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
		  background-image: url("../Images/bg2.jpeg");
		  background-position: center;
		  background-repeat: no-repeat;
		  background-size: cover;

		}
	</style>
</head>


<body>
	
	<div class="bgimg-1"> 
	<br>
	<br>
	<br>
	<br>
	<center><h1 style="Lucida Console, Monaco, monospace"> Hey <?php echo $_SESSION['username'];?> ! Choose something to do on our website:</h1></center>
	<br>
	<br>
	
	<table border="0" width="320" align="center">
		<tr>
			<td width="50"><img src="../Images/geo_trans.png" height="50" width="50"/></td>
			<td width="139"><a href="../Search/search.php"  id="1" >Search Country</a></td>
		</tr>
		<tr>
			<td width="50"><img src="../Images/geo_trans.png" height="50" width="50"/></td>
			<td width="139"><a href="../ShowGraphs/graphs.php"  id="2" >Show Graphs</a></td>
		</tr>
		<tr>
			<td width="50"><img src="../Images/geo_trans.png" height="50" width="50"/></td>
			<td width="139"><a href="../GeoKmeans/kmeans.php"  id="3" >Geolocation based Clustering</a></td>
		</tr>
		<tr>
			<td width="50"><img src="../Images/geo_trans.png" height="50" width="50"/></td>
			<td width="139"><a href="../BubbleKmeans/kbubble.php"  id="4" >Kmeans Bubble Chart</a></td>
		</tr>
	</table>
	
	<br>
	<br>
	<br>
	<br>
	<!-- Display logout status -->
	<center><a href="javascript:void(0);" onclick="fbLogout()" id="fbLink" style="visibility:hidden;" ><img src="../Images/fb_logout2.png" height="120" width="380"/></a></center>
	<center><a href="../index.php" id="logout" style="visibility:hidden;"><img src="../Images/logout.png" height="100" width="230"/></a></center>
	
</body>

</html>

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
            var x = document.getElementById("fbLink");
			x.style.visibility='visible';
        }else{
			var x = document.getElementById("logout");
			x.style.visibility='visible';
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


// Logout from facebook
function fbLogout() {
    FB.logout(function() {
		logout2();
    });
}

$(document).on('click', '#search', function logout2(){
	
	$.ajax({
			method:'GET',
			url:'unset_sess.php',
			success:function(data){window.location = 'https://localhost/geo/index.php';}
		});
});


</script>