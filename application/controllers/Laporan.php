<?php 
require_once APPPATH . 'libraries/Master_controller.php';

class Laporan extends Master_controller{
    var $warna;
    var $arr_menu;
    function __construct(){
        parent::__construct();
        $this->controller = get_class($this);
        $this->load->model("Core_model","cm");
         

        $this->menu = $this->uri->segment(1) . "/" . $this->uri->segment(3);

    }

    function index(){
        
            $data = array();
           
    
          
    
            $content = $this->load->view("laporan/LaporanView",$data,true); 
            $this->set_title("LAPORAN PENJUALAN PER DAPUR PER BULAN");
            $this->set_content($content);
            $this->rendervue();
    }
    

    function getLaporan(){
        $post = $this->input->post();
        extract($post);
        $sql = "SELECT DPR.kode, SUM(IP.JUMLAH) AS JUMLAH 
        FROM dapur DPR 
        JOIN  MAKANAN_MINUMAN MM ON DPR.KODE = MM.KD_DAPUR 
        JOIN item_penjualan  IP ON MM.KODE=IP.kode_barang 
        JOIN penjualan P ON P.ORDER_NO = IP.order_no 
        WHERE p.lunas = 'True'  
        and YEAR(p.order_date) = $tahun 
        AND MONTH(ORDEr_date) = $bulan
        GROUP BY DPR.kode";
        $res = $this->db->query($sql);

        $this->load->view("laporan/LaporanResultView",array("record"=>$res));
    }
    

}