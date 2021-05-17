

        <div class="card card-custom mb-5 mt-10">

            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
                    <h3 class="card-label">حدد المقيم</h3>
                </div>
                <div class="card-toolbar">
                </div>
            </div>
            <form class="form" id="Create_Users_Evaluator" name="Users_Evaluator" action="<?= base_url(APP_NAMESPACE_URL.'/Coordinator/Create_Assign_Evaluator/'.$this->uri->segment(4)) ?>" enctype="multipart/form-data" method="post">
                <?= CSFT_Form() ?>
                <div class="card-body">

	                <?php echo  $this->session->flashdata('message'); ?>

                    <div class="form-group row">
                        <div class="col-lg-12 mt-5">
                            <label> حدد المقيم </label>
                            <select name="Users_Evaluator" class="form-control selectpicker" title="<?= lang("Select_noneSelectedText") ?>" data-live-search="true">
                                <?php
                                foreach ($Users_Evaluator->result() AS $EM)
                                {
                                    echo '<option value="'.$EM->users_id.'">'.$EM->full_name.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="submit" id="buttonCreateSections" class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
                        </div>
                        <div class="col-lg-6 text-lg-right">

                        </div>
                    </div>
                </div>
            </form>

        </div>


