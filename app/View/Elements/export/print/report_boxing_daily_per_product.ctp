<?php
if (!empty($data['rows'])) {
    ?>
    <style>
        .table-bordered,tr,td{
            border:1px solid black;
            border-collapse: collapse;
        }
    </style>
    <div style="text-align:center">
        <div>FORM PACKING</div>
    </div>
    <table class="" style="border:0px;width:100%;">
        <tr>   
            <td style="border:0px;">
                <div style="float:left;width:550px;">
                    <div><span style="width:120px;display:inline-block;">Product Size</span><span>: </span></div>
                </div>
            </td>
        <tr> 
    </table>
    <div style="clear: both;"></div>
    <table class="table-bordered" style="margin-top:10px;width:100%"> 
        <tr style="text-align:center;">
            <td width="50px" rowspan="2">Date</td>
            <td width="30px" rowspan="2">No MC</td>
            <td width="100px" rowspan="2">NW</td>
            <td width="100px" colspan="2">CODE</td>
            <td width="50px" rowspan="2">PCS</td>
            <td width="200px">PMC</td>
        </tr>
        <tr style="text-align:center;">
            <td>PL</td>
            <td>INNER</td>
            <td>MC</td>
        </tr>
        <?php
        $number=1;
        $fishList = array();
        foreach($data['rows']as $box){
            foreach($box['BoxDetail'] as $package){
                if(count($fishList)==0){
                    array_push($fishList,['label'=>$package['PackageDetail']['Product']['name']."-".$package['PackageDetail']['Product']['Parent']['name'],'weight'=>$package['weight'],'total'=>$package['weight'],'buyer'=>$box['Sale']['Buyer']['company_name']]);
                }else{
                    for($i=0;$i<count($fishList);$i++){
                        if($package['PackageDetail']['Product']['name']==$fishList[$i]['label']){
                            $total = $fishList[$i]['total']+$package['weight'];
                            $fishList[$i]['total'] = $total;
                        }else if($i==count($fishList)-1){
                            array_push($fishList,['label'=>$package['PackageDetail']['Product']['name']."-".$package['PackageDetail']['Product']['Parent']['name'],'weight'=>$package['weight'],'total'=>$package['weight'],'buyer'=>$box['Sale']['Buyer']['company_name']]);
                        }
                    }
                }
            }
        }
            foreach($fishList as $item){
                $product = explode("-",$item['label']);
            ?>    
                <!--Set List-->
                <tr>
                    <td><?= $number ?></td>
                    <td><?= $product[1] ?></td>
                    <td><?= $product[0] ?></td>
                    <td><?= $item['total'] ?></td>
                    <td></td>
                    <td><?= $item['buyer'] ?></td>
                    <td><?= $item['weight'] ?></td>
                    <td></td>
                    <td><?= $item['total'] ?></td>
                    <td><?= $item['total'] ?></td>
                </tr> 
            <?php
            $number++;
            }
        }else{
            echo "<div class='text-center'><h2>Tidak Ada Data</h2></div>";
        }
        ?>
    </table>