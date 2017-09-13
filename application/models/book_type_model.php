<?php

/**
*
*/
class Book_type_model extends CI_Model{


  /**************************************************************
  Function to count total number of author
  ****************************************************************/
  public function count_book_type(){
    $query= $this->db->get('book_type')->result_array();
    return count($query);
  }


      /**************************************************************
  Function to list  author from db
  ****************************************************************/
  public function list_book_type($limit,$offset){
    $this->db->order_by("bt_id", "desc"); 
    $query= $this->db->get('book_type',$limit,$offset)->result_array();
    // echo $this->db->last_query();
    return $query;
  }
  }

?>
