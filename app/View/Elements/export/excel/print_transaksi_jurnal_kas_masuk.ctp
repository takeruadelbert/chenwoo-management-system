<div style="text-align: center">
    <div style="font-size:18px;font-weight: bold">
        Transaksi Jurnal Kas Masuk
    </div>
    <div>Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br/>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive pre-scrollable stn-table" style="max-height: 600px;">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?= __("Tanggal Transaksi") ?></th>
                            <th><?= __("Nomor Referensi") ?></th>
                            <th><?= __("Keterangan") ?></th>
                            <th colspan = "2"><?= __("Debit") ?></th>
                            <th colspan = "2"><?= __("Kredit") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if (empty($generalEntries)) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = 8>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($generalEntries as $item) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($item['GeneralEntry']['transaction_date']) ?></td>
                                    <td class="text-center"><?= $item['GeneralEntry']['reference_number'] ?></td>
                                    <td class="text-center"><?= $item['GeneralEntry']['transaction_name'] ?></td>
                                    <?php
                                    if ($item['InitialBalance']['Currency']['id'] == 1) {
                                        ?>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150">
                                            <?php
                                            if (!empty($item['GeneralEntry']['debit'])) {
                                                echo $this->Html->Rp($item['GeneralEntry']['debit']);
                                            } else {
                                                echo $this->Html->Rp(0);
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150">
                                            <?php
                                            if (!empty($item['GeneralEntry']['credit'])) {
                                                echo $this->Html->Rp($item['GeneralEntry']['credit']);
                                            } else {
                                                echo $this->Html->Rp(0);
                                            }
                                            ?>
                                        </td>
                                        <?php
                                    } else {
                                        ?>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150">
                                            <?php
                                            if (!empty($item['GeneralEntry']['debit'])) {
                                                echo $this->Html->Rp($item['GeneralEntry']['debit'] * $item['PaymentSale']['exchange_rate']);
                                            } else {
                                                echo $this->Html->Rp(0);
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150">
                                            <?php
                                            if (!empty($item['GeneralEntry']['credit'])) {
                                                echo $this->Html->Rp($item['GeneralEntry']['credit'] * $item['PaymentSale']['exchange_rate']);
                                            } else {
                                                echo $this->Html->Rp(0);
                                            }
                                            ?>
                                        </td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>