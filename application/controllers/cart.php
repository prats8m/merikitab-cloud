<?php
header('Access-Control-Allow-Origin', '*');
// error_reporting(0);
class Cart extends CI_Controller {


  public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');
    $this->load->model('cart_model',"cm");
    $this->load->model('general_model',"gm");
    $this->load->model('book_model',"bm");
    $this->load->helper('url', 'form');
  }

  public function add_to_cart(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $is_logged_in=$this->session->all_userdata();
    if($user_id = $is_logged_in['id']){
        $product_id = $data['product_id'];
        $product_type = $data['product_type'];
        
        //check if product already exist in the cart or not
        $where = array('product_id'=>$product_id,'product_type'=>$product_type,'user_id'=>$user_id);
        $cart_detail = $this->cm->select_cart($where);

        if($cart_detail){
            $update_data = array(
                'quantity' => $cart_detail['quantity']+1,
                'totalprice' => ($cart_detail['quantity']+1)*$cart_detail['subprice'],
                'updated_on' => time()
            );
            $this->cm->update_cart($where,$update_data);
            $this->gm->send_response(true,"Success","","");    
        } 
        else{
        switch($product_type){
            case 1: {
                $select = ['book_discount_status','book_discount','book_price'];
                $where = array('book_id'=>$product_id);
                $product_detail = $this->bm->select_book($select,$where);
                if($product_detail['book_discount_status']){
                    $product_detail['book_price'] = $product_detail['book_price']-($product_detail['book_price'] * ($product_detail['book_discount']/100)); 
                }
                $insert_data = array(
                    'user_id'=> $is_logged_in['id'],
                    'product_id' => $product_id,
                    'product_type' => $product_type,
                    'quantity' => 1,
                    'subprice' => $product_detail['book_price'],
                    'totalprice' => $product_detail['book_price'],
                    'added_on' => time(),
                    'updated_on' => time()
                );
            }
            break;
        }
        
        $this->cm->add_to_cart($insert_data);
        $this->gm->send_response(true,"Success","","");
    }
    }
    else{
        $this->gm->send_response(false,"Logged_out","","");
    }
  }



  public function delete_cart(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $cart_id = $data['cart_id'];
    $is_logged_in=$this->session->all_userdata();
    if($user_id = $is_logged_in['id']){
        $this->cm->delete_cart($cart_id);
        $this->gm->send_response(true,"Removed From Cart","","");
    }
    else{
        $this->gm->send_response(false,"Logged_out","","");
    }  
  }


  public function empty_cart(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $cart_id = $data['cart_id'];
    $is_logged_in=$this->session->all_userdata();
    if($user_id = $is_logged_in['id']){
        $this->cm->empty_cart($user_id);
        $this->gm->send_response(true,"Your Cart is empty now","","");
    }
    else{
        $this->gm->send_response(false,"Logged_out","","");
    } 
  }


  public function edit_cart(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $cart_id = $data['cart_id'];
    $quantity = $data['quantity'];
    $subprice = $data['subprice'];
    $is_logged_in=$this->session->all_userdata();
    if($uesr_id = $is_logged_in['id']){
        $select = ['quantity','subprice'];
        $where = array(
            'cart_id' => $cart_id
        );

        $update_data = array(
            'quantity' => $quantity,
            'totalprice' => $quantity*$subprice
        );

        $this->cm->update_cart($where, $update_data);
        $this->gm->send_response(true,"Your Cart is e+mpty now","","");
    }
    else{
        $this->gm->send_response(false,"Logged_out","","");
    }
  }



  public function signup(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $email = $data['email'];
    $name = $data['school_name'];
    $password = md5($data['password']);
    $address = $data['school_address'];
    $mobile = $data['mobiel'];
    $number_of_student = $data['number_of_student'];
    $number_of_teacher = $data['number_of_teacher'];
    $select = ['school_email'];
    $where = array(
        'school_email'=>$email
    );

    $response = $this->um->select_school($select,$where);
    if(count($response)){
        echo "school email already exist";
    }
    else{
       $where = array(
        'school_name'=>$name
    );
    $response = $this->um->select_school($select,$where);
    if(count($response)){
        echo "school name already exist";
    }
    else{
        $insert_data = array(
            'school_email'=>$email,
            'school_name'=>$name,
            'school_password'=>$password,
            'school_mobile'=>$mobile,
            'school_address'=>$address,
            'number_of_student'=>$number_of_student,
            'number_of_teacher'=>$number_of_teacher
        );

        $this->um->insert_school($insert_data);
        echo "Signup Successful";
    }
    }

  }
}

?>