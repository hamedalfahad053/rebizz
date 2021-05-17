<div class="card card-custom card-stretch gutter-b">


    <!--begin::Header-->
    <div class="card-header">
        <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon-squares text-primary"></i>
                    </span>
            <h3 class="card-label"><?= $Page_Title ?></h3>
        </div>
        <div class="card-toolbar">
        </div>
    </div>
    <!--end::Header-->

    <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Settings_SMS_Email/Create_Email_Messages') ?>"  method="post">
        <?= CSFT_Form() ?>
        <!--begin::Body-->
        <div class="card-body">

	           <?php echo  $this->session->flashdata('message'); ?>

	             <div class="form-group row">

		             <div class="col-lg-12 mt-5">
			             <label> عنوان الرسالة</label>
			             <input  name="messages_title" class="form-control" >
		             </div>

	                <div class="col-lg-12 mt-5">
		                <label>نص الرسالة</label>
		                <textarea  name="messages_text" class="summernote form-control" ></textarea>
	                </div>

                </div>
        </div>
        <!--end: Card Body-->
        <div class="card-footer">
            <div class="row">
                <div class="col-lg-6">
                    <button type="submit" class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
                </div>
                <div class="col-lg-6 text-lg-right">
                    <button type="reset" class="btn btn-danger"><?= lang('cancel_button') ?></button>
                </div>
            </div>
        </div>
    </form>


</div>
<!--end: Card-->