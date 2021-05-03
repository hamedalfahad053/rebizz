<?php echo  import_css(BASE_ASSET.'plugins/file_uplode/uploadfile',''); ?>
<?php echo  import_js(BASE_ASSET.'plugins/file_uplode/jquery.uploadfile.min',''); ?>



<div id="fileuploader">مرفقات المعاملة</div>

<div id="extrabutton" class="ajax-file-upload-green">تحميل</div>

<div id="message_file_uploader"></div>


<?php
$get_list_type_file = Creation_List_HTML('select', 'LIST_PROPERTY_PICTURES', '', '', 'options', '', '', '', '', '', '', '', '');
?>
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
	        html += "<div class='col-lg-12 mt-5'><label>نوع الصورة</label>";
	        html += '<?php echo  $get_list_type_file ?>';
            html += "<input type='hidden'  name='preview_id' value='<?= $Coordination->Coordination_id ?>'>";
            html += "<input type='hidden'  name='Transaction_id' value='<?= $Transactions->transaction_id ?>'>";
            html += "</div>";
            html += "</div>";
            return html;
        },
	    onSuccess:function(files,data,xhr,pd)
	    {
		    $("#message_file_uploader").html($("#message_file_uploader").html() + data);
	    },
	    afterUploadAll:function(obj)
	    {
		    swal.fire("نجاح",'تم تحميل جميع الصور', "success");
	    },
        autoSubmit:false,
    });


    $("#extrabutton").click(function(){
        extraObj.startUpload();
    });


</script>