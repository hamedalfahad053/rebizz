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


        <?php echo  $this->session->flashdata('message'); ?>

        <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL . '/Clients/Create_Client') ?>" method="post">
            <?= CSFT_Form() ?>

            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-squares text-primary"></i>
                        </span>
                        <h3 class="card-label"><?= lang('client_information') ?></h3>
                    </div>
                    <!-- <div class="card-toolbar">
                    </div> -->
                </div>
                <div class="card-body">
                    <div class="card-body">
                        
                    </div>
                </div>
            </div>
            <div class="card card-custom  mt-10">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-squares text-primary"></i>
                        </span>
                        <h3 class="card-label"><?= lang('client_contract_setting') ?></h3>
                    </div>
                    <!-- <div class="card-toolbar">
                    </div> -->
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-3 mt-5">
                            <label><?= lang('client_contract_file') ?> </label>
                            <input type="file" name="contract_file_id" class="form-control-file" accept=".pdf" placeholder="<?= lang('client_contract_file') ?>" />
                        </div>

                        <div class="col-sm-12 col-md-3 mt-5">
                            <label><?= lang('client_contract_start_date') ?> </label>
                            <input type="text" name="start_date" class="form-control datepicker" placeholder="<?= lang('client_contract_start_date') ?>" />
                        </div>
                        <div class="col-sm-12 col-md-3 mt-5">
                            <label><?= lang('client_contract_end_date') ?> </label>
                            <input type="text" name="end_date" class="form-control datepicker" placeholder="<?= lang('client_contract_end_date') ?>" />
                        </div>

                        <div class="col-sm-12 col-md-3 mt-5">
                            <label><?= lang('client_contract_auto_renew') ?> </label>
                            <select name="is_auto_renew" class="form-control selectpicker" data-live-search="true" data-title="اختر الحالة ">
                                <?php
                                foreach ($List_auto_renew as $key => $value) {
                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-10"></div>
                    <fieldset class="mt-10">
                        <legend class="h5">
                            <?= lang("client_contract_counter_policy") ?>
                        </legend>
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-6 mt-5">
                                <label><?= lang('client_contract_counter_format') ?> </label>
                                <input type="text" name="counter_format" class="form-control" placeholder="<?= lang('client_contract_counter_format_example') ?>" />
                            </div>
                            <div class="col-sm-12 col-md-6 mt-5">
                                <label><?= lang('client_contract_counter_start_from') ?> </label>
                                <input type="number" name="start_from" min="1" step="1" value="1" class="form-control" placeholder="<?= lang('client_contract_counter_start_from') ?>" />
                            </div>
                        </div>
                    </fieldset>

                </div>
            </div>
            <div class="card card-custom  mt-10">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-squares text-primary"></i>
                        </span>
                        <h3 class="card-label"><?= lang('client_contract_evaluation') ?></h3>
                    </div>
                    <!-- <div class="card-toolbar">
                    </div> -->
                </div>
                <div class="card-body">


                    <fieldset>
                        <legend class="h5">
                            <?= lang("client_contract_evaluation_methods") ?>
                        </legend>
                        <div class="form-group mt-5">
                            <div class="row">
                                <div class="col-sm-12 col-md-4 col-xl-3">
                                    <label class="option option-plain">
                                        <span class="option-control">
                                            <span class="checkbox">
                                                <input type="checkbox" name="m_option_1" value="1">
                                                <span></span>
                                            </span>
                                        </span>
                                        <span class="option-label">
                                            <span class="option-head">
                                                <span class="option-title">Premium Partner</span>
                                            </span>
                                            <span class="option-body">30 days free trial and lifetime free updates</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-4 col-xl-3">
                                    <label class="option option option-plain">
                                        <span class="option-control">
                                            <span class="checkbox">
                                                <input type="checkbox" name="m_option_1" value="1" checked="checked">
                                                <span></span>
                                            </span>
                                        </span>
                                        <span class="option-label">
                                            <span class="option-head">
                                                <span class="option-title">Free Membership</span>
                                            </span>
                                            <span class="option-body">24/7 support and Lifetime access</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-4 col-xl-3">
                                    <label class="option option option-plain">
                                        <span class="option-control">
                                            <span class="checkbox">
                                                <input type="checkbox" name="m_option_1" value="1" checked="checked">
                                                <span></span>
                                            </span>
                                        </span>
                                        <span class="option-label">
                                            <span class="option-head">
                                                <span class="option-title">Free Membership</span>
                                            </span>
                                            <span class="option-body">24/7 support and Lifetime access</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-4 col-xl-3">
                                    <label class="option option option-plain">
                                        <span class="option-control">
                                            <span class="checkbox">
                                                <input type="checkbox" name="m_option_1" value="1" checked="checked">
                                                <span></span>
                                            </span>
                                        </span>
                                        <span class="option-label">
                                            <span class="option-head">
                                                <span class="option-title">Free Membership</span>
                                            </span>
                                            <span class="option-body">24/7 support and Lifetime access</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="separator separator-dashed my-10"></div>
                    <fieldset>
                        <legend class="h5">
                            <?= lang("client_contract_evaluation_level") ?>
                        </legend>
                        <div class="form-group mt-5">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="kt_repeater" class="table table-border display warp" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody data-repeater-list="data">
                                            <tr data-repeater-item>
                                                <td><input type="text" class="form-control" name="this_id" value="1" /></td>
                                                <td><input type="text" class="form-control" name="this_name" /></td>
                                                <td><input type="text" class="form-control" name="" /></td>
                                                <td><a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger"><i class="la la-trash-o"></i></a></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">
                                                    <button type="button" class="btn btn-primary mr-2" data-repeater-create>Add New</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="card card-custom  mt-10">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-squares text-primary"></i>
                        </span>
                        <h3 class="card-label"><?= lang('client_property') ?></h3>
                    </div>
                    <!-- <div class="card-toolbar">
                    </div> -->
                </div>
                <div class="card-body">
                </div>
            </div>

            <div class="card card-custom  mt-10">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-squares text-primary"></i>
                        </span>
                        <h3 class="card-label"><?= lang('client_Contract_pricing') ?></h3>
                    </div>
                    <!-- <div class="card-toolbar">
                    </div> -->
                </div>
                <div class="card-body">
                </div>
            </div>

         
            <div class="card card-custom  mt-10">
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
                        </div>
                        <div class="col-lg-6 text-lg-right">
                            <!-- <button type="reset" class="btn btn-danger"><?= lang('cancel_button') ?></button> -->
                            <?= Create_One_Button_Text(array('title' => lang('cancel_button'), 'color' => 'danger', 'href' => base_url(APP_NAMESPACE_URL . '/Clients'))) ?>
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

    $('#kt_repeater').repeater({
        initEmpty: false,
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        },
        isFirstItemUndeletable: true
    });


    $('.selectpicker').selectpicker();

    // function get_Countries() {
    //     $.ajax({
    //         type: 'ajax',
    //         method: 'get',
    //         async: false,
    //         dataType: 'json',
    //         url: '<?= base_url('Ajax/Get_Countries') ?>',
    //         success: function(data) {
    //             $("#Country_id,#companies_Country_id").empty();
    //             $.each(data, function(key, value) {
    //                 $("#Country_id,#companies_Country_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
    //             });
    //             $("#Country_id,#companies_Country_id").selectpicker('refresh');
    //         },
    //         error: function() {
    //             swal.fire(" خطا ", "في ارسال الطلب ", "error");
    //         }
    //     });
    // } // function get_Countries()

    // get_Countries();

    // $('#companies_Country_id').change(function(event) {
    //     event.preventDefault();
    //     var Country_id = $('select[name=companies_Country_id]').val();
    //     $.ajax({
    //         type: 'ajax',
    //         method: 'get',
    //         async: false,
    //         dataType: 'json',
    //         url: '<?= base_url('Ajax/Get_Regions') ?>',
    //         data: {
    //             Country_id: Country_id
    //         },
    //         success: function(data) {
    //             $("#companies_Region_id").empty();
    //             $.each(data, function(key, value) {
    //                 $("#companies_Region_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
    //             });
    //             $("#companies_Region_id").selectpicker('refresh');
    //         },
    //         error: function() {
    //             swal.fire(" خطا ", "في ارسال الطلب ", "error");
    //         }
    //     });
    // });



    // $('#companies_Region_id').change(function(event) {
    //     event.preventDefault();
    //     var Country_id = $('select[name=companies_Country_id]').val();
    //     var Region_id = $('select[name=companies_Region_id]').val();
    //     $.ajax({
    //         type: 'ajax',
    //         method: 'get',
    //         async: false,
    //         dataType: 'json',
    //         url: '<?= base_url('Ajax/Get_Cites') ?>',
    //         data: {
    //             Country_id: Country_id,
    //             Region_id: Region_id
    //         },
    //         success: function(data) {
    //             $("#companies_City_id").empty();
    //             $.each(data, function(key, value) {
    //                 $("#companies_City_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
    //             });
    //             $("#companies_City_id").selectpicker('refresh');
    //         },
    //         error: function() {
    //             swal.fire(" خطا ", "في ارسال الطلب ", "error");
    //         }
    //     });
    // });


    // $('#companies_City_id').change(function(event) {
    //     event.preventDefault();
    //     var Country_id = $('select[name=companies_Country_id]').val();
    //     var Region_id = $('select[name=companies_Region_id]').val();
    //     var City_id = $('select[name=companies_City_id]').val();
    //     $.ajax({
    //         type: 'ajax',
    //         method: 'get',
    //         async: false,
    //         dataType: 'json',
    //         url: '<?= base_url('Ajax/Get_Districts') ?>',
    //         data: {
    //             Country_id: Country_id,
    //             Region_id: Region_id,
    //             City_id: City_id
    //         },
    //         success: function(data) {
    //             $("#companies_District_id").empty();
    //             $.each(data, function(key, value) {
    //                 $("#companies_District_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
    //             });
    //             $("#companies_District_id").selectpicker('refresh');
    //         },
    //         error: function() {
    //             swal.fire(" خطا ", "في ارسال الطلب ", "error");
    //         }
    //     });
    // });


    function get_Nationality() {
        $.ajax({
            type: 'ajax',
            method: 'get',
            async: false,
            dataType: 'json',
            url: '<?= base_url('Ajax/Get_Nationality') ?>',
            success: function(data) {
                $("#Nationality_id").empty();
                $.each(data, function(key, value) {
                    $("#Nationality_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
                });
                $("#Nationality_id").selectpicker('refresh');
            },
            error: function() {
                swal.fire(" خطا ", "في ارسال الطلب ", "error");
            }
        });
    } // function get_Nationality()
    get_Nationality();
</script>