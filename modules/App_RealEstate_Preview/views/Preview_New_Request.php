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


    </div><!--begin::Container-->
</div>
<!--begin::Entry-->