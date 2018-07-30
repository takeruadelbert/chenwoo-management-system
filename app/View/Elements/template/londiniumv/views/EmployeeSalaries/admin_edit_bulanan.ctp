<?php echo $this->Form->create("EmployeeSalary", array("class" => "form-horizontal form-separate", "action" => "edit_bulanan", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM SETUP GAJI") ?>
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <table width="100%" class="table table-hover">
            <tr>
                <td colspan="11" style="width:200px">
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("EmployeeSalary.employee_id", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                        echo $this->Form->input("EmployeeSalary.employee_id", array("div" => false, "label" => false, "type" => "hidden"));
                        ?>
                        <div class="col-sm-4 has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nama Pegawai" class="form-control typeahead-ajax-employee" value="<?= !empty($this->data['Employee']['id']) ? $this->data['Employee']['Account']['Biodata']['full_name'] : "" ?>">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                        <?php
                        echo $this->Form->label("Dummy.MadeBy.Account.Biodata.full_name", __("ID Pegawai"), array("class" => "col-sm-2 control-label"));
                        echo $this->Form->input("Dummy.MadeBy.Account.Biodata.full_name", array("div" => array("class" => "col-sm-4"), "label" => false, "value" => $this->Session->read("credential.admin.Biodata.full_name"), "class" => "form-control", "disabled"));
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="width:200px">
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("EmployeeSalary.month_period", __("Periode Bulan"), array("class" => "col-sm-2 control-label"));
                        echo $this->Form->input("EmployeeSalary.month_period", array("div" => array("class" => "col-sm-4"), "label" => false, "options" => $this->Echo->periodeBulan(), "class" => "select-full EmployeeSalaryMonthPeriod", "data-placeholder" => "- Pilih Periode Bulan -", "empty" => ""));
                        ?>
                        <?php
                        echo $this->Form->label("EmployeeSalary.year_period", __("Periode Tahun"), array("class" => "col-sm-2 control-label"));
                        echo $this->Form->input("EmployeeSalary.year_period", array("div" => array("class" => "col-sm-4"), "label" => false, "options" => $this->Echo->periodeTahun(), "class" => "select-full EmployeeSalaryYearPeriod", "data-placeholder" => "- Pilih Periode Tahun -", "empty" => ""));
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="width:200px">
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("EmployeeSalary.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                        echo $this->Form->input("EmployeeSalary.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix", "placeholder" => "Enter text ..."));
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="width:200px">
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("EmployeeSalary.initial_balance_id", __("Tipe Kas"), array("class" => "col-sm-3 col-md-4 control-label"));
                        echo $this->Form->input("EmployeeSalary.initial_balance_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "data-placeholder" => "- Pilih Tipe Kas -", "empty" => ""));
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
                        <div class="hidden nHolder" data-n="<?= count($this->data['ParameterEmployeeSalary']) ?>"></div>
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
                                <tr class="dynamic-row income">
                                    <?php
                                    $i = 1;
                                    $totalIncome = 0;
                                    if (!empty($this->data['ParameterEmployeeSalary'])) {
                                        foreach ($this->data['ParameterEmployeeSalary'] as $k => $incomes) {
                                            if ($incomes['ParameterSalary']['parameter_salary_type_id'] == 1) {
                                                ?>
                                            <tr class="dynamic-row">
                                                <td class="text-center nomorIdx"><?= $i ?></td>
                                                <td align="center" width="10%">

                                                    <?php
                                                    echo $this->Form->input("ParameterEmployeeSalary.$k.id", array("type" => "hidden", "value" => $incomes['id']));
                                                    ?>
                                                    <select name="data[ParameterEmployeeSalary][<?= $k ?>][parameter_salary_id]" class="select-full" required="required">
                                                        <?php
                                                        $isSelected = "";
                                                        foreach ($incomeParameterSalaries as $v => $income_options) {
                                                            if ($v == $incomes['ParameterSalary']['id']) {
                                                                $isSelected = "selected";
                                                            } else {
                                                                $isSelected = "";
                                                            }
                                                            ?>
                                                            <option value="<?= $v ?>" <?= $isSelected ?>><?= $income_options ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Rp.</span>
                                                        <input name="data[ParameterEmployeeSalary][<?= $k ?>][nominal]" class="form-control text-right ParameterEmployeeSalaryNominalIncome isdecimal" step="1" type="text" required="required" value="<?= $incomes['nominal'] ?>">
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
                                            <?php
                                            $totalIncome += $incomes['nominal'];
                                            $i++;
                                        }
                                    }
                                }
                                ?>
                                </tr>
                                <tr>
                                    <td colspan="4" align="left">
                                        <a class="text-success firstrunclickincome" href="javascript:void(false)" onclick="addThisRow($(this), 'income')"><i class="icon-plus-circle"></i></a>
                                    </td>
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
                                    <td align="center">&nbsp;</td>
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
                                    <td align="center" valign="middle">Aksi</td>
                                </tr>
                            </thead>
                            <tbody id="target-debt">
                                <tr class="dynamic-row debt">
                                    <?php
                                    $j = 1;
                                    $totalDebt = 0;
                                    $is_disabled = "";
                                    $is_readonly = "";
                                    if (!empty($this->data['ParameterEmployeeSalary'])) {
                                        foreach ($this->data['ParameterEmployeeSalary'] as $k => $debts) {
                                            if ($debts['ParameterSalary']['parameter_salary_type_id'] == 2) {
                                                if($debts['ParameterSalary']['id'] == 11) {
                                                    $is_disabled = "disabled";
                                                    $is_readonly = "readonly";
                                                } else {
                                                    $is_disabled = "";
                                                    $is_readonly = "";
                                                }
                                                ?>
                                            <tr class="dynamic-row">
                                                <td class="text-center nomorIdx"><?= $j ?></td>
                                                <td align="center" width="10%">
                                                    <?php
                                                    echo $this->Form->input("ParameterEmployeeSalary.$k.id", array("type" => "hidden", "value" => $debts['id']));
                                                    ?>
                                                    <select name="data[ParameterEmployeeSalary][<?= $k ?>][parameter_salary_id]" class="select-full" required="required" <?= $is_disabled ?>>
                                                        <?php
                                                        $isSelected = "";                                                        
                                                        foreach ($debtParameterSalaries as $v => $debt_options) {
                                                            if ($v == $debts['ParameterSalary']['id']) {
                                                                $isSelected2 = "selected";
                                                            } else {
                                                                $isSelected2 = "";
                                                            }
                                                            ?>
                                                            <option value="<?= $v ?>" <?= $isSelected2 ?>><?= $debt_options ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Rp.</span>
                                                        <input name="data[ParameterEmployeeSalary][<?= $k ?>][nominal]" class="form-control text-right ParameterEmployeeSalaryNominalDebt isdecimal" step="1" type="text" required="required" value="<?= abs($debts['nominal']) ?>" <?= $is_readonly ?>>
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
                                            <?php
                                            $totalDebt += abs($debts['nominal']);
                                            $j++;
                                        }
                                    }
                                }
                                ?>
                                </tr>
                                <tr>
                                    <td colspan="4" align="left">
                                        <a class="text-success firstrunclickdebt" href="javascript:void(false)" onclick="addThisRow($(this), 'debt')"><i class="icon-plus-circle"></i></a>
                                    </td>
                                </tr>
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
                                    <td align="center">&nbsp;</td>
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
        <div class="form-actions text-center">
            <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
            <input type="reset" value="Reset" class="btn btn-info">
            <button class="btn btn-danger" data-toggle="modal" data-target="#edit" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_edit', true); ?>">
                <?= __("Simpan") ?>
            </button>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>

<script>
    var employee = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/employees/list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/employees/list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });

    employee.clearPrefetchCache();
    employee.initialize(true);
    $(document).ready(function () {
        Handlebars.registerHelper('isSelected', function (parameterSalaryOption, parameterSalarySelected) {
            if (parameterSalaryOption === parameterSalarySelected) {
                return true;
            } else {
                return false;
            }
        });
        listenerTotalHargaParameterEmployeeSalary();
        getEmployeeTypeahead();

        var grandTotalIncome = <?= $totalIncome ?>;
        $("input.auto-calculate-grand-total-income").val(IDR(grandTotalIncome));
        $(".target-terbilang-income").html(terbilang(grandTotalIncome + "") + " rupiah");

        var grandTotalDebt = <?= $totalDebt ?>;
        $("input.auto-calculate-grand-total-debt").val(IDR(grandTotalDebt));
        $(".target-terbilang-debt").html(terbilang(grandTotalDebt + "") + " rupiah");
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
            
            /* get Employee Data Loan if the employee has loan(s) */
            $.ajax({
                url: BASE_URL + "employee_data_loans/get_data_loan/" + data.id,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function(response) {
                    if(response.length == 1) {
                        var i = $("div.nHolder").data("n") - 1;
                        $.each(response, function(index, value) {
                            var totalAmountLoan = value.EmployeeDataLoan.total_amount_loan;
                            var installmentNumber = value.CooperativeLoanInterest.installment_number;
                            var remainingLoan = value.EmployeeDataLoan.remaining_loan;
                            var amountPerMonth = 0;
                            if( (totalAmountLoan / installmentNumber) <= remainingLoan) {
                                amountPerMonth = parseInt(totalAmountLoan / installmentNumber);
                            } else {
                                amountPerMonth = parseInt(remainingLoan);
                            }
                            $("#ParameterEmployeeSalary" + i  + "Nominal").val(IDR(amountPerMonth));
                        });
                    } else {
                        $.each(response, function(index, value) {
                            if(index > 0) {
                                addThisRow(".debt", "debt");
                            }                            
                            var i = $("div.nHolder").data("n") - 1;
                            var totalAmountLoan = value.EmployeeDataLoan.total_amount_loan;
                            var installmentNumber = value.CooperativeLoanInterest.installment_number;
                            var remainingLoan = value.EmployeeDataLoan.remaining_loan;
                            var amountPerMonth = 0;
                            if( (totalAmountLoan / installmentNumber) <= remainingLoan) {
                                amountPerMonth = parseInt(totalAmountLoan / installmentNumber);
                            } else {
                                amountPerMonth = parseInt(remainingLoan);
                            }
                            $("#ParameterEmployeeSalary" + i  + "Nominal").val(IDR(amountPerMonth));
                            $(".delete" + i).hide();
                            $("#ParameterEmployeeSalary" + i + "ParameterSalaryId").select2("val", 11);
                            $("#ParameterEmployeeSalary" + i + "ParameterSalaryId").attr("disabled", "disabled");                            
                            $("#ParameterEmployeeSalary" + i + "Nominal").attr("readonly", "readonly");
                            
                            var template = $('#tmpl-hidden-field').html();
                            Mustache.parse(template);
                            var options = {
                                n: i,
                                value: 11,
                            };
                            if (typeof (optFunc) !== 'undefined') {
                                $.extend(options, window[optFunc]());
                            }
                            var rendered = Mustache.render(template, options);
                            $('#hiddenField' + i).append(rendered);
                        });                        
                    }
                    $("input.ParameterEmployeeSalaryNominalDebt").trigger("change");
                }
            });
        });
    }

    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
        listenerTotalHargaParameterEmployeeSalary();
        $("input.ParameterEmployeeSalaryNominalIncome").trigger("change");
        $("input.ParameterEmployeeSalaryNominalDebt").trigger("change");
    }

    var list_parameter_salary_income =<?= $this->Engine->toJSONoptions($incomeParameterSalaries, "- Pilih -") ?>;
    var list_parameter_salary_debt =<?= $this->Engine->toJSONoptions($debtParameterSalaries, "- Pilih -") ?>;
    var potongan_koperasi = <?= $this->Engine->toJSONoptionsWithoutEmptyField($potonganKoperasi) ?>;

    function addThisRow(e, t, optFunc) {
        var n = $("div.nHolder").data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var list_parameter_salary = null;
        var is_readonly = "";
        var is_disabled = "";
        var is_sent = "";
        if (t == "income") {
            list_parameter_salary = list_parameter_salary_income;
        } else if (t == "debt") {
            if(n == 1) {
                list_parameter_salary = potongan_koperasi;
                is_readonly = "readonly";
                is_disabled = "disabled";
                is_sent = "";
            } else {
                list_parameter_salary = list_parameter_salary_debt;
                is_readonly = "";
                is_disabled = "";
                is_sent = "disabled";
            }
        }
        var options = {
            i: 2, 
            n: n, 
            list_volume: list_parameter_salary,
            is_readonly: is_readonly,
            is_disabled: is_disabled,
            is_sent: is_sent
        };
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr.dynamic-row:last").after(rendered);
        $("div.nHolder").data("n", n + 1);
        fixNumber($(e).parents("tbody"));
        listenerTotalHargaParameterEmployeeSalary();
        reloadSelect2();
        reloadisdecimal();
    }

    function fixNumber(e) {
        var i = 0;
        $.each(e.find("tr.dynamic-row").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }

    function listenerTotalHargaParameterEmployeeSalary() {
        $("input.ParameterEmployeeSalaryNominalIncome").on("keyup mouseup change", function () {
            var grandTotalIncome = 0;
            $('input.ParameterEmployeeSalaryNominalIncome').each(function () {
                $thisGrandTotalIncome = $(this);
                grandTotalIncome += parseFloat($thisGrandTotalIncome.val());
            });
            $("input.auto-calculate-grand-total-income").val(IDR(grandTotalIncome));
            $(".target-terbilang-income").html(terbilang(grandTotalIncome + "") + " rupiah");
        });
        $("input.ParameterEmployeeSalaryNominalDebt").on("keyup mouseup change", function () {
            var grandTotalDebt = 0;
            $('input.ParameterEmployeeSalaryNominalDebt').each(function () {
                $thisGrandTotalDebt = $(this);
                grandTotalDebt += parseFloat($thisGrandTotalDebt.val());
            });
            $("input.auto-calculate-grand-total-debt").val(IDR(grandTotalDebt));
            $(".target-terbilang-debt").html(terbilang(grandTotalDebt + "") + " rupiah");
        });
    }
</script>

<script type="x-tmpl-mustache" id="tmpl-income">
    <tr class="dynamic-row">
    <td class="text-center nomorIdx">{{i}}</td>
    <td align="center" width="10%">
    <select name="data[ParameterEmployeeSalary][{{n}}][parameter_salary_id]" class="select-full" id="ParameterEmployeeSalary{{n}}ParameterSalaryId" required="required">
    {{#list_volume}}
    <option value="{{value}}">{{label}}</option>    
    {{/list_volume}}
    </select>
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input name="data[ParameterEmployeeSalary][{{n}}][nominal]" class="form-control text-right ParameterEmployeeSalaryNominalIncome isdecimal" step="1" type="text" id="ParameterEmployeeSalary{{n}}Nominal" required="required">
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
    <tr class="dynamic-row">
    <td class="text-center nomorIdx">{{i}}</td>
    <td align="center" width="10%">
    <select name="data[ParameterEmployeeSalary][{{n}}][parameter_salary_id]" class="select-full" id="ParameterEmployeeSalary{{n}}ParameterSalaryId" required="required" {{is_disabled}}>
    {{#list_volume}}
    <option value="{{value}}">{{label}}</option>
    {{/list_volume}}
    </select>
    <div id="hiddenField{{n}}"></div>
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input name="data[ParameterEmployeeSalary][{{n}}][nominal]" class="form-control text-right ParameterEmployeeSalaryNominalDebt isdecimal" step="1" type="text" id="ParameterEmployeeSalary{{n}}Nominal" required="required" {{is_readonly}}>
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

<script type="x-tmpl-mustache" id="tmpl-hidden-field">
<input type="hidden" name="data[ParameterEmployeeSalary][{{n}}][parameter_salary_id]" id="hiddenField{{n}}" value="{{value}}">
</script>