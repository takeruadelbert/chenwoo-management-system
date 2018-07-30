<?php echo $this->Form->create("Employee", array("class" => "form-horizontal form-separate", "action" => "update_salary_bulanan", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Setup Gaji Pokok Bulanan") ?>
                        <small class="display-block"></small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <div class="panel-heading" style="background:#2179cc">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Pegawai") ?></h6>
                    </div>
                    <table width="100%" class="table">
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.name", __("Nama Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "value" => $employee["Account"]["Biodata"]["full_name"], "disabled"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Employee.nip", __("NIP"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Employee.nip", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled" => true, "required" => false));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Office.name", __("Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Office.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled" => true, "required" => false));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Department.name", __("Department"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Department.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled" => true));
                                            ?>
                                        </div>
                                    </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Employee.tmt", __("Tanggal Masuk"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Employee.tmt", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled" => true, "value" => $this->Html->cvtTanggal($this->data["Employee"]["tmt"], false), "type" => "text", "required" => false));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.jenis_pegawai", __("Jenis Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.jenis_pegawai", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "value" => $employee["EmployeeType"]["name"], "disabled"));
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </td>
                        </tr>

                    </table>
                    <div class="panel-heading" style="background:#a50000">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Form Gaji Pokok") ?></h6>
                    </div>
                    <table width="100%" class="table">
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("EmployeeBasicSalary.new_salary", __("Gaji Pokok Baru"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("EmployeeBasicSalary.new_salary", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control rupiah-field isdecimal"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("EmployeeBasicSalary.new_ot_salary", __("Upah Lembur Per Jam"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("EmployeeBasicSalary.new_ot_salary", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control rupiah-field isdecimal"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Gaji Pokok") ?></h6>
                </div>
                <table width="100%" class="table table-bordered table-hover">
                    <thead>
                        <tr bordercolor="#000000">
                            <td width="1%" align="center" valign="middle" bgcolor="#feffc2">No</td>
                            <td align="center" valign="middle" bgcolor="#feffc2">Tgl Awal</td>
                            <td align="center" valign="middle" bgcolor="#feffc2">Tgl Akhir</td>
                            <td align="center" valign="middle" bgcolor="#feffc2" colspan="2">Gaji Pokok</td>
                            <td align="center" valign="middle" bgcolor="#feffc2" colspan="2">Upah Lembur Per Jam</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($employee["EmployeeBasicSalary"] as $n => $employeeBasicSalary) {
                            ?>
                            <tr>
                                <td class="text-center">
                                    <?= $n + 1 ?>
                                </td>
                                <td>
                                    <?= $this->Html->cvtTanggal($employeeBasicSalary["start_date"], false) ?>
                                </td>
                                <td>
                                    <?= $this->Html->cvtTanggal($employeeBasicSalary["end_date"], false) ?>
                                </td>
                                <td class="text-center" style= "width:50px; border-right-style:none;">           
                                    Rp.
                                </td>    
                                <td class = "text-right" style="border-left-style:none;">
                                    <?= ic_rupiah($employeeBasicSalary["salary"]) ?>
                                </td>
                                <td class="text-center" style= "width:50px; border-right-style:none;">           
                                    Rp.
                                </td>   
                                <td class = "text-right" style="border-left-style:none;">
                                    <?= ic_rupiah($employeeBasicSalary["ot_salary"]) ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center with-padding">
                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                <input type="reset" value="Reset" class="btn btn-info">
                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
</div>
<?php echo $this->Form->end() ?>