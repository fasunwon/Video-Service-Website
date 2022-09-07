<?php
$serverName = "localhost";
$username = "root";
//remove pass for local dev
$password = "";
//authDB for local dev
$dbName = "authDB";
$connection = new mysqli($serverName, $username, $password, $dbName);
if ($connection->connect_error) {
    die("connection failed: " . $connection->connect_error);
}
