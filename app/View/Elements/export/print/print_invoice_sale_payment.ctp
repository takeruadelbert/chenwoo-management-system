<?php
if (!empty($data['rows'])) {
    $groupedProduct = [];
    foreach ($data['rows']['SaleDetail'] as $product) {
        if (!isset($groupedProduct[$product["Product"]["Parent"]["id"]])) {
            $groupedProduct[$product["Product"]["Parent"]["id"]] = [
                "data" => [],
                "label" => $product["Product"]["Parent"]["name"],
            ];
        }
        $groupedProduct[$product["Product"]["Parent"]["id"]]["data"][] = $product;
    }
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
                    <div class="report-title">INVOICE</div>
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
                <td colspan = "2" style = "border-top: 1pt solid; border-left: 1pt solid; border-right: 1pt solid; font-weight: bold"> <?= $data['rows']['Buyer']['company_name'] ?> </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> INVOICE NO </td>
                <td style = "font-weight: bold">  <?= $data['rows']['Sale']['sale_no'] ?></td>
            </tr>
            <tr border-bottom= "1pt">
                <td colspan = "2" style = "border-left: 1pt solid; border-right: 1pt solid; font-weight: bold"> 
                    <?= $data['rows']['Buyer']['address'] ?> 
                </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> PO NUMBER </td>
                <td style = "font-weight: bold"> <?= $data['rows']['Sale']['po_number'] ?>  </td>
            </tr>
            <tr>
                <td colspan = "2" style = "border-left: 1pt solid; border-right: 1pt solid; font-weight: bold">
                    <?= @$data['rows']['Buyer']['City']['name'] ?>, <?= @ $data['rows']['Buyer']['Country']['name'] ?> <?= @$data['rows']['Buyer']['postal_code'] ?> 
                </td>
            </tr>
            <tr>
                <td colspan = "2" style = "border-bottom: 1pt solid; border-left: 1pt solid; border-right: 1pt solid; font-weight: bold"> Tel: <?= $data['rows']['Buyer']['phone_number'] ?> </td>
            </tr>
            <tr>
                <td style = "font-weight: bold">SHIPPED BY </td>
                <td style = "font-weight: bold"><?= $data['rows']['Shipment']['ShipmentAgent']['name'] ?> </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> FROM </td>
                <td style = "font-weight: bold"> <?= $data['rows']['Shipment']['from_dock'] ?> </td>
            </tr>
            <tr>
                <td style = "font-weight: bold">DATE INVOICE </td>
                <td style = "font-weight: bold"><?= $this->Html->cvtTanggal($data['rows']['Sale']['created']) ?> </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> TO </td>
                <td style = "font-weight: bold"> <?= $data['rows']['Shipment']['to_dock'] ?>  </td>
            </tr>
            <tr>
                <td style = "font-weight: bold">CONTAINER NUMBER </td>
                <td style = "font-weight: bold"><?= $data['rows']['Shipment']['container_number'] ?> </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> B/L NUMBER </td>
                <td style = "font-weight: bold"> <?= $data['rows']['Shipment']['bl_number'] ?>  </td>
            </tr>
            <tr>
                <td style = "font-weight: bold">SEAL NUMBER </td>
                <td style = "font-weight: bold"> <?= $data['rows']['Shipment']['seal_number'] ?>  </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> FDA REG NO. </td>
                <td style = "font-weight: bold">  <?= $data['rows']['Shipment']['fda_reg_no'] ?>  </td>
            </tr>
        </table>
        <table width ="100%" style="border: 1px solid">
            <tr>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> NO. </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> DESCRIPTION & SIZE </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> ITEM CODE </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> QTY (Lbs)</td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> UNIT PRICE (USD)</td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> TOTAL AMOUNT (USD)</td>
            </tr>
            <?php
            $i = 1;
            $quantity = 0;
            $total = 0;
            foreach ($groupedProduct as $k => $categoryProduct) {
                ?>
                <tr>
                    <td  class = "text-center" style="border: 1px solid"> 
                        <?= $i ?>
                        <input type = "hidden" class = "idx"value=" <?= $i ?>">
                    </td>
                    <td colspan = "5" class = "text-center" style="border: 1px solid; font-weight: bold"> <?= $categoryProduct['label'] ?></td>
                </tr>
                <?php
                foreach ($categoryProduct["data"] as $product) {
                    ?>
                    <tr>
                        <td class = "text-center" style="border: 1px solid"> </td>
                        <td class = "text-center" style="border: 1px solid"> <?= $product['Product']['name'] ?></td>
                        <td class = "text-center" style="border: 1px solid"> <?= $product['Product']['code'] ?></td>
                        <td class = "text-center" style="border: 1px solid"> 
                            <?php
                            $quantity += $product['quantity'] * $product['McWeight']['lbs'];
                            ?>
                            <?= $product['quantity'] * $product['McWeight']['lbs'] ?>
                        </td>
                        <td class = "text-right" style="border: 1px solid"> 
                            <?= (ac_dollar($product['price'])) ?>
                        </td>
                        <td class = "text-right" style="border: 1px solid">
                            <?php
                            $harga = $product['quantity'] * $product['McWeight']['lbs'] * $product['price'];
                            $total += $harga;
                            ?>
                            <?= (ac_dollar($harga)) ?>
                        </td>
                    </tr>
                    <?php
                }
                $i++;
            }
            ?>
            <tr>
                <td colspan = "2" class = "text-center" style="border: 1px solid; font-weight: bold"> Grand Total </td>
                <td class = "text-center" style="border: 1px solid "> </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> <?= $quantity ?> </td>
                <td class = "text-center" style="border: 1px solid"></td>
                <td class = "text-right" style="border: 1px solid; font-weight: bold"> <?= ac_dollar($total) ?></td>
            </tr>
        </table>
        <!--<p style = "font-weight: bold; margin-top: 10px;">(SAY : <?= angka2kalimat($total) ?>)</p>-->
        <div class="clear"></div>
        <br />
        <div class="clear"></div>
        <table>
            <tr>
                <td width= "75%"class = "text-right" style="border-top: 1px solid;border-right: 1px solid;border-left: 1px solid; font-weight: bold"> PAYMENT: BY TELEGRAPHIC TRANSFER </td>
                <td class = "text-center" >  </td>
                <td class = "text-center" > Makassar, <?= $this->Html->cvtTanggal($data['rows']['Sale']['created']) ?>  </td>
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
<?php
if (!empty($data['rows'])) {
    $groupedProduct = [];
    foreach ($data['rows']['SaleDetail'] as $product) {
        if (!isset($groupedProduct[$product["Product"]["Parent"]["id"]])) {
            $groupedProduct[$product["Product"]["Parent"]["id"]] = [
                "data" => [],
                "label" => $product["Product"]["Parent"]["name"],
            ];
        }
        $groupedProduct[$product["Product"]["Parent"]["id"]]["data"][] = $product;
    }
    ?>
    <div onload = "window.print()" class="page-break">
        <div class="container-print" style="width:100%; margin:10px auto;">
            <div id="identity">
                <div class="no-margin no-padding text-left" style="width:100%">
                    <?php
                    $entity = ClassRegistry::init("EntityConfiguration")->find("first");
                    ?>
                    <div style="display:inline-block; margin-right: 15px;">
                        <img src="<?php echo Router::url($entity['EntityConfiguration']['logo1'], true) ?>"/>
                    </div>
                    <div style="display:inline-block;width: 825px;" >
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
                    <div class="report-title">PACKING LIST</div>
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
                <td colspan = "2" style = "border-top: 1pt solid; border-left: 1pt solid; border-right: 1pt solid; font-weight: bold"> <?= $data['rows']['Buyer']['company_name'] ?> </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> INVOICE NO </td>
                <td style = "font-weight: bold">  <?= $data['rows']['Sale']['sale_no'] ?></td>
            </tr>
            <tr border-bottom= "1pt">
                <td colspan = "2" style = "border-left: 1pt solid; border-right: 1pt solid; font-weight: bold"> 
                    <?= $data['rows']['Buyer']['address'] ?> 
                </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> PO NUMBER </td>
                <td style = "font-weight: bold"> <?= $data['rows']['Sale']['po_number'] ?>  </td>
            </tr>
            <tr>
                <td colspan = "2" style = "border-left: 1pt solid; border-right: 1pt solid; font-weight: bold">
                    <?php
                    if ($data['rows']['Buyer'] != null) {
                        ?>
                        <?= @$data['rows']['Buyer']['City']['name'] ?>, <?= @$data['rows']['Buyer']['Country']['name'] ?> <?= @$data['rows']['Buyer']['postal_code'] ?> 
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan = "2" style = "border-bottom: 1pt solid; border-left: 1pt solid; border-right: 1pt solid; font-weight: bold"> Tel: <?= $data['rows']['Buyer']['phone_number'] ?> </td>
            </tr>
            <tr>
                <td style = "font-weight: bold">SHIPPED BY </td>
                <td style = "font-weight: bold"><?= $data['rows']['Shipment']['ShipmentAgent']['name'] ?> </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> FROM </td>
                <td style = "font-weight: bold"> <?= $data['rows']['Shipment']['from_dock'] ?> </td>
            </tr>
            <tr>
                <td style = "font-weight: bold">DATE INVOICE </td>
                <td style = "font-weight: bold"><?= $this->Html->cvtTanggal($data['rows']['Sale']['created']) ?> </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> TO </td>
                <td style = "font-weight: bold"> <?= $data['rows']['Shipment']['to_dock'] ?>  </td>
            </tr>
            <tr>
                <td style = "font-weight: bold">CONTAINER NUMBER </td>
                <td style = "font-weight: bold"><?= $data['rows']['Shipment']['container_number'] ?> </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> B/L NUMBER </td>
                <td style = "font-weight: bold"> <?= $data['rows']['Shipment']['bl_number'] ?>  </td>
            </tr>
            <tr>
                <td style = "font-weight: bold">SEAL NUMBER </td>
                <td style = "font-weight: bold"> <?= $data['rows']['Shipment']['seal_number'] ?>  </td>
                <td> </td>
                <td> </td>
                <td style = "font-weight: bold"> FDA REG NO. </td>
                <td style = "font-weight: bold">  <?= $data['rows']['Shipment']['fda_reg_no'] ?>  </td>
            </tr>
        </table>
        <table style="border: 1px solid">
            <tr>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> NO. </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> DESCRIPTION & SIZE </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> ITEM CODE </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> MC QTY</td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> NET WEIGHT (KGS)</td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> GROSS WEIGHT (KGS)</td>
            </tr>
            <?php
            $i = 1;
            $quantity = 0;
            $nett = 0;
            $gross = 0;
            foreach ($groupedProduct as $k => $categoryProduct) {
                ?>
                <tr>
                    <td  class = "text-center" style="border: 1px solid"> 
                        <?= $i ?>
                        <input type = "hidden" class = "idx"value=" <?= $i ?>">
                    </td>
                    <td colspan = "5" class = "text-center" style="border: 1px solid; font-weight: bold"> <?= $categoryProduct['label'] ?></td>
                </tr>
                <?php
                foreach ($categoryProduct["data"] as $product) {
                    ?>

                    <tr>
                        <td class = "text-center" style="border: 1px solid"> </td>
                        <td class = "text-center" style="border: 1px solid"> <?= $product['Product']['name'] ?></td>
                        <td class = "text-center" style="border: 1px solid"> <?= $product['Product']['code'] ?></td>
                        <td class = "text-center" style="border: 1px solid"> 
                            <?php
                            $quantity += $product['quantity_production'];
                            ?>
                            <?= $product['quantity_production'] ?>
                        </td>
                        <td class = "text-right" style="border: 1px solid"> 
                            <?php
                            $nett += $product['nett_weight'];
                            ?>
                            <?= $product['nett_weight'] ?>
                        </td>
                        <td class = "text-center" style="border: 1px solid">
                        </td>
                    </tr>
                    <?php
                }
                $i++;
            }
            ?>
            <tr>
                <td colspan = "2" class = "text-center" style="border: 1px solid; font-weight: bold"> Grand Total </td>
                <td class = "text-center" style="border: 1px solid "> </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> <?= $this->Html->berat($quantity) ?> </td>
                <td class = "text-right" style="border: 1px solid; font-weight: bold"> <?= $this->Html->berat($nett) ?> </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> <?= $this->Html->berat($gross) ?></td>
            </tr>
        </table>
        <div class="clear"></div>
        <br />
        <div class="clear"></div>
        <table>
            <tr>
                <td width= "75%"></td>
                <td class = "text-center" >  </td>
                <td class = "text-center" > Makassar, <?= $this->Html->cvtTanggal($data['rows']['Sale']['created']) ?>  </td>
            </tr>
            <tr>
                <td width= "75%"></td>
                <td class = "text-center" > &nbsp; </td>
                <td class = "text-center" > &nbsp; </td>
            </tr>
            <tr>
                <td width= "75%"> </td>
                <td class = "text-center" > &nbsp; </td>
                <td class = "text-center" > &nbsp; </td>
            </tr>
            <tr>
                <td width= "75%"></td>
                <td class = "text-center" > &nbsp; </td>
                <td class = "text-center" > &nbsp; </td>
            </tr>
            <tr>
                <td width= "75%"></td>
                <td class = "text-center" > &nbsp; </td>
                <td class = "text-center" > &nbsp; </td>
            </tr>
            <tr>
                <td width= "75%"></td>
                <td class = "text-center" > &nbsp; </td>
                <td class = "text-center" style="border-bottom: 1px solid !important; border-style: dashed !important" > PT. Chen Woo Fishery </td>
            </tr>
            <tr>
                <td width= "75%"></td>
                <td class = "text-center" > &nbsp; </td>
                <td class = "text-center"  > Authorized Signature </td>
            </tr>
        </table>
    </div>

    <?php
}
?>
