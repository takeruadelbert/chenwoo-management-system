<?php echo $this->Form->create("EmployeeSalaryPeriod", array("class" => "form-horizontal form-separate", "action" => "add_step2", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
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
                                            echo $this->Form->input("EmployeeSalaryPeriod.start_dt", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text", "value" => $this->request->query["start_dt"], "readonly"));
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("EmployeeSalaryPeriod.end_dt", __("Periode Akhir"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("EmployeeSalaryPeriod.end_dt", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text", "value" => $this->request->query["end_dt"], "readonly"));
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
                                    <th align="center" valign="middle">Nama Pegawai</th>
                                    <th align="center" valign="middle">Lembur<br/><span style="text-transform:capitalize">(Jam)</span></th>
                                    <th align="center" valign="middle">Lembur<br/><span style="text-transform:capitalize">(Rp)</span></th>
                                    <th align="center" valign="middle">Lembur<br/><span style="text-transform:capitalize">(Hari)</span></th>
                                    <th align="center" valign="middle">Hari Kerja</th>
                                    <th align="center" valign="middle">Jumlah Hari Kerja</th>
                                    <th align="center" valign="middle">Gaji Pokok<br/><span style="text-transform:capitalize">(Rp)</span></th>
                                    <th align="center" valign="middle"><?= $mapLabelParameterSalary["IWP"] ?></th>
                                    <th align="center" valign="middle"><?= $mapLabelParameterSalary["PKI"] ?></th>
                                    <th align="center" valign="middle"><?= $mapLabelParameterSalary["PKS"] ?></th>
                                    <th align="center" valign="middle"><?= $mapLabelParameterSalary["LPH"] ?></th>
                                    <th align="center" valign="middle"><?= $mapLabelParameterSalary["LPJ"] ?></th>
                                    <th align="center" valign="middle">Total Gaji Lembur<br/><span style="text-transform:capitalize">(Rp)</span></th>
                                    <th align="center" valign="middle"><?= $mapLabelParameterSalary["GPK"] ?><br/><span style="text-transform:capitalize">(Rp)</span></th>
                                    <th align="center" valign="middle">Total Gaji<br/><span style="text-transform:capitalize">(Rp)</span></th>
                                    <th align="center" valign="middle"><?= $mapLabelParameterSalary["PJS"] ?><br/><span style="text-transform:capitalize">(Rp)</span></th>
                                    <th align="center" valign="middle">Total Diterima<br/><span style="text-transform:capitalize">(Rp)</span></th>
                                    <th align="center" valign="middle">Tgl Masuk</th>
                                </tr>
                                <tr class="text-center" style="background-color:#cce3ff;">
                                    <td style="padding:0"><small>a</small></td>
                                    <td style="padding:0"><small>b</small></td>
                                    <td style="padding:0"><small>c</small></td>
                                    <td style="padding:0"><small>d</small></td>
                                    <td style="padding:0"><small>e</small></td>
                                    <td style="padding:0"><small>f</small></td>
                                    <td style="padding:0"><small>g = (2 x e) + f</small></td>
                                    <td style="padding:0"><small>h</small></td>
                                    <td style="padding:0"><small>i</small></td>
                                    <td style="padding:0"><small>j</small></td>
                                    <td style="padding:0"><small>k</small></td>
                                    <td style="padding:0"><small>m = e x (h x 2)</small></td>
                                    <td style="padding:0"><small>n</small></td>
                                    <td style="padding:0"><small>o</small></td>
                                    <td style="padding:0"><small>p</small></td>
                                    <td style="padding:0"><small>q</small></td>
                                    <td style="padding:0"><small>r</small></td>
                                    <td style="padding:0"><small>s</small></td>
                                    <td style="padding:0"><small>t</small></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $n = 1;
                                foreach ($dataSalary as $employeeId => $salaryDetail) {
                                    $totalgaji = $salaryDetail["salary"]["pendapatan"]["data"][$mapParameterSalary["LPJ"]] + $salaryDetail["salary"]["pendapatan"]["data"][$mapParameterSalary["LPH"]] + $salaryDetail["salary"]["pendapatan"]["data"][$mapParameterSalary["GPK"]];
                                    ?>
                                    <tr data-employeeid="<?= $employeeId ?>" class="autocalculate">
                                        <td class="text-center" ><?= $n ?></td>
                                        <td class="text-left" style="-webkit-box-shadow: 10px 0 5px -2px #888; box-shadow: 5px 0 5px -2px #ccc;"><?= $salaryDetail["info"]["full_name"] ?></td>
                                        <td class="text-center"><input type="text" class="form-control text-center minwidth85" readonly value="<?= $this->Html->toHHMMSS($salaryDetail["attendance"]["summary"]["jumlah_jam_lembur"], true) ?>" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][EmployeeSalaryInfo][lembur_jam]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85" readonly value="<?= ic_rupiah($salaryDetail["info"]["ot_salary"]) ?>" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][EmployeeSalaryInfo][lembur_rp]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-center minwidth50" readonly value="<?= $salaryDetail["attendance"]["summary"]["jumlah_hadir_libur"] + ($salaryDetail["attendance"]["extra"]["manual_form"]["holiday"] / 2) ?>"  name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][EmployeeSalaryInfo][lembur_hari]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-center minwidth50" readonly value="<?= $salaryDetail["attendance"]["summary"]["jumlah_hadir"] + $salaryDetail["attendance"]["extra"]["manual_form"]["normal"] ?>"  name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][EmployeeSalaryInfo][hari_kerja]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-center minwidth50" readonly value="<?= $salaryDetail["attendance"]["summary"]["jumlah_hadir"] + ($salaryDetail["attendance"]["summary"]["jumlah_hadir_libur"] * 2) + array_sum($salaryDetail["attendance"]["extra"]["manual_form"]) ?>"  name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][EmployeeSalaryInfo][jumlah_hari_kerja]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85" readonly value="<?= ic_rupiah($salaryDetail["info"]["basic_salary"]) ?>"  name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][EmployeeSalaryInfo][gaji_pokok]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85 potongan isdecimal" readonly value="<?= ic_rupiah(e_isset(@$salaryDetail["salary"]["potongan"]["data"][$mapParameterSalary["IWP"]], 0)) ?>" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][0][nominal]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85 potongan isdecimal" readonly value="<?= ic_rupiah(e_isset(@$salaryDetail["salary"]["potongan"]["data"][$mapParameterSalary["PKI"]], 0)) ?>" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][4][nominal]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85 potongan isdecimal" readonly value="<?= ic_rupiah(e_isset(@$salaryDetail["salary"]["potongan"]["data"][$mapParameterSalary["PKS"]], 0)) ?>" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][5][nominal]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85" readonly value="<?= ic_rupiah($salaryDetail["salary"]["pendapatan"]["data"][$mapParameterSalary["LPH"]]) ?>" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][6][nominal]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85" readonly value="<?= ic_rupiah($salaryDetail["salary"]["pendapatan"]["data"][$mapParameterSalary["LPJ"]]) ?>" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][7][nominal]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85" readonly value="<?= ic_rupiah($salaryDetail["salary"]["pendapatan"]["data"][$mapParameterSalary["LPJ"]] + $salaryDetail["salary"]["pendapatan"]["data"][$mapParameterSalary["LPH"]]) ?>"  name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][EmployeeSalaryInfo][total_gaji_lembur]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85" readonly value="<?= ic_rupiah($salaryDetail["salary"]["pendapatan"]["data"][$mapParameterSalary["GPK"]]) ?>" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][8][nominal]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85" readonly value="<?= ic_rupiah($totalgaji) ?>"  name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][EmployeeSalaryInfo][total_gaji]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85 potongan isdecimal"  value="<?= ic_rupiah(e_isset(@$salaryDetail["salary"]["potongan"]["data"][$mapParameterSalary["PJS"]], 0)) ?>" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][9][nominal]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-right minwidth85 gajiditerima" readonly value="<?= ic_rupiah($totalgaji) ?>" data-totalgaji="<?= $totalgaji ?>"  name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][EmployeeSalaryInfo][total_diterima]"/></td>
                                        <td class="text-center"><input type="text" class="form-control text-center minwidth100" readonly value="<?= $this->Html->cvtTanggal($salaryDetail["info"]["join_date"], false) ?>"/>
                                            <input type="hidden" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][employee_id]" value="<?= $employeeId ?>"/>
                                            <input type="hidden" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][0][parameter_salary_id]" value="<?= $mapParameterSalary["IWP"] ?>"/>
                                            <input type="hidden" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][4][parameter_salary_id]" value="<?= $mapParameterSalary["PKI"] ?>"/>
                                            <input type="hidden" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][5][parameter_salary_id]" value="<?= $mapParameterSalary["PKS"] ?>"/>
                                            <input type="hidden" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][6][parameter_salary_id]" value="<?= $mapParameterSalary["LPH"] ?>"/>
                                            <input type="hidden" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][7][parameter_salary_id]" value="<?= $mapParameterSalary["LPJ"] ?>"/>
                                            <input type="hidden" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][8][parameter_salary_id]" value="<?= $mapParameterSalary["GPK"] ?>"/>
                                            <input type="hidden" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][ParameterEmployeeSalary][9][parameter_salary_id]" value="<?= $mapParameterSalary["PJS"] ?>"/>
                                            <?php
                                            $h = 0;
                                            foreach ($salaryDetail["relation"]["EmployeeSalaryLoan"] as $employeeSalaryLoan) {
                                                ?>
                                                <input type="hidden" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][EmployeeSalaryLoan][<?= $h ?>][employee_data_loan_id]" value="<?= $employeeSalaryLoan["id"] ?>"/>
                                                <input type="hidden" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][EmployeeSalaryLoan][<?= $h ?>][amount]" value="<?= $employeeSalaryLoan["amount"] ?>"/>
                                                <?php
                                                $h++;
                                            }
                                            ?>
                                            <?php
                                            $h = 0;
                                            foreach ($salaryDetail["relation"]["EmployeeSalarySaleProductAdditional"] as $employeeSalarySaleProductAdditional) {
                                                ?>
                                                <input type="hidden" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][EmployeeSalarySaleProductAdditional][<?= $h ?>][sale_product_additional_id]" value="<?= $employeeSalarySaleProductAdditional["id"] ?>"/>
                                                <?php
                                                $h++;
                                            }
                                            ?>
                                            <?php
                                            if ($salaryDetail["relation"]["EmployeeSalaryItemLoan"] !== false) {
                                                ?>
                                                <input type="hidden" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][EmployeeSalaryItemLoan][cooperative_item_loan_payment_detail_id]" value="<?= $salaryDetail["relation"]["EmployeeSalaryItemLoan"]["cooperative_item_loan_payment_detail_id"] ?>"/>
                                                <input type="hidden" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][EmployeeSalaryItemLoan][cooperative_item_loan_id]" value="<?= $salaryDetail["relation"]["EmployeeSalaryItemLoan"]["cooperative_item_loan_id"] ?>"/>
                                                <input type="hidden" name="data[EmployeeSalaryPeriod][EmployeeSalary][<?= $n ?>][EmployeeSalaryItemLoan][amount]" value="<?= $salaryDetail["relation"]["EmployeeSalaryItemLoan"]["amount"] ?>"/>
                                                <?php
                                            }
                                            ?>
                                        </td>
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
                <div class="text-center">
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
        $(".potongan,.pendapatan").on("change keyup paste", function () {
            var $parentTr = $(this).parents("tr");
            calculateGajiDiterima($parentTr);
        })
        $("#table-gaji").tableHeadFixer({"left": 2})
    });
    $(".autocalculate").each(function () {
        calculateGajiDiterima($(this));
    })
    function calculateGajiDiterima(e) {
        var $parentTr = e;
        var $gajiditerimaE = $parentTr.find(".gajiditerima");
        var totalgaji = $gajiditerimaE.data("totalgaji");
        var totalPotongan = 0;
        var totalPendapatan = 0;
        $parentTr.find(".potongan").each(function () {
            totalPotongan += ic_number_reverse($(this).val());
        });
        $parentTr.find(".pendapatan").each(function () {
            totalPendapatan += ic_number_reverse($(this).val());
        });
        $gajiditerimaE.val(ic_rupiah(totalgaji - totalPotongan + totalPendapatan));
    }
</script>