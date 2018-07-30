<?php echo $this->Form->create("CooperativeItemLoanPayment", array("class" => "form-horizontal form-separate", "action" => "bayar_hutang_sembako", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Setup Pembayaran Hutang Sembako") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="well block">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("Dummy.employee_id", __("Nama Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                echo $this->Form->input("Dummy.employee_id", array("div" => false, "label" => false, "type" => "hidden"));
                                echo $this->Form->input("Dummy.employee_type_id", ['div' => false, 'label' => false, 'type' => "hidden"]);
                                echo $this->Form->input("Dummy.cooperative_item_loan_id", ['div' => false, 'label' => false, 'type' => 'hidden']);
                                ?>
                                <div class="col-sm-9 col-md-8 has-feedback">
                                    <input type="text" placeholder="Cari Nama Pegawai" class="form-control typeahead-ajax-employee">
                                    <i class="icon-search3 form-control-feedback"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("CooperativeItemLoanPayment.start_period", __("Tanggal Bayar"), array("class" => "col-sm-3 col-md-4 control-label"));
                                echo $this->Form->input("CooperativeItemLoanPayment.start_period", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text", "value" => date("Y-m-d")));
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("Dummy.total_loan", __("Total Hutang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                ?>
                                <div class="col-sm-9 col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input class="form-control text-right" type="text" disabled id="totalLoan">
                                        <span class="input-group-addon">,00.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("Dummy.remaining", __("Sisa Hutang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                ?>
                                <div class="col-sm-9 col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input class="form-control text-right" type="text" readonly id="remainingLoan" name="data[CooperativeItemLoanPaymentDetail][0][current_debt]">
                                        <span class="input-group-addon">,00.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("Dummy.amount", __("Nominal Bayar"), array("class" => "col-sm-3 col-md-4 control-label"));
                                ?>
                                <div class="col-sm-9 col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input class="form-control text-right isdecimal" type="text" name="data[CooperativeItemLoanPaymentDetail][0][amount]" id="amount">
                                        <span class="input-group-addon">,00.</span>
                                        <span class="input-group-addon" tip><input type="checkbox" class="styled form-control" id="checkpelunasan" value="1"/>&nbsp;&nbsp;<strong>Pelunasan</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("Dummy.cooperative_cash_id", __("Kas Koperasi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                echo $this->Form->input("Dummy.cooperative_cash_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "options" => $cooperativeCashes, "empty" => "", "placeholder" => "- Pilih Kas Koperasi -"));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="well block">
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
    var employee = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '<?= Router::url("/admin/employees/list_cooperative_item_loan", true) ?>',
        remote: {
            url: '<?= Router::url("/admin/employees/list_cooperative_item_loan", true) ?>' + '?q=%QUERY',
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
                return '<p> Nama : ' + data.full_name + '<br/> NIP Pegawai : ' + data.nip + '<br/> Department : ' + data.department + '<br/> Position : ' + data.jabatan + '<br>Total Hutang : ' + RP(data.total_loan) + '<br>Sisa Hutang : ' + RP(data.remaining) + '</p>';
            },
            empty: [
                "<center><h5>Data Pegawai</h5></center> <hr> <center><p>Hasil pencarian Anda tidak dapat ditemukan<p></center>",
            ],
        }
    });
    $('input.typeahead-ajax-employee').bind('typeahead:select', function (ev, data) {
        $('#DummyEmployeeId').val(data.id);
        $("#totalLoan").val(IDR(data.total_loan));
        $("#remainingLoan").val(IDR(data.remaining));
        $("#DummyEmployeeTypeId").val(data.employee_type_id);
        $("#DummyCooperativeItemLoanId").val(data.cooperative_item_loan_id);
    });
</script>
<script>
    $(document).ready(function () {
        $("#checkpelunasan").change(function () {
            if ($(this).is(":checked")) {
                if ($("#DummyEmployeeId").val() != "" && $("#DummyEmployeeId").val() != null) {
                    var remaining_loan = $("#remainingLoan").val();
                    $("#amount").val(remaining_loan);
                } else {
                    notif('warning', 'Nama Pegawai Harus Dipilih Dulu.', 'growl');
                    $("#checkpelunasan").attr("checked", "").click();
                    return false;
                }
            } else {
                $("#amount").val(0);
            }
        });
        
        $("#formSubmit").submit(function(e) {
            if($("#amount").val() == 0) {
                notif('warning', 'Nominal Bayar Tidak Boleh 0!', 'growl');
                e.preventDefault(e);
                return false;
            }
        });
    });
</script>