<?php

/**
*
*/
class Author_model extends CI_Model{

  /**************************************************************
  Function to list  school from db
  ****************************************************************/
  public function list_author($where){
   $this->db->where( $where);
   $query = $this->db->get('author')->result_array();
   return $query;
  }
  }

?>
