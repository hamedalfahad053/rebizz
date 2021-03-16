<?php
class System_Forms_Model extends MY_Model
{

    ########################################################################
    public function __construct()
    {
        parent::__construct();
    }
    ########################################################################


    ########################################################################
    function Create_Forms($data)
    {
        $query = $this->db->insert('portal_forms',$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    ########################################################################


    ########################################################################
    function Create_Forms_Components($data)
    {
        $query = $this->db->insert('portal_forms_components',$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    ########################################################################

    ########################################################################
    function Deleted_Sections_Forms_Components($Forms_id,$Components_id)
    {
        $this->db->where('Forms_id',$Forms_id);
        $this->db->where('components_id',$Components_id);

        $data_update = array(
            "components_isDeleted"=>1,
            "components_DeletedBy"=>1
        );

        $query = $this->db->update('portal_forms_sections_components',$data_update);

        if($query){
            return true;
        }else{
            return false;
        }
    }
    ########################################################################

    ########################################################################
    function Create_Fields_Form_Components($data)
    {
        $query = $this->db->insert('portal_forms_components_fields',$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    ########################################################################

    ########################################################################
    function Deleted_Fields_To_Sections_Form_Components($data)
    {
        $Forms_id      = $data['Forms_id'];
        $Components_id = $data['Components_id'];
        $Fields_id     = $data['Fields_id'];

        $this->db->where('Forms_id',$Forms_id);
        $this->db->where('Components_id',$Components_id);
        $this->db->where('Fields_id',$Fields_id);
        $query = $this->db->delete('portal_forms_sections_components_fields',$data);

        if($query){
            return true;
        }else{
            return false;
        }
    }
    ########################################################################







    ########################################################################
    function Get_All_Forms()
    {
        $this->db->from('portal_auth_users  Users');
        $this->db->join('portal_auth_user_to_group Groups_Users', 'Users.id=Groups_Users.user_id');
        $this->db->join('portal_auth_groups_translation  Groups_Translation', 'Groups_Users.group_id=Groups_Translation.item_id');

        $lang   = get_current_lang();
        $this->db->where('Groups_Translation.translation_lang',$lang);

        $query = $this->db->get();

        return $query;
    }
    ########################################################################





}