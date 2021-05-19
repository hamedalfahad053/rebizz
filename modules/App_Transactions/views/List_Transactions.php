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

	    <div class="card card-custom mb-5">
		    <div class="card-body">
			    <form class="mb-5">
				    <div class="row mb-6">
					    <div class="col-lg-3 mb-lg-0 mb-6">
						    <label>رقم المعاملة</label>
						    <input type="text" class="form-control datatable-input" placeholder="رقم المعاملة" data-col-index="0">
					    </div>
					    <div class="col-lg-3 mb-lg-0 mb-6">
						    <label>المالك</label>
						    <input type="text" class="form-control datatable-input" placeholder="المالك" data-col-index="1">
					    </div>
					    <div class="col-lg-3 mb-lg-0 mb-6">
						    <label>طالب التقييم</label>
						    <input type="text" class="form-control datatable-input" placeholder="طالب التقييم" data-col-index="2">
					    </div>
					    <div class="col-lg-3 mb-lg-0 mb-6">
						    <label>المنطقة</label>
						    <select id="Region_id" class="form-control selectpicker datatable-input"  title="اختر من فضلك " data-col-index="3">
							    <option></option>
						    </select>
					    </div>

				    </div>
				    <div class="row mb-6">


					    <div class="col-lg-3 mb-lg-0 mb-6">
						    <label>نوع التقييم</label>
						    <select class="form-control selectpicker datatable-input"  title="اختر من فضلك " data-col-index="5">
							    <option></option>
							    <?php
							    $lang = get_current_lang();

							    $query_list_options4 = app()->db->from('portal_list_options_data list_options');
							    $query_list_options4 = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
							    $query_list_options4 = app()->db->where('list_options.list_id', 4);
							    $query_list_options4 = app()->db->where('options_translation.translation_lang', $lang);
							    $query_list_options4 = app()->db->order_by('list_options.options_sort', ' DESC');
							    $query_list_options4 = app()->db->get();
							    foreach ($query_list_options4->result() AS $OP4)
							    {
							    ?>
							    <option value="<?= $OP4->item_translation ?>"><?= $OP4->item_translation ?></option>
							    <?php
							    }
							    ?>
 						    </select>
					    </div>

					    <div class="col-lg-3 mb-lg-0 mb-6">
						    <label> حالة المعاملة </label>
						    <select class="form-control selectpicker datatable-input" title="اختر من فضلك " data-col-index="6">
							    <option></option>
							    <?php
							    $lang = get_current_lang();

							    $query_list_options9 = app()->db->from('portal_list_options_data list_options');
							    $query_list_options9 = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
							    $query_list_options9 = app()->db->where('list_options.list_id', 9);
							    $query_list_options9 = app()->db->where('options_translation.translation_lang', $lang);
							    $query_list_options9 = app()->db->order_by('list_options.options_sort', ' DESC');
							    $query_list_options9 = app()->db->get();
							    foreach ($query_list_options9->result() AS $OP9)
							    {
								    ?>
								    <option value="<?= $OP9->item_translation ?>"><?= $OP9->item_translation ?></option>
								    <?php
							    }
							    ?>
 						    </select>
					    </div>

					    <div class="col-lg-3 mb-lg-0 mb-6">
						    <label>بحيازة</label>
						    <select class="form-control selectpicker datatable-input" data-col-index="7">
							    <option value=""></option>

 						    </select>
					    </div>

				    </div>

				    <div class="row mt-8">
					    <div class="col-lg-12">
						    <button class="btn btn-primary btn-primary--icon" id="kt_search"><span><i class="la la-search"></i><span>بحث</span></span></button>&nbsp;&nbsp;
					    </div>
				    </div>
			    </form>
		    </div>
	    </div>

	    <div class="card card-custom">
		    <div class="card-body">




			    <?php echo  $this->session->flashdata('message'); ?>


			    <?php
			    if($Transactions == false)
			    {
				    $msg_result['key'] = 'Danger';
				    $msg_result['value'] = 'لا يوجد معاملات';
				    $msg_result_view = Create_Status_Alert($msg_result);
				    echo $msg_result_view;

			    }else{
				    ?>

				    <style>th.dt-center,.dt-center { text-align: center; }</style>
				    <table id="list_data" class=" table table-bordered table-hover display nowrap" width="100%">
					    <thead>
					    <tr>
						    <th class="text-center">رقم المعاملة</th>
						    <th class="text-center">المالك</th>
						    <th class="text-center">طالب التقييم</th>
						    <th class="text-center">موقع العقار</th>
						    <th class="text-center">بواسطة / التاريخ</th>
						    <th class="text-center">نوع التقييم</th>
						    <th class="text-center">بحيازة</th>
						    <th class="text-center">حالة المعاملة</th>
						    <th class="text-center">الخيارات</th>
					    </tr>
					    </thead>
					    <tbody>
					    <?php
					    foreach ($Transactions AS $Row)
					    {
						    ?>
						    <tr>
							    <td class="text-center">


								    <img src="
								    <?php

								    $path = $LoginUser_Company_Path_Folder.'/'.FOLDER_FILE_Company_client_logo.'/';
								    echo Get_Client_Logo($LoginUser_Company_Path_Folder,$this->aauth->get_user()->company_id,Transaction_data_by_key($Row['transaction_id'],1,1,'LIST_CLIENT'));
								    ?>"  height="35" width="35" >

								    <br>

								    <?= date('Ymd',$Row['Create_Transaction_Date']).$Row['transaction_id'];?>

							    </td>

							    <?php
							    if(Transaction_data_by_key($Row['transaction_id'],13,4,'OWNER_REAL_ESTATE')){
							    ?>
							    <td class="text-center">
								    <?= Transaction_data_by_key($Row['transaction_id'],13,4,'OWNER_REAL_ESTATE') ?>
								    <?= Transaction_data_by_key($Row['transaction_id'],13,4,'OWNERS_MOBILE_NUMBER') ?>
							    </td>
							    <td class="text-center">
								    <?= Transaction_data_by_key($Row['transaction_id'],13,4,'OWNER_APPLICANT_EVALUATION') ?>
								    <?= Transaction_data_by_key($Row['transaction_id'],13,4,'OWNER_MOBILE_EVALUATION') ?>
							    </td>
							    <?php
							    }else{
							    ?>
								    <td class="text-center">--</td><td class="text-center">--</td>
							    <?php
							    }
							    ?>

							    <td class="text-center">
								    <?php
								    $d = Transaction_data_by_key($Row['transaction_id'],1,1,'LIST_REGION');
								    echo get_data_options_List_view(20,$d);
								    ?>
								     -
								    <?php
								    $d = Transaction_data_by_key($Row['transaction_id'],1,1,'LIST_CITY');
								    echo get_data_options_List_view(21,$d);
								    ?>
								     -
								    <?php
								    $d = Transaction_data_by_key($Row['transaction_id'],1,1,'LIST_DISTRICT');
								    echo get_data_options_List_view(22,$d);
								    ?>
							    </td>
							    <td class="text-center">
								    <?= $this->aauth->get_user($Row['Create_Transaction_By_id'])->full_name ?>
								    <br>
								    <?= date('Y-m-d h:i:s a',$Row['Create_Transaction_Date']);?>
							    </td>
							    <td class="text-center">
								    <?php
								    $d = Transaction_data_by_key($Row['transaction_id'],1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');
								    echo get_data_options_List_view(4,$d);
								    ?>
							    </td>
							    <td class="text-center">
								    <?php
								    echo get_data_options_List_view(29,$Row['Transaction_Stage'],'key');
								    ?>
								    <br>

							    </td>
							    <td class="text-center">
								    <?=  get_data_options_List_view(9,$Row['Transaction_Status_id']); ?>
							    </td>
							    <td class="text-center">
								    <?=  $Row['transaction_options'] ?>
							    </td>
						    </tr>
						    <?php
					    }
					    ?>
					    </tbody>
				    </table>
				    <!--begin: Datatable -->
				    <?php
			    }
			    ?>
		    </div>
	    </div>




    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


<script type="text/javascript">

	var KTDatatablesSearchOptionsAdvancedSearch = function() {

		$.fn.dataTable.Api.register('column().title()', function() {
			return $(this.header()).text().trim();
		});

		var initTable1 = function() {
			// begin first table
			var table = $('#list_data').DataTable({
				responsive: true,
				// Pagination settings
				dom: `<'row'<'col-sm-12'tr>>
				<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
				lengthMenu: [5, 10, 25, 50],
				pageLength: 10,
				language: {
					'lengthMenu': 'Display _MENU_',
				},
				searchDelay: 500,
				processing: true,
				initComplete: function() {
					this.api().columns().every(function() {
						var column = this;
						switch (column.title()) {

						}
					});
				}
			});

			var filter = function() {
				var val = $.fn.dataTable.util.escapeRegex($(this).val());
				table.column($(this).data('col-index')).search(val ? val : '', false, false).draw();
			};

			var asdasd = function(value, index) {
				var val = $.fn.dataTable.util.escapeRegex(value);
				table.column(index).search(val ? val : '', false, true);
			};

			$('#kt_search').on('click', function(e) {
				e.preventDefault();
				var params = {};
				$('.datatable-input').each(function() {
					var i = $(this).data('col-index');
					if (params[i]) {
						params[i] += '|' + $(this).val();
					}
					else {
						params[i] = $(this).val();
					}
				});
				$.each(params, function(i, val) {
					table.column(i).search(val ? val : '', false, false);
				});
				table.table().draw();
			});

			$('#kt_reset').on('click', function(e) {
				e.preventDefault();
				$('.datatable-input').each(function() {
					$(this).val('');
					table.column($(this).data('col-index')).search('', false, false);
				});
				table.table().draw();
			});

			$('#kt_datepicker').datepicker({
				todayHighlight: true,
				templates: {
					leftArrow: '<i class="la la-angle-left"></i>',
					rightArrow: '<i class="la la-angle-right"></i>',
				},
			});

		};

		return {
			init: function() {
				initTable1();
			},
		};

	}();

	jQuery(document).ready(function() {
		KTDatatablesSearchOptionsAdvancedSearch.init();
	});






</script>

