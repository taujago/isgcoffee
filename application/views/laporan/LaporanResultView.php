<table class="table table-stripped">
    <thead>
        <tr>
            <th>DAPUR</th>
            <th>JUMLAH </th>

        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0; 
        foreach($record->result() as $row): 
            $total += $row->JUMLAH;
        ?>
        <tr>
            <td><?php echo $row->kode ?></td>
            <td align="right"><?php echo number_format($row->JUMLAH,0,',','.') ?></td>
        </tr>

        <?php endforeach; ?>
        <tr >
            <td><strong>TOTAL</strong></td>
            <td  align="right" ><strong><?php echo number_format($total,0,',','.') ?></strong></td>
        </tr>
    </tbody>


</table>