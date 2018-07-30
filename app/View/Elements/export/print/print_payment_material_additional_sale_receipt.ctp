<?php
if (!empty($data['rows'])) {
    ?>
    <table>
        <tr>
            <td colspan="2">
                <table style="font-family:Tahoma, Geneva, sans-serif; font-size:10px;">
                    <tr><td width ="200">Diterima dari</td><td width =1>:</td><td> <?php echo $data['rows']['MaterialAdditionalSale']['Supplier']['name'] ?></td></tr>
                    <tr>
                        <td>Nomor Invoice</td>
                        <td width="1">:</td>
                        <td><?= $data['rows']['MaterialAdditionalSale']['no_sale'] ?></td>
                    </tr>
                    <tr>
                        <td>Nomor Kwitansi</td>
                        <td width="1">:</td>
                        <td><?= $data['rows']['PaymentSaleMaterialAdditional']['receipt_number'] ?></td>
                    </tr>
                    <tr><td>Sejumlah uang</td><td width =1>:</td><td> Rp. <?php echo number_format(abs($data['rows']['PaymentSaleMaterialAdditional']['amount']), 0, ',', '.') ?>,-</td></tr>
                    <tr><td>Terbilang</td><td width =1>:</td><td> <?php echo angka2kalimat((int)$data['rows']['PaymentSaleMaterialAdditional']['amount']) ?> rupiah</td></tr>
                    <tr><td>Sisa Pembayaran</td><td width =1>:</td><td> Rp. <?php echo number_format(abs($data['rows']['PaymentSaleMaterialAdditional']['remaining']), 0, ',', '.') ?>,-</td></tr>
                    <tr>
                        <td>Tanggal Bayar</td>
                        <td width="1">:</td>
                        <td><?= $this->Html->cvtTanggal($data['rows']['PaymentSaleMaterialAdditional']['payment_date']) ?></td>
                    </tr>
                    <tr><td>Untuk Keperluan</td><td width =1>:</td><td> <?php echo ucwords($data['rows']['PaymentSaleMaterialAdditional']['note']) ?></td></tr>
                </table>
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>


    <div class="clear"></div>
    <br />
    <div class="clear"></div>
    <div class="signature-area">
        <div class="signature-block-ttd pull-right">
            <div class="signature" style="margin-top: 50px;">
                <div class="signature-name" style="font-family:Tahoma, Geneva, sans-serif; font-size:10px;">
                    DIBUAT,
                    <br><br><br>
                    <?= $this->Session->read("credential.admin.Biodata.full_name") ?><br>
                    <?= $this->Session->read("credential.admin.Employee.Office.name") ?>
                </div>
            </div>
        </div> 
        <br><br>
    </div>

<?php } ?>