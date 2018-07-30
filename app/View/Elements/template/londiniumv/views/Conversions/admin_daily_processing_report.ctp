<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/daily_processing_report");
?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("LAPORAN PENGOLAHAN IKAN HARIAN") ?>
                    <div class="pull-right">
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("daily_processing_report/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-print2"></i> 
                            <?= __("Cetak") ?>
                        </button>&nbsp;
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("daily_processing_report/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-file-excel"></i>
                            Excel
                        </button>&nbsp;
                    </div>
                    <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                </h6>
            </div>
            <div>
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Preview Laporan Pengolahan Ikan Harian") ?></h6>
                </div>
                <table class="table-bordered table stn-table" style="width:100%"> 
                    <tr style="text-align:center;">
                        <th width="200px">Size/Process</th>
                        <th width="50px">No</th>
                        <th width="50px">1</th>
                        <th width="50px">2</th>
                        <th width="50px">3</th>
                        <th width="50px">4</th>
                        <th width="50px">5</th>
                        <th width="50px">6</th>
                        <th width="50px">7</th>
                        <th width="50px">8</th>
                        <th width="50px">9</th>
                        <th width="50px">10</th>
                        <th width="50px">11</th>
                        <th width="50px">12</th>
                        <th width="50px">13</th>
                        <th width="100px">Total</th>
                    </tr>
                    <?php if (empty($data['rows'])) {
                        ?>
                        <tr>
                            <td class = "text-center" colspan ="16">Tidak Ada Data</td>
                        </tr>
                        <?php
                    } else {
                        ?>
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
                                    <td><?php
                                        if ((($i + 0) % 13) < count($pieces)) {
                                            $weight = $pieces[(($i + 0) % 13)];
                                            echo $weight;
                                        };
                                        ?></td>  <!--1 -->
                                    <td><?php
                                        if ((($i + 1) % 13) < count($pieces)) {
                                            $weight = $pieces[(($i + 1) % 13)];
                                            echo $weight;
                                        };
                                        ?></td>  <!--2 -->
                                    <td><?php
                                        if ((($i + 2) % 13) < count($pieces)) {
                                            $weight = $pieces[(($i + 2) % 13)];
                                            echo $weight;
                                        };
                                        ?></td>  <!--3 -->
                                    <td><?php
                                        if ((($i + 3) % 13) < count($pieces)) {
                                            $weight = $pieces[(($i + 3) % 13)];
                                            echo $weight;
                                        };
                                        ?></td>  <!--4 -->
                                    <td><?php
                                        if ((($i + 4) % 13) < count($pieces)) {
                                            $weight = $pieces[(($i + 4) % 13)];
                                            echo $weight;
                                        };
                                        ?></td>  <!--5 -->
                                    <td><?php
                                        if ((($i + 5) % 13) < count($pieces)) {
                                            $weight = $pieces[(($i + 5) % 13)];
                                            echo $weight;
                                        };
                                        ?></td>  <!--6 -->
                                    <td><?php
                                        if ((($i + 6) % 13) < count($pieces)) {
                                            $weight = $pieces[(($i + 6) % 13)];
                                            echo $weight;
                                        };
                                        ?></td>  <!--7 -->
                                    <td><?php
                                        if ((($i + 7) % 13) < count($pieces)) {
                                            $weight = $pieces[(($i + 7) % 13)];
                                            echo $weight;
                                        };
                                        ?></td>  <!--8 -->
                                    <td><?php
                                        if ((($i + 8) % 13) < count($pieces)) {
                                            $weight = $pieces[(($i + 8) % 13)];
                                            echo $weight;
                                        };
                                        ?></td>  <!--9 -->
                                    <td><?php
                                        if ((($i + 9) % 13) < count($pieces)) {
                                            $weight = $pieces[(($i + 9) % 13)];
                                            echo $weight;
                                        };
                                        ?></td>  <!--10 -->
                                    <td><?php
                                        if ((($i + 10) % 13) < count($pieces)) {
                                            $weight = $pieces[(($i + 10) % 13)];
                                            echo $weight;
                                        };
                                        ?></td>  <!--11 -->
                                    <td><?php
                                        if ((($i + 11) % 13) < count($pieces)) {
                                            $weight = $pieces[(($i + 11) % 13)];
                                            echo $weight;
                                        };
                                        ?></td>  <!--12 -->
                                    <td><?php
                                        if ((($i + 12) % 13) < count($pieces)) {
                                            $weight = $pieces[(($i + 12) % 13)];
                                            echo $weight;
                                        };
                                        ?></td>  <!--13 -->
                                    <?php
                                    $no++;
                                }
                                ?>
                                <td><?= $conversion['total'] ?></td>  
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>    
    </div>
</div>