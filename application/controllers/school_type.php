<?php
header('Access-Control-Allow-Origin', '*');
// error_reporting(0);
class School_type extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');
    $this->load->model('general_model',"gm");
    $this->load->model('school_type_model',"stm");
    $this->load->helper('url', 'form');
  }

public function list_school_type(){
    $where = [];
    $response = $this->stm->list_school_type($where);
    foreach($response as $key => $item){
        $result[$key]['st_id'] = $item['st_id'];
        $result[$key]['st_name'] = $item['st_name'];
    }
    $this->gm->send_response(true,"Success",$result,'');
}
}