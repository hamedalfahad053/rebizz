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

            <div class="col-lg-12 mt-5">

	            <form class="form" action="<?= base_url(APP_NAMESPACE_URL.'/List/Create_List') ?>" method="post">
		            <?= CSFT_Form() ?>

		           <div class="card card-custom">
		                    <div class="card-header">
		                        <div class="card-title">
		                            <span class="card-icon">
		                                <i class="flaticon-squares text-primary"></i>
		                            </span>
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
		                                </div>
		                    </div>
		                </div>



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
								            <select name="options_status" title="????????"  class="form-control">
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
								            <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger"><i class="la la-trash-o"></i>??????</a>
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


	                     <div class="card card-custom mt-10">
	                         <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="submit" id="buttonCreateSections" class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
                                    </div>
                                    <div class="col-lg-6 text-lg-right">
                                        <button type="reset" class="btn btn-danger"><?= lang('cancel_button') ?></button>
                                    </div>
                                </div>
                            </div>
	                      </div>


	            </form>


            </div><!--<div class="col-lg-12 mt-5">-->



        </div>

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


<script type="text/javascript">
	$('#kt_repeater').repeater({
		initEmpty: false,
		defaultValues: {
			'text-input': 'foo',
		},
		show: function () {
			$(this).slideDown();
		},
		hide: function (deleteElement) {
			if(confirm('???? ?????? ?????????? ???? ?????????? ?????? ???????????? ??')) {
				$(this).slideUp(deleteElement);
			}
		},
		isFirstItemUndeletable: true
	});
</script>