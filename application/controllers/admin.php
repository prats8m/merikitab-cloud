<?php
header('Access-Control-Allow-Origin', '*');
// error_reporting(0);
class Admin extends CI_Controller {


  public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');
    $this->load->model('admin_model',"am");
    $this->load->model('general_model',"gm");
    $this->load->helper('url', 'form');
  }

  public function add_admin(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json

  }

  public function admin_login(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $response=$this->am->admin_login($data);
    if(count($response)){
      $sesssion_data = array(
        'username'  => $response['admin_name'],
        'id'     => $response['admin_id'],
        'role' => $response['admin_role'],
        'last_login'=>date('d-m-Y g:i a',$response['admin_last_login'])
      );
      $this->session->set_userdata($sesssion_data);
      $this->am->inc_login_count($response['admin_id']);
      $this->gm->send_response(true,"Login Successfully",$response,'');
    }
    else{
      $this->gm->send_response(false,"Invalid Login Credential",$response,'');
    }
  }


  public function admin_logout(){
    $this->session->sess_destroy();
    $this->gm->send_response(True,"Logout Successfully",'','');
  }

  public function is_logged_in(){
    $is_logged_in=$this->session->all_userdata();
    // echo count($is_logged_in['user_data']);
    // print_r($is_logged_in);
    $this->gm->send_response(True,"Is Logged In Status",$is_logged_in,'');
  }
  }

?>
