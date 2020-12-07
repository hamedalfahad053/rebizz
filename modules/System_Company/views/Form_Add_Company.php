<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">

            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5"><?= $Page_Title ?></h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <?= $breadcrumbs ?>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->

        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">

        </div>
        <!--end::Toolbar-->
    </div>
</div>
<!--end::Subheader-->

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">

        <form class="form" name="" action="<?= base_url(ADMIN_NAMESPACE_URL.'/Company/Create_Company') ?>" method="post">

            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-squares text-primary"></i>
                                </span>
                        <h3 class="card-label"><?= lang('companies_Commercial_registry') ?></h3>
                    </div>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body">
                        <div class="card-body">

                            <div class="form-group row">
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('companies_Category') ?></label>
                                    <select name="owner_group"  class="form-control selectpicker" data-live-search="true">
                                        <option></option>
                                    </select>
                                </div>
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('companies_Trade_Name') ?></label>
                                    <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                                </div>
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('companies_Commercial_Registration_No') ?></label>
                                    <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                                </div>
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('companies_Unified_record_number') ?></label>
                                    <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                                </div>
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('Global_Registration_Date') ?></label>
                                    <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                                </div>
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('Global_Expiry_Date') ?></label>
                                    <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                                </div>
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('Global_Country') ?></label>
                                    <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                                </div>
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('Global_Region_province') ?></label>
                                    <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                                </div>
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('Global_City') ?></label>
                                    <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                                </div>
                                <div class="col-lg-12 mt-5">
                                    <label><?= lang('companies_commercial_activities') ?></label>
                                    <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                                </div>
                            </div>


                        </div>
                </div>
            </div>



            <div class="card card-custom mt-10">
                <div class="card-header">
                    <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-squares text-primary"></i>
                                </span>
                        <h3 class="card-label"><?= lang('companies_Owner_information') ?></h3>
                    </div>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-lg-4 mt-5">
                                <label>اسم المالك </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>الجنسية </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>رقم الهوية </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>

                            <div class="col-lg-4 mt-5">
                                <label>تاريخ الاصدار </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>تاريخ الانتهاء </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>صادرة من  </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>

                            <div class="col-lg-4 mt-5">
                                <label>رقم الجوال </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>رقم الهاتف </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-12 mt-5">
                                <label>العنوان </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>

                        </div>


                    </div>
                </div>
            </div>

            <div class="card card-custom mt-10">
                <div class="card-header">
                    <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-squares text-primary"></i>
                                </span>
                        <h3 class="card-label"><?= lang('companies_Contact_information') ?></h3>
                    </div>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-lg-4 mt-5">
                                <label>رقم الهاتف </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>رقم جوال </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>البريد الالكتروني </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>الموقع الالكتروني </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>صندوق البريد </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>الرمز البريدي </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-custom mt-10">
                <div class="card-header">
                    <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-squares text-primary"></i>
                                </span>
                        <h3 class="card-label"><?= lang('companies_address_information') ?></h3>
                    </div>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-lg-4 mt-5">
                                <label>الدولة </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label> المنطقة </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>المدينة </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>الحي </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>الشارع </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>رقم المبنى </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>

                            <div class="col-lg-12 mt-5">
                                <label>تفاصيل اخرى  </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>

                            <div class="col-lg-12 mt-5">
                                <label> الموقع على قوقل   </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            <div class="card card-custom mt-10">
                <div class="card-header">
                    <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-squares text-primary"></i>
                                </span>
                        <h3 class="card-label"><?= lang('companies_documents_information') ?></h3>
                    </div>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">


                    </div>
                </div>
            </div>


        </form>

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
