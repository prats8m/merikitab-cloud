<?php
header('Access-Control-Allow-Origin', '*');
// error_reporting(0);
class Customer extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');
    $this->load->model('customer_model',"cm");
    $this->load->model('general_model',"gm");
    $this->load->helper('url', 'form');
  }


public function signup(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    //check if email exist or not
    $select=array('customer_email','customer_mobile');
    $where=array();
    $customer=$this->cm->select_customer($select,$where);
    $count=count($customer);
    
    for($i=0;$i<$count;$i++){
        if($customer[$i]['customer_email']==$data['customer_email']){
            $this->gm->send_response(false,"Email Already Exist",'','');
        }
        if($customer[$i]['customer_mobile']==$data['customer_mobile']){ 
            $this->gm->send_response(false,"Mobile Number Already Exist",'','');
        }
    }

    //bind data to put in db
    $data['customer_added_on']=time();
    $data['customer_password']=md5($data['customer_password']);
    $data['customer_last_login']=time();

    //unset the useless data
    unset($data['customer_confirm_password']);

    $this->cm->add_customer($data);

    $this->gm->send_response(true,"Welcome To ApNi KitaAb",'','');

}


public function login(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $select=array('customer_email','customer_password','customer_name');
    $where=array('customer_email'=>$data['customer_email'],'customer_password'=>md5($data['customer_password']));
    $customer=$this->cm->select_customer($select,$where);
    if(count($customer)){
        $sesssion_data = array(
        'customer_email'  => $customer[0]['customer_email'],
        'id'     => $customer[0]['customer_id'],
        'customer_name'=>$customer[0]['customer_name'],
        );
      $this->session->set_userdata($sesssion_data);
        $this->gm->send_response(true,"Login Successfully",'','');
    }else{
        $this->gm->send_response(false,"Wrong Email OR Password",'','');
    }
}

  public function is_logged_in(){
    $is_logged_in=$this->session->all_userdata();
    $this->gm->send_response(True,"Is Logged In Status",$is_logged_in,'');
  }


  public function logout(){
    $this->session->sess_destroy();
    $this->gm->send_response(True,"Logout Successfully",'','');
  }
}