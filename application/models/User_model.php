<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    function get_users_list(){
        $this->db->select('*');
        $this->db->from('users');
        // $this->db->where('status', 1); //แสดงข้อมูลของผู้ใช้งานที่มี status เป็น 1
        $query=$this->db->get();
        return $query->result();
    }

    function get_user_by_id($userID){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $userID);
        $query=$this->db->get();
        return $query->result_array();
    }

    // function validate_email($postData){
    //     $this->db->where('email', $postData['email']);
    //     $this->db->where('status', 1);
    //     $this->db->from('users');
    //     $query=$this->db->get();

    //     if ($query->num_rows() == 0)
    //         return true;
    //     else
    //         return false;
    // }


    function reset_users_password($email,$id){

        $password = $this->generate_password();
        $data = array(
            'encrypted_password' => md5($password),
        );
        $this->db->where('id', $id);
        $this->db->update('users', $data);

        $message = "รีเซ็ตรหัสผ่านบัญชีของคุณแล้ว<br><br>อีเมล์: ".$email."<br>รหัสผ่านชั่วคราว: ".$password."<br>โปรดเปลี่ยนรหัสผ่านของคุณหลังจากเข้าสู่ระบบ<br><br> คุณสามารถเข้าสู่ระบบได้ที่ ".base_url().".";
        // $subject = "รีเซ็ตรหัสผ่าน";
        $subject = "Password Reset";
        $this->send_email($message,$subject,$email);

        // $module = "การจัดการผู้ใช้งาน";
        // $activity = "รีเซ็ตรหัสผ่านของผู้ใช้งาน ".$email;
        // $this->insert_log($activity, $module);
        return array('status' => 'success', 'message' => '');

    }

    function generate_password(){
        $chars = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKMNOPQRSTUVWXYZ023456789!@#$%^&*()_=";
        $password = substr( str_shuffle( $chars ), 0, 10 );

        return $password;
    }

        /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    // function insert_log($activity, $module){
    //     $id = $this->session->userdata('user_id');

    //     $data = array(
    //         'fk_id_users' => $id,
    //         'activity' => $activity,
    //         'module' => $module,
    //         'created_at' => date('Y\-m\-d\ H:i:s A')
    //     );
    //     $this->db->insert('activity_log', $data);
    // }

    // function get_activity_log(){
    //     /*Array ของ columns ในฐานข้อมูลควรจะถูกอ่านและส่งกลับไปยัง DataTables
    //      *ใช้พื้นที่ที่ต้องการนำ field เข้าที่ไม่มีอยู่ใน database เช่น counter หรือ static image
    //     */
        
    //     $aColumns = array('date_time', 'activity', 'email', 'module');
    //     $aColumnsWhere = array('activity_log.created_at', 'activity', 'email', 'module');
    //     $aColumnsJoin = array('activity_log.created_at as date_time', 'activity', 'email', 'module');

    //     // ชื่อ DB ที่ใช้งาน
    //     $sTable = 'activity_log';
    
    //     $iDisplayStart = $this->input->get_post('iDisplayStart', true);
    //     $iDisplayLength = $this->input->get_post('iDisplayLength', true);
    //     $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
    //     $iSortingCols = $this->input->get_post('iSortingCols', true);
    //     $sSearch = $this->input->get_post('sSearch', true);
    //     $sEcho = $this->input->get_post('sEcho', true);
    
    //     // Paging
    //     if(isset($iDisplayStart) && $iDisplayLength != '-1')
    //     {
    //         $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
    //     }
        
    //     // Ordering
    //     if(isset($iSortCol_0))
    //     {
    //         for($i=0; $i<intval($iSortingCols); $i++)
    //         {
    //             $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
    //             $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
    //             $sSortDir = $this->input->get_post('sSortDir_'.$i, true);
    
    //             if($bSortable == 'true')
    //             {
                    
    //                 $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                    
    //             }
    //         }
    //     }
        
    //     /* 
    //      * Filtering
    //      * โปรดทราบว่าไม่ได้เป็นตัวกรองข้อมูลในตัว DataTables ที่ใช้คำใดในฟิลด์
    //      * เป็นไปได้ที่จะทำที่นี่ แต่ความกังวลเกี่ยวกับประสิทธิภาพในตารางที่มีขนาดใหญ่มาก
    //      * และฟังก์ชันการทำงาน regex ของ MySQL มีข้อ จำกัดมาก
    //      */
    //     if(isset($sSearch) && !empty($sSearch))
    //     {
    //         for($i=0; $i<count($aColumns); $i++)
    //         {
    //             $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
                
    //             // การกรองคอลัมน์แต่ละรายการ
    //             if(isset($bSearchable) && $bSearchable == 'true')
    //             {
    //                 $this->db->or_like($aColumnsWhere[$i], $this->db->escape_like_str($sSearch));

    //             }
    //         }
    //     }
        
    //     // เลือกข้อมูล
    //     $this->db->join('user', 'activity_log.fk_user_id = user.user_id', 'left');
    //     $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumnsJoin)), false);
    //     $rResult = $this->db->get($sTable);
    
    //     // ความยาวชุดข้อมูลหลังจากการกรอง
    //     $this->db->select('FOUND_ROWS() AS found_rows');
    //     $iFilteredTotal = $this->db->get()->row()->found_rows;
    
    //     // ความยาวชุดข้อมูลทั้งหมด
    //     $iTotal = $this->db->count_all($sTable);
    
    //     // Output
    //     $output = array(
    //         'sEcho' => intval($sEcho),
    //         'iTotalRecords' => $iTotal,
    //         'iTotalDisplayRecords' => $iFilteredTotal,
    //         'aaData' => array()
    //     );
        
    //     foreach($rResult->result_array() as $aRow)
    //     {
    //         $row = array();
            
    //         foreach($aColumns as $col)
    //         {
    //             if($col == 'date_time') $aRow[$col] = preg_replace('/\s/','<br />',$aRow[$col]);
    //             $row[] = $aRow[$col];
    //         }
    
    //         $output['aaData'][] = $row;
    //     }
    
    //     return $output;
    // }


    function send_email($message,$subject,$sendTo){
        require_once APPPATH.'libraries/mailer/class.phpmailer.php';
        require_once APPPATH.'libraries/mailer/class.smtp.php';
        require_once APPPATH.'libraries/mailer/mailer_config.php';
        include APPPATH.'libraries/mailer/template/template.php';
        
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        try
        {
            $mail->SMTPDebug = 1;  
            $mail->SMTPAuth = true; 
            $mail->SMTPSecure = 'ssl'; 
            $mail->Host = HOST;
            $mail->Port = PORT;  
            $mail->Username = GUSER;  
            $mail->Password = GPWD;     
            $mail->SetFrom(GUSER, 'Administrator');
            // $mail->Subject = "แจ้งเตือน - ".$subject;
            $mail->Subject = "DO NOT REPLY - ".$subject;
            $mail->IsHTML(true);   
            $mail->WordWrap = 0;


            $hello = '<h1 style="color:#333;font-family:Helvetica,Arial,sans-serif;font-weight:300;padding:0;margin:10px 0 25px;text-align:center;line-height:1;word-break:normal;font-size:38px;letter-spacing:-1px">สวัสดีผู้ใช้งาน, &#9786;</h1>';
            $thanks = "<br><br><i>นี่เป็นอีเมล์ที่สร้างโดยอัตโนมัติโปรดอย่าตอบ</i><br/><br/>ขอบคุณ,<br/>ผู้ดูแลระบบ<br/><br/>";

            $body = $hello.$message.$thanks; //คำสั่งที่ประกอบข้อความในส่วนเนื้อหาของ email
            $mail->Body = $header.$body.$footer;
            $mail->AddAddress($sendTo);

            if(!$mail->Send()) {
                $error = 'เกิดข้อผิดพลาดในการส่งอีเมล์: '.$mail->ErrorInfo;
                return array('status' => false, 'message' => $error);
            } else { 
                return array('status' => true, 'message' => '');
            }
        }
        catch (phpmailerException $e)
        {
            $error = 'เกิดข้อผิดพลาดในการส่งอีเมล์: '.$e->errorMessage();
            return array('status' => false, 'message' => $error);
        }
        catch (Exception $e)
        {
            $error = 'เกิดข้อผิดพลาดในการส่งอีเมล์: '.$e->getMessage();
            return array('status' => false, 'message' => $error);
        }
        
    }

}