<!--Start Model Form Add Fields-->
<div class="modal fade" id="Model_FormCreate_Sections_Form_Components" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="form" id="FormCreateSections" action="#" method="get">
                <input type="hidden" name="Components_id" value="1">
                <div class="card card-custom mb-10 mt-10">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
                            <h3 class="card-label"> اضافة قسم جديد  </h3>
                        </div>
                        <div class="card-toolbar"></div>
                    </div>

                    <div class="card-body">

	                    <div class="form-group row">
		                    <div class="col-lg-4 mt-5">
			                    <label>العنوان باللغة العربية</label>
			                    <input type="text" id="Sections_title_ar" name="Sections_title_ar" class="form-control" placeholder="<?= lang('name_group') ?>"/>
		                    </div>
		                    <div class="col-lg-4 mt-5">
			                    <label>العنوان باللغة الانجليزية</label>
			                    <input type="text" id="Sections_title_en" name="Sections_title_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
		                    </div>
		                    <div class="col-lg-4 mt-5">
			                    <label> الحالة </label>
			                    <select id="Sections_Status" name="Sections_Status" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
				                    <?php
				                    foreach ($status AS $key => $value)
				                    {
					                    echo '<option value="'.$key.'">'.$value.'</option>';
				                    }
				                    ?>
			                    </select>
		                    </div>
	                    </div>

                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" id="buttonCreateSections" class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
                            </div>
                            <div class="col-lg-6 text-lg-right">
                                <button   class="btn btn-danger"><?= lang('cancel_button') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Model Form Add Fields-->