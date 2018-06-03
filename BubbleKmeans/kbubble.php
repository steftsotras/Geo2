<html>
 
    <head>
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
			
			.left_div{
			  width:28%;
			  background-color:#afaa13;
			  position:relative;
			  border-radius: 25px;
			  border: 3px solid #261c1c;
			  padding: 15px; 
				
			}
			
			
			
			
		</style>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script> 
			
			$.ajax({  
				url:"../ShowGraphs/country_checkbox.php",  
				method:"GET",
				dataType: "text",
				success:function(data){  
					
					$('#live_data').html(data);
					 
				}  
			}); 
		</script>
        <script type="text/javascript">
		
		var datatable;
        var options;
        var chart;
		
		$(document).on('click', '#draw', function(){
			
			var datatable;
			
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            
			
            function drawChart() {
               
                var table=[];
               
                var e = document.getElementById("criteria1");
                var crit = e.options[e.selectedIndex].value;
				
				e = document.getElementById("criteria2");
                var crit2 = e.options[e.selectedIndex].value;
               
                var country =[];
                var j =0;
                var inputElements = document.getElementsByClassName('check');
                for(var i=0; i<inputElements.length; ++i){
                      if(inputElements[i].checked){
                           country[j] = inputElements[i].title;
                           j++;
                      }
                }
                //var country = document.querySelector('.check:checked').value;
                //var country = $('.check:checked').val();
                console.log(crit);
                console.dir(country);
               
                var dataToSend = {"criteria1":crit ,"criteria2":crit2,"country":country};
                $.ajax({
                    type: 'POST',
                    url: 'bubble_table.php',
                    data: JSON.stringify(dataToSend),
                    beforeSend: function(x) {
                        if (x && x.overrideMimeType) {
                          x.overrideMimeType("application/j-son;charset=UTF-8");
                        }
                      },
                    success: function(result) {
                       
                        console.log(result);
                        json = JSON.parse(result);
                               
                        var keys = Object.keys(json);
                        keys.forEach(function(key){
                            table.push(json[key]);
							
						
                        });
                       
                       for(var j=0;j<table.length;j++){

							table[j][1]= parseFloat(table[j][1]);
							table[j][2]= parseFloat(table[j][2]);
							table[j][3]= parseFloat(table[j][3]);
						}
                        
						
						
                        datatable = new google.visualization.DataTable();
                       
                        datatable.addColumn('string', 'ID');
                        datatable.addColumn('number', crit);
						datatable.addColumn('number', crit2);
						datatable.addColumn('number', 'Cluster');
						datatable.addColumn('number', 'Population');
                       
                        
						kmeans(table,datatable);
						
						var options = {
							title: 'Countries clustered based on '+crit+' and '+crit2,
							width: 700, height: 500,
							backgroundColor:'#d1cf9e',
							hAxis: {title: crit},
							vAxis: {title: crit2},
							colorAxis: {colors: ['green', 'red']},
							animation: {
							duration: 1000,
							easing: 'out',
							startup: true},
							bubble: {textStyle: {fontSize: 11}}
						};

						var chart = new google.visualization.BubbleChart(document.getElementById('chart_div'));
						chart.draw(datatable, options);
                       
                    }
                });
           
               
            }
			
			function finaltable(cluster1,cluster2){
				
				var  finalarray = [];
				for(var i=0;i<cluster1.length;i++){
				finalarray = finalarray.concat([[cluster1[i][0],cluster1[i][1],cluster1[i][2],1,cluster1[i][3]]]);
				}
				for(i=0;i<cluster2.length;i++){
				finalarray = finalarray.concat([[cluster2[i][0],cluster2[i][1],cluster2[i][2],2,cluster2[i][3]]]);
				}

				console.log(JSON.stringify((finalarray)));

				// now add the rows.
				for (i = 0; i <finalarray.length; i++){
				datatable.addRow(finalarray[i]);
				}
				
			}
			
			function kmeans(countries){
				
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

				var temp = clusterc1;

				for(var t=0;t<10;t++){
						
					if(t!=0 && clusterc1[0] == temp[0] && clusterc1[1] == temp[1]){
						break;
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
					
					//updateChart(chart,options,data,cluster1,cluster2,clusterc1,clusterc2);
					
					
					
				}
				
				finaltable(cluster1,cluster2);

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
				
			
			
			
        });
		
        </script>
    </head>
   
    <body>
		<div class="bgimg-1">
		<br>
		<div align ="center"><a href="../Menu/menu.php"><img src="../Images/back.png" height="50" width="150"/></a></div>
		<br>
		<br>
		<center><div style="min-width: 440px;">
		<div class="left_div" align="center">
        <form action = "" id = "form1" method = "post">
            <select name = "Criteria" form = "form1" id = "criteria1">
                <option value = "">Select 1st Criteria</option>
                <option value = "gdp">GDP</option>
                <option value = "hdi">HDI</option>
                <option value = "gini">Gini</option>
            </select>
            <br>
            <select name = "Criteria" form = "form1" id = "criteria2">
                <option value = "">Select 2nd Criteria</option>
                <option value = "gdp">GDP</option>
                <option value = "hdi">HDI</option>
                <option value = "gini">Gini</option>
            </select>
            <br>    
        </form>
		<div  style="width: 300;">  
				<div id="live_data"></div>                 
			</div>
        <br>
        <button id="draw">Draw Bubble Chart</button>
        
       </div>
	   <br>
	   <br>
	   <div>
			<div id="chart_div"></div>
		
	   </div>
	   
	   </div></center>
    </body>
   
</html>