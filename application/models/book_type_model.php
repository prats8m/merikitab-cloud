<?php

/**
*
*/
class Book_type_model extends CI_Model{

  /**************************************************************
  Function to list  school from db
  ****************************************************************/
  public function list_book_type($where){
   $this->db->where( $where);
   $query = $this->db->get('book_type')->result_array();
   return $query;
  }
  }

?>
