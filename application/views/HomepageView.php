<div class="row">
    <div class="col-12">

        <div class="card">

            <div class="card-body" style="min-height: 400px;">
                
                <div class="row">
                  <?php foreach ($records->result() as $row) : 
                    $class = ($row->status == "BAYAR")?"btn-primary":
                    "btn-secondary";
                    // $link = ($row->status == "BAYAR")?site_url("Homepage/PlaceOrder/$row->nomor"):"#!";
                    $link = site_url("Homepage/PlaceOrder/$row->nomor");

                    ?>
                    <div class="col-4 mb-1">
                      <a href="<?php echo $link; ?>" class="btn <?php echo $class; ?> btn-block"><?php echo $row->nomor; ?></a>
                    </div>
                  <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

</div>




