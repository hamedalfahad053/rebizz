<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
    <!--begin::Header-->
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
        <h3 class="font-weight-bold m-0">الملف الشخصي
            <small class="text-muted font-size-sm ml-2"></small></h3>
        <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>
    <!--end::Header-->
    <!--begin::Content-->
    <div class="offcanvas-content pr-5 mr-n5">
        <!--begin::Header-->
        <div class="d-flex align-items-center mt-5">
            <div class="symbol symbol-100 mr-5">
                <div class="symbol-label" style="background-image:url('assets/media/users/300_21.jpg')"></div>
                <i class="symbol-badge bg-success"></i>
            </div>
            <div class="d-flex flex-column">
                <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?= $this->data['UserLogin']['Info_User']->full_name ?></a>
                <div class="text-muted mt-1"></div>
                <div class="navi mt-2">
                    <a href="#" class="navi-item">
								<span class="navi-link p-0 pb-2">
									<span class="navi-text text-muted text-hover-primary"><?= $this->data['UserLogin']['Info_User']->email ?></span>
								</span>
                    </a>
                    <a href="<?= base_url(APP_NAMESPACE_URL."/Dashboard/logout") ?>" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">تسجيل الخروج</a>
                </div>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Separator-->
        <div class="separator separator-dashed mt-8 mb-5"></div>
        <!--end::Separator-->
        <!--begin::Nav-->
        <div class="navi navi-spacer-x-0 p-0">
            <!--begin::Item-->
            <a href="#" class="navi-item">
                <div class="navi-link">
                    <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label ">
                            <i class="flaticon-cogwheel text-success"></i>
                        </div>
                    </div>
                    <div class="navi-text">
                        <div class="font-weight-bold">الملف الشخصي</div>
                        <div class="text-muted">اعداد الحساب و البيانات الشخصية   </div>
                    </div>
                </div>
            </a>
            <!--end:Item-->
            <!--begin::Item-->
            <a href="#" class="navi-item">
                <div class="navi-link">
                    <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label">
                            <i class="flaticon-cogwheel  text-primary"></i>
                        </div>
                    </div>
                    <div class="navi-text">
                        <div class="font-weight-bold">البريد </div>
                        <div class="text-muted">الرسائل الواردة و المرسلة</div>
                    </div>
                </div>
            </a>
            <!--end:Item-->
            <!--begin::Item-->
            <a href="#" class="navi-item">
                <div class="navi-link">
                    <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label">
                            <i class="flaticon-cogwheel  text-danger"></i>
                        </div>
                    </div>
                    <div class="navi-text">
                        <div class="font-weight-bold">نشاط الحساب</div>
                        <div class="text-muted">سجل الوصول و العلميات</div>
                    </div>
                </div>
            </a>
            <!--end:Item-->

        </div>
        <!--end::Nav-->
        <!--begin::Separator-->
        <div class="separator separator-dashed my-7"></div>
        <!--end::Separator-->


    </div>
    <!--end::Content-->
</div>
