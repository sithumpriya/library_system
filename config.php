<?php
ini_set('session.use_only_coolies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 86400,
    'domain' => 'localhost',
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

session_start();

$conn = mysqli_connect("localhost", "root", "", "library_system");
?>