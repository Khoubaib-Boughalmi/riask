<?php
   require '../db.php';
    if(mysqli_connect_errno()){
        echo 'connection failled';
    
    }

    
    if (isset($_POST['report_id'])) {
        $report_id=$_POST['report_id'];
    }

    if (isset($_POST['user_name_logged_in'])) {
        $user_name_logged_in=$_POST['user_name_logged_in'];
    }
    $query_select_post=mysqli_query($con,"SELECT `repored_by` FROM `posts` WHERE id='$report_id'");
    $query_select_post_arr=mysqli_fetch_array($query_select_post);
    $query_select_post_list=$query_select_post_arr['repored_by'];
    
    if (strstr($query_select_post_list,$user_name_logged_in)==false) {
        $query_select_post_list=$query_select_post_list.','.$user_name_logged_in;
        $query_insert_report_into_post=mysqli_query($con,"UPDATE `posts` SET `repored_by`='$query_select_post_list' WHERE id='$report_id'");
        $query_insert_report=mysqli_query($con,"INSERT INTO report_post VALUES('','$report_id','$user_name_logged_in')");
    }
    echo $query_select_post_list;
?>