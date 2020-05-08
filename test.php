<html>
<body>
<?php 
	echo "Welcome to the telkom test ! <br><br>" ;
?>
<?php 
#set up param 
$url = "https://api.github.com" ; 
$username = 'nicky-mobovest';
$action = "/users/{$username}/repos" ; 
$query = http_build_query([
            'type' => 'all',
            'sort' => "created" ,
            'direction' => "asc" 
]);
$url .= $action . "?".$query ; 
#set up curl
$data = getRequest ($url); 

if ($data['status'] == 1 ){
	$list = json_decode($data['response'], true ); 
}else {
	echo $data['response']; 
}
$i = 1 ; 
#	echo print_r($list,true ); 

foreach($list as $row){
	echo "{$i}. <a href=\"https://github.com/{$username}/{$row['name']}\">{$row['full_name']}</a><br><br>" ;  
	$i++ ; 
}
#	echo print_r($list,true ); 

function getRequest ($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$retValue = curl_exec($ch);

	if (!curl_errno($ch)) {
		curl_close($ch);
		return array( 'status' => 1 ,
					  'response' => $retValue); 
	}else {
		curl_close($ch);
		return array( 'status' => 2 ,
					  'response' => "<br>Error - Bad Response <br>" . curl_getinfo($ch, CURLINFO_HTTP_CODE)); 
	}	
}


?>	
</body>
</html>