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

        <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Create_Transaction') ?>" enctype="multipart/form-data" method="post">
        <?= CSFT_Form() ?>

	        <input type="hidden" value="" name="Transactions_uuid">


	        <?php
	        $where_extra_Form_Components = array(
			        'With_Type_CUSTOMER'           => "All",
			        'With_Type_Property'           => "All",
			        'With_TYPES_APPRAISAL'         => "All",
			        'With_Type_evaluation_methods' => "All"
	        );
	        $Form_Components             = Get_Form_Components(13,$where_extra_Form_Components);

	        foreach ($Form_Components->result() AS $RC)
	        {
		        ?>
		        <input type="hidden" name="Form_id" value="1">
		        <div class="card card-custom mt-10">

			        <!--begin::Header-->
			        <div class="card-header">
				        <div class="card-title">
					        <h3 class="card-label">
						        <?= $RC->item_translation ?>
					        </h3>
				        </div>
				        <div class="card-toolbar">

				        </div>
			        </div>
			        <!--begin::Header-->

			        <!--begin::Body-->
			        <div class="card-body">


				        <div class="form-group row">

					        <?php
					        $Get_Fields_Components = Building_Fields_Components_Forms($RC->Forms_id, $RC->components_id,'All','All','All','All');


					        foreach ($Get_Fields_Components as $GFC)
					        {

						        if($GFC['Fields_Type_Components'] == 'Fields'){

							        $Where_Get_Fields = array("Fields_id" => $GFC['Fields_id']);
							        $Get_Fields       = Get_Fields($Where_Get_Fields)->row();
							        ?>

							        <div class="col-lg-4 mt-5">
								        <?php
								        echo Creation_Field_HTML_input($Get_Fields->Fields_key,
										        true,
										        '',
										        '',
										        '',
										        '',
										        '',
										        '',
										        '',
										        '',
										        '');

								        ?>
							        </div>

							        <?php

						        }elseif($GFC['Fields_Type_Components'] == 'List'){
							        ?>

							        <div class="col-lg-4 mt-5">
								        <?php
								        $class_List      = array( 0 => "selectpicker");
								        Building_List_Forms($RC->Forms_id,
										        $RC->components_id,
										        $GFC['Fields_id'],
										        $multiple = '',
										        $selected='',
										        $style='',
										        $id='',
										        $class = array( 0=> "selectpicker"),
										        $disabled='',
										        $label='',
										        $js='');
								        ?>
							        </div>

							        <?php
						        }

					        } // foreach
					        ?>



				        </div><!-- <div class="form-group row"> -->



			        </div>
			        <!--begin::Body-->


		        </div><!--<div class="card card-custom mt-10">-->
		        <?php
	        }
	        ?>


	        <div class="card card-custom mt-10">
		        <div class="card-footer">
			        <div class="row">
				        <div class="col-lg-6">
					        <button type="submit"   class="btn btn-primary mr-2"> حفظ البيانات  </button>
				        </div>
				        <div class="col-lg-6 text-lg-right">
					        <a href="<?= base_url(APP_NAMESPACE_URL.'/Transactions/#') ?>" class="btn btn-danger"><?= lang('cancel_button') ?></a>
				        </div>
			        </div>
		        </div>
            </div>


        </form>


    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


