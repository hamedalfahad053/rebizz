<div class="modal fade" id="Modal_Form_Comparisons" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافة عرض مقارنة </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>

            <form id="Form_Comparisons"  action="#">

                <input type="hidden" name="Transaction_id"  value="<?= $Transactions->transaction_id ?>">
	            <input type="hidden" name="Coordination_id" value="<?= $Coordination->Coordination_id ?>">

                <div class="modal-body">


	                <style type="text/css">
		                #map_container_Comparisons {
			                width:100%;
			                height:300px;
			                overflow:hidden;
		                }

		                /* ensures that the content fills its parent when shown again */
		                #map_container_Comparisons {
			                height: 100% !important;
			                width: 100% !important;
		                }
	                </style>


	                <div id="map_container_Comparisons" class="mt-10 mb-10">
		                <div id="map_content_Comparisons"></div>
	                </div>


	                <div class="form-group row">
		                <div class="col-lg-4 mt-5">
			                <label>زوم الخريطة</label>
			                <select id="geo-zoom_Comparisons" name="geo-zoom_Comparisons" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
				                <?php
				                for($i=0;$i<20;$i++)
				                {
					                echo '<option value="'.$i.'">'.$i.'</option>';
				                }
				                ?>
			                </select>
		                </div>
		                <div class="col-lg-4 mt-5">
			                <label>خط العرض</label>
			                <input type="text" name="LATITUDE_Comparisons" value="" id="LATITUDE_Comparisons" maxlength="" style="" class=" form-control ">
		                </div>
		                <div class="col-lg-4 mt-5">
			                <label>خط الطول</label>
			                <input type="text" name="LONGITUDE_Comparisons" value="" id="LONGITUDE_Comparisons" maxlength="" style="" class=" form-control ">
		                </div>
	                </div>


	                <div class="form-group row">
		                <label>الفئة</label>
		                <select name="Comparisons_type" id="Comparisons_type" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
						    <option value="Land">ارض</option>
			                <option value="Building">مبنى</option>
		                </select>
	                </div>




                    <div class="form-group row">

                        <div class="col-lg-4">
                            <label>نوع العقار</label>
	                        <select name="property_types_id" id="property_types_id" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
		                        <?php
		                        $Get_Property_Types = Get_Property_Types(array("Property_Types_status"=>1));
		                        foreach ($Get_Property_Types->result() as $roP){
		                        ?>
		                        <option value="<?= $roP->Property_Types_id ?>"><?= $roP->item_translation ?></option>
		                        <?php
		                        }
		                        ?>
	                        </select>
                        </div>


                        <div class="col-lg-4">
                            <label>مساحة الأرض</label>
                            <input type="text" name="Land_area" id="Land_area" class="form-control"  placeholder="مساحة الأرض"/>
                        </div>
                        <div class="col-lg-4">
                            <label>سعر المتر المربع</label>
                            <input type="text" name="Price_per_square_meter_Comparisons" id="Price_per_square_meter" class="form-control"  placeholder="سعر المتر المربع"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>إجمالي قيمة العقار</label>
                            <input type="text" name="total_value_property" id="total_value_property" class="form-control"  placeholder="إجمالي قيمة العقار"/>
                        </div>
                        <div class="col-lg-4">
                            <label>المكتب</label>
                            <input type="text" name="office" id="office" class="form-control"  placeholder="المكتب"/>
                        </div>
                        <div class="col-lg-4">
                            <label>رقم الهاتف</label>
                            <input type="text" name="office_tel" id="office_tel" class="form-control" placeholder="رقم الهاتف"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-12">
                            <button  type="button" id="Form_Comparisons_Submit"  class="btn btn-primary font-weight-bold">حفظ</button>
                            <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">الغاء الامر</button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>


<script type="text/javascript">
	$('#Land_area,#Price_per_square_meter').keyup(function() {
		var Land_area  = $('#Land_area').val();
		var Price_per_square_meter  = $('#Price_per_square_meter').val();
		$('#total_value_property').val(Land_area * Price_per_square_meter);
	});
	/*************************** START MAP ****************************************/


	//google.maps.event.trigger(map, 'resize');


	var map_Comparisons = new GMaps({ div: '#map_content_Comparisons' , lat: 23.7112692 , lng: 44.4579123 });

	GMaps.geolocate({
		success: function(position) {
			map_Comparisons.setCenter(position.coords.latitude, position.coords.longitude);

			$("#LATITUDE_Comparisons").val(position.coords.latitude);
			$("#LONGITUDE_Comparisons").val(position.coords.longitude);

			map_Comparisons.addMarker({
				lat: position.coords.latitude,
				lng: position.coords.longitude,
				zoom: 14,
				draggable: true,
				streetViewControl:false,
				dragend: function(event) {

					var lat = event.latLng.lat();
					var lng = event.latLng.lng();

					$("#LATITUDE_Comparisons").val(lat);
					$("#LONGITUDE_Comparisons").val(lng);

					map_Comparisons.setCenter(lat,lng);
					map_Comparisons.refresh();
				},
				title: 'الموقع الحالي',
				infoWindow: {
					content: '<span  data-container="body" data-offset="20px 20px" data-toggle="popover" data-placement="top" data-content="الموقع الحالي">  </span>'
				}
			});

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

	$('#geo-zoom_Comparisons').change(function(){
		var ToZoom_Comparisons = parseInt($("#geo-zoom_Comparisons").find(":selected").text());
		map_Comparisons.setZoom(ToZoom_Comparisons);
	});

	$('#LATITUDE_Comparisons,#LONGITUDE_Comparisons').blur(function() {

		var LATITUDE_Comparisons  = $("#LATITUDE_Comparisons").val();
		var LONGITUDE_Comparisons = $("#LONGITUDE_Comparisons").val();

		if(LATITUDE_Comparisons.length > 3  || LONGITUDE_Comparisons.length > 3  ){

			map_Comparisons.removeMarkers();

			map_Comparisons.addMarker({
				lat: LATITUDE_Comparisons,
				lng: LONGITUDE_Comparisons,
				zoom: 14,
				draggable: true,
				streetViewControl:false,
				dragend: function(event) {

					var lat_Comparisons = event.latLng.lat();
					var lng_Comparisons = event.latLng.lng();

					$("#LATITUDE_Comparisons").val(lat_Comparisons);
					$("#LONGITUDE_Comparisons").val(lng_Comparisons);

					map_Comparisons.setCenter(lat_Comparisons,lng_Comparisons);
					map_Comparisons.refresh();
				},
				title: 'الموقع الحالي',
				infoWindow: {
					content: '<span  data-container="body" data-offset="20px 20px" data-toggle="popover" data-placement="top" data-content="الموقع الحالي">  </span>'
				}
			});

			map_Comparisons.setCenter(LATITUDE_Comparisons,LONGITUDE_Comparisons);
			map_Comparisons.refresh();
		}

	});
	/*************************** END MAP ****************************************/

	// ------------------------------------------------------------------------------- //
	// Form Add Land Comparisons
	$('#Form_Comparisons').on('click', '#Form_Comparisons_Submit', function (event) {
		event.preventDefault();

		var Transactions_id         = <?= $Transactions->transaction_id ?>;
		var Coordination_id         = <?= $Coordination->Coordination_id ?>;
		var Comparisons_type        = $('select[name=Comparisons_type]').val();
		var property_types_id       = $('select[name=property_types_id]').val();
		var Land_area               = $('input[name=Land_area]').val();
		var Price_per_square_meter  = $('input[name=Price_per_square_meter]').val();
		var total_value_property    = $('input[name=total_value_property]').val();
		var office                  = $('input[name=office]').val();
		var office_tel              = $('input[name=office_tel]').val();

		$.ajax({
			type: 'ajax',
			method: 'get',
			url: '<?= base_url(APP_NAMESPACE_URL . '/Transactions/Create_Ajax_Comparisons_Comparisons') ?>',
			data: {
				Transactions_id: Transactions_id,Coordination_id:Coordination_id,Comparisons_type:Comparisons_type,
				Land_area:Land_area,Price_per_square_meter:Price_per_square_meter,property_types_id:property_types_id,
				total_value_property:total_value_property,office:office,office_tel:office_tel
			},
			async: false,
			dataType: 'json',
			success: function (response) {
				if (response.Type_result == 'success') {
					swal.fire("نجاح",response.Message_result, "success");
					Get_Ajax_Data_Table_Land_Comparisons();
				} else {
					swal.fire(" خطا ", response.Message_result, "error");
					Get_Ajax_Data_Table_Land_Comparisons();
				}
				$('#Modal_Form_Comparisons').modal('hide');
			},
			error: function () {
				swal.fire(" خطا ", "في ارسال الطلب ", "error");
				$('#Modal_Form_Comparisons').modal('hide');
			}
		});
	});
	// ------------------------------------------------------------------------------- //
</script>


