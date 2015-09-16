<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CI_Controller {

    function __construct(){
        parent::__construct();
    }

    public function imageMaker($data){
        $this->load->library('image_lib');

        $config['image_library'] = 'gd2';
        $config['source_image'] = './img/'. $data['filename'];
    }
}
