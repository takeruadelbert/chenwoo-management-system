<?php
if (!empty($data['rows'])) {
    ?>
    <table width="100%" class = "text-center">
        <tr>
            <td>PT. CHENWOO FISHERY</td>
        </tr>
        <tr>
            <td><b>N O T A  P E M B E L I A N</b></td>
        </tr>
        <tr>
            <td>No :  <?= $data['rows'][0]['MaterialEntry']['material_entry_number'] ?></td>
        </tr>
    </table>
    <table width="100%" style="margin-top:30px;">
        <tr>
            <td>Nama Supplier </td>
            <td> : </td>
            <td> <?= $data['rows'][0]['Supplier']['name'] ?> </td>
            <td>Tanggal Nota Timbang </td>
            <td> : </td>
            <td> <?= $this->Html->cvtTanggal($data['rows'][0]['MaterialEntry']['created']) ?></td>
        </tr>
        <tr>
            <td>Alamat </td>
            <td> : </td>
            <td><?= $data['rows'][0]['Supplier']['address'] ?> </td>
            <td>Tanggal Bayar </td>
            <td> : </td>
            <td> <?= $this->Html->cvtTanggal($data['rows'][0]['TransactionEntry']['created_date']) ?></td>
        </tr>
    </table>
    <table class="table-bordered" style="margin-top:30px; width: 100%"> 
        <tr style="text-align:center; border: 1px solid;">
            <td class = "text-center" style="border: 1px solid;" width="30px">No</td>
            <td class = "text-center" width="200px" style="border: 1px solid;">Jenis</td>
            <td class = "text-center" width="80px" style="border: 1px solid;">Jumlah</td>
            <td class = "text-center" width="80px" style="border: 1px solid;">Satuan</td>
            <td class = "text-center" width="200px" colspan = "2" style="border: 1px solid;">Harga Satuan</td>
            <td class = "text-center" width="200px" colspan = "2" style="border: 1px solid">Total</td>
        </tr>
        <?php
        $number = 1;
        $grandTotal = 0;
        $totalWeight = 0;
        foreach ($data['rows'][0]['TransactionMaterialEntry'] as $material) {
            ?>
            <!--Set List-->
            <tr style="text-align:center; border: 1px solid;">
                <td class = "text-center" style="border: 1px solid;"><?= $number ?></td>
                <td class = "text-center" style="border: 1px solid;"><?= $material['MaterialDetail']['name'] ?></td>
                <td class = "text-center" style="border: 1px solid;"><?= $material['weight'] ?></td>
                <td class = "text-center" style="border: 1px solid;"><?= $material['MaterialDetail']['Unit']['uniq'] ?></td>
                <td class = "text-center" style = "border: 1px solid; border-right: none !important;">Rp.</td>
                <td class = "text-right" style = "border: 1px solid; border-left: none !important;"><?= $this->Html->Rp($material['price']) ?></td>
                <td class = "text-center" style = "border: 1px solid; border-right: none !important;">Rp.</td>
                <td class = "text-right" style = "border: 1px solid; border-left: none !important;"><?= $this->Html->Rp($material['weight'] * $material['price']) ?></td>
            </tr> 
            <?php
            $number++;
            $grandTotal += $material['weight'] * $material['price'];
            $totalWeight += $material['weight'];
        }
        ?>
        <tr style = "border: 1px solid">
            <td class = "text-center"></td>
            <td class = "text-center"></td>
            <td class = "text-center" style = "border: 1px solid"><?= $totalWeight ?></td>
            <td class = "text-center" style = "border: 1px solid"><?= $material['MaterialDetail']['Unit']['uniq'] ?></td>
            <td class = "text-center"></td>
            <td class = "text-right"></td>
            <td class = "text-center"></td>
            <td class = "text-right"></td>
        </tr>
        <tr style = "border: 1px solid">
            <td class = "text-right" colspan = "6" style = "border: 1px solid">Grand Total : </td>
            <td class = "text-center" style = "border: 1px solid; border-right: none !important;">Rp.</td>
            <td class = "text-right" style = "border: 1px solid; border-left: none !important;"><?= $this->Html->Rp($grandTotal) ?></td>
        </tr>
        <?php
        if (empty($data['rows'][0]['PaymentPurchase']) || $data['rows'][0]['PaymentPurchase'][0]['verify_status_id'] == 1 || $data['rows'][0]['PaymentPurchase'][0]['verify_status_id'] == 2) {
            ?>
            <tr style = "border: 1px solid">
                <td class = "text-right" colspan = "6" style = "border: 1px solid">Panjar : </td>
                <td class = "text-center" style = "border: 1px solid; border-right: none !important;">Rp.</td>
                <td class = "text-right" style = "border: 1px solid; border-left: none !important;"> - </td>
            </tr>
            <?php
        } else {
            ?>
            <tr style = "border: 1px solid">
                <td class = "text-right" colspan = "6" style = "border: 1px solid">Panjar : </td>
                <td class = "text-center" style = "border: 1px solid; border-right: none !important;">Rp.</td>
                <td class = "text-right" style = "border: 1px solid; border-left: none !important;"> <?= $this->Html->Rp($data['rows'][0]['PaymentPurchase'][0]['amount']) ?> </td>
            </tr>
            <?php
        }
        ?>
        <tr style = "border: 1px solid">
            <td class = "text-right" colspan = "6" style = "border: 1px solid">Sisa Pembayaran : </td>
            <td class = "text-center" style = "border: 1px solid; border-right: none !important;">Rp.</td>
            <td class = "text-right" style = "border: 1px solid; border-left: none !important;"><?= $this->Html->Rp($data['rows'][0]['TransactionEntry']['remaining']) ?></td>
        </tr>
        <tr style = "border: 1px solid">
            <td class = "text-left" colspan = "8" style = "border: 1px solid">Terbilang : <?= ucwords(angka2kalimat($grandTotal)) ?> Rupiah</td>
        </tr> 
    </table>
    <br/>
    <table>
        <tr>
            <td class = "text-center">Keterangan </td>
            <td class = "text-center">: </td>
            <td class = "text-left" colspan = "6"></td>
        </tr> 
    </table>
    <center>
        <table style="margin-top:50px;">
            <tr>
                <td class = "text-center">Supplier</td>
                <td class = "text-center" width = "150px"></td>
                <td class = "text-center">Kasir</td>
            </tr>
            <tr style="height:80px;"> </tr>
            <tr>
                <td class = "text-center" style = "border-top: 1px solid"><?= $data['rows'][0]['Supplier']['name'] ?></td>
                <td class = "text-center" width = "150px"></td>
                <td class = "text-center" style = "border-top: 1px solid"><?= $data['rows'][0]['Employee']['Account']['Biodata']['full_name'] ?></td>
            </tr>
        </table>
    </center>
<?php } ?>