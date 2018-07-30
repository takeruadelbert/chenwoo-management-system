<?php echo $this->Form->create("CooperativeCashDisbursement", array("class" => "form-horizontal form-separate", "type" => "file", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM UBAH KAS KELUAR KASIR KOPERASI") ?>                
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <!-- Justified pills -->
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-mail-send"></i> Data Kas Keluar</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file6"></i> Rincian Biaya Pengeluaran</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeCashDisbursement.cash_disbursement_number", __("Nomor Kas Keluar"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashDisbursement.cash_disbursement_number", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("CooperativeCashDisbursement.created_date", __("Tanggal Dibuat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashDisbursement.created_date", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control datepicker"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeCashDisbursement.creator_id", __("Dibuat Oleh"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashDisbursement.creator_id", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Biodata.full_name"), "disabled"));
                                            echo $this->Form->input("CooperativeCashDisbursement.creator_id", array("type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.position", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.position", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Employee.Office.name"), "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">     
                                            <?php
                                            echo $this->Form->label("CooperativeCashDisbursement.cooperative_cash_id", __("Kas yang digunakan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashDisbursement.cooperative_cash_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "empty" => "--Pilih Kas Yang Digunakan--", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeCashDisbursement.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashDisbursement.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix", "placeholder" => "Enter text ..."));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                    
                    <div class="tab-pane fade" id="justified-pill3">
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Jenis Pengeluaran</th>
                                    <th>Nominal</th>
                                    <th>Tanggal</th>
                                    <th width="300">Bukti</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-kas-keluar">
                                <?php
                                $no = 1;
                                $dataN = count($this->data["CooperativeCashDisbursementDetail"]);
                                foreach ($this->data["CooperativeCashDisbursementDetail"] as $i => $value) {
                                    ?>
                                    <tr>
                                        <td class="text-center nomorIdx">
                                            <?= $no; ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $this->Form->input("CooperativeCashDisbursementDetail.$i.id", array("div" => false, "label" => false, "type" => "hidden", "class" => false));
                                            echo $this->Form->input("CooperativeCashDisbursementDetail.$i.expenditure_type_id", array("div" => false, "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Jenis Pengeluaran -"));
                                            ?>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">Rp.</button>
                                                </span>
                                                <?php
                                                echo $this->Form->input("CooperativeCashDisbursementDetail.$i.amount", array("div" => false, "label" => false, "type" => "text", "class" => "form-control text-right isdecimal"));
                                                ?>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">,00.</button>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("CooperativeCashDisbursementDetail.$i.date", array("div" => false, "label" => false, "class" => "form-control datepicker text-right", "type" => "text")) ?>
                                        </td>
                                        <td>
                                            <input type="file" name="data[CooperativeCashDisbursementDetail][<?= $i ?>][gambar]" class="form-control" id="files">
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                }
                                ?>
                                <tr>
                                    <td colspan="6">
                                        <a class="text-success" href="javascript:void(false)" onclick="addThisRow($(this), 'detail-kas-keluar', 'anakOptions')" data-n="<?= $dataN ?>"><i class="icon-plus-circle"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /justified pills -->
        <div class="text-center">
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
    var expenditureTypes =<?= $this->Engine->toJSONoptions($expenditureTypes) ?>;
    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
    }
    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 2, n: n};
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 1);
        reloadDatePicker();
        reloadSelect2();
        reloadisdecimal()
        fixNumber($(e).parents("tbody"));
    }
    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }
    function anakOptions() {
        return {expenditureTypes: expenditureTypes};
    }
    reloadStyled();
</script>
<script type="x-tmpl-mustache" id="tmpl-detail-kas-keluar">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <select class="select-full" name="data[CooperativeCashDisbursementDetail][{{n}}][expenditure_type_id]" id = "CashDisbursementDetail{{n}}expenditure_type_id" placeholder="- Pilih Jenis Pengeluaran -">
    {{#expenditureTypes}}
    <option value="{{value}}">{{label}}</option>
    {{/expenditureTypes}}
    </select>                                
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-btn">
    <button class="btn btn-default" type="button">Rp.</button>
    </span>
    <input type="text" class="form-control text-right isdecimal" name="data[CooperativeCashDisbursementDetail][{{n}}][amount]" id="CashDisbursementDetail{{n}}amount">
    <span class="input-group-btn">
    <button class="btn btn-default" type="button">,00.</button>
    </span>
    </div>
    </td>
    <td>
    <input name="data[CooperativeCashDisbursementDetail][{{n}}][date]" id="CashDisbursementDetail{{n}}date" class="form-control datepicker text-right" maxlength="255" type="text">                                    
    </td>
    <td>
    <input type="file" name="data[CooperativeCashDisbursementDetail][{{n}}][gambar]" id="CashDisbursementDetail{{n}}gambar" class="form-control">                                   
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>