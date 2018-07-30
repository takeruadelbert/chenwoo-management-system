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
                        <label><?= __("Nomor Penjualan/PO") ?></label>
                        <?php
                        if (isset($this->request->query['select_Sale_id'])) {
                            $number = ClassRegistry::init("Sale")->find("first", ["conditions" => ["Sale.id" => $this->request->query['select_Sale_id']]]);
                            if (!empty($number)) {
                                $numbers = $number['Sale']['sale_no'] . " | " . $number['Sale']['po_number'];
                            } else {
                                $numbers = "";
                            }
                        } else {
                            $numbers = "";
                        }
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "select.Sale.id", "id" => "invoiceNumber"])
                        ?>
                        <div class="has-feedback">
                            <input type="text" placeholder="Cari Nomor Penjualan/PO..." class="form-control typeahead-ajax-transaction" value="<?= $numbers ?>">
                            <i class="icon-search3 form-control-feedback" style = "top:0px;"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Barcode") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "type" => "text", "name" => "PackageDetail.package_no", "default" => isset($this->request->query['PackageDetail_package_no']) ? $this->request->query['PackageDetail_package_no'] : "", "placeholder" => "Ketik Nomor Barcode"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label><?= __("Periode Input Package") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_PackageDetail_modified']) ? $this->request->query['awal_PackageDetail_modified'] : '', "name" => "awal.PackageDetail.modified", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false, "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label>&nbsp;</label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_PackageDetail_modified']) ? $this->request->query['akhir_PackageDetail_modified'] : '', "name" => "akhir.PackageDetail.modified", "class" => "form-control datepicker", "id" => "endDate", "div" => false, "label" => false, "placeholder" => "Akhir Periode"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_PackageDetail_branch_office_id']) ? $this->request->query['select_PackageDetail_branch_office_id'] : '', "name" => "select.PackageDetail.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Nama Produk") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_PackageDetail_product_id']) ? $this->request->query['select_PackageDetail_product_id'] : '', "name" => "select.PackageDetail.product_id", "class" => "select-full", "div" => false, "label" => false, "options" => $productLists, "empty" => "", "placeholder" => "- Semua -"]) ?>
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

    $(document).ready(function () {
        var sale = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('sale_no_po_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/sales/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/sales/list", true) ?>' + '?q=%QUERY',
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
            display: 'sale_no_po_number',
            source: sale.ttAdapter(),
            templates: {
                header: '<center><h5>Data Penjualan Produk</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Penjualan : ' + context.sale_no + '<br>Nomor PO : ' + context.po_number + '<br/>Pembeli : ' + context.buyer_name + '</p>';
                },
                empty: [
                    '<center><h5>Data Penjualan</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction').bind('typeahead:select', function (ev, suggestion) {
            $('#invoiceNumber').val(suggestion.id);
            $('#invoice').val(suggestion.total_invoice);
        });
    });
</script>