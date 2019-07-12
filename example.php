<?php

require 'simplehtmldom/simple_html_dom.php';


$url = 'https://miami.craigslist.org/search/sss?query=chair'; // enter the url craigslist to get result

$html = file_get_html($url);
$results = array();


foreach ($html->find('li[class=result-row]') as $row) 
{
    $pid = $row->getAttribute('data-pid');
    $tmp = $row->find('a[class=result-image]', 0);
    $url = $tmp->getAttribute('href');
    
    $urls = array("https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg");

    if ($tmp->getAttribute('data-ids')) {
        $cb1 = function ($a) {
            global $IMAGE_URL;
            return str_replace("IMAGE_ID", substr($a, strpos($a, "1:") + 2), $IMAGE_URL);
        };
        $urls = array_map($cb1, explode(",", $tmp->getAttribute('data-ids')));

    }

    $price = "$0";
    $tmp = $row->find('span[class=result-price]', 0);
    if ($tmp) {
        $price = $tmp->plaintext;
    }

    $date = $row->find('time[class=result-date]', 0)->plaintext;
    $title = html_entity_decode($row->find('a[class=result-title]', 0)->plaintext);
    $location = '(' . $area . ')';
    if ($row->find('span[class=result-hood]', 0)) {
        $location = trim($row->find('span[class=result-hood]', 0)->plaintext, ' ');
    } else if ($row->find('span[class=nearby]', 0)) {
        $location = html_entity_decode(trim($row->find('span[class=nearby]', 0)->plaintext));
    }


    // *********************** for the description and image start*********************************

    $html2 = file_get_html($url);

    foreach ($html2->find('p[class=print-qrcode-label]') as $row3) 
        {
            $row3->innertext = '';
        }
        
    $html2->save();

    foreach ($html2->find('section[class=userbody]') as $row2) 
    {
        $description = $row2->find('section[id=postingbody]',0);

        $imgtmp = $row2->find('img',0);

        $imgurl = $imgtmp->getAttribute('src');
    }
    // *********************** for the description and image end*********************************


//******************** below is list of Product*******************************
    echo "<br>title:- ".$title;
    echo "<br>IMageURL:- ".$imgurl;
    echo "<br>IMage:- ".$imgtmp;
    echo "<br>Description:- ".$description;
    echo "<br>location:- ".$location;
    echo "<br>price:- ".$price;
    echo "<br>Sourceurl:- ".$url;
    
    
}

