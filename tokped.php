<?php
$tokpedurl= 'https://www.tokopedia.com/'.$_GET['a'].'/'.$_GET['b'];

$tokped_json= IS_SCRAPPING($tokpedurl);

echo $tokped_json;



function IS_SCRAPPING($target, $cache=true){
/* PREPARE CACHED */
		if($cache){
	$filecached= sha1($target).".tmp";
	if(is_file($filecached)){
		return file_get_contents($filecached);
	}
		}
/* END PREPARE CACHED */	
$uarr= array('bingbot','yahoo sulrp','yandexbot','baidu','msnbot','Googlebot');
shuffle($uarr);	
	$data = curl_init();
	$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
	$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	$header[] = "Cache-Control: max-age=0";
	$header[] = "Connection: keep-alive";
	$header[] = "Keep-Alive: 300";
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Accept-Language: en-us,en;q=0.5";
	$header[] = "Pragma: "; // browsers keep this blank.

     curl_setopt($data, CURLOPT_SSL_VERIFYHOST, FALSE);
     curl_setopt($data, CURLOPT_SSL_VERIFYPEER, FALSE);
     curl_setopt($data, CURLOPT_URL, $target);
     curl_setopt($data, CURLOPT_USERAGENT, $uarr[array_rand($uarr)]);
	 curl_setopt($data, CURLOPT_HTTPHEADER, $header);
	 curl_setopt($data, CURLOPT_REFERER, 'https://www.google.com/search?q='.urlencode($target));
	 curl_setopt($data, CURLOPT_ENCODING, 'gzip,deflate');
	 curl_setopt($data, CURLOPT_AUTOREFERER, true);
	 curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt($data, CURLOPT_CONNECTTIMEOUT, 10);
	 curl_setopt($data, CURLOPT_TIMEOUT, 10);
	 curl_setopt($data, CURLOPT_MAXREDIRS, 3);
	 curl_setopt($data, CURLOPT_FOLLOWLOCATION, true);

     $hasil = curl_exec($data);
     curl_close($data);	
  if(!$hasil){return false;}
  
  preg_match_all("~'viewed_product' : \K.*(?=}\))~Uis", $hasil, $hashas);
  if(!isset($hashas[0][0])){ return false; }
		if($cache){
		file_put_contents($filecached, $hashas[0][0]);	
		}	
return $hashas[0][0];
}
