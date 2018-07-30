<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Potongan Sembako
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan($this->data["CooperativeItemLoanPayment"]["start_period"], $this->data["CooperativeItemLoanPayment"]["end_period"]) ?></div>
    <div style="font-size:11px; font-family:Tahoma, Geneva, sans-serif;">
        Pegawai <?= $this->data["EmployeeType"]["name"]?>
    </div>
</div>
<br/>
<table width="100%" class="table-data nowrap">
    <thead>
        <tr bordercolor="#000000">
            <th width="50" align="center" valign="middle" bgcolor="#feffc2">No</th>
            <th align="center" valign="middle" bgcolor="#feffc2">Nama Pegawai</th>
            <th align="center" valign="middle" bgcolor="#feffc2">Total Hutang Sembako</th>
            <th align="center" valign="middle" bgcolor="#feffc2">Jumlah Potongan Periode Ini</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        if (!empty($this->data["CooperativeItemLoanPaymentDetail"])) {
            foreach ($this->data["CooperativeItemLoanPaymentDetail"] as $k => $cooperativeItemLoanPaymentDetail) {
                ?>
                <tr>
                    <td align="center" class="nomorIdx"><?= $k + 1 ?></td>
                    <td>
                        <?= $cooperativeItemLoanPaymentDetail["CooperativeItemLoan"]["Employee"]["Account"]["Biodata"]["full_name"] ?>
                    </td>
                    <td class="text-right">
                        <?= ic_rupiah($cooperativeItemLoanPaymentDetail["current_debt"]) ?>
                    </td>
                    <td class="text-right">
                        <?= ic_rupiah($cooperativeItemLoanPaymentDetail["amount"]) ?>
                    </td>
                </tr>
                <?php
                $i++;
            }
        } else {
            ?>
            <tr>
                <td colspan="4" class="text-center">Tidak ada data hutang.</td>
            </tr>
            <?php
        }
        ?>
    </tbody>  
    <tfoot>
        <tr>
            <td colspan="3" class="text-right"> Total</td>
            <td class="text-right"><?= ic_rupiah(array_sum(array_column($this->data["CooperativeItemLoanPaymentDetail"], "amount"))) ?></td>
        </tr>
    </tfoot>
</table>