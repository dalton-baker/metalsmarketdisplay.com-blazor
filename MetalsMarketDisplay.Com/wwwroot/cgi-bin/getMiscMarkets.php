<?php

class MiscCandle
{
    public $updateTime;
    public $price;
    public $change;
    public $percent;

    public function __construct($sqlRow)
    {
        $this->updateTime = $sqlRow["updateTime"];
        $this->price = $sqlRow["price"];
        $this->actualChange = $sqlRow["actualChange"];
        $this->percentChange = $sqlRow["percentChange"];
    }
}

class MiscMarkets
{
    public $usd;
    public $djia;
    public $spx;
    public $comp;
    public $btc;
    public $eth;
    public $ltc;
}

if ($_GET["auth"] != "fd4cbecc-f3a6-4fba-9853-f8e94bb1e8f7") {
    http_response_code(401);
    echo 'You are not authorised!';
} else {
    try {
        $servername = "drdoomsalot22237.domaincommysql.com";
        $username = "mmd_sqluser";
        $password = "Pass!=98901";
        $dbname = "metalsmarketdisplay_sqldatabase";
        $conn = new mysqli($servername, $username, $password, $dbname);
        $returnMarketData = new MetalsHistory;
        
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $result = $conn->query("SELECT * FROM GoldMarket ORDER BY updateTime DESC LIMIT 288");
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc())
            {
                array_push($returnMarketData->gold, new SimpleCandle($row));
            }
        }

        $result = $conn->query("SELECT * FROM SilverMarket ORDER BY updateTime DESC LIMIT 288");
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc())
            {
                array_push($returnMarketData->silver, new SimpleCandle($row));
            }
        }

        $conn->close();

        echo json_encode($returnMarketData);

    } catch (Exception $e) {
        http_response_code(500);
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}
