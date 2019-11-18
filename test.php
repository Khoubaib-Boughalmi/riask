<?php
$con = mysqli_connect('localhost','root','','riask');
if(mysqli_connect_errno()){
    echo 'connection failled';
}

$query = mysqli_query($con,"INSERT INTO test VALUES('','khoubaib')");

?>
