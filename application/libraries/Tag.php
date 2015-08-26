<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag {

    public function getTag($projectID)
    {
        $CI =& get_instance();

        $CI->load->model('model_project');

        $ids = $CI->model_project->getTagID($projectID);
        $tags = array();

        foreach($ids as $id){
            array_push($tags, $CI->model_project->getTag($id));
        }

        return $tags;
    }


}
