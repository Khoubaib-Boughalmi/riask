<?php
$con = mysqli_connect('localhost','root','','riask');
if(mysqli_connect_errno()){
    echo 'connection failled';
}

if(isset($_POST['tag'])){
    
    $tag= $_POST['tag'];
    $query_tags=mysqli_query($con,"SELECT * FROM tags WHERE tag_name like '%$tag%' order by number_post desc");
    // $query_tags=mysqli_query($con,"SELECT * FROM tags where MATCH(tag_name) AGAINST('$tag')");

    $query_tags_num=mysqli_num_rows($query_tags);
    if(!empty($tag)){
        if($query_tags_num>0){
            while($tag_name=mysqli_fetch_assoc($query_tags)){

                echo '<div class="tags_suggestion '.$tag_name['tag_name'].'">';
                echo '<span class="tag_name"> ' .$tag_name['tag_name']. '</span>';
                echo '<span class="tag_number_post"> ' .$tag_name['number_post']. ' post on this category</span>';
                echo '</div>';
            }
        }else{
            echo '<div class="tags_suggestion another">';
                echo '<span class="tag_name"> Another tag</span>';
                echo '</div>';
        }
    }
}
?>
<script>
 var str=''

$('.tags_suggestion').click(function(){



    $('.create-post-tags-input').focus()
    $('.top_tag').css('padding','.65rem 0rem')
    var tag_name = $(this).attr('class');
    var tag_name = tag_name.slice(16);
    // var string_val = $('.create-post-tags-input').val();
            // if (string_val.includes(tag_name)==false) {
                // string_val = tag_name+','+string_val
                if (tag_name !='another') {
                var final_result="<span class='tags_value tags_value_"+tag_name+"'>"+tag_name+"</span>"
                }else{
                tag_name=$('.create-post-tags-input').val()
                if (tag_name.length>0) {
                    var final_result="<span class='tags_value tags_value_"+tag_name+"'>"+tag_name+"</span>"
                    }
                }
                $('.top_tag').append(final_result)
    $('.create-post-tags-input').val('')
    $('.results_container_tags').css('display','none');

        //  add class to tag_name to know wish tag is clicked

        $('.tags_value').each(function(){
            var tag_name_val=$(this).attr('class')
             tag_name_val = tag_name_val.slice(22);

  str +=tag_name_val+','
})

$('.next_botton_create_post').click(function(){
    var title = $('.create-post-title-input').val()
sessionStorage.setItem("tags", str);
sessionStorage.setItem("title", title);
$('#mysidebarID').html(sessionStorage.getItem("tags"));
$('#mysidebarClass').html(title);

})

            
})
$('.delete_tag').click(function(){
    $('.top_tag').css('padding','1.85rem 0rem');
    $('.results_container_tags').css('display','none');


})



</script>