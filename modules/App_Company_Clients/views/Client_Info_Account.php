<div class="card card-custom card-stretch gutter-b">


	<!--begin::Header-->
	<div class="card-header">
		<div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-list-1 text-primary"></i>
                    </span>
			<h3 class="card-label"><?= $Page_Title ?></h3>
		</div>
		<div class="card-toolbar">
		</div>
	</div>
	<!--end::Header-->


	<!--begin::Body-->
	<div class="card-body">

		<?php echo  $this->session->flashdata('message'); ?>



		<table class="data_table table table-bordered table-hover display nowrap" width="100%">
			<tr>
				<td class="text-center">اسم العميل</td>
				<th class="text-center"><?= $Client_Info->name ?></th>
			</tr>
			<tr>
				<td class="text-center">فئةالعميل</td>
				<td class="text-center"><?= Get_options_List_Translation($Client_Info->type_id)->item_translation;  ?></td>
			</tr>
			<tr>
				<td class="text-center">البريد الالكتروني</td>
				<td class="text-center"><?= $Client_Info->email ?></td>
			</tr>
			<tr>
				<td class="text-center">رقم الاتصال</td>
				<td class="text-center"><?= $Client_Info->phone ?></td>
			</tr>

			<tr>
				<td class="text-center">تاريخ تسجيل العميل</td>
				<td class="text-center"><?= date('Y-m-d h:i:s a',$Client_Info->created_date) ?></td>
			</tr>

			<tr>
				<td class="text-center">بواسطة</td>
				<td class="text-center"><?= $this->aauth->get_user($Client_Info->created_By)->full_name ?></td>
			</tr>

		</table>
		<!--begin: Datatable -->

	</div>
	<!--end: Card Body-->


</div>
<!--end: Card-->