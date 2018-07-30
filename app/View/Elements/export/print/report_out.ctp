<?php
$usdToIDR = 13500;
$categoryGroup = [];
foreach ($productCategories as $productCategory) {
    $categoryGroup[$productCategory["ProductCategory"]["id"]] = [
        "name" => $productCategory["ProductCategory"]["name"],
        "data" => [],
    ];
}
foreach ($result as $item) {
    $categoryGroup[$item["info"]["product_category_id"]]["data"][] = $item;
}
//debug($categoryGroup);
//die;
?>
<style>
    .table-bordered,tr,td{
        border:1px solid black;
        border-collapse: collapse;
        padding:2px 8px;
    }
</style>
<div>PT. CHEN WOO FISHERY MAKASSAR</div>
<div><?php echo $data['title'] ?></div>
<div>Bulan: <?= $month = date("F",strtotime($data['date'])); ?> <?= $year = date("Y",strtotime($data['date'])); ?></div>
<table class="table-bordered" style="margin-top:10px;">
    <thead>
        <tr>
            <td rowspan="2">No</td>
            <td rowspan="2" style="text-align:center;">Description Of Goods</td>
            <td colspan="3" style="text-align:center;">Awal</td>
            <td colspan="3" style="text-align:center;">Sekarang</td>
            <td colspan="3" style="text-align:center;">Total</td>
        </tr>
        <tr>
            <td>Kg</td>
            <td>USD</td>
            <td>Konversi Rp.</td>
            <td>Kg</td>
            <td>USD</td>
            <td>Konversi Rp.</td>
            <td>Kg</td>
            <td>USD</td>
            <td>Konversi Rp.</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $month = date("m",strtotime($data['date']));
        foreach ($categoryGroup as $category) {
            ?>
            <tr>
                <td></td>
                <td><?= $category["name"] ?></td>
            </tr>
            <?php
            $i = 1;
            foreach ($category["data"] as $product) {
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $product["info"]["name"] ?></td>
                    <?php
                    $previousData = [
                        "total_quantity" => 0,
                        "total_price" => 0,
                    ];
                    $currentData = [
                        "total_quantity" => 0,
                        "total_price" => 0,
                    ];
                    $totalData = [
                        "total_quantity" => 0,
                        "total_price" => 0,
                    ];
                    if (!empty($product["monthly"][$year])) {
                        foreach ($product["monthly"][$year] as $m => $monthlyData) {
                            if ($m < intval($month)) {
                                $previousData["total_quantity"]+=$monthlyData["total_quantity"];
                                $previousData["total_price"]+=$monthlyData["total_price"];
                                $totalData["total_quantity"]+=$monthlyData["total_quantity"];
                                $totalData["total_price"]+=$monthlyData["total_price"];
                            }
                            if ($m == intval($month)) {
                                $currentData["total_quantity"]+=$monthlyData["total_quantity"];
                                $currentData["total_price"]+=$monthlyData["total_price"];
                                $totalData["total_quantity"]+=$monthlyData["total_quantity"];
                                $totalData["total_price"]+=$monthlyData["total_price"];
                            }
                        }
                    }
                    ?>
                    <td><?= $previousData["total_quantity"] ?></td>
                    <td><?= $previousData["total_price"] ?></td>
                    <td><?= $this->Html->IDR($previousData["total_price"]*$usdToIDR) ?></td>
                    <td><?= $currentData["total_quantity"] ?></td>
                    <td><?= $currentData["total_price"] ?></td>
                    <td><?= $this->Html->IDR($currentData["total_price"]*$usdToIDR) ?></td>
                    <td><?= $totalData["total_quantity"] ?></td>
                    <td><?= $totalData["total_price"] ?></td>
                    <td><?= $this->Html->IDR($totalData["total_price"]*$usdToIDR) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    <tbody>
</table>