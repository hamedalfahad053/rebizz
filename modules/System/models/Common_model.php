<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model
{
	public function add($table,$data)
	{
		$query = $this->db->insert($table,$data);
		return TRUE;
	}

    public function add_return_id($table,$data)
    {
        $query = $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

	public function select($table)
	{
		$query = $this->db->get($table);
		return $query->result();
	}

    public function get_count_data($table)
    {
        $query = $this->db->get($table);
        return $query->num_rows();
    }

	public function update_data($id,$table)
	{
		$this->db->where($id);
		$query = $this->db->get($table);
		return $query->row();
	}

	public function update($id,$data,$table)
	{
		if (empty($id)) return FALSE;
        $this->db->where($id);
		$this->db->update($table, $data, $id);
		return TRUE;
	}

	public function delete($id,$table)
	{
		$this->db->where($id);
		$this->db->delete($table);
		return TRUE;
	}

    public function join_table_translate($where_extra,$select,$language,$table_option,$table_translate,$limit,$order)
    {
        if(!empty($select)):
            $this->db->select($select);
        else:
            $this->db->select('*');
        endif;

        // if Order
        if (!empty($order)):
            $this->db->order_by($order);
        endif;

        if (!empty($limit)):
            $this->db->limit($limit);
        endif;

        $this->db->from($table_option.' TABLE_OPTION');
        $this->db->join($table_translate.' TABLE_TRANSLATE', 'TABLE_OPTION.id_item = TABLE_TRANSLATE.id_item','out left');
        $this->db->where('TABLE_TRANSLATE.language',$language);
        $this->db->where('TABLE_OPTION.Available',1);

        if(!empty($where_extra)):
            $this->db->where($where_extra);
        endif;

        $query = $this->db->get();

        return $query->result();

        $query->free_result();

    }


	function getAllData($table,$specific='',$Where='',$order='',$limit='',$groupBy='')
	{
		// If Condition
		if (!empty($Where)):
			$this->db->where($Where);
		endif;
		// If Specific Columns are require
		if (!empty($specific)):
			$this->db->select($specific);
		else:
			$this->db->select('*');
		endif;

		if (!empty($groupBy)):
			$this->db->group_by($groupBy);
		endif;
		// if Order
		if (!empty($order)):
			$this->db->order_by($order);
		endif;
		// if limit
		if (!empty($limit)):
			$this->db->limit($limit);
		endif;
		// get Data
		$GetData = $this->db->get($table);

		return $GetData;
	}
}
