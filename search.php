<?php
session_start();
?>

<html>  
    <head>  
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Country Search info</title>  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
		<style>
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
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

		@keyframes spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}
		
		</style>
	</head>  
    <body align="center">  
		<div class="label">  
            <br />  
			<h2>Input a countrys name to see information</h2>
		</div>
        <div class="container">  
            <br />  
            <br />
			<div class="searching">  
				<input type="text" id="country" value=""> <br>
				<button type="button" id="search">Search Country</button>
			</div>
			
			<center><div class="loader" id="loader2"></div></center>
			
			<br/>
			<div class="table-responsive" align="center">  
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
    </body>  
</html> 

<script>

var country_data;
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
	var country_name = $('#country').val();
	
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
	
	
	
	var dataToSend = { "flag": country_data[1],
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