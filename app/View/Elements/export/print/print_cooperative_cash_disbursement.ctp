<?php
if (!empty($data['rows'])) {
    ?>
    <table class = "table-bordered">
        <tr>
            <td colspan="2">
                <table>
                    <tr>
                        <td width="20%">No. Pembelian</td>
                        <td width="1%">:</td>
                        <td width="75%"> <?php echo $data['rows']['CooperativeCashDisbursement']['cash_disbursement_number'] ?></td>
                    </tr>
                    <tr>
                        <td>Total Penjualan</td>
                        <td>:</td>
                        <td> <?php echo $this->Html->IDR($totalPembelian) ?></td>
                    </tr>
                    <tr>
                        <td>Terbilang</td>
                        <td>:</td>
                        <td><?= angka2kalimat($totalPembelian) ?> rupiah.</td>
                    </tr>
                    <tr>
                        <td colspan="3"><br></td>
                    </tr>
                </table>
            </td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="6">
                <div style="border:1px solid black"></div>
            </td>
        </tr>
        <tr>
            <td colspan="6"><br></td>
        </tr>
    </table>
    <table class="detailBarang" style="border: 1px solid black; border-collapse: collapse;">
        <tr>
            <th class="text-center" style="border: 1px solid black;">No.</th>
            <th class="text-center" style="border: 1px solid black;">Nama Barang</th>
            <th class="text-center" colspan="2" style="border: 1px solid black;">Jumlah</th>
            <th class="text-center" colspan="2" style="border: 1px solid black;">Harga Satuan</th>
            <th class="text-center" style="border: 1px solid black;">Diskon</th>
            <th class="text-center" colspan="2" style="border: 1px solid black;">Total</th>
        </tr>
        <?php
        $i = 1;
        $total = 0;
        foreach ($data['rows']['CooperativeCashDisbursementDetail'] as $detail) {
            $discount = $detail['quantity'] * $detail['amount'] * $detail['discount'] / 100;
            $total = ($detail['quantity'] * $detail['amount']) - $discount;
            ?>
            <tr>
                <td class="text-center" style="border: 1px solid black;"><?= $i ?></td>
                <td class="text-center" style="border: 1px solid black;"><?= $detail['CooperativeGoodList']['name'] ?></td>
                <td class="text-right" style="border: 1px solid black; border-right-style:none !important;" width = "75"><?= $detail['quantity'] ?></td>
                <td class="text-right" style="border: 1px solid black; border-left-style:none !important;" width = "25"><?= $detail['CooperativeGoodList']['CooperativeGoodListUnit']['name'] ?></td>
                <td class="text-center" style = "border: 1px solid black; border-right-style:none !important;" width = "25">Rp. </td>
                <td class="text-right" style="border: 1px solid black; border-left-style:none !important;"><?= $this->Html->Rp($detail['amount']) ?></td>
                <td class="text-center" style="border: 1px solid black;"><?= $detail['discount'] ?> %</td>
                <td class="text-center" style = "border: 1px solid black; border-right-style:none !important;" width = "25">Rp. </td>
                <td class="text-right" style="border: 1px solid black; border-left-style:none !important;"><?= $this->Html->Rp($total) ?></td>
            </tr>
            <?php
            $i++;
        }
        ?>
        <tr>
            <td colspan="7" class="text-right" style="border: 1px solid black;"><strong>Diskon</strong></td>
            <td colspan="2" class="text-right" style="border: 1px solid black;"><?= $data['rows']['CooperativeCashDisbursement']['discount'] ?> %</td>
        </tr>
        <tr>
            <td colspan="7" class="text-right" style="border: 1px solid black;"><strong>Grand Total</strong></td>
            <td class="text-left">Rp.</td>
            <td class="text-right"><?= $this->Html->Rp($totalPembelian) ?></td>
        </tr>
    </table>

    <div class="clear"></div>
    <br/>

    <div class="clear"></div>
<?php } ?>

<script>
    $(document).ready(function () {
        $(document).prop('title', '<?= $data['title'] ?>');
    });
</script>