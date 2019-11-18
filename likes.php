
    <?php  
    define("header",true);
	include('header.php');
	// echo '<body>';
    include('classes/user.php');
    include('classes/post.php');
    if (isset($_SESSION['user_name_log_in'])) {
		$userLoggedIn=$_SESSION['user_name_log_in'];
		$user_details_query=mysqli_query($con,"SELECT * FROM users WHERE user_name ='$userLoggedIn'");
		$row=mysqli_fetch_array($user_details_query);
	}else{
		header('location: index.php');
	}

	//Get id of post
	if(isset($_GET['post_id'])) {
		$post_id = $_GET['post_id'];
	}

    $get_likes = mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
	$row = mysqli_fetch_array($get_likes);
	$total_likes = $row['likes']; 
	$user_liked = $row['added_by'];

	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE user_name='$user_liked'");
	$row = mysqli_fetch_array($user_details_query);
    
    //Like button
	if(isset($_POST['like_button'])) {
		$total_likes++;
		$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
		$insert_user = mysqli_query($con, "INSERT INTO likes VALUES('', '$userLoggedIn', '$post_id')");

		//Insert Notification
	}
	//Unlike button
	if(isset($_POST['unlike_button'])) {
		$total_likes--;
		$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
		$insert_user = mysqli_query($con, "DELETE FROM likes WHERE user_name='$userLoggedIn' AND post_id='$post_id'");
    }
    //Check for previous likes
	$check_query = mysqli_query($con, "SELECT * FROM likes WHERE user_name='$userLoggedIn' AND post_id='$post_id'");
	$num_rows = mysqli_num_rows($check_query);

	if($num_rows > 0) {
        echo '<form action="likes.php?post_id=' . $post_id . '" method="POST">
            <div class="likes-container">    
			<div class="like_value">
				'.$total_likes.'
			</div>
				<input type="submit" class="comment_like" name="unlike_button" value="Unlike">
            </div>
			</form>
		';
    }
    
	else {
        echo '<form action="likes.php?post_id=' . $post_id . '" method="POST">
            <div class="likes-container">    
			<div class="like_value">
				'.$total_likes.'
			</div>
				<input type="submit" class="comment_like" name="like_button" value="Like">
            </div>
			</form>
		';
	}


	?>




</body>
</html>