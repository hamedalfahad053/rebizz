<div class="card card-custom mb-5 mt-10">

    <div class="card-header">
        <div class="card-title">
            <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
            <h3 class="card-label">موقع العقار</h3>
        </div>
        <div class="card-toolbar"></div>
    </div>
    <div class="card-body">


	    <table class="data_table table table-bordered table-hover display nowrap" width="100%">
			    <tr>
				    <td class="text-center">الدولة</td>
				    <td class="text-center"></td>
				    <td class="text-center">المنطقة</td>
				    <td class="text-center"></td>
			    </tr>
			    <tr>
				    <td class="text-center">المدينة</td>
				    <td class="text-center"></td>
				    <td class="text-center"> الحي</td>
				    <td class="text-center"></td>
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



<div class="card card-custom mb-5 mt-10">

	<div class="card-header">
		<div class="card-title">
			<span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
			<h3 class="card-label">البيانات الاساسية للعقار</h3>
		</div>
		<div class="card-toolbar"></div>
	</div>
	<div class="card-body">

		<table class="data_table table table-bordered table-hover display nowrap" width="100%">
			<tr>
				<td class="text-center">رقم فسح البناء</td>
				<td class="text-center"></td>
				<td class="text-center">تاريخ فسح البناء</td>
				<td class="text-center"></td>
				<td class="text-center">رقم قرار الذرعة</td>
				<td class="text-center"></td>
				<td class="text-center"> تاريخ قرار الذرعة</td>
				<td class="text-center"></td>
			</tr>
			<tr>
				<td class="text-center">عمر العقار</td>
				<td class="text-center"></td>
				<td class="text-center">نوع المبنى</td>
				<td class="text-center"></td>
				<td class="text-center">توفر رخصة بناء </td>
				<td class="text-center"></td>
				<td class="text-center">شاغرية المبنى </td>
				<td class="text-center"></td>
			</tr>
			<tr>
				<td class="text-center">حالة المبنى </td>
				<td class="text-center"></td>
				<td class="text-center">المنسوب</td>
				<td class="text-center"></td>
				<td class="text-center">الهيكل الانشائي</td>
				<td class="text-center"></td>
				<td class="text-center">تصميم معماري</td>
				<td class="text-center"></td>
			</tr>

		</table>
		<!--begin: Datatable -->

	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('.data_table').DataTable({
			responsive: true
		});
	});
</script>