<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin extends CI_Controller {

    public function __Construct() {
        parent::__Construct();
        if(!$this->session->userdata('logged_in')) {
            redirect(base_url());
        }

        if($this->session->userdata('role') != 'admin'){
            redirect(base_url());
        }

        $this->load->model('admin_model');
    }
    

    private function ajax_checking(){
        if (!$this->input->is_ajax_request()) {
            redirect(base_url());
        }
    }

    public function user_list(){

        $data = array(
            'formTitle' => 'User Management',
            'title' => 'User Management',
            'users' => $this->admin_model->get_user_list(),
        );

        $this->load->view('frame/header_view');
        $this->load->view('frame/sidebar_nav_view');
        $this->load->view('admin/user_list', $data);

    }

    function add_user(){
        $this->ajax_checking();

        $postData = $this->input->post();
        $insert = $this->admin_model->insert_user($postData);
        if($insert['status'] == 'success')
            $this->session->set_flashdata('success', 'ผู้ใช้งาน '.$postData['email'].' ได้รับการสร้างสำเร็จแล้ว!');

        echo json_encode($insert);
    }

    function update_user_details(){
        $this->ajax_checking();

        $postData = $this->input->post();
        $update = $this->admin_model->update_user_details($postData);
        if($update['status'] == 'success')
            $this->session->set_flashdata('success', 'ผู้ใช้งาน '.$postData['email'].' ได้รับการปรับปรุงรายละเอียดเรียบร้อยแล้ว!');

        echo json_encode($update);
    }

    function deactivate_user($email,$id){
        $this->ajax_checking();

        $update = $this->admin_model->deactivate_user($email,$id);
        if($update['status'] == 'success')
            $this->session->set_flashdata('success', 'ผู้ใช้งาน '.$email.' ถูกลบเรียบร้อยแล้ว!');

        echo json_encode($update);
    }

    function reset_user_password($email,$id){
        $this->ajax_checking();

        $update = $this->admin_model->reset_user_password($email,$id);
        if($update['status'] == 'success')
            $this->session->set_flashdata('success', 'ผู้ใช้งาน '.$email.' ตั้งรหัสผ่านใหม่แล้ว!');

        echo json_encode($update);
    }

    function activity_log(){
        $data = array(
            'formTitle' => 'Activity Log',
            'title' => 'Activity Log',
        );
        $this->load->view('frame/header_view');
        $this->load->view('frame/sidebar_nav_view');
        $this->load->view('admin/activity_log', $data);

    }

    function get_activity_log(){
        $this->ajax_checking();
        echo  json_encode( $this->admin_model->get_activity_log() );
    }



}
