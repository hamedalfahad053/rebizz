<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Mobile Toggle-->
            <button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none" id="kt_subheader_mobile_toggle">
                <span></span>
            </button>
            <!--end::Mobile Toggle-->
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


        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon-users-1 text-primary"></i>
                    </span>
                    <h3 class="card-label">اضافة فرع جديد</h3>
                </div>
            </div>
            <div class="card-body">

                <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Company_Locations/Create_Locations') ?>" method="post">

                    <?= CSFT_Form() ?>


                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-lg-4 mt-5">
                                <label>اسم الفرع بالعربية</label>
                                <input type="text" name="Locations_ar" class="form-control" placeholder=""/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>اسم الفرع بالانجليزية</label>
                                <input type="text" name="Locations_en" class="form-control" placeholder=""/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Status_group') ?> </label>
                                <select name="Locations_Status" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
                                    <?php
                                    foreach ($options_status AS $key => $value)
                                    {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-lg-3 mt-5">
                                <label><?= lang('companies_Commercial_Registration_No') ?></label>
                                <input type="text" name="Locations_Commercial_Registration_No" class="form-control" placeholder="<?= lang('companies_Commercial_Registration_No') ?>"/>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label><?= lang('companies_Unified_record_number') ?></label>
                                <input type="text" name="Locations_Unified_record_number" class="form-control" placeholder="<?= lang('companies_Unified_record_number') ?>"/>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label><?= lang('Global_Registration_Date') ?></label>
                                <input type="text" name="Locations_Registration_Date" class="form-control datepicker" placeholder="<?= lang('Global_Registration_Date') ?>"/>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label><?= lang('Global_Expiry_Date') ?></label>
                                <input type="text" name="Locations_Expiry_Date" class="form-control col-12 datepicker" placeholder="<?= lang('Global_Expiry_Date') ?>"/>
                            </div>
                        </div>



                        <div class="form-group row">
                            <div class="col-lg-3 mt-5">
                                <label><?= lang('Global_Country') ?></label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select name="Locations_Country_id" id="companies_Country_id" title="اختر من فضلك "  class="form-control selectpicker" data-size="7" data-live-search="true" >
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label><?= lang('Global_Region_province') ?></label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select name="Locations_Region_id" id="companies_Region_id" title="اختر من فضلك " class="form-control selectpicker" data-size="7" data-live-search="true" >
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label><?= lang('Global_City') ?></label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select  name="Locations_City_id" id="companies_City_id" title="اختر من فضلك " class="form-control selectpicker" data-size="7" data-live-search="true" >
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label><?= lang('Global_District') ?></label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select name="Locations_District_id" id="companies_District_id" title="اختر من فضلك " class="form-control selectpicker" data-size="7" data-live-search="true" >
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>


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
                $("#companies_Country_id").empty();
                $.each(data, function (key, value) {
                    $("#companies_Country_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
                });
                $("#companies_Country_id").selectpicker('refresh');
            },
            error: function () {
                swal.fire(" خطا ", "في ارسال الطلب ", "error");
            }
        });
    } // function get_Countries()

    get_Countries();

    $('#companies_Country_id').change(function(event){
        event.preventDefault();
        var Country_id  = $('select[name=Locations_Country_id]').val();
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
                $("#companies_Region_id").empty();
                $.each(data, function (key, value) {
                    $("#companies_Region_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
                });
                $("#companies_Region_id").selectpicker('refresh');
            },
            error: function () {
                swal.fire(" خطا ", "في ارسال الطلب ", "error");
            }
        });
    });



    $('#companies_Region_id').change(function(event){
        event.preventDefault();
        var Country_id  = $('select[name=Locations_Country_id]').val();
        var Region_id   = $('select[name=Locations_Region_id]').val();
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
                $("#companies_City_id").empty();
                $.each(data, function (key, value) {
                    $("#companies_City_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
                });
                $("#companies_City_id").selectpicker('refresh');
            },
            error: function () {
                swal.fire(" خطا ", "في ارسال الطلب ", "error");
            }
        });
    });


    $('#companies_City_id').change(function(event){
        event.preventDefault();
        var Country_id  = $('select[name=Locations_Country_id]').val();
        var Region_id   = $('select[name=Locations_Region_id]').val();
        var City_id     = $('select[name=Locations_City_id]').val();
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
                $("#companies_District_id").empty();
                $.each(data, function (key, value) {
                    $("#companies_District_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
                });
                $("#companies_District_id").selectpicker('refresh');
            },
            error: function () {
                swal.fire(" خطا ", "في ارسال الطلب ", "error");
            }
        });
    });

</script>
