<form id="frmquery" method="post">
<div class="row">

	<!-- <div class="col-md-3">
		<div class="form-group">
			<label for="bulan"><strong>PERIODE LAPORAN</strong></label>
			<?php 
				$arr_periode = [""=>"== PILIH PERIODE ==","h"=>"HARIAN","b"=>"BULANAN"];
				echo form_dropdown("periode",$arr_periode,'','class="form-control" id="periode"');
			?>
		</div>
	</div> -->


	<div  class="col-md-3 harian">
		<div class="form-group">
			<label for="bulan"><strong>TANGGAL AWAL</strong></label>
			 <input type="text" id="tanggal_awal" name="tanggal_awal" data-date-format="dd-mm-yyyy" class="form-control" autocomplete="off">
		</div>
	</div>

	<div  class="col-md-3 harian">
		<div class="form-group">
			<label for="bulan"><strong>TANGGAL AKHIR</strong></label>
			 <input type="text" id="tanggal_akhir" name="tanggal_akhir" data-date-format="dd-mm-yyyy" class="form-control" autocomplete="off">
		</div>
	</div>

	<div  class="col-md-3 bulanan">
		<div class="form-group">
			<label for="bulan"><strong>BULAN</strong></label>
			<?php 
				$arr_bulan = $this->arr_bulan;
				echo form_dropdown("bulan",$arr_bulan,'','class="form-control" id="bulan"');
			?>
		</div>
	</div>
	<div  class="col-md-3 bulanan">
		<div class="form-group">
			<label for="bulan"><strong>TAHUN</strong></label>
			<input type="number" min="2000" name="tahun" id="tahun" class="form-control" value="<?php echo date("Y"); ?>" />
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group align-bottom">
			<label for="bulan"><strong>&nbsp;</strong></label><br />
			 <input type="submit"  id="btnQuery" class="btn btn-primary btn-block" value="TAMPILKAN" /> 
			<!-- <input type="submit" value="Simpan" class="btn btn-primary"> -->
		</div>
	</div>
</div>
</form>


<div class="row">
	<div id="hasil" class="col-md-12">
	</div>
</div>

