<?php
header('Access-Control-Allow-Origin', '*');
// error_reporting(0);
class City extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');
    $this->load->model('general_model',"gm");
    $this->load->model('city_model',"cm");
    $this->load->helper('url', 'form');
  }

public function list_city(){
    $where = [];
    $response = $this->cm->list_city($where);
    foreach($response as $key => $item){
        $result[$key]['city_id'] = $item['city_id'];
        $result[$key]['city_name'] = $item['city_name'];
    }
    $this->gm->send_response(true,"Success",$result,'');
}
}