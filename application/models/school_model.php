<?php

/**
*
*/
class School_model extends CI_Model{

  /**************************************************************
  Function to list  school from db
  ****************************************************************/
  public function list_school($where,$limit,$offset){
   $this->db->where( $where);
   $query = $this->db->get('school',$limit,$offset)->result_array();
  //  echo $this->db->last_query();
   return $query;
  }


   /**************************************************************
  Function to count  school from db
  ****************************************************************/
  public function count_school($where){
  $this->db->select('*');
  $this->db->where($where);
  $result = $this->db->get('school')->result_array();
   return count($result);
  }

  }

?>
