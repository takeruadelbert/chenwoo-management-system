<?php echo $this->Form->create("RetainedEarning", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Laba Ditahan") ?>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Laba Ditahan") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label><?= __("Bulan") ?></label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <select name="data[Dummy][month]" class="select-full" id="bulan">
                                                    <option value="">- Pilih Bulan -</option>
                                                    <?php
                                                    for ($i = 1; $i <= 12; $i++) {
                                                        ?>
                                                        <option value="<?= $i ?>"><?= $this->Html->getNamaBulan($i) ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Tahun</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <select name="data[Dummy][year]" class="select-full" id="tahun">
                                                    <option value="">- Pilih Tahun -</option>
                                                    <?php
                                                    for ($i = date("Y"); $i >= 1990; $i--) {
                                                        ?>
                                                        <option value="<?= $i ?>"><?= $i ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Laba Bulan Berjalan</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <input type="text" label="false" class="form-control text-right" id="DummyProfitAndLoss" readonly>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00.</button>
                                                    </span>
                                                </div>
                                                <input type="hidden" name="data[RetainedEarning][profit_and_loss_id]" id="test">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Nominal</label>
                                            </div>
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <input type="text" label="false" class="form-control text-right isdecimal" name="data[RetainedEarning][nominal]">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00.</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("RetainedEarning.datetime", __("Tanggal"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("RetainedEarning.datetime", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datetime", "value" => date("Y-m-d H:i:s")));
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
    $(document).ready(function () {
        $("#bulan, #tahun").on("change", function () {
            var month = $("#bulan").val();
            var year = $("#tahun").val();
            if ($("#bulan").val() != "" && $("#tahun").val() != "") {
                $.ajax({
                    url: BASE_URL + "retained_earnings/get_data_profit_and_loss/" + month + "/" + year,
                    type: "GET",
                    dataType: "JSON",
                    data: {},
                    success: function (response) {
                        $("#test").val(response.ProfitAndLoss.id);
                        $("#DummyProfitAndLoss").val(IDR(response.ProfitAndLoss.nominal));
                    }
                });
            }
        });
    });
</script>