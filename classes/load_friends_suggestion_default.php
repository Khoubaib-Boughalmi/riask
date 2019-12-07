<?php

class load_friends_default{

    private $con;
    private $user_logged_in;

    public function __construct($con,$user_logged_in){
        $this->con=$con;
        $this->user_logged_in=$user_logged_in;
    }

    public function load_friends_default_function(){
        $user_logged_in=$this->user_logged_in;
        $query_user_logged_in=mysqli_query($this->con,"SELECT * FROM users WHERE user_name='$user_logged_in'");
        $user_logged_in_array=mysqli_fetch_array($query_user_logged_in);
        $user_logged_in_tags=$user_logged_in_array['tags_user'];
        $user_logged_in_tags = explode(",", $user_logged_in_tags);
        $user_tag1 = $user_logged_in_tags[1];
        $user_tag2 = $user_logged_in_tags[2];
        $user_tag3 = $user_logged_in_tags[3];
        // return print_r($user_logged_in_tags);
        $query_all_user=mysqli_query($this->con,"SELECT * FROM users WHERE (user_name!='$user_logged_in') and (tags_user like'%$user_tag1%' or tags_user like'%$user_tag2%' or tags_user like'%$user_tag3%') order by RAND() DESC  LIMIT 5");
        while ($query_all_user_array=mysqli_fetch_array($query_all_user)){
            $user_name=$query_all_user_array['user_name'];
            
            // to not show already followed ppl
            $user_logged_in_following=$user_logged_in_array['followers'];
            if ($user_name =!' ') {
                if ( (strstr($user_logged_in_following,$user_name)==false) && ($user_name !='')) {
                    $user_profile_pic=$query_all_user_array['profile_pic'];
                    echo "
                    <div href='profile.php?user_profile=$user_name' class='load_friend_container'>
                    <div class='follow_suggestion_name_container'><a href='profile.php?user_profile=$user_name'><img src='$user_profile_pic' alt=''></a><a href='profile.php?user_profile=$user_name' class='follow_friend_user_name'>$user_name</a><div class='follow_friend_button follow_".$user_name."'>Follow</div></div>
                    </div><hr>";
                }
            }
        }
    }
}
?>