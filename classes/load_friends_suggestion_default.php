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
        // add the show only ppl with same categories
        $query_all_user=mysqli_query($this->con,"SELECT * FROM users WHERE user_name!='$user_logged_in' order by RAND() DESC  LIMIT 5");
        while ($query_all_user_array=mysqli_fetch_array($query_all_user)){
            $user_name=$query_all_user_array['user_name'];
            
            // to not show already followed ppl
            $user_logged_in_following=$query_all_user_array['followers'];
                if ( (strstr($user_logged_in_following,$user_name)==false) && ($user_name !='') && ($user_name !=' ')) {
                    $user_profile_pic=$query_all_user_array['profile_pic'];
                    echo "
                    <div href='profile.php?user_profile=$user_name' class='load_friend_container'>
                    <div class='follow_suggestion_name_container'><a href='profile.php?user_profile=$user_name'><img src='$user_profile_pic' alt=''></a><a href='profile.php?user_profile=$user_name' class='follow_friend_user_name'>$user_name</a><div class='follow_friend_button follow_".$user_name."'>Follow</div></div>
                    </div><hr>";
                }
            
        }
    }
}
?>