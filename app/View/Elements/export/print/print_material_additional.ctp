<?php
if (!empty($data['rows'])) {
    ?>
    <br/>
    <center>
        <h3><?= $data['title'] ?></h3>
    </center>
    <div class = "panel panel-default">
        <div class = "panel-body">
            <div class = "table-responsive pre-scrollable stn-table">
                <table width="100%">
                    <tr>
                        <td> HARI/TGL : <?= $this->Html->cvtHari($data['rows']['MaterialAdditionalPerContainer']['created']) . ", " . $this->Html->cvtTanggal($data['rows']['MaterialAdditionalPerContainer']['created']) ?> </td>
                        <td width = "50px"> </td>
                        <td> Nomor PO : <?= $data['rows']['Sale']['sale_no'] ?> </td>
                    </tr>
                </table>
                <table width="100%">
                    <tr>
                        <th class = "text-center" colspan = "2" style = "border: 1px solid"> Jumlah </th>
                        <th class = "text-center" colspan = "2" style = "border: 1px solid"> Harga Master </th>
                        <th class = "text-center" colspan = "2" style = "border: 1px solid"> Biaya </th>
                        <th class = "text-center" colspan = "2" style = "border: 1px solid"> Jumlah </th>
                        <th class = "text-center" style = "border: 1px solid"> Ukuran </th>
                        <th class = "text-center" colspan = "2" style = "border: 1px solid"> Harga Plastik </th>
                        <th class = "text-center" colspan = "2" style = "border: 1px solid"> Biaya </th>
                    </tr>
                    <?php
                    $biayaMC = 0;
                    $biayaPlastic = 0;
                    $totalBiayaMC = 0;
                    $totalBiayaPlastic = 0;
                    $grandTotal = 0;
                    foreach ($data['rows']['MaterialAdditionalPerContainerDetail'] as $item) {
                        ?>
                        <tr>
                            <?php
                            if (empty($item['quantity_mc'])) {
                                ?>
                                <td class = "text-center" style = "border: 1px solid; border-right: none !important"> - </td>
                                <?php
                            } else {
                                ?>
                                <td class = "text-center" style = "border: 1px solid; border-right: none !important" width = "30px"> <?= $this->Html->berat($item['quantity_mc']) ?></td>
                                <?php
                            }
                            ?>
                            <?php
                            if (empty($item['MaterialAdditionalMc']['MaterialAdditionalUnit']['uniq'])) {
                                ?>
                                <td class = "text-center" style = "border: 1px solid; border-left: none !important"> - </td>
                                <?php
                            } else {
                                ?>
                                <td class = "text-center" style = "border: 1px solid; border-left: none !important" width = "30px"> <?= $item['MaterialAdditionalMc']['MaterialAdditionalUnit']['uniq'] ?></td>
                                <?php
                            }
                            ?>
                            <?php
                            if (empty($item['MaterialAdditionalMc']['price'])) {
                                ?>
                                <td class = "text-center" style = "border: 1px solid"> - </td>
                                <?php
                            } else {
                                ?>
                                <td class = "text-right" style = "border: 1px solid"> <?= $this->Echo->empty_strip($this->Html->berat($item['MaterialAdditionalMc']['price'])) ?></td>
                                <?php
                                $biayaMC += $item['MaterialAdditionalMc']['price'] * $item['quantity_mc'];
                                $totalBiayaMC += $biayaMC;
                            }
                            ?>
                            <?php
                            if (empty($item['MaterialAdditionalMc']['name'])) {
                                ?>
                                <td class = "text-center" style = "border: 1px solid"> - </td>
                                <?php
                            } else {
                                ?>
                                <td class = "text-left" style = "border: 1px solid"> <?= $this->Echo->empty_strip($item['MaterialAdditionalMc']['name']) ?></td>
                                <?php
                            }
                            ?>
                            <td class = "text-center" style = "border: 1px solid; border-right: none !important"> Rp. </td>
                            <?php
                            if (empty($item['MaterialAdditionalMc']['price']) && empty($item['quantity_mc'])) {
                                ?>
                                <td class = "text-center" style = "border: 1px solid; border-left: none !important"> - </td>
                                <?php
                            } else {
                                ?>
                                <td class = "text-right" style = "border: 1px solid; border-left: none !important"> <?= $this->Html->berat($biayaMC) ?></td>
                                <?php
                            }
                            ?>
                            <?php
                            if (empty($item['quantity_plastic'])) {
                                ?>
                                <td class = "text-center" style = "border: 1px solid; border-right: none !important"> - </td>
                                <?php
                            } else {
                                ?>
                                <td class = "text-center" style = "border: 1px solid;  border-right: none !important"> <?= $this->Html->berat($item['quantity_plastic']) ?></td>
                                <?php
                            }
                            ?>
                            <?php
                            if (empty($item['MaterialAdditionalPlastic']['MaterialAdditionalUnit']['uniq'])) {
                                ?>
                                <td class = "text-center" style = "border: 1px solid; border-left: none !important"> - </td>
                                <?php
                            } else {
                                ?>
                                <td class = "text-center" style = "border: 1px solid; border-left: none !important" width = "30px"> <?= $item['MaterialAdditionalPlastic']['MaterialAdditionalUnit']['uniq'] ?></td>
                                <?php
                            }
                            ?>
                            <?php
                            if (empty($item['MaterialAdditionalPlastic']['size'])) {
                                ?>
                                <td class = "text-center" style = "border: 1px solid"> - </td>
                                <?php
                            } else {
                                ?>
                                <td class = "text-right" style = "border: 1px solid"> <?= $this->Echo->empty_strip($item['MaterialAdditionalPlastic']['size']) ?></td>
                                <?php
                            }
                            ?>
                            <?php
                            if (empty($item['MaterialAdditionalPlastic']['name'])) {
                                ?>
                                <td class = "text-center" style = "border: 1px solid"> - </td>
                                <?php
                            } else {
                                ?>
                                <td class = "text-right" style = "border: 1px solid"> <?= $this->Echo->empty_strip($item['MaterialAdditionalPlastic']['name']) ?></td>
                                <?php
                            }
                            ?>
                            <?php
                            if (empty($item['MaterialAdditionalPlastic']['price'])) {
                                ?>
                                <td class = "text-center" style = "border: 1px solid"> - </td>
                                <?php
                            } else {
                                ?>
                                <td class = "text-right" style = "border: 1px solid"> <?= $this->Echo->empty_strip($this->Html->berat($item['MaterialAdditionalPlastic']['price'])) ?></td>
                                <?php
                                $biayaPlastic += $item['MaterialAdditionalPlastic']['price'] * $item['quantity_plastic'];
                                $totalBiayaPlastic += $biayaPlastic;
                            }
                            ?>
                            <td class = "text-center" style = "border: 1px solid; border-right: none !important"> Rp. </td>
                            <?php
                            if (empty($item['MaterialAdditionalPlastic']['price']) && empty($item['quantity_plastic'])) {
                                ?>
                                <td class = "text-center" style = "border: 1px solid; border-left: none !important"> - </td>
                                <?php
                            } else {
                                ?>
                                <td class = "text-right" style = "border: 1px solid; border-left: none !important"> <?= $this->Html->berat($biayaPlastic) ?></td>
                                <?php
                            }
                            ?>
                        </tr>
                        <?php
                        $grandTotal = $totalBiayaPlastic + $totalBiayaMC;
                    }
                    ?>
                    <tr height = "30px"> </tr>
                    <tr>
                        <td colspan = "4"> JUMLAH BIAYA MASTER </td>
                        <td class = "text-center"> Rp. </td>
                        <td class = "text-right" style = "border-bottom-style: double"> <?= $this->Html->berat($totalBiayaMC); ?> </td>
                        <td class = "text-center">  </td>
                        <td class = "text-center">  </td>
                        <td colspan = "3"> JUMLAH BIAYA P. VACUM </td>
                        <td class = "text-center"> Rp. </td>
                        <td class = "text-right" style = "border-bottom-style: double"> <?= $this->Html->berat($totalBiayaPlastic); ?>  </td>
                    </tr>
                    <tr height = "50px"> </tr>
                    <tr>
                        <td colspan = "4"> TOTAL BIAYA KEMASAN </td>
                        <td class = "text-center"> Rp. </td>
                        <td class = "text-right" style = "border-bottom-style: double"> <?= $this->Html->berat($grandTotal); ?>  </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php
}
?>