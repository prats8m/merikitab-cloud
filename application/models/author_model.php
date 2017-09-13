<?php

/**
*
*/
class Author_model extends CI_Model{

   /**************************************************************
  Function to list  author from db
  ****************************************************************/
  public function list_author($limit,$offset){
    $this->db->order_by("author_id", "desc"); 
    $query= $this->db->get('author',$limit,$offset)->result_array();
    // echo $this->db->last_query();
    return $query;
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
/**************************************************************
  Function to list add author in db
  ****************************************************************/
  public function add_author($data){
    $this->db->insert('author',$data);
    return $this->db->insert_id();
  }

  /**************************************************************
  Function to count total number of author
  ****************************************************************/
  public function count_author(){
    $query= $this->db->get('author')->result_array();
    return count($query);
  }



  /**************************************************************
  Function to edit a particular author
  ****************************************************************/
  public function edit_author($data){
    $this->db->where('author_id', $data['author_id']);
    return $this->db->update('author', $data); 
  }

    /**************************************************************
  Function to Delete a particular author
  ****************************************************************/
  public function delete_author($author_id){
    $this->db->where('author_id', $author_id);
    $response=$this->db->delete('author');
    return $response;
  }



  /**************************************************************
  Function to view a particular book
  ****************************************************************/
  public function select_author($where){
    $this->db->where($where);
    $query= $this->db->get('author')->result_array();
    return $query;
  }
  }

?>
