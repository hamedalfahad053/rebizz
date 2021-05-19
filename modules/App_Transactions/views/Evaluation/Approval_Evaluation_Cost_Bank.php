
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
			<a href="<?= base_url(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$this->uri->segment(4)) ?>" class="btn btn-success">
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

		<div class="card card-custom mb-5 mt-10">
			<div class="card-header">
				<div class="card-title">
					<span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
					<h3 class="card-label"> بيانات المقيم  </h3>
				</div>
				<div class="card-toolbar">

				</div>
			</div>
			<div class="card-body">
				<table class="data_table table table-bordered table-hover display" width="100%">
					<tr>
						<th class="text-center bg-light-primary">المقيم</th>
						<th class="text-center bg-light-primary">طريقة التقييم</th>
						<th class="text-center bg-light-primary">تاريخ / وقت </th>
						<th class="text-center bg-light-primary">حالة التقييم</th>
						<th class="text-center bg-light-primary">الخيارات</th>
					</tr>
					<tr>
						<th class="text-center"><?= $this->aauth->get_user($get_evaluation->evaluation_userid)->full_name; ?></th>
						<th class="text-center">
							<?php
							$Where_Evaluation_Methods  = array("evaluation_methods_id" => $get_evaluation->evaluation_methodid);
							$Evaluation_Methods        = Get_Evaluation_Methods($Where_Evaluation_Methods)->row();
							echo $Evaluation_Methods->item_translation;
							?>
						</th>
						<th class="text-center">
							<?= date('Y-m-d h:i:s a',$get_evaluation->Create_Date) ?>
						</th>
						<th class="text-center">
							<?php
							if($get_evaluation->evaluation_status == 0){
								echo 'جديد';
							}elseif($get_evaluation->evaluation_status == 1){
								echo 'تم الرفض';
							}elseif($get_evaluation->evaluation_status == 2){
								echo 'تم اعتماد التقييم';
							}
							?>
						</th>
						<th class="text-center">
							<?php
							if(Check_Permissions(27)){


								if($get_evaluation->evaluation_status > 0){
									echo 'تم اعتماد حالة التقييم';
								}else{
									$options['deleted'] = array(
											"class"=>'',
											"id"=>'',
											"data-attribute"=>'',
											"title"=> 'رفض ',
											"href"=> base_url(APP_NAMESPACE_URL.'/Evaluation/Submit_Approval_Evaluation_Transactions/'.$Transactions->uuid.'/1'.$get_evaluation->evaluation_uuid.'/2'));

									$options['custom'] = array(
											"class"=>'',
											"id"=>'',
											"title"=> 'اعتماد',
											"data-attribute"=>'',
											"icon"=> 'flaticon2-checkmark',
											"color" =>'success',
											"href"=> base_url(APP_NAMESPACE_URL.'/Evaluation/Submit_Approval_Evaluation_Transactions/'.$Transactions->uuid.'/'.$get_evaluation->evaluation_uuid.'/2'));
									echo Create_Options_Button($options);
								}
							}
							?>
						</th>
					</tr>
				</table>
			</div>

		</div>



		<div class="card card-custom mb-5 mt-10">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
            <h3 class="card-label"> عرض التقييم النهائي للمعاينة </h3>
        </div>
        <div class="card-toolbar">

        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered table-hover mt-3 data_table_Land_Comparisons">
            <tr>
                <th colspan="2" class="text-center">البيان</th>
                <th colspan="2" class="text-center">سعر المتر</th>
                <th colspan="2" class="text-center">الاجمالي</th>
            </tr>
            <?php
            $LIST_CLIENT                    = Transaction_data_by_key($Transactions->transaction_id,17,1,'LIST_CLIENT');
            $CUSTOMER_CATEGORY              = Transaction_data_by_key($Transactions->transaction_id,17,1,'LIST_CUSTOMER_CATEGORY');
            $TYPE_OF_PROPERTY               = Transaction_data_by_key($Transactions->transaction_id,17,1,'LIST_TYPE_OF_PROPERTY');
            $TYPES_OF_REAL_ESTATE_APPRAISAL = Transaction_data_by_key($Transactions->transaction_id,17,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');
            $Form_Components  = Get_View_Components_Customs(17,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL);

            foreach ($Form_Components->result() AS $RC)
            {


                $td       = '';
                $i_tr     = 0;
                $open_tr  = '<tr>';
                $close_tr = '</tr>';

                $Get_Fields_Components = Building_Fields_Components_Forms($RC->Forms_id, $RC->components_id,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL,'All');



                foreach ($Get_Fields_Components as $GFC)
                {
                    if($GFC['Fields_key'] ==='CONSUMPTION_RATIO'  or  $GFC['Fields_key'] ==='PROFIT_RATIO' or $GFC['Fields_key'] === 'ESTIMATED_COSTS' or $GFC['Fields_key'] === 'MARKET_VALUE'){

                    }else{

                        ++$i_tr;

                        $td .= '<td>'.$GFC['Fields_Title'].'</td>';
                        $td .= '<td>' . number_format(Get_Transaction_Preview_data_by_key($Transactions->transaction_id,$preview_Visit->Coordination_id, $RC->Forms_id, $RC->components_id,$GFC['Fields_key'])) . '</td>';

                        if($i_tr == 3){

                            echo $open_tr.$td.$close_tr;

                            $td   = '';
                            $i_tr = 0;

                        }

                    }
                }



            }
            ?>
        </table>



        <?php
        $get_evaluation_table = $this->db->where('transaction_id',$Transactions->transaction_id);
        $get_evaluation_table = $this->db->where('preview_id',$preview_Visit->Coordination_id);
        $get_evaluation_table = $this->db->get('protal_evaluation_transaction_final_costbank');

        if($get_evaluation_table->num_rows()>0){
            $get_evaluation_table_row = $get_evaluation_table->row();
        }
        ?>

        <table class="table table-striped table-bordered table-hover mt-3 data_table_Land_Comparisons">
            <tr>
                <th class="text-center" width="25%">إجمالي قيمة الأرض</th>
                <td class="text-center"><?= number_format($get_evaluation_table_row->Total_Land) ?></td>
            </tr>
            <tr>
                <th class="text-center" width="25%">إجمالي قيمة المباني </th>
                <td class="text-center"><?= number_format($get_evaluation_table_row->Total_Building) ?></td>
            </tr>
            <tr>
                <th class="text-center" width="25%">نسبة الاستهلاك (%)</th>
                <td class="text-center">%<?= number_format($get_evaluation_table_row->CONSUMPTION_RATIO) ?></td>
            </tr>
            <tr>
                <th class="text-center" width="25%">قيمة الاستهلاك</th>
                <td class="text-center"><?= number_format($get_evaluation_table_row->CONSUMPTION_Total) ?></td>
            </tr>
            <tr>
                <th class="text-center" width="25%">التكلفة التقديرية (التكلفة)</th>
                <td class="text-center"><?= number_format($get_evaluation_table_row->ESTIMATED_COSTS) ?></td>
            </tr>
            <tr>
                <th class="text-center" width="25%">نسبة الربح (%)</th>
                <td class="text-center">%<?= number_format($get_evaluation_table_row->PROFIT_RATIO) ?></td>
            </tr>
            <tr>
                <th class="text-center" width="25%">قيمة الربح</th>
                <td class="text-center"><?= number_format($get_evaluation_table_row->PROFIT_Total) ?></td>
            </tr>
            <tr>
                <th class="text-center" width="25%">القيمة السوقية  (حسب المعطيات)</th>
                <td class="text-center"><?= number_format($get_evaluation_table_row->MARKET_VALUE) ?></td>
            </tr>
            <tr>
                <th class="text-center" width="25%">القيمة السوقية  (التقريبية)</th>
                <td class="text-center"><?= number_format($get_evaluation_table_row->MARKET_VALUE_Approximate) ?>
                </td>
            </tr>
        </table>

    </div>
</div>


	</div>
</div>
