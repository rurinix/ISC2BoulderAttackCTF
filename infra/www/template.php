<?php 

//makes sure that this was submitted via a POST request
// if other than POST, rutrn to hompage
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit();
    header("Location: index.html");
}
else {
    //scrub field "form_value" for special characters and assign it to local variable $local_variable
    $local_variable = htmlspecialchars(strip_tags($_POST["form_value"]));

    // if the $local_variable has no data return to homepage
    if (empty($local_variable)) {
        exit();
        header("Location: index.html");
    }

}

/*FORM CROSS SITE SCRIPTING THING

<form method="post" action="<?php echo htmlspecialchars((strip_tags($_SERVER["PHP_SELF"]));?>">

*/

