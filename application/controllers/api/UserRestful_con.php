<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH. '/libraries/REST_Controller.php';
// use Restserver\libraries\REST_Controller;

class UserRestful_con extends REST_Controller{

    function __construct(){
        parent::__construct();

        //load user model
        $this->load->model('UserRestful_model');
    }

    public function find_all_get(){
        $this->response($this->UserRestful_model->findAll(), REST_Controller::HTTP_OK);
    }

    public function find_get($user_id){
        $this->response($this->UserRestful_model->findById($user_id), REST_Controller::HTTP_OK);
        
    }

    public function create_post(){
       $user = array(
           'email' => $this->post('email'),
           'password' => md5($this->post('password')),
           'name' => $this->post('name'),
           'role' => $this->post('role'),
           'created_at' => $this->post('created_at'),
       );
       $this->UserRestful_model->insert($user);
    }

    public function update_put(){
        $user = array(
            'email' => $this->put('email'),
            'password' => md5($this->put('password')),
            'name' => $this->put('name'),
            'role' => $this->put('role'),
            'updated_at' => $this->put('updated_at'),
        );
        $this->UserRestful_model->update($this->put('user_id'), $user);
     }

     public function delete_delete($user_id){
        $this->UserRestful_model->delete($user_id);
     }
}