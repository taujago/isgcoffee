<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="bulan"><strong>Bulan</strong></label>
                            <?php 
                            $bulan = date("m");
                        $arr  = $this->cm->arr_bulan;
                        echo form_dropdown("bulan",$arr,$bulan,'class="form-control" id="bulan"'); ?>
                        </div>

                    
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="tahun"><strong>Tahun</strong></label>
                            <input type="number" autocomplete="off" name="tahun" id="tahun" class="form-control" step=1 value="<?php echo date("Y"); ?>" />
                        </div>

                    
                    </div>
                    
                </div>
                <div class="row">
                <div class="col-md-2">
                        <div class="form-group">
                            <label for="tahun"><strong>&nbsp;</strong></label>
                            <a href="#!" id="tombol" class="btn btn-primary">QUERY</a>
                        </div>

                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body" id="hasil">

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#tombol").click(function(){
            $.ajax({
                url : '<?php echo site_url("Laporan/getLaporan"); ?>',
                data : {bulan : $("#bulan").val(), tahun : $("#tahun").val()},
                type : 'post',
                success : function(htmldata) {
                    $("#hasil").html(htmldata);
                }
            });
        });
    });
</script>