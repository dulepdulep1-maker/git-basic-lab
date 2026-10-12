<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

$_SESSION = [];
session_destroy();

header("Location: login.php");
exit;