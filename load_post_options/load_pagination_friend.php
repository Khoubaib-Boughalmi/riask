<?php
require '../db.php';

include('../classes/load_pagination_main_page.php');
$pagination=new main_pagination($con);
$num_followers_list=$_POST['num_followers_list'];

$pagination->pagination($num_followers_list);
?>