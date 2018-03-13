<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH. '/libraries/REST_Controller.php';

class ActivitiesRestful_con extends REST_Controller{

    function __construct(){
        parent::__construct();

        //load user model
        $this->load->model('ActivitiesRestful_model');
    }

    public function find_all_get(){
        $this->response($this->ActivitiesRestful_model->findAll(), REST_Controller::HTTP_OK);
    }

    public function find_get($log_id){
        $this->response($this->ActivitiesRestful_model->findById($log_id), REST_Controller::HTTP_OK);
        
    }

    public function create_post(){
    //    $id = $this->session->userdata('user_id');
       $activity_log = array(
        //    'fk_user_id' => $id,
           'fk_user_id' => $this->post('fk_user_id'),
           'activity' => $this->post('activity'),
           'module' => $this->post('module'),
           'created_at' => $this->post('created_at'),
       );
       $this->ActivitiesRestful_model->insert($activity_log);
    }

    public function update_put(){
        $activity_log = array(
           'activity' => $this->post('activity'),
           'module' => $this->post('module'),
           'created_at' => $this->post('created_at'),
        );
        $this->ActivitiesRestful_model->update($this->put('log_id'), $activity_log);
     }

     public function delete_delete($log_id){
        $this->ActivitiesRestful_model->delete($log_id);
     }
}