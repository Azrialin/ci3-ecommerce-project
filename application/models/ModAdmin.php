<?php

class ModAdmin extends CI_Model
{
    public function checkAdmin($data)
    {
        return $this->db->get_where('admin', $data)
                    ->result_array();
        
    }
}