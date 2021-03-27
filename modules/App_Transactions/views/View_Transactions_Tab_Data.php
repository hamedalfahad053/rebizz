

<?php




$where_extra_Form_Components = array('With_Type_CUSTOMER'=> "All",'With_Type_Property'=> "All", 'With_TYPES_APPRAISAL'=> "All",'With_Type_evaluation_methods'=>"All");
$Form_Components = Get_Form_Components(1,$where_extra_Form_Components);
foreach ($Form_Components->result() AS $RC)
{
?>
<input type="hidden" name="Form_id" value="1">
<div class="card card-custom mt-10">

	<!--begin::Header-->
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label">
				<?= $RC->item_translation ?>
			</h3>
		</div>
		<div class="card-toolbar">

		</div>
	</div>
	<!--begin::Header-->

	<!--begin::Body-->
	<div class="card-body">


		<div class="form-group row">
			<?php
			$Get_Fields_Components = Building_Fields_Components_Forms($RC->Forms_id, $RC->components_id,'All','All','All','All');
			foreach ($Get_Fields_Components as $GFC)
			{
			   if($GFC['Fields_Type_Components'] == 'Fields') {

				   $Where_Get_Fields = array("Fields_id" => $GFC['Fields_id']);
				   $Get_Fields = Get_Fields($Where_Get_Fields)->row();
				   echo '<div class="col-lg-4 mt-5">';

				   echo '</div>';

			   }elseif($GFC['Fields_Type_Components'] == 'List') {
				   echo '<div class="col-lg-4 mt-5">';

				   echo '</div>';
			   }

			}
			?>
		</div><!-- <div class="form-group row"> -->



	</div>
	<!--begin::Body-->


</div><!--<div class="card card-custom mt-10">-->
<?php
}
?>


	<?php
	$Get_Form_Components_Customs = Get_Form_Components_Customs('1',
			$data_transactions['LIST_CUSTOMER_CATEGORY']['data_value'],
			$data_transactions['LIST_TYPE_OF_PROPERTY']['data_value'],
			$data_transactions['LIST_TYPES_OF_REAL_ESTATE_APPRAISAL']['data_value'],
			'');

	if($Get_Form_Components_Customs->num_rows()>0){

	foreach ($Get_Form_Components_Customs->result() AS $GFCC)
	{
	?>

		<div class="card card-custom mt-10">

			<!--begin::Header-->
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">
						<?= $GFCC->item_translation ?>
					</h3>
				</div>
				<div class="card-toolbar">

				</div>
			</div>
			<!--begin::Header-->

			<!--begin::Body-->
			<div class="card-body">


			</div><!--begin::Body-->

		</div><!--<div class="card card-custom mt-10">-->

	<?php
	} // foreach ($Get_Form_Components_Customs->result() AS $GFCC)

	} //if($Get_Form_Components_Customs->num_rows()>0)
	?>




