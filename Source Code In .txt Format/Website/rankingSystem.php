<?php

$current=basename($_SERVER['PHP_SELF']);
$current=strstr($current,".php",true);
if(file_exists("ranking.json")){
$json = file_get_contents("ranking.json");
$obj = json_decode($json, true);
if(isset($obj[$current])){
	$obj[$current]=$obj[$current]+1;
}else{
	$obj[$current]=1;
}

}else{
$fp = fopen("ranking.json", 'w');
	fclose($fp);	
}
$jsonString= json_encode($obj);
file_put_contents("ranking.json",$jsonString);

?>