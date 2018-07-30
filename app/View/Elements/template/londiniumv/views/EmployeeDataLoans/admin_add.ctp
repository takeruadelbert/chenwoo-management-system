<?php echo $this->Form->create("EmployeeDataLoan", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Data Pinjaman Pegawai") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Pinjaman Pegawai") ?></h6>
                        </div>
                        <tr>
                            <td colspan="11" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">                                            
                                            <?php
                                            echo $this->Form->label(null, __("Pegawai Pelaksana"), array("class" => "col-sm-4 control-label"));
                                            echo $this->Form->input(null, array("div" => array("class" => "col-sm-8"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Biodata.full_name"), "disabled"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(null, __("NIK Pelaksana"), array("class" => "col-sm-4 control-label"));
                                            echo $this->Form->input(null, array("div" => array("class" => "col-sm-8"), "type" => "text", "label" => false, "class" => "form-control", "value" => $this->Session->read("credential.admin.Employee.nip"), "disabled"));
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
                                                <label>Nama Pegawai</label>
                                            </div>
                                            <div class="has-feedback">
                                                <div class="col-sm-9 col-md-8">                                                
                                                    <input type="text" class="form-control typeahead-ajax-employee" placeholder="Cari Nama Pegawai ...">
                                                    <i class="icon-search3 form-control-feedback"></i>
                                                    <input type="hidden" name="data[EmployeeDataLoan][employee_id]" id="employee">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("EmployeeDataLoan.cooperative_cash_id", __("Kas Asal"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("EmployeeDataLoan.cooperative_cash_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "options" => $cooperativeCashes, "empty" => "", "placeholder" => "- Pilih Tipe Koperasi -"));
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
                                            echo $this->Form->label("EmployeeDataLoan.cooperative_loan_type_id", __("Jenis Pinjaman"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("EmployeeDataLoan.cooperative_loan_type_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Jenis Pinjaman -"));
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
                                                    <input type="text" class="form-control text-right isdecimal" name="data[EmployeeDataLoan][amount_loan]" id="amountLoan">
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
                                                <label>Bunga</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-right" id="interest" disabled>
                                                    <span class="input-group-addon"><strong>%</strong></span>
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
                                                    <input type="text" class="form-control text-right" name="data[EmployeeDataLoan][total_amount_loan]" readonly id="totalAmountLoan">
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
                                            echo $this->Form->label("EmployeeDataLoan.date", __("Tanggal Pinjam"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("EmployeeDataLoan.date", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datetime", "value" => date("Y-m-d H:i:s")));
                                            ?>
                                        </div>
                                    </div>
                                    <!--                                    <div class="col-md-6">
                                                                            <div class="form-group">                                    
                                                                                <div class="col-sm-3 col-md-4 control-label">
                                                                                    <label>Jangka Waktu Pengembalian</label>
                                                                                </div>
                                                                                <div class="col-sm-9 col-md-8">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-6">
                                                                                            <label class="radio-inline radio-success">
                                                                                                <input type="radio" name="data[EmployeeDataLoan][installment_number]" class="styled installment" checked="checked" value="3">
                                                                                                <strong>3 Bulan</strong>
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <label class="radio-inline radio-success">
                                                                                                <input type="radio" name="data[EmployeeDataLoan][installment_number]" class="styled installment" value="6">
                                                                                                <strong>6 Bulan</strong>
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <label class="radio-inline radio-success">
                                                                                                <input type="radio" name="data[EmployeeDataLoan][installment_number]" class="styled installment" value="9">
                                                                                                <strong>9 Bulan</strong>
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <label class="radio-inline radio-success">
                                                                                                <input type="radio" name="data[EmployeeDataLoan][installment_number]" class="styled installment" value="12">
                                                                                                <strong>12 Bulan</strong>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("EmployeeDataLoan.installment_number", __("Jangka Waktu Pengembalian"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            ?>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <?php
                                                    echo $this->Form->input("EmployeeDataLoan.installment_number", array("type" => "text", "div" => array("class" => ""), "label" => false, "class" => "form-control text-right installment"));
                                                    ?>
                                                    <span class="input-group-addon"><strong> Bulan</strong></span>
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
                                            <?php
                                            echo $this->Form->label("EmployeeDataLoan.acquaintance", __("Nama Anggota Keluarga Lain"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("EmployeeDataLoan.acquaintance", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("EmployeeDataLoan.assurance", __("Jaminan yang diberikan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("EmployeeDataLoan.assurance", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
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
                                    echo $this->Form->label("EmployeeDataLoan.note", __("Keterangan (Alasan)"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("EmployeeDataLoan.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <input type="hidden" name="data[EmployeeDataLoan][cooperative_loan_interest_id]" id="coopLoanInterest">
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
    $(document).ready(function () {
        /* Cari Nama Pegawai */
        var employee = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/employees/list_cooperative", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/employees/list_cooperative", true) ?>' + '?q=%QUERY',
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

        $("#amountLoan").on("change keyup", function () {
            var amountLoan = parseInt(String($(this).val()).replaceAll(".", ""));
            $.ajax({
                url: BASE_URL + "admin/cooperative_loan_interests/get_loan_interest_money/" + amountLoan,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#interest").val(data.CooperativeLoanInterest.interest);
                    $("#coopLoanInterest").val(data.CooperativeLoanInterest.id);
                    updateTotalAmount();
                }
            });
        });

        $(".installment").on("keyup change", function () {
            updateTotalAmount();
        })
    });

    /* Update the total amount */
    function updateTotalAmount() {
        var interest = $("#interest").val();
//        var totalAngsuran = parseInt($("input[name='data[EmployeeDataLoan][installment_number]']:checked").val());
        var amountLoan = String($("#amountLoan").val()).replaceAll(".", "");
        var installment = $('.installment').val();
//        if (interest != null && interest != '' && amountLoan != '' && amountLoan != null && totalAngsuran != null && totalAngsuran != '') {
        if (interest != null && interest != '' && amountLoan != '' && amountLoan != null) {
            var total = Math.floor(parseInt(amountLoan) + (parseFloat(interest * installment / 12) * parseInt(amountLoan) / 100));
            $("#totalAmountLoan").val(IDR(total));
        }
    }

    /* Function to replace All
     * Source : http://stackoverflow.com/questions/1144783/how-to-replace-all-occurrences-of-a-string-in-javascript
     *  */
    String.prototype.replaceAll = function (find, replace) {
        var str = this;
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    };
</script>