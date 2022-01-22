<?php
?>
<style>
#tbhasil > tbody > tr:last-child { background:#ccc; font-weight: bold;  }

</style>

<div class="row mb-3">
	<div class="col-md-2">
		<a href="<?php echo site_url("$this->controller/excel/?bulan=$bulan&tahun=$tahun&menu=$namamenu"); ?>" class="btn btn-success"> <i class="fa fa-file-excel-o"> </i> Export Excel</a>
	</div>
</div>
<?php 
$koloms = $record->field_data();
?>
<div class="table-responsive">
<table id="tbhasil" class="table table-bordered responsive">
	<thead>
		<tr>
			<?php		
			$i=1;
		foreach($koloms as $kolom):
			if($i>2) break;
			?>
			<th class="text-center align-middle" rowspan="2"><?php echo str_replace("'","",$kolom->name); ?></th>
			<?php
			$i++;
		endforeach;
		?>
		<th class="text-center" align="center" colspan="<?php echo count($koloms); ?>"><?php echo strtoupper(namabulan($bulan)); ?></th>
		</tr>
	<tr>
		<?php		
		$i=1;
		foreach($koloms as $kolom):
			// echo $i;
			if($i>2) : 

			?>
			<th><?php echo str_replace("'","",$kolom->name); ?></th>
			<?php
			endif;

		$i++;
		endforeach;
		?>

	</tr>
</thead>
<tbody>
	<?php
	foreach($record->result_array() as $row):
	?>
		<tr>
			<?php foreach($row as $value ): ?>
			<td><?php echo $value; ?></td>
			<?php endforeach;?>
		</tr>

	<?php endforeach; ?>
</tbody>
</table>

</div>