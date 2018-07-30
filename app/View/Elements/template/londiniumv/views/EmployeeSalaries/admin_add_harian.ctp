<?php echo $this->Form->create("EmployeeSalary", array("class" => "form-horizontal form-separate", "action" => "add_harian", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("FORM GAJI PEGAWAI HARIAN") ?>
                    <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                </h6>
            </div>
            <div class="well block">
                <div class="tabbable">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active" id="tab-step1"><a href="#data-pegawai" data-toggle="tab"><i class="icon-people"></i> Data Pegawai</a></li>
                        <li id="tab-step2"><a href="#data-gaji" data-toggle="tab"><i class="icon-file6"></i> Rincian Gaji</a></li>
                    </ul>
                    <div class="tab-content pill-content" id="tabs">
                        <div class="tab-pane fade in active" id="data-pegawai">
                            <table width="100%" class="table table-hover">
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("EmployeeSalary.employee_id", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("EmployeeSalary.employee_id", array("div" => false, "label" => false, "type" => "hidden"));
                                            ?>
                                            <div class="col-sm-4 has-feedback">
                                                <input type="text" placeholder="Silahkan Cari Nama Pegawai" class="form-control typeahead-ajax-employee">
                                                <i class="icon-search3 form-control-feedback"></i>
                                            </div>
                                            <?php
                                            echo $this->Form->label("Dummy.MadeBy.Account.Biodata.full_name", __("ID Pegawai Login"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.MadeBy.Account.Biodata.full_name", array("div" => array("class" => "col-sm-4"), "label" => false, "value" => $this->Session->read("credential.admin.Biodata.full_name"), "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("EmployeeSalary.start_date_period", __("Periode Tanggal Awal"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("EmployeeSalary.start_date_period", array("div" => array("class" => "col-sm-4"), "id" => "startDate", "type" => "text", "label" => false, "class" => "form-control datepicker"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("EmployeeSalary.end_date_period", __("Periode Tanggal Akhir"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("EmployeeSalary.end_date_period", array("div" => array("class" => "col-sm-4"), "id" => "endDate", "type" => "text", "label" => false, "class" => "form-control datepicker"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-actions text-center">
                                        <input name="Button" type="button" onclick="step2()" class="btn btn-info" value="<?= __("Next") ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade in" id="data-gaji">

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
                                                        <td align="center" valign="middle">Aksi</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="target-income">
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4" align="left">
                                                            <a class="text-success clickincome" href="javascript:void(false)" onclick="addThisRow($(this), 'income')"><i class="icon-plus-circle"></i></a>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="justified-pill2">
                                            <table width="100%" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <td align="center" valign="middle" width="1%">No</td>
                                                        <td align="center" valign="middle" width="45%">Parameter Gaji</td>
                                                        <td align="center" valign="middle" width="45%">Nominal</td>
                                                        <td align="center" valign="middle">Aksi</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="target-debt">
                                                </tbody>
                                                <tfooot>
                                                    <tr>
                                                        <td colspan="4" align="left">
                                                            <a class="text-success clickdebt" href="javascript:void(false)" onclick="addThisRow($(this), 'debt')"><i class="icon-plus-circle"></i></a>
                                                        </td>
                                                    </tr>
                                                </tfooot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Total Pendapatan</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control text-right auto-calculate-grand-total-income rupiah-field" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Total Potongan</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control text-right auto-calculate-grand-total-debt rupiah-field" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Grand Total</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control text-right auto-calculate-grand-total rupiah-field" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php
                                echo $this->Form->label("EmployeeSalary.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                echo $this->Form->input("EmployeeSalary.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix", "placeholder" => "Enter text ..."));
                                ?>
                            </div>
                            <div class="form-actions text-center">
                                <input name="Button" type="button" onclick="step1();" class="btn btn-success" value="<?= __("Kembali") ?>">
                                <input type="reset" value="Reset" class="btn btn-info">
                                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                                    <?= __("Simpan") ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<input type="hidden" value="0" id="nrow"/>
<script>
    var employee = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/employees/list_bulanan/1", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/employees/list_bulanan/1", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });

    employee.clearPrefetchCache();
    employee.initialize(true);
    $(document).ready(function () {
        disableStep2();
        Handlebars.registerHelper('isSelected', function (parameterSalaryOption, parameterSalarySelected) {
            if (parameterSalaryOption === parameterSalarySelected) {
                return true;
            } else {
                return false;
            }
        });
        reloadSelect2();
        reloadisdecimal();
//        addThisRow(".income", "income");
//        addThisRow(".debt", "debt");
        listenerTotalHargaParameterEmployeeSalary();
        getEmployeeTypeahead();
    });

    function getEmployeeTypeahead() {
        $('input.typeahead-ajax-employee').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'employee',
            display: 'full_name',
            source: employee.ttAdapter(),
            templates: {
                header: '<center><h5>Data Pegawai</h5></center><hr>',
                suggestion: function (data) {
                    return '<p> Nama : ' + data.full_name + '<br/> NIP Pegawai : ' + data.nip + '<br/> Department : ' + data.department + '<br/> Position : ' + data.jabatan + '</p>';
                },
                empty: [
                    "<center><h5>Data Pegawai</h5></center> <hr> <center><p>Hasil pencarian Anda tidak dapat ditemukan<p></center>",
                ],
            }
        });
        $('input.typeahead-ajax-employee').bind('typeahead:select', function (ev, data) {
            $('input#EmployeeSalaryEmployeeId').val(data.id);
        });
    }

    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
        $("input.ParameterEmployeeSalaryNominalIncome").trigger("change");
        $("input.ParameterEmployeeSalaryNominalDebt").trigger("change");
    }

    var list_parameter_salary_income =<?= $this->Engine->toJSONoptions($incomeParameterSalaries, "- Pilih -") ?>;
    var list_parameter_salary_debt =<?= $this->Engine->toJSONoptions($debtParameterSalaries, "- Pilih -") ?>;

    function addThisRow(e, t, optFunc) {
        var n = $("#nrow").val();
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var list_parameter_salary = null;
        if (t == "income") {
            list_parameter_salary = list_parameter_salary_income;
        } else if (t == "debt") {
            list_parameter_salary = list_parameter_salary_debt;
        }
        var options = {
            i: 2,
            n: n,
            list_volume: list_parameter_salary
        };
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t).append(rendered);
        var n = $("#nrow").val(n + 1);
        fixNumber($('#target-' + t));
        listenerTotalHargaParameterEmployeeSalary();
        reloadSelect2();
        reloadisdecimal();
    }

    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr.dynamic-row").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }

    function listenerTotalHargaParameterEmployeeSalary() {
        $("input.ParameterEmployeeSalaryNominalIncome").on("keyup mouseup change", function () {
            calculatetotalincome();
        });
        $("input.ParameterEmployeeSalaryNominalDebt").on("keyup mouseup change", function () {
            calculatetotaldebt();
        });
    }

    function calculatetotalincome() {
        var grandTotalIncome = 0;
        $('input.ParameterEmployeeSalaryNominalIncome').each(function () {
            var $thisGrandTotalIncome = String($(this).val());
            grandTotalIncome += parseInt(ic_number_reverse($thisGrandTotalIncome));
        });
        $("input.auto-calculate-grand-total-income").val(IDR(grandTotalIncome));
        $(".target-terbilang-income").html(terbilang(grandTotalIncome + "") + " rupiah");
        calculategrandtotal();
    }

    function calculatetotaldebt() {
        var grandTotalDebt = 0;
        $('input.ParameterEmployeeSalaryNominalDebt').each(function () {
            var $thisGrandTotalDebt = String($(this).val());
            grandTotalDebt += parseInt(ic_number_reverse($thisGrandTotalDebt));
        });
        $("input.auto-calculate-grand-total-debt").val(IDR(grandTotalDebt));
        $(".target-terbilang-debt").html(terbilang(grandTotalDebt + "") + " rupiah");
        calculategrandtotal();
    }

    function calculategrandtotal() {
        var grandTotalIncome = ic_number_reverse($("input.auto-calculate-grand-total-income").val());
        var grandTotalDebt = ic_number_reverse($("input.auto-calculate-grand-total-debt").val());
        $("input.auto-calculate-grand-total").val(ic_rupiah(grandTotalIncome - grandTotalDebt));
    }

    function getSalaryDetail() {
        var employeeId = $("#EmployeeSalaryEmployeeId").val();
        var startDate = $("input[name='data[EmployeeSalary][start_date_period]']").val();
        var endDate = $("input[name='data[EmployeeSalary][end_date_period]']").val();
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: BASE_URL + "admin/employees/salary_detail_harian?employee_id=" + employeeId + "&start_date=" + startDate + "&end_date=" + endDate,
            beforeSend: function (xhr) {
                ajaxLoadingStart();
            },
            success: function (response) {
                $.each(response.data.salary.pendapatan.data, function (code, amount) {
                    addThisRow($(".clickincome"), "income");
                    $(".tipegajiincome").last().select2("val", code);
                    $(".jumlahgajiincome").last().val(amount);
                });
                n = 0;
                $.each(response.data.salary.potongan.data, function (code, amount) {
                    addThisRow($(".clickdebt"), "debt");
                    $(".tipegajidebt").last().select2("val", code);
                    $(".jumlahgajidebt").last().val(amount);
                });
                calculatetotalincome();
                calculatetotaldebt();
                reloadisdecimal();
                ajaxLoadingSuccess();
            },
        })
    }

    function step1() {
        disableStep2();
        enableStep1();
        gotoTab1();
    }

    function step2() {
        if (proceedToStep2()) {
            getSalaryDetail();
            disableStep1();
            enableStep2();
            gotoTab2();
        }
    }

    function disableStep1() {
        $("#tab-step1").addClass("disabled");
        $("#tab-step1 a").on("click", function (e) {
            return false;
        });
    }

    function disableStep2() {
        $("#tab-step2").addClass("disabled");
        $("#tab-step2 a").on("click", function (e) {
            return false;
        });
    }

    function enableStep1() {
        $("#tab-step1").removeClass("disabled");
        $("#tab-step1 a").unbind("click");
    }

    function enableStep2() {
        $("#tab-step2").removeClass("disabled");
        $("#tab-step2 a").unbind("click");
    }

    function gotoTab1() {
        $("#tab-step1 a").trigger("click");
    }
    function gotoTab2() {
        $("#tab-step2 a").trigger("click");
    }

    function proceedToStep2() {
        if ($("#EmployeeSalaryEmployeeId").val() == "") {
            notif("warning", "Pegawai belum dipilih", "growl")
            return false;
        } else {
            if ($("input[name='data[EmployeeSalary][start_date_period]']").val() == "") {
                notif("warning", "Periode tanggal awal belum diisi", "growl");
                return false;
            }
            if ($("input[name='data[EmployeeSalary][end_date_period]']").val() == "") {
                notif("warning", "Periode tanggal akhir belum diisi", "growl");
                return false;
            }
            if ($("input[name='data[EmployeeSalary][start_date_period]']").val() >= $("input[name='data[EmployeeSalary][end_date_period]']").val()) {
                notif("warning", "Periode tanggal awal harus lebih kecil dari akhir", "growl");
                return false;
            }
            return true;
        }
    }
</script>

<script type="x-tmpl-mustache" id="tmpl-income">
    <tr class="dynamic-row income">
    <td class="text-center nomorIdx">{{i}}</td>
    <td align="center" width="10%">
    <select name="data[ParameterEmployeeSalary][{{n}}][parameter_salary_id]" class="select-full tipegajiincome" id="ParameterEmployeeSalary{{n}}ParameterSalaryId" required="required">
    {{#list_volume}}
    <option value="{{value}}">{{label}}</option>    
    {{/list_volume}}
    </select>
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input name="data[ParameterEmployeeSalary][{{n}}][nominal]" class="form-control text-right ParameterEmployeeSalaryNominalIncome isdecimal jumlahgajiincome" step="1" type="text" id="ParameterEmployeeSalary{{n}}Nominal" required="required">
    <span class="input-group-addon">,00.</span>
    </div>
    </td>
    <td align="center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))">
    <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Hapus">
    <i class="icon-remove3"></i>
    </button>
    </a>
    </td>
    </tr>
</script>

<script type="x-tmpl-mustache" id="tmpl-debt">
    <tr class="dynamic-row debt">
    <td class="text-center nomorIdx">{{i}}</td>
    <td align="center" width="10%">
    <select name="data[ParameterEmployeeSalary][{{n}}][parameter_salary_id]" class="select-full tipegajidebt" id="ParameterEmployeeSalary{{n}}ParameterSalaryId" required="required" {{is_disabled}}>
    {{#list_volume}}
    <option value="{{value}}">{{label}}</option>
    {{/list_volume}}
    </select>
    <div id="hiddenField{{n}}"></div>
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input name="data[ParameterEmployeeSalary][{{n}}][nominal]" class="form-control text-right ParameterEmployeeSalaryNominalDebt isdecimal jumlahgajidebt" step="1" type="text" id="ParameterEmployeeSalary{{n}}Nominal" required="required" {{is_readonly}}>
    <span class="input-group-addon">,00.</span>
    </div>
    </td>
    <td align="center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))">
    <button type="button" class="btn btn-default btn-xs btn-icon tip delete{{n}}" title="Hapus">
    <i class="icon-remove3"></i>
    </button>
    </a>
    </td>
    </tr>
</script>