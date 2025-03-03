<?php

$host = "localhost";
$port = "5432";
$dbname = "postgres";
$username = "postgres";
$password = "postgres";

$conn_string = "host=$host port=$port dbname=$dbname user=$username password=$password";
$conn = pg_connect($conn_string);

if (!$conn) {
    die("Connection failed: " . pg_last_error());
} else {
    "Connected ";
}
