



        <form class="form" id="Form_Create_Transaction" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Coordinator/Create_Preview_Visit/'.$this->uri->segment(4)) ?>" enctype="multipart/form-data" method="post">
        <?= CSFT_Form() ?>

	        <?php echo  $this->session->flashdata('message'); ?>

	        <input type="hidden" name="Transaction_id" value="<?= $Transactions->transaction_id ?>">
	        <div class="card card-custom mb-5">
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
		                <div class="col-lg-6 mt-5">
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
			            <div class="col-lg-6 mt-5">
				            <label>تاريخ الزيارة</label>
				            <input type="text" name="preview_date" class="form-control datepicker" placeholder=""/>
			            </div>



		            </div>

			        <div class="form-group row">
				        <div class="col-lg-12 mt-5">
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
								        echo '<option  value="'.$GSS->stages_self_id.'">   (رقم المرحلة :'.$GSS->stages_self_number.')  '.$GSS->item_translation.'</option>';
							        }

						        }
						        ?>
					        </select>
					        <input type="hidden"  name="preview_type" class="form-control"  value="<?= $type_preview ?>" />
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

				        <div class="col-lg-12 mt-5" id="preview_SMS" style="display: none">
					        <label>اختر رسالة نصية</label>
					        <select name="preview_SMS"  class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
						        <?php
						        $query_SMS = $this->db->where('company_id',$this->aauth->get_user()->company_id);
						        $query_SMS = $this->db->where('isDeleted', 0);
						        $query_SMS = $this->db->where('messages_type', 'SMS');
						        $query_SMS = $this->db->get('protal_mail_sms_messages');

						        if($query_SMS->num_rows()>0){
							        foreach ($query_SMS->result() as $row_s) {
								        echo '<option  value="' . $row_s->messages_uuid . '">' . $row_s->messages_title . '</option>';
							        }
						        }
						        ?>
					        </select>

					        <div class="col-lg-12 mt-5">
						        <textarea name="preview_SMS_text" rows="5" maxlength="140"  placeholder="Top left" id="preview_SMS_text" class="form-control"></textarea>
					        </div>

				        </div>



				        <div class="col-lg-12 mt-5"  id="preview_Email" style="display: none">
					        <label>اختر رسالة البريد الالكتروني</label>
					        <select name="preview_Email"  class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
						        <?php
						        $query_Email = $this->db->where('company_id', $this->aauth->get_user()->company_id);
						        $query_Email = $this->db->where('messages_type', 'Email');
						        $query_Email = $this->db->where('isDeleted', 0);
						        $query_Email = $this->db->get('protal_mail_sms_messages');
						        if($query_Email->num_rows()>0){
							        foreach ($query_Email->result() as $row_e) {
								        echo '<option  value="' . $row_e->messages_uuid . '">' . $row_e->messages_title . '</option>';
							        }
						        }
						        ?>
					        </select>

					        <div class="col-lg-12  mt-5">
						        <textarea name="preview_Email_text" rows="5"  id="preview_Email_textarea" class=" form-control">
						        </textarea>
					        </div>

					        <label class="checkbox mt-3">
						        <input type="checkbox" value="1"  id="attach" name="attach" onclick=""  />
						        <span></span>
						         تضمين مرفقات المعاملة
					        </label>
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
			$('select[name=preview_Email]').change(function(event){
				event.preventDefault();
				var messages_id = $('select[name=preview_Email]').val();
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
						var content_text = response.data;

						$('#preview_Email_textarea').summernote('code', content_text);
					},
					error: function () {
						swal.fire(" خطا ", "في ارسال الطلب ", "error");
					}
				});
			});
		}else{
			$("#preview_Email").hide();
		}
	}

	// function JS_Email_CATEGORY() {
	// 	if ($("#Email").is(":checked")) {
	// 		$("#preview_Email").show();
	// 	}else{
	// 		$("#preview_Email").hide();
	// 	}
	// }

	$('#preview_SMS_text').maxlength({
		threshold: 140,
		warningClass: "label label-warning label-rounded label-inline",
		limitReachedClass: "label label-success label-rounded label-inline"
	});

</script>



