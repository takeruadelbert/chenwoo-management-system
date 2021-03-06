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
                        <div class="has-feedback">
                            <?php
                            $sale = "";
                            if (isset($this->request->query['select_Sale_id'])) {
                                $sale = ClassRegistry::init("Sale")->find("first", [
                                    "conditions" => [
                                        "Sale.id" => $this->request->query['select_Sale_id']
                                    ],
                                    "contain" => [
                                    ]
                                ]);
                            }
                            ?>
                            <label><?= __("Nomor PO") ?></label>
                            <input type="text" placeholder="Cari Nomor PO ..." class="form-control typeahead-ajax-ponumber" value="<?= !empty($sale) ? $sale['Sale']['po_number'] : "" ?>">
                            <input type="hidden" name="select.Sale.id" id="poNumber">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="has-feedback">
                            <?php
                            $employee = "";
                            if (isset($this->request->query['select_Employee_id'])) {
                                $employee = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['select_Employee_id']
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
                            <input type="text" placeholder="Cari Nama Pegawai ..." class="form-control typeahead-ajax-employee" value="<?= !empty($employee) ? $employee['Account']['Biodata']['full_name'] : "" ?>">
                            <input type="hidden" name="select.Employee.id" id="employee">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label><?= __("Periode Permintaan") ?></label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['awal_MaterialAdditionalPerContainer_created']) ? $this->request->query['awal_MaterialAdditionalPerContainer_created'] : '', "name" => "awal.MaterialAdditionalPerContainer.created", "class" => "form-control datepicker", "id" => "startDate", "div" => false, "label" => false, "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label>&nbsp;</label>
                        <?= $this->Form->input(null, ["default" => isset($this->request->query['akhir_MaterialAdditionalPerContainer_created']) ? $this->request->query['akhir_MaterialAdditionalPerContainer_created'] : '', "name" => "akhir.MaterialAdditionalPerContainer.created", "class" => "form-control datepicker", "id" => "endDate", "div" => false, "label" => false, "placeholder" => "Akhir Periode"]) ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label><?= __("Cabang Perusahaan") ?></label>
                            <?= $this->Form->input(null, ["default" => isset($this->request->query['select_MaterialAdditionalPerContainer_branch_office_id']) ? $this->request->query['select_MaterialAdditionalPerContainer_branch_office_id'] : 0, "name" => "select.MaterialAdditionalPerContainer.branch_office_id", "options" => $branchOffices, "class" => "select-full", "div" => false, "label" => false, "empty" => "", "placeholder" => "- Semua -"]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="form-actions text-center">
                    <input type="button" value="<?= __("Reset") ?>" class="btn btn-danger btn-filter-reset">
                    <input type="button" value="<?= __("Cari") ?>" class="btn btn-info btn-filter">
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    filterReload();
</script>

<script>
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
<script>
    filterReload();
    $(document).ready(function () {
        var sale = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('po_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/sales/list_po_number", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/sales/list_po_number", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        sale.clearPrefetchCache();
        sale.initialize(true);
        $('input.typeahead-ajax-ponumber').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'sale',
            display: 'po_number',
            source: sale.ttAdapter(),
            templates: {
                header: '<center><h5>Data Purchase Order</h5></center><hr>',
                suggestion: function (data) {
                    return '<p> Nomor PO : ' + data.po_number + '<br/> Buyer : ' + data.buyer_name + '</p>';
                },
                empty: [
                    '<center><h5>Data Purchase Order</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-ponumber').bind('typeahead:select', function (ev, suggestion) {
            $("#poNumber").val(suggestion.id);
        });
    });
</script>