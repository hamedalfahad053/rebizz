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
            </div>

	        <?php echo  $this->session->flashdata('message'); ?>

	        <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Company_Forms/Create_Forms') ?>" method="post">
		        <?= CSFT_Form() ?>
		        <div class="card-body">

	            <div class="form-group row">
		            <div class="col-lg-6 mt-5">
			            <label>العنوان بالعربية</label>
			            <input type="text" name="title_ar" class="form-control" placeholder="" />
		            </div>
		            <div class="col-lg-6 mt-5">
			            <label>العنوان بالانجليزية</label>
			            <input type="text" name="title_en" class="form-control" placeholder="" />
		            </div>
	            </div>

	            <div class="form-group row">
		            <div class="col-lg-4 mt-5">
			            <label>الحالة</label>
			            <select name="status" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
				            <?php
				            foreach ($status AS $key => $value)
				            {
					            echo '<option value="'.$key.'">'.$value.'</option>';
				            }
				            ?>
			            </select>
		            </div>
		            <div class="col-lg-4 mt-5">
			            <label>العميل</label>
			            <select name="client_id" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
				            <option value="0">عام</option>
				            <?php
				            foreach ($Client_Company AS $RG)
				            {
					            echo '<option value="'.$RG['Client_id'].'">'.$RG['Client_name'].' </option>';
				            }
				            ?>
			            </select>
		            </div>

		            <div class="col-lg-4 mt-5">
			            <label>نوع العقار</label>
			            <select name="Property_Types_id" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
				            <option value="0">عام</option>
				            <?php
				            foreach ($Property_Types AS $RG)
				            {
					            echo '<option value="'.$RG['Property_Types_id'].'">'.$RG['Property_Types_Name'].' </option>';
				            }
				            ?>
			            </select>
		            </div>


	            </div>

                </div>
	            <div class="card-footer">
		        <div class="row">
			        <div class="col-lg-6">
				        <button type="submit"  class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
			        </div>
			        <div class="col-lg-6 text-lg-right">
				        <button type="reset" class="btn btn-danger"><?= lang('cancel_button') ?></button>
			        </div>
		        </div>
	        </div>
	        </form>


        </div>


    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->