<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

$dbData =  [
    'host' => isset($_ENV['host'])? $_ENV['host']: 'localhost',
    'dbname' => isset($_ENV['dbname'])? $_ENV['dbname']: 'riask',
    'user' => isset($_ENV['user'])? $_ENV['user']: 'root',
    'password' => isset($_ENV['password'])? $_ENV['password']: '' 
];
//var_dump($dbData);
$con = mysqli_connect($dbData['host'],$dbData['user'],$dbData['password'], $dbData['dbname']);
if(mysqli_connect_errno()){
    echo 'connection failled'. mysqli_connect_error();

}
