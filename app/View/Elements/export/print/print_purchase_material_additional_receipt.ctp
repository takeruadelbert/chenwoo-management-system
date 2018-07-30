<?php
if (!empty($data['rows'])) {
    ?>
    <table>
        <tr>
            <td colspan="2">
                <table>
                    <tr><td width ="200">Diterima dari</td><td width =1>:</td><td> <?php echo $data['rows']['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['name'] ?></td></tr>
                    <tr><td>Sejumlah uang</td><td width =1>:</td><td> Rp. <?php echo number_format(abs($data['rows']['PaymentPurchaseMaterialAdditional']['amount']), 0, ',', '.') ?>,-</td></tr>
                    <tr><td>Terbilang</td><td width =1>:</td><td> <?php echo angka2kalimat($data['rows']['PaymentPurchaseMaterialAdditional']['amount']) ?> rupiah</td></tr>
                    <tr><td>Sisa Pembayaran</td><td width =1>:</td><td> Rp. <?php echo number_format(abs($data['rows']['PaymentPurchaseMaterialAdditional']['remaining']), 0, ',', '.') ?>,-</td></tr>
                    <tr><td>Untuk Keperluan</td><td width =1>:</td><td> <?php echo ucwords($data['rows']['PaymentPurchaseMaterialAdditional']['note']) ?></td></tr>
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
                <div class="signature-name">
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