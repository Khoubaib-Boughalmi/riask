
<?php
 $con = mysqli_connect('localhost','root','','riask');
 if(mysqli_connect_errno()){
     echo 'connection failled';
 }
if (isset($_POST['user_logged_in'])) {
  $user_logged_in=$_POST['user_logged_in'];
}
if (isset($_POST['file_name'])) {
  $file_name=$_POST['file_name'];
}

if (isset($_POST['filename_rand'])) {
  $filename_rand=$_POST['filename_rand'];
}

if (isset($_POST['image_full_path'])) {
  $image_full_path=$_POST['image_full_path'];
}

  // Getting file name
  $file_name=$filename_rand.$file_name;
  // Valid extension
  $valid_ext = array('png','jpeg','jpg');

  // Location
  $location = "C:/xampp/htdocs/riask/images/users_profile_pic/".$file_name;

  // file extension
  $file_extension = pathinfo($location, PATHINFO_EXTENSION);
  $file_extension = strtolower($file_extension);

  // Check extension
  if(in_array($file_extension,$valid_ext)){
    $pic_location = "images/users_profile_pic/".$file_name;
    
    // chmod($location,0644);
    // Compress Image
    

    $query_updating=mysqli_query($con,"UPDATE `users` SET profile_pic='$pic_location' where user_name='$user_logged_in'");


  }else{
    echo "Can't appload image.";
  }
  echo $pic_location;
?>
