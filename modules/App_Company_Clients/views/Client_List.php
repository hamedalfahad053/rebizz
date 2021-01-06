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

        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon-squares text-primary"></i>
                    </span>
                    <h3 class="card-label"><?= $Page_Title ?></h3>
                </div>
                <div class="card-toolbar">
                    <?= Create_One_Button_Text_Without_tooltip(array('title' => lang('add_new_Client_button'), 'data_attribute' => 'data-toggle="modal" data-target="#CreateNewClient"', 'href' => "javascript:void(0);")) ?>
                </div>
            </div>
            <div class="card-body">


                <?php echo  $this->session->flashdata('message'); ?>

                <style>
                    th.dt-center,
                    .dt-center {
                        text-align: center;
                    }
                </style>
                <table class="data_table table table-bordered table-hover display nowrap" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center"><?= lang('client_name') ?></th>
                            <th class="text-center"><?= lang('client_type') ?></th>
                            <!-- <th class="text-center"><?= lang('User_group') ?></th> -->
                            <th class="text-center"><?= lang('Table_Status') ?></th>
                            <th class="text-center"><?= lang('Table_Options') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($clients !== false) {
                            foreach ($clients as $row) {
                        ?>
                                <tr>
                                    <td class="text-center"><?= $row['Client_id'] ?></td>
                                    <td class="text-center"><?= $row['Client_name'] ?></td>
                                    <td class="text-center"><?= $row['type_id'] ?></td>
                                    <!-- <td class="text-center"><?= $row['company_id'] ?></td> -->
                                    <td class="text-center"><?= $row['is_active'] ?></td>
                                    <td class="text-center"><?= $row['options'] ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <!--begin: Datatable -->
            </div>
        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


<!--Start Modal Create new Client-->
<div class="modal fade" id="CreateNewClient" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL . '/Clients/Create_Client') ?>" method="post">
                <?= CSFT_Form() ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= lang('add_new_Client_title') ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="company_id" value="0" />
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-6 mt-5">
                            <label><?= lang('client_name') ?> </label>
                            <input type="text" name="name" class="form-control" placeholder="<?= lang('client_name') ?>" />
                        </div>

                        <div class="col-sm-12 col-md-6 mt-5">
                            <label><?= lang('client_type') ?></label>
                            <?= Get_Data_List('select', 'LIST_BUSINESS_CATEGORIES') ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 col-md-6 mt-5">
                            <label><?= lang('Global_email') ?> </label>
                            <input type="email" name="email" class="form-control" placeholder="<?= lang('Global_email') ?>" />
                        </div>

                        <div class="col-sm-12 col-md-6 mt-5">
                            <label><?= lang('Global_Phone') ?> </label>
                            <input type="tel" name="Phone" class="form-control" placeholder="<?= lang('Global_Phone') ?>" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 col-md-6 mt-5">
                            <label><?= lang('Status_add_System') ?> </label>
                            <select name="is_active" class="form-control selectpicker" data-live-search="true" data-title="اختر الحالة ">
                                <?php
                                foreach ($List_status as $key => $value) {
                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Modal Create new Client-->

<script type="text/javascript">
    $(document).ready(function() {
        $('.data_table').DataTable({
            responsive: true
        });

    });
</script>