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
	        <a href="<?= base_url(APP_NAMESPACE_URL . '/Transactions/Dashboard_Preview_Property/'.$Transactions->uuid.'/'.$Coordination->Coordination_uuid) ?>" class="btn btn-success">
		        <i class="flaticon2-arrow"></i>   العودة الى لوحة المعاين
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

        <form class="form" id="Form_Create_Transaction" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Create_Map_Preview_Property/'.$Transactions->uuid.'/'.$Coordination->Coordination_uuid) ?>" enctype="multipart/form-data" method="post">
	        <?= CSFT_Form() ?>
	        <input type="hidden" name="Form_id" value="15">
	        <input type="hidden" name="Transaction_id" value="<?= $Transactions->transaction_id ?>">




<!--				        <div class="col-lg-3 mt-5">-->
<!--					        <label> زوم الخريطة </label>-->
<!--					        <select name="zoom_map" onchange="Get_Map(this);" id="zoom_map" class="form-control selectpicker" data-size="5" data-live-search="true"  data-title="اختر من فضلك ">-->
<!--						        --><?php
//						        for($i=10;$i<22;$i++)
//						        {
//							      echo '<option value="'.$i.'">'.$i.'</option>';
//						        }
//						        ?>
<!--					        </select>-->
<!--				        </div>-->
<!--				        <div class="col-lg-3 mt-5">-->
<!--					        <label> زوم الستالايت </label>-->
<!--					        <select name="satellite_zoom" onchange="Get_Map(this);" id="satellite_zoom" class="form-control selectpicker" data-size="5" data-live-search="true"  data-title="اختر من فضلك ">-->
<!--						        --><?php
//						        for($i=10;$i<22;$i++)
//						        {
//							        echo '<option value="'.$i.'">'.$i.'</option>';
//						        }
//						        ?>
<!--					        </select>-->
<!--				        </div>-->
<!--				        <div class="col-lg-3 mt-5">-->
<!--					        <label> زوم التقريب </label>-->
<!--					        <select name="location_overview_zoom" onchange="Get_Map(this);" id="location_overview_zoom" class="form-control selectpicker" data-size="5" data-live-search="true"  data-title="اختر من فضلك ">-->
<!--						        --><?php
//						        for($i=10;$i<22;$i++)
//						        {
//							        echo '<option value="'.$i.'">'.$i.'</option>';
//						        }
//						        ?>
<!--					        </select>-->
<!--				        </div>-->



            <?php echo  $this->session->flashdata('message'); ?>

            <?php
            $LIST_CLIENT                    = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CLIENT');
            $CUSTOMER_CATEGORY              = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CUSTOMER_CATEGORY');
            $TYPE_OF_PROPERTY               = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPE_OF_PROPERTY');
            $TYPES_OF_REAL_ESTATE_APPRAISAL = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');

            $Form_Components  = Get_View_Components_Customs(15,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL);

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

                        </div>
                    </div>
                    <!--begin::Header-->

                    <!--begin::Body-->
                    <div class="card-body">


	                    <?php
	                    if($RC->components_key == 'MAP'){
                          echo '<div id="gmap" style="height:300px;"></div>';
	                    }
	                    ?>


                        <div class="form-group row">
                            <?php
                            $Get_Fields_Components = Building_Fields_Components_Forms($RC->Forms_id, $RC->components_id,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL,'All');

                            foreach ($Get_Fields_Components as $GFC)
                            {

                                if($GFC['Fields_Type_Components'] == 'Fields'){

                                    $Where_Get_Fields = array("Fields_id" => $GFC['Fields_id']);
                                    $Get_Fields       = Get_Fields($Where_Get_Fields)->row();
                                    ?>

                                    <div class="col-lg-3 mt-5">
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
		                                        '',
		                                        '');

                                        ?>
                                    </div>

                                    <?php

                                }elseif($GFC['Fields_Type_Components'] == 'List'){
                                    ?>

                                    <div class="col-lg-3 mt-5">
                                        <?php
                                        $class_List      = array( 0 => "selectpicker");
                                        Building_List_Forms($RC->Forms_id,
                                            $RC->components_id,
                                            $GFC['Fields_id'],
                                            $multiple = '',
                                            $selected='',
                                            $style='',
                                            $id='',
                                            $class = array( 0=> "selectpicker"),
                                            $disabled='',
                                            $label='',
                                            $js='');
                                        ?>
                                    </div>
                                    <?php
                                }

                            } // foreach
                            ?>
                        </div><!-- <div class="form-group row"> -->
                    </div>
                    <!--begin::Body-->


                </div><!--<div class="card card-custom mt-10">-->
                <?php
            }
            ?>




            <?php
            $where_Stages_Assignment = array(
                "stages_key" => 'COORDINATION_AND_QUALITY',
                "company_id" => $this->aauth->get_user()->company_id
            );
            $Get_Stages_Transaction = Assignment_Transaction_Departments_To($where_Stages_Assignment);

            if($Get_Stages_Transaction == false) {

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'لا يوجد ضبط صحيح لاسناد المعاملة ';
                $msg_result_view = Create_Status_Alert($msg_result);
                echo '<br>';
                echo $msg_result_view;

            }else{

                $Assignment_Type_where = array(
                    'stages_key' => 'COORDINATION_AND_QUALITY',
                    'company_id' => $this->aauth->get_user()->company_id
                );
                $Assignment_Type = Get_Stages_Transaction_Company($Assignment_Type_where)->row();

                if($Assignment_Type->attribution_method == 1){
                    echo '<input type="hidden" name="Assignment_userid" value="'.$Get_Stages_Transaction['userid'].'">';
                }elseif($Assignment_Type->attribution_method == 2){
                    ?>
                    <div class="card card-custom mb-5 mt-5">
                        <!--begin::Header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">تحويل الطلب الى </h3>
                            </div>
                        </div>
                        <!--begin::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <select name="Assignment_userid" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
                                <?php
                                $t = 'عدد المعاملات الحالية :';
                                foreach ($Get_Stages_Transaction AS $key_user)
                                {
                                    echo '<option  data-subtext="  '.$t.$key_user['Assignment_Num'].'" value="'.$key_user['userid'].'">'.$key_user['full_name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <!--begin::Body-->
                    </div>
                    <?php
                } // if($Assignment_Type->attribution_method == 1)
                ?>


                <div class="card card-custom mt-10">
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="submit"   class="btn btn-primary mr-2"> حفظ البيانات  </button>
                            </div>
                            <div class="col-lg-6 text-lg-right">
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
            ?>



        </form>

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

<script src="//maps.google.com/maps/api/js?key=AIzaSyBMkLi0BxMHoFVI2CKxGHdduypMeA1I6wk&sensor=false&libraries="></script>
<?php
echo import_js(BASE_ASSET.'plugins/custom/gmaps/gmaps','');
?>
<script type="text/javascript">


	        //var satellite_zoom          =  $('select[name=satellite_zoom]').val();
	        //var location_overview_zoom  =  $('select[name=location_overview_zoom]').val();

	        var map = new GMaps({
		        div: '#gmap',
		        lat: 23.7112692,
		        lng: 44.4579123,

	        });

	        GMaps.geolocate({
		        success: function(position) {

			        map.setCenter(position.coords.latitude, position.coords.longitude);

			        var zoom_map = 15;

			        map.addMarker({
				        lat: position.coords.latitude,
				        lng: position.coords.longitude,
				        zoom: zoom_map,
				        mapTypeId: "satellite",
				        draggable: true,
				        dragend: function(event) {
					        var lat = event.latLng.lat();
					        var lng = event.latLng.lng();
					        $("#LATITUDE").val(lat);
					        $("#LONGITUDE").val(lng);
				        },
				        title: 'الموقع الحالي',
				        infoWindow: {
					        content: '<span style="color:#000">الموقع الحالي </span>'
				        }
			        });



			        $("#LATITUDE").val(position.coords.latitude);
			        $("#LONGITUDE").val(position.coords.longitude);

		        },
		        error: function(error) {
			        swal.fire("خطا ", "لا يمكن العثور على الموقع الجغرافي ", "error");
		        },
		        not_supported: function() {
			        swal.fire("خطا ", "المتصفح لا يدعم الموقع الجغرافي ", "error");
		        },
		        always: function() {

		        }
	        });
</script>
