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



                        <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL . '/Clients/Create_Stages_Self_Construction/'.$this->uri->segment(4)) ?>" enctype="multipart/form-data" method="post">
                        <?= CSFT_Form() ?>
	                    <input type="hidden" name="Clients_id" value="<?= $Client_Info->client_id ?>" class="form-control"  />
                        <div class="card-body">
                        <?php echo  $this->session->flashdata('message'); ?>
                        <div class="form-group row">
	                        <div class="col-sm-12 col-md-12 mt-5">
		                        <label> رقم المرحلة </label>
		                        <select name="stages_self_number" class="form-control selectpicker">
			                        <option value="1">1</option>
			                        <option value="2">2</option>
			                        <option value="3">3</option>
			                        <option value="4">4</option>
			                        <option value="5">5</option>
		                        </select>
	                        </div>

                            <div class="col-sm-12 col-md-12 mt-5">
                                <label> المرحلة بالعربية </label>
                                <input type="text" name="title_ar" class="form-control" placeholder="" />
                            </div>
	                        <div class="col-sm-12 col-md-12 mt-5">
		                        <label> المرحلة بالانجليزية </label>
		                        <input type="text" name="title_en" class="form-control" placeholder="" />
	                        </div>
	                        <div class="col-sm-12 col-md-12 mt-5">
		                        <label> نسبة المرحلة رقما فقط </label>
		                        <input type="text" name="Percentage" class="form-control" />
	                        </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit"   class="btn btn-primary mr-2">اضافة المرحلة</button>
                                </div>
                            </div>
                        </div>
                        </form>

        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


