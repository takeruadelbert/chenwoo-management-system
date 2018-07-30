<?php echo $this->Form->create("EmployeeDataDeposit", array("class" => "form-horizontal form-separate", "action" => "add_withdrawal", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Data Penarikan Simpanan Pegawai") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>

                <div class="well block">
                    <div class="tabbable">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user4"></i>Data Pegawai</a></li>
                            <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file"></i>Data Penarikan</a></li>
                        </ul>
                        <div class="tab-content pill-content">
                            <div class="tab-pane fade in active" id="justified-pill1">
                                <div class="table-responsive">
                                    <table width="100%" class="table">
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class=" col-md-4 control-label">
                                                                <label>Nama Pegawai</label>
                                                            </div>
                                                            <div class="has-feedback">
                                                                <div class=" col-md-8">                                                
                                                                    <input type="text" class="form-control typeahead-ajax-employee" placeholder="Cari Nama Pegawai ...">
                                                                    <i class="icon-search3 form-control-feedback"></i>
                                                                    <input type="hidden" name="data[EmployeeDataDeposit][employee_id]" id="employee">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => " col-md-4 control-label"));
                                                            echo $this->Form->input("Dummy.nip", array("type" => "text", "div" => array("class" => " col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                            echo $this->Form->label("Dummy.department", __("Departemen"), array("class" => " col-md-4 control-label"));
                                                            echo $this->Form->input("Dummy.department", array("type" => "text", "div" => array("class" => " col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Dummy.office", __("Jabatan"), array("class" => " col-md-4 control-label"));
                                                            echo $this->Form->input("Dummy.office", array("type" => "text", "div" => array("class" => " col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="justified-pill3">
                                <table width="100%" class="table">
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class=" col-md-4 control-label">
                                                            <label>Saldo Simpanan</label>
                                                        </div>
                                                        <div class=" col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><strong>Rp.</strong></span>
                                                                <input type="text" class="form-control text-right" name="data[EmployeeDataDeposit][deposit_previous_balance]" disabled id="previousBalance">
                                                                <span class="input-group-addon"><strong>,00.</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("EmployeeDataDeposit.account_number", __("Nomor Rekening"), array("class" => " col-md-4 control-label"));
                                                        echo $this->Form->input("EmployeeDataDeposit.account_number", array("div" => array("class" => " col-md-8"), "label" => false, "class" => "form-control", "id" => "accountNumber", "readonly"));
                                                        ?>
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
                                                        <div class=" col-md-4 control-label">
                                                            <label>Nominal</label>
                                                        </div>
                                                        <div class=" col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><strong>Rp.</strong></span>
                                                                <input type="text" class="form-control text-right isdecimal" name="data[EmployeeDataDeposit][amount]">
                                                                <span class="input-group-addon"><strong>,00.</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">                                    
                                                        <?php
                                                        echo $this->Form->label("EmployeeDataDeposit.transaction_date", __("Waktu Penarikan"), array("class" => " col-md-4 control-label"));
                                                        echo $this->Form->input("EmployeeDataDeposit.transaction_date", array("type" => "text", "div" => array("class" => " col-md-8"), "label" => false, "class" => "form-control datetime", "value" => date("Y-m-d H:i:s"),"readonly"));
                                                        ?>
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
                                                        echo $this->Form->label("EmployeeDataDeposit.cooperative_cash_id", __("Tipe Asal"), array("class" => " col-md-4 control-label"));
                                                        echo $this->Form->input("EmployeeDataDeposit.cooperative_cash_id", array("div" => array("class" => " col-md-8"), "label" => false, "class" => "select-full koperasi", "id" => "tipeKoperasi", "options" => $cooperativeCashes, "empty" => "", "placeholder" => "- Pilih Tipe Koperasi -"));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("EmployeeDataDeposit.note", __("Keterangan"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("EmployeeDataDeposit.note", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                                        ?>
                                                    </div>
                                                </div>
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
            prefetch: '<?= Router::url("/admin/employee_data_deposits/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/employee_data_deposits/list", true) ?>' + '?q=%QUERY',
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
            $("#DummyNip").val(suggestion.nip);
            $("#DummyOffice").val(suggestion.jabatan);
            $("#DummyDepartment").val(suggestion.department);
            getBalance(suggestion.id);
        });
    });
    function getBalance(employeeId) {
        $.ajax({
            url: BASE_URL + "admin/employee_data_deposits/get_balance/" + employeeId,
            type: "GET",
            dataType: "JSON",
            data: {},
            success: function (response) {
                if (response.status == 206) {
                    if (!response.data.is_new) {
                        $("#previousBalance").val(IDR(response.data.balance));
                        $("#accountNumber").val(response.data.account_number);
                    } else {
                        alert("Data Simpanan Tidak Ditemukan");
                    }
                } else {
                    alert(response.message);
                }
            }
        })
    }
</script>