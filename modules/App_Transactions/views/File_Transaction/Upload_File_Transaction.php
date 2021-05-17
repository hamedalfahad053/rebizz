<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">

            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5 right"  >
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5"><?= $Page_Title ?></h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <?= $breadcrumbs ?>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->

        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <a href="<?= base_url(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transactions->uuid) ?>" class="btn btn-success">
                <i class="flaticon2-back"></i>   العودة للمعاملة
            </a>
        </div>
        <!--end::Toolbar-->
    </div>
</div>
<!--end::Subheader-->

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">




        <div class="row">

            <div class="col-lg-12 mt-5">

                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon-squares text-primary"></i>
                            </span>
                            <h3 class="card-label"><?= $Page_Title ?></h3>
                        </div>
                        <div class="card-toolbar"></div>
                    </div>
                    <div class="card-body">


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

			                    url:"<?= base_url(APP_NAMESPACE_URL."/File_Transaction/Submit_Upload_File_Transaction") ?>",
			                    fileName:"file_att",
			                    showPreview:false,
			                    previewHeight: "150px",
			                    previewWidth: "150px",
			                    extraHTML:function()
			                    {
				                    var html = "<div class='form-group'>";
				                    html += "<div class='col-lg-12'><label>اسم المستند</label><input type='text' class='form-control' name='file_name' value='' /></div>";
				                    html += "<input type='hidden'  name='transaction_id' value='<?= $Transactions->transaction_id ?>' />";
				                    html += "<div class='col-lg-12 mt-5'><label>نوع المستند</label>";
				                    html += '<?=  $get_list_type_file ?>';
				                    html += "</div>";
				                    html += "</div>";
				                    return html;
			                    },
			                    autoSubmit:false,
			                    onSuccess:function(files,data,xhr,pd)
			                    {
				                    $("#message_file_uploader").html($("#message_file_uploader").html() + data);
			                    },
			                    afterUploadAll:function(obj)
			                    {
				                    swal.fire("نجاح",'تم تحميل جميع المرفقات', "success");
			                    }
		                    });

		                    $("#extrabutton").click(function(){
			                    extraObj.startUpload();
		                    });
	                    </script>




                    </div>
                </div>



            </div><!--<div class="col-lg-12 mt-5">-->



        </div>



    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->