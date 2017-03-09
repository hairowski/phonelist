<?php

$var_date = time (); 
$date_add = date("H:i:s",$var_date);



if($date_add>='07:00:00' and $date_add<='19:00:00') {
			

$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
$url = 'https://secure.sunhotels.net/maker/inlogged.asp';
$params = 'loginname=179198&password=32123';



$fields = array(
            'Username'=>urlencode('screen'),
            'Password'=>urlencode('LiveBookings_92'),
            'subbutton'=>urlencode('Login'),
			'Login'=>urlencode('1')
        );

//url-ify the data for the POST
$fields_string = '';
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string,'&');

$_SERVER['REMOTE_ADDR']='https://secure.sunhotels.net/maker/';
$ch = curl_init() or die(curl_error());
curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com");
curl_setopt($ch, CURLOPT_USERAGENT, $useragent); 
curl_setopt($ch, CURLOPT_REFERER, 'https://secure.sunhotels.net');
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_POST,count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'test.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, 'test.txt');
$http_data = curl_exec($ch); //hit the $url
$curl_info = curl_getinfo($ch);
$headers = substr($http_data, 0, $curl_info['header_size']); //split out header
//$data1=curl_exec($ch) or die(curl_error()); 
////echo $http_data; 

//echo "<pre>";
//print_r($curl_info);

if (!($curl_info['http_code']>299 && $curl_info['http_code']<309)) {
  //return, echo, die, whatever you like
  //return 'Error - http code'.$curl_info['http_code'].' received.';
}

preg_match("!\r\n(?:Location|URI): *(.*?) *\r\n!", $headers, $matches);

$fields = array(
            'SQL'=>urlencode("SELECT TOP 10 H.id,H.hotelname,B.id,B.dateadded,
CASE WHEN HC.GLatNew IS NULL THEN HC.GLat
ELSE HC.GLatNew
END AS Latitude,
CASE WHEN HC.GLngNew IS NULL THEN HC.GLng
ELSE HC.GLngNew
END AS Longitude 
FROM bookings B
INNER JOIN rooms R ON B.roomId=R.ID
INNER JOIN dbo.hotel H ON R.hotelId=H.id
INNER JOIN dbo.HotelCoordinates HC ON H.id=HC.HotelID 
--WHERE B.dateadded>=dateadd(minute, -10, getdate()) 
ORDER BY B.dateAdded DESC"),
            'maxRows'=>urlencode('10'),
            'timeout'=>urlencode('30')
        );
		
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string,'&');
		
// SQL
$url = 'https://secure.sunhotels.net/maker/sql.asp';
$ch = curl_init() or die(curl_error());
curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com");
curl_setopt($ch, CURLOPT_USERAGENT, $useragent); 
curl_setopt($ch, CURLOPT_REFERER, 'https://secure.sunhotels.net');
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POST,count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'test.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, 'test.txt');
$http_data4 = curl_exec($ch); //hit the $url
$curl_info4 = curl_getinfo($ch);
$headers = substr($http_data4, 0, $curl_info['header_size']); //split out header
//$data1=curl_exec($ch) or die(curl_error()); 

	//echo $http_data4;
	//echo "<p>";


	//echo curl_error($ch); 
	curl_close($ch); 

		$result = str_replace("&nbsp","",$http_data4);
		$result = str_replace(";","",$result);
		$result = ltrim($result);
		$result = rtrim($result);
		
		//echo $result;
		
		$dom = new DomDocument();
		@$dom->loadHTML($result); // Load HTML code:
		$xpath = new DOMXPath($dom);
	  
		// HOTEL / ROOMS PARSING
		$elements = ''; 
		$elements = $xpath->query("//tr");//h3/a");
		
		$count = 1;
		if (!is_null($elements)) {
			foreach ($elements as $element) {
				$data = $xpath->query("//tr[".$count."]/td");//h3/a");
				foreach($data as $d) {
					//echo $d->nodeValue . '<br>';
					$arr[$count][] = ltrim(rtrim($d->nodeValue));
				}
				$count+=1;
			}
		}
		
		//echo "<pre>";
		//print_r($arr);
	
	$i=0;

for($p=2;$p<=count($arr);$p++) {
	$locations["loc".$i] = array(
							'info'=>$arr[$p][2],
							'lat'=>str_replace(",",".",$arr[$p][5]),
							'lng'=>str_replace(",",".",$arr[$p][6])
							);
	$i+=1;
}
echo json_encode($locations);
exit();
	
//echo "<pre>";
//print_r($testLocs);

}

	
?>