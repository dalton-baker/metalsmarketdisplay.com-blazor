<?php

if ($_GET["auth"] != "fd4cbecc-f3a6-4fba-9853-f8e94bb1e8f7") {
    http_response_code(401);
    echo 'You are not authorised!';
} else {
    try {
        $metalsMarketFile = fopen("../market-data/metals.json", "r") or die("Unable to open file!");
        $metalsMarketData = json_decode(fread($metalsMarketFile, filesize("../market-data/metals.json")));
        fclose($myfile);
        
        $miscMarketFile = fopen("../market-data/misc.json", "r") or die("Unable to open file!");
        $miscMarketData = json_decode(fread($miscMarketFile, filesize("../market-data/misc.json")));
        fclose($myfile);

        $returnMarketData->updateTime = $metalsMarketData->updateTime;
        $returnMarketData->marketStatus = $metalsMarketData->marketStatus;
        $returnMarketData->metalsMarket = $metalsMarketData->market;
        $returnMarketData->miscMarkets = $miscMarketData->market;
        echo json_encode($returnMarketData);

    } catch (Exception $e) {
        http_response_code(500);
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}
