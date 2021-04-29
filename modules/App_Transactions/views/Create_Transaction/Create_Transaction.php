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


	    <form class="form" id="Form_Create_Transaction" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Create_Transaction_Submit') ?>" enctype="multipart/form-data" method="post">

		    <?= CSFT_Form() ?>

		    <?php echo  $this->session->flashdata('message'); ?>

		    <?php

		    $collecting_Fields_text   = array();
		    $collecting_Fields_number = array();



		    // Get Components All
		    $where_extra_Form_Components = array('With_Type_CUSTOMER'=> "All",'With_Type_Property'=> "All",'With_TYPES_APPRAISAL'=> "All",'With_Type_evaluation_methods' => "All");
		    $Form_Components             = Get_Form_Components(1,$where_extra_Form_Components);

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
					    $Get_Fields_Components = Building_Fields_Components_Forms($RC->Forms_id, $RC->components_id,'All','All','All','All','All');
					    foreach ($Get_Fields_Components as $GFC)
					    {

							    $Where_Get_Fields = array("Fields_id" => $GFC['Fields_id']);
							    $Get_Fields       = Get_Fields($Where_Get_Fields)->row();



							    if($Get_Fields->Fields_Type_Fields == 'text'){
								    $collecting_Fields_text[]   = array("Fields_key"=>$Get_Fields->Fields_key,"type"=>"text");
							    }elseif ($Get_Fields->Fields_Type_Fields =='number'){
								    $collecting_Fields_number[] = array("Fields_key"=>$Get_Fields->Fields_key,"type"=>"number");
							    }


							    if($GFC['Fields_Type_Components'] == 'Fields'){

								    if($Get_Fields->Fields_Type_Fields == 'file') {
									    $col_size = '12';
								    }else{
									    $col_size = '6';
								    }

							        ?>

									<div class="col-lg-<?= $col_size ?> mt-5">
									<?= Building_Field_Forms($Get_Fields->Fields_key, true, $Get_Fields->Fields_key.'-'.$RC->Forms_id.'-'.$RC->components_id, '', $Get_Fields->Fields_key, '', '', '', '', '', '');  ?>
									</div>
							        <?php


							    }elseif($GFC['Fields_Type_Components'] == 'List'){

								    if($Get_Fields->Fields_Type_Fields == 'list') {
									    $col_size = '12';
								    }else{
									    $col_size = '6';
								    }


							        ?>

								    <div class="col-lg-<?= $col_size ?> mt-5">
							        <?= Building_List_Forms($RC->Forms_id, $RC->components_id, $GFC['Fields_id'], $multiple = '', $selected='', $style='', $id='', $class = array(0=>"selectpicker"), $disabled='', $label='', $js='');  ?>
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

		    <div id="ajax_Components"></div>


		    <?php

		    $where_Stages_Assignment = array("stages_key" => 'CREATE_A_TRANSACTION', "company_id" => $this->aauth->get_user()->company_id);
		    $Get_Stages_Transaction  = Assignment_Transaction_Departments_To($where_Stages_Assignment);

		    // Not Set Setting Admin Assignment

		    if($Get_Stages_Transaction == false) {
			    echo  Create_Status_Alert(array('key'=>'Danger','value'=>'لا يوجد ضبط صحيح لاسناد المعاملة بعد الاضافة'));
		    }else{

			    $Assignment_Type_where = array('stages_key' => 'CREATE_A_TRANSACTION','company_id' => $this->aauth->get_user()->company_id);

			    $Assignment_Type = Get_Stages_Transaction_Company($Assignment_Type_where)->row();

		    	if($Assignment_Type->attribution_method == 1){

		    		echo '<input type="hidden" name="Assignment_userid" value="'.$Get_Stages_Transaction['userid'].'">';

			    }elseif($Assignment_Type->attribution_method == 2){

		    		$data_Assignment_Stages_Transaction['Stages_Transaction'] = $Get_Stages_Transaction;
				    $this->load->view('../../modules/App_Transactions/views/Template/Assignment_Transaction_userid',$data_Assignment_Stages_Transaction);

			    }

				?>
			    <div class="card card-custom mb-5 mt-5">
				    <div class="card-footer">
					    <div class="row">
						    <div class="col-lg-6">
							    <button type="submit"  id="submit"  class="btn btn-primary mr-2">ارسال الطلب</button>
						    </div>
						    <div class="col-lg-6 text-lg-right">
							    <a href="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Cancel_Create_Transaction') ?>" class="btn btn-danger"><?= lang('cancel_button') ?></a>
						    </div>
					    </div>
				    </div>
			    </div>
			<?php
		    }
		    ?>

	    </form>



    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


<?php echo  import_js(BASE_ASSET.'js/pages/crud/forms/editors/summernote',''); ?>

<script type="text/javascript">

	function ajax_Components(div_ajax_Components)
	{
		var form_id                        = 1;
		var CUSTOMER_CATEGORY              = $("#LIST_CUSTOMER_CATEGORY").val();
		var TYPE_OF_PROPERTY               = $("#LIST_TYPE_OF_PROPERTY").val();
		var TYPES_OF_REAL_ESTATE_APPRAISAL = $("#LIST_TYPES_OF_REAL_ESTATE_APPRAISAL").val();
		var LIST_CLIENT                    = $("#LIST_CLIENT").val();

		$.ajax({
			type: 'ajax',
			method: 'get',
			async: false,
			dataType: 'html',
			url: '<?= base_url('/App_Ajax/Ajax_Components') ?>',
			data: {
				form_id:form_id,
				CUSTOMER_CATEGORY:CUSTOMER_CATEGORY,
				TYPE_OF_PROPERTY:TYPE_OF_PROPERTY,
				TYPES_OF_REAL_ESTATE_APPRAISAL:TYPES_OF_REAL_ESTATE_APPRAISAL,
				LIST_CLIENT:LIST_CLIENT
			},
			success: function (data) {
					$(div_ajax_Components).empty();
					$(div_ajax_Components).html(data);
			},
			error: function () {
				swal.fire(" خطا ", "في ارسال الطلب ", "error");
			}
		});

	} // function ajax_Components(div_ajax_Components)

	$(document).on('change', '#LIST_CUSTOMER_CATEGORY', function() {
		ajax_Components('#ajax_Components');
	});

	$(document).on('change', '#LIST_TYPE_OF_PROPERTY', function() {
		ajax_Components('#ajax_Components');
	});

	$(document).on('change', '#LIST_TYPES_OF_REAL_ESTATE_APPRAISAL', function() {
		ajax_Components('#ajax_Components');
	});

	$(document).on('change', '#LIST_CLIENT', function() {
		ajax_Components('#ajax_Components');
	});

	function ajax_list(el){

		    var components_fields_id = $(el).attr("data-components-fields-id");
			var form_id              = $(el).attr("data-form-id");
			var components_id        = $(el).attr("data-components-id");
			var Fields_Type          = $(el).attr("data-Fields-Type");
			var Fields_id            = $(el).attr("data-Fields-id");
			var list_key_div         = $(el).attr("data-list-key-div");
			var list_id              = $(el).attr("data-list-key-id");
		    var List_Target_id       = $(el).attr("data-List-Target-id");
			var List_Target_div      = $(el).attr("data-List-Target-div");
			var option_id            = $(list_key_div).val();

			$.ajax({
				type: 'ajax',
				method: 'get',
				async: false,
				dataType: 'json',
				url: '<?= base_url('/App_Ajax/Ajax_LIST') ?>',
				data: {
					form_id:form_id, components_id:components_id,
					components_fields_id:components_fields_id,
					Fields_Type:Fields_Type, Fields_id:Fields_id, list_id: list_id,
					List_Target_id:List_Target_id, option_id: option_id,
				},
				success: function (data) {
					$(List_Target_div).empty();
					$.each(data.data, function (key, value) {
						$(List_Target_div).append('<option value=' + value.options_id + '>' + value.options_title + '</option>');
					});
					$(List_Target_div).selectpicker('refresh');
				},
				error: function () {
					swal.fire(" خطا ", "في ارسال الطلب ", "error");
				}
			});


	} // function ajax_list(el)




	// -------------------------------------- //
	<?php
	# Marge Array Fields
	$Array_Marge = @array_merge($collecting_Fields_text,$collecting_Fields_number);
	?>


</script>

