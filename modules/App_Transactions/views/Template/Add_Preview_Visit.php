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
<!--end::Subheader-->


<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">

        <form class="form" id="Form_Create_Transaction" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Create_Preview_Visit') ?>" enctype="multipart/form-data" method="post">
        <?= CSFT_Form() ?>

	        <?php echo  $this->session->flashdata('message'); ?>

	        <input type="hidden" name="Transaction_id" value="<?= $Transactions->transaction_id ?>">
	        <div class="card card-custom mb-5 mt-5">
		        <!--begin::Header-->
		        <div class="card-header">
			        <div class="card-title">
				        <h3 class="card-label"> اضافة زيارة معاينة  </h3>
			        </div>
		        </div>
		        <!--begin::Header-->
		        <!--begin::Body-->
		        <div class="card-body">

		            <div class="form-group row">
		                <div class="col-lg-4 mt-5">
		                    <label>المعايين</label>
                            <select name="preview_userid"  class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
	                            <?php
	                            foreach ($users_preview AS $UR)
	                            {
		                            echo '<option value="'.$UR->users_preview_id.'">'.$this->aauth->get_user($UR->users_preview_id)->full_name.'</option>';
	                            }
	                            ?>
                            </select>
		                </div>
			            <div class="col-lg-4 mt-5">
				            <label>تاريخ الزيارة</label>
				            <input type="text" name="preview_date" class="form-control datepicker" placeholder=""/>
			            </div>

			            <div class="col-lg-4 mt-5">
				            <label>نوع  المعاينة / المرحلة</label>
				            <select name="preview_stages"  class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
				            <?php
				            $type_preview =  Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');

				            if($type_preview == 12 or $type_preview ==  14){

					            echo '<option selected="selected" value="'.$type_preview.'">'.get_data_options_List_view('4',$type_preview).'</option>';

				            }elseif($type_preview == 13){

					            $Get_clients_id =  Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CLIENT');
					            $where_Get_Stages_Self = array(
					            		"clients_id" => $Get_clients_id,
						                "company_id" => $this->aauth->get_user()->company_id
					            );
					            $Get_Stages_Self = Get_Stages_Self_Construction($where_Get_Stages_Self);
					            foreach ($Get_Stages_Self->result() AS $GSS)
					            {
						            echo '<option  value="'.$GSS->stages_self_id.'">'.$GSS->item_translation.'</option>';
					            }

				            }
				            ?>
				            </select>

			            </div>
		            </div>
			        <div class="form-group row">
				        <div class="checkbox-list">


					        <label class="checkbox mt-3">
						        <input type="checkbox" value="1"  id="SMS" name="SMS" onclick="JS_SMS_CATEGORY()"  />
						        <span></span>
						        ارسال رسالة SMS
					        </label>


					        <label class="checkbox mt-3">
						        <input type="checkbox" value="1"  id="Email" name="Email" onclick="JS_Email_CATEGORY()"  />
						        <span></span>
						        ارسال بريد الكتروني
					        </label>


				        </div>
			        </div>


			        <div class="row mt-10">
				        <div class="col-lg-6" id="preview_SMS" style="display: none">
					        <label>اختر رسالة نصية</label>
					        <select name="preview_SMS"  class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
						        <?php
						        $company_id  = $this->aauth->get_user()->company_id;
						        $query_SMS = $this->db->where('company_id', $company_id);
						        $query_SMS = $this->db->where('isDeleted', 0);
						        $query_SMS = $this->db->get('protal_mail_sms_messages');

						        if($query_SMS->num_rows()>0){
							        foreach ($query_SMS->result() as $row_s) {
								        echo '<option  value="' . $row_s->messages_id . '">' . $row_s->messages_title . '</option>';
							        }
						        }
						        ?>
					        </select>

					        <br>

					        <textarea name="preview_SMS_text" id="preview_SMS_text" class="form-control"></textarea>

				        </div>
				        <div class="col-lg-6"  id="preview_Email" style="display: none">
					        <label>اختر رسالة البريد الالكتروني</label>
					        <select name="preview_Email"  class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
						        <?php
						        $company_id  = $this->aauth->get_user()->company_id;
						        $query_Email = $this->db->where('company_id', $company_id);
						        $query_Email = $this->db->where('isDeleted', 0);
						        $query_Email = $this->db->get('protal_mail_sms_messages');
						        if($query_Email->num_rows()>0){
							        foreach ($query_Email->result() as $row_e) {
								        echo '<option  value="' . $row_e->messages_id . '">' . $row_e->messages_title . '</option>';
							        }
						        }
						        ?>
					        </select>

					        <textarea name="preview_Email_text"  id="preview_Email_text" class="form-control"></textarea>

				        </div>
			        </div>

		        </div>
		        <!--begin::Body-->



		        <div class="card-footer">
			        <div class="row">
				        <div class="col-lg-6">
					        <button type="submit"   class="btn btn-primary mr-2"> انشاء الزيارة </button>
				        </div>
				        <div class="col-lg-6 text-lg-right">
				        </div>
			        </div>
		        </div>

	        </div>



        </form>

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

<script type="text/javascript">

	function JS_SMS_CATEGORY() {
		if ($("#SMS").is(":checked")) {

			$("#preview_SMS").show();

			$('#preview_SMS').change(function(event){
				event.preventDefault();

				var messages_id = $('select[name=preview_SMS]').val();

				$.ajax({
					type: 'ajax',
					method: 'get',
					async: false,
					dataType: 'json',
					url: '<?= base_url(APP_NAMESPACE_URL . '/App_Ajax/Ajax_text_p_mail_sms_messages') ?>',
					data: {
						messages_id: messages_id
					},
					success: function (response) {
						$("#preview_SMS_text").val(response.data);
					},
					error: function () {
						swal.fire(" خطا ", "في ارسال الطلب ", "error");
					}
				});
			});

		}else{
			$("#preview_SMS").hide();
		}
	}

	function JS_Email_CATEGORY() {
		if ($("#Email").is(":checked")) {
			$("#preview_Email").show();
		}else{
			$("#preview_Email").hide();
		}
	}


</script>



