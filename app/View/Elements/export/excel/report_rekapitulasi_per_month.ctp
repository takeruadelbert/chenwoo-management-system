<?php
$dataBranchOffice = ClassRegistry::init("BranchOffice")->find("first", [
    "conditions" => [
        "BranchOffice.id" => $this->request->query['Sale_branch_office_id']
    ]
        ]);
if (!empty($data['rows'])) {
    ?>
    <style>
        .table-bordered,tr,td{
            border:1px solid black;
            border-collapse: collapse;
        }
    </style>
    <div style="float:left;width:550px;">
        <div><?= $dataBranchOffice['BranchOffice']['name'] ?></div>
        <div><?php echo $data['title'] ?></div>
        <div style=''>Periode : <?= $this->Html->cvtTanggal($this->request->query['start_date']) ?> - <?= $this->Html->cvtTanggal($this->request->query['end_date']) ?></div>
    </div>
    <div style="clear: both;"></div>
    <table class="table-bordered" style="margin-top:10px;"> 
        <tr style="text-align:center;">
            <td width="10%">DATE</td>
            <td width="20%">CONSIGNEE</td>
            <td width="10%">SHIPMENT DESTINATION</td>
            <td width="15%">ORDER REFERENCE / INVOICE</td>
            <td width="15%">QUANTITY (Tons/Kg)</td>
            <td width="15%">SALES AMOUNT (USD)</td>
            <td width="15%">TOTAL AMOUNT (Rp.)</td>
        </tr>
        <?php
        $number = 1;
        $quantityGrandTotal = 0;
        $salesAmountGrandTotal = 0;
        $total = 0;
        foreach ($data['rows']as $data) {
            ?>
            <tr>
                <td class = "text-center"><?= $this->Html->cvtTanggal($data['Sale']['created']) ?></td>
                <td><?= $data['Buyer']['company_name'] ?></td>
                <td><?= $data['Shipment']['to_dock'] ?></td>
                <?php
                $invoice = "-";
                $weightTotal = 0;
                $kurs = $data['Sale']['exchange_rate'];
                $salesAmountGrandTotal+=$data['Sale']['grand_total'];
                foreach ($data['SaleDetail']as $detail) {
                    $weightTotal+=$detail['nett_weight'];
                    $quantityGrandTotal+=$detail['nett_weight'];
                }
                ?>
                <td><?= $data['Sale']['po_number'] . " / " . $invoice ?></td>
                <td class="text-right"><?= $weightTotal ?></td>
                <td class="text-right"><?= $data['Sale']['grand_total'] ?></td>
                <td class="text-right"><?= $this->Html->Rp($data['Sale']['grand_total'] * $kurs) ?></td>
                <?php
                $total +=$data['Sale']['grand_total'] * $kurs;
                ?>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td  colspan="4">Total Export / Penjualan :</td>
            <td class="text-right"><?= $quantityGrandTotal ?></td>
            <td class="text-right"><?= $salesAmountGrandTotal ?></td>
            <td class="text-right"><?= $this->Html->Rp($total) ?></td>
        </tr>   
        <?php
    } else {
        echo "<div class='text-center'><h2>Tidak Ada Data</h2></div>";
    }
    ?>
</table>