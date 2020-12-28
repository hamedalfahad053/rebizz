<div id="kt_quick_panel" class="offcanvas offcanvas-right pt-5 pb-10">
    <!--begin::Header-->
    <div class="offcanvas-header offcanvas-header-navs d-flex align-items-center justify-content-between mb-5">
        <ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-primary flex-grow-1 px-10" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#kt_quick_panel_logs">سجل النشاط</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#kt_quick_panel_notifications">الاشعارات</a>
            </li>
        </ul>
        <div class="offcanvas-close mt-n1 pr-5">
            <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_panel_close">
                <i class="ki ki-close icon-xs text-muted"></i>
            </a>
        </div>
    </div>
    <!--end::Header-->


    <!--begin::Content-->
    <div class="offcanvas-content px-10">
        <div class="tab-content">

            <!--begin::Tabpane panel_logs -->
            <div class="tab-pane fade show pt-3 pr-5 mr-n5 active" id="kt_quick_panel_logs" role="tabpanel">
                <!--begin::Section-->
                <div class="mb-15">
                    <h5 class="font-weight-bold mb-5">سجل الوصول بالنظام</h5>
                    <!--begin: Item-->
                    <div class="d-flex align-items-center flex-wrap mb-5">
                        <div class="symbol symbol-50 symbol-light mr-5">
									<span class="symbol-label">
										<img src="assets/media/svg/misc/006-plurk.svg" class="h-50 align-self-center" alt="" />
									</span>
                        </div>
                        <div class="d-flex flex-column flex-grow-1 mr-2">
                            <a href="#" class="font-weight-bolder text-dark-75 text-hover-primary font-size-lg mb-1">Top Authors</a>
                            <span class="text-muted font-weight-bold">Most Successful Fellas</span>
                        </div>
                        <span class="btn btn-sm btn-light font-weight-bolder py-1 my-lg-0 my-2 text-dark-50">+82$</span>
                    </div>
                    <!--end: Item-->
                </div>
                <!--end::Section-->
            </div>
            <!--end::Tabpane panel_logs -->

            <!--begin::Tabpane notifications-->
            <div class="tab-pane fade pt-2 pr-5 mr-n5" id="kt_quick_panel_notifications" role="tabpanel">
                <!--begin::Nav-->
                <div class="navi navi-icon-circle navi-spacer-x-0">
                    <!--begin::Item-->
                    <a href="#" class="navi-item">
                        <div class="navi-link rounded">
                            <div class="symbol symbol-50 mr-3">
                                <div class="symbol-label">
                                    <i class="flaticon-bell text-success icon-lg"></i>
                                </div>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold font-size-lg">5 new user generated report</div>
                                <div class="text-muted">Reports based on sales</div>
                            </div>
                        </div>
                    </a>
                    <!--end::Item-->
                </div>
                <!--end::Nav-->
            </div>
            <!--end::Tabpane notifications-->

        </div>
    </div>
    <!--end::Content-->
</div>