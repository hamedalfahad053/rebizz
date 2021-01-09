<!--Start Model Form Add Fields-->
<div class="modal fade" id="Model_FormAddFields" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="form" id="FormAddFields" action="#" method="post">
                <input type="hidden" name="Components_id" value="1">
                <div class="card card-custom mb-10 mt-10">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
                            <h3 class="card-label"> اضافة حقل للمكون  </h3>
                        </div>
                        <div class="card-toolbar"></div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-4 mt-5">
                                <label> الحقل </label>
                                <select name="Fields_Add" class="form-control selectpicker" data-size="7" data-live-search="true">
                                    <?php
                                    foreach ($Fields_All_Data AS $Row_Field)
                                    {
                                        echo '<option value="'.$Row_Field->Fields_id.'" data-key="'.$Row_Field->Fields_key.'">'.$Row_Field->item_translation.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" id="buttonAddFieldsSections" class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
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