<!DOCTYPE html>

<html lang="en" dir="<?= $dir ?>" direction="<?= $direction ?>">

<!--begin::Head-->
<head>
    <meta charset="utf-8" />
    <title><?= $Page_Title ?></title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!--begin::Layout Themes-->
    <?= assets_layout_css('rtl') ?>
    <?= $Lode_file_Css ?>
    <!--end::Layout Themes-->

    <!--begin::Global Theme Bundle(used by all pages)-->
    <?= assets_layout_js('rtl') ?>
    <?= $Lode_file_Js ?>
    <!--end::Page Scripts-->


    <?php
    if($direction=='rtl'){
    ?>
    <style type="text/css">
        .dropdown-toggle {padding-right: 5px !important;}
        .bootstrap-select.btn-group,.dropdown-toggle,.filter-option,.filter-option-inner-inner{text-align: right !important;}
        .bootstrap-select.btn-group .dropdown-toggle .caret {left: 12px !important;right: unset !important;;}
    </style>
    <?php
    }
    ?>

</head>
<!--end::Head-->

<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<!--begin::Main-->



<!--begin::Header Mobile-->
<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
    <!--begin::Logo-->
    <a href="#">
        <img alt="Logo" src="<?= BASE_ASSET.'media/logos/logo-light.png' ?>" />
    </a>
    <!--end::Logo-->
    <!--begin::Toolbar-->
    <div class="d-flex align-items-center">
        <!--begin::Aside Mobile Toggle-->
        <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
            <span></span>
        </button>
        <!--end::Aside Mobile Toggle-->
        <!--begin::Header Menu Mobile Toggle-->
        <button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
            <span></span>
        </button>
        <!--end::Header Menu Mobile Toggle-->
        <!--begin::Topbar Mobile Toggle-->
        <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
                        <!--end::Svg Icon-->
					</span>
        </button>
        <!--end::Topbar Mobile Toggle-->
    </div>
    <!--end::Toolbar-->
</div>
<!--end::Header Mobile-->

<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">



        <!--begin::Aside-->
        <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">


            <!--begin::Brand-->
            <div class="brand flex-column-auto" id="kt_brand">
                <!--begin::Logo-->
                <a href="index.html" class="brand-logo">
                    <img alt="Logo" src="<?= BASE_ASSET.'media/logos/logo-light.png' ?>" />
                </a>
                <!--end::Logo-->
                <!--begin::Toggle-->
                <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
							<span class="svg-icon svg-icon svg-icon-xl">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
                                        <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
							</span>
                </button>
                <!--end::Toolbar-->
            </div>
            <!--end::Brand-->


            <!--begin::Aside Menu-->
            <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                <!--begin::Menu Container-->
                <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
                    <!--begin::Menu Nav-->
                    <ul class="menu-nav">


                        <li class="menu-item" aria-haspopup="true">
                            <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Dashboard') ?>" class="menu-link">
                                <i class="menu-icon flaticon-home"></i>
                                <span class="menu-text">لوحة المعلومات</span>
                            </a>
                        </li>


                        <li class="menu-section">
                            <h4 class="menu-text">ادارة المستخدمين و المجموعات</h4>
                            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                        </li>
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="svg-icon menu-icon"><i class="flaticon-users text-primary"></i></span>
                                <span class="menu-text">ادارة المستخدمين</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Users') ?>" class="menu-link menu-toggle">
                                            <span class="menu-icon"><i class="flaticon-users text-primary"></span></i><span class="menu-text">المستخدمين</span></a>
                                    </li>
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Group_Users') ?>" class="menu-link menu-toggle">
                                            <span class="menu-icon"><i class="flaticon-rotate text-primary"></span></i><span class="menu-text">مجموعة المستخدمين</span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>


                        <li class="menu-section">
                            <h4 class="menu-text">ادارة الصلاحيات </h4>
                            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                        </li>
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="svg-icon menu-icon"><i class="flaticon-users text-primary"></i></span>
                                <span class="menu-text">ادارة الصلاحيات</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Permissions/') ?>" class="menu-link menu-toggle">
                                            <span class="menu-icon"><i class="flaticon-users text-primary"></span></i><span class="menu-text">اعداد الصلاحيات</span></a>
                                    </li>
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Permissions/Roles') ?>" class="menu-link menu-toggle">
                                            <span class="menu-icon"><i class="flaticon-rotate text-primary"></span></i><span class="menu-text">اعداد الادوار</span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>




                        <li class="menu-section">
                            <h4 class="menu-text"> ادارة اللغات و الترجمة </h4>
                            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                        </li>
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="svg-icon menu-icon"><i class="flaticon2-world text-primary"></i></span>
                                <span class="menu-text">ادارة اللغات</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Language') ?>" class="menu-link menu-toggle"><span class="menu-icon"><i class="flaticon2-world text-primary"></span></i>
                                            <span class="menu-text"> اللغات </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>


                        <li class="menu-section">
                            <h4 class="menu-text"> ادارة الشركات و المكاتب  </h4>
                            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                        </li>
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="svg-icon menu-icon"><i class="flaticon2-world text-primary"></i></span>
                                <span class="menu-text"> ادارة الشركات و المكاتب </span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">

                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Company/Form_Add_Company') ?>" class="menu-link menu-toggle"><span class="menu-icon"><i class="flaticon2-world text-primary"></span></i>
                                            <span class="menu-text"> تسجيل حساب جديد </span>
                                        </a>
                                    </li>

                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Company') ?>" class="menu-link menu-toggle"><span class="menu-icon"><i class="flaticon2-world text-primary"></span></i>
                                            <span class="menu-text"> ادارة الشركات و المكاتب </span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>


                        <li class="menu-section">
                            <h4 class="menu-text"> ادارة الحقول و النماذج  </h4>
                            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                        </li>
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="svg-icon menu-icon"><i class="flaticon2-world text-primary"></i></span>
                                <span class="menu-text"> ادارة الحقول و النماذج </span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">

                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Fields') ?>" class="menu-link menu-toggle"><span class="menu-icon"><i class="flaticon2-world text-primary"></span></i>
                                            <span class="menu-text"> ادارة الحقول </span>
                                        </a>
                                    </li>

                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Company') ?>" class="menu-link menu-toggle"><span class="menu-icon"><i class="flaticon2-world text-primary"></span></i>
                                            <span class="menu-text"> ادارة النماذج  </span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="svg-icon menu-icon"><i class="flaticon2-world text-primary"></i></span>
                                <span class="menu-text"> ادارة قوائم البيانات </span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/List_Data/Form_Add_New_List') ?>" class="menu-link menu-toggle"><span class="menu-icon"><i class="flaticon2-world text-primary"></span></i>
                                            <span class="menu-text"> اضافة قائمة جديدة </span>
                                        </a>
                                    </li>
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/List_Data') ?>" class="menu-link menu-toggle"><span class="menu-icon"><i class="flaticon2-world text-primary"></span></i>
                                            <span class="menu-text"> ادارة القوائم </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>




                        <li class="menu-section">
                            <h4 class="menu-text"> ادارة النظام  </h4>
                            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/System/Area') ?>" class="menu-link">
                                <i class="menu-icon flaticon-browser"></i>
                                <span class="menu-text"> مناطق العرض  </span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/System/Controllers') ?>" class="menu-link">
                                <i class="menu-icon flaticon2-gear"></i>
                                <span class="menu-text"> ادارة الانظمة </span>
                            </a>
                        </li>


                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="svg-icon menu-icon">
                                <i class="flaticon2-world"></i></span>
                                <span class="menu-text"> قائمة</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">

                                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Company/Form_Add_Company') ?>" class="menu-link menu-toggle"><span class="menu-icon"><i class="flaticon2-world text-primary"></span></i>
                                            <span class="menu-text"> تسجيل حساب جديد </span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>





                    </ul>
                    <!--end::Menu Nav-->
                </div>
                <!--end::Menu Container-->
            </div>
            <!--end::Aside Menu-->
        </div>
        <!--end::Aside-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

            <!--begin::Header-->
            <?= $this->load->view('../../modules/Layout/Widgets/Header'); ?>
            <!--end::Header-->

            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <?= $PageContent ?>
            </div>
            <!--end::Content-->

            <!--begin::Footer-->
            <?= $this->load->view('../../modules/Layout/Widgets/Footer'); ?>
            <!--end::Footer-->

        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Main-->

<!-- begin::User Panel-->
<?= $this->load->view('../../modules/Layout/Widgets/UserPanel'); ?>
<!-- end::User Panel-->

<!--begin::Quick Cart-->
<?= $this->load->view('../../modules/Layout/Widgets/QuickCart'); ?>
<!--end::Quick Cart-->

<!--begin::Quick Panel-->
<?= $this->load->view('../../modules/Layout/Widgets/QuickPanel'); ?>
<!--end::Quick Panel-->

<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop">
			<span class="svg-icon">
				<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg>
                <!--end::Svg Icon-->
			</span>
</div>
<!--end::Scrolltop-->

<!--begin::Sticky Toolbar-->
<ul class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4">
    <!--begin::Item-->
    <li class="nav-item mb-2" id="kt_demo_panel_toggle" data-toggle="tooltip" title="Check out more demos" data-placement="right">
        <a class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" href="#">
            <i class="flaticon2-drop"></i>
        </a>
    </li>
    <!--end::Item-->
</ul>
<!--end::Sticky Toolbar-->

<!--begin::Global Config(global config for global JS scripts)-->
<script  type="text/javascript">var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
<!--end::Global Config-->



</body>
<!--end::Body-->
</html>