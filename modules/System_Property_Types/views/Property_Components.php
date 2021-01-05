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


        <?= $this->load->view('../../modules/System_Property_Types/views/Form_Add_Create_Sections'); ?>



        <div class="card card-custom">
            <div class="card-body">
                <div class="card-body">
                    <a data-toggle="collapse" href="#collapseFormAdd_sctions" role="button" aria-expanded="false" aria-controls="collapseFormAdd_sctions" class="btn btn-primary"> اضافة قسم </a>
                </div>
            </div>
        </div>

        <div id="Data_Sections_Components">
            <div class="lod_spinner spinner hidden spinner-primary mr-15"></div>
        </div>


        <div class="card card-custom mb-10 mt-10">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
                    <h3 class="card-label">اضافة حقل  </h3>
                </div>
                <div class="card-toolbar"></div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4 mt-5">
                        <label>العنوان بالعربية</label>
                        <input type="text" id="Sections_title_ar" name="Sections_title_ar" class="form-control" placeholder=""/>
                    </div>
                    <div class="col-lg-4 mt-5">
                        <label>شروط الحقل</label>
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
$(document).ready(function() {

    function Sections_Components() {

        var Property_Types_id    = <?= $this->uri->segment(4) ?>

        $.ajax({
            type: 'ajax',
            method: 'get',
            beforeSend: function() {
                $('.lod_spinner').show();
            },
            url: '<?= base_url(ADMIN_NAMESPACE_URL . '/Property_Types/Ajax_Property_Types_Sections_Components/') ?>',
            data: {Property_Types_id:Property_Types_id },
            async: false,
            dataType: 'html',
            success: function(data){
                $('.lod_spinner').hide();
                $('#Data_Sections_Components').html(data);
            },
            error: function(){
                swal.fire("خطا بالارسال",'', "error");
            }
        });
    }

    Sections_Components();


    // ------------------------------------------------------------------------------- //
    $('#FormCreateSections').on('click', '#buttonCreateSections', function (event) {

        event.preventDefault();

        var Sections_title_ar    = $('input[name=Sections_title_ar]').val();
        var Sections_title_en    = $('input[name=Sections_title_en]').val();
        var Sections_Status      = $('select[name=Sections_Status]').val();
        var Property_Types_id    = <?= $this->uri->segment(4) ?>

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '<?= base_url(ADMIN_NAMESPACE_URL . '/Property_Types/Create_Sections_Types_Property_Components/') ?>',
            data: { Property_Types_id:Property_Types_id ,  Sections_title_ar:Sections_title_ar,Sections_title_en:Sections_title_en,Sections_Status:Sections_Status },
            async: false,
            dataType: 'json',
            success: function(data){
                $('#FormCreateSections')[0].reset();
                $('#collapseFormAdd_sctions').collapse('hide');

                if(data.Type_result=='success'){
                    swal.fire("تمت الاضافة بنجاح",data.Message_result,"success");
                }else{
                    swal.fire("حدث خطا ",data.Message_result, "error");
                }

            },
            error: function(){
                swal.fire("خطا بالارسال",'', "error");
            }
        });

    });
    // ------------------------------------------------------------------------------- //



});
</script>
