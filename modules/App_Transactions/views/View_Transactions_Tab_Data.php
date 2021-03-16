<div class="card card-custom mb-5 mt-10">

    <div class="card-header">
        <div class="card-title">
            <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
            <h3 class="card-label">البيانات الاساسية للطلب</h3>
        </div>
        <div class="card-toolbar"></div>
    </div>
    <div class="card-body">


	    <table class="data_table table table-bordered table-hover display nowrap" width="100%">
			    <tr>
				    <td class="text-center"> طريقة الاستلام</td>
				    <td class="text-center"><?=  $METHOD_OF_RECEIPT ?></td>
				    <td class="text-center">وقت الاستلام / بواسطة</td>
				    <td class="text-center"><?= date('Y-m-d h:i:s a',$Transactions_Data->Create_Transaction_Date) ?></td>
			    </tr>
				<tr>
					<td class="text-center">فئة العميل</td>
					<td class="text-center"><?= $CUSTOMER_CATEGORY ?></td>
					<td class="text-center"> العميل</td>
					<td class="text-center"><img src="<?= $Client_logo; ?>" height="35" width="35" ><?= $Client_id ?></td>
				</tr>

			    <tr>
				    <td class="text-center">رقم التكليف</td>
				    <td class="text-center"><?= $Transactions_Data->COMMISSIONING_NUMBER ?></td>
				    <td class="text-center">تاريخ / وقت التكليف</td>
				    <td class="text-center"><?= date('Y-m-d h:i:s a',$Transactions_Data->Create_Transaction_Date) ?></td>
			    </tr>
			    <tr>
				    <td class="text-center">الدولة</td>
				    <td class="text-center"><?= $Countries_id ?></td>
				    <td class="text-center">المنطقة</td>
				    <td class="text-center"><?= $Region_id ?></td>
			    </tr>
			    <tr>
				    <td class="text-center">المدينة</td>
				    <td class="text-center"><?= $City_id ?></td>
				    <td class="text-center"> الحي</td>
				    <td class="text-center"><?= $District_id ?></td>
			    </tr>
	    </table>
	    <!--begin: Datatable -->


    </div>
</div>


<div class="card card-custom mb-5 mt-10">

	<div class="card-header">
		<div class="card-title">
			<span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
			<h3 class="card-label"> بيانات المالك - طالب التقييم </h3>
		</div>
		<div class="card-toolbar"></div>
	</div>
	<div class="card-body">

		<table class="data_table table table-bordered table-hover display nowrap" width="100%">
			<tr>
				<td class="text-center">مالك العقار</td>
				<td class="text-center">رقم الهوية</td>
				<td class="text-center">رقم الجوال</td>
				<td class="text-center">طالب التقييم</td>
				<td class="text-center">رقم الهوية</td>
				<td class="text-center">رقم الجوال</td>
			</tr>
			<tr>
				<td class="text-center"><?= $Transactions_Data->OWNER_REAL_ESTATE ?></td>
				<td class="text-center"><?= $Transactions_Data->OWNER_IDENTITY_NUMBER ?></td>
				<td class="text-center"><?= $Transactions_Data->OWNERS_MOBILE_NUMBER ?></td>
				<td class="text-center"><?= $Transactions_Data->OWNER_APPLICANT_EVALUATION ?></td>
				<td class="text-center"><?= $Transactions_Data->OWNER_APPLICANT_IDENTITY_NUMBER ?></td>
				<td class="text-center"><?= $Transactions_Data->OWNER_MOBILE_EVALUATION ?></td>
			</tr>
		</table>
		<!--begin: Datatable -->

	</div>
</div>



<div class="card card-custom mb-5 mt-10">

	<div class="card-header">
		<div class="card-title">
			<span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
			<h3 class="card-label">بيانات الصك </h3>
		</div>
		<div class="card-toolbar"></div>
	</div>
	<div class="card-body">

		<table class="data_table table table-bordered table-hover display nowrap" width="100%">
			<tr>
				<td class="text-center">كتابة عدل</td>
				<td class="text-center"></td>
				<td class="text-center">رقم العقار</td>
				<td class="text-center"></td>
			</tr>
			<tr>
				<td class="text-center"> فئة العقار</td>
				<td class="text-center"></td>
				<td class="text-center">رقم الصك / تاريخة</td>
				<td class="text-center"></td>
			</tr>
		</table>

		<div class="separator separator-dashed my-8"></div>

		<table class="data_table table table-bordered table-hover display nowrap" width="100%">
			<tr>
				<td class="text-center">اسم المخطط</td>
				<td class="text-center"></td>
				<td class="text-center">رقم المخطط</td>
				<td class="text-center"></td>
				<td class="text-center">رقم البلك</td>
				<td class="text-center"></td>
				<td class="text-center">رقم القطعة</td>
				<td class="text-center"></td>
			</tr>
			<tr>
				<td class="text-center">الحد الشمالي</td>
				<td class="text-center"></td>
				<td class="text-center">بطول</td>
				<td class="text-center"></td>
				<td class="text-center">الحد الجنوبي</td>
				<td class="text-center"></td>
				<td class="text-center">بطول</td>
				<td class="text-center"></td>
			</tr>
			<tr>
				<td class="text-center">الحد الشرقي</td>
				<td class="text-center"></td>
				<td class="text-center">بطول</td>
				<td class="text-center"></td>
				<td class="text-center">الحد الغربي</td>
				<td class="text-center"></td>
				<td class="text-center">بطول</td>
				<td class="text-center"></td>
			</tr>
		</table>

	</div>
</div>


