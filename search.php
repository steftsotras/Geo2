<?php
session_start();
?>

<html>  
    <head>  
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Country Search info</title>  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
		
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	  <script>
	  $( function() {
		  
		    var availableCountries = [];
			
			$.ajax({
				type: 'POST',
				url: 'countriesSearched.php',
				success: function(result) {
					
					json = JSON.parse(result);
					
					var keys = Object.keys(json);
					keys.forEach(function(key){
						availableCountries.push(json[key]);
					});
					
				}
			});
			
			$( "#country" ).autocomplete({
			  source: availableCountries
			});
		} );
	  </script>
		
		
		
		<style>
		
		body, html {
		  height: 100%;
		  margin: 0;
		  font: 400 15px/1.8 "Lato", sans-serif;
		  color: #777;
		}
		
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
		}
		
		.round{
			border-radius: 25px;
			border: 2px solid #73AD21;
			padding: 5px; 
		}
		
		th, td {
			padding: 5px;
			text-align: center;
		}
		
		.loader {
			border: 16px solid #f3f3f3; /* Light grey */
			border-top: 16px solid #3498db; /* Blue */
			border-radius: 50%;
			width: 40px;
			height: 40px;
			animation: spin 2s linear infinite;
			display:none;
		}
		
		.bgimg-1 {
		  position: relative;
		  height: 100%;
		  background-image: url("bg2.jpeg");
		  background-position: center;
		  background-repeat: no-repeat;
		  background-size: cover;

		}

		@keyframes spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}
		
		</style>
	</head>  
	
	
    <body align="center">  
	<div class="bgimg-1"> 
		
		<br>
		<div class = "left"><a href="menu.php"><img src="back.png" height="50" width="150"/></a></div>
	
		<div class="label">  
            <br />  
			<h2>Input a countrys name to see information</h2>
		</div>
        <div class="container">  
            <br />  
            <br />
			<div class="ui-widget">  
				<input type="text" id="country" value=""> <br>
				<button type="button" id="search">Search Country</button>
			</div>
			
			<center><div class="loader" id="loader2"></div></center>
			
			<br/>
			<div class="table_responsive" align="center">  
				<div id="live_data"></div>                 
			</div>
			
			
			<div id="submit_data" style="visibility:hidden;">  
				<button type="button" id="submit">Submit Data</button>                 
			</div>
			<br>
			<div class="table-responsive" align="center">  
				<div id="live_message"></div>                 
			</div>
			
		</div>
		
		</div>
    </body>  
</html> 

<script>

var country_data;
var country_name;
//JAVASCRIPT FUNCTION TRIGGERED WHEN BUTTON IS CLICKED
$(document).on('click', '#search', function(){
	
	var x = document.getElementById("live_data");
	x.style.visibility='hidden';
	var y = document.getElementById("live_message");
	y.style.visibility='hidden';
	var z = document.getElementById("submit_data");
	z.style.visibility='hidden';
	
	var loader2 = document.getElementById("loader2");
	loader2.style.display = "block";
	
	
	//PASSING TEXT VALUE TO A VARIABLE
	country_name = $('#country').val();
	
	var show = false;
	
	//DYNAMICALLY PRESENTING FETCHED WIKIPEDIA DATA WITH AJAX
	$.ajax({  
		url:"scrap.php",  
		method:"GET",
		data:{"country_name":country_name},
		contentType: 'application/json; charset=utf-8',
		dataType: "text",
		success:function(data){  
			
			x.style.visibility='visible';
			
			loader2.style.display = "none";
			handleResponse(data);
			 
		}  
	});  
	
	
	
	
	
});


//HANDLING SUCCESSFUL AJAX RESPOND
function handleResponse(data) {
	
	
	
	var x = document.getElementById("submit_data");
	
    if(data == "Wrong input"){
		x.style.visibility='hidden';
	}
	else{
		
		country_data = data.split('~');
		
		data = country_data[0];
		x.style.visibility='visible';
	}
	$('#live_data').html(data); 
	
}


//SUBMITING DATA TO DATABASE
$(document).on('click', '#submit', function(){
	
	
	
	var dataToSend = { "ogname": country_name ,"flag": country_data[1],
								"name": country_data[2],
								"cname": country_data[3],
								"lat": country_data[4],
								"lon": country_data[5],
								"area": country_data[6],
								"pop": country_data[7],
								"gdp": country_data[8],
								"hdi": country_data[9],
								"gini": country_data[10] };
								
	//$('#live_message').html(dataToSend);
	$.ajax({  
		url:"submit.php",  
		method:"POST",
		data: JSON.stringify(dataToSend),
		beforeSend: function(x) {
            if (x && x.overrideMimeType) {
              x.overrideMimeType("application/j-son;charset=UTF-8");
            }
          },
		success:function(data){  
		
			var x = document.getElementById("live_message");
			x.style.visibility='visible';
			
			$('#live_message').html(data);  
			}  
		}); 
	
});

</script>