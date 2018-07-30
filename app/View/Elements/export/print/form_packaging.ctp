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
    <table width = "100%" style="border:none !important">
        <tr style="border:none !important">
            <td width = "25%" class = "text-left" style="border:none !important">
                <?php
                $entity = ClassRegistry::init("EntityConfiguration")->find("first");
                ?>
                <img src="<?= Router::url($entity['EntityConfiguration']['logo1'], true) ?>" height="60px"/>
            </td>
            <td width = "50%" class = "text-center" style="border: 1px solid;">
                <h3 valign = "middle" style = "padding-top : 15px;"><?= $data['title'] ?> <br> <?= !empty($dataBranchOffice) ? "CABANG " . $dataBranchOffice['BranchOffice']['name'] : "SELURUH CABANG" ?></h3>
            </td>
            <td width = "25%" class="text-right" style="border:none !important; font-size: 10px;">
                Dok.No. : FRM.PRO.01.11, Rev.00
            </td>
        </tr>
    </table>
    <table style="border:none !important; margin-top: 10px;">
        <tr style="border:none !important" width = "150px">
            <td style = "border:none !important;">
                Product Size 
            </td> 
            <td style = "border:none !important;" width = "10px">
                : 
            </td> 
            <td style = "border:none !important; border-bottom: 1px solid !important" width = "200px">
            </td> 
            <td style = "border:none !important;">
            </td> 
        </tr>
    </table>
    <table class="table-bordered" style="margin-top:10px;" width = "100%"> 
        <tr style="text-align:center;">
            <th width="150px" rowspan="2">Date</th>
            <th width="50px" rowspan="2">No MC</th>
            <th width="150px" rowspan="2">NW</th>
            <th width="150px" rowspan="2">CODE</th>
            <th width="80px" rowspan="2">PCS</th>
            <th width="200px" colspan="3">PMC</th>
        </tr>
        <tr style="text-align:center;">
            <th>PL</th>
            <th>Inner</th>
            <th>MC</th>
        </tr>
        <?php
        $total = 0;
        $quantity = 0;
        $number = 1;
        $fishList = array();
        foreach ($data['rows']as $package) {
            //foreach ($package['PackageDetail'] as $product) {
            ?>    
            <!--Set List-->
            <tr>
                <td class = "text-center"><?= $this->Html->cvtTanggal($package['PackageDetail']['created']) ?></td>
                <td class = "text-center"><?= $number ?></td>
                <td class = "text-center"><?= $package['PackageDetail']['nett_weight'] ?></td>
                <td class = "text-center"><?= $package['Product']['code'] ?></td>
                <td class = "text-center"><?= $package['PackageDetail']['quantity_per_pack'] ?></td>
                <td class = "text-center"></td>
                <td class = "text-center"></td>
                <td class = "text-center"></td>
            </tr> 
            <?php
            $total += $package['PackageDetail']['nett_weight'];
            $quantity += $package['PackageDetail']['quantity_per_pack'];
            $number++;
            //}
        }
        ?>    
        <tr>
            <td class = "text-center"><b>Total</b></td>
            <td class = "text-center"></td>
            <td class = "text-center"><?= $total ?></td>
            <td class = "text-center"></td>
            <td class = "text-center"><?= $quantity ?></td>
            <td class = "text-center" style = "border-right:none !important;"></td>
            <td class = "text-center" style = "border-left:none !important;border-right:none !important;"></td>
            <td class = "text-center" style = "border-left:none !important;border-right:none !important;"></td>
        </tr> 
    </table>
    <div>
        <p> Note : <br> PMC = Packaging Material Code </p>
    </div>
    <?php
    //$number++;
    //}
}
?>