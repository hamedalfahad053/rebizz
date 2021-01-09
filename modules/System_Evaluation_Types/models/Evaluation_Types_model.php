<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation_Types_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    ########################################################################
    function Get_All_Evaluation_Types($Evaluation_Types_id='')
    {
        $this->db->from('portal_evaluation_types             evaluation_types');
        $this->db->join('portal_evaluation_types_translation translation', 'evaluation_types.evaluation_types_id=translation.item_id');

        $lang   = get_current_lang();
        $this->db->where('translation.translation_lang',$lang);

        if(!empty($Evaluation_Types_id)){
            $this->db->where('evaluation_types.evaluation_types_id',$Evaluation_Types_id);
        }

        $query = $this->db->get();

        return $query;

    }
    ########################################################################



    ########################################################################
    function Create_Evaluation_Types($data)
    {
        $query = $this->db->insert('portal_evaluation_types',$data);

        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }

    }
    ########################################################################

}
