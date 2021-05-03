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
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label"><?= $Page_Title ?></h3>
                </div>
                <div class="card-toolbar">
                    <?php
                    echo Create_One_Button_Text_Without_tooltip(
                        array('id'=>'',
                            'class'=>'',
                            'title' => 'اضافة قسم',
                            'data_attribute' => '',
                            'href' => base_url(APP_NAMESPACE_URL.'/Forms/Add_Components_Forms_Transaction/'.$Forms->Forms_uuid))
                    );
                    ?>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body">
                <?php echo  $this->session->flashdata('message'); ?>
            </div>
            <!--end: Card Body-->
        </div>
        <!--end: Card-->



        <?php
        foreach ($Form_Components->result() AS $RC)
        {
        ?>
        <div class="card card-custom mt-10">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        <?= $RC->item_translation ?>
                    </h3>
                </div>
                <div class="card-toolbar">

	                <?php
	                echo 'فئة العميل : ';
	                if($RC->With_Type_CUSTOMER == 'All'){
		                echo Create_Status_badge(array("key"=>"Success","value"=>lang('All_Components_Filed')));
	                }else{
		                $array_Type_CUSTOMER           = explode(",",$RC->With_Type_CUSTOMER);
		                foreach ($array_Type_CUSTOMER AS $key_WTC)
		                {
			                echo Create_Status_badge(array("key"=>"warning","value"=>Get_options_List_Translation($key_WTC)->item_translation));
		                }
	                }
	                ?>

	                <?php
	                echo ' فئة العقار :';

	                if($RC->With_Type_Property == 'All'){
		                echo Create_Status_badge(array("key"=>"Success","value"=>lang('All_Components_Filed')));
	                }else{
		                $array_Type_Property       = explode(",",$RC->With_Type_Property);
		                foreach ($array_Type_Property AS $key_TP)
		                {
			                echo Create_Status_badge(array("key"=>"warning","value"=> Get_Property_Types(array("Property_Types_id"=>$key_TP))->row()->item_translation));
		                }
	                }
	                ?>

	                <?php
	                echo 'فئة الطلب :';
	                if($RC->With_TYPES_APPRAISAL == 'All'){
		                echo Create_Status_badge(array("key"=>"Success","value"=> lang('All_Components_Filed')));
	                }else{
		                $array_TYPES_APPRAISAL       = explode(",",$RC->With_TYPES_APPRAISAL);
		                foreach ($array_TYPES_APPRAISAL AS $key_WTA)
		                {
			                echo Create_Status_badge(array("key"=>"warning","value"=> Get_options_List_Translation($key_WTA)->item_translation));
		                }
	                }
	                ?>

	                <?php
	                echo 'طريقة التقييم : ';
	                if($RC->With_Type_evaluation_methods == 'All'){
		                echo Create_Status_badge(array("key"=>"Success","value"=> lang('All_Components_Filed')));
	                }else{
		                $array_Type_evaluation_methods       = explode(",",$RC->With_Type_evaluation_methods);
		                foreach ($array_Type_evaluation_methods AS $key_TEM)
		                {
			                echo Create_Status_badge(array("key"=>"Success","value"=> Get_Evaluation_Methods(array("evaluation_methods_id"=>$key_TEM))->row()->item_translation));
		                }
	                }
	                ?>


                    <?php
                    echo Create_One_Button_Text_Without_tooltip(
                        array('id'=>'',
                            'class'=>'',
                            'title' => 'اضافة حقل',
                            'data_attribute' => '',
                            'href' => base_url(APP_NAMESPACE_URL.'/Forms/Add_Fields_Components/'.$Forms->Forms_uuid.'/'.$RC->components_uuid))
                    );

                    echo Create_One_Button_Text_Without_tooltip(
                        array('id' => '',
                            'class' => '',
                            'title' => 'اضافة قائمة',
                            'data_attribute' => '',
                            'href' => base_url(APP_NAMESPACE_URL . '/Forms/Add_List_Components/' . $Forms->Forms_uuid . '/' . $RC->components_uuid))
                    );

                    $options_Components['custom'] = array(
                        "title"          => 'ترتيب الحقول',
                        "data-attribute" => "",
                        "class"          => "",
                        "id"             => "",
                        "color"          => "info",
                        "icon"           => "flaticon2-sort",
                        "href"           => base_url(APP_NAMESPACE_URL.'/Forms/Sort_Fields_Components_Form/'.$Forms->Forms_uuid.'/'.$RC->components_uuid)
                    );
                    echo $Button_Components  = Create_Options_Button($options_Components);

                    ?>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body">

                <style>th.dt-center,.dt-center { text-align: center; }</style>
                <table class="data_table table table-bordered table-hover display nowrap" width="100%">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">اسم الحقل</th>
                        <th class="text-center">خاصية الحقل</th>
                        <th class="text-center">تخصيص فئة العميل</th>
                        <th class="text-center">تخصيص فئة العقار</th>
                        <th class="text-center">تخصيص  فئة الطلب</th>
                        <th class="text-center">تخصيص   طريقة التقييم</th>
                        <th class="text-center">تخصيص  العميل</th>
                        <th class="text-center">الحالة</th>
                        <th class="text-center">الخيارات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $Get_Fields_Components = Get_Fields_Components($RC->Forms_id,$RC->components_id);
                    foreach ($Get_Fields_Components AS $GFC)
                    {
                        ?>
                        <tr>
                            <td class="text-center"><?= $GFC['Fields_id_Components'] ?></td>
                            <td class="text-center"><?= $GFC['Fields_Title'] ?></td>
                            <td class="text-center">

                                <?php
                                if($GFC['Fields_Type']       == 'Field') {
                                    $Forms_Fields_Type =  Create_Status_badge(array("key"=>"warning","value"=>'حقل '));
                                }elseif($GFC['Fields_Type']  == 'Select') {
                                    $Forms_Fields_Type =  Create_Status_badge(array("key"=>"Danger","value"=>'قائمة'));
                                }
                                echo $Forms_Fields_Type;
                                ?>

                            </td>
                            <td class="text-center">
                                <?php
                                if(is_array($GFC['Fields_With_Type_CUSTOMER'])){
                                    foreach ($GFC['Fields_With_Type_CUSTOMER'] AS $FWTC)
                                    {
                                        echo Create_Status_badge(array("key"=>"warning","value"=>$FWTC));
                                    }
                                }else{
                                    echo Create_Status_badge(array("key"=>"Success","value"=>$GFC['Fields_With_Type_CUSTOMER']));
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <?php
                                if(is_array($GFC['Fields_With_Type_Property'])){
                                    foreach ($GFC['Fields_With_Type_Property'] AS $WTP)
                                    {
                                        echo Create_Status_badge(array("key"=>"warning","value"=>$WTP));
                                    }
                                }else{
                                    echo Create_Status_badge(array("key"=>"Success","value"=>$GFC['Fields_With_Type_Property']));
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <?php
                                if(is_array($GFC['Fields_With_TYPES_APPRAISAL'])){
                                    foreach ($GFC['Fields_With_TYPES_APPRAISAL'] AS $WTA)
                                    {
                                        echo Create_Status_badge(array("key"=>"warning","value"=>$WTA));
                                    }
                                }else{
                                    echo Create_Status_badge(array("key"=>"Success","value"=>$GFC['Fields_With_TYPES_APPRAISAL']));

                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <?php
                                if(is_array($GFC['Fields_With_Type_evaluation_methods'])){
                                    foreach ($GFC['Fields_With_Type_evaluation_methods'] AS $WTAM)
                                    {
                                        echo Create_Status_badge(array("key"=>"warning","value"=>$WTAM));
                                    }
                                }else{
                                    echo Create_Status_badge(array("key"=>"Success","value"=>$GFC['Fields_With_Type_evaluation_methods']));
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <?php
                                if(is_array($GFC['Fields_With_Type_evaluation_methods'])){
                                    foreach ($GFC['Fields_With_Type_evaluation_methods'] AS $WTAM)
                                    {
                                        echo Create_Status_badge(array("key"=>"warning","value"=>$WTAM));
                                    }
                                }else{
                                    echo Create_Status_badge(array("key"=>"Success","value"=>$GFC['Fields_With_Type_evaluation_methods']));
                                }
                                ?>
                            </td>
                            <td class="text-center">

                            </td>
                            <td class="text-center">
                                <?php

                                if($GFC['status_is_system'] != 1)
                                {

                                    $options['edit'] = array(
                                        "class"          => '',
                                        "id"             => '',
                                        "title"          => 'تعديل ',
                                        "data-attribute" => '',
                                        "href"           => base_url(APP_NAMESPACE_URL.'/Forms/Validating_Fields/'.$Forms->Forms_uuid.'/'.$RC->components_id.'/'.$GFC['Fields_id_Components'])
                                    );

                                    $options['active'] = array(
                                        "class"          => '',
                                        "id"             => '',
                                        "title"          => 'تفعيل ',
                                        "data-attribute" => '',
                                        "href"           => base_url(APP_NAMESPACE_URL.'/Forms/Validating_Fields/'.$Forms->Forms_uuid.'/'.$RC->components_id.'/'.$GFC['Fields_id_Components'])
                                    );

                                    $options['disable'] = array(
                                        "class"          => '',
                                        "id"             => '',
                                        "title"          => 'تعطيل ',
                                        "data-attribute" => '',
                                        "href"           => base_url(APP_NAMESPACE_URL.'/Forms/Validating_Fields/'.$Forms->Forms_uuid.'/'.$RC->components_id.'/'.$GFC['Fields_id_Components'])
                                    );
                                }


//                                $options['custom'] = array(
//                                    "class"          => '',
//                                    "id"             => '',
//                                    "title"          => 'شروط الحقل',
//                                    "icon"           => 'flaticon2-settings',
//                                    "color"          => 'danger',
//                                    "data-attribute" => '',
//                                    "href"           => base_url(APP_NAMESPACE_URL.'/Forms/Validating_Fields/'.$Forms->Forms_uuid.'/'.$RC->components_id.'/'.$GFC['Fields_id_Components'])
//                                );
//                                echo Create_Options_Button($options);


                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <!--begin: Datatable -->


            </div>
            <!--end: Card Body-->
        </div>
        <!--end: Card-->
        <?php
        }
        ?>

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->




<script type="text/javascript">
    $(document).ready(function() {
        $('.data_table').DataTable({
            responsive: true
        });
    });
</script>
