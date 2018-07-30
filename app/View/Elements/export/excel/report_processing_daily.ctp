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
        <div>DAILY FISH PROCESSING REPORT <br> <?= !empty($dataBranchOffice) ? "CABANG " . $dataBranchOffice['BranchOffice'] : "SELURUH CABANG" ?></div>
    </div>
    <br>
    <div style="display:inline-block;width:100%;float:left">
        <table class="aaa" style="border:0px;width:100%;">
            <tr>   
                <td style="border:0px;width:50%;">
                    <div style="float:left;">                    
                        <div><span style="width:150px;display:inline-block;">PROCESSING</span><span></span></div>
                        <div><span style="width:150px;display:inline-block;">DAY & DATE</span><span>: <?php echo $this->Html->cvtTanggal($data['rows'][0]['Conversion']['created']) ?></span></div>
                        <div><span style="width:150px;display:inline-block;">FISH</span><span>: </span></div>
                        <div><span style="width:150px;display:inline-block;">Total Material Input</span><span>: </span></div>
                        <div><span style="width:150px;display:inline-block;">Total Material Output</span><span>: </span></div>
                    </div>
                </td>
                <td style="border:0px;vertical-align:0px;width:50%;">
                    <div style="float:right;top:0px;">
                        <span style="display:inline-block;">WGS</span><span style="width:30px;display:inline-block;border:2px solid black;height:15px;margin:auto 15px -3px 3px;"></span>
                        <span style="display:inline-block;">WGGS</span><span style="width:30px;display:inline-block;border:2px solid black;height:15px;margin:auto 15px -3px 3px;"></span>
                        <span style="display:inline-block;">SO</span><span style="width:30px;display:inline-block;border:2px solid black;height:15px;margin:auto 15px -3px 3px;"></span>
                        <span style="display:inline-block;">SL</span><span style="width:30px;display:inline-block;border:2px solid black;height:15px;margin:auto 15px -3px 3px;"></span>
                    </div>
                </td>
            <tr> 
        </table>
        <div style="clear: both;"></div>
        <table class="table-bordered" style="margin-top:1px;width:100%"> 
            <tr style="text-align:center;">
                <td width="200px">Size/Process</td>
                <td width="50px">No</td>
                <td width="50px">1</td>
                <td width="50px">2</td>
                <td width="50px">3</td>
                <td width="50px">4</td>
                <td width="50px">5</td>
                <td width="50px">6</td>
                <td width="50px">7</td>
                <td width="50px">8</td>
                <td width="50px">9</td>
                <td width="50px">10</td>
                <td width="50px">11</td>
                <td width="50px">12</td>
                <td width="50px">13</td>
                <td width="100px">Total</td>

            </tr>
            <?php
            $number = 1;
            $arrayConversion = array();
            foreach ($data['rows']as $conversion) {
                ?>        
                <?php
                foreach ($conversion['ConversionData'] as $entry) {
                    if (count($arrayConversion) == 0) {
                        array_push($arrayConversion, ['name' => $entry['MaterialDetail']['Material']['name'] . " " . $entry['MaterialDetail']['name'], 'weight' => $entry['material_size_quantity'], 'total' => $entry['material_size_quantity']]);
                    } else {
                        for ($i = 0; $i < count($arrayConversion); $i++) {
                            if ($entry['MaterialDetail']['Material']['name'] . " " . $entry['MaterialDetail']['name'] == $arrayConversion[$i]['name']) {
                                $total = $arrayConversion[$i]['total'] + $entry['material_size_quantity'];
                                $arrayConversion[$i]['total'] = $total;
                                $arrayConversion[$i]['weight'] = $arrayConversion[$i]['weight'] . "," . $entry['material_size_quantity'];
                            } else if ($i == count($arrayConversion) - 1) {
                                array_push($arrayConversion, ['name' => $entry['MaterialDetail']['Material']['name'] . " " . $entry['MaterialDetail']['name'], 'weight' => $entry['material_size_quantity'], 'total' => $entry['material_size_quantity']]);
                            }
                        }
                    }
                }
            }
            foreach ($arrayConversion as $conversion) {
                ?>
                <tr style="text-align:center;">
                    <td  style="text-align:left;"><?= $conversion['name'] ?></td>
                    <!-- split weight -->
                    <?php
                    $no = 1;
                    $pieces = explode(",", $conversion['weight']);
                    for ($i = 0; $i < count($pieces); $i = $i + 13) {
                        ?>
                        <td><?= $no ?></td>
                        <td><?php if ((($i + 0) % 13) < count($pieces)) {
                $weight = $pieces[(($i + 0) % 13)];
                echo $weight;
            }; ?></td>  <!--1 -->
                        <td><?php if ((($i + 1) % 13) < count($pieces)) {
                $weight = $pieces[(($i + 1) % 13)];
                echo $weight;
            }; ?></td>  <!--2 -->
                        <td><?php if ((($i + 2) % 13) < count($pieces)) {
                $weight = $pieces[(($i + 2) % 13)];
                echo $weight;
            }; ?></td>  <!--3 -->
                        <td><?php if ((($i + 3) % 13) < count($pieces)) {
                $weight = $pieces[(($i + 3) % 13)];
                echo $weight;
            }; ?></td>  <!--4 -->
                        <td><?php if ((($i + 4) % 13) < count($pieces)) {
                $weight = $pieces[(($i + 4) % 13)];
                echo $weight;
            }; ?></td>  <!--5 -->
                        <td><?php if ((($i + 5) % 13) < count($pieces)) {
                $weight = $pieces[(($i + 5) % 13)];
                echo $weight;
            }; ?></td>  <!--6 -->
                        <td><?php if ((($i + 6) % 13) < count($pieces)) {
                $weight = $pieces[(($i + 6) % 13)];
                echo $weight;
            }; ?></td>  <!--7 -->
                        <td><?php if ((($i + 7) % 13) < count($pieces)) {
                $weight = $pieces[(($i + 7) % 13)];
                echo $weight;
            }; ?></td>  <!--8 -->
                        <td><?php if ((($i + 8) % 13) < count($pieces)) {
                $weight = $pieces[(($i + 8) % 13)];
                echo $weight;
            }; ?></td>  <!--9 -->
                        <td><?php if ((($i + 9) % 13) < count($pieces)) {
                $weight = $pieces[(($i + 9) % 13)];
                echo $weight;
            }; ?></td>  <!--10 -->
                        <td><?php if ((($i + 10) % 13) < count($pieces)) {
                $weight = $pieces[(($i + 10) % 13)];
                echo $weight;
            }; ?></td>  <!--11 -->
                        <td><?php if ((($i + 11) % 13) < count($pieces)) {
                $weight = $pieces[(($i + 11) % 13)];
                echo $weight;
            }; ?></td>  <!--12 -->
                        <td><?php if ((($i + 12) % 13) < count($pieces)) {
                $weight = $pieces[(($i + 12) % 13)];
                echo $weight;
            }; ?></td>  <!--13 -->
            <?php
            $no++;
        }
        ?>
                    <td><?= $conversion['total'] ?></td>  
                </tr>
        <?php
    }
    ?>
        </table>
    </div>
    <?php
} else {
    echo "<div class='text-center'><h2>Tidak Ada Data</h2></div>";
}
?>

<!--    <div style="display:inline-block;width:50%">
        <table class="aaa" style="border:0px;width:100%;">
            <tr>   
                <td style="border:0px;">
                    <div style="float:left;width:200px;">                    
                        <div><span style="width:150px;display:inline-block;">PROCESSING</span><span>:</span></div>
                        <div><span style="width:150px;display:inline-block;">DAY & DATE</span><span>: <?php echo $this->Html->cvtTanggalWaktu($data['rows'][0]['Conversion']['created']) ?></span></div>
                        <div><span style="width:150px;display:inline-block;">FISH</span><span>: </span></div>
                        <div><span style="width:150px;display:inline-block;">Total Material Input</span><span>: </span></div>
                        <div><span style="width:150px;display:inline-block;">Total Material Output</span><span>: </span></div>
                    </div>
                </td>
                <td style="border:0px;vertical-align:0px;">
                    <div style="float:right;top:0px;">
                        <span style="display:inline-block;">WGS</span><span style="width:30px;display:inline-block;border:2px solid black;height:15px;margin:auto 15px -3px 3px;"></span>
                        <span style="display:inline-block;">WGGS</span><span style="width:30px;display:inline-block;border:2px solid black;height:15px;margin:auto 15px -3px 3px;"></span>
                        <span style="display:inline-block;">SO</span><span style="width:30px;display:inline-block;border:2px solid black;height:15px;margin:auto 15px -3px 3px;"></span>
                        <span style="display:inline-block;">SL</span><span style="width:30px;display:inline-block;border:2px solid black;height:15px;margin:auto 15px -3px 3px;"></span>
                    </div>
                </td>
            <tr> 
        </table>
        <div style="clear: both;"></div>
        <table class="table-bordered" style="margin-top:1px;width:100%"> 
            <tr style="text-align:center;">
                <td width="200px">Size/Process</td>
                <td width="150px">No</td>
                <td width="50px">1</td>
                <td width="50px">2</td>
                <td width="50px">3</td>
                <td width="50px">4</td>
                <td width="50px">5</td>
                <td width="50px">6</td>
                <td width="50px">7</td>
                <td width="50px">8</td>
                <td width="50px">9</td>
                <td width="50px">10</td>
                <td width="50px">11</td>
                <td width="50px">12</td>
                <td width="50px">13</td>
                <td width="100px">Total</td>

            </tr>

        </table>
    </div>
    <table style="width:100%;margin-top:10px">
        <tr style="">
            <td style="border:0px;text-align:center;">Prepared By</td>
            <td style="border:0px;text-align:center;">Checked By</td>
            <td style="border:0px;text-align:center;">Approved By</td>
        </tr>
    </table>-->