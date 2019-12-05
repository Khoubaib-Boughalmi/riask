<?php
include "../db.php";
if (isset($_POST['user_logged_in'])) {
    $user_name = $_POST['user_logged_in'];
}
include('../classes/load_category_main.php');
$category_obj=new category_main($con);
?>
<script>
    var tags = sessionStorage.getItem("tags");
    var title = sessionStorage.getItem("title");
    var selected_category_val = sessionStorage.getItem("selected_category_val");
</script>
 <div class="create-post-tags-title">
                        <div class="create-post-tags-title-container">
                            <div class="create-post-category">
                                <h3 class="h3-create-post">Select a category for the post</h3>
                                <div class="input-create-post-div input-create-post-category">
                                
                                    <!-- <input type="text" class="create-post-category-input" placeholder="eg: php java c#"> -->
                                    <select name="select_category" value='Select Category'class="select_category" id="">
                                   <?php $category_obj->load_category_create_post() ?>
                                    </select>
                                </div>
                                

                            </div>
                            <div class="create-post-tags">
                                <h3 class="h3-create-post">What languages, technologies, and/or frameworks is your
                                    question about?</h3>
                                <h4 class="h4-create-post">Tags help the right people find and answer your question.
                                </h4>
                                <div class="input-create-post-div input-create-post-tags">
                                    <div class="top_tag">
                                        <!-- <span class='tags_value'>php<span class="delete_tag">+</span></span>
                        <span class='tags_value'>java<span class="delete_tag">+</span></span>-->

                                    </div>
                                    <input type="text" class="create-post-tags-input" placeholder="eg: php java c#">
                                    <div class="bottom_tag">
                                        <span class="delete_tag">+</span>

                                    </div>
                                </div>
                                <div class='results_container_tags' style="">
                                    <p class="tags_create_post"></p>
                                </div>

                            </div>
                            
                            <div class="create-post-title">
                                <h3 class="h3-create-post">Tile for the</h3>
                                <h4 class="h4-create-post">Tags help the right people find and answer your question.
                                </h4>
                                <div class="input-create-post-div input-create-post-title">

                                    <input type="text" class="create-post-title-input" placeholder="eg: php java c#">
                                    <div class="bottom_tag">
                                        <span class="delete_title">+</span>

                                    </div>
                                </div>
                                <div class='results_container_title' style="">
                                    <p class="title_create_post"></p>
                                </div>

                                <div class="next_previous_button_create_post next_botton_tags_title">Next</div>
                            </div>
                        </div>
                        <div class="create-post-tags-title-container-empty"></div>
                    </div>
<script>
    document.querySelector('.user-name-menu').addEventListener("click", function () {
            document.querySelector('.slide-menu-wraper').style.display = "block";
        });
        // insert title value  
        $('.create-post-title-input').val(title)
        // insert tags
        if (tags.length>0) {
            $('.top_tag').css('padding','.65rem 0rem')
            var tags_top_tag_array = tags.split(',')
            for (let i = 0; i < tags_top_tag_array.length-1; i++) {
            $('.top_tag').append('<span class="tags_value tags_value_'+tags_top_tag_array[i]+'">'+tags_top_tag_array[i]+'</span>')           
            }
        }
        // insert category
        $('.select_category').val(selected_category_val)


            $('.next_botton_tags_title').click(function () {
                var selected_category_val = $("select.select_category").children("option:selected").val();
                var title_value = $('.create-post-title-input').val();
                var title_length = title_value.length;
                if ($('.tags_value').length>0 ) {
                    if (title_length>10) {
                        var user_logged_in = '<?php echo $user_name; ?>';
                var tags;
            var all_tags = '';
            $('.tags_value').each(function () {
                tags = ','+$(this).attr('class') ;
                tags = tags.substr(22);
                tags=tags.trim()
                all_tags = all_tags.concat(tags);
            })
            all_tags=all_tags.trim()
            sessionStorage.setItem("tags", all_tags);
            var title = $('.create-post-title-input').val()
            title=title.trim()
            sessionStorage.setItem("title", title)
            sessionStorage.setItem("selected_category_val", selected_category_val);
;

            $('.tags_title').html(all_tags)
                $.ajax({
                    url: 'creat-post-files/description-create-post.php',
                    type: 'POST',
                    data: {
                        user_logged_in: user_logged_in
                    },
                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('.ajax-insert').html(data);

                    }
                })

                $('.botton1').removeClass('active_btn_tag');
                $('.botton2').addClass('active_btn_tag');
            }else{
                        simpleNotify.notify('Title should be at least 10 charcters', 'danger');
                    }
                }
                    
                
                else{
                    simpleNotify.notify('There must be at least one tag', 'danger');

                }
            })
           
            $('.create-post-tags-input').keyup(function () {
                var tag_val = $('.create-post-tags-input').val();
                var user_logged_in = '<?php echo $user_name ;?>';
                $('.results_container_tags').css('display', 'flex');

                $.ajax({
                    url: 'get_tags.php',
                    type: 'POST',
                    data: {
                        tag: tag_val,
                        user_logged_in: user_logged_in
                    },
                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('.tags_create_post').html(data);

                    }
                })

                if (tag_val.length == 0) {
                    $('.results_container_tags').css('display', 'none')
                }
            });

        $('.delete_tag').click(function () {
            $('.top_tag').html('');
        })
        // ***********************************************
        $('.create-post-title-input').keyup(function () {
            var title_val = $('.create-post-title-input').val();
            var user_logged_in = '<?php echo $user_name ;?>';

            $.ajax({
                url: 'get_title.php',
                type: 'POST',
                data: {
                    title: title_val,
                    user_logged_in: user_logged_in
                },
                error: function () {
                    alert('error');
                },
                success: function (data) {
                    $('.title_create_post').html(data);
                }
            })
            $('#tags_title').html('<?php echo $user_name; ?>');

            if (title_val.length == 0) {
                $('.results_container_title').css('display', 'none')
            }
        });

        $('.delete_title').click(function () {
            $('.create-post-title-input').val('');

        })
</script>