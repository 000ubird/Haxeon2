<?php

class Model_users extends CI_Model{

    public function can_log_in(){
        $this->db->where(array('userID' => $this->input->post("userID"), 'userPass' => $this->input->post("password")));
        $query = $this->db->get('account');

        if($query->num_rows() == 1){
            return true;
        }else{
            return false;
        }
    }
}
