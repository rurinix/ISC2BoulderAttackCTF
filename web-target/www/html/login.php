<?php require '/var/www/db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Tasty Bytes">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, maximum-scale=5">
        <meta name="robots" content="index, follow">
        <title>Tasty Bytes | Login</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body>
	<div id="full-page">
        <header class="redbox">
           <nav>
                <button id="burger_btn" class="hamburger hamburger--squeeze" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
		</button>
		<h1>Tasty Bytes</h1>
                <ul id="menu_bar">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><span class="selected">Login</span></li>
                </ul>
            </nav>
        </header>
        <main id="body-container">
            <?php
	       $submitted_PHP_Self = $_SERVER['PHP_SELF'];
	       if ($_SERVER['REQUEST_METHOD'] == "POST") {
		       if (isset($_POST['name'])) { $submitted_name = trim($_POST['name']); }
		       if (isset($_POST['password'])) { $submitted_password = trim($_POST['password']); }
		       if (isset($_POST['validated'])) { $validated = trim($_POST['validated']); }
	       }

	       elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
		       if (isset($_GET['name'])) { $submitted_name = trim($_GET['name']); }
		       if (isset($_GET['password'])) { $submitted_password = trim($_GET['password']); }
		       if (isset($_GET['validated'])) { $validated = trim($_GET['validated']); }
	       }
	       
            ?>
            <div class="flex_box_large boundbox">
                <div class="redbox parchment">
                    <h1>Login</h1>
                    <form method="post" action="<?php echo htmlspecialchars(strip_tags($_SERVER['PHP_SELF'])); ?>" >
                        <div>
                            <label for="name">Name: </label>
                            <div class="input_field">
                                <input required type="text" name="name" id="player_name" autocomplete="off">
                            </div>
                        </div>
                        <div>
                            <label for="password">Password: </label>
                            <div class="input_field">
                                <input required type="password" name="password" id="password" autocomplete="off">
                            </div>
		                </div>
                        <input type="hidden" name="validated" id="validated" value="false">
                        <div class="button-box">
                            <input type="submit" class="button" name="submit" id="submit" value="submit">
                        </div>
                    </form>
		    </div>
		</div>
            <div class="flex_box_large boundbox">
		<?php

		if (isset($submitted_name) && isset($submitted_password)) {
            $show_table = 0;

	        echo '<div class="whitebox parchment">';
            p_r("Unexpected Error at <span class=\"mono-font\">\\cgi-bin\\auth.php</span>");

			if (strtolower(htmlspecialchars(strip_tags($validated))) == 'yes' || strtolower(htmlspecialchars(strip_tags($validated))) == 'true' || strtolower(htmlspecialchars(strip_tags($validated))) == '1') {
				pre_r("CTF{But-n0t-inviz-336064D4}");
			}

			if ($_SERVER['REQUEST_METHOD'] != "POST" && (isset($submitted_name) || isset($submitted_password))) {
				pre_r("CTF{GET-0v3r-h3r3-A4D6FEB9}");
			}

			if (str_contains(strtolower($submitted_name), '<script>') || str_contains(strtolower($submitted_password), '<script>')) {
				pre_r("CTF{Croxx-da-St34ms-E1C8A3F5}");
                $show_table = 1;
			}
			if (str_contains(strtolower($submitted_name), 'or 1=1') || str_contains(strtolower($submitted_password), 'or 1=1')) {
				pre_r("CTF{Alw4yZ-Tru-394A5B6C}");
                $show_table = 1;
			}
			if (strtolower($submitted_name) == (strtolower($submitted_password))) {
				pre_r("CTF{D3-Fault-cr3dz-C70C12B5}");
			}

            if ($show_table==1) { ?>
                <table class="mono-font">
                    <thead>
                        <tr class="table-header">
                            <td>Username</td>
                            <td>Password</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><span><?= htmlspecialchars($row['user_name']) ?></span></td>
                                <td><?= htmlspecialchars($row['passwd']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php 
                endif; 
            }

			echo '</div>';
		}

		?>

                </div>
            </div>
	</main>
	</div>
	<script src="js/jquery.js"></script>
	<script defer src="js/custom.js"></script>
    </body>
</html>
<?php 

function pre_r( $array ) {
  echo '<p class="centered"><span class="mono-font green-font">';
  print_r ($array);
  echo '</span></p>';
}

function p_r( $array ) {
  echo '<p class="centered"><span class="red-font">';
  print_r ($array);
  echo '</span></p>';
}

$conn->close(); 

?>