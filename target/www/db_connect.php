<?php

$host = "mysql";
$db   = "target_db";
$user = "sqlquerier";
$pass = "z2Cb6FzJWaC3wH6qYKNSyc5Z";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "
    SELECT
        id,
        user_name,
        passwd
    FROM users
    ORDER BY id ASC
";

$result = $conn->query($query);
?>