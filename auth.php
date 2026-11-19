<?php
session_start();

function auth($role) {

    if (!isset($_SESSION['role'])) {
        header("Location: login.php");
        exit;
    }

    if ($_SESSION['role'] != $role) {
        header("Location: login.php");
        exit;
    }

}
?>