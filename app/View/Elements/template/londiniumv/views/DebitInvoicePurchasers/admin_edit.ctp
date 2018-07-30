<?php echo $this->Form->create("DebitInvoicePurchaser", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Penerimaan Kembalian") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Penerimaan Kelebihan") ?></h6>
                        </div>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-sm-3 col-md-4 control-label label-required">
                                                <label>Nomor Transaksi</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="has-feedback">
                                                    <?php
                                                    $transaction = ClassRegistry::init("TransactionEntry")->find("first", ["conditions" => ["TransactionEntry.id" => $this->data['TransactionEntry']['id']]]);
                                                    ?>
                                                    <input type="text" placeholder="Silahkan Cari Nomor Transaksi ..." class="form-control typeahead-ajax-transaction" value="<?= $transaction['TransactionEntry']['transaction_number'] ?>">
                                                    <input type="hidden" name="data[DebitInvoicePurchaser][transaction_entry_id]" id="transactionId" value="<?= $this->data['TransactionEntry']['id'] ?>">
                                                    <i class="icon-search3 form-control-feedback"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-sm-3 col-md-4 control-label label-required">
                                                <label>Nominal</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <input type="text" class="form-control text-right isdecimal" name="data[DebitInvoicePurchaser][amount]" value="<?= !empty($this->data['DebitInvoicePurchaser']['amount']) ? $this->data['DebitInvoicePurchaser']['amount'] : 0 ?>">
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
                            <td>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("DebitInvoicePurchaser.initial_balance_id", __("Tipe Kas"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("DebitInvoicePurchaser.initial_balance_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "data-placeholder" => "- Pilih Tipe Kas -", "empty" => ""));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-actions text-center">
                                    <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                                    <input type="reset" value="Reset" class="btn btn-info">
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#edit" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_edit', true); ?>">
                                        <?= __("Simpan") ?>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>

<script>
    $(document).ready(function () {
        var transaction = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('transaction_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/transaction_entries/list_lunas", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/transaction_entries/list_lunas", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        transaction.clearPrefetchCache();
        transaction.initialize(true);
        $('input.typeahead-ajax-transaction').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'transaction',
            display: 'transaction_number',
            source: transaction.ttAdapter(),
            templates: {
                header: '<center><h5>Data Transaksi</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Transaksi : ' + context.transaction_number + '<br>Total Tagihan : ' + RP(context.total_invoice) + '</p>';
                },
                empty: [
                    '<center><h5>Data Transaksi</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction').bind('typeahead:select', function (ev, suggestion) {
            $('#transactionId').val(suggestion.id);
        });
    });
</script>