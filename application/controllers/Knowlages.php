<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Knowlages extends CI_Controller {
    public function __Construct() {
        parent::__Construct();
        if(!$this->session->userdata('logged_in')) {
            redirect(base_url());
        }

        if($this->session->userdata('role') != 'admin'){
            redirect(base_url());
        }
        $this->load->model('knowlage_model');
    }
    

    private function ajax_checking(){
        if (!$this->input->is_ajax_request()) {
            redirect(base_url());
        }
    }
    
    
      //functions  
      function knowlage_list(){  
           $data["title"] = "การจัดการข้อมูลความรู้";
           $this->load->view('frame/header_view');
           $this->load->view('frame/sidebar_nav_view');  
           $this->load->view('knowlages/knowlages_list', $data);  
      }  
      function fetch_knowlage(){  
           $fetch_data = $this->knowlage_model->make_datatables();  
           $data = array();  
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = '<img src="'.base_url().'upload/'.$row->image.'" class="img-thumbnail" width="50" height="35" />';  
                $sub_array[] = $row->type;  
                $sub_array[] = $row->name;
                $sub_array[] = $row->detail;  
                $sub_array[] = '<button type="button" name="update" id="'.$row->id.'" class="btn btn-warning btn-xs">แก้ไข</button>';  
                $sub_array[] = '<button type="button" name="delete" id="'.$row->id.'" class="btn btn-danger btn-xs">ลบ</button>';  
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($_POST["draw"]),  
                "recordsTotal"          =>      $this->knowlage_model->get_all_data(),  
                "recordsFiltered"     =>     $this->knowlage_model->get_filtered_data(),  
                "data"                    =>     $data  
           );  
           echo json_encode($output);  
      } 
      
      function knowlage_action(){  
        // if($_POST["action"] == "Add"){  
             $insert_data = array(  
                  'type'          =>     $this->input->post('type'),  
                  'name'               =>     $this->input->post("name"),
                  'detail'               =>     $this->input->post("detail"),    
                  'image'                    =>     $this->upload_image()  
             );  
             $this->load->model('knowlage_model');  
             $this->knowlage_model->insert_knowlage($insert_data);  
             echo 'เพิ่มข้อมูลสำเร็จแล้ว';  
        // }  
   }
   
   function upload_image(){  
           if(isset($_FILES["knowlage_image"]))  
           {  
                $extension = explode('.', $_FILES['knowlage_image']['name']);  
                $new_name = rand() . '.' . $extension[1];  
                $destination = './upload/' . $new_name;  
                move_uploaded_file($_FILES['knowlage_image']['tmp_name'], $destination);  
                return $new_name;  
           }  
      }  
 }  