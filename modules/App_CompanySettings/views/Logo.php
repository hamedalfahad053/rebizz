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

    <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Settings/Update_Logo') ?>" enctype="multipart/form-data" method="post">
        <?= CSFT_Form() ?>
                <!--begin::Body-->
                <div class="card-body">
                        <div class="form-group row">

                            <div class="form-group row">
                                <div class="col-lg-6 mt-5">
                                    <label>شعار الشركة</label>
                                    <input type="file" name="logo_company" class="form-control-file"/>
                                </div>
                                <div class="col-lg-6 mt-5">

                                </div>
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

<script type="text/javascript">
    var logo_company = new KTImageInput('logo_company');
</script>
