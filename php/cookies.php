<?php
// Configuration for persistent sessions (optional, place here or in a common include)
$session_lifetime = 60 * 60 * 24 * 180; // 180 days
session_set_cookie_params([
    'lifetime' => $session_lifetime,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'], // Or your specific domain
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);