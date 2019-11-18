<?php
ob_start(); 
session_start();
session_regenerate_id();    
if (!defined('header')) {
    echo('Not this time biitch:p ');
    exit();
}
$timezone=  date_default_timezone_set('Africa/Tunis');
// connection with db
$dbData = require "db.php";
//var_dump($dbData);
$con = mysqli_connect($dbData['host'],$dbData['user'],$dbData['password'], $dbData['dbname']);
if(mysqli_connect_errno()){
    echo 'connection failled'. mysqli_connect_error();

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/front.css">
    <!-- <script src="3rd_party/font_awsome/all.js"></script> -->
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans|Montserrat&display=swap" rel="stylesheet">
    <!--Notification-->
    <script src="3rd_party/notification/simpleNotify.min.js"></script>
    <link rel="stylesheet" href="3rd_party/notification/simpleNotifyStyle.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <title>Document</title>
</head>

