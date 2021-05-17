<div class="card card-custom mb-5">
    <!--begin::Header-->
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">ملاحظات عامة للمعاملة</h3>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Create_Note_Transaction/'.$this->uri->segment(4)) ?>" method="post">
        <div class="card-body">
        <?= CSFT_Form() ?>

            <div class="form-group row">
                <div class="col-lg-12">
                    <textarea name="Note_Transaction" class="summernote" ></textarea>
                </div>
            </div>


        </div>
        <div class="card card-custom  mt-10">
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary mr-2"> حفظ الملاحظة </button>
                    </div>
                    <div class="col-lg-6 text-lg-right">
                    </div>
                </div>
            </div>
        </div>
    </form>


</div>
<!--end: Card-->





<script>
    $('.kt_timepicker').timepicker();

    $('.summernote').summernote({
        height: 150
    });
</script>
