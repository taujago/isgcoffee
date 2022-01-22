<?php 
class Core_model extends CI_Model {

var $arr_jenis;
function __construct(){
        $this->arr_jenis = array(
                1=>"SSH","HSPK","ASB","SBU"
        );
}

function arr_dropdown($vTable, $vINDEX, $vVALUE, $vORDERBY){
                $this->db->order_by($vORDERBY);
                $res  = $this->db->get($vTable);

                $ret = array('' => '== PILIH SATU ==');
                foreach($res->result_array() as $row) : 
                        $ret[$row[$vINDEX]] = $row[$vVALUE];
                endforeach;
                return $ret;

        }


function arr_tipe_ssh(){
    $this->db->protect_identifiers = FALSE;
    $this->db->select('tipe_ssh')
    ->from('m_asset')
    ->group_by('tipe_ssh');
    $res = $this->db->get();

    $arr = array('x'=>'== SEMUA JENIS SSH == ');
    foreach($res->result() as $row): 
        if($row->tipe_ssh=="") continue;
        $arr[$row->tipe_ssh] = $row->tipe_ssh;
    endforeach;

    return $arr;
}

function arr_dropdown_nohead($vTable, $vINDEX, $vVALUE, $vORDERBY){
                $this->db->order_by($vORDERBY);
                $res  = $this->db->get($vTable);
         

                $ret = array();
                foreach($res->result_array() as $row) : 
                        $ret[$row[$vINDEX]] = $row[$vVALUE];
                endforeach;
                
                return $ret;

        }


function arr_dropdown_tahun(){
    $arr_tahun = array('' => '== PILIH TAHUN ==');
            $year = date('Y');
            for ($i=$year; $i >= 2003; $i--) { 
                $arr_tahun[$i] = $i;
            }
    return $arr_tahun;
}


        


    function add_arr_head($arr,$index,$str) {
	  $res[$index] = $str;
	  foreach($arr as $x => $y) : 
	  	$res[$x] = $y;
	  endforeach;
	  return $res;
	}

 

    function arr_dropdown2($vTable, $vINDEX, $vVALUE, $vORDERBY, $field, $search){
                $this->db->where($field, $search);
                $this->db->order_by($vORDERBY);
                $res  = $this->db->get($vTable);
                
                $ret = array();
                
                foreach($res->result_array() as $row) : 
                        $ret[$row[$vINDEX]] = $row[$vVALUE];
                endforeach;
                return $ret;

        }  


        function arr_menu(){
                $arr =array();
                $this->db->order_by("nama");
                $res = $this->db->get("makanan_minuman");

                foreach($res->result() as $row):
                        $arr[$row->kode] = $row->nama." Rp ".number_format($row->harga,0,',','.');
                endforeach;
                return $arr;
        }
}
