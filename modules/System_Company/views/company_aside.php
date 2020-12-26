<div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
    <!--begin::Card-->
    <div class="card card-custom">
        <!--begin::Body-->
        <div class="card-body pt-15">
            <!--begin::User-->
            <div class="text-center mb-10">
                <div class="symbol symbol-60 symbol-circle symbol-xl-90">
                    <div class="symbol-label" style="background-image:url('assets/media/users/300_21.jpg')"></div>
                    <i class="symbol-badge symbol-badge-bottom bg-success"></i>
                </div>
                <h4 class="font-weight-bold my-2"><?= Get_options_Data($Company->LIST_BUSINESS_CATEGORIES)->item_translation ?></h4>
                <div class="font-weight-bold font-size-h3 mb-2"><?= $Company->companies_Trade_Name ?></div>
                <span class="font-weight-bold"><?= $Companies_status_badge ?></span>
            </div>
            <!--end::User-->

            <!--begin::Nav-->
            <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Company/Company_Profile/'.$Company->company_id.'') ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">معلومات المنشأة</a>
            <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Company/Company_Group_Users/'.$Company->company_id.'') ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">مجموعة المستخدمين</a>
            <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Company/Company_Users/'.$Company->company_id.'') ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">المستخدمين</a>

            <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Company/Company_Fields/'.$Company->company_id.'') ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">ادارة الاشتراك</a>

            <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Company/Company_Fields/'.$Company->company_id.'') ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">ادارة الحقول</a>
            <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Company/Company_Forms/'.$Company->company_id.'') ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">ادارة النماذج</a>
            <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Company/Company_Contracts/'.$Company->company_id.'') ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">ادارة العقود</a>
            <a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Company/Company_Customers/'.$Company->company_id.'') ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">ادارة العملاء</a>
            <!--end::Nav-->

        </div>
        <!--end::Body-->
    </div>
    <!--end::Card-->
</div>