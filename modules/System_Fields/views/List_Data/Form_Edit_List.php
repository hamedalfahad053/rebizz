<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5"><?= $Page_Title  ?></h5>
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

        </div>
        <!--end::Toolbar-->
    </div>
</div>
<!--end::Subheader-->


<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">

                <form class="form"  action="<?= base_url(ADMIN_NAMESPACE_URL.'/List_Data/Create_List_Data') ?>" method="post">
                    <?= CSFT_Form() ?>
                    <?php echo  $this->session->flashdata('message'); ?>
                    <div class="card card-custom">
                       <div class="card-header">
                                <div class="card-title">
                                    <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
                                    <h3 class="card-label"><?= $Page_Title ?></h3>
                                </div>
                                <div class="card-toolbar"></div>
                            </div>
                          <div class="card-body">

                              <div class="form-group row">
                                 <div class="col-lg-4">
                                   <label><?= lang('Global_form_title_ar') ?></label>
                                   <input type="text" name="title_ar" class="form-control" value="<?= set_value('title_ar'); ?>" placeholder="<?= lang('Global_form_title_ar') ?>"/>
                                 </div>
                                 <div class="col-lg-4">
                                   <label><?= lang('Global_form_title_en') ?></label>
                                   <input type="text" name="title_en" class="form-control" value="<?= set_value('title_en'); ?>" placeholder="<?= lang('Global_form_title_en') ?>"/>
                                 </div>
                                 <div class="col-lg-4">
                                      <label><?= lang('Table_Status') ?> </label>
                                      <select name="list_data_status" class="form-control selectpicker" data-live-search="true">
                                          <?php
                                          foreach ($List_status AS $key => $value)
                                          {
                                              echo '<option value="'.$key.'">'.$value.'</option>';
                                          }
                                          ?>
                                      </select>
                                 </div>
                              </div>


	                          <div class="form-group row">
		                          <div class="col-lg-4">
			                          <div class="radio-list mt-5">
				                          <label class="radio">
					                          <input type="radio" value="1" name="Linking_table"/>
					                          <span></span>
					                          ???? ???????? ?????? ???????????????? ??????????
				                          </label>
			                          </div>
			                          <div class="radio-list mt-5">
				                          <label class="radio">
					                          <input type="radio" value="1" name="Linking_table"/>
					                          <span></span>
					                          ???? ???????? ?????? ???????????????? ???????????? ????????
				                          </label>
			                          </div>
			                          <div class="radio-list mt-5">
				                          <label class="radio">
					                          <input type="radio" value="1" name="Linking_table"/>
					                          <span></span>
					                          ???? ???????? ?????? ????????????????
				                          </label>
			                          </div>
		                          </div>
	                          </div>


                          </div>
                    </div><!--<div class="card card-custom">-->





	                <div class="card card-custom  mt-10">
		                <div class="card-header">
			                <div class="card-title">
				                <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
				                <h3 class="card-label">???????????? ??????????????</h3>
			                </div>
			                <div class="card-toolbar"></div>
		                </div>
		                <div class="card-body">
			                <div id="kt_repeater">
				                <div class="form-group row">
					                <div data-repeater-list="option_list" class="col-lg-12">
						                <div data-repeater-item class="form-group row align-items-center">

							                <div class="col-md-2">
								                <label>???????????????? ????????????????</label>

									                <select name="options_list"  class="form-control selectpicker options_list" multiple data-live-search="true">
										                <?php
										                foreach ($list_group AS $RL)
										                {
										                   echo '<optgroup label="'.$RL['list_name'].'">';
										                   foreach ($RL['list_option'] AS $RO)
										                   {
										                   	  echo '<option value="'.$RO['list_options_id'].'">'.$RO['item_translation'].'</option>';
										                   }
										                   echo '</optgroup>';
										                }
										                ?>
									                </select>

								                <div class="d-md-none mb-2"></div>
							                </div>

							                <div class="col-md-2">
								                <label><?= lang('Global_form_title_ar') ?></label>
								                <input type="text" name="option_ar" value="<?php echo set_value('option_ar'); ?>" class="form-control" placeholder="<?= lang('Global_form_title_ar') ?>"/>
								                <div class="d-md-none mb-2"></div>
							                </div>

							                <div class="col-md-2">
								                <label><?= lang('Global_form_title_en') ?></label>
								                <input type="text" name="option_en" value="<?php echo set_value('option_en'); ?>" class="form-control" placeholder="<?= lang('Global_form_title_en') ?>"/>
								                <div class="d-md-none mb-2"></div>
							                </div>

							                <div class="col-md-2">
								                <label><?= lang('Table_Status') ?></label>
								                <select name="options_status"  class="form-control">
									                <?php
									                foreach ($List_status AS $key => $value)
									                {
										                echo '<option value="'.$key.'">'.$value.'</option>';
									                }
									                ?>
								                </select>
								                <div class="d-md-none mb-2"></div>
							                </div>

							                <div class="col-md-2">
								                <label><?= lang('options_status') ?></label>
								                <select name="options_status_system"  class="form-control">
									                <?php
									                foreach ($options_status AS $key => $value)
									                {
										                echo '<option value="'.$key.'">'.$value.'</option>';
									                }
									                ?>
								                </select>
								                <div class="d-md-none mb-2"></div>
							                </div>

							                <div class="col-md-2">
								                <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
									                <i class="la la-trash-o"></i>??????
								                </a>
							                </div>
						                </div>
					                </div>
				                </div>
				                <div class="form-group row">
					                <label class="col-lg-2 col-form-label text-right"></label>
					                <div class="col-lg-4">
						                <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary"><i class="la la-plus"></i> ?????????? ????????????</a>
					                </div>
				                </div>
			                </div>
		                </div>
	                </div><!--<div class="card card-custom">-->


                    <div class="card card-custom  mt-10">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
                                </div>
                                <div class="col-lg-6 text-lg-right">
                                    <button type="reset" class="btn btn-danger"><?= lang('cancel_button') ?></button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>


            </div>
        </div>

    </div>
    <!--end::Container-->




</div>
<!--end::Entry-->

<script type="text/javascript">





    $('.selectpicker').selectpicker({   noneSelectedText : '<?= lang('Select_noneSelectedText'); ?>' });

    $('#kt_repeater').repeater({
        initEmpty: false,
        defaultValues: {
            'text-input': 'foo',
        },
        show: function () {
            $(this).slideDown();
	        // $(this).find('.options_list').next('select').remove();
	        $('select.options_list').selectpicker('refresh');
        },
        hide: function (deleteElement) {
	        if(confirm('???? ?????? ?????????? ???? ?????????? ?????? ???????????? ??')) {
		        $(this).slideUp(deleteElement);
	        }
        },
        isFirstItemUndeletable: true

    });



    $('.options_list').click(function(){
	    $('select .options_list').selectpicker('refresh');
    });


	//
    // $(document).on('turbolinks:load', function() {
	//     $(this).trigger('load.bs.select.data-api');
    // });


    $('#Table_primary').change(function(event){
	    event.preventDefault();
	    var table_data   = $('select[name=Table_primary]').val();
	    $.ajax({
		    type: 'ajax',
		    method: 'get',
		    async: false,
		    dataType: 'json',
		    url: '<?= base_url( ADMIN_NAMESPACE_URL.'/List_Data/Ajax_fields_Table_Database') ?>',
		    data: {
			    table_data:table_data
		    },
		    success: function (data) {
			    $("#Table_primary_fields").empty();
			    $.each(data, function (key, value) {
				    $("#Table_primary_fields").append('<option value=' + value.id + '>' + value.Name + '</option>');
			    });
			    $("#Table_primary_fields").selectpicker('refresh');
		    },
		    error: function () {
			    swal.fire(" ?????? ", "???? ?????????? ?????????? ", "error");
		    }
	    });
    });

    $('#Table_Join').change(function(event){
	    event.preventDefault();
	    var table_data   = $('select[name=Table_Join]').val();
	    $.ajax({
		    type: 'ajax',
		    method: 'get',
		    async: false,
		    dataType: 'json',
		    url: '<?= base_url( ADMIN_NAMESPACE_URL.'/List_Data/Ajax_fields_Table_Database') ?>',
		    data: {
			    table_data:table_data
		    },
		    success: function (data) {
			    $("#Table_Join_fields").empty();
			    $.each(data, function (key, value) {
				    $("#Table_Join_fields").append('<option value=' + value.id + '>' + value.Name + '</option>');
			    });
			    $("#Table_Join_fields").selectpicker('refresh');
		    },
		    error: function () {
			    swal.fire(" ?????? ", "???? ?????????? ?????????? ", "error");
		    }
	    });
    });




</script>


