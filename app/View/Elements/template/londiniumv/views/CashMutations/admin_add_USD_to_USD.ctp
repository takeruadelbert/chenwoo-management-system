<?php echo $this->Form->create("CashMutation", array("class" => "form-horizontal form-separate", "action" => "add_USD_to_USD", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Tambah Mutasi Kas") ?>
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-mail-send"></i> Data Kas Asal</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-file6"></i> Data Kas Tujuan</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file6"></i> Detail Mutasi</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-3 col-md-4 control-label">
                                                    <label>Kas Asal</label>
                                                </div>
                                                <div class="has-feedback">
                                                    <div class="col-sm-9 col-md-8">                                                
                                                        <input type="text" class="form-control typeahead-ajax-transfer-cash" placeholder="Cari Kas ...">
                                                        <i class="icon-search3 form-control-feedback"></i>
                                                        <input type="hidden" name="data[CashMutation][cash_transfered_id]" id="transferedCash">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.account", __("Nomor Rekening"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.account", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-3 col-md-4 control-label">
                                                    <label>Saldo</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">$</button>
                                                        </span>
                                                        <input type="text" label="false" class="form-control text-right" disabled id="balance">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.on_behalf", __("Atas Nama"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.on_behalf", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.bank", __("Bank"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.bank", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="justified-pill2">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-3 col-md-4 control-label">
                                                    <label>Kas Tujuan</label>
                                                </div>
                                                <div class="has-feedback">
                                                    <div class="col-sm-9 col-md-8">                                                
                                                        <input type="text" class="form-control typeahead-ajax-receive-cash" placeholder="Cari Kas ...">
                                                        <i class="icon-search3 form-control-feedback"></i>
                                                        <input type="hidden" name="data[CashMutation][cash_received_id]" id="receivedCash">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.account2", __("Nomor Rekening"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.account2", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-3 col-md-4 control-label">
                                                    <label>Saldo</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">$</button>
                                                        </span>
                                                        <input type="text" label="false" class="form-control text-right isdecimal" id="balance2" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.on_behalf2", __("Atas Nama"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.on_behalf2", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.bank2", __("Bank"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.bank2", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="justified-pill3">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="col-sm-3 col-md-4 control-label label-required">
                                                        <label>Nominal</label>
                                                    </div>
                                                    <div class="col-sm-9 col-md-8">
                                                        <div class="input-group">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="button">$</button>
                                                            </span>
                                                            <input type="text" label="false" class="form-control text-right isdecimaldollar" required="required" name="data[CashMutation][nominal]">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("CashMutation.transfer_date", __("Tanggal Mutasi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CashMutation.transfer_date", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datetime", "value" => date("Y-m-d H:i:s")));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CashMutation.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("CashMutation.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions text-center">
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
    $(document).ready(function () {

        /* Cari Kas Kirim */
        var transferedCash = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/initial_balances/cash_list/2", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/initial_balances/cash_list/2", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        transferedCash.clearPrefetchCache();
        transferedCash.initialize(true);
        $('input.typeahead-ajax-transfer-cash').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'transferedCash',
            display: 'name',
            source: transferedCash.ttAdapter(),
            templates: {
                header: '<center><h5>Data Kas</h5></center><hr>',
                suggestion: function (context) {
                    return '<p> Nama Kas : ' + context.name + '<br>Nomor Rekening : ' + context.code + '<br> Saldo : $ ' + ac_dollar(context.nominal) + '<br>Atas Nama : ' + context.on_behalf + '<br>Bank : ' + context.bank_account_type + '</p>';
                },
                empty: [
                    '<center><h5>Data Kas</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transfer-cash').bind('typeahead:select', function (ev, suggestion) {
            $('#transferedCash').val(suggestion.id);
            $("#DummyOnBehalf").val(suggestion.on_behalf);
            $("#DummyAccount").val(suggestion.bank_account_type);
            $("#DummyBank").val(suggestion.bank_account_type);
            $("#balance").val(IDR(parseInt(suggestion.nominal)));
        });

        /* Cari Nama Kas Terima */
        var transferedCash2 = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/initial_balances/cash_list/2", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/initial_balances/cash_list/2", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        transferedCash2.clearPrefetchCache();
        transferedCash2.initialize(true);
        $('input.typeahead-ajax-receive-cash').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'transferedCash2',
            display: 'name',
            source: transferedCash2.ttAdapter(),
            templates: {
                header: '<center><h5>Data Kas</h5></center><hr>',
                suggestion: function (context) {
                    return '<p> Nama Kas : ' + context.name + '<br>Nomor Rekening : ' + context.code + '<br> Saldo : $ ' + ac_dollar(context.nominal) + '<br>Atas Nama : ' + context.on_behalf + '<br>Bank : ' + context.bank_account_type + '</p>';
                },
                empty: [
                    '<center><h5>Data Kas</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-receive-cash').bind('typeahead:select', function (ev, suggestion) {
            $('#receivedCash').val(suggestion.id);
            $("#DummyOnBehalf2").val(suggestion.on_behalf);
            $("#DummyAccount2").val(suggestion.bank_account_type);
            $("#DummyBank2").val(suggestion.bank_account_type);
            $("#balance2").val(IDR(parseInt(suggestion.nominal)));
        });
    });

    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    }
</script>