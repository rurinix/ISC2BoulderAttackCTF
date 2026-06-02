<?php

require '/var/www/db_connect.php';
require '/var/www/check_cookie.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    if (isset($_POST['flag'])) { $flag = trim($_POST['flag']); }
    if (!preg_match('/^[a-zA-Z0-9\-_]+$/', $flag)) 
    {
        $flag_message = "Flag may only contain letters, numbers, dashes and underscores.";
        $flag = "";
    }
    else 
    {
        // Validate the flag exists in the flags table
        $stmt = $conn->prepare("SELECT flag FROM flags WHERE flag = ?");
        $stmt->bind_param("s", $flag);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) 
        {
            $flag_message = "Invalid flag.";
        } 
        else 
        {
            $stmt->close();

            // Check if this user has already submitted this flag
            $stmt = $conn->prepare("SELECT flag FROM user_flags WHERE user_name = ? AND flag = ?");
            $stmt->bind_param("ss", $user_name, $flag);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) 
            {
                $flag_message = "You have already submitted this flag.";
            } 
            else 
            {
                // Insert into user_flags
                $stmt = $conn->prepare("INSERT INTO user_flags (user_name, flag) VALUES (?, ?)");
                $stmt->bind_param("ss", $user_name, $flag);
                $stmt->execute();
                $flag_message = "Flag accepted!";
            }
        }
    }
}

if (isset($stmt)) { $stmt->close(); }
?>
<!DOCTYPE html>
  <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="(ISC)2 Boulder Chapter Website">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, maximum-scale=5">
        <meta name="robots" content="index, follow">
        <title>(ISC)2 Boulder Chapter | Capture The Flag - Submission</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="preload" as="image" href="img/Boulder-Chapter_Logo-Stacked.png" imagesrcset="img/Boulder-Chapter_Logo-Stacked.png 380w, img/Boulder-Chapter_Logo.png 680w" imagesizes="100vw">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <div id="full-page">
            <header id="header-banner">
                <div class="boundbox">
                    <img id="chapter-logo" src="img/Boulder-Chapter_Logo-Stacked.png" alt="(ISC)2 Boulder Chapter logo">
                    <img id="chapter-logo-wide" src="img/Boulder-Chapter_Logo.png" alt="(ISC)2 Boulder Chapter logo">
                    <nav>
                        <button id="burger_btn" class="hamburger hamburger--squeeze" type="button" alt="menu">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                        <ul id="menu_bar">
                            <li><a href="index.php">Start</a></li>
                            <li><span class="selected">Submit</span></li>
                            <li><a href="leaderboard.php">Leaderboard</a></li>
                        </ul>
                    </nav>
                </div>
            </header>
            <main>
                <?php include '/var/www/user_banner.php'; ?>
                <h1>Submit a Flag</h1>
                <div class="boundbox">
                    <div class="calloutbox centerbox">
                        <div>
                            <?php if (empty($user_name)): ?>
                                <p>You must register in order to submit flags.</p>
                            <?php else: ?>
                            <form method="POST" action="<?php echo htmlspecialchars(strip_tags($_SERVER['PHP_SELF'])); ?>">
                                <div class="flex_box_large">
                                <div>
                                    <label>Flag: </label>
                                    <div class="input_field flag">
                                        <input required type="text" name="flag" id="flag">
                                    </div>
                                </div>
                                </div>
                                <div class="button-box">
                                    <input type="submit" class="button" name="submit" id="submit" value="submit">
                                </div>
                            </form>
                                <?php if (!empty($flag_message)): ?>
                                    <p class="centered"><?= $flag_message ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php include '/var/www/disclaimer.html'; ?>
            </main>
<?php include '/var/www/footer.php'; ?>