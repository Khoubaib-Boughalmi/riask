<?php
define("header",true);
include('header.php');?>
<input type="file" id="i_file" value=""> 
<input type="button" id="i_submit" value="Submit">
    <br>
<img src="" width="200" style="display:none;" />
<script>
// $('#i_file').change( function(event) {
//     $("img").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
//     // alert($('#i_file').files[0]))
// });

$(function(){
    $(' input:file').change( function(e) {
       
        var img = URL.createObjectURL(e.target.files[0]);
            alert(img)
    });
})
</script>