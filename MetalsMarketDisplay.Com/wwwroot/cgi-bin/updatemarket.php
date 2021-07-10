<?php
# curl.php

require 'connection.php';

function insertMetal($sqlConn, $tableName, $ask, $bid, $ch, $percentCh, $low, $high) {
  $sql = "INSERT INTO " . $tableName . "(ask,bid,actualChange,percentChange,low,high) 
            VALUES (" . $ask . "," . $bid . "," . $ch . "," . $percentCh . "," . $low . "," . $high . ")";

  if ($sqlConn->query($sql) === TRUE) {
    return $tableName . " updated succesfully<br>";
  } else {
    return "Error: " . $sql . "<br>" . $sqlConn->error;
  }
}

if ($_GET["auth"] != "3832d15f-8e27-4eea-a24a-0b9712fd1bc1") {
    http_response_code(401);
    echo 'You are not authorised!';
} else {

    $returnInfo = "";

    // Initialize a connection with cURL (ch = cURL handle, or "channel")
    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.kitco.com/market/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $kitcoResponse = curl_exec($ch);

        curl_setopt($ch, CURLOPT_URL, 'https://www.marketwatch.com/investing/index/dxy');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $usdResponse = curl_exec($ch);

        curl_setopt($ch, CURLOPT_URL, 'https://www.marketwatch.com/investing/index/djia');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $djiaResponse = curl_exec($ch);

        curl_setopt($ch, CURLOPT_URL, 'https://www.marketwatch.com/investing/index/spx');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $spxResponse = curl_exec($ch);

        curl_setopt($ch, CURLOPT_URL, 'https://www.marketwatch.com/investing/index/comp');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $compResponse = curl_exec($ch);

        curl_setopt($ch, CURLOPT_URL, 'https://www.marketwatch.com/investing/cryptocurrency/btcusd');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $btcResponse = curl_exec($ch);

        curl_setopt($ch, CURLOPT_URL, 'https://www.marketwatch.com/investing/cryptocurrency/ethusd');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ethResponse = curl_exec($ch);

        curl_setopt($ch, CURLOPT_URL, 'https://www.marketwatch.com/investing/cryptocurrency/ltcusd');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ltcResponse = curl_exec($ch);
        curl_close($ch);

        preg_match('/market_status_wsp.*(OPEN|CLOSED)/', $kitcoResponse, $marketStatus);

        preg_match('/wsp-AG-ask.>(\d+\.\d+)/', $kitcoResponse, $askAGmatch);
        preg_match('/wsp-AG-bid.>(\d+\.\d+)/', $kitcoResponse, $bidAGmatch);
        preg_match('/wsp-AG-change.*>([\-\+]?\d+\.\d+)/', $kitcoResponse, $changeAGmatch);
        preg_match('/wsp-AG-change-percent.*>([\-\+]?\d+\.\d+)/', $kitcoResponse, $percentAGmatch);
        preg_match('/wsp-AG-low.>(\d+\.\d+)/', $kitcoResponse, $lowAGmatch);
        preg_match('/wsp-AG-high.>(\d+\.\d+)/', $kitcoResponse, $highAGmatch);

        preg_match('/wsp-AU-ask.>(\d+\.\d+)/', $kitcoResponse, $askAUmatch);
        preg_match('/wsp-AU-bid.>(\d+\.\d+)/', $kitcoResponse, $bidAUmatch);
        preg_match('/wsp-AU-change.*>([\-\+]?\d+\.\d+)/', $kitcoResponse, $changeAUmatch);
        preg_match('/wsp-AU-change-percent.*>([\-\+]?\d+\.\d+)/', $kitcoResponse, $percentAUmatch);
        preg_match('/wsp-AU-low.>(\d+\.\d+)/', $kitcoResponse, $lowAUmatch);
        preg_match('/wsp-AU-high.>(\d+\.\d+)/', $kitcoResponse, $highAUmatch);

        preg_match('/wsp-PT-ask.>(\d+\.\d+)/', $kitcoResponse, $askPTmatch);
        preg_match('/wsp-PT-bid.>(\d+\.\d+)/', $kitcoResponse, $bidPTmatch);
        preg_match('/wsp-PT-change.*>([\-\+]?\d+\.\d+)/', $kitcoResponse, $changePTmatch);
        preg_match('/wsp-PT-change-percent.*>([\-\+]?\d+\.\d+)/', $kitcoResponse, $percentPTmatch);
        preg_match('/wsp-PT-low.>(\d+\.\d+)/', $kitcoResponse, $lowPTmatch);
        preg_match('/wsp-PT-high.>(\d+\.\d+)/', $kitcoResponse, $highPTmatch);

        preg_match('/wsp-PD-ask.>(\d+\.\d+)/', $kitcoResponse, $askPDmatch);
        preg_match('/wsp-PD-bid.>(\d+\.\d+)/', $kitcoResponse, $bidPDmatch);
        preg_match('/wsp-PD-change.*>([\-\+]?\d+\.\d+)/', $kitcoResponse, $changePDmatch);
        preg_match('/wsp-PD-change-percent.*>([\-\+]?\d+\.\d+)/', $kitcoResponse, $percentPDmatch);
        preg_match('/wsp-PD-low.>(\d+\.\d+)/', $kitcoResponse, $lowPDmatch);
        preg_match('/wsp-PD-high.>(\d+\.\d+)/', $kitcoResponse, $highPDmatch);

        preg_match('/price" content="(.*)".*\s.*priceChange" content="(.*)".*\s.*priceChangePercent" content="(.*)%/', $usdResponse, $usdMatches);
        preg_match('/price" content="(.*)".*\s.*priceChange" content="(.*)".*\s.*priceChangePercent" content="(.*)%/', $djiaResponse, $djiaMatches);
        preg_match('/price" content="(.*)".*\s.*priceChange" content="(.*)".*\s.*priceChangePercent" content="(.*)%/', $spxResponse, $spxMatches);
        preg_match('/price" content="(.*)".*\s.*priceChange" content="(.*)".*\s.*priceChangePercent" content="(.*)%/', $compResponse, $compMatches);
        preg_match('/price" content="\$(.*)".*\s.*priceChange" content="(.*)".*\s.*priceChangePercent" content="(.*)%/', $btcResponse, $btcMatches);
        preg_match('/price" content="\$(.*)".*\s.*priceChange" content="(.*)".*\s.*priceChangePercent" content="(.*)%/', $ethResponse, $ethMatches);
        preg_match('/price" content="\$(.*)".*\s.*priceChange" content="(.*)".*\s.*priceChangePercent" content="(.*)%/', $ltcResponse, $ltcMatches);

        if(!empty($askAUmatch[1]) and !empty($bidAUmatch[1]) and !empty($changeAUmatch[1]) and !empty($percentAUmatch[1]) and !empty($lowAUmatch[1]) and !empty($highAUmatch[1])){
            $returnInfo .= insertMetal($sqlConnection, "GoldMarket", $askAUmatch[1], $bidAUmatch[1], $changeAUmatch[1], $percentAUmatch[1], $lowAUmatch[1], $highAUmatch[1]);
        }
        else{
            $returnInfo .= "GoldMarket data failed update";
        }

        if(!empty($askAGmatch[1]) and !empty($bidAGmatch[1]) and !empty($changeAGmatch[1]) and !empty($percentAGmatch[1]) and !empty($lowAGmatch[1]) and !empty($highAGmatch[1])){
            $returnInfo .= insertMetal($sqlConnection, "SilverMarket", $askAGmatch[1], $bidAGmatch[1], $changeAGmatch[1], $percentAGmatch[1], $lowAGmatch[1], $highAGmatch[1]);
        }
        else{
            $returnInfo .= "SilverMarket data failed update";
        }

        if(!empty($askPTmatch[1]) and !empty($bidPTmatch[1]) and !empty($changePTmatch[1]) and !empty($percentPTmatch[1]) and !empty($lowPTmatch[1]) and !empty($highPTmatch[1])){
            $returnInfo .= insertMetal($sqlConnection, "PlatinumMarket", $askPTmatch[1], $bidPTmatch[1], $changePTmatch[1], $percentPTmatch[1], $lowPTmatch[1], $highPTmatch[1]);
        }
        else{
            $returnInfo .= "PlatinumMarket data failed update";
        }

        if(!empty($askPTmatch[1]) and !empty($bidPTmatch[1]) and !empty($changePTmatch[1]) and !empty($percentPTmatch[1]) and !empty($lowPTmatch[1]) and !empty($highPTmatch[1])){
            $returnInfo .= insertMetal($sqlConnection, "PalladiumMarket", $askPDmatch[1], $bidPDmatch[1], $changePDmatch[1], $percentPDmatch[1], $lowPDmatch[1], $highPDmatch[1]);
        }
        else{
            $returnInfo .= "PalladiumMarket data failed update";
        }

        $sqlConnection->close();

        echo $returnInfo;

    } catch (Exception $e) {
        http_response_code(500);
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}
