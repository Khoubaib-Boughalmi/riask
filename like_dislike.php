<?php
 
 class likes_dislikes{

    private $con;
    private $user_logged_in;
    
    public function __construct($con,$user_logged_in){
        $this->con=$con;
        $this->user_logged_in=$user_logged_in;
    }

    public function display_likes($post_id,$title){
        $title = (string)$title;
        $title = str_replace(' ','-',$title);
        $user_logged_in=$this->user_logged_in;
        $value='';
        $likes=mysqli_query($this->con,"SELECT * FROM likes WHERE post_id='$post_id' and user_name='$user_logged_in'");
        $num_likes=mysqli_num_rows($likes);
        $marked_post=mysqli_query($this->con,"SELECT * FROM marked_post WHERE post_id='$post_id' and marked_by='$user_logged_in'");
        $marked_post_num=mysqli_num_rows($marked_post);
        if ($num_likes>0) {
            $row=mysqli_fetch_array($likes);
                if ($row['user_name']==$this->user_logged_in) {
                    if ($row['is_like']=='yes') {
                        $value="
                        <hr>
                        <div class='bottom-post disable-select'>
                        <div class='bottom_post_like_".$post_id."'>
                        <div class='riask-reaction'>
                        <span class='like-btn'> 
                        <span class='like-btn-emo like-btn-like like_".$post_id."'></span>
                        <span class='like-btn-text like_btn_".$post_id."'  style='color:#73B973;'>Liked</span> 
                                <ul class='reactions-box'> 
                                            <button class='reaction reaction-like' data-reaction='Like' name='like' id='like".$post_id."'></button>
                                        <button class='reaction reaction-love' data-reaction='dislike' id='dislike".$post_id."' name='dislike'></button> 
                                    </form>    
                                </ul>
			                </span>
                         </div>
                        </div>
                        <a class='bottom_post_componment_like_' id='comment_".$post_id."' href='show_comments.php?post_id=$post_id/$title'>
                            <form action='show_comments.php?post_id=$post_id/$title' method='POST' style='display: flex;' >
                                <img src='images/icons/comment.png' alt=''  style='height:2.1rem';>
                                <input type='submit' type='submit' value='Comments' name='span-icon-name'class='span-icon-name'>
                                </form>
                            </a>
                            <div class='bottom_post_componment_mark_post' id='bottom_post_componment_mark_post_".$post_id."'>";
                            if ($marked_post_num==0) {
                                $value.= "<img src='images/icons/mark.png' alt=''  style='height:2.1rem';>

                                <span style='' class='span-icon-name'>Mark</span>
                            </div>
                            
                            </div>
                            <hr>";
                            }else if ($marked_post_num==1) {
                                $value.= "<img src='images/icons/mark_green.png' alt=''  style='height:2.1rem;';>

                                <span style='color:#73b973;' class='span-icon-name'>Marked</span>
                            </div>
                            
                            </div>
                            <hr>";
                            }
                            
                    }else if($row['is_dislike']=='yes'){
                        $value="
                        <hr>

                        <div class='bottom-post disable-select'>
                        <div class='bottom_post_like_".$post_id."'>
                        <div class='riask-reaction'>
                        <span class='like-btn'> 
                        <span class='like-btn-emo like-btn-love like_".$post_id."'></span>
                        <span class='like-btn-text like_btn_".$post_id."' style='color:#f25268;'>Disliked</span> 
                                <ul class='reactions-box'> 
                                            <button class='reaction reaction-like' data-reaction='Like' name='like' id='like".$post_id."'></button>
                                        <button class='reaction reaction-love' data-reaction='dislike' id='dislike".$post_id."' name='dislike'></button> 
                                </ul>
			                </span>
                         </div>
                        </div>
                        <div class='icon1 icon_comment' id='comment_".$post_id."'>
                            <form action='show_comments.php?post_id=$post_id/$title' method='POST' style='display: flex;' >
                            <img src='images/icons/comment.png' alt=''  style='height:2.1rem';>
                            <input type='submit' value='Comments' name='span-icon-name'class='span-icon-name'>
                                </form>
                            </div>
                            <div class='bottom_post_componment_mark_post' id='bottom_post_componment_mark_post_".$post_id."'>";
                            if ($marked_post_num==0) {
                                $value.= "<img src='images/icons/mark.png' alt=''  style='height:2.1rem';>

                                <span style='' class='span-icon-name'>Mark</span>
                            </div>
                            
                            </div>
                            <hr>";
                            }else if ($marked_post_num==1) {
                                $value.= "<img src='images/icons/mark_green.png' alt=''  style='height:2.1rem;';>

                                <span style='color:#73b973;' class='span-icon-name'>Marked</span>
                            </div>
                            
                            </div>
                            <hr>";
                            }
                    }
                }
            
        }else{
            $value="
            <hr>

            <div class='bottom-post disable-select'>
                        <div class='bottom_post_like_".$post_id."'>
                        <div class='riask-reaction'>
                        <span class='like-btn'> 
                        <span class='like-btn-emo like-btn-default like_".$post_id."'></span>
                        <span class='like-btn-text like_btn_".$post_id."'>Like</span> 
                                <ul class='reactions-box'> 
                                        <button class='reaction reaction-like' data-reaction='Like' name='like' id='like".$post_id."'></button>
                                        <button class='reaction reaction-love' data-reaction='dislike' name='dislike'  id='dislike".$post_id."'></button> 
                                    </form>    
                                </ul>
			                </span>
                         </div>
                        </div>
                        <div class='bottom_post_componment_like_' id='comment_".$post_id."'>
                            <form action='show_comments.php?post_id=$post_id/$title' method='POST' style='display: flex;' >
                                <img src='images/icons/comment.png' alt=''  style='height:2.1rem';>
                                <input type='submit' value='Comments' name='span-icon-name'class='span-icon-name'>
                                </form>
                            </div>
                            <div class='bottom_post_componment_mark_post' id='bottom_post_componment_mark_post_".$post_id."'>";
                            if ($marked_post_num==0) {
                                $value.= "<img src='images/icons/mark.png' alt=''  style='height:2.1rem';>

                                <span style='' class='span-icon-name'>Mark</span>
                            </div>
                            
                            </div>
                            <hr>";
                            }else if ($marked_post_num==1) {
                                $value.= "<img src='images/icons/mark_green.png' alt=''  style='height:2.1rem;';>

                                <span style='color:#73b973;' class='span-icon-name'>Marked</span>
                            </div>
                            
                            </div>
                            <hr>";
                            }
        }
       
       return $value;
    }
 }
?>

