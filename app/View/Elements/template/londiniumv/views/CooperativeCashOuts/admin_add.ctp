<?php echo $this->Form->create("CooperativeCashOut", array("class" => "form-horizontal form-separate", "type" => "file", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Tambah Kas Keluar Koperasi") ?>                
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
                                            echo $this->Form->label("CooperativeCashOut.creator_id", __("Dibuat Oleh"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashOut.creator_id", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Biodata.full_name"), "disabled"));
                                            echo $this->Form->input("CooperativeCashOut.creator_id", array("type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")));
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
                                            echo $this->Form->label("CooperativeCashOut.cooperative_cash_id", __("Kas Asal"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CooperativeCashOut.cooperative_cash_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Kas Yang Digunakan -"));
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
                                    <th>Pengeluaran</th>
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
                                        <?= $this->Form->input("CooperativeCashOutDetail.0.expenditure_type_id", ["div" => false, "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -"]) ?>
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
            expenditureTypes : expenditureTypes
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
    <select class="select-full" name="data[CooperativeCashOutDetail][{{n}}][expenditure_type_id]" placeholder="- Pilih -">
        {{#expenditureTypes}}
            <option value="{{value}}">{{label}}</option>
        {{/expenditureTypes}}
    </select>
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