<?php

require '/var/www/db_connect.php';
require '/var/www/check_cookie.php';

$total_flags = $conn->query("SELECT COUNT(*) FROM flags")->fetch_row()[0];

?>
<!DOCTYPE html>
  <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="ISC2 Boulder Chapter Website">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, maximum-scale=5">
        <meta name="robots" content="index, follow">
        <title>ISC2 Boulder Chapter | Capture The Flag - Scenario</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="preload" as="image" href="img/Boulder-Chapter_Logo-Stacked.png" imagesrcset="img/Boulder-Chapter_Logo-Stacked.png 380w, img/Boulder-Chapter_Logo.png 680w" imagesizes="100vw">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <div id="full-page">
            <header id="header-banner">
                <div class="boundbox">
                    <img id="chapter-logo" src="img/Boulder-Chapter_Logo-Stacked.png" alt="ISC2 Boulder Chapter logo">
                    <img id="chapter-logo-wide" src="img/Boulder-Chapter_Logo.png" alt="ISC2 Boulder Chapter logo">
                    <nav>
                        <button id="burger_btn" class="hamburger hamburger--squeeze" type="button" alt="menu">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                        <ul id="menu_bar">
                            <li><a href="index.php">Start</a></li>
                            <li><span class="selected">Scenario</span></li>
                            <li><a href="submit.php">Submit</a></li>
                            <li><a href="leaderboard.php">Leaderboard</a></li>
                        </ul>
                    </nav>
                </div>
            </header>
            <main>
                <?php include '/var/www/user_banner.php'; ?>
                <h1>Capture the Flag Scenario</h1>
                <div class="boundbox">
                    <div class="calloutbox centerbox">
                        <?php include '/var/www/scenario.html'; ?>
                        </p>
                            <table>
                                <thead>
                                    <tr class="table-header">
                                        <td colspan="2">Off-Limit Systems</td>
                                    </tr>
                                </thead>
                               <tbody>
                                    <tr>
                                        <td>
                                            192.168.1.1
                                        </td>
                                        <td>
                                            Router
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            192.168.1.20
                                        </td>
                                        <td>
                                            The flag reporting portal (this website)
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            192.168.1.100-250
                                        </td>
                                        <td>
                                            DHCP pool (aka other participants)
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </p>
                <?php include '/var/www/disclaimer.html'; ?>
                </div>
            </main>
<?php include '/var/www/footer.php'; ?>