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
            <a href="<?= base_url(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transactions->uuid) ?>" class="btn btn-success">
                <i class="flaticon2-arrow"></i>   العودة للمعاملة
            </a>
        </div>
        <!--end::Toolbar-->

    </div>
</div>


<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">

	    <div class="card card-custom">
		    <div class="card-body">
			    <style>th.dt-center,.dt-center { text-align: center; }</style>
			    <table class="data_table table table-bordered table-hover display" width="100%">
				    <thead>
				    <tr>
					    <th class="text-center">المعاين</th>
					    <th class="text-center">تاريخ الزيارة</th>
					    <th class="text-center">نوع تقييم العقار / المرحلة</th>
					    <th class="text-center">حالة الزيارة</th>
				    </tr>
				    </thead>
				    <tbody>
					    <tr>
						    <th class="text-center">
							    <?php
							    echo $this->aauth->get_user($preview_data->preview_userid)->full_name
							    ?>
						    </th>
						    <th class="text-center">
							    <?php
							    echo date('Y-m-d h:i:s a',$preview_data->preview_Visit_date_completed);
							    ?>
						    </th>

						    <th class="text-center">
							    <?php
							    $type_preview =  Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');
							    if($type_preview == 12 or $type_preview ==  14){
							        $type_preview_text =  get_data_options_List_view('4',$type_preview);
							    }elseif($type_preview == 13){



								    $Get_Stages_Self = $this->db->where('company_id',$this->aauth->get_user()->company_id);
								    $Get_Stages_Self = $this->db->where('transactions_id',$Transactions->transaction_id);
								    $Get_Stages_Self = $this->db->where('stages_self_number',$preview_data->preview_stages);
								    $Get_Stages_Self = $this->db->get('portal_transaction_stages_self_construction');

								    if($Get_Stages_Self->num_rows()>0) {
									    $type_preview_text = $Get_Stages_Self->row()->stages_self_text;
								    }

							    }

							    echo $type_preview_text;
							    ?>
						    </th>
						    <th class="text-center">
							    <?php
							    if($preview_data->preview_Visit_acceptance ==0){
								    echo 'لم تعتمد';
							    }else{
								    echo get_data_options_List_view('90',$preview_data->preview_Visit_acceptance);
							    }
							    ?>
						    </th>
					    </tr>
				    </tbody>
			    </table>

		    </div>
	    </div>


	    <?php

	    $get_evaluation = $this->db->where('transaction_id',$Transactions->transaction_id);
	    $get_evaluation = $this->db->where('preview_id',$preview_Visit->Coordination_id);
	    $get_evaluation = $this->db->get('protal_evaluation_transactions');
	    ?>

	    <div class="card card-custom">


			    <form class="form" id="Form_Create_Transaction" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Evaluation/Create_Evaluation_Transactions/'.$this->uri->segment(4).'/'.$preview_data->Coordination_uuid.'/'.$this->uri->segment(5)) ?>" enctype="multipart/form-data" method="post">
				    <?= CSFT_Form() ?>
			    <div class="card-body">

	            <?php



	            $LIST_CLIENT                    = Transaction_data_by_key($Transactions->transaction_id,17,1,'LIST_CLIENT');
	            $CUSTOMER_CATEGORY              = Transaction_data_by_key($Transactions->transaction_id,17,1,'LIST_CUSTOMER_CATEGORY');
	            $TYPE_OF_PROPERTY               = Transaction_data_by_key($Transactions->transaction_id,17,1,'LIST_TYPE_OF_PROPERTY');
	            $TYPES_OF_REAL_ESTATE_APPRAISAL = Transaction_data_by_key($Transactions->transaction_id,17,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');
	            $Form_Components  = Get_View_Components_Customs(17,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL);

	            foreach ($Form_Components->result() AS $RC)
	            {
	                ?>
	                <h3 class="font-size-h5 font-weight-boldest"><?= $RC->item_translation ?></h3>
	                <div class="separator separator-dashed separator-border-1 separator-primary"></div>
	                <div class="form-group row">
	                    <?php
	                    $Get_Fields_Components = Building_Fields_Components_Forms($RC->Forms_id, $RC->components_id,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL,'All');

	                    foreach ($Get_Fields_Components as $GFC)
	                    {

	                        if($GFC['Fields_key'] !='CONSUMPTION_RATIO'  and  $GFC['Fields_key'] !='PROFIT_RATIO' and $GFC['Fields_key'] != 'ESTIMATED_COSTS' and $GFC['Fields_key'] != 'MARKET_VALUE'){

	                            if($GFC['Fields_Type_Components'] == 'Fields'){
	                                $Where_Get_Fields = array("Fields_id" => $GFC['Fields_id']);
	                                $Get_Fields       = Get_Fields($Where_Get_Fields)->row();
	                                ?>
	                                <div class="col-sm-4  col-lg-4  mt-5">
	                                    <?php
	                                    $data_input = Get_Transaction_Preview_data_by_key($Transactions->transaction_id,$preview_data->Coordination_id,$RC->Forms_id,$RC->components_id,$Get_Fields->Fields_key);
	                                    echo Building_Field_Forms($Get_Fields->Fields_key,
	                                        true,
	                                        $Get_Fields->Fields_key.'-'.$RC->Forms_id.'-'.$RC->components_id,
			                                    $data_input,
			                                $Get_Fields->Fields_key,
	                                        '',
	                                        '',
	                                        '',
	                                        '',
	                                        array("data-calculations"=>"true","value"=>'0',  "min"=> 0,"step"=> 0.0 ),
	                                        ''
	                                    );

	                                    ?>
	                                </div>
	                                <?php
	                            } // if($GFC['Fields_Type_Components'] == 'Fields')

	                        } // if(){ Fields ignor

	                    } // foreach


	                    ?>
	                </div><!-- <div class="form-group row"> -->
	                <?php
	            }

	            $get_evaluation_table = $this->db->where('transaction_id',$Transactions->transaction_id);
	            $get_evaluation_table = $this->db->where('preview_id',$preview_data->Coordination_id);
	            $get_evaluation_table = $this->db->get('protal_transaction_preview_evaluation');

	            if($get_evaluation_table->num_rows()>0){
		            $get_evaluation_table_row = $get_evaluation_table->row();
	            }
	            ?>
				<table class="table table-striped table-bordered table-hover mt-3 data_table_Land_Comparisons">
					      <tr>
						      <th class="text-center" width="25%">إجمالي قيمة الأرض</th>
						      <td class="text-center">
							      <input type="number" name="Total_Land" value="<?= $get_evaluation_table_row->Total_Land ?>"  min="0" step="0.0" id="Total_Land" maxlength="" style="" class=" form-control form-control-solid" readonly="readonly" />
						      </td>
					      </tr>
					      <tr>
						      <th class="text-center" width="25%">إجمالي قيمة المباني </th>
						      <td class="text-center">
							      <input type="number" name="Total_Building" value="<?= $get_evaluation_table_row->Total_Building ?>"  min="0" step="0.0" id="Total_Building" maxlength="" style="" class=" form-control form-control-solid" readonly="readonly" />
						      </td>
					      </tr>
					      <tr>
						      <th class="text-center" width="25%">نسبة الاستهلاك (%)</th>
						      <td class="text-center">
							      <input type="number" name="CONSUMPTION_RATIO" value="<?= $get_evaluation_table_row->CONSUMPTION_RATIO ?>"  min="0" max="100" step="0.0" id="CONSUMPTION_RATIO" maxlength="2" style="" class=" form-control " data-calculations="true">
						      </td>
					      </tr>
					      <tr>
						      <th class="text-center" width="25%">قيمة الاستهلاك</th>
						      <td class="text-center">
							      <input type="number" name="CONSUMPTION_Total" value="<?= $get_evaluation_table_row->CONSUMPTION_Total ?>"  min="0" step="0.0" id="CONSUMPTION_Total" maxlength="" style="" class=" form-control form-control-solid" readonly="readonly" />
						      </td>
					      </tr>
					      <tr>
						      <th class="text-center" width="25%">التكلفة التقديرية (التكلفة)</th>
						      <td class="text-center">
							      <input type="number" name="ESTIMATED_COSTS" value="<?= $get_evaluation_table_row->ESTIMATED_COSTS ?>"  min="0" step="0.0" id="ESTIMATED_COSTS" maxlength="" style="" class=" form-control form-control-solid" readonly="readonly" />
						      </td>
					      </tr>
					      <tr>
						      <th class="text-center" width="25%">نسبة الربح (%)</th>
						      <td class="text-center">
							      <input type="number" name="PROFIT_RATIO" value="<?= $get_evaluation_table_row->PROFIT_RATIO ?>"  min="0" max="100" step="0.0" id="PROFIT_RATIO" maxlength="2" style="" class=" form-control " data-calculations="true">
						      </td>
					      </tr>
					      <tr>
						      <th class="text-center" width="25%">قيمة الربح</th>
						      <td class="text-center">
							      <input type="number" name="PROFIT_Total" value="<?= $get_evaluation_table_row->PROFIT_Total ?>"  min="0" max="100" step="0.0" id="PROFIT_Total" maxlength="" style="" class=" form-control form-control-solid" readonly="readonly" />
						      </td>
					      </tr>
					      <tr>
						      <th class="text-center" width="25%">القيمة السوقية  (حسب المعطيات)</th>
						      <td class="text-center">
							      <input type="number" name="MARKET_VALUE" value="<?= $get_evaluation_table_row->MARKET_VALUE ?>"  min="0" step="0.0" id="MARKET_VALUE" maxlength="" style="" class=" form-control form-control-solid" readonly="readonly" />
						      </td>
					      </tr>
					      <tr>
						      <th class="text-center" width="25%">القيمة السوقية  (التقريبية)</th>
						      <td class="text-center">
							      <input type="number" name="MARKET_VALUE_Approximate" value="<?= $get_evaluation_table_row->MARKET_VALUE_Approximate ?>"  min="0"  step="0.0" id="MARKET_VALUE_Approximate" maxlength="" style="" class=" form-control ">
						      </td>
					      </tr>
				      </table>

			    </div><!--<div class="card-body">-->
				    <div class="card-footer">
					    <div class="row">
						    <div class="col-lg-6">
							    <button type="submit" id="buttonCreateSections" class="btn btn-primary mr-2">حفظ التقييم</button>
						    </div>
						    <div class="col-lg-6 text-lg-right">
						    </div>
					    </div>
				    </div>
			    </form>

	    </div><!--<div class="card card-custom">-->




    </div>
</div>


<script type="text/javascript">

    var Total_Land     = 0;
    var Total_Building = 0;

    <?php
    $where_Get_Calculations = array(
        "Form_loc" => "Preview_Property_FORM",
    );

    $Get_Calculations = Get_Calculations($where_Get_Calculations);
    foreach ($Get_Calculations->result() AS $R_GC)
    {

    if($R_GC->Type_Value == 'Building'){
    ?>
        $('#<?= $R_GC->Field_C_key ?>').attr("data-type","Building").prop("readonly",true).addClass("form-control-solid");
    <?php
    }
    if($R_GC->Type_Value == 'Land'){
    ?>
        $('#<?= $R_GC->Field_C_key ?>').attr("data-type","Land").prop("readonly",true).addClass("form-control-solid");
    <?php
    }
    ?>

	    $('#<?= $R_GC->Field_A_key ?>,#<?= $R_GC->Field_B_key ?>').keyup(function() {
	        var <?= $R_GC->Field_A_key ?>  = $('#<?= $R_GC->Field_A_key ?>').val();
	        var <?= $R_GC->Field_B_key ?>  = $('#<?= $R_GC->Field_B_key ?>').val();
	        $('#<?= $R_GC->Field_C_key ?>').val(<?= $R_GC->Field_A_key ?> * <?= $R_GC->Field_B_key ?>);
	    });

    <?php
    }
    ?>

    var PROFIT_RATIO      = 0;
    var CONSUMPTION_RATIO = 0;
    var CONSUMPTION_Building = 0;
    var ESTIMATED_COSTS = 0;
    var PROFIT_Total = 0 ;

    $(document).on("keyup","input[data-calculations=true]",function(){
        Total_Land = 0;
        Total_Building = 0;

        $('input[data-type="Building"]').each(function(){
            Total_Building += parseFloat($(this).val()) || 0;
        });

        $('input[data-type="Land"]').each(function(){
            Total_Land += parseFloat($(this).val()) || 0;
        });

        CONSUMPTION_RATIO = parseFloat($('#CONSUMPTION_RATIO').val()) || 0;
        if(CONSUMPTION_RATIO !== null  &&  CONSUMPTION_RATIO !== undefined && CONSUMPTION_RATIO !== '' ){
            if(CONSUMPTION_RATIO !== 0) {
                CONSUMPTION_Building = parseFloat((CONSUMPTION_RATIO / 100) * Total_Building);
            }
            else{
                CONSUMPTION_Building = 0;
            }
        }
        ESTIMATED_COSTS = parseFloat((Total_Building - CONSUMPTION_Building)  + Total_Land);
        $('#ESTIMATED_COSTS').val(ESTIMATED_COSTS);



        PROFIT_RATIO = parseFloat($('#PROFIT_RATIO').val()) || 0;
        if(PROFIT_RATIO !== null  &&  PROFIT_RATIO !== undefined && PROFIT_RATIO !== '' ){
            if(PROFIT_RATIO !== 0) {
                PROFIT_Total = parseFloat((PROFIT_RATIO / 100) * (ESTIMATED_COSTS));
            }
            else{
                PROFIT_Total = 0;
            }
        }

        // Value Table input
        $('#Total_Land').val(Total_Land);
        $('#Total_Building').val(Total_Building);
        $('#CONSUMPTION_Total').val(CONSUMPTION_Building);
        $('#PROFIT_Total').val(PROFIT_Total);

        var MARKET_VALUE = parseFloat(PROFIT_Total + ESTIMATED_COSTS);

        $('#MARKET_VALUE').val(MARKET_VALUE);
        $('#MARKET_VALUE_Approximate').val(Math.round(MARKET_VALUE));

    });
</script>
