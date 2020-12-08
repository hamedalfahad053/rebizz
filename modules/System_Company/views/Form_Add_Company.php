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
                                <label><?= lang('companies_owner_nam') ?></label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Nationality') ?></label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Identification_Number') ?></label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>

                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Issued_Date') ?></label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Expiry_Date') ?></label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Issued_by') ?></label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>

                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Mobile') ?></label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_telephone') ?></label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-12 mt-5">
                                <label><?= lang('Global_address') ?></label>
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
                                <label><?= lang('Global_telephone') ?></label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Mobile') ?></label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_email') ?></label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_website') ?></label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_postbox') ?></label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_Postal_code') ?></label>
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
                                <label> <?= lang('Global_Country') ?> </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label> <?= lang('Global_Region_province') ?>  </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_City') ?> </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_District') ?> </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_street') ?>  </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Global_building_number') ?></label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>

                            <div class="col-lg-12 mt-5">
                                <label><?= lang('Global_details') ?> </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>

                            <div class="col-lg-12 mt-5">
                                <label><?= lang('Google_Location_on_Google') ?> </label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </form>

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
