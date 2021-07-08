<?php
# curl.php

class Candle
{
    public $ask;
    public $bid;
    public $change;
    public $percent;
    public $low;
    public $high;

    public function __construct($ask, $bid, $change, $percent, $low, $high)
    {
        $this->ask = $ask;
        $this->bid = $bid;
        $this->change = $change;
        $this->percent = $percent;
        $this->low = $low;
        $this->high = $high;
    }
}

class MetalsMarkets
{
    public $marketOpen;
    public $updateTime;
    public $silver;
    public $gold;
    public $platinum;
    public $palladium;
}

class SimpleCandle
{
    public $ask;
    public $bid;

    public function __construct($ask, $bid)
    {
        $this->ask = $ask;
        $this->bid = $bid;
    }
}

class SimpleMetalsMarkets
{
    public $updateTime;
    public $silver;
    public $gold;
    public $platinum;
    public $palladium;
}



class MiscCandle
{
    public $price;
    public $change;
    public $percent;

    public function __construct($price, $change, $percent)
    {
        $this->price = $price;
        $this->change = $change;
        $this->percent = $percent;
    }
}

class MiscMarkets
{
    public $updateTime;
    public $usd;
    public $djia;
    public $spx;
    public $comp;
    public $btc;
    public $eth;
    public $ltc;
}

if ($_GET["auth"] != "3832d15f-8e27-4eea-a24a-0b9712fd1bc1") {
    http_response_code(401);
    echo 'You are not authorised!';
} else {

    $returnInfo = "Data update status: ";

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

        if (
            !empty($askAGmatch[1]) and !empty($bidAGmatch[1]) and !empty($changeAGmatch[1]) and !empty($percentAGmatch[1]) and !empty($lowAGmatch[1]) and !empty($highAGmatch[1]) and
            !empty($askAUmatch[1]) and !empty($bidAUmatch[1]) and !empty($changeAUmatch[1]) and !empty($percentAUmatch[1]) and !empty($lowAUmatch[1]) and !empty($highAUmatch[1]) and
            !empty($askPTmatch[1]) and !empty($bidPTmatch[1]) and !empty($changePTmatch[1]) and !empty($percentPTmatch[1]) and !empty($lowPTmatch[1]) and !empty($highPTmatch[1]) and
            !empty($askPDmatch[1]) and !empty($bidPDmatch[1]) and !empty($changePDmatch[1]) and !empty($percentPDmatch[1]) and !empty($lowPDmatch[1]) and !empty($highPDmatch[1])
        ) {
            $metalsMarketData = new MetalsMarkets;
            if($marketStatus[1] == "OPEN") {
                $metalsMarketData->marketOpen = "true";
            }
            else {
                $metalsMarketData->marketOpen = "false";
            }
            $metalsMarketData->updateTime = gmdate("m/d/Y H:i:s") . " +00:00";
            $metalsMarketData->silver = new Candle($askAGmatch[1], $bidAGmatch[1], $changeAGmatch[1], $percentAGmatch[1], $lowAGmatch[1], $highAGmatch[1]);
            $metalsMarketData->gold = new Candle($askAUmatch[1], $bidAUmatch[1], $changeAUmatch[1], $percentAUmatch[1], $lowAUmatch[1], $highAUmatch[1]);
            $metalsMarketData->platinum = new Candle($askPTmatch[1], $bidPTmatch[1], $changePTmatch[1], $percentPTmatch[1], $lowPTmatch[1], $highPTmatch[1]);
            $metalsMarketData->palladium = new Candle($askPDmatch[1], $bidPDmatch[1], $changePDmatch[1], $percentPDmatch[1], $lowPDmatch[1], $highPDmatch[1]);

            $simpleMetalsMarkets = new SimpleMetalsMarkets;
            $simpleMetalsMarkets->updateTime = gmdate("m/d/Y H:i:s") . " +00:00";
            $simpleMetalsMarkets->silver = new SimpleCandle($askAGmatch[1], $bidAGmatch[1]);
            $simpleMetalsMarkets->gold = new SimpleCandle($askAUmatch[1], $bidAUmatch[1]);
            $simpleMetalsMarkets->platinum = new SimpleCandle($askPTmatch[1], $bidPTmatch[1]);
            $simpleMetalsMarkets->palladium = new SimpleCandle($askPDmatch[1], $bidPDmatch[1]);


            $metalsFile = fopen("../market-data/metals.json", "w") or die("Unable to open file metals.json");
            fwrite($metalsFile, json_encode($metalsMarketData, JSON_UNESCAPED_SLASHES));
            fclose($metalsFile);
            
            $groupFileName = "../market-data/metals-24-hour/" . gmdate("Hi") . ".json";
            $metalsFile = fopen($groupFileName, "w") or die("Unable to open file " . $groupFileName);
            fwrite($metalsFile, json_encode($simpleMetalsMarkets, JSON_UNESCAPED_SLASHES));
            fclose($metalsFile);
            

            $returnInfo .= "Metals data updated succesfully at " . $metalsMarketData->updateTime;
        }
        else
        {
            $returnInfo .= "Metals data failed update";
        }


        if(!empty($usdMatches[1]) and !empty($usdMatches[2]) and !empty($usdMatches[3]) and
           !empty($djiaMatches[1]) and !empty($djiaMatches[2]) and !empty($djiaMatches[3]) and
           !empty($spxMatches[1]) and !empty($spxMatches[2]) and !empty($spxMatches[3]) and
           !empty($compMatches[1]) and !empty($compMatches[2]) and !empty($compMatches[3]) and
           !empty($btcMatches[1]) and !empty($btcMatches[2]) and !empty($btcMatches[3]) and
           !empty($ethMatches[1]) and !empty($ethMatches[2]) and !empty($ethMatches[3]) and
           !empty($ltcMatches[1]) and !empty($ltcMatches[2]) and !empty($ltcMatches[3]) )
        {
            $miscMarketData = new MiscMarkets;
            $miscMarketData->updateTime = gmdate("m/d/Y H:i:s") . " +00:00";
            $miscMarketData->usd  = new MiscCandle($usdMatches[1], $usdMatches[2], $usdMatches[3]);
            $miscMarketData->djia = new MiscCandle($djiaMatches[1], $djiaMatches[2], $djiaMatches[3]);
            $miscMarketData->spx  = new MiscCandle($spxMatches[1], $spxMatches[2], $spxMatches[3]);
            $miscMarketData->comp = new MiscCandle($compMatches[1], $compMatches[2], $compMatches[3]);
            $miscMarketData->btc  = new MiscCandle($btcMatches[1] . ".00", $btcMatches[2], $btcMatches[3]);
            $miscMarketData->eth  = new MiscCandle($ethMatches[1], $ethMatches[2], $ethMatches[3]);
            $miscMarketData->ltc  = new MiscCandle($ltcMatches[1], $ltcMatches[2], $ltcMatches[3]);

            $miscFile = fopen("../market-data/misc.json", "w") or die("Unable to open file misc.json");
            fwrite($miscFile, json_encode($miscMarketData, JSON_UNESCAPED_SLASHES));
            fclose($miscFile);

            $returnInfo .= ", Misc. data updated succesfully at " . $miscMarketData->updateTime;
        }
        else
        {
            $returnInfo .= ", Misc. data failed update\n";
        }

        echo $returnInfo;
    } catch (Exception $e) {
        http_response_code(500);
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}
