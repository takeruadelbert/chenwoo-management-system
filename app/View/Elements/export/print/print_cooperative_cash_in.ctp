<?php
if (!empty($data)) {
    ?>
    <table class = "table-bordered">
        <tr>
            <td colspan="2">
                <table>
                    <tr>
                        <td width="20%">No. Transaksi</td>
                        <td width="1%">:</td>
                        <td width="75%"> <?= $data['rows']['CooperativeCashReceipt']['reference_number'] ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Pembayaran</td>
                        <td>:</td>
                        <td><?= $data['rows']['CooperativeCashReceipt']["CooperativePaymentType"]['name'] ?></td>
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
    <table class="detailBarang" width="100%" style="border: 1px solid black; border-collapse: collapse;">
        <tr>
            <th class="text-center" style="border: 1px solid black;">No.</th>
            <th class="text-center" style="border: 1px solid black;">Nama Barang</th>
            <th class="text-center" style="border: 1px solid black;">Jumlah</th>
            <th class="text-center" colspan="2" style="border: 1px solid black;">Harga Satuan</th>
            <th class="text-center" style="border: 1px solid black;">Diskon</th>
            <th class="text-center" colspan="2" style="border: 1px solid black;">Total</th>
        </tr>
        <?php
            $i = 1;
            $total = 0;
            $totalPenjualan = 0;
            foreach ($data['rows']['CooperativeCashReceipt']['CooperativeCashReceiptDetail'] as $detail) {
                $discount = $detail['quantity'] * $detail['price'] * $detail['discount'] / 100;
                $total = ($detail['quantity'] * $detail['price']) - $discount;
                $totalPenjualan += $total;
        ?>
        <tr>
            <td class="text-center" style="border: 1px solid black;"><?= $i ?></td>
            <td class="text-center" style="border: 1px solid black;"><?= $detail['CooperativeGoodList']['name'] ?></td>
            <td class="text-center" style="border: 1px solid black;"><?= $detail['quantity'] ?></td>
            <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
            <td class="text-right"><?= $this->Html->Rp($detail['price']) ?></td>
            <td class="text-center" style="border: 1px solid black;"><?= $detail['discount'] ?> %</td>
            <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
            <td class="text-right"><?= $this->Html->Rp($total) ?></td>
        </tr>
        <?php
                $i++;
            }
        ?>
        <tr>
            <td colspan="6" class="text-right" style="border: 1px solid black;"><strong>Diskon</strong></td>
            <td colspan="2" class="text-right" style="border: 1px solid black;"><?= $data['rows']['CooperativeCashReceipt']['discount'] ?> %</td>
        </tr>
        <tr>
            <td colspan="6" class="text-right" style="border: 1px solid black;"><strong>Grand Total</strong></td>
            <td class="text-left">Rp.</td>
            <td class="text-right"><?= $this->Html->Rp($totalPenjualan) ?></td>
        </tr>
    </table>

    <div class="clear"></div>
    <br/>

    <div class="clear"></div>
<?php } ?>