<div onload = "window.print()">
    <div class = "container-print" style = "width:955px; margin:10px auto">
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
        <table width="100%" style="line-height:20px; font-size:11px;font-style: bold; font-family:Tahoma, Geneva, sans-serif;">
            <tr>
                <td width="13%"></td>
                <td width="1"></td>
                <td width="45%"></td>
                <td width="12%"></td>
                <td width="1"></td>
                <td width="30%"></td>
            </tr>
            <tr>
                <td colspan="6" align="center" style="border-bottom: 5px ridge !important; border-top: 5px ridge !important;"><h3 style="margin-bottom: 0px;">BUKTI KAS KELUAR</h3></td>
            </tr>
            <tr style = "font-size:10px; font-family:Tahoma, Geneva, sans-serif;">
                <td>Dari</td>
                <td width="1">:</td>
                <td><strong style="font-style: italic; font-size: 1.17em;">UMUM</strong></td>
                <td>Nomor</td>
                <td width="1">:</td>
                <td><?= $data['rows']['CashDisbursement']['cash_disbursement_number'] ?></td>
            </tr style = "font-size:10px;">
            <tr>
                <td>Alamat</td>
                <td width="1">:</td>
                <td><strong>-</strong></td>
                <td>Tanggal</td>
                <td width="1">:</td>
                <td><?= $this->Html->cvtTanggal($data['rows']['CashDisbursement']['created_datetime']) ?></td>
            </tr>
            <tr style = "font-size:10px;">
                <td>Keterangan</td>
                <td width="1">:</td>
                <td><strong><?= $data['rows']['CashDisbursement']['note'] ?></strong></td>
                <td>Lampiran</td>
                <td width="1">:</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="6"><br></td>
            </tr>
        </table>
        <table width="100%" style="line-height:20px; font-size:11px;font-family:Tahoma, Geneva, sans-serif;">            
            <tr style="border-top: 5px ridge !important; border-bottom: 5px ridge !important;">
                <th width="15%" class="text-center">Kode</th>
                <th width="50%" class="text-center">Rekening/Uraian</th>
                <th width="5%"></th>
                <th width="30%" class="text-center">Jumlah</th>
            </tr>
            <?php
            $totalCashDisbursement = 0;
            foreach ($data['rows']['CashDisbursementDetail'] as $index => $details) {
                if(!empty($details['general_entry_type_id'])) {
                    $transaction_name = $details['GeneralEntryType']['name'];
                    $code = $details['GeneralEntryType']['code'];
                } else if(!empty($details['name'])) {
                    $transaction_name = $details['name'];
                    $code = $data['rows']['GeneralEntryType']['code'];
                } else {
                    $transaction_name = "-";
                    $code = "-";
                }
                ?>
                <tr style = "font-size:10px;">
                    <td class="text-center"><?= $code ?></td>
                    <td><?= $transaction_name ?></td>
                    <td><?= $data['rows']['CashDisbursement']['transaction_currency_type_id'] == 1 ? "Rp." : "$" ?></td>
                    <td class="text-right"><?= $data['rows']['CashDisbursement']['transaction_currency_type_id'] == 1 ? $this->Html->Rp($details['amount']) : ac_dollar($details['amount']) ?></td>
                </tr>
                <?php
                $totalCashDisbursement += $details['amount'];
            }
            ?>
            <tr style = "font-size:10px;">
                <td>Ch/G.B. No : </td>
                <td class="text-right"><strong>Total (Dr.)</strong></td>
                <td style="border-top:5px ridge !important; border-bottom: 5px ridge !important;"><?= $data['rows']['CashDisbursement']['transaction_currency_type_id'] == 1 ? "Rp." : "$" ?></td>
                <td class="text-right" style="border-top:5px ridge !important; border-bottom: 5px ridge !important;"><strong><?= $data['rows']['CashDisbursement']['transaction_currency_type_id'] == 1 ? $this->Html->Rp($totalCashDisbursement) : ac_dollar($totalCashDisbursement) ?></strong></td>
            </tr>
            <tr style = "font-size:10px;">
                <td colspan="4"><br></td>
            </tr>
            <tr style = "font-size:10px;">
                <td>Terbilang : </td>
                <td colspan="3"><strong><?= $data['rows']['CashDisbursement']['transaction_currency_type_id'] == 1 ? angka2kalimat($totalCashDisbursement) . " rupiah." : terbilangBahasaIndonesia($totalCashDisbursement, "dollar") ?></strong></td>
            </tr style = "font-size:10px;">
            <tr style = "font-size:10px;">
                <td colspan="4"><br><br></td>
            </tr>
        </table>
        <table width="100%" border="1" style="line-height:20px; font-size:11px;font-family:Tahoma, Geneva, sans-serif;"> 
            <tr>
                <td class="text-center" width="16%">Akuntansi</td>
                <td class="text-center" width="16%">Mengetahui</td>
                <td colspan="2" class="text-center" width="36%">Menyetujui</td>
                <td class="text-center" width="16%">Kasir</td>
                <td class="text-center" width="16%">Penyetor</td>
            </tr>
            <tr height = "80px">
                <td class="text-center" style = "border: 1px solid"></td>
                <td class="text-center" style = "border: 1px solid"></td>
                <td class="text-center" style = "border: 1px solid"></td>
                <td class="text-center" style = "border: 1px solid"></td>
                <td class="text-center" style = "border: 1px solid"></td>
                <td class="text-center" style = "border: 1px solid"></td>
            </tr>
        </table>
    </div>
</div>