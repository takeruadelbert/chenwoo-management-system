<?php echo $this->Form->create("CashIn", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Kas Masuk Internal") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>

                <div class="well block">
                    <div class="tabbable">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user4"></i>Data Pegawai</a></li>
                            <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-file"></i>Data Kas Masuk</a></li>
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
                                                            <?php
                                                            echo $this->Form->label("Creator.Account.Biodata.full_name", __("Nama Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Creator.Account.Biodata.full_name", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Biodata.full_name")));
                                                            echo $this->Form->input("CashIn.creator_id", array("type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Creator.nip", __("NIP"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Creator.nip", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.nip")));
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
                                                            echo $this->Form->label("Creator.Department.name", __("Departemen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Creator.Department.name", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Department.name")));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Creator.Office.name", __("Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Creator.Office.name", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Office.name")));
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
                                                        <?php
                                                        echo $this->Form->label("CashIn.general_entry_type_id", __("Jenis Pemasukan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("CashIn.general_entry_type_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full earningType", "empty" => "", "placeholder" => "- Pilih Pemasukan -"));
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
                                                        echo $this->Form->label("CashIn.cash_in_number", __("Nomor Kas Masuk"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("CashIn.cash_in_number", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => "Akan Digenerate Setelah Disimpan"));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-sm-3 col-md-4 control-label label-required">
                                                            <label>Nominal</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8 rupiah">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><strong>Rp.</strong></span>                                                                
                                                                <input type="text" class="form-control text-right isdecimal nominalRupiah" name="data[CashIn][amount]" required="required">
                                                                <span class="input-group-addon"><strong>,00.</strong></span>
                                                            </div>

                                                            <input type="hidden" name="data[CashIn][currency_id]" class="currency">
                                                        </div>
                                                        <div class="col-sm-9 col-md-8 dollar">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><strong>$</strong></span>
                                                                <input type="text" class="form-control text-right isdecimaldollar nominalDollar" name="data[CashIn][amount]" required="required" disabled>                                                                
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
                                                        echo $this->Form->label("CashIn.initial_balance_id", __("Tipe Kas Yang Digunakan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("CashIn.initial_balance_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full cashType", "empty" => "", "placeholder" => "- Pilih Tipe Kas -", "disabled", "id" => "initialBalance"));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("CashIn.created_datetime", __("Tanggal"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("CashIn.created_datetime", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datetime", "value" => date("Y-m-d H:i:s")));
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>                                
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("CashIn.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("CashIn.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor fix"));
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
                <div class="block-inner text-danger">
                    <div class="form-actions text-center">
                        <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                        <input type="reset" value="Reset" class="btn btn-info">
                        <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                            <?= __("Simpan") ?>
                        </button>&nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>

<script>
    $(document).ready(function () {
        var capital_nominal = 0;
        var cash_nominal = 0;
        var total_nominal = 0;
        var currencyTypeId = 0;
        var test = 0;
        $(".dollar").hide();
        
        if($(".earningType").find(":selected").val() != "" && $(".earningType").find(":selected").val() != null) {
            $("#initialBalance").removeAttr("disabled");
        } else {
            $("#initialBalance").attr("disabled", 'disabled');
        }
        
        $(".earningType").on("change", function () {
            var generalEntryTypeId = $(this).val();
            if (generalEntryTypeId != "" && generalEntryTypeId != null) {
                $.ajax({
                    url: BASE_URL + "admin/cash_ins/get_parent/" + generalEntryTypeId,
                    type: "GET",
                    dataType: "JSON",
                    data: {},
                    success: function (data) {
                        currencyTypeId = data.GeneralEntryType.currency_id;
                        $(".currency").val(currencyTypeId);
                        if (data.GeneralEntryType.parent_id == 36) {
                            test = 36; // modal                         
                            capital_nominal = data.GeneralEntryType.initial_balance;
                            total_nominal = parseInt(capital_nominal) + parseInt(cash_nominal);
                            if (currencyTypeId == 1) {
                                $(".dollar").hide();
                                $(".rupiah").show();
                                $(".nominalRupiah").val(ic_rupiah(total_nominal));
                                $(".nominalDollar").attr("disabled", 'disabled');
                                $("[name='data[CashIn][nsr__amount]']").attr("disabled", "disabled");
                                $(".nominalRupiah").removeAttr("disabled");
                            } else {
                                $(".rupiah").hide();
                                $(".dollar").show();
                                $(".nominalDollar").val(ac_dollar(total_nominal));
                                $(".nominalRupiah").attr("disabled", "disabled");
                                $(".nominalDollar").removeAttr("disabled");
                                $("[name='data[CashIn][nsr__amount]']").removeAttr("disabled");
                            }
                        } else {
//                            test = 27; // pendapatan luar usaha
                            if (currencyTypeId == 1) {
                                $(".dollar").hide();
                                $(".rupiah").show();
                                $(".nominalDollar").attr("disabled", 'disabled');
                                $("[name='data[CashIn][nsr__amount]']").attr("disabled", "disabled");
                                $(".nominalRupiah").removeAttr("disabled");
                            } else {
                                $(".rupiah").hide();
                                $(".dollar").show();
                                $(".nominalRupiah").attr("disabled", "disabled");
                                $(".nominalDollar").removeAttr("disabled");
                                $("[name='data[CashIn][nsr__amount]']").removeAttr("disabled");
                            }
                        }
                        $("#initialBalance").removeAttr("disabled");
                    }
                });
            } else {
                $(".nominalDollar").attr("disabled", 'disabled');
                $("[name='data[CashIn][nsr__amount]']").attr("disabled", "disabled");
                $(".nominalRupiah").removeAttr("disabled");
            }
        });
        $(".cashType").on("change", function () {
            var generalEntryTypeId = $(this).val();
            var currencyTypeId2;
            $.ajax({
                url: BASE_URL + "admin/cash_ins/get_nominal_cash/" + generalEntryTypeId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    currencyTypeId2 = data.GeneralEntryType.currency_id;
                    if (currencyTypeId == currencyTypeId2) {
                        if (test == 36) {
                            cash_nominal = data.GeneralEntryType.initial_balance;
                            total_nominal = parseInt(capital_nominal) + parseInt(cash_nominal);
                            if (currencyTypeId == 1) {
                                $(".dollar").hide();
                                $(".rupiah").show();
                                $(".nominalRupiah").val(ic_rupiah(total_nominal));
                                $(".nominalDollar").attr("disabled", 'disabled');
                                $("[name='data[CashIn][nsr__amount]']").attr("disabled", "disabled");
                                $(".nominalRupiah").removeAttr("disabled");
                            } else {
                                $(".rupiah").hide();
                                $(".dollar").show();
                                $(".nominalDollar").val(ac_dollar(total_nominal));
                                $(".nominalRupiah").attr("disabled", "disabled");
                                $(".nominalDollar").removeAttr("disabled");
                                $("[name='data[CashIn][nsr__amount]']").removeAttr("disabled");
                            }
                        }
                    } else {
                        notif("warning", "Tipe Mata Uang Tidak Sama", "growl");
                        $(".cashType").select2("val", "");
                    }
                }
            });
        });
    });
</script>