<?php
session_start();
$con = mysqli_connect('localhost','root','','riask');
if(mysqli_connect_errno()){
     echo 'connection failled';
 
}

 
if (isset($_POST['user_name'])) {
     $user_name=$_POST['user_name'];
}
if (isset($_POST['first_name'])) {
     $first_name=$_POST['first_name'];
}
if (isset($_POST['last_name'])) {
     $last_name=$_POST['last_name'];
}
if (isset($_POST['email'])) {
     $email=$_POST['email'];
}
if (isset($_POST['password'])) {
     $password=$_POST['password'];
}


$first_name = (string)$first_name;
$last_name = (string)$last_name;
$email = (string)$email;
// if (isset($_POST['tag_val'])) {
//      $tag_val=$_POST['tag_val'];
// }

function striping1($value,$con)
{
    $value = strip_tags($value);
    $value = mysqli_real_escape_string($con,$value);
    $value = str_replace(" ","",$value);
    $value = ucfirst(strtolower($value));
    return $value;
}
function striping2($value,$con)
{
    $value = strip_tags($value);
    $value = mysqli_real_escape_string($con,$value);
    $value = md5($value);
    return $value;
}

$user_name = striping1($user_name,$con);
$first_name = striping1($first_name,$con);
$last_name = striping1($last_name,$con);
$email = striping1($email,$con);
// $tag_val = striping1($tag_val,$con);
$password = striping2($password,$con);

$inserting_query = mysqli_query($con,"INSERT INTO `users`(`id`, `first_name`, `last_name`, `user_name`, `email`, `password`, `user_bio`, `number_posts`, `profile_pic`, `user_closed`, `followers`, `tags_user`, `register_date`, `categories`, `followed_by`)VALUES ('','$first_name','$last_name','$user_name','$email','$password','hi u.u hi','0','images/steve.jpg','no','','php,css,java,','0-0-0','maths,physics','')");
echo $email ."<br>";
echo $user_name ."<br>";
echo $last_name ."<br>";
echo $first_name ."<br>";
echo $password ."<br>";
echo $inserting_query ."<br>";
?>
