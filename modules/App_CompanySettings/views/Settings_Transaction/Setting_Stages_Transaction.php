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


        <?php echo  $this->session->flashdata('message'); ?>


        <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Settings_Transaction/Update_Stages') ?>" method="post">
            <?= CSFT_Form() ?>
            <?php
            foreach ($stages as $s)
            {

                $where_Get_Stages = array(
                    "company_id" => $this->aauth->get_user()->company_id,
                    "stages_key" => $s['stages_key'],
                );
                $Get_Stages       = Get_Stages_Transaction_Company($where_Get_Stages);
                if($Get_Stages->num_rows()>0){
                    $Get_Stages = $Get_Stages->row();
                }

                $selected_attribution_method_a = '';
                $selected_attribution_method_b = '';
                ?>
                <div class="card card-custom mt-5">
                    <!--begin::Header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label"> من :  <?= $s['stages_title'] ?></h3>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="form-group row">
                            <input type="hidden" name="stages_key[]" value="<?= $s['stages_key'] ?>">
                            <div class="col-lg-4 mt-5">
                                <label>الى قسم</label>
                                <select name="Departments_To[]" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
                                    <?php
                                    foreach ($Departments AS $key2)
                                    {
                                        if(@$Get_Stages->Departments_To == $key2['departments_id']){
                                            $selected_departments_id = 'selected="selected"';
                                        }else{
                                            $selected_departments_id = '';
                                        }
                                        echo '<option '.$selected_departments_id.'  value="'.$key2['departments_id'].'">'.$key2['departments_title'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label>طريقة الاسناد</label>
                                <select name="attribution_method[]" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
                                    <?php
                                    if(@$Get_Stages->attribution_method == 1){
                                        $selected_attribution_method_a = 'selected="selected"';
                                    }elseif (@$Get_Stages->attribution_method == 2){
                                        $selected_attribution_method_b = 'selected="selected"';
                                    }else{
                                        $selected_attribution_method_a = '';
                                        $selected_attribution_method_b = '';
                                    }
                                    ?>
                                    <option <?=  $selected_attribution_method_a ?> value="1">رئيس القسم</option>
                                    <option <?=  $selected_attribution_method_b ?> value="2">موظفين القسم بحسب الشاغر</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--begin::Body-->
                </div>
                <!--end: Card-->
                <?php
            }
            ?>
            <div class="card card-custom mt-5">
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary mr-2">تحديث</button>
                        </div>
                        <div class="col-lg-6 text-lg-right">
                        </div>
                    </div>
                </div>
            </div>


        </form>



    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->