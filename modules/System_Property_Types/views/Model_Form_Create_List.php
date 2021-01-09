
<!--Start Model Form Create List-->
<div class="modal fade" id="Model_FormCreateList" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="form" id="FormCreateSections" action="<?= base_url(ADMIN_NAMESPACE_URL.'/Forms/Create_Forms') ?>" method="post">
                <div class="card card-custom mb-10 mt-10">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
                            <h3 class="card-label">اضافة  قائمة بيانات </h3>
                        </div>
                        <div class="card-toolbar"></div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-12 mt-5">
                                <label>الحالة</label>
                                <select name="List" class="form-control selectpicker" data-size="7" data-live-search="true">
                                    <?php
                                    foreach ($Get_All_List AS $Row_List)
                                    {
                                        echo '<option value="'.$Row_List->list_id.'" data-key="'.$Row_List->list_data_key.'">'.$Row_List->item_translation.'</option>';
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
	                            <button   data-dismiss="modal" aria-label="Close"  class=" btn btn-danger"><?= lang('cancel_button') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Model Form Create List-->

