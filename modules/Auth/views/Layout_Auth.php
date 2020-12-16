
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
                <!--begin::Signin-->
                <div class="login-form login-signin">
                    <!--begin::Form-->
                    <form class="form" novalidate="novalidate" id="kt_login_signin_form">

                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg"> نظام التثمين العقاري الذكي </h3>
                        </div>
                        <!--begin::Title-->

                        <?php echo  $this->session->flashdata('message'); ?>

                        <!--begin::Form group-->
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">البريد الالكتروني</label>
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="text" name="username" autocomplete="off" />
                        </div>
                        <!--end::Form group-->

                        <!--begin::Form group-->
                        <div class="form-group">
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5">كلمة المرور </label>
                                <a href="javascript:;" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot">هل فقدت كلمة المرور ؟</a>
                            </div>
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="password" name="password" autocomplete="off" />
                        </div>
                        <!--end::Form group-->

                        <!--begin::Action-->
                        <div class="pb-lg-0 pb-5">
                            <button type="button" id="kt_login_signin_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">تسجيل دخول</button>
                        </div>
                        <!--end::Action-->

                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->


                <!--begin::Forgot-->
                <div class="login-form login-forgot">
                    <!--begin::Form-->
                    <form class="form" novalidate="novalidate" id="kt_login_forgot_form">

                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg"> هل فقدت كلمة المرور ؟</h3>
                            <p class="text-muted font-weight-bold font-size-h4">فضلا ضع بريدك الالكتروني لاستعادة كلمة المرور </p>
                        </div>
                        <!--end::Title-->

                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6" type="email" placeholder="البريد الالكتروني" name="email" autocomplete="off" />
                        </div>
                        <!--end::Form group-->

                        <!--begin::Form group-->
                        <div class="form-group d-flex flex-wrap pb-lg-0">
                            <button type="button" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">ارسال</button>
                            <button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">الغاء الامر</button>
                        </div>
                        <!--end::Form group-->

                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Forgot-->


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
    var KTLogin = function() {
        var _login;

        var _showForm = function(form) {
            var cls = 'login-' + form + '-on';
            var form = 'kt_login_' + form + '_form';

            _login.removeClass('login-forgot-on');
            _login.removeClass('login-signin-on');
            _login.removeClass('login-signup-on');

            _login.addClass(cls);

            KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp');
        }

        var _handleSignInForm = function() {
            var validation;

            validation = FormValidation.formValidation(
                KTUtil.getById('kt_login_signin_form'),
                {
                    fields: {
                        username: {
                            validators: {
                                notEmpty: {
                                    message: 'Username is required'
                                }
                            }
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: 'Password is required'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        bootstrap: new FormValidation.plugins.Bootstrap()
                    }
                }
            );

            $('#kt_login_signin_submit').on('click', function (e) {
                e.preventDefault();

                validation.validate().then(function(status) {
                    if (status == 'Valid') {
                        swal.fire({
                            text: "All is cool! Now you submit this form",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        }).then(function() {
                            KTUtil.scrollTop();
                        });
                    } else {
                        swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        }).then(function() {
                            KTUtil.scrollTop();
                        });
                    }
                });
            });

            // Handle forgot button
            $('#kt_login_forgot').on('click', function (e) {
                e.preventDefault();
                _showForm('forgot');
            });

            // Handle signup
            $('#kt_login_signup').on('click', function (e) {
                e.preventDefault();
                _showForm('signup');
            });
        }


        var _handleForgotForm = function(e) {
            var validation;

            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            validation = FormValidation.formValidation(
                KTUtil.getById('kt_login_forgot_form'),
                {
                    fields: {
                        email: {
                            validators: {
                                notEmpty: {
                                    message: 'Email address is required'
                                },
                                emailAddress: {
                                    message: 'The value is not a valid email address'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap()
                    }
                }
            );

            // Handle submit button
            $('#kt_login_forgot_submit').on('click', function (e) {
                e.preventDefault();

                validation.validate().then(function(status) {
                    if (status == 'Valid') {
                        // Submit form
                        KTUtil.scrollTop();
                    } else {
                        swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        }).then(function() {
                            KTUtil.scrollTop();
                        });
                    }
                });
            });

            // Handle cancel button
            $('#kt_login_forgot_cancel').on('click', function (e) {
                e.preventDefault();

                _showForm('signin');
            });
        }

        // Public Functions
        return {
            // public functions
            init: function() {
                _login = $('#kt_login');
                _handleSignInForm();
                _handleForgotForm();
            }
        };
    }();

    // Class Initialization
    jQuery(document).ready(function() {
        KTLogin.init();
    });


</script>
</body>
<!--end::Body-->
</html>