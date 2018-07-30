<div class = "container-print" style = "width:955px; margin:10px auto;">
    <div id="identity">
        <div class="no-margin no-padding text-left" style="width:100%">
            <?php
            $entity = ClassRegistry::init("EntityConfiguration")->find("first");
            ?>
            <div style="display:inline-block; margin-right: 15px;">
                <img src="<?php echo Router::url($entity['EntityConfiguration']['logo1'], true) ?>"/>
            </div>
            <div style="display:inline-block;width: 855px;" >
                <?php
                echo $entity['EntityConfiguration']['header'];
                ?>
            </div>
        </div>
        <hr/>
    </div>
    <div style="text-align: center">
        <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
            Data Buku Besar
        </div>
    </div>
    <div style="text-align: center; font-size:11px;font-weight: italic; font-family:Tahoma, Geneva, sans-serif;">
        <?php
        if (!empty($startDate) && !empty($endDate)) {
            echo $this->Html->cvtHariTanggal($startDate) . " - " . $this->Html->cvtHariTanggal($endDate);
        } else {
            echo "Bulan " . $this->Html->getNamaBulan($currentMonth) . " Tahun " . $currentYear;
        }
        ?>
    </div>
    <br>
    <?php
    $totalDebet = 0;
    $totalKredit = 0;
    $saldoAkhir = 0;
    $mutasi = 0;
    $dataClosingBook = ClassRegistry::init("ClosingBook")->find("first", ['recursive' => -1]);
    foreach ($dataGeneralEntry as $data) {
        $totalDebet = 0;
        $totalKredit = 0;
        if (!empty($data)) {
            ?>
            <table width="100%" class="" style="border: none !important; font-size:10px; font-family:Tahoma, Geneva, sans-serif; line-height:20px;">
                <thead>
                    <tr>
                        <th colspan = "7" class="text-left" style="padding:10px; background-color: #DCDCDC; border-bottom:1px solid #ccc; font-size:12px !important;"><?= $data[0]['GeneralEntryType']['code'] . "&nbsp; &nbsp; &nbsp; &nbsp;" . $data[0]['GeneralEntryType']['name'] ?></th>
                        <th width class="text-right" style="padding:10px; background-color: #DCDCDC; border-bottom:1px solid #ccc; font-size:12px !important;"><strong>IDR</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid">
                        <td style = "font-weight: bold;" width="12%"><?= __("Tanggal") ?></td>
                        <td style = "font-weight: bold;" width="1%"><?= __("Tp") ?></td>
                        <td style = "font-weight: bold;" width="20%"><?= __("No. Ref.") ?> </td>
                        <td style = "font-weight: bold;" width="20%"><?= __("Keterangan") ?></td>
                        <td style = "font-weight: bold;" width="15%" class="text-right"><?= __("Debet") ?></td>
                        <td style = "font-weight: bold;" width="15%" class="text-right"><?= __("Kredit") ?></td>
                        <td colspan="2" style="font-weight: bold;" width="17%" class="text-right"><?= __("Balance") ?></td>
                    </tr>
                    <?php
                    $saldoAwal = 0;
                    foreach ($data as $index => $item) {
                        if (!empty($dataClosingBook)) {
                            if ($index == 0) {
                                $saldoAwal = $item['GeneralEntryType']['initial_balance'];
                            }
                        }
                        $mutation_balance = $saldoAwal;
                        ?>
                        <tr>
                            <td><?= $this->Html->cvtTanggal($item['GeneralEntry']['transaction_date']) ?></td>
                            <td><?= $item['GeneralEntryAccountType']['uniq_name'] ?></td>
                            <td><?= $item['GeneralEntry']['reference_number'] ?> </td>
                            <td><?= $item['GeneralEntry']['transaction_name'] ?></td>
                            <?php
                            $debit = 0;
                            $credit = 0;
                            if (!empty($item['GeneralEntry']['initial_balance_id'])) {
                                if ($item['InitialBalance']['Currency']['id'] == 1) {
                                    $debit = $item['GeneralEntry']['debit'];
                                    $credit = $item['GeneralEntry']['credit'];
                                    ?>
                                    <td class = "text-right"><?= $this->Html->Rp($item['GeneralEntry']['debit']) ?></td>
                                    <td class = "text-right"><?= $this->Html->Rp($item['GeneralEntry']['credit']) ?></td>
                                    <?php
                                } else {
                                    if ($item['InitialBalance']['Currency']['id'] == 2 && !empty($item['GeneralEntry']['sale_id']) && empty($item['GeneralEntry']['payment_sale_id'])) {
                                        $debit = $item['GeneralEntry']['debit'] * $item['Sale']['exchange_rate'];
                                        $credit = $item['GeneralEntry']['credit'] * $item['Sale']['exchange_rate'];
                                        ?>
                                        <td class = "text-right"><?= $this->Html->Rp($item['GeneralEntry']['debit'] * $item['Sale']['exchange_rate']) ?></td>
                                        <td class = "text-right"><?= $this->Html->Rp($item['GeneralEntry']['credit'] * $item['Sale']['exchange_rate']) ?></td>
                                        <?php
                                    } else if ($item['InitialBalance']['Currency']['id'] == 2 && empty($item['GeneralEntry']['sale_id']) && !empty($item['GeneralEntry']['payment_sale_id'])) {
                                        $debit = $item['GeneralEntry']['debit'] * $item['PaymentSale']['Sale']['exchange_rate'];
                                        $credit = $item['GeneralEntry']['credit'] * $item['PaymentSale']['Sale']['exchange_rate'];
                                        ?>
                                        <td class = "text-right"><?= $this->Html->Rp($item['GeneralEntry']['debit'] * $item['PaymentSale']['Sale']['exchange_rate']) ?></td>
                                        <td class = "text-right"><?= $this->Html->Rp($item['GeneralEntry']['credit'] * $item['PaymentSale']['Sale']['exchange_rate']) ?></td>
                                        <?php
                                    } else if ($item['InitialBalance']['Currency']['id'] == 2 && !empty($item['GeneralEntry']['shipment_id'])) {
                                        $debit = $item['GeneralEntry']['debit'] * $item['Shipment']['Sale']['exchange_rate'];
                                        $credit = $item['GeneralEntry']['credit'] * $item['Shipment']['Sale']['exchange_rate'];
                                        ?>
                                        <td class = "text-right"><?= $this->Html->Rp($item['GeneralEntry']['debit'] * $item['Shipment']['Sale']['exchange_rate']) ?></td>
                                        <td class = "text-right"><?= $this->Html->Rp($item['GeneralEntry']['credit'] * $item['Shipment']['Sale']['exchange_rate']) ?></td>
                                        <?php
                                    } else if ($item['InitialBalance']['Currency']['id'] == 2 && $item['GeneralEntry']['is_from_general_transaction']) {
                                        $debit = $item['GeneralEntry']['debit'] * $item['GeneralEntry']['exchange_rate'];
                                        $credit = $item['GeneralEntry']['credit'] * $item['GeneralEntry']['exchange_rate'];
                                        ?>
                                        <td class = "text-right"><?= $this->Html->Rp($debit) ?></td>
                                        <td class = "text-right"><?= $this->Html->Rp($credit) ?></td>
                                        <?php
                                    } else {
                                        $debit = $item['GeneralEntry']['debit'] * $item['InitialBalance']['exchange_rate'];
                                        $credit = $item['GeneralEntry']['credit'] * $item['InitialBalance']['exchange_rate'];
                                        ?>
                                        <td class = "text-right"><?= $this->Html->Rp($debit) ?></td>
                                        <td class = "text-right"><?= $this->Html->Rp($credit) ?></td>
                                        <?php
                                    }
                                }
                            } else {
                                if (!empty($item['GeneralEntry']['shipment_id'])) {
                                    if ($item['Shipment']['Sale']['Buyer']['buyer_type_id'] == 2) {
                                        $debit = $item['GeneralEntry']['debit'] * $item['Shipment']['Sale']['exchange_rate'];
                                        $credit = $item['GeneralEntry']['credit'] * $item['Shipment']['Sale']['exchange_rate'];
                                    } else {
                                        $debit = $item['GeneralEntry']['debit'];
                                        $credit = $item['GeneralEntry']['credit'];
                                    }
                                    ?>
                                    <td class = "text-right"><?= $this->Html->Rp($debit) ?></td>
                                    <td class = "text-right"><?= $this->Html->Rp($credit) ?></td>   
                                    <?php
                                } else if ($item['GeneralEntry']['is_from_general_transaction']) {
                                    if ($item['GeneralEntryType']['currency_id'] == 1) {
                                        $debit = $item['GeneralEntry']['debit'];
                                        $credit = $item['GeneralEntry']['credit'];
                                    } else {
                                        $debit = $item['GeneralEntry']['debit'] * $item['GeneralEntry']['exchange_rate'];
                                        $credit = $item['GeneralEntry']['credit'] * $item['GeneralEntry']['exchange_rate'];
                                    }
                                    ?>
                                    <td class = "text-right"><?= $this->Html->Rp($debit) ?></td>
                                    <td class = "text-right"><?= $this->Html->Rp($credit) ?></td>
                                    <?php
                                } else {
                                    $debit = $item['GeneralEntry']['debit'];
                                    $credit = $item['GeneralEntry']['credit'];
                                    ?>
                                    <td class = "text-right"><?= $this->Html->Rp($debit) ?></td>
                                    <td class = "text-right"><?= $this->Html->Rp($credit) ?></td>  
                                    <?php
                                }
                            }
                            $totalDebet += $debit;
                            $totalKredit += $credit;

                            $coa_code = $item['GeneralEntryType']['code'];
                            $classification_coa_code = substr($coa_code, 0, 1);
                            if ($classification_coa_code == '1' || $classification_coa_code == '5' || $classification_coa_code == '6' || $classification_coa_code == '7' || $classification_coa_code == '9') {
                                $mutation_balance += $totalDebet - $totalKredit;
                            } else {
                                $mutation_balance += $totalKredit - $totalDebet;
                            }
                            ?>
                            <td class="text-right" colspan="2"><?= ic_rupiah($mutation_balance) ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr style = "font-weight: bold; background-color:#A9A9A9">
                        <td colspan="2">Saldo Awal </td>
                        <td class = "text-right">
                            <?php
                            if ($item['GeneralEntryType']['Currency']['id'] == 2) {
                                $saldoAwal = $saldoAwal * $item['GeneralEntryType']['exchange_rate'];
                            }
                            echo $this->Html->Rp($saldoAwal);
                            ?>
                        </td>
                        <td>Total </td>
                        <td class = "text-right"><?= $this->Html->Rp($totalDebet) ?></td>
                        <td class = "text-right"><?= $this->Html->Rp($totalKredit) ?></td>
                        <td colspan="2"></td>
                    </tr>
                    <tr style = "font-weight: bold; background-color:#A9A9A9">
                        <?php
                        $generalEntryTypeCode = $item['GeneralEntryType']['code'];
                        $mutasi = $this->Accounting->getMutation($generalEntryTypeCode, $totalDebet, $totalKredit);
                        $saldoAkhir = $saldoAwal + $mutasi;
                        ?>
                        <td colspan="2">Saldo Akhir </td>
                        <td class = "text-right"><?= $this->Html->Rp($saldoAkhir) ?></td>
                        <td>Mutasi </td>
                        <td class = "text-right"><?= $this->Html->Rp($mutasi) ?></td>
                        <td> </td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
            <br><br>
            <?php
        }
    }
    ?>
</div>