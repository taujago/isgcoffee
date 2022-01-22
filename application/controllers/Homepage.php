<?php 
require_once APPPATH . 'libraries/Master_controller.php';

class Homepage extends Master_controller{
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
       

        $sql= "SELECT nomor, status FROM `temp_meja` order by CONVERT(nomor,UNSIGNED INTEGER) asc";
        $res = $this->db->query($sql);
        $data['records'] = $res;

        $content = $this->load->view($this->controller."View",$data,true); 
		$this->set_title("ISG");
		$this->set_content($content);
		$this->rendervue();
    }

    function PlaceOrder($no_meja){

        // get data pemesanan di nomor meja ini 
        $data = array();
        $this->db->select('it.*')->from('item_penjualan it')
        ->join('temp_meja meja', 'it.order_no = meja.faktur')
        ->where("nomor",$no_meja);
        $res = $this->db->get();


        $data['record'] = $res;   
        $data['no_meja'] = $no_meja;    
        $content = $this->load->view("PlaceOrderView", $data, true);
        $this->set_title("PEMESANAN");
        $this->set_content($content);
        $this->rendervue();

    }


    function deleteOrder(){
        $post  = $this->input->post();
        $session_name = "tmp_order" . $post['no_meja'];
        $order_session = $_SESSION[$session_name]; // $this->session->userdata($session_name);

        // show_array($order_session); exit;

         
         
        $order_session[$post['index']]['proses'] = "hapus";
        // $this->session->set_userdata($session_name, $order_session);
        $_SESSION[$session_name] = $order_session; 
        echo json_encode(array('error' => false));
        
    }

    function saveOrder(){
        $post  = $this->input->post();

        // show_array($post);  
        //get menu detail 
        $this->db->where("kode",$post['kode_barang']);
        $menudata = $this->db->get("makanan_minuman")->row();
        $session_name = "tmp_order".$post['no_meja'];
        // echo "sesion ". $session_name; 
        $order_session = $_SESSION[$session_name]; //$this->session->userdata($session_name);

        // show_array($order_session); exit;

        if($post['mode']=="edit"){
            $order_session[$post['index']]['jumlah'] = $post['jumlah'];
            $order_session[$post['index']]['keterangan'] = $post['keterangan'];
            // $order_session[$post['index']]['baru'] = true;
            $order_session[$post['index']]['proses'] = "edit";
            // $this->session->set_userdata($session_name, $order_session);
            $_SESSION[$session_name] = $order_session; 
        }

        else {  // tambah baru 
            // echo "tambah baru";
            if($order_session == "") { // belum ada. bikin baru 
                $arr[] = array("keterangan"=>$post['keterangan'],
                            "jumlah"=>$post['jumlah'],
                            "no_meja"=>$post['no_meja'],
                            // "baru" => true,
                            "proses" => "baru",
                            "menu"=>$menudata);
                // $this->session->set_userdata($session_name, $arr);
                $_SESSION[$session_name] = $arr; 
                // show_array($arr);
            }
            else {
                // echo "sudah ada.. tambahkan";
                // $arr = $this->session->userdata($session_name);
                $arr = $_SESSION[$session_name];
                $tmp_arr =
                array(
                    "keterangan" => $post['keterangan'],
                    "jumlah" => $post['jumlah'],
                    "no_meja" => $post['no_meja'],
                    "proses" => "baru",
                    "menu" => $menudata
                );
                array_push($arr, $tmp_arr);
                // $this->session->set_userdata($session_name,$arr);
                $_SESSION[$session_name] = $arr;
            }
        }
        $tmp_session = $_SESSION[$session_name] ; // $this->session->userdata($session_name);
        // echo "final " . show_array($tmp_session);
        echo json_encode(array('error'=>false));

    }

    function getMenuByTable($tableNo){
        
        $session_name = "tmp_order" . $tableNo;
        // echo "session name" .$session_name;
        $tmp_session = isset($_SESSION[$session_name])?$_SESSION[$session_name]:false; //$this->session->userdata($session_name);
       
        if(!$tmp_session){ // belum ada, cek ke tabel 
            $tmp = array();
            $this->db->select("i.*")
            ->from("item_penjualan i")
            ->join("temp_meja m", "i.order_no = m.faktur")
            ->where("m.nomor",$tableNo)
            ->where("status",'PESAN');
            $res = $this->db->get();

            foreach($res->result() as $row) : 

                $this->db->where("kode",$row->kode_barang);
                $menudata = $this->db->get("makanan_minuman")->row();
                
                $tmp[] = array(
                    "keterangan" => $row->keterangan,
                    "jumlah" => number_format($row->qty,0),
                    "no_meja" => $tableNo,
                    
                    "proses" => null,
                    "menu" => $menudata
                );
            endforeach;


            // $this->session->set_userdata($session_name,$tmp);
            $_SESSION[$session_name] = $tmp;
        }

        $tmp_session = $_SESSION[$session_name]; // $this->session->userdata($session_name);
       
        // if(!isset($tmp_session)){
        //     echo "no data"; exit;
        // }
        $this->load->view("OrderListView",array("record"=>$tmp_session));
        // echo "<ul>";
        // foreach($tmp_session as $index => $tmp) : 
        //     if($tmp['proses']=="hapus") continue;
        //     echo "<li>". $tmp['menu']->kode. " ". $tmp['menu']->nama. " x ". $tmp['jumlah'] 
        //     . "<a href='#!' onclick=edit('".$index."') > Edit </a>"
        //     . "<a href='#!' onclick=hapus('" . $index . "')> Hapus </a>"
        //     ." </li>"; 
        // endforeach;
        // echo "</ul>";
        // show_array($tmp_session); 
    }

    function DeleteSession($no_meja){
        // $this->session->unset_userdata("tmp_order".$no_meja);
        unset($_SESSION["tmp_order".$no_meja]);
    }


    function ConfirmOrder($no_meja){
        // get nomor faktur di meja
        $session_name = "tmp_order" . $no_meja;
        $dataOrder = $_SESSION[$session_name];//$this->session->userdata($session_name);
        // show_array($dataOrder);
        // exit;
        $this->db->where("nomor",$no_meja);
        // $this->db->where("status", "BAYAR");
        $data_meja = $this->db->get("temp_meja")->row();
        $no_faktur = isset($data_meja->faktur)? $data_meja->faktur:"";
        if($no_faktur==""){
            $no_faktur = $this->kode_baru_transaksi(0);
            $baru = true;
        }
        else {
            $baru = false;
        }

        if($baru){
            // "insert into penjualan (order_no,order_date,referensi,operator,meja) values 
            // ('" . $nofaktur . "','" . date("Y-m-d") . "','ANDROID','" . 
            // $operator . "','" . $nomormeja . "')";
            $userdata = $this->session->userdata("userdata");
            $arr=array(
                "order_no" => $no_faktur,
                "order_date" => date("Y-m-d"),
                "referensi" => "MOBILE ORDER",
                "operator" => $userdata['username'],
                "meja" => $no_meja
            );
            // simpan penjualan;
            $this->db->insert("penjualan",$arr);

            // update data meja 
            $arr=array(
                "status" => "PESAN",
                "faktur" => $no_faktur
            );
            $this->db->where("nomor",$no_meja);
            $this->db->update("temp_meja",$arr);



        }



        foreach($dataOrder as $index => $row) :

            if($row['proses'] == "hapus") {
                $this->db->where("kode_barang", $row['menu']->kode)
                    ->where("order_no", $no_faktur);
                $this->db->delete("item_penjualan");
                // echo "ada barang yagn dihapus ".$this->db->last_query(); // exit;

                // update monitor dapur 
                $this->db->where(array(
                    "kode_barang" => $row['menu']->kode,
                    "no_faktur_jual" => $no_faktur,
                    "no_meja" => $row['no_meja'],
                    "kd_dapur" => $row['menu']->kd_dapur,

                ));
                $this->db->delete("dapur_monitor");

                unset($dataOrder[$index]);

            }
            if($row['proses']=="edit"){
                // some code here, must be fucking awesome 
                $this->db->where("kode_barang",$row['menu']->kode)
                ->where("order_no", $no_faktur);
                $res = $this->db->get("item_penjualan");
                if($res->num_rows()==0){
                    $row['proses'] == "baru";
                }
                else {
                    // update item penjualan 

                    $this->db->where("kode_barang", $row['menu']->kode)
                    ->where("order_no", $no_faktur);
                    $this->db->update("item_penjualan",
                    array(
                        "qty"=>$row['jumlah'],"jumlah"=>$row['jumlah']*$row['menu']->harga
                    ));
                    
                    // update monitor dapur 
                    $this->db->where(
                        array("kode_barang"=>$row['menu']->kode,
                                      "no_faktur_jual"=> $no_faktur,
                                      "no_meja" => $row['no_meja'],
                                      "kd_dapur" => $row['menu']->kd_dapur,

                    ));
                    $this->db->update("dapur_monitor",array(
                            "qty" => $row['jumlah'],
                            "status" => 'TELAH DI EDIT' 
                    ));

                    $dataOrder[$index]['proses'] = null;
                    // $this->session->set_userdata($session_name, $dataOrder);
                    $_SESSION[$session_name] = $dataOrder; 


                }

            }
            
            if($row['proses'] == "baru") { 
                $nomor_urut = $this->getDapurNoUrut();
                $no_item = $this->getNoItem($no_faktur);
                $arr_dapur = array(
                        "nomorurut" => $nomor_urut,
                        "kd_dapur" => $row['menu']->kd_dapur,
                        "kode_barang" => $row['menu']->kode,
                        "qty" => $row['jumlah'],
                        "no_meja" => $row['no_meja'],
                        "status" => 'BELUM DI PRINT',
                        "no_faktur_jual" => $no_faktur,
                        "no_urut_jual" => $no_item,
                        "keterangan" => $row['keterangan'],
                        
                );
                $this->db->insert("dapur_monitor", $arr_dapur);


            
            
                        $arr_item_penjualan = array(
                            "order_no" => $no_faktur,
                            "kode_barang" => $row['menu']->kode,
                            "nama_barang" => $row['menu']->nama,
                            "qty" => $row['jumlah'],
                            "unit" => $row['menu']->satuan,
                            "harga" => $row['menu']->harga, 
                            "jumlah" => $row['jumlah'] * $row['menu']->harga,
                            "no" => $nomor_urut,
                            "keterangan" => $row['keterangan']
                        );
                

                $this->db->insert("item_penjualan",$arr_item_penjualan);
            }

        endforeach;

        $session_name = "tmp_order" . $no_meja;
        // $this->session->unset_userdata($session_name);
        unset($_SESSION[$session_name]);
        echo json_encode(array("error"=>false,"url"=>site_url("Homepage")));

        
       
        
        

    }


    function getDapurNoUrut(){
        $this->db->order_by("nomorurut","desc");
        $this->db->limit(1);
        $urutan = $this->db->get("dapur_monitor")->row();
        return isset($urutan->nomorurut)?($urutan->nomorurut+1):1; 
    }

    function getNoItem($no_faktur){
        $this->db->where("order_no",$no_faktur);
        $this->db->order_by("no","desc");
        $items = $this->db->get("item_penjualan")->row();
        return isset($items->no)?($items->no + 1): 1; 
        
    }


    function kode_baru_transaksi($s)
    {
        $s = $s + 1;
        $d = $s;
        $d = date("dmy") . str_pad($d, 3, "0", STR_PAD_LEFT);

        $this->db->where("order_no",$d);
        $dataOrder = $this->db->get("penjualan");
        if($dataOrder->num_rows() > 0){
            return $this->kode_baru_transaksi($s);
        }
        else {
            return (string)$d;
        }


        // $sql = "select order_no from penjualan where order_no='" . $d . "'";
        // $query = mysql_query($sql);
        // $jumlahrec = mysql_num_rows($query);
        // if ($jumlahrec != 0) {
        //     return kode_baru_transaksi($s);
        // } else {
        //     return (string)$d;
        // };
    }

    function getSessionDetail(){
        $post = $this->input->post();
        extract($post);
        $session_name = "tmp_order" . $no_meja;
        $tmp  =  $_SESSION[$session_name]; //$this->session->userdata($session_name);
        $tmp[$index]['index'] = $index;
        echo json_encode($tmp[$index]);
        
    }
}
?>