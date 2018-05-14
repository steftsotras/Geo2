<html>
	
	<head>
		<title>Country Clustering</title>
		<script>
			
		</script>
		        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script>
			
			var countries = [];
			$.ajax({
				type: 'POST',
				url: 'countryGeo.php',
				success: function(result) {
					json = JSON.parse(result);
							
					var keys = Object.keys(json);
					keys.forEach(function(key){
						countries.push(json[key]);
					});
					
					console.log(countries);
				}
			});

			
			google.charts.load('current', {
				'packages':['geochart'],
				'mapsApiKey': 'AIzaSyAR8X1yiG5J8hRsPqrRJBJ5d5KGIMNd7lU'
			  });
			  google.charts.setOnLoadCallback(drawRegionsMap);

			  function drawRegionsMap() {
				var data = google.visualization.arrayToDataTable([
				  ['Country', 'Cluster'],
				  ['Germany', 1],
				  ['United States', 2],
				  ['Brazil',1],
				  ['Canada',1],
				  ['France', 1],
				  ['Russia',null]
				]);

				var options = {showTooltip: true,
								showInfoWindow: true ,
								colorAxis: {colors: ['#00853f', 'black', '#e31b23']},
								backgroundColor: '#81d4fa',
								datalessRegionColor: '#cec8ca',
								defaultColor: '#f5f5f5'
								
							};

				var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

				chart.draw(data, options);
			  }
			
			function kmeans(){
				
				
				
				
			}


		</script>
		
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
			  background-image: url("bg2.jpeg");
			  background-position: center;
			  background-repeat: no-repeat;
			  background-size: cover;

			}
		</style>
		
</head>
	
<body align='center'>
	<div class="bgimg-1">
	<br>
	<div class = "left"><a href="menu.php"><img src="back.png" height="50" width="150"/></a></div>
	<br>
	<center><div id="regions_div" style="width: 1200px; height: 700px;"></div></center>
	<div>
	
	
</body>

	
</html>
