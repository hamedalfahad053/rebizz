

	    <form class="form" id="Form_Create_Transaction" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Update_Data_Transactions/'.$this->uri->segment(4)) ?>" enctype="multipart/form-data" method="post">
		<?= CSFT_Form() ?>

		<input type="hidden" name="Form_id"        value="<?= $Query_Fields->Forms_id ?>">
		<input type="hidden" name="Components_id"  value="<?= $Query_Fields->Components_id ?>">
		<input type="hidden" name="Transaction_id" value="<?= $Transactions->transaction_id ?>">

	    <div class="card card-custom mb-10">


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
				    <label>سبب التعديل </label>
				    <textarea name="Reason_modification" required  id="Reason_modification" class="form-control"></textarea>
			    </div>

			    <div class="form-group row">
				    <?php

				    if($Query_Fields->Fields_Type == 'Fields'){

					    $Where_Get_Fields = array("Fields_id" => $Query_Fields->Fields_id);
					    $Get_Fields       = Get_Fields($Where_Get_Fields)->row();

					    echo Building_Field_Forms($Get_Fields->Fields_key,
							    true,
							    $Get_Fields->Fields_key.'-'.$Query_Fields->Forms_id.'-'.$Query_Fields->Components_id,
							    Transaction_data_by_key($Transactions->transaction_id,$Query_Fields->Forms_id,$Query_Fields->Components_id,$Get_Fields->Fields_key),
							    $Get_Fields->Fields_key,
							    '',
							    '',
							    '',
							    '',
							    '',
							    '');

				    }elseif($Query_Fields->Fields_Type == 'List'){

					    $class_List      = array( 0 => "selectpicker");
					    Building_List_Forms($Query_Fields->Forms_id,
							    $Query_Fields->Components_id,
							    $Query_Fields->Fields_id,
							    $multiple = '',
							    $selected='',
							    $style='',
							    $id='',
							    $class = array( 0=> "selectpicker"),
							    $disabled='',
							    $label='',
							    $js='');
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


