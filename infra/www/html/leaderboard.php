<?php

require '/var/www/db_connect.php';
require '/var/www/check_cookie.php';

$total_flags = $conn->query("SELECT COUNT(*) FROM flags")->fetch_row()[0];

$query = "
    SELECT
        user_name,
        COUNT(flag)              AS flags_captured,
        COALESCE(SUM(points), 0) AS total_points
    FROM players
    LEFT JOIN user_flags  USING (user_name)
    LEFT JOIN flags       USING (flag)
    GROUP BY user_name
    HAVING total_points > 0
    ORDER BY total_points DESC, flags_captured DESC
";

$result = $conn->query($query);
?>
<!DOCTYPE html>
  <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="(ISC)2 Boulder Chapter Website">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, maximum-scale=5">
        <meta name="robots" content="index, follow">
        <meta http-equiv="refresh" content="360">
        <title>(ISC)2 Boulder Chapter | Capture The Flag Leaderboard</title>
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
                            <li><a href="submit.php">Submit</a></li>
                            <li><span class="selected">Leaderboard</span></li>
                        </ul>
                    </nav>
                </div>
            </header>
            <main>
                <?php include '/var/www/user_banner.php'; ?>
                <h1>CTF Leaderboard</h1>
                <div class="boundbox">
                    <div class="calloutbox centerbox">
                        <table>
                            <thead>
                                <tr class="table-header">
                                    <td>Name</td>
                                    <td>Flags</td>
                                    <td>Points</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                  <?php while ($row = $result->fetch_assoc()): ?>
                                      <tr>
                                          <td>
                                            <?php if ($row['flags_captured'] == $total_flags): ?>
                                                <img src="img/crown.png" class="crown" alt="All flags captured!">
                                            <?php endif; ?>
                                            <span class="player_name"><?= htmlspecialchars($row['user_name']) ?></span></td>
                                          <td><?= $row['flags_captured'] ?></td>
                                          <td><?= $row['total_points'] ?></td>
                                      </tr>
                                  <?php endwhile; ?>
                              <?php else: ?>
                                  <tr>
                                      <td colspan="3" class="centered">No scores yet!</td>
                                  </tr>
                              <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php include '/var/www/disclaimer.html'; ?>
            </main>
<?php include '/var/www/footer.php'; ?>