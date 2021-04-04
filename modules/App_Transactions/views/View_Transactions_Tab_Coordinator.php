 <div class="card card-custom mb-5 mt-10">

    <div class="card-header">
        <div class="card-title">
            <span class="card-icon"><i class="flaticon2-layers text-primary"></i></span>
            <h3 class="card-label"> ادارة الزيارات </h3>
        </div>
        <div class="card-toolbar">

	        <a href="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Add_Preview_Visit/'.$Transactions->uuid) ?>" class="btn btn-success">
		        <i class="flaticon-placeholder-1"></i>  اضافة زيارة معاينة
	        </a>

        </div>
    </div>
    <div class="card-body">
	    <?php
	    $where_Preview_Visit = array("Transactions_id" => $Transactions->transaction_id);
	    $Get_Preview_Visit = Get_Preview_Visit($where_Preview_Visit);
	    $p               = 0;
	    $options_Preview = array();
	    if($Get_Preview_Visit->num_rows()==0){

		    $msg_result['key'] = 'Danger';
		    $msg_result['value'] = 'لم يتم انشاء زيارات للمعاملة';
		    $msg_result_view = Create_Status_Alert($msg_result);
		    echo $msg_result_view;

	    }else{
	    ?>
	    <style>th.dt-center,.dt-center { text-align: center; }</style>
	    <table class="data_table table table-bordered table-hover display nowrap" width="100%">
		    <thead>
		    <tr>
			    <th class="text-center">رقم الزيارة</th>
			    <th class="text-center">المعاين</th>
			    <th class="text-center">نوع زيارة المعاينة</th>
			    <th class="text-center">بواسطة / التاريخ</th>
			    <th class="text-center">حالة الزيارة</th>
			    <th class="text-center">الخيارات</th>
		    </tr>
		    </thead>
		    <tbody>
		    <?php
		    foreach ($Get_Preview_Visit->result() AS $PV)
			    {
			    ?>
				    <tr>
					    <td class="text-center"><?= ++$p ?></td>
					    <td class="text-center"><?= $this->aauth->get_user($PV->preview_userid)->full_name ?></td>
					    <td class="text-center">
						    <?php
						    $type_preview =  Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');
						    if($type_preview == 12 or $type_preview ==  14){
							    get_data_options_List_view('4',$type_preview);
						    }elseif($type_preview == 13){

							    $Get_clients_id =  Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CLIENT');
							    $where_Get_Stages_Self = array(
									    "stages_self_id" => $PV->preview_stages,
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
					    <td class="text-center"><?= $this->aauth->get_user($PV->createBy)->full_name ?><br><?= date('Y-m-d h:i:s a',$PV->preview_date_assignment) ?></td>
					    <td class="text-center">
						    <?php
						    echo Create_Status_badge(array("key"=>"Danger","value"=>get_data_options_List_view('60',$PV->preview_stauts)));
						    ?>
					    </td>
					    <td class="text-center">
						    <?php
						    $options_Preview['view'] = array("class"=>'',"id"=>'',"title"=> '',"data-attribute"=>'',"icon"=> '',"href"=> base_url(APP_NAMESPACE_URL.'/Transactions/View_Coordination/'.$Transactions->uuid.'/'.$PV->Coordination_uuid));
						    echo Create_Options_Button($options_Preview);
						    ?>
					    </td>
				    </tr>
		        <?php
			    }
		    ?>
		    </tbody>
	    </table>
	    <?php
	    }
	    ?>
    </div>
</div>



 <div class="card card-custom mb-5 mt-10">

	 <div class="card-header">
		 <div class="card-title">
			 <span class="card-icon"><i class="flaticon-email-black-circular-button text-primary"></i></span>
			 <h3 class="card-label"> افادات العميل </h3>
		 </div>
		 <div class="card-toolbar">

		 </div>
	 </div>
	 <div class="card-body">


	 </div>
 </div>

