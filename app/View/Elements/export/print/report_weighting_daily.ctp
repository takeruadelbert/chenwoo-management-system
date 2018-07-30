<?php
if (!empty($data['rows'])) {
    ?>
    <style>
        .table-bordered,tr,td{
            border:1px solid black;
            border-collapse: collapse;
        }
    </style>
    <div style="text-align:center;margin-bottom:5px;">
        <div>MATERIAL SOURCE FORM OF WEIGHTING</div>
    </div>
    <table class="aaa" style="border:0px;width:100%;">
        <tr style="border:0px solid black;">   
            <td style="border:0px;">
                <div style="float:left;width:550px;">
                    <div><span style="width:120px;display:inline-block;">DAY & DATE</span><span>: <?php echo $this->Html->cvtTanggal($data['rows'][0]['MaterialEntry']['weight_date']) ?></span></div>
                    <div><span style="width:120px;display:inline-block;">PROCESSING</span><span>: </span></div>
                </div>
            </td>
        <tr> 
    </table>
    <div style="clear: both;"></div>
    <table class="table-bordered" style="margin-top:10px;width:100%;"> 
        <tr style="text-align:center;">
            <td width="20">NO</td>
            <td width="200">NAMA</td>
            <td colspan="10">Pembobotan (Kg)</td>
            <td width="100">Total (Kg)</td>
        </tr>
        <?php if (empty($data['rows'])) {
            ?>
            <tr>
                <td class = "text-center" colspan ="13">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            ?>
            <?php
            $number = 1;
            $fishList = array();
            $i = 0;
            foreach ($data['rows']as $transaction) {
                foreach ($transaction['MaterialEntryGrade'] as $materials) {
                    foreach ($materials['MaterialEntryGradeDetail'] as $k => $details) {
                        if ($k == 0) {
                            array_push($fishList, ['label' => $materials['MaterialDetail']['Material']['name'] . " " . $materials['MaterialDetail']['name'], 'weighting' => $details['weight'], 'total' => $details['weight'], "id" => $transaction['MaterialEntry']['id']]);
                        } else {
                            $total = (float) $fishList[$i]['total'] + (float) $details['weight'];
                            $temp = $fishList[$i]['weighting'];
                            $fishList[$i]['weighting'] = $temp . ", " . $details['weight'];
                            $fishList[$i]['total'] = $total;
                        }
                    }
                    $i++;
                }
            }
            foreach ($fishList as $item) {
                $arrayWeightPrint = explode(',', $item['weighting']);
                $statusMerge = false;
                for ($i = 0; $i < count($arrayWeightPrint); $i = $i + 10) {
                    ?>    
                    <!--Set List-->
                    <tr>
                        <?php
                        if ($statusMerge == false) {
                            ?>
                            <td><?= $number ?></td>
                            <td><?= $item['label'] ?></td>
                            <?php
                        } else {
                            ?>
                            <td></td>
                            <td></td>
                            <?php
                        }
                        ?>
                        <td width="5%"><?php
                            if ((($i + 0) % 10) < count($arrayWeightPrint)) {
                                $weight = $arrayWeightPrint[(($i + 0) % 10)];
                                echo $weight;
                            };
                            ?></td>
                        <td width="5%"><?php
                            if ((($i + 1) % 10) < count($arrayWeightPrint)) {
                                $weight = $arrayWeightPrint[(($i + 1) % 10)];
                                echo $weight;
                            };
                            ?></td>
                        <td width="5%"><?php
                            if ((($i + 2) % 10) < count($arrayWeightPrint)) {
                                $weight = $arrayWeightPrint[(($i + 2) % 10)];
                                echo $weight;
                            };
                            ?></td>
                        <td width="5%"><?php
                            if ((($i + 3) % 10) < count($arrayWeightPrint)) {
                                $weight = $arrayWeightPrint[(($i + 3) % 10)];
                                echo $weight;
                            };
                            ?></td>
                        <td width="5%"><?php
                            if ((($i + 4) % 10) < count($arrayWeightPrint)) {
                                $weight = $arrayWeightPrint[(($i + 4) % 10)];
                                echo $weight;
                            };
                            ?></td>
                        <td width="5%"><?php
                            if ((($i + 5) % 10) < count($arrayWeightPrint)) {
                                $weight = $arrayWeightPrint[(($i + 5) % 10)];
                                echo $weight;
                            };
                            ?></td>
                        <td width="5%"><?php
                            if ((($i + 6) % 10) < count($arrayWeightPrint)) {
                                $weight = $arrayWeightPrint[(($i + 6) % 10)];
                                echo $weight;
                            };
                            ?></td>
                        <td width="5%"><?php
                            if ((($i + 7) % 10) < count($arrayWeightPrint)) {
                                $weight = $arrayWeightPrint[(($i + 7) % 10)];
                                echo $weight;
                            };
                            ?></td>
                        <td width="5%"><?php
                            if ((($i + 8) % 10) < count($arrayWeightPrint)) {
                                $weight = $arrayWeightPrint[(($i + 8) % 10)];
                                echo $weight;
                            };
                            ?></td>
                        <td width="5%"><?php
                            if ((($i + 9) % 10) < count($arrayWeightPrint)) {
                                $weight = $arrayWeightPrint[(($i + 9) % 10)];
                                echo $weight;
                            };
                            ?></td>
                        <?php
                        if ($statusMerge == false) {
                            ?>
                            <td class="text-center"><?= $item['total'] ?></td>
                            <?php
                        } else {
                            ?>
                            <td></td>
                            <?php
                        }
                        ?>                   
                    </tr>

                    <?php
                    $statusMerge = True;
                }

                $number++;
            }
            ?>
            <tr style="border: 1px solid black;height:50px;padding:3px;">
                <td colspan="2" style="border:0px solid black;">
                </td>
                <td colspan="3" class="text-center" style="border:0px solid black;vertical-align:initial;">
                    Prepared By
                </td>
                <td colspan="4" class="text-center" style="border:0px solid black;vertical-align:initial;">
                    Checked By
                </td>
                <td colspan="4" class="text-center" style="border:0px solid black;vertical-align:initial;">
                    Approved By
                </td>
            </tr>
        </table>
        <?php
    }
}
?>