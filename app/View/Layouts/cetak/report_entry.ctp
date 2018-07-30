<?php
if (!empty($data['rows'])) {
    ?>
    <style>
        .table-bordered,tr,td{
            border:1px solid black;
            border-collapse: collapse;
        }
    </style>
    <div>PT. CHEN WOO FISHERY MAKASSAR</div>
    <div><?php echo $data['title'] ?></div>
    <div>Bulan: Agustus 2016</div>
    <table class="table-bordered"> 
        <tr style="text-align:center;">
            <td rowspan="2" width="30px">NO</td>
            <td rowspan="2" width="250px">NAMA IKAN</td>
            <td colspan="2" width="160px">BULAN LALU </br> Januari s/d November 2016</td>
            <td rowspan="2" width="80px">HARGA </br> RATA-RATA</td>
            <td colspan="2" width="160px">BULAN INI </br> November 2016</td>
            <td rowspan="2" width="80px">HARGA </br> RATA-RATA</td>
            <td colspan="2" width="160px">S/D BULAN INI </br> Januari s/d Desember 2016</td>
            <td rowspan="2" width="80px">HARGA </br> RATA-RATA</td>
        </tr>
        <tr style="text-align:center;">
            <td>Kg</td>
            <td>Rp.</td>
            <td>Kg</td>
            <td>Rp.</td>
            <td>Kg</td>
            <td>Rp.</td>
        </tr>
        <?php
        $number=1;
        $month=11;
        foreach($data['material_categories'] as $material_categories){
            //foreach($items['TransactionMaterialEntry'] as $materials){
        ?>
        <?php
        //Set for 12 months
        $material = array();
        $price_month_before = array();
        $price_month_now = array();
        $price_month_all = array();
        $weight_month_before = array();
        $weight_month_now = array();
        $weight_month_all = array();
        $compact_data_by_month = array([],[],[],[],[],[],[],[],[],[],[],[]);
        foreach($data['rows'] as $items){
            foreach($items['TransactionMaterialEntry'] as $materials){
                if($material_categories['MaterialCategory']['id']==$materials['Material']['material_category_id']){
                    //$materials['Material']['material_category_id']
                    //Push Material if not exist
                    if(count($material)!=0){
                        for($i=0;$i<count($material);$i++){
                            $d = date_parse_from_format("Y-m-d", $materials['created']);
                            if($material[$i]==$materials['Material']['name']){
                                if($d['month']<$month){
                                    //price
                                    if($price_month_before[$i]==0){
                                        $price_month_before[$i] = $materials['price'];
                                        //$price_month_all[$i] = $materials['price'];
                                    }
                                    //$price_month_before[$i]
                                    //weight
                                    $weight_month_before[$i]+=$materials['quantity'];
                                    $weight_month_all[$i]+=$materials['quantity'];
                                }else if($d['month']=$month){
                                    //price
                                    if($price_month_now[$i]==0){
                                        $price_month_now[$i] = $materials['price'];
                                        //$price_month_all[$i] = $materials['price'];
                                    }
                                    //weight
                                    $weight_month_now[$i]+=$materials['quantity'];
                                    $weight_month_all[$i]+=$materials['quantity'];
                                }
                                $i= count($material)-1;
                            }else if($i==count($material)-1){ 
                                array_push($material, $materials['Material']['name']);
                                if($d['month']<$month){
                                    //price
                                    array_push($price_month_before, $materials['price']);
                                    array_push($price_month_now, 0);
                                    array_push($price_month_all, $materials['price']);
                                    //weight
                                    array_push($weight_month_before, $materials['quantity']);
                                    array_push($weight_month_now, 0);
                                    array_push($weight_month_all, $materials['quantity']);
                                }else if($d['month']=$month){
                                    //price
                                    array_push($price_month_before, 0);
                                    array_push($price_month_now, $materials['price']);
                                    array_push($price_month_all, $materials['price']);
                                    //weight
                                    array_push($weight_month_before, 0);
                                    array_push($weight_month_now, $materials['quantity']);
                                    array_push($weight_month_all, $materials['quantity']);
                                }
                                //array_push($material, $materials['Material']['name']);
                            }
                        }
                    }else{
                        //For first time
                        array_push($material, $materials['Material']['name']);
                        $d = date_parse_from_format("Y-m-d", $materials['created']);
                        if($d['month']<$month){
                            //price
                            array_push($price_month_before, $materials['price']);
                            array_push($price_month_now, 0);
                            array_push($price_month_all, $materials['price']);
                            //weight
                            array_push($weight_month_before, $materials['quantity']);
                            array_push($weight_month_now, 0);
                            array_push($weight_month_all, $materials['quantity']);
                        }else if($d['month']=$month){
                            //price
                            array_push($price_month_before, 0);
                            array_push($price_month_now, $materials['price']);
                            array_push($price_month_all, $materials['price']);
                            //weight
                            array_push($weight_month_before, 0);
                            array_push($weight_month_now, $materials['quantity']);
                            array_push($weight_month_all, $materials['quantity']);
                        }
                    }
                }
            }
        }
        if(count($material)>0){
        ?>
        <!--Set Category Header-->
        <tr>
            <td></td>
            <td style="text-align:center;"><?= $material_categories['MaterialCategory']['name'] ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr> 
        <?php    
        }
        for($i=0;$i<count($material);$i++){
        ?>
        <tr>
            <td><?= ($i+1)?></td>
            <td style="text-align:center;"><?= $material[$i] ?></td>
            <td><?= $weight_month_before[$i] ?></td>
            <td><?= $price_month_before[$i] ?></td>
            <td><?= $weight_month_before[$i]*$price_month_before[$i] ?></td>
            <td><?= $weight_month_now[$i] ?></td>
            <td><?= $price_month_now[$i] ?></td>
            <td><?= $weight_month_now[$i]*$price_month_now[$i] ?></td>
            <td><?= $weight_month_all[$i] ?></td>
            <td><?= $price_month_all[$i] ?></td>
            <td><?= $weight_month_all[$i]*$price_month_all[$i] ?></td>
        </tr> 
        <?php
        }
        ?>
        
        <?php
        $number++;
            //}
        }
        ?>
    </table>


<?php } ?>