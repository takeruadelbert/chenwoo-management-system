<div class="text-center" style="font-size:16px;font-weight: bold">
    <span>Perhitungan Pemakaian Material Tambahan</span>
</div>
<br/>
<table style="font-size:10px" class="no-border">
    <tbody>
        <tr>
            <td width="100">Nomor Penjualan</td>
            <td width="5">:</td>
            <td><?= $this->data['Sale']['sale_no'] ?></td>
        </tr>
        <tr>
            <td>Nomor PO</td>
            <td>:</td>
            <td><?= $this->data['Sale']['po_number'] ?></td>
        </tr>
        <tr>
            <td>Pembeli</td>
            <td>:</td>
            <td><?= $this->data['Buyer']['company_name'] ?></td>
        </tr>
    </tbody>
</table>
<br/>
<table width="100%" class="table-data">                        
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama Produk") ?></th>
            <th width="145"><?= __("Jenis MC") ?></th>
            <th width="45"><?= __("Jumlah MC") ?></th>
            <th width="55"><?= __("Harga Satuan (Rp)") ?></th>
            <th width="80"><?= __("Total Biaya MC (Rp)") ?></th>
            <th width="145"><?= __("Jenis Plastik") ?></th>
            <th width="45"><?= __("Jumlah Plastik") ?></th>
            <th width="55"><?= __("Harga Satuan (Rp)") ?></th>
            <th width="80"><?= __("Total Biaya Plastik (Rp)") ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $grandTotalMc = 0;
        $grandTotalPlastik = 0;
        foreach ($this->data["SaleDetail"] as $k => $saleDetail) {
            $totalMC = ceil(@$saleDetail["quantity"] * @$saleDetail["McUsage"]["ProductMaterialAdditional"]["quantity"]);
            $totalPlastic = ceil(@$saleDetail["nett_weight"] * @$saleDetail["PlasticUsage"]["ProductMaterialAdditional"]["quantity"]);
            $grandTotalMc+=$biayaMC = @$saleDetail["McUsage"]["MaterialAdditional"]["price"] * $totalMC;
            $grandTotalPlastik+=$biayaPlastic = @$saleDetail["PlasticUsage"]["MaterialAdditional"]["price"] * $totalPlastic;
            ?>
            <tr>
                <td class="text-center"><?= $k + 1 ?></td>
                <td class="text-left"><?= $saleDetail["Product"]["Parent"]["name"] ?> - <?= $saleDetail["Product"]["name"] ?></td>
                <td class="text-<?= empty($saleDetail["McUsage"]["MaterialAdditional"]["name"]) ? "center" : "left" ?>"><?= emptyToStrip(@$saleDetail["McUsage"]["MaterialAdditional"]["name"]) ?></td>
                <td class="text-right"><?= ic_decimalseperator($totalMC) ?></td>
                <td class="text-right"><?= ic_rupiah(@$saleDetail["McUsage"]["MaterialAdditional"]["price"]) ?></td>
                <td class="text-right"><?= ic_rupiah($biayaMC) ?></td>
                <td class="text-<?= empty($saleDetail["PlasticUsage"]["MaterialAdditional"]["name"]) ? "center" : "left" ?>"><?= emptyToStrip(@$saleDetail["PlasticUsage"]["MaterialAdditional"]["name"]) ?></td>
                <td class="text-right"><?= ic_decimalseperator($totalPlastic) ?></td>
                <td class="text-right"><?= ic_rupiah(@$saleDetail["PlasticUsage"]["MaterialAdditional"]["price"]) ?></td>
                <td class="text-right"><?= ic_rupiah($biayaPlastic) ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="10" style="height:5px;padding:0"></td>
        </tr>
        <tr>
            <td class="text-center" colspan="5">Total Biaya Pemakaian MC</td>
            <td class="text-right"><?= ic_rupiah($grandTotalMc) ?></td>
            <td class="text-center" colspan="3">Total Biaya Pemakaian Plastik</td>
            <td class="text-right"><?= ic_rupiah($grandTotalPlastik) ?></td>
        </tr>
        <tr>
            <td colspan="10" style="height:5px;padding:0"></td>
        </tr>
        <tr>
            <td class="text-center" colspan="9">Total Biaya Keseluruhan</td>
            <td class="text-right"><?= ic_rupiah($grandTotalPlastik + $grandTotalMc) ?></td>
        </tr>
    </tfoot>
</table>