<?php echo  import_css(BASE_ASSET.'plugins/file_uplode/uploadfile',''); ?>
<?php echo  import_js(BASE_ASSET.'plugins/file_uplode/jquery.uploadfile.min',''); ?>



<div id="fileuploader">مرفقات المعاملة</div>

<div id="extrabutton" class="ajax-file-upload-green">تحميل</div>

<div id="message_file_uploader"></div>



<script type="text/javascript">
    var extraObj = $("#fileuploader").uploadFile({

        url:"<?= base_url("App_Ajax/Ajax_Uploaded_File_Previewer") ?>",
        fileName:"file_att",
        showPreview:true,
        showDelete: true,
        previewHeight: "150px",
        previewWidth: "150px",
        extraHTML:function()
        {
            var html = "<div class='form-group'>";
            html += "<div class='col-lg-12'><label>اسم الصورة</label><input type='text' class='form-control' name='file_name' value='' /></div>";
            html += "<input type='hidden'  name='preview_id' value='<?= $Coordination->Coordination_id ?>'>";
            html += "<input type='hidden'  name='Transaction_id' value='<?= $Transactions->transaction_id ?>'>";
            html += "</div>";
            html += "</div>";
            return html;
        },
        autoSubmit:false,
    });


    $("#extrabutton").click(function(){
        extraObj.startUpload();
    });


</script>