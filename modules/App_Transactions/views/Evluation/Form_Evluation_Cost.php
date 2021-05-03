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


<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">

        <form class="form" id="Form_Create_Transaction" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Update_Data_Transactions') ?>" enctype="multipart/form-data" method="post">
        <?= CSFT_Form() ?>

            <?php
            $LIST_CLIENT                    = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CLIENT');
            $CUSTOMER_CATEGORY              = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CUSTOMER_CATEGORY');
            $TYPE_OF_PROPERTY               = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPE_OF_PROPERTY');
            $TYPES_OF_REAL_ESTATE_APPRAISAL = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');

            $Form_Components  = Get_View_Components_Customs(17,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL);

            foreach ($Form_Components->result() AS $RC)
            {
                ?>
                <h3 class="font-size-h5 font-weight-boldest"><?= $RC->item_translation ?></h3>
                <div class="separator separator-dashed separator-border-1 separator-primary"></div>
                <div class="form-group row">
                    <?php
                    $Get_Fields_Components = Building_Fields_Components_Forms($RC->Forms_id, $RC->components_id,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL,'All');

                    foreach ($Get_Fields_Components as $GFC)
                    {

                        if($GFC['Fields_key'] !='CONSUMPTION_RATIO'  and  $GFC['Fields_key'] !='PROFIT_RATIO' and $GFC['Fields_key'] != 'ESTIMATED_COSTS' and $GFC['Fields_key'] != 'MARKET_VALUE'){

                            if($GFC['Fields_Type_Components'] == 'Fields'){
                                $Where_Get_Fields = array("Fields_id" => $GFC['Fields_id']);
                                $Get_Fields       = Get_Fields($Where_Get_Fields)->row();
                                ?>
                                <div class="col-sm-4  col-lg-4  mt-5">
                                    <?php
                                    echo Building_Field_Forms($Get_Fields->Fields_key,
                                        true,
                                        $Get_Fields->Fields_key.'-'.$RC->Forms_id.'-'.$RC->components_id,
                                        '',
                                        $Get_Fields->Fields_key,
                                        '',
                                        '',
                                        '',
                                        '',
                                        array("data-calculations"=>"true",  "min"=> 0, "value" => 0,"step"=> 0.0 ),
                                        '');

                                    ?>
                                </div>
                                <?php
                            } // if($GFC['Fields_Type_Components'] == 'Fields')

                        } // if(){ Fields ignor

                    } // foreach


                    ?>
                </div><!-- <div class="form-group row"> -->
                <?php
            }

            $this->load->view('../../modules/App_Transactions/views/Template/Template_Total_Evluation_Preview_Property');
            ?>



        </form>

    </div>
</div>


<script type="text/javascript">

    var Total_Land     = 0;
    var Total_Building = 0;

    <?php
    $where_Get_Calculations = array(
        "Form_loc" => "Preview_Property_FORM",
    );

    $Get_Calculations = Get_Calculations($where_Get_Calculations);
    foreach ($Get_Calculations->result() AS $R_GC)
    {

    if($R_GC->Type_Value == 'Building'){
    ?>
        $('#<?= $R_GC->Field_C_key ?>').attr("data-type","Building").prop("readonly",true).addClass("form-control-solid");
    <?php
    }
    if($R_GC->Type_Value == 'Land'){
    ?>
        $('#<?= $R_GC->Field_C_key ?>').attr("data-type","Land").prop("readonly",true).addClass("form-control-solid");
    <?php
    }
    ?>

	    $('#<?= $R_GC->Field_A_key ?>,#<?= $R_GC->Field_B_key ?>').keyup(function() {
	        var <?= $R_GC->Field_A_key ?>  = $('#<?= $R_GC->Field_A_key ?>').val();
	        var <?= $R_GC->Field_B_key ?>  = $('#<?= $R_GC->Field_B_key ?>').val();
	        $('#<?= $R_GC->Field_C_key ?>').val(<?= $R_GC->Field_A_key ?> * <?= $R_GC->Field_B_key ?>);
	    });

    <?php
    }
    ?>

    var PROFIT_RATIO      = 0;
    var CONSUMPTION_RATIO = 0;
    var CONSUMPTION_Building = 0;
    var ESTIMATED_COSTS = 0;
    var PROFIT_Total = 0 ;

    $(document).on("keyup","input[data-calculations=true]",function(){
        Total_Land = 0;
        Total_Building = 0;

        $('input[data-type="Building"]').each(function(){
            Total_Building += parseFloat($(this).val()) || 0;
        });

        $('input[data-type="Land"]').each(function(){
            Total_Land += parseFloat($(this).val()) || 0;
        });

        CONSUMPTION_RATIO = parseFloat($('#CONSUMPTION_RATIO').val()) || 0;
        if(CONSUMPTION_RATIO !== null  &&  CONSUMPTION_RATIO !== undefined && CONSUMPTION_RATIO !== '' ){
            if(CONSUMPTION_RATIO !== 0) {
                CONSUMPTION_Building = parseFloat((CONSUMPTION_RATIO / 100) * Total_Building);
            }
            else{
                CONSUMPTION_Building = 0;
            }
        }
        ESTIMATED_COSTS = parseFloat((Total_Building - CONSUMPTION_Building)  + Total_Land);
        $('#ESTIMATED_COSTS').val(ESTIMATED_COSTS);



        PROFIT_RATIO = parseFloat($('#PROFIT_RATIO').val()) || 0;
        if(PROFIT_RATIO !== null  &&  PROFIT_RATIO !== undefined && PROFIT_RATIO !== '' ){
            if(PROFIT_RATIO !== 0) {
                PROFIT_Total = parseFloat((PROFIT_RATIO / 100) * (ESTIMATED_COSTS));
            }
            else{
                PROFIT_Total = 0;
            }
        }

        // Value Table input
        $('#Total_Land').val(Total_Land);
        $('#Total_Building').val(Total_Building);
        $('#CONSUMPTION_Total').val(CONSUMPTION_Building);
        $('#PROFIT_Total').val(PROFIT_Total);
        var MARKET_VALUE = parseFloat(PROFIT_Total + ESTIMATED_COSTS);
        $('#MARKET_VALUE').val(MARKET_VALUE);
        $('#MARKET_VALUE_Approximate').val(Math.round(MARKET_VALUE));

    });
</script>
