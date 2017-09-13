<?php

/**
*
*/
class Class_model extends CI_Model{
 /**************************************************************
  Function to count total number of author
  ****************************************************************/
  public function count_class(){
    $query= $this->db->get('class')->result_array();
    return count($query);
  }


      /**************************************************************
  Function to list  author from db
  ****************************************************************/
  public function list_class($limit,$offset){
    $this->db->order_by("class_id", "desc"); 
     $query= $this->db->get('class',$limit,$offset)->result_array();
    // echo $this->db->last_query();
    return $query;
    
  }
}
?>
