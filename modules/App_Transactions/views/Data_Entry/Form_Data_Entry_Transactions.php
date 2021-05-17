        <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Review_Entry_Transactions/Submit_DataEntries/'.$this->uri->segment(4)) ?>" enctype="multipart/form-data" method="post">
        <?= CSFT_Form() ?>


		    <?php echo  $this->session->flashdata('message'); ?>

	        <input type="hidden" name="Start_Form_Progresses" value="<?= time() ?>" >
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
		        <div class="card card-custom mb-5">

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
													        <div class="col-lg-6 mt-5">
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

														        <div class="col-lg-6 mt-5">
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

				    $data_Assignment_Stages_Transaction['Stages_Transaction'] = $Get_Stages_Transaction;
				    $this->load->view('../../modules/App_Transactions/views/Assignment_Transaction/Assignment_Transaction_userid',$data_Assignment_Stages_Transaction);

			    } // if($Assignment_Type->attribution_method == 1)
			    ?>


			    <div class="card card-custom mb-5">
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

