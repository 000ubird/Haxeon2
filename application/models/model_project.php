<?php

class Model_project extends CI_Model{

    //データベースにプロジェクト名があったらtrueを返す
    public function isProjectName(){
        $this->db->where(array('projectName' => $this->input->post('projectName'), 'ownerUserID' => $_SESSION['userID']));
        $query = $this->db->get('project');

        if($query->num_rows() == 1){
            return true;
        }else{
            return false;
        }
    }
}
