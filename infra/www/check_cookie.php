<?php 
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$safe = (parse_url($referer, PHP_URL_HOST) === $_SERVER['HTTP_HOST'])
    ? htmlspecialchars(strip_tags($referer))
    : '/index.php';
$user_message = "";
$user_name = "";
//if the cookie is set, use the cookie
if (isset($_COOKIE['user_name'])) {
    $user_name = trim($_COOKIE['user_name']);

    if (!preg_match('/^[a-zA-Z0-9\-_]+$/', $user_name)) {
        $user_message = "Username may only contain letters, numbers, dashes and underscores.";
        setcookie("user_name", "", time() - 3600, "/");
    }
    else {
    $user_message = "Playing as: <span class=\"player_name\">" . $user_name . "</span>" ;
    }
}
//if the cookie is not set, get the cookie
else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_name = trim($_POST['user_name']);

        if (strlen($user_name) > 254) {
            $user_name = substr($user_name, 0, 254);
        }
        
        if (!preg_match('/^[a-zA-Z0-9\-_]+$/', $user_name)) {
            $user_message = "Username may only contain letters, numbers, dashes and underscores.";
            $user_name = "";
        }

        else {
            // Check if user exists
            $stmt = $conn->prepare("SELECT user_name FROM players WHERE user_name = ?");
            $stmt->bind_param("s", $user_name);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 0) {
                // New player — insert them
                $insert = $conn->prepare("INSERT INTO players (user_name) VALUES (?)");
                $insert->bind_param("s", $user_name);
                $insert->execute();
                $insert->close();
                $user_message = "Playing as: <span class=\"player_name\">$user_name</span>";
            } 
            
            else {
                $user_message = "Welcome back: <span>$user_name</span>";
            }

            $stmt->close();

            setcookie("user_name", $user_name, time() + (24 * 60 * 60), "/");
            header("Location: " . $safe);
            exit();
        }

    }

}