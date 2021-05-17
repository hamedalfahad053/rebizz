

		<div class="card card-custom mb-5 ">

			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label"> الموظف </h3>
				</div>
				<div class="card-toolbar">

				</div>
			</div>
		    <div class="card-body">

			    <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Work_Team/Submit_Assign_Transaction/'.$this->uri->segment(4)) ?>" method="post">
				    <?= CSFT_Form() ?>
				    <div class="card-body">
					    <div class="form-group row">

						    <div class="col-lg-12">
 							    <select name="user_emp_id"  data-size="7" title="اختر من فضلك " data-live-search="true"  class="form-control selectpicker">
								    <?php
								    foreach ($Company_Users AS $key)
								    {
									    echo '<option value="'.$key['user_id'].'" data-subtext="'.$key['position'].'" data-icon="la la-user font-size-lg bs-icon">'.$key['full_name'].'</option>';
								    }
								    ?>-
							    </select>
						    </div>

					    </div>
				    </div>
				    <div class="card-footer">
					    <div class="row">
						    <div class="col-lg-6">
							    <button type="submit" class="btn btn-primary mr-2">اضافة الموظف</button>
						    </div>
						    <div class="col-lg-6 text-lg-right">
						    </div>
					    </div>
				    </div>

			    </form>
		    </div>
	    </div>


