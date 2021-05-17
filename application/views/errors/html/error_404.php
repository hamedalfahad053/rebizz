<html lang="en">
<!--begin::Head-->
<head>
	<meta charset="utf-8" />
	<title>الصفحة المطلوبة غير متاحة</title>
	<?= insert_online_current_user(404); ?>


	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

	<!--begin::Layout Themes-->
	<?= assets_layout_css('rtl') ?>
	<!--end::Layout Themes-->


	<script>var HOST_URL = '<?= base_url(APP_NAMESPACE_URL.'/') ?>';</script>
	<!--begin::Global Theme Bundle(used by all pages)-->
	<?= assets_layout_js('rtl') ?>
	<!--end::Page Scripts-->

		<style type="text/css">
			.dropdown-toggle {padding-right: 5px !important;}
			.bootstrap-select.btn-group,.dropdown-toggle,.filter-option,.filter-option-inner-inner{text-align: right !important;}
			.bootstrap-select.btn-group .dropdown-toggle .caret {left: 12px !important;right: unset !important;}

			th.dt-center,.dt-center { text-align: center; }

			input.datepicker {
				width: 100% !important;
			}
		</style>

</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">



<!--begin::Main-->
<div class="d-flex flex-column flex-root">
	<!--begin::Error-->
	<div class="d-flex flex-row-fluid flex-column bgi-size-cover bgi-position-center bgi-no-repeat p-10 p-sm-30" style="background-image: url(<?= base_url('Assets/media/error/bg1.jpg') ?>);">
		<!--begin::Content-->
		<h1 class=" text-dark-20 mt-15" style="font-size: 5rem">الصفحة المطلوبة غير متاحة</h1>
		<p class="font-size-h3 text-muted font-weight-normal">حصل خطا ما نعتذر عن ذلك سيتم حل المشكلة بأسرع وقت ممكن يرجى التواصل مع الدعم الفني لمساعدتك </p>
		<p> <a onclick="history.back()" class="btn btn-primary btn-lg">العودة للخلف</a></p>
		<!--end::Content-->
	</div>
	<!--end::Error-->
</div>
<!--end::Main-->



<!--begin::Global Config(global config for global JS scripts)-->
<script  type="text/javascript">var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
<!--end::Global Config-->

</body>
<!--end::Body-->
</html>
