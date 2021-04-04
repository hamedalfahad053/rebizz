<?php

##############################################################################
if(!function_exists('Create_Fields')) {

    function Create_Fields($data)
    {
        app()->load->database();

        $query = app()->db->insert('portal_fields',$data);

        if($query){
            return app()->db->insert_id();
        }else{
            return false;
        }
    }

}
##############################################################################

##############################################################################
if(!function_exists('Get_Fields'))
{
    function Get_Fields($where_extra = '')
    {
        app()->load->database();

        $lang   = get_current_lang();

        $query_Fields = app()->db->from('portal_fields  fields');
        $query_Fields = app()->db->join('portal_fields_translation  fields_translation', 'fields.Fields_id=fields_translation.item_id');

        if(!empty($where_extra)){

            foreach ($where_extra AS $key => $value)
            {
                $query_Fields = app()->db->where('fields.'.$key,$value);
            }
        }

        $query_Fields = app()->db->where('fields_translation.translation_lang',$lang);
        $query_Fields = app()->db->get();
        return $query_Fields;
    }

}
##############################################################################

##############################################################################
if(!function_exists('Update_Custom_Fields'))
{
    function Update_Custom_Fields($Fields_uuid,$Fields_company_id,$Fields_Status)
    {
        app()->load->database();

        $query_Fields = app()->db->where('Fields_uuid',$Fields_uuid);
        $query_Fields = app()->db->where('Fields_company_id',$Fields_company_id);
        $query_Fields = app()->db->set('Fields_lastModifyDate',time());
        $query_Fields = app()->db->set('Fields_status_Fields',$Fields_Status);
        $query_Fields = app()->db->update('portal_fields');

        if($query_Fields){
             return true;
        }else{
            return false;
        }
    }
}
##############################################################################

##############################################################################
if(!function_exists('Creation_Field')) {

    function  Creation_Field_HTML_input($Fields_key='',$label='',$name='', $value = '',$id='',$class = '',$style,$maxlength='', $disabled='', $attribute ='',$js='')
    {
        app()->load->database();

        $lang       = get_current_lang();
        $input      = '';
        $form_input = '';

        $query_Fields = app()->db->from('portal_fields  fields');
        $query_Fields = app()->db->join('portal_fields_translation  fields_translation', 'fields.Fields_id=fields_translation.item_id');
        $query_Fields = app()->db->where('fields.Fields_id',$Fields_key);
        $query_Fields = app()->db->or_where('fields.Fields_key',$Fields_key);
        $query_Fields = app()->db->where('fields_translation.translation_lang',$lang);
        $query_Fields = app()->db->get()->row();


        $data_input = array();

        if($query_Fields->Fields_Type_Fields ==  'text' or $query_Fields->Fields_Type_Fields ==  'date') {

            $data_input['type'] = 'text';

            $class_output = ' form-control ';
            if (is_array($class)) {
                foreach ($class as $c) {
                    $class_output .= $class_output . ' ' . $c;
                }
            }

            $attribute_output = '';
            if (is_array($attribute)) {
                foreach ($attribute as $atr) {
                    $attribute_output .= $attribute_output . ' ' . $atr;
                }
            }

            if ($query_Fields->Fields_Type_Fields == 'date') $class_output .= $class_output . ' datepicker';
            if ($query_Fields->Fields_Type_Fields == 'file') $class_output .= $class_output . ' form-control-file';

            $data_input['name'] = $query_Fields->Fields_key;
            $data_input['id'] = $id;
            $data_input['value'] = set_value($query_Fields->Fields_key, $value);
            $data_input['maxlength'] = $maxlength;
            $data_input['style'] = $style;

            if (!empty($disabled)) {
                $data_input['disabled'] = $disabled;
            }


            $data_input['class'] = $class_output;
            $data_input['attribute'] = $attribute_output;

            if ($js) {
                $input = form_input($data_input, $js);
            } else {
                $input = form_input($data_input);
            }

            if ($label) {
                $form_input .= form_label($query_Fields->item_translation, '');
                $form_input .= $input;
            }

        }elseif ($query_Fields->Fields_Type_Fields ==  'file_multiple'){

            $form_input.= app()->load->view('../../modules/System_Fields/views/tamplet_file_multiple',$data_input, true);

        }

        return $form_input;

    }
}
##############################################################################

####################################################################
if(!function_exists('array_Type_Fields')) {

    function array_Type_Fields()
    {
        $Type_Fields = array(
            "text"     => "حقل نصي",
            "textarea" => "حقل نصي كبير",
            "textarea" => "حقل نصي كبير",
            "date"     => "تاريخ",
            "email"    => "بريد الكتروني",
            "file"     => "تحميل ملف",
            "file_multiple"     => "تحميل متعدد للملفات",
            "number"   => "ارقام",
            "number_list" => "ترقيم 10 ",
            "time"     => "وقت",
            "url"      => "رابط",
            "tel"      => "رقم هاتف",
        );
        return $Type_Fields;
    }

}
####################################################################

##############################################################################
if(!function_exists('Creation_validating_Fields')) {

    function Creation_validating_Fields($data)
    {
        app()->load->database();

        $query = app()->db->insert('portal_forms_fields_validation',$data);

        if(app()->db->affected_rows()){
            return true;
        }else{
            return false;
        }
    }

}
##############################################################################

##############################################################################
if(!function_exists('Get_validating_Fields')) {

    function Get_validating_Fields($where_extra)
    {
        app()->load->database();
        if(!empty($where_extra)){

            foreach ($where_extra AS $key => $value)
            {
                $query = app()->db->where($key,$value);
            }
        }
        $query = app()->db->get('portal_forms_fields_validation');
        return $query;
    }

}
##############################################################################

##############################################################################
if(!function_exists('Update_validating_Fields'))
{

    function Update_validating_Fields($Forms_id,$Components_id,$Fields_id,$company_id,$data)
    {
            app()->load->database();
            $lang   = get_current_lang();

            $query = app()->db->where('Forms_id', $Forms_id);
            $query = app()->db->where('Components_id', $Components_id);
            $query = app()->db->where('company_id', $company_id);
            $query = app()->db->where('Fields_id', $Fields_id);
            $query = app()->db->set('validating_rules', $data);
            $query = app()->db->update('portal_forms_fields_validation');

            if (app()->db->affected_rows()) {
                return true;
            } else {
                return false;
            }
    }

}
##############################################################################


# Rule validating Fields
####################################################################
if(!function_exists('validating_Fields_required')) {

    function validating_Fields_required($checkbox_required='')
    {


        $html   ='<div class="checkbox-inline mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" '.$checkbox_required.' id="required" value="required" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_required').'
                            </label>
                            <br>
                            <span class="form-text text-muted">'.lang('Rule_validating_Fields_description').'</span>
                     </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;

    }
}
####################################################################


####################################################################
if(!function_exists('validating_Fields_trim')) {

    function validating_Fields_trim($checkbox_trim='')
    {


        $html   ='<div class="checkbox-inline mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" '.$checkbox_trim.'  id="required" value="trim" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_trim').'
                            </label>
                            <br>
                            <span class="form-text text-muted"></span>
                     </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_matches_Fields')) {

    function validating_Fields_matches_Fields()
    {
        $html ='';
        $html .='
                   <script type="text/javascript">
                        $(document).ready(function() {
                            $("#matches").on("click", function(){
                                if($(this).is(":checked")){
                                    $("#matches_Fields").attr("disabled",false);
                                    $(".matches_Fields").fadeIn(300);
                                } else {
                                    $("#matches_Fields").attr("disabled",true);
                                    $(".matches_Fields").hide(300);
                                }
                            });
                         });
                    </script> ';
            
                   $html .='<div class="checkbox-list  mt-5">
                                        <label class="checkbox checkbox-primary">
                                            <input type="checkbox" id="matches" value="matches" name="validating[]"/>
                                            <span></span>
                                            '.lang('Rule_validating_Fields_matches').'
                                        </label>
                                        <br>
                                        <span class="form-text text-muted">'.lang('Rule_validating_Fields_matches_description').'</span>
                            </div>';

                   $html .='<div class="col-lg-12  matches_Fields mt-5" style="display: none">
                               <label>'.lang('Rule_validating_Fields_matches_Fields').'</label>
                               <input type="text" dir="ltr" direction="ltr" id="matches_Fields" name="matches_Fields" class="form-control" placeholder=""/>
                            </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;
    }
}
####################################################################

####################################################################
if(!function_exists('validating_regex_match')) {

    function validating_regex_match()
    {
        $html = '';

        $html .='
                   <script type="text/javascript">
                        $(document).ready(function() {
                                $("#regex_match").on("click", function(){
                                    if($(this).is(":checked")){
                                        $("#regex_match_value").attr("disabled",false);
                                        $(".match_regex").fadeIn(300);
                                    } else {
                                        $("#regex_match_value").attr("disabled",true);
                                        $(".match_regex").hide(300);
                                    }
                                });
                         });
                    </script> ';

        $html      .='<div class="checkbox-inline mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" id="regex_match" value="regex_match" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_regex_match').'
                            </label>
                            <br>
                            <span class="form-text text-muted">'.lang('Rule_validating_Fields_regex_match_description').'</span>
                          </div>';

        $html      .='<div class="form-group match_regex mt-5 row" style="display: none">
                                <div class="col-lg-12">
                                    <label>'.lang('Rule_validating_Fields_regex_match_regex').'</label>
                                    <input type="text" dir="ltr" direction="ltr" id="regex_match_value" name="regex_match_value" class="form-control" placeholder=""/>
                                </div>
                      </div>';

        $html .='<div class="separator mt-5 separator-dashed separator-border-2 separator-primary"></div>';
        return $html;
    }
}
####################################################################

# Returns FALSE if the form element is not unique to the table and field name in the parameter. Note: This rule requires Query Builder to be enabled in order to work.
####################################################################
if(!function_exists('validating_Fields_is_unique'))
{
    function validating_Fields_is_unique()
    {
        $html ='';


        $html      .='<div class="checkbox-inline mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" id="regex_match" value="regex_match" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_is_unique').'
                            </label>
                            <br>
                            <span class="form-text text-muted">'.lang('Rule_validating_Fields_is_unique').'</span>
                          </div>';


        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_min_length'))
{
    function validating_Fields_min_length()
    {
        $html = '';


        $html .='
                   <script type="text/javascript">
                        $(document).ready(function() {
                            $("#min_length").on("click", function(){
                                if($(this).is(":checked")){
                                    $("#min_length_value").attr("disabled",false);
                                    $(".min_length_value").fadeIn(300);
                                } else {
                                    $("#min_length_value").attr("disabled",true);
                                    $(".min_length_value").hide(300);
                                }
                            });
                         });
                    </script> ';


        $html      .='<div class="checkbox-inline mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" id="min_length" value="min_length" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_min_length').'
                            </label>
                          </div>';

        $html      .='<div class="form-group row min_length_value mt-5"  style="display: none">
                                <div class="col-lg-12 mt-5">
                                    <label>'.lang('Rule_validating_Fields_min_length_value').'</label>
                                    <input type="text" id="min_length_value" name="min_length_value" class="form-control" placeholder=""/>
                                </div>
                      </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;
    }
}
####################################################################

# Returns FALSE if the form element is longer than the parameter value.
####################################################################
if(!function_exists('validating_Fields_max_length'))
{
    function validating_Fields_max_length()
    {
        $html = '';

        $html .='
                   <script type="text/javascript">
                        $(document).ready(function() {
                                $("#max_length").on("click", function(){
                                    if($(this).is(":checked")){
                                        $("#max_length_value").attr("disabled",false);
                                        $(".max_length_value").fadeIn(300);
                                    } else {
                                        $("#max_length_value").attr("disabled",true);
                                        $(".max_length_value").hide(300);
                                    }
                                });
                         });
                    </script> ';


        $html      .='<div class="checkbox-inline   mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" id="max_length" value="max_length" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_max_length').'
                            </label>
                          </div>';

        $html      .='<div class="form-group max_length_value  mt-5 row" style="display: none">
                                <div class="col-lg-12 mt-5">
                                    <label>'.lang('Rule_validating_Fields_max_length_value').'</label>
                                    <input type="text" id="max_length_value" name="max_length_value" class="form-control" placeholder=""/>
                                </div>
                      </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;
    }
}
####################################################################

#Returns FALSE if the form element is not exactly the parameter value.
####################################################################
if(!function_exists('validating_Fields_exact_length'))
{
    function validating_Fields_exact_length()
    {
        $html = '';

        $html .='
                   <script type="text/javascript">
                        $(document).ready(function() {
                                $("#exact_length").on("click", function(){
                                    if($(this).is(":checked")){
                                        $("#exact_length_value").attr("disabled",false);
                                        $(".exact_length_value").fadeIn(300);
                                    } else {
                                        $("#exact_length_value").attr("disabled",true);
                                        $(".exact_length_value").hide(300);
                                    }
                                });
                         });
                    </script> ';


        $html      .='<div class="checkbox-inline   mt-5 ">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" id="exact_length" value="exact_length" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_exact_length').'
                            </label>
                          </div>';

        $html      .='<div class="form-group exact_length_value row mt-5"  style="display: none">
                                <div class="col-lg-12">
                                    <label>'.lang('Rule_validating_Fields_exact_length_value').'</label>
                                    <input type="text" id="exact_length_value" name="exact_length_value" class="form-control" placeholder=""/>
                                </div>
                      </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;
    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_greater_than'))
{
    function validating_Fields_greater_than()
    {
        $html = '';

        $html .='
                   <script type="text/javascript">
                        $(document).ready(function() {
                                $("#greater_than").on("click", function(){
                                    if($(this).is(":checked")){
                                        $("#greater_than_value").attr("disabled",false);
                                        $(".greater_than_value").fadeIn(300);
                                    } else {
                                        $("#greater_than_value").attr("disabled",true);
                                        $(".greater_than_value").hide(300);
                                    }
                                });
                         });
                    </script> ';


        $html      .='<div class="checkbox-inline mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" id="greater_than" value="greater_than" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_greater_than').'
                            </label>
                          </div>';

        $html      .='<div class="form-group greater_than_value row  mt-5"  style="display: none">
                                <div class="col-lg-6">
                                    <label>'.lang('Rule_validating_Fields_greater_than_value').'</label>
                                    <input type="text" id="greater_than_value" name="greater_than_value" class="form-control" placeholder=""/>
                                </div>
                      </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;
    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_greater_than_equal_to'))
{
    function validating_Fields_greater_than_equal_to()
    {
        $html = '';

        $html .='
                   <script type="text/javascript">
                        $(document).ready(function() {
                                $("#greater_than_equal_to").on("click", function(){
                                    if($(this).is(":checked")){
                                        $("#greater_than_equal_to_value").attr("disabled",false);
                                        $(".greater_than_equal_to_value").fadeIn(300);
                                    } else {
                                        $("#greater_than_equal_to_value").attr("disabled",true);
                                        $(".greater_than_equal_to_value").hide(300);
                                    }
                                });
                         });
                    </script> ';

        $html      .='<div class="checkbox-inline mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" id="greater_than_equal_to" value="greater_than_equal_to" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_greater_than_equal_to').'
                            </label>
                          </div>';

        $html      .='<div class="form-group row greater_than_equal_to_value  mt-5"  style="display: none">
                                <div class="col-lg-6">
                                    <label>'.lang('Rule_validating_Fields_greater_than_equal_to_value').'</label>
                                    <input type="text" id="greater_than_equal_to_value" name="greater_than_equal_to_value" class="form-control" placeholder=""/>
                                </div>
                      </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;
    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_less_than'))
{
    function validating_Fields_less_than()
    {
        $html = '';

        $html .='
                   <script type="text/javascript">
                        $(document).ready(function() {
                                $("#less_than").on("click", function(){
                                    if($(this).is(":checked")){
                                        $("#less_than_value").attr("disabled",false);
                                        $(".less_than").fadeIn(300);
                                    } else {
                                        $("#less_than_value").attr("disabled",true);
                                        $(".less_than").hide(300);
                                    }
                                });
                         });
                    </script> ';

        $html      .='<div class="checkbox-inline mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" id="less_than" value="less_than" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_less_than').'
                            </label>
                          </div>';

        $html      .='<div class="form-group row less_than  mt-5"  style="display: none">
                                <div class="col-lg-6 ">
                                    <label>'.lang('Rule_validating_Fields_less_than_value').'</label>
                                    <input type="text" id="less_than_value" name="less_than_value" class="form-control" placeholder=""/>
                                </div>
                      </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;
    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_less_than_equal_to'))
{
    function validating_Fields_less_than_equal_to()
    {
        $html = '';

        $html .='
                   <script type="text/javascript">
                        $(document).ready(function() {
                                $("#less_than_equal_to").on("click", function(){
                                    if($(this).is(":checked")){
                                        $("#less_than_equal_to_value").attr("disabled",false);
                                        $(".less_than_equal_to_value").fadeIn(300);
                                    } else {
                                        $("#less_than_equal_to_value").attr("disabled",true);
                                        $(".less_than_equal_to_value").hide(300);
                                    }
                                });
                         });
                    </script> ';


        $html      .='<div class="checkbox-inline  mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" id="less_than_equal_to" value="less_than_equal_to" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_less_than_equal_to').'
                            </label>
                          </div>';

        $html      .='<div class="form-group less_than_equal_to_value row mt-5 " style="display: none">
                                <div class="col-lg-12">
                                    <label>'.lang('Rule_validating_Fields_less_than_equal_to_value').'</label>
                                    <input type="text" id="less_than_equal_to_value" name="less_than_equal_to_value" class="form-control" placeholder=""/>
                                </div>
                      </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;
    }
}
####################################################################


####################################################################
if(!function_exists('validating_Fields_numeric')) {

    function validating_Fields_numeric()
    {
        $html = '';

        $html   ='<div class="checkbox-inline  mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" value="numeric" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_numeric').'
                            </label>
                     </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_integer')) {

    function validating_Fields_integer()
    {
        $html   ='<div class="checkbox-inline mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" value="integer" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_integer').'
                            </label>
                     </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_decimal')) {

    function validating_Fields_decimal()
    {
        $html   ='<div class="checkbox-inline mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" value="decimal" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_decimal').'
                            </label>
                     </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_is_natural')) {

    function validating_Fields_is_natural()
    {
        $html   ='<div class="checkbox-inline mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" value="is_natural" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_is_natural').'
                            </label>
                     </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_is_natural_no_zero')) {

    function validating_Fields_is_natural_no_zero()
    {
        $html   ='<div class="checkbox-inline mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" value="is_natural_no_zero" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_is_natural_no_zero').'
                            </label>
                     </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_valid_url')) {

    function validating_Fields_valid_url()
    {
        $html   ='<div class="checkbox-inline mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" value="valid_url" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_valid_url').'
                            </label>
                     </div>';

        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_valid_email')) {

    function validating_Fields_valid_email()
    {
        $html   ='<div class="checkbox-inline mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" value="valid_email" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_valid_email').'
                            </label>
                     </div>';
        $html .='<div class="separator  mt-5 separator-dashed separator-border-2 separator-primary"></div>';

        return $html;

    }
}
####################################################################

