<?php

/**
*
*/
class Cart_model extends CI_Model{

 public function add_to_cart($data){
    return    $this->db->insert('cart',$data);

  }


   public function select_cart($where){
    $this->db->where($where);
    $query= $this->db->get('cart')->result_array();
    return $query[0];
  }


    public function update_cart($where,$update_data){
    $this->db->where($where);
    return $this->db->update('cart', $update_data); 
  }

    public function delete_cart($cart_id){
    $this->db->where('cart_id', $cart_id);
    $response=$this->db->delete('cart');
    return $response;
  }


    public function empty_cart($user_id){
      $this->db->where('user_id', $user_id);
      $response=$this->db->delete('cart');
      return $response;
  }

}
?>
