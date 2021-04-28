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

            <a href="<?= base_url(APP_NAMESPACE_URL . '/Transactions/View_Transaction/') ?>" class="btn btn-success">
                <i class="flaticon2-arrow"></i>   العودة للمعاملة
            </a>

        </div>
        <!--end::Toolbar-->
    </div>
</div>
<!--end::Subheader-->

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">

	    <form class="form" id="Form_Create_Transaction" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Update_Data_Transactions') ?>" enctype="multipart/form-data" method="post">
		<?= CSFT_Form() ?>

		<input type="hidden" name="Form_id" value="">
		<input type="hidden" name="Components_id" value="">
		<input type="hidden" name="Transaction_id" value="<?= $Transactions->transaction_id ?>">

	    <div class="card card-custom mt-10">
		    <!--begin::Header-->
		    <div class="card-header">
			    <div class="card-title">
				    <h3 class="card-label">تعديل بيانات المعاملة</h3>
			    </div>
			    <div class="card-toolbar">

			    </div>
		    </div>
		    <!--begin::Header-->

		    <!--begin::Body-->
		    <div class="card-body">
			    <div class="form-group row">
				    <?php

				    if($Query_Fields->Fields_Type == 'Fields'){

					    $Where_Get_Fields = array("Fields_id" => $Query_Fields->Fields_id);
					    $Get_Fields       = Get_Fields($Where_Get_Fields)->row();

					    echo Building_Field_Forms($Get_Fields->Fields_key,
							    true,
							    $Get_Fields->Fields_key.'-'.$Query_Fields->Forms_id.'-'.$Query_Fields->Components_id,
							    '',
							    $Get_Fields->Fields_key,
							    '',
							    '',
							    '',
							    '',
							    '',
							    '');



				    }elseif($Query_Fields->Fields_Type == 'List'){

					    echo Building_Field_Forms($Get_Fields->Fields_key,
							    true,
							    $Get_Fields->Fields_key.'-'.$Query_Fields->Forms_id.'-'.$Query_Fields->components_id,
							    '',
							    $Get_Fields->Fields_key,
							    '',
							    '',
							    '',
							    '',
							    '',
							    '');

				    }
				    ?>
			    </div><!-- <div class="form-group row"> -->
		    </div>
		    <!--begin::Body-->

		    <div class="card-footer">
			    <div class="row">
				    <div class="col-lg-6">
					    <button type="submit"   class="btn btn-primary mr-2"> حفظ البيانات  </button>
				    </div>
				    <div class="col-lg-6 text-lg-right">
				    </div>
			    </div>
		    </div>

	    </div><!--<div class="card card-custom mt-10">-->


	    </form>


    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
