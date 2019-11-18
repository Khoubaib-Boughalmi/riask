<?php
ini_set('display_errors', true);
error_reporting(E_ALL);


return  [
    'host' => $_ENV['host'] or 'localhost',
    'dbname' => $_ENV['dbname'] or 'riask',
    'user' => $_ENV['user'] or 'root',
    'password' => $_ENV['password'] or ''
];