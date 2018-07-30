<?php echo $this->Form->create("CashDisbursement", array("class" => "form-horizontal form-separate", "type" => "file", "action" => "add_internal", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("TAMBAH KAS KELUAR") ?>                
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
                                            echo $this->Form->label("CashDisbursement.cash_disbursement_number", __("Nomor Kas Keluar"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CashDisbursement.cash_disbursement_number", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => "Akan Dibuat Setelah Disimpan", "disabled"));
                                            echo $this->Form->input("CashDisbursement.transaction_currency_type_id", ["type" => "hidden", "value" => 1]);
                                            ?>
                                            <?php
                                            echo $this->Form->label("CashDisbursement.created_datetime", __("Tanggal Dibuat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CashDisbursement.created_datetime", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control datepicker", "value" => date("Y-m-d H:i:s")));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">                                            
                                            <?php
                                            echo $this->Form->label("CashDisbursement.creator_id", __("Dibuat Oleh"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CashDisbursement.creator_id", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Biodata.full_name"), "disabled"));
                                            echo $this->Form->input("CashDisbursement.creator_id", array("type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")));
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
                                            echo $this->Form->label("CashDisbursement.initial_balance_id", __("Kas yang digunakan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CashDisbursement.initial_balance_id", array("div" => array("class" => "col-sm-4"), "options" => $initialBalances, "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "-- Pilih Kas Yang Digunakan --"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("CashDisbursement.general_entry_type_id", __("Jenis Pengeluaran"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CashDisbursement.general_entry_type_id", array("div" => array("class" => "col-sm-4"), "options" => $generalEntryTypes, "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "-- Pilih Jenis Pengeluaran --"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CashDisbursement.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CashDisbursement.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix", "placeholder" => "Enter text ..."));
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
                                    <th>Uraian</th>
                                    <th>Nominal</th>
                                    <th>Tanggal</th>
                                    <th width="300">Bukti</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-kas-keluar">
                                <tr>
                                    <td class="text-center nomorIdx">
                                        1
                                    </td>
                                    <td>
                                        <?= $this->Form->input("CashDisbursementDetail.0.name", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">Rp.</button>
                                            </span>
                                            <input type="text" class="form-control text-right isdecimal" name="data[CashDisbursementDetail][0][amount]">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">,00.</button>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <?= $this->Form->input("CashDisbursementDetail.0.date", array("div" => false, "label" => false, "class" => "form-control datepicker text-right", "type" => "text")) ?>
                                    </td>
                                    <td>
                                        <input type="file" name="data[CashDisbursementDetail][0][gambar]" class="form-control">
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <a class="text-success" href="javascript:void(false)" onclick="addThisRow($(this), 'detail-kas-keluar')" data-n="1"><i class="icon-plus-circle"></i></a>
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
            <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                <?= __("Simpan") ?>
            </button>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>

<script>
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
    reloadStyled();
</script>
<script type="x-tmpl-mustache" id="tmpl-detail-kas-keluar">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <input type="text" class="form-control" name="data[CashDisbursementDetail][{{n}}][name]">
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-btn">
    <button class="btn btn-default" type="button">Rp.</button>
    </span>
    <input type="text" class="form-control text-right isdecimal" name="data[CashDisbursementDetail][{{n}}][amount]">
    <span class="input-group-btn">
    <button class="btn btn-default" type="button">,00.</button>
    </span>
    </div>
    </td>
    <td>
    <input name="data[CashDisbursementDetail][{{n}}][date]" class="form-control datepicker text-right" maxlength="255" type="text" id="date{{n}}">                                    
    </td>
    <td>
    <input type="file" name="data[CashDisbursementDetail][{{n}}][gambar]" class="form-control">                                   
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>