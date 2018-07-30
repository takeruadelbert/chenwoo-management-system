<?php
if (!empty($data['rows'])) {
    ?>
    <div onload = "window.print()">
        <div class="container-print" style="width:955px; margin:10px auto;">
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
            <div style="clear:both"></div>
            <div class="input-data">
                <table class="title">
                    <tbody>
                    <thead>
                        <tr>
                            <th class="center-text">
                    <div class="report-title">INVOICE PENJUALAN MATERIAL PEMBANTU</div>
                    </th>
                    </tr>
                    </thead>
                    </tbody>
                </table>
            </div>
        </div>
        <table width = "100%">
            <tr>
                <td rowspan = "8" style = "text-align: top; font-weight: bold"> TO : </td>
                <td colspan = "2" style = "border-top: 1pt solid; border-left: 1pt solid; border-right: 1pt solid; font-weight: bold"> <?= $data['rows']['Supplier']['name'] ?> </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> INVOICE NO </td>
                <td style = "font-weight: bold">  <?= $data['rows']['MaterialAdditionalSale']['no_sale'] ?></td>
            </tr>
            <tr border-bottom= "1pt">
                <td colspan = "2" style = "border-left: 1pt solid; border-right: 1pt solid; font-weight: bold"> 
                    <?= emptyToStrip(@$data['rows']['Supplier']['address']) ?> 
                </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> TANGGAL PENJUALAN </td>
                <td style = "font-weight: bold">  <?= $this->Html->cvtTanggal($data['rows']['MaterialAdditionalSale']['sale_dt']) ?></td>
            </tr>
            <tr>
                <td colspan = "2" style = "border-left: 1pt solid; border-right: 1pt solid; font-weight: bold">
                    <?= @$data['rows']['Supplier']['City']['name'] ?>, <?= @ $data['rows']['Supplier']['Country']['name'] ?> <?= @$data['rows']['Supplier']['postal_code'] ?> 
                </td>
            </tr>
            <tr>
                <td colspan = "2" style = "border-bottom: 1pt solid; border-left: 1pt solid; border-right: 1pt solid; font-weight: bold"> Tel: <?= $data['rows']['Supplier']['phone_number'] ?> </td>
            </tr>
    <!--            <tr>
                <td style = "font-weight: bold">SHIPPED BY </td>
                <td style = "font-weight: bold"><? $data['rows']['Shipment']['ShipmentAgent']['name'] ?> </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> FROM </td>
                <td style = "font-weight: bold"> <? $data['rows']['Shipment']['from_dock'] ?> </td>
            </tr>
            <tr>
                <td style = "font-weight: bold">DATE INVOICE </td>
                <td style = "font-weight: bold"><? $this->Html->cvtTanggal($data['rows']['Sale']['created']) ?> </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> TO </td>
                <td style = "font-weight: bold"> <? $data['rows']['Shipment']['to_dock'] ?>  </td>
            </tr>
            <tr>
                <td style = "font-weight: bold">CONTAINER NUMBER </td>
                <td style = "font-weight: bold"><? $data['rows']['Shipment']['container_number'] ?> </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> B/L NUMBER </td>
                <td style = "font-weight: bold"> <? $data['rows']['Shipment']['bl_number'] ?>  </td>
            </tr>
            <tr>
                <td style = "font-weight: bold">SEAL NUMBER </td>
                <td style = "font-weight: bold"> <? $data['rows']['Shipment']['seal_number'] ?>  </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> FDA REG NO. </td>
                <td style = "font-weight: bold">  <? $data['rows']['Shipment']['fda_reg_no'] ?>  </td>
            </tr>-->
        </table>
        <br><br>
        <table width ="100%" style="border: 1px solid">
            <tr>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> NO. </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> NAMA MATERIAL </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> JUMLAH </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> HARGA SATUAN (IDR)</td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> TOTAL (IDR)</td>
            </tr>
            <?php
            $i = 1;
            $total = 0;
            foreach ($data['rows']['MaterialAdditionalSaleDetail'] as $details) {
                ?>
                <tr>
                    <td  class = "text-center" style="border: 1px solid; font-weight: bold;"><?= $i ?></td>
                    <td class='text-center' style="border: 1px solid; font-weight: bold;"><?= $details['MaterialAdditional']['name'] . ' ' . $details['MaterialAdditional']['size'] ?></td>
                    <td class="text-right" style="border: 1px solid; font-weight: bold;"><?= ic_kg($details['quantity']) . " " . $details['MaterialAdditional']['MaterialAdditionalUnit']['uniq'] ?></td>
                    <td class="text-right" style="border: 1px solid; font-weight: bold;"><?= ic_rupiah($details['price']) ?></td>
                    <td class='text-right' style="border: 1px solid; font-weight: bold;">
                        <?php
                        $temp = $details['quantity'] * $details['price'];
                        echo ic_rupiah($temp);
                        $total += $temp;
                        ?>
                    </td>
                </tr>
                <?php
                $i++;
            }
            ?>
            <tr>
                <td colspan = "4" class = "text-center" style="border: 1px solid; font-weight: bold"> Grand Total </td>
                <td class = "text-right" style="border: 1px solid; font-weight: bold"> <?= ic_rupiah($total) ?></td>
            </tr>
        </table>
        <p style = "font-weight: bold; margin-top: 10px;">(TERBILANG : <?= angka2kalimat($total) ?> rupiah.)</p>
        <div class="clear"></div>
        <br />
        <div class="clear"></div>
        <table>
            <tr>
                <td width= "75%"class = "text-right" style="border-top: 1px solid;border-right: 1px solid;border-left: 1px solid; font-weight: bold"> PAYMENT: BY TELEGRAPHIC TRANSFER </td>
                <td class = "text-center" >  </td>
                <td class = "text-center" > Makassar, <?= $this->Html->cvtTanggal(date("Y-m-d")) ?>  </td>
            </tr>
            <tr>
                <td width= "75%"class = "text-right" style="border-right: 1px solid;border-left: 1px solid; font-weight: bold"> BENEFICIARY: PT CHEN WOO FISHERY </td>
                <td class = "text-center" >  </td>
                <td class = "text-center" >  </td>
            </tr>
            <tr>
                <td width= "75%"class = "text-right" style="border-right: 1px solid;border-left: 1px solid; font-weight: bold"> BANK: BANK CENTRAL ASIA </td>
                <td class = "text-center" >  </td>
                <td class = "text-center" >  </td>
            </tr>
            <tr>
                <td width= "75%"class = "text-right" style="border-right: 1px solid;border-left: 1px solid; font-weight: bold"> AHMAD YANI BRANCH. MAKASSAR - SOUTH SULAWESI - INDONESIA</td>
                <td class = "text-center" >  </td>
                <td class = "text-center" >  </td>
            </tr>
            <tr>
                <td width= "75%"class = "text-right" style="border-right: 1px solid;border-left: 1px solid; font-weight: bold"> SWIFT CODE: CENAIDJA</td>
                <td class = "text-center" >  </td>
                <td class = "text-center" >  </td>
            </tr>
            <tr>
                <td width= "75%"class = "text-right" style="border-right: 1px solid;border-left: 1px solid; font-weight: bold"> PT. Chen Woo Bank USD A/C:</td>
                <td class = "text-center" >  </td>
                <td class = "text-center" style="border-bottom: 1px solid; border-style: dashed" > PT. Chen Woo Fishery </td>
            </tr>
            <tr>
                <td width= "75%"class = "text-right" style="border-bottom: 1px solid;border-right: 1px solid;border-left: 1px solid; font-weight: bold"> 110-3107788</td>
                <td class = "text-center" >  </td>
                <td class = "text-center"  > Authorized Signature </td>
            </tr>
        </table>
    </div>
    <?php
}
?>