<?php
if (!empty($data['rows'])) {
    ?>
    <table width="100%" border="0" align="center">
        <tr>
            <td style="text-align:center; font-style:italic; font-size:6px;">No : <?php echo $data['rows']['CooperativeCashReceipt']['reference_number'] ?></td>
        </tr>
    </table>
    <br />
    <?php
    if ($data["rows"]["CooperativeCashReceipt"]["cooperative_payment_type_id"] == 2) {
        ?>
        <table width="100%">
            <tr>
                <td width="23%" style="text-align:left; font-size:6px; border-bottom:1px solid #000;">Nama Pegawai</td>
                <td width="1" style="text-align:center;font-size:6px; border-bottom:1px solid #000;">:</td>
                <td width="30%" style="text-align:left; font-size:6px; border-bottom:1px solid #000;"><?= $data["rows"]["EmployeeDataLoan"]["Employee"]["Account"]["Biodata"]["full_name"] ?></td>
                <td width="1" rowspan="3" style="text-align:left; font-size:6px;">&nbsp;</td>
                <td width="16%" style="text-align:left; font-size:6px; border-bottom:1px solid #000;">Waktu Transaksi</td>
                <td width="1" style="text-align:center; font-size:6px; border-bottom:1px solid #000;">:</td>
                <td width="40%" style="text-align:left; font-size:6px; border-bottom:1px solid #000;"><?= $this->Html->cvtTanggal($data["rows"]["CooperativeCashReceipt"]["date"]) ?></td>
            </tr>
            <tr>
                <td width="23%" style="text-align:left; font-size:6px; border-bottom:1px solid #000;">NIK</td>
                <td width="1" style="text-align:center; font-size:6px; border-bottom:1px solid #000;">:</td>
                <td width="30%" style="text-align:left; font-size:6px; border-bottom:1px solid #000;">2001020122</td>
                <td width="16%" style="text-align:left; font-size:6px; border-bottom:1px solid #000;">Kasir</td>
                <td width="1" style="text-align:center; font-size:6px; border-bottom:1px solid #000;">:</td>
                <td width="40%" style="text-align:left; font-size:6px; border-bottom:1px solid #000;"><?= $data["rows"]["Operator"]["Account"]["Biodata"]["full_name"] ?></td>
            </tr>
            <tr>
                <td width="23%" style="text-align:left;font-size:6px; border-bottom:1px solid #000;">Tipe Pembayaran</td>
                <td width="1" style="text-align:center; font-size:6px; border-bottom:1px solid #000;">:</td>
                <td width="30%" style="text-align:left; font-size:6px; border-bottom:1px solid #000;"><?= $data['rows']["CooperativePaymentType"]['name'] ?></td>
                <td width="16%" style="text-align:left; font-size:6px; border-bottom:1px solid #000;">No. Kredit</td>
                <td width="1" style="text-align:left; font-size:6px; border-bottom:1px solid #000;">:</td>
                <td width="40%" style="text-align:left; font-size:6px; border-bottom:1px solid #000;"><?= $data["rows"]["EmployeeDataLoan"]["receipt_loan_number"] ?></td>
            </tr>
        </table>
        <?php
    } else {
        ?>
        <table width="100%">
            <tr>
                <td style="text-align:left; font-size:6px; border-bottom:1px solid #000;">No. Transaksi</td>
                <td style="text-align:center; font-size:6px; border-bottom:1px solid #000;">:</td>
                <td style="text-align:left; font-size:6px; border-bottom:1px solid #000;"><?php echo $data['rows']['CooperativeCashReceipt']['reference_number'] ?></td>
                <td width="1" rowspan="4" style="text-align:left; font-size:6px;">&nbsp;</td>

            </tr>
            <tr>
                <td width="23%" style="text-align:left; font-size:6px; border-bottom:1px solid #000;">Waktu Transaksi</td>
                <td width="1" style="text-align:center; font-size:6px; border-bottom:1px solid #000;">:</td>
                <td width="30%" style="text-align:left; font-size:6px; border-bottom:1px solid #000;"><?= $this->Html->cvtTanggal($data["rows"]["CooperativeCashReceipt"]["date"]) ?></td>
                <td width="15%" style="text-align:left; font-size:6px; border-bottom:1px solid #000;">Kasir</td>
                <td width="1" style="text-align:center; font-size:6px; border-bottom:1px solid #000;">:</td>
                <td width="40%" style="text-align:left; font-size:6px; border-bottom:1px solid #000;"><?= $data["rows"]["Operator"]["Account"]["Biodata"]["full_name"] ?></td>
            </tr>
        </table>
        <?php
    }
    ?>
    <br>
    <table width="100%" class="detailBarang" style="border: 1px solid black; border-collapse: collapse; font-size: 9px;">
        <tr>
            <th class="text-center" style="border: 1px solid black; font-size: 6px; width:1%;">No</th>
            <th class="text-center" style="border: 1px solid black; font-size: 6px; width:35%;">Nama Barang</th>
            <th class="text-center" colspan="2" style="border: 1px solid black; font-size: 6px; width:3%;">Qty</th>
            <th class="text-center" colspan="2" style="border: 1px solid black; font-size: 6px;">Harga Satuan</th>
            <th width="5%" class="text-center" style="border: 1px solid black; font-size: 6px; width:3%;">Disc</th>
            <th class="text-center" colspan="2" style="border: 1px solid black; font-size: 6px;">Total</th>
        </tr>
        <?php
        $i = 1;
        $total = 0;
        foreach ($data['rows']['CooperativeCashReceiptDetail'] as $detail) {
            $discount = $detail['quantity'] * $detail['price'] * $detail['discount'] / 100;
            $total = ($detail['quantity'] * $detail['price']) - $discount;
            ?>
            <tr>
                <td class="text-center" style="border: 1px solid black; font-size: 6px;" width="1" ><?= $i ?></td>
                <td class="text-left" style="border: 1px solid black; font-size: 6px;" width="47%"><?= $detail['CooperativeGoodList']['name'] ?></td>
                <td class="text-right" style="border-bottom: 1px solid black; font-size: 6px;" width="1"><?= $detail['quantity'] ?></td>
                <td class="text-right" style="border-right: 1px solid black;border-bottom: 1px solid black; font-size: 6px;"><?= $detail['CooperativeGoodList']['CooperativeGoodListUnit']['name'] ?></td>
                <td class="text-center" style = "border-bottom: 1px solid black !important; font-size: 6px;" width = "1%">Rp. </td>
                <td width="5%" class="text-right" style="font-size: 6px; border-bottom: 1px solid black"><?= $this->Html->Rp($detail['price']) ?></td>
                <td class="text-right" style="border: 1px solid black; font-size: 6px; text-align: right;" width="15%"><?= $detail['discount'] ?> %</td>
                <td class="text-center" style = "border-right-style: none !important; font-size: 6px; border-bottom: 1px solid black" width = "1%">Rp. </td>
                <td class="text-right" style="font-size:6px; border-bottom: 1px solid black;" width="10%"><?= $this->Html->Rp($total) ?></td>
            </tr>
            <?php
            $i++;
        }
        ?>
        <tr>
            <td colspan="7" class="text-right" style="border: 1px solid black; font-size: 6px;"><strong>Diskon</strong></td>
            <td colspan="2" class="text-right" style="border: 1px solid black; font-size: 6px; "><?= $data['rows']['CooperativeCashReceipt']['discount'] ?> %</td>
        </tr>
        <tr>
            <td colspan="7" class="text-right" style="border: 1px solid black; font-size: 6px;"><strong>Grand Total</strong></td>
            <td class="text-left" style="font-size:6px">Rp.</td>
            <td class="text-right" style="font-size:6px"><?= $this->Html->Rp($totalPenjualan) ?></td>
        </tr>
    </table>
    <p>&nbsp;</p>
    <table width="100%" border="0">
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="30%" style="text-align:center; font-size:6px; font-family:Tahoma, Geneva, sans-serif;">Kasir</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="30%">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="30%" style="border-top:1px solid #000; font-family:Tahoma, Geneva, sans-serif; font-size:6px; text-align: center;"><?= $data["rows"]["Operator"]["Account"]["Biodata"]["full_name"] ?></td>
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