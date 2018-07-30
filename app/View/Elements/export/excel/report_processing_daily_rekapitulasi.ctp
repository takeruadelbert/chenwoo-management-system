<?php
$dataBranchOffice = ClassRegistry::init("BranchOffice")->find("first", [
    "conditions" => [
        "BranchOffice.id" => $this->request->query['select_Conversion_branch_office_id']
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
    <div style="text-align:center">
        <div>REKAPITULATION OF DAILY FISH PROCESSING REPORT <br> <?= !empty($dataBranchOffice) ? "CABANG " . strtoupper($dataBranchOffice['BranchOffice']['name']) : "SELURUH CABANG" ?></div>
    </div>
    <table class="aaa" style="border:0px;width:100%;">
        <tr>   
            <td style="border:0px;">
                <div style="float:left;width:550px;">
                    <div><span style="width:120px;display:inline-block;">DAY & DATE</span><span>: <?php echo $this->Html->cvtTanggal($data['rows'][0]['Conversion']['created']) ?></span></div>
                    <div><span style="width:120px;display:inline-block;">PROCESSING</span><span>:</span></div>
                </div>
            </td>
            <td style="border:0px;">
                <div style="float:right;padding-top:20px;">
                    <span style="display:inline-block;">WM</span><span style="width:50px;display:inline-block;border:2px solid black;height:15px;margin:auto 30px -3px 3px;"></span>
                    <span style="display:inline-block;">BF</span><span style="width:50px;display:inline-block;border:2px solid black;height:15px;margin:auto 30px -3px 3px;"></span>
                    <span style="display:inline-block;">TFT</span><span style="width:50px;display:inline-block;border:2px solid black;height:15px;margin:auto 30px -3px 3px;"></span>
                </div>
            </td>
        <tr> 
    </table>
    <div style="clear: both;"></div>
    <table class="table-bordered" style="margin-top:1px;width:100%"> 
        <tr style="text-align:center;">
            <td width="30px"></td>
            <td width="350px" colspan="2">Material Source</td>
            <td width="420px" colspan="3">Material Result</td>
            <td width="150px" colspan="3">Percent</td>
            <td width="80px"></td>
        </tr>
        <tr style="text-align:center;">
            <td width="30px">No</td>
            <td width="200px">Name Of Fish</td>
            <td width="150px">Measurement /KG</td>
            <td width="200px">Name Of Fish</td>
            <td width="150px">Measurement /KG</td>
            <td width="80px">Broken</td>
            <td width="80px">Result</td>
            <td width="80px">Range</td>
            <td width="80px">Variance</td>
            <td width="150px">Description</td>

        </tr>
        <?php
        $number = 1;
        foreach ($data['rows']as $conversion) {
            $sourceList = array();
            $resultList = array();
            foreach ($conversion['MaterialEntry']['MaterialEntryGrade'] as $source) {
                array_push($sourceList, ['label' => $source['MaterialDetail']['Material']['name'] . " - " . $source['MaterialDetail']['name'], 'weight' => $source['weight']]);
            }
            foreach ($conversion['ConversionData'] as $result) {
                array_push($resultList, ['label' => $result['MaterialDetail']['Material']['name'] . " - " . $result['MaterialDetail']['name'], 'weight' => $result['material_size_quantity']]);
            }
            ?>

            <?php
            $count = 0;
            $countSource = count($sourceList);
            $countResult = count($resultList);
            if ($countSource > $countResult) {
                $count = $countSource;
            } else {
                $count = $countResult;
            }
            for ($i = 0; $i < $count; $i++) {
                ?>    
                <tr>
                    <?php
                    if ($i == 0) {
                        ?>
                        <td><?= $number ?></td>
                        <?php
                    } else {
                        ?>
                        <td></td>
                        <?php
                    }
                    ?>
                    <!--Set List Surce-->
                    <?php
                    if ($i < $countSource) {
                        ?>
                        <td><?= $sourceList[$i]['label'] ?></td>
                        <td><?= $sourceList[$i]['weight'] ?></td>
                        <?php
                    } else {
                        ?>
                        <td></td>
                        <td></td>
                        <?php
                    }
                    ?>
                    <!--Set List Result-->
                    <?php
                    if ($i < $countResult) {
                        ?>
                        <td><?= $resultList[$i]['label'] ?></td>
                        <td><?= $resultList[$i]['weight'] ?></td>
                        <?php
                    } else {
                        ?>
                        <td></td>
                        <td></td>
                        <?php
                    }
                    ?>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> 
                <?php
            }
            ?>


            <?php
            $number++;
        }
    } else {
        echo "<div class='text-center'><h2>Tidak Ada Data</h2></div>";
    }
    ?>
</table>
<table style="width:100%;margin-top:10px;">
    <tr style="border:none;">
        <td style="border:0px;text-align:center;"></td>
        <td style="border:0px;text-align:center;">Prepared By</td>
        <td style="border:0px;text-align:center;"></td>
        <td style="border:0px;text-align:center;">Checked By</td>
        <td style="border:0px;text-align:center;"></td>
        <td style="border:0px;text-align:center;" colspan = "4">Approved By</td>
        <td style="border:0px;text-align:center;"></td>
    </tr>
</table>