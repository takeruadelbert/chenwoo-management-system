<?php
$kurs = str_replace(".", "", $data['kurs']);
if (!empty($data['rows'])) {
    ?>
    <style>
        .table-bordered,tr,td,th{
            border:1px solid black;
            border-collapse: collapse;
        }
    </style>
    <div><b>PT. CHENWOO FISHERY MAKASSAR</b></div>
    <div><b><?php echo $data['title'] ?></b></div>
    <div><b>Bulan: <?= $this->Html->getNamaBulan($data['month']) . " " . $data['year'] ?></b></div>
    <div><b>Kurs: <?= $this->Html->IDR($kurs) ?></b></div>
    <table class="table-bordered" width = "100%" style = "font-size:12px; "> 
        <tr style="text-align:center;">
            <th rowspan="2" width="30px">NO</th>
            <th rowspan="2" width="200px">NAMA IKAN</th>
            <th colspan="2" width="180px">
                BULAN LALU </br> Januari
                <?php
                if ($data['month'] != 1) {
                    echo "s/d " . $this->Html->getNamaBulan($data['month'] - 1) . " " . $data['year'];
                }
                ?>
            </th>
            <th rowspan="2" width="80px">HARGA </br> RATA-RATA</th>
            <th colspan="2" width="160px" style="color:blue">BULAN INI </br> <?= $this->Html->getNamaBulan($data['month']) . " " . $data['year'] ?></th>
            <th rowspan="2" width="80px" style="color:blue">HARGA </br> RATA-RATA</th>
            <th colspan="2" width="160px">S/D BULAN INI </br> Januari
                <?php
                if ($data['month'] != 1) {
                    echo "s/d " . $this->Html->getNamaBulan($data['month']) . " " . $data['year'];
                }
                ?>
            </th>
            <th rowspan="2" width="80px">HARGA </br> RATA-RATA</th>
        </tr>
        <tr style="text-align:center;">
            <th>Kg</th>
            <th>Rp.</th>
            <th style="color:blue">Kg</th>
            <th style="color:blue">Rp.</th>
            <th>Kg</th>
            <th>Rp.</th>
        </tr>
        <?php
        $number = 1;
        $month = $data['month'];
        $total_price_month_before = 0;
        $total_price_month_now = 0;
        $total_price_month_all = 0;
        $total_weight_month_before = 0;
        $total_weight_month_now = 0;
        $total_weight_month_all = 0;
        $total_before = 0;
        $total_now = 0;
        $total_all = 0;
        //foreach ($data['material_categories'] as $material_categories) {
        //foreach($items['TransactionMaterialEntry'] as $materials){
        ?>
        <?php
        //Set for 12 months
        $product = array();
        $price_month_before = array();
        $price_month_now = array();
        $price_month_all = array();
        $weight_month_before = array();
        $weight_month_now = array();
        $weight_month_all = array();
        $compact_data_by_month = array([], [], [], [], [], [], [], [], [], [], [], []);
        foreach ($data['rows'] as $items) {
            foreach ($items['SaleDetail'] as $materials) {
                //if ($material_categories['MaterialCategory']['id'] == $materials['MaterialDetail']['Material']['material_category_id']) {
                //$materials['Material']['material_category_id']
                //Push Material if not exist
                if (count($product) != 0) {
                    for ($i = 0; $i < count($product); $i++) {
                        $d = date_parse_from_format("Y-m-d", $materials['created']);
                        if ($product[$i] == $materials['Product']['Parent']['name'] . " " . $materials['Product']['name']) {
                            if ($d['month'] < $month) {
                                //price
                                if ($price_month_before[$i] == 0) {
                                    $price_month_before[$i] = $materials['price'] * $materials['quantity'] * $kurs;
                                    //$price_month_all[$i] = $materials['price'];
                                }
                                //$price_month_before[$i]
                                //weight
                                $weight_month_before[$i]+=$materials['quantity'];
                                $weight_month_all[$i]+=$materials['quantity'];
                            } else if ($d['month'] == $month) {
                                //price
                                if ($price_month_now[$i] == 0) {
                                    $price_month_now[$i] = $materials['price'] * $materials['quantity'] * $kurs;
                                    //$price_month_all[$i] = $materials['price'];
                                }
                                //weight
                                $weight_month_now[$i]+=$materials['quantity'];
                                $weight_month_all[$i]+=$materials['quantity'];
                            }
                            $i = count($product) - 1;
                        } else if ($i == count($product) - 1) {
                            array_push($product, $materials['Product']['Parent']['name'] . " " . $materials['Product']['name']);
                            if ($d['month'] < $month) {
                                //price
                                array_push($price_month_before, $materials['price'] * $materials['quantity'] * $kurs);
                                array_push($price_month_now, 0);
                                array_push($price_month_all, $materials['price'] * $materials['quantity'] * $kurs);
                                //weight
                                array_push($weight_month_before, $materials['quantity']);
                                array_push($weight_month_now, 0);
                                array_push($weight_month_all, $materials['quantity']);
                            } else if ($d['month'] == $month) {
                                //price
                                array_push($price_month_before, 0);
                                array_push($price_month_now, $materials['price'] * $materials['quantity'] * $kurs);
                                array_push($price_month_all, $materials['price'] * $materials['quantity'] * $kurs);
                                //weight
                                array_push($weight_month_before, 0);
                                array_push($weight_month_now, $materials['quantity']);
                                array_push($weight_month_all, $materials['quantity']);
                            }
                            //array_push($material, $materials['Material']['name']);
                        }
                    }
                } else {
                    //For first time
                    array_push($product, $materials['Product']['Parent']['name'] . " " . $materials['Product']['name']);
                    $d = date_parse_from_format("Y-m-d", $materials['created']);
                    if ($d['month'] < $month) {
                        //price
                        array_push($price_month_before, $materials['price'] * $materials['quantity'] * $kurs);
                        array_push($price_month_now, 0);
                        array_push($price_month_all, $materials['price'] * $materials['quantity'] * $kurs);
                        //weight
                        array_push($weight_month_before, $materials['quantity']);
                        array_push($weight_month_now, 0);
                        array_push($weight_month_all, $materials['quantity']);
                    } else if ($d['month'] = $month) {
                        //price
                        array_push($price_month_before, 0);
                        array_push($price_month_now, $materials['price'] * $materials['quantity'] * $kurs);
                        array_push($price_month_all, $materials['price'] * $materials['quantity'] * $kurs);
                        //weight
                        array_push($weight_month_before, 0);
                        array_push($weight_month_now, $materials['quantity']);
                        array_push($weight_month_all, $materials['quantity']);
                    }
                }
                //}
            }
        }
        for ($i = 0; $i < count($product); $i++) {
            ?>
            <tr>
                <td class = "text-center"><?= ($i + 1) ?></td>
                <td style="text-align:left;"><?= $product[$i] ?></td>
                <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($weight_month_before[$i]) ?></td>
                <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($price_month_before[$i]); ?></td>
                <?php
                if ($weight_month_before[$i] != null && $weight_month_before[$i] != "") {
                    ?>
                    <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($price_month_before[$i] / $weight_month_before[$i]) ?></td>
                    <?php
                } else {
                    ?>
                    <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty(0) ?></td>
                    <?php
                }
                ?>
                <td style="text-align:right;color:blue"><?= $this->Html->RpWithMinusEmpty($weight_month_now[$i]) ?></td>
                <td style="text-align:right;color:blue"><?= $this->Html->RpWithMinusEmpty($price_month_now[$i]) ?></td>
                <?php
                if ($weight_month_now != null && $weight_month_now != "") {
                    ?>
                    <td style="text-align:right;color:blue"><?= $this->Html->RpWithMinusEmpty($price_month_now[$i] / $weight_month_now[$i]) ?></td>
                    <?php
                } else {
                    ?>
                    <td style="text-align:right;color:blue"><?= $this->Html->RpWithMinusEmpty(0) ?></td>
                    <?php
                }
                ?>
                <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($weight_month_all[$i]) ?></td>
                <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($price_month_all[$i]) ?></td>
                <?php
                if ($weight_month_all != null && $weight_month_all != "") {
                    ?>
                    <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($price_month_all[$i] / $weight_month_all[$i]) ?></td>
                    <?php
                } else {
                    ?>
                    <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty(0) ?></td>
                    <?php
                }
                ?>
            </tr> 
            <?php
            $total_price_month_before +=$price_month_before[$i];
            $total_price_month_now +=$price_month_now[$i];
            $total_price_month_all +=$price_month_all[$i];
            $total_weight_month_before += $weight_month_before[$i];
            $total_weight_month_now += $weight_month_now[$i];
            $total_weight_month_all += $weight_month_all[$i];
            //$total_before += $weight_month_before[$i] * $price_month_before[$i];
            //$total_now += $weight_month_now[$i] * $price_month_now[$i];
            //$total_all += $weight_month_all[$i] * $price_month_all[$i];
        }
        ?>
        <?php
        $number++;
        //}
        ?>
        <tr style = "font-weight: bold">
            <td class = "text-center"></td>
            <td style="text-align:left;">Jumlah Ikan : </td>
            <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($total_weight_month_before) ?></td>
            <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($total_price_month_before); ?></td>
            <?php
            if ($total_weight_month_before != null && $total_weight_month_before != "") {
                ?>
                <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($total_price_month_before / $total_weight_month_before) ?></td>
                <?php
            } else {
                ?>
                <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty(0) ?></td>
                <?php
            }
            ?>
            <td style="text-align:right;color:blue"><?= $this->Html->RpWithMinusEmpty($total_weight_month_now) ?></td>
            <td style="text-align:right;color:blue"><?= $this->Html->RpWithMinusEmpty($total_price_month_now) ?></td>
            <?php
            if ($total_weight_month_now != null && $total_weight_month_now != "") {
                ?>
                <td style="text-align:right;color:blue"><?= $this->Html->RpWithMinusEmpty($total_price_month_now / $total_weight_month_now) ?></td>
                <?php
            } else {
                ?>
                <td style="text-align:right;color:blue"><?= $this->Html->RpWithMinusEmpty(0) ?></td>
                <?php
            }
            ?>
            <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($total_weight_month_all) ?></td>
            <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($total_price_month_all) ?></td>
            <?php
            if ($total_weight_month_all != null && $total_weight_month_all != "") {
                ?>
                <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty($total_price_month_all / $total_weight_month_all) ?></td>
                <?php
            } else {
                ?>
                <td style="text-align:right;"><?= $this->Html->RpWithMinusEmpty(0) ?></td>
                <?php
            }
            ?>
        </tr> 
    </table>


    <?php
} else {
    echo "<div class='text-center'><h2>Tidak Ada Data</h2></div>";
}
?>