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
                        <label><?= __("Nomor PO") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "form-control tip", "type" => "text", "name" => "PurchaseOrderMaterialAdditional.po_number", "default" => isset($this->request->query['PurchaseOrderMaterialAdditional_po_number']) ? $this->request->query['PurchaseOrderMaterialAdditional_po_number'] : ""]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("Periode PO") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_PurchaseOrderMaterialAdditional_po_date']) ? $this->request->query['awal_PurchaseOrderMaterialAdditional_po_date'] : "", "name" => "awal.PurchaseOrderMaterialAdditional.po_date", "class" => "form-control datepicker", "id" => "startDate", "type" => "text", "div" => false, "label" => false, "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_PurchaseOrderMaterialAdditional_po_date']) ? $this->request->query['akhir_PurchaseOrderMaterialAdditional_po_date'] : "", "name" => "akhir.PurchaseOrderMaterialAdditional.po_date", "class" => "form-control datepicker", "id" => "endDate", "type" => "text", "div" => false, "label" => false, "placeholder" => "Akhir Periode"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Status") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.PurchaseOrderMaterialAdditional.purchase_order_material_additional_status_id", "default" => isset($this->request->query['select_PurchaseOrderMaterialAdditional_purchase_order_material_additional_status_id']) ? $this->request->query['select_PurchaseOrderMaterialAdditional_purchase_order_material_additional_status_id'] : "", "options" => $purchaseOrderMaterialAdditionalStatuses, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-6">
                        <label><?= __("Cabang Perusahaan") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.PurchaseOrderMaterialAdditional.branch_office_id", "default" => isset($this->request->query['select_PurchaseOrderMaterialAdditional_branch_office_id']) ? $this->request->query['select_PurchaseOrderMaterialAdditional_branch_office_id'] : "", "options" => $branchOffices, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label><?= __("Supplier") ?></label>
                        <?= $this->Form->input(null, ["div" => false, "label" => false, "class" => "select-full", "name" => "select.PurchaseOrderMaterialAdditional.material_additional_supplier_id", "default" => isset($this->request->query['select_PurchaseOrderMaterialAdditional_material_additional_supplier_id']) ? $this->request->query['select_PurchaseOrderMaterialAdditional_material_additional_supplier_id'] : "", "options" => $materialAdditionalSuppliers, "empty" => "", "placeholder" => "- Semua -"]) ?>
                    </div>
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $employees = "";
                            if (isset($this->request->query['PurchaseOrderMaterialAdditional_employee_id'])) {
                                $employees = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['PurchaseOrderMaterialAdditional_employee_id']
                                    ],
                                    "contain" => [
                                        "Account" => [
                                            "Biodata"
                                        ]
                                    ]
                                ]);
                            }
                            ?>
                            <label><?= __("Nama Pegawai") ?></label>
                            <input type="text" placeholder="Cari Nama Pegawai ..." class="form-control typeahead-ajax-employee" value="<?= !empty($employees) ? $employees['Account']['Biodata']['full_name'] : "" ?>">
                            <input type="hidden" name="PurchaseOrderMaterialAdditional.employee_id" id="employee">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
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
    /* Cari Nama Pegawai */
    var employee = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/employees/list", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/employees/list", true) ?>' + '?q=%QUERY',
            wildcard: '%QUERY',
        }
    });
    employee.clearPrefetchCache();
    employee.initialize(true);
    $('input.typeahead-ajax-employee').typeahead({
        hint: false,
        highlight: true
    }, {
        name: 'employee',
        display: 'full_name',
        source: employee.ttAdapter(),
        templates: {
            header: '<center><h5>Data Pegawai</h5></center><hr>',
            suggestion: function (data) {
                return '<p> Nama : ' + data.full_name + '<br/> NIP Pegawai : ' + data.nip + '<br/> Department : ' + data.department + '<br/> Position : ' + data.jabatan + '</p>';
            },
            empty: [
                '<center><h5>Data Pegawai</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
            ]
        }
    });
    $('input.typeahead-ajax-employee').bind('typeahead:select', function (ev, suggestion) {
        $("#employee").val(suggestion.id);
    });
</script>
