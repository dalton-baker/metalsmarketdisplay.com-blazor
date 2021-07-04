<!DOCTYPE html>
<html>

<style>
    <?php include 'embeds.css'; ?>
</style>

<?php
$metalsMarketFile = fopen("../market-data/metals.json", "r") or die("Unable to open file!");
$metalsMarketData = json_decode(fread($metalsMarketFile, filesize("../market-data/metals.json")));
fclose($myfile);
?>

<head>
    <title>Metals Market Display</title>
    <!-- https://material.io/resources/icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="main-div">
        <a href="https://metalsmarketdisplay.com/" target="_PARENT" class="link-card card">
            MetalsMarketDisplay.com
        </a>

        <?php foreach ($metalsMarketData->market as $market) : ?>

            <div class="metal-card card">
                <div class="metal-card-lrgname">
                    <?= $market->name; ?>
                </div>
                <div class="metal-card-prices-lrgname">
                    <div>
                        $<?= $market->bid; ?>
                    </div>
                    <div>
                        <?php if (floatval($market->change) < 0) : ?>
                            <span class="down-color">&#x25BC;<?= number_format(abs(floatval($market->change)), 2, '.', '') ?></span>
                        <?php else : ?>
                            <span class="up-color">&#x25B2;<?= number_format(abs(floatval($market->change)), 2, '.', '') ?></span>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>



</body>

</html>