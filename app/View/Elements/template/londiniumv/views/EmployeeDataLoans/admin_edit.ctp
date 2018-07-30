<?php echo $this->Form->create("EmployeeDataLoan", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Data Pinjaman Pegawai") ?>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Pinjaman Pegawai") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Nama Pegawai</label>
                                            </div>
                                            <div class="has-feedback">
                                                <div class="col-sm-9 col-md-8">
                                                    <?php
                                                    $employee = ClassRegistry::init("Employee")->find("first", [
                                                        "conditions" => [
                                                            "Employee.id" => $this->data['EmployeeDataLoan']['employee_id'],
                                                        ],
                                                        "contain" => [
                                                            "Account" => [
                                                                "Biodata"
                                                            ]
                                                        ]
                                                            ])
                                                    ?>
                                                    <input type="text" class="form-control typeahead-ajax-employee" placeholder="Cari Nama Pegawai ..." value="<?= $employee['Account']['Biodata']['full_name'] ?>" readonly>
                                                    <i class="icon-search3 form-control-feedback"></i>
                                                    <input type="hidden" name="data[EmployeeDataLoan][employee_id]" id="employee" value="<?= $this->data['EmployeeDataLoan']['employee_id'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Jenis Angsuran</label>
                                            </div>
                                            <div class="has-feedback">
                                                <?php
                                                $installment = ClassRegistry::init("CooperativeLoanInterest")->find("first", [
                                                    "conditions" => [
                                                        "CooperativeLoanInterest.id" => $this->data['EmployeeDataLoan']['cooperative_loan_interest_id']
                                                    ]
                                                ]);
                                                ?>
                                                <div class="col-sm-9 col-md-8">                                                
                                                    <input type="text" class="form-control typeahead-ajax-installment" placeholder="Cari Jenis Angsuran ..." value="<?= $installment['CooperativeLoanInterest']['installment_number'] ?>" readonly>
                                                    <i class="icon-search3 form-control-feedback"></i>
                                                    <input type="hidden" name="data[EmployeeDataLoan][cooperative_loan_interest_id]" id="installment" value="<?= $this->data['EmployeeDataLoan']['cooperative_loan_interest_id'] ?>">
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
                                            echo $this->Form->label("EmployeeDataLoan.cooperative_cash_id", __("Tipe Koperasi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("EmployeeDataLoan.cooperative_cash_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "options" => $cooperativeCashes, "empty" => "- Pilih Tipe Koperasi -", "disabled"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Total Angsuran</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-right" id="totalInstallment" disabled value="<?= !empty($installment) ? $installment['CooperativeLoanInterest']['installment_number'] : "" ?>">
                                                    <span class="input-group-addon"><strong>kali</strong></span>
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
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Bunga (Jasa)</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-right" id="interest" disabled value="<?= !empty($installment) ? $installment['CooperativeLoanInterest']['interest'] : "" ?>">
                                                    <span class="input-group-addon"><strong>%</strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Maksimal Pinjaman</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><strong>Rp.</strong></span>
                                                    <input type="text" class="form-control text-right" id="limitedAmount" disabled value="<?= !empty($installment) ? $this->Html->Rp($installment['CooperativeLoanInterest']['limited_loan']) : "" ?>">
                                                    <span class="input-group-addon"><strong>,00.</strong></span>
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
                                            echo $this->Form->label("Dummy.type", __("Tipe Pinjaman"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.type", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => "Uang"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Jumlah Pinjaman</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><strong>Rp.</strong></span>
                                                    <input type="text" class="form-control text-right isdecimal" name="data[EmployeeDataLoan][amount_loan]" id="amountLoan" value="<?= !empty($this->data['EmployeeDataLoan']['amount_loan']) ? $this->data['EmployeeDataLoan']['amount_loan'] : "" ?>" readonly>
                                                    <span class="input-group-addon"><strong>,00.</strong></span>
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
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Total Pinjaman</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><strong>Rp.</strong></span>
                                                    <input type="text" class="form-control text-right" name="data[EmployeeDataLoan][total_amount_loan]" readonly id="totalAmountLoan" value="<?= !empty($this->data['EmployeeDataLoan']['total_amount_loan']) ? $this->Html->Rp($this->data['EmployeeDataLoan']['total_amount_loan']) : "" ?>">
                                                    <span class="input-group-addon"><strong>,00.</strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">                                    
                                            <?php
                                            echo $this->Form->label("EmployeeDataLoan.date", __("Tanggal Pinjam"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("EmployeeDataLoan.date", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "disabled"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("EmployeeDataLoan.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("EmployeeDataLoan.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
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
                        <button class="btn btn-danger" data-toggle="modal" data-target="#edit" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_edit', true); ?>">
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

        /* Cari Jenis Angsuran */
        var installment = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('installment_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/cooperative_loan_interests/money_loan_list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/cooperative_loan_interests/money_loan_list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        installment.initialize();
        $('input.typeahead-ajax-installment').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'installment',
            display: 'installment_number',
            source: installment.ttAdapter(),
            templates: {
                header: '<center><h5>Data Jenis Angsuran</h5></center><hr>',
                suggestion: function (data) {
                    return '<p>Banyak Angsuran : ' + data.installment_number + ' kali <br/>Bunga (Jasa) : ' + data.interest + '% <br/> Maksimal Pinjaman : ' + RP(data.limited_loan) + '<br/> Tipe Pinjaman : ' + data.loan_type + '</p>';
                },
                empty: [
                    '<center><h5>Data Jenis Angsuran</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-installment').bind('typeahead:select', function (ev, suggestion) {
            $("#installment").val(suggestion.id);
            $("#totalInstallment").val(suggestion.installment_number);
            $("#interest").val(suggestion.interest);
            $("#limitedAmount").val(IDR(suggestion.limited_loan));
            $("#interest, #amountLoan").trigger("change");
        });

        $("#interest, #amountLoan").on("change keyup keypress", function () {
            updateTotalAmount();
        });

        /* Update the total amount */
        function updateTotalAmount() {
            var interest = $("#interest").val();
            var amountLoan = String($("#amountLoan").val()).replaceAll(".", "");
            if (interest != null && interest != '' && amountLoan != '' && amountLoan != null) {
                var total = parseInt(amountLoan) + (parseFloat(interest) * parseInt(amountLoan) / 100);
                $("#totalAmountLoan").val(total);
            }
        }

        /* Function to replace All
         * Source : http://stackoverflow.com/questions/1144783/how-to-replace-all-occurrences-of-a-string-in-javascript
         *  */
        String.prototype.replaceAll = function (find, replace) {
            var str = this;
            return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
        };
    });
</script>