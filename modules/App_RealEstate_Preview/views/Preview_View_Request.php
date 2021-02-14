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


	    <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Create_Transaction') ?>" enctype="multipart/form-data" method="post">
		<?= CSFT_Form() ?>



		    <div class="card card-custom mb-3 mt-2">
			    <div class="card-body">
				    <ul class="nav nav-tabs nav-bold nav-tabs-line">
					    <li class="nav-item">
						    <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1_4">
							    <span class="nav-icon"><i class="flaticon-cogwheel icon-md"></i></span>
							    <span class="nav-text">البيانات الاساسية </span>
						    </a>
					    </li>

					    <li class="nav-item">
						    <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_1_6">
							    <span class="nav-icon"><i class="flaticon-cogwheel icon-md"></i></span>
							    <span class="nav-text">مكونات العقار </span>
						    </a>
					    </li>


					    <li class="nav-item">
						    <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2_4">
							    <span class="nav-icon"><i class="flaticon2-map icon-md"></i></span>
							    <span class="nav-text"> تحديد الموقع </span>
						    </a>
					    </li>

					    <li class="nav-item">
						    <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3_4">
							    <span class="nav-icon"><i class="flaticon-photo-camera icon-md"></i></span>
							    <span class="nav-text"> صور الموقع </span>
						    </a>
					    </li>

					    <li class="nav-item">
						    <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4_4">
							    <span class="nav-icon"><i class="flaticon-price-tag icon-md"></i></span>
							    <span class="nav-text"> تقييم العقار </span>
						    </a>
					    </li>

					    <li class="nav-item">
						    <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4_5">
							    <span class="nav-icon"><i class="flaticon-analytics icon-md"></i></span>
							    <span class="nav-text"> عروض حول العقار </span>
						    </a>
					    </li>

				    </ul>
			    </div>
		    </div>



		    <div class="tab-content">

			    <div class="tab-pane fade show active" id="kt_tab_pane_1_4" role="tabpanel" aria-labelledby="kt_tab_pane_1_4">
				    <?php
				    echo $this->load->view('../../modules/App_RealEstate_Preview/views/View_Transactions_Tab_Data', $this->data);
				    ?>
			    </div>

			    <div class="tab-pane fade" id="kt_tab_pane_2_4" role="tabpanel" aria-labelledby="kt_tab_pane_2_4">

				    <div class="card card-custom gutter-b">
					    <div class="card-header">
						    <div class="card-title">
							    <h3 class="card-label">
								    تحديد موقع العقار
							    </h3>
						    </div>
					    </div>
					    <div class="card-body">
						    <div id="kt_leaflet_2" style="height:300px;"></div>
					    </div>
				    </div>

			    </div>


			    <div class="tab-pane fade" id="kt_tab_pane_1_6" role="tabpanel" aria-labelledby="kt_tab_pane_1_6">

				    <div class="card card-custom gutter-b">
					    <div class="card-header">
						    <div class="card-title">
							    <h3 class="card-label">
								    مكونات العقار
							    </h3>
						    </div>
					    </div>
					    <div class="card-body">

					    </div>
				    </div>

			    </div>


			    <div class="tab-pane fade" id="kt_tab_pane_3_4" role="tabpanel" aria-labelledby="kt_tab_pane_3_4">

				    <div class="card card-custom gutter-b">
					    <div class="card-header">
						    <div class="card-title">
							    <h3 class="card-label">
								    صور العقار
							    </h3>
						    </div>
					    </div>
					    <div class="card-body">

					    </div>
				    </div>

			    </div>

			    <div class="tab-pane fade" id="kt_tab_pane_4_4" role="tabpanel" aria-labelledby="kt_tab_pane_4_4">

				    <div class="card card-custom gutter-b">
					    <div class="card-header">
						    <div class="card-title">
							    <h3 class="card-label">
								    تقييم العقار
							    </h3>
						    </div>
					    </div>
					    <div class="card-body">

					    </div>
				    </div>

			    </div>

			    <div class="tab-pane fade" id="kt_tab_pane_4_5" role="tabpanel" aria-labelledby="kt_tab_pane_4_5">

				    <div class="card card-custom gutter-b">
					    <div class="card-header">
						    <div class="card-title">
							    <h3 class="card-label">
								     عروض حول العقار
							    </h3>
						    </div>
					    </div>
					    <div class="card-body">

					    </div>
				    </div>

			    </div>

		    </div>



	    </form>

    </div><!--begin::Container-->
</div>
<!--begin::Entry-->


<script type="text/javascript">
	$(document).ready(function() {
		$('.data_table').DataTable({
			responsive: true
		});
	});




	var map = L.map('map').fitWorld();

	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
				'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/streets-v11',
		tileSize: 512,
		zoomOffset: -1
	}).addTo(map);

	function onLocationFound(e) {
		var radius = e.accuracy / 2;

		L.marker(e.latlng).addTo(map)
				.bindPopup("You are within " + radius + " meters from this point").openPopup();

		L.circle(e.latlng, radius).addTo(map);
	}

	function onLocationError(e) {
		alert(e.message);
	}

	map.on('locationfound', onLocationFound);
	map.on('locationerror', onLocationError);

	map.locate({setView: true, maxZoom: 16});



</script>