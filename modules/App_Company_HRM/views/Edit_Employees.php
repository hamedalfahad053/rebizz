


        <div class="card card-custom">
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

	        <form class="form" id="" name="" action="<?= base_url(APP_NAMESPACE_URL.'/HRM/Update_Employees/'.$this->uri->segment(4)) ?>" enctype="multipart/form-data" method="post">
		    <?= CSFT_Form() ?>
	            <div class="card-body">


		            <div class="form-group row">
			            <div class="col-lg-6 mt-5">
				            <label>الاسم باللغة العربية</label>
				            <input type="text" name="full_name_ar" value="<?= $Users->full_name_ar ?>" class="form-control" placeholder=""/>
			            </div>
			            <div class="col-lg-6 mt-5">
				            <label>الاسم باللغة الانجليزية</label>
				            <input type="text" name="full_name" value="<?= $Users->full_name ?>" class="form-control" placeholder="<?= lang('user_full_name_en') ?>"/>
			            </div>
		            </div>

		            <div class="separator separator-dashed separator-border-1 mt-1"></div>

		            <div class="form-group row">
			            <div class="col-lg-6 mt-5">
				            <label><?= lang('Global_email') ?></label>
				            <input type="text" name="email" class="form-control"  value="<?= $Users->email ?>" placeholder="<?= lang('Global_email') ?>"/>
			            </div>
			            <div class="col-lg-6 mt-5">
				            <label><?= lang('Global_Mobile') ?></label>
				            <input type="text" name="mobile" class="form-control" value="<?= $Users->phone ?>" placeholder="<?= lang('Global_Mobile') ?>"/>
			            </div>
		            </div>


		            <div class="separator separator-dashed separator-border-1 mt-1"></div>

		            <div class="form-group row">
			            <div class="col-lg-6 mt-5">
				            <label>رقم العضوية بهيئة المقيمين</label>
				            <input type="text" name="Authority_membership_No" class="form-control"  value="<?= $Users->Authority_membership_No ?>" placeholder=" رقم العضوية بهيئة المقيمين "/>
			            </div>
			            <div class="col-lg-6 mt-5">
				            <label>توقيع الموظف</label>
				            <?php
				            $Uploader_path = base_url('uploads/companies/' . $this->data['LoginUser_Company_domain'] . '/' . FOLDER_Company_Signature);
				            ?>
				            <img width="200px" height="75px" src="<?= $Uploader_path.'/'.$Users->Signature ?>">
                            <input type="file" name="Signature" class="form-control-file">

			            </div>
		            </div>


	            </div>
		        <div class="card-footer">
			        <div class="row">
				        <div class="col-lg-6">
					        <button type="submit" id="buttonCreateSections" class="btn btn-primary mr-2">تحديث بيانات الموظف</button>
				        </div>
				        <div class="col-lg-6 text-lg-right">

				        </div>
			        </div>
		        </div>
	        </form>

        </div>





