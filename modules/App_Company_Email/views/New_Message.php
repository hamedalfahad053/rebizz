



        <form class="form" name="" action="<?= base_url(ADMIN_NAMESPACE_URL.'/Dashboard/Send_Message') ?>" method="post" enctype="multipart/form-data">
            <?= CSFT_Form() ?>
            <input type="hidden" name="student_id" value="<?= $Student->id ?>">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon2-shield text-primary"></i>
                            </span>
                        <h3 class="card-label"><?= $Page_Title ?></h3>
                    </div>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body">
                    <?php echo  $this->session->flashdata('message'); ?>
                    <div class="form-group row">
	                    <div class="col-lg-12 mt-5">
		                    <label>اسم الطالب</label>
		                    <input type="text"  class="form-control" disabled="disabled" value="<?= $Student->full_name ?>"/>
	                    </div>

                        <div class="col-lg-12 mt-5">
                            <label>عنوان الرسالة :</label>
                            <input type="text" name="title" class="form-control" required="required" placeholder="فضلا ادخل عنوان الرسالة"/>
                        </div>
                        <div class="col-lg-12 mt-5">
                            <label>نص الرسالة :</label>
                            <textarea  rows="10" name="message" class="form-control summernote" required="required" placeholder="فضلا ادخل عنوان الرسالة" ></textarea>
                        </div>

	                    <div class="col-lg-12 mt-5">
		                    <label>مرفق</label>
		                    <input type="file" name="file" class="form-control-file" />
	                    </div>

                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary mr-2">ارسال الرسالة</button>
                        </div>
                        <div class="col-lg-6 text-lg-right">
                        </div>
                    </div>
                </div>
            </div>
        </form>

>


<script type="text/javascript">
	$('.summernote').summernote({
		height: 150
	});
</script>