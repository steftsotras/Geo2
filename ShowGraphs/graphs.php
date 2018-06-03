
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
			  background-color:#934c0e;
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
				url:"country_checkbox.php",  
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
			
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            
			
			
            function drawChart() {
               
                var table=[];
               
                var e = document.getElementById("Criteria");
                var crit = e.options[e.selectedIndex].value;
               
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
               
                var dataToSend = {"criteria":crit ,"country":country};
                $.ajax({
                    type: 'POST',
                    url: 'charts_table.php',
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
						}
                       
                        datatable = new google.visualization.DataTable();
                       
                        datatable.addColumn('string', 'Country');
                        datatable.addColumn('number', crit);
                       
                        for(i=0; i<table.length; i++){
                            datatable.addRow(table[i]);
                        }  
						
						var e = document.getElementById("chartType");
						var type = e.options[e.selectedIndex].value;
						
						options = {title:type+' of '+crit,backgroundColor:'#38a2bc',width: 500, height: 400};
						
						if(type == "ColumnChart"){
							chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
							chart.draw(datatable, options);
						}
						else if(type == "PieChart"){
							chart = new google.visualization.PieChart(document.getElementById('chart_div'));
							chart.draw(datatable, options);  
						}
						else if(type == "BarChart"){
							chart = new google.visualization.BarChart(document.getElementById('chart_div'));
							chart.draw(datatable, options);
						}
                       
                    }
                });
           
               
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
		<br>
		<center><div style="min-width: 440px;">
		<div class="left_div" align="center">
        <form action = "" id = "form1" method = "post">
            <select name = "chartType" form ="form1" id = "chartType">
                <option value = "">Select Chart Type </option>
                <option value = "ColumnChart">Column Chart</option>
                <option value = "PieChart">Pie Chart</option>
                <option value = "BarChart">Bar Chart</option>  
            </select>
            <br>
            <select name = "Criteria" form = "form1" id = "Criteria">
                <option value = "">Select Criteria</option>
                <option value = "area">Area</option>
                <option value = "pop">Population</option>
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
        <button id="draw">Draw Chart</button>
        
       </div>
	   <br>
	   <br>
	   <div>
			<div id="chart_div"></div>
		
	   </div>
	   
	   </div></center>
    </body>
   
</html>