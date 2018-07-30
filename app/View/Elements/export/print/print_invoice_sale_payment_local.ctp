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
        <table width = "100%">
            <tr>
                <td width ="35%" style = "text-align: top; font-weight: bold"> Consigne </td>
                <td> </td>
                <td> </td>
            </tr>
            <tr>
                <td style = "border-top: 1pt solid; border-left: 1pt solid; border-right: 1pt solid; font-weight: bold"> <?= $data['rows']['Buyer']['company_name'] ?> </td>
                <td> </td>
                <td> </td>
            </tr>
            <tr>
                <td style = "border-left: 1pt solid; border-right: 1pt solid; font-weight: bold"> <?= $data['rows']['Buyer']['address'] ?> </td>
                <td> </td>
                <td> </td>
            </tr>
            <tr>
                <td style = "border-left: 1pt solid; border-right: 1pt solid; font-weight: bold">ATTN :  <?= $data['rows']['Buyer']['cp_name'] ?> </td>
                <td> </td>
                <td> </td>
            </tr>
            <tr>
                <td style = "border-left: 1pt solid; border-bottom: 1pt solid;border-right: 1pt solid; font-weight: bold">TELP : <?= $data['rows']['Buyer']['cp_phone_number'] ?> </td>
                <td> </td>
                <td> </td>
            </tr>
        </table>
        <table width = "100%" style="margin-top: 10px;">
            <tr>
                <td width ="25%" style = "text-align: top; font-weight: bold"> PACKING LIST NUMBER </td>
                <td style = "border:1pt solid;"> asdas </td>
                <td width ="25%" style = "text-align: top; font-weight: bold"> Shipment Dated </td>
                <td style = "border:1pt solid;"> <?= $this->Html->cvtTanggal($data['rows']['Shipment']['shipment_date']) ?> </td>
            </tr>
            <tr height = "5px"> </tr>
            <tr>
                <td width ="25%" style = "text-align: top; font-weight: bold"> From </td>
                <td style = "border:1pt solid;"> <?= $data['rows']['Shipment']['from_dock'] ?> </td>
                <td width ="25%" style = "text-align: top; font-weight: bold"> To </td>
                <td style = "border:1pt solid;"> <?= $data['rows']['Shipment']['to_dock'] ?> </td>
            </tr>
            <tr height = "5px"> </tr>
            <tr>
                <td width ="25%" style = "text-align: top; font-weight: bold"> Container Number </td>
                <td style = "border:1pt solid;"> <?= $data['rows']['Shipment']['container_number'] ?> </td>
                <td width ="25%" style = "text-align: top; font-weight: bold"> Seal Number </td>
                <td  style = "border:1pt solid;"> <?= $data['rows']['Shipment']['seal_number'] ?> </td>
            </tr>
            <tr height = "5px"> </tr>
            <tr>
                <td width ="25%" style = "text-align: top; font-weight: bold"> Shipping Agent </td>
                <?php
                if (!empty($data['rows']['Shipment']['ShipmentAgent'])) {
                    ?>
                    <td width ="25%" style = "border:1pt solid;"> <?= $data['rows']['Shipment']['ShipmentAgent']['name'] ?> </td>
                    <?php
                } else {
                    ?>
                    <td width ="25%" style = "border:1pt solid;"> &nbsp; </td>
                    <?php
                }
                ?>
                <td> </td>
            </tr>
        </table>
        <table width ="100%" style="border: 1px solid; margin-top: 20px;">
            <tr>
                <td rowspan ="2" class = "text-center" style="border: 1px solid; font-weight: bold"> NO. </td>
                <td rowspan ="2" class = "text-center" style="border: 1px solid; font-weight: bold"> DESCRIPTION OF GOODS </td>
                <td rowspan ="2" class = "text-center" style="border: 1px solid; font-weight: bold"> SIZE </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> MC</td>
                <td colspan = "2" class = "text-center" style="border: 1px solid; font-weight: bold"> N.WEIGHT</td>
            </tr>
            <tr>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> BULK</td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> NETTO </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> GROSS </td>
            </tr>
            <?php
            $i = 1;
            $quantity = 0;
            $nett = 0;
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
                        <td class = "text-center" style="border: 1px solid">  </td>
                        <td class = "text-center" style="border: 1px solid"> <?= $product['Product']['name'] ?></td>
                        <td class = "text-center" style="border: 1px solid"> <?= $product['Product']['code'] ?></td>
                        <td class = "text-center" style="border: 1px solid"> 
                            <?php
                            $quantity += $product['quantity_production'];
                            ?>
                            <?= $this->Html->berat($product['quantity_production']) ?>
                        </td>
                        <td class = "text-center" style="border: 1px solid"> 
                            <?php
                            $nett += $product['nett_weight'];
                            ?>
                            <?= $this->Html->berat($product['nett_weight']) ?>
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
                <td colspan = "2" class = "text-center" style="border: 1px solid; font-weight: bold"> TOTAL </td>
                <td class = "text-center" style="border: 1px solid "> </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> <?= $this->Html->berat($quantity) ?> </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"><?= $this->Html->berat($nett) ?></td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> <?= $this->Html->Rp($total) ?></td>
            </tr>
        </table>
        <div class="clear"></div>
        <br />
        <div class="clear"></div>
        <table>
            <tr>
                <td width= "40%"class = "text-left"> </td>
                <td width= "20%"class = "text-center" >  </td>
                <td width= "20%"class = "text-center" >  </td>
                <td class = "text-center" > <?= $this->Html->cvtTanggal($data['rows']['Sale']['created']) ?>  </td>
            </tr>
            <tr>
                <td width= "40%"class = "text-left"> </td>
                <td width= "20%"class = "text-center" >  </td>
                <td width= "20%"class = "text-center" >  </td>
                <td class = "text-center" >  </td>
            </tr>
            <tr>
                <td width= "40%"class = "text-left" style="border: 1px solid; font-weight: bold"> TOTAL MASTER CARTONS </td>
                <td width= "20%"class = "text-right" style="border: 1px solid; font-weight: bold"> <?= $this->Html->berat($quantity) ?> </td>
                <td width= "20%"class = "text-center" >  </td>
                <td class = "text-center" >  </td>
            </tr>
            <tr>
                <td width= "40%"class = "text-left" style="border: 1px solid; font-weight: bold"> TOTAL NETT WEIGHT (Kgs)</td>
                <td width= "20%"class = "text-right" style="border: 1px solid; font-weight: bold"> <?= $this->Html->berat($nett) ?> </td>
                <td width= "20%"class = "text-center" >  </td>
                <td class = "text-center" >  </td>
            </tr>
            <tr>
                <td width= "40%"class = "text-left" style="border: 1px solid; font-weight: bold"> TOTAL GROSS WEIGHT (Kgs)</td>
                <td width= "20%"class = "text-right" style="border: 1px solid; font-weight: bold">  </td>
                <td width= "20%"class = "text-center">  </td>
                <td class = "text-center" >  </td>
            </tr>
            <tr>
                <td width= "40%"class = "text-left"></td>
                <td width= "20%"class = "text-center">  </td>
                <td width= "20%"class = "text-center" >  </td>
                <td class = "text-center" > </td>
            </tr>
            <tr>
                <td width= "40%"class = "text-left" ></td>
                <td width= "20%"class = "text-center">  </td>
                <td width= "20%"class = "text-center" >  </td>
                <td class = "text-center"  style="border-top: 1px solid !important; border-style: dashed !important" > Authorized Signature </td>
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
        <table width = "100%">
            <tr>
                <td width ="35%" style = "text-align: top; font-weight: bold"> Consigne </td>
                <td> </td>
                <td> </td>
            </tr>
            <tr>
                <td style = "border-top: 1pt solid; border-left: 1pt solid; border-right: 1pt solid; font-weight: bold"> <?= $data['rows']['Buyer']['company_name'] ?> </td>
                <td> </td>
                <td> </td>
            </tr>
            <tr>
                <td style = "border-left: 1pt solid; border-right: 1pt solid; font-weight: bold"> <?= $data['rows']['Buyer']['address'] ?> </td>
                <td> </td>
                <td> </td>
            </tr>
            <tr>
                <td style = "border-left: 1pt solid; border-right: 1pt solid; font-weight: bold">ATTN :  <?= $data['rows']['Buyer']['cp_name'] ?> </td>
                <td> </td>
                <td> </td>
            </tr>
            <tr>
                <td style = "border-left: 1pt solid; border-bottom: 1pt solid;border-right: 1pt solid; font-weight: bold">TELP : <?= $data['rows']['Buyer']['cp_phone_number'] ?> </td>
                <td> </td>
                <td> </td>
            </tr>
        </table>
        <table width = "100%" style="margin-top: 10px;">
            <tr>
                <td width ="25%" style = "text-align: top; font-weight: bold"> PACKING LIST NUMBER </td>
                <td style = "border:1pt solid;"> asdas </td>
                <td width ="25%" style = "text-align: top; font-weight: bold"> Shipment Dated </td>
                <td style = "border:1pt solid;"> <?= $this->Html->cvtTanggal($data['rows']['Shipment']['shipment_date']) ?> </td>
            </tr>
            <tr height = "5px"> </tr>
            <tr>
                <td width ="25%" style = "text-align: top; font-weight: bold"> From </td>
                <td style = "border:1pt solid;"> <?= $data['rows']['Shipment']['from_dock'] ?> </td>
                <td width ="25%" style = "text-align: top; font-weight: bold"> To </td>
                <td style = "border:1pt solid;"> <?= $data['rows']['Shipment']['to_dock'] ?> </td>
            </tr>
            <tr height = "5px"> </tr>
            <tr>
                <td width ="25%" style = "text-align: top; font-weight: bold"> Container Number </td>
                <td style = "border:1pt solid;"> <?= $data['rows']['Shipment']['container_number'] ?> </td>
                <td width ="25%" style = "text-align: top; font-weight: bold"> Seal Number </td>
                <td  style = "border:1pt solid;"> <?= $data['rows']['Shipment']['seal_number'] ?> </td>
            </tr>
            <tr height = "5px"> </tr>
            <tr>
                <td width ="25%" style = "text-align: top; font-weight: bold"> Shipping Agent </td>
                <?php
                if (!empty($data['rows']['Shipment']['ShipmentAgent'])) {
                    ?>
                    <td width ="25%" style = "border:1pt solid;"> <?= $data['rows']['Shipment']['ShipmentAgent']['name'] ?> </td>
                    <?php
                } else {
                    ?>
                    <td width ="25%" style = "border:1pt solid;"> &nbsp; </td>
                    <?php
                }
                ?>
                <td> </td>
            </tr>
        </table>
        <table width ="100%" style="border: 1px solid; margin-top: 20px;">
            <tr>
                <td rowspan ="2" class = "text-center" style="border: 1px solid; font-weight: bold"> NO. </td>
                <td rowspan ="2" class = "text-center" style="border: 1px solid; font-weight: bold"> DESCRIPTION OF GOODS </td>
                <td rowspan ="2" class = "text-center" style="border: 1px solid; font-weight: bold"> SIZE </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> QUANTITY</td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> U. PRICE</td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> T. AMOUNT</td>
            </tr>
            <tr>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> KGS</td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> IDR </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> IDR </td>
            </tr>
            <?php
            $i = 1;
            $quantity = 0;
            $nett = 0;
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
                        <td class = "text-center" style="border: 1px solid">  </td>
                        <td class = "text-center" style="border: 1px solid"> <?= $product['Product']['name'] ?></td>
                        <td class = "text-center" style="border: 1px solid"> <?= $product['Product']['code'] ?></td>
                        <td class = "text-center" style="border: 1px solid"> 
                            <?php
                            $nett += $product['nett_weight'];
                            ?>
                            <?= $this->Html->berat($product['nett_weight']) ?>
                        </td>
                        <td class = "text-center" style="border: 1px solid"> 
                            <?php
                            $quantity += $product['price'];
                            ?>
                            <?= $this->Html->dotNumberSeperator($quantity) ?>
                        </td>
                        <td class = "text-center" style="border: 1px solid"> 
                            <?php
                            $total += $product['price'] * $product['nett_weight'];
                            ?>
                            <?= $this->Html->dotNumberSeperator($product['price'] * $product['nett_weight']) ?>
                        </td>
                    </tr>
                    <?php
                }
                $i++;
            }
            ?>
            <tr>
                <td colspan = "2" class = "text-center" style="border: 1px solid; font-weight: bold"> GRAND TOTAL </td>
                <td class = "text-center" style="border: 1px solid "> </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> <?= $this->Html->berat($nett) ?> </td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"><?= $this->Html->berat($quantity) ?></td>
                <td class = "text-center" style="border: 1px solid; font-weight: bold"> <?= $this->Html->dotNumberSeperator($total) ?></td>
            </tr>
        </table>
        <div class="clear"></div>
        <br />
        <div class="clear"></div>
        <table>
            <tr>
                <td width= "40%"class = "text-left"> </td>
                <td width= "20%"class = "text-center" >  </td>
                <td width= "20%"class = "text-center" >  </td>
                <td class = "text-center" > <?= $this->Html->cvtTanggal($data['rows']['Sale']['created']) ?>  </td>
            </tr>
            <tr>
                <td width= "40%"class = "text-left"> </td>
                <td width= "20%"class = "text-center" >  </td>
                <td width= "20%"class = "text-center" > </td>
                <td class = "text-center" >  </td>
            </tr>
            <tr>
                <td width= "40%"class = "text-left">&nbsp; </td>
                <td width= "20%"class = "text-right">  &nbsp;</td>
                <td width= "20%"class = "text-center" >  </td>
                <td class = "text-center" >  </td>
            </tr>
            <tr>
                <td width= "40%"class = "text-left" >&nbsp; </td>
                <td width= "20%"class = "text-right" > &nbsp; </td>
                <td width= "20%"class = "text-center" > </td>
                <td class = "text-center" >  </td>
            </tr>
            <tr>
                <td width= "40%"class = "text-left"> &nbsp;</td>
                <td width= "20%"class = "text-right"> &nbsp; </td>
                <td width= "20%"class = "text-center"></td>
                <td class = "text-center" >  </td>
            </tr>
            <tr>
                <td width= "40%"class = "text-left"></td>
                <td width= "20%"class = "text-center">  </td>
                <td width= "20%"class = "text-center" ></td>
                <td class = "text-center" > </td>
            </tr>
            <tr>
                <td width= "40%"class = "text-left" ></td>
                <td width= "20%"class = "text-center">  </td>
                <td width= "20%"class = "text-center" >  </td>
                <td class = "text-center"  style="border-top: 1px solid !important; border-style: dashed !important" > Authorized Signature </td>
            </tr>
        </table>
    </div>

    <?php
}
?>