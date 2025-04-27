<?php
// Configuration and common functions
session_start();

define('USERS_FILE', __DIR__ . '/../data/users.txt');
define('TECHNICIANS_FILE', __DIR__ . '/../data/technicians.txt');

function redirect($url) {
    header("Location: $url");
    exit();
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}