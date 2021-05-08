<?php echo  import_css(BASE_ASSET.'plugins/file_uplode/uploadfile',''); ?>
<?php echo  import_js(BASE_ASSET.'plugins/file_uplode/jquery.uploadfile.min',''); ?>






<div class="form-group row">

	<div class="col-sm-4  col-lg-4  mt-5">
		<label>صور معاينة العقار من الداخل</label>
		<div id="fileuploader_inside">صور معاينة العقار من الداخل</div>
		<div id="extrabutton_inside" class="ajax-file-upload-green">تحميل</div>
		<div id="message_file_uploader_inside"></div>
	</div>

	<div class="col-sm-4  col-lg-4  mt-5">
		<label>صور معاينة العقار من الخارج</label>
		<div id="fileuploader_outside">صور معاينة العقار من الخارج</div>
		<div id="extrabutton_outside" class="ajax-file-upload-green">تحميل</div>
		<div id="message_file_uploader_outside"></div>
	</div>

	<div class="col-sm-4  col-lg-4  mt-5">
		<label>صور الملاحظات</label>
		<div id="fileuploader_Drug_reviews">صور الملاحظات</div>
		<div id="extrabutton_Drug_reviews" class="ajax-file-upload-green">تحميل</div>
		<div id="message_file_uploader_Drug_reviews"></div>
	</div>

</div>



<script type="text/javascript">



	// _inside
    var extraObj_inside = $("#fileuploader_inside").uploadFile({
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
	        html += "<input type='hidden'  name='LIST_PROPERTY_PICTURES' value='382'>";
            html += "<input type='hidden'  name='preview_id' value='<?= $Coordination->Coordination_id ?>'>";
            html += "<input type='hidden'  name='Transaction_id' value='<?= $Transactions->transaction_id ?>'>";
            html += "</div>";
            html += "</div>";
            return html;
        },
	    onSuccess:function(files,data,xhr,pd)
	    {
		    $("#message_file_uploader_inside").html($("#message_file_uploader_inside").html() + data);
	    },
	    afterUploadAll:function(obj)
	    {
		    swal.fire("نجاح",'تم تحميل جميع الصور', "success");
	    },
        autoSubmit:false,
    });
    $("#extrabutton_inside").click(function(){
        extraObj_inside.startUpload();
    });




    // _outside
    var extraObj_outside = $("#fileuploader_outside").uploadFile({
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
		    html += "<input type='hidden'  name='LIST_PROPERTY_PICTURES' value='383'>";
		    html += "<input type='hidden'  name='preview_id' value='<?= $Coordination->Coordination_id ?>'>";
		    html += "<input type='hidden'  name='Transaction_id' value='<?= $Transactions->transaction_id ?>'>";
		    html += "</div>";
		    html += "</div>";
		    return html;
	    },
	    onSuccess:function(files,data,xhr,pd)
	    {
		    $("#message_file_uploader_outside").html($("#message_file_uploader_outside").html() + data);
	    },
	    afterUploadAll:function(obj)
	    {
		    swal.fire("نجاح",'تم تحميل جميع الصور', "success");
	    },
	    autoSubmit:false,
    });
    $("#extrabutton_outside").click(function(){
	    extraObj_outside.startUpload();
    });




	// Drug_reviews
	var extraObj_Drug_reviews = $("#fileuploader_Drug_reviews").uploadFile({
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
			html += "<input type='hidden'  name='LIST_PROPERTY_PICTURES' value='387'>";
			html += "<input type='hidden'  name='preview_id' value='<?= $Coordination->Coordination_id ?>'>";
			html += "<input type='hidden'  name='Transaction_id' value='<?= $Transactions->transaction_id ?>'>";
			html += "</div>";
			html += "</div>";
			return html;
		},
		onSuccess:function(files,data,xhr,pd)
		{
			$("#message_file_uploader_Drug_reviews").html($("#message_file_uploader_Drug_reviews").html() + data);
		},
		afterUploadAll:function(obj)
		{
			swal.fire("نجاح",'تم تحميل جميع الصور', "success");
		},
		autoSubmit:false,
	});
	$("#extrabutton_outside").click(function(){
		extraObj_Drug_reviews.startUpload();
	});

</script>