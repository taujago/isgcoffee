<?php
class Master_controller extends CI_Controller {

// var $pilihan; 


	var $arr_bulan;
	var $cols; 

	var $table_name;
	var $arr_semester; 
	function __construct() {

		


		
		
		parent::__construct();
		// $this->set_tbname();
		$login = $this->session->userdata("login"); 
		if($login <> true) {
			redirect("login");
			exit;
		}

		// $userdata = $_SESSION['userdata'];

		// if($userdata['login'] == false || $userdata['id_level'] <> '1' ) {
		// 	redirect('Login/');
		// } 	 
		// $this->content['userdata'] = $_SESSION['userdata'];
	 
	}

	function set_content($str) {
		$this->content['content'] = $str; 
	}
	
	function set_title($str) {
		$this->content['title'] = $str;
	}
	
	function set_subtitle($str) {
		$this->content['subtitle'] = $str;
	}
	
	function render(){
				 

		$this->load->view("template-vue",$this->content );
		
	}


	function rendervue(){
		$this->load->view("template-vue",$this->content );
		
	}

	 

	  
	 



}

?>
