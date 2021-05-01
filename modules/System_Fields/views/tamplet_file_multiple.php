	<?php echo  import_css(BASE_ASSET.'plugins/file_uplode/uploadfile',''); ?>
	<?php echo  import_js(BASE_ASSET.'plugins/file_uplode/jquery.uploadfile.min',''); ?>
	<div id="fileuploader">مرفقات المعاملة</div>
	<div id="extrabutton" class="ajax-file-upload-green">تحميل المرفقات</div>
	<div id="message_file_uploader">

	</div>
	<?php
	$get_list_type_file = Creation_List_HTML('select', 'LIST_TRANSACTION_DOCUMENTS', '', '', 'options', '', '', '', '', '', '', '', '');
	?>
	<script type="text/javascript">
		var extraObj = $("#fileuploader").uploadFile({

			url:"<?= base_url("App_Ajax/Ajax_Uploaded_File_Transaction") ?>",
			fileName:"file_att",
			showPreview:false,
			previewHeight: "150px",
			previewWidth: "150px",
			extraHTML:function()
			{
				var html = "<div class='form-group'>";
						html += "<div class='col-lg-12'><label>اسم المستند</label><input type='text' class='form-control' name='file_name' value='' /></div>";
						html += "<div class='col-lg-12 mt-5'><label>نوع المستند</label>";
				        html += '<?php echo  $get_list_type_file ?>';
				        html += "</div>";
					html += "</div>";
				return html;
			},
			autoSubmit:false,
			onSuccess:function(files,data,xhr,pd)
			{
				$("#message_file_uploader").html($("#message_file_uploader").html() + data);
			}
		});

		$("#extrabutton").click(function(){
			extraObj.startUpload();
		});
	</script>