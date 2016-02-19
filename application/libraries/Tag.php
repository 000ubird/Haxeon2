<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag {

    public function getTag($projectID)
    {
        $CI =& get_instance();

        $CI->load->model('ModelProject');

        $ids = $CI->ModelProject->getTagIDs($projectID);
        $tags = array();

        foreach($ids as $id){
            array_push($tags, $CI->ModelProject->getTag($id));
        }

        return $tags;
    }


}
