<?php
header('Access-Control-Allow-Origin', '*');
// error_reporting(0);
class Admin_book extends CI_Controller {
 

  public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->config();
    $this->load->model('s3_model');
    $this->load->model("general_model",'gm');
    $this->load->model('admin_book_model','abm');
    $this->load->helper('url', 'form');
  }



public function upload_book_pic(){
    
      $file = $_FILES['file'];
      if($file){

      $book_id = $this->input->post('book_id');
      $is_uploaded=$this->upload_files($file,$book_id);
        if($is_uploaded['status'])
        {
            $update_data = array(
            'book_id' => $book_id,
            'book_pic'=>$is_uploaded['path']
            );
        $msg         = "<strong>" . $session_data['username'] . "<strong>" . " added book pic " . $data['name'];
        $this->gm->add_notification($msg);
        $response = $this->abm->edit_book($update_data);
        $this->gm->send_response(true, 'success','','');
        }
        else
        {
            $this->gm->send_response(false, 'Some Error Occured','','');
        }
      }
      die; 
    }
    
    public function upload_files($file,$book_id)
    {
        
            if (!isset($file)) {
                return array(
                    'status' => false,
                    'error' => 'Please upload the file',
                    'file' => $file
                );
            }
            if ($file['name'] != '' and $file['size'] > 0) {
                
                $name       = $file['name'];
                $path_parts = pathinfo($name);
                $ext = strtolower($path_parts["extension"]);
                
                
                $bucket_name = $this->config->config['bucket_name'];
                $image_name  = 'book_' .$book_id. '_'. time() . '.' . $ext;
                
                $quality         = $this->config->config['image_compression_quality'];
                $source_url      = $file["tmp_name"];
                $destination_url = $this->config->config['school_temp_image_path']  . '/mkschool/school_' .$book_id. '.' . $ext;
                $info            = getimagesize($source_url);
                if ($info['mime'] == 'image/jpeg')
                    $image = imagecreatefromjpeg($source_url);
                elseif ($info['mime'] == 'image/gif')
                    $image = imagecreatefromgif($source_url);
                elseif ($info['mime'] == 'image/png')
                    $image = imagecreatefrompng($source_url);
                imagejpeg($image, $destination_url, $quality);
                  
                try {
                    $object_name = $this->s3_model->create_object($bucket_name,'book', $image_name,$file["tmp_name"], $file['type']);
                    unlink($destination_url);
                }
                
                catch (Exception $e) {
                    return array(
                        'status' => false,
                        'error' => $e->getMessage(),
                        'file' => $file
                    );
                    
                }
                
                $file_name= $object_name;
            } else {
                return array(
                    'status' => false,
                    'error' => 'Please upload the valid file',
                    'file' => $file
                );
            }
        
        return array(
            'status' => true,
            'path' => $file_name
        );
    }

  public function add_book(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $session_data=$this->session->all_userdata();
    if($session_data['id']==null){
      $this->gm->send_response(false,"Session Expired",'','');
    }

    if($role==3){
      $this->gm->send_response(false,"Permission Denied",'','');
    }

    $check_data=array(
        'book_name'=>$data['book_name'],
        'book_author'=>$data['book_author'],
        'book_class'=>$data['book_class'],
        'book_publication'=>$data['book_publication'],
        'book_publication_year'=>$data['book_publication_year'],
        'book_language'=>$data['book_language']
    );

    $response=$this->abm->select_book($check_data);
    if(count($response)){
        $this->gm->send_response(false,"Book Already Exist",'','');
    }

    $insert_data=array(
        'book_name'=>$data['book_name'],
        'book_author'=>$data['book_author'],
        'book_class'=>$data['book_class'],
        'book_publication'=>$data['book_publication'],
        'book_price'=>$data['book_price'],
        'book_discount_status'=>$data['book_discount_status'],
        'book_discount'=>$data['book_discount'],
        'book_type'=>$data['book_type'],
        'book_status'=>$data['book_status'],
        'number_of_stock'=>$data['number_of_stock'],
        'book_added_on'=>time(),
        'book_added_by'=>$session_data['username'],
        'book_publication_year'=>$data['book_publication_year'],
        'book_language'=>$data['book_language']
    );
    //transactions start
    $this->db->trans_start();
    $response['book_id']=$this->abm->add_book($insert_data);
    $insert_data=array();
    for($i=0;$i<count($data['school']);$i++){
        $insert_data[$i]=array();
        $insert_data[$i]=array(
            'school_id'=>$data['school'][$i],
            'book_id'=>$response['book_id']
        );
    }

    $msg="<strong>".$session_data['username']."<strong>"." added Book ".$data['book_name'];
    $this->gm->add_notification($msg);
    if(count($data['school']))
    $this->abm->add_school_book($insert_data);

    $this->db->trans_complete();
    //transaction complete

    //show if any error
    if ($this->db->trans_status() === FALSE) {
        throw error;
    }

    $this->gm->send_response(true,"Book Added Successfully",$response,'');

  }


   public function edit_book(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $session_data=$this->session->all_userdata();
    if($session_data['id']==null){
      $this->gm->send_response(false,"Session Expired",'','');
    }

    if($role==3){
      $this->gm->send_response(false,"Permission Denied",'','');
    }

    $update_data=array(
        'book_id'=>$data['book_id'],
        'book_name'=>$data['book_name'],
        'book_author'=>$data['book_author'],
        'book_class'=>$data['book_class'],
        'book_publication'=>$data['book_publication'],
        'book_price'=>$data['book_price'],
        'book_discount_status'=>$data['book_discount_status'],
        'book_discount'=>$data['book_discount'],
        'book_type'=>$data['book_type'],
        'book_status'=>$data['book_status'],
        'number_of_stock'=>$data['number_of_stock'],
        'book_added_on'=>time(),
        'book_added_by'=>$session_data['username'],
        'book_publication_year'=>$data['book_publication_year'],
        'book_language'=>$data['book_language']
    );

    $this->abm->edit_book($update_data);
    $response['book_id']=$data['book_id'];
    $update_data=array();
    for($i=0;$i<count($data['school']);$i++){
        $update_data[$i]=array();
        $update_data[$i]=array(
            'school_id'=>$data['school'][$i],
            'book_id'=>$data['book_id']
        );
    }

    $msg="<strong>".$session_data['username']."<strong>"." edited Book ".$data['book_name'];
    $this->gm->add_notification($msg);

    $this->abm->delete_school_book($data['book_id']);
    $this->abm->add_school_book($update_data);
    $this->gm->send_response(true,"Book Edited Successfully",$response,'');
    }



    public function view_book($book_id){
    
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $session_data=$this->session->all_userdata();
    if($session_data['id']==null){
      $this->gm->send_response(false,"Session Expired",'','');
    }

    $book=$this->abm->view_book($book_id);
    if($book){
        if($book['book_discount_status']){
            $book[0]['discounted_price']=($book[0]['book_price']*(100-$book[0]['book_discount']))/100;
        }
        else{
            $book[0]['discounted_price']=$book[0]['book_price'];
        }
        $this->gm->send_response(True,"Success",$book,'');
    }
    else{
        $this->gm->send_response(false,"Book Not Exist",'','');
    }
    }

    public function delete_book($book_id){
        $session_data=$this->session->all_userdata();
        if($session_data['id']==null){
            $this->gm->send_response(false,"Session Expired",'','');
        }

        $role=$session_data['role'];
        $user_id=$session_data['id'];
        $admin_name=$session_data['username'];

        if($role==3){
            $this->gm->send_response(false,"Permission Denied",'','');
        }
        $book=$this->abm->view_book($book_id);
        $msg="<strong>".$session_data['username']."<strong>"." deleted Book ".$book['book_name'];
        $this->gm->add_notification($msg);
        
        $this->abm->delete_school_book($book_id);
        $response=$this->abm->delete_book($book_id);
        $this->gm->send_response(true,"Book Deleted Successfully",$response,'');
}

  public function list_book($index){
    $limit=$this->config->item('number_of_book_in_one_list');
    $offset=($index-1)*$this->config->item('number_of_book_in_one_list');
    $response_data=$this->abm->list_book($limit,$offset);
    $response_count=$this->abm->count_book();

    $result['data']=$response_data;
    $result['count']=$response_count;
    $this->gm->send_response(true,"List of Books ",$result,'');
  }



}
?>
