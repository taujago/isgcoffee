<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller{
    function __construct()
    {
        parent::__construct();
    }

    function index(){
        $this->load->view("login_view");
    }

    function ceklogin(){
        $post = $this->input->post();
        
        $this->db->where("username",$post['username']);
        $this->db->where("password", $post['password']);
        $res = $this->db->get('tabeluser');
        // echo $this->db->last_query();

        if($res->num_rows() == 0 ){
            $ret = array(
                "error"=>true,
                "message"=>"User not found"
            );
        }
        else {
            $this->session->set_userdata("login",true);
            $this->session->set_userdata("userdata",$res->row_array());
            $ret = array(
                "error" => false,
                "message" => "Login succeed"
            );
        }
        echo json_encode($ret);
    }

    function logout(){
        $this->session->unset_userdata("login");
        redirect("Login");
    }
}
?>