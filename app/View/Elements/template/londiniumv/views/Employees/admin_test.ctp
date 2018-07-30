<?php
$groupedEmployee = [];
foreach ($departments as $id => $name) {
    $groupedEmployee[$id] = [
        "name" => $name,
        "data" => [],
    ];
}
foreach ($employees as $employee) {
    $groupedEmployee[$employee["Employee"]["department_id"]]["data"][] = $employee;
}
?>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jabatan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total=0;
        foreach ($groupedEmployee as $department) {
            ?>
            <tr>
                <td colspan="3" style="padding:5px"><b><?= $department["name"] ?></b></td>
            </tr>
            <?php
            foreach ($department["data"] as $employee) {
                ?>
                <tr>
                    <td style="padding:5px"></td>
                    <td style="padding:5px"><?= $employee["Account"]["Biodata"]["full_name"] ?></td>
                    <td style="padding:5px"><?= $employee["Office"]["name"] ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="2" style="padding:5px">Total</td>
                <td style="padding:5px"><?= count($department["data"])?></td>
            </tr>
            <?php
            $total+=count($department["data"]);
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="padding:5px">Grand Total</td>
            <td style="padding:5px"><?= $total?></td>
        </tr>
    </tfoot>
</table>