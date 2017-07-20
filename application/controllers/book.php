<?php
header('Access-Control-Allow-Origin', '*');
// error_reporting(0);
class Book extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');
    $this->load->model('customer_model',"cm");
    $this->load->model('general_model',"gm");
    $this->load->model('book_model',"bm");
    $this->load->helper('url', 'form');
  }

public function list_book($index){
    $limit=$this->config->item('number_of_book_in_one_view');
    $offset=($index-1)*$this->config->item('number_of_book_in_one_view');
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $where = "";
    $i=0;
    if(count($data['class'])){
        $class = "";
        foreach($data['class'] as $key => $item){
            if(count($data['class']) == $key+1){
                $class = $class.$item;
            }
            else{
                $class = $class.$item.",";
            }
        }
        $where = $where."`book_class` IN (".$class.") ";
        }
    else{
        $where = $where."`book_class` LIKE '%%' ";
    }
    
    $where = $where."AND ";
   if(count($data['type'])){
        $type = "";
        foreach($data['type'] as $key => $item){
            if(count($data['type']) == $key+1){
                $type = $type."'".$item."'";
            }
            else{
                $type = $type."'".$item."',";
            }
        }
        $where = $where."`book_type` IN (".$type.") ";
        }
    else{
        $where = $where."`book_type` LIKE '%%' ";
    }

    $where = $where."AND ";
    if(count($data['publication'])){
        $publication = "";
        foreach($data['publication'] as $key => $item){
            if(count($data['publication']) == $key+1){
                $publication = $publication."'".$item."'";
            }
            else{
                $publication = $publication."'".$item."',";
            }
        }
        $where = $where."`book_publication` IN (".$publication.") ";
        }
    else{
        $where = $where."`book_publication` LIKE '%%' ";
    }

    $where = $where."AND ";
    if(count($data['year'])){
        $year = "";
        foreach($data['year'] as $key => $item){
            if(count($data['year']) == $key+1){
                $year = $year.$item;
            }
            else{
                $year = $year.$item.",";
            }
        }
        $where = $where."`book_publication_year` IN (".$year.") ";
        }
    else{
        $where = $where."`book_publication_year` LIKE '%%' ";
    }


    $where = $where."AND ";
    if(count($data['language'])){
        $language = "";
        foreach($data['language'] as $key => $item){
            if(count($data['language']) == $key+1){
                $language = $language."'".$item."'";
            }
            else{
                $language = $language."'".$item."',";
            }
        }
        $where = $where."`book_language` IN (".$language.") ";
        }
    else{
        $where = $where."`book_language` LIKE '%%' ";
    }


    $where = $where."AND ";
    if(count($data['author'])){
        $author = "";
        foreach($data['author'] as $key => $item){
            if(count($data['author']) == $key+1){
                $author = $author."'".$item."'";
            }
            else{
                $author = $author."'".$item."',";
            }
        }
        $where = $where."`book_author` IN (".$author.") ";
        }
    else{
        $where = $where."`book_author` LIKE '%%' ";
    }



    $where = $where."AND ";
    if(count($data['school'])){
        $school_id = "";
        foreach($data['school'] as $key => $item){
            if(count($data['school']) == $key+1){
                $school_id = $school_id.$item;
            }
            else{
                $school_id = $school_id.$item.",";
            }
        }
        $where = $where."`school_id` IN (".$school_id.") ";
        }
    else{
        $where = $where."`school_id` LIKE '%%' ";
    }

    if($data['price']){
        $where = $where."AND ";
        $where = $where."`book_price` <= '".$data['price']."'";
    }

    $response_data = $this->bm->list_book($where,$limit,$offset);
    $response_count = $this->bm->count_book($where);
    $response['data'] = $response_data;
    $response['count'] = $response_count;
    
    $this->gm->send_response(true,"Success",$response,'');
}


}