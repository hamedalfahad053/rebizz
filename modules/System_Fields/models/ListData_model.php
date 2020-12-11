<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ListData_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }

    ########################################################################
    function Cet_All_List()
    {
        $this->db->from('portal_list_data list');
        $this->db->join('portal_list_data_translation  list_translation', 'list.list_id=list_translation.item_id');
        $lang   = get_current_lang();
        $this->db->where('list_translation.translation_lang',$lang);
        $query = $this->db->get();
        return $query;

    }
    ########################################################################


    ########################################################################
    function Create_List($data)
    {
        $query = $this->db->insert('portal_list_data',$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    ########################################################################

    ########################################################################
    function Create_options_List($data)
    {
        $query = $this->db->insert('portal_list_options_data',$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    ########################################################################


}
