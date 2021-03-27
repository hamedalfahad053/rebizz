
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




        <div class="card card-custom">

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

            <form class="form"  action="<?= base_url(APP_NAMESPACE_URL.'/Forms/Create_Components_Forms_Transaction') ?>" method="post">
                <?= CSFT_Form() ?>


                <div class="card-body">
                    <input type="hidden" name="Forms_id" value="<?= $Forms->Forms_id; ?>">
                    <div class="form-group row">
                        <div class="col-lg-4 mt-5">
                            <label>العنوان باللغة العربية</label>
                            <input type="text" id="Sections_title_ar" name="Sections_title_ar" class="form-control" placeholder=""/>
                        </div>
                        <div class="col-lg-4 mt-5">
                            <label>العنوان باللغة الانجليزية</label>
                            <input type="text" id="Sections_title_en" name="Sections_title_en" class="form-control" placeholder=""/>
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

                    <div class="form-group row">
                        <div class="checkbox-list">

                            <label class="checkbox mt-3">
                                <input type="checkbox" value="1"  id="All_CUSTOMER_CATEGORY" name="All_CUSTOMER_CATEGORY" onclick="JS_CUSTOMER_CATEGORY()"/>
                                <span></span>
                                عام لجميع العملاء
                            </label>

                            <label class="checkbox mt-3">
                                <input type="checkbox" value="1"   id="All_Property_Types" name="All_Property_Types" onclick="JS_Property_Types()" />
                                <span></span>
                                عام لجميع العقارات
                            </label>

                            <label class="checkbox mt-3">
                                <input type="checkbox" value="1"   id="All_TYPES_APPRAISAL" name="All_TYPES_APPRAISAL" onclick="JS_TYPES_APPRAISAL()"/>
                                <span></span>
                                عام لجميع الطلبات
                            </label>

                            <label class="checkbox mt-3">
                                <input type="checkbox" value="1"  id="All_evaluation_methods" name="All_evaluation_methods"  onclick="JS_evaluation_methods()"/>
                                <span></span>
                                عام طرق التقييم
                            </label>

                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-6 mt-5">
                            <label> فئة العميل </label>
                            <?= Creation_List_HTML('select', 'LIST_CUSTOMER_CATEGORY', '','','options', '1','','','',array( 0=> "selectpicker",1=>'Select_CUSTOMER_CATEGORY'),'','','') ?>
                        </div>
                        <div class="col-lg-6 mt-5">
                            <label>  العميل </label>
                            <select id="LIST_Client" name="LIST_Client[]" multiple="multiple" class="form-control  selectpicker" data-live-search="true"  data-title="اختر من فضلك "></select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6 mt-5">
                            <label> فئة الطلب </label>
                            <?= Creation_List_HTML('select', 'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL', '','','options', '1','','','',array( 0=> "selectpicker",1=>'Select_TYPES_APPRAISAL'),'','','') ?>
                        </div>
                        <div class="col-lg-6 mt-5">
                            <label> طريقة  التقييم </label>
                            <?= Get_Select_evaluation_methods('select', '',1, array( 0=> "selectpicker",1=>'Select_evaluation_methods'),'evaluation_methods') ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6 mt-5">
                            <label> فئة العقار </label>
                            <?= Get_Select_Property_Types('select','','1', array( 0=> "selectpicker",1=>'Select_Property_Types'),'') ?>
                        </div>
                    </div>



                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit"  class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>


    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->



<script type="text/javascript">

    function JS_CUSTOMER_CATEGORY() {
        if ($("#All_CUSTOMER_CATEGORY").is(":checked")) {
            $('.Select_CUSTOMER_CATEGORY').attr('disabled', 'disabled');
            $('#LIST_Client').attr('disabled', 'disabled');
        }
        else {
            $('.Select_CUSTOMER_CATEGORY').removeAttr('disabled');
            $('#LIST_Client').removeAttr('disabled');
        }
        $('.Select_CUSTOMER_CATEGORY').selectpicker('refresh');
        $('#LIST_Client').selectpicker('refresh');
    }

    function JS_Property_Types() {
        if ($("#All_Property_Types").is(":checked")) {
            $('.Select_Property_Types').attr('disabled', 'disabled');
        }
        else {
            $('.Select_Property_Types').removeAttr('disabled');
        }
        $('.Select_Property_Types').selectpicker('refresh');
    }

    function JS_TYPES_APPRAISAL() {
        if ($("#All_TYPES_APPRAISAL").is(":checked")) {
            $('.Select_TYPES_APPRAISAL').attr('disabled', 'disabled');
        }
        else {
            $('.Select_TYPES_APPRAISAL').removeAttr('disabled');
        }
        $('.Select_TYPES_APPRAISAL').selectpicker('refresh');
    }

    function JS_evaluation_methods() {
        if ($("#All_evaluation_methods").is(":checked")) {
            $('.Select_evaluation_methods').attr('disabled', 'disabled');
        }
        else {
            $('.Select_evaluation_methods').removeAttr('disabled');
        }
        $('.Select_evaluation_methods').selectpicker('refresh');
    }


    $('#LIST_CUSTOMER_CATEGORY').change(function(event){

	    event.preventDefault();
	    var CUSTOMER_CATEGORY = $('#LIST_CUSTOMER_CATEGORY').val();

            $.ajax({
                type: 'ajax',
                method: 'get',
                async: false,
                dataType: 'json',
                url: '<?= base_url('/App_Ajax/Ajax_List_Client_by_type/') ?>',
                data: {
                    CUSTOMER_CATEGORY: CUSTOMER_CATEGORY
                },
                success: function (data) {
                    $('#LIST_Client').empty();
                    $.each(data.data, function (key, value) {
                        $('#LIST_Client').append('<option value=' + value.options_id + '>' + value.options_title + '</option>');
                    });
                    $('#LIST_Client').selectpicker('refresh');
                },
                error: function () {
                    swal.fire(" خطا ", "في ارسال الطلب ", "error");
                }
            });

    });




</script>
