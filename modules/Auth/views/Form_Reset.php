<!--begin::Forgot-->
<div class="login-form">
    <!--begin::Form-->
    <form class="form" novalidate="novalidate">

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
            <a href="<?= base_url('Auth') ?>" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">الغاء الامر</a>
        </div>
        <!--end::Form group-->

    </form>
    <!--end::Form-->
</div>
<!--end::Forgot-->

