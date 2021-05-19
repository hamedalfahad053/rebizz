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
					<h3 class="card-label">اختر طريقة التقييم</h3>
				</div>
				<div class="card-toolbar">
				</div>
			</div>
			<form class="form" id="Form_Create_Transaction" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Evaluation/Create_Methods_Evaluation/'.$this->uri->segment(4)) ?>" enctype="multipart/form-data" method="post">
			<?= CSFT_Form() ?>
				<div class="card-body">


					<div class="form-group row">

						<div class="col-lg-6 mt-5">
							<label>اختر طريقة التقييم </label>
							<select name="Evaluation_Methods" class="form-control selectpicker" title="<?= lang("Select_noneSelectedText") ?>" data-live-search="true">
							<?php
							$Where_Evaluation_Methods  = array(
                               "evaluation_methods_Status" => 1
							);


							$Evaluation_Methods        = Get_Evaluation_Methods($Where_Evaluation_Methods);
							foreach ($Evaluation_Methods->result() AS $EM)
							{

								$q_old_add = $this->db->where('transaction_id',$Transactions->transaction_id);
								$q_old_add = $this->db->where('evaluation_methodid',$EM->evaluation_methods_id);
								$q_old_add = $this->db->get('protal_evaluation_transactions')->num_rows();

								if($q_old_add == 0){
									echo '<option value="'.$EM->evaluation_methods_id.'">'.$EM->item_translation.'</option>';
								}

							}
							?>
							</select>
						</div>

						<div class="col-lg-6 mt-5">
							<label> الزيارات المعتمدة </label>
							<select name="preview_id" class="form-control selectpicker" title="<?= lang("Select_noneSelectedText") ?>" data-live-search="true">
								<?php
								$where_Preview_Visit = array(
										"Transactions_id" => $Transactions->transaction_id,
										"isDeleted"       => 0,
										"company_id"      => $this->aauth->get_user()->company_id,
									    "preview_Visit_acceptance !="  => 0,
								);
								$Get_Preview_Visit = Get_Preview_Visit($where_Preview_Visit);

								if($Get_Preview_Visit->num_rows()>0)
								{
									foreach ($Get_Preview_Visit->result() as $PV) {

										$type_preview =  Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');
										if($type_preview == 12 or $type_preview ==  14){
											$type_preview_text =  get_data_options_List_view('4',$type_preview);


										}elseif($type_preview == 13){

											$Get_Stages_Self = $this->db->where('company_id',$this->aauth->get_user()->company_id);
											$Get_Stages_Self = $this->db->where('transactions_id',$Transactions->transaction_id);
											$Get_Stages_Self = $this->db->where('stages_self_number',$PV->preview_stages);
											$Get_Stages_Self = $this->db->get('portal_transaction_stages_self_construction');


											$type_preview_text = ' المرحلة :'.$Get_Stages_Self->row()->stages_self_number.' -';
											$type_preview_text .= mb_substr($Get_Stages_Self->row()->stages_self_text,0,50,'UTF-8').'...';

										}

										$q_old_add = $this->db->where('transaction_id', $Transactions->transaction_id);
										$q_old_add = $this->db->where('evaluation_methodid', $EM->evaluation_methods_id);
										$q_old_add = $this->db->get('protal_evaluation_transactions')->num_rows();

										if ($q_old_add == 0) {
											echo '<option value="' . $PV->Coordination_id . '">' . $type_preview_text . ' - المعاين : '.$this->aauth->get_user($PV->preview_userid)->full_name.'- تاريخ المعاينة -   '.date('Y-m-d h:i:s a',$PV->preview_Visit_date_completed).' </option>';
										}

									}
								}else{
									echo '<option>لا يوجد معاينة معتمدة </option>';
								}
								?>
							</select>
						</div>
					</div>


				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-6">
							<button type="submit" id="buttonCreateSections" class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
						</div>
						<div class="col-lg-6 text-lg-right">


						</div>
					</div>
				</div>
			</form>

		</div>

	</div>
</div>


