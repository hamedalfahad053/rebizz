


	    <div class="card card-custom mb-5">
		    <!--begin::Header-->
		    <div class="card-header">
			    <div class="card-title">
				    <h3 class="card-label">افادة المعاين حول جدولة الزيارة</h3>
			    </div>
		    </div>
		    <!--end::Header-->
		    <!--begin::Body-->
		    <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Preview/Create_Preview_FeedBack/'.$this->uri->segment(4).'/'.$this->uri->segment(5)) ?>" method="post">
			    <div class="card-body">
				    <?= CSFT_Form() ?>
				    <input type="hidden" name="" value="<?=  $this->uri->segment(4); ?>">


					    <div class="form-group row">
						    <div class="col-lg-6">
							    <label>حالة الزيارة</label>
							    <?php
							    $lang       = get_current_lang();
							    $query_list = app()->db->from('portal_list_data list');
							    $query_list = app()->db->join('portal_list_data_translation  list_translation', 'list.list_id=list_translation.item_id');
							    $query_list = app()->db->where('list.list_key', 'LIST_LIST_VISITING_STATUS');
							    $query_list = app()->db->where('list_translation.translation_lang', $lang);
							    $query_list = app()->db->get()->row();

							    $query_list_options = app()->db->from('portal_list_options_data list_options');
							    $query_list_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
							    $query_list_options = app()->db->where('list_options.list_id', $query_list->list_id);
							    $query_list_options = app()->db->where('list_options.options_key !=','NEW_PENDING_TESTIMONY_PREVIEWER');
							    $query_list_options = app()->db->where('options_translation.translation_lang', $lang);
							    $query_list_options = app()->db->order_by('list_options.options_sort', ' DESC');
							    $query_list_options = app()->db->get();
							    ?>
							    <select data-live-search="true" data-size="5" name="LIST_VISITING_STATUS" class="form-control selectpicker" id="LIST_VISITING_STATUS" title="فضلا اختر من ...">
								    <?php
								    foreach ($query_list_options->result() AS $OP)
								    {
								    ?>
								    <option value="<?= $OP->list_options_id ?>"><?= $OP->item_translation ?></option>
								    <?php
								    }
								    ?>
							    </select>
						    </div>
					    </div>

					    <div class="form-group row">
						    <div class="col-lg-6">
							    <label>تاريخ الزيارة</label>
							    <input type="text" name="Date_visit" class="form-control datepicker"/>
						    </div>
						    <div class="col-lg-6">
							    <label>وقت  الزيارة</label>
							    <input type="text" name="Time_visit" class="form-control kt_timepicker"/>
						    </div>
					    </div>


				        <div class="form-group row">
						    <div class="col-lg-12">
							    <label>ملاحظات اضافية</label>
							    <textarea name="note_visit" class="summernote" ></textarea>
						    </div>
					    </div>


			    </div>
			    <!--begin::Body-->
			    <div class="card card-custom  mt-10">
				    <div class="card-footer">
					    <div class="row">
						    <div class="col-lg-6">
							    <button type="submit" class="btn btn-primary mr-2">ارسال الافادة </button>
						    </div>
						    <div class="col-lg-6 text-lg-right">
						    </div>
					    </div>
				    </div>
			    </div>
		    </form>
	    </div>
	    <!--end: Card-->





<script>
	$('.kt_timepicker').timepicker();

	$('.summernote').summernote({
		height: 150
	});
</script>

