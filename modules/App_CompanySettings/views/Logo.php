<div class="card card-custom card-stretch gutter-b">


    <!--begin::Header-->
    <div class="card-header">
        <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon-squares text-primary"></i>
                    </span>
            <h3 class="card-label"><?= $Page_Title ?></h3>
        </div>
        <div class="card-toolbar">
        </div>
    </div>
    <!--end::Header-->

    <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Settings/Update_Logo') ?>" enctype="multipart/form-data" method="post">
        <?= CSFT_Form() ?>
                <!--begin::Body-->
                <div class="card-body">

	                    <?php echo  $this->session->flashdata('message'); ?>

                        <div class="form-group row">

                            <div class="form-group row">
                                <div class="col-lg-6 mt-5">
                                    <label>شعار الشركة</label>
                                    <input type="file" name="logo_company" class="form-control-file"/>
                                </div>
                                <div class="col-lg-6 mt-5">
	                                <?php
	                                $Get_Company = Get_Company($this->aauth->get_user()->company_id);

	                                if($Get_Company->Company_Logo == ''){
                                      echo '<img width="84" height="61" alt="Logo" src="'.base_url('uploads/images.png').'">';
	                                }else{
		                              $Uploader_path = base_url('uploads/companies/'.$Get_Company->companies_Domain. '/' . FOLDER_FILE_Company_Logo.'/'.$Get_Company->Company_Logo);
		                              $size   = getimagesize($Uploader_path);
		                              //print_r($size);
		                              echo '<img  alt="Logo" '.$size[3].' src="'.$Uploader_path.'">';
	                                }
	                                ?>
                                </div>
                            </div>

                        </div>
                </div>
                <!--end: Card Body-->
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary mr-2">تحديث</button>
                        </div>
                        <div class="col-lg-6 text-lg-right">
                        </div>
                    </div>
                </div>
    </form>


</div>
<!--end: Card-->

<script type="text/javascript">
    var logo_company = new KTImageInput('logo_company');
</script>
