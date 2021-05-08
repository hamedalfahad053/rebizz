<div class="row">


    <div class="col-sm-12  col-lg-12  mt-5">

        <div id="map-container" class="mt-10 mb-10"><div id="map-content"></div></div>

        <div class="form-group row">
            <div class="col-sm-6  col-lg-6  mt-5">
                <label>زوم الخريطة</label>
                <select id="geo-zoom" name="geo-zoom" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
                    <?php
                    for($i=0;$i<20;$i++)
                    {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="col-sm-6  col-lg-6  mt-5">
                <label>نوع الخريطة</label>
                <select id="Type_Map" name="Type_Map" class="form-control selectpicker"  data-title="اختر من فضلك ">
                    <option value="roadmap">خريطة الطرق</option>
                    <option value="satellite">الأقمار الصناعية</option>
                    <option value="hybrid">هجين</option>
                    <option value="terrain">تضاريس</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6  col-lg-6  mt-5">
                <label> خط الطول </label>
                <input type="text" name="LATITUDE-15-37" value="" id="LATITUDE" maxlength="" style="" class=" form-control ">
            </div>
            <div class="col-sm-6  col-lg-6  mt-5">
                <label>خط العرض</label>
                <input type="text" name="LONGITUDE-15-37" value="" id="LONGITUDE" maxlength="" style="" class=" form-control ">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12  col-lg-12  mt-5">
                <button type="button"  id="Get_Place" class="btn btn-primary">
                    <i class="flaticon2-search"></i>  ابحث عن محيط العقار
                </button>
            </div>

        </div>


    </div>


</div>


<script type="text/javascript">
	var map = new GMaps({ div: '#map-content' , lat: 23.7112692 , lng: 44.4579123 });

	GMaps.geolocate({
		success: function(position) {
			map.setCenter(position.coords.latitude, position.coords.longitude);
			$("#LATITUDE").val(position.coords.latitude);
			$("#LONGITUDE").val(position.coords.longitude);

			map.addMarker({
				lat: position.coords.latitude,
				lng: position.coords.longitude,
				zoom: 14,
				draggable: true,
				streetViewControl:true,
				dragend: function(event) {
					var lat = event.latLng.lat();
					var lng = event.latLng.fuuuu();

					$("#LATITUDE").val(lat);
					$("#LONGITUDE").val(lng);

					map.setCenter(lat,lng);
					map.refresh();
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

	$('#geo-zoom').change(function(){
		var ToZoom = parseInt($("#geo-zoom").find(":selected").text());
		map.setZoom(ToZoom);
		map.refresh();
	});


	$('#LATITUDE,#LONGITUDE').blur(function() {

		var LATITUDE  = $("#LATITUDE").val();
		var LONGITUDE = $("#LONGITUDE").val();

		if(LATITUDE.length > 3  || LONGITUDE.length > 3  ){

			map.removeMarkers();

			map.addMarker({
				lat: LATITUDE,
				lng: LONGITUDE,
				zoom: 14,
				draggable: true,
				streetViewControl:false,
				dragend: function(event) {

					var lat = event.latLng.lat();
					var lng = event.latLng.lng();

					$("#LATITUDE").val(lat);
					$("#LONGITUDE").val(lng);

					map.setCenter(lat,lng);
					map.refresh();
				},
				title: 'الموقع الحالي',
				infoWindow: {
					content: '<span  data-container="body" data-offset="20px 20px" data-toggle="popover" data-placement="top" data-content="الموقع الحالي">  </span>'
				}
			});

			map.setCenter(LATITUDE,LONGITUDE);
			map.refresh();
		}

	});


	// ------------------------------------------------------------------------------- //
	$( "#Get_Place" ).click(function(event) {

		event.preventDefault();

		var LATITUDE  = $("#LATITUDE").val();
		var LONGITUDE = $("#LONGITUDE").val();

		$.ajax({
			type: 'ajax',
			method: 'get',
			url: '<?= base_url(APP_NAMESPACE_URL . '/Tools_Map_Ajax/Get_Place') ?>',
			data: { LATITUDE:LATITUDE ,LONGITUDE:LONGITUDE},
			async: false,
			dataType: 'json',
			success: function (response) {

			},
			error: function () {
				swal.fire(" خطا ", "في ارسال الطلب ", "error");
			}
		});

	});
	// ------------------------------------------------------------------------------- //

</script>