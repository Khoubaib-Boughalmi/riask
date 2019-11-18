<?php
class user{
    private $con;
    private $user_name_loged_in;
    public function __construct($con,$user_name_loged_in)
    {
        $this->con=$con;
        $user_name_query=mysqli_query($con,"SELECT * FROM users WHERE user_name='$user_name_loged_in'");
        $this->user_name_loged_in=mysqli_fetch_array($user_name_query);
    }

    public function get_first_last_name(){ 
        $first_name=$this->user_name_loged_in['first_name'];
        $last_name=$this->user_name_loged_in['last_name'];
        return $first_name.' '.$last_name; 
    }

    public function get_first_name(){ 
        $first_name=$this->user_name_loged_in['first_name'];
        return $first_name; 
    }

    public function get_last_name(){ 
        $last_name=$this->user_name_loged_in['last_name'];
        return $last_name; 
    }

    public function get_bio(){ 
        $bio=$this->user_name_loged_in['user_bio'];
        return $bio; 
    }
    public function get_profile_pic(){ 
        $profile_pic=$this->user_name_loged_in['profile_pic'];
        return $profile_pic; 
    }
    public function get_email(){ 
        $email=$this->user_name_loged_in['email'];
        return $email; 
    }
    public function get_categories(){ 
        $categories=$this->user_name_loged_in['categories'];
        return $categories; 
    }

    public function get_user_name(){ 
        $user_name_loged_in=$this->user_name_loged_in['user_name'];
        return $user_name_loged_in; 
    }

    public function get_user_password(){ 
        $password=$this->user_name_loged_in['password'];
        return $password; 
    }

    public function number_of_posts(){
        $num_posts=$this->user_name_loged_in['number_posts'];
        return $num_posts;
    }
    public function followers(){
        $followers=$this->user_name_loged_in['followed_by'];
        return $followers;
    }
    public function follower_list(){
        $followers=$this->user_name_loged_in['followers'];
        return $followers;
    }
    // public function num_followers(){
        //     $comp = 0;
        //     $num_followers= $this->followers();
        //     $len_followers = strlen($num_followers);
        //     for ($i=0; $i <$len_followers ; $i++) { 
            //         if ($num_followers[$i] == ',') {
                //             $comp +=1;
                //         }
                //     }
                //     return $comp;
    // }
    public function is_friend($user_to_check){
        // $user_to_check = $user_to_check.',';
        if (strstr($this->user_name_loged_in['followers'],$user_to_check)) {
            return true;
        }else{
            return false;
        }
    }
    
    
    public function load_followed_list($follwed_list){
        $followed_result = '';
        $con = $this->con;
        $list_array = explode( ',', $follwed_list ) ;
        for ($i=1; $i < count($list_array); $i++) {   
            if ($list_array[$i] != ' ') {

                $user_followed_obj = new user($con,$list_array[$i]);
                $followed_result .=  "
                <div class='followed_container'>
                <a href='profile.php?user_profile=$list_array[$i]'>
                <div class='followed_profile_pic' style='width: 6rem;'>
                    <img class='images-user-post'src='".$user_followed_obj->get_profile_pic()."' alt=''>
                </div>
                </a>
                <a href='profile.php?user_profile=$list_array[$i]'>
                <div class='followed_info'>
                    <span class='followed_user_name'>".$user_followed_obj->get_user_name()."</span>
                    <span class='followed_full_name'>".$user_followed_obj->get_first_last_name()."</span>
                </div>
                </a>
                <div class='infollow_followed_user_div'>
                    <span class='span-button span-button_profile span-button_profile_infollow infollow_".$list_array[$i]."'>Infollow</span>
                </div>
            </div>
            ";
            }
        }
        return $followed_result;

    }
}
?>