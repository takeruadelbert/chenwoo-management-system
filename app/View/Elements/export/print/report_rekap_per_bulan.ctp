<?php
if (!empty($data['rows'])) {
    $kurs = 13000;
    ?>
    <style>
        .table-bordered,tr,td{
            border:1px solid black;
            border-collapse: collapse;
        }
    </style>
    <div style="text-align:center">
        <div>Rekap Produksi (Kurs Rp. <?= $kurs ?>,00)</div>
    </div>
    <div style="clear: both;"></div>
    <table class="table-bordered" style="margin-top:10px;"> 
        <tr style="text-align:center;">
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" rowspan="3">SUPPLIER <br/> TGL MASUK BARANG</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" rowspan="3">JENIS IKAN</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" rowspan="3">SIZE</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px"rowspan="3">KGS</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" rowspan="3">Total</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px"></td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px"></td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px"></td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px"></td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px"></td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" colspan="6">HASIL PRODUKSI 1/ BARANG MASUK CHILLER</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" colspan="6">PRODUK DARI CHILLER (RETOUCHING) - PRODUKSI II</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" colspan="5">BARANG YANG MASUK ABF</td>
        </tr>
        <tr style="text-align:center;">
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" colspan="3">NOTA PEMBELIAN</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" colspan="2">SELISIH</td>
            <!--Chiller-->
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" colspan="2">RESULT</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" colspan="2">HARGA SESUAI PO</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" rowspan="2">KONVERSI KE RUPIAH</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" rowspan="2">TOTAL</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" colspan="3">HARGA SESUAI PO </td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" rowspan="2">KONVERSI KE RUPIAH</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" rowspan="2">TOTAL</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" rowspan="2">SELISIH</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" rowspan="2">JENIS PRODUK</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" rowspan="2">KGS</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" rowspan="2">TOTAL</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" rowspan="2">SUB TOTAL</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px" rowspan="2">KET</td>
        </tr>
        <tr style="text-align:center;">
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px">KGS</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px">HARGA/KG</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px">JUMLAH</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px">KGS</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px">JUMLAH</td>
            <!--Chiller-->
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px">JENIS PRODUK</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px">KGS</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px">LBS</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px">KG</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px">KGS</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px">LBS</td>
            <td style="overflow:hidden;white-space:nowrap;padding:5px 8px">KG</td>
        </tr>    
        <?php
        $number=1;
        $countArray = [];
        //debug($data['rows']);
        foreach($data['rows']as $transaction){
           $countConversion = count($transaction['MaterialEntry']['Conversion']);
            $countConversionData = 0;
            for($i=0;$i<$countConversion;$i++){ //check count conversin data
                $countConversionData += count($transaction['MaterialEntry']['Conversion'][$i]['ConversionData']);
            }
            $countTransaction = count($transaction['MaterialEntry']['MaterialEntryGrade']);
            $countFreeze = count($transaction['MaterialEntry']['Freeze']);
            $countFreezeDetail = 0;
            for($i=0;$i<$countFreeze;$i++){ //check count Freeze detail
                $countFreezeDetail += count($transaction['MaterialEntry']['Freeze'][$i]['FreezeDetail']);
            }
            $countTreatment = count($transaction['MaterialEntry']['Freeze']); //jumlahnya sama kaya freeze
            $countTreatmentDetail = 0;
            for($i=0;$i<$countTreatment;$i++){ //check count Treatment detail
                $countTreatmentDetail += count($transaction['MaterialEntry']['Freeze'][$i]['Treatment']['TreatmentDetail']);
            }
            //array_push($countArray, max(array($countConversion, $countTransaction, $countFreeze)));
            array_push($countArray, max(array($countConversion, $countTransaction, $countFreeze)));
        }
        ?>
        
        <?php
        for($countData=0;$countData<count($countArray);$countData++){
            $ratioMerge=true;
            for($count=0;$count<$countArray[$countData];$count++){
            ?>
            <tr>
                <?php
                //debug(count($data['rows'][$countData]['TransactionEntry']['transaction_number']));
                if($count<count($data['rows'][$countData]['TransactionEntry']['transaction_number'])){
                    ?>
                    <td rowspan="<?php echo $countArray[$countData]; ?>" ><?= $data['rows'][$countData]['TransactionEntry']['transaction_number']." <br/> ".$data['rows'][$countData]['TransactionEntry']['created'] ?></td>
                    <?php
                }
                ?>
                <?php
                $fishList = array();
                $selisihConversionData=0;
                //debug("aaaaa ".$count." ".count($data['rows'][$countData]['MaterialEntry']['Conversion']));
                if($data['rows'][$countData]['MaterialEntry']['material_category_id']==1){ //Whole
                    if ($count < count($data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'])) { //['ConversionData']
                    ?>
                        <td><?= $data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'][$count]['MaterialDetail']['Material']['name'] . " " . $data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'][$count]['MaterialDetail']['name'] ?></td>
                        <td><?= $data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'][$count]['MaterialSize']['name'] ?></td>
                        <td><?= $data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'][$count]['weight'] ?></td>
                    <?php
                        if($ratioMerge==true){
                    ?>   
                            <td style="color:red" rowspan="<?= count($data['rows'][$countData]['MaterialEntry']['MaterialEntryGrade'])?>"><?= $data['rows'][$countData]['MaterialEntry']['Conversion'][0]['ratio']." %" ?></td> 
                    <?php
                            $ratioMerge=false;
                        }

                    } else {
                        ?>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <?php
                    }
                }else{//Loin
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
                
                if($count<count($data['rows'][$countData]['TransactionMaterialEntry'])){
                    ?>
                        <td><?= $data['rows'][$countData]['TransactionMaterialEntry'][$count]['weight'] ?></td>
                        <td><?= $data['rows'][$countData]['TransactionMaterialEntry'][$count]['price'] ?></td>
                        <td><?= $data['rows'][$countData]['TransactionMaterialEntry'][$count]['price']*$data['rows'][$countData]['TransactionMaterialEntry'][$count]['weight'] ?></td>
                        <td></td>
                        <td></td>
                    <?php    
                }else{
                    ?>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    <?php 
                }
                
                if(count($data['rows'][$countData]['MaterialEntry']['Freeze'])!=0){
                    if($count<count($data['rows'][$countData]['MaterialEntry']['Freeze'])){
                        ?>
                            <td><?= $data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][0]['Product']['Parent']['name']." ".$data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][0]['Product']['name'] ?></td>
                            <td><?= $data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][0]['weight'] ?></td>
                            <td><?= number_format((float)$data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][0]['Product']['price_usd']/2.2, 2) ?></td>
                            <td><?= $data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][0]['Product']['price_usd'] ?></td>
                            <td><?= $data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][0]['Product']['price_usd']*$kurs ?></td>
                            <td><?= $data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][0]['Product']['price_usd']*$kurs*$data['rows'][$countData]['MaterialEntry']['Freeze'][$count]['FreezeDetail'][$count]['weight'] ?></td>
                        <?php
                    }else{
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
        }
        ?>
        
        <?php    
        ?>
    </table>
    <?php
}else{
    echo "<div class='text-center'><h2>Tidak Ada Data</h2></div>";
}
?>