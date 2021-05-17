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


