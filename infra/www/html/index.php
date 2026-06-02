<?php

require '/var/www/db_connect.php';
require '/var/www/check_cookie.php';

$total_flags = $conn->query("SELECT COUNT(*) FROM flags")->fetch_row()[0];

?>
<!DOCTYPE html>
  <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="(ISC)2 Boulder Chapter Website">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, maximum-scale=5">
        <meta name="robots" content="index, follow">
        <title>(ISC)2 Boulder Chapter | Capture The Flag</title>
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
                            <li><span class="selected">Start</span></li>
                            <li><a href="submit.php">Submit</a></li>
                            <li><a href="leaderboard.php">Leaderboard</a></li>
                        </ul>
                    </nav>
                </div>
            </header>
            <main>
                <?php include '/var/www/user_banner.php'; ?>
                <h1>Capture The Flag</h1>
                <div class="boundbox">
                    <p>
                            The CTP resides on a local, isolated network intended to allow players to 
                            sharpen their skills following the MITRE ATT&CK framework.  A total of 
                            <strong class="mono-font"><?= htmlspecialchars($total_flags) ?></strong> flags 
                            have been scattered throughout the network environment.  Use your ingenuity 
                            to identify the target systems, explore their contents, manipulate what you 
                            have access to, and get them to reveal their secrets.
                    </p>
                    <p class="note">
                        No dedication pen-testing tools are needed to find any flag, but having them would help.
                    </p>
                    <div class="calloutbox centerbox">
                        <h2>Rules</h2>
                        <p>
                            To ensure the integrity of the necissary infrastructure and the enjoyment 
                            of all players, participants must comply with the following rules:
                        </p>
                        <ol>
                            <li>No targetting off-limit systems</li>
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
                                                192.168.1.12
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
                            <li>No DoS / DDoS attacks</li>
                            <li>No potentially destructive attacks</li>
                            <li>All activities must stay within the CTP WiFi network</li>
                        </ol> 
                        <?php include '/var/www/disclaimer.html'; ?>
                    </div>
                    
                    <div class="calloutbox centerbox">
                        <h2>Troubleshooting</h2>
                        <p>If you are experiencing issues attempting to connect to systems within
                            the CTF netowrk, try these troubleshooting steps.
                        </p>
                        <ul>
                            <li>
                                <strong>Check WiFi Connection:</strong>
                                Sometimes an OS will 
                                detect that the WiFi network is not connected to the internet and 
                                automatically disconnect.
                            </li>
                            <li>
                                <strong>Verify DNS Settings:</strong>
                                DNS settings are pulled via DHCP.  If your system is not releasing
                                previous DNS settings or has a manual DNS setting already in place
                                it will be necissary to manually set the dns server to 
                                <span class="mono-font">192.168.1.10</span>.
                            </li>
                        </ul>
                    </div>
                </div>
            </main>
<?php include '/var/www/footer.php'; ?>