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



		    <form class="form" action="<?= base_url(ADMIN_NAMESPACE_URL.'/Calculations/Create_Calculations') ?>" method="post">
			<?= CSFT_Form() ?>

		    <div class="card card-custom">
			    <div class="card-header">
				    <div class="card-title">
	                    <span class="card-icon">
	                        <i class="flaticon-squares text-primary"></i>
	                    </span>
					    <h3 class="card-label">عملية حسابية لحقلين فقط</h3>
				    </div>
				    <div class="card-toolbar">
				    </div>
			    </div>
			    <div class="card-body">


				        <div class="form-group row">

						    <div class="col-lg-2 mt-5">
							    <label>الحقل الاول</label>
							    <select name="Fields_A" class="form-control selectpicker" data-size="7" data-live-search="true">
								    <?php
								    foreach ($Fields_All_Data AS $Row_Field)
								    {
									    echo '<option value="'.$Row_Field->Fields_id.'">'.$Row_Field->item_translation.'</option>';
								    }
								    ?>
							    </select>
						    </div>

						    <div class="col-lg-2 mt-5">
							    <label>العميلة الحسابية</label>
							    <select name="Calculations_type" class="form-control selectpicker" data-size="7" data-live-search="true">
									<option value="+">جمع</option>
								    <option value="-">طرح</option>
								    <option value="*">ضرب</option>
								    <option value="/">قسمة</option>
								    <option value="-%">خصم بالنسبة المئوية</option>
								    <option value="+%">زيادة بالنسبة المئوية</option>
							    </select>
						    </div>

					        <div class="col-lg-2 mt-5">
						        <label>النسبة المئوية رقما فقط</label>
							    <select name="ratio" class="form-control selectpicker" data-size="7" data-live-search="true">
								    <?php
								    for($i=0;$i<100;$i++) {
								    ?>
								    <option value="<?= $i ?>"><?= $i ?></option>
								    <?php
								    }
								    ?>
							    </select>
					        </div>


						    <div class="col-lg-2 mt-5">
							    <label>الحقل الثاني</label>
							    <select name="Fields_B" class="form-control selectpicker" data-size="7" data-live-search="true">
								    <?php
								    foreach ($Fields_All_Data AS $Row_Field)
								    {
									    echo '<option value="'.$Row_Field->Fields_id.'">'.$Row_Field->item_translation.'</option>';
								    }
								    ?>                               
							    </select>
						    </div>

						    <div class="col-lg-2 mt-5">
							    <label> حقل الناتج </label>
							    <select name="Fields_C" class="form-control selectpicker" data-size="7" data-live-search="true">
								    <?php
								    foreach ($Fields_All_Data AS $Row_Field)
								    {
									    echo '<option value="'.$Row_Field->Fields_id.'">'.$Row_Field->item_translation.'</option>';
								    }
								    ?>
							    </select>
						    </div>

					    </div>


			    </div>
			    <div class="card-footer">
				    <div class="row">
					    <div class="col-lg-6">
						    <button type="submit" id="buttonCreateSections" class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
					    </div>
					    <div class="col-lg-6"></div>
				    </div>
			    </div>

		    </div>
		    </form>


    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

