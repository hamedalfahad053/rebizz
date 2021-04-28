
<?php
foreach ($query->result() as $row) {
?>
        <div class="card card-custom mt-10">


            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon-squares text-primary"></i>
                            </span>
                    <h3 class="card-label"><?= $row->item_translation ?></h3>
                </div>
                <div class="card-toolbar">
                </div>
            </div>
            <!--end::Header-->

            <!--begin::Body-->
            <div class="card-body">
	            <div class="form-group row">
                <?php
                $Get_Fields_Components = Building_Fields_Components_Forms($row->Forms_id, $row->components_id,$row->With_CLIENT, $row->With_Type_CUSTOMER, $row->With_Type_Property, $row->With_TYPES_APPRAISAL, $row->With_Type_evaluation_methods);
                foreach ($Get_Fields_Components as $GFC) {
                    if ($GFC['Fields_Type_Components'] == 'Fields') {

                        $Where_Get_Fields = array("Fields_id" => $GFC['Fields_id']);
                        $Get_Fields = Get_Fields($Where_Get_Fields)->row();

                        echo '<div class="col-lg-4 mt-5">';

	                    echo Building_Field_Forms($Get_Fields->Fields_key,
			                    true,
			                    $Get_Fields->Fields_key.'-'.$row->Forms_id.'-'.$row->components_id,
			                    '',
			                    $Get_Fields->Fields_key,
			                    '',
			                    '',
			                    '',
			                    '',
			                    '',
			                    '');

                        echo '</div>';

                    } elseif ($GFC['Fields_Type_Components'] == 'List') {

                        echo '<div class="col-lg-4 mt-5">';
                        $class_List = array(0 => "selectpicker");

	                    Building_List_Forms($row->Forms_id,
			                    $row->components_id,
			                    $GFC['Fields_id'],
			                    $multiple = '',
			                    $selected='',
			                    $style='',
			                    $id='',
			                    $class = array( 0=> "selectpicker"),
			                    $disabled='',
			                    $label='',
			                    $js='');

	                    echo '</div>';

                    }
                } // foreach

                ?>
	            </div>


            </div>
            <!--end: Card Body-->

        </div>
        <!--end: Card-->

<?php
}
?>

<script>
    $(".datepicker").hijriDatePicker({
        hijri:false,
        format: "DD-MM-YYYY",
        hijriFormat:"iYYYY-iMM-iDD",
        dayViewHeaderFormat: "MMMM YYYY",
        hijriDayViewHeaderFormat: "iMMMM iYYYY",
        showSwitcher: true,
        allowInputToggle: true,
        useCurrent: true,
        isRTL: true,
        keepOpen: true,
        debug: true,
        showClear: true,
        showTodayButton: true,
        showClose: true
    });
</script>

<script>$(".selectpicker").selectpicker("refresh");</script>
