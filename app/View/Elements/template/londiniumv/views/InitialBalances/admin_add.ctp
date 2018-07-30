<?php echo $this->Form->create("InitialBalance", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Saldo Awal Rekening") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Saldo Awal Rekening") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("InitialBalance.cash", __("Nama Kas"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("InitialBalance.cash", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full cashType", "empty" => "", "placeholder" => "- Pilih Kas -", "options" => $cashTypes));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("InitialBalance.initial_date", __("Tanggal Dibuat"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("InitialBalance.initial_date", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "value" => date("Y-m-d")));
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
                                                <label>Nomor Rekening</label>
                                            </div>
                                            <div class="has-feedback">
                                                <div class="col-sm-9 col-md-8">                                                
                                                    <input type="text" class="form-control typeahead-ajax-code" placeholder="Cari Nomor Rekening ..." id="dummyBankAccount">
                                                    <i class="icon-search3 form-control-feedback"></i>
                                                    <input type="hidden" name="data[InitialBalance][bank_account_id]" id="bankAccount">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.account", __("Bank"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.account", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                            echo $this->Form->label("Dummy.on_behalf", __("Atas Nama Rekening"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.on_behalf", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("InitialBalance.currency_id", __("Mata Uang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("InitialBalance.currency_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -", "id" => "currency"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6 kurs">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Kurs</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <input type="text" label="false" class="form-control text-right isdecimal exchangeRate" name="data[InitialBalance][exchange_rate]" value="<?= $this->Html->getExchangeRate(1, "USD", "IDR") ?>" disabled>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00.</button>
                                                    </span>
                                                </div>
                                                <span class="help-block">Dollar ke Rupiah.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    
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
                
        /* Cari Nomor Rekening */
        var code = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('code'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/bank_accounts/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/bank_accounts/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        code.clearPrefetchCache();
        code.initialize(true);
        $('input.typeahead-ajax-code').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'code',
            display: 'code',
            source: code.ttAdapter(),
            templates: {
                header: '<center><h5>Data Rekening</h5></center><hr>',
                suggestion: function (context) {
                    return '<p> Nomor Rekening : ' + context.code + '<br>Atas Nama : ' + context.on_behalf + '<br>Bank : ' + context.bank_account_type + '</p>';
                },
                empty: [
                    '<center><h5>Data Rekening</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-code').bind('typeahead:select', function (ev, suggestion) {
            $('#bankAccount').val(suggestion.id);
            $("#DummyOnBehalf").val(suggestion.on_behalf);
            $("#DummyAccount").val(suggestion.bank_account_type);
        });

        /* If small cash type were selected, then disabling the account-code-related fields */
        $("#cashType").click(function () {
            if ($("#cashType option:selected").length) {
                if ($(this).val() == 1) {
                    $("#bankAccount").attr("disabled", "disabled");
                    $("#dummyBankAccount").attr("disabled", "disabled");
                } else {
                    $("#bankAccount").removeAttr("disabled");
                    $("#dummyBankAccount").removeAttr("disabled");
                }
            }
        });
        $(".dollar").hide();
        $(".kurs").hide();
        $("#currency").on("change", function () {
            if ($(this).val() == 2) {
                $(".dollar").show();
                $(".kurs").show();
                $(".exchangeRate").removeAttr("disabled");
                $(".rupiah").hide();
            } else {
                $(".dollar").hide();
                $(".kurs").hide();
                $(".exchangeRate").attr("disabled", "disabled");
                $(".rupiah").show();
            }
        });
    });
</script>