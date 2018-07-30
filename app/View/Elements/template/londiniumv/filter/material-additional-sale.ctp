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
                            $employee = "";
                            if (isset($this->request->query['select_MaterialAdditionalSale_employee_id'])) {
                                $employee = ClassRegistry::init("Employee")->find("first", [
                                    "conditions" => [
                                        "Employee.id" => $this->request->query['select_MaterialAdditionalSale_employee_id']
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
                            <input type="hidden" name="select.MaterialAdditionalSale.employee_id" id="employee">
                            <i class="icon-search3 form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("Periode Tanggal Penjualan") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "label" => false, "class" => "form-control datepicker", "default" => isset($this->request->query["awal_MaterialAdditionalSale_sale_dt"]) ? $this->request->query['awal_MaterialAdditionalSale_sale_dt'] : "", "name" => "awal.MaterialAdditionalSale.sale_dt", "id" => "startDate", "placeholder" => "Awal Periode"]) ?>
                    </div>
                    <div class="col-md-3">
                        <label><?= __("&nbsp;") ?></label>
                        <?= $this->Form->input(null, ["type" => "text", "div" => false, "label" => false, "class" => "form-control datepicker", "default" => isset($this->request->query["akhir_MaterialAdditionalSale_sale_dt"]) ? $this->request->query['akhir_MaterialAdditionalSale_sale_dt'] : "", "name" => "akhir.MaterialAdditionalSale.sale_dt", "id" => "endDate", "placeholder" => "Akhir Periode"]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label>Nomor Penjualan</label>
                        <?= $this->Form->input(null, ['div' => false, 'label' => false, 'class' => "form-control tip", 'name' => "MaterialAdditionalSale.no_sale", "default" => isset($this->request->query['MaterialAdditionalSale_no_sale']) ? $this->request->query['MaterialAdditionalSale_no_sale'] : "", 'placeholder' => "Nomor Penjualan ..."]) ?>
                    </div>
                    <div class="col-md-6">
                        <label>Status Penjualan</label>
                        <?= $this->Form->input(null, ['div' => false, "label" => false, "class" => 'select-full', 'name' => "MaterialAdditionalSale.validate_status_id", "default" => isset($this->request->query['MaterialAdditionalSale_validate_status_id']) ? $this->request->query['MaterialAdditionalSale_validate_status_id'] : "", "empty" => "", "placeholder" => "- Pilih Status -", 'options' => $validateStatuses]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label>Cabang Perusahaan</label>
                        <?= $this->Form->input(null, ['div' => false, "label" => false, "class" => 'select-full', 'name' => "MaterialAdditionalSale.branch_office_id", "default" => isset($this->request->query['MaterialAdditionalSale_branch_office_id']) ? $this->request->query['MaterialAdditionalSale_branch_office_id'] : "", "empty" => "", "placeholder" => "- Pilih Cabang -", 'options' => $branchOffices]) ?>
                    </div>
                    <div class="col-md-6">
                        <label>Nama Supplier</label>
                        <?= $this->Form->input(null, ['div' => false, "label" => false, "class" => "select-full", 'name' => "select.MaterialAdditionalSale.supplier_id", "default" => isset($this->request->query['select_MaterialAdditionalSale_supplier_id']) ? $this->request->query['select_MaterialAdditionalSale_supplier_id'] : "", "empty" => "", "placeholder" => "- Pilih Supplier -", 'options' => $suppliers]) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
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