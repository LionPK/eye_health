<?php
defined ('BASEPATH') or exit ('No direct script access allowed');

class ActivitiesRestful_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        
        //load database library
        $this->load->database('activity_log');
    }

    public function findAll(){
        return $this->db->get('activity_log')->result();
    }

    public function findById($log_id){
        $this->db->where('log_id',$log_id);
        return $this->db->get('activity_log')->row();

    }

    public function delete($log_id){
        $this->db->where('log_id',$log_id);
        $this->db->delete('activity_log');
    }

    public function insert($data){
        $this->db->insert('activity_log',$data);
    }

    public function update($log_id,$data){
        $this->db->where('log_id',$log_id);
        $this->db->update('activity_log',$data);
    }
}