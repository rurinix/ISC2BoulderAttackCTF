<?php

$host = "mysql";
$db   = "ctf_db";
$user = "isc2sqlquerier";
$pass = "PsJ747suUzQ5NBFsantx5jQT";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>