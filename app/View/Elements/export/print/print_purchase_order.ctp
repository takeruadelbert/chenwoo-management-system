<table width="100%" class="">
    <tr>
        <td class="text-center" style="border-top: none; border-bottom: none; border-left: none; border-right: none" colspan = "2">
            <table width="100%" class="table table-hover table1">
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td class ="text-center" width = "110" rowspan = "2" style="border-top: none; border-bottom: none; border-left: none; border-right: none"> 
                        <?php
                        $entity = ClassRegistry::init("EntityConfiguration")->find("first");
                        ?>
                        <img src="<?php echo Router::url($entity['EntityConfiguration']['logo1'], true) ?>" height="90px"/>
                    </td>
                    <td class = "text-center" style="border-top: none; border-bottom: none; border-left: none; border-right: none;"> <h3 style = "margin-bottom: 0px !important"><u>PURCHASE ORDER</u></h3></td>
                    <td width = "110" style="border-top: none; border-bottom: none; border-left: none; border-right: none"></td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none"></td>
                </tr>      
                <tr>
                    <td class = "text-center" style="border-top: none; border-bottom: none; border-left: none; border-right: none; font-size:12px">
                        <?= $data['title'] ?>
                    </td>
                    <td width = "110" colspan = "2" style="font-size: 12px;border-top: none; border-bottom: none; border-left: none; border-right: none">
                        Dok.No : FRM.PBJ.02.02, Rev.00
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="border-top: none; border-bottom: none; border-left: none; border-right: none"  colspan = "2"> <br> </td>
    </tr>
    <tr>
        <td style="border-top: none; border-bottom: none"  colspan = "2">
            <table width="100%" class="table table-hover table1" style = "font-size : 14px">
                <tr>
                    <td width = "10%"> To : </td>
                    <td width = "30%" style = "border-bottom : 1px solid"> <?= $data['rows']['MaterialAdditionalSupplier']['name'] ?></td>
                    <td width = "20%"> </td>
                    <td width = "15%"> Tanggal : </td>
                    <td width = "25%" style = "border-bottom : 1px solid"> <?= $this->Html->cvtTanggal($data['rows']['PurchaseOrderMaterialAdditional']['po_date']) ?></td>
                </tr>
                <tr>
                    <td> </td>
                    <td width = "30%" style = "border-bottom : 1px solid"> <?= $data['rows']['MaterialAdditionalSupplier']['address'] ?></td>
                    <td> </td>
                    <td width = "50"> No. PO : </td>
                    <td width = "25%" style = "border-bottom : 1px solid"> <?= $data['rows']['PurchaseOrderMaterialAdditional']['po_number'] ?></td>
                </tr>
                <tr>
                    <td> </td>
                    <td width = "30%" style = "border-bottom : 1px solid"> <?= $data['rows']['MaterialAdditionalSupplier']['City']['name'] ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="border-top: none; border-bottom: none" colspan = "2"><br></td>
    </tr>
    <tr>
        <td style="border-top: none; border-bottom: none" colspan = "2">
            <table width="100%" class="">
                <tr>
                    <td class = "text-center" colspan = 2> Jumlah </td>
                    <td class = "text-center"> Item dan Spesifikasi </td>
                    <td class = "text-center" colspan = "2"> Harga </td>
                    <td class = "text-center" colspan = "2"> Jumlah </td>
                </tr>
                <?php
                $total = 0;
                foreach ($data['rows']['PurchaseOrderMaterialAdditionalDetail'] as $order) {
                    $total += $order['price'] * $order['quantity'];
                    ?>
                    <tr>
                        <td class = "text-right" style = "border-right-style: none" width = 75px><?= ic_kg($order['quantity']) ?> </td>
                        <td class = "text-left" style = "border-left-style: none" width = 35px><?= $order['MaterialAdditional']['MaterialAdditionalUnit']['uniq'] ?> </td>
                        <td class = "text-center"><?= $order['MaterialAdditional']['name']." ".$order['MaterialAdditional']['size'] ?> </td>
                        <td class = "text-center" style = "border-right: none"> Rp. </td>
                        <td class = "text-right" style = "border-left: none"><?= $this->Html->Rp($order['price']) ?> </td>
                        <td class = "text-center" style = "border-right: none"> Rp. </td>
                        <td class = "text-right" style = "border-left: none"><?= $this->Html->Rp($order['price'] * $order['quantity']) ?> </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td style = "border-right-style: none"> &nbsp </td>
                    <td style = "border-left-style: none"> &nbsp </td>
                    <td> &nbsp </td>
                    <td style = "border-right: none"> &nbsp </td>
                    <td style = "border-left: none"> &nbsp </td>
                    <td style = "border-right: none"> &nbsp </td>
                    <td style = "border-left: none"> &nbsp </td>
                </tr>
                <tr>
                    <td style = "border-right-style: none"> &nbsp </td>
                    <td style = "border-left-style: none"> &nbsp </td>
                    <td> &nbsp </td>
                    <td style = "border-right: none"> &nbsp </td>
                    <td style = "border-left: none"> &nbsp </td>
                    <td class = "text-center" style = "border-right: none"> Rp. </td>
                    <td class = "text-right" style = "border-left: none"> <?= $this->Html->Rp($total) ?> </td>
                </tr>
                <tr>
                    <td style = "border-right-style: none"> &nbsp </td>
                    <td style = "border-left-style: none"> &nbsp </td>
                    <td class = "text-center"> Pajak Pertambahan Nilai (PPN) </td>
                    <td class = "text-center" colspan = "2"> 10% </td>
                    <?php
                    $ppn = ($total * 10) / 100;
                    ?>
                    <td class = "text-center" style = "border-right: none"> Rp. </td>
                    <td class = "text-right" style = "border-left: none"> <?= $this->Html->Rp($ppn) ?> </td>
                </tr>
                <tr>
                    <td style = "border-right-style: none"> &nbsp </td>
                    <td style = "border-left-style: none"> &nbsp </td>
                    <td class = "text-right"> Total </td>
                    <td colspan = "2"> &nbsp </td>
                    <td class = "text-center" style = "border-right: none"> Rp. </td>
                    <td class = "text-right" style = "border-left: none"> <?= $this->Html->Rp($ppn + $total) ?> </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="border-top: none; border-bottom: none" colspan = "2"><br></td>
    </tr>
    <tr>
        <td style="border-top: none; border-bottom: none"  colspan = "2">
            <table width="100%" class="table1">
                <tr>
                    <td> 
                        Barang/Jasa di atas harap dikirimkan ke alamat sebagai berikut
                    </td>
                </tr>
                <tr>
                    <td style = "border-bottom : 1px solid;"> 
                        <b> PT. CHEN WOO FISHERY </b>
                    </td>
                </tr>
                <tr>
                    <td style = "border-bottom : 1px solid"> 
                        <b> JL. KIMA 4 BLOK K9 / B2 </b>
                    </td>
                </tr>
                <tr>
                    <td style = "border-bottom : 1px solid"> 
                        <b> KAWASAN INDUSTRI MAKASSAR (KIMA) </b>
                    </td>
                </tr>
                <tr>
                    <td style = "border-bottom : 1px solid"> 
                        <b> MAKASSAR </b>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="border-top: none; border-bottom: none" colspan = "2"><br></td>
    </tr>
    <tr>
        <td style="border-top: none; border-bottom: none"  colspan = "2">
            <table width="100%" class="table table-hover table1">
                <tr>
                    <td width = "10%"> 
                        PIC
                    </td>
                    <td width = "5%"> 
                        :
                    </td>
                    <td width = "30%" style = "border-bottom: 1px solid"> 
                        <?= $data['rows']['MaterialAdditionalSupplier']['cp_name'] ?>
                    </td>
                    <td width = "55%"> 
                        &nbsp
                    </td>
                </tr>
                <tr>
                    <td width = "10%"> 
                        Telp
                    </td>
                    <td width = "5%"> 
                        :
                    </td>
                    <td width = "30%" style = "border-bottom: 1px solid"> 
                        <?= $data['rows']['MaterialAdditionalSupplier']['cp_phone_number'] ?>
                    </td>
                    <td width = "55%"> 
                        &nbsp
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="border-top: none; border-bottom: none" colspan = "2"><br></td>
    </tr>
    <tr>
        <td style="border-top: none; border-bottom: none"  colspan = "2">
            <table width="100%" class="table table-hover table1">
                <tr>
                    <td style="border: none;">
                        Estimasi Kedatangan Barang
                    </td>
                    <td width = "30%" style = "border-bottom: 1px solid"> 

                    </td>
                    <td width = "30%"> 
                        &nbsp
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="border-top: none; border-bottom: none" colspan = "2"><br></td>
    </tr>
    <tr>
        <td style="border-top: none; border-bottom: none" colspan = "2"><br></td>
    </tr>
    <tr>
        <td style="border-top: none; border-bottom: none" colspan = "2">
            <table width="100%" class="table table-hover table1">
                <tr>
                    <td style="padding:0 0 0 0;">
                        <table width="100%" class="table1">
                            <tr>
                                <td class="text-center" width = "10%">Dibuat Oleh,</td>
                                <td width="5%" style=""></td>
                                <td class="text-center" width = "10%">Disetujui Oleh,</td>
                                <td width="5%" style=""></td>
                                <td class="text-center" width = "10%">Diterima Oleh,</td>
                            </tr>
                            <tr>
                                <td class="text-center" width = "10%"></td>
                                <td width="5%" style=""></td>
                                <td class="text-center" width = "10%"> <i>sertakan cap perusahaan</i></td>
                                <td width="5%" style=""></td>
                                <td class="text-center" width = "10%"><i>sertakan cap perusahaan</i></td>
                            </tr>
                            <tr>
                                <td class="text-center" width = "10%"><br><br><br><br><br></td>
                                <td width="5%" style=""></td>
                                <td class="text-center" width = "10%"><br><br><br><br><br></td>
                                <td width="5%" style=""></td>
                                <td class="text-center" width = "10%"><br><br><br><br><br></td>
                            </tr>
                            <tr>
                                <td class="text-center" width = "10%" style = "border-bottom: 1px solid black"> <?= $data['rows']['Employee']['Account']['Biodata']['full_name'] ?></td>
                                <td width="5%" style=""></td>
                                <td class="text-center" width = "10%" style = "border-bottom: 1px solid black"> <?= $data['rows']['VerifiedBy']['Account']['Biodata']['full_name'] ?></td>
                                <td width="5%" style=""></td>
                                <td class="text-center" width = "10%" style = "border-bottom: 1px solid black"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="border-top: none; border-bottom: none" colspan = "2"><br></td>
    </tr>
</table>