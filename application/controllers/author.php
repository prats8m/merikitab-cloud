<?php
header('Access-Control-Allow-Origin', '*');
// error_reporting(0);
class Author extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');
    $this->load->model('general_model',"gm");
    $this->load->model('author_model',"am");
    $this->load->helper('url', 'form');
  }

public function list_author(){
    $where = [];
    $response = $this->am->list_author($where);
    foreach($response as $key => $item){
        $result[$key]['author_id'] = $item['author_id'];
        $result[$key]['author_name'] = $item['author_name'];
    }
    $this->gm->send_response(true,"Success",$result,'');
}
}