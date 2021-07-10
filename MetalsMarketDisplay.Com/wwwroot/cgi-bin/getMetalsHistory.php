<?php

require 'connection.php';

class SimpleCandle
{
    public $updateTime;
    public $ask;
    public $bid;

    public function __construct($sqlRow)
    {
        $this->updateTime = $sqlRow["updateTime"];
        $this->ask = $sqlRow["ask"];
        $this->bid = $sqlRow["bid"];
    }
}

class MetalsHistory
{
    public $silver = array();
    public $gold = array();
}

if ($_GET["auth"] != "fd4cbecc-f3a6-4fba-9853-f8e94bb1e8f7") {
    http_response_code(401);
    echo 'You are not authorised!';
} else {
    $returnMarketData = new MetalsHistory;
        
    $result = $sqlConnection->query("SELECT * FROM GoldMarket ORDER BY updateTime DESC LIMIT 288");
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc())
        {
            array_push($returnMarketData->gold, new SimpleCandle($row));
        }
    }

    $result = $sqlConnection->query("SELECT * FROM SilverMarket ORDER BY updateTime DESC LIMIT 288");
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc())
        {
            array_push($returnMarketData->silver, new SimpleCandle($row));
        }
    }

    $sqlConnection->close();

    echo json_encode($returnMarketData);
}
