<?php
//echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/pension");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA GAJI PEGAWAI") ?>
                <div class="pull-right">
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete") ?>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" width="1%" bgcolor="#FFFFCC" style="color: #000;"><input type="checkbox" class="styled checkall"/></th>
                            <th class="text-center" width="1%" bgcolor="#FFFFCC" style="color: #000;">No</th>
                            <th class="text-center" width="8%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Nama") ?></th>
                            <th class="text-center" width="10%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Tipe Gaji") ?></th>
                            <th class="text-center" width="10%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Tipe Kas") ?></th>
                            <th class="text-center" width="8%" bgcolor="#FFFFCC" style="color: #000;" colspan = "2"><?= __("Jumlah Pendapatan") ?></th>
                            <th class="text-center" width="8%" bgcolor="#FFFFCC" style="color: #000;" colspan = "2"><?= __("Jumlah Potongan") ?></th>
                            <th class="text-center" width="8%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Tanggal Verifikasi") ?></th>
                            <th class="text-center" width="8%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Diverifikasi Oleh") ?></th>
                            <th class="text-center" width="8%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Status Verifikasi") ?></th>
                            <th class="text-center" width="7%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Aksi") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                        $i = ($limit * $page) - ($limit - 1);
                        if (empty($data['rows'])) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = 13>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $item['Employee']['EmployeeType']['name'] ?></td>
                                    <td class="text-center"><?= $item['InitialBalance']['name'] ?></td>
                                    <?php
                                    $totalIncome = 0;
                                    $totalDebt = 0;
                                    foreach ($item['ParameterEmployeeSalary'] as $value) {
                                        if ($value['ParameterSalary']['parameter_salary_type_id'] === '1') {
                                            $totalIncome += $value['nominal'];
                                        }
                                        if ($value['ParameterSalary']['parameter_salary_type_id'] === '2') {
                                            $totalDebt += $value['nominal'];
                                        }
                                    }
                                    ?>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp(abs($totalIncome)); ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp(abs($totalDebt)); ?></td>
                                    <td class="text-center">
                                        <?php
                                        if ($item['EmployeeSalary']['verified_datetime'] === null) {
                                            echo "-";
                                        } else {
                                            echo $this->Html->cvtTanggalWaktu($item['EmployeeSalary']['verified_datetime']);
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($item['VerifiedBy']['id'] === null) {
                                            echo "-";
                                        } else {
                                            echo $item['VerifiedBy']['Account']['Biodata']['full_name'];
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                                        <?php
                                        if ($item['EmployeeSalary']['verify_status_id'] == 2) {
                                            echo "Ditolak";
                                        } else if ($item['EmployeeSalary']['verify_status_id'] == 3) {
                                            echo "Disetujui";
                                        } else {
                                            echo $this->Html->changeStatusSelect($item['EmployeeSalary']['id'], ClassRegistry::init("VerifyStatus")->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))), $item['EmployeeSalary']['verify_status_id'], Router::url("/admin/employee_salaries/change_status_verify"), "#target-change-status$i");
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a data-toggle="modal" role="button" href="#default-view" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="" data-original-title="Lihat File" data-gaji-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>"><i class="icon-eye7"></i></a>&nbsp;
                                        <?php
                                        if ($item['EmployeeSalary']['verify_status_id'] == '3') {
                                            ?>
                                            <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Ubah" disabled><i class="icon-pencil"></i></button>
                                            <?php
                                        } else if ($item['EmployeeSalary']['verify_status_id'] == '2') {
                                            ?>
                                            <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Ubah" disabled><i class="icon-pencil"></i></button>
                                            <?php
                                        } else {
                                            if ($item['Employee']['employee_type_id'] == 2) {
                                                ?>
                                                <a href="<?= Router::url("/admin/{$this->params['controller']}/edit_bulanan/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Ubah"><i class="icon-pencil"></i></button></a>
                                                <?php
                                            } else if ($item['Employee']['employee_type_id'] == 1) {
                                                ?>
                                                <a href="<?= Router::url("/admin/{$this->params['controller']}/edit_harian/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Ubah"><i class="icon-pencil"></i></button></a>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <?php echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>

<!-- Default modal -->
<div id="default-view" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA GAJI PEGAWAI
                            <small class="display-block">PT. iLugroup Multimedia Indonesia</small>
                        </h6>
                    </div>
                    <table width="100%" class="table table-hover">
                        <tr>
                            <td colspan="11" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("EmployeeSalary.Employee.Account.Biodata.full_name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("EmployeeSalary.Employee.Account.Biodata.full_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                    ?>
                                    <?php
                                    echo $this->Form->label("EmployeeSalary.MadeBy.Account.Biodata.full_name", __("ID Pegawai"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("EmployeeSalary.MadeBy.Account.Biodata.full_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("EmployeeSalary.month", __("Periode Bulan"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("EmployeeSalary.month", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                    ?>
                                    <?php
                                    echo $this->Form->label("EmployeeSalary.year_period", __("Periode Tahun"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("EmployeeSalary.year_period", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("EmployeeSalary.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("EmployeeSalary.note", array("div" => array("class" => "col-sm-10"), "label" => false, "id" => "employeeSalaryNote", "class" => "form-control ckeditor-fix", "readonly"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("InitialBalance.name", __("Tipe Kas"), array("class" => "col-sm-3 col-md-4 control-label"));
                                    echo $this->Form->input("InitialBalance.name", array("div" => array("class" => "col-sm-9 col-md-8"), "id" => "initialBalanceName", "label" => false, "class" => "form-control", "disabled"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <!-- Justified pills -->
                    <div class="well block">
                        <div class="tabbable">
                            <ul class="nav nav-pills nav-justified">
                                <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-plus-circle"></i>Pendapatan</a></li>
                                <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-minus-circle"></i>Potongan</a></li>
                            </ul>
                            <div class="tab-content pill-content">
                                <div class="tab-pane fade in active" id="justified-pill1">
                                    <table width="100%" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <td align="center" valign="middle" width="1%">No</td>
                                                <td align="center" valign="middle" width="45%">Parameter Gaji</td>
                                                <td align="center" valign="middle" width="45%">Nominal</td>
                                            </tr>
                                        </thead>
                                        <tbody id="target-income">
                                            <tr class="dynamic-row-pendapatan hidden" data-n="0">
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="right">
                                                    <strong>Grand Total</strong>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Rp.</span>
                                                        <input type="text" class="form-control text-right auto-calculate-grand-total-income" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="left">
                                                    <strong><em>Terbilang : </em></strong><span class="target-terbilang-income"></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="justified-pill2">
                                    <table width="100%" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <td align="center" valign="middle" width="1%">No</td>
                                                <td align="center" valign="middle" width="45%">Parameter Gaji</td>
                                                <td align="center" valign="middle" width="45%">Nominal</td>
                                            </tr>
                                        </thead>
                                        <tbody id="target-debt">
                                            <tr class="dynamic-row-potongan hidden" data-n="0"></tr>
                                            <tr>
                                                <td colspan="2" align="right">
                                                    <strong>Grand Total</strong>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Rp.</span>
                                                        <input type="text" class="form-control text-right auto-calculate-grand-total-debt" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="left">
                                                    <strong><em>Terbilang : </em></strong><span class="target-terbilang-debt"></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /justified pills -->
                </div>
                <!-- /new invoice template -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /default modal -->

<script>
    $(document).ready(function () {
        $('.viewData').click(function () {
            $("tr.dynamic-row-pendapatan").html("");
            $("tr.dynamic-row-potongan").html("");
            var gajiId = $(this).data("gaji-id");
            var e = $("tr.dynamic-row-pendapatan");
            var f = $("tr.dynamic-row-potongan");
            fixNumberPendapatan(e.parents("tbody"));
            fixNumberPotongan(f.parents("tbody"));
            var totalPendapatan = 0;
            var totalPotongan = 0;
            $.ajax({
                url: BASE_URL + "/employee_salaries/view_data_gaji/" + gajiId,
                dataType: "JSON",
                type: "GET",
                data: {},
                success: function (data) {
                    // Data Gaji Pegawai
                    $('input#EmployeeSalaryEmployeeAccountBiodataFullName').val(data.Employee.Account.Biodata.full_name);
                    $('input#EmployeeSalaryMadeByAccountBiodataFullName').val(data.MadeBy.Account.Biodata.full_name);
                    $('input#EmployeeSalaryMonth').val(getNamaBulan((data.EmployeeSalary.month_period) - 1));
                    $('input#EmployeeSalaryYearPeriod').val(data.EmployeeSalary.year_period);
//                    $('#employeeSalaryNote').val(data.EmployeeSalary.note);
                    CKEDITOR.instances['employeeSalaryNote'].setData(data.EmployeeSalary.note);
                    $('#initialBalanceName').val(data.InitialBalance.name);

                    // Data Pendapatan dan Pemotongan
                    var emp = data.ParameterEmployeeSalary;
                    var i = 1;
                    var j = 1;
                    $.each(emp, function (index, value) {
                        if (parseInt(value.nominal) >= 0) {
                            totalPendapatan += parseInt(value.nominal);
                            var parameter = value.ParameterSalary.name;
                            var nominal = IDR(value.nominal);

                            var n = e.data("n");
                            var template = $('#tmpl-income').html();
                            Mustache.parse(template);
                            var options = {i: i, n: n, parameter: parameter, nominal: nominal};
                            i++;
                            var rendered = Mustache.render(template, options);
                            $('#target-income tr.dynamic-row-pendapatan:last').after(rendered);
                            e.data("n", n + 1);
                        } else if (parseInt(value.nominal) < 0) {
                            totalPotongan += parseInt((value.nominal) * -1);
                            var parameter = value.ParameterSalary.name;
                            var nominal = IDR(Math.abs(value.nominal));

                            var n = f.data("n");
                            var template = $('#tmpl-debt').html();
                            Mustache.parse(template);
                            var options = {j: j, n: n, parameter: parameter, nominal: nominal};
                            j++;
                            var rendered = Mustache.render(template, options);
                            $('#target-debt tr.dynamic-row-potongan:last').after(rendered);
                            f.data("n", n + 1);
                        }
                    });

                    $("input.auto-calculate-grand-total-income").val(IDR(totalPendapatan));
                    $("input.auto-calculate-grand-total-debt").val(IDR(totalPotongan));
                    $(".target-terbilang-income").html(terbilang(totalPendapatan + "") + " rupiah");
                    $(".target-terbilang-debt").html(terbilang(totalPotongan + "") + " rupiah");
                }
            });
        });
    });

    function fixNumberPendapatan(e) {
        var i = 1;
        $.each(e.find("tr.dynamic-row-pendapatan").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }

    function fixNumberPotongan(f) {
        var j = 1;
        $.each(f.find("tr.dynamic-row-potongan").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(j);
            j++;
        })
    }
</script>

<script type="x-tmpl-mustache" id="tmpl-income">
    <tr class="dynamic-row-pendapatan">
    <td class="text-center nomorIdx">{{i}}</td>
    <td>
    <input name="data[ParameterEmployeeSalary][{{n}}][ParameterSalary][name]" class="form-control" value="{{parameter}}" readonly>                                
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input name="data[ParameterEmployeeSalary][{{n}}][nominal]" class="form-control text-right Nominal" value="{{nominal}}" readonly>
    </div>
    </td>
    </tr>
</script>

<script type="x-tmpl-mustache" id="tmpl-debt">
    <tr class="dynamic-row-potongan">
    <td class="text-center nomorIdx">{{j}}</td>
    <td>
    <input name="data[ParameterEmployeeSalary][{{n}}][ParameterSalary][name]" class="form-control" value="{{parameter}}" readonly>                                
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input name="data[ParameterEmployeeSalary][{{n}}][nominal]" class="form-control text-right Nominal" value="{{nominal}}" readonly>
    </div>
    </td>
    </tr>
</script>