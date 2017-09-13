<?php

/**
*
*/
class Admin_book_model extends CI_Model{

  /**************************************************************
  Function to add book in db
  ****************************************************************/
  public function add_book($data){

     $this->db->insert('book',$data);
     return $this->db->insert_id();
  }


/**************************************************************
  Function to add school_book linking in db
  ****************************************************************/
  public function add_school_book($data){
    return    $this->db->insert_batch('school_book',$data);

  }

  /**************************************************************
  Function to list  book from db
  ****************************************************************/
  public function list_book($limit,$offset){
    $this->db->cache_on();
    $this->db->join('publication','publication.publication_id=book.book_publication');
    $this->db->join('class','class.class_id=book.book_class');
    $this->db->join('book_type','book_type.bt_id=book.book_type');
    $this->db->join('author','author.author_id=book.book_author');
    $this->db->order_by("book_id", "desc"); 
    $query= $this->db->get('book',$limit,$offset)->result_array();
    // echo $this->db->last_query();
    return $query;
  }

  /**************************************************************
  Function to list  book from db
  ****************************************************************/
  public function count_book(){
    $query= $this->db->get('book')->result_array();
    return count($query);
  }

  /**************************************************************
  Function to edit a particular book
  ****************************************************************/
  public function edit_book($data){
    $this->db->where('book_id', $data['book_id']);
    return $this->db->update('book', $data); 
  }

  /**************************************************************
  Function to view a particular book
  ****************************************************************/
  public function view_book($book_id){
    $this->db->where('book.book_id', $book_id);
    $this->db->from('book');
    $this->db->join('publication','publication.publication_id=book.book_publication','left');
    $this->db->join('class','class.class_id=book.book_class','left');
    $this->db->join('book_type','book_type.bt_id=book.book_type','left');
    $this->db->join('author','author.author_id=book.book_author','left');
    $this->db->join('school_book','school_book.book_id=book.book_id','left');
    $this->db->join('school','school.school_id=school_book.school_id','left');
    $query= $this->db->get()->result_array();
    
    return $query;
  }

    /**************************************************************
  Function to view a particular book
  ****************************************************************/
  public function select_book($where){
    $this->db->where($where);
    $query= $this->db->get('book')->result_array();
    return $query;
  }

  /**************************************************************
  Function to Delete a particular book
  ****************************************************************/
  public function delete_book($book_id){
    $this->db->where('book_id', $book_id);
    $response=$this->db->delete('book');
    return $response;
  }

   /**************************************************************
  Function to Delete a particular book from school book
  ****************************************************************/
  public function delete_school_book($book_id){
    $this->db->where('book_id', $book_id);
    $response=$this->db->delete('school_book');
    return $response;
  }
}

?>
