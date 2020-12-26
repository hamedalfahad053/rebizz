
<!DOCTYPE html>

<html lang="en" lang="en" dir="<?= $dir ?>" direction="<?= $direction ?>">
<!--begin::Head-->
<head>
    <meta charset="utf-8" />
    <title><?= $Page_Title ?></title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="" />
    <!--begin::Layout Themes-->
    <?= assets_layout_css('rtl') ?>
    <?= $Lode_file_Css ?>
    <!--end::Layout Themes-->

    <!--begin::Global Theme Bundle(used by all pages)-->
    <?= assets_layout_js('rtl') ?>
    <?= $Lode_file_Js ?>
    <!--end::Page Scripts-->

</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">



        <!--begin::Aside-->
        <div class="login-aside d-flex flex-row-auto bgi-size-cover bgi-no-repeat p-10 p-lg-10" style="background-image: url(<?= BASE_ASSET.'media/bg/bg-4.jpg'; ?>);">
            <!--begin: Aside Container-->
            <div class="d-flex flex-row-fluid flex-column justify-content-between">
                <!--begin: Aside header-->
                <a href="#" class="flex-column-auto mt-5 pb-lg-0 pb-10">
                    <img src="assets/media/logos/logo-letter-1.png" class="max-h-70px" alt="">
                </a>
                <!--end: Aside header-->
                <!--begin: Aside content-->
                <div class="flex-column-fluid d-flex flex-column justify-content-center">
                    <h3 class="font-size-h1 mb-5 text-white">مرحبا بك </h3>
                    <p class="font-weight-lighter text-white opacity-80">web apps.</p>
                </div>
                <!--end: Aside content-->
                <!--begin: Aside footer for desktop-->
                <div class="d-none flex-column-auto d-lg-flex justify-content-between mt-10">
                    <div class="opacity-70 font-weight-bold text-white">© 2020 </div>
                    <div class="d-flex">
                        <a href="#" class="text-white"></a>
                        <a href="#" class="text-white ml-10"></a>
                        <a href="#" class="text-white ml-10"></a>
                    </div>
                </div>
                <!--end: Aside footer for desktop-->
            </div>
            <!--end: Aside Container-->
        </div>
        <!--begin::Aside-->


        <!--begin::Content-->
        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <!--begin::Content body-->
            <div class="d-flex flex-column-fluid flex-center">
              <!--Start Content-->
                <?= $PageContent ?>
              <!--End Content-->
            </div>
            <!--end::Content body-->

            <!--begin::Content footer-->
            <div class="d-flex justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0">
                <div class="text-dark-50 font-size-lg font-weight-bolder mr-10">
                    <span class="mr-1"><?= date('Y') ?>©</span>
                    <a href="<?= base_url(); ?>" target="_blank" class="text-dark-75 text-hover-primary">نظام التثمين الذكي</a>
                </div>
                <a href="#" class="text-primary ml-5">سياسة الاستخدام</a>
                <a href="#" class="text-primary ml-5">سياسة الخصوصية</a>
                <a href="#" class="text-primary ml-5">الخطط</a>
                <a href="#" class="text-primary ml-5">تواصل معنا</a>
            </div>
            <!--end::Content footer-->

        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
</div>
<!--end::Main-->



<script type="text/javascript">
</script>
</body>
<!--end::Body-->
</html>