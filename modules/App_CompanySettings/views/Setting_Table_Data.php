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

    <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Settings/Update_Setting_Table_Data') ?>"  method="post">
        <?= CSFT_Form() ?>
        <!--begin::Body-->
        <div class="card-body">


                <div class="form-group row">
                    <div class="col-lg-12 mt-5">
                        <label>عدد البيانات المعروضه بالجدول</label>
                        <select name="Table_Data_page_Length"  class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
	                        <option value="<?= company_settings_system($LoginUser_Company,'Table_Data_page_Length') ?>" selected><?= company_settings_system($LoginUser_Company,'Table_Data_page_Length') ?></option>
                            <?php
                            $p = 5;
                            for ($x = 5; $x <= 500; $x+=5) {
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