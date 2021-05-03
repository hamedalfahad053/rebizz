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
		    <div class="card-body">

			    <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Submit_Assign_Transaction/'.$this->uri->segment(4)) ?>" method="post">
				    <?= CSFT_Form() ?>
				    <div class="card-body">
					    <div class="form-group row">



						    <div class="col-lg-6 mt-5">
							    <label>اختر  موظف</label>
							    <select name="user_emp_id"  data-size="7" title="اختر من فضلك " data-live-search="true"  class="form-control selectpicker">
								    <?php
								    foreach ($Company_Users AS $key)
								    {
									    echo '<option value="'.$key['user_id'].'" data-subtext="'.$key['position'].'" data-icon="la la-user font-size-lg bs-icon">'.$key['full_name'].'</option>';
								    }
								    ?>-
							    </select>
						    </div>

					    </div>
				    </div>
				    <div class="card-footer">
					    <div class="row">
						    <div class="col-lg-6">
							    <button type="submit" class="btn btn-primary mr-2">اضافة الموظف</button>
						    </div>
						    <div class="col-lg-6 text-lg-right">
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
