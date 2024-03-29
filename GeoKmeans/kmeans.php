

<html>
	
	<head>
		<title>Country Clustering</title>
		<script>
			
		</script>
		    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		
		
		<style>
			
			body, html {
			  height: 100%;
			  margin: 0;
			  font: 400 15px/1.8 "Lato", sans-serif;
			  color: #000;
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
	
<body align='center'>
	<div class="bgimg-1">
	<br>
	<div class = "left"><a href="../Menu/menu.php"><img src="../Images/back.png" height="50" width="150"/></a></div>
	<br>
	<center><div id="regions_div" style="width: 1200px; height: 700px;"></div></center>
	<div>
	<br>
	<center>
	<input id="slide" type="range" min="1000" max="10000" step="1" value="10">
	<div id="sliderAmount">Control how fast the clustering is happening</div>

	<button id="start_button"onclick="start()" >start</button>
	<button id="stop_button"onclick="stop()" style="display:none;">stop</button>
	</center>
	
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
					
					//console.log(JSON.stringify(countries));
					
					//MAKING LAT LON FROM STRING TO FLOAT
					for(var j=0;j<countries.length;j++){

						countries[j][1]= parseFloat(countries[j][1]);
						countries[j][2]= parseFloat(countries[j][2]);

					}
				}
			});
			
			
			var main_interval;
var interval_speed = 3000;
var data;
var chart;
var options;
var cluster1 = [];
var cluster2 = [];
var clusterc1 =[];
var clusterc2 = [];
var t=0;


var slide = document.getElementById('slide');
var sliderDiv = document.getElementById("sliderAmount");

slide.onchange = function() {
 		interval_speed = this.value;
    sliderDiv.innerHTML = this.value/1000 + " sec";
}


function stop(){
		window.clearInterval(main_interval);
    document.getElementById("stop_button").style.display="none";
    document.getElementById("start_button").style.display="block";
    document.getElementById("slide").style.display="block";
    document.getElementById("sliderAmount").style.display="block";
    
}

function start(){
		document.getElementById("start_button").style.display="none";
    document.getElementById("slide").style.display="none";
    document.getElementById("sliderAmount").style.display="none";
    document.getElementById("stop_button").style.display="block";
    cluster1 = [];
    cluster2 = [];
    clusterc1 =[];
    clusterc2 = [];
    t=0;
		kmeans();
}

google.charts.load('current', {
			'packages':['geochart'],
			'mapsApiKey': 'AIzaSyAR8X1yiG5J8hRsPqrRJBJ5d5KGIMNd7lU'
			});
			google.charts.setOnLoadCallback(drawRegionsMap);

			function drawRegionsMap() {
				data = new google.visualization.DataTable();

				data.addColumn('string', 'Country');
				data.addColumn('number', 'Cluster');

				for (i = 0; i <countries.length; i++)
				data.addRow(countries[i].slice(0,1).concat(null)); 

				options = {showTooltip: true,
				showInfoWindow: true ,
				colorAxis: {colors: ['#00853f', 'black', '#e31b23']},
				backgroundColor: '#81d4fa',
				datalessRegionColor: '#cec8ca',
				defaultColor: '#f5f5f5'

				};

				chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

				chart.draw(data, options);

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
			
			function kmeans(){


				var tobe = countries.slice();
				
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

				updateChart(chart,options,data,cluster1,cluster2,clusterc1,clusterc2);
				
        main_interval = window.setInterval(function(){main_kmeans();}, interval_speed);
				

}

function main_kmeans(){
		
    if(t == 4){
     stop();
    }
    
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
					t++;
          
}

function drawTable(){

		var myTableDiv = document.getElementById("table");

    var table = document.createElement('TABLE');
    table.border = '1';

    var tableBody = document.createElement('TBODY');
    table.appendChild(tableBody);

    
    var tr = document.createElement('TR');
    tableBody.appendChild(tr);


    var td = document.createElement('TD');
    td.width = '100';
    td.appendChild(document.createTextNode("Cluster 1"));
    tr.appendChild(td);
    
    var td = document.createElement('TD');
    td.width = '100';
    td.appendChild(document.createTextNode("Cluster 1"));
    tr.appendChild(td);
        
    
    myTableDiv.appendChild(table);
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
	
</body>

	
</html>



