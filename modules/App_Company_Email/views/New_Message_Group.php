



        <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Email/Send_Message_Group') ?>" method="post" enctype="multipart/form-data">
            <?= CSFT_Form() ?>

            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon2-envelope text-primary"></i>
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
		                    <label>اختر من القائمة المرسل اليهم</label>
		                    <select name="student_ids[]"  class="form-control  selectpicker"  data-actions-box="true" title="اختر" multiple="multiple" data-size="5" data-live-search="true">
			                    <?php
			                    foreach ($users->result() as $row) {
				                    echo '<option value="' . $row->id . '">' . $row->full_name . '</option>';
			                    }
			                    ?>
		                    </select>
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





<script type="text/javascript">
	$('.summernote').summernote({
		height: 150
	});
</script>