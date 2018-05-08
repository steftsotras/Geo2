<?php
session_start();

#COUNTRY NAME GIVEN BY USER THROU GET
$arg = (string)$_GET["country_name"];
#PYTHON PATH ON PC
$python = "C:\\Users\\Stefanos\\AppData\\Local\\Programs\\Python\\Python36-32\\python.exe ";
#SCRIPT PATH ON PC
$script = "C:\\xampp\\htdocs\\geo\\scraping_tool.py ";

//CONCUTING THE STRINGS TOGETHER
$cmd = $python . $script . $arg;

#EXECUTE SCRIPT COLLECTING PRINTED STRINGS ON THE OUTPUT ARRAY
exec($cmd,$output);

#var_dump($output);
if($output){
$out = '  
		<br />  
        <br />
        <div class="table-responsive">  
            <table class="table-bordered" >  
                <tr>  
                    <th >Flag</th>  
                    <th >Country Name</th>  
                    <th >Capital Name</th>  
					<th >Latitude</th>
                    <th >Longitude</th>  
					<th >Area (in km^2)</th>
					<th >Population</th>
					<th >GDP</th>
					<th >HDI (Per Capita)</th>
					<th >Gini</th>
                </tr>
		';

$out .= '
		 <tr>
			 <td> <img src="https:'.$output[0].'"></td>
			 <td > <id="name" >'.$output[1].' </td>
			 <td > <id="capital" >'.$output[2].' </td>
			 <td > <id="lat" >'.$output[3].' </td>
			 <td > <id="long" >'.$output[4].' </td>
			 <td > <id="area" >'.$output[5].' </td>
			 <td > <id="pop" >'.$output[6].' </td>
			 <td > <id="gdp" >'.$output[7].' </td>
			 <td > <id="hdi" >'.$output[8].' </td>
			 <td > <id="gini" >'.$output[9].' </td>
		 </tr>
		 </table>
		</div>
		 <br/>
		';	
	
		


for($i = 0; $i<10; ++$i){
	$out .= '~';
	$out .= ''.$output[$i].'';
	
}

echo $out;

#$_SESSION['output'] = $output;
#$_SESSION['show'] = true;

}else{
	#$_SESSION['show']= false; 
	echo "Wrong input"; 
}

?>