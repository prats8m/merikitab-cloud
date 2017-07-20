<?php
header('Access-Control-Allow-Origin', '*');
// error_reporting(0);
class School extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');
    $this->load->model('customer_model',"cm");
    $this->load->model('general_model',"gm");
    $this->load->model('school_model',"sm");
    $this->load->helper('url', 'form');
  }

public function list_school($index){
    $limit=$this->config->item('number_of_school_in_one_view');
    $offset=($index-1)*$this->config->item('number_of_school_in_one_view');
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $where = "";
    $i=0;
    if(count($data['city'])){
        foreach ($data['city'] as $key => $item) {
            if(count($data['city']) == $key+1){
                $where = $where."`school_city` = '".$item."' ";
            }
            else{
                $where = $where."`school_city` = '".$item."' AND ";
            }
            $i++;
        }
    }
    else{
        $where = $where."`school_city` LIKE '%%' ";
    }
    
    $where = $where."AND ";
    if(count($data['type'])){
        foreach ($data['type'] as $key => $item) {
            if(count($data['type']) == $key+1){
                $where = $where."`school_type`='".$item."'";
            }
            else{
                $where = $where."`school_type`='".$item."' AND ";
            }
            $i++;
        }
    }
    else{
        $where = $where."`school_type` LIKE '%%' ";
    }

    $response = $this->sm->list_school($where);
    $this->gm->send_response(true,"Success",$response,'');
}


public function list_school_filter(){
    $where = [];
    $response = $this->sm->list_school($where);
    foreach($response as $key => $item){
        $result[$key]['school_id'] = $item['school_id'];
        $result[$key]['school_name'] = $item['school_name'];
    }
    $this->gm->send_response(true,"Success",$result,'');
}
}