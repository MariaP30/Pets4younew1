<?php

$servername = "localhost";
$username = "pets4you";
$password = "0106myoca1A";
$dbname = "pets4you";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}
