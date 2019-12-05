<?php
session_start();
require '../db.php';
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
if (isset($_POST['tag_val'])) {
     $tag_val=$_POST['tag_val'];
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
$password = striping2($password,$con);

$user_name_f_letter = $user_name[0];
$user_name_f_letter =strtolower($user_name_f_letter);

// choose profile pic
switch ($user_name_f_letter) {
     case 'a':
          $profile_pic ="images/letter/a.png";
         break;
     case 'b':
          $profile_pic ="images/letter/b.png";
         break;
     case 'c':
          $profile_pic ="images/letter/c.png";
         break;
     case 'd':
          $profile_pic ="images/letter/d.png";
         break;
     case 'e':
          $profile_pic ="images/letter/e.png";
         break;
     case 'f':
          $profile_pic ="images/letter/f.png";
         break;
     case 'j':
          $profile_pic ="images/letter/j.png";
         break;
     case 'h':
          $profile_pic ="images/letter/h.png";
         break;
     case 'i':
          $profile_pic ="images/letter/i.png";
         break;
     case 'g':
          $profile_pic ="images/letter/g.png";
         break;
         
     case 'k':
          $profile_pic ="images/letter/k.png";
         break;
     case 'l':
          $profile_pic ="images/letter/l.png";
         break;
     case 'm':
          $profile_pic ="images/letter/m.png";
         break;
     case 'n':
          $profile_pic ="images/letter/n.png";
         break;
     case 'o':
          $profile_pic ="images/letter/o.png";
         break;
     case 'p':
          $profile_pic ="images/letter/p.png";
         break;
     case 'q':
          $profile_pic ="images/letter/q.png";
         break;
     case 'r':
          $profile_pic ="images/letter/r.png";
         break;
     case 's':
          $profile_pic ="images/letter/s.png";
         break;
     case 't':
          $profile_pic ="images/letter/t.png";
         break;
     case 'u':
          $profile_pic ="images/letter/u.png";
         break;
     case 'v':
          $profile_pic ="images/letter/v.png";
         break;
     case 'w':
          $profile_pic ="images/letter/w.png";
         break;
     case 'x':
          $profile_pic ="images/letter/x.png";
         break;
     case 'y':
          $profile_pic ="images/letter/y.png";
         break;
     case 'z':
          $profile_pic ="images/letter/z.png";
         break;
     default: 
           $profile_pic ="images/letter/r.png";
      break;

         
     }
     
     





$inserting_query = mysqli_query($con,"INSERT INTO `users`(`id`, `first_name`, `last_name`, `user_name`, `email`, `password`, `user_bio`, `number_posts`, `profile_pic`, `user_closed`, `followers`, `tags_user`, `register_date`, `categories`, `followed_by`)VALUES ('','$first_name','$last_name','$user_name','$email','$password','hi u.u hi','0','$profile_pic','no','','php,css,java,','0-0-0','$tag_val','')");
echo $email ."<br>";
echo $user_name ."<br>";
echo $last_name ."<br>";
echo $first_name ."<br>";
echo $password ."<br>";
echo $inserting_query ."<br>";
?>
