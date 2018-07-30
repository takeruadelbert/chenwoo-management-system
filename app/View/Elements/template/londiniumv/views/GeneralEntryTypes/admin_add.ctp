<?php echo $this->Form->create("GeneralEntryType", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Kode Akun Buku Besar") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("GeneralEntryType.code", __("Kode"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("GeneralEntryType.code", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control iscoa", "maxlength" => 11));
                        ?>
                        <?php
                        echo $this->Form->label("GeneralEntryType.name", __("Nama"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("GeneralEntryType.name", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                        ?>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("GeneralEntryType.parent_id", __("Klasifikasi"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("GeneralEntryType.parent_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -", "options" => $generalEntryTypes));
                        ?>
                        <?php
                        echo $this->Form->label("GeneralEntryType.currency_id", __("Mata Uang"), array("class" => "col-md-2 control-label"));
                        echo $this->Form->input("GeneralEntryType.currency_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -", "id" => "currency"));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">
                        <label>Saldo Awal</label>
                    </div>
                    <div class="col-sm-4 rupiah">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Rp.</button>
                            </span>
                            <input type="text" label="false" class="form-control text-right isdecimal" name="data[GeneralEntryType][initial_balance]" id="nominalIDR">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">,00.</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 dollar">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">$</button>
                            </span>
                            <input type="text" label="false" class="form-control text-right isdecimaldollar" name="data[GeneralEntryType][initial_balance]" disabled id="nominalUSD">
                        </div>
                    </div>
                    <div class="kurs">
                        <div class="col-sm-2 control-label">
                            <label>Kurs</label>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Rp.</button>
                                </span>
                                <input type="text" label="false" class="form-control text-right isdecimal exchangeRate" name="data[GeneralEntryType][exchange_rate]" value="<?= $this->Html->getExchangeRate(1, "USD", "IDR") ?>" disabled>
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">,00.</button>
                                </span>
                            </div>
                        </div>
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
<?php echo $this->Form->end() ?>

<script>
    $(document).ready(function() {
        $(".dollar").hide();
        $(".kurs").hide();
        $("#currency").on("change", function() {
            if($(this).val() == 1) {
                $(".dollar").hide();
                $(".rupiah").show();
                $(".kurs").hide();
                $(".exchangeRate").attr("disabled", "disabled");
                $("#nominalIDR").removeAttr("disabled");
                $("#nominalUSD").attr("disabled", "disabled");
                $("[name='data[GeneralEntryType][nsr__initial_balance]']").attr("disabled", "disabled");
            } else {
                $(".dollar").show();
                $(".rupiah").hide();
                $(".kurs").show();
                $(".exchangeRate").removeAttr("disabled");
                $("#nominalIDR").attr("disabled", "disabled");
                $("#nominalUSD").removeAttr("disabled");
                $("[name='data[GeneralEntryType][nsr__initial_balance]']").removeAttr("disabled");
            }
        });
    });
</script>