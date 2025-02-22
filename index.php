<?php
require_once 'config/env.php';
error_reporting(E_ERROR | E_PARSE); // remove waring messages

// check page for action
if (!empty($_GET["pages"]) && !empty($_SESSION["supplier"]["id"])) {
?>
    <!DOCTYPE html>
    <html class="loading" lang="en" data-textdirection="ltr">
    <!-- BEGIN: Head-->

    <?php
    if ((include 'layouts/' . $_GET["pages"] . '-main.php') == FALSE) {
        unset($_SESSION["supplier"]);
        include "pages/authentication/login.php";
    }
    ?>

    </html>

<?php
} else {
    unset($_SESSION["supplier"]);
    include "pages/authentication/login.php";
}
?>