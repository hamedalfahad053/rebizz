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


        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon-squares text-primary"></i>
                    </span>
                    <h3 class="card-label"><?= $Page_Title ?></h3>
                </div>
                <div class="card-toolbar">
                </div>
            </div>


        <?php echo  $this->session->flashdata('message'); ?>

        <form class="form" name="" action="<?= base_url(ADMIN_NAMESPACE_URL.'/Forms/Set_Validating_Fields') ?>" method="post">
            <?= CSFT_Form() ?>
            <div class="card-body">

                <?php echo  $this->session->flashdata('message'); ?>


                <input type="hidden" name="Forms_id" value="<?= $Fields_data_component->Forms_id ?>">
                <input type="hidden" name="Components_id" value="<?= $Fields_data_component->Components_id ?>">
                <input type="hidden" name="Fields_id" value="<?= $Fields_data_component->Fields_id ?>">

                <?php

                $checkbox_trim              = '';
                $checkbox_required          = '';
                $checkbox_min_length        = '';
                $checkbox_min_length_value  = '';
                $checkbox_max_length        = '';
                $checkbox_max_length_value  = '';
                $checkbox_valid_email       = '';
                $checkbox_numeric           = '';
                $checkbox_integer           = '';
                $checkbox_is_natural        = '';
                $checkbox_natural_no_zero   = '';

                $validating_Fields_where_extra = array(
                		"Forms_id"      => $Fields_data_component->Forms_id,
		                "Components_id" => $Fields_data_component->Components_id,
		                "Fields_id"     => $Fields_data_component->Fields_id,
		                "company_id"    => 0
                );

                $Get_validating_Fields = Get_validating_Fields($validating_Fields_where_extra);

                if($Get_validating_Fields->num_rows()>0){

	                $Get_validating_Fields  = $Get_validating_Fields->row();
                	$validating_rules       = explode("|",$Get_validating_Fields->validating_rules);

                	foreach ($validating_rules AS $key)
	                {
	                	if($key=='trim'){
			                $checkbox_trim      = 'checked="checked"';
		                }
	                	if($key=='required'){
			                $checkbox_required  = 'checked="checked';
		                }

	                }

                }

                $Type_Fields_html_view = '';

                $Type_Fields_html_view .= validating_Fields_trim($checkbox_trim);
                $Type_Fields_html_view .= validating_Fields_required($checkbox_required);

                if($Fields_data_component->Fields_Type == 'Fields'){

                    if($Fields_data->Fields_Type_Fields == 'text')
                    {
                        $Type_Fields_html_view .= validating_Fields_min_length();
                        $Type_Fields_html_view .= validating_Fields_max_length();
                        //$Type_Fields_html_view .= validating_Fields_matches_Fields();
                    }
                    elseif ($Fields_data->Fields_Type_Fields ==  'date')
                    {

                    }
                    elseif ($Fields_data->Fields_Type_Fields ==  'email')
                    {
                        $Type_Fields_html_view .= validating_Fields_valid_email();
                    }
                    elseif ($Fields_data->Fields_Type_Fields ==  'url')
                    {
                        $Type_Fields_html_view .= validating_Fields_valid_url() ;
                    }
                    elseif ($Fields_data->Fields_Type_Fields ==  'number')
                    {
                        $Type_Fields_html_view .= validating_Fields_numeric();
                        $Type_Fields_html_view .= validating_Fields_integer();
                        $Type_Fields_html_view .= validating_Fields_decimal();
                        $Type_Fields_html_view .= validating_Fields_is_natural();
                        $Type_Fields_html_view .= validating_Fields_is_natural_no_zero();
                    }

                }elseif($Fields_data_component->Fields_Type == 'List'){



                }

                echo $Type_Fields_html_view;
                ?>


            </div>

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

        </form>


    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


