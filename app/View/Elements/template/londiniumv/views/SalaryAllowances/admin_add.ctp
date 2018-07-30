<?php echo $this->Form->create("SalaryAllowance", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Setup Tunjangan Pegawai") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("SalaryAllowance.employee_id", __("Pegawai"), array("class" => "col-sm-4 control-label"));
                            echo $this->Form->input("SalaryAllowance.employee_id", array("div" => array("class" => "col-sm-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "-Pilih Pegawai-"));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Tunjangan") ?></h6>
                </div>
                <table width="100%" class="table table-bordered table-hover">
                    <thead>
                        <tr bordercolor="#000000">
                            <th width="1%" align="center" valign="middle" class="text-center" bgcolor="#feffc2">No</th>
                            <th align="center" valign="middle" class="text-center" bgcolor="#feffc2"><?= __("Jenis Tunjangan") ?></th>
                            <th class="text-center" width="20%" align="center" valign="middle" bgcolor="#feffc2"><?= __("Nilai Tunjangan") ?></th>
                            <th class="text-center" width="5%" align="center" valign="middle" bgcolor="#feffc2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="target-salaryAllowanceDetail">
                    </tbody>  
                    <tfoot>
                        <tr class="addrowborder">
                            <td colspan="4" align="left"><a href="javascript:void(false)" onclick="addThisRow($(this), 'salaryAllowanceDetail', 'salaryAllowanceDetailOptions')" data-n="1"><i class="icon-plus-circle"></i></a></td>
                        </tr>
                    </tfoot>
                </table>
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
    </div>
</div>
<?php echo $this->Form->end() ?>
<script>
    var parameter_salaries =<?= $this->Engine->toJSONoptions($parameterSalaries,"-Pilih Tunjangan-") ?>;
    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 2, n: n};
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $("#target-" + t).append(rendered);
        $(e).data("n", n + 1);
        fixNumber($(e).parents("table").find("tbody"));
        reloadSelect2();
        reloadisdecimal();
    }
    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }
    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        var tr = e.parents("tr");
        tr.remove();
        fixNumber(tbody);
    }

    function salaryAllowanceDetailOptions() {
        return {parameter_salaries: parameter_salaries};
    }
</script>

<script type="x-tmpl-mustache" id="tmpl-salaryAllowanceDetail">
    <tr>
    <td align="center" class="nomorIdx">1</td>
    <td>
    <div class="false">
    <select name="data[SalaryAllowanceDetail][{{n}}][parameter_salary_id]" class="select-full" id="SalaryAllowanceDetail{{n}}ParameterSalaryId" placeholder="-Pilih Tunjangan-">
    {{#parameter_salaries}}
    <option value="{{value}}">{{label}}</option>
    {{/parameter_salaries}}
    </select>                                  
    </div>
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input name="data[SalaryAllowanceDetail][{{n}}][amount]" class="form-control text-right isdecimal" maxlength="255" type="text" id="SalaryAllowanceDetail{{n}}Amount" required="required">
    <span class="input-group-addon">,00.</span>
    </div>
    </td>
    <td align="center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>