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
                        <label><?= __("Nomor PO Material Pembantu") ?></label>
                        <?php
                        if (isset($this->request->query['select_PurchaseOrderMaterialAdditional_id'])) {
                            $number = ClassRegistry::init("PurchaseOrderMaterialAdditional")->find("first", ["conditions" => ["PurchaseOrderMaterialAdditional.id" => $this->request->query['select_PurchaseOrderMaterialAdditional_id']]]);
                            if (!empty($number)) {
                                $numbers = $number['PurchaseOrderMaterialAdditional']['po_number'];
                            } else {
                                $numbers = "";
                            }
                        } else {
                            $numbers = "";
                        }
                        echo $this->Form->input(null, ["div" => false, "label" => false, "type" => "hidden", "name" => "select.PurchaseOrderMaterialAdditional.id", "id" => "transNumber"])
                        ?>
                        <div class="has-feedback">
                            <input type="text" placeholder="Silahkan Cari Nomor PO Material Pembantu ..." class="form-control typeahead-ajax-transaction"  value="<?= $numbers ?>">
                            <i class="icon-search3 form-control-feedback" style="top:0px;"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("Periode PO") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_PurchaseOrderMaterialAdditional_po_date']) ? $this->request->query['awal_PurchaseOrderMaterialAdditional_po_date'] : '', "name" => "awal.PurchaseOrderMaterialAdditional.po_date", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false, "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_PurchaseOrderMaterialAdditional_po_date']) ? $this->request->query['akhir_PurchaseOrderMaterialAdditional_po_date'] : '', "name" => "akhir.PurchaseOrderMaterialAdditional.po_date", "class" => "form-control datepicker", "id" => "endDate", "div" => false, "label" => false, "placeholder" => "Akhir Periode"]) ?>
                    </div> 
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_PurchaseOrderMaterialAdditional_branch_office_id']) ? $this->request->query['select_PurchaseOrderMaterialAdditional_branch_office_id'] : '', "name" => "select.PurchaseOrderMaterialAdditional.branch_office_id", "class" => "select-full", "div" => false, "label" => false, "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Nama Supplier") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['select_PurchaseOrderMaterialAdditional_material_additional_supplier_id']) ? $this->request->query['select_PurchaseOrderMaterialAdditional_material_additional_supplier_id'] : '', "name" => "select.PurchaseOrderMaterialAdditional.material_additional_supplier_id", "class" => "select-full", "div" => false, "label" => false, "options" => $materialAdditionalSuppliers, "empty" => "", "placeholder" => "- Semua -"]) ?>
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
        var transaction = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('po_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/purchase_order_material_additionals/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/purchase_order_material_additionals/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        transaction.clearPrefetchCache();
        transaction.initialize(true);
        $('input.typeahead-ajax-transaction').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'purhcase_order',
            display: 'po_number',
            source: transaction.ttAdapter(),
            templates: {
                header: '<center><h5>Data PO Material Pembantu</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor PO : ' + context.po_number + '<br>Total Tagihan : ' + RP(context.total) + '</p>';
                },
                empty: [
                    '<center><h5>Data PO Material Pembantu</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction').bind('typeahead:select', function (ev, suggestion) {
            $('#transNumber').val(suggestion.po_number);
            $('#invoice').val(suggestion.total);
            console.log(suggestion);
        });
    });
</script>
