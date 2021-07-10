<?php
	$servername = "drdoomsalot22237.domaincommysql.com";
    $username = "mmd_sqluser";
    $password = "Pass!=98901";
    $dbname = "metalsmarketdisplay_sqldatabase";
    $sqlConnection = new mysqli($servername, $username, $password, $dbname);
	if ($sqlConnection->connect_error) {
        die("Connection failed: " . $sqlConnection->connect_error);
    }