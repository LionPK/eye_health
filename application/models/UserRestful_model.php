<?php
defined ('BASEPATH') or exit ('No direct script access allowed');

class UserRestful_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        
        //load database library
        $this->load->database('user');
    }

    public function findAll(){
        $this->db->where('status', 1);//display only status equals one
        return $this->db->get('user')->result();
    }

    public function findById($user_id){
        $this->db->where('status', 1);//display only status equals one
        $this->db->where('user_id',$user_id);
        return $this->db->get('user')->row();

    }

    public function delete($user_id){
        $this->db->where('user_id',$user_id);
        $this->db->delete('user');
    }

    public function insert($data){
        $this->db->insert('user',$data);
    }

    public function update($user_id,$data){
        $this->db->where('user_id',$user_id);
        $this->db->update('user',$data);
    }
}