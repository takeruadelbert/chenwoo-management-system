<?php echo $this->Form->create("CooperativeCashMutation", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Mutasi Kas Koperasi") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Pegawai") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.nip", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Employee.nip"), "disabled"));
                                            echo $this->Form->hidden("CooperativeCashMutation.creator_id", ["value" => $this->Session->read("credential.admin.Employee.id")]);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.name", __("Nama"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.name", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Biodata.full_name"), "disabled"));
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
                                            echo $this->Form->label("Dummy.departemen", __("Departemen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.departemen", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Employee.Department.name"), "disabled"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.office", __("Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.office", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Employee.Office.name"), "disabled"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Kas Koperasi") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Kas Awal</label>
                                            </div>
                                            <div class="has-feedback">
                                                <div class="col-sm-9 col-md-8">                                                
                                                    <input type="text" class="form-control typeahead-ajax-transfer-cash" placeholder="Cari Kas Awal ...">
                                                    <i class="icon-search3 form-control-feedback"></i>
                                                    <input type="hidden" name="data[CooperativeCashMutation][cooperative_cash_transfered_id]" id="transferedCash">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Kas Tujuan</label>
                                            </div>
                                            <div class="has-feedback">
                                                <div class="col-sm-9 col-md-8">                                                
                                                    <input type="text" class="form-control typeahead-ajax-receive-cash received" placeholder="Cari Kas Tujuan ...">
                                                    <i class="icon-search3 form-control-feedback"></i>
                                                    <input type="hidden" name="data[CooperativeCashMutation][cooperative_cash_received_id]" id="receivedCash">
                                                </div>
                                            </div>
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
                                            echo $this->Form->label("Dummy.account", __("Nomor Rekening"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.account", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
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
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Saldo</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <input type="text" label="false" class="form-control text-right isdecimal" disabled id="balance">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00.</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Saldo</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <input type="text" label="false" class="form-control text-right isdecimal" id="balance2" disabled>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00.</button>
                                                    </span>
                                                </div>
                                            </div>
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
                                            echo $this->Form->label("Dummy.on_behalf", __("Atas Nama"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.on_behalf", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
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
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.bank", __("Bank"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.bank", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.bank2", __("Bank"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.bank2", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>                        
                    </table>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Mutasi Kas") ?></h6>
                        </div>
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
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <input type="text" label="false" class="form-control text-right isdecimal" name="data[CooperativeCashMutation][nominal]" required="required">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00.</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("CooperativeCashMutation.transfer_date", __("Tanggal Mutasi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("CooperativeCashMutation.transfer_date", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datetime", "value" => date("Y-m-d H:i:s"), "readonly"));
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
                                    echo $this->Form->label("CooperativeCashMutation.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("CooperativeCashMutation.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
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
    $(document).ready(function () {
        /* Cari Kas Kirim */
        var transferedId = 0;
        var transferedCash = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/cooperative_cashes/cash_list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/cooperative_cashes/cash_list", true) ?>' + '?q=%QUERY',
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
                    return '<p> Nama Kas : ' + context.name + '<br>Nomor Rekening : ' + context.code + '<br> Saldo : ' + RP(context.nominal) + '<br>Atas Nama : ' + context.on_behalf + '<br>Bank : ' + context.bank_account_type + '</p>';
                },
                empty: [
                    '<center><h5>Data Kas</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });

        $(".received").attr("disabled", "disabled");
        $('input.typeahead-ajax-transfer-cash').bind('typeahead:select', function (ev, suggestion) {
            $('#transferedCash').val(suggestion.id);
            $("#DummyOnBehalf").val(suggestion.on_behalf);
            $("#DummyAccount").val(suggestion.bank_account_type);
            $("#balance").val(IDR(suggestion.nominal));
            $("#DummyBank").val(suggestion.bank_account_type);
            $(".received").removeAttr("disabled");
            var transferedCash2 = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: BASE_URL + "admin/cooperative_cashes/cash_list1/" + suggestion.id,
                remote: {
                    url: BASE_URL + "admin/cooperative_cashes/cash_list1/" + suggestion.id + '?q=%QUERY',
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
                        return '<p> Nama Kas : ' + context.name + '<br>Nomor Rekening : ' + context.code + '<br> Saldo : ' + RP(context.nominal) + '<br>Atas Nama : ' + context.on_behalf + '<br>Bank : ' + context.bank_account_type + '</p>';
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
                $("#balance2").val(IDR(suggestion.nominal));
                $("#DummyBank2").val(suggestion.bank_account_type);
            });
        });
        /* Cari Nama Kas Terima */

    });
</script>