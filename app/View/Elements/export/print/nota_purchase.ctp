<?php
if (!empty($data['rows'])) {
    ?>
    <style>
        .table-bordered,tr,td{
            border:1px solid black;
            border-collapse: collapse;
        }
    </style>
    <div style="float:left;width:550px;">
        <div>PT. CHEN WOO FISHERY MAKASSAR</div>
        <div><?php echo $data['title'] ?></div>
    </div>
    <div style="float:left;">
        <div style=''>Tanggal: <?php echo $data['rows'][0]['Purchase']['created'] ?></div>
        <div>Nota No: <?php echo $data['rows'][0]['Purchase']['purchase_no'] ?></div>
    </div>
    <div style="clear: both;"></div>
    <table class="table-bordered" style="margin-top:10px;"> 
        <tr style="text-align:center;">
            <td width="30px">NO</td>
            <td width="250px">NAMA</td>
            <td width="80px">Jumlah</td>
            <td width="80px">Unit</td>
            <td width="160px">Harga</td>
            <td width="160px">Subtotal</td>
        </tr>
        <?php
        $number = 1;
        $grandTotal = 0;
        foreach ($data['rows'][0]['PurchaseDetail'] as $material) {
            //foreach($items['TransactionMaterialEntry'] as $materials){
            ?>
            <!--Set List-->
            <tr>
                <td><?= $number ?></td>
                <td style="text-align:center;"><?= $material['ProductSize']['Product']['name'] . ' - ' . $material['ProductSize']['name'] ?></td>
                <td><?= $material['quantity'] ?></td>
                <td><?= $material['ProductSize']['ProductUnit']['name'] ?></td>
                <td><?= $this->Html->IDR($material['price']) ?></td>
                <td><?= $this->Html->IDR($material['quantity'] * $material['price']) ?></td>
            </tr> 
            <?php
            $number++;
            $grandTotal += $material['quantity'] * $material['price'];
        }
        ?>
        <tr>
            <td colspan="5"><p style="text-align:right;padding-right:10px;">Grand Total<p></td>
            <td><?= $this->Html->IDR($grandTotal) ?></td>
        </tr> 
    </table>


<?php } ?>