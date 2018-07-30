<?php echo $this->Form->create("EmployeeDataLoanDetail", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Data Transaksi Angsuran") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>

                <div class="well block">
                    <div class="tabbable">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user4"></i>Data Pegawai</a></li>
                            <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-menu2"></i>Data Pinjaman</a></li>
                            <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file"></i>Proses Pembayaran</a></li>
                        </ul>
                        <div class="tab-content pill-content">
                            <div class="tab-pane fade in active" id="justified-pill1">
                                <div class="hidden nHolder" data-n="0"></div>
                                <div class="table-responsive">
                                    <table width="100%" class="table">
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="col-sm-3 col-md-4 control-label">
                                                                <label>Nomor Pinjaman</label>
                                                            </div>
                                                            <div class="has-feedback">
                                                                <div class="col-sm-9 col-md-8">                                                
                                                                    <input type="text" class="form-control typeahead-ajax-loan" placeholder="Cari Nomor Pinjaman / Nama Pegawai ...">
                                                                    <i class="icon-search3 form-control-feedback"></i>
                                                                    <input type="hidden" name="data[EmployeeDataLoanDetail][employee_data_loan_id]" id="dataLoan">
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
                                                            echo $this->Form->label("Dummy.name", __("Nama Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Dummy.name", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Dummy.nip", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                            echo $this->Form->label("Dummy.department", __("Departemen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Dummy.department", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Dummy.office", __("Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Dummy.office", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="justified-pill2">
                                <table width="100%" class="table">
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-sm-3 col-md-4 control-label">
                                                            <label>Tenor</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control text-right" id="totalInstallment" disabled>
                                                                <span class="input-group-addon"><strong class="paymentUnit">bulan</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-sm-3 col-md-4 control-label">
                                                            <label>Bunga (Jasa)</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control text-right" id="interest" disabled>
                                                                <span class="input-group-addon"><strong>%</strong></span>
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
                                                            <label>Jumlah Angsuran Sekarang</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control text-right" id="currentInstallment" disabled>
                                                                <span class="input-group-addon"><strong class="paymentUnit">bulan</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">                                    
                                                        <?php
                                                        echo $this->Form->label("EmployeeDataLoan.date", __("Tanggal Pinjam"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("EmployeeDataLoan.date", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                            <label>Jumlah Pinjaman</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><strong>Rp.</strong></span>
                                                                <input type="text" class="form-control text-right" id="amountLoan" disabled>
                                                                <span class="input-group-addon"><strong>,00.</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-sm-3 col-md-4 control-label">
                                                            <label>Total Pinjaman</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><strong>Rp.</strong></span>
                                                                <input type="text" class="form-control text-right" readonly id="totalAmountLoan" name="data[EmployeeDataLoanDetail][total_amount_loan]">
                                                                <span class="input-group-addon"><strong>,00.</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-sm-3 col-md-4 control-label">
                                                            <label>Sisa Pinjaman</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><strong>Rp.</strong></span>
                                                                <input type="text" class="form-control text-right" id="remainingLoan" readonly name="data[EmployeeDataLoanDetail][remaining_loan]">
                                                                <span class="input-group-addon"><strong>,00.</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="justified-pill3">
                                <table width="100%" class="table">
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("EmployeeDataLoanDetail.coop_receipt_number", __("Nomor Kwitansi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("EmployeeDataLoanDetail.coop_receipt_number", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => "AUTO GENERATE"));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">                                    
                                                        <?php
                                                        echo $this->Form->label("EmployeeDataLoanDetail.paid_date", __("Tanggal Bayar"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("EmployeeDataLoanDetail.paid_date", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "value" => date("Y-m-d")));
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
                                                        <div class="col-md-4 control-label">
                                                            <label>Biaya Angsuran</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><strong>Rp.</strong></span>
                                                                <input type="text" class="form-control text-right" readonly id="biayaAngsuranBulanIni" name="data[EmployeeDataLoanDetail][amount]">
                                                                <span class="input-group-addon"><strong>,00.</strong></span>
                                                                <span class="input-group-addon" tip><input type="checkbox" class="styled form-control" name="data[EmployeeDataLoanDetail][full_payment]" id="checkpelunasan" value="1"/>&nbsp;&nbsp;<strong>Pelunasan</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("EmployeeDataLoanDetail.cooperative_cash_id", __("Kas Tujuan"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("EmployeeDataLoanDetail.cooperative_cash_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "options" => $cooperativeCashes, "empty" => "", "placeholder" => "- Pilih Kas Koperasi -"));
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
                                                echo $this->Form->label("EmployeeDataLoanDetail.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("EmployeeDataLoanDetail.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive stn-table">
                    <div class="panel-heading" style="background:#2179cc">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Angsuran") ?></h6>
                    </div>
                    <br>
                    <table width="100%" class="table table-hover table-bordered">                        
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th><?= __("Nomor Kwitansi") ?></th>
                                <th><?= __("Nominal Pembayaran") ?></th>
                                <th><?= __("Tanggal Pembayaran") ?></th>
                            </tr>
                        </thead>
                        <tbody id="target-installment">
                            <tr id="init">
                                <td class = "text-center" colspan = "5">Tidak Ada Data</td>
                            </tr>
                        </tbody>
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
    var totalAmountLoan = false;
    var installmentNumber = false;
    var remainingLoan = false;
    $(document).ready(function () {
        /* Cari Nomor Pinjaman */
        var loan = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('receipt_loan_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/employee_data_loans/receipt_loan_number_list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/employee_data_loans/receipt_loan_number_list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        loan.clearPrefetchCache();
        loan.initialize(true);
        $('input.typeahead-ajax-loan').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'loan',
            display: 'receipt_loan_number',
            source: loan.ttAdapter(),
            templates: {
                header: '<center><h5>Data Nomor Pinjaman</h5></center><hr>',
                suggestion: function (data) {
                    return '<p>Nomor Pinjaman :' + data.receipt_loan_number + '<br>Nama : ' + data.full_name + '<br/> NIP Pegawai : ' + data.nip + '<br/> Department : ' + data.department + '<br/> Position : ' + data.jabatan + '</p>';
                },
                empty: [
                    '<center><h5>Data Nomot Pinjaman</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-loan').bind('typeahead:select', function (ev, suggestion) {
            $("#DummyName").val(suggestion.full_name);
            $("#DummyNip").val(suggestion.nip);
            $("#DummyOffice").val(suggestion.jabatan);
            $("#DummyDepartment").val(suggestion.department);
            $("#totalInstallment").val(suggestion.installment_number);
            $("#interest").val(suggestion.interest);
            $("#currentInstallment").val(suggestion.total_installment_paid);
            $("#EmployeeDataLoanDate").val(cvtTanggal(suggestion.date));
            $("#amountLoan").val(IDR(suggestion.amount_loan));
            $("#totalAmountLoan").val(IDR(suggestion.total_amount_loan));
            $("#dataLoan").val(suggestion.employee_data_loan_id);
            $("#dataKoperasi").val(suggestion.cooperative_cash_id);
            $("#remainingLoan").val(IDR(suggestion.remaining_loan));
            var totalInstallmentPaid = suggestion.total_installment_paid;
            installmentNumber = suggestion.installment_number;
            remainingLoan=suggestion.remaining_loan;
            var paidDate = suggestion.date;
            var temp = new Date(paidDate);
            var newPaidDate = temp.getFullYear() + "-" + (temp.getMonth() + 1) + "-" + temp.getDate();
            var nextMonth = parseInt(suggestion.total_installment_paid) + 1;
            if (suggestion.payment_type == "weekly") {
                $(".paymentUnit").html("minggu");
            } else {
                $(".paymentUnit").html("bulan");
            }
            totalAmountLoan = suggestion.total_amount_loan;
            if ($("#checkpelunasan").is(":checked")) {
                var paymentAmount = remainingLoan;
            } else {

                var paymentAmount = Math.ceil(totalAmountLoan / installmentNumber);
            }
            $("#biayaAngsuranBulanIni").val(IDR(paymentAmount));
            $("#target-installment").empty();
            viewInstallmentHistory(suggestion.id);
        });

        $("#checkpelunasan").on("change", function () {
            if (installmentNumber) {
                if ($("#checkpelunasan").is(":checked")) {
                    var paymentAmount = remainingLoan;
                } else {

                    var paymentAmount = Math.ceil(totalAmountLoan / installmentNumber);
                }
                $("#biayaAngsuranBulanIni").val(IDR(paymentAmount));
            }
        });
    });

    function viewInstallmentHistory(employeeDataLoanId) {
        $.ajax({
            url: BASE_URL + "employee_data_loan_details/view_installment_history/" + employeeDataLoanId,
            dataType: "JSON",
            type: "GET",
            data: {},
            success: function (data) {
                if (data != null && data != '') {
                    var i = 1;
                    var template = $("#tmpl-installment").html();
                    Mustache.parse(template);
                    $("table tr#init").remove();
                    $.each(data, function (index, item) {
                        if (item.EmployeeDataLoanDetail.paid_date) {
                            var paidDate = cvtTanggal(item.EmployeeDataLoanDetail.paid_date);
                        } else {
                            var paidDate = cvtTanggal(item.EmployeeDataLoanDetail.created);
                        }
                        var options = {
                            i: i,
                            coopReceiptNumber: item.EmployeeDataLoanDetail.coop_receipt_number,
                            nominal: IDR(item.EmployeeDataLoanDetail.amount),
                            paid_date: paidDate,
                            due_date: cvtTanggal(item.EmployeeDataLoanDetail.due_date)
                        };
                        var rendered = Mustache.render(template, options);
                        $('#target-installment').append(rendered);
                        i++;
                    });
                }
            }
        })
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-installment">
    <tr>
    <td class="text-center">{{i}}</td>
    <td class="text-center">{{coopReceiptNumber}}</td>        
    <td class="text-center">Rp. {{nominal}},-.</td>
    <td class="text-center">{{paid_date}}</td>
    </tr>
</script>