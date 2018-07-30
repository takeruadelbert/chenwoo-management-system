<?php
$mapId = [];
$mapAmount = [];
foreach ($this->data["SalaryReductionDetail"] as $salaryReductionDetail) {
    $mapId[$salaryReductionDetail["employee_id"]] = $salaryReductionDetail["id"];
    $mapAmount[$salaryReductionDetail["employee_id"]] = $salaryReductionDetail["amount"];
}
?>
<?php echo $this->Form->create("SalaryReduction", array("class" => "form-horizontal form-separate", "action" => "view", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Lihat Potongan Gaji") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("SalaryReduction.parameter_salary_id", __("Jenis Potongan"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("SalaryReduction.ParameterSalary.name", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "value" => $this->data['ParameterSalary']['name'], "disabled"));
                        ?>
                    </div>
                </div>
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Pegawai Harian") ?></h6>
                </div>
                <div class="table-responsive stn-table">
                    <table width="100%" class="table table-bordered table-hover">
                        <thead>
                            <tr bordercolor="#000000">
                                <th width="50" align="center" valign="middle" bgcolor="#feffc2">No</th>
                                <th align="center" valign="middle" bgcolor="#feffc2">Nama Pegawai</th>
                                <th align="center" valign="middle" bgcolor="#feffc2" colspan = "2">Jumlah Potongan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($dataEmployeeHarian as $k => $employee) {
                                $employeeId = $employee["Employee"]["id"];
                                ?>
                                <tr>
                                    <td align="center" class="nomorIdx"><?= $i ?></td>
                                    <td>
                                        <div class="false">
                                            <?= $employee["Account"]["Biodata"]["full_name"] ?>
                                        </div>
                                    </td>
                                    <td class="text-center" style= "width:50px; border-right-style:none;">           
                                        Rp.
                                    </td>    
                                    <td class = "text-right" style="border-left-style:none; width:250px">
                                        <?php
                                        if (!isset($mapId[$employeeId])) {
                                            ?>
                                            <?= $this->Form->hidden("SalaryReductionDetail.$i.employee_id", ["value" => $employeeId]) ?>
                                            <?= ic_rupiah($this->data['SalaryReductionDetail'][$i]['amount']) ?>
                                            <?php
                                        } else {
                                            ?>
                                            <?= $this->Form->hidden("SalaryReductionDetail.$i.id", ["value" => $mapId[$employeeId]]) ?>
                                            <?= ic_rupiah($mapAmount[$employeeId]) ?>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>  
                    </table>
                </div>
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Pegawai Bulanan") ?></h6>
                </div>
                <div class="table-responsive stn-table">
                    <table width="100%" class="table table-bordered table-hover">
                        <thead>
                            <tr bordercolor="#000000">
                                <th width="50" align="center" valign="middle" bgcolor="#feffc2">No</th>
                                <th align="center" valign="middle" bgcolor="#feffc2">Nama Pegawai</th>
                                <th width="250" align="center" valign="middle" bgcolor="#feffc2" colspan="2">Jumlah Potongan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($dataEmployeeBulanan as $k => $employee) {
                                $employeeId = $employee["Employee"]["id"];
                                ?>
                                <tr>
                                    <td align="center" class="nomorIdx"><?= $i ?></td>
                                    <td>
                                        <div class="false">
                                            <?= $employee["Account"]["Biodata"]["full_name"] ?>
                                        </div>
                                    </td>
                                    <td class="text-center" style= "width:50px; border-right-style:none;">           
                                        Rp.
                                    </td> 
                                    <td class = "text-right" style="border-left-style:none; width:250px">
                                        <?php
                                        if (!isset($mapId[$employeeId])) {
                                            ?>
                                            <?= $this->Form->hidden("SalaryReductionDetail.$i.employee_id", ["value" => $employeeId]) ?>
                                            <?= ic_rupiah($this->data['SalaryReductionDetail'][$i]['amount']) ?>
                                            <?php
                                        } else {
                                            ?>
                                            <?= $this->Form->hidden("SalaryReductionDetail.$i.id", ["value" => $mapId[$employeeId]]) ?>
                                            <?= ic_rupiah($mapAmount[$employeeId]) ?>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>  
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <div class="form-actions text-center">
                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>