<?php echo $this->Form->create("ClosingBook", array("class" => "form-horizontal form-separate", "action" => "add_tutup_buku_akhir_bulan", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Tutup Buku Akhir Bulan") ?>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Tutup Buku Akhir Bulan") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("ClosingBook.closing_datetime", __("Tanggal Tutup Buku"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("ClosingBook.closing_datetime", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datetime", "value" => date("Y-m-d H:i:s"), "readonly"));
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
                                            echo $this->Form->label("Dummy.name", __("Nama Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Biodata.full_name")));
                                            echo $this->Form->input("ClosingBook.employee_id", array("type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.jabatan", __("Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Dummy.jabatan", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Office.name")));
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
    $(document).ready(function() {
        $(".dollar").hide();
        $("#tipeKas").on("change", function() {
            var cashId = $(this).val();
            $.ajax({
                url: BASE_URL + "closing_books/get_initial_balance_data/" + cashId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function(data) {
                    if(data.InitialBalance.currency_id == 1) {
                        $(".dollar").hide();
                        $(".rupiah").show();
                        $("#previousBalance").val(IDR(data.InitialBalance.initial_amount));
                        $("#currentBalance").val(IDR(data.InitialBalance.nominal));
                    } else {
                        $(".dollar").show();
                        $(".rupiah").hide();
                        $("#previousBalance").val(data.InitialBalance.initial_amount);
                        $("#currentBalance").val(data.InitialBalance.nominal);
                    }                    
                }
            })                
        });
    });
</script>