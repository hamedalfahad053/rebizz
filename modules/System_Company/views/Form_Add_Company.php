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

        <form class="form" name="" action="<?= base_url(ADMIN_NAMESPACE_URL.'/Company/Create_Company') ?>" method="post">
            <?= CSFT_Form() ?>

            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-squares text-primary"></i>
                                </span>
                        <h3 class="card-label"><?= lang('companies_Commercial_registry') ?></h3>
                    </div>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('companies_Category') ?></label>
                                    <?= Get_Data_List('select','LIST_BUSINESS_CATEGORIES') ?>
                                </div>
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('companies_Trade_Name') ?></label>
                                    <input type="text" name="companies_Trade_Name" class="form-control" placeholder="<?= lang('companies_Trade_Name') ?>"/>
                                </div>
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('companies_Commercial_Registration_No') ?></label>
                                    <input type="text" name="companies_Commercial_Registration_No" class="form-control" placeholder="<?= lang('companies_Commercial_Registration_No') ?>"/>
                                </div>
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('companies_Unified_record_number') ?></label>
                                    <input type="text" name="companies_Unified_record_number" class="form-control" placeholder="<?= lang('companies_Unified_record_number') ?>"/>
                                </div>
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('Global_Registration_Date') ?></label>
                                    <input type="text" name="Registration_Date" class="form-control datepicker" placeholder="<?= lang('Global_Registration_Date') ?>"/>
                                </div>
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('Global_Expiry_Date') ?></label>
                                    <input type="text" name="Expiry_Date" class="form-control col-12 datepicker" placeholder="<?= lang('Global_Expiry_Date') ?>"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12 mt-5">
                                    <label><?= lang('companies_commercial_activities') ?></label>
                                    <input type="text" name="companies_commercial_activities" class="form-control" placeholder="<?= lang('companies_commercial_activities') ?>"/>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

            <div class="card card-custom mt-10">
                <div class="card-header">
                    <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-squares text-primary"></i>
                                </span>
                        <h3 class="card-label"><?= lang('companies_Owner_information') ?></h3>
                    </div>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('companies_owner_name') ?></label>
                                <input type="text" name="companies_owner_name" class="form-control" placeholder="<?= lang('companies_owner_nam') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Nationality') ?></label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select name="owner_Nationality_id" id="Nationality_id" class="form-control selectpicker" data-size="7" data-live-search="true" >
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Identification_Number') ?></label>
                                <input type="text" name="owner_Identification_Number" class="form-control" placeholder="<?= lang('Global_Identification_Number') ?>"/>
                            </div>

                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Issued_Date') ?></label>
                                <input type="text" name="owner_Identification_Issued_Date" class="form-control datepicker" placeholder="<?= lang('Global_Issued_Date') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Expiry_Date') ?></label>
                                <input type="text" name="owner_Identification_Expiry_Date" class="form-control datepicker" placeholder="<?= lang('Global_Expiry_Date') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Issued_by') ?></label>
                                <input type="text" name="owner_Identification_Issued_by" class="form-control" placeholder="<?= lang('Global_Issued_by') ?>"/>
                            </div>

                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Mobile') ?></label>
                                <input type="text" name="owner_Mobile" class="form-control" placeholder="<?= lang('Global_Mobile') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_telephone') ?></label>
                                <input type="text" name="owner_telephone" class="form-control" placeholder="<?= lang('Global_telephone') ?>"/>
                            </div>
                            <div class="col-lg-12 mt-5">
                                <label><?= lang('Global_address') ?></label>
                                <input type="text" name="owner_address" class="form-control" placeholder="<?= lang('Global_address') ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-custom mt-10">
                <div class="card-header">
                    <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-squares text-primary"></i>
                                </span>
                        <h3 class="card-label"><?= lang('companies_Contact_information') ?></h3>
                    </div>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_telephone') ?></label>
                                <input type="text" name="companies_telephone" class="form-control" placeholder="<?= lang('Global_telephone') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Mobile') ?></label>
                                <input type="text" name="companies_Mobile" class="form-control" placeholder="<?= lang('Global_Mobile') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_email') ?></label>
                                <input type="text" name="companies_email" class="form-control" placeholder="<?= lang('Global_email') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_website') ?></label>
                                <input type="text" name="companies_website" class="form-control" placeholder="<?= lang('Global_website') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_postbox') ?></label>
                                <input type="text" name="companies_postbox" class="form-control" placeholder="<?= lang('Global_postbox') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Postal_code') ?></label>
                                <input type="text" name="companies_Postal_code" class="form-control" placeholder="<?= lang('Global_Postal_code') ?>"/>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-custom mt-10">
                <div class="card-header">
                    <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-squares text-primary"></i>
                                </span>
                        <h3 class="card-label"><?= lang('companies_address_information') ?></h3>
                    </div>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">

                        <div class="form-group row">


                            <div class="col-lg-3 mt-5">
                                <label><?= lang('Global_Country') ?></label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select name="companies_Country_id" id="companies_Country_id" class="form-control selectpicker" data-size="7" data-live-search="true" >
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label><?= lang('Global_Region_province') ?></label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select name="companies_Region_id" id="companies_Region_id" class="form-control selectpicker" data-size="7" data-live-search="true" >
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label><?= lang('Global_City') ?></label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select  name="companies_City_id" id="companies_City_id" class="form-control selectpicker" data-size="7" data-live-search="true" >
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label><?= lang('Global_District') ?></label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select name="companies_District_id" id="companies_District_id" class="form-control selectpicker" data-size="7" data-live-search="true" >
                                    </select>
                                </div>
                            </div>



                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_street') ?>  </label>
                                <input type="text" name="companies_street" class="form-control" placeholder="<?= lang('Global_street') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_building_number') ?></label>
                                <input type="text" name="companies_building_number" class="form-control" placeholder="<?= lang('Global_building_number') ?>"/>
                            </div>

                            <div class="col-lg-12 mt-5">
                                <label><?= lang('Global_details') ?> </label>
                                <input type="text" name="companies_address_details" class="form-control" placeholder="<?= lang('Global_details') ?>"/>
                            </div>

                            <div class="col-lg-12 mt-5">
                                <label><?= lang('Google_Location_on_Google') ?> </label>
                                <input type="text" name="companies_Location_on_Google" class="form-control" placeholder="<?= lang('Google_Location_on_Google') ?>"/>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-custom  mt-10">
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
            </div>

        </form>

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
                $("#Country_id,#companies_Country_id").empty();
                $.each(data, function (key, value) {
                    $("#Country_id,#companies_Country_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
                });
                $("#Country_id,#companies_Country_id").selectpicker('refresh');
            },
            error: function () {
                swal.fire(" خطا ", "في ارسال الطلب ", "error");
            }
        });
    } // function get_Countries()

    get_Countries();

    $('#companies_Country_id').change(function(event){
        event.preventDefault();
        var Country_id  = $('select[name=companies_Country_id]').val();
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
        var Country_id  = $('select[name=companies_Country_id]').val();
        var Region_id   = $('select[name=companies_Region_id]').val();
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
        var Country_id  = $('select[name=companies_Country_id]').val();
        var Region_id   = $('select[name=companies_Region_id]').val();
        var City_id     = $('select[name=companies_City_id]').val();
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


    function get_Nationality(){
        $.ajax({
            type: 'ajax',
            method: 'get',
            async: false,
            dataType: 'json',
            url: '<?= base_url( 'Ajax/Get_Nationality') ?>',
            success: function (data) {
                $("#Nationality_id").empty();
                $.each(data, function (key, value) {
                    $("#Nationality_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
                });
                $("#Nationality_id").selectpicker('refresh');
            },
            error: function () {
                swal.fire(" خطا ", "في ارسال الطلب ", "error");
            }
        });
    } // function get_Nationality()
    get_Nationality();


</script>
