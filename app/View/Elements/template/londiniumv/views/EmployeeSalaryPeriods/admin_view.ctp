<?php echo $this->Form->create("EmployeeSalaryPeriod", array("class" => "form-horizontal form-separate", "action" => "view", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Gaji Pegawai Harian") ?>
                        <small class="display-block">Mohon diperiksa dengan teliti</small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <div class="panel-heading" style="background:#2179cc">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Penggajian") ?></h6>
                    </div>
                    <table width="100%" class="table">
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("EmployeeSalaryPeriod.start_dt", __("Periode Mulai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("EmployeeSalaryPeriod.start_dt", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text", "disabled"));
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("EmployeeSalaryPeriod.end_dt", __("Periode Akhir"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("EmployeeSalaryPeriod.end_dt", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text", "disabled"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="panel-heading" style="background:#2179cc">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Rincian Penggajian") ?></h6>
                    </div>
                    <div class="table-responsive pre-scrollable stn-table stn-table-nowrap" style="max-height: 550px;">
                        <table width="100%" class="table table-bordered table-striped" id="table-gaji">
                            <thead>
                                <tr bordercolor="#000000">
                                    <th width="1%" align="center" valign="middle">No</th>
                                    <th align="center" valign="middle">Nama Karyawan</th>
                                    <th align="center" valign="middle">Lembur (Jam)</th>
                                    <th align="center" valign="middle">Lembur (Rp)</th>
                                    <th align="center" valign="middle">Lembur (Hari)</th>
                                    <th align="center" valign="middle">Hari Kerja</th>
                                    <th align="center" valign="middle">Jumlah Hari Kerja</th>
                                    <th align="center" valign="middle">Gaji Pokok (Rp)</th>
                                    <th align="center" valign="middle"><?= $mapLabelParameterSalary["IWP"] ?></th>
                                    <th align="center" valign="middle"><?= $mapLabelParameterSalary["PKI"] ?></th>
                                    <th align="center" valign="middle"><?= $mapLabelParameterSalary["PKS"] ?></th>
                                    <th align="center" valign="middle"><?= $mapLabelParameterSalary["LPH"] ?></th>
                                    <th align="center" valign="middle"><?= $mapLabelParameterSalary["LPJ"] ?></th>
                                    <th align="center" valign="middle">Total Gaji Lembur</th>
                                    <th align="center" valign="middle"><?= $mapLabelParameterSalary["GPK"] ?></th>
                                    <th align="center" valign="middle">Total Gaji</th>
                                    <th align="center" valign="middle"><?= $mapLabelParameterSalary["PJS"] ?></th>
                                    <th align="center" valign="middle">Total Diterima</th>
                                    <th align="center" valign="middle">Tgl Masuk</th>
                                </tr>
                                <tr class="text-center"  style="background-color:#cce3ff;">
                                    <td style="padding:0"><small>a</small></td>
                                    <td style="padding:0"><small>b</small></td>
                                    <td style="padding:0"><small>c</small></td>
                                    <td style="padding:0"><small>d</small></td>
                                    <td style="padding:0"><small>e</small></td>
                                    <td style="padding:0"><small>f</small></td>
                                    <td style="padding:0"><small>g = (2 x e) + f</small></td>
                                    <td style="padding:0"><small>h</small></td>
                                    <td style="padding:0"><small>l</small></td>
                                    <td style="padding:0"><small>m</small></td>
                                    <td style="padding:0"><small>n</small></td>
                                    <td style="padding:0"><small>o = e x (h x 2)</small></td>
                                    <td style="padding:0"><small>p</small></td>
                                    <td style="padding:0"><small>q</small></td>
                                    <td style="padding:0"><small>r</small></td>
                                    <td style="padding:0"><small>s</small></td>
                                    <td style="padding:0"><small>t</small></td>
                                    <td style="padding:0"><small>u</small></td>
                                    <td style="padding:0"><small>v</small></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $n = 1;
                                foreach ($this->data["EmployeeSalary"] as $employeeSalary) {
                                    $build = [];
                                    foreach ($employeeSalary["ParameterEmployeeSalary"] as $parameterEmployeeSalary) {
                                        $build[$parameterEmployeeSalary["ParameterSalary"]["code"]] = abs($parameterEmployeeSalary["nominal"]);
                                    }
                                    $totalgaji = $build["LPJ"] + $build["LPH"] + $build["GPK"];
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $n ?></td>
                                        <td class="text-left" style="-webkit-box-shadow: 10px 0 5px -2px #888; box-shadow: 5px 0 5px -2px #ccc;">
                                            <?= $employeeSalary["Employee"]["Account"]["Biodata"]["full_name"] ?>
                                        </td>
                                        <td class="text-center">
                                            <input type="text" class="form-control text-center minwidth85" disabled value="<?= $employeeSalary["EmployeeSalaryInfo"]["lembur_jam"] ?>"/>
                                        </td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85" disabled value="<?= $employeeSalary["EmployeeSalaryInfo"]["lembur_rp"] ?>"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-center minwidth50" disabled value="<?= $employeeSalary["EmployeeSalaryInfo"]["lembur_hari"] ?>"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-center minwidth50" disabled value="<?= $employeeSalary["EmployeeSalaryInfo"]["hari_kerja"] ?>"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-center minwidth50" disabled value="<?= $employeeSalary["EmployeeSalaryInfo"]["jumlah_hari_kerja"] ?>"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85" disabled value="<?= $employeeSalary["EmployeeSalaryInfo"]["gaji_pokok"] ?>"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85 potongan isdecimal" disabled name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][0][nominal]" value="<?= $build["IWP"] ?>"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85 potongan isdecimal" disabled name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][4][nominal]" value="<?= $build["PKI"] ?>"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85 potongan isdecimal" disabled name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][5][nominal]" value="<?= $build["PKS"] ?>"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85" readonly value="<?= ic_rupiah($build["LPH"]) ?>" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][6][nominal]" value="<?= $build["LPH"] ?>"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85" readonly value="<?= ic_rupiah($build["LPJ"]) ?>" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][7][nominal]" value="<?= $build["LPJ"] ?>"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85" disabled value="<?= $employeeSalary["EmployeeSalaryInfo"]["total_gaji_lembur"] ?>"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85" readonly value="<?= ic_rupiah($build["GPK"]) ?>" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][8][nominal]" value="<?= $build["GPK"] ?>"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85" disabled value="<?= $employeeSalary["EmployeeSalaryInfo"]["total_gaji"] ?>"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85 potongan isdecimal" disabled name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][9][nominal]" value="<?= $build["PJS"] ?>"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85 gajiditerima" disabled value="<?= $employeeSalary["EmployeeSalaryInfo"]["total_diterima"] ?>" /></td>
                                        <td class="text-center"><input type="text" class="form-control text-center minwidth100" disabled value="<?= $this->Html->cvtTanggal($employeeSalary["Employee"]["tmt"], false) ?>"/></td>
                                    </tr>
                                    <?php
                                    $n++;
                                }
                                ?>
                            </tbody>  
                        </table>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<style>
    .minwidth85{
        width:85px;  
    }
    .minwidth100{
        width:100px;  
    }
    .minwidth50{
        width:50px;  
    }
</style>
<script>
    $(document).ready(function () {
        $("#table-gaji").tableHeadFixer({"left": 2})
    })
</script>