<?php 

$warna = $this->warna;

$n=0;
foreach($record->result() as $row):

?>

<div class="col-md-4">
    <div class="card text-center <?php  echo $warna[$n]; ?>">
        <div class="card-body">
             <h4 class="text-white card-text"><?php echo $row->OUTPUT ?></p>
            <h2 class="text-white font-weight-bolder"><?php echo $row->JUMLAH ?></h2>
            
        </div>
    </div>

</div>
<?php 
$n++;
endforeach; ?>