<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">

            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5"><?= $Page_Title ?></h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <?= $breadcrumbs ?>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->

        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">

        </div>
        <!--end::Toolbar-->
    </div>
</div>
<!--end::Subheader-->



<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">


        <div class="card card-custom mb-10 mt-10">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
                    <h3 class="card-label">البيانات الأساسية للمعاملة</h3>
                </div>
                <div class="card-toolbar"></div>
            </div>
            <div class="card-body">

                    <div class="form-group row">
                        <div class="col-lg-3 mt-5">
                            <?= Creation_Field_HTML_input('COMMISSIONING_NUMBER') ?>
                        </div>
                        <div class="col-lg-3 mt-5">
                            <?= Creation_Field_HTML_input('TRANSACTION_NUMBER') ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3 mt-5">
                            <label><?= lang('Global_Country') ?></label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <select name="Country_id" id="Country_id" title="اختر من فضلك "  class="form-control selectpicker" data-size="7" data-live-search="true" >
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-5">
                            <label><?= lang('Global_Region_province') ?></label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <select name="Region_id" id="Region_id" title="اختر من فضلك " class="form-control selectpicker" data-size="7" data-live-search="true" >
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-5">
                            <label><?= lang('Global_City') ?></label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <select  name="City_id" id="City_id" title="اختر من فضلك " class="form-control selectpicker" data-size="7" data-live-search="true" >
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-5">
                            <label><?= lang('Global_District') ?></label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <select name="District_id" id="District_id" title="اختر من فضلك " class="form-control selectpicker" data-size="7" data-live-search="true" >
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3 mt-5">
                            <label>تصنيف العقار</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <?= Get_Data_List('select','LIST_CATEGORY_OF_THE_PROPERTY') ?>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-5">
                            <label>نوع العقار</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <select name="" id="" title="اختر من فضلك "  class="form-control selectpicker" data-size="7" data-live-search="true" >
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-5">
                            <label> العميل </label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <select name="" id="" title="اختر من فضلك "  class="form-control selectpicker" data-size="7" data-live-search="true" >
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-5">
                            <label> نموذج المعاملة </label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <select name="" id="" title="اختر من فضلك "  class="form-control selectpicker" data-size="7" data-live-search="true" >
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-3 mt-5">
                            <?= Creation_Field_HTML_input('OWNER_REAL_ESTATE') ?>
                        </div>
                        <div class="col-lg-3 mt-5">
                            <?= Creation_Field_HTML_input('OWNERS_MOBILE_NUMBER') ?>
                        </div>
                        <div class="col-lg-3 mt-5">
                            <?= Creation_Field_HTML_input('OWNER_IDENTITY_NUMBER') ?>
                        </div>
                        <div class="col-lg-3 mt-5">
                            <?= Creation_Field_HTML_input('OWNER_APPLICANT_EVALUATION') ?>
                        </div>
                        <div class="col-lg-3 mt-5">
                            <?= Creation_Field_HTML_input('OWNER_MOBILE_EVALUATION') ?>
                        </div>
                    </div>

            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <button type="button" id="buttonCreateSections" class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
                    </div>
                    <div class="col-lg-6 text-lg-right">
                        <button type="reset" class="btn btn-danger"><?= lang('cancel_button') ?></button>
                    </div>
                </div>
            </div>
        </div>




    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


<script type="text/javascript">

    var arrows;
    if (KTUtil.isRTL()) {
        arrows = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>'
        }
    } else {
        arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }

    $('.datepicker').datepicker({
        rtl: KTUtil.isRTL(),
        todayHighlight: true,
        orientation: "bottom left",
        templates: arrows
    });

    $('.selectpicker').selectpicker();

    function get_Countries(){
        $.ajax({
            type: 'ajax',
            method: 'get',
            async: false,
            dataType: 'json',
            url: '<?= base_url( 'Ajax/Get_Countries') ?>',
            success: function (data) {
                $("#Country_id").empty();
                $.each(data, function (key, value) {
                    $("#Country_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
                });
                $("#Country_id").selectpicker('refresh');
            },
            error: function () {
                swal.fire(" خطا ", "في ارسال الطلب ", "error");
            }
        });
    } // function get_Countries()

    get_Countries();

    $('#Country_id').change(function(event){
        event.preventDefault();
        var Country_id  = $('select[name=Country_id]').val();
        $.ajax({
            type: 'ajax',
            method: 'get',
            async: false,
            dataType: 'json',
            url: '<?= base_url( 'Ajax/Get_Regions') ?>',
            data: {
                Country_id: Country_id
            },
            success: function (data) {
                $("#Region_id").empty();
                $.each(data, function (key, value) {
                    $("#Region_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
                });
                $("#Region_id").selectpicker('refresh');
            },
            error: function () {
                swal.fire(" خطا ", "في ارسال الطلب ", "error");
            }
        });
    });



    $('#Region_id').change(function(event){
        event.preventDefault();
        var Country_id  = $('select[name=Country_id]').val();
        var Region_id   = $('select[name=Region_id]').val();
        $.ajax({
            type: 'ajax',
            method: 'get',
            async: false,
            dataType: 'json',
            url: '<?= base_url( 'Ajax/Get_Cites') ?>',
            data: {
                Country_id:Country_id,Region_id:Region_id
            },
            success: function (data) {
                $("#City_id").empty();
                $.each(data, function (key, value) {
                    $("#City_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
                });
                $("#City_id").selectpicker('refresh');
            },
            error: function () {
                swal.fire(" خطا ", "في ارسال الطلب ", "error");
            }
        });
    });


    $('#City_id').change(function(event){
        event.preventDefault();
        var Country_id  = $('select[name=Country_id]').val();
        var Region_id   = $('select[name=Region_id]').val();
        var City_id     = $('select[name=City_id]').val();
        $.ajax({
            type: 'ajax',
            method: 'get',
            async: false,
            dataType: 'json',
            url: '<?= base_url( 'Ajax/Get_Districts') ?>',
            data: {
                Country_id:Country_id,Region_id:Region_id,City_id:City_id
            },
            success: function (data) {
                $("#District_id").empty();
                $.each(data, function (key, value) {
                    $("#District_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
                });
                $("#District_id").selectpicker('refresh');
            },
            error: function () {
                swal.fire(" خطا ", "في ارسال الطلب ", "error");
            }
        });
    });

</script>
