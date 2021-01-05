<?php


##############################################################################
if(!function_exists('Get_Fields'))
{

    function Get_Fields($Fields_id='')
    {
        app()->load->database();

        $lang   = get_current_lang();

        $query_Fields = app()->db->from('portal_fields  fields');
        $query_Fields = app()->db->join('portal_fields_translation  fields_translation', 'fields.Fields_id=fields_translation.item_id');

        if(!empty($Fields_id)){
            $query_Fields = app()->db->where('fields.Fields_id',$Fields_id);
            $query_Fields = app()->db->or_where('fields.Fields_key',$Fields_id);
        }

        $query_Fields = app()->db->where('fields_translation.translation_lang',$lang);
        $query_Fields = app()->db->get();
        return $query_Fields;
    }

}
##############################################################################

##############################################################################
if(!function_exists('Get_Fields_By_Status'))
{

    function Get_Fields_By_Status($Fields_id='')
    {
        app()->load->database();

        $lang   = get_current_lang();

        $query_Fields = app()->db->from('portal_fields  fields');
        $query_Fields = app()->db->join('portal_fields_translation  fields_translation', 'fields.Fields_id=fields_translation.item_id');

        if(!empty($Fields_id)){
            $query_Fields = app()->db->where('fields.Fields_id',$Fields_id);
            $query_Fields = app()->db->or_where('fields.Fields_key',$Fields_id);
        }

        $query_Fields = app()->db->where('fields.Fields_status_Fields',1);
        $query_Fields = app()->db->where('fields_translation.translation_lang',$lang);
        $query_Fields = app()->db->get();
        return $query_Fields;
    }

}
##############################################################################

##############################################################################
if(!function_exists('Creation_Field')) {

    function  Creation_Field_HTML_input($Fields_key = '')
    {
        app()->load->database();

        $class_plugin = '';
        $lang   = get_current_lang();

        $query_Fields = app()->db->from('portal_fields  fields');
        $query_Fields = app()->db->join('portal_fields_translation  fields_translation', 'fields.Fields_id=fields_translation.item_id');
        $query_Fields = app()->db->where('fields.Fields_id',$Fields_key);
        $query_Fields = app()->db->or_where('fields.Fields_key',$Fields_key);

        $query_Fields = app()->db->where('fields_translation.translation_lang',$lang);
        $query_Fields = app()->db->get()->row();

        $html = '';

        if($query_Fields->Fields_Type_Fields == 'date'){
            $class_plugin .= ' datepicker  "';
        }



        $html .= '<label>  '.$query_Fields->item_translation.' </label>';
        $html .= '<div class="col-lg-12 col-md-12 col-sm-12">';
        $html .= '<input type="text" name="'.$query_Fields->Fields_key.'" class="form-control" placeholder="'.$query_Fields->item_translation.'"/>';
        $html .= '</div>';

        return $html;
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
            "date"     => "تاريخ",
            "email"    => "بريد الكتروني",
            "file"     => "تحميل ملف",
            "number"   => "ارقام",
            "number_list" => "ترقيم 10 ",
            "time"     => "وقت",
            "url"      => "رابط",
            "tel"     => "رقم هاتف",
        );
        return $Type_Fields;
    }

}
####################################################################



# Rule validating Fields
####################################################################
if(!function_exists('validating_Fields_required')) {

    function validating_Fields_required()
    {


        $html   ='<div class="checkbox-inline mt-5">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" id="required" value="required" name="validating[]"/>
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

