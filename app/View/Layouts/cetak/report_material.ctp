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
        <td rowspan="2" width="250px">Material</td>
        <td colspan="3" width="160px">Satuan</td>
        <td colspan="3" width="160px">Kategori</td>
    </tr>
        <?php
        foreach($data as $materials){
            //foreach($items['TransactionMaterialEntry'] as $materials){
        ?>
        <?php
        $usdToIDR = 13500;
        //Set for 12 months
        $product = array();
        $price_month_before = array();
        $price_month_now = array();
        $price_month_all = array();
        $weight_month_before = array();
        $weight_month_now = array();
        $weight_month_all = array();
        $compact_data_by_month = array([],[],[],[],[],[],[],[],[],[],[],[]);
        foreach($data['rows'] as $items){
            foreach($items['TransactionMaterialOut'] as $transactions){
                foreach($transactions['Package']['PackageDetail'] as $packages){
                if($product_category['ProductCategory']['id']==$packages['ProductData']['ProductSize']['Product']['product_category_id']){
                    //$materials['Material']['material_category_id']
                    //Push Material if not exist
                    if(count($product)!=0){
                        for($i=0;$i<count($product);$i++){
                            $d = date_parse_from_format("Y-m-d", $packages['created']);
                            if($product[$i]==$packages['ProductData']['ProductSize']['name']){
                                if($d['month']<$month){
                                    //price
                                    if($price_month_before[$i]==0){
                                        $price_month_before[$i] = $packages['ProductData']['ProductSize']['price'];
                                        //$price_month_all[$i] = $materials['price'];
                                    }
                                    //$price_month_before[$i]
                                    //weight
                                    $weight_month_before[$i]+=$packages['ProductData']['ProductSize']['quantity'];
                                    $weight_month_all[$i]+=$packages['ProductData']['ProductSize']['quantity'];
                                }else if($d['month']=$month){
                                    //price
                                    if($price_month_now[$i]==0){
                                        $price_month_now[$i] = $packages['ProductData']['ProductSize']['price'];
                                        //$price_month_all[$i] = $materials['price'];
                                    }
                                    //weight
                                    $weight_month_now[$i]+=$packages['ProductData']['ProductSize']['quantity'];
                                    $weight_month_all[$i]+=$packages['ProductData']['ProductSize']['quantity'];
                                }
                                $i= count($packages)-1;
                            }else if($i==count($product)-1){ 
                                array_push($product, $materials['ProductData']['ProductSize']['name']);
                                if($d['month']<$month){
                                    //price
                                    array_push($price_month_before, $packages['ProductData']['ProductSize']['price']);
                                    array_push($price_month_now, 0);
                                    array_push($price_month_all, $packages['ProductData']['ProductSize']['price']);
                                    //weight
                                    array_push($weight_month_before, $packages['ProductData']['ProductSize']['quantity']);
                                    array_push($weight_month_now, 0);
                                    array_push($weight_month_all, $packages['ProductData']['ProductSize']['quantity']);
                                }else if($d['month']=$month){
                                    //price
                                    array_push($price_month_before, 0);
                                    array_push($price_month_now, $packages['ProductData']['ProductSize']['price']);
                                    array_push($price_month_all, $packages['ProductData']['ProductSize']['price']);
                                    //weight
                                    array_push($weight_month_before, 0);
                                    array_push($weight_month_now, $packages['ProductData']['ProductSize']['quantity']);
                                    array_push($weight_month_all, $packages['ProductData']['ProductSize']['quantity']);
                                }
                                //array_push($material, $materials['Material']['name']);
                            }
                        }
                    }else{
                        //For first time
                        array_push($product, $packages['ProductData']['ProductSize']['name']);
                        $d = date_parse_from_format("Y-m-d", $packages['created']);
                        if($d['month']<$month){
                            //price
                            array_push($price_month_before, $packages['ProductData']['ProductSize']['price']);
                            array_push($price_month_now, 0);
                            array_push($price_month_all, $packages['ProductData']['ProductSize']['price']);
                            //weight
                            array_push($weight_month_before, $packages['ProductData']['ProductSize']['quantity']);
                            array_push($weight_month_now, 0);
                            array_push($weight_month_all, $packages['ProductData']['ProductSize']['quantity']);
                        }else if($d['month']=$month){
                            //price
                            array_push($price_month_before, 0);
                            array_push($price_month_now, $packages['ProductData']['ProductSize']['price']);
                            array_push($price_month_all, $packages['ProductData']['ProductSize']['price']);
                            //weight
                            array_push($weight_month_before, 0);
                            array_push($weight_month_now, $packages['ProductData']['ProductSize']['quantity']);
                            array_push($weight_month_all, $packages['ProductData']['ProductSize']['quantity']);
                        }
                    }
                }
            }
            }
        }
        if(count($product)>0){
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