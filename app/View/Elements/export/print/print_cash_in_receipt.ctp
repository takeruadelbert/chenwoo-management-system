<div onload = "window.print()">
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
        <table width="100%" style="line-height:20px; font-size:11px;font-style: bold; font-family:Tahoma, Geneva, sans-serif;">
            <tr>
                <td width="13%"></td>
                <td width="1"></td>
                <td width="35%"></td>
                <td width="12%"></td>
                <td width="1"></td>
                <td width="40%"></td>
            </tr>
            <tr>
                <td colspan="6" align="center" style="line-height:20px; border-bottom: 1px solid !important; border-top: 1px solid !important;"><h3 style="margin-bottom: 0px;">BUKTI KAS MASUK</h3></td>
            </tr>
            <tr style = "font-size:10px; font-family:Tahoma, Geneva, sans-serif;">
                <td>Dari</td>
                <td width="1">:</td>
                <td><strong style="font-style: none; font-size: 1.17em;">UMUM</strong></td>
                <td>Nomor</td>
                <td width="1">:</td>
                <td><?= $data['rows']['CashIn']['cash_in_number'] ?></td>
            </tr>
            <tr style = "font-size:10px; font-family:Tahoma, Geneva, sans-serif;">
                <td>Alamat</td>
                <td width="1">:</td>
                <td><strong><?= !empty($data['rows']['Partner']['id']) ? $data['rows']['Partner']['address'] : "-" ?></strong></td>
                <td>Tanggal</td>
                <td width="1">:</td>
                <td><?= $this->Html->cvtTanggal($data['rows']['CashIn']['created_datetime']) ?></td>
            </tr>
            <tr style = "font-size:10px; font-family:Tahoma, Geneva, sans-serif;">
                <td>Keterangan</td>
                <td width="1">:</td>
                <td><strong><?= $data['rows']['CashIn']['note'] ?></strong></td>
                <td>Lampiran</td>
                <td width="1">:</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="6"><br></td>
            </tr>
        </table>
        <table width="100%" style="line-height:20px; font-size:11px;font-family:Tahoma, Geneva, sans-serif;">  
            <tr style="border-top: 1px solid !important; border-bottom: 1px solid !important;">
                <th width="15%" class="text-center">Kode</th>
                <th width="50%" class="text-center">Rekening/Uraian</th>
                <th width="5%"></th>
                <th width="30%" class="text-center">Jumlah</th>
            </tr>
            <tr style = "font-size:10px;">
                <td class="text-center"><?= $kode['GeneralEntryType']['code'] ?></td>
                <td><?= $kode['GeneralEntryType']['name'] ?></td>
                <td><?= $data['rows']['CashIn']['currency_id'] == 1 ? "Rp." : "$" ?></td>
                <td class="text-right"><?= $data['rows']['CashIn']['currency_id'] == 1 ? $this->Html->Rp($data['rows']['CashIn']['amount']) : ac_dollar($data['rows']['CashIn']['amount']) ?></td>
            </tr>
            <tr style = "font-size:10px;">
                <td>Ch/G.B. No : </td>
                <td class="text-right"><strong>Total (Cr.)</strong></td>
                <td style="border-top:1px solid !important; border-bottom: 1px solid !important;"><?= $data['rows']['CashIn']['currency_id'] == 1 ? "Rp." : "$" ?></td>
                <td class="text-right" style="border-top:1px solid !important; border-bottom: 1px solid !important;"><strong><?= $data['rows']['CashIn']['currency_id'] == 1 ? $this->Html->Rp($data['rows']['CashIn']['amount']) : ac_dollar($data['rows']['CashIn']['amount']) ?></strong></td>
            </tr>
            <tr style = "font-size:10px;">
                <td colspan="4"><br></td>
            </tr>
            <tr style = "font-size:10px;">
                <td>Terbilang : </td>
                <td colspan="3"><strong><?= $data['rows']['CashIn']['currency_id'] == 1 ? angka2kalimat($data['rows']['CashIn']['amount']) . " rupiah." : terbilangBahasaIndonesia($data['rows']['CashIn']['amount'], "dollar") ?> </strong></td>
            </tr>
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