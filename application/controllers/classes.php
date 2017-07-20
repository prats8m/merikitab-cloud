<?php
header('Access-Control-Allow-Origin', '*');
// error_reporting(0);
class Classes extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');
    $this->load->model('general_model',"gm");
    $this->load->model('class_model',"cm");
    $this->load->helper('url', 'form');
  }

public function list_class_filter(){
    $where = [];
    $response = $this->cm->list_class($where);
    foreach($response as $key => $item){
        $result[$key]['class_id'] = $item['class_id'];
        $result[$key]['class_name'] = $item['class_name'];
    }
    $this->gm->send_response(true,"Success",$result,'');
}
}