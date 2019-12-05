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
 require "db.php";



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Free Web tutorials">
    <meta name="keywords" content="HTML, CSS, XML, JavaScript">
    <meta name="author" content="Khoubaib Bouhghalmi">

    <link rel="stylesheet" href="css/front.css">
    <!-- <script src="/font_awsome/all.js"></script> -->
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans|Montserrat&display=swap" rel="stylesheet">
    <!--Notification-->
    <script src="js_ex/notification/simpleNotify.min.js"></script>
    <link rel="stylesheet" href="js_ex/notification/simpleNotifyStyle.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-153200341-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-153200341-1');
</script> -->
<link rel="shortcut icon" href="images/icons/logo_transparent.ico" />
<title>Riask</title>
</head>

