<link rel="stylesheet" type="text/css" href="<?php echo base_url("vuexy"); ?>/app-assets/css/pages/ui-feather.css">
<?php 
foreach($record as $index => $tmp) : 
    if($tmp['proses']=="hapus") continue;
?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-7">
                <?php echo $tmp['menu']->nama. "<br /> ". $tmp['jumlah'] . " x Rp ". number_format($tmp['menu']->harga,0)?> 
                
            </div>
            <div class="col-2">
                <a href="#!" onclick="edit('<?php echo $index; ?>')" class="btn btn-sm btn-warning"> Edit </a>
                
            </div>
            <div class="col-2">
            <a href="#!" onclick="hapus('<?php echo $index; ?>')" class="btn btn-sm btn-danger"> Hapus </a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>