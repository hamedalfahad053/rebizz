
<!--begin::Signin-->
<div class="login-form login-signin">
    <!--begin::Form-->
    <form class="form" method="post" action="<?= base_url('Auth/Login') ?>" novalidate="novalidate" >
        <?= CSFT_Form() ?>

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
                <a href="<?= base_url('Auth/Reset') ?>" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5" >هل فقدت كلمة المرور ؟</a>
            </div>
            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="password" name="password" autocomplete="off" />
        </div>
        <!--end::Form group-->

        <!--begin::Action-->
        <div class="pb-lg-0 pb-5">
            <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">تسجيل دخول</button>
        </div>
        <!--end::Action-->

    </form>
    <!--end::Form-->
</div>
<!--end::Signin-->