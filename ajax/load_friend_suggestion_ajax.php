<?php
require '../db.php';
if(mysqli_connect_errno()){
    echo 'connection failled';

}
if (isset($_POST['suggestion'])) {
    $input_val=$_POST['suggestion'];
}

if (isset($_POST['user_logged_in'])) {
    $user_name_logged_in=$_POST['user_logged_in'];
}


$query_names=mysqli_query($con,"SELECT * FROM users WHERE user_name LIKE '%$input_val%' and user_name not like '$user_name_logged_in' LIMIT 5");
$query_names_user_logged_in=mysqli_query($con,"SELECT * FROM users WHERE user_name='$user_name_logged_in'");
$query_names_user_logged_in_array=mysqli_fetch_array($query_names_user_logged_in);
if (mysqli_num_rows($query_names)>0) {
    echo '<script>document.querySelector(".suggested_friend_show_more_button").style.display="block"</script>';

    while($query_names_array = mysqli_fetch_array($query_names)){
        // user logged in friend string
        $friend_list=$query_names_user_logged_in_array['followers'];
        $user_name=$query_names_array['user_name'];
        $user_profile_pic=$query_names_array['profile_pic'];
        if (strstr($friend_list,$user_name)==false) {
            echo "<div href='profile.php?user_profile=$user_name' class='load_friend_container'>
            <div class='follow_suggestion_name_container'><a href='profile.php?user_profile=$user_name'><img src='$user_profile_pic' alt=''></a><a href='profile.php?user_profile=$user_name' class='follow_friend_user_name'>$user_name</a><div class='follow_friend_button follow_".$user_name."'>Follow</div></div>
            </div><hr>";
        }else{
            echo "<div href='profile.php?user_profile=$user_name' class='load_friend_container'>
            <div class='follow_suggestion_name_container'><a href='profile.php?user_profile=$user_name'><img src='$user_profile_pic' alt=''></a><a href='profile.php?user_profile=$user_name' class='follow_friend_user_name'>$user_name</a></div>
            </div><hr>";
        }
    }
}else{
    echo '<div><span style="font-size: 1.4rem;font-weight: bold;margin: 2rem 0;display: block;">Oopsie daisy, no result found</span><img src="images/not_found_friend.png" style="width:16rem;height: 18rem;border-radius:0;margin-left: 6rem"alt=""></div>';
    echo '<script>document.querySelector(".suggested_friend_show_more_button").style.display="none"</script>';
}
// echo "<div href='profile.php?user_profile=Pasta69' class='load_friend_container'>
// <div class='follow_suggestion_name_container'><a href='profile.php?user_profile=Pasta69'><img src='images/bill.jpg' alt=''></a><a href='profile.php?user_profile=Pasta69' class='follow_friend_user_name'>Pasta69</a></div>
// </div><hr>
// <div href='profile.php?user_profile=Pasta69' class='load_friend_container'>
// <div class='follow_suggestion_name_container'><a href='profile.php?user_profile=Pasta69'><img src='images/bill.jpg' alt=''></a><a href='profile.php?user_profile=Pasta69' class='follow_friend_user_name'>Pasta69</a></div>
// </div><hr>
// <div href='profile.php?user_profile=Pasta69' class='load_friend_container'>
// <div class='follow_suggestion_name_container'><a href='profile.php?user_profile=Pasta69'><img src='images/bill.jpg' alt=''></a><a href='profile.php?user_profile=Pasta69' class='follow_friend_user_name'>Pasta69</a></div>
// </div><hr>
// <div href='profile.php?user_profile=Pasta69' class='load_friend_container'>
// <div class='follow_suggestion_name_container'><a href='profile.php?user_profile=Pasta69'><img src='images/bill.jpg' alt=''></a><a href='profile.php?user_profile=Pasta69' class='follow_friend_user_name'>Pasta69</a></div>
// </div><hr>";
?>

<script>
$('.follow_friend_button').click(function () {
                var user_name_logged_in = '<?php echo $user_name_logged_in?>';

                var user_clicked_name = $(this).attr('class')
                var user_clicked_name = user_clicked_name.substr(28);
                $.post("ajax/follow_friend_button.php", {
                    user_clicked_name: user_clicked_name,
                    user_name_logged_in: user_name_logged_in
                }, function (data) {
                    $('.follow_' + user_clicked_name).html(data);
                })
            })
</script>