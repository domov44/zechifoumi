<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['token']) || isset($_SESSION['admin_token']);
}

function isAdmin() {
    return isset($_SESSION['admin_token']);
}
?>
