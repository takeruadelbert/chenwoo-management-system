<?php
$mapId = [];
$mapAmount = [];
foreach ($this->data["SalaryReductionDetail"] as $salaryReductionDetail) {
    $mapId[$salaryReductionDetail["employee_id"]] = $salaryReductionDetail["id"];
    $mapAmount[$salaryReductionDetail["employee_id"]] = $salaryReductionDetail["amount"];
}
?>
<?php echo $this->Form->create("SalaryReduction", array("class" => "form-horizontal form-separate", "action" => "edit", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Potongan Gaji") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("SalaryReduction.parameter_salary_id", __("Jenis Potongan"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("SalaryReduction.parameter_salary_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "-Pilih Jenis Potongan-"));
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
                                <th width="250" align="center" valign="middle" bgcolor="#feffc2">Jumlah Potongan</th>
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
                                            <?= $this->Form->input("Dummy.$i.name", [ "value" => $employee["Account"]["Biodata"]["full_name"], "div" => false, "class" => "form-control", "label" => false, "disabled"]) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        if (!isset($mapId[$employeeId])) {
                                            ?>
                                            <?= $this->Form->hidden("SalaryReductionDetail.$i.employee_id", ["value" => $employeeId]) ?>
                                            <?= $this->Form->input("SalaryReductionDetail.$i.amount", [ "div" => false, "class" => "form-control rupiah-field isdecimal text-right", "label" => false]) ?>
                                            <?php
                                        } else {
                                            ?>
                                            <?= $this->Form->hidden("SalaryReductionDetail.$i.id", ["value" => $mapId[$employeeId]]) ?>
                                            <?= $this->Form->input("SalaryReductionDetail.$i.amount", ["value" => $mapAmount[$employeeId], "div" => false, "class" => "form-control rupiah-field isdecimal text-right", "label" => false]) ?>
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
                                <th width="250" align="center" valign="middle" bgcolor="#feffc2">Jumlah Potongan</th>
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
                                            <?= $this->Form->input("Dummy.$i.name", [ "value" => $employee["Account"]["Biodata"]["full_name"], "div" => false, "class" => "form-control", "label" => false, "disabled"]) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        if (!isset($mapId[$employeeId])) {
                                            ?>
                                            <?= $this->Form->hidden("SalaryReductionDetail.$i.employee_id", ["value" => $employeeId]) ?>
                                            <?= $this->Form->input("SalaryReductionDetail.$i.amount", [ "div" => false, "class" => "form-control rupiah-field isdecimal text-right", "label" => false]) ?>
                                            <?php
                                        } else {
                                            ?>
                                            <?= $this->Form->hidden("SalaryReductionDetail.$i.id", ["value" => $mapId[$employeeId]]) ?>
                                            <?= $this->Form->input("SalaryReductionDetail.$i.amount", ["value" => $mapAmount[$employeeId], "div" => false, "class" => "form-control rupiah-field isdecimal text-right", "label" => false]) ?>
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
                <input type="reset" value="Reset" class="btn btn-info">
                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>