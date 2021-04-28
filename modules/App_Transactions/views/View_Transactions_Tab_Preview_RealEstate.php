


    <div class="card card-custom mt-10">

        <!--begin::Header-->
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                   الزيارات المجدولة
                </h3>
            </div>
            <div class="card-toolbar">

            </div>
        </div>
        <!--begin::Header-->

        <!--begin::Body-->
        <div class="card-body">

	        <?php
	        $p = 0;
	        $options_Preview = array();


	        $where_Preview_Visit = array(
			    "Transactions_id"=> $Transactions->transaction_id,"preview_userid"=>$this->aauth->get_user()->id
	        );

	        $Get_Preview_Visit = Get_Preview_Visit($where_Preview_Visit);

	        if ($Get_Preview_Visit->num_rows() == 0){

		        $msg_result['key'] = 'Danger';
		        $msg_result['value'] = 'لا يوجد زيارة مجدولة من قبل المنسق';
		        $msg_result_view = Create_Status_Alert($msg_result);
		        echo $msg_result_view;

	        }else{
		        ?>

		        <style>th.dt-center,.dt-center { text-align: center; }</style>
		        <table class="data_table table table-bordered table-hover display nowrap" width="100%">
			        <thead>
			        <tr>
				        <th class="text-center">#</th>
				        <th class="text-center">المنسق</th>
				        <th class="text-center">تاريخ الاضافة</th>
				        <th class="text-center">نوع تقييم العقار / المرحلة</th>
				        <th class="text-center">الحالة</th>
				        <th class="text-center">الخيارات</th>
			        </tr>
			        </thead>
			        <tbody>
			        <?php
			        $ii = 0;
			        foreach ($Get_Preview_Visit->result() AS $PVF)
			        {
				        ?>
				        <tr>
					        <td class="text-center"><?= ++$ii ?></td>
					        <td class="text-center">
						        <?php
						        echo $this->aauth->get_user($PVF->createBy)->full_name
						        ?>
					        </td>
					        <td class="text-center">
						        <?php
						        echo date('Y-m-d h:i:s a',$PVF->preview_date_assignment);
						        ?>
					        </td>
					        <td class="text-center">
						        <?php
						        $type_preview =  Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');
						        if($type_preview == 12 or $type_preview ==  14){
							        get_data_options_List_view('4',$type_preview);
						        }elseif($type_preview == 13){

							        $Get_clients_id =  Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CLIENT');
							        $where_Get_Stages_Self = array(
									        "stages_self_id" => $PVF->preview_stages,
									        "clients_id"     => $Get_clients_id,
									        "company_id"     => $this->aauth->get_user()->company_id
							        );
							        $Get_Stages_Self = Get_Stages_Self_Construction($where_Get_Stages_Self);
							        if($Get_Stages_Self->num_rows()>0) {
								        echo $Get_Stages_Self->row()->item_translation;
							        }
						        }
						        ?>
					        </td>
					        <td class="text-center">
						        <?=  Create_Status_badge(array("key"=>"Danger","value"=>get_data_options_List_view('60',$PVF->preview_stauts))); ?>
					        </td>
					        <td class="text-center">

						        <a href="<?= base_url(APP_NAMESPACE_URL . '/Transactions/Form_Preview_Feedback/'.$Transactions->uuid.'/'.$PVF->Coordination_uuid) ?>" class="btn btn-success">
							        <i class="flaticon2-sheet"></i> ارسال افادة
						        </a>


						        <?php
						        if($PVF->preview_stauts == 298){
						        ?>
						        <a href="<?= base_url(APP_NAMESPACE_URL . '/Transactions/Dashboard_Preview_Property/'.$Transactions->uuid.'/'.$PVF->Coordination_uuid) ?>" class="btn btn-primary">
							        <i class="flaticon-placeholder-1"></i>  معاينة العقار
						        </a>
						        <?php
						        }
						        ?>
					        </td>
				        </tr>
				        <?php
			        }
			        ?>
			        </tbody>
		        </table>

		        <?php
	        } // if ($Preview_Visit_FeedBack->num_rows() == 0)
	        ?>



        </div>
        <!--begin::Body-->


    </div><!--<div class="card card-custom mt-10">-->
