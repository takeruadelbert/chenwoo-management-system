<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/employee-statistic");
$countGender = [];
$newEmployeeThisMonth = [];
foreach ($data["genders"] as $gender) {
    $countGender[$gender["Gender"]["id"]] = [
        "label" => $gender["Gender"]["name"],
        "count" => 0,
    ];
}
$groupedEmployee = [];
foreach ($data["employeeTypes"] as $employeeType) {
    $groupedEmployee[$employeeType["EmployeeType"]["id"]] = [
        "label" => "Pegawai {$employeeType["EmployeeType"]["name"]}",
        "data" => [],
        "count" => 0,
        "gender" => $countGender,
        "department" => [],
    ];
}
foreach ($data["employees"] as $employee) {
//    $groupedEmployee[$employee["Employee"]["employee_type_id"]]["data"][] = $employee;
    if (date("m-Y", strtotime($employee["Employee"]["tmt"])) == date("m-Y")) {
        $newEmployeeThisMonth[] = $employee;
    }
    $groupedEmployee[$employee["Employee"]["employee_type_id"]]["count"] ++;
    if (!isset($groupedEmployee[$employee["Employee"]["employee_type_id"]]["department"][$employee["Employee"]["department_id"]])) {
        $groupedEmployee[$employee["Employee"]["employee_type_id"]]["department"][$employee["Employee"]["department_id"]] = [
            "label" => $employee["Department"]["name"],
            "count" => 0,
        ];
    }
    $groupedEmployee[$employee["Employee"]["employee_type_id"]]["department"][$employee["Employee"]["department_id"]]["count"] ++;
    if (!empty($employee["Account"]["Biodata"]["gender_id"])) {
        $groupedEmployee[$employee["Employee"]["employee_type_id"]]["gender"][$employee["Account"]["Biodata"]["gender_id"]]["count"] ++;
        $countGender[$employee["Account"]["Biodata"]["gender_id"]]["count"] ++;
    }
}
//foreach ($groupedEmployee as &$employeeTypeData) {
//    array_multisort(array_column($employeeTypeData["department"], "label"), SORT_ASC, $employeeTypeData["department"]);
//}
$colspan = 20;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("STATISTIK PEGAWAI")." {$namaCabang}" ?> Periode <?= $this->Html->getNamaBulan(date("m")) . " " . date("Y") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("statistic/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="stn-table-nowrap">
            <table class="table">
                <tbody>
                    <tr style="background-color:#2179cc;color:white">
                        <td width="25" class="text-center">I</td>
                        <td colspan="<?= $colspan - 1 ?>" style="text-decoration: underline;font-weight: bold">Jumlah Pegawai</td>
                    </tr>
                    <?php
                    foreach ($groupedEmployee as $employeeTypeData) {
                        ?>
                        <tr>
                            <td width="25" class="text-center">-</td>
                            <td width="100"><?= $employeeTypeData["label"] ?></td>
                            <td width="5">:</td>
                            <td width="50" class="text-right"><?= $employeeTypeData["count"] ?></td>
                            <?php
                            foreach ($employeeTypeData["gender"] as $genderData) {
                                ?>
                                <td width="25"></td>
                                <td width="100"><?= $genderData["label"] ?></td>
                                <td width="5">:</td>
                                <td width="50" class="text-right"><?= $genderData["count"] ?></td>
                                <?php
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr style="font-weight: bold">
                        <td></td>
                        <td>Jumlah Pegawai</td>
                        <td width="5">:</td>
                        <td class="text-right"><?= array_sum(array_column($groupedEmployee, "count")) ?></td>
                        <?php
                        foreach ($countGender as $genderData) {
                            ?>
                            <td width="25"></td>
                            <td width="100"><?= $genderData["label"] ?></td>
                            <td width="5">:</td>
                            <td width="50" class="text-right"><?= $genderData["count"] ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                    $n = 2;

                    foreach ($groupedEmployee as $employeeTypeData) {
                        ?>
                        <tr style="background-color:#2179cc;color:white">
                            <td width="25" class="text-center"><?= romanic_number($n++) ?></td>
                            <td colspan="<?= $colspan - 1 ?>" style="text-decoration: underline;font-weight: bold"><?= $employeeTypeData["label"] ?></td>
                        </tr>
                        <?php
                        $m = 0;
                        if (!empty($employeeTypeData["department"])) {
                            foreach ($employeeTypeData["department"] as $departmentData) {
                                $m++;
                                if ($m % 3 == 1) {
                                    ?>
                                    <tr>
                                        <?php
                                    }
                                    ?>
                                    <td width="25"></td>
                                    <td width="100"><?= $departmentData["label"] ?></td>
                                    <td width="5">:</td>
                                    <td width="50" class="text-right"><?= $departmentData["count"] ?></td>
                                    <?php
                                    if ($m % 3 == 0 || $m == count($employeeTypeData["department"])) {
                                        if ($m % 3 != 0) {
                                            ?>
                                            <td colspan="<?= (3 - ($m % 3)) * 4 ?>"></td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="<?= $colspan ?>" class="text-center">Tidak ada data.</td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>
            <table class="table">
                <tbody>
                    <tr style="background-color:#2179cc;color:white">
                        <td width="25" class="text-center"><?= romanic_number($n++) ?></td>
                        <td colspan="<?= $colspan - 1 ?>" style="text-decoration: underline;font-weight: bold">Pegawai Baru</td>
                    </tr>
                    <tr style="background-color:#fdffd4">
                        <td width="50"></td>
                        <td>Nama</td>
                        <td>Department</td>
                        <td>Jabatan</td>
                        <td>Tanggal Masuk</td>
                    </tr>
                    <?php
                    $i = 1;
                    if (!empty($newEmployeeThisMonth)) {
                        foreach ($newEmployeeThisMonth as $employee) {
                            ?>
                            <tr>
                                <td class="text-center"><?= $i ?></td>
                                <td><?= $employee["Account"]["Biodata"]["full_name"] ?></td>
                                <td><?= $employee["Department"]["name"] ?></td>
                                <td><?= $employee["Office"]["name"] ?></td>
                                <td><?= $this->Html->cvtTanggal($employee["Employee"]["tmt"], false) ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="<?= $colspan ?>" class="text-center">Tidak ada data.</td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr style="background-color:#2179cc;color:white">
                        <td width="25" class="text-center"><?= romanic_number($n++) ?></td>
                        <td colspan="<?= $colspan - 1 ?>" style="text-decoration: underline;font-weight: bold">Pegawai Keluar</td>
                    </tr>
                    <tr style="background-color:#fdffd4">
                        <td width="50"></td>
                        <td>Nama</td>
                        <td>Department</td>
                        <td>Jabatan</td>
                        <td>Tanggal Keluar</td>
                    </tr>
                    <?php
                    $i = 1;
                    if (!empty($data["pensions"])) {
                        foreach ($data["pensions"] as $pension) {
                            $employee = $pension["Employee"];
                            ?>
                            <tr>
                                <td class="text-center"><?= $i ?></td>
                                <td><?= $employee["Account"]["Biodata"]["full_name"] ?></td>
                                <td><?= $employee["Department"]["name"] ?></td>
                                <td><?= $employee["Office"]["name"] ?></td>
                                <td><?= $this->Html->cvtTanggal($pension["Pension"]["tanggal_sk"], false) ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    if (!empty($data["resignations"])) {
                        foreach ($data["resignations"] as $resignation) {
                            $employee = $resignation["Employee"];
                            ?>
                            <tr>
                                <td class="text-center"><?= $i ?></td>
                                <td><?= $employee["Account"]["Biodata"]["full_name"] ?></td>
                                <td><?= $employee["Department"]["name"] ?></td>
                                <td><?= $employee["Office"]["name"] ?></td>
                                <td><?= $this->Html->cvtTanggal($resignation["Resignation"]["resignation_date"], false) ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    if ($i == 1) {
                        ?>
                        <tr>
                            <td colspan="<?= $colspan ?>" class="text-center">Tidak ada data.</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <table class="table">
                <tbody>
                    <tr style="background-color:#2179cc;color:white">
                        <td width="25" class="text-center"><?= romanic_number($n++) ?></td>
                        <td colspan="<?= $colspan - 1 ?>" style="text-decoration: underline;font-weight: bold">Pegawai Yang Dimutasikan</td>
                    </tr>
                    <tr style="background-color:#fdffd4">
                        <td width="50"></td>
                        <td>Nama</td>
                        <td>Department</td>
                        <td>Jabatan</td>
                        <td>Dimutasikan Dari</td>
                        <td>Dimutasikan Ke</td>
                        <td>Tanggal Mutasi</td>
                    </tr>
                    <?php
                    $i = 1;
                    if (!empty($data["transferEmployees"])) {
                        foreach ($data["transferEmployees"] as $transferEmployee) {
                            $employee = $transferEmployee["Employee"];
                            ?>
                            <tr>
                                <td class="text-center"><?= $i ?></td>
                                <td><?= $employee["Account"]["Biodata"]["full_name"] ?></td>
                                <td><?= $employee["Department"]["name"] ?></td>
                                <td><?= $employee["Office"]["name"] ?></td>
                                <td><?= $transferEmployee["OriginBranchOffice"]["name"] ?></td>
                                <td><?= $transferEmployee["BranchOffice"]["name"] ?></td>
                                <td><?= $this->Html->cvtTanggal($transferEmployee["TransferEmployee"]["tanggal_sk_mutasi"], false) ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    if ($i == 1) {
                        ?>
                        <tr>
                            <td colspan="<?= $colspan ?>" class="text-center">Tidak ada data.</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php ?>

