<?php
$dataBranchOffice = ClassRegistry::init("BranchOffice")->find("first", [
    "conditions" => [
        "BranchOffice.id" => $this->request->query['Sale_branch_office_id']
    ]
        ]);
if (!empty($data['rows'])) {
    ?>
    <style>
        .table-bordered,tr,td,th{
            border:1px solid black;
            border-collapse: collapse;
        }
    </style>
    <div style="float:left;width:550px;">
        <div><?= $dataBranchOffice['BranchOffice']['name'] ?></div>
        <div><?php echo $data['title'] . " ke " . $data['rows'][0]['Buyer']['company_name'] ?></div>
    </div>
    <div style="float:left;">
        <div style=''>Periode : <?= $this->Html->cvtTanggal($this->request->query['start_date']) ?> - <?= $this->Html->cvtTanggal($this->request->query['end_date']) ?></div>
    </div>
    <div style="clear: both;"></div>
    <table class="table-data" style="margin-top:10px;"> 
        <tr style="text-align:center;">
            <th width="30px">NO</th>
            <th width="30px">NO INVOICE</th>
            <th width="200px">DESCRIPTION OF GOODS</th>
            <th width="100px">SIZE</th>
            <th width="80px">QUANTITY</th>
            <th width="100px">U/PRICE (Rp.)</th>
            <th width="150px">U/PRICE (USD)</th>
            <th width="200px">AMOUNT (Rp.)</th>
            <th width="150px">AMOUNT (USD)</th>
            <th width="100px">KET</th>
        </tr>
        <?php
        $number = 1;
        $fishList = array();
        $kurs = 13000;
        foreach ($data['rows']as $invoice) {
            $first = true;
            foreach ($invoice['SaleDetail'] as $product) {
                ?>
                <tr>
                    <?php
                    if ($first == true) {
                        ?>
                        <td><?= $number ?></td>
                        <td><?= $invoice['Sale']['po_number'] ?></td> <!--$invoice['TransactionOut']['invoice_number']-->
                        <?php
                    } else {
                        ?>
                        <td></td>
                        <td></td>
                        <?php
                    }
                    ?>
                    <td><?= $product['Product']['Parent']['name'] ?></td>
                    <td><?= $product['Product']['name'] ?></td>
                    <td class = "text-right"><?= number_format(($product['nett_weight'] * 2.20462), 2) ?></td>
                    <td class = "text-right"><?= $this->Html->berat($product['price'] * $kurs) ?></td>
                    <td class = "text-right"><?= $product['price'] ?></td>
                    <td class = "text-right"><?= $this->Html->berat($product['price'] * $product['quantity'] * $kurs) ?></td>
                    <td class = "text-right"><?= $product['price'] * $product['quantity'] ?></td>
                    <?php
                    if ($first == true) {
                        $first = false;
                        ?>
                        <td>Kurs : <?= $this->Html->IDR($kurs) ?></td>
                        <?php
                    } else {
                        ?>
                        <td></td>
                        <?php
                    }
                    ?>

                </tr> 
                <?php
            }
            $number++;
        }
    } else {
        echo "<div class='text-center'><h2>Tidak Ada Data</h2></div>";
    }
    ?>
</table>