<?php 
/*
Plugin Name: AJAX File Upload
Plugin URI: 
Description: Can add ajax file uploader that returns the file url inside a form. just add inside the script tag in the footer:  <br>add_file_upload_to_form( <br>add_after, //to add after what? <br> container_css_class, //the file upload parent div<br>upload_class, // apply class to input file upload<br>image_preview_class, // apply class to preview img tag parent<br>preview_image_class// apply class to preview img tag  );  
Author:  Aamir Hussain
Version: 1.0
Author URI: 
*/


add_action('wp_footer','aamirs_footer_script');

function aamirs_footer_script(){
    ob_start();?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  function add_file_upload_to_form(add_after, container_css_class, upload_class, image_preview_class, preview_image_class){
     let the_html = '<div class="upload_container '+container_css_class+'"><input accept="image/*" type="file" class="file '+upload_class+'" name="file" /><input type="hidden" class="file_src" name="file_src" /><div class="preview '+image_preview_class+'"><img style="display:none;" src="" class="preview_img '+preview_image_class+'" width="100" height="100"></div><div class="response col"></div></div>';
     $(the_html).insertAfter(add_after);
 
     $(".file").change(function(){
 
         let fd = new FormData();
 
         let files = $(this)[0].files;
         let _this = $(this);
         // Check file selected or not
         if(files.length > 0 ){
 
             fd.append('file',files[0]);
 //
 let the_url = "<?php echo admin_url('admin-ajax.php') ?>?action=the_upload_process";
             $.ajax({
                 url:the_url,
                 type:'post',
                 data:fd,
                 contentType: false,
                 processData: false,
                 success:function(response){
                     if(response != 0){
                         console.log(response);
                         // return;
         _this.closest(".upload_container").find(".file_src").val(response);
         _this.closest(".upload_container").find('.preview img').attr("src",response).show();
         _this.closest(".upload_container").find(".response").html('Uploaded successfully').addClass('text-success');
         _this.closest(".upload_container").find(".response").focus();
                     }else{
                         _this.closest(".upload_container").find(".response").html('File not uploaded').addClass('text-danger');
                         _this.closest(".upload_container").find(".response").focus();
                     }
                 }
             });
         }else{
             alert("Please select a file.");
         }
         });
 }
 $(document).ready(function(){
 //allowed_file_types, max_file_size 

 /* add_file_upload_to_form(
      add_after, //to add after what?
      container_css_class, //the file upload parent div
      upload_class, // apply class to input file upload
      image_preview_class, // apply class to preview img tag parent
      preview_image_class// apply class to preview img tag 
 );*/       

 });

  </script>  
    <?php $html = ob_get_clean();
    echo $html;
}

add_action('wp_ajax_the_upload_process', 'the_upload_process');
add_action('wp_ajax_nopriv_the_upload_process', 'the_upload_process');
function the_upload_process(){
    include_once('upload.php');
}