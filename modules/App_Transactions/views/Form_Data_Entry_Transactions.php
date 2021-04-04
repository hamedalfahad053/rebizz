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






	    <?php
	    $Customs_With_CLIENT            = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CLIENT');
	    $Customs_With_Type_CUSTOMER     = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CUSTOMER_CATEGORY');
	    $Customs_With_Type_Property     = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPE_OF_PROPERTY');
	    $Customs_With_TYPES_APPRAISAL   = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');

	    $Form_Components_Customs        = Get_View_Components_Customs(1,$Customs_With_CLIENT,$Customs_With_Type_CUSTOMER,$Customs_With_Type_Property,$Customs_With_TYPES_APPRAISAL);
	    foreach ($Form_Components_Customs->result() AS $RC_Customs)
	    {
		    ?>
		    <div class="card card-custom mt-10">
			    <!--begin::Header-->
			    <div class="card-header">
				    <div class="card-title">
					    <h3 class="card-label">
						    <?= $RC_Customs->item_translation ?>
					    </h3>
				    </div>
			    </div>
			    <!--begin::Header-->
			    <!--begin::Body-->
			    <div class="card-body">
				    <div class="form-group row">
					    <table class="data_table table table-bordered table-hover display nowrap" width="100%">

						    <?php
						    $Get_Fields_Components = Building_Fields_Components_Views($RC_Customs->Forms_id, $RC_Customs->components_id,'All','All','All','All');
						    foreach ($Get_Fields_Components as $GFC)
						    {

							    if($GFC['Fields_Type_Components'] == 'Fields'){

								    $Get_Fields = Get_Fields(array("Fields_id"=>$GFC['Fields_id']))->row();

								    if($Get_Fields->Fields_Type_Fields == 'file_multiple' or $Get_Fields->Fields_Type_Fields == 'file') {
									    $data_files['Get_Transaction_files'] = Get_Transaction_files(array("Transaction_id"=>$Transactions->transaction_id))->result();
									    $this->load->view('../../modules/App_Transactions/views/Template/Template_row_transaction_files',$data_files);
								    }else{
									    ?>
									    <tr>
										    <td><?= $GFC['Fields_Title'] ?></td>
										    <td><?= Transaction_data_by_key($Transactions->transaction_id,$GFC['Forms_id'],$GFC['components_id'],$GFC['Fields_key']) ?></td>
										    <td><button type="button" class="btn btn-icon btn-sm btn-light-warning mx-2" data-toggle="modal" data-target="#exampleModalCenter"><i class="la la-edit"></i></button>
									    </tr>
									    <?php
								    }


							    }elseif($GFC['Fields_Type_Components'] == 'List'){

								    $d = Transaction_data_by_key($Transactions->transaction_id,$GFC['Forms_id'],$GFC['components_id'],$GFC['Fields_key']);
								    ?>
								    <tr>
									    <td><?= $GFC['Fields_Title'] ?></td>
									    <td><?= get_data_options_List_view($GFC['Fields_id'],$d); ?></td>
									    <td></td>
								    </tr>
								    <?php
							    }
						    } // foreach ($Get_Fields_Components as $GFC)
						    ?>
					    </table>

				    </div><!-- <div class="form-group row"> -->
			    </div>
			    <!--begin::Body-->
		    </div><!--<div class="card card-custom mt-10">-->
		    <?php
	    } // foreach ($Form_Components_Customs->result() AS $RC_Customs)
	    ?>




	    <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Submit_DataEntries') ?>" enctype="multipart/form-data" method="post">
        <?= CSFT_Form() ?>

		    <?php echo  $this->session->flashdata('message'); ?>

	        <input type="hidden" value="" name="Transactions_uuid">
	        <?php
	        $where_extra_Form_Components = array(
			        'With_Type_CUSTOMER'           => "All",
			        'With_Type_Property'           => "All",
			        'With_TYPES_APPRAISAL'         => "All",
			        'With_Type_evaluation_methods' => "All"
	        );
	        $Form_Components  = Get_Form_Components(13,$where_extra_Form_Components);

	        foreach ($Form_Components->result() AS $RC)
	        {
		        ?>
		        <input type="hidden" name="Form_id" value="13">
		        <input type="hidden" name="Transaction_id" value="<?= $Transactions->transaction_id ?>">
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

						        if($GFC['Fields_Type_Components'] == 'Fields'){

							        $Where_Get_Fields = array("Fields_id" => $GFC['Fields_id']);
							        $Get_Fields       = Get_Fields($Where_Get_Fields)->row();
							        ?>

							        <div class="col-lg-4 mt-5">
								        <?php
								        echo Building_Field_Forms($Get_Fields->Fields_key,
										        true,
										        $Get_Fields->Fields_key.'-'.$RC->Forms_id.'-'.$RC->components_id,
										        '',
										        $Get_Fields->Fields_key,
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




		    <?php
		    $where_Stages_Assignment = array(
				    "stages_key" => 'COORDINATION_AND_QUALITY',
				    "company_id" => $this->aauth->get_user()->company_id
		    );
		    $Get_Stages_Transaction = Assignment_Transaction_Departments_To($where_Stages_Assignment);

		    if($Get_Stages_Transaction == false) {

			    $msg_result['key']   = 'Danger';
			    $msg_result['value'] = 'لا يوجد ضبط صحيح لاسناد المعاملة ';
			    $msg_result_view = Create_Status_Alert($msg_result);
			    echo '<br>';
			    echo $msg_result_view;

		    }else{

			    $Assignment_Type_where = array(
					    'stages_key' => 'COORDINATION_AND_QUALITY',
					    'company_id' => $this->aauth->get_user()->company_id
			    );
			    $Assignment_Type = Get_Stages_Transaction_Company($Assignment_Type_where)->row();

			    if($Assignment_Type->attribution_method == 1){
				    echo '<input type="hidden" name="Assignment_userid" value="'.$Get_Stages_Transaction['userid'].'">';
			    }elseif($Assignment_Type->attribution_method == 2){
				    ?>
				    <div class="card card-custom mb-5 mt-5">
					    <!--begin::Header-->
					    <div class="card-header">
						    <div class="card-title">
							    <h3 class="card-label">تحويل الطلب الى </h3>
						    </div>
					    </div>
					    <!--begin::Header-->
					    <!--begin::Body-->
					    <div class="card-body">
						    <select name="Assignment_userid" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
							    <?php
							    $t = 'عدد المعاملات الحالية :';
							    foreach ($Get_Stages_Transaction AS $key_user)
							    {
								    echo '<option  data-subtext="  '.$t.$key_user['Assignment_Num'].'" value="'.$key_user['userid'].'">'.$key_user['full_name'].'</option>';
							    }
							    ?>
						    </select>
					    </div>
					    <!--begin::Body-->
				    </div>
				<?php
			    } // if($Assignment_Type->attribution_method == 1)
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

			<?php
		    }
		    ?>





        </form>


    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


<div class="modal fade" id="exampleModalCenter" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">


			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">تعديل البيانات</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>
			<div class="modal-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary font-weight-bold">حفظ</button>
			</div>

		</div>
	</div>
</div>

