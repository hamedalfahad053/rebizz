<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Mobile Toggle-->
            <button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none" id="kt_subheader_mobile_toggle">
                <span></span>
            </button>
            <!--end::Mobile Toggle-->
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


<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">

            <div class="card card-custom">
                <div class="card-body">

               <?php

               //echo $Get_Regions->Point_2;

               ?>

	                <?= $Get_Regions->Latitude ?> - <?= $Get_Regions->Longitude ?>
	                <div id="kt_leaflet_4" style="height:500px"></div>

                </div>
            </div>

        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->

<?= import_css(BASE_ASSET.'plugins/custom/leaflet/leaflet.bundle',''); ?>
<?= import_js(BASE_ASSET.'plugins/custom/leaflet/leaflet.bundle',''); ?>

<script>



	// Class definition
	var KTLeaflet = function () {

		// Private functions
		var demo4 = function () {
			// define leaflet
			var leaflet = L.map('kt_leaflet_4', {
				center: [<?= $Get_Regions->Latitude ?>,<?= $Get_Regions->Longitude ?>],
				zoom: 18
			})

			// set leaflet tile layer
			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
			}).addTo(leaflet);

			// set custom SVG icon marker
			var leafletIcon = L.divIcon({
				html: `<span class="svg-icon svg-icon-danger svg-icon-3x"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="24" width="24" height="0"/><path d="M5,10.5 C5,6 8,3 12.5,3 C17,3 20,6.75 20,10.5 C20,12.8325623 17.8236613,16.03566 13.470984,20.1092932 C12.9154018,20.6292577 12.0585054,20.6508331 11.4774555,20.1594925 C7.15915182,16.5078313 5,13.2880005 5,10.5 Z M12.5,12 C13.8807119,12 15,10.8807119 15,9.5 C15,8.11928813 13.8807119,7 12.5,7 C11.1192881,7 10,8.11928813 10,9.5 C10,10.8807119 11.1192881,12 12.5,12 Z" fill="#000000" fill-rule="nonzero"/></g></svg></span>`,
				bgPos: [10, 10],
				iconAnchor: [20, 37],
				popupAnchor: [0, -37],
				className: 'leaflet-marker'
			});

			// bind marker with popup
			var marker = L.marker([<?= $Get_Regions->Latitude ?>,<?= $Get_Regions->Longitude ?>], { icon: leafletIcon }).addTo(leaflet);

			// set circle polygon
			var circle = L.circle([<?= $Get_Regions->Latitude ?>,<?= $Get_Regions->Longitude ?>], {
				color: '#4A7DFF',
				fillColor: '#6993FF',
				fillOpacity: 0.5,
				radius: 700
			}).addTo(leaflet);

			// set polygon
			var polygon = L.polygon([
				[51.509, -0.08],
				[51.503, -0.06],
				[51.51, -0.047]
			]).addTo(leaflet);
		}

		return {
			// public functions
			init: function () {
				// default charts
				demo4();
			}
		};
	}();

	jQuery(document).ready(function () {
		KTLeaflet.init();
	});



</script>
