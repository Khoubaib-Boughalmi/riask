<?php
class marked{
    private $con;
    private $user_obj;
    public $user_name_logged_in;
    public $categories_list;
    public function __construct($con,$user_name){
        $this->con=$con;
        $this->user_obj=new user($con,$user_name);
        $this->user_name_logged_in=$user_name;
    }


    public function load_post(){
        // strat likes obj
        include_once('like_dislike.php');
        $like_dislike_obj=new likes_dislikes($this->con,$this->user_name_logged_in);
        // end likes obj
    $count=0;
        $post="";
        $num_posts = 0;
        $user_name_logged_in = $this->user_name_logged_in;
        $query_load_post=mysqli_query($this->con,"SELECT * from marked_post where marked_by ='$user_name_logged_in' order by id DESC");
        if (mysqli_num_rows($query_load_post)>0) {
            
            while($row=mysqli_fetch_array($query_load_post)){
               
                        $id=$row['post_id'];
                        $body=$row['body'];
                        $title=$row['title'];
                        $tags=$row['tags'];


                        $title_post = (string)$title;
                        $title_post = str_replace(' ','-',$title);
                
                $query_likes=mysqli_query($this->con,"SELECT * FROM likes where post_id='$id' and is_like='yes'");
                $query_dislikes=mysqli_query($this->con,"SELECT * FROM likes where post_id='$id' and is_dislike='yes'");
                
                $query_num_likes=mysqli_num_rows($query_likes);
                $query_num_dislikes=mysqli_num_rows($query_dislikes);
                

				

                    echo "<div class='show_all_search_result_content show_all_search_result_content_$id'>
                    <div class='show_all_search_result_reactions'>
                        <div class='show_all_search_result_reaction_like' style='display: flex;align-items: flex-end;'>
                        <img src='images/green_flag.png' style='height: 2.2rem;'>
                        <span style='font-size:1.4rem; margin-left:.4rem;font-weight:bold'>$query_num_likes</span>
                        </div>
                        <div class='show_all_search_result_reaction_dislike'  style='display: flex;align-items: flex-end;'>
                        <img src='images/red_flag.png' style='height: 2.2rem;'>
                        <span style='font-size:1.4rem; margin-left:.4rem;font-weight:bold'>$query_num_dislikes</span>
                        </div>
                    </div>
                    <div class='show_all_search_result_content_title_and_subtitle'>
                        <a href='show_comments.php?post_id=$id/$title_post'>            
                            <div class='show_all_search_result_content_title'>
                                <span>$title</span>
                            </div>
                            <div class='show_all_search_result_content_subtitle'>
                                <span>$body</span>
                            </div>
                            <div class='show_all_search_result_content_tags'>";
                            $tags=$row['tags'];
                            $arr=explode(',',$tags);
                            $val=count($arr);
                            $i=0;
                            for($i=0;$i<$val-1;$i++){
                            echo '<span>'.$arr[$i].'</span>';
                            }  
                            
                            echo"
                            </div>
                        </a>
                    </div>
                    <div class='show_all_search_result_content_date'>
                    <div class='dropdown_post'>
                    <img class='ellipsis_img_post ellipsis_img_post_$id' src='images/ellipsis.png'>
                    <div id='more_option_post_div more_option_post_div_$id' class='dropdown-content_more_option_post dropdown-content_more_option_post_$id'>
                    <div class='remove_post_div remove_post_div_$id'><i class='far fa-times-circle' style='font-size: 1.3rem;'></i><span class='report_button_post'>Remove</span></div>
                    </div>
                    </div>
                    </div>
                    
            </div>";
                        $num_posts++;
                  
        
    }
        }else{
        echo 'no posts to show';
    }
    
    
    
}
}
?>