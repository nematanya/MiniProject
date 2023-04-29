<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Customlib
{

    public $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');

    }
   
    public function getStaffRole()
    {
        $admin = $this->CI->session->userdata('admin');
        $role = $admin['level'];
        //echo $role;die();
        if ($admin) {
            $role_key = $this->CI->db->select('role_name')->from('roles')->where('role_id', trim($role))->get()->row_array();

            return json_encode(array('id' => $role, 'name' => $role_key['role_name']));
        }
    }

    public function logged_in()
    {
        return (bool) $this->CI->session->userdata('admin');
    }

    public function is_logged_in($default_redirect = false)
    {
        $admin = $this->CI->session->userdata('admin');

        if (!$admin) {

            $_SESSION['redirect_to'] = current_url();
            redirect('login/admin/');

            return false;
        } else {
            $active_status = $this->CI->db->select('status')->from('staff')->where('staff_id', $admin['id'])->get()->row_array();

            if ($active_status['status'] == 1) {

                if ($default_redirect) {

                    redirect('admin/admin/dashboard');
                }
                return true;
            } else {

                $_SESSION['redirect_to'] = current_url();
                $this->logout();
                redirect('login/admin/');
                return false;
            }

        }
    }

    public function is_user_logged_in($default_redirect = false) {
        $user=$this->CI->session->userdata('user');
        if(!$user){
            $_SESSION['redirect_to'] = current_url();
            redirect('login');

            return false;
        }else{
            $active_status = $this->CI->db->select('status,emailverified')->from('users')->where('userid', $user['id'])->get()->row_array();
            if ($active_status['status'] == 1 & $active_status['emailverified']==1) {

                if ($default_redirect) {

                    redirect('userpanel/dashboard');
                }
                return true;
            } else if($active_status['emailverified']==0){              
                 redirect('login/emailverification');
                 return true;
            } else {

                $_SESSION['redirect_to'] = current_url();
                $this->userlogout();
                redirect('login');
                return false;
            }
        }
    }


    public function logout()
    {
        $this->CI->session->unset_userdata('admin');
        $this->CI->session->sess_destroy();
    }


    public function userlogout()
    {
        $this->CI->session->unset_userdata('user');
        $this->CI->session->sess_destroy();
    }

    public function insertinhistory($compid,$msg){
        $insertArray=array(
           'complaintId'=>$compid,
           'compstatus' =>$msg,
           'statusupdate'=>time(),
        );
        $this->CI->db->insert('complainthistory', $insertArray);
    }

    public function getSystemInfo(){
        return $this->CI->db->select('*')->from('systemsetting')->where('id',1)->get()->row_array();
    }

    public function getNotificationStatus($name){
        return $this->CI->db->select('status')->from('emailnotification')->where('name',$name)->get()->row_array();
    }
    





}

?>