<?php

session_start();

if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
    session_destroy();
}

header('Location: ../HTML/index.php');
exit;

?>