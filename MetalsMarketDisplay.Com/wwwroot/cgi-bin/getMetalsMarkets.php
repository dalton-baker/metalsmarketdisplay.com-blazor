<?php

require 'connection.php';

class Candle
{
    public $updateTime;
    public $ask;
    public $bid;
    public $actualChange;
    public $percentChange;
    public $low;
    public $high;

    public function __construct($sqlRow)
    {
        $this->updateTime = $sqlRow["updateTime"];
        $this->ask = $sqlRow["ask"];
        $this->bid = $sqlRow["bid"];
        $this->actualChange = $sqlRow["actualChange"];
        $this->percentChange = $sqlRow["percentChange"];
        $this->low = $sqlRow["low"];
        $this->high = $sqlRow["high"];
    }
}

class MetalsMarkets
{
    public $silver;
    public $gold;
    public $platinum;
    public $palladium;
}

if ($_GET["auth"] != "fd4cbecc-f3a6-4fba-9853-f8e94bb1e8f7") {
    http_response_code(401);
    echo 'You are not authorised!';
} else {
    $returnMarketData = new MetalsMarkets;
        
    $result = $sqlConnection->query("SELECT * FROM GoldMarket ORDER BY updateTime DESC LIMIT 1");
    if ($result->num_rows > 0) {
        $returnMarketData->gold = new Candle($result->fetch_assoc());
    }

    $result = $sqlConnection->query("SELECT * FROM SilverMarket ORDER BY updateTime DESC LIMIT 1");
    if ($result->num_rows > 0) {
        $returnMarketData->silver = new Candle($result->fetch_assoc());
    }

    $result = $sqlConnection->query("SELECT * FROM PlatinumMarket ORDER BY updateTime DESC LIMIT 1");
    if ($result->num_rows > 0) {
        $returnMarketData->platinum = new Candle($result->fetch_assoc());
    }

    $result = $sqlConnection->query("SELECT * FROM PalladiumMarket ORDER BY updateTime DESC LIMIT 1");
    if ($result->num_rows > 0) {
        $returnMarketData->palladium = new Candle($result->fetch_assoc());
    }

    $sqlConnection->close();

    echo json_encode($returnMarketData);
}
