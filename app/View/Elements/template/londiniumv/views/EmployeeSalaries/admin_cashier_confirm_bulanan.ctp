<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/validate-salary");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("PEMBAYARAN GAJI BULANAN") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" title="Print Data" type="button" onclick="exp('print', '<?php echo Router::url("validate_index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i>
                        Print
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" title="Ekspor Ke Excel" type="button" onclick="exp('excel', '<?php echo Router::url("validate_index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" width="1%" bgcolor="#FFFFCC" style="color: #000;"><input type="checkbox" class="styled checkall"/></th>
                            <th class="text-center" width="1%" bgcolor="#FFFFCC" style="color: #000;">No</th>
                            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;"><?= __("Nama") ?></th>
                            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;"><?= __("Tipe Gaji") ?></th>
                            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;"><?= __("Periode Penggajian") ?></th>
                            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;" colspan = "2"><?= __("Jumlah Pendapatan") ?></th>
                            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;" colspan = "2"><?= __("Jumlah Potongan") ?></th>
                            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;" colspan = "2"><?= __("Total") ?></th>
                            <th class="text-center" bgcolor="#FFFFCC" style="color: #000;"><?= __("Tanggal Bayar") ?></th>
                            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;"><?= __("Dibayar Oleh") ?></th>
                            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;"><?= __("Status Pembayaran") ?></th>
                            <th class="text-center"  bgcolor="#FFFFCC" style="color: #000;" width = "120"><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan = "15">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $item['Employee']['EmployeeType']['name'] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($item['EmployeeSalary']['start_date_period'], false) ?> - <?= $this->Html->cvtTanggal($item['EmployeeSalary']['end_date_period'], false) ?></td>
                                    <?php
                                    $totalIncome = 0;
                                    $totalDebt = 0;
                                    if (!empty($item['ParameterEmployeeSalary'])) {
                                        foreach ($item['ParameterEmployeeSalary'] as $value) {
                                            if ($value['ParameterSalary']['parameter_salary_type_id'] === '1') {
                                                $totalIncome += $value['nominal'];
                                            }
                                            if ($value['ParameterSalary']['parameter_salary_type_id'] === '2') {
                                                $totalDebt += $value['nominal'];
                                            }
                                        }
                                    }
                                    ?>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" ><?= ic_rupiah($totalIncome); ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" ><?= ic_rupiah(abs($totalDebt)); ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" ><?= ic_rupiah($totalIncome + $totalDebt); ?></td>
                                    <td class="text-center valid-date-<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>">
                                        <?php
                                        if ($item['EmployeeSalary']['confirmed_date_by_cashier_operator'] === null) {
                                            echo "-";
                                        } else {
                                            echo $this->Html->cvtTanggalWaktu($item['EmployeeSalary']['confirmed_date_by_cashier_operator']);
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center valid-by-<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>">
                                        <?php
                                        if ($item['CashierOperator']['id'] === null) {
                                            echo "-";
                                        } else {
                                            echo $item['CashierOperator']['Account']['Biodata']['full_name'];
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center target-change-status-<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>"><?= $item['EmployeeSalaryCashierStatus']['name'] ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" role="button" href="#default-view" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="" data-original-title="Lihat Data" data-gaji-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>"><i class="icon-eye7"></i></a>&nbsp;
                                        <?php
                                        if ($item['EmployeeSalary']['employee_salary_cashier_status_id'] == 1 && $item['EmployeeSalary']['validate_status_id'] == 2) {
                                            ?>
                                            <a id="confirmbutton-<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" data-toggle="modal" role="button" href="#confirmation-salary" class="btn btn-default btn-xs btn-icon btn-icon tip confirmSalary" title="" data-original-title="Bayar Gaji" data-gaji-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>"><i class="icon-coin"></i></a>&nbsp;
                                            <?php
                                        }
                                        ?>
                                        <a target="_blank" href="<?= Router::url("/admin/{$this->params['controller']}/print_employee_salary/{$item[Inflector::classify($this->params['controller'])]['id']}", true) ?>" class="btn btn-default btn-xs btn-icon btn-icon tip" title="Print Slip Gaji"><i class="icon-print2"></i></a>
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
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
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
                                    echo $this->Form->label("EmployeeSalary.MadeBy.Account.Biodata.full_name", __("Dibuat Oleh"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("EmployeeSalary.MadeBy.Account.Biodata.full_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("EmployeeSalary.period", __("Periode Penggajian"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("EmployeeSalary.period", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("EmployeeSalary.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                    ?>
                                    <div id ="EmployeeSalaryNote" style = "padding-top:10px !important;padding-left:165px !important;">
                                    </div>
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="well block">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Total Pendapatan</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control text-right income-total rupiah-field" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Total Potongan</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control text-right debt-total rupiah-field" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Total Diterima</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control text-right grand-total rupiah-field" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /justified pills -->
                    </div>
                    <div class="well block">
                        <div class="row">
                            <div class="col-md-12">
                                <strong><em>Terbilang : </em></strong><span class="target-terbilang"></span>
                            </div>
                        </div>
                    </div>
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

<!-- Employee Salary Confirmation -->
<div id="confirmation-salary" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg-6">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="close">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">KONFIRMASI GAJI PEGAWAI
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <table width="100%" class="table table-hover">
                        <tr>
                            <td colspan="11" style="width:200px">
                                <div class="form-group form-horizontal">
                                    <?php
                                    echo $this->Form->label("EmployeeSalary.initial_balance_id", __("Kas yang digunakan"), array("class" => "col-sm-4 control-label"));
                                    echo $this->Form->input("EmployeeSalary.initial_balance_id", array("div" => array("class" => "col-sm-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Kas -", "id" => "initialBalance"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal" id="closeForm">Tutup Form</button>
                    <button type="button" class="btn btn-success save" data-dismiss="modal">Simpan</button>
                </div>
            </div>
            <!-- /new invoice template -->
        </div>
    </div>
</div>
<!-- /Employee Salary Confirmation -->

<script>
    $(document).ready(function () {
        $(".confirmSalary").click(function () {
            var salaryId = $(this).data("gaji-id");
            $(".save").click(function () {
                var initialBalanceId = $("#initialBalance").val();
                if (initialBalanceId != "" && initialBalanceId != null) {
                    $.ajax({
                        url: BASE_URL + "admin/employee_salaries/cashier_confirm/" + salaryId + "/" + initialBalanceId,
                        type: "PUT",
                        dataType: "JSON",
                        data: {},
                        beforeSend: function (xhr) {
                            ajaxLoadingStart();
                            $(".save").unbind("click");
                        },
                        success: function (response) {
                            if (response.status == 200) {
                                $(".target-change-status-" + salaryId).html("Sudah Dibayar");
                                $(".valid-by-" + salaryId).html(response.data.CashierOperator.Account.Biodata.full_name);
                                $(".valid-date-" + salaryId).html(cvtWaktu(response.data.EmployeeSalary.confirmed_date_by_cashier_operator));
                                $("#confirmbutton-" + salaryId).remove();
                                notif("notice", response.message, "growl");
                            } else if(response.status == 407) {
                                notif("warning", "Uang Kas Tidak Cukup", "growl");
                            } else {
                                notif("warning", "Pembayaran Gagal. Terdapat Kesalahan Pada Saat Proses Pembayaran.", "growl")
                            }
                            ajaxLoadingSuccess();
                        }
                    });
                }
            });
            $("#closeForm, #close").click(function() {
                $(".save").unbind("click");
            });
        });

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
                beforeSend: function (xhr) {
                    ajaxLoadingStart();
                },
                success: function (data) {
                    // Data Gaji Pegawai
                    $('input#EmployeeSalaryEmployeeAccountBiodataFullName').val(data.Employee.Account.Biodata.full_name);
                    $('input#EmployeeSalaryMadeByAccountBiodataFullName').val(data.MadeBy.Account.Biodata.full_name);
                    var tanggal = cvtTanggal(data.EmployeeSalary.start_date_period) + " - " + cvtTanggal(data.EmployeeSalary.end_date_period);
                    $('input#EmployeeSalaryPeriod').val(tanggal);
//                    $('input#EmployeeSalaryMonth').val(getNamaBulan((data.EmployeeSalary.month_period) - 1));
//                    $('input#EmployeeSalaryYearPeriod').val(data.EmployeeSalary.year_period);
                    $('#EmployeeSalaryNote').html(data.EmployeeSalary.note);

                    // Data Pendapatan dan Pemotongan
                    var emp = data.ParameterEmployeeSalary;
                    var i = 1;
                    var j = 1;
                    $.each(emp, function (index, value) {
                        if (value.ParameterSalary.parameter_salary_type_id == 1) {
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
                        } else if (value.ParameterSalary.parameter_salary_type_id == 2) {
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

                    $("input.grand-total").val(IDR(totalPendapatan - totalPotongan));
                    $("input.debt-total").val(IDR(totalPotongan));
                    $("input.income-total").val(IDR(totalPendapatan));
                    $(".target-terbilang").html(terbilang((totalPendapatan - totalPotongan) + "") + " rupiah");
                    ajaxLoadingSuccess();
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