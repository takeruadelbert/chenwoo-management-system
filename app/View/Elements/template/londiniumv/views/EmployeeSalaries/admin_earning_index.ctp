<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/earning");
?>
<div class="row">
    <div class="col-md-12">
        <!-- /separated form outside panel -->
        <!-- Shipping method -->
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("REKAP PENGHASILAN") ?> 
                        <div class="pull-right">
                            <button class="btn btn-xs btn-default" title="Print Data" type="button" onclick="exp('print', '<?php echo Router::url("earning_index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                                <i class="icon-print2"></i>
                                Print
                            </button>&nbsp;
                        </div>
                        <small class="display-block">Periode Tahun : <strong><?= date('Y', strtotime(date("Y-m-01"))); ?></strong></small>
                    </h6>
                </div>
                <div class="table-responsive stn-table-nowrap">
                    <table width="100%" class="table table-bordered">
                        <tbody><tr>
                                <td width="2%" rowspan="2"><a href="<?= Router::url($this->Session->read("credential.admin.User.profile_picture"), true) ?>" class="lightbox" title="<?= $this->Session->read("credential.admin.Biodata.full_name") ?>"><img src="<?= Router::url($this->Session->read("credential.admin.User.profile_picture"), true) ?>" width="40px" alt="" class="img-media"></a></td>
                                <td width="15%"><?= __("Nama Pegawai") ?></td>
                                <td width="1%" align="center" valign="middle">:</td>
                                <td width="34%"><?= $this->Session->read("credential.admin.Biodata.full_name"); ?></td>
                                <td width="15%"><?= __("Department") ?></td>
                                <td width="1%" align="center">:</td>
                                <td width="34%"><?= $this->Session->read("credential.admin.Employee.Department.name"); ?></td>
                            </tr>
                            <tr>
                                <td><?= __("Jabatan") ?></td>
                                <td align="center" valign="middle">:</td>
                                <td><?= $this->Session->read("credential.admin.Employee.Office.name"); ?></td>
                                <td><?= __("Periode Laporan") ?></td>
                                <td align="center">:</td>
                                <td>
                                    <?php
                                    if (isset($this->request->query["awalint_EmployeeSalary_month_period"]) && isset($this->request->query["akhirint_EmployeeSalary_month_period"]) && isset($this->request->query["awalint_EmployeeSalary_year_period"]) && isset($this->request->query["akhirint_EmployeeSalary_year_period"])) {
                                        echo date('F Y', strtotime($this->request->query["awalint_EmployeeSalary_year_period"] . "-" . $this->request->query["awalint_EmployeeSalary_month_period"] . "-01")) . " s/d " . date('F Y', strtotime($this->request->query["akhirint_EmployeeSalary_year_period"] . "-" . $this->request->query["akhirint_EmployeeSalary_month_period"] . "-01"));
                                    } else {
                                        echo date('F Y', strtotime(date("Y-m-01")));
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <div class="table-responsive pre-scrollable">
                        <table width="100%" class="table table-hover table-bordered">
                            <thead>
                                <tr height="50px">
                                    <th class="text-center" width="10" align="center" valign="middle" bgcolor="#FFFFCC">No</th>
                                    <th class="text-center"  bgcolor="#FFFFCC"><?= __("Periode") ?></th>
                                    <th class="text-center" colspan="2" bgcolor="#FFFFCC"><?= __("Jumlah Pendapatan") ?></th>
                                    <th class="text-center" colspan="2" bgcolor="#FFFFCC"><?= __("Jumlah Potongan") ?></th>
                                    <th class="text-center" colspan="2" bgcolor="#FFFFCC"><?= __("Gaji Diterima") ?></th>
                                    <th class="text-center" bgcolor="#FFFFCC"><?= __("Divalidasi") ?></th>
                                    <th class="text-center" width="10" bgcolor="#FFFFCC"><?= __("Aksi") ?></th>
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
                                        <td class = "text-center" colspan ="10">Tidak Ada Data</td>
                                    </tr>
                                    <?php
                                } else {
                                    foreach ($data['rows'] as $item) {
                                        ?>
                                        <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                            <td class="text-center" align="center" valign="middle"><?= $i ?></td>
                                            <td class="text-center"><?= $this->Html->cvtTanggal($item['EmployeeSalary']['start_date_period'], false) ?> - <?= $this->Html->cvtTanggal($item['EmployeeSalary']['end_date_period'], false) ?></td>
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
                                            <td class="text-center" align="center" valign="middle" width = "50">Rp.</td>
                                            <td class="text-center" align="center" valign="middle" width = "150"><?= $this->Html->IDR($totalIncome); ?></td>
                                            <td class="text-center" align="center" valign="middle" width = "50">Rp.</td>
                                            <td class="text-center" align="center" valign="middle" width = "150"><?= $this->Html->IDR($totalDebt * -1); ?></td>
                                            <td class="text-center" align="center" valign="middle" width = "50"><strong>Rp.</strong></td>
                                            <td class="text-center" align="center" valign="middle" width = "150"><strong><?= $this->Html->IDR(($totalIncome + $totalDebt)); ?></strong></td>
                                            <td align="center" valign="middle">
                                                <?php
                                                if ($item['ValidateBy']['id'] === null) {
                                                    ?>
                                                    <strong>-</strong>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <strong>di Validasi Oleh <?= @$item['ValidateBy']['Account']['Biodata']['full_name']; ?><br><?= $this->Html->cvtTanggalWaktu($item['EmployeeSalary']['validate_datetime'], false); ?></strong>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <a data-toggle="modal" role="button" href="#default-view" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="" data-original-title="Lihat Data" data-gaji-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>"><i class="icon-eye7"></i></a>&nbsp;
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /shipping method -->

                </div>
                <!-- Shipping method -->

            </div>
            <!-- /page content -->
        </div>
    </div>
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
                beforeSend: function (xhr) {
                    ajaxLoadingStart();
                },
                success: function (data) {
                    // Data Gaji Pegawai
                    $('input#EmployeeSalaryEmployeeAccountBiodataFullName').val(data.Employee.Account.Biodata.full_name);
                    $('input#EmployeeSalaryMadeByAccountBiodataFullName').val(data.MadeBy.Account.Biodata.full_name);
                    $('input#EmployeeSalaryMonth').val(getNamaBulan((data.EmployeeSalary.month_period) - 1));
                    $('input#EmployeeSalaryYearPeriod').val(data.EmployeeSalary.year_period);
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

                    $("input.auto-calculate-grand-total-income").val(IDR(totalPendapatan));
                    $("input.auto-calculate-grand-total-debt").val(IDR(totalPotongan));
                    $(".target-terbilang-income").html(terbilang(totalPendapatan + "") + " rupiah");
                    $(".target-terbilang-debt").html(terbilang(totalPotongan + "") + " rupiah");
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