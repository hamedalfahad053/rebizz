<?php

# Rule validating Fields

####################################################################
if(!function_exists('validating_Fields_required')) {

    function validating_Fields_required()
    {
        $html   ='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="required" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_required').'
                            </label>
                     </div>';
        return $html;

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_matches_Fields')) {

    function validating_Fields_matches_Fields()
    {
        $html ='';

        $html        .='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="matches" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_matches').'
                            </label>
                          </div>';

        $html        .='<div class="form-group row">
                                <div class="col-lg-6 mt-5">
                                    <label>'.lang('Rule_validating_Fields_matches_Fields').'</label>
                                    <input type="text" name="matches_Fields" class="form-control" placeholder=""/>
                                </div>
                            </div>';

        return $html;
    }
}
####################################################################

####################################################################
if(!function_exists('validating_regex_match')) {

    function validating_regex_match()
    {
        $html = '';
        $html      .='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="regex_match" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_regex_match').'
                            </label>
                          </div>';

        $html      .='<div class="form-group row">
                                <div class="col-lg-6 mt-5">
                                    <label>'.lang('Rule_validating_Fields_regex_match_regex').'</label>
                                    <input type="text" name="match_regex" class="form-control" placeholder=""/>
                                </div>
                      </div>';

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

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_min_length'))
{
    function validating_Fields_min_length()
    {
        $html = '';
        $html      .='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="min_length" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_min_length').'
                            </label>
                          </div>';

        $html      .='<div class="form-group row">
                                <div class="col-lg-6 mt-5">
                                    <label>'.lang('Rule_validating_Fields_min_length_value').'</label>
                                    <input type="text" name="min_length_value" class="form-control" placeholder=""/>
                                </div>
                      </div>';

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
        $html      .='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="max_length" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_max_length').'
                            </label>
                          </div>';

        $html      .='<div class="form-group row">
                                <div class="col-lg-6 mt-5">
                                    <label>'.lang('Rule_validating_Fields_max_length_value').'</label>
                                    <input type="text" name="max_length_value" class="form-control" placeholder=""/>
                                </div>
                      </div>';

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
        $html      .='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="exact_length" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_max_length').'
                            </label>
                          </div>';

        $html      .='<div class="form-group row">
                                <div class="col-lg-6 mt-5">
                                    <label>'.lang('Rule_validating_Fields_max_length_value').'</label>
                                    <input type="text" name="exact_length_value" class="form-control" placeholder=""/>
                                </div>
                      </div>';

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
        $html      .='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="greater_than" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_greater_than').'
                            </label>
                          </div>';

        $html      .='<div class="form-group row">
                                <div class="col-lg-6 mt-5">
                                    <label>'.lang('Rule_validating_Fields_greater_than_value').'</label>
                                    <input type="text" name="greater_than_value" class="form-control" placeholder=""/>
                                </div>
                      </div>';

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
        $html      .='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="greater_than_equal_to" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_greater_than_equal_to').'
                            </label>
                          </div>';

        $html      .='<div class="form-group row">
                                <div class="col-lg-6 mt-5">
                                    <label>'.lang('Rule_validating_Fields_greater_than_equal_to_value').'</label>
                                    <input type="text" name="greater_than_equal_to_value" class="form-control" placeholder=""/>
                                </div>
                      </div>';

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
        $html      .='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="less_than" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_less_than').'
                            </label>
                          </div>';

        $html      .='<div class="form-group row">
                                <div class="col-lg-6 mt-5">
                                    <label>'.lang('Rule_validating_Fields_less_than_value').'</label>
                                    <input type="text" name="less_than_value" class="form-control" placeholder=""/>
                                </div>
                      </div>';

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
        $html      .='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="less_than_equal_to" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_less_than_equal_to').'
                            </label>
                          </div>';

        $html      .='<div class="form-group row">
                                <div class="col-lg-6 mt-5">
                                    <label>'.lang('Rule_validating_Fields_less_than_equal_to_value').'</label>
                                    <input type="text" name="less_than_equal_to_value" class="form-control" placeholder=""/>
                                </div>
                      </div>';

        return $html;
    }
}
####################################################################


####################################################################
if(!function_exists('validating_Fields_numeric')) {

    function validating_Fields_numeric()
    {
        $html = '';

        $html   ='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="numeric" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_numeric').'
                            </label>
                     </div>';
        return $html;

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_integer')) {

    function validating_Fields_integer()
    {
        $html   ='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="integer" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_integer').'
                            </label>
                     </div>';
        return $html;

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_decimal')) {

    function validating_Fields_decimal()
    {
        $html   ='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="decimal" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_decimal').'
                            </label>
                     </div>';
        return $html;

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_is_natural')) {

    function validating_Fields_is_natural()
    {
        $html   ='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="is_natural" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_is_natural').'
                            </label>
                     </div>';
        return $html;

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_is_natural_no_zero')) {

    function validating_Fields_is_natural_no_zero()
    {
        $html   ='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="is_natural_no_zero" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_is_natural_no_zero').'
                            </label>
                     </div>';
        return $html;

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_valid_url')) {

    function validating_Fields_valid_url()
    {
        $html   ='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="valid_url" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_valid_url').'
                            </label>
                     </div>';
        return $html;

    }
}
####################################################################

####################################################################
if(!function_exists('validating_Fields_valid_email')) {

    function validating_Fields_valid_email()
    {
        $html   ='<div class="checkbox-inline">
                            <label class="checkbox checkbox-success">
                                <input type="checkbox" value="valid_email" name="validating[]"/>
                                <span></span>
                                '.lang('Rule_validating_Fields_valid_email').'
                            </label>
                     </div>';
        return $html;

    }
}
####################################################################

