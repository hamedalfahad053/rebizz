<div class="card card-custom mb-5">

    <div class="card-header">
        <div class="card-title">
            <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
            <h3 class="card-label">تقييم العقار</h3>
        </div>
        <div class="card-toolbar">

            <a href="<?= base_url(APP_NAMESPACE_URL.'/Evaluation/Add_New_Evaluation/'.$Transactions->uuid) ?>" class="btn btn-primary">
                <i class="flaticon2-line-chart"></i>  اضافة تقييم للمعاملة
            </a>


        </div>
    </div>
    <div class="card-body">


        <?php
        $query_Evluation_Transactions = $this->db->where('transaction_id',$Transactions->transaction_id);
        $query_Evluation_Transactions = $this->db->where('isDeleted',0);
        $query_Evluation_Transactions = app()->db->get('protal_evaluation_transactions');

        if ($query_Evluation_Transactions->num_rows() == 0) {

            echo Create_Status_Alert(array("key"=>"Danger","value"=>"لم يتم اضافة اي طريقة تقييم للمعاملة"));

        }else{

            ?>

            <style>th.dt-center,.dt-center { text-align: center; }</style>
            <table class="data_file table table-bordered table-hover display nowrap" width="100%">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">طريقة التقييم</th>
                    <th class="text-center">المقيم</th>
                    <th class="text-center">المعاينة</th>
                    <th class="text-center">حالة التقييم</th>
                    <th class="text-center"> المقيم </th>
                    <th class="text-center">الخيارات</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                foreach ($query_Evluation_Transactions->result() AS $QET)
                {

                    $Where_Evaluation_Methods  = array("evaluation_methods_id" => $QET->evaluation_methodid);
                    $Evaluation_Methods        = Get_Evaluation_Methods($Where_Evaluation_Methods)->row();
                    ?>
                    <tr>
                        <th class="text-center"><?= ++$i ?></th>
                        <th class="text-center"><?= $Evaluation_Methods->item_translation ?></th>
                        <th class="text-center"><?= $this->aauth->get_user($QET->evaluation_userid)->full_name ?></th>
                        <th class="text-center">
	                        <?php
	                        $where_Preview_Visit = array(
			                        "Transactions_id" => $Transactions->transaction_id,
			                        "isDeleted"       => 0,
			                        "company_id"      => $this->aauth->get_user()->company_id,
			                        "preview_Visit_acceptance !="  => 0,
	                        );
	                        $Get_Preview_Visit = Get_Preview_Visit($where_Preview_Visit)->row();

	                        $type_preview =  Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');

	                        if($type_preview == 12 or $type_preview ==  14){
		                        $type_preview_text =  get_data_options_List_view('4',$type_preview);


	                        }elseif($type_preview == 13){

		                        $Get_Stages_Self = $this->db->where('company_id',$this->aauth->get_user()->company_id);
		                        $Get_Stages_Self = $this->db->where('transactions_id',$Transactions->transaction_id);
		                        $Get_Stages_Self = $this->db->where('stages_self_number',$Get_Preview_Visit->preview_stages);
		                        $Get_Stages_Self = $this->db->get('portal_transaction_stages_self_construction');

		                        if($Get_Stages_Self->num_rows()>0) {
			                        $type_preview_text = ' المرحلة :'.$Get_Stages_Self->row()->stages_self_number.' -';
	                                $type_preview_text .= mb_substr($Get_Stages_Self->row()->stages_self_text,0,50,'UTF-8').'...';
	                             }
	                        }

	                        echo '' . $type_preview_text . '<br> - المعاين : '.$this->aauth->get_user($Get_Preview_Visit->preview_userid)->full_name.'- تاريخ المعاينة - <br>  '.date('Y-m-d h:i:s a',$Get_Preview_Visit->preview_Visit_date_completed).'';
	                        ?>
                        </th>
	                    <th class="text-center">

		                    <?php
		                    if($QET->evaluation_status == 0){
		                    	echo 'قيد المعالجة - جديد';
		                    }elseif($QET->evaluation_status == 1){
                                echo 'تم الرفض';
		                    }elseif($QET->evaluation_status == 2){
		                    	echo 'تم اعتماد التقييم';
		                    }
		                    ?>
	                    </th>
                        <th class="text-center">
                            <?= $this->aauth->get_user($QET->Create_Byid)->full_name ?>
                            <?= date('Y-m-d ',$QET->Create_Date); ?>
                        </th>
                        <th class="text-center">
                            <?php
                            $evaluation_transaction_final_cost_bank = $this->db->where('transaction_id',$Transactions->transaction_id);
                            $evaluation_transaction_final_cost_bank = $this->db->where('preview_id',$QET->preview_id);
                            $evaluation_transaction_final_cost_bank = $this->db->get('protal_evaluation_transaction_final_costbank');

                            if($evaluation_transaction_final_cost_bank->num_rows()>0) {

                            }else{
	                            if(Check_Permissions(37)) {
		                            $options_Evaluation['view'] = array(
				                            "class" => '',
				                            "id" => '',
				                            "title" => 'عرض',
				                            "data-attribute" => '',
				                            "href" => base_url(APP_NAMESPACE_URL . '/Evaluation/Evaluation_Transactions/' . $Transactions->uuid . '/' . $QET->evaluation_uuid));


	                            }
                            }

                            if(Check_Permissions(27)) {
	                            $options_Evaluation['custom'] = array(
			                            "class" => '',
			                            "id" => '',
			                            "title" => ' اعتماد / مراجعة التقرير ',
			                            "data-attribute" => '',
			                            "color" => 'warning',
			                            "icon" => 'flaticon2-checkmark',
			                            "href" => base_url(APP_NAMESPACE_URL . '/Evaluation/Approval_Evaluation_Transactions/' . $Transactions->uuid . '/' . $QET->evaluation_uuid));
                            }
                            echo Create_Options_Button($options_Evaluation);

                            ?>
                        </th>
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