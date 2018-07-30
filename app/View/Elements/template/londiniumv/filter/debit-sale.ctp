<form action="#" role="form" class="panel-filter">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Filter Data</h6>
            <div class="panel-icons-group"> <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-up9"></i></a></div>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label>Nomor Penjualan Produk</label>
                        <?php
                        if (isset($this->request->query['select_Sale_id'])) {
                            $number = ClassRegistry::init("Sale")->find("first", ["conditions" => ["Sale.id" => $this->request->query['select_Sale_id']]]);
                            if (!empty($number)) {
                                $numbers = $number['Sale']['sale_no'];
                            } else {
                                $numbers = "";
                            }
                        } else {
                            $numbers = "";
                        }
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "select.Sale.id", "id" => "saleId"])
                        ?>
                        <div class="has-feedback">
                            <input type="text" placeholder="Cari Nomor Penjualan Produk ..." class="form-control typeahead-ajax-transaction"  value="<?= $numbers ?>">
                            <i class="icon-search3 form-control-feedback" style="top:0px;"></i>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <label><?= __("Status Verifikasi") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_DebitInvoiceSale_verify_status_id']) ? $this->request->query['select_DebitInvoiceSale_verify_status_id'] : "", "name" => "select.DebitInvoiceSale.verify_status_id", "empty" => "", "placeholder" => "- Semua -", "options" => $verifyStatuses, "class" => "select-full", "div" => false, "label" => false]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_Sale_branch_office_id']) ? $this->request->query['select_Sale_branch_office_id'] : '', "name" => "select.Sale.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-actions text-center">
                <input type="button" value="<?= __("Reset") ?>" class="btn btn-danger btn-filter-reset">
                <input type="button" value="<?= __("Cari") ?>" class="btn btn-info btn-filter">
            </div>
        </div>
    </div>
</form>
<script>
    filterReload();
</script>
<script>
    $(document).ready(function () {
        var sale = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('sale_no'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/sales/list_lunas", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/sales/list_lunas", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        sale.clearPrefetchCache();
        sale.initialize(true);
        $('input.typeahead-ajax-transaction').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'sale',
            display: 'sale_no',
            source: sale.ttAdapter(),
            templates: {
                header: '<center><h5>Data Penjualan Produk</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Penjualan Produk : ' + context.sale_no + '<br>Total Tagihan : $ ' + context.total_invoice + '</p>';
                },
                empty: [
                    '<center><h5>Data Penjualan Produk</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction').bind('typeahead:select', function (ev, suggestion) {
            $('#saleId').val(suggestion.id);
        });
    });
</script>