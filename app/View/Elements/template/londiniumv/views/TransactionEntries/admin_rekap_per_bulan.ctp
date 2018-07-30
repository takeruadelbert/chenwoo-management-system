<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/rekap_per_bulan");
?>
<?php
$kurs = $data['kurs'];
?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("REKAPITULASI LAPORAN PEMBOBOTAN IKAN HARIAN") ?>
                    <div class="pull-right">
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("rekap_per_bulan/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-print2"></i> 
                            <?= __("Cetak") ?>
                        </button>&nbsp;
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("rekap_per_bulan/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-file-excel"></i>
                            Excel
                        </button>&nbsp;
                    </div>
                    <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                </h6>
            </div>
            <div>
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Preview Rekapitulasi Laporan Pembobotan Ikan Harian") ?></h6>
                </div>
                <div class="table-responsive stn-table pre-scrollable">
                    <table width="100%" class="table table-hover table-bordered" style="table-layout: fixed">     
                        <tr style="text-align:center;">
                            <th width = "300" rowspan="3">SUPPLIER <br/> TGL MASUK BARANG</th>
                            <th width = "150" rowspan="3">JENIS IKAN</th>
                            <th width = "150" rowspan="3">SIZE</th>
                            <th width = "150" rowspan="3">KGS</th>
                            <th width = "150" rowspan="3">Total</th>
                            <th width = "450" colspan = "3" rowspan="2">NOTA PEMBELIAN</th>
                            <th width = "300" colspan = "2" rowspan="2">SELISIH</th>
                            <th width = "900" colspan="6">HASIL PRODUKSI 1/ BARANG MASUK CHILLER</th>
                            <th width = "900" colspan="6">PRODUK DARI CHILLER (RETOUCHING) - PRODUKSI II</th>
                            <th width = "1200" colspan="5">BARANG YANG MASUK ABF</th>
                        </tr>
                        <tr style="text-align:center;">
                            <!--Chiller-->
                            <th width = "300" colspan="2">RESULT</th>
                            <th width = "200" colspan="2">HARGA SESUAI PO</th>
                            <th width = "200" rowspan="2">KONVERSI KE RUPIAH</th>
                            <th width = "200" rowspan="2">TOTAL</th>

                            <th width = "300" colspan="3">HARGA SESUAI PO </th>
                            <th width = "200" rowspan="2">KONVERSI KE RUPIAH</th>
                            <th width = "200" rowspan="2">TOTAL</th>
                            <th width = "200" rowspan="2">SELISIH</th>

                            <th width = "300" rowspan="2">JENIS PRODUK</th>
                            <th width = "200" rowspan="2">KGS</th>
                            <th width = "200" rowspan="2">TOTAL</th>
                            <th width = "200" rowspan="2">SUB TOTAL</th>
                            <th width = "300" rowspan="2">KET</th>
                        </tr>
                        <tr style="text-align:center;">
                            <th width = "150">KGS</th>
                            <th width = "150">HARGA/KG</th>
                            <th width = "150">JUMLAH</th>

                            <th width = "150">KGS</th>
                            <th width = "150">JUMLAH</th>
                            <!--Chiller-->
                            <th width = "200">JENIS PRODUK</th>
                            <th width = "100">KGS</th>
                            <th width = "100">LBS</th>
                            <th width = "100">KG</th>

                            <th width = "100">KGS</th>
                            <th width = "100">LBS</th>
                            <th width = "100">KG</th>
                        </tr>    
                        <?php
                        $number = 1;
                        $countArray = [];
                        debug($data['rows']);
                        foreach ($data['rows']as $transaction) {
                            $countConversion = count($transaction['MaterialEntry']['Conversion']);
                            $countConversionData = 0;
                            for ($i = 0; $i < $countConversion; $i++) { //check count conversin data
                                $countConversionData += count($transaction['MaterialEntry']['Conversion'][$i]['ConversionData']);
                            }
                            $countTransaction = count($transaction['MaterialEntry']['MaterialEntryGrade']);
                            $countFreeze = count($transaction['MaterialEntry']['Freeze']);
                            $countFreezeDetail = 0;
                            for ($i = 0; $i < $countFreeze; $i++) { //check count Freeze detail
                                $countFreezeDetail += count($transaction['MaterialEntry']['Freeze'][$i]['FreezeDetail']);
                            }
                            $countTreatment = count($transaction['MaterialEntry']['Freeze']); //jumlahnya sama kaya freeze
                            $countTreatmentDetail = 0;
                            for ($i = 0; $i < $countTreatment; $i++) { //check count Treatment detail
                                if($transaction['MaterialEntry']['Freeze'][$i]['Treatment']!=null){
                                    $countTreatmentDetail += count($transaction['MaterialEntry']['Freeze'][$i]['Treatment']['TreatmentDetail']);
                                }
                            }
                            //array_push($countArray, max(array($countConversion, $countTransaction, $countFreeze)));
                            array_push($countArray, max(array($countConversionData, $countTransaction, $countFreeze)));
                        }
                        ?>
                        <?php
                        for ($countData = 0; $countData < count($countArray); $countData++) {
                            $ratioMerge = true;
                            $materialEntryWeight = 0;
                            $conversionWeight = 0;
                            for ($count = 0; $count < $countArray[$countData]; $count++) {
                                ?>
                                <tr>
                                    <?php
                                    //debug($count." ".$countData." ".count($data['rows'][$countData]['TransactionEntry']['transaction_number']));
                                    if ($count == 0) {
                                        ?>
                                        <td rowspan="<?php echo $countArray[$countData]; ?>" ><?= $data['rows'][$countData]['MaterialEntry']['Supplier']['name'] . " <br/> " . $data['rows'][$countData]['TransactionEntry']['transaction_number'] . " <br/> " . $data['rows'][$countData]['TransactionEntry']['created'] ?></td>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    $fishList = array();
                                    $selisihConversionData = 0;
                                    
                                    //debug("aaaaa ".$count." ".count($data['rows'][$countData]['MaterialEntry']['Conversion']));
                                    if ($data['rows'][$countData]['MaterialEntry']['material_category_id'] == 1) { //Whole
                                        if ($count < count($data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'])) { //['ConversionData']
                                            $materialEntryWeight += $data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'][$count]['weight'];
                                            $conversionWeight += $data['rows'][$countData]['MaterialEntry']['Conversion'][$count]['total'];
                                            $ratio = ($conversionWeight / $materialEntryWeight) * 100;
                                            ?>
                                            <td><?= $data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'][$count]['MaterialDetail']['Material']['name'] . " " . $data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'][$count]['MaterialDetail']['name'] ?></td>
                                            <td><?= $data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'][$count]['MaterialSize']['name'] ?></td>
                                            <td><?= $data['rows'][$countData]['MaterialEntry']['Conversion'][$count]['total'] ?></td>
                                            <?php
                                            if ($ratioMerge == true) {
                                                ?>   
                                                <td style="color:red" rowspan="<?= count($data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade']) ?>"><?= round($ratio, 2) . " %" ?></td> 
                                                <?php
                                                $ratioMerge = false;
                                            }
                                        } else {
                                            ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <?php
                                        }
                                    } else {//Loin
                                        if ($count < count($data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'])) { //['ConversionData']
                                            ?>
                                            <td><?= $data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'][$count]['MaterialDetail']['Material']['name'] . " " . $data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'][$count]['MaterialDetail']['name'] ?></td>
                                            <td><?= $data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'][$count]['MaterialSize']['name'] ?></td>
                                            <td><?= $data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'][$count]['weight'] ?></td>
                                            <td></td> 
                                            <?php
                                        } else {
                                            ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <?php
                                        }
                                    }

                                    //array_push($fishList,['label'=>$conversion['MaterialSize']['name'],'weight'=>$conversion['material_size_quantity']]);  

                                    if ($count < count($data['rows'][$countData]['TransactionMaterialEntry'])) {
                                        ?>
                                        <td><?= $data['rows'][$countData]['TransactionMaterialEntry'][$count]['weight'] ?></td>
                                        <td><?= ic_decimalseperator($data['rows'][$countData]['TransactionMaterialEntry'][$count]['price']) ?></td>
                                        <td><?= ic_decimalseperator($data['rows'][$countData]['TransactionMaterialEntry'][$count]['price'] * $data['rows'][$countData]['TransactionMaterialEntry'][$count]['weight']) ?></td>
                                        <td><?= round($data['rows'][$countData]['TransactionMaterialEntry'][$count]['weight'] - $data['rows'][$countData]['MaterialEntry']['Conversion'][$count]['total'], 2) ?></td>
                                        <td><?= ic_decimalseperator(($data['rows'][$countData]['TransactionMaterialEntry'][$count]['weight'] - $data['rows'][$countData]['MaterialEntry']['Conversion'][$count]['total']) * $data['rows'][$countData]['TransactionMaterialEntry'][$count]['price']) ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <?php
                                    }
                                    
                                    if (count($data['rows'][$countData]['MaterialEntry']['Freeze']) != 0) {
                                        if ($count < count($data['rows'][$countData]['MaterialEntry']['Freeze'])) {
                                            foreach ($data['rows'][$countData]['MaterialEntry']['Freeze'] as $freeze) {
                                                foreach ($freeze['FreezeDetail'] as $freezeDetail) {
                                                ?>
                    <!--                                                <td><? $data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][0]['Product']['Parent']['name'] . " " . $data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][0]['Product']['name'] ?></td>
                                                        <td><? $data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][0]['weight'] ?></td>
                                                        <td><? number_format((float) $data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][0]['Product']['price_usd'] / 2.2, 2) ?></td>
                                                        <td><? $data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][0]['Product']['price_usd'] ?></td>
                                                        <td><? ic_rupiah($data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][0]['Product']['price_usd'] * $kurs) ?></td>
                                                        <td><? ic_rupiah($data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][0]['Product']['price_usd'] * $kurs * $data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][0]['weight']) ?></td>-->

                                                <td><?=$freezeDetail['Product']['Parent']['name'] . " " . $freezeDetail['Product']['name'] ?></td>
                                                <td><?=$freezeDetail['weight'] ?></td>
                                                <td><?= number_format((float) $freezeDetail['Product']['price_usd'] / 2.2, 2) ?></td>
                                                <td><?= $freezeDetail['Product']['price_usd'] ?></td>
                                                <td><?= ic_rupiah($freezeDetail['Product']['price_usd'] * $kurs) ?></td>
                                                <td><?= ic_rupiah($freezeDetail['Product']['price_usd'] * $kurs * $freezeDetail['weight']) ?></td>
                                                <?php
                                                }
                                            }
                                        } else {
                                            ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <?php
                                        }

                                        if (count($data['rows'][$countData]['MaterialEntry']['Freeze'][0]['Treatment']) != 0) {
                                            if ($count < count($data['rows'][$countData]['MaterialEntry']['Freeze'][0]['Treatment']['TreatmentDetail'])) {
                                                ?>
                                                <td><?= $data['rows'][$countData]['MaterialEntry']['Freeze'][0]['Treatment']['TreatmentDetail'][$count]['weight'] . " Kg" ?></td>
                                                <td><?= $data['rows'][$countData]['MaterialEntry']['Freeze'][0]['Treatment']['TreatmentDetail'][$count]['Product']['price_usd'] / 2.2 ?></td>
                                                <td><?= $data['rows'][$countData]['MaterialEntry']['Freeze'][0]['Treatment']['TreatmentDetail'][$count]['Product']['price_usd'] ?></td>
                                                <td><?= ic_rupiah($data['rows'][$countData]['MaterialEntry']['Freeze'][0]['Treatment']['TreatmentDetail'][$count]['Product']['price_usd'] * $kurs) ?></td>
                                                <td><?= ic_rupiah($data['rows'][$countData]['MaterialEntry']['Freeze'][0]['Treatment']['TreatmentDetail'][$count]['Product']['price_usd'] * $data['rows'][$countData]['MaterialEntry']['Freeze'][0]['Treatment']['TreatmentDetail'][$count]['weight'] * $kurs) ?></td>
                                                <td></td>
                                                    <td><?= $data['rows'][$countData]['MaterialEntry']['Freeze'][0]['Treatment']['TreatmentDetail'][$count]['Product']['Parent']['name'] . " " . $data['rows'][$countData]['MaterialEntry']['Freeze'][0]['Treatment']['TreatmentDetail'][$count]['Product']['name'] ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <?php
                                            } else {
                                                ?>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tr>
                                <?php
                            }
                            $ratioMerge = true;
                        }
                        ?>

                        <?php
                        ?>
                    </table>
                </div>
            </div>
        </div>    
    </div>
</div>
