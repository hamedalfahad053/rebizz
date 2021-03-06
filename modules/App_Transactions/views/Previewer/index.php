


<div class="card card-custom mb-10">

    <!--begin::Header-->
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                معاينة العقار
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
			"Transactions_id" => $Transactions->transaction_id,
			//"preview_userid"  => $this->aauth->get_user()->id,
			"isDeleted"       => 0,
			"company_id"      => $this->aauth->get_user()->company_id
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
            <table class="data_table table table-bordered table-hover display" width="100%">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">المنسق</th>
                    <th class="text-center">تاريخ الاضافة</th>
                    <th class="text-center">نوع تقييم العقار / المرحلة</th>
	                <th class="text-center">افادة المعاين</th>
                    <th class="text-center">حالة الزيارة</th>
                    <th class="text-center">الخيارات</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $ii = 0;
                foreach ($Get_Preview_Visit->result() AS $PVF)
                {

	                $type_preview =  Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');

	                if($type_preview == 12 or $type_preview ==  14){

		                $type_preview_text =  get_data_options_List_view('4',$type_preview);

	                }elseif($type_preview == 13){

		                $Get_Stages_Self = $this->db->where('company_id',$this->aauth->get_user()->company_id);
		                $Get_Stages_Self = $this->db->where('transactions_id',$Transactions->transaction_id);
		                $Get_Stages_Self = $this->db->where('stages_self_number',$PVF->preview_stages);
		                $Get_Stages_Self = $this->db->get('portal_transaction_stages_self_construction');
		                if($Get_Stages_Self->num_rows()>0) {
			                $type_preview_text = mb_substr($Get_Stages_Self->row()->stages_self_text,0,50,'UTF-8').'...';
		                }
	                }
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
                        <td class="text-center"><?= $type_preview_text ?></td>
                        <td class="text-center">
                            <?=  get_data_options_List_view('60',$PVF->preview_stauts); ?>
                        </td>
	                    <td class="text-center">
		                    <?php
		                    if($PVF->preview_Visit_acceptance ==0){
		                    	echo 'لم تعتمد';
		                    }else{
			                    echo get_data_options_List_view('90',$PVF->preview_Visit_acceptance);
		                    }
		                    ?>
	                    </td>

                        <td class="text-center">
                            <?php
                            $query_preview_data = app()->db->where('Transaction_id',$Transactions->transaction_id);
                            $query_preview_data = app()->db->where('company_id',$this->aauth->get_user()->company_id);
                            $query_preview_data = app()->db->where('preview_id',$PVF->Coordination_id);
                            $query_preview_data = app()->db->get('protal_transaction_preview_data');

                            if($query_preview_data->num_rows()>0){
                                ?>
                                <a href="<?= base_url(APP_NAMESPACE_URL . '/Preview/View_Preview/'.$Transactions->uuid.'/'.$PVF->Coordination_uuid) ?>" class="btn btn-primary">
                                    <i class="flaticon-placeholder-1"></i>  عرض بيانات المعاينة
                                </a>
                                <?php
                            }else{

	                            $query_preview_feedback = app()->db->order_by('feedback_id', 'DESC');
                                $query_preview_feedback = app()->db->where('feedback_userid',$this->aauth->get_user()->id);
                                $query_preview_feedback = app()->db->where('Coordination_id',$PVF->Coordination_id);
                                $query_preview_feedback = app()->db->get('protal_users_preview_feedback');
                                ?>

                                <a href="<?= base_url(APP_NAMESPACE_URL . '/Preview/Form_Preview_Feedback/'.$Transactions->uuid.'/'.$PVF->Coordination_uuid) ?>" class="btn btn-success">
                                    <i class="flaticon2-sheet"></i> ارسال افادة
                                </a>

                                <?php
                                if($query_preview_feedback->num_rows()>0){

                                	if($query_preview_feedback->row()->VISITING_STATUS == 298 ){
                                    ?>
                                    <a href="<?= base_url(APP_NAMESPACE_URL . '/Preview/Dashboard_Preview_Property/'.$Transactions->uuid.'/'.$PVF->Coordination_uuid) ?>" class="btn btn-primary">
                                        <i class="flaticon-placeholder-1"></i>  معاينة العقار
                                    </a>
                                    <?php
	                                }
                                }

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
