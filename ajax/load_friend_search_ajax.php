<link rel="manifest" href="/../js/manifest.json"></link>

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

$query_names=mysqli_query($con,"SELECT * FROM users WHERE user_name LIKE '%$input_val%' and user_name not like '$user_name_logged_in'");
$query_names_user_logged_in=mysqli_query($con,"SELECT * FROM users WHERE user_name='$user_name_logged_in'");
$query_names_user_logged_in_array=mysqli_fetch_array($query_names_user_logged_in);
if (mysqli_num_rows($query_names)>0) {
while($query_names_array = mysqli_fetch_array($query_names)){
    // user logged in friend string
    $friend_list=$query_names_user_logged_in_array['followers'];
    $user_name=$query_names_array['user_name'];
    $user_profile_pic=$query_names_array['profile_pic'];
    if (strstr($friend_list,$user_name)==false) {
        echo "<div class='load_friend_search_div'>
        <div class='friend_image_div_search_friend'>
            <img src='$user_profile_pic' alt='' srcset=''class='friend_image_search_friend'>
        </div>
        <div class='friend_name_commen_friends'>
            <a href='profile.php?user_profile=$user_name'>
            <div class='friend_name'><span>$user_name</span></div>
            <div class='friend_commen_friends'><span>12 commen friend<span></div>
            </a>
        </div>
        <div class='follow_friend_button_search_friend follow_friend_button_search_friend_$user_name'>Follow</div>
        <div class=''></div>
        </div>";
    }else{
        echo "<div class='load_friend_search_div'>
        <div class='friend_image_div_search_friend'>
            <img src='$user_profile_pic' alt='' srcset=''class='friend_image_search_friend'>
        </div>
        <div class='friend_name_commen_friends'>
            <a href='index.php'>
            <div class='friend_name'><span>$user_name</span></div>
            <div class='friend_commen_friends'><span>12 commen friend<span></div>
            </a>
        </div>
        <div class=''></div>
    </div>
    ";
    }
}
echo "  </div>
<div class='load_friend_search_container_bottom'>
<div class='no_more_result_search_friend'>No more results</div>
</div>";

}else{
    echo '<div><span style="font-size: 2.4rem;text-align:center;font-weight: bold;margin: 4rem 0;display: block;">Oopsie daisy, no result found</span><img src="images/not_found_friend.png" style="width: 16rem;height: 18rem;border-radius: 0;margin-left: 14rem;margin-top: 5rem;"alt=""></div>';
       
}
?>

<script>
$('.follow_friend_button_search_friend').click(function(){
// 43
var user_name_logged_in='<?php echo $user_name_logged_in?>';

    var user_clicked_name=$(this).attr('class')
    var user_clicked_name = user_clicked_name.substr(70);
    $.post("ajax/follow_friend_button_search.php",{
        user_clicked_name:user_clicked_name,
        user_name_logged_in:user_name_logged_in
    },function(data){
        $('.follow_friend_button_search_friend_'+user_clicked_name).html(data);
    })
})
</script>