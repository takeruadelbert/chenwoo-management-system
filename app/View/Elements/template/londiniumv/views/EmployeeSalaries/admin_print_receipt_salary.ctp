<?php echo $this->Form->create("EmployeeSalary", array("class" => "form-horizontal form-separate", "action" => "print_receipt_salary", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("KWITANSI SLIP GAJI") ?>
                <div class="pull-right">
                    <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                    <input type="reset" value="Reset" class="btn btn-info">
                    <input type="submit" value="<?= __("Cari") ?>" class="btn btn-danger">
                </div>
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <div class="table-responsive">
            <table width="100%" class="table table-hover">
                <tbody>
                    <tr>
                        <td colspan="3" style="width:200px">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("EmployeeSalary.month_period", __("Periode"), array("class" => "col-sm-2 control-label"));
                                echo $this->Form->input("EmployeeSalary.month_period", array("div" => array("class" => "col-sm-2"), "label" => false, "options" => $this->Echo->periodeBulan(), "class" => "select-full", "data-placeholder" => "- Pilih Periode Bulan -", "empty" => ""));
                                echo $this->Form->input("EmployeeSalary.year_period", array("div" => array("class" => "col-sm-2"), "label" => false, "options" => $this->Echo->periodeTahun(), "class" => "select-full", "data-placeholder" => "- Pilih Periode Tahun -", "empty" => ""));
                                ?>
                                <label class="col-sm-2 control-label">Tujuan</label>
                                <div class="col-sm-4">
                                    <select name="data[EmployeeSalary][aim]" class="select-full EmployeeSalaryAim" tabindex="2" id="EmployeeSalaryAim" data-placeholder="- Pilih Tujuan -" required>
                                        <option></option>
                                        <option value="1">Department</option>
                                        <option value="2">Perorangan</option>
                                    </select>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="width:200px">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("Employee.department_id", __("Department"), array("class" => "col-sm-2 control-label"));
                                echo $this->Form->input("Employee.department_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full EmployeeDepartmentId", "data-placeholder" => "- Pilih Department -", "empty" => ""));
                                ?>
                                <?php
                                echo $this->Form->label("EmployeeSalary.employee_id", __("Nama Pegawai"), array("class" => "col-sm-2 control-label EmployeeSalaryEmployeeId"));
                                echo $this->Form->input("EmployeeSalary.employee_id", array("div" => false, "label" => false, "type" => "hidden"));
                                ?>
                                <div class="col-sm-4 has-feedback">
                                    <input type = "text" placeholder = "Cari Nama / NIP Pegawai" class = "form-control typeahead-ajax-employee">
                                    <i class="icon-search3 form-control-feedback"></i>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>

<script>
    var employee = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/employee_salaries/getEmployeeTypeahead", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/employee_salaries/getEmployeeTypeahead", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    employee.clearPrefetchCache();
    employee.initialize(true);

    $(document).ready(function () {
        getEmployeeTypeahead();

        $("#EmployeeDepartmentId").attr("disabled", "disabled");
        $(".typeahead-ajax-employee").attr("disabled", "disabled");

        $(".EmployeeSalaryAim").select(function () {
            var typeSelect = $(this).select2('data');
            var type = "";
            if (typeSelect !== null) {
                type = typeSelect.text;
            } else {
                type = "";
            }
            if (type === "Department") {
                $("#EmployeeDepartmentId").removeAttr("disabled");
                $("#EmployeeSalaryEmployeeId").val("");
                $("#EmployeeSalaryEmployeeId").attr("disabled", "disabled");
                $(".typeahead-ajax-employee").val("");
                $(".typeahead-ajax-employee").attr("disabled", "disabled");
            }
            if (type === "Perorangan") {
                $('#EmployeeDepartmentId').val("").change();
                $("#EmployeeDepartmentId").attr("disabled", "disabled");
                $("#EmployeeSalaryEmployeeId").removeAttr("disabled");
                $(".typeahead-ajax-employee").removeAttr("disabled");
            } else {

            }
        });


    });

    function getEmployeeTypeahead() {
        $('input.typeahead-ajax-employee').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'employee',
            display: 'name',
            source: employee.ttAdapter(),
            templates: {
                header: '<center><h5>Data Pegawai</h5></center><hr>',
                suggestion: function (data) {
                    return '<p> Nama : ' + data.name + '<br/> NIP : ' + data.nip + '<br/> Department : ' + data.department + '<br/> Jabatan : ' + data.position + '</p>';
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
</script>