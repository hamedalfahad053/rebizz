<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fields_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }



    ########################################################################
    function Get_Fields_Type()
    {
        $this->db->from('portal_form_input_type  input_type');
        $this->db->join('portal_form_input_type_translation   type_translation', 'input_type.input_type_id = type_translation.item_id');
        $lang   = get_current_lang();
        $this->db->where('type_translation.translation_lang',$lang);
        $query = $this->db->get();
        return $query;
    }
    ########################################################################

    ########################################################################
    function Get_Fields_Type_Active()
    {
        $this->db->from('portal_form_input_type  input_type');
        $this->db->join('portal_form_input_type_translation   type_translation', 'input_type.input_type_id = type_translation.item_id');
        $lang   = get_current_lang();
        $this->db->where('input_type.input_type_status',1);
        $this->db->where('type_translation.translation_lang',$lang);
        $query = $this->db->get();
        return $query;
    }
    ########################################################################



    ########################################################################
    function Create_Fields_Type($data)
    {
        $query = $this->db->insert('portal_form_input_type',$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    ########################################################################


}
