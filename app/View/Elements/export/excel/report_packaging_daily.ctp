<?php
$dataBranchOffice = ClassRegistry::init("BranchOffice")->find("first", [
    "conditions" => [
        "BranchOffice.id" => $this->request->query['Package_branch_office_id']
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
    <h2 style="text-align: center">
        <?= $data['title'] ?>
        <br>
        <?= !empty($dataBranchOffice) ? "CABANG " . $dataBranchOffice['BranchOffice']['name'] : "SELURUH CABANG" ?>
    </h2>
    <table style="border:none !important; margin-top: 10px;" width = "100%">
        <tr style="border:none !important">
            <td style = "border:none !important;" class = "text-left" width = "35%">
                <b>Date : </b> <?php echo $this->Html->cvtHari($data['rows'][0]['PackageDetail']['created']) . ", " . $this->Html->cvtTanggal($data['rows'][0]['PackageDetail']['created']) ?>
            </td> 
            <td style = "border:none !important;">
            </td> 
            <td style = "border:none !important; font-size:12px;" class = "text-right" width = "35%">
                Dok.No. : FRM.PRO.01.12, Rev.01
            </td> 
        </tr>
    </table>
    <table class="table-bordered" style="margin-top:10px;" width = "100%"> 
        <tr style="text-align:center;">
            <th width="30px" rowspan="2">NO</th>
            <th width="200px" rowspan="2">KIND OF FISH</th>
            <th width="100px" rowspan="2">GRADE</th>
            <th width="100px">MC</th>
            <th width="150px" rowspan="2">PEMBELI</th>
            <th width="150px" colspan="2">PACKING UNIT</th>
            <th width="80px" rowspan="2">TOTAL KGS</th>
            <th width="80px" rowspan="2">REAL KGS</th>
        </tr>
        <tr style="text-align:center;">
            <th>TOTAL</th>
            <th>LBS</th>
            <th>KGS</th>
        </tr>
        <?php
        $number = 1;
        $fishList = array();
        foreach ($data['rows']as $package) {
            //foreach ($package['PackageDetail'] as $product) {
            if (count($fishList) == 0) {
                array_push($fishList, ['name' => $package['Product']['Parent']['name'], 'size' => $package['Product']['name'], 'weight' => $package['PackageDetail']['nett_weight'], 'total' => $package['PackageDetail']['nett_weight'], 'buyer' => $package['Sale']['Buyer']['company_name'], 'count' => 1]);
            } else {
                for ($i = 0; $i < count($fishList); $i++) {
                    if ($package['Product']['Parent']['name'] == $fishList[$i]['name'] && $package['Product']['name'] == $fishList[$i]['size']) {
                        $total = $fishList[$i]['total'] + $package['PackageDetail']['nett_weight'];
                        $fishList[$i]['total'] = $total;
                        $fishList[$i]['count'] = $fishList[$i]['count'] + 1;
                    } else if ($i == count($fishList) - 1) {
                        array_push($fishList, ['name' => $package['Product']['Parent']['name'], 'size' => $package['Product']['name'], 'weight' => $package['PackageDetail']['nett_weight'], 'total' => $package['PackageDetail']['nett_weight'], 'buyer' => $package['Sale']['Buyer']['company_name'], 'count' => 1]);
                    }
                }
            }
            //}
        }
        foreach ($fishList as $item) {
            ?>    
            <!--Set List-->
            <tr>
                <td class="text-center"><?= $number ?></td>
                <td><?= $item['name'] ?></td>
                <td class="text-center"><?= $item['size'] ?></td>
                <td style="text-align:center"><?= $item['count'] ?></td>
                <td style="text-align:center"><?= $item['buyer'] ?></td>
                <td style="text-align:center"><?= number_format($item['weight'] * 2.20462, 2, '.', '') ?></td> <!-- LBS -->
                <td style="text-align:center"><?= $item['weight'] ?></td> <!-- KGS -->
                <td style="text-align:center"><?= $item['weight'] * $item['count'] ?></td>
                <td style="text-align:center"></td>
            </tr> 
            <?php
            $number++;
        }
        ?>
    </table>
    <table width = "100%" style="border:none !important; margin-top:20px;">
        <tr style="border:none !important">
            <td style = "border:none !important;" class = "text-center" width="25%"> Prepared By </td>
            <td style = "border:none !important;" class = "text-center" width="13%"> </td>
            <td style = "border:none !important;" class = "text-center" width="25%"> Checked By </td>
            <td style = "border:none !important;" class = "text-center" width="13%"> </td>
            <td style = "border:none !important;" class = "text-center" width="25%"> Approved By </td>
        </tr>
        <tr style="border:none !important" height="60px">
            <td style = "border:none !important;" class = "text-center" width="25%"> </td>
            <td style = "border:none !important;" class = "text-center" width="13%"> </td>
            <td style = "border:none !important;" class = "text-center" width="25%"> </td>
            <td style = "border:none !important;" class = "text-center" width="13%"> </td>
            <td style = "border:none !important;" class = "text-center" width="25%"> </td>
        </tr>
        <tr style="border:none !important">
            <td style = "border:none !important; border-bottom: 1px solid !important" class = "text-center" width="25%"> </td>
            <td style = "border:none !important;" class = "text-center" width="13%"> </td>
            <td style = "border:none !important; border-bottom: 1px solid !important" class = "text-center" width="25%"> </td>
            <td style = "border:none !important;" class = "text-center" width="13%"> </td>
            <td style = "border:none !important; border-bottom: 1px solid !important" class = "text-center" width="25%"> </td>
        </tr>
    </table>
    <?php
} else {
    echo "<div class='text-center'><h2>Tidak Ada Data</h2></div>";
}
?>