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

public function list_class($index){
    $limit  = $this->config->item('number_of_author_in_one_list');
        $offset = ($index - 1) * $this->config->item('number_of_author_in_one_list');
        if ($index == 0) {
            $limit  = 10000;
            $offset = 0;
        }
        // echo $limit;
        // echo $offset;
        $response_data  = $this->cm->list_class($limit, $offset);
        // die;
        $response_count = $this->cm->count_class();
        if ($index == 0) {
            for ($i = 0; $i < count($response_data); $i++) {
                $response[$i]['class_id']   = $response_data[$i]['class_id'];
                $response[$i]['class_name'] = $response_data[$i]['class_name'];
            }
        }
        if ($index == 0) {
            $result['data'] = $response;
        } else {
            $result['data'] = $response_data;
        }
        $result['count'] = $response_count;
        
        $this->gm->send_response(true, "List of Classes", $result, '');
}


}