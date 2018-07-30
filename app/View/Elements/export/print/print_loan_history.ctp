<?php
if (!empty($data['rows'])) {
    ?>
    <table class = "table-bordered">
        <tr>
            <td colspan="2">
                <table>
                    <tr><td>No. Bukti</td><td>:</td><td> <?php echo $data['rows']['EmployeeDataLoanDetail']['coop_receipt_number'] ?></td></tr>
                    <tr><td>Telah terima dari</td><td>:</td><td> <?php echo $data['rows']['EmployeeDataLoan']['Employee']['Account']['Biodata']['full_name'] ?></td></tr>
                    <tr><td>Banyaknya uang</td><td>:</td><td> <?php echo angka2kalimat($data['rows']['EmployeeDataLoanDetail']['amount']) ?></td></tr>
                    <tr><td>Untuk pembayaran</td><td>:</td><td> <?php echo $data['rows']['EmployeeDataLoanDetail']['note'] ?></td></tr>
                </table>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="4">
                <div style="border:1px solid black"></div>
            </td>
        </tr>
        <br/>
        <tr>
            <td></td>
            <td colspan="2" style = "text-align:right">          
                Total Angsuran Rp. <?php echo number_format($data['rows']['EmployeeDataLoanDetail']['total_amount_loan'], 0, ',', '.') ?>,-. Sisa Angsuran Rp. <?php echo number_format($data['rows']['EmployeeDataLoanDetail']['remaining_loan'], 0, ',', '.') ?>,-.
                <div style="border:1px solid black"></div>
            </td>
        </tr>
    </table>


    <div class="clear"></div>
    <br />
    <table class="total">
        <tbody><tr>
                <td colspan="4" class="left-text">
                    Rp.
                    <div class="total trapesium"> <?php echo number_format($data['rows']['EmployeeDataLoanDetail']['amount'], 0, ',', '.') ?> ,-. </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="clear"></div>
    <div class="signature-area">
        <div class="signature-block-ttd">
            <div class="signature" style="margin-top: 50px;">
                <div class="signature-name">
                    diketahui oleh,
                    <br><br><br>

                    <br>

                </div>
            </div>
        </div>

        <div class="signature-block-ttd">
            <div class="signature" style="margin-top: 50px;">
                <div class="signature-name">dibayarkan oleh,
                    <br><br><br>

                    <br>

                </div>
            </div>
        </div>   

        <div class="signature-block-ttd">
            <div class="signature" style="margin-top: 50px;">
                <div class="signature-name">diterima oleh,
                    <br><br><br>

                    <br>

                </div>
            </div>
        </div>   
        <br><br>
    </div>
<?php } ?>