<?php
include_once( 'libs/simple_html_dom.php' );

//   ______   _______           _______ _________ _______  _______ 
//  (  ___ \ (  ____ \|\     /|(  ____ \\__   __/(  ____ \(  ____ )
//  | (   ) )| (    \/| )   ( || (    \/   ) (   | (    \/| (    )|
//  | (__/ / | (__    | |   | || (_____    | |   | (__    | (____)|
//  |  __ (  |  __)   ( (   ) )(_____  )   | |   |  __)   |     __)
//  | (  \ \ | (       \ \_/ /       ) |   | |   | (      | (\ (   
//  | )___) )| (____/\  \   /  /\____) |   | |   | (____/\| ) \ \__
//  |/ \___/ (_______/   \_/   \_______)   )_(   (_______/|/   \__/
//  Sebtastisk (C) 2013

    //[MASTER_URL]
    $MASTER_URL = 'https://www.google.com/search?tbm=isch';
    
    //[VALUES_FILL_IN]
    $VALUES_SEARCH = "q=";

    //[FILTER_URL]
    $FILTER_SAFE = 'safe=active';
    
    //[SETTINGS_URL_TBS]
    $SVALUES_TYPE = array("itp:face", "itp:photo", "itp:clipart", "itp:lineart", "itp:animated");
    $SVALUES_SIZE = array("isz:l", "isz:m");
    $SVALUES_COLOR = array("ic:color", "ic:gray", "ic:trans");
    $SVALUES_LICENCE = array("sur:f", "sur:fc", "sur:fm", "sur:fmc");

    //[GET_VALUES]
        //[SEARCH]
        $SEARCH = $_GET["search"];
        $TYPE = $_GET["type"];
        $SIZE = $_GET["size"];
        $COLOR = $_GET["color"];
        $LICENCE = $_GET["licence"];
        $SAFE = $_GET["safe"];

        //[GENERAL]
        $RESULT_AMOUNT = $_GET['amount'];
        $DISPLAY = $_GET['disp'];
    //[GET_VALUES]


function display()
{
    global $RESULT_AMOUNT, $DISPLAY, $SEARCH;

    if($SEARCH != null || !empty($SEARCH))
    {
        $ADRESSES = returnURLArray($SEARCH, $RESULT_AMOUNT);
        if($ADRESSES != null || !empty($ADRESSES))
        {
            switch ($DISPLAY) {
                case 'table':
                    displayTable($ADRESSES, 'false');
                break;
                case 'table_img':
                    displayTable($ADRESSES, 'true');
                break;
                case 'plain':
                    foreach ($ADRESSES as $a => $value)
                    {
                        echo $value.'<br>';
                    }
                break;
                case 'plain_img':
                    foreach ($ADRESSES as $a => $value)
                    {
                        echo '<img src="'.$value.'" height="100" width="120">';
                        echo $value.'<br>';
                    }
                break;
                 case 'json':
                    header('Content-Type: application/json');
					echo json_encode($ADRESSES);
                break;
                default:
                    displayTable($ADRESSES, 'false');
                break;
            }
        }

    }else
    {
        echo 'Search was empty.';
    }

}

function returnTest()
{
    global $SEARCH;

    $suburl = 'imgres';
    $adresse = buildUrl($SEARCH);
    echo $adresse.'<br>';
    
   if($adresse != null || $adresse != ""){

        $htmla = file_get_html($adresse); 
        foreach($htmla->find('a') as $elements)
        {
            if(stripos($elements->href, $suburl))
            {
                echo retrieveIMGUrl($elements->href).'<br>';
            }
        }
        $htmla->clear();
    }else
    {
        echo "Error";
    }
}

function buildUrl($search)
{
    global $MASTER_URL, $VALUES_SEARCH, $TYPE, $SIZE, $COLOR, $LICENCE;
   
    $search_url = "";
    if($search != null || !empty($search))
    {
        $TDS = buildTbs($TYPE, $SIZE, $COLOR, $LICENCE);
        if($SAFE != null || !empty($SAFE) || $SAFE == "1" )
        {
            if($TDS != null || $TDS != "tbs=")
            {
                $search_url = $MASTER_URL.'&'.$VALUES_SEARCH.$search.'&'.$FILTER_SAFE.'&'.$TDS;
            }else
            {
                $search_url = $MASTER_URL.'&'.$VALUES_SEARCH.$search.'&'.$FILTER_SAFE;
            }
        }
        else
        {
            if($TDS != null || $TDS != "tbs=")
            {
                $search_url = $MASTER_URL.'&'.$VALUES_SEARCH.$search.'&'.$TDS;
            }else
            {
                $search_url = $MASTER_URL.'&'.$VALUES_SEARCH.$search;
            }        
        }
    }
    print('URL: ' . $search_url);
    return $search_url;
}   

function buildTbs($type, $size, $color, $licence)
{
    global $SVALUES_TYPE, $SVALUES_SIZE, $SVALUES_COLOR, $SVALUES_LICENCE;

    $base = 'tbs=';
    if($type != null || !empty($type)){if(count($SVALUES_TYPE) >= $type){ $base = $base.$SVALUES_TYPE[$type];}}
    if($size != null || !empty($size)){ if(strlen($base) > 6){if(count($SVALUES_SIZE) >= $size){$base = $base.','.$SVALUES_SIZE[$size];}}else{if(count($SVALUES_SIZE) >= $size){$base = $base.$SVALUES_SIZE[$size];}}}
    if($color != null || !empty($color)){ if(strlen($base) > 6){if(count($SVALUES_COLOR) >= $color){$base = $base.','.$SVALUES_COLOR[$color];}}else{if(count($SVALUES_COLOR) >= $color){$base = $base.$SVALUES_COLOR[$color];}}}
    if($licence != null || !empty($licence)){ if(strlen($base) > 6){if(count($SVALUES_LICENCE) >= $licence){$base = $base.','.$SVALUES_LICENCE[$licence];}}else{if(count($SVALUES_LICENCE) >= $licence){$base = $base.$SVALUES_LICENCE[$licence];}}}
    return $base;
}

function returnURLArray($search, $amount)
{
    $array_res = array();
    $suburl = 'imgres';
    $adresse = buildUrl($search);
    $amount_url = 0;
    $_amount = $amount;

    if($_amount == null || empty($_amount)) $_amount = 0;
    if($_amount >= 15) $_amount = 15;
    if($_amount <= 0) $_amount = 0;

   if($adresse != null || !empty($adresse)){
   		
       	$htmla = file_get_html($adresse);
        print($htmla);

        foreach($htmla->find('a') as $elements)
        {
        	print($elements->href . '<br>');
            if(stripos($elements->href, $suburl))
            {
            	echo "True<br>";
                if($_amount >= $amount_url)
                {
                    $array_res[$amount_url] = retrieveIMGUrl($elements->href);
                    $amount_url = $amount_url + 1;
                }
            }
        }
        $htmla->clear();
    }else
    {
        echo "Error";
    }
   return $array_res;
}

function retrieveIMGUrl($url)
{
    if(url != null || !empty($url))
    {
        $png = ".png&";
        $jpg = ".jpg&";
        $jpeg = ".jpeg&";
        $gif = ".gif&";
        $svg = ".svg&";

        $cut_start = stripos($url, "imgurl") + 7;
        if(stripos($url, $png)) $cut_end = stripos($url, $png) + 4;
        if(stripos($url, $jpg)) $cut_end = stripos($url, $jpg) + 4;
        if(stripos($url, $jpeg)) $cut_end = stripos($url, $jpeg) + 4;
        if(stripos($url, $gif)) $cut_end = stripos($url, $gif) + 4;
        if(stripos($url, $svg)) $cut_end = stripos($url, $svg) + 4;
        $url_result = substr($url, $cut_start, $cut_end-$cut_start);
        return $url_result;
    }
    return '';
}

function displayTable($liste, $img)
{
       
       $aY = -1; // Array Y lengde
       $aX = -1; // Array X lengde

        echo "<table id='result' border='1'>";
        foreach ($liste as $rows => $row)
        {
          $aY = count($liste);  
            echo "<tr>";            
                if($img == "true") echo '<td><img src="'.$row.'" height="100" width="120"></td>';
                echo "<td>" . $row . "</td>";
            echo "</tr>";
        }
            echo "</table>";
}

display();

// FFFFFFFFFFFFFFFhHIHHIHehhehehehesDFfFE#E#EihahhahahahhahehhehhhhhhFIEIIIIIIEIe(F(#F(U34UU92349+342+924+92+4f2  :=)))

//tbs=sur:f,     <==>    labeled for reuse
//tbs=sur:fc,     <==>    labeled for commercial reuse
//tbs=sur:fm,     <==>    labeled for reuse with modification
//tbs=sur:fmc,     <==>    labeled for commercial reuse with modification