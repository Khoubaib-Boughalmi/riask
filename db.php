<?php
ini_set('display_errors', true);
error_reporting(E_ALL);


return  [
    'host' => isset($_ENV['host'])? $_ENV['host']: 'kf3k4aywsrp0d2is.cbetxkdyhwsb.us-east-1.rds.amazonaws.com',
    'dbname' => isset($_ENV['dbname'])? $_ENV['dbname']: 'k3dqklbrwiunemb3',
    'user' => isset($_ENV['user'])? $_ENV['user']: 'zmnwq0sa1b4ek8y6',
    'password' => isset($_ENV['password'])? $_ENV['password']: 'g2fo2m0qwchr1wp1' 
];
