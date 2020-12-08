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


            <div class="col-lg-8 mt-5">

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
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Type_Fields') ?></label>
                                <select name="Type_Fields"  class="form-control selectpicker" data-live-search="true">
                                    <option></option>
                                </select>
                            </div>
                        </div>


                    </div>
                </div>

            </div><!--<div class="col-lg-8 mt-5">-->



            <div class="col-lg-4 mt-5">

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
                            <div class="col-lg-12 mt-5">
                                <label><?= lang('Type_Fields') ?></label>

                            </div>
                        </div>



                    </div>
                </div>

            </div><!--<div class="col-lg-4 mt-5">-->


        </div>



    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->



