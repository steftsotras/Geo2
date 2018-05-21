<html>
	
	<head>
		<title>Country Clustering</title>
		<script>
			
		</script>
		    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
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
					
					console.log(JSON.stringify(countries));
					
					//MAKING LAT LON FROM STRING TO FLOAT
					for(var j=0;j<countries.length;j++){

						countries[j][1]= parseFloat(countries[j][1]);
						countries[j][2]= parseFloat(countries[j][2]);

					}
				}
			});
			
			
			google.charts.load('current', {
			'packages':['geochart'],
			'mapsApiKey': 'AIzaSyAR8X1yiG5J8hRsPqrRJBJ5d5KGIMNd7lU'
			});
			google.charts.setOnLoadCallback(drawRegionsMap);

			function drawRegionsMap() {
				var data = new google.visualization.DataTable();

				data.addColumn('string', 'Country');
				data.addColumn('number', 'Cluster');

				for (i = 0; i <countries.length; i++)
				data.addRow(countries[i].slice(0,1).concat(null)); 

				var options = {showTooltip: true,
				showInfoWindow: true ,
				colorAxis: {colors: ['#00853f', 'black', '#e31b23']},
				backgroundColor: '#81d4fa',
				datalessRegionColor: '#cec8ca',
				defaultColor: '#f5f5f5'

				};

				var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

				chart.draw(data, options);

				kmeans(chart,options,data);
			}
			function updateChart(chart,options,dataTable,cluster1,cluster2,center1,center2) {

				var  finalarray = [];
				for(var i=0;i<cluster1.length;i++){
				finalarray = finalarray.concat([[cluster1[i][0],1]]);
				}
				for(i=0;i<cluster2.length;i++){
				finalarray = finalarray.concat([[cluster2[i][0],2]]);
				}

				console.log(JSON.stringify((finalarray)));


				for (i = 0; i <dataTable.length; i++){
				dataTable.removeRow(i);
				}
				// now add the rows.
				for (i = 0; i <finalarray.length; i++){
				dataTable.addRow(finalarray[i]);
				}
				// redraw the chart.
				chart.draw(dataTable, options);        

				}
			
			function kmeans(chart,options,data){


				var tobe = countries.slice();
				var cluster1 = [];
				var cluster2 = [];
				var clusterc1 =[];
				var clusterc2 = [];
				var d1;
				var d2;

				//Arxikopoihsh
				cluster1 = tobe.splice((Math.random()*tobe.length),1);
				cluster2 = tobe.splice((Math.random()*tobe.length),1);


				clusterc1[0] = cluster1[0][1];
				clusterc1[1] = cluster1[0][2];
				clusterc2[0] = cluster2[0][1];
				clusterc2[1] = cluster2[0][2];


				//Anathesh twn upoloipwn xwrwn
				for(var i=0;i<tobe.length;i++){
					
					d1 = distance(tobe,clusterc1,i);
					d2 = distance(tobe,clusterc2,i);
					
					
					if(d2 < d1){
						cluster2.push(tobe[i]);
					}
					else{
						cluster1.push(tobe[i]);
					}
				}

				console.clear();
				console.log(JSON.stringify((cluster1)));
				console.log(JSON.stringify((cluster2)));

				clusterc1 = newCenter(cluster1);
				clusterc2 = newCenter(cluster2);

				console.log(JSON.stringify((clusterc1)));
				console.log(JSON.stringify((clusterc2)));



				for(var t=0;t<5;t++){
						
					for(i=0;i<cluster1.length;i++){
							
						d1 = distance(cluster1,clusterc1,i);
						d2 = distance(cluster1,clusterc2,i);


						if(d2 < d1){
							cluster2 = cluster2.concat(cluster1.splice(i,1));
						}
					}
					
					for(i=0;i<cluster2.length;i++){
							
						d1 = distance(cluster2,clusterc1,i);
						d2 = distance(cluster2,clusterc2,i);


						if(d1 < d2){
							cluster1 = cluster1.concat(cluster2.splice(i,1));
						}
					}
						
					console.log("loop"+t);
					console.log(JSON.stringify((cluster1)));
						console.log(JSON.stringify((cluster2)));
						
					clusterc1 = newCenter(cluster1);
						clusterc2 = newCenter(cluster2);
					
					console.log(JSON.stringify((clusterc1)));
						console.log(JSON.stringify((clusterc2)));
					
					//GRAFIKA
					
					updateChart(chart,options,data,cluster1,cluster2,clusterc1,clusterc2);
					
					
					
				}

}

function newCenter(cluster){
		var center = [];
    center[0] = 0;
    center[1] = 0;
    
    for(var i=0;i<cluster.length;i++){
    		center[0] += cluster[i][1];
        center[1] += cluster[i][2];
    }
    center[0] = center[0]/cluster.length;
    center[1] = center[1]/cluster.length;
		
    return center;
}

function distance(cluster,center,i){
    return Math.sqrt(Math.pow((cluster[i][1] - center[0]),2) + Math.pow((cluster[i][2] - center[1]),2));
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
