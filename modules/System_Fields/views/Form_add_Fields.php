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


        <div class="row">


            <div class="col-lg-6 mt-5">

                   <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon-squares text-primary"></i>
                            </span>
                            <h3 class="card-label"><?= $Page_Title ?></h3>
                        </div>
                        <div class="card-toolbar"></div>
                    </div>
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-lg-6 mt-5">
                                <label><?= lang('Type_Fields') ?></label>
                                <select name="Type_Fields" id="Type_Fields"  class="form-control selectpicker">
                                    <?php
                                    foreach ($options_Type_Tag_Fields AS $key => $value)
                                    {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-lg-6 mt-5">

                                <label>نوع الحقل</label>
                                <select name="options_Type_Fields" id="options_Type_Fields"  class="form-control selectpicker" data-live-search="true">

                                </select>

                            </div>
                        </div>




                    </div>
                </div>

            </div><!--<div class="col-lg-12 mt-5">-->


            <div class="col-lg-6 mt-5">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">شروط الحقل</h3>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-lg-12 mt-5" id="validating_Fields">


                            </div>
                        </div>

                    </div>
                </div>
            </div>









        </div>



    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


<script>


    $(document).on('change', '#Type_Fields', function(e){
        e.preventDefault();
        var Type_Fields       =  $('select[name="Type_Fields"]').val();
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '<?= base_url(ADMIN_NAMESPACE_URL .'/Fields/options_Type_Fields') ?>',
            data: { Type_Fields:Type_Fields},//
            async: false,
            dataType: 'json',
            success: function(data){
                $("#options_Type_Fields").empty();
                $("#options_Type_Fields").append('<option>اختر </option>');
                $.each(data.data, function (key, value) {
                    $("#options_Type_Fields").append('<option value=' + key + '>' + value + '</option>');
                });
                $("#options_Type_Fields").selectpicker('refresh');
            },
            error: function(){
                swal.fire("خطا بالارسال",'', "error");
            }
        });
    }); // $('#Type_Fields').change(function()


    $(document).on('change', '#options_Type_Fields', function(e){
        e.preventDefault();
        var options_Type_Fields  =  $('select[name="options_Type_Fields"]').val();
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '<?= base_url(ADMIN_NAMESPACE_URL .'/Fields/validating_Fields_Template') ?>',
            data: { options_Type_Fields:options_Type_Fields},//
            async: false,
            dataType: 'html',
            success: function(data){
                $("#validating_Fields").html(data);
            },
            error: function(){
                swal.fire("خطا بالارسال",'', "error");
            }
        });
    }); // $('#Type_Fields').change(function()




    $(document).ready(function() {

        /* Scripts validating Fields */

        $("#matches").on("click", function(){
            if($(this).is(":checked")){
                $("#matches_Fields").attr("disabled",false);
                $(".matches_Fields").fadeIn(300);
            } else {
                $("#matches_Fields").attr("disabled",true);
                $(".matches_Fields").hide(300);
            }
        });

        $("#regex_match").on("click", function(){
            if($(this).is(":checked")){
                $("#regex_match_value").attr("disabled",false);
                $(".match_regex").fadeIn(300);
            } else {
                $("#regex_match_value").attr("disabled",true);
                $(".match_regex").hide(300);
            }
        });

        $("#min_length").on("click", function(){
            if($(this).is(":checked")){
                $("#min_length_value").attr("disabled",false);
                $(".min_length_value").fadeIn(300);
            } else {
                $("#min_length_value").attr("disabled",true);
                $(".min_length_value").hide(300);
            }
        });

        $("#max_length").on("click", function(){
            if($(this).is(":checked")){
                $("#max_length_value").attr("disabled",false);
                $(".max_length_value").fadeIn(300);
            } else {
                $("#max_length_value").attr("disabled",true);
                $(".max_length_value").hide(300);
            }
        });

        $("#exact_length").on("click", function(){
            if($(this).is(":checked")){
                $("#exact_length_value").attr("disabled",false);
                $(".exact_length_value").fadeIn(300);
            } else {
                $("#exact_length_value").attr("disabled",true);
                $(".exact_length_value").hide(300);
            }
        });



    }); // $(document).ready(function()


</script>


