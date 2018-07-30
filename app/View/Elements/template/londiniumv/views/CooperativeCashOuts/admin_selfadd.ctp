<?php echo $this->Form->create("CooperativeCashOut", array("class" => "form-horizontal form-separate", "type" => "file", "action" => "selfadd", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Tambah Pengeluaran Koperasi") ?>                
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <!-- Justified pills -->
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#data-login" data-toggle="tab"><i class="icon-user4"></i>Data Login</a></li>
                    <li><a href="#justified-pill1" data-toggle="tab"><i class="icon-mail-send"></i> Data Pengeluaran</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file6"></i> Rincian Biaya Pengeluaran</a></li>                    
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="data-login">
                        <div class="table-responsive">
                            <table width="100%" class="table">
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label(null, __("Nama Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Biodata.full_name")));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">                                    
                                                    <?php
                                                    echo $this->Form->label(null, __("NIK"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.nip")));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>                                
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">                                    
                                                    <?php
                                                    echo $this->Form->label(null, __("Departemen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Department.name")));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">                                    
                                                    <?php
                                                    echo $this->Form->label(null, __("Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Office.name")));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>                                
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="justified-pill1">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeCashOut.cash_out_number", __("Nomor Kas Keluar"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashOut.cash_out_number", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => "AUTO GENERATE", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("CooperativeCashOut.created_datetime", __("Waktu Dibuat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashOut.created_datetime", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control datetime", "value" => date("Y-m-d H:i:s")));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">     
                                            <?php
                                            echo $this->Form->label("CooperativeCashOut.cooperative_cash_id", __("Kas Asal"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashOut.cooperative_cash_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Kas Yang Digunakan -"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("CooperativeCashOut.general_entry_type_id", __("Jenis Pengeluaran"), array("class" => "col-sm-2 control-label label-required"));
                                            echo $this->Form->input("CooperativeCashOut.general_entry_type_id", array("options" => $outCooperativeGeneralEntryTypes, "div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Jenis Pengeluaran -", "required" => true));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeCashOut.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashOut.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
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
                                    <th width="3%">No</th>
                                    <th>Uraian</th>
                                    <th width="25%">Nominal</th>
                                    <th width="20%">Tanggal</th>
                                    <th width="25%">Bukti</th>
                                    <th width="3%">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-kas-keluar">
                                <tr>
                                    <td class="text-center nomorIdx">
                                        1
                                    </td>
                                    <td>
                                        <?= $this->Form->input("CooperativeCashOutDetail.0.uraian", ["div" => false, "label" => false, "class" => "form-control"]) ?>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp.</span>
                                            <input type="text" class="form-control text-right isdecimal" name="data[CooperativeCashOutDetail][0][amount]">
                                            <span class="input-group-addon">,00.</span>
                                        </div>
                                    </td>
                                    <td>
                                        <?= $this->Form->input("CooperativeCashOutDetail.0.date", ["type" => "text", "div" => false, "label" => false, "class" => "form-control datepicker", "value" => date("Y-m-d")]) ?>
                                    </td>
                                    <td>
                                        <input type="file" class="form-control" name="data[CooperativeCashOutDetail][0][gambar]">
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <a class="text-success dataN0" href="javascript:void(false)" onclick="addThisRow($(this), 'detail-kas-keluar', 'anakOptions')" data-n="1" data-k="0"><i class="icon-plus-circle"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="block-inner text-danger">
                                    <div class="form-actions text-center">
                                        <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                                        <input type="reset" value="Reset" class="btn btn-info">
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                                            <?= __("Simpan") ?>
                                        </button>&nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>

<script>
    var expenditureTypes = <?= $this->Engine->toJSONoptions($expenditureTypes) ?>;

    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    }

    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
    }
    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var k = $(e).data("k");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {
            i: 2,
            n: n,
            k: k
        };
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 1);
        $(e).data("k", k + 1);
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
        return {
            expenditureTypes: expenditureTypes
        };
    }
    reloadStyled();
</script>
<script type="x-tmpl-mustache" id="tmpl-detail-kas-keluar">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <input name="data[CooperativeCashOutDetail][{{n}}][uraian]" class="form-control" maxlength="255" type="text" id="CooperativeCashOutDetail{{n}}Uraian">
    </td>
    <td>
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input type="text" class="form-control text-right isdecimal" name="data[CooperativeCashOutDetail][{{n}}][amount]">
    <span class="input-group-addon">,00.</span>
    </div>                                    
    </td>
    <td>
    <input type="text" class="form-control datepicker" name="data[CooperativeCashOutDetail][{{n}}][date]" value="<?= date("Y-m-d") ?>">
    </td>
    <td>
    <input type="file" class="form-control" name="data[CooperativeCashOutDetail][{{n}}][gambar]">
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>