<?php

//*******************************************************************
//ASX XML Display script
//*******************************************************************
function asx_xml_retrieves($asx_code, $market){
	$result=asx_prices($asx_code, $market);
	$ASX_result = unserialize($result);
    return($ASX_result);
}
//*******************************************************************
//ASX Display latest Share Price - Free
//*******************************************************************
function asx_xml_display_free($asx_code, $market){
    $ReturnString = "";
    $x=0;
	do {
		$ASX_result=asx_xml_retrieves($asx_code, $market);
		if ($ASX_result['last_price']<100){
			$asx_ok='y';
		}
		$x++;
		if ($x==100){$asx_ok='y';}
	}while($asx_ok!='y');
	
	
	
	return $ASX_result;
}


//*******************************************************************
//ASX XML Display latest Share Price
//*******************************************************************


function asx_prices($asx_code, $market){
	
	$ASX_response = asx_price_retrieve($asx_code, $market);			
	$ASX_result =  (array) $ASX_response;
	
	return serialize($ASX_result);
}


//Retrieve the latest price
function asx_price_retrieve($code, $market){
	$asx_code = strtolower(trim($code));
    	$ftime=filemtime((ABSPATH .'/wp-content/uploads/ausstocks/'.$asx_code.'/price.txt'));
        $seconds_diff = time() - $ftime;                            
        $time = ($seconds_diff/3600);
        $ftime=gmdate( "F j, Y, g:i a", $ftime);
	if ((!file_exists(ABSPATH .'/wp-content/uploads/ausstocks/'.$asx_code.'/price.txt'))OR($time>=1)){
        //Update Price File
        if (($asx_market!='ASX')AND($asx_market!='')){$market_folder=strtolower($asx_market).'/';}else{$market_folder='';}

        //path from plugins/austocks folder to uploads/austocks
        	$price_folder=ABSPATH .'/wp-content/uploads/ausstocks/'. strtolower($asx_code);
        	if (!file_exists($price_folder)) {
        	    mkdir($price_folder, 0755, true);
            }
        //Get the file
        $array = file_get_contents('https://ausstocks.com.au/wp-content/uploads/austocks/json/'.$market_folder.'price_'.strtoupper($asx_code).'.txt');
        //Store in the filesystem.
        $fp = fopen($price_folder.'/price.txt', "w");
        fwrite($fp, $array);
        fclose($fp);
	}else{
	    $array = file(site_url().'/wp-content/uploads/ausstocks/'.$asx_code.'/price.txt');
	}
	$array=substr(str_replace('\r\n','',$array[0]),1,-1);
	$output=unserialize($array);
	$resultarray = $output[strtoupper($asx_code)];
    return ($resultarray);
}
?>