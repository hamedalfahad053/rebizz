
	<!--begin: Card Contract basic information-->
	<div class="card card-custom card-stretch gutter-b">
		<!--begin::Header-->
		<div class="card-header">
			<div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon-squares text-primary"></i>
                    </span>
				<h3 class="card-label">بيانات العقد الأساسية</h3>
			</div>
			<div class="card-toolbar">
			</div>
		</div>
		<!--end::Header-->


		<!--begin::Body-->
		<div class="card-body">



			<table class="data_table table table-bordered table-hover display nowrap" width="100%">
				<tr>
					<td class="text-center">مسمى العقد</td>
					<td class="text-center"><?= $Client_Contract->Contracts_name ?></td>
				</tr>
				<tr>
					<td class="text-center">وصف</td>
					<td class="text-center"><?= $Client_Contract->Contracts_description ?></td>
				</tr>
				<tr>
					<td class="text-center">يبدا بتاريخ</td>
					<td class="text-center"><?= date('Y-m-d h:i:s a',$Client_Contract->Contracts_start_date) ?></td>
				</tr>
				<tr>
					<td class="text-center">ينتهي بتاريخ</td>
					<td class="text-center"><?= date('Y-m-d h:i:s a',$Client_Contract->Contracts_end_date) ?></td>
				</tr>
				<tr>
					<td class="text-center">تنسيق ترقيم المعاملات</td>
					<td class="text-center"><?= $Client_Contract->Code_Transaction ?></td>
				</tr>
				<tr>
					<td class="text-center">يبدا الترقيم من</td>
					<td class="text-center"><?= $Client_Contract->start_Num_Transaction ?></td>
				</tr>
				<tr>
					<td class="text-center">التجديد التلقائي</td>
					<td class="text-center"><?= $Client_Contract->is_auto_renew ?></td>
				</tr>
				<tr>
					<td class="text-center"></td>
					<td class="text-center"></td>
				</tr>

			</table>
			<!--begin: Datatable -->


		</div>
		<!--end: Card Body-->

	</div>
	<!--end: Card Contract basic information-->




