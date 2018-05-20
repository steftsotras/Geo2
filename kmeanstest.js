(function(){
var countries = [["Australia", -35.3081, 149.124],["France", 48.85, 2.35],["Germany", 52.517, 13.383],["Greece", 37.967, 23.717]];
var tobe = countries.slice();
console.log(tobe);
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
    
}

})();

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