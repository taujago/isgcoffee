<div class="row">
    <div class="col-12">

        <div class="card">

            <div class="card-body">               
                 
                
                        <h3>PEMESANAN MEJA <?php echo $no_meja; ?></h3>
                        <hr />
                        <div class="row mt-1">
                            <div class="col-6">
                                <a href="#!" id="btn-tambah" class="btn btn-primary"><i data-feather='plus-square'></i>Tambah</a>

                            </div>
                            <div class="col-6">
                                <a href="<?php echo site_url("Homepage"); ?>" id="back" class="btn btn-danger"><i data-feather='arrow-left'></i></i>Kembali</a>
                            </div>
                        </div>   
            </div>
        </div>
    </div>

</div>







<div class="row">
    <div class="col-12" id="listMenu">

    </div>
</div>

<div class="card">

    <div class="card-body">     
        <div class="row">
            <div class="col-12">
                <a href="#!" id="konfirmasi" class="btn btn-block btn-lg btn-info">Konfirmasi</a>
            </div>
        </div>
    </div>
</div>



<div id="modaltambah" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="row ml-1 mr-1 mb-2">
                <div class="col-12">
                    <div class="form-group">
                        <label>Menu Makanan / Minuman</label>
                        <?php
                        echo form_dropdown("kode_barang", $this->cm->arr_menu(), '', 'class="form-control" id="kode_barang"');
                        ?>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="text" name="jumlah" id="jumlah" value="1" class="form-control touchspin" autocomplete="off" />
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" id="keterangan" name="keterangan" class="form-control" autocomplete="off" />
                    </div>
                </div>

                <input type="hidden" name="index" id="index" />
                <input type="hidden" name="mode" id="mode" />

                <div class="col-6">
                    <button id="simpanorder" class="btn btn-primary btn-block"><i data-feather='save'></i> Simpan</button>
                </div>
                <div class="col-6">
                    <button id="batal" class="btn btn-danger btn-block"> <i data-feather='x'></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        getMenuByTable();
        $("#kode_barang").select2();

        $("#kode_barang").select(function() {
            $("#jumlah").focus();
        });


        $("#btn-tambah").click(function() {
            $("#modaltambah").modal('show');
        });

        $("#batal").click(function() {
            $("#modaltambah").modal('hide');
        });

        $("#simpanorder").click(function() {
            $.ajax({
                url: '<?php echo site_url("Homepage/saveOrder"); ?>',
                dataType: 'json',
                type: 'post',
                data: {
                    kode_barang: $("#kode_barang").val(),
                    jumlah: $("#jumlah").val(),
                    keterangan: $("#keterangan").val(),
                    no_meja: '<?php echo $no_meja ?>',
                    index: $("#index").val(),
                    mode: $("#mode").val()
                },
                success: function(obj) {
                    console.log('madafakaaaa');
                    $("#modaltambah").modal('hide');
                    getMenuByTable();
                }
            });
        });


        $("#konfirmasi").click(function() {
            Swal.fire({
                title: 'Konfirmasi Pesanan',
                text: "Pesanan akan disimpan. Konfirmasi lagi ke pelanggan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Konfirmasi'
            }).then((result) => {
                console.log('madafakaaa..');
                console.log(result);

                if (result.value == true) {
                    console.log('Eksekusi ');
                    $.ajax({
                        url: '<?php echo site_url("Homepage/ConfirmOrder/$no_meja"); ?>',
                        dataType: 'json',
                        success: function(obj) {
                            location.href = (obj.url);
                        }
                    });
                }
            })

        });







    });


    function getMenuByTable() {
        // listMenu
        $.ajax({
            url: '<?php echo site_url("Homepage/getMenuByTable/$no_meja"); ?>',
            success: function(htmldata) {
                $("#listMenu").html(htmldata);
            }
        });
    }

    function edit(index) {
        console.log('index edit ' + index);
        $.ajax({
            url: '<?php echo site_url("Homepage/getSessionDetail/") ?>',
            data: {
                index: index,
                no_meja: '<?php echo $no_meja; ?>'
            },
            dataType: 'json',
            type: 'post',
            success: function(obj) {
                console.log(obj);

                $("#kode_barang").val(obj.menu.kode).change();
                $("#jumlah").val(obj.jumlah);
                $("#keterangan").val(obj.keterangan);
                $("#index").val(obj.index);
                $("#mode").val('edit');
                $("#modaltambah").modal('show');

            }
        });

    }


    function hapus(index) {



        Swal.fire({
            title: 'Hapus Pesanan',
            text: "Pesanan akan dihapus",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Konfirmasi'
        }).then((result) => {
            console.log('madafakaaa..');
            console.log(result);

            if (result.value == true) {
                console.log('Eksekusi ');
                $.ajax({
                    url: '<?php echo site_url("Homepage/deleteOrder/") ?>',
                    data: {
                        index: index,
                        no_meja: '<?php echo $no_meja; ?>'
                    },
                    dataType: 'json',
                    type: 'post',
                    success: function(obj) {
                        getMenuByTable();

                    }
                });

            }
        })

    }
</script>