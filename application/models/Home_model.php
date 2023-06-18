<?php
class Home_model extends CI_Model
{
    public function get_masjid()
    {
        $query =$this->db->get('tb_masjid');
        return $query->result_array();
    }
    
    public function get_masjid_byid($id)
    {
        $query =$this->db->get_where('tb_masjid', ['id_masjid' => $id]);
        return $query->result_array();
    }

    public function get_dok($id)
    {
        $query =$this->db->get_where('tb_dokumentasi', ['id_masjid' => $id]);
        return $query->result_array();
    }
}

