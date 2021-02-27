<div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
    <!--begin::Card-->
    <div class="card card-custom">
        <!--begin::Body-->
        <div class="card-body pt-15">



            <!--begin::User-->
            <div class="text-center mb-10">
                <div class="symbol symbol-60 symbol-circle symbol-xl-90">

	                <?php
	                if($Client_Info->logo == ''){
		                $logo = LOGO_DEFAULT_CLIENT;
	                }else{
		                $logo = $this->data['LoginUser_Company_Path_Folder'].'/'.FOLDER_FILE_Company_client_logo.'/'.$Client_Info->logo;
	                }
	                ?>

                    <div class="symbol-label" style="background-image:url('<?= $logo ?>')"></div>
                </div>
                <h4 class="font-weight-bold my-2">العميل :</h4>
                <div class="font-weight-bold font-size-h3 mb-2"><?= $Client_Info->name ?></div>
                <span class="font-weight-bold"><?= $Client_status_badge ?></span>
            </div>
            <!--end::User-->


            <?php $Client_id =  $this->uri->segment(4); ?>

            <!--begin::Nav-->
            <a href="<?= base_url(APP_NAMESPACE_URL.'/Clients/Information/'.$Client_id.'') ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">معلومات العميل</a>
            <a href="<?= base_url(APP_NAMESPACE_URL.'/Clients/Contracts/'.$Client_id.'') ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">ادارة العقود</a>

            <div class="separator separator-dashed separator-border-1 mt-5 mb-5"></div>

            <a href="<?= base_url(APP_NAMESPACE_URL.'/Clients/Transactions/'.$Client_id.'') ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block"> معاملات العميل</a>

            <div class="separator separator-dashed separator-border-1 mt-5 mb-5"></div>

            <a href="<?= base_url(APP_NAMESPACE_URL.'/Clients/#/'.$Client_id.'') ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block"> مطالبات العميل </a>

            <!--end::Nav-->

        </div>
        <!--end::Body-->
    </div>
    <!--end::Card-->
</div>