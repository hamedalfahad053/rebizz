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

    <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Settings/Update_Setting_Form_Design_Create_Transaction') ?>"  method="post">
        <?= CSFT_Form() ?>
        <!--begin::Body-->
        <div class="card-body">


                <div class="form-group row">
                    <div class="col-lg-12 mt-5">
                        <label>عدد الحقول بالصف الواحد</label>
                        <select name="Table_Data_page_Length"  class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
                            <?php
                            for ($x = 10; $x <= 500; $x++) {
                                echo '<option value="'.$x.'">'.$x.'</option>';
                            }
                            ?>
                        </select>
                    </div>
	                <div class="col-lg-12 mt-5">
		                <label>عدد قوائم الاختيارات بالصف الواحد</label>
		                <select name="Table_Data_page_Length"  class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
			                <?php
			                for ($x = 10; $x <= 500; $x++) {
				                echo '<option value="'.$x.'">'.$x.'</option>';
			                }
			                ?>
		                </select>
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